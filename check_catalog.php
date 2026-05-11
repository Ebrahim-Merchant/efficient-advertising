<?php
// Bootstrap WordPress
require_once( dirname( __FILE__ ) . '/wp-load.php' );

$report = [];

// 1. Check Product Slugs
global $wpdb;

// Get all published products
$products = $wpdb->get_results( "
    SELECT ID, post_name, post_title 
    FROM {$wpdb->posts} 
    WHERE post_type = 'product' 
    AND post_status = 'publish'
" );

$report['total_products'] = count($products);

$slugs = [];
$redundant_slugs = [];

foreach ( $products as $p ) {
    if ( isset( $slugs[ $p->post_name ] ) ) {
        $redundant_slugs[] = [
            'slug' => $p->post_name,
            'id1'  => $slugs[ $p->post_name ]['ID'],
            'title1' => $slugs[ $p->post_name ]['title'],
            'id2'  => $p->ID,
            'title2' => $p->post_title
        ];
    } else {
        $slugs[ $p->post_name ] = [ 'ID' => $p->ID, 'title' => $p->post_title ];
    }
}

$report['redundant_slugs'] = $redundant_slugs;
$report['unique_slugs_count'] = count($slugs);

// 2. Category / Subcategory Breakdown
$categories = get_terms( [
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
] );

$cat_tree = [];
$total_categories = 0;
$total_subcategories = 0;

foreach ( $categories as $cat ) {
    if ( $cat->parent == 0 ) {
        $total_categories++;
        $cat_tree[ $cat->term_id ] = [
            'name'  => $cat->name,
            'slug'  => $cat->slug,
            'count' => $cat->count,
            'subs'  => []
        ];
    }
}

foreach ( $categories as $cat ) {
    if ( $cat->parent != 0 ) {
        $total_subcategories++;
        if ( isset( $cat_tree[ $cat->parent ] ) ) {
            $cat_tree[ $cat->parent ]['subs'][] = [
                'name'  => $cat->name,
                'slug'  => $cat->slug,
                'count' => $cat->count
            ];
        }
    }
}

$report['total_categories'] = $total_categories;
$report['total_subcategories'] = $total_subcategories;
$report['tree'] = $cat_tree;

echo json_encode($report, JSON_PRETTY_PRINT);
