<?php
/**
 * Template Name: Single Portfolio Project
 * Description: Premium detail view for portfolio case studies.
 *
 * @package NewEfficientAdvtWorkingTheme_v1.0
 */

get_header();

while ( have_posts() ) :
    the_post();
    
    // Fetch custom project specifications meta
    $client    = get_post_meta( get_the_ID(), 'ea_proj_client', true );
    $location  = get_post_meta( get_the_ID(), 'ea_proj_location', true );
    $duration  = get_post_meta( get_the_ID(), 'ea_proj_duration', true );
    $materials = get_post_meta( get_the_ID(), 'ea_proj_materials', true );
    $link_url  = get_post_meta( get_the_ID(), 'ea_proj_link_url', true );
    if ( empty( $link_url ) ) {
        $link_url = '/catalogue/';
    }
    
    // Fallback featured image URL
    $img_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
    if ( ! $img_url ) {
        $img_url = get_post_meta( get_the_ID(), '_ea_custom_featured_img', true );
    }
    if ( empty( $img_url ) ) {
        $img_url = '/wp-content/uploads/2022/03/3D-Aluminum-Signage-2.jpg';
    }
?>

<div class="ea-cat-hero" style="background: linear-gradient(135deg, #0A192F 0%, #0F172A 100%); padding: clamp(100px, 12vw, 150px) 0 60px; border-bottom: 1px solid rgba(255, 186, 9, 0.15); text-align: center; position: relative;">
    <div class="container" style="position: relative; z-index: 2;">
        <span style="color:#D4A73A; font-weight:700; font-size:12px; text-transform:uppercase; letter-spacing:3px; display:block; margin-bottom:15px;">Real UAE Installation · Proof of Work</span>
        <h1 style="color:#F5F7FA; font-size:clamp(28px, 4.5vw, 42px); font-weight:800; line-height:1.2; margin:0 0 20px; text-shadow:0 2px 10px rgba(0,0,0,0.5); font-family:'Outfit', sans-serif;"><?php the_title(); ?></h1>
        <div class="ea-breadcrumbs" style="color:rgba(255,255,255,0.6); font-size:13.5px;">
            <a href="<?php echo esc_url( home_url() ); ?>" style="color:#D4A73A; text-decoration:none;">Home</a> &nbsp;·&nbsp; 
            <a href="<?php echo esc_url( home_url( '/portfolio/' ) ); ?>" style="color:#D4A73A; text-decoration:none;">Portfolio</a> &nbsp;·&nbsp; 
            <span><?php the_title(); ?></span>
        </div>
    </div>
</div>

<div class="container" style="margin-top:60px; margin-bottom:80px;">
    <div style="display:grid; grid-template-columns: 2fr 1fr; gap: clamp(30px, 4.5vw, 60px);">
        
        <!-- Left: Case Study Article -->
        <article class="ea-project-article" style="color:#cbd5e1; font-family:'Outfit', sans-serif;">
            <?php if ( $img_url ) : ?>
                <div class="ea-project-main-image" style="margin-bottom:40px; border-radius:12px; overflow:hidden; box-shadow:0 20px 40px rgba(0,0,0,0.3); border:1px solid rgba(255,255,255,0.05); aspect-ratio: 16/10;">
                    <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>" style="width:100%; height:100%; object-fit:cover;" />
                </div>
            <?php endif; ?>

            <div class="ea-project-body-content" style="font-size:16px; line-height:1.75;">
                <?php the_content(); ?>
            </div>
        </article>

        <!-- Right: Specifications Panel -->
        <aside class="ea-project-sidebar" style="font-family:'Outfit', sans-serif;">
            <div style="background:#102B49; border:1px solid rgba(212,167,58,0.2); border-radius:12px; padding:30px; box-shadow:0 15px 35px rgba(0,0,0,0.25); position:sticky; top:110px;">
                <h3 style="color:#D4A73A; font-size:18px; font-weight:700; margin:0 0 20px; text-transform:uppercase; letter-spacing:1px; border-bottom:1px solid rgba(255,255,255,0.08); padding-bottom:12px;">Project Specifications</h3>
                
                <table style="width:100%; font-size:14.5px; border-collapse:collapse; margin-bottom:30px;">
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                        <td style="padding:12px 0; color:#8FA3B7; font-weight:500;">Client Entity:</td>
                        <td style="padding:12px 0; color:#fff; text-align:right; font-weight:600;"><?php echo esc_html( $client ? $client : 'Corporate Enterprise' ); ?></td>
                    </tr>
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                        <td style="padding:12px 0; color:#8FA3B7; font-weight:500;">Location:</td>
                        <td style="padding:12px 0; color:#fff; text-align:right; font-weight:600;"><?php echo esc_html( $location ? $location : 'Dubai, UAE' ); ?></td>
                    </tr>
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                        <td style="padding:12px 0; color:#8FA3B7; font-weight:500;">Completion Frame:</td>
                        <td style="padding:12px 0; color:#fff; text-align:right; font-weight:600;"><?php echo esc_html( $duration ? $duration : '5 Business Days' ); ?></td>
                    </tr>
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                        <td style="padding:12px 0; color:#8FA3B7; font-weight:500;">Materials Base:</td>
                        <td style="padding:12px 0; color:#fff; text-align:right; font-weight:500; font-size:13.5px; line-height:1.4; max-width:180px;"><?php echo esc_html( $materials ? $materials : 'Certified Commercial Grade' ); ?></td>
                    </tr>
                </table>

                <div style="text-align:center;">
                    <a href="<?php echo esc_url( $link_url ); ?>" class="btn-primary" style="display:block; background:#D4A73A; color:#0B1F38; text-decoration:none; padding:14px 20px; border-radius:6px; font-weight:700; font-size:15px; text-transform:uppercase; letter-spacing:1px; margin-bottom:15px; text-align:center; transition:background 0.2s;">
                        Browse Allied Products
                    </a>
                    <a href="<?php echo esc_url( home_url( '/contact-us/?product=' . sanitize_title( get_the_title() ) ) ); ?>" style="display:block; background:rgba(255,255,255,0.03); color:#fff; text-decoration:none; padding:12px 20px; border-radius:6px; font-weight:600; font-size:14px; border:1px solid rgba(255,255,255,0.1); text-align:center; transition:background 0.2s;">
                        Get Custom Estimate
                    </a>
                </div>
            </div>
        </aside>

    </div>
</div>

<?php
endwhile;

get_footer();
