<?php
/**
 * EA-ENCODING-FIX-016 — Comprehensive encoding cleanup
 * -------------------------------------------------------
 * Fixes all 6 corrupted Windows-1252/double-encoded UTF-8 sequences
 * across ALL live database tables (no file changes, no slug changes).
 *
 * Corruption map:
 *   ΓÇö → —   em dash
 *   ΓÇô → –   en dash
 *   ΓÇ£ → "   left double quote
 *   ΓÇ¥ → "   right double quote
 *   ΓÇÖ → '   right single quote
 *   ΓÇª → …   ellipsis
 *
 * Tables scanned:
 *   wp_posts          — post_title, post_content, post_excerpt
 *   wp_postmeta       — meta_value (serialized-safe via maybe_unserialize)
 *   wp_options        — option_value (serialized-safe via get/update_option)
 *   wp_terms          — name, description (not slug)
 *   wp_term_taxonomy  — description
 *   wp_comments       — comment_content, comment_author_email (skipped), comment_author
 * -------------------------------------------------------
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ── Corruption map ── */
$CORRUPTED = [
    "ΓÇö" => "—",   // em dash       U+2014
    "ΓÇô" => "–",   // en dash       U+2013
    "ΓÇ£" => "\u{201C}",  // left double quote
    "ΓÇ¥" => "\u{201D}",  // right double quote
    "ΓÇÖ" => "\u{2019}",  // right single quote / apostrophe
    "ΓÇª" => "…",   // ellipsis      U+2026
];
$FIND    = array_keys( $CORRUPTED );
$REPLACE = array_values( $CORRUPTED );

/* ── Report dir ── */
$REPORT_DIR  = __DIR__ . '/website-cleanup-dump/logs';
$REPORT_FILE = $REPORT_DIR . '/ea-016-encoding-report.txt';
if ( ! is_dir( $REPORT_DIR ) ) wp_mkdir_p( $REPORT_DIR );

/* ── Counters ── */
$totals  = [];
$report  = [];
$report[] = '===== EA-ENCODING-FIX-016 REPORT =====';
$report[] = 'Date: ' . date( 'Y-m-d H:i:s' );
$report[] = 'Patterns searched: ' . implode( ', ', $FIND );
$report[] = '';

global $wpdb;

/* ─── Helper: build LIKE WHERE for a column ─── */
function ea016_where( $col, $patterns, $wpdb ) {
    $parts = [];
    foreach ( $patterns as $p ) {
        $parts[] = $wpdb->prepare( "$col LIKE %s", '%' . $wpdb->esc_like( $p ) . '%' );
    }
    return implode( ' OR ', $parts );
}

/* ─── Helper: fix recursive (handles strings, arrays, objects) ─── */
function ea016_fix( $value, $find, $replace ) {
    if ( is_string( $value ) ) {
        return str_replace( $find, $replace, $value );
    }
    if ( is_array( $value ) ) {
        $out = [];
        foreach ( $value as $k => $v ) {
            $fixed_k      = is_string( $k ) ? str_replace( $find, $replace, $k ) : $k;
            $out[$fixed_k] = ea016_fix( $v, $find, $replace );
        }
        return $out;
    }
    if ( is_object( $value ) ) {
        foreach ( get_object_vars( $value ) as $k => $v ) {
            $value->$k = ea016_fix( $v, $find, $replace );
        }
        return $value;
    }
    return $value;
}

/* ─── Helper: count corruptions in a string ─── */
function ea016_count( $str, $patterns ) {
    $n = 0;
    foreach ( $patterns as $p ) {
        $n += substr_count( $str, $p );
    }
    return $n;
}

/* ════════════════════════════════════════════════════
   1. wp_posts — post_title, post_content, post_excerpt
   ════════════════════════════════════════════════════ */
$report[] = '--- 1. wp_posts ---';
echo "Scanning wp_posts...\n";

foreach ( [ 'post_title', 'post_content', 'post_excerpt' ] as $col ) {
    $where = ea016_where( $col, $FIND, $wpdb );
    // exclude auto-drafts and revisions to stay clean
    $rows = $wpdb->get_results(
        "SELECT ID, $col FROM {$wpdb->posts} WHERE ($where) AND post_status != 'auto-draft'",
        ARRAY_A
    );
    $fixed_count = 0;
    $instance_count = 0;
    foreach ( $rows as $row ) {
        $orig  = $row[$col];
        $fixed = str_replace( $FIND, $REPLACE, $orig );
        if ( $fixed !== $orig ) {
            $instances = ea016_count( $orig, $FIND );
            $instance_count += $instances;
            $result = $wpdb->update(
                $wpdb->posts,
                [ $col => $fixed ],
                [ 'ID' => (int) $row['ID'] ]
            );
            if ( $result !== false ) {
                $fixed_count++;
                $report[] = sprintf( '  FIXED  post_id:%d col:%s instances:%d', $row['ID'], $col, $instances );
            } else {
                $report[] = sprintf( '  ERROR  post_id:%d col:%s', $row['ID'], $col );
            }
        }
    }
    $totals['wp_posts'][$col] = [ 'rows' => $fixed_count, 'instances' => $instance_count ];
    echo "  $col: $fixed_count rows, $instance_count instances\n";
}

/* ════════════════════════════════════════════════════
   2. wp_postmeta — meta_value (serialized-safe)
   ════════════════════════════════════════════════════ */
$report[] = '';
$report[] = '--- 2. wp_postmeta ---';
echo "Scanning wp_postmeta...\n";

$where_meta = ea016_where( 'meta_value', $FIND, $wpdb );
$meta_rows  = $wpdb->get_results(
    "SELECT meta_id, post_id, meta_key, meta_value FROM {$wpdb->postmeta} WHERE $where_meta",
    ARRAY_A
);

$pm_fixed = 0;
$pm_instances = 0;
foreach ( $meta_rows as $row ) {
    $raw  = $row['meta_value'];
    $instances = ea016_count( $raw, $FIND );

    /* Handle serialized vs plain */
    if ( is_serialized( $raw ) ) {
        $unserialized = @unserialize( $raw );
        if ( $unserialized !== false ) {
            $fixed_data = ea016_fix( $unserialized, $FIND, $REPLACE );
            $fixed_raw  = serialize( $fixed_data );
        } else {
            /* Corrupted serialization — try plain fix and hope for the best */
            $fixed_raw = str_replace( $FIND, $REPLACE, $raw );
        }
    } else {
        $fixed_raw = str_replace( $FIND, $REPLACE, $raw );
    }

    if ( $fixed_raw !== $raw ) {
        $result = $wpdb->update(
            $wpdb->postmeta,
            [ 'meta_value' => $fixed_raw ],
            [ 'meta_id' => (int) $row['meta_id'] ]
        );
        if ( $result !== false ) {
            $pm_fixed++;
            $pm_instances += $instances;
            $report[] = sprintf( '  FIXED  meta_id:%d post_id:%d key:%s instances:%d',
                $row['meta_id'], $row['post_id'], $row['meta_key'], $instances );
        } else {
            $report[] = sprintf( '  ERROR  meta_id:%d post_id:%d key:%s',
                $row['meta_id'], $row['post_id'], $row['meta_key'] );
        }
    }
}
$totals['wp_postmeta'] = [ 'rows' => $pm_fixed, 'instances' => $pm_instances ];
echo "  meta_value: $pm_fixed rows, $pm_instances instances\n";

/* ════════════════════════════════════════════════════
   3. wp_options — option_value (get/update for serialized safety)
   ════════════════════════════════════════════════════ */
$report[] = '';
$report[] = '--- 3. wp_options ---';
echo "Scanning wp_options...\n";

/* Collect all matching option names (deduplicated) */
$matching_opts = [];
foreach ( $FIND as $p ) {
    $names = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT option_name FROM {$wpdb->options} WHERE option_value LIKE %s",
            '%' . $wpdb->esc_like( $p ) . '%'
        )
    );
    foreach ( $names as $n ) {
        $matching_opts[$n] = true;
    }
}

$opt_fixed = 0;
$opt_instances = 0;
foreach ( array_keys( $matching_opts ) as $opt_name ) {
    /* Count instances on the raw DB value first */
    $raw_val = $wpdb->get_var(
        $wpdb->prepare( "SELECT option_value FROM {$wpdb->options} WHERE option_name = %s", $opt_name )
    );
    $instances = ea016_count( (string) $raw_val, $FIND );

    /* Let WP handle serialization via get/update */
    $value = get_option( $opt_name );
    $fixed = ea016_fix( $value, $FIND, $REPLACE );

    /* Compare serialized forms */
    $orig_ser  = maybe_serialize( $value );
    $fixed_ser = maybe_serialize( $fixed );

    if ( $fixed_ser !== $orig_ser ) {
        update_option( $opt_name, $fixed );
        $opt_fixed++;
        $opt_instances += $instances;
        $report[] = "  FIXED  option:$opt_name instances:$instances";
    }
}
$totals['wp_options'] = [ 'rows' => $opt_fixed, 'instances' => $opt_instances ];
echo "  option_value: $opt_fixed options, $opt_instances instances\n";

/* ════════════════════════════════════════════════════
   4. wp_terms — name, description (NOT slug)
   ════════════════════════════════════════════════════ */
$report[] = '';
$report[] = '--- 4. wp_terms ---';
echo "Scanning wp_terms...\n";

foreach ( [ 'name', 'description' ] as $col ) {
    $where = ea016_where( $col, $FIND, $wpdb );
    $rows  = $wpdb->get_results(
        "SELECT term_id, $col FROM {$wpdb->terms} WHERE $where",
        ARRAY_A
    );
    $fixed_count = 0;
    $instance_count = 0;
    foreach ( $rows as $row ) {
        $orig  = $row[$col];
        $fixed = str_replace( $FIND, $REPLACE, $orig );
        if ( $fixed !== $orig ) {
            $instances = ea016_count( $orig, $FIND );
            $instance_count += $instances;
            $result = $wpdb->update(
                $wpdb->terms,
                [ $col => $fixed ],
                [ 'term_id' => (int) $row['term_id'] ]
            );
            if ( $result !== false ) {
                $fixed_count++;
                $report[] = sprintf( '  FIXED  term_id:%d col:%s', $row['term_id'], $col );
            }
        }
    }
    $totals['wp_terms'][$col] = [ 'rows' => $fixed_count, 'instances' => $instance_count ];
    echo "  $col: $fixed_count rows\n";
}

/* ════════════════════════════════════════════════════
   5. wp_term_taxonomy — description
   ════════════════════════════════════════════════════ */
$report[] = '';
$report[] = '--- 5. wp_term_taxonomy ---';
echo "Scanning wp_term_taxonomy...\n";

$where = ea016_where( 'description', $FIND, $wpdb );
$rows  = $wpdb->get_results(
    "SELECT term_taxonomy_id, description FROM {$wpdb->term_taxonomy} WHERE $where",
    ARRAY_A
);
$tt_fixed = 0;
foreach ( $rows as $row ) {
    $orig  = $row['description'];
    $fixed = str_replace( $FIND, $REPLACE, $orig );
    if ( $fixed !== $orig ) {
        $wpdb->update( $wpdb->term_taxonomy, [ 'description' => $fixed ], [ 'term_taxonomy_id' => (int) $row['term_taxonomy_id'] ] );
        $tt_fixed++;
        $report[] = sprintf( '  FIXED  term_taxonomy_id:%d', $row['term_taxonomy_id'] );
    }
}
$totals['wp_term_taxonomy'] = [ 'rows' => $tt_fixed ];
echo "  description: $tt_fixed rows\n";

/* ════════════════════════════════════════════════════
   6. wp_comments — comment_content, comment_author
   ════════════════════════════════════════════════════ */
$report[] = '';
$report[] = '--- 6. wp_comments ---';
echo "Scanning wp_comments...\n";

foreach ( [ 'comment_content', 'comment_author' ] as $col ) {
    $where = ea016_where( $col, $FIND, $wpdb );
    $rows  = $wpdb->get_results(
        "SELECT comment_ID, $col FROM {$wpdb->comments} WHERE $where",
        ARRAY_A
    );
    $fixed_count = 0;
    foreach ( $rows as $row ) {
        $orig  = $row[$col];
        $fixed = str_replace( $FIND, $REPLACE, $orig );
        if ( $fixed !== $orig ) {
            $wpdb->update( $wpdb->comments, [ $col => $fixed ], [ 'comment_ID' => (int) $row['comment_ID'] ] );
            $fixed_count++;
        }
    }
    $totals['wp_comments'][$col] = [ 'rows' => $fixed_count ];
    echo "  $col: $fixed_count rows\n";
}

/* ════════════════════════════════════════════════════
   7. WP Object Cache flush
   ════════════════════════════════════════════════════ */
wp_cache_flush();
$report[] = '';
$report[] = '--- Cache ---';
$report[] = '  WP object cache flushed.';
echo "WP object cache flushed.\n";

/* ════════════════════════════════════════════════════
   Summary
   ════════════════════════════════════════════════════ */
$report[] = '';
$report[] = '===== SUMMARY =====';
foreach ( $totals as $table => $cols ) {
    if ( isset( $cols['rows'] ) ) {
        /* flat */
        $r = $cols['rows'];
        $i = $cols['instances'] ?? '?';
        $report[] = "  $table: $r rows fixed, $i instances";
        echo "SUMMARY $table: $r rows fixed\n";
    } else {
        /* nested by column */
        foreach ( $cols as $col => $data ) {
            $r = $data['rows'];
            $i = $data['instances'] ?? '?';
            $report[] = "  $table.$col: $r rows fixed, $i instances";
            echo "SUMMARY $table.$col: $r rows fixed\n";
        }
    }
}

$report[] = '';
$report[] = '===== END EA-ENCODING-FIX-016 =====';

/* Write report */
$ok = file_put_contents( $REPORT_FILE, implode( "\n", $report ) . "\n" );
echo ( $ok !== false )
    ? "\nReport written: $REPORT_FILE\n"
    : "\nWARN: could not write report\n";
