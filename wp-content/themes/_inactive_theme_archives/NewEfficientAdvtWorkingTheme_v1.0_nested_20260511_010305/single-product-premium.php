<?php
/**
 * Template: Premium Product Page
 * Reusable for ALL curated products — Efficient Advertising LLC
 *
 * Sections: Breadcrumb → Hero (Gallery + Config) → Trust Bar → Features →
 *           Specs (Tabbed) → How to Order + Artwork → Related Products →
 *           Reviews → FAQ → CTA Strip → Sticky Mobile Bar
 *
 * @package NewEfficientAdvtWorkingTheme_v1.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

/* ── PRODUCT DATA ── */
$pp_id         = get_the_ID();
$pp_title      = get_the_title();
$pp_url        = get_permalink();
$pp_excerpt    = get_the_excerpt();
$pp_content    = get_the_content();
$pp_slug       = get_post_field( 'post_name', $pp_id );
$wa_num        = '971527966265';
$wa_text       = rawurlencode( 'Hi, I need a quote for: ' . $pp_title . ' in Dubai' );
$contact_url   = home_url( '/contact-us/?product=' . urlencode( $pp_slug ) );

/* Category — use product_cat (WooCommerce) */
$pp_terms    = get_the_terms( $pp_id, 'product_cat' );
$pp_cat_slug = '';
$pp_cat_name = 'Products';
$pp_cat_url  = home_url( '/shop/' );
if ( $pp_terms && ! is_wp_error( $pp_terms ) ) {
  $pp_cat      = reset( $pp_terms );
  $pp_cat_slug = $pp_cat->slug;
  $pp_cat_name = $pp_cat->name;
  $pp_cat_url  = get_term_link( $pp_cat );
}

/* Gallery: featured image + custom fields */
$gallery  = [];
$thumb_id = get_post_thumbnail_id( $pp_id );
if ( $thumb_id ) {
  $s = wp_get_attachment_image_src( $thumb_id, 'large' );
  if ( $s ) $gallery[] = [ 'url' => $s[0], 'alt' => esc_attr( $pp_title . ' — Efficient Advertising Dubai' ) ];
}
foreach ( [ 'product_image_one', 'product_image_two', 'product_image_three' ] as $i => $fld ) {
  $val = get_post_meta( $pp_id, $fld, true );
  if ( ! $val ) continue;
  if ( is_numeric( $val ) ) {
    $s = wp_get_attachment_image_src( (int) $val, 'large' );
    if ( $s ) $gallery[] = [ 'url' => $s[0], 'alt' => esc_attr( $pp_title . ' view ' . ( $i + 2 ) ) ];
  } elseif ( filter_var( $val, FILTER_VALIDATE_URL ) ) {
    $gallery[] = [ 'url' => esc_url( $val ), 'alt' => esc_attr( $pp_title . ' view ' . ( $i + 2 ) ) ];
  }
}

/* Short description: keep hero copy concise for launch-readiness */
$short_desc = trim( wp_strip_all_tags( $pp_excerpt ) );
if ( empty( $short_desc ) ) {
  $short_desc = trim( wp_strip_all_tags( wp_trim_words( $pp_content, 26, '...' ) ) );
} else {
  $short_desc = wp_trim_words( $short_desc, 26, '...' );
}

/* ── PER-CATEGORY CONFIGURATION ── */
$_pp_cats = [
  'backdrop-display-dubai' => [
    'tagline'  => 'Custom backdrops, pop-up stands, step-and-repeat & fabric displays — designed, printed & installed across Dubai & the UAE.',
    'badges'   => [ ['label'=>'Materials','value'=>'Fabric / PVC / Canvas'], ['label'=>'Print','value'=>'Full-Colour Digital'], ['label'=>'Turnaround','value'=>'Same-Day Available'], ['label'=>'Delivery','value'=>'UAE-Wide'] ],
    'features' => [
      ['icon'=>'fa-home','title'=>'Solid Frame Construction','desc'=>'Premium MDF or hardwood frames that stand firm throughout your event — no wobble, no compromise.'],
      ['icon'=>'fa-clock','title'=>'Dye-Sub & Direct Print','desc'=>'Vivid CMYK colours with no banding. Fabric panels are precision-printed and tensioned for a wrinkle-free finish.'],
      ['icon'=>'fa-expand','title'=>'Any Size, Any Shape','desc'=>'Standard 2×2 m to wall-sized 6×3 m and beyond. Curved, arch, and custom profiles available.'],
      ['icon'=>'fa-users','title'=>'Brand Activations','desc'=>'Red carpet press walls, product launches, corporate events — your logo perfectly positioned every time.'],
    ],
    'specs' => [
      ['tab'=>'Materials','rows'=> [ ['Fabric Backdrop','200gsm knit polyester, dye-sublimated — brightest colours, no fading'], ['Vinyl Backdrop','440gsm PVC vinyl, solvent or UV inks — high durability outdoors'], ['Wooden Frame','18mm MDF or kiln-dried hardwood, lacquered/stained finish'], ['Pop-Up','Aluminium telescopic frame + fabric graphic panel'] ] ],
      ['tab'=>'Sizes','rows'=> [ ['Standard','1×2m, 2×2m, 2×3m, 3×4m'], ['Large Format','Up to 6×3m single piece, wider with joining'], ['Custom','Any custom size or shape — arch, hexagonal, curved'] ] ],
    ],
    'faq' => [
      ['q'=>'What is the minimum order for custom backdrops in Dubai?','a'=>'We print from 1 piece with no minimum order. Custom sizes are always welcome.'],
      ['q'=>'Do you supply the frame with the backdrop?','a'=>'Yes — we offer complete kits with aluminium pop-up or straight frames plus a carry bag.'],
      ['q'=>'Can I get same-day backdrop printing in Dubai?','a'=>'Yes. Order before 10am for same-day collection from our Dubai production facility.'],
      ['q'=>'What file format do you need for backdrop printing?','a'=>'AI, PDF or high-resolution JPG/PNG at 150 dpi at actual size. Free artwork support included.'],
    ],
  ],
  'flex-banner-printing-dubai' => [
    'tagline'  => 'Roll-up banners, X-banners, flex banners & fence banners — vibrant print quality, fast turnaround across Dubai & UAE.',
    'badges'   => [ ['label'=>'Sizes','value'=>'0.6m – 3m Wide'], ['label'=>'Materials','value'=>'Flex / Mesh / Vinyl'], ['label'=>'Turnaround','value'=>'4–24 Hours'], ['label'=>'Delivery','value'=>'Free Dubai Delivery'] ],
    'features' => [
      ['icon'=>'fa-bolt','title'=>'Same-Day Production','desc'=>'Urgent roll-up banners completed within 2–4 hours from order confirmation.'],
      ['icon'=>'fa-layer-group','title'=>'Multiple Materials','desc'=>'Flex, mesh, vinyl, banner cloth — we match the right material to your application.'],
      ['icon'=>'fa-sun','title'=>'UV & Weather Resistant','desc'=>'Our flex and mesh banners are UV-resistant and weatherproof for 2–3 years outdoor use.'],
      ['icon'=>'fa-suitcase','title'=>'Stands Included','desc'=>'Roll-up and X-banner prices include premium retractable stands with carry bags.'],
    ],
    'specs' => [
      ['tab'=>'Materials','rows'=> [ ['PVC Vinyl','440–550gsm blockout vinyl, UV/solvent digital print'], ['Mesh Banner','340gsm PVC mesh, wind-through for fencing/scaffolding'], ['Fabric Banner','Dye-sub polyester for indoor premium displays'], ['Canvas','380gsm artist cotton canvas for premium indoor signage'] ] ],
      ['tab'=>'Finishing','rows'=> [ ['Standard','Welded hems + brass eyelets every 50cm'], ['Pole Pocket','Top/bottom pole pockets for hanging systems'], ['Rope & Toggle','Rope hems with toggle clips for fence mounting'] ] ],
    ],
    'faq' => [
      ['q'=>'What is flex banner printing?','a'=>'Flex banners are large-format prints on durable PVC or mesh, ideal for outdoor events, scaffolding, and fencing.'],
      ['q'=>'How fast can you print a roll-up banner in Dubai?','a'=>'Same-day if ordered before 10am. Urgent roll-up banners completed within 2–4 hours.'],
      ['q'=>'Do roll-up banner prices include the stand?','a'=>'Yes — our price includes a premium retractable aluminium stand with carry bag.'],
      ['q'=>'Can flex banners be used outdoors in Dubai?','a'=>'Absolutely — our flex and mesh banners are UV-resistant and weatherproof for 2–3 years outdoor use.'],
    ],
  ],
  'flags-printing-dubai' => [
    'tagline'  => 'Teardrop flags, feather flags, car flags & event flags — full colour dye sublimation, fast delivery across Dubai & UAE.',
    'badges'   => [ ['label'=>'Types','value'=>'Teardrop / Feather / Car'], ['label'=>'Print','value'=>'Dye Sublimation'], ['label'=>'Turnaround','value'=>'3–5 Days'], ['label'=>'Includes','value'=>'Pole + Base'] ],
    'features' => [
      ['icon'=>'fa-flag','title'=>'Full-Colour Dye-Sub','desc'=>'Vibrant, colour-fast print on all flag types — withstands Dubai\'s sun and wind.'],
      ['icon'=>'fa-shapes','title'=>'Custom Shapes','desc'=>'Teardrop, feather, rectangular, car, hand, table — plus fully custom-cut shapes.'],
      ['icon'=>'fa-wind','title'=>'Outdoor Durable','desc'=>'UV-treated polyester, colourfast and weatherproof for outdoor events and promotions.'],
      ['icon'=>'fa-box-open','title'=>'Complete Sets','desc'=>'Every flag comes with pole kit and ground spike or base — ready to use immediately.'],
    ],
    'specs' => [
      ['tab'=>'Flag Types','rows'=> [ ['Teardrop','2m–4m height, curved shape — best for shop fronts and events'], ['Feather','2.5m–5.5m height, flowing shape — maximum visibility outdoors'], ['Car Flags','30×45cm polyester pairs with window clips'], ['Table Flags','A5/A4 satin polyester on chrome/black stands'] ] ],
      ['tab'=>'Materials','rows'=> [ ['Knitted Polyester','Standard for all outdoor flags — lightweight, vibrant print'], ['Satin Polyester','Premium finish for table and ceremonial flags'], ['Double-Sided','Two prints sewn back-to-back with block-out layer'] ] ],
    ],
    'faq' => [
      ['q'=>'What types of flag printing do you offer in Dubai?','a'=>'We print teardrop, feather, rectangular, car, hand, table and custom-shaped event flags with full-colour dye sublimation.'],
      ['q'=>'Are your promotional flags suitable for outdoor use?','a'=>'Yes — all flags are printed on UV-treated polyester, colourfast and weatherproof for outdoor events.'],
      ['q'=>'Can I get custom-shaped flags?','a'=>'Yes — teardrop and feather shapes are standard; completely custom-cut shapes are available.'],
      ['q'=>'What is the minimum quantity for flag printing?','a'=>'From 1 piece. Bulk pricing applies from 10 units onwards.'],
    ],
  ],
  'signage-dubai' => [
    'tagline'  => '3D letters, acrylic signs, backlit LED channel letters, reception signs & outdoor signage — design, fabrication & installation Dubai & UAE.',
    'badges'   => [ ['label'=>'Types','value'=>'3D / Acrylic / LED'], ['label'=>'Materials','value'=>'Acrylic / Aluminium / Steel'], ['label'=>'Turnaround','value'=>'5–10 Days'], ['label'=>'Service','value'=>'Design + Install'] ],
    'features' => [
      ['icon'=>'fa-building','title'=>'Shop Front Signage','desc'=>'Complete facade signage — design, fabrication, and professional installation UAE-wide.'],
      ['icon'=>'fa-lightbulb','title'=>'LED & Backlit','desc'=>'Channel letters, halo-lit signs, and lightboxes — illuminated signage for maximum impact.'],
      ['icon'=>'fa-gem','title'=>'Premium Materials','desc'=>'Marine-grade stainless steel, UV-stabilised acrylic, and aluminium composite panels.'],
      ['icon'=>'fa-tools','title'=>'Full-Service','desc'=>'From 3D design through fabrication to on-site installation — we handle everything.'],
    ],
    'specs' => [
      ['tab'=>'Sign Types','rows'=> [ ['Acrylic Letters','Laser-cut 10–20mm acrylic, standoff mounted or flush'], ['Channel Letters','Aluminium with LED backlit or halo-lit'], ['Lightbox','Aluminium frame with LED-lit fabric or acrylic face'], ['ACP Board','Aluminium composite panel with vinyl graphics'] ] ],
      ['tab'=>'Finishes','rows'=> [ ['Brushed Metal','Stainless steel or aluminium brushed finish'], ['Painted','Spray-painted RAL/Pantone matched colours'], ['Illuminated','Front-lit, backlit (halo), or edge-lit LED options'] ] ],
    ],
    'faq' => [
      ['q'=>'Do you supply and install signage in Dubai?','a'=>'Yes — full process: design, fabrication, delivery and installation anywhere in Dubai and the UAE.'],
      ['q'=>'What materials are best for outdoor signage in Dubai?','a'=>'Aluminium composite panels, marine-grade stainless steel and UV-stabilised acrylic perform best in UAE conditions.'],
      ['q'=>'How long does custom 3D signage take?','a'=>'Standard 3D letter signs take 5–7 working days. Rush orders in 3 days with an express surcharge.'],
      ['q'=>'Do you make backlit LED signs?','a'=>'Yes — LED backlit channel letters, halo-lit signs and lightboxes of all sizes.'],
    ],
  ],
  'vehicle-branding' => [
    'tagline'  => 'Full vehicle wraps, partial wraps & fleet graphics — premium 3M / Avery vinyl, expert application across Dubai & UAE.',
    'badges'   => [ ['label'=>'Services','value'=>'Full / Partial / Fleet'], ['label'=>'Materials','value'=>'3M / Avery Cast Vinyl'], ['label'=>'Turnaround','value'=>'1–3 Days'], ['label'=>'Coverage','value'=>'All UAE Emirates'] ],
    'features' => [
      ['icon'=>'fa-car','title'=>'Full & Partial Wraps','desc'=>'From complete colour-change wraps to branded side panels and spot graphics.'],
      ['icon'=>'fa-shield-alt','title'=>'Paint Protection','desc'=>'Premium cast vinyl protects your paintwork — removed cleanly when you\'re ready.'],
      ['icon'=>'fa-truck','title'=>'Fleet Branding','desc'=>'Consistent brand application across entire vehicle fleets — cars, vans, trucks, buses.'],
      ['icon'=>'fa-sun','title'=>'5–7 Year Durability','desc'=>'Premium cast vinyl lasts 5–7 years in Dubai\'s climate without fading or peeling.'],
    ],
    'specs' => [
      ['tab'=>'Vinyl Types','rows'=> [ ['Cast Vinyl','Premium 3M/Avery, air-release, 5–7 year outdoor'], ['Calendared','Economy option, 2–3 year outdoor life'], ['Chrome / Metallic','Mirror, satin chrome, brushed metal finishes'], ['Colour Change','Full palette — gloss, matte, satin, pearlescent'] ] ],
      ['tab'=>'Vehicles','rows'=> [ ['Sedan','Full wrap: 1–2 days production + application'], ['SUV / Van','Full wrap: 2–3 days, partial: 1 day'], ['Truck / Bus','Fleet graphics: 2–4 days per vehicle'], ['Boat / Marine','Speciality marine-grade vinyl application'] ] ],
    ],
    'faq' => [
      ['q'=>'How long does a vehicle wrap last in Dubai?','a'=>'Premium cast vinyl wraps last 5–7 years in Dubai\'s climate. Calendared vinyl lasts 2–3 years.'],
      ['q'=>'Will wrapping damage my car\'s paintwork?','a'=>'No — premium cast vinyl protects the paint. When removed correctly, paintwork is fully preserved.'],
      ['q'=>'How long does it take to wrap a car?','a'=>'A standard sedan full wrap takes 1–2 days. Larger vehicles take 2–3 days.'],
      ['q'=>'Do you wrap fleet vehicles?','a'=>'Yes — we specialise in fleet branding, ensuring consistent application across all vehicles.'],
    ],
  ],
  'sticker-printing-dubai' => [
    'tagline'  => 'Custom sticker printing in Dubai — vinyl, PVC, die-cut, wall, floor & glass stickers. Waterproof, UV-resistant, fast turnaround.',
    'badges'   => [ ['label'=>'Types','value'=>'Vinyl / Die-Cut / Wall'], ['label'=>'Finish','value'=>'Gloss / Matt / Clear'], ['label'=>'Turnaround','value'=>'Same-Day Available'], ['label'=>'Quantity','value'=>'From 1 Piece'] ],
    'features' => [
      ['icon'=>'fa-droplet','title'=>'Waterproof & UV-Resistant','desc'=>'All vinyl stickers are waterproof and UV-resistant for indoor and outdoor UAE conditions.'],
      ['icon'=>'fa-scissors','title'=>'Custom Die-Cut','desc'=>'Contour-cut in any shape — circles, custom logos, silhouettes. No minimum for die-cuts.'],
      ['icon'=>'fa-clock','title'=>'Same-Day Turnaround','desc'=>'Standard stickers available same-day. Large format and speciality finishes within 2 days.'],
      ['icon'=>'fa-layer-group','title'=>'Multiple Applications','desc'=>'Wall graphics, floor stickers, glass decals, product labels, vehicle decals and more.'],
    ],
    'specs' => [
      ['tab'=>'Materials','rows'=> [ ['Gloss Vinyl','Standard glossy finish, waterproof, UV-resistant'], ['Matt Vinyl','Non-reflective finish, premium feel'], ['Clear Vinyl','Transparent background for glass and window applications'], ['Anti-Slip Laminate','Floor sticker with safety-rated textured surface'] ] ],
      ['tab'=>'Options','rows'=> [ ['Die-Cut','Contour-cut to any custom shape'], ['Kiss-Cut','Cut through vinyl layer only, easy peel from backing'], ['Wall Removable','Repositionable adhesive for interior walls'], ['Permanent','High-tack adhesive for outdoor and vehicle use'] ] ],
    ],
    'faq' => [
      ['q'=>'Are your vinyl stickers waterproof?','a'=>'Yes — all vinyl stickers are waterproof and UV-resistant for indoor and outdoor UAE conditions.'],
      ['q'=>'Can you cut stickers to custom shapes?','a'=>'Yes — die-cut and contour-cut in any shape. No minimum required for die-cuts.'],
      ['q'=>'How long do outdoor stickers last in Dubai?','a'=>'Outdoor vinyl with UV lamination lasts 3–5 years in Dubai\'s climate.'],
      ['q'=>'What is the smallest quantity I can order?','a'=>'From 1 piece for large-format stickers. Cut stickers from 10 pcs minimum.'],
    ],
  ],
  'exhibition-event-management' => [
    'tagline'  => 'Exhibition stand design, build & management in Dubai — shell scheme, modular & bespoke custom stands for trade shows & events.',
    'badges'   => [ ['label'=>'Stand Types','value'=>'Shell / Modular / Bespoke'], ['label'=>'Sizes','value'=>'9m² to 200m²+'], ['label'=>'Service','value'=>'Design → Build → Install'], ['label'=>'Venues','value'=>'DWTC / ADNEC / Expo City'] ],
    'features' => [
      ['icon'=>'fa-drafting-compass','title'=>'3D Design & Visualisation','desc'=>'Photorealistic 3D renders so you see your stand before a single panel is cut.'],
      ['icon'=>'fa-hammer','title'=>'In-House Fabrication','desc'=>'Our own workshop in Dubai builds aluminium, fabric, acrylic and LED structures.'],
      ['icon'=>'fa-truck','title'=>'Logistics & Install','desc'=>'We deliver, install, and dismantle at any UAE exhibition venue. Post-show storage available.'],
      ['icon'=>'fa-redo','title'=>'Reusable Systems','desc'=>'Modular stand components can be reconfigured for different booth sizes at future shows.'],
    ],
    'specs' => [
      ['tab'=>'Stand Types','rows'=> [ ['Shell Scheme Upgrade','Graphics + furniture + lighting for standard shell booths'], ['Modular','Aluminium frame + fabric/acrylic walls — reconfigurable'], ['Bespoke Custom','Fully custom-designed and fabricated to your specification'], ['Pop-Up Display','Fabric + frame portable display — 3m to 6m wide'] ] ],
      ['tab'=>'Services','rows'=> [ ['Design','3D renders, floor plan, and material specification'], ['Build','In-house fabrication — aluminium, acrylic, LED, fabric'], ['Install','On-site construction, electrical, and final dressing'], ['Dismantle','Post-event breakdown, transport, and storage'] ] ],
    ],
    'faq' => [
      ['q'=>'Do you design and build exhibition stands in Dubai?','a'=>'Yes — complete solutions from 3D design through to build, installation and dismantling at any Dubai venue.'],
      ['q'=>'Which venues do you service?','a'=>'DWTC, ADNEC, Dubai Expo City, Sharjah Expo Centre and all other UAE exhibition venues.'],
      ['q'=>'How far in advance should I book?','a'=>'4–6 weeks for bespoke stands; 2–3 weeks for modular. Rush 1-week builds available for shell scheme upgrades.'],
      ['q'=>'Do you handle post-show storage?','a'=>'Yes — we deliver, install, dismantle, and store stand components for your next show.'],
    ],
  ],
  'promotional-gifts-dubai' => [
    'tagline'  => 'Branded USB drives, pens, mugs, notebooks & corporate gift sets — custom logo printing & engraving for businesses across Dubai & UAE.',
    'badges'   => [ ['label'=>'Products','value'=>'USB / Pens / Mugs / Bags'], ['label'=>'Branding','value'=>'Print / Engrave / Emboss'], ['label'=>'MOQ','value'=>'From 25 Pieces'], ['label'=>'Turnaround','value'=>'3–7 Days'] ],
    'features' => [
      ['icon'=>'fa-gift','title'=>'Wide Product Range','desc'=>'USB drives, pens, mugs, notebooks, lanyards, power banks, bags — hundreds of options.'],
      ['icon'=>'fa-paint-brush','title'=>'Multiple Branding Methods','desc'=>'Full colour print, laser engraving, embossing, debossing, and embroidery.'],
      ['icon'=>'fa-box','title'=>'Custom Packaging','desc'=>'Branded gift boxes, tissue paper, sleeves and presentation bags available.'],
      ['icon'=>'fa-shipping-fast','title'=>'Fast Delivery','desc'=>'Stock items with branding: 3–5 working days. Custom-manufactured: 10–14 days.'],
    ],
    'specs' => [
      ['tab'=>'Branding Methods','rows'=> [ ['Screen Print','1–4 colours on flat surfaces — mugs, bags, pens'], ['Laser Engrave','Permanent on metal and wood — premium feel'], ['Full Colour','Sublimation or UV print — photos and gradients'], ['Embroidery','Thread stitching on caps, polo shirts, bags'] ] ],
      ['tab'=>'Products','rows'=> [ ['Writing','Metal pens, ballpoints, fountain pens, pencil sets'], ['Tech','USB drives, power banks, wireless chargers, speakers'], ['Drinkware','Ceramic mugs, travel mugs, water bottles, flasks'], ['Office','Notebooks, desk organisers, mouse pads, coasters'] ] ],
    ],
    'faq' => [
      ['q'=>'What is the minimum order for promotional gifts?','a'=>'Minimum 25 pieces for most branded gifts. Notebooks and premium items from 50 pcs.'],
      ['q'=>'Can you brand gifts with our logo?','a'=>'Yes — we print, engrave, emboss or embroider your logo on all promotional items.'],
      ['q'=>'Do you do custom corporate gift packaging?','a'=>'Yes — custom-printed gift boxes, tissue paper, sleeves and bags available.'],
      ['q'=>'How fast can you deliver promotional gifts in Dubai?','a'=>'Stock items with branding: 3–5 working days. Custom-manufactured items: 10–14 working days.'],
    ],
  ],
  'plastic-bags-printing' => [
    'tagline'  => 'Custom printed plastic bags in Dubai — HDPE, LDPE, non-woven PP and biodegradable bags with logo printing for retail & corporate use.',
    'badges'   => [ ['label'=>'Types','value'=>'HDPE / LDPE / Non-Woven'], ['label'=>'Print','value'=>'1–6 Colour Flexo'], ['label'=>'MOQ','value'=>'From 500 Pieces'], ['label'=>'Turnaround','value'=>'7–14 Days'] ],
    'features' => [
      ['icon'=>'fa-shopping-bag','title'=>'Multiple Materials','desc'=>'HDPE T-shirt bags, LDPE carrier bags, non-woven PP, and eco-friendly biodegradable options.'],
      ['icon'=>'fa-leaf','title'=>'Eco Options','desc'=>'D2W oxo-biodegradable and fully compostable bags — compliant with UAE regulations.'],
      ['icon'=>'fa-palette','title'=>'Custom Printing','desc'=>'Up to 6-colour flexographic printing or full digital print with your branding.'],
      ['icon'=>'fa-industry','title'=>'Factory Direct','desc'=>'Direct from manufacturing — competitive pricing for bulk orders.'],
    ],
    'specs' => [
      ['tab'=>'Materials','rows'=> [ ['HDPE','High-density polyethylene T-shirt bags — lightweight, strong'], ['LDPE','Low-density carrier bags — heavier gauge, premium feel'], ['Non-Woven PP','Reusable polypropylene — eco-friendly, brand visibility'], ['Biodegradable','D2W oxo-degradable or compostable options'] ] ],
      ['tab'=>'Sizes','rows'=> [ ['Small','20×30cm — pharmacy, accessories'], ['Medium','30×40cm — retail, general purpose'], ['Large','40×50cm — clothing, supermarket'], ['Custom','Any dimension to your specification'] ] ],
    ],
    'faq' => [
      ['q'=>'What types of bags do you print?','a'=>'HDPE T-shirt bags, LDPE carrier bags, non-woven PP bags, oxo-biodegradable and compostable bags.'],
      ['q'=>'What is the minimum order?','a'=>'500 pieces for most types; HDPE bags from 1,000 pcs.'],
      ['q'=>'Can bags be biodegradable?','a'=>'Yes — D2W oxo-biodegradable and fully compostable bags with full-colour logo printing.'],
      ['q'=>'Do your bags comply with UAE regulations?','a'=>'Yes — all bags comply with UAE packaging regulations. Eco-friendly alternatives available.'],
    ],
  ],
  'stationery-printing-dubai' => [
    'tagline'  => 'Business cards, letterheads, NCR books, envelopes & corporate stationery printing in Dubai — premium quality, same-day available.',
    'badges'   => [ ['label'=>'Products','value'=>'Cards / Letterheads / NCR'], ['label'=>'Finish','value'=>'Matt / Gloss / Spot UV'], ['label'=>'Turnaround','value'=>'Same-Day Available'], ['label'=>'Quantity','value'=>'From 50 Copies'] ],
    'features' => [
      ['icon'=>'fa-id-card','title'=>'Full Stationery Range','desc'=>'Business cards, letterheads, envelopes, NCR books, rubber stamps — everything your brand needs.'],
      ['icon'=>'fa-gem','title'=>'Premium Finishes','desc'=>'Matt/gloss lamination, soft-touch, spot UV, foil stamping, and embossing options.'],
      ['icon'=>'fa-bolt','title'=>'Same-Day Production','desc'=>'Standard business cards and letterheads available same-day before 10am.'],
      ['icon'=>'fa-palette','title'=>'Pantone Matching','desc'=>'Exact brand colour reproduction using CMYK proofing and Pantone reference.'],
    ],
    'specs' => [
      ['tab'=>'Products','rows'=> [ ['Business Cards','85×55mm, 350gsm silk/gloss/matt, single or double-sided'], ['Letterheads','A4, 100–120gsm uncoated, full colour'], ['NCR Books','2/3/4-part self-copy, A4/A5/A6, numbered + bound'], ['Envelopes','DL/C5/C4, 80–100gsm, window or plain'] ] ],
      ['tab'=>'Finishes','rows'=> [ ['Lamination','Matt or gloss protective coating'], ['Spot UV','Selective gloss highlight on matt base'], ['Foil Stamping','Gold, silver, or custom colour metallic foil'], ['Embossing','Raised or debossed texture for premium feel'] ] ],
    ],
    'faq' => [
      ['q'=>'Can I get same-day business cards?','a'=>'Yes — single or double-sided cards on standard stock available same-day if artwork submitted before 10am.'],
      ['q'=>'Do you print NCR books?','a'=>'Yes — 2-part, 3-part and 4-part NCR books in A4/A5/A6 with sequential numbering, padding, and binding.'],
      ['q'=>'What is the minimum for stationery?','a'=>'Business cards from 50 pcs, letterheads from 100 sheets, NCR books from 10 books.'],
      ['q'=>'Can you match our brand colours?','a'=>'Yes — we use Pantone matching and CMYK proofing to ensure brand colour consistency.'],
    ],
  ],
  'banners-printing' => [
    'tagline'  => 'PVC vinyl banners, mesh banners & same-day banner printing in Dubai — outdoor, indoor, custom size, fast turnaround.',
    'badges'   => [ ['label'=>'Material','value'=>'PVC / Mesh / Scrim'], ['label'=>'Sizes','value'=>'Custom — Any Size'], ['label'=>'Turnaround','value'=>'Same-Day Available'], ['label'=>'Delivery','value'=>'Free Dubai Delivery'] ],
    'features' => [
      ['icon'=>'fa-print','title'=>'High-Resolution Print','desc'=>'UV/solvent digital printing at 1440 dpi — vivid colours, sharp text on any banner size.'],
      ['icon'=>'fa-bolt','title'=>'Same-Day Production','desc'=>'Standard PVC banners available same-day if artwork submitted before 10am.'],
      ['icon'=>'fa-cloud-sun','title'=>'Outdoor Durable','desc'=>'UV-resistant inks on weatherproof materials — banners last 2–3 years outdoors in Dubai.'],
      ['icon'=>'fa-ruler','title'=>'Any Size','desc'=>'From small table banners to 50m+ building wraps — printed in one piece up to 5m wide.'],
    ],
    'specs' => [
      ['tab'=>'Materials','rows'=> [ ['PVC Vinyl','440–550gsm blockout — standard for most banners'], ['Mesh','340gsm PVC mesh — wind-through for fencing/scaffolding'], ['Scrim','Heavy-duty 550gsm for premium outdoor installations'], ['Fabric','Dye-sub polyester for indoor premium displays'] ] ],
      ['tab'=>'Finishing','rows'=> [ ['Eyelets','Brass eyelets every 50cm — standard finish'], ['Hemmed','Welded hems for clean edges and durability'], ['Pole Pockets','Top/bottom pockets for hanging systems'], ['Rope & Toggle','For fence and scaffold mounting'] ] ],
    ],
    'faq' => [
      ['q'=>'What is the difference between PVC and mesh banners?','a'=>'PVC vinyl is solid — ideal for walls. Mesh is perforated, allowing wind through — best for fencing and scaffolding.'],
      ['q'=>'Can I get same-day banner printing?','a'=>'Yes — standard PVC banners available same-day if artwork submitted before 10am.'],
      ['q'=>'What is the maximum banner size?','a'=>'Up to 5m wide in one piece. Sections can be joined for larger installations.'],
      ['q'=>'Do banners include eyelets and hemming?','a'=>'Yes — welded hems and brass eyelets every 50cm as standard. Pole pockets on request.'],
    ],
  ],
];

$_pp_default = [
  'tagline'  => 'Professional printing & advertising solutions in Dubai — quality in-house production, fast turnaround, free design support.',
  'badges'   => [ ['label'=>'Service','value'=>'In-House Production'], ['label'=>'Turnaround','value'=>'Same-Day Available'], ['label'=>'Design','value'=>'Free Artwork Support'], ['label'=>'Delivery','value'=>'All UAE Emirates'] ],
  'features' => [
    ['icon'=>'fa-industry','title'=>'In-House Production','desc'=>'We own and operate our printing facility in Dubai — no outsourcing, full quality control.'],
    ['icon'=>'fa-bolt','title'=>'Same-Day Available','desc'=>'Urgent order? Same-day and next-day printing available on most products.'],
    ['icon'=>'fa-pen-ruler','title'=>'Free Design Support','desc'=>'Our in-house design team prepares and adjusts your artwork at no extra charge.'],
    ['icon'=>'fa-truck','title'=>'UAE-Wide Delivery','desc'=>'Fast delivery to Dubai, Abu Dhabi, Sharjah, and all UAE emirates.'],
  ],
  'specs' => [
    ['tab'=>'Overview','rows'=> [ ['Print Method','Full-colour CMYK digital printing'], ['Materials','Varies by product — vinyl, fabric, acrylic, paper'], ['Sizes','Standard and custom sizes available'], ['Turnaround','1–5 working days, same-day options'] ] ],
  ],
  'faq' => [
    ['q'=>'How quickly can you print my order?','a'=>'Most orders ready in 1–3 working days. Same-day and next-day options available.'],
    ['q'=>'Do you provide free design support?','a'=>'Yes — our in-house design team prepares and adjusts artwork at no extra charge.'],
    ['q'=>'What is the minimum order quantity?','a'=>'Minimums vary by product. Many items print from 1 piece.'],
    ['q'=>'Do you deliver across the UAE?','a'=>'Yes — Dubai, Abu Dhabi, Sharjah, and all UAE locations.'],
  ],
];

$cfg = isset( $_pp_cats[ $pp_cat_slug ] ) ? $_pp_cats[ $pp_cat_slug ] : $_pp_default;

/* ── NEW SLUG → OLD CONFIG REMAP ──
 * After migration, products use new category slugs (*-new).
 * Map each new slug to the closest matching legacy config above. */
$_slug_remap = [
  // Print Materials
  'print-materials'           => 'stationery-printing-dubai',
  'business-cards-new'        => 'stationery-printing-dubai',
  'flyers-new'                => 'stationery-printing-dubai',
  'brochures-new'             => 'stationery-printing-dubai',
  'booklets-catalogues-new'   => 'stationery-printing-dubai',
  'postcards-new'             => 'stationery-printing-dubai',
  'greeting-cards-new'        => 'stationery-printing-dubai',
  'calendars-new'             => 'stationery-printing-dubai',
  'tickets-vouchers-new'      => 'stationery-printing-dubai',
  'menus-placemats-new'       => 'stationery-printing-dubai',
  'ncr-forms-new'             => 'stationery-printing-dubai',
  'certificates-new'          => 'stationery-printing-dubai',
  // Signage
  'signage-new'               => 'signage-dubai',
  '3d-illuminated-signage-new'=> 'signage-dubai',
  'name-plates-labels-new'    => 'signage-dubai',
  'led-digital-signage-new'   => 'signage-dubai',
  'rigid-board-signage-new'   => 'signage-dubai',
  'large-format-panel-signs-new' => 'signage-dubai',
  'wayfinding-directory-new'  => 'signage-dubai',
  'light-box-signage-new'     => 'signage-dubai',
  'safety-signage-new'        => 'signage-dubai',
  // Banners & Large Format
  'banners-large-format-new'  => 'banners-printing',
  'vinyl-banners-new'         => 'banners-printing',
  'pull-up-banners-new'       => 'flex-banner-printing-dubai',
  'frame-banners-new'         => 'flex-banner-printing-dubai',
  'large-format-posters-new'  => 'banners-printing',
  'canvas-prints-new'         => 'banners-printing',
  'backdrops-new'             => 'backdrop-display-dubai',
  // Stickers & Branding
  'stickers-branding-new'     => 'sticker-printing-dubai',
  'sticker-printing-new'      => 'sticker-printing-dubai',
  'window-graphics-new'       => 'sticker-printing-dubai',
  'wall-graphics-new'         => 'sticker-printing-dubai',
  'floor-graphics-new'        => 'sticker-printing-dubai',
  'seals-stamps-new'          => 'sticker-printing-dubai',
  'magnets-new'               => 'sticker-printing-dubai',
  // Flags
  'flags-outdoor-new'         => 'flags-printing-dubai',
  'feather-sail-flags-new'    => 'flags-printing-dubai',
  'tear-drop-flags-new'       => 'flags-printing-dubai',
  'table-conference-flags-new'=> 'flags-printing-dubai',
  'decorative-flags-new'      => 'flags-printing-dubai',
  'flag-accessories-new'      => 'flags-printing-dubai',
  // Vehicle Branding
  'vehicle-branding-new'      => 'vehicle-branding',
  'car-van-branding-new'      => 'vehicle-branding',
  'fleet-branding-new'        => 'vehicle-branding',
  'marine-branding-new'       => 'vehicle-branding',
  // Exhibitions & Events
  'exhibitions-events-new'    => 'exhibition-event-management',
  'exhibition-stands-new'     => 'exhibition-event-management',
  'popup-displays-new'        => 'exhibition-event-management',
  'event-backdrops-new'       => 'backdrop-display-dubai',
  'event-accessories-new'     => 'exhibition-event-management',
  // Promotional & Corporate Gifts
  'promotional-gifts-new'     => 'promotional-gifts-dubai',
  'branded-apparel-new'       => 'promotional-gifts-dubai',
  'bags-accessories-new'      => 'promotional-gifts-dubai',
  'drinkware-new'             => 'promotional-gifts-dubai',
  'office-desktop-gifts-new'  => 'promotional-gifts-dubai',
  'tech-products-new'         => 'promotional-gifts-dubai',
  'executive-kits-new'        => 'promotional-gifts-dubai',
  'packaging-gifts-new'       => 'plastic-bags-printing',
];

$remap_slug = isset( $_slug_remap[ $pp_cat_slug ] ) ? $_slug_remap[ $pp_cat_slug ] : $pp_cat_slug;
$cfg = isset( $_pp_cats[ $remap_slug ] ) ? $_pp_cats[ $remap_slug ] : $cfg;
if ( empty( $short_desc ) ) $short_desc = $cfg['tagline'];

/* Related products query */
$pp_cat_ids    = wp_get_object_terms( $pp_id, 'product_cat', [ 'fields' => 'ids' ] );
$related_query = new WP_Query( [
  'post_type'      => 'product',
  'post_status'    => 'publish',
  'posts_per_page' => 3,
  'orderby'        => 'rand',
  'tax_query'      => [ [ 'taxonomy' => 'product_cat', 'field' => 'id', 'terms' => $pp_cat_ids ] ],
  'post__not_in'   => [ $pp_id ],
] );
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=Unbounded:wght@400;500;600;700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/premium-product.css?v=1.0">

<!-- Schema Markup -->
<script type="application/ld+json">
[{"@context":"https://schema.org","@type":"Product",
  "name":"<?php echo esc_js( $pp_title ); ?> Dubai",
  "url":"<?php echo esc_url( $pp_url ); ?>",
  <?php if ( ! empty( $gallery ) ) : ?>"image":"<?php echo esc_url( $gallery[0]['url'] ); ?>",<?php endif; ?>
  "description":"<?php echo esc_js( substr( wp_strip_all_tags( $short_desc ), 0, 300 ) ); ?>",
  "brand":{"@type":"Brand","name":"Efficient Advertising LLC"},
  "offers":{"@type":"Offer","priceCurrency":"AED","availability":"https://schema.org/InStock","url":"<?php echo esc_url( $pp_url ); ?>","seller":{"@type":"Organization","name":"Efficient Advertising LLC"}}
},
{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[
  {"@type":"ListItem","position":1,"name":"Home","item":"<?php echo esc_url( home_url('/') ); ?>"},
  {"@type":"ListItem","position":2,"name":"<?php echo esc_js( $pp_cat_name ); ?>","item":"<?php echo esc_url( $pp_cat_url ); ?>"},
  {"@type":"ListItem","position":3,"name":"<?php echo esc_js( $pp_title ); ?>"}
]},
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
  <?php foreach ( $cfg['faq'] as $fi => $faq ) : ?>
  {"@type":"Question","name":"<?php echo esc_js( $faq['q'] ); ?>","acceptedAnswer":{"@type":"Answer","text":"<?php echo esc_js( $faq['a'] ); ?>"}}<?php echo ( $fi < count( $cfg['faq'] ) - 1 ) ? ',' : ''; ?>
  <?php endforeach; ?>
]}]
</script>

<div id="ea-pp-wrap" class="ea-pp">

<!-- ═══ BREADCRUMB ═══ -->
<section id="ea-pp-breadcrumb">
  <div class="container">
    <ol class="ea-breadcrumb">
      <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
      <li><span class="sep">›</span></li>
      <li><a href="<?php echo esc_url( $pp_cat_url ); ?>"><?php echo esc_html( $pp_cat_name ); ?></a></li>
      <li><span class="sep">›</span></li>
      <li class="active"><?php echo esc_html( $pp_title ); ?></li>
    </ol>
  </div>
</section>

<!-- ═══ HERO: Gallery + Config ═══ -->
<section id="ea-pp-hero">
  <div class="container">
    <div class="ea-pp-hero-grid">

      <!-- Gallery Column -->
      <div class="reveal">
        <?php if ( ! empty( $gallery ) ) : ?>
        <div class="ea-pp-main-img" id="eaPPMainImg">
          <img src="<?php echo esc_url( $gallery[0]['url'] ); ?>" alt="<?php echo $gallery[0]['alt']; ?>" id="eaPPMainImgEl" loading="eager">
          <button class="ea-pp-zoom-btn" aria-label="Zoom image">
            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
          </button>
        </div>
        <?php if ( count( $gallery ) > 1 ) : ?>
        <div class="ea-pp-thumbs">
          <?php foreach ( $gallery as $gi => $img ) : ?>
          <div class="ea-pp-thumb<?php echo $gi === 0 ? ' active' : ''; ?>" data-src="<?php echo esc_url( $img['url'] ); ?>" data-alt="<?php echo esc_attr( $img['alt'] ); ?>">
            <img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo esc_attr( $img['alt'] ); ?>" loading="lazy">
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php else : ?>
        <div class="ea-pp-no-image">
          <svg viewBox="0 0 24 24" fill="none" stroke="#1A1A2E" stroke-width="1" width="64" height="64"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
          <span>Product image coming soon</span>
        </div>
        <?php endif; ?>
      </div>

      <!-- Config Column -->
      <div class="reveal">
        <div class="ea-pp-category-pill"><?php echo esc_html( $pp_cat_name ); ?></div>
        <h1 class="ea-pp-title"><?php echo esc_html( $pp_title ); ?></h1>
        <p class="ea-pp-short-desc"><?php echo esc_html( $short_desc ); ?></p>

        <!-- Spec Badges -->
        <div class="ea-pp-spec-badges">
          <?php foreach ( $cfg['badges'] as $badge ) : ?>
          <div class="ea-pp-badge">
            <span class="ea-pp-badge-label"><?php echo esc_html( $badge['label'] ); ?></span>
            <span class="ea-pp-badge-value"><?php echo esc_html( $badge['value'] ); ?></span>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Config Panel -->
        <div class="ea-pp-config">
          <div class="ea-pp-config-title">Request a Quote</div>

          <div class="ea-pp-qty-row">
            <span class="ea-pp-qty-label">Qty</span>
            <div class="ea-pp-qty-wrap">
              <button class="ea-pp-qty-btn" id="eaPPQtyMinus" aria-label="Decrease">−</button>
              <input class="ea-pp-qty-num" type="number" id="eaPPQtyNum" value="1" min="1" max="99" aria-label="Quantity">
              <button class="ea-pp-qty-btn" id="eaPPQtyPlus" aria-label="Increase">+</button>
            </div>
          </div>
        </div>

        <!-- CTA Row -->
        <div class="ea-pp-cta-row">
          <a href="<?php echo esc_url( $contact_url ); ?>" class="btn-amber-solid">
            <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
            Get a Quote
          </a>
          <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_text; ?>" class="btn-green-solid" target="_blank" rel="noopener">
            <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            WhatsApp
          </a>
        </div>

        <!-- Trust line -->
        <div class="ea-pp-trust">
          <div class="ea-pp-trust-item">
            <div class="trust-ico"><svg viewBox="0 0 24 24" width="13" height="13"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
            UAE-Wide
          </div>
          <div class="ea-pp-trust-item">
            <div class="trust-ico"><svg viewBox="0 0 24 24" width="13" height="13"><path d="M5 12l5 5L20 7"/></svg></div>
            In-House Production
          </div>
          <div class="ea-pp-trust-item">
            <div class="trust-ico"><svg viewBox="0 0 24 24" width="13" height="13"><path d="M12 1l3.09 6.26L22 8.27l-5 4.87 1.18 6.88L12 16.77l-6.18 3.25L7 13.14 2 8.27l6.91-1.01L12 1z"/></svg></div>
            18+ Years
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ═══ TRUST BAR ═══ -->
<section id="ea-pp-trust-bar">
  <div class="container">
    <div class="ea-pp-trust-bar-inner">
      <div class="ea-pp-trust-item"><div class="trust-ico"><svg viewBox="0 0 24 24" width="13" height="13"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div> UAE-Wide Coverage</div>
      <div class="ea-pp-trust-item"><div class="trust-ico"><svg viewBox="0 0 24 24" width="13" height="13"><path d="M5 12l5 5L20 7"/></svg></div> In-House Production</div>
      <div class="ea-pp-trust-item"><div class="trust-ico"><svg viewBox="0 0 24 24" width="13" height="13"><path d="M12 1l3.09 6.26L22 8.27l-5 4.87 1.18 6.88L12 16.77l-6.18 3.25L7 13.14 2 8.27l6.91-1.01L12 1z"/></svg></div> 18+ Years Experience</div>
      <div class="ea-pp-trust-item"><div class="trust-ico"><svg viewBox="0 0 24 24" width="13" height="13"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></div> 500+ Projects Delivered</div>
    </div>
  </div>
</section>

<!-- ═══ FEATURES ═══ -->
<section id="ea-pp-features">
  <div class="container">
    <div class="ea-pp-features-header reveal">
      <div class="sec-label">Why Choose Us</div>
      <h2>Why <?php echo esc_html( $pp_title ); ?> From Efficient?</h2>
      <p>Quality, speed, and service — here's what sets our <?php echo esc_html( strtolower( $pp_cat_name ) ); ?> apart.</p>
    </div>
    <div class="ea-pp-features-grid">
      <?php foreach ( $cfg['features'] as $feat ) : ?>
      <div class="ea-pp-feature-card reveal">
        <div class="ea-pp-feature-ico"><i class="fa-solid <?php echo esc_attr( $feat['icon'] ); ?>"></i></div>
        <h4><?php echo esc_html( $feat['title'] ); ?></h4>
        <p><?php echo esc_html( $feat['desc'] ); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══ SPECS (Tabbed) ═══ -->
<section id="ea-pp-specs">
  <div class="container">
    <div class="ea-pp-specs-inner">
      <div class="ea-pp-specs-header reveal">
        <div class="sec-label">Technical Details</div>
        <h2><?php echo esc_html( $pp_title ); ?> — Specifications</h2>
        <p>Full technical details for your <?php echo esc_html( strtolower( $pp_title ) ); ?> from Efficient Advertising Dubai.</p>
      </div>

      <?php if ( count( $cfg['specs'] ) > 1 ) : ?>
      <div class="ea-pp-tabs reveal" role="tablist">
        <?php foreach ( $cfg['specs'] as $si => $spec_tab ) : ?>
        <button class="ea-pp-tab<?php echo $si === 0 ? ' active' : ''; ?>" role="tab" data-tab="spec-<?php echo $si; ?>" aria-selected="<?php echo $si === 0 ? 'true' : 'false'; ?>"><?php echo esc_html( $spec_tab['tab'] ); ?></button>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <?php foreach ( $cfg['specs'] as $si => $spec_tab ) : ?>
      <div class="ea-pp-tab-panel<?php echo $si === 0 ? ' active' : ''; ?> reveal" id="tab-spec-<?php echo $si; ?>" role="tabpanel">
        <table class="ea-pp-spec-table">
          <tbody>
            <?php foreach ( $spec_tab['rows'] as $row ) : ?>
            <tr><td><?php echo esc_html( $row[0] ); ?></td><td><?php echo esc_html( $row[1] ); ?></td></tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══ HOW TO ORDER + ARTWORK ═══ -->
<section id="ea-pp-artwork">
  <div class="container">
    <div class="ea-pp-hto-grid">
      <div class="ea-pp-hto-left reveal">
        <div class="sec-label">Simple Process</div>
        <h2>How to Order</h2>
        <p>From inquiry to delivered — here's exactly what happens after you reach out.</p>
        <div class="ea-pp-steps">
          <div class="ea-pp-step">
            <div class="ea-pp-step-num">01</div>
            <div class="ea-pp-step-body">
              <h4>Send Us Your Brief</h4>
              <p>Share your requirements — size, quantity, material, and deadline. WhatsApp or email.</p>
            </div>
          </div>
          <div class="ea-pp-step">
            <div class="ea-pp-step-num">02</div>
            <div class="ea-pp-step-body">
              <h4>Receive a Quotation</h4>
              <p>We respond within 2 hours with a detailed quote including delivery costs.</p>
            </div>
          </div>
          <div class="ea-pp-step">
            <div class="ea-pp-step-num">03</div>
            <div class="ea-pp-step-body">
              <h4>Approve Artwork Proof</h4>
              <p>Upload your print file or send your logo — we create a free layout proof for your sign-off.</p>
            </div>
          </div>
          <div class="ea-pp-step">
            <div class="ea-pp-step-num">04</div>
            <div class="ea-pp-step-body">
              <h4>We Produce &amp; Deliver</h4>
              <p>In-house production, quality checked, and delivered to your door across the UAE.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="reveal">
        <div class="ea-pp-artwork-card">
          <div class="sec-label">Artwork Upload</div>
          <h3>Send Your Print File</h3>
          <p>Share your artwork via WhatsApp, WeTransfer, or email. Not ready? Send your logo and we'll create a layout — no extra charge.</p>
          <div class="ea-pp-file-specs">
            <div class="ea-pp-file-spec"><span class="fs-label">Format</span><span class="fs-val">PDF / AI / PSD</span></div>
            <div class="ea-pp-file-spec"><span class="fs-label">Resolution</span><span class="fs-val">150 dpi min</span></div>
            <div class="ea-pp-file-spec"><span class="fs-label">Colour Mode</span><span class="fs-val">CMYK</span></div>
            <div class="ea-pp-file-spec"><span class="fs-label">Bleed</span><span class="fs-val">30 mm</span></div>
          </div>
          <div class="ea-pp-artwork-actions">
            <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I want to send artwork for: ' . $pp_title ); ?>" class="btn-green-solid" target="_blank" rel="noopener">
              <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              Send via WhatsApp
            </a>
            <a href="mailto:info@efficientadvt.com?subject=<?php echo rawurlencode( 'Artwork for ' . $pp_title ); ?>" class="btn-outline-dark">
              <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
              Email Artwork
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══ RELATED PRODUCTS (Unified Card System) ═══ -->
<?php if ( $related_query->have_posts() ) : ?>
<section id="ea-pp-related">
  <div class="container">
    <div class="ea-pp-related-header reveal">
      <div>
        <div class="sec-label">Related Products</div>
        <h2>More From <?php echo esc_html( $pp_cat_name ); ?></h2>
      </div>
      <a href="<?php echo esc_url( $pp_cat_url ); ?>" class="ea-pp-related-see-all">
        View All
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
    <div class="ea-pp-card-grid">
      <?php while ( $related_query->have_posts() ) : $related_query->the_post();
        $rel_cat_terms = get_the_terms( get_the_ID(), 'product_cat' );
        $rel_cat_name  = ( $rel_cat_terms && ! is_wp_error( $rel_cat_terms ) ) ? reset( $rel_cat_terms )->name : '';
        $rel_excerpt   = get_the_excerpt();
        if ( empty( $rel_excerpt ) ) $rel_excerpt = wp_trim_words( get_the_content(), 15, '…' );
      ?>
      <a href="<?php the_permalink(); ?>" class="ea-product-card reveal">
        <div class="ea-product-card__img">
          <?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'medium_large', [ 'alt' => get_the_title() . ' Dubai', 'loading' => 'lazy' ] ); else : ?>
          <div class="ea-product-card__placeholder"><svg viewBox="0 0 24 24" fill="none" stroke="#1A1A2E" stroke-width="1" width="48" height="48"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg></div>
          <?php endif; ?>
        </div>
        <div class="ea-product-card__body">
          <?php if ( $rel_cat_name ) : ?><span class="ea-product-card__cat"><?php echo esc_html( $rel_cat_name ); ?></span><?php endif; ?>
          <h4><?php the_title(); ?></h4>
          <p><?php echo esc_html( wp_trim_words( $rel_excerpt, 12, '…' ) ); ?></p>
          <span class="ea-product-card__cta">View Product <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="13" height="13"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </div>
      </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ═══ REVIEWS ═══ -->
<section id="ea-pp-reviews">
  <div class="container">
    <div class="reveal" style="text-align:center; margin-bottom:48px;">
      <div class="sec-label">Customer Reviews</div>
      <h2>What Our Clients Say</h2>
      <p>Real feedback from businesses and individuals across the UAE.</p>
    </div>
    <div class="reveal">
      <?php echo do_shortcode('[trustindex no-registration=google]'); ?>
    </div>
  </div>
</section>

<!-- ═══ FAQ ═══ -->
<section id="ea-pp-faq">
  <div class="container">
    <div class="ea-pp-faq-grid">
      <div class="reveal">
        <div class="sec-label">FAQ</div>
        <h2>Frequently Asked Questions</h2>
        <p>Common questions about <?php echo esc_html( strtolower( $pp_title ) ); ?> in Dubai.</p>
        <a href="<?php echo home_url('/contact-us/'); ?>" class="btn-outline-dark" style="margin-top:8px;">More Questions? Ask Us</a>
      </div>
      <div class="reveal">
        <?php foreach ( $cfg['faq'] as $fi => $faq ) : ?>
        <div class="ea-pp-acc-item">
          <button class="ea-pp-acc-trigger" aria-expanded="false">
            <span class="ea-pp-acc-q"><?php echo esc_html( $faq['q'] ); ?></span>
            <span class="ea-pp-acc-icon"><svg viewBox="0 0 24 24" width="14" height="14"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
          </button>
          <div class="ea-pp-acc-body">
            <p class="ea-pp-acc-answer"><?php echo esc_html( $faq['a'] ); ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ═══ CTA STRIP ═══ -->
<section id="ea-pp-cta">
  <div class="container">
    <div class="ea-pp-cta-inner reveal">
      <div class="sec-label-dark">Get Started Today</div>
      <h2>Ready to Order Your<br><?php echo esc_html( $pp_title ); ?>?</h2>
      <p>Tell us your requirements — we'll have a quote ready within 2 hours. Delivery across the UAE.</p>
      <div class="ea-pp-cta-btns">
        <a href="<?php echo esc_url( $contact_url ); ?>" class="btn-amber-solid">
          <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
          Request a Quote
        </a>
        <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_text; ?>" class="btn-outline-amber" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          WhatsApp Us
        </a>
        <a href="tel:+971527966265" class="btn-outline-white">
          <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
          +971 52 796 6265
        </a>
      </div>
      <p class="ea-pp-cta-note">No minimum order · UAE-wide delivery · Free artwork support</p>
    </div>
  </div>
</section>

</div><!-- /#ea-pp-wrap -->

<!-- WhatsApp Float -->
<a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_text; ?>"
   target="_blank" rel="noopener" aria-label="Chat on WhatsApp" class="ea-pp-wa-float">
  <svg viewBox="0 0 24 24" fill="#fff" width="28" height="28"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>

<!-- Sticky Mobile Bar -->
<div class="ea-pp-sticky-bar" role="navigation" aria-label="Quick actions">
  <a href="tel:+971527966265" class="ea-pp-sticky-btn ea-pp-sticky-call">
    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
    Call
  </a>
  <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_text; ?>" class="ea-pp-sticky-btn ea-pp-sticky-wa" target="_blank" rel="noopener">
    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    WhatsApp
  </a>
  <a href="<?php echo esc_url( $contact_url ); ?>" class="ea-pp-sticky-btn ea-pp-sticky-quote">
    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
    Quote
  </a>
</div>

<!-- Quote Modal -->
<div class="ea-modal-overlay" id="eaPPModal" style="display:none">
  <div class="ea-modal-box">
    <div class="ea-modal-header">
      <h3><svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg> Get a Free Quote</h3>
      <button class="ea-modal-close" onclick="document.getElementById('eaPPModal').style.display='none'" aria-label="Close">✕</button>
    </div>
    <div class="ea-modal-body">
      <form class="ea-quote-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="submit_product_order">
        <?php wp_nonce_field( 'product_order_nonce', 'order_nonce' ); ?>
        <input type="hidden" name="product_name" value="<?php echo esc_attr( $pp_title ); ?>">
        <div class="ea-form-row">
          <div class="ea-form-group"><label for="ppName">Full Name *</label><input type="text" id="ppName" name="order_name" required placeholder="Your full name"></div>
          <div class="ea-form-group"><label for="ppEmail">Email *</label><input type="email" id="ppEmail" name="order_email" required placeholder="your@email.com"></div>
        </div>
        <div class="ea-form-row">
          <div class="ea-form-group"><label for="ppPhone">Phone / WhatsApp *</label><input type="tel" id="ppPhone" name="order_phone" required placeholder="+971 50 123 4567"></div>
          <div class="ea-form-group"><label for="ppCo">Company</label><input type="text" id="ppCo" name="order_company" placeholder="Your company"></div>
        </div>
        <div class="ea-form-group"><label for="ppMsg">Requirements</label><textarea id="ppMsg" name="order_message" rows="4" placeholder="Size, quantity, material, deadline..."></textarea></div>
        <button type="submit" class="ea-form-submit"><svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg> Send Quote Request</button>
      </form>
    </div>
  </div>
</div>

<!-- Lightbox -->
<div class="ea-pp-lightbox" id="eaPPLightbox" style="display:none" onclick="this.style.display='none'">
  <button class="ea-pp-lb-close" onclick="event.stopPropagation();document.getElementById('eaPPLightbox').style.display='none'" aria-label="Close">✕</button>
  <img id="eaPPLightboxImg" src="" alt="Product image">
</div>

<!-- ═══ JAVASCRIPT ═══ -->
<script>
(function(){
  /* Scroll Reveal */
  var revEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    var obs = new IntersectionObserver(function(entries){
      entries.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('visible'); obs.unobserve(e.target); } });
    }, {threshold: 0.12});
    revEls.forEach(function(el){ obs.observe(el); });
  } else {
    revEls.forEach(function(el){ el.classList.add('visible'); });
  }

  /* Thumbnail Gallery */
  var thumbs = document.querySelectorAll('.ea-pp-thumb');
  var mainImg = document.getElementById('eaPPMainImgEl');
  if (thumbs.length && mainImg) {
    thumbs.forEach(function(t){
      t.addEventListener('click', function(){
        thumbs.forEach(function(x){ x.classList.remove('active'); });
        t.classList.add('active');
        mainImg.src = t.dataset.src;
        mainImg.alt = t.dataset.alt || '';
      });
    });
  }

  /* Lightbox */
  var mainWrap = document.getElementById('eaPPMainImg');
  if (mainWrap) {
    mainWrap.addEventListener('click', function(){
      var lb = document.getElementById('eaPPLightbox');
      var li = document.getElementById('eaPPLightboxImg');
      if (mainImg) { li.src = mainImg.src; li.alt = mainImg.alt; }
      lb.style.display = 'flex';
    });
  }

  /* Quantity */
  var qtyNum = document.getElementById('eaPPQtyNum');
  var qtyMinus = document.getElementById('eaPPQtyMinus');
  var qtyPlus = document.getElementById('eaPPQtyPlus');
  if (qtyNum && qtyMinus && qtyPlus) {
    qtyMinus.addEventListener('click', function(){ var v = parseInt(qtyNum.value, 10); if (v > 1) qtyNum.value = v - 1; });
    qtyPlus.addEventListener('click', function(){ var v = parseInt(qtyNum.value, 10); if (v < 99) qtyNum.value = v + 1; });
  }

  /* Spec Tabs */
  var tabs = document.querySelectorAll('.ea-pp-tab');
  var tabPanels = document.querySelectorAll('.ea-pp-tab-panel');
  tabs.forEach(function(tab){
    tab.addEventListener('click', function(){
      tabs.forEach(function(t){ t.classList.remove('active'); t.setAttribute('aria-selected','false'); });
      tabPanels.forEach(function(p){ p.classList.remove('active'); });
      tab.classList.add('active');
      tab.setAttribute('aria-selected','true');
      var target = document.getElementById('tab-' + tab.dataset.tab);
      if (target) target.classList.add('active');
    });
  });

  /* FAQ Accordion */
  var accItems = document.querySelectorAll('.ea-pp-acc-item');
  accItems.forEach(function(item){
    var trigger = item.querySelector('.ea-pp-acc-trigger');
    if (!trigger) return;
    trigger.addEventListener('click', function(){
      var isOpen = item.classList.contains('open');
      accItems.forEach(function(i){ i.classList.remove('open'); var t = i.querySelector('.ea-pp-acc-trigger'); if(t) t.setAttribute('aria-expanded','false'); });
      if (!isOpen) { item.classList.add('open'); trigger.setAttribute('aria-expanded','true'); }
    });
  });

  /* Modal */
  document.addEventListener('click', function(e){ if (e.target && e.target.id === 'eaPPModal') e.target.style.display = 'none'; });
  document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') {
      var m = document.getElementById('eaPPModal'); var l = document.getElementById('eaPPLightbox');
      if (m) m.style.display = 'none'; if (l) l.style.display = 'none';
    }
  });

  /* Header Offset */
  function eaPPOffset() {
    var hdr = document.getElementById('header');
    var wrap = document.getElementById('ea-pp-wrap');
    if (hdr && wrap) wrap.style.marginTop = hdr.offsetHeight + 'px';
  }
  eaPPOffset();
  window.addEventListener('resize', eaPPOffset);
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(eaPPOffset);
})();
</script>

<?php get_footer(); ?>
