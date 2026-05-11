<?php
/**
 * Template Name: EA Visual Rhythm Preview
 * Prototype tool for EA-HOMEPAGE-VISUAL-RHYTHM-PREVIEW-001
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// 1. Force the preview class on the body
add_filter( 'body_class', function( $classes ) {
    $classes[] = 'ea-preview-active';
    return $classes;
} );

// 2. Inject the preview CSS directly into the head for this template only
add_action( 'wp_head', function() {
    $css_url = get_template_directory_uri() . '/css/ea-homepage-visual-rhythm-preview.css?v=' . time();
    echo '<link rel="stylesheet" id="ea-visual-preview-css" href="' . esc_url( $css_url ) . '" type="text/css" media="all" />';
}, 20 );

// 3. Load the standard homepage renderer
require locate_template( 'index.php' );
