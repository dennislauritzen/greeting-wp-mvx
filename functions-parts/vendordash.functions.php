<?php


/**
 * Removing the visibility of admin area for MVX users and vendors.
 */
function removeAdminVisibilityForSomeUSers(){
    $user = wp_get_current_user();

    if ( in_array( 'editor', (array) $user->roles ) ) {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('new-content');
    }

    //remove_submenu_page( 'index.php', 'update-core.php');  // Update

    /* REMOVE DEFAULT MENUS */
    if (!in_array( 'administrator', (array) $user->roles )){
        remove_menu_page('edit.php?post_type=landingpage');
        remove_menu_page('edit.php?post_type=city');
        remove_menu_page('acoplw_badges_ui');
        remove_menu_page('upload.php');
    }
}
add_action( 'admin_head', 'removeAdminVisibilityForSomeUSers' );



/**
 * Disable automatic VendorX reports
 */
apply_filters('mvx_do_schedule_cron_vendor_monthly_order_stats', true);
add_filter('mvx_enabled_vendor_weekly_report_mail', '__return_false');

/**
 * Disable autocreate vendor shipping class
 */
add_filter('mvx_add_vendor_shipping_class', '__return_false');

/**
 * Remove PayPal from dashboard.
 */
add_filter('woocommerce_should_load_paypal_standard', '__return_true' );


/* Allow vendors to view/choose admin created shipping classes */
add_filter('mvx_allowed_only_vendor_shipping_class', '__return_false');
add_action('init', 'init_mvx');
function init_mvx(){
    global $MVX;
    remove_filter('woocommerce_product_options_shipping', array($MVX->vendor_dashboard, 'mvx_product_options_shipping'), 5);
}


/**
 * Add new column to the order table on WCMP frontend order table
 * This is the Parent Order ID / Hoved ordre nr.
 *
 * @author Dennis Lauritzen
 */
add_filter('mvx_datatable_order_list_table_headers', 'mvx_add_order_table_column_callback', 10, 2);
function mvx_add_order_table_column_callback($orders_list_table_headers, $current_user_id) {
    $mvx_custom_columns = array(
        'order_p_id'    => array('label' => __( 'Hoved ordre nr.', 'dc-woocommerce-multi-vendor' ))
    );

    return (array_slice($orders_list_table_headers, 0, 2) + $mvx_custom_columns + array_slice($orders_list_table_headers, 2));
}


/**
 * Add the data to new column the order table on WCMP frontend order table
 * This is the Parent Order ID / Hoved ordre nr.
 *
 * @author Dennis Lauritzen
 */
add_filter('mvx_datatable_order_list_row_data', 'mvx_add_order_table_row_data', 10, 2);
function mvx_add_order_table_row_data($vendor_rows, $order) {
    $item_sku = array();
    $vendor = get_current_vendor();
    if($vendor){
        $vendor_items = $vendor->get_vendor_items_from_order($order, $vendor->term_id);
        if($vendor_items){
            foreach ($vendor_items as $item) {
                $product = wc_get_product( $item['product_id'] );
            }
        }
    }
    $parents_order_id = wp_get_post_parent_id($order->id);
    $vendor_rows['order_p_id'] = isset( $parents_order_id ) ? $parents_order_id : '-';
    return $vendor_rows;
}

/**
 * Function to add Custom menu to Vendor Dashboard
 * This adds content to the custom menu point
 *
 * @return void
 */
function custom_menu_endpoint_content(){
    echo '<div class="col-md-12 all-products-wrapper">
    <div class="panel panel-default panel-pading">
        <div class="product-list-filter-wrap">';
    echo '<table style="width: 350px;">';
    echo '<tr><th style="width: 250px;">Periode</th><th style="width: 100px;">Link</th></th>';
    echo '<tr><td>Periode</td><td>Link</td></tr>';
    echo '</table>';
    echo '</div></div></div>';
}
// display content of custom endpoint
add_action('mvx_vendor_dashboard_custom-mvx-menu_endpoint', 'custom_menu_endpoint_content');

/**
 * Function to add Custom menu to Vendor Dashboard
 * This adds a tab to the dashboard.
 *
 * @param $nav
 * @return mixed
 */
function add_tab_to_vendor_dashboard($nav) {
    $nav['custom_mvx_menu'] = array(
        'label' => __('Opgørelser', 'multivendorx'), // menu label
        'url' => mvx_get_vendor_dashboard_endpoint_url( get_mvx_vendor_settings( 'mvx_custom_endpoint', 'seller_dashboard', 'custom-mvx-menu' ) ), // menu url
        'capability' => true, // capability if any
        'position' => 75, // position of the menu
        'submenu' => array(), // submenu if any
        'link_target' => '_self',
        'nav_icon' => 'mvx-font ico-tools-icon', // menu icon
    );
    return $nav;
}
// add custom menu to vendor dashboard
add_filter('mvx_vendor_dashboard_nav', 'add_tab_to_vendor_dashboard');

/**
 * Function to add Custom menu to Vendor Dashboard
 * This adds the endpoint and gives the page a name (also the H1 name on the page)
 *
 * @param $endpoints
 * @return mixed
 */
function add_mvx_endpoints_query_vars_new($endpoints) {
    $endpoints['custom-mvx-menu'] = array(
        'label' => __('Greeting.dk Opgørelser', 'multivendorx'),
        'endpoint' => get_mvx_vendor_settings('mvx_custom_endpoint', 'seller_dashboard', 'custom-mvx-menu')
    );
    return $endpoints;
}
// add custom endpoint
add_filter('mvx_endpoints_query_vars', 'add_mvx_endpoints_query_vars_new');

/**
 * Function for updating the "Clear transients" in the Vendor Dashboard on MultiVendorX.
 *
 * @param $vendor_nav
 * @return mixed
 */
function remove_mvx_vendor_dashboard_nav($vendor_nav){
    unset($vendor_nav['vendor-tools']);
    #unset($vendor_nav['store-settings']['submenu']['vendor-billing']);
    unset($vendor_nav['vendor-payments']);
    unset($vendor_nav['vendor-report']['submenu']['banking-overview']);
    #echo'<pre>';print_r($vendor_nav);echo'</pre>';
    return $vendor_nav;
}
add_filter('mvx_vendor_dashboard_nav', 'remove_mvx_vendor_dashboard_nav', 99);

/**
 * Removing vendors ability to set some of the
 * order statuses on orders.
 *
 * @author Dennis Lauritzen
 * @since v0.1
 *
 */
function mvx_change_default_status( $order_status, $order ){
    unset($order_status['wc-pending']);
    unset($order_status['wc-on-hold']);
    unset($order_status['wc-cancelled']);
    unset($order_status['wc-refunded']);
    unset($order_status['wc-failed']);
    return $order_status;
}
add_filter( 'mvx_vendor_order_statuses', 'mvx_change_default_status', 10, 2);
