<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
 *  Template Name: Payement
 * 
 */
get_header();

 ?>
<?php
global $wpdb;
$table_name = 'paymentdetails';
if ( isset( $_POST['newsubmit'] ) ) {

    // CSRF nonce verification (C-02)
    if ( ! isset( $_POST['payment_nonce'] ) || ! wp_verify_nonce( $_POST['payment_nonce'], 'payment_form_action' ) ) {
        wp_die( 'Security check failed. Please go back and try again.' );
    }

    // Sanitize all inputs (C-01)
    $Name         = sanitize_text_field( $_POST['Name'] );
    $Company      = sanitize_text_field( $_POST['Company'] );
    $Email        = sanitize_email( $_POST['Email'] );
    $Phone        = sanitize_text_field( $_POST['Phone'] );
    $City         = sanitize_text_field( $_POST['City'] );
    $Country      = sanitize_text_field( $_POST['Country'] );
    $ProductName  = sanitize_text_field( $_POST['ProductName'] );
    $quantity     = absint( $_POST['quantity'] );
    $size         = sanitize_text_field( $_POST['size'] );
    $estimate     = sanitize_text_field( $_POST['estimate'] );
    $date1        = sanitize_text_field( $_POST['date1'] );
    $paymenttype  = sanitize_text_field( $_POST['paymenttype'] );
    $date2        = sanitize_text_field( $_POST['date2'] );
    $deliverytime = sanitize_text_field( $_POST['deliverytime'] );
    $currency     = sanitize_text_field( $_POST['currency'] );
    $amount       = sanitize_text_field( $_POST['amount'] );
    $message      = sanitize_textarea_field( $_POST['message'] );

    // Use $wpdb->insert() with prepared data — no SQL injection (C-01)
    $wpdb->insert(
        $table_name,
        array(
            'name'         => $Name,
            'companyname'  => $Company,
            'email'        => $Email,
            'phone'        => $Phone,
            'city'         => $City,
            'country'      => $Country,
            'productname'  => $ProductName,
            'quantity'     => $quantity,
            'size'         => $size,
            'estimate'     => $estimate,
            'date1'        => $date1,
            'paymenttype'  => $paymenttype,
            'date2'        => $date2,
            'deliverytime' => $deliverytime,
            'currency'     => $currency,
            'amount'       => $amount,
            'message'      => $message,
        ),
        array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' )
    );

    // Use dynamic site URL instead of hardcoded demo domain (H-03)
    $payment_return_url = home_url( '/payment/' );
    echo '<form action="https://www.paypal.com/us/cgi-bin/webscr" name="frm1" id="frm1" method="POST">
   <input type="hidden" name="amount" value="' . esc_attr( $amount ) . '">
   <input type="hidden" name="return" value="' . esc_url( $payment_return_url ) . '">
   <input type="hidden" name="cancel_return" value="' . esc_url( $payment_return_url ) . '">
   <input type="hidden" name="cmd" value="_ext-enter" />
   <input type="hidden" name="redirect_cmd" value="_xclick" />
   <input type="hidden" name="business" value="efficientadvt1@gmail.com" />
   <input type="hidden" name="item_name" value="Payment to efficient advert" />
   <input type="hidden" name="currency_code" value="USD" />
   <input type="hidden" name="rm" value="2" />
</form>
<script>document.frm1.submit();</script>';
}
?>
<section class="contdetail">
<!-- 	    <div class="head-title">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	
						<?php the_content(); ?>		
						<?php edit_post_link(); ?>			
						<?php endwhile; endif; ?>
					</div>
				</div>
			</div>
		</div> -->
       <!---end--->	
	
	<div class="container paymentoption">
	<form action="" method="post" class="wpcf7-form init">
	<?php wp_nonce_field( 'payment_form_action', 'payment_nonce' ); ?>
<div class="row">
<div class="col-lg-6 col-xs-12">
<div class="md-form mb-4">
<input required type="text" name="Name" value="" size="40" class="form-control required" aria-required="true" aria-invalid="false" placeholder="Your Name *">
</div>
</div>
<div class="col-lg-6 col-xs-12">
<div class="md-form mb-4">
<input required type="text" name="Company" value="" size="40" class="form-control required" aria-required="true" aria-invalid="false" placeholder="Company Name *">
</div>
</div>
<div class="col-lg-6 col-xs-12">
<div class="md-form mb-4">
<input required type="email" name="Email" value="" size="40" class="form-control required" aria-required="true" aria-invalid="false" placeholder="Email *">
</div>
</div>
<div class="col-lg-6 col-xs-12">
<div class="md-form mb-4">
<input required type="text" name="Phone" value="" size="40" class="form-control required" aria-required="true" aria-invalid="false" placeholder="Phone *">
</div>
</div>
<div class="col-lg-6 col-xs-12">
<div class="md-form mb-4">
<input required type="text" name="City" value="" size="40" class="form-control required" aria-required="true" aria-invalid="false" placeholder="City *">
</div>
</div>
<div class="col-lg-6 col-xs-12">
<div class="md-form mb-4">
<input required type="text" name="Country" value="" size="40" class="form-control required" aria-required="true" aria-invalid="false" placeholder="Country *">
</div>
</div>
<div class="col-lg-6 col-xs-12">
<div class="md-form mb-4">
<input required type="text" name="ProductName" value="" size="40" class="form-control required" aria-required="true" aria-invalid="false" placeholder="Product Name *">
</div>
</div>
<div class="col-lg-6 col-xs-12">
<div class="md-form mb-4">
<input required type="number" name="quantity" value="" class="form-control" min="1" max="1000" aria-required="true" aria-invalid="false" placeholder="Quantity *">
</div>
</div>
<div class="col-lg-6 col-xs-12">
<div class="md-form mb-4">
<input required type="text" name="size" value="" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Size *">
</div>
</div>
<div class="col-lg-6 col-xs-12">
<div class="md-form mb-4">
<input required type="text" name="estimate" value="" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Estimate/Invoice #">
</div>
</div>
<div class="col-lg-6 col-xs-12">
<div class="md-form mb-4">
<input required type="date" id="datepicker" name="date1" value="" size="40" class="form-control date" aria-required="true" aria-invalid="false" placeholder="Estimate/Invoice Date">
</div>
</div>
<div class="col-lg-6 col-xs-12">
<div class="md-form mb-4">
<input required type="text" name="paymenttype" value="" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Payment type: Advance/Final/Full">
</div>
</div>
	<div class="clearboth"></div>
<div class="col-lg-6 col-xs-12">
<div class="md-form mb-4">
<input required type="date" name="date2" id="datepicker2" value="" size="40" class="form-control date" aria-required="true" aria-invalid="false" placeholder="Date of delivery">
</div>
</div>

<div class="col-lg-6 col-xs-12">
<div class="md-form mb-4">
<input required type="text" name="deliverytime" value="" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Time of delivery">
</div>
</div>
	<div class="clearboth"></div>	
<div class="col-lg-6 col-xs-12">
<div class="md-form mb-4">
<select required name="currency" class="form-control" aria-required="true" aria-invalid="false">
    <option value="AED د.إ">AED د.إ</option></select>
</div>
</div>
<div class="col-lg-6 col-xs-12">
<div class="md-form mb-4">
<input required type="text" name="amount" value="" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Amount">
</div>
</div>
<div class="col-lg-12 col-xs-12">
<div class="md-form mb-4">
<textarea required name="message" cols="40" rows="10" class="form-control required" aria-required="true" aria-invalid="false" placeholder="Message"></textarea>
</div>
</div>
</div>
<input type="submit" name="newsubmit" class="wpcf7-submit btn btn-default submitcls" value="PayNow">
		<!--<button data-toggle="modal" data-target="#myModalpay" value="" class="wpcf7-submit btn btn-default submitcls">PayNow</button>-->
</form>
	</div>
</section>

<div id="myModalpay" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
