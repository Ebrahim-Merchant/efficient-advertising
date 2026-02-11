<?php
/**
 * Debug Template - Place this in your theme root temporarily
 * Access it at: yoursite.com/wp-content/themes/efficient-modern/debug-products.php
 */

// Load WordPress
require_once('../../../wp-load.php');

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product Debug Info</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .box { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h2 { color: #8B1538; border-bottom: 2px solid #8B1538; padding-bottom: 10px; }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .warning { color: #ffc107; }
        code { background: #f0f0f0; padding: 2px 6px; border-radius: 3px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        table td, table th { padding: 8px; border: 1px solid #ddd; text-align: left; }
        table th { background: #8B1538; color: white; }
    </style>
</head>
<body>
    <h1>🔍 Product Debug Information</h1>
    
    <div class="box">
        <h2>1. WooCommerce Status</h2>
        <?php if ( class_exists( 'WooCommerce' ) ) : ?>
            <p class="success">✅ <strong>WooCommerce IS ACTIVE</strong></p>
            <p>Shop Page: <code><?php echo wc_get_page_permalink( 'shop' ); ?></code></p>
            <p>WooCommerce uses post type: <code>product</code> and taxonomy: <code>product_cat</code></p>
        <?php else : ?>
            <p class="warning">⚠️  <strong>WooCommerce IS NOT ACTIVE</strong></p>
            <p>Custom product post type should be registered.</p>
        <?php endif; ?>
    </div>
    
    <div class="box">
        <h2>2. Registered Post Types</h2>
        <?php
        $post_types = get_post_types( array( 'public' => true ), 'objects' );
        if ( isset( $post_types['product'] ) ) {
            echo '<p class="success">✅ <strong>Product post type IS REGISTERED</strong></p>';
            echo '<table>';
            echo '<tr><th>Property</th><th>Value</th></tr>';
            echo '<tr><td>Label</td><td>' . $post_types['product']->label . '</td></tr>';
            echo '<tr><td>Has Archive</td><td>' . ( $post_types['product']->has_archive ? 'Yes' : 'No' ) . '</td></tr>';
            echo '<tr><td>Publicly Queryable</td><td>' . ( $post_types['product']->publicly_queryable ? 'Yes' : 'No' ) . '</td></tr>';
            echo '<tr><td>Rewrite Slug</td><td>' . ( isset( $post_types['product']->rewrite['slug'] ) ? $post_types['product']->rewrite['slug'] : 'N/A' ) . '</td></tr>';
            echo '<tr><td>Archive Link</td><td><code>' . get_post_type_archive_link( 'product' ) . '</code></td></tr>';
            echo '</table>';
        } else {
            echo '<p class="error">❌ <strong>Product post type NOT REGISTERED</strong></p>';
        }
        ?>
    </div>
    
    <div class="box">
        <h2>3. Product Taxonomies</h2>
        <?php
        $taxonomies = get_taxonomies( array(), 'objects' );
        $found_tax = false;
        
        echo '<table>';
        echo '<tr><th>Taxonomy</th><th>Label</th><th>Post Types</th><th>Public</th></tr>';
        
        foreach ( $taxonomies as $tax_name => $tax_obj ) {
            if ( strpos( $tax_name, 'product' ) !== false || in_array( 'product', $tax_obj->object_type ) ) {
                $found_tax = true;
                echo '<tr>';
                echo '<td><code>' . $tax_name . '</code></td>';
                echo '<td>' . $tax_obj->label . '</td>';
                echo '<td>' . implode( ', ', $tax_obj->object_type ) . '</td>';
                echo '<td>' . ( $tax_obj->public ? 'Yes' : 'No' ) . '</td>';
                echo '</tr>';
            }
        }
        
        echo '</table>';
        
        if ( ! $found_tax ) {
            echo '<p class="warning">⚠️  No product-related taxonomies found</p>';
        }
        ?>
    </div>
    
    <div class="box">
        <h2>4. Product Count</h2>
        <?php
        $product_count = wp_count_posts( 'product' );
        if ( $product_count ) {
            echo '<p>Published Products: <strong>' . $product_count->publish . '</strong></p>';
            echo '<p>Draft Products: <strong>' . $product_count->draft . '</strong></p>';
            echo '<p>Total: <strong>' . ( $product_count->publish + $product_count->draft ) . '</strong></p>';
        } else {
            echo '<p class="error">❌ Could not count products</p>';
        }
        ?>
    </div>
    
    <div class="box">
        <h2>5. Sample Products</h2>
        <?php
        $products = get_posts( array(
            'post_type' => 'product',
            'posts_per_page' => 5,
            'post_status' => 'publish',
        ) );
        
        if ( $products ) {
            echo '<p class="success">✅ Found ' . count( $products ) . ' products</p>';
            echo '<table>';
            echo '<tr><th>ID</th><th>Title</th><th>URL</th><th>Status</th></tr>';
            foreach ( $products as $product ) {
                echo '<tr>';
                echo '<td>' . $product->ID . '</td>';
                echo '<td>' . $product->post_title . '</td>';
                echo '<td><a href="' . get_permalink( $product->ID ) . '" target="_blank">View</a></td>';
                echo '<td>' . $product->post_status . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p class="error">❌ No published products found</p>';
        }
        ?>
    </div>
    
    <div class="box">
        <h2>6. Theme Template Files</h2>
        <?php
        $templates = array(
            'archive-product.php' => get_template_directory() . '/archive-product.php',
            'single-product.php' => get_template_directory() . '/single-product.php',
            'taxonomy-product_category.php' => get_template_directory() . '/taxonomy-product_category.php',
        );
        
        echo '<table>';
        echo '<tr><th>Template</th><th>Status</th></tr>';
        foreach ( $templates as $name => $path ) {
            echo '<tr>';
            echo '<td><code>' . $name . '</code></td>';
            echo '<td>' . ( file_exists( $path ) ? '<span class="success">✅ Exists</span>' : '<span class="error">❌ Missing</span>' ) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        ?>
    </div>
    
    <div class="box">
        <h2>7. Permalink Structure</h2>
        <p>Current Structure: <code><?php echo get_option( 'permalink_structure' ); ?></code></p>
        <p><strong>⚠️  If products aren't loading, go to Settings → Permalinks and click "Save Changes"</strong></p>
    </div>
    
    <div class="box">
        <h2>8. Test URLs</h2>
        <p>Try these URLs:</p>
        <ul>
            <li>All Products: <a href="<?php echo home_url( '/product/' ); ?>" target="_blank"><?php echo home_url( '/product/' ); ?></a></li>
            <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <li>Shop Page: <a href="<?php echo wc_get_page_permalink( 'shop' ); ?>" target="_blank"><?php echo wc_get_page_permalink( 'shop' ); ?></a></li>
            <?php endif; ?>
            <?php if ( ! empty( $products ) ) : ?>
                <li>Sample Product: <a href="<?php echo get_permalink( $products[0]->ID ); ?>" target="_blank"><?php echo get_permalink( $products[0]->ID ); ?></a></li>
            <?php endif; ?>
        </ul>
    </div>
    
    <div class="box">
        <h2>9. Recommended Actions</h2>
        <ol>
            <li><strong>Flush Permalinks:</strong> Go to WordPress Admin → Settings → Permalinks → Click "Save Changes"</li>
            <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <li><strong>WooCommerce is Active:</strong> Use the Shop page URL instead of /product/</li>
                <li><strong>Configure Shop Page:</strong> WooCommerce → Settings → Products → Shop Page</li>
            <?php else : ?>
                <li><strong>No WooCommerce:</strong> Make sure custom post type is registered in theme</li>
            <?php endif; ?>
            <li><strong>Check Products:</strong> Make sure you have published products in WordPress Admin</li>
            <li><strong>Check Theme:</strong> Make sure Efficient Modern theme is active</li>
        </ol>
    </div>
    
    <p style="text-align: center; margin-top: 40px; color: #666;">
        <em>Delete this file (debug-products.php) when done debugging</em>
    </p>
</body>
</html>
