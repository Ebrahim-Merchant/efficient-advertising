<?php
/**
 * Template Name: Contact Us Page
 * 
 * @package Efficient_Modern
 * @since 1.0.0
 */

get_header();
?>

<main class="contact-page">
    <?php while ( have_posts() ) : the_post(); ?>
    
    <!-- Contact Hero Section -->
    <section class="contact-hero-section">
        <div class="container">
            <div class="contact-hero-content">
                <span class="contact-hero-label">
                    <?php esc_html_e( 'Get in Touch', 'efficient-modern' ); ?>
                </span>
                <h1 class="contact-hero-title">
                    Let's Bring Your <span class="serif-text">Vision</span> to Life
                </h1>
                <p class="contact-hero-description">
                    <?php esc_html_e( 'Whether you need a quote, have questions about our services, or want to discuss a custom project, our team is here to help. Reach out today and experience the Efficient Advertising difference.', 'efficient-modern' ); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Content Section -->
    <section class="contact-content-section">
        <div class="container">
            <div class="contact-grid">
                
                <!-- Contact Form -->
                <div class="contact-form-wrapper">
                    <h2 class="contact-form-title"><?php esc_html_e( 'Send Us a Message', 'efficient-modern' ); ?></h2>
                    
                    <form class="contact-form" id="contactForm" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                        <input type="hidden" name="action" value="submit_contact_form">
                        <?php wp_nonce_field( 'contact_form_nonce', 'contact_nonce' ); ?>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact_name">
                                    <?php esc_html_e( 'Full Name', 'efficient-modern' ); ?> *
                                </label>
                                <input type="text" class="form-control" id="contact_name" name="contact_name" required>
                            </div>
                            <div class="form-group">
                                <label for="contact_email">
                                    <?php esc_html_e( 'Email Address', 'efficient-modern' ); ?> *
                                </label>
                                <input type="email" class="form-control" id="contact_email" name="contact_email" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact_phone">
                                    <?php esc_html_e( 'Phone Number', 'efficient-modern' ); ?>
                                </label>
                                <input type="tel" class="form-control" id="contact_phone" name="contact_phone" placeholder="+971 50 123 4567">
                            </div>
                            <div class="form-group">
                                <label for="contact_company">
                                    <?php esc_html_e( 'Company Name', 'efficient-modern' ); ?>
                                </label>
                                <input type="text" class="form-control" id="contact_company" name="contact_company">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="contact_subject">
                                <?php esc_html_e( 'Subject', 'efficient-modern' ); ?> *
                            </label>
                            <select class="form-control" id="contact_subject" name="contact_subject" required>
                                <option value=""><?php esc_html_e( 'Select a topic...', 'efficient-modern' ); ?></option>
                                <option value="quote"><?php esc_html_e( 'Request a Quote', 'efficient-modern' ); ?></option>
                                <option value="services"><?php esc_html_e( 'General Services Inquiry', 'efficient-modern' ); ?></option>
                                <option value="support"><?php esc_html_e( 'Customer Support', 'efficient-modern' ); ?></option>
                                <option value="partnership"><?php esc_html_e( 'Partnership Opportunities', 'efficient-modern' ); ?></option>
                                <option value="other"><?php esc_html_e( 'Other', 'efficient-modern' ); ?></option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="contact_message">
                                <?php esc_html_e( 'Your Message', 'efficient-modern' ); ?> *
                            </label>
                            <textarea class="form-control" id="contact_message" name="contact_message" rows="6" required 
                                      placeholder="<?php esc_attr_e( 'Tell us about your project or inquiry...', 'efficient-modern' ); ?>"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fa-solid fa-paper-plane"></i>
                            <?php esc_html_e( 'Send Message', 'efficient-modern' ); ?>
                        </button>
                    </form>
                </div>
                
                <!-- Contact Information -->
                <div class="contact-info-wrapper">
                    <div class="contact-info-card">
                        <h3 class="contact-info-title"><?php esc_html_e( 'Contact Information', 'efficient-modern' ); ?></h3>
                        
                        <!-- Address -->
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="contact-info-content">
                                <h4><?php esc_html_e( 'Visit Us', 'efficient-modern' ); ?></h4>
                                <p>
                                    <?php 
                                    $address = function_exists( 'of_get_option' ) ? of_get_option( 'company_address' ) : 'Warehouse-11, 10C Street, Ras Al Khor Industrial Area 1, Dubai';
                                    echo esc_html( $address );
                                    ?>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Phone -->
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="contact-info-content">
                                <h4><?php esc_html_e( 'Call Us', 'efficient-modern' ); ?></h4>
                                <p>
                                    <?php 
                                    $phone = function_exists( 'of_get_option' ) ? of_get_option( 'contact_no' ) : '+971 4 271 1048';
                                    ?>
                                    <a href="tel:<?php echo esc_attr( str_replace( array( ' ', '-', '+' ), '', $phone ) ); ?>">
                                        <?php echo esc_html( $phone ); ?>
                                    </a>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="contact-info-content">
                                <h4><?php esc_html_e( 'Email Us', 'efficient-modern' ); ?></h4>
                                <p>
                                    <?php 
                                    $email = function_exists( 'of_get_option' ) ? of_get_option( 'email_address' ) : 'info@efficientadvt.com';
                                    ?>
                                    <a href="mailto:<?php echo esc_attr( $email ); ?>">
                                        <?php echo esc_html( $email ); ?>
                                    </a>
                                </p>
                            </div>
                        </div>
                        
                        <!-- WhatsApp -->
                        <?php 
                        $whatsapp = function_exists( 'of_get_option' ) ? of_get_option( 'whatsapp_no' ) : '';
                        if ( $whatsapp ) :
                        ?>
                        <div class="contact-info-item">
                            <div class="contact-info-icon whatsapp">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div class="contact-info-content">
                                <h4><?php esc_html_e( 'WhatsApp', 'efficient-modern' ); ?></h4>
                                <p>
                                    <a href="https://wa.me/<?php echo esc_attr( str_replace( array( '+', ' ', '-' ), '', $whatsapp ) ); ?>" target="_blank">
                                        <?php echo esc_html( $whatsapp ); ?>
                                    </a>
                                </p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Business Hours -->
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div class="contact-info-content">
                                <h4><?php esc_html_e( 'Business Hours', 'efficient-modern' ); ?></h4>
                                <p>
                                    <?php esc_html_e( 'Saturday - Thursday: 9:00 AM - 6:00 PM', 'efficient-modern' ); ?><br>
                                    <?php esc_html_e( 'Friday: Closed', 'efficient-modern' ); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Links -->
                    <div class="contact-social">
                        <h4><?php esc_html_e( 'Follow Us', 'efficient-modern' ); ?></h4>
                        <div class="social-links">
                            <?php 
                            $facebook = function_exists( 'of_get_option' ) ? of_get_option( 'facebook_link' ) : '';
                            $instagram = function_exists( 'of_get_option' ) ? of_get_option( 'instagram_link' ) : '';
                            $linkedin = function_exists( 'of_get_option' ) ? of_get_option( 'linkedin_link' ) : '';
                            ?>
                            
                            <?php if ( $facebook ) : ?>
                                <a href="<?php echo esc_url( $facebook ); ?>" target="_blank" class="social-link">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ( $instagram ) : ?>
                                <a href="<?php echo esc_url( $instagram ); ?>" target="_blank" class="social-link">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ( $linkedin ) : ?>
                                <a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" class="social-link">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="contact-map-section">
        <div class="contact-map">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3610.2956878988886!2d55.36075631501205!3d25.184758383893394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f6773a8c8d8db%3A0x5e8f3c0c5b8e5e8d!2sRas%20Al%20Khor%20Industrial%20Area%201%20-%20Dubai!5e0!3m2!1sen!2sae!4v1234567890123!5m2!1sen!2sae" 
                width="100%" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

    <?php endwhile; ?>
</main>

<style>
/* Contact Page Styles */
.serif-text {
    font-family: 'Times New Roman', serif;
    font-style: italic;
}

.contact-hero-section {
    padding: 8rem 0 4rem;
    background: linear-gradient(135deg, #f8f6f6 0%, #ffffff 100%);
}

.contact-hero-content {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}

.contact-hero-label {
    display: block;
    color: var(--color-primary);
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    margin-bottom: 1.5rem;
}

.contact-hero-title {
    font-size: 3.5rem;
    font-weight: 300;
    line-height: 1.2;
    margin-bottom: 1.5rem;
}

.contact-hero-description {
    font-size: 1.125rem;
    line-height: 1.8;
    color: var(--color-text-light);
}

.contact-content-section {
    padding: 4rem 0 8rem;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 4rem;
}

.contact-form-wrapper {
    background: var(--color-bg-white);
    padding: 3rem;
    border-radius: 12px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
}

.contact-form-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 2rem;
}

.contact-form .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.contact-form .form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 1.5rem;
}

.contact-form .form-row .form-group {
    margin-bottom: 0;
}

.contact-form .form-group label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--color-text-dark);
    font-size: 0.875rem;
}

.contact-form .form-control {
    padding: 0.875rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.contact-form .form-control:focus {
    outline: none;
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.1);
}

.contact-form textarea.form-control {
    resize: vertical;
    min-height: 150px;
}

.contact-form .btn {
    margin-top: 1rem;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.contact-info-wrapper {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.contact-info-card {
    background: var(--color-bg-white);
    padding: 2.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
}

.contact-info-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 2rem;
}

.contact-info-item {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #f1f5f9;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.contact-info-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.contact-info-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--color-primary) 0%, #a31d42 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    flex-shrink: 0;
    font-size: 1.25rem;
}

.contact-info-icon.whatsapp {
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
}

.contact-info-content h4 {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--color-text-dark);
}

.contact-info-content p {
    color: var(--color-text-light);
    line-height: 1.6;
    margin: 0;
}

.contact-info-content a {
    color: var(--color-primary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.contact-info-content a:hover {
    color: #a31d42;
}

.contact-social {
    background: var(--color-bg-white);
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
}

.contact-social h4 {
    font-size: 1.125rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.social-links {
    display: flex;
    gap: 1rem;
}

.social-link {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #f8f6f6 0%, #e5e7eb 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    color: var(--color-text-dark);
    transition: all 0.3s ease;
    text-decoration: none;
}

.social-link:hover {
    background: linear-gradient(135deg, var(--color-primary) 0%, #a31d42 100%);
    color: white;
    transform: translateY(-4px);
}

.contact-map-section {
    margin-top: 4rem;
}

.contact-map {
    height: 450px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
}

.contact-map iframe {
    width: 100%;
    height: 100%;
}

@media (max-width: 992px) {
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 3rem;
    }
    
    .contact-hero-title {
        font-size: 2.5rem;
    }
    
    .contact-form-wrapper {
        padding: 2rem;
    }
}

@media (max-width: 768px) {
    .contact-hero-section {
        padding: 4rem 0 2rem;
    }
    
    .contact-form .form-row {
        grid-template-columns: 1fr;
        gap: 0;
    }
    
    .contact-hero-title {
        font-size: 2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';
            submitBtn.disabled = true;
        });
    }
});
</script>

<?php
get_footer();
