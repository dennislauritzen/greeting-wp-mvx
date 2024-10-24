<?php


/**
 *
 * Add photos to order e-mails
 *
 * @author Dennis Lauritzen
 * @since v1.0
 */
function greeting_modify_wc_order_emails( $args ) {

    // bail if this is sent to the admin
    #if ( $args['sent_to_admin'] ) {
    #    return $args;
    #}
    $args['show_sku'] = false;
    $args['show_image'] = true;
    $args['image_size'] = array( 100, 100 );

    return $args;
}
add_filter( 'woocommerce_email_order_items_args', 'greeting_modify_wc_order_emails' );

/**
 * Function for customizing subject of Order Completed mail
 *
 * @since 1.0.1
 * @author Dennis Lauritzen
 *
 */
add_filter( 'woocommerce_email_subject_customer_completed_order', 'custom_email_subject_completed', 20, 2 );
function custom_email_subject_completed( $formated_subject, $order ){
    $data = $order->get_data();

    # $inv_name = $data['billing']['first_name'];
    $delivery_name = $data['shipping']['first_name'];
    $shop_id = get_field('greeting_marketplace_order_shop_id', $data['id']);
    $delivery_type = get_field('delivery_type','user'.$shop_id);
    # $greeting_store_name = get_field('company_name', 'options');

    # 0 = delivery with post, 1 = personal delivery
    $del_value = '';
    $del_type = '';
    if(empty($delivery_type['label'])){
        $del_value = $delivery_type;
        $del_type = $delivery_type;
    } else {
        $del_value = $delivery_type['value'];
        $del_type = $delivery_type['label'];
    }

    if($del_value == "1")
    {
        // Personal delivery
        return __( 'Din gave til '.$delivery_name.' er nu leveret 🎁', 'woocommerce' );
    } else {
        // Delivery by courier
        return __( 'Din gave til '.$delivery_name.' 🎁', 'woocommerce' );
    }
}

/**
 *
 * Function for making sure the vendor doesnt get an email if the order is cancelled.
 *
 * @author Dennis Lauritzen
 * @paused by Dennis 25/06-22
 * @todo - TEST!!!!!
 * @important!!! TEst this before launch
 *
 * @param $recipient
 * @param $order
 * @return mixed|void
 */
function restrict_vendor_new_order_mail($recipient, $order) {
    $order_status = $order == NULL ? "cancelled" : $order->get_status();

    if ( $order_status == 'processing') {
        return $recipient ;
    } else {
        return;
    }

    # original code...
    #$order_status = $order == NULL ? "cancelled": $order->get_status();
    //In new order,vendor will receive only 'processing' mail no other mail will send to vendor.
    #if ($order_status == 'failed' || $order_status == 'on-hold' || $order_status == 'cancelled' || $order_status == 'pending' && !$order_status == 'processing') {
    #    return;
    #} else {
    #    return $recipient;
    #}
}
add_filter('woocommerce_email_recipient_vendor_new_order', 'restrict_vendor_new_order_mail', 1, 2);


/**
 * Function for vendor new order template
 *
 * @author Dennis Lauritzen
 * @paused by Dennis 25/06-22
 */
#add_action('woocommerce_order_status_changed', 'woo_order_status_change_custom', 100, 3);
function woo_order_status_change_custom( $order_id, $from_status, $to_status ) {
    if( !$order_id ) return;
    if( wp_get_post_parent_id( $order_id )) return;

    if($to_status == 'processing'){
        $emails = WC()->mailer()->emails;
        $email_vendor = $emails['WC_Email_Vendor_New_Order']->trigger( $order_id );
    }
}


/**
 * Add a custom quantity text to e-mails
 *
 * @param $quantity_html
 * @param $item
 * @param $item_id
 * @param $order
 * @return string
 */
function custom_order_item_quantity_html($quantity_html) {
    $quantity = $quantity_html . ' stk.';
    // Return the modified quantity HTML
    return $quantity;
}
add_filter('mvx_order_item_quantity_text', 'custom_order_item_quantity_html', 10, 4);


/**
 * Add a custom field (in an order) to the emails-old
 *
 * @since v1.0
 * @author Dennis
 */
function custom_woocommerce_email_order_meta_fields( $fields, $sent_to_admin, $order ) {
	if( is_wc_hpos_activated() ){
	# DELIVERY DATE
		$del_date = $order->get_meta('_delivery_date');
		$delivery_date = (!empty($del_date) ? $del_date : 'Hurtigst muligt');

		# GREETING MESSAGE
		$greeting_message = $order->get_meta('_greeting_message');

		# LEAVE GIFT
		$leave_gift_at_address = ($order->get_meta('_leave_gift_address') == "1" ? 'Ja' : 'Nej');
		$leave_gift_at_neighbour = ($order->get_meta('_leave_gift_neighbour') == "1" ? 'Ja' : 'Nej');

		# DELIVERY INSTRUCTIONS
		$delivery_instructions = $order->get_meta('_delivery_instructions');

		# RECEIVER PHONE
		$receiver_phone = $order->get_meta('_receiver_phone');
	} else {
		# DELIVERY DATE
		$del_date = get_post_meta( $order->get_id(), '_delivery_date', true );
		$delivery_date = (!empty($del_date) ? $del_date : 'Hurtigst muligt');

		# GREETING MESSAGE
		$greeting_message = get_post_meta( $order->get_id(), '_greeting_message', true );

		# LEAVE GIFT
		$leave_gift_at_address = (get_post_meta( $order->get_id(), '_leave_gift_address', true ) == "1" ? 'Ja' : 'Nej');
		$leave_gift_at_neighbour = (get_post_meta( $order->get_id(), '_leave_gift_neighbour', true ) == "1" ? 'Ja' : 'Nej');

		# DELIVERY INSTRUCTIONS
		$delivery_instructions = get_post_meta( $order->get_id(), '_delivery_instructions', true );

		# RECEIVER PHONE
		$receiver_phone = get_post_meta( $order->get_id(), '_receiver_phone', true );
	}


    $fields['delivery_date'] = array(
        'label' => __( 'Leveringsdato' ),
        'value' => $delivery_date,
    );
    $fields['billing_phone'] = array(
        'label' => __( 'Afsenders telefonnr.' ),
        'value' => $order->get_billing_phone(),
    );


    $fields['greeting_message'] = array(
        'label' => __( 'Besked til modtager' ),
        'value' => get_post_meta( $order->get_id(), '_greeting_message', true ),
    );

    $fields['leave_gift_address'] = array(
        'label' => __( 'Efterlad gaven på adressen' ),
        'value' => $leave_gift_at_address
    );

    $fields['leave_gift_neighbour'] = array(
        'label' => __( 'Gaven må afleveres til naboen' ),
        'value' => $leave_gift_at_neighbour,
    );
    $fields['delivery_instructions'] = array(
        'label' => __( 'Leveringsinstruktioner' ),
        'value' => $delivery_instructions,
    );
    $fields['receiver_phone'] = array(
        'label' => __( 'Modtagers telefonnr.' ),
        'value' => $receiver_phone,
    );

    return $fields;
}
add_filter( 'woocommerce_email_order_meta_fields', 'custom_woocommerce_email_order_meta_fields', 10, 3 );
#do_action('mvx_checkout_vendor_order_processed', $vendor_order_id, $posted_data, $order);

/**
 * Add product image heading to e-mail new vendor order #mails #transactional
 *
 * @access public
 * @author Dennis Lauritzen
 * @return void
 */
add_action('mvx_before_vendor_order_table_header', 'add_prod_img_heading_to_vendor_email', 10, 4);
function add_prod_img_heading_to_vendor_email() {
    $str = '<th scope="col" style="text-align: left; width: 10%; border: 1px solid #eee;">';
    $str .= '';
    $str .= '</th>';

    echo wp_kses_post( $str  );
}

/**
 * Add product image to e-mail new vendor order #mails #transactional
 *
 * @access public
 * @author Dennis Lauritzen
 * @return void
 */
add_action('mvx_before_vendor_order_item_table', 'add_prod_img_to_vendor_email', 10, 4);
function add_prod_img_to_vendor_email($item, $order, $vendor_id, $is_ship) {
    $product = wc_get_product( $item['product_id'] );
    $mvx_product_img = $product->get_image( array( 100, 100 ));
    $str = '<td scope="col" style="width: 20%; text-align:left; border: 1px solid #eee;">';
    $str .= $mvx_product_img;
    $str .= '</td>';

    echo wp_kses_post( $str  );
}


function add_notes_to_vendor_order_item_table( $name, $item ) {
    $product = new WC_Product($item->get_product_id());

    $name .= '';
    $note = wc_get_order_item_meta( $item->get_id(), '_custom_note', true ); // Retrieve the note meta data
    $name .= '<br><span style="display: inline-block; padding-top:10px; font-size:12px;">'. __('Ønske til gavens indhold','greeting3') . ': '.$note.'</span>';
    return $name;
}
add_filter( 'woocommerce_order_item_name', 'add_notes_to_vendor_order_item_table', 10, 2 );


/**
 * Remove sold by from vendor mails and admin mails
 *
 * Dennis: I am not sure, this is actually in use.
 *
 * @param $html
 * @param $item
 * @param $args
 * @return string
 */
function mvx_email_change_sold_by_text($html, $item, $args ){
    $strings = array();
    $html    = '';
    foreach ( $item->get_formatted_meta_data() as $meta_id => $meta ) {
        $value = $args['autop'] ? wp_kses_post( $meta->display_value ) : wp_kses_post( make_clickable( trim( $meta->display_value ) ) );
        if (0 !== strcasecmp( $meta->display_key, 'Sold By' ) ) {
            $strings[] = $args['label_before'] . wp_kses_post( $meta->display_key ) . $args['label_after'] . $value;
        }
    }

    if ( $strings ) {
        $html = $args['before'] . implode( $args['separator'], $strings ) . $args['after'];
    }

    return $html;
}
add_filter( 'woocommerce_display_item_meta','mvx_email_change_sold_by_text', 10, 3 );

