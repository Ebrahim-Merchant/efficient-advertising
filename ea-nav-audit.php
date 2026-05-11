<?php
require_once __DIR__ . '/wp-load.php';
$cats = get_terms(array('taxonomy'=>'product_cat','parent'=>0,'hide_empty'=>true,'orderby'=>'name','order'=>'ASC'));
foreach ($cats as $c) {
    if ($c->slug === 'uncategorized') continue;
    $subs = get_terms(array('taxonomy'=>'product_cat','parent'=>$c->term_id,'hide_empty'=>true));
    $sub_names = array_map(function($s){ return $s->name; }, $subs);
    echo $c->name . ' (' . count($subs) . ' subs)' . PHP_EOL;
    if ($sub_names) echo '  -> ' . implode(' | ', $sub_names) . PHP_EOL;
}
echo 'Catalogue (0 subs)' . PHP_EOL;
