# Modal System Fix - Unified Request Quote Modal

## Issue
The "Get Quote" button in the navbar was pointing to `#requestQuoteModal` (global modal), but the product page was using a separate `#orderModal` which was only available on product pages. This caused the navbar button to not work correctly on product pages.

## Solution
Unified all "Request a Quote" buttons across the site to use the single global modal `#requestQuoteModal` defined in `footer.php`.

## Changes Made

### 1. Updated Product Page Button (Line ~145)
**File**: `single-product.php`

**Before**:
```php
<button type="button" class="btn-quote" data-toggle="modal" data-target="#orderModal">
```

**After**:
```php
<button type="button" class="btn-quote" data-toggle="modal" data-target="#requestQuoteModal">
```

### 2. Updated CTA Section Button (Line ~316)
**File**: `single-product.php`

**Before**:
```php
<a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>" class="cta-btn-primary">
    <i class="fa-solid fa-envelope"></i>
    <?php esc_html_e( 'Request Custom Quote', 'efficient-modern' ); ?>
</a>
```

**After**:
```php
<button type="button" class="cta-btn-primary" data-toggle="modal" data-target="#requestQuoteModal">
    <i class="fa-solid fa-envelope"></i>
    <?php esc_html_e( 'Request Custom Quote', 'efficient-modern' ); ?>
</button>
```

### 3. Removed Duplicate Modal (Lines 386-578)
**File**: `single-product.php`

Removed the entire `#orderModal` section which included:
- Modal HTML structure
- Custom order form with all fields
- File upload functionality
- Delivery options
- Alternative contact options

This modal is now replaced by the global `#requestQuoteModal` in `footer.php`.

## Modal System Overview

### Global Modal Location
**File**: `footer.php` (Line ~244)
```php
<div class="modal-overlay" id="requestQuoteModal">
```

### Modal Features
- Uses Contact Form 7 integration
- Falls back to default form if CF7 not found
- Globally available across all pages
- Consistent styling with theme

### All Buttons Now Using This Modal

#### 1. Navbar "Get Quote" Button
**File**: `header.php` (Line ~253)
```php
<button type="button" class="btn btn-secondary btn-sm header-cta" data-toggle="modal" data-target="#requestQuoteModal">
```

#### 2. Product Page Main CTA Button
**File**: `single-product.php` (Line ~145)
```php
<button type="button" class="btn-quote" data-toggle="modal" data-target="#requestQuoteModal">
```

#### 3. Product Page Bottom CTA Button
**File**: `single-product.php` (Line ~316)
```php
<button type="button" class="cta-btn-primary" data-toggle="modal" data-target="#requestQuoteModal">
```

#### 4. Archive Page CTA Buttons
**File**: `archive-product.php` (Line ~215)
```php
<button class="cta-btn-primary-white" data-toggle="modal" data-target="#requestQuoteModal">
```

#### 5. Search Page CTA Buttons
**File**: `search.php` (Line ~413)
```php
<button class="cta-btn-primary-white" data-toggle="modal" data-target="#requestQuoteModal">
```

## JavaScript Handler
**File**: `assets/js/mpstyle.js` (Line ~53)

The modal system uses jQuery event delegation:
```javascript
$(document).on('click', '[data-toggle="modal"]', function(e) {
    e.preventDefault();
    var target = $(this).data('target');
    var $modal = $(target);
    
    if ($modal.length) {
        $modal.addClass('active');
        $('body').addClass('modal-open');
    }
});
```

## CSS Styles
**File**: `assets/css/custom.css` (Line ~1293)

Modal styling includes:
- `.modal-overlay` - Full-screen overlay with backdrop blur
- `.modal-overlay.active` - Shows modal with fade-in animation
- `.modal-container` - Modal content wrapper with scale animation
- `.modal-content` - Inner content styling
- `.modal-header` - Header with title and close button
- `.modal-body` - Form content area

## Testing Checklist

✅ **Navbar "Get Quote" Button**
- Works on homepage
- Works on product pages
- Works on archive pages
- Works on search pages
- Works on other pages

✅ **Product Page Buttons**
- Main "Request a Quote" button opens modal
- Bottom CTA "Request Custom Quote" button opens modal
- Modal displays correctly
- Form submits properly

✅ **Archive Page CTA Button**
- Opens modal correctly
- Accessible from all products

✅ **Search Page CTA Button**
- Opens modal correctly
- Available on both product and general search results

## Benefits of This Change

1. **Consistency**: Same modal experience across all pages
2. **Maintainability**: Single modal to update instead of multiple
3. **File Size**: Removed ~200 lines of duplicate code from single-product.php
4. **User Experience**: Predictable behavior for quote requests
5. **Integration**: Centralized Contact Form 7 integration

## Form Submission

The modal uses Contact Form 7 which should be configured in WordPress admin:
1. Go to WordPress Admin → Contact → Contact Forms
2. Create/Edit a form for quote requests
3. The modal will automatically use the first available CF7 form
4. If no CF7 form exists, a default fallback form is displayed

## Future Enhancements

If you need product-specific information in the modal:
- Add hidden fields via JavaScript when modal opens
- Pass product ID/name via URL parameters
- Use CF7 dynamic tags to auto-fill product info

## Troubleshooting

### Modal Not Opening
1. Check browser console for JavaScript errors
2. Verify jQuery is loaded
3. Ensure `mpstyle.js` is enqueued in theme
4. Check that modal ID matches `#requestQuoteModal`

### Form Not Submitting
1. Verify Contact Form 7 is installed and activated
2. Check that at least one CF7 form exists
3. Review CF7 form settings in admin
4. Check email settings in WordPress

### Styling Issues
1. Ensure `custom.css` is loaded
2. Check for conflicting CSS from plugins
3. Verify modal z-index is high enough (9999)
4. Clear browser cache

## Version History

### v2.0.0 (Current) - February 10, 2026
- Unified all quote request buttons to use `#requestQuoteModal`
- Removed duplicate `#orderModal` from product pages
- Changed CTA section link to button with modal trigger
- File size reduced from 865 to 651 lines

### v1.0.0 (Previous)
- Separate modals for different pages
- Product pages used `#orderModal`
- CTA section linked to contact page
