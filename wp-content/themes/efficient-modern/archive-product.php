<?php
/**
 * The template for displaying all products archive
 * Modern redesign - matching updated design system
 *
 * @package Efficient_Modern
 * @since 2.0.0
 */

get_header();
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
                            'taxonomy'   => 'product_category',
                            'hide_empty' => true,
                        ) );
                        
                        if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
                            foreach ( $categories as $category ) :
                                $selected = ( is_tax( 'product_category', $category->slug ) ) ? 'selected' : '';
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
                    
                    // Try to get featured image first
                    $image_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                    
                    // If no featured image, try ACF fields
                    if ( ! $image_url && function_exists( 'get_field' ) ) {
                        $image_url = get_field( 'product_image_one' );
                    }
                    
                    // Get category
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
                                    <img src="<?php echo esc_url( $image_url ); ?>" 
                                         alt="<?php the_title_attribute(); ?>" 
                                         class="product-image-modern"
                                         loading="lazy">
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
                <?php endwhile; ?>
            </div>
            
            <!-- Pagination -->
            <div class="pagination-wrapper-modern">
                <?php
                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => esc_html__( 'Previous', 'efficient-modern' ),
                    'next_text' => esc_html__( 'Next', 'efficient-modern' ) . ' <i class="fa-solid fa-chevron-right"></i>',
                    'type'      => 'list',
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
