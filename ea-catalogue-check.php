<?php
require_once 'C:/Users/merch/Local Sites/newefficientadvertising09042026/app/public/wp-load.php';

// Get first product image from each top-level category
$cats = get_terms(['taxonomy'=>'product_cat','parent'=>0,'hide_empty'=>true,'exclude'=>[get_option('default_product_cat')],'orderby'=>'name']);
foreach($cats as $c) {
  $prods = get_posts(['post_type'=>'product','posts_per_page'=>1,'tax_query'=>[['taxonomy'=>'product_cat','field'=>'term_id','terms'=>$c->term_id]],'fields'=>'ids']);
  $img = 'NONE';
  if ($prods) {
    $thumb_id = get_post_thumbnail_id($prods[0]);
    if ($thumb_id) $img = wp_get_attachment_image_url($thumb_id,'medium');
  }
  echo "{$c->slug} | {$c->name} ({$c->count}) | {$img}\n";
}
