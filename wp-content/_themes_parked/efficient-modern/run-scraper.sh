#!/bin/bash

# Product Scraper Setup and Execution Script
# This script helps you set up and run the product scraper

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
SCRAPER_FILE="$SCRIPT_DIR/product-scraper.php"

echo "======================================"
echo "Product Scraper Setup & Execution"
echo "======================================"
echo ""

# Check if OpenAI API key is set
if [ -z "$OPENAI_API_KEY" ]; then
    echo "⚠️  WARNING: OPENAI_API_KEY environment variable is not set."
    echo ""
    echo "To enable AI optimization, set your API key:"
    echo "  export OPENAI_API_KEY='sk-...'"
    echo ""
    read -p "Continue without AI optimization? (y/n) " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
else
    echo "✓ OpenAI API key detected"
fi

echo ""
echo "Running product scraper..."
echo ""

# Run the PHP scraper
cd "$SCRIPT_DIR/../.."
php "$SCRAPER_FILE"

echo ""
echo "======================================"
echo "Scraper execution completed!"
echo "======================================"
echo ""
echo "Next steps:"
echo "1. Check the logs above for any errors or warnings"
echo "2. Review the scraped products as drafts in WordPress admin"
echo "3. Edit and publish them when ready"
echo "4. Adjust CSS selectors in product-scraper.php if products weren't scraped correctly"
echo ""
