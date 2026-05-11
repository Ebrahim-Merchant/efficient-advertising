<?php
/**
 * deactivate-placeholders.php
 * Sets products with placeholder images to 'private' status.
 */
require_once __DIR__ . '/wp-load.php';

@set_time_limit(1800);
echo "<h1>🚫 Deactivating Placeholder Products</h1>";
echo "<pre>";

$products = get_posts([
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => -1
]);

$deactivated = 0;

foreach ($products as $p) {
    $thumb_id = get_post_thumbnail_id($p->ID);
    $current_file = $thumb_id ? basename(get_attached_file($thumb_id)) : '';

    // Check if it's a placeholder or missing
    $is_placeholder = (empty($current_file) || strpos($current_file, 'ea-sub-') === 0 || strpos($current_file, 'placeholder') !== false);

    if ($is_placeholder) {
        // Set post status to private (prevents it from showing on the frontend but keeps it in the backend)
        wp_update_post([
            'ID' => $p->ID,
            'post_status' => 'private'
        ]);
        $deactivated++;
        echo "🔒 [Deactivated] {$p->post_title} (ID: {$p->ID})\n";
    }
}

echo "<h2>✅ Operation Complete</h2>";
echo "Total products moved to Private: $deactivated\n";
echo "</pre>";
?>
