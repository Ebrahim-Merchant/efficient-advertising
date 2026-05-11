<?php
/**
 * Find products without thumbnail and attempt to assign one based on SKU
 */
define('ABSPATH', __DIR__ . '/');
require_once ABSPATH . 'wp-load.php';
global $wpdb;

// Find published products with no _thumbnail_id
$no_thumb = $wpdb->get_results("
    SELECT p.ID, p.post_title, sku.meta_value as sku
    FROM {$wpdb->posts} p
    LEFT JOIN {$wpdb->postmeta} sku ON p.ID = sku.post_id AND sku.meta_key = '_sku'
    LEFT JOIN {$wpdb->postmeta} thumb ON p.ID = thumb.post_id AND thumb.meta_key = '_thumbnail_id'
    WHERE p.post_type = 'product' AND p.post_status = 'publish'
    AND (thumb.meta_value IS NULL OR thumb.meta_value = '' OR thumb.meta_value = '0')
");

echo "Products without thumbnail: " . count($no_thumb) . "\n\n";

$upload_dir = wp_get_upload_dir()['basedir'];
$sku_dir = $upload_dir . '/product-sku-images/';

foreach ($no_thumb as $prod) {
    $sku = strtolower(trim($prod->sku));
    echo "Product {$prod->ID} | SKU: {$prod->sku} | {$prod->post_title}\n";
    
    if (empty($sku)) {
        echo "  NO SKU - cannot assign image\n\n";
        continue;
    }
    
    $expected_file = $sku_dir . $sku . '.webp';
    if (file_exists($expected_file)) {
        echo "  SKU image exists: $expected_file\n";
        
        // Check if there's already an attachment for this file
        $existing = $wpdb->get_var($wpdb->prepare(
            "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND guid LIKE %s",
            '%' . $sku . '.webp'
        ));
        
        if ($existing) {
            echo "  Found existing attachment ID: $existing\n";
            update_post_meta($prod->ID, '_thumbnail_id', $existing);
            echo "  Assigned thumbnail!\n\n";
        } else {
            // Create new attachment
            $filetype = wp_check_filetype($expected_file);
            $attachment = array(
                'guid' => wp_get_upload_dir()['baseurl'] . '/product-sku-images/' . $sku . '.webp',
                'post_mime_type' => $filetype['type'] ?: 'image/webp',
                'post_title' => $prod->post_title,
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attach_id = wp_insert_attachment($attachment, 'product-sku-images/' . $sku . '.webp', $prod->ID);
            if (!is_wp_error($attach_id)) {
                update_post_meta($prod->ID, '_thumbnail_id', $attach_id);
                echo "  Created new attachment ID: $attach_id and assigned as thumbnail\n\n";
            } else {
                echo "  ERROR creating attachment: " . $attach_id->get_error_message() . "\n\n";
            }
        }
    } else {
        echo "  SKU image NOT found at: $expected_file\n";
        // Look for similar files
        $matches = glob($sku_dir . substr($sku, 0, 2) . '-*');
        echo "  Similar files in category: " . count($matches) . "\n\n";
    }
}

// Final count
$still_missing = $wpdb->get_var("
    SELECT COUNT(*) FROM {$wpdb->posts} p
    LEFT JOIN {$wpdb->postmeta} thumb ON p.ID = thumb.post_id AND thumb.meta_key = '_thumbnail_id'
    WHERE p.post_type = 'product' AND p.post_status = 'publish'
    AND (thumb.meta_value IS NULL OR thumb.meta_value = '' OR thumb.meta_value = '0')
");
echo "=== Still missing thumbnails: $still_missing ===\n";
