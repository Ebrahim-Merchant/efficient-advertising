# Contact Page & Product Pages - Setup Guide

## ✅ What's Been Fixed

### 1. **Product Archive Page** (`archive-product.php`)
- **Issue**: Page wasn't loading
- **Fix**: Updated custom post type registration to properly enable archives
- **URL**: `http://efficientadvt.local/product/`

### 2. **Single Product Pages** (`single-product.php`)
- **Issue**: Not loading properly
- **Fix**: Rewrite rules updated for proper URL structure
- **URL**: `http://efficientadvt.local/product/product-name/`

### 3. **Contact Page** (`page-contact.php`)
- **Issue**: Form was empty
- **Fix**: Created complete contact page template with:
  - Contact information cards (Phone, Email, WhatsApp, Address)
  - Contact Form 7 integration
  - Fallback HTML form if CF7 not installed
  - Business hours sidebar
  - Social media links
  - Quick WhatsApp button

## 🚀 How to Use

### Setting Up the Contact Page:

1. **Go to WordPress Admin** → Pages → Add New (or edit existing "Contact Us" page)

2. **Set Page Template**:
   - In the right sidebar, find "Page Attributes"
   - Under "Template", select **"Contact Page"**
   - Click "Publish" or "Update"

3. **Install Contact Form 7** (Recommended):
   ```
   WordPress Admin → Plugins → Add New
   Search for "Contact Form 7"
   Install and Activate
   ```

4. **The page will automatically**:
   - Display your contact information (from theme options)
   - Show the contact form
   - Display business hours
   - Show social media links

### Fixing Product Pages:

**IMPORTANT**: You must **flush permalinks** after theme changes!

1. **Go to**: WordPress Admin → Settings → Permalinks
2. **Click**: "Save Changes" button (don't change anything, just save)
3. **Test**: Visit `http://efficientadvt.local/product/`

This will regenerate the URL rewrite rules and make product pages work!

## 📝 Page Template Usage

### Contact Page Template Features:

✅ **Contact Info Section** - Auto-populated from theme options:
- Phone numbers
- Email address
- WhatsApp number
- Physical address

✅ **Contact Form** - Uses Contact Form 7:
- Name, Email, Phone, Subject fields
- Message textarea
- Submit button
- Fallback HTML form if CF7 not installed

✅ **Sidebar Features**:
- Business hours (customizable in template)
- Social media links (from theme options)
- Quick WhatsApp contact button

✅ **Optional Google Map**:
- Can be enabled via theme options
- Embed Google Maps iframe

## 🎨 Customization

### Edit Business Hours:
Open `page-contact.php` and find this section (around line 240):
```php
<div class="hours-row">
    <span class="day">Monday - Friday</span>
    <span class="time">9:00 AM - 6:00 PM</span>
</div>
```

### Change Contact Information:
Contact info is pulled from theme options automatically:
- `of_get_option('phone_number')`
- `of_get_option('email_address')`
- `of_get_option('whatsapp_no')`
- `of_get_option('address')`

### Customize Form Fields:
If using Contact Form 7:
1. Go to Contact → Contact Forms
2. Edit your form
3. Customize fields as needed

## 🔧 Troubleshooting

### Products Page Shows 404:
1. Go to Settings → Permalinks
2. Click "Save Changes"
3. Try visiting `/product/` again

### Contact Form Not Showing:
1. Check if Contact Form 7 is installed and activated
2. If not, a fallback HTML form will display
3. Install CF7 for better functionality

### Contact Info Not Showing:
The template uses the OptionsFramework theme options. If not set:
- Default placeholder values will display
- Update theme options in Appearance → Theme Options

### WhatsApp Link Not Working:
Make sure WhatsApp number is in international format:
- Correct: `+971501234567`
- Wrong: `0501234567`

## 📂 Files Modified

**New Files:**
- `/wp-content/themes/efficient-modern/page-contact.php`

**Modified Files:**
- `/wp-content/themes/efficient-modern/inc/custom-post-types.php`
- `/wp-content/themes/efficient-modern/assets/css/custom.css`

## 🎯 Next Steps

1. **Flush Permalinks**: Settings → Permalinks → Save Changes
2. **Create/Edit Contact Page**: Use "Contact Page" template
3. **Install Contact Form 7**: For better form functionality
4. **Test All Links**:
   - Visit `/product/` (all products)
   - Click any product (single product page)
   - Visit contact page
   - Submit contact form
5. **Update Theme Options**: Add your actual contact information

## 💡 Tips

- The contact form will work with any Contact Form 7 form you create
- You can customize the business hours directly in the template
- All styling matches your theme's color scheme
- Fully responsive on all devices
- Includes accessibility features (ARIA labels, semantic HTML)

---

**Need Help?**
- All files are documented with comments
- Styles are organized in `custom.css`
- Template uses WordPress best practices
