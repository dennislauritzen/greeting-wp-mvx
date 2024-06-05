<?php
/**
 * Template Name: E-mail template (new)
 * Description: Page template.
 *
 */

//if(empty($_GET['o']) || empty($_GET['key'])){
//	return;
//}

// If testing on Mac:
#$order_id 		= 48991;//(isset($_GET['o']) ? $_GET['o'] : 0);
#$order_old_id 	= 48991;//(isset($_GET['order_id']) ? $_GET['order_id'] : 0);

// If testing on Windows:
$order_id 		= 40254;//(isset($_GET['o']) ? $_GET['o'] : 0);
$order_old_id 	= 40254;//(isset($_GET['order_id']) ? $_GET['order_id'] : 0);
$order_key 		= (isset($_GET['key']) ? $_GET['key'] : '');

$order_id_data = wc_get_order_id_by_order_key( $order_key );
$order = wc_get_order( $order_id );

$vendor_id = 0;

// If someone changed something in the URL part
//if($order_id != $order_id_data){#logo {
//                width: 250px;
//            }
//            @media only screen and (max-width: 800px) {
//                #logo {
//                    width: 300px !important;
//                    padding: 10px 0 10px 0 !important;
//                }
//            }
//
//            td.cr-cell {
//                padding-left: 10px;
//                padding-bottom: 10px;
//            }
//            td.contact-icon-cell {
//                padding-bottom: 10px;
//                padding-right: 10px;
//            }
//            @media only screen and (max-width: 800px) {
//                td.cr-cell,
//                td.contact-icon-cell {
//                    padding-bottom: 20px !important;
//                }
//            }
//
//            img.customerreviews {
//                width: 250px;
//            }
//            img.customerreviews a {
//                border: 0;
//            }
//            @media only screen and (max-width: 800px) {
//                img.customerreviews {
//                    width: 300px;
//                }
//            }
//
//            img.phone-icon,
//            img.mail-icon {
//                width: 45px;
//                height: 45px;
//            }
//
//            @media only screen and (max-width: 800px) {
//                img.phone-icon,
//                img.mail-icon {
//                    width: 75px !important;
//                    height: 75px !important;
//                    padding-right: 10px !important;
//                }
//            }
//	return;
//}

#do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );
#do_action( 'woocommerce_thankyou', $order->get_id() );

#get_header('checkout');

//the_post();
?>
<link rel='stylesheet' id='style-css' href='https://www.greeting.dk/wp-content/themes/greeting2/style.css?ver=3.0.4' media='all' />
<link rel='stylesheet' id='main-css' href='https://www.greeting.dk/wp-content/themes/greeting2/assets/css/main.css?ver=3.0.4' media='all' />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Merriweather:wght@300;400;700;900&family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&family=Rubik:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style type="text/css">
    html,body {
        padding: 0;
        margin: 0;
    }

    #logo {
        width: 250px;
    }
    @media only screen and (max-width: 800px) {
        #logo {
            width: 300px !important;
            padding: 10px 0 10px 0 !important;
        }
    }

    td.cr-cell {
        padding-left: 10px;
        padding-bottom: 10px;
    }
    td.contact-icon-cell {
        padding-bottom: 10px;
        padding-right: 10px;
    }
    @media only screen and (max-width: 800px) {
        td.cr-cell,
        td.contact-icon-cell {
            padding-bottom: 20px !important;
        }
    }

    img.customerreviews {
        width: 250px;
    }
    img.customerreviews a {
        border: 0;
    }
    @media only screen and (max-width: 800px) {
        img.customerreviews {
            width: 300px;
        }
    }

    img.phone-icon,
    img.mail-icon {
        width: 45px;
        height: 45px;
    }

    @media only screen and (max-width: 800px) {
        img.phone-icon,
        img.mail-icon {
            width: 75px !important;
            height: 75px !important;
            padding-right: 10px !important;
        }
    }

    td.order-heading {
        padding: 50px 0 15px 0;
    }
    @media only screen and (max-width: 800px) {
        td.summary-heading,
        td.order-heading {
            padding-left: 10px;
        }
    }

    table.order-summary {
        font-size: 15px;
    }
    @media only screen and (max-width: 800px) {
        table.order-summary {
            font-size: 14px;
        }
    }

    table.order-details,
    tr.order-details-totals-row {
        font-size: 14px;
    }
    @media only screen and (max-width: 800px) {
        table.order-details,
        tr.order-details-totals-row{
            font-size: 13px;
        }
    }

    td.delivery-options-cell,
    td.your-options-cell {
        vertical-align: top;
        width: 50%;
        padding: 50px 0 0 0;
    }
    td.your-options-cell-mobile {
        display: none;
    }
    td.delivery-options-cell p,
    td.your-options-cell p,
    td.your-options-cell-mobile p {
        font-size: 13px;
    }
    td.your-options-cell {
        text-align: right;
    }
    @media only screen and (max-width: 800px) {
        td.your-options-cell {
            display: none;
        }

        td.delivery-options-cell,
        td.your-options-cell-mobile {
            padding-left: 15px;
            display: table-cell;
            width: 100%;
        }
    }


    label {
        font-family: 'Inter', sans-serif;
    }

    h1, h2, h3, h4 {
        font-family: 'Merriweather';
    }
    h1 {
        font-size: 28px;
        font-weight: 500;
    }
    h2 {
        font-size: 25px;
        font-weight: 500;
    }
    h3 {
        font-size: 22px !important;
        font-weight: 500 !important;
    }

    @media only screen and (max-width: 800px) {
        h1 {
            font-size: 22px;
            font-weight: 500;
        }
        h2 {
            font-size: 19px;
            font-weight: 500;
        }
        h3 {
            font-size: 16px !important;
            font-weight: 500 !important;
        }
    }
    input {
        font-family: 'Inter', sans-serif;
    }
    input[type="radio"] {
        width: 4%;
        min-width: 20px;
    }
    .form-row-label {
        width: 95%;
    }

    p {
        line-height: 150% !important;
    }

    table.social {

    }
    table.social p {
        font-size: 14px;
    }
    @media only screen and (max-width: 800px) {
        table.social p {
            font-size: 13px;
        }
    }

    #greeting-footer h6 {
        font-family: 'Rubik', 'Inter', 'Comic Sans', sans-serif;
        font-size: 20px;
        color: #1b4949;
    }
    #greeting-footer .greeting-footer-logo {
        width: 175px;
    }
    @media only screen and (max-width: 800px) {
        #greeting-footer .greeting-footer-logo {
            width: 275px;
        }
    }

    #greeting-footer .left-col {
        padding: 0 0 0 20px;
    }
    #greeting-footer .right-col {
        padding: 0 20px 0 0;
    }
    #greeting-footer h6.light {
        font-family: 'Rubik', 'Inter', 'Comic Sans', sans-serif;
        font-size: 18px;
        text-transform: uppercase;
        color: #ffffff;
    }
    #greeting-footer h4 a,
    #greeting-footer h6 a {
        color: #1b4949;
    }
    #greeting-footer h6.light a {
        color: #ffffff;
    }
    #greeting-footer ul {
        font-family: 'Inter', 'Comic Sans', sans-serif;
        font-weight: 300;
    }

    #greeting-footer ul.social {
        width: 150px;
        list-style: none;
        margin: -30px 0 0 -100px;
        padding: 0 5px 0 0;
    }
    #greeting-footer ul.social li {
        float: left;
        width: 45px;
        margin: 0;
        padding: 0;
    }
    #greeting-footer ul.footer-menu,
    #greeting-footer p {
        font-size: 13px;
    }
    #greeting-footer p a {
        color: #ffffff;
    }
    @media only screen and (max-width: 800px) {
        #greeting-footer ul.footer-menu,
        #greeting-footer p {
            font-size: 15px;
        }
    }
    #greeting-footer ul.social li a {
        color: #ffffff;
    }
    #formal-footer {
        border-top: 3px solid #fecbca;
        font-family: 'Inter',sans-serif;
        font-size: 12px;
        color: #555555;
    }
    #formal-footer ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    #formal-footer ul li {
        float: left;
        margin: 0;
        padding: 0 10px 0 0;
    }
</style>

<!--[if gte mso 9]><table width="600" cellpadding="0" cellspacing="0"><tr><td><![endif]-->
<table width="100%" style="width: 100%;">
    <tr style="background-color: #4d696b;">
        <td align="center">
            <table width="800" style="width:800px;" id="header">
                <tr>
                    <td width="100%" colspan="2" style="padding: 30px 0 5px 0; width: 100%; text-align: center;">
                        <a href="<?php echo home_url(); ?>" style="padding: 5px 0 0 0;">
                            <img src="https://www.greeting.dk/wp-content/uploads/2023/06/mail-logo.png" id="logo" />
                        </a>
                    </td>
                </tr>
                <tr>
                    <td width="50%"  class="cr-cell" style="text-align: left;">
                        <a href="https://dk.trustpilot.com/review/greeting.dk">
                            <img class="customerreviews" src="https://www.greeting.dk/wp-content/uploads/2023/06/customer-reviews-94-new-v4.png">
                        </a>
                    </td>
                    <td width="50%" class="contact-icon-cell" style="text-align: right;">
                        <a href="tel:+4571901834" title="Ring til os her, hvis du oplever problemer eller har spørgsmål.">
                            <img class="phone-icon" src="https://www.greeting.dk/wp-content/uploads/2023/06/icon-phone.png">
                        </a>
                        <a href="mailto:kontakt@greeting.dk" alt="E-mail" title="Skriv til os her, hvis du oplever problemer eller har spørgsmål.">
                            <img class="mail-icon" src="https://www.greeting.dk/wp-content/uploads/2023/06/icon-mail.png">
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- THE CONTENT -->
<table width="100%" style="width: 100%; padding: 0 15px;">
    <tr>
        <td align="center">
            <table width="800" style="width: 100%; max-width: 800px;">
                <tr>
                    <td colspan="2" class="summary-heading" style="padding-bottom: 20px;">
                        <h1 style="margin-top: 35px;">Din bestilling af gavehilsen er modtaget</h1>
                        <small>❤️ af hjertet tak fra os - og din modtager</small>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="100%" class="order-summary" style="width: 100%; border: 1px solid #dee2e6;">
                            <tr>
                                <td valign="top" style="padding: 10px 0 15px 10px;">
                                    <strong style="text-transform: uppercase;">Bestillingsdato</strong>
                                    <br>
                                    <?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?><!--(Status: <?php echo $order->get_status(); ?>)-->
                                </td>
                                <td valign="top" align="right" style="padding: 10px 15px 10px 0;">
                                    <strong style="text-transform: uppercase;">Ordrenr</strong>
                                    <br>
                                    <?php echo $order->get_id(); ?>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" width="50%" style="width: 50%; padding: 10px 0 15px 10px;">
                                    <strong style="text-transform: uppercase;">Levering</strong>
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
                                    <?php _e('Må stilles på adressen:', 'woocommerce'); ?> <?php echo $leave_gift_at_address; ?><br>

                                    <?php $leave_gift_at_neighbour = (get_post_meta( $order->get_id(), '_leave_gift_neighbour', true ) == "1" ? 'Ja' : 'Nej'); ?>
                                    <?php _e('Må gaven afleveres hos naboen:', 'woocommerce'); ?> <?php echo $leave_gift_at_neighbour; ?>
                                </td>
                                <td valign="top" align="right" width="50%" style="width: 50%; padding: 10px 15px 10px 0;">
                                    <strong style="text-transform: uppercase;">Hilsen til gavemodtager</strong>
                                    <br>
                                    <p>
                                    <?php
                                    echo esc_html( get_post_meta($order->get_id(), '_greeting_message', true) ); ?>
                                    </p>
                                </td>
                            </tr>
                            <?php $delivery_instructions = get_post_meta( $order->get_id(), '_delivery_instructions', true ); ?>
                            <?php if(!empty($delivery_instructions)){ ?>
                            <tr>
                                <td valign="top" width="50%" style="width: 50%; padding: 10px 0 15px 10px;">
                                    <strong><?php _e('Leveringsinstruktioner', 'woocommerce'); ?></strong>
                                    <br>
                                    <?php echo $delivery_instructions; ?>
                                </td>
                                <td valign="top" align="right" width="50%" style="width: 50%; padding: 10px 15px 10px 0;">
                                    &nbsp;
                                </td>
                            </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="order-heading">
                        <h2>Din bestilling</h2>
                    </td>
                </tr>
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
                    <tr>
                        <td colspan="2" style="padding: 20px 0;">
                            <table class="order-details" style="width: 100%;">
                                <tr>
                                    <td width="20%" style="width: 20%;">
                                        <?php
                                        $id = $product->get_image_id();
                                        $placeholder = wc_placeholder_img_src('thumbnail');

                                        $img = ($id>0) ? wp_get_attachment_url($id) : $placeholder;
                                        echo '<img src="'.$img.'" class="img-fluid">'; ?>
                                    </td>
                                    <td width="50%" style="width: 50%;">
                                        <?php echo ($quantity > 1) ? $quantity.' x ' : ''; ?>
                                        <?php echo $product_name; ?>
                                    </td>
                                    <td width="15%" style="width: 15%;">
                                        <?php echo $order->get_item_subtotal( $item, $inc_tax = 'true', $round = 'false' ); ?> kr. pr. stk.
                                    </td>
                                    <td width="15%" style="width: 15%; text-align: right;">
                                        <?php echo $order->get_formatted_line_subtotal( $item ); ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr class="order-details-totals-row" style="border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;">
                    <td width="50%" style="width: 50%; padding: 6px 0 6px 10px;">
                        Varer i alt
                    </td>
                    <td style="width: 50%; padding: 6px 10px 6px 0px; text-align: right;">
                        <?php echo $order->get_subtotal_to_display(); ?>
                    </td>
                </tr>
                <tr class="order-details-totals-row" style="border-top: 1px solid #c0c0c0; border-bottom: 1px solid #dee2e6;">
                    <td width="50%" style="width: 50%; padding: 6px 0 6px 10px;">
                        Indpakning
                    </td>
                    <td style="width: 50%; padding: 6px 10px 6px 0px; text-align: right;">
                        Gratis
                    </td>
                </tr>
                <tr class="order-details-totals-row" style="border-top: 1px solid #c0c0c0; border-bottom: 1px solid #dee2e6;">
                    <td width="50%" style="width: 50%; padding: 6px 0 6px 10px;">
                        Levering & håndtering
                    </td>
                    <td style="width: 50%; padding: 6px 10px 6px 0px; text-align: right;">
                        <?php echo $order->get_shipping_to_display(); ?>
                        <br>
                        (heraf <?php echo $order->get_total_tax(); ?> moms)
                    </td>
                </tr>
                <tr class="order-details-totals-row" style="border-top: 1px solid #c0c0c0; border-bottom: 1px solid #dee2e6;">
                    <td width="50%" style="width: 50%; padding: 6px 0 6px 10px;">
                        Total (betalt med <?php echo $order->get_payment_method_title(); ?>)
                    </td>
                    <td style="width: 50%; padding: 6px 10px 6px 0px; text-align: right;">
                        <?php echo $order->get_formatted_order_total(true, 0); ?>
                        <br>
                        (heraf <?php echo $order->get_total_tax(); ?> moms)
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="delivery-options-cell">
                        <h3>Leveringsoplysninger</h3>
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
                    </td>
                    <td valign="top" class="your-options-cell">
                        <h3>Dine oplysninger</h3>
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
                </tr>
                <tr>
                    <td valign="top" class="your-options-cell-mobile">
                        <h3>Dine oplysninger</h3>
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
                </tr>
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
<table width="100%" class="social" style="width: 100%; padding: 0 15px;">
    <tr>
        <td align="center">
            <table width="800" style="width: 100%; max-width: 800px;">
                <tr>
                    <td valign="top" class="left-col" style="width: 50%; padding: 40px 10px 40px 10px;">
                        <h4>Følg os</h4>
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
                    </td>
                    <td valign="top" class="right-col" style="width: 50%; padding: 40px 10px 40px 10px;">
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

<table width="100%" id="greeting-footer" style="width: 100%;">
    <tr style="background-color: #4d696b;">
        <td align="center" style=" padding: 0 0 25px 0;">
            <table width="800" style="width:800px;">
                <tr>
                    <td width="100%" colspan="2" style="width: 100%; padding: 50px 0 30px 0; text-align: center;">
                        <svg viewBox="0 0 524 113" class="greeting-footer-logo"  fill="#fecbca"  xmlns="http://www.w3.org/2000/svg">
                            <path d="m77.206 77.399c-1.3564 0.9013-3.0143 2.0655-4.9737 3.4925-1.884 1.352-4.1824 2.6664-6.8954 3.9432-2.6376 1.2017-5.7273 2.2532-9.2692 3.1545s-7.5736 1.352-12.095 1.352c-6.707 0-12.773-1.0891-18.199-3.2672-5.4259-2.2533-10.06-5.2951-13.904-9.1256-3.768-3.9057-6.707-8.4497-8.817-13.632-2.0347-5.2576-3.0521-10.891-3.0521-16.899 0-6.0086 1.055-11.604 3.1651-16.787 2.1101-5.2576 5.1244-9.8016 9.0431-13.632 3.9941-3.9056 8.8171-6.9475 14.469-9.1256 5.652-2.2532 12.058-3.3799 19.217-3.3799 3.2404 0 6.2548 0.18777 9.0431 0.56331 2.8637 0.37554 5.5013 0.86375 7.9128 1.4646 2.4868 0.52575 4.7099 1.0891 6.6693 1.6899 1.9593 0.60086 3.7303 1.1642 5.3128 1.6899l2.2608 18.364-1.0174 0.338c-2.7129-3.9056-5.3128-7.2104-7.7997-9.9143-2.4115-2.779-4.8606-5.0322-7.3475-6.7597-2.4115-1.8026-4.936-3.117-7.5736-3.9432-2.6376-0.82619-5.4636-1.2393-8.478-1.2393-5.1998 0-9.7213 1.0515-13.565 3.1545-3.8433 2.103-7.0084 4.9947-9.4952 8.675-2.4869 3.6803-4.3709 7.999-5.652 12.956-1.2058 4.9571-1.8086 10.29-1.8086 15.998s0.5652 11.041 1.6956 15.998c1.1303 4.882 2.8636 9.1632 5.1998 12.844 2.4115 3.6052 5.4635 6.4593 9.1561 8.5623 3.768 2.103 8.2896 3.1545 13.565 3.1545 6.1795 0 11.191-1.5021 15.034-4.5064 3.8434-3.0044 5.765-7.4733 5.765-13.407 0-2.0279-0.0753-3.8305-0.2261-5.4078-0.1507-1.5773-0.4521-3.0794-0.9043-4.5065-0.3768-1.427-0.9043-2.8165-1.5825-4.1685-0.6782-1.427-1.5072-2.9667-2.4869-4.6191v-0.2253h22.156v0.2253c-0.9043 1.7275-1.6579 3.3423-2.2608 4.8445-0.6029 1.427-1.0927 2.8916-1.4695 4.3938-0.3014 1.5021-0.5275 3.117-0.6782 4.8444-0.0754 1.7275-0.1131 3.7554-0.1131 6.0838v6.7597z"/>
                            <path d="m88.067 87.651v-0.2253c0.5275-1.5772 0.942-3.117 1.2434-4.6191 0.3768-1.5022 0.6406-3.0794 0.7913-4.7318 0.2261-1.7275 0.3768-3.5677 0.4522-5.5205 0.0753-2.0279 0.113-4.2811 0.113-6.7597v-13.294c0-3.7554-0.5275-6.7597-1.5825-9.013-0.9797-2.2532-2.1478-4.1309-3.5043-5.6331v-0.2253l15.939-5.9711v13.745h0.452c1.13-1.352 2.336-2.779 3.617-4.2812 1.357-1.5772 2.789-3.0043 4.296-4.2811 1.507-1.352 3.089-2.441 4.747-3.2672 1.734-0.9013 3.505-1.352 5.313-1.352l-0.226 13.745h-0.452c-0.528-0.4506-1.243-0.8637-2.148-1.2393-0.904-0.3755-1.846-0.7135-2.826-1.0139-0.904-0.3756-1.846-0.6385-2.826-0.7887-0.904-0.2253-1.658-0.338-2.26-0.338-0.905 0-2.035 0.4131-3.392 1.2393-1.281 0.8262-2.562 2.103-3.843 3.8305v18.026c0 4.882 0.113 8.9754 0.339 12.28 0.302 3.2297 1.017 6.3842 2.148 9.4636v0.2253h-16.391z"/>
                            <path d="m169.29 72.667c-0.754 2.3283-1.809 4.5065-3.165 6.5344-1.281 2.0279-2.864 3.793-4.748 5.2951-1.884 1.5022-4.032 2.6663-6.443 3.4925-2.412 0.9013-5.087 1.352-8.026 1.352-3.768 0-7.234-0.676-10.399-2.0279-3.09-1.4271-5.765-3.3799-8.026-5.8585-2.186-2.4785-3.919-5.4077-5.2-8.7876-1.206-3.3799-1.809-7.0226-1.809-10.928 0-4.5065 0.754-8.5623 2.261-12.168 1.583-3.6803 3.617-6.7973 6.104-9.351 2.487-2.5536 5.275-4.5064 8.365-5.8584 3.165-1.427 6.293-2.1406 9.382-2.1406 3.316 0 6.331 0.676 9.044 2.028 2.712 1.3519 5.011 3.1169 6.895 5.2951 1.959 2.103 3.429 4.4689 4.408 7.0977 0.98 2.5536 1.395 5.0698 1.244 7.5483h-36.286v2.1406c0 7.9615 1.809 13.857 5.426 17.688 3.617 3.8306 8.403 5.7458 14.356 5.7458 3.467 0 6.481-0.6384 9.043-1.9153 2.638-1.3519 4.936-3.2296 6.896-5.633l0.678 0.4506zm-22.156-38.418c-2.185 0-4.107 0.4882-5.765 1.4646-1.582 0.9013-2.976 2.1781-4.182 3.8305-1.131 1.5772-2.035 3.4925-2.713 5.7457-0.678 2.1782-1.131 4.5441-1.357 7.0977l24.53-0.5633v-1.2393c0-5.6331-0.867-9.764-2.6-12.393s-4.371-3.9431-7.913-3.9431z"/>
                            <path d="m219.88 72.667c-0.753 2.3283-1.808 4.5065-3.165 6.5344-1.281 2.0279-2.863 3.793-4.747 5.2951-1.884 1.5022-4.032 2.6663-6.444 3.4925-2.411 0.9013-5.086 1.352-8.025 1.352-3.768 0-7.235-0.676-10.4-2.0279-3.09-1.4271-5.765-3.3799-8.026-5.8585-2.185-2.4785-3.918-5.4077-5.2-8.7876-1.205-3.3799-1.808-7.0226-1.808-10.928 0-4.5065 0.753-8.5623 2.261-12.168 1.582-3.6803 3.617-6.7973 6.104-9.351 2.487-2.5536 5.275-4.5064 8.365-5.8584 3.165-1.427 6.292-2.1406 9.382-2.1406 3.316 0 6.33 0.676 9.043 2.028 2.713 1.3519 5.011 3.1169 6.895 5.2951 1.96 2.103 3.429 4.4689 4.409 7.0977 0.98 2.5536 1.394 5.0698 1.243 7.5483h-36.285v2.1406c0 7.9615 1.808 13.857 5.426 17.688 3.617 3.8306 8.402 5.7458 14.356 5.7458 3.466 0 6.48-0.6384 9.043-1.9153 2.637-1.3519 4.936-3.2296 6.895-5.633l0.678 0.4506zm-22.155-38.418c-2.186 0-4.107 0.4882-5.765 1.4646-1.583 0.9013-2.977 2.1781-4.183 3.8305-1.13 1.5772-2.034 3.4925-2.713 5.7457-0.678 2.1782-1.13 4.5441-1.356 7.0977l24.529-0.5633v-1.2393c0-5.6331-0.866-9.764-2.6-12.393-1.733-2.6288-4.37-3.9431-7.912-3.9431z"/>
                            <path d="m240.63 89.341c-1.657 0-3.278-0.2253-4.86-0.676-1.507-0.3755-2.864-1.0891-4.07-2.1406-1.13-1.0515-2.034-2.441-2.713-4.1685-0.678-1.8026-1.017-4.0182-1.017-6.647v-39.77h-6.104v-0.676l16.391-14.083h1.13v12.731h14.582v2.0279h-14.582v39.432c0 5.558 2.638 8.337 7.913 8.337 1.959 0 3.617-0.2629 4.973-0.7887 1.357-0.6008 2.186-0.9764 2.487-1.1266l0.339 0.4507c-1.582 2.1781-3.617 3.9056-6.104 5.1824-2.411 1.2769-5.199 1.9153-8.365 1.9153z"/>
                            <path d="m273.54 13.519c0 1.8777-0.678 3.4926-2.034 4.8445-1.282 1.2768-2.864 1.9153-4.748 1.9153s-3.504-0.6385-4.861-1.9153c-1.281-1.3519-1.921-2.9668-1.921-4.8445s0.64-3.4925 1.921-4.8444c1.357-1.352 2.977-2.0279 4.861-2.0279s3.466 0.67597 4.748 2.0279c1.356 1.3519 2.034 2.9667 2.034 4.8444zm-14.469 73.906c0.754-3.0794 1.357-6.2339 1.809-9.4636 0.527-3.2296 0.791-7.2855 0.791-12.168v-12.844c0-3.6051-0.527-6.5344-1.582-8.7876-0.98-2.3283-2.148-4.2436-3.505-5.7458v-0.7886l16.391-5.9711v34.024 6.647c0.075 1.9528 0.188 3.793 0.339 5.5204 0.226 1.7275 0.49 3.3799 0.791 4.9572 0.302 1.5021 0.754 3.0419 1.357 4.6191v0.2253h-16.391v-0.2253z"/>
                            <path d="m298.9 87.651h-16.39v-0.2253c0.527-1.5772 0.942-3.117 1.243-4.6191 0.377-1.5022 0.641-3.0794 0.791-4.7318 0.227-1.7275 0.377-3.5677 0.453-5.5205 0.075-2.0279 0.113-4.2811 0.113-6.7597v-13.294c0-3.7554-0.528-6.7597-1.583-9.013-0.98-2.2532-2.148-4.1309-3.504-5.6331v-0.2253l15.938-5.9711v10.816l0.453 0.1126c2.411-2.9292 5.049-5.3702 7.912-7.323 2.864-2.0279 6.293-3.0419 10.287-3.0419 5.2 0 9.156 1.4646 11.869 4.3939 2.713 2.9292 4.069 6.9099 4.069 11.942v17.125 6.8723c0.076 1.9528 0.189 3.793 0.34 5.5205 0.226 1.6524 0.489 3.2296 0.791 4.7318 0.377 1.5021 0.866 3.0419 1.469 4.6191v0.2253h-16.39v-0.2253c0.979-3.0794 1.62-6.2715 1.921-9.5763 0.377-3.3047 0.565-7.323 0.565-12.055v-14.646c0-1.5773-0.188-3.0795-0.565-4.5065-0.377-1.5022-0.979-2.8166-1.808-3.9432s-1.922-1.9904-3.278-2.5912c-1.282-0.676-2.864-1.014-4.748-1.014-2.412 0-4.672 0.5258-6.782 1.5773-2.111 0.9764-3.995 2.3283-5.652 4.0558v20.955c0 4.882 0.113 8.9754 0.339 12.28 0.301 3.2297 1.017 6.3842 2.147 9.4636v0.2253z"/>
                            <path d="m360.52 68.611c1.809 0 3.354-0.4131 4.635-1.2393 1.356-0.9013 2.412-2.103 3.165-3.6052 0.829-1.5773 1.432-3.3799 1.809-5.4078 0.377-2.103 0.565-4.3938 0.565-6.8724 0-2.4785-0.188-4.7693-0.565-6.8723-0.377-2.1031-0.98-3.9057-1.809-5.4078-0.753-1.5773-1.809-2.779-3.165-3.6052-1.281-0.9013-2.864-1.3519-4.748-1.3519s-3.466 0.4506-4.747 1.3519c-1.281 0.8262-2.336 2.0279-3.165 3.6052-0.754 1.5021-1.319 3.3047-1.696 5.4078-0.301 2.103-0.452 4.3938-0.452 6.8723 0 2.4786 0.188 4.7694 0.565 6.8724 0.377 2.0279 0.942 3.8305 1.696 5.4078 0.829 1.5022 1.884 2.7039 3.165 3.6052 1.356 0.8262 2.939 1.2393 4.747 1.2393zm28.938 26.476c-0.075 2.4035-0.791 4.6943-2.147 6.8723-1.281 2.178-3.165 4.056-5.652 5.633-2.487 1.653-5.615 2.967-9.383 3.943-3.692 0.977-7.95 1.465-12.773 1.465-3.542 0-6.858-0.3-9.947-0.901-3.015-0.526-5.615-1.352-7.8-2.479-2.186-1.126-3.919-2.478-5.2-4.056-1.206-1.577-1.809-3.38-1.809-5.407 0-1.4275 0.302-2.7419 0.905-3.9436 0.603-1.1267 1.394-2.1406 2.374-3.0419 1.055-0.8262 2.223-1.5397 3.504-2.1406 1.281-0.5257 2.6-0.9764 3.956-1.3519-1.959-0.7511-3.542-1.8026-4.747-3.1546-1.131-1.427-1.696-3.3047-1.696-5.6331 0-1.7275 0.339-3.2672 1.017-4.6191 0.679-1.352 1.545-2.5161 2.6-3.4925 1.131-1.0516 2.412-1.9153 3.844-2.5913 1.431-0.6759 2.901-1.2017 4.408-1.5772-3.542-1.5773-6.405-3.8681-8.591-6.8724-2.185-3.0043-3.278-6.4218-3.278-10.252 0-2.7038 0.565-5.22 1.696-7.5483 1.13-2.4035 2.637-4.4689 4.521-6.1964 1.959-1.7275 4.22-3.0795 6.782-4.0559 2.638-0.9764 5.426-1.4646 8.365-1.4646s5.69 0.5258 8.252 1.5773c2.638 0.9764 4.936 2.3284 6.896 4.0558l14.356-8.337 0.226 0.1127v10.027h-0.452l-12.548-0.2253c1.507 1.6524 2.675 3.4925 3.504 5.5204 0.905 2.028 1.357 4.2061 1.357 6.5344 0 2.6288-0.565 5.1074-1.696 7.4357-1.13 2.3284-2.675 4.3563-4.634 6.0838-1.884 1.7275-4.145 3.117-6.783 4.1685-2.637 0.9764-5.426 1.4646-8.365 1.4646-1.507 0-2.939-0.1127-4.295-0.338-1.281-0.3004-2.562-0.676-3.843-1.1266-1.884 0.9013-3.203 1.9152-3.957 3.0419-0.678 1.0515-1.017 2.103-1.017 3.1545 0 2.103 1.017 3.5301 3.052 4.2811 2.035 0.676 4.785 1.0891 8.252 1.2393l11.304 0.338c2.562 0.0751 5.049 0.4131 7.46 1.014 2.412 0.6008 4.522 1.4646 6.33 2.5912 1.809 1.1266 3.203 2.5161 4.183 4.1685 1.055 1.7275 1.545 3.7554 1.469 6.0837zm-25.32 13.97c6.33 0 11.04-0.901 14.13-2.704 3.165-1.803 4.747-4.093 4.747-6.8724 0-1.352-0.377-2.5162-1.13-3.4926-0.678-0.9013-1.658-1.6523-2.939-2.2532-1.206-0.5258-2.675-0.9389-4.409-1.2393-1.658-0.2253-3.429-0.3755-5.313-0.4506l-12.208-0.4507c-1.733-0.0751-3.429-0.2253-5.087-0.4506-1.658-0.1503-3.24-0.4507-4.747-0.9013-0.754 0.6759-1.432 1.5772-2.035 2.7039-0.527 1.1266-0.791 2.5161-0.791 4.1685 0 3.8303 1.695 6.7593 5.087 8.7873 3.391 2.103 8.289 3.155 14.695 3.155z"/>
                            <path d="m399.12 88.214c-2.11 0-3.918-0.7511-5.425-2.2533-1.432-1.5021-2.148-3.2672-2.148-5.2951 0-2.1781 0.716-3.9807 2.148-5.4078 1.507-1.5021 3.315-2.2532 5.425-2.2532 2.035 0 3.806 0.7511 5.313 2.2532 1.507 1.4271 2.261 3.2297 2.261 5.4078 0 2.0279-0.754 3.793-2.261 5.2951-1.507 1.5022-3.278 2.2533-5.313 2.2533z"/>
                            <path d="m438.95 81.793c2.939 0 5.501-0.5633 7.687-1.6899 2.261-1.1266 4.145-2.5912 5.652-4.3938v-28.954c-0.528-2.4034-1.244-4.3938-2.148-5.9711-0.904-1.6523-1.959-2.9292-3.165-3.8305-1.13-0.9764-2.374-1.6523-3.73-2.0279-1.281-0.4506-2.562-0.6759-3.844-0.6759-2.486 0-4.747 0.6384-6.782 1.9152-1.959 1.2017-3.655 2.9292-5.087 5.1825-1.356 2.1781-2.411 4.8069-3.165 7.8863-0.753 3.0794-1.13 6.4593-1.13 10.14 0 6.7597 1.281 12.205 3.843 16.336 2.638 4.0558 6.594 6.0837 11.869 6.0837zm13.452-3.8305c-0.829 1.5022-1.884 2.9292-3.165 4.2812-1.206 1.3519-2.638 2.5536-4.296 3.6052-1.582 1.0515-3.391 1.8777-5.426 2.4785-1.959 0.676-4.107 1.014-6.443 1.014-3.316 0-6.33-0.6384-9.043-1.9153-2.637-1.3519-4.898-3.1921-6.782-5.5204-1.884-2.3284-3.354-5.0698-4.409-8.2243-0.979-3.2297-1.469-6.7222-1.469-10.478 0-4.0558 0.603-7.9615 1.808-11.717 1.281-3.7554 3.165-7.0601 5.652-9.9142s5.577-5.1074 9.269-6.7597c3.693-1.7275 7.951-2.5913 12.774-2.5913 2.185 0 4.22 0.1878 6.104 0.5633 1.959 0.3756 3.73 0.8638 5.313 1.4647v-13.407c0-3.7554-0.528-6.7597-1.583-9.013-0.979-2.2532-2.147-4.1309-3.504-5.6331v-0.22532l16.391-5.9711v63.654c0 3.8305 0.075 6.9475 0.226 9.351 0.226 2.4034 0.527 4.3938 0.904 5.9711 0.452 1.5021 0.98 2.7039 1.583 3.6052 0.678 0.9013 1.507 1.765 2.487 2.5912v0.2253l-16.052 3.6052v-11.041h-0.339z"/>
                            <path d="m474.15 87.426c0.753-1.5772 1.356-3.4925 1.808-5.7457 0.452-2.2533 0.679-5.4829 0.679-9.689v-51.261c0-3.6803-0.528-6.647-1.583-8.9003-0.98-2.2532-2.148-4.1309-3.504-5.6331v-0.22532l16.39-5.9711v71.878c0 4.206 0.227 7.4732 0.679 9.8016 0.527 2.3283 1.205 4.2436 2.034 5.7457v0.2253h-16.503v-0.2253zm34.138 0.2253-19.443-27.94 12.999-14.083c1.809-1.9528 3.015-3.9807 3.618-6.0837 0.602-2.1782 0.452-3.9808-0.453-5.4078v-0.2253h14.695v0.2253c-3.391 1.5022-6.367 3.4174-8.93 5.7458-2.562 2.2532-5.011 4.6191-7.347 7.0977l-5.878 6.4217 16.617 23.884c1.733 2.4035 3.315 4.4314 4.747 6.0838s3.128 3.0043 5.087 4.0558v0.2253h-15.712z"/>
                        </svg>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="left-col" width="50%" style="vertical-align: top; text-align: left;">
                        <h4 class="" style="font-family: 'Rubik', 'Inter', 'Comic Sans', sans-serif; font-size: 20px; color: #1b4949;">Greeting.dk</h4>
                        <?php
                        wp_nav_menu(
                            array(
                                'menu' => 'Footer Menu',
                                'theme_location' => 'footer-menu',
                                'container' => 'ul',
                                'menu_class' => 'list-unstyled footer-menu mb-0',
                                'depth' => '1',
                                'fallback_cb'    => false, // Do not fall back to wp_page_menu(),
                                'add_li_class' => 'pb-1 menu-item',
                                'add_a_class' => 'text-white'
                            )
                        );
                        ?>
                    </td>
                    <td valign="top" class="right-col" width="50%"style="vertical-align: top; text-align: right;">
                        <h4 class="" style="font-family: 'Rubik', 'Inter', 'Comic Sans', sans-serif; font-size: 20px; color: #1b4949;"><?php echo get_field('greeting_info_footer_heading', 'options'); ?></h4>
                        <p style="color: #ffffff;">
                            <?php echo get_field('greeting_info_text', 'options'); ?>
                        </p>
                        <p style="color: #ffffff;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#1b4949" class="me-1 bi bi-envelope" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l3.235 1.94a2.76 2.76 0 0 0-.233 1.027L1 5.384v5.721l3.453-2.124c.146.277.329.556.55.835l-3.97 2.443A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741l-3.968-2.442c.22-.28.403-.56.55-.836L15 11.105V5.383l-3.002 1.801a2.76 2.76 0 0 0-.233-1.026L15 4.217V4a1 1 0 0 0-1-1H2Zm6 2.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z"/>
                            </svg>
                            <a href="mailto:<?php echo get_field('greeting_contact_mail_address', 'option'); ?>" class="text-white" style="font-size: 0.9em;"><?php echo get_field('greeting_contact_mail_address', 'option'); ?></a>
                        </p>
                        <p style="color: #ffffff;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#1b4949" class="me-1 bi bi-telephone" viewBox="0 0 16 16">
                                <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                            </svg>
                            <a href="tel:+45<?php echo get_field('greeting_contact_phone_number', 'option'); ?>" class="text-white" style="font-size: 0.9em;">(+45) <?php echo trim(strrev(chunk_split(strrev( get_field('greeting_contact_phone_number', 'option') ),2, ' '))); ?></a>
                        </p>
                        <p style="text-align: right;">
                            <a href="https://www.facebook.com/greeting.dk" class="text-white" style="display: inline-block; float: right;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="currentColor" class="float-end bi bi-facebook" viewBox="0 0 18 18">
                                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                </svg>
                            </a>
                            <a href="https://www.instagram.com/greeting.dk/" style="display: inline-block; float: right;">
                                <figure class="rounded-circle text-center" style="display: inline-block; background-color: #ffffff; width: 40px; height: 40px; padding: 7px; margin: 0 5px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="#446a6b" class="bi bi-instagram" viewBox="0 0 16 16">
                                        <path color="#446a6b" d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                                    </svg>
                                </figure>
                            </a>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!--[if gte mso 9]></td></tr></table><![endif]-->
<?php
#get_footer();
