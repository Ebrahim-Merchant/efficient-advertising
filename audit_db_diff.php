<?php
require_once('wp-load.php');

global $wpdb;

// Get all products and variations
$query = "
    SELECT p.ID, p.post_type, pm.meta_value as sku 
    FROM {$wpdb->posts} p
    LEFT JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id AND pm.meta_key = '_sku'
    WHERE p.post_type IN ('product', 'product_variation')
    AND p.post_status != 'trash'
";

$results = $wpdb->get_results($query);

$db_state = [];
foreach ($results as $row) {
    if (!empty($row->sku)) {
        $db_state[$row->sku] = [
            'id' => $row->ID,
            'type' => $row->post_type
        ];
    }
}

file_put_contents('scratch_node/db_state.json', json_encode($db_state, JSON_PRETTY_PRINT));
echo "Dumped " . count($db_state) . " SKUs to scratch_node/db_state.json\n";
