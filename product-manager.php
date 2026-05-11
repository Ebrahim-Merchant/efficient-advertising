<?php
/**
 * ⚡ Optimized Product Status Decision Tool
 * Location: Root of WordPress
 * Usage: Review live products in batches and decide whether to KEEP or DRAFT them.
 */

// 1. Load WordPress
require_once( 'wp-load.php' );

// 2. Simple Security
if ( ! current_user_can( 'manage_options' ) ) {
    wp_die( '<h1>Unauthorized</h1><p>You must be an administrator to use this tool.</p>' );
}

$message = '';

// 3. Handle Execution
if ( isset( $_POST['ea_execute_audit'] ) && check_admin_referer( 'ea_audit_nonce' ) ) {
    $decisions = isset( $_POST['decision'] ) ? (array)$_POST['decision'] : [];
    $drafted = 0;
    $kept = 0;

    foreach ( $decisions as $pid => $action ) {
        $pid = intval( $pid );
        if ( $action === 'draft' ) {
            wp_update_post( array( 'ID' => $pid, 'post_status' => 'draft' ) );
            $drafted++;
        } else {
            $kept++;
        }
    }
    $message = "<div style='background:#dcfce7; color:#166534; padding:20px; margin-bottom:20px; border-radius:8px; border:1px solid #bbf7d0;'>
        ✅ <b>Audit Complete for this Page:</b> $drafted products moved to Draft, $kept products kept Live.
    </div>";
}

// 4. Filters & Pagination
$paged       = isset( $_GET['paged'] ) ? max( 1, intval( $_GET['paged'] ) ) : 1;
$per_page    = 50; // Smaller batches for better loading speed
$filter_cat  = isset( $_GET['filter_cat'] ) ? sanitize_text_field( $_GET['filter_cat'] ) : '';

$query_args = array(
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => $per_page,
    'paged'          => $paged,
    'orderby'        => 'title',
    'order'          => 'ASC',
);

if ( ! empty( $filter_cat ) ) {
    $query_args['tax_query'] = array(
        array(
            'taxonomy' => 'product_category',
            'field'    => 'slug',
            'terms'    => $filter_cat,
        ),
    );
}

$query    = new WP_Query( $query_args );
$products = $query->posts;
$total_pages = $query->max_num_pages;

// Get all categories for filter dropdown
$all_cats = get_terms( array( 'taxonomy' => 'product_category', 'hide_empty' => true ) );

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>⚡ Product Status Manager (Speed Optimized) — Efficient Advertising</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background: #f0f2f5; padding: 20px; color: #1e293b; line-height: 1.5; }
        .container { max-width: 1200px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        h1 { margin-top: 0; color: #0f172a; border-bottom: 2px solid #FFBA09; padding-bottom: 10px; font-size: 24px; }
        
        .filters { background: #f8fafc; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; display: flex; gap: 20px; align-items: center; border: 1px solid #e2e8f0; flex-wrap: wrap; }
        .filters label { font-size: 14px; font-weight: bold; }
        .filters select { padding: 8px; border-radius: 6px; border: 1px solid #cbd5e1; }
        .filters .btn-reset { font-size: 12px; color: #64748b; text-decoration: none; }
        .filters .btn-reset:hover { color: #0f172a; }

        .pagination { display: flex; gap: 5px; margin: 15px 0; justify-content: center; flex-wrap: wrap; }
        .pagination a { padding: 6px 12px; background: #fff; border: 1px solid #e2e8f0; border-radius: 6px; text-decoration: none; color: #1e293b; font-size: 13px; font-weight: bold; }
        .pagination a.current { background: #FFBA09; border-color: #FFBA09; color: #0f172a; }
        .pagination a:hover:not(.current) { background: #f1f5f9; }

        .product-item { display: flex; align-items: center; padding: 15px; border-bottom: 1px solid #f1f5f9; gap: 25px; transition: background 0.2s; }
        .product-item:hover { background: #fdfdfd; }
        
        .product-img { width: 120px; height: 120px; background: #f1f5f9; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid #e2e8f0; }
        .product-img img { width: 100%; height: 100%; object-fit: cover; }
        
        .product-info { flex: 1; min-width: 0; }
        .product-cat { font-size: 11px; color: #FFBA09; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
        .product-title { font-size: 16px; font-weight: 700; margin: 4px 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        
        .decision-box { display: flex; gap: 8px; flex-shrink: 0; }
        .decision-box label { padding: 8px 16px; border-radius: 6px; border: 2px solid #e2e8f0; font-weight: 700; cursor: pointer; transition: all 0.2s; font-size: 11px; text-transform: uppercase; }
        .decision-box input { display: none; }
        .decision-box input:checked + span { color: #fff; }
        
        .opt-keep:checked + .lbl-keep { background: #16a34a; border-color: #16a34a; color: white; }
        .lbl-keep { color: #64748b; }
        .opt-draft:checked + .lbl-draft { background: #dc2626; border-color: #dc2626; color: white; }
        .lbl-draft { color: #64748b; }

        .bulk-actions { margin-left: auto; }
        .btn-draft-all { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; padding: 8px 14px; border-radius: 6px; cursor: pointer; font-weight: 700; font-size: 12px; }

        .footer-bar { position: sticky; bottom: 0; background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(8px); color: white; padding: 20px; text-align: center; margin-top: 30px; border-radius: 12px; box-shadow: 0 -10px 25px rgba(0,0,0,0.1); border-top: 2px solid #FFBA09; z-index: 1000; }
        .submit-btn { background: #FFBA09; color: #0f172a; border: none; padding: 12px 60px; font-weight: 800; font-size: 16px; border-radius: 50px; cursor: pointer; transition: transform 0.2s, background 0.2s; }
        .submit-btn:hover { transform: translateY(-2px); background: #f59e0b; }
        
        .empty-state { text-align: center; padding: 50px 0; color: #64748b; }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚡ Product Manager (Speed Optimized)</h1>
        <p style="font-size:14px; color:#64748b;">Showing batch of <b><?php echo count($products); ?></b> of <b><?php echo $query->found_posts; ?></b> published products.</p>
        
        <?php echo $message; ?>

        <!-- Filters Section -->
        <div class="filters">
            <form action="" method="GET" style="display:flex; gap:12px; align-items:center;">
                <label>Category:</label>
                <select name="filter_cat" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <?php foreach ($all_cats as $cat) : ?>
                        <option value="<?php echo esc_attr($cat->slug); ?>" <?php selected($filter_cat, $cat->slug); ?>><?php echo esc_html($cat->name); ?></option>
                    <?php endforeach; ?>
                </select>
                <a href="product-manager.php" class="btn-reset">Reset</a>
            </form>

            <div class="bulk-actions">
                <button type="button" class="btn-draft-all" onclick="if(confirm('Set all products on this page to Draft status?')) { document.querySelectorAll('.opt-draft').forEach(i => i.checked = true); }">Draft All on Page</button>
            </div>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1) : ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <a href="?paged=<?php echo $i; ?>&filter_cat=<?php echo $filter_cat; ?>" class="<?php echo ($i == $paged) ? 'current' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>

        <form method="POST">
            <?php wp_nonce_field( 'ea_audit_nonce' ); ?>
            
            <div class="product-list">
                <?php if ( empty($products) ) : ?>
                    <div class="empty-state">
                        <p>No published products found matching your filter.</p>
                    </div>
                <?php else : ?>
                    <?php foreach ( $products as $p ) : 
                        $thumb_id = get_post_thumbnail_id( $p->ID );
                        $img_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'medium' ) : ''; // Medium is faster than large
                        $terms = wp_get_post_terms( $p->ID, 'product_category' );
                        $cat_str = !empty($terms) ? $terms[0]->name : 'Uncategorized';
                        if (!empty($terms) && $terms[0]->parent != 0) {
                            $parent = get_term($terms[0]->parent, 'product_category');
                            $cat_str = $parent->name . ' &rsaquo; ' . $cat_str;
                        }
                    ?>
                    <div class="product-item">
                        <div class="product-img">
                            <?php if ($img_url): ?>
                                <img src="<?php echo esc_url($img_url); ?>" alt="Preview" loading="lazy">
                            <?php else: ?>
                                <span style="font-size:10px; color:#cbd5e1; font-weight:bold;">NO IMAGE</span>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <div class="product-cat"><?php echo esc_html($cat_str); ?></div>
                            <div class="product-title" title="<?php echo esc_attr($p->post_title); ?>"><?php echo esc_html($p->post_title); ?></div>
                            <div style="font-size:10px; color:#94a3b8;">PID: #<?php echo $p->ID; ?></div>
                        </div>
                        <div class="decision-box">
                            <label class="lbl-keep">
                                <input type="radio" name="decision[<?php echo $p->ID; ?>]" value="keep" class="opt-keep" checked>
                                <span>Keep</span>
                            </label>
                            <label class="lbl-draft">
                                <input type="radio" name="decision[<?php echo $p->ID; ?>]" value="draft" class="opt-draft">
                                <span>Draft</span>
                            </label>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="footer-bar">
                <button type="submit" name="ea_execute_audit" class="submit-btn" onclick="return confirm('Execute decisions for current page?')">Execute Decisions for This Page</button>
            </div>
        </form>

        <!-- Pagination Bottom -->
        <?php if ($total_pages > 1) : ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <a href="?paged=<?php echo $i; ?>&filter_cat=<?php echo $filter_cat; ?>" class="<?php echo ($i == $paged) ? 'current' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>

    </div>
</body>
</html>
