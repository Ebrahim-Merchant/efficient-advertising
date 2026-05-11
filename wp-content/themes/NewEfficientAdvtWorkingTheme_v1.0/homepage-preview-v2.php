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

// 3. Force a peaceful 7-second pause background rotation speed, clearing any previous fast intervals
add_action( 'wp_footer', function() {
    ?>
    <script id="ea-visual-v2-rotator-speed-override">
    (function() {
        console.log("V2 Mirror: Enforcing peaceful 7-second background rotator.");
        var slides = Array.prototype.slice.call(document.querySelectorAll('[data-hero-bg-slide]'));
        if (!slides.length) return;
        
        // Bulletproof clear of any previous timers or intervals that might have been cached
        var maxId = setTimeout(function(){}, 0);
        for (var i = 0; i < maxId; i++) {
            clearTimeout(i);
            clearInterval(i);
        }
        
        // Reset active slide
        slides.forEach(function(s) { s.classList.remove('is-active'); });
        slides[0].classList.add('is-active');
        
        // 1. Immediately apply collage background images on load to bypass server-side lazy loaders
        var cols = Array.prototype.slice.call(document.querySelectorAll('[data-collage-bg]'));
        cols.forEach(function(col) {
            var bgUrl = col.getAttribute('data-collage-bg');
            if (bgUrl) {
                col.style.backgroundImage = "url('" + bgUrl + "')";
            }
        });
        
        var index = 0;
        setInterval(function() {
            slides[index].classList.remove('is-active');
            index = (index + 1) % slides.length;
            slides[index].classList.add('is-active');
        }, 7000); // Peaceful 7-second interval
    })();
    </script>
    <?php
}, 9999 );

// 4. Load the premium sandbox layout template
require locate_template( 'index-premium-v2.php' );

