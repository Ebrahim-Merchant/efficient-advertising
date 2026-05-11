<?php
require_once('wp-load.php');

$top_cats = get_terms([
    'taxonomy'   => 'product_cat',
    'parent'     => 0,
    'hide_empty' => false,
    'orderby'    => 'name',
    'order'      => 'ASC',
]);

$grand_total = 0;

foreach ($top_cats as $cat) {
    if ($cat->slug === 'uncategorized') continue;

    $sub_cats = get_terms([
        'taxonomy'   => 'product_cat',
        'parent'     => $cat->term_id,
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ]);

    $cat_total = 0;
    $sub_lines = [];

    foreach ($sub_cats as $sub) {
        $products = get_posts([
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'tax_query'      => [[
                'taxonomy'         => 'product_cat',
                'field'            => 'term_id',
                'terms'            => $sub->term_id,
                'include_children' => false,
            ]],
            'meta_query' => [[
                'key'     => '_sku',
                'value'   => '',
                'compare' => '!=',
            ]],
        ]);

        // Only count uppercase SKU (valid) products
        $valid = 0;
        foreach ($products as $id) {
            $sku = get_post_meta($id, '_sku', true);
            if ($sku && $sku === strtoupper($sku)) {
                $valid++;
            }
        }

        $cat_total   += $valid;
        $grand_total += $valid;
        $sub_lines[]  = "   -- {$sub->name}: {$valid} products";
    }

    echo "CATEGORY: {$cat->name} | Total Valid Products: {$cat_total}\n";
    foreach ($sub_lines as $line) echo $line . "\n";
    echo "\n";
}

echo "==========================================\n";
echo "GRAND TOTAL VALID PRODUCTS: {$grand_total}\n";
?>
