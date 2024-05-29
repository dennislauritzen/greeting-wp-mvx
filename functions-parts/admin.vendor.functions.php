<?php


/**
 * Register meta box(es).
 * This is for changing vendor data on an order
 *
 * @author Dennis Lauritzen
 */
function greeting_change_vendor_show_meta() {
    add_meta_box( 'meta-change-vendor', __( 'Change Vendor', 'textdomain' ), 'greeting_change_vendor_show_meta_callback', 'shop_order' );
}
add_action( 'add_meta_boxes', 'greeting_change_vendor_show_meta' );

/**
 * Meta box display callback.
 * This is for changing vendor data on an order
 *
 * @author Dennis Lauritzen
 * @param WP_Post $post Current post object.
 */
function greeting_change_vendor_show_meta_callback( $post ) {
    // Display code/markup goes here. Don't forget to include nonces!
    global $wpdb;

    $args = array(
        'fields' => 'all_with_meta',
        'role' => 'dc_vendor'
    );
    $query = new WP_User_Query($args);
    $stores = $query->get_results();
    $current_store = get_post_meta($post->ID, '_vendor_id', true);

    wp_nonce_field( 'greeting_vendor_change_metabox_action', 'greeting_vendor_change' );
    echo '<select name="vendor_meta_name">';
    foreach($stores as $k => $v){
        $selected = ($current_store == $v->ID ? ' selected="selected"' : '');
        $name = get_user_meta( $v->ID, '_vendor_page_title', true );
        echo '<option value="'.$v->ID.'"'.$selected.'>'.$name.'</option>';
    }
    echo '</select>';
}

/**
 * Function for changing an order to another vendor
 *
 * @author Dennis Lauritzen
 * @param Integer $post_id
 * @return void
 */
function greeting_change_vendor_show_meta_action( $post_id ) {
    if( !isset( $_POST['vendor_meta_name'] ) || !wp_verify_nonce( $_POST['greeting_vendor_change'],'greeting_vendor_change_metabox_action') )
        return;

    if ( !current_user_can( 'manage_options', $post_id ))
        return;

    if ( isset($_POST['vendor_meta_name']) ) {
        $vendor_id = sanitize_text_field( $_POST['vendor_meta_name']);
        update_post_meta($post_id, '_vendor_id', $vendor_id);
        #// Assuming the vendor name is stored in another custom field, adjust the field name accordingly
        $vendor_name = get_vendor_name_by_id( $vendor_id ); // Replace with your actual function to get vendor name
        update_post_meta( $post_id, '_vendor_name', sanitize_text_field( $vendor_name ) );
    }

}
add_action('save_post', 'greeting_change_vendor_show_meta_action');

/**
 * Function for getting the vendor name from a vendor ID.
 *
 * @param $vendor_id
 * @return string
 */
function get_vendor_name_by_id($vendor_id) {
    $vendor_user = get_userdata($vendor_id);
    return $vendor_user ? $vendor_user->display_name : '';
}

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
    $actions['wc_custom_order_action_delivery_notice'] = __( 'Gensend leveringsbekræftelse til kunde', 'greeting2' );
    $actions['wc_custom_order_action_test_mail'] = __( 'SEND TEST MAIL', 'greeting2' );
    return $actions;
}
add_action( 'woocommerce_order_actions', 'greeting_wc_add_order_meta_box_action' );


/**
 * Hide fields through CSS in the vendor user admin
 *
 * @author Dennis Lauritzen
 * @return void
 */
function vendor_hide_fields_css() {
    $edited_user_id = isset($_REQUEST['user_id']) ? absint($_REQUEST['user_id']) : 0;

    // Check if the current user has the 'dc_vendor' role
    if ($edited_user_id > 0
        && current_user_can('administrator')
        && in_array('dc_vendor', get_userdata($edited_user_id)->roles)) {
        // Hide specific fields or sections by their IDs or names
        ?>
        <style type="text/css">
            /* Replace 'field-id' with the actual ID or name of the field you want to hide */
            .vendor_fb_profile_wrapper,
            .vendor_instagram_wrapper,
            .vendor_twitter_profile_wrapper,
            .vendor_linkdin_profile_wrapper,
            .vendor_pinterest_profile_wrapper,
            .vendor_youtube_wrapper,
            .vendor_csd_return_address1_wrapper,
            .vendor_csd_return_address2_wrapper,
            .vendor_csd_return_country_wrapper,
            .vendor_csd_return_state_wrapper,
            .vendor_csd_return_city_wrapper,
            .vendor_csd_return_zip_wrapper,
            .vendor_customer_phone_wrapper,
            .vendor_customer_email_wrapper,
            .vendor_paypal_email_wrapper,
            .vendor_give_tax_wrapper,
            .vendor_give_shipping_wrapper,
            .vendor_hide_address_wrapper,
            .vendor_hide_phone_wrapper,
            .vendor_hide_email_wrapper,
            .vendor_hide_description_wrapper,
            .vendor_message_to_buyers_wrapper
            {
                display: none;
            }
        </style>
        <?php
    }
}
add_action('admin_head', 'vendor_hide_fields_css');

/**
 * Remove unneccessary shipping fields from admin
 *
 * @author Dennis Lauritzen
 * @param Array $show_fields
 * @return Array
 */
function vendor_remove_shipping_fields($show_fields) {
    // Get the ID of the user currently being edited
    $edited_user_id = isset($_REQUEST['user_id']) ? absint($_REQUEST['user_id']) : 0;

    // Check if the current user is an administrator and if the user being edited has the 'dc_vendor' role
    if ($edited_user_id > 0
        && current_user_can('administrator')
        && in_array('dc_vendor', get_userdata($edited_user_id)->roles)) {
        // Check if $show_fields is an array before attempting to loop through it

        if (is_array($show_fields)) {
            unset($show_fields['billing']);
            unset($show_fields['shipping']);
        }
    }

    return $show_fields;
}
add_filter( 'woocommerce_customer_meta_fields', 'vendor_remove_shipping_fields' );

/**
 * Removing unnecessary fields from vendor admin
 *
 * @param $contactmethods
 * @param $user
 * @return mixed
 */
function vendor_remove_fields_from_admin($contactmethods, $user) {
    // Check if the current user is an administrator and if the user being edited has the 'dc_vendor' role
    $current_user = wp_get_current_user();

    if (current_user_can('administrator') && is_array($contactmethods) && $user && is_object($user)) {
        // Check if the user has roles and if 'dc_vendor' is among them
        $user_roles = $user->roles;
        if (is_array($user_roles) && in_array('dc_vendor', $user_roles)) {
            // Replace 'field-id' with the actual ID or name of the field you want to unset
            $fields_to_unset = array(
                'facebook',
                'instagram',
                'linkedin',
                'twitter',
                'youtube',
                'wikipedia',
                'myspace',
                'pinterest',
                'soundcloud',
                'tumblr',
                'facebook_profile',
                'twitter_profile',
                'linkedin_profile',
                'github_profile',
                'vendor_csd_return_address1',
                'vendor_csd_return_address2'
            );

            // Unset each shipping address field
            foreach ($fields_to_unset as $field) {
                unset($contactmethods[$field]);
            }
        }
    }

    return $contactmethods;
}
add_filter('user_contactmethods', 'vendor_remove_fields_from_admin', 10, 2);


