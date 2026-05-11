<?php
/**
 * Template Name: EA Visual Rhythm V2
 * Prototype tool for EA-HOMEPAGE-VISUAL-RHYTHM-PREVIEW-V2
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// 1. Force the exact classes from the live homepage to ensure mirror parity
add_filter( 'body_class', function( $classes ) {
    // Add classes needed for the mirror
    $classes[] = 'home';
    $classes[] = 'page-template-default';
    $classes[] = 'ea-preview-active-v2';
    return $classes;
} );

// 2. Inject the preview CSS directly into the head for this template only
add_action( 'wp_head', function() {
    $css_url = get_template_directory_uri() . '/css/ea-homepage-visual-rhythm-preview-v2.css?v=' . time();
    echo '<link rel="stylesheet" id="ea-visual-preview-v2-css" href="' . esc_url( $css_url ) . '" type="text/css" media="all" />';
}, 20 );

// 3. Load the standard homepage renderer (using front-page.php for this theme)
require locate_template( 'front-page.php' );
