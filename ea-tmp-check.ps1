$rows = Import-Csv "C:\Users\pc\Local Sites\newefficientadvertising09042026\app\public\website-cleanup-dump\logs\draft-product-analysis.csv"
$bad = $rows | Where-Object { $_.safe_to_delete -eq "no" }
$bad | Select-Object -First 10 product_id,sku,product_name,notes | Format-Table -AutoSize -Wrap
