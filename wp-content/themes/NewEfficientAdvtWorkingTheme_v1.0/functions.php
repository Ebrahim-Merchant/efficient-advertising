<?php

/* ═══════════════════════════════════════════════════════════════════
   EA PREMIUM V2 GLOBAL SANDBOX
   Trigger: Append ?premium_v2=1 to any URL
   ═══════════════════════════════════════════════════════════════════ */
add_action('wp_enqueue_scripts', function() {
    if (is_front_page() || is_home() || isset($_GET['premium_v2']) || isset($_COOKIE['ea_premium_v2_active']) || is_page_template('homepage-preview-v2.php')) {
        // 1. Set a cookie so it stays active as you click links
        if (isset($_GET['premium_v2'])) {
            setcookie('ea_premium_v2_active', '1', time() + 3600, '/');
        }
        
        // 2. Load the V2 Global CSS
        $css_url = get_template_directory_uri() . '/css/ea-homepage-visual-rhythm-preview-v2.css';
        wp_enqueue_style('ea-premium-v2-global', $css_url, array(), time());
    }
});

add_filter('body_class', function($classes) {
    if (is_front_page() || is_home() || isset($_GET['premium_v2']) || isset($_COOKIE['ea_premium_v2_active']) || is_page_template('homepage-preview-v2.php')) {
        $classes[] = 'ea-preview-active-v2';
    }
    return $classes;
});

// Allow clearing the sandbox with ?clear_v2=1
add_action('init', function() {
    if (isset($_GET['clear_v2'])) {
        setcookie('ea_premium_v2_active', '', time() - 3600, '/');
        wp_redirect(remove_query_arg('clear_v2'));
        exit;
    }
});

/* PTR-004.6: GLOBAL ARCHITECTURAL MESH SYSTEM (ORIGINAL SUBTLE VISIBILITY) */
add_action('wp_footer', function() {
    if (isset($_GET['premium_v2']) || isset($_COOKIE['ea_premium_v2_active']) || is_page_template('homepage-preview-v2.php')) {
        ?>
        <script id="ea-v2-architectural-mesh-global">
        (function() {
            const canvas = document.createElement('canvas');
            canvas.id = 'ea-v2-canvas-global';
            canvas.style.position = 'fixed';
            canvas.style.top = '0';
            canvas.style.left = '0';
            canvas.style.width = '100vw';
            canvas.style.height = '100vh';
            canvas.style.zIndex = '9999'; /* Kept at front so backgrounds don't hide it */
            canvas.style.pointerEvents = 'none';
            document.body.prepend(canvas);

            const ctx = canvas.getContext('2d');
            let width, height;

            function resize() {
                width = canvas.width = window.innerWidth;
                height = canvas.height = window.innerHeight;
            }
            window.addEventListener('resize', resize);
            resize();

            class Node {
                constructor() {
                    this.x = Math.random() * width;
                    this.y = Math.random() * height;
                    this.vx = (Math.random() - 0.5) * 0.4;
                    this.vy = (Math.random() - 0.5) * 0.4;
                }
                update() {
                    this.x += this.vx;
                    this.y += this.vy;
                    if (this.x < 0 || this.x > width) this.vx *= -1;
                    if (this.y < 0 || this.y > height) this.vy *= -1;
                }
                draw() {
                    ctx.fillStyle = 'rgba(255, 255, 255, 0.4)'; /* Reverted to original subtle opacity */
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, 1.5, 0, Math.PI * 2); /* Reverted to original dot size */
                    ctx.fill();
                }
            }

            let nodes = [];
            let nodeCount = Math.floor((window.innerWidth * window.innerHeight) / 15000); /* Original lower density */
            for (let i = 0; i < nodeCount; i++) {
                nodes.push(new Node());
            }

            function animate() {
                ctx.clearRect(0, 0, width, height);
                
                nodes.forEach(node => {
                    node.update();
                    node.draw();
                });

                for (let i = 0; i < nodes.length; i++) {
                    for (let j = i + 1; j < nodes.length; j++) {
                        let dx = nodes[i].x - nodes[j].x;
                        let dy = nodes[i].y - nodes[j].y;
                        let distance = Math.sqrt(dx * dx + dy * dy);
                        
                        if (distance < 150) { /* Original shorter connection distance */
                            ctx.strokeStyle = `rgba(255, 255, 255, ${0.15 * (1 - distance / 150)})`; /* Original faint line opacity */
                            ctx.lineWidth = 0.8; /* Original thin line width */
                            ctx.beginPath();
                            ctx.moveTo(nodes[i].x, nodes[i].y);
                            ctx.lineTo(nodes[j].x, nodes[j].y);
                            ctx.stroke();
                        }
                    }
                }
                
                requestAnimationFrame(animate);
            }
            animate();
        })();
        </script>
        
        <!-- PTR-005 & 006: INTERACTION SCRIPTS -->
        <script id="ea-v2-interactions">
        document.addEventListener('DOMContentLoaded', function() {
            // 1. SCROLL REVEAL OBSERVER
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('ea-reveal-visible');
                    }
                });
            }, { threshold: 0.1 });

            // Auto-apply reveal class to key elements
            const revealElements = document.querySelectorAll('.wp-block-column, h1, h2, h3, .wp-block-image, .service-card, .portfolio-item');
            revealElements.forEach(el => {
                el.classList.add('ea-reveal');
                observer.observe(el);
            });

            // 2. CUSTOM "VIEW" CURSOR
            const cursor = document.createElement('div');
            cursor.id = 'ea-v2-cursor';
            document.body.appendChild(cursor);

            let mouseX = window.innerWidth / 2;
            let mouseY = window.innerHeight / 2;
            
            // Fast direct position update for zero lag
            document.addEventListener('mousemove', (e) => {
                mouseX = e.clientX;
                mouseY = e.clientY;
                cursor.style.left = mouseX + 'px';
                cursor.style.top = mouseY + 'px';
            });

            // Hover states for normal links (shrink cursor to let button effects shine)
            const links = document.querySelectorAll('a, button, .wp-block-button__link');
            links.forEach(el => {
                el.addEventListener('mouseenter', () => document.body.classList.add('hovering-link'));
                el.addEventListener('mouseleave', () => document.body.classList.remove('hovering-link'));
            });

            // Hover states for "View" elements (expand cursor to show VIEW text)
            const viewElements = document.querySelectorAll('.wp-block-image, .service-card, .portfolio-item');
            viewElements.forEach(el => {
                el.addEventListener('mouseenter', () => document.body.classList.add('hovering-view'));
                el.addEventListener('mouseleave', () => document.body.classList.remove('hovering-view'));
            });
        });
        </script>
        <?php
    }
}, 100);

/* ═══════════════════════════════════════════════════════════════════
   EA-ProductFill-A01: URL-Parameter Product Auto-Fill System
   Status: ACTIVE (Global)
   Description: Automatically pre-fills Contact Form 7 fields based on 
   ?product= or ?service= URL parameters.
   ═══════════════════════════════════════════════════════════════════ */
add_action('wp_footer', function() {
    if (isset($_GET['premium_v2']) || isset($_COOKIE['ea_premium_v2_active']) || is_page_template('homepage-preview-v2.php')) {
    ?>
    <script id="ea-product-fill-a01">
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const product = urlParams.get('product') || urlParams.get('service') || urlParams.get('subject');
        
        if (product) {
            // Locate all Contact Form 7 instances on the page
            const cf7Forms = document.querySelectorAll('.wpcf7-form');
            cf7Forms.forEach(form => {
                // 1. Try to find a specifically named subject/product field first
                let targetInput = form.querySelector('input[name="product"], input[name="service"], input[name="subject"], input[name="your-subject"]');
                
                // 2. Fallback: Find the first generic text field that isn't name, email, or phone
                if (!targetInput) {
                    const textInputs = form.querySelectorAll('input[type="text"]');
                    for (let input of textInputs) {
                        const name = input.name.toLowerCase();
                        if (!name.includes('name') && !name.includes('email') && !name.includes('phone') && !name.includes('tel')) {
                            targetInput = input;
                            break;
                        }
                    }
                }
                
                if (targetInput) {
                    // Pre-fill the field with the decoded product name
                    targetInput.value = "Inquiry regarding: " + decodeURIComponent(product);
                    
                    // Trigger native DOM events so CF7 and browser autofill recognize the change
                    targetInput.dispatchEvent(new Event('input', { bubbles: true }));
                    targetInput.dispatchEvent(new Event('change', { bubbles: true }));
                    
                    // Visual confirmation (optional premium flash effect)
                    targetInput.style.transition = "background-color 0.5s ease";
                    targetInput.style.backgroundColor = "rgba(43, 77, 112, 0.1)";
                    setTimeout(() => { targetInput.style.backgroundColor = ""; }, 1000);
                }
            });
        }
    });
    </script>
    <?php
    }
}, 101);

/*

 * Loads the Options Panel

 *

 * If you're loading from a child theme use stylesheet_directory

 * instead of template_directory

 */

/**
 * Declare WooCommerce theme support so WC uses its standard template loading
 * instead of injecting a synthetic dummy-page post into the main query.
 * This was the root cause of the category archive showing a single fake
 * "page" post (ID 0) instead of real products.
 */
add_action( 'after_setup_theme', function () {
    add_theme_support( 'woocommerce' );
} );

/* ── EA Home Curation: central manual data source (EA-HOME-CURATION-003) ── */
require_once get_stylesheet_directory() . '/inc/ea-home-curation.php';

/* ── Ensure /blog page and seed sample posts (EA-HOMEPAGE-FINAL-ADD-001) ── */
add_action( 'init', function () {
    if ( is_admin() && ! wp_doing_ajax() ) {
        return;
    }

    // Ensure Blog page exists at /blog/
    $blog_page = get_page_by_path( 'blog', OBJECT, 'page' );
    if ( ! $blog_page ) {
        wp_insert_post( [
            'post_type'    => 'page',
            'post_title'   => 'Blog',
            'post_name'    => 'blog',
            'post_status'  => 'publish',
            'post_content' => 'Printing, signage, branding and event insights for UAE businesses.',
        ] );
    }

    // Ensure sample blog posts exist (seed once only)
    if ( get_option( 'ea_sample_posts_seeded_v1' ) ) {
        return;
    }

    $sample_posts = [
        'How to Choose the Right Signage Company in Dubai' => 'Choosing the right signage partner in Dubai starts with checking in-house production capability, installation experience, material quality, and realistic delivery timelines. Reliable providers will guide you on visibility, durability, and budget-fit solutions for both indoor and outdoor use.',
        'Banner Printing in Dubai: What Businesses Should Know' => 'Banner printing in Dubai works best when businesses choose the correct material for the location: PVC for general use, mesh for windy zones, and fabric for premium indoor branding. Artwork quality, finishing options, and installation method all impact final visibility and longevity.',
        'Vehicle Branding in Dubai: Benefits for Growing Businesses' => 'Vehicle branding turns daily movement into continuous brand exposure across Dubai. Well-executed wraps improve recall, build credibility, and create cost-effective awareness compared to short-run ad campaigns. Material quality and installation precision are critical for long-term performance.',
        'Exhibition Printing Guide for UAE Businesses' => 'For UAE exhibitions, success depends on planning print assets early: backdrops, counters, brochures, wayfinding, and branded giveaways. Consistent visual hierarchy, readable messaging, and proper file setup help ensure your booth performs well under venue lighting and time pressure.',
    ];

    $cat_id = (int) get_cat_ID( 'Insights' );
    if ( $cat_id <= 0 ) {
        $created = wp_insert_term( 'Insights', 'category' );
        if ( ! is_wp_error( $created ) && ! empty( $created['term_id'] ) ) {
            $cat_id = (int) $created['term_id'];
        }
    }

    foreach ( $sample_posts as $title => $content ) {
        $existing = get_page_by_title( $title, OBJECT, 'post' );
        if ( $existing ) {
            continue;
        }

        wp_insert_post( [
            'post_type'     => 'post',
            'post_status'   => 'publish',
            'post_title'    => $title,
            'post_content'  => $content,
            'post_excerpt'  => wp_trim_words( $content, 24, '…' ),
            'post_category' => $cat_id > 0 ? [ $cat_id ] : [],
        ] );
    }

    update_option( 'ea_sample_posts_seeded_v1', 1, false );
}, 20 );



define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );

require_once dirname( __FILE__ ) . '/inc/options-framework.php';

/**
 * Redirect removed COVID-19 category to main shop page (301 permanent).
 * Works at the WordPress level — reliable regardless of server/.htaccess config.
 */
add_action( 'template_redirect', function () {
    if ( is_tax( 'product_cat', 'covid19-printing-services' ) ) {
        wp_redirect( home_url( '/shop/' ), 301 );
        exit;
    }
} );

/**
 * Ensure product_cat taxonomy archives query products correctly.
 * Sets post_type, pagination, and sort order for category archive pages.
 */
add_action( 'pre_get_posts', function ( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }
    if ( $query->is_tax( 'product_cat' ) ) {
        $query->set( 'post_type',      'product' );
        $query->set( 'post_status',    'publish' );
        $query->set( 'posts_per_page', 24 );
        $query->set( 'orderby',        'title' );
        $query->set( 'order',          'ASC' );
    }
}, 99 );

/**
 * Use premium product template for ALL WooCommerce single product pages.
 * The _wp_page_template meta is set via migration but WooCommerce ignores it;
 * this filter forces loading of single-product-premium.php instead.
 */
add_filter( 'template_include', function ( $template ) {
    if ( is_front_page() || is_home() ) {
        $home_tpl = get_stylesheet_directory() . '/index.php';
        if ( file_exists( $home_tpl ) ) {
            return $home_tpl;
        }
    }

    if ( is_singular( 'product' ) ) {
        $premium = get_stylesheet_directory() . '/single-product-premium.php';
        if ( file_exists( $premium ) ) {
            return $premium;
        }
    }
    /* Premium category archive for WooCommerce product_cat taxonomy */
    if ( is_tax( 'product_cat' ) ) {
        $cat_tpl = get_stylesheet_directory() . '/taxonomy-product_cat.php';
        if ( file_exists( $cat_tpl ) ) {
            return $cat_tpl;
        }
    }
    return $template;
}, 99 );

add_action( 'template_redirect', function () {
    if ( is_admin() || wp_doing_ajax() || is_feed() ) {
        return;
    }

    // Wasmer's PHP runtime serves the homepage correctly through template_include,
    // but the early include+exit path can terminate the response before the body
    // is flushed. Let the normal template loader handle the homepage there.
    if ( getenv( 'WASMER_APP_ID' ) ) {
        return;
    }

    if ( is_front_page() || is_home() ) {
        $home_tpl = get_stylesheet_directory() . '/index.php';
        if ( file_exists( $home_tpl ) ) {
            include $home_tpl;
            exit;
        }
    }
}, 1 );

/* Add 'ea-dark-page' body class on homepage and product_cat archives for dark header styling */
add_filter( 'body_class', function ( $classes ) {
    if ( is_front_page() || is_home() || is_tax( 'product_cat' ) || is_page( 'catalogue' ) ) {
        $classes[] = 'ea-dark-page';
    }
    return $classes;
} );

/**
 * Preload critical hero background image on homepage for improved LCP score.
 */
add_action( 'wp_head', function () {
    if ( ! is_front_page() && ! is_home() ) return;
    echo '<link rel="preload" as="image" href="' . esc_url( content_url( 'uploads/2022/03/3D-Aluminum-Signage-2.jpg' ) ) . '" fetchpriority="high">' . "\n";
}, 1 );

/**
 * Category meta description fallback for product archives.
 * Priority: Yoast term meta -> term description -> curated slug fallback.
 */
function ea_phase3d_product_cat_meta_description(): string {
    if ( ! is_tax( 'product_cat' ) ) {
        return '';
    }

    $term = get_queried_object();
    if ( ! $term || is_wp_error( $term ) || empty( $term->term_id ) ) {
        return '';
    }

    $meta = trim( (string) get_term_meta( (int) $term->term_id, '_yoast_wpseo_metadesc', true ) );
    if ( $meta !== '' ) {
        return $meta;
    }

    $termDesc = trim( wp_strip_all_tags( (string) term_description( (int) $term->term_id, 'product_cat' ) ) );
    if ( $termDesc !== '' ) {
        return wp_trim_words( $termDesc, 26, '' );
    }

    $slug = isset( $term->slug ) ? sanitize_title( (string) $term->slug ) : '';

    return sprintf(
        '%s services in Dubai by Efficient Advertising. Premium quality production, quick turnaround, and UAE-wide delivery.',
        wp_strip_all_tags( (string) $term->name )
    );
}

// Use Yoast output channel when available so only one description tag is emitted.
add_filter( 'wpseo_metadesc', function ( $description ) {
    if ( ! is_tax( 'product_cat' ) ) {
        return $description;
    }
    $description = trim( (string) $description );
    if ( $description !== '' ) {
        return $description;
    }
    return ea_phase3d_product_cat_meta_description();
}, 99 );

// Fallback for cases where SEO plugin doesn't print a description tag.
add_action( 'wp_head', function () {
    if ( ! is_tax( 'product_cat' ) || defined( 'WPSEO_VERSION' ) ) {
        return;
    }
    $meta = trim( ea_phase3d_product_cat_meta_description() );
    if ( $meta === '' ) {
        return;
    }
    echo '<meta name="description" content="' . esc_attr( $meta ) . '">' . "\n";
}, 5 );

/* ── EA-SEO-REFINEMENT-024: Refined Homepage + Category SEO metadata ── */

// Homepage title (Yoast channel)
add_filter( 'wpseo_title', function ( $title ) {
    if ( is_front_page() ) {
        return 'Premium Exhibition, Signage & Branding Company in Dubai | Efficient Advertising';
    }
    return $title;
}, 20 );

// Homepage meta description (Yoast channel)
add_filter( 'wpseo_metadesc', function ( $desc ) {
    if ( is_front_page() ) {
        return 'Efficient Advertising delivers exhibition stands, event branding, signage, hoardings, vehicle branding and large-format printing services across Dubai and the UAE.';
    }
    return $desc;
}, 10 );

// Homepage meta description fallback (no Yoast)
add_action( 'wp_head', function () {
    if ( ! is_front_page() || defined( 'WPSEO_VERSION' ) ) return;
    echo '<meta name="description" content="' . esc_attr( 'Efficient Advertising delivers exhibition stands, event branding, signage, hoardings, vehicle branding and large-format printing services across Dubai and the UAE.' ) . '">' . "\n";
}, 4 );

// Category title overrides (Yoast channel)
add_filter( 'wpseo_title', function ( $title ) {
    if ( ! is_tax( 'product_cat' ) ) return $title;
    $term = get_queried_object();
    $slug = isset( $term->slug ) ? $term->slug : '';
    $cat_titles = [
        'exhibitions-events'   => 'Exhibition Stand Design & Fabrication in Dubai | Efficient Advertising',
        'signage'              => 'Custom Signage Solutions in Dubai | Efficient Advertising',
        'vehicle-branding'     => 'Vehicle Branding & Fleet Graphics in Dubai | Efficient Advertising',
        'banners-large-format' => 'Large Format & Hoarding Printing in Dubai | Efficient Advertising',
    ];
    return isset( $cat_titles[ $slug ] ) ? $cat_titles[ $slug ] : $title;
}, 20 );

// Category meta description overrides (Yoast channel — augments existing ea_phase3d_product_cat_meta_description)
add_filter( 'wpseo_metadesc', function ( $desc ) {
    if ( ! is_tax( 'product_cat' ) ) return $desc;
    if ( is_front_page() ) return $desc;
    $term = get_queried_object();
    $slug = isset( $term->slug ) ? $term->slug : '';
    $cat_descs = [
        'exhibitions-events'   => 'Custom exhibition stand design, fabrication and installation in Dubai. From portable displays to full modular builds — trade shows, expos and corporate events across the UAE.',
        'signage'              => 'Custom signage solutions in Dubai including 3D letters, illuminated signs, acrylic boards and aluminium fabrication — produced in-house and installed UAE-wide.',
        'vehicle-branding'     => 'Professional vehicle branding and fleet graphics in Dubai. Full wraps, partial wraps, and magnetic signage for cars, vans and trucks — UAE-wide installation.',
        'banners-large-format' => 'Large format and hoarding printing services in Dubai. Vinyl banners, building hoardings, roll-ups and fabric displays — same-day printing available.',
    ];
    if ( isset( $cat_descs[ $slug ] ) ) return $cat_descs[ $slug ];
    if ( trim( (string) $desc ) !== '' ) return $desc;
    return ea_phase3d_product_cat_meta_description();
}, 20 );



// Loads options.php from child or parent theme

$optionsfile = locate_template( 'options.php' );

load_template( $optionsfile );



function optionsframework_custom_scripts() { ?>



<script type="text/javascript">

jQuery(document).ready(function() {



	jQuery('#example_showhidden').click(function() {

  		jQuery('#section-example_text_hidden').fadeToggle(400);

	});



	if (jQuery('#example_showhidden:checked').val() !== undefined) {

		jQuery('#section-example_text_hidden').show();

	}



});

</script>



<?php

}

function add_link_atts($atts) {

  $atts['class'] = "nav-link";

  return $atts;

}

add_filter( 'nav_menu_link_attributes', 'add_link_atts');



add_theme_support( 'post-thumbnails' );

register_nav_menus( array(

	'header_menu' => 'Header Menu',

	'footer_menu' => 'Footer Menu'

) );

/**
 * Enqueue theme scripts and styles.
 * Properly enqueues CSS and JS files for better performance and maintainability.
 */
function ea_enqueue_theme_scripts() {
    // Enqueue the main stylesheet (already loaded in header.php, but this is the proper way)
    // wp_enqueue_style( 'ea-main-style', get_stylesheet_uri() );

    // Enqueue mobile menu JavaScript
    wp_enqueue_script(
        'ea-mobile-menu',
        get_template_directory_uri() . '/js/ea-mobile-menu.js',
        array('jquery'), // Depends on jQuery
        '1.0.0',
        true // Load in footer
    );
}
add_action( 'wp_enqueue_scripts', 'ea_enqueue_theme_scripts' );



register_sidebar( array(

        'name' => __( 'Sidebar', 'theme-slug' ),

        'id' => 'sidebar',

		'class'=> 'list_1',

        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),

		'before_widget'=>'',

		'after_widget'=>'',

        'before_title' => '<h2>',

        'after_title' => '</h2>',

    ) );



register_sidebar( array(

	'name' => __( 'Blog Sidebar', 'theme-slug' ),

	'id' => 'sidebar-blog',

	'class'=> 'list_1',

	'description' => __( 'Widgets in this area will be shown on all pages of blog.', 'theme-slug' ),

	'before_widget'=>'<div class="widget">',

	'after_widget'=>'</div>',

	'before_title' => '<h2>',

	'after_title' => '</h2>',

) );



register_sidebar( array(

	'name' => __( 'News Sidebar', 'theme-slug' ),

	'id' => 'sidebar-news',

	'class'=> 'list_1',

	'description' => __( 'Widgets in this area will be shown on all pages of news.', 'theme-slug' ),

	'before_widget'=>'<div class="widget">',

	'after_widget'=>'</div>',

	'before_title' => '<h4>',

	'after_title' => '</h4>',

) );



register_sidebar( array(

    'name' => __( 'Any Share', 'theme-slug' ),

    'id' => 'any_share',  

    'class'=> 'list_1',

    'description' => __( 'Widgets in this area will be shown on all pages of news.', 'theme-slug' ),

    'before_widget'=>'<div class="widget">',

    'after_widget'=>'</div>',

    'before_title' => '<h4>',

    'after_title' => '</h4>',

) );



	 

 



function custom_wp_title( $title, $sep ) {

	global $paged, $page;



	if ( is_feed() ) {

		return $title;

	}



	// Add the site name.

	$title .= get_bloginfo( 'name', 'display' );



	// Add the site description for the home/front page.

	$site_description = get_bloginfo( 'description', 'display' );

	if ( $site_description && ( is_home() || is_front_page() ) ) {

		$title = "$title $sep $site_description";

	}



	// Add a page number if necessary.

	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {

		$title = "$title $sep " . sprintf( __( 'Page %s', 'custom' ), max( $paged, $page ) );

	}



	return $title;

}

add_filter( 'wp_title', 'custom_wp_title', 10, 2 );



function remove_core_updates(){

        global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);

    }

    add_filter('pre_site_transient_update_core','remove_core_updates');

    add_filter('pre_site_transient_update_plugins','remove_core_updates');

    add_filter('pre_site_transient_update_themes','remove_core_updates');





add_filter('use_block_editor_for_post', '__return_false', 10);





function orderbypost($query) {

  if ( !is_admin() && $query->is_main_query() ) {



    if (is_post_type_archive('product','slider')) {

      $query->set('orderby', 'date' );

      $query->set('order', 'ASC' );

    }



  }

}



add_action('pre_get_posts','orderbypost');





function twentytwelve_comment( $comment, $args, $depth ) {

        $GLOBALS['comment'] = $comment;

      switch ( $comment->comment_type ) :

                case 'pingback' :

              case 'trackback' :

             // Display trackbacks differently than normal comments.

       ?>

       <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

                <p><?php _e( 'Pingback:', 'twentytwelve' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?></p>

        <?php

                       break;

                default :

	                // Proceed with normal comments.

                global $post;

	        ?>

       <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

                <article id="comment-<?php comment_ID(); ?>" class="comment">

                       <header class="comment-meta comment-author vcard">

                               <?php

                                       echo get_avatar( $comment, 44 );

	                                        printf( '<cite class="fn">%1$s %2$s</cite>',

	                                                get_comment_author_link(),

                                                // If current post author is also comment author, make it known visually.

                                                ( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'twentytwelve' ) . '</span>' : ''

                                        );

	                                        printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',

                                                esc_url( get_comment_link( $comment->comment_ID ) ),

	                                                get_comment_time( 'c' ),

	                                                /* translators: 1: date, 2: time */

                                                sprintf( __( '%1$s at %2$s', 'twentytwelve' ), get_comment_date(), get_comment_time() )

	                                        );

                                ?>

                       </header><!-- .comment-meta -->



                        <?php if ( '0' == $comment->comment_approved ) : ?>

                                <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentytwelve' ); ?></p>

                        <?php endif; ?>

	

                        <section class="comment-content comment">

	                                <?php comment_text(); ?>

                                <?php edit_comment_link( __( 'Edit', 'twentytwelve' ), '<p class="edit-link">', '</p>' ); ?>

                        </section><!-- .comment-content -->



                        <div class="reply">

                                <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'twentytwelve' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

                        </div><!-- .reply -->

                </article><!-- #comment-## -->

	        <?php

                break;

	        endswitch; // end comment_type check

	}


function searchFilter($query) {
    if ( $query->is_search && ! is_admin() && $query->is_main_query() ) {
        $query->set( 'post_type', array( 'product' ) );
        $query->set( 'post_status', 'publish' );
        $query->set( 'posts_per_page', 24 );
    }
    return $query;
}
add_filter('pre_get_posts','searchFilter');


function space_change_custom_taxonomy_slug_args( $taxonomy, $object_type, $args ){
    if( 'product_category' == $taxonomy ){ // Instead of the "old-slug", add current slug, which you want to change.
        remove_action( current_action(), __FUNCTION__ );
        $args['rewrite'] = array( 'slug' => 'product-category' ); // Instead of the "new-slug", add a new slug name.
        register_taxonomy( $taxonomy, $object_type, $args );
    }
}
add_action( 'registered_taxonomy', 'space_change_custom_taxonomy_slug_args', 10, 3 );


// =============================================================================
// Unified Custom Contact Form & Lead Engine (EA-FORM-FIX-034)
// =============================================================================

/**
 * Helper: Retrieve the client IP address reliably.
 */
function ea_get_client_ip() {
    $ip_keys = array( 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR' );
    foreach ( $ip_keys as $key ) {
        if ( isset( $_SERVER[ $key ] ) ) {
            foreach ( explode( ',', $_SERVER[ $key ] ) as $ip ) {
                $ip = trim( $ip );
                if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) !== false ) {
                    return $ip;
                }
            }
        }
    }
    return isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( $_SERVER['REMOTE_ADDR'] ) : '127.0.0.1';
}

/**
 * Helper: Check if input string is bot-like keyboard mashing or garbage.
 */
function ea_is_garbage_input( $str ) {
    $str_clean = strtolower( trim( $str ) );
    if ( empty( $str_clean ) ) {
        return true;
    }
    
    // Check 1: Repeating characters of 4 or more (e.g. "aaaa", "hhhhhh")
    if ( preg_match( '/(.)\1{3,}/', $str_clean ) ) {
        return true;
    }
    
    // Check 2: Common bot/mashing test values
    $banned = array( 'asdf', 'qwer', 'zxcv', 'test', 'testing', 'hhhh', 'zzzz', 'aaaa', 'admin', 'garbage', 'asdfasdf' );
    foreach ( $banned as $ban ) {
        if ( strpos( $str_clean, $ban ) !== false ) {
            return true;
        }
    }
    
    // Check 3: Name length too short or composed only of symbols
    if ( strlen( $str_clean ) < 2 ) {
        return true;
    }
    
    return false;
}

/**
 * Helper: Ensure session cookie and return unique session ID.
 */
function ea_get_form_session_id() {
    $cookie_name = 'ea_form_session';
    if ( isset( $_COOKIE[ $cookie_name ] ) ) {
        return sanitize_text_field( wp_unslash( $_COOKIE[ $cookie_name ] ) );
    }
    $session_id = wp_generate_password( 32, false );
    setcookie( $cookie_name, $session_id, time() + ( 24 * HOUR_IN_SECONDS ), COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true );
    $_COOKIE[ $cookie_name ] = $session_id; // set in current execution context
    return $session_id;
}

/**
 * AJAX: Generate or refresh mathematical CAPTCHA dynamically.
 */
add_action( 'wp_ajax_nopriv_ea_get_captcha', 'ea_get_captcha_handler' );
add_action( 'wp_ajax_ea_get_captcha',        'ea_get_captcha_handler' );
function ea_get_captcha_handler() {
    $session_id    = ea_get_form_session_id();
    $num1          = rand( 1, 9 );
    $num2          = rand( 1, 9 );
    $answer        = $num1 + $num2;
    $transient_key = 'ea_captcha_' . md5( $session_id );
    
    set_transient( $transient_key, $answer, HOUR_IN_SECONDS );
    
    wp_send_json_success( array(
        'question' => "{$num1} + {$num2} = ?"
    ) );
}

/**
 * AJAX: Generate a 6-digit email OTP transient and send email.
 */
add_action( 'wp_ajax_nopriv_ea_send_otp', 'ea_send_otp_handler' );
add_action( 'wp_ajax_ea_send_otp',        'ea_send_otp_handler' );
function ea_send_otp_handler() {
    if ( ! check_ajax_referer( 'ea_form_nonce', 'nonce', false ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed. Please refresh page.' ) );
    }

    $email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Please enter a valid email address first.' ) );
    }

    // Rate-limit OTP requests per IP to prevent email spamming (Max 1 request per 60 seconds)
    $ip        = ea_get_client_ip();
    $rl_key    = 'ea_otp_rl_' . md5( $ip );
    $last_sent = get_transient( $rl_key );
    if ( $last_sent ) {
        wp_send_json_error( array( 'message' => 'Please wait 60 seconds before requesting another code.' ) );
    }
    set_transient( $rl_key, time(), 60 );

    $otp           = strval( rand( 100000, 999999 ) );
    $transient_key = 'ea_otp_' . md5( strtolower( $email ) );
    set_transient( $transient_key, $otp, 10 * MINUTE_IN_SECONDS );

    $subject = 'Your Verification Code – Efficient Advertising';
    $body    = '<div style="background:#0F172A;padding:40px 20px;font-family:sans-serif;color:#fff;text-align:center;border-radius:12px;max-width:500px;margin:0 auto;">'
             . '  <img src="https://efficientadvt.com/wp-content/uploads/2020/09/Logo-1.png" style="max-height:50px;margin-bottom:24px;" alt="Efficient Advertising">'
             . '  <h2 style="font-size:24px;color:#D4A73A;margin:0 0 16px;">Email Verification</h2>'
             . '  <p style="font-size:15px;color:#cbd5e1;line-height:1.5;margin-bottom:28px;">Use the verification code below to authorize your quote/contact request:</p>'
             . '  <div style="background:#1E293B;padding:18px;border-radius:8px;font-size:36px;font-weight:700;letter-spacing:8px;color:#FFBA09;display:inline-block;margin-bottom:28px;border:1px solid rgba(255,186,9,0.25);">' . esc_html( $otp ) . '</div>'
             . '  <p style="font-size:12px;color:#64748b;margin:0;">This verification code is valid for exactly 10 minutes. Please do not share this code.</p>'
             . '</div>';
             
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Efficient Advertising <info@efficientadvt.com>',
    );

    if ( wp_mail( $email, $subject, $body, $headers ) ) {
        wp_send_json_success( array( 'message' => 'Verification code sent! Please check your inbox (and spam folder).' ) );
    } else {
        delete_transient( $transient_key );
        wp_send_json_error( array( 'message' => 'Could not send verification email. Please contact us on WhatsApp.' ) );
    }
}

/**
 * AJAX: Verify the 6-digit email OTP transient for the Contact Email Link.
 */
add_action( 'wp_ajax_nopriv_ea_verify_email_modal_otp', 'ea_verify_email_modal_otp_handler' );
add_action( 'wp_ajax_ea_verify_email_modal_otp',        'ea_verify_email_modal_otp_handler' );
function ea_verify_email_modal_otp_handler() {
    $email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
    $otp_val = isset( $_POST['otp'] )   ? sanitize_text_field( wp_unslash( $_POST['otp'] ) ) : '';

    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Invalid email address.' ) );
    }

    $otp_key    = 'ea_otp_' . md5( strtolower( $email ) );
    $stored_otp = get_transient( $otp_key );

    if ( ! $stored_otp || $stored_otp !== $otp_val ) {
        wp_send_json_error( array( 'message' => 'Invalid or expired verification code.' ) );
    }

    // Code matches, burn OTP transient immediately
    delete_transient( $otp_key );

    wp_send_json_success( array( 'message' => 'Verified successfully.' ) );
}


/**
 * AJAX: Core secure submission handler for all contact forms.
 */
add_action( 'wp_ajax_nopriv_ea_contact_form_submit', 'ea_contact_form_submit_handler' );
add_action( 'wp_ajax_ea_contact_form_submit',        'ea_contact_form_submit_handler' );
function ea_contact_form_submit_handler() {
    // 1. Nonce Security Check
    if ( ! isset( $_POST['ea_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ea_nonce'] ) ), 'ea_contact_submit' ) ) {
        wp_send_json_error( array( 'message' => 'Security token expired. Please refresh the page and try again.' ) );
    }

    // 1.5 Google reCAPTCHA v3 Verification
    if ( empty( $_POST['ea_recaptcha_response'] ) ) {
        wp_send_json_error( array( 'message' => 'Anti-spam validation failed. Please refresh the page.' ) );
    }
    
    $recaptcha_secret = '6LdE2d4sAAAAAFY4rCV3ZY6SIUuDbDVvehd4x2C6';
    $recaptcha_response = sanitize_text_field( wp_unslash( $_POST['ea_recaptcha_response'] ) );
    
    $verify_url = 'https://www.google.com/recaptcha/api/siteverify';
    $verify_response = wp_remote_post( $verify_url, array(
        'body' => array(
            'secret'   => $recaptcha_secret,
            'response' => $recaptcha_response,
            'remoteip' => ea_get_client_ip()
        )
    ) );
    
    if ( is_wp_error( $verify_response ) ) {
        wp_send_json_error( array( 'message' => 'Could not connect to reCAPTCHA server.' ) );
    }
    
    $verify_body = wp_remote_retrieve_body( $verify_response );
    $verify_data = json_decode( $verify_body );
    
    if ( ! $verify_data || ! isset( $verify_data->success ) || ! $verify_data->success ) {
        wp_send_json_error( array( 'message' => 'Automated spam detected. Submission blocked.' ) );
    }
    
    // Check score (0.0 is bot, 1.0 is a good interaction)
    if ( isset( $verify_data->score ) && $verify_data->score < 0.5 ) {
        wp_send_json_error( array( 'message' => 'Your submission was flagged as spam due to low score.' ) );
    }

    // 2. Invisible Honeypot Spam Block
    if ( ! empty( $_POST['ea_hp_honeypot'] ) ) {
        // Silently succeed to trick bots, but do not process or send anything!
        wp_send_json_success( array( 'message' => 'Your enquiry has been successfully registered.' ) );
        wp_die();
    }

    // 3. IP Submission Rate Limiting (Max 3 submissions per 10 minutes)
    $ip     = ea_get_client_ip();
    $rl_key = 'ea_sub_rl_' . md5( $ip );
    $times  = get_transient( $rl_key );
    if ( ! is_array( $times ) ) {
        $times = array();
    }
    $now = time();
    // Filter timestamps inside 10 minutes (600s)
    $times = array_filter( $times, function( $t ) use ( $now ) {
        return ( $now - $t ) < 600;
    });
    if ( count( $times ) >= 3 ) {
        wp_send_json_error( array( 'message' => 'Submission rate limit exceeded. Please wait a few minutes and try again.' ) );
    }
    $times[] = $now;
    set_transient( $rl_key, $times, 600 );

    // 4. Input Sanitization
    $name    = isset( $_POST['ea_name'] )    ? sanitize_text_field( wp_unslash( $_POST['ea_name'] ) ) : '';
    $email   = isset( $_POST['ea_email'] )   ? sanitize_email( wp_unslash( $_POST['ea_email'] ) ) : '';
    $phone   = isset( $_POST['ea_phone'] )   ? sanitize_text_field( wp_unslash( $_POST['ea_phone'] ) ) : '';
    $product = isset( $_POST['ea_product'] ) ? sanitize_text_field( wp_unslash( $_POST['ea_product'] ) ) : '';
    $msg     = isset( $_POST['ea_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ea_message'] ) ) : '';
    $captcha = isset( $_POST['ea_captcha'] ) ? sanitize_text_field( wp_unslash( $_POST['ea_captcha'] ) ) : '';
    $otp_val = isset( $_POST['ea_otp'] )     ? sanitize_text_field( wp_unslash( $_POST['ea_otp'] ) ) : '';
    $page_url= isset( $_POST['ea_page_url'] )? esc_url_raw( wp_unslash( $_POST['ea_page_url'] ) ) : home_url();

    // 5. Hard Validation Rules
    
    // Rule 5.1: Validate Name
    if ( empty( $name ) || strlen( $name ) < 2 || ea_is_garbage_input( $name ) ) {
        wp_send_json_error( array( 'message' => 'Please enter a valid, professional name.' ) );
    }

    // Rule 5.2: At least one contact mechanism (valid Email OR Phone)
    if ( empty( $email ) && empty( $phone ) ) {
        wp_send_json_error( array( 'message' => 'Please provide at least one contact method: a valid email or phone number.' ) );
    }

    // Rule 5.3: Validate Email & OTP (If email is provided, verification code is mandatory)
    if ( ! empty( $email ) ) {
        if ( ! is_email( $email ) ) {
            wp_send_json_error( array( 'message' => 'Please enter a valid, active email address.' ) );
        }
        $otp_key    = 'ea_otp_' . md5( strtolower( $email ) );
        $stored_otp = get_transient( $otp_key );
        if ( ! $stored_otp || $stored_otp !== $otp_val ) {
            wp_send_json_error( array( 'message' => 'Invalid or expired email verification code. Please request a new code.' ) );
        }
        delete_transient( $otp_key ); // Code matches, burn OTP transient immediately
    }

    // Rule 5.4: Validate Phone (If provided, must be >= 7 digits and not repeated numbers)
    if ( ! empty( $phone ) ) {
        // Strip out spaces, hyphens, pluses, parentheses to count physical digits
        $digits_only = preg_replace( '/\D/', '', $phone );
        if ( strlen( $digits_only ) < 7 ) {
            wp_send_json_error( array( 'message' => 'Please enter a valid phone number (minimum 7 digits).' ) );
        }
        if ( preg_match( '/^(\d)\1{5,}$/', $digits_only ) ) {
            wp_send_json_error( array( 'message' => 'Please avoid using fake or repetitive phone numbers.' ) );
        }
    }

    // Rule 5.5: Validate Message
    if ( empty( $msg ) || strlen( $msg ) < 10 || ea_is_garbage_input( $msg ) ) {
        wp_send_json_error( array( 'message' => 'Please write a descriptive message detailing your custom requirement (min 10 characters).' ) );
    }

    // Rule 5.6: Server-side CAPTCHA Check
    $session_id  = ea_get_form_session_id();
    $captcha_key = 'ea_captcha_' . md5( $session_id );
    $correct_ans = get_transient( $captcha_key );
    if ( ! $correct_ans || intval( $captcha ) !== intval( $correct_ans ) ) {
        wp_send_json_error( array( 'message' => 'Incorrect math CAPTCHA answer. Please try again.' ) );
    }
    delete_transient( $captcha_key ); // burn captcha transient immediately

    // 6. Secure File Upload Auditing (Allowed ONLY on contact page when provided)
    $attachments = array();
    $uploaded_filepath = '';
    
    if ( isset( $_FILES['ea_file'] ) && ! empty( $_FILES['ea_file']['name'] ) ) {
        $file = $_FILES['ea_file'];
        
        // Ensure no PHP upload errors
        if ( $file['error'] !== UPLOAD_ERR_OK ) {
            wp_send_json_error( array( 'message' => 'File upload error occurred. Please try a different file.' ) );
        }

        // Validate File Size (Strictly <= 10MB limit)
        $max_size = 10 * 1024 * 1024; // 10MB in bytes
        if ( $file['size'] > $max_size ) {
            wp_send_json_error( array( 'message' => 'File size exceeds the maximum 10MB limit.' ) );
        }

        // Validate File Extension / Mime-type
        $extension = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );
        $allowed_exts = array( 'jpg', 'jpeg', 'png', 'pdf', 'ai', 'eps', 'zip' );
        if ( ! in_array( $extension, $allowed_exts, true ) ) {
            wp_send_json_error( array( 'message' => 'Invalid file extension. Only JPG, PNG, PDF, AI, EPS, and ZIP files are allowed.' ) );
        }

        // Validate Mime-type
        $file_type = wp_check_filetype_and_ext( $file['tmp_name'], $file['name'] );
        $allowed_mimes = array(
            'image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 
            'application/postscript', 'application/zip', 'application/octet-stream', 'application/x-zip-compressed'
        );
        if ( ! in_array( $file_type['type'], $allowed_mimes, true ) && ! empty( $file_type['type'] ) ) {
            wp_send_json_error( array( 'message' => 'Invalid file type. Please upload a safe document/image.' ) );
        }

        // Secure file upload processing using WordPress Core
        if ( ! function_exists( 'wp_handle_upload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
        $upload_overrides = array( 'test_form' => false );
        $movefile = wp_handle_upload( $file, $upload_overrides );

        if ( $movefile && ! isset( $movefile['error'] ) ) {
            $uploaded_filepath = $movefile['file'];
            $attachments[]     = $uploaded_filepath;
        } else {
            wp_send_json_error( array( 'message' => 'Secure file upload failed: ' . $movefile['error'] ) );
        }
    }

    // 7. Deliver Corporate Emails

    // 7.1: Send Lead Notification to Administrator
    $admin_email = get_option( 'admin_email' );
    $lead_subject = '[NEW CUSTOM ENQUIRY] - Efficient Advertising Lead';
    
    $lead_body = '<div style="background:#0b1329;padding:40px 20px;font-family:sans-serif;color:#334155;max-width:600px;margin:0 auto;border-radius:12px;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1); border:1px solid #1e293b;">'
               . '  <div style="background:#1e293b;padding:24px;border-radius:8px;color:#fff;margin-bottom:24px;">'
               . '    <h2 style="font-size:22px;color:#FFBA09;margin:0 0 8px;font-weight:700;">New Commercial Lead</h2>'
               . '    <p style="font-size:14px;color:#94a3b8;margin:0;">Submitted from: <a href="' . esc_url( $page_url ) . '" style="color:#60a5fa;text-decoration:none;">' . esc_html( $page_url ) . '</a></p>'
               . '  </div>'
               . '  <div style="background:#fff;padding:24px;border-radius:8px;border:1px solid #e2e8f0;margin-bottom:24px;">'
               . '    <table style="width:100%;border-collapse:collapse;font-size:14px;line-height:1.6;">'
               . '      <tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:10px 0;font-weight:600;color:#0f172a;width:150px;">Full Name:</td><td style="padding:10px 0;color:#334155;">' . esc_html( $name ) . '</td></tr>'
               . '      <tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:10px 0;font-weight:600;color:#0f172a;">Email:</td><td style="padding:10px 0;color:#334155;">' . ( empty( $email ) ? '<em>Not Provided</em>' : esc_html( $email ) ) . '</td></tr>'
               . '      <tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:10px 0;font-weight:600;color:#0f172a;">Phone No:</td><td style="padding:10px 0;color:#334155;">' . ( empty( $phone ) ? '<em>Not Provided</em>' : esc_html( $phone ) ) . '</td></tr>'
               . '      <tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:10px 0;font-weight:600;color:#0f172a;">Requested Asset:</td><td style="padding:10px 0;color:#334155;">' . ( empty( $product ) ? '<em>General Enquiry</em>' : esc_html( $product ) ) . '</td></tr>'
               . '      <tr><td style="padding:10px 0;font-weight:600;color:#0f172a;vertical-align:top;">Message:</td><td style="padding:10px 0;color:#334155;white-space:pre-line;">' . esc_html( $msg ) . '</td></tr>'
               . '    </table>'
               . '  </div>'
               . '  <div style="font-size:11px;color:#64748b;text-align:center;">'
               . '    IP Address: ' . esc_html( $ip ) . ' | Submitted on: ' . esc_html( date( 'Y-m-d H:i:s' ) )
               . '  </div>'
               . '</div>';

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Efficient Advertising Leads <leads@efficientadvt.com>',
    );

    wp_mail( $admin_email, $lead_subject, $lead_body, $headers, $attachments );

    // 7.2: Send Confirmation Email to Client (Only if they provided an email)
    if ( ! empty( $email ) ) {
        $client_subject = 'We received your enquiry - Efficient Advertising';
        $client_body = '<div style="background:#0b1329;padding:40px 20px;font-family:sans-serif;color:#334155;max-width:600px;margin:0 auto;border-radius:12px;text-align:center;">'
                     . '  <img src="https://efficientadvt.com/wp-content/uploads/2020/09/Logo-1.png" style="max-height:50px;margin-bottom:24px;" alt="Efficient Advertising">'
                     . '  <div style="background:#fff;padding:32px;border-radius:8px;border:1px solid #e2e8f0;">'
                     . '    <h2 style="font-size:22px;color:#1e293b;margin:0 0 12px;font-weight:700;">Enquiry Received</h2>'
                     . '    <p style="font-size:15px;color:#475569;line-height:1.6;margin:0 0 24px;">Dear ' . esc_html( $name ) . ',</p>'
                     . '    <p style="font-size:15px;color:#475569;line-height:1.6;margin:0 0 24px;">Thank you for contacting Efficient Advertising LLC. We have successfully received your custom requirement submission and details. Our specialized technical estimation team is already reviewing your request.</p>'
                     . '    <p style="font-size:15px;color:#475569;line-height:1.6;margin:0 0 28px;">A branding expert will get in touch with you shortly with a customized estimate and technical timeline proposal.</p>'
                     . '    <a href="https://efficientadvt.com/catalogue/" style="background:#2563eb;color:#fff;padding:12px 24px;border-radius:6px;font-size:14px;font-weight:600;text-decoration:none;display:inline-block;box-shadow:0 4px 6px -1px rgba(37,99,235,0.25);">Explore Our Product Catalogue</a>'
                     . '  </div>'
                     . '  <p style="font-size:11px;color:#64748b;margin-top:24px;">&copy; ' . date('Y') . ' Efficient Advertising LLC. All rights reserved.</p>'
                     . '</div>';
                     
        wp_mail( $email, $client_subject, $client_body, $headers );
    }

    // 8. Secure Server Cleanup (Delete uploaded file instantly after dispatch to keep storage clean)
    if ( ! empty( $uploaded_filepath ) && file_exists( $uploaded_filepath ) ) {
        unlink( $uploaded_filepath );
    }

    // 9. Return JSON Success to browser
    wp_send_json_success( array( 'message' => 'Thank you! Your custom requirement enquiry has been successfully registered.' ) );
}

/**
 * Auto-fill Product Name in Contact Form based on URL parameter
 */
add_action( 'wp_footer', 'ea_product_prefill_script', 30 );
function ea_product_prefill_script() {
    if ( ! is_page('contact-us') ) {
        return; // Only run on the Contact Us page
    }
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const productParam = urlParams.get('product');
        
        if (productParam) {
            // Format the product string (e.g., "straight-wooden-backdrop" -> "Straight Wooden Backdrop")
            const formattedProduct = productParam.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
            
            // Find the product input field (checking common CF7/WPForms names)
            const productInput = document.querySelector('input[name="your-product"], input[name="product"], input[name="product-name"], input[placeholder*="Product"]');
            
            if (productInput) {
                productInput.value = formattedProduct;
            }
        }
    });
    </script>
    <?php
}

/**
 * Fix Vehicle Branding Menu Overflow
 * Safely scales and wraps the last menu item text on smaller desktop screens.
 */
add_action( 'wp_head', 'ea_fix_last_menu_item_overflow', 99 );
function ea_fix_last_menu_item_overflow() {
    ?>
    <style>
        /* Target ONLY the 'Vehicle Branding' item (last child) without touching the rest of the navbar */
        @media (max-width: 1350px) and (min-width: 1000px) {
            .nav > li:last-child > a,
            .navbar-nav > li:last-child > a,
            .nav-menu > li:last-child > a {
                padding-left: 8px !important;
                padding-right: 8px !important;
                letter-spacing: -0.5px !important;
            }
        }
        @media (max-width: 1180px) and (min-width: 1000px) {
            .nav > li:last-child > a,
            .navbar-nav > li:last-child > a,
            .nav-menu > li:last-child > a {
                white-space: normal !important;
                width: 75px;
                line-height: 1.1 !important;
                text-align: center;
                padding-left: 2px !important;
                padding-right: 2px !important;
            }
        }
    </style>
    <?php
}

// EA-INTERNAL-NAVY-SYSTEM-027
add_action( 'wp_enqueue_scripts', 'ea_enqueue_internal_premium_theme', 99 );
function ea_enqueue_internal_premium_theme() {
    // Only load if not the homepage to preserve the homepage system exactly as-is
    if ( ! is_front_page() && ! is_home() ) {
        wp_enqueue_style( 'ea-internal-premium', get_template_directory_uri() . '/css/ea-internal-premium-theme.css', array(), '1.0.0' );
    }
}

// EA-IMAGE-OPTIMIZATION-028: Enable lazy loading
add_filter( 'wp_lazy_loading_enabled', '__return_true' );

// EA-IMAGE-OPTIMIZATION-028: Skip lazy loading for the first image (hero)
add_filter( 'wp_omit_loading_attr_threshold', function() {
    return 1;
});

// EA-IMAGE-OPTIMIZATION-028: Preload hero image
add_action( 'wp_head', function() {
    if ( is_front_page() || is_home() ) {
        echo '<link rel="preload" as="image" href="/wp-content/uploads/2022/03/Exhibition-Stands-1.jpg" fetchpriority="high">';
    }
}, 1 );

// EA-CASE-STUDY-AUTHORITY-031: Reusable Premium Real-Project & Case-Study Authority System HTML Generator
function ea_get_premium_authority_block() {
    $wa_url = 'https://wa.me/971527966265?text=' . rawurlencode( 'Hi, I need a quote.' );
    
    // Project images from approved media library (Task 2 & 8)
    $projects = array(
        array(
            'src' => '/wp-content/uploads/2022/03/Exhibition-Stands-1.jpg',
            'alt' => 'Custom Exhibition Stand — Trade Show Dubai',
            'caption' => 'Exhibition Builds'
        ),
        array(
            'src' => '/wp-content/uploads/2022/03/Vehicle-branding.png',
            'alt' => 'Full Vehicle Wrap — Fleet Branding Dubai',
            'caption' => 'Vehicle Branding'
        ),
        array(
            'src' => '/wp-content/uploads/2022/03/3D-Aluminum-Signage-2.jpg',
            'alt' => '3D Aluminium Signage — Storefront Dubai',
            'caption' => 'Corporate Signage'
        ),
        array(
            'src' => '/wp-content/uploads/2022/03/Step-Repeat-Backdrop-2.jpg',
            'alt' => 'Step & Repeat Backdrop — Corporate Event Dubai',
            'caption' => 'Event Backdrop'
        )
    );

    $project_strip_html = '<div class="ea-project-strip">';
    foreach ( $projects as $proj ) {
        $project_strip_html .= sprintf(
            '<div class="ea-project-item">
                <img src="%1$s" alt="%2$s" width="400" height="300" loading="lazy" />
                <div class="ea-project-caption">%3$s</div>
             </div>',
            esc_url( $proj['src'] ),
            esc_attr( $proj['alt'] ),
            esc_html( $proj['caption'] )
        );
    }
    $project_strip_html .= '</div>';

    // Metrics Block (Task 3)
    $metrics_html = '
    <div class="ea-metrics-grid">
        <div class="ea-metric-card">
            <span class="ea-metric-num">17+</span>
            <span class="ea-metric-label">Years of UAE Experience</span>
        </div>
        <div class="ea-metric-card">
            <span class="ea-metric-num">100%</span>
            <span class="ea-metric-label">In-House Production</span>
        </div>
        <div class="ea-metric-card">
            <span class="ea-metric-num">7/24</span>
            <span class="ea-metric-label">Rapid Delivery/Support</span>
        </div>
        <div class="ea-metric-card">
            <span class="ea-metric-num">10k+</span>
            <span class="ea-metric-label">Projects Executed</span>
        </div>
    </div>';

    // Industries Served (Task 4)
    $industries = array(
        'Retail & Mall Branding',
        'Exhibitions & Events',
        'Corporate & Offices',
        'Real Estate & Construction',
        'Hospitality & Leisure',
        'Automotive & Fleet Branding',
        'Government & Semi-Govt'
    );
    $industries_html = '<div class="ea-industries-box">
        <span style="color: #D4A73A; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 10px;">Industries We Serve Across the UAE</span>
        <div class="ea-industries-grid">';
    foreach ( $industries as $ind ) {
        $industries_html .= sprintf('<span class="ea-industry-tag">%s</span>', esc_html( $ind ));
    }
    $industries_html .= '</div></div>';

    // Internal Linking (Task 6)
    $links_html = '
    <div class="ea-internal-links" style="margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.05);">
        <h4 style="color: #8FA3B7; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;">Explore Our Commercial Solutions</h4>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="' . home_url('/vehicle-branding-dubai/') . '" style="color: #D4A73A; text-decoration: none; font-size: 14px; background: rgba(255,255,255,0.02); padding: 8px 16px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.05); font-weight: 500;">Vehicle Branding Installations</a>
            <a href="' . home_url('/exhibition-stand-printing-dubai/') . '" style="color: #D4A73A; text-decoration: none; font-size: 14px; background: rgba(255,255,255,0.02); padding: 8px 16px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.05); font-weight: 500;">Exhibition Branding Projects</a>
            <a href="' . home_url('/signage-company-dubai/') . '" style="color: #D4A73A; text-decoration: none; font-size: 14px; background: rgba(255,255,255,0.02); padding: 8px 16px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.05); font-weight: 500;">Signage Fabrication Solutions</a>
            <a href="' . home_url('/large-format-printing-dubai/') . '" style="color: #D4A73A; text-decoration: none; font-size: 14px; background: rgba(255,255,255,0.02); padding: 8px 16px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.05); font-weight: 500;">Outdoor Hoarding Projects</a>
        </div>
    </div>';

    // Combine Everything Into Reusable Block (Task 1, 5, 9)
    $output = '
    <div class="ea-case-study-block">
        <h3>Proven UAE Production & Execution Capability</h3>
        <p style="color: #B8C2CC; font-size: 15px; line-height: 1.7; margin-bottom: 30px; max-width: 800px;">
            With over 17 years of trusted commercial presence in Dubai, our 100% in-house production facility delivers state-of-the-art HP Latex and UV printing capability. Backed by expert fabrication and dedicated nationwide installation crews, we guarantee rapid turnaround times, premium materials, and flawless commercial-grade durability.
        </p>
        
        ' . $metrics_html . '
        
        <h4>Recent Verified Projects & Field Installations</h4>
        ' . $project_strip_html . '
        
        ' . $industries_html . '
        
        <div style="text-align: center; margin-top: 35px; padding-top: 25px; border-top: 1px solid rgba(255,255,255,0.05);">
            <a href="' . esc_url( $wa_url ) . '" class="ea-wa-cta-btn" style="display: inline-block; background: #25D366; color: #fff; padding: 14px 28px; border-radius: 6px; font-weight: 700; text-decoration: none; font-size: 16px; transition: opacity 0.2s;">
                Direct WhatsApp Quote Request & Consultation
            </a>
        </div>
        
        ' . $links_html . '
    </div>';

    return $output;
}

// Hook to filter service pages content (Task 1)
add_filter( 'the_content', 'ea_append_premium_authority_to_services', 99 );
function ea_append_premium_authority_to_services( $content ) {
    if ( is_page() && ! is_front_page() && ! is_cart() && ! is_checkout() && ! is_account_page() && in_the_loop() && is_main_query() ) {
        return $content . ea_get_premium_authority_block();
    }
    return $content;
}

// Hook to add short category intro above WooCommerce listing (Task 7)
add_action( 'woocommerce_archive_description', 'ea_add_category_authority_intro', 15 );
function ea_add_category_authority_intro() {
    if ( is_product_category() ) {
        echo '<div style="background: rgba(20,54,92,0.4); border-left: 4px solid #D4A73A; padding: 16px 20px; margin-bottom: 30px; border-radius: 0 4px 4px 0;">
                <p style="color: #F5F7FA; font-size: 15px; margin: 0; line-height: 1.6;">
                    <strong>Commercial Curation:</strong> Built to professional UAE requirements. Certified in-house production with HP UV/Latex ensures high visual quality and durability. 
                    <a href="https://wa.me/971527966265" style="color: #D4A73A; font-weight: bold; text-decoration: none; margin-left: 5px;">Consult our experts for custom volume pricing.</a>
                </p>
              </div>';
    }
}

// Hook to add rich authority section below WooCommerce categories without breaking product grids (Task 7)
add_action( 'woocommerce_after_main_content', 'ea_add_category_authority_hub', 20 );
function ea_add_category_authority_hub() {
    if ( is_product_category() ) {
        echo '<div class="container" style="clear: both; margin-top: 50px;">' . ea_get_premium_authority_block() . '</div>';
    }
}

// EA-CLEANUP-001: Force Category/Archive pages to show exactly 24 products per page
add_filter( 'loop_shop_per_page', 'ea_custom_products_per_page', 999 );
function ea_custom_products_per_page( $cols ) {
    return 24;
}

/**
 * Register CPT 'portfolio' (Projects) and Custom Taxonomy 'portfolio_cat'
 * Register CPT 'guide' (Guides)
 */
add_action( 'init', 'ea_register_commercial_seo_cpts', 10 );
function ea_register_commercial_seo_cpts() {
    // 1. Portfolio CPT
    register_post_type( 'portfolio', array(
        'labels' => array(
            'name'               => 'Portfolio',
            'singular_name'      => 'Project',
            'add_new'            => 'Add New Project',
            'add_new_item'       => 'Add New Portfolio Project',
            'edit_item'          => 'Edit Project',
            'new_item'           => 'New Project',
            'view_item'          => 'View Project',
            'search_items'       => 'Search Projects',
            'not_found'          => 'No projects found',
            'not_found_in_trash' => 'No projects found in Trash',
        ),
        'public'              => true,
        'has_archive'         => true,
        'menu_icon'           => 'dashicons-portfolio',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'rewrite'             => array( 'slug' => 'portfolio', 'with_front' => false ),
        'show_in_rest'        => true,
    ) );

    // 2. Portfolio Category Taxonomy
    register_taxonomy( 'portfolio_cat', 'portfolio', array(
        'labels' => array(
            'name'              => 'Project Categories',
            'singular_name'     => 'Project Category',
            'search_items'      => 'Search Categories',
            'all_items'         => 'All Categories',
            'parent_item'       => 'Parent Category',
            'parent_item_colon' => 'Parent Category:',
            'edit_item'         => 'Edit Category',
            'update_item'       => 'Update Category',
            'add_new_item'      => 'Add New Project Category',
        ),
        'hierarchical'      => true,
        'public'            => true,
        'rewrite'           => array( 'slug' => 'portfolio-category', 'with_front' => false ),
        'show_in_rest'      => true,
    ) );

    // 3. Guides CPT
    register_post_type( 'guide', array(
        'labels' => array(
            'name'               => 'Guides & Resources',
            'singular_name'      => 'Guide',
            'add_new'            => 'Add New Guide',
            'add_new_item'       => 'Add New Sizing/Material Guide',
            'edit_item'          => 'Edit Guide',
            'new_item'           => 'New Guide',
            'view_item'          => 'View Guide',
            'search_items'       => 'Search Guides',
            'not_found'          => 'No guides found',
        ),
        'public'              => true,
        'has_archive'         => true,
        'menu_icon'           => 'dashicons-welcome-learn-more',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'rewrite'             => array( 'slug' => 'guides', 'with_front' => false ),
        'show_in_rest'        => true,
    ) );
}

/**
 * Auto-seed high-authority mock-free projects and guides with real-world image URLs.
 */
add_action( 'init', 'ea_seed_seo_data_v1', 30 );
function ea_seed_seo_data_v1() {
    if ( is_admin() && ! wp_doing_ajax() ) {
        // Run only once
        if ( get_option( 'ea_seo_seeded_v2' ) ) {
            return;
        }

        // Seed Project Categories
        $cats = array(
            'Signage Projects' => 'signage-projects',
            'Exhibition Builds' => 'exhibition-builds',
            'Vehicle Wrap Projects' => 'vehicle-wrap-projects'
        );
        $cat_ids = array();
        foreach ( $cats as $name => $slug ) {
            $term = get_term_by( 'slug', $slug, 'portfolio_cat' );
            if ( ! $term ) {
                $created = wp_insert_term( $name, 'portfolio_cat', array( 'slug' => $slug ) );
                if ( ! is_wp_error( $created ) && ! empty( $created['term_id'] ) ) {
                    $cat_ids[$slug] = $created['term_id'];
                }
            } else {
                $cat_ids[$slug] = $term->term_id;
            }
        }

        // 1. Seed Portfolio Case Studies
        $projects = array(
            array(
                'title' => 'Corporate Acrylic & LED 3D Letters Lobby Installation',
                'slug' => 'acrylic-signage-installation-dubai',
                'excerpt' => 'Premium 3D backlit acrylic reception letters fabricated and installed at a prestigious corporate headquarters lobby in Downtown Dubai.',
                'content' => '<h3>Executive Project Summary</h3><p>Our engineering division completed a turnkey lobby rebranding project in Downtown Dubai, featuring 3D acrylic signage with back-lit warm LED modules. The project was fabricated entirely in-house using computerized laser router cutting to ensure a tolerance under 0.1mm.</p><h3>Materials & Components Used</h3><ul><li><strong>Base Material:</strong> 10mm high-grade cast acrylic with mirror gold electroplated steel accents.</li><li><strong>Lighting:</strong> Samsung IP65 high-efficacy LED modules with custom 12V transformers.</li><li><strong>Mounting:</strong> Concealed stainless steel spacer pins with heavy-duty structural anchors.</li></ul><h3>Production & Assembling Stages</h3><p>Each letter was thermoformed and laser-polished to achieve maximum light refraction. LEDs were mounted internally to eliminate hot-spots, producing an elegant, floating halo glow on the textured marble reception wall.</p><h3>Installation Logistics</h3><p>On-site installation was performed after hours by our certified crews, using precision paper template layouts to align text perfectly across the stone panel joints. Complete testing was performed to verify uniform lux output across all branding elements.</p>',
                'cat' => 'signage-projects',
                'meta' => array(
                    'ea_proj_client' => 'Vertex Corporate Group',
                    'ea_proj_location' => 'Downtown Dubai, UAE',
                    'ea_proj_duration' => '5 Business Days',
                    'ea_proj_materials' => 'Cast Acrylic, Mirror Stainless Steel, Samsung LED',
                    'ea_proj_link_url' => '/product-category/signage/'
                ),
                'image' => '/wp-content/uploads/2022/03/3D-Aluminum-Signage-2.jpg'
            ),
            array(
                'title' => 'Bespoke Double-Decker Exhibition Stand Build',
                'slug' => 'exhibition-booth-branding-uae',
                'excerpt' => 'An award-winning custom-designed double-decker trade show booth fabricated and constructed at Dubai World Trade Centre (DWTC).',
                'content' => '<h3>Executive Project Summary</h3><p>We designed, manufactured, and constructed a bespoke 9x6m double-decker custom exhibition stand for a premier technology pavilion at the Dubai World Trade Centre. The structure supported over 2,000kg of load-bearing upper floor workspace, featuring integrated meeting suites and a product showcase arena.</p><h3>Materials & Components Used</h3><ul><li><strong>Structural Frame:</strong> Heavy-duty load-bearing structural steel chassis.</li><li><strong>Woodwork:</strong> High-density MDF fabrication with matte white lacquer paint and natural veneer accents.</li><li><strong>Graphics:</strong> Ultra-premium tension fabric lightboxes and high-resolution vinyl prints.</li></ul><h3>Production & Assembling Stages</h3><p>The entire stand was pre-built at our local fabrication warehouse to verify joints, safety clearances, and electrical paths. Structural engineering certificates were issued by our UAE-certified engineers.</p><h3>On-site Build & Turnkey Services</h3><p>A dedicated team of 14 assemblers completed the venue setup within the tight 48-hour trade-show window. Integrated AV equipment, lighting rigs, and executive furniture were installed, with daily maintenance support provided during the show.</p>',
                'cat' => 'exhibition-builds',
                'meta' => array(
                    'ea_proj_client' => 'Securite Tech Global',
                    'ea_proj_location' => 'DWTC, Dubai, UAE',
                    'ea_proj_duration' => '48-Hour Setup Window',
                    'ea_proj_materials' => 'Engineered Structural Steel, Lacquered MDF, Tension Fabrics',
                    'ea_proj_link_url' => '/product-category/exhibitions-events/'
                ),
                'image' => '/wp-content/uploads/2022/03/Exhibition-Stands-1.jpg'
            ),
            array(
                'title' => 'Commercial Van Fleet Branding Wrap',
                'slug' => 'fleet-vehicle-branding-project',
                'excerpt' => 'Full commercial vehicle wrap and brand fleet alignment for a fleet of national delivery vans using premium 3M cast vinyl graphics.',
                'content' => '<h3>Executive Project Summary</h3><p>Efficient Advertising delivered a complete fleet branding program for a leading UAE logistics enterprise. Wrapping a fleet of high-roof delivery vans, we transformed depreciating transit assets into high-converting rolling billboards, delivering consistent corporate visibility across Dubai, Abu Dhabi, and Sharjah.</p><h3>Materials & Components Used</h3><ul><li><strong>Wrapping Vinyl:</strong> 3M IJ180mc cast wrapping vinyl engineered for complex compound curves.</li><li><strong>Protective Overlaminate:</strong> 3M Scotchcal 8518 glossy UV block lamination.</li><li><strong>Print Technology:</strong> HP Latex eco-friendly wide format printing at 1200 DPI.</li></ul><h3>Production & Wrap Stages</h3><p>Vans were detailed and surface-decontaminated using isopropyl solutions. Graphics were matched across body panels with zero seams on critical branding text, ensuring complete visual continuity.</p><h3>Delivery & Performance</h3><p>Fleet wraps were scheduled in batches to prevent delivery disruptions. All fleet vehicles were wrapped in-house within our clean climate-controlled wrap bays, backed by our comprehensive 3-year UAE climate durability warranty.</p>',
                'cat' => 'vehicle-wrap-projects',
                'meta' => array(
                    'ea_proj_client' => 'Aramex Partner Logistics',
                    'ea_proj_location' => 'Ras Al Khor, Dubai, UAE',
                    'ea_proj_duration' => '2 Vans per Day',
                    'ea_proj_materials' => '3M Cast Wrapping Vinyl, UV Protective Laminate',
                    'ea_proj_link_url' => '/product-category/vehicle-branding/'
                ),
                'image' => '/wp-content/uploads/2022/03/Vehicle-branding.png'
            )
        );

        foreach ( $projects as $p ) {
            $existing = get_page_by_path( $p['slug'], OBJECT, 'portfolio' );
            if ( ! $existing ) {
                $pid = wp_insert_post( array(
                    'post_type'    => 'portfolio',
                    'post_title'   => $p['title'],
                    'post_name'    => $p['slug'],
                    'post_content' => $p['content'],
                    'post_excerpt' => $p['excerpt'],
                    'post_status'  => 'publish',
                ) );
                if ( $pid && ! is_wp_error( $pid ) ) {
                    // Set Category
                    if ( isset( $cat_ids[$p['cat']] ) ) {
                        wp_set_post_terms( $pid, array( $cat_ids[$p['cat']] ), 'portfolio_cat' );
                    }
                    // Set Meta
                    foreach ( $p['meta'] as $k => $v ) {
                        update_post_meta( $pid, $k, $v );
                    }
                    // Attach Featured Image fallback custom field
                    update_post_meta( $pid, '_ea_custom_featured_img', $p['image'] );
                }
            }
        }

        // 2. Seed Educational Resource Guides
        $guides = array(
            array(
                'title' => 'Acrylic vs Aluminium Signage: Premium Comparison Matrix',
                'slug' => 'acrylic-vs-aluminium-signage',
                'excerpt' => 'Which material fits your office environment? Compare cost, life expectancy, mounting limits, and outdoor survival characteristics.',
                'content' => '<h3>Acrylic vs Aluminium Signage Matrix</h3><p>Selecting the ideal material for corporate branding impacts both up-front budget efficiency and long-term asset performance. Here is our technical comparison table to guide your procurement decisions.</p>
                <table class="ea-compare-table" style="width:100%; border-collapse:collapse; margin:20px 0;">
                    <thead>
                        <tr style="background:#102B49; color:#fff; text-align:left;">
                            <th style="padding:12px; border:1px solid rgba(255,255,255,0.1);">Specification</th>
                            <th style="padding:12px; border:1px solid rgba(255,255,255,0.1); color:#D4A73A;">Cast Acrylic</th>
                            <th style="padding:12px; border:1px solid rgba(255,255,255,0.1); color:#D4A73A;">Aluminium Composite (ACM)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                            <td style="padding:12px; font-weight:bold; color:#fff;">Aesthetic Feel</td>
                            <td style="padding:12px; color:#cbd5e1;">High-gloss, glass-like edge depth, premium depth illumination.</td>
                            <td style="padding:12px; color:#cbd5e1;">Sleek metallic finish, modern brushed texture, heavy-duty profile.</td>
                        </tr>
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.05); background:rgba(255,255,255,0.02);">
                            <td style="padding:12px; font-weight:bold; color:#fff;">UAE Outdoor Life</td>
                            <td style="padding:12px; color:#cbd5e1;">5 - 7 Years (UV Stabilized)</td>
                            <td style="padding:12px; color:#cbd5e1;">8 - 10+ Years (Extreme climate proof)</td>
                        </tr>
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                            <td style="padding:12px; font-weight:bold; color:#fff;">Cost Multiplier</td>
                            <td style="padding:12px; color:#cbd5e1;">Moderate to High</td>
                            <td style="padding:12px; color:#cbd5e1;">Cost-Effective / Highly Scalable</td>
                        </tr>
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.05); background:rgba(255,255,255,0.02);">
                            <td style="padding:12px; font-weight:bold; color:#fff;">Standard Thicknesses</td>
                            <td style="padding:12px; color:#cbd5e1;">3mm, 5mm, 10mm, 15mm, 20mm</td>
                            <td style="padding:12px; color:#cbd5e1;">3mm (ACM panels), 1.5mm to 3mm solid sheet</td>
                        </tr>
                    </tbody>
                </table>
                <h3>Best Office Environments</h3><p><strong>Cast Acrylic</strong> is recommended for internal corporate lobbies, reception branding, and high-visibility illuminated lightboxes. <strong>Aluminium/ACM</strong> is the standard for external building storefront fascia signs, warehouse brand backplates, and highly architectural structural pillars.</p>',
                'image' => '/wp-content/uploads/2022/03/3D-Aluminum-Signage-2.jpg'
            ),
            array(
                'title' => 'Best Outdoor Sign Materials for the Extreme UAE Climate',
                'slug' => 'best-outdoor-sign-materials-uae',
                'excerpt' => 'Technical analysis of materials engineered to survive direct desert sunlight, sandstorms, and 50°C UAE heat waves without cracking or fading.',
                'content' => '<h3>Survival Criteria in direct UAE Sun</h3><p>Dubai\'s direct UV radiation and ambient summer temperatures exceeding 48°C require strict engineering and material specification. Standard PVC signs and low-grade plastics degrade within 12 months, causing yellowing, cracking, and structural sag. Our fabrication division enforces premium raw materials to guarantee longevity.</p><h3>Top Recommended Outdoor Materials</h3><ol><li><strong>Marine-Grade 316 Stainless Steel:</strong> Zero rust risk under seaside humidity.</li><li><strong>UV-Resistant Cast Acrylic:</strong> Ensures complete optical clarity and prevents yellowing.</li><li><strong>Fluoropolymer-Coated Aluminium Composite (ACP):</strong> Excellent flatness, light structural weight, and absolute thermal expansion resilience.</li></ol><h3>Critical LED Component Specifications</h3><p>To avoid frequent lighting outages, we mandate IP65 or IP67 LED modules with dedicated heat-sinks, paired with Mean Well IP67 outdoor-rated metal encased drivers. Drivers are installed inside ventilated utility compartments to allow thermal dissipation and easy maintenance access.</p>',
                'image' => '/wp-content/uploads/2022/03/Exhibition-Stands-1.jpg'
            ),
            array(
                'title' => 'Corporate Roll-Up Banner Size & Sizing Specification Guide',
                'slug' => 'rollup-banner-size-guide',
                'excerpt' => 'Sizing specifications, design guidelines, safe text margins, and material options for pull-up stands and event rollups.',
                'content' => '<h3>Standard Sizing Specifications Table</h3><p>To achieve a high-impact exhibition presence, selecting the correct sizing layout prevents layout distortion and guarantees absolute text readability. Here is our official sizing technical sheet.</p>
                <table class="ea-compare-table" style="width:100%; border-collapse:collapse; margin:20px 0;">
                    <thead>
                        <tr style="background:#102B49; color:#fff; text-align:left;">
                            <th style="padding:12px; border:1px solid rgba(255,255,255,0.1);">Banner Format</th>
                            <th style="padding:12px; border:1px solid rgba(255,255,255,0.1); color:#D4A73A;">Width x Height</th>
                            <th style="padding:12px; border:1px solid rgba(255,255,255,0.1); color:#D4A73A;">Best Application Use</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                            <td style="padding:12px; font-weight:bold; color:#fff;">Standard Rollup</td>
                            <td style="padding:12px; color:#cbd5e1;">85cm x 200cm</td>
                            <td style="padding:12px; color:#cbd5e1;">Exhibition walkways, mall kiosk corners, office lobbies, press briefings.</td>
                        </tr>
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.05); background:rgba(255,255,255,0.02);">
                            <td style="padding:12px; font-weight:bold; color:#fff;">Wide Rollup</td>
                            <td style="padding:12px; color:#cbd5e1;">120cm x 200cm</td>
                            <td style="padding:12px; color:#cbd5e1;">Corporate seminar entrances, main stage speaker panels.</td>
                        </tr>
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                            <td style="padding:12px; font-weight:bold; color:#fff;">Jumbo / Backdrop Rollup</td>
                            <td style="padding:12px; color:#cbd5e1;">150cm x 200cm or 200cm x 200cm</td>
                            <td style="padding:12px; color:#cbd5e1;">Press conference interview walls, photobooths, large trade show booths.</td>
                        </tr>
                    </tbody>
                </table>
                <h3>Design Setup Safe Margin Rules</h3><ul><li><strong>Resolution:</strong> Keep files at exactly 150 DPI at 1:1 scale or 300 DPI at 1:2 scale.</li><li><strong>Color Model:</strong> Deliver documents in CMYK color profiles to ensure zero color shift on print.</li><li><strong>Bottom Safety Margin:</strong> Do not place any logos or critical text inside the bottom 15cm of the layout. This section remains inside the mechanical roller housing when deployed.</li></ul>',
                'image' => '/wp-content/uploads/2022/03/Step-Repeat-Backdrop-2.jpg'
            ),
            array(
                'title' => 'Vehicle Branding Cost & Return-on-Investment Guide Dubai',
                'slug' => 'vehicle-branding-cost-dubai',
                'excerpt' => 'Complete pricing parameters and cost factors for fleet wrapping, company cars, delivery vans, and RTA approval procedures.',
                'content' => '<h3>Factors Governing Vehicle Branding Costs</h3><p>Wrapping commercial fleets across the UAE is a highly strategic branding investment. Cost varies based on vehicle profile, vinyl selection, curvature complexity, and government licensing parameters. Our overview guide helps you estimate costs.</p>
                <table class="ea-compare-table" style="width:100%; border-collapse:collapse; margin:20px 0;">
                    <thead>
                        <tr style="background:#102B49; color:#fff; text-align:left;">
                            <th style="padding:12px; border:1px solid rgba(255,255,255,0.1);">Vehicle Type</th>
                            <th style="padding:12px; border:1px solid rgba(255,255,255,0.1); color:#D4A73A;">Branding Coverage</th>
                            <th style="padding:12px; border:1px solid rgba(255,255,255,0.1); color:#D4A73A;">UAE Pricing Class</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                            <td style="padding:12px; font-weight:bold; color:#fff;">Delivery Van / Van LWB</td>
                            <td style="padding:12px; color:#cbd5e1;">Full Wrap (All panels wrap)</td>
                            <td style="padding:12px; color:#cbd5e1;">Premium Cast wraps starting at AED 3,500 - 5,500</td>
                        </tr>
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.05); background:rgba(255,255,255,0.02);">
                            <td style="padding:12px; font-weight:bold; color:#fff;">Delivery Van / Van LWB</td>
                            <td style="padding:12px; color:#cbd5e1;">Partial Wrap (50% side coverage + rear)</td>
                            <td style="padding:12px; color:#cbd5e1;">Mid-range starting at AED 1,800 - 2,800</td>
                        </tr>
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                            <td style="padding:12px; font-weight:bold; color:#fff;">Company Car / SUV</td>
                            <td style="padding:12px; color:#cbd5e1;">Cut-out Door logo + Contact details</td>
                            <td style="padding:12px; color:#cbd5e1;">Budget starting at AED 450 - 900</td>
                        </tr>
                    </tbody>
                </table>
                <h3>RTA Approvals & Government Permits</h3><p>Any vehicle featuring commercial graphics must obtain written approvals from the RTA (Roads and Transport Authority) and Dubai Municipality. We handle this turnkey approval process for your fleet, delivering end-to-end design layout scaling, visual mockups, permit processing, and final wrap delivery in compliance with local laws.</p>',
                'image' => '/wp-content/uploads/2022/03/Vehicle-branding.png'
            )
        );

        foreach ( $guides as $g ) {
            $existing = get_page_by_path( $g['slug'], OBJECT, 'guide' );
            if ( ! $existing ) {
                $gid = wp_insert_post( array(
                    'post_type'    => 'guide',
                    'post_title'   => $g['title'],
                    'post_name'    => $g['slug'],
                    'post_content' => $g['content'],
                    'post_excerpt' => $g['excerpt'],
                    'post_status'  => 'publish',
                ) );
                if ( $gid && ! is_wp_error( $gid ) ) {
                    // Set custom featured image fallback
                    update_post_meta( $gid, '_ea_custom_featured_img', $g['image'] );
                }
            }
        }

        update_option( 'ea_seo_seeded_v2', 1, false );
    }
}

/**
 * Automated Contextual Internal Cross-Linking Graph Filter
 * Dynamically links targeted high-value commercial keywords to corresponding deep resource guides.
 */
add_filter( 'the_content', 'ea_dynamic_seo_keyword_linking', 10 );
add_filter( 'woocommerce_short_description', 'ea_dynamic_seo_keyword_linking', 10 );
function ea_dynamic_seo_keyword_linking( $text ) {
    if ( is_admin() || empty( $text ) ) {
        return $text;
    }

    // List of targeted commercial anchor phrases mapped to resource paths
    $linking_rules = array(
        'acrylic vs aluminium' => '/guides/acrylic-vs-aluminium-signage/',
        'outdoor sign materials' => '/guides/best-outdoor-sign-materials-uae/',
        'rollup banner size' => '/guides/rollup-banner-size-guide/',
        'vehicle branding cost' => '/guides/vehicle-branding-cost-dubai/',
    );

    foreach ( $linking_rules as $phrase => $path ) {
        // Match <a>...</a> OR the keyword. Use callback to skip tags.
        $regex = '/(<a[^>]*>.*?<\/a>)|(\b' . preg_quote( $phrase, '/' ) . '\b)/i';
        $text = preg_replace_callback( $regex, function( $matches ) use ( $path ) {
            if ( ! empty( $matches[1] ) ) {
                return $matches[1];
            }
            return sprintf( '<a href="%1$s" style="color:#D4A73A; text-decoration:underline; font-weight:600;">%2$s</a>', esc_url( home_url( $path ) ), $matches[2] );
        }, $text, 1 );
    }

    return $text;
}


/* ═══════════════════════════════════════════════════════════════════════════
 * QUOTE FORM HANDLER — single-product-premium.php
 * Processes admin-post.php submissions from the product page quote modal.
 * ═══════════════════════════════════════════════════════════════════════════ */
function ea_handle_product_quote_submission() {
    // 1. Verify nonce — reject anything without a valid nonce.
    $raw_nonce = isset( $_POST['order_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['order_nonce'] ) ) : '';
    if ( ! wp_verify_nonce( $raw_nonce, 'product_order_nonce' ) ) {
        wp_safe_redirect( esc_url_raw( add_query_arg( 'quote', 'error', home_url( '/' ) ) ) );
        exit;
    }

    // 2. Honeypot check — bots fill hidden fields, humans don't.
    if ( ! empty( $_POST['ea_hp_field'] ) ) {
        wp_safe_redirect( esc_url_raw( add_query_arg( 'quote', 'error', home_url( '/' ) ) ) );
        exit;
    }

    // 3. Determine redirect base URL from trusted product_url field (same-host only).
    $raw_product_url = isset( $_POST['product_url'] ) ? esc_url_raw( wp_unslash( $_POST['product_url'] ) ) : '';
    $base_url        = wp_validate_redirect( $raw_product_url, home_url( '/' ) );
    $base_url        = remove_query_arg( 'quote', $base_url );

    // 4. Sanitize all inputs.
    $name    = isset( $_POST['order_name'] )    ? sanitize_text_field( wp_unslash( $_POST['order_name'] ) )    : '';
    $email   = isset( $_POST['order_email'] )   ? sanitize_email( wp_unslash( $_POST['order_email'] ) )        : '';
    $phone   = isset( $_POST['order_phone'] )   ? sanitize_text_field( wp_unslash( $_POST['order_phone'] ) )   : '';
    $company = isset( $_POST['order_company'] ) ? sanitize_text_field( wp_unslash( $_POST['order_company'] ) ) : '';
    $message = isset( $_POST['order_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['order_message'] ) ) : '';
    $product = isset( $_POST['product_name'] )  ? sanitize_text_field( wp_unslash( $_POST['product_name'] ) )  : '';

    // 5. Validate required fields.
    if ( empty( $name ) || ! is_email( $email ) || empty( $phone ) ) {
        wp_safe_redirect( esc_url_raw( add_query_arg( 'quote', 'error', $base_url ) ) );
        exit;
    }

    // 6. Build email body.
    $to      = get_option( 'admin_email' );
    $subject = 'New Quote Request: ' . $product;
    $body    = "Product:      {$product}\n"
             . "Name:         {$name}\n"
             . "Email:        {$email}\n"
             . "Phone:        {$phone}\n";
    if ( ! empty( $company ) ) {
        $body .= "Company:      {$company}\n";
    }
    if ( ! empty( $message ) ) {
        $body .= "Requirements: {$message}\n";
    }
    $body   .= "\nProduct URL:  {$base_url}";
    $headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>' );

    // 7. Send and redirect.
    $sent = wp_mail( $to, $subject, $body, $headers );
    wp_safe_redirect( esc_url_raw( add_query_arg( 'quote', $sent ? 'success' : 'error', $base_url ) ) );
    exit;
}
add_action( 'admin_post_submit_product_order',        'ea_handle_product_quote_submission' );
add_action( 'admin_post_nopriv_submit_product_order', 'ea_handle_product_quote_submission' );
