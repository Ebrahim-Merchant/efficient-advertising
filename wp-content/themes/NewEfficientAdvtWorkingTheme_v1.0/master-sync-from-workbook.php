<?php

declare(strict_types=1);

$_SERVER['HTTP_HOST'] = 'newefficientadvertising09042026.local';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['REQUEST_METHOD'] = 'GET';

require_once dirname(__DIR__, 3) . '/wp-load.php';

$workbookPath = 'C:/Users/merch/OneDrive/Downloads/Edge Browser Downloads New/eprint_ae_product_catalogue_v8.xlsx';
$reportPath = __DIR__ . '/master-sync-report.json';

if (!file_exists($workbookPath)) {
    fwrite(STDERR, "Workbook missing: {$workbookPath}\n");
    exit(1);
}

function ea_col_to_index(string $col): int {
    $col = strtoupper($col);
    $len = strlen($col);
    $idx = 0;
    for ($i = 0; $i < $len; $i++) {
        $idx = $idx * 26 + (ord($col[$i]) - 64);
    }
    return $idx - 1;
}

function ea_trim_words(string $text, int $maxWords): string {
    $text = trim(preg_replace('/\s+/', ' ', wp_strip_all_tags($text)));
    if ($text === '') return '';
    $words = preg_split('/\s+/', $text) ?: [];
    if (count($words) <= $maxWords) return $text;
    return implode(' ', array_slice($words, 0, $maxWords)) . '...';
}

function ea_list_html(string $value, string $heading): string {
    $items = array_filter(array_map('trim', explode('|', (string)$value)));
    if (empty($items)) return '';
    $lis = '';
    foreach ($items as $it) {
        $lis .= '<li>' . esc_html($it) . '</li>';
    }
    return '<h3>' . esc_html($heading) . '</h3><ul>' . $lis . '</ul>';
}

function ea_fix_brand(string $text): string {
    $text = trim($text);
    if ($text === '') return '';
    $text = preg_replace('/eprint\.ae/i', 'efficientadvt.com', $text) ?? $text;
    $text = preg_replace('/\beprint\b/i', 'Efficient Advertising', $text) ?? $text;
    return trim($text);
}

function ea_read_sheet_rows(string $xlsxPath, string $targetSheetName): array {
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
    $wb->registerXPathNamespace('r', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships');
    $rels->registerXPathNamespace('pr', 'http://schemas.openxmlformats.org/package/2006/relationships');

    $rid = '';
    $sheets = $wb->xpath('//m:sheets/m:sheet');
    if ($sheets) {
        foreach ($sheets as $sheet) {
            $name = (string)$sheet['name'];
            if ($name === $targetSheetName) {
                $rid = (string)$sheet->attributes('http://schemas.openxmlformats.org/officeDocument/2006/relationships')->id;
                break;
            }
        }
    }
    if ($rid === '') {
        $zip->close();
        throw new RuntimeException('Target sheet not found: ' . $targetSheetName);
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
        throw new RuntimeException('Worksheet target not found for ' . $rid);
    }

    $target = ltrim($target, '/');
    if (strpos($target, 'xl/') !== 0) {
        $target = 'xl/' . $target;
    }

    $sheetXml = $zip->getFromName($target);
    $zip->close();
    if (!$sheetXml) {
        throw new RuntimeException('Worksheet XML missing: ' . $target);
    }

    $sheet = simplexml_load_string($sheetXml);
    if ($sheet === false) {
        throw new RuntimeException('Worksheet XML parse failed');
    }

    $sheet->registerXPathNamespace('m', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
    $rows = $sheet->xpath('//m:sheetData/m:row');
    if (!$rows) {
        return [];
    }

    $out = [];
    foreach ($rows as $row) {
        $rowData = [];
        foreach ($row->c as $c) {
            $ref = (string)$c['r'];
            $col = preg_replace('/\d+/', '', $ref);
            $idx = ea_col_to_index($col);
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

$rows = ea_read_sheet_rows($workbookPath, '📦 Product Catalogue');
if (count($rows) < 2) {
    fwrite(STDERR, "No data rows in Product Catalogue sheet\n");
    exit(1);
}

$headers = $rows[0];
$headerIndex = [];
foreach ($headers as $i => $h) {
    $key = strtolower(trim((string)$h));
    if ($key !== '') {
        $headerIndex[$key] = $i;
    }
}

$need = [
    'sku', 'category', 'sub-category', 'product group', 'individual product',
    'seo title (≤60 chars)', 'url slug', 'meta description (≤155 chars)',
    'short description', 'full description', 'key features (pipe-separated)',
    'material / substrate options', 'finish options', 'ideal use cases', 'image alt text', 'seo tags', 'product status'
];

foreach ($need as $col) {
    if (!array_key_exists($col, $headerIndex)) {
        fwrite(STDERR, "Missing column: {$col}\n");
        exit(1);
    }
}

$stats = [
    'workbook_rows' => count($rows) - 1,
    'processed_rows' => 0,
    'skipped_no_sku' => 0,
    'created_products' => 0,
    'updated_products' => 0,
    'assigned_parent_terms' => 0,
    'assigned_child_terms' => 0,
    'seo_updated' => 0,
    'alt_updated' => 0,
    'errors' => 0,
    'skipped_non_product_posts' => 0,
    'error_samples' => [],
    'samples' => [],
];

for ($r = 1; $r < count($rows); $r++) {
    $row = $rows[$r];

    $sku = strtoupper(trim((string)($row[$headerIndex['sku']] ?? '')));
    if ($sku === '') {
        $stats['skipped_no_sku']++;
        continue;
    }

    $stats['processed_rows']++;

    $category = trim((string)($row[$headerIndex['category']] ?? ''));
    $subcat = trim((string)($row[$headerIndex['sub-category']] ?? ''));
    $group = trim((string)($row[$headerIndex['product group']] ?? ''));
    $individual = trim((string)($row[$headerIndex['individual product']] ?? ''));
    $title = $individual !== '' ? $individual : ($group !== '' ? $group : $sku);

    $seoTitle = ea_fix_brand((string)($row[$headerIndex['seo title (≤60 chars)']] ?? ''));
    $slug = sanitize_title(trim((string)($row[$headerIndex['url slug']] ?? '')));
    $metaDesc = ea_fix_brand((string)($row[$headerIndex['meta description (≤155 chars)']] ?? ''));
    $short = ea_trim_words(ea_fix_brand((string)($row[$headerIndex['short description']] ?? '')), 35);
    $full = ea_fix_brand((string)($row[$headerIndex['full description']] ?? ''));
    $features = (string)($row[$headerIndex['key features (pipe-separated)']] ?? '');
    $materials = (string)($row[$headerIndex['material / substrate options']] ?? '');
    $finish = (string)($row[$headerIndex['finish options']] ?? '');
    $useCases = (string)($row[$headerIndex['ideal use cases']] ?? '');
    $altText = trim((string)($row[$headerIndex['image alt text']] ?? ''));
    $tags = trim((string)($row[$headerIndex['seo tags']] ?? ''));
    $statusRaw = strtolower(trim((string)($row[$headerIndex['product status']] ?? 'published')));
    $postStatus = ($statusRaw === 'draft' || $statusRaw === 'private' || $statusRaw === 'pending') ? $statusRaw : 'publish';

    $body = '';
    if ($full !== '') {
        $body .= '<p>' . esc_html($full) . '</p>';
    }
    $body .= ea_list_html($features, 'Key Features');
    $body .= ea_list_html($materials, 'Materials / Substrate Options');
    $body .= ea_list_html($finish, 'Finish Options');
    $body .= ea_list_html($useCases, 'Ideal Use Cases');

    $productId = (int)wc_get_product_id_by_sku($sku);
    $isCreate = $productId <= 0;
    $existingPostType = $isCreate ? '' : get_post_type($productId);

    $postArr = [
        'post_title' => $title,
        'post_excerpt' => $short,
        'post_content' => $body,
        'post_status' => $postStatus,
    ];
    if ($slug !== '') {
        $postArr['post_name'] = $slug;
    }

    if ($isCreate) {
        $postArr['post_type'] = 'product';
        $productId = wp_insert_post($postArr, true);
        if (is_wp_error($productId) || !$productId) {
            $stats['errors']++;
            if (count($stats['error_samples']) < 25) {
                $stats['error_samples'][] = [
                    'sku' => $sku,
                    'stage' => 'insert',
                    'message' => is_wp_error($productId) ? $productId->get_error_message() : 'insert returned empty ID',
                ];
            }
            continue;
        }
        update_post_meta($productId, '_sku', $sku);
        update_post_meta($productId, '_stock_status', 'instock');
        update_post_meta($productId, '_manage_stock', 'no');
        update_post_meta($productId, '_regular_price', '');
        update_post_meta($productId, '_price', '');
        $stats['created_products']++;
    } else {
        if (!in_array($existingPostType, ['product', 'product_variation'], true)) {
            $stats['skipped_non_product_posts']++;
            continue;
        }
        // Some migrated products carry invalid `_wp_page_template` values,
        // which causes wp_update_post() to fail with "Invalid page template".
        delete_post_meta($productId, '_wp_page_template');
        $postArr['ID'] = $productId;
        $res = wp_update_post($postArr, true);
        if (is_wp_error($res)) {
            $stats['errors']++;
            if (count($stats['error_samples']) < 25) {
                $stats['error_samples'][] = [
                    'sku' => $sku,
                    'product_id' => $productId,
                    'stage' => 'update',
                    'message' => $res->get_error_message(),
                ];
            }
            continue;
        }
        $stats['updated_products']++;
    }

    $termIds = [];
    if ($category !== '') {
        $parentTerm = term_exists($category, 'product_cat');
        if (!$parentTerm) {
            $parentTerm = wp_insert_term($category, 'product_cat');
        }
        $parentTermId = 0;
        if (!is_wp_error($parentTerm)) {
            if (is_array($parentTerm) && !empty($parentTerm['term_id'])) {
                $parentTermId = (int)$parentTerm['term_id'];
            } elseif (is_int($parentTerm)) {
                $parentTermId = $parentTerm;
            }
        }
        if ($parentTermId > 0) {
            $pid = $parentTermId;
            $termIds[] = $pid;
            $stats['assigned_parent_terms']++;
            if ($subcat !== '') {
                $childTerm = term_exists($subcat, 'product_cat', $pid);
                if (!$childTerm) {
                    $childTerm = wp_insert_term($subcat, 'product_cat', ['parent' => $pid]);
                }
                $childTermId = 0;
                if (!is_wp_error($childTerm)) {
                    if (is_array($childTerm) && !empty($childTerm['term_id'])) {
                        $childTermId = (int)$childTerm['term_id'];
                    } elseif (is_int($childTerm)) {
                        $childTermId = $childTerm;
                    }
                }
                if ($childTermId > 0) {
                    $termIds[] = $childTermId;
                    $stats['assigned_child_terms']++;
                }
            }
        }
    }
    if ($existingPostType !== 'product_variation' && !empty($termIds)) {
        wp_set_object_terms($productId, array_values(array_unique($termIds)), 'product_cat');
    }

    if ($tags !== '') {
        $tagList = array_filter(array_map('trim', explode(',', $tags)));
        if (!empty($tagList)) {
            wp_set_object_terms($productId, $tagList, 'product_tag', false);
        }
    }

    if ($seoTitle !== '') {
        update_post_meta($productId, '_yoast_wpseo_title', $seoTitle);
        $stats['seo_updated']++;
    }
    if ($metaDesc !== '') {
        update_post_meta($productId, '_yoast_wpseo_metadesc', $metaDesc);
        $stats['seo_updated']++;
    }

    if ($altText !== '') {
        $thumbId = (int)get_post_thumbnail_id($productId);
        if ($thumbId > 0) {
            update_post_meta($thumbId, '_wp_attachment_image_alt', $altText);
            $stats['alt_updated']++;
        }
    }

    if (count($stats['samples']) < 8) {
        $stats['samples'][] = [
            'sku' => $sku,
            'product_id' => $productId,
            'title' => $title,
            'slug' => get_post_field('post_name', $productId),
            'category' => $category,
            'sub_category' => $subcat,
            'short_description' => $short,
            'seo_title' => $seoTitle,
            'meta_description' => $metaDesc,
        ];
    }

    if ($stats['processed_rows'] % 100 === 0) {
        echo 'PROGRESS=' . $stats['processed_rows'] . PHP_EOL;
    }
}

file_put_contents($reportPath, json_encode($stats, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo 'WROTE=' . $reportPath . PHP_EOL;
foreach ($stats as $k => $v) {
    if (!is_array($v)) {
        echo strtoupper($k) . '=' . $v . PHP_EOL;
    }
}
