<?php
require_once('wp-load.php');
$cat = get_term_by('slug', 'corporate-gifts', 'product_cat');
if($cat) {
    $subs = get_terms([
        'taxonomy' => 'product_cat',
        'parent' => $cat->term_id,
        'hide_empty' => false
    ]);
    foreach($subs as $s) {
        echo $s->name . "\n";
    }
} else {
    echo "Corporate Gifts category not found.";
}
?>
