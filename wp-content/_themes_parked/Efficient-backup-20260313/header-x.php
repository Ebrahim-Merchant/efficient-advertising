<!DOCTYPE html>



<html lang="en">



<head>



  <title>EFFICIENT</title>

  <?php

   if (of_get_option('favicon')) {



    ?>



        <link rel="shortcut icon" type="image/png" href="<?php echo of_get_option('favicon'); ?>" />



    <?php



    }



    ?>



<meta content='IE=edge' http-equiv='X-UA-Compatible'>



<meta http-equiv='content-type' content='text/html; charset=UTF-8'>



<meta charset='UTF-8'>



<meta name='viewport' content='width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0'>



  <link rel="shortcut icon" href="faviconn.ico" type="image/x-icon">



<link rel="icon" href="faviconn.ico" type="image/x-icon">



 <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css">



 <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/animate.css">



   <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">



  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/owl.carousel.min.css">



     <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/owl.theme.default.min.css">



    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.min.css">



    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/blueimp-gallery.min.css">



    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/blueimp-gallery-indicator.css"> 







<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-3.3.1.min.js"></script>



<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>



   <script src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.min.js"></script> 



   <script src="<?php echo get_template_directory_uri(); ?>/js/wow.min.js"></script>         



    <script>



wow = new WOW( {



    boxClass:     'wow',



    animateClass: 'animated',



    offset:       100



    }



);







wow.init();



</script> 











</head>



<body> 



 



  <div id="header">







 



   <nav class="navbar navbar-inverse">



 <div class="container">







   <div class="middle">



       <div class="logo">



      <a class="" href="<?php echo home_url(); ?>">

      <?php if (of_get_option('logo')) { ?>



                                    <img src="<?php echo of_get_option('logo'); ?>" alt="Logo">



                                <?php



                                } else { ?>



                                    <img src="<?php echo get_template_directory_uri(); ?>">



                                <?php



                                }



                                ?>

                                </a>

      </div>



   </div>



<div class="rightside">



    <div class="navbar-header">



      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">



        <span class="icon-bar"></span>



        <span class="icon-bar"></span>



        <span class="icon-bar"></span> 



      </button>



    </div>



   <div class="collapse navbar-collapse" id="myNavbar">



       

        <div class="navbar-right" style="display:flex;gap:8px;align-items:center;margin:13px 0;">
          <a class="contbtn" style="float:none;margin:0;background:#1e293b;" href="<?php echo esc_url( home_url('/payment/') ); ?>">PAY NOW</a>
          <a class="contbtn" style="float:none;margin:0;" href="<?php echo esc_url( home_url('/contact-us/') ); ?>">CONTACT US</a>
        </div>
        <?php wp_nav_menu( array( 'theme_location' => 'header_menu','menu' => 'Header Menu', 'menu_class' => 'nav navbar-nav','container' => 'false' ) ); ?>

    </div>



 </div>



</div>



</nav>



</div>



<script>







$(document).ready(function(){  



  $('#home').owlCarousel({



    loop:true,



    nav:false,



    dots:false,



    autoplay:true,



    smartSpeed :2000,



    responsiveClass:true,



    navText : ["<i class='fa fa-long-arrow-left'></i>","<i class='fa fa-long-arrow-right'></i>"],



    responsive:{



        0:{



            items:1,



            nav:false



        },



        600:{



            items:1,



            nav:false



        },



        1000:{



            items:1,



            nav:true 



        }



    }



});











  $('#testimonial').owlCarousel({



    loop:true,



    nav:true,



    dots:true,



    autoplay:true,



    smartSpeed :1500,



    responsiveClass:true,



    responsive:{



        0:{



            items:1,



            nav:false



        },



        600:{



            items:1,



            nav:false



        },



        1000:{



            items:1



           



        }



    }



}); 







   $('.carousel').carousel();



  



});











    $(window).scroll(function() {



    var height = $(window).scrollTop();



    if (height > 100) {



        $('#back2Top').fadeIn();



    } else {



        $('#back2Top').fadeOut();



    }



});



$(document).ready(function() {



    $("#back2Top").click(function(event) {



        event.preventDefault();



        $("html, body").animate({ scrollTop: 0 }, "slow");



        return false;



    });







});















$(".navbar .nav li a, .navbar .nav li a").click(function () {



        var dataAttr = $(this).attr('data-jump');



        $('html,body').animate({



            scrollTop: $("#" + dataAttr).offset().top - 0



        }, 1000);



    });







$(function(){



  var navbar = $('.navbar');



  



  $(window).scroll(function(){



    if($(window).scrollTop() <= 40){



      navbar.removeClass('navbar-scroll');



    } else {







      navbar.addClass('navbar-scroll');



    }



  });



});











</script>







