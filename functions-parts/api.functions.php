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
                        if(is_wc_hpos_activated()){
                            $order->update_meta_data( $field, sanitize_text_field( $value ) );
                            $order->save(); // Save the changes
                        } else {
                            update_post_meta( $order->get_id(), $field, sanitize_text_field( $value ) );
                        }
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

                    // Get customer's first order.
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


/**
 * Add the function of get_postal_code as an endpoint to the API
 * @endpoint
 */
add_action('rest_api_init', function () {
    register_rest_route('custom/v2', '/get-postal-code', array(
        'methods' => 'GET',
        'callback' => 'get_postal_code',
        'permission_callback' => '__return_true', // Adjust this for better security as needed
    ));
});

/**
 * Function to handle all postal code requests
 *
 * @param WP_REST_Request $request
 * @param int $return_associated_postals Want the associated postals returned in the json?
 * @return WP_Error
 */
function get_postal_code(WP_REST_Request $request) {
    $lat = $request->get_param('lat');
    $lon = $request->get_param('lon');
    $postal_code = $request->get_param('postal');

    // Get the 'assoc' parameter from the request and cast it to an integer
    $return_assoc = (int) $request->get_param('assoc');

    // Ensure $return_assoc is an integer; default to 0 if not
    if (!is_integer($return_assoc)) {
        $return_assoc = 0;
    }

    $ip = ($_SERVER['REMOTE_ADDR'] == '::1') ? '93.165.251.215' : $_SERVER['REMOTE_ADDR'];

    $cache_key_ip = 'ip_addr_' . md5($ip);
    $cached_data_ip = wp_cache_get($cache_key_ip);
    if($cached_data_ip){
        $response_data_arr_ip = json_decode($cached_data_ip);
        $response_data_arr_ip['cached_status'] = 'cached';
        return rest_ensure_response( $response_data_arr_ip );
    }

    if (!$lat || !$lon || !$postal_code) {
        // If no lat/lon, use IP to get lat/lon
        $apis = array(
            'ipapi.co' => "https://ipapi.co/".$ip."/json/",
            'ip-api.com' => "http://ip-api.com/json/".$ip,
            'freeipapi.com' => "https://freeipapi.com/api/json/".$ip,
        );

        $data = fetch_ip_location($apis);

        if (is_wp_error($data)) {
            return $data;
        }

        $lat = $data['lat'];
        $lon = $data['lon'];
        $postal_code = isset($data['postal_code']) ? $data['postal_code'] : null;
        // Cache the postal code for the IP for 7 days
        wp_cache_set(
            $cached_data_ip,
            json_encode(array('postal_code' => $postal_code)),
            '',
            7 * (60 * 60 * 24)
        );
    }

    // If postal code is still not found, return an error
    if (!$postal_code) {
        return new WP_Error('api_error', 'Failed to fetch postal code', array('status' => 500));
    }

    // Generate cache key and check for cached data
    $cache_key = 'postal_code_' . md5($postal_code);
    $cached_data = wp_cache_get($cache_key);

    if ($cached_data) {
        return rest_ensure_response(json_decode($cached_data, true));
    }

    // Cache the postal code for 7 days
    wp_cache_set(
        $cache_key,
        json_encode(array('postal_code' => $postal_code)),
        '',
        7 * (60 * 60 * 24)
    );

    $return_arr = array(
        'postal_code' => $postal_code
    );
    if($return_assoc === 1){
        // Call the refactored function to get featured postal codes
        $featured_postal_codes = get_featured_postal_codes_api($postal_code);
        $return_arr['related'] = $featured_postal_codes;
    }

    return rest_ensure_response( $return_arr );
}

function fetch_ip_location($apis) {
    foreach ($apis as $api_name => $api_url) {
        $response = wp_remote_get($api_url);
        if (is_wp_error($response)) {
            continue; // Try the next API
        }

        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code !== 200) {
            continue; // Try the next API
        }

        $data = json_decode(wp_remote_retrieve_body($response), true);

        // Ensure the data format matches the expected structure
        switch ($api_name) {
            case 'ipapi.co':
                if (isset($data['latitude']) && isset($data['longitude'])) {
                    return array('lat' => $data['latitude'], 'lon' => $data['longitude'], 'postal_code' => $data['postal']);
                }
                break;
            case 'ip-api.com':
                if (isset($data['lat']) && isset($data['lon'])) {
                    return array('lat' => $data['lat'], 'lon' => $data['lon'], 'postal_code' => $data['zip']);
                }
                break;
            case 'freeipapi.com':
                if (isset($data['latitude']) && isset($data['longitude'])) {
                    return array('lat' => $data['latitude'], 'lon' => $data['longitude'], 'postal_code' => $data['zipCode']);
                }
                break;
        }
    }

    return new WP_Error('api_error', 'All IP location APIs failed', array('status' => 500));
}


add_action('rest_api_init', function () {
    register_rest_route('custom/v2', '/get-featured-postal-codes', array(
        'methods' => 'GET',
        'callback' => 'get_featured_postal_codes_api_call',
        'permission_callback' => '__return_true', // Adjust this for better security as needed
    ));
});

function get_featured_postal_codes_api_call(WP_REST_Request $request) {
    $postal_code = $request->get_param('postal');

    if (!$postal_code) {
        return new WP_Error('no_postal_code', 'Postal code is required', array('status' => 400));
    }

    // Generate cache key
    $cache_key = 'featured_postal_codes_' . md5($postal_code);

    // Check for cached data
    $cached_data = wp_cache_get($cache_key);

    #var_dump($cached_data);

    if ($cached_data) {
        // If data is cached
        #error_log("Cache hit for key: $cache_key");
        $response_data = json_decode($cached_data, true);
        $response_data['cache_status'] = 'cached';
    } else {
        // If data is not cached, fetch it and cache the result
        #error_log("Cache miss for key: $cache_key");
        $featured_postal_codes = get_featured_postal_codes_api($postal_code);

        // Cache the result for 7 days
        $wp_cache_set = wp_cache_set(
            $cache_key,
            json_encode($featured_postal_codes),
            '',
            7 * (60 * 60 * 24)
        );

        $response_data = $featured_postal_codes;
        $response_data['cache_status'] = 'fresh';
    }

    return rest_ensure_response($response_data);
}

function get_featured_postal_codes_api($postal_code){
    global $wpdb;

    $user_areas = get_user_area($postal_code);

    // Postal code array to submit
    $postal_code_arr = array();

    // Get the actual postal code
    $postal_args2 = array(
        'post_type' => 'city',
        'posts_per_page' => '1',
        'meta_query' => array(
            array(
                'key' => 'postalcode',
                'value' => $postal_code,
                'compare' => '='
            )
        ),
        'no_found_rows' => true
    );
    $postal_query2 = new WP_Query($postal_args2);
    foreach($postal_query2->posts as $k => $postal){
        $postal_code_arr[] = array(
            'link' => get_permalink($postal->ID),
            'postal' =>  get_post_meta($postal->ID, 'postalcode', true),
            'city' => get_post_meta($postal->ID, 'city', true)
        );
    }

    // Get the close areas
    $postal_args = array(
        'post_type' => 'city',
        'posts_per_page' => '7',
        'orderby' => 'meta_value',
        'meta_key' => 'is_featured_city',
        'order' => 'DESC',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'postalcode',
                'value' => array($user_areas['start'], $user_areas['end']),
                'compare' => 'BETWEEN',
                'type' => 'numeric'
            ),
            array(
                'key' => 'postalcode',
                'value' => (!empty($postal_code) ? $postal_code : (int) '0999'),
                'compare' => '!=',
                'type' => 'numeric'
            )
        ),
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false
    );
    $postal_query = new WP_Query($postal_args);
    foreach($postal_query->posts as $k => $postal){
        $postal_query->the_post();
        $postal_code_arr[] = array(
            'link' => get_permalink($postal->ID),
            'postal' =>  get_post_meta($postal->ID, 'postalcode', true),
            'city' => get_post_meta($postal->ID, 'city', true)
        );
    }
    return $postal_code_arr;
    #wp_die();
}