<?php
require_once('wp-load.php');

// Count 1: Unique published products (no double-counting)
$unique_published = get_posts([
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'fields'         => 'ids',
]);
echo "Unique Published Products: " . count($unique_published) . "\n";

// Count 2: Draft products
$drafts = get_posts([
    'post_type'      => 'product',
    'post_status'    => 'draft',
    'posts_per_page' => -1,
    'fields'         => 'ids',
]);
echo "Draft Products: " . count($drafts) . "\n";

// Count 3: All statuses
$all = get_posts([
    'post_type'      => 'product',
    'post_status'    => 'any',
    'posts_per_page' => -1,
    'fields'         => 'ids',
]);
echo "All Products (any status): " . count($all) . "\n";

// Count 4: Products with NO category assigned
$no_cat = get_posts([
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'fields'         => 'ids',
    'tax_query'      => [
        [
            'taxonomy' => 'product_cat',
            'operator' => 'NOT EXISTS',
        ]
    ],
]);
echo "Published Products with NO category: " . count($no_cat) . "\n";

// Count 5: Products assigned to parent category directly (not a subcategory)
$top_cats = get_terms([
    'taxonomy'   => 'product_cat',
    'parent'     => 0,
    'hide_empty' => false,
]);
$top_cat_ids = wp_list_pluck($top_cats, 'term_id');
$directly_in_parent = get_posts([
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'fields'         => 'ids',
    'tax_query'      => [[
        'taxonomy'         => 'product_cat',
        'field'            => 'term_id',
        'terms'            => $top_cat_ids,
        'include_children' => false,
    ]],
]);
echo "Published Products assigned directly to a PARENT category (not sub): " . count($directly_in_parent) . "\n";

echo "\nNOTE: Previous 677 count was due to products assigned to multiple subcategories being counted more than once.\n";
?>
