<?php
/**
 * Plugin Name: EA Image Manager
 * Description: Manage unattached media images — keep or permanently delete.
 */

add_action('admin_menu', function () {
    add_media_page(
        'EA Image Manager',
        'EA Image Manager',
        'manage_options',
        'ea-image-manager',
        'ea_image_manager_page'
    );
});

function ea_image_manager_page() {
    if (!current_user_can('manage_options')) {
        wp_die('Not allowed.');
    }

    $message = '';
    $deleted_count = 0;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ea_nonce'])) {
        if (!wp_verify_nonce($_POST['ea_nonce'], 'ea_image_manager')) {
            wp_die('Security check failed.');
        }
        $to_delete = isset($_POST['delete_ids']) ? array_map('intval', (array)$_POST['delete_ids']) : [];
        foreach ($to_delete as $id) {
            if ($id > 0 && wp_delete_attachment($id, true)) {
                $deleted_count++;
            }
        }
        $message = "Permanently deleted $deleted_count image(s).";
    }

    global $wpdb;
    $images = $wpdb->get_results("
        SELECT p.ID, p.post_title, pm.meta_value AS file_path
        FROM {$wpdb->posts} p
        JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id AND pm.meta_key = '_wp_attached_file'
        WHERE p.post_type = 'attachment'
          AND p.post_mime_type LIKE 'image/%'
          AND p.post_parent = 0
        ORDER BY pm.meta_value
    ");

    $total = count($images);
    $action_url = admin_url('upload.php?page=ea-image-manager');
    ?>
    <style>
    #ea-wrap * { box-sizing: border-box; }
    #ea-wrap { font-family: Arial, sans-serif; }
    #ea-topbar {
        position: sticky; top: 32px; z-index: 99;
        background: #1d2327; color: #fff;
        padding: 10px 16px;
        display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
        border-radius: 4px; margin-bottom: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,.3);
    }
    #ea-topbar h2 { font-size: 15px; color: #fff; margin: 0; }
    #ea-topbar .info { color: #bbb; font-size: 12px; }
    #ea-topbar .spacer { flex: 1; }
    .ea-btn { padding: 6px 14px; border: none; border-radius: 3px; cursor: pointer; font-size: 12px; font-weight: 700; }
    .ea-btn-all    { background: #2271b1; color: #fff; }
    .ea-btn-clear  { background: #50575e; color: #fff; }
    .ea-btn-delete { background: #d63638; color: #fff; font-size: 13px; padding: 7px 18px; }
    .ea-btn:hover  { opacity: .85; }
    .ea-counter { background: #d63638; color: #fff; border-radius: 10px; padding: 1px 8px; font-size: 12px; }
    .ea-msg { background: #00a32a; color: #fff; padding: 10px 16px; border-radius: 3px; margin-bottom: 14px; font-weight: bold; }
    .ea-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
        gap: 12px;
    }
    .ea-card {
        background: #fff; border: 2px solid #ddd; border-radius: 5px;
        overflow: hidden; cursor: pointer;
    }
    .ea-card:hover { border-color: #999; }
    .ea-card.del { border-color: #d63638; background: #fff5f5; }
    .ea-card.del .ea-img-wrap { opacity: .55; }
    .ea-img-wrap {
        width: 100%; height: 140px; background: #f6f7f7;
        display: flex; align-items: center; justify-content: center; overflow: hidden;
    }
    .ea-img-wrap img { max-width: 100%; max-height: 100%; object-fit: contain; }
    .ea-card-body  { padding: 7px 8px; }
    .ea-card-id    { font-weight: bold; font-size: 11px; color: #666; }
    .ea-card-name  { font-size: 11px; color: #333; word-break: break-word; line-height: 1.3; margin-top: 2px; }
    .ea-toggle { display: flex; gap: 4px; margin-top: 7px; }
    .ea-toggle button {
        flex: 1; padding: 4px 0; font-size: 11px; font-weight: 700;
        border: 1px solid #ddd; border-radius: 3px; background: #f6f7f7; cursor: pointer;
    }
    .ea-toggle .kb { color: #007017; }
    .ea-toggle .db { color: #d63638; }
    .ea-toggle .kb.on { background: #d7f3dd; border-color: #007017; }
    .ea-toggle .db.on { background: #fde8e8; border-color: #d63638; }
    .ea-empty { text-align:center; padding: 60px; color: #666; font-size: 15px; }
    </style>

    <div id="ea-wrap">
    <form method="post" action="<?php echo esc_url($action_url); ?>" id="ea-form">
    <?php wp_nonce_field('ea_image_manager', 'ea_nonce'); ?>

    <div id="ea-topbar">
        <h2>EA Image Manager</h2>
        <span class="info">Unattached: <strong><?php echo $total; ?></strong></span>
        <span class="info">Marked: <span class="ea-counter" id="ea-count">0</span></span>
        <div class="spacer"></div>
        <button type="button" class="ea-btn ea-btn-all" onclick="eaAll()">Mark All Delete</button>
        <button type="button" class="ea-btn ea-btn-clear" onclick="eaClear()">Clear All</button>
        <button type="submit" class="ea-btn ea-btn-delete" onclick="return eaConfirm()">&#x1F5D1; Delete Marked</button>
    </div>
    </form>

    <?php if ($message): ?>
    <div class="ea-msg"><?php echo esc_html($message); ?></div>
    <?php endif; ?>

    <?php if ($total === 0): ?>
    <div class="ea-empty">No unattached images found.</div>
    <?php else: ?>
    <div class="ea-grid">
    <?php foreach ($images as $img):
        $url = wp_get_attachment_url($img->ID);
        if (!$url) $url = content_url('uploads/' . $img->file_path);
        $title = esc_html($img->post_title);
    ?>
        <div class="ea-card" id="ec-<?php echo $img->ID; ?>" data-id="<?php echo $img->ID; ?>">
            <div class="ea-img-wrap">
                <img src="<?php echo esc_url($url); ?>" alt="<?php echo $title; ?>" loading="lazy">
            </div>
            <div class="ea-card-body">
                <div class="ea-card-id">ID: <?php echo $img->ID; ?></div>
                <div class="ea-card-name"><?php echo $title; ?></div>
                <div class="ea-toggle">
                    <button type="button" class="kb on" onclick="eaSet(<?php echo $img->ID; ?>,'k',event)">&#10003; Keep</button>
                    <button type="button" class="db"     onclick="eaSet(<?php echo $img->ID; ?>,'d',event)">&#10005; Delete</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
    <?php endif; ?>
    </div>

    <script>
    const eaDel = new Set();
    function eaSet(id, act, e) {
        e && e.stopPropagation();
        const c = document.getElementById('ec-' + id);
        const kb = c.querySelector('.kb'), db = c.querySelector('.db');
        if (act === 'd') {
            eaDel.add(id); c.classList.add('del');
            kb.classList.remove('on'); db.classList.add('on');
        } else {
            eaDel.delete(id); c.classList.remove('del');
            kb.classList.add('on'); db.classList.remove('on');
        }
        document.getElementById('ea-count').textContent = eaDel.size;
    }
    function eaAll()   { document.querySelectorAll('.ea-card[data-id]').forEach(c => eaSet(+c.dataset.id,'d',null)); }
    function eaClear() { document.querySelectorAll('.ea-card[data-id]').forEach(c => eaSet(+c.dataset.id,'k',null)); }
    function eaConfirm() {
        if (eaDel.size === 0) { alert('No images marked for deletion.'); return false; }
        if (!confirm('Permanently delete ' + eaDel.size + ' image(s)?\n\nFiles will be removed from disk. This cannot be undone.')) return false;
        const form = document.getElementById('ea-form');
        eaDel.forEach(id => {
            const inp = document.createElement('input');
            inp.type = 'hidden'; inp.name = 'delete_ids[]'; inp.value = id;
            form.appendChild(inp);
        });
        return true;
    }
    </script>
    <?php
}
