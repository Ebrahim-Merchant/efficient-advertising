<?php
/**
 * Check and fix WooCommerce category display_type for all product_cat terms.
 * Usage: php ea-fix-display-type.php check|fix
 */
$_SERVER['HTTP_HOST']   = 'newefficientadvertising09042026.local';
$_SERVER['REQUEST_URI'] = '/';
require __DIR__ . '/wp-load.php';

$action = $argv[1] ?? 'check';

$terms = get_terms([
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
]);

if ( is_wp_error($terms) ) {
    echo "ERROR: " . $terms->get_error_message() . "\n";
    exit(1);
}

// Also check the global WC settings
$shop_display = get_option('woocommerce_shop_page_display', '(not set)');
$cat_display  = get_option('woocommerce_category_archive_display', '(not set)');
echo "=== WooCommerce Global Display Settings ===\n";
echo "Shop page display: '{$shop_display}'\n";
echo "Category archive display: '{$cat_display}'\n\n";

$problems = [];
echo "=== Category display_type meta ===\n";
foreach ($terms as $t) {
    $display = get_term_meta($t->term_id, 'display_type', true);
    if ( ! empty($display) && $display !== '' && $display !== 'products' ) {
        echo "  ** {$t->name} (ID {$t->term_id}): display_type='{$display}' <- PROBLEM\n";
        $problems[] = $t;
    } elseif ( ! empty($display) ) {
        echo "  {$t->name} (ID {$t->term_id}): display_type='{$display}'\n";
    } else {
        echo "  {$t->name} (ID {$t->term_id}): display_type=(empty/inherits global)\n";
    }
}

echo "\nProblems found: " . count($problems) . "\n";

if ($action === 'fix' && ! empty($problems)) {
    echo "\n=== Fixing display_type ===\n";
    foreach ($problems as $t) {
        update_term_meta($t->term_id, 'display_type', '');
        echo "  Fixed: {$t->name} (ID {$t->term_id}) -> display_type=''\n";
    }
    echo "Done.\n";
} elseif ($action === 'fix' && empty($problems)) {
    echo "Nothing to fix.\n";
}

// Also check: is there a WordPress PAGE with slug 'signage'?
echo "\n=== Pages with signage-related slugs ===\n";
$pages = get_posts([
    'post_type'   => 'page',
    'post_status' => 'any',
    'numberposts' => -1,
]);
foreach ($pages as $p) {
    if (stripos($p->post_name, 'signage') !== false) {
        echo "  Page: '{$p->post_title}' (ID {$p->ID}, slug='{$p->post_name}', status={$p->post_status})\n";
    }
}

echo "\n=== Done ===\n";
