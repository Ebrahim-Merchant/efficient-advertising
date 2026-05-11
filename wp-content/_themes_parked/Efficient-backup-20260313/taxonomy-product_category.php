<?php get_header(); ?>  

<?php

    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $uri_segments = explode('/', $uri_path);

    $url =  $uri_segments[2];

    $urlone =  $uri_segments[2];

   // print_r($urlone);

   // exit; 

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 

$term_name =  $term->name; // will show the name

 

?> 
<div class="tabsflags">
  <div class="container">
 <!--  <ul class="nav nav-tabs">
     <li class="active"><a data-toggle="tab" href="">ALL CATEGORIES</a></li>
 
  <li><a  href="ADVERTISING">ADVERTISING FLAGS</a></li> 
  <li><a  href="HANDHELD">HANDHELD FLAGS </a></li>
    <li><a  href="OFFICE">OFFICE FLAGS  </a></li>
      <li><a  href="DECORATIVE">DECORATIVE FLAGS </a></li>
        <li><a  href="OUTDOOR">OUTDOOR FLAGS</a></li>
          <li><a  href="FLAG">FLAG BASE</a></li>
</ul> -->

<div class="tab-content lefop">
  <div id="all" class="tab-pane fade in active">
    <div class="fullsopt">
    <div class="titledpe">
      <h1 style="font-size: 28px;"><?php echo $term_name; ?></h1>
    </div>
		
    <div class="tabscategory">
      <div class="row">
        <?php

                  $args = array(

                    'post_type' => 'product','posts_per_page' => '-1',

                    'tax_query' => array(

                        array(

                            'taxonomy' => 'product_category',

                            'field' => 'slug',

                            'terms' => $urlone

                        )

                    )

                  );

                  $my_query =  new WP_Query($args); 

                  $count=1;

                  while($my_query->have_posts()) :

                  $my_query->the_post();

                  $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->id), 'full');

            ?> 
          <div class="col-md-3">
          <div class="zoom-img ">
                    <figure>
                      <a href="<?php the_permalink(); ?>"><img class="img-responsive" src="<?php echo $thumb['0']; ?>" alt="Photo"></a>
                    </figure>
                    <div class="text-box">
                      <div class="text-content mb-20">
                      <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                      </div>
                  </div>
                  </div>
              </div>
         <?php 

             $count++; 

             endwhile; 

             wp_reset_query(); 

          ?> 

      </div>
    </div>
    </div>
  </div>
<?php if (strlen(category_description()) > 0) {
echo "<div id='catdesc'>";
echo category_description();
echo "</div>";
}
?>
</div>
</div>

</div>

<section class="blog bestblogred">

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

                  $args = array(

                    'post_type' => 'product',  'orderby'        => 'rand','posts_per_page' => '4',

                    'tax_query' => array(

                        array(

                            'taxonomy' => 'product_category',

                            'field' => 'slug',

                           'terms' => $urlone

                        )

                    )

                  );

                  $my_query =  new WP_Query($args); 

                  $count=1;

                  while($my_query->have_posts()) :

                  $my_query->the_post();

                  $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->id), 'full');

            ?> 
<div class="col-md-3">
  
         
        <div class="zoom-img ">


                  <figure>

                    <a href="<?php the_permalink(); ?>"><img class="img-responsive" src="<?php echo $thumb['0']; ?>"></a>

                  </figure>

                  <div class="text-box">

                    <div class="text-content mb-20">

                    <h3><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>

                    </div>

                </div>

                </div>
               
            </div>
           <?php 
                      endwhile; 
                      wp_reset_query(); 
              ?> 
            </div>

          </div>
        </div>

      </section>
<?php get_footer(); ?>