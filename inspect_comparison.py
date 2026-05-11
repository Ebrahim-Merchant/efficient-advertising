import sys, io
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8', errors='replace')

sys.path.insert(0, r'C:\Users\pc\.python-openpyxl')
import openpyxl
from pathlib import Path

FILE_PATH = Path(r'C:\Users\pc\Downloads\product-name-comparison-review.xlsx')

if not FILE_PATH.exists():
    print(f"File not found: {FILE_PATH}")
    sys.exit(1)

wb = openpyxl.load_workbook(FILE_PATH, read_only=True, data_only=True)
ws = wb.active

print(f"File: {FILE_PATH.name}")
for i, row in enumerate(ws.iter_rows(min_row=1, max_row=5, values_only=True)):
    print(f"Row {i+1}:")
    print(row)
    print("-" * 50)
