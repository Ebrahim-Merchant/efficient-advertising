<?php
/**
 * Template Functions
 *
 * @package Efficient_Modern
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Display post thumbnail with fallback
 */
function efficient_modern_post_thumbnail( $size = 'post-thumbnail', $attr = array() ) {
    if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
        return;
    }

    if ( is_singular() ) :
        ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail( $size, $attr ); ?>
        </div>
        <?php
    else :
        ?>
        <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
            <?php
            the_post_thumbnail( $size, array(
                'alt' => the_title_attribute( array( 'echo' => false ) ),
            ) );
            ?>
        </a>
        <?php
    endif;
}

/**
 * Display categories with custom styling
 */
function efficient_modern_categories_list() {
    $categories_list = get_the_category_list( ' ' );
    if ( $categories_list ) {
        printf( '<div class="cat-links">' . esc_html__( 'Posted in %1$s', 'efficient-modern' ) . '</div>', $categories_list );
    }
}

/**
 * Display tags with custom styling
 */
function efficient_modern_tags_list() {
    $tags_list = get_the_tag_list( '', ' ' );
    if ( $tags_list ) {
        printf( '<div class="tags-links">' . esc_html__( 'Tagged %1$s', 'efficient-modern' ) . '</div>', $tags_list );
    }
}

/**
 * Display posted on date
 */
function efficient_modern_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf(
        $time_string,
        esc_attr( get_the_date( DATE_W3C ) ),
        esc_html( get_the_date() ),
        esc_attr( get_the_modified_date( DATE_W3C ) ),
        esc_html( get_the_modified_date() )
    );

    $posted_on = sprintf(
        esc_html_x( 'Posted on %s', 'post date', 'efficient-modern' ),
        '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
    );

    echo '<span class="posted-on">' . $posted_on . '</span>';
}

/**
 * Display post author
 */
function efficient_modern_posted_by() {
    $byline = sprintf(
        esc_html_x( 'by %s', 'post author', 'efficient-modern' ),
        '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
    );

    echo '<span class="byline"> ' . $byline . '</span>';
}

/**
 * Get reading time estimate
 */
function efficient_modern_reading_time() {
    $content = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( strip_tags( $content ) );
    $reading_time = ceil( $word_count / 200 );

    $reading_text = sprintf(
        _n( '%s minute read', '%s minutes read', $reading_time, 'efficient-modern' ),
        $reading_time
    );

    return '<span class="reading-time">' . esc_html( $reading_text ) . '</span>';
}

/**
 * Custom comment callback
 */
function efficient_modern_comment( $comment, $args, $depth ) {
    ?>
    <li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <footer class="comment-meta">
                <div class="comment-author vcard">
                    <?php
                    if ( 0 != $args['avatar_size'] ) {
                        echo get_avatar( $comment, $args['avatar_size'] );
                    }
                    ?>
                    <?php
                    printf( __( '%s <span class="says">says:</span>', 'efficient-modern' ), sprintf( '<b class="fn">%s</b>', get_comment_author_link() ) );
                    ?>
                </div>

                <div class="comment-metadata">
                    <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
                        <time datetime="<?php comment_time( 'c' ); ?>">
                            <?php
                            printf( _x( '%1$s at %2$s', '1: date, 2: time', 'efficient-modern' ), get_comment_date( '', $comment ), get_comment_time() );
                            ?>
                        </time>
                    </a>
                    <?php edit_comment_link( __( 'Edit', 'efficient-modern' ), '<span class="edit-link">', '</span>' ); ?>
                </div>

                <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'efficient-modern' ); ?></p>
                <?php endif; ?>
            </footer>

            <div class="comment-content">
                <?php comment_text(); ?>
            </div>

            <div class="reply">
                <?php
                comment_reply_link(
                    array_merge(
                        $args,
                        array(
                            'add_below' => 'div-comment',
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'],
                        )
                    )
                );
                ?>
            </div>
        </article>
    <?php
}

/**
 * Get social share buttons
 */
function efficient_modern_social_share() {
    if ( ! is_singular() ) {
        return;
    }

    $url = urlencode( get_permalink() );
    $title = urlencode( get_the_title() );
    ?>
    <div class="social-share">
        <span class="share-label"><?php esc_html_e( 'Share:', 'efficient-modern' ); ?></span>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" target="_blank" rel="noopener" class="share-facebook">
            <i class="fa-brands fa-facebook-f"></i>
        </a>
        <a href="https://twitter.com/intent/tweet?url=<?php echo $url; ?>&text=<?php echo $title; ?>" target="_blank" rel="noopener" class="share-twitter">
            <i class="fa-brands fa-twitter"></i>
        </a>
        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>&title=<?php echo $title; ?>" target="_blank" rel="noopener" class="share-linkedin">
            <i class="fa-brands fa-linkedin-in"></i>
        </a>
        <a href="https://api.whatsapp.com/send?text=<?php echo $title; ?>%20<?php echo $url; ?>" target="_blank" rel="noopener" class="share-whatsapp">
            <i class="fa-brands fa-whatsapp"></i>
        </a>
    </div>
    <?php
}

/**
 * Pagination for archive pages
 */
function efficient_modern_pagination() {
    if ( $GLOBALS['wp_query']->max_num_pages <= 1 ) {
        return;
    }
    ?>
    <nav class="pagination" role="navigation">
        <?php
        echo paginate_links( array(
            'mid_size'  => 2,
            'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
            'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
            'type'      => 'list',
        ) );
        ?>
    </nav>
    <?php
}
