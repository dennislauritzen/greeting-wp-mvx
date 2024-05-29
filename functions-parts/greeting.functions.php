<?php


/**
 *
 * Remove the pagination for product category pages and custom taxonomy 'Occasions'.
 *
 */
add_filter( 'loop_shop_per_page', 'greeting_remove_pagination', 20 );
function greeting_remove_pagination( $cols ) {
    $cols = 1;
    return $cols;
}

/**
 * Change currency symbol for danish goods.
 *
 * @param $currency_symbol
 * @param $currency
 * @return mixed|string
 */
function greeting_change_dk_currency_symbol( $currency_symbol, $currency ) {
    switch( $currency ) {
        // DKK til kr
        case 'DKK': $currency_symbol = 'kr.'; break;
    }
    return $currency_symbol;
}
add_filter('woocommerce_currency_symbol', 'greeting_change_dk_currency_symbol', 10, 2);


/**
 * Turn off the xmlRPC
 *
 * @author Dennis Lauritzen
 */
add_filter( 'xmlrpc_enabled', '__return_false' );


#add_action( 'generate_rewrite_rules', 'register_product_rewrite_rules' );
function register_product_rewrite_rules( $wp_rewrite ) {
    $new_rules = array(
        'products/([^/]+)/?$' => 'index.php?product-category=' . $wp_rewrite->preg_index( 1 ), // 'products/any-character/'
        'products/([^/]+)/([^/]+)/?$' => 'index.php?post_type=sps-product&product-category=' . $wp_rewrite->preg_index( 1 ) . '&sps-product=' . $wp_rewrite->preg_index( 2 ), // 'products/any-character/post-slug/'
        'products/([^/]+)/([^/]+)/page/(\d{1,})/?$' => 'index.php?post_type=sps-product&product-category=' . $wp_rewrite->preg_index( 1 ) . '&paged=' . $wp_rewrite->preg_index( 3 ), // match paginated results for a sub-category archive
        'products/([^/]+)/([^/]+)/([^/]+)/?$' => 'index.php?post_type=sps-product&product-category=' . $wp_rewrite->preg_index( 2 ) . '&sps-product=' . $wp_rewrite->preg_index( 3 ), // 'products/any-character/sub-category/post-slug/'
        'products/([^/]+)/([^/]+)/([^/]+)/([^/]+)/?$' => 'index.php?post_type=sps-product&product-category=' . $wp_rewrite->preg_index( 3 ) . '&sps-product=' . $wp_rewrite->preg_index( 4 ), // 'products/any-character/sub-category/sub-sub-category/post-slug/'
    );
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}


//add_filter( 'wpseo_primary_term_taxonomies', '__return_false' );


function add_theme_caps() {
    // gets the administrator role
    $admins = get_role( 'administrator' );

    $admins->add_cap( 'publish_wcmppages' );
    $admins->add_cap( 'edit_wcmppages' );
    $admins->add_cap( 'edit_other_wcmppages' );
    $admins->add_cap( 'delete_wcmppages' );
    $admins->add_cap( 'delete_other_wcmppages' );
    $admins->add_cap( 'read_private_wcmppages' );
    $admins->add_cap( 'edit_wcmppage' );
    $admins->add_cap( 'delete_wcmppage' );
}
add_action( 'admin_init', 'add_theme_caps');

/**
 * Custom post
 */
add_action('init', 'greeting_custom_post_type');
function greeting_custom_post_type() {

    // landing page
    register_post_type('landingpage',
        array(
            'labels' => array(
                'name'          => __('Landing Pages', 'woocommerce'),
                'singular_name' => __('Landing Page', 'woocommerce'),
            ),
            'menu_icon' => 'dashicons-flag',
            'public'      => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'l'),
            'supports' => array('title','editor'),
            'capabilities' => array(
                'publish_posts' => 'publish_wcmppages',
                'edit_posts' => 'edit_wcmppages',
                'edit_others_posts' => 'edit_other_wcmppages',
                'delete_posts' => 'delete_wcmppages',
                'delete_others_posts' => 'delete_other_wcmppages',
                'read_private_posts' => 'read_private_wcmppages',
                'edit_post' => 'edit_wcmppage',
                'delete_post' => 'delete_wcmppage' )
        )
    );

    // city
    register_post_type('city',
        array(
            'labels' => array(
                'name'          => __('City', 'woocommerce'),
                'singular_name' => __('Cities', 'woocommerce'),
            ),
            'rewrite' => array('slug' => 'c'),
            'menu_icon' => 'dashicons-location-alt',
            'public'      => true,
            'has_archive' => false,
            'supports' => array('title'),
            'capabilities' => array(
                'publish_posts' => 'publish_wcmppages',
                'edit_posts' => 'edit_wcmppages',
                'edit_others_posts' => 'edit_other_wcmppages',
                'delete_posts' => 'delete_wcmppages',
                'delete_others_posts' => 'delete_other_wcmppages',
                'read_private_posts' => 'read_private_wcmppages',
                'edit_post' => 'edit_wcmppage',
                'delete_post' => 'delete_wcmppage' )
        )
    );
}

/**
 *
 * Custom taxonomy for the Occasions for Greeting
 *
 **/
add_action( 'init', 'greeting_custom_taxonomy_occasion', 0 );
function greeting_custom_taxonomy_occasion()  {
    $labels = array(
        'name'                       => 'Occasions',
        'singular_name'              => 'Occasion',
        'menu_name'                  => 'Occasions',
        'all_occasions'                  => 'All Occasions',
        'parent_occasion'                => 'Parent Occasion',
        'parent_occasion_colon'          => 'Parent Occasion:',
        'new_occasion_name'              => 'New Occasion Name',
        'add_new_occasion'               => 'Add New Occasion',
        'edit_occasion'                  => 'Edit Occasion',
        'update_occasion'                => 'Update Occasion',
        'separate_occasions_with_commas' => 'Separate Occasion with commas',
        'search_occasions'               => 'Search Occasions',
        'add_or_remove_occasions'        => 'Add or remove Occasions',
        'choose_from_most_used'      => 'Choose from the most used Occasions',
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'rewrite'										 => array('slug' => 'anledning'),
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'capabilities' 							 => array(
            'publish_posts' => 'edit_posts',
            'edit_posts' => 'edit_posts',
            'edit_others_posts' => 'edit_posts',
            'delete_posts' => 'edit_posts',
            'delete_others_posts' => 'edit_posts',
            'read_private_posts' => 'edit_posts',
            'edit_post' => 'edit_posts',
            'delete_post' => 'edit_posts',
            'read_post' => 'edit_posts' )
    );
    register_taxonomy( 'occasion', 'product', $args );
}



/**
 * Add settings pages to ACF.
 *
 */
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title' 	=> 'Theme General Settings',
        'menu_title'	=> 'Theme Settings',
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Header Settings',
        'menu_title'	=> 'Header',
        'parent_slug'	=> 'theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Footer Settings',
        'menu_title'	=> 'Footer',
        'parent_slug'	=> 'theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Block: Howdy Settings',
        'menu_title'	=> 'Howdy-block',
        'parent_slug'	=> 'theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Block: City Page',
        'menu_title'	=> 'City Page',
        'parent_slug'	=> 'theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Block: Did You Know',
        'menu_title'	=> 'Vidste Du At-block',
        'parent_slug'	=> 'theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Block: Customer Care',
        'menu_title'	=> 'Kundeservice-block',
        'parent_slug'	=> 'theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Header: USPs',
        'menu_title'	=> 'Header: USPer',
        'parent_slug'	=> 'theme-general-settings',
    ));
}

/**
 * Minimum order value required for shopping
 * @since 1.0.3
 * @author Dennis Lauritzen
 *
 * @todo Make sure this is based on settings for the store.
 * @todo Make sure there is put a warning if the cart doesn't meet requirements.
 */
# add_action('wp', 'greeting_marketplace_min_order_value');
function greeting_marketplace_min_order_value(){
    $min_order_value = get_option('greeting_marketplace_min_order_value');
    if($min_order_value){
        if(WC()->cart->subtotal < $min_order_value){
            remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
            remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
        }
    }
}



function shapeSpace_customize_image_sizes($sizes) {
    unset($sizes['medium_large']); // 768px
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'shapeSpace_customize_image_sizes');

// disable srcset on frontend
function disable_wp_responsive_images() {
    return 1;
}
add_filter('max_srcset_image_width', 'disable_wp_responsive_images');

/**
 * Creating custom sizing for the images in the store view box.
 */
add_image_size( 'vendor-product-box-size', 240, 240 );

/**
 * Creating custom sizing for the images in the store view box.
 */
add_image_size( 'vendor-topbanner-size', 400, 200 );


/**
 * Show order date in thank you page
 * @todo - $order is not defined. Therefore we should not try to access object, just use function variable.
 *
 * I think this is deprecated since we made the new order confirmation page setup.
 *
 * @param $order_id
 * @return void
 */
function greeting_view_order_and_thankyou_page( $order_id ){
    global $order;

    if( empty($order_id) || !is_numeric($order_id)){
        $order_id = $order->get_id();
    }

    $str = '<p><strong>Leveringsdato:</strong> ';
    if ( $_POST['delivery_date'] ) { $str .= get_post_meta( $order_id, '_delivery_date', true ); } else { $str .= 'Hurtigst muligt'; }
    $str .= '</p>';
    $str .= '<p><strong>Modtagers telefonnr.:</strong> ' . get_post_meta( $order_id, '_receiver_phone', true ) . '</p>';
    $str .= '<p><strong>Besked til modtager:</strong> ' . get_post_meta( $order_id, '_greeting_message', true ) . '</p>';
    $str .= '<p><strong>Leveringsinstruktioner:</strong> ' . get_post_meta( $order_id, '_delivery_instructions', true ) . '</p>';

    $leave_gift_at_address = (get_post_meta( $order_id, '_leave_gift_address', true ) == "1" ? 'Ja' : 'Nej');
    $str .= '<p><strong>Må gaven stilles på adressen:</strong> ' . $leave_gift_at_address . '</p>';
    $leave_gift_at_neighbour = (get_post_meta( $order_id, '_leave_gift_neighbour', true ) == "1" ? 'Ja' : 'Nej');
    $str .= '<p><strong>Må gaven afleveres hos naboen:</strong> ' . $leave_gift_at_neighbour . '</p>';

    echo $str;
}
add_action( 'woocommerce_thankyou', 'greeting_view_order_and_thankyou_page', 20 );


/**
 * Filter for update image_editors added
 * wp_image_editors
 */
add_filter( 'wp_image_editors', function() { return array( 'WP_Image_Editor_GD' ); } );



/**
 * function for removing some post types from the link query arguments
 *
 * @param $query
 * @return array
 */
function custom_wp_link_query_args($query)
{
    $pt_new = array();

    $exclude_types = array('landingpage','product');

    foreach ($query['post_type'] as $pt)
    {
        if (in_array($pt, $exclude_types)) continue;
        $pt_new[] = $pt;
    }

    $query['post_type'] = $pt_new;
    return $query;
}
add_filter('wp_link_query_args', 'custom_wp_link_query_args');



/**
 * The notice when someone shops in more than one store.
 * Should be localized and danish
 *
 * @todo Dennis - translate
 * @todo Dennis - set up with localization.
 *
 * @usedby greeting_shop_only_one_store_at_the_same_time
 *
 * @author Dennis Lauritzen
 * @return void
 */
// show shop only one store same time notice
function show_shop_only_one_store_at_the_same_time(){
    $notice = 'Øv - vi kan se, du har produkter fra flere butikker i kurven. Du kan på nuværende tidspunkt kun handle i én butik ad gangen. Gå til kurven og sørg for, der kun er produkter fra én butik i kurven, før du kan gennemføre';
    wc_print_notice($notice, 'error');
}

/**
 * Only show one store at a time
 *
 * @author Dennis Lauritzen
 * @return void
 */
function greeting_shop_only_one_store_at_the_same_time() {
    $single_vendor = 0;
    $last_inserted_vendor_id = null;
    $vendor_id_array = array();

    // check is woocommerce installed and active?
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        // Yes, WooCommerce is enabled
        if(!empty(WC()->cart) && !is_admin()){
            $cart_data = WC()->cart->get_cart();
            $length = count($cart_data);
            foreach ($cart_data as $cart_item_key => $cart_item) {
                $product_id = $cart_item['product_id'];
                $vendor_data = get_mvx_product_vendors($product_id);
                if(is_object($vendor_data)){
                    $vendor_id = $vendor_data->user_data->ID;
                    $vendor_id_array[] = $vendor_id;
                }
            }
        }
    } else {
        // WooCommerce is NOT enabled!
        return;
    }

    // check array is unique or not
    if(!empty($vendor_id_array) && count(array_unique($vendor_id_array)) > 1) {
        // remove actions
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
        remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
        // add actions
        add_action( 'after_mvx_vendor_description', 'show_shop_only_one_store_at_the_same_time', 5 );
        add_action( 'woocommerce_before_single_product', 'show_shop_only_one_store_at_the_same_time', 5 );
        add_action('woocommerce_before_cart', 'show_shop_only_one_store_at_the_same_time', 5);
        add_action('woocommerce_before_checkout_form', 'show_shop_only_one_store_at_the_same_time', 5);
        // add filter for hide 'place order' button
        add_filter( 'woocommerce_order_button_html', 'greeting_custom_button_html' );
        function greeting_custom_button_html( $button_html ) {
            $button_html = '';
            return $button_html;
        }
    }
}
//  add_action('init', 'greeting_shop_only_one_store_same_time');
add_action('wp_loaded', 'greeting_shop_only_one_store_at_the_same_time');


##############################################################
## *****************************
## POSSIBLE DEPRECATED FUNCTIONS
##
##
##
##

/**
 * Function for triggering Greeting holiday mode,.
 * Not used.
 *
 * @return void
 */
function greeting_woocommerce_holiday_mode() {

    // $get_option = get_option( 'mb-bhi-settings' );
    // $open_status = $get_option['openline'];
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
    remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
    add_action( 'woocommerce_before_main_content', 'greeting_wc_shop_disabled', 5 );
    add_action( 'woocommerce_before_cart', 'greeting_wc_shop_disabled', 5 );
    add_action( 'woocommerce_before_checkout_form', 'greeting_wc_shop_disabled', 5 );
}
// add_action ('init', 'greeting_woocommerce_holiday_mode');

// Show Holiday Notice
function greeting_wc_shop_disabled() {
    wc_print_notice( 'Greeting.dk er lukket ned pga. vedligehold netop nu, desværre :)', 'error');
}
