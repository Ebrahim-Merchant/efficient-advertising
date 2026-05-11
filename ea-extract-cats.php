<?php
$file = fopen('woo_products_import.csv', 'r');
$headers = fgetcsv($file);
$catIndex = array_search('Categories', $headers);
$categories = [];

while (($row = fgetcsv($file)) !== false) {
    if (!empty($row[$catIndex])) {
        $categories[] = trim($row[$catIndex]);
    }
}
fclose($file);

$unique = array_unique($categories);
sort($unique);
foreach ($unique as $cat) {
    echo $cat . "\n";
}
?>
