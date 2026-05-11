<?php
/**
 * Set Yoast SEO descriptions for all product categories
 */
require_once __DIR__ . '/wp-load.php';
global $wpdb;

$action = isset($argv[1]) ? $argv[1] : 'set-cat-seo';

if ($action === 'set-cat-seo') {
    $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false, 'orderby' => 'parent']);

    $updated = 0;
    $skipped = 0;
    foreach ($cats as $cat) {
        if ($cat->slug === 'uncategorized') continue;

        // Check if already has Yoast desc
        $existing = get_term_meta($cat->term_id, '_yoast_wpseo_metadesc', true);
        if (!empty(trim($existing))) {
            $skipped++;
            continue;
        }

        // Build description from category name + context
        $parent_name = '';
        if ($cat->parent) {
            $parent = get_term($cat->parent, 'product_cat');
            if ($parent && !is_wp_error($parent)) {
                $parent_name = $parent->name;
            }
        }

        $name_clean = html_entity_decode($cat->name);
        $parent_clean = html_entity_decode($parent_name);

        if ($parent_clean) {
            $desc = sprintf(
                '%s — premium %s solutions by Efficient Advertising Dubai. In-house production, fast turnaround, and UAE-wide delivery. Get a free quote today.',
                $name_clean, strtolower($parent_clean)
            );
        } else {
            $desc = sprintf(
                '%s services in Dubai by Efficient Advertising. Premium quality in-house production with quick turnaround and delivery across the UAE. Request a free quote.',
                $name_clean
            );
        }

        // Truncate to 155 chars for SEO
        if (strlen($desc) > 155) {
            $desc = substr($desc, 0, 152) . '...';
        }

        update_term_meta($cat->term_id, '_yoast_wpseo_metadesc', $desc);

        // Also set title if missing
        $existing_title = get_term_meta($cat->term_id, '_yoast_wpseo_title', true);
        if (empty(trim($existing_title))) {
            if ($parent_clean) {
                $title = sprintf('%s | %s | Efficient Advertising Dubai', $name_clean, $parent_clean);
            } else {
                $title = sprintf('%s | Efficient Advertising Dubai', $name_clean);
            }
            update_term_meta($cat->term_id, '_yoast_wpseo_title', $title);
        }

        echo "  SET: {$cat->name} (ID={$cat->term_id}) → " . substr($desc, 0, 80) . "...\n";
        $updated++;
    }

    echo "\nDone. Updated: $updated, Skipped (already set): $skipped\n";
}
