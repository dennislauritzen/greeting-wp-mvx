<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button pt-1 pb-3">
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
            <button type="submit" class="single_add_to_cart_button button alt py-3 py-xs-2 py-md-0 w-100 h-100 bg-teal"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

            <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

            <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
            <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
            <input type="hidden" name="variation_id" class="variation_id" value="0" />
        </div>
	</div>
    <div class="row">
        <div class="col-12 py-2 mt-1">
            <label for="custom_note" class="label col-12 pb-1" style="font-size: 14px;"><?php echo __('Særlige ønsker til gaven', 'textdomain'); ?></label>
            <textarea id="custom_note" class="form-control form-control-sm" name="custom_note" rows="4" cols="50" placeholder="<?php echo __('Indtast eventuelle ønsker til produktet her. Eks. ønsket farve, alkoholfrit indhold el.lign. Vi kan ikke garantere, vi kan imødekomme ønskerne, men vi gør, hvad vi kan. :)', 'textdomain'); ?>"></textarea>
        </div>
    </div>
    <?php
    $post_author = get_post_field( 'post_author', $product->get_id() );
    if( vendor_is_freight_company( $post_author ) ){
    ?>
    <div class="row">
        <div class="col-12 py-2 mt-1">
            <label for="datepicker" class="label col-12 pb-1" style="font-size: 14px;">Hvornår skal gaven leveres? (kan også vælges senere)</label>
            <input type="text" class="input-text form-control" name="delivery_date" id="datepicker" placeholder="Vælg dato hvor gaven skal leveres" value="" readonly="readonly" translate="no">
        </div>
    </div>
    <?php
    }
    ?>
</div>

<?php
$vendor_id = get_vendor_id_on_product_page();

echo greeting_enable_datepicker();
echo greeting_load_calendar_dates_function( $vendor_id );
?>
