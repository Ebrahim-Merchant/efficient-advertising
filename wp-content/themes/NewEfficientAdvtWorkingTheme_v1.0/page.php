<?php
/**
 * Template Name: Inner Template
 **/

if ( is_page( 'blog' ) ) :
	get_header();
	$blog_query = new WP_Query( [
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 6,
		'paged'               => max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) ),
		'ignore_sticky_posts' => true,
	] );
?>

<style>
.ea-blog-page {
	background: #14365C;
}
.ea-blog-container {
	max-width: 1200px;
	margin: 0 auto;
	padding-left: clamp(20px, 4vw, 48px);
	padding-right: clamp(20px, 4vw, 48px);
}
.ea-blog-hero {
	padding: clamp(88px, 10vw, 128px) 0 clamp(38px, 5vw, 62px);
	text-align: center;
}
.ea-blog-hero h1 {
	margin: 0 0 14px;
	color: #F5F7FA;
	font-size: clamp(2rem, 4.4vw, 3rem);
	line-height: 1.15;
	letter-spacing: -0.02em;
}
.ea-blog-hero p {
	margin: 0 auto;
	max-width: 760px;
	color: #B8C2CC;
	font-size: 1.02rem;
	line-height: 1.7;
}
.ea-blog-grid-wrap {
	padding: 0 0 clamp(72px, 8vw, 100px);
}
.ea-blog-grid {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 24px;
}
.ea-blog-card {
	border-radius: 16px;
	overflow: hidden;
	border: 1px solid rgba(255,255,255,0.08);
	background: #102B49;
	box-shadow: 0 14px 36px rgba(0,0,0,0.24);
	display: flex;
	flex-direction: column;
}
.ea-blog-thumb {
	display: block;
	aspect-ratio: 16/9;
	background: #0B1F38;
}
.ea-blog-thumb img {
	width: 100%;
	height: 100%;
	object-fit: cover;
}
.ea-blog-thumb-placeholder {
	width: 100%;
	height: 100%;
	display: flex;
	align-items: center;
	justify-content: center;
	color: #B8C2CC;
	font-size: .95rem;
}
.ea-blog-body {
	padding: 18px 18px 20px;
}
.ea-blog-cat {
	display: inline-block;
	margin-bottom: 8px;
	font-size: 11px;
	font-weight: 700;
	letter-spacing: 1.2px;
	text-transform: uppercase;
	color: #D4A73A;
}
.ea-blog-body h2 {
	margin: 0 0 10px;
	font-size: 1.08rem;
	line-height: 1.35;
}
.ea-blog-body h2 a {
	color: #F5F7FA;
	text-decoration: none;
}
.ea-blog-body p {
	margin: 0 0 14px;
	color: #B8C2CC;
	font-size: .92rem;
	line-height: 1.7;
}
.ea-blog-readmore {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-width: 106px;
	height: 36px;
	border-radius: 10px;
	border: 1px solid #D4A73A;
	color: #D4A73A;
	font-size: 13px;
	font-weight: 700;
	text-decoration: none;
}
.ea-blog-readmore:hover {
	background: #D4A73A;
	color: #0B1F38;
}
.ea-blog-pagination {
	margin-top: 28px;
	text-align: center;
}
.ea-blog-pagination .page-numbers {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-width: 36px;
	height: 36px;
	margin: 0 4px;
	border-radius: 8px;
	border: 1px solid rgba(255,255,255,0.18);
	color: #F5F7FA;
	text-decoration: none;
	font-size: 13px;
	font-weight: 700;
}
.ea-blog-pagination .page-numbers.current,
.ea-blog-pagination .page-numbers:hover {
	border-color: #D4A73A;
	background: #D4A73A;
	color: #0B1F38;
}
@media (max-width: 1024px) {
	.ea-blog-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 767px) {
	.ea-blog-grid { grid-template-columns: 1fr; }
}
</style>

<main class="ea-blog-page">
	<section class="ea-blog-hero">
		<div class="ea-blog-container">
			<h1>Printing &amp; Signage Blog</h1>
			<p>Guides, tips, and insights for businesses planning signage, printing, branding, and events in Dubai.</p>
		</div>
	</section>

	<section class="ea-blog-grid-wrap">
		<div class="ea-blog-container">
			<?php if ( $blog_query->have_posts() ) : ?>
				<div class="ea-blog-grid">
					<?php while ( $blog_query->have_posts() ) : $blog_query->the_post();
						$thumb = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
						$cats  = get_the_category();
						$cat   = ! empty( $cats ) ? $cats[0]->name : 'Insights';
					?>
					<article class="ea-blog-card">
						<a class="ea-blog-thumb" href="<?php echo esc_url( get_permalink() ); ?>" aria-label="<?php the_title_attribute(); ?>">
							<?php if ( $thumb ) : ?>
								<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" width="560" height="320">
							<?php else : ?>
								<span class="ea-blog-thumb-placeholder">Efficient Advertising Blog</span>
							<?php endif; ?>
						</a>
						<div class="ea-blog-body">
							<span class="ea-blog-cat"><?php echo esc_html( $cat ); ?></span>
							<h2><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h2>
							<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 28, '…' ) ); ?></p>
							<a class="ea-blog-readmore" href="<?php echo esc_url( get_permalink() ); ?>">Read More</a>
						</div>
					</article>
					<?php endwhile; ?>
				</div>

				<div class="ea-blog-pagination">
					<?php
						echo paginate_links( [
							'prev_text' => '←',
							'next_text' => '→',
						] );
					?>
				</div>
			<?php else : ?>
				<p style="text-align:center;color:#B8C2CC;">No blog posts yet. Please check back soon.</p>
			<?php endif; wp_reset_postdata(); ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
<?php return; endif; ?>

<?php get_header(); ?>
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