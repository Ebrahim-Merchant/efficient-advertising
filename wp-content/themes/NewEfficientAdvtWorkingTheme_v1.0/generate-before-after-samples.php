<?php

declare(strict_types=1);

$_SERVER['HTTP_HOST'] = 'newefficientadvertising09042026.local';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['REQUEST_METHOD'] = 'GET';

require_once dirname(__DIR__, 3) . '/wp-load.php';

$workbookPath = 'C:/Users/merch/OneDrive/Downloads/Edge Browser Downloads New/eprint_ae_product_catalogue_v8.xlsx';
$outPath = __DIR__ . '/BEFORE_AFTER_5_PRODUCTS.md';

function ea_col_to_index_ba(string $col): int {
    $col = strtoupper($col);
    $idx = 0;
    for ($i = 0; $i < strlen($col); $i++) {
        $idx = $idx * 26 + (ord($col[$i]) - 64);
    }
    return $idx - 1;
}

function ea_read_sheet_rows_ba(string $xlsxPath, string $targetSheetName): array {
    $zip = new ZipArchive();
    if ($zip->open($xlsxPath) !== true) {
        throw new RuntimeException('Unable to open workbook');
    }

    $shared = [];
    $sharedXml = $zip->getFromName('xl/sharedStrings.xml');
    if ($sharedXml) {
        $sx = simplexml_load_string($sharedXml);
        if ($sx !== false) {
            foreach ($sx->si as $si) {
                if (isset($si->t)) {
                    $shared[] = (string)$si->t;
                } else {
                    $txt = '';
                    if (isset($si->r)) {
                        foreach ($si->r as $r) {
                            $txt .= (string)$r->t;
                        }
                    }
                    $shared[] = $txt;
                }
            }
        }
    }

    $wbXml = $zip->getFromName('xl/workbook.xml');
    $relsXml = $zip->getFromName('xl/_rels/workbook.xml.rels');
    if (!$wbXml || !$relsXml) {
        $zip->close();
        throw new RuntimeException('Workbook structure invalid');
    }

    $wb = simplexml_load_string($wbXml);
    $rels = simplexml_load_string($relsXml);
    if ($wb === false || $rels === false) {
        $zip->close();
        throw new RuntimeException('Workbook XML parse failed');
    }

    $wb->registerXPathNamespace('m', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
    $rels->registerXPathNamespace('pr', 'http://schemas.openxmlformats.org/package/2006/relationships');

    $rid = '';
    $sheets = $wb->xpath('//m:sheets/m:sheet');
    if ($sheets) {
        foreach ($sheets as $sheet) {
            if ((string)$sheet['name'] === $targetSheetName) {
                $rid = (string)$sheet->attributes('http://schemas.openxmlformats.org/officeDocument/2006/relationships')->id;
                break;
            }
        }
    }
    if ($rid === '') {
        $zip->close();
        throw new RuntimeException('Target sheet not found');
    }

    $target = '';
    $relationships = $rels->xpath('//pr:Relationship');
    if ($relationships) {
        foreach ($relationships as $rel) {
            if ((string)$rel['Id'] === $rid) {
                $target = (string)$rel['Target'];
                break;
            }
        }
    }
    if ($target === '') {
        $zip->close();
        throw new RuntimeException('Worksheet target not found');
    }

    $target = ltrim($target, '/');
    if (strpos($target, 'xl/') !== 0) {
        $target = 'xl/' . $target;
    }

    $sheetXml = $zip->getFromName($target);
    $zip->close();
    if (!$sheetXml) {
        throw new RuntimeException('Worksheet XML missing');
    }

    $sheet = simplexml_load_string($sheetXml);
    if ($sheet === false) {
        throw new RuntimeException('Worksheet XML parse failed');
    }

    $sheet->registerXPathNamespace('m', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
    $rows = $sheet->xpath('//m:sheetData/m:row');
    if (!$rows) return [];

    $out = [];
    foreach ($rows as $row) {
        $rowData = [];
        foreach ($row->c as $c) {
            $ref = (string)$c['r'];
            $col = preg_replace('/\d+/', '', $ref);
            $idx = ea_col_to_index_ba($col);
            $type = (string)$c['t'];
            $value = '';
            if ($type === 's') {
                $si = isset($c->v) ? (int)$c->v : -1;
                $value = ($si >= 0 && isset($shared[$si])) ? $shared[$si] : '';
            } elseif ($type === 'inlineStr' && isset($c->is->t)) {
                $value = (string)$c->is->t;
            } elseif (isset($c->v)) {
                $value = (string)$c->v;
            }
            $rowData[$idx] = trim((string)$value);
        }
        if (!empty($rowData)) {
            ksort($rowData);
            $max = max(array_keys($rowData));
            $normalized = array_fill(0, $max + 1, '');
            foreach ($rowData as $i => $v) {
                $normalized[$i] = $v;
            }
            $out[] = $normalized;
        }
    }

    return $out;
}

$rows = ea_read_sheet_rows_ba($workbookPath, '📦 Product Catalogue');
if (count($rows) < 2) {
    throw new RuntimeException('No data rows in workbook');
}

$headers = $rows[0];
$idx = [];
foreach ($headers as $i => $h) {
    $k = strtolower(trim((string)$h));
    if ($k !== '') {
        $idx[$k] = $i;
    }
}

$required = [
    'sku',
    'individual product',
    'short description',
    'seo title (≤60 chars)',
    'meta description (≤155 chars)'
];
foreach ($required as $r) {
    if (!array_key_exists($r, $idx)) {
        throw new RuntimeException('Missing workbook column: ' . $r);
    }
}

$targetSkus = ['PS-001', 'PS-002', 'PS-003', 'PS-004', 'PS-005'];
$workbookBySku = [];
for ($r = 1; $r < count($rows); $r++) {
    $row = $rows[$r];
    $sku = strtoupper(trim((string)($row[$idx['sku']] ?? '')));
    if ($sku === '') continue;
    if (!in_array($sku, $targetSkus, true)) continue;

    $workbookBySku[$sku] = [
        'title' => trim((string)($row[$idx['individual product']] ?? '')),
        'short' => trim((string)($row[$idx['short description']] ?? '')),
        'seo_title' => trim((string)($row[$idx['seo title (≤60 chars)']] ?? '')),
        'meta_desc' => trim((string)($row[$idx['meta description (≤155 chars)']] ?? '')),
    ];
}

$lines = [];
$lines[] = '# Before vs After - 5 Product Examples';
$lines[] = '';
$lines[] = 'Method:';
$lines[] = '- Before = workbook master row values';
$lines[] = '- After = live WordPress values after sync';
$lines[] = '';

foreach ($targetSkus as $sku) {
    $before = $workbookBySku[$sku] ?? null;
    $pid = (int)wc_get_product_id_by_sku($sku);
    if (!$before || $pid <= 0) {
        $lines[] = '## ' . $sku;
        $lines[] = '- Status: Missing workbook or product match.';
        $lines[] = '';
        continue;
    }

    $post = get_post($pid);
    $afterTitle = $post ? $post->post_title : '';
    $afterShort = $post ? wp_strip_all_tags((string)$post->post_excerpt) : '';
    $afterSeoTitle = (string)get_post_meta($pid, '_yoast_wpseo_title', true);
    $afterMetaDesc = (string)get_post_meta($pid, '_yoast_wpseo_metadesc', true);

    $lines[] = '## ' . $sku;
    $lines[] = '- Product URL: ' . get_permalink($pid);
    $lines[] = '- Title before: ' . $before['title'];
    $lines[] = '- Title after: ' . $afterTitle;
    $lines[] = '- Short before: ' . $before['short'];
    $lines[] = '- Short after: ' . $afterShort;
    $lines[] = '- SEO title before: ' . $before['seo_title'];
    $lines[] = '- SEO title after: ' . $afterSeoTitle;
    $lines[] = '- Meta before: ' . $before['meta_desc'];
    $lines[] = '- Meta after: ' . $afterMetaDesc;
    $lines[] = '';
}

file_put_contents($outPath, implode(PHP_EOL, $lines));
echo 'WROTE=' . $outPath . PHP_EOL;
