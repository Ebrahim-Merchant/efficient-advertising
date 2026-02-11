<?php
/**
 * Template Name: Modern Home (Tailwind)
 * Description: Modern homepage design with Tailwind CSS
 *
 * @package Efficient_Modern
 * @since 2.0.0
 */

get_header('modern');
?>

<!-- Hero Section with Search -->
<header class="relative pt-20 pb-32 overflow-hidden bg-accent">
    <div class="absolute inset-0 opacity-20 pointer-events-none">
        <div class="absolute top-[-20%] left-[-10%] w-[600px] h-[600px] bg-primary rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-red-400 rounded-full blur-[100px]"></div>
    </div>
    <div class="max-w-5xl mx-auto px-6 relative z-10 text-center">
        <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/10 text-white border border-white/20 text-xs font-semibold uppercase tracking-widest mb-8">
            Trusted since 2010 in Dubai
        </div>
        <h1 class="text-5xl md:text-7xl font-black text-white leading-[1.1] mb-8">
            Your <span class="text-primary">Printing Partner</span> <br> for the Digital Age
        </h1>
        <p class="text-lg md:text-xl text-white/70 max-w-2xl mx-auto mb-12 font-medium leading-relaxed">
            Premium high-quality printing solutions for brands that demand excellence. From large format displays to custom branding packages.
        </p>
        <div class="max-w-2xl mx-auto relative mb-12">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none">
                    <i class="material-icons-outlined text-slate-400">search</i>
                </div>
                <input type="search" name="s" class="w-full pl-16 pr-32 py-5 rounded-2xl bg-white text-slate-900 border-none shadow-2xl focus:ring-4 focus:ring-primary/20 text-lg placeholder:text-slate-400" placeholder="Search for products (e.g. Backdrop, Stickers, PVC)...">
                <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 bg-accent text-white px-6 py-2.5 rounded-xl font-bold hover:bg-slate-900 transition-colors">
                    Search
                </button>
            </form>
        </div>
        <div class="flex flex-wrap justify-center gap-6">
            <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" class="bg-white text-accent px-10 py-4 rounded-full font-bold hover:bg-slate-100 transition-all flex items-center gap-2 group">
                Explore Products <i class="material-icons-outlined group-hover:translate-x-1 transition-transform">arrow_forward</i>
            </a>
            <a href="<?php echo esc_url(home_url('/portfolio')); ?>" class="border-2 border-white/30 text-white px-10 py-4 rounded-full font-bold hover:bg-white/10 transition-all">
                Our Portfolio
            </a>
        </div>
    </div>
</header>

<!-- Trust Badges -->
<section class="relative -mt-12 z-20 max-w-7xl mx-auto px-6">
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl grid grid-cols-2 lg:grid-cols-4 p-8 border border-slate-100 dark:border-slate-700">
        <div class="p-6 text-center border-r border-slate-100 dark:border-slate-700">
            <i class="material-icons-outlined text-primary text-3xl mb-3">precision_manufacturing</i>
            <h4 class="font-bold text-slate-900 dark:text-white">In-House</h4>
            <p class="text-xs text-slate-500 uppercase tracking-tighter">Production Team</p>
        </div>
        <div class="p-6 text-center lg:border-r border-slate-100 dark:border-slate-700">
            <i class="material-icons-outlined text-primary text-3xl mb-3">sell</i>
            <h4 class="font-bold text-slate-900 dark:text-white">Bulk Discounts</h4>
            <p class="text-xs text-slate-500 uppercase tracking-tighter">Special B2B Pricing</p>
        </div>
        <div class="p-6 text-center border-r border-slate-100 dark:border-slate-700">
            <i class="material-icons-outlined text-primary text-3xl mb-3">local_shipping</i>
            <h4 class="font-bold text-slate-900 dark:text-white">Fast Delivery</h4>
            <p class="text-xs text-slate-500 uppercase tracking-tighter">Express Across UAE</p>
        </div>
        <div class="p-6 text-center">
            <i class="material-icons-outlined text-primary text-3xl mb-3">verified</i>
            <h4 class="font-bold text-slate-900 dark:text-white">4.9/5 Rating</h4>
            <p class="text-xs text-slate-500 uppercase tracking-tighter">1200+ Reviews</p>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-24 max-w-7xl mx-auto px-6">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
        <div class="max-w-2xl">
            <h2 class="text-4xl md:text-5xl font-black mb-6 tracking-tight">Our Bouquet Of <span class="text-primary">Services</span></h2>
            <p class="text-slate-500 dark:text-slate-400 text-lg">We offer a comprehensive range of premium printing services designed to elevate your brand presence in the UAE market.</p>
        </div>
        <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" class="text-primary font-bold flex items-center gap-1 group">
            View all categories <i class="material-icons-outlined group-hover:translate-x-1 transition-transform">east</i>
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php
        $categories = get_terms(array(
            'taxonomy'   => 'product_category',
            'hide_empty' => true,
            'number'     => 4,
        ));
        
        $icons = array('image', 'flag', 'shopping_bag', 'layers');
        $icon_index = 0;
        
        if (!empty($categories) && !is_wp_error($categories)) :
            foreach ($categories as $category) :
                $cat_link = get_term_link($category);
                $count = $category->count;
        ?>
        <div class="group relative overflow-hidden bg-white dark:bg-slate-800 p-8 rounded-3xl border border-slate-100 dark:border-slate-700 hover:border-primary dark:hover:border-primary transition-all duration-300">
            <div class="w-16 h-16 bg-red-50 dark:bg-red-900/20 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-primary transition-colors">
                <i class="material-icons-outlined text-primary group-hover:text-white text-3xl"><?php echo $icons[$icon_index++ % 4]; ?></i>
            </div>
            <h3 class="text-xl font-bold mb-2 group-hover:text-primary transition-colors"><?php echo esc_html($category->name); ?></h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm mb-6"><?php echo $count; ?>+ Premium products</p>
            <a href="<?php echo esc_url($cat_link); ?>" class="text-sm font-bold uppercase tracking-widest text-slate-400 group-hover:text-primary flex items-center gap-2">
                Explore <i class="material-icons-outlined text-xs">arrow_forward</i>
            </a>
        </div>
        <?php
            endforeach;
        endif;
        ?>
    </div>
</section>

<!-- Featured Creations -->
<section class="py-24 bg-slate-100 dark:bg-slate-900/50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-black mb-6 tracking-tight italic">Featured <span class="text-primary">Creations</span></h2>
            <p class="text-slate-500 dark:text-slate-400 text-lg max-w-2xl mx-auto">Explore our portfolio of high-impact printing projects across various industries.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $featured_products = new WP_Query(array(
                'post_type'      => 'product',
                'posts_per_page' => 3,
                'orderby'        => 'rand',
            ));
            
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
                <div class="relative overflow-hidden rounded-3xl aspect-[4/5] bg-slate-200 mb-6">
                    <img alt="<?php echo esc_attr(get_the_title()); ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" src="<?php echo esc_url($product_image); ?>">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-8">
                        <span class="text-primary font-bold text-xs uppercase tracking-widest mb-2">Premium Quality</span>
                        <h4 class="text-white text-2xl font-bold"><?php the_title(); ?></h4>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold group-hover:text-primary transition-colors"><?php the_title(); ?></h3>
                    <i class="material-icons-outlined text-slate-400 group-hover:translate-x-1 transition-transform">east</i>
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
            <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" class="bg-primary text-white px-10 py-4 rounded-full font-bold shadow-xl shadow-primary/20 hover:scale-105 active:scale-95 transition-all">
                Browse All Products
            </a>
        </div>
    </div>
</section>

<!-- Why Trust Us -->
<section class="py-24 max-w-7xl mx-auto px-6">
    <div class="bg-accent rounded-[40px] p-12 lg:p-24 relative overflow-hidden">
        <div class="absolute right-0 bottom-0 w-1/2 h-1/2 opacity-10 pointer-events-none translate-x-1/4 translate-y-1/4">
            <div class="w-full h-full bg-primary rounded-full"></div>
        </div>
        <div class="relative z-10 grid lg:grid-cols-2 gap-20 items-center">
            <div>
                <h2 class="text-4xl md:text-5xl font-black text-white mb-8 tracking-tight">Why Brands Trust <br>Efficient Advertising</h2>
                <p class="text-white/70 text-lg mb-12">We combine over a decade of local expertise with state-of-the-art technology to deliver results that exceed expectations.</p>
                <div class="space-y-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="material-icons-outlined text-white">history</i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-white mb-1">14+ Years Experience</h4>
                            <p class="text-white/60">Established track record of excellence in Dubai's competitive market.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="material-icons-outlined text-accent">workspace_premium</i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-white mb-1">Unmatched Quality</h4>
                            <p class="text-white/60">Using only the finest materials and high-precision machinery.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white/10 backdrop-blur-md p-8 rounded-3xl border border-white/10">
                    <div class="text-3xl font-black text-primary mb-2">5000+</div>
                    <p class="text-sm font-medium text-white/80">Projects Delivered</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-8 rounded-3xl border border-white/10">
                    <div class="text-3xl font-black text-primary mb-2">24/7</div>
                    <p class="text-sm font-medium text-white/80">Premium Support</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-8 rounded-3xl border border-white/10">
                    <div class="text-3xl font-black text-primary mb-2">100%</div>
                    <p class="text-sm font-medium text-white/80">On-time Guarantee</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-8 rounded-3xl border border-white/10">
                    <div class="text-3xl font-black text-primary mb-2">Gold</div>
                    <p class="text-sm font-medium text-white/80">Service Standards</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col items-center mb-16">
            <div class="flex items-center gap-1 text-yellow-400 mb-4">
                <i class="material-icons-outlined">star</i>
                <i class="material-icons-outlined">star</i>
                <i class="material-icons-outlined">star</i>
                <i class="material-icons-outlined">star</i>
                <i class="material-icons-outlined">star</i>
            </div>
            <h2 class="text-4xl font-black text-center mb-4 tracking-tight">What Our Clients Say</h2>
            <p class="text-slate-500 text-center max-w-xl">Join hundreds of satisfied business owners who choose us for their branding needs.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php
            // Sample testimonials - you can replace with actual testimonial custom post type
            $testimonials = array(
                array(
                    'name' => 'Habibur Rahman',
                    'date' => 'May 31, 2023',
                    'text' => 'Excellent service and high-quality printing. The team is professional and always delivers on time. Highly recommended for business branding!'
                ),
                array(
                    'name' => 'Arqam Khan',
                    'date' => 'March 8, 2023',
                    'text' => 'Amazing work on our exhibition stands. The quality of the material and the sharpness of the print was top-notch. Best in Dubai!'
                ),
                array(
                    'name' => 'Nikhil Uzgare',
                    'date' => 'June 21, 2022',
                    'text' => 'A job well done on time and at a reasonable price! Will definitely come back for future projects.'
                )
            );
            
            $shadow_class = '';
            foreach ($testimonials as $index => $testimonial) :
                $shadow_class = ($index === 1) ? 'shadow-2xl shadow-slate-200/50 dark:shadow-none' : '';
            ?>
            <div class="bg-background-light dark:bg-slate-800 p-10 rounded-[32px] border border-slate-100 dark:border-slate-700 <?php echo $shadow_class; ?>">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 rounded-full bg-slate-200 flex items-center justify-center overflow-hidden">
                        <i class="material-icons-outlined text-slate-400 text-3xl">person</i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white"><?php echo esc_html($testimonial['name']); ?></h4>
                        <p class="text-xs text-slate-400 uppercase tracking-widest"><?php echo esc_html($testimonial['date']); ?></p>
                    </div>
                    <i class="material-icons-outlined text-primary ml-auto">thumb_up</i>
                </div>
                <p class="text-slate-600 dark:text-slate-300 italic leading-relaxed">"<?php echo esc_html($testimonial['text']); ?>"</p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-24 max-w-4xl mx-auto px-6">
    <div class="text-center mb-16">
        <h2 class="text-4xl font-black mb-6 tracking-tight italic">Common <span class="text-primary">Questions</span></h2>
        <p class="text-slate-500">Quick answers to frequently asked questions about our services.</p>
    </div>
    <div class="space-y-4">
        <details class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden" open>
            <summary class="flex justify-between items-center p-6 cursor-pointer select-none">
                <span class="text-lg font-bold">What printing and branding services do you offer?</span>
                <i class="material-icons-outlined group-open:rotate-180 transition-transform">expand_more</i>
            </summary>
            <div class="px-6 pb-6 text-slate-500 dark:text-slate-400">
                We offer a wide range of services including large format printing, indoor/outdoor displays, vehicle branding, exhibition stands, and corporate promotional items.
            </div>
        </details>
        <details class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
            <summary class="flex justify-between items-center p-6 cursor-pointer select-none">
                <span class="text-lg font-bold">Do you provide design assistance?</span>
                <i class="material-icons-outlined group-open:rotate-180 transition-transform">expand_more</i>
            </summary>
            <div class="px-6 pb-6 text-slate-500 dark:text-slate-400">
                Yes, we have an in-house design team that can help you with layouts, artwork optimization, and full creative branding concepts.
            </div>
        </details>
        <details class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
            <summary class="flex justify-between items-center p-6 cursor-pointer select-none">
                <span class="text-lg font-bold">Can you handle urgent same-day orders?</span>
                <i class="material-icons-outlined group-open:rotate-180 transition-transform">expand_more</i>
            </summary>
            <div class="px-6 pb-6 text-slate-500 dark:text-slate-400">
                Depending on the workload and job specifications, we offer express 24-hour delivery for many of our standard products.
            </div>
        </details>
    </div>
    <div class="mt-12 text-center">
        <a href="https://wa.me/971527966265" target="_blank" class="inline-flex items-center gap-3 bg-[#25D366] text-white px-8 py-4 rounded-full font-bold shadow-lg shadow-green-200 dark:shadow-none hover:scale-105 transition-all">
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.526-2.961-2.642-.087-.116-.708-.941-.708-1.797 0-.856.448-1.274.607-1.446.16-.171.347-.214.464-.214.117 0 .234.002.336.006.107.004.25-.039.391.302.144.35.493 1.203.536 1.289.044.086.073.186.015.301-.058.116-.088.188-.175.29-.088.102-.185.228-.263.307-.089.09-.182.188-.078.366.103.178.461.761.989 1.233.68.607 1.253.796 1.432.885.178.089.282.075.386-.044.104-.119.444-.517.564-.694.12-.178.239-.148.405-.087.165.062 1.053.496 1.234.587.18.09.3.136.344.211.044.075.044.437-.1.842zM12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2zm0 1.5c-4.694 0-8.5 3.806-8.5 8.5s3.806 8.5 8.5 8.5 8.5-3.806 8.5-8.5-3.806-8.5-8.5-8.5z"></path></svg>
            Chat with an Expert
        </a>
    </div>
</section>

<!-- CTA Section -->
<section class="py-32 bg-accent text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-1/3 h-full bg-primary/10 -skew-x-12 translate-x-1/2"></div>
    <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
        <h2 class="text-4xl md:text-6xl font-black mb-8 leading-tight">Ready to bring your <br>ideas to life?</h2>
        <p class="text-white/70 text-lg mb-12 max-w-2xl mx-auto">Contact us today for a free consultation and personalized quote for your next printing project.</p>
        <div class="flex flex-wrap justify-center gap-6">
            <a href="<?php echo esc_url(home_url('/contact-us')); ?>" class="bg-white text-accent px-12 py-5 rounded-full font-bold hover:bg-slate-100 transition-all text-lg">Contact Us Now</a>
            <a href="tel:+971527966265" class="border-2 border-white/30 text-white px-12 py-5 rounded-full font-bold hover:bg-white/10 transition-all text-lg flex items-center gap-2">
                <i class="material-icons-outlined">call</i> +971 52 796 6265
            </a>
        </div>
    </div>
</section>

<?php
get_footer('modern');
?>
