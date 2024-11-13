<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$order_id = (empty($order_id)) ? $this->order_id : $order_id;

$order = (!empty($order)) ? $order : wc_get_order($order_id);

$order_number = $order->get_id();
$order_date = $order->get_date_created()->date('F j, Y');
$billing_postcode = $order->get_billing_postcode();
$shipping_postcode = $order->get_shipping_postcode();

$delivery_date = is_wc_hpos_activated() ? $order->get_meta('_delivery_date') : get_post_meta($order->get_id(), '_delivery_date', true);

$order_total = $order->get_total();
$goods_total = $order->get_subtotal_to_display();

$product_details = array();
foreach ($order->get_items() as $item) {
	$product = $item->get_product();
	if ($product) {
		$product_name = $product->get_name();
		$product_customer_wish = $item->get_meta('custom_note');
		$product_details[] = array(
			'name' => $product_name,
			'customer_note' => $product_customer_wish,
		);
	}
}

$accept_url = home_url("/vendor-order-accept/?acc_order_id=$order_id&acc_invite_id=$invite_id&acc_invite_guid=$calculated_invite_guid&acc_vendor=$vendor_id&acc_vendor_guid=$calculated_vendor_guid&acc_action_guid=zzkrne1FD_fe&acc_t=$calculated_t_var");
$decline_url = home_url("/vendor-order-accept/?acc_order_id=$order_id&acc_invite_id=$invite_id&acc_invite_guid=$calculated_invite_guid&acc_vendor=$vendor_id&acc_vendor_guid=$calculated_vendor_guid&acc_action_guid=mfefldm1_ewq&acc_t=$calculated_t_var");

echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
echo esc_html( wp_strip_all_tags( $email_heading ) );
echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo "Hej $vendor_name :)\n\n";
echo "Vi har modtaget en ordre i dit område, som du hermed inviteres til at overtage. Ordren kan være sendt til flere - og den første, der accepterer ordren vil modtage ordrebekræftelsesmail med alle info.\n";
echo "Nedenfor finder du et kort udsnit af informationer, og du kan acceptere/afvise ved at klikke på knapperne nedenfor.\n";

echo "\nVil du have ordren? Klik her: $accept_url";
echo "\nVil du IKKE have ordren? Klik her: $decline_url";

echo "\n\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=";
echo 'Ordreinformationer';
echo "\n\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";

echo "Postnummer: $shipping_postcode\n";
echo "Leveringsdato: $delivery_date\n";
echo "Total pris på varen(e): $goods_total\n";
echo "Levering: 39,- kr.\n";

echo "\n\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=";
echo 'Varer på bestillingen';
echo "\n\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";

foreach ($product_details as $product) {
	echo "\n" . esc_html($product['name']) . "\n";
	echo "Ønske til gavens indhold: " . $product['customer_note'] . "\n";
}

echo "\n----------------------------------------\n\n";
