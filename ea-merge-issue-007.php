<?php
/**
 * EA-MERGE-ISSUE-007 — Analyze Groups With Issues (REPORT ONLY)
 * NO product changes. NO merges. NO deletes.
 *
 * Reads issue-007-groups.json, queries DB for product details,
 * scores completeness, and generates merge-issue-analysis.csv
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Run via WP-CLI eval-file only.' );
}

global $wpdb;

$json_file  = __DIR__ . '/website-cleanup-dump/logs/issue-007-groups.json';
$out_file   = __DIR__ . '/website-cleanup-dump/logs/merge-issue-analysis.csv';

if ( ! file_exists( $json_file ) ) {
    WP_CLI::error( "JSON not found: $json_file" );
}

$issue_groups = json_decode( file_get_contents( $json_file ), true );
if ( ! $issue_groups ) {
    WP_CLI::error( 'Failed to parse JSON.' );
}

// ─── Helper: fetch product info by SKU ────────────────────────────────────────
function ea007_get_product_info( $sku ) {
    global $wpdb;
    $row = $wpdb->get_row( $wpdb->prepare(
        "SELECT p.ID, p.post_title, p.post_status, p.post_content
         FROM {$wpdb->posts} p
         JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
         WHERE pm.meta_key = '_sku'
           AND pm.meta_value = %s
           AND p.post_type IN ('product', 'product_variation')
         LIMIT 1",
        $sku
    ) );
    if ( ! $row ) {
        return null;
    }
    $has_thumb = (bool) $wpdb->get_var( $wpdb->prepare(
        "SELECT meta_value FROM {$wpdb->postmeta}
         WHERE post_id = %d AND meta_key = '_thumbnail_id' AND meta_value != '' LIMIT 1",
        $row->ID
    ) );
    $gallery_raw = $wpdb->get_var( $wpdb->prepare(
        "SELECT meta_value FROM {$wpdb->postmeta}
         WHERE post_id = %d AND meta_key = '_product_image_gallery' LIMIT 1",
        $row->ID
    ) );
    $has_gallery = ! empty( trim( $gallery_raw, ',' ) );
    $desc_len    = strlen( strip_tags( $row->post_content ?? '' ) );

    return [
        'post_id'     => (int) $row->ID,
        'post_title'  => $row->post_title,
        'post_status' => $row->post_status,
        'has_thumb'   => $has_thumb,
        'has_gallery' => $has_gallery,
        'desc_len'    => $desc_len,
        'score'       => ( $row->post_status === 'publish' ? 2 : 0 )
                        + ( $has_thumb  ? 3 : 0 )
                        + ( $has_gallery ? 1 : 0 )
                        + ( $desc_len > 50 ? 1 : 0 ),
    ];
}

// ─── Scoring helper ───────────────────────────────────────────────────────────
function ea007_pick_best( array $skus ) {
    $scored = [];
    foreach ( $skus as $s ) {
        $info = ea007_get_product_info( $s['sku'] );
        if ( $info ) {
            $scored[] = array_merge( $s, $info );
        } else {
            $scored[] = array_merge( $s, [
                'post_id' => null, 'post_title' => null, 'post_status' => 'not_in_db',
                'has_thumb' => false, 'has_gallery' => false, 'desc_len' => 0, 'score' => -1,
            ] );
        }
    }
    usort( $scored, function( $a, $b ) {
        if ( $b['score'] !== $a['score'] ) return $b['score'] - $a['score'];
        // tiebreaker: prefer lower post_id (older product)
        if ( $a['post_id'] && $b['post_id'] ) return $a['post_id'] - $b['post_id'];
        return 0;
    } );
    return $scored;
}

// ─── Build recommendation detail string ──────────────────────────────────────
function ea007_score_summary( array $info ) {
    $parts = [];
    if ( $info['post_status'] === 'not_in_db' ) return 'NOT IN DB';
    $parts[] = 'ID:' . $info['post_id'];
    $parts[] = 'status:' . $info['post_status'];
    $parts[] = 'thumb:' . ( $info['has_thumb'] ? 'yes' : 'no' );
    $parts[] = 'gallery:' . ( $info['has_gallery'] ? 'yes' : 'no' );
    $parts[] = 'desc:' . $info['desc_len'] . 'ch';
    $parts[] = 'score:' . $info['score'];
    return implode( ' ', $parts );
}

// ─── Open CSV ─────────────────────────────────────────────────────────────────
$fh = fopen( $out_file, 'w' );
fputcsv( $fh, [
    'group_id',
    'category',
    'sub_category',
    'product_head',
    'issue_type',
    'all_skus',
    'original_candidates',
    'duplicate_skus',
    'recommended_primary_sku',
    'recommended_primary_name',
    'recommendation',
    'scoring_notes',
] );

$total_multi = 0;
$total_missing = 0;

foreach ( $issue_groups as $g ) {
    $group_id    = $g['group_id'];
    $issue_type  = $g['issue_type'];
    $originals   = $g['originals'];   // [ {sku, name}, … ]
    $duplicates  = $g['duplicates'];  // [ {sku, name, remark}, … ]

    $all_skus_list   = array_merge( $originals, $duplicates );
    $all_skus_str    = implode( '|', array_column( $all_skus_list, 'sku' ) );
    $orig_skus_str   = implode( '|', array_column( $originals, 'sku' ) );
    $dup_skus_str    = implode( '|', array_column( $duplicates, 'sku' ) );

    $scoring_notes   = [];
    $recommended_sku  = '';
    $recommended_name = '';
    $recommendation   = '';

    if ( $issue_type === 'Multiple Originals' ) {
        $total_multi++;
        // Score all originals — pick the most complete
        $ranked = ea007_pick_best( $originals );
        $best   = $ranked[0];
        $recommended_sku  = $best['sku'];
        $recommended_name = $best['name'];
        $recommendation   = sprintf(
            'Keep %s as variable product primary. Demote remaining %d original(s) to variations (treat as duplicates). Convert %d duplicate(s) to additional variations.',
            $best['sku'],
            count( $originals ) - 1,
            count( $duplicates )
        );
        foreach ( $ranked as $r ) {
            $scoring_notes[] = $r['sku'] . ' [' . ea007_score_summary( $r ) . ']';
        }

    } elseif ( $issue_type === 'Missing Original' ) {
        $total_missing++;
        // Score all duplicates — promote the best as new original
        $ranked = ea007_pick_best( $duplicates );
        $best   = $ranked[0];
        $recommended_sku  = $best['sku'];
        $recommended_name = $best['name'];
        $recommendation   = sprintf(
            'Promote %s (%s) as new variable product primary. Convert remaining %d product(s) to variations.',
            $best['sku'],
            $best['name'],
            count( $duplicates ) - 1
        );
        foreach ( $ranked as $r ) {
            $scoring_notes[] = $r['sku'] . ' [' . ea007_score_summary( $r ) . ']';
        }
    }

    fputcsv( $fh, [
        $group_id,
        $g['category'],
        $g['sub_category'],
        $g['product_head'],
        $issue_type,
        $all_skus_str,
        $orig_skus_str,
        $dup_skus_str,
        $recommended_sku,
        $recommended_name,
        $recommendation,
        implode( ' | ', $scoring_notes ),
    ] );

    WP_CLI::log( sprintf(
        "GID %2d [%s] %s → recommend: %s",
        $group_id, $issue_type, $g['product_head'], $recommended_sku
    ) );
}

fclose( $fh );

WP_CLI::log( '' );
WP_CLI::log( '═══════════════════════════════════════════════════════════' );
WP_CLI::log( 'EA-MERGE-ISSUE-007 ANALYSIS COMPLETE' );
WP_CLI::log( '═══════════════════════════════════════════════════════════' );
WP_CLI::log( sprintf( 'Total issue groups : %d', $total_multi + $total_missing ) );
WP_CLI::log( sprintf( 'Multiple Originals : %d', $total_multi ) );
WP_CLI::log( sprintf( 'Missing Original   : %d', $total_missing ) );
WP_CLI::log( "Report saved: $out_file" );
