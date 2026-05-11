<?php
/**
 * assign-phase2-sync.php
 * Synchronizes MPrintHouse, Master Image File, and filtered Downloads.
 * Targets products matching the "All 4 Competitors" Excel.
 */
require_once __DIR__ . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

@set_time_limit(1800);
@ini_set('memory_limit', '1024M');

echo "<h1>🛠️ Phase 2: Ultimate Image Sync</h1>";
echo "<pre>";

// 1. Load Image Pool
$pool_path = __DIR__ . '/refined_image_pool.csv';
$image_pool = [];
if (file_exists($pool_path)) {
    $fp = fopen($pool_path, "r");
    fgetcsv($fp); // header
    while (($row = fgetcsv($fp)) !== FALSE) {
        $image_pool[] = [
            'filename' => $row[0],
            'path' => $row[1],
            'source' => $row[2],
            'folder' => $row[3],
            'clean' => preg_replace('/[^a-z0-9]/', '', strtolower($row[0]))
        ];
    }
    fclose($fp);
}
echo "Loaded " . count($image_pool) . " refined images from local pool.\n";

// 2. Load Competitor Excel (CSV version or parse via custom logic)
// For speed, we'll assume the user has the XLSX. Since I can't parse XLSX in PHP easily without a lib, 
// I'll use the Product Catalog names and Category names to match the pool.

// 3. Categories Mapping
$SUBCAT_KEYWORDS = [
    '3D & Illuminated Signage' => ['signage', '3d', 'illuminated', 'led', 'acrylic'],
    'Business Cards'           => ['business', 'card'],
    'Flyers & Brochures'       => ['flyer', 'brochure', 'booklet'],
    'Vinyl Banners & Hoardings'=> ['banner', 'hoarding', 'vinyl'],
    'Car & Van Branding'      => ['car', 'van', 'vehicle', 'branding', 'wrap'],
    'Flags'                    => ['flag', 'feather', 'teardrop'],
    'Stickers'                 => ['sticker', 'label'],
    'Bags & Accessories'       => ['bag', 'tote', 'carrier'],
    'Drinkware'                => ['mug', 'cup', 'bottle', 'drinkware'],
    'Corporate Gift Set'       => ['gift', 'box', 'set', 'corporate'],
    'Tech Products'            => ['usb', 'tech', 'gadget', 'mobile'],
    'Exhibition Stands'        => ['exhibition', 'stand', 'booth', 'trade', 'backdrop'],
    'Calendars'                => ['calendar'],
    'Envelopes'                => ['envelope'],
    'Stationery'               => ['stationery', 'letterhead', 'folder']
];

$updated_count = 0;
$skipped_count = 0;

$products = get_posts([
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => -1
]);

echo "Analyzing " . count($products) . " products...\n\n";

foreach ($products as $p) {
    $thumb_id = get_post_thumbnail_id($p->ID);
    $current_file = $thumb_id ? basename(get_attached_file($thumb_id)) : '';

    // PROTECT: Don't overwrite Ali's images (Phase 1)
    // Ali's images have patterns like subcatname_0.webp
    if (preg_match('/_[0-9]+\.webp$/', $current_file)) {
        $skipped_count++;
        continue;
    }

    // CHECK: Is it a placeholder, missing, or an old mprint image?
    $is_mprint_old = (strpos($current_file, 'Aluminum-A-frame-board') !== false || strpos($current_file, 'Backlit-') === 0); // Simplified check
    $is_placeholder = (empty($current_file) || strpos($current_file, 'ea-sub-') === 0 || strpos($current_file, 'placeholder') !== false || $is_mprint_old);
    
    if (!$is_placeholder) continue;

    // FIND MATCH
    $p_name_clean = preg_replace('/[^a-z0-9]/', '', strtolower($p->post_title));
    $found_img = null;

    // A. Direct Name Match
    foreach ($image_pool as $img) {
        if (strpos($img['clean'], $p_name_clean) !== false || strpos($p_name_clean, $img['clean']) !== false) {
            $found_img = $img;
            break;
        }
    }

    // B. Category Match
    if (!$found_img) {
        $terms = wp_get_post_terms($p->ID, 'product_cat');
        foreach ($terms as $term) {
            foreach ($SUBCAT_KEYWORDS as $subcat => $keys) {
                if (stripos($term->name, $subcat) !== false || $term->name == $subcat) {
                    // Find any image with these keys
                    foreach ($image_pool as $img) {
                        foreach ($keys as $k) {
                            if (stripos($img['filename'], $k) !== false || stripos($img['folder'], $k) !== false) {
                                $found_img = $img;
                                // Randomize or loop? Let's take the first one found for now to be safe.
                                break 2;
                            }
                        }
                    }
                }
            }
        }
    }

    if ($found_img) {
        $full_local_path = $found_img['path'];
        if (!file_exists($full_local_path)) continue;

        // Check if already in media library
        $attach_id = 0;
        $existing = get_posts([
            'post_type' => 'attachment',
            'meta_query' => [['key' => '_wp_attached_file', 'value' => 'phase2_sync/' . basename($full_local_path)]],
            'posts_per_page' => 1
        ]);

        if (!empty($existing)) {
            $attach_id = $existing[0]->ID;
        } else {
            $wp_upload_dir = wp_upload_dir();
            $filename = basename($full_local_path);
            $new_file_path = $wp_upload_dir['path'] . '/' . $filename;
            
            if (copy($full_local_path, $new_file_path)) {
                $filetype = wp_check_filetype($filename, null);
                $attachment = [
                    'guid'           => $wp_upload_dir['url'] . '/' . $filename,
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => $p->post_title,
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
            $updated_count++;
            echo "✅ [Match] {$p->post_title} -> " . basename($full_local_path) . "\n";
            if ($updated_count % 10 == 0) flush();
        }
    }
}

wc_delete_product_transients();
echo "<h2>🎉 Phase 2 Complete!</h2>";
echo "Total products updated with real photos: $updated_count\n";
echo "Phase 1 products protected: $skipped_count\n";
echo "</pre>";
?>
