<?php
/**
 * Selector Debugging & Finding Guide
 * 
 * If products aren't being scraped, the CSS/XPath selectors need to be updated.
 * This file explains how to find the correct selectors for the target website.
 */

/**
 * STEP 1: Manual Website Inspection
 * 
 * 1. Open https://mprinthouse.ae/ in your browser
 * 2. Right-click on a product element
 * 3. Select "Inspect" or press F12
 * 4. Look at the HTML structure
 * 
 * You're looking for patterns like:
 * - <div class="product">
 * - <div class="item">
 * - <section class="product-card">
 * - <article class="listing">
 */

/**
 * STEP 2: Understanding XPath Selectors
 * 
 * XPath is used to find elements in HTML. Here are common patterns:
 */

$xpath_examples = array(
    
    // Basic element selection
    './/div'                           => 'Select any div element',
    './/div[@class="product"]'         => 'Select div with class="product"',
    './/div[@id="product-1"]'          => 'Select div with id="product-1"',
    
    // Class matching
    './/div[contains(@class, "product")]'        => 'Select div containing "product" in class',
    './/div[contains(@class, "product") and contains(@class, "featured")]' => 'Multiple class matching',
    
    // Attribute matching
    './/a[@href]'                      => 'Select any link with href',
    './/img[@src]'                     => 'Select any image with src',
    './/span[contains(@data-price, "")]' => 'Select span with data-price attribute',
    
    // Text content
    './/h2[contains(text(), "Price")]' => 'Select h2 containing text "Price"',
    
    // Hierarchical
    './/div[@class="product"]//img'    => 'Select img inside product div',
    './following-sibling::p'           => 'Select next p sibling',
    './ancestor::div[@class="container"]' => 'Select ancestor div with class',
    
    // Indexing
    './/div[@class="product"][1]'      => 'First product div',
    './/div[@class="product"][position() > 1]' => 'All but first product',
    
    // Combined conditions
    './/div[@class="product" and @data-active="true"]' => 'Multiple conditions',
);

/**
 * STEP 3: Common Website Structures
 * 
 * Different websites use different patterns. Try these based on what you find:
 */

$common_patterns = array(
    
    // E-commerce style
    array(
        'wrapper'     => './/div[@class="product-item"]',
        'name'        => './/h2[@class="product-title"]',
        'price'       => './/span[@class="price"]',
        'description' => './/p[@class="product-desc"]',
        'image'       => './/img[@class="product-image"]',
        'link'        => './/a[@class="product-link"]',
    ),
    
    // Blog style
    array(
        'wrapper'     => './/article[@class="post"]',
        'name'        => './/h2[@class="entry-title"]',
        'price'       => './/span[contains(@class, "price")]',
        'description' => './/div[@class="entry-content"]',
        'image'       => './/img[@class="attachment-large"]',
        'link'        => './/h2//a',
    ),
    
    // Grid layout
    array(
        'wrapper'     => './/div[@class="grid-item"]',
        'name'        => './/a[@class="item-name"]',
        'price'       => './/span[@class="item-price"]',
        'description' => './/span[@class="item-description"]',
        'image'       => './/img[1]',
        'link'        => './/a[1]',
    ),
    
    // List style
    array(
        'wrapper'     => './/li[@class="product-listing"]',
        'name'        => './/h3',
        'price'       => './/strong[contains(text(), "$")]',
        'description' => './/p',
        'image'       => './/img[@src]',
        'link'        => './/a[@href]',
    ),
);

/**
 * STEP 4: Browser Console Testing
 * 
 * You can test XPath selectors in your browser's console:
 * 
 * 1. Open browser DevTools (F12)
 * 2. Go to Console tab
 * 3. Run these commands:
 */

$browser_console_tests = array(
    
    // JavaScript XPath test
    "document.evaluate('.//div[@class=\"product\"]', document, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null).snapshotLength",
    
    // jQuery test (if available)
    "$('.product').length",
    
    // Get first product element
    "document.querySelector('.product')",
    
    // Get all product elements
    "document.querySelectorAll('.product')",
);

/**
 * STEP 5: Debugging Script
 * 
 * If you need to debug, create a temporary PHP script:
 */

$debugging_script = <<<'PHP'
<?php
// Save this as debug-scraper.php in your theme directory

$source_url = 'https://mprinthouse.ae/';

// Fetch the HTML
$response = wp_remote_get( $source_url, array(
    'timeout'   => 15,
    'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
) );

if ( is_wp_error( $response ) ) {
    die( 'Error fetching URL: ' . $response->get_error_message() );
}

$html = wp_remote_retrieve_body( $response );

// Load HTML
$dom = new DOMDocument();
@$dom->loadHTML( $html );
$xpath = new DOMXPath( $dom );

// Test different selectors
$selectors = array(
    'div with class product'         => '//div[@class="product"]',
    'div containing product class'   => '//div[contains(@class, "product")]',
    'any h2 in document'             => '//h2',
    'any product-like div'           => '//div[contains(@class, "item") or contains(@class, "product")]',
    'all images'                     => '//img',
    'all prices'                     => '//span[contains(@class, "price")]',
);

echo "<h2>Selector Testing Results</h2>";
foreach ( $selectors as $description => $selector ) {
    $results = $xpath->query( $selector );
    echo "<p><strong>$description</strong><br>";
    echo "Selector: <code>$selector</code><br>";
    echo "Found: {$results->length} elements<br>";
    
    if ( $results->length > 0 ) {
        $first = $results->item( 0 );
        echo "First element: <code>" . htmlspecialchars( substr( $dom->saveHTML( $first ), 0, 100 ) ) . "...</code>";
    }
    echo "</p>";
}

// Try to find product containers
echo "<h2>Product Container Analysis</h2>";
$test_selectors = array(
    '//div[@class="product"]',
    '//div[contains(@class, "product")]',
    '//li[contains(@class, "product")]',
    '//article[contains(@class, "product")]',
    '//div[@class="item"]',
    '//div[contains(@class, "item")]',
);

foreach ( $test_selectors as $selector ) {
    $results = $xpath->query( $selector );
    if ( $results->length > 0 ) {
        echo "<p style='background:#efe; padding:10px;'>";
        echo "<strong style='color:green;'>✓ FOUND!</strong> ";
        echo "Selector: <code>$selector</code> - Found {$results->length} elements";
        echo "</p>";
    }
}
?>
PHP;

/**
 * STEP 6: Updating the Scraper
 * 
 * Once you've found the correct selectors, update them in product-scraper.php:
 * 
 * Example: If you found products in <div class="item">
 * 
 * OLD:
 * $product_elements = $xpath->query( '//div[contains(@class, "product")]' );
 * 
 * NEW:
 * $product_elements = $xpath->query( '//div[@class="item"]' );
 */

/**
 * STEP 7: Common Issues & Solutions
 */

$troubleshooting = array(
    
    'No products found' => array(
        'causes' => array(
            '1. Wrong CSS class/selector used',
            '2. Website uses dynamic JavaScript loading',
            '3. Products are in an iframe',
            '4. Website structure changed',
        ),
        'solutions' => array(
            'Inspect HTML with browser DevTools',
            'Use browser console to test selectors',
            'Check if website uses JavaScript frameworks (Vue, React, etc)',
            'Look for data-* attributes instead of classes',
            'Try more generic selectors like //div or //article',
        ),
    ),
    
    'Getting partial data' => array(
        'causes' => array(
            'Selector finds container but not specific field',
            'Multiple elements with same class',
            'Lazy-loaded content not in initial HTML',
        ),
        'solutions' => array(
            'Be more specific with nested selectors',
            'Use position() to target specific element',
            'Check for data-* attributes with actual values',
            'Inspect the exact HTML structure carefully',
        ),
    ),
    
    'Images not downloading' => array(
        'causes' => array(
            'Image URL is relative or encoded',
            'Image uses lazy-loading (data-src instead of src)',
            'Website blocks image downloads',
        ),
        'solutions' => array(
            'Check for both src and data-src attributes',
            'Convert relative URLs to absolute',
            'Add User-Agent header to requests',
            'Check website terms of service',
        ),
    ),
);

/**
 * STEP 8: XPath Quick Reference
 * 
 * Common XPath syntax:
 */

$xpath_reference = array(
    
    // Operators
    'and'       => 'Both conditions must be true',
    'or'        => 'Either condition can be true',
    'not()'     => 'Negation',
    '|'         => 'Union (multiple expressions)',
    
    // Functions
    'text()'    => 'Text content of element',
    'count()'   => 'Count matching elements',
    'contains()' => 'Check if text contains',
    'starts-with()' => 'Check if text starts with',
    'ends-with()' => 'Check if text ends with',
    'substring()' => 'Extract substring',
    
    // Axis
    './'        => 'Child elements',
    './/'       => 'Child elements at any depth',
    '../'       => 'Parent element',
    '@'         => 'Attribute',
    'following-sibling::' => 'Next sibling',
    'preceding-sibling::' => 'Previous sibling',
    'ancestor::' => 'Any ancestor element',
    'descendant::' => 'Any descendant element',
);

/**
 * PRACTICAL EXAMPLES FOR MPRINTHOUSE.AE
 * 
 * If the default selectors don't work on mprinthouse.ae,
 * try these based on common UAE ecommerce patterns:
 */

$mprinthouse_examples = array(
    
    // If it's a Shopify store
    array(
        'type' => 'Shopify',
        'wrapper' => '//div[@class="product-item"] | //div[contains(@class, "ProductItem")]',
        'name' => './/a[@class="product-name"] | .//h2',
        'price' => './/span[@class="price"] | .//span[contains(@class, "money")]',
    ),
    
    // If it's a WooCommerce store
    array(
        'type' => 'WooCommerce',
        'wrapper' => '//div[@class="product"]',
        'name' => './/h2[@class="woocommerce-loop-product__title"]',
        'price' => './/span[@class="woocommerce-Price-amount"]',
    ),
    
    // If it's a custom build
    array(
        'type' => 'Custom E-commerce',
        'wrapper' => '//div[@class="product-card"] | //div[@data-product-id]',
        'name' => './/h3 | .//a[@class="product-link"]',
        'price' => './/span[@data-price] | .//strong[contains(text(), "AED")]',
    ),
);

/**
 * FINAL DEBUGGING CHECKLIST
 */

$debugging_checklist = <<<'CHECKLIST'
□ Website loads without errors (check with curl or browser)
□ Selectors tested in browser console (shows matching elements)
□ Product containers found correctly
□ Product names, prices, images located in containers
□ Image URLs are absolute (not relative)
□ No JavaScript errors in browser console
□ No rate limiting (try with delays between requests)
□ Correct User-Agent header set
□ File permissions on wp-content/uploads are correct
□ WordPress media upload functioning
□ OpenAI API key is valid
CHECKLIST;
CHECKLIST;

echo $debugging_checklist;
?>

## Quick Test

To quickly test if selectors work, add this to your theme:

```php
// debug-selectors.php in your theme directory
<?php
$html = wp_remote_get( 'https://mprinthouse.ae/', array( 'timeout' => 15 ) );
$dom = new DOMDocument();
@$dom->loadHTML( wp_remote_retrieve_body( $html ) );
$xpath = new DOMXPath( $dom );

// Test your selector
$results = $xpath->query( '//div[contains(@class, "product")]' );
echo "Found: " . $results->length . " products";
?>
```

## Contact

If you can't find the right selectors:
1. Save the website HTML to a file
2. Open in browser and inspect elements carefully
3. Note down the exact class names and attributes
4. Test XPath in browser console
5. Update selectors in product-scraper.php
