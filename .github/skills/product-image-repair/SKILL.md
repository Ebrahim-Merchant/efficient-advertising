---
name: product-image-repair
description: Repair WooCommerce product imagery by using DB-derived attachment paths and generated size variants.
---

# Product image repair

Use this skill when WooCommerce products load but thumbnails, galleries, or catalogue images are missing.

## Do this

1. Derive image paths from `_thumbnail_id`, `_product_image_gallery`, `_wp_attached_file`, and `_wp_attachment_metadata`.
2. Compare those paths against the live uploads volume.
3. Restore the missing originals and expected size variants.
4. Re-run the missing-path audit until it reaches zero or clearly explain the remainder.

## Repo-specific note

This repo needed both original files and generated variant files to fully restore product imagery.
