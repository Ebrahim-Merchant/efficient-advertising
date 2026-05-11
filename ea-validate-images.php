<?php
/**
 * Step 5: Validate 10 random product images - file existence + URL generation
 */
define('ABSPATH', __DIR__ . '/');
require_once ABSPATH . 'wp-load.php';
global $wpdb;

$products = $wpdb->get_results("
    SELECT p.ID, p.post_title, sku.meta_value as sku, thumb.meta_value as thumb_id
    FROM {$wpdb->posts} p
    LEFT JOIN {$wpdb->postmeta} sku ON p.ID = sku.post_id AND sku.meta_key = '_sku'
    LEFT JOIN {$wpdb->postmeta} thumb ON p.ID = thumb.post_id AND thumb.meta_key = '_thumbnail_id'
    WHERE p.post_type = 'product' AND p.post_status = 'publish'
    AND thumb.meta_value IS NOT NULL AND thumb.meta_value != ''
    ORDER BY RAND() LIMIT 10
");

echo "=== STEP 5: IMAGE VALIDATION (10 Random Products) ===\n\n";

$pass = 0;
$fail = 0;

foreach ($products as $p) {
    echo "#{$p->ID} | {$p->sku} | {$p->post_title}\n";
    
    // Check _wp_attached_file meta
    $file_meta = get_post_meta($p->thumb_id, '_wp_attached_file', true);
    echo "  _wp_attached_file: $file_meta\n";
    
    // Check actual file on disk
    $full_path = wp_get_upload_dir()['basedir'] . '/' . $file_meta;
    $exists = file_exists($full_path);
    echo "  File exists: " . ($exists ? 'YES' : 'NO') . "\n";
    
    // Check WordPress URL generation
    $url = wp_get_attachment_url($p->thumb_id);
    echo "  WP URL: $url\n";
    
    // Check thumbnail URL via WooCommerce
    $thumb_url = get_the_post_thumbnail_url($p->ID, 'woocommerce_thumbnail');
    echo "  WC Thumbnail URL: $thumb_url\n";
    
    // Check if URL path is correct (no double-path issue)
    $url_has_double = (substr_count($url, 'wp-content/uploads') > 1) ? 'DOUBLE PATH!' : 'OK';
    echo "  URL path check: $url_has_double\n";
    
    if ($exists && $url_has_double === 'OK') {
        echo "  RESULT: PASS ✓\n\n";
        $pass++;
    } else {
        echo "  RESULT: FAIL ✗\n\n";
        $fail++;
    }
}

echo "=== SUMMARY: $pass PASS / $fail FAIL out of 10 ===\n";

// Also check total counts
$total_products = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='product' AND post_status='publish'");
$with_thumb = $wpdb->get_var("
    SELECT COUNT(DISTINCT p.ID) FROM {$wpdb->posts} p
    INNER JOIN {$wpdb->postmeta} thumb ON p.ID = thumb.post_id AND thumb.meta_key = '_thumbnail_id'
    WHERE p.post_type='product' AND p.post_status='publish'
    AND thumb.meta_value IS NOT NULL AND thumb.meta_value != '' AND thumb.meta_value != '0'
");
echo "\nTotal products: $total_products | With thumbnails: $with_thumb | Missing: " . ($total_products - $with_thumb) . "\n";
