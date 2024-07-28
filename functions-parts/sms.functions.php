<?php

function custom_log($message) {
    $log_file = 'C:\wamp64\logs\custom_log.txt';

    $timestamp = date("Y-m-d H:i:s");

    $log_entry = "[$timestamp] $message\n";

    // Check if the file is writable
    if (!is_writable($log_file)) {
        // Attempt to change file permissions to make it writable
        if (!chmod($log_file, 0666)) {
            error_log('Failed to change permissions of log file');
            return; // Exit if unable to change permissions
        }
    }

    // Append the log entry to the file
    $result = file_put_contents($log_file, $log_entry, FILE_APPEND);
    if ($result === false) {
        error_log('Failed to write to custom log file');
    }
}

/**
 * Function for sending SMS when the vendor_new_order email is triggered.
 *
 * @param WC_Order $order The order object.
 * @param bool $sent_to_admin Whether the email is being sent to the admin.
 * @param bool $plain_text Whether the email is in plain text.
 * @param WC_Email $email The email object.
 */
#function send_sms_on_new_order( ) {
#function send_sms_on_new_order( $order, $sent_to_admin, $plain_text, $email ) {
function send_sms_on_new_order( $order_id, $old_status, $new_status,  $order ) {
    if($old_status != 'pending' || $new_status != 'processing'){
        // Make check if the correct statusses
        // And make check if there is already sent SMS.
        // If there is sent - or the statusses aren't correct - stop it and just return.
        return false;
    } else {
        // GatewayAPI credentials
        $url = "https://gatewayapi.com/rest/mtsms";
        $api_token = "Co1rOcIZQSSjK6g6MS4Q74f5dDWQRigd9mDeuREZCAfXDVqsOf5xeDnNK7aIPWlb";

        // Retrieve the order
        $order_id = $order->get_id();
        if (!$order) {
            return;
        }

        // Get vendor ID and the setting if they want to receive SMS.
        $vendor_id = get_vendor_id_by_order_id($order->get_id());
        $vendor_to_receive_sms = get_field('receive_sms', 'user_'.$vendor_id);

        if($vendor_to_receive_sms != "1"){
            return;
        }

        // Check if HPOS is active
        // Get the vendor_id of the order.
        if (is_wc_hpos_activated()) {
            $vendor_id = $order->get_meta('_vendor_id');
            $delivery_date = $order->get_meta('_delivery_date');
        } else {
            $vendor_id = get_post_meta($order->get_id(), '_vendor_id', true);
            $delivery_date = get_post_meta($order->get_id(), '_delivery_date', true);
        }

        // Vendor phone.
        $vendor_phone = get_user_meta($vendor_id, '_vendor_phone', true);
        #custom_log('Vendor phone'.$vendor_phone);
        if (empty($vendor_phone)) {
            return;
        }
        $formatted_phone = format_danish_phone_number($vendor_phone);

        // Ensure the phone number is in the correct format (e.g., with country code)
        $customer_phone_number = preg_replace('/\D/', '', $vendor_phone); // Remove non-digits

        // Data for the message
        $delivery_postal = $order->get_shipping_postcode(); // Add logic to get the postal code if needed

        // The SMS message with line breaks
        $message = 'Du har modtaget en ny bestilling #' . $order->get_order_number()
            . "\n\n"
            . "Bestillingen er bestilt til postnummer " . $delivery_postal . " og med levering d. " . $delivery_date
            . "\n\n"
            . "Med venlig hilsen"
            . "\nGreeting";

        #var_dump($message);
        #var_dump($payload);

        //Set SMS recipients and content
        $recipients = [$vendor_phone];
        $json = [
            'sender' => 'Greeting.dk',
            'message' => $message,
            'recipients' => [],
        ];
        foreach ($recipients as $msisdn) {
            $json['recipients'][] = ['msisdn' => $formatted_phone];
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_USERPWD, $api_token . ":");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Check if the domain is 'greeting.local' and disable SSL verification for testing
        if (strpos(home_url(), 'http://greeting.local') !== false) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        // Execute the request
        $result = curl_exec($ch);

        // Check for curl errors
        if ($result === false) {
            $error_message = 'Curl error: ' . curl_error($ch);
            curl_close($ch);
            #echo '<div class="error"><p>' . $error_message . '</p></div>';
            return;
        }

        // Get HTTP response code
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close the curl session
        curl_close($ch);

        // Decode JSON response
        $response_json = json_decode($result);
        if (json_last_error() === JSON_ERROR_NONE) {
            // Print out response JSON for debugging
            #error_log('Response JSON: ' . print_r($response_json, true));

            // Handle specific data in response if it exists
            #if (isset($response_json->ids)) {
                #error_log('Message IDs: ' . implode(', ', $response_json->ids));
            #} else {
                #error_log('No IDs found in response.');
            #}
        } else {
            error_log('SMS Sending error | JSON decode error: ' . json_last_error_msg());
        }
    }
}
#add_action( 'woocommerce_email_after_send', 'send_sms_on_new_order', 10, 3 );
add_action( 'woocommerce_order_status_changed', 'send_sms_on_new_order', 99, 4 );

function format_danish_phone_number($vendor_phone) {
    // Remove all non-numeric characters
    $cleaned_phone = preg_replace('/\D/', '', $vendor_phone);

    // Initialize formatted phone number
    $formatted_phone = null;

    // Check if the phone number starts with country code '45'
    if (substr($cleaned_phone, 0, 2) === '45') {
        // Check if the remaining number has exactly 8 digits
        if (strlen(substr($cleaned_phone, 2)) === 8) {
            $formatted_phone = '45' . substr($cleaned_phone, 2);
        } else {
            // Phone number starts with '45' but doesn't have 8 digits after it
            $formatted_phone = $cleaned_phone;
        }
    } elseif (substr($cleaned_phone, 0, 4) === '0045') {
        // Check if the remaining number has exactly 8 digits
        if (strlen(substr($cleaned_phone, 4)) === 8) {
            $formatted_phone = '45' . substr($cleaned_phone, 4);
        } else {
            // Phone number starts with '0045' but doesn't have 8 digits after it
            $formatted_phone = $cleaned_phone;
        }
    } elseif (substr($cleaned_phone, 0, 3) === '+45') {
        // Check if the remaining number has exactly 8 digits
        if (strlen(substr($cleaned_phone, 3)) === 8) {
            $formatted_phone = '45' . substr($cleaned_phone, 3);
        } else {
            // Phone number starts with '+45' but doesn't have 8 digits after it
            $formatted_phone = $cleaned_phone;
        }
    } else {
        // No country code or other country code is present
        if (strlen($cleaned_phone) === 8) {
            $formatted_phone = '45' . $cleaned_phone;
        } else {
            // Invalid phone number
            return null;
        }
    }

    return $formatted_phone;
}