<?php
// Simulate web server environment so wp-load.php boots correctly
$_SERVER['HTTP_HOST']   = 'efficientadvt.local';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['SERVER_NAME'] = 'efficientadvt.local';
$_SERVER['HTTPS']       = '';
$_SERVER['REQUEST_METHOD'] = 'GET';

define('ABSPATH_NEEDED', true);
require_once __DIR__ . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

set_time_limit(0);
ini_set('memory_limit', '512M');

$BRAIN = 'C:/Users/merch/.gemini/antigravity/brain/d89c9731-c08e-47dd-90c0-d79d2c818741';

// Check if START parameter is provided (for batch mode)
$start_idx = isset($argv[1]) ? (int)$argv[1] : 0;
$batch_size = isset($argv[2]) ? (int)$argv[2] : 999;

$SUBCATS = [
    // AI-generated (local files)
    'Flyers & Brochures'           => ['local', $BRAIN.'/sub_flyers_brochures_1773640746034.png'],
    'Business Cards'               => ['local', $BRAIN.'/sub_business_cards_1773640761246.png'],
    'Stationery'                   => ['local', $BRAIN.'/sub_stationery_1773640781145.png'],
    'Stickers'                     => ['local', $BRAIN.'/sub_stickers_1773640798529.png'],
    'Branded Apparel'              => ['local', $BRAIN.'/sub_branded_apparel_1773640814780.png'],
    'Bags & Accessories'           => ['local', $BRAIN.'/sub_bags_accessories_1773640829551.png'],
    '3D & Illuminated Signage'     => ['local', $BRAIN.'/sub_3d_illuminated_signage_1773640843364.png'],
    'Feather & Sail Flags'         => ['local', $BRAIN.'/sub_feather_sail_flags_1773640859307.png'],
    // loremflickr downloads
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

function create_wp_attachment($dest_path, $title) {
    $upload_dir = wp_upload_dir();
    $wp_filetype = wp_check_filetype(basename($dest_path), null);
    $url = str_replace(wp_normalize_path(ABSPATH), get_site_url() . '/', wp_normalize_path($dest_path));
    $attachment = [
        'guid'           => $url,
        'post_mime_type' => $wp_filetype['type'] ?: 'image/jpeg',
        'post_title'     => $title,
        'post_content'   => '',
        'post_status'    => 'inherit',
    ];
    $id = wp_insert_attachment($attachment, $dest_path);
    if (!is_wp_error($id)) {
        $meta = wp_generate_attachment_metadata($id, $dest_path);
        wp_update_attachment_metadata($id, $meta);
    }
    return $id;
}

$all_subcats = array_keys($SUBCATS);
$total = count($all_subcats);
$batch_end = min($start_idx + $batch_size, $total);

echo "=== Sub-Category Image Assignment ===\n";
echo "Processing $start_idx to " . ($batch_end - 1) . " of $total sub-categories\n\n";

$upload_dir = wp_upload_dir();
$assigned_total = 0;
$errors = 0;

for ($i = $start_idx; $i < $batch_end; $i++) {
    $subcat = $all_subcats[$i];
    [$type, $source] = $SUBCATS[$subcat];
    $safe = 'ea-sub-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($subcat));

    echo "[" . ($i+1) . "/$total] $subcat ... ";

    // Prepare destination
    if ($type === 'local') {
        $ext = pathinfo($source, PATHINFO_EXTENSION);
        $dest = $upload_dir['path'] . "/{$safe}.{$ext}";
        if (!copy($source, $dest)) {
            echo "FAIL (copy)\n";
            $errors++;
            continue;
        }
    } else {
        $dest = $upload_dir['path'] . "/{$safe}.jpg";
        // Try loremflickr
        $url = "https://loremflickr.com/800/600/{$source}";
        $opts = stream_context_create([
            'http' => ['timeout' => 20, 'user_agent' => 'Mozilla/5.0', 'follow_location' => 1],
            'ssl'  => ['verify_peer' => false],
        ]);
        $data = @file_get_contents($url, false, $opts);
        if (!$data || strlen($data) < 3000) {
            echo "FAIL (download: ".strlen($data)." bytes)\n";
            $errors++;
            continue;
        }
        file_put_contents($dest, $data);
    }

    // Create WP attachment
    $attach_id = create_wp_attachment($dest, $subcat);
    if (is_wp_error($attach_id)) {
        echo "FAIL (attachment: " . $attach_id->get_error_message() . ")\n";
        $errors++;
        continue;
    }

    // Find sub-category term and assign to all its products
    $term = get_term_by('name', $subcat, 'product_cat');
    if (!$term) {
        echo "OK (uploaded ID:$attach_id) | WARN: term not found\n";
        continue;
    }

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
        $assigned_total++;
    }
    echo "OK (ID:$attach_id) | assigned to $done products\n";
}

wc_delete_product_transients();
echo "\n=== DONE ===\n";
echo "Total products updated: $assigned_total\n";
echo "Errors: $errors\n";
