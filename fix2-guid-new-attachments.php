<?php
global $wpdb;

$base_url = 'http://newefficientadvertising09042026.local/wp-content/uploads/';

// Count before
$before = $wpdb->get_var(
    "SELECT COUNT(*) FROM {$wpdb->posts} p
     INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID AND pm.meta_key = '_wp_attached_file'
     WHERE p.ID >= 4032
     AND p.post_type = 'attachment'
     AND p.guid NOT LIKE '%/wp-content/uploads/%'"
);
WP_CLI::log("Attachments with ID >= 4032 needing GUID fix: {$before}");

// Run the update
$affected = $wpdb->query(
    "UPDATE {$wpdb->posts} p
     INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID AND pm.meta_key = '_wp_attached_file'
     SET p.guid = CONCAT('{$base_url}', pm.meta_value)
     WHERE p.ID >= 4032
     AND p.post_type = 'attachment'
     AND p.guid NOT LIKE '%/wp-content/uploads/%'"
);
WP_CLI::log("Rows affected: {$affected}");

// Verify after
$after = $wpdb->get_var(
    "SELECT COUNT(*) FROM {$wpdb->posts} p
     INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID AND pm.meta_key = '_wp_attached_file'
     WHERE p.ID >= 4032
     AND p.post_type = 'attachment'
     AND p.guid NOT LIKE '%/wp-content/uploads/%'"
);
WP_CLI::log("Still needing fix after update: {$after}");

// Sample 3 fixed rows
$sample = $wpdb->get_results(
    "SELECT p.ID, p.guid FROM {$wpdb->posts} p
     WHERE p.ID >= 4032 AND p.post_type = 'attachment'
     ORDER BY p.ID ASC LIMIT 3"
);
WP_CLI::log("");
WP_CLI::log("Sample GUIDs after fix:");
foreach ($sample as $row) {
    WP_CLI::log("  ID={$row->ID} guid={$row->guid}");
}
