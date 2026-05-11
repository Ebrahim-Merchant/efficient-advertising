<?php
/**
 * Quick diagnostic: check why title-matching fails for draft products
 * Looks at first 10 draft products with empty SKU and checks for matching variations
 */
if (!defined('ABSPATH')) exit;
global $wpdb;

$drafts = $wpdb->get_results(
    "SELECT p.ID, p.post_title
     FROM {$wpdb->posts} p
     WHERE p.post_type='product' AND p.post_status='draft'
     ORDER BY p.ID ASC LIMIT 10"
);

foreach ($drafts as $d) {
    $sku   = get_post_meta($d->ID, '_sku', true);
    $title = $d->post_title;

    // Count how many variations share this title
    $count = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->posts}
         WHERE post_type='product_variation' AND post_title=%s",
        $title
    ));

    // Show a variation example if any exist
    $var = $wpdb->get_row($wpdb->prepare(
        "SELECT ID, post_parent, post_title
         FROM {$wpdb->posts}
         WHERE post_type='product_variation' AND post_title=%s LIMIT 1",
        $title
    ));

    WP_CLI::log(sprintf(
        "ID:%d sku:'%s' title:'%s' → variations_with_same_title:%d %s",
        $d->ID, $sku, $title, $count,
        $var ? "(e.g. var_id={$var->ID} parent={$var->post_parent})" : ''
    ));
}
