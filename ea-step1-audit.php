<?php
/**
 * Step 1 Audit: Current DB state — products, categories, images
 */
require_once __DIR__ . '/wp-load.php';
global $wpdb;

$action = isset($argv[1]) ? $argv[1] : 'audit';

// ── AUDIT ──
if ($action === 'audit') {
    echo "=== PRODUCT STATUS ===\n";
    $rows = $wpdb->get_results("SELECT post_status, COUNT(*) as cnt FROM {$wpdb->posts} WHERE post_type='product' GROUP BY post_status ORDER BY cnt DESC");
    $total = 0;
    foreach ($rows as $r) {
        echo "  {$r->post_status}: {$r->cnt}\n";
        $total += $r->cnt;
    }
    echo "  TOTAL: $total\n\n";

    $pub = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='product' AND post_status='publish'");
    echo "Published products: $pub\n\n";

    echo "=== CATEGORIES (product_cat) ===\n";
    $cats = get_terms(['taxonomy'=>'product_cat','hide_empty'=>false,'orderby'=>'parent']);
    $tree = [];
    foreach ($cats as $c) {
        $pname = $c->parent ? get_term($c->parent,'product_cat')->name : '(root)';
        echo sprintf("  ID=%-5d | %-40s | slug=%-45s | parent=%-30s | count=%d\n",
            $c->term_id, $c->name, $c->slug, $pname, $c->count);
    }
    echo "\nTotal categories: " . count($cats) . "\n\n";

    // Products with no thumbnail
    $no_thumb = $wpdb->get_var("
        SELECT COUNT(*) FROM {$wpdb->posts} p
        WHERE p.post_type='product' AND p.post_status='publish'
        AND NOT EXISTS (
            SELECT 1 FROM {$wpdb->postmeta} pm
            WHERE pm.post_id = p.ID AND pm.meta_key = '_thumbnail_id' AND pm.meta_value > 0
        )
    ");
    echo "Published products WITHOUT thumbnail: $no_thumb\n";

    // Products with thumbnail
    $has_thumb = $wpdb->get_var("
        SELECT COUNT(*) FROM {$wpdb->posts} p
        WHERE p.post_type='product' AND p.post_status='publish'
        AND EXISTS (
            SELECT 1 FROM {$wpdb->postmeta} pm
            WHERE pm.post_id = p.ID AND pm.meta_key = '_thumbnail_id' AND pm.meta_value > 0
        )
    ");
    echo "Published products WITH thumbnail: $has_thumb\n\n";

    // Products with SKU
    $has_sku = $wpdb->get_var("
        SELECT COUNT(*) FROM {$wpdb->posts} p
        JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID AND pm.meta_key = '_sku' AND pm.meta_value != ''
        WHERE p.post_type='product' AND p.post_status='publish'
    ");
    echo "Published products WITH SKU: $has_sku\n";

    // Sample 10 products with their categories and image status
    echo "\n=== SAMPLE 10 PRODUCTS ===\n";
    $samples = $wpdb->get_results("
        SELECT p.ID, p.post_title, pm.meta_value as sku
        FROM {$wpdb->posts} p
        LEFT JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID AND pm.meta_key = '_sku'
        WHERE p.post_type='product' AND p.post_status='publish'
        ORDER BY RAND() LIMIT 10
    ");
    foreach ($samples as $s) {
        $cats = wp_get_post_terms($s->ID, 'product_cat', ['fields'=>'names']);
        $thumb_id = get_post_meta($s->ID, '_thumbnail_id', true);
        $thumb_url = $thumb_id ? wp_get_attachment_url($thumb_id) : 'NONE';
        $img_exists = 'N/A';
        if ($thumb_id) {
            $file = get_attached_file($thumb_id);
            $img_exists = ($file && file_exists($file)) ? 'YES' : 'MISSING_FILE';
        }
        echo sprintf("  ID=%-6d SKU=%-15s | %-50s | cats=%s | img=%s (%s)\n",
            $s->ID, $s->sku ?: '(none)', $s->post_title,
            implode(', ', $cats), $thumb_url ? 'SET' : 'NONE', $img_exists);
    }

    // Check image directory
    $img_dir = WP_CONTENT_DIR . '/uploads/product-sku-images/';
    if (is_dir($img_dir)) {
        $files = glob($img_dir . '*.{webp,jpg,png,jpeg}', GLOB_BRACE);
        echo "\n\nSKU image directory: " . count($files) . " files in $img_dir\n";
    } else {
        echo "\n\nSKU image directory NOT FOUND: $img_dir\n";
    }
}
