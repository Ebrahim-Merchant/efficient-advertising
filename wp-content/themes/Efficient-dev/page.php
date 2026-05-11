<?php
/**
 * Template Name: Inner Template
 **/
get_header();
?>
<section class="contdetail">
	    <div class="head-title">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	
						<?php the_content(); ?>		
						<?php edit_post_link(); ?>			
						<?php endwhile; endif; ?>
					</div>
				</div>
			</div>
		</div>
       <!---end--->	
		   
</section>
<?php get_footer(); ?>