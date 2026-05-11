<?php
/**
 * Deep investigation of broken product images.
 * Checks: site URL, uploads URL, attachment records, file existence, thumbnail meta.
 * Run: wp eval-file investigate-images.php
 */

// ─── 1. Site / uploads configuration ────────────────────────────────────────
WP_CLI::log("=== SITE CONFIGURATION ===");
WP_CLI::log("home        : " . get_option('home'));
WP_CLI::log("siteurl     : " . get_option('siteurl'));
WP_CLI::log("upload_url  : " . wp_upload_dir()['baseurl']);
WP_CLI::log("upload_path : " . wp_upload_dir()['basedir']);
WP_CLI::log("upload_url_path (override): " . get_option('upload_url_path'));
WP_CLI::log("");

// ─── 2. Sample: 10 products — check SKU, attachment ID, file URL, file on disk ──
WP_CLI::log("=== SAMPLE PRODUCT → IMAGE AUDIT (10 products) ===");
$products = get_posts(array(
    'post_type'      => 'product',
    'posts_per_page' => 10,
    'fields'         => 'ids',
    'orderby'        => 'ID',
    'order'          => 'ASC',
));

foreach ($products as $pid) {
    $sku    = get_post_meta($pid, '_sku', true);
    $tid    = get_post_thumbnail_id($pid);
    if (!$tid) {
        WP_CLI::log("  Product $pid (SKU=$sku) → NO THUMBNAIL SET");
        continue;
    }
    $url    = wp_get_attachment_url($tid);
    $meta   = wp_get_attachment_metadata($tid);
    $file   = get_attached_file($tid);          // absolute path on disk
    $exists = $file && file_exists($file);

    WP_CLI::log("  Product $pid (SKU=$sku)");
    WP_CLI::log("    attach_id : $tid");
    WP_CLI::log("    url       : $url");
    WP_CLI::log("    file_path : $file");
    WP_CLI::log("    on_disk   : " . ($exists ? "YES" : "NO ← MISSING"));
    WP_CLI::log("    meta_file : " . ($meta['file'] ?? '(no meta)'));
    WP_CLI::log("");
}

// ─── 3. Scan ALL attachments pointing to product-sku-images ─────────────────
WP_CLI::log("=== ATTACHMENT RECORDS FOR product-sku-images ===");
global $wpdb;
$rows = $wpdb->get_results("
    SELECT p.ID, p.guid, pm.meta_value AS file
    FROM {$wpdb->posts} p
    JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID AND pm.meta_key = '_wp_attached_file'
    WHERE p.post_type = 'attachment'
      AND pm.meta_value LIKE '%product-sku-images%'
    ORDER BY p.ID ASC
    LIMIT 20
");

if (empty($rows)) {
    WP_CLI::warning("No attachments found pointing to product-sku-images folder!");
} else {
    foreach ($rows as $r) {
        $abs  = wp_upload_dir()['basedir'] . '/' . $r->file;
        $disk = file_exists($abs) ? "YES" : "NO ← MISSING ON DISK";
        WP_CLI::log("  ID={$r->ID}  file={$r->file}  guid={$r->guid}  disk=$disk");
    }
}
WP_CLI::log("");

// ─── 4. Check a recently-assigned product (OB-013 / ID=1735) ────────────────
WP_CLI::log("=== DETAILED CHECK: OB-013 (product ID 1735) ===");
$pid  = 1735;
$tid  = get_post_thumbnail_id($pid);
WP_CLI::log("thumbnail_id : $tid");
if ($tid) {
    WP_CLI::log("guid         : " . get_post_field('guid', $tid));
    WP_CLI::log("attach_url   : " . wp_get_attachment_url($tid));
    WP_CLI::log("attach_file  : " . get_attached_file($tid));
    WP_CLI::log("file exists  : " . (file_exists(get_attached_file($tid)) ? "YES" : "NO"));
    $meta = get_post_meta($tid, '_wp_attached_file', true);
    WP_CLI::log("_wp_attached_file meta: $meta");
}
WP_CLI::log("");

// ─── 5. Check a product that had an image BEFORE the script ran ─────────────
WP_CLI::log("=== DETAILED CHECK: PS-095 (product ID 3676, pre-existing image) ===");
$pid  = 3676;
$tid  = get_post_thumbnail_id($pid);
WP_CLI::log("thumbnail_id : $tid");
if ($tid) {
    WP_CLI::log("guid         : " . get_post_field('guid', $tid));
    WP_CLI::log("attach_url   : " . wp_get_attachment_url($tid));
    WP_CLI::log("attach_file  : " . get_attached_file($tid));
    WP_CLI::log("file exists  : " . (file_exists(get_attached_file($tid)) ? "YES" : "NO"));
    $meta = get_post_meta($tid, '_wp_attached_file', true);
    WP_CLI::log("_wp_attached_file meta: $meta");
}
WP_CLI::log("");

// ─── 6. Count attachments with missing files ─────────────────────────────────
WP_CLI::log("=== BROKEN IMAGE COUNT (sample 200 product attachments) ===");
$broken = 0; $ok = 0;
$att_ids = $wpdb->get_col("
    SELECT p.ID FROM {$wpdb->posts} p
    WHERE p.post_type = 'attachment'
      AND p.post_mime_type LIKE 'image/%'
    ORDER BY p.ID DESC
    LIMIT 200
");
foreach ($att_ids as $aid) {
    $f = get_attached_file($aid);
    if ($f && file_exists($f)) $ok++;
    else $broken++;
}
WP_CLI::log("  OK     : $ok");
WP_CLI::log("  Broken : $broken  (file missing on disk)");
WP_CLI::log("");

// ─── 7. Check uploads folder structure ───────────────────────────────────────
WP_CLI::log("=== UPLOADS FOLDER STRUCTURE ===");
$base = wp_upload_dir()['basedir'];
$dirs = glob($base . '/*', GLOB_ONLYDIR);
foreach ($dirs as $d) {
    $count = count(glob($d . '/*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE));
    WP_CLI::log("  " . basename($d) . " — $count image files");
}
$sku_dir = $base . '/product-sku-images';
if (is_dir($sku_dir)) {
    $count = count(glob($sku_dir . '/*.webp'));
    WP_CLI::log("  product-sku-images — $count .webp files (confirmed)");
} else {
    WP_CLI::warning("  product-sku-images folder NOT FOUND at: $sku_dir");
}
