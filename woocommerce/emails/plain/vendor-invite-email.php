<?php
/**
 * Vendor invite mail (plain text)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/plain/vendor-invite-email.php
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails\Plain
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// The order object
$order = (!empty($order)) ? $order : wc_get_order($order_id);

// Access various order details
$order_number = $order->get_order_number();
$order_date = $order->get_date_created()->date('F j, Y');

// Customer name
$customer_name = $order->get_billing_first_name();

// Order details
$billing_postcode = $order->get_billing_postcode();
$shipping_postcode = $order->get_shipping_postcode();
$customer_name = $order->get_billing_first_name();

// Get the delivery date, HPOS compatible
if(is_wc_hpos_activated()){
	$delivery_date = $order->get_meta('_delivery_date');
} else {
	$delivery_date = get_post_meta($order->get_id(), '_delivery_date', true);
}

// Get the order totals
$order_total = $order->get_total();
$goods_total = $order->get_subtotal_to_display();

// ===========
// Get the product names in a comma separated list
// Initialize arrays to store product names and images
$product_details = array();

// Get the order items
$order_items = $order->get_items();

foreach ($order_items as $item_id => $item) {
	// Get the product object from the order item
	$product = $item->get_product();

	if ($product) {
		// Get the product name
		$product_name = $product->get_name();

		// Get the product image (thumbnail)
		$product_image_id = $product->get_image_id();
		$product_image_url = wp_get_attachment_url($product_image_id);

		// Get the customer wish from the order item metadata
		$product_customer_wish = $item->get_meta('custom_note');

		// If the product has an image, use it, otherwise use a placeholder
		if (!$product_image_url) {
			// Use a default placeholder if no image is set
			$product_image_url = wc_placeholder_img_src();
		}

		// Add product details (name and image) to the array
		$product_details[] = array(
			'name' => $product_name,
			'image' => $product_image_url,
			'customer_note' => $product_customer_wish,
		);
	}
}
// ==============================


// Accessing the invite details passed in placeholders
$invite_id = isset($invite_id) ? $invite_id : '';
$invite_guid = isset($invite_guid) ? $invite_guid : '';

$calculated_invite_guid = md5('greeting____invite!Lfæaaæel41_QR!' . $invite_id);
$calculated_t_var = md5('gree_inv_grrg1_;:,f,e1' . $order->get_id() . $invite_id . $vendor_id);
$calculated_vendor_guid = md5('vendor_id_id_id_fkrenfguu12_GUID_' . $vendor_id);

// Build the URL with parameters
$accept_url = home_url("/vendor-order-accept/?acc_order_id=".$order_id."&acc_invite_id=".$invite_id."&acc_invite_guid=".$calculated_invite_guid."&acc_vendor=".$vendor_id."&acc_vendor_guid=".$calculated_vendor_guid."&acc_action_guid=zzkrne1FD_fe&acc_t=".$calculated_t_var);
$decline_url = home_url("/vendor-order-accept/?acc_order_id=".$order_id."&acc_invite_id=".$invite_id."&acc_invite_guid=".$calculated_invite_guid."&acc_vendor=".$vendor_id."&acc_vendor_guid=".$calculated_vendor_guid."&acc_action_guid=mfefldm1_ewq&acc_t=".$calculated_t_var);
# /vendor-order-accept/?acc_order_id=$order_id&acc_invite_id=$invite_id&acc_invite_guid=$calculated_invite_guid&acc_vendor=$vendor_id&acc_vendor_guid=$calculated_vendor_guid&acc_action_guid={action}&acc_t=$calculated_t_var


/*
 * @hooked WC_Emails::email_header() Output the email header
 */
#do_action( 'woocommerce_email_header', $email_heading, $email );

echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
echo esc_html( wp_strip_all_tags( $email_heading ) );
echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

/* translators: %s: Customer billing full name */


echo "Hej " . $vendor_name . " :)\n\n";
/**
 * Show user-defined additional content - this is set in each email's settings.
 */
#if ( $additional_content ) {
#	echo esc_html( wp_strip_all_tags( wptexturize( $additional_content ) ) );
#	echo "\n\n----------------------------------------\n\n";
#}

echo "Vi har modtaget en ordre i dit område, som du hermed inviteres til at overtage. Ordren kan være sendt til flere - og den første, der accepterer ordren vil modtage ordrebekræftelsesmail med alle info.\n";
echo "Nedenfor finder du et kort udsnit af informationer, og du kan acceptere/afvise ved at klikke på knapperne nedenfor";

echo "\n\nVil du have ordren? Klik her: ".$accept_url;


echo "\n\nVil du IKKE have ordren? Klik her: ".$decline_url;


echo "\n\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=";
echo 'Ordreinformationer';
echo "\n\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=";

echo "\nPostnummer: " . $shipping_postcode . "\n";
echo "\nLeveringsdato: " . $delivery_date . "\n";

echo "\nTotal pris på varen(e): " . $goods_total . "\n";
echo "\nLevering: 39,- kr.\n";


echo "\n\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=";
echo 'Varer på bestillingen';
echo "\n\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=";
// Loop through the product details and display the names and images
foreach ($product_details as $product) {

	echo "\n" . esc_html($product['name']) . "\n";

	echo "\n Ønske til gavens indhold: " .$product['customer_note'];
}





echo "\n----------------------------------------\n\n";


