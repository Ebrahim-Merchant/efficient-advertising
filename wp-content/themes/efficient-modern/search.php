<?php
/**
 * The template for displaying search results
 * Modern redesign - matching updated design system
 *
 * @package Efficient_Modern
 * @since 2.0.0
 */

get_header();

// Check if this is a product search
$is_product_search = ( isset( $_GET['post_type'] ) && $_GET['post_type'] === 'product' );
?>

<!-- Page Header -->
<header class="search-results-header">
    <div class="container">
        <div class="header-content">
            <h1 class="header-title">
                <?php
                if ( $is_product_search ) {
                    printf(
                        esc_html__( 'Product Search: %s', 'efficient-modern' ),
                        '<span class="search-query">' . get_search_query() . '</span>'
                    );
                } else {
                    printf(
                        esc_html__( 'Search Results: %s', 'efficient-modern' ),
                        '<span class="search-query">' . get_search_query() . '</span>'
                    );
                }
                ?>
            </h1>
            
            <?php if ( have_posts() ) : ?>
                <p class="header-description">
                    <?php
                    printf(
                        esc_html( _n( 'Found %d result', 'Found %d results', $wp_query->found_posts, 'efficient-modern' ) ),
                        $wp_query->found_posts
                    );
                    ?>
                </p>
            <?php endif; ?>
            
            <!-- Search Bar -->
            <div class="header-search-wrapper">
                <form role="search" method="get" class="product-search-form-modern" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <div class="search-input-wrapper">
                        <i class="fa-solid fa-search search-icon"></i>
                        <input type="search" 
                               class="search-field-modern" 
                               placeholder="<?php esc_attr_e( 'Try another search...', 'efficient-modern' ); ?>" 
                               value="<?php echo get_search_query(); ?>" 
                               name="s" 
                               title="<?php esc_attr_e( 'Search for:', 'efficient-modern' ); ?>" />
                        <?php if ( $is_product_search ) : ?>
                            <input type="hidden" name="post_type" value="product" />
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="search-submit-modern">
                        <?php esc_html_e( 'Search', 'efficient-modern' ); ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<?php if ( $is_product_search ) : ?>
    
    <!-- Product Search Results -->
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
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h2><?php esc_html_e( 'No Products Found', 'efficient-modern' ); ?></h2>
                    <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'efficient-modern' ); ?></p>
                    
                    <div class="search-suggestions">
                        <h3><?php esc_html_e( 'Try:', 'efficient-modern' ); ?></h3>
                        <ul>
                            <li><?php esc_html_e( 'Check your spelling', 'efficient-modern' ); ?></li>
                            <li><?php esc_html_e( 'Use more general keywords', 'efficient-modern' ); ?></li>
                            <li><?php esc_html_e( 'Try different keywords', 'efficient-modern' ); ?></li>
                        </ul>
                    </div>
                    
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" class="btn btn-primary">
                        <i class="fa-solid fa-grid"></i>
                        <?php esc_html_e( 'View All Products', 'efficient-modern' ); ?>
                    </a>
                </div>
                
            <?php endif; ?>
            
        </div>
    </main>

<?php else : ?>
    
    <!-- General Search Results (Posts/Pages) -->
    <main class="search-results-section">
        <div class="container">
            
            <?php if ( have_posts() ) : ?>
                
                <div class="search-results-list">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        
                        $post_type = get_post_type();
                        $post_type_obj = get_post_type_object( $post_type );
                    ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'search-result-item' ); ?>>
                            
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="result-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'medium' ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="result-content">
                                <div class="result-meta">
                                    <span class="post-type-badge">
                                        <?php echo esc_html( $post_type_obj->labels->singular_name ); ?>
                                    </span>
                                    <span class="result-date">
                                        <i class="fa-regular fa-calendar"></i>
                                        <?php echo get_the_date(); ?>
                                    </span>
                                </div>
                                
                                <?php the_title( '<h2 class="result-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
                                
                                <div class="result-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" class="result-link">
                                    <?php esc_html_e( 'Read More', 'efficient-modern' ); ?>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                            
                        </article>
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
                
                <!-- No Results Found -->
                <div class="no-products-found">
                    <div class="no-results-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h2><?php esc_html_e( 'No Results Found', 'efficient-modern' ); ?></h2>
                    <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'efficient-modern' ); ?></p>
                    
                    <div class="search-suggestions">
                        <h3><?php esc_html_e( 'Search Suggestions:', 'efficient-modern' ); ?></h3>
                        <ul>
                            <li><?php esc_html_e( 'Check your spelling', 'efficient-modern' ); ?></li>
                            <li><?php esc_html_e( 'Try more general keywords', 'efficient-modern' ); ?></li>
                            <li><?php esc_html_e( 'Try different keywords', 'efficient-modern' ); ?></li>
                        </ul>
                    </div>
                    
                    <div class="alternative-options">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                            <?php esc_html_e( 'Go Home', 'efficient-modern' ); ?>
                        </a>
                        <a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>" class="btn btn-outline">
                            <?php esc_html_e( 'Contact Us', 'efficient-modern' ); ?>
                        </a>
                    </div>
                </div>
                
            <?php endif; ?>
            
        </div>
    </main>

<?php endif; ?>

<!-- CTA Section -->
<section class="cta-section-modern">
    <div class="container">
        <div class="cta-content-wrapper">
            <div class="cta-text-content">
                <h2 class="cta-title-modern">Need Help Finding What You're Looking For?</h2>
                <p class="cta-description-modern">Our team is here to help you find the perfect solution. Request a custom quote or get in touch with us directly.</p>
            </div>
            <div class="cta-buttons-modern">
                <button class="cta-btn-primary-white" data-toggle="modal" data-target="#requestQuoteModal">
                    <i class="fa-solid fa-file-lines"></i>
                    Request a Quote
                </button>
                <a href="https://wa.me/9714204222" class="cta-btn-whatsapp" target="_blank" rel="noopener">
                    <i class="fa-brands fa-whatsapp"></i>
                    WhatsApp Us
                </a>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();


