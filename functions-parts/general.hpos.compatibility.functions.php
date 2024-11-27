<?php

use Automattic\WooCommerce\Utilities\OrderUtil;

/**
 * Check is post is WooCommerce HPOS order.
 *
 * @param int $post_id Post id.
 *
 * @return bool $bool True|false.
 */
function is_wc_order( $post_id = 0 ) {
    $bool = false;
    if ( 'shop_order' === OrderUtil::get_order_type( $post_id ) ) {
        $bool = true;
    }
    return $bool;
}

/**
 * Check if HPOS is activated
 *
 * @return bool
 */
function is_wc_hpos_activated($check = '') {
    // Example check for a hypothetical constant indicating HPOS activation.
	if($check == 'meta_box') {
		if (\Automattic\WooCommerce\Utilities\OrderUtil::custom_orders_table_usage_is_enabled()) {
			return true;
		} else {
			return false;
		}
	} else if($check == 'frontend'){
		if(\Automattic\WooCommerce\Utilities\OrderUtil::custom_orders_table_usage_is_enabled()){
			return true;
		} else {
			return false;
		}
	} else {
		return defined('WC_HPOS_ACTIVATED') && WC_HPOS_ACTIVATED;
	}
}

function get_wc_hpos_order_screen_name(){
	return wc_get_container()->get( \Automattic\WooCommerce\Internal\DataStores\Orders\CustomOrdersTableController::class )->custom_orders_table_usage_is_enabled()
		? wc_get_page_screen_id( 'shop-order' )
		: 'shop_order';
}