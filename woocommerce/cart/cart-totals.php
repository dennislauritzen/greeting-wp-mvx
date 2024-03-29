<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

?>
<?php do_action( 'woocommerce_before_cart_totals' ); ?>
<div class="col-12 col-lg-6 p-3 bg-light-grey cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">
<h3 style="font-family: 'Rubik', 'Inter', Arial, sans-serif;"><?php esc_html_e( 'Cart totals', 'woocommerce' ); ?></h3>

<div class="cart-subtotals cart-subtotal">
	<div class="row cart-subtotal">
		<div class="col-4"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></div>
		<div class="col-8" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
			<p class="text-end">
				<?php wc_cart_totals_subtotal_html(); ?>
			</p>
		</div>
	</div>

	<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
		<div class="row cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
			<div class="col-4">
				<?php wc_cart_totals_coupon_label( $coupon ); ?>
			</div>
			<div class="col-8" data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>">
				<p class="text-end">
					<?php wc_cart_totals_coupon_html( $coupon ); ?>
				</p>
			</div>
		</div>
	<?php endforeach; ?>

	<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

		<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

		<?php #wc_cart_totals_shipping_html(); ?>
		<div class="row shipping cart-shipping">
			<div class="col-4"><?php esc_html_e( 'Shipping', 'woocommerce' ); ?></div>
			<div class="col-8" data-title="<?php esc_attr_e( 'Shipping', 'woocommerce' ); ?>">
				<p class="text-end">
					<?php #OLD: woocommerce_shipping_calculator(); ?>
					<?php
						foreach( WC()->session->get('shipping_for_package_0')['rates'] as $method_id => $rate ){
						    if( WC()->session->get('chosen_shipping_methods')[0] == $method_id ){
						        $rate_label = $rate->label; // The shipping method label name
						        $rate_cost_excl_tax = floatval($rate->cost); // The cost excluding tax
						        // The taxes cost
						        $rate_taxes = 0;
						        foreach ($rate->taxes as $rate_tax)
						            $rate_taxes += floatval($rate_tax);
						        // The cost including tax
						        $rate_cost_incl_tax = $rate_cost_excl_tax + $rate_taxes;

						?>
						            <span class="totals"><?php echo WC()->cart->get_cart_shipping_total(); ?></span>
						<?php
						        break;
						    }
						}
					?>
				</p>
			</div>
		</div>

		<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

	<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

		<div class="row shipping">
			<div class="col-4">
				<?php esc_html_e( 'Shipping', 'woocommerce' ); ?>
			</div>
			<div class="col-8" data-title="<?php esc_attr_e( 'Shipping', 'woocommerce' ); ?>">
				<p class="text-end">
					<?php #woocommerce_shipping_calculator(); ?>
				</p>
			</div>
		</div>

	<?php endif; ?>

	<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
		<div class="row fee">
			<div class="col-4">
				<?php echo esc_html( $fee->name ); ?>
			</div>
			<div class="col-8" data-title="<?php echo esc_attr( $fee->name ); ?>">
				<p class="text-end">
					<?php wc_cart_totals_fee_html( $fee ); ?>
				</p>
			</div>
		</div>
	<?php endforeach; ?>

	<?php
	if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
		$taxable_address = WC()->customer->get_taxable_address();
		$estimated_text  = '';

		if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
			/* translators: %s location. */
			$estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
		}

		if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
			foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				?>
				<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
					<th><?php echo esc_html( $tax->label ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
					<td data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
				</tr>
				<?php
			}
		} else {
			?>
			<div class="row tax-total">
				<div class="col-4">
					<?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
				<div class="col-8" data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>">
					<p class="text-end">
						<?php wc_cart_totals_taxes_total_html(); ?>
					</p>
				</div>
			</div>
			<?php
		}
	}
	?>

	<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

	<div class="row order-total">
		<div class="col-4">
			<?php esc_html_e( 'Total', 'woocommerce' ); ?>
		</div>
		<div class="col-8" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
			<p class="text-end">
				<?php wc_cart_totals_order_total_html(); ?>
			</p>
		</div>
	</div>

	<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

</div>

<div class="wc-proceed-to-checkout">
	<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
</div>

<?php do_action( 'woocommerce_after_cart_totals' ); ?>
</div>
