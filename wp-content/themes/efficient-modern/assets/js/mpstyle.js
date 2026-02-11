/**
 * M Print House Style - Additional JavaScript
 */

// Font Awesome 5 to 6 Shim (JS Backup)
document.addEventListener('DOMContentLoaded', function() {
    var icons = document.querySelectorAll('.fa, .fas, .far, .fab');
    icons.forEach(function(icon) {
        // If icon has fa- but not fa-solid/regular/brands, try to auto-fix common ones
        var classes = icon.className;
        if (classes.includes('fa-') && !classes.includes('fa-solid') && !classes.includes('fa-regular') && !classes.includes('fa-brands')) {
            // This is a last resort fallback for icons that might be missing specific 5.x classes or using only "fa fa-something"
             if (classes.includes('fas')) {
                icon.classList.add('fa-solid');
             } else if (classes.includes('fab')) {
                icon.classList.add('fa-brands');
             } else if (classes.includes('far')) {
                icon.classList.add('fa-regular');
             }
        }
    });

    // Force font family on all older icon classes if computed style is wrong
    // (This is a heavy-handed fix but useful if CSS cascade is really broken)
});

jQuery(document).ready(function($) {
    
    // FAQ Accordion
    $('.faq-question').on('click', function() {
        var $faqItem = $(this).closest('.faq-item');
        var $allItems = $('.faq-item');
        
        // Close all other items
        $allItems.not($faqItem).removeClass('active');
        
        // Toggle current item
        $faqItem.toggleClass('active');
    });
    
    // Smooth scroll for anchor links
    $('a[href^="#"]').on('click', function(e) {
        var target = $(this).attr('href');
        if (target !== '#' && $(target).length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $(target).offset().top - 100
            }, 600);
        }
    });
    
    // Generic Modal Trigger Logic
    $(document).on('click', '[data-toggle="modal"]', function(e) {
        e.preventDefault();
        var target = $(this).data('target');
        var $modal = $(target);
        
        if ($modal.length) {
            $modal.addClass('active');
            $('body').addClass('modal-open');
        }
    });

    // Close Modal Logic
    $(document).on('click', '.modal-overlay, [data-modal-close]', function(e) {
        if ($(e.target).hasClass('modal-overlay') || $(e.target).closest('[data-modal-close]').length) {
            $('.modal-overlay').removeClass('active');
            $('body').removeClass('modal-open');
        }
    });
    
    // Prevent closing when clicking inside modal content
    $(document).on('click', '.modal-container', function(e) {
        e.stopPropagation();
    });
});
