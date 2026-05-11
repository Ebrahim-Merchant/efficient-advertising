<?php
/**
 * EA-PERFORMANCE-010: Quick Verification Script
 * Outputs load times for specific categories as plain text
 */

require_once dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/wp-load.php';

if ( ! defined( 'ABSPATH' ) ) {
    die( 'WordPress not loaded' );
}

// Target categories
$target_cats = [
    'Promotional & Corporate Gifts',
    'Banners & Large Format',
    'Signage',
];

echo "=== EA-PERFORMANCE-010 Quick Verification ===\n\n";

$any_timeout = false;

foreach ( $target_cats as $cat_name ) {
    $term = get_term_by( 'name', $cat_name, 'product_cat' );
    
    if ( ! $term || is_wp_error( $term ) ) {
        echo "$cat_name: NOT FOUND\n";
        continue;
    }
    
    $start = microtime( true );
    
    $query = new WP_Query([
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 24,
        'paged'          => 1,
        'tax_query'      => [[
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => $term->term_id,
        ]],
        'fields'         => 'ids',
    ]);
    
    $load_time = microtime( true ) - $start;
    $count = $query->found_posts;
    
    $status = $load_time < 3 ? 'OK' : 'TIMEOUT';
    if ( $load_time >= 3 ) $any_timeout = true;
    
    echo "$cat_name: " . number_format( $load_time, 3 ) . "s ($count products) [$status]\n";
}

echo "\n";
echo "Any category timing out? " . ( $any_timeout ? "Yes" : "No" ) . "\n";