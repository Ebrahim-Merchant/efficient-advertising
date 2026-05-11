<?php
require_once('wp-load.php');

$ea_top_cats = get_terms( array(
    'taxonomy'   => 'product_cat',
    'parent'     => 0,
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
) );

if ( ! is_wp_error( $ea_top_cats ) ) {
    foreach ( $ea_top_cats as $ea_cat ) {
        echo $ea_cat->name . " (ID: " . $ea_cat->term_id . ", Count: " . $ea_cat->count . ")\n";
    }
} else {
    echo "Error fetching terms.";
}
