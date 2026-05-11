<?php
/*
Plugin Name: EA Catalog Mode
Description: Disables WooCommerce cart and checkout functionality to operate strictly as an inquiry/catalog site.
Version: 1.0
Author: Efficient Advt
*/

// Prevent direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Hook into init to remove the "Add to Cart" hooks globally
add_action( 'init', 'ea_disable_woocommerce_cart' );
function ea_disable_woocommerce_cart() {
    // Remove from product list pages (shop, categories)
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
    
    // Remove from single product pages
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
    remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
    remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
    remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
}

// Redirect away from Cart and Checkout pages if users somehow try to access them directly
add_action( 'template_redirect', 'ea_redirect_cart_checkout' );
function ea_redirect_cart_checkout() {
    if ( function_exists( 'is_cart' ) && function_exists( 'is_checkout' ) && function_exists( 'wc_get_page_permalink' ) ) {
        if ( is_cart() || is_checkout() ) {
            wp_redirect( wc_get_page_permalink( 'shop' ) );
            exit;
        }
    }
}
