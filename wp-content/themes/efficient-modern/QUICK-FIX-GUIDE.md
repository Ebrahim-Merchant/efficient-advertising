# QUICK FIX GUIDE - Contact & Products

## ✅ What I Did:

### 1. Contact Page - FIXED ✅
Updated `page-contact.php` to match the OLD theme exactly:
- Uses same OptionsFramework fields (`header_address`, `contact_no`, `email_address`)
- Shows ADDRESS, PHONE, EMAIL cards (removed WhatsApp card from top)
- Google Map section (uses ACF field `google_map`)
- Contact Form 7 integration (looks for form ID 210 or any available)
- Simplified layout - matches old theme structure

**How to Use:**
1. WordPress Admin → Pages → Find/Create "Contact Us" page
2. Set Template: **"Contact Page"**
3. If you have ACF, add `google_map` field with iframe code
4. Click Update/Publish

### 2. Products - Need to Check Database

The old theme uses:
- Post Type: `product`
- Taxonomy: `product_category`

But products MUST be registered somewhere (plugin or database).

## 🔍 DEBUG PRODUCTS:

I created a debug file. **Visit this URL:**
```
http://efficientadvt.local/wp-content/themes/efficient-modern/debug-products.php
```

This will show you:
- ✅ Is WooCommerce active?
- ✅ Is product post type registered?
- ✅ How many products exist?
- ✅ What are the correct URLs?
- ✅ Which template files exist?

## 🎯 Most Likely Issue:

**Products ARE registered** (old theme uses them) but:
1. **Permalinks need flushing**: Settings → Permalinks → Save Changes
2. **WooCommerce might be active**: Use Shop page instead of /product/
3. **Theme not activated**: Make sure efficient-modern theme is ACTIVE

## 📝 Quick Actions:

### For Contact Page:
1. Edit Contact Us page
2. Set Template to "Contact Page"
3. Done! ✅

### For Products:
1. **MUST DO**: Go to Settings → Permalinks → Click "Save Changes"
2. Visit debug page (link above)
3. Take screenshot
4. Show me the results

## 🔧 Files Modified:

- ✅ `page-contact.php` - Simplified, matches old theme
- ✅ `inc/custom-post-types.php` - Won't register if WooCommerce active
- ✅ `debug-products.php` - New debug file (DELETE after fixing)

## 💡 What's Probably Happening:

The OLD theme works because:
- Products are in the DATABASE (registered by plugin or old theme)
- Post type: `product`
- Taxonomy: `product_category`

Your NEW theme:
- Tries to register same post type
- Might conflict with WooCommerce OR existing registration
- Needs permalink flush to work

## ⚠️ IMPORTANT:

**You MUST flush permalinks** or products won't load!
Settings → Permalinks → Save Changes

Then try:
- `/product/` for all products
- Click any product from old theme

---

**Next Step:** 
1. Visit the debug page
2. Show me screenshot
3. I'll tell you exact fix!
