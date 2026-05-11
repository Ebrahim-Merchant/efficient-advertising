#!/usr/bin/env python3
"""
Local Product Scraper - Python Version
Scrapes products from mprinthouse.ae and saves locally for testing
No WordPress or dependencies needed!

Usage:
    python3 scraper-test.py
    python3 scraper-test.py --output json
    python3 scraper-test.py --output csv
"""

import requests
from bs4 import BeautifulSoup
import json
import csv
import sys
from datetime import datetime
from urllib.parse import urljoin, urlparse
import argparse
from typing import List, Dict, Optional

class Colors:
    """ANSI color codes for terminal output"""
    HEADER = '\033[44;37m'
    BLUE = '\033[0;36m'
    GREEN = '\033[0;32m'
    YELLOW = '\033[1;33m'
    RED = '\033[0;31m'
    MAGENTA = '\033[1;35m'
    CYAN = '\033[0;36m'
    END = '\033[0m'
    BOLD = '\033[1m'

class ProductScraper:
    def __init__(self, url: str = 'https://mprinthouse.ae/'):
        self.url = url
        self.products = []
        self.errors = []
        self.session = requests.Session()
        self.session.headers.update({
            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
        })
        self.print_title('🎯 Local Product Scraper - Python')
        print(f"{Colors.BLUE}Target: {self.url}{Colors.END}\n")

    def print_title(self, text: str):
        """Print formatted title"""
        print(f"\n{Colors.HEADER} {'━' * 60} {Colors.END}")
        print(f"{Colors.BOLD}{Colors.CYAN} {text} {Colors.END}")
        print(f"{Colors.HEADER} {'━' * 60} {Colors.END}\n")

    def log_success(self, message: str):
        """Print success message"""
        timestamp = datetime.now().strftime('%H:%M:%S')
        print(f"{Colors.GREEN}✓ [{timestamp}] {message}{Colors.END}")

    def log_error(self, message: str):
        """Print error message"""
        timestamp = datetime.now().strftime('%H:%M:%S')
        print(f"{Colors.RED}✗ [{timestamp}] ERROR: {message}{Colors.END}")
        self.errors.append(message)

    def log_warning(self, message: str):
        """Print warning message"""
        timestamp = datetime.now().strftime('%H:%M:%S')
        print(f"{Colors.YELLOW}⚠ [{timestamp}] WARNING: {message}{Colors.END}")

    def log_info(self, message: str):
        """Print info message"""
        timestamp = datetime.now().strftime('%H:%M:%S')
        print(f"{Colors.BLUE}ℹ [{timestamp}] {message}{Colors.END}")

    def log_product(self, message: str):
        """Print product message"""
        print(f"{Colors.MAGENTA}  📦 {message}{Colors.END}")

    def log_data(self, message: str):
        """Print data message"""
        print(f"{Colors.CYAN}     {message}{Colors.END}")

    def fetch_url(self, url: str) -> Optional[str]:
        """Fetch URL content"""
        try:
            self.log_info(f"Fetching: {url}")
            response = self.session.get(url, timeout=15)
            response.raise_for_status()
            self.log_success(f"Fetched successfully ({len(response.content)} bytes)")
            return response.text
        except requests.RequestException as e:
            self.log_error(f"Failed to fetch URL: {str(e)}")
            return None

    def make_absolute_url(self, url: str, base_url: str) -> str:
        """Convert relative URL to absolute"""
        if url.startswith('http'):
            return url
        return urljoin(base_url, url)

    def extract_products(self, html: str) -> bool:
        """Extract products from HTML"""
        try:
            soup = BeautifulSoup(html, 'html.parser')
            self.log_info("Parsing HTML with BeautifulSoup...")

            # This is a WooCommerce store - use li.product selector
            all_products = soup.find_all('li', class_='product')
            
            if all_products:
                self.log_success(f"Found {len(all_products)} WooCommerce products")
            else:
                self.log_warning("No li.product elements found, trying alternate selectors...")
                # Try alternate selectors
                all_products = soup.find_all('div', class_='eael-product-wrap')
                if all_products:
                    self.log_success(f"Found {len(all_products)} products with eael-product-wrap selector")

            if not all_products:
                self.log_error("No products found with any selector")
                return False

            self.log_info(f"Processing {len(all_products)} product elements...")

            for element in all_products:
                product = self.extract_product_data(element)
                if product and product.get('name'):
                    self.products.append(product)

            self.log_success(f"Successfully extracted {len(self.products)} products")
            return len(self.products) > 0

        except Exception as e:
            self.log_error(f"Error parsing HTML: {str(e)}")
            return False

    def extract_product_data(self, element) -> Optional[Dict]:
        """Extract product data from HTML element"""
        product = {}

        # For WooCommerce products, look for the standard selectors
        
        # Extract name
        title_elem = element.find('h2', class_='woocommerce-loop-product__title')
        if not title_elem:
            title_elem = element.find('h2')
        if not title_elem:
            # Check inside link
            link = element.find('a', class_='woocommerce-LoopProduct-link')
            if link:
                title_elem = link.find('h2')

        if title_elem:
            name = title_elem.get_text(strip=True)
            if name and len(name) > 2:
                product['name'] = name
        
        if not product.get('name'):
            return None

        # Extract price
        price_elem = element.find('span', class_='woocommerce-Price-amount')
        if price_elem:
            price_text = price_elem.get_text(strip=True)
            # Extract just the number
            import re
            match = re.search(r'[\d.]+', price_text)
            if match:
                product['price'] = match.group(0)

        # Extract description (might not be available in list view)
        desc_elem = element.find('p', class_='woo-sc-product-shortcode-item-description')
        if desc_elem:
            desc = desc_elem.get_text(strip=True)
            if desc:
                product['description'] = desc

        # Extract image - check data-src attribute first (lazy loading)
        product_wrap = element.find('div', class_='eael-product-wrap')
        if product_wrap and product_wrap.get('data-src'):
            product['image_url'] = product_wrap.get('data-src')
        else:
            # Fallback to img tag
            img = element.find('img')
            if img:
                img_url = img.get('src') or img.get('data-src')
                if img_url and not img_url.startswith('data:'):
                    product['image_url'] = img_url

        # Extract product URL
        link = element.find('a', class_='woocommerce-LoopProduct-link')
        if link and link.get('href'):
            product['url'] = link.get('href')

        return product if product.get('name') else None

    def scrape(self) -> bool:
        """Main scraping function"""
        html = self.fetch_url(self.url)
        if not html:
            return False

        return self.extract_products(html)

    def display_results(self):
        """Display results in terminal"""
        self.print_title(f"{len(self.products)} Products Found")

        if not self.products:
            self.log_warning("No products to display")
            return

        for idx, product in enumerate(self.products, 1):
            print(f"\n{Colors.BOLD}{Colors.CYAN}{idx}. {product.get('name', 'N/A')}{Colors.END}")

            if 'price' in product:
                self.log_data(f"Price: {product['price']}")

            if 'description' in product:
                desc = product['description'][:100]
                desc += "..." if len(product['description']) > 100 else ""
                self.log_data(f"Description: {desc}")

            if 'image_url' in product:
                self.log_data(f"Image: {product['image_url']}")

            if 'url' in product:
                self.log_data(f"URL: {product['url']}")

    def save_to_json(self, filename: str = 'scraped-products.json') -> bool:
        """Save products to JSON file"""
        try:
            data = {
                'timestamp': datetime.now().isoformat(),
                'source_url': self.url,
                'total_products': len(self.products),
                'products': self.products,
                'errors': self.errors,
            }

            with open(filename, 'w', encoding='utf-8') as f:
                json.dump(data, f, indent=2, ensure_ascii=False)

            file_size = len(open(filename, 'rb').read())
            self.log_success(f"Saved to: {filename} ({file_size} bytes)")
            return True

        except Exception as e:
            self.log_error(f"Failed to save JSON: {str(e)}")
            return False

    def save_to_csv(self, filename: str = 'scraped-products.csv') -> bool:
        """Save products to CSV file"""
        try:
            if not self.products:
                self.log_warning("No products to export")
                return False

            with open(filename, 'w', newline='', encoding='utf-8') as f:
                writer = csv.DictWriter(f, fieldnames=self.products[0].keys())
                writer.writeheader()
                writer.writerows(self.products)

            file_size = len(open(filename, 'rb').read())
            self.log_success(f"Exported to: {filename} ({file_size} bytes)")
            return True

        except Exception as e:
            self.log_error(f"Failed to save CSV: {str(e)}")
            return False

    def save_to_html(self, filename: str = 'scraped-products.html') -> bool:
        """Save products as HTML report"""
        try:
            html_content = """
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scraped Products Report</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 8px; margin-bottom: 30px; }
        .header h1 { font-size: 2.5em; margin-bottom: 10px; }
        .header p { font-size: 1.1em; opacity: 0.9; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .stat-card .number { font-size: 2em; font-weight: bold; color: #667eea; }
        .stat-card .label { color: #666; margin-top: 5px; }
        .products { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .product-card { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: transform 0.2s; }
        .product-card:hover { transform: translateY(-5px); }
        .product-image { width: 100%; height: 200px; background: #f0f0f0; overflow: hidden; }
        .product-image img { width: 100%; height: 100%; object-fit: cover; }
        .product-info { padding: 15px; }
        .product-name { font-size: 1.2em; font-weight: bold; margin-bottom: 10px; color: #333; }
        .product-price { font-size: 1.5em; font-weight: bold; color: #667eea; margin-bottom: 10px; }
        .product-desc { color: #666; font-size: 0.9em; margin-bottom: 10px; line-height: 1.4; }
        .product-url { display: inline-block; color: #667eea; text-decoration: none; font-size: 0.9em; }
        .product-url:hover { text-decoration: underline; }
        .footer { margin-top: 30px; padding: 20px; background: white; border-radius: 8px; text-align: center; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎯 Scraped Products Report</h1>
            <p>mprinthouse.ae Product Scraping Results</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="number">{}</div>
                <div class="label">Total Products</div>
            </div>
            <div class="stat-card">
                <div class="number">{}</div>
                <div class="label">With Images</div>
            </div>
            <div class="stat-card">
                <div class="number">{}</div>
                <div class="label">With Prices</div>
            </div>
            <div class="stat-card">
                <div class="number">{}</div>
                <div class="label">With URLs</div>
            </div>
        </div>

        <div class="products">
""".format(
                len(self.products),
                len([p for p in self.products if 'image_url' in p]),
                len([p for p in self.products if 'price' in p]),
                len([p for p in self.products if 'url' in p]),
            )

            for product in self.products:
                html_content += f"""
            <div class="product-card">
"""
                if 'image_url' in product:
                    html_content += f'                <div class="product-image"><img src="{product["image_url"]}" alt="{product["name"]}"></div>\n'
                else:
                    html_content += '                <div class="product-image"></div>\n'

                html_content += f"""
                <div class="product-info">
                    <div class="product-name">{product.get('name', 'N/A')}</div>
"""
                if 'price' in product:
                    html_content += f'                    <div class="product-price">${product["price"]}</div>\n'

                if 'description' in product:
                    desc = product['description'][:150]
                    desc += "..." if len(product['description']) > 150 else ""
                    html_content += f'                    <div class="product-desc">{desc}</div>\n'

                if 'url' in product:
                    html_content += f'                    <a href="{product["url"]}" class="product-url" target="_blank">View Product →</a>\n'

                html_content += """
                </div>
            </div>
"""

            html_content += """
        </div>

        <div class="footer">
            <p>Generated: {}</p>
            <p>Source: {}</p>
        </div>
    </div>
</body>
</html>
""".format(datetime.now().strftime('%Y-%m-%d %H:%M:%S'), self.url)

            with open(filename, 'w', encoding='utf-8') as f:
                f.write(html_content)

            file_size = len(open(filename, 'rb').read())
            self.log_success(f"HTML report saved: {filename} ({file_size} bytes)")
            print(f"\n{Colors.BLUE}Open in browser: file://{filename}{Colors.END}")
            return True

        except Exception as e:
            self.log_error(f"Failed to save HTML: {str(e)}")
            return False


def main():
    parser = argparse.ArgumentParser(
        description='Local Product Scraper for mprinthouse.ae',
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog="""
Examples:
  python3 scraper-test.py                    # Scrape and show results
  python3 scraper-test.py --output json      # Export to JSON
  python3 scraper-test.py --output csv       # Export to CSV
  python3 scraper-test.py --output html      # Create HTML report
  python3 scraper-test.py --output all       # All formats
        """
    )

    parser.add_argument(
        '--output',
        choices=['json', 'csv', 'html', 'all'],
        default='json',
        help='Output format (default: json)'
    )

    args = parser.parse_args()

    # Create scraper
    scraper = ProductScraper()

    # Run scraping
    if scraper.scrape():
        # Display results
        scraper.display_results()

        # Save files
        if args.output in ['json', 'all']:
            scraper.save_to_json('scraped-products.json')

        if args.output in ['csv', 'all']:
            scraper.save_to_csv('scraped-products.csv')

        if args.output in ['html', 'all']:
            scraper.save_to_html('scraped-products.html')

        # Summary
        print(f"\n{Colors.GREEN}✓ Scraping completed successfully!{Colors.END}\n")

    else:
        scraper.log_error("Scraping failed")
        sys.exit(1)


if __name__ == '__main__':
    main()
