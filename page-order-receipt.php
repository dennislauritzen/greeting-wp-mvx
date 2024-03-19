<?php
/**
 * Template Name: Order Receipt (only)
 * Description: Page template.
 *
 */

if(empty($_GET['o']) || empty($_GET['key'])){
	return;
}

$order_id 		= (isset($_GET['o']) ? $_GET['o'] : 0);
$order_old_id 	= (isset($_GET['order_id']) ? $_GET['order_id'] : 0);
$order_key 		= (isset($_GET['key']) ? $_GET['key'] : '');

$order_id_data = wc_get_order_id_by_order_key( $order_key );

$order = wc_get_order( $order_id );
$vendor_id = 0;

// If someone changed something in the URL part
if($order_id != $order_id_data){
	return;
}

#do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );
#do_action( 'woocommerce_thankyou', $order->get_id() );

get_header('checkout');

//the_post();
?>
<script>
	dataLayer.push({
		'ecommerce': {
		'currencyCode': '<?php echo $order->get_order_currency(); ?>',
		'purchase': {
			'actionField':{
			'id': '<?php echo $order->get_order_number(); ?>',
			'affiliation': 'WooCommerce',
			'revenue': <?php echo number_format($order->get_subtotal(), 2, ".", ""); ?>,
			'tax': <?php echo number_format($order->get_total_tax(), 2, ".", ""); ?>,
			'shipping': <?php echo number_format($order->calculate_shipping(), 2, ".", ""); ?>,
			<?php if($order->get_used_coupons()): ?>
				'coupon': '<?php echo implode("-", $order->get_used_coupons()); ?>'
			<?php endif; ?>
			},
			'products': [
				<?php
				foreach($order->get_items() as $key => $item):
					$product = $order->get_product_from_item( $item );
					$variant_name = ($item['variation_id']) ? wc_get_product($item['variation_id']) : '';
				?>
					{
					'name': '<?php echo $item['name']; ?>',
					'id': '<?php echo $item['product_id']; ?>',
					'price': '<?php echo number_format($order->get_line_subtotal($item), 2, ".", ""); ?>',
					'brand': '',
					'category': '<?php echo strip_tags($product->get_categories(', ', '', '')); ?>',
					'variant': '<?php echo ($variant_name) ? implode("-", $variant_name->get_variation_attributes()) : ''; ?>',
					'quantity': <?php echo $item['qty']; ?>
					},
				<?php endforeach; ?>
			]
		}
	},
	'user_details': {
		'phone': '<?php echo ($order->get_billing_phone()) ? $order->get_billing_phone() : ''; ?>',
		'mail': '<?php echo ($order->get_billing_email()) ? $order->get_billing_email() : ''; ?>',
		'full_name': '<?php echo $order->get_formatted_billing_full_name(); ?>',
		'address': '<?php echo ($order->get_billing_address_1()) ? $order->get_billing_address_1() : ''; ?>',
		'city': '<?php echo ($order->get_billing_city()) ? $order->get_billing_city() : ''; ?>',
		'country': '<?php echo ($order->get_billing_country()) ? $order->get_billing_country() : ''; ?>',
		'postcode': '<?php echo ($order->get_billing_postcode()) ? $order->get_billing_postcode() : ''; ?>',
		'delivery_phone': '<?php echo (get_post_meta($order->get_id(), '_receiver_phone', true)) ? get_post_meta($order->get_id(), '_receiver_phone', true) : ''; ?>'
	}
	});
</script>

<section id="receipt">
    <div class="container">
        <div class="row">
            <div class="offset-lg-1 offset-xl-2 col-md-12 col-lg-10 col-xl-8">
                <div class="row pb-4">
                    <div class="col-12">
                        <h1 class="mt-5">Din bestilling af gavehilsen er modtaget</h1>
                        <small>❤️ af hjertet tak fra os - og din modtager</small>
                    </div><!-- /.col -->
                </div>
                <div class="row border mb-3">
                    <div class="col-6 pt-2">
                        <p>
                            <strong class="text-uppercase">Bestillingsdato</strong>
                            <br>
                            <?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?><!--(Status: <?php echo $order->get_status(); ?>)-->
                        </p>
                        <p>
                            <strong class="text-uppercase">Levering</strong>
                            <br>
                            <?php
                            $delivery_date = get_post_meta($order->get_id(), '_delivery_date', true);
                            $wc_date = new WC_Datetime($delivery_date);
                            $delivery_date2 = wc_format_datetime( $wc_date );

                            if(!empty($delivery_date)){
                                echo esc_html( $delivery_date2 );
                            } else {
                                echo 'Hurtigst muligt';
                            }
                            ?>
                            <br>til <?php echo $order->get_shipping_first_name().' '.$order->get_shipping_last_name(); ?>
                            <br>
                            <br>

                            <?php $leave_gift_at_address = (get_post_meta( $order->get_id(), '_leave_gift_address', true ) == "1" ? 'Ja' : 'Nej'); ?>
                            <?php _e('Må stilles på adressen:', 'woocommerce'); ?> <?php echo $leave_gift_at_address; ?>
                            <br>
                            <?php $leave_gift_at_neighbour = (get_post_meta( $order->get_id(), '_leave_gift_neighbour', true ) == "1" ? 'Ja' : 'Nej'); ?>
                            <?php _e('Må gaven afleveres hos naboen:', 'woocommerce'); ?> <?php echo $leave_gift_at_neighbour; ?>

                            <br><br>

                            <?php $delivery_instructions = get_post_meta( $order->get_id(), '_delivery_instructions', true ); ?>
                            <?php if(!empty($delivery_instructions)){ ?>
                            <p class="text-start">
                                <strong><?php _e('Leveringsinstruktioner', 'woocommerce'); ?></strong>
                                <br>
                                <?php echo $delivery_instructions; ?>
                            </p>
                            <?php } ?>
                        </p>
                    </div>
                    <div class="col-6 pt-2">
                        <p class="text-end">
                            <strong class="text-uppercase">Ordrenr.</strong>
                            <br>
                            <?php echo $order->get_id(); ?>
                        </p>
                        <p class="text-end">
                            <strong class="text-uppercase">Hilsen til gavemodtager</strong>
                            <br>
                            <?php
                            echo esc_html( get_post_meta($order->get_id(), '_greeting_message', true) ); ?>
                        </p>
                    </div>
                </div>
                <div class="row order">
                    <div class="col-12 mt-4">
                        <h3>Din bestilling</h3>
                    </div>
                </div>
                <?php
                // Get and Loop Over Order Items

                foreach ( $order->get_items() as $item_id => $item ) {
                    // Set the vendor ID
                    $post = get_post($item->get_product_id());
                    $vendor_id = $post->post_author;

                     $product_id = $item->get_product_id();
                     $variation_id = $item->get_variation_id();
                     $product = $item->get_product();
                     $product_name = $item->get_name();
                     $quantity = $item->get_quantity();
                     $subtotal = $item->get_subtotal();
                     $total = $item->get_total();
                     $tax = $item->get_subtotal_tax();
                     $taxclass = $item->get_tax_class();
                     $taxstat = $item->get_tax_status();
                     $allmeta = $item->get_meta_data();
                     $somemeta = $item->get_meta( '_whatever', true );
                     $product_type = $item->get_type();
                     $unit_price = $total / $quantity;
                 ?>
                <div class="row order-product py-2">
                    <div class="col-2">
                        <?php
                        $id = $product->get_image_id();
                        $placeholder = wc_placeholder_img_src('thumbnail');

                        $img = ($id>0) ? wp_get_attachment_url($id) : $placeholder;
                        echo '<img src="'.$img.'" class="img-fluid">'; ?>
                    </div>
                    <div class="col-6">
                        <?php echo ($quantity > 1) ? $quantity.' x ' : ''; ?>
                        <?php echo $product_name; ?>
                    </div>
                    <div class="col-2">
                        <?php echo $order->get_item_subtotal( $item, $inc_tax = 'true', $round = 'false' ); ?> kr. pr. stk.
                    </div>
                    <div class="col-2 text-end">
                        <?php echo $order->get_formatted_line_subtotal( $item ); ?>
                    </div>
                </div>
                <?php
                }
                ?>
                <div class="row totals mt-4 py-2">
                    <div class="col-12">
                        <div class="row py-2 border-bottom border-top">
                                <div class="col-6">
                                    Varer i alt
                                </div>
                                <div class="col-6 text-end">
                                    <?php echo $order->get_subtotal_to_display(); ?>
                                </div>
                        </div>
                        <div class="row py-2 border-bottom">
                                <div class="col-6">
                                    Indpakning
                                </div>
                                <div class="col-6 text-end">

                                </div>
                        </div>
                        <div class="row py-2 border-bottom">
                                <div class="col-6">
                                    Levering & håndtering
                                </div>
                                <div class="col-6 text-end">
                                    <?php echo $order->get_shipping_to_display(); ?>
                                    <br>
                                    (heraf <?php echo $order->get_total_tax(); ?> kr. i moms)
                                </div>
                        </div>
                        <div class="row py-2 border-bottom">
                                <div class="col-6">
                                    Total (betalt med <?php echo $order->get_payment_method_title(); ?>)
                                </div>
                                <div class="col-6 text-end">
                                    <?php echo $order->get_formatted_order_total(true, 0); ?>
                                    <br>
                                    (heraf <?php echo $order->get_total_tax(); ?> kr. i moms)
                                </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-6">
                        <h4>Leveringsoplysninger</h4>
                        <p>
                            <?php echo '<span id="ship_fullname">'.$order->get_formatted_shipping_full_name().'</span>'; ?>
                            <?php echo ($order->get_shipping_company()) ? '<br><span id="ship_company">'.$order->get_shipping_company().'</span>' : ''; ?>

                            <?php echo ($order->get_shipping_address_1()) ? '<br><span id="ship_address">'.$order->get_shipping_address_1().'</span>' : ''; ?>

                            <?php echo ($order->get_shipping_postcode()) ? '<br><span id="ship_postcode">'.$order->get_shipping_postcode().'</span>' : ''; ?>
                            <?php echo ($order->get_shipping_city()) ? ' <span id="ship_city">'.$order->get_shipping_city().'</span>' : ''; ?>

                            <?php echo ($order->get_shipping_country()) ? '<br><span id="ship_country">'.$order->get_shipping_country().'</span>' : ''; ?>

                            <?php
                            $delivery_phone = get_post_meta($order->get_id(), '_receiver_phone', true);
                            echo ($delivery_phone) ? '<br><span id="ship_phone">'.$delivery_phone.'</span>' : ''; ?>
                        </p>
                    </div>
                    <div class="col-6">
                        <h4>Dine oplysninger</h4>
                        <p>
                            <?php echo '<span id="bill_fullname">'.$order->get_formatted_billing_full_name().'</span>'; ?>
                            <?php echo ($order->get_billing_company()) ? '<span id="bill_company"><br>'.$order->get_billing_company().'</span>' : ''; ?>

                            <?php echo ($order->get_billing_address_1()) ? '<br><span id="bill_address">'.$order->get_billing_address_1().'</span>' : ''; ?>

                            <?php echo ($order->get_billing_postcode()) ? '<br><span id="bill_postcode">'.$order->get_billing_postcode().'</span>' : ''; ?>
                            <?php echo ($order->get_billing_city()) ? ' <span id="bill_city">'.$order->get_billing_city().'</span>' : ''; ?>

                            <?php echo ($order->get_billing_country()) ? '<br><span id="bill_country">'.$order->get_billing_country().'</span>' : ''; ?>


                            <?php echo ($order->get_billing_email()) ? '<br><br><span id="bill_email">'.$order->get_billing_email().'</span>' : ''; ?>
                            <?php echo ($order->get_billing_phone()) ? '<br><span id="bill_phone">'.$order->get_billing_phone().'</span>' : ''; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-5 pb-5">
            <div class="col-12 col-lg-4 p-5">
                <h1 class="mt-5">Følg os</h1>
                <p>
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
            </div><!-- /.col -->
            <div class="col-12 col-lg-4 bg-light p-5">
                <?php
                $vendor = get_mvx_vendor($vendor_id);
                if($vendor){
                ?>
                <div class="text-center">
                    <?php
                            $image = $vendor->get_image() ? $vendor->get_image('image', array(125, 125)) : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
                    ?>
                    <img class="img-fuid pb-3" style="max-height:75px;"
                        src="<?php echo esc_attr($image); ?>">
                </div>
                <h4 class="mt-3">Din gavehilsen leveres fra <?php echo esc_html($vendor->page_title); ?></h4>
                <div class="store-loc pt-1 pb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                    </svg>
                    <?php
                    $vendor_address = !empty(get_user_meta($vendor_id, '_vendor_address_1', true)) ? get_user_meta($vendor_id, '_vendor_address_1', true) : '';
                    $vendor_postal = !empty(get_user_meta($vendor_id, '_vendor_postcode', true)) ? get_user_meta($vendor_id, '_vendor_postcode', true) : '';
                    $vendor_city = !empty(get_user_meta($vendor_id, '_vendor_city', true)) ? get_user_meta($vendor_id, '_vendor_city', true) : '';
                    $location = '';
                    if(!empty($vendor_address)){
                        $location .= $vendor_address.', ';
                    }
                    if(!empty($vendor_postal)){
                        $location .= $vendor_postal.' ';
                    }
                    if(!empty($vendor_city)){
                        $location .= $vendor_city.' ';
                    }
                    echo esc_html($location); ?>
                </div>
                <p></p>
                <p></p>
                <a href="<?php echo esc_url($vendor->get_permalink()); ?>" class="text-dark">Se butikkens sortiment</a>
                <?php
                }
                ?>
            </div><!-- /.col -->
            <div class="col-12 col-lg-4 p-5">
                <h3 class="mt-5">Brug for hjælp?</h3>
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
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</section>
<?php
get_footer();
