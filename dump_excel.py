import sys, io
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8', errors='replace')
import openpyxl

EXCEL_PATH = r'C:\Users\pc\Local Sites\newefficientadvertising09042026\app\public\competitor_research\eprint_ae_product_catalogue_v8.xlsx'

wb = openpyxl.load_workbook(EXCEL_PATH, read_only=True)
ws = wb.active

for i, row in enumerate(ws.iter_rows(min_row=1, max_row=4, values_only=True)):
    print(f"Row {i+1}:")
    print(row)
    print("-" * 50)
