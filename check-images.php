<?php
require_once __DIR__ . '/wp-load.php';

$products = get_posts([
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => 20,
]);

echo "<pre>";
foreach ($products as $p) {
    echo "Product: " . $p->post_title . " (ID: " . $p->ID . ")\n";
    if (has_post_thumbnail($p->ID)) {
        $thumb_id = get_post_thumbnail_id($p->ID);
        $file = get_attached_file($thumb_id);
        echo "  - Current Image: " . basename($file) . "\n";
    } else {
        echo "  - No Image\n";
    }
}
echo "</pre>";
?>
