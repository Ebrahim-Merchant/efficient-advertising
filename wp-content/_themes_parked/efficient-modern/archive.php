<?php
/**
 * The template for displaying archive pages
 *
 * @package Efficient_Modern
 * @since 1.0.0
 */

get_header();
?>

<section class="archive-header">
    <div class="container">
        <div class="archive-header-content">
            <?php
            the_archive_title( '<h1 class="archive-title">', '</h1>' );
            the_archive_description( '<div class="archive-description">', '</div>' );
            ?>
        </div>
    </div>
</section>

<div class="container">
    <div class="content-wrapper section-padding">
        
        <main id="primary" class="content-area">
            
            <?php if ( have_posts() ) : ?>
                
                <div class="posts-grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                    ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
                            
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'efficient-category' ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="post-content">
                                <header class="post-header">
                                    <div class="post-meta">
                                        <span class="post-date">
                                            <i class="fa-regular fa-calendar"></i>
                                            <?php echo get_the_date(); ?>
                                        </span>
                                        <span class="post-author">
                                            <i class="fa-regular fa-user"></i>
                                            <?php the_author(); ?>
                                        </span>
                                    </div>
                                    
                                    <?php the_title( '<h2 class="post-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
                                </header>
                                
                                <div class="post-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" class="read-more">
                                    <?php esc_html_e( 'Read More', 'efficient-modern' ); ?>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                            
                        </article>
                    <?php
                    endwhile;
                    ?>
                </div>
                
                <?php
                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => '<i class="fa-solid fa-chevron-left"></i> ' . esc_html__( 'Previous', 'efficient-modern' ),
                    'next_text' => esc_html__( 'Next', 'efficient-modern' ) . ' <i class="fa-solid fa-chevron-right"></i>',
                ) );
                ?>
                
            <?php else : ?>
                
                <div class="no-posts-found">
                    <i class="fa-regular fa-folder-open"></i>
                    <h2><?php esc_html_e( 'Nothing Found', 'efficient-modern' ); ?></h2>
                    <p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for.', 'efficient-modern' ); ?></p>
                </div>
                
            <?php endif; ?>
            
        </main>

        <?php get_sidebar(); ?>
        
    </div>
</div>

<style>
.archive-header {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    color: var(--color-bg-white);
    padding: var(--spacing-3xl) 0;
    text-align: center;
}

.archive-title {
    font-size: var(--font-size-4xl);
    color: var(--color-bg-white);
    margin-bottom: var(--spacing-md);
}

.archive-description {
    font-size: var(--font-size-lg);
    opacity: 0.95;
    max-width: 700px;
    margin: 0 auto;
}

.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: var(--spacing-2xl);
    margin-bottom: var(--spacing-3xl);
}

.post-card {
    background: var(--color-bg-white);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: all var(--transition-base);
}

.post-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.post-thumbnail {
    position: relative;
    padding-top: 60%;
    overflow: hidden;
    background: var(--color-bg-gray);
}

.post-thumbnail img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-slow);
}

.post-card:hover .post-thumbnail img {
    transform: scale(1.1);
}

.post-content {
    padding: var(--spacing-xl);
}

.post-meta {
    display: flex;
    gap: var(--spacing-lg);
    font-size: var(--font-size-sm);
    color: var(--color-text-light);
    margin-bottom: var(--spacing-md);
}

.post-meta span {
    display: flex;
    align-items: center;
    gap: var(--spacing-xs);
}

.post-title {
    font-size: var(--font-size-2xl);
    margin-bottom: var(--spacing-md);
}

.post-title a {
    color: var(--color-text-dark);
    transition: color var(--transition-base);
}

.post-title a:hover {
    color: var(--color-primary);
}

.post-excerpt {
    color: var(--color-text-light);
    line-height: 1.7;
    margin-bottom: var(--spacing-lg);
}

.read-more {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-xs);
    color: var(--color-secondary);
    font-weight: 600;
    transition: all var(--transition-base);
}

.read-more:hover {
    gap: var(--spacing-sm);
}

.no-posts-found {
    text-align: center;
    padding: var(--spacing-4xl) 0;
}

.no-posts-found i {
    font-size: 5rem;
    color: var(--color-text-lighter);
    margin-bottom: var(--spacing-xl);
}

@media (max-width: 768px) {
    .posts-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
get_footer();
