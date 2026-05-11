<?php
require_once('wp-load.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

$folder = 'C:\Users\merch\OneDrive\Edge Browser\drive-download-20260405T224013Z-1-001';
$files = glob($folder . '\*.{jpg,jpeg,png,webp}', GLOB_BRACE);

if (empty($files)) {
    die("No images found in folder: $folder\n");
}

echo "Found " . count($files) . " images in local folder.\n";

$count_success = 0;
$count_updated = 0;
$count_failed = 0;

foreach ($files as $filepath) {
    if(!file_exists($filepath)) continue;

    $filename = basename($filepath);
    $info = pathinfo($filename);
    
    $clean_name = preg_replace('/\s*\(\d+\)$/', '', $info['filename']); 
    $sku = sanitize_title($clean_name);
    $title = ucwords(str_replace(['-', '_'], ' ', $clean_name));
    
    $existing = wc_get_product_id_by_sku($sku);
    $post_id = 0;
    
    if($existing) {
        $post_id = $existing;
        // Check if the current thumbnail is already this file
        $thumb_id = get_post_thumbnail_id($post_id);
        if ($thumb_id) {
            $thumb_url = wp_get_attachment_url($thumb_id);
            if (strpos($thumb_url, $filename) !== false) {
                echo "[~] $sku already has $filename attached. Skipping...\n";
                continue;
            }
        }
        echo "[~] Updating existing product '$sku' ($post_id) with new WebP image...\n";
    } else {
        $post_id = wp_insert_post([
            'post_title'   => $title,
            'post_status'  => 'publish',
            'post_type'    => 'product',
        ]);
        update_post_meta($post_id, '_sku', $sku);
    }
    
    $tmp_name = wp_tempnam($filename);
    copy($filepath, $tmp_name);
    
    $file_array = array(
        'name'     => $filename,
        'tmp_name' => $tmp_name
    );
    
    $attachment_id = media_handle_sideload( $file_array, $post_id );
    if( is_wp_error($attachment_id) ) {
        echo "[- $sku -] Failed attaching image: " . $attachment_id->get_error_message() . "\n";
        @unlink($tmp_name);
        $count_failed++;
    } else {
        set_post_thumbnail($post_id, $attachment_id);
        
        $prefix = strtoupper(substr($clean_name, 0, 2));
        $category_slug = '';
        if ($prefix === 'PS') $category_slug = 'print-stationery';
        if ($prefix === 'OB') $category_slug = 'office-retail-branding';
        if ($prefix === 'FL') $category_slug = 'flags';
        if ($prefix === 'VB') $category_slug = 'vehicle-branding';
        
        if ($category_slug) {
            wp_set_object_terms( $post_id, $category_slug, 'product_cat' );
        }
        
        if($existing) {
            $count_updated++;
            echo "[^] Updated $sku with new image.\n";
        } else {
            $count_success++;
            echo "[+] Created new product $sku.\n";
        }
    }
    
    // Clear memory caches so the script doesn't crash on 300 items
    wp_cache_flush();
    gc_collect_cycles();
}

echo "\n==============================\n";
echo "PROCESS COMPLETE\n";
echo "Created: $count_success\n";
echo "Updated: $count_updated\n";
echo "Failed: $count_failed\n";
