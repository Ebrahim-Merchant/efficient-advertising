<?php
/**
 * The template for displaying product category archives
 * Enhanced with full SEO + UI/UX treatment — per-category content, schema, hero, FAQ
 *
 * @package Efficient_Modern
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Header moved to line ~218

// =====================================================================
// SETUP
// =====================================================================
$term          = get_queried_object();
$term_slug     = $term->slug ?? '';
$term_name     = $term->name ?? 'Products';
$term_description = $term->description ?? '';
$term_url      = get_term_link( $term );
$wa_num        = '971527966265';

// =====================================================================
// PER-CATEGORY CONTENT DATA
// =====================================================================
$cat_data = [
    'backdrop-display-dubai' => [
        'h1'    => 'Backdrops &amp; Displays Printing Dubai',
        'sub'   => 'Custom fabric backdrops, pop-up displays, standees, step-and-repeat &amp; wooden backdrop printing — in-house production with same-day delivery across Dubai &amp; UAE.',
        'intro' => 'Efficient Advertising LLC is Dubai\'s premier provider of backdrops and display solutions for events, exhibitions, and retail. From step-and-repeat photo backdrops for red-carpet events to fabric pop-up displays for trade shows and eye-catching standees for store promotions — our in-house facility produces vibrant, high-resolution results with fast turnaround.',
        'faqs'  => [
            ['q' => 'What backdrop sizes are available?', 'a' => 'We print backdrops in any custom size — from 1&times;1m up to 10m wide and beyond. Common event sizes are 8&times;10ft and 10&times;12ft. Same-day production available for standard sizes.'],
            ['q' => 'What materials do you use for backdrop printing?', 'a' => 'We print on knitted polyester fabric (wrinkle-free, ideal for events), vinyl, and canvas. Fabric is preferred for step-and-repeat, photo backdrops, and pop-up displays.'],
            ['q' => 'How quickly can I get a custom backdrop in Dubai?', 'a' => 'Same-day and next-day production is available for most standard sizes. WhatsApp us in the morning for same-day collection from our Dubai facility.'],
            ['q' => 'Do you deliver and install backdrops across the UAE?', 'a' => 'Yes &mdash; we deliver to Dubai, Abu Dhabi, Sharjah, Ajman, Fujairah, Ras Al Khaimah, and all UAE emirates. Installation services available in Dubai.'],
        ],
    ],
    'flex-banner-printing-dubai' => [
        'h1'    => 'Flex Banner Printing Dubai, UAE',
        'sub'   => 'High-resolution flex banners, roll-up banners, X-banners &amp; fence banners — fast in-house printing in Dubai &amp; UAE.',
        'intro' => 'From roll-up banners for corporate exhibitions to large outdoor flex banners for storefronts and events, Efficient Advertising provides professional flex banner printing in Dubai. Our wide-format printers deliver sharp, vibrant prints on durable materials suited for both indoor and outdoor use — with same-day options available.',
        'faqs'  => [
            ['q' => 'What is the difference between a roll-up and X-banner?', 'a' => 'Roll-up banners retract into a base unit for easy transport and storage. X-banners use a lightweight X-shaped stand. Both are ideal for exhibitions, conferences, and retail displays.'],
            ['q' => 'What is the maximum flex banner size you can print?', 'a' => 'Our wide-format printers handle banners up to 5 meters wide, any length. Seamless joining available for extra-large installations.'],
            ['q' => 'Can I get same-day banner printing in Dubai?', 'a' => 'Yes! Same-day printing is available for standard sizes with print-ready artwork. Send your file via WhatsApp for an instant turnaround confirmation.'],
            ['q' => 'What file format should I send for banner printing?', 'a' => 'We accept print-ready PDF, AI, EPS, and high-res JPG/PNG. Our design team can also create or modify your artwork free of charge with any order.'],
        ],
    ],
    'flags-printing-dubai' => [
        'h1'    => 'Flag Printing Dubai, UAE',
        'sub'   => 'Custom teardrop flags, feather flags, car flags, table flags &amp; hoisting flags — dye sublimation, any size, same-day available in Dubai.',
        'intro' => 'Efficient Advertising is one of Dubai\'s leading flag printing specialists. We offer full-color dye sublimation printing on teardrop, feather, L-shaped, car, table, hoisting, telescopic, pennant, conference, and wall-mounted flags. All flags come complete with poles, bases, and carry bags — ideal for outdoor events, exhibitions, and corporate promotions across the UAE.',
        'faqs'  => [
            ['q' => 'What types of custom flags can you print in Dubai?', 'a' => 'Teardrop, feather, L-shape, car, table, hoisting, telescopic, pennant, conference, and wall-mounted flags — all in full-color dye sublimation, any size.'],
            ['q' => 'What material are custom flags printed on?', 'a' => '110g knitted polyester printed via dye sublimation for vibrant, fade-resistant colors. Lightweight, wind-resistant, and washable for a long outdoor life.'],
            ['q' => 'Do you supply flags with poles and bases?', 'a' => 'Yes — all flag kits include poles, ground stake, water-fill or cross base, and a carry bag. Flexible fiberglass and aluminum poles available.'],
            ['q' => 'What is the minimum order quantity for custom flags?', 'a' => 'We accept single-unit orders. Bulk pricing available for 10+ units. WhatsApp us for an instant quote on your required size and quantity.'],
        ],
    ],
    'stationery-printing-dubai' => [
        'h1'    => 'Stationery Printing Dubai, UAE',
        'sub'   => 'Business cards, letterheads, envelopes, notepads, folders, NCR books, rubber stamps &amp; ID cards — premium corporate stationery for Dubai businesses.',
        'intro' => 'First impressions matter. Efficient Advertising prints premium corporate stationery for Dubai businesses of all sizes. From thick, matte-laminated business cards and branded letterheads to custom notepads, NCR carbonless receipt books, and professional rubber stamps — we ensure every touchpoint represents your brand at its best.',
        'faqs'  => [
            ['q' => 'What stationery items can you print in Dubai?', 'a' => 'Business cards, letterheads, envelopes, folders, notepads, NCR books (2-part &amp; 3-part), lanyard &amp; ID cards, flyers, brochures, rubber stamps, and seal makers.'],
            ['q' => 'What is the minimum order for business cards in Dubai?', 'a' => 'Minimum order is 100 business cards. Available in 250, 500, and 1,000+ with volume discounts. UV coating, matte lamination, and soft-touch finishes all available.'],
            ['q' => 'Can you design our stationery?', 'a' => 'Yes — our in-house design team provides free artwork setup on all stationery orders. Share your logo and brand guidelines and we\'ll handle the rest.'],
            ['q' => 'Do you print NCR (carbonless copy) books?', 'a' => 'Yes. We print 2-part and 3-part NCR books in A4, A5, and custom sizes for receipts, invoices, order forms, and delivery notes.'],
        ],
    ],
    'sticker-printing-dubai' => [
        'h1'    => 'Sticker Printing Dubai, UAE',
        'sub'   => 'Vinyl stickers, PVC stickers, wall stickers, glass stickers, foam board &amp; forex board printing — cut-to-shape, any size in Dubai.',
        'intro' => 'Efficient Advertising provides precision sticker and board printing in Dubai. From custom-cut vinyl stickers and clear glass decals to large wall graphics and rigid foam board displays — our in-house printing facility delivers sharp, durable results for retail, events, and office interiors across the UAE.',
        'faqs'  => [
            ['q' => 'What types of stickers do you print in Dubai?', 'a' => 'Vinyl stickers (die-cut &amp; sheet), PVC stickers, wall stickers, glass/window stickers, car stickers, floor stickers, and custom-shape stickers in indoor and outdoor grades.'],
            ['q' => 'What is the difference between foam board and forex board?', 'a' => 'Foam board (foamex) is lightweight, ideal for indoor displays and POS. Forex (PVC board) is denser, waterproof, and suited for outdoor signage and long-term use.'],
            ['q' => 'Can you cut stickers to any custom shape?', 'a' => 'Yes — we offer die-cut stickers to any shape: circles, squares, custom outlines, and kiss-cut sticker sheets. Share your design and we\'ll produce exactly what you need.'],
            ['q' => 'Do you install wall stickers in offices in Dubai?', 'a' => 'Yes. We print and install wall stickers, vinyl murals, and large-format wall graphics for offices, retail shops, and hospitality venues across Dubai and the UAE.'],
        ],
    ],
    'signage-dubai' => [
        'h1'    => 'Signage Company Dubai, UAE',
        'sub'   => '3D signage, acrylic signage, backlit signs &amp; office reception signage — fabricated and installed across Dubai &amp; UAE.',
        'intro' => 'Efficient Advertising is a leading signage company in Dubai offering custom 3D lettering, acrylic signs, backlit boards, and office reception signage. Our fabrication team manages everything from design to production and installation — ensuring your brand is represented professionally in every space.',
        'faqs'  => [
            ['q' => 'What types of signage do you make in Dubai?', 'a' => '3D acrylic letters, illuminated backlit signs, reception wall signage, ACP boards, toblerone signs, directional wayfinding, and custom office branding.'],
            ['q' => 'Do you provide signage installation in Dubai?', 'a' => 'Yes — our team installs across all of Dubai and the UAE: office receptions, shop fronts, mall kiosks, building facades, and high-rise exteriors.'],
            ['q' => 'What is the turnaround time for custom signage?', 'a' => 'Simple flat signage: 2–3 business days. 3D or illuminated signage: 5–10 business days. Rush orders available — WhatsApp us for details.'],
            ['q' => 'Can I get acrylic letters for my office reception?', 'a' => 'Absolutely — we specialise in acrylic reception signage: laser-cut 3D letters, frosted panels, backlit logos, and full reception wall branding in any size and colour.'],
        ],
    ],
    'promotional-gifts-dubai' => [
        'h1'    => 'Promotional Items &amp; Corporate Gifts Dubai',
        'sub'   => 'Branded USB drives, pens, mugs &amp; custom corporate gifts — quality promotional products for Dubai businesses, events &amp; trade shows.',
        'intro' => 'Efficient Advertising supplies branded promotional items and corporate gift solutions for UAE businesses and events. From branded USB drives and gift sets for corporate clients to event giveaways and trade show merchandise — we help your brand make a memorable impression on every recipient.',
        'faqs'  => [
            ['q' => 'What promotional items can you brand in Dubai?', 'a' => 'USB drives, pens, notebooks, mugs, lanyards, tote bags, phone stands, keychains, power banks, and complete corporate gift sets. Custom items available on request.'],
            ['q' => 'What is the minimum order for promotional products?', 'a' => 'MOQs vary by product — typically 50–100 units for most items. Contact us for exact quantities and bulk pricing tailored to your requirements.'],
            ['q' => 'Can you help design the artwork for our promotional items?', 'a' => 'Yes — our design team provides free mockups for all promotional orders so you can approve exactly how your logo will look on each item before production.'],
            ['q' => 'How long does production take for branded promotional products?', 'a' => 'Most standard items are ready in 5–7 business days. Large quantity or fully custom items may take 10–14 days. Rush production available.'],
        ],
    ],
    'vehicle-branding' => [
        'h1'    => 'Vehicle Branding Dubai, UAE',
        'sub'   => 'Full car wrapping, partial vehicle branding, trade name branding &amp; fleet graphics — printed and installed in Dubai.',
        'intro' => 'Transform your vehicles into mobile billboards with Efficient Advertising\'s vehicle branding services in Dubai. We offer full-wrap vinyl installations, partial branding panels, trade name lettering, and large-scale fleet graphics for cars, vans, trucks, and heavy vehicles — all professionally installed at our Dubai facility.',
        'faqs'  => [
            ['q' => 'What vehicle branding options are available in Dubai?', 'a' => 'Full vehicle wraps, partial branding (doors/rear/bonnet), trade name cut-letter branding, and full fleet graphics for cars, vans, trucks, and buses.'],
            ['q' => 'How long does a vehicle wrap last in Dubai\'s climate?', 'a' => 'Premium cast vinyl wraps last 5–7 years with proper care. Calendered vinyl for partial branding lasts 3–5 years. All wraps are UV-resistant and weatherproof.'],
            ['q' => 'Does vehicle wrapping damage the original paint?', 'a' => 'Not at all — when installed and removed professionally. Vinyl wraps actually protect the original paintwork. Removal is clean with zero paint damage.'],
            ['q' => 'Do you handle fleet branding for multiple vehicles?', 'a' => 'Yes — we offer fleet branding packages for any number of vehicles with consistent brand application across the entire fleet. Contact us for fleet pricing.'],
        ],
    ],
    'plastic-bags-printing' => [
        'h1'    => 'Plastic Bag Printing Dubai, UAE',
        'sub'   => 'Custom printed plastic bags for retail, events &amp; corporate promotions — any quantity, full color, fast delivery across UAE.',
        'intro' => 'Efficient Advertising produces custom-printed plastic bags for retailers, event organisers, and corporate promotions across Dubai and the UAE. Choose from HDPE, LDPE, or non-woven PP bags in a range of sizes and handle styles, all printed in full colour with your logo and branding.',
        'faqs'  => [
            ['q' => 'What types of printed bags can you produce in Dubai?', 'a' => 'HDPE and LDPE plastic carry bags, non-woven PP bags, polythene bags, and custom packaging bags. Available in various sizes with patch, loop, or die-cut handles.'],
            ['q' => 'What is the minimum order for custom printed bags?', 'a' => 'Minimum order is typically 500 units for printed plastic bags. Contact us for exact MOQs based on your required size and specification.'],
            ['q' => 'Can you match our exact brand colours on the bags?', 'a' => 'Yes — we print in 1 to full-colour using flexographic or digital printing. CMYK process and Pantone spot colour matching both available.'],
            ['q' => 'Do you offer eco-friendly bag printing options?', 'a' => 'Yes — we offer non-woven PP bags and can source biodegradable or recycled alternatives. Contact us to discuss sustainable packaging solutions.'],
        ],
    ],
    'exhibition-event-management' => [
        'h1'    => 'Exhibition Stands &amp; Event Branding Dubai',
        'sub'   => 'Custom exhibition stands, event branding, event management &amp; tradeshow materials — complete solutions in Dubai &amp; across the UAE.',
        'intro' => 'Efficient Advertising provides end-to-end exhibition and event solutions in Dubai. From custom-built modular stands and shell-scheme branding to full event management, printed materials, and complete on-site execution at GITEX, Arab Health, Dubai Expo, and all major UAE tradeshows — we make your brand stand out.',
        'faqs'  => [
            ['q' => 'What exhibition stand types do you offer in Dubai?', 'a' => 'Modular stands, shell scheme branding, bespoke custom-built stands, portable fabric pop-up displays, and turnkey booth solutions for all major UAE trade shows.'],
            ['q' => 'Do you handle full event management in the UAE?', 'a' => 'Yes — we provide complete event management including venue coordination, branding, printed collateral, AV support, and on-site execution for corporate events across the UAE.'],
            ['q' => 'How far in advance should I book an exhibition stand?', 'a' => 'We recommend 4–6 weeks ahead for custom-built stands. Modular and portable solutions can be ready in 5–10 business days.'],
            ['q' => 'Can you brand a complete exhibition space?', 'a' => 'Yes — full-booth branding including wall graphics, hanging banners, counters, furniture wraps, floor graphics, and all printed collateral for a cohesive brand presence.'],
        ],
    ],
    'banners-printing' => [
        'h1'    => 'Banner Printing Dubai, UAE',
        'sub'   => 'Large-format banners, event banners, street banners &amp; custom banner printing — fast turnaround, vibrant quality in Dubai &amp; UAE.',
        'intro' => 'Efficient Advertising delivers professional banner printing services across Dubai and the UAE. From large outdoor vinyl banners for storefronts and events to indoor fabric banners and promotional signage — our wide-format printing facility ensures consistent quality with fast turnaround and competitive pricing for all banner types.',
        'faqs'  => [
            ['q' => 'What types of banners can you print in Dubai?', 'a' => 'Vinyl banners, fabric banners, mesh banners (for wind-exposed areas), PVC flex banners, pop-up banners, and custom-shape banners for indoor and outdoor use.'],
            ['q' => 'What is the maximum banner size you can print?', 'a' => 'Our wide-format printers handle banners up to 5 meters wide. Longer runs are seamlessly joined. We\'ve delivered banners for stadiums, malls, and building facades.'],
            ['q' => 'Can I get same-day banner printing in Dubai?', 'a' => 'Yes — same-day printing for standard sizes with print-ready artwork. Drop off your file or WhatsApp it in the morning for same-day collection from our Dubai facility.'],
            ['q' => 'Do you install banners after printing?', 'a' => 'Yes — we install banners at your location across Dubai and the UAE. We supply eyelets, ropes, and tensioning hardware as needed.'],
        ],
    ],
    'best-selling' => [
        'h1'    => 'Best Selling Printing Products in Dubai',
        'sub'   => 'Our most popular products — business cards, banners, flags, exhibition stands, wall stickers &amp; more. Trusted by 1,000+ UAE businesses.',
        'intro' => 'These are the printing and branding products most trusted by our Dubai clients. From premium business cards and teardrop event flags to full exhibition stands and custom wall graphics — our best sellers combine quality, competitive pricing, and fast turnaround to make them indispensable for UAE businesses of every size.',
        'faqs'  => [
            ['q' => 'What are the most popular printing products in Dubai?', 'a' => 'Our top sellers include business cards, teardrop flags, roll-up banners, exhibition stands, wall stickers, and flyers — staples for events, trade shows, and retail promotions.'],
            ['q' => 'What is the turnaround time for popular printing products?', 'a' => 'Most best-selling products are ready in 1–3 business days. Same-day printing available for banners, stickers, and business cards. WhatsApp us for urgent orders.'],
            ['q' => 'Can I order a bundle of printing products at a discount?', 'a' => 'Yes — we offer corporate printing packages combining business cards, letterheads, banners, and signage at discounted bundle rates. Contact us to build your package.'],
            ['q' => 'Do you deliver outside Dubai?', 'a' => 'Yes — we deliver to all UAE emirates: Abu Dhabi, Sharjah, Ajman, Fujairah, Ras Al Khaimah, and Umm Al Quwain. Gulf region exports available on request.'],
        ],
    ],
    'covid19-printing-services' => [
        'h1'    => 'Health &amp; Safety Signage Dubai',
        'sub'   => 'Health and safety awareness signage, printed materials &amp; branded displays for Dubai workplaces, retail &amp; events.',
        'intro' => 'Efficient Advertising provides professional health and safety awareness materials for workplaces, retail environments, and events in Dubai. From floor stickers and awareness banners to branded display stands and safety signage — we help your organisation communicate safety standards clearly and professionally.',
        'faqs'  => [
            ['q' => 'Do you print health and safety posters in Dubai?', 'a' => 'Yes — we print A3, A2, A1, and large-format health and safety posters, awareness banners, and display boards for offices, factories, construction sites, and retail spaces.'],
            ['q' => 'Can you brand sanitizer dispenser stands with our logo?', 'a' => 'Yes — we supply branded sanitizer dispenser stands with printed panel branding for corporate use. Available in floor-standing and wall-mounted configurations.'],
            ['q' => 'Do you supply floor distance stickers?', 'a' => 'Yes — we print and supply floor graphics in circles, footprints, arrows, and custom shapes. Anti-slip laminate available for safety compliance in commercial spaces.'],
            ['q' => 'How quickly can I get safety signage printed in Dubai?', 'a' => 'Same-day printing is available for standard safety signs with ready artwork. WhatsApp us for an immediate quote and turnaround confirmation.'],
        ],
    ],
    'large-format-printing-dubai' => [
        'h1'    => 'Large Format Printing Dubai — Wide Format Print Shop UAE',
        'sub'   => 'Building wraps, hoardings, wall murals, floor graphics and billboard printing — up to 5 metres wide in a single pass at our Dubai facility.',
        'intro' => 'Efficient Advertising LLC is Dubai\'s specialist wide format print shop. We operate high-resolution large-format printers capable of producing prints up to 5 metres wide on vinyl, mesh, fabric, backlit film, and rigid substrates. From large outdoor vinyl banners for storefronts to building wraps and hoardings — we ensure consistent quality with fast turnaround across the UAE.',
        'faqs'  => [
            ['q' => 'What is the maximum print width for large format printing?', 'a' => 'Our wide-format printers produce prints up to 5 metres wide in a single pass. For larger applications like building wraps or billboards, we produce multiple panels with seamless joins.'],
            ['q' => 'What resolution do you print large format graphics at?', 'a' => 'We print at 720–1440 DPI depending on viewing distance. For large-format graphics viewed from 3m+, 72–150 DPI produces excellent results.'],
            ['q' => 'Do you print on rigid substrates for large format work?', 'a' => 'Yes. We print directly onto foam board, PVC board, ACM (aluminium composite), and dibond for rigid large-format applications including hoardings.'],
            ['q' => 'Can you install wall murals in Dubai offices?', 'a' => 'Yes. We supply and install wall murals on removable vinyl or wallpaper across Dubai and UAE, handling everything from preparation to professional installation.'],
        ],
    ],
    'exhibition-stand-printing-dubai' => [
        'h1'    => 'Exhibition Stand Printing & Design Dubai',
        'sub'   => 'Custom exhibition stands, modular displays and event branding — professional fabrication and installation across all UAE trade shows.',
        'intro' => 'From custom-built modular stands to shell-scheme branding and portable fabric displays, Efficient Advertising provides complete exhibition solutions in Dubai. We handle design, printing, fabrication, and on-site installation at major venues including DWTC and ADNEC.',
        'faqs'  => [
            ['q' => 'What types of exhibition stands do you offer?', 'a' => 'We offer custom-built wood stands, modular aluminum systems, fabric pop-up displays, and magnetic pop-ups suited for all exhibition sizes.'],
            ['q' => 'How long does it take to produce an exhibition stand?', 'a' => 'Modular and portable stands take 3-5 days. Custom-built stands require 2-4 weeks for design and fabrication.'],
            ['q' => 'Do you provide delivery and installation at the venue?', 'a' => 'Yes, our team handles delivery, installation, and dismantle at all major UAE exhibition centers including GITEX, Gulfood, and Arab Health.'],
        ],
    ],
];

// Default fallback for any unrecognised category
$default_data = [
    'h1'    => esc_html( $term_name ) . ' Dubai, UAE',
    'sub'   => 'Professional ' . esc_html( strtolower( $term_name ) ) . ' services in Dubai and across the UAE. In-house production, fast turnaround, free design support.',
    'intro' => 'Efficient Advertising LLC provides professional ' . esc_html( strtolower( $term_name ) ) . ' services in Dubai and across the UAE. Our in-house facility delivers quality, speed, and competitive pricing on every order. Contact us for a free quote.',
    'faqs'  => [
        ['q' => 'How do I place an order?', 'a' => 'Send your artwork via WhatsApp or through the Quick Quote form on this page. We respond with a quote within a few hours.'],
        ['q' => 'What is your standard turnaround time?', 'a' => '1–3 business days for most products. Same-day and next-day options available. Contact us for urgent requirements.'],
        ['q' => 'Do you deliver across the UAE?', 'a' => 'Yes — Dubai, Abu Dhabi, Sharjah, Ajman, Fujairah, Ras Al Khaimah, and Umm Al Quwain. Gulf region exports available on request.'],
        ['q' => 'Can you design my artwork?', 'a' => 'Yes — our in-house design team provides free artwork setup and revisions on all orders. Share your logo and brand guidelines.'],
    ],
];

$cat = isset( $cat_data[ $term_slug ] ) ? $cat_data[ $term_slug ] : $default_data;
$h1     = $cat['h1'];
$sub    = $cat['sub'];
$intro  = $cat['intro'];
$faqs   = $cat['faqs'];

// SEO: Add manual meta description
add_action('wp_head', function() use ($sub) {
    if ($sub) {
        echo '<!-- Audit Fix: Manual Meta Description (Priority 0) -->' . "\n";
        echo '<meta name="description" content="' . esc_attr(wp_strip_all_tags($sub)) . '">' . "\n";
    }
}, 0); // High priority

get_header(); // Fire get_header AFTER setting up wp_head action

// =====================================================================
// COLLECT PRODUCTS FOR JSON-LD ItemList
// =====================================================================
$schema_posts = get_posts([
    'post_type'   => 'product',
    'post_status' => 'publish',
    'numberposts' => 50,
    'tax_query'   => [[
        'taxonomy' => 'product_category',
        'field'    => 'slug',
        'terms'    => $term_slug,
    ]],
]);
$item_list = [];
foreach ( $schema_posts as $idx => $sp ) {
    $item_list[] = [
        'pos'  => $idx + 1,
        'name' => esc_js( $sp->post_title ),
        'url'  => esc_url( get_permalink( $sp->ID ) ),
    ];
}
wp_reset_postdata();
?>
<!-- JSON-LD: CollectionPage + BreadcrumbList + FAQPage -->
<script type="application/ld+json">
[
  {
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "<?php echo esc_js( wp_strip_all_tags( $h1 ) ); ?>",
    "url": "<?php echo esc_url( $term_url ); ?>",
    "description": "<?php echo esc_js( wp_strip_all_tags( $sub ) ); ?>",
    "provider": {
      "@type": "Organization",
      "name": "Efficient Advertising LLC",
      "url": "https://efficientadvt.com"
    }
    <?php if ( ! empty( $item_list ) ) : ?>
    ,"mainEntity": {
      "@type": "ItemList",
      "itemListElement": [
        <?php foreach ( $item_list as $i => $it ) : ?>
        {
          "@type": "ListItem",
          "position": <?php echo intval( $it['pos'] ); ?>,
          "name": "<?php echo $it['name']; ?>",
          "url": "<?php echo $it['url']; ?>"
        }<?php echo ( $i < count( $item_list ) - 1 ) ? ',' : ''; ?>
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
      {"@type":"ListItem","position":2,"name":"Products","item":"<?php echo esc_url( home_url('/shop/') ); ?>"},
      {"@type":"ListItem","position":3,"name":"<?php echo esc_js( $term_name ); ?>"}
    ]
  },
  {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
      <?php foreach ( $faqs as $fi => $faq ) : ?>
      {
        "@type": "Question",
        "name": "<?php echo esc_js( $faq['q'] ); ?>",
        "acceptedAnswer": {"@type":"Answer","text":"<?php echo esc_js( wp_strip_all_tags( $faq['a'] ) ); ?>"}
      }<?php echo ( $fi < count( $faqs ) - 1 ) ? ',' : ''; ?>
      <?php endforeach; ?>
    ]
  }
]
</script>

<!-- HERO SECTION -->
<section class="cat-hero">
    <div class="container">
        <div class="cat-hero-inner">
            <nav class="cat-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url('/') ); ?>">Home</a>
                <span aria-hidden="true">/</span>
                <a href="<?php echo esc_url( home_url('/shop/') ); ?>">Products</a>
                <span aria-hidden="true">/</span>
                <span><?php echo esc_html( $term_name ); ?></span>
            </nav>
            <h1 class="cat-hero-title"><?php echo wp_kses_post( $h1 ); ?></h1>
            <p class="cat-hero-sub"><?php echo wp_kses_post( $sub ); ?></p>
            <div class="cat-hero-ctas">
                <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I need a quote for: ' . $term_name . ' in Dubai' ); ?>"
                   class="cat-btn-whatsapp" target="_blank" rel="noopener">
                    <i class="fa-brands fa-whatsapp"></i> WhatsApp for Quote
                </a>
                <a href="<?php echo esc_url( home_url('/contact-us/') ); ?>" class="cat-btn-quote">
                    <i class="fa-solid fa-file-invoice"></i> Request a Quote
                </a>
            </div>
        </div>
    </div>
</section>

<!-- TRUST BAR -->
<section class="cat-trust-bar">
    <div class="container">
        <div class="cat-trust-grid">
            <div class="cat-trust-item">
                <i class="fa-solid fa-industry"></i>
                <span>In-House Production</span>
            </div>
            <div class="cat-trust-item">
                <i class="fa-solid fa-bolt"></i>
                <span>Same-Day Available</span>
            </div>
            <div class="cat-trust-item">
                <i class="fa-solid fa-pen-ruler"></i>
                <span>Free Design Support</span>
            </div>
            <div class="cat-trust-item">
                <i class="fa-solid fa-award"></i>
                <span>18+ Years Experience</span>
            </div>
        </div>
    </div>
</section>

<!-- CATEGORY INTRO -->
<section class="cat-intro-section">
    <div class="container">
        <p class="cat-intro-text"><?php echo wp_kses_post( $intro ); ?></p>
    </div>
</section>

<!-- Products Section -->
<section class="products-archive-section section-padding">
    <div class="container">
        
        <?php if ( have_posts() ) : ?>
            
            <!-- Products Count & Filter -->
            <div class="archive-toolbar">
                <div class="products-count">
                    <span>
                        <?php
                        printf(
                            esc_html( _n( 'Showing %d product', 'Showing %d products', $wp_query->found_posts, 'efficient-modern' ) ),
                            $wp_query->found_posts
                        );
                        ?>
                    </span>
                </div>
                
                <!-- Optional Sort/Filter -->
                <div class="products-filter">
                    <select id="product-sort" class="form-control">
                        <option value=""><?php esc_html_e( 'Default Sorting', 'efficient-modern' ); ?></option>
                        <option value="name-asc"><?php esc_html_e( 'Name: A to Z', 'efficient-modern' ); ?></option>
                        <option value="name-desc"><?php esc_html_e( 'Name: Z to A', 'efficient-modern' ); ?></option>
                        <option value="date-desc"><?php esc_html_e( 'Newest First', 'efficient-modern' ); ?></option>
                    </select>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="products-grid">
                <?php
                while ( have_posts() ) :
                    the_post();
                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'efficient-thumbnail' );
                ?>
                    <div class="product-card wow fadeInUp">
                        <a href="<?php the_permalink(); ?>" class="product-card-link">
                            <div class="product-image">
                                <?php 
                                if ( $thumb && isset( $thumb[0] ) ) : 
                                ?>
                                    <img src="<?php echo esc_url( $thumb[0] ); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php elseif ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'efficient-thumbnail' ); ?>
                                <?php else : ?>
                                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/placeholder.jpg' ); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php endif; ?>
                                
                                <div class="product-overlay">
                                    <span class="view-product">
                                        <?php esc_html_e( 'View Details', 'efficient-modern' ); ?>
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="product-content">
                                <h3 class="product-name"><?php the_title(); ?></h3>
                                
                                <?php if ( has_excerpt() ) : ?>
                                    <p class="product-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 15 ) ); ?></p>
                                <?php endif; ?>
                                
                                <span class="product-link-text">
                                    <?php esc_html_e( 'Learn More', 'efficient-modern' ); ?>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                        
                        <div class="product-actions-quick">
                            <button class="quick-order-btn" data-product-id="<?php the_ID(); ?>" data-product-title="<?php the_title_attribute(); ?>">
                                <i class="fa-solid fa-cart-plus"></i>
                                <span><?php esc_html_e( 'Quick Order', 'efficient-modern' ); ?></span>
                            </button>
                        </div>
                    </div>
                <?php
                endwhile;
                ?>
            </div>
            
            <!-- Pagination -->
            <div class="pagination-wrapper">
                <?php
                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => '<i class="fa-solid fa-chevron-left"></i> ' . esc_html__( 'Previous', 'efficient-modern' ),
                    'next_text' => esc_html__( 'Next', 'efficient-modern' ) . ' <i class="fa-solid fa-chevron-right"></i>',
                ) );
                ?>
            </div>
            
        <?php else : ?>
            
            <!-- No Products Found -->
            <div class="no-products-found">
                <div class="no-products-icon">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h2><?php esc_html_e( 'No products found', 'efficient-modern' ); ?></h2>
                <p><?php esc_html_e( 'Sorry, we couldn\'t find any products in this category.', 'efficient-modern' ); ?></p>
                <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="btn btn-primary">
                    <?php esc_html_e( 'View All Products', 'efficient-modern' ); ?>
                </a>
            </div>
            
        <?php endif; ?>
        
    </div>
</section>

<!-- WHY CHOOSE EFFICIENT ADVERTISING -->
<section class="cat-why-section">
    <div class="container">
        <div class="cat-section-header">
            <h2>Why Choose Efficient Advertising?</h2>
            <p>Dubai&rsquo;s trusted printing partner for over 18 years — quality, speed, and service you can count on.</p>
        </div>
        <div class="cat-why-grid">
            <div class="cat-why-card">
                <div class="cat-why-icon"><i class="fa-solid fa-industry"></i></div>
                <h3>In-House Production</h3>
                <p>No outsourcing. We own and operate our printing facility in Dubai, giving us full quality control and faster turnaround on every order.</p>
            </div>
            <div class="cat-why-card">
                <div class="cat-why-icon"><i class="fa-solid fa-clock"></i></div>
                <h3>Same-Day &amp; Express</h3>
                <p>Urgent order? We offer same-day and next-day production for most products. Just WhatsApp us your artwork before 11am.</p>
            </div>
            <div class="cat-why-card">
                <div class="cat-why-icon"><i class="fa-solid fa-pen-ruler"></i></div>
                <h3>Free Design Support</h3>
                <p>Our in-house design team prepares, adjusts, and finalises your artwork at no extra cost. We make sure every print looks perfect.</p>
            </div>
            <div class="cat-why-card">
                <div class="cat-why-icon"><i class="fa-solid fa-truck-fast"></i></div>
                <h3>UAE-Wide Delivery</h3>
                <p>We deliver to all UAE emirates — Dubai, Abu Dhabi, Sharjah, Ajman, and beyond. Fast, reliable, and tracked.</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ SECTION -->
<section class="cat-faq-section">
    <div class="container">
        <div class="cat-section-header">
            <h2>Frequently Asked Questions</h2>
            <p>Everything you need to know about <?php echo esc_html( $term_name ); ?> in Dubai.</p>
        </div>
        <div class="cat-faq-list">
            <?php foreach ( $faqs as $faq ) : ?>
            <details class="cat-faq-item">
                <summary class="cat-faq-question">
                    <span><?php echo esc_html( $faq['q'] ); ?></span>
                    <i class="fa-solid fa-chevron-down cat-faq-icon"></i>
                </summary>
                <div class="cat-faq-answer">
                    <p><?php echo wp_kses_post( $faq['a'] ); ?></p>
                </div>
            </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- WHATSAPP / QUOTE CTA -->
<section class="cat-cta-section">
    <div class="container">
        <div class="cat-cta-inner">
            <div class="cat-cta-text">
                <h2>Need <?php echo wp_kses_post( $h1 ); ?>?</h2>
                <p>Get a free quote within hours. Our Dubai team is ready to help — same-day production available.</p>
            </div>
            <div class="cat-cta-buttons">
                <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo rawurlencode( 'Hi, I need a quote for: ' . $term_name . ' in Dubai' ); ?>"
                   class="cat-btn-whatsapp cat-btn-lg" target="_blank" rel="noopener">
                    <i class="fa-brands fa-whatsapp"></i> WhatsApp Us Now
                </a>
                <a href="<?php echo esc_url( home_url('/contact-us/') ); ?>" class="cat-btn-outline cat-btn-lg">
                    <i class="fa-solid fa-phone"></i> Call or Email Us
                </a>
            </div>
        </div>
    </div>
</section>

/* ======================================================
   CATEGORY HERO
   ====================================================== */
.cat-hero {
    background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 60%, #a51b44 100%);
    color: #fff;
    padding: 6rem 0 3rem; /* Increased top padding for header clearance */
    text-align: center;
}
@media (max-width: 767px) {
    .cat-hero { padding-top: 180px !important; } /* High clearance (180px) to survive fixed header */
}
.cat-hero-inner { max-width: 760px; margin: 0 auto; }
.cat-breadcrumb {
    display: flex; justify-content: center; align-items: center; gap: .5rem;
    font-size: .8rem; opacity: .75; margin-bottom: 1.25rem; flex-wrap: wrap;
}
.cat-breadcrumb a { color: #fff; text-decoration: none; }
.cat-breadcrumb a:hover { opacity: 1; text-decoration: underline; }
.cat-breadcrumb span { opacity: .6; }
.cat-hero-title {
    font-size: clamp(1.75rem, 4vw, 2.6rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.2;
    margin-bottom: 1rem;
}
.cat-hero-sub {
    font-size: 1.05rem;
    opacity: .92;
    line-height: 1.7;
    margin-bottom: 2rem;
    color: #fff;
}
.cat-hero-ctas {
    display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;
}
.cat-btn-whatsapp {
    display: inline-flex; align-items: center; gap: .5rem;
    background: #25D366; color: #fff;
    padding: .8rem 1.6rem; border-radius: 8px;
    font-weight: 700; font-size: .95rem; text-decoration: none;
    transition: background .2s, transform .15s;
}
.cat-btn-whatsapp:hover { background: #1da853; transform: translateY(-2px); color: #fff; }
.cat-btn-quote {
    display: inline-flex; align-items: center; gap: .5rem;
    background: rgba(255,255,255,.15); color: #fff;
    border: 2px solid rgba(255,255,255,.5);
    padding: .8rem 1.6rem; border-radius: 8px;
    font-weight: 700; font-size: .95rem; text-decoration: none;
    transition: background .2s, transform .15s;
}
.cat-btn-quote:hover { background: rgba(255,255,255,.25); transform: translateY(-2px); color: #fff; }

/* ======================================================
   TRUST BAR
   ====================================================== */
.cat-trust-bar {
    background: #ff6b35;
    padding: .85rem 0;
}
.cat-trust-grid {
    display: flex; justify-content: center; align-items: center;
    gap: 2.5rem; flex-wrap: wrap;
}
.cat-trust-item {
    display: flex; align-items: center; gap: .5rem;
    color: #fff; font-weight: 700; font-size: .88rem;
    white-space: nowrap;
}
.cat-trust-item i { font-size: 1rem; }

/* ======================================================
   CATEGORY INTRO
   ====================================================== */
.cat-intro-section { padding: 2.25rem 0 1rem; background: #fafafa; }
.cat-intro-text {
    max-width: 820px; margin: 0 auto;
    font-size: 1.05rem; line-height: 1.8; color: var(--color-text-main);
    text-align: center;
}

/* ======================================================
   SHARED SECTION HEADER
   ====================================================== */
.cat-section-header {
    text-align: center; margin-bottom: 2.5rem;
}
.cat-section-header h2 {
    font-size: clamp(1.5rem, 3vw, 2rem);
    color: var(--color-primary-dark); margin-bottom: .5rem;
}
.cat-section-header p {
    font-size: 1rem; color: var(--color-text-light); max-width: 600px; margin: 0 auto;
}

/* ======================================================
   WHY CHOOSE US
   ====================================================== */
.cat-why-section { padding: 4rem 0; background: #fff; }
.cat-why-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1.5rem;
}
.cat-why-card {
    background: var(--color-bg-light);
    border-radius: 12px;
    padding: 1.75rem 1.5rem;
    text-align: center;
    transition: box-shadow .2s, transform .2s;
}
.cat-why-card:hover { box-shadow: 0 8px 24px rgba(107,29,45,.12); transform: translateY(-4px); }
.cat-why-icon {
    width: 56px; height: 56px;
    background: linear-gradient(135deg, var(--color-primary-dark), var(--color-primary));
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1rem;
}
.cat-why-icon i { color: #fff; font-size: 1.25rem; }
.cat-why-card h3 { font-size: 1rem; font-weight: 700; margin-bottom: .5rem; color: var(--color-text-dark); }
.cat-why-card p { font-size: .88rem; color: var(--color-text-light); line-height: 1.65; margin: 0; }

/* ======================================================
   FAQ SECTION
   ====================================================== */
.cat-faq-section { padding: 4rem 0; background: var(--color-bg-light); }
.cat-faq-list { max-width: 760px; margin: 0 auto; display: flex; flex-direction: column; gap: .75rem; }
.cat-faq-item {
    background: #fff;
    border: 1px solid var(--color-border);
    border-radius: 10px;
    overflow: hidden;
}
.cat-faq-item[open] { border-color: var(--color-primary); }
.cat-faq-question {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.1rem 1.4rem;
    font-weight: 600; font-size: .97rem; cursor: pointer;
    list-style: none; color: var(--color-text-dark);
    transition: background .15s;
    gap: 1rem;
}
.cat-faq-question::-webkit-details-marker { display: none; }
.cat-faq-question:hover { background: var(--color-bg-light); }
.cat-faq-item[open] .cat-faq-question { color: var(--color-primary); background: var(--color-bg-light); }
.cat-faq-icon { font-size: .8rem; flex-shrink: 0; color: var(--color-text-light); transition: transform .2s; }
.cat-faq-item[open] .cat-faq-icon { transform: rotate(180deg); color: var(--color-primary); }
.cat-faq-answer { padding: 0 1.4rem 1.2rem; }
.cat-faq-answer p { font-size: .93rem; color: var(--color-text-main); line-height: 1.75; margin: 0; }

/* ======================================================
   WHATSAPP / QUOTE CTA
   ====================================================== */
.cat-cta-section {
    background: linear-gradient(135deg, var(--color-primary-dark), var(--color-primary));
    padding: 3.5rem 0;
    color: #fff;
}
.cat-cta-inner {
    display: flex; align-items: center; justify-content: space-between;
    gap: 2rem; flex-wrap: wrap;
}
.cat-cta-text h2 { font-size: clamp(1.3rem, 2.5vw, 1.7rem); color: #fff; margin-bottom: .5rem; }
.cat-cta-text p { color: rgba(255,255,255,.85); font-size: 1rem; margin: 0; }
.cat-cta-buttons { display: flex; gap: 1rem; flex-wrap: wrap; flex-shrink: 0; }
.cat-btn-lg { padding: 1rem 2rem !important; font-size: 1rem !important; }
.cat-btn-outline {
    display: inline-flex; align-items: center; gap: .5rem;
    background: transparent; color: #fff;
    border: 2px solid rgba(255,255,255,.6);
    padding: .8rem 1.6rem; border-radius: 8px;
    font-weight: 700; font-size: .95rem; text-decoration: none;
    transition: background .2s, transform .15s;
}
.cat-btn-outline:hover { background: rgba(255,255,255,.15); transform: translateY(-2px); color: #fff; }

/* ======================================================
   RESPONSIVE OVERRIDES
   ====================================================== */
@media (max-width: 768px) {
    .cat-trust-grid { gap: 1.25rem; }
    .cat-why-grid { grid-template-columns: 1fr 1fr; }
    .cat-cta-inner { flex-direction: column; text-align: center; }
    .cat-cta-buttons { justify-content: center; }
}
@media (max-width: 480px) {
    .cat-why-grid { grid-template-columns: 1fr; }
    .cat-hero-ctas { flex-direction: column; }
}

/* ======================================================
   LEGACY SECTION OVERRIDES (kept for products grid)
   ====================================================== */
/* Archive Toolbar */
.archive-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--spacing-2xl);
    padding: var(--spacing-lg);
    background: var(--color-bg-light);
    border-radius: var(--radius-lg);
}

.products-count {
    font-weight: 600;
    color: var(--color-text-main);
}

.products-filter select {
    padding: 0.5rem 1rem;
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    background: var(--color-bg-white);
    font-size: var(--font-size-base);
    cursor: pointer;
}

/* Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: var(--spacing-xl);
    margin-bottom: var(--spacing-3xl);
}

.product-card {
    background: var(--color-bg-white);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: all var(--transition-base);
    position: relative;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.product-card-link {
    display: block;
    text-decoration: none;
    color: inherit;
}

.product-image {
    position: relative;
    padding-top: 100%;
    overflow: hidden;
    background: var(--color-bg-gray);
}

.product-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-slow);
}

.product-card:hover .product-image img {
    transform: scale(1.1);
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(139, 21, 56, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity var(--transition-base);
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.view-product {
    color: var(--color-bg-white);
    font-weight: 600;
    font-size: var(--font-size-lg);
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.product-content {
    padding: var(--spacing-lg);
}

.product-name {
    font-size: var(--font-size-xl);
    font-weight: 600;
    margin-bottom: var(--spacing-sm);
    transition: color var(--transition-base);
}

.product-card:hover .product-name {
    color: var(--color-primary);
}

.product-excerpt {
    font-size: var(--font-size-sm);
    color: var(--color-text-light);
    margin-bottom: var(--spacing-sm);
    line-height: 1.6;
}

.product-link-text {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-xs);
    font-size: var(--font-size-sm);
    font-weight: 600;
    color: var(--color-secondary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.product-link-text i {
    transition: transform var(--transition-base);
}

.product-card:hover .product-link-text i {
    transform: translateX(4px);
}

/* Quick Actions */
.product-actions-quick {
    padding: var(--spacing-md) var(--spacing-lg);
    border-top: 1px solid var(--color-border);
}

.quick-order-btn {
    width: 100%;
    padding: 0.75rem;
    background: var(--color-secondary);
    color: var(--color-bg-white);
    border: none;
    border-radius: var(--radius-md);
    font-weight: 600;
    cursor: pointer;
    transition: all var(--transition-base);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--spacing-sm);
}

.quick-order-btn:hover {
    background: var(--color-secondary-dark);
    transform: translateY(-2px);
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: var(--spacing-3xl);
}

.pagination {
    display: flex;
    gap: var(--spacing-sm);
    list-style: none;
    padding: 0;
}

.page-numbers {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 45px;
    height: 45px;
    padding: 0 var(--spacing-md);
    background: var(--color-bg-white);
    color: var(--color-text-main);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    font-weight: 600;
    transition: all var(--transition-base);
    text-decoration: none;
}

.page-numbers:hover,
.page-numbers.current {
    background: var(--color-primary);
    color: var(--color-bg-white);
    border-color: var(--color-primary);
}

/* No Products Found */
.no-products-found {
    text-align: center;
    padding: var(--spacing-4xl) var(--spacing-xl);
}

.no-products-icon {
    font-size: 5rem;
    color: var(--color-text-lighter);
    margin-bottom: var(--spacing-xl);
}

.no-products-found h2 {
    font-size: var(--font-size-3xl);
    margin-bottom: var(--spacing-md);
}

.no-products-found p {
    font-size: var(--font-size-lg);
    color: var(--color-text-light);
    margin-bottom: var(--spacing-xl);
}

/* Responsive (products grid) */
@media (max-width: 768px) {
    .archive-toolbar {
        flex-direction: column;
        gap: var(--spacing-md);
        text-align: center;
    }
    
    .products-filter {
        width: 100%;
    }
    
    .products-filter select {
        width: 100%;
    }
    
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: var(--spacing-md);
    }
}

@media (max-width: 480px) {
    .products-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
get_footer();
