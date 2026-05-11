<?php

/*

 * Loads the Options Panel

 *

 * If you're loading from a child theme use stylesheet_directory

 * instead of template_directory

 */



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
 * Preload critical hero background image on homepage for improved LCP score.
 */
add_action( 'wp_head', function () {
    if ( ! is_front_page() ) return;
    echo '<link rel="preload" as="image" href="' . esc_url( content_url( 'uploads/2022/06/bak-1.png' ) ) . '" fetchpriority="high">' . "\n";
}, 1 );



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
    if ($query->is_search) {
        if ( !isset($query->query_vars['post_type']) ) {
            $query->set('post_type', 'post');
        }
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
// Email OTP Verification for Contact Form (CF7 #39)
// =============================================================================

/**
 * AJAX: generate a 6-digit OTP, store as transient (10 min), send to email.
 */
add_action( 'wp_ajax_nopriv_ea_send_otp', 'ea_send_otp_handler' );
add_action( 'wp_ajax_ea_send_otp',        'ea_send_otp_handler' );
function ea_send_otp_handler() {
    if ( ! check_ajax_referer( 'ea_otp_nonce', 'nonce', false ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed.' ) );
    }

    $email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Please enter a valid email address first.' ) );
        wp_die();
    }

    $otp           = strval( rand( 100000, 999999 ) );
    $transient_key = 'ea_otp_' . md5( strtolower( $email ) );
    set_transient( $transient_key, $otp, 10 * MINUTE_IN_SECONDS );

    $subject = 'Your Verification Code – Efficient Advertising';
    $body    = '<p>Hi,</p>'
             . '<p>Your one-time verification code is:</p>'
             . '<h2 style="letter-spacing:6px;font-size:32px;">' . esc_html( $otp ) . '</h2>'
             . '<p>This code is valid for <strong>10 minutes</strong>.</p>'
             . '<p>If you did not request this, please ignore this email.</p>';
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Efficient Advertising <info@efficientadvt.com>',
    );

    if ( wp_mail( $email, $subject, $body, $headers ) ) {
        wp_send_json_success( array( 'message' => 'Code sent! Please check your inbox (and spam folder).' ) );
    } else {
        // Clean up transient if mail failed
        delete_transient( $transient_key );
        wp_send_json_error( array( 'message' => 'Could not send email. Please try again.' ) );
    }
}

/**
 * CF7: validate the ea-otp field against the stored transient.
 */
add_filter( 'wpcf7_validate_text*', 'ea_validate_otp_field', 20, 2 );
function ea_validate_otp_field( $result, $tag ) {
    if ( $tag->name !== 'ea-otp' ) {
        return $result;
    }

    $email       = isset( $_POST['ea-email'] ) ? sanitize_email( wp_unslash( $_POST['ea-email'] ) ) : '';
    $otp_entered = isset( $_POST['ea-otp'] )   ? sanitize_text_field( wp_unslash( $_POST['ea-otp'] ) ) : '';

    if ( empty( $otp_entered ) ) {
        $result->invalidate( $tag, 'Please enter the verification code sent to your email.' );
        return $result;
    }

    if ( ! is_email( $email ) ) {
        $result->invalidate( $tag, 'Email address is missing or invalid.' );
        return $result;
    }

    $transient_key = 'ea_otp_' . md5( strtolower( $email ) );
    $stored_otp    = get_transient( $transient_key );

    if ( false === $stored_otp || $stored_otp !== $otp_entered ) {
        $result->invalidate( $tag, 'Invalid or expired code. Please request a new one.' );
        return $result;
    }

    delete_transient( $transient_key ); // one-time use
    return $result;
}

/**
 * Output the AJAX config + OTP button JS in the footer.
 */
add_action( 'wp_footer', 'ea_otp_footer_script', 20 );
function ea_otp_footer_script() {
    $cfg = array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'ea_otp_nonce' ),
    );
    ?>
<script>
(function(){
  var cfg = <?php echo wp_json_encode( $cfg ); ?>;
  document.addEventListener('DOMContentLoaded', function(){
    var btn    = document.getElementById('ea-send-otp-btn');
    var status = document.getElementById('ea-otp-status');
    if (!btn || !status) return;

    btn.addEventListener('click', function(){
      var emailField = document.getElementById('ea-email-field');
      if (!emailField) return;
      var email = emailField.value.trim();
      var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!email || !emailRe.test(email)) {
        status.textContent = 'Please enter a valid email address first.';
        status.className   = 'ea-otp-msg ea-otp-error';
        emailField.focus();
        return;
      }
      btn.disabled    = true;
      btn.textContent = 'Sending\u2026';
      status.textContent = '';
      status.className   = 'ea-otp-msg';

      var fd = new FormData();
      fd.append('action', 'ea_send_otp');
      fd.append('nonce',  cfg.nonce);
      fd.append('email',  email);

      fetch(cfg.ajax_url, { method: 'POST', body: fd })
        .then(function(r){ return r.json(); })
        .then(function(data){
          var msg = (data.data && data.data.message) ? data.data.message : (data.success ? 'Code sent!' : 'Error. Try again.');
          status.textContent = msg;
          status.className   = 'ea-otp-msg ' + (data.success ? 'ea-otp-ok' : 'ea-otp-error');
          if (data.success) {
            var secs = 60;
            btn.textContent = 'Resend in ' + secs + 's';
            var t = setInterval(function(){
              secs--;
              btn.textContent = 'Resend in ' + secs + 's';
              if (secs <= 0) {
                clearInterval(t);
                btn.disabled    = false;
                btn.textContent = 'Resend Code';
              }
            }, 1000);
          } else {
            btn.disabled    = false;
            btn.textContent = 'Send Verification Code';
          }
        })
        .catch(function(){
          status.textContent = 'Network error. Please try again.';
          status.className   = 'ea-otp-msg ea-otp-error';
          btn.disabled       = false;
          btn.textContent    = 'Send Verification Code';
        });
    });
  });
})();
</script>
    <?php
}


