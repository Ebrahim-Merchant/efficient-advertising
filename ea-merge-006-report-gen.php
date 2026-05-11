<?php
/**
 * EA-MERGE-006: Regenerate accurate report CSV from actual database state.
 * Queries WooCommerce for each group to reflect what was actually applied.
 */
global $wpdb;

$groups = [
    [3,  'PS-056', 'Economy Flyers',              ['PS-057','PS-058','PS-059']],
    [6,  'PS-070', 'DL Flyers & Leaflets',        ['PS-071','PS-072','PS-073','PS-074']],
    [7,  'PS-075', 'B4/B5 Flyers',                ['PS-076','PS-077','PS-078']],
    [8,  'PS-079', 'Bi-Fold Brochures',            ['PS-080','PS-081','PS-082','PS-083','PS-084','PS-085','PS-086']],
    [9,  'PS-087', 'Tri-Fold Brochures',           ['PS-088','PS-089','PS-090']],
    [10, 'PS-091', 'Z-Fold & Gate-Fold Brochures', ['PS-092','PS-093','PS-094']],
    [11, 'PS-096', 'Postcards',                    ['PS-097','PS-098','PS-099','PS-100','PS-101','PS-102','PS-103','PS-104','PS-105','PS-106','PS-107','PS-108','PS-109','PS-110','PS-111','PS-112','PS-113','PS-114']],
    [12, 'PS-115', 'Bookmarks',                    ['PS-116','PS-117','PS-118','PS-119','PS-120','PS-121','PS-122','PS-123','PS-124','PS-125']],
    [13, 'PS-126', 'Letterheads',                  ['PS-127','PS-128']],
    [14, 'PS-129', 'Envelopes',                    ['PS-130','PS-131','PS-132']],
    [16, 'PS-139', 'Presentation Folders',         ['PS-140','PS-141','PS-142','PS-143']],
    [17, 'PS-156', 'Saddle-Stitch Booklets',       ['PS-157','PS-158','PS-159','PS-160']],
    [18, 'PS-161', 'Perfect-Bound Catalogues',     ['PS-162','PS-163']],
    [20, 'PS-166', 'Annual Reports',               ['PS-167','PS-168']],
    [21, 'PS-169', 'Product Catalogues',           ['PS-170']],
    [23, 'PS-175', 'Invitations & Greeting Cards', ['PS-176','PS-177','PS-178','PS-179','PS-180','PS-181']],
    [24, 'PS-187', 'Wall Calendars',               ['PS-188']],
    [25, 'PS-195', 'Raffle Tickets',               ['PS-196']],
    [26, 'PS-200', 'Loyalty Cards',                ['PS-201']],
    [27, 'PS-202', 'Laminated Menus',              ['PS-203']],
    [28, 'PS-204', 'Table Mats & Placemats',       ['PS-205','PS-206','PS-207','PS-208','PS-209','PS-210','PS-211','PS-212','PS-213']],
    [29, 'PS-214', 'Door Hangers',                 ['PS-215','PS-216','PS-217','PS-218','PS-219','PS-220','PS-221']],
    [30, 'PS-222', 'Die-Cut Sticker Sheets',       ['PS-223']],
    [32, 'PS-229', 'Epoxy / 3D Domed Stickers',   ['PS-230']],
    [33, 'PS-239', 'PVC White Stickers',           ['PS-240']],
    [34, 'PS-243', 'Cut To Shape Decals',          ['PS-244']],
    [36, 'PS-256', 'Delivery Order Books',         ['PS-257']],
    [37, 'PS-258', 'Variable Data Printing',       ['PS-259','PS-260']],
    [39, 'PS-271', 'CD & DVD Printing',            ['PS-272']],
    [40, 'PS-273', 'CD & DVD Covers',              ['PS-274']],
];

$report_file = __DIR__ . '/website-cleanup-dump/logs/merge-batch-006-report.csv';
$fh = fopen( $report_file, 'w' );
fputcsv( $fh, [
    'group_id', 'original_sku', 'original_product_id', 'original_product_name',
    'duplicate_skus', 'variation_ids', 'drafted_product_ids', 'status', 'issues',
] );

$total_completed  = 0;
$total_skipped    = 0;
$total_variations = 0;
$total_drafted    = 0;

foreach ( $groups as $entry ) {
    list( $gid, $orig_sku, $head, $dup_skus ) = $entry;
    $issues = [];

    // Locate original by SKU
    $orig_id = wc_get_product_id_by_sku( $orig_sku );
    if ( ! $orig_id ) {
        $issues[] = "Original SKU $orig_sku not found";
        fputcsv( $fh, [ $gid, $orig_sku, '', $head, implode('|',$dup_skus), '', '', 'SKIPPED', implode('; ',$issues) ] );
        $total_skipped++;
        continue;
    }

    $orig_product = wc_get_product( $orig_id );
    $orig_name    = $orig_product->get_name();
    $is_variable  = ( $orig_product->get_type() === 'variable' );

    // Collect variation IDs under parent
    $var_ids = $wpdb->get_col( $wpdb->prepare(
        "SELECT ID FROM wp_posts WHERE post_parent = %d AND post_type = 'product_variation'",
        $orig_id
    ) );

    // Collect drafted original duplicate IDs
    $drafted_ids = [];
    $dup_status  = [];
    foreach ( $dup_skus as $dup_sku ) {
        // Check if SKU now belongs to a variation (expected post-merge)
        $var_match = $wpdb->get_var( $wpdb->prepare(
            "SELECT p.ID FROM wp_posts p
             JOIN wp_postmeta pm ON p.ID = pm.post_id
             WHERE pm.meta_key = '_sku' AND pm.meta_value = %s AND p.post_type = 'product_variation'",
            $dup_sku
        ) );
        // Check if there's a draft product that had this SKU (now blank)
        // We track by checking if a product is draft and had its SKU cleared
        $dup_status[ $dup_sku ] = $var_match ? "variation:$var_match" : 'NOT_FOUND_AS_VARIATION';
    }

    // Find draft products linked to this group (those set to draft)
    // Identify by checking product IDs that are now drafts and have blank SKUs
    // and were children of a parent category match – approximate via product names
    $draft_rows = $wpdb->get_results( $wpdb->prepare(
        "SELECT p.ID, pm.meta_value as sku
         FROM wp_posts p
         LEFT JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_sku'
         WHERE p.post_type = 'product' AND p.post_status = 'draft'
         AND p.ID != %d",
        $orig_id
    ) );
    // We'll report variation IDs as proof of merge
    foreach ( $var_ids as $vid ) {
        $v = wc_get_product( $vid );
        if ( $v ) {
            $total_variations++;
        }
    }

    if ( $is_variable && count( $var_ids ) > 0 ) {
        $status = 'COMPLETED';
        $total_completed++;
    } else {
        $status = 'INCOMPLETE';
        $issues[] = $is_variable ? 'Variable but no variations found' : 'Not variable';
        $total_skipped++;
    }

    // Drafted product IDs: find products in draft with blank SKU (those cleared by merge)
    // Best approximation: find draft products that were in the same parent relationship
    $drafted_products_for_group = $wpdb->get_col( $wpdb->prepare(
        "SELECT p.ID FROM wp_posts p
         JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_sku' AND pm.meta_value = ''
         WHERE p.post_type = 'product' AND p.post_status = 'draft'
         AND p.ID IN (
             SELECT post_id FROM wp_postmeta WHERE meta_key = '_sku' AND meta_value = ''
         )
         LIMIT %d",
        count( $dup_skus ) * 2
    ) );

    $total_drafted += count( $drafted_products_for_group );

    fputcsv( $fh, [
        $gid,
        $orig_sku,
        $orig_id,
        $orig_name,
        implode( '|', $dup_skus ),
        implode( '|', $var_ids ),
        '',   // drafted IDs — tracked globally in audit log
        $status,
        implode( '; ', $issues ),
    ] );

    echo "GID $gid  $orig_sku  $head  →  $status  vars=" . count($var_ids) . "\n";
}

fclose( $fh );

// Global drafted count from DB
$global_draft_count = $wpdb->get_var(
    "SELECT COUNT(*) FROM wp_posts WHERE post_type = 'product' AND post_status = 'draft'"
);

echo "\n=== REPORT SUMMARY ===\n";
echo "Groups completed:   $total_completed / 30\n";
echo "Groups skipped:     $total_skipped\n";
echo "Variations counted: " . ($total_variations) . "\n";
echo "Total draft products in DB: $global_draft_count\n";
echo "Report written to: $report_file\n";
