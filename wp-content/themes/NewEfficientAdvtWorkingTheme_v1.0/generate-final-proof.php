<?php

declare(strict_types=1);

$_SERVER['HTTP_HOST'] = 'newefficientadvertising09042026.local';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['REQUEST_METHOD'] = 'GET';

require_once dirname(__DIR__, 3) . '/wp-load.php';

$out = __DIR__ . '/FINAL_PROOF_REPORT.md';
$mapCsv = __DIR__ . '/sku-image-map.csv';

$lines = [];
$lines[] = '# FINAL PROOF REPORT';
$lines[] = '';
$lines[] = 'Date: ' . date('Y-m-d H:i:s');
$lines[] = '';
$lines[] = '## Canonical Environment';
$lines[] = '- Site: http://newefficientadvertising09042026.local';
$lines[] = '- Theme: wp-content/themes/NewEfficientAdvtWorkingTheme_v1.0';
$lines[] = '- Canonical homepage template: index.php (forced by theme routing hooks)';
$lines[] = '';

$lines[] = '## SKU to Image Mapping Sample';
if (is_file($mapCsv)) {
    $fh = fopen($mapCsv, 'rb');
    $headers = fgetcsv($fh, 0, ',', '"', '\\');
    $idxSku = array_search('sku', $headers, true);
    $idxImage = array_search('image_path', $headers, true);
    $idxStatus = array_search('status', $headers, true);
    $count = 0;
    while (($r = fgetcsv($fh, 0, ',', '"', '\\')) !== false && $count < 15) {
        if (($r[$idxStatus] ?? '') !== 'matched') continue;
        $lines[] = '- ' . ($r[$idxSku] ?? '') . ' -> ' . basename((string)($r[$idxImage] ?? ''));
        $count++;
    }
    fclose($fh);
}
$lines[] = '';

$lines[] = '## Alt Text Samples';
$products = get_posts([
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 10,
    'orderby' => 'date',
    'order' => 'DESC',
]);
$altCount = 0;
foreach ($products as $p) {
    $thumb = (int)get_post_thumbnail_id($p->ID);
    if ($thumb <= 0) continue;
    $alt = trim((string)get_post_meta($thumb, '_wp_attachment_image_alt', true));
    if ($alt === '') continue;
    $lines[] = '- ' . get_post_meta($p->ID, '_sku', true) . ' | ' . $p->post_title . ' | ' . $alt;
    $altCount++;
    if ($altCount >= 8) break;
}
$lines[] = '';

$lines[] = '## Short Intro Samples';
$introCount = 0;
foreach ($products as $p) {
    $sku = (string)get_post_meta($p->ID, '_sku', true);
    if ($sku === '') continue;
    $excerpt = trim(wp_strip_all_tags((string)$p->post_excerpt));
    if ($excerpt === '') continue;
    $wordCount = str_word_count($excerpt);
    $lines[] = '- ' . $sku . ' | words=' . $wordCount . ' | ' . $excerpt;
    $introCount++;
    if ($introCount >= 8) break;
}
$lines[] = '';

$lines[] = '## SEO Title + Meta Samples';
$seoCount = 0;
foreach ($products as $p) {
    $sku = (string)get_post_meta($p->ID, '_sku', true);
    if ($sku === '') continue;
    $title = (string)get_post_meta($p->ID, '_yoast_wpseo_title', true);
    $meta = (string)get_post_meta($p->ID, '_yoast_wpseo_metadesc', true);
    if ($title === '' && $meta === '') continue;
    $lines[] = '- ' . $sku . ' | title: ' . $title . ' | meta: ' . $meta;
    $seoCount++;
    if ($seoCount >= 8) break;
}
$lines[] = '';

$lines[] = '## Mobile QA Note';
$lines[] = '- Interactive mobile checks done in browser-emulated viewport.';
$lines[] = '- Physical real-device validation remains a final human QA step.';
$lines[] = '';

file_put_contents($out, implode(PHP_EOL, $lines));
echo 'WROTE=' . $out . PHP_EOL;
