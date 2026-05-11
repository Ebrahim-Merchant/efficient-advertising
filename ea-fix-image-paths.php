<?php
/**
 * Fix _wp_attached_file meta paths
 * Problem: Full absolute path stored instead of relative path
 * Fix: Strip uploads base directory prefix to make paths relative
 */
define('ABSPATH', __DIR__ . '/');
define('SHORTINIT', false);
require_once ABSPATH . 'wp-load.php';

global $wpdb;

$upload_dir = wp_upload_dir();
$basedir = str_replace('\\', '/', $upload_dir['basedir']);
echo "Upload basedir: $basedir\n\n";

// Get all attachment file meta values
$attachments = $wpdb->get_results("
    SELECT post_id, meta_value 
    FROM {$wpdb->postmeta} 
    WHERE meta_key = '_wp_attached_file'
");

$fixed = 0;
$already_ok = 0;
$errors = 0;

foreach ($attachments as $a) {
    $path = str_replace('\\', '/', $a->meta_value);
    
    // Check if path contains the absolute uploads directory
    if (strpos($path, $basedir) !== false) {
        // Strip the basedir prefix (and trailing slash)
        $relative = str_replace($basedir . '/', '', $path);
        $relative = str_replace($basedir, '', $relative);
        
        // Verify the file exists at the relative path
        $full_path = $basedir . '/' . $relative;
        
        // Update the meta
        $result = $wpdb->update(
            $wpdb->postmeta,
            ['meta_value' => $relative],
            ['post_id' => $a->post_id, 'meta_key' => '_wp_attached_file']
        );
        
        if ($result !== false) {
            $fixed++;
            if ($fixed <= 5) {
                echo "FIXED: [{$a->post_id}] {$path} → {$relative} (exists: " . (file_exists($full_path) ? 'YES' : 'NO') . ")\n";
            }
        } else {
            $errors++;
        }
    } else {
        $already_ok++;
    }
}

echo "\nFixed: $fixed\n";
echo "Already OK: $already_ok\n";
echo "Errors: $errors\n";

// Verify - sample check
echo "\n=== VERIFICATION ===\n";
$sample_products = get_posts(['post_type' => 'product', 'posts_per_page' => 5, 'post_status' => 'publish']);
foreach ($sample_products as $p) {
    $thumb_id = get_post_thumbnail_id($p->ID);
    if ($thumb_id) {
        // Clear any caches
        wp_cache_delete($thumb_id, 'post_meta');
        clean_post_cache($thumb_id);
        
        $file = get_attached_file($thumb_id);
        $sku = get_post_meta($p->ID, '_sku', true);
        echo "Product {$p->ID} (SKU: $sku): file=" . basename($file) . " exists=" . (file_exists($file) ? 'YES' : 'NO') . "\n";
    }
}
