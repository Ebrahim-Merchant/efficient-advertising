
<style>
#ea-fnav ul, #ea-fnav ul li { list-style:none !important; margin:0 !important; padding:0 !important; }
#ea-fnav a { color:#ffffff !important; font-size:13px !important; text-decoration:none !important; display:block !important; padding:5px 0 !important; line-height:1.5 !important; border-bottom:1px solid rgba(255,255,255,0.05) !important; }
#ea-fnav a:hover { color:#FFBA09 !important; padding-left:4px !important; }
#ea-fnav li:last-child a { border-bottom:none !important; }

#ea-fcf7 .wpcf7 { margin:0 !important; }
#ea-fcf7 input[type="text"], #ea-fcf7 input[type="email"],
#ea-fcf7 input[type="tel"],  #ea-fcf7 input[type="number"],
#ea-fcf7 input[type="text"]:focus, #ea-fcf7 input[type="email"]:focus,
#ea-fcf7 input[type="tel"]:focus,  #ea-fcf7 input[type="number"]:focus,
#ea-fcf7 textarea, #ea-fcf7 textarea:focus {
  display:block !important; width:100% !important; box-sizing:border-box !important;
  background:#1e2535 !important;
  border:1px solid rgba(255,255,255,0.2) !important;
  border-radius:5px !important; color:#ffffff !important;
  font-size:13px !important; padding:9px 11px !important; margin-bottom:7px !important;
  outline:none !important; box-shadow:none !important;
}
#ea-fcf7 textarea { height:80px !important; resize:none !important; }
#ea-fcf7 input::placeholder, #ea-fcf7 textarea::placeholder { color:#8896a8 !important; opacity:1 !important; }
#ea-fcf7 input::-webkit-input-placeholder, #ea-fcf7 textarea::-webkit-input-placeholder { color:#8896a8 !important; }
#ea-fcf7 input::-moz-placeholder, #ea-fcf7 textarea::-moz-placeholder { color:#8896a8 !important; }
#ea-fcf7 .wpcf7-form-control-wrap { display:block !important; }
#ea-fcf7 label, #ea-fcf7 .wpcf7-quiz-label, #ea-fcf7 .wpcf7-quiz-label span { color:#ffffff !important; font-size:11px !important; display:block !important; margin-bottom:2px !important; }
#ea-fcf7 p { margin:0 !important; color:#ffffff !important; }
#ea-fcf7 span { color:#ffffff !important; }
#ea-fcf7 .wpcf7-not-valid-tip { color:#f87171 !important; font-size:11px !important; }
#ea-fcf7 input[type="submit"] {
  display:block !important; width:100% !important;
  background:#FFBA09 !important; color:#0A0A14 !important;
  font-weight:800 !important; font-size:12px !important; letter-spacing:1px !important;
  text-transform:uppercase !important; border:none !important;
  border-radius:5px !important; padding:11px !important;
  cursor:pointer !important; margin-top:4px !important;
}
#ea-fcf7 input[type="submit"]:hover { background:#E5A800 !important; }
/* Hide CF7 form title output */
#ea-fcf7 .wpcf7 > h2, #ea-fcf7 .wpcf7 > h3,
#ea-fcf7 .wpcf7-form > h2, #ea-fcf7 .wpcf7-form > h3,
#ea-fcf7 p.wpcf7-hidden, #ea-fcf7 .screen-reader-response { display:none !important; }

#ea-foot-seo a { color:#ffffff !important; font-size:11px !important; text-decoration:none !important; margin:0 10px 5px 0 !important; display:inline-block !important; }
#ea-foot-seo a:hover { color:#FFBA09 !important; }
</style>

<footer style="background:#0A0A14; margin:0; padding:0; border-top:3px solid #FFBA09;">

  <div style="padding:48px 0 36px;">
    <div class="container">
      <div class="row">

        <!-- Col 1: Brand + About + Social -->
        <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:32px; padding-right:20px;">
          <div style="margin-bottom:16px;">
            <?php $footer_logo = of_get_option('footer_logo'); if ( $footer_logo ) : ?>
              <a href="<?php echo esc_url(home_url('/')); ?>" style="display:inline-block; text-decoration:none;">
                <img src="<?php echo esc_url($footer_logo); ?>" alt="Efficient Advertising" style="max-width:140px; height:auto; display:block;">
              </a>
            <?php else : ?>
              <a href="<?php echo esc_url(home_url('/')); ?>" style="display:inline-flex; align-items:center; gap:9px; text-decoration:none;">
                <svg width="36" height="36" viewBox="0 0 38 38" fill="none" style="flex-shrink:0;">
                  <circle cx="19" cy="19" r="19" fill="#FFBA09"/>
                  <path d="M11 27L19 11L27 27" stroke="#0A0A14" stroke-width="3" stroke-linejoin="round" fill="none"/>
                  <path d="M14 22H24" stroke="#0A0A14" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
                <div style="line-height:1.2;">
                  <div style="font-size:13px; font-weight:900; color:#ffffff; letter-spacing:0.5px;">EFFICIENT</div>
                  <div style="font-size:13px; font-weight:900; color:#FFBA09; letter-spacing:0.5px;">ADVERTISING</div>
                  <div style="font-size:8px; color:#475569; letter-spacing:1px; margin-top:2px;">YOU THINK IT. WE PRINT IT</div>
                </div>
              </a>
            <?php endif; ?>
          </div>
          <p style="color:#ffffff; font-size:12px; line-height:1.7; margin:0 0 6px;">Dubai's full-service printing &amp; advertising company. Custom signage, vehicle branding, exhibition stands and events across the UAE.</p>
          <p style="color:#e2e8f0; font-size:11px; margin:0 0 18px;">Trusted since 2008.</p>
          <div style="display:flex; gap:7px; flex-wrap:wrap;">
            <?php if ( of_get_option('facebook_link') ) : ?>
            <a href="<?php echo esc_url(of_get_option('facebook_link')); ?>" target="_blank" rel="noopener" title="Facebook" style="width:32px;height:32px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:5px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="#FFBA09"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
            </a>
            <?php endif; ?>
            <?php if ( of_get_option('twitter_link') ) : ?>
            <a href="<?php echo esc_url(of_get_option('twitter_link')); ?>" target="_blank" rel="noopener" title="X / Twitter" style="width:32px;height:32px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:5px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="#FFBA09"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
            <?php endif; ?>
            <?php if ( of_get_option('linkedin_link') ) : ?>
            <a href="<?php echo esc_url(of_get_option('linkedin_link')); ?>" target="_blank" rel="noopener" title="LinkedIn" style="width:32px;height:32px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:5px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="#FFBA09"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
            </a>
            <?php endif; ?>
            <a href="https://api.whatsapp.com/send?phone=971527966265" target="_blank" rel="noopener" title="WhatsApp" style="width:32px;height:32px;background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.2);border-radius:5px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="#F59E0B"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            </a>
          </div>
        </div>

        <!-- Col 2: Get In Touch -->
        <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:32px;">
          <p style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:2px; color:#FFBA09; margin:0 0 14px; padding-bottom:8px; border-bottom:1px solid rgba(255,186,9,0.15);">Get In Touch</p>
          <?php
          $addr  = of_get_option('header_address');
          $email = of_get_option('email_address');
          $phone = of_get_option('contact_no');
          if ( $addr ) : ?>
          <div style="display:flex; gap:9px; margin-bottom:13px; align-items:flex-start;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FFBA09" stroke-width="2" style="flex-shrink:0; margin-top:2px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <span style="color:#ffffff; font-size:12px; line-height:1.6;"><?php echo esc_html($addr); ?></span>
          </div>
          <?php endif; if ( $email ) : ?>
          <div style="display:flex; gap:9px; margin-bottom:13px; align-items:center;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FFBA09" stroke-width="2" style="flex-shrink:0;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <a href="mailto:<?php echo esc_attr($email); ?>" style="color:#ffffff; font-size:12px; text-decoration:none;"><?php echo esc_html($email); ?></a>
          </div>
          <?php endif; if ( $phone ) : ?>
          <div style="display:flex; gap:9px; margin-bottom:20px; align-items:center;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="#FFBA09" style="flex-shrink:0;"><path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.25 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1C10.85 21 3 13.15 3 4c0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/','',$phone)); ?>" style="color:#ffffff; font-size:12px; text-decoration:none;"><?php echo esc_html($phone); ?></a>
          </div>
          <?php endif; ?>
          <a href="https://api.whatsapp.com/send?phone=971527966265&text=Hello%2C%20I%20need%20a%20printing%20quote" target="_blank" rel="noopener"
             style="display:inline-flex;align-items:center;gap:8px;background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.2);border-radius:5px;color:#F59E0B;font-size:12px;font-weight:700;text-decoration:none;padding:9px 14px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="#F59E0B"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            <span style="color:#F59E0B;">WhatsApp Us</span>
          </a>
        </div>

        <!-- Col 3: Useful Links -->
        <div class="col-md-2 col-sm-6 col-xs-12" style="margin-bottom:32px;">
          <p style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:2px; color:#FFBA09; margin:0 0 14px; padding-bottom:8px; border-bottom:1px solid rgba(255,186,9,0.15);">Useful Links</p>
          <div id="ea-fnav">
            <?php wp_nav_menu( array(
              'theme_location' => 'footer_menu',
              'menu'           => 'Useful Links',
              'menu_class'     => 'footer-widget-list',
              'container'      => false,
              'depth'          => 1,
            ) ); ?>
          </div>
        </div>

        <!-- Col 4: Contact Form -->
        <div class="col-md-4 col-sm-12 col-xs-12" style="margin-bottom:32px;">
          <p style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:2px; color:#FFBA09; margin:0 0 14px; padding-bottom:8px; border-bottom:1px solid rgba(255,186,9,0.15);">Contact Us</p>
          <div id="ea-fcf7">
            <?php echo do_shortcode('[contact-form-7 id="39" title="NEWSLETTER" html_class="ea-footer-cf7"]'); ?>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- SEO strip -->
  <div id="ea-foot-seo" style="background:#050509; border-top:1px solid rgba(255,255,255,0.05); padding:14px 0 10px;">
    <div class="container">
      <p style="color:#94a3b8; font-size:9px; font-weight:700; letter-spacing:2px; text-transform:uppercase; margin:0 0 8px;">Printing &amp; Signage Services in Dubai</p>
      <?php
      $seo_pages = array(
        array('Same-Day Printing',  '/same-day-printing-dubai/'),
        array('Backdrop Printing',  '/backdrop-printing-dubai/'),
        array('Roll-Up Banners',    '/roll-up-banner-printing-dubai/'),
        array('Banner Printing',    '/banner-printing-dubai/'),
        array('Signage Company',    '/signage-company-dubai/'),
        array('Large Format',       '/large-format-printing-dubai/'),
        array('Exhibition Stands',  '/exhibition-stand-printing-dubai/'),
        array('Vehicle Branding',   '/vehicle-branding-dubai/'),
        array('Sticker Printing',   '/sticker-printing-dubai/'),
        array('Flag Printing',      '/flag-printing-dubai/'),
        array('Wall Graphics',      '/wall-graphics-dubai/'),
        array('3D Signage',         '/3d-signage-dubai/'),
      );
      foreach ( $seo_pages as $sp ) : ?>
      <a href="<?php echo esc_url(home_url($sp[1])); ?>"><?php echo esc_html($sp[0]); ?> Dubai</a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Copyright -->
  <div style="background:#03030A; border-top:1px solid rgba(255,255,255,0.05); padding:14px 20px; display:flex; align-items:center; justify-content:center; position:relative;">
    <span style="color:#e2e8f0; font-size:11px;">
      <?php echo of_get_option('copyright_text') ? esc_html(of_get_option('copyright_text')) : 'Copyright &copy; ' . date('Y') . ' Efficient Advertising LLC. All Rights Reserved'; ?>
    </span>
    <a id="back2Top" href="javascript:void(0);" aria-label="Back to top"
       style="position:absolute; right:20px; top:50%; transform:translateY(-50%); width:30px; height:30px; background:#FFBA09; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; text-decoration:none;">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0A0A14" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg>
    </a>
  </div>

</footer>

<!-- Scripts -->
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/wow.min.js"></script>

<?php wp_footer(); ?>

<!-- FAQ ACCORDION JS -->
<script>
(function(){
  document.querySelectorAll('.ea-faq-q').forEach(function(btn){
    btn.addEventListener('click', function(){
      var answer = this.nextElementSibling;
      var isOpen = this.getAttribute('aria-expanded') === 'true';
      // Close all others
      document.querySelectorAll('.ea-faq-q').forEach(function(b){
        b.setAttribute('aria-expanded','false');
        b.nextElementSibling.classList.remove('open');
      });
      // Toggle clicked
      if (!isOpen) {
        this.setAttribute('aria-expanded','true');
        answer.classList.add('open');
      }
    });
  });
})();
</script>

<!-- STICKY MOBILE CTA BAR -->
<div class="ea-sticky-bar" id="eaStickyBar">
  <a href="tel:+971527966265" class="ea-sticky-btn ea-sticky-call">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.25 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1C10.85 21 3 13.15 3 4c0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
    Call Us
  </a>
  <a href="https://api.whatsapp.com/send?phone=971527966265&text=Hello%2C%20I%20need%20a%20printing%20quote" target="_blank" rel="noopener" class="ea-sticky-btn ea-sticky-wa">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    WhatsApp Us
  </a>
  <a href="/contact-us/" class="ea-sticky-btn ea-sticky-quote">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
    Get a Quote
  </a>
</div>
<style>
.ea-sticky-bar {
  display: none; /* desktop hidden */
  position: fixed;
  bottom: 0; left: 0; right: 0;
  z-index: 9999;
  background: #fff;
  box-shadow: 0 -2px 16px rgba(0,0,0,0.15);
  padding: 0;
  border-top: 1px solid #e2e8f0;
}
.ea-sticky-btn {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 4px;
  padding: 10px 4px 8px;
  font-size: 11px;
  font-weight: 700;
  text-decoration: none;
  text-transform: uppercase;
  letter-spacing: 0.3px;
  transition: background 0.15s;
}
.ea-sticky-call  { color: #0F172A; border-right: 1px solid #e2e8f0; }
.ea-sticky-wa    { color: #F59E0B; border-right: 1px solid #e2e8f0; }
.ea-sticky-quote { color: #fff; background: #1a1a2e; }
.ea-sticky-call:hover  { background: #f8fafc; color: #0F172A; }
.ea-sticky-wa:hover    { background: #fffbeb; color: #F59E0B; }
.ea-sticky-quote:hover { background: #334155; color: #fff; }
@media (max-width: 767px) {
  .ea-sticky-bar { display: flex; }
  /* Push page content up so sticky bar doesn't overlap footer */
  body { padding-bottom: 62px; }
}
</style>
<!-- END STICKY MOBILE CTA BAR -->

<script>
/* ── Hide URL preview in browser status bar for all WA / tel links ── */
(function(){
  function activateNoHref(el) {
    var url = el.getAttribute('data-url') || el.getAttribute('href') || '';
    if (!url || url === '#' || url === 'javascript:;') return;
    el.removeAttribute('href');
    el.setAttribute('data-url', url);
    el.style.cursor = 'pointer';
    el.addEventListener('click', function(e){
      e.preventDefault();
      if (url.indexOf('tel:') === 0) {
        window.location.href = url;
      } else {
        window.open(url, '_blank', 'noopener,noreferrer');
      }
    });
    el.addEventListener('keydown', function(e){
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        url.indexOf('tel:') === 0 ? (window.location.href = url) : window.open(url, '_blank', 'noopener,noreferrer');
      }
    });
  }
  /* Pre-tagged with ea-no-href class (header call button) */
  document.querySelectorAll('.ea-no-href').forEach(activateNoHref);
  /* All tel: and WhatsApp links site-wide */
  document.querySelectorAll('a[href^="tel:"], a[href*="whatsapp.com/send"], a[href*="wa.me/"]').forEach(activateNoHref);
})();
</script>


<!-- ==========================================
     PREMIUM ANIMATIONS & MOUSE FOLLOWER 
     ========================================== -->
<div class="ea-bg-animation">
  <svg class="blob blob-1" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
    <path fill="#F59E0B" d="M45.7,-76.3C58.9,-69.3,69.1,-56,76.5,-41.8C83.9,-27.6,88.4,-12.3,86.6,2.3C84.8,16.8,76.6,30.6,66.8,42.4C57,54.1,45.6,63.9,32.2,71.2C18.8,78.5,3.3,83.4,-11.7,82.4C-26.7,81.3,-41.1,74.3,-53.4,64.2C-65.6,54.1,-75.7,40.9,-81.4,26.1C-87,11.3,-88.2,-5,-83.4,-18.7C-78.5,-32.4,-67.5,-43.5,-55.1,-51.6C-42.7,-59.7,-28.9,-65,-14.8,-67.8C-0.6,-70.6,14.6,-71.1,29.3,-72.1C44,-73,59.2,-74.5,45.7,-76.3Z" transform="translate(100 100)" />
  </svg>
  <svg class="blob blob-2" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
    <path fill="#0F172A" d="M38.8,-63.9C52.4,-57.4,66.8,-49.6,76,-37.9C85.1,-26.2,89,-10.6,87.7,4.5C86.4,19.5,79.9,34.1,70.1,45.9C60.3,57.7,47.2,66.7,32.8,72.4C18.4,78.2,2.7,80.7,-11.7,78.5C-26.1,76.3,-39.2,69.5,-50.2,59.5C-61.2,49.6,-70.1,36.5,-75.5,21.9C-80.9,7.3,-82.8,-8.7,-78.3,-22.6C-73.8,-36.5,-62.9,-48.3,-50,-55C-37,-61.7,-22.1,-63.3,-7.9,-66.2C6.3,-69.1,20.6,-73.2,33.5,-73.5C46.4,-73.8,57.8,-70.3,38.8,-63.9Z" transform="translate(100 100)" />
  </svg>
</div>

<div class="ea-cursor-dot"></div>
<div class="ea-cursor-ring"></div>

<style>
/* Background Blobs */
.ea-bg-animation {
  position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; 
  z-index: -1; pointer-events: none; overflow: hidden; 
  background: #ffffff;
}
.ea-bg-animation .blob {
  position: absolute; width: 800px; height: 800px; 
  filter: blur(120px); opacity: 0.15; 
  animation: floatBlobs 25s ease-in-out infinite alternate;
}
.blob-1 { top: -200px; left: -200px; }
.blob-2 { bottom: -200px; right: -150px; animation-delay: -10s; }

@keyframes floatBlobs {
  0% { transform: translate(0, 0) scale(1) rotate(0deg); }
  50% { transform: translate(100px, 150px) scale(1.1) rotate(45deg); }
  100% { transform: translate(-50px, 200px) scale(0.9) rotate(90deg); }
}

/* Mouse Follower Cursor */
body { cursor: none; } /* Hide default cursor */
.ea-cursor-dot {
  position: fixed; top: 0; left: 0;
  width: 8px; height: 8px;
  background-color: #F59E0B;
  border-radius: 50%;
  transform: translate(-50%, -50%);
  pointer-events: none;
  z-index: 999999;
  transition: width 0.2s, height 0.2s, background-color 0.2s;
}
.ea-cursor-ring {
  position: fixed; top: 0; left: 0;
  width: 36px; height: 36px;
  border: 2px solid rgba(245, 158, 11, 0.4);
  border-radius: 50%;
  transform: translate(-50%, -50%);
  pointer-events: none;
  z-index: 999998;
  box-sizing: border-box;
  transition: width 0.2s, height 0.2s, border-color 0.2s;
}
/* Interaction states */
.ea-cursor-dot.hover { transform: translate(-50%, -50%) scale(1.5); background-color: #0F172A; }
.ea-cursor-ring.hover { width: 50px; height: 50px; border-color: rgba(15, 23, 42, 0.5); background-color: rgba(245, 158, 11, 0.1); }
</style>

<script>
  // Mouse Follower JS
  const dot = document.querySelector('.ea-cursor-dot');
  const ring = document.querySelector('.ea-cursor-ring');
  let mouseX = 0, mouseY = 0;
  let ringX = 0, ringY = 0;

  document.addEventListener('mousemove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;
    dot.style.transform = `translate(${mouseX}px, ${mouseY}px)`;
  });

  function renderRing() {
    ringX += (mouseX - ringX) * 0.15;
    ringY += (mouseY - ringY) * 0.15;
    ring.style.transform = `translate(${ringX}px, ${ringY}px)`;
    requestAnimationFrame(renderRing);
  }
  requestAnimationFrame(renderRing);

  // Add hover effect to interactive elements
  const interactives = document.querySelectorAll('a, button, input, select, textarea, .owl-nav div');
  interactives.forEach(el => {
    el.addEventListener('mouseenter', () => {
      dot.classList.add('hover');
      ring.classList.add('hover');
    });
    el.addEventListener('mouseleave', () => {
      dot.classList.remove('hover');
      ring.classList.remove('hover');
    });
  });
</script>
<!-- ========================================== -->

</body>
</html>
