<?php
/**
 * Template Name: Single Guide
 * Description: Premium detail view for material & sizing resource guides.
 *
 * @package NewEfficientAdvtWorkingTheme_v1.0
 */

get_header();

while ( have_posts() ) :
    the_post();
    
    // Fallback featured image URL
    $img_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
    if ( ! $img_url ) {
        $img_url = get_post_meta( get_the_ID(), '_ea_custom_featured_img', true );
    }
    if ( empty( $img_url ) ) {
        $img_url = '/wp-content/uploads/2022/03/3D-Aluminum-Signage-2.jpg';
    }
?>

<div class="ea-cat-hero" style="background: linear-gradient(135deg, #0A192F 0%, #0F172A 100%); padding: clamp(100px, 12vw, 150px) 0 60px; border-bottom: 1px solid rgba(255, 186, 9, 0.15); text-align: center;">
    <div class="container">
        <span style="color:#D4A73A; font-weight:700; font-size:12px; text-transform:uppercase; letter-spacing:3px; display:block; margin-bottom:15px;">UAE Corporate Material & Sizing Guides</span>
        <h1 style="color:#F5F7FA; font-size:clamp(28px, 4.2vw, 40px); font-weight:800; line-height:1.2; margin:0 0 20px; font-family:'Outfit', sans-serif;"><?php the_title(); ?></h1>
        <div class="ea-breadcrumbs" style="color:rgba(255,255,255,0.6); font-size:13.5px;">
            <a href="<?php echo esc_url( home_url() ); ?>" style="color:#D4A73A; text-decoration:none;">Home</a> &nbsp;·&nbsp; 
            <a href="<?php echo esc_url( home_url( '/guides/' ) ); ?>" style="color:#D4A73A; text-decoration:none;">Guides & Resources</a> &nbsp;·&nbsp; 
            <span><?php the_title(); ?></span>
        </div>
    </div>
</div>

<div class="container" style="margin-top:60px; margin-bottom:80px; font-family:'Outfit', sans-serif;">
    <div style="display:grid; grid-template-columns: 2.2fr 1fr; gap: clamp(30px, 4.5vw, 60px);">
        
        <!-- Left Column: Guide Content -->
        <main class="ea-guide-main-article" style="color:#cbd5e1; font-size:16px; line-height:1.75;">
            <?php if ( $img_url ) : ?>
                <div class="ea-guide-featured-wrap" style="margin-bottom:40px; border-radius:12px; overflow:hidden; box-shadow:0 15px 35px rgba(0,0,0,0.25); border:1px solid rgba(255,255,255,0.05); aspect-ratio: 16/9;">
                    <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>" style="width:100%; height:100%; object-fit:cover;" />
                </div>
            <?php endif; ?>

            <div class="ea-guide-rich-content">
                <?php the_content(); ?>
            </div>
            
            <div style="background:rgba(212,167,58,0.05); border:1px solid rgba(212,167,58,0.2); border-radius:8px; padding:30px; margin-top:50px;">
                <h4 style="color:#D4A73A; font-size:18px; margin:0 0 10px; font-weight:700;">Need Engineering & Material Advice?</h4>
                <p style="color:#8FA3B7; font-size:14.5px; margin:0 0 20px; line-height:1.6;">Our in-house design and fabrication experts are available to provide direct technical advice, structural load estimations, and tailored material specifications matching your UAE budget requirements.</p>
                <div style="display:flex; gap:15px; flex-wrap:wrap;">
                    <a href="https://wa.me/971527966265" class="ea-wa-cta-btn" style="background:#25D366; color:#fff; padding:12px 24px; border-radius:6px; font-weight:700; text-decoration:none; font-size:14.5px;">Consult on WhatsApp</a>
                    <a href="<?php echo esc_url( home_url( '/contact-us/?product=' . sanitize_title( get_the_title() ) ) ); ?>" style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:#fff; padding:12px 24px; border-radius:6px; font-weight:600; text-decoration:none; font-size:14.5px;">Request a Custom Proposal</a>
                </div>
            </div>
        </main>

        <!-- Right Column: Sidebar Resources -->
        <aside class="ea-guide-sidebar">
            <div style="background:#102B49; border:1px solid rgba(255,255,255,0.05); border-radius:12px; padding:30px; box-shadow:0 15px 35px rgba(0,0,0,0.25); position:sticky; top:110px;">
                <h3 style="color:#D4A73A; font-size:16px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin:0 0 20px; padding-bottom:10px; border-bottom:1px solid rgba(255,255,255,0.08);">More Sizing & Specs</h3>
                
                <?php
                $other_guides = new WP_Query( array(
                    'post_type'      => 'guide',
                    'posts_per_page' => 4,
                    'post__not_in'   => array( get_the_ID() )
                ) );
                
                if ( $other_guides->have_posts() ) :
                    echo '<ul style="list-style:none; padding:0; margin:0;">';
                    while ( $other_guides->have_posts() ) :
                        $other_guides->the_post();
                        ?>
                        <li style="margin-bottom:18px;">
                            <a href="<?php the_permalink(); ?>" style="color:#fff; text-decoration:none; font-weight:600; font-size:14.5px; line-height:1.4; display:block; transition:color 0.2s;"><?php the_title(); ?></a>
                            <p style="color:#8FA3B7; font-size:12.5px; margin:4px 0 0; line-height:1.4;"><?php echo wp_trim_words( get_the_excerpt(), 10 ); ?></p>
                        </li>
                        <?php
                    endwhile;
                    echo '</ul>';
                    wp_reset_postdata();
                else :
                    echo '<p style="color:#8FA3B7; font-size:13.5px; margin:0;">No additional guides currently published.</p>';
                endif;
                ?>
            </div>
        </aside>

    </div>
</div>

<?php
endwhile;

get_footer();
