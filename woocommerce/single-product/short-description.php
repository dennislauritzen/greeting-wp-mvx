<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		Automattic
 * @package 	WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );
$description = $post->post_content;



if ( ! $short_description && ! $description ) {
	return;
}

// Go through the descriptions to make the links.
$short_description_new = add_links_to_keywords(
    wp_kses_post( $short_description ),
    array('product_cat', 'occasion')
);

$description_new = add_links_to_keywords(
    $description,
    array('product_cat', 'occasion')
);

?>
<div class="description">
	<?php echo $short_description_new; // WPCS: XSS ok.  ?>
	<?php echo $description_new; ?>
</div>
