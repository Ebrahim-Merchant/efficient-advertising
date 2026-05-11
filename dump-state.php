<?php
require_once 'wp-load.php';
$products = get_posts(['post_type'=>'product','post_status'=>'publish','posts_per_page'=>-1]);
$data = [];
foreach($products as $p) {
    $thumb_id = get_post_thumbnail_id($p->ID);
    $img_path = $thumb_id ? get_attached_file($thumb_id) : '';
    $data[] = [
        'id' => $p->ID,
        'title' => $p->post_title,
        'image' => basename($img_path),
        'category' => wp_get_post_terms($p->ID, 'product_cat', ['fields'=>'names'])
    ];
}
file_put_contents('assignment_dump.json', json_encode($data));
?>