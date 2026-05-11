<?php
/**
 * Safe Theme Re-Activation Script for 'Efficient-dev'
 */
require_once('wp-load.php');
if ( ! current_user_can('manage_options') && ! empty( $_SERVER['REMOTE_ADDR'] ) && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1' ) {
    die("Security Error: Access Denied. Please log in as admin.");
}

switch_theme('Efficient-dev');
echo "<h1>✅ SUCCESS: Site is now using 'Efficient-dev'!</h1>";
echo "<p><a href='/'>Go to Homepage</a></p>";
