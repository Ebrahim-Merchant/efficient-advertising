<?php
/**
 * Custom Post Types and Taxonomies
 *
 * @package Efficient_Modern
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Custom Post Type: Product
 * Only registers if WooCommerce is not active
 * Priority 999 to override any plugin registrations
 */
function efficient_modern_register_product_post_type() {
    // Don't register if WooCommerce is active (it has its own product post type)
    if ( class_exists( 'WooCommerce' ) ) {
        return;
    }
    
    // Check if product post type already exists
    $existing = post_type_exists( 'product' );
    
    $labels = array(
        'name'                  => _x( 'Products', 'Post Type General Name', 'efficient-modern' ),
        'singular_name'         => _x( 'Product', 'Post Type Singular Name', 'efficient-modern' ),
        'menu_name'             => __( 'Products', 'efficient-modern' ),
        'name_admin_bar'        => __( 'Product', 'efficient-modern' ),
        'archives'              => __( 'Product Archives', 'efficient-modern' ),
        'attributes'            => __( 'Product Attributes', 'efficient-modern' ),
        'parent_item_colon'     => __( 'Parent Product:', 'efficient-modern' ),
        'all_items'             => __( 'All Products', 'efficient-modern' ),
        'add_new_item'          => __( 'Add New Product', 'efficient-modern' ),
        'add_new'               => __( 'Add New', 'efficient-modern' ),
        'new_item'              => __( 'New Product', 'efficient-modern' ),
        'edit_item'             => __( 'Edit Product', 'efficient-modern' ),
        'update_item'           => __( 'Update Product', 'efficient-modern' ),
        'view_item'             => __( 'View Product', 'efficient-modern' ),
        'view_items'            => __( 'View Products', 'efficient-modern' ),
        'search_items'          => __( 'Search Product', 'efficient-modern' ),
        'not_found'             => __( 'Not found', 'efficient-modern' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'efficient-modern' ),
        'featured_image'        => __( 'Product Image', 'efficient-modern' ),
        'set_featured_image'    => __( 'Set product image', 'efficient-modern' ),
        'remove_featured_image' => __( 'Remove product image', 'efficient-modern' ),
        'use_featured_image'    => __( 'Use as product image', 'efficient-modern' ),
        'insert_into_item'      => __( 'Insert into product', 'efficient-modern' ),
        'uploaded_to_this_item' => __( 'Uploaded to this product', 'efficient-modern' ),
        'items_list'            => __( 'Products list', 'efficient-modern' ),
        'items_list_navigation' => __( 'Products list navigation', 'efficient-modern' ),
        'filter_items_list'     => __( 'Filter products list', 'efficient-modern' ),
    );

    $args = array(
        'label'                 => __( 'Product', 'efficient-modern' ),
        'description'           => __( 'Printing products and services', 'efficient-modern' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
        'taxonomies'            => array( 'product_category' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-products',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true, // CRITICAL: Enable archive
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rewrite'               => array( 
            'slug' => 'product',
            'with_front' => false,
            'feeds' => true,
            'pages' => true,
        ),
        '_builtin'              => false, // Not a built-in type
        '_edit_link'            => 'post.php?post=%d',
    );

    // Register or re-register to ensure archive support
    register_post_type( 'product', $args );
    
    // Force flush rewrite rules if needed
    if ( $existing && ! get_option( 'efficient_modern_product_archive_fixed' ) ) {
        flush_rewrite_rules( false );
        update_option( 'efficient_modern_product_archive_fixed', true );
    }
}
// Use higher priority to override other registrations
add_action( 'init', 'efficient_modern_register_product_post_type', 999 );

/**
 * Register Custom Taxonomy: Product Category
 * Only registers if WooCommerce is not active
 */
function efficient_modern_register_product_category_taxonomy() {
    // Don't register if WooCommerce is active (it has product_cat taxonomy)
    if ( class_exists( 'WooCommerce' ) ) {
        return;
    }
    
    $labels = array(
        'name'                       => _x( 'Product Categories', 'Taxonomy General Name', 'efficient-modern' ),
        'singular_name'              => _x( 'Product Category', 'Taxonomy Singular Name', 'efficient-modern' ),
        'menu_name'                  => __( 'Categories', 'efficient-modern' ),
        'all_items'                  => __( 'All Categories', 'efficient-modern' ),
        'parent_item'                => __( 'Parent Category', 'efficient-modern' ),
        'parent_item_colon'          => __( 'Parent Category:', 'efficient-modern' ),
        'new_item_name'              => __( 'New Category Name', 'efficient-modern' ),
        'add_new_item'               => __( 'Add New Category', 'efficient-modern' ),
        'edit_item'                  => __( 'Edit Category', 'efficient-modern' ),
        'update_item'                => __( 'Update Category', 'efficient-modern' ),
        'view_item'                  => __( 'View Category', 'efficient-modern' ),
        'separate_items_with_commas' => __( 'Separate categories with commas', 'efficient-modern' ),
        'add_or_remove_items'        => __( 'Add or remove categories', 'efficient-modern' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'efficient-modern' ),
        'popular_items'              => __( 'Popular Categories', 'efficient-modern' ),
        'search_items'               => __( 'Search Categories', 'efficient-modern' ),
        'not_found'                  => __( 'Not Found', 'efficient-modern' ),
        'no_terms'                   => __( 'No categories', 'efficient-modern' ),
        'items_list'                 => __( 'Categories list', 'efficient-modern' ),
        'items_list_navigation'      => __( 'Categories list navigation', 'efficient-modern' ),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
        'rewrite'                    => array( 'slug' => 'product-category' ),
    );

    register_taxonomy( 'product_category', array( 'product' ), $args );
}
add_action( 'init', 'efficient_modern_register_product_category_taxonomy', 0 );

/**
 * Register Custom Post Type: Home Categories (for homepage display)
 */
function efficient_modern_register_home_categories_post_type() {
    $labels = array(
        'name'                  => _x( 'Home Categories', 'Post Type General Name', 'efficient-modern' ),
        'singular_name'         => _x( 'Home Category', 'Post Type Singular Name', 'efficient-modern' ),
        'menu_name'             => __( 'Home Categories', 'efficient-modern' ),
        'name_admin_bar'        => __( 'Home Category', 'efficient-modern' ),
        'all_items'             => __( 'All Categories', 'efficient-modern' ),
        'add_new_item'          => __( 'Add New Category', 'efficient-modern' ),
        'add_new'               => __( 'Add New', 'efficient-modern' ),
        'new_item'              => __( 'New Category', 'efficient-modern' ),
        'edit_item'             => __( 'Edit Category', 'efficient-modern' ),
        'update_item'           => __( 'Update Category', 'efficient-modern' ),
        'view_item'             => __( 'View Category', 'efficient-modern' ),
        'search_items'          => __( 'Search Category', 'efficient-modern' ),
        'not_found'             => __( 'Not found', 'efficient-modern' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'efficient-modern' ),
    );

    $args = array(
        'label'                 => __( 'Home Category', 'efficient-modern' ),
        'description'           => __( 'Categories displayed on homepage', 'efficient-modern' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'thumbnail', 'custom-fields' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-category',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type( 'home_categotries', $args );
}
add_action( 'init', 'efficient_modern_register_home_categories_post_type', 0 );

/**
 * Helper function to get the correct product post type and taxonomy
 */
function efficient_modern_get_product_type() {
    return class_exists( 'WooCommerce' ) ? 'product' : 'product';
}

function efficient_modern_get_product_taxonomy() {
    return class_exists( 'WooCommerce' ) ? 'product_cat' : 'product_category';
}

function efficient_modern_get_product_archive_link() {
    if ( class_exists( 'WooCommerce' ) ) {
        return wc_get_page_permalink( 'shop' );
    }
    return get_post_type_archive_link( 'product' );
}
