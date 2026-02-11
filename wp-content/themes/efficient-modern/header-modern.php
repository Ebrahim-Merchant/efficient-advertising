<?php
/**
 * The modern header with Tailwind CSS
 *
 * @package Efficient_Modern
 * @since 2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html class="scroll-smooth" lang="<?php language_attributes(); ?>">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    
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
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
        }
        .material-icons-outlined {
            font-family: 'Material Icons Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            display: inline-block;
            line-height: 1;
            text-transform: none;
            letter-spacing: normal;
            word-wrap: normal;
            white-space: nowrap;
            direction: ltr;
        }
    </style>
    
    <?php wp_head(); ?>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased overflow-x-hidden">
<?php wp_body_open(); ?>

<!-- Top Bar -->
<div class="hidden lg:block bg-accent text-white py-2 px-8 text-xs font-medium tracking-wide">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-6">
            <?php 
            $phone = function_exists('of_get_option') ? of_get_option('contact_no') : '+971 4 271 1048';
            $email = function_exists('of_get_option') ? of_get_option('email_address') : 'info@efficientadvt.com';
            $address = function_exists('of_get_option') ? of_get_option('header_address') : 'Al Khor Industrial Area 1, Dubai';
            ?>
            
            <?php if ($phone) : ?>
            <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>" class="flex items-center gap-1 hover:opacity-80">
                <i class="material-icons-outlined text-sm">phone</i> <?php echo esc_html($phone); ?>
            </a>
            <?php endif; ?>
            
            <?php if ($email) : ?>
            <a href="mailto:<?php echo esc_attr($email); ?>" class="flex items-center gap-1 hover:opacity-80">
                <i class="material-icons-outlined text-sm">email</i> <?php echo esc_html($email); ?>
            </a>
            <?php endif; ?>
            
            <?php if ($address) : ?>
            <span class="flex items-center gap-1">
                <i class="material-icons-outlined text-sm">location_on</i> <?php echo esc_html($address); ?>
            </span>
            <?php endif; ?>
        </div>
        <div class="flex items-center space-x-4">
            <?php 
            $facebook = function_exists('of_get_option') ? of_get_option('facebook_link') : '';
            $instagram = function_exists('of_get_option') ? of_get_option('instagram_link') : '';
            $linkedin = function_exists('of_get_option') ? of_get_option('linkedin_link') : '';
            ?>
            
            <?php if ($facebook) : ?>
            <a href="<?php echo esc_url($facebook); ?>" target="_blank" class="hover:opacity-80">FB</a>
            <?php endif; ?>
            
            <?php if ($instagram) : ?>
            <a href="<?php echo esc_url($instagram); ?>" target="_blank" class="hover:opacity-80">IG</a>
            <?php endif; ?>
            
            <?php if ($linkedin) : ?>
            <a href="<?php echo esc_url($linkedin); ?>" target="_blank" class="hover:opacity-80">LI</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Navigation -->
<nav class="sticky top-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center gap-2">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-2xl">E</span>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-slate-900 dark:text-white uppercase">
                        Efficient <span class="text-primary font-black">ADVT</span>
                    </span>
                </a>
            <?php endif; ?>
        </div>
        
        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center space-x-10 text-sm font-semibold tracking-wide uppercase">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => '',
                'items_wrap'     => '%3$s',
                'fallback_cb'    => false,
                'link_before'    => '',
                'link_after'     => '',
                'walker'         => new class extends Walker_Nav_Menu {
                    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                        $classes = empty($item->classes) ? array() : (array) $item->classes;
                        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
                        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
                        
                        $output .= '<a href="' . esc_url($item->url) . '" class="hover:text-primary transition-colors"' . $class_names . '>';
                        $output .= apply_filters('the_title', $item->title, $item->ID);
                        $output .= '</a>';
                    }
                }
            ));
            ?>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center gap-4">
            <button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors" aria-label="Search">
                <i class="material-icons-outlined">search</i>
            </button>
            <a href="<?php echo esc_url(home_url('/contact-us')); ?>" class="bg-primary hover:bg-red-600 text-white px-6 py-2.5 rounded-full text-sm font-bold transition-all shadow-lg shadow-primary/20">
                Get Quote
            </a>
        </div>
    </div>
</nav>

<div id="page" class="site">
    <div id="content" class="site-content">
