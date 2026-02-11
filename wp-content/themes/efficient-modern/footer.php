<?php
/**
 * The template for displaying the footer
 *
 * @package Efficient_Modern
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

    </main><!-- #primary -->

    <!-- Footer -->
    <footer id="colophon" class="site-footer">
        
        <!-- Main Footer Content -->
        <div class="footer-main">
            <div class="container">
                <div class="footer-grid">
                    
                    <!-- Footer Column 1 - About -->
                    <div class="footer-column footer-about">
                        <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                            <?php dynamic_sidebar( 'footer-1' ); ?>
                        <?php else : ?>
                            <div class="footer-logo">
                                <?php
                                $footer_logo = function_exists( 'of_get_option' ) ? of_get_option( 'footer_logo' ) : '';
                                
                                if ( $footer_logo ) : ?>
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                        <img src="<?php echo esc_url( $footer_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="footer-logo-img">
                                    </a>
                                <?php else : 
                                    // Use transparent footer logo as fallback
                                    $default_logo = get_template_directory_uri() . '/assets/images/logo-footer.png';
                                ?>
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                        <img src="<?php echo esc_url( $default_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="footer-logo-img">
                                    </a>
                                <?php endif; ?>
                            </div>
                            
                            <div class="footer-description">
                                <?php 
                                $about_content = function_exists( 'of_get_option' ) ? of_get_option( 'about_content' ) : '';
                                if ( $about_content ) {
                                    echo wp_kses_post( $about_content );
                                } else {
                                    echo '<p>' . esc_html__( 'Efficient Advertising is Dubai\'s premier printing company, delivering high-quality printing solutions for businesses across the UAE since 2010.', 'efficient-modern' ) . '</p>';
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Footer Column 2 - Quick Links -->
                    <div class="footer-column">
                        <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                            <?php dynamic_sidebar( 'footer-2' ); ?>
                        <?php else : ?>
                            <h4 class="widget-title"><?php esc_html_e( 'Quick Links', 'efficient-modern' ); ?></h4>
                            <?php
                            if ( has_nav_menu( 'footer' ) ) {
                                wp_nav_menu( array(
                                    'theme_location' => 'footer',
                                    'container'      => false,
                                    'menu_class'     => 'footer-menu',
                                    'depth'          => 1,
                                ) );
                            } else {
                                echo '<ul class="footer-menu">';
                                echo '<li><a href="' . esc_url( home_url( '/about-us' ) ) . '">' . esc_html__( 'About Us', 'efficient-modern' ) . '</a></li>';
                                echo '<li><a href="' . esc_url( home_url( '/shop' ) ) . '">' . esc_html__( 'Our Products', 'efficient-modern' ) . '</a></li>';
                                echo '<li><a href="' . esc_url( home_url( '/contact-us' ) ) . '">' . esc_html__( 'Contact', 'efficient-modern' ) . '</a></li>';
                                echo '<li><a href="' . esc_url( home_url( '/privacy-policy' ) ) . '">' . esc_html__( 'Privacy Policy', 'efficient-modern' ) . '</a></li>';
                                echo '</ul>';
                            }
                            ?>
                        <?php endif; ?>
                    </div>

                    <!-- Footer Column 3 - Services/Categories -->
                    <div class="footer-column">
                        <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                            <?php dynamic_sidebar( 'footer-3' ); ?>
                        <?php else : ?>
                            <h4 class="widget-title"><?php esc_html_e( 'Our Services', 'efficient-modern' ); ?></h4>
                            <ul class="footer-services">
                                <?php
                                // Get WooCommerce product categories
                                if ( class_exists( 'WooCommerce' ) ) {
                                    $categories = get_terms( array(
                                        'taxonomy'   => 'product_cat',
                                        'hide_empty' => true,
                                        'number'     => 6,
                                        'exclude'    => get_option( 'default_product_cat' ),
                                    ) );
                                    
                                    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                                        foreach ( $categories as $category ) {
                                            echo '<li><a href="' . esc_url( get_term_link( $category ) ) . '">' . esc_html( $category->name ) . '</a></li>';
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <!-- Footer Column 4 - Contact Info -->
                    <div class="footer-column footer-contact">
                        <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
                            <?php dynamic_sidebar( 'footer-4' ); ?>
                        <?php else : ?>
                            <h4 class="widget-title"><?php esc_html_e( 'Get In Touch', 'efficient-modern' ); ?></h4>
                            
                            <div class="contact-info">
                                <?php 
                                $address = function_exists( 'of_get_option' ) ? of_get_option( 'header_address' ) : 'Warehouse-11, 10C Street, Ras Al Khor Industrial Area 1, Dubai, UAE';
                                $phone = function_exists( 'of_get_option' ) ? of_get_option( 'contact_no' ) : '+971 4 271 1048';
                                $email = function_exists( 'of_get_option' ) ? of_get_option( 'email_address' ) : 'info@efficientadvt.com';
                                ?>
                                
                                <?php if ( $address ) : ?>
                                    <div class="contact-item">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span><?php echo esc_html( $address ); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ( $phone ) : ?>
                                    <div class="contact-item">
                                        <i class="fa-solid fa-phone"></i>
                                        <a href="tel:<?php echo esc_attr( str_replace( ' ', '', $phone ) ); ?>">
                                            <?php echo esc_html( $phone ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ( $email ) : ?>
                                    <div class="contact-item">
                                        <i class="fa-solid fa-envelope"></i>
                                        <a href="mailto:<?php echo esc_attr( $email ); ?>">
                                            <?php echo esc_html( $email ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Social Links -->
                            <div class="footer-social">
                                <?php 
                                $facebook = function_exists( 'of_get_option' ) ? of_get_option( 'facebook_link' ) : '';
                                $twitter = function_exists( 'of_get_option' ) ? of_get_option( 'twitter_link' ) : '';
                                $linkedin = function_exists( 'of_get_option' ) ? of_get_option( 'linkedin_link' ) : '';
                                $instagram = function_exists( 'of_get_option' ) ? of_get_option( 'instagram_link' ) : '';
                                ?>
                                
                                <?php if ( $facebook ) : ?>
                                    <a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener" class="social-facebook" aria-label="Facebook">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ( $twitter ) : ?>
                                    <a href="<?php echo esc_url( $twitter ); ?>" target="_blank" rel="noopener" class="social-twitter" aria-label="Twitter">
                                        <i class="fa-brands fa-twitter"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ( $linkedin ) : ?>
                                    <a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener" class="social-linkedin" aria-label="LinkedIn">
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ( $instagram ) : ?>
                                    <a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener" class="social-instagram" aria-label="Instagram">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                </div><!-- .footer-grid -->
            </div><!-- .container -->
        </div><!-- .footer-main -->

        <!-- Footer Bottom - Copyright -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-inner">
                    <div class="copyright">
                        <p>
                            <?php
                            printf(
                                esc_html__( '&copy; %1$s %2$s. All rights reserved.', 'efficient-modern' ),
                                date( 'Y' ),
                                get_bloginfo( 'name' )
                            );
                            ?>
                        </p>
                    </div>
                    
                    <div class="footer-credits">
                        <?php
                        printf(
                            esc_html__( '%s', 'efficient-modern' ),
                            'Created by <a href="' . esc_url( __( 'https://botr.solutions/', 'efficient-modern' ) ) . '" target="_blank" rel="noopener">BOTR Solutions</a>'
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div><!-- .footer-bottom -->

    </footer><!-- #colophon -->

    <!-- Floating WhatsApp Button -->
    <?php 
    $whatsapp_number = function_exists( 'of_get_option' ) ? of_get_option( 'whatsapp_number' ) : '+971527966265';
    if ( $whatsapp_number ) : 
    ?>
        <a href="https://wa.me/<?php echo esc_attr( str_replace( array( '+', ' ', '-' ), '', $whatsapp_number ) ); ?>?text=<?php echo urlencode( 'Hello! I would like to inquire about your printing services.' ); ?>" 
           class="floating-whatsapp" 
           target="_blank" 
           rel="noopener"
           aria-label="<?php esc_attr_e( 'Chat with us on WhatsApp', 'efficient-modern' ); ?>">
            <i class="fa-brands fa-whatsapp"></i>
        </a>
    <?php endif; ?>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'efficient-modern' ); ?>">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <!-- Request Quote Modal (Global) - Comprehensive Order Form -->
    <div class="modal-overlay" id="requestQuoteModal">
        <div class="modal-container">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-header-content">
                        <h3 class="modal-title" id="requestQuoteModalLabel">
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
                        
                        <form class="order-form" id="globalOrderForm" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                            <input type="hidden" name="action" value="submit_product_order">
                            <?php wp_nonce_field( 'product_order_nonce', 'order_nonce' ); ?>
                            
                            <!-- Personal Information -->
                            <div class="form-section">
                                <h4 class="form-section-title">
                                    <i class="fa-solid fa-user"></i>
                                    <?php esc_html_e( 'Your Information', 'efficient-modern' ); ?>
                                </h4>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="order_name_global">
                                            <?php esc_html_e( 'Full Name', 'efficient-modern' ); ?> *
                                        </label>
                                        <input type="text" class="form-control" id="order_name_global" name="order_name" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="order_email_global">
                                            <?php esc_html_e( 'Email Address', 'efficient-modern' ); ?> *
                                        </label>
                                        <input type="email" class="form-control" id="order_email_global" name="order_email" required>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="order_phone_global">
                                            <?php esc_html_e( 'Phone Number', 'efficient-modern' ); ?> *
                                        </label>
                                        <input type="tel" class="form-control" id="order_phone_global" name="order_phone" required 
                                               placeholder="+971 50 123 4567">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="order_company_global">
                                            <?php esc_html_e( 'Company Name', 'efficient-modern' ); ?>
                                        </label>
                                        <input type="text" class="form-control" id="order_company_global" name="order_company">
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
                                        <label for="order_quantity_global">
                                            <?php esc_html_e( 'Quantity Required', 'efficient-modern' ); ?> *
                                        </label>
                                        <input type="number" class="form-control" id="order_quantity_global" name="order_quantity" 
                                               min="1" value="1" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="order_size_global">
                                            <?php esc_html_e( 'Size/Dimensions', 'efficient-modern' ); ?>
                                        </label>
                                        <input type="text" class="form-control" id="order_size_global" name="order_size" 
                                               placeholder="e.g., A4, 100x50cm, Custom">
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="order_material_global">
                                            <?php esc_html_e( 'Material/Type', 'efficient-modern' ); ?>
                                        </label>
                                        <select class="form-control" id="order_material_global" name="order_material">
                                            <option value=""><?php esc_html_e( 'Select Material', 'efficient-modern' ); ?></option>
                                            <option value="standard"><?php esc_html_e( 'Standard', 'efficient-modern' ); ?></option>
                                            <option value="premium"><?php esc_html_e( 'Premium', 'efficient-modern' ); ?></option>
                                            <option value="custom"><?php esc_html_e( 'Custom (Specify in notes)', 'efficient-modern' ); ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="order_deadline_global">
                                            <?php esc_html_e( 'Required By', 'efficient-modern' ); ?>
                                        </label>
                                        <input type="date" class="form-control" id="order_deadline_global" name="order_deadline" 
                                               min="<?php echo date( 'Y-m-d', strtotime( '+1 day' ) ); ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="order_notes_global">
                                        <?php esc_html_e( 'Additional Requirements / Notes', 'efficient-modern' ); ?>
                                    </label>
                                    <textarea class="form-control" id="order_notes_global" name="order_notes" rows="4" 
                                              placeholder="<?php esc_attr_e( 'Please provide any specific requirements, colors, design specifications, or other details...', 'efficient-modern' ); ?>"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="order_artwork_global">
                                        <i class="fa-solid fa-file-image"></i>
                                        <?php esc_html_e( 'Upload Artwork/Design Files', 'efficient-modern' ); ?>
                                    </label>
                                    <div class="file-upload-wrapper">
                                        <input type="file" class="file-upload-input" id="order_artwork_global" name="order_artwork[]" 
                                               accept="image/*,.pdf,.ai,.eps,.psd,.svg" multiple>
                                        <label for="order_artwork_global" class="file-upload-label">
                                            <i class="fa-solid fa-cloud-arrow-up"></i>
                                            <span class="file-upload-text"><?php esc_html_e( 'Click to upload or drag & drop', 'efficient-modern' ); ?></span>
                                            <span class="file-upload-subtext"><?php esc_html_e( 'JPG, PNG, PDF, AI, EPS, PSD, SVG (Max 10MB each)', 'efficient-modern' ); ?></span>
                                        </label>
                                        <div class="file-upload-preview" id="filePreviewGlobal"></div>
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
                                    <label for="order_delivery_global">
                                        <?php esc_html_e( 'Delivery Option', 'efficient-modern' ); ?> *
                                    </label>
                                    <select class="form-control" id="order_delivery_global" name="order_delivery" required>
                                        <option value="pickup"><?php esc_html_e( 'Pickup from Dubai', 'efficient-modern' ); ?></option>
                                        <option value="delivery_dubai"><?php esc_html_e( 'Delivery within Dubai', 'efficient-modern' ); ?></option>
                                        <option value="delivery_uae"><?php esc_html_e( 'Delivery within UAE', 'efficient-modern' ); ?></option>
                                        <option value="delivery_international"><?php esc_html_e( 'International Delivery', 'efficient-modern' ); ?></option>
                                    </select>
                                </div>
                                
                                <div class="form-group" id="delivery_address_group_global" style="display: none;">
                                    <label for="order_address_global">
                                        <?php esc_html_e( 'Delivery Address', 'efficient-modern' ); ?>
                                    </label>
                                    <textarea class="form-control" id="order_address_global" name="order_address" rows="3" 
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
                                    <a href="https://wa.me/<?php echo esc_attr( str_replace( array( '+', ' ', '-' ), '', $whatsapp ) ); ?>?text=<?php echo urlencode( 'Hi, I\'m interested in getting a quote' ); ?>" 
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

</div><!-- #page -->

<script>
// Pre-fill product information in global quote modal
document.addEventListener('DOMContentLoaded', function() {
    // Store product name when any quote button with product data is clicked
    document.addEventListener('click', function(e) {
        const button = e.target.closest('[data-toggle="modal"]');
        
        if (button) {
            const productName = button.getAttribute('data-product-name');
            
            // Store product name if it exists
            if (productName) {
                sessionStorage.setItem('quote_product_name', productName);
            }
            
            // If opening the global modal, pre-fill the product info
            if (button.getAttribute('data-target') === '#requestQuoteModal') {
                setTimeout(function() {
                    const storedProductName = sessionStorage.getItem('quote_product_name');
                    const notesField = document.getElementById('order_notes_global');
                    
                    if (storedProductName && notesField) {
                        // Pre-fill the additional notes with product information
                        const prefillText = 'Product of Interest: ' + storedProductName + '\n\n';
                        
                        // Only pre-fill if the field is empty
                        if (!notesField.value || notesField.value === '') {
                            notesField.value = prefillText;
                        }
                    }
                }, 100);
            }
        }
    });
    
    // Handle delivery address visibility for global modal
    const deliverySelectGlobal = document.getElementById('order_delivery_global');
    const addressGroupGlobal = document.getElementById('delivery_address_group_global');
    
    if (deliverySelectGlobal && addressGroupGlobal) {
        deliverySelectGlobal.addEventListener('change', function() {
            if (this.value !== 'pickup') {
                addressGroupGlobal.style.display = 'block';
            } else {
                addressGroupGlobal.style.display = 'none';
            }
        });
    }
});
</script>

<?php wp_footer(); ?>

</body>
</html>
