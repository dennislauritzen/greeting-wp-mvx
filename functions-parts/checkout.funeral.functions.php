<?php
/**
 *
 * This is only for moderating checkout functions for funeral products.
 *
 *
 */


/**
 * Add a Checkout settings options page
 */
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title'    => 'Checkout Settings: Funeral',
        'menu_title'    => 'Checkout Settings: Funeral',
        'menu_slug'     => 'checkout-settings-funeral',
        'capability'    => 'edit_posts',
        'redirect'      => false,
        'parent_slug'   => 'theme-general-settings' // Parent slug to place it under "Theme Settings"
    ));
}

/**
 *
 *
 */
function cart_has_funeral_products(){
    return has_funeral_products_in_cart();
}

function has_funeral_products_in_cart() {
    // Get the selected category and occasion IDs from ACF options
    $specific_category_id = get_field('specific_product_category', 'option');
    $specific_occasion_id = get_field('specific_occasion', 'option');

    // Initialize flags
    $has_specific_category = false;
    $has_specific_occasion = false;

    // Loop through cart items
    foreach (WC()->cart->get_cart() as $cart_item) {
        // Check for specific product category
        if ($specific_category_id && has_term($specific_category_id, 'product_cat', $cart_item['product_id'])) {
            $has_specific_category = true;
        }

        // Check for specific occasion
        if ($specific_occasion_id && has_term($specific_occasion_id, 'occasion', $cart_item['product_id'])) {
            $has_specific_occasion = true;
        }

        // If both conditions are met, no need to check further
        if ($has_specific_category || $has_specific_occasion) {
            return true;
        }
    }

    return false;
}

function has_funeral_products_with_band_in_cart() {
    // Get the selected category and occasion IDs from ACF options
    $specific_category_id = get_field('specific_product_category', 'option');
    $specific_occasion_id = get_field('specific_occasion', 'option');

    // Initialize flags
    $has_specific_category = false;
    $has_specific_occasion = false;

    // Loop through cart items
    foreach (WC()->cart->get_cart() as $cart_item) {
        $product_id = $cart_item['product_id'];
        $is_eligible_for_band = get_post_meta($product_id, 'is_eligible_for_band', true);

        // Check for specific product category
        if ($specific_category_id && has_term($specific_category_id, 'product_cat', $product_id) && $is_eligible_for_band == 1) {
            $has_specific_category = true;
        }

        // Check for specific occasion
        if ($specific_occasion_id && has_term($specific_occasion_id, 'occasion', $product_id) && $is_eligible_for_band == 1) {
            $has_specific_occasion = true;
        }

        // If both conditions are met, no need to check further
        if ($has_specific_category || $has_specific_occasion) {
            return true;
        }
    }

    return false;
}

/**
 *
 */
function order_has_funeral_products($order_id) {
    // Get the selected category and occasion IDs from ACF options
    $specific_category_id = get_field('specific_product_category', 'option');
    $specific_occasion_id = get_field('specific_occasion', 'option');

    // Initialize flags
    $has_specific_category = false;
    $has_specific_occasion = false;

    // Get the order
    $order = wc_get_order($order_id);

    // Loop through order items
    foreach ($order->get_items() as $item_id => $item) {
        $product_id = $item->get_product_id();

        // Check for specific product category
        if ($specific_category_id && has_term($specific_category_id, 'product_cat', $product_id)) {
            $has_specific_category = true;
        }

        // Check for specific occasion
        if ($specific_occasion_id && has_term($specific_occasion_id, 'occasion', $product_id)) {
            $has_specific_occasion = true;
        }

        // If either condition is met, return true
        if ($has_specific_category || $has_specific_occasion) {
            return true;
        }
    }

    // If neither condition is met, return false
    return false;
}

/**
 * Function to update field labels if there is funeral products in cart
 *
 * @param $fields
 * @return array
 */
function custom_checkout_field_labels($fields) {
    $has_funeral_products_in_cart = has_funeral_products_in_cart();

    // Modify the labels if the conditions are met
    if ($has_funeral_products_in_cart) {
        // Change the shipping first name label
        $fields['shipping']['shipping_first_name']['label'] = 'Afdødes fornavn';
        $fields['shipping']['shipping_first_name']['label'] = 'Afdødes efternavn';

        // Change the shipping company name label
        if (isset($fields['shipping']['shipping_company'])) {
            $fields['shipping']['shipping_company']['label'] = 'Kirke- eller kapelnavn';
        }
        if (isset($fields['shipping']['shipping_address'])) {
            $fields['shipping']['shipping_company']['label'] = 'Kirkens eller kapellets adresse';
        }
        // Add more field modifications as needed
    }

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'custom_checkout_field_labels');


// Add custom HTML under Shipping City field
function custom_html_under_shipping_city($fields) {
    $html = '<div class="custom-html-wrapper">';
    $html .= '<p>This is custom HTML content.</p>';
    $html .= '</div>';

    // Insert custom HTML after Shipping City field
    $fields['shipping']['shipping_city']['custom_html'] = $html;

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'custom_html_under_shipping_city');