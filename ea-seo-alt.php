<?php
/**
 * Step 12+13: Fix alt text on all product images + verify SEO meta
 * Alt text format: "{Product Name} — {Category Name} | Efficient Advertising Dubai"
 */
define('ABSPATH', __DIR__ . '/');
require_once ABSPATH . 'wp-load.php';
global $wpdb;

$action = $argv[1] ?? 'fix-alt';

if ($action === 'fix-alt') {
    echo "=== FIXING ALT TEXT ON ALL PRODUCT IMAGES ===\n\n";
    
    $products = $wpdb->get_results("
        SELECT p.ID, p.post_title, thumb.meta_value as thumb_id
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->postmeta} thumb ON p.ID = thumb.post_id AND thumb.meta_key = '_thumbnail_id'
        WHERE p.post_type = 'product' AND p.post_status = 'publish'
        AND thumb.meta_value IS NOT NULL AND thumb.meta_value != ''
    ");
    
    $updated = 0;
    $already_ok = 0;
    $errors = 0;
    
    foreach ($products as $prod) {
        // Get primary category
        $cats = get_the_terms($prod->ID, 'product_cat');
        $cat_name = '';
        if ($cats && !is_wp_error($cats)) {
            // Prefer parent category
            foreach ($cats as $c) {
                if ($c->parent == 0 && $c->slug !== 'uncategorized') {
                    $cat_name = $c->name;
                    break;
                }
            }
            if (!$cat_name) {
                $cat_name = reset($cats)->name;
            }
        }
        
        $alt_text = html_entity_decode($prod->post_title, ENT_QUOTES, 'UTF-8');
        if ($cat_name) {
            $cat_clean = html_entity_decode($cat_name, ENT_QUOTES, 'UTF-8');
            $alt_text .= ' — ' . $cat_clean . ' | Efficient Advertising Dubai';
        } else {
            $alt_text .= ' | Efficient Advertising Dubai';
        }
        
        // Check current alt
        $current_alt = get_post_meta($prod->thumb_id, '_wp_attachment_image_alt', true);
        if ($current_alt === $alt_text) {
            $already_ok++;
            continue;
        }
        
        // Update attachment alt text
        $result = update_post_meta($prod->thumb_id, '_wp_attachment_image_alt', $alt_text);
        if ($result !== false) {
            $updated++;
        } else {
            $errors++;
        }
        
        // Also update the attachment post_title to match product name
        wp_update_post([
            'ID' => $prod->thumb_id,
            'post_title' => html_entity_decode($prod->post_title, ENT_QUOTES, 'UTF-8'),
        ]);
    }
    
    echo "Total products processed: " . count($products) . "\n";
    echo "Alt text updated: $updated\n";
    echo "Already correct: $already_ok\n";
    echo "Errors: $errors\n";
    
    // Verify 5 samples
    echo "\n=== VERIFICATION (5 random) ===\n";
    $samples = $wpdb->get_results("
        SELECT p.ID, p.post_title, thumb.meta_value as thumb_id
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->postmeta} thumb ON p.ID = thumb.post_id AND thumb.meta_key = '_thumbnail_id'
        WHERE p.post_type = 'product' AND p.post_status = 'publish'
        ORDER BY RAND() LIMIT 5
    ");
    foreach ($samples as $s) {
        $alt = get_post_meta($s->thumb_id, '_wp_attachment_image_alt', true);
        echo "  Product {$s->ID} | {$s->post_title}\n";
        echo "    Alt: $alt\n\n";
    }
}

if ($action === 'check-seo') {
    echo "=== SEO HEALTH CHECK ===\n\n";
    
    // Check if Yoast is active
    $active_plugins = get_option('active_plugins', []);
    $has_yoast = false;
    foreach ($active_plugins as $p) {
        if (strpos($p, 'wordpress-seo') !== false) {
            $has_yoast = true;
            break;
        }
    }
    echo "Yoast SEO active: " . ($has_yoast ? 'YES' : 'NO') . "\n";
    
    // Check homepage meta
    echo "\n--- Homepage ---\n";
    $front_id = get_option('page_on_front');
    if ($front_id) {
        $title = get_the_title($front_id);
        $yoast_title = get_post_meta($front_id, '_yoast_wpseo_title', true);
        $yoast_desc = get_post_meta($front_id, '_yoast_wpseo_metadesc', true);
        echo "  Front page: $title (ID: $front_id)\n";
        echo "  Yoast title: " . ($yoast_title ?: '(not set)') . "\n";
        echo "  Yoast desc: " . ($yoast_desc ?: '(not set)') . "\n";
    }
    
    // Check 5 random product SEO
    echo "\n--- Products (5 random) ---\n";
    $prods = $wpdb->get_results("
        SELECT ID, post_title, post_name FROM {$wpdb->posts}
        WHERE post_type = 'product' AND post_status = 'publish'
        ORDER BY RAND() LIMIT 5
    ");
    foreach ($prods as $p) {
        $yoast_title = get_post_meta($p->ID, '_yoast_wpseo_title', true);
        $yoast_desc = get_post_meta($p->ID, '_yoast_wpseo_metadesc', true);
        echo "  #{$p->ID} {$p->post_title}\n";
        echo "    URL: /" . $p->post_name . "/\n";
        echo "    Yoast title: " . ($yoast_title ?: '(auto)') . "\n";
        echo "    Yoast desc: " . ($yoast_desc ?: '(auto)') . "\n\n";
    }
    
    // Check category SEO
    echo "--- Categories (top-level) ---\n";
    $cats = get_terms(['taxonomy' => 'product_cat', 'parent' => 0, 'hide_empty' => true]);
    foreach ($cats as $c) {
        if ($c->slug === 'uncategorized') continue;
        $yoast_title = get_term_meta($c->term_id, 'wpseo_title', true);
        $yoast_desc = get_term_meta($c->term_id, 'wpseo_desc', true);
        echo "  {$c->name} (/{$c->slug}/)\n";
        echo "    Yoast title: " . ($yoast_title ?: '(auto)') . "\n";
        echo "    Yoast desc: " . ($yoast_desc ?: '(auto/theme fallback)') . "\n\n";
    }
    
    // Check active plugins list
    echo "--- Active Plugins ---\n";
    foreach ($active_plugins as $p) {
        echo "  $p\n";
    }
}
