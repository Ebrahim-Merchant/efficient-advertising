<?php

declare(strict_types=1);

require_once dirname(__DIR__, 3) . '/wp-load.php';

if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
    echo "wp_cache_flush=1\n";
} else {
    echo "wp_cache_flush=0\n";
}

global $wpdb;
$deleted = $wpdb->query(
    "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%' OR option_name LIKE '_site_transient_%'"
);
echo 'transients_deleted=' . (int)$deleted . "\n";

if (function_exists('rocket_clean_domain')) {
    rocket_clean_domain();
    echo "rocket_clean_domain=1\n";
}
if (function_exists('w3tc_flush_all')) {
    w3tc_flush_all();
    echo "w3tc_flush_all=1\n";
}
if (function_exists('wpfc_clear_all_cache')) {
    wpfc_clear_all_cache(true);
    echo "wpfc_clear_all_cache=1\n";
}
