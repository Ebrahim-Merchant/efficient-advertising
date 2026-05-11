<?php
/**
 * Assign existing product-sku-images to WooCommerce products by SKU.
 * Files already exist in uploads/product-sku-images/ — no upload needed.
 * Run via WP-CLI: wp eval-file assign-sku-images.php
 *
 * Optional: pass --limit=N to test on first N rows only.
 *           pass --dry-run to preview without making changes.
 */

$csv_path     = 'C:/Users/merch/sku_matches_v2.csv';
$uploads_dir  = WP_CONTENT_DIR . '/uploads/product-sku-images/';
$uploads_url  = content_url( 'uploads/product-sku-images/' );

// --- Config: change these before running ---
$dry_run = false;  // Set to false for the real run
$limit   = 0;      // Set to 0 to process all rows
// -------------------------------------------

if ( ! file_exists( $csv_path ) ) {
    WP_CLI::error( "CSV not found: $csv_path" );
    exit(1);
}

$handle = fopen( $csv_path, 'r' );
$header = fgetcsv( $handle ); // skip header row

$count     = 0;
$assigned  = 0;
$skipped   = 0;
$not_found = 0;
$errors    = 0;

WP_CLI::log( $dry_run ? "DRY RUN — no changes will be made.\n" : "Assigning images to products...\n" );

while ( ( $row = fgetcsv( $handle ) ) !== false ) {
    if ( $limit > 0 && $count >= $limit ) break;

    $sku      = trim( $row[1] );  // col 0=product_id, col 1=sku, col 2=filename
    $filename = strtolower( trim( $row[2] ) ); // filename column
    $filepath = $uploads_dir . $filename;
    $fileurl  = $uploads_url . $filename;

    if ( ! file_exists( $filepath ) ) {
        WP_CLI::warning( "File not found on disk: $filepath" );
        $not_found++;
        $count++;
        continue;
    }

    // Find the product by SKU — try as-is first, then lowercase (DB stores lowercase)
    $product_id = wc_get_product_id_by_sku( $sku );
    if ( ! $product_id ) {
        $product_id = wc_get_product_id_by_sku( strtolower( $sku ) );
    }
    if ( ! $product_id ) {
        WP_CLI::warning( "No product found for SKU: $sku" );
        $not_found++;
        $count++;
        continue;
    }

    // Check if this product already has a featured image
    $existing_thumb = get_post_thumbnail_id( $product_id );
    if ( $existing_thumb ) {
        // Only skip if the existing image is already from the product-sku-images/ folder.
        // If it's anywhere else (generic placeholder, old upload), allow the override.
        $existing_file = get_attached_file( $existing_thumb );
        $existing_path = str_replace( '\\', '/', (string) $existing_file );
        if ( strpos( $existing_path, '/product-sku-images/' ) !== false ) {
            // Already has the correct SKU image — skip
            $skipped++;
            $count++;
            continue;
        }
        // Existing image is a generic placeholder — fall through to override
    }

    // Look for existing attachment by file path in postmeta
    $existing_attachment_id = attachment_url_to_postid( $fileurl );

    if ( ! $existing_attachment_id ) {
        // Not in media library yet — register the existing file as an attachment
        if ( ! $dry_run ) {
            $filetype = wp_check_filetype( $filename );
            $attachment = [
                'post_mime_type' => $filetype['type'],
                'post_title'     => sanitize_file_name( pathinfo( $filename, PATHINFO_FILENAME ) ),
                'post_content'   => '',
                'post_status'    => 'inherit',
            ];
            $existing_attachment_id = wp_insert_attachment( $attachment, $filepath, $product_id );
            if ( is_wp_error( $existing_attachment_id ) ) {
                WP_CLI::warning( "Failed to register attachment for SKU $sku: " . $existing_attachment_id->get_error_message() );
                $errors++;
                $count++;
                continue;
            }
            // Generate attachment metadata (thumbnail sizes etc.)
            require_once ABSPATH . 'wp-admin/includes/image.php';
            $attach_data = wp_generate_attachment_metadata( $existing_attachment_id, $filepath );
            wp_update_attachment_metadata( $existing_attachment_id, $attach_data );
        } else {
            WP_CLI::log( "[DRY RUN] Would register + assign: SKU=$sku  File=$filename  ProductID=$product_id" );
            $assigned++;
            $count++;
            continue;
        }
    }

    // Set as featured image
    if ( ! $dry_run ) {
        $result = set_post_thumbnail( $product_id, $existing_attachment_id );
        if ( $result ) {
            WP_CLI::success( "SKU=$sku  Product=$product_id  AttachmentID=$existing_attachment_id" );
            $assigned++;
        } else {
            WP_CLI::warning( "set_post_thumbnail failed for SKU=$sku" );
            $errors++;
        }
    }

    $count++;
}

fclose( $handle );

WP_CLI::log( "\n--- Summary ---" );
WP_CLI::log( "Processed : $count" );
WP_CLI::log( "Assigned  : $assigned" );
WP_CLI::log( "Skipped (already had image): $skipped" );
WP_CLI::log( "Not found (SKU or file): $not_found" );
WP_CLI::log( "Errors    : $errors" );
