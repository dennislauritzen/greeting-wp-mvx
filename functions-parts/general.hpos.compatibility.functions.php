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
function is_wc_hpos_activated() {
    // Example check for a hypothetical constant indicating HPOS activation.
    return defined( 'WC_HPOS_ACTIVATED' ) && WC_HPOS_ACTIVATED;
}