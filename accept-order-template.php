<?php
## GET THE HEADER
include('header.php');
include('header-green.php');





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
if(is_wc_hpos_activated('frontend')){
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
?>


<div class="container">
	<div class="row">
		<div class="col-12">
			<h2 class="mt-3 pt-4"><?php echo $heading; ?></h2>
			<p><?php echo $text; ?></p>

			<?php
			if($order_inv_result == 1){
				// If the order result is positive show some of the order information

				// @todo insert the order information from the e-mail with styling (and responsive).
			?>
				<h4 class="pt-4">Ordreinformationer</h4>
				Postnummer: <?php echo $shipping_postcode; ?><br><br>

				Leveringsdato: <?php echo $delivery_date; ?><br><br>

				Total pris på varen(e): <?php echo $goods_total; ?><br>
				Levering: 39,- kr.<br>
			<?php
			}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-12 pt-5 mt-3">
			<h4 style="font-family: 'Inter';">Produkter på bestillingen</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<?php
			// Loop through the product details and display the names and images
			foreach ($product_details as $product) {
				?>
				<div class="row">
					<div class="col-2 col-xs-4 col-sm-4 col-md-2 col-lg-2">
						<img src="<?php echo esc_url($product['image']); ?>"
							 alt="<?php echo esc_attr($product['name']); ?>"
							 class="img-fluid"
							 style="max-width: 100%; height: auto;">
					</div>
					<div class="col-10 col-xs-8 col-sm-8 col-md-10 col-lg-10">
						<b><?php echo esc_html($product['name']); ?></b>

						<?php if(!empty($product['customer_note'])) { ?>
							<br>
							<span><u><?php echo __('Ønske til gavens indhold','greeting3'); ?>:</u> <?php echo $product['customer_note']; ?></span>
						<?php } ?>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>



<?php
## GET THE FOOTER
include('footer.php');
?>