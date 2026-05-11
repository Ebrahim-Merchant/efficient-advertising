import csv, json

CSV_PATH = r'C:\Users\pc\Local Sites\newefficientadvertising09042026\app\public\website-cleanup-dump\logs\excel-variant-merge-audit.csv'

# Groups already done: group_id 2
already_done = {2}

selected = []
with open(CSV_PATH, newline='', encoding='utf-8') as f:
    reader = csv.DictReader(f)
    for row in reader:
        gid   = int(row['group_id'])
        issue = row['issues'].strip()
        orig  = row['original_sku'].strip()
        if issue:
            continue        # skip any group with issues
        if gid in already_done:
            continue        # skip already-done
        selected.append({
            'group_id':     gid,
            'original_sku': orig,
            'original_name': row['original_product_name'].strip(),
            'variant_skus':  [s.strip() for s in row['variant_skus'].split('|') if s.strip()],
            'variant_values':[v.strip() for v in row['variant_values'].split('|') if v.strip()],
            'product_head':  row['product_head'].strip(),
        })
        if len(selected) == 30:
            break

print(f'Total selected: {len(selected)}')
for g in selected:
    print(f"  GID {g['group_id']:2d}  {g['original_sku']:10s}  dups={len(g['variant_skus']):2d}  {g['product_head']}")

# Emit PHP array literal
print('\n\n// PHP DATA:')
print('$groups = [')
for g in selected:
    orig_val = g['original_name'].replace("'", "\\'")
    head_val = g['product_head'].replace("'", "\\'")
    sku_val  = g['original_sku'].replace("'", "\\'")
    pairs = []
    for sku, val in zip(g['variant_skus'], g['variant_values']):
        s = sku.replace("'", "\\'")
        v = val.replace("'", "\\'")
        pairs.append(f"        ['{s}', '{v}']")
    pairs_str = ',\n'.join(pairs)
    print(f"    [{g['group_id']}, '{sku_val}', '{orig_val}', '{head_val}', [\n{pairs_str}\n    ]],")
print('];')
