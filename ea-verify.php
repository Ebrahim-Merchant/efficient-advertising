<?php
/**
 * Frontend verification — check all key pages render correctly
 */
define('ABSPATH', __DIR__ . '/');
require_once ABSPATH . 'wp-load.php';
global $wpdb;

echo "=== FRONTEND VERIFICATION ===\n\n";

// 1. Homepage data check
echo "--- HOMEPAGE ---\n";
$front_id = get_option('page_on_front');
echo "Front page ID: $front_id\n";
echo "Show on front: " . get_option('show_on_front') . "\n";
$template = get_page_template_slug($front_id);
echo "Page template: " . ($template ?: '(default)') . "\n";

// Check hero image data
$hero_slugs = ['signage', 'signage-dubai', 'vehicle-branding', 'banners-large-format', 'exhibitions-events', 'stickers-branding', 'flags-outdoor'];
$hero_found = 0;
foreach ($hero_slugs as $s) {
    $t = get_term_by('slug', $s, 'product_cat');
    if ($t) {
        $prods = get_posts([
            'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => 1,
            'meta_query' => [['key' => '_thumbnail_id', 'compare' => 'EXISTS']],
            'tax_query' => [['taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $t->term_id]],
        ]);
        if (!empty($prods)) {
            $img = get_the_post_thumbnail_url($prods[0]->ID, 'large');
            if ($img) {
                $hero_found++;
                echo "  Hero image for $s: " . basename($img) . "\n";
            }
        }
    }
}
echo "Hero images available: $hero_found\n\n";

// 2. Service categories check
echo "--- SERVICE CATEGORIES ---\n";
$parent_cats = get_terms(['taxonomy' => 'product_cat', 'parent' => 0, 'hide_empty' => true, 'orderby' => 'name']);
$cat_count = 0;
foreach ($parent_cats as $c) {
    if ($c->slug === 'uncategorized') continue;
    $cat_count++;
    $sub_count = count(get_terms(['taxonomy' => 'product_cat', 'parent' => $c->term_id, 'hide_empty' => true]));
    echo "  {$c->name} ({$c->slug}) — {$c->count} products, $sub_count subcats\n";
    echo "    URL: " . get_term_link($c) . "\n";
}
echo "Total parent categories: $cat_count\n\n";

// 3. Product pages check - 5 random
echo "--- PRODUCT PAGES (5 random) ---\n";
$random_prods = $wpdb->get_results("
    SELECT p.ID, p.post_title, p.post_name, p.post_excerpt, 
           thumb.meta_value as thumb_id
    FROM {$wpdb->posts} p
    LEFT JOIN {$wpdb->postmeta} thumb ON p.ID = thumb.post_id AND thumb.meta_key = '_thumbnail_id'
    WHERE p.post_type = 'product' AND p.post_status = 'publish'
    ORDER BY RAND() LIMIT 5
");

foreach ($random_prods as $p) {
    $url = get_permalink($p->ID);
    $has_thumb = !empty($p->thumb_id);
    $thumb_url = $has_thumb ? wp_get_attachment_url($p->thumb_id) : 'NONE';
    $cats = get_the_terms($p->ID, 'product_cat');
    $cat_names = [];
    if ($cats && !is_wp_error($cats)) {
        foreach ($cats as $c) $cat_names[] = $c->name;
    }
    $sku = get_post_meta($p->ID, '_sku', true);
    $yoast_t = get_post_meta($p->ID, '_yoast_wpseo_title', true);
    $yoast_d = get_post_meta($p->ID, '_yoast_wpseo_metadesc', true);
    $alt = get_post_meta($p->thumb_id, '_wp_attachment_image_alt', true);

    echo "  #{$p->ID} {$p->post_title}\n";
    echo "    SKU: $sku\n";
    echo "    URL: $url\n";
    echo "    Thumb: " . ($has_thumb ? basename($thumb_url) : 'MISSING') . "\n";
    echo "    Alt: " . ($alt ?: 'MISSING') . "\n";
    echo "    Categories: " . implode(', ', $cat_names) . "\n";
    echo "    Yoast: " . ($yoast_t ? 'YES' : 'auto') . " / " . ($yoast_d ? 'YES' : 'auto') . "\n";
    echo "    Excerpt: " . (strlen($p->post_excerpt) > 0 ? substr($p->post_excerpt, 0, 80) . '...' : 'EMPTY') . "\n\n";
}

// 4. Category page test - check products load for top category
echo "--- CATEGORY PAGE TEST (signage) ---\n";
$signage = get_term_by('slug', 'signage', 'product_cat');
if ($signage) {
    $sig_prods = get_posts([
        'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => -1,
        'tax_query' => [['taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $signage->term_id, 'include_children' => true]],
    ]);
    echo "  Products in Signage (inc children): " . count($sig_prods) . "\n";

    // Check subcategories
    $sig_subs = get_terms(['taxonomy' => 'product_cat', 'parent' => $signage->term_id, 'hide_empty' => true]);
    echo "  Subcategories: " . count($sig_subs) . "\n";
    foreach ($sig_subs as $ss) {
        echo "    {$ss->name} ({$ss->count} products)\n";
    }
}

// 5. Image file existence check - 10 random
echo "\n--- IMAGE FILE CHECK (10 random) ---\n";
$uploads_dir = wp_upload_dir()['basedir'];
$sample_imgs = $wpdb->get_results("
    SELECT p.ID, p.post_title, am.meta_value as file_path
    FROM {$wpdb->posts} p
    INNER JOIN {$wpdb->postmeta} thumb ON p.ID = thumb.post_id AND thumb.meta_key = '_thumbnail_id'
    INNER JOIN {$wpdb->postmeta} am ON thumb.meta_value = am.post_id AND am.meta_key = '_wp_attached_file'
    WHERE p.post_type = 'product' AND p.post_status = 'publish'
    ORDER BY RAND() LIMIT 10
");
$pass = 0;
$fail = 0;
foreach ($sample_imgs as $img) {
    $full_path = $uploads_dir . '/' . $img->file_path;
    $exists = file_exists($full_path);
    echo "  " . ($exists ? 'PASS' : 'FAIL') . " | {$img->post_title} → " . basename($img->file_path) . "\n";
    $exists ? $pass++ : $fail++;
}
echo "Image check: $pass PASS, $fail FAIL\n";

// 6. Template routing check
echo "\n--- TEMPLATE ROUTING ---\n";
$theme_dir = get_template_directory();
$templates = ['single-product-premium.php', 'taxonomy-product_cat.php', 'index.php', 'header.php', 'footer.php', 'front-page.php'];
foreach ($templates as $tpl) {
    $exists = file_exists($theme_dir . '/' . $tpl);
    echo "  " . ($exists ? 'EXISTS' : 'MISSING') . " — $tpl\n";
}

// Check functions.php template routing
echo "\n--- TEMPLATE ROUTING HOOKS ---\n";
$funcs = file_get_contents($theme_dir . '/functions.php');
echo "  template_include filter: " . (strpos($funcs, 'template_include') !== false ? 'YES' : 'NO') . "\n";
echo "  single-product-premium.php reference: " . (strpos($funcs, 'single-product-premium') !== false ? 'YES' : 'NO') . "\n";

// 7. Overall counts
echo "\n--- SUMMARY ---\n";
$total_pub = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='product' AND post_status='publish'");
$total_with_thumb = $wpdb->get_var("
    SELECT COUNT(DISTINCT p.ID) FROM {$wpdb->posts} p
    INNER JOIN {$wpdb->postmeta} m ON p.ID = m.post_id AND m.meta_key = '_thumbnail_id'
    WHERE p.post_type='product' AND p.post_status='publish'
    AND m.meta_value IS NOT NULL AND m.meta_value != ''
");
$total_with_sku = $wpdb->get_var("
    SELECT COUNT(DISTINCT p.ID) FROM {$wpdb->posts} p
    INNER JOIN {$wpdb->postmeta} m ON p.ID = m.post_id AND m.meta_key = '_sku'
    WHERE p.post_type='product' AND p.post_status='publish'
    AND m.meta_value IS NOT NULL AND m.meta_value != ''
");
$total_cats = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->term_taxonomy} WHERE taxonomy='product_cat'");

echo "  Published products: $total_pub\n";
echo "  With thumbnail: $total_with_thumb\n";
echo "  With SKU: $total_with_sku\n";
echo "  Total categories: $total_cats\n";
echo "  Theme: " . wp_get_theme()->get('Name') . "\n";
echo "  Site URL: " . get_site_url() . "\n";
echo "\nDONE.\n";
