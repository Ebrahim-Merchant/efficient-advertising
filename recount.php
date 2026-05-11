<?php
// Recount WooCommerce Terms
require_once( __DIR__ . '/wp-load.php' );

// Make sure we have admin privileges to bypass restrictions
wp_set_current_user( 1 );

// Get all product categories
$terms = get_terms( array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
    'fields'     => 'ids',
) );

if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
    wp_update_term_count_now( $terms, 'product_cat' );
    
    // Clear WooCommerce transients
    wc_delete_product_transients();
    delete_transient( 'wc_term_counts' );
    
    echo "Successfully recounted " . count($terms) . " product categories.\n";
} else {
    echo "Error fetching categories.\n";
}

// Recount tags just in case
$tags = get_terms( array(
    'taxonomy'   => 'product_tag',
    'hide_empty' => false,
    'fields'     => 'ids',
) );

if ( ! is_wp_error( $tags ) && ! empty( $tags ) ) {
    wp_update_term_count_now( $tags, 'product_tag' );
    echo "Successfully recounted " . count($tags) . " product tags.\n";
}

echo "Done.";
