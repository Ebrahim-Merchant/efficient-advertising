<?php
/**
 * Fix ALL _wp_attached_file meta that still contain absolute paths.
 * The correct value should be just: product-sku-images/FILENAME.webp
 */
define('ABSPATH', __DIR__ . '/');
require_once ABSPATH . 'wp-load.php';
global $wpdb;

// Find all _wp_attached_file meta that contain absolute paths or drive letters
$rows = $wpdb->get_results("
    SELECT post_id, meta_value 
    FROM {$wpdb->postmeta} 
    WHERE meta_key = '_wp_attached_file'
    AND (meta_value LIKE '%:%' OR meta_value LIKE '%//%')
");

echo "Found " . count($rows) . " attachment records with absolute paths\n";

$fixed = 0;
$errors = 0;
foreach ($rows as $r) {
    // Extract just the filename
    $basename = basename($r->meta_value);
    // Determine subdirectory - should be product-sku-images/ for SKU images
    if (strpos($r->meta_value, 'product-sku-images') !== false) {
        $new_value = 'product-sku-images/' . $basename;
    } else {
        // For other uploads, extract the year/month path or just use basename
        if (preg_match('#uploads/(\d{4}/\d{2}/.+)$#', $r->meta_value, $m)) {
            $new_value = $m[1];
        } else {
            $new_value = $basename;
        }
    }
    
    $result = $wpdb->update(
        $wpdb->postmeta,
        ['meta_value' => $new_value],
        ['post_id' => $r->post_id, 'meta_key' => '_wp_attached_file'],
        ['%s'],
        ['%d', '%s']
    );
    
    if ($result !== false) {
        $fixed++;
    } else {
        echo "ERROR fixing post_id {$r->post_id}: {$wpdb->last_error}\n";
        $errors++;
    }
}

echo "Fixed: $fixed\n";
echo "Errors: $errors\n";

// Verify 5 random samples
echo "\n=== VERIFICATION (5 random products) ===\n";
$samples = $wpdb->get_results("
    SELECT p.ID, p.post_title, 
           sku.meta_value as sku,
           thumb.meta_value as thumb_id
    FROM {$wpdb->posts} p
    LEFT JOIN {$wpdb->postmeta} sku ON p.ID = sku.post_id AND sku.meta_key = '_sku'
    LEFT JOIN {$wpdb->postmeta} thumb ON p.ID = thumb.post_id AND thumb.meta_key = '_thumbnail_id'
    WHERE p.post_type = 'product' AND p.post_status = 'publish'
    AND thumb.meta_value IS NOT NULL
    ORDER BY RAND() LIMIT 5
");

foreach ($samples as $s) {
    $file_meta = get_post_meta($s->thumb_id, '_wp_attached_file', true);
    $full_path = wp_get_upload_dir()['basedir'] . '/' . $file_meta;
    $exists = file_exists($full_path) ? 'YES' : 'NO';
    echo "Product {$s->ID} | SKU: {$s->sku} | {$s->post_title}\n";
    echo "  _wp_attached_file = $file_meta\n";
    echo "  Full path = $full_path\n";
    echo "  Exists: $exists\n\n";
}
