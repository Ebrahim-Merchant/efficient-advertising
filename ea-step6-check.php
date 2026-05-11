<?php
/**
 * Step 6-7: Check product short descriptions + verify category cards show data
 */
require_once __DIR__ . '/wp-load.php';
global $wpdb;

$action = isset($argv[1]) ? $argv[1] : 'check-excerpts';

if ($action === 'check-excerpts') {
    // Count products with/without excerpts
    $no_excerpt = $wpdb->get_var("
        SELECT COUNT(*) FROM {$wpdb->posts}
        WHERE post_type='product' AND post_status='publish'
        AND (post_excerpt IS NULL OR post_excerpt = '')
    ");
    $has_excerpt = $wpdb->get_var("
        SELECT COUNT(*) FROM {$wpdb->posts}
        WHERE post_type='product' AND post_status='publish'
        AND post_excerpt IS NOT NULL AND post_excerpt != ''
    ");
    echo "Products WITH short description: $has_excerpt\n";
    echo "Products WITHOUT short description: $no_excerpt\n\n";

    // Sample 5 WITH excerpt
    echo "=== SAMPLE WITH EXCERPT ===\n";
    $samples = $wpdb->get_results("
        SELECT ID, post_title, post_excerpt FROM {$wpdb->posts}
        WHERE post_type='product' AND post_status='publish'
        AND post_excerpt IS NOT NULL AND post_excerpt != ''
        ORDER BY RAND() LIMIT 5
    ");
    foreach ($samples as $s) {
        $wc = str_word_count(wp_strip_all_tags($s->post_excerpt));
        echo "  ID={$s->ID} | {$s->post_title}\n    Excerpt ({$wc} words): " . wp_trim_words(wp_strip_all_tags($s->post_excerpt), 40) . "\n";
    }

    // Sample 5 WITHOUT excerpt
    if ($no_excerpt > 0) {
        echo "\n=== SAMPLE WITHOUT EXCERPT ===\n";
        $samples2 = $wpdb->get_results("
            SELECT ID, post_title, post_content FROM {$wpdb->posts}
            WHERE post_type='product' AND post_status='publish'
            AND (post_excerpt IS NULL OR post_excerpt = '')
            ORDER BY RAND() LIMIT 5
        ");
        foreach ($samples2 as $s) {
            $content_words = str_word_count(wp_strip_all_tags($s->post_content));
            echo "  ID={$s->ID} | {$s->post_title} | content={$content_words} words\n";
        }
    }
}

if ($action === 'check-alt-text') {
    // Check how many product thumbnails have alt text
    $total = 0; $has_alt = 0; $no_alt = 0;
    $products = $wpdb->get_results("
        SELECT p.ID, p.post_title, pm.meta_value as thumb_id
        FROM {$wpdb->posts} p
        JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID AND pm.meta_key = '_thumbnail_id'
        WHERE p.post_type='product' AND p.post_status='publish' AND pm.meta_value > 0
    ");
    foreach ($products as $p) {
        $total++;
        $alt = get_post_meta($p->thumb_id, '_wp_attachment_image_alt', true);
        if (!empty(trim($alt))) {
            $has_alt++;
        } else {
            $no_alt++;
        }
    }
    echo "Total products with thumbnail: $total\n";
    echo "Thumbnails WITH alt text: $has_alt\n";
    echo "Thumbnails WITHOUT alt text: $no_alt\n\n";

    // Sample 5
    $samp = $wpdb->get_results("
        SELECT p.ID, p.post_title, pm.meta_value as thumb_id
        FROM {$wpdb->posts} p
        JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID AND pm.meta_key = '_thumbnail_id'
        WHERE p.post_type='product' AND p.post_status='publish' AND pm.meta_value > 0
        ORDER BY RAND() LIMIT 5
    ");
    foreach ($samp as $s) {
        $alt = get_post_meta($s->thumb_id, '_wp_attachment_image_alt', true);
        $cats = wp_get_post_terms($s->ID, 'product_cat', ['fields'=>'names']);
        echo "  {$s->post_title} | cat=" . implode(', ', $cats) . " | alt=" . ($alt ?: '(empty)') . "\n";
    }
}

if ($action === 'check-seo') {
    // Check H1 count, meta title/desc on homepage, category, product
    $urls = [
        'Homepage' => home_url('/'),
        'Category (Signage)' => home_url('/product-category/signage/'),
        'Product' => '',
    ];
    // Get a random product URL
    $prod = $wpdb->get_row("SELECT ID FROM {$wpdb->posts} WHERE post_type='product' AND post_status='publish' ORDER BY RAND() LIMIT 1");
    if ($prod) {
        $urls['Product'] = get_permalink($prod->ID) . ' (' . get_the_title($prod->ID) . ')';
    }

    echo "=== SEO CHECK ===\n";
    foreach ($urls as $label => $url) {
        if (empty($url)) continue;
        $raw_url = preg_replace('/\s+\(.*\)$/', '', $url);
        echo "\n$label: $url\n";

        // Can't fetch via HTTP locally, check template counts
        echo "  (Template-level checks done in browser)\n";
    }

    // Check Yoast meta for products
    $yoast_title = $wpdb->get_var("
        SELECT COUNT(*) FROM {$wpdb->posts} p
        JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID AND pm.meta_key = '_yoast_wpseo_title' AND pm.meta_value != ''
        WHERE p.post_type='product' AND p.post_status='publish'
    ");
    $yoast_desc = $wpdb->get_var("
        SELECT COUNT(*) FROM {$wpdb->posts} p
        JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID AND pm.meta_key = '_yoast_wpseo_metadesc' AND pm.meta_value != ''
        WHERE p.post_type='product' AND p.post_status='publish'
    ");
    echo "\nYoast SEO meta title set: $yoast_title / 727\n";
    echo "Yoast SEO meta desc set: $yoast_desc / 727\n";

    // Category Yoast
    $cat_yoast = $wpdb->get_var("
        SELECT COUNT(DISTINCT tm.term_id)
        FROM {$wpdb->termmeta} tm
        WHERE tm.meta_key = '_yoast_wpseo_metadesc' AND tm.meta_value != ''
    ");
    echo "Category Yoast descriptions: $cat_yoast\n";
}
