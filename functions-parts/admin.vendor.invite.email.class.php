<?php

if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'WC_Email' ) ) {
	error_log("WC_Email not found\n", 3, 'C:/wamp64/logs/custom_log.log');
	return;
}

if ( ! class_exists( 'WC_Email_Vendor_Order_Invite', false ) ) {
	/**
	 * Vendor invitation email
	 *
	 *
	 *
	 * @class       WC_Email_Vendor_Order_Invite
	 * @version     2.0.0
	 * @package     WooCommerce\Classes\Emails
	 * @extends     WC_Email
	 */
	class WC_Email_Vendor_Order_Invite extends WC_Email
	{
		/**
		 * Constructor.
		 */
		public function __construct()
		{
			$this->id             	= 'vendor_invite';
			$this->customer_email 	= false;
			$this->title          	= __( 'Vendor Invite', 'greeting3' );
			$this->description 		= __('This email is sent to a vendor when they are invited to take over an order.', 'greeting3');
			$this->heading 			= __('You’re Invited to Take Over Order', 'greeting3');
			$this->subject 			= __( 'Invitation til at overtage bestilling på Greeting.dk', 'greeting3' );
			$this->template_html 	= 'emails/vendor-invite-email.php';
			$this->template_plain 	= 'emails/plain/vendor-invite-email.php';
			$this->placeholders   	= array(
				'{invite_id}'   => '',
				'{invite_guid}' => '',
			);

			// Define the email format as HTML
			$this->email_type     = 'html';

			// Triggers for this email.
			#add_action( 'send_vendor_invite_email_notification', array($this, 'trigger'), 20, 5);

			// Call parent constructor.
			parent::__construct();
		}

		public function init_form_fields() {
			$this->form_fields = array(
				'enabled' => array(
					'title'   => __( 'Enable/Disable', 'greeting3' ),
					'type'    => 'checkbox',
					'label'   => __( 'Enable this email notification', 'greeting3' ),
					'default' => 'yes',
				),
				'subject' => array(
					'title'       => __( 'Subject', 'greeting3' ),
					'type'        => 'text',
					'description' => __( 'This controls the email subject line.', 'greeting3' ),
					'placeholder' => '',
					'default'     => $this->subject,
				),
				'heading' => array(
					'title'       => __( 'Heading', 'greeting3' ),
					'type'        => 'text',
					'description' => __( 'This controls the main heading in the email notification.', 'greeting3' ),
					'placeholder' => '',
					'default'     => $this->heading,
				),
				'funeral_subject' => array(
					'title'       => __( 'Funeral Order Subject', 'greeting3' ),
					'type'        => 'text',
					'description' => __( 'This controls the subject for funeral orders.', 'greeting3' ),
					'placeholder' => '',
					'default'     => __( 'Special Funeral Order Invitation', 'greeting3' ),
				),
				'funeral_heading' => array(
					'title'       => __( 'Funeral Order Heading', 'greeting3' ),
					'type'        => 'text',
					'description' => __( 'This controls the heading for funeral orders.', 'greeting3' ),
					'placeholder' => '',
					'default'     => __( 'You’re Invited to Take Over a Funeral Order', 'greeting3' ),
				),
			);
		}

		/**
		 * Trigger the sending of this email.
		 *
		 * @param int            $order_id The order ID.
		 * @param WC_Order|false $order Order object.
		 */
		public function trigger($email, $vendor_id, $order_id, $invite_id, $invite_guid, $order = false)
		{
			$this->setup_locale();

			if (!$vendor_id) {
				return;
			}

			if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
				$order = wc_get_order( $order_id );
			}

			$vendor_name = get_user_meta($vendor_id, '_vendor_page_title', 1);

			$this->object = $order;
			$this->vendor_id = $vendor_id;
			$this->vendor_name = $vendor_name;
			$this->recipient = $email;
			$this->order_id = $order_id;
			$this->invite_id = $this->placeholders['{invite_id}'] = $invite_id;
			$this->invite_guid = $this->placeholders['{invite_guid}'] = $invite_guid;


			$this->placeholders['{order_number}'] = $order->get_id();
			$this->placeholders['{vendor_name}'] = $vendor_name;
			$this->placeholders['{delivery_postal}'] = $order->get_shipping_postcode();
			$this->placeholders['{delivery_city}'] = $order->get_shipping_city();
			$this->placeholders['{delivery_date}'] = $order->get_meta('_delivery_date');

			// Retrieve the alternate settings
			$funeral_subject = $this->get_option('funeral_subject', $this->subject);
			$funeral_heading = $this->get_option('funeral_heading', $this->heading);

			// Replace placeholders with the actual values
			foreach ($this->placeholders as $placeholder => $value) {
				$funeral_subject = str_replace($placeholder, $value, $funeral_subject);
				$funeral_heading = str_replace($placeholder, $value, $funeral_heading);
			}

			// Set subject and heading conditionally for funeral products
			if (order_has_funeral_products($order->get_id())) {
				// Use set_subject and set_heading for proper handling
				$subject = $funeral_subject;  // Set subject directly
				$heading = $funeral_heading;  // Set heading directly
			} else {
				$subject = $this->get_subject();  // Set subject directly
				$heading = $this->get_heading();  // Set heading directly
			}

			if (!$this->is_enabled() || !$this->get_recipient()) {
				return;
			}

			$this->send($this->get_recipient(), $subject, $this->get_content(), $this->get_headers(), $this->get_attachments());

			$this->restore_locale();
		}


		/**
		 * Get email subject.
		 *
		 * @since  3.1.0
		 * @return string
		 */
		public function get_default_subject() {
			return __( 'Invitation til at overtage bestilling på Greeting.dk', 'greeting3' );
		}

		/**
		 * Get email heading.
		 *
		 * @since  3.1.0
		 * @return string
		 */
		public function get_default_heading() {
			return __( 'You are invited to accept an order in your area', 'woocommerce' );
		}

		/**
		 * Get content html.
		 *
		 * @return string
		 */
		public function get_content_html()
		{
			return wc_get_template_html($this->template_html, array(
				'order' => $this->object,
				'email_heading' => $this->get_heading(),
				'email' => $this,
				'order_id' => $this->order_id,
				'vendor_id' => $this->vendor_id,
				'vendor_name' => $this->vendor_name,
				'invite_id' => $this->invite_id,
				'invite_guid' => $this->invite_guid,
			), '', $this->template_base);
		}

		/**
		 * Get content plain.
		 *
		 * @return string
		 */
		public function get_content_plain()
		{
			return wc_get_template_html($this->template_plain, array(
				'email_heading' => $this->get_heading(),
				'invite_guid' => $this->invite_guid,
				'email' => $this,
			), '', $this->template_base);
		}

		/**
		 * Default content to show below main email content.
		 *
		 * @since 3.7.0
		 * @return string
		 */
		public function get_default_additional_content() {
			return __( 'Thanks for shopping with us.', 'woocommerce' );
		}
	}
}

return new WC_Email_Vendor_Order_Invite();