<?php
/**
 * ea-full-image-audit.php
 * Scans ALL WooCommerce products and generates a downloadable Excel-compatible CSV.
 * Checks every product's featured image and gallery against:
 *   - mprint_processed (competitor-scraped images)
 *   - ali_product_images (category image archive)
 * DELETE THIS FILE immediately after downloading the report.
 */

// ─── Bootstrap ───────────────────────────────────────────────────────────────
define('ABSPATH', __DIR__ . '/');
ini_set('memory_limit', '512M');
set_time_limit(300);
require_once __DIR__ . '/wp-load.php';
if (!current_user_can('manage_options')) { wp_die('Unauthorized'); }

// ─── Paths ────────────────────────────────────────────────────────────────────
$uploads_dir   = WP_CONTENT_DIR . '/uploads';
$mprint_dir    = $uploads_dir . '/mprint_processed';
$ali_dir       = $uploads_dir . '/ali_product_images';
$manifest_csv  = $mprint_dir . '/_manifest.csv';
$ali_map_csv   = $ali_dir . '/ali_image_mapping.csv';

// ─── Load mprint_processed manifest (Slug → rows) ────────────────────────────
$mprint_by_slug = [];   // [slug => [row, ...]]
$mprint_by_name = [];   // [lowercase product name => [row, ...]]
if (file_exists($manifest_csv)) {
    $fh = fopen($manifest_csv, 'r');
    $header = fgetcsv($fh);
    while ($row = fgetcsv($fh)) {
        if (count($row) < count($header)) continue;
        $data = array_combine($header, $row);
        $s = strtolower(trim($data['Slug']));
        $n = strtolower(trim($data['ProductName']));
        $mprint_by_slug[$s][] = $data;
        $mprint_by_name[$n][] = $data;
    }
    fclose($fh);
}

// ─── Load ali_image_mapping (woo_subcat → filenames) ─────────────────────────
$ali_by_subcat = [];    // [lowercase subcat => [filename, ...]]
if (file_exists($ali_map_csv)) {
    $fh = fopen($ali_map_csv, 'r');
    $header = fgetcsv($fh);
    while ($row = fgetcsv($fh)) {
        if (count($row) < 2) continue;
        $data = array_combine($header, $row);
        $sc = strtolower(trim($data['woo_subcat']));
        $ali_by_subcat[$sc][] = trim($data['assigned_file']);
    }
    fclose($fh);
}

// ─── Known base/stand/hardware-only folders (NEVER correct as product image) ──
$bad_folders = [
    // Flag hardware
    'concrete-base','cross-base-(x-base)','fiber-base','metal-base',
    'spike-base','t-550-water-base','water-base',
    // Banner finishing/hardware
    'd-ring-banner-hanging','grommets_eyelets-banner-hanging',
    'heat_clean-cut-banner-edge-finishing','hems-banner-finishing',
    'loop_pocket-pole-banner-hanging','rope-stitch-banner-hanging',
    'stitching-fabric-banner-edge-finishing','velcro-fabric-banner-edge-finishing',
    'ceremonial-ribbon-printing',
];

// Normalise to lowercase for matching
$bad_folders = array_map('strtolower', $bad_folders);

// ─── Index actual files in mprint_processed ──────────────────────────────────
// Build a flat map: normalized product folder → [file, ...]
$mprint_files = [];   // ['category/product-folder' => [files]]
if (is_dir($mprint_dir)) {
    foreach (scandir($mprint_dir) as $cat) {
        if ($cat[0] === '.' || !is_dir("$mprint_dir/$cat")) continue;
        foreach (scandir("$mprint_dir/$cat") as $prod) {
            if ($prod[0] === '.' || !is_dir("$mprint_dir/$cat/$prod")) continue;
            $key = strtolower("$cat/$prod");
            $files = array_values(array_filter(scandir("$mprint_dir/$cat/$prod"), fn($f) => $f[0] !== '.'));
            $mprint_files[$key] = $files;
        }
    }
}

// ─── Index ali_product_images webp files ─────────────────────────────────────
$ali_files_on_disk = [];  // [prefix => [files]]
if (is_dir($ali_dir)) {
    foreach (scandir($ali_dir) as $f) {
        if (!str_ends_with($f, '.webp')) continue;
        // prefix = everything before last _N.webp
        $prefix = preg_replace('/_\d+\.webp$/', '', $f);
        $ali_files_on_disk[$prefix][] = $f;
    }
}

// ─── Helper: classify an image URL ───────────────────────────────────────────
function classify_image(string $url, array $bad_folders, string $mprint_dir): array {
    if (empty($url)) {
        return [
            'source'        => 'NONE',
            'source_folder' => '',
            'is_bad_type'   => false,
            'risk'          => 'HIGH',
            'risk_reason'   => 'No image assigned',
        ];
    }

    $url_lower = strtolower($url);

    // mprint_processed source
    if (strpos($url_lower, '/mprint_processed/') !== false) {
        // Extract the path after mprint_processed/
        preg_match('#/mprint_processed/([^/]+)/([^/?]+)#i', $url, $m);
        $cat_folder  = isset($m[1]) ? strtolower($m[1]) : '';
        $prod_folder = isset($m[2]) ? strtolower($m[2]) : '';
        $is_bad = in_array($prod_folder, $bad_folders, true);
        return [
            'source'        => 'mprint_processed',
            'source_folder' => ($cat_folder ? "$cat_folder/$prod_folder" : ''),
            'is_bad_type'   => $is_bad,
            'risk'          => $is_bad ? 'CRITICAL' : 'HIGH',
            'risk_reason'   => $is_bad
                ? 'Competitor image AND wrong type (base/stand/hardware)'
                : 'Competitor scraped image (mprinthouse.ae) – possible watermark',
        ];
    }

    // ali_product_images source
    if (strpos($url_lower, '/ali_product_images/') !== false) {
        return [
            'source'        => 'ali_product_images',
            'source_folder' => '',
            'is_bad_type'   => false,
            'risk'          => 'MEDIUM',
            'risk_reason'   => 'Third-party stock image – verify licence and accuracy',
        ];
    }

    // Regular WordPress upload (year folder)
    if (preg_match('#/uploads/(20\d\d)/\d\d/#', $url)) {
        return [
            'source'        => 'wp_media_library',
            'source_folder' => '',
            'is_bad_type'   => false,
            'risk'          => 'LOW',
            'risk_reason'   => 'Standard WP upload – manually verify image accuracy',
        ];
    }

    return [
        'source'        => 'other',
        'source_folder' => '',
        'is_bad_type'   => false,
        'risk'          => 'MEDIUM',
        'risk_reason'   => 'Unknown source – verify manually',
    ];
}

// ─── Helper: find best mprint manifest match ─────────────────────────────────
function find_mprint_match(WP_Post $p, array $by_slug, array $by_name): array {
    $slug = strtolower($p->post_name);
    if (isset($by_slug[$slug])) {
        $row = $by_slug[$slug][0];
        return [
            'match'     => 'YES (by slug)',
            'name'      => $row['ProductName'],
            'saved'     => $row['SavedPath'],
            'status'    => $row['Status'],
        ];
    }
    $title = strtolower($p->post_title);
    if (isset($by_name[$title])) {
        $row = $by_name[$title][0];
        return [
            'match'  => 'YES (by name)',
            'name'   => $row['ProductName'],
            'saved'  => $row['SavedPath'],
            'status' => $row['Status'],
        ];
    }
    // Fuzzy: check if slug words appear in any manifest key
    $words = explode('-', $slug);
    foreach ($by_slug as $ms => $rows) {
        $hits = 0;
        foreach ($words as $w) {
            if (strlen($w) > 3 && strpos($ms, $w) !== false) $hits++;
        }
        if ($hits >= 2) {
            return [
                'match'  => 'PARTIAL (fuzzy)',
                'name'   => $rows[0]['ProductName'],
                'saved'  => $rows[0]['SavedPath'],
                'status' => $rows[0]['Status'],
            ];
        }
    }
    return ['match'=>'NO','name'=>'','saved'=>'','status'=>''];
}

// ─── Helper: find ali image match ────────────────────────────────────────────
function find_ali_match(array $cats, array $ali_by_subcat, array $ali_files_on_disk): array {
    foreach ($cats as $cat_name) {
        $cn = strtolower($cat_name);
        if (isset($ali_by_subcat[$cn])) {
            $files = $ali_by_subcat[$cn];
            $count = count($files);
            // Check first file actually exists on disk
            $prefix = preg_replace('/_\d+\.webp$/', '', $files[0]);
            $exists = isset($ali_files_on_disk[$prefix]);
            return ['match'=>'YES', 'files'=>$count, 'file_exists'=>($exists?'YES':'NO'), 'category'=>$cat_name];
        }
    }
    return ['match'=>'NO','files'=>0,'file_exists'=>'NO','category'=>''];
}

// ─── Recommended action logic ─────────────────────────────────────────────────
function recommend(array $info, array $mprint, array $ali): string {
    if ($info['risk'] === 'NONE') return 'OK - No action needed';

    if ($info['source'] === 'NONE') {
        if ($mprint['match'] !== 'NO' && $mprint['status'] === 'OK') {
            return 'ASSIGN: Use mprint_processed image (verify no watermark first)';
        }
        if ($ali['match'] === 'YES' && $ali['file_exists'] === 'YES') {
            return 'ASSIGN: Use ali_product_images image';
        }
        return 'URGENT: Upload own product photo – no archive match found';
    }

    if ($info['is_bad_type']) {
        if ($mprint['match'] !== 'NO') return 'REPLACE: Wrong image type (base/stand) – use correct mprint image';
        if ($ali['match'] === 'YES') return 'REPLACE: Wrong image type – use ali_product_images';
        return 'REPLACE: Wrong image type + no archive match – need own photo';
    }

    if ($info['source'] === 'mprint_processed') {
        return 'REVIEW: Check for watermark – replace with own photo if found';
    }

    if ($info['source'] === 'ali_product_images') {
        return 'REVIEW: Verify image accuracy and licence';
    }

    return 'VERIFY: Confirm image is correct product';
}

// ─── Get ALL products ─────────────────────────────────────────────────────────
$products = get_posts([
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
]);

// ─── Output CSV ───────────────────────────────────────────────────────────────
$filename = 'EfficientAdvt-Image-Audit-' . date('Ymd-His') . '.csv';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
header('Expires: 0');

$out = fopen('php://output', 'w');
// UTF-8 BOM for Excel
fwrite($out, "\xEF\xBB\xBF");

// ─── Headers ──────────────────────────────────────────────────────────────────
fputcsv($out, [
    'Product ID',
    'Product Title',
    'Product Slug',
    'WC Category (Parent)',
    'WC Sub-Category',
    '— CURRENT IMAGE —',
    'Has Featured Image',
    'Featured Image Filename',
    'Featured Image URL',
    'Image Source',
    'Image Source Folder',
    'Gallery Count',
    '— RISK ASSESSMENT —',
    'Risk Level',
    'Risk Reason',
    'Is Wrong Image Type (base/stand/hardware)',
    '— ARCHIVE MATCH: mprint_processed (Competitor) —',
    'mprint Manifest Match',
    'mprint Product Name Match',
    'mprint Saved File Path',
    'mprint File Status',
    '— ARCHIVE MATCH: ali_product_images —',
    'ali Image Match',
    'ali Matched Category',
    'ali Image Count Available',
    'ali File Exists on Disk',
    '— ACTION —',
    'Recommended Action',
    'Notes',
]);

// ─── Data rows ────────────────────────────────────────────────────────────────
$row_num = 0;
foreach ($products as $p) {
    $row_num++;

    // Categories
    $all_cats = wp_get_post_terms($p->ID, 'product_cat', ['fields'=>'all']);
    $parent_cats = []; $child_cats = [];
    foreach ($all_cats as $cat) {
        if ($cat->parent == 0) $parent_cats[] = $cat->name;
        else                    $child_cats[]  = $cat->name;
    }
    if (empty($parent_cats)) $parent_cats = ['(none)'];
    if (empty($child_cats))  $child_cats  = ['(none)'];

    // Featured image
    $thumb_id  = get_post_thumbnail_id($p->ID);
    $thumb_url = $thumb_id ? (wp_get_attachment_url($thumb_id) ?: '') : '';
    $has_thumb = !empty($thumb_url) ? 'YES' : 'NO';
    $thumb_file = $thumb_url ? basename(parse_url($thumb_url, PHP_URL_PATH)) : '';

    // Gallery
    $gallery_raw = get_post_meta($p->ID, '_product_image_gallery', true);
    $gallery_ids = array_filter(explode(',', $gallery_raw ?: ''));
    $gallery_count = count($gallery_ids);

    // Classify image
    $info = classify_image($thumb_url, $bad_folders, $mprint_dir);

    // mprint manifest match
    $mprint = find_mprint_match($p, $mprint_by_slug, $mprint_by_name);

    // ali match (check all category names)
    $all_cat_names = array_merge($parent_cats, $child_cats);
    $ali = find_ali_match($all_cat_names, $ali_by_subcat, $ali_files_on_disk);

    // Recommendation
    $action = recommend($info, $mprint, $ali);

    // Notes
    $notes = '';
    if ($gallery_count > 0 && $has_thumb === 'NO') {
        $notes = 'Has gallery images but no featured image – promote first gallery image';
    }
    if ($info['source'] === 'mprint_processed' && $info['is_bad_type']) {
        $notes .= ($notes?'; ':'') . 'Image is from base/stand folder – clearly wrong product image';
    }

    fputcsv($out, [
        $p->ID,
        $p->post_title,
        $p->post_name,
        implode(' | ', $parent_cats),
        implode(' | ', $child_cats),
        '—', // section divider column
        $has_thumb,
        $thumb_file,
        $thumb_url,
        $info['source'],
        $info['source_folder'],
        $gallery_count,
        '—', // section divider
        $info['risk'],
        $info['risk_reason'],
        $info['is_bad_type'] ? 'YES' : 'NO',
        '—', // section divider
        $mprint['match'],
        $mprint['name'],
        $mprint['saved'],
        $mprint['status'],
        '—', // section divider
        $ali['match'],
        $ali['category'],
        $ali['files'],
        $ali['file_exists'],
        '—', // section divider
        $action,
        $notes,
    ]);
}

fclose($out);
exit;
