<?php get_header(); ?>

<!-- Blog archive header -->
<div style="background:#fff; border-bottom:1px solid #eee; padding:44px 0 40px; text-align:center;">
  <div class="container">
    <p style="font-size:12px; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:#555; margin:0 0 10px;">Stay Updated With Trends</p>
    <h1 style="font-size:36px; font-weight:800; color:#1a1a2e; margin:0 0 14px; position:relative; display:inline-block; padding-bottom:14px;">
      Latest News &amp; Blog
      <span style="display:block; width:60px; height:3px; background:#e63946; border-radius:2px; position:absolute; bottom:0; left:50%; transform:translateX(-50%);"></span>
    </h1>
  </div>
</div>

<!-- Blog post grid -->
<section style="background:#fff; padding:48px 0 64px;">
  <div class="container">

    <?php if ( have_posts() ) : ?>

    <div class="row">
      <?php while ( have_posts() ) : the_post();
        $post_url = esc_url( get_permalink( get_the_ID() ) );
        $thumb    = has_post_thumbnail()
          ? get_the_post_thumbnail_url( get_the_ID(), 'medium_large' )
          : null;
      ?>
      <div class="col-md-3 col-sm-6" style="margin-bottom:32px;">
        <div style="background:#fff; border-radius:4px; overflow:hidden; box-shadow:0 1px 6px rgba(0,0,0,.08); height:100%; display:flex; flex-direction:column;">

          <!-- Image with date badge -->
          <a href="<?php echo $post_url; ?>" style="display:block; position:relative; overflow:hidden; flex-shrink:0;">
            <?php if ( $thumb ) : ?>
            <img src="<?php echo esc_url($thumb); ?>"
                 alt="<?php the_title_attribute(); ?>"
                 style="width:100%; height:200px; object-fit:cover; display:block; transition:transform .35s ease;"
                 onmouseover="this.style.transform='scale(1.05)'"
                 onmouseout="this.style.transform='scale(1)'" />
            <?php else : ?>
            <div style="width:100%; height:200px; background:linear-gradient(135deg,#1a1a2e 0%,#0082C8 100%); display:flex; align-items:center; justify-content:center;">
              <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
            </div>
            <?php endif; ?>
            <!-- Date badge -->
            <div style="position:absolute; top:12px; left:12px; background:#e63946; color:#fff; border-radius:50%; width:52px; height:52px; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; line-height:1.1;">
              <span style="font-size:17px; font-weight:800;"><?php echo get_the_date('d'); ?></span>
              <span style="font-size:10px; font-weight:700; text-transform:uppercase;"><?php echo get_the_date('M'); ?></span>
            </div>
          </a>

          <div style="padding:14px 16px 18px; flex:1; display:flex; flex-direction:column;">
            <p style="font-size:12px; color:#e63946; margin:0 0 6px 0; font-weight:600;">Posted by <?php the_author(); ?> -</p>
            <h2 style="font-size:15px; font-weight:700; line-height:1.45; color:#1a1a2e; margin:0 0 10px; flex:1;">
              <a href="<?php echo $post_url; ?>" style="color:inherit; text-decoration:none;"><?php echo wp_trim_words( get_the_title(), 10, '&hellip;' ); ?></a>
            </h2>
          </div>

        </div>
      </div>
      <?php endwhile; ?>
    </div>

    <!-- Pagination -->
    <div class="row text-center" style="margin-top:8px;">
      <div class="col-sm-12">
        <div style="font-size:14px;">
        <?php
          echo paginate_links([
            'prev_text' => '&larr; Newer',
            'next_text' => 'Older &rarr;',
          ]);
        ?>
        </div>
      </div>
    </div>

    <?php else : ?>
    <p style="text-align:center; color:#888;">No posts found.</p>
    <?php endif; ?>

  </div>
</section>

<!-- CTA strip -->
<div style="background:#1a1a2e; padding:40px 0; text-align:center;">
  <div class="container">
    <p style="color:#aaa; font-size:14px; margin:0 0 16px;">Ready to print? Efficient Advertising — Dubai's printing specialists since 2008.</p>
    <a href="<?php echo esc_url( home_url('/contact-us/') ); ?>" class="cta-primary"
       style="display:inline-block; background:#2563eb; color:#fff; padding:14px 32px; border-radius:6px; font-size:15px; font-weight:700; text-decoration:none; margin-right:10px;">
      Get a Free Quote
    </a>
    <a href="<?php echo esc_url( home_url('/') ); ?>"
       style="display:inline-block; background:transparent; color:#aaa; padding:13px 20px; font-size:14px; text-decoration:none;">
      &larr; Back to Home
    </a>
  </div>
</div>

<?php get_footer(); ?>
