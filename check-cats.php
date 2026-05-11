<?php
require_once('wp-load.php');

$parent_term = get_term_by('slug', 'vehicle-branding', 'product_cat');
if (!$parent_term) {
    echo "Parent category 'Vehicle Branding' not found.\n";
    exit;
}

$sub_cats = get_terms(array(
    'taxonomy'   => 'product_cat',
    'parent'     => $parent_term->term_id,
    'hide_empty' => false,
));

if (is_wp_error($sub_cats)) {
    echo "Error retrieving sub-categories.\n";
    exit;
}

echo "Sub-categories of Vehicle Branding (hide_empty=false):\n";
foreach ($sub_cats as $cat) {
    echo "- " . $cat->name . " (Count: " . $cat->count . ")\n";
}

if (empty($sub_cats)) {
    echo "No sub-categories found.\n";
}
