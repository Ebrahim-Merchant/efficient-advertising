<?php
require_once __DIR__ . '/wp-load.php';
$p1 = get_post(1534);
$p2 = get_post(1535);
echo "1534: " . ($p1 ? $p1->post_title . " [" . $p1->post_status . "]" : "NOT FOUND") . PHP_EOL;
echo "1535: " . ($p2 ? $p2->post_title . " [" . $p2->post_status . "]" : "NOT FOUND") . PHP_EOL;

// Also check vb-001 vs vb-002 product names
$vb1 = get_posts(['post_type'=>'product','meta_key'=>'_sku','meta_value'=>'VB-001','posts_per_page'=>1]);
$vb2 = get_posts(['post_type'=>'product','meta_key'=>'_sku','meta_value'=>'VB-002','posts_per_page'=>1]);
echo "VB-001: " . ($vb1 ? $vb1[0]->post_title : "NOT FOUND") . PHP_EOL;
echo "VB-002: " . ($vb2 ? $vb2[0]->post_title : "NOT FOUND") . PHP_EOL;

// SG-003 vs SG-004
$sg3 = get_posts(['post_type'=>'product','meta_key'=>'_sku','meta_value'=>'SG-003','posts_per_page'=>1]);
$sg4 = get_posts(['post_type'=>'product','meta_key'=>'_sku','meta_value'=>'SG-004','posts_per_page'=>1]);
echo "SG-003: " . ($sg3 ? $sg3[0]->post_title : "NOT FOUND") . PHP_EOL;
echo "SG-004: " . ($sg4 ? $sg4[0]->post_title : "NOT FOUND") . PHP_EOL;
