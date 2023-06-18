<?php
/**
 * The template for displaying demo plugin content.
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/emails/vendor-new-order.php
 * THIS IS THE WORKING MAIL TEMPLATE
 *
 * From Dennis Lauritzen - this is the active vendor-new-order template
 * @author 		WC Marketplace
 * @package 	dc-product-vendor/Templates
 * @version   0.0.1
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
global $WCMp;
$vendor = get_wcmp_vendor(absint($vendor_id));
do_action( 'woocommerce_email_header', $email_heading, $email );
$text_align = is_rtl() ? 'right' : 'left';

$parent_order_id = (empty(wp_get_post_parent_id($order->get_id())) ? $order->get_id() : wp_get_post_parent_id($order->get_id()));

// The different number orders
$latestOrderId = $parent_order_id; // Last order ID
$order_hash = hash('md4','gree_ting_dk#!4r1242142fgriejgfto'.$latestOrderId.$latestOrderId);
$order_hash2 = hash('md4', 'vvkrne12onrtnFG_:____'.$latestOrderId);

$codeContents = site_url().'/shop-order-status/?order_id='.$latestOrderId.'&oh='.$order_hash.'&sshh='.$order_hash2;
$qrcode = 'https://chart.googleapis.com/chart?chs=135x135&cht=qr&chl='.$codeContents;
?>

<div style="margin-top: 0px;">
  <a href="<?php echo $codeContents; ?>">
    <img src="<?php echo $qrcode; ?>" alt="" style="width:150px;"/>
    Markér ordre som leveret
  </a>
</div>

<?php
  $main_order = (empty(get_post_parent($order->get_id())) ? $order->get_id() : get_post_parent($order->get_id()) );
  $main_order_object = wc_get_order($main_order);
  $main_order_ID_str = ( empty($main_order_object->get_id())  ? $main_order->ID : $main_order_object->get_id() );
  $main_order_id = (empty(get_post_parent($order->get_id())) ? $order->get_id() : $main_order_ID_str );
?>
<p>Ordrenr.: #<?php echo $main_order_id; ?> (Sub-ordre ID: #<?php echo $order->get_id(); ?>)</p>
<p><p><?php printf(esc_html__('A new order was received and marked as %s from %s. Their order is as follows:', 'dc-woocommerce-multi-vendor'), $order->get_status( 'edit' ), $order->get_billing_first_name() . ' ' . $order->get_billing_last_name()); ?></p></p>

<?php do_action('woocommerce_email_before_order_table', $order, true, false, $email); ?>
<table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
    <thead>
        <tr>
            <?php do_action('wcmp_before_vendor_order_table_header', $order, $vendor->term_id); ?>
            <th scope="col" style="text-align:<?php echo $text_align; ?>; width: 50%; border: 1px solid #eee;"><?php _e('Product', 'dc-woocommerce-multi-vendor'); ?></th>
            <th scope="col" style="text-align:<?php echo $text_align; ?>; width: 15%; border: 1px solid #eee;"><?php _e('Quantity', 'dc-woocommerce-multi-vendor'); ?></th>
            <th scope="col" style="text-align:<?php echo $text_align; ?>; width: 15%; border: 1px solid #eee;"><?php _e('Commission', 'dc-woocommerce-multi-vendor'); ?></th>
            <?php do_action('wcmp_after_vendor_order_table_header', $order, $vendor->term_id); ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $vendor->vendor_order_item_table($order, $vendor->term_id, true);

        ?>
    </tbody>
</table>
<?php
if (apply_filters('show_cust_order_calulations_field', true, $vendor->id)) {
    $order_total = $order->get_total();
    $order_ship_total = $order->get_shipping_total() + $order->get_shipping_tax();


    $order_new_subtotal = $order_total - $order_ship_total;
    $order_ship_new = 39;
    $order_new_total = $order_new_subtotal + $order_ship_new;
    ?>
    <table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
      <tr>
          <th scope="row" style="width: 70%; text-align:left; border: 1px solid #eee;">Fragt</th>
          <td style="width: 30%; text-align:<?php echo $text_align; ?>; border: 1px solid #eee;"><?php echo $order_ship_new; ?>,- kr.</td>
      </tr>
      <tr>
          <th scope="row" style="text-align:left; border: 1px solid #eee;">Varetotal (inkl. 25 % moms)</th>
          <td style="text-align:<?php echo $text_align; ?>; border: 1px solid #eee;">
            <?php echo $order_new_subtotal; ?> kr.<br>
          </td>
      </tr>
      <tr>
          <th scope="row" style="text-align:left; border: 1px solid #eee;">Ordretotal (inkl. 25 % moms)</th>
          <td style="text-align:<?php echo $text_align; ?>; border: 1px solid #eee;">
            <?php echo $order_new_total; ?> kr.
          </td>
      </tr>
        <?php
        #$totals = $vendor->wcmp_vendor_get_order_item_totals($order, $vendor->term_id);
        #if ($totals) {
        #    foreach ($totals as $total_key => $total) {
        ?>
        <!--<tr>
                    <th scope="row" colspan="2" style="text-align:left; border: 1px solid #eee;"><?php echo $total['label']; ?></th>
                    <td style="text-align:<?php echo $text_align; ?>; border: 1px solid #eee;"><?php echo $total['value']; ?></td>
                </tr>-->
        <?php
        #    }
        #}
        if ( $order->get_customer_note() ) {
            ?>
            <tr>
                <th class="td" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Note:', 'dc-woocommerce-multi-vendor' ); ?></th>
                <td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
    }
    if (apply_filters('show_cust_address_field', true, $vendor->id) || apply_filters( 'is_vendor_can_see_customer_details', true, $vendor->id, $order ) ) {
    ?>


    <h2><?php __('Delivery Details', 'dc-woocommerce-multi-vendor'); ?></h2>
    <?php if ( !empty(get_post_meta($parent_order_id, '_delivery_date', true)) ) { $delivery_date = get_post_meta( $parent_order_id, '_delivery_date', true ); } else { $delivery_date = 'Hurtigst muligt'; } ?>
    <p><strong><?php _e('Leveringsdato:', 'woocommerce'); ?></strong> <?php echo $delivery_date; ?></p>

    <p><strong><?php _e('Afsenders telefonnummer:', 'woocommerce'); ?></strong> <?php echo $order->get_billing_phone(); ?></p>
    <p><strong><?php _e('Modtagers telefonnummer:', 'woocommerce'); ?></strong> <?php echo get_post_meta( $parent_order_id, '_receiver_phone', true ); ?></p>

    <p><strong><?php _e('Besked til modtager', 'woocommerce'); ?></strong> <?php echo get_post_meta( $parent_order_id, '_greeting_message', true ); ?></p>

    <p><strong><?php _e('Leveringsinstruktioner', 'woocommerce'); ?></strong> <?php echo get_post_meta( $parent_order_id, '_delivery_instructions', true ); ?></p>

    <?php $leave_gift_at_address = (get_post_meta( $parent_order_id, '_leave_gift_address', true ) == "1" ? 'Ja' : 'Nej'); ?>
    <p><strong><?php _e('Må stilles på adressen:', 'woocommerce'); ?></strong> <?php echo $leave_gift_at_address; ?></p>

    <?php $leave_gift_at_neighbour = (get_post_meta( $parent_order_id, '_leave_gift_neighbour', true ) == "1" ? 'Ja' : 'Nej'); ?>
    <p><strong><?php _e('Må gaven afleveres hos naboen:', 'woocommerce'); ?></strong> <?php echo $leave_gift_at_neighbour; ?></p>

    <?php
    }
    ?>
    <table id="addresses" cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top; margin-bottom: 40px; padding:0;" border="0">
	<tr>
            <?php if (apply_filters('show_cust_billing_address_field', true, $vendor->id)) { ?>
            <td style="text-align:<?php echo $text_align; ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;" valign="top" width="50%">
                <h2><?php _e( 'Billing Address', 'dc-woocommerce-multi-vendor' ); ?></h2>
                <address class="address">
                    <?php echo ( $address = $order->get_formatted_billing_address() ) ? $address : esc_html__( 'N/A', 'dc-woocommerce-multi-vendor' ); ?>
                </address>
                <p><strong><?php _e('Email:', 'woocommerce'); ?></strong> <?php echo $order->get_billing_email(); ?></p>
            </td>
            <?php } ?>
            <?php if ( apply_filters('show_cust_shipping_address_field', true, $vendor->id) && ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && ( $shipping = $order->get_formatted_shipping_address() ) ) : ?>
                <td style="text-align:<?php echo $text_align; ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; padding:0;" valign="top" width="50%">
                        <h2><?php _e('Shipping Address', 'dc-woocommerce-multi-vendor'); ?></h2>
                        <address class="address"><?php echo $shipping; ?></address>
                </td>
            <?php endif; ?>
    </tr>
    </table>


<?php do_action('wcmp_email_footer'); ?>
