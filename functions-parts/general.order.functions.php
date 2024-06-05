<?php

/**
 * Get hash values for a given order ID
 *
 * @param $order_id
 * @return array
 */
function get_order_hashes($order_id){
    $oh = hash('md4','gree_ting_dk#!4r1242142fgriejgfto'.$order_id.$order_id);
    $sshh = hash('md4', 'vvkrne12onrtnFG_:____'.$order_id);

    return array(
        'oh' => $oh,
        'sshh' => $sshh
    );
}

/**
 * Function for using order object to get Vendor ID.
 *
 * @author Dennis Lauritzen
 * @param \WC_Order $order
 * @return Integer $vendor_id
 */
function greeting_get_vendor_id_from_order( $order ){
    $vendor_id = 0;
    foreach ($order->get_items() as $item_key => $item) {
        $product = get_post($item['product_id']);
        $vendor_id = $product->post_author;
        if(!empty($vendor_id) && $vendor_id != 0){
            break;
        }
    }

    return $vendor_id;
}


/**
 * Get parent orders for a vendor ID.
 *
 * @param $vendor_id
 * @return array
 */
function get_vendor_parent_order($vendor_id) {
    $return_orders = array();

    $vendor_orders = get_posts( array(
        'fields'      => 'all',          // Retrieve only post IDs
        'numberposts' => -1,
        'meta_key'    => '_vendor_id',
        'meta_value'  => $vendor_id,
        'post_type'   => 'shop_order',
        'post_status' => 'any',
    ) );

    foreach( $vendor_orders as $vendor_order ) {
        if ( wc_get_order( $vendor_order->ID )->get_parent_id() === 0 ) {
            // This is a parent order
            $return_orders[] = $vendor_order->ID;
        }
    }
#print "<div>";var_dump($return_orders);print "</div>";
    return $return_orders;
}