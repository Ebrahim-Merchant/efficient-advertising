<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php
if(of_get_option('favicon'))	
{		
?>
<link rel="shortcut icon" type="image/png" href="<?php echo of_get_option('favicon'); ?>"/>	
<?php		
}
?>
<meta content='IE=edge' http-equiv='X-UA-Compatible'>
<meta http-equiv='content-type' content='text/html; charset=UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<!-- Google Analytics GA4 + Google Ads — single unified gtag block (Google recommended) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-38EQB75ZRX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-38EQB75ZRX');
  gtag('config', 'AW-854448823');
</script>
<!-- NOTE: Google Ads conversion event must only be placed on thank-you.php, NOT here -->

<!-- LocalBusiness Schema Markup -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "Efficient Advertising L.L.C",
  "image": "https://efficientadvt.com/wp-content/uploads/2024/11/efficient-logo-1-1.png",
  "url": "https://efficientadvt.com",
  "telephone": "+971527966265",
  "email": "info@efficientadvt.com",
  "description": "Dubai's media, printing and branding company since 2008 — specialising in banners, backdrops, flags, signage, exhibitions, events and vehicle branding across the UAE.",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Warehouse-11, 10C Street, Ras Al Khor Industrial Area 1",
    "addressLocality": "Dubai",
    "addressRegion": "Dubai",
    "addressCountry": "AE"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": "25.1849",
    "longitude": "55.3644"
  },
  "openingHoursSpecification": [
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
      "opens": "08:00",
      "closes": "20:00"
    }
  ],
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "5",
    "reviewCount": "34"
  },
  "priceRange": "$$",
  "sameAs": [
    "https://www.facebook.com/EfficientUAE",
    "https://x.com/EfficientUAE",
    "https://linkedin.com/company/efficientuae",
    "https://www.instagram.com/efficientuae"
  ]
}
</script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/animate.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/owl.theme.default.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/blueimp-gallery.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/blueimp-gallery-indicator.css">
<!-- AUDIT FIX H-06: Replaced vulnerable bundled jQuery 3.3.1 with WordPress core jQuery (always up to date) -->
<script src="<?php echo includes_url('js/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/wow.min.js"></script>         
<script>
   wow = new WOW( {
   
       boxClass:     'wow',
   
       animateClass: 'animated',
   
       offset:       100
   
       }
   
   ); 
   
   wow.init();
   
</script>
<!-- Hero fonts: Unbounded (labels), DM Sans (body) — supplement existing Gotham -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<!-- LCP preload for hero above-fold image -->
<link rel="preload" as="image" href="<?php echo esc_url( content_url('uploads/2022/03/Step-Repeat-Backdrop-2.jpg') ); ?>">
<?php wp_head(); ?>
<!-- AUDIT FIX H-04: Duplicate Google Analytics block removed -->
	
	<meta name="google-site-verification" content="nsHzgQDRYfrB4J9Man5LqiEjBjCoXYLHI120Gp0SvaQ" />
	
	
</head>
<body <?php body_class(); ?>>



<style>
/* ===== TOP ROW ===== */
.logtophead {
  display: flex;
  align-items: center;
  flex-wrap: nowrap;
  justify-content: space-between;
  padding: 12px 0;
}

/* ── LEFT: logo + tagline ── */
.ea-toprow-left {
  display: flex;
  align-items: center;
  gap: 18px;
  flex-shrink: 0;
}
.ea-toprow-left .middle {
  flex-shrink: 0;
  width: auto !important;
  padding: 0 !important;
  float: none !important;
}
.ea-toprow-left .logo img {
  width: auto !important;
  height: 72px !important;
  display: block;
  object-fit: contain;
  /* Logo copy-protection */
  -webkit-user-drag: none;
  user-select: none;
  -webkit-user-select: none;
  pointer-events: none;   /* passes clicks up to the <a> wrapper */
}
.logtophead .think {
  font-size: 18px !important;
  font-weight: 800 !important;
  color: #1e293b !important;
  margin: 0 !important;
  line-height: 1.45;
  white-space: nowrap;
  letter-spacing: 0.2px;
}

/* ── RIGHT: flag+loc | phone | search | buttons ── */
.ea-toprow-right {
  display: flex;
  align-items: center;
  gap: 20px;          /* generous breathing room between groups */
  flex-shrink: 0;
}

/* Flag + Location: flag on left, 2-line address on right */
.ea-toprow-flag-loc {
  display: flex;
  align-items: center;
  gap: 10px;          /* clear gap between flag and text */
  flex-shrink: 0;
}
.ea-toprow-flag-loc > img {
  width: 32px;
  height: 21px;
  border-radius: 3px;
  box-shadow: 0 1px 4px rgba(0,0,0,0.22);
  display: block;
  flex-shrink: 0;
}
.ea-toprow-location {
  display: block;
  color: #475569;
  font-size: 12px;
  font-weight: 500;
  line-height: 1.5;
  white-space: normal;
  max-width: 120px;
  text-decoration: none !important;
}
.ea-toprow-location:hover { color: #1e293b !important; text-decoration: none !important; }

/* Slim vertical rule between groups */
.ea-toprow-divider {
  width: 1px;
  height: 36px;
  background: #e2e8f0;
  flex-shrink: 0;
}

/* Phone */
.ea-toprow-phone {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  color: #F59E0B !important;
  font-weight: 700;
  font-size: 14px;
  white-space: nowrap;
  text-decoration: none !important;
}
.ea-toprow-phone:hover { color: #D97706 !important; text-decoration: none !important; }

/* Search pill */
.ea-toprow-search {
  display: flex;
  align-items: center;
  background: #f1f5f9;
  border: 1px solid #e2e8f0;
  border-radius: 20px;
  overflow: hidden;
  height: 34px;
  transition: border-color 0.2s;
}
.ea-toprow-search:focus-within { border-color: #F59E0B; background: #fff; }
.ea-toprow-search input {
  border: none !important;
  background: transparent !important;
  padding: 0 6px 0 14px !important;
  height: 34px !important;
  font-size: 12px !important;
  color: #1e293b !important;
  width: 140px;
  outline: none !important;
  box-shadow: none !important;
  line-height: 34px !important;
}
.ea-toprow-search input::placeholder { color: #94a3b8; }
.ea-toprow-search button {
  border: none !important;
  background: #0F172A;
  color: #fff;
  height: 34px;
  width: 34px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  border-radius: 0 20px 20px 0;
  transition: background 0.2s;
  padding: 0;
}
.ea-toprow-search button:hover { background: #F59E0B; }
.logtophead .rightside { flex-shrink: 0; }

/* Responsive */
@media (max-width: 1280px) {
  .ea-toprow-flag-loc { display: none; }
  .ea-toprow-right { gap: 14px; }
}
@media (max-width: 1024px) {
  .ea-toprow-search { display: none; }
  .ea-toprow-phone .ph-text { display: none; }
}
@media (max-width: 767px) {
  .ea-toprow-phone { display: none; }
  .ea-toprow-divider { display: none; }
}

/* ===== FULL-WIDTH LAYOUT — overrides Bootstrap 3 fixed container widths ===== */
html, body {
  width: 100% !important;
  max-width: 100% !important;
  overflow-x: hidden;
}
.container,
.navbar > .container,
.navbar > .container-fluid {
  width: 100% !important;
  max-width: 1440px !important;
  padding-left: 20px !important;
  padding-right: 20px !important;
  margin-left: auto !important;
  margin-right: auto !important;
  box-sizing: border-box !important;
}
/* Full-bleed sections (hero, banners) still go edge-to-edge */
.homebaner,
.homebaner img,
#header,
#footer,
nav.navbar {
  width: 100% !important;
  max-width: 100% !important;
}

/* =====================================================================
   OPTION C — PURE GOTHAM TYPOGRAPHY SYSTEM
   Gotham Black  → H1 hero headings
   Gotham Bold   → H2 section headings, strong UI text
   Gotham Medium → H3 sub-headings, card titles
   Gotham Book   → body copy, paragraphs
   Gotham Light  → captions, labels, meta
   ===================================================================== */

/* Base */
html {
  font-size: 17px !important;   /* 1rem = 17px — comfortable reading size */
}
body {
  font-family: 'Outfit', sans-serif !important;
  font-weight: 400 !important;   /* Gotham Book */
  font-size: 1rem !important;    /* 17px */
  line-height: 1.7 !important;
  color: #1f2937;               /* inherited by all children */
}
/* Enforce Gotham on inline elements — color intentionally NOT set here
   so these elements inherit color from their nearest ancestor */
body p,
body li,
body td,
body input,
body textarea,
body select,
body button {
  font-family: 'Outfit', sans-serif !important;
  font-weight: 400 !important;
  font-size: 1rem !important;
  line-height: 1.7 !important;
}

/* H1 — page/hero titles */
h1, .h1,
.sp-hero-h1,
.cat-hero-title,
.ea-hero-h1 {
  font-family: 'Outfit', sans-serif !important;
  font-weight: 900 !important;   /* Gotham Black */
  font-size: clamp(2rem, 5vw, 3rem) !important;
  line-height: 1.15 !important;
  letter-spacing: -0.02em;
  color: #0f172a;   /* NO !important */
}

/* H1 on dark/hero backgrounds stays white */
.sp-hero h1, .sp-hero .sp-hero-h1,
.cat-hero h1, .cat-hero .cat-hero-title,
.ea-seo-hero h1 {
  color: #ffffff !important;
}

/* H2 — section headings */
h2, .h2,
.sp-sec-hdr h2,
.cat-sec-hdr h2,
.ea-sec-title {
  font-family: 'Outfit', sans-serif !important;
  font-weight: 700 !important;   /* Gotham Bold */
  font-size: clamp(1.5rem, 3.5vw, 2.2rem) !important;
  line-height: 1.25 !important;
  letter-spacing: -0.01em;
  color: #1e293b;   /* NO !important */
}

/* H3 — card/sub-section titles */
h3, .h3,
.sp-why-title,
.cat-why-title,
.ea-card-title {
  font-family: 'Outfit', sans-serif !important;
  font-weight: 600 !important;   /* Gotham Medium */
  font-size: clamp(1.15rem, 2.5vw, 1.5rem) !important;
  line-height: 1.3 !important;
  color: #1e293b;   /* NO !important */
}

/* H4 — minor headings, widget titles */
h4, .h4 {
  font-family: 'Outfit', sans-serif !important;
  font-weight: 600 !important;
  font-size: 1.1rem !important;
  color: #334155;   /* NO !important */
}

/* Labels, captions, small meta text */
small, .small,
.sp-panel-label,
.sp-breadcrumb,
.cat-breadcrumb,
.sp-spec-label,
.sp-pricing-tbl th,
.sp-trust-item,
figcaption {
  font-family: 'Outfit', sans-serif !important;
  font-weight: 300 !important;   /* Gotham Light */
  font-size: 0.82rem !important;
  letter-spacing: 0.03em;
  color: #64748b;   /* NO !important */
}

/* Strong values — spec vals, prices, badges */
.sp-panel-val,
.sp-spec-val,
strong, b {
  font-family: 'Outfit', sans-serif !important;
  font-weight: 700 !important;   /* Gotham Bold */
  color: inherit;
}

/* Navigation stays as-is (already styled) but enforce Gotham */
.navbar-nav > li > a,
.dropdown-menu > li > a,
.navbar .think {
  font-family: 'Outfit', sans-serif !important;
}

/* Button text */
.btn,
.sp-btn-wa, .sp-btn-quote, .sp-btn-call,
.sp-price-wa, .sp-panel-cta,
.ea-cta-btn {
  font-family: 'Outfit', sans-serif !important;
  font-weight: 700 !important;
  letter-spacing: 0.02em;
}

/* ── Dark-background sections: restore white/light text ── */
#footer,
#footer p, #footer li, #footer a, #footer span,
#footer h2, #footer h3, #footer h4,
.foterlogo p, .footerheading p {
  font-family: 'Outfit', sans-serif !important;
  font-size: 0.9rem !important;
  color: rgba(255,255,255,0.82) !important;
}
#footer .footerheading h2,
#footer .footerheading h3 {
  font-size: clamp(1rem, 2vw, 1.25rem) !important;
  font-weight: 700 !important;
  color: #ffffff !important;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}

/* Dark sections — ea-dark-section class applied to dark <section> elements */
.ea-dark-section,
.ea-dark-section p,
.ea-dark-section li,
.ea-dark-section span,
.ea-dark-section a,
.ea-dark-section label {
  color: rgba(255,255,255,0.82) !important;
}
.ea-dark-section h1,
.ea-dark-section h2,
.ea-dark-section h3,
.ea-dark-section h4,
.ea-dark-section .ea-stat-number {
  color: #ffffff !important;
}
.ea-dark-section .ea-stat-label {
  color: rgba(255,255,255,0.65) !important;
  font-size: 0.82rem !important;
}

/* Hero sections on product/category/SEO pages — keep white */
.sp-hero, .sp-hero p, .sp-hero h1, .sp-hero h2, .sp-hero h3,
.cat-hero, .cat-hero p, .cat-hero h1, .cat-hero h2, .cat-hero h3,
.sp-trust-bar, .sp-trust-bar p,
.sp-cta-strip, .sp-cta-strip p, .sp-cta-strip h2 {
  color: #ffffff !important;
}

/* Mobile scale-down */
@media (max-width: 767px) {
  html { font-size: 15px; }
}
</style>
<div id="header">
   <nav class="navbar navbar-inverse">
      <div class="container">
        <div class="logtophead">
          <!-- LEFT 50%: logo + tagline -->
          <div class="ea-toprow-left">
            <div class="middle">
              <div class="logo">
                <a class="" href="<?php echo home_url(); ?>">
                  <?php if ( of_get_option('logo') ) : ?>
                    <img src="<?php echo of_get_option('logo'); ?>" alt="Efficient Advertising" draggable="false" oncontextmenu="return false;" />
                  <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="Efficient Advertising" draggable="false" oncontextmenu="return false;">
                  <?php endif; ?>
                </a>
              </div>
            </div>
            <h3 class="think">You think it,<br>We print it</h3>
          </div>

          <!-- RIGHT: flag+location · | · phone · | · search · | · buttons -->
          <div class="ea-toprow-right">
            <div class="ea-toprow-flag-loc">
              <img src="https://flagcdn.com/ae.svg" alt="UAE" width="24" height="16" />
              <a href="https://maps.google.com/?q=Ras+Al+Khor+Industrial+Area+Dubai" target="_blank" rel="noopener" class="ea-toprow-location">Ras Al Khor Ind.<br>Area 1, Dubai</a>
            </div>
            <div class="ea-toprow-divider"></div>
            <div class="ea-toprow-phones">
              <a class="ea-toprow-phone ea-no-href" data-url="tel:+971527966265" role="button" style="cursor:pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.57 3.37 2 2 0 0 1 3.55 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.64a16 16 0 0 0 6.12 6.12l.81-.81a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                <span class="ph-text">+971 52 796 6265</span>
              </a>
              <a class="ea-toprow-landline ea-no-href" data-url="tel:+97142711048" role="button" style="cursor:pointer; font-size:11px; color:#555; text-decoration:none; display:block; margin-top:2px; line-height:1;">
                &#9743; 04 271 1048
              </a>
            </div>
            <div class="ea-toprow-divider"></div>
            <form class="ea-toprow-search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
              <input type="search" name="s" placeholder="Search products..." value="<?php echo get_search_query(); ?>" autocomplete="off" />
              <button type="submit" aria-label="Search">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
              </button>
            </form>
            <div class="ea-toprow-divider"></div>
            <div class="rightside">
              <?php wp_nav_menu( array( 'theme_location' => 'header_menu', 'menu' => 'Menu', 'menu_class' => 'rightside', 'container' => 'false' ) ); ?>
            </div>
          </div>
        </div>
        <div class="headerbottom">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <?php wp_nav_menu( array( 'theme_location' => 'header_menu', 'menu' => 'Header Menu', 'menu_class' => 'nav navbar-nav', 'container' => 'false' ) ); ?>
          </div>
        </div>
      </div>
   </nav>
</div>
<script>
$(document).ready(function(){  

  //$('#datepicker').datetimepicker();

  $('#home').owlCarousel({

    loop:true,

    nav:false,

    dots:false,

    autoplay:true,

    smartSpeed :2000,

    responsiveClass:true,

    navText : ["<i class='fa fa-long-arrow-left'></i>","<i class='fa fa-long-arrow-right'></i>"],

    responsive:{

        0:{

            items:1,

            nav:false

        },

        600:{

            items:1,

            nav:false

        },

        1000:{

            items:1,

            nav:true 

        }

    }

});





  $('#testimonial').owlCarousel({

    loop:true,

    nav:true,

    dots:true,

    autoplay:true,

    smartSpeed :1500,

    responsiveClass:true,

    responsive:{

        0:{

            items:1,

            nav:false

        },

        600:{

            items:1,

            nav:false

        },

        1000:{

            items:1

           

        }

    }

}); 



   $('.carousel').carousel();

  

});



$(document).ready(function () {

            $('#vertical').lightSlider({

                gallery: true,

                item: 1,

                vertical: true,

                verticalHeight: 450,

                vThumbWidth: 100,

                vThumbheight: 70,

                thumbItem: 4,

                thumbMargin: 0,

                slideMargin: 0,

                 responsive : [

            {

                breakpoint:768,

                settings: {

                    thumbItem:3,

                     vThumbWidth: 70,

                     verticalHeight: 300 

                  }

            },

            {

                breakpoint:480,

                settings: {

                    thumbItem:3,

                     vThumbWidth: 70,

                     verticalHeight: 250

                  }

            }

        ]

            });

        });



    $(window).scroll(function() {

    var height = $(window).scrollTop();

    if (height > 100) {

        $('#back2Top').fadeIn();

    } else {

        $('#back2Top').fadeOut();

    }

});

$(document).ready(function() {

    $("#back2Top").click(function(event) {

        event.preventDefault();

        $("html, body").animate({ scrollTop: 0 }, "slow");

        return false;

    });



});


$(".navbar .nav li a, .navbar .nav li a").click(function () {

        var dataAttr = $(this).attr('data-jump');

        $('html,body').animate({

            scrollTop: $("#" + dataAttr).offset().top - 0

        }, 1000);

    });



$(function(){

  var navbar = $('.navbar');

  function updateHeader() {
    if ($(window).scrollTop() <= 40) {
      navbar.removeClass('navbar-scroll');
      $('body').removeClass('ea-compact-header');
    } else {
      navbar.addClass('navbar-scroll');
      $('body').addClass('ea-compact-header');
    }
    // Measure actual rendered header height and apply to carousel (override any CSS !important)
    var h = $('#header').outerHeight();
    if (h && h > 0) {
      var hpx = h + 'px';
      if ($('.homebaner').length)  { $('.homebaner')[0].style.setProperty('margin-top', hpx, 'important'); }
      if ($('#ea-hero').length)    { document.getElementById('ea-hero').style.setProperty('margin-top', hpx, 'important'); }
      if ($('.sp-hero').length)    { $('.sp-hero')[0].style.setProperty('padding-top', hpx, 'important'); }
      if ($('.cat-hero').length)   { $('.cat-hero')[0].style.setProperty('padding-top', hpx, 'important'); }
      if ($('.ea-seo-hero').length){ $('.ea-seo-hero')[0].style.setProperty('padding-top', hpx, 'important'); }
      if ($('.ea-bdhero').length)  { $('.ea-bdhero')[0].style.setProperty('padding-top', hpx, 'important'); }
    }
  }

  // Run immediately on load so carousel is never hidden under header
  updateHeader();

  $(window).on('scroll resize', updateHeader);

});

</script>