<?php


/**
 * Register vendor ID in Rest API.
 * Make sure to use PHP >= 5.4
 *
 * @author Dennis Lauritzen
 */
add_action(
    'rest_api_init',
    function () {
        // Field name to register.
        $field = '_vendor_id';
        register_rest_field(
            'shop_order',
            $field,
            array(
                'get_callback'    => function ( $object ) use ( $field ) {
                    // Get field as single value from post meta.
                    return get_post_meta( $object['id'], $field, true );
                },
                'update_callback' => function ( $value, $object ) use ( $field ) {
                    // Update the field/meta value.
                    update_post_meta( $object->ID, $field, $value );
                },
                'schema'          => array(
                    'type'        => 'string',
                    'arg_options' => array(
                        'sanitize_callback' => function ( $value ) {
                            // Make the value safe for storage.
                            return sanitize_text_field( $value );
                        },
                        'validate_callback' => function ( $value ) {
                            // Valid if it contains exactly 10 English letters.
                            return (bool) preg_match( '/\A[a-z]{10}\Z/', $value );
                        },
                    ),
                ),
            )
        );
    }
);

/**
 * Register vendor name in Rest API.
 * Make sure to use PHP >= 5.4
 *
 * @author Dennis Lauritzen
 */
add_action(
    'rest_api_init',
    function () {
        // Field name to register.
        $field = '_vendor_name';
        register_rest_field(
            'shop_order',
            $field,
            array(
                'get_callback'    => function ( $object ) use ( $field ) {
                    // Get field as single value from post meta.
                    return get_post_meta( $object['id'], $field, true );
                },
                'schema'          => array(
                    'type'        => 'string',
                    'arg_options' => array(
                        'sanitize_callback' => function ( $value ) {
                            // Make the value safe for storage.
                            return sanitize_text_field( $value );
                        },
                        'validate_callback' => function ( $value ) {
                            // Valid if it contains exactly 10 English letters.
                            return (bool) preg_match( '/\A[a-z]{10}\Z/', $value );
                        },
                    ),
                ),
            )
        );
    }
);

/**
 * Register a users first order date in Rest API.
 * Make sure to use PHP >= 5.4
 *
 * @author Dennis Lauritzen
 */
add_action(
    'rest_api_init',
    function () {
        // Field name to register.
        $field = '_first_order_date';
        $order_meta = array();
        $meta_key = "";
        $meta_value = "";

        register_rest_field(
            'shop_order',
            $field,
            array(
                'get_callback'    => function ( $object ) use ( $field ) {
                    // Get the customer ID if logged in.
                    $order_id = $object['id'];

                    $customer_id = get_post_meta( $order_id, '_customer_user', true );
                    $billing_email = '';

                    // If not logged in, try to get customer ID using email.
                    if ( empty( $customer_id ) ) {
                        $billing_email = get_post_meta( $order_id, '_billing_email', true );
                        $customer_id = email_exists( $billing_email );
                    }

                    $order = get_customer_order($customer_id, $billing_email, 'first');

                    $first_order_date = $order ? ( $order->get_date_created() ? gmdate( 'Y-m-d H:i:s',
                        $order->get_date_created()->getOffsetTimestamp() ) : '' ) : '';

                    if(!empty($first_order_date)){
                        return $first_order_date;
                    }

                    return null;
                },
                'update_callback' => function ( $value, $object ) use ( $field ) {
                    // This field is read-only, so no need for an update callback.
                    return;
                },
                'schema'          => array(
                    'type' => 'string',
                ),
            )
        );
    }
);

/**
 * Get a users order based on either customer ID or billing e-mail
 *
 * @param $customer_id integer
 * @param $billing_email object
 * @param $first_or_last string #Values: 'first' or 'last'
 * @return bool|WC_Order|WC_Order_Refund
 */
function get_customer_order( $customer_id, $billing_email, $first_or_last )
{
    global $wpdb;

    if (!empty($customer_id)) {
        $meta_key = "_customer_user";
        $meta_value = $customer_id;
    } elseif (!empty($billing_email)) {
        $meta_key = "_billing_email";
        $meta_value = $billing_email;
    } else {
        return false;
    }

    if ('first' === $first_or_last) {
        $direction = 'ASC';
    } else if ('last' === $first_or_last) {
        $direction = 'DESC';
    } else {
        return false;
    }


    #$order = $wpdb->get_var(
    #// phpcs:disable WordPress.DB.PreparedSQL.NotPrepared
    #    "SELECT posts.ID
    #		FROM $wpdb->posts AS posts
    #		LEFT JOIN {$wpdb->postmeta} AS meta on posts.ID = meta.post_id
    #		WHERE meta.meta_key = '" . $meta_key . "'
    #		AND   meta.meta_value = '" . esc_sql($meta_value) . "'
    #		AND   posts.post_type = 'shop_order'
    #		AND   posts.post_status IN ( '" . implode("','", array_map('esc_sql', array_keys(wc_get_order_statuses()))) . "' )
    #		ORDER BY posts.ID {$direction}"
    #// phpcs:enable
    #);

    $prepared_query = $wpdb->prepare(
        "SELECT posts.ID
    FROM $wpdb->posts AS posts
    LEFT JOIN {$wpdb->postmeta} AS meta on posts.ID = meta.post_id
    WHERE meta.meta_key = %s
    AND meta.meta_value = %s
    AND posts.post_type = 'shop_order'
    AND posts.post_status IN ( '" . implode("','", array_map('esc_sql', array_keys(wc_get_order_statuses()))) . "' )
    ORDER BY posts.ID {$direction}",
        $meta_key,
        $meta_value
    );

    $order = $wpdb->get_var($prepared_query);

    if (!$order) {
        return false;
    }

    return wc_get_order(absint($order));
}