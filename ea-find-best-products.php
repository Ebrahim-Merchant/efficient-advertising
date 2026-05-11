<?php
/**
 * Find the best representative product per category by searching product names
 * for high-value keywords. Output product ID, name, SKU image filename.
 */
require_once __DIR__ . '/wp-load.php';

$categories = get_terms([
    'taxonomy'   => 'product_cat',
    'parent'     => 0,
    'hide_empty' => true,
]);

// Keywords that indicate high-value, professional products per category
$best_keywords = [
    'banners-large-format' => ['backdrop', 'step and repeat', 'step & repeat', 'roll up', 'rollup', 'pop up', 'popup', 'mesh banner', 'vinyl banner', 'large banner'],
    'exhibitions-events'   => ['exhibition stand', 'exhibition booth', 'display stand', 'trade show', 'pop up stand', 'display counter', 'promotional counter', 'exhibition display'],
    'flags-outdoor'        => ['feather flag', 'teardrop', 'beach flag', 'outdoor flag', 'flying banner', 'wind flag', 'sail flag', 'flutter flag'],
    'print-materials'      => ['business card', 'letterhead', 'brochure', 'flyer', 'corporate', 'premium card', 'luxury card', 'spot uv', 'emboss'],
    'promotional-gifts'    => ['trophy', 'award', 'crystal', 'executive', 'premium', 'luxury', 'corporate gift', 'gold', 'silver', 'metal'],
    'signage'              => ['3d', 'led', 'channel letter', 'neon', 'acrylic sign', 'illuminated', 'light box', 'pylon', 'monument'],
    'stickers-branding'    => ['vinyl wrap', 'wall graphic', 'floor graphic', 'window', 'frosted', 'glass', 'full color', 'printed vinyl', 'custom vinyl'],
    'vehicle-branding'     => ['full wrap', 'full vehicle', 'car wrap', 'bus wrap', 'fleet', 'van wrap', 'truck', 'full body'],
];

foreach ($categories as $cat) {
    echo "\n=== {$cat->name} (slug: {$cat->slug}, count: {$cat->count}) ===\n";

    // Get ALL products in this category with thumbnails
    $products = get_posts([
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'tax_query'      => [['taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $cat->term_id, 'include_children' => true]],
        'meta_query'     => [['key' => '_thumbnail_id', 'compare' => 'EXISTS']],
    ]);

    $keywords = isset($best_keywords[$cat->slug]) ? $best_keywords[$cat->slug] : [];

    // Score each product
    $scored = [];
    foreach ($products as $p) {
        $name_lower = strtolower($p->post_title);
        $desc_lower = strtolower($p->post_content . ' ' . $p->post_excerpt);
        $score = 0;

        foreach ($keywords as $kw) {
            if (strpos($name_lower, $kw) !== false) $score += 10;
            if (strpos($desc_lower, $kw) !== false) $score += 3;
        }

        $thumb_id  = get_post_thumbnail_id($p->ID);
        $thumb_url = wp_get_attachment_url($thumb_id);
        $thumb_file = $thumb_url ? basename($thumb_url) : '(no file)';

        $scored[] = [
            'id'    => $p->ID,
            'title' => $p->post_title,
            'score' => $score,
            'file'  => $thumb_file,
            'url'   => $thumb_url,
        ];
    }

    // Sort by score descending
    usort($scored, function($a, $b) { return $b['score'] - $a['score']; });

    // Show top 10
    $show = array_slice($scored, 0, 10);
    foreach ($show as $s) {
        echo "  ID={$s['id']} | score={$s['score']} | {$s['title']} | {$s['file']}\n";
    }
}
