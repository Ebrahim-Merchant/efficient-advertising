<?php
/**
 * assign-ali-images.php
 * Assigns processed local images from Ali to WooCommerce products.
 */
require_once __DIR__ . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

@set_time_limit(600);
@ini_set('memory_limit', '512M');

$mapping_file = __DIR__ . '/wp-content/uploads/ali_product_images/ali_image_mapping.csv';
$images_dir   = __DIR__ . '/wp-content/uploads/ali_product_images/';

if (!file_exists($mapping_file)) {
    die("Mapping file not found: $mapping_file");
}

echo "<h1>🚀 Assigning Ali's High-Quality Images</h1>";
echo "<pre>";

$handle = fopen($mapping_file, 'r');
fgetcsv($handle); // Skip header

$subcat_images = [];
while (($data = fgetcsv($handle)) !== FALSE) {
    if (count($data) < 2) continue;
    $subcat = trim($data[0]);
    $file   = trim($data[1]);
    if (!isset($subcat_images[$subcat])) $subcat_images[$subcat] = [];
    $subcat_images[$subcat][] = $file;
}
fclose($handle);

$total_assigned = 0;

foreach ($subcat_images as $subcat => $images) {
    echo "Processing Sub-Category: <strong>$subcat</strong> (" . count($images) . " images available)\n";
    
    $term = get_term_by('name', $subcat, 'product_cat');
    if (!$term) {
        echo "  <span style='color:red;'>✗ Sub-category term not found in WordPress.</span>\n";
        continue;
    }

    $products = get_posts([
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'tax_query'      => [[
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => $term->term_id,
            'include_children' => false // Only direct products for this subcat
        ]]
    ]);

    echo "  Found " . count($products) . " products.\n";

    foreach ($products as $index => $p) {
        // Cycle through images if more products than images
        $img_file = $images[$index % count($images)];
        $full_path = $images_dir . $img_file;

        if (!file_exists($full_path)) {
            echo "    <span style='color:red;'>✗ Image file missing: $img_file</span>\n";
            continue;
        }

        // Check if image already in media library to avoid duplicates
        $attach_id = 0;
        $existing = get_posts([
            'post_type'   => 'attachment',
            'meta_query'  => [['key' => '_wp_attached_file', 'value' => 'ali_product_images/' . $img_file]],
            'posts_per_page' => 1
        ]);

        if (!empty($existing)) {
            $attach_id = $existing[0]->ID;
        } else {
            // Import to media library
            // Note: We move it to the standard uploads folder for WP compatibility
            $wp_upload_dir = wp_upload_dir();
            $filename = basename($full_path);
            $new_file_path = $wp_upload_dir['path'] . '/' . $filename;
            
            if (copy($full_path, $new_file_path)) {
                $filetype = wp_check_filetype($filename, null);
                $attachment = [
                    'guid'           => $wp_upload_dir['url'] . '/' . $filename,
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => preg_replace('/\.[^.]+$/', '', $filename),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                ];
                $attach_id = wp_insert_attachment($attachment, $new_file_path, $p->ID);
                $attach_data = wp_generate_attachment_metadata($attach_id, $new_file_path);
                wp_update_attachment_metadata($attach_id, $attach_data);
            }
        }

        if ($attach_id) {
            set_post_thumbnail($p->ID, $attach_id);
            $total_assigned++;
            echo "    ✓ Product {$p->ID} ({$p->post_title}) -> $img_file\n";
        }
    }
    echo "\n";
    flush();
}

wc_delete_product_transients();

echo "<h2>✅ Finished! Total products updated: $total_assigned</h2>";
echo "</pre>";
?>
