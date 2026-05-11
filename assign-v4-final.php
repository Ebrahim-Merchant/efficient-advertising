<?php
/**
 * assign-v4-final.php
 * Final Watermark-Free Sync: Correct Orientation & Clean Crops
 */
require_once __DIR__ . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

@set_time_limit(1800);
echo "<h1>🛡️ Phase 4: Final Clean Sync (Correct Orientation)</h1>";
echo "<pre>";

$pool_path = __DIR__ . '/refined_image_pool_v4.csv';
$image_pool = [];
if (file_exists($pool_path)) {
    $fp = fopen($pool_path, "r");
    fgetcsv($fp);
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

$products = get_posts(['post_type'=>'product','post_status'=>'publish','posts_per_page'=>-1]);
$updated = 0; $skipped = 0;

foreach ($products as $p) {
    $thumb_id = get_post_thumbnail_id($p->ID);
    $current_file = $thumb_id ? basename(get_attached_file($thumb_id)) : '';

    // PROTECT: Phase 1 Ali Images (Pattern: subcat_0.webp)
    // We only skip Ali images if they are specifically from Phase 1 (not mod_ or v4_)
    if (preg_match('/_[0-9]+\.webp$/', $current_file) && strpos($current_file, 'mod_') === false && strpos($current_file, 'v4_') === false) {
        $skipped++;
        continue;
    }

    // TARGET: 
    // 1. Placeholders (ea-sub-)
    // 2. Old mirrored versions (mod_v2, mod_v3)
    // 3. Raw watermarked versions (no mod/v4 prefix but clearly mprint/signage)
    
    $is_mirrored = (strpos($current_file, 'mod_v2') !== false || strpos($current_file, 'mod_v3') !== false);
    $is_placeholder = (empty($current_file) || strpos($current_file, 'ea-sub-') === 0);
    $is_mprint_raw = (strpos($current_file, 'v4_') === false && 
                      (stripos($current_file, 'M-PRINT') !== false || 
                       stripos($current_file, 'Signage') !== false || 
                       stripos($current_file, 'Backdrop') !== false ||
                       stripos($current_file, 'Standee') !== false));

    if ($is_placeholder || $is_mirrored || $is_mprint_raw) {
        $p_name_clean = preg_replace('/[^a-z0-9]/', '', strtolower($p->post_title));
        $found = null;

        foreach ($image_pool as $img) {
            if (strpos($img['clean'], $p_name_clean) !== false || strpos($p_name_clean, $img['clean']) !== false) {
                $found = $img; break;
            }
        }

        if ($found) {
            $res = wp_insert_attachment_from_path_v4($found['path'], $p->ID, $p->post_title);
            if ($res) {
                set_post_thumbnail($p->ID, $res);
                $updated++;
                echo "✅ [Corrected/Updated] {$p->post_title} -> " . $found['filename'] . "\n";
            }
        }
    }
}

function wp_insert_attachment_from_path_v4($path, $parent_id, $title) {
    if (!file_exists($path)) return false;
    $wp_upload_dir = wp_upload_dir();
    $name = basename($path);
    
    // Check if already in usage
    $existing = get_posts(['post_type'=>'attachment', 'meta_query'=>[['key'=>'_v4_pool_path','value'=>$path]], 'posts_per_page'=>1]);
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
        update_post_meta($attach_id, '_v4_pool_path', $path);
        wp_update_attachment_metadata($attach_id, wp_generate_attachment_metadata($attach_id, $new_path));
        return $attach_id;
    }
    return false;
}

wc_delete_product_transients();
echo "<h2>🎉 Product Orientation Corrected!</h2>";
echo "Products updated/fixed: $updated\n";
echo "Protected Ali images: $skipped\n";
?>
