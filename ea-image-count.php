<?php
require_once('wp-load.php');

// Get all published products that have a SKU (excluding blank-SKU legacy items)
$products = get_posts([
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'fields'         => 'ids',
    'meta_query'     => [[
        'key'     => '_sku',
        'value'   => '',
        'compare' => '!=',
    ]],
]);

$with_sku = [];
foreach ($products as $id) {
    $sku = get_post_meta($id, '_sku', true);
    // Only count uppercase/new-format SKUs (exclude old lowercase ones)
    if ($sku && $sku === strtoupper($sku)) {
        $with_sku[$id] = $sku;
    }
}

$total_valid     = count($with_sku);
$with_image      = 0;
$without_image   = 0;

foreach ($with_sku as $id => $sku) {
    if (has_post_thumbnail($id)) {
        $with_image++;
    } else {
        $without_image++;
    }
}

echo "=== CLEAN PRODUCT COUNT (Valid SKUs Only) ===\n\n";
echo "Total Valid Products (uppercase SKU format): $total_valid\n";
echo "  -- WITH featured image   : $with_image\n";
echo "  -- WITHOUT featured image: $without_image\n";
echo "\nImage coverage: " . round(($with_image / $total_valid) * 100, 1) . "%\n";
?>
