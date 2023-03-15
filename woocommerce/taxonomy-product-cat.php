<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     4.7.0
 */

/**
 * Former code:
 * # wc_get_template( 'archive-product-to-vendorstore.php' );
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * The variable for holding the delivery_zip.
 *
 */
$delivery_zip_chosen = '';

if(empty($delivery_zip_chosen) || $delivery_zip_chosen == ''){
	wc_get_template( 'archive-product.php',
		array(
			'delivery_zip_chosen' => $delivery_zip_chosen
		)
	);
} else {
	wc_get_template( 'archive-product.php',
		array(
			'delivery_zip_chosen' => $delivery_zip_chosen
		)
	);
}
