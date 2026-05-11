<?php
/**
 * One-shot CF7 form updater – run once via PHP CLI, then auto-deletes.
 */
$_SERVER['HTTP_HOST']   = 'efficientadvt.local';
$_SERVER['REQUEST_URI'] = '/';
require_once __DIR__ . '/wp-load.php';

$post_id = 39;

// ── New form HTML ─────────────────────────────────────────────────────────────
$form_html = '<div class="row">

<div class="col-sm-6 mb-10">
[text* ea-name placeholder "Your Name *"]
</div>

<div class="col-sm-6 mb-10">
[email* ea-email id:ea-email-field placeholder "Email Address *"]
</div>

<div class="col-sm-12 mb-10 ea-otp-send-row">
<button type="button" id="ea-send-otp-btn" class="ea-otp-send-btn">Send Verification Code</button>
<span id="ea-otp-status" class="ea-otp-msg"></span>
</div>

<div class="col-sm-6 mb-10">
[text* ea-otp placeholder "Verification Code *"]
</div>

<div class="col-sm-6 mb-10">
[text* ea-country placeholder "Country *"]
</div>

<div class="col-sm-12 mb-10">
[textarea* ea-message placeholder "How can we help you? *"]
</div>

<div class="col-sm-12 mb-10 ea-captcha-row">
[quiz* ea-captcha "4 + 3 = ?|7" "8 - 5 = ?|3" "3 x 2 = ?|6" "9 - 6 = ?|3" "5 + 5 = ?|10"]
</div>

<div class="col-sm-12 text-center">
[submit id:ea-submit "Send Message"]
</div>

</div>';

update_post_meta( $post_id, '_form', $form_html );

// ── New mail template ─────────────────────────────────────────────────────────
$mail = array(
    'active'             => true,
    'subject'            => '[Efficient Advertising] New Enquiry from [ea-name]',
    'sender'             => 'Efficient Advertising <info@efficientadvt.com>',
    'recipient'          => 'info@efficientadvt.com',
    'body'               => "Name    : [ea-name]\nEmail   : [ea-email]\nCountry : [ea-country]\n\nMessage :\n[ea-message]",
    'additional_headers' => "Reply-To: [ea-email]\nCc: efficientadvt1@gmail.com, efficientadvertisingllc@gmail.com",
    'attachments'        => '',
    'use_html'           => false,
    'exclude_blank'      => false,
);

update_post_meta( $post_id, '_mail', $mail );

// ── Clear CF7's cache so changes take effect immediately ──────────────────────
if ( function_exists('wpcf7_get_contact_form') ) {
    $cf = wpcf7_get_contact_form( $post_id );
    if ( $cf ) {
        wp_cache_delete( $post_id, 'posts' );
        wp_cache_delete( $post_id, 'post_meta' );
        clean_post_cache( $post_id );
    }
}

echo "Form updated successfully.\n";

// Self-delete
@unlink( __FILE__ );
echo "Update file deleted.\n";
