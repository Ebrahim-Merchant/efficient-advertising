<?php
/**
 * ea-img-audit.php — Product Image Audit
 * Lists all WooCommerce products, their categories, slugs, and featured image status.
 * DELETE THIS FILE when done.
 */

define('ABSPATH', __DIR__ . '/');
require_once __DIR__ . '/wp-load.php';

if (!current_user_can('manage_options') && !(defined('WP_CLI') && WP_CLI)) {
    wp_die('Unauthorized');
}

$products = get_posts([
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
]);

$manifest_path = __DIR__ . '/wp-content/uploads/mprint_processed/_manifest.csv';
$manifest = [];
if (file_exists($manifest_path)) {
    $fh = fopen($manifest_path, 'r');
    $header = fgetcsv($fh);
    while ($row = fgetcsv($fh)) {
        $data = array_combine($header, $row);
        $slug = trim($data['Slug']);
        if (!isset($manifest[$slug])) {
            $manifest[$slug] = [];
        }
        $manifest[$slug][] = $data;
    }
    fclose($fh);
}

$with_img    = 0;
$without_img = 0;
$matched     = 0;

echo "<!DOCTYPE html><html><head><meta charset='utf-8'>";
echo "<title>EfficientAdvt – Product Image Audit</title>";
echo "<style>
  body { font-family: monospace; font-size:13px; background:#111; color:#eee; padding:20px; }
  h1 { color:#FFBA09; }
  table { border-collapse:collapse; width:100%; margin-top:10px; }
  th { background:#222; color:#FFBA09; padding:6px 10px; text-align:left; border:1px solid #333; }
  td { padding:5px 10px; border:1px solid #222; vertical-align:top; }
  tr:hover { background:#1a1a1a; }
  .yes  { color:#4caf50; font-weight:bold; }
  .no   { color:#f44336; font-weight:bold; }
  .match{ color:#2196F3; font-weight:bold; }
  .summary { margin:10px 0; color:#ccc; background:#1a1a1a; padding:12px; border-left:4px solid #FFBA09; }
</style></head><body>";

echo "<h1>Product Image Audit</h1>";
echo "<p style='color:#aaa'>Total products: <strong style='color:#fff'>" . count($products) . "</strong></p>";

echo "<table><tr>
  <th>#</th>
  <th>ID</th>
  <th>Product Title</th>
  <th>Slug</th>
  <th>Category</th>
  <th>Featured Image</th>
  <th>Gallery Images</th>
  <th>Manifest Match</th>
  <th>Image File Exists</th>
</tr>";

$i = 0;
foreach ($products as $p) {
    $i++;
    $cats = wp_get_post_terms($p->ID, 'product_cat', ['fields' => 'names']);
    $cat_str = implode(', ', $cats);

    $thumb_id  = get_post_thumbnail_id($p->ID);
    $has_thumb = !empty($thumb_id) && get_post($thumb_id);
    if ($has_thumb) $with_img++; else $without_img++;

    $gallery_raw = get_post_meta($p->ID, '_product_image_gallery', true);
    $gallery_ids = array_filter(explode(',', $gallery_raw));
    $gallery_count = count($gallery_ids);

    $slug = $p->post_name;
    $in_manifest = isset($manifest[$slug]);
    if ($in_manifest) $matched++;

    $file_exists_str = '-';
    if ($in_manifest) {
        $first = $manifest[$slug][0];
        $saved = trim($first['SavedPath']);
        // Convert Desktop path to mprint_processed equivalent
        // SavedPath: C:\Users\merch\Desktop\mprinthouse-images\Category\Product\image.webp
        // Actual:    wp-content/uploads/mprint_processed/Category/Product/image.webp
        if (preg_match('/mprinthouse-images[\\\\/](.+)/', $saved, $m)) {
            $rel = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $m[1]);
            $actual = __DIR__ . '/wp-content/uploads/mprint_processed/' . $rel;
            $file_exists_str = file_exists($actual)
                ? "<span class='yes'>YES</span>"
                : "<span class='no'>NO (path: " . esc_html($actual) . ")</span>";
        }
    }

    $thumb_text  = $has_thumb  ? "<span class='yes'>YES (ID: $thumb_id)</span>"    : "<span class='no'>NO</span>";
    $gallery_text= $gallery_count ? "<span class='match'>$gallery_count image(s)</span>" : "<span class='no'>none</span>";
    $manifest_text = $in_manifest ? "<span class='match'>YES (" . count($manifest[$slug]) . " images)</span>" : "<span class='no'>NO</span>";

    echo "<tr>
      <td>$i</td>
      <td>$p->ID</td>
      <td>" . esc_html($p->post_title) . "</td>
      <td><small>" . esc_html($slug) . "</small></td>
      <td><small>" . esc_html($cat_str) . "</small></td>
      <td>$thumb_text</td>
      <td>$gallery_text</td>
      <td>$manifest_text</td>
      <td>$file_exists_str</td>
    </tr>";
}

echo "</table>";
echo "<div class='summary'>
  <strong>Summary:</strong><br>
  ✅ With featured image: <strong>$with_img</strong><br>
  ❌ Without featured image: <strong>$without_img</strong><br>
  🔵 Matched in manifest: <strong>$matched</strong>
</div>";

echo "</body></html>";
