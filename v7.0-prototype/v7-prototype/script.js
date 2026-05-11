document.addEventListener('DOMContentLoaded', () => {
    
    // Navbar Scroll Logic
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 30) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // V6 UX Element: Interactive Custom Cursor
    const cursor = document.getElementById('cursor');
    const hoverTargets = document.querySelectorAll('.hover-target');
    
    // Track cursor position
    document.addEventListener('mousemove', (e) => {
        if(window.innerWidth > 900) { // Only animate on desktop
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
        }
    });
    
    // Trigger cursor interactions
    hoverTargets.forEach(target => {
        target.addEventListener('mouseenter', () => cursor.classList.add('active'));
        target.addEventListener('mouseleave', () => cursor.classList.remove('active'));
    });

    // V6 x V5 Element: Parallax Neon Glow Box
    const orb = document.getElementById('orb');
    
    document.addEventListener('mousemove', (e) => {
        if(window.innerWidth > 900) {
            // Soft parallax tracking
            const xPos = (e.clientX / window.innerWidth - 0.5) * 15; 
            const yPos = (e.clientY / window.innerHeight - 0.5) * 15;
            
            orb.style.transform = `translate(calc(-50% + ${xPos}vw), calc(-50% + ${yPos}vh))`;
        }
    });

    // V6 Reveal UX: Intersection Observer
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { rootMargin: '0px', threshold: 0.15 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
});
