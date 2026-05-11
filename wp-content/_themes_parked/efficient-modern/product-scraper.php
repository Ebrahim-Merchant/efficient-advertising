<?php
/**
 * Product Scraper and AI Optimizer
 * 
 * This script scrapes products from mprinthouse.ae and adds them to your WordPress site
 * with AI-optimized content for SEO.
 * 
 * Usage: php product-scraper.php
 */

// Load WordPress
require_once( dirname( __FILE__ ) . '/../../wp-load.php' );

// Configuration
$config = array(
    'source_url'      => 'https://mprinthouse.ae/',
    'wp_rest_base'    => home_url( '/wp-json/wp/v2/' ),
    'company_name'    => 'Efficient Advertising', // Change this to your company name
    'openai_api_key'  => getenv( 'OPENAI_API_KEY' ), // Set this environment variable or update here
    'admin_user_id'   => 1, // WordPress admin user ID
);

/**
 * Main scraper class
 */
class ProductScraper {
    private $config;
    private $existing_products = array();
    private $scraped_products = array();
    
    public function __construct( $config ) {
        $this->config = $config;
        $this->log( 'Product Scraper initialized' );
    }
    
    /**
     * Log messages
     */
    private function log( $message, $type = 'info' ) {
        $timestamp = date( 'Y-m-d H:i:s' );
        echo "[{$timestamp}] [{$type}] {$message}\n";
    }
    
    /**
     * Run the entire process
     */
    public function run() {
        try {
            $this->log( 'Starting product scraping process...' );
            
            // Step 1: Get existing products from WordPress
            $this->get_existing_products();
            
            // Step 2: Scrape products from source website
            $this->scrape_products();
            
            // Step 3: Find missing products
            $missing = $this->find_missing_products();
            
            if ( empty( $missing ) ) {
                $this->log( 'No missing products found.' );
                return;
            }
            
            $this->log( 'Found ' . count( $missing ) . ' missing products' );
            
            // Step 4: Process each missing product
            foreach ( $missing as $product ) {
                $this->process_product( $product );
            }
            
            $this->log( 'Product scraping completed successfully!' );
            
        } catch ( Exception $e ) {
            $this->log( 'Error: ' . $e->getMessage(), 'error' );
        }
    }
    
    /**
     * Get existing products from WordPress
     */
    private function get_existing_products() {
        $this->log( 'Fetching existing products from WordPress...' );
        
        try {
            // Get WooCommerce products if available
            $products = get_posts( array(
                'post_type'      => 'product',
                'posts_per_page' => -1,
                'fields'         => 'ids',
            ) );
            
            foreach ( $products as $product_id ) {
                $product = wc_get_product( $product_id );
                if ( $product ) {
                    $this->existing_products[ $product->get_name() ] = $product_id;
                }
            }
            
            $this->log( 'Found ' . count( $this->existing_products ) . ' existing products' );
            
        } catch ( Exception $e ) {
            $this->log( 'Warning: Could not fetch WooCommerce products. ' . $e->getMessage(), 'warning' );
        }
    }
    
    /**
     * Scrape products from source website
     */
    private function scrape_products() {
        $this->log( 'Scraping products from ' . $this->config['source_url'] );
        
        $html = $this->fetch_url( $this->config['source_url'] );
        
        if ( ! $html ) {
            throw new Exception( 'Failed to fetch source website' );
        }
        
        $dom = new DOMDocument();
        @$dom->loadHTML( $html );
        $xpath = new DOMXPath( $dom );
        
        // Adjust these selectors based on the actual website structure
        // You may need to inspect the website to get the correct selectors
        $product_elements = $xpath->query( '//div[contains(@class, "product")]' );
        
        $this->log( 'Found ' . $product_elements->length . ' product elements' );
        
        foreach ( $product_elements as $element ) {
            $product_data = $this->extract_product_data( $element, $xpath );
            
            if ( $product_data ) {
                $this->scraped_products[] = $product_data;
            }
        }
        
        $this->log( 'Successfully scraped ' . count( $this->scraped_products ) . ' products' );
    }
    
    /**
     * Extract product data from HTML element
     */
    private function extract_product_data( $element, $xpath ) {
        $product_data = array();
        
        // Extract product name
        $name_node = $xpath->query( './/h2[contains(@class, "product-name")] | .//h3 | .//a[@class="product-link"]', $element )->item( 0 );
        if ( $name_node ) {
            $product_data['name'] = trim( $name_node->textContent );
        } else {
            return null;
        }
        
        // Extract product price
        $price_node = $xpath->query( './/span[contains(@class, "price")] | .//span[@class="product-price"]', $element )->item( 0 );
        if ( $price_node ) {
            $price_text = trim( $price_node->textContent );
            $product_data['price'] = $this->extract_price( $price_text );
        }
        
        // Extract product description
        $desc_node = $xpath->query( './/p[contains(@class, "description")] | .//p[@class="product-description"]', $element )->item( 0 );
        if ( $desc_node ) {
            $product_data['description'] = trim( $desc_node->textContent );
        }
        
        // Extract product image
        $img_node = $xpath->query( './/img', $element )->item( 0 );
        if ( $img_node ) {
            $img_url = $img_node->getAttribute( 'src' );
            if ( ! $img_url ) {
                $img_url = $img_node->getAttribute( 'data-src' );
            }
            $product_data['image_url'] = $this->make_absolute_url( $img_url );
        }
        
        // Extract product URL
        $link_node = $xpath->query( './/a[@href]', $element )->item( 0 );
        if ( $link_node ) {
            $product_data['source_url'] = $this->make_absolute_url( $link_node->getAttribute( 'href' ) );
        }
        
        return $product_data;
    }
    
    /**
     * Extract price from text
     */
    private function extract_price( $price_text ) {
        if ( preg_match( '/[\d.]+/', $price_text, $matches ) ) {
            return floatval( $matches[0] );
        }
        return 0;
    }
    
    /**
     * Make URL absolute
     */
    private function make_absolute_url( $url ) {
        if ( filter_var( $url, FILTER_VALIDATE_URL ) ) {
            return $url;
        }
        
        $base_url = $this->config['source_url'];
        if ( strpos( $url, '/' ) === 0 ) {
            $parts = wp_parse_url( $base_url );
            return $parts['scheme'] . '://' . $parts['host'] . $url;
        } else {
            return rtrim( $base_url, '/' ) . '/' . $url;
        }
    }
    
    /**
     * Fetch URL content
     */
    private function fetch_url( $url ) {
        $response = wp_remote_get( $url, array(
            'timeout'   => 15,
            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        ) );
        
        if ( is_wp_error( $response ) ) {
            $this->log( 'Failed to fetch URL: ' . $response->get_error_message(), 'error' );
            return false;
        }
        
        return wp_remote_retrieve_body( $response );
    }
    
    /**
     * Find missing products
     */
    private function find_missing_products() {
        $missing = array();
        
        foreach ( $this->scraped_products as $product ) {
            if ( ! isset( $this->existing_products[ $product['name'] ] ) ) {
                $missing[] = $product;
            }
        }
        
        return $missing;
    }
    
    /**
     * Process and add a single product
     */
    private function process_product( $product ) {
        $this->log( 'Processing product: ' . $product['name'] );
        
        // Step 1: Optimize content with AI
        $optimized = $this->optimize_with_ai( $product );
        
        if ( ! $optimized ) {
            $this->log( 'Failed to optimize product content for: ' . $product['name'], 'warning' );
            $optimized = $product;
        }
        
        // Step 2: Download and upload featured image
        $image_id = null;
        if ( ! empty( $product['image_url'] ) ) {
            $image_id = $this->download_and_upload_image( $product['image_url'], $product['name'] );
        }
        
        // Step 3: Create product
        $product_id = $this->create_product( $optimized, $image_id );
        
        if ( $product_id ) {
            $this->log( 'Successfully added product: ' . $product['name'] . ' (ID: ' . $product_id . ')' );
        } else {
            $this->log( 'Failed to add product: ' . $product['name'], 'error' );
        }
    }
    
    /**
     * Optimize product content with AI (OpenAI)
     */
    private function optimize_with_ai( $product ) {
        if ( empty( $this->config['openai_api_key'] ) ) {
            $this->log( 'OpenAI API key not set. Skipping AI optimization.', 'warning' );
            return null;
        }
        
        $this->log( 'Optimizing content with AI for: ' . $product['name'] );
        
        $prompt = $this->build_optimization_prompt( $product );
        
        $response = $this->call_openai_api( $prompt );
        
        if ( ! $response ) {
            return null;
        }
        
        return $this->parse_ai_response( $product, $response );
    }
    
    /**
     * Build optimization prompt for AI
     */
    private function build_optimization_prompt( $product ) {
        $company_name = $this->config['company_name'];
        
        $prompt = <<<PROMPT
You are an expert SEO copywriter for a digital printing and advertising company called "{$company_name}".

I need you to optimize the following product information for SEO and your website:

Product Name: {$product['name']}
Current Description: {$product['description']}
Price: {$product['price']}

Please provide a JSON response with the following fields:
1. "optimized_title": An SEO-optimized product title (max 60 chars) that includes relevant keywords
2. "optimized_description": A detailed, SEO-optimized product description (100-200 words) that highlights benefits, includes keywords naturally, and mentions {$company_name}
3. "seo_keywords": A comma-separated list of 5-8 relevant SEO keywords

Make sure to:
- Include {$company_name} naturally in the description
- Use keywords related to "digital printing", "advertising", "marketing", and the specific product
- Focus on benefits for businesses and marketing professionals
- Use professional, persuasive language
- Include a call-to-action

Return ONLY valid JSON without any markdown formatting or extra text.
PROMPT;
        
        return $prompt;
    }
    
    /**
     * Call OpenAI API
     */
    private function call_openai_api( $prompt ) {
        $api_url = 'https://api.openai.com/v1/chat/completions';
        
        $request_body = array(
            'model'      => 'gpt-3.5-turbo',
            'messages'   => array(
                array(
                    'role'    => 'user',
                    'content' => $prompt,
                ),
            ),
            'temperature' => 0.7,
            'max_tokens'  => 500,
        );
        
        $response = wp_remote_post( $api_url, array(
            'timeout'   => 30,
            'headers'   => array(
                'Authorization' => 'Bearer ' . $this->config['openai_api_key'],
                'Content-Type'  => 'application/json',
            ),
            'body'      => wp_json_encode( $request_body ),
        ) );
        
        if ( is_wp_error( $response ) ) {
            $this->log( 'OpenAI API error: ' . $response->get_error_message(), 'error' );
            return null;
        }
        
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );
        
        if ( ! isset( $data['choices'][0]['message']['content'] ) ) {
            $this->log( 'Invalid OpenAI response', 'error' );
            return null;
        }
        
        return $data['choices'][0]['message']['content'];
    }
    
    /**
     * Parse AI response
     */
    private function parse_ai_response( $product, $response ) {
        // Try to extract JSON from the response
        $json_match = preg_match( '/\{.*\}/s', $response, $matches );
        
        if ( ! $json_match ) {
            $this->log( 'Could not parse AI response', 'warning' );
            return null;
        }
        
        $ai_data = json_decode( $matches[0], true );
        
        if ( ! $ai_data ) {
            $this->log( 'Invalid JSON in AI response', 'warning' );
            return null;
        }
        
        $product['optimized_title']       = $ai_data['optimized_title'] ?? $product['name'];
        $product['optimized_description'] = $ai_data['optimized_description'] ?? $product['description'];
        $product['seo_keywords']          = $ai_data['seo_keywords'] ?? '';
        
        return $product;
    }
    
    /**
     * Download and upload image
     */
    private function download_and_upload_image( $image_url, $product_name ) {
        $this->log( 'Downloading image for: ' . $product_name );
        
        $image_data = $this->fetch_url( $image_url );
        
        if ( ! $image_data ) {
            $this->log( 'Failed to download image: ' . $image_url, 'warning' );
            return null;
        }
        
        // Create filename
        $filename = sanitize_file_name( $product_name . '-' . time() . '.jpg' );
        
        // Upload to WordPress media library
        $upload = wp_upload_bits( $filename, null, $image_data );
        
        if ( ! empty( $upload['error'] ) ) {
            $this->log( 'Image upload error: ' . $upload['error'], 'warning' );
            return null;
        }
        
        // Create attachment
        $attachment_id = wp_insert_attachment( array(
            'guid'           => $upload['url'],
            'post_mime_type' => 'image/jpeg',
            'post_title'     => $product_name,
            'post_content'   => '',
            'post_status'    => 'inherit',
        ), $upload['file'] );
        
        if ( ! $attachment_id ) {
            $this->log( 'Failed to create attachment', 'error' );
            return null;
        }
        
        // Generate attachment metadata
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        $attach_data = wp_generate_attachment_metadata( $attachment_id, $upload['file'] );
        wp_update_attachment_metadata( $attachment_id, $attach_data );
        
        $this->log( 'Image uploaded successfully (ID: ' . $attachment_id . ')' );
        
        return $attachment_id;
    }
    
    /**
     * Create WordPress product
     */
    private function create_product( $product, $image_id ) {
        $title = $product['optimized_title'] ?? $product['name'];
        $content = $product['optimized_description'] ?? $product['description'];
        
        // Determine post type - product or post
        $post_type = class_exists( 'WooCommerce' ) ? 'product' : 'post';
        
        $post_id = wp_insert_post( array(
            'post_title'    => $title,
            'post_content'  => $content,
            'post_type'     => $post_type,
            'post_status'   => 'draft', // Set to draft for review first
            'post_author'   => $this->config['admin_user_id'],
        ) );
        
        if ( ! $post_id ) {
            return null;
        }
        
        // Set featured image
        if ( $image_id ) {
            set_post_thumbnail( $post_id, $image_id );
        }
        
        // Add meta data
        update_post_meta( $post_id, '_source_url', $product['source_url'] ?? '' );
        update_post_meta( $post_id, '_seo_keywords', $product['seo_keywords'] ?? '' );
        update_post_meta( $post_id, '_product_scraped', true );
        update_post_meta( $post_id, '_scraped_date', current_time( 'mysql' ) );
        
        // If WooCommerce product
        if ( $post_type === 'product' && function_exists( 'wc_get_product' ) ) {
            $wc_product = wc_get_product( $post_id );
            if ( $wc_product ) {
                $wc_product->set_price( $product['price'] ?? 0 );
                $wc_product->save();
            }
        }
        
        return $post_id;
    }
}

// Run the scraper
$scraper = new ProductScraper( $config );
$scraper->run();
