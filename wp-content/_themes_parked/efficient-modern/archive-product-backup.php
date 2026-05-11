<?php
/**
 * The template for displaying all products archive
 * Modern redesign - matching updated design system
 *
 * @package Efficient_Modern
 * @since 2.0.0
 */

// If WooCommerce is active, use its shop template
if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_product_category() || is_product_tag() ) ) {
    woocommerce_content();
    get_footer();
    exit;
}

get_header();

// Get the correct taxonomy name
$product_taxonomy = 'product_category';
?>

<!-- Page Header -->
<header class="all-products-header">
    <div class="container">
        <div class="header-content">
            <h1 class="header-title"><?php esc_html_e( 'All Products', 'efficient-modern' ); ?></h1>
            <p class="header-description">
                <?php esc_html_e( 'Browse our complete range of high-quality printing and advertising solutions tailored for your business needs.', 'efficient-modern' ); ?>
            </p>
            
            <!-- Search Bar -->
            <div class="header-search-wrapper">
                <form role="search" method="get" class="product-search-form-modern" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <div class="search-input-wrapper">
                        <i class="fa-solid fa-search search-icon"></i>
                        <input type="search" 
                               class="search-field-modern" 
                               placeholder="<?php esc_attr_e( 'Search products...', 'efficient-modern' ); ?>" 
                               value="<?php echo get_search_query(); ?>" 
                               name="s" 
                               title="<?php esc_attr_e( 'Search for:', 'efficient-modern' ); ?>" />
                        <input type="hidden" name="post_type" value="product" />
                    </div>
                    <button type="submit" class="search-submit-modern">
                        <?php esc_html_e( 'Search', 'efficient-modern' ); ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<!-- Filter Bar -->
<section class="filter-bar-section">
    <div class="container">
        <div class="filter-bar-content">
            <div class="filter-left">
                <div class="filter-label">
                    <i class="fa-solid fa-filter"></i>
                    <span><?php esc_html_e( 'FILTER BY:', 'efficient-modern' ); ?></span>
                </div>
                <div class="filter-controls">
                    <!-- Category Filter -->
                    <select id="category-select-modern" class="filter-select">
                        <option value="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>">
                            <?php esc_html_e( 'All Categories', 'efficient-modern' ); ?>
                        </option>
                        <?php
                        $categories = get_terms( array(
                            'taxonomy'   => $product_taxonomy,
                            'hide_empty' => true,
                        ) );
                        
                        if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
                            foreach ( $categories as $category ) :
                                $selected = ( is_tax( $product_taxonomy, $category->slug ) ) ? 'selected' : '';
                        ?>
                            <option value="<?php echo esc_url( get_term_link( $category ) ); ?>" <?php echo $selected; ?>>
                                <?php echo esc_html( $category->name ); ?>
                            </option>
                        <?php 
                            endforeach;
                        endif;
                        ?>
                    </select>
                    
                    <!-- Sort Options -->
                    <select id="product-sort-modern" class="filter-select">
                        <option value="default"><?php esc_html_e( 'Sort By: Default', 'efficient-modern' ); ?></option>
                        <option value="latest"><?php esc_html_e( 'Latest', 'efficient-modern' ); ?></option>
                        <option value="popular"><?php esc_html_e( 'Most Popular', 'efficient-modern' ); ?></option>
                        <option value="price-low"><?php esc_html_e( 'Price: Low to High', 'efficient-modern' ); ?></option>
                    </select>
                </div>
            </div>
            
            <div class="filter-right">
                <span class="products-count-text">
                    <?php
                    global $wp_query;
                    printf(
                        esc_html__( 'Showing %d products', 'efficient-modern' ),
                        $wp_query->found_posts
                    );
                    ?>
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Products Grid -->
<main class="products-main-section">
    <div class="container">
        
        <?php if ( have_posts() ) : ?>
            
            <div class="products-grid-modern">
                <?php
                while ( have_posts() ) :
                    the_post();
                    $image_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                    $terms = get_the_terms( get_the_ID(), 'product_category' );
                    $category_name = '';
                    if ( $terms && ! is_wp_error( $terms ) ) {
                        $category_name = $terms[0]->name;
                    }
                ?>
                    <div class="product-card-modern">
                        <a href="<?php the_permalink(); ?>" class="product-link-modern">
                            <div class="product-image-wrapper">
                                <?php if ( $image_url ) : ?>
                                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title_attribute(); ?>" class="product-image-modern">
                                <?php else : ?>
                                    <div class="product-placeholder-modern">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="product-hover-overlay"></div>
                            </div>
                            
                            <div class="product-info-modern">
                                <?php if ( $category_name ) : ?>
                                    <span class="product-category-badge"><?php echo esc_html( $category_name ); ?></span>
                                <?php endif; ?>
                                <h3 class="product-title-modern"><?php the_title(); ?></h3>
                                <div class="product-view-link">
                                    <?php esc_html_e( 'View Details', 'efficient-modern' ); ?>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
                endwhile;
                ?>
            </div>
            
            <!-- Pagination -->
            <div class="pagination-modern">
                <?php
                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                $total_pages = $wp_query->max_num_pages;
                
                if ( $total_pages > 1 ) :
                ?>
                    <div class="pagination-buttons">
                        <?php for ( $i = 1; $i <= $total_pages; $i++ ) : ?>
                            <?php if ( $i == $paged ) : ?>
                                <span class="page-number active"><?php echo $i; ?></span>
                            <?php elseif ( $i <= 3 || $i == $total_pages || abs( $i - $paged ) <= 1 ) : ?>
                                <a href="<?php echo get_pagenum_link( $i ); ?>" class="page-number"><?php echo $i; ?></a>
                            <?php elseif ( $i == 4 && $paged > 5 ) : ?>
                                <span class="page-dots">...</span>
                            <?php elseif ( $i == $total_pages - 1 && $paged < $total_pages - 4 ) : ?>
                                <span class="page-dots">...</span>
                            <?php endif; ?>
                        <?php endfor; ?>
                        
                        <?php if ( $paged < $total_pages ) : ?>
                            <a href="<?php echo get_pagenum_link( $paged + 1 ); ?>" class="page-next">
                                <?php esc_html_e( 'Next', 'efficient-modern' ); ?> <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            
        <?php else : ?>
            
            <!-- No Products Found -->
            <div class="no-products-found-modern">
                <i class="fa-solid fa-box-open no-products-icon"></i>
                <h2 class="no-products-title"><?php esc_html_e( 'No Products Found', 'efficient-modern' ); ?></h2>
                <p class="no-products-text"><?php esc_html_e( 'We couldn\'t find any products. Please try different filters.', 'efficient-modern' ); ?></p>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" class="btn-view-all">
                    <?php esc_html_e( 'View All Products', 'efficient-modern' ); ?>
                </a>
            </div>
            
        <?php endif; ?>
        
    </div>
</main>

<!-- CTA Section -->
<section class="archive-cta-section">
    <div class="cta-background-pattern"></div>
    <div class="container">
        <div class="cta-content-modern">
            <h2 class="cta-title-modern"><?php esc_html_e( "Can't Find What You're Looking For?", 'efficient-modern' ); ?></h2>
            <p class="cta-description-modern"><?php esc_html_e( 'Contact us for custom printing solutions tailored to your specific needs.', 'efficient-modern' ); ?></p>
            <div class="cta-buttons-modern">
                <a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>" class="cta-btn-primary-white">
                    <i class="fa-solid fa-envelope"></i>
                    <?php esc_html_e( 'Contact Us', 'efficient-modern' ); ?>
                </a>
                <?php 
                $whatsapp_number = function_exists( 'of_get_option' ) ? of_get_option( 'whatsapp_number' ) : '+971527966265';
                if ( $whatsapp_number ) : 
                ?>
                    <a href="https://wa.me/<?php echo esc_attr( str_replace( array( '+', ' ', '-' ), '', $whatsapp_number ) ); ?>" 
                       class="cta-btn-whatsapp" 
                       target="_blank" 
                       rel="noopener">
                        <i class="fa-brands fa-whatsapp"></i>
                        <?php esc_html_e( 'WhatsApp Us', 'efficient-modern' ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
// Category filter redirect
document.getElementById('category-select-modern')?.addEventListener('change', function() {
    if (this.value) {
        window.location.href = this.value;
    }
});

// Sort functionality (add your AJAX implementation here)
document.getElementById('product-sort-modern')?.addEventListener('change', function() {
    // Implement sort functionality
    console.log('Sort by:', this.value);
});
</script>

<?php get_footer(); ?>
                                    <span class="view-details">
                                        <i class="fa-solid fa-eye"></i>
                                        <?php esc_html_e( 'View Details', 'efficient-modern' ); ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="product-content">
                                <h3 class="product-title"><?php the_title(); ?></h3>
                                
                                <?php
                                // Get product categories
                                $terms = get_the_terms( get_the_ID(), 'product_category' );
                                if ( $terms && ! is_wp_error( $terms ) ) :
                                    $categories = array();
                                    foreach ( $terms as $term ) {
                                        $categories[] = $term->name;
                                    }
                                    $category_list = join( ', ', $categories );
                                ?>
                                    <div class="product-category">
                                        <i class="fa-solid fa-tag"></i>
                                        <?php echo esc_html( $category_list ); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ( has_excerpt() ) : ?>
                                    <div class="product-excerpt">
                                        <?php echo wp_trim_words( get_the_excerpt(), 15, '...' ); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <span class="view-more-link">
                                    <?php esc_html_e( 'Learn More', 'efficient-modern' ); ?>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                <?php
                    $delay += 0.1;
                    if ( $delay > 0.6 ) $delay = 0.1; // Reset delay for stagger effect
                endwhile;
                ?>
            </div>
            
            <!-- Pagination -->
            <div class="pagination-wrapper wow fadeInUp">
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
                <div class="no-results-icon">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h2><?php esc_html_e( 'No Products Found', 'efficient-modern' ); ?></h2>
                <p><?php esc_html_e( 'We couldn\'t find any products matching your criteria. Try adjusting your filters or search terms.', 'efficient-modern' ); ?></p>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" class="btn btn-primary">
                    <i class="fa-solid fa-grid"></i>
                    <?php esc_html_e( 'View All Products', 'efficient-modern' ); ?>
                </a>
            </div>
            
        <?php endif; ?>
        
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content wow fadeInUp">
            <h2 class="cta-title"><?php esc_html_e( 'Can\'t Find What You\'re Looking For?', 'efficient-modern' ); ?></h2>
            <p class="cta-text"><?php esc_html_e( 'Contact us for custom printing solutions tailored to your specific needs.', 'efficient-modern' ); ?></p>
            <div class="cta-buttons">
                <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-primary btn-lg">
                    <i class="fa-solid fa-envelope"></i>
                    <?php esc_html_e( 'Contact Us', 'efficient-modern' ); ?>
                </a>
                <a href="https://wa.me/971509876543" class="btn btn-secondary btn-lg" target="_blank">
                    <i class="fa-brands fa-whatsapp"></i>
                    <?php esc_html_e( 'WhatsApp Us', 'efficient-modern' ); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
