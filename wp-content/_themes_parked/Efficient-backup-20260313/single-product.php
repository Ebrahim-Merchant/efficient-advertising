<?php get_header(); ?> 
<!-- Page Title Start -->
<section class="flagdetail">
   <div class="container">
      <div class="row">
         <div class="col-lg-6 col-xs-12">
            <div class="leftdetail">
               <h1 style = "margin: 0px;
    text-align: center;
    padding-bottom: 20px;
    font-size: 25px;"><?php the_title(); ?></h1>
               <div class="page-holder">
                  <ul id="vertical">
                     <?php
                        $args = array('post_type' => 'product','posts_per_page' => -1,);
                        $my_query = new WP_Query($args);
                        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->id), 'full');
                    ?>
                        <li
                           data-thumb="<?php echo $thumb['0']; ?>">
                           <img src="<?php echo $thumb['0']; ?>" />
                        </li>
                     <?php 
                        wp_reset_query(); 
                    ?>
                    <?php 
                        $product_image_one = get_field('product_image_one');
                        $product_image_two = get_field('product_image_two');
                        $product_image_three = get_field('product_image_three');
                    ?>
                     <?php if($product_image_one !="") { ?>
                     <li
                        data-thumb="<?php echo $product_image_one; ?>">
                        <img src="<?php echo $product_image_one; ?>" />
                     </li>
                     <?php } ?>
                    <?php if($product_image_two !="") { ?>
                     <li
                        data-thumb="<?php echo $product_image_two; ?>">
                        <img src="<?php echo $product_image_two; ?>" />
                     </li>
                     <?php } ?>
                    <?php if($product_image_three !="") { ?>
                     <li
                        data-thumb="<?php echo $product_image_three; ?>">
                        <img src="<?php echo $product_image_three; ?>" />
                     </li>
                     <?php } ?>
                  </ul>
               </div>
               <button class="btn vewalls btn-lg" data-toggle="modal" data-target="#myviewall">ORDER NOW</button>
            </div>
         </div>
         <div class="col-lg-6 col-xs-12">
            <div class="detailright">
               <div class="selhead">
                  <!-- <h2>SPECIFICATIONS</h2> -->
               </div>
               <?php if (have_posts()) : while (have_posts()) : the_post(); ?>   
                   
                  <?php the_content(); ?>    
                   
                  <?php endwhile; endif; ?>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="blog bestblogred" style="background-color:#fff;">
   <div class="container">
      <div class="row">
         <div class="row pb-30 text-center">
            <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 ">
               <div class="creative_heading">
                  <h2>RECOMMENDED PRODUCTS</h2>
                  <br>
               </div>
            </div>
         </div>
         <div class="col-lg-12 pdn">
            <?php 
               // get the custom post type's taxonomy terms
               $custom_taxterms = wp_get_object_terms( $post->ID, 'product_category', array('fields' => 'ids') );
               // arguments
               $args = array(
               'post_type' => 'product',
               'post_status' => 'publish',
               'posts_per_page' => 4, // you may edit this number
               'orderby'        => 'rand',
               'tax_query' => array(
                   array(
                       'taxonomy' => 'product_category',
                       'field' => 'id',
                       'terms' => $custom_taxterms
                   )
               ),
               'post__not_in' => array ($post->ID),
               );
               $related_items = new WP_Query( $args );
               // loop over query
               if ($related_items->have_posts()) :

               while ( $related_items->have_posts() ) : $related_items->the_post();
            ?>
               <div class="col-md-3">
                  <div class="zoom-img ">
                     <figure>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                     </figure>
                     <div class="text-box">
                        <div class="text-content mb-20">
                           <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        </div>
                     </div>
                  </div>
               </div>
            <?php
               endwhile;
               endif;
               // Reset Post Data
               wp_reset_postdata();
            ?> 
         </div>
         <!-- <a href="" class="read__more">See More Product</a> -->
      </div>
   </div>
</section>
<div class="modal" id="myviewall">

   <div class="modal-dialog">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <div class="modal-content">
        <?php echo do_shortcode('[contact-form-7 id="211" title="Order Details"]'); ?>
      </div>
   </div>
</div>
<?php get_footer(); ?>