$ErrorActionPreference = 'Stop'

$imgRoot = 'G:\My Drive\Website Images'
if (-not (Test-Path $imgRoot)) {
    Write-Output "ERROR|Image root not found|$imgRoot"
    exit 1
}

$files = Get-ChildItem -Path $imgRoot -Recurse -File -Include *.webp,*.jpg,*.jpeg,*.png
Write-Output ("TOTAL_IMAGES|{0}" -f $files.Count)

$matched = $files | Where-Object { $_.BaseName -match '^([A-Za-z]{2,3})-(\d+)$' }
Write-Output ("MATCHED_SKU_STYLE|{0}" -f $matched.Count)

$prefixes = $matched |
    ForEach-Object {
        if ($_.BaseName -match '^([A-Za-z]{2,3})-(\d+)$') {
            $matches[1].ToUpper()
        }
    } |
    Group-Object |
    Sort-Object Name

foreach ($prefix in $prefixes) {
    Write-Output ("PREFIX|{0}|COUNT={1}" -f $prefix.Name, $prefix.Count)
}

$unmatched = $files |
    Where-Object { $_.BaseName -notmatch '^([A-Za-z]{2,3})-(\d+)$' } |
    Select-Object -First 50 -ExpandProperty Name

foreach ($name in $unmatched) {
    Write-Output ("UNMATCHED|{0}" -f $name)
}
