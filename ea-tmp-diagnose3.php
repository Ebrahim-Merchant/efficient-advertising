<?php
if (!defined('ABSPATH')) exit;
global $wpdb;

// Check the 7 unmatched draft products and their group parents
$unmatched_ids = [1162, 1163, 1164, 1165, 1166, 1195, 1258];

foreach ($unmatched_ids as $pid) {
    $title = get_the_title($pid);
    WP_CLI::log("\n=== Draft ID:$pid title:'$title' ===");
    // Show hex of title to detect encoding
    $bytes = bin2hex(substr($title, 0, 30));
    WP_CLI::log("  title hex: $bytes");

    // Find parent post (is this product a child of any variable?)
    $parent_id = wp_get_post_parent_id($pid);
    WP_CLI::log("  post parent: $parent_id");
}

// Now check what attribute_option values are stored in variations that might match "Specialty" or "4 Color"
WP_CLI::log("\n=== attribute_option values containing 'Specialty' ===");
$rows = $wpdb->get_results(
    "SELECT pm.post_id, pm.meta_value, p.post_parent
     FROM {$wpdb->postmeta} pm
     JOIN {$wpdb->posts} p ON pm.post_id=p.ID
     WHERE pm.meta_key='attribute_option' AND pm.meta_value LIKE '%pecialty%'
     LIMIT 20"
);
foreach ($rows as $r) {
    $hex = bin2hex(substr($r->meta_value, 0, 30));
    WP_CLI::log("  var_id:{$r->post_id} parent:{$r->post_parent} value:'{$r->meta_value}' hex:$hex");
}

WP_CLI::log("\n=== attribute_option values containing '4 Color' ===");
$rows2 = $wpdb->get_results(
    "SELECT pm.post_id, pm.meta_value, p.post_parent
     FROM {$wpdb->postmeta} pm
     JOIN {$wpdb->posts} p ON pm.post_id=p.ID
     WHERE pm.meta_key='attribute_option' AND pm.meta_value LIKE '%4 Color%'
     LIMIT 5"
);
foreach ($rows2 as $r) {
    $hex = bin2hex(substr($r->meta_value, 0, 30));
    WP_CLI::log("  var_id:{$r->post_id} parent:{$r->post_parent} value:'{$r->meta_value}' hex:$hex");
}
