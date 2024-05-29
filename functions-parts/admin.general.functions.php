<?php

/*
 * Function for registering new Order Statusses for Greeting.dk
 */
function register_new_greeting_order_status() {
    register_post_status( 'wc-delivered', array(
        'label'                     => 'Delivered',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Delivered <span class="count">(%s)</span>', 'Delivered <span class="count">(%s)</span>' )
    ) );

    register_post_status( 'wc-order-seen', array(
        'label'                     => 'Order Seen by Vendor',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Order Seen by Vendor <span class="count">(%s)</span>', 'Order Seen by Vendor <span class="count">(%s)</span>' )
    ) );

    register_post_status( 'wc-order-mail-open', array(
        'label'                     => 'Vendor Opened Mail',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Vendor Opened Mail <span class="count">(%s)</span>', 'Vendor opened Mail <span class="count">(%s)</span>' )
    ) );

    register_post_status( 'wc-order-forwarded', array(
        'label'                     => 'Order Sent to Vendor',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Order Forwarded to Vendor <span class="count">(%s)</span>', 'Order Forwarded to Vendor <span class="count">(%s)</span>' )
    ) );

    register_post_status( 'wc-order-accepted', array(
        'label'                     => 'Vendor Accepted',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Vendor Marked Order Received <span class="count">(%s)</span>', 'Vendor Marked Order Received <span class="count">(%s)</span>' )
    ) );
}
add_action( 'init', 'register_new_greeting_order_status' );



function add_awaiting_delivered_to_order_statuses( $order_statuses ) {
    $new_order_statuses = array();

    foreach ( $order_statuses as $key => $status ) {

        $new_order_statuses[ $key ] = $status;

        if ( 'wc-processing' === $key ) {
            $new_order_statuses['wc-order-mail-open'] = 'Vendor Opened Mail';
            $new_order_statuses['wc-order-seen'] = 'Order Seen by Vendor';
            $new_order_statuses['wc-order-forwarded'] = 'Order Forwarded to Vendor';
            $new_order_statuses['wc-order-accepted'] = 'Vendor Accepted';
            $new_order_statuses['wc-delivered'] = 'Leveret';
        }
        if( 'wc-on-hold' === $key ){
            unset( $new_order_statuses['wc-on-hold'] );
        }
    }

    return $new_order_statuses;
}
add_filter( 'wc_order_statuses', 'add_awaiting_delivered_to_order_statuses' );


/**
 * Function for adding order status CSS to the order overview
 * Function to add buttons on the admin actions cell for each order in the admin order list.
 *
 * @return void
 */
function add_custom_order_status_actions_button_css() {
    echo '<style>
		.view.delivered::after { font-family: woocommerce; content: "\1F69A" !important; }
		.tracking.link::after { font-family: woocommerce; content: "\1F6E0" !important; }
		</style>';
}
add_action( 'admin_head', 'add_custom_order_status_actions_button_css' );

/**
 * Function for styling order statis 'buttons' / tags on order lines in the table.
 *
 * @return void
 */
function styling_admin_order_list() {
    global $pagenow, $post;

    if( $pagenow != 'edit.php') return; // Exit
    if( is_object($post) && get_post_type($post->ID) != 'shop_order' ) return; // Exit

    // HERE we set your custom status
    $order_status = 'Order Mail Open'; // <==== HERE
    echo '<style>
      .order-status.status-'.sanitize_title( $order_status ).'{
          background: #f2e59d;
          color: #a39443;
      }
    </style>';

    $order_status = 'Order Seen'; // <==== HERE
    echo '<style>
			.order-status.status-'.sanitize_title( $order_status ).'{
					background: #d7f8a7;
					color: #0c942b;
			}
		</style>';

    $order_status = 'Delivered'; // <==== HERE
    echo '<style>
      .order-status.status-'.sanitize_title( $order_status ).'{
          background: #0c942b;
          color: #d7f8a7;
      }
    </style>';

    $order_status = 'Order Forwarded'; // <==== HERE
    echo '<style>
      .order-status.status-'.sanitize_title( $order_status ).'{
          background: #98d8ed;
          color: #3d7d91;
      }
    </style>';

    $order_status = 'Order Seen'; // <==== HERE
    echo '<style>
			.order-status.status-'.sanitize_title( $order_status ).'{
					background: #d7f8a7;
					color: #0c942b;
			}
		</style>';
}
add_action('admin_head', 'styling_admin_order_list' );

/**
 * Remove the JetPack admin header notice.
 */
add_action('admin_head', 'custom_admin_head');
function custom_admin_head() {
    ?><style>.notice.wcs-nux__notice{display:none;}</style><?php
}