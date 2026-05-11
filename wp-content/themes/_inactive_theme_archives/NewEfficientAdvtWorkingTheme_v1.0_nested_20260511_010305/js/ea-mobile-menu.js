/**
 * EA Mobile Menu - Refactored JavaScript
 * Handles mobile drawer toggle, overlay, and accordion behavior
 * Separated from header.php for cleaner architecture
 */
(function($) {
  'use strict';

  // Guard against no jQuery
  if (typeof $ === 'undefined') return;

  // Cache DOM elements
  var $eaToggle   = $('#eaMobToggle');
  var $eaOverlay  = $('#eaMobOverlay');
  var $eaNav      = $('#eaMegaNav');
  var $eaClose    = $('#eaMobClose');
  var $eaItems    = $('.ea-mega-item.ea-has-panel');
  var eaHoverTimer;

  // Breakpoint matching style.css mobile threshold
  var MOBILE_BREAKPOINT = 991;

  /**
   * Open mobile drawer
   */
  function eaOpenDrawer() {
    $eaNav.addClass('is-open');
    $eaOverlay.addClass('is-vis');
    $eaToggle.addClass('is-active').attr('aria-expanded', 'true');
    $('body').css('overflow', 'hidden');
  }

  /**
   * Close mobile drawer
   */
  function eaCloseDrawer() {
    $eaNav.removeClass('is-open');
    $eaOverlay.removeClass('is-vis');
    $eaToggle.removeClass('is-active').attr('aria-expanded', 'false');
    $('body').css('overflow', '');
    $eaItems.removeClass('is-open');
  }

  /**
   * Toggle drawer state
   */
  function eaToggleDrawer() {
    if ($eaNav.hasClass('is-open')) {
      eaCloseDrawer();
    } else {
      eaOpenDrawer();
    }
  }

  /**
   * Initialize desktop hover behavior for mega menu panels
   * Only active when window width > 991px
   */
  function initDesktopHover() {
    if ($(window).width() <= MOBILE_BREAKPOINT) return;

    $eaItems
      .on('mouseenter', function() {
        clearTimeout(eaHoverTimer);
        $eaItems.not(this).removeClass('is-open');
        $(this).addClass('is-open');
      })
      .on('mouseleave', function() {
        var $it = $(this);
        eaHoverTimer = setTimeout(function() { $it.removeClass('is-open'); }, 180);
      });

    $eaItems.find('.ea-mega-panel')
      .on('mouseenter', function() { clearTimeout(eaHoverTimer); })
      .on('mouseleave', function() {
        var $it = $(this).closest('.ea-mega-item');
        eaHoverTimer = setTimeout(function() { $it.removeClass('is-open'); }, 180);
      });

    // Close panel when clicking elsewhere on page
    $(document).on('click.eamega', function(e) {
      if (!$(e.target).closest('.ea-mega-item').length) {
        $eaItems.removeClass('is-open');
      }
    });
  }

  /**
   * Initialize mobile accordion behavior
   * Only active when window width <= 991px
   */
  function initMobileAccordion() {
    if ($(window).width() > MOBILE_BREAKPOINT) return;

    // Remove desktop hover handlers
    $eaItems.off('mouseenter mouseleave');
    $eaItems.find('.ea-mega-panel').off('mouseenter mouseleave');
    $(document).off('click.eamega');

    // Attach accordion click handler
    $eaItems.find('> .ea-mega-link').off('click').on('click', function(e) {
      e.preventDefault();
      var $it = $(this).closest('.ea-mega-item');
      var wasOpen = $it.hasClass('is-open');
      $eaItems.removeClass('is-open');
      if (!wasOpen) { $it.addClass('is-open'); }
    });
  }

  /**
   * Handle responsive switching between desktop and mobile modes
   */
  function handleResponsive() {
    var width = $(window).width();
    if (width > MOBILE_BREAKPOINT) {
      initDesktopHover();
      // Close drawer on resize to desktop
      eaCloseDrawer();
    } else {
      initMobileAccordion();
    }
  }

  /**
   * Initialize event listeners
   */
  function init() {
    // Toggle button click
    $eaToggle.on('click', eaToggleDrawer);

    // Close button click
    $eaClose.on('click', eaCloseDrawer);

    // Overlay click (click-away to close)
    $eaOverlay.on('click', eaCloseDrawer);

    // Handle responsive behavior
    handleResponsive();
    $(window).on('resize', handleResponsive);

    // Keyboard accessibility: close on Escape
    $(document).on('keydown', function(e) {
      if (e.key === 'Escape' && $eaNav.hasClass('is-open')) {
        eaCloseDrawer();
        $eaToggle.focus();
      }
    });
  }

  // Initialize when DOM is ready
  $(document).ready(init);

})(jQuery);