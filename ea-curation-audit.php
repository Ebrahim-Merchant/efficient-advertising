<?php
require_once 'C:/Users/merch/Local Sites/newefficientadvertising09042026/app/public/wp-load.php';

echo "=== CURATED PRODUCTS (1 per parent cat, ordered by count DESC) ===\n";
$cats = get_terms([
  'taxonomy'=>'product_cat','parent'=>0,'hide_empty'=>true,
  'orderby'=>'count','order'=>'DESC','number'=>8,
]);
if (!is_wp_error($cats)) {
  $cats = array_filter($cats, function($t){ return $t->term_id >= 1257; });
}
foreach($cats as $c) {
  $prods = get_posts([
    'post_type'=>'product','post_status'=>'publish','posts_per_page'=>1,
    'meta_query'=>[['key'=>'_thumbnail_id','compare'=>'EXISTS']],
    'tax_query'=>[['taxonomy'=>'product_cat','field'=>'term_id','terms'=>$c->term_id]],
  ]);
  if($prods) {
    $p=$prods[0];
    $img=get_the_post_thumbnail_url($p->ID,'medium_large');
    echo "  ID={$p->ID} | {$c->name} | {$p->post_title} | {$img}\n";
  }
}

echo "\n=== PORTFOLIO (current static array — no query needed) ===\n";
echo "  Static array in index.php — no WC query\n";

echo "\n=== CATALOGUE CATEGORY SLUGS + FIRST PRODUCT IMAGES ===\n";
$allcats = get_terms(['taxonomy'=>'product_cat','parent'=>0,'hide_empty'=>true,'exclude'=>[get_option('default_product_cat')],'orderby'=>'name']);
foreach($allcats as $c) {
  $prods = get_posts(['post_type'=>'product','posts_per_page'=>1,'tax_query'=>[['taxonomy'=>'product_cat','field'=>'term_id','terms'=>$c->term_id]],'fields'=>'ids']);
  $img='NONE';
  if($prods) { $tid=get_post_thumbnail_id($prods[0]); if($tid) $img=wp_get_attachment_image_url($tid,'medium_large'); }
  echo "  '{$c->slug}' => '{$img}',  // {$c->name} ({$c->count})\n";
}

echo "\n=== HERO IMAGES (current static) ===\n";
$heros = [
  '/wp-content/uploads/2026/03/exhibition-stand-dubai.jpg',
  '/wp-content/uploads/2026/03/car-wrap-vehicle-branding.jpg',
  '/wp-content/uploads/2026/03/business-signage-storefront.jpg',
];
foreach($heros as $h) {
  $full = ABSPATH . ltrim($h,'/');
  echo "  {$h} => " . (file_exists($full) ? 'EXISTS' : 'MISSING') . "\n";
}
