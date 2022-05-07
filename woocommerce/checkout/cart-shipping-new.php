<!--

Selve review order skal rettes til også at være opbygget af <div>'s '
før denne kan bruges. Det er derfor det bugger pt.

-->

<div class="row woocommerce-shipping-totals">
	<div class="col-12 fw-bold pb-2">Levering</div>
	<div class="col-12" data-title="<?php echo esc_attr( $package_name ); ?>">
		<?php if ( $available_methods ) : ?>
				<?php foreach ( $available_methods as $method ) : ?>
					<div class="row">
						<div class="col-4">
							<label for="shipping_method_<?php echo $index; ?>_<?php echo esc_attr( sanitize_title( $method->id ) ); ?>">
								<?php echo $method->label; ?>
							</label>
						</div>
						<div class="col-8 text-end">
							<?php
							echo $method->cost.' '.get_woocommerce_currency_symbol();
							#print '<label for="shipping_method_'.$index.'_'.esc_attr( sanitize_title( $method->id ) ).'">';
							#print wc_cart_totals_shipping_method_label( $method );
							#print '</label>';
							?>
							<?php #printf( '<label for="shipping_method_%1$s_%2$s">%3$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), wc_cart_totals_shipping_method_label( $method ) ); // WPCS: XSS ok. ?>
						</div>
						<div class="col-12">
						<?php
						if ( 1 < count( $available_methods ) ) {
							printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) ); // WPCS: XSS ok.
						} else {
							printf( '<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) ); // WPCS: XSS ok.
						}
						do_action( 'woocommerce_after_shipping_rate', $method, $index );
						?>
						</div>
					</div>
				<?php endforeach; ?>
			<?php if ( is_cart() ) : ?>
				<p class="woocommerce-shipping-destination text-right">
					<?php
					// Shipping to the postal code entered in frontpage
					# The 'ship to somewhere'-statement. Commented out to due lack of functionality in regards to delivery area at the moment.
					# @todo - fix this so we can write 'Shipping to 7100 Vejle' etc.
					#printf( esc_html__( 'Shipping to %s.', 'greeting' ) . ' ', '<strong>' . 'someplace' . '</strong>' );
					?>
					<?php
					// if ( $formatted_destination ) {
						// Translators: $s shipping destination.
					//	printf( esc_html__( 'Shipping to %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' );
					//	$calculator_text = esc_html__( 'Change address', 'woocommerce' );
					// } else {
					//	echo wp_kses_post( apply_filters( 'woocommerce_shipping_estimate_html', __( 'Shipping options will be updated during checkout.', 'woocommerce' ) ) );
					// }
					?>
				</p>
			<?php endif; ?>
			<?php
		elseif ( ! $has_calculated_shipping || ! $formatted_destination ) :
			if ( is_cart() && 'no' === get_option( 'woocommerce_enable_shipping_calc' ) ) {
				echo wp_kses_post( apply_filters( 'woocommerce_shipping_not_enabled_on_cart_html', __( 'Shipping costs are calculated during checkout.', 'woocommerce' ) ) );
			} else {
				echo wp_kses_post( apply_filters( 'woocommerce_shipping_may_be_available_html', __( 'Enter your address to view shipping options.', 'woocommerce' ) ) );
			}
		elseif ( ! is_cart() ) :
			echo wp_kses_post( apply_filters( 'woocommerce_no_shipping_available_html', __( 'There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce' ) ) );
		else :
			// Translators: $s shipping destination.
			echo wp_kses_post( apply_filters( 'woocommerce_cart_no_shipping_available_html', sprintf( esc_html__( 'No shipping options were found for %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' ) ) );
			$calculator_text = esc_html__( 'Enter a different address', 'woocommerce' );
		endif;
		?>

		<?php if ( $show_package_details ) : ?>
			<?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html( $package_details ) . '</small></p>'; ?>
		<?php endif; ?>

		<?php if ( $show_shipping_calculator ) : ?>
			<?php woocommerce_shipping_calculator( $calculator_text ); ?>
		<?php endif; ?>
	</div>
</div>
