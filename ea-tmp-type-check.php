<?php
if (!defined('ABSPATH')) exit;
global $wpdb;
// How many published products have NO product_type term?
$no_type = $wpdb->get_var(
    "SELECT COUNT(DISTINCT p.ID)
     FROM {$wpdb->posts} p
     WHERE p.post_type='product' AND p.post_status='publish'
       AND p.ID NOT IN (
           SELECT tr.object_id
           FROM {$wpdb->term_relationships} tr
           JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id=tt.term_taxonomy_id
           WHERE tt.taxonomy='product_type'
       )"
);
WP_CLI::log("Published products with NO product_type term: $no_type");

// Sample a few
$examples = $wpdb->get_results(
    "SELECT p.ID, p.post_title FROM {$wpdb->posts} p
     WHERE p.post_type='product' AND p.post_status='publish'
       AND p.ID NOT IN (
           SELECT tr.object_id
           FROM {$wpdb->term_relationships} tr
           JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id=tt.term_taxonomy_id
           WHERE tt.taxonomy='product_type'
       )
     ORDER BY p.ID LIMIT 5"
);
foreach ($examples as $e) {
    $sku = get_post_meta($e->ID, '_sku', true);
    WP_CLI::log("  ID:{$e->ID} SKU:'{$sku}' title:'{$e->post_title}'");
}
