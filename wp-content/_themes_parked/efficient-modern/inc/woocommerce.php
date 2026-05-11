<?php
/**
 * WooCommerce Compatibility File
 *
 * @package Efficient_Modern
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Remove default WooCommerce wrappers
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Add custom WooCommerce wrappers
 */
add_action( 'woocommerce_before_main_content', 'efficient_modern_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'efficient_modern_wrapper_end', 10 );

function efficient_modern_wrapper_start() {
    echo '<div id="primary" class="content-area"><main id="main" class="site-main woocommerce-main">';
}

function efficient_modern_wrapper_end() {
    echo '</main></div>';
}

/**
 * Disable default WooCommerce styles
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Change number of products per page
 */
add_filter( 'loop_shop_per_page', 'efficient_modern_products_per_page', 20 );
function efficient_modern_products_per_page( $cols ) {
    return 12;
}

/**
 * Change number of related products
 */
add_filter( 'woocommerce_output_related_products_args', 'efficient_modern_related_products_args', 20 );
function efficient_modern_related_products_args( $args ) {
    $args['posts_per_page'] = 4;
    $args['columns'] = 4;
    return $args;
}

/**
 * Add cart icon to header with count
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'efficient_modern_cart_count_fragments' );
function efficient_modern_cart_count_fragments( $fragments ) {
    ob_start();
    $cart_count = WC()->cart->get_cart_contents_count();
    ?>
    <span class="cart-count"><?php echo esc_html( $cart_count ); ?></span>
    <?php
    $fragments['.cart-count'] = ob_get_clean();
    return $fragments;
}

/**
 * Customize WooCommerce breadcrumbs
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'efficient_modern_woocommerce_breadcrumbs' );
function efficient_modern_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => ' › ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb breadcrumbs">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => _x( 'Home', 'breadcrumb', 'efficient-modern' ),
    );
}

/**
 * Custom WooCommerce product columns
 */
add_filter( 'loop_shop_columns', 'efficient_modern_loop_columns', 999 );
function efficient_modern_loop_columns() {
    return 4; // 4 products per row
}

/**
 * Modify WooCommerce pagination
 */
add_filter( 'woocommerce_pagination_args', 'efficient_modern_woocommerce_pagination' );
function efficient_modern_woocommerce_pagination( $args ) {
    $args['prev_text'] = '<i class="fa-solid fa-chevron-left"></i> ' . __( 'Previous', 'efficient-modern' );
    $args['next_text'] = __( 'Next', 'efficient-modern' ) . ' <i class="fa-solid fa-chevron-right"></i>';
    return $args;
}
