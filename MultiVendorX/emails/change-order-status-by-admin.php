<?php
/**
 * The template for displaying demo plugin content.
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/emails-old/change-order-status-by-admin.php
 *
 * @author 		WC Marketplace
 * @package 	dc-product-vendor/Templates
 * @version   	3.7.2
 */


if ( !defined( 'ABSPATH' ) ) exit;  ?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

	<p><?php printf( esc_html__( "Hi there! This is to notify that an order #%s status has been changed on %s.",  'dc-woocommerce-multi-vendor' ), $order_id, get_option( 'blogname' ) ); ?></p>

<?php do_action( 'mvx_email_footer' ); ?>