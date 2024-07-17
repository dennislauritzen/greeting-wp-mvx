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
                    // Ensure correct retrieval of order ID.
                    $order_id = empty( $object['id'] ) ? $object->get_id() : $object['id'];
                    // Use the CRUD method to get the order.
                    $order = wc_get_order( $order_id );
                    if ( $order ) {
                        return $order->get_meta( $field, true );
                    }
                    return null;
                },
                'update_callback' => function ( $value, $object ) use ( $field ) {
                    // Ensure correct retrieval of order ID.
                    $order_id = empty( $object->ID ) ? $object->get_id() : $object->ID;
                    // Use the CRUD method to get the order and update the meta field.
                    $order = wc_get_order( $order_id );
                    if ( $order ) {
                        $order->update_meta_data( $field, sanitize_text_field( $value ) );
                        $order->save(); // Save the changes
                    }
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
                    // Ensure correct retrieval of order ID.
                    $order_id = empty( $object['id'] ) ? $object->get_id() : $object['id'];
                    // Use the CRUD method to get the order.
                    $order = wc_get_order( $order_id );
                    if ( $order ) {
                        return $order->get_meta( $field, true );
                    }
                    return null;
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
 * Register a user's first order date in Rest API.
 * Make sure to use PHP >= 5.4
 *
 * @author Dennis Lauritzen
 */
add_action(
    'rest_api_init',
    function () {
        // Field name to register.
        $field = '_first_order_date';

        register_rest_field(
            'shop_order',
            $field,
            array(
                'get_callback'    => function ( $object ) use ( $field ) {
                    // Ensure correct retrieval of order ID.
                    $order_id = empty( $object['id'] ) ? $object->get_id() : $object['id'];
                    $order = wc_get_order( $order_id );

                    if ( !$order ) {
                        return null;
                    }

                    // Get the customer ID if logged in.
                    $customer_id = $order->get_customer_id();
                    $billing_email = '';

                    // If not logged in, try to get customer ID using email.
                    if ( empty( $customer_id ) ) {
                        $billing_email = $order->get_billing_email();
                        $customer_id = email_exists( $billing_email );
                    }

                    // Function to get customer's first order.
                    function get_customer_order( $customer_id, $billing_email, $order_type = 'first' ) {
                        $args = array(
                            'customer' => $customer_id ? $customer_id : '',
                            'billing_email' => $billing_email ? $billing_email : '',
                            'limit' => -1,
                            'orderby' => 'date',
                            'order' => 'ASC',
                        );

                        // Get orders
                        $orders = wc_get_orders( $args );

                        if ( $order_type == 'first' && !empty( $orders ) ) {
                            return reset( $orders );
                        }

                        return null;
                    }

                    $first_order = get_customer_order( $customer_id, $billing_email, 'first' );

                    $first_order_date = $first_order ? ( $first_order->get_date_created() ? gmdate( 'Y-m-d H:i:s',
                        $first_order->get_date_created()->getOffsetTimestamp() ) : '' ) : '';

                    if ( !empty( $first_order_date ) ) {
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
 * Get a user's order based on either customer ID or billing email.
 *
 * @param int $customer_id
 * @param string $billing_email
 * @param string $first_or_last # Values: 'first' or 'last'
 * @return bool|WC_Order
 */
function get_customer_order( $customer_id, $billing_email, $first_or_last ) {
    if ( empty( $customer_id ) && empty( $billing_email ) ) {
        return false;
    }

    $args = array(
        'limit'        => 1,
        'orderby'      => 'date',
        'order'        => $first_or_last === 'first' ? 'ASC' : 'DESC',
        'return'       => 'ids',
    );

    if ( !empty( $customer_id ) ) {
        $args['customer_id'] = $customer_id;
    } elseif ( !empty( $billing_email ) ) {
        $args['billing_email'] = $billing_email;
    }

    $orders = wc_get_orders( $args );

    if ( empty( $orders ) ) {
        return false;
    }

    return wc_get_order( $orders[0] );
}