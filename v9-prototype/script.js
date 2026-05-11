/**
 * EFFICIENT ADVERTISING - V9 PROTOTYPE
 * GSAP ScrollTrigger & Lenis Smooth Scroll
 */

document.addEventListener("DOMContentLoaded", () => {
  // 1. Initialize Lenis Smooth Scroll
  const lenis = new Lenis({
    duration: 1.2,
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
    direction: 'vertical',
    gestureDirection: 'vertical',
    smooth: true,
    mouseMultiplier: 1,
    smoothTouch: false,
    touchMultiplier: 2,
    infinite: false,
  });

  // Sync GSAP ScrollTrigger with Lenis
  lenis.on('scroll', ScrollTrigger.update);
  gsap.ticker.add((time) => {
    lenis.raf(time * 1000);
  });
  gsap.ticker.lagSmoothing(0, 0);

  // 2. Custom Cursor
  const cursorDot = document.querySelector('.cursor-dot');
  const cursorRing = document.querySelector('.cursor-ring');

  window.addEventListener('mousemove', (e) => {
    gsap.to(cursorDot, {
      x: e.clientX,
      y: e.clientY,
      duration: 0.1,
      ease: "power2.out"
    });
    gsap.to(cursorRing, {
      x: e.clientX,
      y: e.clientY,
      duration: 0.3,
      ease: "power2.out"
    });
  });

  // Hover states for cursor
  document.querySelectorAll('a, button, .panel-card').forEach(el => {
    el.addEventListener('mouseenter', () => {
      gsap.to(cursorRing, { width: 60, height: 60, scale: 1.5, borderColor: '#fff', duration: 0.3 });
      gsap.to(cursorDot, { scale: 0, duration: 0.3 });
    });
    el.addEventListener('mouseleave', () => {
      gsap.to(cursorRing, { width: 40, height: 40, scale: 1, borderColor: '#ccff00', duration: 0.3 });
      gsap.to(cursorDot, { scale: 1, duration: 0.3 });
    });
  });

  // 3. Hero Entrance Animations
  const tlHero = gsap.timeline({ delay: 0.2 });
  
  // Split Text Animation (Words slide up)
  tlHero.to('.hero-title .word', {
    y: '0%',
    duration: 1,
    stagger: 0.1,
    ease: "power4.out"
  })
  .to('.hero-badge', {
    opacity: 1,
    y: 0,
    duration: 0.6,
    ease: "power2.out"
  }, "-=0.6")
  .to('.hero-subtext', {
    opacity: 1,
    y: 0,
    duration: 0.8,
    ease: "power2.out"
  }, "-=0.6")
  .to('.scroll-indicator', {
    opacity: 1,
    duration: 0.8
  }, "-=0.4");

  // Hero Parallax on Scroll
  gsap.to('.hero-bg-media img', {
    yPercent: 30,
    ease: "none",
    scrollTrigger: {
      trigger: ".v9-hero",
      start: "top top",
      end: "bottom top",
      scrub: true
    }
  });

  // 4. Horizontal Scroll Section
  const track = document.querySelector('.h-track');
  const horizontalSec = document.querySelector('.v9-horizontal-sec');

  if (track && horizontalSec) {
    // Calculate total scroll distance based on track width vs viewport width
    let getScrollAmount = () => -(track.scrollWidth - window.innerWidth);

    const tween = gsap.to(track, {
      x: getScrollAmount,
      ease: "none"
    });

    ScrollTrigger.create({
      trigger: horizontalSec,
      start: "top top",
      end: () => `+=${track.scrollWidth}`, /* Scroll distance = track width */
      pin: true,
      animation: tween,
      scrub: 1,
      invalidateOnRefresh: true,
      anticipatePin: 1
    });
  }

  // 5. Stat Counter Reveal
  gsap.from('.stat-box', {
    y: 60,
    opacity: 0,
    duration: 0.8,
    stagger: 0.2,
    ease: "power3.out",
    scrollTrigger: {
      trigger: ".v9-stats",
      start: "top 75%",
    }
  });

  // Update scroll distance on resize
  window.addEventListener('resize', () => {
    ScrollTrigger.refresh();
  });
});
