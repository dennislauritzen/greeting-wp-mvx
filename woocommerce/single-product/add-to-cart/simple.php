<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<div class="woocommerce-simple-add-to-cart py-3">
        <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' autocomplete="off">
            <div class="row">

                <div class="quantity col-12 col-xs-12 col-sm-12 col-md-5">
                    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

                    <?php
                    do_action( 'woocommerce_before_add_to_cart_quantity' );

                    woocommerce_quantity_input(
                        array(
                            'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                            'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                            'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                        )
                    );

                    do_action( 'woocommerce_after_add_to_cart_quantity' );

                    ?>
                </div>
                <div class="add-to-cart col-12 col-xs-12 col-sm-12 col-md-7 mt-2 mt-md-0">
                    <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt py-3 py-xs-2 py-md-0 w-100 h-100 bg-teal"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

                </div>
            </div>
            <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

            <div class="row">
                <div class="col-12 py-2 mt-1">
                    <label for="custom_note" class="label col-12 pb-1" style="font-size: 14px;"><?php echo __('Særlige ønsker til gaven', 'greeting3'); ?></label>
                    <textarea id="custom_note" class="form-control form-control-sm" name="custom_note" rows="4" cols="50" placeholder="<?php echo __('Indtast eventuelle ønsker til produktet her. Eks. ønsket farve, alkoholfrit indhold el.lign. Vi kan ikke garantere, vi kan imødekomme ønskerne, men vi gør, hvad vi kan. :)', 'textdomain'); ?>"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-12 py-2 mt-1">
                    <label for="datepicker" class="label col-12 pb-1" style="font-size: 14px;">Hvornår skal gaven leveres? (kan også vælges senere)</label>
                    <input type="text" class="input-text form-control" name="delivery_date" id="datepicker" placeholder="Vælg dato hvor gaven skal leveres" value="" readonly="readonly" translate="no">
                </div>
            </div>
        </form> 
	</div>
    <?php
    $vendor_id = get_vendor_id_on_product_page();

    echo greeting_enable_datepicker();
    echo greeting_load_calendar_dates_function( $vendor_id );
    ?>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
