$ErrorActionPreference = 'Stop'

$xlsx = 'C:\Users\merch\OneDrive\Downloads\Edge Browser Downloads New\eprint_ae_product_catalogue_v8.xlsx'
if (-not (Test-Path $xlsx)) {
    Write-Output "ERROR|Workbook not found|$xlsx"
    exit 1
}

Add-Type -AssemblyName System.IO.Compression.FileSystem
$zip = [System.IO.Compression.ZipFile]::OpenRead($xlsx)

try {
    $readEntry = {
        param($entryName)
        $entry = $zip.Entries | Where-Object { $_.FullName -eq $entryName }
        if (-not $entry) { return $null }
        $sr = New-Object IO.StreamReader($entry.Open())
        $txt = $sr.ReadToEnd()
        $sr.Close()
        return $txt
    }

    $wbXml = & $readEntry 'xl/workbook.xml'
    if (-not $wbXml) {
        Write-Output 'ERROR|Missing xl/workbook.xml'
        exit 1
    }

    $relsXml = & $readEntry 'xl/_rels/workbook.xml.rels'
    if (-not $relsXml) {
        Write-Output 'ERROR|Missing xl/_rels/workbook.xml.rels'
        exit 1
    }

    $sharedStrings = @()
    $ssXml = & $readEntry 'xl/sharedStrings.xml'
    if ($ssXml) {
        $siMatches = [regex]::Matches($ssXml, '<si>(.*?)</si>', 'Singleline')
        foreach ($si in $siMatches) {
            $parts = [regex]::Matches($si.Groups[1].Value, '<t[^>]*>(.*?)</t>', 'Singleline') | ForEach-Object { $_.Groups[1].Value }
            $sharedStrings += ($parts -join '')
        }
    }

    $sheetMatches = [regex]::Matches($wbXml, '<sheet[^>]*name="([^"]+)"[^>]*r:id="([^"]+)"', 'IgnoreCase')
    $relMatches = [regex]::Matches($relsXml, '<Relationship[^>]*Id="([^"]+)"[^>]*Target="([^"]+)"', 'IgnoreCase')

    $relMap = @{}
    foreach ($rel in $relMatches) {
        $relMap[$rel.Groups[1].Value] = $rel.Groups[2].Value
    }

    foreach ($sheet in $sheetMatches) {
        $sheetName = $sheet.Groups[1].Value
        $rid = $sheet.Groups[2].Value

        if (-not $relMap.ContainsKey($rid)) {
            Write-Output "SHEET|$sheetName|ERROR|Missing relationship"
            continue
        }

        $target = $relMap[$rid].TrimStart('/')
        if (-not $target.StartsWith('xl/')) {
            $target = "xl/$target"
        }

        $sheetXml = & $readEntry $target
        if (-not $sheetXml) {
            Write-Output "SHEET|$sheetName|ERROR|Missing worksheet xml"
            continue
        }

        $usedRows = [regex]::Matches($sheetXml, '<row\b', 'IgnoreCase').Count
        $row1 = [regex]::Match($sheetXml, '<row[^>]*r="1"[^>]*>(.*?)</row>', 'Singleline')

        if (-not $row1.Success) {
            Write-Output "SHEET|$sheetName|ROWS=$usedRows|HEADERS=NONE"
            continue
        }

        $cells = [regex]::Matches($row1.Groups[1].Value, '<c[^>]*?(?:t="([^"]+)")?[^>]*>(.*?)</c>', 'Singleline')
        $headers = @()

        foreach ($cell in $cells) {
            $type = $cell.Groups[1].Value
            $body = $cell.Groups[2].Value
            $value = ''

            if ($type -eq 's') {
                $vMatch = [regex]::Match($body, '<v[^>]*>(.*?)</v>', 'Singleline')
                if ($vMatch.Success -and $vMatch.Groups[1].Value -match '^\d+$') {
                    $idx = [int]$vMatch.Groups[1].Value
                    if ($idx -lt $sharedStrings.Count) {
                        $value = $sharedStrings[$idx]
                    }
                }
            } elseif ($type -eq 'inlineStr') {
                $tMatch = [regex]::Match($body, '<t[^>]*>(.*?)</t>', 'Singleline')
                if ($tMatch.Success) { $value = $tMatch.Groups[1].Value }
            } else {
                $vMatch = [regex]::Match($body, '<v[^>]*>(.*?)</v>', 'Singleline')
                if ($vMatch.Success) { $value = $vMatch.Groups[1].Value }
            }

            $headers += ($value -replace '\s+', ' ').Trim()
        }

        Write-Output ("SHEET|{0}|ROWS={1}|HEADERS={2}" -f $sheetName, $usedRows, ($headers -join ' || '))
    }
}
finally {
    $zip.Dispose()
}
