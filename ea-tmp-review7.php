<?php
if (!defined('ABSPATH')) exit;
// Show draft products flagged as needing review
$file = __DIR__ . '/website-cleanup-dump/logs/draft-product-analysis.csv';
$fh = fopen($file, 'r');
$headers = fgetcsv($fh);
$h = array_flip($headers);
while (($row = fgetcsv($fh)) !== false) {
    if ($row[$h['safe_to_delete']] === 'no') {
        WP_CLI::log(sprintf(
            "ID:%s SKU:'%s' title:'%s' | img:%s unique:%s | %s",
            $row[$h['product_id']], $row[$h['sku']], $row[$h['product_name']],
            $row[$h['image_present']], $row[$h['image_unique']], $row[$h['notes']]
        ));
    }
}
fclose($fh);
