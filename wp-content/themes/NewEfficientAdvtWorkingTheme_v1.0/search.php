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
    padding: clamp(104px, 12vw, 148px) 20px 32px;
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

/* Search-specific grid — ea-search-* prefix avoids WooCommerce class conflicts */
.ea-search-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}
@media (max-width: 991px) { .ea-search-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px)  { .ea-search-grid { grid-template-columns: repeat(1, 1fr); } }

.ea-search-card {
    width: 100%;
    box-sizing: border-box;
    overflow: hidden;
    background: #fff;
    border-radius: 6px;
    border: 1px solid #eee;
    display: flex;
    flex-direction: column;
}
.ea-search-img {
    width: 100%;
    height: 200px !important;
    overflow: hidden;
    position: relative;
    flex-shrink: 0;
}
.ea-search-img img,
.ea-search-img img.wp-post-image {
    width: 100% !important;
    height: 100% !important;
    display: block !important;
    object-fit: cover !important;
    max-width: 100% !important;
}
.ea-search-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.2s;
}
.ea-search-card:hover .ea-search-overlay { opacity: 1; }
.ea-search-view { color: #fff; font-size: 13px; font-weight: 600; }
.ea-search-card-link { text-decoration: none; color: inherit; display: flex; flex-direction: column; flex: 1; }
.ea-search-content {
    padding: 12px 14px;
    width: 100%;
    box-sizing: border-box;
    flex: 1;
}
.ea-search-name { font-size: 14px; font-weight: 600; margin: 0 0 6px; color: #1c1c1c; }
.ea-search-excerpt { font-size: 13px; color: #555; margin: 0 0 8px; min-height: 54px; }
.ea-search-link-text { font-size: 12px; color: #e02020; font-weight: 600; }
.ea-search-actions { padding: 8px 14px 12px; }
.ea-search-order-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #1c1c1c;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 7px 14px;
    font-size: 13px;
    cursor: pointer;
}
.ea-search-order-btn:hover { background: #333; }

body { overflow-x: hidden; }

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

        <div class="ea-search-grid">
            <?php while ( have_posts() ) : the_post();
                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'efficient-thumbnail' );
            ?>
            <div class="ea-search-card">
                <a href="<?php the_permalink(); ?>" class="ea-search-card-link">
                    <div class="ea-search-img">
                        <?php if ( $thumb && isset( $thumb[0] ) ) : ?>
                            <img src="<?php echo esc_url( $thumb[0] ); ?>" alt="<?php the_title_attribute(); ?>">
                        <?php elseif ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'efficient-thumbnail' ); ?>
                        <?php else : ?>
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/placeholder.jpg' ); ?>" alt="<?php the_title_attribute(); ?>">
                        <?php endif; ?>
                        <div class="ea-search-overlay">
                            <span class="ea-search-view">View Details <i class="fa-solid fa-arrow-right"></i></span>
                        </div>
                    </div>
                    <div class="ea-search-content">
                        <h3 class="ea-search-name"><?php the_title(); ?></h3>
                        <?php $excerpt = get_the_excerpt(); if ( $excerpt ) : ?>
                            <p class="ea-search-excerpt"><?php echo esc_html( wp_trim_words( $excerpt, 12 ) ); ?></p>
                        <?php else : ?>
                            <p class="ea-search-excerpt"></p>
                        <?php endif; ?>
                        <span class="ea-search-link-text">Learn More <i class="fa-solid fa-arrow-right"></i></span>
                    </div>
                </a>
                <div class="ea-search-actions">
                    <button class="ea-search-order-btn" data-product-id="<?php the_ID(); ?>" data-product-title="<?php the_title_attribute(); ?>">
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
            <a href="<?php echo esc_url( home_url( '/catalogue/' ) ); ?>" class="ea-wa-cta-btn" style="display:inline-flex;background:#1c1c1c;">Browse All Products</a>
        </div>

    <?php endif; ?>

</div>

<?php get_footer(); ?>
