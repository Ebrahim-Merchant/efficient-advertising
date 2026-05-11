<?php
/**
 * Theme Selector Tool (Updated with Efficient Modern)
 */
require_once('wp-load.php');

$message = '';
if (isset($_GET['activate_theme'])) {
    $theme_name = $_GET['activate_theme'];
    $themes = wp_get_themes();
    
    if (isset($themes[$theme_name])) {
        switch_theme($theme_name);
        $message = "<div style='padding: 20px; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px; font-weight: bold;'>
                        Theme '" . esc_html($theme_name) . "' is now ACTIVE. <br>
                        <a href='" . home_url() . "' target='_blank'>Click here to view your site</a>
                    </div>";
    } else {
        $message = "<div style='padding: 20px; background: #fee2e2; color: #991b1b; border-radius: 8px; margin-bottom: 20px;'>Theme folder '$theme_name' not found.</div>";
    }
}

$available_themes = [
    'efficient-modern' => '🏆 Efficient Modern (12 Products / Match Production Header)',
    'Efficient' => 'Modern Premium (Amber & Dark Navy)',
    'Efficient-backup-20260313' => 'Legacy Corporate (March 2023 Backup)',
    'Efficient-dev' => 'Current Dev Version'
];

$current_theme = get_stylesheet();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Theme Review Selector</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #f1f5f9; color: #1e293b; padding: 40px; }
        .container { max-width: 850px; margin: 0 auto; background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
        h1 { margin-top: 0; color: #0f172a; font-size: 32px; font-weight: 800; letter-spacing: -1px; }
        p { color: #64748b; font-size: 16px; margin-bottom: 30px; }
        .theme-card { display: flex; align-items: center; justify-content: space-between; padding: 25px; border: 2px solid #e2e8f0; border-radius: 16px; margin-bottom: 15px; transition: all 0.3s; }
        .theme-card.active { border-color: #3b82f6; background: #f0f7ff; box-shadow: 0 4px 20px rgba(59, 130, 246, 0.15); }
        .theme-card.modern { border-color: #059669; }
        .theme-card.modern.active { border-color: #059669; background: #f0fdf4; }
        .theme-info h3 { margin: 0; font-size: 20px; color: #0f172a; }
        .theme-info p { margin: 6px 0 0; color: #64748b; font-size: 14px; }
        .btn { padding: 12px 24px; border-radius: 10px; border: none; font-weight: 700; cursor: pointer; text-decoration: none; font-size: 14px; transition: all 0.2s; }
        .btn-activate { background: #0f172a; color: #fff; }
        .btn-activate:hover { background: #334155; transform: translateY(-2px); }
        .btn-current { background: #3b82f6; color: #fff; cursor: default; }
        .btn-current.modern { background: #059669; }
        .badge { background: #3b82f6; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 10px; text-transform: uppercase; margin-left: 10px; vertical-align: middle; }
        .badge-modern { background: #059669; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Theme Review Selector</h1>
        <p>I found the "Efficient Modern" theme in your backups and copied it here. You can now toggle it live.</p>
        
        <?php echo $message; ?>

        <div class="theme-list">
            <?php foreach ($available_themes as $folder => $label): 
                $is_active = ($current_theme === $folder);
                $is_modern = ($folder === 'efficient-modern');
            ?>
                <div class="theme-card <?php echo $is_active ? 'active' : ''; ?> <?php echo $is_modern ? 'modern' : ''; ?>">
                    <div class="theme-info">
                        <h3><?php echo esc_html($label); ?> <?php if($is_active) echo "<span class='badge " . ($is_modern ? 'badge-modern' : '') . "'>Active Now</span>"; ?></h3>
                        <p>Folder Location: <code>/wp-content/themes/<?php echo esc_html($folder); ?>/</code></p>
                    </div>
                    <div>
                        <?php if ($is_active): ?>
                            <span class="btn btn-current <?php echo $is_modern ? 'modern' : ''; ?>">Currently Loaded</span>
                        <?php else: ?>
                            <a href="?activate_theme=<?php echo urlencode($folder); ?>" class="btn btn-activate">Activate Version</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div style="margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 25px; text-align: center;">
            <a href="<?php echo home_url(); ?>" target="_blank" style="color: #64748b; text-decoration: none; font-weight: 700; font-size: 15px;">&larr; Go to Home Page</a>
        </div>
    </div>
</body>
</html>
