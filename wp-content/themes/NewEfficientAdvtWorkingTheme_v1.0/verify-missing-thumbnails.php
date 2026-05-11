<?php

declare(strict_types=1);

$_SERVER['HTTP_HOST'] = 'newefficientadvertising09042026.local';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['REQUEST_METHOD'] = 'GET';

require_once dirname(__DIR__, 3) . '/wp-load.php';

$ids = get_posts([
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'fields' => 'ids',
]);

foreach ($ids as $id) {
    $id = (int)$id;
    if (get_post_thumbnail_id($id)) {
        continue;
    }
    $sku = (string)get_post_meta($id, '_sku', true);
    $name = get_the_title($id);
    echo 'NO_THUMB|ID=' . $id . '|SKU=' . $sku . '|NAME=' . $name . PHP_EOL;
}
