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

$total = count($ids);
$withThumb = 0;

foreach ($ids as $id) {
    if (get_post_thumbnail_id((int)$id)) {
        $withThumb++;
    }
}

$withoutThumb = $total - $withThumb;

echo 'PRODUCT_TOTAL=' . $total . PHP_EOL;
echo 'PRODUCT_WITH_THUMB=' . $withThumb . PHP_EOL;
echo 'PRODUCT_WITHOUT_THUMB=' . $withoutThumb . PHP_EOL;
