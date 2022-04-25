<?php
/**
 * Single Product Sale Flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

 if ( ! defined( 'ABSPATH' ) ) {
 	exit; // Exit if accessed directly
 }
 global $post, $product;
 ?>

 <?php if ( $product->is_on_sale() ) : ?>

 	<?php
 	if ($product->is_type( 'simple' )) {
 		$sale_price     =  $product->get_sale_price();
 		$regular_price  =  $product->get_regular_price();
 	}
 	elseif($product->is_type('variable')){
 		$sale_price     =  $product->get_variation_sale_price( 'min', true );
 		$regular_price  =  $product->get_variation_regular_price( 'max', true );
 	}


 	$discount = round (($sale_price / $regular_price -1 ) * 100);

 	?>

 	<?php # echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale-icon"> ' . $discount . ' %</span>', $post, $product ); ?>

 <?php endif;
