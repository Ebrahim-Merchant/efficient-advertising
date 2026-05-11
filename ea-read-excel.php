<?php
/**
 * ea-read-excel.php — Read xlsx files and output JSON structure
 * Access: http://efficientadvt.local/ea-read-excel.php
 */
error_reporting(0);
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
if (!preg_match('/^(127\.|10\.|192\.168\.|172\.(1[6-9]|2[0-9]|3[01])\.)/', $ip)) {
    http_response_code(403); die('Forbidden');
}
header('Content-Type: application/json');

function readXlsx($path) {
    if (!file_exists($path)) return ['error' => 'File not found', 'path' => $path];

    $zip = new ZipArchive();
    if ($zip->open($path, ZipArchive::RDONLY) !== true) return ['error' => 'Cannot open — close the file in Excel first'];

    // Shared strings (pure regex — no XML parser, no namespace issues)
    $strings = [];
    $ssXml = $zip->getFromName('xl/sharedStrings.xml');
    if ($ssXml) {
        preg_match_all('/<si>(.*?)<\/si>/s', $ssXml, $m);
        foreach ($m[1] as $si) {
            preg_match_all('/<t[^>]*>(.*?)<\/t>/s', $si, $tm);
            $strings[] = html_entity_decode(implode('', $tm[1]), ENT_QUOTES | ENT_XML1, 'UTF-8');
        }
    }

    // Sheet names
    $sheets = [];
    $wbXml = $zip->getFromName('xl/workbook.xml');
    if ($wbXml) {
        preg_match_all('/<sheet\b[^>]+name="([^"]+)"/i', $wbXml, $m);
        $sheets = $m[1];
    }

    // First 6 rows of sheet1 (header + 5 samples)
    $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
    $zip->close();
    if (!$sheetXml) return ['error' => 'No sheet1.xml'];

    $rows = [];
    preg_match_all('/<row\b[^>]*>(.*?)<\/row>/s', $sheetXml, $rowMatches);
    foreach (array_slice($rowMatches[1], 0, 6) as $rowXml) {
        $rowData = [];
        preg_match_all('/<c\b([^>]*)>(.*?)<\/c>/s', $rowXml, $cells, PREG_SET_ORDER);
        foreach ($cells as $cell) {
            $type = preg_match('/\bt="([^"]+)"/', $cell[1], $tm) ? $tm[1] : '';
            preg_match('/<v[^>]*>(.*?)<\/v>/s', $cell[2], $vm);
            $v = $vm[1] ?? '';
            if ($type === 's') {
                $rowData[] = $strings[(int)$v] ?? '';
            } elseif ($type === 'inlineStr') {
                preg_match('/<t[^>]*>(.*?)<\/t>/s', $cell[2], $it);
                $rowData[] = $it[1] ?? '';
            } else {
                $rowData[] = $v;
            }
        }
        $rows[] = $rowData;
    }

    return [
        'file'    => basename($path),
        'sheets'  => $sheets,
        'headers' => $rows[0] ?? [],
        'sample'  => array_slice($rows, 1),
    ];
}

// Show only xlsx files in the folder (compact list)
$dir = 'C:/Users/merch/OneDrive/Edge Browser/';
$xlsx = array_values(array_filter(scandir($dir) ?: [], fn($f) => str_ends_with(strtolower($f), '.xlsx')));

$result = [
    'xlsx_in_folder' => $xlsx,
    'mprint'  => readXlsx($dir . 'mprinthouse_products.xlsx'),
    'diamond' => readXlsx($dir . 'diamond_printingpress_products.xlsx'),
];

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
