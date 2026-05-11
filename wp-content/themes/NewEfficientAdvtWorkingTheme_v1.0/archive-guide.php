<?php
/**
 * Template Name: Guides Archive
 * Description: Premium list view for sizing and material resource guides.
 *
 * @package NewEfficientAdvtWorkingTheme_v1.0
 */

get_header();
?>

<div class="ea-cat-hero" style="background: linear-gradient(135deg, #0A192F 0%, #0F172A 100%); padding: clamp(100px, 12vw, 150px) 0 60px; border-bottom: 1px solid rgba(255, 186, 9, 0.15); text-align: center;">
    <div class="container">
        <span style="color:#D4A73A; font-weight:700; font-size:12px; text-transform:uppercase; letter-spacing:3px; display:block; margin-bottom:15px;">UAE Corporate Resource Center</span>
        <h1 style="color:#F5F7FA; font-size:clamp(32px, 5vw, 48px); font-weight:800; line-height:1.2; margin:0 0 20px; font-family:'Outfit', sans-serif;">Sizing &amp; Material Technical Guides</h1>
        <p style="color:#8FA3B7; max-width:650px; margin:0 auto 25px; font-size:16px; line-height:1.6; font-family:'Outfit', sans-serif;">
            Ensure compliance and perfect specs for your next campaign. Compare material specs, review sizing standards, and understand local RTA approval guidelines.
        </p>
    </div>
</div>

<div class="container" style="margin-top:60px; margin-bottom:100px; font-family:'Outfit', sans-serif;">
    <?php
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $guides_query = new WP_Query( array(
        'post_type'      => 'guide',
        'posts_per_page' => 12,
        'paged'          => $paged
    ) );
    
    if ( $guides_query->have_posts() ) :
    ?>
        <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap:30px;">
            <?php
            while ( $guides_query->have_posts() ) :
                $guides_query->the_post();
                
                // Fallback featured image
                $img_url = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
                if ( ! $img_url ) {
                    $img_url = get_post_meta( get_the_ID(), '_ea_custom_featured_img', true );
                }
                if ( empty( $img_url ) ) {
                    $img_url = '/wp-content/uploads/2022/03/3D-Aluminum-Signage-2.jpg';
                }
            ?>
                <article class="ea-guide-card" style="background:#0F1C30; border:1px solid rgba(255,255,255,0.05); border-radius:10px; overflow:hidden; display:flex; flex-direction:column; box-shadow:0 10px 30px rgba(0,0,0,0.15); transition:transform 0.3s ease, border-color 0.3s ease;">
                    <a href="<?php the_permalink(); ?>" style="text-decoration:none; color:inherit; display:flex; flex-direction:column; height:100%;">
                        
                        <div style="aspect-ratio:16/10; overflow:hidden; position:relative; border-bottom:1px solid rgba(255,255,255,0.05);">
                            <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>" style="width:100%; height:100%; object-fit:cover; transition:transform 0.5s ease;" />
                            <span style="position:absolute; bottom:12px; left:12px; background:rgba(212,167,58,0.95); color:#0B1F38; font-size:11px; font-weight:700; padding:4px 10px; border-radius:4px; text-transform:uppercase; letter-spacing:0.5px;">Technical Guide</span>
                        </div>

                        <div style="padding:25px; display:flex; flex-direction:column; flex-grow:1;">
                            <span style="color:#D4A73A; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:10px; display:block;">Specifications &amp; Standards</span>
                            <h2 style="color:#fff; font-size:18px; font-weight:700; margin:0 0 12px; line-height:1.4; transition:color 0.2s;"><?php the_title(); ?></h2>
                            <p style="color:#8FA3B7; font-size:13.5px; line-height:1.6; margin:0 0 20px; flex-grow:1;"><?php echo wp_trim_words( get_the_excerpt(), 18 ); ?></p>
                            
                            <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid rgba(255,255,255,0.05); padding-top:15px; font-size:13px; color:#D4A73A; font-weight:600;">
                                <span>Read Sizing Specs &rarr;</span>
                            </div>
                        </div>

                    </a>
                </article>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>

        <!-- Custom Pagination -->
        <div style="margin-top:50px; text-align:center;">
            <?php
            echo paginate_links( array(
                'total'   => $guides_query->max_num_pages,
                'current' => $paged,
                'format'  => '?paged=%#%',
                'prev_text' => '&larr; Previous',
                'next_text' => 'Next &rarr;',
            ) );
            ?>
        </div>
        
    <?php else : ?>
        <p style="color:#8FA3B7; text-align:center; font-size:16px;">Our material resource guides are presently loading. Check back soon!</p>
    <?php endif; ?>
</div>

<?php
get_footer();
