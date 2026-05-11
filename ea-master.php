<?php
/**
 * Efficient Advertising - Master Execution Script
 * Handles category cleanup, product reassignment, image mapping, and content structure
 */
define('ABSPATH', __DIR__ . '/');
define('SHORTINIT', false);
require_once ABSPATH . 'wp-load.php';

$action = $argv[1] ?? 'help';

switch ($action) {

// ===== STEP 1: ANALYZE CATEGORIES =====
case 'analyze-cats':
    $sync_file = __DIR__ . '/wp-content/themes/NewEfficientAdvtWorkingTheme_v1.0/master-sync-report.json';
    $sync = json_decode(file_get_contents($sync_file), true);
    
    // Extract unique categories from sync data
    $excel_cats = [];
    $excel_subcats = [];
    foreach ($sync['samples'] as $s) {
        $excel_cats[$s['category']] = true;
        $excel_subcats[$s['sub_category']] = $s['category'];
    }
    
    // But the sync report only has samples. Let me look at actual WP terms
    $all_terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
    
    $new_cats = [];
    $old_cats = [];
    foreach ($all_terms as $t) {
        if (str_ends_with($t->slug, '-new') || $t->slug === 'print-materials') {
            $new_cats[] = $t;
        } elseif ($t->slug === 'uncategorized') {
            // skip
        } else {
            $old_cats[] = $t;
        }
    }
    
    echo "=== NEW CATEGORIES (from Excel sync) ===\n";
    echo "Count: " . count($new_cats) . "\n";
    $new_parents = [];
    $new_children = [];
    foreach ($new_cats as $c) {
        if ($c->parent == 0) {
            $new_parents[$c->term_id] = $c;
        } else {
            $new_children[$c->term_id] = $c;
        }
    }
    echo "\nParent categories (" . count($new_parents) . "):\n";
    foreach ($new_parents as $c) {
        echo "  [{$c->term_id}] {$c->name} (slug: {$c->slug}, products: {$c->count})\n";
    }
    echo "\nChild categories (" . count($new_children) . "):\n";
    foreach ($new_children as $c) {
        $parent_name = '';
        foreach ($new_parents as $p) {
            if ($p->term_id == $c->parent) {
                $parent_name = $p->name;
                break;
            }
        }
        echo "  [{$c->term_id}] {$c->name} → parent: {$parent_name} (products: {$c->count})\n";
    }
    
    echo "\n=== OLD CATEGORIES (to be removed) ===\n";
    echo "Count: " . count($old_cats) . "\n";
    $old_with_products = array_filter($old_cats, fn($c) => $c->count > 0);
    echo "With products: " . count($old_with_products) . "\n";
    foreach ($old_with_products as $c) {
        echo "  [{$c->term_id}] {$c->name} ({$c->count} products)\n";
    }
    break;

// ===== STEP 1B: GET FULL CATEGORY MAPPING FROM PRODUCTS =====
case 'full-cat-map':
    // Query all products and get their category assignments
    global $wpdb;
    
    // Get all new parent categories
    $new_parents = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0]);
    $new_parent_ids = [];
    foreach ($new_parents as $p) {
        if (str_ends_with($p->slug, '-new') || $p->slug === 'print-materials') {
            $new_parent_ids[$p->term_id] = $p->name;
        }
    }
    
    // Get all new child categories
    $new_child_ids = [];
    $all_terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
    foreach ($all_terms as $t) {
        if (str_ends_with($t->slug, '-new') || $t->slug === 'print-materials') {
            $new_child_ids[$t->term_id] = $t->name;
        }
    }
    
    echo "New category IDs: " . implode(', ', array_keys($new_child_ids)) . "\n\n";
    
    // Count products that are ONLY in old categories
    $products_only_old = 0;
    $products_in_new = 0;
    $products_in_both = 0;
    
    $all_products = get_posts(['post_type' => 'product', 'posts_per_page' => -1, 'post_status' => 'any', 'fields' => 'ids']);
    echo "Total products: " . count($all_products) . "\n";
    
    foreach ($all_products as $pid) {
        $terms = wp_get_post_terms($pid, 'product_cat', ['fields' => 'ids']);
        $has_new = false;
        $has_old = false;
        foreach ($terms as $tid) {
            if (isset($new_child_ids[$tid])) {
                $has_new = true;
            } else {
                $has_old = true;
            }
        }
        if ($has_new && $has_old) $products_in_both++;
        elseif ($has_new) $products_in_new++;
        elseif ($has_old) $products_only_old++;
    }
    
    echo "Products in new categories only: $products_in_new\n";
    echo "Products in old categories only: $products_only_old\n";
    echo "Products in both old + new: $products_in_both\n";
    break;

// ===== STEP 1C: DELETE OLD CATEGORIES =====
case 'delete-old-cats':
    $all_terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
    $deleted = 0;
    $kept = 0;
    
    foreach ($all_terms as $t) {
        if (str_ends_with($t->slug, '-new') || $t->slug === 'print-materials' || $t->slug === 'uncategorized') {
            $kept++;
            continue;
        }
        // This is an old category - delete it
        $result = wp_delete_term($t->term_id, 'product_cat');
        if (is_wp_error($result)) {
            echo "ERROR deleting [{$t->term_id}] {$t->name}: " . $result->get_error_message() . "\n";
        } else {
            $deleted++;
        }
    }
    echo "Deleted: $deleted old categories\n";
    echo "Kept: $kept new categories\n";
    
    // Verify remaining
    $remaining = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
    echo "Remaining categories: " . count($remaining) . "\n";
    break;

// ===== STEP 1D: RENAME NEW CATEGORIES (remove -new suffix from slugs) =====
case 'rename-cats':
    $all_terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
    $renamed = 0;
    foreach ($all_terms as $t) {
        if (str_ends_with($t->slug, '-new')) {
            $new_slug = preg_replace('/-new$/', '', $t->slug);
            wp_update_term($t->term_id, 'product_cat', ['slug' => $new_slug]);
            echo "Renamed: {$t->slug} → {$new_slug}\n";
            $renamed++;
        }
    }
    echo "\nRenamed $renamed categories\n";
    break;

// ===== STEP 2: CHECK PRODUCT CATEGORY ASSIGNMENTS =====
case 'check-assignments':
    $all_products = get_posts(['post_type' => 'product', 'posts_per_page' => -1, 'post_status' => 'any', 'fields' => 'ids']);
    $no_cat = 0;
    $uncategorized_only = 0;
    $properly_assigned = 0;
    $samples_no_cat = [];
    
    foreach ($all_products as $pid) {
        $terms = wp_get_post_terms($pid, 'product_cat', ['fields' => 'all']);
        if (empty($terms)) {
            $no_cat++;
            if (count($samples_no_cat) < 10) {
                $sku = get_post_meta($pid, '_sku', true);
                $samples_no_cat[] = "ID:$pid SKU:$sku " . get_the_title($pid);
            }
        } else {
            $only_uncat = true;
            foreach ($terms as $tt) {
                if ($tt->slug !== 'uncategorized') {
                    $only_uncat = false;
                    break;
                }
            }
            if ($only_uncat) {
                $uncategorized_only++;
                if (count($samples_no_cat) < 10) {
                    $sku = get_post_meta($pid, '_sku', true);
                    $samples_no_cat[] = "ID:$pid SKU:$sku " . get_the_title($pid) . " [uncategorized]";
                }
            } else {
                $properly_assigned++;
            }
        }
    }
    echo "Total products: " . count($all_products) . "\n";
    echo "Properly categorized: $properly_assigned\n";
    echo "No category: $no_cat\n";
    echo "Uncategorized only: $uncategorized_only\n";
    if (!empty($samples_no_cat)) {
        echo "\nSamples needing categories:\n";
        foreach ($samples_no_cat as $s) echo "  $s\n";
    }
    break;

// ===== STEP 3: CHECK IMAGE ASSIGNMENTS =====
case 'check-images':
    $all_products = get_posts(['post_type' => 'product', 'posts_per_page' => -1, 'post_status' => 'any', 'fields' => 'ids']);
    $with_image = 0;
    $no_image = 0;
    $broken_image = 0;
    $samples_missing = [];
    
    foreach ($all_products as $pid) {
        $thumb_id = get_post_thumbnail_id($pid);
        if (!$thumb_id) {
            $no_image++;
            if (count($samples_missing) < 20) {
                $sku = get_post_meta($pid, '_sku', true);
                $samples_missing[] = "ID:$pid SKU:$sku " . get_the_title($pid);
            }
        } else {
            $file = get_attached_file($thumb_id);
            if ($file && file_exists($file)) {
                $with_image++;
            } else {
                $broken_image++;
                if (count($samples_missing) < 20) {
                    $sku = get_post_meta($pid, '_sku', true);
                    $samples_missing[] = "ID:$pid SKU:$sku " . get_the_title($pid) . " [BROKEN: file missing]";
                }
            }
        }
    }
    echo "Total products: " . count($all_products) . "\n";
    echo "With valid image: $with_image\n";
    echo "No image set: $no_image\n";
    echo "Broken image (file missing): $broken_image\n";
    if (!empty($samples_missing)) {
        echo "\nSamples missing images:\n";
        foreach ($samples_missing as $s) echo "  $s\n";
    }
    break;

// ===== STEP 4: FIND AVAILABLE IMAGES =====
case 'find-images':
    $upload_dir = wp_upload_dir();
    echo "Upload dir: " . $upload_dir['basedir'] . "\n\n";
    
    // Count total media attachments
    global $wpdb;
    $total_attachments = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='attachment' AND post_mime_type LIKE 'image/%'");
    echo "Total image attachments in DB: $total_attachments\n";
    
    // Sample some product images
    $products_with_img = $wpdb->get_results("
        SELECT p.ID, p.post_title, pm.meta_value as thumb_id, pm2.meta_value as sku
        FROM {$wpdb->posts} p
        LEFT JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id AND pm.meta_key = '_thumbnail_id'
        LEFT JOIN {$wpdb->postmeta} pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_sku'
        WHERE p.post_type = 'product' AND p.post_status = 'publish'
        AND pm.meta_value IS NOT NULL AND pm.meta_value != ''
        LIMIT 10
    ");
    echo "\nSample products WITH images:\n";
    foreach ($products_with_img as $r) {
        $url = wp_get_attachment_url($r->thumb_id);
        echo "  SKU:{$r->sku} | {$r->post_title} | thumb_id:{$r->thumb_id} | URL: {$url}\n";
    }
    break;

// ===== STEP 5: ASSIGN IMAGES FROM MEDIA LIBRARY =====
case 'assign-images':
    global $wpdb;
    
    // Get all products without thumbnails
    $products_no_img = $wpdb->get_results("
        SELECT p.ID, p.post_title, pm_sku.meta_value as sku
        FROM {$wpdb->posts} p
        LEFT JOIN {$wpdb->postmeta} pm_sku ON p.ID = pm_sku.post_id AND pm_sku.meta_key = '_sku'
        LEFT JOIN {$wpdb->postmeta} pm_thumb ON p.ID = pm_thumb.post_id AND pm_thumb.meta_key = '_thumbnail_id'
        WHERE p.post_type = 'product' AND p.post_status IN ('publish','draft','private')
        AND (pm_thumb.meta_value IS NULL OR pm_thumb.meta_value = '' OR pm_thumb.meta_value = '0')
    ");
    
    echo "Products without images: " . count($products_no_img) . "\n\n";
    
    if (count($products_no_img) == 0) {
        echo "All products have images!\n";
        break;
    }
    
    // Get all category terms for products to find category-based images
    // Build a mapping of subcategory → image_id from products that have images in same subcategory
    $assigned = 0;
    $failed = 0;
    
    foreach ($products_no_img as $product) {
        // Strategy 1: Find image by SKU name match in media library
        $sku = $product->sku;
        $title = $product->post_title;
        
        if ($sku) {
            $img = $wpdb->get_var($wpdb->prepare(
                "SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND post_mime_type LIKE 'image/%%' AND (post_title LIKE %s OR post_name LIKE %s) LIMIT 1",
                '%' . $wpdb->esc_like($sku) . '%',
                '%' . $wpdb->esc_like($sku) . '%'
            ));
            if ($img) {
                set_post_thumbnail($product->ID, $img);
                echo "ASSIGNED (SKU match): {$product->ID} [{$sku}] → img:{$img}\n";
                $assigned++;
                continue;
            }
        }
        
        // Strategy 2: Find by product title similarity
        $title_words = explode(' ', strtolower($title));
        $search_term = implode(' ', array_slice($title_words, 0, 3));
        if ($search_term) {
            $img = $wpdb->get_var($wpdb->prepare(
                "SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND post_mime_type LIKE 'image/%%' AND post_title LIKE %s LIMIT 1",
                '%' . $wpdb->esc_like($search_term) . '%'
            ));
            if ($img) {
                set_post_thumbnail($product->ID, $img);
                echo "ASSIGNED (title match): {$product->ID} [{$sku}] {$title} → img:{$img}\n";
                $assigned++;
                continue;
            }
        }
        
        // Strategy 3: Use same category sibling's image
        $cats = wp_get_post_terms($product->ID, 'product_cat', ['fields' => 'ids']);
        if (!empty($cats)) {
            $cat_id = end($cats); // Use deepest category
            $sibling = $wpdb->get_var($wpdb->prepare(
                "SELECT tr.object_id FROM {$wpdb->term_relationships} tr
                JOIN {$wpdb->postmeta} pm ON tr.object_id = pm.post_id AND pm.meta_key = '_thumbnail_id' AND pm.meta_value != '' AND pm.meta_value != '0'
                WHERE tr.term_taxonomy_id = (SELECT term_taxonomy_id FROM {$wpdb->term_taxonomy} WHERE term_id = %d AND taxonomy = 'product_cat')
                AND tr.object_id != %d
                LIMIT 1",
                $cat_id, $product->ID
            ));
            if ($sibling) {
                $sibling_thumb = get_post_thumbnail_id($sibling);
                if ($sibling_thumb) {
                    set_post_thumbnail($product->ID, $sibling_thumb);
                    echo "ASSIGNED (sibling): {$product->ID} [{$sku}] {$title} → from sibling:{$sibling} img:{$sibling_thumb}\n";
                    $assigned++;
                    continue;
                }
            }
        }
        
        echo "FAILED: {$product->ID} [{$sku}] {$title}\n";
        $failed++;
    }
    
    echo "\nAssigned: $assigned\n";
    echo "Failed: $failed\n";
    break;

// ===== STEP 6: ALT TEXT UPDATE =====
case 'fix-alt-text':
    global $wpdb;
    
    $products = get_posts(['post_type' => 'product', 'posts_per_page' => -1, 'post_status' => 'any', 'fields' => 'ids']);
    $updated = 0;
    
    foreach ($products as $pid) {
        $thumb_id = get_post_thumbnail_id($pid);
        if (!$thumb_id) continue;
        
        $title = get_the_title($pid);
        $cats = wp_get_post_terms($pid, 'product_cat', ['fields' => 'names']);
        $cat_name = !empty($cats) ? end($cats) : 'Products';
        
        $alt = "{$title} in {$cat_name} by Efficient Advertising Dubai";
        
        update_post_meta($thumb_id, '_wp_attachment_image_alt', $alt);
        $updated++;
    }
    echo "Updated alt text for $updated product images\n";
    break;

// ===== STEP 7: CHECK PRODUCT PAGE STRUCTURE =====
case 'check-structure':
    $products = get_posts(['post_type' => 'product', 'posts_per_page' => 20, 'post_status' => 'publish', 'orderby' => 'rand']);
    
    $has_short_desc = 0;
    $has_long_desc = 0;
    $has_features = 0;
    $short_too_long = 0;
    
    foreach ($products as $p) {
        $short = $p->post_excerpt;
        $long = $p->post_content;
        
        if (!empty(trim($short))) {
            $has_short_desc++;
            $word_count = str_word_count(strip_tags($short));
            if ($word_count > 50) $short_too_long++;
        }
        if (!empty(trim($long))) {
            $has_long_desc++;
            if (stripos($long, 'feature') !== false || stripos($long, '<h') !== false) {
                $has_features++;
            }
        }
        
        echo "ID:{$p->ID} | {$p->post_title}\n";
        echo "  Short desc: " . str_word_count(strip_tags($short)) . " words\n";
        echo "  Long desc: " . str_word_count(strip_tags($long)) . " words\n";
        echo "  Has structured sections: " . (stripos($long, '<h') !== false ? 'YES' : 'NO') . "\n\n";
    }
    
    echo "Summary (of 20 sampled):\n";
    echo "  Has short description: $has_short_desc\n";
    echo "  Has long description: $has_long_desc\n";
    echo "  Has structured headings: $has_features\n";
    echo "  Short desc too long (>50 words): $short_too_long\n";
    break;

// ===== STEP 8: SEO CHECK =====
case 'check-seo':
    global $wpdb;
    
    $products = get_posts(['post_type' => 'product', 'posts_per_page' => -1, 'post_status' => 'publish', 'fields' => 'ids']);
    
    $missing_seo_title = 0;
    $missing_meta_desc = 0;
    $has_seo = 0;
    
    foreach ($products as $pid) {
        $seo_title = get_post_meta($pid, '_yoast_wpseo_title', true);
        $meta_desc = get_post_meta($pid, '_yoast_wpseo_metadesc', true);
        
        if (empty($seo_title)) $missing_seo_title++;
        if (empty($meta_desc)) $missing_meta_desc++;
        if (!empty($seo_title) && !empty($meta_desc)) $has_seo++;
    }
    
    echo "Total published products: " . count($products) . "\n";
    echo "Complete SEO (title + meta): $has_seo\n";
    echo "Missing SEO title: $missing_seo_title\n";
    echo "Missing meta description: $missing_meta_desc\n";
    break;

// ===== HOMEPAGE ANALYSIS =====
case 'check-homepage':
    $theme_dir = get_template_directory();
    echo "Theme directory: $theme_dir\n";
    echo "Active theme: " . get_template() . "\n\n";
    
    // Check front-page.php
    $front_page = $theme_dir . '/front-page.php';
    if (file_exists($front_page)) {
        echo "front-page.php exists: YES\n";
        echo "Size: " . filesize($front_page) . " bytes\n";
        echo "First 50 lines:\n";
        $lines = file($front_page);
        foreach (array_slice($lines, 0, 50) as $i => $line) {
            echo ($i+1) . ": " . $line;
        }
    } else {
        echo "front-page.php: NOT FOUND\n";
    }
    break;

default:
    echo "Available actions:\n";
    echo "  analyze-cats - List all categories (new vs old)\n";
    echo "  full-cat-map - Full category mapping analysis\n";
    echo "  delete-old-cats - Delete all old categories\n";
    echo "  rename-cats - Remove -new suffix from slugs\n";
    echo "  check-assignments - Check product category assignments\n";
    echo "  check-images - Check product image assignments\n";
    echo "  find-images - Find available images in media library\n";
    echo "  assign-images - Auto-assign images to products without them\n";
    echo "  fix-alt-text - Update alt text format\n";
    echo "  check-structure - Check product page content structure\n";
    echo "  check-seo - Check SEO fields\n";
    echo "  check-homepage - Analyze homepage template\n";
    break;
}
