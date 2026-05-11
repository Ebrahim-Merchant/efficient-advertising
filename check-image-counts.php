<?php
global $wpdb;
$g = $wpdb->get_var("SELECT COUNT(DISTINCT p.ID) FROM {$wpdb->posts} p INNER JOIN {$wpdb->postmeta} tm ON tm.post_id=p.ID AND tm.meta_key='_thumbnail_id' AND tm.meta_value > 0 INNER JOIN {$wpdb->posts} att ON att.ID=tm.meta_value INNER JOIN {$wpdb->postmeta} af ON af.post_id=att.ID AND af.meta_key='_wp_attached_file' AND af.meta_value NOT LIKE 'product-sku-images/%' WHERE p.post_type='product'");
$s = $wpdb->get_var("SELECT COUNT(DISTINCT p.ID) FROM {$wpdb->posts} p INNER JOIN {$wpdb->postmeta} tm ON tm.post_id=p.ID AND tm.meta_key='_thumbnail_id' AND tm.meta_value > 0 INNER JOIN {$wpdb->posts} att ON att.ID=tm.meta_value INNER JOIN {$wpdb->postmeta} af ON af.post_id=att.ID AND af.meta_key='_wp_attached_file' AND af.meta_value LIKE 'product-sku-images/%' WHERE p.post_type='product'");
$none = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} p WHERE p.post_type='product' AND p.post_status='publish' AND NOT EXISTS (SELECT 1 FROM {$wpdb->postmeta} tm WHERE tm.post_id=p.ID AND tm.meta_key='_thumbnail_id' AND tm.meta_value > 0)");
WP_CLI::log("Generic/wrong images : $g");
WP_CLI::log("Correct SKU images   : $s");
WP_CLI::log("No thumbnail at all  : $none");
