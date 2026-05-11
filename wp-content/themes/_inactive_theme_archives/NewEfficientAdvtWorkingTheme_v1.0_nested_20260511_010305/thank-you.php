<?php
/**
 * Template Name: Thank-you
 *
 */
 get_header(); ?>

<h1 class="my-5 thnaku"style="text-align:center; color: #F5F7FA;"><?php the_title(); ?>
</h1>
<span id="timer"></span>

<p class="" style="text-align: center; color: #B8C2CC;"><?php the_content(); ?></p>
<script type="text/javascript">
   var count = 5;
   var redirect = "<?php echo home_url(); ?>";
   function countDown(){
   var timer = document.getElementById("timer");
   if(count > 0){
   count--;
   timer.innerHTML = ""+count+"";
   setTimeout("countDown()", 1000);
   }else{
   window.location.href = redirect;
   }
   }
   countDown();
</script>
<style type="text/css">
  body{background:#0B1F38;}
   #timer{
   font-size:30px;
  color:#F5F7FA;
   display: table;
   margin:00px auto 20px;
   text-align: center;
  border: 4px solid #D4A73A;
   width: 50px;
   height: 50px;
   padding: 0px 0px;
   border-radius: 100%;
   }
</style>

<!-- Google Ads Conversion Tracking — fires only on thank-you page -->
<!-- IMPORTANT: Replace CONVERSION_LABEL_HERE with your label from Google Ads → Goals → Conversions → your action → Tag details -->
<script>
  if ( typeof gtag === 'function' ) {
    gtag('event', 'conversion', {
      'send_to': 'AW-854448823/LuqOCKjBmKMBELe1t5cD'
    });
  }
</script>

<?php get_footer(); ?>
