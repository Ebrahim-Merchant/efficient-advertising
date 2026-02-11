<?php
/**
 * The main template file - Homepage (M Print House Style)
 *
 * Template Name: Home
 *
 * @package Efficient_Modern
 * @since 1.0.0
 */

get_header();
?>

<!-- Hero Section with CTA -->
<section class="hero-mpstyle">
    <div class="container">
        <div class="hero-content-mp">
            <h1 class="hero-main-title wow fadeInUp">
                YOUR <span class="highlight-gradient">PRINTING PARTNER</span><br>
                SINCE 2010 IN UAE
            </h1>
            <p class="hero-main-subtitle wow fadeInUp" data-wow-delay="0.2s">
                We deliver 300+ custom printing products at the best prices in Dubai
            </p>
            <div class="hero-ctas wow fadeInUp" data-wow-delay="0.4s">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" class="btn-hero btn-hero-primary">
                    Browse Products <i class="fas fa-arrow-right"></i>
                </a>
                <a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>" class="btn-hero btn-hero-secondary">
                    Get a Quote
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Trust Badges Bar -->
<section class="trust-bar">
    <div class="container">
        <div class="trust-items-row">
            <div class="trust-badge wow fadeIn" data-wow-delay="0.1s">
                <div class="trust-icon">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div class="trust-text">
                    <strong>In-House Production Team</strong>
                </div>
            </div>
            <div class="trust-badge wow fadeIn" data-wow-delay="0.2s">
                <div class="trust-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="trust-text">
                    <strong>Discounts on Bulk Orders</strong>
                </div>
            </div>
            <div class="trust-badge wow fadeIn" data-wow-delay="0.3s">
                <div class="trust-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="trust-text">
                    <strong>Flexible Venue Delivery</strong>
                </div>
            </div>
            <div class="trust-badge wow fadeIn" data-wow-delay="0.4s">
                <div class="trust-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="trust-text">
                    <strong>4.8 ⭐ Trusted Reviews</strong>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Bouquet of Services -->
<section class="services-bouquet section-padding">
    <div class="container">
        <div class="section-header-center wow fadeInUp">
            <h2 class="section-title-large">Our Bouquet Of Services</h2>
        </div>
        
        <div class="services-grid-8">
            <?php
            // Get product categories
            $categories = get_terms( array(
                'taxonomy'   => 'product_category',
                'hide_empty' => true,
                'number'     => 8,
            ) );
            
            if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
                $delay = 0.1;
                foreach ( $categories as $category ) :
                    // Count products in category
                    $count = $category->count;
                    
                    // Get category image
                    $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
                    $image_url = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : '';
            ?>
                <div class="service-card-mp wow fadeInUp" data-wow-delay="<?php echo esc_attr( $delay ); ?>s">
                    <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="service-card-link">
                        <?php if ( $image_url ) : ?>
                            <div class="service-icon-img">
                                <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $category->name ); ?>">
                            </div>
                        <?php else : ?>
                            <div class="service-icon-default">
                                <i class="fas fa-print"></i>
                            </div>
                        <?php endif; ?>
                        <h3 class="service-title"><?php echo esc_html( strtoupper( $category->name ) ); ?></h3>
                        <p class="service-count">(<?php echo esc_html( $count ); ?> Products)</p>
                        <span class="service-shop-btn">Shop Now</span>
                    </a>
                </div>
            <?php
                    $delay += 0.1;
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="featured-products section-padding" style="background: #f8f9fa;">
    <div class="container">
        <div class="section-header-center wow fadeInUp">
            <h2 class="section-title-large">Featured Products</h2>
            <p class="section-subtitle">Check out our most popular printing solutions</p>
        </div>
        
        <div class="products-grid-4">
            <?php
            $featured_args = array(
                'post_type'      => 'product',
                'posts_per_page' => 8,
                'orderby'        => 'rand',
            );
            $featured_products = new WP_Query( $featured_args );
            
            if ( $featured_products->have_posts() ) :
                $delay = 0.1;
                while ( $featured_products->have_posts() ) : $featured_products->the_post();
            ?>
                <div class="product-card-mp wow fadeInUp" data-wow-delay="<?php echo esc_attr( $delay ); ?>s">
                    <a href="<?php the_permalink(); ?>" class="product-card-link">
                        <div class="product-image-wrapper">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium', array( 'class' => 'product-img' ) ); ?>
                            <?php else : ?>
                                <div class="product-placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="product-content-mp">
                            <h3 class="product-title-mp"><?php the_title(); ?></h3>
                            <div class="product-action">
                                <span class="view-details-btn">View Details <i class="fas fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
                    $delay += 0.05;
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
        
        <div class="text-center" style="margin-top: 3rem;">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" class="btn-hero btn-hero-primary btn-lg">
                View All Products
            </a>
        </div>
    </div>
</section>

<!-- Our Order Process -->
<section class="order-process section-padding">
    <div class="container">
        <div class="section-header-center wow fadeInUp">
            <h2 class="section-title-large">Our Order Process</h2>
            <p class="section-subtitle">Simple steps from inquiry to delivery</p>
        </div>
        
        <div class="process-steps">
            <div class="process-step wow fadeInUp" data-wow-delay="0.1s">
                <div class="step-number">1</div>
                <div class="step-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3 class="step-title">Inquiry</h3>
                <p class="step-description">Share your requirements with us to get started.</p>
            </div>
            
            <div class="process-step wow fadeInUp" data-wow-delay="0.2s">
                <div class="step-number">2</div>
                <div class="step-icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <h3 class="step-title">Quotation</h3>
                <p class="step-description">Receive and approve a tailored quotation.</p>
            </div>
            
            <div class="process-step wow fadeInUp" data-wow-delay="0.3s">
                <div class="step-number">3</div>
                <div class="step-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <h3 class="step-title">Payment</h3>
                <p class="step-description">Confirm your order securely with payment.</p>
            </div>
            
            <div class="process-step wow fadeInUp" data-wow-delay="0.4s">
                <div class="step-number">4</div>
                <div class="step-icon">
                    <i class="fas fa-palette"></i>
                </div>
                <h3 class="step-title">Mock-Up</h3>
                <p class="step-description">Review and approve your design mock-up.</p>
            </div>
            
            <div class="process-step wow fadeInUp" data-wow-delay="0.5s">
                <div class="step-number">5</div>
                <div class="step-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <h3 class="step-title">Production</h3>
                <p class="step-description">Your order is crafted with care and precision.</p>
            </div>
            
            <div class="process-step wow fadeInUp" data-wow-delay="0.6s">
                <div class="step-number">6</div>
                <div class="step-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h3 class="step-title">Delivery</h3>
                <p class="step-description">Receive your order by delivery or collect in person.</p>
            </div>
        </div>
    </div>
</section>

<!-- Client Logos -->
<section class="clients-section section-padding" style="background: #f8f9fa;">
    <div class="container">
        <div class="section-header-center wow fadeInUp">
            <h2 class="section-title-large">Businesses That Trust Us!</h2>
            <p class="section-subtitle">Join the league of satisfied customers</p>
        </div>
        
        <div class="clients-notice wow fadeInUp" data-wow-delay="0.2s">
            <p style="text-align: center; color: #666; font-size: 1.1rem;">
                <i class="fas fa-users"></i> Over 1000+ businesses across UAE trust us for their printing needs
            </p>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section section-padding">
    <div class="container">
        <div class="section-header-center wow fadeInUp">
            <h2 class="section-title-large">Frequently Asked Questions (FAQs)</h2>
            <p class="section-subtitle">Find answers to common queries</p>
        </div>
        
        <div class="faq-wrapper">
            <div class="faq-item wow fadeInUp" data-wow-delay="0.1s">
                <button class="faq-question">
                    <span>What printing and branding services do you offer?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>We offer over 300+ custom printing and branding solutions including signage, vehicle branding, packaging, event & exhibition displays, promotional items, business cards, brochures, banners, and more — all at competitive prices.</p>
                </div>
            </div>
            
            <div class="faq-item wow fadeInUp" data-wow-delay="0.2s">
                <button class="faq-question">
                    <span>Do you provide design assistance for printing projects?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Yes! Our in-house design team can help you create stunning designs for your printing projects. We'll work with you to understand your vision and create designs that align with your brand.</p>
                </div>
            </div>
            
            <div class="faq-item wow fadeInUp" data-wow-delay="0.3s">
                <button class="faq-question">
                    <span>Can you handle urgent or same-day printing orders?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Absolutely! We understand that sometimes you need things fast. Contact us to discuss your urgent requirements, and we'll do our best to accommodate your timeline.</p>
                </div>
            </div>
            
            <div class="faq-item wow fadeInUp" data-wow-delay="0.4s">
                <button class="faq-question">
                    <span>Do you offer delivery across UAE?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Yes, we provide flexible delivery options across all of UAE. We can deliver to your office, event venue, or any specified location in Dubai, Abu Dhabi, Sharjah, and other emirates.</p>
                </div>
            </div>
            
            <div class="faq-item wow fadeInUp" data-wow-delay="0.5s">
                <button class="faq-question">
                    <span>What file formats do you accept for printing?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>We accept various file formats including PDF, AI, EPS, PSD, JPG, and PNG. For best results, we recommend vector formats (AI, EPS) for logos and high-resolution PDFs for print-ready files.</p>
                </div>
            </div>
        </div>
        
        <div class="text-center wow fadeInUp" style="margin-top: 3rem;" data-wow-delay="0.6s">
            <?php 
            $whatsapp_number = '+971501234567'; // Replace with your actual number
            ?>
            <a href="https://wa.me/<?php echo esc_attr( str_replace( array( '+', ' ', '-' ), '', $whatsapp_number ) ); ?>?text=Hello%2C%20I%20have%20a%20question" 
               class="btn-hero btn-hero-primary" 
               target="_blank">
                <i class="fab fa-whatsapp"></i> Any Other Query - WhatsApp Now
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-final" style="background: linear-gradient(135deg, #8B1538 0%, #6a1028 100%); color: white;">
    <div class="container">
        <div class="cta-content-final text-center">
            <h2 class="cta-title-final wow fadeInUp">Ready to bring your ideas to life?</h2>
            <p class="cta-subtitle-final wow fadeInUp" data-wow-delay="0.2s">
                Get in touch with us today for a free quote and consultation
            </p>
            <div class="cta-buttons-final wow fadeInUp" data-wow-delay="0.4s">
                <a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>" class="btn-cta-white">
                    Contact Us Now <i class="fas fa-arrow-right"></i>
                </a>
                <a href="tel:+971501234567" class="btn-cta-outline">
                    <i class="fas fa-phone"></i> Call Us: +971 50 123 4567
                </a>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
