<?php
/**
 * Generate sku_matches_v2.csv — SKU → filename mappings for the 355 products
 * that already have a matching .webp in product-sku-images/ but weren't in the
 * original sku_matches.csv (their thumbnail is still a generic old image).
 *
 * Output: C:/Users/merch/sku_matches_v2.csv  (product_id, sku, filename)
 */

$output_file = 'C:/Users/merch/sku_matches_v2.csv';

global $wpdb;

// Products whose thumbnail is NOT from product-sku-images/ — same as check-image-counts.php
$rows_db = $wpdb->get_results( "
    SELECT p.ID
    FROM {$wpdb->posts} p
    INNER JOIN {$wpdb->postmeta} tm  ON tm.post_id  = p.ID    AND tm.meta_key  = '_thumbnail_id' AND tm.meta_value > 0
    INNER JOIN {$wpdb->posts}    att ON att.ID       = tm.meta_value
    INNER JOIN {$wpdb->postmeta} af  ON af.post_id   = att.ID  AND af.meta_key  = '_wp_attached_file'
                                                                AND af.meta_value NOT LIKE 'product-sku-images/%'
    WHERE p.post_type = 'product'
    ORDER BY p.ID ASC
" );

$upload  = wp_upload_dir();
$sku_dir = $upload['basedir'] . '/product-sku-images/';

$found    = 0;
$skipped  = 0;
$csv_rows = [];

foreach ( $rows_db as $row ) {
    $sku = (string) get_post_meta( $row->ID, '_sku', true );
    if ( ! $sku ) { $skipped++; continue; }

    $filename = strtolower( $sku ) . '.webp';
    $filepath = $sku_dir . $filename;

    if ( ! file_exists( $filepath ) ) { $skipped++; continue; }

    $csv_rows[] = [ $row->ID, $sku, $filename ];
    $found++;
}

$fh = fopen( $output_file, 'w' );
fputcsv( $fh, [ 'product_id', 'sku', 'filename' ] );
foreach ( $csv_rows as $r ) {
    fputcsv( $fh, $r );
}
fclose( $fh );

WP_CLI::success( "Exported $found matchable products to: $output_file" );
WP_CLI::log( "Skipped (no SKU or no image file): $skipped" );
