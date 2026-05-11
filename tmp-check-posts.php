<?php
$ids = [4444,4442];
foreach ($ids as $id) {
  $thumb_id = get_post_thumbnail_id($id);
  $url = get_the_post_thumbnail_url($id, 'medium_large');
  $title = get_the_title($id);
  $excerpt = get_the_excerpt($id);
  echo "POST {$id}\n";
  echo "title: {$title}\n";
  echo "thumb_id: " . ($thumb_id ?: '0') . "\n";
  echo "thumb_url: " . ($url ?: 'EMPTY') . "\n";
  echo "excerpt: {$excerpt}\n\n";
}
