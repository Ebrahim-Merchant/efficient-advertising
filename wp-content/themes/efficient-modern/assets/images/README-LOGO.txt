LOGO UPDATE INSTRUCTIONS:
=========================

Please save your logo images with these exact names:

1. For Header (full logo with text):
   - Save as: logo-header.png
   - Location: /wp-content/themes/efficient-modern/assets/images/

2. For Footer (transparent logo):
   - Save as: logo-footer.png
   - Location: /wp-content/themes/efficient-modern/assets/images/

Then the code will automatically use them!

Or you can use these WP-CLI commands to upload:
wp media import path/to/your/header-logo.png --post_id=0 --title="Header Logo"
wp media import path/to/your/footer-logo.png --post_id=0 --title="Footer Logo"
