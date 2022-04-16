<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce\Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<form role="search" method="get" id="searchform" action="<?php echo esc_url(rigid_wpml_get_home_url()); ?>">
	<div>
		<input type="text" value="<?php echo esc_attr(get_search_query()); ?>" name="s" id="s" data-swplive="true" placeholder="<?php esc_attr_e('Search Products', 'rigid'); ?>" />
		<?php
		if ( rigid_get_option( 'filter_by_product_category' ) ) {
			$rigid_categories_depth = 0;
			if ( rigid_get_option( 'filter_by_product_category_top' ) ) {
				$rigid_categories_depth = 1;
			}
			$rigid_categories_args = array(
				'show_option_none' => esc_html__( 'All Categories', 'rigid' ),
				'depth'            => $rigid_categories_depth
			);
			wc_product_dropdown_categories( $rigid_categories_args );
		}
        ?>
        <input type="submit" id="searchsubmit" value="<?php esc_attr_e('Search Products', 'rigid') ?>" />
		<input type="hidden" name="post_type" value="product" />
	</div>
</form>