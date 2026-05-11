import pandas as pd
import os
import shutil
from PIL import Image

# Paths
local_img_dir = r'F:\Efficient Work Images from Ali 06 March 2026'
classification_csv = os.path.join(local_img_dir, 'Efficient_Advertising_Image_Classification.csv')
excel_path = r'c:\Users\merch\Local Sites\EfficientAdvt.Com\app\public\competitor_research\eprint_ae_product_catalogue_v8.xlsx'
output_dir = r'c:\Users\merch\Local Sites\EfficientAdvt.Com\app\public\wp-content\uploads\ali_product_images'

# Create output directory
os.makedirs(output_dir, exist_ok=True)

print("Loading data...")
# Load classification
class_df = pd.read_csv(classification_csv)
# Load product catalog
prod_df = pd.read_excel(excel_path)

# Dictionary to store images per sub-category
# Key: Sub-Category name, Value: List of filenames
cat_to_images = {}

print("Mapping local images to categories...")
for _, row in class_df.iterrows():
    orig_file = str(row['Original Filename']).strip()
    category = str(row['Category']).strip()
    
    # We'll use the 'Category' from the CSV to find matches in WooCommerce
    # Note: These names might not match exactly, so we'll need a mapping or fuzzy matching
    if category not in cat_to_images:
        cat_to_images[category] = []
    cat_to_images[category].append(orig_file)

# Mapping between Ali's categories and WooCommerce Sub-Categories
# Based on the unique values found earlier
MAPPING = {
    "Signage / Lightbox": ["3D & Illuminated Signage", "Light Box Signage", "LED & Digital Signage", "Rigid Board Signage"],
    "Business Card": ["Business Cards"],
    "Exhibition Stand": ["Exhibition Stands & Booths", "Trade Shows & Events"],
    "Roll-up Banner": ["Pull-Up & Roll-Up Banners"],
    "Hoarding / Billboard": ["Vinyl Banners & Hoardings"],
    "Vehicle Branding": ["Car & Van Branding", "Fleet Branding"],
    "Sticker / Vinyl": ["Stickers", "Sticker Printing", "Vinyl Banners & Hoardings"],
    "Pole Flag": ["Feather & Sail Flags", "Tear Drop & Blade Flags"]
}

# Reverse mapping: WooCommerce Sub-Category -> List of Images
woo_subcat_to_images = {}

for ali_cat, images in cat_to_images.items():
    if ali_cat in MAPPING:
        for woo_subcat in MAPPING[ali_cat]:
            if woo_subcat not in woo_subcat_to_images:
                woo_subcat_to_images[woo_subcat] = []
            woo_subcat_to_images[woo_subcat].extend(images)

print(f"Total mapped WooCommerce sub-categories: {len(woo_subcat_to_images)}")

# Now process and copy images
# We will rename them to something like 'subcat_name_index.webp'
count = 0
mapping_log = []

for subcat, images in woo_subcat_to_images.items():
    print(f"Processing {len(images)} images for: {subcat}")
    for i, img_name in enumerate(images):
        src_path = os.path.join(local_img_dir, img_name)
        if not os.path.exists(src_path):
            continue
            
        try:
            # Open and optimize
            img = Image.open(src_path)
            if img.mode in ("RGBA", "P"):
                img = img.convert("RGB")
            
            # Safe filename
            safe_subcat = subcat.replace(" ", "_").replace("&", "and").lower()
            new_filename = f"{safe_subcat}_{i}.webp"
            dst_path = os.path.join(output_dir, new_filename)
            
            # Resize if too large (max 1200px)
            if max(img.size) > 1200:
                img.thumbnail((1200, 1200), Image.Resampling.LANCZOS)
                
            img.save(dst_path, "webp", quality=85, optimize=True)
            mapping_log.append({
                "woo_subcat": subcat,
                "assigned_file": new_filename
            })
            count += 1
        except Exception as e:
            print(f"Error processing {img_name}: {e}")

# Save the final mapping for the PHP script to use
mapping_df = pd.DataFrame(mapping_log)
mapping_df.to_csv(os.path.join(output_dir, 'ali_image_mapping.csv'), index=False)

print("-" * 50)
print(f"Done! {count} images processed and saved to {output_dir}")
print(f"Mapping saved to {os.path.join(output_dir, 'ali_image_mapping.csv')}")
