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
<?php wp_head(); ?>
	
	<meta name="google-site-verification" content="nsHzgQDRYfrB4J9Man5LqiEjBjCoXYLHI120Gp0SvaQ" />
	
	
</head>
<body <?php body_class(); ?>>



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