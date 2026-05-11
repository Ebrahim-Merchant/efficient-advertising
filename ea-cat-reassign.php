<?php
/**
 * Efficient Advertising - Category Reassignment
 * Maps products from old categories to matching new (Excel-synced) categories
 */
define('ABSPATH', __DIR__ . '/');
define('SHORTINIT', false);
require_once ABSPATH . 'wp-load.php';

$action = $argv[1] ?? 'build-map';

switch ($action) {

case 'build-map':
    // Get all categories
    $all_terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
    
    $new_terms = [];
    $old_terms = [];
    foreach ($all_terms as $t) {
        if (str_ends_with($t->slug, '-new') || $t->slug === 'print-materials') {
            $new_terms[$t->term_id] = $t;
        } elseif ($t->slug !== 'uncategorized') {
            $old_terms[$t->term_id] = $t;
        }
    }
    
    // Build name→new_term mapping (normalize names)
    $new_by_name = [];
    foreach ($new_terms as $t) {
        $clean = strtolower(html_entity_decode($t->name));
        $new_by_name[$clean] = $t;
    }
    
    // Map each old category to a new one
    echo "=== OLD → NEW CATEGORY MAPPING ===\n\n";
    $mapping = [];
    $unmapped = [];
    
    foreach ($old_terms as $ot) {
        $old_name = strtolower(html_entity_decode($ot->name));
        
        // Direct name match
        if (isset($new_by_name[$old_name])) {
            $mapping[$ot->term_id] = $new_by_name[$old_name]->term_id;
            echo "MATCH: [{$ot->term_id}] {$ot->name} → [{$new_by_name[$old_name]->term_id}] {$new_by_name[$old_name]->name}\n";
            continue;
        }
        
        // Fuzzy match - try slug base match
        $old_slug_base = preg_replace('/-new$/', '', $ot->slug);
        foreach ($new_terms as $nt) {
            $new_slug_base = preg_replace('/-new$/', '', $nt->slug);
            if ($old_slug_base === $new_slug_base) {
                $mapping[$ot->term_id] = $nt->term_id;
                echo "SLUG MATCH: [{$ot->term_id}] {$ot->name} ({$ot->slug}) → [{$nt->term_id}] {$nt->name} ({$nt->slug})\n";
                continue 2;
            }
        }
        
        // Try partial name matching
        $best_match = null;
        $best_score = 0;
        foreach ($new_terms as $nt) {
            $new_name = strtolower(html_entity_decode($nt->name));
            similar_text($old_name, $new_name, $score);
            if ($score > $best_score && $score > 60) {
                $best_score = $score;
                $best_match = $nt;
            }
        }
        
        if ($best_match) {
            $mapping[$ot->term_id] = $best_match->term_id;
            echo "FUZZY ({$best_score}%): [{$ot->term_id}] {$ot->name} → [{$best_match->term_id}] {$best_match->name}\n";
        } else {
            // Check if parent matches and try to map to parent
            if ($ot->parent > 0 && isset($mapping[$ot->parent])) {
                $parent_new_id = $mapping[$ot->parent];
                $mapping[$ot->term_id] = $parent_new_id;
                echo "PARENT FALLBACK: [{$ot->term_id}] {$ot->name} → parent [{$parent_new_id}] {$new_terms[$parent_new_id]->name}\n";
            } else {
                $unmapped[] = $ot;
                echo "UNMAPPED: [{$ot->term_id}] {$ot->name} ({$ot->slug}, {$ot->count} products)\n";
            }
        }
    }
    
    echo "\n=== SUMMARY ===\n";
    echo "Mapped: " . count($mapping) . " old→new\n";
    echo "Unmapped: " . count($unmapped) . "\n";
    
    // For unmapped, suggest best parent category
    if (!empty($unmapped)) {
        echo "\n=== SUGGESTED MAPPINGS FOR UNMAPPED ===\n";
        foreach ($unmapped as $ut) {
            echo "\n  [{$ut->term_id}] {$ut->name} ({$ut->count} products)\n";
            echo "  Suggest mapping to: ";
            // Try to find by keyword
            $words = explode(' ', strtolower(html_entity_decode($ut->name)));
            foreach ($new_terms as $nt) {
                $new_name_lower = strtolower($nt->name);
                foreach ($words as $w) {
                    if (strlen($w) > 3 && strpos($new_name_lower, $w) !== false) {
                        echo "[{$nt->term_id}] {$nt->name} (keyword: $w)\n";
                        continue 3;
                    }
                }
            }
            echo "NO SUGGESTION - needs manual mapping\n";
        }
    }
    
    // Save mapping to file for use by reassign action
    file_put_contents(__DIR__ . '/cat-mapping.json', json_encode($mapping));
    echo "\nMapping saved to cat-mapping.json\n";
    break;

case 'reassign':
    // Load mapping
    $mapping = json_decode(file_get_contents(__DIR__ . '/cat-mapping.json'), true);
    if (!$mapping) {
        echo "ERROR: Run 'build-map' first\n";
        break;
    }
    
    // Get new category term IDs
    $all_terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
    $new_term_ids = [];
    foreach ($all_terms as $t) {
        if (str_ends_with($t->slug, '-new') || $t->slug === 'print-materials') {
            $new_term_ids[$t->term_id] = true;
        }
    }
    
    // Process all products
    $all_products = get_posts(['post_type' => 'product', 'posts_per_page' => -1, 'post_status' => 'any', 'fields' => 'ids']);
    
    $reassigned = 0;
    $already_ok = 0;
    $no_mapping = 0;
    $errors = [];
    
    foreach ($all_products as $pid) {
        $current_terms = wp_get_post_terms($pid, 'product_cat', ['fields' => 'ids']);
        
        // Check if already has new categories only
        $has_old = false;
        $has_new = false;
        $old_ids = [];
        $new_ids = [];
        
        foreach ($current_terms as $tid) {
            if (isset($new_term_ids[$tid])) {
                $has_new = true;
                $new_ids[] = $tid;
            } else {
                $has_old = true;
                $old_ids[] = $tid;
            }
        }
        
        if (!$has_old) {
            $already_ok++;
            continue;
        }
        
        // Map old categories to new ones
        $target_new_ids = $new_ids; // Keep any existing new cats
        foreach ($old_ids as $old_id) {
            if (isset($mapping[$old_id])) {
                $target_new_ids[] = $mapping[$old_id];
            }
        }
        
        $target_new_ids = array_unique(array_map('intval', $target_new_ids));
        
        if (empty($target_new_ids)) {
            $no_mapping++;
            $sku = get_post_meta($pid, '_sku', true);
            $errors[] = "ID:$pid SKU:$sku " . get_the_title($pid) . " - no mapping for cats: " . implode(',', $old_ids);
            continue;
        }
        
        // Also add parent categories
        $final_ids = $target_new_ids;
        foreach ($target_new_ids as $tid) {
            $term = get_term($tid, 'product_cat');
            if ($term && $term->parent > 0) {
                $final_ids[] = $term->parent;
            }
        }
        $final_ids = array_unique(array_map('intval', $final_ids));
        
        // Set new categories (replaces all old ones)
        wp_set_post_terms($pid, $final_ids, 'product_cat');
        $reassigned++;
    }
    
    echo "Total products: " . count($all_products) . "\n";
    echo "Reassigned: $reassigned\n";
    echo "Already OK: $already_ok\n";
    echo "No mapping found: $no_mapping\n";
    
    if (!empty($errors)) {
        echo "\nProducts without mapping:\n";
        foreach (array_slice($errors, 0, 20) as $e) echo "  $e\n";
    }
    break;

case 'verify':
    // After reassignment, verify state
    $all_terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
    $new_terms = [];
    foreach ($all_terms as $t) {
        if (str_ends_with($t->slug, '-new') || $t->slug === 'print-materials') {
            $new_terms[$t->term_id] = $t;
        }
    }
    
    $all_products = get_posts(['post_type' => 'product', 'posts_per_page' => -1, 'post_status' => 'any', 'fields' => 'ids']);
    $in_new = 0;
    $in_old = 0;
    $in_both = 0;
    $no_cat = 0;
    
    foreach ($all_products as $pid) {
        $terms = wp_get_post_terms($pid, 'product_cat', ['fields' => 'ids']);
        if (empty($terms)) {
            $no_cat++;
            continue;
        }
        $has_new = false;
        $has_old = false;
        foreach ($terms as $tid) {
            if (isset($new_terms[$tid])) $has_new = true;
            else if ($tid != 61) $has_old = true; // 61 = uncategorized
        }
        if ($has_new && $has_old) $in_both++;
        elseif ($has_new) $in_new++;
        elseif ($has_old) $in_old++;
        else $no_cat++;
    }
    
    echo "Products in new categories only: $in_new\n";
    echo "Products in old categories only: $in_old\n";
    echo "Products in both: $in_both\n";
    echo "No category: $no_cat\n";
    
    // Show new category counts
    echo "\n=== NEW CATEGORY PRODUCT COUNTS ===\n";
    $updated_terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
    foreach ($updated_terms as $t) {
        if (str_ends_with($t->slug, '-new') || $t->slug === 'print-materials') {
            // Recount
            $count = 0;
            foreach ($all_products as $pid) {
                $pterms = wp_get_post_terms($pid, 'product_cat', ['fields' => 'ids']);
                if (in_array($t->term_id, $pterms)) $count++;
            }
            if ($t->parent == 0) {
                echo "PARENT [{$t->term_id}] {$t->name}: $count products\n";
            }
        }
    }
    break;

default:
    echo "Actions: build-map, reassign, verify\n";
}
