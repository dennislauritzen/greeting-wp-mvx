<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$order_id = (empty($order_id)) ? $order_id = $this->order_id : $order_id;

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
do_action( 'woocommerce_email_header', $email_heading, $email );
?>

<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="width: 100%; text-align: center; border-collapse: collapse;">
	<tr style="text-align: center;">
		<td align="center" style="text-align: center; padding: 0 15px;">
			<table width="770" border="0"cellpadding="0" cellspacing="0" style="text-align: left; margin: 0 auto; width: 770px; max-width: 770px; border-collapse: collapse;">
				<tr>
					<td colspan="2" class="summary-heading" style="padding-bottom: 20px;">
						<table width="100%" border="0"cellpadding="0" cellspacing="0" style="width: 100%; max-width: 800px; border-collapse: collapse;">
							<tr>
								<td width="100%" style="width: 75%;">
									<h1 style="margin-top: 25px;"><?php echo $email_heading; ?></h1>
									<small>
										<img width="15" height="15" src="https://s.w.org/images/core/emoji/14.0.0/72x72/2764.png" style="display: inline-block; width: 15px !important; max-width: 20px; height: 15px; max-height: 20px; font-size: 12px;">
										&nbsp; <?php _e( 'You have been invited to take over an order on our platform!', 'greeting3' ); ?>
									</small>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr style="text-align: center;">
		<td align="center" style="text-align: center; padding: 0 15px;">
			<table width="770" border="0"cellpadding="0" cellspacing="0" style="text-align: left; margin: 0 auto; width: 770px; max-width: 770px; border-collapse: collapse; ">
				<tr>
					<td colspan="2" class="summary-heading" style="padding-bottom: 20px;">
						<p>
							Hej <?php echo $vendor_name; ?> :)
						</p>
						<p>Vi har modtaget en ordre i dit område, som du hermed inviteres til at overtage. Ordren kan være sendt til flere - og den første, der accepterer ordren vil modtage ordrebekræftelsesmail med alle info.<br>
						Nedenfor finder du et kort udsnit af informationer, og du kan acceptere/afvise ved at klikke på knapperne nedenfor.</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse; background-color: #f4f4f4; padding: 20px; border-radius: 10px;">
							<tr>
								<!-- Accept Button -->
								<td width="50%" style="text-align: center; padding: 10px; border-radius: 10px; border: 2px solid #28a745;  cursor: pointer;">
									<a href="<?php echo $accept_url; ?>"
									   style="display: inline-block; padding: 20px; background-color: #fff; color: #28a745; text-decoration: none; font-size: 16px; font-weight: bold; text-align: center; min-width: 300px; width: 100%; cursor: pointer;">

										<!-- Icon (on first line) -->
										<div style="text-align: center; margin-bottom: 10px;">
											<span style="color: green; font-size: 40px; font-weight: bold;">✔️</span>
										</div>

										<!-- Text (on second line, with wrap if necessary) -->
										<div style="font-size: 14px; font-weight: normal; color: #28a745; text-align: center; line-height: 1.4;">
											Acceptér ordren (Ja tak, den kan jeg levere)
										</div>
									</a>
								</td>

								<!-- Decline Button -->
								<td width="50%" style="text-align: center; padding: 10px; border-radius: 10px; border: 2px solid #dc3545;  cursor: pointer;">
									<a href="<?php echo $decline_url; ?>"
									   style="display: inline-block; padding: 20px; background-color: #fff; color: #dc3545; text-decoration: none; font-size: 16px; font-weight: bold; text-align: center; min-width: 300px;  width: 100%; cursor: pointer;">

										<!-- Icon (on first line) -->
										<div style="text-align: center; margin-bottom: 10px;">
											<span style="color: red; font-size: 40px; font-weight: bold;">❌</span>

										</div>

										<!-- Text (on second line, with wrap if necessary) -->
										<div style="font-size: 14px; font-weight: normal; color: #dc3545; text-align: center; line-height: 1.4;">
											Afslå ordren (Nej tak, den vil jeg ikke have)
										</div>
									</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="summary-heading" style="padding-bottom: 20px;">
						<h3>Ordreinformationer</h3>
						Postnummer: <?php echo $shipping_postcode; ?><br><br>

						Leveringsdato: <?php echo $delivery_date; ?><br><br>

						Total pris på varen(e): <?php echo $goods_total; ?><br>
						Levering: 39,- kr.<br>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="summary-heading" style="padding-bottom: 20px;">
						<h3>Produkter på bestillingen</h3>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="770" border="0"cellpadding="0" cellspacing="0" style="text-align: left; margin: 0 auto; width: 770px; max-width: 770px; border-collapse: collapse; ">
						<?php
						// Loop through the product details and display the names and images
						foreach ($product_details as $product) {
						?>
							<tr>
								<td width="25%" class="summary-heading" style="padding-bottom: 20px;">
									<img src="<?php echo esc_url($product['image']); ?>" alt="<?php echo esc_attr($product['name']); ?>" style="width: 100px; height: auto;">
								</td>
								<td width="75%">
									<b><?php echo esc_html($product['name']); ?></b>

									<?php if(!empty($product['customer_note'])){ ?>
									<br>
									<span><u><?php echo __('Ønske til gavens indhold','greeting3'); ?>:</u></b> <?php echo $product['customer_note']; ?></span>
									<?php } ?>
								</td>
							</tr>
						<?php
						}
						?>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<p>&nbsp;</p>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
					</td>
				</tr>

			</table>
		</td>
	</tr>
</table>


<table width="100%" class="social" style="width: 100%;">
	<tr>
		<td align="center" style="text-align: center; padding: 0 15px;">
			<table width="770" style="width: 770px; max-width: 770px;">
				<tr>
					<td valign="top" width="50%" class="left-col" style="text-align: left; width: 50%; padding: 40px 0;">
						<h4>Følg os</h4>
						<p style="margin: 0 20px 0 0;">
							Kunne du tænke dig at følge med i, hvad vi går og laver - og blive inspireret til din næste gavehilsen?
							Så følg med på vores profiler på Facebook eller Instagram.
						</p>
						<p>
							<a href="https://www.facebook.com/greeting.dk" class="text-dark">
								<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#446a6b" class="bi bi-facebook" viewBox="0 0 18 18">
									<path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
								</svg>
								facebook.com/greeting.dk
							</a>
						</p>
						<p>
							<a href="https://www.instagram.com/greeting.dk/" class="text-dark">
								<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="#446a6b" class="bi bi-instagram" viewBox="0 0 16 16">
									<path color="#446a6b" d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
								</svg>
								@greeting.dk
							</a>
						</p>
					</td>
					<td valign="top" width="50%" class="right-col" style="text-align: left; width: 50%; padding: 40px 0;">
						<h4>Brug for hjælp?</h4>
						<p>
							Er du i tvivl om noget vedrørende din ordre, eller har du rettelser? Så
							tag endelig fat i os :)
						</p>
						<p>
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#1b4949" class="pr-2 bi bi-envelope" viewBox="0 0 16 16">
								<path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
							</svg>
							<a href="mailto:kontakt@greeting.dk" class="ms-2 text-dark">kontakt@greeting.dk</a>
						</p>
						<p>
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#1b4949" class="pr-2 bi bi-telephone" viewBox="0 0 16 16">
								<path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
							</svg>
							<a href="tel:+4571901834" class="ms-2 text-dark">(+45) 71 90 18 34</a>
						</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<!-- THE CONTENT END -->

<?php do_action('mvx_email_footer'); ?>

<?php
/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
#do_action( 'woocommerce_email_footer', $email );