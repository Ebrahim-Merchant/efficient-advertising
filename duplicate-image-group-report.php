<?php
$reportDir = __DIR__ . '/website-cleanup-dump/logs';
if (!is_dir($reportDir) && !mkdir($reportDir, 0777, true) && !is_dir($reportDir)) {
    fwrite(STDERR, "ERROR: Unable to create report directory: $reportDir\n");
    exit(1);
}
$reportFile = $reportDir . '/duplicate-product-image-groups.csv';
$products = wc_get_products(['limit' => -1, 'status' => 'any']);
$totalProducts = count($products);
$imageHashGroups = [];
$featuredImages = 0;
foreach ($products as $product) {
    $id = $product->get_id();
    $image_id = $product->get_image_id();
    if (! $image_id) {
        continue;
    }
    $file = get_attached_file($image_id);
    if (! $file || ! is_file($file)) {
        continue;
    }
    $hash = md5_file($file);
    if ($hash === false) {
        continue;
    }
    $featuredImages++;
    if (! isset($imageHashGroups[$hash])) {
        $imageHashGroups[$hash] = [
            'hash' => $hash,
            'image_attachment_ids' => [],
            'image_file_name' => basename($file),
            'products' => [],
        ];
    }
    $imageHashGroups[$hash]['image_attachment_ids'][$image_id] = $image_id;
    $imageHashGroups[$hash]['products'][] = [
        'id' => $id,
        'name' => $product->get_name(),
        'sku' => $product->get_sku(),
    ];
}
$duplicateGroups = [];
foreach ($imageHashGroups as $hash => $group) {
    if (count($group['products']) > 1) {
        $duplicateGroups[] = $group;
    }
}
$handle = fopen($reportFile, 'w');
if (! $handle) {
    fwrite(STDERR, "ERROR: Unable to open report file: $reportFile\n");
    exit(1);
}
fputcsv($handle, ['group_id', 'image_attachment_id', 'image_file_name', 'image_hash', 'product_count', 'product_ids', 'product_names', 'product_skus', 'recommendation']);
$groupId = 0;
$largestGroupCount = 0;
foreach ($duplicateGroups as $group) {
    $groupId++;
    $productIds = array_map(fn($p) => $p['id'], $group['products']);
    $productNames = array_map(fn($p) => $p['name'], $group['products']);
    $productSkus = array_map(fn($p) => $p['sku'], $group['products']);
    $productCount = count($group['products']);
    $largestGroupCount = max($largestGroupCount, $productCount);
    $attachmentId = reset($group['image_attachment_ids']);
    fputcsv($handle, [
        $groupId,
        $attachmentId,
        $group['image_file_name'],
        $group['hash'],
        $productCount,
        implode('|', $productIds),
        implode('|', $productNames),
        implode('|', $productSkus),
        'Potential variation group - review',
    ]);
}
fclose($handle);
echo "TOTAL_PRODUCTS_SCANNED: $totalProducts\n";
echo "TOTAL_FEATURED_IMAGES_SCANNED: $featuredImages\n";
echo "DUPLICATE_GROUPS_FOUND: " . count($duplicateGroups) . "\n";
echo "LARGEST_DUPLICATE_GROUP_COUNT: $largestGroupCount\n";
echo "REPORT_FILE:$reportFile\n";
