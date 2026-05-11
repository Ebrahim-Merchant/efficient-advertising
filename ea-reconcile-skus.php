<?php
require_once('wp-load.php');

// --- LIVE DB SKUs ---
$products = get_posts([
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'fields'         => 'ids',
]);

$live_skus = [];
$blank_sku_products = [];

foreach ($products as $id) {
    $sku = get_post_meta($id, '_sku', true);
    if ($sku) {
        $live_skus[] = $sku;
    } else {
        $blank_sku_products[] = get_the_title($id);
    }
}

// --- IMPORT FILE SKUs ---
$file = fopen('woo_products_import.csv', 'r');
$headers = fgetcsv($file);
$sku_idx  = array_search('SKU', $headers);
$type_idx = array_search('Type', $headers);

$import_skus = [];
while (($row = fgetcsv($file)) !== false) {
    $type = isset($row[$type_idx]) ? trim($row[$type_idx]) : '';
    $sku  = isset($row[$sku_idx])  ? trim($row[$sku_idx])  : '';
    // Exclude variations — only count simple/variable parent products
    if ($type !== 'variation' && $sku !== '') {
        $import_skus[] = $sku;
    }
}
fclose($file);

$unique_live   = array_unique($live_skus);
$unique_import = array_unique($import_skus);

$in_import_not_live = array_diff($unique_import, $unique_live);
$in_live_not_import = array_diff($unique_live, $unique_import);

echo "=== PRODUCT COUNT RECONCILIATION ===\n\n";
echo "Live DB — Total Published Products : " . count($products) . "\n";
echo "Live DB — Products WITH a SKU      : " . count($unique_live) . "\n";
echo "Live DB — Products with BLANK SKU  : " . count($blank_sku_products) . "\n\n";
echo "Import File — Total Parent Products: " . count($unique_import) . "\n\n";
echo "--- DISCREPANCY ANALYSIS ---\n";
echo "In Import NOT in Live DB (" . count($in_import_not_live) . "): \n";
foreach (array_slice($in_import_not_live, 0, 20) as $s) echo "  MISSING: $s\n";
if (count($in_import_not_live) > 20) echo "  ... and " . (count($in_import_not_live) - 20) . " more\n";

echo "\nIn Live DB NOT in Import (" . count($in_live_not_import) . "): \n";
foreach (array_slice($in_live_not_import, 0, 20) as $s) echo "  EXTRA: $s\n";
if (count($in_live_not_import) > 20) echo "  ... and " . (count($in_live_not_import) - 20) . " more\n";

echo "\nBlank SKU Products (first 20):\n";
foreach (array_slice($blank_sku_products, 0, 20) as $t) echo "  NO-SKU: $t\n";
if (count($blank_sku_products) > 20) echo "  ... and " . (count($blank_sku_products) - 20) . " more\n";
?>
