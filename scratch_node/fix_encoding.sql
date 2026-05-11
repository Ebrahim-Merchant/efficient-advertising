BEGIN;

-- Fix wp_posts
UPDATE wp_posts SET post_title = REPLACE(post_title, UNHEX('CE93C387C3B4'), '-');
UPDATE wp_posts SET post_title = REPLACE(post_title, UNHEX('CE93C387C3B6'), '-');
UPDATE wp_posts SET post_title = REPLACE(post_title, UNHEX('CE93C387C396'), '''');

UPDATE wp_posts SET post_content = REPLACE(post_content, UNHEX('CE93C387C3B4'), '-');
UPDATE wp_posts SET post_content = REPLACE(post_content, UNHEX('CE93C387C3B6'), '-');
UPDATE wp_posts SET post_content = REPLACE(post_content, UNHEX('CE93C387C396'), '''');

UPDATE wp_posts SET post_excerpt = REPLACE(post_excerpt, UNHEX('CE93C387C3B4'), '-');
UPDATE wp_posts SET post_excerpt = REPLACE(post_excerpt, UNHEX('CE93C387C3B6'), '-');
UPDATE wp_posts SET post_excerpt = REPLACE(post_excerpt, UNHEX('CE93C387C396'), '''');

-- Fix wp_postmeta
UPDATE wp_postmeta SET meta_value = REPLACE(meta_value, UNHEX('CE93C387C3B4'), '-');
UPDATE wp_postmeta SET meta_value = REPLACE(meta_value, UNHEX('CE93C387C3B6'), '-');
UPDATE wp_postmeta SET meta_value = REPLACE(meta_value, UNHEX('CE93C387C396'), '''');

COMMIT;
