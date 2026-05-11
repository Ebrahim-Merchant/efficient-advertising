<?php
/**
 * Check nav menu items for broken links
 */
define('ABSPATH', __DIR__ . '/');
require_once ABSPATH . 'wp-load.php';

$menu_id = 1256; // from diagnostic
$items = wp_get_nav_menu_items($menu_id);

if (!$items) {
    echo "No menu items found for menu ID $menu_id\n";
    exit;
}

echo "=== HEADER MENU (ID:$menu_id) — " . count($items) . " items ===\n\n";

$broken = 0;
foreach ($items as $item) {
    $parent = $item->menu_item_parent ? " (parent:{$item->menu_item_parent})" : '';
    $type = $item->type; // taxonomy, post_type, custom
    $url = $item->url;
    
    // Check if URL is accessible
    $is_broken = false;
    if ($type === 'taxonomy') {
        $term = get_term($item->object_id, $item->object);
        if (!$term || is_wp_error($term)) {
            $is_broken = true;
        }
    } elseif ($type === 'post_type') {
        $post = get_post($item->object_id);
        if (!$post || $post->post_status !== 'publish') {
            $is_broken = true;
        }
    }
    
    $status = $is_broken ? '❌ BROKEN' : '✓';
    echo "  [{$item->ID}] {$item->title} | type:{$type} | obj:{$item->object} | obj_id:{$item->object_id}{$parent} | {$status}\n";
    if ($is_broken) $broken++;
}

echo "\n=== SUMMARY: $broken broken out of " . count($items) . " items ===\n";
