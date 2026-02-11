<?php
/**
 * Local Product Scraper Test
 * 
 * This script scrapes products from mprinthouse.ae and saves the data locally
 * without any WordPress or AI dependencies. Perfect for testing!
 * 
 * Usage: php test-scraper-local.php
 * Output: Saves data to scraped-products.json
 */

error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

class LocalProductScraper {
    private $source_url;
    private $products = array();
    private $errors = array();
    
    public function __construct( $source_url = 'https://mprinthouse.ae/' ) {
        $this->source_url = $source_url;
        $this->log( '🎯 Local Product Scraper Started', 'title' );
        $this->log( 'Target: ' . $this->source_url );
    }
    
    /**
     * Colored console output
     */
    private function log( $message, $type = 'info' ) {
        $timestamp = date( 'H:i:s' );
        
        switch ( $type ) {
            case 'title':
                echo "\n\033[44;37m ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ \033[0m\n";
                echo "\033[1;36m $message \033[0m\n";
                echo "\033[44;37m ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ \033[0m\n\n";
                break;
            case 'success':
                echo "\033[0;32m✓ [$timestamp] $message\033[0m\n";
                break;
            case 'error':
                echo "\033[0;31m✗ [$timestamp] ERROR: $message\033[0m\n";
                $this->errors[] = $message;
                break;
            case 'warning':
                echo "\033[1;33m⚠ [$timestamp] WARNING: $message\033[0m\n";
                break;
            case 'info':
                echo "\033[0;36mℹ [$timestamp] $message\033[0m\n";
                break;
            case 'product':
                echo "\033[1;35m  📦 $message\033[0m\n";
                break;
            case 'data':
                echo "\033[0;33m     $message\033[0m\n";
                break;
        }
    }
    
    /**
     * Fetch URL without WordPress
     */
    private function fetch_url( $url ) {
        $this->log( 'Fetching: ' . $url, 'info' );
        
        // Use cURL if available, otherwise file_get_contents
        if ( function_exists( 'curl_init' ) ) {
            return $this->fetch_with_curl( $url );
        } else {
            return $this->fetch_with_file_get_contents( $url );
        }
    }
    
    /**
     * Fetch using cURL
     */
    private function fetch_with_curl( $url ) {
        $ch = curl_init();
        curl_setopt_array( $ch, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ) );
        
        $response = curl_exec( $ch );
        $error = curl_error( $ch );
        curl_close( $ch );
        
        if ( $error ) {
            $this->log( 'cURL error: ' . $error, 'error' );
            return null;
        }
        
        return $response;
    }
    
    /**
     * Fetch using file_get_contents
     */
    private function fetch_with_file_get_contents( $url ) {
        $context = stream_context_create( array(
            'http' => array(
                'timeout' => 15,
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            ),
        ) );
        
        $response = @file_get_contents( $url, false, $context );
        
        if ( $response === false ) {
            $this->log( 'Failed to fetch URL', 'error' );
            return null;
        }
        
        return $response;
    }
    
    /**
     * Main scraping function
     */
    public function scrape() {
        $html = $this->fetch_url( $this->source_url );
        
        if ( ! $html ) {
            $this->log( 'Failed to fetch website', 'error' );
            return false;
        }
        
        $this->log( 'HTML fetched successfully (' . strlen( $html ) . ' bytes)', 'success' );
        
        // Parse HTML
        $dom = new DOMDocument();
        @$dom->loadHTML( $html );
        $xpath = new DOMXPath( $dom );
        
        $this->log( 'Analyzing HTML structure...', 'info' );
        
        // Try multiple product selectors
        $selectors = array(
            '//div[contains(@class, "product")]',
            '//div[@class="product-item"]',
            '//li[contains(@class, "product")]',
            '//article[contains(@class, "product")]',
            '//div[contains(@class, "item")]',
            '//div[@data-product-id]',
        );
        
        $product_elements = null;
        $used_selector = null;
        
        foreach ( $selectors as $selector ) {
            $results = $xpath->query( $selector );
            if ( $results && $results->length > 0 ) {
                $product_elements = $results;
                $used_selector = $selector;
                $this->log( 'Found ' . $results->length . ' products with selector: ' . $selector, 'success' );
                break;
            }
        }
        
        if ( ! $product_elements || $product_elements->length === 0 ) {
            $this->log( 'No products found with default selectors', 'warning' );
            $this->log( 'Trying generic selectors...', 'info' );
            
            // Try very generic selectors
            $generic_selectors = array(
                '//div',
                '//section',
                '//article',
            );
            
            foreach ( $generic_selectors as $selector ) {
                $results = $xpath->query( $selector );
                if ( $results && $results->length > 5 ) {
                    $this->log( 'Found ' . $results->length . ' ' . str_replace( '//', '', $selector ) . ' elements', 'info' );
                }
            }
            
            return false;
        }
        
        $this->log( 'Processing ' . $product_elements->length . ' products...', 'info' );
        
        // Extract product data
        foreach ( $product_elements as $element ) {
            $product = $this->extract_product_data( $element, $xpath );
            if ( $product ) {
                $this->products[] = $product;
            }
        }
        
        $this->log( 'Successfully extracted ' . count( $this->products ) . ' products', 'success' );
        return true;
    }
    
    /**
     * Extract product data
     */
    private function extract_product_data( $element, $xpath ) {
        $product = array();
        
        // Try to extract name
        $name_selectors = array(
            './/h2',
            './/h3',
            './/h1',
            './/a[@href]',
            './/span[@class="name"]',
            './/*[@data-name]',
        );
        
        foreach ( $name_selectors as $selector ) {
            $node = $xpath->query( $selector, $element )->item( 0 );
            if ( $node ) {
                $name = trim( $node->textContent );
                if ( ! empty( $name ) && strlen( $name ) > 2 ) {
                    $product['name'] = $name;
                    break;
                }
            }
        }
        
        if ( empty( $product['name'] ) ) {
            return null;
        }
        
        // Extract price
        $price_selectors = array(
            './/span[contains(@class, "price")]',
            './/span[@class="amount"]',
            './/strong[contains(text(), "$") or contains(text(), "AED")]',
            './/em',
            '//span[contains(., "$") or contains(., "AED")]',
        );
        
        foreach ( $price_selectors as $selector ) {
            $node = $xpath->query( $selector, $element )->item( 0 );
            if ( $node ) {
                $price_text = trim( $node->textContent );
                if ( preg_match( '/[\d.]+/', $price_text, $matches ) ) {
                    $product['price'] = $matches[0];
                    break;
                }
            }
        }
        
        // Extract description
        $desc_selectors = array(
            './/p',
            './/div[@class="description"]',
            './/span[@class="description"]',
            '//following-sibling::p',
        );
        
        foreach ( $desc_selectors as $selector ) {
            $node = $xpath->query( $selector, $element )->item( 0 );
            if ( $node ) {
                $desc = trim( $node->textContent );
                if ( ! empty( $desc ) && strlen( $desc ) > 5 ) {
                    $product['description'] = $desc;
                    break;
                }
            }
        }
        
        // Extract image URL
        $img_selectors = array(
            './/img[@src]',
            './/img[@data-src]',
            './/picture//img',
        );
        
        foreach ( $img_selectors as $selector ) {
            $node = $xpath->query( $selector, $element )->item( 0 );
            if ( $node ) {
                $img_url = $node->getAttribute( 'src' );
                if ( ! $img_url ) {
                    $img_url = $node->getAttribute( 'data-src' );
                }
                if ( ! empty( $img_url ) ) {
                    $product['image_url'] = $this->make_absolute_url( $img_url );
                    break;
                }
            }
        }
        
        // Extract product URL
        $link_selectors = array(
            './/a[@href]',
            './/a[contains(@class, "product")]',
        );
        
        foreach ( $link_selectors as $selector ) {
            $node = $xpath->query( $selector, $element )->item( 0 );
            if ( $node ) {
                $href = $node->getAttribute( 'href' );
                if ( ! empty( $href ) ) {
                    $product['url'] = $this->make_absolute_url( $href );
                    break;
                }
            }
        }
        
        return $product;
    }
    
    /**
     * Make URL absolute
     */
    private function make_absolute_url( $url ) {
        if ( filter_var( $url, FILTER_VALIDATE_URL ) ) {
            return $url;
        }
        
        if ( strpos( $url, '/' ) === 0 ) {
            $parts = parse_url( $this->source_url );
            return $parts['scheme'] . '://' . $parts['host'] . $url;
        } else {
            return rtrim( $this->source_url, '/' ) . '/' . $url;
        }
    }
    
    /**
     * Display results
     */
    public function display_results() {
        $this->log( count( $this->products ) . ' Products Found', 'title' );
        
        if ( empty( $this->products ) ) {
            $this->log( 'No products to display', 'warning' );
            return;
        }
        
        foreach ( $this->products as $index => $product ) {
            echo "\n";
            echo "\033[1;36m" . ( $index + 1 ) . ". " . $product['name'] . "\033[0m\n";
            
            if ( ! empty( $product['price'] ) ) {
                echo "\033[0;33m   Price: " . $product['price'] . "\033[0m\n";
            }
            
            if ( ! empty( $product['description'] ) ) {
                $desc = substr( $product['description'], 0, 100 );
                echo "\033[0;37m   Desc: " . $desc . ( strlen( $product['description'] ) > 100 ? '...' : '' ) . "\033[0m\n";
            }
            
            if ( ! empty( $product['image_url'] ) ) {
                echo "\033[0;35m   Image: " . $product['image_url'] . "\033[0m\n";
            }
            
            if ( ! empty( $product['url'] ) ) {
                echo "\033[0;34m   URL: " . $product['url'] . "\033[0m\n";
            }
        }
    }
    
    /**
     * Save to JSON file
     */
    public function save_to_json( $filename = 'scraped-products.json' ) {
        $data = array(
            'timestamp'      => date( 'Y-m-d H:i:s' ),
            'source_url'     => $this->source_url,
            'total_products' => count( $this->products ),
            'products'       => $this->products,
            'errors'         => $this->errors,
        );
        
        $json = json_encode( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
        
        if ( file_put_contents( $filename, $json ) ) {
            $this->log( 'Data saved to: ' . $filename, 'success' );
            $this->log( 'File size: ' . filesize( $filename ) . ' bytes', 'info' );
            return true;
        } else {
            $this->log( 'Failed to save to: ' . $filename, 'error' );
            return false;
        }
    }
    
    /**
     * Export to CSV
     */
    public function save_to_csv( $filename = 'scraped-products.csv' ) {
        if ( empty( $this->products ) ) {
            $this->log( 'No products to export', 'warning' );
            return false;
        }
        
        $fp = fopen( $filename, 'w' );
        
        // Write header
        $headers = array_keys( $this->products[0] );
        fputcsv( $fp, $headers );
        
        // Write data
        foreach ( $this->products as $product ) {
            fputcsv( $fp, $product );
        }
        
        fclose( $fp );
        
        $this->log( 'Data exported to: ' . $filename, 'success' );
        return true;
    }
    
    /**
     * Get products
     */
    public function get_products() {
        return $this->products;
    }
    
    /**
     * Get product count
     */
    public function get_count() {
        return count( $this->products );
    }
}

// ============================================================================
// MAIN EXECUTION
// ============================================================================

$scraper = new LocalProductScraper( 'https://mprinthouse.ae/' );

// Run scraping
if ( $scraper->scrape() ) {
    // Display results in terminal
    $scraper->display_results();
    
    // Save to files
    $scraper->save_to_json( 'scraped-products.json' );
    $scraper->save_to_csv( 'scraped-products.csv' );
    
    echo "\n";
    $scraper->log( count( $scraper->get_products() ) . ' products extracted successfully!', 'success' );
    echo "\n";
} else {
    $scraper->log( 'Scraping failed', 'error' );
    echo "\n";
    exit( 1 );
}
