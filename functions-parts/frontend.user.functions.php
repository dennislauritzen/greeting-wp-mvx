<?php


/**
 * Format WordPress User's "Display Name" to Full Name on Login
 * ------------------------------------------------------------------------------
 *
 * @author Dennis Lauritzen
 * @param String $username
 * @return void
 */

add_action( 'wp_login', 'greeting_r19029_format_user_display_name_on_login' );
function greeting_r19029_format_user_display_name_on_login( $username ) {
    $user = get_user_by( 'login', $username );

    $first_name = get_user_meta( $user->ID, 'first_name', true );
    $last_name = get_user_meta( $user->ID, 'last_name', true );

    $full_name = trim( $first_name . ' ' . $last_name );

    if ( ! empty( $full_name ) && ( $user->data->display_name != $full_name ) ) {
        $userdata = array(
            'ID' => $user->ID,
            'display_name' => $full_name,
        );

        wp_update_user( $userdata );
    }
}



function login_failed() {
    $login_page  = home_url( '/log-ind/' );
    wp_redirect( $login_page . '?login=failed' );
    exit;
}
add_action( 'wp_login_failed', 'login_failed' );


function wpcc_front_end_login_fail( $username ) {
    $referrer = $_SERVER['HTTP_REFERER'];
    if ( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) ) {
        $referrer = esc_url( remove_query_arg( 'login', $referrer ) );
        wp_redirect( $referrer . '?login=failed' );
        exit;
    }
}
add_action( 'wp_login_failed', 'wpcc_front_end_login_fail' );


function custom_authenticate_wpcc( $user, $username, $password ) {
    if ( is_wp_error( $user ) && isset( $_SERVER[ 'HTTP_REFERER' ] ) && !strpos( $_SERVER[ 'HTTP_REFERER' ], 'wp-admin' ) && !strpos( $_SERVER[ 'HTTP_REFERER' ], 'wp-login.php' ) ) {
        $referrer = $_SERVER[ 'HTTP_REFERER' ];
        foreach ( $user->errors as $key => $error ) {
            if ( in_array( $key, array( 'empty_password', 'empty_username') ) ) {
                unset( $user->errors[ $key ] );
                $user->errors[ 'custom_'.$key ] = $error;
            }
        }
    }

    return $user;
}
add_filter( 'authenticate', 'custom_authenticate_wpcc', 31, 3);


function logout_page() {
    $login_page  = home_url( '/log-ind/' );
    wp_redirect( $login_page . "?login=false" );
    exit;
}
add_action('wp_logout','logout_page');