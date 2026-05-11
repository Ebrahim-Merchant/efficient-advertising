<?php
/**
 * Single Product Template — 10-Section SEO Landing Page
 * Efficient Advertising LLC, Dubai, UAE  |  Rebuilt: 2026-03-14
 *
 * @package Efficient_Modern
 */
if ( ! defined( 'ABSPATH' ) ) exit;

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
        <p class="sp-hero-tagline"><?php echo esc_html( $tagline ); ?></p>
        <div class="sp-hero-ctas">
          <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I need a quote for: ' . $sp_title . ' in Dubai' ); ?>" class="sp-btn-wa" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> WhatsApp for Quote</a>
          <button type="button" class="sp-btn-quote" onclick="document.getElementById('orderModal').style.display='flex'"><i class="fa-solid fa-file-invoice"></i> Request a Quote</button>
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
        <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I need a quote for: ' . $sp_title ); ?>" class="sp-panel-cta" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> Get Instant Quote</a>
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

<section class="sp-faq-section">
  <div class="container">
    <div class="sp-sec-hdr"><h2>FAQs — <?php echo esc_html( $sp_title ); ?> in Dubai</h2><p>Common questions when ordering <?php echo esc_html( strtolower( $sp_title ) ); ?> from Efficient Advertising.</p></div>
    <div class="sp-faq-list">
      <?php foreach ( $faqs as $fi => $faq ) : ?>
      <details class="sp-faq-item"<?php echo $fi === 0 ? ' open' : ''; ?>>
        <summary class="sp-faq-q"><span><?php echo esc_html( $faq['q'] ); ?></span><i class="fa-solid fa-chevron-down sp-faq-icon"></i></summary>
        <div class="sp-faq-a"><p><?php echo wp_kses_post( $faq['a'] ); ?></p></div>
      </details>
      <?php endforeach; ?>
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

<style>
:root{--sp-primary:#8B1538;--sp-dark:#660f29;--sp-orange:#FF6B35;--sp-light:#f9fafb;--sp-border:#e5e7eb;--sp-text:#1f2937;--sp-muted:#6b7280;--sp-radius:10px;--sp-shadow:0 2px 12px rgba(0,0,0,.08);--sp-container:1440px}
.sp-page{background:#fff;width:100%}
.sp-page .container{max-width:var(--sp-container);width:100%;margin-left:auto;margin-right:auto;padding-left:20px;padding-right:20px}
.sp-sec-hdr{text-align:center;margin-bottom:2.5rem}
.sp-sec-hdr h2{font-size:clamp(1.5rem,3.5vw,2rem);color:var(--sp-primary);font-weight:800;margin:0 0 .5rem}
.sp-sec-hdr p{color:var(--sp-muted);font-size:1rem;max-width:620px;margin:0 auto}
.sp-hero{background:linear-gradient(135deg,#8B1538 0%,#5a0d20 60%,#3d0814 100%);padding:3.5rem 0 3rem;color:#fff}
.sp-hero-inner{display:grid;grid-template-columns:1fr 360px;gap:2rem;align-items:start}
.sp-breadcrumb{display:flex;gap:.4rem;align-items:center;font-size:.83rem;flex-wrap:wrap;margin-bottom:1rem}
.sp-breadcrumb a{color:rgba(255,255,255,.8);text-decoration:none}
.sp-breadcrumb a:hover{color:#fff;text-decoration:underline}
.sp-breadcrumb>span{color:rgba(255,255,255,.5)}
.sp-hero-h1{font-size:clamp(1.65rem,4vw,2.5rem);font-weight:800;line-height:1.2;margin:0 0 .75rem;color:#fff}
.sp-hero-tagline{font-size:1.05rem;color:rgba(255,255,255,.88);line-height:1.6;margin:0 0 1.75rem;max-width:540px}
.sp-hero-ctas{display:flex;flex-wrap:wrap;gap:.75rem}
.sp-btn-wa{display:inline-flex;align-items:center;gap:.5rem;background:#25D366;color:#fff;padding:.7rem 1.25rem;border-radius:7px;font-weight:700;font-size:.95rem;text-decoration:none;border:none;cursor:pointer;transition:background .2s}
.sp-btn-wa:hover{background:#1da855;color:#fff}
.sp-btn-quote{display:inline-flex;align-items:center;gap:.5rem;background:var(--sp-orange);color:#fff;padding:.7rem 1.25rem;border-radius:7px;font-weight:700;font-size:.95rem;border:none;cursor:pointer;transition:background .2s}
.sp-btn-quote:hover{background:#e55a25}
.sp-btn-call{display:inline-flex;align-items:center;gap:.5rem;background:rgba(255,255,255,.15);color:#fff;padding:.7rem 1.25rem;border-radius:7px;font-weight:700;font-size:.95rem;border:1px solid rgba(255,255,255,.4);text-decoration:none;transition:background .2s}
.sp-btn-call:hover{background:rgba(255,255,255,.25);color:#fff}
.sp-btn-lg{padding:.85rem 1.5rem;font-size:1rem}
.sp-hero-panel{background:rgba(255,255,255,.12);backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,.2);border-radius:var(--sp-radius);padding:1.5rem}
.sp-panel-title{font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(255,255,255,.7);margin-bottom:1rem}
.sp-panel-row{display:flex;align-items:flex-start;gap:.75rem;padding:.55rem 0;border-bottom:1px solid rgba(255,255,255,.1)}
.sp-panel-row:last-of-type{border-bottom:none}
.sp-panel-row>i{font-size:1rem;color:var(--sp-orange);margin-top:.15rem;flex-shrink:0}
.sp-panel-row>div{display:flex;flex-direction:column}
.sp-panel-label{font-size:.78rem;color:rgba(255,255,255,.65)}
.sp-panel-val{font-size:.92rem;font-weight:600;color:#fff}
.sp-panel-cta{display:block;text-align:center;background:#25D366;color:#fff;padding:.65rem 1rem;border-radius:7px;font-weight:700;font-size:.9rem;text-decoration:none;margin-top:1.1rem;transition:background .2s}
.sp-panel-cta:hover{background:#1da855;color:#fff}
.sp-trust-bar{background:var(--sp-orange);padding:.85rem 0}
.sp-trust-grid{display:flex;flex-wrap:wrap;justify-content:center;gap:1.25rem 2.5rem}
.sp-trust-item{display:flex;align-items:center;gap:.6rem;color:#fff;font-weight:700;font-size:.92rem}
.sp-trust-item i{font-size:1.1rem}
.sp-gallery-section{padding:2.5rem 0;background:var(--sp-light)}
.sp-gallery-wrap{display:grid;grid-template-columns:1fr 110px;gap:1rem;max-width:800px;margin:0 auto;align-items:start}
.sp-gallery-main-wrap{border-radius:var(--sp-radius);overflow:hidden;box-shadow:var(--sp-shadow);background:#fff}
.sp-gallery-main-img{width:100%;height:auto;display:block;cursor:zoom-in;transition:transform .3s}
.sp-gallery-main-img:hover{transform:scale(1.01)}
.sp-gallery-thumbs{display:flex;flex-direction:column;gap:.6rem}
.sp-thumb-item{border-radius:6px;overflow:hidden;cursor:pointer;border:2px solid transparent;transition:border-color .2s}
.sp-thumb-item img{width:100%;height:70px;object-fit:cover;display:block}
.sp-thumb-item.active,.sp-thumb-item:hover{border-color:var(--sp-primary)}
.sp-specs-section{padding:4rem 0;background:#fff}
.sp-specs-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(175px,1fr));gap:1.25rem}
.sp-spec-card{text-align:center;padding:1.5rem 1rem;border:1px solid var(--sp-border);border-radius:var(--sp-radius);background:var(--sp-light);transition:box-shadow .2s,border-color .2s}
.sp-spec-card:hover{box-shadow:var(--sp-shadow);border-color:var(--sp-primary)}
.sp-spec-icon-wrap{width:48px;height:48px;border-radius:50%;background:var(--sp-primary);color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.15rem;margin:0 auto .85rem}
.sp-spec-label{font-size:.78rem;color:var(--sp-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:.35rem}
.sp-spec-val{font-size:.95rem;font-weight:700;color:var(--sp-text)}
.sp-pricing-section{padding:4rem 0;background:var(--sp-light)}
.sp-pricing-wrap{overflow-x:auto}
.sp-pricing-tbl{width:100%;border-collapse:collapse;background:#fff;border-radius:var(--sp-radius);overflow:hidden;box-shadow:var(--sp-shadow)}
.sp-pricing-tbl thead tr{background:var(--sp-primary);color:#fff}
.sp-pricing-tbl th{padding:.9rem 1.1rem;text-align:left;font-size:.88rem;font-weight:700;white-space:nowrap}
.sp-pricing-tbl td{padding:.85rem 1.1rem;border-bottom:1px solid var(--sp-border);font-size:.92rem}
.sp-pricing-tbl tbody tr:last-child td{border-bottom:none}
.sp-pricing-tbl tbody tr:hover td{background:#fdf2f5}
.sp-rq-badge{display:inline-block;background:#fff7ed;color:#c05621;border:1px solid #fbd38d;border-radius:20px;padding:.25rem .85rem;font-size:.82rem;font-weight:700;white-space:nowrap;letter-spacing:.02em}
.sp-price-wa{display:inline-flex;align-items:center;gap:.4rem;background:#25D366;color:#fff;padding:.45rem .9rem;border-radius:6px;font-size:.85rem;font-weight:700;text-decoration:none;white-space:nowrap;transition:background .2s}
.sp-price-wa:hover{background:#1da855;color:#fff}
.sp-pricing-note{margin-top:1rem;font-size:.88rem;color:var(--sp-muted);text-align:center}
.sp-pricing-note a{color:var(--sp-primary)}
.sp-why-section{padding:4rem 0;background:#fff}
.sp-why-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1.5rem}
.sp-why-card{padding:1.75rem 1.25rem;border:1px solid var(--sp-border);border-radius:var(--sp-radius);text-align:center;transition:box-shadow .2s,border-color .2s}
.sp-why-card:hover{box-shadow:var(--sp-shadow);border-color:var(--sp-primary)}
.sp-why-icon{width:56px;height:56px;background:var(--sp-primary);color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.3rem;margin:0 auto 1rem}
.sp-why-card h3{font-size:1rem;font-weight:700;color:var(--sp-text);margin:0 0 .5rem}
.sp-why-card p{font-size:.9rem;color:var(--sp-muted);line-height:1.6;margin:0}
.sp-faq-section{padding:4rem 0;background:var(--sp-light)}
.sp-faq-list{max-width:800px;margin:0 auto;display:flex;flex-direction:column;gap:.75rem}
.sp-faq-item{background:#fff;border:1px solid var(--sp-border);border-radius:var(--sp-radius);overflow:hidden;transition:box-shadow .2s}
.sp-faq-item[open]{box-shadow:var(--sp-shadow);border-color:var(--sp-primary)}
.sp-faq-q{display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:1rem 1.25rem;cursor:pointer;list-style:none;font-weight:600;font-size:.97rem;color:var(--sp-text);user-select:none}
.sp-faq-q::-webkit-details-marker{display:none}
.sp-faq-icon{color:var(--sp-primary);font-size:.85rem;flex-shrink:0;transition:transform .25s}
.sp-faq-item[open] .sp-faq-icon{transform:rotate(180deg)}
.sp-faq-a{padding:.1rem 1.25rem 1.1rem}
.sp-faq-a p{margin:0;color:var(--sp-muted);line-height:1.7;font-size:.93rem}
.sp-cta-section{padding:3.5rem 0;background:linear-gradient(135deg,#8B1538,#660f29)}
.sp-cta-inner{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:1.5rem}
.sp-cta-text h2{font-size:clamp(1.3rem,3vw,1.8rem);color:#fff;font-weight:800;margin:0 0 .4rem}
.sp-cta-text p{color:rgba(255,255,255,.8);font-size:.97rem;margin:0}
.sp-cta-btns{display:flex;flex-wrap:wrap;gap:.85rem}
.sp-seo-section{padding:3rem 0;background:#fff}
.sp-seo-content{max-width:860px;margin:0 auto;font-size:.95rem;line-height:1.8;color:var(--sp-text)}
.sp-seo-content h2,.sp-seo-content h3{color:var(--sp-primary)}
.sp-seo-content a{color:var(--sp-primary)}
.sp-related-section{padding:4rem 0;background:var(--sp-light)}
.sp-related-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.25rem}
.sp-related-card{display:block;text-decoration:none;background:#fff;border:1px solid var(--sp-border);border-radius:var(--sp-radius);overflow:hidden;transition:box-shadow .2s,border-color .2s}
.sp-related-card:hover{box-shadow:0 4px 18px rgba(139,21,56,.14);border-color:var(--sp-primary)}
.sp-related-img img{width:100%;height:180px;object-fit:cover;display:block}
.sp-related-placeholder{width:100%;height:180px;background:var(--sp-light);display:flex;align-items:center;justify-content:center;color:var(--sp-border);font-size:2rem}
.sp-related-name{padding:.85rem 1rem .3rem;font-weight:700;font-size:.95rem;color:var(--sp-text)}
.sp-related-link{padding:.3rem 1rem .85rem;font-size:.85rem;color:var(--sp-primary);font-weight:600}
.sp-lightbox{position:fixed;inset:0;background:rgba(0,0,0,.9);z-index:99999;display:flex;align-items:center;justify-content:center;cursor:zoom-out}
.sp-lightbox img{max-width:92vw;max-height:92vh;object-fit:contain;border-radius:4px;pointer-events:none}
.sp-lb-close{position:absolute;top:1.2rem;right:1.5rem;background:rgba(255,255,255,.15);border:none;color:#fff;font-size:1.3rem;width:42px;height:42px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center}
.sp-lb-close:hover{background:rgba(255,255,255,.3)}
.ea-modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:9999;display:flex;align-items:center;justify-content:center;padding:1rem}
.ea-modal-box{background:#fff;border-radius:12px;width:100%;max-width:560px;max-height:92vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,.3)}
.ea-modal-header{display:flex;align-items:center;justify-content:space-between;padding:1.25rem 1.5rem;border-bottom:1px solid var(--sp-border)}
.ea-modal-header h3{margin:0;font-size:1.15rem;color:var(--sp-primary);font-weight:700}
.ea-modal-header h3 i{margin-right:.5rem}
.ea-modal-close{background:none;border:none;font-size:1.1rem;cursor:pointer;color:var(--sp-muted);padding:.3rem;border-radius:4px}
.ea-modal-close:hover{background:var(--sp-light);color:var(--sp-primary)}
.ea-modal-body{padding:1.5rem}
.ea-form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem}
.ea-form-group{margin-bottom:1rem}
.ea-form-group label{display:block;font-size:.88rem;font-weight:600;color:var(--sp-text);margin-bottom:.4rem}
.ea-form-group input,.ea-form-group textarea{width:100%;padding:.65rem .9rem;border:1px solid var(--sp-border);border-radius:7px;font-size:.93rem;color:var(--sp-text);background:#fff;box-sizing:border-box;transition:border-color .2s;font-family:inherit}
.ea-form-group input:focus,.ea-form-group textarea:focus{outline:none;border-color:var(--sp-primary);box-shadow:0 0 0 3px rgba(139,21,56,.1)}
.ea-form-submit{width:100%;padding:.8rem 1rem;background:var(--sp-primary);color:#fff;border:none;border-radius:7px;font-size:1rem;font-weight:700;cursor:pointer;transition:background .2s}
.ea-form-submit:hover{background:var(--sp-dark)}
@media(max-width:900px){.sp-hero-inner{grid-template-columns:1fr}.sp-hero-panel{display:none}}
@media(max-width:768px){.sp-gallery-wrap{grid-template-columns:1fr}.sp-gallery-thumbs{flex-direction:row;overflow-x:auto}.sp-thumb-item img{height:60px;width:80px}.sp-cta-inner{flex-direction:column;text-align:center}.sp-cta-btns{justify-content:center}.ea-form-row{grid-template-columns:1fr}}
@media(max-width:480px){.sp-hero-ctas{flex-direction:column}.sp-hero-ctas a,.sp-hero-ctas button{width:100%;justify-content:center}.sp-trust-grid{gap:1rem 1.5rem}}
</style>

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