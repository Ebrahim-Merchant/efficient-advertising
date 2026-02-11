# Product Scraper with AI SEO Optimization

This script automates the process of scraping products from `https://mprinthouse.ae/` and adding them to your WordPress site with AI-optimized content for SEO.

## Features

✅ Scrapes products from the target website  
✅ Compares with existing WordPress products  
✅ Downloads and uploads product images  
✅ Uses OpenAI to optimize content for SEO  
✅ Automatically adds keywords and company name  
✅ Creates draft posts for manual review before publishing  
✅ Works with both regular WordPress posts and WooCommerce products  

## Prerequisites

1. **OpenAI API Key** (for AI optimization)
   - Sign up at https://platform.openai.com/
   - Create an API key
   - You'll need credits on your account

2. **WordPress Installation**
   - Your WordPress site must be running
   - You should be in your theme directory

## Installation & Setup

### 1. Set Environment Variable

Before running the script, set your OpenAI API key:

```bash
export OPENAI_API_KEY='sk-your-api-key-here'
```

**For macOS/Linux:** Add this to your `~/.zshrc` or `~/.bash_profile` to make it permanent:

```bash
echo "export OPENAI_API_KEY='sk-your-api-key-here'" >> ~/.zshrc
source ~/.zshrc
```

### 2. Make Script Executable

```bash
chmod +x run-scraper.sh
```

### 3. Update Configuration (Optional)

Edit `product-scraper.php` and update the `$config` array if needed:

```php
$config = array(
    'source_url'      => 'https://mprinthouse.ae/',
    'wp_rest_base'    => home_url( '/wp-json/wp/v2/' ),
    'company_name'    => 'Your Company Name', // ← Update this
    'openai_api_key'  => getenv( 'OPENAI_API_KEY' ),
    'admin_user_id'   => 1,
);
```

## Running the Scraper

### Option 1: Using the Shell Script (Recommended)

```bash
./run-scraper.sh
```

### Option 2: Direct PHP Execution

```bash
php product-scraper.php
```

### Option 3: From WordPress Admin

You can also run it via WP-CLI:

```bash
wp eval-file product-scraper.php
```

## How It Works

1. **Loads WordPress** - Initializes your WordPress environment
2. **Fetches Existing Products** - Gets all products from your WordPress site
3. **Scrapes Source Website** - Downloads and parses the HTML from mprinthouse.ae
4. **Identifies Missing Products** - Compares scraped products with existing ones
5. **Optimizes Content** - Uses OpenAI to create SEO-optimized titles and descriptions
6. **Downloads Images** - Saves product images to your media library
7. **Creates Draft Posts** - Adds products as drafts for your review

## Understanding the HTML Selectors

The script uses CSS selectors to extract product information. If the scraper doesn't find products, you may need to update the selectors in `product-scraper.php`:

### Finding the Right Selectors

1. Visit https://mprinthouse.ae/
2. Right-click on a product → "Inspect" (or press F12)
3. Look for patterns in the HTML structure
4. Update these lines in the `extract_product_data()` function:

```php
// Product name
$name_node = $xpath->query( './/h2[contains(@class, "product-name")]', $element )->item( 0 );

// Product price
$price_node = $xpath->query( './/span[contains(@class, "price")]', $element )->item( 0 );

// Product description
$desc_node = $xpath->query( './/p[contains(@class, "description")]', $element )->item( 0 );

// Product image
$img_node = $xpath->query( './/img', $element )->item( 0 );
```

### XPath Selector Examples

- `.//h2` - Any h2 element
- `.//h2[@class="title"]` - h2 with specific class
- `.//span[contains(@class, "price")]` - span containing "price" in class
- `./following-sibling::p` - Next p element after current
- `./ancestor::div[@class="product"]` - Parent div with class "product"

## Output and Logging

The script provides detailed logging:

```
[2026-01-20 10:30:45] [info] Product Scraper initialized
[2026-01-20 10:30:45] [info] Starting product scraping process...
[2026-01-20 10:30:46] [info] Fetching existing products from WordPress...
[2026-01-20 10:30:46] [info] Found 5 existing products
[2026-01-20 10:30:47] [info] Scraping products from https://mprinthouse.ae/
[2026-01-20 10:30:48] [info] Found 24 product elements
[2026-01-20 10:30:48] [info] Successfully scraped 24 products
[2026-01-20 10:30:48] [info] Found 19 missing products
...
```

## Reviewing Scraped Products

After running the scraper:

1. Go to your WordPress Admin Dashboard
2. Navigate to **Posts** or **Products** (depending on your setup)
3. Filter by **Draft** status to see newly scraped products
4. Review, edit, and publish them

## Metadata Added to Posts

Each scraped product includes useful metadata:

- `_source_url` - Original URL from the source website
- `_seo_keywords` - AI-generated SEO keywords
- `_product_scraped` - Marks it as scraped
- `_scraped_date` - When it was scraped

Access this in the post editor or via WordPress admin.

## Troubleshooting

### "OpenAI API key not set"

**Problem:** You see a warning about missing API key  
**Solution:** Set the environment variable before running:
```bash
export OPENAI_API_KEY='sk-your-key'
./run-scraper.sh
```

### "Failed to fetch source website"

**Problem:** Script can't access https://mprinthouse.ae/  
**Solution:** 
- Check your internet connection
- Verify the website is accessible in your browser
- Check if your server has outbound HTTP access
- Website might be blocking the scraper - try adding a delay

### "No products found"

**Problem:** Script runs but finds 0 products  
**Solution:**
- The CSS selectors might be wrong
- Inspect the website HTML to find correct selectors (see "Finding the Right Selectors" above)
- Update the xpath queries in the `extract_product_data()` method

### "Image upload failed"

**Problem:** Products are added but without images  
**Solution:**
- Check WordPress media upload permissions
- Verify `/wp-content/uploads/` directory is writable
- Check server disk space
- Verify image URLs are accessible

### OpenAI API Errors

**Problem:** "Invalid OpenAI response" or quota errors  
**Solution:**
- Verify your API key is correct
- Check your OpenAI account has credits available
- Check API usage at https://platform.openai.com/account/usage/overview
- Rate limits: Free tier has limited requests per minute

## Performance Tips

1. **Start Small** - Test with 5-10 products first
2. **Batch Process** - Run scraper multiple times if website has many products
3. **Cache Images** - Downloaded images are stored in WordPress media library
4. **API Costs** - Each AI optimization uses OpenAI credits (~0.01-0.05 USD per product)

## Advanced: Modifying the Script

### Change the Post Status

To automatically publish posts instead of drafts:

```php
'post_status' => 'publish',  // Changed from 'draft'
```

### Customize AI Prompts

Edit the `build_optimization_prompt()` method to adjust how AI optimizes your content.

### Add Custom Fields

In the `create_product()` method:

```php
update_post_meta( $post_id, 'custom_field_name', 'value' );
```

### Skip AI Optimization

Comment out the optimization line in `process_product()`:

```php
// $optimized = $this->optimize_with_ai( $product );
$optimized = $product;
```

## Support & Debugging

To enable more detailed debugging:

1. Add this to your `wp-config.php`:
```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
```

2. Check `/wp-content/debug.log` for detailed errors

## File Structure

```
wp-content/themes/efficient-modern/
├── product-scraper.php      # Main scraper script
├── run-scraper.sh           # Shell wrapper
└── SCRAPER-README.md        # This file
```

## Next Steps

1. **Configure** - Set your OpenAI API key and company name
2. **Test** - Run the scraper on a small batch first
3. **Monitor** - Check the WordPress admin for results
4. **Refine** - Adjust CSS selectors if needed
5. **Automate** - Set up a cron job for regular updates

## License & Terms

- Ensure you have permission to scrape the target website
- Respect robots.txt and website terms of service
- Test with small quantities first
- Review AI-generated content for accuracy

## Questions?

If products aren't being scraped correctly:
1. Check the exact HTML selectors on the target website
2. Update the CSS/XPath selectors in the script
3. Test selectors in browser console first
4. Run with detailed logging enabled
