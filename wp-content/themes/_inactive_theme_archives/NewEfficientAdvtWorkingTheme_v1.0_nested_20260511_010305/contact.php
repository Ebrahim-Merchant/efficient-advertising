<?php
/**
 * Template Name: Contact Us
 *
 */
 get_header(); ?>
<section class="contdetail">

  <div class="icon-box-area mb-100 mb-md-30 mb-sm-30">
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-md-70 mb-sm-70">
          <!--=======  single icon box  =======-->
          
          <div class="single-icon-box">
            <div class="icon-box-icon">
             <i class="fa fa-map-marker" aria-hidden="true"></i>
            </div>
            <div class="icon-box-content">
              <h3 class="title">ADDRESS</h3>
              <p class="content"><?php if(of_get_option('header_address')) { echo of_get_option('header_address');} else { echo ""; } ?></p>
            </div>
          </div>
          
          <!--=======  End of single icon box  =======-->
        </div>
        <div class="col-md-4 mb-md-70 mb-sm-70">
          <!--=======  single icon box  =======-->
          
          <div class="single-icon-box mb-10">
            <div class="icon-box-icon">
        <i class="fa fa-phone" aria-hidden="true"></i>
            </div>
            <div class="icon-box-content">
              <h3 class="title">PHONE</h3>
              <p class="content"><a href="tel: <?php if(of_get_option('contact_no')) { echo of_get_option('contact_no');} else { echo ""; } ?>" > Phone: <?php if(of_get_option('contact_no')) { echo of_get_option('contact_no');} else { echo ""; } ?></a></p>
            </div>
          </div>
          
       
          
          <!--=======  End of single icon box  =======-->
        </div>
        <div class="col-md-4 mb-md-70 mb-sm-70">
          <!--=======  single icon box  =======-->
          
            <div class="single-icon-box">
            <div class="icon-box-icon">
            <i class="fa fa-envelope" aria-hidden="true"></i>
            </div>
            <div class="icon-box-content">
               <h3 class="title">EMAIL</h3>
              <p class="content"> <a href="mailto:<?php if(of_get_option('email_address')) { echo of_get_option('email_address');} else { echo ""; } ?>?&cc=efficientadvt1@gmail.com&bcc=efficientadvertisingllc@gmail.com"><?php if(of_get_option('email_address')) { echo of_get_option('email_address');} else { echo ""; } ?></a></p>
            </div>
          </div>
          
          <!--=======  End of single icon box  =======-->
        </div>
      </div>
    </div>
  </div>

<div class="map">
  <div class="container">
	  <?php if(get_field('google_map')) { echo get_field('google_map');} else { echo ""; } ?>
  </div>
</div>

  <div class="section-title-container mb-50 mt50">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <!--=======  section title  =======-->
          
          <div class="section-title section-title--one text-center">
            <h1>Get in touch</h1>
          </div>
          
          <!--=======  End of section title  =======-->
        </div>
      </div>
    </div>
  </div>
  <div class="contact-form-area mb-60">
    <div class="container">
      <div class="row">
<div class="col-md-2 hidden-xs hidden-sm"></div>
        <div class="col-lg-8 col-xs-12">
          <div class="lezada-form contact-form">
            <?php echo do_shortcode('[contact-form-7 id="210" title="contact"]'); ?>
          </div>
          <p class="form-messege pt-10 pb-10 mt-10 mb-10"></p>
        </div>
        <div class="col-md-2 hidden-xs hidden-sm"></div>
      </div>
    </div>
  </div>
</section>



<?php get_footer(); ?>