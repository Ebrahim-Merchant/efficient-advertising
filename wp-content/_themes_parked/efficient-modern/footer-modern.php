<?php
/**
 * The modern footer with Tailwind CSS
 *
 * @package Efficient_Modern
 * @since 2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

    </div><!-- #content -->
</div><!-- #page -->

<!-- Instagram Section -->
<section class="py-24 bg-slate-50 dark:bg-slate-900/30">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black mb-4 tracking-tight italic">Follow Our <span class="text-primary">Journey</span></h2>
            <p class="text-slate-500 font-medium tracking-wide">@efficientadvt on Instagram</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
            <?php
            // Display Instagram feed if available
            // You can integrate with Instagram API or use static images
            for ($i = 1; $i <= 6; $i++) :
                $placeholder = 'https://placehold.co/400x400/e2e8f0/6B1D2D?text=Instagram+' . $i;
            ?>
            <div class="aspect-square bg-slate-200 overflow-hidden relative group">
                <img alt="Instagram Post <?php echo $i; ?>" class="w-full h-full object-cover" src="<?php echo esc_url($placeholder); ?>">
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity cursor-pointer">
                    <i class="material-icons-outlined text-white">favorite</i>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-slate-900 text-white pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-20">
            <!-- Brand Column -->
            <div class="lg:col-span-1">
                <div class="flex items-center gap-2 mb-8">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-2xl">E</span>
                        </div>
                        <span class="text-xl font-bold tracking-tight uppercase">Efficient <span class="text-primary">ADVT</span></span>
                    <?php endif; ?>
                </div>
                <p class="text-slate-400 mb-8 leading-relaxed">Dubai's leading digital printing company, delivering high-impact solutions for brands that care about quality and precision.</p>
                <div class="flex space-x-4">
                    <?php 
                    $facebook = function_exists('of_get_option') ? of_get_option('facebook_link') : '';
                    $instagram = function_exists('of_get_option') ? of_get_option('instagram_link') : '';
                    $linkedin = function_exists('of_get_option') ? of_get_option('linkedin_link') : '';
                    ?>
                    
                    <?php if ($facebook) : ?>
                    <a href="<?php echo esc_url($facebook); ?>" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary transition-colors">
                        <i class="material-icons-outlined text-sm">thumb_up</i>
                    </a>
                    <?php endif; ?>
                    
                    <?php if ($instagram) : ?>
                    <a href="<?php echo esc_url($instagram); ?>" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary transition-colors">
                        <i class="material-icons-outlined text-sm">camera_alt</i>
                    </a>
                    <?php endif; ?>
                    
                    <?php if ($linkedin) : ?>
                    <a href="<?php echo esc_url($linkedin); ?>" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary transition-colors">
                        <i class="material-icons-outlined text-sm">business</i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-bold mb-8">Quick Links</h4>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer_menu_1',
                    'container'      => false,
                    'menu_class'     => 'space-y-4 text-slate-400',
                    'fallback_cb'    => function() {
                        echo '<ul class="space-y-4 text-slate-400">';
                        echo '<li><a href="' . esc_url(get_post_type_archive_link('product')) . '" class="hover:text-primary transition-colors">Our Products</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/about')) . '" class="hover:text-primary transition-colors">About Company</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/contact-us')) . '" class="hover:text-primary transition-colors">Contact Us</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/privacy-policy')) . '" class="hover:text-primary transition-colors">Privacy Policy</a></li>';
                        echo '</ul>';
                    },
                ));
                ?>
            </div>

            <!-- Services -->
            <div>
                <h4 class="text-lg font-bold mb-8">Our Services</h4>
                <ul class="space-y-4 text-slate-400">
                    <?php
                    $categories = get_terms(array(
                        'taxonomy'   => 'product_category',
                        'hide_empty' => true,
                        'number'     => 4,
                    ));
                    
                    if (!empty($categories) && !is_wp_error($categories)) :
                        foreach ($categories as $category) :
                            $cat_link = get_term_link($category);
                    ?>
                        <li><a href="<?php echo esc_url($cat_link); ?>" class="hover:text-primary transition-colors"><?php echo esc_html($category->name); ?></a></li>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-bold mb-8">Get In Touch</h4>
                <ul class="space-y-6 text-slate-400">
                    <?php 
                    $address = function_exists('of_get_option') ? of_get_option('footer_address', 'Warehouse-11, 10C Street, Ras Al Khor Industrial Area 1, Dubai, UAE') : 'Warehouse-11, 10C Street, Ras Al Khor Industrial Area 1, Dubai, UAE';
                    $phone = function_exists('of_get_option') ? of_get_option('contact_no') : '+971 4 271 1048';
                    $email = function_exists('of_get_option') ? of_get_option('email_address') : 'info@efficientadvt.com';
                    ?>
                    
                    <?php if ($address) : ?>
                    <li class="flex gap-4">
                        <i class="material-icons-outlined text-primary">location_on</i>
                        <span><?php echo esc_html($address); ?></span>
                    </li>
                    <?php endif; ?>
                    
                    <?php if ($phone) : ?>
                    <li class="flex gap-4">
                        <i class="material-icons-outlined text-primary">phone</i>
                        <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>" class="hover:text-primary transition-colors"><?php echo esc_html($phone); ?></a>
                    </li>
                    <?php endif; ?>
                    
                    <?php if ($email) : ?>
                    <li class="flex gap-4">
                        <i class="material-icons-outlined text-primary">email</i>
                        <a href="mailto:<?php echo esc_attr($email); ?>" class="hover:text-primary transition-colors"><?php echo esc_html($email); ?></a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="pt-12 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-slate-500 text-sm">© <?php echo date('Y'); ?> Efficient Advertising LLC. All rights reserved.</p>
            <p class="text-slate-500 text-sm">Powered by <a href="<?php echo esc_url(home_url('/')); ?>" class="text-white hover:text-primary">Modern Web Design</a></p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
