# 🔐 BACKUP & VERSION CONTROL MANIFEST
**Created:** 2026-04-14 14:50 UTC  
**Project:** Efficient Advertising Website Refinement v1.0  
**Status:** BACKUP READY - DO NOT MODIFY WITHOUT APPROVAL

---

## 📦 BACKUP STRATEGY

### Master Backup Location
```
c:\Users\merch\Local Sites\newefficientadvertising09042026\backups\MASTER_BACKUP_2026-04-14_SESSION
```

### What Will Be Backed Up (Pre-Approval)
✅ **Database**
- Full MySQL database export (`local` database)
- File: `database_local_2026-04-14_HHmmss.sql`
- Size: ~27+ MB
- Frequency: Before each major change

✅ **Theme Files**
- Active theme: `NewEfficientAdvtWorkingTheme_v1.0`
- Location: `wp-content/themes/NewEfficientAdvtWorkingTheme_v1.0/`
- All PHP, CSS, JS, images, fonts

✅ **WordPress Configuration**
- `wp-config.php`
- `wp-content/mu-plugins/`
- `.htaccess` and `.htaccess.bk`

✅ **Critical Custom Files**
- `single-product-premium.php`
- `css/premium-product.css`
- `functions.php` (with all filters/hooks)
- Category configuration arrays

✅ **Media Library**
- Featured images
- Product images
- Gallery uploads
- Index: Product SKU → Image mapping

### Backup Triggers
| Trigger | Action |
|---------|--------|
| Before code modification | Full backup |
| Before database update | Database export |
| Before plugin change | Plugin snapshot |
| Weekly (FYI) | Incremental backup |

---

## 📋 VERSION CONTROL PROTOCOL

### Pre-Change Checklist
- [ ] Backup created with timestamp
- [ ] Change description documented
- [ ] Approval obtained from advisor
- [ ] Rollback plan prepared

### Post-Change Checklist
- [ ] Changes tested in staging
- [ ] No functional regression
- [ ] Audit performed
- [ ] Logbook updated
- [ ] Screenshots/evidence captured

### Rollback Procedure
If issues arise:
```
1. Stop any active processes
2. Restore from backup: database_local_YYYY-MM-DD.sql
3. Restore theme files from backup/
4. Verify staging environment
5. Test all product pages
6. Document incident in logbook
```

---

## 🗂️ CRITICAL FILES & LOCATIONS

### Theme Core
- **Location:** `wp-content/themes/NewEfficientAdvtWorkingTheme_v1.0/`
- **Key Files:**
  - `single-product-premium.php` (Product template - DO NOT MODIFY without approval)
  - `css/premium-product.css` (Design tokens - DO NOT MODIFY without approval)
  - `functions.php` (All hooks - DO NOT MODIFY without approval)
  - `header.php` (Navigation - DO NOT MODIFY without approval)
  - `footer.php` (Footer - DO NOT MODIFY without approval)

### Database
- **Host:** localhost (port 10035)
- **Database:** `local`
- **User:** root
- **Password:** root

### WordPress Core
- **Location:** `c:\Users\merch\Local Sites\newefficientadvertising09042026\app\public\`
- **Version:** WP core + WooCommerce
- **Permalink:** `/product/{slug}/` and `/product-category/{slug}/`

### Product Data
- **Product Count:** 529 published, 162 draft, 104 private
- **Categories:** 59 (8 parent + 51 child)
- **Images:** Many awaiting assignment
- **Index:** SKU to Image mapping CSV available

---

## 🚨 DO NOT TOUCH (Without Explicit Approval)

❌ Database structure changes  
❌ Active theme directory  
❌ WooCommerce product post type definitions  
❌ WordPress core files  
❌ Plugin deactivation  
❌ Permalink structure changes  

---

## ✅ READY FOR APPROVAL

This backup & version control manifest is ready, and the project governance protocol is in place.

**Awaiting:** Advisor approval to proceed with any modifications.

**Next Action:** Receive advisor instructions on priority focus areas.
