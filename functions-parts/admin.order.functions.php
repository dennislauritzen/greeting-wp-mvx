<?php

/**
 * Filtering action for the admin order page, to filter vendors
 *
 * @param $query
 * @return mixed
 */
function filter_orders_by_vendor_in_admin_dashboard( $query ) {
    if (current_user_can('administrator') && !empty($_REQUEST['admin_order_vendor'])) {
        $vendor_term_id = isset($_GET['admin_order_vendor']) ? $_GET['admin_order_vendor'] : '';
        $vendor =  get_mvx_vendor_by_term($vendor_term_id);
        #var_dump($vendor);

        $parent_orders = get_vendor_parent_order($vendor->id);
        $query['post__in'] = $parent_orders;
        return $query;
    }
    return $query;
}
add_filter( 'mvx_shop_order_query_request', 'filter_orders_by_vendor_in_admin_dashboard');


/**
 * Add your custom order status action button (for orders with "processing" status)
 *
 * @param $actions
 * @param $order
 * @return mixed
 */
function add_custom_order_status_actions_button( $actions, $order ) {
    // Get Order ID (compatibility all WC versions)
    $order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;

    // Display the button for all orders that have a 'processing' status
    if ( $order->has_status( array( 'processing', 'order-mail-open', 'order-seen', 'order-forwarded', 'order-accepted' ) ) ) {
        // Set the action button
        $actions['delivered'] = array(
            'url'       => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=delivered&order_id=' . $order_id ), 'woocommerce-mark-order-status' ),
            'name'      => __( 'Order Delivered', 'woocommerce' ),
            'action'    => "view delivered", // keep "view" class for a clean button CSS
        );
    }

    if ( $order->has_status( array( 'completed', 'delivered', 'processing', 'order-mail-open', 'order-seen', 'order-forwarded', 'order-accepted' ) ) ) {
        $oh = hash('md4','gree_ting_dk#!4r1242142fgriejgfto'.$order_id.$order_id);
        $sshh = hash('md4', 'vvkrne12onrtnFG_:____'.$order_id);

        // Set the action button
        $actions['open_tracking_link'] = array(
            'url'       => '/shop-order-status/?order_id=' . $order_id .'&oh=' . $oh . '&sshh=' . $sshh,
            'name'      => __( 'Open tracking link', 'woocommerce' ),
            'action'    => "tracking link", // keep "view" class for a clean button CSS
        );
    }

    return $actions;
}
add_filter( 'woocommerce_admin_order_actions', 'add_custom_order_status_actions_button', 100, 2 );

/**
 * Function for making the custom column with delivery date (unix) sortable
 *
 * @param $sortable_columns
 * @return mixed
 */
function filter_manage_edit_shop_order_sortable_columns( $sortable_columns ) {
    return wp_parse_args( array( 'delivery-date' => '_delivery_unixdate' ), $sortable_columns );
}
add_filter( 'manage_edit-shop_order_sortable_columns', 'filter_manage_edit_shop_order_sortable_columns', 10, 1 );

/**
 * Get the orderby from the URL to order by the delivery-unix-date.
 *
 * @param $query
 * @return void
 */
function action_pre_get_posts( $query ) {
    // If it is not admin area, exit
    if ( ! is_admin() ) return;

    global $pagenow;

    // Compare
    if ( $pagenow === 'edit.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'shop_order' ) {
        // Get orderby
        $orderby = $query->get( 'orderby' );

        // Set query
        if ( $orderby == '_delivery_unixdate' ) {
            $query->set( 'meta_key', '_delivery_unixdate' );
            $query->set( 'orderby', 'meta_value' );
        }
    }
}
add_action( 'pre_get_posts', 'action_pre_get_posts', 10, 1 );


/**
 * Display order data in admin order preview
 *
 * @return void
 */
function custom_display_order_data_in_admin(){
    // Call the stored value and display it
    $str = '<div style="margin:15px 0px 0px 15px;"><strong>Leveringsdato:</strong> {{data.delivery_date_key}}</div>';
    $str .= '<div style="margin:15px 0px 0px 15px;"><strong>Modtagers telefonnr.:</strong> {{data.receiver_phone_key}}</div>';

    $str .= '<div style="margin:15px 0px 0px 15px;"><strong>Besked til modtager:</strong> {{data.greeting_message_key}}</div>';
    $str .= '<div style="margin:15px 0px 0px 15px;"><strong>Bånd - linje 1:</strong> {{data.greeting_message_band_1_key}}</div>';
    $str .= '<div style="margin:2px 0px 0px 15px;"><strong>Bånd - linje 2:</strong> {{data.greeting_message_band_2_key}}</div>';

    $str .= '<div style="margin:15px 0px 0px 15px;"><strong>Leveringsinstruktioner:</strong> {{data.delivery_instructions_key}}</div>';


    $str .= '<div style="margin:15px 0px 0px 15px;"><strong>Gaven må efterlades på adressen:</strong> {{data.leave_gift_address_key}}</div>';

    $str .= '<div style="margin:15px 0px 0px 15px;"><strong>Gaven må afleveres til naboen:</strong> {{data.leave_gift_neighbour_key}}</div>';
}
add_action( 'woocommerce_admin_order_preview_start', 'custom_display_order_data_in_admin' );

/**
 * Add custom order meta data to make it accessible in Order preview template
 *
 * @param $data
 * @param $order
 * @return mixed
 */
function admin_order_preview_add_custom_meta_data( $data, $order ) {
    if(is_wc_hpos_activated()){
        if( $delivery_date_value = $order->get_meta('_delivery_date') ){
            $data['delivery_date_key'] = $delivery_date_value; // <= Store the value in the data array.
        }
    } else {
        if( $delivery_date_value = get_post_meta($order->get_id(), '_delivery_date', 'true') ){
            $data['delivery_date_key'] = $delivery_date_value; // <= Store the value in the data array.
        }
    }

    if( $receiver_phone = $order->get_meta('_receiver_phone') ){
        $data['receiver_phone_key'] = $receiver_phone; // <= Store the value in the data array.
    }


    if(order_has_funeral_products($order->get_id())){
        if( $greeting_message_band_1 = $order->get_meta('_greeting_message_band_1') ){
            $data['greeting_message_band_1_key'] = $greeting_message_band_1; // <= Store the value in the data array.
        }
        if( $greeting_message_band_2 = $order->get_meta('_greeting_message_band_2') ){
            $data['greeting_message_band_2_key'] = $greeting_message_band_2; // <= Store the value in the data array.
        }
    } else {
        if( $greeting_message = $order->get_meta('_greeting_message') ){
            $data['greeting_message_key'] = $greeting_message; // <= Store the value in the data array.
        }
    }


    if( $leave_gift_address = $order->get_meta('_leave_gift_address') ){
        $leave_gift_address = ($leave_gift_address == "1" ? 'Ja' : 'Nej');
        $data['leave_gift_address_key'] = $leave_gift_address; // <= Store the value in the data array.
    }
    if( $leave_gift_neighbour = $order->get_meta('_leave_gift_neighbour') ){
        $leave_gift_neighbour = ($leave_gift_neighbour == "1" ? 'Ja' : 'Nej');
        $data['leave_gift_neighbour_key'] = $leave_gift_neighbour; // <= Store the value in the data array.
    }

    if( $delivery_instructions = $order->get_meta('_delivery_instructions') ){
        $data['delivery_instructions_key'] = $delivery_instructions; // <= Store the value in the data array.
    }
    return $data;
}
add_filter( 'woocommerce_admin_order_preview_get_order_details', 'admin_order_preview_add_custom_meta_data', 10, 2 );


/**
 * STORE OWN REFERENCE AND DELIVERY DATE - Stores own reference for the order
 * For displaying the delivery date dropdown and the store_own_order_reference in admin
 *
 *
 * @return void
 */
function add_shop_order_meta_box() {

    add_meta_box(
        'delivery_date',
        __( 'Leveringsdato', 'greeting2' ),
        'shop_order_display_callback',
        'shop_order',
        'side',
        'core'
    );

    add_meta_box(
        'store_own_order_reference',
        __( 'Butikkens egen ref. for ordre', 'greeting2' ),
        'shop_order_store_own_ref_callback',
        'shop_order',
        'side',
        'core'
    );

}
add_action( 'add_meta_boxes', 'add_shop_order_meta_box' );

/**
 * Function for showing the order dropdown in the order edit page.
 *
 * @param $post
 * @return void
 */
function shop_order_display_callback( $post ) {
    $order = wc_get_order($post->ID);

    if(is_wc_hpos_activated()){
        $value = $order->get_meta('_delivery_date' );
    } else {
        $value = get_post_meta( $post->ID, '_delivery_date', true );
    }

    $vendor_id = 0;
    $storeProductId = 0;
    foreach ( $order->get_items() as $itemId => $item ) {
        // Get the product object
        $product = $item->get_product();

        // Get the product Id
        $productId = $product->get_id();
        $product_meta = get_post($productId);

        $vendor_id = $product_meta->post_author;

        if(!empty($orderedVendorStoreName)){
            break;
        }
    } // end foreach

    $vendor_delivery_day_required = (int) get_vendor_delivery_days_required($vendor_id);
    $vendor_drop_off_time = get_vendor_dropoff_time($vendor_id);
    #if(strpos($vendor_drop_off_time,':') === false && strpos($vendor_drop_off_time,'.')){
    #    $vendor_drop_off_time = $vendor_drop_off_time.':00';
    #} else {
    #    $vendor_drop_off_time = str_replace(array(':','.'),array(':',':'),$vendor_drop_off_time);
    #}

    if($vendor_drop_off_time < date('H:i:s')){
        $vendor_delivery_day_required = $vendor_delivery_day_required + 1;
    }

    // BEWARE: Not used because then we cant change date according to our needs
    $dates = get_vendor_dates_new($vendor_id);
    $dates_json = json_encode($dates);
    ?>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            jQuery('#datepicker').click(function() {
                var customMinDateVal = <?php echo $vendor_delivery_day_required; ?>;
                var customMinDateValInt = parseInt(customMinDateVal);
                var today = '';
                var vendorDropOffTimeVal = '<?php echo $vendor_drop_off_time; ?>';
                let d = new Date();
                var hour = d.getHours()+':'+d.getMinutes();
                // var vendorClosedDayArray = $('#vendorClosedDayId').val();
                //var vendorClosedDayArray = '<?php echo $dates_json; ?>';
                var vendorClosedDayArray = '';

                jQuery('#datepicker').datepicker({
                    dateFormat: 'dd-mm-yy',
                    // minDate: -1,
                    minDate: new Date(),
                    // maxDate: "+1M +10D"
                    maxDate: "+58D",
                    firstDay: 1,
                    // closed on specific date
                    beforeShowDay: function(date){
                        var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
                        return [ vendorClosedDayArray.indexOf(string) == -1 ];
                    }
                }).datepicker( "show" );
                jQuery('.ui-datepicker').addClass('notranslate');
            });
        });
    </script>
    <?php

    woocommerce_form_field( 'delivery_date', array(
        'type'          => 'text',
        'class'         => array(),
        'id'            => 'datepicker',
        'required'      => true,
        'label'         => __('Hvornår skal gaven leveres?'),
        'placeholder'   => __('Vælg dato hvor gaven skal leveres'),
        'custom_attributes' => array('readonly' => 'readonly')
    ), esc_attr( $value ) );
}



/**
 * Call back for the STORE OWN REFERENCE field
 *
 * @param $post WP_Post
 * @return void
 */
function shop_order_store_own_ref_callback( $post ){
    if(is_wc_hpos_activated()){
        $order = wc_get_order($post->ID);
        $value = $order->get_meta('_store_own_order_reference');
    } else {
        $value = get_post_meta( $post->ID, '_store_own_order_reference', true );
    }


    woocommerce_form_field( 'store_own_order_reference', array(
        'type'          => 'text',
        'class'         => array(),
        'id'            => 'store_own_ref',
        'required'      => true,
        'label'         => __('Indtast butikkens egen referencenr.'),
        'placeholder'   => __('Indtast butikkens egen referencenr.')
    ), esc_attr( $value ) );
}

/**
 * Function for saving the shop order meta box data for the delivery date.
 *
 * @param $post_id
 * @param $post
 * @return void
 */
function save_shop_order_meta_box_data( $post_id, $post ) {
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $post->post_type ) && 'shop_order' == $post->post_type ) {
        if ( ! current_user_can( 'edit_shop_order', $post_id ) ) {
            return;
        }
    }

    // Make sure that it is set.
    if ( !isset($_POST['delivery_date']) ){
        return;
    }

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['delivery_date'] );

    # SET THE POST PARENT ID FOR DELIVERY DATE
    if (get_post_parent($post_id) !== null){
        $post = get_post_parent($post_id);
        $post_id = $post->ID;
    }

    $order = wc_get_order($post_id);
    #print $post_id; exit;

    // Update the meta field in the database.
    $post_date = $my_data;
    $d_date = substr($post_date, 0, 2);
    $d_month = substr($post_date, 3, 2);
    $d_year = substr($post_date, 6, 4);
    $unix_date = date("U", strtotime($d_year.'-'.$d_month.'-'.$d_date));


    if(is_wc_hpos_activated()) {
        $order->update_meta_data('_delivery_unixdate', $unix_date);
        $order->update_meta_date('_delivery_date', $my_data);
        $order->save_meta_data();
        $order->save();
    } else {
        update_post_meta( $post_id, '_delivery_unixdate', $unix_date );
        update_post_meta( $post_id, '_delivery_date', $my_data );
    }
}
add_action( 'save_post', 'save_shop_order_meta_box_data', 20, 2 );


/**
 * For saving the data of the "Store own ref" meta box on order page.
 *
 * @param $post_id
 * @param $post
 * @return void
 */
function save_shop_order_meta_box_store_own_ref_data( $post_id, $post ) {
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $post->post_type ) && 'shop_order' == $post->post_type ) {
        if ( ! current_user_can( 'edit_shop_order', $post_id ) ) {
            return;
        }
    }

    // Make sure that it is set.
    if ( !isset($_POST['store_own_order_reference']) ){
        return;
    }

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['store_own_order_reference'] );

    # SET THE POST PARENT ID FOR DELIVERY DATE
    if (get_post_parent($post_id) !== null){
        $post_id_parent = get_post_parent($post_id);

        $order_parent = wc_get_order($post_id_parent);
        if(!is_a($order_parent, 'WC_Order')){
            return;
        }

        // Before changing the post_id variable, lets update the child order value too.
        if(is_wc_hpos_activated()){
            $order_parent->update_meta_data('_store_own_order_reference', $my_data);
            $order_parent->save_meta_data();
            $order_parent->save();
        } else {
            update_post_meta( $post_id, '_store_own_order_reference', $my_data );
            #$post_id = $post->ID;
        }
    } else {
        $order = wc_get_order($post_id);
        if(!is_a($order, 'WC_Order')){
            return;
        }

        // Before changing the post_id variable, lets update the child order value too.
        if(is_wc_hpos_activated()){
            $order->update_meta_data('_store_own_order_reference', $my_data);
            $order->save_meta_data();
            $order->save();
        } else {
            update_post_meta( $post_id, '_store_own_order_reference', $my_data );
            #$post_id = $post->ID;
        }
    }
    #print $post_id; exit;

    // Update the meta field in the database.
    #update_post_meta( $post_id, '_store_own_order_reference', $my_data );
}
add_action( 'save_post', 'save_shop_order_meta_box_store_own_ref_data', 20, 2 );



/**
 * ADDING 2 NEW COLUMNS WITH THEIR TITLES (keeping "Total" and "Actions" columns at the end)
 * Possible values: cborder_number, mvx_suborder, order_date, order_status, billing_address, shipping_address, pensopay_transaction_info, order_total, woe_export_status,
 * wc_actions, store_own_order_reference
 *
 * Also - Removing the suborder column and the export column.
 *
 * @param $columns
 * @return array
 */
function custom_shop_order_column($columns)
{
    $reordered_columns = array();

    // Inserting columns to a specific location
    foreach( $columns as $key => $column){
        $reordered_columns[$key] = $column;
        if( $key == 'mvx_suborder' || $key == 'woe_export_status'){
            unset($reordered_columns['mvx_suborder']);
            unset($reordered_columns['woe_export_status']);
        }
        if( $key ==  'order_status' ){
            // Inserting after "Status" column
            $reordered_columns['delivery-date'] = __( 'Leveringsdato','greeting2');
        }
        if( $key == 'order_number'){
            $reordered_columns['store_vendor_id_name'] = __( 'Butik', 'greeting2' );
        }
        if( $key == 'wc_actions'){
            $reordered_columns['store_own_order_reference'] = __( 'Butikkens egen ref. for ordre', 'greeting2' );
        }
    }
    return $reordered_columns;
}
add_filter( 'manage_edit-shop_order_columns', 'custom_shop_order_column', 20 );

/**
 * Adding column for admin order view
 * This adds the store vendor ID name columns
 * and the delivery date columns
 *
 * @param $column String
 * @param $post_id int
 */
function custom_orders_list_column_content( $column, $post_id )
{
    $vendor_id = get_post_meta( $post_id, '_vendor_id', true);
    $vendor_name = get_vendor_name_by_id($vendor_id);
    $order = wc_get_order( $post_id );

    switch ( $column )
    {
        case 'store_vendor_id_name' :
            print $vendor_name.' (#'.$vendor_id.')';

            // Check if it's a parent order with suborders
            if ($order && $order->get_id() > 0 && $order->get_type() === 'shop_order') {
                // Get the first suborder (assuming there is always only one suborder)
                $suborders = wc_get_orders(array('post_parent' => $post_id, 'post_status' => 'any'));;
                $suborder_id = !empty($suborders) ? current($suborders)->get_id() : 0;

                if ($suborder_id) {
                    $suborder = wc_get_order($suborder_id);
                    // Get the vendor ID from the suborder's metadata
                    $suborder_vendor_id = $suborder->get_meta('_vendor_id', true);
                    $suborder_vendor_name = get_vendor_name_by_id($suborder_vendor_id);

                    // Check if the vendor ID of the suborder is different from the parent order's vendor ID
                    if ($suborder_vendor_id && $suborder_vendor_id != $vendor_id) {
                        echo '<ul class="wcmp-order-vendor" style="margin:0px;"><li>';
                        echo '<small class="wcmp-order-for-vendor"> – tidl.: ' . $suborder_vendor_name . '</small>';
                        echo '</li></ul>';
                    }
                }
            }

            break;
        case 'delivery-date' :
            // Get custom post meta data
            $post_id = has_post_parent($post_id) ? get_post_parent($post_id) : $post_id;

            $del_date_unix = get_post_meta( $post_id, '_delivery_unixdate', true );
            $del_date = get_post_meta( $post_id, '_delivery_date', true );

            if(!$vendor_id){

                foreach ( $order->get_items() as $itemId => $item ){
                    if(!empty($product_meta->post_author)){
                        $vendor_id = $product_meta->post_author;
                        break;
                    }
                }
            }

            $del_type = (get_field('delivery_type', 'user_'.$vendor_id) != '' ? get_field('delivery_type', 'user_'.$vendor_id) : array());
            $del_type_value = is_array($del_type) && isset($del_type[0]['value']) ? $del_type[0]['value'] : '';

            // Generate Delivery icons
            $personal_icon_path = 'M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5zm1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139L5.5 6.943zM8 9.057 9.598 6.5H6.402L8 9.057zM4.937 9.5a1.997 1.997 0 0 0-.487-.877l-.548.877h1.035zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765l1.027-1.643zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53L11.55 8.623z';
            $freight_icon_path = 'M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z';
            $delivery_icon_path = ($del_type_value == 0) ? $freight_icon_path : $personal_icon_path;
            // Output delivery type icon
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi ';
            echo $del_type_value == '0' ? 'bi-truck' : 'bi-bicycle';
            echo '" viewBox="0 0 16 16"><path d="'.$delivery_icon_path.'"></path></svg> ';

            if(!empty($del_date_unix)){
                // The user didnt choose "delivery date", but it was calculated
                $dateobj = new DateTime();
                $dateobj->setTimestamp($del_date_unix);
                $date_format = $dateobj->format('D, j. M \'y');

                echo (empty($del_date) ? '<small><em>Hurtigst muligt (senest '.$date_format.')</em></small>' : $date_format);
            } else if(!empty($del_date)){
                $date_d = substr($del_date, 0, 2);
                $month_d = substr($del_date, 3, 2);
                $year_d = substr($del_date, 6, 4);

                $old_date = DateTime::createFromFormat('d-m-Y', $del_date);

                echo ($old_date instanceof DateTime ? $old_date->format('D, j. M \'y') : '<small>(Hurtigst muligt - <em>'.$del_date.'</em>)</small>');
            } else {
                // The user chose a delivery date.
                echo '<small>(<em>Hurtigst muligt</em>)</small>';
            }
            break;
    }
}
add_action( 'manage_shop_order_posts_custom_column' , 'custom_orders_list_column_content', 20, 2 );




/**
 * Add a custom action to order actions select box on edit order page.
 * Only added for paid orders that haven't fired this action yet
 *
 * @author Dennis Lauritzen
 * @param array $actions order actions array to display
 * @return array - updated actions
 */
function greeting_wc_add_order_meta_box_action( $actions ) {
    #global $theorder;

    // bail if the order has been paid for or this action has been run
    #if ( ! $theorder->is_paid() ) {
    #	return $actions;
    #}

    // add "mark printed" custom action
    $actions['wc_custom_order_action'] = __( 'Gensend mail til butikken', 'greeting2' );
    $actions['wc_custom_order_action_order_notice'] = __( 'Gensend ordrebekræftelse til kunde', 'greeting2' );
    $actions['wc_custom_order_action_delivery_notice'] = __( 'Gensend leveringsbekræftelse til kunde', 'greeting2' );
    $actions['wc_custom_order_action_test_mail'] = __( 'SEND TEST MAIL', 'greeting2' );
    return $actions;
}
add_action( 'woocommerce_order_actions', 'greeting_wc_add_order_meta_box_action' );

/**
 * Add an order note when custom action is clicked
 * Add a flag on the order to show it's been run
 *
 * @author Dennis Lauritzen
 * @param \WC_Order $order
 */
function greeting_wc_process_order_meta_box_action( $order ) {
    $mailer = WC()->mailer();
    $mails = $mailer->get_emails();

    if ( !empty( $mails ) ) {
        foreach ( $mails as $mail ) {
            if ( $mail->id == 'vendor_new_order' ) {
                $mail->trigger( $order->get_id() );
            }
        }
    }
}
add_action( 'woocommerce_order_action_wc_custom_order_action', 'greeting_wc_process_order_meta_box_action' );


/**
 * Add an order note when custom action is clicked
 * Add a flag on the order to show it's been run
 *
 * @author Dennis Lauritzen
 * @param \WC_Order $order
 */
function greeting_wc_completed_order_resend_new_order_mail_to_customer( $order ) {
    $mailer = WC()->mailer();
    $mails = $mailer->get_emails();

    if ( !empty( $mails ) ) {
        foreach ( $mails as $mail ) {
            if ( $mail->id == 'customer_processing_order' ) {
                $mail->trigger( $order->get_id() );
            }
        }
    }
}
add_action( 'woocommerce_order_action_wc_custom_order_action_order_notice', 'greeting_wc_completed_order_resend_new_order_mail_to_customer' );

/**
 * Add an order note when custom action is clicked
 * Add a flag on the order to show it's been run
 *
 * @author Dennis Lauritzen
 * @param \WC_Order $order
 */
function greeting_wc_completed_order_resend_order_notice_to_customer( $order ) {
    $mailer = WC()->mailer();
    $mails = $mailer->get_emails();

    if ( !empty( $mails ) ) {
        foreach ( $mails as $mail ) {
            if ( $mail->id == 'customer_completed_order' ) {
                $mail->trigger( $order->get_id() );
            }
        }
    }
}
add_action( 'woocommerce_order_action_wc_custom_order_action_delivery_notice', 'greeting_wc_completed_order_resend_order_notice_to_customer' );

/**
 * Add an order note when custom action is clicked
 * Add a flag on the order to show it's been run
 *
 * @author Dennis Lauritzen
 * @param \WC_Order $order
 */
function greeting_wc_process_order_meta_box_action_test_mail( $order ) {
    # Possible mail values:
    # ----
    # ARRAY: new_order, cancelled_order, failed_order, customer_on_hold_order, customer_processing_order, customer_completed_order, customer_refunded_order,
    # customer_invoice, customer_note, customer_reset_password, customer_new_account, woocommerce_pensopay_payment_link, vendor_new_account, admin_new_vendor,
    # approved_vendor_new_account, rejected_vendor_new_account, vendor_new_order, notify_shipped, admin_new_vendor_product, vendor_new_question, admin_new_question,
    # customer_answer, admin_added_new_product_to_vendor, vendor_commissions_transaction, vendor_direct_bank, admin_widthdrawal_request, vendor_orders_stats_report,
    # vendor_contact_widget_email, mvx_send_report_abuse, vendor_new_announcement, customer_order_refund_request, admin_vendor_product_rejected,
    # suspend_vendor_new_account, review_vendor_alert, vendor_followed, admin_change_order_status, admin_new_vendor_coupon

    $mailer = WC()->mailer();
    $mails = $mailer->get_emails();

    if ( !empty( $mails ) ) {
        foreach ( $mails as $mail ) {
            if ( $mail->id == 'customer_completed_order' ) {
                add_filter('woocommerce_new_order_email_allows_resend', '__return_true' );
                $mail->trigger( $order->get_id() );
            }
        }
    }

    #$user_id = (empty(get_current_user_id()) ? wp_get_current_user()->ID : get_current_user_id() );
    #$mailer->customer_new_account($user_id);
    #exit;
}
add_action( 'woocommerce_order_action_wc_custom_order_action_test_mail', 'greeting_wc_process_order_meta_box_action_test_mail' );



function greeting_delivery_date_display_admin_order_meta( $order ) {
    $str = '<p><strong>Leveringsdato:</strong> ';
    if ( !empty(get_post_meta( $order->get_id(), '_delivery_date', true )) ) {
        $str .= esc_attr( get_post_meta( $order->get_id(), '_delivery_date', true ) );
    } else {
        $str .= 'Hurtigst muligt ('. get_post_meta( $order->get_id(), '_delivery_unixdate', true ).')';
    }
    //$str .= '('.get_post_meta( $order->get_id(), '_delivery_unixdate', true ).')';
    $str .= '</p>';

    if(order_has_funeral_products( $order->get_id() ))
    {
        $str .= '<p>
                <strong>Bånd - linje 1:</strong> ' . esc_attr( get_post_meta( $order->get_id(), '_greeting_message_band_1', true ) ) . '<br>' .
                '<strong>Bånd - linje 2:</strong>' . esc_attr( get_post_meta( $order->get_id(), '_greeting_message_band_2', true ) )  .
            '</p>';
    } else {

        $str .= '<p><strong>Modtagers telefonnr.:</strong> ' . esc_attr( get_post_meta( $order->get_id(), '_receiver_phone', true ) ) . '</p>';
        $str .= '<p><strong>Besked til modtager:</strong> ' . esc_attr( get_post_meta( $order->get_id(), '_greeting_message', true ) ) . '</p>';
    }


    $str .= '<p><strong>Leveringsinstruktioner:</strong> ' . get_post_meta( $order->get_id(), '_delivery_instructions', true ) . '</p>';
    $leave_gift_at_address = (esc_attr( get_post_meta( $order->get_id(), '_leave_gift_address', true ) ) == "1" ? 'Ja' : 'Nej');
    $str .= '<p><strong>Må gaven stilles på adressen:</strong> ' . $leave_gift_at_address . '</p>';
    $leave_gift_at_neighbour = (esc_attr( get_post_meta( $order->get_id(), '_leave_gift_neighbour', true ) ) == "1" ? 'Ja' : 'Nej');
    $str .= '<p><strong>Må gaven afleveres hos naboen:</strong> ' . $leave_gift_at_neighbour . '</p>';

    echo $str;
}
add_action( 'woocommerce_admin_order_data_after_billing_address', 'greeting_delivery_date_display_admin_order_meta' );



function admin_order_preview_add_receiver_info_custom_meta_data( $data, $order ) {
    if( $receiver_info_value = $order->get_meta('receiver_phone') )
        $data['receiver_info_key'] = $receiver_info_value; // <= Store the value in the data array.
    return $data;
}
// Add custom order meta data to make it accessible in Order preview template#add_filter( 'woocommerce_admin_order_preview_get_order_details', 'admin_order_preview_add_receiver_info_custom_meta_data', 10, 2 );


function custom_display_order_receiver_info_data_in_admin(){
    // Call the stored value and display it
    echo '<div style="margin:5px 0px 0px 15px;"><strong>Receiver Info:</strong> {{data.receiver_info_key}}</div>';
}
// Display order date in admin order preview
add_action( 'woocommerce_admin_order_preview_start', 'custom_display_order_receiver_info_data_in_admin' );


function unit_before_order_itemmeta( $item_id, $item, $product ){
    // Only "line" items and backend order pages
    if( ! ( is_admin() && $item->is_type('line_item') ) ) return;

    $unit = $product->get_meta('notes');

    if( ! empty($unit) ) {
        echo '<p><b>Ønsker til produkt:</b> '.$unit.'</p>';
    }
}
add_action( 'woocommerce_before_order_itemmeta', 'unit_before_order_itemmeta', 10, 3 );


// Change display label for custom note meta key
function change_custom_note_meta_key_label($meta_keys) {
    if($meta_keys == "_custom_note"){
        $meta_keys =  __('Kundens ønske til gavens indhold','greeting3');
    }
    return $meta_keys;
}
add_filter('woocommerce_order_item_display_meta_key', 'change_custom_note_meta_key_label', 10, 1);