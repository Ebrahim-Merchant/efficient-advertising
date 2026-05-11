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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=Unbounded:wght@400;500;600;700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">

<style>
:root {
  --bg:#F7F5F0; --bg-dark:#EDE9DF; --bg-card:#FFFFFF;
  --bg-dark1:#1A1A2E; --bg-dark2:#0F0F1E; --bg-dark3:#0A0A14;
  --amber:#FFC107; --amber-dk:#FFB300; --amber-pale:rgba(255,193,7,0.1);
  --amber-ring:rgba(255,193,7,0.40);
  --tx:#1A1A2E; --tx-2:#374151; --tx-muted:#64748B;
  --tx-light:#FFFFFF;
  --green:#16A34A; --border:rgba(26,26,46,0.10);
  --shadow-sm:0 2px 14px rgba(26,26,46,0.07);
  --shadow-md:0 6px 32px rgba(26,26,46,0.12);
  --r-sm:10px; --r-md:20px; --r-lg:28px; --r-pill:100px;
  --cream:#F7F5F0; --navy:#1A1A2E;
}
.sp-page { font-family:'DM Sans',sans-serif; background:var(--bg); color:var(--tx); line-height:1.65; overflow-x:hidden; margin-top:100px; }
.sp-page h1, .sp-page h2, .sp-page h3 { font-family:'Syne',sans-serif; font-weight: 800 !important; }
.sec-label { font-family:'Unbounded',sans-serif; font-size:10px; font-weight:700; letter-spacing:2.2px; text-transform:uppercase; color:var(--tx); background:var(--amber-pale); border:1.5px solid var(--amber-ring); padding:7px 18px; border-radius:var(--r-pill); display:inline-block; margin-bottom:22px; }

/* HERO CTAs */
.sp-hero-ctas { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 30px; }
.sp-hero-ctas a, .sp-hero-ctas button { 
    flex: 1; min-width: 140px; height: 48px; 
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    border-radius: var(--r-sm); font-size: 14px; font-weight: 700; cursor: pointer;
    transition: all 0.2s; text-decoration: none; border: none;
}
.sp-btn-wa { background: var(--green) !important; color: #fff !important; }
.sp-btn-wa:hover { background: #15803d !important; transform: translateY(-2px); }
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
.sp-panel-cta:hover { background: #15803d; }

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

/* PREMIUM VISUAL VARIANT PILL CONTAINER */
.sp-variant-container {
  background: rgba(26, 26, 46, 0.04);
  border: 1px solid rgba(26, 26, 46, 0.08);
  border-radius: var(--r-sm);
  padding: 18px 22px;
  margin: 25px 0;
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
}
.sp-variant-hdr {
  font-family: 'Unbounded', sans-serif;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--tx-muted);
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.sp-variant-hdr i {
  color: var(--amber);
  font-size: 12px;
}
.sp-variant-pills {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}
.sp-variant-pill {
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  font-weight: 700;
  color: var(--tx);
  background: #fff;
  border: 1.5px solid var(--border);
  padding: 8px 16px;
  border-radius: var(--r-pill);
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  display: inline-flex;
  align-items: center;
  gap: 6px;
  user-select: none;
}
.sp-variant-pill:hover {
  border-color: var(--amber);
  background: var(--amber-pale);
  transform: translateY(-1.5px);
  box-shadow: 0 4px 12px rgba(255, 186, 9, 0.15);
}
.sp-variant-pill i {
  color: var(--amber-dk);
  font-size: 11px;
}
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

  $sp_excerpt_raw = trim( wp_strip_all_tags( get_the_excerpt() ) );
  if ( empty( $sp_excerpt_raw ) ) {
    $sp_excerpt_raw = trim( wp_strip_all_tags( $tagline ) );
  }
  $sp_intro = wp_trim_words( $sp_excerpt_raw, 32, '...' );

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
  "description":"<?php echo esc_js( substr( wp_strip_all_tags( $sp_intro ), 0, 300 ) ); ?>",
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

<section class="sp-hero">
  <div class="container">
    <div class="sp-hero-inner">
      <div class="sp-hero-left">
        <nav class="sp-breadcrumb" aria-label="Breadcrumb">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span>/</span>
          <a href="<?php echo esc_url( $sp_cat_url ); ?>"><?php echo esc_html( $sp_cat_name ); ?></a><span>/</span>
          <span><?php echo esc_html( $sp_title ); ?></span>
        </nav>
        <h1 class="sp-hero-h1"><?php echo esc_html( $sp_title ); ?> Dubai, UAE</h1>
        <p class="sp-hero-tagline"><?php echo esc_html( $sp_intro ); ?></p>

        <!-- Automated Visual Variant Pill Container -->
        <?php
        $variants_to_display = [];
        $current_title = trim( html_entity_decode( $sp_title, ENT_QUOTES, 'UTF-8' ) );
        $excel_dump_file = ABSPATH . 'excel_dump.json';
        
        // 1. Check Excel taxonomy mapping (Tracking the last seen parent correctly)
        if ( file_exists( $excel_dump_file ) ) {
            $excel_rows = json_decode( file_get_contents( $excel_dump_file ), true );
            if ( is_array( $excel_rows ) ) {
                $current_title_lower = strtolower( $current_title );
                $last_seen_parent = '';
                foreach ( $excel_rows as $idx => $cols ) {
                    if ( isset( $cols['B'] ) && ! empty( $cols['B'] ) && $cols['B'] !== 'Product Name' ) {
                        $last_seen_parent = trim( $cols['B'] );
                    }
                    if ( strtolower( $last_seen_parent ) === $current_title_lower ) {
                        if ( isset( $cols['C'] ) && ! empty( $cols['C'] ) && $cols['C'] !== 'Variant' ) {
                            $variants_to_display[] = trim( $cols['C'] );
                        }
                    }
                }
            }
        }
        
        // 2. Fallback to WooCommerce variable attributes if applicable
        $wc_product = wc_get_product( $sp_id );
        if ( empty( $variants_to_display ) && $wc_product && $wc_product->is_type( 'variable' ) ) {
            $variation_ids = $wc_product->get_children();
            foreach ( $variation_ids as $var_id ) {
                $var_obj = wc_get_product( $var_id );
                if ( $var_obj ) {
                    $attr_desc = implode( ' / ', $var_obj->get_variation_attributes() );
                    if ( empty( $attr_desc ) ) {
                        $attr_name = str_replace( $sp_title . ' - ', '', $var_obj->get_name() );
                        if ( ! empty( $attr_name ) ) {
                            $variants_to_display[] = $attr_name;
                        }
                    } else {
                        $variants_to_display[] = $attr_desc;
                    }
                }
            }
        }
        
        // Render Container if we found variations
        if ( ! empty( $variants_to_display ) ) {
            // Remove duplicates
            $variants_to_display = array_unique( $variants_to_display );
            ?>
            <div class="sp-variant-container">
              <div class="sp-variant-hdr">
                <i class="fa-solid fa-layer-group"></i> Available Options &amp; Variants
              </div>
              <div class="sp-variant-pills">
                <?php foreach ( $variants_to_display as $variant_label ) : ?>
                  <span class="sp-variant-pill">
                    <i class="fa-solid fa-circle-check"></i> <?php echo esc_html( $variant_label ); ?>
                  </span>
                <?php endforeach; ?>
              </div>
            </div>
            <?php
        }
        ?>
        <div class="sp-hero-ctas">
          <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I need a quote for: ' . $sp_title . ' in Dubai' ); ?>" class="sp-btn-wa" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
          <button type="button" class="sp-btn-quote" onclick="document.getElementById('orderModal').style.display='flex'"><i class="fa-solid fa-file-invoice"></i> Get Quote</button>
          <a href="tel:+97142711048" class="sp-btn-call"><i class="fa-solid fa-phone"></i> Call Us</a>
        </div>
      </div>
      <div class="sp-hero-panel">
        <div class="sp-panel-title">Quick Specs</div>
        <?php foreach ( array_slice( $specs, 0, 4 ) as $spec ) : ?>
        <div class="sp-panel-row">
          <i class="fa-solid <?php echo esc_attr( $spec['icon'] ); ?>"></i>
          <div><span class="sp-panel-label"><?php echo esc_html( $spec['label'] ); ?></span><span class="sp-panel-val"><?php echo esc_html( $spec['val'] ); ?></span></div>
        </div>
        <?php endforeach; ?>
        <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I need a quote for: ' . $sp_title ); ?>" class="sp-panel-cta" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> Instant Quote</a>
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

<?php if ( ! empty( $gallery ) ) : ?>
<section class="sp-gallery-section">
  <div class="container"><div class="sp-gallery-wrap">
    <div class="sp-gallery-main-wrap">
      <img id="spMainImg" src="<?php echo esc_url( $gallery[0]['url'] ); ?>" alt="<?php echo $gallery[0]['alt']; ?>" loading="eager" class="sp-gallery-main-img">
    </div>
    <?php if ( count( $gallery ) > 1 ) : ?>
    <div class="sp-gallery-thumbs">
      <?php foreach ( $gallery as $gi => $img ) : ?>
      <div class="sp-thumb-item<?php echo $gi === 0 ? ' active' : ''; ?>" onclick="spSwapImg(this,'<?php echo esc_js( $img['url'] ); ?>')">
        <img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo $img['alt']; ?>" loading="lazy">
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div></div>
</section>
<?php endif; ?>

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
<section id="sp-reviews" style="background:#fff; padding:60px 0; border-top:1px solid var(--border);">
  <div class="container" style="text-align:center;">
    <div class="sec-label">Trusted by Thousands</div>
    <h2 style="font-size:32px; margin-bottom:40px;">What Our Clients Say</h2>
    <?php echo do_shortcode('[trustindex no-registration=google]'); ?>
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
function spSwapImg(el,url){document.getElementById('spMainImg').src=url;document.querySelectorAll('.sp-thumb-item').forEach(function(t){t.classList.remove('active');});el.classList.add('active');}
(function(){
  var mi=document.getElementById('spMainImg');
  if(mi){mi.addEventListener('click',function(){var lb=document.getElementById('spLightbox');var li=document.getElementById('spLightboxImg');li.src=mi.src;li.alt=mi.alt;lb.style.display='flex';});}
  document.addEventListener('click',function(e){if(e.target&&e.target.id==='orderModal')e.target.style.display='none';});
  document.addEventListener('keydown',function(e){if(e.key==='Escape'){var m=document.getElementById('orderModal');var l=document.getElementById('spLightbox');if(m)m.style.display='none';if(l)l.style.display='none';}});
})();
</script>

<?php get_footer(); ?>