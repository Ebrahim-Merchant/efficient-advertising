<?php
/**
 * Product Category Archive — WooCommerce product_cat taxonomy
 * Dark-luxury design matching the premium homepage.
 *
 * @package NewEfficientAdvtWorkingTheme_v1.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$term      = get_queried_object();
$term_slug = $term->slug ?? '';
$term_name = $term->name ?? 'Products';
$term_desc = $term->description ?? '';
$term_url  = get_term_link( $term );
$wa_num    = '971527966265';
$wa_url    = 'https://wa.me/' . $wa_num . '?text=' . rawurlencode( 'Hi, I need a quote for: ' . $term_name . ' in Dubai' );
$quote_url = home_url( '/contact-us/' );

/* Parent category name (for breadcrumb) */
$parent_name = '';
$parent_url  = '';
if ( $term->parent ) {
  $parent_term = get_term( $term->parent, 'product_cat' );
  if ( ! is_wp_error( $parent_term ) ) {
    $parent_name = $parent_term->name;
    $parent_url  = get_term_link( $parent_term );
  }
}

/* Default subheading & intro */
$sub   = ! empty( $term_desc ) ? $term_desc : 'Professional ' . strtolower( $term_name ) . ' printing and branding — produced in-house at our Dubai facility with same-day delivery across the UAE.';
$intro = 'Efficient Advertising is one of Dubai\'s leading providers of ' . strtolower( $term_name ) . ' solutions. In-house production, fast turnaround, and free design support on every order. Browse our range below and request a quote.';

/* Subcategories */
$subcats = get_terms( [
  'taxonomy'   => 'product_cat',
  'parent'     => $term->term_id,
  'hide_empty' => true,
  'orderby'    => 'name',
] );
$has_subs = ( ! is_wp_error( $subcats ) && ! empty( $subcats ) );

/* Collect product IDs for ItemList schema */
$schema_items = [];
if ( have_posts() ) {
  $tmp = clone $wp_query;
  $pos = 0;
  while ( $tmp->have_posts() ) {
    $tmp->the_post();
    $pos++;
    $schema_items[] = [
      'pos'  => $pos,
      'name' => get_the_title(),
      'url'  => get_permalink(),
    ];
  }
  wp_reset_postdata();
}
?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/premium-homepage.css?v=1.0">
<style>
/* ── Category Archive Overrides ── */
.ea-cat-hero {
  background: #14365C;
  position: relative;
  overflow: hidden;
  padding: clamp(112px, 14vw, 164px) 0 clamp(64px, 7vw, 92px);
}
.ea-cat-hero::before {
  content: '';
  position: absolute; inset: 0;
  background: radial-gradient(ellipse at 30% 40%, rgba(212,167,58,0.10) 0%, transparent 55%);
  pointer-events: none;
}
.ea-cat-hero-inner {
  position: relative; z-index: 1;
  max-width: var(--hp-max, 1200px); margin: 0 auto;
  padding: 0 var(--hp-px, 24px);
  text-align: center;
}
.ea-cat-breadcrumb {
  display: flex; justify-content: center; align-items: center; gap: 8px;
  flex-wrap: wrap; margin-bottom: 18px;
}
.ea-cat-breadcrumb a {
  font-family: var(--hp-f-body, sans-serif); font-size: 13px; color: #8FA3B7; text-decoration: none;
}
.ea-cat-breadcrumb a:hover { color: var(--hp-amber, #FFBA09); }
.ea-cat-breadcrumb .sep { color: #8FA3B7; font-size: 12px; }
.ea-cat-breadcrumb .current { font-size: 13px; color: #F5F7FA; font-weight: 600; }
.ea-cat-hero h1 {
  font-family: var(--hp-f-head, 'Syne', sans-serif) !important;
  font-size: clamp(1.8rem, 4vw, 2.8rem) !important;
  font-weight: 800 !important;
  color: #F5F7FA !important;
  line-height: 1.15 !important;
  letter-spacing: -0.02em;
  margin: 0 0 14px !important;
}
.ea-cat-hero p {
  font-family: var(--hp-f-body, sans-serif) !important;
  font-size: 1.05rem !important;
  color: #B8C2CC !important;
  max-width: 600px; margin: 0 auto 28px !important;
  line-height: 1.65 !important;
}
.ea-cat-hero-ctas {
  display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;
}

/* Subcategories strip */
.ea-cat-subs {
  background: #1B435E;
  border-top: 1px solid rgba(143,163,183,0.22);
  border-bottom: 1px solid rgba(143,163,183,0.22);
  padding: 32px 0;
}
.ea-cat-subs-inner {
  max-width: var(--hp-max, 1200px); margin: 0 auto;
  padding: 0 var(--hp-px, 24px);
  display: flex; flex-wrap: wrap; gap: 10px; justify-content: center;
}
.ea-cat-sub-pill {
  display: inline-block;
  font-family: var(--hp-f-body, sans-serif);
  font-size: 13px; font-weight: 600;
  color: #B8C2CC;
  background: #102B49;
  border: 1px solid rgba(143,163,183,0.24);
  border-radius: 24px;
  padding: 8px 20px;
  text-decoration: none;
  transition: all 0.25s ease;
}
.ea-cat-sub-pill:hover {
  color: #0B1F38;
  background: #D4A73A;
  border-color: #D4A73A;
}

/* Product count bar */
.ea-cat-toolbar {
  max-width: var(--hp-max, 1200px); margin: 0 auto;
  padding: 32px var(--hp-px, 24px) 0;
  display: flex; align-items: center; justify-content: space-between;
}
.ea-cat-count {
  font-family: var(--hp-f-body, sans-serif);
  font-size: 14px; font-weight: 600; color: #8FA3B7;
}

/* Products grid */
.ea-cat-grid-section {
  background: #0B1F38;
  padding: 40px 0 var(--hp-section, 100px);
}
.ea-cat-products-grid {
  max-width: var(--hp-max, 1200px); margin: 0 auto;
  padding: 0 var(--hp-px, 24px);
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 24px;
}
.ea-cat-card {
  background: #102B49;
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: var(--hp-r-lg, 20px);
  overflow: hidden;
  text-decoration: none !important;
  transition: all 0.3s ease;
  display: flex; flex-direction: column;
}
.ea-cat-card:hover {
  border-color: rgba(255,186,9,0.25);
  transform: translateY(-4px);
  box-shadow: 0 16px 48px rgba(0,0,0,0.35);
}
.ea-cat-card__img {
  height: 220px; overflow: hidden; background: #1B435E;
}
.ea-cat-card__img img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform 0.4s ease;
}
.ea-cat-card:hover .ea-cat-card__img img { transform: scale(1.05); }
.ea-cat-card__body {
  padding: 20px; flex: 1; display: flex; flex-direction: column;
}
.ea-cat-card__body h3 {
  font-family: var(--hp-f-head, 'Syne', sans-serif) !important;
  font-size: 1rem !important; font-weight: 700 !important;
  color: #F5F7FA !important; margin: 0 0 6px !important; line-height: 1.3 !important;
}
.ea-cat-card__body p {
  font-family: var(--hp-f-body, sans-serif) !important;
  font-size: 0.85rem !important; color: #B8C2CC !important;
  line-height: 1.55 !important; margin: 0 0 12px !important; flex: 1;
}
.ea-cat-card__cta {
  font-family: var(--hp-f-body, sans-serif);
  font-size: 13px; font-weight: 700;
  color: #D4A73A;
  display: inline-flex; align-items: center; gap: 5px; margin-top: auto;
}

/* Pagination */
.ea-cat-pagination {
  max-width: var(--hp-max, 1200px); margin: 0 auto;
  padding: 48px var(--hp-px, 24px) 0;
  display: flex; justify-content: center; gap: 8px;
}
.ea-cat-pagination .page-numbers {
  display: inline-flex; align-items: center; justify-content: center;
  min-width: 42px; height: 42px; padding: 0 14px;
  background: #102B49;
  color: #B8C2CC;
  border: 1px solid rgba(143,163,183,0.24);
  border-radius: var(--hp-r, 12px);
  font-family: var(--hp-f-body, sans-serif);
  font-weight: 600; font-size: 14px;
  text-decoration: none;
  transition: all 0.25s ease;
}
.ea-cat-pagination .page-numbers:hover,
.ea-cat-pagination .page-numbers.current {
  background: #D4A73A;
  color: #0B1F38;
  border-color: #D4A73A;
}

/* Why section on category pages */
.ea-cat-why {
  background: #1B435E;
  padding: var(--hp-section, 100px) 0;
}

/* CTA on category pages */
.ea-cat-cta {
  background: #0B1F38;
  padding: var(--hp-section, 100px) 0;
  text-align: center;
}
.ea-cat-cta h2 {
  font-family: var(--hp-f-head, 'Syne', sans-serif) !important;
  font-size: clamp(1.6rem, 3.5vw, 2.4rem) !important;
  font-weight: 700 !important; color: #F5F7FA !important;
  margin: 0 0 12px !important;
}
.ea-cat-cta > .ea-hp-container > p {
  font-family: var(--hp-f-body, sans-serif) !important;
  font-size: 1.05rem !important; color: #B8C2CC !important;
  margin: 0 0 28px !important;
}
.ea-cat-cta .ea-hp-hero-ctas { justify-content: center; }

/* No products */
.ea-cat-empty {
  text-align: center; padding: 80px 24px;
}
.ea-cat-empty i { font-size: 48px; color: rgba(143,163,183,0.28); margin-bottom: 20px; }
.ea-cat-empty h2 {
  font-family: var(--hp-f-head, 'Syne', sans-serif) !important;
  font-size: 1.4rem !important; color: #F5F7FA !important;
  margin: 0 0 10px !important;
}
.ea-cat-empty p {
  color: #8FA3B7 !important; margin: 0 0 24px !important;
}

/* EA-TEXT-002 — Category Section-Level Text System */
.ea-cat-hero,
.ea-cat-subs,
.ea-cat-grid-section,
.ea-cat-why,
.ea-cat-cta,
#ea-cat-why,
#ea-cat-cta,
#ea-cat-grid-section {
  color: #B8C2CC;
}

.ea-cat-hero h1,
.ea-cat-hero h2,
.ea-cat-hero h3,
.ea-cat-subs h1,
.ea-cat-subs h2,
.ea-cat-subs h3,
.ea-cat-grid-section h1,
.ea-cat-grid-section h2,
.ea-cat-grid-section h3,
.ea-cat-why h1,
.ea-cat-why h2,
.ea-cat-why h3,
.ea-cat-cta h1,
.ea-cat-cta h2,
.ea-cat-cta h3,
#ea-cat-why h1,
#ea-cat-why h2,
#ea-cat-why h3,
#ea-cat-cta h1,
#ea-cat-cta h2,
#ea-cat-cta h3 {
  color: #F5F7FA !important;
}

.ea-cat-hero small,
.ea-cat-subs small,
.ea-cat-grid-section small,
.ea-cat-why small,
.ea-cat-cta small,
.ea-cat-hero .meta,
.ea-cat-subs .meta,
.ea-cat-grid-section .meta,
.ea-cat-why .meta,
.ea-cat-cta .meta,
.ea-cat-hero .muted,
.ea-cat-subs .muted,
.ea-cat-grid-section .muted,
.ea-cat-why .muted,
.ea-cat-cta .muted,
#ea-cat-why small,
#ea-cat-why .meta,
#ea-cat-why .muted,
#ea-cat-cta small,
#ea-cat-cta .meta,
#ea-cat-cta .muted {
  color: #8FA3B7 !important;
}

.ea-cat-hero .ea-hp-label,
.ea-cat-subs .ea-hp-label,
.ea-cat-grid-section .ea-hp-label,
.ea-cat-why .ea-hp-label,
.ea-cat-cta .ea-hp-label,
.ea-cat-card__cta,
.ea-cat-tile-count {
  color: #D4A73A;
}

@media (max-width: 767px) {
  .ea-cat-hero { padding-top: 132px; padding-bottom: 56px; }
  .ea-cat-products-grid { grid-template-columns: 1fr; }
  .ea-cat-hero-ctas { flex-direction: column; align-items: center; }
  .ea-hp-btn { width: 100%; }
}

/* ================================================
   EA-CAT-SPACING-v1 — Premium Section Rhythm
   ================================================ */
.ea-cat-hero + .ea-cat-subs { margin-top: 60px; }
.ea-cat-subs + .ea-cat-grid-section { margin-top: 60px; }
#ea-cat-grid-section + #ea-cat-why { margin-top: 100px; }
#ea-cat-why + #ea-cat-cta { margin-top: 100px; }
</style>

<!-- JSON-LD: CollectionPage + BreadcrumbList -->
<script type="application/ld+json">
[
  {
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "<?php echo esc_js( $term_name ); ?> — Efficient Advertising Dubai",
    "url": "<?php echo esc_url( $term_url ); ?>",
    "description": "<?php echo esc_js( wp_strip_all_tags( $sub ) ); ?>"
    <?php if ( ! empty( $schema_items ) ) : ?>
    ,"mainEntity": {
      "@type": "ItemList",
      "itemListElement": [
        <?php foreach ( $schema_items as $si => $sit ) : ?>
        {"@type":"ListItem","position":<?php echo $sit['pos']; ?>,"name":"<?php echo esc_js( $sit['name'] ); ?>","url":"<?php echo esc_url( $sit['url'] ); ?>"}<?php echo $si < count( $schema_items ) - 1 ? ',' : ''; ?>
        <?php endforeach; ?>
      ]
    }
    <?php endif; ?>
  },
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
      {"@type":"ListItem","position":1,"name":"Home","item":"<?php echo esc_url( home_url('/') ); ?>"},
      <?php if ( $parent_name ) : ?>
      {"@type":"ListItem","position":2,"name":"<?php echo esc_js( $parent_name ); ?>","item":"<?php echo esc_url( $parent_url ); ?>"},
      {"@type":"ListItem","position":3,"name":"<?php echo esc_js( $term_name ); ?>"}
      <?php else : ?>
      {"@type":"ListItem","position":2,"name":"<?php echo esc_js( $term_name ); ?>"}
      <?php endif; ?>
    ]
  }
]
</script>

<!-- HERO -->
<section class="ea-cat-hero">
  <div class="ea-cat-hero-inner">
    <nav class="ea-cat-breadcrumb" aria-label="Breadcrumb">
      <a href="<?php echo esc_url( home_url('/') ); ?>">Home</a>
      <span class="sep">/</span>
      <?php if ( $parent_name ) : ?>
        <a href="<?php echo esc_url( $parent_url ); ?>"><?php echo esc_html( $parent_name ); ?></a>
        <span class="sep">/</span>
      <?php endif; ?>
      <span class="current"><?php echo esc_html( $term_name ); ?></span>
    </nav>
    <h1><?php echo esc_html( $term_name ); ?></h1>
    <p><?php echo esc_html( $sub ); ?></p>
    <div class="ea-cat-hero-ctas">
      <a href="<?php echo esc_url( $wa_url ); ?>" class="ea-hp-btn ea-hp-btn--whatsapp" target="_blank" rel="noopener noreferrer">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        WhatsApp for Quote
      </a>
      <a href="<?php echo esc_url( $quote_url ); ?>" class="ea-hp-btn ea-hp-btn--outline">Request a Quote</a>
    </div>
  </div>
</section>

<!-- SUBCATEGORIES (if parent category) -->
<?php if ( $has_subs ) : ?>
<section class="ea-cat-subs">
  <div class="ea-cat-subs-inner">
    <?php foreach ( $subcats as $sc ) : ?>
      <a href="<?php echo esc_url( get_term_link( $sc ) ); ?>" class="ea-cat-sub-pill"><?php echo esc_html( $sc->name ); ?></a>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<!-- PRODUCTS GRID -->
<section class="ea-cat-grid-section">
  <?php if ( have_posts() ) : ?>
    <div class="ea-cat-toolbar">
      <span class="ea-cat-count">
        <?php printf( '%d product%s', $wp_query->found_posts, $wp_query->found_posts === 1 ? '' : 's' ); ?>
      </span>
    </div>
    <div class="ea-cat-products-grid" style="margin-top: 32px;">
      <?php while ( have_posts() ) : the_post();
        $product    = function_exists( 'wc_get_product' ) ? wc_get_product( get_the_ID() ) : null;
        $thumb      = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
        $fallback_img = content_url( 'uploads/2025/10/3M-Glass-Sticker-Display-Image.webp' );
        $thumb      = $thumb ? $thumb : $fallback_img;
        $card_text  = '';
        $card_alt   = sprintf( '%s in %s by Efficient Advertising Dubai', get_the_title(), $term_name );

        if ( has_excerpt() ) {
          $card_text = get_the_excerpt();
        } elseif ( $product && method_exists( $product, 'get_short_description' ) ) {
          $card_text = wp_strip_all_tags( $product->get_short_description() );
        }

        if ( empty( $card_text ) ) {
          $card_text = 'Premium quality production with fast turnaround and professional installation support across Dubai and UAE.';
        }
      ?>
      <a href="<?php the_permalink(); ?>" class="ea-cat-card">
        <div class="ea-cat-card__img">
          <?php if ( $thumb ) : ?>
            <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $card_alt ); ?>" loading="lazy" width="400" height="300">
          <?php endif; ?>
        </div>
        <div class="ea-cat-card__body">
          <h3><?php the_title(); ?></h3>
          <p><?php echo esc_html( wp_trim_words( $card_text, 15, '...' ) ); ?></p>
          <span class="ea-cat-card__cta">View Product <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="13" height="13"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </div>
      </a>
      <?php endwhile; ?>
    </div>

    <!-- Pagination -->
    <div class="ea-cat-pagination">
      <?php
      echo paginate_links( [
        'prev_text' => '&laquo;',
        'next_text' => '&raquo;',
        'type'      => 'plain',
      ] );
      ?>
    </div>

  <?php else : ?>
    <div class="ea-hp-container">
      <div class="ea-cat-empty">
        <i class="fa fa-cube"></i>
        <h2>No products found</h2>
        <p>We haven't added products to this category yet. Contact us directly for a quote.</p>
        <a href="<?php echo esc_url( $wa_url ); ?>" class="ea-hp-btn ea-hp-btn--whatsapp" target="_blank" rel="noopener noreferrer">WhatsApp Us</a>
      </div>
    </div>
  <?php endif; ?>
</section>

<!-- WHY CHOOSE US -->
<section class="ea-cat-why">
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
        <p>Urgent? We offer same-day printing on banners, cards and select products before 10am cutoff.</p>
      </div>
      <div class="ea-hp-why-card">
        <div class="ea-hp-why-icon"><i class="fa fa-shield"></i></div>
        <h3>Premium Quality</h3>
        <p>HP Latex and UV flatbed tech — vivid colours, durable finishes, indoor and outdoor rated.</p>
      </div>
      <div class="ea-hp-why-card">
        <div class="ea-hp-why-icon"><i class="fa fa-truck"></i></div>
        <h3>UAE-Wide Delivery</h3>
        <p>From Ras Al Khor to all seven Emirates — delivery and on-site installation available.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="ea-cat-cta">
  <div class="ea-hp-container">
    <h2>Need <?php echo esc_html( $term_name ); ?>?</h2>
    <p>Get a free quote in minutes. Our team responds within the hour.</p>
    <div class="ea-hp-hero-ctas" style="justify-content:center;">
      <a href="<?php echo esc_url( $quote_url ); ?>" class="ea-hp-btn ea-hp-btn--primary">Get a Free Quote</a>
      <a href="<?php echo esc_url( $wa_url ); ?>" class="ea-hp-btn ea-hp-btn--whatsapp" target="_blank" rel="noopener noreferrer">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        WhatsApp Us
      </a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
