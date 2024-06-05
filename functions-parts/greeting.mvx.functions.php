<?php


function get_vendor_name($vendor_id){
    if(empty($vendor_id) || !is_numeric($vendor_id)){
        return;
    }

    global $MVX;

    $vendor = get_mvx_vendor($vendor_id);

    return ucfirst(esc_html($vendor->page_title));
}

/**
 *
 * Remove vendor details / information in mails
 *
 */
add_filter ( 'mvx_display_vendor_message_to_buyer','__return_false');


/**
 * Function for removing visitor stats in wcmp.
 * for performance reasons.
 *
 * @since v1.0
 * @author Dennis Lauritzen
 */
apply_filters('mvx_is_disable_store_visitors_stats', '__return_false');


/**
 * Remove report abuse link
 *
 * @author Dennis Lauritzen
 */
add_filter('mvx_show_report_abuse_link', '__return_false');

/**
 * function to handling filtering between vendors in admin on the order table page
 *
 * @return void
 */
function mvx_admin_filter_by_vendor() {
    global $typenow;
    if ($typenow == 'shop_order') {
        $admin_dd_html = '<select name="admin_order_vendor" id="dropdown_admin_order_vendor"><option value="">'.__("Show All Vendors", "dc-woocommerce-multi-vendor").'</option>';
        $vendors = get_mvx_vendors();

        if($vendors){
            $vendor_arr = array();

            foreach ($vendors as $vendor) {
                $vendor_arr[$vendor->term_id] = $vendor->page_title . ' ('. $vendor->user_data->data->display_name . ' - ID :#'.$vendor->id.')';
            }

            asort($vendor_arr);
            foreach($vendor_arr as $vendor => $value){
                $checked = isset($_REQUEST['admin_order_vendor']) ? sanitize_text_field($_REQUEST['admin_order_vendor']) : '';
                $checked = ($checked == $vendor) ? ' selected="selected"' : '';
                $admin_dd_html .= '<option value="'.$vendor.'"'.$checked.'>'.$value.'</option>';
            }
        }

        $admin_dd_html .= '</select>';
        echo $admin_dd_html;
    }
}
add_action( 'restrict_manage_posts', 'mvx_admin_filter_by_vendor');


/**
 * redirect pages for restricted page
 *
 * @return void
 */
function redirect_direct_access( ) {
    $currentUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    if ( $currentUrl == home_url().'/dashboard/transaction-details/' ) {
        $redirectUrl = home_url().'/'.'dashboard/';
        wp_redirect($redirectUrl);
        exit();
    }
}
add_action( 'template_redirect', 'redirect_direct_access' );