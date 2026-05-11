<?php
/**
 * Plugin Name: Efficient Instagram Carousel
 * Description: Auto-scrolling Instagram carousel using Trustindex cached feed data. Hover to pause and see post details.
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_shortcode( 'efficient-instagram-carousel', 'eic_render_carousel' );

// Tell LiteSpeed Cache and Smush not to lazy-load anything inside the carousel
add_filter( 'litespeed_optm_js_defer_exc', function( $list ) { $list[] = 'eic-'; return $list; } );
add_filter( 'litespeed_media_lazy_img_excludes', function( $list ) { $list[] = 'eic-bg-img'; return $list; } );

function eic_render_carousel() {
    $feed_data_json = get_option( 'trustindex-feed-instagram-feed-data', '' );
    if ( ! $feed_data_json ) {
        return '<p style="text-align:center;color:#999;">Instagram feed not available.</p>';
    }

    $feed_data = json_decode( $feed_data_json, true );
    if ( empty( $feed_data['posts'] ) ) {
        return '<p style="text-align:center;color:#999;">No Instagram posts found.</p>';
    }

    // Sort newest first
    $posts = $feed_data['posts'];
    usort( $posts, function( $a, $b ) {
        return strtotime( $b['created_at'] ) - strtotime( $a['created_at'] );
    });

    ob_start();
    ?>
    <div class="eic-section">
        <div class="eic-track-wrapper" id="eic-track-wrapper">
            <div class="eic-track" id="eic-track">
                <?php
                // Render posts 4x — enough to fill any viewport with no gaps
                for ( $loop = 0; $loop < 4; $loop++ ) :
                    foreach ( $posts as $post ) :
                        $media  = $post['media_content'][0] ?? null;
                        if ( ! $media ) continue;

                        $img_src = '';
                        if ( ! empty( $media['image_urls'] ) && is_array( $media['image_urls'] ) ) {
                            // Trustindex stores relative CDN paths — prepend base URL
                            $cdn_base = 'https://cdn.trustindex.io/';
                            $img_src  = $cdn_base . ltrim( $media['image_urls']['medium'] ?? $media['image_urls']['large'] ?? reset( $media['image_urls'] ), '/' );
                        } elseif ( ! empty( $media['image_url'] ) ) {
                            $img_src = $media['image_url'];
                        }
                        if ( ! $img_src ) continue;

                        $post_url = esc_url( $post['url'] ?? '#' );
                        $caption  = esc_html( wp_trim_words( $post['text'] ?? $post['content'] ?? '', 20, '…' ) );
                        $likes    = isset( $post['like_count'] ) ? intval( $post['like_count'] ) : ( isset( $post['likes'] ) ? intval( $post['likes'] ) : null );
                        $date     = ! empty( $post['created_at'] ) ? esc_html( date( 'M j, Y', strtotime( $post['created_at'] ) ) ) : '';
                        ?>
                        <div class="eic-item">
                            <a href="<?php echo $post_url; ?>" target="_blank" rel="noopener noreferrer" class="eic-link" data-no-optimize="1">
                                <div class="eic-bg-img" data-no-lazy="1" data-no-optimize="1" style="background-image:url('<?php echo esc_url( $img_src ); ?>') !important;" role="img" aria-label="<?php echo $caption ? esc_attr( $caption ) : 'Instagram post'; ?>"></div>
                                <div class="eic-overlay">
                                    <?php if ( $caption ) : ?>
                                        <p class="eic-caption"><?php echo $caption; ?></p>
                                    <?php endif; ?>
                                    <div class="eic-meta">
                                        <?php if ( $likes !== null ) : ?>
                                            <span class="eic-likes">&#9829; <?php echo number_format( $likes ); ?></span>
                                        <?php endif; ?>
                                        <?php if ( $date ) : ?>
                                            <span class="eic-date"><?php echo $date; ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <style>
    .eic-section {
        width: 100%;
        overflow: hidden;
        background: #fff;
        padding: 20px 0;
    }
    .eic-track-wrapper {
        width: 100%;
        overflow: hidden;
        position: relative;
    }
    .eic-track {
        display: flex;
        gap: 12px;
        will-change: transform;
        animation: eic-scroll 30s linear infinite;
    }
    .eic-track.paused {
        animation-play-state: paused;
    }
    @keyframes eic-scroll {
        0%   { transform: translateX(0); }
        100% { transform: translateX(-25%); }
    }
    .eic-item {
        flex: 0 0 240px;
        height: 240px;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        cursor: pointer;
    }
    .eic-link {
        display: block;
        width: 100%;
        height: 100%;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }
    .eic-bg-img {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transition: transform 0.4s ease;
    }
    .eic-item:hover .eic-bg-img {
        transform: scale(1.07);
    }
    .eic-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.78) 0%, rgba(0,0,0,0.18) 55%, transparent 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 14px 12px 12px;
        opacity: 0;
        transition: opacity 0.3s ease;
        box-sizing: border-box;
    }
    .eic-item:hover .eic-overlay {
        opacity: 1;
    }
    .eic-caption {
        color: #fff;
        font-size: 13px;
        line-height: 1.4;
        margin: 0 0 8px;
        font-family: inherit;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }
    .eic-meta {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .eic-likes,
    .eic-date {
        color: #eee;
        font-size: 12px;
        font-family: inherit;
    }
    .eic-likes {
        color: #ff6b6b;
    }
    @media (max-width: 600px) {
        .eic-item {
            flex: 0 0 180px;
            height: 180px;
        }
    }
    </style>

    <script>
    (function() {
        var wrapper = document.getElementById('eic-track-wrapper');
        var track   = document.getElementById('eic-track');
        if (!wrapper || !track) return;

        // ── Fix 1: No longer needed — background-image is set directly inline ──

        // ── Fix 2: Pause on hover ──
        wrapper.addEventListener('mouseenter', function() { track.classList.add('paused'); });
        wrapper.addEventListener('mouseleave', function() { track.classList.remove('paused'); });

        // ── Fix 3: Shuffle + restart when section scrolls out of view ──
        // Fisher-Yates shuffle on the actual item elements
        function shuffleTrack() {
            var items = Array.from(track.children);
            for (var i = items.length - 1; i > 0; i--) {
                var j = Math.floor(Math.random() * (i + 1));
                track.appendChild(items[j]);
                items.splice(j, 1);
            }
            // Re-apply background-image after shuffle (DOM elements retain inline style)
        }

        if ('IntersectionObserver' in window) {
            var visible = true;
            var io = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (!entry.isIntersecting && visible) {
                        visible = false;
                        // Shuffle order while offscreen → new sequence on next view
                        shuffleTrack();
                        track.style.animation = 'none';
                        track.offsetHeight; // force reflow
                    } else if (entry.isIntersecting && !visible) {
                        visible = true;
                        track.style.animation = '';
                    }
                });
            }, { threshold: 0.05 });
            io.observe(wrapper);
        }
    })();
    </script>
    <?php
    return ob_get_clean();
}
