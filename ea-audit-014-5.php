<?php
/**
 * EA-PRODUCT-IMPACT-AUDIT-014.5 — READ ONLY, NO DB CHANGES
 */
if (!defined('ABSPATH')) exit;
global $wpdb;

$excel_json = __DIR__ . '/ea-audit-014-excel-data.json';
if (!file_exists($excel_json)) {
    WP_CLI::error("Excel JSON not found: $excel_json");
}
$rows = json_decode(file_get_contents($excel_json), true);
WP_CLI::log("Excel rows loaded: " . count($rows));

// ── 1. Pull ALL product SKUs from DB ─────────────────────────────────────────
$db_products = $wpdb->get_results(
    "SELECT p.ID, p.post_title, p.post_name AS slug, p.post_status,
            p.post_type, pm_sku.meta_value AS sku,
            pm_img.meta_value AS featured_image_id,
            pm_gal.meta_value AS gallery_image_ids
     FROM {$wpdb->posts} p
     LEFT JOIN {$wpdb->postmeta} pm_sku ON pm_sku.post_id=p.ID AND pm_sku.meta_key='_sku'
     LEFT JOIN {$wpdb->postmeta} pm_img ON pm_img.post_id=p.ID AND pm_img.meta_key='_thumbnail_id'
     LEFT JOIN {$wpdb->postmeta} pm_gal ON pm_gal.post_id=p.ID AND pm_gal.meta_key='_product_image_gallery'
     WHERE p.post_type IN ('product','product_variation')
       AND p.post_status IN ('publish','draft','private','pending')",
    ARRAY_A
);

$db_by_sku = [];
$sku_dup_check = [];
foreach ($db_products as $p) {
    $sku = trim($p['sku'] ?? '');
    if (!$sku) continue;
    $sku_dup_check[$sku] = ($sku_dup_check[$sku] ?? 0) + 1;
    if (!isset($db_by_sku[$sku])) {
        $db_by_sku[$sku] = $p;
    }
}
$duplicate_skus = array_filter($sku_dup_check, fn($c) => $c > 1);

WP_CLI::log("DB products with SKU: " . count($db_by_sku));
WP_CLI::log("Duplicate SKUs in DB: " . count($duplicate_skus));

// ── 2. Build attachment path map (by attachment ID) ───────────────────────────
$att_ids = [];
foreach ($db_products as $p) {
    if ($p['featured_image_id']) $att_ids[] = (int)$p['featured_image_id'];
    if ($p['gallery_image_ids']) {
        foreach (explode(',', $p['gallery_image_ids']) as $gid) {
            if (trim($gid)) $att_ids[] = (int)trim($gid);
        }
    }
}
$att_ids = array_unique(array_filter($att_ids));

$att_paths = [];
if ($att_ids) {
    $placeholders = implode(',', array_fill(0, count($att_ids), '%d'));
    $att_rows = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT post_id, meta_value AS file_path
             FROM {$wpdb->postmeta}
             WHERE meta_key='_wp_attached_file' AND post_id IN ($placeholders)",
            ...$att_ids
        ),
        ARRAY_A
    );
    foreach ($att_rows as $a) {
        $att_paths[(int)$a['post_id']] = $a['file_path'];
    }
}

$upload_base = wp_upload_dir()['basedir'];

function ea_image_exists(int $att_id, array $att_paths, string $upload_base): bool {
    if (!$att_id) return false;
    $rel = $att_paths[$att_id] ?? '';
    if (!$rel) return false;
    return file_exists($upload_base . '/' . $rel);
}

// ── 3. Iterate Excel rows ─────────────────────────────────────────────────────
$results = [];
$stats = [
    'keep'         => 0, 'delete'       => 0,
    'ignore'       => 0, 'blank'        => 0,
    'sku_found'    => 0, 'sku_missing'  => 0,
    'slug_differs' => 0,
    'feat_ok'      => 0, 'feat_missing' => 0,
    'gal_ok'       => 0, 'gal_missing'  => 0,
    'img_broken'   => 0,
    'del_found'    => 0, 'del_missing'  => 0,
];

foreach ($rows as $row) {
    $sku           = $row['sku'];
    $decision      = strtolower(trim($row['decision']));
    $product_name  = $row['product_name'];
    $suggested     = $row['suggested_final'] ?: $product_name;
    $current_name  = $row['current_name'];
    $product_type  = $row['product_type'];

    // Decision counts
    if ($decision === 'keep')        $stats['keep']++;
    elseif (in_array($decision, ['delete'])) $stats['delete']++;
    elseif ($decision === 'ignore')  $stats['ignore']++;
    else                             $stats['blank']++;

    $db = $db_by_sku[$sku] ?? null;
    if ($db) {
        $stats['sku_found']++;
    } else {
        $stats['sku_missing']++;
        $results[] = ['sku' => $sku, 'issue' => 'SKU_NOT_FOUND', 'decision' => $row['decision'],
                       'detail' => "SKU '$sku' not in WooCommerce DB"];
        continue;
    }

    $db_id     = (int)$db['ID'];
    $db_slug   = $db['slug'];
    $db_status = $db['post_status'];
    $db_title  = $db['post_title'];
    $feat_id   = (int)($db['featured_image_id'] ?? 0);
    $gal_raw   = $db['gallery_image_ids'] ?? '';
    $gal_ids   = array_filter(array_map('intval', explode(',', $gal_raw)));

    // Slug impact
    $proposed_slug = sanitize_title($suggested);
    $slug_differs  = ($proposed_slug !== $db_slug);
    if ($slug_differs && in_array($decision, ['keep', 'delete'])) {
        $stats['slug_differs']++;
    }

    // Image checks
    $feat_ok = ea_image_exists($feat_id, $att_paths, $upload_base);
    if ($feat_id) {
        if ($feat_ok) $stats['feat_ok']++;
        else          { $stats['feat_missing']++; $stats['img_broken']++; }
    } else {
        $stats['feat_missing']++;
    }

    $gal_ok_count = 0;
    foreach ($gal_ids as $gid) {
        if (ea_image_exists($gid, $att_paths, $upload_base)) $gal_ok_count++;
        else $stats['img_broken']++;
    }
    if (!empty($gal_ids)) {
        if ($gal_ok_count === count($gal_ids)) $stats['gal_ok']++;
        else $stats['gal_missing']++;
    } else {
        $stats['gal_missing']++;
    }

    // Delete impact
    if (in_array($decision, ['delete'])) {
        if ($db) { $stats['del_found']++; }
        else     { $stats['del_missing']++; }

        $feat_path = '';
        if ($feat_id && isset($att_paths[$feat_id])) {
            $feat_path = $upload_base . '/' . $att_paths[$feat_id];
        }
        $results[] = [
            'sku'         => $sku,
            'issue'       => 'DELETE_CANDIDATE',
            'decision'    => $row['decision'],
            'db_id'       => $db_id,
            'db_status'   => $db_status,
            'db_title'    => $db_title,
            'feat_id'     => $feat_id,
            'feat_path'   => $feat_path,
            'feat_exists' => $feat_ok,
            'gal_count'   => count($gal_ids),
        ];
    }

    // Slug mismatch detail (keep only, for review)
    if ($slug_differs && $decision === 'keep') {
        $results[] = [
            'sku'           => $sku,
            'issue'         => 'SLUG_MISMATCH',
            'decision'      => $row['decision'],
            'current_slug'  => $db_slug,
            'proposed_slug' => $proposed_slug,
            'suggested'     => $suggested,
            'current_title' => $db_title,
        ];
    }

    // Broken image detail
    if ($feat_id && !$feat_ok) {
        $results[] = [
            'sku'    => $sku,
            'issue'  => 'FEAT_IMAGE_BROKEN',
            'detail' => "Attachment ID $feat_id path not found on disk",
            'path'   => $att_paths[$feat_id] ?? '(no meta)',
        ];
    }
}

// ── 4. Variant group analysis (Keep rows only) ────────────────────────────────
$variant_groups = [];
foreach ($rows as $row) {
    $dec = strtolower(trim($row['decision']));
    if ($dec !== 'keep') continue;
    $grp = $row['product_name'] ?: $row['suggested_final'];
    if (!$grp) continue;
    $v   = $row['variant'];
    $variant_groups[$grp][] = ['sku' => $row['sku'], 'variant' => $v];
}

$groups_gt1    = 0;
$blank_vars    = [];
$dup_vars      = [];
$risky_groups  = [];

foreach ($variant_groups as $name => $members) {
    $variants = array_column($members, 'variant');
    $blank_in = array_filter($variants, fn($v) => $v === '');
    if (!empty($blank_in)) {
        $blank_vars[$name] = count($blank_in);
    }
    $dup_check = array_filter(array_count_values($variants), fn($c) => $c > 1);
    if (!empty($dup_check)) {
        $dup_vars[$name] = $dup_check;
        $risky_groups[] = $name;
    }
    if (count($members) > 1) $groups_gt1++;
}

// ── 5. Duplicate final name risk ──────────────────────────────────────────────
$final_name_sku_map = [];
foreach ($rows as $row) {
    $dec = strtolower(trim($row['decision']));
    if ($dec !== 'keep') continue;
    $fn  = $row['product_name'] ?: $row['suggested_final'];
    if (!$fn) continue;
    $final_name_sku_map[$fn][] = $row['sku'];
}
$risky_names = [];
foreach ($final_name_sku_map as $name => $skus) {
    if (count($skus) > 1) {
        // Expected if they are variants of same group — check if they share a product group
        $types = array_map(fn($s) => $rows[array_search($s, array_column($rows,'sku'))]['product_type'] ?? '', $skus);
        $risky_names[$name] = ['skus' => $skus, 'types' => $types];
    }
}

// ── 6. Output ─────────────────────────────────────────────────────────────────
WP_CLI::log('');
WP_CLI::log('===== EA-PRODUCT-IMPACT-AUDIT-014.5 RESULTS =====');
WP_CLI::log('');
WP_CLI::log('--- 1. Excel Decision Summary ---');
WP_CLI::log("Keep:    {$stats['keep']}");
WP_CLI::log("Delete:  {$stats['delete']}");
WP_CLI::log("Ignore:  {$stats['ignore']}");
WP_CLI::log("Blank:   {$stats['blank']}");
WP_CLI::log('');
WP_CLI::log('--- 2. SKU Match Summary ---');
WP_CLI::log("Found:      {$stats['sku_found']}");
WP_CLI::log("Missing:    {$stats['sku_missing']}");
WP_CLI::log("Duplicates: " . count($duplicate_skus));
if ($duplicate_skus) {
    foreach ($duplicate_skus as $sku => $cnt) WP_CLI::log("  DUPE: $sku x$cnt");
}
WP_CLI::log('');
WP_CLI::log('--- 3. Slug Impact Summary ---');
WP_CLI::log("Rows where title change would alter slug: {$stats['slug_differs']}");
WP_CLI::log("NOTE: Slugs will NOT be changed in execution (per rules)");
$slug_issues = array_filter($results, fn($r) => $r['issue'] === 'SLUG_MISMATCH');
WP_CLI::log("Slug mismatch details (first 10):");
foreach (array_slice($slug_issues, 0, 10) as $r) {
    WP_CLI::log("  SKU:{$r['sku']} current_slug:{$r['current_slug']} proposed_slug:{$r['proposed_slug']}");
}
WP_CLI::log('');
WP_CLI::log('--- 4. Image Safety Summary ---');
WP_CLI::log("Featured images OK:      {$stats['feat_ok']}");
WP_CLI::log("Featured images MISSING: {$stats['feat_missing']}");
WP_CLI::log("Gallery OK:              {$stats['gal_ok']}");
WP_CLI::log("Gallery MISSING/EMPTY:   {$stats['gal_missing']}");
WP_CLI::log("Total broken paths:      {$stats['img_broken']}");
$broken = array_filter($results, fn($r) => $r['issue'] === 'FEAT_IMAGE_BROKEN');
foreach (array_slice($broken, 0, 10) as $r) {
    WP_CLI::log("  SKU:{$r['sku']} {$r['detail']}");
}
WP_CLI::log('');
WP_CLI::log('--- 5. Delete Impact Summary ---');
WP_CLI::log("Delete rows in Excel:    {$stats['delete']}");
WP_CLI::log("Delete SKUs found in DB: {$stats['del_found']}");
WP_CLI::log("Delete SKUs missing:     {$stats['del_missing']}");
$del_rows = array_filter($results, fn($r) => $r['issue'] === 'DELETE_CANDIDATE');
WP_CLI::log("Delete candidates (all):");
foreach ($del_rows as $r) {
    $fe = $r['feat_exists'] ? 'img_ok' : 'img_MISSING';
    WP_CLI::log("  SKU:{$r['sku']} ID:{$r['db_id']} status:{$r['db_status']} feat:{$r['feat_id']} $fe gal:{$r['gal_count']}");
}
WP_CLI::log('');
WP_CLI::log('--- 6. Variant Group Summary ---');
WP_CLI::log("Total variant groups (product names with >=1 member): " . count($variant_groups));
WP_CLI::log("Groups with >1 variant:  $groups_gt1");
WP_CLI::log("Groups with blank variant values: " . count($blank_vars));
foreach ($blank_vars as $name => $cnt) WP_CLI::log("  BLANK: '$name' has $cnt blank variants");
WP_CLI::log("Groups with duplicate variant labels: " . count($dup_vars));
foreach ($dup_vars as $name => $dups) WP_CLI::log("  DUP: '$name' " . json_encode($dups));
WP_CLI::log('');
WP_CLI::log('--- 7. Duplicate Final Name Risk ---');
WP_CLI::log("Final names shared by >1 SKU: " . count($risky_names));
foreach (array_slice($risky_names, 0, 20) as $name => $info) {
    WP_CLI::log("  NAME:'$name' SKUs:" . implode(', ', $info['skus']));
}
WP_CLI::log('');
WP_CLI::log('--- Unmatched SKUs ---');
$notfound = array_filter($results, fn($r) => $r['issue'] === 'SKU_NOT_FOUND');
foreach ($notfound as $r) WP_CLI::log("  SKU:{$r['sku']} decision:{$r['decision']}");
WP_CLI::log('');
WP_CLI::log('===== END OF AUDIT =====');
