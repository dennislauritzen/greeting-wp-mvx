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

/**
 * Set Cache Headers for checkout
 *
 * @access public
 */
function greeting_set_cartcheckout_custom_headers(){
    if(is_cart()) {
        header("Cache-Tag: Cart");
    }# else if(is_checkout()) {
    #    header("Cache-Tag: Checkout");
    #}
}
add_action('template_redirect', 'greeting_set_cartcheckout_custom_headers');


##########################################################
## **************
##
## CART STARTS HERE
##
##
##########################################################

/**
 * Remove Cart fragments from the whole site except cart and checkout.
 *
 * @return void
 *
 */
function disable_woocommerce_cart_fragments() {
    if (is_front_page() || is_single() || is_archive()) {
        wp_dequeue_script('wc-cart-fragments');
    }
}
add_action('wp_enqueue_scripts', 'disable_woocommerce_cart_fragments', 11);


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
 *
 * Save the note from product page when adding to cart
 *
 */
// Save the custom note to the cart item
function save_custom_note_to_cart_item( $cart_item_data, $product_id, $variation_id ) {
    if( isset( $_POST['custom_note'] ) ) {
        $cart_item_data['custom_note'] = sanitize_text_field( $_POST['custom_note'] );
    }
    return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'save_custom_note_to_cart_item', 10, 3 );


/**
 *
 * Save the note from product page when adding to cart
 *
 */
// Save the custom note to the cart item
function save_delivery_date_to_cart_item( $cart_item_data, $product_id, $variation_id ) {
    if( isset( $_POST['delivery_date'] ) ) {
        WC()->session->set( 'delivery_date', sanitize_text_field( $_POST['delivery_date'] ) );
    }
    return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'save_delivery_date_to_cart_item', 10, 3 );


/**
 * Add a text field to each cart item
 */
function custom_note_cart_item( $cart_item, $cart_item_key ) {
    $notes = isset( $cart_item['custom_note'] ) ? $cart_item['custom_note'] : '';
    printf(
        '<div><textarea class="%s form-control form-control-sm my-2" id="cart_custom_note_%s" data-cart-id="%s" placeholder="Har du ønsker til gavens indhold? Notér dem her - så forsøger vi at følge dem så godt som muligt.">%s</textarea></div>',
        'prefix-cart-custom-note',
        $cart_item_key,
        $cart_item_key,
        $notes
    );
}
add_action( 'woocommerce_after_cart_item_name', 'custom_note_cart_item', 10, 2 );

/**
 * Enqueue our JS file
 */
function addCartJS() {
    if ( is_cart() ) { // Check if the current page is the cart page
    ?>
    <script>
        (function($){
            $(document).ready(function(){
                var typingTimer;                // Timer identifier
                var doneTypingInterval = 500;  // Time in milliseconds (0.5 seconds)

                $('.prefix-cart-custom-note').on('keyup paste', function(){
                    clearTimeout(typingTimer); // Clear the previous timer
                    var inputField = $(this);
                    typingTimer = setTimeout(function() {
                        // Start blocking the cart totals
                        $('.cart_totals').block({
                            message: null,
                            overlayCSS: {
                                background: '#fff',
                                opacity: 0.6
                            }
                        });

                        var cart_id = inputField.data('cart-id');
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>', // Make sure this variable is correctly defined
                            data: {
                                action: 'prefix_update_cart_notes',
                                security: $('#woocommerce-cart-nonce').val(),
                                custom_note: $('#cart_custom_note_' + cart_id).val(),
                                cart_id: cart_id
                            },
                            success: function(response) {
                                // Unblock the cart totals after AJAX success
                                $('.cart_totals').unblock();
                            }
                        });
                    }, doneTypingInterval);
                });

                // Clear the timeout if the user starts typing again
                $('.prefix-cart-notes').on('keydown', function(){
                    clearTimeout(typingTimer);
                });
            });
        })(jQuery);

    </script>
    <?php
    } // end if isCart()
}
add_action( 'wp_footer', 'addCartJS' );
#add_action( 'wp_enqueue_scripts', 'prefix_enqueue_scripts' );

/**
 * Update cart item notes
 */
function prefix_update_cart_notes() {
    // Do a nonce check to ensure security
    if( ! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'woocommerce-cart' ) ) {
        // Send a JSON response indicating nonce failure
        wp_send_json( array( 'nonce_fail' => 1 ) );
        exit;
    }

    // Save the notes to the cart meta
    $cart = WC()->cart->cart_contents; // Get the cart contents
    $cart_id = $_POST['cart_id']; // Get the cart ID from the POST data
    $notes = $_POST['custom_note']; // Get the notes from the POST data

    // Find the cart item by its ID
    $cart_item = $cart[$cart_id];

    // Add the notes to the cart item
    $cart_item['custom_note'] = $notes;

    // Update the cart contents with the modified cart item
    WC()->cart->cart_contents[$cart_id] = $cart_item;

    // Save the updated cart contents to the session
    WC()->cart->set_session();

    // Send a JSON response indicating success
    wp_send_json( array( 'success' => 1 ) );
    exit;

}
add_action( 'wp_ajax_prefix_update_cart_notes', 'prefix_update_cart_notes' );
add_action( 'wp_ajax_nopriv_prefix_update_cart_notes', 'prefix_update_cart_notes' );

function prefix_checkout_create_order_line_item( $item, $cart_item_key, $values, $order ) {
    foreach( $item as $cart_item_key=>$cart_item ) {
        if( isset( $cart_item['custom_note'] ) ) {
            $item->add_meta_data( '_custom_note', $cart_item['custom_note'], true );
        }
    }
}
add_action( 'woocommerce_checkout_create_order_line_item', 'prefix_checkout_create_order_line_item', 10, 4 );















##########################################################
## **************
##
## CHECKOUT STARTS HERE
##
##
##########################################################

// show order date in thank you page
add_action( 'woocommerce_thankyou', 'greeting_view_order_and_receiver_info_thankyou_page', 20 );
function greeting_view_order_and_receiver_info_thankyou_page( $order_id ){
	if(is_wc_hpos_activated()){
		$order = wc_get_order( $order_id );
		$receiver_phone = $order->get_meta('receiver_phone');
	} else {
		$receiver_phone = get_post_meta( $order_id, 'receiver_phone', true );
	}
	echo '<p><strong>' . __('Receiver phone','greeting2') . ':</strong> ' . $receiver_phone . '</p>';
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

    // Get the value on funeral - true/false
    $cart_has_funeral_items = cart_has_funeral_products();

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
        $delivery_date = WC()->session->get( 'delivery_date' );

        if(empty($delivery_date)){
           $delivery_date =  WC()->checkout->get_value( 'delivery_date' );
        }

        $delivery_date_label = __('Hvornår skal gaven leveres?', 'greeting3');
        $delivery_date_header = 'Leveringsdato';
        if($cart_has_funeral_items){
            $delivery_date_label = __('Hvornår / hvilken dato er begravelsen?', 'greeting3');
            $delivery_date_header = 'Leveringsdato & -tidspunkt';
        }

        echo '<h3 class="pt-4">'.$delivery_date_header.'</h3>';
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
        ), $delivery_date );

        if($cart_has_funeral_items){
            $delivery_date_time = WC()->session->get( 'delivery_date_time' );

            if(empty($delivery_date_time)){
                $delivery_date_time =  WC()->checkout->get_value( 'delivery_date_time' );
            }

            woocommerce_form_field( 'delivery_date_time', array(
                'type'          => 'time',
                'class'         => array('form-row-wide', 'notranslate'),
                'id'            => '',
                'required'			=> true,
                'label'         => __('Begravelsestidspunkt'),
                'placeholder'   => __('Indtast tidspunkt for begravelsen')
            ), $delivery_date_time );
        }


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
            Du er i gang med at bestille en gavehilsen hos '.get_vendor_name($vendor_id).', der kan levere din gave '.$del_days.'.<br><br>
        ';
        // Dropoff time, get.
        $dropoff_time = get_vendor_dropoff_time($vendor_id);
        $formatted_time = date("H:i", strtotime($dropoff_time));

        $prepend_text = ($del_value == "1") ? 'Hvis du bestiller inden kl. '.$formatted_time.', kan butikken levere ' : 'Hvis du bestiller inden kl. '.$formatted_time.' afsender butikken ';

        $vendor_delivery_days_from_today = get_vendor_delivery_days_from_today_header_vendor($vendor_id, $prepend_text, $del_value, 1);

        echo $vendor_delivery_days_from_today;

        echo '
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

    #var_dump($fields['steps']);
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


/**
 *
 * @param $fields
 * @return mixed
 */
function greeting_delivery_instructions( $fields ) {
    $has_funeral_products = has_funeral_products_in_cart();

    if($has_funeral_products){
        echo '<p class="form-row text-end">';
        echo 'I tvivl om kirkens adresse? Du kan finde den på <a href="https://www.sogn.dk/" target="_blank" rel="nofollow noopener">Sogn.dk</a>';
        echo '</p>';
    }

    /**
     * The receiver phone field
     *
     * Shouldn't show on funeral products.
     */
    if(!$has_funeral_products) {
        woocommerce_form_field('receiver_phone', array(
            'type' => 'tel',
            'class' => array('form-row-wide', 'greeting-custom-input'),
            'input_class' => array('input-text validate[required] validate[custom[phone]'),
            'required' => true,
            'label' => __('Modtagerens telefonnr.', 'greeting2'),
            'placeholder' => __('Indtast modtagerens telefonnummer.', 'greeting2'),
        ), WC()->checkout->get_value('receiver_phone'));

        echo '
        <div style="padding: 6px 10px; font-size: 12px; font-family: Inter,sans-serif; margin-top: -5px; margin-bottom: 10px; background: #fafafa; color: #666666;">
            Telefonnummeret bruges <b>kun</b> i forbindelse med selve leveringen, hvis modtageren eks. ikke åbner, eller vi skal bruge deres hjælp til at finde indgangen.<br>
            Vi sender ikke nogen information om bestillingen - hverken før, under eller efter levering.
        </div>
        ';
    }

    echo '<h3 style="margin-top:30px;">Leveringsinstruktioner</h3>
		<style type="text/css">
			input#deliveryLeaveGiftAddress,
			input#deliveryLeaveGiftNeighbour {
				width: 18px;
				height: 18px;
			}
		</style>
		';

    if(!$has_funeral_products) {
        woocommerce_form_field('leave_gift_address', array(
            'type' => 'checkbox',
            'id' => 'deliveryLeaveGiftAddress',
            'class' => array('form-row-wide'),
            'label_class' => array(''),
            'input_class' => array('input-checkbox'),
            'label' => __('Ja, gaven må efterlades på adressen', 'greeting2'),
            'placeholder' => '',
            'required' => false,
            'default' => 1
        ), 1);

        woocommerce_form_field('leave_gift_neighbour', array(
            'type' => 'checkbox',
            'id' => 'deliveryLeaveGiftNeighbour',
            'class' => array('form-row-wide'),
            'input_class' => array('input-checkbox'),
            'label' => __('Ja, gaven må afleveres til/hos naboen', 'greeting2'),
            'placeholder' => '',
            'required' => false,
            'default' => 1
        ), 0);
    }

    woocommerce_form_field( 'delivery_instructions', array(
        'type'				=> 'textarea',
        'id'					=> 'deliveryInstructions',
        'class'				=> array('form-row-wide'),
        'label'				=> __('Leveringsinstruktioner', 'greeting2'),
        'placeholder'	=> __('Har du særlige instruktioner til leveringen? Eks. en dørkode, særlige forhold på leveringsadressen, en dato hvor gaven må åbnes eller lignende? Notér dem her :)', 'greeting2')
    ), WC()->checkout->get_value( 'delivery_instructions' ) );

    return $fields;
}
add_filter( 'woocommerce_after_checkout_shipping_form' , 'greeting_delivery_instructions' );

function greeting_card_options(){
    #$cart_has_funeral_products = cart_has_funeral_products();

    $options_array = array();

    #if($cart_has_funeral_products){
        // Free card.
        #$options_array['0'] = 'Standardkort - håndskrevet hilsen (op til 160 tegn), gratis';

        // Band for funeral, 7.5 cm
        #$options_array['90'] = 'Bånd (op til 2 linjer á 30 tegn), +200 kr.';

        // Band for funeral, 7.5 cm
        #$options_array['97'] = 'Bånd - 7,5 cm (op til 2 linjer á 30 tegn), +149 kr.';

        // Band for funeral, 10 cm
        #$options_array['98'] = 'Bånd - 10 cm (op til 2 linjer á 30 tegn), +199 kr.';

        // Band for funeral, 12.5 cm
        #$options_array['99'] = 'Bånd - 12,5 cm (op til 2 linjer á 30 tegn), +249 kr.';

        // Long greeting
        #$options_array['99']= 'Eksklusivt bånd (op til 2 linjer á 40 tegn), +199 kr.';
    #} else {
        // Free card.
        $options_array['0'] = 'Standardkort - håndskrevet hilsen (op til 160 tegn), gratis';

        // Premium 'normal' size card
        #$options_array['1'] = 'Premium kort, håndskrevet hilsen (op til 160 tegn), +20 kr.';

        // Long greeting
        $options_array['4']= 'Stort kort - håndskrevet hilsen (op til 400 tegn), +29 kr.';
    #}


    // Premium 'normal' size card
    #$options_array['99'] = 'Premium kort, håndskrevet hilsen (op til 160 tegn), +20 kr.';

    return $options_array;
}

function greeting_card_options_selected(){
    $chosenMessage = WC()->checkout->get_value( 'message_pro' );
    $chosenMessage = empty( $chosenMessage ) ? WC()->session->get( 'message_pro' ) : $chosenMessage;
    $chosenMessage = empty( $chosenMessage ) ? '0' : $chosenMessage;

    return $chosenMessage;
}

/** Receiver info and message begin */
#add_action( 'woocommerce_before_order_notes', 'greeting_echo_receiver_info' );
function greeting_echo_receiver_info( ) {

    echo '
    <div>
    ';

    // Check if this is a funeral product...
    $has_funeral_products_in_cart = has_funeral_products_in_cart();
    $has_funeral_products_with_band_in_cart = has_funeral_products_with_band_in_cart();

    if ($has_funeral_products_in_cart) {
        echo '<h3>Tekst / hilsen til afdøde</h3>';
    } else {
        echo '<h3>Din hilsen til modtager</h3>';
    }

    if($has_funeral_products_with_band_in_cart){
        woocommerce_form_field( 'greeting_message_band_1', array(
            'type'				=> 'textarea',
            'id'				=> 'greetingMessageBand',
            'class'				=> array('form-row-wide'),
            'required'		    => true,
            'input_class'	    => 'validate[required]',
            'label'				=> __('Bånd, linje 1 (max 30 tegn)', 'greeting2'),
            'placeholder'	    => __('Skriv linje 1 til båndet her', 'greeting2'),
            'maxlength' 	    => 30,
            'custom_attributes' => array(
                'rows' => 2,
            )
        ), WC()->checkout->get_value( 'greeting_message_band_1' ) );

        woocommerce_form_field( 'greeting_message_band_2', array(
            'type'				=> 'textarea',
            'id'				=> 'greetingMessageBand2',
            'class'				=> array('form-row-wide'),
            #'required'		    => true,
            #'input_class'	    => 'validate[required]',
            'label'				=> __('Bånd, linje 2 (max 30 tegn)', 'greeting2'),
            'placeholder'	    => __('Skriv linje 2 til båndet her', 'greeting2'),
            'maxlength' 	    => 30
        ), WC()->checkout->get_value( 'greeting_message_band_2' ) );
        ?>
            <style type="text/css">
                #greetingMessageBand, #greetingMessageBand2 {
                    height: 65px !important;
                    min-height: 65px !important;
                }
            </style>
            <!--<script type="text/javascript">
                jQuery('input[type="radio"]').removeClass('form-control');
            </script>-->
        <?php
    } else {
        // Get the options of the message_pro
        $options_array = greeting_card_options();

        // Get the selected / default option of the message_pro
        $selected_option = greeting_card_options_selected();

        // Add the radio buttons for message options
        woocommerce_form_field('message_pro', array(
            'type'      => 'radio',
            'label'     => 'Hvor lang er din hilsen?',
            'class'     => array('form-check', 'update_totals_on_change'),
            'label_class' => array('form-check-label', 'form-row-label'),
            'input_class' => array('form-check-input'),
            'options'   => $options_array,
            'default'   => $selected_option
        ), $selected_option);

        woocommerce_form_field( 'greeting_message', array(
            'type'				=> 'textarea',
            'id'				=> 'greetingMessage',
            'class'				=> array('form-row-wide'),
            'required'		    => true,
            //'input_class'	    => 'validate[required]',
            'label'				=> __('Din hilsen til modtager (max 160 tegn)', 'greeting2'),
            'placeholder'	    => __('Skriv din hilsen til din modtager her :)', 'greeting2'),
            'maxlength' 	    => 160
        ), WC()->checkout->get_value( 'greeting_message' ) );
        ?>
        <script type="text/javascript">
            jQuery('input[type="radio"]').removeClass('form-control');
        </script>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                // Function to update the textarea maxlength based on selected option
                function updateMessageMaxlength() {
                    var selectedOption = $('input[name="message_pro"]:checked').val();
                    var textarea = $('#greetingMessage');
                    var messageText = textarea.val();
                    var label = $('label[for="greetingMessage"]');

                    var hiddenField = $("#greetingMessageHidden");
                    var hiddenFieldVal = hiddenField.val();
                    var hiddenFieldText = hiddenFieldVal.substring(0, 160);

                    if (selectedOption == '4') {
                        textarea.attr('maxlength', 400);
                        label.text('Din hilsen til modtager (max 400 tegn)');

                        if(messageText == hiddenFieldText)
                        {
                            textarea.val( hiddenFieldVal );
                        }
                    } else {
                        // Truncate the text to 160 characters
                        hiddenField.val( textarea.val() );
                        textarea.val( messageText.substring(0, 160) );

                        textarea.attr('maxlength', 160);
                        label.text('Din hilsen til modtager (max 160 tegn)');
                    }
                }


                // Run the function on page load
                updateMessageMaxlength();

                function updateCartSurcharge() {
                    var selectedOption = $('input[name="message_pro"]:checked').val();

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo admin_url('admin-ajax.php');?>',
                        data: {
                            action: 'update_greeting_message_surcharge',
                            message_pro: selectedOption
                        },
                        success: function(response) {
                            if (!response.success) {
                                //alert(response.data);
                            } else {
                                // Trigger WooCommerce to update the order review section
                                $('body').trigger('update_checkout');
                                $(document.body).trigger('update_checkout');
                            }
                        }
                    });
                }

                $('input[name="message_pro"]').change(function() {
                    updateMessageMaxlength();
                    updateCartSurcharge();
                });
            });
        </script>
        <?php
    }

    echo '<input type="hidden" name="greeting_message_hidden" id="greetingMessageHidden">';

    if($has_funeral_products_with_band_in_cart){
        echo '
        <div style="padding: 6px 10px; font-size: 12px; font-family: Inter,sans-serif; margin-top: -5px;  margin-bottom: 10px; background: #fafafa; color: #666666;">
            Brug kun almindelig tekst til båndet. Bånd trykkes på en båndtrykkemaskine, hvorfor eks. emojis og smileyer ikke kan gengives.
        </div>
    ';
    } else {
        echo '
        <div style="padding: 6px 10px; font-size: 12px; font-family: Inter,sans-serif; margin-top: -5px;  margin-bottom: 10px; background: #fafafa; color: #666666;">
            Da vores kort med hilsener er håndskrevne, kan vi ikke indsætte emojis, men vi forsøger at gengive dem på bedst mulig vis.   
        </div>
    ';
    }


    // Insert the delivery date area
    greeting_echo_date_picker();

    echo '</div>';
}


/**
 * Add surcharge based on selected greeting message option
 *
 * @param $cart
 * @return void
 */
function add_greeting_message_surcharge( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    // Get the surcharge amount from the session
    $surcharge = WC()->session->get('greeting_message_surcharge', 0);

    // Check if the fee already exists and remove it
    $fees = $cart->get_fees();
    foreach ( $fees as $fee_key => $fee ) {
        if ( $fee->name === __( 'Tilkøb af større kort', 'greeting3' ) ) {
            unset($fees[$fee_key]);
        }
    }

    // Add the surcharge if it's greater than 0
    if ( $surcharge > 0 ) {
        $cart->add_fee( __( 'Tilkøb af større kort', 'greeting3' ), $surcharge, true );
    }
}
add_action( 'woocommerce_cart_calculate_fees', 'add_greeting_message_surcharge' );



/**
 * Handle AJAX request to update surcharge
 *
 * @return void
 */
function update_greeting_message_surcharge() {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    if ( isset($_POST['message_pro']) ) {
        $chosen_option = sanitize_text_field($_POST['message_pro']);

        if ( $chosen_option == '1' ) {
            $surcharge = 16; // 16 kr. ex VAT (20 kr. incl.) for the premium message
        } elseif ( $chosen_option == '4' ) {
            $surcharge = 23.2; // 24 kr. ex VAT (29 kr. incl.) for the long message
        } else {
            $surcharge = 0;
        }

        // Overwrite the surcharge in the session
        WC()->session->set('greeting_message_surcharge', $surcharge);

        // Set value of the message_pro
        WC()->session->set('message_pro', $chosen_option);

        // Check if the fee already exists and remove it
        $fees = WC()->cart->get_fees();
        foreach ( $fees as $fee_key => $fee ) {
            if ( $fee->name === __( 'Tilkøb af større kort', 'greeting3' ) ) {
                unset($fees[$fee_key]);
            }
        }

        // Add the surcharge if it's greater than 0
        if ( $surcharge > 0 ) {
            WC()->cart->add_fee( __( 'Tilkøb af større kort', 'greeting3' ), $surcharge, true );
        }

        // Recalculate the cart totals
        #WC()->cart->calculate_totals();

        // Send JSON response back to the front-end
        wp_send_json_success();
    } else {
        wp_send_json_error('No message option selected');
    }
}
add_action( 'wp_ajax_update_greeting_message_surcharge', 'update_greeting_message_surcharge' );
add_action( 'wp_ajax_nopriv_update_greeting_message_surcharge', 'update_greeting_message_surcharge' );


// Display the selected greeting message option in the order admin
function display_greeting_message_option_in_admin( $order ) {
	if(is_wc_hpos_activated()){
		$message_option = $order->get_meta('_greeting_card_upgrade_option');
	} else {
		$message_option = get_post_meta( $order->get_id(), '_greeting_card_upgrade_option', true );
	}

    if ( ! empty( $message_option ) ) {
        $options = greeting_card_options();

        echo '<p><strong>' . __( 'Tilkøb af større kort', 'greeting3' ) . ':</strong> ' . $options[$message_option] . '</p>';
    }
}
add_action( 'woocommerce_admin_order_data_after_billing_address', 'display_greeting_message_option_in_admin', 10, 1 );

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
#add_action( 'woocommerce_thankyou', 'woocommerce_thankyou_redirect', 4 );
function woocommerce_thankyou_redirect( $order_id ) {
    //$order_id. // This contains the specific ID of the order
    $order       = wc_get_order( $order_id );
    $order_key   = $order->get_order_key();
    if(empty($order) || (!is_object($order) && !is_array($order) && count($order) == 0)){
        wp_redirect( site_url() .'/' );
    }
    global $wp;
    if ( is_checkout() && !empty( $wp->query_vars['order-received'] ) ) {
        wp_redirect( site_url() . '/order-received?o='.$order->get_id().'&key='.$order_key );
        exit;
    }
}
add_action( 'woocommerce_thankyou', 'greeting_redirect_after_thankyou', 999, 1 );
function greeting_redirect_after_thankyou( $order_id ) {
    // Ensure we have a valid order ID
    if ( ! $order_id ) {
        wp_redirect( site_url() .'/' );
        return;
    }

    // Get the order object
    $order = wc_get_order( $order_id );

    // Ensure order object exists and is valid
    if ( ! $order ) {
        wp_redirect( site_url() .'/' );
        return;
    }

    $order_key   = $order->get_order_key();

    // Redirect to custom receipt page
    wp_redirect( site_url() . '/order-received?o='.$order->get_id().'&key='.$order_key );
    exit;
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

    // If this is a shipping company, then return empty.
    $delivery_type = get_vendor_delivery_type($vendor_id, 'value');
    if($delivery_type == "0"){
        return;
    }

    $dates = get_vendor_dates_new($vendor_id, 'd-m-Y', 'close');
    $dates_values_only = array_values($dates);
    $dates_json = json_encode($dates_values_only);
    ?>

    <script type="text/javascript" data-cfasync="false">
        (function($) {
            $.datepicker.regional['da'] = {
                closeText: 'Luk',
                prevText: '&#x3C;Forrige',
                nextText: 'Næste&#x3E;',
                currentText: 'I dag',
                monthNames: ['Januar', 'Februar', 'Marts', 'April', 'Maj', 'Juni',
                    'Juli', 'August', 'September', 'Oktober', 'November', 'December'
                ],
                monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'
                ],
                dayNames: ['Søndag', 'Mandag', 'Tirsdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lørdag'],
                dayNamesShort: ['Søn', 'Man', 'Tir', 'Ons', 'Tor', 'Fre', 'Lør'],
                dayNamesMin: ['Sø', 'Ma', 'Ti', 'On', 'To', 'Fr', 'Lø'],
                weekHeader: 'Uge',
                dateFormat: 'dd-mm-yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };
            $.datepicker.setDefaults($.datepicker.regional['da']);
        })(jQuery);

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

// Load JQuery Datepicker
add_action( 'woocommerce_after_checkout_form', 'greeting_enable_datepicker', 10 );
function greeting_enable_datepicker() { ?>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js" data-cfasync="false"></script>
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
    global $wpdb, $MVX;

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
 * @possible-hook: woocommerce_checkout_create_order
 * @possible-hook: woocommerce_new_order
 * @possible-hook: woocommerce_pre_payment_complete
 * @todo: Remember to add the redirect for order pages again!!!! (@line 3095)
 */
#add_action( 'woocommerce_checkout_update_order_meta', 'greeting_save_custom_fields_with_order' );
add_action( 'woocommerce_checkout_update_order_meta', 'greeting_save_custom_fields_with_order', 10, 2 );

#add_action( 'woocommerce_checkout_create_order', 'greeting_save_custom_fields_with_order', 10, 2 );
function greeting_save_custom_fields_with_order( $order_id ) {
#function greeting_save_custom_fields_with_order( $order, $data ) {

    // -----------------------
    $order = is_a($order_id, 'WC_Order') ? $order_id : wc_get_order($order_id);

    $vendor_id = 0;
    foreach ($order->get_items() as $item_key => $item) {
        $product = get_post($item['product_id']);
        $vendor_id = $product->post_author;

        $vendor_name = get_user_meta($vendor_id, '_vendor_page_title', 1);

        if(!empty($vendor_id)){
            if(is_wc_hpos_activated()){
                $order->update_meta_data('_vendor_id', $vendor_id);
                $order->update_meta_data('_vendor_name', $vendor_name);
            } else {
                update_post_meta($order_id, '_vendor_id', $vendor_id );
                update_post_meta($order_id, '_vendor_name', $vendor_name );
            }
            break;
        }
    }

    $post_date = isset($_POST['delivery_date']) ? esc_attr($_POST['delivery_date']) : '';
    if ( !empty($post_date) ) {
        if(is_wc_hpos_activated()){
            $order->update_meta_data('_delivery_date', esc_attr( $post_date ) );
        } else {
            update_post_meta($order_id, '_delivery_date', esc_attr( $post_date ) );
        }
    };
    if (!empty($post_date) && preg_match('/^\d{2}-\d{2}-\d{4}$/', $post_date)) {
        $d_date = substr($post_date, 0, 2);
        $d_month = substr($post_date, 3, 2);
        $d_year = substr($post_date, 6, 4);
        $unix_date = date("U", strtotime($d_year.'-'.$d_month.'-'.$d_date));

        if(is_wc_hpos_activated()){
            $order->update_meta_data('_delivery_unixdate', $unix_date );
            $order->update_meta_data('_delivery_date', esc_attr( $post_date ) );
        } else {
            update_post_meta( $order_id, '_delivery_unixdate', $unix_date );
            update_post_meta( $order_id, '_delivery_date', esc_attr( $post_date )  );
        }
    } else {
        $vendor_del_days = (int) get_field('vendor_require_delivery_day', 'user_'.$vendor_id);
        $vendor_drop_off = (int) get_field('vendor_drop_off_time', 'user_'.$vendor_id);
        $vendor_opening_days = get_field('openning', 'user_'.$vendor_id);
        $delivery_date = estimateDeliveryDate($vendor_del_days, $vendor_drop_off, $vendor_opening_days, 'U');

        if(is_wc_hpos_activated()){
            $order->update_meta_data('_delivery_unixdate', sanitize_text_field($delivery_date));
        } else {
            update_post_meta( $order_id, '_delivery_unixdate', sanitize_text_field( $delivery_date ) );
        }
    }

    // Delivery date time - only on orders with funeral products
    $delivery_date_time = isset( $_POST['delivery_date_time'] ) ? sanitize_text_field($_POST['delivery_date_time']) : '';
    if( !empty($delivery_date_time) ){
        if(is_wc_hpos_activated()){
            $order->update_meta_data('_delivery_date_time', $delivery_date_time);
        } else {
            update_post_meta($order_id, '_delivery_date_time',  $delivery_date_time );
        }
    }

    // Save the message for the greeting card.
    $greeting_message = isset( $_POST['greeting_message'] ) ? sanitize_text_field($_POST['greeting_message']) : '';
    if ( !empty($greeting_message) ){
        if(is_wc_hpos_activated()){
            $order->update_meta_data('_greeting_message', $greeting_message );
        } else {
            update_post_meta( $order_id, '_greeting_message', $greeting_message );
        }
    }
    $greeting_pro_message = isset( $_POST['message_pro'] ) ? esc_attr($_POST['message_pro']) : '';
    if ( $greeting_pro_message ) {
        if(is_wc_hpos_activated()){
            $order->update_meta_data('_greeting_card_upgrade_option', $greeting_pro_message );
        } else {
            update_post_meta( $order_id, '_greeting_card_upgrade_option', sanitize_text_field( $_POST['message_pro'] ) );
        }
    }

    // Band message - for funeral
    $greeting_message_band_1 = isset( $_POST['greeting_message_band_1'] ) ? sanitize_text_field($_POST['greeting_message_band_1']) : '';
    if ( !empty($greeting_message_band_1) ){
        if(is_wc_hpos_activated()){
            $order->update_meta_data('_greeting_message_band_1', $greeting_message_band_1 );
        } else {
            update_post_meta($order_id, '_greeting_message_band_1', $greeting_message_band_1 );
        }
    }

    $greeting_message_band_2 = isset( $_POST['greeting_message_band_2'] ) ? sanitize_text_field($_POST['greeting_message_band_2']) : '';
    if ( !empty($greeting_message_band_2) ){
        if(is_wc_hpos_activated()){
            $order->update_meta_data('_greeting_message_band_2', $greeting_message_band_2 );
        } else {
            update_post_meta($order_id, '_greeting_message_band_2', $greeting_message_band_2 );
        }
    }

    // Receiver phone
    $receiver_phone = isset( $_POST['receiver_phone'] ) ? sanitize_text_field($_POST['receiver_phone']) : '';
    if (!empty($receiver_phone)) {
        if(is_wc_hpos_activated()){
            $order->update_meta_data('_receiver_phone', $receiver_phone );
        } else {
            update_post_meta($order_id, '_receiver_phone', $receiver_phone );
        }
    }

    // Delivery instructions
    $delivery_instructions = isset( $_POST['delivery_instructions'] ) ? sanitize_text_field($_POST['delivery_instructions']) : '';
    if (!empty($delivery_instructions)) {
        if(is_wc_hpos_activated()){
            $order->update_meta_data('_delivery_instructions', $delivery_instructions );
        } else {
            update_post_meta($order_id, '_delivery_instructions', $delivery_instructions );
        }
    }

    // Leave gift address
    $leave_gift_address = isset( $_POST['leave_gift_address'] ) ? sanitize_text_field($_POST['leave_gift_address']) : '';
    if (!empty($leave_gift_address)) {
        if(is_wc_hpos_activated()){
            $order->update_meta_data('_leave_gift_address', $leave_gift_address );
        } else {
            update_post_meta($order_id, '_leave_gift_address', $leave_gift_address );
        }

    }

    // Leave gift neighbour
    $leave_gift_neighbour = isset( $_POST['leave_gift_neighbour'] ) ? sanitize_text_field($_POST['leave_gift_neighbour']) : '';
    if (!empty($data['leave_gift_neighbour'])) {
        if(is_wc_hpos_activated()){
            $order->update_meta_data('_leave_gift_neighbour', $leave_gift_neighbour );
        } else {
            update_post_meta($order_id, '_leave_gift_neighbour', $leave_gift_address );
        }
    }

    if(is_wc_hpos_activated()){
        // Save all meta data changes to the order
        $order->save_meta_data();
        $order->save();
    }
}

#add_action( 'woocommerce_checkout_create_order', 'greeting_save_custom_fields_with_order2', 10, 2 );
function greeting_save_custom_fields_with_order2( $order_id, $data ) {
    // Ensure we have a valid order ID
    if ( ! $order_id ) {
        return;
    }

    // Get the order object
    $order = wc_get_order( $order_id );

    // Ensure order object exists and is valid
    if ( ! $order ) {
        return;
    }

    // Check if the custom field 'greeting_message' is set in $_POST
    if ( isset( $_POST['greeting_message'] ) ) {
        // Sanitize the custom field value
        $greeting_message = sanitize_text_field( $_POST['greeting_message'] );

        // Update the order meta data
        if(is_wc_hpos_activated()){
            $order->update_meta_data( '_greeting_message', $greeting_message );
        } else {
            update_post_meta($order_id, '_greeting_message', $greeting_message );
        }

        // Save the order with the updated meta data
        try {
            $order->save();
        } catch ( Exception $e ) {
            // Log the error if saving the order fails
            error_log( 'Error updating order meta data: ' . $e->getMessage() );
        }
    }
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

    #if ( isset($_POST['greeting_message']) && empty($_POST['greeting_message']) ){
    #    $errors->add(
    #        'validation',
    #        __( 'Please enter greeting message', 'greeting2')
    #    );
    #}

    //if ($_POST['message-pro'] == "0" && (strlen($_POST['greeting_message']) > 165)){
    if( isset($_POST['message_pro']) && $_POST['message_pro'] == "0"
        && isset($_POST['greeting_message']) && mb_strlen(trim($_POST['greeting_message']),'UTF-8') > 165)
    {
        $errors->add(
            'validation',
            __( 'Standard package accept only 165 Character', 'greeting2')
        );
    }

    //if ($_POST['message-pro'] == "0" && (strlen($_POST['greeting_message']) > 165)){
    if( isset($_POST['message_pro']) && $_POST['message_pro'] == "4"
        && isset($_POST['greeting_message']) && mb_strlen(trim($_POST['greeting_message']),'UTF-8') > 400)
    {
        $errors->add(
            'validation',
            __( 'Kortet kan maksimalt indeholde 400 tegn', 'greeting2')
        );
    }

    if ( isset($_POST['greeting_message_band_1']) && empty($_POST['greeting_message_band_1']) ){
        $errors->add(
            'validation',
            __( 'Venligst indtast tekst til linje 1 på båndet', 'greeting3')
        );
    }
    //if ($_POST['message-pro'] == "0" && (strlen($_POST['greeting_message']) > 165)){
    if(isset($_POST['greeting_message_band_1']) && mb_strlen(trim($_POST['greeting_message_band_1']),'UTF-8') > 30){
        $errors->add(
            'validation',
            __( 'Bånd, linje 1 kan kun indeholde 30 tegn', 'greeting3')
        );
    }
    if(isset($_POST['greeting_message_band_2']) && mb_strlen(trim($_POST['greeting_message_band_2']),'UTF-8') > 30){
        $errors->add(
            'validation',
            __( 'Bånd, linje 2 kan kun indeholde 30 tegn', 'greeting3')
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
    //unset($fields['billing']['billing_company']);
    // unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    // unset($fields['billing']['billing_city']);
    // unset($fields['billing']['billing_postcode']);
    //unset($fields['billing']['billing_country']);
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
 *
 * Be aware: This is not HPOS compatible.
 */
function update_sub_order_meta($vendor_order_id, $posted_data, $order){
    global $MVX;

    $vendor_order = wc_get_order($vendor_order_id);

	if(is_wc_hpos_activated()){
		$vendor_id = $vendor_order->get_meta('_vendor_id');
	} else {
		$vendor_id = get_post_meta($vendor_order_id, '_vendor_id', true);
	}

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

