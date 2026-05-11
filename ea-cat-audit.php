<?php
require_once __DIR__ . '/wp-load.php';
$cats = get_terms(array('taxonomy'=>'product_cat','parent'=>0,'hide_empty'=>true,'orderby'=>'name','order'=>'ASC'));
echo "=== WooCommerce Top-Level Categories (orderby=name ASC) ===" . PHP_EOL;
foreach ($cats as $c) {
    if ($c->slug === 'uncategorized') continue;
    echo $c->term_id . ' | ' . $c->slug . ' | ' . $c->name . ' | count=' . $c->count . PHP_EOL;
}
