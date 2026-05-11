<?php
$products = get_posts(array('post_type'=>'product','posts_per_page'=>20,'fields'=>'ids'));
$no_image = 0;
$has_image = 0;
foreach($products as $id){
    $sku = get_post_meta($id,'_sku',true);
    $tid = get_post_thumbnail_id($id);
    $url = $tid ? wp_get_attachment_url($tid) : 'NO IMAGE';
    echo $id.' SKU='.$sku.' THUMB='.$url."\n";
    if($tid) $has_image++; else $no_image++;
}
echo "\nHas image: ".$has_image." | No image: ".$no_image."\n";
