<?php
/**
 * img-batch.php  – run via browser with ?batch=0, ?batch=1, etc.
 * Each batch processes 10 sub-categories.
 * DELETE after use.
 */
require_once __DIR__ . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

@set_time_limit(120);
@ini_set('memory_limit', '256M');

$BRAIN = 'C:/Users/merch/.gemini/antigravity/brain/d89c9731-c08e-47dd-90c0-d79d2c818741';

$SUBCATS = [
    'Flyers & Brochures'           => ['local', $BRAIN.'/sub_flyers_brochures_1773640746034.png'],
    'Business Cards'               => ['local', $BRAIN.'/sub_business_cards_1773640761246.png'],
    'Stationery'                   => ['local', $BRAIN.'/sub_stationery_1773640781145.png'],
    'Stickers'                     => ['local', $BRAIN.'/sub_stickers_1773640798529.png'],
    'Branded Apparel'              => ['local', $BRAIN.'/sub_branded_apparel_1773640814780.png'],
    'Bags & Accessories'           => ['local', $BRAIN.'/sub_bags_accessories_1773640829551.png'],
    '3D & Illuminated Signage'     => ['local', $BRAIN.'/sub_3d_illuminated_signage_1773640843364.png'],
    'Feather & Sail Flags'         => ['local', $BRAIN.'/sub_feather_sail_flags_1773640859307.png'],
    'Pop-Up & Portable Displays'   => ['flickr', 'popup,exhibition,display,stand,booth'],
    'Certificates & Invitations'   => ['flickr', 'certificate,invitation,luxury,gold'],
    'Drinkware'                    => ['flickr', 'mug,cup,drinkware,branded,coffee'],
    'Rigid Board Signage'          => ['flickr', 'outdoor,sign,board,retail,shop'],
    'Event Accessories'            => ['flickr', 'event,party,accessories,branded,items'],
    'Booklets & Catalogues'        => ['flickr', 'booklet,catalogue,brochure,pages,print'],
    'Crowd Promotion'              => ['flickr', 'promotional,branded,merchandise,crowd'],
    'Die-Cut Products'             => ['flickr', 'diecut,custom,shape,print,label'],
    'Menus & Placemats'            => ['flickr', 'restaurant,menu,placemat,food,print'],
    'Indoor & Corporate Flags'     => ['flickr', 'indoor,corporate,flag,office,banner'],
    'Window Graphics & Frosted Film'=> ['flickr', 'window,frosted,glass,film,vinyl'],
    'Vinyl Banners & Hoardings'    => ['flickr', 'vinyl,banner,outdoor,advertising,large'],
    'Name Plates & Labels'         => ['flickr', 'name,plate,door,label,metal'],
    'Trade Shows & Events'         => ['flickr', 'trade,show,event,exhibition,booth'],
    'Product Boxes'                => ['flickr', 'product,box,packaging,cardboard,custom'],
    'Food & Beverage Packaging'    => ['flickr', 'food,beverage,packaging,box,label'],
    'Backdrops'                    => ['flickr', 'backdrop,event,banner,step,repeat'],
    'Wall Graphics & Decals'       => ['flickr', 'wall,graphics,office,decal,vinyl'],
    'Sticker Printing'             => ['flickr', 'sticker,printing,custom,label,design'],
    'Tickets & Coupons'            => ['flickr', 'ticket,event,coupon,print,voucher'],
    'Voucher Books'                => ['flickr', 'voucher,booklet,coupon,print,deal'],
    'Office & Desktop Gifts'       => ['flickr', 'office,desk,gift,pen,corporate'],
    'Bags & Carriers'              => ['flickr', 'tote,bag,shopping,branded,carrier'],
    'Frame Banners & Stands'       => ['flickr', 'frame,banner,stand,display,advertising'],
    'LED & Digital Signage'        => ['flickr', 'LED,digital,screen,display,signage'],
    'Exhibition Stands & Booths'   => ['flickr', 'exhibition,booth,stand,trade,show'],
    'Premium & Specialty Gifts'    => ['flickr', 'luxury,gift,premium,corporate,branded'],
    'Executive Kit'                => ['flickr', 'executive,gift,set,corporate,premium'],
    'Roll Labels & Stickers'       => ['flickr', 'roll,label,sticker,packaging,print'],
    'Pull-Up & Roll-Up Banners'    => ['flickr', 'rollup,banner,display,stand,advertising'],
    'Large Format Posters'         => ['flickr', 'large,poster,print,wall,color'],
    'Large Format & Panel Signs'   => ['flickr', 'large,panel,sign,outdoor,hoarding'],
    'Decorative Flags'             => ['flickr', 'decorative,bunting,flag,event,colorful'],
    'Car & Van Branding'           => ['flickr', 'car,van,vehicle,branding,wrap'],
    'Canvas Prints'                => ['flickr', 'canvas,print,art,wall,photo'],
    'Labels'                       => ['flickr', 'product,label,bottle,sticker,branded'],
    'Standees & Cutouts'           => ['flickr', 'standee,lifesize,cutout,display,print'],
    'Calendars'                    => ['flickr', 'calendar,wall,desk,print,custom'],
    'Tech Products'                => ['flickr', 'tech,gadget,usb,branded,corporate'],
    'Custom Packaging'             => ['flickr', 'custom,packaging,luxury,box,branded'],
    'Magnets'                      => ['flickr', 'magnet,fridge,custom,print,branded'],
    'Flexible Packaging'           => ['flickr', 'flexible,pouch,bag,packaging,print'],
    'Fleet Branding'               => ['flickr', 'fleet,truck,vehicle,branding,wrap'],
    'Seals & Stamps'               => ['flickr', 'wax,seal,stamp,custom,emboss'],
    'Wayfinding & Directory'       => ['flickr', 'wayfinding,sign,directory,office,map'],
    'Flag Bases & Accessories'     => ['flickr', 'flag,pole,base,stand,accessory'],
    'Floor Graphics'               => ['flickr', 'floor,sticker,vinyl,graphic,retail'],
    'Variable Printing'            => ['flickr', 'variable,data,personalized,print,custom'],
    'Office Essentials'            => ['flickr', 'office,supplies,branded,desk,pen'],
    'Tear Drop & Blade Flags'      => ['flickr', 'teardrop,blade,flag,outdoor,advertising'],
    'Party Essentials'             => ['flickr', 'party,balloon,decoration,event,colorful'],
    'Wall Frames'                  => ['flickr', 'picture,frame,wall,print,display'],
    'POS Display'                  => ['flickr', 'retail,display,point,sale,counter'],
    'Event Disposables'            => ['flickr', 'disposable,cup,plate,event,branded'],
    'Mailer & Corrugated Boxes'    => ['flickr', 'mailer,box,corrugated,shipping,packaging'],
    'Light Box Signage'            => ['flickr', 'lightbox,illuminated,display,sign,light'],
    'Safety Signage'               => ['flickr', 'safety,warning,sign,notice,industrial'],
    'Boat & Yacht Branding'        => ['flickr', 'boat,yacht,marine,decal,branding'],
    'Exhibition Counters'          => ['flickr', 'counter,display,exhibition,trade,show'],
    'Event Props'                  => ['flickr', 'event,prop,party,decoration,display'],
    'Repositionable Cling'         => ['flickr', 'window,cling,decal,removable,vinyl'],
    'Workplace'                    => ['flickr', 'workplace,office,branding,wall,sign'],
    'Wall Décor'                   => ['flickr', 'wall,decor,art,office,print'],
    'Magnetic Sheet'               => ['flickr', 'magnetic,sheet,sign,advertising,custom'],
];

$batch = isset($_GET['batch']) ? (int)$_GET['batch'] : 0;
$per_batch = 10;
$all = array_keys($SUBCATS);
$total = count($all);
$total_batches = ceil($total / $per_batch);
$start = $batch * $per_batch;
$end = min($start + $per_batch, $total);
$next_batch = ($batch + 1 < $total_batches) ? ($batch + 1) : null;

$upload_dir = wp_upload_dir();

function dl_image_to_wp($name, $type, $src, $upload_dir) {
    $safe = 'ea-sub-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($name));
    $ext  = ($type === 'local') ? pathinfo($src, PATHINFO_EXTENSION) : 'jpg';
    $dest = $upload_dir['path'] . "/{$safe}.{$ext}";

    if ($type === 'local') {
        if (!copy($src, $dest)) return ['error' => "copy failed"];
    } else {
        $url = "https://loremflickr.com/800/600/{$src}";
        $ctx = stream_context_create(['http'=>['timeout'=>15,'follow_location'=>1,'user_agent'=>'Mozilla/5.0'],'ssl'=>['verify_peer'=>false]]);
        $data = @file_get_contents($url, false, $ctx);
        if (!$data || strlen($data) < 3000) return ['error' => "download failed (".strlen((string)$data)." bytes)"];
        file_put_contents($dest, $data);
    }

    $mime = ($ext === 'png') ? 'image/png' : 'image/jpeg';
    $att = ['guid'=>$upload_dir['url']."/".basename($dest),'post_mime_type'=>$mime,'post_title'=>$name,'post_content'=>'','post_status'=>'inherit'];
    $id = wp_insert_attachment($att, $dest);
    if (is_wp_error($id)) return ['error' => $id->get_error_message()];
    wp_update_attachment_metadata($id, wp_generate_attachment_metadata($id, $dest));
    return ['id' => $id];
}

echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Images Batch '.$batch.'</title>
<style>body{font-family:monospace;background:#0f1117;color:#e2e8f0;padding:20px;font-size:13px;}
h1{color:#f59e0b;}.ok{color:#4ade80;}.err{color:#f87171;}.info{color:#60a5fa;}
.next{display:inline-block;margin-top:20px;background:#f59e0b;color:#000;padding:10px 20px;text-decoration:none;border-radius:8px;font-weight:bold;}
</style></head><body>';

echo "<h1>🖼️ Batch $batch of ".($total_batches-1)." [".$start."-".($end-1)."/".$total."]</h1>";

$assigned = 0;

for ($i = $start; $i < $end; $i++) {
    $subcat = $all[$i];
    [$type, $src] = $SUBCATS[$subcat];

    echo "<div style='margin:8px 0;border-left:3px solid #f59e0b;padding-left:10px;'>";
    echo "<strong style='color:#f59e0b;'>[$i] $subcat</strong><br>";

    $result = dl_image_to_wp($subcat, $type, $src, $upload_dir);
    if (isset($result['error'])) {
        echo "<span class='err'>✗ Image: ".$result['error']."</span><br>";
        echo "</div>"; continue;
    }
    $attach_id = $result['id'];
    echo "<span class='ok'>✓ Uploaded (ID: $attach_id)</span><br>";

    $term = get_term_by('name', $subcat, 'product_cat');
    if (!$term) { echo "<span class='err'>✗ Term not found</span>"; echo "</div>"; continue; }

    $products = get_posts(['post_type'=>'product','post_status'=>'publish','posts_per_page'=>-1,
        'tax_query'=>[['taxonomy'=>'product_cat','field'=>'term_id','terms'=>$term->term_id]]]);

    foreach ($products as $p) { set_post_thumbnail($p->ID, $attach_id); $assigned++; }
    echo "<span class='ok'>✓ ".count($products)." products updated</span>";
    echo "</div>";
    flush(); ob_flush();
}

wc_delete_product_transients();

echo "<hr style='border-color:#334155;margin:16px 0;'>";
echo "<p class='ok'>✓ Batch $batch done. Products updated this batch: $assigned</p>";

if ($next_batch !== null) {
    $next_url = "/img-batch.php?batch=$next_batch";
    echo "<p class='info'>Auto-advancing to batch $next_batch in 2 seconds...</p>";
    echo "<a class='next' href='$next_url'>▶ Next Batch ($next_batch)</a>";
    echo "<script>setTimeout(()=>location.href='$next_url', 2000);</script>";
} else {
    echo "<p class='ok' style='font-size:16px;font-weight:bold;'>🎉 ALL BATCHES COMPLETE! All $total sub-categories done.</p>";
    echo "<a class='next' href='/product-category/print-stationery/'>View Products</a>";
}
echo '</body></html>';
