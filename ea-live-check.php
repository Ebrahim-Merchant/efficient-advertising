<?php
/**
 * Live page HTML checker - fetches actual rendered pages and checks key elements
 */
define('ABSPATH', __DIR__ . '/');
require_once ABSPATH . 'wp-load.php';

$site = get_site_url();
$pages = [
    'Homepage'  => $site . '/',
    'Category'  => $site . '/product-category/signage/',
    'SubCat'    => $site . '/product-category/signage/3d-illuminated-signage/',
    'Product'   => $site . '/product/office-sign/',
    'Product2'  => $site . '/product/printed-cap/',
    'Contact'   => $site . '/contact-us/',
];

foreach ($pages as $label => $url) {
    echo "=== $label — $url ===\n";

    $ctx = stream_context_create(['http' => ['timeout' => 10, 'header' => 'Host: newefficientadvertising09042026.local']]);
    $html = @file_get_contents($url, false, $ctx);

    if (!$html) {
        echo "  FAIL: Could not fetch page\n\n";
        continue;
    }

    echo "  Size: " . strlen($html) . " bytes\n";

    // Title
    if (preg_match('/<title>([^<]+)<\/title>/i', $html, $m)) {
        echo "  Title: " . trim($m[1]) . "\n";
    } else {
        echo "  Title: MISSING\n";
    }

    // H1
    $h1_count = preg_match_all('/<h1[^>]*>/i', $html);
    echo "  H1 tags: $h1_count\n";

    // Meta description
    if (preg_match('/<meta\s+name=["\']description["\']\s+content=["\']([^"\']+)/i', $html, $m)) {
        echo "  Meta desc: " . substr($m[1], 0, 100) . "...\n";
    } else {
        echo "  Meta desc: NOT FOUND\n";
    }

    // Check for PHP errors
    if (preg_match_all('/(Fatal error|Warning|Notice|Parse error):/i', $html, $errs)) {
        echo "  PHP ERRORS: " . count($errs[0]) . " found!\n";
    } else {
        echo "  PHP errors: NONE\n";
    }

    // Check for product images
    $img_count = preg_match_all('/product-sku-images/i', $html);
    echo "  SKU images ref: $img_count\n";

    // Check for broken image refs (-new slugs)
    if (preg_match('/-new\//i', $html)) {
        echo "  WARNING: Found -new slug reference!\n";
    }

    // Check for WhatsApp CTA
    $wa = (strpos($html, 'wa.me') !== false || strpos($html, 'whatsapp') !== false) ? 'YES' : 'NO';
    echo "  WhatsApp CTA: $wa\n";

    // Check for canonical
    if (preg_match('/<link\s+rel=["\']canonical["\']\s+href=["\']([^"\']+)/i', $html, $m)) {
        echo "  Canonical: " . $m[1] . "\n";
    }

    echo "\n";
}

echo "DONE.\n";
