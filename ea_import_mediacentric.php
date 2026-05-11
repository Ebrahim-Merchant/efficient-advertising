<?php
/**
 * EA Media-Centric Product Importer
 * Prioritizes existing media library items to prevent "junk" and duplication.
 */
require_once('wp-load.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

global $wpdb;

$folder = 'C:\Users\merch\OneDrive\Edge Browser\drive-download-20260405T224013Z-1-001';
$files = glob($folder . '\*.{jpg,jpeg,png,webp}', GLOB_BRACE);

if (empty($files)) {
    die("No images found in folder: $folder\n");
}

echo "Found " . count($files) . " items in local folder. Starting clean import...\n";

$count_new = 0;
$count_updated = 0;
$count_media_reused = 0;
$count_failed = 0;

foreach ($files as $filepath) {
    if(!file_exists($filepath)) continue;

    $filename = basename($filepath);
    $info = pathinfo($filename);
    $clean_base = preg_replace('/\s*\(\d+\)$/', '', $info['filename']); // Remove (1) suffixes
    $sku = sanitize_title($clean_base);
    $title = ucwords(str_replace(['-', '_'], ' ', $clean_base));
    
    // 1. Find or create the product by SKU
    $product_id = wc_get_product_id_by_sku($sku);
    
    // If no product found by SKU, try finding by title to avoid data junk
    if (!$product_id) {
        $existing_post = get_page_by_path($sku, OBJECT, 'product');
        if ($existing_post) {
            $product_id = $existing_post->ID;
            update_post_meta($product_id, '_sku', $sku);
        }
    }

    if (!$product_id) {
        $product_id = wp_insert_post([
            'post_title'   => $title,
            'post_status'  => 'publish',
            'post_type'    => 'product',
        ]);
        update_post_meta($product_id, '_sku', $sku);
        $count_new++;
    } else {
        // Ensure it's published if it was drafted before
        wp_update_post(['ID' => $product_id, 'post_status' => 'publish']);
        $count_updated++;
    }

    // 2. Check Media Library for EXISTING attachment before uploading
    // Match by meta key '_wp_attached_file' containing the filename, OR by title
    $attachment_id = $wpdb->get_var($wpdb->prepare(
        "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_wp_attached_file' AND meta_value LIKE %s LIMIT 1",
        '%' . $filename . '%'
    ));

    if (!$attachment_id) {
        // Fallback check by title/name in the posts table
        $attachment_id = $wpdb->get_var($wpdb->prepare(
            "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND post_name = %s LIMIT 1",
            $sku
        ));
    }

    if ($attachment_id) {
        // Reuse existing media item
        echo "[~] Reusing media ID $attachment_id for $sku\n";
        $count_media_reused++;
    } else {
        // Only sideload if not found
        $tmp_name = wp_tempnam($filename);
        copy($filepath, $tmp_name);
        $file_array = ['name' => $filename, 'tmp_name' => $tmp_name];
        
        $attachment_id = media_handle_sideload($file_array, $product_id);
        if (is_wp_error($attachment_id)) {
            echo "[-] Error uploading $filename: " . $attachment_id->get_error_message() . "\n";
            @unlink($tmp_name);
            $count_failed++;
            continue;
        }
        echo "[+] Uploaded new image for $sku (ID $attachment_id)\n";
    }

    // 3. Set the thumbnail
    set_post_thumbnail($product_id, $attachment_id);

    // 4. Auto-Categorize
    $prefix = strtoupper(substr($sku, 0, 2));
    $cat_slug = '';
    switch($prefix) {
        case 'PS': $cat_slug = 'print-stationery'; break;
        case 'OB': $cat_slug = 'office-retail-branding'; break;
        case 'FL': $cat_slug = 'flags'; break;
        case 'VB': $cat_slug = 'vehicle-branding'; break;
    }
    if ($cat_slug) {
        wp_set_object_terms($product_id, $cat_slug, 'product_cat');
    }

    // Performance cleanup
    wp_cache_flush();
    gc_collect_cycles();
}

echo "\nDone!\nProducts: $count_new new, $count_updated updated.\nMedia: $count_media_reused reused from library.\nErrors: $count_failed.\n";
