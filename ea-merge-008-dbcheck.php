<?php
if (!defined('ABSPATH')) exit;
global $wpdb;
$v    = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='product_variation' AND post_status='publish'");
$var  = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} p JOIN {$wpdb->term_relationships} tr ON p.ID=tr.object_id JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id=tt.term_taxonomy_id JOIN {$wpdb->terms} t ON tt.term_id=t.term_id WHERE p.post_type='product' AND t.slug='variable' AND p.post_status='publish'");
$draft  = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='product' AND post_status='draft'");
$simple = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} p JOIN {$wpdb->term_relationships} tr ON p.ID=tr.object_id JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id=tt.term_taxonomy_id JOIN {$wpdb->terms} t ON tt.term_id=t.term_id WHERE p.post_type='product' AND t.slug='simple' AND p.post_status='publish'");
WP_CLI::log("Variable products (published): $var");
WP_CLI::log("Variations (published):        $v");
WP_CLI::log("Simple products (published):   $simple");
WP_CLI::log("Draft products:                $draft");
