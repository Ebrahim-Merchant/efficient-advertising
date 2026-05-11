<?php
/**
 * EA-MERGE-006: Batch merge duplicate products into variations — 30 groups.
 *
 * RULES:
 * - Max 30 groups, exactly as listed
 * - No deletions. Duplicates → draft only.
 * - Clear duplicate SKU before assigning to variation.
 * - Do not change images.
 * - Skip group on any SKU or product lookup failure.
 * - Full log + CSV report.
 */

// ── Group data ──────────────────────────────────────────────────────────────
// Format: [ group_id, original_sku, original_variant_label, product_head, [ [dup_sku, variant_value], ... ] ]
$groups = [
    [3, 'PS-056', 'Glossy Paper 115gsm', 'Economy Flyers', [
        ['PS-057', 'Glossy Paper 135gsm'],
        ['PS-058', 'Glossy Paper 170gsm'],
        ['PS-059', 'Wood Free Paper 100gsm'],
    ]],
    [6, 'PS-070', 'Glossy Paper 115gsm', 'DL Flyers & Leaflets', [
        ['PS-071', 'Glossy Paper 135gsm'],
        ['PS-072', 'Glossy Paper 170gsm'],
        ['PS-073', 'Glossy Paper 200gsm'],
        ['PS-074', 'Wood Free Paper 100gsm'],
    ]],
    [7, 'PS-075', 'Glossy Paper 115gsm', 'B4/B5 Flyers', [
        ['PS-076', 'Glossy Paper 135gsm'],
        ['PS-077', 'Glossy Paper 170gsm'],
        ['PS-078', 'Wood Free Paper 100gsm'],
    ]],
    [8, 'PS-079', 'Glossy Paper 115gsm', 'Bi-Fold Brochures', [
        ['PS-080', 'Glossy Paper 135gsm'],
        ['PS-081', 'Glossy Paper 170gsm'],
        ['PS-082', 'Wood Free Paper 100gsm'],
        ['PS-083', '100lb Gloss Text'],
        ['PS-084', '100lb+UV'],
        ['PS-085', '100lb+Matte'],
        ['PS-086', '80lb Enviro Uncoated'],
    ]],
    [9, 'PS-087', 'Glossy Paper 115gsm', 'Tri-Fold Brochures', [
        ['PS-088', 'Glossy Paper 135gsm'],
        ['PS-089', 'Glossy Paper 170gsm'],
        ['PS-090', 'Wood Free Paper 100gsm'],
    ]],
    [10, 'PS-091', 'Z-Fold Glossy', 'Z-Fold & Gate-Fold Brochures', [
        ['PS-092', 'Z-Fold Matte'],
        ['PS-093', 'Gate-Fold Glossy'],
        ['PS-094', 'Gate-Fold Matte'],
    ]],
    [11, 'PS-096', '10pt+Matte', 'Postcards', [
        ['PS-097', '14pt+Matte'],
        ['PS-098', '16pt+Matte'],
        ['PS-099', '14pt+UV'],
        ['PS-100', '16pt+UV'],
        ['PS-101', '18pt Gloss Lam'],
        ['PS-102', '18pt Matte/Silk Lam'],
        ['PS-103', '10pt+AQ'],
        ['PS-104', '14pt+AQ'],
        ['PS-105', '16pt+AQ'],
        ['PS-106', '13pt Enviro'],
        ['PS-107', '13pt Linen'],
        ['PS-108', '14pt Writable+AQ'],
        ['PS-109', '14pt Writable+UV'],
        ['PS-110', 'Specialty - Metallic Foil'],
        ['PS-111', 'Specialty - Kraft'],
        ['PS-112', 'Specialty - Durable'],
        ['PS-113', 'Specialty - Spot UV'],
        ['PS-114', 'Specialty - Pearl'],
    ]],
    [12, 'PS-115', '14pt+Matte', 'Bookmarks', [
        ['PS-116', '14pt+UV'],
        ['PS-117', '10pt+Matte'],
        ['PS-118', '18pt Matte/Silk Lam'],
        ['PS-119', '18pt Gloss Lam'],
        ['PS-120', '14pt Writable+UV'],
        ['PS-121', '16pt+Matte'],
        ['PS-122', '16pt+UV'],
        ['PS-123', '13pt Enviro'],
        ['PS-124', '13pt Linen'],
        ['PS-125', '18pt Matte Lam+Spot UV'],
    ]],
    [13, 'PS-126', 'Wood Free Paper 100gsm', 'Letterheads', [
        ['PS-127', 'Wood Free Paper 120gsm'],
        ['PS-128', '60lb Uncoated'],
    ]],
    [14, 'PS-129', 'Wood Free Paper 100gsm', 'Envelopes', [
        ['PS-130', 'Wood Free Paper 120gsm'],
        ['PS-131', 'Security 60lb Uncoated'],
        ['PS-132', '60lb Uncoated (Self-Adhesive)'],
    ]],
    [16, 'PS-139', 'Standard Matte Finish', 'Presentation Folders', [
        ['PS-140', 'Standard UV'],
        ['PS-141', 'Matte Laminated'],
        ['PS-142', 'Standard AQ'],
        ['PS-143', 'Specialty - Metallic Foil'],
    ]],
    [17, 'PS-156', '80lb Gloss Text', 'Saddle-Stitch Booklets', [
        ['PS-157', '100lb Gloss Text'],
        ['PS-158', '60lb Offset Text'],
        ['PS-159', '80lb Silk Text'],
        ['PS-160', '100lb Silk Text'],
    ]],
    [18, 'PS-161', 'Gloss Cover', 'Perfect-Bound Catalogues', [
        ['PS-162', 'Matte Cover'],
        ['PS-163', 'Soft Touch Cover'],
    ]],
    [20, 'PS-166', 'Saddle Stitch', 'Annual Reports', [
        ['PS-167', 'Perfect Bound'],
        ['PS-168', 'Hard Cover'],
    ]],
    [21, 'PS-169', 'B2B Catalogue', 'Product Catalogues', [
        ['PS-170', 'Retail Catalogue'],
    ]],
    [23, 'PS-175', '14pt Matte Finish', 'Invitations & Greeting Cards', [
        ['PS-176', '14pt Writable+AQ'],
        ['PS-177', '14pt AQ'],
        ['PS-178', '14pt UV'],
        ['PS-179', 'Kraft Paper'],
        ['PS-180', 'Pearl Paper'],
        ['PS-181', 'Metallic Foil'],
    ]],
    [24, 'PS-187', '80lb Gloss Text', 'Wall Calendars', [
        ['PS-188', '100lb Gloss Text'],
    ]],
    [25, 'PS-195', 'Standard Raffle Book', 'Raffle Tickets', [
        ['PS-196', 'Numbered Raffle Book'],
    ]],
    [26, 'PS-200', 'Stamp Card', 'Loyalty Cards', [
        ['PS-201', 'Points Card'],
    ]],
    [27, 'PS-202', 'Matt Lamination 350gsm', 'Laminated Menus', [
        ['PS-203', 'Glossy Lamination 350gsm'],
    ]],
    [28, 'PS-204', '4 Color - Wood Free 80gsm', 'Table Mats & Placemats', [
        ['PS-205', '4 Color - Wood Free 100gsm'],
        ['PS-206', '4 Color - Glossy 90gsm'],
        ['PS-207', '4 Color - Glossy 135gsm'],
        ['PS-208', '4 Color - Economy Paper'],
        ['PS-209', '1-2 Color - Glossy 90gsm'],
        ['PS-210', '1-2 Color - Glossy 135gsm'],
        ['PS-211', '1-2 Color - Wood Free 80gsm'],
        ['PS-212', '1-2 Color - Wood Free 100gsm'],
        ['PS-213', '1-2 Color - Economy Paper'],
    ]],
    [29, 'PS-214', 'Glossy 170gsm', 'Door Hangers', [
        ['PS-215', 'Matt Lamination 350gsm'],
        ['PS-216', 'Cane Design Matt Lam 350gsm'],
        ['PS-217', 'Butterfly Design Matt Lam 350gsm'],
        ['PS-218', 'Rounded Corner Matt Lam 350gsm'],
        ['PS-219', '14pt+Matte'],
        ['PS-220', '14pt+UV'],
        ['PS-221', '13pt Enviro Uncoated'],
    ]],
    [30, 'PS-222', 'Glossy Lamination 80gsm', 'Die-Cut Sticker Sheets', [
        ['PS-223', 'Gold Foil Glossy Lamination 80gsm'],
    ]],
    [32, 'PS-229', 'Standard Epoxy', 'Epoxy / 3D Domed Stickers', [
        ['PS-230', 'Custom Shape Epoxy'],
    ]],
    [33, 'PS-239', 'Permanent Vinyl', 'PVC White Stickers', [
        ['PS-240', 'Removable Vinyl'],
    ]],
    [34, 'PS-243', 'White Vinyl (Permanent)', 'Cut To Shape Decals', [
        ['PS-244', 'White Vinyl (Removable)'],
    ]],
    [36, 'PS-256', 'Standard DO Book', 'Delivery Order Books', [
        ['PS-257', 'Duplicate DO Book'],
    ]],
    [37, 'PS-258', '14pt Variable', 'Variable Data Printing', [
        ['PS-259', 'Matte Variable'],
        ['PS-260', 'UV Variable'],
    ]],
    [39, 'PS-271', 'CD Printing', 'CD & DVD Printing', [
        ['PS-272', 'DVD Printing'],
    ]],
    [40, 'PS-273', 'CD Cover', 'CD & DVD Covers', [
        ['PS-274', 'DVD Cover'],
    ]],
];

// ── Safety check ─────────────────────────────────────────────────────────────
if ( count( $groups ) > 30 ) {
    echo "FATAL: More than 30 groups selected (" . count( $groups ) . "). STOP.\n";
    exit( 1 );
}

// ── Report file ───────────────────────────────────────────────────────────────
$report_dir  = __DIR__ . '/website-cleanup-dump/logs';
$report_file = $report_dir . '/merge-batch-006-report.csv';
if ( ! is_dir( $report_dir ) ) {
    mkdir( $report_dir, 0755, true );
}
$fh = fopen( $report_file, 'w' );
fputcsv( $fh, [
    'group_id', 'original_sku', 'original_product_id', 'original_product_name',
    'duplicate_skus', 'variation_ids', 'drafted_product_ids', 'status', 'issues',
] );

// ── Counters ──────────────────────────────────────────────────────────────────
$total_attempted    = 0;
$total_completed    = 0;
$total_skipped      = 0;
$total_variations   = 0;
$total_drafted      = 0;
$attr_key           = 'option';
$attribute_name     = 'Option';

// ── Helper: create one variation ─────────────────────────────────────────────
function ea006_create_variation( $parent_id, $attr_key, $attr_value, $sku, $price ) {
    $variation = new WC_Product_Variation();
    $variation->set_parent_id( $parent_id );
    $variation->set_attributes( [ $attr_key => $attr_value ] );
    $variation->set_sku( $sku );
    if ( $price !== '' && $price !== null && $price !== false ) {
        $variation->set_regular_price( $price );
    }
    $variation->set_status( 'publish' );
    $variation->set_manage_stock( false );
    return $variation->save();
}

// ── Main loop ─────────────────────────────────────────────────────────────────
echo "=== EA-MERGE-006 BATCH START — " . count( $groups ) . " GROUPS ===\n";
echo date( 'Y-m-d H:i:s' ) . "\n\n";

foreach ( $groups as $entry ) {
    list( $group_id, $orig_sku, $orig_label, $product_head, $dup_pairs ) = $entry;
    $total_attempted++;

    $row_issues       = [];
    $variation_ids    = [];
    $drafted_ids      = [];
    $dup_skus_done    = [];

    echo "GROUP $group_id — $product_head  (Original: $orig_sku)\n";

    // 1. Find original
    $orig_id = wc_get_product_id_by_sku( $orig_sku );
    if ( ! $orig_id ) {
        echo "  SKIP: Original SKU $orig_sku not found in WordPress.\n";
        $total_skipped++;
        fputcsv( $fh, [ $group_id, $orig_sku, '', $product_head, '', '', '', 'SKIPPED', "Original SKU $orig_sku not found" ] );
        continue;
    }
    $orig_product = wc_get_product( $orig_id );
    $orig_name    = $orig_product->get_name();

    // 2. Skip if already variable (already processed)
    if ( $orig_product->get_type() === 'variable' ) {
        echo "  SKIP: Original ID $orig_id already variable. Already processed?\n";
        $total_skipped++;
        fputcsv( $fh, [ $group_id, $orig_sku, $orig_id, $orig_name, '', '', '', 'SKIPPED', 'Original already variable' ] );
        continue;
    }

    // 3. Verify all duplicate SKUs exist before touching anything
    $dup_products = [];
    $preflight_ok = true;
    foreach ( $dup_pairs as $pair ) {
        list( $dup_sku, $dup_val ) = $pair;
        $dup_id = wc_get_product_id_by_sku( $dup_sku );
        if ( ! $dup_id ) {
            echo "  SKIP: Duplicate SKU $dup_sku not found. Skipping whole group.\n";
            $row_issues[] = "Duplicate SKU $dup_sku not found";
            $preflight_ok = false;
            break;
        }
        $dup_products[] = [ 'sku' => $dup_sku, 'id' => $dup_id, 'val' => $dup_val ];
    }
    if ( ! $preflight_ok ) {
        $total_skipped++;
        fputcsv( $fh, [ $group_id, $orig_sku, $orig_id, $orig_name, '', '', '', 'SKIPPED', implode( '; ', $row_issues ) ] );
        continue;
    }

    // 4. Convert original → variable
    wp_set_object_terms( $orig_id, 'variable', 'product_type' );
    clean_post_cache( $orig_id );
    echo "  Original ID $orig_id → type set to variable\n";

    // 5. Build attribute with all values (original label + all dup values)
    $all_values = array_merge( [ $orig_label ], array_column( $dup_products, 'val' ) );

    $attribute = new WC_Product_Attribute();
    $attribute->set_name( $attribute_name );
    $attribute->set_options( $all_values );
    $attribute->set_position( 0 );
    $attribute->set_visible( true );
    $attribute->set_variation( true );

    $variable_product = new WC_Product_Variable( $orig_id );
    $variable_product->set_attributes( [ $attr_key => $attribute ] );
    $variable_product->save();
    echo "  Attribute '$attribute_name' set with " . count( $all_values ) . " values\n";

    // 6. Create variation for the original itself
    $orig_price  = $orig_product->get_regular_price();
    $orig_var_id = ea006_create_variation( $orig_id, $attr_key, $orig_label, $orig_sku . '-var', $orig_price );
    if ( $orig_var_id ) {
        $variation_ids[] = $orig_var_id;
        echo "  Variation $orig_var_id created: SKU={$orig_sku}-var value=$orig_label\n";
    }

    // 7. For each duplicate: clear SKU, create variation, draft product
    foreach ( $dup_products as $dp ) {
        $dup_sku = $dp['sku'];
        $dup_id  = $dp['id'];
        $dup_val = $dp['val'];

        $dup_obj = wc_get_product( $dup_id );
        if ( ! $dup_obj ) {
            $row_issues[] = "Could not load product ID $dup_id (SKU $dup_sku)";
            echo "  ERROR: Could not load duplicate product ID $dup_id.\n";
            continue;
        }

        // Clear SKU from duplicate to allow WC SKU uniqueness
        $dup_obj->set_sku( '' );
        $dup_obj->save();
        echo "  Cleared SKU $dup_sku from product ID $dup_id\n";

        // Create variation
        $dup_price = $dup_obj->get_regular_price();
        $var_id    = ea006_create_variation( $orig_id, $attr_key, $dup_val, $dup_sku, $dup_price );
        if ( ! $var_id ) {
            // Restore SKU on failure
            $dup_obj->set_sku( $dup_sku );
            $dup_obj->save();
            $row_issues[] = "Variation creation failed for SKU $dup_sku; SKU restored";
            echo "  ERROR: Variation creation failed for SKU $dup_sku. SKU restored.\n";
            continue;
        }
        $variation_ids[]  = $var_id;
        $dup_skus_done[]  = $dup_sku;
        echo "  Variation $var_id created: SKU=$dup_sku value=$dup_val\n";

        // Draft the duplicate product
        $draft_result = wp_update_post( [ 'ID' => $dup_id, 'post_status' => 'draft' ] );
        if ( is_wp_error( $draft_result ) ) {
            $row_issues[] = "Could not draft product ID $dup_id: " . $draft_result->get_error_message();
            echo "  ERROR: Could not draft product ID $dup_id.\n";
        } else {
            $drafted_ids[] = $dup_id;
            echo "  Product ID $dup_id (was $dup_sku) → draft\n";
        }
    }

    // 8. Sync variable product
    WC_Product_Variable::sync( $orig_id );
    wc_delete_product_transients( $orig_id );

    $status = empty( $row_issues ) ? 'COMPLETED' : 'COMPLETED_WITH_WARNINGS';
    $total_completed++;
    $total_variations += count( $variation_ids );
    $total_drafted    += count( $drafted_ids );

    fputcsv( $fh, [
        $group_id,
        $orig_sku,
        $orig_id,
        $orig_name,
        implode( '|', $dup_skus_done ),
        implode( '|', $variation_ids ),
        implode( '|', $drafted_ids ),
        $status,
        implode( '; ', $row_issues ),
    ] );

    echo "  GROUP $group_id STATUS: $status (" . count( $variation_ids ) . " variations, " . count( $drafted_ids ) . " drafted)\n\n";
}

fclose( $fh );

// ── Summary ───────────────────────────────────────────────────────────────────
echo "=== EA-MERGE-006 BATCH COMPLETE ===\n";
echo "Groups attempted:   $total_attempted\n";
echo "Groups completed:   $total_completed\n";
echo "Groups skipped:     $total_skipped\n";
echo "Variations created: $total_variations\n";
echo "Products drafted:   $total_drafted\n";
echo "Report:             $report_file\n";
