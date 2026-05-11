<?php
/**
 * Plugin Name: EA Product Image Manager
 * Description: Assign product images per sub-category — bulk update all products at once.
 * Version: 1.0
 * Author: Efficient Advertising
 */
if (!defined('ABSPATH')) exit;

/* ── Register admin menu ─────────────────────────────────────────────────── */
add_action('admin_menu', function () {
    add_menu_page(
        'Product Image Manager',
        '🖼️ Image Manager',
        'manage_options',
        'ea-image-manager',
        'ea_render_page',
        'dashicons-format-gallery',
        58
    );
});

/* ── Enqueue WP media uploader ───────────────────────────────────────────── */
add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook !== 'toplevel_page_ea-image-manager') return;
    wp_enqueue_media();
    wp_enqueue_script('jquery');
});

/* ── Handle AJAX save ────────────────────────────────────────────────────── */
add_action('wp_ajax_ea_assign_image', function () {
    check_ajax_referer('ea_image_manager_nonce', 'nonce');
    if (!current_user_can('manage_options')) wp_die('Unauthorized');

    $term_id   = intval($_POST['term_id']);
    $attach_id = intval($_POST['attach_id']);

    if (!$term_id || !$attach_id) {
        wp_send_json_error('Missing term_id or attach_id');
    }

    // Get all products in this sub-category
    $products = get_posts([
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'tax_query'      => [[
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => $term_id,
        ]],
    ]);

    $count = 0;
    foreach ($products as $p) {
        set_post_thumbnail($p->ID, $attach_id);
        $count++;
    }

    // Also save category thumbnail for future reference
    update_term_meta($term_id, 'ea_category_image', $attach_id);
    wc_delete_product_transients();

    wp_send_json_success([
        'count'     => $count,
        'thumb_url' => wp_get_attachment_image_url($attach_id, 'thumbnail'),
    ]);
});

/* ── Render page ─────────────────────────────────────────────────────────── */
function ea_render_page() {
    $nonce = wp_create_nonce('ea_image_manager_nonce');
    $ajax  = admin_url('admin-ajax.php');

    // Get all product sub-categories (exclude top-level cats with no parent)
    $terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false, 'number' => 200]);

    // Separate parents and children
    $parents  = [];
    $children = [];
    foreach ($terms as $t) {
        if ($t->parent == 0) $parents[$t->term_id]  = $t;
        else                 $children[$t->parent][] = $t;
    }
    ?>
    <style>
        #ea-imager { font-family: -apple-system, sans-serif; padding: 20px; max-width: 1200px; }
        #ea-imager h1 { color: #1e1e2e; font-size: 24px; margin-bottom: 6px; }
        #ea-imager .subtitle { color: #666; margin-bottom: 24px; font-size: 14px; }
        .ea-group { margin-bottom: 32px; }
        .ea-group h2 { background: #f59e0b; color: #000; padding: 8px 14px; border-radius: 6px;
                       font-size: 15px; margin: 0 0 10px; display:inline-block; }
        .ea-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 14px; }
        .ea-card { background: #fff; border: 2px solid #e5e7eb; border-radius: 10px; padding: 12px;
                   display: flex; flex-direction: column; gap: 8px; transition: border-color 0.2s; }
        .ea-card:hover { border-color: #f59e0b; }
        .ea-card.saved { border-color: #22c55e; }
        .ea-thumb { width: 100%; height: 120px; object-fit: cover; border-radius: 6px;
                    background: #f3f4f6; display: block; cursor: pointer; }
        .ea-thumb.empty { display: flex; align-items: center; justify-content: center;
                          color: #aaa; font-size: 28px; }
        .ea-name { font-weight: 600; font-size: 13px; color: #1f2937; }
        .ea-count { font-size: 11px; color: #6b7280; }
        .ea-btn { background: #f59e0b; color: #000; border: none; padding: 7px 12px;
                  border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 12px;
                  transition: background 0.2s; }
        .ea-btn:hover { background: #d97706; }
        .ea-status { font-size: 11px; color: #22c55e; min-height: 16px; font-weight: 600; }
        .ea-note { background: #fffbeb; border: 1px solid #fcd34d; border-radius: 8px;
                   padding: 12px 16px; margin-bottom: 20px; font-size: 13px; color: #92400e; }
    </style>

    <div id="ea-imager">
        <h1>🖼️ Product Image Manager</h1>
        <p class="subtitle">Pick an image for each sub-category → it instantly updates all products in that category.</p>

        <div class="ea-note">
            💡 <strong>How to use:</strong>
            First go to <a href="<?= admin_url('upload.php') ?>" target="_blank"><strong>Media Library → Add New</strong></a>
            and upload your product photos. Then come back here and click <em>"Pick Image"</em> on each category.
        </div>

        <?php
        // Sort parents by name
        uasort($parents, fn($a,$b) => strcmp($a->name, $b->name));

        foreach ($parents as $parent_id => $parent):
            if (empty($children[$parent_id])) continue;
            $subcats = $children[$parent_id];
        ?>
        <div class="ea-group">
            <h2><?= esc_html($parent->name) ?></h2>
            <div class="ea-grid">
                <?php foreach ($subcats as $sub):
                    $saved_img_id = get_term_meta($sub->term_id, 'ea_category_image', true);
                    $thumb_url    = $saved_img_id ? wp_get_attachment_image_url($saved_img_id, 'thumbnail') : '';
                    $product_count = $sub->count;
                ?>
                <div class="ea-card <?= $thumb_url ? 'saved' : '' ?>"
                     id="card-<?= $sub->term_id ?>">

                    <?php if ($thumb_url): ?>
                        <img class="ea-thumb"
                             src="<?= esc_url($thumb_url) ?>"
                             id="thumb-<?= $sub->term_id ?>"
                             onclick="eaPick(<?= $sub->term_id ?>)"
                             title="Click to change image">
                    <?php else: ?>
                        <div class="ea-thumb empty" id="thumb-<?= $sub->term_id ?>"
                             onclick="eaPick(<?= $sub->term_id ?>)"
                             title="Click to pick image">📷</div>
                    <?php endif; ?>

                    <div class="ea-name"><?= esc_html($sub->name) ?></div>
                    <div class="ea-count"><?= $product_count ?> products</div>
                    <button class="ea-btn" onclick="eaPick(<?= $sub->term_id ?>)">
                        <?= $thumb_url ? '🔄 Change Image' : '📷 Pick Image' ?>
                    </button>
                    <div class="ea-status" id="status-<?= $sub->term_id ?>">
                        <?= $thumb_url ? '✓ Image assigned' : '' ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <script>
    var mediaFrame;
    var currentTermId;

    function eaPick(termId) {
        currentTermId = termId;
        if (mediaFrame) { mediaFrame.open(); return; }

        mediaFrame = wp.media({
            title: 'Select Product Image',
            button: { text: 'Use This Image' },
            multiple: false,
            library: { type: 'image' }
        });

        mediaFrame.on('select', function() {
            var attachment = mediaFrame.state().get('selection').first().toJSON();
            eaAssign(currentTermId, attachment.id, attachment.url);
        });

        mediaFrame.open();
    }

    function eaAssign(termId, attachId, thumbUrl) {
        var status = document.getElementById('status-' + termId);
        var card   = document.getElementById('card-' + termId);
        var thumbEl = document.getElementById('thumb-' + termId);

        status.textContent = '⏳ Assigning...';
        status.style.color = '#f59e0b';

        jQuery.post('<?= $ajax ?>', {
            action:    'ea_assign_image',
            nonce:     '<?= $nonce ?>',
            term_id:   termId,
            attach_id: attachId
        }, function(resp) {
            if (resp.success) {
                var count = resp.data.count;
                var finalThumb = resp.data.thumb_url || thumbUrl;

                status.textContent = '✓ Done! ' + count + ' products updated';
                status.style.color = '#22c55e';
                card.classList.add('saved');

                // Update thumbnail preview
                if (thumbEl.tagName === 'DIV') {
                    var img = document.createElement('img');
                    img.className = 'ea-thumb';
                    img.id = 'thumb-' + termId;
                    img.src = finalThumb;
                    img.onclick = function() { eaPick(termId); };
                    thumbEl.parentNode.replaceChild(img, thumbEl);
                } else {
                    thumbEl.src = finalThumb;
                }

                // Update button text
                var btn = card.querySelector('.ea-btn');
                btn.textContent = '🔄 Change Image';
            } else {
                status.textContent = '✗ Error: ' + resp.data;
                status.style.color = '#ef4444';
            }
        });
    }
    </script>
    <?php
}
