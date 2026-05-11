<?php
require_once __DIR__ . '/wp-load.php';

echo "=== CURATED PRODUCTS ===" . PHP_EOL;
$ids = ea_get_home_curated_product_ids();
foreach ($ids as $id) {
    $p = get_post($id);
    $img = get_the_post_thumbnail_url($id, 'medium_large');
    echo "ID={$id} | {$p->post_title} | " . basename($img) . PHP_EOL;
}

echo PHP_EOL . "=== CATALOGUE TILES ===" . PHP_EOL;
$map = ea_get_catalogue_category_image_map();
foreach ($map as $slug => $url) {
    echo "{$slug} => " . basename($url) . PHP_EOL;
}

echo PHP_EOL . "=== HERO SLIDES ===" . PHP_EOL;
$slides = ea_get_home_hero_slides();
foreach ($slides as $s) {
    echo basename($s['image_url']) . " | " . $s['eyebrow'] . PHP_EOL;
}

echo PHP_EOL . "=== RECENT WORK ===" . PHP_EOL;
$items = ea_get_home_recent_work_items();
foreach ($items as $item) {
    echo basename($item['image_url']) . " | " . $item['title'] . PHP_EOL;
}
