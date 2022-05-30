<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) :

global $product;
$product_id = $product->get_id();
$product_meta = get_post($product_id);
$vendor_id = $product_meta->post_author;
$vendor = get_wcmp_vendor($vendor_id);
unset($product);
$vendorProducts = $vendor->get_products(array('fields' => 'all', 'posts_per_page' => 3));

?>

<section id="related">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 pb-5">
				<h4>💝 Andre produkter fra <?php echo esc_html($vendor->user_data->data->display_name); ?></h4>
			</div>
			<?php woocommerce_product_loop_start(); ?>
				<?php foreach ( $vendorProducts as $related_product ) :

					/** @var WC_Product $related_product */
					$post_object = get_post( $related_product->ID );

					// Althemist edit - removed pass by ref as it is unnecessary
					setup_postdata( $GLOBALS['post'] = $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

				<?php endforeach; ?>
			<?php woocommerce_product_loop_end(); ?>
		</div
	</div>
</section>

<?php
endif;
wp_reset_postdata();
