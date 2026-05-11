<?php
/**
 * EA-TEST-MERGE-005: Resume — complete steps 5+6 only.
 * Creates variations for PS-033 and PS-034 (PS-032-var already exists).
 * Clears SKU from duplicate product first to avoid WC uniqueness conflict,
 * then assigns it to the variation, then sets the duplicate product to draft.
 */

$log = [];
function ea_log( &$log, $msg ) {
    $line = '[' . date( 'Y-m-d H:i:s' ) . '] ' . $msg;
    $log[] = $line;
    echo $line . "\n";
}

ea_log( $log, '=== EA-TEST-MERGE-005 RESUME START ===' );

$parent_id = 1084;
$attr_key  = 'option';

$items = [
    'PS-033' => [ 'id' => 1085, 'val' => '14pt+UV' ],
    'PS-034' => [ 'id' => 1086, 'val' => '13pt Enviro Uncoated' ],
];

// Safety: confirm parent is now variable
$parent_type = wp_get_object_terms( $parent_id, 'product_type' );
if ( empty( $parent_type ) || $parent_type[0]->slug !== 'variable' ) {
    ea_log( $log, 'FATAL: Parent ID 1084 is not variable. STOP.' );
    exit( 1 );
}
ea_log( $log, "Parent ID $parent_id confirmed as variable type." );

// Safety: confirm variation for PS-032-var already exists
global $wpdb;
$existing = $wpdb->get_col(
    "SELECT ID FROM wp_posts WHERE post_parent = $parent_id AND post_type = 'product_variation'"
);
ea_log( $log, 'Existing variation IDs: ' . ( $existing ? implode( ', ', $existing ) : 'none' ) );

foreach ( $items as $sku => $info ) {
    $dup_id  = $info['id'];
    $val     = $info['val'];

    ea_log( $log, "--- Processing duplicate SKU $sku (ID $dup_id, value='$val') ---" );

    // 1. Confirm duplicate still exists as simple/publish
    $dup = wc_get_product( $dup_id );
    if ( ! $dup ) {
        ea_log( $log, "FATAL: Product ID $dup_id not found. STOP." );
        exit( 1 );
    }
    ea_log( $log, "  Duplicate confirmed: type=" . $dup->get_type() . "  status=" . $dup->get_status() . "  sku=" . $dup->get_sku() );

    // 2. Clear the duplicate's SKU so WC allows reuse in variation
    $orig_sku = $dup->get_sku();
    $dup->set_sku( '' );
    $dup->save();
    ea_log( $log, "  Cleared SKU from duplicate product ID $dup_id (was: $orig_sku)" );

    // 3. Create variation with that SKU
    $variation = new WC_Product_Variation();
    $variation->set_parent_id( $parent_id );
    $variation->set_attributes( [ $attr_key => $val ] );
    $variation->set_sku( $orig_sku );
    $variation->set_status( 'publish' );
    $variation->set_manage_stock( false );
    $price = $dup->get_regular_price();
    if ( $price !== '' && $price !== null && $price !== false ) {
        $variation->set_regular_price( $price );
    }
    $vid = $variation->save();

    if ( ! $vid || is_wp_error( $vid ) ) {
        ea_log( $log, "  ERROR creating variation for $sku. Restoring SKU on duplicate." );
        $dup->set_sku( $orig_sku );
        $dup->save();
        ea_log( $log, "  SKU $orig_sku restored to product ID $dup_id. STOP." );
        exit( 1 );
    }
    ea_log( $log, "  Created variation ID $vid  SKU=$orig_sku  attr[$attr_key]=$val" );

    // 4. Set duplicate product to draft
    $result = wp_update_post( [ 'ID' => $dup_id, 'post_status' => 'draft' ] );
    if ( is_wp_error( $result ) ) {
        ea_log( $log, "  ERROR setting duplicate ID $dup_id to draft: " . $result->get_error_message() );
    } else {
        ea_log( $log, "  Duplicate product ID $dup_id (SKU was $orig_sku) → set to draft" );
    }
}

// Sync variable product
WC_Product_Variable::sync( $parent_id );
wc_delete_product_transients( $parent_id );
ea_log( $log, "Variable product ID $parent_id synced." );

// Final state report
ea_log( $log, '--- FINAL STATE ---' );
$all_vars = $wpdb->get_results(
    "SELECT ID FROM wp_posts WHERE post_parent = $parent_id AND post_type = 'product_variation'"
);
foreach ( $all_vars as $row ) {
    $v = wc_get_product( $row->ID );
    ea_log( $log, "  Variation ID " . $row->ID . "  SKU=" . $v->get_sku() . "  attr=" . wp_json_encode( $v->get_variation_attributes() ) . "  status=" . $v->get_status() );
}
foreach ( $items as $sku => $info ) {
    $d = wc_get_product( $info['id'] );
    ea_log( $log, "  Duplicate ID " . $info['id'] . "  SKU=" . $d->get_sku() . "  status=" . $d->get_status() );
}

ea_log( $log, '=== EA-TEST-MERGE-005 RESUME COMPLETE ===' );
