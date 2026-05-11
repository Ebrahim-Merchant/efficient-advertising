<?php
/**
 * EA-MASTER-EXPORT-010 — Extract all WooCommerce product data to JSON
 * EXPORT ONLY — NO DATABASE MODIFICATIONS
 */

if ( ! defined( 'ABSPATH' ) ) { exit( 'Run via WP-CLI eval-file only.' ); }

global $wpdb;

$out_dir  = __DIR__ . '/website-cleanup-dump/logs';
$out_json = $out_dir . '/current-product-master-export-727.json';

if ( ! is_dir( $out_dir ) ) { mkdir( $out_dir, 0755, true ); }

// ── 1. Fetch all product posts (published + draft) and variations ─────────────
WP_CLI::log( 'Step 1: Fetching all posts...' );
$posts = $wpdb->get_results(
    "SELECT ID, post_title, post_excerpt, post_content, post_status, post_type, post_parent
     FROM {$wpdb->posts}
     WHERE post_type IN ('product','product_variation')
       AND post_status IN ('publish','draft')
     ORDER BY post_type DESC, ID ASC",
    ARRAY_A
);

$all_ids       = array_column( $posts, 'ID' );
$product_ids   = array_column( array_filter( $posts, fn($p) => $p['post_type'] === 'product' ),            'ID' );
$variation_ids = array_column( array_filter( $posts, fn($p) => $p['post_type'] === 'product_variation' ), 'ID' );
$posts_map     = array_column( $posts, null, 'ID' );

WP_CLI::log( '  Products: ' . count( $product_ids ) . '   Variations: ' . count( $variation_ids ) );

// ── 2. Batch fetch postmeta ───────────────────────────────────────────────────
WP_CLI::log( 'Step 2: Fetching postmeta...' );
$ids_csv   = implode( ',', array_map( 'intval', $all_ids ) );
$meta_keys = [
    '_sku', '_regular_price', '_sale_price', '_thumbnail_id',
    '_product_image_gallery', '_product_attributes', 'attribute_option',
    '_yoast_wpseo_title', '_yoast_wpseo_metadesc',
    'rank_math_title', 'rank_math_description',
];
$keys_sql = "'" . implode( "','", $meta_keys ) . "'";

$all_meta = $wpdb->get_results(
    "SELECT post_id, meta_key, meta_value
     FROM {$wpdb->postmeta}
     WHERE post_id IN ($ids_csv)
       AND meta_key IN ($keys_sql)",
    ARRAY_A
);

$meta_map = [];
foreach ( $all_meta as $row ) {
    $meta_map[ (int) $row['post_id'] ][ $row['meta_key'] ] = $row['meta_value'];
}

// ── 3. Product types ──────────────────────────────────────────────────────────
WP_CLI::log( 'Step 3: Fetching product types...' );
$prod_ids_csv  = implode( ',', array_map( 'intval', $product_ids ) );
$type_rows = $wpdb->get_results(
    "SELECT tr.object_id, t.slug
     FROM {$wpdb->term_relationships} tr
     JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
     JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
     WHERE tt.taxonomy = 'product_type'
       AND tr.object_id IN ($prod_ids_csv)",
    ARRAY_A
);
$product_type_map = [];
foreach ( $type_rows as $row ) { $product_type_map[ (int) $row['object_id'] ] = $row['slug']; }

// ── 4. Category term hierarchy ────────────────────────────────────────────────
WP_CLI::log( 'Step 4: Fetching categories...' );
$term_data = $wpdb->get_results(
    "SELECT t.term_id, t.name, tt.parent
     FROM {$wpdb->terms} t
     JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id
     WHERE tt.taxonomy = 'product_cat'",
    ARRAY_A
);
$term_map = [];
foreach ( $term_data as $t ) {
    $term_map[ (int) $t['term_id'] ] = [ 'name' => $t['name'], 'parent' => (int) $t['parent'] ];
}

// Category relationships for products only (variations inherit from parent)
$cat_rels = $wpdb->get_results(
    "SELECT tr.object_id, tt.term_id
     FROM {$wpdb->term_relationships} tr
     JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
     WHERE tt.taxonomy = 'product_cat'
       AND tr.object_id IN ($prod_ids_csv)",
    ARRAY_A
);
$product_cats = [];
foreach ( $cat_rels as $row ) {
    $product_cats[ (int) $row['object_id'] ][] = (int) $row['term_id'];
}

// ── 5. Attachment data ────────────────────────────────────────────────────────
WP_CLI::log( 'Step 5: Fetching attachment data...' );
$all_att_ids = [];
foreach ( $meta_map as $pm ) {
    if ( ! empty( $pm['_thumbnail_id'] ) )       $all_att_ids[] = (int) $pm['_thumbnail_id'];
    if ( ! empty( $pm['_product_image_gallery'] ) ) {
        foreach ( explode( ',', $pm['_product_image_gallery'] ) as $gid ) {
            $gid = (int) trim( $gid );
            if ( $gid ) $all_att_ids[] = $gid;
        }
    }
}
$all_att_ids = array_unique( array_filter( $all_att_ids ) );

$attachment_data = [];
if ( $all_att_ids ) {
    $att_ids_csv = implode( ',', $all_att_ids );

    $att_posts = $wpdb->get_results(
        "SELECT ID, post_title, guid FROM {$wpdb->posts}
         WHERE ID IN ($att_ids_csv) AND post_type = 'attachment'", ARRAY_A
    );
    foreach ( $att_posts as $att ) {
        $attachment_data[ (int) $att['ID'] ] = [ 'title' => $att['post_title'], 'guid' => $att['guid'] ];
    }

    $alt_rows = $wpdb->get_results(
        "SELECT post_id, meta_value FROM {$wpdb->postmeta}
         WHERE post_id IN ($att_ids_csv) AND meta_key = '_wp_attachment_image_alt'", ARRAY_A
    );
    foreach ( $alt_rows as $row ) {
        $attachment_data[ (int) $row['post_id'] ]['alt'] = $row['meta_value'];
    }

    $file_rows = $wpdb->get_results(
        "SELECT post_id, meta_value FROM {$wpdb->postmeta}
         WHERE post_id IN ($att_ids_csv) AND meta_key = '_wp_attached_file'", ARRAY_A
    );
    foreach ( $file_rows as $row ) {
        $attachment_data[ (int) $row['post_id'] ]['file'] = basename( $row['meta_value'] );
        $attachment_data[ (int) $row['post_id'] ]['path'] = $row['meta_value'];
    }
}

// ── 6. Parent SKU map + variation child map ───────────────────────────────────
$parent_sku_map    = []; // parent_post_id => SKU
$parent_variations = []; // parent_post_id => [variation_post_ids]
foreach ( $posts as $p ) {
    $pid = (int) $p['ID'];
    if ( $p['post_type'] === 'product' ) {
        $sku = $meta_map[ $pid ]['_sku'] ?? '';
        if ( $sku ) { $parent_sku_map[ $pid ] = $sku; }
    } elseif ( $p['post_type'] === 'product_variation' ) {
        $parent_variations[ (int) $p['post_parent'] ][] = $pid;
    }
}

// ── Helper functions ──────────────────────────────────────────────────────────
function ea010_get_cats( $post_id, $product_cats, $term_map ) {
    if ( empty( $product_cats[ $post_id ] ) ) { return [ '', '' ]; }
    $cats = $subs = [];
    foreach ( $product_cats[ $post_id ] as $tid ) {
        if ( ! isset( $term_map[ $tid ] ) ) { continue; }
        if ( $term_map[ $tid ]['parent'] === 0 ) { $cats[] = $term_map[ $tid ]['name']; }
        else                                      { $subs[] = $term_map[ $tid ]['name']; }
    }
    return [ implode( ' | ', $cats ), implode( ' | ', $subs ) ];
}

// ── 7. Build export rows ──────────────────────────────────────────────────────
WP_CLI::log( 'Step 6: Building export rows...' );

$rows  = [];
$stats = [ 'simple' => 0, 'variable' => 0, 'variation' => 0, 'draft' => 0, 'no_sku' => 0, 'no_image' => 0 ];

foreach ( $posts as $p ) {
    $pid         = (int) $p['ID'];
    $post_type   = $p['post_type'];
    $post_status = $p['post_status'];
    $parent_id   = (int) $p['post_parent'];
    $pm          = $meta_map[ $pid ] ?? [];
    $sku         = $pm['_sku'] ?? '';

    // Type label
    if ( $post_type === 'product_variation' ) {
        $type_label = 'variation';
        $stats['variation']++;
    } else {
        $type_label = $product_type_map[ $pid ] ?? 'simple';
        if ( $post_status === 'draft' )        { $stats['draft']++; }
        elseif ( $type_label === 'variable' )  { $stats['variable']++; }
        else                                   { $stats['simple']++; }
    }

    if ( ! $sku ) { $stats['no_sku']++; }

    // Categories — variations inherit from parent
    $cat_source = ( $post_type === 'product_variation' ) ? $parent_id : $pid;
    [ $cat_name, $sub_cat_name ] = ea010_get_cats( $cat_source, $product_cats, $term_map );

    // Product Head + Individual Product Name
    if ( $post_type === 'product_variation' ) {
        $parent_post     = $posts_map[ $parent_id ] ?? null;
        $product_head    = $parent_post ? $parent_post['post_title'] : '';
        $option_value    = $pm['attribute_option'] ?? '';
        $individual_name = $option_value ?: $p['post_title'];
    } else {
        $product_head    = $p['post_title'];
        $individual_name = $p['post_title'];
        $option_value    = '';
    }

    // Prices
    $regular_price = $pm['_regular_price'] ?? '';
    $sale_price    = $pm['_sale_price']    ?? '';

    // Descriptions (strip HTML)
    $short_desc = trim( strip_tags( $p['post_excerpt'] ?? '' ) );
    $long_desc  = trim( strip_tags( $p['post_content'] ?? '' ) );

    // SEO
    $meta_title = $pm['_yoast_wpseo_title']   ?? $pm['rank_math_title']       ?? '';
    $meta_desc  = $pm['_yoast_wpseo_metadesc'] ?? $pm['rank_math_description'] ?? '';

    // Featured image
    $thumb_id   = $pm['_thumbnail_id'] ?? '';
    $thumb_data = $thumb_id ? ( $attachment_data[ (int) $thumb_id ] ?? [] ) : [];
    $thumb_file = $thumb_data['file'] ?? '';
    $thumb_url  = $thumb_data['guid'] ?? '';
    $thumb_alt  = $thumb_data['alt']  ?? '';
    if ( ! $thumb_id ) { $stats['no_image']++; }

    // Gallery
    $gallery_raw   = $pm['_product_image_gallery'] ?? '';
    $gallery_files = '';
    if ( $gallery_raw ) {
        $gids = array_filter( array_map( 'trim', explode( ',', $gallery_raw ) ) );
        $gnames = array_map( fn($g) => $attachment_data[ (int) $g ]['file'] ?? "id_$g", $gids );
        $gallery_files = implode( ' | ', $gnames );
    }

    // Attributes
    $attr_name = $attr_vals = '';
    $attr_raw  = $pm['_product_attributes'] ?? '';
    if ( $attr_raw ) {
        $attrs = @unserialize( $attr_raw );
        if ( is_array( $attrs ) ) {
            $anames = $avals = [];
            foreach ( $attrs as $attr ) {
                if ( is_array( $attr ) ) {
                    $anames[] = $attr['name']  ?? '';
                    $avals[]  = $attr['value'] ?? '';
                }
            }
            $attr_name = implode( ' | ', $anames );
            $attr_vals = implode( ' | ', $avals );
        }
    }

    // Variation count + linked SKUs (variable parents only)
    $var_count    = '';
    $linked_skus  = '';
    if ( $type_label === 'variable' && isset( $parent_variations[ $pid ] ) ) {
        $vids      = $parent_variations[ $pid ];
        $var_count = count( $vids );
        $vskus     = array_filter( array_map( fn($v) => $meta_map[ $v ]['_sku'] ?? '', $vids ) );
        $linked_skus = implode( ' | ', $vskus );
    }

    // Parent SKU
    $parent_sku = $parent_id ? ( $parent_sku_map[ $parent_id ] ?? '' ) : '';

    // Merge status column
    if ( $post_type === 'product_variation' )   { $merge_status = 'Variation'; }
    elseif ( $post_status === 'draft' )          { $merge_status = 'Draft (Merged Duplicate)'; }
    elseif ( $type_label === 'variable' )        { $merge_status = 'Variable Parent'; }
    else                                         { $merge_status = 'Simple (Original)'; }

    // Notes
    $notes_arr = [];
    if ( $post_type === 'product' && $type_label === 'simple' ) { $notes_arr[] = 'Product Head inferred from title'; }
    if ( ! $sku )      { $notes_arr[] = 'SKU cleared by merge'; }
    if ( ! $thumb_id ) { $notes_arr[] = 'No featured image'; }

    $rows[] = [
        'product_id'              => $pid,
        'sku'                     => $sku,
        'product_status'          => $post_status,
        'product_type'            => $type_label,
        'parent_product_id'       => $parent_id ?: '',
        'parent_sku'              => $parent_sku,
        'category_name'           => $cat_name,
        'sub_category_name'       => $sub_cat_name,
        'product_head'            => $product_head,
        'individual_product_name' => $individual_name,
        'option_variant_value'    => $option_value,
        'regular_price'           => $regular_price,
        'sale_price'              => $sale_price,
        'short_description'       => $short_desc,
        'long_description'        => $long_desc,
        'meta_title'              => $meta_title,
        'meta_description'        => $meta_desc,
        'featured_image_id'       => $thumb_id,
        'featured_image_filename' => $thumb_file,
        'featured_image_url'      => $thumb_url,
        'image_alt_text'          => $thumb_alt,
        'gallery_image_ids'       => $gallery_raw,
        'gallery_image_filenames' => $gallery_files,
        'attribute_name'          => $attr_name,
        'attribute_values'        => $attr_vals,
        'variation_count'         => $var_count,
        'linked_variation_skus'   => $linked_skus,
        'merge_status'            => $merge_status,
        'notes'                   => implode( '; ', $notes_arr ),
    ];
}

// ── 8. Write JSON ─────────────────────────────────────────────────────────────
WP_CLI::log( 'Step 7: Writing JSON...' );
file_put_contents( $out_json, json_encode(
    [ 'stats' => $stats, 'rows' => $rows ],
    JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
) );

WP_CLI::log( '' );
WP_CLI::log( '═══════════════════════════════════════════════════════════' );
WP_CLI::log( 'EA-MASTER-EXPORT-010 DATA EXTRACTED' );
WP_CLI::log( '═══════════════════════════════════════════════════════════' );
WP_CLI::log( 'Total rows     : ' . count( $rows ) );
WP_CLI::log( 'Simple (pub)   : ' . $stats['simple'] );
WP_CLI::log( 'Variable (pub) : ' . $stats['variable'] );
WP_CLI::log( 'Variations     : ' . $stats['variation'] );
WP_CLI::log( 'Draft products : ' . $stats['draft'] );
WP_CLI::log( 'No SKU         : ' . $stats['no_sku'] );
WP_CLI::log( 'No Image       : ' . $stats['no_image'] );
WP_CLI::log( "Output JSON    : $out_json" );
