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
<link rel="preload" as="image" href="<?php echo esc_url( content_url('uploads/2022/03/Exhibition-Stands-1.jpg') ); ?>">
<?php wp_head(); ?>
<!-- AUDIT FIX H-04: Duplicate Google Analytics block removed -->
	
	<meta name="google-site-verification" content="nsHzgQDRYfrB4J9Man5LqiEjBjCoXYLHI120Gp0SvaQ" />
	
	
</head>
<body <?php body_class(); ?>>



<style>
/* ===== SINGLE-ROW HEADER BAR ===== */
.logtophead {
  display: flex;
  align-items: center;
  padding: 0;
  width: 100%;
  min-height: 88px;
  gap: 0;
  position: relative;
}

/* Brand: logo + tagline inline */
.ea-hdr-brand {
  flex-shrink: 0;
  display: flex;
  align-items: center;
  gap: 12px;
  margin-right: 20px;
  padding: 10px 0;
  text-decoration: none !important;
}
.ea-hdr-brand .logo {
  line-height: 0;
}
.ea-hdr-brand .logo img {
  height: 72px !important;
  width: auto;
  display: block;
  object-fit: contain;
  -webkit-user-drag: none;
  user-select: none;
  -webkit-user-select: none;
  pointer-events: none;
}
.ea-hdr-tagline {
  font-size: 20px;
  font-weight: 700;
  color: #1A1A2E;
  white-space: nowrap;
  line-height: 1.4;
  letter-spacing: 0.3px;
}

/* Top utility bar: centered layout for cleaner hierarchy */
.topheader .container {
  display: flex;
  justify-content: center;
  align-items: center;
}
.topheader .topleftside {
  float: none !important;
  width: auto !important;
}
.topheader .topleftside ul {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 24px;
  flex-wrap: wrap;
  margin: 0;
  padding: 0;
}
.topheader .toprightside {
  display: none !important;
}

/* Stronger primary navigation readability */
.ea-mega-list {
  gap: 6px;
}
.ea-mega-list > .ea-mega-item > .ea-mega-link {
  font-size: 16px !important;
  font-weight: 700 !important;
  padding-top: 15px !important;
  padding-bottom: 15px !important;
  letter-spacing: 0.01em;
}

/* Nav row — headerbottom holds the mega-nav below the logo row */
.headerbottom {
  position: relative;
  overflow: visible;
  border-top: 1px solid #f1f5f9;
  padding: 0;
}

/* Utilities: search · WhatsApp — pushed to right of logo row */
.ea-hdr-utils {
  flex-shrink: 0;
  display: flex;
  align-items: center;
  gap: 12px;
  margin-left: auto;
  padding: 10px 0;
}

/* Phone */
.ea-toprow-phone {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  color: #F59E0B !important;
  font-weight: 700;
  font-size: 13px;
  white-space: nowrap;
  text-decoration: none !important;
  cursor: pointer;
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
  width: 130px;
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

/* Responsive */
@media (max-width: 1280px) {
  .ea-hdr-tagline { display: none; }
  .ea-hdr-utils { gap: 10px; }
  .ea-hdr-brand .logo img { height: 64px !important; }
}
@media (max-width: 1024px) {
  .ea-toprow-search { display: none; }
  .ea-toprow-phone .ph-text { display: none; }
  .ea-hdr-brand .logo img { height: 58px !important; }
  .topheader .topleftside ul { gap: 16px; }
}
@media (max-width: 767px) {
  .ea-hdr-utils { display: none; }
  .topheader .container { justify-content: center; }
  .topheader .topleftside ul { justify-content: center; gap: 10px; }
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
  <!-- Row 1: Top bar — address · phone · email · social -->
  <div class="topheader">
    <div class="container">
      <div class="topleftside">
        <ul>
          <li><a href="tel:+971527966265"><i class="fa fa-phone"></i> +971 52 796 6265</a></li>
          <li><a href="mailto:info@efficientadvt.com"><i class="fa fa-envelope-o"></i> info@efficientadvt.com</a></li>
          <li><i class="fa fa-map-marker"></i> Ras Al Khor Industrial Area 1, Dubai</li>
        </ul>
      </div>
      <div class="toprightside">
        <ul>
          <li><a href="https://www.facebook.com/EfficientUAE" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fa fa-facebook"></i></a></li>
          <li><a href="https://www.instagram.com/efficientuae" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fa fa-instagram"></i></a></li>
          <li><a href="https://x.com/EfficientUAE" target="_blank" rel="noopener noreferrer" aria-label="Twitter / X"><i class="fa fa-twitter"></i></a></li>
          <li><a href="https://linkedin.com/company/efficientuae" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fa fa-linkedin"></i></a></li>
        </ul>
      </div>
    </div>
  </div>
  <!-- Row 2: Logo + mega navigation -->
   <nav class="navbar navbar-inverse">
      <div class="container">
        <div class="logtophead">
          <!-- Brand: logo + tagline -->
          <div class="ea-hdr-brand">
            <div class="logo">
              <a class="" href="<?php echo home_url(); ?>">
                <?php if ( of_get_option('logo') ) : ?>
                  <img src="<?php echo of_get_option('logo'); ?>" alt="Efficient Advertising" draggable="false" oncontextmenu="return false;" />
                <?php else : ?>
                  <img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="Efficient Advertising" draggable="false" oncontextmenu="return false;">
                <?php endif; ?>
              </a>
            </div>
            <span class="ea-hdr-tagline">You think it, We print it</span>
          </div>

          <!-- Mobile hamburger toggle -->
          <button class="ea-mob-toggle" id="eaMobToggle" aria-label="Open navigation" aria-expanded="false">
            <span class="ea-bar"></span>
            <span class="ea-bar"></span>
            <span class="ea-bar"></span>
          </button>
          <!-- Mobile click-away overlay -->
          <div class="ea-mob-overlay" id="eaMobOverlay"></div>
          <!-- Utilities: search · WhatsApp -->
          <div class="ea-hdr-utils">
            <form class="ea-toprow-search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
              <input type="search" name="s" placeholder="Search products..." value="<?php echo get_search_query(); ?>" autocomplete="off" />
              <button type="submit" aria-label="Search">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
              </button>
            </form>
            <a class="ea-wa-cta-btn ea-no-href" data-url="https://wa.me/971527966265?text=Hi%2C%20I%27d%20like%20to%20get%20a%20quote" role="button" aria-label="WhatsApp Us">
              <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink:0;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              <span>WhatsApp Us</span>
            </a>
          </div>
        </div><!-- /.logtophead -->
        <!-- Navigation row: full-width bar for all category links -->
        <div class="headerbottom">
          <nav class="ea-mega-nav" id="eaMegaNav" aria-label="Main navigation">
            <div class="ea-mob-close-row">
              <button class="ea-mob-close" id="eaMobClose" aria-label="Close navigation">&#10005;</button>
            </div>
            <ul class="ea-mega-list">
              <?php
              $ea_top_cats = get_terms( array(
                'taxonomy'   => 'product_cat',
                'parent'     => 0,
                'hide_empty' => true,
                'orderby'    => 'name',
                'order'      => 'ASC',
              ) );
              if ( ! is_wp_error( $ea_top_cats ) ) :
                foreach ( $ea_top_cats as $ea_cat ) :
                  if ( 'uncategorized' === $ea_cat->slug ) continue;
                  $ea_cat_url  = get_term_link( $ea_cat );
                  $ea_sub_cats = get_terms( array(
                    'taxonomy'   => 'product_cat',
                    'parent'     => $ea_cat->term_id,
                    'hide_empty' => true,
                    'orderby'    => 'name',
                    'order'      => 'ASC',
                  ) );
                  $ea_has_subs = ( ! is_wp_error( $ea_sub_cats ) && ! empty( $ea_sub_cats ) );
                  /* Representative image: first product thumbnail in this category */
                  $ea_img_html = '';
                  $ea_products = get_posts( array(
                    'post_type'      => 'product',
                    'posts_per_page' => 1,
                    'post_status'    => 'publish',
                    'tax_query'      => array( array(
                      'taxonomy' => 'product_cat',
                      'field'    => 'term_id',
                      'terms'    => $ea_cat->term_id,
                    ) ),
                  ) );
                  if ( $ea_products ) {
                    $ea_tid = get_post_thumbnail_id( $ea_products[0]->ID );
                    if ( $ea_tid ) {
                      $ea_img_html = wp_get_attachment_image( $ea_tid, array( 260, 195 ), false, array(
                        'class'   => 'ea-panel-img',
                        'loading' => 'lazy',
                        'alt'     => esc_attr( $ea_cat->name ),
                      ) );
                    }
                  }
              ?>
              <li class="ea-mega-item<?php echo $ea_has_subs ? ' ea-has-panel' : ''; ?>">
                <a class="ea-mega-link" href="<?php echo esc_url( $ea_cat_url ); ?>"><?php echo esc_html( $ea_cat->name ); ?><?php if ( $ea_has_subs ) : ?><svg class="ea-chevron" width="10" height="6" viewBox="0 0 10 6" aria-hidden="true" focusable="false"><polyline points="1,1 5,5 9,1" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg><?php endif; ?></a>
                <?php if ( $ea_has_subs ) : ?>
                <div class="ea-mega-panel">
                  <div class="ea-mega-panel-inner">
                    <?php if ( $ea_img_html ) : ?><a class="ea-panel-imglink" href="<?php echo esc_url( $ea_cat_url ); ?>" tabindex="-1"><?php echo $ea_img_html; ?></a><?php endif; ?>
                    <div class="ea-panel-subs">
                      <a class="ea-panel-viewall" href="<?php echo esc_url( $ea_cat_url ); ?>">View All &rarr;</a>
                      <ul class="ea-panel-sublist">
                        <?php foreach ( $ea_sub_cats as $ea_sub ) : ?>
                        <li><a href="<?php echo esc_url( get_term_link( $ea_sub ) ); ?>"><?php echo esc_html( $ea_sub->name ); ?></a></li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
              </li>
              <?php
                endforeach;
              endif;
              ?>
            </ul>
          </nav>
        </div><!-- /.headerbottom -->
      </div>
   </nav>
</div>
<script>
if (typeof window.$ === 'undefined' && typeof window.jQuery !== 'undefined') {
  window.$ = window.jQuery;
}
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
      if ($('#ea-hp-hero').length) { document.getElementById('ea-hp-hero').style.setProperty('padding-top', hpx, 'important'); }
      if ($('.ea-cat-hero').length) { $('.ea-cat-hero')[0].style.setProperty('padding-top', hpx, 'important'); }
    }
  }

  // Run immediately on load so carousel is never hidden under header
  updateHeader();

  $(window).on('scroll resize', updateHeader);

  // ea-no-href: open data-url on click (used for phone, WhatsApp, etc.)
  $(document).on('click', '.ea-no-href', function() {
    var url = $(this).data('url');
    if (url) {
      if (url.indexOf('wa.me') !== -1 || url.indexOf('http') === 0) {
        window.open(url, '_blank');
      } else {
        window.location.href = url;
      }
    }
  });

});

</script>

