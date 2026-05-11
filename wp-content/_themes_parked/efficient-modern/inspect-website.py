#!/usr/bin/env python3
"""
Website Structure Inspector
Analyzes HTML structure to find correct product selectors
"""

import requests
from bs4 import BeautifulSoup
import re
from collections import Counter

class Colors:
    BLUE = '\033[0;36m'
    GREEN = '\033[0;32m'
    YELLOW = '\033[1;33m'
    RED = '\033[0;31m'
    MAGENTA = '\033[1;35m'
    END = '\033[0m'
    BOLD = '\033[1m'

def inspect_website(url):
    print(f"\n{Colors.BOLD}{Colors.BLUE}🔍 Website Structure Inspector{Colors.END}\n")
    print(f"Target: {url}\n")
    
    # Fetch
    print(f"{Colors.BLUE}Fetching website...{Colors.END}")
    try:
        response = requests.get(url, timeout=15)
        response.raise_for_status()
    except Exception as e:
        print(f"{Colors.RED}Error: {e}{Colors.END}")
        return
    
    print(f"{Colors.GREEN}✓ Downloaded {len(response.content)} bytes{Colors.END}\n")
    
    # Parse
    soup = BeautifulSoup(response.text, 'html.parser')
    
    # Analyze structure
    print(f"{Colors.BOLD}📊 HTML Structure Analysis{Colors.END}\n")
    
    # Check for common class names
    print(f"{Colors.YELLOW}Common class names found:{Colors.END}")
    all_classes = []
    for elem in soup.find_all(class_=True):
        classes = elem.get('class', [])
        all_classes.extend(classes)
    
    class_counts = Counter(all_classes)
    for class_name, count in class_counts.most_common(20):
        if class_name and len(class_name) > 2:
            print(f"  • {class_name}: {count}x")
    
    print()
    
    # Check for common IDs
    print(f"{Colors.YELLOW}Common IDs found:{Colors.END}")
    all_ids = []
    for elem in soup.find_all(id=True):
        elem_id = elem.get('id')
        if elem_id:
            all_ids.append(elem_id)
    
    id_counts = Counter(all_ids)
    for elem_id, count in id_counts.most_common(10):
        if elem_id and len(elem_id) > 2:
            print(f"  • {elem_id}: {count}x")
    
    print()
    
    # Check for product-like patterns
    print(f"{Colors.YELLOW}Product-like elements:{Colors.END}")
    
    # Look for common product indicators
    indicators = {
        'images': len(soup.find_all('img')),
        'prices': len(re.findall(r'\$\s*[\d.]+|AED\s*[\d.]+', response.text)),
        'links': len(soup.find_all('a', href=True)),
        'headings': len(soup.find_all(['h1', 'h2', 'h3', 'h4'])),
    }
    
    for indicator, count in indicators.items():
        print(f"  • {indicator}: {count}")
    
    print()
    
    # Find divs with product-like attributes
    print(f"{Colors.YELLOW}Interesting div patterns:{Colors.END}")
    
    divs_with_attrs = soup.find_all('div', attrs={
        'class': re.compile(r'product|item|card|listing|entry', re.I),
    })
    
    if divs_with_attrs:
        print(f"  Found {len(divs_with_attrs)} divs with product-like classes")
        for div in divs_with_attrs[:5]:
            classes = div.get('class', [])
            print(f"    • classes: {' '.join(classes)}")
    
    # Look for data attributes
    print()
    print(f"{Colors.YELLOW}Elements with data-* attributes:{Colors.END}")
    
    data_attrs = {}
    for elem in soup.find_all(attrs={re.compile(r'^data-'): True}):
        for attr in elem.attrs:
            if attr.startswith('data-'):
                data_attrs[attr] = data_attrs.get(attr, 0) + 1
    
    if data_attrs:
        for attr, count in sorted(data_attrs.items(), key=lambda x: x[1], reverse=True)[:10]:
            print(f"  • {attr}: {count}x")
    else:
        print(f"  {Colors.YELLOW}No data attributes found{Colors.END}")
    
    print()
    
    # Sample HTML
    print(f"{Colors.YELLOW}Sample HTML from first few divs:{Colors.END}\n")
    
    divs = soup.find_all('div', limit=20)
    for i, div in enumerate(divs[:5], 1):
        # Get first 200 chars
        html_str = str(div)[:200]
        if len(str(div)) > 200:
            html_str += "..."
        print(f"  Div {i}:")
        print(f"  {Colors.BLUE}{html_str}{Colors.END}\n")
    
    # Look for specific patterns
    print(f"{Colors.YELLOW}Checking specific selectors:{Colors.END}\n")
    
    selectors_to_test = [
        ('div.product', 'div.product'),
        ('div[class*="product"]', 'div with "product" in class'),
        ('div.item', 'div.item'),
        ('div[class*="item"]', 'div with "item" in class'),
        ('div.card', 'div.card'),
        ('a[href*="product"]', 'links with "product" in href'),
        ('div[data-product-id]', 'divs with data-product-id'),
        ('article', 'article tags'),
        ('li.product', 'li.product'),
    ]
    
    for selector, description in selectors_to_test:
        try:
            if selector.startswith('div.'):
                class_name = selector.split('.')[1]
                count = len(soup.select(selector))
            else:
                count = len(soup.select(selector))
            
            if count > 0:
                print(f"  {Colors.GREEN}✓{Colors.END} {description}: {count} matches")
            else:
                print(f"  {Colors.RED}✗{Colors.END} {description}: no matches")
        except:
            pass
    
    print()
    print(f"{Colors.MAGENTA}💡 Tips:{Colors.END}")
    print("  1. Look at the output above for patterns")
    print("  2. Update the selectors in scraper-test.py")
    print("  3. Or manually inspect the website:")
    print("     - Visit https://mprinthouse.ae/")
    print("     - Right-click on a product → Inspect")
    print("     - Find the parent div class name")
    print("     - Update the selector in the script")
    print()

if __name__ == '__main__':
    inspect_website('https://mprinthouse.ae/')
