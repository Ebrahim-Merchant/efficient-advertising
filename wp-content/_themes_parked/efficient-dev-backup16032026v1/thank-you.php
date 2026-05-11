<?php
/**
 * Template Name: Thank-you
 *
 */
 get_header(); ?>

<h1 class="my-5 thnaku"style="text-align:center; color: #9dc44f;"><?php the_title(); ?>
</h1>
<span id="timer"></span>

<p class="" style="text-align: center; color: #9dc44f;"><?php the_content(); ?></p>
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
   #timer{
   font-size:30px;
   display: table;
   margin:00px auto 20px;
   text-align: center;
   border: 4px solid #000;
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

<?php include("footer.php"); ?>
