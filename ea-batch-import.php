<?php
/**
 * EA Batch Import — SSE streaming progress, folder picker UI.
 * http://efficientadvt.local/ea-batch-import.php
 * LOCAL USE ONLY.
 */

// Local dev only — block obviously external IPs
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$blocked = !preg_match('/^(127\.|::1$|::ffff:127\.|10\.|192\.168\.|172\.(1[6-9]|2[0-9]|3[01])\.)/', $ip);
if ($blocked) {
    http_response_code(403); die('Local access only');
}

// ═══════════════════════════════════════════════════════════════════════════════
// SSE STREAM — called by JS EventSource
// ═══════════════════════════════════════════════════════════════════════════════
if (isset($_GET['stream'])) {
    $folder = rtrim(str_replace('\\', '/', trim($_GET['folder'] ?? '')), '/');

    // SSE headers — text/event-stream bypasses nginx buffering
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    header('X-Accel-Buffering: no');
    header('Connection: keep-alive');
    // Kill any existing output buffers
    while (ob_get_level()) ob_end_clean();

    function sse(string $type, array $data): void {
        echo 'data: ' . json_encode(['t' => $type] + $data) . "\n\n";
        flush();
    }

    if (!$folder || !is_dir($folder)) {
        sse('error', ['msg' => 'Folder not found: ' . $folder]); exit;
    }

    ignore_user_abort(true);
    set_time_limit(0);
    ini_set('memory_limit', '512M');

    require_once __DIR__ . '/wp-load.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $admins = get_users(['role' => 'administrator', 'number' => 1, 'fields' => ['ID']]);
    if (empty($admins)) { sse('error', ['msg' => 'No WordPress admin user found']); exit; }
    wp_set_current_user($admins[0]->ID);

    // Disable Smush to skip thumbnail warnings
    add_filter('wp_smush_should_skip_image', '__return_true');

    // Collect files
    $allowed = ['jpg','jpeg','png','webp','gif'];
    $files = [];
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($folder, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($it as $f) {
        if ($f->isFile() && in_array(strtolower($f->getExtension()), $allowed))
            $files[] = $f->getPathname();
    }
    sort($files);
    $total = count($files);

    if ($total === 0) { sse('error', ['msg' => 'No image files found in this folder']); exit; }

    // Already-in-library map
    $existing = [];
    foreach (get_posts(['post_type'=>'attachment','numberposts'=>-1,'fields'=>'ids']) as $pid) {
        $p = get_attached_file($pid);
        if ($p) $existing[strtolower(basename($p))] = true;
    }

    sse('start', ['total' => $total]);

    $ok = $skipped = $failed = 0;

    foreach ($files as $i => $filepath) {
        $fname = basename($filepath);
        $done  = $i + 1;

        if (isset($existing[strtolower($fname)])) {
            $skipped++;
            sse('skip', ['f'=>$fname,'done'=>$done,'total'=>$total,'ok'=>$ok,'sk'=>$skipped,'fa'=>$failed]);
            continue;
        }

        $tmp = tempnam(sys_get_temp_dir(), 'ea_');
        if (!copy($filepath, $tmp)) {
            $failed++;
            sse('fail', ['f'=>$fname,'msg'=>'copy failed','done'=>$done,'total'=>$total,'ok'=>$ok,'sk'=>$skipped,'fa'=>$failed]);
            continue;
        }

        $file_array = ['name'=>$fname,'tmp_name'=>$tmp,'error'=>UPLOAD_ERR_OK,'size'=>filesize($filepath)];
        ob_start();
        $id = media_handle_sideload($file_array, 0, $fname);
        ob_get_clean();
        @unlink($tmp);

        if (is_wp_error($id)) {
            $failed++;
            sse('fail', ['f'=>$fname,'msg'=>$id->get_error_message(),'done'=>$done,'total'=>$total,'ok'=>$ok,'sk'=>$skipped,'fa'=>$failed]);
        } else {
            $ok++;
            sse('ok', ['f'=>$fname,'done'=>$done,'total'=>$total,'ok'=>$ok,'sk'=>$skipped,'fa'=>$failed]);
        }
    }

    sse('done', ['ok'=>$ok,'sk'=>$skipped,'fa'=>$failed,'total'=>$total]);
    exit;
}

// ═══════════════════════════════════════════════════════════════════════════════
// UI
// ═══════════════════════════════════════════════════════════════════════════════
$user = getenv('USERNAME') ?: 'merch';
$home = 'C:/Users/' . $user;
$presets = [
    '🖥 Desktop'       => $home . '/Desktop',
    '⬇ Downloads'     => $home . '/Downloads',
    '📄 Documents'    => $home . '/Documents',
    '🖼 Pictures'     => $home . '/Pictures',
    '📁 mprint_processed' => 'C:/Users/merch/Local Sites/EfficientAdvt.Com/app/public/wp-content/uploads/mprint_processed',
    '📁 ea-computer-scan' => 'C:/Users/merch/Local Sites/EfficientAdvt.Com/app/public/wp-content/uploads/ea-computer-scan',
];
?><!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"><title>EA Batch Import</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#111;color:#eee;min-height:100vh}
.page{max-width:720px;margin:0 auto;padding:40px 24px}
h1{color:#f0a500;font-size:26px;font-weight:900;margin-bottom:4px}
.sub{color:#555;font-size:12px;margin-bottom:32px}
.slbl{font-size:10px;font-weight:800;color:#f0a500;text-transform:uppercase;letter-spacing:1px;margin-bottom:10px}
.preset-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:8px;margin-bottom:20px}
.pfolder{padding:11px 14px;background:#1a1a1a;border:1px solid #2a2a2a;border-radius:8px;cursor:pointer;font-size:12px;color:#aaa;text-align:left;transition:all .15s}
.pfolder:hover{border-color:#f0a500;color:#f0a500;background:#1f1a00}
.pfolder.active{border-color:#f0a500;background:#2a1f00;color:#f0a500}
.pfolder strong{display:block;font-size:13px;color:#ddd;margin-bottom:2px}
.pfolder span{font-size:9px;color:#555;word-break:break-all}
.or{text-align:center;color:#333;font-size:11px;margin:10px 0}
.custom-row{display:flex;gap:8px}
.custom-in{flex:1;padding:10px 13px;background:#1a1a1a;border:1px solid #2a2a2a;border-radius:7px;color:#eee;font-size:12px;outline:none}
.custom-in:focus{border-color:#f0a500}
.start-btn{padding:11px 22px;background:#f0a500;color:#111;font-size:13px;font-weight:800;border:none;border-radius:7px;cursor:pointer;white-space:nowrap}
.start-btn:disabled{opacity:.35;cursor:not-allowed}
/* Progress */
#progress-section{display:none;margin-top:28px}
.bar-wrap{background:#1e1e1e;border-radius:4px;overflow:hidden;height:10px;margin:10px 0}
.bar{height:10px;background:#f0a500;border-radius:4px;width:0;transition:width .4s}
#stat{font-size:12px;color:#888;min-height:18px}
.log{background:#0d0d0d;border:1px solid #1e1e1e;border-radius:8px;padding:12px;height:300px;overflow-y:auto;font-family:Consolas,monospace;font-size:11px;line-height:1.7;margin-top:10px}
.ok{color:#58d68d}.sk{color:#445}.fa{color:#e07070}.inf{color:#f0a500}
/* Done */
.done-box{background:#0b1f10;border:1px solid #1a5c28;border-radius:10px;padding:20px 24px;margin-top:20px;display:none}
.done-box h2{color:#58d68d;font-size:20px;margin-bottom:8px}
.done-stats{font-size:13px;color:#aaa;line-height:2}
.done-stats strong{color:#fff}
.err-list{background:#1a0a0a;border:1px solid #5c1e1e;border-radius:7px;padding:12px;margin-top:12px;font-size:11px;color:#e07070;max-height:150px;overflow-y:auto}
.back-btn{display:inline-block;margin-top:16px;padding:10px 20px;background:#f0a500;color:#111;font-weight:800;border-radius:7px;text-decoration:none;font-size:13px}
</style>
</head><body>
<div class="page">
  <h1>⚡ EA Batch Import</h1>
  <p class="sub">Import thousands of images directly to WP Media Library — runs on the server.</p>

  <div id="setup-section">
    <div class="slbl">Step 1 — Pick a folder</div>
    <div class="preset-grid">
      <?php foreach ($presets as $label => $path): ?>
      <button class="pfolder" onclick="pickFolder(this, <?= htmlspecialchars(json_encode($path)) ?>)">
        <strong><?= htmlspecialchars($label) ?></strong>
        <span><?= htmlspecialchars($path) ?></span>
      </button>
      <?php endforeach; ?>
    </div>
    <div class="or">— or type a custom path —</div>
    <div class="custom-row">
      <input type="text" class="custom-in" id="customPath"
             placeholder="C:/Users/merch/Downloads/my-images"
             oninput="pickCustom(this.value)">
    </div>

    <div class="slbl" style="margin-top:20px">Step 2 — Start</div>
    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
      <button class="start-btn" id="startBtn" disabled onclick="startImport()">⚡ Import to WordPress →</button>
      <span id="selPath" style="font-size:11px;color:#555"></span>
    </div>
  </div>

  <div id="progress-section">
    <div style="font-size:14px;font-weight:700;color:#f0a500;margin-bottom:6px" id="progTitle">⚙️ Importing…</div>
    <div id="stat">Starting…</div>
    <div class="bar-wrap"><div class="bar" id="bar"></div></div>
    <div class="log" id="log"></div>
    <div class="done-box" id="doneBox">
      <h2>✅ Import Complete!</h2>
      <div class="done-stats" id="doneStats"></div>
      <div class="err-list" id="errList" style="display:none"></div>
      <a class="back-btn" href="ea-batch-import.php">← Import Another Folder</a>
    </div>
  </div>
</div>

<script>
let chosenFolder = '';
let es = null;
let failedFiles = [];

function pickFolder(btn, path) {
  document.querySelectorAll('.pfolder').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  chosenFolder = path;
  document.getElementById('customPath').value = '';
  document.getElementById('selPath').textContent = path;
  document.getElementById('startBtn').disabled = false;
}
function pickCustom(val) {
  document.querySelectorAll('.pfolder').forEach(b => b.classList.remove('active'));
  chosenFolder = val.trim();
  document.getElementById('selPath').textContent = chosenFolder || '';
  document.getElementById('startBtn').disabled = !chosenFolder;
}

function log(cls, msg) {
  const d = document.getElementById('log');
  const r = document.createElement('div');
  r.className = cls; r.textContent = msg;
  d.appendChild(r);
  d.scrollTop = d.scrollHeight;
}
function setBar(pct, stat) {
  document.getElementById('bar').style.width = pct + '%';
  document.getElementById('stat').textContent = stat;
}

function startImport() {
  if (!chosenFolder) return;
  document.getElementById('setup-section').style.display = 'none';
  document.getElementById('progress-section').style.display = 'block';
  failedFiles = [];

  const url = 'ea-batch-import.php?stream=1&folder=' + encodeURIComponent(chosenFolder);
  es = new EventSource(url);

  es.onmessage = function(e) {
    const d = JSON.parse(e.data);
    const pct = d.total ? Math.round((d.done / d.total) * 100) : 0;

    if (d.t === 'start') {
      log('inf', '📂 Found ' + d.total + ' images. Starting import…');
      setBar(0, '0 / ' + d.total);
    } else if (d.t === 'ok') {
      log('ok', '✓ ' + d.f);
      setBar(pct, d.done + ' / ' + d.total + ' — ' + d.ok + ' uploaded, ' + d.sk + ' skipped, ' + d.fa + ' failed');
    } else if (d.t === 'skip') {
      log('sk', '⏭ SKIP (exists): ' + d.f);
      setBar(pct, d.done + ' / ' + d.total + ' — ' + d.ok + ' uploaded, ' + d.sk + ' skipped, ' + d.fa + ' failed');
    } else if (d.t === 'fail') {
      log('fa', '✗ FAIL: ' + d.f + ' — ' + d.msg);
      failedFiles.push(d.f + ': ' + d.msg);
      setBar(pct, d.done + ' / ' + d.total + ' — ' + d.ok + ' uploaded, ' + d.sk + ' skipped, ' + d.fa + ' failed');
    } else if (d.t === 'error') {
      log('fa', '⚠ ERROR: ' + d.msg);
      es.close();
    } else if (d.t === 'done') {
      es.close();
      setBar(100, 'Done!');
      document.getElementById('progTitle').textContent = '✅ Finished!';
      document.getElementById('doneBox').style.display = 'block';
      document.getElementById('doneStats').innerHTML =
        '<strong>' + d.ok + '</strong> uploaded to Media Library<br>' +
        '<strong style="color:#445">' + d.sk + '</strong> skipped (already existed)<br>' +
        (d.fa ? '<strong style="color:#e07070">' + d.fa + '</strong> failed — see list below<br>' : '') +
        '<br>Find your images in <strong>WP Admin → Media</strong>.';
      if (failedFiles.length) {
        const el = document.getElementById('errList');
        el.style.display = 'block';
        el.innerHTML = '<strong>Failed files:</strong><br>' + failedFiles.map(f => '• ' + f).join('<br>');
      }
    }
  };

  es.onerror = function() {
    if (es.readyState === EventSource.CLOSED) return; // normal close after done
    log('fa', '⚠ Connection lost — the import may still be running on the server. Refresh the page to check WP Media.');
    es.close();
  };
}
</script>
</body></html>
