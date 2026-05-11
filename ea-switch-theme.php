<?php
/**
 * ea-switch-theme.php — Temporarily switch active WordPress theme
 * Access: http://efficientadvt.local/ea-switch-theme.php
 * DELETE this file when done.
 */
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
if (!preg_match('/^(127\.|10\.|192\.168\.|172\.(1[6-9]|2[0-9]|3[01])\.)/', $ip)) {
    http_response_code(403); die('Forbidden');
}

define('WP_USE_THEMES', false);
require __DIR__ . '/wp-load.php';

$current_template   = get_option('template');
$current_stylesheet = get_option('stylesheet');

$action = $_POST['action'] ?? '';
$target = sanitize_text_field($_POST['theme'] ?? '');

$msg = '';
if ($action === 'switch' && $target) {
    // Verify theme exists
    $theme = wp_get_theme($target);
    if (!$theme->exists()) {
        $msg = '<div style="color:#f66">Theme not found: ' . esc_html($target) . '</div>';
    } else {
        update_option('template',   $target);
        update_option('stylesheet', $target);
        delete_option('theme_switched');
        wp_clean_themes_cache();
        $msg = '<div style="color:#6f6">✅ Switched to: <strong>' . esc_html($target) . '</strong></div>';
        $current_template = $target;
        $current_stylesheet = $target;
    }
}

// List available themes
$themes = wp_get_themes();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>EA Theme Switcher</title>
<style>
body{font-family:sans-serif;background:#111;color:#eee;padding:30px;max-width:600px}
h2{color:#f0a500}
.cur{background:#1a2a1a;border:1px solid #2a5a2a;border-radius:8px;padding:14px 18px;margin:16px 0}
.cur strong{color:#6f6}
select,button{padding:10px 16px;border-radius:6px;border:none;font-size:14px;cursor:pointer}
select{background:#222;color:#eee;border:1px solid #444;width:100%;margin:10px 0}
.go{background:#f0a500;color:#111;font-weight:800;margin-top:8px;width:100%}
.go:hover{opacity:.85}
.restore{background:#444;color:#eee;width:100%;margin-top:8px}
a{color:#f0a500}
.msg{margin:12px 0;padding:10px 14px;background:#1a1a1a;border-radius:6px;font-weight:700}
.preview{margin-top:18px}
.preview a{display:inline-block;padding:10px 20px;background:#1a3a5a;color:#6af;
  border-radius:6px;text-decoration:none;font-weight:700}
.preview a:hover{background:#1f4a70}
.warn{color:#fa0;font-size:12px;margin-top:20px;border-top:1px solid #333;padding-top:14px}
</style>
</head>
<body>
<h2>🎨 EA Theme Switcher</h2>

<div class="cur">
  Currently active: <strong><?= esc_html($current_stylesheet) ?></strong>
</div>

<?php if ($msg): ?><div class="msg"><?= $msg ?></div><?php endif; ?>

<form method="post">
  <input type="hidden" name="action" value="switch">
  <label style="font-size:13px;color:#aaa">Select theme to activate:</label>
  <select name="theme">
    <?php foreach ($themes as $slug => $theme): ?>
      <option value="<?= esc_attr($slug) ?>"
        <?= $slug === 'Efficient-backup-20260313' ? 'selected' : '' ?>>
        <?= esc_html($theme->get('Name')) ?> (<?= esc_html($slug) ?>)
      </option>
    <?php endforeach; ?>
  </select>
  <button type="submit" class="go">▶ Activate Selected Theme</button>
</form>

<form method="post" style="margin-top:6px">
  <input type="hidden" name="action" value="switch">
  <input type="hidden" name="theme" value="Efficient-dev">
  <button type="submit" class="restore">↩ Restore: Efficient-dev</button>
</form>

<div class="preview">
  <a href="http://efficientadvt.local/" target="_blank">🌐 Preview Site →</a>
</div>

<p class="warn">⚠ This is a local tool. Delete <code>ea-switch-theme.php</code> when done.</p>
</body>
</html>
