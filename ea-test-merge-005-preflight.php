<?php
// EA-TEST-MERGE-005: Pre-flight check — confirm SKUs exist before any changes
$skus = [ 'PS-032', 'PS-033', 'PS-034' ];

echo "=== EA-TEST-MERGE-005 PRE-FLIGHT CHECK ===\n\n";
echo "Group:    Folded Business Cards\n";
echo "Original: PS-032 (14pt+Matte)\n";
echo "Dup 1:    PS-033 (14pt+UV)\n";
echo "Dup 2:    PS-034 (13pt Enviro Uncoated)\n\n";

$all_found = true;
foreach ( $skus as $sku ) {
    $product_id = wc_get_product_id_by_sku( $sku );
    if ( ! $product_id ) {
        echo "MISSING SKU: $sku — STOP\n";
        $all_found = false;
        continue;
    }
    $product = wc_get_product( $product_id );
    $title   = $product->get_name();
    $type    = $product->get_type();
    $status  = $product->get_status();
    $price   = $product->get_regular_price();
    echo "FOUND  SKU $sku  →  ID $product_id  |  type=$type  |  status=$status  |  name=$title  |  price=$price\n";
}

echo "\n";
if ( $all_found ) {
    echo "PRE-FLIGHT: PASS — all SKUs found. Safe to proceed.\n";
} else {
    echo "PRE-FLIGHT: FAIL — missing SKUs. Do not proceed.\n";
}
