#!/usr/bin/env python3
"""
Deep website inspector - find actual product containers
"""

import requests
from bs4 import BeautifulSoup

url = 'https://mprinthouse.ae/'
response = requests.get(url, timeout=15)
soup = BeautifulSoup(response.text, 'html.parser')

print("\n🔍 Looking for WooCommerce product structures...\n")

# WooCommerce uses specific classes
# Let's look for products
products = soup.find_all('a', class_='woocommerce-LoopProduct-link')
print(f"Found {len(products)} woocommerce product links\n")

if products:
    print("Sample product link HTML:")
    for i, product in enumerate(products[:3], 1):
        print(f"\n{i}. Parent structure:")
        parent = product.parent
        print(f"   Parent tag: {parent.name}")
        print(f"   Parent classes: {parent.get('class', [])}")
        
        # Find the container
        container = product
        for _ in range(5):
            if container.parent:
                container = container.parent
                print(f"   → {container.name} classes: {container.get('class', [])}")
        
        print(f"\n   Full link HTML:")
        print(f"   {str(product)[:300]}...")

# Also look for li.product
print("\n\nLooking for li.product elements:")
li_products = soup.find_all('li', class_='product')
print(f"Found {len(li_products)} li.product elements\n")

if li_products:
    print("Sample li.product HTML:")
    for i, product in enumerate(li_products[:3], 1):
        print(f"\n{i}. Product item:")
        print(f"   {str(product)[:400]}...")
        
        # Try to extract data
        link = product.find('a', class_='woocommerce-LoopProduct-link')
        if link:
            print(f"   Link: {link.get('href', 'N/A')}")
        
        title = product.find('h2')
        if title:
            print(f"   Title: {title.get_text(strip=True)}")
        
        price = product.find('span', class_='woocommerce-Price-amount')
        if price:
            print(f"   Price: {price.get_text(strip=True)}")
        
        img = product.find('img')
        if img:
            print(f"   Image: {img.get('src', img.get('data-src', 'N/A'))}")

print("\n\n💡 RESULT: This is a WooCommerce store!")
print("Use selector: li.product")
print("\nInside each li.product, look for:")
print("  - a.woocommerce-LoopProduct-link (product link)")
print("  - h2 or .woocommerce-loop-product__title (product name)")
print("  - span.woocommerce-Price-amount (price)")
print("  - img (featured image)")
