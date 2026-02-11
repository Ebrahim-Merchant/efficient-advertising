#!/usr/bin/env python3
"""
Product Scraper CLI Tool
A command-line interface for the product scraper with additional features.

Usage:
    python3 scraper-cli.py --help
    python3 scraper-cli.py run
    python3 scraper-cli.py test-selectors
    python3 scraper-cli.py inspect-website
"""

import requests
import argparse
import json
import sys
from urllib.parse import urljoin
from html.parser import HTMLParser
from typing import List, Dict, Optional
import os
from datetime import datetime

class ScraperCLI:
    def __init__(self):
        self.config = self.load_config()
        self.session = requests.Session()
        self.session.headers.update({
            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        })
        self.log_file = None
        
    def load_config(self) -> dict:
        """Load configuration from environment or use defaults"""
        return {
            'source_url': 'https://mprinthouse.ae/',
            'company_name': os.getenv('COMPANY_NAME', 'Efficient Advertising'),
            'openai_api_key': os.getenv('OPENAI_API_KEY', ''),
            'openai_model': 'gpt-3.5-turbo',
            'timeout': 15,
            'user_agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        }
    
    def log(self, message: str, level: str = 'INFO'):
        """Print formatted log message"""
        timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        log_msg = f"[{timestamp}] [{level}] {message}"
        print(log_msg)
        
        if self.log_file:
            with open(self.log_file, 'a') as f:
                f.write(log_msg + '\n')
    
    def fetch_url(self, url: str) -> Optional[str]:
        """Fetch URL content"""
        try:
            self.log(f"Fetching: {url}")
            response = self.session.get(url, timeout=self.config['timeout'])
            response.raise_for_status()
            return response.text
        except Exception as e:
            self.log(f"Error fetching {url}: {str(e)}", 'ERROR')
            return None
    
    def inspect_website(self, args):
        """Analyze website structure to find correct selectors"""
        self.log("Inspecting website structure...")
        
        html = self.fetch_url(self.config['source_url'])
        if not html:
            return
        
        self.log("Website inspection results:")
        self.log("=" * 60)
        
        # Look for common product container classes/tags
        containers = [
            'product', 'item', 'card', 'listing', 'entry',
            'grid-item', 'product-item', 'goods', 'commodity'
        ]
        
        for container in containers:
            if container in html.lower():
                count = html.lower().count(f'class="{container}"')
                if count > 0:
                    self.log(f"Found {count}x elements with class '{container}'")
        
        # Look for product-like patterns
        patterns = [
            (r'<h[1-6][^>]*>.*?</h[1-6]>', 'Headings'),
            (r'<img[^>]*src=["\']([^"\']+)["\']', 'Images'),
            (r'\$\s*[\d.]+', 'Prices'),
            (r'<a\s+href=["\']([^"\']+)["\']', 'Links'),
        ]
        
        for pattern, name in patterns:
            import re
            matches = re.findall(pattern, html, re.IGNORECASE)
            if matches:
                self.log(f"Found {len(matches)} potential {name}")
        
        self.log("=" * 60)
        self.log("Tips for finding selectors:")
        self.log("1. Open the website in your browser")
        self.log("2. Right-click on a product → Inspect")
        self.log("3. Look for parent div/section with class='product' or similar")
        self.log("4. Find the specific elements within that container")
        self.log("5. Update the selectors in scraper-config.php")
    
    def test_selectors(self, args):
        """Test CSS selectors on the website"""
        self.log("Testing selectors on target website...")
        
        if not args.selector:
            self.log("Usage: scraper-cli.py test-selectors --selector 'CSS_SELECTOR'", 'ERROR')
            return
        
        html = self.fetch_url(self.config['source_url'])
        if not html:
            return
        
        # Simple selector testing
        self.log(f"Testing selector: {args.selector}")
        self.log("Note: This is a basic test. Use browser DevTools for more accurate results.")
        
        # Count occurrences
        import re
        if args.selector.startswith('.'):
            class_name = args.selector[1:]
            count = len(re.findall(f'class=["\'][^"\']*{class_name}[^"\']*["\']', html))
        elif args.selector.startswith('#'):
            id_name = args.selector[1:]
            count = len(re.findall(f'id=["\']?{id_name}["\']?', html))
        else:
            count = html.count(f'<{args.selector}')
        
        if count > 0:
            self.log(f"✓ Found {count} matching elements", 'SUCCESS')
        else:
            self.log("✗ No matching elements found", 'WARNING')
            self.log("Try these tips:")
            self.log("- Use browser DevTools to inspect the exact classes/IDs")
            self.log("- Check for dynamic content (JavaScript-rendered)")
            self.log("- Look for parent containers wrapping products")
    
    def validate_config(self, args):
        """Validate configuration"""
        self.log("Validating configuration...")
        
        issues = []
        
        if not self.config['openai_api_key']:
            issues.append("OPENAI_API_KEY environment variable not set")
        
        if not self.config['company_name']:
            issues.append("COMPANY_NAME not configured")
        
        # Test URL
        try:
            response = self.session.head(self.config['source_url'], timeout=5)
            if response.status_code >= 400:
                issues.append(f"Source URL returned {response.status_code}")
        except Exception as e:
            issues.append(f"Cannot reach source URL: {str(e)}")
        
        if issues:
            self.log("Configuration Issues Found:", 'WARNING')
            for issue in issues:
                self.log(f"  • {issue}")
        else:
            self.log("✓ Configuration looks good!", 'SUCCESS')
        
        self.log("\nCurrent Configuration:")
        self.log(f"  Source URL: {self.config['source_url']}")
        self.log(f"  Company Name: {self.config['company_name']}")
        self.log(f"  OpenAI Model: {self.config['openai_model']}")
        self.log(f"  OpenAI API Key: {'Set' if self.config['openai_api_key'] else 'NOT SET'}")
    
    def show_stats(self, args):
        """Show scraping statistics"""
        self.log("Scraping Statistics")
        self.log("=" * 60)
        
        html = self.fetch_url(self.config['source_url'])
        if not html:
            return
        
        # Basic statistics
        import re
        
        # Count potential products
        product_divs = len(re.findall(r'<div[^>]*class="[^"]*product[^"]*"', html))
        product_items = len(re.findall(r'<li[^>]*class="[^"]*item[^"]*"', html))
        
        # Count images
        images = len(re.findall(r'<img[^>]*src=', html))
        
        # Count prices
        prices = len(re.findall(r'[\$€£]\s*[\d.,]+', html))
        
        # Count links
        links = len(re.findall(r'<a\s+href=', html))
        
        self.log(f"Potential product containers: {product_divs + product_items}")
        self.log(f"Images found: {images}")
        self.log(f"Prices found: {prices}")
        self.log(f"Links found: {links}")
        self.log(f"HTML size: {len(html)} bytes")
        self.log("=" * 60)
    
    def run(self):
        """Run the CLI"""
        parser = argparse.ArgumentParser(
            description='Product Scraper CLI Tool',
            formatter_class=argparse.RawDescriptionHelpFormatter,
            epilog="""
Examples:
  python3 scraper-cli.py inspect-website
  python3 scraper-cli.py test-selectors --selector ".product-name"
  python3 scraper-cli.py validate-config
  python3 scraper-cli.py stats
            """
        )
        
        subparsers = parser.add_subparsers(dest='command', help='Commands')
        
        # Inspect website command
        inspect_parser = subparsers.add_parser('inspect-website', help='Analyze website structure')
        inspect_parser.set_defaults(func=self.inspect_website)
        
        # Test selectors command
        test_parser = subparsers.add_parser('test-selectors', help='Test CSS selectors')
        test_parser.add_argument('--selector', help='CSS selector to test')
        test_parser.set_defaults(func=self.test_selectors)
        
        # Validate config command
        validate_parser = subparsers.add_parser('validate-config', help='Validate configuration')
        validate_parser.set_defaults(func=self.validate_config)
        
        # Stats command
        stats_parser = subparsers.add_parser('stats', help='Show scraping statistics')
        stats_parser.set_defaults(func=self.show_stats)
        
        args = parser.parse_args()
        
        if not args.command:
            parser.print_help()
            return
        
        if hasattr(args, 'func'):
            args.func(args)

if __name__ == '__main__':
    cli = ScraperCLI()
    cli.run()
