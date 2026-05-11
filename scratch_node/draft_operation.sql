-- Create temporary table with variant IDs
CREATE TEMPORARY TABLE draft_variants AS 
SELECT p.ID, p.post_parent
FROM wp_posts p
JOIN wp_postmeta pm ON p.ID = pm.post_id
WHERE pm.meta_key = '_sku' AND pm.meta_value IN (
    'PS-048', 'PS-049', 'PS-050', 'PS-051', 'PS-052', 'PS-053', 'PS-054', 'PS-055',
    'PS-065', 'PS-066', 'PS-067', 'PS-068', 'PS-069',
    'PS-079', 'PS-080', 'PS-081', 'PS-082', 'PS-083', 'PS-084', 'PS-085', 'PS-086',
    'PS-087', 'PS-088', 'PS-089', 'PS-090',
    'PS-091', 'PS-092', 'PS-093', 'PS-094',
    'PS-258', 'PS-259', 'PS-260',
    'PS-271', 'PS-272',
    'PS-273', 'PS-274'
);

-- Draft the variants
UPDATE wp_posts 
SET post_status = 'draft' 
WHERE ID IN (SELECT ID FROM draft_variants);

-- Draft the parent products
UPDATE wp_posts 
SET post_status = 'draft' 
WHERE ID IN (SELECT post_parent FROM draft_variants WHERE post_parent != 0);

SELECT 'Drafted variants:', COUNT(*) FROM draft_variants;
