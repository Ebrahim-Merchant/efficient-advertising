/* 
 * Premium System JS - Extracted from header.php
 * Part of the "Lightweight WooCommerce" (Phase 2) Implementation.
 */

jQuery(document).ready(function($){  

  // Hero / Homepage Carousel
  $('#home').owlCarousel({
    loop:true,
    nav:false,
    dots:false,
    autoplay:true,
    smartSpeed :2000,
    responsiveClass:true,
    navText : ["<i class='fa fa-long-arrow-left'></i>","<i class='fa fa-long-arrow-right'></i>"],
    responsive:{
        0:{ items:1, nav:false },
        600:{ items:1, nav:false },
        1000:{ items:1, nav:true }
    }
  });

  // Testimonial Carousel
  $('#testimonial').owlCarousel({
    loop:true,
    nav:true,
    dots:true,
    autoplay:true,
    smartSpeed :1500,
    responsiveClass:true,
    responsive:{
        0:{ items:1, nav:false },
        600:{ items:1, nav:false },
        1000:{ items:1 }
    }
  }); 

  $('.carousel').carousel();

  // Product Page LightSlider
  $('#vertical').lightSlider({
    gallery: true,
    item: 1,
    vertical: true,
    verticalHeight: 450,
    vThumbWidth: 100,
    vThumbheight: 70,
    thumbItem: 4,
    thumbMargin: 0,
    slideMargin: 0,
    responsive : [
        {
            breakpoint:768,
            settings: {
                thumbItem:3,
                vThumbWidth: 70,
                verticalHeight: 300 
              }
        },
        {
            breakpoint:480,
            settings: {
                thumbItem:3,
                vThumbWidth: 70,
                verticalHeight: 250
              }
        }
    ]
  });

  // Back to Top functionality
  $(window).scroll(function() {
    var height = $(window).scrollTop();
    if (height > 100) {
        $('#back2Top').fadeIn();
    } else {
        $('#back2Top').fadeOut();
    }
  });

  $("#back2Top").click(function(event) {
    event.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "slow");
    return false;
  });

  // Smooth jump navigation
  $(".navbar .nav li a, .navbar .nav li a").click(function () {
    var dataAttr = $(this).attr('data-jump');
    if (dataAttr) {
        $('html,body').animate({
            scrollTop: $("#" + dataAttr).offset().top - 0
        }, 1000);
    }
  });

  // Header Compact Effect & Hero Padding Sync
  var navbar = $('.navbar');
  function updateHeader() {
    if ($(window).scrollTop() <= 40) {
      navbar.removeClass('navbar-scroll');
      $('body').removeClass('ea-compact-header');
    } else {
      navbar.addClass('navbar-scroll');
      $('body').addClass('ea-compact-header');
    }
    
    // Measure actual rendered header height and apply to carousel
    var headerEl = $('#header');
    if (headerEl.length) {
      var h = headerEl.outerHeight();
      if (h && h > 0) {
        var hpx = h + 'px';
        $('.homebaner').css('margin-top', hpx);
        $('.sp-hero, .cat-hero, .ea-seo-hero').css('padding-top', hpx);
      }
    }
  }

  // Run immediately on load
  updateHeader();
  $(window).on('scroll resize', updateHeader);
  
  // WOW Initiation if available
  if (typeof WOW === 'function') {
      new WOW({
          boxClass:     'wow',
          animateClass: 'animated',
          offset:       100
      }).init();
  }

});
