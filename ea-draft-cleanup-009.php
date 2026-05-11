<?php
/**
 * EA-DRAFT-CLEANUP-009 — Analyze draft products (REPORT ONLY)
 * NO product changes. NO database modifications.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Run via WP-CLI eval-file only.' );
}

global $wpdb;

$out_dir  = __DIR__ . '/website-cleanup-dump/logs';
$out_file = $out_dir . '/draft-product-analysis.csv';

if ( ! is_dir( $out_dir ) ) { mkdir( $out_dir, 0755, true ); }

// ─── Fetch all draft products (type = product only, not variations) ───────────
$drafts = $wpdb->get_results(
    "SELECT p.ID, p.post_title
     FROM {$wpdb->posts} p
     WHERE p.post_type = 'product'
       AND p.post_status = 'draft'
     ORDER BY p.ID ASC"
);

WP_CLI::log( 'Draft products found: ' . count( $drafts ) );

// ─── Build a lookup: which SKUs are currently assigned to a variation ─────────
$variation_skus = $wpdb->get_col(
    "SELECT DISTINCT pm.meta_value
     FROM {$wpdb->postmeta} pm
     JOIN {$wpdb->posts} p ON pm.post_id = p.ID
     WHERE pm.meta_key = '_sku'
       AND pm.meta_value != ''
       AND p.post_type = 'product_variation'"
);
$variation_sku_set = array_flip( $variation_skus );

// ─── Build a lookup: thumbnail_id → how many posts use it ────────────────────
$thumb_usage = $wpdb->get_results(
    "SELECT meta_value AS thumb_id, COUNT(*) AS usage_count
     FROM {$wpdb->postmeta}
     WHERE meta_key = '_thumbnail_id'
       AND meta_value != ''
     GROUP BY meta_value"
);
$thumb_usage_map = [];
foreach ( $thumb_usage as $row ) {
    $thumb_usage_map[ $row->thumb_id ] = (int) $row->usage_count;
}

// ─── Build lookup: attribute_option value → [variation_id, parent_id] ─────────
// This is the key match: draft post_title = variation attribute_option value
// WooCommerce overwrites variation post_title with parent title, so we must
// use the attribute_option postmeta which we set to the original product name.
$attr_rows = $wpdb->get_results(
    "SELECT pm.post_id AS variation_id, pm.meta_value AS option_value, p.post_parent
     FROM {$wpdb->postmeta} pm
     JOIN {$wpdb->posts} p ON pm.post_id = p.ID
     WHERE pm.meta_key = 'attribute_option'
       AND pm.meta_value != ''
       AND p.post_type = 'product_variation'"
);

// Normalise dash variants for comparison.
// Some titles were stored with double-encoded en-dash (ΓÇô = CE93 C387 C3B4)
// while attribute_option values from Excel contain plain hyphens.
function ea009_normalise( $s ) {
    // Fix double-encoded en-dash garbage sequence ΓÇô → single hyphen
    $s = str_replace( "\xce\x93\xc3\x87\xc3\xb4", '-', $s );
    // Normalise Unicode dashes to ASCII hyphen
    $s = preg_replace( '/[\x{2013}\x{2014}\x{2012}]/u', '-', $s );
    // Collapse any space-hyphen-space variants to uniform " - "
    $s = preg_replace( '/\s*-\s*/', ' - ', $s );
    return trim( $s );
}

// Allow multiple variations per title (for collision detection)
$attr_option_map        = []; // exact key   → entries
$attr_option_norm_map   = []; // normalised key → entries
foreach ( $attr_rows as $r ) {
    $entry = [ 'variation_id' => (int) $r->variation_id, 'parent_id' => (int) $r->post_parent ];
    $attr_option_map[ $r->option_value ][] = $entry;
    $norm_key = ea009_normalise( $r->option_value );
    $attr_option_norm_map[ $norm_key ][] = $entry;
}

// ─── Open CSV ─────────────────────────────────────────────────────────────────
$fh = fopen( $out_file, 'w' );
fputcsv( $fh, [
    'product_id',
    'sku',
    'product_name',
    'image_present',
    'image_unique',
    'linked_variation',
    'variation_parent_id',
    'safe_to_delete',
    'notes',
] );

$total          = count( $drafts );
$safe_count     = 0;
$review_count   = 0;

foreach ( $drafts as $draft ) {
    $post_id    = (int) $draft->ID;
    $post_title = $draft->post_title;

    // SKU (may be empty if cleared by merge scripts)
    $sku = (string) get_post_meta( $post_id, '_sku', true );

    // Thumbnail
    $thumb_id    = get_post_meta( $post_id, '_thumbnail_id', true );
    $has_thumb   = ! empty( $thumb_id );
    $usage_count = isset( $thumb_usage_map[ $thumb_id ] ) ? $thumb_usage_map[ $thumb_id ] : 0;
    // unique = only 1 post uses it (just this draft)
    $image_unique = $has_thumb && ( $usage_count <= 1 ) ? 'yes' : 'no';

    $variation_parent_id  = '';
    $linked_variation     = 'no';
    $safe                 = 'no';
    $notes                = [];

    // ── Strategy 1: SKU still present on draft and exists on a variation ───────
    if ( ! empty( $sku ) && isset( $variation_sku_set[ $sku ] ) ) {
        $var_row = $wpdb->get_row( $wpdb->prepare(
            "SELECT p.ID, p.post_parent
             FROM {$wpdb->posts} p
             JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
             WHERE pm.meta_key = '_sku' AND pm.meta_value = %s
               AND p.post_type = 'product_variation' LIMIT 1",
            $sku
        ) );
        if ( $var_row ) {
            $variation_parent_id = $var_row->post_parent;
            $linked_variation    = 'yes';
            $safe                = 'yes';
            $notes[]             = "SKU $sku confirmed on variation (parent=$variation_parent_id)";
        }
    }

    // ── Strategy 2: SKU cleared — match draft title to attribute_option value ──
    if ( $safe === 'no' ) {
        // Try exact match first, then normalised (handles en-dash/em-dash encoding diff)
        $candidates = $attr_option_map[ $post_title ]
                   ?? $attr_option_norm_map[ ea009_normalise( $post_title ) ]
                   ?? null;
        $norm_used  = ( ! isset( $attr_option_map[ $post_title ] ) && $candidates );

        if ( $candidates !== null ) {
            $matches = $candidates;
            if ( count( $matches ) === 1 ) {
                $variation_parent_id = $matches[0]['parent_id'];
                $linked_variation    = 'yes';
                $safe                = 'yes';
                $note_suffix = $norm_used ? ' (normalised dash match)' : '';
                $notes[]             = "Matched by attribute_option value (variation_id=" . $matches[0]['variation_id'] . " parent=$variation_parent_id)$note_suffix";
            } elseif ( count( $matches ) > 1 ) {
                // Multiple variations share this option value — disambiguate
                $confirmed = null;
                foreach ( $matches as $m ) {
                    $parent_status = $wpdb->get_var( $wpdb->prepare(
                        "SELECT post_status FROM {$wpdb->posts} WHERE ID=%d AND post_type='product'", $m['parent_id']
                    ) );
                    $var_sku = $wpdb->get_var( $wpdb->prepare(
                        "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id=%d AND meta_key='_sku'", $m['variation_id']
                    ) );
                    if ( $parent_status === 'publish' && ! empty( $var_sku ) ) {
                        $confirmed = $m;
                        break;
                    }
                }
                if ( $confirmed ) {
                    $variation_parent_id = $confirmed['parent_id'];
                    $linked_variation    = 'yes';
                    $safe                = 'yes';
                    $notes[]             = "Matched by attribute_option (disambiguated among " . count($matches) . " collisions, variation_id={$confirmed['variation_id']} parent=$variation_parent_id)";
                } else {
                    $linked_variation = 'no';
                    $notes[] = "Title collision: " . count( $matches ) . " variations share option value '$post_title' — manual review";
                }
            }
        }
    }

    // ── No match at all ────────────────────────────────────────────────────────
    if ( $safe === 'no' && empty( $notes ) ) {
        if ( empty( $sku ) ) {
            $notes[] = "SKU cleared, no matching attribute_option found — manual review";
        } else {
            $notes[] = "SKU '$sku' not found on any variation — manual review";
        }
    }

    if ( $image_unique === 'yes' && $safe === 'yes' ) {
        $notes[] = "Image unique to this draft — will be orphaned if deleted";
    }

    fputcsv( $fh, [
        $post_id,
        $sku,
        $post_title,
        $has_thumb ? 'yes' : 'no',
        $image_unique,
        $linked_variation,
        $variation_parent_id,
        $safe,
        implode( '; ', $notes ),
    ] );

    if ( $safe === 'yes' ) { $safe_count++; } else { $review_count++; }
}

fclose( $fh );

WP_CLI::log( '' );
WP_CLI::log( '═══════════════════════════════════════════════════════════' );
WP_CLI::log( 'EA-DRAFT-CLEANUP-009 ANALYSIS COMPLETE' );
WP_CLI::log( '═══════════════════════════════════════════════════════════' );
WP_CLI::log( "Total draft products : $total" );
WP_CLI::log( "Safe to delete       : $safe_count" );
WP_CLI::log( "Needs review         : $review_count" );
WP_CLI::log( "Report saved         : $out_file" );
