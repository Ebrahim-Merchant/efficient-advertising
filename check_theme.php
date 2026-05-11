<?php
/**
 * Theme Verification Script
 */
require_once('wp-load.php');
$theme = get_stylesheet();
echo "<h1>🔍 ACTIVE THEME: $theme</h1>";
if ($theme === 'Efficient-dev') {
    echo "<p style='color:green;'>✅ You are correctly using the high-performance dev theme!</p>";
} else {
    echo "<p style='color:red;'>⚠️ You are still on $theme. Please run <a href='/activate_theme.php'>activate_theme.php</a> to switch.</p>";
}
