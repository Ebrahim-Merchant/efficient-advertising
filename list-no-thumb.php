<?php
/**
 * List products with no thumbnail and check if a SKU image file exists for them.
 */

$args = [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'meta_query'     => [
        [
            'key'     => '_thumbnail_id',
            'compare' => 'NOT EXISTS',
        ],
    ],
];

$products = get_posts( $args );
$upload_dir = wp_upload_dir();
$sku_image_dir = $upload_dir['basedir'] . '/product-sku-images/';

WP_CLI::log( sprintf( "Products with no thumbnail: %d\n", count( $products ) ) );
WP_CLI::log( str_pad( 'Product ID', 12 ) . str_pad( 'SKU', 15 ) . str_pad( 'Product Name', 45 ) . 'Image file exists?' );
WP_CLI::log( str_repeat( '-', 90 ) );

foreach ( $products as $product ) {
    $sku  = get_post_meta( $product->ID, '_sku', true );
    $file = $sku_image_dir . strtolower( $sku ) . '.webp';
    $exists = file_exists( $file ) ? 'YES - ' . strtolower( $sku ) . '.webp' : 'NO';
    WP_CLI::log( str_pad( $product->ID, 12 ) . str_pad( $sku, 15 ) . str_pad( substr( $product->post_title, 0, 43 ), 45 ) . $exists );
}
