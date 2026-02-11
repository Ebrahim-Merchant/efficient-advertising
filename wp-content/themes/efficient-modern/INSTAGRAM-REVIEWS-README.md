# Instagram & Google Reviews Integration

## Overview
I've successfully added both the **Instagram Feed** and **Google Reviews** sections from your old theme to the new M Print House inspired layout.

## New Sections Added

### 1. Google Reviews Section
**Location:** After "Businesses That Trust Us" section, before FAQ

**Features:**
- Section title pulls from ACF field "Google Reviews" (fallback: "What Our Clients Say")
- Displays Google reviews using Trustindex widget
- Shortcode: `[trustindex no-registration=google]`
- Clean, modern styling with proper spacing
- Fully responsive design

**Styling:**
- White background
- Centered layout
- Maximum width: 1200px
- Minimum iframe height: 400px (350px on tablet, 300px on mobile)

### 2. Instagram Feed Section
**Location:** After FAQ section, before Final CTA

**Features:**
- Section title: "Follow Us On Instagram"
- Displays Instagram feed using Trustindex widget
- Shortcode: `[trustindex-feed-instagram]`
- Optional "Follow Us on Instagram" button (if Instagram link is set in theme options)
- Light gray background (#f8f9fa) for contrast
- Fully responsive design

**Styling:**
- Light background for visual separation
- Centered layout
- Maximum width: 1200px
- Minimum iframe height: 500px (400px on tablet, 350px on mobile)
- Optional Instagram button with brand styling

## Required Plugins

To display these sections, you need the **Trustindex** plugin installed:

1. **Trustindex - Google Reviews**
   - For Google Reviews display
   - Shortcode: `[trustindex no-registration=google]`

2. **Trustindex - Instagram Feed**
   - For Instagram feed display
   - Shortcode: `[trustindex-feed-instagram]`

## How to Configure

### Google Reviews:
1. Install "Trustindex" plugin from WordPress plugins
2. Connect your Google Business account
3. Configure the widget settings in Trustindex dashboard
4. The shortcode will automatically display reviews

### Instagram Feed:
1. Install "Trustindex Instagram Feed" or similar plugin
2. Connect your Instagram account
3. Configure feed settings (number of posts, layout, etc.)
4. The shortcode will automatically display your feed

### Custom Settings:
- **Instagram Link:** Set in theme options (of_get_option('instagram_link'))
- **Google Reviews Title:** Set via ACF field "Google Reviews" on the homepage
- If ACF field is empty, defaults to "What Our Clients Say"

## Layout Order (Full Homepage)

1. Hero Section
2. Trust Badges Bar
3. Our Bouquet of Services
4. Featured Products
5. Our Order Process
6. Businesses That Trust Us
7. **Google Reviews** ⭐ NEW
8. FAQ Section
9. **Instagram Feed** ⭐ NEW
10. Final CTA Section

## Styling Details

### Google Reviews Section:
```css
- Background: White
- Padding: 80px 0
- Content max-width: 1200px
- Centered alignment
- Responsive iframe sizing
```

### Instagram Section:
```css
- Background: #f8f9fa (light gray)
- Padding: 80px 0
- Content max-width: 1200px
- Centered alignment
- Optional button with brand colors
- Responsive iframe sizing
```

## Responsive Behavior

### Desktop (1200px+):
- Full width layouts
- Iframe min-height: 400px (reviews), 500px (Instagram)

### Tablet (768px - 1199px):
- Adjusted iframe heights
- Reviews: 350px min-height
- Instagram: 400px min-height

### Mobile (< 768px):
- Single column layouts
- Reviews: 300px min-height
- Instagram: 350px min-height
- Full-width buttons

## Testing Checklist

- [ ] Install Trustindex plugins
- [ ] Connect Google Business account
- [ ] Connect Instagram account
- [ ] Test shortcodes display correctly
- [ ] Check responsive layouts on mobile
- [ ] Verify Instagram link button appears (if link is set)
- [ ] Test on different browsers
- [ ] Check loading performance

## Customization Options

### Change Section Order:
Edit `/wp-content/themes/efficient-modern/index.php` and move the section blocks.

### Change Instagram Button Text:
Line ~357 in index.php:
```php
<i class="fab fa-instagram"></i> Follow Us on Instagram
```

### Change Reviews Title:
Set ACF field "Google Reviews" on homepage, or edit fallback text in index.php (line ~274).

### Modify Styling:
Edit `/wp-content/themes/efficient-modern/assets/css/mpstyle.css`:
- Reviews section styles: Lines ~497-516
- Instagram section styles: Lines ~518-568

## Alternative Plugins

If you prefer different plugins, you can replace the shortcodes:

**For Google Reviews:**
- Google Reviews Widget
- WP Google Review
- Widget for Google Reviews

**For Instagram:**
- Smash Balloon Instagram Feed
- 10Web Social Photo Feed
- Instagram Feed by Elfsight

Just replace the shortcode in index.php with your plugin's shortcode.

## Support Notes

- Both sections use WOW.js animations for smooth appearance
- Sections maintain consistent design with rest of homepage
- Fully compatible with M Print House inspired layout
- No conflicts with existing functionality
- All styling is responsive and mobile-friendly

Enjoy your enhanced homepage with social proof and Instagram showcase! 🎉
