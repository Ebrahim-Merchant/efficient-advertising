<?php
/**
 * Identify extra products not in Excel sync
 */
define('ABSPATH', __DIR__ . '/');
define('SHORTINIT', false);
require_once ABSPATH . 'wp-load.php';

global $wpdb;

// Get all product IDs from sync report 
$sync_file = __DIR__ . '/wp-content/themes/NewEfficientAdvtWorkingTheme_v1.0/master-sync-report.json';
$sync = json_decode(file_get_contents($sync_file), true);

// The sync report only has 8 samples. Get synced product IDs by SKU prefix
// All synced products have SKUs like PS-001, BLF-001, etc.
$all_products = get_posts(['post_type' => 'product', 'posts_per_page' => -1, 'post_status' => 'any']);

$with_sku = 0;
$without_sku = 0;
$no_sku_list = [];

foreach ($all_products as $p) {
    $sku = get_post_meta($p->ID, '_sku', true);
    if (!empty($sku)) {
        $with_sku++;
    } else {
        $without_sku++;
        $cats = wp_get_post_terms($p->ID, 'product_cat', ['fields' => 'names']);
        $no_sku_list[] = [
            'id' => $p->ID,
            'title' => $p->post_title,
            'status' => $p->post_status,
            'cats' => implode(', ', $cats),
        ];
    }
}

echo "Total products: " . count($all_products) . "\n";
echo "With SKU (from Excel): $with_sku\n";
echo "Without SKU (extra): $without_sku\n\n";

if (!empty($no_sku_list)) {
    echo "Products WITHOUT SKU:\n";
    foreach ($no_sku_list as $p) {
        echo "  ID:{$p['id']} | {$p['title']} | Status:{$p['status']} | Cats:{$p['cats']}\n";
    }
}

// Also check for duplicate products (same title)
echo "\n\n=== DUPLICATE TITLE CHECK ===\n";
$titles = [];
foreach ($all_products as $p) {
    $titles[$p->post_title][] = $p->ID;
}
$dupes = array_filter($titles, fn($ids) => count($ids) > 1);
echo "Products with duplicate titles: " . count($dupes) . "\n";
if (!empty($dupes)) {
    foreach (array_slice($dupes, 0, 20) as $title => $ids) {
        echo "  '{$title}' → IDs: " . implode(', ', $ids) . "\n";
    }
}
