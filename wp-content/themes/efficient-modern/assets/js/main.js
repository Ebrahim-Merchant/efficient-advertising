/**
 * Main JavaScript for Efficient Modern Theme
 */

(function($) {
    'use strict';

    // Document Ready
    $(document).ready(function() {
        
        // Mobile Menu Toggle
        initMobileMenu();
        
        // Sticky Header
        initStickyHeader();
        
        // Back to Top Button
        initBackToTop();
        
        // Smooth Scroll
        initSmoothScroll();
        
        // WOW.js Animations (if loaded)
        initAnimations();
        
        // Cart Count Update (WooCommerce)
        initCartUpdate();
        
        // Initialize Order Modal
        initOrderModal();
        
        // Initialize Hero Carousel
        initHeroCarousel();
        
        // Initialize Product Search
        initProductSearch();
        
    });

    /**
     * Hero Carousel
     */
    function initHeroCarousel() {
        const carousel = document.getElementById('heroCarousel');
        if (!carousel) return;
        
        const slides = carousel.querySelectorAll('.carousel-slide');
        const prevBtn = carousel.querySelector('.carousel-control.prev');
        const nextBtn = carousel.querySelector('.carousel-control.next');
        const indicators = carousel.querySelectorAll('.indicator');
        let currentSlide = 0;
        let autoplayInterval;
        
        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(ind => ind.classList.remove('active'));
            
            if (index >= slides.length) currentSlide = 0;
            else if (index < 0) currentSlide = slides.length - 1;
            else currentSlide = index;
            
            slides[currentSlide].classList.add('active');
            if (indicators[currentSlide]) {
                indicators[currentSlide].classList.add('active');
            }
        }
        
        function nextSlide() {
            showSlide(currentSlide + 1);
        }
        
        function prevSlide() {
            showSlide(currentSlide - 1);
        }
        
        function startAutoplay() {
            autoplayInterval = setInterval(nextSlide, 5000);
        }
        
        function stopAutoplay() {
            clearInterval(autoplayInterval);
        }
        
        // Event listeners
        if (prevBtn) prevBtn.addEventListener('click', () => {
            prevSlide();
            stopAutoplay();
            startAutoplay();
        });
        
        if (nextBtn) nextBtn.addEventListener('click', () => {
            nextSlide();
            stopAutoplay();
            startAutoplay();
        });
        
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                showSlide(index);
                stopAutoplay();
                startAutoplay();
            });
        });
        
        // Pause on hover
        carousel.addEventListener('mouseenter', stopAutoplay);
        carousel.addEventListener('mouseleave', startAutoplay);
        
        // Start autoplay
        startAutoplay();
    }

    /**
     * Product Search
     */
    function initProductSearch() {
        const searchToggle = document.getElementById('searchToggle');
        const searchDropdown = document.getElementById('searchDropdown');
        const searchField = searchDropdown ? searchDropdown.querySelector('.search-field') : null;
        const searchSuggestions = document.getElementById('searchSuggestions');
        
        if (!searchToggle || !searchDropdown) return;
        
        // Toggle search dropdown
        searchToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            searchDropdown.classList.toggle('active');
            searchToggle.classList.toggle('active');
            
            if (searchDropdown.classList.contains('active') && searchField) {
                setTimeout(() => searchField.focus(), 100);
            }
        });
        
        // Close on click outside
        document.addEventListener('click', function(e) {
            if (!searchDropdown.contains(e.target) && e.target !== searchToggle) {
                searchDropdown.classList.remove('active');
                searchToggle.classList.remove('active');
            }
        });
        
        // Live search suggestions
        let searchTimeout;
        if (searchField && searchSuggestions) {
            searchField.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();
                
                if (query.length < 2) {
                    searchSuggestions.innerHTML = '';
                    return;
                }
                
                searchTimeout = setTimeout(() => {
                    $.ajax({
                        url: efficientModern.ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'search_products',
                            query: query,
                            nonce: efficientModern.nonce
                        },
                        success: function(response) {
                            if (response.success && response.data.length > 0) {
                                let html = '';
                                response.data.forEach(product => {
                                    html += `
                                        <a href="${product.url}" class="search-suggestion-item">
                                            ${product.image ? `<img src="${product.image}" alt="${product.title}" class="search-suggestion-image">` : ''}
                                            <div class="search-suggestion-content">
                                                <div class="search-suggestion-title">${product.title}</div>
                                                ${product.category ? `<div class="search-suggestion-category">${product.category}</div>` : ''}
                                            </div>
                                        </a>
                                    `;
                                });
                                searchSuggestions.innerHTML = html;
                            } else {
                                searchSuggestions.innerHTML = `
                                    <div class="search-no-results">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <p>No products found</p>
                                    </div>
                                `;
                            }
                        }
                    });
                }, 300);
            });
        }
    }

    /**
     * Initialize Order Modal
     */
    function initOrderModal() {
        const modal = document.getElementById('orderModal');
        const openBtns = document.querySelectorAll('[data-modal-open], .order-now-btn');
        const closeBtns = document.querySelectorAll('[data-modal-close]');
        
        if (!modal) return;
        
        // Open modal
        openBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        });
        
        // Close modal
        closeBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
        
        // Close on overlay click
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
        
        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        const $menuToggle = $('.menu-toggle');
        const $navigation = $('.main-navigation');
        const $body = $('body');

        $menuToggle.on('click', function(e) {
            e.preventDefault();
            
            $(this).toggleClass('active');
            $navigation.toggleClass('active');
            $body.toggleClass('menu-open');
            
            // Update ARIA attributes
            const isExpanded = $(this).attr('aria-expanded') === 'true';
            $(this).attr('aria-expanded', !isExpanded);
        });

        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.site-header').length) {
                $menuToggle.removeClass('active');
                $navigation.removeClass('active');
                $body.removeClass('menu-open');
                $menuToggle.attr('aria-expanded', 'false');
            }
        });

        // Close menu when pressing ESC
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $navigation.hasClass('active')) {
                $menuToggle.removeClass('active');
                $navigation.removeClass('active');
                $body.removeClass('menu-open');
                $menuToggle.attr('aria-expanded', 'false');
            }
        });

        // Close menu on window resize if open
        $(window).on('resize', function() {
            if ($(window).width() > 992 && $navigation.hasClass('active')) {
                $menuToggle.removeClass('active');
                $navigation.removeClass('active');
                $body.removeClass('menu-open');
                $menuToggle.attr('aria-expanded', 'false');
            }
        });
    }

    /**
     * Sticky Header
     */
    function initStickyHeader() {
        const $header = $('.site-header');
        const headerOffset = $header.offset().top;

        $(window).on('scroll', function() {
            const scrollTop = $(this).scrollTop();
            
            if (scrollTop > headerOffset + 100) {
                $header.addClass('is-sticky');
            } else {
                $header.removeClass('is-sticky');
            }
        });
    }

    /**
     * Back to Top Button
     */
    function initBackToTop() {
        const $backToTop = $('#back-to-top');

        // Show/hide button on scroll
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                $backToTop.addClass('show');
            } else {
                $backToTop.removeClass('show');
            }
        });

        // Scroll to top on click
        $backToTop.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 600);
        });
    }

    /**
     * Smooth Scroll for Anchor Links
     */
    function initSmoothScroll() {
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            const target = $(this.hash);
            
            if (target.length) {
                e.preventDefault();
                
                const offsetTop = target.offset().top - 100; // Account for fixed header
                
                $('html, body').animate({
                    scrollTop: offsetTop
                }, 600);
            }
        });
    }

    /**
     * Initialize WOW.js Animations
     */
    function initAnimations() {
        if (typeof WOW !== 'undefined') {
            new WOW({
                boxClass: 'wow',
                animateClass: 'animated',
                offset: 100,
                mobile: true,
                live: true
            }).init();
        }
    }

    /**
     * Update Cart Count (WooCommerce)
     */
    function initCartUpdate() {
        // Update cart count on add to cart
        $(document.body).on('added_to_cart', function() {
            updateCartCount();
        });

        // Update cart count on page load
        updateCartCount();
    }

    function updateCartCount() {
        if (typeof efficientModern === 'undefined') {
            return;
        }

        $.ajax({
            url: efficientModern.ajaxurl,
            type: 'POST',
            data: {
                action: 'efficient_modern_update_cart_count',
                nonce: efficientModern.nonce
            },
            success: function(response) {
                const count = parseInt(response);
                const $cartCount = $('.cart-count');
                
                if (count > 0) {
                    if ($cartCount.length) {
                        $cartCount.text(count);
                    } else {
                        $('.header-cart-icon').append('<span class="cart-count">' + count + '</span>');
                    }
                } else {
                    $cartCount.remove();
                }
            }
        });
    }

    /**
     * Carousel/Slider Enhancement (if using carousel)
     */
    function initCarousel() {
        if ($.fn.owlCarousel) {
            $('.product-carousel').owlCarousel({
                loop: true,
                margin: 30,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                navText: [
                    '<i class="fa-solid fa-chevron-left"></i>',
                    '<i class="fa-solid fa-chevron-right"></i>'
                ],
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 4
                    }
                }
            });
        }
    }

    /**
     * Image Lazy Loading Enhancement
     */
    function initLazyLoad() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const image = entry.target;
                        image.src = image.dataset.src;
                        image.classList.remove('lazy');
                        imageObserver.unobserve(image);
                    }
                });
            });

            document.querySelectorAll('img.lazy').forEach(function(img) {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Form Validation Enhancement
     */
    function initFormValidation() {
        $('form.needs-validation').on('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            $(this).addClass('was-validated');
        });
    }

    /**
     * Cookie Consent (if needed)
     */
    function initCookieConsent() {
        const cookieConsent = localStorage.getItem('cookieConsent');
        
        if (!cookieConsent) {
            // Show cookie consent banner
            const $banner = $('<div class="cookie-banner">')
                .html(
                    '<div class="container">' +
                        '<p>We use cookies to improve your experience. By continuing to browse, you agree to our use of cookies.</p>' +
                        '<button class="btn btn-sm btn-primary cookie-accept">Accept</button>' +
                    '</div>'
                )
                .appendTo('body');

            $('.cookie-accept').on('click', function() {
                localStorage.setItem('cookieConsent', 'true');
                $banner.fadeOut(300, function() {
                    $(this).remove();
                });
            });
        }
    }

    /**
     * Search Toggle (if needed)
     */
    function initSearchToggle() {
        $('.search-toggle').on('click', function(e) {
            e.preventDefault();
            $('.search-form').toggleClass('active');
            $('.search-form input[type="search"]').focus();
        });
    }

    /**
     * Utility: Debounce Function
     */
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    /**
     * Window Load Events
     */
    $(window).on('load', function() {
        // Initialize lazy loading
        initLazyLoad();
        
        // Remove preloader if exists
        $('.preloader').fadeOut(300);
    });

    /**
     * Category Filter Select
     */
    $('#category-select').on('change', function() {
        const url = $(this).val();
        if (url) {
            window.location.href = url;
        }
    });


    /**
     * Product Sort
     */
    $('#product-sort').on('change', function() {
        const sortValue = $(this).val();
        const currentUrl = new URL(window.location.href);
        
        if (sortValue && sortValue !== 'default') {
            currentUrl.searchParams.set('orderby', sortValue);
        } else {
            currentUrl.searchParams.delete('orderby');
        }
        
        window.location.href = currentUrl.toString();
    });

    /**
     * Order Form Enhancement
     */
    // Show/hide delivery address based on delivery option
    $('#order_delivery').on('change', function() {
        const deliveryOption = $(this).val();
        const addressGroup = $('#delivery_address_group');
        
        if (deliveryOption !== 'pickup') {
            addressGroup.slideDown(300);
            $('#order_address').prop('required', true);
        } else {
            addressGroup.slideUp(300);
            $('#order_address').prop('required', false);
        }
    });

    // File Upload with Preview and Drag & Drop
    const fileInput = document.getElementById('order_artwork');
    const filePreview = document.getElementById('filePreview');
    const fileUploadWrapper = document.querySelector('.file-upload-wrapper');
    const uploadLabel = document.querySelector('.file-upload-label');
    let uploadedFiles = [];
    
    if (fileInput && fileUploadWrapper) {
        // File input change handler
        fileInput.addEventListener('change', function(e) {
            handleFiles(this.files);
        });
        
        // Drag and drop handlers
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadLabel.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadLabel.addEventListener(eventName, () => {
                fileUploadWrapper.classList.add('dragover');
            }, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            uploadLabel.addEventListener(eventName, () => {
                fileUploadWrapper.classList.remove('dragover');
            }, false);
        });
        
        uploadLabel.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }, false);
        
        function handleFiles(files) {
            const maxSize = 10 * 1024 * 1024; // 10MB
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml', 
                                'application/pdf', 'application/postscript', 
                                'application/x-photoshop', 'image/vnd.adobe.photoshop'];
            
            Array.from(files).forEach(file => {
                // Validate file size
                if (file.size > maxSize) {
                    alert(`${file.name} is too large. Maximum file size is 10MB.`);
                    return;
                }
                
                // Validate file type
                const fileExt = file.name.split('.').pop().toLowerCase();
                const isValidType = allowedTypes.includes(file.type) || 
                                  ['ai', 'eps', 'psd', 'svg'].includes(fileExt);
                
                if (!isValidType) {
                    alert(`${file.name} is not a supported file type.`);
                    return;
                }
                
                uploadedFiles.push(file);
                displayFilePreview(file);
            });
            
            updateFileInput();
        }
        
        function displayFilePreview(file) {
            const previewItem = document.createElement('div');
            previewItem.className = 'file-preview-item';
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const isImage = file.type.startsWith('image/');
                
                if (isImage) {
                    previewItem.innerHTML = `
                        <img src="${e.target.result}" alt="${file.name}" class="file-preview-image">
                        <div class="file-preview-name">${truncateFilename(file.name, 15)}</div>
                        <div class="file-preview-size">${formatFileSize(file.size)}</div>
                        <button type="button" class="file-preview-remove" data-filename="${file.name}">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    `;
                } else {
                    const icon = getFileIcon(file.name);
                    previewItem.innerHTML = `
                        <div class="file-preview-icon">
                            <i class="${icon}"></i>
                        </div>
                        <div class="file-preview-name">${truncateFilename(file.name, 15)}</div>
                        <div class="file-preview-size">${formatFileSize(file.size)}</div>
                        <button type="button" class="file-preview-remove" data-filename="${file.name}">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    `;
                }
                
                filePreview.appendChild(previewItem);
                
                // Add remove handler
                const removeBtn = previewItem.querySelector('.file-preview-remove');
                removeBtn.addEventListener('click', function() {
                    const filename = this.getAttribute('data-filename');
                    removeFile(filename);
                    previewItem.remove();
                });
            };
            
            if (file.type.startsWith('image/')) {
                reader.readAsDataURL(file);
            } else {
                reader.onload();
            }
        }
        
        function removeFile(filename) {
            uploadedFiles = uploadedFiles.filter(f => f.name !== filename);
            updateFileInput();
        }
        
        function updateFileInput() {
            const dt = new DataTransfer();
            uploadedFiles.forEach(file => dt.items.add(file));
            fileInput.files = dt.files;
        }
        
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }
        
        function truncateFilename(filename, maxLength) {
            if (filename.length <= maxLength) return filename;
            const ext = filename.split('.').pop();
            const name = filename.substring(0, filename.lastIndexOf('.'));
            const truncated = name.substring(0, maxLength - ext.length - 4);
            return truncated + '...' + ext;
        }
        
        function getFileIcon(filename) {
            const ext = filename.split('.').pop().toLowerCase();
            const iconMap = {
                'pdf': 'fa-solid fa-file-pdf',
                'ai': 'fa-solid fa-file-code',
                'eps': 'fa-solid fa-file-image',
                'psd': 'fa-solid fa-file-image',
                'svg': 'fa-solid fa-file-code'
            };
            return iconMap[ext] || 'fa-solid fa-file';
        }
    }

    // Order form submission
    $('#productOrderForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const originalBtnText = submitBtn.html();
        
        // Basic validation
        if (!form[0].checkValidity()) {
            form[0].reportValidity();
            return false;
        }
        
        // Add loading state
        form.addClass('loading');
        submitBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Sending...');
        
        // Prepare form data
        const formData = new FormData(form[0]);
        
        // Submit via AJAX
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Show success message
                form.html(
                    '<div class="order-success">' +
                        '<i class="fa-solid fa-check-circle"></i>' +
                        '<h4>Quote Request Submitted!</h4>' +
                        '<p>Thank you for your interest. Our team will review your request and get back to you within 24 hours.</p>' +
                        '<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>' +
                    '</div>'
                );
                
                // Reset form after 5 seconds when modal closes
                setTimeout(function() {
                    $('#orderModal').on('hidden.bs.modal', function() {
                        location.reload();
                    });
                }, 2000);
            },
            error: function(xhr, status, error) {
                // Remove loading state
                form.removeClass('loading');
                submitBtn.prop('disabled', false).html(originalBtnText);
                
                // Show error message
                alert('There was an error submitting your request. Please try again or contact us directly.');
                console.error('Form submission error:', error);
            }
        });
        
        return false;
    });

    // Auto-populate product name in modal
    $('#orderModal').on('show.bs.modal', function() {
        const productName = $('h1.product-title').text().trim();
        if (productName && $('#order_product_name').length) {
            $('#order_product_name').val(productName);
        }
    });

})(jQuery);


