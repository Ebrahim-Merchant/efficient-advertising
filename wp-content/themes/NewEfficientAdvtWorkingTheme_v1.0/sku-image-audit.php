<?php

declare(strict_types=1);

$csvPath = dirname(__DIR__, 3) . '/woo_products_import.csv';
$imageRoot = 'G:/My Drive/Website Images';
$outPath = __DIR__ . '/sku-image-audit.json';
$ignorePath = __DIR__ . '/sku-ignore-list.txt';

if (!is_file($csvPath)) {
    fwrite(STDERR, "Missing CSV: {$csvPath}\n");
    exit(1);
}
if (!is_dir($imageRoot)) {
    fwrite(STDERR, "Missing image root: {$imageRoot}\n");
    exit(1);
}

$ignoredSkus = [];
if (is_file($ignorePath)) {
    $lines = file($ignorePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
    foreach ($lines as $line) {
        $sku = strtoupper(trim((string)$line));
        if ($sku !== '' && !str_starts_with($sku, '#')) {
            $ignoredSkus[$sku] = true;
        }
    }
}

$skuSet = [];
$prefixSkuCounts = [];

$fh = fopen($csvPath, 'rb');
$headers = fgetcsv($fh, 0, ',', '"', '\\');
$skuIdx = array_search('SKU', $headers, true);
if ($skuIdx === false) {
    fwrite(STDERR, "CSV has no SKU column\n");
    exit(1);
}

while (($row = fgetcsv($fh, 0, ',', '"', '\\')) !== false) {
    $sku = strtoupper(trim((string)($row[$skuIdx] ?? '')));
    if ($sku === '') {
        continue;
    }
    $skuSet[$sku] = true;
    if (preg_match('/^([A-Z]{2,3})-\d+$/', $sku, $m)) {
        $prefix = $m[1];
        $prefixSkuCounts[$prefix] = ($prefixSkuCounts[$prefix] ?? 0) + 1;
    }
}
fclose($fh);

$imageSet = [];
$prefixImageCounts = [];
$unmatchedImageNames = [];

$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($imageRoot, FilesystemIterator::SKIP_DOTS));
foreach ($it as $file) {
    if (!$file->isFile()) {
        continue;
    }
    $ext = strtolower($file->getExtension());
    if (!in_array($ext, ['webp', 'jpg', 'jpeg', 'png'], true)) {
        continue;
    }

    $basename = strtoupper(pathinfo($file->getFilename(), PATHINFO_FILENAME));
    $imageSet[$basename] = true;

    if (preg_match('/^([A-Z]{2,3})-\d+$/', $basename, $m)) {
        $prefix = $m[1];
        $prefixImageCounts[$prefix] = ($prefixImageCounts[$prefix] ?? 0) + 1;
    } else {
        $unmatchedImageNames[] = $file->getFilename();
    }
}

$missingImages = [];
$ignoredMissingImages = [];
foreach (array_keys($skuSet) as $sku) {
    if (!isset($imageSet[$sku])) {
        if (isset($ignoredSkus[$sku])) {
            $ignoredMissingImages[] = $sku;
        } else {
            $missingImages[] = $sku;
        }
    }
}
sort($missingImages);
sort($ignoredMissingImages);

$extraImages = [];
foreach (array_keys($imageSet) as $imgSku) {
    if (preg_match('/^[A-Z]{2,3}-\d+$/', $imgSku) && !isset($skuSet[$imgSku])) {
        $extraImages[] = $imgSku;
    }
}
sort($extraImages);

ksort($prefixSkuCounts);
ksort($prefixImageCounts);
sort($unmatchedImageNames);

$report = [
    'csv_path' => $csvPath,
    'image_root' => $imageRoot,
    'ignore_list_path' => $ignorePath,
    'ignored_sku_count' => count($ignoredSkus),
    'ignored_skus' => array_values(array_keys($ignoredSkus)),
    'total_csv_skus' => count($skuSet),
    'total_image_basenames' => count($imageSet),
    'prefix_sku_counts' => $prefixSkuCounts,
    'prefix_image_counts' => $prefixImageCounts,
    'missing_image_count' => count($missingImages),
    'missing_images' => $missingImages,
    'ignored_missing_image_count' => count($ignoredMissingImages),
    'ignored_missing_images' => $ignoredMissingImages,
    'extra_image_count' => count($extraImages),
    'extra_images' => $extraImages,
    'unmatched_image_name_count' => count($unmatchedImageNames),
    'unmatched_image_names_sample' => array_slice($unmatchedImageNames, 0, 100),
];

file_put_contents($outPath, json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "WROTE {$outPath}\n";
echo "CSV_SKUS=" . count($skuSet) . "\n";
echo "IMAGES=" . count($imageSet) . "\n";
echo "MISSING=" . count($missingImages) . "\n";
echo "IGNORED_MISSING=" . count($ignoredMissingImages) . "\n";
echo "EXTRA=" . count($extraImages) . "\n";
