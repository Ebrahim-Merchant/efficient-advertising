<?php
/**
 * Template Name: About Us Page
 * Finch Gift Shop â€“ North York, Toronto
 * @package Efficient_Modern
 * @since 1.0.0
 */
get_header();
?>
<main class="about-us-page">
<?php while ( have_posts() ) : the_post(); ?>

<!-- ===================== FINCH GIFT SHOP: ABOUT US ===================== -->

<!-- Hero -->
<section style="background:linear-gradient(135deg,#fdf6f0 0%,#fff5f8 100%);padding:80px 0 60px;">
  <div style="max-width:1200px;margin:0 auto;padding:0 24px;">
    <div style="display:flex;flex-wrap:wrap;align-items:center;gap:48px;">
      <div style="flex:1;min-width:280px;">
        <span style="display:inline-block;background:#e8a0b4;color:#fff;font-size:.85rem;font-weight:600;letter-spacing:1px;padding:6px 14px;border-radius:20px;margin-bottom:20px;text-transform:uppercase;">North York Â· Toronto</span>
        <h1 style="font-size:2.5rem;font-weight:800;line-height:1.2;color:#1a1a2e;margin-bottom:20px;">
          Gifts That Speak <span style="color:#e8607a;">From the Heart</span>
        </h1>
        <p style="font-size:1.1rem;line-height:1.8;color:#555;margin-bottom:28px;">
          Finch Gift Shop is a premium floral and gift boutique in North York, Toronto.
          We craft stunning arrangements and thoughtful gift sets for birthdays, anniversaries,
          Mother&rsquo;s Day, Valentine&rsquo;s Day, and every special occasion.
        </p>
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
           style="display:inline-block;background:#e8607a;color:#fff;padding:14px 32px;border-radius:30px;font-weight:700;text-decoration:none;">
          Shop Our Gifts
        </a>
      </div>
      <div style="flex:1;min-width:260px;display:flex;flex-wrap:wrap;gap:20px;">
        <?php
        $highlights = array(
          array( 'ðŸŒ¸', 'Fresh Flowers',      'Sourced fresh daily from local & international growers' ),
          array( 'ðŸšš', 'Same-Day Delivery',  'Fast delivery across Toronto & North York' ),
          array( 'ðŸŽ', 'Custom Gifts',       'Personalized hampers & unique gift sets' ),
          array( 'ðŸ’¬', '24/7 Support',       'Our florists are always here to help' ),
        );
        foreach ( $highlights as $h ) : ?>
        <div style="flex:1;min-width:220px;background:#fff;border-radius:16px;padding:22px;box-shadow:0 4px 20px rgba(0,0,0,.06);">
          <div style="font-size:2rem;margin-bottom:10px;"><?php echo $h[0]; ?></div>
          <h3 style="font-size:1rem;font-weight:700;color:#1a1a2e;margin-bottom:6px;"><?php echo esc_html( $h[1] ); ?></h3>
          <p style="font-size:.9rem;color:#666;line-height:1.5;margin:0;"><?php echo esc_html( $h[2] ); ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- Our Story -->
<section style="padding:70px 0;background:#fff;">
  <div style="max-width:1200px;margin:0 auto;padding:0 24px;">
    <div style="max-width:780px;margin:0 auto;text-align:center;">
      <h2 style="font-size:2rem;font-weight:800;color:#1a1a2e;margin-bottom:20px;">Our Story</h2>
      <div style="width:60px;height:4px;background:#e8607a;margin:0 auto 30px;"></div>
      <p style="font-size:1.05rem;line-height:1.9;color:#555;margin-bottom:22px;">
        Finch Gift Shop was founded in Toronto with one belief: every gift should tell a story.
        We started as a small neighbourhood florist near Finch Station and grew into a full-service
        gift shop beloved by thousands of customers across the GTA.
      </p>
      <p style="font-size:1.05rem;line-height:1.9;color:#555;">
        Today we offer hundreds of unique products &mdash; from elegant rose bouquets and custom gift
        baskets to indoor plants, teddy bears, chocolates, and luxury hampers. We also partner with
        SkipTheDishes, DoorDash, and UberEats to bring your gifts right to the door.
      </p>
    </div>
  </div>
</section>

<!-- Why Choose Us -->
<section style="padding:70px 0;background:#fdf6f0;">
  <div style="max-width:1200px;margin:0 auto;padding:0 24px;">
    <h2 style="font-size:2rem;font-weight:800;color:#1a1a2e;text-align:center;margin-bottom:14px;">Why Customers Love Us</h2>
    <div style="width:60px;height:4px;background:#e8607a;margin:0 auto 50px;"></div>
    <div style="display:flex;flex-wrap:wrap;gap:28px;justify-content:center;">
      <?php
      $reasons = array(
        array( '1', 'Always Fresh',            'Our flowers are prepared the same day you order.' ),
        array( '2', 'Handcrafted with Love',   'Every arrangement is hand-assembled by skilled florists.' ),
        array( '3', 'Delivery You Can Trust',  'Reliable same-day and next-day delivery across Toronto.' ),
        array( '4', 'Secure &amp; Easy Checkout', '100% secure online payment. Free pickup at our Yonge Street store.' ),
        array( '5', 'Custom Orders Welcome',   'Chat with our florists on WhatsApp for a unique creation.' ),
        array( '6', 'Budget-Friendly Options', 'Beautiful gifts from $5 balloons to premium luxury hampers.' ),
      );
      foreach ( $reasons as $r ) : ?>
      <div style="flex:0 1 320px;background:#fff;border-radius:16px;padding:30px;box-shadow:0 4px 20px rgba(0,0,0,.06);">
        <div style="width:44px;height:44px;background:#e8607a;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.2rem;font-weight:800;color:#fff;margin-bottom:16px;"><?php echo esc_html( $r[0] ); ?></div>
        <h3 style="font-size:1.05rem;font-weight:700;color:#1a1a2e;margin-bottom:10px;"><?php echo esc_html( $r[1] ); ?></h3>
        <p style="font-size:.92rem;line-height:1.7;color:#666;margin:0;"><?php echo wp_kses_post( $r[2] ); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Contact -->
<section style="padding:70px 0;background:#1a1a2e;color:#fff;">
  <div style="max-width:1200px;margin:0 auto;padding:0 24px;text-align:center;">
    <h2 style="font-size:2rem;font-weight:800;margin-bottom:14px;color:#fff;">Visit Us or Get In Touch</h2>
    <div style="width:60px;height:4px;background:#e8607a;margin:0 auto 40px;"></div>
    <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:32px;margin-bottom:40px;">
      <div>
        <div style="font-size:2rem;margin-bottom:8px;">ðŸ“</div>
        <p style="font-weight:600;margin-bottom:4px;color:#fff;">Address</p>
        <p style="color:#ccc;font-size:.95rem;">5714 Yonge Street, North York, ON M2M 4E7, Canada</p>
      </div>
      <div>
        <div style="font-size:2rem;margin-bottom:8px;">ðŸ“ž</div>
        <p style="font-weight:600;margin-bottom:4px;color:#fff;">Phone / WhatsApp</p>
        <a href="tel:+14167301028" style="color:#e8a0b4;font-size:.95rem;text-decoration:none;">+1 (416) 730-1028</a>
      </div>
      <div>
        <div style="font-size:2rem;margin-bottom:8px;">âœ‰ï¸</div>
        <p style="font-weight:600;margin-bottom:4px;color:#fff;">Email</p>
        <a href="mailto:info@finchgiftshop.com" style="color:#e8a0b4;font-size:.95rem;text-decoration:none;">info@finchgiftshop.com</a>
      </div>
    </div>
    <a href="https://wa.me/14167301028" target="_blank" rel="noopener"
       style="display:inline-block;background:#25D366;color:#fff;padding:14px 36px;border-radius:30px;font-weight:700;text-decoration:none;font-size:1rem;margin-right:12px;">
      &#x1F4AC; Chat on WhatsApp
    </a>
    <a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"
       style="display:inline-block;background:transparent;color:#fff;padding:13px 32px;border-radius:30px;font-weight:700;text-decoration:none;font-size:1rem;border:2px solid #fff;">
      Contact Us
    </a>
  </div>
</section>

<!-- Delivery Partners -->
<section style="padding:60px 0;background:#fff;">
  <div style="max-width:900px;margin:0 auto;padding:0 24px;text-align:center;">
    <h2 style="font-size:1.5rem;font-weight:800;color:#1a1a2e;margin-bottom:30px;">Also Available On</h2>
    <div style="display:flex;flex-wrap:wrap;justify-content:center;align-items:center;gap:28px;">
      <a href="https://www.skipthedishes.com/finch-gift-shop-yonge" target="_blank" rel="noopener"
         style="font-size:1rem;font-weight:600;color:#e8607a;text-decoration:none;padding:12px 24px;border:2px solid #e8607a;border-radius:30px;">SkipTheDishes</a>
      <a href="https://www.doordash.com/en-CA/store/finch-gift-shop-toronto-24712946/" target="_blank" rel="noopener"
         style="font-size:1rem;font-weight:600;color:#e8607a;text-decoration:none;padding:12px 24px;border:2px solid #e8607a;border-radius:30px;">DoorDash</a>
      <a href="https://www.ubereats.com/ca/store/finch-gift-shop/1yLeXxWwXRS34DYFpRua6A" target="_blank" rel="noopener"
         style="font-size:1rem;font-weight:600;color:#e8607a;text-decoration:none;padding:12px 24px;border:2px solid #e8607a;border-radius:30px;">UberEats</a>
    </div>
  </div>
</section>

<?php endwhile; ?>
</main>
<?php
// ===================== END FINCH GIFT SHOP ABOUT PAGE =====================

get_footer();
