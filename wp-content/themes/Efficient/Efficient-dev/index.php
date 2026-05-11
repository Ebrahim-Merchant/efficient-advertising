<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
 * Template Name: Home
 *
 */
 get_header(); ?>

<?php /* ── Hero design tokens (scoped to hero only) ── */ ?>
<style>
#ea-hero {
  --hero-dark: #0A0A14;
  --hero-amber: #FFBA09;
  --hero-amber-dk: #E5A800;
  --hero-f-head: 'Syne', 'Gotham', sans-serif;
  --hero-f-body: 'DM Sans', sans-serif;
  background: #0A0A14; position: relative; overflow: hidden; z-index: 1;
}
#ea-hero::before {
  content: ''; position: absolute; inset: 0; pointer-events: none; z-index: 0;
  background: radial-gradient(ellipse at 15% 50%, rgba(255,186,9,0.06) 0%, transparent 55%),
              radial-gradient(ellipse at 85% 20%, rgba(255,186,9,0.03) 0%, transparent 45%);
}
.ea-slider-viewport { overflow: hidden; position: relative; z-index: 1; }
.ea-slider-track {
  display: flex;
  transition: transform 0.65s cubic-bezier(0.25,0.46,0.45,0.94);
  will-change: transform;
}
.ea-slide { min-width:100%; width:100%; flex-shrink:0; box-sizing:border-box; }
.ea-slide-wrap {
  display: grid; grid-template-columns: 1fr 1fr;
  align-items: stretch; min-height: 60vh; width: 100%;
}
.ea-slide-txt {
  padding: 80px 60px;
  display: flex; flex-direction: column; justify-content: center;
}
.ea-slide-label {
  font-size: 11px; font-weight: 800; letter-spacing: 4px; text-transform: uppercase;
  color: #FFBA09; margin-bottom: 18px;
  opacity: 0; transform: translateY(12px);
  transition: opacity .45s ease, transform .45s ease;
}
.ea-slide-label.lbl-in { opacity: 1; transform: translateY(0); }
.ea-slide-h1 {
  font-size: clamp(36px, 5vw, 80px);
  font-weight: 800; line-height: 0.95; letter-spacing: -1.5px; text-transform: uppercase;
  color: #ffffff; margin-bottom: 20px;
}
.ea-slide-h1 em { color: #FFBA09; font-style: normal; }
.ea-slide-sub {
  font-size: 15px; line-height: 1.6;
  color: rgba(255,255,255,0.65); margin-bottom: 36px; max-width: 400px;
}
.ea-slide-cta {
  display: inline-flex; align-items: center; gap: 11px;
  background: #FFBA09; color: #0A0A14;
  font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;
  padding: 10px 24px 10px 10px; border-radius: 100px;
  transition: all .3s; align-self: flex-start; border: 1px solid #FFBA09;
}
.ea-slide-cta .ico {
  width: 32px; height: 32px; background: #0A0A14; color: #FFBA09; border-radius: 50%;
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.ea-slide-cta:hover { background: transparent; color: #FFBA09; transform: translateY(-2px); text-decoration: none; }
.ea-slide-cta:hover .ico { background: #FFBA09; color: #0A0A14; }
.ea-slide-img {
  position: relative; overflow: hidden; min-height: 60vh;
  background: #0d0d1a;
}
.ea-slide-img-bg {
  position: absolute; inset: 0; width: 100%; height: 100%;
  object-fit: cover; object-position: center 30%;
  transition: transform 6s ease, clip-path 0.7s cubic-bezier(0.4,0,0.2,1);
  filter: saturate(1.15);
}
.ea-slide-img-bg.bg-zoom { transform: scale(1.08); }
.ea-slide-img::before {
  content: ''; position: absolute; inset: 0; z-index: 1; pointer-events: none;
  background: linear-gradient(to right, rgba(10,10,20,0.90) 0%, rgba(10,10,20,0.40) 8%, rgba(10,10,20,0.08) 18%, transparent 25%);
}
.ea-slide-img .img-b { clip-path: inset(0 0 0 100%); }
.ea-dots {
  position: absolute; bottom: 20px; left: 40px;
  display: flex; gap: 6px; align-items: center; z-index: 10;
}
.ea-dot {
  width: 8px; height: 8px; border-radius: 50%;
  background: rgba(255,255,255,0.25); border: none; cursor: pointer; padding: 0;
  transition: all .3s ease; flex-shrink: 0;
}
.ea-dot.active { background: #FFBA09; width: 24px; border-radius: 4px; }
.ea-ctrl {
  position: absolute; bottom: 14px; z-index: 10;
  width: 40px; height: 40px; border-radius: 50%; border: 1px solid rgba(255,186,9,0.3);
  background: rgba(10,10,20,0.5); color: #FFBA09;
  font-size: 22px; line-height: 1; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: background .2s;
}
.ea-ctrl:hover { background: rgba(255,186,9,0.2); }
.ea-prev { right: 60px; }
.ea-next { right: 14px; }
/* Amber divider */
.ea-hero-divider {
  height: 4px;
  background: linear-gradient(90deg, transparent 0%, #FFBA09 20%, #FFBA09 80%, transparent 100%);
}
@media (max-width: 991px) {
  .ea-slide-wrap { min-height: 50vh; }
  .ea-slide-txt  { padding: 60px 30px; }
}
@media (max-width: 767px) {
  .ea-slide-wrap { grid-template-columns: 1fr; min-height: 100svh; }
  .ea-slide-img  { display: none; }
  .ea-slide-txt  { padding: 60px 20px 48px; }
  .ea-slide-h1   { font-size: clamp(32px, 8vw, 48px); }
  .ea-dots { left: 20px; }
}
</style>

<section id="ea-hero">
  <div class="ea-slider-viewport" id="ea-viewport">
    <div class="ea-slider-track" id="ea-track">

      <!-- SLIDE 1 — Backdrops & Displays -->
      <div class="ea-slide">
        <div class="ea-slide-wrap">
          <div class="ea-slide-txt">
            <div class="ea-slide-label">BACKDROPS &amp; DISPLAYS</div>
            <h1 class="ea-slide-h1">Custom <em>Backdrops</em><br>&amp; Pop-Up Displays</h1>
            <p class="ea-slide-sub">Fabric, vinyl &amp; tension fabric displays for events, exhibitions and retail. Delivered across all UAE.</p>
            <a href="https://api.whatsapp.com/send?phone=971527966265&amp;text=Hello%2C%20I%20need%20a%20quote%20for%20backdrops" target="_blank" rel="noopener" class="ea-slide-cta">
              <span class="ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg></span>
              Contact Us
            </a>
          </div>
          <div class="ea-slide-img">
            <img class="ea-slide-img-bg img-a" src="<?php echo esc_url(content_url('uploads/2022/03/Step-Repeat-Backdrop-2.jpg')); ?>" alt="Backdrops &amp; Displays">
            <img class="ea-slide-img-bg img-b" src="<?php echo esc_url(content_url('uploads/cfdb7_uploads/1669025793-uploadfile-backdrop.png')); ?>" alt="Backdrop Display">
          </div>
        </div>
      </div>

      <!-- SLIDE 2 — Banner Printing -->
      <div class="ea-slide">
        <div class="ea-slide-wrap">
          <div class="ea-slide-txt">
            <div class="ea-slide-label">BANNER PRINTING</div>
            <h2 class="ea-slide-h1">Large-Format <em>Banner</em><br>Printing Dubai</h2>
            <p class="ea-slide-sub">Flex, mesh, roll-up &amp; retractable banners. Indoor &amp; outdoor. Same-day printing available.</p>
            <a href="https://api.whatsapp.com/send?phone=971527966265&amp;text=Hello%2C%20I%20need%20a%20quote%20for%20banners" target="_blank" rel="noopener" class="ea-slide-cta">
              <span class="ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg></span>
              Contact Us
            </a>
          </div>
          <div class="ea-slide-img">
            <img class="ea-slide-img-bg img-a" src="<?php echo esc_url(content_url('uploads/2026/01/banners.webp')); ?>" alt="Banner Printing Dubai">
            <img class="ea-slide-img-bg img-b" src="<?php echo esc_url(content_url('uploads/2022/03/pop-up-stand.jpg')); ?>" alt="Pop-Up Banner Stand">
          </div>
        </div>
      </div>

      <!-- SLIDE 3 — Signage & 3D Letters -->
      <div class="ea-slide">
        <div class="ea-slide-wrap">
          <div class="ea-slide-txt">
            <div class="ea-slide-label">SIGNAGE &amp; 3D LETTERS</div>
            <h2 class="ea-slide-h1">Acrylic, LED &amp;<br><em>3D Signage</em> Fabrication</h2>
            <p class="ea-slide-sub">Shop fronts, office signs, wayfinding, illuminated 3D letters &amp; acrylic boards. Designed &amp; built in-house.</p>
            <a href="https://api.whatsapp.com/send?phone=971527966265&amp;text=Hello%2C%20I%20need%20a%20quote%20for%20signage" target="_blank" rel="noopener" class="ea-slide-cta">
              <span class="ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg></span>
              Contact Us
            </a>
          </div>
          <div class="ea-slide-img">
            <img class="ea-slide-img-bg img-a" src="<?php echo esc_url(content_url('uploads/2026/03/business-signage-storefront.jpg')); ?>" alt="Signage &amp; 3D Letters">
            <img class="ea-slide-img-bg img-b" src="<?php echo esc_url(content_url('uploads/2022/03/Wall-Sticker.jpg')); ?>" alt="Wall Sticker Signage">
          </div>
        </div>
      </div>

      <!-- SLIDE 4 — Exhibition Stands -->
      <div class="ea-slide">
        <div class="ea-slide-wrap">
          <div class="ea-slide-txt">
            <div class="ea-slide-label">EXHIBITION STANDS</div>
            <h2 class="ea-slide-h1">Custom <em>Exhibition</em><br>Stand Design &amp; Build</h2>
            <p class="ea-slide-sub">Modular, custom-built and portable exhibition stands. Full design, fabrication and on-site installation.</p>
            <a href="https://api.whatsapp.com/send?phone=971527966265&amp;text=Hello%2C%20I%20need%20a%20quote%20for%20exhibition%20stands" target="_blank" rel="noopener" class="ea-slide-cta">
              <span class="ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg></span>
              Contact Us
            </a>
          </div>
          <div class="ea-slide-img">
            <img class="ea-slide-img-bg img-a" src="<?php echo esc_url(content_url('uploads/2025/04/Trade-Show-Booth-Deemed-University-1000-x-1000-px.jpg')); ?>" alt="Exhibition Stands Dubai">
            <img class="ea-slide-img-bg img-b" src="<?php echo esc_url(content_url('uploads/2022/03/Exhibition-Stands-1.jpg')); ?>" alt="Exhibition Stand Design">
          </div>
        </div>
      </div>

      <!-- SLIDE 5 — Vehicle Branding -->
      <div class="ea-slide">
        <div class="ea-slide-wrap">
          <div class="ea-slide-txt">
            <div class="ea-slide-label">VEHICLE BRANDING</div>
            <h2 class="ea-slide-h1">Fleet &amp; Vehicle<br><em>Vinyl Wrapping</em></h2>
            <p class="ea-slide-sub">Full wraps, partial wraps &amp; magnetic signs. Corporate fleets to single vehicles — all UAE.</p>
            <a href="https://api.whatsapp.com/send?phone=971527966265&amp;text=Hello%2C%20I%20need%20a%20quote%20for%20vehicle%20branding" target="_blank" rel="noopener" class="ea-slide-cta">
              <span class="ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg></span>
              Contact Us
            </a>
          </div>
          <div class="ea-slide-img">
            <img class="ea-slide-img-bg img-a" src="<?php echo esc_url(content_url('uploads/2026/03/car-wrap-vehicle-branding.jpg')); ?>" alt="Vehicle Branding Dubai">
            <img class="ea-slide-img-bg img-b" src="<?php echo esc_url(content_url('uploads/2022/03/Vehicle-branding.png')); ?>" alt="Fleet Vehicle Wrap">
          </div>
        </div>
      </div>

      <!-- SLIDE 6 — Events & Corporate -->
      <div class="ea-slide">
        <div class="ea-slide-wrap">
          <div class="ea-slide-txt">
            <div class="ea-slide-label">EVENTS &amp; CORPORATE</div>
            <h2 class="ea-slide-h1">Events, Stage &amp;<br><em>Corporate Branding</em></h2>
            <p class="ea-slide-sub">End-to-end event branding: stage sets, flags, banners, uniforms and full event setup.</p>
            <a href="https://api.whatsapp.com/send?phone=971527966265&amp;text=Hello%2C%20I%20need%20a%20quote%20for%20events" target="_blank" rel="noopener" class="ea-slide-cta">
              <span class="ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg></span>
              Contact Us
            </a>
          </div>
          <div class="ea-slide-img">
            <img class="ea-slide-img-bg img-a" src="<?php echo esc_url(content_url('uploads/2022/03/Events-Branding-2-1.jpg')); ?>" alt="Events &amp; Corporate Branding">
            <img class="ea-slide-img-bg img-b" src="<?php echo esc_url(content_url('uploads/cfdb7_uploads/1715591438-uploadfile-dior-backdrop-.png')); ?>" alt="Event Backdrop">
          </div>
        </div>
      </div>

      <!-- SLIDE 7 — Flags & Poles -->
      <div class="ea-slide">
        <div class="ea-slide-wrap">
          <div class="ea-slide-txt">
            <div class="ea-slide-label">FLAGS &amp; POLES</div>
            <h2 class="ea-slide-h1">Custom <em>Flags</em>,<br>Teardrop &amp; Feather</h2>
            <p class="ea-slide-sub">Teardrop flags, feather flags, national &amp; custom flags. Single units or bulk orders. Fast UAE delivery.</p>
            <a href="https://api.whatsapp.com/send?phone=971527966265&amp;text=Hello%2C%20I%20need%20a%20quote%20for%20flags" target="_blank" rel="noopener" class="ea-slide-cta">
              <span class="ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg></span>
              Contact Us
            </a>
          </div>
          <div class="ea-slide-img">
            <img class="ea-slide-img-bg img-a" src="<?php echo esc_url(content_url('uploads/2022/03/custom-teardrop-flag.jpg')); ?>" alt="Custom Flags &amp; Poles">
            <img class="ea-slide-img-bg img-b" src="<?php echo esc_url(content_url('uploads/2022/03/Hoisting-Flags.jpg')); ?>" alt="Hoisting Flags">
          </div>
        </div>
      </div>

    </div><!-- /.ea-slider-track -->
  </div><!-- /.ea-slider-viewport -->

  <div class="ea-dots" id="ea-dots">
    <button class="ea-dot active" data-idx="0" aria-label="Slide 1"></button>
    <button class="ea-dot" data-idx="1" aria-label="Slide 2"></button>
    <button class="ea-dot" data-idx="2" aria-label="Slide 3"></button>
    <button class="ea-dot" data-idx="3" aria-label="Slide 4"></button>
    <button class="ea-dot" data-idx="4" aria-label="Slide 5"></button>
    <button class="ea-dot" data-idx="5" aria-label="Slide 6"></button>
    <button class="ea-dot" data-idx="6" aria-label="Slide 7"></button>
  </div>
  <button class="ea-ctrl ea-prev" id="ea-prev" aria-label="Previous slide">&#8249;</button>
  <button class="ea-ctrl ea-next" id="ea-next" aria-label="Next slide">&#8250;</button>

</section>

<div class="ea-hero-divider"></div>

<script>
(function(){
  var track  = document.getElementById('ea-track');
  var dotsEl = document.querySelectorAll('.ea-dot');
  var total  = 7;
  var curDom = 1;
  var busy   = false;
  var timer;

  var realSlides = track.querySelectorAll('.ea-slide');
  var cloneFirst = realSlides[0].cloneNode(true);
  var cloneLast  = realSlides[total - 1].cloneNode(true);
  track.appendChild(cloneFirst);
  track.insertBefore(cloneLast, realSlides[0]);
  var allSlides = track.querySelectorAll('.ea-slide');

  function domToReal(p) {
    if (p === 0)         return total - 1;
    if (p === total + 1) return 0;
    return p - 1;
  }
  function moveTo(p, animated) {
    track.style.transition = animated ? '' : 'none';
    track.style.transform  = 'translateX(-' + (p * 100) + '%)';
  }
  function updateDots(realIdx) {
    dotsEl.forEach(function(d, i){ d.classList.toggle('active', i === realIdx); });
  }
  function animLabel(domPos) {
    var lbl = allSlides[domPos].querySelector('.ea-slide-label');
    if (!lbl) return;
    lbl.classList.remove('lbl-in');
    lbl.style.transition = 'none'; lbl.style.opacity = '0'; lbl.style.transform = 'translateY(12px)';
    requestAnimationFrame(function(){ requestAnimationFrame(function(){ lbl.style.transition = ''; lbl.classList.add('lbl-in'); }); });
  }
  function kenBurns(domPos) {
    track.querySelectorAll('.ea-slide-img-bg').forEach(function(bg){ bg.classList.remove('bg-zoom'); });
    var bg = allSlides[domPos].querySelector('.ea-slide-img-bg');
    if (bg) setTimeout(function(){ bg.classList.add('bg-zoom'); }, 50);
  }
  var imgTimer = null;
  function hideAllImgB() {
    clearTimeout(imgTimer);
    track.querySelectorAll('.img-b').forEach(function(el){
      el.style.transition = 'none'; el.style.clipPath = 'inset(0 0 0 100%)'; el.classList.remove('bg-zoom');
    });
  }
  function goNext() {
    if (busy) return; busy = true; hideAllImgB();
    curDom++; moveTo(curDom, true); updateDots(domToReal(curDom)); animLabel(curDom); kenBurns(curDom); resetTimer();
  }
  function goPrev() {
    if (busy) return; busy = true; hideAllImgB();
    curDom--; moveTo(curDom, true); updateDots(domToReal(curDom)); animLabel(curDom); kenBurns(curDom); resetTimer();
  }
  function goToReal(realIdx) {
    if (busy) return; busy = true; hideAllImgB();
    curDom = realIdx + 1; moveTo(curDom, true); updateDots(realIdx); animLabel(curDom); kenBurns(curDom); resetTimer();
  }
  track.addEventListener('transitionend', function(e){
    if (e.propertyName !== 'transform') return;
    busy = false;
    if (curDom === 0) { curDom = total; moveTo(curDom, false); }
    else if (curDom === total + 1) { curDom = 1; moveTo(curDom, false); }
    requestAnimationFrame(function(){ track.querySelectorAll('.img-b').forEach(function(el){ el.style.transition = ''; }); });
    activateSlideImages(curDom);
  });
  function resetTimer() { clearInterval(timer); timer = setInterval(goNext, 6000); }
  function activateSlideImages(domPos) {
    clearTimeout(imgTimer);
    var slide = allSlides[domPos];
    if (!slide) return;
    var imgB = slide.querySelector('.img-b');
    if (!imgB) return;
    imgTimer = setTimeout(function(){ imgB.style.clipPath = 'inset(0 0 0 0%)'; imgB.classList.add('bg-zoom'); }, 2400);
  }
  document.getElementById('ea-prev').addEventListener('click', goPrev);
  document.getElementById('ea-next').addEventListener('click', goNext);
  dotsEl.forEach(function(d){
    d.addEventListener('click', function(){ goToReal(parseInt(d.getAttribute('data-idx'), 10)); });
  });
  moveTo(1, false); updateDots(0); kenBurns(1);
  var lbl0 = allSlides[1].querySelector('.ea-slide-label');
  if (lbl0) { setTimeout(function(){ lbl0.classList.add('lbl-in'); }, 300); }
  activateSlideImages(1); resetTimer();
})();
</script>

<!-- TRUST BAR -->
<div class="ea-trustbar">
  <div class="ea-trustbar__track">
    <!-- Items duplicated to create seamless infinite loop -->
    <span class="ea-trustbar__item">🏭 100% In-House Printing Facility</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">🖨 Advanced Printing Technology</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">📏 Large Format Printing Specialists</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">⚡ Same-Day Printing Available</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">🚚 UAE-Wide Delivery &amp; Installation</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">📍 Serving All Emirates</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">🎨 Free Design Support</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">💰 Bulk Order Discounts</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">💬 Dedicated Customer Support</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">✔ Custom Event &amp; Corporate Branding</span>
    <span class="ea-trustbar__sep">|</span>
    <!-- Duplicate set for seamless loop -->
    <span class="ea-trustbar__item">🏭 100% In-House Printing Facility</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">🖨 Advanced Printing Technology</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">📏 Large Format Printing Specialists</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">⚡ Same-Day Printing Available</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">🚚 UAE-Wide Delivery &amp; Installation</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">📍 Serving All Emirates</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">🎨 Free Design Support</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">💰 Bulk Order Discounts</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">💬 Dedicated Customer Support</span>
    <span class="ea-trustbar__sep">|</span>
    <span class="ea-trustbar__item">✔ Custom Event &amp; Corporate Branding</span>
    <span class="ea-trustbar__sep">|</span>
  </div>
</div>

<style>
.ea-trustbar {
  width: 100% !important;
  max-width: none !important;
  margin: 0 !important;
  padding: 0;
  background: linear-gradient(90deg, #1e293b 0%, #334155 50%, #1e293b 100%);
  overflow: hidden;
  display: flex;
  align-items: center;
  height: 46px;
  box-sizing: border-box;
}
.ea-trustbar__track {
  display: flex;
  align-items: center;
  gap: 0;
  white-space: nowrap;
  animation: ea-scroll-rtl 32s linear infinite;
  will-change: transform;
}
.ea-trustbar__item {
  color: #fff;
  font-size: 13.5px;
  font-weight: 700;
  letter-spacing: 0.2px;
  padding: 0 22px;
  white-space: nowrap;
}
.ea-trustbar__sep {
  color: rgba(255,255,255,0.28);
  font-size: 16px;
  flex-shrink: 0;
}
@keyframes ea-scroll-rtl {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
.ea-trustbar:hover .ea-trustbar__track { animation-play-state: paused; }
</style>
<!-- END TRUST BAR -->


<!-- BD-STYLE HERO BANNER -->
<section class="ea-bdhero" style="background: linear-gradient(100deg, #0284c7 0%, #0ea5e9 28%, #06b6d4 55%, #0d9488 78%, #059669 100%); padding: 44px 0; overflow: visible; position: relative;">
  <div class="container" style="position: relative;">

    <!-- Wrapper with left indent to make space for the WhatsApp circle -->
    <div class="ea-bdhero__wrap">

      <!-- White card -->
      <div class="ea-bdhero__card">

        <!-- LEFT: Text content -->
        <div class="ea-bdhero__text">

          <!-- Badge pill -->
          <span class="ea-bdhero__badge">Print &middot; Brand &middot; Deliver &middot; Install</span>

          <h1 class="ea-bdhero__heading">
            Banner Printing, Signage &amp; Branding Company in Dubai
          </h1>

          <p class="ea-bdhero__para">
            Since 2008, Efficient Advertising has been the trusted name for
            <strong>banner printing</strong>, <strong>custom backdrops</strong>,
            <strong>flag printing</strong>, <strong>signage</strong>,
            <strong>exhibition stands</strong>, <strong>event management</strong>,
            and <strong>vehicle branding</strong> across Dubai and the UAE.
            One team. Every job. Done right.
          </p>

          <p class="ea-bdhero__para" style="margin-bottom:20px;">
            Based in Ras Al Khor, Dubai — we print, produce, deliver, and install.
            Whether you need a <strong>fabric backdrop</strong>, <strong>teardrop flags</strong>,
            a full <strong>exhibition stand build</strong>, or <strong>3D acrylic signage</strong>
            — our 18-year track record speaks for itself. Urgent deadline?
            We offer <strong>same-day printing</strong> across Dubai.
          </p>

          <a href="/product-category/backdrop-display-dubai/" class="ea-bdhero__link">
            View Our Products &rarr;
          </a>

          <!-- Mobile-only WhatsApp button (shown instead of the circle) -->
          <a href="https://api.whatsapp.com/send?phone=971527966265&amp;text=Hello%2C%20I%20need%20a%20printing%20quote"
             target="_blank" rel="noopener" class="ea-bdhero__wa-mobile">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#fff" style="flex-shrink:0;">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            WhatsApp Us
          </a>

        </div><!-- /text -->

        <!-- RIGHT: Image -->
        <div class="ea-bdhero__imgwrap">
          <!-- Soft fade on left edge to blend into white card -->
          <div class="ea-bdhero__imgfade"></div>
          <img src="<?php echo esc_url( content_url( 'uploads/2022/07/Exhibition-Stands-2-1-1.jpg' ) ); ?>"
               alt="Exhibition Stand Dubai - Efficient Advertising"
               class="ea-bdhero__img" />
        </div>

      </div><!-- /card -->

      <!-- WhatsApp circle CTA (floats on left edge of card, desktop only) -->
      <a href="https://api.whatsapp.com/send?phone=971527966265&amp;text=Hello%2C%20I%20need%20a%20printing%20quote"
         target="_blank" rel="noopener" class="ea-bdhero__wa-circle" aria-label="Chat on WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24" fill="#16a34a">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
        <span>WhatsApp<br>Us</span>
      </a>

    </div><!-- /wrap -->
  </div>
</section>

<style>
/* ======= BD-Style Hero Banner ======= */
.ea-bdhero { }
.ea-bdhero__wrap {
  position: relative;
}
.ea-bdhero__card {
  background: transparent;
  border-radius: 20px;
  overflow: hidden;
  display: flex;
  min-height: 300px;
  box-shadow: 0 12px 48px rgba(0,0,0,0.28);
  border: 1px solid rgba(255,255,255,0.18);
}
.ea-bdhero__text {
  flex: 1;
  min-width: 0;
  padding: 40px 32px 36px 32px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  background: rgba(255,255,255,0.14);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  border-right: 1px solid rgba(255,255,255,0.20);
}
.ea-bdhero__badge {
  display: inline-block;
  border: 2px solid rgba(255,255,255,0.85);
  border-radius: 50px;
  padding: 5px 18px;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 0.5px;
  color: #fff;
  margin-bottom: 18px;
  width: fit-content;
}
.ea-bdhero__heading {
  font-size: 26px;
  font-weight: 800;
  color: #fff;
  margin: 0 0 16px;
  line-height: 1.3;
}
.ea-bdhero__para {
  font-size: 14px;
  line-height: 1.8;
  color: rgba(255,255,255,0.88);
  margin: 0 0 12px;
}
.ea-bdhero__link {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  color: #fff;
  font-size: 14px;
  font-weight: 700;
  text-decoration: underline;
  text-underline-offset: 3px;
  margin-top: 4px;
  opacity: 0.9;
}
.ea-bdhero__link:hover { color: #fff; opacity: 1; }
.ea-bdhero__imgwrap {
  width: 44%;
  flex-shrink: 0;
  position: relative;
  overflow: hidden;
}
.ea-bdhero__imgfade {
  position: absolute;
  top: 0; left: 0;
  width: 100px;
  height: 100%;
  background: linear-gradient(to right, rgba(255,255,255,0.14) 0%, rgba(255,255,255,0) 100%);
  z-index: 2;
  pointer-events: none;
}
.ea-bdhero__img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  display: block;
}
/* WhatsApp circle — desktop */
.ea-bdhero__wa-circle {
  position: absolute;
  right: -20px;
  bottom: -20px;
  left: auto;
  top: auto;
  transform: none;
  width: 88px;
  height: 88px;
  background: #fff;
  border-radius: 50%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 5px;
  box-shadow: 0 6px 28px rgba(0,0,0,0.22);
  z-index: 10;
  text-decoration: none;
  border: 3px solid rgba(22,163,74,0.15);
  transition: box-shadow 0.2s, transform 0.2s;
}
.ea-bdhero__wa-circle:hover {
  box-shadow: 0 8px 32px rgba(22,163,74,0.35);
  transform: scale(1.05);
}
.ea-bdhero__wa-circle span {
  color: #16a34a;
  font-size: 8px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.4px;
  line-height: 1.2;
  text-align: center;
}
/* Mobile WhatsApp button (hidden on desktop) */
.ea-bdhero__wa-mobile {
  display: none;
  align-items: center;
  gap: 8px;
  background: #16a34a;
  color: #fff;
  padding: 11px 22px;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 700;
  text-decoration: none;
  margin-top: 20px;
  width: fit-content;
  transition: background 0.2s;
}
.ea-bdhero__wa-mobile:hover { background: #15803d; color: #fff; }

/* ---- Responsive ---- */
@media (max-width: 991px) {
  .ea-bdhero__imgwrap { width: 38%; }
  .ea-bdhero__heading { font-size: 22px; }
}
@media (max-width: 767px) {
  .ea-bdhero__wrap { margin-left: 0; }
  .ea-bdhero__card { flex-direction: column; }
  .ea-bdhero__imgwrap { width: 100%; height: 220px; }
  .ea-bdhero__imgfade { display: none; }
  .ea-bdhero__text { padding: 28px 20px 20px; }
  .ea-bdhero__heading { font-size: 20px; }
  .ea-bdhero__wa-circle { display: none; }
  .ea-bdhero__wa-mobile { display: inline-flex; }
}
</style>



<section class="blog">



        <div class="container">

          <div class="row">

            <div class="row pb-30 text-center">

              <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 ">

                <div class="ea-products-hd">
                  <p class="ea-products-label"><?php if(get_field('categories_subheadings')) { echo get_field('categories_subheadings');} else { echo "OUR PRODUCTS"; } ?></p>
                  <h2 class="ea-products-heading">Printing &amp; Branding Services in Dubai</h2>
                  <p class="ea-products-sub">12&nbsp;product categories &middot; 18&nbsp;years experience &middot; Same-day printing available</p>
                  <div class="ea-products-accent"></div>
                </div>              

              </div>

            </div>

            <div class="col-lg-12 pdn">

                         <?php
                            $my_query =  new WP_Query( array(
                                'post_type' => 'home_categotries',
                                 'posts_per_page' => -1,
                                 'orderby' => 'menu_order',
                                 'order'   => 'ASC',
                               )); 
                            $count=0;
                            while($my_query->have_posts()) :
                            $my_query->the_post();
                            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->id), 'full');
                         ?> 

<div class="col-md-4">

        <div class="zoom-img ">

                  <figure>

                    <a href="<?php if(get_field('conection')) { echo get_field('conection');} else { echo ""; } ?>"><img class="img-responsive" src="<?php echo esc_url( $thumb['0'] ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?> - Printing Services Dubai" loading="lazy"></a>
                    <div class="zoom-explore-cta">Explore &rarr;</div>

                  </figure>

                  <div class="text-box">

                    <div class="text-content mb-20">

                    <h3><a href="<?php if(get_field('conection')) { echo get_field('conection');} else { echo ""; } ?>"><?php the_title();?></a></h3>

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

        </div>



      </section>



<!-- STATS BAR -->
<section style="background:#1a1a2e; padding:48px 0;">
  <div class="container">
    <div class="ea-stats-grid">
      <div class="ea-stat-item">
        <span class="ea-stat-icon">📏</span>
        <span class="ea-stat-number">500K+</span>
        <span class="ea-stat-label">Sq.ft Printed (18 Yrs)</span>
      </div>
      <div class="ea-stat-divider"></div>
      <div class="ea-stat-item">
        <span class="ea-stat-icon">📦</span>
        <span class="ea-stat-number">20,000+</span>
        <span class="ea-stat-label">Orders Delivered</span>
      </div>
      <div class="ea-stat-divider"></div>
      <div class="ea-stat-item">
        <span class="ea-stat-icon">🏆</span>
        <span class="ea-stat-number">18+</span>
        <span class="ea-stat-label">Years Industry Experience</span>
      </div>
      <div class="ea-stat-divider"></div>
      <div class="ea-stat-item">
        <span class="ea-stat-icon">🏢</span>
        <span class="ea-stat-number">500+</span>
        <span class="ea-stat-label">UAE Companies Trusted</span>
      </div>
      <div class="ea-stat-divider"></div>
      <div class="ea-stat-item">
        <span class="ea-stat-icon">⭐</span>
        <span class="ea-stat-number">4.8★</span>
        <span class="ea-stat-label">Google Rating</span>
      </div>
    </div>
  </div>
</section>
<style>
.ea-stats-grid {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
  gap: 0;
}
.ea-stat-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 12px 36px;
  text-align: center;
}
.ea-stat-icon {
  font-size: 28px;
  line-height: 1;
  margin-bottom: 8px;
  display: block;
}
.ea-stat-number {
  font-size: 40px;
  font-weight: 800;
  color: #f5bd56;
  line-height: 1.1;
  letter-spacing: -1px;
}
.ea-stat-label {
  font-size: 13px;
  font-weight: 600;
  color: rgba(255,255,255,0.72);
  margin-top: 6px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.ea-stat-divider {
  width: 1px;
  height: 52px;
  background: rgba(255,255,255,0.15);
  flex-shrink: 0;
}
@media (max-width: 767px) {
  .ea-stat-item { padding: 14px 20px; width: 50%; }
  .ea-stat-divider { display: none; }
  .ea-stat-number { font-size: 32px; }
}
</style>
<!-- END STATS BAR -->

<!-- TRUSTED CLIENTS CAROUSEL -->
<section style="background:#fff; padding:40px 0 36px; border-top:1px solid #eee; border-bottom:1px solid #eee; overflow:hidden;">
  <div style="text-align:center; margin-bottom:28px;">
    <p style="font-size:11px; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:#94a3b8; margin:0;">TRUSTED BY 500+ UAE BUSINESSES ACROSS ALL INDUSTRIES</p>
  </div>

  <!-- Full-width scrolling track — sits outside .container intentionally -->
  <div class="ea-clients-viewport">
    <div class="ea-clients-track">

      <!--
        HOW TO ADD YOUR REAL LOGOS:
        Replace the <div class="ea-client-logo-box"> placeholder in each card with:
          <img src="<?php echo esc_url( content_url('uploads/clients/logo-name.png') ); ?>"
               class="ea-client-logo" alt="Company Name - Efficient Advertising Client" loading="lazy">
        Keep the <span class="ea-client-name"> line with the real company name.
        The set of 12 cards is duplicated once below for the seamless infinite loop — update BOTH copies.
      -->

      <!-- ── SET A (originals) ── -->
      <div class="ea-client-card">
        <div class="ea-client-logo-box">1</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">2</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">3</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">4</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">5</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">6</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">7</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">8</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">9</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">10</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">11</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">12</div>
        <span class="ea-client-name">Company Name</span>
      </div>

      <!-- ── SET B (duplicate — do NOT remove, required for seamless loop) ── -->
      <div class="ea-client-card">
        <div class="ea-client-logo-box">1</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">2</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">3</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">4</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">5</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">6</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">7</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">8</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">9</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">10</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">11</div>
        <span class="ea-client-name">Company Name</span>
      </div>
      <div class="ea-client-card">
        <div class="ea-client-logo-box">12</div>
        <span class="ea-client-name">Company Name</span>
      </div>

    </div><!-- /.ea-clients-track -->
  </div><!-- /.ea-clients-viewport -->

</section>
<style>
/* Viewport: hides overflow, adds fade edges */
.ea-clients-viewport {
  overflow: hidden;
  position: relative;
  width: 100%;
}
/* Fade edges left & right */
.ea-clients-viewport::before,
.ea-clients-viewport::after {
  content: '';
  position: absolute;
  top: 0; bottom: 0;
  width: 80px;
  z-index: 2;
  pointer-events: none;
}
.ea-clients-viewport::before { left:0;  background: linear-gradient(to right, #fff 0%, transparent 100%); }
.ea-clients-viewport::after  { right:0; background: linear-gradient(to left,  #fff 0%, transparent 100%); }

/* Scrolling track */
.ea-clients-track {
  display: flex;
  align-items: center;
  gap: 0;
  width: max-content;
  animation: ea-clients-scroll 36s linear infinite;
  will-change: transform;
}
.ea-clients-viewport:hover .ea-clients-track { animation-play-state: paused; }

@keyframes ea-clients-scroll {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}

/* Individual card */
.ea-client-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 0 32px;
  border-right: 1px solid #f1f5f9;
  min-width: 120px;
  cursor: default;
}
.ea-client-card:last-child { border-right: none; }

/* Logo image — swap .ea-client-logo-box placeholder with a real <img class="ea-client-logo"> */
.ea-client-logo-box {
  width: 90px;
  height: 52px;
  background: #f1f5f9;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  font-weight: 700;
  color: #94a3b8;
  letter-spacing: 1px;
}
.ea-client-logo {
  height: 44px;
  width: auto;
  max-width: 110px;
  object-fit: contain;
  filter: grayscale(1);
  opacity: 0.55;
  transition: opacity 0.25s, filter 0.25s;
  display: block;
}
.ea-client-card:hover .ea-client-logo { opacity: 1; filter: none; }

/* Company name */
.ea-client-name {
  font-size: 11px;
  font-weight: 700;
  color: #94a3b8;
  text-transform: uppercase;
  letter-spacing: 0.8px;
  white-space: nowrap;
  text-align: center;
}
.ea-client-card:hover .ea-client-name { color: #374151; }
</style>
<!-- END TRUSTED CLIENTS CAROUSEL -->

<!-- WHY CHOOSE US SECTION -->
<section class="section-bar whychooseus-section" style="background:#f5bd56; padding:64px 0 52px; position:relative; overflow:hidden; margin:0 !important;">

  <!-- Decorative circles: solid white, half-visible at corners -->
  <div style="position:absolute; top:-350px; left:-350px; width:800px; height:800px; background:#fff; opacity:0.40; border-radius:50%; pointer-events:none; z-index:1;"></div>
  <div style="position:absolute; bottom:-240px; right:-240px; width:560px; height:560px; background:#fff; opacity:0.40; border-radius:50%; pointer-events:none; z-index:1;"></div>

  <div class="container" style="position:relative; z-index:2;">

    <!-- Section header -->
    <div style="text-align:center; margin-bottom:48px;">
      <p style="font-size:12px; font-weight:800; letter-spacing:3px; text-transform:uppercase; color:rgba(255,255,255,0.85); margin:0 0 10px;">OUR DIFFERENCE</p>
      <h2 style="color:#111; font-size:36px; font-weight:700; margin:0 0 14px; line-height:1.3;">Why Dubai Businesses Choose Efficient Advertising</h2>
      <p style="color:#111; font-size:16px; margin:0 auto; max-width:600px; line-height:1.75;">
        Since 2008, we have built our name across Dubai and the UAE — delivering media, print, and branding with genuine care for every client.
      </p>
    </div>

    <!-- 6 Cards — pure flexbox grid for perfect equal heights -->
    <div class="wcu-grid">

      <!-- Card 1 -->
      <div class="wcu-card">
        <div style="font-size:44px; margin-bottom:18px; line-height:1;">&#127942;</div>
        <h3 style="font-size:22px; font-weight:700; color:#111; margin:0 0 12px; line-height:1.3;">18 Years in Dubai<br>— Since 2008</h3>
        <p style="font-size:15px; color:#333; line-height:1.75; flex:1; margin:0 0 20px;">
          We opened in 2008 and haven't stopped. 18 years of media, print, and branding work across the UAE — reputation built job by job.
        </p>
        <div style="display:flex; justify-content:flex-end;">
          <a href="/contact-us/" style="display:flex; align-items:center; justify-content:center; width:38px; height:38px; border:1.5px solid #bbb; border-radius:50%; text-decoration:none; flex-shrink:0;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#444" stroke-width="2.5"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </a>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="wcu-card">
        <div style="font-size:44px; margin-bottom:18px; line-height:1;">&#9889;</div>
        <h3 style="font-size:22px; font-weight:700; color:#111; margin:0 0 12px; line-height:1.3;">Fast Turnaround,<br>Zero Compromise</h3>
        <p style="font-size:15px; color:#333; line-height:1.75; flex:1; margin:0 0 20px;">
          Same-day and express printing options so your materials are ready exactly when you need them.
        </p>
        <div style="display:flex; justify-content:flex-end;">
          <a href="/contact-us/" style="display:flex; align-items:center; justify-content:center; width:38px; height:38px; border:1.5px solid #bbb; border-radius:50%; text-decoration:none; flex-shrink:0;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#444" stroke-width="2.5"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </a>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="wcu-card">
        <div style="font-size:44px; margin-bottom:18px; line-height:1;">&#127959;</div>
        <h3 style="font-size:22px; font-weight:700; color:#111; margin:0 0 12px; line-height:1.3;">End-to-End<br>Service</h3>
        <p style="font-size:15px; color:#333; line-height:1.75; flex:1; margin:0 0 20px;">
          Design, production, delivery, and on-site installation — one vendor, complete accountability.
        </p>
        <div style="display:flex; justify-content:flex-end;">
          <a href="/contact-us/" style="display:flex; align-items:center; justify-content:center; width:38px; height:38px; border:1.5px solid #bbb; border-radius:50%; text-decoration:none; flex-shrink:0;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#444" stroke-width="2.5"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </a>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="wcu-card">
        <div style="font-size:44px; margin-bottom:18px; line-height:1;">&#128176;</div>
        <h3 style="font-size:22px; font-weight:700; color:#111; margin:0 0 12px; line-height:1.3;">Competitive<br>Pricing</h3>
        <p style="font-size:15px; color:#333; line-height:1.75; flex:1; margin:0 0 20px;">
          Premium quality at fair prices — scalable solutions for startups, SMEs, and enterprises.
        </p>
        <div style="display:flex; justify-content:flex-end;">
          <a href="/contact-us/" style="display:flex; align-items:center; justify-content:center; width:38px; height:38px; border:1.5px solid #bbb; border-radius:50%; text-decoration:none; flex-shrink:0;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#444" stroke-width="2.5"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </a>
        </div>
      </div>

      <!-- Card 5 -->
      <div class="wcu-card">
        <div style="font-size:44px; margin-bottom:18px; line-height:1;">&#128666;</div>
        <h3 style="font-size:22px; font-weight:700; color:#111; margin:0 0 12px; line-height:1.3;">UAE-Wide<br>Delivery</h3>
        <p style="font-size:15px; color:#333; line-height:1.75; flex:1; margin:0 0 20px;">
          Delivering across Dubai, Sharjah, Abu Dhabi, Ajman, and all UAE emirates.
        </p>
        <div style="display:flex; justify-content:flex-end;">
          <a href="/contact-us/" style="display:flex; align-items:center; justify-content:center; width:38px; height:38px; border:1.5px solid #bbb; border-radius:50%; text-decoration:none; flex-shrink:0;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#444" stroke-width="2.5"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </a>
        </div>
      </div>

      <!-- Card 6 -->
      <div class="wcu-card">
        <div style="font-size:44px; margin-bottom:18px; line-height:1;">&#11088;</div>
        <h3 style="font-size:22px; font-weight:700; color:#111; margin:0 0 12px; line-height:1.3;">Google-Rated<br>Excellent</h3>
        <p style="font-size:15px; color:#333; line-height:1.75; flex:1; margin:0 0 20px;">
          Rated Excellent across 34+ verified Google reviews for quality and professionalism.
        </p>
        <div style="display:flex; justify-content:flex-end;">
          <a href="/contact-us/" style="display:flex; align-items:center; justify-content:center; width:38px; height:38px; border:1.5px solid #bbb; border-radius:50%; text-decoration:none; flex-shrink:0;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#444" stroke-width="2.5"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </a>
        </div>
      </div>

    </div><!-- /.wcu-grid -->

    <!-- Bottom CTA -->
    <div style="display:flex; justify-content:flex-end; margin-top:20px;">
      <a href="https://api.whatsapp.com/send?phone=971527966265&amp;text=Hi%2C+I%27d+like+to+get+a+quote+for+printing+services."
         target="_blank" rel="noopener" class="cta-wa"
         style="display:inline-flex; align-items:center; gap:8px; background:#16a34a; color:#fff;
                padding:14px 32px; border-radius:6px; font-size:15px; font-weight:700; text-decoration:none;">
        WhatsApp Us
      </a>
    </div>

  </div><!-- /.container -->
</section>
<style>
/* Why Choose Us — zero out the .section-bar margin that causes white gaps */
.whychooseus-section { margin: 0 !important; }

/* Why Choose Us — flex grid (replaces Bootstrap floats for equal-height cards) */
.wcu-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 24px;
}
.wcu-card {
  background: #fff;
  border-radius: 16px;
  padding: 30px 26px 24px;
  display: flex;
  flex-direction: column;
  box-shadow: 0 4px 24px rgba(0,0,0,0.11);
  width: calc(33.333% - 16px);
  box-sizing: border-box;
}
@media (max-width: 991px) {
  .wcu-card { width: calc(50% - 12px); }
}
@media (max-width: 575px) {
  .wcu-card { width: 100%; }
}
</style>
<!-- END WHY CHOOSE US SECTION -->

<!-- HOW IT WORKS SECTION -->
<section style="background:#f8fafc; padding:64px 0 60px;">
  <div class="container">
    <div style="text-align:center; margin-bottom:48px;">
      <p style="font-size:11px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:#2563eb;margin:0 0 10px;">Simple &amp; Fast</p>
      <h2 style="font-size:32px;font-weight:800;color:#1a1a2e;margin:0 0 14px;position:relative;display:inline-block;padding-bottom:16px;">
        How It Works
        <span style="position:absolute;bottom:0;left:50%;transform:translateX(-50%);width:56px;height:4px;background:linear-gradient(90deg,#2563eb,#16a34a);border-radius:2px;"></span>
      </h2>
      <p style="font-size:15px;color:#555;max-width:520px;margin:0 auto;">From your first message to final installation — we make it effortless.</p>
    </div>
    <div class="ea-hiw-grid">

      <div class="ea-hiw-step">
        <div class="ea-hiw-num">01</div>
        <div class="ea-hiw-icon">&#128172;</div>
        <h3 class="ea-hiw-title">Request a Quote</h3>
        <p class="ea-hiw-desc">Tell us your requirements via WhatsApp, call, or our contact form. We respond within hours.</p>
      </div>
      <div class="ea-hiw-connector"></div>

      <div class="ea-hiw-step">
        <div class="ea-hiw-num">02</div>
        <div class="ea-hiw-icon">&#127912;</div>
        <h3 class="ea-hiw-title">Design Approval</h3>
        <p class="ea-hiw-desc">Our in-house design team creates or finalises your artwork. You approve before we print.</p>
      </div>
      <div class="ea-hiw-connector"></div>

      <div class="ea-hiw-step">
        <div class="ea-hiw-num">03</div>
        <div class="ea-hiw-icon">&#128424;</div>
        <h3 class="ea-hiw-title">Production</h3>
        <p class="ea-hiw-desc">Printed in-house at our Ras Al Khor facility using advanced large-format printing technology.</p>
      </div>
      <div class="ea-hiw-connector"></div>

      <div class="ea-hiw-step">
        <div class="ea-hiw-num">04</div>
        <div class="ea-hiw-icon">&#128666;</div>
        <h3 class="ea-hiw-title">Delivery &amp; Install</h3>
        <p class="ea-hiw-desc">We deliver to all UAE emirates and offer professional on-site installation for signage and exhibitions.</p>
      </div>

    </div>
    <div style="text-align:center; margin-top:40px;">
      <a href="https://api.whatsapp.com/send?phone=971527966265&amp;text=Hi%2C+I%27d+like+to+start+a+print+order"
         target="_blank" rel="noopener"
         style="display:inline-block;background:#16a34a;color:#fff;padding:14px 32px;border-radius:6px;font-size:15px;font-weight:700;text-decoration:none;">
        Start Your Order &rarr;
      </a>
    </div>
  </div>
</section>
<style>
.ea-hiw-grid {
  display:flex; align-items:flex-start; justify-content:center; flex-wrap:wrap; gap:0;
}
.ea-hiw-step {
  flex:1; min-width:160px; max-width:210px; text-align:center;
  padding:28px 18px; background:#fff; border-radius:16px;
  box-shadow:0 2px 16px rgba(0,0,0,0.07);
}
.ea-hiw-num { font-size:11px; font-weight:800; letter-spacing:2px; color:#2563eb; margin-bottom:10px; }
.ea-hiw-icon { font-size:38px; line-height:1; margin-bottom:14px; }
.ea-hiw-title { font-size:16px; font-weight:700; color:#1a1a2e; margin:0 0 10px; }
.ea-hiw-desc { font-size:13px; color:#64748b; line-height:1.7; margin:0; }
.ea-hiw-connector {
  width:40px; height:2px;
  background:linear-gradient(90deg,#2563eb,#16a34a);
  align-self:center; flex-shrink:0; position:relative; top:-22px;
}
@media (max-width:767px) {
  .ea-hiw-grid { flex-direction:column; align-items:center; gap:16px; }
  .ea-hiw-step { max-width:100%; width:100%; }
  .ea-hiw-connector { display:none; }
}
</style>
<!-- END HOW IT WORKS SECTION -->


<!-- YOUTUBE SECTION -->
<style>
/* Facade thumbnail wrapper */
.ea-yt-facade { position:absolute; top:0; left:0; width:100%; height:100%; cursor:pointer; overflow:hidden; }
.ea-yt-facade img { width:100%; height:100%; object-fit:cover; object-position:center top; display:block; transition:transform 0.35s ease; }
.ea-yt-wrap:hover .ea-yt-facade img { transform:scale(1.05); }
/* Play button centred over thumbnail */
.ea-yt-play-btn { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); pointer-events:none; filter:drop-shadow(0 3px 10px rgba(0,0,0,0.6)); transition:transform 0.2s ease; }
.ea-yt-wrap:hover .ea-yt-play-btn { transform:translate(-50%,-50%) scale(1.14); }
/* Hover hint label */
.ea-yt-hint { position:absolute; bottom:12px; left:0; right:0; text-align:center; color:#fff; font-size:11px; font-weight:700; letter-spacing:0.5px; text-transform:uppercase; opacity:0; transition:opacity 0.2s; pointer-events:none; text-shadow:0 1px 4px rgba(0,0,0,0.8); }
.ea-yt-wrap:hover .ea-yt-hint { opacity:1; }
</style>
<section id="ea-yt-section" style="background:#1a1a2e; padding:50px 0;">
  <div class="container">

    <div class="row pb-30 text-center">
      <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
        <div class="creative_heading">
          <h4 style="color:#e63946;">OUR WORK</h4>
          <h2 style="color:#fff;">Our Work Speaks for Itself</h2>
        </div>
        <p style="color:#aaa; font-size:14px; margin-top:10px; margin-bottom:30px;">
          See our latest projects — banners, exhibitions, signage, and vehicle branding across Dubai and the UAE.
        </p>
      </div>
    </div>

    <div class="row" style="display:flex; flex-wrap:wrap; justify-content:center;">

      <!-- Video 1 — to swap: change the two instances of the video ID below -->
      <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:24px; padding:0 10px;">
        <div style="background:#0d0d1a; border-radius:10px; overflow:hidden;">
          <div class="ea-yt-wrap" style="position:relative; padding-top:177.78%; background:#111; border-radius:10px 10px 0 0; overflow:hidden;">
            <div class="ea-yt-facade" data-vid="lsu0EGYvGKw">
              <img src="https://i.ytimg.com/vi/lsu0EGYvGKw/hqdefault.jpg" alt="Printing and Branding Dubai UAE" loading="lazy">
              <div class="ea-yt-play-btn"><svg viewBox="0 0 68 48" width="62" height="44"><path d="M66.52 7.74c-.78-2.93-2.49-5.41-5.42-6.19C55.79.13 34 0 34 0S12.21.13 6.9 1.55c-2.93.78-4.63 3.26-5.42 6.19C.06 13.05 0 24 0 24s.06 10.95 1.48 16.26c.78 2.93 2.49 5.41 5.42 6.19C12.21 47.87 34 48 34 48s21.79-.13 27.1-1.55c2.93-.78 4.64-3.26 5.42-6.19C67.94 34.95 68 24 68 24s-.06-10.95-1.48-16.26z" fill="#f00"/><path d="M45 24 27 14v20" fill="#fff"/></svg></div>
              <div class="ea-yt-hint">Hover to preview &bull; Click to play</div>
            </div>
          </div>
          <div style="padding:12px; text-align:center;">
            <span style="background:#e63946; color:#fff; font-size:11px; font-weight:700; padding:4px 12px; border-radius:20px; text-transform:uppercase; letter-spacing:0.5px;">Branding</span>
          </div>
        </div>
      </div>

      <!-- Video 2 — to swap: change the two instances of the video ID below -->
      <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:24px; padding:0 10px;">
        <div style="background:#0d0d1a; border-radius:10px; overflow:hidden;">
          <div class="ea-yt-wrap" style="position:relative; padding-top:177.78%; background:#111; border-radius:10px 10px 0 0; overflow:hidden;">
            <div class="ea-yt-facade" data-vid="SdWYXXcJqaI">
              <img src="https://i.ytimg.com/vi/SdWYXXcJqaI/hqdefault.jpg" alt="Exhibition Stands and Events Dubai" loading="lazy">
              <div class="ea-yt-play-btn"><svg viewBox="0 0 68 48" width="62" height="44"><path d="M66.52 7.74c-.78-2.93-2.49-5.41-5.42-6.19C55.79.13 34 0 34 0S12.21.13 6.9 1.55c-2.93.78-4.63 3.26-5.42 6.19C.06 13.05 0 24 0 24s.06 10.95 1.48 16.26c.78 2.93 2.49 5.41 5.42 6.19C12.21 47.87 34 48 34 48s21.79-.13 27.1-1.55c2.93-.78 4.64-3.26 5.42-6.19C67.94 34.95 68 24 68 24s-.06-10.95-1.48-16.26z" fill="#f00"/><path d="M45 24 27 14v20" fill="#fff"/></svg></div>
              <div class="ea-yt-hint">Hover to preview &bull; Click to play</div>
            </div>
          </div>
          <div style="padding:12px; text-align:center;">
            <span style="background:#0082C8; color:#fff; font-size:11px; font-weight:700; padding:4px 12px; border-radius:20px; text-transform:uppercase; letter-spacing:0.5px;">Exhibitions</span>
          </div>
        </div>
      </div>

      <!-- Video 3 — to swap: change the two instances of the video ID below -->
      <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:24px; padding:0 10px;">
        <div style="background:#0d0d1a; border-radius:10px; overflow:hidden;">
          <div class="ea-yt-wrap" style="position:relative; padding-top:177.78%; background:#111; border-radius:10px 10px 0 0; overflow:hidden;">
            <div class="ea-yt-facade" data-vid="QMz0sqOM8JA">
              <img src="https://i.ytimg.com/vi/QMz0sqOM8JA/hqdefault.jpg" alt="Signage and Visual Branding UAE" loading="lazy">
              <div class="ea-yt-play-btn"><svg viewBox="0 0 68 48" width="62" height="44"><path d="M66.52 7.74c-.78-2.93-2.49-5.41-5.42-6.19C55.79.13 34 0 34 0S12.21.13 6.9 1.55c-2.93.78-4.63 3.26-5.42 6.19C.06 13.05 0 24 0 24s.06 10.95 1.48 16.26c.78 2.93 2.49 5.41 5.42 6.19C12.21 47.87 34 48 34 48s21.79-.13 27.1-1.55c2.93-.78 4.64-3.26 5.42-6.19C67.94 34.95 68 24 68 24s-.06-10.95-1.48-16.26z" fill="#f00"/><path d="M45 24 27 14v20" fill="#fff"/></svg></div>
              <div class="ea-yt-hint">Hover to preview &bull; Click to play</div>
            </div>
          </div>
          <div style="padding:12px; text-align:center;">
            <span style="background:#2e7d32; color:#fff; font-size:11px; font-weight:700; padding:4px 12px; border-radius:20px; text-transform:uppercase; letter-spacing:0.5px;">Signage</span>
          </div>
        </div>
      </div>

      <!-- Video 4 — to swap: change the two instances of the video ID below -->
      <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:24px; padding:0 10px;">
        <div style="background:#0d0d1a; border-radius:10px; overflow:hidden;">
          <div class="ea-yt-wrap" style="position:relative; padding-top:177.78%; background:#111; border-radius:10px 10px 0 0; overflow:hidden;">
            <div class="ea-yt-facade" data-vid="l33hizcCOZo">
              <img src="https://i.ytimg.com/vi/l33hizcCOZo/hqdefault.jpg" alt="Vehicle Wraps and Fleet Branding Dubai" loading="lazy">
              <div class="ea-yt-play-btn"><svg viewBox="0 0 68 48" width="62" height="44"><path d="M66.52 7.74c-.78-2.93-2.49-5.41-5.42-6.19C55.79.13 34 0 34 0S12.21.13 6.9 1.55c-2.93.78-4.63 3.26-5.42 6.19C.06 13.05 0 24 0 24s.06 10.95 1.48 16.26c.78 2.93 2.49 5.41 5.42 6.19C12.21 47.87 34 48 34 48s21.79-.13 27.1-1.55c2.93-.78 4.64-3.26 5.42-6.19C67.94 34.95 68 24 68 24s-.06-10.95-1.48-16.26z" fill="#f00"/><path d="M45 24 27 14v20" fill="#fff"/></svg></div>
              <div class="ea-yt-hint">Hover to preview &bull; Click to play</div>
            </div>
          </div>
          <div style="padding:12px; text-align:center;">
            <span style="background:#6a1b9a; color:#fff; font-size:11px; font-weight:700; padding:4px 12px; border-radius:20px; text-transform:uppercase; letter-spacing:0.5px;">Vehicle Branding</span>
          </div>
        </div>
      </div>

    </div><!-- /.row -->

    <!-- CTA Buttons -->
    <div style="text-align:center; margin-top:10px;">
      <a href="https://www.youtube.com/@efficientuae" target="_blank" rel="noopener" class="cta-youtube"
         style="display:inline-block; background:#FF0000; color:#fff; padding:14px 32px;
                border-radius:6px; font-size:15px; font-weight:700; text-decoration:none; margin:6px;">
        &#9654; Subscribe on YouTube
      </a>
      <a href="/contact-us/" class="cta-primary"
         style="display:inline-block; background:#2563eb; color:#fff; padding:14px 32px;
                border-radius:6px; font-size:15px; font-weight:700; text-decoration:none; margin:6px;">
        Get a Free Quote
      </a>
    </div>

  </div><!-- /.container -->
</section>
<script>
/* YouTube Facade — zero page-load cost, hover=muted preview, click=full play */
(function(){
  document.querySelectorAll('.ea-yt-wrap').forEach(function(wrap){
    var facade = wrap.querySelector('.ea-yt-facade');
    if (!facade) return;
    var vid = facade.dataset.vid;
    var _iframe = null, _overlay = null, _clicked = false;

    function makeIframe(muted) {
      var f = document.createElement('iframe');
      f.src = 'https://www.youtube.com/embed/' + vid
            + '?autoplay=1&mute=' + (muted ? 1 : 0)
            + '&rel=0&modestbranding=1&playsinline=1';
      f.style.cssText = 'position:absolute;top:0;left:0;width:100%;height:100%;border:none;z-index:3;';
      f.setAttribute('allow', 'accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture');
      f.setAttribute('allowfullscreen', '');
      return f;
    }

    /* HOVER → inject muted preview iframe */
    wrap.addEventListener('mouseenter', function(){
      if (_clicked) return;
      _iframe  = makeIframe(true);
      /* Transparent overlay captures the click so we control unmute */
      _overlay = document.createElement('div');
      _overlay.style.cssText = 'position:absolute;top:0;left:0;width:100%;height:100%;z-index:4;cursor:pointer;';
      _overlay.addEventListener('click', function(){
        _clicked = true;
        _overlay.remove(); _overlay = null;
        /* Swap src to unmuted — user gesture already registered on overlay click */
        _iframe.src = _iframe.src.replace('mute=1', 'mute=0');
        facade.style.display = 'none';
      });
      wrap.appendChild(_iframe);
      wrap.appendChild(_overlay);
      facade.style.visibility = 'hidden';
    });

    /* LEAVE → remove preview, restore thumbnail (unless user clicked) */
    wrap.addEventListener('mouseleave', function(){
      if (_clicked) return;
      if (_iframe)  { _iframe.remove();  _iframe  = null; }
      if (_overlay) { _overlay.remove(); _overlay = null; }
      facade.style.visibility = 'visible';
    });
  });
})();
</script>
<!-- END YOUTUBE SECTION -->

<!-- URGENCY CTA BANNER -->
<section style="background:linear-gradient(135deg,#1a1a2e 0%,#162032 60%,#0f172a 100%); padding:48px 0; position:relative; overflow:hidden;">
  <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#e63946,#f59e0b,#2563eb);"></div>
  <div class="container">
    <div class="ea-urgency-inner">
      <div>
        <p style="font-size:11px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:#f59e0b;margin:0 0 8px;">&#9889; SAME-DAY PRINTING AVAILABLE IN DUBAI</p>
        <h2 style="font-size:28px;font-weight:800;color:#fff;margin:0 0 10px;line-height:1.3;">Need Urgent Printing in Dubai?</h2>
        <p style="font-size:15px;color:rgba(255,255,255,0.75);margin:0;max-width:520px;line-height:1.7;">
          Tight deadline? We offer express and same-day turnaround on banners, signage, and large-format printing across Dubai &mdash; all printed in-house at Ras Al Khor.
        </p>
      </div>
      <div class="ea-urgency-ctas">
        <a href="https://api.whatsapp.com/send?phone=971527966265&amp;text=Hi%2C+I+need+urgent+printing.+Can+you+help%3F"
           target="_blank" rel="noopener" class="ea-urgency-btn-wa">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#fff"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          WhatsApp for Urgent Order
        </a>
        <a href="tel:+971527966265" class="ea-urgency-btn-call">&#128222; Call: +971 52 796 6265</a>
      </div>
    </div>
  </div>
</section>
<style>
.ea-urgency-inner { display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:24px; }
.ea-urgency-ctas { display:flex; flex-direction:column; gap:12px; flex-shrink:0; }
.ea-urgency-btn-wa {
  display:inline-flex; align-items:center; gap:10px;
  background:#16a34a; color:#fff; padding:13px 26px; border-radius:6px;
  font-size:14px; font-weight:700; text-decoration:none; white-space:nowrap;
}
.ea-urgency-btn-wa:hover { background:#15803d; color:#fff; }
.ea-urgency-btn-call {
  display:inline-flex; align-items:center; justify-content:center; gap:8px;
  background:transparent; color:#fff; padding:13px 26px; border-radius:6px;
  font-size:14px; font-weight:700; text-decoration:none; white-space:nowrap;
  border:1.5px solid rgba(255,255,255,0.3);
}
.ea-urgency-btn-call:hover { background:rgba(255,255,255,0.08); color:#fff; }
@media (max-width:767px) { .ea-urgency-ctas { width:100%; } .ea-urgency-btn-wa, .ea-urgency-btn-call { justify-content:center; } }
</style>
<!-- END URGENCY CTA BANNER -->

<!-- QUICK QUOTE FORM SECTION -->
<section id="ea-quote" style="background:#f0f4ff; padding:64px 0 68px;">
  <div class="container">
    <div class="row">
      <div class="col-md-5" style="margin-bottom:32px;">
        <p style="font-size:11px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:#2563eb;margin:0 0 10px;">Free &amp; Fast</p>
        <h2 style="font-size:30px;font-weight:800;color:#1a1a2e;margin:0 0 16px;line-height:1.3;">Get a Free<br>Printing Quote</h2>
        <p style="font-size:14px;color:#555;line-height:1.8;margin-bottom:24px;">
          Fill in the form and we&rsquo;ll respond via WhatsApp within minutes. No commitment required.
        </p>
        <ul style="list-style:none;padding:0;margin:0;">
          <li style="display:flex;align-items:center;gap:10px;margin-bottom:12px;font-size:14px;color:#374151;"><span style="width:24px;height:24px;background:#dcfce7;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;">&#10003;</span>In-house production &mdash; direct pricing</li>
          <li style="display:flex;align-items:center;gap:10px;margin-bottom:12px;font-size:14px;color:#374151;"><span style="width:24px;height:24px;background:#dcfce7;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;">&#10003;</span>Same-day printing available</li>
          <li style="display:flex;align-items:center;gap:10px;margin-bottom:12px;font-size:14px;color:#374151;"><span style="width:24px;height:24px;background:#dcfce7;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;">&#10003;</span>Free design support included</li>
          <li style="display:flex;align-items:center;gap:10px;font-size:14px;color:#374151;"><span style="width:24px;height:24px;background:#dcfce7;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;">&#10003;</span>Delivery across all UAE emirates</li>
        </ul>
      </div>
      <div class="col-md-7">
        <div style="background:#fff;border-radius:16px;padding:32px 28px;box-shadow:0 4px 24px rgba(0,0,0,0.09);">
          <form id="ea-quote-form" onsubmit="eaSubmitQuote(event)" novalidate>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
              <div>
                <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;" for="eq-name">Your Name *</label>
                <input type="text" id="eq-name" placeholder="e.g. Ahmed Hassan" required
                  style="width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;outline:none;box-sizing:border-box;"
                  onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">
              </div>
              <div>
                <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;" for="eq-phone">Phone / WhatsApp *</label>
                <input type="tel" id="eq-phone" placeholder="+971 5X XXX XXXX" required
                  style="width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;outline:none;box-sizing:border-box;"
                  onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">
              </div>
            </div>
            <div style="margin-bottom:16px;">
              <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;" for="eq-service">Service Required *</label>
              <select id="eq-service" required
                style="width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;outline:none;box-sizing:border-box;background:#fff;"
                onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">
                <option value="">Select a service...</option>
                <option>Banner Printing</option>
                <option>Roll-Up / Pop-Up Banners</option>
                <option>Backdrop Printing</option>
                <option>Flag Printing</option>
                <option>Signage &amp; 3D Letters</option>
                <option>Exhibition Stand</option>
                <option>Vehicle Branding</option>
                <option>Event Branding</option>
                <option>Sticker Printing</option>
                <option>Other / Multiple Services</option>
              </select>
            </div>
            <div style="margin-bottom:20px;">
              <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;" for="eq-details">Size / Quantity / Deadline</label>
              <textarea id="eq-details" rows="3" placeholder="e.g. 2m x 1m banner, qty 50, needed by Friday..."
                style="width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;outline:none;box-sizing:border-box;resize:vertical;font-family:inherit;"
                onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
            </div>
            <button type="submit"
              style="width:100%;background:#16a34a;color:#fff;padding:14px;border:none;border-radius:8px;font-size:15px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:10px;transition:background 0.2s;"
              onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#fff"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              Send Quote Request via WhatsApp
            </button>
          </form>
          <p id="ea-quote-err" style="display:none;color:#ef4444;font-size:13px;margin-top:10px;text-align:center;"></p>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
function eaSubmitQuote(e) {
  e.preventDefault();
  var name    = document.getElementById('eq-name').value.trim();
  var phone   = document.getElementById('eq-phone').value.trim();
  var service = document.getElementById('eq-service').value;
  var details = document.getElementById('eq-details').value.trim();
  var err     = document.getElementById('ea-quote-err');
  if (!name || !phone || !service) {
    err.style.display = 'block';
    err.textContent   = 'Please fill in your name, phone, and service required.';
    return;
  }
  if (phone.replace(/\D/g,'').length < 8) {
    err.style.display = 'block';
    err.textContent   = 'Please enter a valid phone/WhatsApp number.';
    return;
  }
  err.style.display = 'none';
  var msg = 'Hi Efficient Advertising,\n\n'
    + 'I would like to request a quote:\n\n'
    + '\u2022 Name: ' + name + '\n'
    + '\u2022 Phone: ' + phone + '\n'
    + '\u2022 Service: ' + service + '\n'
    + (details ? '\u2022 Details: ' + details + '\n' : '')
    + '\nThank you!';
  window.open(
    'https://api.whatsapp.com/send?phone=971527966265&text=' + encodeURIComponent(msg),
    '_blank', 'noopener,noreferrer'
  );
}
</script>
<!-- END QUICK QUOTE FORM SECTION -->

<!-- BLOG TEASER SECTION MOVED — now lives just above footer -->


<section class="blog bestblogred">



        <div class="container">

          <div class="row">

            <div class="row pb-30 text-center">

              <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 ">

                <div class="creative_heading">

                 

                  <h2><?php if(get_field('best_heading')) { echo get_field('best_heading');} else { echo "BEST SELLING PRODUCTS"; } ?></h2>

               <br>

                </div>              

              </div>

            </div>

            <div class="col-lg-12 pdn">

        
  <?php

                  $args = array(

                    'post_type' => 'product','posts_per_page' => '-1',

                    'tax_query' => array(

                        array(

                            'taxonomy' => 'product_category',

                            'field' => 'slug',

                            'terms' => 'best-selling'

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

                    <a href="<?php the_permalink(); ?>"><img class="img-responsive" src="<?php echo esc_url( $thumb['0'] ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?> - Efficient Advertising Dubai" loading="lazy"></a>

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





<section class="reviews">
  <div class="container">
    <div class="reviewshadow">
      <div class="row pb-30 text-center">
        <div class="col-sm-8 mx-auto col-lg-6">
          <div class="creative_heading">
            <h2><?php echo get_field('Google Reviews') ?: ""; ?></h2>
          </div>
          <br>
        </div>
      </div>
      
      <div class="row">
        <div class="col-12 text-center">
          <?php
          // Display the Google Trustindex feed
          echo do_shortcode('[trustindex no-registration=google]');
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ourteam" style="display: none;" >
<div class="container">
<div class="row pb-30 text-center">
 <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 ">
 <div class="creative_heading">
 <h2>OUR TEAM</h2>
 <br>
 </div>              
</div>
 </div>
	
	<div class="team-area">
       
                <div class="row mb-n-30px">
					 <?php
                            $my_query =  new WP_Query( array(
                                'post_type' => 'teams',
                                 'posts_per_page' => -1,
                               )); 
                            $count=0;
                            while($my_query->have_posts()) :
                            $my_query->the_post();
                            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->id), 'full');
                         ?>  
					
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-lm-30px mb-lg-30px mb-md-30px">
                        
                        <div class="team-wrapper ">
                            <div class="team-image overflow-hidden">
                                <img src="<?php echo $thumb['0']; ?>" alt="">
                             
                            </div>
                            <div class="team-inner">
                                <div class="team-content">
                                    <h6 class="title"><?php the_title();?></h6>
                                    <span class="sub-title"><?php if(get_field('designation')) { echo get_field('designation');} else { echo ""; } ?></span>
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
<section class="ourteam eic-instagram-section">
<div class="container">
<div class="eic-instagram-header" style="text-align:center;padding:30px 0 10px;">
    <h2 style="font-size:28px;font-weight:700;margin-bottom:4px;">Follow Us on Instagram</h2>
    <p style="color:#666;font-size:14px;margin:0;"><a href="https://www.instagram.com/efficientuae" target="_blank" rel="noopener noreferrer" style="color:#e1306c;text-decoration:none;">@efficientuae</a></p>
</div>
<?php echo do_shortcode('[efficient-instagram-carousel]'); ?>
</div>
</section>

<!-- ══════════════════════════════════════════════════════════
     FAQ SECTION — SEO schema + accordion UX
     ══════════════════════════════════════════════════════════ -->
<section id="ea-faq" style="background:#f0f4ff; padding:64px 0 72px;">
  <div class="container">

    <!-- Section heading -->
    <div class="row text-center" style="margin-bottom:44px;">
      <div class="col-sm-12">
        <p style="font-size:11px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:#2563eb;margin-bottom:10px;">Got Questions?</p>
        <h2 style="font-size:32px;font-weight:800;color:#1a1a2e;margin:0 0 14px;position:relative;display:inline-block;padding-bottom:16px;">
          Frequently Asked Questions
          <span style="position:absolute;bottom:0;left:50%;transform:translateX(-50%);width:60px;height:4px;background:linear-gradient(90deg,#2563eb,#16a34a);border-radius:2px;"></span>
        </h2>
        <p style="font-size:15px;color:#555;max-width:560px;margin:0 auto;">Everything you need to know about our printing &amp; branding services in Dubai.</p>
      </div>
    </div>

    <!-- FAQ accordion -->
    <div class="row">
      <div class="col-md-6">

        <div class="ea-faq-item">
          <button class="ea-faq-q" aria-expanded="false">
            What types of printing services do you offer in Dubai?
            <span class="ea-faq-icon">+</span>
          </button>
          <div class="ea-faq-a">
            <p>We offer a full range of large-format and commercial printing services including flex banner printing, roll-up banners, backdrops &amp; displays, flags, signage, vehicle branding, exhibition &amp; event materials, and custom corporate branding — all produced in-house at our Ras Al Khor facility in Dubai.</p>
          </div>
        </div>

        <div class="ea-faq-item">
          <button class="ea-faq-q" aria-expanded="false">
            Do you offer same-day or express printing in Dubai?
            <span class="ea-faq-icon">+</span>
          </button>
          <div class="ea-faq-a">
            <p>Yes. We offer same-day and express printing for selected products. Contact us via WhatsApp or call <a href="tel:+971527966265" style="color:#2563eb;">+971 52 796 6265</a> with your order details and we'll confirm the earliest possible turnaround.</p>
          </div>
        </div>

        <div class="ea-faq-item">
          <button class="ea-faq-q" aria-expanded="false">
            Do you deliver printing across all UAE emirates?
            <span class="ea-faq-icon">+</span>
          </button>
          <div class="ea-faq-a">
            <p>Yes, we deliver and install across all emirates including Dubai, Abu Dhabi, Sharjah, Ajman, Ras Al Khaimah, Fujairah, and Umm Al Quwain. We also handle on-site installation for exhibitions, retail fit-outs, and outdoor signage.</p>
          </div>
        </div>

        <div class="ea-faq-item">
          <button class="ea-faq-q" aria-expanded="false">
            Can you print custom sizes for banners and signage?
            <span class="ea-faq-icon">+</span>
          </button>
          <div class="ea-faq-a">
            <p>Absolutely. All our banners, signage, and display products are available in custom sizes. With over 500,000 sq.ft of printing delivered across 18+ years, we can accommodate any dimension requirement for outdoor hoardings, mall branding, or event backdrops.</p>
          </div>
        </div>

        <div class="ea-faq-item">
          <button class="ea-faq-q" aria-expanded="false">
            Do you offer free design support?
            <span class="ea-faq-icon">+</span>
          </button>
          <div class="ea-faq-a">
            <p>Yes, our in-house design team provides free design support for all orders. We can create artwork from scratch, modify your existing files, or advise on print-ready file specifications. Just share your brand guidelines and we'll take it from there.</p>
          </div>
        </div>

      </div>
      <div class="col-md-6">

        <div class="ea-faq-item">
          <button class="ea-faq-q" aria-expanded="false">
            What is the minimum order quantity?
            <span class="ea-faq-icon">+</span>
          </button>
          <div class="ea-faq-a">
            <p>We accept orders of all sizes — from a single banner to bulk runs of thousands of units. We offer significant bulk order discounts for corporate clients, events companies, and government entities. Request a quote for your volume.</p>
          </div>
        </div>

        <div class="ea-faq-item">
          <button class="ea-faq-q" aria-expanded="false">
            How do I get a quote for my printing project?
            <span class="ea-faq-icon">+</span>
          </button>
          <div class="ea-faq-a">
            <p>You can get an instant quote via WhatsApp on <a href="https://wa.me/971527966265" target="_blank" rel="noopener" style="color:#16a34a;">+971 52 796 6265</a>, by calling us, or by using the <a href="/contact" style="color:#2563eb;">Contact Us</a> form. Share your product type, size, quantity, and deadline for the fastest response.</p>
          </div>
        </div>

        <div class="ea-faq-item">
          <button class="ea-faq-q" aria-expanded="false">
            What materials are used for outdoor banners in the UAE?
            <span class="ea-faq-icon">+</span>
          </button>
          <div class="ea-faq-a">
            <p>We use UV-resistant, weatherproof materials specifically suited to the UAE climate — including PVC flex, mesh banners for windload areas, vinyl, and aluminium composite panels. All outdoor prints are UV-laminated for extended longevity in direct sunlight and heat.</p>
          </div>
        </div>

        <div class="ea-faq-item">
          <button class="ea-faq-q" aria-expanded="false">
            Do you handle vehicle branding and fleet wrapping?
            <span class="ea-faq-icon">+</span>
          </button>
          <div class="ea-faq-a">
            <p>Yes. We specialise in vehicle branding for cars, vans, trucks, and full fleet wraps. We use premium cast vinyl with professional installation. Our team handles everything from design approval to final application at our Dubai facility.</p>
          </div>
        </div>

        <div class="ea-faq-item">
          <button class="ea-faq-q" aria-expanded="false">
            Are you a direct printer or a broker?
            <span class="ea-faq-icon">+</span>
          </button>
          <div class="ea-faq-a">
            <p>We are a 100% in-house printing facility with 18+ years of experience. We own and operate our own advanced printing equipment — no middlemen. This means better quality control, faster turnaround, and more competitive pricing for every order.</p>
          </div>
        </div>

      </div>
    </div><!-- .row -->

  </div><!-- .container -->
</section>

<!-- FAQ JSON-LD Schema — Google Rich Result eligible -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What types of printing services do you offer in Dubai?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "We offer a full range of large-format and commercial printing services including flex banner printing, roll-up banners, backdrops & displays, flags, signage, vehicle branding, exhibition & event materials, and custom corporate branding — all produced in-house at our Ras Al Khor facility in Dubai."
      }
    },
    {
      "@type": "Question",
      "name": "Do you offer same-day or express printing in Dubai?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. We offer same-day and express printing for selected products. Contact us via WhatsApp or call +971 52 796 6265 with your order details and we'll confirm the earliest possible turnaround."
      }
    },
    {
      "@type": "Question",
      "name": "Do you deliver printing across all UAE emirates?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, we deliver and install across all emirates including Dubai, Abu Dhabi, Sharjah, Ajman, Ras Al Khaimah, Fujairah, and Umm Al Quwain. We also handle on-site installation for exhibitions, retail fit-outs, and outdoor signage."
      }
    },
    {
      "@type": "Question",
      "name": "Can you print custom sizes for banners and signage?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Absolutely. All our banners, signage, and display products are available in custom sizes. With over 500,000 sq.ft of printing delivered across 18+ years, we can accommodate any dimension requirement for outdoor hoardings, mall branding, or event backdrops."
      }
    },
    {
      "@type": "Question",
      "name": "Do you offer free design support?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, our in-house design team provides free design support for all orders. We can create artwork from scratch, modify your existing files, or advise on print-ready file specifications."
      }
    },
    {
      "@type": "Question",
      "name": "What is the minimum order quantity?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "We accept orders of all sizes — from a single banner to bulk runs of thousands of units. We offer significant bulk order discounts for corporate clients, events companies, and government entities."
      }
    },
    {
      "@type": "Question",
      "name": "How do I get a quote for my printing project?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "You can get an instant quote via WhatsApp on +971 52 796 6265, by calling us, or by using the Contact Us form on our website. Share your product type, size, quantity, and deadline for the fastest response."
      }
    },
    {
      "@type": "Question",
      "name": "What materials are used for outdoor banners in the UAE?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "We use UV-resistant, weatherproof materials specifically suited to the UAE climate — including PVC flex, mesh banners for windload areas, vinyl, and aluminium composite panels. All outdoor prints are UV-laminated for extended longevity in direct sunlight and heat."
      }
    },
    {
      "@type": "Question",
      "name": "Do you handle vehicle branding and fleet wrapping?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. We specialise in vehicle branding for cars, vans, trucks, and full fleet wraps. We use premium cast vinyl with professional installation."
      }
    },
    {
      "@type": "Question",
      "name": "Are you a direct printer or a broker?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "We are a 100% in-house printing facility with 18+ years of experience. We own and operate our own advanced printing equipment — no middlemen. This means better quality control, faster turnaround, and more competitive pricing for every order."
      }
    }
  ]
}
</script>

<!-- SEO CONTENT BLOCK -->
<section style="background:#f8fafc; padding:60px 0; border-top:1px solid #eee;">
  <div class="container">
    <div class="row">
      <div class="col-md-7" style="margin-bottom:28px;">
        <h2 style="font-size:24px; font-weight:800; color:#1a1a2e; margin:0 0 20px; line-height:1.4;">
          Printing Company in Dubai &mdash; Banner Printing, Signage &amp; Branding Since 2008
        </h2>
        <p style="font-size:14px; color:#444; line-height:1.9; margin-bottom:16px;">
          Efficient Advertising is a leading <strong>printing company in Dubai</strong>, specialising in large-format printing, signage, banner printing, exhibition stands, vehicle branding, and corporate event materials. Based in Ras Al Khor Industrial Area, Dubai, we have been serving businesses across the UAE since 2008 &mdash; 18+ years of trusted printing and branding expertise.
        </p>
        <p style="font-size:14px; color:#444; line-height:1.9; margin-bottom:16px;">
          Our in-house production facility handles everything from <strong>flex banner printing</strong> and <strong>backdrop printing Dubai</strong> to full <strong>exhibition stand design and build</strong>. We operate our own advanced large-format printers &mdash; meaning no middlemen, tighter quality control, faster turnaround, and better value. Whether you need a single <strong>roll-up banner</strong> for a conference or 1,000 branded flags for a UAE National Day event, we deliver on time and on budget.
        </p>
        <p style="font-size:14px; color:#444; line-height:1.9; margin-bottom:16px;">
          For businesses across Dubai, Sharjah, Abu Dhabi, and all UAE emirates, we offer <strong>same-day printing</strong> on selected items &mdash; one of the very few printing companies in Dubai with genuine in-house capability. Our designers, printers, and installers work as one team to ensure every print job is production-ready, colourfast, and finished to the highest standard.
        </p>
        <p style="font-size:14px; color:#444; line-height:1.9;">
          Need <strong>vehicle branding in Dubai</strong>? Our certified wrap technicians handle everything from partial vinyl wraps to full fleet branding campaigns. Planning a trade show or exhibition? Our <strong>exhibition stand Dubai</strong> team designs, prints, and installs on-site. Looking for durable <strong>outdoor signage UAE</strong>? We use UV-resistant materials guaranteed for the region&rsquo;s harsh climate.
        </p>
      </div>
      <div class="col-md-5" style="margin-bottom:28px;">
        <div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 12px rgba(0,0,0,0.07); margin-bottom:20px;">
          <h3 style="font-size:15px; font-weight:700; color:#1a1a2e; margin:0 0 14px;">Our Services in Dubai &amp; UAE</h3>
          <ul style="list-style:none; padding:0; margin:0;">
            <?php
            $seo_services = [
              'Banner Printing Dubai', 'Backdrop &amp; Display Printing',
              'Roll-Up Banners Dubai', 'Flag Printing Dubai',
              'Large Format Printing', 'Signage &amp; 3D Lettering',
              'Exhibition Stands Dubai', 'Vehicle Branding Dubai',
              'Fleet Wrap &amp; Branding', 'Sticker Printing Dubai',
              'Wall Graphics &amp; Murals', 'Same-Day Printing Dubai',
            ];
            foreach ( $seo_services as $svc ) {
              echo '<li style="font-size:13px;color:#374151;padding:5px 0;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:8px;"><span style="color:#16a34a;font-weight:700;flex-shrink:0;">&#10003;</span>' . $svc . '</li>';
            }
            ?>
          </ul>
        </div>
        <div style="background:linear-gradient(135deg,#1e3a8a,#2563eb); border-radius:12px; padding:24px; color:#fff;">
          <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:2px; opacity:0.8; margin:0 0 6px;">Based in Dubai Since 2008</p>
          <p style="font-size:18px; font-weight:800; margin:0 0 8px;">Ras Al Khor Industrial Area 1</p>
          <p style="font-size:13px; opacity:0.85; margin:0 0 16px; line-height:1.6;">Warehouse-11, 10C Street,<br>Dubai, United Arab Emirates</p>
          <a href="tel:+971527966265" style="color:#fbbf24; font-size:15px; font-weight:700; text-decoration:none;">&#128222; +971 52 796 6265</a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- END SEO CONTENT BLOCK -->

<!-- BLOG TEASER SECTION -->
<section style="background:#fff; padding:56px 0 60px; border-top:1px solid #eee;">
  <div class="container">

    <div class="row text-center" style="margin-bottom:36px;">
      <div class="col-sm-12">
        <p style="font-size:12px; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:#555; margin-bottom:10px;">Stay Updated With Trends</p>
        <h2 style="font-size:30px; font-weight:800; color:#1a1a2e; margin:0 0 14px; position:relative; display:inline-block; padding-bottom:14px;">
          Latest News &amp; Blog
          <span style="display:block; width:56px; height:3px; background:#e63946; border-radius:2px; position:absolute; bottom:0; left:50%; transform:translateX(-50%);"></span>
        </h2>
      </div>
    </div>

    <div class="row">
      <?php
        $blog_posts = new WP_Query([
          'post_type'      => 'post',
          'post_status'    => 'publish',
          'posts_per_page' => 3,
          'orderby'        => 'date',
          'order'          => 'DESC',
        ]);
        if ( $blog_posts->have_posts() ) :
          while ( $blog_posts->have_posts() ) : $blog_posts->the_post();
            $thumb = has_post_thumbnail()
              ? get_the_post_thumbnail_url( get_the_ID(), 'medium_large' )
              : null;
            $cats  = get_the_category();
            $cat   = $cats ? esc_html( $cats[0]->name ) : '';
            $post_url = esc_url( get_permalink( get_the_ID() ) );
      ?>
      <div class="col-md-4 col-sm-6" style="margin-bottom:32px;">
        <div style="background:#fff; border-radius:4px; overflow:hidden; box-shadow:0 1px 6px rgba(0,0,0,.1); height:100%; display:flex; flex-direction:column;">
          <!-- Image with date badge -->
          <a href="<?php echo $post_url; ?>" style="display:block; position:relative; overflow:hidden; flex-shrink:0;">
            <?php if ( $thumb ) : ?>
            <img src="<?php echo esc_url($thumb); ?>"
                 alt="<?php the_title_attribute(); ?>"
                 style="width:100%; height:210px; object-fit:cover; display:block; transition:transform .35s ease;"
                 onmouseover="this.style.transform='scale(1.05)'"
                 onmouseout="this.style.transform='scale(1)'" />
            <?php else : ?>
            <div style="width:100%; height:210px; background:linear-gradient(135deg,#1a1a2e 0%,#0082C8 100%); display:flex; align-items:center; justify-content:center;">
              <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
            </div>
            <?php endif; ?>
            <!-- Date badge -->
            <div style="position:absolute; top:12px; left:12px; background:#e63946; color:#fff; border-radius:50%; width:54px; height:54px; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; line-height:1.1;">
              <span style="font-size:18px; font-weight:800;"><?php echo get_the_date('d'); ?></span>
              <span style="font-size:10px; font-weight:700; text-transform:uppercase;"><?php echo get_the_date('M'); ?></span>
            </div>
          </a>
          <div style="padding:14px 16px 18px; flex:1; display:flex; flex-direction:column;">
            <p style="font-size:12px; color:#e63946; margin:0 0 6px 0; font-weight:600;">Posted by <?php the_author(); ?> -</p>
            <h3 style="font-size:15px; font-weight:700; line-height:1.45; color:#1a1a2e; margin:0; flex:1;">
              <a href="<?php echo $post_url; ?>" style="color:inherit; text-decoration:none;"><?php echo wp_trim_words( get_the_title(), 10, '&hellip;' ); ?></a>
            </h3>
          </div>
        </div>
      </div>
      <?php endwhile; wp_reset_postdata(); endif; ?>
    </div>

    <div class="row text-center" style="margin-top:10px;">
      <div class="col-sm-12">
        <a href="<?php echo esc_url( home_url('/blog/') ); ?>" class="cta-secondary"
           style="display:inline-block; background:#1e293b; color:#fff; padding:14px 32px; border-radius:6px; font-size:15px; font-weight:700; text-decoration:none; letter-spacing:.5px;">
          View All Articles
        </a>
      </div>
    </div>

  </div>
</section>
<!-- END BLOG TEASER SECTION -->

<?php include("footer.php"); ?>



