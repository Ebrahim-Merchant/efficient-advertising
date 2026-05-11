<?php get_header(); ?>

<!-- Post breadcrumb bar -->
<div style="background:#1a1a2e; padding:14px 0; border-bottom:2px solid #0082C8;">
  <div class="container">
    <p style="margin:0; font-size:13px; color:#aaa;">
      <a href="<?php echo esc_url( home_url('/') ); ?>" style="color:#aaa; text-decoration:none;">Home</a>
      &nbsp;/&nbsp;
      <a href="<?php echo esc_url( get_permalink( get_option('page_for_posts') ) ); ?>" style="color:#aaa; text-decoration:none;">Blog</a>
      &nbsp;/&nbsp;
      <?php
        $cats = get_the_category();
        if ( $cats ) :
          foreach ( $cats as $cat ) :
      ?>
      <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" style="color:#0082C8; text-decoration:none;"><?php echo esc_html($cat->name); ?></a>
      &nbsp;/&nbsp;
      <?php endforeach; endif; ?>
      <span style="color:#fff;"><?php the_title(); ?></span>
    </p>
  </div>
</div>

<!-- Post hero title -->
<div style="background:#f5f7fa; padding:48px 0 40px; border-bottom:1px solid #e8e8e8;">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2 text-center">
        <?php
          $cats = get_the_category();
          if ($cats) :
            $cat = $cats[0];
        ?>
        <a href="<?php echo esc_url( get_category_link($cat->term_id) ); ?>"
           style="display:inline-block; font-size:11px; font-weight:700; letter-spacing:2.5px; text-transform:uppercase; color:#0082C8; text-decoration:none; margin-bottom:14px;">
          <?php echo esc_html($cat->name); ?>
        </a>
        <?php endif; ?>
        <h1 style="font-size:30px; font-weight:800; color:#1a1a2e; line-height:1.35; margin:0 0 18px;"><?php the_title(); ?></h1>
        <p style="font-size:13px; color:#888; margin:0;">
          By <strong style="color:#555;"><?php the_author(); ?></strong>
          &nbsp;&middot;&nbsp;
          <?php echo get_the_date('d M Y'); ?>
          &nbsp;&middot;&nbsp;
          <?php echo ceil( str_word_count( strip_tags( get_the_content() ) ) / 200 ); ?> min read
        </p>
      </div>
    </div>
  </div>
</div>

<!-- Featured image -->
<?php if ( has_post_thumbnail() ) : ?>
<div style="background:#1a1a2e; text-align:center; max-height:460px; overflow:hidden;">
  <img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>"
       alt="<?php the_title_attribute(); ?>"
       style="width:100%; max-height:460px; object-fit:cover; display:block; margin:0 auto; opacity:.92;" />
</div>
<?php endif; ?>

<!-- Post body -->
<section style="padding:56px 0 64px; background:#fff;">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">

        <div class="entry-content" style="font-size:16px; line-height:1.85; color:#333;">
          <?php the_content(); ?>
        </div>

        <!-- Post footer meta -->
        <div style="margin-top:48px; padding-top:24px; border-top:1px solid #eee; display:flex; align-items:center; flex-wrap:wrap; gap:12px;">
          <?php
            $tags = get_the_tags();
            if ($tags) :
              foreach ($tags as $tag) :
          ?>
          <a href="<?php echo esc_url( get_tag_link($tag->term_id) ); ?>"
             style="font-size:12px; background:#f0f4f8; color:#555; padding:5px 12px; border-radius:20px; text-decoration:none; white-space:nowrap;">
            #<?php echo esc_html($tag->name); ?>
          </a>
          <?php endforeach; endif; ?>
        </div>

        <!-- Back to blog -->
        <div style="margin-top:36px;">
          <a href="<?php echo esc_url( get_permalink( get_option('page_for_posts') ) ); ?>"
             style="font-size:13px; font-weight:700; color:#0082C8; text-decoration:none;">
            &larr; Back to Blog
          </a>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- Related posts / CTA strip -->
<div style="background:#1a1a2e; padding:40px 0; text-align:center;">
  <div class="container">
    <p style="color:#aaa; font-size:14px; margin:0 0 16px;">Need printing or advertising in Dubai?</p>
    <a href="<?php echo esc_url( home_url('/contact-us/') ); ?>" class="cta-primary"
       style="display:inline-block; background:#2563eb; color:#fff; padding:14px 32px; border-radius:6px; font-size:15px; font-weight:700; text-decoration:none; margin-right:10px;">
      Get a Free Quote
    </a>
    <a href="https://api.whatsapp.com/send?phone=971527966265" class="cta-wa"
       style="display:inline-block; background:#16a34a; color:#fff; padding:14px 32px; border-radius:6px; font-size:15px; font-weight:700; text-decoration:none;">
      WhatsApp Us
    </a>
  </div>
</div>

<style>
.entry-content h2 { font-size:22px; font-weight:700; color:#1a1a2e; margin:36px 0 14px; }
.entry-content h3 { font-size:18px; font-weight:700; color:#1a1a2e; margin:28px 0 10px; }
.entry-content ul, .entry-content ol { padding-left:24px; margin-bottom:20px; }
.entry-content li { margin-bottom:6px; }
.entry-content table { width:100%; border-collapse:collapse; margin:20px 0; font-size:14px; }
.entry-content th { background:#1a1a2e; color:#fff; padding:10px 14px; text-align:left; }
.entry-content td { padding:10px 14px; border-bottom:1px solid #eee; color:#444; }
.entry-content tr:nth-child(even) td { background:#f9f9f9; }
.entry-content hr { border:none; border-top:1px solid #e8e8e8; margin:32px 0; }
.entry-content a { color:#0082C8; }
</style>

<?php get_footer(); ?>
