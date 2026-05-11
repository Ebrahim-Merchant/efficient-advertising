<?php
require_once( dirname( __FILE__ ) . '/wp-load.php' );
global $wpdb;
$trashed_products = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'product' AND post_status = 'trash'" );
echo "Trashed products: " . $trashed_products;
