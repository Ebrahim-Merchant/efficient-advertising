<?php
/**
 * EA Computer Image Review Tool
 * View all WebP images from your computer, decide: Delete / Keep (ignore) / Upload to WordPress
 * Access: /ea-computer-images.php  —  DELETE THIS FILE when done
 */
define( 'WP_USE_THEMES', false );
require_once __DIR__ . '/wp-load.php';

if ( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) ) {
    auth_redirect();
    exit;
}

$upload_info = wp_upload_dir();
$uploads_url = $upload_info['baseurl'];
$uploads_dir = $upload_info['basedir'];

// Scan folder (copies of Desktop images placed here)
$scan_dir  = $uploads_dir . '/ea-computer-scan';
$scan_url  = $uploads_url . '/ea-computer-scan';
// Original Desktop source (for actual deletion later)
$desktop_src = 'C:/Users/merch/Desktop/mprinthouse-images';

// ── EXECUTE decisions (POST) ──────────────────────────────────────────────────
$exec_messages = [];
if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['_ea_nonce'] ) ) {
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_ea_nonce'] ) ), 'ea_computer_review' ) ) {
        wp_die( 'Invalid nonce' );
    }

    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $decisions = isset( $_POST['decisions'] ) && is_array( $_POST['decisions'] ) ? $_POST['decisions'] : [];

    foreach ( $decisions as $rel_path => $action ) {
        // rel_path is like "Custom-Flags/Blade-Flags/15-1-scaled.webp"
        $rel_path   = ltrim( sanitize_text_field( wp_unslash( $rel_path ) ), '/' );
        $scan_file  = realpath( $scan_dir . '/' . $rel_path );
        $real_scan  = realpath( $scan_dir );

        // Path traversal guard
        if ( ! $scan_file || ! $real_scan || strpos( $scan_file, $real_scan . DIRECTORY_SEPARATOR ) !== 0 ) {
            $exec_messages[] = [ 'type' => 'err', 'msg' => 'Skipped (invalid path): ' . esc_html( $rel_path ) ];
            continue;
        }

        $action = sanitize_text_field( $action );

        if ( $action === 'delete' ) {
            // Delete from scan folder AND Desktop source
            $desktop_file = str_replace( '/', DIRECTORY_SEPARATOR, $desktop_src . '/' . $rel_path );
            if ( file_exists( $scan_file ) )    { unlink( $scan_file ); }
            if ( file_exists( $desktop_file ) ) { unlink( $desktop_file ); }
            $exec_messages[] = [ 'type' => 'ok',  'msg' => '🗑 Deleted: ' . esc_html( basename( $rel_path ) ) ];

        } elseif ( $action === 'wp_small' || $action === 'wp_full' ) {
            // Upload to WordPress Media Library
            if ( ! file_exists( $scan_file ) ) {
                $exec_messages[] = [ 'type' => 'err', 'msg' => 'File missing: ' . esc_html( $rel_path ) ];
                continue;
            }

            // Destination inside uploads dated folder
            $upload_folder = $uploads_dir . '/' . date( 'Y/m' );
            if ( ! is_dir( $upload_folder ) ) { wp_mkdir_p( $upload_folder ); }

            $ext      = pathinfo( $scan_file, PATHINFO_EXTENSION );
            $basename = sanitize_file_name( pathinfo( $scan_file, PATHINFO_FILENAME ) ) . '.' . $ext;
            $dest     = $upload_folder . '/' . $basename;
            // Avoid overwrite
            $counter = 1;
            while ( file_exists( $dest ) ) {
                $dest = $upload_folder . '/' . sanitize_file_name( pathinfo( $scan_file, PATHINFO_FILENAME ) ) . '-' . $counter . '.' . $ext;
                $counter++;
            }

            if ( $action === 'wp_small' ) {
                // Resize to max 800px wide using WP's image editor
                $img_editor = wp_get_image_editor( $scan_file );
                if ( ! is_wp_error( $img_editor ) ) {
                    $img_editor->resize( 800, 800, false );
                    $img_editor->save( $dest );
                } else {
                    copy( $scan_file, $dest );
                }
            } else {
                // Full resolution — just copy
                copy( $scan_file, $dest );
            }

            $filetype  = wp_check_filetype( $dest );
            $attach_id = wp_insert_attachment(
                [
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => sanitize_file_name( pathinfo( $dest, PATHINFO_FILENAME ) ),
                    'post_content'   => '',
                    'post_status'    => 'inherit',
                ],
                $dest
            );
            if ( ! is_wp_error( $attach_id ) ) {
                wp_update_attachment_metadata( $attach_id, wp_generate_attachment_metadata( $attach_id, $dest ) );
                $label = $action === 'wp_small' ? 'Small (≤800px)' : 'Full resolution';
                $exec_messages[] = [ 'type' => 'ok', 'msg' => "✓ Uploaded [{$label}]: " . esc_html( basename( $dest ) ) . " (ID #{$attach_id})" ];
            } else {
                $exec_messages[] = [ 'type' => 'err', 'msg' => 'WP insert failed: ' . esc_html( $attach_id->get_error_message() ) ];
            }

        } else {
            // 'ignore' — keep on computer, do nothing
            $exec_messages[] = [ 'type' => 'info', 'msg' => '⏭ Ignored (kept on computer): ' . esc_html( basename( $rel_path ) ) ];
        }
    }
}

// ── Build image index grouped by category → product ──────────────────────────
$image_tree = []; // [ category => [ product => [ rel_path, url, size_kb ] ] ]
$total_count = 0;

if ( is_dir( $scan_dir ) ) {
    $cat_dirs = glob( $scan_dir . '/*', GLOB_ONLYDIR );
    sort( $cat_dirs );
    foreach ( $cat_dirs as $cat_dir ) {
        $cat_name = basename( $cat_dir );
        $prod_dirs = glob( $cat_dir . '/*', GLOB_ONLYDIR );
        sort( $prod_dirs );
        foreach ( $prod_dirs as $prod_dir ) {
            $prod_name   = basename( $prod_dir );
            $image_files = glob( $prod_dir . '/*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE );
            foreach ( $image_files as $img_file ) {
                $rel  = str_replace( $scan_dir . '/', '', $img_file );
                $url  = $scan_url . '/' . str_replace( '\\', '/', $rel );
                $size = round( filesize( $img_file ) / 1024, 1 );
                $image_tree[ $cat_name ][ $prod_name ][] = [
                    'rel'    => $rel,
                    'url'    => $url,
                    'size'   => $size,
                    'name'   => basename( $img_file ),
                    'prod'   => $prod_name,
                    'cat'    => $cat_name,
                ];
                $total_count++;
            }
        }
    }
}

$nonce = wp_create_nonce( 'ea_computer_review' );
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>EA — Computer Image Review</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#111;color:#eee;min-height:100vh}

/* ── Header ── */
.header{background:#1a1a1a;border-bottom:1px solid #333;padding:12px 20px;display:flex;align-items:center;gap:14px;position:sticky;top:0;z-index:100}
.header h1{font-size:17px;font-weight:700;color:#fff}
.header .stats{margin-left:auto;font-size:12px;color:#888;text-align:right;line-height:1.7}
.header .stats strong{color:#f0a500}

/* ── Toolbar ── */
.toolbar{background:#1d1d1d;border-bottom:1px solid #2a2a2a;padding:9px 20px;display:flex;gap:10px;align-items:center;flex-wrap:wrap;position:sticky;top:49px;z-index:99}
.search-box{flex:1;min-width:180px;max-width:320px;padding:7px 12px;border:1px solid #444;border-radius:5px;font-size:13px;background:#2a2a2a;color:#eee;outline:none}
.search-box:focus{border-color:#f0a500}
.btn{padding:7px 14px;border:none;border-radius:5px;cursor:pointer;font-size:13px;font-weight:500;display:inline-flex;align-items:center;gap:5px;text-decoration:none;transition:opacity .15s}
.btn:hover{opacity:.85}
.btn-amber{background:#f0a500;color:#111}
.btn-red{background:#c0392b;color:#fff}
.btn-green{background:#27ae60;color:#fff}
.btn-blue{background:#2980b9;color:#fff}
.btn-ghost{background:#2a2a2a;color:#ccc;border:1px solid #444}
.btn-sm{padding:4px 9px;font-size:11px}
.sel-count{font-size:12px;color:#f0a500;font-weight:700}

/* ── Bulk action bar ── */
.bulk-bar{background:#1d1d1d;border-bottom:1px solid #2a2a2a;padding:7px 20px;display:flex;gap:8px;align-items:center;flex-wrap:wrap}
.bulk-bar label{font-size:12px;color:#999}
.bulk-sep{width:1px;height:20px;background:#333;margin:0 4px}

/* ── Tabs ── */
.tabs{display:flex;gap:2px;padding:10px 20px 0;background:#1a1a1a;overflow-x:auto;border-bottom:2px solid #2a2a2a;position:sticky;top:97px;z-index:98;scrollbar-width:thin}
.tab{padding:8px 14px;border-radius:5px 5px 0 0;cursor:pointer;font-size:12px;background:#222;border:1px solid #333;border-bottom:none;white-space:nowrap;color:#aaa;user-select:none;transition:background .15s}
.tab:hover{background:#2a2a2a;color:#eee}
.tab.active{background:#111;font-weight:700;color:#f0a500;border-bottom:2px solid #111;margin-bottom:-2px}
.tab-badge{background:#333;border-radius:10px;padding:1px 6px;font-size:10px;margin-left:5px;color:#aaa}
.tab.active .tab-badge{background:#f0a500;color:#111}

/* ── Grid ── */
.content{padding:18px 20px 120px}
.cat-section{display:none}.cat-section.active{display:block}
.cat-title{font-size:14px;font-weight:800;color:#f0a500;margin-bottom:16px;padding-bottom:6px;border-bottom:1px solid #2a2a2a;text-transform:uppercase;letter-spacing:.5px}
.prod-group{margin-bottom:28px}
.prod-title{font-size:12px;font-weight:700;color:#ccc;margin-bottom:10px;padding:4px 8px;background:#1d1d1d;border-radius:4px;border-left:3px solid #444}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:14px}

/* ── Card ── */
.card{background:#1a1a1a;border-radius:8px;overflow:hidden;border:2px solid transparent;transition:border-color .2s,transform .15s;cursor:pointer;position:relative}
.card:hover{transform:translateY(-2px)}
.card.selected{border-color:#f0a500 !important}
.card.decision-delete{border-color:#c0392b !important;opacity:.65}
.card.decision-ignore{border-color:#555 !important;opacity:.7}
.card.decision-wp_small{border-color:#27ae60 !important}
.card.decision-wp_full{border-color:#2980b9 !important}

/* Select checkbox */
.card-checkbox{position:absolute;top:8px;left:8px;z-index:2;width:20px;height:20px;cursor:pointer;accent-color:#f0a500}

/* Decision badge */
.decision-badge{position:absolute;top:8px;right:8px;font-size:10px;font-weight:800;padding:3px 8px;border-radius:10px;z-index:2;pointer-events:none}
.badge-delete{background:#c0392b;color:#fff}
.badge-ignore{background:#555;color:#aaa}
.badge-wp_small{background:#27ae60;color:#fff}
.badge-wp_full{background:#2980b9;color:#fff}

.card-img{width:100%;height:180px;object-fit:cover;display:block;background:#222}
.card-body{padding:10px}
.card-prod{font-size:12px;font-weight:700;color:#eee;line-height:1.3;margin-bottom:2px}
.card-meta{font-size:10px;color:#666;margin-bottom:10px}

/* Per-card action buttons */
.card-actions{display:flex;gap:4px;flex-wrap:wrap}
.card-actions .btn{flex:1;min-width:0;justify-content:center;font-size:10px;padding:5px 4px}

/* ── Apply bar ── */
.apply-bar{position:fixed;bottom:0;left:0;right:0;background:#1a1a1a;border-top:2px solid #f0a500;padding:12px 20px;display:flex;align-items:center;gap:12px;transform:translateY(110%);transition:transform .3s;z-index:150}
.apply-bar.visible{transform:translateY(0)}
.apply-summary{font-size:13px;color:#eee;flex:1;line-height:1.6}
.apply-summary span{font-weight:700}
.apply-summary .del{color:#e74c3c}
.apply-summary .ign{color:#888}
.apply-summary .wps{color:#27ae60}
.apply-summary .wpf{color:#3498db}

/* ── Results messages ── */
.results{padding:16px 20px}
.result-msg{padding:8px 14px;border-radius:4px;margin-bottom:5px;font-size:13px}
.result-ok{background:#1a3d2b;border-left:4px solid #27ae60;color:#7ed6a7}
.result-err{background:#3d1a1a;border-left:4px solid #c0392b;color:#e07070}
.result-info{background:#2a2a2a;border-left:4px solid #555;color:#aaa}

/* ── Modal ── */
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:200;display:flex;align-items:center;justify-content:center}
.modal{background:#1a1a1a;border-radius:10px;width:92%;max-width:480px;padding:24px;border:1px solid #333;box-shadow:0 12px 48px rgba(0,0,0,.6)}
.modal h3{font-size:16px;font-weight:700;margin-bottom:8px;color:#fff}
.modal p{font-size:13px;color:#aaa;margin-bottom:18px;line-height:1.5}
.modal .btns{display:flex;gap:8px;flex-wrap:wrap}
.modal .btns .btn{flex:1;justify-content:center;padding:10px}

/* ── No results ── */
.no-results{text-align:center;padding:60px 20px;color:#555;font-size:14px;display:none}

/* Scrollbar */
::-webkit-scrollbar{width:6px;height:6px}
::-webkit-scrollbar-track{background:#111}
::-webkit-scrollbar-thumb{background:#333;border-radius:3px}
::-webkit-scrollbar-thumb:hover{background:#555}
</style>
</head>
<body>

<!-- Header -->
<div class="header">
  <h1>🖥 Computer Image Review</h1>
  <div class="stats">
    <strong><?= $total_count ?></strong> images found &nbsp;·&nbsp;
    <strong><?= count( $image_tree ) ?></strong> categories &nbsp;·&nbsp;
    Mark each image then click <strong>Execute All Decisions</strong>
  </div>
</div>

<!-- Toolbar -->
<div class="toolbar">
  <input type="text" class="search-box" id="searchBox" placeholder="🔍 Search product name…" oninput="filterCards(this.value)">
  <span class="sel-count" id="selCount"></span>
  <a href="<?= esc_url( admin_url() ) ?>" class="btn btn-ghost">← WP Admin</a>
</div>

<!-- Bulk action bar -->
<div class="bulk-bar">
  <label>Bulk mark selected as:</label>
  <button class="btn btn-red btn-sm"   onclick="bulkMark('delete')">🗑 Delete</button>
  <button class="btn btn-ghost btn-sm" onclick="bulkMark('ignore')">⏭ Keep (ignore)</button>
  <button class="btn btn-green btn-sm" onclick="bulkMark('wp_small')">↑ WP Small</button>
  <button class="btn btn-blue btn-sm"  onclick="bulkMark('wp_full')">↑ WP Full Res</button>
  <div class="bulk-sep"></div>
  <button class="btn btn-ghost btn-sm" onclick="selectAllVisible()">Select All Visible</button>
  <button class="btn btn-ghost btn-sm" onclick="clearSelection()">Clear Selection</button>
</div>

<!-- Results from last execution -->
<?php if ( ! empty( $exec_messages ) ) : ?>
<div class="results">
  <h3 style="color:#f0a500;font-size:13px;margin-bottom:8px;text-transform:uppercase;letter-spacing:.5px">
    Execution Results (<?= count( $exec_messages ) ?> actions)
  </h3>
  <?php foreach ( $exec_messages as $m ) :
    $cls = $m['type'] === 'ok' ? 'result-ok' : ( $m['type'] === 'err' ? 'result-err' : 'result-info' );
  ?>
    <div class="result-msg <?= $cls ?>"><?= $m['msg'] ?></div>
  <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Category Tabs -->
<div class="tabs" id="tabBar">
<?php $first = true; foreach ( $image_tree as $cat => $prods ) :
  $cat_count = 0;
  foreach ( $prods as $imgs ) { $cat_count += count( $imgs ); }
?>
  <div class="tab <?= $first ? 'active' : '' ?>"
       data-cat="<?= esc_attr( $cat ) ?>"
       onclick="switchTab(this)">
    <?= esc_html( $cat ) ?>
    <span class="tab-badge" id="tab-badge-<?= esc_attr( sanitize_title( $cat ) ) ?>"><?= $cat_count ?></span>
  </div>
<?php $first = false; endforeach; ?>
</div>

<!-- Image Grids -->
<div class="content">
  <div class="no-results" id="noResults">No images match your search.</div>

<?php $first = true; foreach ( $image_tree as $cat => $prods ) :
  $cat_id = sanitize_title( $cat );
?>
  <div class="cat-section <?= $first ? 'active' : '' ?>"
       id="cat-<?= esc_attr( $cat_id ) ?>"
       data-cat="<?= esc_attr( $cat ) ?>">
    <div class="cat-title"><?= esc_html( $cat ) ?></div>

    <?php foreach ( $prods as $prod_name => $images ) : ?>
    <div class="prod-group" data-prod="<?= esc_attr( strtolower( $prod_name ) ) ?>">
      <div class="prod-title"><?= esc_html( $prod_name ) ?></div>
      <div class="grid">
        <?php foreach ( $images as $img ) :
          $card_id = 'card-' . md5( $img['rel'] );
        ?>
        <div class="card"
             id="<?= $card_id ?>"
             data-rel="<?= esc_attr( $img['rel'] ) ?>"
             data-prod="<?= esc_attr( strtolower( $img['prod'] ) ) ?>"
             data-cat="<?= esc_attr( $img['cat'] ) ?>"
             onclick="toggleSelect(this, event)">

          <input type="checkbox" class="card-checkbox" onchange="onCheckbox(this)" onclick="event.stopPropagation()">
          <div class="decision-badge" id="badge-<?= $card_id ?>"></div>
          <img class="card-img" src="<?= esc_url( $img['url'] ) ?>" alt="<?= esc_attr( $img['prod'] ) ?>" loading="lazy">

          <div class="card-body">
            <div class="card-prod"><?= esc_html( $img['prod'] ) ?></div>
            <div class="card-meta"><?= esc_html( $img['name'] ) ?> &nbsp;·&nbsp; <?= $img['size'] ?> KB</div>

            <div class="card-actions" onclick="event.stopPropagation()">
              <button class="btn btn-red"   onclick="setDecision('<?= esc_js( $img['rel'] ) ?>', 'delete',   '<?= $card_id ?>')">🗑</button>
              <button class="btn btn-ghost" onclick="setDecision('<?= esc_js( $img['rel'] ) ?>', 'ignore',   '<?= $card_id ?>')">⏭</button>
              <button class="btn btn-green" onclick="setDecision('<?= esc_js( $img['rel'] ) ?>', 'wp_small', '<?= $card_id ?>')">↑S</button>
              <button class="btn btn-blue"  onclick="setDecision('<?= esc_js( $img['rel'] ) ?>', 'wp_full',  '<?= $card_id ?>')">↑F</button>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
<?php $first = false; endforeach; ?>
</div><!-- /content -->

<!-- Apply / Execute bar -->
<div class="apply-bar" id="applyBar">
  <div class="apply-summary" id="applySummary"></div>
  <button class="btn btn-ghost" onclick="clearAllDecisions()">Reset All</button>
  <button class="btn btn-amber" id="executeBtn" onclick="openConfirm()">Execute All Decisions →</button>
</div>

<!-- Confirm modal -->
<div class="modal-overlay" id="confirmModal" style="display:none">
  <div class="modal">
    <h3>⚠ Confirm Execution</h3>
    <p id="confirmText">This will permanently delete files from your computer and upload selected images to WordPress. This cannot be undone.</p>
    <div class="btns">
      <button class="btn btn-ghost" onclick="closeConfirm()">Cancel</button>
      <button class="btn btn-amber" onclick="submitDecisions()">Yes, Execute →</button>
    </div>
  </div>
</div>

<!-- Hidden POST form -->
<form method="post" id="execForm" action="">
  <input type="hidden" name="_ea_nonce" value="<?= esc_attr( $nonce ) ?>">
  <div id="hiddenInputs"></div>
</form>

<script>
// State
let decisions   = {};  // rel_path → 'delete' | 'ignore' | 'wp_small' | 'wp_full'
let selectedIds = new Set();

const LABELS = {
  delete:   { text: '🗑 DELETE',    cls: 'badge-delete',   cardCls: 'decision-delete'   },
  ignore:   { text: '⏭ KEEP',      cls: 'badge-ignore',   cardCls: 'decision-ignore'   },
  wp_small: { text: '↑ WP SMALL',  cls: 'badge-wp_small', cardCls: 'decision-wp_small' },
  wp_full:  { text: '↑ WP FULL',   cls: 'badge-wp_full',  cardCls: 'decision-wp_full'  },
};

// ── Set decision on a single card ─────────────────────────────────────────────
function setDecision(rel, action, cardId) {
  decisions[rel] = action;
  const card  = document.getElementById(cardId);
  const badge = document.getElementById('badge-' + cardId);
  if (!card || !badge) return;
  // Remove all existing decision classes
  card.classList.remove('decision-delete','decision-ignore','decision-wp_small','decision-wp_full');
  badge.className = 'decision-badge';
  const lbl = LABELS[action];
  card.classList.add(lbl.cardCls);
  badge.className = 'decision-badge ' + lbl.cls;
  badge.textContent = lbl.text;
  updateApplyBar();
}

// ── Toggle select ─────────────────────────────────────────────────────────────
function toggleSelect(card, event) {
  if (event.target.tagName === 'BUTTON' || event.target.tagName === 'INPUT') return;
  const cb = card.querySelector('.card-checkbox');
  cb.checked = !cb.checked;
  if (cb.checked) { selectedIds.add(card.id); card.classList.add('selected'); }
  else            { selectedIds.delete(card.id); card.classList.remove('selected'); }
  updateSelCount();
}
function onCheckbox(cb) {
  const card = cb.closest('.card');
  if (cb.checked) { selectedIds.add(card.id); card.classList.add('selected'); }
  else            { selectedIds.delete(card.id); card.classList.remove('selected'); }
  updateSelCount();
}
function updateSelCount() {
  const el = document.getElementById('selCount');
  el.textContent = selectedIds.size > 0 ? selectedIds.size + ' selected' : '';
}

// ── Bulk mark ─────────────────────────────────────────────────────────────────
function bulkMark(action) {
  selectedIds.forEach(cardId => {
    const card = document.getElementById(cardId);
    if (!card) return;
    const rel = card.dataset.rel;
    setDecision(rel, action, cardId);
  });
}
function selectAllVisible() {
  document.querySelectorAll('.card').forEach(card => {
    if (card.style.display === 'none') return;
    const cb = card.querySelector('.card-checkbox');
    cb.checked = true;
    selectedIds.add(card.id);
    card.classList.add('selected');
  });
  updateSelCount();
}
function clearSelection() {
  selectedIds.forEach(id => {
    const card = document.getElementById(id);
    if (card) {
      card.querySelector('.card-checkbox').checked = false;
      card.classList.remove('selected');
    }
  });
  selectedIds.clear();
  updateSelCount();
}

// ── Search / filter ───────────────────────────────────────────────────────────
function filterCards(q) {
  q = q.trim().toLowerCase();
  let totalVisible = 0;
  const catCounts = {};

  document.querySelectorAll('.card').forEach(card => {
    const prod = card.dataset.prod || '';
    const cat  = card.dataset.cat;
    const show = !q || prod.includes(q);
    card.style.display = show ? '' : 'none';
    if (show) { totalVisible++; catCounts[cat] = (catCounts[cat] || 0) + 1; }
  });

  // Show/hide product group headings
  document.querySelectorAll('.prod-group').forEach(g => {
    const prod = g.dataset.prod || '';
    g.style.display = (!q || prod.includes(q)) ? '' : 'none';
  });

  // Update tab badges
  document.querySelectorAll('.tab').forEach(tab => {
    const cat = tab.dataset.cat;
    const id  = tab.querySelector('.tab-badge').id;
    const cnt = catCounts[cat] || 0;
    document.getElementById(id).textContent = cnt;
    tab.style.display = q ? (cnt > 0 ? '' : 'none') : '';
    if (!q) {
      // Restore original count from data
      document.getElementById(id).textContent =
        document.querySelectorAll(`.card[data-cat="${CSS.escape(cat)}"]`).length;
    }
  });

  // Auto-switch to first visible tab
  const activeTab = document.querySelector('.tab.active');
  if (q && activeTab && activeTab.style.display === 'none') {
    const first = document.querySelector('.tab:not([style*="display: none"])');
    if (first) switchTab(first);
  }
  document.getElementById('noResults').style.display = (q && totalVisible === 0) ? 'block' : 'none';
}

// ── Tabs ──────────────────────────────────────────────────────────────────────
function switchTab(el) {
  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.cat-section').forEach(s => s.classList.remove('active'));
  el.classList.add('active');
  const cat = el.dataset.cat;
  const sec = document.querySelector(`.cat-section[data-cat="${CSS.escape(cat)}"]`);
  if (sec) sec.classList.add('active');
}

// ── Apply bar ─────────────────────────────────────────────────────────────────
function updateApplyBar() {
  const counts = { delete: 0, ignore: 0, wp_small: 0, wp_full: 0 };
  Object.values(decisions).forEach(a => counts[a]++);
  const total = Object.values(counts).reduce((s, v) => s + v, 0);
  const bar = document.getElementById('applyBar');
  if (total === 0) { bar.classList.remove('visible'); return; }
  bar.classList.add('visible');
  const parts = [];
  if (counts.delete   > 0) parts.push(`<span class="del">🗑 ${counts.delete} delete</span>`);
  if (counts.ignore   > 0) parts.push(`<span class="ign">⏭ ${counts.ignore} keep</span>`);
  if (counts.wp_small > 0) parts.push(`<span class="wps">↑ ${counts.wp_small} WP small</span>`);
  if (counts.wp_full  > 0) parts.push(`<span class="wpf">↑ ${counts.wp_full} WP full</span>`);
  document.getElementById('applySummary').innerHTML = parts.join(' &nbsp;·&nbsp; ');
}
function clearAllDecisions() {
  decisions = {};
  document.querySelectorAll('.card').forEach(card => {
    card.classList.remove('decision-delete','decision-ignore','decision-wp_small','decision-wp_full');
    const badge = card.querySelector('.decision-badge');
    if (badge) { badge.className = 'decision-badge'; badge.textContent = ''; }
  });
  document.getElementById('applyBar').classList.remove('visible');
}

// ── Confirm & Submit ─────────────────────────────────────────────────────────
function openConfirm() {
  const counts = { delete: 0, ignore: 0, wp_small: 0, wp_full: 0 };
  Object.values(decisions).forEach(a => counts[a]++);
  let txt = '';
  if (counts.delete   > 0) txt += `• <strong>${counts.delete}</strong> images will be permanently DELETED from your computer<br>`;
  if (counts.wp_small > 0) txt += `• <strong>${counts.wp_small}</strong> images uploaded to WordPress at small size (≤800px)<br>`;
  if (counts.wp_full  > 0) txt += `• <strong>${counts.wp_full}</strong> images uploaded to WordPress at full resolution<br>`;
  if (counts.ignore   > 0) txt += `• <strong>${counts.ignore}</strong> images kept on computer, ignored<br>`;
  document.getElementById('confirmText').innerHTML = txt + '<br>Delete actions cannot be undone.';
  document.getElementById('confirmModal').style.display = 'flex';
}
function closeConfirm() {
  document.getElementById('confirmModal').style.display = 'none';
}
function submitDecisions() {
  closeConfirm();
  const container = document.getElementById('hiddenInputs');
  container.innerHTML = '';
  for (const [rel, action] of Object.entries(decisions)) {
    const inp = document.createElement('input');
    inp.type  = 'hidden';
    inp.name  = `decisions[${rel}]`;
    inp.value = action;
    container.appendChild(inp);
  }
  document.getElementById('execForm').submit();
}
</script>
</body>
</html>
