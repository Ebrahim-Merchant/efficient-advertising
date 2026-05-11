<?php
$data = json_decode(file_get_contents('C:/Users/merch/Local Sites/newefficientadvertising09042026/app/public/wp-content/themes/NewEfficientAdvtWorkingTheme_v1.0/master-sync-report.json'), true);
echo "Total samples in report: " . count($data['samples']) . "\n";

// Extract unique category+subcategory pairs
$cat_map = [];
foreach ($data['samples'] as $s) {
    $key = $s['category'] . ' >> ' . $s['sub_category'];
    if (!isset($cat_map[$key])) {
        $cat_map[$key] = 0;
    }
    $cat_map[$key]++;
}

echo "\nUnique category >> subcategory pairs:\n";
ksort($cat_map);
foreach ($cat_map as $k => $count) {
    echo "  $k ($count products)\n";
}
echo "\nTotal unique pairs: " . count($cat_map) . "\n";

// Extract unique parents and children
$parents = [];
$children = [];
foreach ($data['samples'] as $s) {
    $parents[$s['category']] = true;
    $children[$s['sub_category']] = $s['category'];
}
echo "\nParent categories (" . count($parents) . "):\n";
foreach (array_keys($parents) as $p) echo "  - $p\n";
echo "\nChild categories (" . count($children) . "):\n";
foreach ($children as $child => $parent) echo "  - $child (under $parent)\n";
