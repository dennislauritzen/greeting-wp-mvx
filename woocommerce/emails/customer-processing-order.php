<?php
/**
 * Admin new order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-new-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails\HTML
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

global $MVX;

$order_id = $order->get_id();
$hpos_enabled = is_wc_hpos_activated('frontend');

$parent_order_id = (empty(wp_get_post_parent_id($order_id)) ? $order_id : wp_get_post_parent_id($order_id));

// The different number orders
$latestOrderId = $parent_order_id; // Last order ID
$order_hash = hash('md4','gree_ting_dk#!4r1242142fgriejgfto'.$latestOrderId.$latestOrderId);
$order_hash2 = hash('md4', 'vvkrne12onrtnFG_:____'.$latestOrderId);

// Get vendor ID
$vendor_id = greeting_get_vendor_id_from_order( $order );
$vendor = get_mvx_vendor(absint($vendor_id));

// Calculate order IDs
$main_order = (empty(get_post_parent($order_id)) ? $order_id : get_post_parent($order_id) );
$main_order_object = wc_get_order($main_order);
$main_order_ID_str = ( empty($main_order_object->get_id())  ? $main_order : $main_order_object->get_id() );
$main_order_id = (empty(get_post_parent($order_id)) ? $order_id : $main_order_ID_str );

$additional_content = (!empty($additional_content) ? $additional_content : 'Vi har modtaget din bestilling - og den er videresendt til butikken, der sørger for, den bliver leveret til tiden. :)');

// Get the value if this order has funeral products
$order_has_funeral_products = order_has_funeral_products($order->get_id());

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email );
#do_action('woocommerce_email_before_order_table', $order, true, false, $email); ?>

<!-- THE CONTENT -->
<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="width: 100%; text-align: center; border-collapse: collapse;">
    <tr style="text-align: center;">
        <td align="center" style="text-align: center; padding: 0 15px;">
            <table width="770" border="0"cellpadding="0" cellspacing="0" style="text-align: left; margin: 0 auto; width: 770px; max-width: 770px; border-collapse: collapse;">
                <tr>
                    <td colspan="2" class="summary-heading" style="padding-bottom: 20px;">
                        <table width="100%" border="0"cellpadding="0" cellspacing="0" style="width: 100%; max-width: 800px; border-collapse: collapse;">
                            <tr>
                                <td width="75%" style="width: 75%;">
                                    <h1 style="margin-top: 25px;"><?php echo $email_heading; ?></h1>
                                    <small>
                                      <img width="15" height="15" src="https://s.w.org/images/core/emoji/14.0.0/72x72/2764.png" style="display: inline-block; width: 15px !important; max-width: 20px; height: 15px; max-height: 20px; font-size: 12px;">
                                      &nbsp; <?php echo $additional_content; ?>
                                   	</small>
                                </td>
                                <td width="25%" style="width: 25%">
                                        &nbsp;
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="order-summary">
                            <tr>
                                <td valign="top" style="padding: 10px 0 15px 0px;">
                                    <strong style="text-transform: uppercase;">Levering</strong>
                                    <br>
                                    <?php
                                    if($hpos_enabled){
                                        $delivery_date = $order->get_meta('_delivery_date');
                                        $delivery_date_time = $order->get_meta('_delivery_date_time');
                                    } else {
                                        $delivery_date = get_post_meta($order->get_id(), '_delivery_date', true);
                                        $delivery_date_time = get_post_meta($order->get_id(), '_delivery_date_time', true);
                                    }

                                    $wc_date = new WC_Datetime($delivery_date);
                                    $delivery_date2 = wc_format_datetime( $wc_date );

                                    if(!empty($delivery_date)){
                                        echo esc_html( $delivery_date2 );

                                        if(!empty($delivery_date_time)){
                                            echo ' kl. '.esc_html($delivery_date_time);
                                        }
                                    } else {
                                        echo 'Hurtigst muligt';
                                    }
                                    ?>
                                    <br>
                                    <?php if(order_has_funeral_products($parent_order_id)) { ?>
                                        til
                                        <?php echo $order->get_shipping_company(); ?>
                                        (Afdødes navn: <?php echo $order->get_shipping_first_name().' '.$order->get_shipping_last_name(); ?>)
                                    <?php } else { ?>
                                        til
                                        <?php echo $order->get_shipping_first_name().' '.$order->get_shipping_last_name(); ?>
                                    <?php } ?>
                                </td>
                                <td valign="top" align="right" style="padding: 10px 0px 10px 0;">
                                    <strong style="text-transform: uppercase;">Ordrenr</strong>
                                    <br>
                                    #<?php echo $main_order_id; ?> <!--(Sub-ordre nr.: #<?php echo $order->get_id(); ?>)-->
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" width="50%" style="width: 50%; padding: 10px 0 15px 0px;">
									<?php
									if($hpos_enabled){
										$delivery_instructions = $main_order_object->get_meta( $order->get_id(), '_delivery_instructions');
									} else {
										$delivery_instructions = get_post_meta( $main_order_id, '_delivery_instructions', true );
									} ?>
                                    <strong><?php _e('Leveringsinstruktioner', 'woocommerce'); ?></strong>
                                    <br>
                                    <?php echo (!empty($delivery_instructions)) ? $delivery_instructions : 'Ingen særlige leveringsinstruktioner'; ?>
                                    <br>
                                    <br>

                                    <?php
                                    if(!order_has_funeral_products($parent_order_id)){

                                        // Only show this if it is not a funeral order.

                                        if($hpos_enabled){
                                            $leave_gift_at_address = ($main_order_object->get_meta('_leave_gift_address') == "1" ? 'Ja' : 'Nej');
                                        } else {
                                            $leave_gift_at_address = (get_post_meta( $main_order_id, '_leave_gift_address', true ) == "1" ? 'Ja' : 'Nej');
                                        }
                                        ?>
                                        <?php _e('Må stilles på adressen:', 'woocommerce'); ?> <?php echo $leave_gift_at_address; ?><br>

                                        <?php
                                        if($hpos_enabled){
                                            $leave_gift_at_neighbour = ($main_order_object->get_meta('_leave_gift_neighbour') == "1" ? 'Ja' : 'Nej');
                                        } else {
                                            $leave_gift_at_neighbour = (get_post_meta( $main_order_id, '_leave_gift_neighbour', true ) == "1" ? 'Ja' : 'Nej');
                                        }
                                        ?>
                                        <?php _e('Må gaven afleveres hos naboen:', 'woocommerce'); ?> <?php echo $leave_gift_at_neighbour; ?>

                                        <?php
                                    }
                                    ?>
                                </td>
                                <td valign="top" align="right" width="50%" style="vertical-align: top; width: 50%; padding: 10px 0px 10px 0;">
                                    <!--<strong style="text-transform: uppercase;">Hilsen til gavemodtager</strong>
                                    <p>
                                        <?php
                                        #echo esc_html( get_post_meta($main_order_id, '_greeting_message', true) ); ?>
                                    </p>-->
                                    <strong style="text-transform: uppercase;">
                                        <?php
                                        if(order_has_funeral_products($parent_order_id)){
                                            echo 'Hilsen til afdøde';
                                        } else {
                                            echo 'Hilsen til gavemodtager';
                                        }
                                        ?>
                                    </strong>
                                    <br>
                                    <p>
                                        <?php
										if($hpos_enabled){
											$band_line_1 = $main_order_object->get_meta('_greeting_message_band_1');
											$band_line_2 = $main_order_object->get_meta('_greeting_message_band_2');
										} else {
											$band_line_1 = get_post_meta( $parent_order_id, '_greeting_message_band_1', true );
											$band_line_2 = get_post_meta( $parent_order_id, '_greeting_message_band_2', true );
										}

                                        if( order_has_funeral_products($parent_order_id)
                                            && ( !empty($band_line_1)
                                                || !empty( $band_line_2 )
											)
                                        ){
                                            echo 'Bånd, linje 1: '.$band_line_1 . '<br><br>';
                                            echo 'Bånd, linje 2: '.$band_line_2;
                                        } else {
                                            $greeting_message = $hpos_enabled ? esc_html( $main_order_object->get_meta('_greeting_message') ) : esc_html( get_post_meta($main_order_id, '_greeting_message', true) );

                                            echo $greeting_message;
                                        }
                                        ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" width="50%" style="width: 50%; padding: 10px 0 15px 0px;">
                                    <?php if(!order_has_funeral_products($parent_order_id)){ ?>
                                        <p>
                                            <strong><?php _e('Modtagers telefonnummer:', 'woocommerce'); ?></strong>
                                            <br>
                                            <?php
                                            if($hpos_enabled){
                                                echo $main_order_object->get_meta('_receiver_phone');
                                            } else {
                                                echo get_post_meta( $main_order_id, '_receiver_phone', true );
                                            }
                                            ?>
                                        </p>
                                    <?php } ?>

                                    <p>
                                      <strong><?php _e('Dit telefonnummer:', 'woocommerce'); ?></strong><br>
                                      <?php echo $order->get_billing_phone(); ?>
                                    </p>
                                </td>
                                <td valign="top" align="right" width="50%" style="width: 50%; padding: 10px 0px 10px 0;">
                                    <strong style="text-transform: uppercase;">Bestillingsdato</strong>
                                    <br>
                                    <?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?><!--(Status: <?php echo $order->get_status(); ?>)-->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="order-heading">
                        <h2>Din bestilling</h2>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <style type="text/css">
                          table#prodtable td {
                            border:0 !important;
                          }
                          table#prodtable td:last-child {
                            text-align: right !important;
                          }
                          table#prodtable td:last-child span {
                            display: inline-block;
                          }
                        </style>
                        <table id="prodtable" border="0" cellpadding="0" cellspacing="0" border="0" style="width: 100%; border: 0; border-collapse: collapse;">
													<thead border="0" style="border: 0;">
                            <tr border="0" style="border: 0;">
                              <th width="25%" style="border: 0; width: 25%; font-size: 1px;">&nbsp;</th>
                              <th width="40%" style="border: 0; width: 40%; font-size: 1px;">&nbsp;</th>
                              <th width="10%" style="border: 0; width: 10%; font-size: 1px;">&nbsp;</th>
                              <th width="25%" style="border: 0; width: 25%; font-size: 1px;">&nbsp;</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $vendor->vendor_order_item_table($order, $vendor->term_id, true);
                            ?>
                          </tbody>
                        </table>
                    </td>
                </tr>

                <?php
                if (apply_filters('show_cust_order_calulations_field', true, $vendor->id)) {
                    $order_total = $order->get_total();
                    $order_ship_total = $order->get_shipping_total() + $order->get_shipping_tax();

                    // Calculate the cost of the cards
                    $fees = $order->get_fees();
                    $greeting_card_fee_ex_vat = 0;
                    $greeting_card_fee_with_vat = 0;
                    foreach($fees as $fee){
                        $fee_name = $fee->get_name();
                        $fee_amount = $fee->get_amount();

                        $greeting_card_fee_ex_vat =+ $fee_amount;
                        $greeting_card_fee_with_vat =+ $fee_amount * 1.25 ;
                    }

                    $order_new_subtotal = $order_total - $greeting_card_fee_with_vat - $order_ship_total;
                ?>
                <tr class="order-details-totals-row" style="border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;">
                    <td width="50%" style="width: 50%; padding: 6px 0 6px 10px;">
                        Varetotal (inkl. 25 % moms)
                    </td>
                    <td style="width: 50%; padding: 6px 10px 6px 0px; text-align: right;">
                        <?php echo wc_price( $order_new_subtotal ); ?>
                    </td>
                </tr>
                <?php if($greeting_card_fee_with_vat > 0){ ?>
                <tr class="order-details-totals-row" style="border-top: 1px solid #c0c0c0; border-bottom: 1px solid #dee2e6;">
                    <td width="50%" style="width: 50%; padding: 6px 0 6px 10px;">
                        Kort
                    </td>
                    <td style="width: 50%; padding: 6px 10px 6px 0px; text-align: right;">
                        <?php echo wc_price( $greeting_card_fee_with_vat ); ?>
                    </td>
                </tr>
                <?php } ?>
                <tr class="order-details-totals-row" style="border-top: 1px solid #c0c0c0; border-bottom: 1px solid #dee2e6;">
                    <td width="50%" style="width: 50%; padding: 6px 0 6px 10px;">
                        Levering
                    </td>
                    <td style="width: 50%; padding: 6px 10px 6px 0px; text-align: right;">
                        <?php echo wc_price( $order_ship_total ); ?>
                    </td>
                </tr>
                <tr class="order-details-totals-row" style="border-top: 1px solid #c0c0c0; border-bottom: 1px solid #dee2e6;">
                    <td width="50%" style="width: 50%; padding: 6px 0 6px 10px;">
                        Ordretotal (inkl. 25 % moms)
                    </td>
                    <td style="width: 50%; padding: 6px 10px 6px 0px; text-align: right;">
                        <?php echo wc_price( $order_total ); ?>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <td valign="top" class="delivery-options-cell">
                        <h3>Levering</h3>
                        <p>
                            <?php if( order_has_funeral_products($parent_order_id) ){
                                echo '<span id="ship_fullname">Kirkens navn: '.$order->get_formatted_shipping_full_name().'</span>';
                                echo ($order->get_shipping_company()) ? '<br><span id="ship_company">Afdødes navn: '.$order->get_shipping_company().'</span>' : '';
                            } else {
                                echo '<span id="ship_fullname">'.$order->get_formatted_shipping_full_name().'</span>';
                                echo ($order->get_shipping_company()) ? '<br><span id="ship_company">'.$order->get_shipping_company().'</span>' : '';
                            }
                            ?>

                            <?php echo ($order->get_shipping_address_1()) ? '<br><span id="ship_address">'.$order->get_shipping_address_1().'</span>' : ''; ?>

                            <?php echo ($order->get_shipping_postcode()) ? '<br><span id="ship_postcode">'.$order->get_shipping_postcode().'</span>' : ''; ?>
                            <?php echo ($order->get_shipping_city()) ? ' <span id="ship_city">'.$order->get_shipping_city().'</span>' : ''; ?>

                            <?php echo ($order->get_shipping_country()) ? '<br><span id="ship_country">'.WC()->countries->countries[$order->get_shipping_country()].'</span>' : ''; ?>

                            <?php
							if($hpos_enabled){
								$delivery_phone = $main_order_object->get_meta('_receiver_phone');
							} else {
								$delivery_phone = get_post_meta( $main_order_id, '_receiver_phone', true );
							}

                            echo ($delivery_phone) ? '<br><span id="ship_phone">Modtagers tlf.: '.$delivery_phone.'</span>' : ''; ?>
                        </p>
                    </td>
                    <td valign="top" class="your-options-cell">
                        <h3>Dine info</h3>
                        <p>
                            <?php echo '<span id="bill_fullname">'.$order->get_formatted_billing_full_name().'</span>'; ?>
                            <?php echo ($order->get_billing_company()) ? '<span id="bill_company"><br>'.$order->get_billing_company().'</span>' : ''; ?>

                            <?php echo ($order->get_billing_address_1()) ? '<br><span id="bill_address">'.$order->get_billing_address_1().'</span>' : ''; ?>

                            <?php echo ($order->get_billing_postcode()) ? '<br><span id="bill_postcode">'.$order->get_billing_postcode().'</span>' : ''; ?>
                            <?php echo ($order->get_billing_city()) ? ' <span id="bill_city">'.$order->get_billing_city().'</span>' : ''; ?>

                            <?php echo ($order->get_billing_country()) ? '<br><span id="bill_country">'.WC()->countries->countries[$order->get_billing_country()].'</span>' : ''; ?>


                            <?php echo ($order->get_billing_email()) ? '<br><br><span id="bill_email">Din mail: '.$order->get_billing_email().'</span>' : ''; ?>
                            <?php echo ($order->get_billing_phone()) ? '<br><span id="bill_phone">Dit tlf.nr.: '.$order->get_billing_phone().'</span>' : ''; ?>
                        </p>
                    </td>
                </tr>
                <!--<tr>
                    <td valign="top" class="your-options-cell-mobile">
                        <h3>Afsenders oplysninger</h3>
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
                    </td>
                </tr>-->
                <tr>
                    <td colspan="2" style="background: #f8f9fa; padding: 20px;">
                        <?php
                        $vendor = get_mvx_vendor($vendor_id);
                        if($vendor){
                            ?>
                            <div class="text-center">
                                <?php
                                $image = $vendor->get_image() ? $vendor->get_image('image', array(125, 125)) : $MVX->plugin_url . 'assets/images/WP-stdavatar.png';
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
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table width="100%" class="social" style="width: 100%;;">
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
