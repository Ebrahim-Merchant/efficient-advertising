"""
scrape_instagram_dumpor.py
Downloads photos from @efficientuae Instagram via dumpor.io public viewer.
Then reviews each image and only assigns to the correct product sub-category
if CONFIDENT about the match. Skips ambiguous images.
"""
import os, re, time, json, sys, io, urllib.request, urllib.error

sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8', errors='replace')

HANDLE  = 'efficientuae'
OUT_DIR = r'C:\Users\merch\Local Sites\EfficientAdvt.Com\app\public\insta_images'
MAX_PAGES = 10   # each page has ~12 posts on dumpor

os.makedirs(OUT_DIR, exist_ok=True)

HEADERS = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 '
                  '(KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
    'Accept'    : 'text/html,application/xhtml+xml,*/*;q=0.9',
    'Accept-Language': 'en-US,en;q=0.9',
    'Referer'   : 'https://dumpor.io/',
}

def fetch(url, retries=2):
    for attempt in range(retries):
        try:
            req = urllib.request.Request(url, headers=HEADERS)
            with urllib.request.urlopen(req, timeout=25) as r:
                return r.read().decode('utf-8', errors='ignore')
        except urllib.error.HTTPError as e:
            print(f"  HTTP {e.code} on {url}")
            time.sleep(2)
        except Exception as e:
            print(f"  Error: {e}")
            time.sleep(2)
    return ''

def extract_image_urls(html):
    """Extract full-size image URLs from Inflact HTML"""
    # Inflact uses <img> tags with broad source attributes
    patterns = [
        r'src="(https://[^"]*(?:cdninstagram|fbcdn\.net)[^"]*\.jpg[^"]*)"',
        r'data-src="(https://[^"]*(?:cdninstagram|fbcdn\.net)[^"]*\.jpg[^"]*)"',
        r'<img[^>]+src="(https://[^"]+\.jpg[^"]*)"',
    ]
    urls = []
    for p in patterns:
        found = re.findall(p, html)
        for u in found:
            u = u.replace('\\/', '/').split('?')[0]
            if u.endswith('.jpg') and ('cdninstagram' in u or 'fbcdn' in u or 'instagram' in u):
                urls.append(u)

    seen, result = set(), []
    for u in urls:
        if u not in seen and len(u) > 30:
            seen.add(u)
            result.append(u)
    return result

def download_image(url, dest_path):
    try:
        req = urllib.request.Request(url, headers=HEADERS)
        with urllib.request.urlopen(req, timeout=20) as r:
            data = r.read()
        if len(data) < 5000:
            return False, 0  # Still small but more lenient
        with open(dest_path, 'wb') as f:
            f.write(data)
        return True, len(data)
    except Exception as e:
        return False, 0

def scrape_inflact():
    print(f"== Scraping @{HANDLE} via inflact.com ==\n")
    # Note: Inflact has a limited free search daily, but we can target the profile page
    url = f'https://inflact.com/webviewer/profile/{HANDLE}/'
    
    print(f"Fetching profile: {url}")
    html = fetch(url)
    if not html:
        print("  -> No response from Inflact.")
        return []

    urls = extract_image_urls(html)
    print(f"  -> Found {len(urls)} image URLs")

    # If we need more, Inflact uses pagination or a "Load More" button
    # For now, let's start with what we found on the first load
    return urls

def main():
    all_urls = scrape_inflact()

    if not all_urls:
        print("\nNo images found from inflact.com.")
        # Trying a fallback if Inflact fails
        html = fetch(f'https://imginn.com/{HANDLE}/')
        if html:
            all_urls = extract_image_urls(html)
            print(f"Fallback found: {len(all_urls)} images")

    if not all_urls:
        print("Could not scrape any images. Will need a different approach.")
        return

    print(f"\nDownloading {min(len(all_urls), 1200)} images to:\n  {OUT_DIR}\n")
    print("-" * 60)

    downloaded = 0
    skipped = 0
    failed = 0
    manifest = []

    for i, url in enumerate(all_urls[:1200]):
        filename = f'insta_{i+1:04d}.jpg'
        dest     = os.path.join(OUT_DIR, filename)

        if os.path.exists(dest) and os.path.getsize(dest) > 8000:
            print(f"[{i+1:3d}] SKIP (exists): {filename}")
            skipped += 1
            manifest.append({'file': filename, 'url': url})
            continue

        ok, size = download_image(url, dest)
        if ok:
            print(f"[{i+1:3d}] OK  {filename}  ({size//1024}KB)")
            downloaded += 1
            manifest.append({'file': filename, 'url': url})
        else:
            print(f"[{i+1:3d}] FAIL: {url[:70]}")
            failed += 1

        time.sleep(0.4)

    # Save manifest
    manifest_path = os.path.join(OUT_DIR, '_manifest.json')
    with open(manifest_path, 'w') as f:
        json.dump(manifest, f, indent=2)

    print("\n" + "=" * 60)
    print(f"Downloaded : {downloaded}")
    print(f"Skipped    : {skipped}")
    print(f"Failed     : {failed}")
    print(f"Total saved: {downloaded + skipped}")
    print(f"\nImages in : {OUT_DIR}")
    print(f"Manifest  : {manifest_path}")
    print("\nNext step: Run identify_and_assign.py to review + assign images.")

if __name__ == '__main__':
    main()
