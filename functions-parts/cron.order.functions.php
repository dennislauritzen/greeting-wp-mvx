<?php

/**
 * CRONJOB
 * Function for using order object to get Vendor ID.
 *
 * @author Dennis Lauritzen
 * @param array $schedules
 * @return array
 */
// Define a custom 15-minute interval
function greeting_custom_15_minute_interval($schedules) {
    $schedules['every_15_minutes'] = array(
        'interval' => 900, // 15 minutes in seconds
        'display'  => __('Every 15 Minutes', 'textdomain')
    );
    return $schedules;
}
add_filter('cron_schedules', 'greeting_custom_15_minute_interval');

/**
 * Function for updatering via cronjob all orders from delivered status to completed every 15 minutes.
 *
 * @author Dennis Lauritzen
 * @return void
 */
function greeting_update_wc_delivered_orders_to_completed() {
    // Get orders with "wc-delivered" status
    $delivered_orders = wc_get_orders(array(
        'status' => 'wc-delivered',
        'limit' => -1, // Retrieve all orders with "wc-delivered" status
    ));

    // Loop through the delivered orders and update their status to "completed"
    foreach ($delivered_orders as $order) {
        if($order->get_status() == 'delivered'){
            $date = date_i18n( 'l \\d\\e\\n d. F Y \\k\\l\\. H:i:s');
            $order->update_status('completed', 'Ordre er automatisk opdateret til Gennemført '.$date);
        }
    }
}
add_action('update_completed_orders_event', 'greeting_update_wc_delivered_orders_to_completed');

// Schedule the event to run every 15 minutes using the custom interval
if (!wp_next_scheduled('update_completed_orders_event')) {
    wp_schedule_event(current_time('timestamp'), 'every_15_minutes', 'update_completed_orders_event');
}