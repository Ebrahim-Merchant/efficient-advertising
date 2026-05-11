BEGIN;
UPDATE wp_posts SET post_title = '250 GSM+Matte' WHERE ID = 1148;
UPDATE wp_postmeta SET meta_value = '250 GSM+Matte' WHERE post_id = 1148 AND meta_key = '_product_name_custom';
UPDATE wp_posts SET post_title = '250 GSM+AQ' WHERE ID = 1155;
UPDATE wp_postmeta SET meta_value = '250 GSM+AQ' WHERE post_id = 1155 AND meta_key = '_product_name_custom';
UPDATE wp_posts SET post_title = '250 GSM+Matte' WHERE ID = 1169;
UPDATE wp_postmeta SET meta_value = '250 GSM+Matte' WHERE post_id = 1169 AND meta_key = '_product_name_custom';
COMMIT;