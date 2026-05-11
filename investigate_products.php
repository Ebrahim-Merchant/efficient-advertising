<?php
// Bootstrap WordPress
require_once( dirname( __FILE__ ) . '/wp-load.php' );

global $wpdb;
$report = [];

// 1. Count products by status
$status_counts = $wpdb->get_results( "
    SELECT post_status, COUNT(*) as count 
    FROM {$wpdb->posts} 
    WHERE post_type = 'product' 
    GROUP BY post_status
", ARRAY_A );

$report['product_counts_by_status'] = $status_counts;

// 2. Count product variations
$variation_counts = $wpdb->get_var( "
    SELECT COUNT(*) 
    FROM {$wpdb->posts} 
    WHERE post_type = 'product_variation'
" );

$report['total_product_variations'] = $variation_counts;

// 3. Check for any other custom post types that might be confused with products
$post_types = $wpdb->get_results( "
    SELECT post_type, COUNT(*) as count 
    FROM {$wpdb->posts} 
    WHERE post_type IN ('product', 'product_variation', 'post', 'page', 'attachment')
    GROUP BY post_type
", ARRAY_A );

$report['overall_post_type_counts'] = $post_types;

// 4. Count unique product URLs (slugs) including drafts
$slugs = $wpdb->get_var( "
    SELECT COUNT(DISTINCT post_name) 
    FROM {$wpdb->posts} 
    WHERE post_type = 'product' 
    AND post_name != ''
" );

$report['unique_product_slugs_in_db'] = $slugs;

echo json_encode($report, JSON_PRETTY_PRINT);
