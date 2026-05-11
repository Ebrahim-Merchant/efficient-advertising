<?php
/**
 * Efficient Advertising - Execution helper
 * Run with: php ea-exec.php <action>
 */
define('ABSPATH', __DIR__ . '/');
define('SHORTINIT', false);
require_once ABSPATH . 'wp-load.php';

$action = $argv[1] ?? 'list-cats';

switch ($action) {
    case 'list-cats':
        $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
        echo "Total categories: " . count($cats) . "\n";
        echo str_pad("ID", 6) . str_pad("SLUG", 40) . str_pad("NAME", 45) . str_pad("PARENT", 8) . "COUNT\n";
        echo str_repeat("-", 110) . "\n";
        foreach ($cats as $c) {
            echo str_pad($c->term_id, 6) . str_pad($c->slug, 40) . str_pad($c->name, 45) . str_pad($c->parent, 8) . $c->count . "\n";
        }
        break;

    case 'product-count':
        $published = wp_count_posts('product');
        echo "Published: " . $published->publish . "\n";
        echo "Draft: " . $published->draft . "\n";
        echo "Private: " . $published->private . "\n";
        echo "Trash: " . ($published->trash ?? 0) . "\n";
        $total = $published->publish + $published->draft + $published->private;
        echo "Total (pub+draft+priv): $total\n";
        break;

    case 'sample-products':
        // Get 20 random products with their categories and images
        $products = get_posts([
            'post_type' => 'product',
            'posts_per_page' => 20,
            'orderby' => 'rand',
            'post_status' => 'any',
        ]);
        foreach ($products as $p) {
            $cats = wp_get_post_terms($p->ID, 'product_cat', ['fields' => 'names']);
            $thumb_id = get_post_thumbnail_id($p->ID);
            $thumb_url = $thumb_id ? wp_get_attachment_url($thumb_id) : 'NO IMAGE';
            $sku = get_post_meta($p->ID, '_sku', true);
            echo "ID:{$p->ID} | SKU:{$sku} | {$p->post_title} | Status:{$p->post_status} | Cats:" . implode(',', $cats) . " | Img:{$thumb_url}\n";
        }
        break;

    default:
        echo "Unknown action: $action\n";
}
