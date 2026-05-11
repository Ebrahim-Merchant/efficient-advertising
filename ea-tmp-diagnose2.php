<?php
if (!defined('ABSPATH')) exit;
global $wpdb;

// Check what the actual variation titles look like for parent post_id 1053 (PS-001 Standard Business Cards)
$vars = $wpdb->get_results(
    "SELECT ID, post_title, post_parent FROM {$wpdb->posts}
     WHERE post_type='product_variation' AND post_parent=1053 LIMIT 5"
);
WP_CLI::log("Variation titles for parent 1053:");
foreach ($vars as $v) {
    $vsku = get_post_meta($v->ID, '_sku', true);
    $attr = get_post_meta($v->ID, 'attribute_option', true);
    WP_CLI::log("  variation_id:{$v->ID} title:'{$v->post_title}' sku:'$vsku' attribute_option:'$attr'");
}

// Also check what the draft product at ID 1054 looks like
WP_CLI::log("\nDraft product 1054:");
$draft = get_post(1054);
WP_CLI::log("  title: '{$draft->post_title}'");
WP_CLI::log("  sku: '" . get_post_meta(1054, '_sku', true) . "'");
