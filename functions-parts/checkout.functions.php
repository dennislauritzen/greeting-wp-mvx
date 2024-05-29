<?php

#########################################################
## This file contains both CART and CHECKOUT functions.
##
## CART functions first.
##
## then
##
## CHECKOUT functions.
##
#########################################################


##########################################################
## **************
##
## CART STARTS HERE
##
##
##########################################################



/**
 * Add javascript and some styles to header only on cart page
 * for qty updates
 *
 * The conditionally function is only for ensuring the is_cart is actually existing.
 *
 * @author Dennis Lauritzen
 */
add_action('wp_footer', 'conditionally_add_javascript_on_cart_page', 9999);
function conditionally_add_javascript_on_cart_page() {
    if (is_cart()) {
        add_javascript_on_cart_page();
    }
}

function add_javascript_on_cart_page() {
?>
<style type="text/css">
    .woocommerce button[name="update_cart"],
    .woocommerce input[name="update_cart"] {
        display: none;
    }
</style>
<script type="text/javascript">
    var timeout;
    jQuery('.woocommerce').on('change', 'input.input-qty', function(){
        if ( timeout !== undefined ) {
            clearTimeout( timeout );
        }
        timeout = setTimeout(function() {
            jQuery("[name='update_cart']").removeAttr("disabled");
            jQuery("[name='update_cart']").trigger("click");
        }, 1000 ); // 1 second delay, half a second (500) seems comfortable too
    });

    jQuery('.woocommerce').on('click', 'button.plus-qty', function(){
        if ( timeout !== undefined ) {
            clearTimeout( timeout );
        }
        timeout = setTimeout(function() {
            jQuery("[name='update_cart']").removeAttr("disabled");
            jQuery("[name='update_cart']").trigger("click");
        }, 1000 ); // 1 second delay, half a second (500) seems comfortable too
    });

    jQuery('.woocommerce').on('click', 'button.minus-qty', function(){
        if ( timeout !== undefined ) {
            clearTimeout( timeout );
        }
        timeout = setTimeout(function() {
            jQuery("[name='update_cart']").removeAttr("disabled");
            jQuery("[name='update_cart']").trigger("click");
        }, 1000 ); // 1 second delay, half a second (500) seems comfortable too
    });
</script>
<?php
}

/**
 * Add update javascript for quantity buttons in footer.
 *
 * The conditionally function is only for ensuring the is_cart is actually existing.
 *
 * @author Dennis Lauritzen
 */
add_action('wp_footer', 'conditionally_add_quantity_plus_and_minus_in_footer', 9999);
function conditionally_add_quantity_plus_and_minus_in_footer() {
    if (is_cart()) {
        add_quantity_plus_and_minus_in_footer();
    }
}

function add_quantity_plus_and_minus_in_footer(){
?>
<script type="text/javascript">
    function incrementValue(e) {
        e.preventDefault();
        var fieldName = jQuery(e.target).data('field');
        var parent = jQuery(e.target).closest('div');
        var currentVal = parseInt(parent.find('input#' + fieldName).val(), 10);

        if (!isNaN(currentVal)) {
            parent.find('input#' + fieldName).val(currentVal + 1);
        } else {
            parent.find('input#' + fieldName).val(0);
        }
    }

    function decrementValue(e) {
        e.preventDefault();
        var fieldName = jQuery(e.target).data('field');
        var parent = jQuery(e.target).closest('div');
        var currentVal = parseInt(parent.find('input#' + fieldName).val(), 10);

        if (!isNaN(currentVal) && currentVal > 0) {
            parent.find('input#' + fieldName).val(currentVal - 1);
        } else {
            parent.find('input#' + fieldName).val(0);
        }
    }

    jQuery('.plus-qty').click(function(e) {
        incrementValue(e);
    });

    jQuery('.minus-qty').click(function(e) {
        decrementValue(e);
    });
</script>
<?php
}



##########################################################
## **************
##
## CHECKOUT STARTS HERE
##
##
##########################################################

//  Save & show date as order meta
add_action( 'woocommerce_checkout_update_order_meta', 'greeting_save_receiver_info_with_order' );
function greeting_save_receiver_info_with_order( $order_id ) {
    global $woocommerce;

    if ( $_POST['receiver_phone'] ) update_post_meta( $order_id, 'receiver_phone', esc_attr( $_POST['receiver_phone'] ) );
}

// show order date in thank you page
add_action( 'woocommerce_thankyou', 'greeting_view_order_and_receiver_info_thankyou_page', 20 );
function greeting_view_order_and_receiver_info_thankyou_page( $order_id ){  ?>
    <?php echo '<p><strong>'.__('Receiver phone','greeting2').':</strong> ' . get_post_meta( $order_id, 'receiver_phone', true ) . '</p>';
}


/**
 * For adding an input class for some of the checkout fields
 *
 * @param $args
 * @param $key
 * @param $value
 * @return mixed
 */
function wc_form_field_args($args, $key, $value) {
    if($args['type'] !== 'checkbox'){
        $args['input_class'] = array( 'form-control' );
    }
    return $args;
}
add_filter('woocommerce_form_field_args',  'wc_form_field_args',10,3);


/**
 * @author Dennis
 * Functions for setting the order delivery date.
 * On step 3 in checkout.
 *
 * order date begin
 */
# add_action( 'woocommerce_review_order_before_payment', 'greeting_echo_date_picker' );
function greeting_echo_date_picker( ) {
    $storeProductId = '';
    // Get $product object from Cart object
    $cart = WC()->cart->get_cart();

    foreach( $cart as $cart_item_key => $cart_item ){
        $product = $cart_item['data'];
        $storeProductId = $product->get_id();
    }

    // Get vendor ID.
    $product = get_post($storeProductId);
    $vendor_id = (!empty($product->post_author) ? $product->post_author : get_post_field('post_author', $storeProductId));

    // Get delivery type.
    $del_value = get_vendor_delivery_type($vendor_id, 'value');

    // Get delivery day requirement, cut-off-time for orders and the closed dates.
    $vendorDeliverDayReq = get_vendor_delivery_days_required($vendor_id);
    $vendorDropOffTime = get_vendor_dropoff_time($vendor_id);

    $closed_dates_arr = get_vendor_closed_dates($vendor_id);

    if($del_value == '0'){
        echo '<h3 class="pt-4">Leveringsdato</h3>';
        echo '<p>';
        echo 'Da du bestiller fra en butik, der sender varerne med fragtfirma, kan du ikke vælge en leveringsdato. ';
        echo 'Varen sendes hurtigst muligt - og hvis gaven først må åbnes på en bestemt dag, så kan du notere det oven for i leveringsintruktionerne';
        echo '</p>';
    } else {
        echo '<h3 class="pt-4">Leveringsdato</h3>';
        echo '<script>';
        echo 'jQuery("#datepicker").prop("readonly", true).prop("disabled","disabled");';
        echo '</script>';
        woocommerce_form_field( 'delivery_date', array(
            'type'          => 'text',
            'class'         => array('form-row-wide', 'notranslate'),
            'id'            => 'datepicker',
            'required'			=> true,
            'label'         => __('Hvornår skal gaven leveres?'),
            'placeholder'   => __('Vælg dato hvor gaven skal leveres'),
            'custom_attributes' => array('readonly' => 'readonly', 'translate' => 'no')
        ), WC()->checkout->get_value( 'delivery_date' ) );


        // Build intervals & delivery days.
        $opening = get_field('openning', 'user_'.$vendor_id);
        $del_days = get_del_days_text($opening, $del_value, 2);
        //echo $del_days;
        //echo '.</p>';

        // @todo - get the days. "I dag", "I morgen" etc. - must be a function from the overviews.
        $delivery_text = get_vendor_delivery_date_text($vendor_id);
        echo '
        <div style="padding: 6px 10px; font-size: 12px; font-family: Inter,sans-serif; background: #fafafa; color: #666666;">
            <b>Info om butikken, der leverer din gavehilsen</b><br>
            Du er i gang med at bestille en gavehilsen hos '.get_vendor_name($vendor_id).', der har åbent og kan levere din gave '.$del_days.'.<br><br>
        
            Hvis du bestiller nu, kan butikken levere <b>'.$delivery_text.'</b>. (Butikken kan levere inden for '.$vendorDeliverDayReq.' åbningsdag(e), hvis du bestiller inden kl. '.$vendorDropOffTime.').
        </div>
        ';
    }
    ?>

    <input type="hidden" id="vendorDeliverDay" value="<?php echo $vendorDeliverDayReq;?>"/>
    <input type="hidden" id="vendorDropOffTimeId" value="<?php echo $vendorDropOffTime;?>"/>
    <?php
}


/**
 * Add New Custom Step to the Arg Checkout, where the Greeting & delivery date can be.
 *
 * @param array $fields
 * return array
 */
function argmcAddNewSteps($fields) {
    //Add First Step
    $position = 6;     //Set Step Position
    $fields['steps'] = array_slice($fields['steps'] , 0, $position - 1, true) +
        array(
            'step_6' => array(
                'text'  => __('Hilsen & leveringsdato', 'argMC'),     //"Tab Name" - Set First Tab Name
                'class' => 'greeting-message'             //'my-custom-step' - Set First Tab Class Name
            ),
        ) +
        array_slice($fields['steps'], $position - 1, count($fields['steps']) - 1, true);

    return $fields;

}
add_filter('arg-mc-init-options', 'argmcAddNewSteps');


/**
 * Add Content to the Related Steps Created Above
 * It is in the ARGmc checkout steps.
 *
 * @param string $step
 * return void
 */
function argmcAddStepsContent($step) {
    //First Step Content

    if ($step == 'step_6') {
        greeting_echo_receiver_info();
    }
}
add_action('arg-mc-checkout-step', 'argmcAddStepsContent');


/** Receiver info and message begin */
#add_action( 'woocommerce_before_order_notes', 'greeting_echo_receiver_info' );
function greeting_echo_receiver_info( ) {

    echo '<div>';

    echo '<h3>Din hilsen til modtager</h3>';

    #$chosenMessage = WC()->session->get( 'message-pro' );
    #$chosenMessage = empty( $chosenMessage ) ? WC()->checkout->get_value( 'message-pro' ) : $chosenMessage;
    #$chosenMessage = empty( $chosenMessage ) ? '0' : $chosenMessage;

    #woocommerce_form_field( 'message-pro',  array(
    #	'type'      => 'radio',
    #	'label'			=> 'Hvor lang er din hilsen?',
    #	'class'     => array( 'form-row-wide', 'update_totals_on_change' ),
    #	'label_class' =>	array('form-row-label'),
    #	'options'   => array(
    #		'0'				=> 'Standardhilsen, håndskrevet (op til 165 tegn)',
    #		'4'				=> 'Lang hilsen, håndkrevet (op til 400 tegn), +10 kr.'
    #	),
    #), $chosenMessage );

    // @todo - If message-pro == 4, then this should be allowed to be 400 characters.
    woocommerce_form_field( 'greeting_message', array(
        'type'				=> 'textarea',
        'id'					=> 'greetingMessage',
        'class'				=> array('form-row-wide'),
        'required'		=> true,
        'input_class'	=> 'validate[required]',
        'label'				=> __('Din hilsen til modtager (max 160 tegn)', 'greeting2'),
        'placeholder'	=> __('Skriv din hilsen til din modtager her :)', 'greeting2'),
        'maxlength' 	=> 160
    ), WC()->checkout->get_value( 'greeting_message' ) );

    echo '
        <div style="padding: 6px 10px; font-size: 12px; font-family: Inter,sans-serif; margin-top: -5px;  margin-bottom: 10px; background: #fafafa; color: #666666;">
            Da vores kort med hilsener er håndskrevne, kan vi ikke indsætte emojis, men vi forsøger at gengive dem på bedst mulig vis.   
        </div>
        ';

    woocommerce_form_field( 'receiver_phone', array(
        'type'          => 'tel',
        'class'         => array('form-row-wide', 'greeting-custom-input'),
        'input_class'		=> array('input-text validate[required] validate[custom[phone]'),
        'required'      => true,
        'label'         => __('Modtagerens telefonnr.', 'greeting2'),
        'placeholder'       => __('Indtast modtagerens telefonnummer.', 'greeting2'),
    ), WC()->checkout->get_value( 'receiver_phone' ));
    #echo '<tr class="message-pro-radio"><td>';

    echo '
        <div style="padding: 6px 10px; font-size: 12px; font-family: Inter,sans-serif; margin-top: -5px; margin-bottom: 10px; background: #fafafa; color: #666666;">
            Telefonnummeret bruges <b>kun</b> i forbindelse med selve leveringen, hvis vi modtageren eks. ikke åbner, eller vi skal bruge deres hjælp til at finde indgangen.<br>
            Vi sender ikke nogen information om bestillingen - hverken før, under eller efter levering.
        </div>
        ';

    echo '<h3>Leveringsinstruktioner</h3>
		<style type="text/css">
			input#deliveryLeaveGiftAddress,
			input#deliveryLeaveGiftNeighbour {
				width: 18px;
				height: 18px;
			}
		</style>
		';

    woocommerce_form_field( 'leave_gift_address', array(
        'type'				=> 'checkbox',
        'id'					=> 'deliveryLeaveGiftAddress',
        'class'				=> array('form-row-wide'),
        'label_class' => array(''),
        'input_class' => array('input-checkbox'),
        'label'				=> __('Ja, gaven må efterlades på adressen', 'greeting2'),
        'placeholder'	=> '',
        'required' 		=> false,
        'default' 		=> 1
    ), 1 );

    woocommerce_form_field( 'leave_gift_neighbour', array(
        'type'				=> 'checkbox',
        'id'					=> 'deliveryLeaveGiftNeighbour',
        'class'				=> array('form-row-wide'),
        'input_class' => array('input-checkbox'),
        'label'				=> __('Ja, gaven må afleveres til/hos naboen', 'greeting2'),
        'placeholder'	=> '',
        'required' 		=> false,
        'default' 		=> 1
    ), 0 );

    woocommerce_form_field( 'delivery_instructions', array(
        'type'				=> 'textarea',
        'id'					=> 'deliveryInstructions',
        'class'				=> array('form-row-wide'),
        'label'				=> __('Leveringsinstruktioner', 'greeting2'),
        'placeholder'	=> __('Har du særlige instruktioner til leveringen? Eks. en dørkode, særlige forhold på leveringsadressen, en dato hvor gaven må åbnes eller lignende? Notér dem her :)', 'greeting2')
    ), WC()->checkout->get_value( 'delivery_instructions' ) );

    // Insert the delivery date area
    greeting_echo_date_picker();

    echo '</div>';
}


/**
 * Make ship to different address checkbox checked by default
 *
 * @since 1.0.1
 * @author Dennis Lauritzen
 *
 */
add_filter('woocommerce_ship_to_different_address_checked', '__return_true');
add_filter('woocommerce_order_needs_shipping_address', '__return_true');


/**
 * Function for redirecting to a new receipt page, that has custom theme.
 *
 * @author Dennis Lauritzen
 * @return void
 */
add_action( 'woocommerce_thankyou', 'woocommerce_thankyou_redirect', 4 );
function woocommerce_thankyou_redirect( $order_id ) {
    //$order_id. // This contains the specific ID of the order
    $order       = wc_get_order( $order_id );
    $order_key   = $order->get_order_key();
    if(empty($order) || (!is_object($order) && !is_array($order) && count($order) == 0)){
        wp_redirect( site_url() .'/' );
    }
    global $wp;
    if ( is_checkout() && !empty( $wp->query_vars['order-received'] ) ) {
        wp_redirect( site_url() . '/order-received?o='.$order->ID.'&key='.$order_key );
        exit;
    }
}

/**
 * Function for loading the calendar dates to the checkout.
 */
// Load Calendar Dates
add_action( 'woocommerce_after_checkout_form', 'greeting_load_calendar_dates', 20 );
function greeting_load_calendar_dates( $available_gateways ) {
    // Get $product object from Cart object
    $cart = WC()->cart->get_cart();

    foreach( $cart as $cart_item_key => $cart_item ){
        $product = $cart_item['data'];
        $storeProductId = $product->get_id();
    }

    $vendor_id = get_post_field( 'post_author', $storeProductId );
    $dates = get_vendor_dates_new($vendor_id, 'd-m-Y', 'close');
    $dates_values_only = array_values($dates);
    $dates_json = json_encode($dates_values_only);
    ?>

    <script type="text/javascript">
        // Validates that the input string is a valid date formatted as "mm/dd/yyyy"
        function isValidDate(dateString)
        {
            // First check for the pattern
            if(!/^\d{1,2}\-\d{1,2}\-\d{4}$/.test(dateString))
                return false;

            // Parse the date parts to integers
            var parts = dateString.split("-");
            var day = parseInt(parts[0], 10);
            var month = parseInt(parts[1], 10);
            var year = parseInt(parts[2], 10);

            // Check the ranges of month and year
            if(year < 1000 || year > 3000 || month == 0 || month > 12)
                return false;

            var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

            // Adjust for leap years
            if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
                monthLength[1] = 29;

            // Check the range of the day
            return day > 0 && day <= monthLength[month - 1];
        };

        jQuery(document).ready(function($) {
            $('#datepicker').click(function() {
                var customMinDateVal = $('#vendorDeliverDay').val();
                var customMinDateValInt = parseInt(customMinDateVal);
                let vendorDropOffTimeVal = $('#vendorDropOffTimeId').val();
                let d = new Date();
                let hour = d.getHours();
                if(hour > vendorDropOffTimeVal){
                    var customMinDateVal = customMinDateValInt+1;
                } else {
                    customMinDateVal = $('#vendorDeliverDay').val();
                }
                // var vendorClosedDayArray = $('#vendorClosedDayId').val();
                var vendorClosedDayArray = <?php echo $dates_json; ?>;

                jQuery('#datepicker').datepicker({
                    dateFormat: 'dd-mm-yy',
                    // minDate: -1,
                    minDate: new Date(),
                    // maxDate: "+1M +10D"
                    maxDate: "+58D",
                    // closed on specific date
                    beforeShowDay: function(date){
                        var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
                        return [ vendorClosedDayArray.indexOf(string) == -1 ];
                    },
                    onClose: function(date, datepicker){
                        const par_elm = jQuery(this).closest('.form-row');

                        if (!isValidDate(date) || date == '') {
                            par_elm.addClass('has-error');
                        } else {
                            par_elm.removeClass('has-error').addClass('woocommerce-validated');
                            jQuery("#datepicker_field label.error").css('display','none');
                        }
                    },
                    errorPlacement: function(error, element) { }
                }).datepicker( "show" );
                jQuery(".ui-datepicker").addClass('notranslate');
            });
        });
    </script>
    <?php
}

/**
 * function for showing / hiding the calendar.
 * Not in use at the moment.
 *
 * @param $available_gateways
 * @return void
 */
#add_action( 'woocommerce_after_checkout_form', 'greeting_show_hide_calendar' );
function greeting_show_hide_calendar( $available_gateways ) {?>
    <script type="text/javascript">
        function show_calendar( val ) {
            if ( val.match("^flat_rate") || val.match("^free_shipping") ) {
                jQuery('#show-if-shipping').fadeIn();
            } else {
                jQuery('#show-if-shipping').fadeOut();
            }
        }

        jQuery(document).ajaxComplete(function() {
            var val = jQuery('input[name^="shipping_method"]:checked').val();
            show_calendar( val );
        });
    </script>
    <?php
}

#add_action( 'woocommerce_checkout_process', 'greeting_validate_new_checkout_fields' );
function greeting_validate_new_checkout_fields() {
    if ( isset( $_POST['delivery_date'] ) && empty( $_POST['delivery_date'] ) ) wc_add_notice( __( 'Please select the Delivery Date' ), 'error' );
}

// Load JQuery Datepicker
add_action( 'woocommerce_after_checkout_form', 'greeting_enable_datepicker', 10 );
function greeting_enable_datepicker() { ?>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <?php
}


/**
 * Check if store delivers in the postal code.
 *  This is the check in checkout.
 *
 * @param $fields
 * @param $errors
 * @return void
 */
add_action( 'woocommerce_after_checkout_validation', 'greeting_check_delivery_postcode', 10, 2);
function greeting_check_delivery_postcode( $fields, $errors ){
    global $wpdb, $WCMp;

    $storeProductId = 0;
    // Get $product object from Cart object
    $cart = WC()->cart->get_cart();

    foreach( $cart as $cart_item_key => $cart_item ){
        $product = $cart_item['data'];
        $storeProductId = (!empty($product->get_parent_id()) ? (($product->get_parent_id() == 0) ? $product->get_id() : $product->get_parent_id()) : $product->get_id());
        #print "<p>Store ID: ";var_dump($storeProductId);print "</p>";
    }

    $vendor_id = get_post_field( 'post_author', $storeProductId );
    #print "<p>Vendor ID: ";var_dump($vendor_id);print "</p>";
    $vendor = get_mvx_vendor($vendor_id);

    // get vendor delivery zips
    $vendorDeliveryZipsRow = $wpdb->get_row( "
		SELECT * FROM {$wpdb->prefix}usermeta
		WHERE user_id = {$vendor_id}
		AND meta_key = 'delivery_zips'
	" );
    $vendorDeliveryZipsBilling = $vendorDeliveryZipsRow->meta_value;

    $vendorRelatedPCBillingWithoutComma = str_replace(" ","",$vendorDeliveryZipsBilling);
    $vendorRelatedPCBillingWCArray = explode(",", $vendorRelatedPCBillingWithoutComma);

    $ship_postcode = (int) trim($fields['shipping_postcode']);
    $findPostCodeFromArray = in_array($ship_postcode, $vendorRelatedPCBillingWCArray);

    if (!in_array($ship_postcode, $vendorRelatedPCBillingWCArray)){
        $args = array(
            'post_type' => 'city',
            'meta_query'=> array(
                array(
                    'key' => 'postalcode',
                    'compare' => '=',
                    'value' => $ship_postcode,
                    'type' => 'numeric'
                )
            ),
            'post_status' => 'publish',
            'posts_per_page' => '1'
        );
        $city = new WP_Query( $args );

        if($city && $city->posts && count($city->posts) > 0 && is_object($vendor)){
            $errors->add( 'validation', '<p style="line-height:150%;">Beklager - den valgte butik kan ikke levere til '.$city->posts[0]->post_title.'. Du kan <a href="'.$vendor->get_permalink().'">gå til butikkens side</a> og se hvilke postnumre de leverer til eller <a href="'.get_permalink($city->posts[0]->ID).'">klikke her og se butikker der leverer i postnummer '.$city->posts[0]->post_title.'</a></p>' );
        } else {
            $errors->add( 'validation', 'Beklager - butikken kan desværre ikke levere til det postnummer, du har indtastet under levering. Du bedes enten ændre leveringens postnummer eller gå til <a href="'.home_url().'">forsiden</a> for at finde en butik i det ønskede postnummer.' );
        }
    }
}



/**
 * function to add order meta to the post / order after checkout.
 *
 * #add delivery_date
 *
 * @todo: Remember to add the redirect for order pages again!!!! (@line 3095)
 */
add_action( 'woocommerce_checkout_update_order_meta', 'greeting_save_custom_fields_with_order' );
function greeting_save_custom_fields_with_order( $order_id ) {
    global $woocommerce;

    // -----------------------
    // Get data from child order.
    $order = wc_get_order( $order_id );
    $vendor_id = 0;
    foreach ($order->get_items() as $item_key => $item) {
        $product = get_post($item['product_id']);
        $vendor_id = $product->post_author;

        $vendor_name = get_user_meta($vendor_id, '_vendor_page_title', 1);

        if(!empty($vendor_id)){
            update_post_meta($order_id, '_vendor_id', $vendor_id);
            update_post_meta($order_id, '_vendor_name', $vendor_name);
            break;
        }
    }

    if ( $_POST['delivery_date'] ) update_post_meta( $order_id, '_delivery_date', esc_attr( $_POST['delivery_date'] ) );
    if ( $_POST['delivery_date'] ){
        $post_date = $_POST['delivery_date'];
        $d_date = substr($post_date, 0, 2);
        $d_month = substr($post_date, 3, 2);
        $d_year = substr($post_date, 6, 4);
        $unix_date = date("U", strtotime($d_year.'-'.$d_month.'-'.$d_date));
        update_post_meta( $order_id, '_delivery_unixdate', esc_attr( $unix_date ) );
        update_post_meta( $order_id, '_delivery_date', esc_attr( $post_date )  );
    } else {
        $vendor_del_days = (int) get_field('vendor_require_delivery_day', 'user_'.$vendor_id);
        $vendor_drop_off = (int) get_field('vendor_drop_off_time', 'user_'.$vendor_id);
        $vendor_opening_days = get_field('openning', 'user_'.$vendor_id);
        $delivery_date = estimateDeliveryDate($vendor_del_days, $vendor_drop_off, $vendor_opening_days, 'U');

        update_post_meta( $order_id, '_delivery_unixdate', esc_attr( $delivery_date ) );
    }
    if ( $_POST['greeting_message'] ) update_post_meta( $order_id, '_greeting_message', esc_attr( $_POST['greeting_message'] ) );
    if ( $_POST['receiver_phone'] ) update_post_meta( $order_id, '_receiver_phone', esc_attr( $_POST['receiver_phone'] ) );

    if ( $_POST['delivery_instructions'] ) update_post_meta( $order_id, '_delivery_instructions', esc_attr( $_POST['delivery_instructions'] ) );

    if ( $_POST['leave_gift_address'] ) update_post_meta( $order_id, '_leave_gift_address', esc_attr( $_POST['leave_gift_address'] ) );
    if ( $_POST['leave_gift_neighbour'] ) update_post_meta( $order_id, '_leave_gift_neighbour', esc_attr( $_POST['leave_gift_neighbour'] ) );
}


/**
 * Function for the greeting text / greeting message
 * #greeting_text #greeting_meesage
 *
 * @author Dennis Lauritzen
 * @return void
 */
add_action( 'woocommerce_after_checkout_validation', 'greeting_validate_new_receiver_info_fields', 10, 2 );
function greeting_validate_new_receiver_info_fields($fields, $errors) {
    global $woocommerce;

    #if ( isset($_POST['receiver_phone']) && (empty($_POST['receiver_phone']) || !preg_match('/^[0-9\s\+]{8,15}$/', trim($_POST['receiver_phone']))) ){
    #	$errors->add(
    #		'validation',
    #		__('Indtast et gyldigt telefonnummer til modtager i step 3  (8 cifre, uden mellemrum og landekode), så vi kan kontakte vedkommende ved evt. spørgsmål om levering. Klik på "Gennmfør bestilling" når du har rettet telefonnummeret.','greeting2')
    #	);
    #}
    if ( isset($_POST['greeting_message']) && empty($_POST['greeting_message']) ){
        $errors->add(
            'validation',
            __( 'Please enter greeting message', 'greeting2')
        );
    }
    //if ($_POST['message-pro'] == "0" && (strlen($_POST['greeting_message']) > 165)){
    if(mb_strlen(trim($_POST['greeting_message']),'UTF-8') > 165){
        $errors->add(
            'validation',
            __( 'Standard package accept only 165 Character', 'greeting2')
        );
    }

    $cart = WC()->cart->get_cart();

    $age_restricted_items_in_cart = false;
    foreach( $cart as $cart_item_key => $cart_item ){
        $product = $cart_item['data'];
        $storeProductId = $product->get_id();

        $product_id = $cart_item['product_id'];
        $shop_id = get_post_meta($product_id, 'shop', true);

        $product_alchohol = get_post_meta($product_id, 'alcohol', true);
        if($product_alchohol){
            $age_restricted_items_in_cart = true;
        }
    }

    if($age_restricted_items_in_cart){
        if(!isset($_POST['age_restriction'])) {
            $errors->add('age-restriction', esc_html__('Please confirm that you\'re 18+ years old.', 'greeting-marketplace'));
        }
    }

}

/**
 * Disable order shipping options
 * @since 1.0.1
 * @author Dennis Lauritzen
 */
function greeting_marketplace_checkout_fields($fields) {
    // Remove billing fields
    //unset($fields['billing']['billing_first_name']);
    //unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_company']);
    // unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    // unset($fields['billing']['billing_city']);
    // unset($fields['billing']['billing_postcode']);
    # unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    //unset($fields['billing']['billing_phone']);
    //unset($fields['billing']['billing_email']);

    // Remove shipping fields
    //unset($fields['shipping']['shipping_first_name']);
    //unset($fields['shipping']['shipping_last_name']);
    //unset($fields['shipping']['shipping_company']);
    //unset($fields['shipping']['shipping_address_1']);
    unset($fields['shipping']['shipping_address_2']);
    //unset($fields['shipping']['shipping_city']);
    //unset($fields['shipping']['shipping_postcode']);
    # unset($fields['shipping']['shipping_country']);
    unset($fields['shipping']['shipping_state']);

    // Remove order comment fields
    unset($fields['order']['order_comments']);

    $disable_autocomplete = false;
    $fields['shipping']['shipping_address_1']['autocomplete'] = $disable_autocomplete;
    $fields['shipping']['shipping_postcode']['autocomplete'] = $disable_autocomplete;
    $fields['shipping']['shipping_city']['autocomplete'] = $disable_autocomplete;

    return $fields;
}
add_filter('woocommerce_checkout_fields' , 'greeting_marketplace_checkout_fields', 10, 1);


/**
 * Add additional terms to checkout if cart contains product that has an age restriction of 18+
 * @since 1.0.1
 * @author Dennis
 */
function greeting_marketplace_checkout_age_restriction() {
    $age_restricted_items_in_cart = false;
    foreach(WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $product_alchohol = get_post_meta($cart_item['product_id'], 'alcholic_content', true);
        $product_alchohol = (is_array($product_alchohol)) ? $product_alchohol[0] : $product_alchohol;

        $product_alcohol_acf = get_field('alcholic_content', 'product_'.$cart_item['product_id']);


        // value: 0 or 1
        $product_alcohol = 0;
        if($product_alchohol == 1){
            $product_alcohol = 1;
        } else if($product_alcohol_acf == 1){
            $product_alcohol = 1;
        }

        if($product_alcohol == 1){
            $age_restricted_items_in_cart = true;
            break;
        }
    }
    if($age_restricted_items_in_cart){
        woocommerce_form_field('age_restriction', array(
            'type'          => 'checkbox',
            'class'         => array('form-row mycheckbox'),
            'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
            'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
            'required'      => true,
            'label'         => esc_html__('I confirm that I\'m 18+ years old.', 'greeting2'),
        ));
    }
}
add_action('woocommerce_review_order_before_submit', 'greeting_marketplace_checkout_age_restriction');


/**
 * Updating the suborder meta data for vendor_id.
 * Not in use at the moment.
 *
 * @param $vendor_order_id
 * @param $posted_data
 * @param $order
 * @return void
 */
function update_sub_order_meta($vendor_order_id, $posted_data, $order){
    global $WCMp;

    $vendor_order = wc_get_order($vendor_order_id);
    $vendor_id = get_post_meta($vendor_order_id, '_vendor_id', true);

    #$vendor_id = get_post_meta($vendor_order_id, '_vendor_id', true);
}
#add_action( 'mvx_checkout_vendor_order_processed' , 'update_sub_order_meta' ,10 , 3);


/**
 * Change the default state and country on the checkout page
 */
add_filter( 'default_checkout_billing_country', 'change_default_checkout_country' );
add_filter( 'default_checkout_shipping_country', 'change_default_checkout_country' );
function change_default_checkout_country() {
    return 'DK'; // country code
}
function change_default_checkout_state() {
    return ''; // state code
}


/** packaging fee begin */

#add_action( 'woocommerce_review_order_before_order_total', 'checkout_packaging_radio_buttons' );

function checkout_packaging_radio_buttons() {

    echo '<div class="packaging-radio">
        <div>'.__("Packaging Options").'</div><div>';

    $chosen = WC()->session->get( 'packaging' );
    $chosen = empty( $chosen ) ? WC()->checkout->get_value( 'packaging' ) : $chosen;
    $chosen = empty( $chosen ) ? '0' : $chosen;

    woocommerce_form_field( 'packaging',  array(
        'type'      => 'radio',
        'class'     => array( 'form-row-wide', 'update_totals_on_change' ),
        'options'   => array(
            '5'  => 'Premium Packaging: (+5 kr.)',
            '0'     => 'Standard Packaging',
        ),
    ), $chosen );

    echo '</div></div>';
}

/**
 * Function for adding extra fee in checkout.
 * if e.g. there is a larger message available.
 *
 * @author Dennis
 * @since v1.0
 */
function checkout_message_fee( $cart ) {
    if ( $radio2 = WC()->session->get( 'message-pro' ) ) {
        $cart->add_fee( 'Message Fee', $radio2 );
    }
}
#add_action( 'woocommerce_cart_calculate_fees', 'checkout_message_fee', 20, 1 );


/**
 * @param $posted_data
 * @return void
 */
function checkout_message_choice_to_session( $posted_data ) {
    parse_str( $posted_data, $output );
    if ( isset( $output['message-pro'] ) ){
        WC()->session->set( 'message-pro', $output['message-pro'] );
    }
}
add_action( 'woocommerce_checkout_update_order_review', 'checkout_message_choice_to_session' );




function checkout_packaging_fee( $cart ) {
    if ( $radio = WC()->session->get( 'packaging' ) ) {
        $cart->add_fee( 'Packaging Fee', $radio );
    }
}
#add_action( 'woocommerce_cart_calculate_fees', 'checkout_packaging_fee', 20, 1 );


function checkout_packaging_choice_to_session( $posted_data ) {
    parse_str( $posted_data, $output );
    if ( isset( $output['packaging'] ) ){
        WC()->session->set( 'packaging', $output['packaging'] );
    }
}
#add_action( 'woocommerce_checkout_update_order_review', 'checkout_packaging_choice_to_session' );