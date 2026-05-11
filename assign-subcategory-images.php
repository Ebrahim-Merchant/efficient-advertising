<?php
/**
 * assign-subcategory-images.php
 * Assigns unique images to every WooCommerce product by sub-category.
 * - Uses pre-generated AI images for 8 sub-categories (already saved locally)
 * - Downloads from loremflickr.com (free, no API key) for remaining 64
 *
 * Run via: http://efficientadvt.local/assign-subcategory-images.php
 * DELETE after use!
 */

define('SHORTINIT', false);
require_once __DIR__ . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

@set_time_limit(600);
@ini_set('memory_limit', '512M');

$BRAIN = 'C:/Users/merch/.gemini/antigravity/brain/d89c9731-c08e-47dd-90c0-d79d2c818741';

// ── Sub-category → image source mapping ───────────────────────────────────
// Local AI images for 8 sub-categories, loremflickr query for the rest
$SUBCATS = [
    // ── Already generated locally ──────────────────────────────────────────
    'Flyers & Brochures'         => ['local', $BRAIN.'/sub_flyers_brochures_1773640746034.png'],
    'Business Cards'             => ['local', $BRAIN.'/sub_business_cards_1773640761246.png'],
    'Stationery'                 => ['local', $BRAIN.'/sub_stationery_1773640781145.png'],
    'Stickers'                   => ['local', $BRAIN.'/sub_stickers_1773640798529.png'],
    'Branded Apparel'            => ['local', $BRAIN.'/sub_branded_apparel_1773640814780.png'],
    'Bags & Accessories'         => ['local', $BRAIN.'/sub_bags_accessories_1773640829551.png'],
    '3D & Illuminated Signage'   => ['local', $BRAIN.'/sub_3d_illuminated_signage_1773640843364.png'],
    'Feather & Sail Flags'       => ['local', $BRAIN.'/sub_feather_sail_flags_1773640859307.png'],

    // ── Download from loremflickr.com ──────────────────────────────────────
    'Pop-Up & Portable Displays'   => ['flickr', 'popup,display,exhibition,stand'],
    'Certificates & Invitations'   => ['flickr', 'certificate,invitation,luxury,card'],
    'Drinkware'                    => ['flickr', 'branded,mug,cup,drinkware,corporate'],
    'Rigid Board Signage'          => ['flickr', 'signage,board,outdoor,sign'],
    'Event Accessories'            => ['flickr', 'event,accessories,party,supplies'],
    'Booklets & Catalogues'        => ['flickr', 'booklet,catalogue,brochure,print'],
    'Crowd Promotion'              => ['flickr', 'crowd,promotional,items,merchandise'],
    'Die-Cut Products'             => ['flickr', 'die,cut,custom,print,shape'],
    'Menus & Placemats'            => ['flickr', 'menu,restaurant,placemat,print'],
    'Indoor & Corporate Flags'     => ['flickr', 'indoor,corporate,flag,banner'],
    'Window Graphics & Frosted Film'=> ['flickr', 'window,graphics,frosted,film,vinyl'],
    'Vinyl Banners & Hoardings'    => ['flickr', 'vinyl,banner,hoarding,outdoor,print'],
    'Name Plates & Labels'         => ['flickr', 'name,plate,label,door,sign'],
    'Trade Shows & Events'         => ['flickr', 'trade,show,exhibition,event,booth'],
    'Product Boxes'                => ['flickr', 'product,box,packaging,custom,print'],
    'Food & Beverage Packaging'    => ['flickr', 'food,packaging,beverage,box,label'],
    'Backdrops'                    => ['flickr', 'backdrop,step,repeat,banner,event'],
    'Wall Graphics & Decals'       => ['flickr', 'wall,graphics,decal,vinyl,office'],
    'Sticker Printing'             => ['flickr', 'sticker,printing,label,custom,design'],
    'Tickets & Coupons'            => ['flickr', 'ticket,coupon,voucher,event,print'],
    'Voucher Books'                => ['flickr', 'voucher,book,booklet,print,deal'],
    'Office & Desktop Gifts'       => ['flickr', 'office,desk,corporate,gift,pen'],
    'Bags & Carriers'              => ['flickr', 'bag,carrier,shopping,branded,tote'],
    'Frame Banners & Stands'       => ['flickr', 'frame,banner,stand,display,sign'],
    'LED & Digital Signage'        => ['flickr', 'LED,digital,signage,display,screen'],
    'Exhibition Stands & Booths'   => ['flickr', 'exhibition,stand,booth,trade,show'],
    'Premium & Specialty Gifts'    => ['flickr', 'premium,luxury,gift,corporate,branded'],
    'Executive Kit'                => ['flickr', 'executive,kit,corporate,gift,set'],
    'Roll Labels & Stickers'       => ['flickr', 'roll,label,sticker,print,packaging'],
    'Pull-Up & Roll-Up Banners'    => ['flickr', 'rollup,banner,stand,print,display'],
    'Large Format Posters'         => ['flickr', 'large,format,poster,print,wall'],
    'Large Format & Panel Signs'   => ['flickr', 'large,format,panel,sign,outdoor'],
    'Decorative Flags'             => ['flickr', 'decorative,flag,bunting,event,print'],
    'Car & Van Branding'           => ['flickr', 'car,van,vehicle,wrap,branding'],
    'Canvas Prints'                => ['flickr', 'canvas,print,wall,art,frame'],
    'Labels'                       => ['flickr', 'product,label,sticker,print,bottle'],
    'Standees & Cutouts'           => ['flickr', 'standee,cutout,life,size,display'],
    'Calendars'                    => ['flickr', 'wall,desk,calendar,print,custom'],
    'Tech Products'                => ['flickr', 'tech,gadget,branded,corporate,gift'],
    'Custom Packaging'             => ['flickr', 'custom,packaging,box,brand,luxury'],
    'Magnets'                      => ['flickr', 'magnet,fridge,custom,print,branded'],
    'Flexible Packaging'           => ['flickr', 'flexible,packaging,pouch,bag,print'],
    'Fleet Branding'               => ['flickr', 'fleet,vehicle,branding,wrap,truck'],
    'Seals & Stamps'               => ['flickr', 'wax,seal,stamp,custom,logo'],
    'Wayfinding & Directory'       => ['flickr', 'wayfinding,directory,sign,office,map'],
    'Flag Bases & Accessories'     => ['flickr', 'flag,base,pole,accessory,stand'],
    'Floor Graphics'               => ['flickr', 'floor,graphic,decal,vinyl,sticker'],
    'Variable Printing'            => ['flickr', 'variable,data,print,personalized'],
    'Office Essentials'            => ['flickr', 'office,desk,supplies,branded,print'],
    'Tear Drop & Blade Flags'      => ['flickr', 'teardrop,blade,flag,advertising,outdoor'],
    'Party Essentials'             => ['flickr', 'party,event,supplies,balloon,decoration'],
    'Wall Frames'                  => ['flickr', 'wall,frame,print,photo,display'],
    'POS Display'                  => ['flickr', 'point,of,sale,display,retail,sign'],
    'Event Disposables'            => ['flickr', 'disposable,cups,plates,event,branded'],
    'Mailer & Corrugated Boxes'    => ['flickr', 'mailer,box,corrugated,packaging,ship'],
    'Light Box Signage'            => ['flickr', 'light,box,illuminated,sign,display'],
    'Safety Signage'               => ['flickr', 'safety,sign,warning,notice,industrial'],
    'Boat & Yacht Branding'        => ['flickr', 'boat,yacht,branding,decal,marine'],
    'Exhibition Counters'          => ['flickr', 'exhibition,counter,display,booth,event'],
    'Event Props'                  => ['flickr', 'event,prop,decoration,display,party'],
    'Repositionable Cling'         => ['flickr', 'window,cling,decal,removable,vinyl'],
    'Workplace'                    => ['flickr', 'workplace,office,branding,sign,wall'],
    'Wall Décor'                   => ['flickr', 'wall,decor,print,art,office'],
    'Magnetic Sheet'               => ['flickr', 'magnetic,sheet,sign,print,custom'],
];

// ── Helpers ────────────────────────────────────────────────────────────────
function upload_image_from_file($src, $filename) {
    $upload_dir = wp_upload_dir();
    $dest = $upload_dir['path'] . '/' . $filename;
    if (!copy($src, $dest)) return new WP_Error('copy_failed', "Copy failed: $src → $dest");
    return create_attachment($dest, $upload_dir['url'] . '/' . $filename);
}

function upload_image_from_url($url, $filename) {
    $upload_dir = wp_upload_dir();
    $dest = $upload_dir['path'] . '/' . $filename;

    $ctx = stream_context_create([
        'http' => [
            'timeout' => 15,
            'user_agent' => 'Mozilla/5.0 (compatible; ProductImager/1.0)',
            'follow_location' => true,
        ],
        'ssl' => ['verify_peer' => false, 'verify_peer_name' => false],
    ]);
    $data = @file_get_contents($url, false, $ctx);
    if (!$data || strlen($data) < 5000) return new WP_Error('download_failed', "Download failed or too small: $url");

    file_put_contents($dest, $data);
    return create_attachment($dest, $upload_dir['url'] . '/' . $filename);
}

function create_attachment($dest, $guid) {
    $wp_filetype = wp_check_filetype(basename($dest), null);
    $attachment = [
        'guid'           => $guid,
        'post_mime_type' => $wp_filetype['type'] ?: 'image/jpeg',
        'post_title'     => preg_replace('/\.[^.]+$/', '', basename($dest)),
        'post_content'   => '',
        'post_status'    => 'inherit',
    ];
    $attach_id = wp_insert_attachment($attachment, $dest);
    if (is_wp_error($attach_id)) return $attach_id;
    $meta = wp_generate_attachment_metadata($attach_id, $dest);
    wp_update_attachment_metadata($attach_id, $meta);
    return $attach_id;
}

function assign_image_to_subcategory($subcat_name, $attach_id) {
    // Find all products in this sub-category and assign the image
    $term = get_term_by('name', $subcat_name, 'product_cat');
    if (!$term) return ['found' => 0, 'done' => 0, 'error' => "Term not found: $subcat_name"];

    $products = get_posts([
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'tax_query'      => [[
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => $term->term_id,
        ]],
    ]);

    $done = 0;
    foreach ($products as $p) {
        set_post_thumbnail($p->ID, $attach_id);
        $done++;
    }
    return ['found' => count($products), 'done' => $done, 'error' => null];
}

// ── Main ───────────────────────────────────────────────────────────────────
echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Sub-Category Images</title>
<style>
  body{font-family:monospace;background:#0f1117;color:#e2e8f0;padding:24px;font-size:13px;}
  h1{color:#f59e0b;} .ok{color:#4ade80;} .err{color:#f87171;} .info{color:#60a5fa;}
  .row{margin:3px 0;} .cat{color:#f59e0b;font-weight:bold;margin-top:14px;font-size:14px;}
</style></head><body>';
echo '<h1>🖼️ Sub-Category Image Assignment</h1>';
echo '<p class="info">Processing '.count($SUBCATS).' sub-categories...</p>';

$total_assigned = 0;
$total_errors = 0;
$idx = 0;

foreach ($SUBCATS as $subcat => $config) {
    $idx++;
    [$type, $source] = $config;
    $safe_name = 'ea-sub-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($subcat)) . '.jpg';

    echo "<div class='cat'>[$idx/".count($SUBCATS)."] $subcat</div>";
    flush(); ob_flush();

    // Upload image
    if ($type === 'local') {
        $source_png = str_replace('.jpg', '.png', $safe_name);
        // Use local file (it's PNG)
        $safe_name = 'ea-sub-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($subcat)) . '.png';
        $attach_id = upload_image_from_file($source, $safe_name);
    } else {
        // Download from loremflickr
        $query = urlencode($source);
        $url = "https://loremflickr.com/800/600/{$source}";
        $attach_id = upload_image_from_url($url, $safe_name);
    }

    if (is_wp_error($attach_id)) {
        echo "<div class='row err'>✗ Image failed: ".$attach_id->get_error_message()."</div>";
        $total_errors++;
        flush(); ob_flush();
        continue;
    }

    echo "<div class='row ok'>✓ Image uploaded (ID: $attach_id)</div>";

    // Assign to all products in this sub-category
    $result = assign_image_to_subcategory($subcat, $attach_id);
    if ($result['error']) {
        echo "<div class='row err'>⚠ ".$result['error']."</div>";
        $total_errors++;
    } else {
        echo "<div class='row ok'>✓ Assigned to {$result['done']}/{$result['found']} products</div>";
        $total_assigned += $result['done'];
    }

    flush(); ob_flush();
}

wc_delete_product_transients();

echo "<hr style='border-color:#334155;margin-top:20px;'>";
echo "<h2 class='ok'>✅ Done!</h2>";
echo "<p>Total assignments: <strong class='ok'>$total_assigned</strong> | Errors: <strong class='err'>$total_errors</strong></p>";
echo "<p class='err'>⚠️ DELETE this file now: assign-subcategory-images.php</p>";
echo '</body></html>';
