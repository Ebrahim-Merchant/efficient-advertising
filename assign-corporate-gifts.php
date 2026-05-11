<?php
/**
 * assign-corporate-gifts.php
 * Specifically targets the Corporate Gifts category.
 */
require_once __DIR__ . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

@set_time_limit(1800);
@ini_set('memory_limit', '1024M');

echo "<h1>🎁 Phase 3: Corporate Gifts Special Sync</h1>";
echo "<pre>";

$pool_path = __DIR__ . '/corporate_gift_image_pool.csv';
$gift_pool = [];
if (file_exists($pool_path)) {
    $fp = fopen($pool_path, "r");
    fgetcsv($fp);
    while (($row = fgetcsv($fp)) !== FALSE) {
        $gift_pool[] = ['path' => $row[1], 'filename' => $row[0]];
    }
    fclose($fp);
}
echo "Loaded " . count($gift_pool) . " candidate images for gifts.\n";

$GIFT_SUBCATS = [
    'Branded Apparel' => ['tshirt', 'cap', 'shirt', 'hoodie', 'apparel'],
    'Drinkware' => ['mug', 'cup', 'bottle', 'flask', 'drinkware'],
    'Bags & Accessories' => ['bag', 'tote', 'backpack', 'pouch'],
    'Office & Desktop Gifts' => ['pen', 'notebook', 'diary', 'desktop'],
    'Office Essentials' => ['pen', 'notebook', 'calc', 'folder'],
    'Tech Products' => ['usb', 'powerbank', 'speaker', 'tech', 'cable'],
    'Premium & Specialty Gifts' => ['luxury', 'wallet', 'watch', 'premium'],
    'Executive Kit' => ['kit', 'set', 'box', 'gift'],
    'Event Disposables' => ['cup', 'plate', 'napkin', 'disposable']
];

$updated = 0;

foreach ($GIFT_SUBCATS as $subcat => $keys) {
    echo "\nProcessing: <strong>$subcat</strong>\n";
    $term = get_term_by('name', $subcat, 'product_cat');
    if (!$term) continue;

    $products = get_posts([
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'tax_query' => [['taxonomy'=>'product_cat','field'=>'term_id','terms'=>$term->term_id]]
    ]);

    // Find sub-pool matching these keys
    $sub_pool = array_filter($gift_pool, function($img) use ($keys) {
        foreach ($keys as $k) {
            if (stripos($img['filename'], $k) !== false) return true;
        }
        return false;
    });
    $sub_pool = array_values($sub_pool);
    echo "  - " . count($sub_pool) . " targeted images found for " . count($products) . " products.\n";

    if (empty($sub_pool)) continue;

    foreach ($products as $idx => $p) {
        $img_id = get_post_thumbnail_id($p->ID);
        $file = $img_id ? basename(get_attached_file($img_id)) : '';

        // If it's a placeholder or missing, update it
        if (empty($file) || strpos($file, 'ea-sub-') === 0) {
            $match = $sub_pool[$idx % count($sub_pool)];
            $local_path = $match['path'];

            $res = wp_insert_attachment_from_path($local_path, $p->ID, $p->post_title);
            if ($res) {
                set_post_thumbnail($p->ID, $res);
                $updated++;
                echo "    ✓ Assigned: {$p->post_title} -> " . basename($local_path) . "\n";
            }
        }
    }
}

function wp_insert_attachment_from_path($path, $parent_id, $title) {
    if (!file_exists($path)) return false;
    $wp_upload_dir = wp_upload_dir();
    $name = basename($path);
    
    // Check if already in generic library
    $existing = get_posts(['post_type'=>'attachment', 'meta_query'=>[['key'=>'_gift_source_path','value'=>$path]], 'posts_per_page'=>1]);
    if (!empty($existing)) return $existing[0]->ID;

    $new_path = $wp_upload_dir['path'] . '/' . $name;
    if (copy($path, $new_path)) {
        $filetype = wp_check_filetype($name, null);
        $attachment = [
            'guid' => $wp_upload_dir['url'] . '/' . $name,
            'post_mime_type' => $filetype['type'],
            'post_title' => $title,
            'post_content'   => '',
            'post_status'    => 'inherit'
        ];
        $attach_id = wp_insert_attachment($attachment, $new_path, $parent_id);
        update_post_meta($attach_id, '_gift_source_path', $path);
        wp_update_attachment_metadata($attach_id, wp_generate_attachment_metadata($attach_id, $new_path));
        return $attach_id;
    }
    return false;
}

wc_delete_product_transients();
echo "\n<h2>🎉 Corporate Gifts Sync Complete!</h2>";
echo "Total gifts updated: $updated\n";
echo "</pre>";
?>
