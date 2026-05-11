<?php
// EA-TEST-MERGE-005: Post-run state check
global $wpdb;

$skus_to_check = [ 'PS-032', 'PS-033', 'PS-034' ];
echo "=== POST-RUN STATE CHECK ===\n\n";

foreach ( $skus_to_check as $sku ) {
    $id = wc_get_product_id_by_sku( $sku );
    if ( ! $id ) {
        echo "NOT FOUND: $sku\n";
        continue;
    }
    $p = wc_get_product( $id );
    echo "SKU $sku  ID $id  type=" . $p->get_type() . "  status=" . $p->get_status() . "  name=" . $p->get_name() . "\n";
}

// Check for variation SKUs under parent 1084
echo "\nVariations under parent ID 1084:\n";
$var_rows = $wpdb->get_results(
    "SELECT ID, post_status FROM wp_posts WHERE post_parent = 1084 AND post_type = 'product_variation'"
);
if ( $var_rows ) {
    foreach ( $var_rows as $row ) {
        $var = wc_get_product( $row->ID );
        $var_sku = $var ? $var->get_sku() : 'n/a';
        $attr    = $var ? wp_json_encode( $var->get_variation_attributes() ) : 'n/a';
        echo "  Variation ID " . $row->ID . "  status=" . $row->post_status . "  sku=$var_sku  attrs=$attr\n";
    }
} else {
    echo "  No variations found.\n";
}

// Check product type for parent
$type_term = wp_get_object_terms( 1084, 'product_type' );
echo "\nProduct type term for ID 1084: ";
echo $type_term ? $type_term[0]->slug : 'none';
echo "\n";
