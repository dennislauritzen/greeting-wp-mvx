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
    #$categories = wc_get_product_category_list( $product->get_id() );
    #$size_categories = 0;
    #$arr_categories = get_the_terms( $post->ID, 'product_cat' );
    #if(is_array($arr_categories)) {
    #    $size_categories = count($arr_categories);
    #}

    #$tags = wc_get_product_tag_list( $product->get_id());
    #$size_tags = 0;
    #$arr_tags = get_the_terms( $post->ID, 'product_tag' );
    #if(is_array($arr_tags)) {
    #    $size_tags = count($arr_tags);
    #}

    #if($categories) echo '<p class="posted_in">'._n('Category:', 'Categories:', $size_categories, 'greeting2').' '.$categories.'</p>';

    #if($tags) echo '<p class="tagged_as">'._n('Tag:', 'Tags:', $size_tags, 'greeting2').' '.$tags.'</p>';
?>
<?php
// Get the product categories
$categories = get_the_terms( get_the_ID(), 'product_cat' );

// Check if categories exist
if ( $categories && !is_wp_error( $categories ) ) {


    $default_category_id = get_option( 'default_product_cat' );

    echo '<div class="product-categories mt-3 mb-2">';
    echo '<span style="font-size: 14px;">Kategorier: </span>';
    foreach ( $categories as $category ) {
        if(!empty($default_category_id) && !empty($category->term_id) && $category->term_id == $default_category_id){
            continue;
        }
        $category_link = get_term_link( $category );
        echo '<a href="' . esc_url( $category_link ) . '" class="badge border border-grey text-dark me-1 mb-1 px-2 py-2 fw-normal">' . esc_html( $category->name ) . '</a>';
    }
    echo '</div>';
}
?>

<?php
// Get the product occasions
$occasions = get_the_terms( get_the_ID(), 'occasion' );

// Check if categories exist
if ( $occasions && ! is_wp_error( $categories ) ) {
    echo '<div class="product-categories mb-2">';
    echo '<span style="font-size: 14px;">Anledninger: </span>';
    foreach ( $occasions as $occasion ) {
        $occasion_link = get_term_link( $occasion );
        echo '<a href="' . esc_url( $occasion_link ) . '" class="badge border border-grey text-dark me-1 mb-1 px-2 py-2 fw-normal">' . esc_html( $occasion->name ) . '</a>';
    }
    echo '</div>';
}
?>

<?php
// Dennis added 1 === 2 so this doesn't show.
if ( 1 === 2 && wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

<p class="sku_wrapper"><?php esc_html_e( 'SKU:', 'greeting2' ); ?> <span class="sku"><?php if( $sku = $product->get_sku() ) echo esc_html($sku); else esc_html_e( 'N/A', 'greeting2' ); ?></span></p>

<?php endif; ?>
<?php do_action( 'woocommerce_product_meta_end' ); ?>