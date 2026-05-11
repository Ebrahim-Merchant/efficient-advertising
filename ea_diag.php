<?php
require_once('wp-load.php');
echo "Active Theme: " . wp_get_theme()->get('Name') . "\n";
echo "Template Dir: " . get_template_directory() . "\n";
echo "Stylesheet Dir: " . get_stylesheet_directory() . "\n";
echo "WP_CACHE: " . (defined('WP_CACHE') && WP_CACHE ? 'Enabled' : 'Disabled') . "\n";
