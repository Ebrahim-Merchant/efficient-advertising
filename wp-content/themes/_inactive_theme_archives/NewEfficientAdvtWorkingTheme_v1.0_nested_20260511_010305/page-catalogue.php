<?php
/**
 * Template Name: Product Catalogue
 * Description: Premium catalogue grid showing all product categories
 */

get_header();

// Get all top-level product categories (exclude Uncategorized)
$categories = get_terms([
  'taxonomy'   => 'product_cat',
  'parent'     => 0,
  'hide_empty' => true,
  'exclude'    => [ get_option('default_product_cat') ],
  'orderby'    => 'name',
]);

// Category descriptions — centralized in ea-home-curation.php
$cat_descriptions = ea_get_catalogue_category_descriptions();
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/premium-homepage.css">
<style>
/* ── Catalogue Page Styles ── */
.ea-cat-page { background: #0B1F38; color: #F5F7FA; min-height: 100vh; }

.ea-cat-hero {
  padding: clamp(104px, 12vw, 148px) var(--hp-px) clamp(64px, 7vw, 88px);
  text-align: center;
  position: relative;
  overflow: hidden;
}
.ea-cat-hero::before {
  content: '';
  position: absolute; inset: 0;
  background: radial-gradient(ellipse 50% 60% at 50% 20%, rgba(212,167,58,0.10), transparent 70%);
  pointer-events: none;
}
.ea-cat-hero-eyebrow {
  font-family: var(--hp-f-body);
  font-size: 13px;
  font-weight: 600;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: #D4A73A;
  margin-bottom: 16px;
}
.ea-cat-hero h1 {
  font-family: var(--hp-f-head);
  font-size: clamp(32px, 5vw, 56px);
  font-weight: 800;
  line-height: 1.12;
  letter-spacing: -0.02em;
  color: #F5F7FA;
  margin: 0 0 20px;
}
.ea-cat-hero p {
  font-family: var(--hp-f-body);
  font-size: clamp(15px, 1.4vw, 18px);
  color: #B8C2CC;
  max-width: 620px;
  margin: 0 auto;
  line-height: 1.7;
}

/* ── Category Grid ── */
.ea-cat-grid-wrap {
  max-width: var(--hp-max);
  margin: 0 auto;
  padding: 24px var(--hp-px) var(--hp-section);
}
.ea-cat-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 28px;
}
.ea-cat-tile {
  position: relative;
  border-radius: var(--hp-r-lg);
  overflow: hidden;
  background: #102B49;
  border: 1px solid rgba(255,255,255,0.06);
  transition: transform 380ms ease, box-shadow 380ms ease;
  text-decoration: none;
  display: block;
}
.ea-cat-tile:hover {
  transform: translateY(-6px);
  box-shadow: 0 24px 48px rgba(0,0,0,0.35), 0 0 0 1px rgba(212,167,58,0.16);
}

.ea-cat-tile-img {
  width: 100%;
  aspect-ratio: 4/3;
  object-fit: cover;
  display: block;
  transition: transform 600ms ease;
}
.ea-cat-tile:hover .ea-cat-tile-img { transform: scale(1.06); }

.ea-cat-tile-body {
  padding: 20px 20px 24px;
}
.ea-cat-tile-name {
  font-family: var(--hp-f-head);
  font-size: 17px;
  font-weight: 700;
  color: #F5F7FA;
  margin: 0 0 6px;
  line-height: 1.25;
}
.ea-cat-tile-count {
  font-family: var(--hp-f-body);
  font-size: 12px;
  font-weight: 600;
  color: #D4A73A;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  margin-bottom: 8px;
}
.ea-cat-tile-desc {
  font-family: var(--hp-f-body);
  font-size: 13.5px;
  color: #B8C2CC;
  line-height: 1.55;
  margin: 0;
}
.ea-cat-tile-arrow {
  position: absolute;
  top: 16px;
  right: 16px;
  width: 32px; height: 32px;
  background: rgba(11,31,56,0.72);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  color: #F5F7FA;
  font-size: 16px;
  opacity: 0;
  transition: opacity 300ms ease;
}
.ea-cat-tile:hover .ea-cat-tile-arrow { opacity: 1; }

/* ── Bottom CTA ── */
.ea-cat-cta {
  text-align: center;
  padding: 24px var(--hp-px) var(--hp-section);
  max-width: var(--hp-max);
  margin: 0 auto;
}
.ea-cat-cta h2 {
  font-family: var(--hp-f-head);
  font-size: clamp(24px, 3.5vw, 40px);
  font-weight: 800;
  color: #F5F7FA;
  margin: 0 0 16px;
}
.ea-cat-cta p {
  font-family: var(--hp-f-body);
  font-size: 16px;
  color: #B8C2CC;
  margin: 0 0 28px;
}
.ea-cat-cta-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 15px 36px;
  background: #25D366;
  color: #fff;
  font-family: var(--hp-f-body);
  font-weight: 700;
  font-size: 15px;
  border-radius: 60px;
  text-decoration: none;
  transition: background 250ms ease, transform 250ms ease;
}
.ea-cat-cta-btn:hover { background: #1ebb57; transform: translateY(-2px); }
.ea-cat-cta-btn svg { width: 18px; height: 18px; }

/* ── Responsive ── */
@media (max-width: 1024px) {
  .ea-cat-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 767px) {
  .ea-cat-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
  .ea-cat-tile-body { padding: 14px 14px 18px; }
  .ea-cat-tile-name { font-size: 15px; }
  .ea-cat-tile-desc { font-size: 12.5px; }
  .ea-cat-hero { padding-top: 132px; padding-bottom: 56px; }
  .ea-cat-grid-wrap { padding-top: 16px; padding-bottom: 64px; }
  .ea-cat-cta { padding-top: 16px; padding-bottom: 56px; }
}
@media (max-width: 480px) {
  .ea-cat-grid { grid-template-columns: 1fr; gap: 14px; }
  .ea-cat-hero { padding-top: 132px; padding-bottom: 52px; }
}
</style>

<div class="ea-cat-page">

  <!-- Hero -->
  <section class="ea-cat-hero">
    <p class="ea-cat-hero-eyebrow">Our Products</p>
    <h1>Browse Our Product Catalogue</h1>
    <p>Over 700 premium printing, signage and branding products — everything your business needs to stand out in Dubai and the UAE.</p>
  </section>

  <!-- Category Grid -->
  <div class="ea-cat-grid-wrap">
    <div class="ea-cat-grid">
      <?php
        // Tile images from central curation file (EA-HOME-CURATION-003)
        $cat_image_map = ea_get_catalogue_category_image_map();
      ?>
      <?php foreach ( $categories as $cat ) :
        $img_url = isset( $cat_image_map[ $cat->slug ] ) ? $cat_image_map[ $cat->slug ] : '';
        $desc = isset( $cat_descriptions[ $cat->slug ] ) ? $cat_descriptions[ $cat->slug ] : '';
        $link = get_term_link( $cat );
      ?>
      <a class="ea-cat-tile" href="<?php echo esc_url( $link ); ?>">
        <span class="ea-cat-tile-arrow">→</span>
        <?php if ( $img_url ) : ?>
          <img class="ea-cat-tile-img" src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $cat->name ); ?>" loading="lazy">
        <?php else : ?>
          <div class="ea-cat-tile-img" style="background:#1B435E;"></div>
        <?php endif; ?>
        <div class="ea-cat-tile-body">
          <p class="ea-cat-tile-count"><?php echo intval( $cat->count ); ?> Products</p>
          <h3 class="ea-cat-tile-name"><?php echo esc_html( $cat->name ); ?></h3>
          <?php if ( $desc ) : ?>
            <p class="ea-cat-tile-desc"><?php echo esc_html( $desc ); ?></p>
          <?php endif; ?>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Bottom CTA -->
  <section class="ea-cat-cta">
    <h2>Can't Find What You Need?</h2>
    <p>Our team can produce custom signage, printing and branding solutions tailored to your exact requirements.</p>
    <a class="ea-cat-cta-btn" href="https://wa.me/971527966265" target="_blank" rel="noopener">
      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.625.846 5.059 2.284 7.034L.789 23.492a.75.75 0 00.913.913l4.458-1.495A11.952 11.952 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-2.319 0-4.476-.672-6.306-1.832l-.44-.277-3.065 1.027 1.027-3.065-.277-.44A9.953 9.953 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/></svg>
      WhatsApp Us Now
    </a>
  </section>

</div>

<?php get_footer(); ?>
