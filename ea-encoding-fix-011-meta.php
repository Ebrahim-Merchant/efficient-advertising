<?php
if (!defined('ABSPATH')) exit;
global $wpdb;

$from = [
    "\xce\x93\xc3\x87\xc3\xb4", // ΓÇô → en dash
    "\xce\x93\xc3\x87\xc3\xb3", // ΓÇó → bullet
    "\xce\x93\xc3\x87\xc3\x96", // ΓÇÖ → right single quote
    "\xce\x93\xc3\x87\xc2\xa3", // ΓÇ£ → left double quote
    "\xce\x93\xc3\x87\xc2\xa5", // ΓÇ¥ → right double quote
];
$to = [
    "\xe2\x80\x93", // –
    "\xe2\x80\xa2", // •
    "\xe2\x80\x99", // '
    "\xe2\x80\x9c", // "
    "\xe2\x80\x9d", // "
];

// Fetch all postmeta rows containing the bad byte sequence
// Scoped to product/product_variation posts only for safety
$rows = $wpdb->get_results(
    "SELECT pm.meta_id, pm.meta_key, pm.meta_value
     FROM {$wpdb->postmeta} pm
     JOIN {$wpdb->posts} p ON p.ID = pm.post_id
     WHERE p.post_type IN ('product','product_variation')
       AND pm.meta_value LIKE '%\xce\x93\xc3\x87%'"
);

echo "Affected meta rows found: " . count($rows) . "\n";

$updated = 0;
foreach ($rows as $row) {
    $fixed = str_replace($from, $to, $row->meta_value);
    if ($fixed === $row->meta_value) continue;

    // Correct approach: update by meta_id (not post_id)
    $wpdb->update(
        $wpdb->postmeta,
        ['meta_value' => $fixed],
        ['meta_id'    => (int)$row->meta_id],
        ['%s'],
        ['%d']
    );
    echo "  meta_id:{$row->meta_id} key:{$row->meta_key} fixed\n";
    $updated++;
}

echo "Done. Meta rows updated: $updated\n";
