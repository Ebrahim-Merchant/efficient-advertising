<?php

declare(strict_types=1);

$_SERVER['HTTP_HOST'] = $_SERVER['HTTP_HOST'] ?? 'newefficientadvertising09042026.local';
$_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] ?? '/';
$_SERVER['SERVER_PORT'] = $_SERVER['SERVER_PORT'] ?? '80';
$_SERVER['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'] ?? 'GET';

require_once dirname(__DIR__, 3) . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

set_time_limit(0);
ini_set('memory_limit', '1024M');

$mapCsv = __DIR__ . '/sku-image-map.csv';
$logJson = __DIR__ . '/sku-image-assign-report.json';

if (!is_file($mapCsv)) {
    fwrite(STDERR, "Missing mapping CSV: {$mapCsv}\n");
    exit(1);
}

function find_attachment_by_relative_path(string $relativePath): int
{
    $q = new WP_Query([
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'posts_per_page' => 1,
        'fields' => 'ids',
        'meta_query' => [[
            'key' => '_wp_attached_file',
            'value' => $relativePath,
            'compare' => '=',
        ]],
    ]);

    return !empty($q->posts) ? (int)$q->posts[0] : 0;
}

function ensure_attachment(string $sourcePath, string $destPath, string $title, string $alt): int
{
    $destDir = dirname($destPath);
    if (!is_dir($destDir) && !wp_mkdir_p($destDir)) {
        return 0;
    }

    if (!file_exists($destPath) && !copy($sourcePath, $destPath)) {
        return 0;
    }

    $upload = wp_upload_dir();
    $relative = ltrim(str_replace(wp_normalize_path($upload['basedir']), '', wp_normalize_path($destPath)), '/');

    $existing = find_attachment_by_relative_path($relative);
    if ($existing > 0) {
        if ($alt !== '') {
            update_post_meta($existing, '_wp_attachment_image_alt', $alt);
        }
        return $existing;
    }

    $filetype = wp_check_filetype(basename($destPath), null);
    $attachment = [
        'post_mime_type' => $filetype['type'] ?: 'image/webp',
        'post_title' => $title,
        'post_status' => 'inherit',
    ];

    $attachmentId = wp_insert_attachment($attachment, $destPath);
    if (is_wp_error($attachmentId) || !$attachmentId) {
        return 0;
    }

    if ($alt !== '') {
        update_post_meta($attachmentId, '_wp_attachment_image_alt', $alt);
    }

    return (int)$attachmentId;
}

$in = fopen($mapCsv, 'rb');
$headers = fgetcsv($in, 0, ',', '"', '\\');
$idxSku = array_search('sku', $headers, true);
$idxName = array_search('name', $headers, true);
$idxImage = array_search('image_path', $headers, true);
$idxStatus = array_search('status', $headers, true);

if ($idxSku === false || $idxImage === false || $idxStatus === false) {
    fclose($in);
    fwrite(STDERR, "Unexpected map CSV columns\n");
    exit(1);
}

$upload = wp_upload_dir();
$destBase = wp_normalize_path($upload['basedir'] . '/product-sku-images');

$stats = [
    'total_rows' => 0,
    'matched_rows' => 0,
    'ignored_rows' => 0,
    'missing_rows' => 0,
    'products_updated' => 0,
    'products_unchanged' => 0,
    'products_not_found' => 0,
    'source_file_missing' => 0,
    'attachment_errors' => 0,
    'sample_product_not_found' => [],
    'sample_missing_source' => [],
];

while (($row = fgetcsv($in, 0, ',', '"', '\\')) !== false) {
    $stats['total_rows']++;
    if ($stats['total_rows'] % 100 === 0) {
        echo 'PROGRESS_ROWS=' . $stats['total_rows'] . "\n";
    }

    $sku = strtoupper(trim((string)($row[$idxSku] ?? '')));
    $name = trim((string)($row[$idxName] ?? ''));
    $imagePath = trim((string)($row[$idxImage] ?? ''));
    $status = strtolower(trim((string)($row[$idxStatus] ?? '')));

    if ($sku === '') {
        continue;
    }

    if ($status === 'ignored') {
        $stats['ignored_rows']++;
        continue;
    }

    if ($status !== 'matched') {
        $stats['missing_rows']++;
        continue;
    }

    $stats['matched_rows']++;

    $productId = (int)wc_get_product_id_by_sku($sku);
    if ($productId <= 0) {
        $stats['products_not_found']++;
        if (count($stats['sample_product_not_found']) < 20) {
            $stats['sample_product_not_found'][] = $sku;
        }
        continue;
    }

    if ($imagePath === '' || !file_exists($imagePath)) {
        $stats['source_file_missing']++;
        if (count($stats['sample_missing_source']) < 20) {
            $stats['sample_missing_source'][] = $sku;
        }
        continue;
    }

    $ext = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
    $ext = $ext !== '' ? $ext : 'webp';
    $destPath = $destBase . '/' . strtolower($sku) . '.' . $ext;

    $attachmentId = ensure_attachment($imagePath, $destPath, $name !== '' ? $name : $sku, $name !== '' ? $name : $sku);
    if ($attachmentId <= 0) {
        $stats['attachment_errors']++;
        continue;
    }

    $currentThumb = (int)get_post_thumbnail_id($productId);
    if ($currentThumb === $attachmentId) {
        $stats['products_unchanged']++;
        continue;
    }

    set_post_thumbnail($productId, $attachmentId);
    $stats['products_updated']++;
}

fclose($in);
wc_delete_product_transients();

file_put_contents($logJson, json_encode($stats, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "WROTE {$logJson}\n";
foreach ($stats as $k => $v) {
    if (is_array($v)) {
        continue;
    }
    echo strtoupper($k) . '=' . $v . "\n";
}
