<?php
/**
 * ea-flag-audit.php — Flag Products Image Audit
 * Shows current image assignments and available clean alternatives.
 * DELETE THIS FILE when done.
 */
define('ABSPATH', __DIR__ . '/');
require_once __DIR__ . '/wp-load.php';
if (!current_user_can('manage_options')) { wp_die('Unauthorized'); }

$uploads_url  = content_url('uploads');
$uploads_dir  = WP_CONTENT_DIR . '/uploads';
$mprint_dir   = $uploads_dir . '/mprint_processed/Custom-Flags';
$mprint_url   = $uploads_url . '/mprint_processed/Custom-Flags';

// All flag product folders in mprint_processed
$flag_folders = [];
if (is_dir($mprint_dir)) {
    foreach (scandir($mprint_dir) as $f) {
        if ($f[0] === '.') continue;
        $path = $mprint_dir . '/' . $f;
        if (is_dir($path)) {
            $files = array_values(array_filter(scandir($path), fn($x) => !str_starts_with($x,'.')));
            $flag_folders[$f] = $files;
        }
    }
}

// Map: flag product title keywords => mprint_processed folder name
$product_folder_map = [
    'Bunting'    => 'Bunting-flags',
    'Pennant'    => 'Pennant-flags',
    'Toothpick'  => 'Tooth-Pick-Flags',
    'Tooth Pick' => 'Tooth-Pick-Flags',
    'Car Flag'   => 'Car-Flags',
    'Car Desert' => 'Car-Flags',
    'Dashboard'  => 'Car-Flags',
    'Teardrop'   => 'Teardrop-Flags',
    'Tear Drop'  => 'Teardrop-Flags',
    'Blade'      => 'Blade-Flags',
    'Feather'    => 'Sail-Flags',
    'Sail'       => 'Sail-Flags',
    'Festival'   => 'Hand-Flags',
    'Country'    => 'Wall-Mounted-Flags',
    'Table'      => 'Table-Flags',
    'L-Shape'    => 'L-Shaped-Flags',
    'L Shape'    => 'L-Shaped-Flags',
    'Hoisting'   => 'Hoisting-Flag',
    'Conference' => 'Conference-Flags',
    'Hand Wave'  => 'Hand-Waving-Pole-Flags',
    'Racing'     => 'Racing-flags',
    'Stadium'    => 'Stadium-Crowd-Flags',
    'Pointing'   => 'Pointing-Flags',
    'Finishing'  => 'Finishing-Line-Flags',
    'Telescopic' => 'Telescopic-Flag',
    'Body'       => 'Body-Flags',
    'Boat'       => 'Boat-flags',
    'Cluster'    => 'Cluster-flags',
];

// Base/stand folders that should NEVER be product images
$base_folders = ['Concrete-Base','Cross-base-(x-base)','Fiber-Base','Metal-Base',
                 'Spike-base','T-550-Water-Base','Water-Base'];

// Get all flag-category products
$products = get_posts([
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
    'tax_query'      => [[
        'taxonomy' => 'product_cat',
        'field'    => 'name',
        'terms'    => ['Custom Flags','Flags','Feather & Sail Flags','Tear Drop & Blade Flags'],
        'operator' => 'IN',
    ]],
]);

// Also get any product with "flag" in title not in those cats
$all_flag_products = get_posts([
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    's'              => 'flag',
    'orderby'        => 'title',
    'order'          => 'ASC',
]);
$found_ids = array_column($products, 'ID');
foreach ($all_flag_products as $p) {
    if (!in_array($p->ID, $found_ids)) {
        $products[] = $p;
        $found_ids[] = $p->ID;
    }
}
usort($products, fn($a,$b) => strcmp($a->post_title, $b->post_title));
?>
<!DOCTYPE html><html><head><meta charset='utf-8'>
<title>Flag Image Audit</title>
<style>
  body{font-family:system-ui;background:#0d0d1a;color:#e0e0e0;padding:24px;margin:0}
  h1{color:#FFBA09;margin-bottom:4px}
  .sub{color:#888;margin-bottom:24px;font-size:13px}
  .card{background:#151525;border:1px solid #252540;border-radius:8px;margin-bottom:20px;overflow:hidden}
  .card-head{padding:12px 16px;background:#1a1a30;border-bottom:1px solid #252540;display:flex;align-items:center;gap:12px}
  .card-head h3{margin:0;font-size:15px;color:#fff}
  .badge{font-size:11px;padding:2px 8px;border-radius:12px;font-weight:600}
  .badge-ok{background:#1a3d1a;color:#4caf50}
  .badge-warn{background:#3d2a00;color:#FFBA09}
  .badge-err{background:#3d0000;color:#ff5555}
  .card-body{display:grid;grid-template-columns:180px 180px 1fr;gap:0}
  .img-block{padding:12px;border-right:1px solid #252540}
  .img-block img{width:156px;height:120px;object-fit:cover;border-radius:4px;display:block}
  .img-block .label{font-size:11px;color:#888;margin-top:6px;word-break:break-all}
  .img-block .sublabel{font-size:10px;color:#555;margin-top:2px}
  .info-block{padding:12px 16px;font-size:12px}
  .info-block table{border-collapse:collapse;width:100%}
  .info-block td{padding:3px 6px;vertical-align:top}
  .info-block td:first-child{color:#888;white-space:nowrap;width:140px}
  .alt-grid{display:flex;flex-wrap:wrap;gap:6px;margin-top:8px}
  .alt-grid img{width:70px;height:56px;object-fit:cover;border-radius:3px;border:2px solid #333;cursor:pointer}
  .alt-grid img:hover{border-color:#FFBA09}
  .section-label{font-size:11px;color:#FFBA09;font-weight:600;margin-bottom:4px;margin-top:10px}
  .no-img{width:156px;height:120px;background:#1a1a2e;border-radius:4px;display:flex;align-items:center;justify-content:center;color:#555;font-size:11px}
  .watermark-warn{background:#3d1a00;border:1px solid #ff8c00;color:#ffa040;font-size:11px;padding:4px 8px;border-radius:4px;margin-top:6px}
  .action-btn{display:inline-block;padding:4px 10px;background:#FFBA09;color:#000;font-size:11px;font-weight:700;border-radius:4px;text-decoration:none;margin-top:8px;cursor:pointer;border:none}
  .action-btn.red{background:#f44336;color:#fff}
  .summary-bar{background:#1a1a30;border:1px solid #252540;border-radius:8px;padding:16px;margin-bottom:24px;display:flex;gap:32px}
  .stat{text-align:center}
  .stat .n{font-size:28px;font-weight:700;color:#FFBA09}
  .stat .l{font-size:11px;color:#888;margin-top:2px}
</style></head><body>
<h1>Flag Product Image Audit</h1>
<p class='sub'>Checking competitors watermarks, wrong images, and available clean alternatives</p>

<?php
$total = count($products);
$has_thumb = 0; $no_thumb = 0; $needs_fix = 0;
// Pre-calc stats
foreach ($products as $p) {
    $tid = get_post_thumbnail_id($p->ID);
    if ($tid) { $has_thumb++; } else { $no_thumb++; }
}

echo "<div class='summary-bar'>
  <div class='stat'><div class='n'>$total</div><div class='l'>Flag Products</div></div>
  <div class='stat'><div class='n'>$has_thumb</div><div class='l'>Have Featured Image</div></div>
  <div class='stat'><div class='n'>$no_thumb</div><div class='l'>Missing Image</div></div>
  <div class='stat'><div class='n'>" . count($base_folders) . "</div><div class='l'>Base/Stand Folders<br><small style='color:#f44'>(should never be product image)</small></div></div>
</div>";

foreach ($products as $p) {
    $cats = wp_get_post_terms($p->ID, 'product_cat', ['fields'=>'names']);
    $cat_str = implode(', ', $cats);
    $tid = get_post_thumbnail_id($p->ID);
    $thumb_url = $tid ? wp_get_attachment_url($tid) : null;
    $thumb_meta = $tid ? wp_get_attachment_metadata($tid) : null;
    $gallery_raw = get_post_meta($p->ID, '_product_image_gallery', true);
    $gallery_ids = array_filter(explode(',', $gallery_raw ?: ''));

    // Detect if current image is a base/stand
    $is_base = false;
    $base_name = '';
    if ($thumb_url) {
        foreach ($base_folders as $bf) {
            if (stripos($thumb_url, $bf) !== false || stripos($thumb_url, str_replace('-',' ',$bf)) !== false) {
                $is_base = true; $base_name = $bf; break;
            }
        }
    }

    // Find best available clean folder for this product
    $clean_folder = null;
    $title_lower = strtolower($p->post_title);
    foreach ($product_folder_map as $keyword => $folder) {
        if (stripos($title_lower, strtolower($keyword)) !== false) {
            if (!in_array($folder, $base_folders) && isset($flag_folders[$folder])) {
                $clean_folder = $folder;
                break;
            }
        }
    }

    // Figure out status
    if (!$tid) {
        $status = ['label'=>'Missing Image', 'class'=>'badge-err'];
    } elseif ($is_base) {
        $status = ['label'=>'WRONG: Shows Base/Stand', 'class'=>'badge-err'];
    } else {
        $status = ['label'=>'Has Image (verify)', 'class'=>'badge-warn'];
    }

    echo "<div class='card'>";
    echo "<div class='card-head'>";
    echo "<h3>" . esc_html($p->post_title) . " <small style='color:#666;font-weight:400'>ID:{$p->ID}</small></h3>";
    echo "<span class='badge {$status['class']}'>{$status['label']}</span>";
    if ($is_base) echo "<span class='badge badge-err' style='background:#4a0000'>⚠ Base/Stand Image</span>";
    echo "<small style='color:#555;margin-left:auto'>" . esc_html($cat_str) . "</small>";
    echo "</div>";

    echo "<div class='card-body'>";

    // Current image
    echo "<div class='img-block'>";
    echo "<div class='section-label'>CURRENT IMAGE</div>";
    if ($thumb_url) {
        echo "<img src='" . esc_url($thumb_url) . "' onerror=\"this.style.display='none'\">";
        $filename = basename($thumb_url);
        echo "<div class='label'>" . esc_html($filename) . "</div>";
        echo "<div class='sublabel'>Attachment ID: $tid</div>";
        if ($is_base) {
            echo "<div class='watermark-warn'>⚠ This is a BASE/STAND image<br>folder: $base_name</div>";
        }
    } else {
        echo "<div class='no-img'>No Image</div>";
    }
    echo "</div>";

    // Gallery
    echo "<div class='img-block'>";
    echo "<div class='section-label'>GALLERY (" . count($gallery_ids) . " images)</div>";
    if ($gallery_ids) {
        $first_gid = array_shift(array_values($gallery_ids));
        $gurl = wp_get_attachment_url($first_gid);
        if ($gurl) {
            echo "<img src='" . esc_url($gurl) . "' onerror=\"this.style.display='none'\">";
            echo "<div class='label'>" . esc_html(basename($gurl)) . "</div>";
        } else {
            echo "<div class='no-img'>Gallery empty</div>";
        }
    } else {
        echo "<div class='no-img'>No gallery</div>";
    }
    echo "</div>";

    // Info + alternatives
    echo "<div class='info-block'>";
    echo "<div class='section-label'>PRODUCT DETAILS</div>";
    echo "<table>";
    echo "<tr><td>Slug:</td><td><small>" . esc_html($p->post_name) . "</small></td></tr>";
    echo "<tr><td>Category:</td><td>" . esc_html($cat_str) . "</td></tr>";
    echo "<tr><td>Thumb ID:</td><td>" . ($tid ?: '<span style=color:#f44>NONE</span>') . "</td></tr>";
    echo "<tr><td>Gallery IDs:</td><td>" . (implode(', ', $gallery_ids) ?: 'none') . "</td></tr>";
    echo "</table>";

    if ($clean_folder) {
        echo "<div class='section-label' style='margin-top:12px'>CLEAN ALTERNATIVES (mprint_processed)</div>";
        echo "<div class='alt-grid'>";
        foreach ($flag_folders[$clean_folder] as $img) {
            $img_url = $mprint_url . '/' . rawurlencode($clean_folder) . '/' . rawurlencode($img);
            echo "<img src='" . esc_url($img_url) . "' title='" . esc_attr("$clean_folder/$img") . "' onerror=\"this.parentNode.removeChild(this)\">";
        }
        echo "</div>";
        echo "<div style='margin-top:8px;font-size:11px;color:#888'>Folder: <code>mprint_processed/Custom-Flags/$clean_folder/</code></div>";
    } else {
        echo "<div class='section-label' style='margin-top:12px;color:#f44'>NO CLEAN FOLDER MAPPED</div>";
        echo "<div style='font-size:11px;color:#888'>Own photos needed for this product.</div>";
    }
    echo "</div>"; // info-block

    echo "</div>"; // card-body
    echo "</div>"; // card
}
?>
<p style='color:#555;font-size:12px;margin-top:24px'>DELETE ea-flag-audit.php after use.</p>
</body></html>
