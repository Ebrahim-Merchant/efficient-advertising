<?php
/**
 * EA Visual Review Tool — Image Assignment
 * Access: /ea-visual-review.php (admin only, delete after use)
 */
define('WP_USE_THEMES', false);
require_once __DIR__ . '/wp-load.php';

if (!is_user_logged_in() || !current_user_can('manage_options')) {
    auth_redirect();
    exit;
}

$upload_info  = wp_upload_dir();
$uploads_url  = $upload_info['baseurl'];
$uploads_dir  = $upload_info['basedir'];
$archive_base = $uploads_dir . '/mprint_processed';
$archive_url  = $uploads_url . '/mprint_processed';

// ── Helper: slugify for matching ─────────────────────────────────────────────
function ea_slugify( $str ) {
    $str = mb_strtolower( $str );
    $str = str_replace( ['&', '(', ')', '/', '\\', '+', '.', ',', '_', '\''], '-', $str );
    $str = preg_replace( '/[^a-z0-9\-]/', '', $str );
    $str = preg_replace( '/-+/', '-', $str );
    return trim( $str, '-' );
}

// ── Build archive index: slug => {name, cat, path, url, all[]} ───────────────
$archive_index = [];
if ( is_dir( $archive_base ) ) {
    foreach ( glob( $archive_base . '/*', GLOB_ONLYDIR ) as $cat_dir ) {
        $cat_name = basename( $cat_dir );
        foreach ( glob( $cat_dir . '/*', GLOB_ONLYDIR ) as $prod_dir ) {
            $prod_name   = basename( $prod_dir );
            $prod_slug   = ea_slugify( $prod_name );
            $image_files = glob( $prod_dir . '/*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE );
            if ( ! empty( $image_files ) ) {
                $first_rel = str_replace( $uploads_dir, '', $image_files[0] );
                $archive_index[ $prod_slug ] = [
                    'name' => $prod_name,
                    'cat'  => $cat_name,
                    'path' => $image_files[0],
                    'url'  => $uploads_url . $first_rel,
                    'all'  => array_map( function ( $p ) use ( $uploads_dir, $uploads_url ) {
                        return [
                            'path'  => $p,
                            'url'   => $uploads_url . str_replace( $uploads_dir, '', $p ),
                            'label' => basename( dirname( $p ) ),
                        ];
                    }, $image_files ),
                ];
            }
        }
    }
}

// ── Export CSV ───────────────────────────────────────────────────────────────
if ( isset( $_GET['action'] ) && $_GET['action'] === 'export_csv' ) {
    if ( ! isset( $_GET['_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_nonce'] ) ), 'ea_export' ) ) {
        wp_die( 'Invalid nonce' );
    }
    $products = wc_get_products( [ 'limit' => -1, 'status' => 'publish' ] );
    header( 'Content-Type: text/csv; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename="product-image-review-' . date( 'Ymd' ) . '.csv"' );
    $out = fopen( 'php://output', 'w' );
    fputcsv( $out, [ 'Product ID', 'Product Name', 'Category', 'Current Image URL', 'Suggested Replacement', 'Status', 'Notes' ] );
    foreach ( $products as $product ) {
        $pid      = $product->get_id();
        $title    = $product->get_name();
        $terms    = wp_get_post_terms( $pid, 'product_cat', [ 'fields' => 'names' ] );
        $cat_str  = implode( ' > ', array_reverse( $terms ) );
        $thumb_id = $product->get_image_id();
        $curr_img = $thumb_id ? wp_get_attachment_url( $thumb_id ) : '';
        $slug     = ea_slugify( $title );
        $sugg     = isset( $archive_index[ $slug ] ) ? $archive_index[ $slug ]['url'] : '';
        fputcsv( $out, [ $pid, $title, $cat_str, $curr_img, $sugg, '', '' ] );
    }
    fclose( $out );
    exit;
}

// ── Get replacements (AJAX) ──────────────────────────────────────────────────
if ( isset( $_GET['action'] ) && $_GET['action'] === 'get_replacements' ) {
    if ( ! isset( $_GET['_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_nonce'] ) ), 'ea_review' ) ) {
        wp_die( 'Invalid nonce' );
    }
    header( 'Content-Type: application/json' );
    $q       = strtolower( sanitize_text_field( wp_unslash( $_GET['q'] ?? '' ) ) );
    $results = [];
    foreach ( $archive_index as $slug => $data ) {
        if ( ! $q || str_contains( $slug, $q ) || str_contains( strtolower( $data['name'] ), $q ) ) {
            foreach ( $data['all'] as $img ) {
                $results[] = [ 'label' => $data['name'], 'url' => $img['url'], 'path' => $img['path'] ];
            }
        }
    }
    if ( $q === '' ) {
        // Return first 48 items when no query
        $results = array_values( array_slice(
            array_map( function ( $d ) { return [ 'label' => $d['name'], 'url' => $d['url'], 'path' => $d['path'] ]; }, $archive_index ),
            0, 48
        ) );
    }
    echo wp_json_encode( array_slice( $results, 0, 48 ) );
    exit;
}

// ── Apply Changes (POST) ─────────────────────────────────────────────────────
$messages = [];
if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['_ea_nonce'] ) ) {
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_ea_nonce'] ) ), 'ea_review' ) ) {
        wp_die( 'Invalid nonce' );
    }

    // Renames
    $renames = ( isset( $_POST['renames'] ) && is_array( $_POST['renames'] ) ) ? $_POST['renames'] : [];
    foreach ( $renames as $rpid => $new_title ) {
        $rpid      = absint( $rpid );
        $new_title = sanitize_text_field( wp_unslash( $new_title ) );
        if ( $rpid && $new_title ) {
            wp_update_post( [ 'ID' => $rpid, 'post_title' => $new_title ] );
            $messages[] = '✓ Renamed #' . $rpid . ' → ' . $new_title;
        }
    }

    // Image changes
    $changes = ( isset( $_POST['changes'] ) && is_array( $_POST['changes'] ) ) ? $_POST['changes'] : [];
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    foreach ( $changes as $cpid => $change ) {
        $cpid     = absint( $cpid );
        $img_path = sanitize_text_field( wp_unslash( $change['path'] ?? '' ) );

        // Path traversal guard – must be within uploads directory
        $real_path    = realpath( $img_path );
        $real_uploads = realpath( $uploads_dir );
        if ( ! $real_path || ! $real_uploads || strpos( $real_path, $real_uploads . DIRECTORY_SEPARATOR ) !== 0 ) {
            $messages[] = '✗ Skipped #' . $cpid . ': invalid path';
            continue;
        }
        if ( ! file_exists( $real_path ) ) {
            $messages[] = '✗ Skipped #' . $cpid . ': file not found';
            continue;
        }

        // Copy file to dated uploads subfolder
        $upload_folder = $uploads_dir . '/' . date( 'Y/m' );
        if ( ! is_dir( $upload_folder ) ) {
            wp_mkdir_p( $upload_folder );
        }
        $ext      = pathinfo( $real_path, PATHINFO_EXTENSION );
        $basename = sanitize_file_name( pathinfo( $real_path, PATHINFO_FILENAME ) ) . '-p' . $cpid . '.' . $ext;
        $dest     = $upload_folder . '/' . $basename;
        if ( ! copy( $real_path, $dest ) ) {
            $messages[] = '✗ Failed to copy image for #' . $cpid;
            continue;
        }

        $filetype  = wp_check_filetype( $dest );
        $attach_id = wp_insert_attachment(
            [
                'post_mime_type' => $filetype['type'],
                'post_title'     => sanitize_file_name( pathinfo( $dest, PATHINFO_FILENAME ) ),
                'post_content'   => '',
                'post_status'    => 'inherit',
            ],
            $dest,
            $cpid
        );
        if ( is_wp_error( $attach_id ) ) {
            $messages[] = '✗ WP insert failed for #' . $cpid . ': ' . $attach_id->get_error_message();
            continue;
        }
        $meta = wp_generate_attachment_metadata( $attach_id, $dest );
        wp_update_attachment_metadata( $attach_id, $meta );
        set_post_thumbnail( $cpid, $attach_id );
        $messages[] = '✓ Product #' . $cpid . ': image assigned (' . esc_html( basename( $dest ) ) . ')';
    }
}

// ── Fetch all WooCommerce products ───────────────────────────────────────────
$all_products = wc_get_products( [
    'limit'   => -1,
    'status'  => 'publish',
    'orderby' => 'name',
    'order'   => 'ASC',
] );

// Group by top-level WooCommerce category
$by_cat       = [];
$total_auto   = 0;
$total_no_img = 0;

foreach ( $all_products as $product ) {
    $pid      = $product->get_id();
    $title    = $product->get_name();
    $terms    = wp_get_post_terms( $pid, 'product_cat', [ 'orderby' => 'parent', 'order' => 'ASC' ] );
    $top_cat  = 'Uncategorized';
    $sub_cat  = '';
    foreach ( $terms as $t ) {
        if ( (int) $t->parent === 0 ) {
            $top_cat = $t->name;
        } else {
            $sub_cat = $t->name;
        }
    }
    $thumb_id  = $product->get_image_id();
    $thumb_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'medium' ) : '';
    $slug_key  = ea_slugify( $title );
    $sug       = $archive_index[ $slug_key ] ?? null;

    if ( $sug ) { $total_auto++; }
    if ( ! $thumb_url ) { $total_no_img++; }

    $by_cat[ $top_cat ][] = [
        'pid'       => $pid,
        'title'     => $title,
        'sub'       => $sub_cat,
        'thumb_url' => $thumb_url,
        'sug'       => $sug,
    ];
}
ksort( $by_cat );

$nonce        = wp_create_nonce( 'ea_review' );
$export_nonce = wp_create_nonce( 'ea_export' );
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>EA Image Review</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#f0f0f1;color:#1d2327}
/* Header */
.header{background:#1d2327;color:#fff;padding:12px 20px;display:flex;align-items:center;gap:16px;position:sticky;top:0;z-index:100}
.header h1{font-size:18px;font-weight:700}
.header .stats{font-size:12px;color:#aaa;margin-left:auto;text-align:right;line-height:1.6}
/* Toolbar */
.toolbar{background:#fff;border-bottom:1px solid #ddd;padding:9px 20px;display:flex;gap:10px;align-items:center;flex-wrap:wrap;position:sticky;top:49px;z-index:99}
.search-box{flex:1;min-width:200px;max-width:340px;padding:7px 12px;border:1px solid #ccc;border-radius:4px;font-size:14px;outline:none}
.search-box:focus{border-color:#2271b1;box-shadow:0 0 0 2px rgba(34,113,177,.2)}
.btn{padding:7px 14px;border:none;border-radius:4px;cursor:pointer;font-size:13px;font-weight:500;text-decoration:none;display:inline-flex;align-items:center;gap:5px}
.btn-primary{background:#2271b1;color:#fff}.btn-primary:hover{background:#135e96}
.btn-secondary{background:#f6f7f7;color:#1d2327;border:1px solid #ccc}.btn-secondary:hover{background:#e8e8e8}
.btn-green{background:#00a32a;color:#fff}.btn-green:hover{background:#006e1a}
.btn-red{background:#d63638;color:#fff}.btn-red:hover{background:#a00}
.btn-sm{padding:4px 9px;font-size:11px}
/* Messages */
.messages{padding:14px 20px}
.msg{padding:7px 14px;border-left:4px solid #00a32a;background:#edfaef;margin-bottom:5px;border-radius:0 4px 4px 0;font-size:13px}
.msg.err{background:#fde0e0;border-left-color:#d63638}
/* Tabs */
.tabs{display:flex;gap:3px;padding:10px 20px 0;background:#fff;overflow-x:auto;border-bottom:2px solid #e2e4e7;position:sticky;top:97px;z-index:98;scrollbar-width:thin}
.tab{padding:8px 13px;border-radius:4px 4px 0 0;cursor:pointer;font-size:12px;background:#f6f7f7;border:1px solid #ddd;border-bottom:none;white-space:nowrap;transition:background .15s;user-select:none}
.tab.active{background:#fff;font-weight:600;border-bottom:2px solid #fff;margin-bottom:-2px;color:#2271b1}
.tab-count{background:#e0e0e0;border-radius:10px;padding:1px 6px;font-size:10px;margin-left:4px}
.tab.active .tab-count{background:#2271b1;color:#fff}
/* Grid */
.cats-container{padding:18px 20px 80px}
.cat-section{display:none}.cat-section.active{display:block}
.cat-title{font-size:15px;font-weight:700;margin-bottom:14px;color:#1d2327;padding-bottom:6px;border-bottom:2px solid #e2e4e7}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(210px,1fr));gap:12px}
/* Card */
.card{background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.1);transition:box-shadow .2s,outline .15s;position:relative}
.card:hover{box-shadow:0 4px 14px rgba(0,0,0,.14)}
.card.accepted{outline:3px solid #00a32a}
.card.rejected{outline:3px solid #d63638;opacity:.7}
.card.has-change{outline:3px solid #2271b1}
.card-badge{position:absolute;top:8px;right:8px;font-size:10px;font-weight:700;padding:3px 7px;border-radius:10px;background:#f0a500;color:#fff}
.card-badge.auto{background:#2271b1}
.card-img{width:100%;height:150px;object-fit:cover;background:#f6f7f7;display:block}
.card-no-img{width:100%;height:150px;background:#f6f7f7;display:flex;align-items:center;justify-content:center;color:#bbb;font-size:12px;flex-direction:column;gap:4px}
.card-body{padding:10px}
.card-sub{font-size:10px;color:#888;text-transform:uppercase;letter-spacing:.3px;margin-bottom:3px}
.card-title{font-size:13px;font-weight:600;line-height:1.35;margin-bottom:2px}
.card-title-row{display:flex;align-items:flex-start;gap:4px}
.card-rename-btn{background:none;border:none;cursor:pointer;color:#ccc;padding:1px;font-size:13px;flex-shrink:0;line-height:1}.card-rename-btn:hover{color:#2271b1}
.card-title-input{font-size:13px;font-weight:600;width:100%;border:1px solid #2271b1;border-radius:3px;padding:3px 7px}
.card-pid{font-size:11px;color:#bbb;margin-bottom:8px}
/* Suggestion */
.sug-block{border-top:1px solid #f0f0f0;padding-top:8px;margin-top:4px}
.sug-label{font-size:10px;color:#888;margin-bottom:4px;font-weight:600;text-transform:uppercase}
.sug-img{width:100%;height:90px;object-fit:cover;border-radius:4px;background:#f6f7f7}
.sug-name{font-size:10px;color:#666;margin:3px 0 6px}
/* Change preview */
.change-preview{border-top:1px solid #dceeff;padding-top:8px;margin-top:6px}
.change-preview img{width:100%;height:80px;object-fit:cover;border-radius:4px;background:#f6f7f7}
.change-label{font-size:10px;color:#2271b1;font-weight:700;margin-top:3px}
/* Actions */
.card-actions{display:flex;gap:4px;flex-wrap:wrap;margin-top:8px}
.card-actions .btn{flex:1;min-width:0;text-align:center;padding:5px 6px;font-size:11px;justify-content:center}
/* Modal */
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:200;display:flex;align-items:center;justify-content:center}
.modal{background:#fff;border-radius:8px;width:92%;max-width:720px;max-height:82vh;display:flex;flex-direction:column;box-shadow:0 8px 40px rgba(0,0,0,.25)}
.modal-header{padding:15px 20px;border-bottom:1px solid #eee;display:flex;justify-content:space-between;align-items:center}
.modal-header h3{font-size:15px;font-weight:700}
.modal-close{background:none;border:none;font-size:22px;cursor:pointer;color:#999;line-height:1}
.modal-search-bar{padding:10px 20px;border-bottom:1px solid #eee}
.modal-search-bar input{width:100%;padding:8px 12px;border:1px solid #ddd;border-radius:4px;font-size:14px;outline:none}
.modal-search-bar input:focus{border-color:#2271b1}
.modal-body{overflow-y:auto;padding:14px 20px;flex:1}
.modal-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:10px}
.picker-item{cursor:pointer;border:2px solid transparent;border-radius:5px;overflow:hidden;transition:border-color .15s}
.picker-item:hover{border-color:#2271b1}
.picker-item.selected{border-color:#00a32a}
.picker-item img{width:100%;height:85px;object-fit:cover;display:block;background:#f6f7f7}
.picker-item span{display:block;font-size:10px;padding:3px 5px;background:#f6f7f7;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.modal-footer{padding:12px 20px;border-top:1px solid #eee;display:flex;gap:10px;justify-content:flex-end}
/* Apply bar */
.apply-bar{position:fixed;bottom:0;left:0;right:0;background:#2271b1;color:#fff;padding:13px 20px;display:flex;align-items:center;gap:14px;transform:translateY(110%);transition:transform .3s;z-index:150;box-shadow:0 -2px 12px rgba(0,0,0,.2)}
.apply-bar.visible{transform:translateY(0)}
.apply-count{font-weight:700;font-size:15px}
.apply-bar .spacer{flex:1}
/* No results */
.no-results{text-align:center;padding:50px 20px;color:#999;font-size:15px;display:none}
/* Scrollbar */
::-webkit-scrollbar{width:6px;height:6px}::-webkit-scrollbar-track{background:#f0f0f0}::-webkit-scrollbar-thumb{background:#ccc;border-radius:3px}
</style>
</head>
<body>

<div class="header">
  <h1>🖼 EA Image Review</h1>
  <div class="stats">
    <?= count( $all_products ) ?> products &nbsp;·&nbsp;
    <?= count( $archive_index ) ?> images in archive &nbsp;·&nbsp;
    <strong style="color:#6ee46e"><?= $total_auto ?> auto-matched</strong> &nbsp;·&nbsp;
    <span style="color:#ff9f9f"><?= $total_no_img ?> without image</span>
  </div>
</div>

<div class="toolbar">
  <input type="text" class="search-box" id="searchBox" placeholder="🔍 Search products…" oninput="filterCards(this.value)">
  <button class="btn btn-secondary" onclick="exportCSV()">↓ Export Excel</button>
  <a href="<?= esc_url( admin_url() ) ?>" class="btn btn-secondary">← WP Admin</a>
</div>

<?php if ( ! empty( $messages ) ) : ?>
<div class="messages">
  <?php foreach ( $messages as $msg ) : ?>
    <div class="msg <?= strpos( $msg, '✓' ) !== false ? '' : 'err' ?>"><?= esc_html( $msg ) ?></div>
  <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Category tabs -->
<div class="tabs" id="tabBar">
<?php $first = true; foreach ( $by_cat as $cat_name => $prods ) : ?>
  <div class="tab <?= $first ? 'active' : '' ?>"
       data-cat="<?= esc_attr( $cat_name ) ?>"
       onclick="switchTab(this)">
    <?= esc_html( $cat_name ) ?>
    <span class="tab-count"><?= count( $prods ) ?></span>
  </div>
<?php $first = false; endforeach; ?>
</div>

<!-- Product grids per category -->
<div class="cats-container">
<div class="no-results" id="noResults">No products match your search.</div>

<?php $first = true; foreach ( $by_cat as $cat_name => $prods ) : ?>
<div class="cat-section <?= $first ? 'active' : '' ?>"
     id="cat-<?= esc_attr( sanitize_title( $cat_name ) ) ?>"
     data-cat="<?= esc_attr( $cat_name ) ?>">
  <div class="cat-title"><?= esc_html( $cat_name ) ?> <small style="font-weight:400;color:#888;font-size:12px;">(<?= count( $prods ) ?> products)</small></div>
  <div class="grid">
  <?php foreach ( $prods as $p ) :
    $has_sug = ! empty( $p['sug'] );
  ?>
    <div class="card"
         id="card-<?= $p['pid'] ?>"
         data-pid="<?= $p['pid'] ?>"
         data-title="<?= esc_attr( strtolower( $p['title'] ) ) ?>"
         data-cat="<?= esc_attr( $cat_name ) ?>">

      <?php if ( $has_sug ) : ?>
        <span class="card-badge auto">AUTO</span>
      <?php elseif ( ! $p['thumb_url'] ) : ?>
        <span class="card-badge">NO IMG</span>
      <?php endif; ?>

      <?php if ( $p['thumb_url'] ) : ?>
        <img class="card-img" src="<?= esc_url( $p['thumb_url'] ) ?>" alt="" loading="lazy">
      <?php else : ?>
        <div class="card-no-img"><span style="font-size:28px;">📷</span>No current image</div>
      <?php endif; ?>

      <div class="card-body">
        <div class="card-sub"><?= esc_html( $p['sub'] ) ?></div>

        <!-- Title (display / edit) -->
        <div id="title-display-<?= $p['pid'] ?>" class="card-title-row">
          <div class="card-title" id="title-text-<?= $p['pid'] ?>"><?= esc_html( $p['title'] ) ?></div>
          <button class="card-rename-btn" title="Rename" onclick="startEditName(<?= $p['pid'] ?>, <?= esc_js( wp_json_encode( $p['title'] ) ) ?>)">✏</button>
        </div>
        <div id="title-edit-<?= $p['pid'] ?>" style="display:none">
          <input class="card-title-input" id="title-input-<?= $p['pid'] ?>"
                 type="text" value="<?= esc_attr( $p['title'] ) ?>"
                 onkeydown="handleNameKey(event,<?= $p['pid'] ?>)">
          <div style="display:flex;gap:4px;margin-top:5px">
            <button class="btn btn-green btn-sm" style="flex:1" onclick="saveName(<?= $p['pid'] ?>)">Save</button>
            <button class="btn btn-secondary btn-sm" style="flex:1" onclick="cancelName(<?= $p['pid'] ?>)">Cancel</button>
          </div>
        </div>
        <div class="card-pid">#<?= $p['pid'] ?></div>

        <?php if ( $has_sug ) : ?>
        <!-- Auto-matched suggestion -->
        <div class="sug-block" id="sug-<?= $p['pid'] ?>">
          <div class="sug-label">Archive match</div>
          <img class="sug-img" src="<?= esc_url( $p['sug']['url'] ) ?>" alt="" loading="lazy">
          <div class="sug-name"><?= esc_html( $p['sug']['name'] ) ?></div>
        </div>
        <?php endif; ?>

        <!-- Chosen change preview -->
        <div id="change-preview-<?= $p['pid'] ?>"></div>

        <!-- Action buttons -->
        <div class="card-actions">
          <?php if ( $p['thumb_url'] ) : ?>
          <button class="btn btn-green" title="Current image is correct — keep it"
                  onclick="markAccepted(<?= $p['pid'] ?>)">✓ OK</button>
          <?php endif; ?>
          <?php if ( $has_sug ) : ?>
          <button class="btn btn-primary"
                  onclick="useSuggestion(<?= $p['pid'] ?>,
                    <?= esc_js( wp_json_encode( $p['sug']['url'] ) ) ?>,
                    <?= esc_js( wp_json_encode( $p['sug']['path'] ) ) ?>,
                    <?= esc_js( wp_json_encode( $p['sug']['name'] ) ) ?>)">Use Match</button>
          <?php endif; ?>
          <button class="btn btn-secondary"
                  onclick="openPicker(<?= $p['pid'] ?>, <?= esc_js( wp_json_encode( $p['title'] ) ) ?>)">🔍 Pick</button>
          <?php if ( $p['thumb_url'] ) : ?>
          <button class="btn btn-red" title="Mark as wrong"
                  onclick="markRejected(<?= $p['pid'] ?>)">✕</button>
          <?php endif; ?>
        </div>
        <!-- Clear change link -->
        <div id="clear-link-<?= $p['pid'] ?>" style="display:none;margin-top:5px;text-align:right">
          <a href="#" style="font-size:11px;color:#999" onclick="clearChange(<?= $p['pid'] ?>);return false">✕ Clear change</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
</div>
<?php $first = false; endforeach; ?>
</div><!-- /cats-container -->

<!-- Image picker modal -->
<div class="modal-overlay" id="pickerModal" style="display:none" onclick="if(event.target===this)closePicker()">
  <div class="modal">
    <div class="modal-header">
      <h3>Pick a replacement image</h3>
      <button class="modal-close" onclick="closePicker()">×</button>
    </div>
    <div class="modal-search-bar">
      <input type="text" id="modalSearch" placeholder="Type product name to filter…" oninput="fetchImages(this.value)">
    </div>
    <div class="modal-body">
      <div class="modal-grid" id="modalGrid"></div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closePicker()">Cancel</button>
      <button class="btn btn-primary" onclick="confirmPicker()">Use Selected →</button>
    </div>
  </div>
</div>

<!-- Apply bar -->
<div class="apply-bar" id="applyBar">
  <span class="apply-count" id="applyCount">0 pending</span>
  <span class="spacer"></span>
  <button class="btn btn-secondary" style="color:#1d2327" onclick="clearAll()">Clear All</button>
  <button class="btn btn-green" onclick="submitChanges()">Apply Changes →</button>
</div>

<!-- Hidden form for POST submission -->
<form method="post" id="applyForm" action="">
  <input type="hidden" name="_ea_nonce" value="<?= esc_attr( $nonce ) ?>">
  <div id="hiddenInputs"></div>
</form>

<script>
const NONCE        = <?= wp_json_encode( $nonce ) ?>;
const EXPORT_NONCE = <?= wp_json_encode( $export_nonce ) ?>;
const SCRIPT_URL   = location.pathname;

let changes       = {};  // pid → {url, path, label}
let renames       = {};  // pid → newTitle
let pickerPid     = null;
let pickerSelected= null;
let searchTimer   = null;

// ── Tabs ─────────────────────────────────────────────────────────────────────
function switchTab(el) {
  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.cat-section').forEach(s => s.classList.remove('active'));
  el.classList.add('active');
  const cat = el.dataset.cat;
  const sec = document.querySelector(`.cat-section[data-cat="${CSS.escape(cat)}"]`);
  if (sec) sec.classList.add('active');
}

// ── Search / filter ───────────────────────────────────────────────────────────
function filterCards(q) {
  q = q.trim().toLowerCase();
  let totalVisible = 0;
  const catVisible = {};

  document.querySelectorAll('.card').forEach(card => {
    const title = card.dataset.title || '';
    const cat   = card.dataset.cat;
    const show  = !q || title.includes(q);
    card.style.display = show ? '' : 'none';
    if (show) { totalVisible++; catVisible[cat] = (catVisible[cat] || 0) + 1; }
  });

  document.querySelectorAll('.tab').forEach(tab => {
    const cat = tab.dataset.cat;
    const cnt = catVisible[cat] || 0;
    tab.querySelector('.tab-count').textContent = cnt;
    if (q) {
      tab.style.display = cnt > 0 ? '' : 'none';
    } else {
      tab.style.display = '';
      // Restore full counts
      tab.querySelector('.tab-count').textContent =
        document.querySelectorAll(`.card[data-cat="${CSS.escape(cat)}"]`).length;
    }
  });

  // Auto-switch to first visible tab if current is hidden
  const activeTab = document.querySelector('.tab.active');
  if (q && activeTab && activeTab.style.display === 'none') {
    const firstVisible = document.querySelector('.tab:not([style*="display: none"])');
    if (firstVisible) switchTab(firstVisible);
  }
  if (!q) {
    // Restore counts and show all — switch back to first tab if none active
    const anyActive = document.querySelector('.tab.active:not([style*="display: none"])');
    if (!anyActive) {
      const first = document.querySelector('.tab');
      if (first) switchTab(first);
    }
  }
  document.getElementById('noResults').style.display = (q && totalVisible === 0) ? 'block' : 'none';
}

// ── Card state ────────────────────────────────────────────────────────────────
function markAccepted(pid) {
  const card = document.getElementById('card-' + pid);
  card.classList.toggle('accepted');
  card.classList.remove('rejected');
}
function markRejected(pid) {
  const card = document.getElementById('card-' + pid);
  card.classList.toggle('rejected');
  card.classList.remove('accepted');
}
function useSuggestion(pid, url, path, label) {
  setChange(pid, url, path, label);
}
function setChange(pid, url, path, label) {
  changes[pid] = { url, path, label };
  const card = document.getElementById('card-' + pid);
  card.classList.remove('accepted', 'rejected');
  card.classList.add('has-change');
  const preview = document.getElementById('change-preview-' + pid);
  const img = document.createElement('img');
  img.src = url;
  img.alt = '';
  const lbl = document.createElement('div');
  lbl.className = 'change-label';
  lbl.textContent = '→ ' + label;
  const wrap = document.createElement('div');
  wrap.className = 'change-preview';
  wrap.appendChild(img);
  wrap.appendChild(lbl);
  preview.innerHTML = '';
  preview.appendChild(wrap);
  document.getElementById('clear-link-' + pid).style.display = 'block';
  updateApplyBar();
}
function clearChange(pid) {
  delete changes[pid];
  const card = document.getElementById('card-' + pid);
  card.classList.remove('has-change');
  document.getElementById('change-preview-' + pid).innerHTML = '';
  document.getElementById('clear-link-' + pid).style.display = 'none';
  updateApplyBar();
}

// ── Picker modal ──────────────────────────────────────────────────────────────
function openPicker(pid, title) {
  pickerPid      = pid;
  pickerSelected = null;
  document.getElementById('pickerModal').style.display = 'flex';
  document.getElementById('modalSearch').value = title || '';
  fetchImages(title || '');
}
function closePicker() {
  document.getElementById('pickerModal').style.display = 'none';
  pickerPid      = null;
  pickerSelected = null;
}
function fetchImages(q) {
  if (searchTimer) clearTimeout(searchTimer);
  searchTimer = setTimeout(() => {
    const url = SCRIPT_URL + '?action=get_replacements&_nonce=' + encodeURIComponent(NONCE) + '&q=' + encodeURIComponent(q.toLowerCase());
    fetch(url)
      .then(r => r.json())
      .then(items => renderPickerGrid(items))
      .catch(() => {});
  }, 250);
}
function renderPickerGrid(items) {
  const grid = document.getElementById('modalGrid');
  grid.innerHTML = '';
  if (!items || !items.length) {
    const p = document.createElement('p');
    p.textContent = 'No images found.';
    p.style.cssText = 'color:#999;grid-column:1/-1;text-align:center;padding:30px;';
    grid.appendChild(p);
    return;
  }
  items.forEach(item => {
    const div  = document.createElement('div');
    div.className = 'picker-item';
    div.dataset.path  = item.path;
    div.dataset.url   = item.url;
    div.dataset.label = item.label;
    div.addEventListener('click', function() { selectItem(this); });
    const img  = document.createElement('img');
    img.src     = item.url;
    img.alt     = '';
    img.loading = 'lazy';
    const span = document.createElement('span');
    span.textContent = item.label;
    div.appendChild(img);
    div.appendChild(span);
    grid.appendChild(div);
  });
}
function selectItem(el) {
  document.querySelectorAll('.picker-item').forEach(i => i.classList.remove('selected'));
  el.classList.add('selected');
  pickerSelected = { url: el.dataset.url, path: el.dataset.path, label: el.dataset.label };
}
function confirmPicker() {
  if (pickerSelected && pickerPid) {
    setChange(pickerPid, pickerSelected.url, pickerSelected.path, pickerSelected.label);
  }
  closePicker();
}

// ── Inline rename ─────────────────────────────────────────────────────────────
function startEditName(pid, currentName) {
  document.getElementById('title-display-' + pid).style.display = 'none';
  document.getElementById('title-edit-'    + pid).style.display = 'block';
  const inp = document.getElementById('title-input-' + pid);
  inp.value = currentName;
  inp.focus();
  inp.select();
}
function saveName(pid) {
  const inp = document.getElementById('title-input-' + pid);
  const val = inp.value.trim();
  if (val) {
    renames[pid] = val;
    document.getElementById('title-text-' + pid).textContent = val;
  }
  cancelName(pid);
  updateApplyBar();
}
function cancelName(pid) {
  document.getElementById('title-display-' + pid).style.display = 'flex';
  document.getElementById('title-edit-'    + pid).style.display = 'none';
}
function handleNameKey(e, pid) {
  if (e.key === 'Enter')  saveName(pid);
  if (e.key === 'Escape') cancelName(pid);
}

// ── Apply bar ─────────────────────────────────────────────────────────────────
function updateApplyBar() {
  const imgCnt = Object.keys(changes).length;
  const renCnt = Object.keys(renames).length;
  const total  = imgCnt + renCnt;
  const bar    = document.getElementById('applyBar');
  const lbl    = document.getElementById('applyCount');
  if (total > 0) {
    bar.classList.add('visible');
    const parts = [];
    if (imgCnt > 0) parts.push(imgCnt + ' image' + (imgCnt !== 1 ? 's' : ''));
    if (renCnt > 0) parts.push(renCnt + ' rename' + (renCnt !== 1 ? 's' : ''));
    lbl.textContent = parts.join(' + ') + ' pending';
  } else {
    bar.classList.remove('visible');
  }
}
function clearAll() {
  changes = {};
  renames = {};
  document.querySelectorAll('.card').forEach(c => c.classList.remove('has-change','accepted','rejected'));
  document.querySelectorAll('[id^="change-preview-"]').forEach(el => el.innerHTML = '');
  document.querySelectorAll('[id^="clear-link-"]').forEach(el => el.style.display = 'none');
  updateApplyBar();
}

// ── Export & Submit ───────────────────────────────────────────────────────────
function exportCSV() {
  location.href = SCRIPT_URL + '?action=export_csv&_nonce=' + encodeURIComponent(EXPORT_NONCE);
}
function submitChanges() {
  const hiddens = document.getElementById('hiddenInputs');
  hiddens.innerHTML = '';
  for (const [pid, ch] of Object.entries(changes)) {
    const p = document.createElement('input'); p.type='hidden'; p.name=`changes[${pid}][path]`; p.value=ch.path; hiddens.appendChild(p);
    const u = document.createElement('input'); u.type='hidden'; u.name=`changes[${pid}][url]`;  u.value=ch.url;  hiddens.appendChild(u);
  }
  for (const [pid, title] of Object.entries(renames)) {
    const r = document.createElement('input'); r.type='hidden'; r.name=`renames[${pid}]`; r.value=title; hiddens.appendChild(r);
  }
  document.getElementById('applyForm').submit();
}
</script>
</body>
</html>
