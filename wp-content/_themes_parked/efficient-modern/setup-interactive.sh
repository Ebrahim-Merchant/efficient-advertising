#!/bin/bash

# =============================================================================
# PRODUCT SCRAPER - START HERE!
# =============================================================================
# This script will walk you through the entire setup process interactively.
# Just run: bash setup-interactive.sh
# =============================================================================

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Banner
print_banner() {
    clear
    echo -e "${BLUE}"
    echo "╔════════════════════════════════════════════════════════════════╗"
    echo "║                                                                ║"
    echo "║           🎯 PRODUCT SCRAPER - INTERACTIVE SETUP 🎯            ║"
    echo "║                                                                ║"
    echo "║              Scrape Products from mprinthouse.ae              ║"
    echo "║              Optimize with AI for Your WordPress             ║"
    echo "║                                                                ║"
    echo "╚════════════════════════════════════════════════════════════════╝"
    echo -e "${NC}"
}

# Helper functions
print_step() {
    echo -e "\n${GREEN}▶ $1${NC}"
}

print_info() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

# Start
print_banner

# Step 1: Check Prerequisites
print_step "Step 1: Checking Prerequisites"
echo ""

# Check PHP
if command -v php &> /dev/null; then
    PHP_VERSION=$(php -v | head -n 1)
    print_success "PHP is installed: $PHP_VERSION"
else
    print_error "PHP is not installed. Please install PHP first."
    exit 1
fi

# Check Python
if command -v python3 &> /dev/null; then
    PYTHON_VERSION=$(python3 --version 2>&1)
    print_success "Python 3 is installed: $PYTHON_VERSION"
else
    print_warning "Python 3 not found. Some debugging tools won't work."
fi

# Step 2: OpenAI API Key
print_step "Step 2: OpenAI API Key Configuration"
echo ""
print_info "You need an OpenAI API key for AI optimization."
print_info "Get one at: https://platform.openai.com/api-keys"
echo ""

if [ -z "$OPENAI_API_KEY" ]; then
    print_warning "OPENAI_API_KEY environment variable is not set"
    echo ""
    read -p "Do you want to set it now? (y/n) " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        read -p "Enter your OpenAI API key (starting with 'sk-'): " api_key
        if [[ $api_key == sk-* ]]; then
            export OPENAI_API_KEY="$api_key"
            print_success "API key set temporarily for this session"
            echo ""
            echo "To make it permanent, add this line to your ~/.zshrc:"
            echo "  export OPENAI_API_KEY='$api_key'"
            echo ""
            read -p "Should I add it to ~/.zshrc? (y/n) " -n 1 -r
            echo
            if [[ $REPLY =~ ^[Yy]$ ]]; then
                echo "export OPENAI_API_KEY='$api_key'" >> ~/.zshrc
                print_success "Added to ~/.zshrc"
            fi
        else
            print_error "Invalid API key format (must start with 'sk-')"
            exit 1
        fi
    else
        print_warning "Skipping AI optimization setup (you can run without it)"
    fi
else
    print_success "OpenAI API key is configured: ${OPENAI_API_KEY:0:10}..."
fi

# Step 3: Validate Configuration
print_step "Step 3: Validating Configuration"
echo ""

# Check if scripts exist
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

if [ -f "$SCRIPT_DIR/product-scraper.php" ]; then
    print_success "Found product-scraper.php"
else
    print_error "product-scraper.php not found"
    exit 1
fi

if [ -f "$SCRIPT_DIR/scraper-cli.py" ]; then
    print_success "Found scraper-cli.py"
else
    print_error "scraper-cli.py not found"
    exit 1
fi

# Step 4: Website Inspection
print_step "Step 4: Website Structure Inspection"
echo ""
print_info "Let's analyze the target website structure..."
echo ""

read -p "Run website inspection? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    if command -v python3 &> /dev/null; then
        python3 "$SCRIPT_DIR/scraper-cli.py" inspect-website
    else
        print_warning "Python 3 not available, skipping inspection"
    fi
fi

# Step 5: Configuration Review
print_step "Step 5: Configuration Review"
echo ""
print_info "Current configuration:"
echo ""
echo "  Source URL: https://mprinthouse.ae/"
echo "  Company Name: Efficient Advertising"
echo "  Post Status: draft (manually review before publishing)"
echo "  Download Images: Yes"
echo "  AI Optimization: $([ -n "$OPENAI_API_KEY" ] && echo 'Enabled' || echo 'Disabled')"
echo ""

read -p "Edit configuration? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    if [ -f "$SCRIPT_DIR/scraper-config.php" ]; then
        nano "$SCRIPT_DIR/scraper-config.php"
        print_success "Configuration updated"
    else
        print_error "Configuration file not found"
    fi
fi

# Step 6: Ready to Run
print_step "Step 6: Ready to Run!"
echo ""
print_info "Everything is configured and ready to go!"
echo ""

read -p "Run the scraper now? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo ""
    print_step "Running Product Scraper..."
    echo ""
    cd "$SCRIPT_DIR/../.."
    php "$SCRIPT_DIR/product-scraper.php"
    
    echo ""
    print_step "Scraper Completed!"
    echo ""
    print_info "Next steps:"
    echo "  1. Go to WordPress Admin: http://localhost:3000/wp-admin"
    echo "  2. Navigate to Posts or Products"
    echo "  3. Filter by 'Draft' status"
    echo "  4. Review newly scraped products"
    echo "  5. Edit and publish when ready"
else
    echo ""
    print_info "To run the scraper manually, execute:"
    echo "  cd $SCRIPT_DIR"
    echo "  ./run-scraper.sh"
fi

# Step 7: Additional Help
print_step "Step 7: Need Help?"
echo ""
echo "Documentation files in this directory:"
echo "  • QUICK-START.md ..................... 5-minute quick start"
echo "  • SCRAPER-README.md ................. Complete documentation"
echo "  • SETUP-SUMMARY.md .................. Full feature summary"
echo "  • SELECTOR-DEBUG-GUIDE.md ........... Finding CSS selectors"
echo ""
echo "Available CLI commands:"
echo "  python3 scraper-cli.py inspect-website .... Analyze website"
echo "  python3 scraper-cli.py test-selectors .... Test CSS selectors"
echo "  python3 scraper-cli.py validate-config .. Check configuration"
echo "  python3 scraper-cli.py stats ............ Website statistics"
echo ""

read -p "Would you like to see any documentation? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo ""
    echo "Available documentation:"
    echo "  1. QUICK-START.md"
    echo "  2. SCRAPER-README.md"
    echo "  3. SETUP-SUMMARY.md"
    echo "  4. SELECTOR-DEBUG-GUIDE.md"
    echo ""
    read -p "Enter number (1-4) or press Enter to skip: " doc_choice
    
    case $doc_choice in
        1) less "$SCRIPT_DIR/QUICK-START.md" ;;
        2) less "$SCRIPT_DIR/SCRAPER-README.md" ;;
        3) less "$SCRIPT_DIR/SETUP-SUMMARY.md" ;;
        4) less "$SCRIPT_DIR/SELECTOR-DEBUG-GUIDE.md" ;;
    esac
fi

print_banner
print_success "Setup Complete! Happy Scraping! 🚀"
echo ""
