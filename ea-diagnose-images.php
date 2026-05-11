<?php
/**
 * Diagnose image path issues
 */
define('ABSPATH', __DIR__ . '/');
define('SHORTINIT', false);
require_once ABSPATH . 'wp-load.php';

global $wpdb;

// Check a few products' image attachment paths
$products = get_posts(['post_type' => 'product', 'posts_per_page' => 10, 'post_status' => 'publish']);
echo "=== IMAGE PATH DIAGNOSIS ===\n\n";

foreach ($products as $p) {
    $sku = get_post_meta($p->ID, '_sku', true);
    $thumb_id = get_post_thumbnail_id($p->ID);
    echo "Product: {$p->ID} | SKU: {$sku} | {$p->post_title}\n";
    
    if (!$thumb_id) {
        echo "  No thumbnail ID set\n\n";
        continue;
    }
    
    $file = get_attached_file($thumb_id);
    $url = wp_get_attachment_url($thumb_id);
    $metadata = wp_get_attachment_metadata($thumb_id);
    
    echo "  Thumb ID: {$thumb_id}\n";
    echo "  get_attached_file: {$file}\n";
    echo "  File exists: " . (file_exists($file) ? 'YES' : 'NO') . "\n";
    echo "  URL: {$url}\n";
    
    // Check the _wp_attached_file meta
    $meta_file = get_post_meta($thumb_id, '_wp_attached_file', true);
    echo "  _wp_attached_file meta: {$meta_file}\n";
    
    // Build expected path
    $upload_dir = wp_upload_dir();
    $expected = $upload_dir['basedir'] . '/' . $meta_file;
    echo "  Expected path: {$expected}\n";
    echo "  Expected exists: " . (file_exists($expected) ? 'YES' : 'NO') . "\n";
    
    // Try to find the actual file
    if (!file_exists($expected) && !empty($sku)) {
        $sku_lower = strtolower($sku);
        $sku_file = $upload_dir['basedir'] . '/product-sku-images/' . $sku_lower . '.webp';
        echo "  SKU-based path: {$sku_file}\n";
        echo "  SKU file exists: " . (file_exists($sku_file) ? 'YES' : 'NO') . "\n";
    }
    echo "\n";
}

// Also check what the attachment records look like
echo "\n=== SAMPLE ATTACHMENT RECORDS ===\n";
$attachments = $wpdb->get_results("
    SELECT p.ID, p.post_title, pm.meta_value as file_path
    FROM {$wpdb->posts} p
    JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id AND pm.meta_key = '_wp_attached_file'
    WHERE p.post_type = 'attachment' 
    AND pm.meta_value LIKE '%product-sku-images%'
    LIMIT 10
");
foreach ($attachments as $a) {
    $full_path = wp_upload_dir()['basedir'] . '/' . $a->file_path;
    echo "  Attachment {$a->ID}: {$a->file_path} | exists: " . (file_exists($full_path) ? 'YES' : 'NO') . "\n";
}

// Count attachments pointing to product-sku-images that exist
echo "\n\n=== ATTACHMENT FILE STATUS ===\n";
$all_sku_attachments = $wpdb->get_results("
    SELECT p.ID, pm.meta_value as file_path
    FROM {$wpdb->posts} p
    JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id AND pm.meta_key = '_wp_attached_file'
    WHERE p.post_type = 'attachment' 
    AND pm.meta_value LIKE '%product-sku-images%'
");
$exists = 0;
$missing = 0;
$base = wp_upload_dir()['basedir'];
foreach ($all_sku_attachments as $a) {
    if (file_exists($base . '/' . $a->file_path)) {
        $exists++;
    } else {
        $missing++;
    }
}
echo "SKU image attachments: " . count($all_sku_attachments) . "\n";
echo "Files exist: $exists\n";
echo "Files missing: $missing\n";

// Check what other image sources exist
echo "\n\n=== OTHER IMAGE DIRECTORIES ===\n";
$dirs = ['ali_product_images', '2022', '2024', '2025', '2026'];
foreach ($dirs as $d) {
    $path = $base . '/' . $d;
    if (is_dir($path)) {
        $count = 0;
        $iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        foreach ($iter as $f) {
            if ($f->isFile() && preg_match('/\.(jpg|jpeg|png|webp|gif)$/i', $f->getFilename())) {
                $count++;
            }
        }
        echo "  $d: $count images\n";
    }
}
