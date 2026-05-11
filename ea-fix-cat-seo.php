<?php
/**
 * Set explicit Yoast SEO title + meta description for all parent categories.
 */
define('ABSPATH', __DIR__ . '/');
require_once ABSPATH . 'wp-load.php';

$cats = get_terms(['taxonomy' => 'product_cat', 'parent' => 0, 'hide_empty' => false]);

$seo_map = [
    'signage' => [
        'title' => 'Signage Company Dubai | Custom Signs, 3D Letters & LED | Efficient Advertising',
        'desc'  => 'Dubai\'s trusted signage company since 2008. Custom 3D letters, acrylic signs, LED signage, shop boards & office signs. In-house production with same-day options.',
    ],
    'banners-large-format' => [
        'title' => 'Banner Printing Dubai | Roll-Up, Flex & Large Format | Efficient Advertising',
        'desc'  => 'Professional banner printing in Dubai — roll-up banners, flex banners, mesh banners & large format prints. Fast turnaround, free delivery across UAE.',
    ],
    'vehicle-branding' => [
        'title' => 'Vehicle Branding Dubai | Car Wraps, Van Graphics & Fleet | Efficient Advertising',
        'desc'  => 'Expert vehicle branding in Dubai — full wraps, partial decals, van graphics & fleet branding. Premium 3M vinyl with 5-year warranty. Free design included.',
    ],
    'exhibitions-events' => [
        'title' => 'Exhibition Stands Dubai | Trade Show Displays & Events | Efficient Advertising',
        'desc'  => 'Custom exhibition stands and event displays in Dubai. Pop-up stands, booth construction, backdrops & branded environments. Turnkey solutions for UAE events.',
    ],
    'stickers-branding' => [
        'title' => 'Sticker Printing Dubai | Custom Labels, Decals & Branding | Efficient Advertising',
        'desc'  => 'Custom sticker printing in Dubai — vinyl stickers, labels, floor graphics, wall decals & window branding. Weather-proof materials with same-day production.',
    ],
    'flags-outdoor' => [
        'title' => 'Flag Printing Dubai | Custom Flags, Feather & Teardrop Banners | Efficient Advertising',
        'desc'  => 'Custom flag printing in Dubai — feather flags, teardrop banners, national flags & event flags. Dye-sublimation print, durable outdoor materials.',
    ],
    'print-materials' => [
        'title' => 'Printing Services Dubai | Business Cards, Brochures & Flyers | Efficient Advertising',
        'desc'  => 'Professional printing services in Dubai — business cards, brochures, flyers, letterheads, envelopes & catalogues. Premium paper stocks, fast turnaround.',
    ],
    'promotional-gifts' => [
        'title' => 'Promotional Gifts Dubai | Corporate Gifts & Branded Items | Efficient Advertising',
        'desc'  => 'Custom promotional and corporate gifts in Dubai — branded mugs, pens, bags, t-shirts, caps & tech accessories. Bulk orders with free branding.',
    ],
];

echo "=== SETTING CATEGORY SEO META ===\n\n";
$set = 0;
$skipped = 0;

foreach ($cats as $c) {
    if ($c->slug === 'uncategorized') continue;

    if (!isset($seo_map[$c->slug])) {
        echo "  SKIP: {$c->name} ({$c->slug}) — not in map\n";
        $skipped++;
        continue;
    }

    $meta = $seo_map[$c->slug];

    // Yoast stores category SEO in wpseo_taxonomy_meta option
    $tax_meta = get_option('wpseo_taxonomy_meta', []);
    if (!isset($tax_meta['product_cat'])) {
        $tax_meta['product_cat'] = [];
    }
    if (!isset($tax_meta['product_cat'][$c->term_id])) {
        $tax_meta['product_cat'][$c->term_id] = [];
    }

    $tax_meta['product_cat'][$c->term_id]['wpseo_title'] = $meta['title'];
    $tax_meta['product_cat'][$c->term_id]['wpseo_desc'] = $meta['desc'];

    update_option('wpseo_taxonomy_meta', $tax_meta);

    echo "  SET: {$c->name} ({$c->slug})\n";
    echo "    Title: {$meta['title']}\n";
    echo "    Desc: {$meta['desc']}\n\n";
    $set++;
}

echo "Done. Set: $set, Skipped: $skipped\n";

// Also set SEO for subcategories using a pattern
echo "\n=== SETTING SUB-CATEGORY SEO (auto-generated) ===\n";
$subcats = get_terms(['taxonomy' => 'product_cat', 'parent__not_in' => [0], 'hide_empty' => false]);
$sub_set = 0;
$tax_meta = get_option('wpseo_taxonomy_meta', []);

foreach ($subcats as $sc) {
    $parent = get_term($sc->parent, 'product_cat');
    $parent_name = $parent ? $parent->name : 'Products';

    $title = "{$sc->name} Dubai | {$parent_name} | Efficient Advertising";
    $desc_text = "Order {$sc->name} in Dubai from Efficient Advertising. Part of our {$parent_name} range. In-house production, same-day delivery available across UAE.";

    if (!isset($tax_meta['product_cat'][$sc->term_id])) {
        $tax_meta['product_cat'][$sc->term_id] = [];
    }
    $tax_meta['product_cat'][$sc->term_id]['wpseo_title'] = $title;
    $tax_meta['product_cat'][$sc->term_id]['wpseo_desc'] = $desc_text;
    $sub_set++;
}

update_option('wpseo_taxonomy_meta', $tax_meta);
echo "Sub-categories SEO set: $sub_set\n";
