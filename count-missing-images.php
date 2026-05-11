<?php
// Count products with vs without featured images
$page = 1;
$per  = 200;
$no_img = array();
$has_img = 0;

while(true){
    $ids = get_posts(array(
        'post_type'      => 'product',
        'posts_per_page' => $per,
        'paged'          => $page,
        'fields'         => 'ids',
    ));
    if(empty($ids)) break;
    foreach($ids as $id){
        $tid = get_post_thumbnail_id($id);
        if($tid){ $has_img++; }
        else {
            $sku = get_post_meta($id,'_sku',true);
            $no_img[] = $id.' (SKU='.$sku.')';
        }
    }
    $page++;
}

WP_CLI::log('Has image: '.$has_img);
WP_CLI::log('No image:  '.count($no_img));
WP_CLI::log('');
if(count($no_img)){
    WP_CLI::log('Products WITHOUT images:');
    foreach($no_img as $line) WP_CLI::log('  '.$line);
}
