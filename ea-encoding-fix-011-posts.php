<?php
if (!defined('ABSPATH')) exit;
global $wpdb;

// Double-encoded Windows-1252 sequences → correct UTF-8
// Keys are raw byte sequences; values are proper UTF-8
$from = [
    "\xce\x93\xc3\x87\xc3\xb4", // ΓÇô → en dash
    "\xce\x93\xc3\x87\xc3\xb3", // ΓÇó → bullet
    "\xce\x93\xc3\x87\xc3\x96", // ΓÇÖ → right single quote
    "\xce\x93\xc3\x87\xc2\xa3", // ΓÇ£ → left double quote
    "\xce\x93\xc3\x87\xc2\xa5", // ΓÇ¥ → right double quote
];
$to = [
    "\xe2\x80\x93", // –
    "\xe2\x80\xa2", // •
    "\xe2\x80\x99", // '
    "\xe2\x80\x9c", // "
    "\xe2\x80\x9d", // "
];

// Pull affected posts directly via SQL (all statuses, both types)
// Any post whose title/content/excerpt contains the CE93 byte sequence
$ids = $wpdb->get_col(
    "SELECT ID FROM {$wpdb->posts}
     WHERE post_type IN ('product','product_variation')
       AND (
         post_title   LIKE '%\xce\x93\xc3\x87%'
         OR post_content LIKE '%\xce\x93\xc3\x87%'
         OR post_excerpt LIKE '%\xce\x93\xc3\x87%'
       )"
);

echo "Affected posts found: " . count($ids) . "\n";

$updated = 0;
foreach ($ids as $id) {
    $p = get_post((int)$id);
    if (!$p) continue;

    $new_title   = str_replace($from, $to, $p->post_title);
    $new_content = str_replace($from, $to, $p->post_content);
    $new_excerpt = str_replace($from, $to, $p->post_excerpt);

    $wpdb->update(
        $wpdb->posts,
        [
            'post_title'   => $new_title,
            'post_content' => $new_content,
            'post_excerpt' => $new_excerpt,
        ],
        ['ID' => (int)$id]
    );
    echo "  Updated ID:$id  [{$p->post_title}] -> [$new_title]\n";
    $updated++;
    clean_post_cache((int)$id);
}

echo "Done. Posts updated: $updated\n";
