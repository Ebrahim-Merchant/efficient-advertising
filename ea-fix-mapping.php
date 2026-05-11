<?php
/**
 * Fix incorrect category mappings and add unmapped ones
 */
$mapping = json_decode(file_get_contents(__DIR__ . '/cat-mapping.json'), true);

// Fix incorrect fuzzy matches
$fixes = [
    // Die-Cut Products → should be Print Materials subcategory, use Print Materials parent
    223 => 1257,   // Die-Cut Products → Print Materials
    // Office & Retail Branding → should map to Stickers & Branding
    1101 => 1286,  // Office & Retail Branding → Stickers & Branding
    // Variable Printing → Print Materials
    254 => 1257,   // Variable Printing → Print Materials
    // POS Display → Exhibitions & Events
    1223 => 1303,  // POS Display → Exhibitions & Events
    // Product Boxes → Packaging & Labels
    456 => 1315,   // Product Boxes → Packaging & Labels
    // Large Format → Banners & Large Format (parent)
    522 => 1279,   // Large Format → Banners & Large Format
    // Indoor & Corporate Flags → Table & Conference Flags (better match)
    850 => 1294,   // Indoor & Corporate Flags → Table & Conference Flags
    // Flyers & Brochures → Flyers (not Brochures)
    97 => 1259,    // Flyers & Brochures → Flyers
    // Print & Stationery → Print Materials (correct mapping)
    62 => 1257,    // Print & Stationery → Print Materials
    // Stickers → Custom Stickers & Labels
    232 => 1289,   // Stickers → Custom Stickers & Labels
    // Tickets & Coupons → Tickets, Vouchers & Loyalty Cards
    201 => 1266,   // Tickets & Coupons → Tickets, Vouchers & Loyalty Cards
    // Voucher Books → Tickets, Vouchers & Loyalty Cards
    249 => 1266,   // Voucher Books → Tickets, Vouchers & Loyalty Cards
    // Stationery → Print Materials
    116 => 1257,   // Stationery → Print Materials
    // Backdrops (1083, under Exhibitions) → Event Backdrops (correct)
    // Event Props → Event Accessories (better fit)
    1065 => 1307,  // Event Props → Event Accessories
    // Repositionable Cling → Wall Graphics & Decals
    1236 => 1288,  // Repositionable Cling → Wall Graphics & Decals
    // Wall Décor → Wall Graphics & Decals
    1246 => 1288,  // Wall Décor → Wall Graphics & Decals
    // Wall Frames → Wall Graphics & Decals
    1210 => 1288,  // Wall Frames → Wall Graphics & Decals
    // Workplace → Stickers & Branding
    1241 => 1286,  // Workplace → Stickers & Branding
    // Magnetic Sheet → Magnets
    1251 => 1292,  // Magnetic Sheet → Magnets
    // Roll Labels & Stickers → Custom Stickers & Labels
    478 => 1289,   // Roll Labels & Stickers → Custom Stickers & Labels
    // Exhibition Counters → Exhibition Stands & Booths
    1056 => 1304,  // Exhibition Counters → Exhibition Stands & Booths
    // Floor Graphics (1192) under Office & Retail → Floor Graphics (1290) under Stickers
    1192 => 1290,  // Floor Graphics → Floor Graphics (correct)
    // Bags & Carriers → Bags & Accessories
    513 => 1310,   // Bags & Carriers → Bags & Accessories
    // Event Disposables → Event Accessories
    446 => 1307,   // Event Disposables → Event Accessories
    // Office Essentials → Office & Desktop Gifts
    380 => 1312,   // Office Essentials → Office & Desktop Gifts
    // Party Essentials → Event Accessories
    1070 => 1307,  // Party Essentials → Event Accessories
    // Premium & Specialty Gifts → Executive Kits
    397 => 1313,   // Premium & Specialty Gifts → Executive Kits
    // Standees & Cutouts → Pop-Up & Portable Displays
    995 => 1305,   // Standees & Cutouts → Pop-Up & Portable Displays
    // Trade Shows & Events → Exhibition Stands & Booths
    414 => 1304,   // Trade Shows & Events → Exhibition Stands & Booths
];

// Add unmapped categories
$unmapped_fixes = [
    260 => 1308,   // Crowd Promotion → Promotional & Corporate Gifts
    497 => 1315,   // Custom Packaging → Packaging & Labels
    788 => 1293,   // Flags → Flags & Outdoor (parent)
    487 => 1315,   // Flexible Packaging → Packaging & Labels
    508 => 1315,   // Food & Beverage Packaging → Packaging & Labels
    765 => 1275,   // Labels → Name Plates & Labels (under Signage)
    473 => 1315,   // Mailer & Corrugated Boxes → Packaging & Labels
];

foreach ($fixes as $old_id => $new_id) {
    $mapping[$old_id] = $new_id;
}
foreach ($unmapped_fixes as $old_id => $new_id) {
    $mapping[$old_id] = $new_id;
}

file_put_contents(__DIR__ . '/cat-mapping.json', json_encode($mapping));
echo "Mapping updated. Total entries: " . count($mapping) . "\n";

// Verify all old categories are mapped
echo "\nAll 83 old categories should now be mapped.\n";
