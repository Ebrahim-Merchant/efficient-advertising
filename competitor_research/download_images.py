import pandas as pd
import os
import requests
from PIL import Image
from io import BytesIO
import time
import subprocess
import sys

# Ensure requirements are installed
def install_requirements():
    try:
        import duckduckgo_search
        from PIL import Image
        import openpyxl
    except ImportError:
        print("Installing required packages...")
        subprocess.check_call([sys.executable, "-m", "pip", "install", "duckduckgo-search", "pillow", "openpyxl"])

install_requirements()
from duckduckgo_search import DDGS

# Paths
excel_path = 'C:/Users/merch/Local Sites/EfficientAdvt.Com/app/public/competitor_research/eprint_ae_product_catalogue_v8.xlsx'
output_dir = 'C:/Users/merch/Local Sites/EfficientAdvt.Com/app/public/competitor_research/product_images_webp'

# Create output directory
os.makedirs(output_dir, exist_ok=True)

print("Loading Excel file...")
df = pd.read_excel(excel_path)

ddgs = DDGS()

print("Starting image download process for the first 10 products as a test batch...")
print("-" * 50)

count = 0
# We will just do the first 10 rows first to ensure it works without taking hours
for index, row in df.head(10).iterrows():
    sku = str(row['SKU']).strip()
    product_name = str(row['Individual Product']).strip()
    
    # Create an accurate search query based on the product
    search_term = f"{product_name} printing product isolated"
    print(f"Processing [{sku}]: {product_name}")
    
    try:
        # Search for an image
        results = list(ddgs.images(search_term, max_results=3)) 
        
        success = False
        for result in results:
            if success: break
                
            img_url = result['image']
            try:
                # Attempt to download
                response = requests.get(img_url, timeout=10, headers={'User-Agent': 'Mozilla/5.0'})
                if response.status_code == 200:
                    # Open image
                    img = Image.open(BytesIO(response.content))
                    
                    # Convert to RGB to avoid alpha channel issues with webp
                    if img.mode in ("RGBA", "P"):
                        img = img.convert("RGB")
                    
                    # Calculate new size to keep it high-res but low file size (e.g. max width 1000px)
                    max_size = (1000, 1000)
                    img.thumbnail(max_size, Image.Resampling.LANCZOS)
                        
                    # Save as optimized WEBP
                    output_path = os.path.join(output_dir, f"{sku}.webp")
                    img.save(output_path, "webp", quality=80, optimize=True)
                    print(f" -> SUCCESS: Saved as {sku}.webp")
                    success = True
                    count += 1
            except Exception as inner_e:
                print(f" -> Skip URL ({img_url[-20:]}): {inner_e}")
                
        if not success:
            print(" -> FAILED to find a working image.")
            
    except Exception as e:
        print(f" -> Error during search: {e}")
        
    # Sleep to prevent search engine rate limiting
    time.sleep(2)

print("-" * 50)
print(f"Test batch complete. Successfully downloaded {count} high-res, optimized WebP images.")
