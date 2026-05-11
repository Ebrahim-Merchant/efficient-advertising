<?php
/**
 * Single Product Template — 10-Section SEO Landing Page
 * Efficient Advertising LLC, Dubai, UAE  |  Rebuilt: 2026-03-14
 *
 * @package Efficient_Modern
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<style>
:root {
  --bg:#F7F5F0; --bg-dark:#EDE9DF; --bg-card:#FFFFFF;
  --bg-dark1:#1A1A2E; --bg-dark2:#0F0F1E; --bg-dark3:#0A0A14;
  --amber:#FFBA09; --amber-dk:#E5A800; --amber-pale:#FFF8E1;
  --amber-ring:rgba(255,186,9,0.40);
  --tx:#1A1A2E; --tx-2:#374151; --tx-muted:#64748B;
  --tx-light:rgba(255,255,255,0.85);
  --green:#25D366; --border:rgba(26,26,46,0.10);
  --shadow-sm:0 2px 14px rgba(26,26,46,0.07);
  --shadow-md:0 6px 32px rgba(26,26,46,0.12);
  --r-sm:10px; --r-md:20px; --r-lg:28px; --r-pill:100px;
  --cream:#F7F5F0; --navy:#1A1A2E;
}
.sp-page { font-family:'Gotham',sans-serif; background:var(--bg); color:var(--tx); line-height:1.65; overflow-x:hidden; margin-top:100px; }
.sp-page h1, .sp-page h2, .sp-page h3 { font-family:'Gotham',sans-serif; }
.sec-label { font-family:'Gotham',sans-serif; font-size:10px; font-weight:600; letter-spacing:2px; text-transform:uppercase; color:var(--tx); background:var(--amber-pale); border:1.5px solid var(--amber-ring); padding:7px 18px; border-radius:var(--r-pill); display:inline-block; margin-bottom:22px; }

/* HERO CTAs */
.sp-hero-ctas { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 30px; }
.sp-hero-ctas a, .sp-hero-ctas button { 
    flex: 1; min-width: 140px; height: 40px; 
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    border-radius: var(--r-sm); font-size: 13px; font-weight: 700; cursor: pointer;
    transition: all 0.2s; text-decoration: none; border: none;
}
.sp-btn-wa { background: var(--green) !important; color: #fff !important; }
.sp-btn-wa:hover { background: #128C7E !important; transform: translateY(-2px); }
.sp-btn-quote { background: var(--amber) !important; color: var(--tx) !important; }
.sp-btn-quote:hover { background: var(--amber-dk) !important; transform: translateY(-2px); }
.sp-btn-call { background: transparent !important; color: var(--tx) !important; border: 1.5px solid var(--border) !important; }
.sp-btn-call:hover { background: rgba(26,26,46,0.05) !important; transform: translateY(-2px); }

/* TRUST BAR */
.sp-trust-bar { background: var(--bg-dark); padding: 50px 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); margin: 40px 0; width: 100vw; position: relative; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw; }
.sp-trust-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; max-width: 1200px; margin: 0 auto; padding: 0 20px; }
.sp-trust-item { display: flex; align-items: center; gap: 15px; font-weight: 700; color: var(--tx); }
.sp-trust-item i { width: 45px; height: 45px; background: var(--amber-pale); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--amber-dk); border: 1px solid var(--amber-ring); }

/* FAQ DARK CIRCLES */
.sp-faq-item summary { cursor: pointer; padding: 20px 0; display: flex; align-items: center; justify-content: space-between; font-weight: 700; border-top: 1px solid var(--border); list-style: none; }
.sp-faq-item summary::-webkit-details-marker { display: none; }
.sp-faq-icon { width: 28px; height: 28px; background: #1A1A2E; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s; font-size: 12px; }
.sp-faq-item[open] .sp-faq-icon { transform: rotate(180deg); background: var(--amber); color: #1A1A2E; }

/* ARTWORK Side-by-Side */
.sp-artwork-actions { display: flex; gap: 12px; margin-top: 20px; }
.sp-btn-art-wa { background: var(--green) !important; color: #fff !important; flex: 1; padding: 15px; border-radius: var(--r-sm); font-weight: 700; text-align: center; text-decoration: none; }
.sp-btn-art-email { background: transparent !important; color: var(--tx) !important; border: 1.5px solid var(--navy) !important; flex: 1; padding: 15px; border-radius: var(--r-sm); font-weight: 700; text-align: center; text-decoration: none; }

@media (max-width: 768px) {
    .sp-trust-grid { grid-template-columns: 1fr 1fr; }
    .sp-hero-ctas { flex-direction: column; }
    .sp-artwork-actions { flex-direction: column; }
}

/* Restoring Layout Styles */
.container { max-width: 1200px; margin: 0 auto; padding: 0 20px; width: 100%; box-sizing: border-box; }
.sp-hero { background: #F4F2ED; padding: 60px 0; color: var(--tx); }
.sp-hero-inner { display: grid; grid-template-columns: 1fr 360px; gap: 40px; align-items: start; }
.sp-hero-h1 { font-size: clamp(28px, 4vw, 42px); font-weight: 800; line-height:1.2; margin: 0 0 15px; color: #1A1A2E !important; }
.sp-hero-tagline { font-size: 16px; color: #374151 !important; line-height: 1.6; margin: 0 0 30px; }
.sp-breadcrumb { display: flex; gap: 8px; font-size: 12px; margin-bottom: 20px; color: var(--tx-muted); }
.sp-breadcrumb a { color: var(--tx-muted); text-decoration: none; }
.sp-breadcrumb a:hover { color: var(--amber-dk); }

.sp-hero-panel { background: #fff; border: 1px solid var(--border); border-radius: var(--r-md); padding: 25px; box-shadow: var(--shadow-sm); }
.sp-panel-title { font-size: 12px; font-weight: 800; text-transform: uppercase; color: var(--tx-muted); margin-bottom: 15px; border-bottom: 1px solid var(--border); padding-bottom: 10px; }
.sp-panel-row { display: flex; align-items: flex-start; gap: 12px; padding: 10px 0; border-bottom: 1px solid rgba(0,0,0,0.05); }
.sp-panel-row:last-child { border-bottom: none; }
.sp-panel-row i { color: var(--amber-dk); font-size: 16px; margin-top: 3px; }
.sp-panel-label { display: block; font-size: 11px; color: var(--tx-muted); font-weight: 700; text-transform: uppercase; }
.sp-panel-val { display: block; font-size: 14px; color: var(--tx); font-weight: 600; }
.sp-panel-cta { display: block; background: var(--green); color: #fff; text-align: center; padding: 12px; border-radius: 8px; font-weight: 700; text-decoration: none; margin-top: 20px; transition: background 0.2s; }
.sp-panel-cta:hover { background: #128C7E; }

.sp-gallery-section { padding: 50px 0; background: #fff; }
.sp-gallery-wrap { display: grid; grid-template-columns: 1fr 120px; gap: 20px; max-width: 900px; margin: 0 auto; }
.sp-gallery-main-img { width: 100%; border-radius: var(--r-md); border: 1px solid var(--border); cursor: zoom-in; }
.sp-gallery-thumbs { display: flex; flex-direction: column; gap: 10px; }
.sp-thumb-item { border-radius: 8px; overflow: hidden; border: 2px solid transparent; cursor: pointer; height: 80px; }
.sp-thumb-item.active { border-color: var(--amber); }
.sp-thumb-item img { width: 100%; height: 100%; object-fit: cover; }

.sp-specs-section { padding: 80px 0; background: var(--bg); }
.sp-sec-hdr { text-align: center; margin-bottom: 50px; }
.sp-sec-hdr h2 { font-size: 32px; color: var(--tx); margin-bottom: 15px; }
.sp-sec-hdr p { color: var(--tx-muted); }
.sp-specs-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
.sp-spec-card { background: #fff; padding: 30px 20px; border-radius: var(--r-md); border: 1px solid var(--border); text-align: center; transition: transform 0.2s; }
.sp-spec-card:hover { transform: translateY(-5px); border-color: var(--amber); }
.sp-spec-icon-wrap { width: 50px; height: 50px; background: var(--amber-pale); color: var(--amber-dk); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 20px; }
.sp-spec-label { font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--tx-muted); margin-bottom: 5px; }
.sp-spec-val { font-size: 15px; font-weight: 600; color: var(--tx); }

.sp-pricing-section { padding: 80px 0; background: #fff; }
.sp-pricing-wrap { overflow-x: auto; }
.sp-pricing-tbl { width: 100%; border-collapse: collapse; background: #fff; border: 1px solid var(--border); }
.sp-pricing-tbl th { background: var(--tx); color: #fff; padding: 15px; text-align: left; font-size: 14px; }
.sp-pricing-tbl td { padding: 15px; border-bottom: 1px solid var(--border); font-size: 14px; }
.sp-pricing-tbl tr:hover td { background: var(--bg); }
.sp-price-wa { background: var(--green); color: #fff; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-weight: 700; font-size: 13px; }

.sp-why-section { padding: 80px 0; background: var(--bg); }
.sp-why-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
.sp-why-card { background: #fff; padding: 30px; border-radius: var(--r-md); border: 1px solid var(--border); text-align: center; }
.sp-why-icon { width: 60px; height: 60px; background: var(--tx); color: var(--amber); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; }
.sp-why-card h3 { font-size: 18px; margin-bottom: 10px; }

.sp-related-section { padding: 80px 0; background: var(--bg); }
.sp-related-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
.sp-related-card { display: block; background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid var(--border); text-decoration: none; transition: transform 0.2s; }
.sp-related-card:hover { transform: translateY(-5px); border-color: var(--amber); }
.sp-related-img img { width: 100%; height: 200px; object-fit: cover; }
.sp-related-name { padding: 15px; font-weight: 700; color: var(--tx); }
.sp-related-link { padding: 0 15px 15px; color: var(--amber-dk); font-size: 13px; font-weight: 700; }

@media (max-width: 900px) {
    .sp-hero-inner { grid-template-columns: 1fr; }
    .sp-why-grid { grid-template-columns: 1fr 1fr; }
    .sp-related-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 600px) {
    .sp-why-grid { grid-template-columns: 1fr; }
    .sp-related-grid { grid-template-columns: 1fr; }
    .sp-gallery-wrap { grid-template-columns: 1fr; }
    .sp-gallery-thumbs { flex-direction: row; }
    .sp-thumb-item { flex: 1; height: 60px; }
}

/* ── DARK HERO SECTION ── */
#ea-pg-hero {
  background: #0F0F1E;
  padding: clamp(36px,4vw,72px) 0 clamp(48px,5vw,90px);
  position: relative; overflow: hidden;
}
#ea-pg-hero::before {
  content: ''; position: absolute; inset: 0; pointer-events: none; z-index: 0;
  background: radial-gradient(ellipse at 0% 50%, rgba(255,186,9,0.05) 0%, transparent 50%),
              radial-gradient(ellipse at 100% 20%, rgba(255,186,9,0.04) 0%, transparent 45%);
}
.ea-pg-hero-grid {
  display: grid; grid-template-columns: 1fr 1fr;
  gap: clamp(28px,4vw,60px); align-items: start;
  position: relative; z-index: 1;
}
@media (max-width: 991px) { .ea-pg-hero-grid { grid-template-columns: 1fr; } }
/* Gallery */
.ea-pg-main-img {
  width: 100%; aspect-ratio: 4/3; border-radius: var(--r-md); overflow: hidden;
  border: 1px solid rgba(255,255,255,0.08); background: #0A0A14;
  position: relative; cursor: zoom-in;
}
.ea-pg-main-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s cubic-bezier(0.25,0.46,0.45,0.94); display: block; }
.ea-pg-main-img:hover img { transform: scale(1.04); }
.ea-pg-zoom-btn {
  position: absolute; top: 14px; right: 14px; width: 34px; height: 34px; border-radius: 50%;
  background: rgba(10,10,20,0.70); backdrop-filter: blur(6px);
  display: flex; align-items: center; justify-content: center;
  border: 1px solid rgba(255,255,255,0.14); cursor: pointer; transition: background .2s;
}
.ea-pg-zoom-btn:hover { background: rgba(255,186,9,0.25); }
.ea-pg-thumbs { display: grid; grid-template-columns: repeat(4,1fr); gap: 10px; margin-top: 12px; }
.ea-pg-thumb {
  aspect-ratio: 1; border-radius: var(--r-sm); overflow: hidden;
  border: 2px solid transparent; background: #0A0A14; cursor: pointer;
  transition: border-color .2s, transform .2s;
}
.ea-pg-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.ea-pg-thumb:hover { border-color: rgba(255,186,9,0.50); transform: translateY(-2px); }
.ea-pg-thumb.active { border-color: var(--amber); }
/* Product info right column */
.ea-pg-category-pill {
  display: inline-block; font-family: 'Gotham',sans-serif;
  font-size: 9px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase;
  color: var(--amber); background: rgba(255,186,9,0.10);
  border: 1px solid rgba(255,186,9,0.25); padding: 5px 14px;
  border-radius: var(--r-pill); margin-bottom: 14px;
}
.ea-pg-title {
  font-family: 'Gotham',sans-serif; font-size: clamp(26px,2.8vw,44px);
  font-weight: 800; line-height: 1.2; color: #fff; margin: 0 0 14px; letter-spacing: -0.5px;
}
.ea-pg-short-desc {
  font-family: 'Gotham',sans-serif; font-size: clamp(14px,1.1vw,16px);
  color: rgba(255,255,255,0.68); line-height: 1.75; margin: 0 0 24px;
}
/* Spec badge pills */
.ea-pg-spec-badges { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 28px; }
.ea-pg-badge {
  display: flex; align-items: center; gap: 6px;
  background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.10);
  border-radius: var(--r-sm); padding: 7px 12px; font-family: 'Gotham',sans-serif;
}
.ea-pg-badge-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; color: var(--amber); opacity: 0.75; display: block; line-height: 1; }
.ea-pg-badge-value { font-size: 13px; font-weight: 600; color: rgba(255,255,255,0.88); display: block; line-height: 1.3; margin-top: 2px; }
/* Config panel */
.ea-pg-config {
  background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08);
  border-radius: var(--r-md); padding: clamp(18px,2vw,26px); margin-bottom: 24px;
}
.ea-pg-config-title {
  font-family: 'Gotham',sans-serif; font-size: 13px; font-weight: 700;
  text-transform: uppercase; letter-spacing: 1.5px; color: rgba(255,255,255,0.50);
  margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
}
.ea-pg-config-title::after { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.08); }
.ea-pg-option-group { margin-bottom: 20px; }
.ea-pg-option-group:last-child { margin-bottom: 0; }
.ea-pg-option-label {
  font-family: 'Gotham',sans-serif; font-size: 11px; font-weight: 700;
  text-transform: uppercase; letter-spacing: 1.2px; color: rgba(255,255,255,0.42);
  margin-bottom: 10px; display: flex; align-items: center; gap: 8px;
}
.ea-pg-option-label span { font-family: 'Gotham',sans-serif; font-size: 13px; font-weight: 600; text-transform: none; letter-spacing: 0; color: rgba(255,255,255,0.82); }
.ea-pg-option-btns { display: flex; flex-wrap: wrap; gap: 8px; }
.ea-pg-opt-btn {
  padding: 9px 16px; background: rgba(255,255,255,0.04);
  border: 1.5px solid rgba(255,255,255,0.12); border-radius: var(--r-sm);
  font-family: 'Gotham',sans-serif; font-size: 13px; font-weight: 500;
  color: rgba(255,255,255,0.72); cursor: pointer;
  transition: border-color .18s, background .18s, color .18s; text-align: center;
}
.ea-pg-opt-btn:hover { border-color: rgba(255,186,9,0.50); background: rgba(255,186,9,0.06); color: #fff; }
.ea-pg-opt-btn.selected { border-color: var(--amber); background: rgba(255,186,9,0.12); color: #fff; font-weight: 700; }
/* Qty row */
.ea-pg-qty-row { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
.ea-pg-qty-label { font-family: 'Gotham',sans-serif; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; color: rgba(255,255,255,0.42); flex-shrink: 0; }
.ea-pg-qty-wrap {
  display: flex; align-items: center; gap: 0;
  background: rgba(255,255,255,0.04); border: 1.5px solid rgba(255,255,255,0.12);
  border-radius: var(--r-sm); overflow: hidden;
}
.ea-pg-qty-btn {
  width: 38px; height: 38px; background: none; border: none;
  color: rgba(255,255,255,0.60); font-size: 18px; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: background .15s, color .15s;
}
.ea-pg-qty-btn:hover { background: rgba(255,186,9,0.12); color: var(--amber); }
.ea-pg-qty-num {
  width: 52px; text-align: center; background: none; border: none;
  border-left: 1px solid rgba(255,255,255,0.08); border-right: 1px solid rgba(255,255,255,0.08);
  font-family: 'Gotham',sans-serif; font-size: 15px; font-weight: 700;
  color: #fff; padding: 8px 0; outline: none; -moz-appearance: textfield;
}
.ea-pg-qty-num::-webkit-outer-spin-button, .ea-pg-qty-num::-webkit-inner-spin-button { -webkit-appearance: none; }
/* CTA row in hero */
.ea-pg-cta-row { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 24px; }
.btn-amber-solid {
  display: inline-flex; align-items: center; justify-content: center; gap: 10px;
  background: var(--amber); color: var(--tx); font-family: 'Gotham',sans-serif;
  font-size: 13px; font-weight: 700; padding: 10px 22px; border-radius: var(--r-sm);
  border: none; cursor: pointer; transition: background .2s, transform .2s;
  text-decoration: none; white-space: nowrap; flex: 1; min-width: 160px;
}
.btn-amber-solid:hover { background: var(--amber-dk); transform: translateY(-2px); color: var(--tx); }
.btn-outline-amber {
  display: inline-flex; align-items: center; justify-content: center; gap: 10px;
  background: transparent; color: var(--amber); font-family: 'Gotham',sans-serif;
  font-size: 13px; font-weight: 600; padding: 9px 22px; border-radius: var(--r-sm);
  border: 1.5px solid rgba(255,186,9,0.50); cursor: pointer;
  transition: background .2s, border-color .2s, transform .2s;
  text-decoration: none; white-space: nowrap; flex: 1; min-width: 160px;
}
.btn-outline-amber:hover { background: rgba(255,186,9,0.10); border-color: var(--amber); transform: translateY(-2px); color: var(--amber); }
/* WA quick link */
.ea-pg-wa-link {
  display: flex; align-items: center; gap: 8px; font-family: 'Gotham',sans-serif;
  font-size: 13px; color: #4ade80; text-decoration: none;
  transition: color .2s; margin-bottom: 24px;
}
.ea-pg-wa-link:hover { color: #86efac; }
/* Trust badges in hero */
.ea-pg-trust {
  display: flex; flex-wrap: wrap; gap: 10px; padding-top: 20px;
  border-top: 1px solid rgba(255,255,255,0.07);
}
.ea-pg-trust-item {
  display: flex; align-items: center; gap: 8px; font-family: 'Gotham',sans-serif;
  font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.55);
}
.ea-pg-trust-item .trust-ico {
  width: 28px; height: 28px; border-radius: 50%; background: rgba(255,186,9,0.10);
  border: 1px solid rgba(255,186,9,0.20); display: flex; align-items: center;
  justify-content: center; flex-shrink: 0;
}
.ea-pg-trust-item .trust-ico svg { fill: var(--amber); width: 13px; height: 13px; }
/* Breadcrumb bar */
#ea-pg-breadcrumb {
  background: #0A0A14; border-bottom: 1px solid rgba(255,255,255,0.06);
  padding: 13px 0; position: relative; z-index: 1;
}
.ea-breadcrumb {
  display: flex; align-items: center; gap: 0; flex-wrap: wrap;
  list-style: none; margin: 0; padding: 0;
}
.ea-breadcrumb li {
  display: flex; align-items: center; font-family: 'Gotham',sans-serif;
  font-size: 13px; color: rgba(255,255,255,0.40);
}
.ea-breadcrumb li a { color: rgba(255,255,255,0.50); text-decoration: none; transition: color .2s; }
.ea-breadcrumb li a:hover { color: var(--amber); }
.ea-breadcrumb li.active { color: rgba(255,255,255,0.82); font-weight: 500; }
.ea-breadcrumb .sep { margin: 0 8px; color: rgba(255,255,255,0.18); font-size: 11px; }
/* Sticky mobile CTA bar */
.ea-sticky-bar {
  display: none; position: fixed; bottom: 0; left: 0; right: 0; z-index: 9999;
  background: #0A0A14; box-shadow: 0 -2px 16px rgba(0,0,0,0.4);
  border-top: 1px solid rgba(255,186,9,0.22);
}
.ea-sticky-btn {
  flex: 1; display: flex; flex-direction: column; align-items: center;
  justify-content: center; gap: 3px; padding: 10px 4px 8px;
  font-family: 'Gotham',sans-serif; font-size: 10px; font-weight: 700;
  text-decoration: none; text-transform: uppercase; letter-spacing: 0.4px;
  transition: background 0.15s;
}
.ea-sticky-call  { color: #60a5fa; border-right: 1px solid rgba(255,255,255,0.08); }
.ea-sticky-wa    { color: #4ade80; border-right: 1px solid rgba(255,255,255,0.08); }
.ea-sticky-quote { color: var(--amber); }
@media (max-width: 767px) { .ea-sticky-bar { display: flex; } body { padding-bottom: 62px; } }
</style>
<?php

/* =========================================================
   PER-CATEGORY CONFIG  (key = product_category slug)
   Each entry: tagline, specs[6], pricing[4], faq[4]
   ========================================================= */
$_ea_cats = [
  'backdrop-display-dubai' => [
    'tagline' => 'Custom backdrops, pop-up stands, step-and-repeat & fabric displays — designed, printed & installed across Dubai & the UAE.',
    'specs'   => [
      ['icon'=>'fa-ruler-combined','label'=>'Sizes',      'val'=>'Any size — A0 to 5×10m+'],
      ['icon'=>'fa-layer-group',  'label'=>'Materials',  'val'=>'Fabric, PVC, canvas, flex'],
      ['icon'=>'fa-palette',      'label'=>'Print',      'val'=>'Full-colour digital'],
      ['icon'=>'fa-bolt',         'label'=>'Turnaround', 'val'=>'Same-day / next-day'],
      ['icon'=>'fa-screwdriver-wrench','label'=>'Finish','val'=>'Hemmed, eyelets, frame kit'],
      ['icon'=>'fa-truck-fast',   'label'=>'Delivery',   'val'=>'Dubai & all UAE'],
    ],
    'pricing' => [
      ['size'=>'1×2m Pop-up Backdrop',      'mat'=>'PVC Vinyl',                 'price'=>'AED 55 – 85'],
      ['size'=>'2×3m Step-and-Repeat',      'mat'=>'Fabric / Flex',             'price'=>'AED 120 – 180'],
      ['size'=>'3×6m Backdrop + Frame',     'mat'=>'Fabric + Aluminium Frame',  'price'=>'AED 380 – 600'],
      ['size'=>'Custom Large Format',       'mat'=>'Canvas / Vinyl',            'price'=>'Request Quote'],
    ],
    'faq' => [
      ['q'=>'What is the minimum order for custom backdrops in Dubai?',
       'a'=>'We print from 1 piece with no minimum order. Custom sizes are always welcome.'],
      ['q'=>'Do you supply the frame with the backdrop?',
       'a'=>'Yes — we offer complete kits with aluminium pop-up or straight frames plus a carry bag.'],
      ['q'=>'Can I get same-day backdrop printing in Dubai?',
       'a'=>'Yes. Order before 10am for same-day collection from our Dubai production facility.'],
      ['q'=>'What file format do you need for backdrop printing?',
       'a'=>'AI, PDF or high-resolution JPG/PNG at 150 dpi at actual size. Free artwork support included.'],
    ],
  ],
  'flex-banner-printing-dubai' => [
    'tagline' => 'Roll-up banners, X-banners, flex banners & fence banners — vibrant print quality, fast turnaround, competitive prices across Dubai & UAE.',
    'specs'   => [
      ['icon'=>'fa-ruler-combined','label'=>'Sizes',      'val'=>'0.6m – 3m wide, any length'],
      ['icon'=>'fa-layer-group',  'label'=>'Materials',  'val'=>'Flex, mesh, vinyl, banner cloth'],
      ['icon'=>'fa-palette',      'label'=>'Print',      'val'=>'UV / solvent / latex digital'],
      ['icon'=>'fa-bolt',         'label'=>'Turnaround', 'val'=>'4 – 24 hrs, same-day available'],
      ['icon'=>'fa-screwdriver-wrench','label'=>'Finish','val'=>'Hemmed edges, eyelets, pole pockets'],
      ['icon'=>'fa-truck-fast',   'label'=>'Delivery',   'val'=>'Free Dubai delivery, all UAE'],
    ],
    'pricing' => [
      ['size'=>'Roll-up Banner 85×200cm',  'mat'=>'Premium vinyl + stand',     'price'=>'AED 65 – 110'],
      ['size'=>'X-Banner 60×160cm',        'mat'=>'Polyester + X-frame',       'price'=>'AED 45 – 75'],
      ['size'=>'Flex Banner 1×3m',         'mat'=>'500gsm blockout flex',      'price'=>'AED 45 – 75'],
      ['size'=>'Fence Banner 1×5m (mesh)', 'mat'=>'PVC mesh',                  'price'=>'AED 75 – 120'],
    ],
    'faq' => [
      ['q'=>'What is flex banner printing?',
       'a'=>'Flex banners are large-format prints on durable PVC or mesh, ideal for outdoor events, scaffolding, and fencing.'],
      ['q'=>'How fast can you print a roll-up banner in Dubai?',
       'a'=>'Same-day if ordered before 10am. Urgent roll-up banners completed within 2–4 hours from order confirmation.'],
      ['q'=>'Do roll-up banner prices include the stand?',
       'a'=>'Yes — our price includes a premium retractable aluminium stand with carry bag.'],
      ['q'=>'Can flex banners be used outdoors in Dubai?',
       'a'=>'Absolutely — our flex and mesh banners are UV-resistant and weatherproof for 2–3 years outdoor use.'],
    ],
  ],
  'flags-printing-dubai' => [
    'tagline' => 'Teardrop flags, feather flags, car flags, table flags & event flags — full colour dye sublimation, fast delivery across Dubai & UAE.',
    'specs'   => [
      ['icon'=>'fa-flag',         'label'=>'Types',      'val'=>'Teardrop, feather, car, table, event'],
      ['icon'=>'fa-layer-group',  'label'=>'Materials',  'val'=>'Polyester, knitted polyester, satin'],
      ['icon'=>'fa-palette',      'label'=>'Print',      'val'=>'Dye sublimation, full colour'],
      ['icon'=>'fa-bolt',         'label'=>'Turnaround', 'val'=>'3–5 working days, express available'],
      ['icon'=>'fa-screwdriver-wrench','label'=>'Includes','val'=>'Pole, ground spike / base options'],
      ['icon'=>'fa-truck-fast',   'label'=>'Delivery',   'val'=>'Dubai, Abu Dhabi, Sharjah & UAE'],
    ],
    'pricing' => [
      ['size'=>'Teardrop Flag 2m',      'mat'=>'Knitted polyester + pole',         'price'=>'AED 85 – 140'],
      ['size'=>'Feather Flag 4.5m',     'mat'=>'Knitted polyester + pole + base',  'price'=>'AED 140 – 220'],
      ['size'=>'Table Flag A5',         'mat'=>'Satin polyester',                  'price'=>'AED 25 – 40'],
      ['size'=>'Car Flags 30×45cm',     'mat'=>'Polyester pair',                   'price'=>'AED 40 – 70'],
    ],
    'faq' => [
      ['q'=>'What types of flag printing do you offer in Dubai?',
       'a'=>'We print teardrop, feather, rectangular, car, hand, table and custom-shaped event flags with full-colour dye sublimation.'],
      ['q'=>'Are your promotional flags suitable for outdoor use?',
       'a'=>'Yes — all flags are printed on UV-treated polyester, colourfast and weatherproof for outdoor events.'],
      ['q'=>'Can I get custom-shaped flags?',
       'a'=>'Yes — teardrop and feather shapes are standard; completely custom-cut shapes are available.'],
      ['q'=>'What is the minimum quantity for flag printing?',
       'a'=>'From 1 piece. Bulk pricing applies from 10 units onwards.'],
    ],
  ],
  'stationery-printing-dubai' => [
    'tagline' => 'Business cards, letterheads, NCR books, envelopes & corporate stationery printing in Dubai — premium quality, same-day available.',
    'specs'   => [
      ['icon'=>'fa-id-card',      'label'=>'Products',   'val'=>'Cards, letterheads, NCR, envelopes'],
      ['icon'=>'fa-layer-group',  'label'=>'Materials',  'val'=>'350gsm silk, uncoated, recycled'],
      ['icon'=>'fa-palette',      'label'=>'Finish',     'val'=>'Matt, gloss, soft-touch, spot UV'],
      ['icon'=>'fa-bolt',         'label'=>'Turnaround', 'val'=>'Same-day to 3 working days'],
      ['icon'=>'fa-hashtag',      'label'=>'Quantity',   'val'=>'From 50 to 100,000+ copies'],
      ['icon'=>'fa-truck-fast',   'label'=>'Delivery',   'val'=>'Door-to-door, all UAE'],
    ],
    'pricing' => [
      ['size'=>'Business Cards 85×55mm',  'mat'=>'350gsm gloss / matt (250 pcs)', 'price'=>'AED 45 – 85'],
      ['size'=>'Letterhead A4',           'mat'=>'100gsm uncoated (500 pcs)',      'price'=>'AED 65 – 120'],
      ['size'=>'NCR Books 2-part A5',     'mat'=>'Self-copy paper (25 sets)',      'price'=>'AED 55 – 95'],
      ['size'=>'DL Envelopes',            'mat'=>'80gsm (box of 500)',             'price'=>'AED 95 – 160'],
    ],
    'faq' => [
      ['q'=>'Can I get same-day business card printing in Dubai?',
       'a'=>'Yes — single-sided or double-sided cards on standard stock are available same-day if artwork is submitted before 10am.'],
      ['q'=>'Do you print NCR (carbonless copy) books?',
       'a'=>'Yes — 2-part, 3-part and 4-part NCR books in A4/A5/A6 with sequential numbering, padding, and binding.'],
      ['q'=>'What is the minimum for stationery printing?',
       'a'=>'Business cards from 50 pcs, letterheads from 100 sheets, NCR books from 10 books.'],
      ['q'=>'Can you match our brand colours exactly?',
       'a'=>'Yes — we use Pantone matching and CMYK proofing to ensure brand colour consistency.'],
    ],
  ],
  'sticker-printing-dubai' => [
    'tagline' => 'Custom sticker printing in Dubai — vinyl, PVC, die-cut, wall, floor & glass stickers. Waterproof, UV-resistant, fast turnaround.',
    'specs'   => [
      ['icon'=>'fa-tag',          'label'=>'Types',      'val'=>'Vinyl, die-cut, wall, glass, floor'],
      ['icon'=>'fa-layer-group',  'label'=>'Materials',  'val'=>'Vinyl, polyester, PVC, clear'],
      ['icon'=>'fa-palette',      'label'=>'Finish',     'val'=>'Gloss, matt, clear, white'],
      ['icon'=>'fa-bolt',         'label'=>'Turnaround', 'val'=>'Same-day to 2 working days'],
      ['icon'=>'fa-hashtag',      'label'=>'Quantity',   'val'=>'From 1 to 100,000+ pieces'],
      ['icon'=>'fa-truck-fast',   'label'=>'Delivery',   'val'=>'All UAE, express available'],
    ],
    'pricing' => [
      ['size'=>'A4 Sheet Stickers',       'mat'=>'Gloss vinyl (50 sheets)',  'price'=>'AED 75 – 130'],
      ['size'=>'Round Stickers 50mm',     'mat'=>'Matt vinyl (200 pcs)',     'price'=>'AED 55 – 95'],
      ['size'=>'Wall Sticker A1',         'mat'=>'Removable vinyl',          'price'=>'AED 65 – 120'],
      ['size'=>'Floor Sticker 50×50cm',   'mat'=>'Anti-slip laminate',       'price'=>'AED 45 – 90'],
    ],
    'faq' => [
      ['q'=>'Are your vinyl stickers waterproof?',
       'a'=>'Yes — all vinyl stickers are waterproof and UV-resistant for indoor and outdoor UAE conditions.'],
      ['q'=>'Can you cut stickers to custom shapes?',
       'a'=>'Yes — die-cut and contour-cut in any shape. No minimum required for die-cuts.'],
      ['q'=>'How long do outdoor stickers last in Dubai?',
       'a'=>'Outdoor vinyl with UV lamination last 3–5 years in Dubai\'s climate.'],
      ['q'=>'What is the smallest quantity I can order?',
       'a'=>'From 1 piece for large-format stickers. Cut stickers from 10 pcs minimum.'],
    ],
  ],
  'signage-dubai' => [
    'tagline' => '3D letters, acrylic signs, backlit LED channel letters, reception signs & outdoor signage — design, fabrication & full installation Dubai & UAE.',
    'specs'   => [
      ['icon'=>'fa-building',     'label'=>'Types',      'val'=>'3D letters, acrylic, LED, backlit'],
      ['icon'=>'fa-layer-group',  'label'=>'Materials',  'val'=>'Acrylic, aluminium, stainless steel'],
      ['icon'=>'fa-lightbulb',    'label'=>'Lighting',   'val'=>'LED backlit, halo-lit, edge-lit'],
      ['icon'=>'fa-bolt',         'label'=>'Turnaround', 'val'=>'5–10 working days (rush available)'],
      ['icon'=>'fa-screwdriver-wrench','label'=>'Service','val'=>'Design + fabrication + installation'],
      ['icon'=>'fa-truck-fast',   'label'=>'Coverage',   'val'=>'Dubai, Abu Dhabi, Sharjah & UAE'],
    ],
    'pricing' => [
      ['size'=>'Acrylic Reception Sign 60×90cm','mat'=>'10mm acrylic on standoffs',  'price'=>'AED 350 – 650'],
      ['size'=>'3D Logo Letters (1m wide)', 'mat'=>'Acrylic / aluminium',             'price'=>'AED 550 – 1,200'],
      ['size'=>'Backlit Channel Letters',   'mat'=>'Aluminium + LED (per letter)',     'price'=>'AED 200 – 500/letter'],
      ['size'=>'Outdoor Signboard',         'mat'=>'Aluminium composite panel',        'price'=>'Request Quote'],
    ],
    'faq' => [
      ['q'=>'Do you supply and install signage in Dubai?',
       'a'=>'Yes — full process: design, fabrication, delivery and installation anywhere in Dubai and the UAE.'],
      ['q'=>'What materials are best for outdoor signage in Dubai?',
       'a'=>'Aluminium composite panels, marine-grade stainless steel and UV-stabilised acrylic perform best in UAE outdoor conditions.'],
      ['q'=>'How long does custom 3D signage take?',
       'a'=>'Standard 3D letter signs take 5–7 working days. Rush orders in 3 days with an express surcharge.'],
      ['q'=>'Do you make backlit LED signs?',
       'a'=>'Yes — LED backlit channel letters, halo-lit signs and lightboxes of all sizes for shop fronts and offices.'],
    ],
  ],
  'promotional-gifts-dubai' => [
    'tagline' => 'Branded USB drives, pens, mugs, notebooks & corporate gift sets — custom logo printing & engraving for businesses Dubai & UAE.',
    'specs'   => [
      ['icon'=>'fa-gift',         'label'=>'Products',   'val'=>'USB, pens, mugs, notebooks, bags'],
      ['icon'=>'fa-palette',      'label'=>'Branding',   'val'=>'Print, emboss, engrave, embroidery'],
      ['icon'=>'fa-hashtag',      'label'=>'MOQ',        'val'=>'From 25 pieces per item'],
      ['icon'=>'fa-bolt',         'label'=>'Turnaround', 'val'=>'3–7 working days (stock items)'],
      ['icon'=>'fa-box-open',     'label'=>'Packaging',  'val'=>'Custom gift box / retail packaging'],
      ['icon'=>'fa-truck-fast',   'label'=>'Delivery',   'val'=>'All UAE + export available'],
    ],
    'pricing' => [
      ['size'=>'Branded Metal Pen',    'mat'=>'Laser engraved (50 pcs)',      'price'=>'AED 8 – 18/pc'],
      ['size'=>'Ceramic Mug 11oz',     'mat'=>'Full colour print (50 pcs)',   'price'=>'AED 15 – 28/pc'],
      ['size'=>'USB Flash Drive 16GB', 'mat'=>'Branded metal body (50 pcs)', 'price'=>'AED 22 – 40/pc'],
      ['size'=>'Corporate Gift Set',   'mat'=>'Pen + notebook + USB + box',  'price'=>'AED 75 – 150/set'],
    ],
    'faq' => [
      ['q'=>'What is the minimum order for promotional gifts in Dubai?',
       'a'=>'Minimum 25 pieces for most branded gifts. Notebooks and premium items from 50 pcs.'],
      ['q'=>'Can you brand gifts with our logo?',
       'a'=>'Yes — we print, engrave, emboss or embroider your logo on all promotional items.'],
      ['q'=>'Do you do custom corporate gift packaging?',
       'a'=>'Yes — custom-printed gift boxes, tissue paper, sleeves and bags available.'],
      ['q'=>'How fast can you deliver promotional gifts in Dubai?',
       'a'=>'Stock items with branding: 3–5 working days. Custom-manufactured items: 10–14 working days.'],
    ],
  ],
  'vehicle-branding' => [
    'tagline' => 'Full vehicle wraps, partial wraps & fleet graphics — premium 3M / Avery vinyl, expert application, mobile advertising across Dubai & UAE.',
    'specs'   => [
      ['icon'=>'fa-car',          'label'=>'Services',   'val'=>'Full wrap, partial, spot graphics'],
      ['icon'=>'fa-layer-group',  'label'=>'Materials',  'val'=>'3M, Avery, KPMF cast vinyl'],
      ['icon'=>'fa-palette',      'label'=>'Finish',     'val'=>'Gloss, matt, satin, chrome, metallic'],
      ['icon'=>'fa-bolt',         'label'=>'Turnaround', 'val'=>'1–3 days per vehicle'],
      ['icon'=>'fa-car-side',     'label'=>'Vehicles',   'val'=>'Cars, vans, trucks, buses, boats'],
      ['icon'=>'fa-truck-fast',   'label'=>'Coverage',   'val'=>'Dubai, Sharjah, Abu Dhabi'],
    ],
    'pricing' => [
      ['size'=>'Sedan Full Wrap',          'mat'=>'Premium cast vinyl',   'price'=>'AED 1,800 – 3,500'],
      ['size'=>'Van / SUV Full Wrap',      'mat'=>'Premium cast vinyl',   'price'=>'AED 2,500 – 5,000'],
      ['size'=>'Partial Wrap (one side)',  'mat'=>'Cast vinyl',           'price'=>'AED 600 – 1,400'],
      ['size'=>'Fleet Graphics (van)',     'mat'=>'Cut vinyl / digital',  'price'=>'AED 400 – 900/vehicle'],
    ],
    'faq' => [
      ['q'=>'How long does a vehicle wrap last in Dubai?',
       'a'=>'Premium cast vinyl wraps last 5–7 years in Dubai\'s climate. Calendared vinyl lasts 2–3 years.'],
      ['q'=>'Will vehicle wrapping damage my car\'s paintwork?',
       'a'=>'No — premium cast vinyl protects the paint. When removed correctly, the paintwork is fully preserved.'],
      ['q'=>'How long does it take to wrap a car in Dubai?',
       'a'=>'A standard sedan full wrap takes 1–2 days. Larger vehicles (vans, buses) take 2–3 days.'],
      ['q'=>'Do you wrap fleet vehicles for companies?',
       'a'=>'Yes — we specialise in fleet branding, ensuring consistent brand application across all vehicles.'],
    ],
  ],
  'plastic-bags-printing' => [
    'tagline' => 'Custom printed plastic bags in Dubai — HDPE, LDPE, non-woven PP and biodegradable bags with logo printing for retail & corporate use.',
    'specs'   => [
      ['icon'=>'fa-shopping-bag', 'label'=>'Types',      'val'=>'HDPE, LDPE, non-woven, biodegradable'],
      ['icon'=>'fa-ruler-combined','label'=>'Sizes',     'val'=>'S, M, L, XL or custom dimensions'],
      ['icon'=>'fa-palette',      'label'=>'Print',      'val'=>'1–6 colour flexo / full digital'],
      ['icon'=>'fa-hashtag',      'label'=>'MOQ',        'val'=>'From 500 pieces'],
      ['icon'=>'fa-bolt',         'label'=>'Turnaround', 'val'=>'7–14 working days'],
      ['icon'=>'fa-truck-fast',   'label'=>'Delivery',   'val'=>'All UAE — factory direct pricing'],
    ],
    'pricing' => [
      ['size'=>'HDPE T-Shirt Bag Medium',  'mat'=>'25 micron (1,000 pcs)',   'price'=>'AED 65 – 120'],
      ['size'=>'LDPE Carry Bag Large',     'mat'=>'50 micron (500 pcs)',     'price'=>'AED 95 – 160'],
      ['size'=>'Non-Woven PP Bag',         'mat'=>'80gsm with print (500)', 'price'=>'AED 180 – 350'],
      ['size'=>'Biodegradable Bags',       'mat'=>'D2W oxo-degradable (500)','price'=>'Request Quote'],
    ],
    'faq' => [
      ['q'=>'What types of plastic bags do you print in Dubai?',
       'a'=>'We print HDPE T-shirt bags, LDPE carrier bags, non-woven PP bags, oxo-biodegradable and compostable bags.'],
      ['q'=>'What is the minimum order for printed plastic bags?',
       'a'=>'Minimum 500 pieces for most bag types; HDPE bags from 1,000 pcs.'],
      ['q'=>'Can printed bags be biodegradable?',
       'a'=>'Yes — D2W oxo-biodegradable and fully compostable bags with full-colour logo printing available.'],
      ['q'=>'Do your bags comply with UAE plastic regulations?',
       'a'=>'Yes — all bags comply with UAE packaging regulations. Eco-friendly alternatives available.'],
    ],
  ],
  'exhibition-event-management' => [
    'tagline' => 'Exhibition stand design, build & management in Dubai — shell scheme, modular & bespoke custom stands for trade shows & events UAE-wide.',
    'specs'   => [
      ['icon'=>'fa-store',        'label'=>'Stand Types', 'val'=>'Shell scheme, modular, bespoke'],
      ['icon'=>'fa-ruler-combined','label'=>'Stand Sizes','val'=>'9m² to 200m²+'],
      ['icon'=>'fa-layer-group',  'label'=>'Materials',  'val'=>'Aluminium, fabric, acrylic, LED'],
      ['icon'=>'fa-bolt',         'label'=>'Turnaround', 'val'=>'Design 48hrs, build 5–10 days'],
      ['icon'=>'fa-screwdriver-wrench','label'=>'Service','val'=>'Design + build + install + dismantle'],
      ['icon'=>'fa-truck-fast',   'label'=>'Venues',     'val'=>'DWTC, ADNEC, Expo City & all UAE'],
    ],
    'pricing' => [
      ['size'=>'Shell Scheme Upgrade 9m²','mat'=>'Graphics + furniture',       'price'=>'AED 1,800 – 4,000'],
      ['size'=>'Modular Stand 18m²',      'mat'=>'Aluminium + fabric walls',   'price'=>'AED 6,000 – 12,000'],
      ['size'=>'Bespoke Stand 36m²',      'mat'=>'Fully custom fabrication',   'price'=>'AED 18,000 – 45,000'],
      ['size'=>'Pop-up Display 3m',       'mat'=>'Fabric + frame',             'price'=>'AED 900 – 1,800'],
    ],
    'faq' => [
      ['q'=>'Do you design and build exhibition stands in Dubai?',
       'a'=>'Yes — complete solutions from 3D design and visualisation through to build, installation and dismantling at any Dubai venue.'],
      ['q'=>'Which exhibition venues in Dubai do you service?',
       'a'=>'We build at DWTC, ADNEC, Dubai Expo City, Sharjah Expo Centre and all other UAE exhibition venues.'],
      ['q'=>'How far in advance should I book an exhibition stand?',
       'a'=>'4–6 weeks for bespoke stands; 2–3 weeks for modular. Urgent 1-week builds available for shell scheme upgrades.'],
      ['q'=>'Do you handle logistics and post-show storage?',
       'a'=>'Yes — we deliver, install, dismantle, and store stand components for your next show.'],
    ],
  ],
  'banners-printing' => [
    'tagline' => 'PVC vinyl banners, mesh banners & same-day banner printing in Dubai — outdoor, indoor, custom size, fast turnaround for events & advertising.',
    'specs'   => [
      ['icon'=>'fa-scroll',       'label'=>'Types',      'val'=>'PVC vinyl, mesh, scrim, blockout'],
      ['icon'=>'fa-ruler-combined','label'=>'Sizes',     'val'=>'Custom — 0.5m to 50m wide'],
      ['icon'=>'fa-palette',      'label'=>'Print',      'val'=>'UV / solvent digital, 1440 dpi'],
      ['icon'=>'fa-bolt',         'label'=>'Turnaround', 'val'=>'Same-day / 24-hour available'],
      ['icon'=>'fa-screwdriver-wrench','label'=>'Finish','val'=>'Eyelets, hemmed, pole pockets, rope'],
      ['icon'=>'fa-truck-fast',   'label'=>'Delivery',   'val'=>'Free delivery in Dubai, all UAE'],
    ],
    'pricing' => [
      ['size'=>'PVC Banner 1×3m',       'mat'=>'440gsm blockout vinyl',   'price'=>'AED 55 – 90'],
      ['size'=>'Mesh Banner 2×4m',      'mat'=>'PVC mesh (outdoor)',      'price'=>'AED 85 – 145'],
      ['size'=>'Premium Scrim 1×5m',    'mat'=>'550gsm scrim vinyl',     'price'=>'AED 95 – 165'],
      ['size'=>'Event Banner 1×10m',    'mat'=>'440gsm, hemmed + eyelets','price'=>'AED 175 – 280'],
    ],
    'faq' => [
      ['q'=>'What is the difference between PVC vinyl and mesh banners?',
       'a'=>'PVC vinyl banners are solid and block wind — ideal for walls. Mesh banners are perforated, allowing wind through, best for fencing and scaffolding.'],
      ['q'=>'Can I get same-day banner printing in Dubai?',
       'a'=>'Yes — standard PVC banners available for same-day collection if artwork submitted before 10am.'],
      ['q'=>'What is the maximum banner size you can print?',
       'a'=>'We print up to 5 metres wide in one piece. Sections can be joined for larger installations.'],
      ['q'=>'Do your banners include eyelets and hemming?',
       'a'=>'Yes — welded hems and brass eyelets every 50cm as standard. Pole pockets available on request.'],
    ],
  ],
];

$_ea_default = [
  'tagline' => 'Professional printing & advertising solutions in Dubai, UAE — quality in-house production, fast turnaround, free design support.',
  'specs'   => [
    ['icon'=>'fa-print',          'label'=>'Service',    'val'=>'In-house digital printing'],
    ['icon'=>'fa-ruler-combined', 'label'=>'Sizes',      'val'=>'Standard & custom sizes'],
    ['icon'=>'fa-palette',        'label'=>'Print',      'val'=>'Full colour CMYK digital'],
    ['icon'=>'fa-bolt',           'label'=>'Turnaround', 'val'=>'Same-day to 5 working days'],
    ['icon'=>'fa-screwdriver-wrench','label'=>'Finish',  'val'=>'Varies by product'],
    ['icon'=>'fa-truck-fast',     'label'=>'Delivery',   'val'=>'All UAE emirates'],
  ],
  'pricing' => [
    ['size'=>'Small Format',  'mat'=>'Standard material', 'price'=>'From AED 25'],
    ['size'=>'Medium Format', 'mat'=>'Standard material', 'price'=>'From AED 55'],
    ['size'=>'Large Format',  'mat'=>'Standard material', 'price'=>'From AED 95'],
    ['size'=>'Custom / Bulk', 'mat'=>'Any material',      'price'=>'Request Quote'],
  ],
  'faq' => [
    ['q'=>'How quickly can you print my order in Dubai?',
     'a'=>'Most orders ready in 1–3 working days. Same-day and next-day options available for urgent jobs.'],
    ['q'=>'Do you provide free design or artwork support?',
     'a'=>'Yes — our in-house design team prepares and adjusts artwork at no extra charge on every order.'],
    ['q'=>'What is the minimum order quantity?',
     'a'=>'Minimums vary by product. Many items print from 1 piece. Contact us for your specific product.'],
    ['q'=>'Do you deliver across the UAE?',
     'a'=>'Yes — Dubai, Abu Dhabi, Sharjah, Ajman, Fujairah, Ras Al Khaimah and all UAE locations.'],
  ],
];

get_header();
?>
<!-- PRELOADER -->
<div id="v9-pre">
  <div class="pre-inner">
    <div class="pre-ring"></div>
    <span class="pre-name">Efficient Advertising</span>
  </div>
</div>
<style>
#v9-pre { position: fixed; inset: 0; z-index: 99999; background: #1A1A2E; display: flex; align-items: center; justify-content: center; transition: opacity .5s ease, visibility .5s ease; }
#v9-pre.gone { opacity: 0; visibility: hidden; pointer-events: none; }
.pre-inner { text-align: center; }
.pre-ring { width: 44px; height: 44px; border-radius: 50%; border: 3px solid rgba(255,186,9,0.20); border-top-color: #FFBA09; animation: sp-spin .7s linear infinite; margin: 0 auto 18px; }
@keyframes sp-spin { to { transform: rotate(360deg); } }
.pre-name { font-family: 'Gotham',sans-serif; font-size: 10px; font-weight: 500; letter-spacing: 3px; color: rgba(255,255,255,0.32); text-transform: uppercase; }
</style>
<script>window.addEventListener('load',function(){ var p=document.getElementById('v9-pre'); if(p) setTimeout(function(){ p.classList.add('gone'); },200); });</script>

<main class="sp-page">
<?php
while ( have_posts() ) : the_post();

  $sp_id    = get_the_ID();
  $sp_title = get_the_title();
  $sp_url   = get_permalink();
  $wa_num   = '971527966265';

  $sp_terms    = get_the_terms( $sp_id, 'product_category' );
  $sp_cat_slug = '';
  $sp_cat_name = 'Products';
  $sp_cat_url  = home_url( '/shop/' );
  if ( $sp_terms && ! is_wp_error( $sp_terms ) ) {
    $sp_cat      = reset( $sp_terms );
    $sp_cat_slug = $sp_cat->slug;
    $sp_cat_name = $sp_cat->name;
    $sp_cat_url  = get_term_link( $sp_cat );
  }

  $cfg     = isset( $_ea_cats[ $sp_cat_slug ] ) ? $_ea_cats[ $sp_cat_slug ] : $_ea_default;
  $tagline = $cfg['tagline'];
  $specs   = $cfg['specs'];
  $pricing = $cfg['pricing'];
  $faqs    = $cfg['faq'];

  $gallery  = [];
  $thumb_id = get_post_thumbnail_id( $sp_id );
  if ( $thumb_id ) {
    $s = wp_get_attachment_image_src( $thumb_id, 'large' );
    if ( $s ) $gallery[] = [ 'url' => $s[0], 'alt' => esc_attr( $sp_title . ' — Efficient Advertising Dubai' ) ];
  }
  foreach ( [ 'product_image_one', 'product_image_two', 'product_image_three' ] as $fi => $fld ) {
    $val = get_post_meta( $sp_id, $fld, true );
    if ( ! $val ) continue;
    if ( is_numeric( $val ) ) {
      $s = wp_get_attachment_image_src( (int) $val, 'large' );
      if ( $s ) $gallery[] = [ 'url' => $s[0], 'alt' => esc_attr( $sp_title . ' view ' . ( $fi + 2 ) ) ];
    } elseif ( filter_var( $val, FILTER_VALIDATE_URL ) ) {
      $gallery[] = [ 'url' => esc_url( $val ), 'alt' => esc_attr( $sp_title . ' view ' . ( $fi + 2 ) ) ];
    }
  }

  $sp_cat_ids    = wp_get_object_terms( $sp_id, 'product_category', [ 'fields' => 'ids' ] );
  $related_query = new WP_Query( [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => 4,
    'orderby'        => 'rand',
    'tax_query'      => [ [ 'taxonomy' => 'product_category', 'field' => 'id', 'terms' => $sp_cat_ids ] ],
    'post__not_in'   => [ $sp_id ],
  ] );
?>

<script type="application/ld+json">
[{"@context":"https://schema.org","@type":"Product",
  "name":"<?php echo esc_js( $sp_title ); ?> Dubai",
  "url":"<?php echo esc_url( $sp_url ); ?>",
  <?php if ( ! empty( $gallery ) ) : ?>"image":"<?php echo esc_url( $gallery[0]['url'] ); ?>",<?php endif; ?>
  "description":"<?php echo esc_js( substr( wp_strip_all_tags( get_the_excerpt() ?: $tagline ), 0, 300 ) ); ?>",
  "brand":{"@type":"Brand","name":"Efficient Advertising LLC"},
  "offers":{"@type":"Offer","priceCurrency":"AED","availability":"https://schema.org/InStock","url":"<?php echo esc_url( $sp_url ); ?>","seller":{"@type":"Organization","name":"Efficient Advertising LLC"}}
},
{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[
  {"@type":"ListItem","position":1,"name":"Home","item":"<?php echo esc_url( home_url( '/' ) ); ?>"},
  {"@type":"ListItem","position":2,"name":"<?php echo esc_js( $sp_cat_name ); ?>","item":"<?php echo esc_url( $sp_cat_url ); ?>"},
  {"@type":"ListItem","position":3,"name":"<?php echo esc_js( $sp_title ); ?>"}
]},
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
  <?php foreach ( $faqs as $fi => $faq ) : ?>
  {"@type":"Question","name":"<?php echo esc_js( $faq['q'] ); ?>","acceptedAnswer":{"@type":"Answer","text":"<?php echo esc_js( wp_strip_all_tags( $faq['a'] ) ); ?>"}}<?php echo ( $fi < count( $faqs ) - 1 ) ? ',' : ''; ?>
  <?php endforeach; ?>
]}]
</script>

<!-- BREADCRUMB BAR -->
<section id="ea-pg-breadcrumb">
  <div class="container">
    <ol class="ea-breadcrumb" aria-label="Breadcrumb">
      <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">›</span></li>
      <li><a href="<?php echo esc_url( $sp_cat_url ); ?>"><?php echo esc_html( $sp_cat_name ); ?></a><span class="sep">›</span></li>
      <li class="active" aria-current="page"><?php echo esc_html( $sp_title ); ?></li>
    </ol>
  </div>
</section>

<!-- PRODUCT HERO -->
<section id="ea-pg-hero">
  <div class="container">
    <div class="ea-pg-hero-grid">

      <!-- LEFT: Image Gallery -->
      <div class="ea-pg-gallery">
        <div class="ea-pg-main-img" id="eaPgMainImg">
          <?php if ( ! empty( $gallery ) ) : ?>
          <img src="<?php echo esc_url( $gallery[0]['url'] ); ?>" alt="<?php echo esc_attr( $sp_title . ' — Efficient Advertising Dubai' ); ?>" id="eaPgMainImgEl" loading="eager">
          <?php else : ?>
          <img src="<?php echo get_template_directory_uri(); ?>/images/placeholder.jpg" alt="<?php echo esc_attr( $sp_title ); ?>" id="eaPgMainImgEl" loading="eager">
          <?php endif; ?>
          <button class="ea-pg-zoom-btn" id="eaZoomBtn" aria-label="Zoom image">
            <svg viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.72)" stroke-width="2" width="16" height="16"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/><path d="M8 11h6M11 8v6" stroke-linecap="round"/></svg>
          </button>
        </div>
        <?php if ( count( $gallery ) > 1 ) : ?>
        <div class="ea-pg-thumbs">
          <?php foreach ( $gallery as $gi => $img ) : ?>
          <div class="ea-pg-thumb<?php echo $gi === 0 ? ' active' : ''; ?>" data-src="<?php echo esc_url( $img['url'] ); ?>">
            <img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo esc_attr( $img['alt'] ); ?>" loading="lazy">
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <!-- RIGHT: Product Info + Config -->
      <div class="ea-pg-info">
        <span class="ea-pg-category-pill"><?php echo esc_html( $sp_cat_name ); ?></span>
        <h1 class="ea-pg-title"><?php echo esc_html( $sp_title ); ?> Dubai, UAE</h1>
        <p class="ea-pg-short-desc"><?php echo esc_html( $tagline ); ?></p>

        <!-- Quick spec badge pills -->
        <div class="ea-pg-spec-badges">
          <?php foreach ( array_slice( $specs, 0, 4 ) as $badge ) : ?>
          <div class="ea-pg-badge">
            <div>
              <span class="ea-pg-badge-label"><?php echo esc_html( $badge['label'] ); ?></span>
              <span class="ea-pg-badge-value"><?php echo esc_html( $badge['val'] ); ?></span>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Variant Config Panel -->
        <div class="ea-pg-config">
          <div class="ea-pg-config-title">Configure Your Order</div>
          <div class="ea-pg-option-group">
            <div class="ea-pg-option-label">Size / Format &nbsp;<span id="eaSelectedSize"><?php echo esc_html( $pricing[0]['size'] ); ?></span></div>
            <div class="ea-pg-option-btns" id="eaSizeGroup">
              <?php foreach ( $pricing as $pi => $row ) : ?>
              <button class="ea-pg-opt-btn<?php echo $pi === 0 ? ' selected' : ''; ?>" data-group="size" data-val="<?php echo esc_attr( $row['size'] ); ?>"><?php echo esc_html( $row['size'] ); ?></button>
              <?php endforeach; ?>
            </div>
          </div>
          <?php
            $finishes = [];
            foreach ( $specs as $s ) {
              if ( strtolower($s['label']) === 'finish' || strtolower($s['label']) === 'materials' ) {
                $parts = preg_split('/[,\/]/', $s['val']);
                foreach ($parts as $p) {
                  $f = trim($p);
                  if ($f) $finishes[] = $f;
                }
                break;
              }
            }
            if ( empty($finishes) ) $finishes = ['Standard', 'Custom'];
          ?>
          <div class="ea-pg-option-group">
            <div class="ea-pg-option-label">Finish &nbsp;<span id="eaSelectedFinish"><?php echo esc_html( $finishes[0] ); ?></span></div>
            <div class="ea-pg-option-btns" id="eaFinishGroup">
              <?php foreach ( $finishes as $fi => $f ) : ?>
              <button class="ea-pg-opt-btn<?php echo $fi === 0 ? ' selected' : ''; ?>" data-group="finish" data-val="<?php echo esc_attr( $f ); ?>"><?php echo esc_html( $f ); ?></button>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="ea-pg-qty-row">
            <span class="ea-pg-qty-label">Qty</span>
            <div class="ea-pg-qty-wrap">
              <button class="ea-pg-qty-btn" id="eaQtyDown" aria-label="Decrease quantity">−</button>
              <input type="number" class="ea-pg-qty-num" id="eaQtyNum" value="1" min="1" max="9999" aria-label="Quantity">
              <button class="ea-pg-qty-btn" id="eaQtyUp" aria-label="Increase quantity">+</button>
            </div>
          </div>
        </div>

        <!-- CTA Buttons -->
        <div class="ea-pg-cta-row">
          <button type="button" class="btn-amber-solid" onclick="document.getElementById('orderModal').style.display='flex'">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
            Get a Quote
          </button>
          <a href="#sp-artwork" class="btn-outline-amber">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3"/></svg>
            Upload Artwork
          </a>
        </div>

        <!-- WhatsApp quick link -->
        <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I need a quote for: ' . $sp_title . ' in Dubai' ); ?>" target="_blank" rel="noopener" class="ea-pg-wa-link">
          <svg width="17" height="17" viewBox="0 0 32 32" fill="currentColor"><path d="M16 0C7.164 0 0 7.163 0 16c0 2.822.736 5.463 2.018 7.761L0 32l8.533-2.236A15.93 15.93 0 0 0 16 32c8.836 0 16-7.163 16-16S24.836 0 16 0zm8.293 22.293c-.343.963-1.998 1.84-2.733 1.957-.698.11-1.58.157-2.547-.16-.587-.193-1.34-.45-2.297-.882-4.047-1.748-6.688-5.818-6.888-6.087-.197-.27-1.613-2.145-1.613-4.09 0-1.944 1.02-2.9 1.38-3.297.343-.38.748-.476 1-.476.25 0 .499.003.717.013.23.01.54-.088.844.644.314.75 1.066 2.598 1.16 2.786.094.19.156.41.03.66-.125.25-.188.406-.375.625-.188.22-.395.49-.563.658-.188.188-.383.39-.165.766.22.375.977 1.613 2.098 2.61 1.44 1.285 2.656 1.685 3.031 1.875.375.188.594.157.813-.094.22-.25.938-1.094 1.188-1.469.25-.375.5-.312.844-.187.344.125 2.188 1.031 2.563 1.219.375.188.625.281.719.438.094.156.094.906-.25 1.87z"/></svg>
          Quick enquiry via WhatsApp
        </a>

        <!-- Trust badges -->
        <div class="ea-pg-trust">
          <div class="ea-pg-trust-item"><div class="trust-ico"><svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div>Same-Day Available</div>
          <div class="ea-pg-trust-item"><div class="trust-ico"><svg viewBox="0 0 24 24"><path d="M1 3h15v13H1zM16 8l4 2v6h-4m-12 0a2 2 0 104 0 2 2 0 00-4 0m10 0a2 2 0 104 0 2 2 0 00-4 0"/></svg></div>Free UAE Delivery</div>
          <div class="ea-pg-trust-item"><div class="trust-ico"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>In-House Production</div>
          <div class="ea-pg-trust-item"><div class="trust-ico"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>18+ Years Experience</div>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="sp-trust-bar">
  <div class="container"><div class="sp-trust-grid">
    <div class="sp-trust-item"><i class="fa-solid fa-industry"></i><span>In-House Production</span></div>
    <div class="sp-trust-item"><i class="fa-solid fa-bolt"></i><span>Same-Day Available</span></div>
    <div class="sp-trust-item"><i class="fa-solid fa-pen-ruler"></i><span>Free Design Support</span></div>
    <div class="sp-trust-item"><i class="fa-solid fa-award"></i><span>18+ Years Experience</span></div>
  </div></div>
</section>



<section class="sp-specs-section">
  <div class="container">
    <div class="sp-sec-hdr"><h2><?php echo esc_html( $sp_title ); ?> — Specifications &amp; Options</h2><p>Technical details for your <?php echo esc_html( strtolower( $sp_title ) ); ?> from Efficient Advertising Dubai.</p></div>
    <div class="sp-specs-grid">
      <?php foreach ( $specs as $spec ) : ?>
      <div class="sp-spec-card">
        <div class="sp-spec-icon-wrap"><i class="fa-solid <?php echo esc_attr( $spec['icon'] ); ?>"></i></div>
        <div class="sp-spec-label"><?php echo esc_html( $spec['label'] ); ?></div>
        <div class="sp-spec-val"><?php echo esc_html( $spec['val'] ); ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="sp-pricing-section">
  <div class="container">
    <div class="sp-sec-hdr"><h2>Get a Quote — <?php echo esc_html( $sp_title ); ?> Dubai</h2><p>Every job is custom. Send us your size, quantity &amp; material and we'll reply within the hour.</p></div>
    <div class="sp-pricing-wrap">
      <table class="sp-pricing-tbl">
        <thead><tr><th>Size / Product</th><th>Material / Spec</th><th>Pricing</th><th>Get Quote</th></tr></thead>
        <tbody>
          <?php foreach ( $pricing as $row ) : ?>
          <tr>
            <td><?php echo esc_html( $row['size'] ); ?></td>
            <td><?php echo esc_html( $row['mat'] ); ?></td>
            <td><span class="sp-rq-badge">Request Quote</span></td>
            <td><a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I need a quote for: ' . $sp_title . ' — ' . $row['size'] ); ?>" class="sp-price-wa" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> Quote</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p class="sp-pricing-note"><i class="fa-solid fa-circle-info"></i> All prices exclude 5% VAT. Bulk discounts available. Call <a href="tel:+97142711048">+971 4 271 1048</a> or <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>" target="_blank" rel="noopener">WhatsApp +971 52 796 6265</a> for a customised quote.</p>
  </div>
</section>

<section class="sp-why-section">
  <div class="container">
    <div class="sp-sec-hdr"><h2>Why Choose Efficient Advertising?</h2><p>Dubai&rsquo;s trusted printing &amp; branding partner for over 18 years — quality, speed and reliability.</p></div>
    <div class="sp-why-grid">
      <div class="sp-why-card"><div class="sp-why-icon"><i class="fa-solid fa-industry"></i></div><h3>In-House Production</h3><p>We own and operate our printing facility in Dubai — no outsourcing, full quality control, faster turnaround on every order.</p></div>
      <div class="sp-why-card"><div class="sp-why-icon"><i class="fa-solid fa-bolt"></i></div><h3>Same-Day &amp; Express</h3><p>Urgent order? Same-day and next-day printing available on most products. WhatsApp before 10am for same-day collection.</p></div>
      <div class="sp-why-card"><div class="sp-why-icon"><i class="fa-solid fa-pen-ruler"></i></div><h3>Free Design Support</h3><p>Our in-house design team prepares, adjusts and finalises your artwork at no extra charge — every print looks exactly right.</p></div>
      <div class="sp-why-card"><div class="sp-why-icon"><i class="fa-solid fa-truck-fast"></i></div><h3>UAE-Wide Delivery</h3><p>Fast delivery to all UAE emirates: Dubai, Abu Dhabi, Sharjah, Ajman, Fujairah, Ras Al Khaimah and more.</p></div>
    </div>
  </div>
</section>

</section>

<!-- REVIEWS -->
<section class="reviews">
  <div class="container">
    <div class="reviewshadow">
      <div class="row pb-30 text-center">
        <div class="col-sm-8 mx-auto col-lg-6">
          <div class="creative_heading">
            <h2><?php echo get_field('Google Reviews') ?: ""; ?></h2>
          </div>
          <br>
        </div>
      </div>
      <div class="row">
        <div class="col-12 text-center">
          <?php echo do_shortcode('[trustindex no-registration=google]'); ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ARTWORK SECTION -->
<section id="sp-artwork" style="background:var(--bg-dark); padding:80px 0;">
  <div class="container">
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:60px; align-items:center;">
      <div>
        <div class="sec-label">Ordering Process</div>
        <h2 style="font-size:36px; margin-bottom:20px;">Ready to Print?</h2>
        <p style="color:var(--tx-muted); margin-bottom:30px;">Follow these simple steps to get your project moving. Our team handles everything from design checks to final delivery.</p>
        
        <div style="display:flex; flex-direction:column; gap:20px;">
          <div style="display:flex; gap:15px;">
            <div style="width:32px; height:32px; background:var(--amber); border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:800; flex-shrink:0;">1</div>
            <div><strong>Upload Artwork:</strong> Send us your files via WhatsApp or Email.</div>
          </div>
          <div style="display:flex; gap:15px;">
            <div style="width:32px; height:32px; background:var(--amber); border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:800; flex-shrink:0;">2</div>
            <div><strong>Design Approval:</strong> We'll send you a digital proof for review.</div>
          </div>
          <div style="display:flex; gap:15px;">
            <div style="width:32px; height:32px; background:var(--amber); border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:800; flex-shrink:0;">3</div>
            <div><strong>Production:</strong> Once approved, we print and install.</div>
          </div>
        </div>
      </div>
      <div style="background:#fff; padding:40px; border-radius:var(--r-md); border:1.5px dashed var(--amber-ring);">
        <h3 style="margin-bottom:15px;">Submit Your Artwork</h3>
        <p style="font-size:14px; color:var(--tx-muted); margin-bottom:25px;">PDF, AI, or High-Res JPG preferred (minimum 150dpi).</p>
        <div class="sp-artwork-actions">
           <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I want to send artwork for: ' . $sp_title ); ?>" class="sp-btn-art-wa" target="_blank" rel="noopener">
             <i class="fa-brands fa-whatsapp"></i> Send via WhatsApp
           </a>
           <a href="mailto:info@efficientadvt.com?subject=Artwork for <?php echo esc_attr($sp_title); ?>" class="sp-btn-art-email">
             <i class="fa-solid fa-envelope"></i> Email Artwork
           </a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="sp-cta-section">
  <div class="container"><div class="sp-cta-inner">
    <div class="sp-cta-text"><h2>Ready to order <?php echo esc_html( $sp_title ); ?> in Dubai?</h2><p>Free quote within hours. Same-day production available. Our Dubai team is ready.</p></div>
    <div class="sp-cta-btns">
      <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I need a quote for: ' . $sp_title . ' in Dubai' ); ?>" class="sp-btn-wa sp-btn-lg" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> WhatsApp Us Now</a>
      <button type="button" class="sp-btn-quote sp-btn-lg" onclick="document.getElementById('orderModal').style.display='flex'"><i class="fa-solid fa-envelope"></i> Request a Quote</button>
    </div>
  </div></div>
</section>

<?php if ( get_the_content() ) : ?>
<section class="sp-seo-section"><div class="container"><div class="sp-seo-content"><?php the_content(); ?></div></div></section>
<?php endif; ?>

<?php endwhile; ?>

<?php if ( isset( $related_query ) && $related_query->have_posts() ) : ?>
<section class="sp-related-section">
  <div class="container">
    <div class="sp-sec-hdr"><h2>Related Products</h2><p>You might also be interested in these products from Efficient Advertising Dubai.</p></div>
    <div class="sp-related-grid">
      <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
      <a href="<?php the_permalink(); ?>" class="sp-related-card">
        <div class="sp-related-img"><?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'medium', [ 'alt' => get_the_title() . ' Dubai', 'loading' => 'lazy' ] ); else : ?><div class="sp-related-placeholder"><i class="fa-solid fa-image"></i></div><?php endif; ?></div>
        <div class="sp-related-name"><?php the_title(); ?></div>
        <div class="sp-related-link">View Details <i class="fa-solid fa-arrow-right"></i></div>
      </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

</main>

<div id="spLightbox" class="sp-lightbox" style="display:none" onclick="this.style.display='none'">
  <button class="sp-lb-close" onclick="event.stopPropagation();document.getElementById('spLightbox').style.display='none'" aria-label="Close"><i class="fa-solid fa-times"></i></button>
  <img id="spLightboxImg" src="" alt="Product image">
</div>

<div class="ea-modal-overlay" id="orderModal" style="display:none">
  <div class="ea-modal-box">
    <div class="ea-modal-header">
      <h3><i class="fa-solid fa-file-signature"></i> Get a Free Quote</h3>
      <button class="ea-modal-close" onclick="document.getElementById('orderModal').style.display='none'" aria-label="Close"><i class="fa-solid fa-times"></i></button>
    </div>
    <div class="ea-modal-body">
      <form class="ea-quote-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="submit_product_order">
        <?php wp_nonce_field( 'product_order_nonce', 'order_nonce' ); ?>
        <input type="hidden" name="product_name" value="<?php echo esc_attr( get_the_title() ); ?>">
        <div class="ea-form-row">
          <div class="ea-form-group"><label for="oName">Full Name *</label><input type="text" id="oName" name="order_name" required placeholder="Your full name"></div>
          <div class="ea-form-group"><label for="oEmail">Email *</label><input type="email" id="oEmail" name="order_email" required placeholder="your@email.com"></div>
        </div>
        <div class="ea-form-row">
          <div class="ea-form-group"><label for="oPhone">Phone / WhatsApp *</label><input type="tel" id="oPhone" name="order_phone" required placeholder="+971 50 123 4567"></div>
          <div class="ea-form-group"><label for="oCo">Company</label><input type="text" id="oCo" name="order_company" placeholder="Your company"></div>
        </div>
        <div class="ea-form-group"><label for="oMsg">Requirements</label><textarea id="oMsg" name="order_message" rows="4" placeholder="Size, quantity, material, deadline..."></textarea></div>
        <button type="submit" class="ea-form-submit"><i class="fa-solid fa-paper-plane"></i> Send Quote Request</button>
      </form>
    </div>
  </div>
</div>


<script>
/* Gallery thumb swap for new ea-pg-thumb system */
function spSwapImg(el,url){document.getElementById('spMainImg').src=url;document.querySelectorAll('.sp-thumb-item').forEach(function(t){t.classList.remove('active');});el.classList.add('active');}
/* New hero gallery */
(function(){
  document.querySelectorAll('.ea-pg-thumb').forEach(function(t){
    t.addEventListener('click',function(){
      var src=t.getAttribute('data-src');
      var main=document.getElementById('eaPgMainImgEl');
      if(main && src){ main.src=src; }
      document.querySelectorAll('.ea-pg-thumb').forEach(function(x){x.classList.remove('active');});
      t.classList.add('active');
    });
  });
  /* Zoom */
  var zBtn=document.getElementById('eaZoomBtn');
  if(zBtn){
    zBtn.addEventListener('click',function(e){
      e.stopPropagation();
      var mi=document.getElementById('eaPgMainImgEl');
      var lb=document.getElementById('spLightbox');
      var li=document.getElementById('spLightboxImg');
      if(mi && lb && li){ li.src=mi.src; li.alt=mi.alt; lb.style.display='flex'; }
    });
  }
  /* Main image click zoom */
  var mw=document.getElementById('eaPgMainImg');
  if(mw){
    mw.addEventListener('click',function(){
      var mi=document.getElementById('eaPgMainImgEl');
      var lb=document.getElementById('spLightbox');
      var li=document.getElementById('spLightboxImg');
      if(mi && lb && li){ li.src=mi.src; li.alt=mi.alt; lb.style.display='flex'; }
    });
  }
  /* Qty stepper */
  var qUp=document.getElementById('eaQtyUp');
  var qDn=document.getElementById('eaQtyDown');
  var qNum=document.getElementById('eaQtyNum');
  if(qUp && qDn && qNum){
    qUp.addEventListener('click',function(){ var v=parseInt(qNum.value)||1; qNum.value=Math.min(v+1,9999); });
    qDn.addEventListener('click',function(){ var v=parseInt(qNum.value)||1; qNum.value=Math.max(v-1,1); });
  }
  /* Variant option buttons */
  document.querySelectorAll('.ea-pg-opt-btn').forEach(function(btn){
    btn.addEventListener('click',function(){
      var grp=btn.getAttribute('data-group');
      var val=btn.getAttribute('data-val');
      document.querySelectorAll('[data-group="'+grp+'"]').forEach(function(b){b.classList.remove('selected');});
      btn.classList.add('selected');
      if(grp==='size'){ var el=document.getElementById('eaSelectedSize'); if(el) el.textContent=val; }
      if(grp==='finish'){ var el2=document.getElementById('eaSelectedFinish'); if(el2) el2.textContent=val; }
    });
  });
})();
(function(){
  var mi=document.getElementById('spMainImg');
  if(mi){mi.addEventListener('click',function(){var lb=document.getElementById('spLightbox');var li=document.getElementById('spLightboxImg');li.src=mi.src;li.alt=mi.alt;lb.style.display='flex';});}
  document.addEventListener('click',function(e){if(e.target&&e.target.id==='orderModal')e.target.style.display='none';});
  document.addEventListener('keydown',function(e){if(e.key==='Escape'){var m=document.getElementById('orderModal');var l=document.getElementById('spLightbox');if(m)m.style.display='none';if(l)l.style.display='none';}});
})();
</script>

<!-- STICKY MOBILE CTA BAR -->
<div class="ea-sticky-bar">
  <a href="tel:+97142711048" class="ea-sticky-btn ea-sticky-call">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012 .19h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
    Call
  </a>
  <a href="https://wa.me/<?php echo esc_attr( isset($wa_num) ? $wa_num : '971527966265' ); ?>" target="_blank" rel="noopener" class="ea-sticky-btn ea-sticky-wa">
    <svg width="18" height="18" viewBox="0 0 32 32" fill="currentColor"><path d="M16 0C7.164 0 0 7.163 0 16c0 2.822.736 5.463 2.018 7.761L0 32l8.533-2.236A15.93 15.93 0 0 0 16 32c8.836 0 16-7.163 16-16S24.836 0 16 0zm8.293 22.293c-.343.963-1.998 1.84-2.733 1.957-.698.11-1.58.157-2.547-.16-.587-.193-1.34-.45-2.297-.882-4.047-1.748-6.688-5.818-6.888-6.087-.197-.27-1.613-2.145-1.613-4.09 0-1.944 1.02-2.9 1.38-3.297.343-.38.748-.476 1-.476.25 0 .499.003.717.013.23.01.54-.088.844.644.314.75 1.066 2.598 1.16 2.786.094.19.156.41.03.66-.125.25-.188.406-.375.625-.188.22-.395.49-.563.658-.188.188-.383.39-.165.766.22.375.977 1.613 2.098 2.61 1.44 1.285 2.656 1.685 3.031 1.875.375.188.594.157.813-.094.22-.25.938-1.094 1.188-1.469.25-.375.5-.312.844-.187.344.125 2.188 1.031 2.563 1.219.375.188.625.281.719.438.094.156.094.906-.25 1.87z"/></svg>
    WhatsApp
  </a>
  <button type="button" class="ea-sticky-btn ea-sticky-quote" onclick="document.getElementById('orderModal').style.display='flex'">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
    Quote
  </button>
</div>

<?php get_footer(); ?>