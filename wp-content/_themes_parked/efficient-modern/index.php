<?php
/**
 * The main template file - Homepage (Modern Tailwind Style)
 *
 * Template Name: Home
 *
 * @package Efficient_Modern
 * @since 2.0.0
 */

error_log('INDEX.PHP LOADED - ' . date('H:i:s'));
get_header();
?>

<!-- Hero Carousel Section -->
<?php
// Build carousel slides: up to 7 product categories, one image each (no blank slides)
$_carousel_terms = get_terms( array(
    'taxonomy'   => 'product_category',
    'hide_empty' => true,
    'number'     => 12,
    'orderby'    => 'count',
    'order'      => 'DESC',
) );
$_carousel_slides = array();
if ( ! empty( $_carousel_terms ) && ! is_wp_error( $_carousel_terms ) ) {
    foreach ( $_carousel_terms as $_ct ) {
        // Try WooCommerce category thumbnail first
        $_thumb_id = get_term_meta( $_ct->term_id, 'thumbnail_id', true );
        $_img      = $_thumb_id ? wp_get_attachment_image_url( $_thumb_id, 'large' ) : '';
        // Fallback: first product in category that has a featured image
        if ( ! $_img ) {
            $_products = get_posts( array(
                'post_type'      => 'product',
                'posts_per_page' => 1,
                'tax_query'      => array( array(
                    'taxonomy' => 'product_category',
                    'field'    => 'term_id',
                    'terms'    => $_ct->term_id,
                ) ),
                'meta_query' => array( array(
                    'key'     => '_thumbnail_id',
                    'compare' => 'EXISTS',
                ) ),
            ) );
            if ( ! empty( $_products ) ) {
                $_img = get_the_post_thumbnail_url( $_products[0]->ID, 'large' );
            }
        }
        if ( $_img ) {
            $_carousel_slides[] = array(
                'image' => $_img,
                'title' => html_entity_decode( $_ct->name, ENT_QUOTES, 'UTF-8' ),
                'link'  => get_term_link( $_ct ),
                'count' => $_ct->count,
            );
        }
        if ( count( $_carousel_slides ) >= 7 ) break;
    }
}
?>
<section class="hero-carousel-section" id="heroCarousel">
    <div class="hero-carousel">
        <div class="carousel-track">
            <?php
            $_slide_index = 0;
            foreach ( $_carousel_slides as $_slide ) :
                $_is_first = ( $_slide_index === 0 );
            ?>
            <div class="carousel-slide<?php echo $_is_first ? ' active' : ''; ?>">
                <div class="slide-background">
                    <img
                        src="<?php echo esc_url( $_slide['image'] ); ?>"
                        alt="<?php echo esc_attr( $_slide['title'] ); ?>"
                        loading="<?php echo $_is_first ? 'eager' : 'lazy'; ?>"
                    >
                </div>
                <div class="slide-content">
                    <div class="inline-flex items-center px-4 py-1 rounded-full text-white text-xs font-semibold uppercase tracking-widest mb-6" style="background-color:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.25);">
                        Trusted since 2010 in Dubai
                    </div>
                    <h2 class="slide-title"><?php echo esc_html( $_slide['title'] ); ?></h2>
                    <p class="slide-subtitle"><?php echo esc_html( $_slide['count'] ); ?>+ Premium Products</p>
                    <div class="slide-buttons">
                        <a href="<?php echo esc_url( $_slide['link'] ); ?>" class="btn btn-primary">
                            Shop Now
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                        <a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>" class="btn btn-outline-light">
                            Get a Quote
                        </a>
                    </div>
                </div>
            </div>
            <?php
                $_slide_index++;
            endforeach;
            ?>
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control prev" aria-label="Previous slide">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
        </button>
        <button class="carousel-control next" aria-label="Next slide">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
        </button>

        <!-- Indicators -->
        <div class="carousel-indicators">
            <?php for ( $_i = 0; $_i < count( $_carousel_slides ); $_i++ ) : ?>
            <button class="indicator<?php echo $_i === 0 ? ' active' : ''; ?>" aria-label="Slide <?php echo $_i + 1; ?>"></button>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- Hero Search Bar -->
<div style="background-color: #6B1D2D; padding: 2rem 0;">
    <div class="max-w-5xl mx-auto px-6 text-center">
        <div class="inline-flex items-center px-4 py-1.5 rounded-full text-white border text-xs font-semibold uppercase tracking-widest mb-8" style="background-color: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2);">
            Trusted since 2010 in Dubai
        </div>
        <h1 class="text-5xl md:text-7xl font-black text-white leading-[1.1] mb-8">
            Your <span style="color: #EF4444;">Printing Partner</span> <br> for the Digital Age
        </h1>
        <p class="text-lg md:text-xl text-white max-w-2xl mx-auto mb-12 font-medium leading-relaxed" style="opacity: 0.7;">
            Premium high-quality printing solutions for brands that demand excellence. From large format displays to custom branding packages.
        </p>
        <div class="max-w-2xl mx-auto relative mb-12">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="relative" id="heroSearchForm">
                <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none">
                    <svg class="w-5 h-5" style="color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="search" name="s" id="realtimeSearch" class="w-full pl-16 pr-32 py-5 rounded-2xl bg-white text-slate-900 border-none shadow-2xl text-lg" placeholder="Search for products (e.g. Backdrop, Stickers, PVC)..." style="outline: none;" autocomplete="off">
                <button type="submit" class="absolute right-4 top-1/2 px-6 py-2.5 rounded-xl font-bold text-white transition-colors" style="transform: translateY(-50%); background-color: #6B1D2D;">
                    Search
                </button>
            </form>
            
            <!-- Realtime Search Results Dropdown -->
            <div id="searchResults" class="hidden absolute w-full mt-2 bg-white rounded-2xl shadow-2xl overflow-hidden z-50" style="max-height: 400px; overflow-y: auto;">
                <div id="searchResultsContent" class="p-4"></div>
            </div>
        </div>
        
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('realtimeSearch');
            const searchResults = document.getElementById('searchResults');
            const searchResultsContent = document.getElementById('searchResultsContent');
            let searchTimeout;
            
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                
                // Clear previous timeout
                clearTimeout(searchTimeout);
                
                if (query.length < 2) {
                    searchResults.classList.add('hidden');
                    return;
                }
                
                // Debounce search requests
                searchTimeout = setTimeout(function() {
                    performSearch(query);
                }, 300);
            });
            
            // Close search results when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.add('hidden');
                }
            });
            
            function performSearch(query) {
                searchResultsContent.innerHTML = '<div class="text-center py-4"><svg class="animate-spin h-5 w-5 mx-auto" style="color: #EF4444;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>';
                searchResults.classList.remove('hidden');
                
                // AJAX search request
                fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=realtime_product_search&s=' + encodeURIComponent(query))
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.data.length > 0) {
                            let html = '<div class="divide-y divide-slate-100">';
                            data.data.forEach(product => {
                                html += `
                                    <a href="${product.url}" class="flex items-center gap-4 p-4 hover:bg-slate-50 transition-colors">
                                        ${product.image ? 
                                            `<img src="${product.image}" alt="${product.title}" class="w-16 h-16 object-cover rounded-lg flex-shrink-0">` :
                                            `<div class="w-16 h-16 bg-slate-200 rounded-lg flex-shrink-0 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>`
                                        }
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-slate-900 truncate">${product.title}</h4>
                                            ${product.category ? `<p class="text-sm text-slate-500">${product.category}</p>` : ''}
                                        </div>
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                `;
                            });
                            html += '</div>';
                            
                            if (data.data.length >= 5) {
                                html += `<a href="<?php echo esc_url(home_url('/')); ?>?s=${encodeURIComponent(query)}" class="block text-center py-3 text-sm font-bold text-white hover:opacity-90 transition-opacity" style="background-color: #EF4444;">View All Results</a>`;
                            }
                            
                            searchResultsContent.innerHTML = html;
                        } else {
                            searchResultsContent.innerHTML = '<div class="text-center py-8"><svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><p class="text-slate-500">No products found</p></div>';
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        searchResultsContent.innerHTML = '<div class="text-center py-4 text-slate-500">Search error. Please try again.</div>';
                    });
            }
        });
        </script>
        <div class="flex flex-wrap justify-center gap-6">
            <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" class="bg-white px-10 py-4 rounded-full font-bold hover:bg-slate-100 transition-all flex items-center gap-2 group" style="color: #6B1D2D;">
                Explore Products 
                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </a>
            <a href="<?php echo esc_url(home_url('/about-us')); ?>" class="border-2 text-white px-10 py-4 rounded-full font-bold transition-all" style="border-color: rgba(255,255,255,0.3);" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                About Us
            </a>
        </div>
    </div>
</div>

<!-- Trust Badges -->
<section class="relative z-20 max-w-7xl mx-auto px-6" style="margin-top: -3rem;">
    <div class="bg-white rounded-3xl shadow-xl grid grid-cols-2 lg:grid-cols-4 p-8" style="border: 1px solid #e2e8f0;">
        <div class="p-6 text-center" style="border-right: 1px solid #e2e8f0;">
            <svg class="w-8 h-8 mx-auto mb-3" style="color: #EF4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            <h4 class="font-bold text-slate-900">In-House</h4>
            <p class="text-xs text-slate-500 uppercase tracking-tighter">Production Team</p>
        </div>
        <div class="p-6 text-center lg:border-r" style="border-right: 1px solid #e2e8f0;">
            <svg class="w-8 h-8 mx-auto mb-3" style="color: #EF4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
            <h4 class="font-bold text-slate-900">Bulk Discounts</h4>
            <p class="text-xs text-slate-500 uppercase tracking-tighter">Special B2B Pricing</p>
        </div>
        <div class="p-6 text-center" style="border-right: 1px solid #e2e8f0;">
            <svg class="w-8 h-8 mx-auto mb-3" style="color: #EF4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
            <h4 class="font-bold text-slate-900">Fast Delivery</h4>
            <p class="text-xs text-slate-500 uppercase tracking-tighter">Express Across UAE</p>
        </div>
        <div class="p-6 text-center">
            <svg class="w-8 h-8 mx-auto mb-3" style="color: #EF4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
            <h4 class="font-bold text-slate-900">4.9/5 Rating</h4>
            <p class="text-xs text-slate-500 uppercase tracking-tighter">1200+ Reviews</p>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-24 max-w-7xl mx-auto px-6">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
        <div class="max-w-2xl">
            <h2 class="text-4xl md:text-5xl font-black mb-6 tracking-tight">Our Bouquet Of <span style="color: #EF4444;">Services</span></h2>
            <p class="text-slate-500 text-lg">We offer a comprehensive range of premium printing services designed to elevate your brand presence in the UAE market.</p>
        </div>
        <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" class="font-bold flex items-center gap-1 group" style="color: #EF4444;">
            View all categories 
            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php
        $categories = get_terms(array(
            'taxonomy'   => 'product_category',
            'hide_empty' => true,
            'number'     => 4,
        ));
        
        $icons = array(
            '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>',
            '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>',
            '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>',
            '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>'
        );
        $icon_index = 0;
        
        if (!empty($categories) && !is_wp_error($categories)) :
            foreach ($categories as $category) :
                $cat_link = get_term_link($category);
                $count = $category->count;
        ?>
        <div class="group relative overflow-hidden bg-white p-8 rounded-3xl transition-all duration-300" style="border: 1px solid #e2e8f0;" onmouseover="this.style.borderColor='#EF4444'" onmouseout="this.style.borderColor='#e2e8f0'">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-6 transition-colors" style="background-color: #fef2f2; color: #EF4444;" onmouseover="this.style.backgroundColor='#EF4444'; this.querySelectorAll('svg').forEach(svg => svg.style.color='white');" onmouseout="this.style.backgroundColor='#fef2f2'; this.querySelectorAll('svg').forEach(svg => svg.style.color='#EF4444');">
                <?php echo $icons[$icon_index++ % 4]; ?>
            </div>
            <h3 class="text-xl font-bold mb-2 transition-colors"><?php echo esc_html($category->name); ?></h3>
            <p class="text-slate-500 text-sm mb-6"><?php echo $count; ?>+ Premium products</p>
            <a href="<?php echo esc_url($cat_link); ?>" class="text-sm font-bold uppercase tracking-widest text-slate-400 flex items-center gap-2" style="transition: color 0.3s;" onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='#9ca3af'">
                Explore 
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        <?php
            endforeach;
        endif;
        ?>
    </div>
</section>

<!-- Featured Products -->
<section class="py-24" style="background-color: #f1f5f9;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-black mb-6 tracking-tight" style="font-style: italic;">Featured <span style="color: #EF4444;">Creations</span></h2>
            <p class="text-slate-500 text-lg max-w-2xl mx-auto">Discover our commitment to quality and innovation. <a href="<?php echo esc_url(home_url('/about-us')); ?>" class="font-semibold hover:underline" style="color: #EF4444;">Learn more about us →</a></p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $featured_args = array(
                'post_type'      => 'product',
                'posts_per_page' => 3,
                'orderby'        => 'rand',
            );
            $featured_products = new WP_Query($featured_args);
            
            if ($featured_products->have_posts()) :
                $index = 0;
                while ($featured_products->have_posts()) : $featured_products->the_post();
                    $product_link = get_permalink();
                    $product_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    if (!$product_image) {
                        $product_image = 'https://placehold.co/600x750/e2e8f0/475569?text=' . urlencode(get_the_title());
                    }
            ?>
            <div class="group cursor-pointer <?php echo ($index === 1) ? 'lg:mt-12' : ''; ?>">
                <div class="relative overflow-hidden rounded-3xl bg-slate-200 mb-6" style="aspect-ratio: 4/5;">
                    <img alt="<?php echo esc_attr(get_the_title()); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="<?php echo esc_url($product_image); ?>">
                    <div class="absolute inset-0 flex flex-col justify-end p-8 opacity-0 group-hover:opacity-100 transition-opacity" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                        <span class="font-bold text-xs uppercase tracking-widest mb-2" style="color: #EF4444;">Premium Quality</span>
                        <h4 class="text-white text-2xl font-bold"><?php the_title(); ?></h4>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold transition-colors group-hover:text-[#EF4444]"><?php the_title(); ?></h3>
                    <svg class="w-5 h-5 text-slate-400 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </div>
            </div>
            <?php
                    $index++;
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
        <div class="mt-20 text-center">
            <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" class="inline-block px-10 py-4 rounded-full font-bold text-white shadow-xl transition-all hover:scale-105 active:scale-95" style="background-color: #EF4444; box-shadow: 0 25px 50px -12px rgba(239, 68, 68, 0.2);">
                Browse All Products
            </a>
        </div>
    </div>
</section>

<!-- Why Trust Us -->
<section class="py-24 max-w-7xl mx-auto px-6">
    <div class="rounded-[40px] p-12 lg:p-24 relative overflow-hidden" style="background-color: #6B1D2D;">
        <div class="absolute right-0 bottom-0 w-1/2 h-1/2 opacity-10 pointer-events-none translate-x-1/4 translate-y-1/4">
            <div class="w-full h-full rounded-full" style="background-color: #EF4444;"></div>
        </div>
        <div class="relative z-10 grid lg:grid-cols-2 gap-20 items-center">
            <div>
                <h2 class="text-4xl md:text-5xl font-black text-white mb-8 tracking-tight">Why Brands Trust <br>Efficient Advertising</h2>
                <p class="text-lg mb-12" style="color: rgba(255,255,255,0.7);">We combine over a decade of local expertise with state-of-the-art technology to deliver results that exceed expectations.</p>
                <div class="space-y-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background-color: #EF4444;">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-white mb-1">14+ Years Experience</h4>
                            <p style="color: rgba(255,255,255,0.6);">Established track record of excellence in Dubai's competitive market.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" style="color: #6B1D2D;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-white mb-1">Unmatched Quality</h4>
                            <p style="color: rgba(255,255,255,0.6);">Using only the finest materials and high-precision machinery.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div class="p-8 rounded-3xl" style="background-color: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                    <div class="text-3xl font-black mb-2" style="color: #EF4444;">5000+</div>
                    <p class="text-sm font-medium" style="color: rgba(255,255,255,0.8);">Projects Delivered</p>
                </div>
                <div class="p-8 rounded-3xl" style="background-color: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                    <div class="text-3xl font-black mb-2" style="color: #EF4444;">24/7</div>
                    <p class="text-sm font-medium" style="color: rgba(255,255,255,0.8);">Premium Support</p>
                </div>
                <div class="p-8 rounded-3xl" style="background-color: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                    <div class="text-3xl font-black mb-2" style="color: #EF4444;">100%</div>
                    <p class="text-sm font-medium" style="color: rgba(255,255,255,0.8);">On-time Guarantee</p>
                </div>
                <div class="p-8 rounded-3xl" style="background-color: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                    <div class="text-3xl font-black mb-2" style="color: #EF4444;">Gold</div>
                    <p class="text-sm font-medium" style="color: rgba(255,255,255,0.8);">Service Standards</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col items-center mb-16">
            <div class="flex items-center gap-1 text-yellow-400 mb-4">
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
            </div>
            <h2 class="text-4xl font-black text-center mb-4 tracking-tight">What Our Clients Say</h2>
            <p class="text-slate-500 text-center max-w-xl">Join hundreds of satisfied business owners who choose us for their branding needs.</p>
        </div>
        
        <!-- Trustindex Widget or Custom Reviews -->
        <div class="mb-12">
            <?php echo do_shortcode('[trustindex no-registration=google]'); ?>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-24 max-w-4xl mx-auto px-6">
    <div class="text-center mb-16">
        <h2 class="text-4xl font-black mb-6 tracking-tight" style="font-style: italic;">Common <span style="color: #EF4444;">Questions</span></h2>
        <p class="text-slate-500">Quick answers to frequently asked questions about our services.</p>
    </div>
    <div class="space-y-4">
        <details class="group bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e2e8f0;" open>
            <summary class="flex justify-between items-center p-6 cursor-pointer select-none">
                <span class="text-lg font-bold">What printing and branding services do you offer?</span>
                <svg class="w-6 h-6 text-slate-400 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </summary>
            <div class="px-6 pb-6 text-slate-500">
                We offer a wide range of services including large format printing, indoor/outdoor displays, vehicle branding, exhibition stands, and corporate promotional items.
            </div>
        </details>
        <details class="group bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e2e8f0;">
            <summary class="flex justify-between items-center p-6 cursor-pointer select-none">
                <span class="text-lg font-bold">Do you provide design assistance?</span>
                <svg class="w-6 h-6 text-slate-400 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </summary>
            <div class="px-6 pb-6 text-slate-500">
                Yes, we have an in-house design team that can help you with layouts, artwork optimization, and full creative branding concepts.
            </div>
        </details>
        <details class="group bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e2e8f0;">
            <summary class="flex justify-between items-center p-6 cursor-pointer select-none">
                <span class="text-lg font-bold">Can you handle urgent same-day orders?</span>
                <svg class="w-6 h-6 text-slate-400 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </summary>
            <div class="px-6 pb-6 text-slate-500">
                Depending on the workload and job specifications, we offer express 24-hour delivery for many of our standard products.
            </div>
        </details>
    </div>
    <div class="mt-12 text-center">
        <a href="https://wa.me/971527966265" target="_blank" class="inline-flex items-center gap-3 text-white px-8 py-4 rounded-full font-bold shadow-lg transition-all hover:scale-105" style="background-color: #25D366;">
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.526-2.961-2.642-.087-.116-.708-.941-.708-1.797 0-.856.448-1.274.607-1.446.16-.171.347-.214.464-.214.117 0 .234.002.336.006.107.004.25-.039.391.302.144.35.493 1.203.536 1.289.044.086.073.186.015.301-.058.116-.088.188-.175.29-.088.102-.185.228-.263.307-.089.09-.182.188-.078.366.103.178.461.761.989 1.233.68.607 1.253.796 1.432.885.178.089.282.075.386-.044.104-.119.444-.517.564-.694.12-.178.239-.148.405-.087.165.062 1.053.496 1.234.587.18.09.3.136.344.211.044.075.044.437-.1.842zM12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2zm0 1.5c-4.694 0-8.5 3.806-8.5 8.5s3.806 8.5 8.5 8.5 8.5-3.806 8.5-8.5-3.806-8.5-8.5-8.5z"></path></svg>
            Chat with an Expert
        </a>
    </div>
</section>

<!-- Instagram Section -->
<section class="py-24" style="background-color: #f8f9fa;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black mb-4 tracking-tight" style="font-style: italic;">Follow Our <span style="color: #EF4444;">Journey</span></h2>
            <p class="text-slate-500 font-medium tracking-wide">@efficientadvt on Instagram</p>
        </div>
        <div class="mb-12">
            <?php echo do_shortcode('[trustindex-feed-instagram]'); ?>
        </div>
        <?php 
        $instagram_link = function_exists('of_get_option') ? of_get_option('instagram_link') : '';
        if ($instagram_link) : 
        ?>
        <div class="text-center">
            <a href="<?php echo esc_url($instagram_link); ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-8 py-3 rounded-full font-bold text-white transition-all hover:scale-105" style="background-color: #E1306C;">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                Follow Us on Instagram
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA Section -->
<section class="py-32 text-white relative overflow-hidden" style="background-color: #6B1D2D;">
    <div class="absolute top-0 right-0 w-1/3 h-full -skew-x-12 translate-x-1/2" style="background-color: rgba(239,68,68,0.1);"></div>
    <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
        <h2 class="text-5xl md:text-7xl font-black text-white mb-8 leading-tight tracking-tight">Ready to bring your <br>ideas to life?</h2>
        <p class="text-xl md:text-2xl text-white mb-12 max-w-2xl mx-auto font-normal" style="opacity: 0.9;">Contact us today for a free consultation and personalized quote for your next printing project.</p>
        <div class="flex flex-wrap justify-center gap-6">
            <a href="<?php echo esc_url(home_url('/contact-us')); ?>" class="bg-white px-12 py-5 rounded-full font-bold hover:bg-slate-100 transition-all text-lg shadow-lg" style="color: #6B1D2D;">Contact Us Now</a>
            <a href="tel:+971527966265" class="border-2 text-white px-12 py-5 rounded-full font-bold transition-all text-lg flex items-center gap-2 hover:bg-white/10" style="border-color: rgba(255,255,255,0.5);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                +971 52 796 6265
            </a>
        </div>
    </div>
</section>

<?php
get_footer();
