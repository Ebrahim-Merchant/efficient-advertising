<?php
/**
 * Theme Customizer
 *
 * @package Efficient_Modern
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add postMessage support for site title and description
 */
function efficient_modern_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'efficient_modern_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'efficient_modern_customize_partial_blogdescription',
            )
        );
    }
}
add_action( 'customize_register', 'efficient_modern_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 */
function efficient_modern_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function efficient_modern_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function efficient_modern_customize_preview_js() {
    wp_enqueue_script( 
        'efficient-modern-customizer', 
        get_template_directory_uri() . '/assets/js/customizer.js', 
        array( 'customize-preview' ), 
        EFFICIENT_MODERN_VERSION, 
        true 
    );
}
add_action( 'customize_preview_init', 'efficient_modern_customize_preview_js' );
