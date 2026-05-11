<?php
/**
 * EA-MERGE-ISSUE-008 — Merge issue groups (Multiple Originals + Missing Original)
 *
 * CRITICAL SAFETY RULES:
 *  - NO product deletions
 *  - Duplicates / extra originals → draft only
 *  - Clear SKU before assigning to variation (WooCommerce uniqueness)
 *  - Use recommended_primary_sku as parent
 *  - Full logging to report CSV
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Run via WP-CLI eval-file only.' );
}

global $wpdb;

$json_file   = __DIR__ . '/website-cleanup-dump/logs/issue-007-groups.json';
$csv_file    = __DIR__ . '/website-cleanup-dump/logs/merge-issue-analysis.csv';
$report_file = __DIR__ . '/website-cleanup-dump/logs/merge-issue-008-report.csv';

if ( ! file_exists( $json_file ) ) { WP_CLI::error( "JSON not found: $json_file" ); }
if ( ! file_exists( $csv_file )  ) { WP_CLI::error( "CSV not found: $csv_file" ); }

$issue_groups = json_decode( file_get_contents( $json_file ), true );
if ( ! $issue_groups ) { WP_CLI::error( 'Failed to parse issue-007-groups.json.' ); }

// ─── Load recommended_primary_sku from CSV ────────────────────────────────────
$csv_data = [];
$fh       = fopen( $csv_file, 'r' );
$headers  = fgetcsv( $fh );
$h        = array_flip( $headers );
while ( ( $row = fgetcsv( $fh ) ) !== false ) {
    $gid = (int) $row[ $h['group_id'] ];
    $csv_data[ $gid ] = [
        'recommended_primary_sku'  => trim( $row[ $h['recommended_primary_sku'] ] ),
        'recommended_primary_name' => trim( $row[ $h['recommended_primary_name'] ] ),
        'issue_type'               => trim( $row[ $h['issue_type'] ] ),
        'product_head'             => trim( $row[ $h['product_head'] ] ),
    ];
}
fclose( $fh );

// ─── Helpers ──────────────────────────────────────────────────────────────────
function ea008_get_product_by_sku( $sku ) {
    global $wpdb;
    return $wpdb->get_row( $wpdb->prepare(
        "SELECT p.ID, p.post_title, p.post_status, p.post_type
         FROM {$wpdb->posts} p
         JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
         WHERE pm.meta_key = '_sku'
           AND pm.meta_value = %s
           AND p.post_type IN ('product','product_variation')
         LIMIT 1",
        $sku
    ) );
}

function ea008_get_price( $post_id ) {
    $price = get_post_meta( $post_id, '_regular_price', true );
    if ( empty( $price ) ) {
        $price = get_post_meta( $post_id, '_price', true );
    }
    return $price;
}

// ─── Open report CSV ──────────────────────────────────────────────────────────
$fh_report = fopen( $report_file, 'w' );
fputcsv( $fh_report, [
    'group_id', 'parent_sku', 'variation_count', 'drafted_products', 'status', 'issues',
] );

$total_variations = 0;
$total_drafted    = 0;
$total_completed  = 0;
$total_skipped    = 0;

// ─── Main loop ────────────────────────────────────────────────────────────────
foreach ( $issue_groups as $g ) {
    $gid        = (int) $g['group_id'];
    $issue_type = $g['issue_type'];

    if ( ! isset( $csv_data[ $gid ] ) ) {
        WP_CLI::warning( "GID $gid not found in analysis CSV — skipping." );
        continue;
    }

    $parent_sku   = $csv_data[ $gid ]['recommended_primary_sku'];
    $product_head = $csv_data[ $gid ]['product_head'];

    WP_CLI::log( "\n────────────────────────────────────────────────────────" );
    WP_CLI::log( "GID $gid [$issue_type] $product_head | parent: $parent_sku" );

    // Build all SKU+name pairs for this group
    $all_in_group = array_merge( $g['originals'], $g['duplicates'] );

    // ── GID 22 special case: only 1 product in group ──────────────────────────
    if ( count( $all_in_group ) <= 1 ) {
        WP_CLI::log( "  SKIP: Single product in group — no merge needed." );
        fputcsv( $fh_report, [ $gid, $parent_sku, 0, 0, 'SKIPPED', 'Single product — no merge needed' ] );
        $total_skipped++;
        continue;
    }

    // ── Get parent product ────────────────────────────────────────────────────
    $parent_row = ea008_get_product_by_sku( $parent_sku );
    if ( ! $parent_row ) {
        WP_CLI::warning( "  STOP: Parent product not found for SKU $parent_sku" );
        fputcsv( $fh_report, [ $gid, $parent_sku, 0, 0, 'FAILED', "Parent SKU not found in DB: $parent_sku" ] );
        continue;
    }
    $parent_id = (int) $parent_row->ID;

    // ── Skip if already converted ────────────────────────────────────────────
    $current_type = WC_Product_Factory::get_product_type( $parent_id );
    if ( $current_type === 'variable' ) {
        WP_CLI::log( "  SKIP: GID $gid parent (post_id $parent_id) is already variable." );
        fputcsv( $fh_report, [ $gid, $parent_sku, 0, 0, 'SKIPPED', 'Already variable' ] );
        $total_skipped++;
        continue;
    }

    // ── Build variant list = everything except parent ────────────────────────
    $variants = array_values( array_filter( $all_in_group, fn( $s ) => $s['sku'] !== $parent_sku ) );

    // ── Pre-flight: verify all variant SKUs exist in DB ──────────────────────
    $preflight_ok = true;
    foreach ( $variants as $v ) {
        if ( ! ea008_get_product_by_sku( $v['sku'] ) ) {
            WP_CLI::warning( "  STOP (preflight): Variant SKU not found in DB: " . $v['sku'] );
            fputcsv( $fh_report, [ $gid, $parent_sku, 0, 0, 'FAILED', "Preflight: SKU not in DB: " . $v['sku'] ] );
            $preflight_ok = false;
            break;
        }
    }
    if ( ! $preflight_ok ) { continue; }

    WP_CLI::log( "  Parent post_id : $parent_id" );
    WP_CLI::log( "  Variants       : " . count( $variants ) );

    // ── Build all option values for attribute ─────────────────────────────────
    $all_option_values = [ $parent_row->post_title ];
    foreach ( $variants as $v ) {
        $vrow = ea008_get_product_by_sku( $v['sku'] );
        $all_option_values[] = $vrow ? $vrow->post_title : $v['name'];
    }
    $all_option_values = array_values( array_unique( $all_option_values ) );

    // ── Convert parent to variable ────────────────────────────────────────────
    wp_set_object_terms( $parent_id, 'variable', 'product_type' );

    // ── Set product attribute "Option" on parent ──────────────────────────────
    $attr_slug = 'option';
    update_post_meta( $parent_id, '_product_attributes', [
        $attr_slug => [
            'name'         => 'Option',
            'value'        => implode( ' | ', $all_option_values ),
            'position'     => 0,
            'is_visible'   => 1,
            'is_variation' => 1,
            'is_taxonomy'  => 0,
        ],
    ] );

    $variation_count = 0;
    $drafted_count   = 0;
    $had_error       = false;
    $report_issues   = [];

    // ── Process each variant ──────────────────────────────────────────────────
    foreach ( $variants as $v ) {
        $vsku = $v['sku'];

        $vrow = ea008_get_product_by_sku( $vsku );
        if ( ! $vrow ) {
            $msg = "Variant SKU not found in DB: $vsku";
            WP_CLI::warning( "  STOP: $msg" );
            $report_issues[] = $msg;
            $had_error = true;
            break;
        }
        $vpost_id     = (int) $vrow->ID;
        $option_value = $vrow->post_title;
        $price        = ea008_get_price( $vpost_id );

        // Step 1: Clear SKU from the variant product (WC uniqueness requirement)
        update_post_meta( $vpost_id, '_sku', '' );
        WP_CLI::log( "  Cleared SKU $vsku from post_id $vpost_id" );

        // Step 2: Create variation post under parent
        $variation_id = wp_insert_post( [
            'post_title'  => $option_value,
            'post_type'   => 'product_variation',
            'post_status' => 'publish',
            'post_parent' => $parent_id,
        ] );

        if ( is_wp_error( $variation_id ) ) {
            $msg = "Failed to create variation for $vsku: " . $variation_id->get_error_message();
            WP_CLI::warning( "  STOP: $msg" );
            $report_issues[] = $msg;
            $had_error = true;
            break;
        }

        // Step 3: Assign SKU, attribute value, price, stock to variation
        update_post_meta( $variation_id, '_sku',            $vsku );
        update_post_meta( $variation_id, 'attribute_' . $attr_slug, $option_value );
        update_post_meta( $variation_id, '_manage_stock', 'no' );
        update_post_meta( $variation_id, '_stock_status', 'instock' );
        if ( ! empty( $price ) ) {
            update_post_meta( $variation_id, '_price',         $price );
            update_post_meta( $variation_id, '_regular_price', $price );
        }

        WP_CLI::log( "  Created variation $variation_id → SKU $vsku | option: $option_value" );
        $variation_count++;

        // Step 4: Set variant product to draft (no delete)
        wp_update_post( [ 'ID' => $vpost_id, 'post_status' => 'draft' ] );
        WP_CLI::log( "  Drafted post_id $vpost_id ($vsku)" );
        $drafted_count++;
    }

    if ( $had_error ) {
        fputcsv( $fh_report, [
            $gid, $parent_sku, $variation_count, $drafted_count, 'FAILED',
            implode( '; ', $report_issues ),
        ] );
        continue;
    }

    // ── Sync variable product & clear transients ──────────────────────────────
    $wc_parent = wc_get_product( $parent_id );
    if ( $wc_parent instanceof WC_Product_Variable ) {
        WC_Product_Variable::sync( $parent_id );
        wc_delete_product_transients( $parent_id );
    }

    WP_CLI::log( "  GID $gid COMPLETED: $variation_count variations, $drafted_count drafted." );
    fputcsv( $fh_report, [ $gid, $parent_sku, $variation_count, $drafted_count, 'COMPLETED', '' ] );

    $total_variations += $variation_count;
    $total_drafted    += $drafted_count;
    $total_completed++;
}

fclose( $fh_report );

WP_CLI::log( '' );
WP_CLI::log( '═══════════════════════════════════════════════════════════' );
WP_CLI::log( 'EA-MERGE-ISSUE-008 COMPLETE' );
WP_CLI::log( '═══════════════════════════════════════════════════════════' );
WP_CLI::log( "Completed  : $total_completed" );
WP_CLI::log( "Skipped    : $total_skipped" );
WP_CLI::log( "Variations : $total_variations" );
WP_CLI::log( "Drafted    : $total_drafted" );
WP_CLI::log( "Report     : $report_file" );
