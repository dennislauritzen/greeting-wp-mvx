<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;


global $woocommerce, $wpdb, $WCMp;

$postId = get_the_ID();

$checkout_postalcode = WC()->customer->get_shipping_postcode();
#if($cityPostalcode != $checkout_postalcode){
  #print 'postnumre afviger';
#  $woocommerce->cart->empty_cart();
#}


// Get header designs.
get_header();
get_header('green', array());
?>

<?php
get_footer('shop');
