<footer id="footer">
  <section class="foter">
    <div class="container">
      <div class="row">

        <!-- Logo and About -->
        <div class="col-md-4 col-xs-12">
          <div class="foterlogo">
            <div class="footerheading">
              <a href="<?php echo home_url(); ?>">
                <?php if (of_get_option('footer_logo')) { ?>
                  <img src="<?php echo of_get_option('footer_logo'); ?>" alt="Logo">
                <?php } else { ?>
                  <img src="<?php echo get_template_directory_uri(); ?>/img/logo.png">
                <?php } ?>
              </a>
            </div>
            <a href="<?php echo home_url(); ?>/about-us">
              <p>
                Efficient Advertising L.L.C is Dubai's full-service printing and advertising company,
                specialising in digital printing, custom signage, vehicle branding, exhibition stands,
                and event management solutions across the UAE.
              </p>
              <p>
                Since 2008, we have built our reputation on exceptional print quality, fast
                turnaround, and outstanding customer service — combining state-of-the-art technology
                with a genuine commitment to every client's success.
              </p>
            </a>
            <!-- 
            <p>Efficient Advertising is a full-service company dedicated to the wide range of Design, Print & Event Management solutions.</p>
            <p>For more than 8 years, we have valued the importance of customer service and quality printing combined with state of the art technology. These core values continue to be the foundation of our success.</p> 
            -->
          </div>
        </div>

        <!-- Get In Touch -->
        <div class="col-md-3 col-xs-12">
          <div class="address">
            <div class="footerheading">
              <h2>Get In Touch</h2>
            </div>
            <div class="d-table">
              <div class="table-cell">
                <span>
                  Address: 
                  <?php if(of_get_option('header_address')) { echo of_get_option('header_address');} else { echo ""; } ?>
                </span>
              </div>
            </div>
            <div class="d-table">
              <div class="table-cell">
                <span>
                  <a href="mailto:<?php if(of_get_option('email_address')) { echo of_get_option('email_address');} else { echo ""; } ?>?&cc=efficientadvt1@gmail.com&bcc=efficientadvertisingllc@gmail.com">
                    Email: <?php if(of_get_option('email_address')) { echo of_get_option('email_address');} else { echo ""; } ?>
                  </a>
                </span>
              </div>
            </div>
            <div class="d-table">
              <div class="table-cell">
                <span>
                  <a href="tel: <?php if(of_get_option('contact_no')) { echo of_get_option('contact_no');} else { echo ""; } ?>">
                    Phone: <?php if(of_get_option('contact_no')) { echo of_get_option('contact_no');} else { echo ""; } ?>
                  </a>
                </span>
              </div>
            </div>
            <ul class="list-inline">
              <li style="background-color: #314987;">
                <a target="_blank" href="<?php if(of_get_option('facebook_link')) { echo of_get_option('facebook_link');} else { echo ""; } ?>">
                  <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
              </li>
              <li style="background-color: #22bbf4;">
                <a target="_blank" href="<?php if(of_get_option('twitter_link')) { echo of_get_option('twitter_link');} else { echo ""; } ?>">
                  <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
              </li>
              <li style="background-color: #006dc0;">
                <a target="_blank" href="<?php if(of_get_option('linkedin_link')) { echo of_get_option('linkedin_link');} else { echo ""; } ?>">
                  <i class="fa fa-linkedin" aria-hidden="true"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>

        <!-- Useful Links -->
        <div class="col-md-2 col-xs-12">
          <div class="address">
            <div class="footerheading">
              <h2>Useful LINKS</h2>
            </div>
            <ul class="zombo">
              <?php wp_nav_menu( array(
                'theme_location' => 'footer_menu',
                'menu'           => 'Useful Links',
                'menu_class'     => 'footer-widget-list',
                'container'      => 'true'
              ) ); ?>
            </ul>
          </div>
        </div>

        <!-- Contact Form -->
        <div class="col-md-3 col-xs-12">
          <div class="address">
            <div class="footerheading">
              <h2>Contact Us</h2>
            </div>
            <?php echo do_shortcode('[contact-form-7 id="39" title="NEWSLETTER"]'); ?>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- WhatsApp -->
  <div class="whatapp">
    <a target="_blank" href="https://api.whatsapp.com/send?phone=<?php if(of_get_option('whatsapp_no')) { echo of_get_option('whatsapp_no');} else { echo ""; } ?>">
      <img src="<?php echo get_template_directory_uri(); ?>/img/whatsapp.png">
    </a>
  </div>
</footer>

<!-- Copyright -->
<div class="copyRight">
  <div class="container">
    <div class="copyRightText">
      <span>
        <?php if(of_get_option('copyright_text')) { echo of_get_option('copyright_text');} else { echo ""; } ?>
      </span>
    </div>
  </div>
  <div class="scroll">
    <a id="back2Top" href="javascript:void(0);">
      <i class="fa fa-angle-up" aria-hidden="true"></i>
    </a>
  </div>
</div>

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
.ea-sticky-call  { color: #0284c7; border-right: 1px solid #e2e8f0; }
.ea-sticky-wa    { color: #16a34a; border-right: 1px solid #e2e8f0; }
.ea-sticky-quote { color: #fff; background: #1a1a2e; }
.ea-sticky-call:hover  { background: #f0f9ff; color: #0284c7; }
.ea-sticky-wa:hover    { background: #f0fdf4; color: #16a34a; }
.ea-sticky-quote:hover { background: #334155; color: #fff; }
@media (max-width: 767px) {
  .ea-sticky-bar { display: flex; }
  /* Push page content up so sticky bar doesn't overlap footer */
  body { padding-bottom: 62px; }
}
</style>
<!-- END STICKY MOBILE CTA BAR -->

</body>
</html>
