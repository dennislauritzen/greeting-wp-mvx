<?php
/**
 * Functions for adding a vendor as an affiliate on an order
 * meaning they receive a fee for the order.
 */

function greeting_vendor_affiliation_fee(){
	$percentage = 10;

	return $percentage / 100;
}

function greeting_vendor_affiliation_to_order($order_id)
{
	// Check if user is logged in
	if (is_user_logged_in()) {
		$current_user = wp_get_current_user();

		// Check if user is a DC Vendor
		if (in_array('dc_vendor', $current_user->roles)) {
			// Add custom order meta data

		}
	}

	// Verify nonce for additional security
	if (!check_ajax_referer('woocommerce-process_checkout', 'security', false)) {
		return;
	}

	// Check if user is logged in
	if (!is_user_logged_in()) {
		return;
	}

	$current_user = wp_get_current_user();

	// Multiple role checks for enhanced security
	$allowed_vendor_roles = apply_filters('vendor_order_meta_roles', ['dc_vendor']);
	$user_roles = $current_user->roles;

	// Check if user has any of the vendor roles
	$is_vendor = array_intersect($allowed_vendor_roles, $user_roles);

	if (!$is_vendor) {
		return;
	}

	// Validate order and user
	$order = wc_get_order($order_id);
	if (!$order || $order->get_customer_id() !== $current_user->ID) {
		return;
	}

	if (is_wc_hpos_activated('frontend')) {
		// Add secure custom order meta data
		$order->update_meta_data('_vendor_affiliation_id', $current_user->ID);
		$order->update_meta_data('_vendor_affiliation_percentage', greeting_vendor_affiliation_fee());
		$order->save(); // Save the order to persist meta data
	} else {
	// Add secure custom order meta data
		update_post_meta($order_id, '_vendor_affiliation_id', $current_user->ID);
		update_post_meta($order_id, '_vendor_affiliation_percentage', greeting_vendor_affiliation_fee());
	}
}
add_action('woocommerce_checkout_update_order_meta', 'greeting_vendor_affiliation_to_order', 10, 1);


// Register custom metabox for vendor selection
function register_vendor_selection_metabox() {
	if( is_wc_hpos_activated('meta_box') ) {
		// HPOS is enabled.
		add_meta_box(
			'vendor_affiliation_metabox',           // Unique ID
			'Henvisende butik (som får 10 %)',      // Box title
			'add_vendor_selection_dropdown',        // Content callback
			get_wc_hpos_order_screen_name(),                           // Post type
			'side',                                 // Context
			'low'                                   // Priority
		);
	} else {
		// Custom Post Type order admin interface.
		add_meta_box(
			'vendor_affiliation_metabox',           // Unique ID
			'Henvisende butik (som får 10 %)',      // Box title
			'add_vendor_selection_dropdown',        // Content callback
			'shop_order',                           // Post type
			'side',                                 // Context
			'low'                                   // Priority
		);
	}
}
add_action('add_meta_boxes', 'register_vendor_selection_metabox');


// Add vendor selection dropdown to order edit page
function add_vendor_selection_dropdown($post) {
	// Check if current user is admin
	if (!current_user_can('manage_options')) {
		return;
	}

	if(is_wc_hpos_activated()){
		$order = wc_get_order($post->ID);

		// Get current vendor affiliation
		$current_vendor_id = $order->get_meta('_vendor_affiliation_id', true);

		// Get current vendor affiliation
		$order_vendor_id = $order->get_meta('_vendor_id', true);
	} else {
		// Get current vendor affiliation
		$current_vendor_id = get_post_meta($post->ID, '_vendor_affiliation_id', true);

		// Get current vendor affiliation
		$order_vendor_id = get_post_meta($post->ID, '_vendor_id', true);
	}


	// Get all DC Vendors
	$vendor_args = array(
		'role'    => 'dc_vendor',
		'orderby' => 'ID',
		'order'   => 'ASC',
		'exclude' => array($order_vendor_id)
	);
	$vendors = get_users($vendor_args);

	// Add nonce for security
	wp_nonce_field('vendor_affiliation_nonce', 'vendor_affiliation_nonce');

	// Start dropdown
	echo '<select name="vendor_affiliation_id" id="vendor_affiliation_id">';
	echo '<option value="">Vælg butik</option>';

	// Populate dropdown
	foreach ($vendors as $vendor) {
		$selected = ($vendor->ID == $current_vendor_id) ? 'selected' : '';
		echo "<option value='{$vendor->ID}' {$selected}>{$vendor->display_name} (ID: {$vendor->ID})</option>";
	}
	echo '</select>';
}

// Save vendor affiliation
function save_vendor_affiliation($post_id, $post) {
	// Check user permissions
	if (!current_user_can('manage_options')) {
		return;
	}

	// Verify nonce for security
	if (!isset($_POST['woocommerce_meta_nonce']) ||
		!wp_verify_nonce($_POST['woocommerce_meta_nonce'], 'woocommerce_save_data')) {
		return;
	}



	// Save vendor affiliation
	if (isset($_POST['vendor_affiliation_id']) && !empty($_POST['vendor_affiliation_id'])) {
		$vendor_id = sanitize_text_field($_POST['vendor_affiliation_id']);

		if(is_wc_hpos_activated('frontend')){
			$order = wc_get_order($post_id);
			$order->update_meta_data('_vendor_affiliation_id', $vendor_id);
		} else {
			update_post_meta($post_id, '_vendor_affiliation_id', $vendor_id);
		}
	} else {
		if(is_wc_hpos_activated('frontend')){
			$order = wc_get_order($post_id);
			$order->delete_meta_data('_vendor_affiliation_id');
		} else {
			// Remove meta if no vendor selected
			delete_post_meta($post_id, '_vendor_affiliation_id');
		}
	}
}
add_action('woocommerce_process_shop_order_meta', 'save_vendor_affiliation', 10, 2);

// Add custom column to orders list
function add_vendor_affiliation_column($columns) {
	$columns['vendor_affiliation'] = 'Vendor Affiliation';
	return $columns;
}
add_filter('manage_edit-shop_order_columns', 'add_vendor_affiliation_column');