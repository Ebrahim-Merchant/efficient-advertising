<?php
/**
 * The main template file - Homepage
 *
 * Template Name: Home
 *
 * @package Efficient_Modern
 * @since 1.0.0
 */

get_header();
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-background">
        <?php
        // Get hero image from theme options or use default
        $hero_image = function_exists( 'get_field' ) && get_field( 'hero_background_image' ) 
            ? get_field( 'hero_background_image' ) 
            : 'https://efficientadvt.com/wp-content/uploads/2022/06/bak-1.png';
        ?>
        <div class="hero-image" style="background-image: url('<?php echo esc_url( $hero_image ); ?>')"></div>
        <div class="hero-overlay"></div>
    </div>
    
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title wow fadeInUp" data-wow-delay="0.2s">
                    You think it, <span class="highlight">We print it</span>
                </h1>
                
                <p class="hero-subtitle wow fadeInUp" data-wow-delay="0.4s">
                    Dubai's premier digital printing company delivering exceptional quality for B2B signage, branding, and promotional materials since 2010.
                </p>
                
                <div class="hero-buttons wow fadeInUp" data-wow-delay="0.6s">
                    <a href="<?php echo esc_url( home_url( '/products' ) ); ?>" class="btn btn-primary btn-lg">
                        <span><?php esc_html_e( 'Browse Products', 'efficient-modern' ); ?></span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>" class="btn btn-outline btn-lg">
                        <span><?php esc_html_e( 'Get a Quote', 'efficient-modern' ); ?></span>
                    </a>
                </div>
                
                <!-- Trust Indicators -->
                <div class="trust-indicators wow fadeInUp" data-wow-delay="0.8s">
                    <div class="trust-item">
                        <span class="trust-number">14+</span>
                        <span class="trust-label"><?php esc_html_e( 'Years Experience', 'efficient-modern' ); ?></span>
                    </div>
                    <div class="trust-item">
                        <span class="trust-number">5000+</span>
                        <span class="trust-label"><?php esc_html_e( 'Projects Delivered', 'efficient-modern' ); ?></span>
                    </div>
                    <div class="trust-item">
                        <span class="trust-number">1000+</span>
                        <span class="trust-label"><?php esc_html_e( 'Happy Clients', 'efficient-modern' ); ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Featured Product Image -->
            <div class="hero-product wow fadeInRight" data-wow-delay="1s">
                <?php
                // Get random featured product
                $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 1,
                    'orderby'        => 'rand',
                );
                
                $featured_query = new WP_Query( $args );
                
                if ( $featured_query->have_posts() ) :
                    while ( $featured_query->have_posts() ) : $featured_query->the_post();
                        if ( has_post_thumbnail() ) :
                ?>
                    <a href="<?php the_permalink(); ?>" class="hero-product-link">
                        <?php the_post_thumbnail( 'efficient-product', array( 'class' => 'hero-product-image' ) ); ?>
                    </a>
                <?php
                        endif;
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section section-padding">
    <div class="container">
        <div class="about-grid">
            <div class="about-content wow fadeInLeft">
                <div class="section-header">
                    <span class="section-subtitle">
                        <?php 
                        echo function_exists( 'get_field' ) && get_field( 'heading' ) 
                            ? esc_html( get_field( 'heading' ) ) 
                            : esc_html__( 'About Us', 'efficient-modern' ); 
                        ?>
                    </span>
                    <h2 class="section-title">
                        <?php 
                        echo function_exists( 'get_field' ) && get_field( 'sub_heading' ) 
                            ? esc_html( get_field( 'sub_heading' ) ) 
                            : esc_html__( 'Leading Digital Printing Company in Dubai', 'efficient-modern' ); 
                        ?>
                    </h2>
                </div>
                
                <div class="about-text">
                    <?php
                    if ( have_posts() ) :
                        while ( have_posts() ) : the_post();
                            the_content();
                        endwhile;
                    else :
                    ?>
                        <p><?php esc_html_e( 'Welcome to our premier digital printing company in Dubai, where we offer a wide range of printing services tailored to meet the needs of businesses and individuals alike. Whether you need business cards, brochures, banners, or custom printed materials, we have the expertise and technology to deliver high-quality results that exceed your expectations.', 'efficient-modern' ); ?></p>
                        
                        <p><?php esc_html_e( 'Our digital printing company in Dubai prides itself on providing comprehensive printing services in Dubai, UAE. We understand that every project is unique, and we are committed to delivering personalized solutions that cater to your specific requirements. From small-scale printing jobs to large-format projects, we have the capabilities to handle it all.', 'efficient-modern' ); ?></p>
                    <?php endif; ?>
                </div>
                
                <a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>" class="btn btn-primary">
                    <?php esc_html_e( 'Learn More About Us', 'efficient-modern' ); ?>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="about-image wow fadeInRight">
                <?php
                $about_image = function_exists( 'get_field' ) && get_field( 'add_you_tube_video_link' ) 
                    ? get_field( 'add_you_tube_video_link' ) 
                    : 'https://efficientadvt.com/wp-content/uploads/2022/07/Exhibition-Stands-2-1-1.jpg';
                    
                // Check if it's a YouTube link
                if ( strpos( $about_image, 'youtube.com' ) !== false || strpos( $about_image, 'youtu.be' ) !== false ) :
                ?>
                    <div class="video-wrapper">
                        <iframe src="<?php echo esc_url( $about_image ); ?>" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                        </iframe>
                    </div>
                <?php else : ?>
                    <img src="<?php echo esc_url( $about_image ); ?>" alt="<?php esc_attr_e( 'About Efficient Advertising', 'efficient-modern' ); ?>">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section section-padding">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-subtitle">
                <?php 
                echo function_exists( 'get_field' ) && get_field( 'category_heading' ) 
                    ? esc_html( get_field( 'category_heading' ) ) 
                    : esc_html__( 'CATEGORIES', 'efficient-modern' ); 
                ?>
            </span>
            <h2 class="section-title">
                <?php 
                echo function_exists( 'get_field' ) && get_field( 'categories_subheadings' ) 
                    ? esc_html( get_field( 'categories_subheadings' ) ) 
                    : esc_html__( 'Our Products', 'efficient-modern' ); 
                ?>
            </h2>
        </div>
        
        <div class="category-grid">
            <?php
            // First, try to get categories from custom post type (note: original theme has typo "categotries")
            $home_categories = new WP_Query( array(
                'post_type'      => 'home_categotries',
                'posts_per_page' => -1,
            ) );
            
            if ( $home_categories->have_posts() ) :
                $delay = 0.1;
                while ( $home_categories->have_posts() ) : $home_categories->the_post();
                    // Get the category link from ACF
                    $category_link = '';
                    if ( function_exists( 'get_field' ) ) {
                        $category_link = get_field( 'conection' ) ? get_field( 'conection' ) : get_field( 'category_link' );
                    }
                    if ( ! $category_link ) {
                        $category_link = '#';
                    }
                    
                    // Get the featured image
                    $image_url = '';
                    if ( has_post_thumbnail() ) {
                        $image_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                    }
            ?>
                <div class="category-card wow fadeInUp" data-wow-delay="<?php echo esc_attr( $delay ); ?>s">
                    <a href="<?php echo esc_url( $category_link ); ?>" class="category-card-link">
                        <div class="category-image">
                            <?php if ( $image_url ) : ?>
                                <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else : ?>
                                <div style="width: 100%; height: 250px; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                    <span><?php esc_html_e( 'No Image', 'efficient-modern' ); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="category-overlay"></div>
                        </div>
                        <div class="category-content">
                            <h3 class="category-title"><?php the_title(); ?></h3>
                            <span class="category-link-text">
                                <?php esc_html_e( 'View Products', 'efficient-modern' ); ?>
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                </div>
            <?php
                    $delay += 0.1;
                endwhile;
                wp_reset_postdata();
            else :
                // Fallback to WooCommerce product categories
                if ( class_exists( 'WooCommerce' ) ) :
                    $product_categories = get_terms( array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => true,
                        'exclude'    => get_option( 'default_product_cat' ),
                        'number'     => 8,
                    ) );
                    
                    if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) :
                        foreach ( $product_categories as $category ) :
                            $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
                            $image_url = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : get_template_directory_uri() . '/assets/images/placeholder.jpg';
            ?>
                <div class="category-card wow fadeInUp" data-wow-delay="0.1s">
                    <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="category-card-link">
                        <div class="category-image">
                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $category->name ); ?>">
                            <div class="category-overlay"></div>
                        </div>
                        <div class="category-content">
                            <h3 class="category-title"><?php echo esc_html( $category->name ); ?></h3>
                            <span class="category-link-text">
                                <?php esc_html_e( 'View Products', 'efficient-modern' ); ?>
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                </div>
            <?php
                        endforeach;
                    endif;
                endif;
            endif;
            ?>
        </div>
        
        <div class="text-center wow fadeInUp" style="margin-top: 3rem;">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-grid"></i>
                <?php esc_html_e( 'View All Products', 'efficient-modern' ); ?>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="features-section section-padding-sm" style="background: var(--color-bg-light);">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-subtitle"><?php esc_html_e( 'Why Choose Us', 'efficient-modern' ); ?></span>
            <h2 class="section-title"><?php esc_html_e( 'Excellence in Every Print', 'efficient-modern' ); ?></h2>
        </div>
        
        <div class="features-grid">
            <div class="feature-card wow fadeInUp" data-wow-delay="0.1s">
                <div class="feature-icon">
                    <i class="fa-solid fa-award"></i>
                </div>
                <h3 class="feature-title"><?php esc_html_e( 'Premium Quality', 'efficient-modern' ); ?></h3>
                <p class="feature-description">
                    <?php esc_html_e( 'State-of-the-art printing technology ensuring exceptional quality and vibrant colors.', 'efficient-modern' ); ?>
                </p>
            </div>
            
            <div class="feature-card wow fadeInUp" data-wow-delay="0.2s">
                <div class="feature-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <h3 class="feature-title"><?php esc_html_e( 'Fast Turnaround', 'efficient-modern' ); ?></h3>
                <p class="feature-description">
                    <?php esc_html_e( 'Quick delivery times without compromising on quality. Express services available.', 'efficient-modern' ); ?>
                </p>
            </div>
            
            <div class="feature-card wow fadeInUp" data-wow-delay="0.3s">
                <div class="feature-icon">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h3 class="feature-title"><?php esc_html_e( '24/7 Support', 'efficient-modern' ); ?></h3>
                <p class="feature-description">
                    <?php esc_html_e( 'Dedicated customer support team ready to assist you at any time.', 'efficient-modern' ); ?>
                </p>
            </div>
            
            <div class="feature-card wow fadeInUp" data-wow-delay="0.4s">
                <div class="feature-icon">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
                <h3 class="feature-title"><?php esc_html_e( 'Competitive Pricing', 'efficient-modern' ); ?></h3>
                <p class="feature-description">
                    <?php esc_html_e( 'Best prices in Dubai with no hidden costs. Volume discounts available.', 'efficient-modern' ); ?>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title wow fadeInUp">
                <?php esc_html_e( 'Ready to bring your ideas to life?', 'efficient-modern' ); ?>
            </h2>
            <p class="cta-subtitle wow fadeInUp" data-wow-delay="0.2s">
                <?php esc_html_e( 'Get in touch with us today for a free quote and consultation.', 'efficient-modern' ); ?>
            </p>
            <div class="cta-buttons wow fadeInUp" data-wow-delay="0.4s">
                <a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>" class="btn btn-secondary btn-lg">
                    <?php esc_html_e( 'Contact Us Now', 'efficient-modern' ); ?>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
                <?php 
                $whatsapp_number = function_exists( 'of_get_option' ) ? of_get_option( 'whatsapp_number' ) : '+971501234567';
                if ( $whatsapp_number ) : 
                ?>
                    <a href="https://wa.me/<?php echo esc_attr( str_replace( array( '+', ' ', '-' ), '', $whatsapp_number ) ); ?>" 
                       class="btn btn-outline btn-lg" 
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

<?php
get_footer();
