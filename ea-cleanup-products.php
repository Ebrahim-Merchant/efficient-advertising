<?php
/**
 * Trash products not in Excel (no SKU) and handle duplicates
 */
define('ABSPATH', __DIR__ . '/');
define('SHORTINIT', false);
require_once ABSPATH . 'wp-load.php';

$action = $argv[1] ?? 'trash-no-sku';

switch ($action) {

case 'trash-no-sku':
    $all_products = get_posts(['post_type' => 'product', 'posts_per_page' => -1, 'post_status' => 'any']);
    $trashed = 0;
    
    foreach ($all_products as $p) {
        $sku = get_post_meta($p->ID, '_sku', true);
        if (empty($sku)) {
            wp_trash_post($p->ID);
            echo "TRASHED: ID:{$p->ID} {$p->post_title}\n";
            $trashed++;
        }
    }
    
    echo "\nTrashed: $trashed products without SKU\n";
    
    // Verify
    $remaining = wp_count_posts('product');
    echo "Remaining published: {$remaining->publish}\n";
    echo "Remaining draft: {$remaining->draft}\n";
    echo "Remaining trash: {$remaining->trash}\n";
    break;

case 'verify-count':
    $counts = wp_count_posts('product');
    echo "Published: {$counts->publish}\n";
    echo "Draft: {$counts->draft}\n";
    echo "Private: {$counts->private}\n";
    echo "Trash: {$counts->trash}\n";
    $active = $counts->publish + $counts->draft + $counts->private;
    echo "Active total: $active\n";
    break;
}
