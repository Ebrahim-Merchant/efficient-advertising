<?php
/**
 * EA-TEST-MERGE-005: Test merge — single product group only.
 *
 * Group: Folded Business Cards
 * Original:  PS-032 (14pt+Matte)  → becomes variable product
 * Duplicate: PS-033 (14pt+UV)     → variation, then set to draft
 * Duplicate: PS-034 (13pt Enviro Uncoated) → variation, then set to draft
 *
 * RULES:
 * - NO deletions
 * - Duplicate products → draft only
 * - Do NOT change images
 * - Full log output
 */

$log = [];

function ea_log( &$log, $msg ) {
    $line = '[' . date( 'Y-m-d H:i:s' ) . '] ' . $msg;
    $log[] = $line;
    echo $line . "\n";
}

ea_log( $log, '=== EA-TEST-MERGE-005 MERGE SCRIPT START ===' );

// ── Config ──────────────────────────────────────────────────────────────────
$original_sku   = 'PS-032';
$duplicate_skus = [
    'PS-033' => '14pt+UV',
    'PS-034' => '13pt Enviro Uncoated',
];
$attribute_name = 'Option';
// The Original's own variant value (it represents 14pt+Matte)
$original_variant_value = '14pt+Matte';

// ── Step 1: Locate all products ──────────────────────────────────────────────
ea_log( $log, 'STEP 1 — Locating products by SKU' );

$original_id = wc_get_product_id_by_sku( $original_sku );
if ( ! $original_id ) {
    ea_log( $log, "FATAL: Original SKU $original_sku not found. STOP." );
    exit( 1 );
}
ea_log( $log, "Original  SKU $original_sku → WP Post ID $original_id" );

$dup_ids = [];
foreach ( $duplicate_skus as $sku => $val ) {
    $id = wc_get_product_id_by_sku( $sku );
    if ( ! $id ) {
        ea_log( $log, "FATAL: Duplicate SKU $sku not found. STOP." );
        exit( 1 );
    }
    $dup_ids[ $sku ] = $id;
    ea_log( $log, "Duplicate SKU $sku → WP Post ID $id  |  variant value: $val" );
}

// ── Step 2: Safety — confirm all are simple & published ─────────────────────
ea_log( $log, 'STEP 2 — Confirming current product state' );

$orig_product = wc_get_product( $original_id );
if ( $orig_product->get_type() !== 'simple' ) {
    ea_log( $log, 'FATAL: Original is not simple type. Already converted? STOP.' );
    exit( 1 );
}
ea_log( $log, "Original type=simple  status=" . $orig_product->get_status() . "  OK" );

foreach ( $dup_ids as $sku => $id ) {
    $p = wc_get_product( $id );
    if ( $p->get_type() !== 'simple' ) {
        ea_log( $log, "FATAL: Duplicate $sku is not simple type. STOP." );
        exit( 1 );
    }
    ea_log( $log, "Duplicate $sku type=simple  status=" . $p->get_status() . "  OK" );
}

// ── Step 3: Convert Original → variable ─────────────────────────────────────
ea_log( $log, 'STEP 3 — Changing Original product type: simple → variable' );

wp_set_object_terms( $original_id, 'variable', 'product_type' );
clean_post_cache( $original_id );
ea_log( $log, "Post ID $original_id product_type term set to 'variable'" );

// ── Step 4: Create "Option" attribute on the parent ──────────────────────────
ea_log( $log, 'STEP 4 — Creating "Option" attribute on parent product' );

// Collect all variant values: Original first, then duplicates
$all_variant_values = array_merge(
    [ $original_variant_value ],
    array_values( $duplicate_skus )
);

$product_attributes = [];

// Use a local (product-level) attribute — no global taxonomy needed
$attr_key = sanitize_title( $attribute_name ); // 'option'

$attribute = new WC_Product_Attribute();
$attribute->set_name( $attribute_name );
$attribute->set_options( $all_variant_values );
$attribute->set_position( 0 );
$attribute->set_visible( true );
$attribute->set_variation( true );

$product_attributes[ $attr_key ] = $attribute;

// Reload using WC product object to save attributes
$variable_product = new WC_Product_Variable( $original_id );
$variable_product->set_attributes( $product_attributes );
$variable_product->save();

ea_log( $log, "Attribute '$attribute_name' created with values: " . implode( ' | ', $all_variant_values ) );

// ── Step 5: Create variations ────────────────────────────────────────────────
ea_log( $log, 'STEP 5 — Creating variations under post ID ' . $original_id );

// Helper: create one variation
function ea_create_variation( $parent_id, $attr_key, $attr_value, $sku, $price, &$log ) {
    $variation = new WC_Product_Variation();
    $variation->set_parent_id( $parent_id );
    $variation->set_attributes( [ $attr_key => $attr_value ] );
    $variation->set_sku( $sku );
    if ( $price !== '' && $price !== null && $price !== false ) {
        $variation->set_regular_price( $price );
    }
    $variation->set_status( 'publish' );
    $variation->set_manage_stock( false );
    $variation_id = $variation->save();
    ea_log( $log, "  Created variation ID $variation_id  SKU=$sku  attr[$attr_key]=$attr_value" );
    return $variation_id;
}

// Variation for the Original itself (14pt+Matte / PS-032)
$orig_price = $orig_product->get_regular_price();
$var_id_original = ea_create_variation(
    $original_id,
    $attr_key,
    $original_variant_value,
    $original_sku . '-var',   // avoid SKU collision with the parent
    $orig_price,
    $log
);

// Variations for each duplicate
$created_variation_ids = [ $var_id_original ];
foreach ( $duplicate_skus as $sku => $val ) {
    $dup_product = wc_get_product( $dup_ids[ $sku ] );
    $dup_price   = $dup_product->get_regular_price();
    $vid = ea_create_variation( $original_id, $attr_key, $val, $sku, $dup_price, $log );
    $created_variation_ids[] = $vid;
}

ea_log( $log, 'Variations created: ' . implode( ', ', $created_variation_ids ) );

// ── Step 6: Set duplicates to draft ──────────────────────────────────────────
ea_log( $log, 'STEP 6 — Setting duplicate products to draft (NO deletion)' );

foreach ( $dup_ids as $sku => $id ) {
    $result = wp_update_post( [
        'ID'          => $id,
        'post_status' => 'draft',
    ] );
    if ( is_wp_error( $result ) ) {
        ea_log( $log, "ERROR: Could not set $sku (ID $id) to draft: " . $result->get_error_message() );
    } else {
        ea_log( $log, "  SKU $sku (ID $id) → status set to draft" );
    }
}

// ── Step 7: Sync variable product data ───────────────────────────────────────
ea_log( $log, 'STEP 7 — Syncing variable product price and variation data' );
WC_Product_Variable::sync( $original_id );
wc_delete_product_transients( $original_id );
ea_log( $log, "Variable product ID $original_id synced" );

// ── Final summary ─────────────────────────────────────────────────────────────
ea_log( $log, '=== EA-TEST-MERGE-005 COMPLETE ===' );
ea_log( $log, "Parent product: ID $original_id  SKU $original_sku  type=variable" );
ea_log( $log, "Variations created: " . count( $created_variation_ids ) );
ea_log( $log, "Duplicates set to draft: " . implode( ', ', array_keys( $dup_ids ) ) );
ea_log( $log, 'No products deleted.' );
