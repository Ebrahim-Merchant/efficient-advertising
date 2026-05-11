<?php

declare(strict_types=1);

$csvPath = dirname(__DIR__, 3) . '/woo_products_import.csv';
$imageRoot = 'G:/My Drive/Website Images';
$outCsv = __DIR__ . '/sku-image-map.csv';
$ignorePath = __DIR__ . '/sku-ignore-list.txt';

if (!is_file($csvPath) || !is_dir($imageRoot)) {
    fwrite(STDERR, "Missing input files\n");
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

$imageLookup = [];
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($imageRoot, FilesystemIterator::SKIP_DOTS));
foreach ($it as $file) {
    if (!$file->isFile()) {
        continue;
    }
    $ext = strtolower($file->getExtension());
    if (!in_array($ext, ['webp', 'jpg', 'jpeg', 'png'], true)) {
        continue;
    }
    $base = strtoupper(pathinfo($file->getFilename(), PATHINFO_FILENAME));
    if (!isset($imageLookup[$base])) {
        $imageLookup[$base] = $file->getPathname();
    }
}

$in = fopen($csvPath, 'rb');
$headers = fgetcsv($in, 0, ',', '"', '\\');
$skuIdx = array_search('SKU', $headers, true);
$nameIdx = array_search('Name', $headers, true);
$catIdx = array_search('Categories', $headers, true);

if ($skuIdx === false) {
    fwrite(STDERR, "SKU column not found\n");
    exit(1);
}

$out = fopen($outCsv, 'wb');
fputcsv($out, ['sku', 'name', 'categories', 'image_path', 'status'], ',', '"', '\\');

$total = 0;
$missing = 0;
$ignored = 0;

while (($row = fgetcsv($in, 0, ',', '"', '\\')) !== false) {
    $sku = strtoupper(trim((string)($row[$skuIdx] ?? '')));
    if ($sku === '') {
        continue;
    }

    $total++;
    $name = trim((string)($row[$nameIdx] ?? ''));
    $cat = trim((string)($row[$catIdx] ?? ''));

    $img = $imageLookup[$sku] ?? '';
    if ($img !== '') {
        $status = 'matched';
    } elseif (isset($ignoredSkus[$sku])) {
        $status = 'ignored';
        $ignored++;
    } else {
        $status = 'missing';
        $missing++;
    }

    fputcsv($out, [$sku, $name, $cat, $img, $status], ',', '"', '\\');
}

fclose($in);
fclose($out);

echo "WROTE {$outCsv}\n";
echo "TOTAL={$total}\n";
echo "MISSING={$missing}\n";
echo "IGNORED={$ignored}\n";
