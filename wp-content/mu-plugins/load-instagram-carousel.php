<?php
/**
 * Plugin Name: Efficient Instagram Carousel (MU)
 * Description: Auto-loads the Instagram carousel shortcode without needing activation.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$eic_plugin = WP_PLUGIN_DIR . '/efficient-instagram-carousel/efficient-instagram-carousel.php';
if ( file_exists( $eic_plugin ) ) {
    require_once $eic_plugin;
}
