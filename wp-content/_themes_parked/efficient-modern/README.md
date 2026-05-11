# Efficient Modern - WordPress Theme

A modern, responsive WordPress theme designed specifically for Efficient Advertising Dubai - a premier digital printing company in the UAE.

## Features

- **Modern Design**: Clean, contemporary aesthetics with smooth animations
- **Fully Responsive**: Mobile-first design that looks great on all devices
- **WooCommerce Ready**: Full e-commerce integration for product catalogs
- **Custom Post Types**: Product management with categories
- **SEO Optimized**: Clean code and semantic HTML for better search rankings
- **Fast Performance**: Optimized assets and modern CSS/JS
- **WhatsApp Integration**: Floating WhatsApp button and quick contact
- **Customizable**: Easy to customize via WordPress Customizer
- **Translation Ready**: Fully internationalized and ready for translation

## Installation

1. Download the theme files
2. Upload the `efficient-modern` folder to `/wp-content/themes/`
3. Activate the theme through the WordPress admin panel
4. Navigate to **Appearance > Customize** to configure theme settings

## Theme Setup

### Required Plugins

For full functionality, install these plugins:

- **Contact Form 7** - For contact forms
- **Advanced Custom Fields (ACF)** - For custom fields
- **WooCommerce** - For e-commerce functionality (optional)

### Recommended Plugins

- **Yoast SEO** - For better SEO
- **WP Super Cache** - For performance optimization
- **Smush** - For image optimization

## Configuration

### 1. Logo & Branding

- Go to **Appearance > Customize > Site Identity**
- Upload your logo (recommended size: 300x100px)
- Set site title and tagline

### 2. Menus

- Navigate to **Appearance > Menus**
- Create menus for:
  - **Primary Menu** - Main navigation
  - **Footer Menu** - Footer links

### 3. Theme Options (Options Framework)

The theme uses an options framework for easy customization:

- **Logo Settings**: Upload logo and footer logo
- **Contact Information**: Phone, email, address
- **Social Media**: Facebook, Twitter, LinkedIn, Instagram links
- **WhatsApp Number**: For WhatsApp integration
- **Favicon**: Site icon

### 4. Homepage Setup

1. Create a new page named "Home"
2. Assign the "Home" template to it
3. Go to **Settings > Reading**
4. Set "Homepage displays" to "A static page"
5. Select your "Home" page as the homepage

### 5. Custom Fields (ACF)

If using ACF, add these fields to the homepage:

- `hero_background_image` - Hero section background
- `hero_title` - Main hero heading
- `hero_subtitle` - Hero description
- `heading` - About section heading
- `sub_heading` - About section subheading
- `category_heading` - Categories section heading
- `categories_subheadings` - Categories section subheading

For products:

- `product_image_one` - Additional product image 1
- `product_image_two` - Additional product image 2
- `product_image_three` - Additional product image 3
- `product_features` - Product specifications
- `category_link` - Link for home category items

## Custom Post Types

### Products

The theme includes a custom **Product** post type:

- Navigate to **Products > Add New** to create products
- Add product images via Featured Image
- Assign products to categories

### Product Categories

Organize products using the **Product Category** taxonomy:

- Go to **Products > Categories**
- Create categories like "Signage", "Banners", "Vehicle Branding", etc.

### Home Categories

Special post type for homepage category display:

- Navigate to **Home Categories > Add New**
- Add category image and link
- These will appear on the homepage categories section

## Customization

### Colors

Edit colors in `style.css` by modifying CSS variables:

```css
:root {
    --color-primary: #8B1538;     /* Burgundy */
    --color-secondary: #FF6B35;   /* Orange */
    /* Modify other colors as needed */
}
```

### Typography

Change fonts in `functions.php`:

```php
wp_enqueue_style( 
    'efficient-modern-fonts', 
    'https://fonts.googleapis.com/css2?family=Your-Font&display=swap'
);
```

Then update CSS variables in `style.css`.

### Layout

- Container width: Edit `--container-width` in CSS variables
- Spacing: Modify spacing variables
- Grid columns: Adjust grid-template-columns in component styles

## Page Templates

- `index.php` - Homepage template
- `single-product.php` - Individual product pages
- `taxonomy-product_category.php` - Product category archives
- `page.php` - Default page template
- `single.php` - Blog post template
- `archive.php` - Blog archive
- `404.php` - Error page

## Support

For support and questions:

- **Email**: info@efficientadvertising.ae
- **Phone**: +971 4 XXX XXXX
- **Website**: https://efficientadvertising.ae

## Changelog

### Version 1.0.0 (January 2026)

- Initial release
- Modern homepage design
- Custom product post types
- WooCommerce integration
- Responsive design
- WhatsApp integration
- Contact forms integration
- SEO optimization

## Credits

- **Design & Development**: Efficient Advertising Tech Team
- **Fonts**: Google Fonts (Inter, Poppins)
- **Icons**: Font Awesome 6
- **Framework**: WordPress

## License

This theme is licensed under the GNU General Public License v2 or later.

---

© 2026 Efficient Advertising Dubai. All rights reserved.
