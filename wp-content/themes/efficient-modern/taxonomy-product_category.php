<?php
/**
 * The template for displaying product category archives
 *
 * @package Efficient_Modern
 * @since 1.0.0
 */

get_header();

// Get current term
$term = get_queried_object();
$term_name = $term->name;
$term_description = $term->description;
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="page-header-content">
            <h1 class="page-title wow fadeInUp"><?php echo esc_html( $term_name ); ?></h1>
            <?php if ( $term_description ) : ?>
                <p class="page-description wow fadeInUp" data-wow-delay="0.2s">
                    <?php echo wp_kses_post( $term_description ); ?>
                </p>
            <?php endif; ?>
            
            <!-- Breadcrumbs (optional) -->
            <nav class="breadcrumbs wow fadeInUp" data-wow-delay="0.3s" aria-label="Breadcrumb">
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'efficient-modern' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/shop' ) ); ?>"><?php esc_html_e( 'Products', 'efficient-modern' ); ?></a></li>
                    <li class="active"><?php echo esc_html( $term_name ); ?></li>
                </ul>
            </nav>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="products-archive-section section-padding">
    <div class="container">
        
        <?php if ( have_posts() ) : ?>
            
            <!-- Products Count & Filter -->
            <div class="archive-toolbar">
                <div class="products-count">
                    <span>
                        <?php
                        printf(
                            esc_html( _n( 'Showing %d product', 'Showing %d products', $wp_query->found_posts, 'efficient-modern' ) ),
                            $wp_query->found_posts
                        );
                        ?>
                    </span>
                </div>
                
                <!-- Optional Sort/Filter -->
                <div class="products-filter">
                    <select id="product-sort" class="form-control">
                        <option value=""><?php esc_html_e( 'Default Sorting', 'efficient-modern' ); ?></option>
                        <option value="name-asc"><?php esc_html_e( 'Name: A to Z', 'efficient-modern' ); ?></option>
                        <option value="name-desc"><?php esc_html_e( 'Name: Z to A', 'efficient-modern' ); ?></option>
                        <option value="date-desc"><?php esc_html_e( 'Newest First', 'efficient-modern' ); ?></option>
                    </select>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="products-grid">
                <?php
                while ( have_posts() ) :
                    the_post();
                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'efficient-thumbnail' );
                ?>
                    <div class="product-card wow fadeInUp">
                        <a href="<?php the_permalink(); ?>" class="product-card-link">
                            <div class="product-image">
                                <?php 
                                if ( $thumb && isset( $thumb[0] ) ) : 
                                ?>
                                    <img src="<?php echo esc_url( $thumb[0] ); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php elseif ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'efficient-thumbnail' ); ?>
                                <?php else : ?>
                                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/placeholder.jpg' ); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php endif; ?>
                                
                                <div class="product-overlay">
                                    <span class="view-product">
                                        <?php esc_html_e( 'View Details', 'efficient-modern' ); ?>
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="product-content">
                                <h3 class="product-name"><?php the_title(); ?></h3>
                                
                                <?php if ( has_excerpt() ) : ?>
                                    <p class="product-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 15 ) ); ?></p>
                                <?php endif; ?>
                                
                                <span class="product-link-text">
                                    <?php esc_html_e( 'Learn More', 'efficient-modern' ); ?>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                        
                        <div class="product-actions-quick">
                            <button class="quick-order-btn" data-product-id="<?php the_ID(); ?>" data-product-title="<?php the_title_attribute(); ?>">
                                <i class="fa-solid fa-cart-plus"></i>
                                <span><?php esc_html_e( 'Quick Order', 'efficient-modern' ); ?></span>
                            </button>
                        </div>
                    </div>
                <?php
                endwhile;
                ?>
            </div>
            
            <!-- Pagination -->
            <div class="pagination-wrapper">
                <?php
                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => '<i class="fa-solid fa-chevron-left"></i> ' . esc_html__( 'Previous', 'efficient-modern' ),
                    'next_text' => esc_html__( 'Next', 'efficient-modern' ) . ' <i class="fa-solid fa-chevron-right"></i>',
                ) );
                ?>
            </div>
            
        <?php else : ?>
            
            <!-- No Products Found -->
            <div class="no-products-found">
                <div class="no-products-icon">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h2><?php esc_html_e( 'No products found', 'efficient-modern' ); ?></h2>
                <p><?php esc_html_e( 'Sorry, we couldn\'t find any products in this category.', 'efficient-modern' ); ?></p>
                <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="btn btn-primary">
                    <?php esc_html_e( 'View All Products', 'efficient-modern' ); ?>
                </a>
            </div>
            
        <?php endif; ?>
        
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section-simple">
    <div class="container">
        <div class="cta-simple-content">
            <h2 class="wow fadeInUp"><?php esc_html_e( 'Can\'t find what you\'re looking for?', 'efficient-modern' ); ?></h2>
            <p class="wow fadeInUp" data-wow-delay="0.2s">
                <?php esc_html_e( 'Contact us for custom printing solutions tailored to your needs.', 'efficient-modern' ); ?>
            </p>
            <div class="wow fadeInUp" data-wow-delay="0.4s">
                <a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>" class="btn btn-secondary btn-lg">
                    <?php esc_html_e( 'Contact Us', 'efficient-modern' ); ?>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    color: var(--color-bg-white);
    padding: var(--spacing-3xl) 0 var(--spacing-2xl);
    text-align: center;
}

.page-title {
    font-size: var(--font-size-5xl);
    color: var(--color-bg-white);
    margin-bottom: var(--spacing-md);
}

.page-description {
    font-size: var(--font-size-lg);
    max-width: 700px;
    margin: 0 auto var(--spacing-lg);
    opacity: 0.95;
}

/* Breadcrumbs */
.breadcrumbs ul {
    list-style: none;
    display: flex;
    justify-content: center;
    gap: var(--spacing-sm);
    padding: 0;
    margin: 0;
    font-size: var(--font-size-sm);
}

.breadcrumbs li {
    display: flex;
    align-items: center;
}

.breadcrumbs li:not(:last-child)::after {
    content: "›";
    margin-left: var(--spacing-sm);
    opacity: 0.7;
}

.breadcrumbs a {
    color: var(--color-bg-white);
    opacity: 0.8;
    transition: opacity var(--transition-base);
}

.breadcrumbs a:hover {
    opacity: 1;
}

.breadcrumbs .active {
    opacity: 1;
}

/* Archive Toolbar */
.archive-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--spacing-2xl);
    padding: var(--spacing-lg);
    background: var(--color-bg-light);
    border-radius: var(--radius-lg);
}

.products-count {
    font-weight: 600;
    color: var(--color-text-main);
}

.products-filter select {
    padding: 0.5rem 1rem;
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    background: var(--color-bg-white);
    font-size: var(--font-size-base);
    cursor: pointer;
}

/* Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: var(--spacing-xl);
    margin-bottom: var(--spacing-3xl);
}

.product-card {
    background: var(--color-bg-white);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: all var(--transition-base);
    position: relative;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.product-card-link {
    display: block;
    text-decoration: none;
    color: inherit;
}

.product-image {
    position: relative;
    padding-top: 100%;
    overflow: hidden;
    background: var(--color-bg-gray);
}

.product-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-slow);
}

.product-card:hover .product-image img {
    transform: scale(1.1);
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(139, 21, 56, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity var(--transition-base);
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.view-product {
    color: var(--color-bg-white);
    font-weight: 600;
    font-size: var(--font-size-lg);
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.product-content {
    padding: var(--spacing-lg);
}

.product-name {
    font-size: var(--font-size-xl);
    font-weight: 600;
    margin-bottom: var(--spacing-sm);
    transition: color var(--transition-base);
}

.product-card:hover .product-name {
    color: var(--color-primary);
}

.product-excerpt {
    font-size: var(--font-size-sm);
    color: var(--color-text-light);
    margin-bottom: var(--spacing-sm);
    line-height: 1.6;
}

.product-link-text {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-xs);
    font-size: var(--font-size-sm);
    font-weight: 600;
    color: var(--color-secondary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.product-link-text i {
    transition: transform var(--transition-base);
}

.product-card:hover .product-link-text i {
    transform: translateX(4px);
}

/* Quick Actions */
.product-actions-quick {
    padding: var(--spacing-md) var(--spacing-lg);
    border-top: 1px solid var(--color-border);
}

.quick-order-btn {
    width: 100%;
    padding: 0.75rem;
    background: var(--color-secondary);
    color: var(--color-bg-white);
    border: none;
    border-radius: var(--radius-md);
    font-weight: 600;
    cursor: pointer;
    transition: all var(--transition-base);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--spacing-sm);
}

.quick-order-btn:hover {
    background: var(--color-secondary-dark);
    transform: translateY(-2px);
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: var(--spacing-3xl);
}

.pagination {
    display: flex;
    gap: var(--spacing-sm);
    list-style: none;
    padding: 0;
}

.page-numbers {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 45px;
    height: 45px;
    padding: 0 var(--spacing-md);
    background: var(--color-bg-white);
    color: var(--color-text-main);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    font-weight: 600;
    transition: all var(--transition-base);
    text-decoration: none;
}

.page-numbers:hover,
.page-numbers.current {
    background: var(--color-primary);
    color: var(--color-bg-white);
    border-color: var(--color-primary);
}

/* No Products Found */
.no-products-found {
    text-align: center;
    padding: var(--spacing-4xl) var(--spacing-xl);
}

.no-products-icon {
    font-size: 5rem;
    color: var(--color-text-lighter);
    margin-bottom: var(--spacing-xl);
}

.no-products-found h2 {
    font-size: var(--font-size-3xl);
    margin-bottom: var(--spacing-md);
}

.no-products-found p {
    font-size: var(--font-size-lg);
    color: var(--color-text-light);
    margin-bottom: var(--spacing-xl);
}

/* Simple CTA */
.cta-section-simple {
    background: var(--color-bg-light);
    padding: var(--spacing-3xl) 0;
    text-align: center;
}

.cta-simple-content h2 {
    font-size: var(--font-size-3xl);
    margin-bottom: var(--spacing-md);
}

.cta-simple-content p {
    font-size: var(--font-size-lg);
    color: var(--color-text-light);
    margin-bottom: var(--spacing-xl);
}

.cta-simple-content .btn {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-sm);
}

/* Responsive */
@media (max-width: 768px) {
    .archive-toolbar {
        flex-direction: column;
        gap: var(--spacing-md);
        text-align: center;
    }
    
    .products-filter {
        width: 100%;
    }
    
    .products-filter select {
        width: 100%;
    }
    
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: var(--spacing-md);
    }
}

@media (max-width: 480px) {
    .products-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
get_footer();
