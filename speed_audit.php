<?php
/**
 * Speed Audit Tool v1.0
 * Measures: TTFB, Resource Count, CSS/JS Bloat, Image Optimization Status.
 */
require_once('wp-load.php');

echo "<h1>⚡ Speed Audit: Local State</h1>";
echo "<pre>";

$site_url = get_site_url();
echo "Target Site: $site_url\n";
echo "Timestamp: " . date('Y-m-d H:i:s') . "\n";
echo "------------------------------------------\n";

// 1. Measure TTFB (Time to First Byte)
$start = microtime(true);
$response = wp_remote_get($site_url, ['timeout' => 15]);
$end = microtime(true);

if (is_wp_error($response)) {
    echo "❌ Error reaching site: " . $response->get_error_message() . "\n";
} else {
    $ttfb = round(($end - $start) * 1000, 2);
    echo "Time to First Byte (TTFB): {$ttfb}ms\n";
    if ($ttfb < 200) echo "✅ Excellent (<200ms)\n";
    elseif ($ttfb < 500) echo "⚠️ Decent (200-500ms)\n";
    else echo "❌ SLOW (>500ms) - Likely DB or Server overhead.\n";

    $html = wp_remote_retrieve_body($response);
    
    // 2. Count Resources
    preg_match_all('/<script[^>]+src=[\'"]([^\'"]+)[\'"]/', $html, $js_matches);
    preg_match_all('/<link[^>]+rel=[\'"]stylesheet[\'"][^>]+href=[\'"]([^\'"]+)[\'"]/', $html, $css_matches);
    preg_match_all('/<img[^>]+src=[\'"]([^\'"]+)[\'"]/', $html, $img_matches);

    $js_count = count(array_unique($js_matches[1]));
    $css_count = count(array_unique($css_matches[1]));
    $img_count = count($img_matches[1]);

    echo "\nResource Summary:\n";
    echo "- JS Files: $js_count " . ($js_count > 15 ? "❌ Bloated" : "✅ Clean") . "\n";
    echo "- CSS Files: $css_count " . ($css_count > 10 ? "❌ Bloated" : "✅ Clean") . "\n";
    echo "- Images: $img_count\n";

    // 3. Check for specific bloat items
    $bloat_items = ['jquery.js', 'bootstrap', 'owl.carousel', 'font-awesome', 'elementor'];
    echo "\nBloat Check:\n";
    foreach ($bloat_items as $item) {
        if (stripos($html, $item) !== false) {
            echo "⚠️ Found: $item\n";
        }
    }

    // 4. Image Optimization Check
    $lazily_loaded = substr_count($html, 'loading="lazy"');
    $webp_images = substr_count($html, '.webp');
    
    echo "\nOptimization Check:\n";
    echo "- Lazy Loading: " . round(($lazily_loaded / max(1, $img_count)) * 100) . "% of images ($lazily_loaded/$img_count)\n";
    echo "- WebP Usage: " . round(($webp_images / max(1, $img_count)) * 100) . "% ($webp_images/$img_count)\n";

    // 5. DOM Size estimation
    $dom_size = substr_count($html, '<');
    echo "\nEstimated DOM Nodes: $dom_size " . ($dom_size > 1500 ? "❌ High" : "✅ Good") . "\n";
}

echo "------------------------------------------\n";
echo "Audit Complete.";
echo "</pre>";
