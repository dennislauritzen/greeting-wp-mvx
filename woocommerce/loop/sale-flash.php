<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global /** @var WC_Product $product */
$post, $product;

?>
<?php if ( $product->is_on_sale() ) : ?>
	<?php if ( $product->is_type( 'combo' ) ): ?>
		<?php // echo apply_filters( 'woocommerce_sale_flash', '<span class="sale">' . esc_html__( 'save', 'rigid' ) . '</span>', $post, $product ); ?>
	<?php else: ?>
		<?php //echo apply_filters( 'woocommerce_sale_flash', '<span class="sale">' . ' -' . rigid_get_product_saving( $product ) . '%</span>', $post, $product ); ?>
	<?php endif; ?>
<?php endif; ?>
