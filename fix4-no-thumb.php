<?php
/**
 * Fix 4: Assign images to products with no thumbnail where the SKU image file exists.
 * Targets PS-174 and PS-171 which were missed (likely not in sku_matches.csv).
 */

$targets = [
    'PS-174' => 'ps-174.webp',
    'PS-171' => 'ps-171.webp',
];

$upload_dir    = wp_upload_dir();
$sku_image_dir = $upload_dir['basedir'] . '/product-sku-images/';
$sku_image_url = $upload_dir['baseurl'] . '/product-sku-images/';

$assigned  = 0;
$errors    = 0;

foreach ( $targets as $sku => $filename ) {
    $product_id = wc_get_product_id_by_sku( $sku );
    if ( ! $product_id ) {
        WP_CLI::warning( "SKU $sku: product not found." );
        $errors++;
        continue;
    }

    $filepath = $sku_image_dir . $filename;
    if ( ! file_exists( $filepath ) ) {
        WP_CLI::warning( "SKU $sku: file not found at $filepath" );
        $errors++;
        continue;
    }

    $fileurl = $sku_image_url . $filename;

    // Check if attachment already registered
    $attachment_id = attachment_url_to_postid( $fileurl );

    if ( ! $attachment_id ) {
        $attachment = [
            'post_mime_type' => 'image/webp',
            'post_title'     => sanitize_file_name( $filename ),
            'post_content'   => '',
            'post_status'    => 'inherit',
        ];
        $attachment_id = wp_insert_attachment( $attachment, $filepath, $product_id );
        if ( is_wp_error( $attachment_id ) ) {
            WP_CLI::warning( "SKU $sku: wp_insert_attachment failed — " . $attachment_id->get_error_message() );
            $errors++;
            continue;
        }
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $metadata = wp_generate_attachment_metadata( $attachment_id, $filepath );
        wp_update_attachment_metadata( $attachment_id, $metadata );
    }

    $result = set_post_thumbnail( $product_id, $attachment_id );
    if ( $result ) {
        WP_CLI::success( "SKU=$sku  Product=$product_id  AttachmentID=$attachment_id" );
        $assigned++;
    } else {
        WP_CLI::warning( "SKU $sku: set_post_thumbnail failed." );
        $errors++;
    }
}

WP_CLI::log( "\n--- Fix 4 Summary ---" );
WP_CLI::log( "Assigned : $assigned" );
WP_CLI::log( "Errors   : $errors" );
WP_CLI::log( "\nNote: 7 remaining products have no SKU and no image file — require manual image assignment in WP Admin." );
WP_CLI::log( "  ID=945  Ceremonial Ribbon Printing" );
WP_CLI::log( "  ID=942  Barricades Banners" );
WP_CLI::log( "  ID=317  Lama Stand" );
WP_CLI::log( "  ID=187  Acrylic Signage" );
WP_CLI::log( "  ID=183  Soft Loop Handle Bag" );
WP_CLI::log( "  ID=177  Business Cards" );
WP_CLI::log( "  ID=168  Wall Sticker Printing" );
