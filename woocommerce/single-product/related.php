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

if ( $related_products ) : ?>

<section id="related">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 pb-5">
				<h4>💝 Andre produkter fra Slikapoteket</h4>
			</div>
			<?php woocommerce_product_loop_start(); ?>
				<?php foreach ( $related_products as $related_product ) : ?>

					<?php
					/** @var WC_Product $related_product */
					$post_object = get_post( $related_product->get_id() );

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
