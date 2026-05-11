<?php
if (!defined('ABSPATH')) exit;
$file = __DIR__ . '/website-cleanup-dump/logs/draft-product-analysis.csv';
$fh = fopen($file, 'r');
$headers = fgetcsv($fh);
$h = array_flip($headers);
$total = $safe = $unique_img = $no_img = 0;
while (($row = fgetcsv($fh)) !== false) {
    $total++;
    if ($row[$h['safe_to_delete']] === 'yes') $safe++;
    if ($row[$h['image_present']] === 'yes' && $row[$h['image_unique']] === 'yes') $unique_img++;
    if ($row[$h['image_present']] === 'no') $no_img++;
}
fclose($fh);
WP_CLI::log("Total draft products  : $total");
WP_CLI::log("Safe to delete        : $safe");
WP_CLI::log("With unique image      : $unique_img  (image will orphan on delete)");
WP_CLI::log("Without image          : $no_img");
WP_CLI::log("With shared image      : " . ($total - $no_img - $unique_img));
