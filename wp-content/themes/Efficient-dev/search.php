<?php
/**
 * Search results template — shows WooCommerce products matching the query
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$search_query = get_search_query();
$found        = $wp_query->found_posts;
?>

<style>
.ea-search-hero {
    background: #1c1c1c;
    padding: 38px 0 32px;
    text-align: center;
    color: #fff;
}
.ea-search-hero h1 {
    font-size: 22px;
    font-weight: 700;
    margin: 0 0 10px;
    color: #fff;
}
.ea-search-hero p {
    font-size: 14px;
    color: #aaa;
    margin: 0 0 18px;
}
.ea-search-form-wrap {
    display: flex;
    justify-content: center;
    gap: 0;
    max-width: 480px;
    margin: 0 auto;
}
.ea-search-form-wrap input[type="search"] {
    flex: 1;
    padding: 10px 16px;
    border: none;
    border-radius: 6px 0 0 6px;
    font-size: 14px;
    outline: none;
}
.ea-search-form-wrap button {
    padding: 10px 20px;
    background: #e02020;
    color: #fff;
    border: none;
    border-radius: 0 6px 6px 0;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
}
.ea-search-form-wrap button:hover { background: #b00000; }

.ea-search-results-wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px 20px 60px;
}
.ea-search-count {
    font-size: 13px;
    color: #666;
    margin-bottom: 20px;
}
.ea-search-count strong { color: #222; }

/* Reuse same product grid as category pages */
.products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}
@media (max-width: 991px) { .products-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 600px)  { .products-grid { grid-template-columns: repeat(2, 1fr); } }

.ea-no-results {
    text-align: center;
    padding: 60px 20px;
    color: #555;
}
.ea-no-results h2 { font-size: 20px; margin-bottom: 10px; }
.ea-no-results p  { font-size: 14px; margin-bottom: 24px; }
</style>

<!-- Search Hero -->
<div class="ea-search-hero">
    <h1>
        <?php if ( $found > 0 ) : ?>
            <?php echo esc_html( $found ); ?> result<?php echo $found !== 1 ? 's' : ''; ?> for &ldquo;<?php echo esc_html( $search_query ); ?>&rdquo;
        <?php else : ?>
            No results for &ldquo;<?php echo esc_html( $search_query ); ?>&rdquo;
        <?php endif; ?>
    </h1>
    <p>Search our full catalogue of <?php echo esc_html( wp_count_posts( 'product' )->publish ); ?> products</p>
    <form class="ea-search-form-wrap" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
        <input type="search" name="s" placeholder="Try another search..." value="<?php echo esc_attr( $search_query ); ?>" autocomplete="off" />
        <button type="submit">Search</button>
    </form>
</div>

<div class="ea-search-results-wrap">

    <?php if ( have_posts() ) : ?>

        <p class="ea-search-count">Showing <strong><?php echo esc_html( $found ); ?></strong> product<?php echo $found !== 1 ? 's' : ''; ?> matching <strong>&ldquo;<?php echo esc_html( $search_query ); ?>&rdquo;</strong></p>

        <div class="products-grid">
            <?php while ( have_posts() ) : the_post();
                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'efficient-thumbnail' );
            ?>
            <div class="product-card">
                <a href="<?php the_permalink(); ?>" class="product-card-link">
                    <div class="product-image">
                        <?php if ( $thumb && isset( $thumb[0] ) ) : ?>
                            <img src="<?php echo esc_url( $thumb[0] ); ?>" alt="<?php the_title_attribute(); ?>">
                        <?php elseif ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'efficient-thumbnail' ); ?>
                        <?php else : ?>
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/placeholder.jpg' ); ?>" alt="<?php the_title_attribute(); ?>">
                        <?php endif; ?>
                        <div class="product-overlay">
                            <span class="view-product">View Details <i class="fa-solid fa-arrow-right"></i></span>
                        </div>
                    </div>
                    <div class="product-content">
                        <h3 class="product-name"><?php the_title(); ?></h3>
                        <?php if ( has_excerpt() ) : ?>
                            <p class="product-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 12 ) ); ?></p>
                        <?php endif; ?>
                        <span class="product-link-text">Learn More <i class="fa-solid fa-arrow-right"></i></span>
                    </div>
                </a>
                <div class="product-actions-quick">
                    <button class="quick-order-btn" data-product-id="<?php the_ID(); ?>" data-product-title="<?php the_title_attribute(); ?>">
                        <i class="fa-solid fa-cart-plus"></i>
                        <span>Quick Order</span>
                    </button>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper" style="margin-top:40px;">
            <?php the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => '&lsaquo; Previous',
                'next_text' => 'Next &rsaquo;',
            ) ); ?>
        </div>

    <?php else : ?>

        <div class="ea-no-results">
            <h2>No products found</h2>
            <p>We couldn&rsquo;t find anything matching &ldquo;<?php echo esc_html( $search_query ); ?>&rdquo;. Try a different keyword.</p>
            <a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="ea-wa-cta-btn" style="display:inline-flex;background:#1c1c1c;">Browse All Products</a>
        </div>

    <?php endif; ?>

</div>

<?php get_footer(); ?>
