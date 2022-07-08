<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template.
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/taxonomy-dc_vendor_shop.php
 *
 * @author 		WC Marketplace
 * @package 	WCMp/Templates
 * @version   	3.7
 */
global $WCMp;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Get vendor
$vendor_id = wcmp_find_shop_page_vendor();
$vendor = get_wcmp_vendor($vendor_id);
if(!$vendor){
  // Redirect if not vendor
  #wp_safe_redirect(get_permalink( woocommerce_get_page_id( 'shop' ) ));

	wp_safe_redirect( home_url() );
	exit();
}

$is_block = get_user_meta($vendor->id, '_vendor_turn_off' , true);
$user_type = get_user_meta($vendor->id, 'wp_capabilities');

if($is_block && (!empty($user_type) && $user_type[0]['dc_vendor'] !== true)) {
	wp_safe_redirect( home_url() );
} else {
	$WCMp->template->get_store_template('wcmp-archive-page-vendor.php');
}
