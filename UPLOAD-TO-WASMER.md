# Upload to Your Wasmer App
**Your App:** https://efficient-advertising.wasmer.app/
**Wasmer Account:** https://wasmer.io/ebrahim-merchant

---

## 📦 Files Ready on Your Desktop

1. ✅ `efficient-advertising-backup-20260210-191805.sql` (18MB) - Database
2. ✅ `efficient-modern-theme.tar.gz` (277KB) - Your custom theme  
3. ✅ `wp-uploads.tar.gz` (107MB) - All media files

---

## 🚀 Quick Upload Guide

### Step 1: Access Your Wasmer App via SSH

```bash
# Load Wasmer CLI
source ~/.wasmer/wasmer.sh

# Login to Wasmer
wasmer login

# SSH into your app
wasmer ssh efficient-advertising
```

### Step 2: Upload Your Custom Theme

**Option A: Via SFTP (Recommended)**

1. Get your SFTP credentials from: https://wasmer.io/apps/ebrahim-merchant/efficient-advertising
2. Use any SFTP client (FileZilla, Cyberduck, etc.) or command line:

```bash
# Extract the theme locally first
cd ~/Desktop
tar -xzf efficient-modern-theme.tar.gz

# Upload via SFTP (you'll need credentials from Wasmer dashboard)
sftp ebrahim-merchant@ssh.wasmer.io
# Then navigate to: /wp-content/themes/
# Upload the efficient-modern folder
```

**Option B: Via WordPress Admin (Easier)**

1. Login to: https://efficient-advertising.wasmer.app/wp-admin
2. Go to: Appearance → Themes → Add New → Upload Theme
3. First, convert your theme to a .zip file:
   ```bash
   cd ~/Desktop
   tar -xzf efficient-modern-theme.tar.gz
   cd wp-content/themes
   zip -r efficient-modern.zip efficient-modern
   ```
4. Upload `efficient-modern.zip` via WordPress admin
5. Click "Activate"

### Step 3: Upload Media Files

```bash
# Extract uploads locally
cd ~/Desktop
tar -xzf wp-uploads.tar.gz

# Upload via SFTP to: /wp-content/uploads/
# Or use WP-CLI if you have access via SSH
```

### Step 4: Import Your Database

**Option A: Via Wasmer Dashboard**

1. Go to your app's database section in Wasmer dashboard
2. Access phpMyAdmin or database management tool
3. Import: `efficient-advertising-backup-20260210-191805.sql`

**Option B: Via SSH with WP-CLI**

```bash
# SSH into your app
wasmer ssh efficient-advertising

# Upload database file first, then:
wp db import /path/to/efficient-advertising-backup-20260210-191805.sql

# Update URLs from local to production
wp search-replace 'http://efficientadvt.local' 'https://efficient-advertising.wasmer.app' --all-tables --dry-run

# If it looks good, run without --dry-run:
wp search-replace 'http://efficientadvt.local' 'https://efficient-advertising.wasmer.app' --all-tables
```

**Option C: Manual SQL Queries**

After importing the database, run these SQL queries to update URLs:

```sql
UPDATE wp_options 
SET option_value = REPLACE(option_value, 'http://efficientadvt.local', 'https://efficient-advertising.wasmer.app');

UPDATE wp_posts 
SET post_content = REPLACE(post_content, 'http://efficientadvt.local', 'https://efficient-advertising.wasmer.app');

UPDATE wp_posts 
SET guid = REPLACE(guid, 'http://efficientadvt.local', 'https://efficient-advertising.wasmer.app');

UPDATE wp_postmeta 
SET meta_value = REPLACE(meta_value, 'http://efficientadvt.local', 'https://efficient-advertising.wasmer.app');
```

### Step 5: Upload Logo Files

Make sure your new logos are in the theme:
- `wp-content/themes/efficient-modern/assets/images/logo-header.png`
- `wp-content/themes/efficient-modern/assets/images/logo-footer.png`

If they're not already in the theme backup, upload them separately via SFTP or WordPress Media Library.

---

## ✅ Post-Upload Checklist

After uploading everything:

1. **Login to WordPress Admin:**
   - https://efficient-advertising.wasmer.app/wp-admin

2. **Activate Your Theme:**
   - Go to Appearance → Themes
   - Activate "Efficient Modern"

3. **Fix Permalinks:**
   - Go to Settings → Permalinks
   - Click "Save Changes" (don't change anything, just save)

4. **Test Your Pages:**
   - [ ] Home: https://efficient-advertising.wasmer.app/
   - [ ] About Us: https://efficient-advertising.wasmer.app/about-us/
   - [ ] Contact Us: https://efficient-advertising.wasmer.app/contact-us/
   - [ ] Products: https://efficient-advertising.wasmer.app/products/

5. **Verify Custom Features:**
   - [ ] Header logo displays (logo-header.png)
   - [ ] Footer logo displays (logo-footer.png)
   - [ ] Quote modal works from navbar
   - [ ] Product pre-fill works from product pages
   - [ ] Contact form works
   - [ ] All images load correctly
   - [ ] Mobile responsive design works

---

## 🔧 Useful Wasmer Commands

```bash
# View your app info
wasmer app info efficient-advertising

# View app logs
wasmer app logs efficient-advertising

# SSH into app
wasmer ssh efficient-advertising

# List your apps
wasmer app list

# View app in browser
open https://efficient-advertising.wasmer.app
```

---

## 🆘 Troubleshooting

### Theme Not Showing?
- Verify theme uploaded to: `/wp-content/themes/efficient-modern/`
- Check all theme files are present
- Activate theme in WordPress admin

### Database Import Failed?
- Check database size limits in Wasmer dashboard
- Try importing in smaller chunks if needed
- Verify SQL file is valid

### URLs Still Showing Local?
- Run the search-replace command again
- Clear WordPress cache
- Check .htaccess file

### Images Not Loading?
- Verify uploads folder is present: `/wp-content/uploads/`
- Check file permissions
- Ensure URLs updated in database

---

## 📞 Support

**Wasmer Support:**
- Dashboard: https://wasmer.io/apps/ebrahim-merchant/efficient-advertising
- Discord: https://discord.gg/qBTfsNP7N8
- Docs: https://docs.wasmer.io

---

## 🎯 Quick Start (Step by Step)

1. Login to Wasmer CLI:
   ```bash
   source ~/.wasmer/wasmer.sh
   wasmer login
   ```

2. Create .zip of your theme for easier upload:
   ```bash
   cd ~/Desktop
   tar -xzf efficient-modern-theme.tar.gz
   cd wp-content/themes
   zip -r ~/Desktop/efficient-modern.zip efficient-modern
   ```

3. Login to WordPress:
   - Open: https://efficient-advertising.wasmer.app/wp-admin

4. Upload theme:
   - Appearance → Themes → Add New → Upload Theme
   - Choose: `~/Desktop/efficient-modern.zip`
   - Click "Activate"

5. Import database (use Wasmer's database tools or phpMyAdmin)

6. Update URLs using SQL queries above

7. Test your site!

---

**Your site is at:** https://efficient-advertising.wasmer.app/

Good luck! 🚀
