<?php
/**
 * Export a CSV of all 420 products with "generic/wrong" images.
 * "Generic" = thumbnail path does NOT start with product-sku-images/
 * Same criterion used by check-image-counts.php.
 *
 * Columns: product_id, sku, product_name, current_thumb_file, current_thumb_url, sku_image_exists_in_folder
 */

$output_file = 'C:/Users/merch/generic-products.csv';

global $wpdb;

// Get all product IDs whose thumbnail is NOT from product-sku-images/
$rows_db = $wpdb->get_results( "
    SELECT p.ID, p.post_title,
           af.meta_value  AS attached_file,
           att.ID         AS thumb_id
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
$base    = $upload['baseurl'];
$count   = 0;
$csv_rows = [];

foreach ( $rows_db as $row ) {
    $sku       = (string) get_post_meta( $row->ID, '_sku', true );
    $thumb_url = $base . '/' . $row->attached_file;
    $basename  = basename( $row->attached_file );
    $sku_lower = strtolower( $sku );
    $sku_file  = $sku_lower ? $sku_dir . $sku_lower . '.webp' : '';
    $sku_exists = ( $sku_file && file_exists( $sku_file ) ) ? 'YES' : 'NO';

    $csv_rows[] = [
        $row->ID,
        $sku,
        $row->post_title,
        $basename,
        $thumb_url,
        $sku_exists,
    ];
    $count++;
}

// Write CSV
$fh = fopen( $output_file, 'w' );
fputcsv( $fh, [ 'product_id', 'sku', 'product_name', 'current_thumb_file', 'current_thumb_url', 'sku_image_exists_in_folder' ] );
foreach ( $csv_rows as $r ) {
    fputcsv( $fh, $r );
}
fclose( $fh );

WP_CLI::success( "Exported $count products to: $output_file" );
WP_CLI::log( "Open the CSV — 'current_thumb_url' is a clickable link showing the current image." );
WP_CLI::log( "If 'sku_image_exists_in_folder' = YES, a matching .webp is already in product-sku-images/ — just needs adding to a new SKU CSV." );
WP_CLI::log( "If NO, you need to source/create a new image and place it in product-sku-images/ named by SKU (e.g. XX-001.webp)." );
