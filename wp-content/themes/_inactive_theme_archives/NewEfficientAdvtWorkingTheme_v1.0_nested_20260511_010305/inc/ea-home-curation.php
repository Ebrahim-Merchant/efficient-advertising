<?php
/**
 * EA Home Curation — Central manual data source
 * CONTROL NO: EA-HOME-CURATION-003
 *
 * All homepage and catalogue visual data is defined here.
 * No WooCommerce queries, no automatic selection, no fallbacks.
 *
 * Functions:
 *   ea_get_home_hero_slides()
 *   ea_get_home_curated_product_ids()
 *   ea_get_home_recent_work_items()
 *   ea_get_catalogue_category_image_map()
 *
 * @package NewEfficientAdvtWorkingTheme_v1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ─────────────────────────────────────────────
 * 1. HERO SLIDES
 * Return exactly 3 manually curated slides.
 * If an image file does not exist on disk, that slide is skipped.
 * ───────────────────────────────────────────── */
function ea_get_home_hero_slides() {

    $wa_url    = 'https://wa.me/971527966265?text=' . rawurlencode( 'Hi, I would like to get a quote for printing/branding services.' );
    $quote_url = home_url( '/contact-us/' );

    $slides = [
        [
            'image_url'       => '/wp-content/uploads/product-sku-images/ee-002.webp',  // Exhibition booth
            'eyebrow'         => 'Premium Printing & Signage in Dubai',
            'heading'         => 'Premium Signage, Printing & Brand Execution',
            'text'            => 'Custom signage, exhibition stands, vehicle branding, large-format printing, promotional displays and installation services across Dubai and the UAE.',
            'primary_label'   => 'Browse Catalogue',
            'primary_url'     => '/catalogue/',
            'secondary_label' => 'WhatsApp Us',
            'secondary_url'   => $wa_url,
            'micro_label'     => 'Request a Quote',
            'micro_url'       => $quote_url,
        ],
        [
            'image_url'       => '/wp-content/uploads/product-sku-images/vb-002.webp',  // Full Wrap – Van
            'eyebrow'         => 'Premium Printing & Signage in Dubai',
            'heading'         => 'Premium Signage, Printing & Brand Execution',
            'text'            => 'Custom signage, exhibition stands, vehicle branding, large-format printing, promotional displays and installation services across Dubai and the UAE.',
            'primary_label'   => 'Browse Catalogue',
            'primary_url'     => '/catalogue/',
            'secondary_label' => 'WhatsApp Us',
            'secondary_url'   => $wa_url,
            'micro_label'     => 'Request a Quote',
            'micro_url'       => $quote_url,
        ],
        [
            'image_url'       => '/wp-content/uploads/product-sku-images/sg-003.webp',  // Frontlit 3D Channel Letters
            'eyebrow'         => 'Premium Printing & Signage in Dubai',
            'heading'         => 'Premium Signage, Printing & Brand Execution',
            'text'            => 'Custom signage, exhibition stands, vehicle branding, large-format printing, promotional displays and installation services across Dubai and the UAE.',
            'primary_label'   => 'Browse Catalogue',
            'primary_url'     => '/catalogue/',
            'secondary_label' => 'WhatsApp Us',
            'secondary_url'   => $wa_url,
            'micro_label'     => 'Request a Quote',
            'micro_url'       => $quote_url,
        ],
    ];

    // Filter out slides whose image file does not exist on disk
    return array_values( array_filter( $slides, function ( $slide ) {
        $file = ABSPATH . ltrim( $slide['image_url'], '/' );
        return file_exists( $file );
    } ) );
}


/* ─────────────────────────────────────────────
 * 2. CURATED PRODUCT IDs
 * Ordered array of manually chosen WooCommerce product IDs.
 * Only these exact IDs are queried. Order is preserved.
 * Missing or unpublished IDs are skipped — never replaced.
 *
 * Best-in-class showcase products selected per category.
 * ───────────────────────────────────────────── */
function ea_get_home_curated_product_ids() {

    return [
        1058,   // Print Materials — Gold Foil Spot UV Business Card 400gsm
        1411,   // Promotional & Corporate Gifts — Standard Crystal Trophy
        1734,   // Stickers & Branding — Retail Shopfront Window Graphic
        1534,   // Signage — Frontlit 3D Channel Letters
        1668,   // Exhibitions & Events — Double-Decker Booth
        1505,   // Banners & Large Format — Standard Step & Repeat
        1601,   // Flags & Outdoor — Standard Feather Flag
        1646,   // Vehicle Branding — Full Wrap – Car
    ];
}


/* ─────────────────────────────────────────────
 * 3. RECENT WORK (PORTFOLIO)
 * Each item is a manually curated project visual.
 * No product thumbnails. No WooCommerce queries.
 * If an image is missing on disk, that item is skipped.
 * ───────────────────────────────────────────── */
function ea_get_home_recent_work_items() {

    $items = [
        [
            'image_url' => '/wp-content/uploads/2022/03/Step-Repeat-Backdrop-2.jpg',
            'title'     => 'Step & Repeat Backdrop',
            'subtitle'  => 'Corporate Event Dubai',
            'link_url'  => '',
        ],
        [
            'image_url' => '/wp-content/uploads/2022/03/3D-Aluminum-Signage-2.jpg',
            'title'     => '3D Aluminium Signage',
            'subtitle'  => 'Storefront Dubai',
            'link_url'  => '',
        ],
        [
            'image_url' => '/wp-content/uploads/2022/03/Exhibition-Stands-1.jpg',
            'title'     => 'Custom Exhibition Stand',
            'subtitle'  => 'Trade Show Dubai',
            'link_url'  => '',
        ],
        [
            'image_url' => '/wp-content/uploads/2022/03/Vehicle-branding.png',
            'title'     => 'Full Vehicle Wrap',
            'subtitle'  => 'Fleet Branding Dubai',
            'link_url'  => '',
        ],
        [
            'image_url' => '/wp-content/uploads/2022/03/Events-Branding-2-1.jpg',
            'title'     => 'Event Branding',
            'subtitle'  => 'Corporate Launch Dubai',
            'link_url'  => '',
        ],
        [
            'image_url' => '/wp-content/uploads/product-sku-images/sg-003.webp',  // Frontlit 3D Channel Letters
            'title'     => 'Frontlit 3D Signage',
            'subtitle'  => 'Storefront Dubai',
            'link_url'  => '',
        ],
    ];

    // Filter out items whose image file does not exist on disk
    return array_values( array_filter( $items, function ( $item ) {
        $file = ABSPATH . ltrim( $item['image_url'], '/' );
        return file_exists( $file );
    } ) );
}


/* ─────────────────────────────────────────────
 * 4. CATALOGUE CATEGORY DESCRIPTIONS
 * key   = real WooCommerce category slug
 * value = marketing description for catalogue tiles
 *
 * Single source of truth — consumed by page-catalogue.php.
 * ───────────────────────────────────────────── */
function ea_get_catalogue_category_descriptions() {

    return [
        'banners-large-format' => 'Roll-up banners, mesh banners, vinyl banners and large-format prints for events and retail.',
        'exhibitions-events'   => 'Exhibition stands, backdrop walls, promotional counters and event branding solutions.',
        'flags-outdoor'        => 'Feather flags, teardrop banners, outdoor flags and wind-resistant displays.',
        'print-materials'      => 'Business cards, brochures, flyers, letterheads and all commercial printing needs.',
        'promotional-gifts'    => 'Branded corporate gifts, promotional items, custom merchandise and giveaways.',
        'signage'              => 'Acrylic signs, LED signage, channel letters, shop fascia and wayfinding systems.',
        'stickers-branding'    => 'Custom stickers, wall graphics, floor decals and interior branding solutions.',
        'vehicle-branding'     => 'Full car wraps, partial wraps, van graphics and fleet branding across the UAE.',
    ];
}

/* ─────────────────────────────────────────────
 * 5. CATALOGUE CATEGORY TILE IMAGES
 * key   = real WooCommerce category slug
 * value = manual image URL (relative to site root)
 *
 * No product queries. No first-product fallback.
 * If a slug has no mapped image, the tile shows a neutral placeholder.
 *
 * TODO: Replace these with curated category hero images
 *       when professional photography is available.
 *       Current images are representative product SKU images.
 * ───────────────────────────────────────────── */
function ea_get_catalogue_category_image_map() {

    return [
        'banners-large-format' => '/wp-content/uploads/product-sku-images/lf-029.webp',  // Standard Step & Repeat backdrop
        'exhibitions-events'   => '/wp-content/uploads/product-sku-images/ee-008.webp',  // Double-Decker Booth
        'flags-outdoor'        => '/wp-content/uploads/product-sku-images/fl-001.webp',  // Standard Feather Flag
        'print-materials'      => '/wp-content/uploads/product-sku-images/ps-006.webp',  // Gold Foil Spot UV Business Card
        'promotional-gifts'    => '/wp-content/uploads/product-sku-images/cg-085.webp',  // Standard Crystal Trophy
        'signage'              => '/wp-content/uploads/product-sku-images/sg-003.webp',  // Frontlit 3D Channel Letters
        'stickers-branding'    => '/wp-content/uploads/product-sku-images/ob-012.webp',  // Retail Shopfront Window Graphic
        'vehicle-branding'     => '/wp-content/uploads/product-sku-images/vb-002.webp',  // Full Wrap – Van
    ];
}
