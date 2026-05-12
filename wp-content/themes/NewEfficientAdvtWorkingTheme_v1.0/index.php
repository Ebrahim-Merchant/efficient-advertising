<?php
/**
 * Template Name: Home
 * Premium Homepage — Efficient Advertising LLC
 * Canonical homepage renderer (Phase 3D sign-off path).
 *
 * Sections: Hero → Services → Curated Products → Portfolio →
 *           Why Choose Us → CTA → FAQ → Footer
 *
 * @package NewEfficientAdvtWorkingTheme_v1.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( is_page( 'blog' ) || ( is_home() && ! is_front_page() ) ) {
  require __DIR__ . '/page-blog.php';
  return;
}

// 1. Force the premium body class scoping indicator
add_filter( 'body_class', function( $classes ) {
    if ( ! in_array( 'ea-preview-active-v2', $classes ) ) {
        $classes[] = 'ea-preview-active-v2';
    }
    return $classes;
} );

// 2. Load the premium visual rhythm stylesheet
add_action( 'wp_head', function() {
    $css_url = get_template_directory_uri() . '/css/ea-homepage-visual-rhythm-preview-v2.css?v=' . time();
    echo '<link rel="stylesheet" id="ea-visual-preview-v2-css" href="' . esc_url( $css_url ) . '" type="text/css" media="all" />';
}, 20 );

get_header('premium-v2');

/* ── DATA ── */
$wa_url   = 'https://wa.me/971527966265?text=' . rawurlencode( 'Hi, I would like to get a quote for printing/branding services.' );
$quote_url = home_url( '/contact-us/' );
$phone     = '+971 52 796 6265';

/* ── Hero slides: read from central curation file (EA-HOME-CURATION-003) ── */
$hero_slides = ea_get_home_hero_slides();

/* ── Curated products: read IDs from central curation file (EA-HOME-CURATION-003) ── */
$curated_ids = ea_get_home_curated_product_ids();
$curated     = [];
if ( $curated_ids ) {
  $curated_posts = get_posts( [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => count( $curated_ids ),
    'post__in'       => $curated_ids,
    'orderby'        => 'post__in',
  ] );
  foreach ( $curated_posts as $p ) {
    $img = get_the_post_thumbnail_url( $p->ID, 'medium_large' );
    if ( ! $img ) continue;
    // Domain translation for local environment
    $img = str_replace( 'https://efficientadvt.com', home_url(), $img );
    $terms    = get_the_terms( $p->ID, 'product_cat' );
    $cat_name = ( $terms && ! is_wp_error( $terms ) ) ? reset( $terms )->name : '';
    $cat_link = ( $terms && ! is_wp_error( $terms ) ) ? get_term_link( reset( $terms ) ) : '';
    $excerpt  = $p->post_excerpt;
    if ( empty( $excerpt ) ) $excerpt = wp_trim_words( $p->post_content, 12, '…' );
    $curated[] = [
      'id'       => $p->ID,
      'title'    => $p->post_title,
      'url'      => get_permalink( $p->ID ),
      'img'      => $img,
      'cat_name' => $cat_name,
      'cat_url'  => $cat_link,
      'excerpt'  => $excerpt,
    ];
  }
}

/* ── Core services (static — curated selection) ── */
$services = [
  [
    'icon'  => 'fa-print',
    'title' => 'Large Format Printing & Hoarding Solutions',
    'desc'  => 'Vinyl banners, building hoardings, roll-ups and fabric displays — produced in-house with same-day printing available.',
    'url'   => home_url( '/product-category/banners-large-format/' ),
  ],
  [
    'icon'  => 'fa-building',
    'title' => 'Custom Signage & 3D Letter Solutions',
    'desc'  => 'Acrylic, aluminium, LED and illuminated signage — fabricated and installed across Dubai and the UAE.',
    'url'   => home_url( '/product-category/signage/' ),
  ],
  [
    'icon'  => 'fa-car',
    'title' => 'Vehicle Branding & Fleet Graphics',
    'desc'  => 'Full wraps, partial wraps, fleet branding and magnetic signage for cars, vans and trucks across the UAE.',
    'url'   => home_url( '/product-category/vehicle-branding/' ),
  ],
  [
    'icon'  => 'fa-calendar',
    'title' => 'Event Branding & Exhibition Graphics',
    'desc'  => 'Custom exhibition stands, event backdrops, pop-up displays — turnkey fabrication and UAE-wide installation.',
    'url'   => home_url( '/product-category/exhibitions-events/' ),
  ],
  [
    'icon'  => 'fa-sticky-note',
    'title' => 'Stickers & Branding',
    'desc'  => 'Die-cut stickers, wall graphics, floor decals, window frosting — any surface, any size.',
    'url'   => home_url( '/product-category/stickers-branding/' ),
  ],
  [
    'icon'  => 'fa-gift',
    'title' => 'Promotional & Corporate Gifts',
    'desc'  => 'Branded apparel, packaging, drinkware, executive kits — customised for your brand.',
    'url'   => home_url( '/product-category/promotional-gifts/' ),
  ],
];

/* ── Recent work: read from central curation file (EA-HOME-CURATION-003) ── */
$portfolio = ea_get_home_recent_work_items();
if ( ! empty( $portfolio ) ) {
  foreach ( $portfolio as &$pf ) {
    $pf['image_url'] = str_replace( 'https://efficientadvt.com', home_url(), $pf['image_url'] );
  }
  unset( $pf );
}

$instagram_url = 'https://www.instagram.com/efficientuae/';

/* ── Curated social proof (selected, no feed widgets) ── */
$google_reviews = [
  [
    'name'   => 'Ahmed R.',
    'rating' => '5.0',
    'text'   => 'Outstanding quality and very fast turnaround. Our signage and event branding looked premium and the team delivered exactly on schedule.',
  ],
  [
    'name'   => 'Sara M.',
    'rating' => '5.0',
    'text'   => 'Professional team from briefing to installation. Vehicle branding finish was clean and durable, and communication was excellent throughout.',
  ],
  [
    'name'   => 'Mohammed K.',
    'rating' => '5.0',
    'text'   => 'Reliable Dubai partner for banners and exhibition graphics. Great print clarity, helpful design support, and responsive service on urgent jobs.',
  ],
  [
    'name'   => 'Lina A.',
    'rating' => '5.0',
    'text'   => 'Efficient, detail-focused, and easy to work with. The final output matched our brand standards perfectly across all materials.',
  ],
];

$youtube_videos = [
  [
    'id'    => 'lsu0EGYvGKw',
    'title' => 'Printing & Branding Showcase',
  ],
  [
    'id'    => 'SdWYXXcJqaI',
    'title' => 'Recent Production Highlights',
  ],
];

/* ── Company logos (from uploaded zip) ── */
$client_logos = [];
$logo_dir = trailingslashit( get_stylesheet_directory() ) . 'assets/company-logos/Company Logos/';
if ( is_dir( $logo_dir ) ) {
  $logo_files = [];
  $all_files = scandir( $logo_dir );
  if ( is_array( $all_files ) ) {
    foreach ( $all_files as $file ) {
      if ( in_array( strtolower( pathinfo( $file, PATHINFO_EXTENSION ) ), ['webp', 'png', 'jpg', 'jpeg', 'svg'] ) ) {
        $logo_files[] = $logo_dir . $file;
      }
    }
  }
  if ( ! empty( $logo_files ) ) {
    natcasesort( $logo_files );
    foreach ( $logo_files as $logo_file ) {
      $company = pathinfo( $logo_file, PATHINFO_FILENAME );
      $company = preg_replace( '/[^\PC\s]/u', '', $company );
      $company = trim( preg_replace( '/\s+/', ' ', $company ) );
      if ( $company === '' ) continue;

      $rel = str_replace( '\\', '/', str_replace( trailingslashit( get_stylesheet_directory() ), '', $logo_file ) );
      $segments = array_map( 'rawurlencode', explode( '/', $rel ) );
      $logo_url = trailingslashit( get_stylesheet_directory_uri() ) . implode( '/', $segments );

      $client_logos[] = [
        'name' => $company,
        'url'  => $logo_url,
        'alt'  => $company . ' logo – client of Efficient Advertising Dubai',
      ];
    }
  }
}

if ( ! empty( $client_logos ) ) {
  $client_logos = array_slice( $client_logos, 0, 10 );
}

/* ── Blog preview (prioritize SEO-updated posts) ── */
$blog_preview_posts = [];

$seo_blog_titles = [
  'How to Choose the Right Signage Company in Dubai (2026 Guide)',
  'Banner Printing in Dubai: Pricing, Materials & Business Guide',
];

$seo_blog_ids = [];
foreach ( $seo_blog_titles as $seo_title ) {
  $seo_post = get_page_by_title( $seo_title, OBJECT, 'post' );
  if ( $seo_post && ! empty( $seo_post->ID ) ) {
    $seo_blog_ids[] = (int) $seo_post->ID;
  }
}

if ( ! empty( $seo_blog_ids ) ) {
  $blog_preview_posts = get_posts( [
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 2,
    'post__in'            => $seo_blog_ids,
    'orderby'             => 'post__in',
    'ignore_sticky_posts' => true,
  ] );
}

if ( count( $blog_preview_posts ) < 2 ) {
  $existing_ids = wp_list_pluck( $blog_preview_posts, 'ID' );
  $fallback_posts = get_posts( [
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 2 - count( $blog_preview_posts ),
    'orderby'             => 'date',
    'order'               => 'DESC',
    'post__not_in'        => $existing_ids,
    'ignore_sticky_posts' => true,
  ] );
  $blog_preview_posts = array_merge( $blog_preview_posts, $fallback_posts );
}

if ( empty( $blog_preview_posts ) ) {
  $blog_preview_posts = [
    (object) [
      'ID'         => 0,
      'post_title' => 'Banner Printing Dubai: Choosing the Right Material',
      'post_excerpt' => 'A practical guide to selecting banner materials for indoor and outdoor campaigns in Dubai.',
    ],
    (object) [
      'ID'         => 0,
      'post_title' => 'Vehicle Branding Dubai: What to Prepare Before Printing',
      'post_excerpt' => 'Key checklist to speed up approvals, avoid delays, and get high-impact fleet branding results.',
    ],
  ];
}

/* ── FAQ ── */
$faqs = [
  [ 'q' => 'What is the best exhibition stand company in Dubai?',          'a' => 'Efficient Advertising is a leading exhibition stand company in Dubai, offering custom design, in-house fabrication and on-site installation — from portable pop-up displays to full modular builds for trade shows and corporate events across the UAE.' ],
  [ 'q' => 'Do you provide event branding installation across the UAE?',   'a' => 'Yes. We provide full event branding services including production and on-site installation across Dubai, Abu Dhabi, Sharjah, and all seven Emirates — from small corporate launches to large-scale trade shows.' ],
  [ 'q' => 'How much does vehicle branding cost in Dubai?',                'a' => 'Vehicle branding costs vary by vehicle size and print coverage. Full wraps for cars start from AED 1,800 and vans from AED 2,500. Contact us for a tailored fleet branding quote.' ],
  [ 'q' => 'Do you offer custom signage fabrication in Dubai?',            'a' => 'Yes — our Dubai facility produces custom signage including 3D acrylic letters, illuminated channel signs, aluminium composite boards and LED signage. All fabrication and installation is handled in-house.' ],
  [ 'q' => 'Can you handle large-format hoarding printing projects?',      'a' => 'Absolutely. We produce large-format hoardings for construction sites, retail frontages and outdoor advertising campaigns across Dubai and the UAE — with same-day printing available for urgent deadlines.' ],
  [ 'q' => 'Do you offer same-day printing services in Dubai?',            'a' => 'Yes — same-day printing is available for banners, roll-up stands, business cards and select items when artwork is submitted before 10am. Our in-house production line ensures fast output without quality compromise.' ],
  [ 'q' => 'What materials are used for outdoor signage and hoardings?',   'a' => 'We use premium outdoor-rated materials including UV-resistant vinyl, aluminium composite panels, correx boards, PVC foam and mesh banner fabric — all suited to Dubai\'s climate and long-term outdoor durability.' ],
  [ 'q' => 'Do you provide design, production and installation services?', 'a' => 'Yes — we are a fully integrated branding company. Our in-house team handles concept design, artwork preparation, production and on-site installation for signage, exhibition stands, hoardings and vehicle branding projects across the UAE.' ],
];
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/premium-homepage.css?v=2.0">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/ea-home-shell-014.css?v=2.0">

<!-- HOMEPAGE_RENDERER: index-premium-v2.php sandbox -->
<style>
/* Ensure no gap between header and hero */
body.home #header, body.page-template-index #header {
  margin-bottom: 0 !important;
}
body.home #ea-hp-hero, body.page-template-index #ea-hp-hero {
  margin-top: 0 !important;
  padding-top: 0 !important;
}
body.home #ea-hp-trust-strip {
  height: auto !important;
  min-height: auto !important;
  max-height: none !important;
  padding: 12px 0 !important;
  margin-top: 0 !important;
}
body.home .topheader .container,
body.page-template-index .topheader .container {
  display: flex !important;
  justify-content: center !important;
  align-items: center !important;
}
body.home .topheader .topleftside,
body.page-template-index .topheader .topleftside {
  float: none !important;
  width: auto !important;
}
body.home .topheader .topleftside ul,
body.page-template-index .topheader .topleftside ul {
  display: flex !important;
  justify-content: center !important;
  gap: 24px !important;
  flex-wrap: wrap !important;
}
body.home .topheader .toprightside,
body.page-template-index .topheader .toprightside {
  display: none !important;
}
body.home .ea-mega-list > .ea-mega-item > .ea-mega-link,
body.page-template-index .ea-mega-list > .ea-mega-item > .ea-mega-link {
  font-size: 12.5px !important;
  font-weight: 700 !important;
  padding-top: 11px !important;
  padding-bottom: 11px !important;
  letter-spacing: 0.003em !important;
}
@media (max-width: 1024px) {
  body.home .ea-hdr-brand .logo img,
  body.page-template-index .ea-hdr-brand .logo img {
    height: 56px !important;
  }
}

/* ─────────────────────────────────────────────
   POINT 3: HERO CTA HOVER ANIMATIONS & UPGRADES
   ───────────────────────────────────────────── */
.ea-hp-btn {
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
  position: relative !important;
  overflow: hidden !important;
}
.ea-hp-btn--primary {
  background: linear-gradient(135deg, #FFC107 0%, #FFA000 100%) !important;
  border: none !important;
  color: #0B1F38 !important;
  font-weight: 700 !important;
  box-shadow: 0 4px 15px rgba(255, 193, 7, 0.25) !important;
}
.ea-hp-btn--primary:hover {
  transform: translateY(-3px) scale(1.02) !important;
  box-shadow: 0 8px 25px rgba(255, 193, 7, 0.45) !important;
  color: #0B1F38 !important;
}
.ea-hp-btn--whatsapp {
  background: #25D366 !important;
  border: none !important;
  color: #FFFFFF !important;
  font-weight: 600 !important;
  box-shadow: 0 4px 15px rgba(37, 211, 102, 0.2) !important;
}
.ea-hp-btn--whatsapp:hover {
  transform: translateY(-3px) scale(1.02) !important;
  box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4) !important;
  color: #FFFFFF !important;
}

/* ─────────────────────────────────────────────
   POINT 4: FLOATING QUICK-ACTION CATEGORY PILLS (LIGHT THEME)
   ───────────────────────────────────────────── */
.ea-hp-hero-pills {
  margin: 28px auto 36px auto !important;
  display: flex;
  flex-direction: column;
  gap: 12px;
  max-width: 680px !important;
  align-items: center !important;
}
.ea-hp-hero-pills-title {
  font-size: 13px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  color: rgba(11, 31, 56, 0.65) !important;
  display: inline-block;
  text-shadow: none !important;
}
.ea-hp-pills-list {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  justify-content: center !important;
}
.ea-hp-pill {
  display: inline-flex;
  align-items: center;
  padding: 8px 18px;
  background: rgba(255, 255, 255, 0.85) !important;
  border: 1px solid rgba(11, 31, 56, 0.15) !important;
  border-radius: 50px;
  color: #0B1F38 !important;
  font-size: 13.5px;
  font-weight: 600;
  text-decoration: none !important;
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
}
.ea-hp-pill:hover {
  background: #0B1F38 !important;
  border-color: #0B1F38 !important;
  color: #FFFFFF !important;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(11, 31, 56, 0.2);
}
.ea-hp-pill:active {
  transform: translateY(0);
}

/* ─────────────────────────────────────────────
   FULL-BLEED BACKGROUND CAROUSEL OVERRIDES
   ───────────────────────────────────────────── */
#ea-hp-hero {
  position: relative !important;
  width: 100% !important;
  height: 680px !important;
  min-height: 85vh !important;
  overflow: hidden !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  background: #F4F6F9 !important; /* Clean light fallback background */
  padding: 0 !important;
  margin: 0 !important;
}

/* Slider Background layer */
.ea-hp-hero-bg-carousel {
  position: absolute !important;
  top: 0 !important;
  left: 0 !important;
  width: 100% !important;
  height: 100% !important;
  z-index: 1 !important;
}

/* Shifting slides - Slowed down and softened transition */
.ea-hp-hero-bg-slide {
  position: absolute !important;
  top: 0 !important;
  left: 0 !important;
  width: 100% !important;
  height: 100% !important;
  background-size: cover !important;
  background-position: center !important;
  opacity: 0 !important;
  transition: opacity 1.8s ease-in-out !important; /* Luxurious, slow cross-fade */
  z-index: 1 !important;
}

.ea-hp-hero-bg-slide.is-active {
  opacity: 1 !important;
  z-index: 2 !important;
}

/* Bright, Premium Glassmorphism White Overlay on Top of Background Images */
.ea-hp-hero-bg-overlay {
  position: absolute !important;
  top: 0 !important;
  left: 0 !important;
  width: 100% !important;
  height: 100% !important;
  background: linear-gradient(135deg, rgba(255, 255, 255, 0.94) 0%, rgba(245, 247, 250, 0.88) 50%, rgba(255, 255, 255, 0.96) 100%) !important;
  z-index: 3 !important;
}

/* Elegant Center-Aligned Content Area */
.ea-hp-hero-inner {
  position: relative !important;
  z-index: 4 !important;
  width: 100% !important;
  max-width: 1000px !important;
  margin: 0 auto !important;
  padding: 0 24px !important;
  display: block !important; /* Overriding layout splits */
}

.ea-hp-hero-content {
  width: 100% !important;
  max-width: 860px !important;
  margin: 0 auto !important;
  text-align: center !important;
}

/* ELITE TEXT PALETTE OVERRIDES - BRAND NAVY STANDARD */
body #ea-hp-hero .ea-hp-hero-label {
  display: inline-block !important;
  color: #0B1F38 !important;
  border: 1px solid rgba(11, 31, 56, 0.15) !important;
  background: rgba(11, 31, 56, 0.05) !important;
  padding: 6px 18px !important;
  border-radius: 30px !important;
  font-size: 12px !important;
  font-weight: 700 !important;
  letter-spacing: 0.08em !important;
  text-transform: uppercase !important;
  margin-bottom: 24px !important;
  text-shadow: none !important;
}

body #ea-hp-hero .ea-hp-hero-content h1 {
  color: #0B1F38 !important; /* Brand-Standard corporate Navy Blue heading */
  font-size: 3.3rem !important;
  line-height: 1.22 !important;
  font-weight: 800 !important;
  margin-top: 15px !important;
  margin-bottom: 24px !important;
  text-shadow: none !important;
}

/* Elegant gold-orange highlight for key services, perfectly readable on light overlay */
body #ea-hp-hero .ea-hp-hero-content h1 .ea-highlight-gold {
  background: linear-gradient(135deg, #FF9100 0%, #E65100 100%) !important;
  -webkit-background-clip: text !important;
  -webkit-text-fill-color: transparent !important;
  display: inline !important;
  font-weight: 800 !important;
}

body #ea-hp-hero .ea-hp-hero-content > p {
  color: #455A64 !important; /* Soft charcoal-grey paragraph for flawless readability */
  font-size: 1.18rem !important;
  line-height: 1.65 !important;
  margin: 0 auto 32px auto !important;
  max-width: 740px !important;
  text-shadow: none !important;
}

.ea-hp-hero-ctas {
  justify-content: center !important;
  gap: 16px !important;
}

body #ea-hp-hero .ea-hp-hero-micro {
  text-align: center !important;
  color: rgba(11, 31, 56, 0.7) !important;
  margin-top: 24px !important;
  font-size: 14.5px !important;
  text-shadow: none !important;
}

body #ea-hp-hero .ea-hp-hero-micro a {
  color: #E65100 !important;
  font-weight: 600 !important;
}

/* Disable the original media block since we are full-bleed */
.ea-hp-hero-media {
  display: none !important;
}

/* Light-break backgrounds only */
#ea-hp-products { background: #EDF4FF !important; }
#ea-hp-faq { background: #EDF4FF !important; }

/* Logos: pure white with dark clear fonts */
#ea-hp-logos { background: #FFFFFF !important; }
#ea-hp-logos .ea-hp-section-header h2 { color: #0F172A !important; }
#ea-hp-logos .ea-hp-section-header p { color: #334155 !important; }

.ea-mobile-hero-search {
  display: none !important;
}

@media (max-width: 991px) {
  #ea-hp-hero {
    height: auto !important;
    min-height: 0 !important;
    align-items: flex-start !important;
    padding: 24px 0 40px !important;
  }

  .ea-hp-hero-split-container {
    min-height: 0 !important;
    height: auto !important;
    align-items: stretch !important;
  }

  .ea-hp-hero-split-text,
  .ea-hp-hero-split-gallery {
    margin-top: 0 !important;
  }

  .ea-mobile-hero-search {
    display: block !important;
    width: 100% !important;
    margin: 16px 0 24px !important;
  }

  .ea-mobile-hero-search form {
    display: flex !important;
    align-items: center !important;
    gap: 0 !important;
    width: 100% !important;
    background: #ffffff !important;
    border: 1px solid rgba(20, 54, 92, 0.14) !important;
    border-radius: 999px !important;
    overflow: hidden !important;
    box-shadow: 0 12px 28px rgba(20, 54, 92, 0.12) !important;
  }

  .ea-mobile-hero-search input {
    flex: 1 1 auto !important;
    min-width: 0 !important;
    height: 52px !important;
    border: 0 !important;
    background: transparent !important;
    color: #14365C !important;
    font-size: 15px !important;
    padding: 0 18px !important;
    box-shadow: none !important;
    outline: none !important;
  }

  .ea-mobile-hero-search input::placeholder {
    color: #64748b !important;
  }

  .ea-mobile-hero-search button {
    width: 56px !important;
    height: 52px !important;
    border: 0 !important;
    background: #14365C !important;
    color: #ffffff !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex: 0 0 56px !important;
    padding: 0 !important;
  }
}

@media (max-width: 767px) {
  #ea-hp-hero {
    height: auto !important;
    min-height: 0 !important;
    align-items: flex-start !important;
    padding: 0 0 32px !important;
  }

  .ea-hp-hero-split-container {
    min-height: 0 !important;
    height: auto !important;
    align-items: stretch !important;
  }

  .ea-hp-hero-split-text {
    margin-top: 0 !important;
  }

  .ea-hp-hero-split-gallery {
    margin-top: 0 !important;
  }
}
</style>

<!-- ═══════════════════════════════════════════
     SECTION 1 — PREMIUM HERO
     ═══════════════════════════════════════════ -->
<?php 
$first_slide = ! empty( $hero_slides ) ? $hero_slides[0] : null; 

// Dynamic Layout Mode selection for previewing the 3 design options
$layout_mode = isset( $_GET['layout'] ) ? sanitize_key( $_GET['layout'] ) : 'option1';
if ( ! in_array( $layout_mode, [ 'option1', 'option2', 'option3' ] ) ) {
    $layout_mode = 'option1';
}

// Single Premium Product backgrounds (one high-end project at a time as requested)
$single_slides = [];
if ( ! empty( $hero_slides ) ) {
  foreach ( $hero_slides as $slide ) {
    $single_slides[] = home_url( str_replace( 'https://efficientadvt.com', '', $slide['image_url'] ) );
  }
}
if ( empty( $single_slides ) ) {
  $single_slides[] = home_url( '/wp-content/uploads/product-sku-images/sg-003.webp' );
}
?>
<section id="ea-hp-hero" class="layout-<?php echo esc_attr( $layout_mode ); ?>">

  <?php if ( $layout_mode === 'option1' ) : ?>
    <!-- ── OPTION 1: APPLE-STYLE CINEMATIC SPLIT ── -->
    <div class="ea-hp-hero-split-container">
      <div class="ea-hp-hero-split-text">
        <div class="ea-mobile-hero-search" aria-label="Search products">
          <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
            <input type="search" name="s" placeholder="Search products or services" value="<?php echo esc_attr( get_search_query() ); ?>" autocomplete="off" />
            <button type="submit" aria-label="Search">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>
            <input type="hidden" name="post_type" value="product" />
          </form>
        </div>
        <h1><?php echo $first_slide ? esc_html( $first_slide['heading'] ) : 'Premium Exhibition, Signage &amp; Branding Company'; ?></h1>
        <p><?php echo $first_slide ? esc_html( $first_slide['text'] ) : ''; ?></p>

        <div class="ea-hp-hero-ctas">
          <a href="<?php echo esc_url( home_url( '/catalogue/' ) ); ?>" class="ea-hp-btn ea-hp-btn--primary">Browse Catalogue</a>
          <a href="<?php echo esc_url( $wa_url ); ?>" class="ea-hp-btn ea-hp-btn--whatsapp" target="_blank" rel="noopener noreferrer">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            WhatsApp Us
          </a>
        </div>
        <p class="ea-hp-hero-micro"><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">Request a Quote</a> — Free consultation · Quick response</p>
      </div>

      <div class="ea-hp-hero-split-gallery">
        <div class="ea-hp-hero-gallery-frame">
          <div class="ea-hp-hero-bg-carousel">
            <?php foreach ( $single_slides as $slide_index => $slide_img ) : ?>
            <div 
              class="ea-hp-hero-bg-slide<?php echo $slide_index === 0 ? ' is-active' : ''; ?>" 
              data-hero-bg-slide
              data-collage-bg="<?php echo esc_url( $slide_img ); ?>"
            ></div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

  <?php elseif ( $layout_mode === 'option2' ) : ?>
    <!-- ── OPTION 2: STRIPE-STYLE BENTO GRID ── -->
    <div class="ea-bento-container">
      
      <!-- Top Left: Main Copy Card -->
      <div class="ea-bento-card-main">
        <div class="ea-mobile-hero-search" aria-label="Search products">
          <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
            <input type="search" name="s" placeholder="Search products or services" value="<?php echo esc_attr( get_search_query() ); ?>" autocomplete="off" />
            <button type="submit" aria-label="Search">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>
            <input type="hidden" name="post_type" value="product" />
          </form>
        </div>
        <h1><?php echo $first_slide ? esc_html( $first_slide['heading'] ) : 'Premium Exhibition, Signage &amp; Branding'; ?></h1>
        <p><?php echo $first_slide ? esc_html( $first_slide['text'] ) : ''; ?></p>
        
        <div class="ea-hp-hero-ctas">
          <a href="<?php echo esc_url( home_url( '/catalogue/' ) ); ?>" class="ea-hp-btn ea-hp-btn--primary">Browse Catalogue</a>
          <a href="<?php echo esc_url( $wa_url ); ?>" class="ea-hp-btn ea-hp-btn--whatsapp" target="_blank" rel="noopener noreferrer">WhatsApp Us</a>
        </div>
      </div>

      <!-- Top Right: Active Rotating Showcase Card (Displays single image rotating) -->
      <div class="ea-bento-card-gallery">
        <div class="ea-hp-hero-bg-carousel">
          <?php foreach ( $single_slides as $slide_index => $slide_img ) : ?>
          <div 
            class="ea-hp-hero-bg-slide<?php echo $slide_index === 0 ? ' is-active' : ''; ?>" 
            data-hero-bg-slide
            data-collage-bg="<?php echo esc_url( $slide_img ); ?>"
          ></div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Bottom Grid Row: Service Pillars (Each card displays a single image) -->
      <div class="ea-bento-subgrid">
        <div class="ea-bento-card-sub" data-collage-bg="<?php echo esc_url( home_url('/wp-content/uploads/product-sku-images/ee-002.webp') ); ?>">
          <div class="ea-hp-hero-collage-label">
            <span>Trade Show Booths</span>
          </div>
        </div>
        <div class="ea-bento-card-sub" data-collage-bg="<?php echo esc_url( home_url('/wp-content/uploads/product-sku-images/fl-001.webp') ); ?>">
          <div class="ea-hp-hero-collage-label">
            <span>Outdoor Flags</span>
          </div>
        </div>
        <div class="ea-bento-card-sub" data-collage-bg="<?php echo esc_url( home_url('/wp-content/uploads/product-sku-images/vb-002.webp') ); ?>">
          <div class="ea-hp-hero-collage-label">
            <span>Vehicle wraps</span>
          </div>
        </div>
      </div>

    </div>

  <?php elseif ( $layout_mode === 'option3' ) : ?>
    <!-- ── OPTION 3: PORSCHE-STYLE FULL-BLEED CINEMATIC THEATER ── -->
    <div class="ea-hp-hero-full-carousel">
      <div class="ea-hp-hero-bg-carousel">
        <?php foreach ( $single_slides as $slide_index => $slide_img ) : ?>
        <div 
          class="ea-hp-hero-bg-slide<?php echo $slide_index === 0 ? ' is-active' : ''; ?>" 
          data-hero-bg-slide
          data-collage-bg="<?php echo esc_url( $slide_img ); ?>"
        ></div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="ea-hp-hero-bg-overlay-dark"></div>

    <div class="ea-hp-hero-inner-center">
      <div class="ea-mobile-hero-search" aria-label="Search products">
        <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
          <input type="search" name="s" placeholder="Search products or services" value="<?php echo esc_attr( get_search_query() ); ?>" autocomplete="off" />
          <button type="submit" aria-label="Search">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          </button>
          <input type="hidden" name="post_type" value="product" />
        </form>
      </div>
      <h1><?php echo $first_slide ? esc_html( $first_slide['heading'] ) : 'Premium Exhibition, Signage &amp; Branding Company'; ?></h1>
      <p><?php echo $first_slide ? esc_html( $first_slide['text'] ) : ''; ?></p>
      
      <div class="ea-hp-hero-ctas">
        <a href="<?php echo esc_url( home_url( '/catalogue/' ) ); ?>" class="ea-hp-btn ea-hp-btn--primary">Browse Catalogue</a>
        <a href="<?php echo esc_url( $wa_url ); ?>" class="ea-hp-btn ea-hp-btn--whatsapp" target="_blank" rel="noopener noreferrer">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          WhatsApp Us
        </a>
      </div>
      <p class="ea-hp-hero-micro"><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">Request a Quote</a> — Free consultation · Quick response</p>
    </div>
  <?php endif; ?>



</section>

<!-- LUXURIOUS, SLOW-PACED 7-SECOND BG ROTATOR -->
<script>
(function() {
  var slides = Array.prototype.slice.call(document.querySelectorAll('[data-hero-bg-slide]'));
  if (!slides.length || slides.length < 2) return;
  var index = 0;
  setInterval(function() {
    slides[index].classList.remove('is-active');
    index = (index + 1) % slides.length;
    slides[index].classList.add('is-active');
  }, 7000); // 7-second peaceful pause
})();
</script>

<!-- ═══════════════════════════════════════════
     SECTION 2 — TRUST STRIP
     ═══════════════════════════════════════════ -->
<section id="ea-hp-trust-strip">
  <div class="ea-hp-container">
    <div class="ea-hp-trust-grid">
      <div class="ea-hp-trust-item">
        <strong>500K+</strong><span>Sq. Ft. Printed</span>
      </div>
      <div class="ea-hp-trust-item">
        <strong>500+</strong><span>Clients Served</span>
      </div>
      <div class="ea-hp-trust-item">
        <strong>18+</strong><span>Years Experience</span>
      </div>
      <div class="ea-hp-trust-item">
        <strong>4.8★</strong><span>Google Rating</span>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     SECTION 3 — CORE SERVICES
     ═══════════════════════════════════════════ -->
<section id="ea-hp-services">
  <div class="ea-hp-container">
    <div class="ea-hp-section-header">
      <span class="ea-hp-label">What We Do</span>
      <h2>Core Services</h2>
      <p>Complete signage, exhibition, printing, and branding solutions in Dubai</p>
    </div>
    <div class="ea-hp-services-grid">
      <?php foreach ( $services as $svc ) : ?>
      <a href="<?php echo esc_url( $svc['url'] ); ?>" class="ea-hp-service-card">
        <div class="ea-hp-service-icon"><i class="fa <?php echo esc_attr( $svc['icon'] ); ?>"></i></div>
        <h3><?php echo esc_html( $svc['title'] ); ?></h3>
        <p><?php echo esc_html( $svc['desc'] ); ?></p>
        <span class="ea-hp-service-arrow">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     SECTION 4 — CURATED PRODUCTS
     ═══════════════════════════════════════════ -->
<section id="ea-hp-products">
  <div class="ea-hp-container">
    <div class="ea-hp-section-header">
      <span class="ea-hp-label">Our Products</span>
      <h2>Featured Branding, Signage &amp; Exhibition Solutions</h2>
      <p>Browse our most popular categories, then explore our <a href="<?php echo esc_url( home_url( '/catalogue/' ) ); ?>">catalogue</a> or request a quick quote via our <a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">contact page</a>.</p>
    </div>
    <div class="ea-hp-products-grid">
      <?php foreach ( $curated as $item ) : ?>
      <a href="<?php echo esc_url( $item['url'] ); ?>" class="ea-product-card">
        <div class="ea-product-card__img">
          <img src="<?php echo esc_url( $item['img'] ); ?>" alt="<?php echo esc_attr( $item['title'] . ' in ' . $item['cat_name'] . ' by Efficient Advertising Dubai' ); ?>" loading="lazy" width="400" height="300">
        </div>
        <div class="ea-product-card__body">
          <span class="ea-product-card__cat"><?php echo esc_html( $item['cat_name'] ); ?></span>
          <h3><?php echo esc_html( $item['title'] ); ?></h3>
          <p><?php echo esc_html( wp_trim_words( $item['excerpt'], 10, '…' ) ); ?></p>
          <span class="ea-product-card__cta">View Product <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="13" height="13"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <div class="ea-hp-products-more">
      <a href="<?php echo home_url( '/catalogue/' ); ?>" class="ea-hp-btn ea-hp-btn--outline">View All Products</a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     SECTION 5 — PORTFOLIO
     ═══════════════════════════════════════════ -->
<section id="ea-hp-portfolio">
  <div class="ea-hp-container">
    <div class="ea-hp-section-header">
      <span class="ea-hp-label">Our Work</span>
      <h2>Recent Projects</h2>
      <p>A selection of recent work across signage, events, vehicle branding and large-format printing.</p>
    </div>
    <div class="ea-hp-portfolio-grid">
      <?php foreach ( $portfolio as $pf ) : ?>
      <div class="ea-hp-portfolio-item">
        <img src="<?php echo esc_url( $pf['image_url'] ); ?>" alt="<?php echo esc_attr( $pf['title'] . ' — ' . $pf['subtitle'] ); ?>" loading="lazy" width="600" height="400">
        <div class="ea-hp-portfolio-overlay">
          <span><?php echo esc_html( $pf['title'] ); ?></span>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="ea-hp-portfolio-more">
      <a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" class="ea-hp-btn ea-hp-btn--outline">
        View on Instagram
      </a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     SECTION 6 — SELECTED GOOGLE REVIEWS
     ═══════════════════════════════════════════ -->
<section id="ea-hp-reviews">
  <div class="ea-hp-container">
    <div class="ea-hp-section-header">
      <span class="ea-hp-label">Google Reviews</span>
      <h2>Trusted by Clients Across Dubai</h2>
      <p>Selected customer feedback from verified Google reviews.</p>
    </div>
    <div class="ea-hp-reviews-grid">
      <?php foreach ( $google_reviews as $review ) : ?>
      <article class="ea-hp-review-card">
        <div class="ea-hp-review-stars" aria-label="Rated <?php echo esc_attr( $review['rating'] ); ?> out of 5">★★★★★</div>
        <p class="ea-hp-review-text"><?php echo esc_html( $review['text'] ); ?></p>
        <div class="ea-hp-review-meta">
          <strong><?php echo esc_html( $review['name'] ); ?></strong>
          <span>Google Review</span>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     SECTION 6B — COMPANY LOGOS
     ═══════════════════════════════════════════ -->
<?php if ( ! empty( $client_logos ) ) : ?>
<section id="ea-hp-logos">
  <div class="ea-hp-container">
    <div class="ea-hp-section-header">
      <h2>Trusted by Businesses Across the UAE</h2>
      <p>Supporting brands across Dubai with signage, printing, branding, and event solutions.</p>
    </div>

    <div class="ea-hp-logos-grid" aria-label="Client logos">
      <?php foreach ( $client_logos as $logo ) : ?>
        <div class="ea-hp-logo-item">
          <div class="ea-hp-logo-box">
            <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr( $logo['alt'] ); ?>" loading="lazy" width="140" height="80">
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="ea-hp-logos-more">
      <a href="<?php echo esc_url( home_url( '/catalogue/' ) ); ?>" class="ea-hp-btn ea-hp-btn--outline">View Our Catalogue</a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════
     SECTION 7 — FEATURED YOUTUBE VIDEOS
     ═══════════════════════════════════════════ -->
<section id="ea-hp-videos">
  <div class="ea-hp-container">
    <div class="ea-hp-section-header">
      <span class="ea-hp-label">Featured Videos</span>
      <h2>Behind Our Recent Work</h2>
      <p>Selected video highlights from our production and installation projects.</p>
    </div>
    <div class="ea-hp-videos-grid">
      <?php foreach ( $youtube_videos as $video ) : ?>
      <?php
        $video_id    = isset( $video['id'] ) ? $video['id'] : '';
        $video_title = isset( $video['title'] ) ? $video['title'] : 'Featured Video';
        $video_url   = 'https://www.youtube.com/watch?v=' . rawurlencode( $video_id );
        $video_thumb = 'https://i.ytimg.com/vi/' . rawurlencode( $video_id ) . '/hqdefault.jpg';
      ?>
      <article class="ea-hp-video-card">
        <div class="ea-hp-video-frame">
          <a class="ea-hp-video-thumb" href="<?php echo esc_url( $video_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Watch <?php echo esc_attr( $video_title ); ?> on YouTube">
            <img
              src="<?php echo esc_url( $video_thumb ); ?>"
              alt="<?php echo esc_attr( $video_title ); ?> video thumbnail"
              loading="lazy"
              width="640"
              height="360"
              onerror="this.onerror=null;this.src='https://via.placeholder.com/640x360/0B1F38/F5F7FA?text=Efficient+Advertising+Video';"
            >
            <span class="ea-hp-video-play" aria-hidden="true">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
            </span>
          </a>
        </div>
        <h3><?php echo esc_html( $video_title ); ?></h3>
      </article>
      <?php endforeach; ?>
    </div>
    <div class="ea-hp-portfolio-more">
      <a href="https://www.youtube.com/@efficientuae" target="_blank" rel="noopener noreferrer" class="ea-hp-btn ea-hp-btn--outline">
        View on YouTube
      </a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     SECTION 8 — WHY CHOOSE US
     ═══════════════════════════════════════════ -->
<section id="ea-hp-why">
  <div class="ea-hp-container">
    <div class="ea-hp-section-header">
      <span class="ea-hp-label">WHY LEADING BRANDS CHOOSE US</span>
      <h2>Built for Large-Scale Branding, Events &amp; Signage Projects</h2>
      <p>From exhibition stands and event branding to hoardings, vehicle graphics and premium signage, Efficient Advertising delivers end-to-end production, installation and branding solutions across Dubai and the UAE.</p>
    </div>
    <div class="ea-hp-why-grid">
      <div class="ea-hp-why-card">
        <div class="ea-hp-why-icon"><i class="fa fa-industry"></i></div>
        <h3>100% In-House</h3>
        <p>Design, print and finishing all under one roof — no outsourcing, no delays, total quality control.</p>
      </div>
      <div class="ea-hp-why-card">
        <div class="ea-hp-why-icon"><i class="fa fa-bolt"></i></div>
        <h3>Same-Day Production</h3>
        <p>Urgent deadline? We offer same-day printing on banners, cards and select products before 10am cutoff.</p>
      </div>
      <div class="ea-hp-why-card">
        <div class="ea-hp-why-icon"><i class="fa fa-star"></i></div>
        <h3>Premium Quality</h3>
        <p>HP Latex and UV flatbed technology — vivid colours, durable finishes, indoor and outdoor rated.</p>
      </div>
      <div class="ea-hp-why-card">
        <div class="ea-hp-why-icon"><i class="fa fa-truck"></i></div>
        <h3>UAE-Wide Delivery</h3>
        <p>From Ras Al Khor to all seven Emirates — delivery and on-site installation services available.</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
  SECTION 9 — CTA BAND
     ═══════════════════════════════════════════ -->
<section id="ea-hp-cta">
  <div class="ea-hp-container">
    <div class="ea-hp-cta-inner">
      <h2>Ready to Start Your Project?</h2>
      <p>Get a free quote in minutes. Our team responds within the hour.</p>
      <div class="ea-hp-hero-ctas">
        <a href="<?php echo esc_url( $quote_url ); ?>" class="ea-hp-btn ea-hp-btn--primary">Get a Free Quote</a>
        <a href="<?php echo esc_url( $wa_url ); ?>" class="ea-hp-btn ea-hp-btn--whatsapp" target="_blank" rel="noopener noreferrer">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          WhatsApp Us
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
  SECTION 10 — FAQ
     ═══════════════════════════════════════════ -->
<section id="ea-hp-faq">
  <div class="ea-hp-container">
    <div class="ea-hp-section-header">
      <span class="ea-hp-label">FAQ</span>
      <h2>Common Questions About Printing, Signage &amp; Exhibition Services in Dubai</h2>
    </div>
    <div class="ea-hp-faq-list">
      <?php foreach ( $faqs as $i => $faq ) : ?>
      <details class="ea-hp-faq-item">
        <summary>
          <span><?php echo esc_html( $faq['q'] ); ?></span>
          <span class="ea-hp-faq-icon">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
          </span>
        </summary>
        <div class="ea-hp-faq-answer">
          <p><?php echo esc_html( $faq['a'] ); ?></p>
        </div>
      </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FAQ JSON-LD (EA-SEO-POSITIONING-023) -->
<script type="application/ld+json">
<?php
$faq_schema = array(
  '@context'   => 'https://schema.org',
  '@type'      => 'FAQPage',
  'mainEntity' => array(),
);
foreach ( $faqs as $faq ) {
  $faq_schema['mainEntity'][] = array(
    '@type'          => 'Question',
    'name'           => wp_strip_all_tags( (string) $faq['q'] ),
    'acceptedAnswer' => array(
      '@type' => 'Answer',
      'text'  => wp_strip_all_tags( (string) $faq['a'] ),
    ),
  );
}
echo wp_json_encode( $faq_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
?>
</script>

<!-- ═══════════════════════════════════════════
     SECTION 11 — SEO CONTENT BLOCK
     ═══════════════════════════════════════════ -->
<section id="ea-hp-seo-block" style="background: #1D4472; padding: 80px 0; border-top: 1px solid rgba(255,255,255,0.06);">
  <div class="ea-hp-container">
    <div class="ea-hp-section-header" style="text-align: center; margin-bottom: 40px;">
      <span class="ea-hp-label">Excellence Since 2008</span>
      <h2>Exhibition, Signage &amp; Branding Company in Dubai</h2>
    </div>
    <div class="ea-hp-seo-inner" style="text-align: center; max-width: 900px; margin: 0 auto;">
      <p style="color: #B8C2CC; font-size: 15px; line-height: 1.8;">Efficient Advertising is a Dubai-based exhibition, signage and branding company specializing in exhibition stands, event branding, hoardings, vehicle graphics, large-format printing and custom signage solutions. With in-house production, experienced installation teams and UAE-wide project execution capabilities, we deliver premium branding solutions for retail, corporate, exhibition and outdoor advertising projects.</p>
      <p style="color: #B8C2CC; font-size: 15px; line-height: 1.8; margin-top: 15px;">Explore our key services: <a href="<?php echo esc_url( home_url( '/product-category/exhibitions-events/' ) ); ?>" style="color: #FFC107; text-decoration: underline;">Exhibition Stand Solutions</a>, <a href="<?php echo esc_url( home_url( '/product-category/exhibitions-events/' ) ); ?>" style="color: #FFC107; text-decoration: underline;">Event Branding Services</a>, <a href="<?php echo esc_url( home_url( '/product-category/signage/' ) ); ?>" style="color: #FFC107; text-decoration: underline;">Signage &amp; 3D Letters</a>, <a href="<?php echo esc_url( home_url( '/product-category/vehicle-branding/' ) ); ?>" style="color: #FFC107; text-decoration: underline;">Vehicle Branding Services</a>, and <a href="<?php echo esc_url( home_url( '/product-category/banners-large-format/' ) ); ?>" style="color: #FFC107; text-decoration: underline;">Hoarding Printing Solutions</a>.</p>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     SECTION 12 — BLOG PREVIEW
     ═══════════════════════════════════════════ -->
<section id="ea-hp-blog-preview">
  <div class="ea-hp-container">
    <div class="ea-hp-section-header">
      <h2>Printing &amp; Signage Insights</h2>
      <p>Guides, tips, and insights for businesses planning signage, printing, branding, and events in Dubai.</p>
    </div>

    <div class="ea-hp-blog-grid">
      <?php foreach ( $blog_preview_posts as $bp ) :
        $post_id = isset( $bp->ID ) ? intval( $bp->ID ) : 0;
        $thumb   = $post_id ? get_the_post_thumbnail_url( $post_id, 'medium_large' ) : '';
        $cats    = $post_id ? get_the_category( $post_id ) : [];
        $cat     = ( ! empty( $cats ) ) ? $cats[0]->name : 'Insights';
        $title   = ! empty( $bp->post_title ) ? $bp->post_title : 'Printing & Signage Insights';
        $excerpt = $post_id ? get_the_excerpt( $post_id ) : ( ! empty( $bp->post_excerpt ) ? $bp->post_excerpt : '' );
        $url     = $post_id ? get_permalink( $post_id ) : home_url( '/blog/' );
      ?>
      <article class="ea-hp-blog-card">
        <a class="ea-hp-blog-thumb" href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( $title ); ?>">
          <?php if ( $thumb ) : ?>
            <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy" width="560" height="320">
          <?php else : ?>
            <span class="ea-hp-blog-placeholder">Efficient Advertising Blog</span>
          <?php endif; ?>
        </a>
        <div class="ea-hp-blog-body">
          <span class="ea-hp-blog-cat"><?php echo esc_html( $cat ); ?></span>
          <h3><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $title ); ?></a></h3>
          <p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $excerpt ), 22, '…' ) ); ?></p>
          <a class="ea-hp-blog-readmore" href="<?php echo esc_url( $url ); ?>">Read More <span aria-hidden="true">→</span></a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>

    <div class="ea-hp-blog-more">
      <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="ea-hp-btn ea-hp-btn--outline">View All Articles</a>
    </div>
  </div>
</section>

<script>
(function() {
  var faqItems = Array.prototype.slice.call(document.querySelectorAll('#ea-hp-faq .ea-hp-faq-item'));
  if (!faqItems.length) return;

  function isDesktop() {
    return window.matchMedia('(min-width: 768px)').matches;
  }

  faqItems.forEach(function(item) {
    var summary = item.querySelector('summary');
    if (!summary) return;

    item.removeAttribute('open');

    item.addEventListener('mouseenter', function() {
      if (!isDesktop()) return;
      item.setAttribute('open', 'open');
    });

    item.addEventListener('mouseleave', function() {
      if (!isDesktop()) return;
      item.removeAttribute('open');
    });

    summary.addEventListener('click', function(event) {
      if (!isDesktop()) return;
      event.preventDefault();
    });
  });

  window.addEventListener('resize', function() {
    if (isDesktop()) {
      faqItems.forEach(function(item) { item.removeAttribute('open'); });
    }
  });
})();
</script>

<script id="ea-homepage-lazyload-bypass">
(function() {
  console.log("EA: Running bulletproof image lazyloader bypass.");
  
  function forceLoadLazy() {
    var lazyImgs = Array.prototype.slice.call(document.querySelectorAll('img.lazyload, img[data-src]'));
    lazyImgs.forEach(function(img) {
      var realSrc = img.getAttribute('data-src');
      if (realSrc && img.getAttribute('src') !== realSrc) {
        img.setAttribute('src', realSrc);
        img.classList.remove('lazyload');
        img.classList.add('lazyloaded');
        img.style.opacity = '1';
      }
    });

    // Also trigger background image load
    var bgCols = Array.prototype.slice.call(document.querySelectorAll('[data-collage-bg]'));
    bgCols.forEach(function(col) {
      var bgUrl = col.getAttribute('data-collage-bg');
      if (bgUrl && col.style.backgroundImage !== "url('" + bgUrl + "')") {
        col.style.backgroundImage = "url('" + bgUrl + "')";
      }
    });
  }

  // Force load on load, DOMContentLoaded, and multiple subsequent intervals to bypass race conditions
  window.addEventListener('load', forceLoadLazy);
  document.addEventListener('DOMContentLoaded', forceLoadLazy);
  forceLoadLazy();
  setTimeout(forceLoadLazy, 200);
  setTimeout(forceLoadLazy, 600);
  setTimeout(forceLoadLazy, 1200);
  setTimeout(forceLoadLazy, 2500);
})();
</script>

<?php get_footer(); ?>
