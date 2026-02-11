<?php
/**
 * Product Scraper Configuration
 * 
 * This file contains all configuration options for the product scraper.
 * Edit this file to customize the scraper behavior.
 */

return array(
    
    // ========== BASIC SETTINGS ==========
    
    /**
     * Source website URL to scrape products from
     */
    'source_url' => 'https://mprinthouse.ae/',
    
    /**
     * Your company name (used in AI optimization)
     */
    'company_name' => 'Efficient Advertising',
    
    /**
     * WordPress admin user ID (who will be the post author)
     */
    'admin_user_id' => 1,
    
    
    // ========== AI & API SETTINGS ==========
    
    /**
     * OpenAI API Key
     * Get from: https://platform.openai.com/api-keys
     * 
     * Set via environment variable:
     * export OPENAI_API_KEY='sk-...'
     */
    'openai_api_key' => getenv( 'OPENAI_API_KEY' ),
    
    /**
     * OpenAI Model to use
     * Options: 'gpt-3.5-turbo', 'gpt-4', etc.
     */
    'openai_model' => 'gpt-3.5-turbo',
    
    /**
     * Temperature for AI responses (0.0 - 2.0)
     * Lower = more deterministic, Higher = more creative
     */
    'ai_temperature' => 0.7,
    
    /**
     * Maximum tokens for AI response
     */
    'ai_max_tokens' => 500,
    
    
    // ========== SCRAPING SETTINGS ==========
    
    /**
     * CSS/XPath selectors for products
     * These are used to find products on the target website
     * 
     * You may need to update these based on the website structure
     */
    'selectors' => array(
        // Main product container
        'product_wrapper' => '//div[contains(@class, "product")]',
        
        // Product name/title
        'product_name' => './/h2[contains(@class, "product-name")] | .//h3 | .//a[@class="product-link"]',
        
        // Product price
        'product_price' => './/span[contains(@class, "price")] | .//span[@class="product-price"]',
        
        // Product description
        'product_description' => './/p[contains(@class, "description")] | .//p[@class="product-description"]',
        
        // Product image
        'product_image' => './/img',
        
        // Product URL/link
        'product_link' => './/a[@href]',
    ),
    
    /**
     * Timeout for fetching URLs (in seconds)
     */
    'fetch_timeout' => 15,
    
    /**
     * User agent string
     */
    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
    
    
    // ========== POST SETTINGS ==========
    
    /**
     * Post status for new products
     * Options: 'draft', 'pending', 'publish'
     * 
     * Recommended: 'draft' so you can review before publishing
     */
    'new_post_status' => 'draft',
    
    /**
     * Post type for new products
     * Options: 'post', 'product' (WooCommerce)
     * 
     * Leave empty to auto-detect based on WooCommerce availability
     */
    'post_type' => '',
    
    /**
     * Add content prefix
     * Prepend text to all product descriptions
     */
    'content_prefix' => '',
    
    /**
     * Add content suffix
     * Append text to all product descriptions
     */
    'content_suffix' => '',
    
    
    // ========== IMAGE SETTINGS ==========
    
    /**
     * Download and upload product images
     */
    'download_images' => true,
    
    /**
     * Image quality (1-100)
     */
    'image_quality' => 85,
    
    /**
     * Maximum image width in pixels
     */
    'image_max_width' => 2000,
    
    
    // ========== LOGGING & DEBUG ==========
    
    /**
     * Enable verbose logging
     */
    'verbose_logging' => true,
    
    /**
     * Log file path (set to null for stdout)
     */
    'log_file' => null,
    
    /**
     * Enable debug mode
     */
    'debug_mode' => false,
    
    
    // ========== BATCH PROCESSING ==========
    
    /**
     * Process products in batches
     * Useful for large datasets
     */
    'batch_size' => 0, // 0 = no batching
    
    /**
     * Delay between batch processing (in seconds)
     */
    'batch_delay' => 2,
    
    /**
     * Maximum products to process per run
     */
    'max_products' => 0, // 0 = unlimited
    
    
    // ========== FILTERING ==========
    
    /**
     * Only scrape products matching these keywords
     * Empty array = all products
     */
    'keyword_filter' => array(),
    
    /**
     * Skip products matching these keywords
     * Useful to exclude categories
     */
    'keyword_exclude' => array(),
    
    /**
     * Only import if price is between min and max
     * Set to empty array to disable
     */
    'price_range' => array(
        'min' => 0,
        'max' => 0, // 0 = unlimited
    ),
    
);
