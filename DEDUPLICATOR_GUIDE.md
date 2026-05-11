# 🪄 Media Deduplicator Guide

This tool is a specialized utility for **EfficientAdvt** to maintain a clean WordPress Media Library.

### 📍 Location
File: `media-clean.php` (in the root of your WordPress installation).
URL: `http://efficientadvt.local/media-clean.php`

### 🛠 How it Works
1.  **Bit-Level Analysis**: Instead of just looking at filenames, it calculates a digital fingerprint (MD5) of every image file.
2.  **Duplicate Detection**: It groups images that are identical at the pixel level.
3.  **Smart Selection**: 
    - **Master Copy**: The first image found is kept as the "Master."
    - **Duplicates**: All other copies are marked for deletion.
4.  **Batch Actions**: Includes a "Select Every Duplicate" button and a "Execute All Selected" button to clean hundreds of files in one go.

### ⚠️ Best Practices
- **Backup**: Always a good idea to have a backup of your `wp-content/uploads` folder before doing major library cleanups.
- **Verification**: Use the visual thumbnails and file metadata (size, dimensions) provided in the dashboard to confirm images before deleting.
- **Submit Together**: This tool is designed to collect all your decisions across multiple pages and submit them in one batch.

---
*Created March 20, 2026*
