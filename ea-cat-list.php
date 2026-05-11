<?php
require_once __DIR__ . '/wp-load.php';
$cats = get_terms(['taxonomy'=>'product_cat','hide_empty'=>false,'orderby'=>'name']);
echo 'TOTAL CATEGORIES: ' . count($cats) . PHP_EOL . PHP_EOL;
echo str_pad('CATEGORY',42) . '| ' . str_pad('PARENT',32) . '| COUNT' . PHP_EOL;
echo str_repeat('-',85) . PHP_EOL;
$top = 0; $sub = 0;
foreach ($cats as $c) {
  $parent_name = '';
  if ($c->parent) { $p = get_term($c->parent,'product_cat'); $parent_name = $p->name; $sub++; } else { $top++; }
  printf("%-42s| %-32s| %d\n", $c->name, ($parent_name ?: '(top-level)'), $c->count);
}
echo PHP_EOL . "Top-level: $top | Subcategories: $sub" . PHP_EOL;
