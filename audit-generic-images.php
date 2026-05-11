<?php
/**
 * Audit generic/wrong images — export CSV for manual review and new SKU matching.
 * A product is "generic/wrong" if it has a thumbnail but the filename doesn't contain its SKU.
 *
 * Output columns:
 *   product_id, sku, product_name, current_image_file, sku_image_file_exists, sku_image_filename
 */

$upload_dir    = wp_upload_dir();
$sku_image_dir = $upload_dir['basedir'] . '/product-sku-images/';
$output_file   = 'C:/Users/merch/generic-image-audit.csv';

$args = [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
];

$products = get_posts( $args );

$rows    = [];
$generic = 0;

foreach ( $products as $product ) {
    $thumb_id = get_post_thumbnail_id( $product->ID );
    if ( ! $thumb_id ) continue;

    $sku           = get_post_meta( $product->ID, '_sku', true );
    $attached_file = get_attached_file( $thumb_id );
    $basename      = strtolower( basename( (string) $attached_file ) );
    $sku_lower     = strtolower( (string) $sku );

    // Skip products that already have the correct SKU image
    if ( $sku_lower && strpos( $basename, $sku_lower ) !== false ) continue;

    // This is a generic/wrong image
    $generic++;
    $sku_file = $sku_lower ? ( $sku_image_dir . $sku_lower . '.webp' ) : '';
    $sku_file_exists  = $sku_file && file_exists( $sku_file ) ? 'YES' : 'NO';
    $sku_image_filename = $sku_file_exists === 'YES' ? ( $sku_lower . '.webp' ) : '';

    $rows[] = [
        $product->ID,
        $sku,
        $product->post_title,
        $basename,
        $sku_file_exists,
        $sku_image_filename,
    ];
}

// Sort by SKU
usort( $rows, fn( $a, $b ) => strcmp( (string) $a[1], (string) $b[1] ) );

// Write CSV
$fh = fopen( $output_file, 'w' );
fputcsv( $fh, [ 'product_id', 'sku', 'product_name', 'current_image_file', 'sku_image_file_exists', 'sku_image_filename' ] );
foreach ( $rows as $row ) {
    fputcsv( $fh, $row );
}
fclose( $fh );

WP_CLI::success( "Found $generic products with generic/wrong images." );
WP_CLI::log( "CSV exported to: $output_file" );
WP_CLI::log( "" );

// Quick summary breakdown
$has_sku_file = array_filter( $rows, fn( $r ) => $r[4] === 'YES' );
$no_sku_file  = array_filter( $rows, fn( $r ) => $r[4] === 'NO' );
$no_sku_at_all = array_filter( $rows, fn( $r ) => $r[1] === '' );

WP_CLI::log( "--- Breakdown ---" );
WP_CLI::log( "SKU image file EXISTS (can fix immediately) : " . count( $has_sku_file ) );
WP_CLI::log( "SKU image file MISSING (need new image)     : " . count( $no_sku_file ) );
WP_CLI::log( "No SKU assigned at all                      : " . count( $no_sku_at_all ) );
