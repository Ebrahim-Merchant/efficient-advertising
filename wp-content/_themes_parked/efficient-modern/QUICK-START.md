# Quick Start Guide - Product Scraper

## 🚀 Get Started in 5 Minutes

### Step 1: Get Your OpenAI API Key
1. Go to https://platform.openai.com/api-keys
2. Sign in or create an account
3. Create a new API key
4. Copy the key (you'll use it next)

### Step 2: Set Environment Variable
Open Terminal and run:

```bash
export OPENAI_API_KEY='sk-your-api-key-here'
```

**To make it permanent** (macOS):
```bash
echo "export OPENAI_API_KEY='sk-your-api-key-here'" >> ~/.zshrc
source ~/.zshrc
```

### Step 3: Navigate to Scraper Directory
```bash
cd /Users/ebrahimmerchant/Local\ Sites/efficient-advertising/app/public/wp-content/themes/efficient-modern
```

### Step 4: Make Script Executable
```bash
chmod +x run-scraper.sh
chmod +x scraper-cli.py
```

### Step 5: Inspect the Target Website
First, let's analyze the website structure:

```bash
python3 scraper-cli.py inspect-website
```

This shows you what elements are on the website and helps identify the correct selectors.

### Step 6: Run the Scraper
```bash
./run-scraper.sh
```

That's it! The script will:
- 🕷️ Scrape products from mprinthouse.ae
- 🤖 Use AI to optimize content for SEO
- 📥 Download images and upload them
- 📝 Create draft posts in WordPress

### Step 7: Review Results
1. Go to your WordPress Admin: `http://localhost:3000/wp-admin`
2. Click **Posts** or **Products**
3. Filter by **Draft** status
4. Review, edit, and publish

---

## 🔧 If Products Aren't Found

The selectors might need updating. Let's debug:

### Option A: Inspect Website Structure
```bash
python3 scraper-cli.py inspect-website
```

### Option B: Check Specific Selectors
```bash
python3 scraper-cli.py test-selectors --selector ".product"
```

### Option C: Manual Inspection

1. Visit https://mprinthouse.ae/
2. Right-click on a product → **Inspect**
3. Look at the HTML structure
4. Edit `product-scraper.php` and update the selectors:

```php
// Find this section in extract_product_data():
$name_node = $xpath->query( './/h2[contains(@class, "product-name")]', $element )->item( 0 );
```

Replace with the actual selector from the website.

---

## 📋 Common Selectors to Try

If the defaults don't work, try these:

```php
// For product names:
'.//h2'                           // Any h2
'.//a[@class="product-title"]'    // Link with product-title class
'.//span[@data-product-name]'     // Span with data attribute

// For prices:
'.//span[@class="price"]'         // Span with price class
'.//div[@data-price]'             // Div with data-price
'.//em'                           // Emphasis tag often used for prices

// For images:
'.//img[@class="product-image"]'  // Img with product-image class
'.//img[1]'                       // First image in container

// For links:
'.//a[@href]'                     // Any link
'.//a[contains(@href, "product")] // Link containing "product" in href
```

---

## 💡 Tips & Tricks

### Skip AI Optimization (Faster)
If you want to scrape without AI, edit `product-scraper.php`:

```php
// Comment out this line:
// $optimized = $this->optimize_with_ai( $product );
// Add this instead:
$optimized = $product;
```

### Publish Automatically
To auto-publish instead of draft:

Edit `product-scraper.php`:
```php
'post_status' => 'publish',  // Changed from 'draft'
```

### Test Without Scraping
```bash
python3 scraper-cli.py validate-config
```

This checks if everything is configured correctly.

---

## 📊 Validate Your Setup

Before the first full run, validate everything:

```bash
python3 scraper-cli.py validate-config
```

You should see:
```
[2026-01-20 10:30:45] [SUCCESS] ✓ Configuration looks good!

Current Configuration:
  Source URL: https://mprinthouse.ae/
  Company Name: Efficient Advertising
  OpenAI Model: gpt-3.5-turbo
  OpenAI API Key: Set
```

---

## 🐛 Troubleshooting

| Issue | Solution |
|-------|----------|
| "Command not found: ./run-scraper.sh" | Run `chmod +x run-scraper.sh` first |
| "OPENAI_API_KEY not set" | Run `export OPENAI_API_KEY='sk-...'` |
| "No products found" | Run `python3 scraper-cli.py inspect-website` to find correct selectors |
| "Image upload failed" | Check `/wp-content/uploads/` permissions |
| "Cannot reach source URL" | Check internet connection or website accessibility |

---

## 💰 API Costs

- **OpenAI GPT-3.5-turbo**: ~$0.01-0.05 per product
- No charges if you skip AI optimization
- Free tier available but limited requests

---

## 📖 Next Steps

1. ✅ Run the scraper: `./run-scraper.sh`
2. 📝 Review products in WordPress admin
3. ✏️ Edit and optimize as needed
4. 🚀 Publish when ready
5. 🔄 Run periodically to sync new products

---

## Full Documentation

For detailed information, see `SCRAPER-README.md` in this directory.

---

## Questions?

If something doesn't work:
1. Check the error message carefully
2. Review the "Troubleshooting" section above
3. Use `python3 scraper-cli.py inspect-website` to debug
4. Update CSS selectors based on actual website structure
5. Run with verbose logging enabled

**Happy scraping! 🎉**
