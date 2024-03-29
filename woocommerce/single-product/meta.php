<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
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
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/** @var WC_Product $product */
global $post, $product;
?>
<?php do_action( 'woocommerce_product_meta_start' ); ?>
<?php
    $categories = wc_get_product_category_list( $product->get_id() );
    $size_categories = 0;
    $arr_categories = get_the_terms( $post->ID, 'product_cat' );
    if(is_array($arr_categories)) {
        $size_categories = count($arr_categories);
    }

    $tags = wc_get_product_tag_list( $product->get_id());
    $size_tags = 0;
    $arr_tags = get_the_terms( $post->ID, 'product_tag' );
    if(is_array($arr_tags)) {
        $size_tags = count($arr_tags);
    }

    if($categories) echo '<p class="posted_in">'._n('Category:', 'Categories:', $size_categories, 'greeting2').' '.$categories.'</p>';

    if($tags) echo '<p class="tagged_as">'._n('Tag:', 'Tags:', $size_tags, 'greeting2').' '.$tags.'</p>';
?>
<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

<p class="sku_wrapper"><?php esc_html_e( 'SKU:', 'greeting2' ); ?> <span class="sku"><?php if( $sku = $product->get_sku() ) echo esc_html($sku); else esc_html_e( 'N/A', 'greeting2' ); ?></span></p>

<?php endif; ?>
<?php do_action( 'woocommerce_product_meta_end' ); ?>
