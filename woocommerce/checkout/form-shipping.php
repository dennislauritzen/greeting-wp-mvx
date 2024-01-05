<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-shipping-fields" style="margin-top: 0px !important;">

	<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

		<h3 id="ship-to-different-address">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
				<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span><?php esc_html_e( 'Ship to a different address?', 'woocommerce' ); ?></span>
			</label>
		</h3>

		<div class="shipping_address" style="margin-top: 0px !important;">
            <h3 style="margin-top: 0px;">Leveringsadresse</h3>
			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<div class="woocommerce-shipping-fields__field-wrapper">
				<?php
				$fields = $checkout->get_checkout_fields( 'shipping' );

				foreach ( $fields as $key => $field ) {
					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
				}
				?>
			</div>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>

	<?php endif; ?>
</div>
<!-- DAWA AUTOCOMPLETE -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fetch/2.0.3/fetch.min.js"></script>-->
<script src="<?php echo get_template_directory_uri();?>/node_modules/dawa-autocomplete2/dist/js/dawa-autocomplete2.min.js"></script>
<script type="text/javascript">
    "use strict"

    dawaAutocomplete.dawaAutocomplete( document.getElementById("shipping_address_1"), {
        select: function(address) {
            const autocompleteInput = document.getElementById('autocomplete');
            const streetAddressInput = document.getElementById('shipping_address_1');
            const postalCodeInput = document.getElementById('shipping_postcode');
            const cityInput = document.getElementById('shipping_city');

            // Extract components
            const streetName = address.data.adresseringsvejnavn;
            const houseNumber = address.data.husnr;
            const postalCode = address.data.postnr;
            const cityName = address.data.postnrnavn;

            // Populate the respective input fields with the extracted components
            if(streetName && houseNumber) {
                streetAddressInput.value = streetName + ' ' + houseNumber;
            }
            if(postalCode) {
                postalCodeInput.value = postalCode;
            }
            if(cityName) {
                cityInput.value = cityName;
            }
        }
    });
</script>
<style type="text/css">
    .autocomplete-container {
        /* relative position for at de absolut positionerede forslag får korrekt placering.*/
        position: relative;
        width: 100px;
        max-width: 30em;
    }

    /* Media query for screen sizes larger than 768px */
    @media screen and (min-width: 769px) {
        .autocomplete-container {
            /* Styles for larger screens */
            width: 462px;
            max-width: none; /* Remove the max-width restriction */
        }
    }

    .autocomplete-container input {
        /* Både input og forslag får samme bredde som omkringliggende DIV */
        width: 100%;
        box-sizing: border-box;
    }


    .dawa-autocomplete-suggestions {
        margin: 0.3em 0 0 0;
        padding: 0;
        text-align: left;
        border-radius: 0.3125em;
        background: #fcfcfc;
        box-shadow: 0 0.0625em 0.15625em rgba(0,0,0,.15);
        position: absolute;
        left: 0;
        right: 0;
        z-index: 9999;
        overflow-y: auto;
        box-sizing: border-box;
    }

    @media screen and (min-width: 768px) {
        .dawa-autocomplete-suggestions {
            width: 432px;
            margin: 2px auto;
        }
    }
    @media screen and (min-width: 992px) {
        .dawa-autocomplete-suggestions {
            width: 468px;
            margin: 2px auto;
        }
    }
    @media screen and (min-width: 1200px) {
        .dawa-autocomplete-suggestions {
            width: 540px;
            margin: 2px auto;
        }
    }

    @media screen and (min-width: 1400px) {
        .dawa-autocomplete-suggestions {
            width: 628px;
            margin: 2px auto;
        }
    }

    .dawa-autocomplete-suggestions .dawa-autocomplete-suggestion {
        margin: 0;
        list-style: none;
        cursor: pointer;
        padding: 0.4em 0.6em;
        color: #333;
        border: 0.0625em solid #ddd;
        border-bottom-width: 0;
    }

    .dawa-autocomplete-suggestions .dawa-autocomplete-suggestion:first-child {
        border-top-left-radius: inherit;
        border-top-right-radius: inherit;
    }

    .dawa-autocomplete-suggestions .dawa-autocomplete-suggestion:last-child {
        border-bottom-left-radius: inherit;
        border-bottom-right-radius: inherit;
        border-bottom-width: 0.0625em;
    }

    .dawa-autocomplete-suggestions .dawa-autocomplete-suggestion.dawa-selected,
    .dawa-autocomplete-suggestions .dawa-autocomplete-suggestion:hover {
        background: #f0f0f0;
    }
</style>
<div class="woocommerce-additional-fields">
	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

			<h3><?php esc_html_e( 'Additional information', 'woocommerce' ); ?></h3>

		<?php endif; ?>

		<div class="woocommerce-additional-fields__field-wrapper">
			<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
			<?php endforeach; ?>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>
