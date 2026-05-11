<?php
require_once 'C:/Users/merch/Local Sites/newefficientadvertising09042026/app/public/wp-load.php';

// Check if page already exists
$existing = get_page_by_path('catalogue');
if ($existing) {
  echo "Page already exists: ID={$existing->ID}\n";
  // Make sure it uses the template
  update_post_meta($existing->ID, '_wp_page_template', 'page-catalogue.php');
  echo "Template set to page-catalogue.php\n";
} else {
  $page_id = wp_insert_post([
    'post_title'   => 'Product Catalogue',
    'post_name'    => 'catalogue',
    'post_content' => '',
    'post_status'  => 'publish',
    'post_type'    => 'page',
    'post_author'  => 1,
    'page_template'=> 'page-catalogue.php',
  ]);
  if (is_wp_error($page_id)) {
    echo "Error: " . $page_id->get_error_message() . "\n";
  } else {
    echo "Created page ID={$page_id} slug=catalogue\n";
    update_post_meta($page_id, '_wp_page_template', 'page-catalogue.php');
    echo "Template set to page-catalogue.php\n";
  }
}
