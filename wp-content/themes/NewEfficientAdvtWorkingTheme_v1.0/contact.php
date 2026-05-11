<?php
/**
 * Template Name: Contact Us
 *
 */
 get_header(); ?>
<section class="contdetail">

  <div class="icon-box-area mb-100 mb-md-30 mb-sm-30" style="padding-top:60px;">
    <div class="container">
      <div class="row" style="display:flex; flex-wrap:wrap;">
        <div class="col-md-4 mb-md-70 mb-sm-70" style="display:flex; flex-direction:column;">
          <a href="https://www.google.com/maps/dir//Efficient+Advertising+LLC,+Warehouse-11+10C+Street+-+Ras+Al+Khor+Industrial+Area+1+-+Dubai/@25.2792793,55.334664,14z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3e5f433376dbc64d:0x93df4d4b2e23867f!2m2!1d55.3341345!2d25.1774446?entry=ttu&g_ep=EgoyMDI2MDUwMi4wIKXMDSoASAFQAw%3D%3D" target="_blank" rel="noopener" class="ea-contact-card" style="display:block; text-decoration:none; background:#102B49; border:1px solid rgba(255,255,255,0.08); border-radius:12px; padding:35px 20px; text-align:center; height:100%; transition:transform 0.3s ease, border-color 0.3s ease; box-shadow:0 10px 30px rgba(0,0,0,0.15);">
            <div style="width:64px; height:64px; border-radius:50%; background:rgba(255,193,7,0.1); color:#FFC107; font-size:26px; line-height:64px; margin:0 auto 20px;">
             <i class="fa fa-map-marker" aria-hidden="true"></i>
            </div>
            <h3 style="color:#FFFFFF; font-size:16px; font-weight:800; letter-spacing:1px; margin-bottom:12px;">ADDRESS</h3>
            <p style="color:#B8C2CC; font-size:14px; line-height:1.6; margin:0;"><?php if(of_get_option('header_address')) { echo wp_kses_post(of_get_option('header_address'));} else { echo ""; } ?></p>
          </a>
        </div>
        <div class="col-md-4 mb-md-70 mb-sm-70" style="display:flex; flex-direction:column;">
          <a href="tel:+971545889737" class="ea-contact-card" style="display:block; text-decoration:none; background:#102B49; border:1px solid rgba(255,255,255,0.08); border-radius:12px; padding:35px 20px; text-align:center; height:100%; transition:transform 0.3s ease, border-color 0.3s ease; box-shadow:0 10px 30px rgba(0,0,0,0.15);">
            <div style="width:64px; height:64px; border-radius:50%; background:rgba(255,193,7,0.1); color:#FFC107; font-size:26px; line-height:64px; margin:0 auto 20px;">
              <i class="fa fa-phone" aria-hidden="true"></i>
            </div>
            <h3 style="color:#FFFFFF; font-size:16px; font-weight:800; letter-spacing:1px; margin-bottom:12px;">PHONE</h3>
            <p style="color:#B8C2CC; font-size:14px; margin:0;">+971 54 588 9737</p>
          </a>
        </div>
        <div class="col-md-4 mb-md-70 mb-sm-70" style="display:flex; flex-direction:column;">
          <a href="javascript:void(0);" onclick="eaOpenEmailOtpModal();" class="ea-contact-card" style="display:block; text-decoration:none; background:#102B49; border:1px solid rgba(255,255,255,0.08); border-radius:12px; padding:35px 20px; text-align:center; height:100%; transition:transform 0.3s ease, border-color 0.3s ease; box-shadow:0 10px 30px rgba(0,0,0,0.15);">
            <div style="width:64px; height:64px; border-radius:50%; background:rgba(255,193,7,0.1); color:#FFC107; font-size:26px; line-height:64px; margin:0 auto 20px;">
              <i class="fa fa-envelope" aria-hidden="true"></i>
            </div>
            <h3 style="color:#FFFFFF; font-size:16px; font-weight:800; letter-spacing:1px; margin-bottom:12px;">EMAIL</h3>
            <p style="color:#B8C2CC; font-size:14px; margin:0;">info@efficientadvt.com</p>
          </a>
        </div>
      </div>
    </div>
  </div>

<div class="map">
  <div class="container">
	  <?php if(get_field('google_map')) { echo get_field('google_map');} else { echo ""; } ?>
  </div>
</div>

  <div class="section-title-container mb-50 mt50" style="padding-top:40px;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-title section-title--one text-center">
            <h1 style="color:#FFFFFF !important; font-size:48px; font-weight:900; text-shadow:0 4px 12px rgba(0,0,0,0.5);">Get in touch</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="contact-form-area mb-60">
    <div class="container">
      <div class="row">
<div class="col-md-2 hidden-xs hidden-sm"></div>
        <div class="col-lg-8 col-xs-12">
          <style>
          .ea-contact-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
          }
          @media (max-width: 767px) {
            .ea-contact-grid {
              grid-template-columns: 1fr;
              gap: 15px;
            }
          }
          .ea-contact-input, .ea-contact-textarea {
            width: 100%;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 14px;
            color: #FFFFFF;
            background: #102B49;
            outline: none;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
          }
          .ea-contact-input:focus, .ea-contact-textarea:focus {
            border-color: #FFC107;
            box-shadow: 0 0 0 3px rgba(255,193,7,0.15);
          }
          .ea-contact-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #475569;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
          }
          .ea-contact-submit-btn {
            background: #FFC107;
            color: #0B1F38;
            font-size: 15px;
            font-weight: 800;
            border: 2px solid #FFC107;
            border-radius: 10px;
            padding: 14px 32px;
            cursor: pointer;
            transition: all 0.25s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
          }
          .ea-contact-submit-btn:hover {
            background: #FFFFFF;
            border-color: #FFFFFF;
            color: #0B1F38;
          }
          </style>

          <div class="lezada-form contact-form">
            <form id="ea-main-contact-form" class="ea-custom-ajax-form" method="POST" enctype="multipart/form-data" action="">
              <?php wp_nonce_field( 'ea_contact_submit', 'ea_nonce' ); ?>
              <input type="text" name="ea_hp_honeypot" class="ea-form-hp-field" style="display:none !important;" tabindex="-1" autocomplete="off">
              <input type="hidden" name="ea_page_url" value="<?php echo esc_url( (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ); ?>">
              <input type="hidden" name="action" value="ea_contact_form_submit">
              <input type="hidden" name="ea_recaptcha_response" id="ea-contact-recaptcha-response" value="">

              <div class="ea-contact-grid">
                <div class="ea-form-group">
                  <label class="ea-contact-label" for="ea-contact-name">Full Name *</label>
                  <input type="text" id="ea-contact-name" name="ea_name" class="ea-contact-input" placeholder="Your professional name" required>
                </div>
                <div class="ea-form-group">
                  <label class="ea-contact-label" for="ea-contact-email">Email Address</label>
                  <input type="email" id="ea-contact-email" name="ea_email" class="ea-contact-input" placeholder="name@company.com">
                </div>
              </div>

              <!-- OTP Verification Row (Slides down when valid email is entered) -->
              <div id="ea-contact-otp-row" class="ea-otp-send-row" style="display:none; background:#102B49; border-radius:10px; padding:15px; margin-bottom:20px; border:1px solid rgba(255,255,255,0.1);">
                <div style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
                  <div style="flex:1; min-width:180px;">
                    <label class="ea-contact-label" for="ea-contact-otp" style="margin-bottom:4px; color:#8FA3B7;">Verification Code *</label>
                    <input type="text" id="ea-contact-otp" name="ea_otp" class="ea-contact-input" placeholder="6-digit OTP code" style="padding:10px 14px;">
                  </div>
                  <div style="margin-top:18px;">
                    <button type="button" id="ea-contact-otp-btn" class="ea-otp-send-btn" style="background:#FFC107; color:#0B1F38; border:none; border-radius:8px; padding:11px 20px; font-size:13px; font-weight:800; cursor:pointer; transition:background 0.25s; height:43px;">Send Verification Code</button>
                  </div>
                </div>
                <div id="ea-contact-otp-status" class="ea-otp-msg" style="font-size:12px; margin-top:8px; font-weight:600; color:#FFFFFF;"></div>
              </div>

              <div class="ea-contact-grid">
                <div class="ea-form-group">
                  <label class="ea-contact-label" for="ea-contact-phone">Phone Number *</label>
                  <input type="tel" id="ea-contact-phone" name="ea_phone" class="ea-contact-input" placeholder="e.g. +971 50 123 4567">
                </div>
                <div class="ea-form-group">
                  <label class="ea-contact-label" for="ea-contact-product">Product or Service of Interest</label>
                  <input type="text" id="ea-contact-product" name="ea_product" class="ea-contact-input" placeholder="e.g. Vehicle Branding, Exhibition Stand">
                </div>
              </div>

              <div class="ea-form-group" style="margin-bottom:20px;">
                <label class="ea-contact-label" for="ea-contact-file">Attach Reference / Artwork <span style="text-transform:none; font-weight:400; color:#8FA3B7;">(Optional - JPG, PNG, PDF, AI, EPS, ZIP | Max 10MB)</span></label>
                <input type="file" id="ea-contact-file" name="ea_file" class="ea-contact-input" style="padding:10px; border-style:dashed; background:#102B49; color:#FFFFFF; cursor:pointer;">
              </div>

              <div class="ea-form-group" style="margin-bottom:20px;">
                <label class="ea-contact-label" for="ea-contact-message">Enquiry Message *</label>
                <textarea id="ea-contact-message" name="ea_message" class="ea-contact-textarea" rows="5" placeholder="Please describe your specific printing, sizing, structural, or deployment requirements..." required style="resize:none;"></textarea>
              </div>

              <!-- CAPTCHA Math Quiz -->
              <div class="ea-captcha-box" style="display:flex; align-items:center; gap:12px; margin-bottom:25px; background:#102B49; border-radius:10px; padding:12px 18px; border:1px solid rgba(255,255,255,0.1); width:fit-content;">
                <span class="ea-captcha-question" style="color:#FFFFFF; font-size:14px; font-weight:700;">Math Quiz: Loading...</span>
                <input type="number" id="ea-contact-captcha" name="ea_captcha" class="ea-contact-input" placeholder="Answer *" required style="width:90px; margin:0; padding:8px 12px; font-size:14px; text-align:center; background:#0B1F38; color:#FFFFFF; border:1px solid rgba(255,255,255,0.2);">
                <button type="button" class="ea-captcha-refresh-btn" style="background:none; border:none; color:#FFC107; cursor:pointer; font-size:22px; line-height:1; padding:0 6px;" title="Refresh Captcha">↻</button>
              </div>

              <div class="ea-form-group" style="text-align:center;">
                <button type="submit" class="ea-contact-submit-btn">Send Enquiry Request</button>
              </div>

              <div id="ea-contact-status" class="ea-form-status-msg" style="font-size:14px; margin-top:15px; font-weight:700; text-align:center;"></div>
            </form>
          </div>
          <p class="form-messege pt-10 pb-10 mt-10 mb-10"></p>
        </div>
        <div class="col-md-2 hidden-xs hidden-sm"></div>
      </div>
    </div>
  </div>
</section>

<!-- Secure Email OTP Modal -->
<div id="ea-email-otp-modal" style="display:none; position:fixed; inset:0; background:rgba(11,31,56,0.85); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
  <div style="background:#102B49; border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:30px; max-width:400px; width:90%; position:relative; box-shadow:0 20px 50px rgba(0,0,0,0.5); text-align:center;">
    <button onclick="eaCloseEmailOtpModal()" style="position:absolute; top:15px; right:15px; background:none; border:none; color:#B8C2CC; font-size:24px; cursor:pointer; line-height:1;">&times;</button>
    
    <!-- Step 1: Initial Prompt -->
    <div id="ea-otp-step-1">
      <div style="width:50px; height:50px; border-radius:50%; background:rgba(255,193,7,0.1); color:#FFC107; font-size:20px; line-height:50px; margin:0 auto 15px;">
        <i class="fa fa-envelope" aria-hidden="true"></i>
      </div>
      <h3 style="color:#FFFFFF; font-size:20px; font-weight:800; margin-bottom:10px;">Contact Us via Email</h3>
      <p style="color:#B8C2CC; font-size:14px; margin-bottom:20px; line-height:1.6;">Do you want to send an email to <strong>info@efficientadvt.com</strong>?</p>
      <div style="display:flex; gap:10px; justify-content:center;">
        <button onclick="eaCloseEmailOtpModal()" style="background:transparent; border:1px solid rgba(255,255,255,0.2); color:#FFFFFF; padding:10px 20px; border-radius:8px; font-weight:700; cursor:pointer; transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">Cancel</button>
        <button onclick="eaShowOtpStep2()" style="background:#FFC107; border:none; color:#0B1F38; padding:10px 20px; border-radius:8px; font-weight:800; cursor:pointer; transition:background 0.2s;" onmouseover="this.style.background='#FFFFFF'" onmouseout="this.style.background='#FFC107'">Yes, Continue</button>
      </div>
    </div>

    <!-- Step 2: Request User Email -->
    <div id="ea-otp-step-2" style="display:none;">
      <h3 style="color:#FFFFFF; font-size:18px; font-weight:800; margin-bottom:10px;">Verification Required</h3>
      <p style="color:#B8C2CC; font-size:13px; margin-bottom:15px; line-height:1.5;">To prevent spam, please verify your email address to receive a secure code.</p>
      <input type="email" id="ea-modal-user-email" placeholder="Your Email Address" style="width:100%; padding:12px; border-radius:8px; border:1px solid rgba(255,255,255,0.1); background:#0B1F38; color:#FFFFFF; margin-bottom:15px; outline:none; text-align:center;">
      <button id="ea-modal-send-btn" onclick="eaSendEmailModalOtp()" style="width:100%; background:#FFC107; border:none; color:#0B1F38; padding:12px; border-radius:8px; font-weight:800; cursor:pointer; margin-bottom:10px; transition:background 0.2s;" onmouseover="this.style.background='#FFFFFF'" onmouseout="this.style.background='#FFC107'">Send Verification Code</button>
      <div id="ea-modal-status-1" style="font-size:12px; color:#FFC107; margin-bottom:5px; font-weight:600; min-height:15px;"></div>
    </div>

    <!-- Step 3: Verify OTP -->
    <div id="ea-otp-step-3" style="display:none;">
      <h3 style="color:#FFFFFF; font-size:18px; font-weight:800; margin-bottom:10px;">Enter Verification Code</h3>
      <p style="color:#B8C2CC; font-size:13px; margin-bottom:15px; line-height:1.5;">We've sent a 6-digit code to your email.</p>
      <input type="text" id="ea-modal-otp-code" placeholder="------" maxlength="6" style="width:100%; padding:12px; border-radius:8px; border:1px solid rgba(255,255,255,0.1); background:#0B1F38; color:#FFFFFF; margin-bottom:15px; text-align:center; letter-spacing:10px; font-weight:800; font-size:18px; outline:none;">
      <button id="ea-modal-verify-btn" onclick="eaVerifyEmailModalOtp()" style="width:100%; background:#FFC107; border:none; color:#0B1F38; padding:12px; border-radius:8px; font-weight:800; cursor:pointer; margin-bottom:10px; transition:background 0.2s;" onmouseover="this.style.background='#FFFFFF'" onmouseout="this.style.background='#FFC107'">Verify & Open Email</button>
      <div id="ea-modal-status-2" style="font-size:12px; color:#FFC107; margin-bottom:5px; font-weight:600; min-height:15px;"></div>
    </div>
  </div>
</div>

<script>
function eaOpenEmailOtpModal() {
  document.getElementById('ea-email-otp-modal').style.display = 'flex';
  document.getElementById('ea-otp-step-1').style.display = 'block';
  document.getElementById('ea-otp-step-2').style.display = 'none';
  document.getElementById('ea-otp-step-3').style.display = 'none';
  document.getElementById('ea-modal-user-email').value = '';
  document.getElementById('ea-modal-otp-code').value = '';
  document.getElementById('ea-modal-status-1').innerText = '';
  document.getElementById('ea-modal-status-2').innerText = '';
}

function eaCloseEmailOtpModal() {
  document.getElementById('ea-email-otp-modal').style.display = 'none';
}

function eaShowOtpStep2() {
  document.getElementById('ea-otp-step-1').style.display = 'none';
  document.getElementById('ea-otp-step-2').style.display = 'block';
}

function eaSendEmailModalOtp() {
  var email = document.getElementById('ea-modal-user-email').value.trim();
  if(!email || email.indexOf('@') === -1 || email.indexOf('.') === -1) {
    document.getElementById('ea-modal-status-1').innerText = 'Please enter a valid email address.';
    return;
  }
  
  var btn = document.getElementById('ea-modal-send-btn');
  var status = document.getElementById('ea-modal-status-1');
  btn.disabled = true;
  btn.innerText = 'Sending...';
  btn.style.opacity = '0.7';
  status.innerText = '';
  
  var fd = new FormData();
  fd.append('action', 'ea_send_otp');
  // We use the existing nonce from the contact form
  var nonceField = document.querySelector('input[name="ea_nonce"]');
  if(nonceField) {
    fd.append('nonce', nonceField.value);
  }
  fd.append('email', email);
  
  fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
    method: 'POST',
    body: fd
  })
  .then(res => res.json())
  .then(data => {
    btn.disabled = false;
    btn.innerText = 'Send Verification Code';
    btn.style.opacity = '1';
    if(data.success) {
      document.getElementById('ea-otp-step-2').style.display = 'none';
      document.getElementById('ea-otp-step-3').style.display = 'block';
    } else {
      status.innerText = data.data.message || data.data || 'Failed to send OTP.';
    }
  })
  .catch(err => {
    btn.disabled = false;
    btn.innerText = 'Send Verification Code';
    btn.style.opacity = '1';
    status.innerText = 'Server error. Please try again.';
  });
}

function eaVerifyEmailModalOtp() {
  var email = document.getElementById('ea-modal-user-email').value.trim();
  var otp = document.getElementById('ea-modal-otp-code').value.trim();
  
  if(!otp || otp.length < 5) {
    document.getElementById('ea-modal-status-2').innerText = 'Please enter the valid OTP.';
    return;
  }
  
  var btn = document.getElementById('ea-modal-verify-btn');
  var status = document.getElementById('ea-modal-status-2');
  btn.disabled = true;
  btn.innerText = 'Verifying...';
  btn.style.opacity = '0.7';
  status.innerText = '';
  
  var fd = new FormData();
  fd.append('action', 'ea_verify_email_modal_otp');
  var nonceField = document.querySelector('input[name="ea_nonce"]');
  if(nonceField) {
    fd.append('nonce', nonceField.value);
  }
  fd.append('email', email);
  fd.append('otp', otp);
  
  fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
    method: 'POST',
    body: fd
  })
  .then(res => res.json())
  .then(data => {
    btn.disabled = false;
    btn.innerText = 'Verify & Open Email';
    btn.style.opacity = '1';
    if(data.success) {
      eaCloseEmailOtpModal();
      window.location.href = 'mailto:<?php if(of_get_option('email_address')) { echo esc_js(sanitize_email(of_get_option('email_address')));} else { echo "info@efficientadvt.com"; } ?>?cc=efficientadvt1@gmail.com&bcc=efficientadvertisingllc@gmail.com';
    } else {
      status.innerText = data.data.message || data.data || 'Invalid OTP.';
    }
  })
  .catch(err => {
    btn.disabled = false;
    btn.innerText = 'Verify & Open Email';
    btn.style.opacity = '1';
    status.innerText = 'Server error. Please try again.';
  });
}
</script>

<?php get_footer(); ?>