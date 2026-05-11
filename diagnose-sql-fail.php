<?php
global $wpdb;

// How many attachment records exist for product-sku-images files?
$sku_att_count = $wpdb->get_var(
    "SELECT COUNT(*) FROM {$wpdb->postmeta}
     WHERE meta_key = '_wp_attached_file'
     AND meta_value LIKE 'product-sku-images/%'"
);
WP_CLI::log("_wp_attached_file rows for product-sku-images: {$sku_att_count}");

// Total attachment posts with ID >= 4032
$new_atts = $wpdb->get_var(
    "SELECT COUNT(*) FROM {$wpdb->posts}
     WHERE post_type = 'attachment' AND ID >= 4032"
);
WP_CLI::log("Attachment posts with ID >= 4032: {$new_atts}");

// Check if specific file from the SQL exists as an attachment
$test1 = $wpdb->get_var(
    "SELECT p.ID FROM {$wpdb->posts} p
     INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID
       AND pm.meta_key = '_wp_attached_file'
       AND pm.meta_value = 'product-sku-images/ob-057.webp'
     WHERE p.post_type = 'attachment' LIMIT 1"
);
WP_CLI::log("Attachment for ob-057.webp (pid=1779 target): " . ($test1 ? "EXISTS id=$test1" : "NOT FOUND"));

$test2 = $wpdb->get_var(
    "SELECT p.ID FROM {$wpdb->posts} p
     INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID
       AND pm.meta_key = '_wp_attached_file'
       AND pm.meta_value = 'product-sku-images/fl-005.webp'
     WHERE p.post_type = 'attachment' LIMIT 1"
);
WP_CLI::log("Attachment for fl-005.webp (first in assign script): " . ($test2 ? "EXISTS id=$test2" : "NOT FOUND"));

// Sample 5 product-sku-images attachment files that DO exist
$samples = $wpdb->get_results(
    "SELECT p.ID, pm.meta_value AS file
     FROM {$wpdb->posts} p
     INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID
       AND pm.meta_key = '_wp_attached_file'
       AND pm.meta_value LIKE 'product-sku-images/%'
     WHERE p.post_type = 'attachment'
     LIMIT 5"
);
WP_CLI::log("");
WP_CLI::log("Sample registered SKU attachments:");
foreach ($samples as $s) {
    WP_CLI::log("  ID={$s->ID}  file={$s->file}");
}
