<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Efficient_Modern
 * @since 1.0.0
 */

get_header();
?>

<section class="error-404-section section-padding">
    <div class="container">
        <div class="error-404-content">
            
            <div class="error-404-icon">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            
            <h1 class="error-404-title">
                <?php esc_html_e( '404', 'efficient-modern' ); ?>
            </h1>
            
            <h2 class="error-404-subtitle">
                <?php esc_html_e( 'Oops! Page Not Found', 'efficient-modern' ); ?>
            </h2>
            
            <p class="error-404-text">
                <?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'efficient-modern' ); ?>
            </p>
            
            <!-- Search Form -->
            <div class="error-404-search">
                <?php get_search_form(); ?>
            </div>
            
            <!-- Quick Links -->
            <div class="error-404-links">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                    <i class="fa-solid fa-house"></i>
                    <?php esc_html_e( 'Go to Homepage', 'efficient-modern' ); ?>
                </a>
                <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="btn btn-outline">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <?php esc_html_e( 'Browse Products', 'efficient-modern' ); ?>
                </a>
                <a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>" class="btn btn-outline">
                    <i class="fa-solid fa-envelope"></i>
                    <?php esc_html_e( 'Contact Us', 'efficient-modern' ); ?>
                </a>
            </div>
            
            <!-- Popular Products/Categories -->
            <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <div class="error-404-suggestions">
                    <h3><?php esc_html_e( 'Popular Categories', 'efficient-modern' ); ?></h3>
                    
                    <div class="category-suggestions">
                        <?php
                        $categories = get_terms( array(
                            'taxonomy'   => 'product_cat',
                            'hide_empty' => true,
                            'number'     => 4,
                            'exclude'    => get_option( 'default_product_cat' ),
                        ) );
                        
                        if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
                            foreach ( $categories as $category ) :
                        ?>
                            <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="category-suggestion">
                                <i class="fa-solid fa-folder"></i>
                                <?php echo esc_html( $category->name ); ?>
                            </a>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>

<style>
.error-404-section {
    min-height: 70vh;
    display: flex;
    align-items: center;
    background: var(--color-bg-light);
}

.error-404-content {
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

.error-404-icon {
    font-size: 5rem;
    color: var(--color-secondary);
    margin-bottom: var(--spacing-xl);
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

.error-404-title {
    font-size: 8rem;
    font-weight: 800;
    color: var(--color-primary);
    line-height: 1;
    margin-bottom: var(--spacing-md);
}

.error-404-subtitle {
    font-size: var(--font-size-3xl);
    margin-bottom: var(--spacing-md);
    color: var(--color-text-dark);
}

.error-404-text {
    font-size: var(--font-size-lg);
    color: var(--color-text-light);
    margin-bottom: var(--spacing-2xl);
    line-height: 1.8;
}

.error-404-search {
    max-width: 500px;
    margin: 0 auto var(--spacing-2xl);
}

.error-404-search .search-form {
    display: flex;
    gap: var(--spacing-sm);
}

.error-404-search input[type="search"] {
    flex: 1;
    padding: 1rem;
    border: 2px solid var(--color-border);
    border-radius: var(--radius-lg);
    font-size: var(--font-size-base);
}

.error-404-search button {
    padding: 1rem 2rem;
    background: var(--color-primary);
    color: white;
    border: none;
    border-radius: var(--radius-lg);
    font-weight: 600;
    cursor: pointer;
    transition: all var(--transition-base);
}

.error-404-search button:hover {
    background: var(--color-primary-dark);
}

.error-404-links {
    display: flex;
    gap: var(--spacing-md);
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: var(--spacing-3xl);
}

.error-404-links .btn {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.error-404-suggestions {
    margin-top: var(--spacing-3xl);
    padding-top: var(--spacing-3xl);
    border-top: 1px solid var(--color-border);
}

.error-404-suggestions h3 {
    font-size: var(--font-size-2xl);
    margin-bottom: var(--spacing-lg);
    color: var(--color-text-dark);
}

.category-suggestions {
    display: flex;
    flex-wrap: wrap;
    gap: var(--spacing-md);
    justify-content: center;
}

.category-suggestion {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-sm);
    padding: 0.75rem 1.5rem;
    background: var(--color-bg-white);
    color: var(--color-text-main);
    border: 2px solid var(--color-border);
    border-radius: var(--radius-full);
    font-weight: 600;
    transition: all var(--transition-base);
}

.category-suggestion:hover {
    background: var(--color-primary);
    color: var(--color-bg-white);
    border-color: var(--color-primary);
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .error-404-title {
        font-size: 6rem;
    }
    
    .error-404-subtitle {
        font-size: var(--font-size-2xl);
    }
    
    .error-404-links {
        flex-direction: column;
    }
    
    .error-404-links .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<?php
get_footer();
