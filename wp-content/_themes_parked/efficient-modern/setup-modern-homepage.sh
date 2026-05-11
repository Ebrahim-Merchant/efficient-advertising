#!/bin/bash

# Modern Homepage Setup Script
# This script helps set up the new modern homepage for Efficient Advertising

echo "═══════════════════════════════════════════════════════"
echo "  Efficient Advertising - Modern Homepage Setup"
echo "═══════════════════════════════════════════════════════"
echo ""

# Colors
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}✓${NC} Modern template files have been created:"
echo "  - page-home-modern.php"
echo "  - header-modern.php"
echo "  - footer-modern.php"
echo ""

echo -e "${BLUE}ℹ${NC} Next Steps:"
echo ""
echo "1. Go to WordPress Admin Dashboard"
echo "   URL: http://localhost:10004/wp-admin"
echo ""
echo "2. Create a New Page:"
echo "   → Pages → Add New"
echo "   → Title: 'Home Modern' or 'Homepage'"
echo "   → Template: Select 'Modern Home (Tailwind)'"
echo "   → Click 'Publish'"
echo ""
echo "3. Set as Homepage:"
echo "   → Settings → Reading"
echo "   → Select 'A static page'"
echo "   → Homepage: Choose your new page"
echo "   → Save Changes"
echo ""
echo "4. Preview your new homepage!"
echo ""

echo -e "${YELLOW}⚠${NC} Important Notes:"
echo ""
echo "• The template uses Tailwind CSS from CDN"
echo "• Make sure your theme options are configured"
echo "• Update contact info in theme settings"
echo "• Add real product images for best results"
echo ""

echo "═══════════════════════════════════════════════════════"
echo "For detailed instructions, see: MODERN-HOMEPAGE-GUIDE.md"
echo "═══════════════════════════════════════════════════════"
echo ""

# Ask if user wants to open the admin dashboard
read -p "Would you like to open WordPress Admin now? (y/n): " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "Opening WordPress Admin..."
    open "http://localhost:10004/wp-admin" 2>/dev/null || xdg-open "http://localhost:10004/wp-admin" 2>/dev/null || echo "Please open http://localhost:10004/wp-admin manually"
fi

echo ""
echo -e "${GREEN}Setup complete!${NC} Happy designing! 🎨"
