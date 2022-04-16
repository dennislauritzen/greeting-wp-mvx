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

// Hover Product Behaviour on Product List - product_hover_onproduct
if ( rigid_get_option( 'product_hover_onproduct' ) != 'none' ) {
    // Check if swap effect is selected but second image is not present
	if ( ! ( rigid_get_option( 'product_hover_onproduct' ) == 'rigid-prodhover-swap' && ! rigid_get_second_product_image_id( $product ) ) ) {
		$classes[] = rigid_get_option( 'product_hover_onproduct' );
	}
}
// Manage Buttons Visibility on Listings
$classes[] = rigid_get_option('product_list_buttons_visibility');

// Accent Shadow on Hover for Product Lists
if(rigid_get_option('products_hover_shadow')) {
    $classes[] = 'rigid-products-hover-shadow';
}

?>
<div <?php wc_product_class( $classes, $product ); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10 - removed
	 */
    do_action('woocommerce_before_shop_loop_item'); ?>
	<div class="rigid-list-prod-summary">
		<?php rigid_display_attributes_in_listings(); ?>
		<a class="wrap_link" href="<?php the_permalink(); ?>">
			<span class="name">
				<?php if (rigid_get_option('shop_default_product_columns') == 'rigid-products-list-view'): ?>
					<?php echo rigid_short_product_title(get_the_title()); ?>
				<?php else: ?>
					<?php echo rigid_short_product_title(get_the_title(), 35); ?>
				<?php endif; ?>
			</span>
		</a>
		<?php woocommerce_template_loop_price() ?>
	</div>
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 *
	 */
	do_action('woocommerce_before_shop_loop_item_title');

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10 (removed by rigid)
	 */
	do_action('woocommerce_after_shop_loop_item_title');
	?>

	<?php
	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10 (removed by rigid when list view is selected)
	 */
	do_action('woocommerce_after_shop_loop_item');
	?>

</div>
