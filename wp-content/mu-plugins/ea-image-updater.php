<?php
/**
 * Plugin Name: EA Image Updater
 * Description: Match unattached images to catalogue SKUs and update title/alt text.
 */

add_action('admin_menu', function () {
    add_media_page(
        'EA Image Updater',
        'EA Image Updater',
        'manage_options',
        'ea-image-updater',
        'ea_image_updater_page'
    );
});

function ea_normalize($str) {
    $str = strtolower($str);
    $str = preg_replace('/\.\w+$/', '', $str);          // strip extension
    $str = preg_replace('/[-_\.]+/', ' ', $str);         // dashes/underscores → space
    $str = preg_replace('/\s*\d+\s*x\s*\d+\s*/', ' ', $str); // strip WxH dimensions
    $str = preg_replace('/\s*\d+(px|gsm|mm|cm|pt)\s*/i', ' $1 ', $str); // keep unit context
    $str = preg_replace('/\s+[0-9]+\s*$/', '', $str);    // strip trailing numbers
    $str = preg_replace('/\s+-\s*\d+$/', '', $str);      // strip " -1" suffix (WP rename)
    $str = preg_replace('/\s+/', ' ', trim($str));
    return $str;
}

function ea_best_match($imageStr, $catalogue) {
    $norm = ea_normalize($imageStr);
    $best = null;
    $bestScore = 0;

    foreach ($catalogue as $entry) {
        $candidate = strtolower($entry['group'] . ' ' . $entry['name']);
        similar_text($norm, $candidate, $pct);
        if ($pct > $bestScore) {
            $bestScore = $pct;
            $best = $entry;
        }
        // Also try just the name
        $candidate2 = strtolower($entry['name']);
        similar_text($norm, $candidate2, $pct2);
        if ($pct2 > $bestScore) {
            $bestScore = $pct2;
            $best = $entry;
        }
    }
    return ['entry' => $best, 'score' => round($bestScore, 1)];
}

function ea_image_updater_page() {
    if (!current_user_can('manage_options')) wp_die('Not allowed.');

    $json_path = __DIR__ . '/ea-catalogue.json';
    if (!file_exists($json_path)) {
        echo '<div class="notice notice-error"><p>Catalogue JSON not found at: ' . esc_html($json_path) . '</p></div>';
        return;
    }

    $catalogue = json_decode(file_get_contents($json_path), true);
    if (!$catalogue) {
        echo '<div class="notice notice-error"><p>Failed to parse catalogue JSON.</p></div>';
        return;
    }

    // Build SKU lookup for dropdown
    $sku_options = [];
    foreach ($catalogue as $entry) {
        $sku_options[$entry['sku']] = $entry['sku'] . ' — ' . $entry['group'] . ' › ' . $entry['name'];
    }

    // Handle update submission
    $updated = 0;
    $skipped = 0;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ea_upd_nonce'])) {
        if (!wp_verify_nonce($_POST['ea_upd_nonce'], 'ea_image_updater')) wp_die('Security check failed.');

        $actions      = isset($_POST['ea_action'])      ? (array)$_POST['ea_action']      : [];
        $image_ids    = isset($_POST['ea_image_id'])    ? (array)$_POST['ea_image_id']    : [];
        $skus         = isset($_POST['ea_sku'])         ? (array)$_POST['ea_sku']         : [];
        $modes        = isset($_POST['ea_mode'])        ? (array)$_POST['ea_mode']        : [];
        $manual_titles = isset($_POST['ea_manual_title']) ? (array)$_POST['ea_manual_title'] : [];
        $manual_alts   = isset($_POST['ea_manual_alt'])   ? (array)$_POST['ea_manual_alt']   : [];

        $sku_map = [];
        foreach ($catalogue as $entry) {
            $sku_map[$entry['sku']] = $entry;
        }

        foreach ($image_ids as $i => $img_id) {
            $img_id = intval($img_id);
            $action = $actions[$i] ?? 'skip';
            if ($action !== 'update') { $skipped++; continue; }

            $mode = $modes[$i] ?? 'sku';

            if ($mode === 'manual') {
                $new_title = sanitize_text_field($manual_titles[$i] ?? '');
                $new_alt   = sanitize_text_field($manual_alts[$i]   ?? '');
                if ($new_title === '' && $new_alt === '') { $skipped++; continue; }
            } else {
                $sku   = sanitize_text_field($skus[$i] ?? '');
                $entry = $sku_map[$sku] ?? null;
                if (!$entry || !$img_id) { $skipped++; continue; }
                $new_title = sanitize_text_field($entry['group'] . ' ' . $entry['name']);
                $new_alt   = sanitize_text_field($entry['alt']);
            }

            if ($new_title !== '') wp_update_post(['ID' => $img_id, 'post_title' => $new_title]);
            if ($new_alt   !== '') update_post_meta($img_id, '_wp_attachment_image_alt', $new_alt);
            $updated++;
        }
    }

    // Fetch unattached images
    global $wpdb;
    $images = $wpdb->get_results("
        SELECT p.ID, p.post_title, pm.meta_value AS file_path,
               COALESCE(pm2.meta_value,'') AS current_alt
        FROM {$wpdb->posts} p
        JOIN {$wpdb->postmeta} pm  ON p.ID = pm.post_id  AND pm.meta_key  = '_wp_attached_file'
        LEFT JOIN {$wpdb->postmeta} pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_wp_attachment_image_alt'
        WHERE p.post_type = 'attachment'
          AND p.post_mime_type LIKE 'image/%'
          AND p.post_parent = 0
        ORDER BY pm.meta_value
    ");

    $total = count($images);
    $action_url = admin_url('upload.php?page=ea-image-updater');
    ?>
    <style>
    #eau * { box-sizing: border-box; }
    #eau { font-family: Arial, sans-serif; font-size: 13px; }
    #eau-bar {
        position: sticky; top: 32px; z-index: 99;
        background: #1d2327; color: #fff;
        padding: 10px 16px; display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
        border-radius: 4px; margin-bottom: 16px; box-shadow: 0 2px 8px rgba(0,0,0,.3);
    }
    #eau-bar h2 { font-size: 15px; color:#fff; margin:0; }
    .eau-info { color:#bbb; font-size:12px; }
    .eau-spacer { flex:1; }
    .eau-btn { padding:6px 14px; border:none; border-radius:3px; cursor:pointer; font-size:12px; font-weight:700; }
    .eau-all    { background:#2271b1; color:#fff; }
    .eau-none   { background:#50575e; color:#fff; }
    .eau-save   { background:#007017; color:#fff; font-size:13px; padding:7px 20px; }
    .eau-btn:hover { opacity:.85; }
    .eau-count  { background:#007017; color:#fff; border-radius:10px; padding:1px 8px; font-size:12px; }
    .eau-msg-ok  { background:#00a32a; color:#fff; padding:10px 16px; border-radius:3px; margin-bottom:14px; font-weight:bold; }

    #eau table { width:100%; border-collapse:collapse; background:#fff; }
    #eau th { background:#1d2327; color:#fff; padding:8px 10px; text-align:left; font-size:12px; position:sticky; top:72px; z-index:10; }
    #eau td { padding:7px 10px; border-bottom:1px solid #e5e5e5; vertical-align:middle; font-size:12px; }
    #eau tr:hover td { background:#f6f7f7; }
    #eau tr.skipped td { opacity:.5; }

    .eau-thumb { width:70px; height:55px; object-fit:contain; background:#f6f7f7; display:block; border:1px solid #ddd; }
    .eau-score-hi  { color:#007017; font-weight:bold; }
    .eau-score-med { color:#996800; font-weight:bold; }
    .eau-score-lo  { color:#d63638; font-weight:bold; }

    .eau-sku-sel { width:100%; font-size:11px; padding:3px; }
    .eau-new-title { font-size:11px; color:#007017; font-weight:bold; display:block; margin-top:2px; }
    .eau-new-alt   { font-size:11px; color:#2271b1; display:block; margin-top:2px; max-width:260px; word-break:break-word; }

    .eau-toggle { display:flex; gap:4px; }
    .eau-toggle label { cursor:pointer; }
    .eau-upd-btn { padding:3px 10px; border:1px solid #007017; border-radius:3px; font-size:11px; font-weight:700; cursor:pointer; background:#f6f7f7; color:#007017; }
    .eau-upd-btn.active { background:#d7f3dd; border-color:#007017; }
    .eau-skip-btn { padding:3px 10px; border:1px solid #ddd; border-radius:3px; font-size:11px; font-weight:700; cursor:pointer; background:#f6f7f7; color:#666; }
    .eau-skip-btn.active { background:#f0f0f0; border-color:#999; }

    .eau-filter { padding:6px 10px; border:1px solid #ddd; border-radius:3px; font-size:12px; width:220px; }

    .eau-manual-btn { padding:3px 10px; border:1px solid #9c27b0; border-radius:3px; font-size:11px; font-weight:700; cursor:pointer; background:#f6f7f7; color:#9c27b0; }
    .eau-manual-btn.active { background:#f3e5f5; border-color:#7b1fa2; }
    .eau-manual-fields { display:none; margin-top:6px; }
    .eau-manual-fields input { width:100%; padding:4px 6px; font-size:11px; border:1px solid #bbb; border-radius:3px; margin-top:3px; }
    .eau-manual-fields label { font-size:10px; color:#555; font-weight:bold; }
    </style>

    <div id="eau">

    <?php if ($updated || $skipped): ?>
    <div class="eau-msg-ok">Updated <?php echo $updated; ?> image(s). Skipped <?php echo $skipped; ?>.</div>
    <?php endif; ?>

    <form method="post" action="<?php echo esc_url($action_url); ?>" id="eau-form">
    <?php wp_nonce_field('ea_image_updater', 'ea_upd_nonce'); ?>

    <div id="eau-bar">
        <h2>EA Image Updater</h2>
        <span class="eau-info">Unattached: <strong><?php echo $total; ?></strong></span>
        <span class="eau-info">To update: <span class="eau-count" id="eau-cnt">0</span></span>
        <input type="text" class="eau-filter" id="eau-filter" placeholder="Filter by filename..." oninput="eauFilter(this.value)">
        <div class="eau-spacer"></div>
        <button type="button" class="eau-btn eau-all"  onclick="eauSetAll('update')">✓ Update All</button>
        <button type="button" class="eau-btn eau-none" onclick="eauSetAll('skip')">✗ Skip All</button>
        <button type="submit" class="eau-btn eau-save" onclick="return eauConfirm()">💾 Save Updates</button>
    </div>
    </form>

    <form method="post" action="<?php echo esc_url($action_url); ?>" id="eau-main-form">
    <?php wp_nonce_field('ea_image_updater', 'ea_upd_nonce'); ?>

    <table id="eau-table">
    <thead>
        <tr>
            <th>Image</th>
            <th>ID / Current Title</th>
            <th>Best Match SKU</th>
            <th>New Title &amp; Alt Text</th>
            <th style="width:90px">Match %</th>
            <th style="width:150px">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sku_json = json_encode($sku_options);
    foreach ($images as $img):
        $match = ea_best_match($img->post_title ?: basename($img->file_path), $catalogue);
        $entry = $match['entry'];
        $score = $match['score'];
        $scoreClass = $score >= 70 ? 'eau-score-hi' : ($score >= 45 ? 'eau-score-med' : 'eau-score-lo');
        $defaultAction = $score >= 45 ? 'update' : 'skip';
        $url = wp_get_attachment_url($img->ID);
        if (!$url) $url = content_url('uploads/' . $img->file_path);
        $new_title = $entry ? esc_html($entry['group'] . ' ' . $entry['name']) : '';
        $new_alt   = $entry ? esc_html($entry['alt']) : '';
        $matched_sku = $entry ? $entry['sku'] : '';
    ?>
    <tr id="eau-row-<?php echo $img->ID; ?>" data-name="<?php echo esc_attr(strtolower($img->post_title . ' ' . $img->file_path)); ?>">
        <td><img class="eau-thumb" src="<?php echo esc_url($url); ?>" alt="" loading="lazy"></td>
        <td>
            <strong style="font-size:11px">ID: <?php echo $img->ID; ?></strong><br>
            <span style="color:#555;font-size:11px;word-break:break-all"><?php echo esc_html($img->post_title ?: basename($img->file_path)); ?></span>
            <?php if ($img->current_alt): ?>
            <span style="color:#999;font-size:10px;display:block">Alt: <?php echo esc_html($img->current_alt); ?></span>
            <?php endif; ?>
        </td>
        <td>
            <select class="eau-sku-sel" id="sku-<?php echo $img->ID; ?>"
                    onchange="eauSkuChange(<?php echo $img->ID; ?>, this.value)"
                    name="ea_sku[]">
                <option value="">— none —</option>
                <?php foreach ($sku_options as $s => $label): ?>
                <option value="<?php echo esc_attr($s); ?>" <?php selected($s, $matched_sku); ?>>
                    <?php echo esc_html($label); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <div id="sku-preview-<?php echo $img->ID; ?>">
                <span class="eau-new-title" id="title-<?php echo $img->ID; ?>"><?php echo $new_title; ?></span>
                <span class="eau-new-alt"   id="alt-<?php echo $img->ID; ?>"><?php echo $new_alt; ?></span>
            </div>
            <div class="eau-manual-fields" id="manual-fields-<?php echo $img->ID; ?>">
                <label>Title</label>
                <input type="text" id="manual-title-<?php echo $img->ID; ?>" placeholder="Enter image title..." value="" oninput="eauSyncManual(<?php echo $img->ID; ?>,'title',this.value)">
                <label>Alt Text</label>
                <input type="text" id="manual-alt-<?php echo $img->ID; ?>"   placeholder="Enter alt text..."    value="" oninput="eauSyncManual(<?php echo $img->ID; ?>,'alt',this.value)">
            </div>
            <input type="hidden" name="ea_manual_title[]" id="mth-<?php echo $img->ID; ?>" value="">
            <input type="hidden" name="ea_manual_alt[]"   id="mal-<?php echo $img->ID; ?>" value="">
        </td>
        <td><span class="<?php echo $scoreClass; ?>"><?php echo $score; ?>%</span></td>
        <td>
            <input type="hidden" name="ea_image_id[]" value="<?php echo $img->ID; ?>">
            <input type="hidden" name="ea_action[]" id="action-<?php echo $img->ID; ?>" value="<?php echo $defaultAction; ?>">
            <input type="hidden" name="ea_mode[]"   id="mode-<?php echo $img->ID; ?>"   value="sku">
            <div class="eau-toggle" style="flex-wrap:wrap;gap:3px;">
                <button type="button" class="eau-upd-btn <?php echo $defaultAction==='update'?'active':''; ?>"
                        id="upd-<?php echo $img->ID; ?>"
                        onclick="eauAction(<?php echo $img->ID; ?>,'update')">Update</button>
                <button type="button" class="eau-skip-btn <?php echo $defaultAction==='skip'?'active':''; ?>"
                        id="skip-<?php echo $img->ID; ?>"
                        onclick="eauAction(<?php echo $img->ID; ?>,'skip')">Skip</button>
                <button type="button" class="eau-manual-btn"
                        id="manual-<?php echo $img->ID; ?>"
                        onclick="eauToggleManual(<?php echo $img->ID; ?>)">&#9998; Manual</button>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    </form>
    </div>

    <script>
    const catalogue = <?php
        $catMap = [];
        foreach ($catalogue as $entry) {
            $catMap[$entry['sku']] = ['group' => $entry['group'], 'name' => $entry['name'], 'alt' => $entry['alt']];
        }
        echo json_encode($catMap);
    ?>;

    let eauCount = 0;

    function eauInit() {
        eauCount = document.querySelectorAll('input[name="ea_action[]"][value="update"]').length;
        document.getElementById('eau-cnt').textContent = eauCount;
        // Move main form save button to top bar form submit
        document.querySelector('.eau-save').addEventListener('click', function(e) {
            e.preventDefault();
            if (eauConfirm()) document.getElementById('eau-main-form').submit();
        });
    }

    function eauAction(id, act) {
        const inp  = document.getElementById('action-' + id);
        const updB = document.getElementById('upd-' + id);
        const skpB = document.getElementById('skip-' + id);
        const row  = document.getElementById('eau-row-' + id);
        const prev = inp.value;
        inp.value = act;
        if (act === 'update') {
            updB.classList.add('active'); skpB.classList.remove('active');
            row.classList.remove('skipped');
            if (prev !== 'update') eauCount++;
        } else {
            skpB.classList.add('active'); updB.classList.remove('active');
            row.classList.add('skipped');
            if (prev === 'update') eauCount--;
        }
        document.getElementById('eau-cnt').textContent = eauCount;
    }

    function eauSetAll(act) {
        document.querySelectorAll('[id^="eau-row-"]').forEach(row => {
            if (row.style.display === 'none') return;
            const id = row.id.replace('eau-row-', '');
            eauAction(id, act);
        });
    }

    function eauSkuChange(id, sku) {
        const entry = catalogue[sku];
        const titleEl = document.getElementById('title-' + id);
        const altEl   = document.getElementById('alt-' + id);
        if (entry) {
            titleEl.textContent = entry.group + ' ' + entry.name;
            altEl.textContent   = entry.alt;
        } else {
            titleEl.textContent = '';
            altEl.textContent   = '';
        }
    }

    function eauToggleManual(id) {
        const modeInp   = document.getElementById('mode-' + id);
        const manualBtn = document.getElementById('manual-' + id);
        const manualDiv = document.getElementById('manual-fields-' + id);
        const skuPrev   = document.getElementById('sku-preview-' + id);
        const skuSel    = document.getElementById('sku-' + id);
        const isManual  = modeInp.value === 'manual';
        if (isManual) {
            // Switch back to SKU mode
            modeInp.value = 'sku';
            manualBtn.classList.remove('active');
            manualDiv.style.display = 'none';
            skuPrev.style.display   = '';
            skuSel.disabled = false;
        } else {
            // Switch to manual mode
            modeInp.value = 'manual';
            manualBtn.classList.add('active');
            manualDiv.style.display = 'block';
            skuPrev.style.display   = 'none';
            skuSel.disabled = true;
            // Auto-fill from current SKU match as starting point
            const titleEl = document.getElementById('title-' + id);
            const altEl   = document.getElementById('alt-' + id);
            const mTitle  = document.getElementById('manual-title-' + id);
            const mAlt    = document.getElementById('manual-alt-' + id);
            if (!mTitle.value) mTitle.value = titleEl.textContent;
            if (!mAlt.value)   mAlt.value   = altEl.textContent;
            // Sync to hidden fields
            document.getElementById('mth-' + id).value = mTitle.value;
            document.getElementById('mal-' + id).value = mAlt.value;
            // Make sure action is set to update
            eauAction(id, 'update');
        }
    }

    function eauSyncManual(id, field, val) {
        const hiddenId = field === 'title' ? 'mth-' + id : 'mal-' + id;
        document.getElementById(hiddenId).value = val;
    }

    function eauFilter(val) {
        const v = val.toLowerCase();
        document.querySelectorAll('[id^="eau-row-"]').forEach(row => {
            const name = row.dataset.name || '';
            row.style.display = (!v || name.includes(v)) ? '' : 'none';
        });
    }

    function eauConfirm() {
        if (eauCount === 0) { alert('No images set to update.'); return false; }
        return confirm('Update ' + eauCount + ' image(s) with new title and alt text?');
    }

    document.addEventListener('DOMContentLoaded', eauInit);
    </script>
    <?php
}
