import urllib.request
from html.parser import HTMLParser
import ssl

class SEOParser(HTMLParser):
    def __init__(self):
        super().__init__()
        self.in_title = False
        self.in_h1 = False
        self.in_h2 = False
        self.title = ""
        self.h1s = []
        self.h2s = []
        self.meta_desc = ""
        self.img_count = 0
        self.img_no_alt = 0

    def handle_starttag(self, tag, attrs):
        attrs = dict(attrs)
        if tag == "title":
            self.in_title = True
        elif tag == "h1":
            self.in_h1 = True
        elif tag == "h2":
            self.in_h2 = True
        elif tag == "meta":
            if attrs.get("name", "").lower() == "description":
                self.meta_desc = attrs.get("content", "")
        elif tag == "img":
            self.img_count += 1
            if not attrs.get("alt"):
                self.img_no_alt += 1

    def handle_data(self, data):
        data = data.strip()
        if not data: return
        if self.in_title:
            self.title += data + " "
        elif self.in_h1:
            self.h1s.append(data)
        elif self.in_h2:
            self.h2s.append(data)

    def handle_endtag(self, tag):
        if tag == "title":
            self.in_title = False
        elif tag == "h1":
            self.in_h1 = False
        elif tag == "h2":
            self.in_h2 = False

url = "https://finchgiftshop.com"
ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

try:
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
    with urllib.request.urlopen(req, context=ctx) as response:
        html = response.read().decode('utf-8', errors='ignore')
        parser = SEOParser()
        parser.feed(html)
        print(f"Title: {parser.title.strip()}")
        print(f"Meta Description: {parser.meta_desc}")
        print(f"H1 Tags: {parser.h1s}")
        print(f"H2 Tags: {parser.h2s}")
        print(f"Total Images: {parser.img_count}")
        print(f"Images without Alt: {parser.img_no_alt}")
        print(f"HTML Size: {len(html)} bytes")
except Exception as e:
    print(f"Error: {e}")
