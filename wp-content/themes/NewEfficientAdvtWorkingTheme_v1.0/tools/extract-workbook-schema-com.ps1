$ErrorActionPreference = 'Stop'

$xlsx = 'C:\Users\merch\OneDrive\Downloads\Edge Browser Downloads New\eprint_ae_product_catalogue_v8.xlsx'
if (-not (Test-Path $xlsx)) {
    Write-Output "ERROR|Workbook not found|$xlsx"
    exit 1
}

$excel = $null
$wb = $null

try {
    $excel = New-Object -ComObject Excel.Application
    $excel.Visible = $false
    $excel.DisplayAlerts = $false

    # Open read-only to avoid lock conflicts.
    $wb = $excel.Workbooks.Open($xlsx, 0, $true)

    foreach ($ws in $wb.Worksheets) {
        $used = $ws.UsedRange
        $rowCount = [int]$used.Rows.Count
        $colCount = [int]$used.Columns.Count

        $headers = @()
        $maxCols = [Math]::Min($colCount, 30)
        for ($c = 1; $c -le $maxCols; $c++) {
            $v = [string]$ws.Cells.Item(1, $c).Text
            if ([string]::IsNullOrWhiteSpace($v)) {
                $headers += "(blank$c)"
            }
            else {
                $headers += ($v -replace '\s+', ' ').Trim()
            }
        }

        Write-Output ("SHEET|{0}|ROWS={1}|COLS={2}|HEADERS={3}" -f $ws.Name, $rowCount, $colCount, ($headers -join ' || '))
    }
}
catch {
    Write-Output ("ERROR|{0}" -f $_.Exception.Message)
    exit 1
}
finally {
    if ($wb -ne $null) {
        $wb.Close($false)
        [void][System.Runtime.InteropServices.Marshal]::ReleaseComObject($wb)
    }
    if ($excel -ne $null) {
        $excel.Quit()
        [void][System.Runtime.InteropServices.Marshal]::ReleaseComObject($excel)
    }
    [GC]::Collect()
    [GC]::WaitForPendingFinalizers()
}
