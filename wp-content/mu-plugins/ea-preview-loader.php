<?php
/**
 * EA Preview Mode Loader
 *
 * Supports two preview modes via URL parameter:
 *   ?ea_preview=light       → loads ea-preview-light-ui.css             (full light theme)
 *   ?ea_preview=warm-bg     → loads ea-preview-warm-bg.css              (background-only warm feel)
 *   ?ea_preview=light-comp  → loads ea-preview-03-light-components.css  (warm bg + light cards)
 *   ?ea_preview=faq         → loads ea-preview-faq.css                  (warm bg + light cards + premium FAQ)
 *   ?ea_preview=alignment   → loads ea-preview-05-alignment.css         (full alignment review: home+cat+product)
 *   ?ea_preview=header      → loads ea-preview-06-header.css            (standardised dark header: all pages)
 *
 * Affects homepage, product_cat archive pages, and single product pages.
 * Does NOT touch any existing theme file, plugin, or stylesheet.
 * To completely remove preview: delete this file only.
 *
 * Preview URLs:
 *   Homepage desktop : http://newefficientadvertising09042026.local/?ea_preview=warm-bg
 *   Category page    : http://newefficientadvertising09042026.local/product-category/signage/?ea_preview=warm-bg
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Strategy: inject via wp_footer at priority 999.
 * index.php and taxonomy-product_cat.php load their CSS as <link> tags inside
 * the <body> — AFTER wp_head(). wp_enqueue_style() would load in <head> and
 * be overridden by those body-loaded stylesheets.
 * By hooking wp_footer at priority 999 we output AFTER every body <link> tag
 * and after all inline styles, so our overrides win in source order.
 */
add_action( 'wp_footer', function () {
    // Safety: only activate when preview parameter is explicitly present
    if ( ! isset( $_GET['ea_preview'] ) ) {
        return;
    }
    $mode = sanitize_key( $_GET['ea_preview'] );

    // Scope: homepage, category archives, single product pages, and all other pages
    // (header preview needs to cover all page types)
    $is_header_mode = ( $mode === 'header' );
    if ( ! $is_header_mode ) {
        if ( ! is_front_page() && ! is_home() && ! is_tax( 'product_cat' ) && ! is_singular( 'product' ) ) {
            return;
        }
    }

    // Map mode → CSS file
    $allowed = [
        'light'      => 'ea-preview-light-ui.css',
        'warm-bg'    => 'ea-preview-warm-bg.css',
        'light-comp' => 'ea-preview-03-light-components.css',
        'faq'        => 'ea-preview-faq.css',
        'alignment'  => 'ea-preview-05-alignment.css',
        'header'     => 'ea-preview-06-header.css',
    ];
    if ( ! array_key_exists( $mode, $allowed ) ) {
        return;
    }
    $filename = $allowed[ $mode ];
    $css_id   = 'ea-preview-' . $mode . '-css';
    $css_path = get_stylesheet_directory()     . '/css/' . $filename;
    $css_uri  = get_stylesheet_directory_uri() . '/css/' . $filename;
    $version  = file_exists( $css_path ) ? filemtime( $css_path ) : '1.0';

    // Output a <link> tag right before </body> — loads AFTER all body-embedded CSS
    echo '<link rel="stylesheet" id="' . esc_attr( $css_id ) . '" href="'
        . esc_url( add_query_arg( 'ver', $version, $css_uri ) )
        . '" media="all">' . "\n";
}, 999 );
