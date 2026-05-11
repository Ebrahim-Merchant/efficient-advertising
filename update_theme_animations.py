import os
import re

header_path = "C:/Users/merch/Local Sites/EfficientAdvt.Com/app/public/wp-content/themes/Efficient-dev/header.php"
footer_path = "C:/Users/merch/Local Sites/EfficientAdvt.Com/app/public/wp-content/themes/Efficient-dev/footer.php"

# 1. Update HEADER
with open(header_path, "r", encoding="utf-8") as f:
    header = f.read()

# Fonts
header = re.sub(r'family=[^&]+&family=[^&]+&family=[^&]+', 'family=Outfit:wght@300;400;500;600;700;800;900', header)
header = header.replace("'Gotham', 'Helvetica Neue', Arial, sans-serif", "'Outfit', sans-serif")

# Colors
header = header.replace("color: #16a34a", "color: #F59E0B") # Phone green -> Amber
header = header.replace("color: #15803d", "color: #D97706") # Phone hover -> Darker Amber
header = header.replace("border-color: #2563eb", "border-color: #F59E0B") # Search focus
header = header.replace("background: #2563eb", "background: #0F172A") # Search btn blue -> Black
header = header.replace("background: #1d4ed8", "background: #F59E0B") # Search btn hover
header = header.replace("background:#dedede", "background:#ffffff") # Header bg

with open(header_path, "w", encoding="utf-8") as f:
    f.write(header)

# 2. Update FOOTER
with open(footer_path, "r", encoding="utf-8") as f:
    footer = f.read()

footer = footer.replace("#16a34a", "#F59E0B") # WhatsApp / Colors to Amber
footer = footer.replace("#4ade80", "#F59E0B") # Light green to Amber
footer = footer.replace("rgba(34,197,94,0.1)", "rgba(245,158,11,0.1)")
footer = footer.replace("rgba(34,197,94,0.2)", "rgba(245,158,11,0.2)")

footer = footer.replace("#0284c7", "#0F172A") # Call blue to Black
footer = footer.replace("#f0fdf4", "#fffbeb") # WA hover bg to amber-light
footer = footer.replace("#f0f9ff", "#f8fafc") # Call hover bg 

# 3. Add Animations block to footer (Mouse Follower + SVG Background)
animation_html = """
<!-- ==========================================
     PREMIUM ANIMATIONS & MOUSE FOLLOWER 
     ========================================== -->
<div class="ea-bg-animation">
  <svg class="blob blob-1" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
    <path fill="#F59E0B" d="M45.7,-76.3C58.9,-69.3,69.1,-56,76.5,-41.8C83.9,-27.6,88.4,-12.3,86.6,2.3C84.8,16.8,76.6,30.6,66.8,42.4C57,54.1,45.6,63.9,32.2,71.2C18.8,78.5,3.3,83.4,-11.7,82.4C-26.7,81.3,-41.1,74.3,-53.4,64.2C-65.6,54.1,-75.7,40.9,-81.4,26.1C-87,11.3,-88.2,-5,-83.4,-18.7C-78.5,-32.4,-67.5,-43.5,-55.1,-51.6C-42.7,-59.7,-28.9,-65,-14.8,-67.8C-0.6,-70.6,14.6,-71.1,29.3,-72.1C44,-73,59.2,-74.5,45.7,-76.3Z" transform="translate(100 100)" />
  </svg>
  <svg class="blob blob-2" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
    <path fill="#0F172A" d="M38.8,-63.9C52.4,-57.4,66.8,-49.6,76,-37.9C85.1,-26.2,89,-10.6,87.7,4.5C86.4,19.5,79.9,34.1,70.1,45.9C60.3,57.7,47.2,66.7,32.8,72.4C18.4,78.2,2.7,80.7,-11.7,78.5C-26.1,76.3,-39.2,69.5,-50.2,59.5C-61.2,49.6,-70.1,36.5,-75.5,21.9C-80.9,7.3,-82.8,-8.7,-78.3,-22.6C-73.8,-36.5,-62.9,-48.3,-50,-55C-37,-61.7,-22.1,-63.3,-7.9,-66.2C6.3,-69.1,20.6,-73.2,33.5,-73.5C46.4,-73.8,57.8,-70.3,38.8,-63.9Z" transform="translate(100 100)" />
  </svg>
</div>

<div class="ea-cursor-dot"></div>
<div class="ea-cursor-ring"></div>

<style>
/* Background Blobs */
.ea-bg-animation {
  position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; 
  z-index: -1; pointer-events: none; overflow: hidden; 
  background: #ffffff;
}
.ea-bg-animation .blob {
  position: absolute; width: 800px; height: 800px; 
  filter: blur(120px); opacity: 0.15; 
  animation: floatBlobs 25s ease-in-out infinite alternate;
}
.blob-1 { top: -200px; left: -200px; }
.blob-2 { bottom: -200px; right: -150px; animation-delay: -10s; }

@keyframes floatBlobs {
  0% { transform: translate(0, 0) scale(1) rotate(0deg); }
  50% { transform: translate(100px, 150px) scale(1.1) rotate(45deg); }
  100% { transform: translate(-50px, 200px) scale(0.9) rotate(90deg); }
}

/* Mouse Follower Cursor */
body { cursor: none; } /* Hide default cursor */
.ea-cursor-dot {
  position: fixed; top: 0; left: 0;
  width: 8px; height: 8px;
  background-color: #F59E0B;
  border-radius: 50%;
  transform: translate(-50%, -50%);
  pointer-events: none;
  z-index: 999999;
  transition: width 0.2s, height 0.2s, background-color 0.2s;
}
.ea-cursor-ring {
  position: fixed; top: 0; left: 0;
  width: 36px; height: 36px;
  border: 2px solid rgba(245, 158, 11, 0.4);
  border-radius: 50%;
  transform: translate(-50%, -50%);
  pointer-events: none;
  z-index: 999998;
  box-sizing: border-box;
  transition: width 0.2s, height 0.2s, border-color 0.2s;
}
/* Interaction states */
.ea-cursor-dot.hover { transform: translate(-50%, -50%) scale(1.5); background-color: #0F172A; }
.ea-cursor-ring.hover { width: 50px; height: 50px; border-color: rgba(15, 23, 42, 0.5); background-color: rgba(245, 158, 11, 0.1); }
</style>

<script>
  // Mouse Follower JS
  const dot = document.querySelector('.ea-cursor-dot');
  const ring = document.querySelector('.ea-cursor-ring');
  let mouseX = 0, mouseY = 0;
  let ringX = 0, ringY = 0;

  document.addEventListener('mousemove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;
    dot.style.transform = `translate(${mouseX}px, ${mouseY}px)`;
  });

  function renderRing() {
    ringX += (mouseX - ringX) * 0.15;
    ringY += (mouseY - ringY) * 0.15;
    ring.style.transform = `translate(${ringX}px, ${ringY}px)`;
    requestAnimationFrame(renderRing);
  }
  requestAnimationFrame(renderRing);

  // Add hover effect to interactive elements
  const interactives = document.querySelectorAll('a, button, input, select, textarea, .owl-nav div');
  interactives.forEach(el => {
    el.addEventListener('mouseenter', () => {
      dot.classList.add('hover');
      ring.classList.add('hover');
    });
    el.addEventListener('mouseleave', () => {
      dot.classList.remove('hover');
      ring.classList.remove('hover');
    });
  });
</script>
<!-- ========================================== -->
"""

if "ea-bg-animation" not in footer:
    footer = footer.replace("</body>", animation_html + "\n</body>")

with open(footer_path, "w", encoding="utf-8") as f:
    f.write(footer)

print("Theme updated successfully!")
