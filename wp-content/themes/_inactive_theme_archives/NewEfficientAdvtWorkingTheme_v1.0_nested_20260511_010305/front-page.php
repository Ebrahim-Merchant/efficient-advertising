<?php
/**
 * ██  DEPRECATED — DO NOT USE  ██
 *
 * Premium Homepage — Efficient Advertising LLC
 *
 * This file is FULLY BYPASSED by the template_include filter in
 * functions.php (line ~68) which forces index.php for is_front_page()/is_home().
 *
 * Retained for historical reference only.
 * Safe to delete once all stakeholders confirm index.php is the canonical homepage.
 *
 * @deprecated 2026-04-12  Superseded by index.php (Template Name: Home)
 * @package NewEfficientAdvtWorkingTheme_v1.0
 */

// SAFETY GUARD: If this file is ever loaded accidentally, redirect to index.php.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( defined( 'EA_HOMEPAGE_LOADED' ) ) return; // prevent double-render
$canonical_home = get_stylesheet_directory() . '/index.php';
if ( file_exists( $canonical_home ) ) {
    include $canonical_home;
    return;
}

/* ── ORIGINAL CODE BELOW (inactive — guarded above) ── */

get_header();

/* ── DATA ── */
$wa_url   = 'https://wa.me/971527966265?text=' . rawurlencode( 'Hi, I would like to get a quote for printing/branding services.' );
$quote_url = home_url( '/contact-us/' );
$phone     = '+971 52 796 6265';

/* ── 8 Curated products: one per parent category, with featured image ── */
$ea_parent_cats = get_terms( [
  'taxonomy'   => 'product_cat',
  'parent'     => 0,
  'hide_empty' => true,
  'orderby'    => 'count',
  'order'      => 'DESC',
  'number'     => 8,
  'meta_query' => [],
] );
// Filter to only new categories (term_id >= 1257)
if ( ! is_wp_error( $ea_parent_cats ) ) {
  $ea_parent_cats = array_filter( $ea_parent_cats, function( $t ) { return $t->term_id >= 1257; } );
}

$curated = [];
if ( ! is_wp_error( $ea_parent_cats ) ) {
  foreach ( $ea_parent_cats as $pcat ) {
    $prods = get_posts( [
      'post_type'      => 'product',
      'post_status'    => 'publish',
      'posts_per_page' => 1,
      'meta_query'     => [ [ 'key' => '_thumbnail_id', 'compare' => 'EXISTS' ] ],
      'tax_query'      => [ [ 'taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $pcat->term_id ] ],
    ] );
    if ( $prods ) {
      $p = $prods[0];
      $img = get_the_post_thumbnail_url( $p->ID, 'medium_large' );
      if ( ! $img ) continue;
      $excerpt = $p->post_excerpt;
      if ( empty( $excerpt ) ) $excerpt = wp_trim_words( $p->post_content, 12, '…' );
      $curated[] = [
        'id'       => $p->ID,
        'title'    => $p->post_title,
        'url'      => get_permalink( $p->ID ),
        'img'      => $img,
        'cat_name' => $pcat->name,
        'cat_url'  => get_term_link( $pcat ),
        'excerpt'  => $excerpt,
      ];
    }
  }
}

/* ── Core services (static — curated selection) ── */
$services = [
  [
    'icon'  => 'fa-print',
    'title' => 'Banner & Large Format Printing',
    'desc'  => 'Vinyl banners, roll-ups, hoardings, fabric displays — printed in-house, same-day available.',
    'url'   => home_url( '/product-category/banners-large-format/' ),
  ],
  [
    'icon'  => 'fa-building',
    'title' => 'Signage & 3D Letters',
    'desc'  => 'Acrylic, aluminium, LED and illuminated signage — fabricated and installed across the UAE.',
    'url'   => home_url( '/product-category/signage/' ),
  ],
  [
    'icon'  => 'fa-car',
    'title' => 'Vehicle Branding',
    'desc'  => 'Full wraps, partial wraps, fleet branding and magnetic signage for cars, vans and trucks.',
    'url'   => home_url( '/product-category/vehicle-branding/' ),
  ],
  [
    'icon'  => 'fa-calendar',
    'title' => 'Exhibition & Events',
    'desc'  => 'Custom stands, pop-ups, backdrops, event branding — turnkey solutions for trade shows.',
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
    'title' => 'Corporate Gifts & Promotions',
    'desc'  => 'Branded apparel, packaging, drinkware, executive kits — customised for your brand.',
    'url'   => home_url( '/product-category/promotional-gifts/' ),
  ],
];

/* ── Portfolio images (verified existing) ── */
$portfolio = [
  [ 'src' => '/wp-content/uploads/2022/03/Step-Repeat-Backdrop-2.jpg',      'alt' => 'Step & Repeat Backdrop — Corporate Event Dubai' ],
  [ 'src' => '/wp-content/uploads/2022/03/3D-Aluminum-Signage-2.jpg',       'alt' => '3D Aluminium Signage — Storefront Dubai' ],
  [ 'src' => '/wp-content/uploads/2022/03/Exhibition-Stands-1.jpg',         'alt' => 'Custom Exhibition Stand — Trade Show Dubai' ],
  [ 'src' => '/wp-content/uploads/2022/03/Vehicle-branding.png',            'alt' => 'Full Vehicle Wrap — Fleet Branding Dubai' ],
  [ 'src' => '/wp-content/uploads/2022/03/Events-Branding-2-1.jpg',        'alt' => 'Event Branding — Corporate Launch Dubai' ],
  [ 'src' => '/wp-content/uploads/2026/03/business-signage-storefront.jpg', 'alt' => 'Business Signage — Retail Storefront Dubai' ],
];

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

/* ── FAQ ── */
$faqs = [
  [ 'q' => 'What is the turnaround time for printing?',    'a' => 'Standard orders are completed in 2–3 business days. Same-day printing is available for banners, business cards and select items if artwork is submitted before 10am.' ],
  [ 'q' => 'Do you offer design services?',                'a' => 'Yes — our in-house design team can create artwork from scratch or optimise your existing files for print at no extra charge on qualifying orders.' ],
  [ 'q' => 'What areas do you deliver to?',                'a' => 'We deliver across the UAE including Dubai, Abu Dhabi, Sharjah, Ajman, and the Northern Emirates. Installation services are available for signage and vehicle branding.' ],
  [ 'q' => 'Can I visit your facility?',                   'a' => 'Absolutely. Our production facility and showroom in Ras Al Khor Industrial Area 1 is open Saturday–Thursday, 8am–8pm. Walk-ins welcome.' ],
  [ 'q' => 'What file formats do you accept?',             'a' => 'We accept PDF, AI, EPS, PSD, and high-resolution JPG/PNG. Our team will check your artwork and confirm before production begins.' ],
];
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/premium-homepage.css?v=1.0">

<!-- ═══════════════════════════════════════════
     SECTION 1 — PREMIUM HERO
     ═══════════════════════════════════════════ -->
<section id="ea-hp-hero">
  <div class="ea-hp-hero-inner">
    <div class="ea-hp-hero-content">
      <span class="ea-hp-hero-label">Dubai's Premier Printing & Branding Company</span>
      <h1>We Bring Your Brand<br>to Life</h1>
      <p>From large-format banners to 3D signage and vehicle wraps — we produce everything in-house at our Dubai facility. 18+ years of trusted service, same-day production available.</p>
      <div class="ea-hp-hero-ctas">
        <a href="<?php echo esc_url( $quote_url ); ?>" class="ea-hp-btn ea-hp-btn--primary">Get a Quote</a>
        <a href="<?php echo esc_url( $wa_url ); ?>" class="ea-hp-btn ea-hp-btn--whatsapp" target="_blank" rel="noopener noreferrer">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          WhatsApp Us
        </a>
      </div>
      <div class="ea-hp-hero-trust">
        <span><i class="fa fa-check-circle"></i> 18+ Years in Dubai</span>
        <span><i class="fa fa-check-circle"></i> In-House Production</span>
        <span><i class="fa fa-check-circle"></i> Same-Day Available</span>
      </div>
    </div>
    <div class="ea-hp-hero-img">
      <img src="/wp-content/uploads/2022/03/Exhibition-Stands-1.jpg"
           alt="Exhibition Setup and Branding Installation — Efficient Advertising Dubai"
           width="720" height="540" loading="eager" fetchpriority="high">
    </div>
  </div>
</section>

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
      <p>End-to-end printing, signage and branding — everything produced in-house at our Dubai facility.</p>
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
      <h2>Curated Product Range</h2>
      <p>Browse our most popular categories — from banners and signage to corporate gifts.</p>
    </div>
    <div class="ea-hp-products-grid">
      <?php foreach ( $curated as $item ) : ?>
      <a href="<?php echo esc_url( $item['url'] ); ?>" class="ea-product-card">
        <div class="ea-product-card__img">
          <img src="<?php echo esc_url( $item['img'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?> — Efficient Advertising Dubai" loading="lazy" width="400" height="300">
        </div>
        <div class="ea-product-card__body">
          <span class="ea-product-card__cat"><?php echo esc_html( $item['cat_name'] ); ?></span>
          <h4><?php echo esc_html( $item['title'] ); ?></h4>
          <p><?php echo esc_html( wp_trim_words( $item['excerpt'], 10, '…' ) ); ?></p>
          <span class="ea-product-card__cta">View Product <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="13" height="13"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <div class="ea-hp-products-more">
      <a href="<?php echo home_url( '/shop/' ); ?>" class="ea-hp-btn ea-hp-btn--outline">View All Products</a>
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
        <img src="<?php echo esc_url( $pf['src'] ); ?>" alt="<?php echo esc_attr( $pf['alt'] ); ?>" loading="lazy" width="600" height="400">
        <div class="ea-hp-portfolio-overlay">
          <span><?php echo esc_html( $pf['alt'] ); ?></span>
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
      <article class="ea-hp-video-card">
        <div class="ea-hp-video-frame">
          <iframe
            src="https://www.youtube-nocookie.com/embed/<?php echo esc_attr( $video['id'] ); ?>?rel=0&modestbranding=1"
            title="<?php echo esc_attr( $video['title'] ); ?>"
            loading="lazy"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin"
            allowfullscreen>
          </iframe>
        </div>
        <h3><?php echo esc_html( $video['title'] ); ?></h3>
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
      <span class="ea-hp-label">Why Efficient</span>
      <h2>Why Choose Us</h2>
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
        <div class="ea-hp-why-icon"><i class="fa fa-shield"></i></div>
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
      <h2>Common Questions</h2>
    </div>
    <div class="ea-hp-faq-list">
      <?php foreach ( $faqs as $i => $faq ) : ?>
      <details class="ea-hp-faq-item"<?php if ( $i === 0 ) echo ' open'; ?>>
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

<?php get_footer(); ?>
