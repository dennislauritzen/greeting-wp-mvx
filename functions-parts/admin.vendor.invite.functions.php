<?php

// Get the order util in order to check
// if HPOS is activated, and if it is, then
// add order meta in a new way
use Automattic\WooCommerce\Utilities\OrderUtil;
use Automattic\WooCommerce\Internal\DataStores\Orders\CustomOrdersTableController;


function register_vendor_invite_post_type() {
	$args = array(
		'public' => false,
		'label'  => __( 'Vendor Invites', 'greeting3' ),
		'supports' => array( 'title', 'editor', 'custom-fields' ),
		'rewrite' => array( 'slug' => 'vendor-invite' ),
		'show_in_rest' => true, // Optional: If you want to use the Block Editor
	);
	register_post_type( 'vendor_invite', $args );
}
add_action( 'init', 'register_vendor_invite_post_type' );

// Include custom email class file
function add_vendor_invite_email_class( $email_classes ) {
	if ( ! isset( $email_classes['WC_Email_Vendor_Order_Invite'] ) || ! is_a( $email_classes['WC_Email_Vendor_Order_Invite'], 'WC_Email_Vendor_Order_Invite' ) ) {
		// Check if the class has been instantiated already
		if ( ! class_exists( 'WC_Email_Vendor_Order_Invite' ) ) {
			$email_classes['WC_Email_Vendor_Order_Invite'] = include_once('admin.vendor.invite.email.class.php');
		}
	}
	return $email_classes;
}
add_filter( 'woocommerce_email_classes', 'add_vendor_invite_email_class' );



// Add a meta box in the order edit screen to invite vendors
add_action( 'add_meta_boxes_shop_order', 'add_invite_vendor_metabox' );
function add_invite_vendor_metabox( $post ) {
	// Get the WC_Order object
	$order = is_a( $post, 'WP_Post' ) ? wc_get_order( $post->ID ) : $post;

	// Attempt to get the vendor ID from a meta field (ensure this field exists)
	$vendor_id = get_post_meta( $order->get_id(), '_vendor_id', true );

	// If vendor_id is empty, output a debug message
	if ( empty( $vendor_id ) ) {
		return;  // Do not add the meta box if no vendor_id
	}

	// Get the list of allowed user IDs from the ACF settings page
	$allowed_vendor_data = get_field( 'greeting_store_user_id', 'option' ); // Assuming the field is set in options page
	$allowed_vendor_ids = array_column( $allowed_vendor_data, 'ID' ); // Extract 'ID' from each array in $allowed_vendor_data

	// Check if the vendor ID exists in the allowed list
	if ( in_array( $vendor_id, $allowed_vendor_ids ) ) {
		add_meta_box(
			'invite_vendor_metabox',
			__('Invitér butikspartner til at overtage', 'greeting3'),
			'invite_vendor_metabox_callback',
			'shop_order',
			'side'
		);

	}
}


function invite_vendor_metabox_callback( $post ) {
	// Get the order's delivery postal code
	// Get the WC_Order object
	$order = is_a( $post, 'WP_Post' ) ? wc_get_order( $post->ID ) : $post;

	// Attempt to get the vendor ID from a meta field (ensure this field exists)
	$vendor_id = get_post_meta( $order->get_id(), '_vendor_id', true );

	$shipping_postcode = $order->get_shipping_postcode();

	// Query vendors whose 'delivery_postal_codes' meta field contains the order's postal code
	$vendors = get_users(array(
		'role' => 'dc_vendor',
		'meta_query' => array(
			'relation' => 'AND',  // Ensure both conditions must be met
			array(
				'key' => 'delivery_zips',
				'value' => $shipping_postcode,
				'compare' => 'LIKE',  // Match postal code within a comma-separated list
			), array(
				'key' => 'delivery_type',  // ACF field for delivery type
				'value' => '"1"',               // Integer 1 for "Personlig levering"
				'compare' => 'LIKE'
			),
		),
	));

	#var_dump($vendors);

	// Display checkboxes for each vendor
	$vendor_ids_to_exclude = array();
	echo '<div style="height: 200px; overflow-y: scroll;">';
	foreach ($vendors as $vendor) {
		$vendor_ids_to_exclude[] = $vendor->ID;
		$vendor_page_title = get_user_meta($vendor->ID, '_vendor_page_title', true);
		echo '<span style="display: block; padding: 3px 0 2px 0;">';
		echo '<input type="checkbox" name="invite_vendors[]" id="invite_vendor' . $vendor->ID . '" value="' . esc_attr($vendor->ID) . '"> ';
		echo '<label for="invite_vendor' . $vendor->ID . '">' . esc_html($vendor_page_title) . ' (' . esc_html($vendor->display_name) . ')</label>';
		echo '</span>';
	}

	echo '<hr><b>Butikker der ikke leverer her som standard:</b>';

	// Query vendors who cannot deliver to the area (excluding the ones already listed above)
	$vendors = get_users(array(
		'role' => 'dc_vendor',
		'exclude' => $vendor_ids_to_exclude,  // Exclude vendors who can deliver to the area
		'meta_query' => array(
			'relation' => 'AND',  // Ensure both conditions must be met
			array(
				'key' => 'delivery_type',  // ACF field for delivery type
				'value' => '"1"',               // Integer 1 for "Personlig levering"
				'compare' => 'LIKE'
			),
		),
	));

	foreach ($vendors as $vendor) {
		echo '<span style="display: block; padding: 3px 0 2px 0;">';
		echo '<input type="checkbox" name="invite_vendors[]" id="invite_vendor' . $vendor->ID . '" value="' . esc_attr($vendor->ID) . '"> ';
		echo '<label for="invite_vendor' . $vendor->ID . '">' . esc_html($vendor->display_name) . '</label>';
		echo '</span>';
	}

	echo '</div>';
	wp_nonce_field('invite_vendors_nonce_action', 'invite_vendors_nonce');
}


// Check if an invite already exists for a specific vendor and order
function vendor_invite_exists( $vendor_id, $order_id ) {
	$existing_invites = get_posts( array(
		'post_type'  => 'vendor_invite',
		'meta_query' => array(
			array(
				'key'   => 'vendor_id',
				'value' => $vendor_id,
			),
			array(
				'key'   => 'order_id',
				'value' => $order_id,
			),
		),
		'fields'     => 'ids',
		'posts_per_page' => 1,
	) );

	return !empty( $existing_invites );
}

// Handle saving the invite on order update
add_action( 'save_post_shop_order', 'process_vendor_invitations' );
function process_vendor_invitations( $order_id ) {
	// Check for nonce
	if ( ! isset( $_POST['invite_vendors_nonce'] ) || ! wp_verify_nonce( $_POST['invite_vendors_nonce'], 'invite_vendors_nonce_action' ) ) {
		return;
	}

	// Verify invited vendors
	if ( isset( $_POST['invite_vendors'] ) && ! empty( $_POST['invite_vendors'] ) ) {
		$invited_vendors = array_map( 'intval', $_POST['invite_vendors'] );

		$vendor_invitations = 0;
		foreach ( $invited_vendors as $vendor_id ) {
			// Create an invite only if it doesn't already exist
				$invite = create_vendor_invite( $vendor_id, $order_id );

				// Send email notification to vendor
				if ( $invite ) {
					$vendor_invitations++;
					send_mail_for_vendor_invite( $vendor_id, $order_id, $invite['id'], $invite['guid'] );
				}
		}
		if($vendor_invitations > 0){
			// The order object
			$order = wc_get_order($order_id);

			// Get the current date and time, plus 2 hours
			$open_for_invites_until = date('Y-m-d H:i:s', strtotime('+2 hours'));

			// Update the order meta with the calculated date and the boolean
			$order->update_meta_data('_open_for_invites', '1');
			$order->update_meta_data('_open_for_invites_until', $open_for_invites_until);

			// Save the changes
			$order->save();
		}
	}
}

// Create a new vendor invite post
function create_vendor_invite( $vendor_id, $order_id ) {
	// Generate a unique GUID
	$invite_guid = uniqid( 'invite_', true );

	$post_data = array(
		'post_title'   => sprintf( 'Invite for Order #%d', $order_id ),
		'post_content' => sprintf( 'Invite for vendor %d to take over order #%d', $vendor_id, $order_id ),
		'post_status'  => 'pending',
		'post_type'    => 'vendor_invite',
		'meta_input'   => array(
			'vendor_id'      => $vendor_id,
			'order_id'       => $order_id,
			'invite_guid'    => $invite_guid,
			'created_at'     => current_time( 'mysql' ),
			'expiration_at'  => date( 'Y-m-d H:i:s', strtotime( '+120 minutes' ) ),
		),
	);

	$invite_post = wp_insert_post( $post_data );

	return array('id' => $invite_post, 'guid' => $invite_guid);
}

// Send email notification to the vendor
function send_mail_for_vendor_invite( $vendor_id, $order_id, $invite_id, $invite_guid ) {
	$vendor_email = get_the_author_meta( 'user_email', $vendor_id );

	// Send the e-mail
	$emails = WC()->mailer()->emails;
	$email_vendor = $emails['WC_Email_Vendor_Order_Invite']->trigger( $vendor_email, $vendor_id, $order_id, $invite_id, $invite_guid );
}


function accept_invite() {
	if ( isset( $_GET['invite_guid'] ) && isset( $_GET['invite_id'] ) ) {
		$invite_guid = sanitize_text_field( $_GET['invite_guid'] );
		$invite_id = intval( $_GET['invite_id'] );

		// Retrieve the invite post
		$invite_post = get_post( $invite_id );

		if ( $invite_post && $invite_post->post_type === 'vendor_invite' ) {
			// Check if GUID matches and if it's within the 60-minute limit
			$stored_guid = get_post_meta( $invite_id, 'invite_guid', true );
			$created_at = strtotime( get_post_meta( $invite_id, 'created_at', true ) );

			if ( $stored_guid === $invite_guid && ( time() - $created_at < 3600 ) ) {
				// Proceed with order takeover logic
				// e.g., update order status, link it to the vendor, etc.

				echo __( 'You have accepted the invite!', 'greeting3' );

				// Optionally, delete the invite post if accepted
				wp_delete_post( $invite_id, true );
			} else {
				echo __( 'This invite is either invalid or has expired.', 'greeting3' );
			}
		} else {
			echo __( 'Invalid invite.', 'greeting3' );
		}
	} else {
		echo __( 'No invite found.', 'greeting3' );
	}
}


function delete_expired_invites() {
	$args = array(
		'post_type'      => 'vendor_invite',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	);

	$expired_invites = get_posts( $args );

	foreach ( $expired_invites as $invite ) {
		$created_at = strtotime( get_post_meta( $invite->ID, 'created_at', true ) );

		// If more than 60 minutes have passed, delete the invite
		if ( time() - $created_at >= (60*60*24) ) {
			wp_delete_post( $invite->ID, true );
		}
	}
}

// Schedule the cron job if it's not already scheduled
if ( ! wp_next_scheduled( 'delete_expired_invites_cron' ) ) {
	#wp_schedule_event( time(), 'hourly', 'delete_expired_invites_cron' );
}

// Hook the cleanup function to the scheduled event
add_action( 'delete_expired_invites_cron', 'delete_expired_invites' );

// ==================================================
// HANDLE THE ACCEPT
// ==================================================

// Register the custom endpoint
function greeting_accept_endpoint() {
	add_rewrite_rule(
		'^vendor-order-accept/?$',
		'index.php?acc_order_id=$matches[1]&acc_invite_id=$matches[2]&acc_invite_guid=$matches[3]&acc_vendor=$matches[4]&acc_vendor_guid=$matches[5]&acc_action_guid=$matches[6]&acc_t=$matches[7]',
		'top'
	);

	// Register each query parameter to make it accessible in WP_Query
	add_rewrite_tag('%acc_order_id%', '([0-9]+)');
	add_rewrite_tag('%acc_invite_id%', '([0-9]+)');
	add_rewrite_tag('%acc_invite_guid%', '([0-9A-Za-Z]+)');
	add_rewrite_tag('%acc_vendor%', '([0-9]+)');
	add_rewrite_tag('%acc_vendor_guid%', '([0-9A-Za-Z]+)');
	add_rewrite_tag('%acc_action_guid%', '([0-9A-Za-Z]+)');
	add_rewrite_tag('%acc_t%', '([0-9A-Za-Z]+)');
}
add_action('init', 'greeting_accept_endpoint');


// Flush rewrite rules on theme activation to ensure the endpoint is added
add_action('init', function() {
	flush_rewrite_rules();
});

function greeting_accept_template() {
	global $wp_query;

	// Check if the accept_order_id parameter is present
	if (isset($wp_query->query_vars['acc_order_id'])
		&& isset($wp_query->query_vars['acc_invite_id'])
		&& isset($wp_query->query_vars['acc_invite_guid'])
		&& isset($wp_query->query_vars['acc_vendor'])
		&& isset($wp_query->query_vars['acc_vendor_guid'])
		&& isset($wp_query->query_vars['acc_action_guid'])
		&& isset($wp_query->query_vars['acc_t'])
	){
		// Retrieve query parameters from the URL
		$get_order_id = get_query_var('acc_order_id');
		$get_invite_id = get_query_var('acc_invite_id');
		$get_invite_guid = get_query_var('acc_invite_guid');
		$get_vendor_id = get_query_var('acc_vendor');
		$get_vendor_guid = get_query_var('acc_vendor_guid');
		$get_action_guid = get_query_var('acc_action_guid');
		$get_t_var = get_query_var('acc_t');

		$action = 0;
		if($get_action_guid == 'zzkrne1FD_fe'){
			// Store answered "yes please" for the order.
			$action = 1;
		} else if($get_action_guid == 'mfefldm1_ewq'){
			// Store answered "no" for the order.
			$action = 2;
		}

		$order = wc_get_order($get_order_id);

		$calculated_invite_guid = md5('greeting____invite!Lfæaaæel41_QR!'.$get_invite_id);
		$calculated_t_var = md5('gree_inv_grrg1_;:,f,e1' . $get_order_id . $get_invite_id . $get_vendor_id);
		$calculated_vendor_guid = md5('vendor_id_id_id_fkrenfguu12_GUID_'.$get_vendor_id);

		if ($order
			&& $get_invite_guid == $calculated_invite_guid
			&& $get_t_var == $calculated_t_var
			&& $get_vendor_guid == $calculated_vendor_guid
			&& $action > 0
		) {
			$order_id = $order->get_id();
			$order_open_for_invites = $order->get_meta('_open_for_invites');
			$order_open_for_invites_until = $order->get_meta('_open_for_invites_until');

			// Get the shop vendor_id of the order
			$order_vendor_id = $order->get_meta('_vendor_id');

			// Get the current time in the same format as the stored date
			$current_time = current_time('mysql'); // Returns the current time in 'Y-m-d H:i:s' format

			// Check if the 'until' time has passed
			if(	($order_open_for_invites_until && $order_open_for_invites_until < $current_time) ){
				$order_open_for_invites = 0;
			}

			// Get the list of allowed user IDs from the ACF settings page
			$allowed_vendor_data = get_field( 'greeting_store_user_id', 'option' ); // Assuming the field is set in options page
			$allowed_vendor_ids = array_column( $allowed_vendor_data, 'ID' ); // Extract 'ID' from each array in $allowed_vendor_data

			// Check if the vendor ID exists in the allowed list
			$vendor_in_store_invitation_array = 0;
			if ( in_array( $order_vendor_id, $allowed_vendor_ids ) ) {
				$vendor_in_store_invitation_array = 1;
			}

			$invite = get_post($get_invite_id);

			if ($invite && $invite->post_type === 'vendor_invite') {
				// Successfully retrieved the invite post
				// Now you can access post properties, like:
				$invite_title = $invite->post_title;
				$invite_content = $invite->post_content;
				$invite_status = $invite->post_status;

				// Retrieve the expiry time for the invite
				$expiry_time = get_post_meta($invite->ID, 'expiration_at', true);

				// Check if the invite has expired
				$invite_expired = 0;
				if($invite_status == 'rejected'
					|| empty($expiry_time)
					|| (!empty($expiry_time) && $expiry_time < $current_time)
				){
					$invite_expired = 1;
				}

				///***********************
				/// #########################
				/// SETTING UP THE VARIABLES FOR THE TEMPLATE
				$order_inv_result = 0;
				if($action == 1){
					// Yes from the store
					$heading_positive = 'Tillykke - ordren er din';
					$heading_negative = 'Desværre - ordren er allerede accepteret af en anden butik';
					$heading_toolate = 'Desværre - invitationen er udløbet';

					if($order_open_for_invites == 1
						&& $vendor_in_store_invitation_array == 1
						&& $invite_expired == 0
					) {
						$order_inv_result = 1;

						$heading = $heading_positive;
						$text = 'Du vil modtage en e-mail snarest med de nærmere ordre- & leveringsoplysninger.';
					} else if($invite_expired == 1) {
						$order_inv_result = 0;

						$heading = $heading_toolate;
						$text = 'Hvis du mener, det er en fejl, så tag fat i os hurtigst muligt. Vi sidder klar til at hjælpe.';
					} else {
						$order_inv_result = 0;

						$heading = $heading_negative;
						$text = 'Har du spørgsmål, er du meget velkommen til at kontakte os.';
					}
				} else if($action == 2) {
					$order_inv_result = 0;
					// No from the store
					$heading = 'Tak - vi har registreret dit nej tak til ordren. :)';
					$text = 'Dit svar er registreret. Hav en rigtig god dag.';
				}

				if($order_inv_result == 1){
					// To set the post status to 'accepted'
					wp_update_post(array(
						'ID' => $invite->ID,
						'post_status' => 'accepted', // Custom status
					));
					// Set the "_answer_time" meta field to the current time
					update_post_meta($invite->ID, '_answer_time', current_time('mysql'));

					// Close all other invitations by setting their status to 'expired'
					$args = array(
						'post_type'      => 'vendor_invite',
						'post_status'    => array('pending','publish'), // Get only pending invites (or modify this if needed)
						'posts_per_page' => -1, // Get all invites
						'post__not_in'   => array($invite->ID), // Exclude the current invite
					);

					$query = new WP_Query($args);

					// Loop through the invites and set their status to 'expired'
					if ($query->have_posts()) {
						while ($query->have_posts()) {
							$query->the_post();

							wp_update_post(array(
								'ID' => get_the_ID(),
								'post_status' => 'cancelled', // Set to 'expired'
							));
						}
						wp_reset_postdata();
					}

					$vendor_id = $get_vendor_id;
					$vendor_name = get_vendor_name_by_id( $vendor_id );

					$order->update_meta_data('_vendor_id', $vendor_id);
					$order->update_meta_data('_vendor_name', $vendor_name);
					$order->update_meta_data('_open_for_invites', 0);
					$order->update_meta_data('_open_for_invites_until', 0);

					// Save the changes
					$order->save();

					// Ensure WooCommerce functions are available
					if ( class_exists( 'WC_Emails' ) ) {

						// Get the email object for the "New Order" email
						$new_order_email = WC()->mailer()->get_emails()['WC_Email_Vendor_New_Order'];

						// Make sure the email object exists
						if ($new_order_email) {
							// You need to set the vendor's email (the recipient)
							$vendor_email = get_the_author_meta( 'user_email', $vendor_id ); // Get the email of the new vendor

							// Set the recipient email to the new vendor
							$new_order_email->recipient = $vendor_email;

							// Trigger the sending of the "New Order" email to the vendor
							$new_order_email->trigger( $order->get_id() );
						}
					}

					// (v) @todo - Resend the order notification to the new store.

					// (v) @todo - Update the order to this vendor.
					// (v) @todo - Close all invitations
					// (v) @todo - Set the expiry date on the order to 0 / delete it AND set the order_open_for_invites to 0
				}
				if($order_inv_result == 0
				&& $action == 2){
					// To set the post status to 'accepted'
					wp_update_post(array(
						'ID' => $invite->ID,
						'post_status' => 'rejected', // Custom status
					));
				}

				// Load custom template file, passing the $order object to it
				include locate_template('accept-order-template.php');
			} else {
				#print "Ingen invite at finde";
				wp_redirect(home_url());
				exit;
			}
		} else {
			#print "vars passer ikke";
			wp_redirect(home_url());
			exit;
		}

		// Stop WordPress from loading the default template
		exit;
	}
}
add_action('template_redirect', 'greeting_accept_template');


// =========================================
// ## Invite meta box for the order
// =========================================
// Add meta box for invites on the order page
function add_invites_meta_box_to_order() {
	add_meta_box(
		'invites_meta_box',           // Meta box ID
		'Invites for Order',          // Title
		'display_invites_meta_box',   // Callback function to display the content
		'shop_order',                 // Post type (WooCommerce orders)
		'normal',                     // Context (normal or side)
		'low'                        	// Priority (high or low)
	);
}
add_action('add_meta_boxes', 'add_invites_meta_box_to_order');

// Display the invites table in the meta box
function display_invites_meta_box($post) {
	// Get the order ID
	$order_id = $post->ID;

	// Query the invites associated with this order (assuming the invites are stored as custom posts)
	$invites = get_posts(array(
		'post_status' => 'any', // Get posts with any status
		'post_type' => 'vendor_invite', // Adjust to your custom post type for invites
		'meta_query' => array(
			array(
				'key' => 'order_id',
				'value' => $order_id,
				'compare' => '='
			)
		),
		'posts_per_page' => -1 // Ensure we're retrieving all invites
	));

	if ($invites) {
		echo '<table class="wp-list-table widefat fixed striped invites">';
		echo '<thead><tr><th>ID</th><th>Butiksnavn</th><th>Status</th><th>Oprettelsesdato</th><th>Udløbsdato</th><th>Svardato</th></tr></thead>';
		echo '<tbody>';

		// Loop through the invites and display them in the table
		foreach ($invites as $invite) {
			$invite_id = $invite->ID;
			$invite_title = $invite->post_title;
			$vendor_id = get_post_meta($invite_id, 'vendor_id', true);

			$vendor_name = get_user_meta($vendor_id, '_vendor_page_title', true);
			$user_login = get_vendor_name_by_id($vendor_id);

			$invite_status = get_post_status($invite_id); // Get the status of the invite
			$invite_expiry = get_post_meta($invite_id, 'expiration_at', true);

			$invite_creation_time = get_post_field('post_date', $invite->ID);
			$invite_answer_time = get_post_meta($invite_id, '_answer_time', 'true');

			// Determine invite status
			if ($invite_status == 'accepted') {
				$status = 'active'; // Invite is still active
				$dot_color = 'green';
			} elseif ($invite_status == 'pending' || $invite_status == 'publish') { // Within the last 2 hours
				$status = 'near_expiry'; // Invite is near expiry
				$dot_color = 'yellow';
			} else if ($invite_status == 'expired' || $invite_status == 'rejected' || $invite_status == 'cancelled') {
				$status = 'expired'; // Invite is expired
				$dot_color = 'red';
			}

			// Add rows to the table
			echo '<tr>';
			echo '<td>' . $invite_id . '</td>';
			echo '<td>' . esc_html($vendor_name) . ' (' . $user_login . ')</td>';
			echo '<td> <span class="invite-status-dot" style="background-color: ' . $dot_color . '; width: 10px; height: 10px; border-radius: 50%; display: inline-block;"></span> ' . esc_html($invite_status) . '</td>';
			echo '<td>' . esc_html($invite_creation_time) . '</td>';
			echo '<td>' . esc_html($invite_expiry) . '</td>';
			echo '<td>' . esc_html($invite_answer_time) . '</td>';
			echo '</tr>';
		}

		echo '</tbody>';
		echo '</table>';
	} else {
		echo '<p>Der findes ingen invitationer knyttet til denne ordre.</p>';
	}
}