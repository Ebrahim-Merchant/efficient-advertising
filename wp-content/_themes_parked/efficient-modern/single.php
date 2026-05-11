<?php
/**
 * The template for displaying all single posts
 *
 * @package Efficient_Modern
 * @since 1.0.0
 */

get_header();
?>

<div class="container">
    <div class="content-wrapper section-padding">
        
        <main id="primary" class="content-area">
            <?php
            while ( have_posts() ) :
                the_post();
                ?>
                
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    
                    <header class="entry-header">
                        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        
                        <div class="entry-meta">
                            <?php
                            efficient_modern_posted_on();
                            efficient_modern_posted_by();
                            ?>
                        </div>
                    </header>
                    
                    <?php efficient_modern_post_thumbnail( 'efficient-hero' ); ?>
                    
                    <div class="entry-content">
                        <?php
                        the_content();

                        wp_link_pages(
                            array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'efficient-modern' ),
                                'after'  => '</div>',
                            )
                        );
                        ?>
                    </div>
                    
                    <footer class="entry-footer">
                        <?php
                        efficient_modern_categories_list();
                        efficient_modern_tags_list();
                        ?>
                    </footer>
                    
                </article>

                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            endwhile;
            ?>
        </main>

        <?php get_sidebar(); ?>
        
    </div>
</div>

<?php
get_footer();
