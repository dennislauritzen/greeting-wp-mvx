<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || false === wc_get_loop_product_visibility( $product->get_id() ) || ! $product->is_visible() ) {
	return;
}

// Extra post classes
$classes = array('prod_hold');
?>
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10 - removed
	 */
    //do_action('woocommerce_before_shop_loop_item'); ?>
		<div class="col-6 col-md-3">
			<div class="card mb-4 border-0">
					<a href="<?php the_permalink(); ?>">
						<?php
						$uploadedImage = wp_get_attachment_image_url($product->get_image_id(), 'medium');
						$img_src = wc_placeholder_img_src();
						if(!empty($uploadedImage)){
							$img_src = $uploadedImage;
						} ?>
							<img
							width="370"
							height="370"
							src="<?php echo $img_src; ?>"
							class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
							alt=""
							loading="lazy">
					</a>
					<div class="card-body">
							<h6 class="card-title" style="font-size: 12px;">
								<a href="<?php the_permalink(); ?>" class="text-dark">
									<?php echo $product->get_name(); ?>
								</a>
							</h6>
							<?php
								/**
								 * Hook: woocommerce_after_shop_loop_item_title.
								 *
								 * @hooked woocommerce_template_loop_rating - 5
								 * @hooked woocommerce_template_loop_price - 10 (removed by rigid)
								 */

								#do_action('woocommerce_after_shop_loop_item_title'); ?>
							<small><?php woocommerce_template_loop_price(); ?></small>
					</div>
			</div>
		</div>
		<?php
		/**
		 * Hook: woocommerce_after_shop_loop_item.
		 *
		 * @hooked woocommerce_template_loop_product_link_close - 5
		 * @hooked woocommerce_template_loop_add_to_cart - 10 (removed by rigid when list view is selected)
		 *
		 *
		 * @author Dennis Lauritzen - Removed this action since we don't want add to cart button on related products
		 */
		//do_action('woocommerce_after_shop_loop_item');
		?>
