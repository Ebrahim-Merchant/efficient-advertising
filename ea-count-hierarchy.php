<?php
require_once('wp-load.php');

$top_cats = get_terms([
    'taxonomy'   => 'product_cat',
    'parent'     => 0,
    'hide_empty' => false,
    'orderby'    => 'name',
    'order'      => 'ASC',
]);

$grand_total_subs = 0;
$grand_total_products = 0;

foreach ($top_cats as $cat) {
    if ($cat->slug === 'uncategorized') continue;

    $sub_cats = get_terms([
        'taxonomy'   => 'product_cat',
        'parent'     => $cat->term_id,
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ]);

    $sub_count = count($sub_cats);
    $grand_total_subs += $sub_count;

    $total_products_in_cat = 0;
    foreach ($sub_cats as $sub) {
        $products = get_posts([
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'tax_query'      => [['taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $sub->term_id]],
            'fields'         => 'ids',
        ]);
        $total_products_in_cat += count($products);
        $grand_total_products += count($products);
    }

    echo "CATEGORY: {$cat->name} | Subcategories: {$sub_count} | Total Products: {$total_products_in_cat}\n";

    foreach ($sub_cats as $sub) {
        $products = get_posts([
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'tax_query'      => [['taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $sub->term_id]],
            'fields'         => 'ids',
        ]);
        echo "   -- {$sub->name}: " . count($products) . " products\n";
    }
    echo "\n";
}

echo "===========================================\n";
echo "TOTALS: " . (count($top_cats)-1) . " parent cats | {$grand_total_subs} subcategories | {$grand_total_products} products\n";
?>
