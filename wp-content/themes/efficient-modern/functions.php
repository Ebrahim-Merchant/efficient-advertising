<?php
/**
 * Efficient Modern Theme functions and definitions
 *
 * @package Efficient_Modern
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Theme version
define( 'EFFICIENT_MODERN_VERSION', '1.0.0' );

/**
 * Theme Setup
 */
function efficient_modern_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails
    add_theme_support( 'post-thumbnails' );
    
    // Add custom image sizes
    add_image_size( 'efficient-hero', 1920, 800, true );
    add_image_size( 'efficient-category', 600, 400, true );
    add_image_size( 'efficient-product', 800, 800, true );
    add_image_size( 'efficient-thumbnail', 400, 400, true );

    // Register Navigation Menus
    register_nav_menus( array(
        'primary'  => esc_html__( 'Primary Menu', 'efficient-modern' ),
        'footer'   => esc_html__( 'Footer Menu', 'efficient-modern' ),
    ) );

    // HTML5 support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add theme support for custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-width'  => true,
        'flex-height' => true,
    ) );

    // Add theme support for custom background
    add_theme_support( 'custom-background', array(
        'default-color' => 'ffffff',
    ) );

    // WooCommerce Support
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // Add support for editor styles
    add_theme_support( 'editor-styles' );
    
    // Load translation files
    load_theme_textdomain( 'efficient-modern', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'efficient_modern_setup' );

/**
 * Set the content width
 */
function efficient_modern_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'efficient_modern_content_width', 1280 );
}
add_action( 'after_setup_theme', 'efficient_modern_content_width', 0 );

/**
 * Enqueue scripts and styles
 */
function efficient_modern_scripts() {
    // Google Fonts - Inter & Poppins
    wp_enqueue_style( 
        'efficient-modern-fonts', 
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap', 
        array(), 
        null 
    );

    // Font Awesome 6.5.1 (Latest) - Unique handle to avoid conflicts
    wp_enqueue_style( 
        'efficient-font-awesome', 
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', 
        array(), 
        '6.5.1'
    );
    
    // Add V4 shims just in case
    wp_enqueue_style( 
        'efficient-font-awesome-v4-shims', 
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/v4-shims.min.css', 
        array('efficient-font-awesome'), 
        '6.5.1'
    );

    // Animate.css for WOW.js animations
    wp_enqueue_style( 
        'animate-css', 
        'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', 
        array(), 
        '4.1.1' 
    );

    // Main stylesheet
    wp_enqueue_style( 
        'efficient-modern-style', 
        get_stylesheet_uri(), 
        array(), 
        EFFICIENT_MODERN_VERSION 
    );

    // Additional custom styles
    wp_enqueue_style( 
        'efficient-modern-custom', 
        get_template_directory_uri() . '/assets/css/custom.css', 
        array('efficient-modern-style'), 
        EFFICIENT_MODERN_VERSION 
    );

    // Hero carousel styles
    wp_enqueue_style( 
        'efficient-modern-hero-carousel', 
        get_template_directory_uri() . '/assets/css/hero-carousel.css', 
        array('efficient-modern-style'), 
        EFFICIENT_MODERN_VERSION 
    );

    // M Print House Style (new layout)
    wp_enqueue_style( 
        'efficient-modern-mpstyle', 
        get_template_directory_uri() . '/assets/css/mpstyle.css', 
        array('efficient-modern-style'), 
        EFFICIENT_MODERN_VERSION 
    );

    // jQuery (already included in WordPress)
    
    // WOW.js for scroll animations
    wp_enqueue_script( 
        'wow-js', 
        'https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js', 
        array(), 
        '1.1.2', 
        true 
    );
    
    // Main JavaScript
    wp_enqueue_script( 
        'efficient-modern-main', 
        get_template_directory_uri() . '/assets/js/main.js', 
        array('jquery', 'wow-js'), 
        EFFICIENT_MODERN_VERSION, 
        true 
    );

    // M Print House Style JavaScript
    wp_enqueue_script( 
        'efficient-modern-mpstyle', 
        get_template_directory_uri() . '/assets/js/mpstyle.js', 
        array('jquery'), 
        EFFICIENT_MODERN_VERSION, 
        true 
    );

    // Localize script for AJAX
    wp_localize_script( 'efficient-modern-main', 'efficientModern', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'efficient-modern-nonce' ),
    ) );

    // Comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'efficient_modern_scripts' );

/**
 * Add Font Awesome v5 to v6 compatibility CSS
 * This ensures icons work with both old (fas, fab, far) and new (fa-solid, fa-brands) class names
 */
function efficient_modern_font_awesome_compatibility() {
    ?>
    <style id="fa-compatibility">
        /* Font Awesome v5 to v6 Compatibility Layer */
        .fas, .fab, .far, .fal, .fad, 
        i[class*="fa-"] {
            -moz-osx-font-smoothing: grayscale;
            -webkit-font-smoothing: antialiased;
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            line-height: 1;
            text-rendering: auto;
        }
        
        /* Solid icons */
        .fas {
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 900 !important;
        }
        
        /* Regular icons */
        .far {
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 400 !important;
        }
        
        /* Brand icons */
        .fab {
            font-family: "Font Awesome 6 Brands" !important;
            font-weight: 400 !important;
        }
        
        /* Light & Duotone (Pro only, fallback to regular) */
        .fal, .fad {
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 400 !important;
        }
        
        /* Old Icons Mapping */
        .fa-truck:before { content: "\f0d1"; }
        .fa-users-cog:before { content: "\f509"; }
        .fa-tags:before { content: "\f02c"; }
        .fa-star:before { content: "\f005"; }
        .fa-print:before { content: "\f02f"; }
        .fa-image:before { content: "\f03e"; }
        .fa-arrow-right:before { content: "\f061"; }
        .fa-award:before { content: "\f559"; }
        .fa-project-diagram:before { content: "\f542"; }
        .fa-users:before { content: "\f0c0"; }
        .fa-clock:before { content: "\f017"; }
        .fa-headset:before { content: "\f590"; }
        .fa-chevron-down:before { content: "\f078"; }
        .fa-phone:before { content: "\f095"; }
        .fa-envelope:before { content: "\f0e0"; }
        .fa-file-invoice-dollar:before { content: "\f571"; }
        .fa-credit-card:before { content: "\f09d"; }
        .fa-palette:before { content: "\f53f"; }
        .fa-cogs:before { content: "\f085"; }
        .fa-shipping-fast:before { content: "\f48b"; }
        .fa-location-dot:before { content: "\f3c5"; }
        .fa-magnifying-glass:before { content: "\f002"; }
        .fa-cart-shopping:before { content: "\f07a"; }
        
        /* Modern equivalents if missing */
        .fa-search:before { content: "\f002"; }
        .fa-map-marker-alt:before { content: "\f3c5"; }
        .fa-shopping-cart:before { content: "\f07a"; }
        
        /* Social Media Icons */
        .fa-facebook-f:before { content: "\f39e"; }
        .fa-twitter:before { content: "\f099"; }
        .fa-instagram:before { content: "\f16d"; }
        .fa-linkedin-in:before { content: "\f0e1"; }
        .fa-whatsapp:before { content: "\f232"; }
        .fa-youtube:before { content: "\f167"; }
        
        /* Generic .fa fallback to Solid */
        .fa {
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 900 !important;
        }
        
        /* Why Choose Us Icons - Specific Mapping */
        .fa-award:before { content: "\f559"; } 
        .fa-project-diagram:before { content: "\f542"; }
        .fa-users:before { content: "\f0c0"; }
        .fa-clock:before { content: "\f017"; }
        .fa-tags:before { content: "\f02c"; }
        .fa-headset:before { content: "\f590"; }
        
        /* Ensure specific icons for Why Choose Us have Solid style */
        .why-choose-icon i.fas, 
        .why-choose-icon i.fa-solid,
        .why-choose-icon i.fa {
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 900 !important;
            font-style: normal;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'efficient_modern_font_awesome_compatibility', 100 );

/**
 * Register Widget Areas
 */
function efficient_modern_widgets_init() {
    // Sidebar
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'efficient-modern' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'efficient-modern' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    // Footer Widget Areas (4 columns)
    for ( $i = 1; $i <= 4; $i++ ) {
        register_sidebar( array(
            'name'          => sprintf( esc_html__( 'Footer %d', 'efficient-modern' ), $i ),
            'id'            => 'footer-' . $i,
            'description'   => sprintf( esc_html__( 'Footer widget area %d', 'efficient-modern' ), $i ),
            'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ) );
    }
}
add_action( 'widgets_init', 'efficient_modern_widgets_init' );

/**
 * Custom Excerpt Length
 */
function efficient_modern_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'efficient_modern_excerpt_length' );

/**
 * Custom Excerpt More
 */
function efficient_modern_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'efficient_modern_excerpt_more' );

/**
 * Add class to navigation menu links
 */
function efficient_modern_nav_menu_link_attributes( $atts, $item, $args ) {
    if ( isset( $args->link_class ) ) {
        $atts['class'] = $args->link_class;
    }
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'efficient_modern_nav_menu_link_attributes', 10, 3 );

/**
 * Add body classes
 */
function efficient_modern_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter( 'body_class', 'efficient_modern_body_classes' );

/**
 * Include Custom Post Types and Taxonomies
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * Include Theme Options Framework (if using options framework)
 */
if ( file_exists( get_template_directory() . '/inc/options-framework.php' ) ) {
    define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
    require_once get_template_directory() . '/inc/options-framework.php';
}

/**
 * Include Theme Customizer
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Include Template Functions
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * WooCommerce Customizations
 */
if ( class_exists( 'WooCommerce' ) ) {
    require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Add custom field support for theme options
 */
function efficient_modern_acf_json_save_point( $path ) {
    $path = get_stylesheet_directory() . '/acf-json';
    return $path;
}
add_filter( 'acf/settings/save_json', 'efficient_modern_acf_json_save_point' );

function efficient_modern_acf_json_load_point( $paths ) {
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}
add_filter( 'acf/settings/load_json', 'efficient_modern_acf_json_load_point' );

/**
 * Get WooCommerce cart count
 */
function efficient_modern_cart_count() {
    if ( class_exists( 'WooCommerce' ) ) {
        return WC()->cart->get_cart_contents_count();
    }
    return 0;
}

/**
 * Custom Product Sorting
 */
function efficient_modern_product_sorting( $query ) {
    if ( ! is_admin() && $query->is_main_query() && ( is_post_type_archive( 'product' ) || is_tax( 'product_category' ) ) ) {
        
        // Check if orderby parameter is set
        if ( isset( $_GET['orderby'] ) ) {
            $orderby = sanitize_text_field( $_GET['orderby'] );
            
            switch ( $orderby ) {
                case 'name-asc':
                    $query->set( 'orderby', 'title' );
                    $query->set( 'order', 'ASC' );
                    break;
                
                case 'name-desc':
                    $query->set( 'orderby', 'title' );
                    $query->set( 'order', 'DESC' );
                    break;
                
                case 'date-desc':
                    $query->set( 'orderby', 'date' );
                    $query->set( 'order', 'DESC' );
                    break;
                
                case 'date-asc':
                    $query->set( 'orderby', 'date' );
                    $query->set( 'order', 'ASC' );
                    break;
            }
        }
        
        // Set posts per page
        $query->set( 'posts_per_page', 12 );
    }
}
add_action( 'pre_get_posts', 'efficient_modern_product_sorting' );

/**
 * Add "View All Products" link to menu (optional)
 */
function efficient_modern_add_products_to_menu( $items, $args ) {
    if ( $args->theme_location == 'primary' ) {
        $products_link = get_post_type_archive_link( 'product' );
        if ( $products_link ) {
            $items .= '<li class="menu-item"><a href="' . esc_url( $products_link ) . '">' . esc_html__( 'All Products', 'efficient-modern' ) . '</a></li>';
        }
    }
    return $items;
}
// Uncomment the line below to add "All Products" link to your menu automatically
// add_filter( 'wp_nav_menu_items', 'efficient_modern_add_products_to_menu', 10, 2 );

/**
 * Update cart count via AJAX
 */
function efficient_modern_update_cart_count() {
    echo efficient_modern_cart_count();
    wp_die();
}
add_action( 'wp_ajax_efficient_modern_update_cart_count', 'efficient_modern_update_cart_count' );
add_action( 'wp_ajax_nopriv_efficient_modern_update_cart_count', 'efficient_modern_update_cart_count' );

/**
 * Flush rewrite rules on theme activation
 */
function efficient_modern_activation() {
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'efficient_modern_activation' );

/**
 * Handle Product Order Form Submission
 */
function efficient_modern_handle_product_order() {
    // Verify nonce
    if ( ! isset( $_POST['order_nonce'] ) || ! wp_verify_nonce( $_POST['order_nonce'], 'product_order_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed' ) );
        return;
    }

    // Sanitize form data
    $product_id = intval( $_POST['product_id'] );
    $product_name = sanitize_text_field( $_POST['product_name'] );
    $customer_name = sanitize_text_field( $_POST['order_name'] );
    $customer_email = sanitize_email( $_POST['order_email'] );
    $customer_phone = sanitize_text_field( $_POST['order_phone'] );
    $company = sanitize_text_field( $_POST['order_company'] );
    $quantity = intval( $_POST['order_quantity'] );
    $size = sanitize_text_field( $_POST['order_size'] );
    $material = sanitize_text_field( $_POST['order_material'] );
    $deadline = sanitize_text_field( $_POST['order_deadline'] );
    $notes = sanitize_textarea_field( $_POST['order_notes'] );
    $delivery_option = sanitize_text_field( $_POST['order_delivery'] );
    $delivery_address = sanitize_textarea_field( $_POST['order_address'] );

    // Handle file uploads
    $attachments = array();
    $uploaded_files_info = array();
    
    if ( ! empty( $_FILES['order_artwork']['name'][0] ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        
        $files = $_FILES['order_artwork'];
        $file_count = count( $files['name'] );
        
        for ( $i = 0; $i < $file_count; $i++ ) {
            if ( $files['error'][$i] === 0 ) {
                $file = array(
                    'name'     => $files['name'][$i],
                    'type'     => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error'    => $files['error'][$i],
                    'size'     => $files['size'][$i]
                );
                
                // Validate file size (10MB max)
                if ( $file['size'] > 10 * 1024 * 1024 ) {
                    continue;
                }
                
                // Move file to temp location
                $upload = wp_handle_upload( $file, array( 'test_form' => false ) );
                
                if ( ! isset( $upload['error'] ) ) {
                    $attachments[] = $upload['file'];
                    $uploaded_files_info[] = array(
                        'name' => $files['name'][$i],
                        'size' => size_format( $files['size'][$i] )
                    );
                }
            }
        }
    }

    // Get admin email
    $admin_email = get_option( 'admin_email' );
    
    // Try to get custom email from theme options
    if ( function_exists( 'of_get_option' ) ) {
        $custom_email = of_get_option( 'email_address' );
        if ( $custom_email ) {
            $admin_email = $custom_email;
        }
    }

    // Prepare email subject
    $subject = sprintf( 
        __( 'New Quote Request: %s - %s', 'efficient-modern' ),
        $product_name,
        $customer_name
    );

    // Prepare delivery option text
    $delivery_options = array(
        'pickup' => 'Pickup from Dubai',
        'delivery_dubai' => 'Delivery within Dubai',
        'delivery_uae' => 'Delivery within UAE',
        'delivery_international' => 'International Delivery'
    );
    $delivery_text = isset( $delivery_options[ $delivery_option ] ) ? $delivery_options[ $delivery_option ] : $delivery_option;

    // Prepare material text
    $material_options = array(
        'standard' => 'Standard',
        'premium' => 'Premium',
        'custom' => 'Custom'
    );
    $material_text = isset( $material_options[ $material ] ) ? $material_options[ $material ] : $material;

    // Prepare email body (HTML)
    $message = '
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .email-container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #8B1538 0%, #FF6B35 100%); color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
            .content { background: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; border-top: none; }
            .section { margin-bottom: 25px; }
            .section-title { font-size: 16px; font-weight: bold; color: #8B1538; margin-bottom: 10px; border-bottom: 2px solid #8B1538; padding-bottom: 5px; }
            .field { margin-bottom: 12px; }
            .field-label { font-weight: bold; color: #555; }
            .field-value { color: #333; margin-left: 10px; }
            .product-link { display: inline-block; margin-top: 15px; padding: 10px 20px; background: #8B1538; color: white; text-decoration: none; border-radius: 5px; }
            .footer { background: #374151; color: white; padding: 15px; text-align: center; font-size: 12px; border-radius: 0 0 8px 8px; }
        </style>
    </head>
    <body>
        <div class="email-container">
            <div class="header">
                <h2>📋 New Quote Request</h2>
                <p style="margin: 0;">Efficient Advertising - Dubai</p>
            </div>
            
            <div class="content">
                <div class="section">
                    <div class="section-title">👤 Customer Information</div>
                    <div class="field">
                        <span class="field-label">Name:</span>
                        <span class="field-value">' . esc_html( $customer_name ) . '</span>
                    </div>
                    <div class="field">
                        <span class="field-label">Email:</span>
                        <span class="field-value"><a href="mailto:' . esc_attr( $customer_email ) . '">' . esc_html( $customer_email ) . '</a></span>
                    </div>
                    <div class="field">
                        <span class="field-label">Phone:</span>
                        <span class="field-value"><a href="tel:' . esc_attr( str_replace( array( ' ', '-', '+' ), '', $customer_phone ) ) . '">' . esc_html( $customer_phone ) . '</a></span>
                    </div>';
    
    if ( $company ) {
        $message .= '
                    <div class="field">
                        <span class="field-label">Company:</span>
                        <span class="field-value">' . esc_html( $company ) . '</span>
                    </div>';
    }
    
    $message .= '
                </div>
                
                <div class="section">
                    <div class="section-title">📦 Product & Order Details</div>
                    <div class="field">
                        <span class="field-label">Product:</span>
                        <span class="field-value"><strong>' . esc_html( $product_name ) . '</strong></span>
                    </div>
                    <div class="field">
                        <span class="field-label">Quantity:</span>
                        <span class="field-value">' . esc_html( $quantity ) . ' units</span>
                    </div>';
    
    if ( $size ) {
        $message .= '
                    <div class="field">
                        <span class="field-label">Size/Dimensions:</span>
                        <span class="field-value">' . esc_html( $size ) . '</span>
                    </div>';
    }
    
    if ( $material ) {
        $message .= '
                    <div class="field">
                        <span class="field-label">Material/Type:</span>
                        <span class="field-value">' . esc_html( $material_text ) . '</span>
                    </div>';
    }
    
    if ( $deadline ) {
        $message .= '
                    <div class="field">
                        <span class="field-label">Required By:</span>
                        <span class="field-value">' . esc_html( date( 'F j, Y', strtotime( $deadline ) ) ) . '</span>
                    </div>';
    }
    
    $message .= '
                    <div class="field">
                        <span class="field-label">Has Artwork:</span>
                        <span class="field-value">' . esc_html( $has_artwork ) . '</span>
                    </div>';
    
    if ( $notes ) {
        $message .= '
                    <div class="field">
                        <span class="field-label">Additional Notes:</span>
                        <div style="background: white; padding: 10px; margin-top: 5px; border-left: 3px solid #8B1538;">' . nl2br( esc_html( $notes ) ) . '</div>
                    </div>';
    }
    
    $message .= '
                </div>
                
                <div class="section">
                    <div class="section-title">🚚 Delivery Information</div>
                    <div class="field">
                        <span class="field-label">Delivery Option:</span>
                        <span class="field-value">' . esc_html( $delivery_text ) . '</span>
                    </div>';
    
    if ( $delivery_address ) {
        $message .= '
                    <div class="field">
                        <span class="field-label">Delivery Address:</span>
                        <div style="background: white; padding: 10px; margin-top: 5px; border-left: 3px solid #8B1538;">' . nl2br( esc_html( $delivery_address ) ) . '</div>
                    </div>';
    }
    
    $product_link = get_permalink( $product_id );
    $message .= '
                </div>
                
                <div style="text-align: center; margin-top: 30px;">
                    <a href="' . esc_url( $product_link ) . '" class="product-link">View Product</a>
                </div>
            </div>
            
            <div class="footer">
                <p style="margin: 0;">This quote request was submitted from your website.</p>
                <p style="margin: 5px 0 0;">Respond within 24 hours for best customer experience.</p>
            </div>
        </div>
    </body>
    </html>';

    // Email headers
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . get_bloginfo( 'name' ) . ' <' . $admin_email . '>',
        'Reply-To: ' . $customer_name . ' <' . $customer_email . '>',
    );

    // Send email with attachments
    $email_sent = wp_mail( $admin_email, $subject, $message, $headers, $attachments );

    // Send confirmation email to customer
    $customer_subject = sprintf( 
        __( 'Quote Request Received - %s', 'efficient-modern' ),
        $product_name
    );
    
    $customer_message = '
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .email-container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #8B1538 0%, #FF6B35 100%); color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
            .content { background: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; border-top: none; }
            .footer { background: #374151; color: white; padding: 15px; text-align: center; font-size: 12px; border-radius: 0 0 8px 8px; }
        </style>
    </head>
    <body>
        <div class="email-container">
            <div class="header">
                <h2>✅ Quote Request Received</h2>
                <p style="margin: 0;">Thank you for choosing Efficient Advertising!</p>
            </div>
            
            <div class="content">
                <p>Dear ' . esc_html( $customer_name ) . ',</p>
                
                <p>Thank you for your quote request for <strong>' . esc_html( $product_name ) . '</strong>.</p>
                
                <p>We have received your request and our team will review it carefully. You can expect to hear from us within <strong>24 hours</strong> with a detailed quote.</p>
                
                <p><strong>Your Request Summary:</strong></p>
                <ul>
                    <li>Product: ' . esc_html( $product_name ) . '</li>
                    <li>Quantity: ' . esc_html( $quantity ) . ' units</li>
                    ' . ( $size ? '<li>Size: ' . esc_html( $size ) . '</li>' : '' ) . '
                    <li>Delivery: ' . esc_html( $delivery_text ) . '</li>
                </ul>
                
                <p>If you have any immediate questions, please don\'t hesitate to contact us.</p>
                
                <p>Best regards,<br>
                <strong>Efficient Advertising Team</strong><br>
                Dubai, UAE</p>
            </div>
            
            <div class="footer">
                <p style="margin: 0;">This is an automated confirmation email.</p>
            </div>
        </div>
    </body>
    </html>';

    $customer_headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . get_bloginfo( 'name' ) . ' <' . $admin_email . '>',
    );

    wp_mail( $customer_email, $customer_subject, $customer_message, $customer_headers );

    // Clean up uploaded files from temp directory
    if ( ! empty( $attachments ) ) {
        foreach ( $attachments as $attachment ) {
            if ( file_exists( $attachment ) ) {
                @unlink( $attachment );
            }
        }
    }

    if ( $email_sent ) {
        wp_send_json_success( array( 'message' => 'Quote request submitted successfully' ) );
    } else {
        wp_send_json_error( array( 'message' => 'Failed to send email' ) );
    }
}
add_action( 'admin_post_submit_product_order', 'efficient_modern_handle_product_order' );
add_action( 'admin_post_nopriv_submit_product_order', 'efficient_modern_handle_product_order' );

/**
 * AJAX Product Search
 */
function efficient_modern_search_products() {
    check_ajax_referer( 'efficient-modern-nonce', 'nonce' );
    
    $query = isset( $_POST['query'] ) ? sanitize_text_field( $_POST['query'] ) : '';
    
    if ( empty( $query ) || strlen( $query ) < 2 ) {
        wp_send_json_success( array() );
        return;
    }
    
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 5,
        's' => $query,
        'post_status' => 'publish',
    );
    
    $search_query = new WP_Query( $args );
    $results = array();
    
    if ( $search_query->have_posts() ) {
        while ( $search_query->have_posts() ) {
            $search_query->the_post();
            
            $terms = get_the_terms( get_the_ID(), 'product_category' );
            $category = ! empty( $terms ) && ! is_wp_error( $terms ) ? $terms[0]->name : '';
            
            $results[] = array(
                'title' => get_the_title(),
                'url' => get_permalink(),
                'image' => get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ),
                'category' => $category,
            );
        }
        wp_reset_postdata();
    }
    
    wp_send_json_success( $results );
}
add_action( 'wp_ajax_search_products', 'efficient_modern_search_products' );
add_action( 'wp_ajax_nopriv_search_products', 'efficient_modern_search_products' );

/**
 * Realtime Product Search for Homepage
 */
function efficient_modern_realtime_product_search() {
    $query = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';
    
    if ( empty( $query ) || strlen( $query ) < 2 ) {
        wp_send_json_success( array() );
        return;
    }
    
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 5,
        's' => $query,
        'post_status' => 'publish',
    );
    
    $search_query = new WP_Query( $args );
    $results = array();
    
    if ( $search_query->have_posts() ) {
        while ( $search_query->have_posts() ) {
            $search_query->the_post();
            
            $terms = get_the_terms( get_the_ID(), 'product_category' );
            $category = ! empty( $terms ) && ! is_wp_error( $terms ) ? $terms[0]->name : '';
            
            $results[] = array(
                'title' => get_the_title(),
                'url' => get_permalink(),
                'image' => get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ),
                'category' => $category,
            );
        }
        wp_reset_postdata();
    }
    
    wp_send_json_success( $results );
}
add_action( 'wp_ajax_realtime_product_search', 'efficient_modern_realtime_product_search' );
add_action( 'wp_ajax_nopriv_realtime_product_search', 'efficient_modern_realtime_product_search' );
