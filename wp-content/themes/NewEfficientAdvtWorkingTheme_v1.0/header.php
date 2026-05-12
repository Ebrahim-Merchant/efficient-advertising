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
<!-- LCP preload for hero above-fold image (conditioned to avoid unnecessary render/LCP delay on service pages) -->
<?php if ( is_front_page() || is_home() || is_page_template('page-v10.php') || is_page('wooden-backdrop') ) : ?>
<link rel="preload" as="image" href="<?php echo esc_url( content_url('uploads/2022/03/Step-Repeat-Backdrop-2.jpg') ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
<!-- AUDIT FIX H-04: Duplicate Google Analytics block removed -->
	
	<meta name="google-site-verification" content="nsHzgQDRYfrB4J9Man5LqiEjBjCoXYLHI120Gp0SvaQ" />
	
	
</head>
<body <?php body_class(); ?>>



<style>
#header {
  position: sticky !important;
  top: 0 !important;
  width: 100% !important;
  z-index: 10000 !important;
  background: #1D4472 !important;
  box-shadow: 0 4px 20px rgba(0,0,0,0.3) !important;
}
.navbar-scroll {
  position: sticky !important;
  top: 0 !important;
}
.logtophead {
  display: flex;
  align-items: center;
  padding: 0;
  width: 100%;
  min-height: 72px;
  gap: 0;
  position: relative;
}

/* Brand: logo + tagline inline */
.ea-hdr-brand {
  flex-shrink: 0;
  display: flex;
  align-items: center;
  gap: 12px;
  margin-right: 30px;
  padding: 8px 0;
  text-decoration: none !important;
}
.ea-hdr-brand .logo {
  line-height: 0;
}
.ea-hdr-brand .logo img {
  height: 64px !important;
  width: auto;
  display: block;
  object-fit: contain;
  -webkit-user-drag: none;
  user-select: none;
  -webkit-user-select: none;
  pointer-events: none;
}
.ea-hdr-tagline {
  display: none !important;
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
  flex-grow: 1; /* Expand to fill space */
  display: flex;
  align-items: center;
  gap: 20px;
  margin-left: 20px;
  padding: 10px 0;
}

/* Phone */
.ea-toprow-phone {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  color: #FFC107 !important;
  font-weight: 800;
  font-size: 16px;
  white-space: nowrap;
  text-decoration: none !important;
  cursor: pointer;
  text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}
.ea-toprow-phone:hover { color: #FFFFFF !important; text-decoration: none !important; }

/* Search pill */
.ea-toprow-search {
  display: flex;
  align-items: center;
  background: #102B49;
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 25px;
  overflow: hidden;
  height: 44px; /* Taller search */
  flex-grow: 1; /* Fill the header */
  max-width: 800px; /* But don't get too crazy on huge screens */
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.ea-toprow-search:focus-within { border-color: #FFC107; background: #fff; }
.ea-toprow-search input {
  border: none !important;
  background: transparent !important;
  padding: 0 20px !important;
  height: 44px !important;
  font-size: 15px !important;
  color: #FFFFFF !important;
  width: 100%; /* Take up all space in container */
  outline: none !important;
  box-shadow: none !important;
  line-height: 44px !important;
}
.ea-toprow-search input::placeholder { color: #94a3b8; }
.ea-toprow-search button {
  border: none !important;
  background: #FFC107;
  color: #000;
  height: 44px;
  width: 60px; /* Wider button */
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  border-radius: 0 25px 25px 0;
  transition: background 0.2s;
  padding: 0;
}
.ea-toprow-search button:hover { background: #FFFFFF; color: #000; }

/* Responsive */
@media (max-width: 900px) {
  .ea-hdr-tagline { display: none; }
  .ea-hdr-utils { gap: 10px; }
}
@media (max-width: 1024px) {
  .ea-toprow-search { display: none; }
  .ea-toprow-phone .ph-text { display: none; }
}
@media (max-width: 767px) {
  .ea-hdr-utils { display: none; }
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
  font-size: 18px !important;   /* Increased from 17px for premium feel */
}
body {
  font-family: 'Outfit', sans-serif !important;
  font-weight: 500 !important;   /* Gotham Book - Medium Upgrade */
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
  font-weight: 500 !important;
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
  font-size: clamp(2.2rem, 5.5vw, 3.4rem) !important;
  line-height: 1.1 !important;
  letter-spacing: -0.03em;
  color: #0f172a;
}

/* H1 on dark/hero backgrounds stays white */
.sp-hero h1, .sp-hero .sp-hero-h1,
.cat-hero h1, .cat-hero .cat-hero-title,
.ea-seo-hero h1 {
  color: #ffffff !important;
  text-shadow: 0 4px 15px rgba(0,0,0,0.6) !important; /* Stronger 'Pop' to prevent dullness */
}

/* H2 — section headings */
h2, .h2,
.sp-sec-hdr h2,
.cat-sec-hdr h2,
.ea-sec-title {
  font-family: 'Outfit', sans-serif !important;
  font-weight: 800 !important;   /* Gotham Bold-Black */
  font-size: clamp(1.7rem, 4vw, 2.5rem) !important;
  line-height: 1.2 !important;
  letter-spacing: -0.015em;
  color: #1e293b;
}

/* H3 — card/sub-section titles */
h3, .h3,
.sp-why-title,
.cat-why-title,
.ea-card-title {
  font-family: 'Outfit', sans-serif !important;
  font-weight: 700 !important;   /* Gotham Bold */
  font-size: clamp(1.25rem, 2.8vw, 1.7rem) !important;
  line-height: 1.25 !important;
  color: #1e293b;
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
  font-size: 15.5px !important; /* Larger nav font */
  font-weight: 700 !important;
  text-transform: uppercase;
  letter-spacing: 0.03em;
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

/* Hide Redundant Floating WA Icon on Mobile (Audit H-08) */
@media (max-width: 767px) {
  .ht-ctc-chat, .ccw_plugin, .ht_ctc_widget, [id^="ht-ctc-chat"], #ht-ctc-chat { 
    display: none !important; 
  }
}

/* ── Dark-background sections: restore white/light text ── */
#footer,
#footer p, #footer li, #footer a, #footer span,
#footer h2, #footer h3, #footer h4,
.foterlogo p, .footerheading p {
  font-family: 'Outfit', sans-serif !important;
  font-size: 0.92rem !important;
  color: #ffffff !important;
  text-shadow: 0 2px 10px rgba(0,0,0,0.4) !important; /* Force high contrast pop */
}
#footer .footerheading h2,
#footer .footerheading h3 {
  font-size: clamp(1.1rem, 2.2vw, 1.4rem) !important;
  font-weight: 800 !important;
  color: #FFC107 !important; /* Premium Gold */
}

/* Dark sections — ea-dark-section class applied to dark <section> elements */
.ea-dark-section,
.ea-dark-section p,
.ea-dark-section li,
.ea-dark-section span,
.ea-dark-section a,
.ea-dark-section label {
  color: #ffffff !important;
  text-shadow: 0 2px 8px rgba(0,0,0,0.4) !important;
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
  text-shadow: 0 3px 10px rgba(0,0,0,0.5) !important;
}

/* Mobile scale-down */
@media (max-width: 767px) {
  html { font-size: 15px; }
}

/* ====================================================
   EA-HEADER-FOOTER-LOCK-001 — HEADER NAVY FREEZE (GLOBAL)
   Homepage header is the single source of truth for all pages.
   ==================================================== */
#header {
  background: #1D4472 !important;
  position: sticky !important;
  top: 0 !important;
  z-index: 9999 !important;
  box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important;
}
#header .topheader {
  display: none !important; /* remove utility bar globally */
}
#header nav.navbar,
#header .navbar-inverse,
#header .headerbottom,
#header .ea-mega-nav,
#header .ea-mega-panel {
  background: #1D4472 !important;
}
#header .headerbottom,
#header .navbar,
#header .navbar-inverse {
  border-color: rgba(255,255,255,0.08) !important;
}
#header .ea-hdr-tagline,
#header .navbar-inverse .navbar-nav > li > a,
#header .ea-mega-link,
#header .topleftside li,
#header .topleftside li a,
#header .toprightside ul li a,
#header .ea-toprow-search input {
  color: #FFFFFF !important;
}
#header .ea-toprow-phone {
  color: #FFC107 !important; /* Premium Gold Upgrade */
}
#header .ea-toprow-search {
  background: #102B49 !important;
  border: 1px solid rgba(255,255,255,0.08) !important;
}
#header .ea-toprow-search:focus-within {
  background: #102B49 !important;
  border-color: #FFC107 !important;
}
#header .ea-toprow-search input::placeholder {
  color: #8FA3B7 !important;
}
#header .ea-toprow-search button {
  background: #FFC107 !important;
  color: #000 !important;
}
#header .ea-toprow-search button:hover {
  background: #FFFFFF !important;
}
#header .ea-wa-cta-btn {
  background: #25D366 !important;
  color: #ffffff !important;
}
#header .ea-wa-cta-btn:hover {
  background: #128C7E !important;
  color: #ffffff !important;
}
#header .ea-mega-link:hover,
#header .ea-mega-link:focus,
#header .ea-mega-item.is-open > .ea-mega-link {
  color: #FFC107 !important;
  background: rgba(255,255,255,0.08) !important;
  border-bottom-color: #FFC107 !important;
}

/* ===== UNIFIED PREMIUM MEGA MENU ===== */
.ea-mega-panel {
  position: absolute;
  top: 100%;
  left: 0;
  width: 100vw;
  left: calc(-50vw + 50%);
  background: rgba(20, 43, 73, 0.98) !important; /* Slightly darker premium depth */
  backdrop-filter: blur(15px);
  -webkit-backdrop-filter: blur(15px);
  visibility: hidden;
  opacity: 0;
  transform: translateY(12px);
  transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
  padding: 20px 0; /* Tightened panel vertical padding */
  border-top: 2px solid #FFC107;
  box-shadow: 0 25px 60px rgba(0,0,0,0.45);
}
.ea-mega-item:hover .ea-mega-panel {
  visibility: visible;
  opacity: 1;
  transform: translateY(0);
}
.ea-mega-panel-inner {
  max-width: 1400px; /* Increased max-width to utilize widescreen space */
  margin: 0 auto;
  display: flex;
  gap: 30px; /* Reduced gap */
  padding: 0 24px; /* Reduced padding */
}
.ea-panel-imglink {
  display: none !important; /* Hide image panel on desktop to give 100% width to categories */
}
.ea-mega-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); /* Auto-fit columns to span horizontally */
  flex: 1;
  gap: 20px; /* Tightened grid spacing */
}
.ea-mega-col-list {
  list-style: none !important;
  padding: 0 !important;
  margin: 0 !important;
}
.ea-mega-col-list li {
  list-style: none !important;
  padding: 0 !important;
  margin: 0 !important;
}
.ea-mega-col-title {
  color: #FFC107 !important;
  font-size: 13px; /* Highly readable premium title size */
  font-weight: 800;
  text-transform: uppercase;
  margin-bottom: 12px; /* Restored elegant margin */
  letter-spacing: 0.1em;
  border-bottom: 1px solid rgba(255,255,255,0.12);
  padding-bottom: 6px; /* Restored elegant padding */
}
.ea-mega-col-list li a {
  color: rgba(255,255,255,0.92) !important;
  font-size: 14px; /* Highly readable premium body size */
  font-weight: 600;
  text-decoration: none;
  transition: all 0.25s ease;
  padding: 4px 0; /* Restored elegant item padding */
  display: block;
  line-height: 1.4;
}
.ea-mega-col-list li a:hover {
  color: #FFC107 !important;
  transform: translateX(4px);
}

/* ===== AI ASSISTANT BUBBLE (FIX) ===== */
.ea-ai-bubble {
  position: fixed;
  bottom: 100px;
  right: 30px;
  background: #FFC107;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 10px 25px rgba(0,0,0,0.3);
  z-index: 10000;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  border: 2px solid #fff;
  text-decoration: none !important;
}
.ea-ai-bubble:hover {
  transform: scale(1.1) rotate(5deg);
  background: #FFFFFF;
}
.ea-ai-bubble i {
  color: #1D4472;
  font-size: 28px;
}
.ea-ai-bubble::after {
  content: "Ask AI Assistant";
  position: absolute;
  right: 70px;
  background: #fff;
  color: #1D4472;
  padding: 8px 15px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 700;
  white-space: nowrap;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  opacity: 0;
  transform: translateX(10px);
  transition: all 0.3s ease;
  pointer-events: none;
}
.ea-ai-bubble:hover::after {
  opacity: 1;
  transform: translateX(0);
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
                  <?php
                    $white_logo_url = content_url( 'uploads/2024/11/efficient-logo-2.png' );
                    $logo_src       = $white_logo_url;
                  ?>
                  <img src="<?php echo esc_url( $logo_src ); ?>" alt="Efficient Advertising" draggable="false" oncontextmenu="return false;" />
                </a>
              </div>
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
              <input type="search" name="s" placeholder="Ask our AI anything... (e.g. 'What is the best signage for a shop?')" value="<?php echo get_search_query(); ?>" autocomplete="off" />
              <button type="submit" aria-label="Search">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
              </button>
              <input type="hidden" name="post_type" value="product" />
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
              $ea_cat_image_map = function_exists( 'ea_get_catalogue_category_image_map' ) ? ea_get_catalogue_category_image_map() : array();
              if ( ! is_wp_error( $ea_top_cats ) ) :
                foreach ( $ea_top_cats as $ea_cat ) :
                  if ( 'uncategorized' === $ea_cat->slug ) continue;
                  $ea_cat_url  = get_term_link( $ea_cat );
                  $ea_sub_cats = get_terms( array(
                    'taxonomy'   => 'product_cat',
                    'parent'     => $ea_cat->term_id,
                    'hide_empty' => ( 'vehicle-branding' === $ea_cat->slug ) ? false : true,
                    'orderby'    => 'name',
                    'order'      => 'ASC',
                  ) );
                  $ea_has_subs = ( ! is_wp_error( $ea_sub_cats ) && ! empty( $ea_sub_cats ) );
                  /* Representative image: central curated category mapping */
                  $ea_img_html = '';
                  $ea_img_url  = isset( $ea_cat_image_map[ $ea_cat->slug ] ) ? $ea_cat_image_map[ $ea_cat->slug ] : '';
                  if ( $ea_img_url ) {
                    $ea_img_html = sprintf(
                      '<img src="%1$s" class="ea-panel-img" loading="lazy" alt="%2$s" />',
                      esc_url( $ea_img_url ),
                      esc_attr( $ea_cat->name )
                    );
                  }
              ?>
              <li class="ea-mega-item<?php echo $ea_has_subs ? ' ea-has-panel' : ''; ?>">
                <a class="ea-mega-link" href="<?php echo esc_url( $ea_cat_url ); ?>"><?php
                  $ea_nav_label = $ea_cat->name;
                  switch ( $ea_cat->name ) {
    default:
        $ea_nav_label = $ea_cat->name;

        if (stripos($ea_cat->name, 'banner') !== false) {
            $ea_nav_label = 'LARGE FORMAT';
        }
        elseif (stripos($ea_cat->name, 'promotional') !== false) {
            $ea_nav_label = 'CORPORATE GIFTS';
        }
        elseif (stripos($ea_cat->name, 'flag') !== false) {
            $ea_nav_label = 'FLAGS';
        }

        break;
}
                  echo esc_html( $ea_nav_label );
                ?><?php if ( $ea_has_subs ) : ?><svg class="ea-chevron" width="10" height="6" viewBox="0 0 10 6" aria-hidden="true" focusable="false"><polyline points="1,1 5,5 9,1" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg><?php endif; ?></a>
                <?php if ( $ea_has_subs ) : ?>
                <div class="ea-mega-panel">
                  <div class="ea-mega-panel-inner">
                    <?php if ( $ea_img_html ) : ?><a class="ea-panel-imglink" href="<?php echo esc_url( $ea_cat_url ); ?>" tabindex="-1"><?php echo $ea_img_html; ?></a><?php endif; ?>
                    
                    <?php
                    // 1. Get all products under this parent category (including subcategories) in a single high-performance query
                    $all_products = get_posts( array(
                        'post_type'      => 'product',
                        'post_status'    => 'publish',
                        'posts_per_page' => -1,
                        'tax_query'      => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'term_id',
                                'terms'    => $ea_cat->term_id,
                                'include_children' => true,
                            ),
                        ),
                        'orderby'        => 'title',
                        'order'          => 'ASC',
                    ) );

                    // Organize products by subcategory and filter using uppercase SKU validation rules
                    $sub_to_products = array();
                    foreach ( $all_products as $p ) {
                        // Keep only products with non-empty, uppercase SKUs
                        $sku = get_post_meta( $p->ID, '_sku', true );
                        if ( empty( $sku ) || preg_match( '/[a-z]/', $sku ) ) {
                            continue;
                        }

                        $terms = get_the_terms( $p->ID, 'product_cat' );
                        if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
                            foreach ( $terms as $term ) {
                                if ( $term->parent === $ea_cat->term_id ) {
                                    $sub_to_products[ $term->term_id ][] = $p;
                                }
                            }
                        }
                    }

                    // Dynamically build the column structures
                    $sub_cols = array();
                    foreach ( $ea_sub_cats as $ea_sub ) {
                        $prods = isset( $sub_to_products[ $ea_sub->term_id ] ) ? $sub_to_products[ $ea_sub->term_id ] : array();
                        if ( ! empty( $prods ) ) {
                            $col_key = $ea_sub->name . ' (' . count( $prods ) . ')';
                            $sub_cols[ $col_key ] = array();
                            $count = 0;
                            foreach ( $prods as $p ) {
                                if ( $count >= 6 ) break;
                                $sub_cols[ $col_key ][ $p->post_title ] = get_permalink( $p->ID );
                                $count++;
                            }
                        } else {
                            // Fallback to subcategory term link if no products match
                            $col_key = $ea_sub->name;
                            $sub_cols[ $col_key ] = array(
                                'View All ' . $ea_sub->name => get_term_link( $ea_sub )
                            );
                        }
                    }
                    ?>
                    <div class="ea-mega-grid">
                        <?php foreach ( $sub_cols as $col_title => $links ) : ?>
                        <div class="ea-mega-col">
                            <div class="ea-mega-col-title"><?php echo esc_html( $col_title ); ?></div>
                            <ul class="ea-mega-col-list">
                                <?php foreach ( $links as $label => $href ) : ?>
                                <li><a href="<?php echo esc_url( $href ); ?>"><?php echo esc_html( $label ); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endforeach; ?>
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
      var heroPadPx = (window.innerWidth <= 767 ? (h + 16) : h) + 'px';
      if ($('.homebaner').length)  { $('.homebaner')[0].style.setProperty('margin-top', hpx, 'important'); }
      if ($('#ea-hero').length)    { document.getElementById('ea-hero').style.setProperty('margin-top', hpx, 'important'); }
      if ($('#ea-hp-hero').length && window.innerWidth > 767) { document.getElementById('ea-hp-hero').style.setProperty('margin-top', hpx, 'important'); }
      if ($('.sp-hero').length)    { $('.sp-hero')[0].style.setProperty('padding-top', heroPadPx, 'important'); }
      if ($('.cat-hero').length)   { $('.cat-hero')[0].style.setProperty('padding-top', heroPadPx, 'important'); }
      if ($('.ea-cat-hero').length){ $('.ea-cat-hero')[0].style.setProperty('padding-top', heroPadPx, 'important'); }
      if ($('.ea-seo-hero').length){ $('.ea-seo-hero')[0].style.setProperty('padding-top', heroPadPx, 'important'); }
      if ($('.ea-bdhero').length)  { $('.ea-bdhero')[0].style.setProperty('padding-top', heroPadPx, 'important'); }
    }
  }

  // Run immediately on load so carousel is never hidden under header
  updateHeader();

  $(window).on('scroll resize', updateHeader);
  $(window).on('load', updateHeader); // re-run after logo image loads (logo height inflates header)

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

  // Open AI Chatbot on bubble click
  $(document).on('click', '.ea-ai-bubble', function(e) {
    e.preventDefault();
    if (typeof mwai_open_chat === 'function') {
      mwai_open_chat();
    } else {
      // Fallback if global function not found, try clicking the plugin's own bubble if it exists
      $('.mwai-chat-bubble').click();
      // Or show an alert if it's still loading
      if ($('.mwai-chat-bubble').length === 0) {
        console.log("AI Chatbot is still loading...");
      }
    }
  });

  /* ——— EA Mega Menu ——— */
  var $eaToggle  = $('#eaMobToggle');
  var $eaOverlay = $('#eaMobOverlay');
  var $eaNav     = $('#eaMegaNav');
  var $eaClose   = $('#eaMobClose');
  var $eaItems   = $('.ea-mega-item.ea-has-panel');
  var eaHoverTimer;

  function eaOpenDrawer() {
    $eaNav.addClass('is-open');
    $eaOverlay.addClass('is-vis');
    $eaToggle.addClass('is-active').attr('aria-expanded', 'true');
    $('body').css('overflow', 'hidden');
  }
  function eaCloseDrawer() {
    $eaNav.removeClass('is-open');
    $eaOverlay.removeClass('is-vis');
    $eaToggle.removeClass('is-active').attr('aria-expanded', 'false');
    $('body').css('overflow', '');
    $eaItems.removeClass('is-open');
  }

  $eaToggle.on('click', function() {
    $eaNav.hasClass('is-open') ? eaCloseDrawer() : eaOpenDrawer();
  });
  $eaClose.on('click', eaCloseDrawer);
  $eaOverlay.on('click', eaCloseDrawer);

  /* Desktop: hover to open panels */
  function eaSyncDesktopNavOverflow() {
    var $eaList = $eaNav.find('.ea-mega-list').first();
    var usedWidth = 0;

    if (!$eaList.length) {
      return;
    }

    $eaList.children('.ea-mega-item').removeClass('ea-nav-overflow');

    if ($(window).width() <= 991) {
      return;
    }

    $eaList.children('.ea-mega-item').each(function() {
      var $item = $(this);
      var itemWidth = Math.ceil($item.outerWidth(true));

      if (usedWidth + itemWidth > $eaList.innerWidth()) {
        $item.removeClass('is-open').addClass('ea-nav-overflow');
        return;
      }

      usedWidth += itemWidth;
    });
  }

  function eaQueueDesktopNavSync() {
    if (window.requestAnimationFrame) {
      window.requestAnimationFrame(eaSyncDesktopNavOverflow);
      return;
    }

    eaSyncDesktopNavOverflow();
  }

  eaQueueDesktopNavSync();
  $(window).on('load resize orientationchange', eaQueueDesktopNavSync);

  if ($(window).width() > 991) {
    $eaItems
      .on('mouseenter', function() {
        clearTimeout(eaHoverTimer);
        $eaItems.not(this).removeClass('is-open');
        $(this).addClass('is-open');
      })
      .on('mouseleave', function() {
        var $it = $(this);
        eaHoverTimer = setTimeout(function() { $it.removeClass('is-open'); }, 180);
      });
    $eaItems.find('.ea-mega-panel')
      .on('mouseenter', function() { clearTimeout(eaHoverTimer); })
      .on('mouseleave', function() {
        var $it = $(this).closest('.ea-mega-item');
        eaHoverTimer = setTimeout(function() { $it.removeClass('is-open'); }, 180);
      });
    /* Close panel when clicking elsewhere on page */
    $(document).on('click.eamega', function(e) {
      if (!$(e.target).closest('.ea-mega-item').length) {
        $eaItems.removeClass('is-open');
      }
    });
  }

  /* Mobile: accordion (tap category link to expand subs, not navigate) */
  if ($(window).width() <= 991) {
    $eaItems.find('> .ea-mega-link').on('click', function(e) {
      e.preventDefault();
      var $it = $(this).closest('.ea-mega-item');
      var wasOpen = $it.hasClass('is-open');
      $eaItems.removeClass('is-open');
      if (!wasOpen) { $it.addClass('is-open'); }
    });
  }

  // Bulletproof real-time link interceptor and router (WordPress-safe)
  jQuery(document).on('click', 'a[href]', function(e) {
    var href = jQuery(this).attr('href');
    // Ensure it is a valid navigation link
    if (href && href.indexOf('javascript:') === -1 && href.indexOf('#') !== 0 && href.indexOf('mailto:') === -1 && href.indexOf('tel:') === -1) {
      // Ensure it is an internal link on the local preview domain
      if (href.indexOf('newefficientadvertising09042026.local') !== -1 || href.indexOf('/') === 0 || href.indexOf('http') === -1) {
        if (href.indexOf('preview_ea_rhythm') === -1) {
          e.preventDefault(); // Stop standard browser navigation
          var separator = href.indexOf('?') !== -1 ? '&' : '?';
          window.location.href = href + separator + 'preview_ea_rhythm=2'; // Navigate manually with sandbox parameter
        }
      }
    }
  });

});

</script>




<a href="#" class="ea-ai-bubble" onclick="return false;" aria-label="Open AI Assistant">
  <i class="fa fa-magic"></i>
</a>
