<?php
/**
 * assign-mprint-images-v2.php
 * Phase 2: Integrate MPrintHouse collection.
 * NOW UPDATED: Overwrites "ea-sub-*" placeholders with real MPrintHouse photos.
 */
require_once __DIR__ . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

@set_time_limit(1200);
@ini_set('memory_limit', '512M');

$manifest_path = __DIR__ . '/wp-content/uploads/mprint_processed/_manifest.csv';
$images_base   = __DIR__ . '/wp-content/uploads/mprint_processed/';

if (!file_exists($manifest_path)) {
    die("Error: MPrintHouse Manifest not found: $manifest_path");
}

echo "<h1>🚀 Phase 2: MPrintHouse - Overwriting Placeholders</h1>";
echo "<pre>";

// 1. Load MPrintHouse Manifest
$mprint_data = [];
$handle = fopen($manifest_path, "r");
$headers = fgetcsv($handle); 
while (($row = fgetcsv($handle)) !== FALSE) {
    if (count($row) < 5) continue;
    $mprint_data[] = [
        'name' => trim($row[0]),
        'cat' => trim($row[2]),
        'path' => trim($row[4])
    ];
}
fclose($handle);
echo "Loaded " . count($mprint_data) . " MPrintHouse images.\n\n";

// 2. Mapping
$CAT_MAP = [
    'Stationery & Corporate' => ['Business Cards', 'Stationery', 'Calendars', 'Drinkware', 'Office Essentials', 'Corporate Gift Set', 'Tech Products', 'Executive Kit', 'Premium & Specialty Gifts', 'Tickets & Coupons', 'Voucher Books', 'Seals & Stamps', 'Certificates & Invitations'],
    'Custom Signage'        => ['3D & Illuminated Signage', 'Light Box Signage', 'LED & Digital Signage', 'Rigid Board Signage', 'Wayfinding & Directory', 'Safety Signage', 'Name Plates & Labels', 'Large Format & Panel Signs'],
    'Backdrops & Displays' => ['Backdrops', 'Pull-Up & Roll-Up Banners', 'Pop-Up & Portable Displays', 'Roll Labels & Stickers', 'Standees & Cutouts', 'POS Display', 'Frame Banners & Stands'],
    'Banners Printing'      => ['Vinyl Banners & Hoardings', 'Large Format Posters'],
    'Vehicle Branding'      => ['Car & Van Branding', 'Fleet Branding', 'Boat & Yacht Branding'],
    'Custom Flags'          => ['Feather & Sail Flags', 'Tear Drop & Blade Flags', 'Indoor & Corporate Flags', 'Decorative Flags', 'Flag Bases & Accessories'],
    'Exhibitions & Events'  => ['Exhibition Stands & Booths', 'Trade Shows & Events', 'Event Accessories', 'Event Props', 'Event Disposables', 'Party Essentials'],
    'Others'                => ['Stickers', 'Sticker Printing', 'Wall Décor', 'Wall Frames', 'Wall Graphics & Decals', 'Floor Graphics', 'Repositionable Cling', 'Canvas Prints', 'Magnets', 'Custom Packaging', 'Product Boxes', 'Food & Beverage Packaging', 'Mailer & Corrugated Boxes', 'Flexible Packaging']
];

$updated_total = 0;

foreach ($CAT_MAP as $mprint_cat => $woo_subcats) {
    // Get mprint images
    $available_images = array_values(array_filter($mprint_data, function($item) use ($mprint_cat) {
        return strpos($item['cat'], $mprint_cat) !== false;
    }));

    if (empty($available_images)) continue;

    foreach ($woo_subcats as $subcat) {
        $term = get_term_by('name', $subcat, 'product_cat');
        if (!$term) continue;

        $products = get_posts([
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'tax_query'      => [[
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $term->term_id,
            ]]
        ]);

        foreach ($products as $idx => $p) {
            $current_img_id = get_post_thumbnail_id($p->ID);
            $current_img_file = $current_img_id ? basename(get_attached_file($current_img_id)) : '';
            
            // LOGIC: Only overwrite if NO image OR if it's an "ea-sub-*" placeholder
            // AND we don't want to overwrite Ali's images (anything .webp with an underscore and digit)
            $is_placeholder = (empty($current_img_file) || strpos($current_img_file, 'ea-sub-') === 0 || strpos($current_img_file, 'ea-alt-') === 0);
            
            if (!$is_placeholder) continue;

            $mprint_item = $available_images[$idx % count($available_images)];
            $rel_path = str_replace('C:\Users\merch\Desktop\mprinthouse-images\\', '', $mprint_item['path']);
            $full_local_path = $images_base . $rel_path;

            if (!file_exists($full_local_path)) continue;

            // Import/Get matching attachment
            $attach_id = 0;
            $existing = get_posts([
                'post_type'   => 'attachment',
                'meta_query'  => [['key' => '_wp_attached_file', 'value' => 'mprint_processed/' . $rel_path]],
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
                        'post_title'     => $mprint_item['name'],
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
                $updated_total++;
                echo "✓ [{$subcat}] Updated: {$p->post_title} -> " . basename($full_local_path) . "\n";
                if ($updated_total % 20 == 0) flush();
            }
        }
    }
}

wc_delete_product_transients();
echo "<h2>✅ Finished! Total products updated to real photos: $updated_total</h2>";
echo "</pre>";
?>
