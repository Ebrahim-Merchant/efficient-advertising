# WordPress Deployment Guide for Wasmer.io
**Date:** February 10, 2026
**Your Wasmer Account:** https://wasmer.io/ebrahim-merchant

## 📦 What You Have Ready
- ✅ Database backup: `efficient-advertising-backup-20260210-191805.sql` (18MB) on Desktop
- ✅ Custom theme backup: `efficient-modern-theme.tar.gz` (277KB) on Desktop  
- ✅ Uploads backup: `wp-uploads.tar.gz` (107MB) on Desktop
- ✅ Current local URL: `http://efficientadvt.local`
- ✅ Updated homepage with "About Us" link

---

## 🚀 Deploying to Wasmer.io

### Method 1: Use Wasmer's WordPress Template (Easiest)

1. **Go to Wasmer and create a WordPress app:**
   - Visit: https://wasmer.io/apps/create?template=wordpress-starter
   - Or click "Deploy for free" on https://wasmer.io/wordpress-hosting
   
2. **Your app will be created at:**
   - URL format: `https://your-app-name-ebrahim-merchant.wasmer.app`

3. **After deployment, you'll need to:**
   - Upload your theme via SFTP or WordPress admin
   - Import your database
   - Upload your media files

### Method 2: Deploy Using Wasmer CLI (More Control)

#### Step 1: Install Wasmer CLI

```bash
curl https://get.wasmer.io -sSfL | sh
```

Then restart your terminal or run:
```bash
source ~/.wasmer/wasmer.sh
```

#### Step 2: Login to Wasmer

```bash
wasmer login
```

This will open a browser for authentication to your account: ebrahim-merchant

#### Step 3: Deploy WordPress

```bash
cd "/Users/ebrahimmerchant/Local Sites/efficient-advertising/app/public"
wasmer deploy --template=wordpress-starter
```

You'll be prompted for:
- **App owner:** ebrahim-merchant (your username)
- **App name:** efficient-advertising (or your preferred name)
- **Deploy now?:** yes

#### Step 4: Access Your WordPress

Your site will be available at:
- `https://efficient-advertising-ebrahim-merchant.wasmer.app`

---

## 📤 Uploading Your Custom Theme & Content

### Option A: Via SFTP (Recommended)

Wasmer provides SFTP access to your app files.

1. **Get SFTP credentials from Wasmer dashboard**
2. **Connect using any SFTP client:**
   ```bash
   sftp ebrahim-merchant@ssh.wasmer.io
   ```

3. **Upload your theme:**
   ```bash
   cd wp-content/themes/
   put -r /path/to/efficient-modern
   ```

### Option B: Via WordPress Admin

1. **Login to WordPress admin:**
   - `https://your-app.wasmer.app/wp-admin`

2. **Upload theme:**
   - Go to Appearance → Themes → Add New → Upload Theme
   - Upload `efficient-modern-theme.tar.gz` (might need to convert to .zip)

3. **Activate the theme:**
   - Click "Activate" on efficient-modern

---

## 🗄️ Importing Your Database

### Option 1: Using WP-CLI on Wasmer

```bash
# SSH into your Wasmer app
wasmer ssh your-app-name

# Import database
wp db import /path/to/efficient-advertising-backup-20260210-191805.sql

# Update URLs
wp search-replace 'http://efficientadvt.local' 'https://your-app.wasmer.app' --all-tables
```

### Option 2: Using phpMyAdmin

1. Access phpMyAdmin from Wasmer dashboard
2. Select your database
3. Go to Import tab
4. Upload `efficient-advertising-backup-20260210-191805.sql`
5. Click "Go"

After import, run these SQL queries to update URLs:

```sql
UPDATE wp_options SET option_value = REPLACE(option_value, 'http://efficientadvt.local', 'https://your-app.wasmer.app');
UPDATE wp_posts SET post_content = REPLACE(post_content, 'http://efficientadvt.local', 'https://your-app.wasmer.app');
UPDATE wp_posts SET guid = REPLACE(guid, 'http://efficientadvt.local', 'https://your-app.wasmer.app');
UPDATE wp_postmeta SET meta_value = REPLACE(meta_value, 'http://efficientadvt.local', 'https://your-app.wasmer.app');
```

---

## �️ Uploading Logo Files

After deploying, make sure to upload your new logos:

1. **Via SFTP:**
   ```bash
   cd wp-content/themes/efficient-modern/assets/images/
   put logo-header.png
   put logo-footer.png
   ```

2. **Or manually via File Manager** in Wasmer dashboard

The theme is already configured to use:
- `logo-header.png` - Full logo with text for header
- `logo-footer.png` - Transparent logo for footer

---

## ✅ Post-Deployment Checklist

After deploying to Wasmer:

- [ ] Login to WordPress admin
- [ ] Activate `efficient-modern` theme
- [ ] Go to Settings → Permalinks → Save (to refresh .htaccess)
- [ ] Test all pages:
  - [ ] Home page (`/`)
  - [ ] About Us (`/about-us`) - should use custom template
  - [ ] Contact Us (`/contact-us`) - should use custom template
  - [ ] Product pages
- [ ] Verify logos appear in header and footer
- [ ] Test quote request modal from navbar
- [ ] Test product pre-fill functionality
- [ ] Test contact form submission
- [ ] Check all images load correctly
- [ ] Test mobile responsiveness

---

## 🔧 Wasmer-Specific Features

### InstaBoot (Faster Loading)
Wasmer's InstaBoot feature can make your WordPress site load 80% faster. It's automatically enabled for WordPress apps.

### Auto-Scaling
Your site automatically scales with traffic - no need to worry about traffic spikes!

### Edge Deployment
Your site is deployed on Wasmer's global edge network for fast loading worldwide.

---

## � Important Site Information

**Current Local Development:**
- URL: http://efficientadvt.local
- WordPress: 6.9.1
- PHP: 8.2.27 (Wasmer supports latest PHP)
- MySQL: 8.0.35
- Theme: efficient-modern

**Important Pages & IDs:**
- Home: ID 22
- About Us: ID 779 (uses `page-about.php` template)
- Contact Us: ID 20 (uses `page-contact.php` template)  
- Thank You: ID 453
- Payment: ID 379
- Privacy Policy: ID 909

**Custom Features to Verify:**
- ✨ Quote modal in navbar with comprehensive form
- ✨ Product pre-fill using sessionStorage
- ✨ Premium About Us page design
- ✨ Premium Contact Us page design
- ✨ Delivery address toggle in forms
- ✨ File upload in quote forms
- ✨ Header logo (logo-header.png)
- ✨ Footer logo (logo-footer.png)

---

## 🆘 Getting Help

### Wasmer Support
- **Discord:** https://discord.gg/qBTfsNP7N8
- **Twitter:** @wasmerio
- **Docs:** https://docs.wasmer.io

### Your Wasmer Dashboard
- https://wasmer.io/ebrahim-merchant

### Common Issues

**Site not loading?**
- Check if app is running in Wasmer dashboard
- Verify database connection in `wp-config.php`

**Permalinks broken?**
- Go to Settings → Permalinks → Save Changes

**Images not showing?**
- Ensure URLs are updated in database
- Check file permissions

**Theme not activating?**
- Verify all theme files uploaded correctly
- Check PHP error logs in Wasmer dashboard

---

## 🎯 Quick Start Commands

```bash
# Install Wasmer CLI
curl https://get.wasmer.io -sSfL | sh

# Login
wasmer login

# Deploy from your WordPress directory
cd "/Users/ebrahimmerchant/Local Sites/efficient-advertising/app/public"
wasmer deploy --template=wordpress-starter

# Or create new WordPress app
wasmer deploy --template=wordpress-starter --app efficient-advertising

# SSH into your app
wasmer ssh efficient-advertising

# View logs
wasmer app logs efficient-advertising
```

---

## 💡 Alternative: Traditional Hosting

If you prefer traditional hosting instead of Wasmer, you already have all the files ready:
- `efficient-advertising-backup-20260210-191805.sql` - Database
- `efficient-modern-theme.tar.gz` - Theme
- `wp-uploads.tar.gz` - Media files

Simply upload via FTP/cPanel to any standard WordPress host.

---

Good luck with your deployment on Wasmer.io! 🚀

**Next Steps:**
1. Visit https://wasmer.io/apps/create?template=wordpress-starter
2. Or run `wasmer deploy` from your WordPress directory
3. Follow the checklist above after deployment
