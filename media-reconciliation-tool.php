<?php
/**
 * Media Reconciliation Tool - V2
 * Added Success Modal and Batch Processing flow.
 */
define('WP_ADMIN', true);
require_once __DIR__ . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/admin.php';

// Handle Action Submission
$show_modal = false;
$success_text = "";
if (isset($_POST['reconcile_action'])) {
    $actions = $_POST['action'] ?? [];
    $total = 0;
    foreach ($actions as $pid => $data) {
        $decision = $data['decision'] ?? 'keep';
        $tid = ($decision === 'replace') ? ($data['target_thumb_id'] ?? 0) : (($decision === 'manual') ? ($data['manual_thumb_id'] ?: ($data['manual_id_fallback'] ?? 0)) : 0);
        
        if ($tid) { set_post_thumbnail($pid, $tid); $total++; }
        elseif ($decision === 'delete' || $decision === 'park') {
            delete_post_thumbnail($pid);
            if ($decision === 'park') wp_update_post(['ID' => $pid, 'post_status' => 'draft']);
            $total++;
        }
        if (!empty($data['follow_up'])) update_post_meta($pid, '_ea_image_followup', 'yes');
        else delete_post_meta($pid, '_ea_image_followup');
        
        // Mark as processed in this session
        update_post_meta($pid, '_ea_last_reconciled', time());
    }
    $show_modal = true;
    $success_text = "Decisions applied successfully to $total products.";
}

// Fetch 20 random products that haven't been reconciled yet
$products = get_posts([
    'post_type'      => 'product',
    'posts_per_page' => 20,
    'orderby'        => 'rand',
    'post_status'    => 'publish',
    'meta_query'     => [
        [
            'key'     => '_ea_last_reconciled',
            'compare' => 'NOT EXISTS'
        ]
    ]
]);

function get_match($name) {
    global $wpdb;
    $words = array_filter(explode(' ', preg_replace('/[^a-zA-Z0-9\s]/', '', $name)), function($w){return strlen($w)>3;});
    if (!$words) return null;
    $where = implode(' AND ', array_map(function($w) use ($wpdb){return $wpdb->prepare("post_title LIKE %s", '%'.$wpdb->esc_like($w).'%');}, $words));
    return $wpdb->get_row("SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND ($where) LIMIT 1");
}

wp_enqueue_media();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Media Reconciliation Dashboard</title>
    <?php wp_head(); ?>
    <script>var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';</script>
    <style>
        body { font-family: -apple-system, system-ui, sans-serif; background: #f0f2f5; padding: 40px; margin: 0; }
        .wrap { max-width: 1400px; margin: auto; background: #fff; padding: 40px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px; }
        h1 { margin: 0; font-size: 24px; color: #1a202c; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; background: #f7fafc; padding: 15px; color: #4a5568; font-size: 13px; text-transform: uppercase; }
        td { padding: 25px 15px; border-bottom: 1px solid #edf2f7; vertical-align: top; }
        .img-box { width: 160px; height: 160px; object-fit: cover; border-radius: 10px; border: 3px solid #f1f5f9; }
        .sugg-img { border-color: #3182ce; }
        .manual-zone { background: #e6fffa; border: 2px dashed #38b2ac; padding: 12px; border-radius: 10px; text-align: center; }
        .btn-main { background: #1a202c; color: #fff; border: none; padding: 20px 50px; border-radius: 12px; font-weight: bold; cursor: pointer; font-size: 18px; box-shadow: 0 4px 14px rgba(0,0,0,0.1); }
        
        /* Modal Styles */
        #success-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); display: <?php echo $show_modal ? 'flex' : 'none'; ?>; align-items: center; justify-content: center; z-index: 10000; }
        .modal-content { background: #fff; padding: 40px; border-radius: 20px; text-align: center; max-width: 450px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); }
        .modal-icon { font-size: 60px; margin-bottom: 20px; }
        .modal-title { font-size: 22px; font-weight: bold; margin-bottom: 10px; }
        .modal-btns { display: flex; gap: 15px; justify-content: center; margin-top: 30px; }
        .btn-cont { background: #38a169; color: #fff; border: none; padding: 12px 25px; border-radius: 8px; cursor: pointer; font-weight: bold; flex: 1; }
        .btn-quit { background: #e53e3e; color: #fff; border: none; padding: 12px 25px; border-radius: 8px; cursor: pointer; font-weight: bold; flex: 1; }
        
        .radio-stack { background: #f8fafc; padding: 10px; border-radius: 8px; line-height: 1.8; font-size: 13px; }
    </style>
</head>
<body>

<div class="wrap">
    <div class="top-bar">
        <h1>📦 Product Image Reconciliation</h1>
        <div style="font-size:13px; color:#718096;">Analyzing 5 Products | <b>Logged in as Admin</b></div>
    </div>

    <form method="POST">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Current Image</th>
                    <th>Library Suggestion</th>
                    <th>Manual Select</th>
                    <th>Decision</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): 
                    $curr_url = get_the_post_thumbnail_url($p->ID, 'medium');
                    $match = get_match($p->post_title);
                    $match_url = $match ? wp_get_attachment_image_url($match->ID, 'medium') : '';
                ?>
                <tr>
                    <td style="width: 200px;">
                        <div style="font-weight:bold;"><?php echo $p->post_title; ?></div>
                        <div style="font-size:11px; color:#cbd5e0; margin-top:5px;">UID: <?php echo $p->ID; ?></div>
                    </td>
                    <td>
                        <?php if($curr_url): ?><img src="<?php echo $curr_url; ?>" class="img-box"><?php else: ?><div style="width:160px; height:160px; background:#f7fafc; border-radius:10px; border:1px solid #edf2f7;"></div><?php endif; ?>
                    </td>
                    <td>
                        <?php if($match_url): ?>
                            <img src="<?php echo $match_url; ?>" class="img-box sugg-img">
                            <input type="hidden" name="action[<?php echo $p->ID; ?>][target_thumb_id]" value="<?php echo $match->ID; ?>">
                        <?php else: ?>
                            <div style="color:#e53e3e; font-size:11px; padding:10px;">No Library Match</div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="manual-zone">
                            <button type="button" onclick="doSel(<?php echo $p->ID; ?>)" style="background:#38b2ac; border:none; color:#fff; padding:8px 15px; border-radius:5px; cursor:pointer; font-size:12px;">📂 Select Library</button>
                            <div style="margin:8px 0; font-size:10px; color:#4a5568;">Or ID: <input type="text" name="action[<?php echo $p->ID; ?>][manual_id_fallback]" style="width:50px; border:1px solid #38b2ac; border-radius:3px;"></div>
                            <img id="prev_<?php echo $p->ID; ?>" class="img-box" style="display:none; width:100px; height:100px; margin:auto;">
                            <input type="hidden" name="action[<?php echo $p->ID; ?>][manual_thumb_id]" id="inp_<?php echo $p->ID; ?>">
                        </div>
                    </td>
                    <td>
                        <div class="radio-stack">
                            <label><input type="radio" name="action[<?php echo $p->ID; ?>][decision]" value="keep" checked> Keep Current</label><br>
                            <?php if($match): ?><label style="color:#2b6cb0;font-weight:bold;"><input type="radio" name="action[<?php echo $p->ID; ?>][decision]" value="replace"> Replace with AI</label><br><?php endif; ?>
                            <label style="color:#2f855a;font-weight:bold;"><input type="radio" name="action[<?php echo $p->ID; ?>][decision]" value="manual"> Use Manual Select</label><br>
                            <label style="color:#c53030;"><input type="radio" name="action[<?php echo $p->ID; ?>][decision]" value="park"> Delete & Park</label>
                        </div>
                        <label style="display:block; margin-top:10px; background:#fffaf0; padding:8px; border:1px solid #fbd38d; border-radius:6px; font-size:12px;">
                            <input type="checkbox" name="action[<?php echo $p->ID; ?>][follow_up]"> ⚠️ Priority Follow Up
                        </label>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div style="text-align:center; margin-top:40px;">
            <button type="submit" name="reconcile_action" class="btn-main">🚀 Finalize Selections (Test 5)</button>
        </div>
    </form>
</div>

<!-- SUCCESS MODAL -->
<div id="success-modal">
    <div class="modal-content">
        <div class="modal-icon">✅</div>
        <div class="modal-title">Batch Applied Successfully!</div>
        <div style="color:#718096; margin-bottom:20px;"><?php echo $success_text; ?></div>
        <div class="modal-btns">
            <button class="btn-cont" onclick="location.reload()">Process next batch →</button>
            <button class="btn-quit" onclick="location.href='<?php echo admin_url(); ?>'">Quit Tool</button>
        </div>
    </div>
</div>

<script>
let frame; let activeId;
function doSel(pid) {
    activeId = pid;
    if (frame) { frame.open(); return; }
    frame = wp.media({ title: 'Select Image', button: { text: 'Assign' }, multiple: false });
    frame.on('select', function() {
        let a = frame.state().get('selection').first().toJSON();
        document.getElementById('inp_'+activeId).value = a.id;
        let img = document.getElementById('prev_'+activeId); img.src = a.url; img.style.display = 'block';
        document.querySelector('input[name="action['+activeId+'][decision]"][value="manual"]').checked = true;
    });
    frame.open();
}
</script>
<?php wp_footer(); wp_print_media_templates(); ?>
</body>
</html>
