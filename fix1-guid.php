<?php
global $wpdb;

// First verify count before
$before = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE guid LIKE '%local.local%'");
WP_CLI::log("Before: {$before} GUIDs contain .local.local");

// Run the fix
$affected = $wpdb->query("UPDATE {$wpdb->posts} SET guid = REPLACE(guid, 'local.local', 'local') WHERE guid LIKE '%local.local%'");
WP_CLI::log("Rows affected: {$affected}");

// Verify after
$after = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE guid LIKE '%local.local%'");
WP_CLI::log("After: {$after} GUIDs still contain .local.local");

// Sample check
$sample = $wpdb->get_results("SELECT ID, guid FROM {$wpdb->posts} WHERE guid LIKE '%2026/04%' LIMIT 3");
WP_CLI::log("");
WP_CLI::log("Sample GUIDs after fix:");
foreach ($sample as $row) {
    WP_CLI::log("  ID={$row->ID} guid={$row->guid}");
}
