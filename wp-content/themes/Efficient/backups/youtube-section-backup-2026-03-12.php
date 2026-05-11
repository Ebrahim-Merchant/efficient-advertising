<?php
/**
 * BACKUP — YouTube / Our Work section
 * Saved: 2026-03-12
 * Source: index.php lines 796–910
 * This is the complete "Our Work Speaks for Itself" section as it stood on this date.
 * To restore: copy everything between the two PHP comment markers back into index.php.
 */
?>
<!-- YOUTUBE SECTION -->
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

      <!-- Video 1 -->
      <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:24px; padding:0 10px;">
        <div style="background:#0d0d1a; border-radius:10px; overflow:hidden;">
          <div style="position:relative; padding-top:177.78%; background:#000;">
            <iframe src="https://www.youtube.com/embed/lsu0EGYvGKw?enablejsapi=1"
              style="position:absolute; top:0; left:0; width:100%; height:100%; border:none;"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen loading="lazy" title="Printing & Branding — Dubai UAE"></iframe>
          </div>
          <div style="padding:12px; text-align:center;">
            <span style="background:#e63946; color:#fff; font-size:11px; font-weight:700; padding:4px 12px; border-radius:20px; text-transform:uppercase; letter-spacing:0.5px;">Branding</span>
          </div>
        </div>
      </div>

      <!-- Video 2 -->
      <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:24px; padding:0 10px;">
        <div style="background:#0d0d1a; border-radius:10px; overflow:hidden;">
          <div style="position:relative; padding-top:177.78%; background:#000;">
            <iframe src="https://www.youtube.com/embed/SdWYXXcJqaI?enablejsapi=1"
              style="position:absolute; top:0; left:0; width:100%; height:100%; border:none;"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen loading="lazy" title="Exhibition Stands & Events — Dubai"></iframe>
          </div>
          <div style="padding:12px; text-align:center;">
            <span style="background:#0082C8; color:#fff; font-size:11px; font-weight:700; padding:4px 12px; border-radius:20px; text-transform:uppercase; letter-spacing:0.5px;">Exhibitions</span>
          </div>
        </div>
      </div>

      <!-- Video 3 -->
      <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:24px; padding:0 10px;">
        <div style="background:#0d0d1a; border-radius:10px; overflow:hidden;">
          <div style="position:relative; padding-top:177.78%; background:#000;">
            <iframe src="https://www.youtube.com/embed/QMz0sqOM8JA?enablejsapi=1"
              style="position:absolute; top:0; left:0; width:100%; height:100%; border:none;"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen loading="lazy" title="Signage & Visual Branding — UAE"></iframe>
          </div>
          <div style="padding:12px; text-align:center;">
            <span style="background:#2e7d32; color:#fff; font-size:11px; font-weight:700; padding:4px 12px; border-radius:20px; text-transform:uppercase; letter-spacing:0.5px;">Signage</span>
          </div>
        </div>
      </div>

      <!-- Video 4 -->
      <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:24px; padding:0 10px;">
        <div style="background:#0d0d1a; border-radius:10px; overflow:hidden;">
          <div style="position:relative; padding-top:177.78%; background:#000;">
            <iframe src="https://www.youtube.com/embed/l33hizcCOZo?enablejsapi=1"
              style="position:absolute; top:0; left:0; width:100%; height:100%; border:none;"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen loading="lazy" title="Vehicle Wraps & Fleet Branding — Dubai"></iframe>
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
(function(){
  document.querySelectorAll('#ea-yt-section .col-md-3, #ea-yt-section .col-sm-6').forEach(function(col){
    var iframe = col.querySelector('iframe');
    if (!iframe) return;
    col.style.cursor = 'pointer';
    col.addEventListener('mouseenter', function(){
      iframe.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
    });
    col.addEventListener('mouseleave', function(){
      iframe.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
    });
  });
})();
</script>
<!-- END YOUTUBE SECTION -->
