<?php
/**
 * The template for displaying demo plugin content.
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/emails-old/new-admin-product.php
 *
 * @author 		WC Marketplace
 * @package 	dc-product-vendor/Templates
 * @version   0.0.1
 */


if ( !defined( 'ABSPATH' ) ) exit; 
global $MVX;
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

	<p><?php printf( esc_html__( "Hi there! This is to notify that a new product has been submitted in %s.",  'dc-woocommerce-multi-vendor' ), get_option( 'blogname' ) ); ?></p>

	<p>
		<?php printf( esc_html__( "Product title: %s",  'dc-woocommerce-multi-vendor' ), $product_name ); ?><br/>
		<?php printf( esc_html__( "Submitted by: %s",  'dc-woocommerce-multi-vendor' ), 'Site Administrator' ); ?><br/>
		<?php 
                    $product_link = apply_filters( 'mvx_email_admin_new_product_link', esc_url( mvx_get_vendor_dashboard_endpoint_url( get_mvx_vendor_settings( 'mvx_edit_product_endpoint', 'vendor', 'general', 'edit-product' ), $post_id ) ) );
			if($submit_product) {
				printf( esc_html__( "Edit product: %s",  'dc-woocommerce-multi-vendor' ), $product_link ); 
			} else {
				printf( esc_html__( "View product: %s",  'dc-woocommerce-multi-vendor' ), get_permalink($post_id)); 
			}
		?>
		<br/>
	</p>

<?php do_action( 'mvx_email_footer' ); ?>