<?php
// EA-MERGE-006: Database state verification
global $wpdb;

$variable_count = $wpdb->get_var(
    "SELECT COUNT(DISTINCT p.ID)
     FROM wp_posts p
     JOIN wp_term_relationships tr ON p.ID = tr.object_id
     JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
     JOIN wp_terms t ON tt.term_id = t.term_id
     WHERE t.slug = 'variable' AND tt.taxonomy = 'product_type' AND p.post_status = 'publish'"
);

$variation_count = $wpdb->get_var(
    "SELECT COUNT(*) FROM wp_posts WHERE post_type = 'product_variation' AND post_status = 'publish'"
);

$draft_count = $wpdb->get_var(
    "SELECT COUNT(*) FROM wp_posts WHERE post_type = 'product' AND post_status = 'draft'"
);

$simple_count = $wpdb->get_var(
    "SELECT COUNT(DISTINCT p.ID)
     FROM wp_posts p
     JOIN wp_term_relationships tr ON p.ID = tr.object_id
     JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
     JOIN wp_terms t ON tt.term_id = t.term_id
     WHERE t.slug = 'simple' AND tt.taxonomy = 'product_type' AND p.post_status = 'publish'"
);

echo "=== DATABASE STATE AFTER EA-MERGE-006 ===\n";
echo "Published variable products: $variable_count\n";
echo "Published product variations: $variation_count\n";
echo "Published simple products:   $simple_count\n";
echo "Draft products:              $draft_count\n";

// Sample: show first 5 variable products and their variation counts
$sample = $wpdb->get_results(
    "SELECT p.ID, p.post_title
     FROM wp_posts p
     JOIN wp_term_relationships tr ON p.ID = tr.object_id
     JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
     JOIN wp_terms t ON tt.term_id = t.term_id
     WHERE t.slug = 'variable' AND tt.taxonomy = 'product_type' AND p.post_status = 'publish'
     LIMIT 8"
);
echo "\nSample variable products:\n";
foreach ( $sample as $row ) {
    $vcount = $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM wp_posts WHERE post_parent = %d AND post_type = 'product_variation'",
        $row->ID
    ) );
    echo "  ID {$row->ID}  ({$row->post_title})  variations=$vcount\n";
}
