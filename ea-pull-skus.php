<?php
require_once('wp-load.php');

$products = get_posts([
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'fields'         => 'ids',
]);

echo "SKU,Product Name,Status,Categories\n";

foreach ($products as $id) {
    $sku   = get_post_meta($id, '_sku', true);
    $title = get_the_title($id);
    $terms = get_the_terms($id, 'product_cat');
    $cats  = '';
    if ($terms && !is_wp_error($terms)) {
        $cats = implode(' | ', wp_list_pluck($terms, 'name'));
    }
    echo '"' . esc_attr($sku) . '","' . esc_attr($title) . '","publish","' . esc_attr($cats) . '"' . "\n";
}
?>
