<?php
/**
 * The header for Efficient Modern theme
 *
 * @package Efficient_Modern
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!doctype html>
<html class="scroll-smooth" <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#EF4444",
                        "background-light": "#F9FAFB",
                        "background-dark": "#111827",
                        accent: "#6B1D2D",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "12px",
                        "2xl": "24px",
                    },
                },
            },
        };
    </script>
    
    <?php 
    // Favicon support
    if ( function_exists( 'of_get_option' ) && of_get_option( 'favicon' ) ) : ?>
        <link rel="shortcut icon" type="image/png" href="<?php echo esc_url( of_get_option( 'favicon' ) ); ?>"/>
    <?php endif; ?>
    
    <?php wp_head(); ?>
</head>

<body class="antialiased" <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary">
        <?php esc_html_e( 'Skip to content', 'efficient-modern' ); ?>
    </a>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-inner">
                <div class="top-bar-contact">
                    <?php 
                    $phone = function_exists( 'of_get_option' ) ? of_get_option( 'contact_no' ) : '+971 4 271 1048';
                    $email = function_exists( 'of_get_option' ) ? of_get_option( 'email_address' ) : 'info@efficientadvt.com';
                    $address = function_exists( 'of_get_option' ) ? of_get_option( 'header_address' ) : 'Warehouse-11, 10C Street, Ras Al Khor Industrial Area 1, Dubai';
                    ?>
                    
                    <?php if ( $phone ) : ?>
                        <a href="tel:<?php echo esc_attr( str_replace( ' ', '', $phone ) ); ?>">
                            <i class="fa-solid fa-phone"></i>
                            <span><?php echo esc_html( $phone ); ?></span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( $email ) : ?>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>">
                            <i class="fa-solid fa-envelope"></i>
                            <span><?php echo esc_html( $email ); ?></span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( $address ) : ?>
                        <span>
                            <i class="fa-solid fa-location-dot"></i>
                            <span><?php echo esc_html( $address ); ?></span>
                        </span>
                    <?php endif; ?>
                </div>
                
                <div class="top-bar-social">
                    <?php 
                    $facebook = function_exists( 'of_get_option' ) ? of_get_option( 'facebook_link' ) : '';
                    $twitter = function_exists( 'of_get_option' ) ? of_get_option( 'twitter_link' ) : '';
                    $linkedin = function_exists( 'of_get_option' ) ? of_get_option( 'linkedin_link' ) : '';
                    $instagram = function_exists( 'of_get_option' ) ? of_get_option( 'instagram_link' ) : '';
                    ?>
                    
                    <?php if ( $facebook ) : ?>
                        <a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener" aria-label="Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( $twitter ) : ?>
                        <a href="<?php echo esc_url( $twitter ); ?>" target="_blank" rel="noopener" aria-label="Twitter">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( $linkedin ) : ?>
                        <a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener" aria-label="LinkedIn">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( $instagram ) : ?>
                        <a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener" aria-label="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div><!-- .top-bar -->

    <!-- Main Header -->
    <header id="masthead" class="site-header">
        <div class="container">
            <div class="site-header-inner">
                
                <!-- Logo -->
                <div class="site-branding">
                    <?php
                    $logo = function_exists( 'of_get_option' ) ? of_get_option( 'logo' ) : '';
                    
                    if ( has_custom_logo() ) {
                        the_custom_logo();
                    } elseif ( $logo ) {
                        ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="site-logo">
                        </a>
                        <?php
                    } else {
                        // Use header logo as fallback
                        $default_logo = get_template_directory_uri() . '/assets/images/logo-header.png';
                        ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <img src="<?php echo esc_url( $default_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="site-logo">
                        </a>
                        <?php
                    }
                    ?>
                </div><!-- .site-branding -->

                <!-- Mobile Menu Toggle -->
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle menu', 'efficient-modern' ); ?>">
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                </button>

                <!-- Main Navigation -->
                <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'efficient-modern' ); ?>">
                    <?php
                    if ( has_nav_menu( 'primary' ) ) {
                        wp_nav_menu(
                            array(
                                'theme_location' => 'primary',
                                'menu_id'        => 'primary-menu',
                                'container'      => false,
                                'fallback_cb'    => false,
                            )
                        );
                    } else {
                        // Fallback menu if no menu is set
                        echo '<ul id="primary-menu">';
                        echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'efficient-modern' ) . '</a></li>';
                        
                        // Check if products/shop page exists
                        $products_page = get_post_type_archive_link( 'product' );
                        if ( $products_page ) {
                            echo '<li><a href="' . esc_url( $products_page ) . '">' . esc_html__( 'Products', 'efficient-modern' ) . '</a></li>';
                        } elseif ( class_exists( 'WooCommerce' ) ) {
                            echo '<li><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '">' . esc_html__( 'Products', 'efficient-modern' ) . '</a></li>';
                        }
                        
                        echo '<li><a href="' . esc_url( home_url( '/about-us' ) ) . '">' . esc_html__( 'About Us', 'efficient-modern' ) . '</a></li>';
                        echo '<li><a href="' . esc_url( home_url( '/contact-us' ) ) . '">' . esc_html__( 'Contact', 'efficient-modern' ) . '</a></li>';
                        echo '</ul>';
                    }
                    ?>
                </nav><!-- #site-navigation -->

                <!-- Header Actions -->
                <div class="header-actions">
                    
                    <!-- Product Search -->
                    <button class="search-toggle" aria-label="<?php esc_attr_e( 'Search', 'efficient-modern' ); ?>" id="searchToggle">
                        <i class="fa-solid fa-search"></i>
                    </button>
                    
                    <!-- Search Form Dropdown -->
                    <div class="search-dropdown" id="searchDropdown">
                        <form role="search" method="get" class="product-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <input type="search" 
                                   class="search-field" 
                                   placeholder="<?php esc_attr_e( 'Search products...', 'efficient-modern' ); ?>" 
                                   value="<?php echo get_search_query(); ?>" 
                                   name="s" 
                                   autocomplete="off">
                            <input type="hidden" name="post_type" value="product">
                            <button type="submit" class="search-submit">
                                <i class="fa-solid fa-search"></i>
                            </button>
                        </form>
                        <div class="search-suggestions" id="searchSuggestions"></div>
                    </div>
                    
                    <!-- WhatsApp Button -->
                    <?php 
                    $whatsapp_number = function_exists( 'of_get_option' ) ? of_get_option( 'whatsapp_number' ) : '+971527966265';
                    if ( $whatsapp_number ) : 
                    ?>
                        <a href="https://wa.me/<?php echo esc_attr( str_replace( array( '+', ' ', '-' ), '', $whatsapp_number ) ); ?>" 
                           class="header-whatsapp" 
                           target="_blank" 
                           rel="noopener"
                           aria-label="<?php esc_attr_e( 'Contact us on WhatsApp', 'efficient-modern' ); ?>">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    <?php endif; ?>
                    
                    <!-- Cart Icon (WooCommerce) -->
                    <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="header-cart-icon" aria-label="<?php esc_attr_e( 'Shopping Cart', 'efficient-modern' ); ?>">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <?php 
                            $cart_count = WC()->cart->get_cart_contents_count();
                            if ( $cart_count > 0 ) : 
                            ?>
                                <span class="cart-count"><?php echo esc_html( $cart_count ); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                    
                    <!-- CTA Button -->
                    <button type="button" class="btn btn-secondary btn-sm header-cta" data-toggle="modal" data-target="#requestQuoteModal">
                        <?php esc_html_e( 'Get Quote', 'efficient-modern' ); ?>
                    </button>
                </div><!-- .header-actions -->

            </div><!-- .site-header-inner -->
        </div><!-- .container -->
    </header><!-- #masthead -->

    <main id="primary" class="site-main">
