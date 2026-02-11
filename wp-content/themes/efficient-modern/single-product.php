<?php
/**
 * The template for displaying single products
 *
 * @package Efficient_Modern
 * @since 1.0.0
 */

get_header();
?>

<main class="single-product-page">
    <?php while ( have_posts() ) : the_post(); ?>
    
    <!-- Product Detail Section -->
    <section class="product-detail-section">
        <div class="container">
            <div class="product-detail-grid">
                
                <!-- Product Gallery -->
                <div class="product-gallery-wrapper">
                    <div class="product-main-image">
                        <?php 
                        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                        if ( $thumb && isset( $thumb[0] ) ) : 
                        ?>
                            <img id="mainProductImage" src="<?php echo esc_url( $thumb[0] ); ?>" alt="<?php the_title_attribute(); ?>">
                        <?php else : ?>
                            <?php the_post_thumbnail( 'full', array( 'id' => 'mainProductImage' ) ); ?>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Thumbnail Gallery -->
                    <div class="product-thumbnails-grid">
                        <?php
                        // Main image thumbnail
                        if ( $thumb && isset( $thumb[0] ) ) :
                        ?>
                            <div class="thumbnail-item active" data-image="<?php echo esc_url( $thumb[0] ); ?>">
                                <img src="<?php echo esc_url( $thumb[0] ); ?>" alt="<?php the_title_attribute(); ?>">
                            </div>
                        <?php endif; ?>
                        
                        <?php
                        // Additional product images from ACF
                        $product_images = array(
                            'product_image_one',
                            'product_image_two',
                            'product_image_three'
                        );
                        
                        foreach ( $product_images as $image_field ) :
                            $image = function_exists( 'get_field' ) ? get_field( $image_field ) : '';
                            if ( $image ) :
                        ?>
                            <div class="thumbnail-item" data-image="<?php echo esc_url( $image ); ?>">
                                <img src="<?php echo esc_url( $image ); ?>" alt="<?php the_title_attribute(); ?>">
                            </div>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="product-info-wrapper">
                    <!-- Breadcrumb -->
                    <nav class="product-breadcrumb">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Products', 'efficient-modern' ); ?></a>
                        <span>/</span>
                        <?php
                        $terms = get_the_terms( get_the_ID(), 'product_category' );
                        if ( $terms && ! is_wp_error( $terms ) ) :
                            $first_term = array_shift( $terms );
                        ?>
                            <a href="<?php echo esc_url( get_term_link( $first_term ) ); ?>"><?php echo esc_html( $first_term->name ); ?></a>
                        <?php endif; ?>
                    </nav>
                    
                    <!-- Product Tags -->
                    <div class="product-tags-header">
                        <?php if ( function_exists( 'get_field' ) && get_field( 'best_selling' ) ) : ?>
                            <span class="product-tag best-selling"><?php esc_html_e( 'Best Selling', 'efficient-modern' ); ?></span>
                        <?php endif; ?>
                        <?php
                        if ( $terms && ! is_wp_error( $terms ) ) :
                            $first_term = array_shift( $terms );
                        ?>
                            <span class="product-tag-category"><?php echo esc_html( $first_term->name ); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <h1 class="product-title"><?php the_title(); ?></h1>
                    
                    <div class="product-description">
                        <?php the_content(); ?>
                    </div>
                    
                    <!-- Product Options -->
                    <div class="product-options">
                        <?php if ( function_exists( 'get_field' ) && have_rows( 'product_sizes' ) ) : ?>
                            <div class="product-option-group">
                                <h4 class="option-label"><?php esc_html_e( 'Select Size (Height)', 'efficient-modern' ); ?></h4>
                                <div class="option-buttons size-options">
                                    <?php 
                                    $first = true;
                                    while ( have_rows( 'product_sizes' ) ) : the_row(); 
                                        $size = get_sub_field( 'size' );
                                    ?>
                                        <button type="button" class="option-btn <?php echo $first ? 'active' : ''; ?>" data-option="size" data-value="<?php echo esc_attr( $size ); ?>">
                                            <?php echo esc_html( $size ); ?>
                                        </button>
                                    <?php 
                                        $first = false;
                                    endwhile; 
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ( function_exists( 'get_field' ) && have_rows( 'base_materials' ) ) : ?>
                            <div class="product-option-group">
                                <h4 class="option-label"><?php esc_html_e( 'Base Material', 'efficient-modern' ); ?></h4>
                                <div class="option-buttons material-options">
                                    <?php 
                                    $first = true;
                                    while ( have_rows( 'base_materials' ) ) : the_row(); 
                                        $material = get_sub_field( 'material' );
                                    ?>
                                        <button type="button" class="option-btn <?php echo $first ? 'active' : ''; ?>" data-option="material" data-value="<?php echo esc_attr( $material ); ?>">
                                            <?php echo esc_html( $material ); ?>
                                        </button>
                                    <?php 
                                        $first = false;
                                    endwhile; 
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- CTA Buttons -->
                    <div class="product-cta-buttons">
                        <button type="button" class="btn-quote" data-toggle="modal" data-target="#orderModal" data-product-name="<?php echo esc_attr( get_the_title() ); ?>">
                            <i class="fa-solid fa-file-invoice"></i>
                            <?php esc_html_e( 'Request a Quote', 'efficient-modern' ); ?>
                        </button>
                        
                        <?php 
                        $whatsapp_number = function_exists( 'of_get_option' ) ? of_get_option( 'whatsapp_number' ) : '+971527966265';
                        if ( $whatsapp_number ) : 
                        ?>
                            <a href="https://wa.me/<?php echo esc_attr( str_replace( array( '+', ' ', '-' ), '', $whatsapp_number ) ); ?>?text=<?php echo urlencode( 'Hi, I am interested in: ' . get_the_title() ); ?>" 
                               class="btn-whatsapp" 
                               target="_blank" 
                               rel="noopener">
                                <i class="fa-brands fa-whatsapp"></i>
                                <?php esc_html_e( 'WhatsApp Us', 'efficient-modern' ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Product Features -->
                    <div class="product-features-badges">
                        <div class="feature-badge">
                            <i class="fa-solid fa-circle-check"></i>
                            <span><?php esc_html_e( 'In-house Production', 'efficient-modern' ); ?></span>
                        </div>
                        <div class="feature-badge">
                            <i class="fa-solid fa-truck-fast"></i>
                            <span><?php esc_html_e( 'Express Delivery', 'efficient-modern' ); ?></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    
    
    <!-- Product Information Accordion -->
    <section class="product-information-section">
        <div class="container">
            <h2 class="info-section-title"><?php esc_html_e( 'Product Information', 'efficient-modern' ); ?></h2>
            
            <div class="product-accordion">
                <!-- Product Description -->
                <details class="accordion-item" open>
                    <summary class="accordion-header">
                        <span class="accordion-title"><?php esc_html_e( 'Product Description', 'efficient-modern' ); ?></span>
                        <i class="fa-solid fa-chevron-down accordion-icon"></i>
                    </summary>
                    <div class="accordion-content">
                        <?php if ( function_exists( 'get_field' ) && get_field( 'product_description' ) ) : ?>
                            <?php the_field( 'product_description' ); ?>
                        <?php else : ?>
                            <p><?php esc_html_e( 'Efficient Advertising LLC is one of the best, professional, and reliable printing and advertising company in Dubai, UAE. We offer high-quality printing services at competitive prices. Our team consists of experienced and skilled staff in all aspects of printing. We ensure the best custom printing solution according to your company\'s needs.', 'efficient-modern' ); ?></p>
                        <?php endif; ?>
                    </div>
                </details>
                
                <!-- Technical Details -->
                <details class="accordion-item">
                    <summary class="accordion-header">
                        <span class="accordion-title"><?php esc_html_e( 'Technical Details', 'efficient-modern' ); ?></span>
                        <i class="fa-solid fa-chevron-down accordion-icon"></i>
                    </summary>
                    <div class="accordion-content">
                        <?php if ( function_exists( 'get_field' ) && get_field( 'product_features' ) ) : ?>
                            <?php the_field( 'product_features' ); ?>
                        <?php else : ?>
                            <ul>
                                <li><strong><?php esc_html_e( 'Material:', 'efficient-modern' ); ?></strong> <?php esc_html_e( '110g Knitted Polyester Fabric', 'efficient-modern' ); ?></li>
                                <li><strong><?php esc_html_e( 'Print:', 'efficient-modern' ); ?></strong> <?php esc_html_e( 'Dye sublimation for long-lasting color', 'efficient-modern' ); ?></li>
                                <li><strong><?php esc_html_e( 'Finishing:', 'efficient-modern' ); ?></strong> <?php esc_html_e( 'Double stitched for extra durability', 'efficient-modern' ); ?></li>
                                <li><strong><?php esc_html_e( 'Pole:', 'efficient-modern' ); ?></strong> <?php esc_html_e( 'Lightweight flexible fiberglass/aluminum poles', 'efficient-modern' ); ?></li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </details>
                
                <!-- Ordering Process -->
                <details class="accordion-item">
                    <summary class="accordion-header">
                        <span class="accordion-title"><?php esc_html_e( 'Ordering Process', 'efficient-modern' ); ?></span>
                        <i class="fa-solid fa-chevron-down accordion-icon"></i>
                    </summary>
                    <div class="accordion-content">
                        <?php if ( function_exists( 'get_field' ) && get_field( 'ordering_process' ) ) : ?>
                            <?php the_field( 'ordering_process' ); ?>
                        <?php else : ?>
                            <ol>
                                <li><strong><?php esc_html_e( 'Inquiry:', 'efficient-modern' ); ?></strong> <?php esc_html_e( 'Request a quote via our website or WhatsApp.', 'efficient-modern' ); ?></li>
                                <li><strong><?php esc_html_e( 'Design Approval:', 'efficient-modern' ); ?></strong> <?php esc_html_e( 'Send your artwork or let our team design it for you.', 'efficient-modern' ); ?></li>
                                <li><strong><?php esc_html_e( 'Sampling:', 'efficient-modern' ); ?></strong> <?php esc_html_e( 'Digital mockup provided for final confirmation.', 'efficient-modern' ); ?></li>
                                <li><strong><?php esc_html_e( 'Production:', 'efficient-modern' ); ?></strong> <?php esc_html_e( 'Fast in-house manufacturing in our Dubai facility.', 'efficient-modern' ); ?></li>
                                <li><strong><?php esc_html_e( 'Delivery:', 'efficient-modern' ); ?></strong> <?php esc_html_e( 'Express shipping across the UAE.', 'efficient-modern' ); ?></li>
                            </ol>
                        <?php endif; ?>
                    </div>
                </details>
            </div>
        </div>
    </section>
    
    <?php endwhile; ?>

<!-- Recommended Products -->
<section class="recommended-products-section">
    <div class="container">
        <div class="section-header-center">
            <h2 class="recommended-title"><?php esc_html_e( 'Recommended Products', 'efficient-modern' ); ?></h2>
            <div class="title-underline"></div>
        </div>
        
        <div class="recommended-products-grid">
            <?php
            // Get related products from same category
            $custom_taxterms = wp_get_object_terms( get_the_ID(), 'product_category', array( 'fields' => 'ids' ) );
            
            $args = array(
                'post_type'      => 'product',
                'post_status'    => 'publish',
                'posts_per_page' => 4,
                'orderby'        => 'rand',
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'product_category',
                        'field'    => 'id',
                        'terms'    => $custom_taxterms
                    )
                ),
                'post__not_in'   => array( get_the_ID() ),
            );
            
            $related_query = new WP_Query( $args );
            
            if ( $related_query->have_posts() ) :
                while ( $related_query->have_posts() ) : $related_query->the_post();
            ?>
                <div class="recommended-product-card">
                    <a href="<?php the_permalink(); ?>" class="recommended-product-link">
                        <div class="recommended-product-image">
                            <?php 
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'large' );
                            } else {
                                echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/placeholder.jpg' ) . '" alt="' . get_the_title() . '">';
                            }
                            ?>
                        </div>
                        <h3 class="recommended-product-name"><?php the_title(); ?></h3>
                    </a>
                </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <p><?php esc_html_e( 'No related products found.', 'efficient-modern' ); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="product-cta-section">
    <div class="container">
        <div class="cta-content-wrapper">
            <div class="cta-background-overlay"></div>
            <div class="cta-content">
                <h2 class="cta-title"><?php esc_html_e( "Can't find what you're looking for?", 'efficient-modern' ); ?></h2>
                <p class="cta-description"><?php esc_html_e( 'Our Dubai-based facility handles custom requirements of all scales. Get in touch with our experts for a personalized consultation.', 'efficient-modern' ); ?></p>
                <div class="cta-buttons-wrapper">
                    <button type="button" class="cta-btn-primary" data-toggle="modal" data-target="#orderModal" data-product-name="<?php echo esc_attr( get_the_title() ); ?>">
                        <i class="fa-solid fa-envelope"></i>
                        <?php esc_html_e( 'Request Custom Quote', 'efficient-modern' ); ?>
                    </button>
                    <?php 
                    $phone_number = function_exists( 'of_get_option' ) ? of_get_option( 'phone_number' ) : '+971527966265';
                    if ( $phone_number ) : 
                    ?>
                        <a href="tel:<?php echo esc_attr( str_replace( array( ' ', '-' ), '', $phone_number ) ); ?>" class="cta-btn-secondary">
                            <i class="fa-solid fa-phone"></i>
                            <?php printf( esc_html__( 'Call %s', 'efficient-modern' ), $phone_number ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

<!-- JavaScript for Product Gallery & Options -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image Gallery Functionality
    const thumbnails = document.querySelectorAll('.thumbnail-item');
    const mainImage = document.getElementById('mainProductImage');
    
    thumbnails.forEach(function(thumb) {
        thumb.addEventListener('click', function() {
            // Remove active class from all thumbnails
            thumbnails.forEach(t => t.classList.remove('active'));
            // Add active class to clicked thumbnail
            this.classList.add('active');
            // Change main image
            const newImage = this.getAttribute('data-image');
            if (mainImage && newImage) {
                mainImage.src = newImage;
            }
        });
    });
    
    // Product Options Functionality
    const optionButtons = document.querySelectorAll('.option-btn');
    
    optionButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const optionType = this.getAttribute('data-option');
            // Remove active from same type
            document.querySelectorAll(`[data-option="${optionType}"]`).forEach(b => b.classList.remove('active'));
            // Add active to clicked
            this.classList.add('active');
        });
    });
    
    // Accordion Functionality
    const accordionItems = document.querySelectorAll('.accordion-item');
    
    accordionItems.forEach(function(item) {
        const summary = item.querySelector('.accordion-header');
        summary.addEventListener('click', function() {
            // Toggle open attribute
            if (item.hasAttribute('open')) {
                setTimeout(() => item.removeAttribute('open'), 0);
            }
        });
    });
});
</script>

<!-- Product Order Modal (Product-Specific with all fields) -->
<div class="modal-overlay" id="orderModal">
    <div class="modal-container">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-content">
                    <h3 class="modal-title" id="orderModalLabel">
                        <i class="fa-solid fa-file-signature"></i>
                        <?php esc_html_e( 'Get a Free Quote', 'efficient-modern' ); ?>
                    </h3>
                    <p class="modal-subtitle"><?php esc_html_e( 'Fill out the form below and we will get back to you shortly.', 'efficient-modern' ); ?></p>
                </div>
                <button type="button" class="modal-close" data-modal-close aria-label="Close">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <?php 
                // Use our custom modern order form
                ?>
                    <div class="order-form-notice">
                        <i class="fa-solid fa-info-circle"></i>
                        <?php esc_html_e( 'Fill in your details and we\'ll get back to you with a quote within 24 hours.', 'efficient-modern' ); ?>
                    </div>
                    
                    <form class="order-form" id="productOrderForm" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                        <input type="hidden" name="action" value="submit_product_order">
                        <input type="hidden" name="product_id" value="<?php echo get_the_ID(); ?>">
                        <input type="hidden" name="product_name" value="<?php echo esc_attr( get_the_title() ); ?>">
                        <?php wp_nonce_field( 'product_order_nonce', 'order_nonce' ); ?>
                        
                        <!-- Personal Information -->
                        <div class="form-section">
                            <h4 class="form-section-title">
                                <i class="fa-solid fa-user"></i>
                                <?php esc_html_e( 'Your Information', 'efficient-modern' ); ?>
                            </h4>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="order_name">
                                        <?php esc_html_e( 'Full Name', 'efficient-modern' ); ?> *
                                    </label>
                                    <input type="text" class="form-control" id="order_name" name="order_name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="order_email">
                                        <?php esc_html_e( 'Email Address', 'efficient-modern' ); ?> *
                                    </label>
                                    <input type="email" class="form-control" id="order_email" name="order_email" required>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="order_phone">
                                        <?php esc_html_e( 'Phone Number', 'efficient-modern' ); ?> *
                                    </label>
                                    <input type="tel" class="form-control" id="order_phone" name="order_phone" required 
                                           placeholder="+971 50 123 4567">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="order_company">
                                        <?php esc_html_e( 'Company Name', 'efficient-modern' ); ?>
                                    </label>
                                    <input type="text" class="form-control" id="order_company" name="order_company">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order Details -->
                        <div class="form-section">
                            <h4 class="form-section-title">
                                <i class="fa-solid fa-box"></i>
                                <?php esc_html_e( 'Order Details', 'efficient-modern' ); ?>
                            </h4>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="order_quantity">
                                        <?php esc_html_e( 'Quantity Required', 'efficient-modern' ); ?> *
                                    </label>
                                    <input type="number" class="form-control" id="order_quantity" name="order_quantity" 
                                           min="1" value="1" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="order_size">
                                        <?php esc_html_e( 'Size/Dimensions', 'efficient-modern' ); ?>
                                    </label>
                                    <input type="text" class="form-control" id="order_size" name="order_size" 
                                           placeholder="e.g., A4, 100x50cm, Custom">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="order_material">
                                        <?php esc_html_e( 'Material/Type', 'efficient-modern' ); ?>
                                    </label>
                                    <select class="form-control" id="order_material" name="order_material">
                                        <option value=""><?php esc_html_e( 'Select Material', 'efficient-modern' ); ?></option>
                                        <option value="standard"><?php esc_html_e( 'Standard', 'efficient-modern' ); ?></option>
                                        <option value="premium"><?php esc_html_e( 'Premium', 'efficient-modern' ); ?></option>
                                        <option value="custom"><?php esc_html_e( 'Custom (Specify in notes)', 'efficient-modern' ); ?></option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="order_deadline">
                                        <?php esc_html_e( 'Required By', 'efficient-modern' ); ?>
                                    </label>
                                    <input type="date" class="form-control" id="order_deadline" name="order_deadline" 
                                           min="<?php echo date( 'Y-m-d', strtotime( '+1 day' ) ); ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="order_notes">
                                    <?php esc_html_e( 'Additional Requirements / Notes', 'efficient-modern' ); ?>
                                </label>
                                <textarea class="form-control" id="order_notes" name="order_notes" rows="4" 
                                          placeholder="<?php esc_attr_e( 'Please provide any specific requirements, colors, design specifications, or other details...', 'efficient-modern' ); ?>"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="order_artwork">
                                    <i class="fa-solid fa-file-image"></i>
                                    <?php esc_html_e( 'Upload Artwork/Design Files', 'efficient-modern' ); ?>
                                </label>
                                <div class="file-upload-wrapper">
                                    <input type="file" class="file-upload-input" id="order_artwork" name="order_artwork[]" 
                                           accept="image/*,.pdf,.ai,.eps,.psd,.svg" multiple>
                                    <label for="order_artwork" class="file-upload-label">
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                        <span class="file-upload-text"><?php esc_html_e( 'Click to upload or drag & drop', 'efficient-modern' ); ?></span>
                                        <span class="file-upload-subtext"><?php esc_html_e( 'JPG, PNG, PDF, AI, EPS, PSD, SVG (Max 10MB each)', 'efficient-modern' ); ?></span>
                                    </label>
                                    <div class="file-upload-preview" id="filePreview"></div>
                                </div>
                                <p class="form-help-text">
                                    <i class="fa-solid fa-info-circle"></i>
                                    <?php esc_html_e( 'Upload your design files, logos, or reference images. Multiple files allowed.', 'efficient-modern' ); ?>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Delivery Information -->
                        <div class="form-section">
                            <h4 class="form-section-title">
                                <i class="fa-solid fa-truck"></i>
                                <?php esc_html_e( 'Delivery Information', 'efficient-modern' ); ?>
                            </h4>
                            
                            <div class="form-group">
                                <label for="order_delivery">
                                    <?php esc_html_e( 'Delivery Option', 'efficient-modern' ); ?> *
                                </label>
                                <select class="form-control" id="order_delivery" name="order_delivery" required>
                                    <option value="pickup"><?php esc_html_e( 'Pickup from Dubai', 'efficient-modern' ); ?></option>
                                    <option value="delivery_dubai"><?php esc_html_e( 'Delivery within Dubai', 'efficient-modern' ); ?></option>
                                    <option value="delivery_uae"><?php esc_html_e( 'Delivery within UAE', 'efficient-modern' ); ?></option>
                                    <option value="delivery_international"><?php esc_html_e( 'International Delivery', 'efficient-modern' ); ?></option>
                                </select>
                            </div>
                            
                            <div class="form-group" id="delivery_address_group" style="display: none;">
                                <label for="order_address">
                                    <?php esc_html_e( 'Delivery Address', 'efficient-modern' ); ?>
                                </label>
                                <textarea class="form-control" id="order_address" name="order_address" rows="3" 
                                          placeholder="<?php esc_attr_e( 'Full delivery address...', 'efficient-modern' ); ?>"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                <i class="fa-solid fa-paper-plane"></i>
                                <?php esc_html_e( 'Submit Quote Request', 'efficient-modern' ); ?>
                            </button>
                            <p class="form-help-text text-center">
                                <?php esc_html_e( 'Our team will review your request and respond within 24 hours', 'efficient-modern' ); ?>
                            </p>
                        </div>
                    </form>
                    
                    <!-- Alternative Contact Options -->
                    <div class="modal-footer-alt">
                        <p class="text-center">
                            <strong><?php esc_html_e( 'Prefer to order by phone or WhatsApp?', 'efficient-modern' ); ?></strong>
                        </p>
                        <div class="alt-contact-options">
                            <?php 
                            $phone = function_exists( 'of_get_option' ) ? of_get_option( 'contact_no' ) : '';
                            $whatsapp = function_exists( 'of_get_option' ) ? of_get_option( 'whatsapp_no' ) : '';
                            if ( $phone ) :
                            ?>
                                <a href="tel:<?php echo esc_attr( str_replace( array( ' ', '-', '+' ), '', $phone ) ); ?>" class="btn btn-outline">
                                    <i class="fa-solid fa-phone"></i>
                                    <?php echo esc_html( $phone ); ?>
                                </a>
                            <?php endif; ?>
                            <?php if ( $whatsapp ) : ?>
                                <a href="https://wa.me/<?php echo esc_attr( str_replace( array( '+', ' ', '-' ), '', $whatsapp ) ); ?>?text=<?php echo urlencode( 'Hi, I\'m interested in: ' . get_the_title() ); ?>" 
                                   class="btn btn-success" target="_blank">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <?php esc_html_e( 'WhatsApp Us', 'efficient-modern' ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<script>
// File upload display
jQuery(document).ready(function($) {
    $('#quote_file').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $('#fileName').text(fileName || 'No file chosen');
    });
});
</script>

<style>
/* Product Detail Styles */
.product-detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--spacing-4xl);
    margin-bottom: var(--spacing-4xl);
}

.product-gallery {
    position: sticky;
    top: 120px;
    height: fit-content;
}

.main-product-image {
    background: var(--color-bg-light);
    border-radius: var(--radius-xl);
    padding: var(--spacing-xl);
    margin-bottom: var(--spacing-lg);
    overflow: hidden;
}

.main-product-image img {
    width: 100%;
    height: auto;
    border-radius: var(--radius-lg);
}

.product-thumbnails {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: var(--spacing-md);
    margin-bottom: var(--spacing-xl);
}

.thumbnail-item {
    cursor: pointer;
    border: 2px solid var(--color-border);
    border-radius: var(--radius-md);
    padding: var(--spacing-xs);
    transition: all var(--transition-base);
    overflow: hidden;
}

.thumbnail-item:hover,
.thumbnail-item.active {
    border-color: var(--color-primary);
}

.thumbnail-item img {
    width: 100%;
    height: auto;
    border-radius: var(--radius-sm);
}

.product-title {
    font-size: var(--font-size-4xl);
    margin-bottom: var(--spacing-md);
}

.product-categories {
    display: flex;
    flex-wrap: wrap;
    gap: var(--spacing-sm);
    margin-bottom: var(--spacing-xl);
}

.category-badge {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: var(--color-bg-light);
    color: var(--color-primary);
    font-size: var(--font-size-sm);
    font-weight: 600;
    border-radius: var(--radius-full);
    transition: all var(--transition-base);
}

.category-badge:hover {
    background: var(--color-primary);
    color: var(--color-bg-white);
}

.product-content {
    font-size: var(--font-size-lg);
    line-height: 1.8;
    color: var(--color-text-light);
    margin-bottom: var(--spacing-2xl);
}

.product-features {
    background: var(--color-bg-light);
    padding: var(--spacing-xl);
    border-radius: var(--radius-xl);
    margin-bottom: var(--spacing-2xl);
}

.product-features h3 {
    font-size: var(--font-size-2xl);
    margin-bottom: var(--spacing-md);
}

.product-actions {
    display: flex;
    gap: var(--spacing-md);
    flex-wrap: wrap;
}

.product-actions .btn {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-sm);
}

/* Product Grid for Related Products */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: var(--spacing-xl);
}

.product-card {
    background: var(--color-bg-white);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: all var(--transition-base);
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.product-card-link {
    display: block;
    text-decoration: none;
    color: inherit;
}

.product-image {
    position: relative;
    padding-top: 100%;
    overflow: hidden;
    background: var(--color-bg-gray);
}

.product-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-slow);
}

.product-card:hover .product-image img {
    transform: scale(1.1);
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(139, 21, 56, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity var(--transition-base);
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.view-product {
    color: var(--color-bg-white);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.product-content {
    padding: var(--spacing-lg);
}

.product-name {
    font-size: var(--font-size-lg);
    font-weight: 600;
    margin: 0;
    transition: color var(--transition-base);
}

.product-card:hover .product-name {
    color: var(--color-primary);
}

/* Modal Styles */
.modal-content {
    border-radius: var(--radius-xl);
}

.modal-header {
    background: var(--color-primary);
    color: var(--color-bg-white);
    border-radius: var(--radius-xl) var(--radius-xl) 0 0;
    padding: var(--spacing-xl);
}

.modal-header .close {
    color: var(--color-bg-white);
    opacity: 1;
}

.modal-body {
    padding: var(--spacing-2xl);
}

@media (max-width: 992px) {
    .product-detail-grid {
        grid-template-columns: 1fr;
        gap: var(--spacing-2xl);
    }
    
    .product-gallery {
        position: relative;
        top: 0;
    }
}

@media (max-width: 768px) {
    .product-actions {
        flex-direction: column;
    }
    
    .product-actions .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Thumbnail click handler
    $('.thumbnail-item').on('click', function() {
        $('.thumbnail-item').removeClass('active');
        $(this).addClass('active');
        
        const newSrc = $(this).find('img').attr('src');
        $('.main-product-image img').fadeOut(200, function() {
            $(this).attr('src', newSrc).fadeIn(200);
        });
    });
});
</script>

<?php
get_footer();
