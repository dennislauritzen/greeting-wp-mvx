<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails-old/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php

/**
 * Get variables for use in the template
 */

global $WCMp;

$order_id = $order->get_id();
$items = $order->get_items();

$vendor_id;
foreach($items as $item){
	$prod_obj = get_post( $item->get_product_id() );
	$vendor_id = $prod_obj->post_author;
	if(!empty($vendor_id)){
		break;
	}
}

$vendor = get_wcmp_vendor(absint($vendor_id));
$shop_name = (is_object($vendor) ? ucfirst(esc_html($vendor->user_data->data->display_name)) : '');

// Delivery type
$del_type = '';
$del_value = '';
if(!empty(get_field('delivery_type', 'user_'.$vendor_id))){
  $delivery_type = get_field('delivery_type', 'user_'.$vendor_id)[0];

  if(empty($delivery_type['label'])){
    $del_value = $delivery_type;
    $del_type = $delivery_type;
  } else {
    $del_value = $delivery_type['value'];
    $del_type = $delivery_type['label'];
  }
}
?>

<?php /* translators: %s: Customer first name */ ?>
<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>

<?php
if($del_value == '1'){
	// Personlig levering
?>
<p>Vi har nu leveret din gave til <?php print $order->get_shipping_first_name(); ?>.
<br>Vi er sikre på, at din hilsen har gjort en forskel!</p>

<p>Vi glæder os til at overraske en heldig modtager næste gang, du skal sende en gavehilsen til en der fortjener det.</p>
<?php
} else {
	// Afsendelsesordrer
?>
<p>Din gavebestilling er sendt til <?php print $order->get_shipping_first_name(); ?>, og vi forventer derfor at <?php print $order->get_shipping_first_name(); ?> modtager
gaven meget snart
- eller måske endda allerede har modtaget den.</p>
<p>Derfor vil vi endnu engang sige tusind tak for din bestilling.</p>

<?php
}
?>

<p>De bedste hilsner<br>
<?php print $shop_name; ?> & Greeting.dk</p>

<p><img src="https://www.greeting.dk/wp-content/uploads/2022/06/greeting-logo-200x48-green.png" height="25"></p>


<b>★★★★★ Vil du hjælpe os? :)</b>
<p style="font-size:14px;">
	Kunne du tænke dig at hjælpe os ved at anmelde <a href="https://dk.trustpilot.com/review/greeting.dk">din oplevelse med Greeting.dk på TrustPilot</a>?
</p>

<p>Og hvis du har lyst, må du endelig følge med på vores <a href="https://www.instagram.com/greeting.dk/">Instagram</a>
og <a href="https://www.facebook.com/greeting.dk">Facebook</a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<hr>
<p>&nbsp;</p>
<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
//do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
