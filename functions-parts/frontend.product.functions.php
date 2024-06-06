<?php

#####################
##
## Reorder the product page hooks
## for the Product Page.
##

function list_hooked_functions($hook_name) {
    global $wp_filter;

    if (!isset($wp_filter[$hook_name])) {
        echo "No actions found for hook: {$hook_name}";
        return;
    }

    $hook = $wp_filter[$hook_name];

    // WordPress 4.7+ stores hooks in an array instead of WP_Hook object
    if (is_object($hook) && isset($hook->callbacks)) {
        $hook = $hook->callbacks;
    }

    if (is_array($hook)) {
        echo '<pre>';
        echo "Actions for hook: {$hook_name}\n";
        foreach ($hook as $priority => $functions) {
            echo "Priority: {$priority}\n";
            foreach ($functions as $function) {
                if (is_string($function['function'])) {
                    echo "Function: {$function['function']}\n";
                } elseif (is_array($function['function'])) {
                    $class = is_object($function['function'][0]) ? get_class($function['function'][0]) : $function['function'][0];
                    $method = $function['function'][1];
                    echo "Class Method: {$class}::{$method}\n";
                } elseif (is_object($function['function']) && ($function['function'] instanceof Closure)) {
                    echo "Function: Closure\n";
                } else {
                    echo "Function: Unknown type\n";
                }
            }
        }
        echo '</pre>';
    } else {
        echo "No actions found for hook: {$hook_name}";
    }
}

// Example usage
#('wp_head', function() {
#    list_hooked_functions('woocommerce_single_product_summary');
#});


function reorder_product_page_hooks(){
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_rating', 10);
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt', 20);
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_price', 10);
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart', 30);
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_sharing', 50);

    add_action('woocommerce_single_product_summary','woocommerce_template_single_title', 5);
    add_action('woocommerce_single_product_summary','woocommerce_template_single_price', 10);
    add_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt', 15);
    add_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart', 20);
}
add_action( 'woocommerce_single_product_summary', 'reorder_product_page_hooks', 1 );

function reorder_product_page_after_product_hooks(){
    remove_action('woocommerce_after_single_product_summary','woocommerce_output_product_data_tabs', 10);
    remove_action('woocommerce_after_single_product_summary','woocommerce_upsell_display', 15);
    remove_action('woocommerce_after_single_product_summary','woocommerce_output_related_products', 20);

    add_action('woocommerce_after_single_product_summary','add_vendor_info_to_product_page', 5);
    add_action('woocommerce_after_single_product_summary','woocommerce_output_related_products', 10);
}
add_action( 'woocommerce_after_single_product_summary', 'reorder_product_page_after_product_hooks', 1 );


// Function to include custom template part in woocommerce_single_product_summary hook
function include_greeting_benefits_to_product_page() {
    // Include the template part in the woocommerce_single_product_summary hook
    wc_get_template_part( 'template-parts/inc/blocks/greeting-benefits' );
}

// Hook the function to woocommerce_single_product_summary
add_action( 'woocommerce_single_product_summary', 'include_greeting_benefits_to_product_page', 30 );


/**
 * Utility function to get the price of a variation from it's attribute value
 *
 * Add a filter for always showing the variation price - the default settings is, that if
 * the variations have same price, it is not shown.
 */
add_filter( 'woocommerce_show_variation_price', '__return_true');

/**
 * Function to redirect from product page if the vendor is deleted or not active
 *
 * @return void
 */
function redirect_if_vendor_inactive_or_nonexistent() {
    if (is_singular('product')) {
        global $post;

        // Get the vendor ID (post author ID)
        $vendor_id = $post->post_author;

        // Check if the vendor exists in the database
        $vendor = get_userdata($vendor_id);
        if (!$vendor) {
            // Vendor doesn't exist, redirect to a custom page
            wp_redirect(home_url());
            exit;
        }

        // Check if the vendor is of type 'dc_vendor'
        if (!in_array('dc_vendor', $vendor->roles)) {
            // Vendor is not active, redirect to a custom page
            wp_redirect(home_url());
            exit;
        }
    }
}
add_action('template_redirect', 'redirect_if_vendor_inactive_or_nonexistent');


/**
 * Function for getting the price for the current variation for the select dropdown
 *
 * @param $product
 * @param $name
 * @param $term_slug
 * @return string|void
 */
function get_the_variation_price_html( $product, $name, $term_slug ){
    foreach ( $product->get_available_variations() as $variation ){
        if($variation['attributes'][$name] == $term_slug ){
            $price = empty($variation['price_html']) ? $variation['display_regular_price'] : $variation['price_html'];
            return strip_tags( $price );
        }
    }
}

/**
 * Function for getting the text part of the variation price.
 *
 * @param $product
 * @param $name
 * @param $term_slug
 * @return string|void
 */
function get_the_variation_price( $product, $name, $term_slug ){
    foreach ( $product->get_available_variations() as $variation ){
        if($variation['attributes'][$name] == $term_slug ){
            $price = $variation['display_price'];
            return strip_tags( $price );
        }
    }
}

/**
 * Change the way the price is shown for variable products
 *
 * @param $price
 * @param $product
 * @return mixed|null
 */
function change_variable_products_price_display( $price, $product ) {
    // Only for variable products type
    if( ! $product->is_type('variable') ) return $price;

    $prices = $product->get_variation_prices( true );

    if ( empty( $prices['price'] ) )
        return apply_filters( 'woocommerce_variable_empty_price_html', '', $product );

    $min_price = current( $prices['price'] );
    $max_price = end( $prices['price'] );
    $prefix_html = '<span class="price-prefix">' . __('Fra ') . '</span>';

    $prefix = $min_price !== $max_price ? $prefix_html : ''; // HERE the prefix

    return apply_filters( 'woocommerce_variable_price_html', $prefix . wc_price( $min_price ) . $product->get_price_suffix(), $product );
}
add_filter( 'woocommerce_get_price_html', 'change_variable_products_price_display', 10, 2 );

/**
 * Function for showing the price in the attribute dropdown on product pages
 *
 * @param $html
 * @param $args
 * @return mixed|string
 */
function show_price_in_attribute_dropdown( $html, $args ) {
    // Only if there is a unique variation attribute (one dropdown)
    if( sizeof($args['product']->get_variation_attributes()) == 1 ) :

        $options               = $args['options'];
        $product               = $args['product'];
        $attribute             = $args['attribute'];
        $name                  = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
        $id                    = $args['id'] ? $args['id'] : sanitize_title( $attribute );
        $class                 = $args['class'];
        $show_option_none      = (bool) $args['show_option_none'];
        $show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __( 'Choose an option', 'woocommerce' );

        if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
            $attributes = $product->get_variation_attributes();
            $options    = $attributes[ $attribute ];
        }

        $html = '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
        $html .= '<option value="">' . esc_html( $show_option_none_text ) . '</option>';

        if ( !empty( $options ) ) {
            $option_value_arr = array();

            if ( $product && taxonomy_exists( $attribute ) ) {
                $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

                foreach ( $terms as $term ) {
                    if ( in_array( $term->slug, $options ) ) {
                        // Get and inserting the price
                        $price_html = get_the_variation_price_html( $product, $name, $term->slug );
                        $price_raw = get_the_variation_price($product, $name, $term->slug);

                        $price_title_text = (empty($price_html) ? esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) : esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) . ' (' . $price_html . ')' ) );
                        $content = '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . $price_title_text  . '</option>';
                        $option_value_arr[$term->slug] = array('price' => $price_raw, 'title_text' => $price_title_text, 'html' => $content);
                    }
                }
            } else {
                foreach ( $options as $option ) {
                    $selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
                    // Get and inserting the price
                    $price_html = get_the_variation_price_html( $product, $name, sanitize_title( $option ) );
                    $price_raw = get_the_variation_price($product, $name, sanitize_title( $option ));

                    $option_title_text = ( empty($price_html) ? esc_html(apply_filters( 'woocommerce_variation_option_name', $option )) : esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) . ' (' . $price_html . ')' ) );
                    $content = '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . $option_title_text . '</option>';

                    $option_value_arr[sanitize_title( $option )] = array('price' => $price_raw, 'title_text' => $option_title_text, 'html' => $content);
                }
            }

            // Sort the array by price using an anonymous function
            usort($option_value_arr, function($a, $b) {
                if ($a['price'] == $b['price']) {
                    return 0;
                }
                return ($a['price'] < $b['price']) ? -1 : 1;
            });

            foreach($option_value_arr as $v){
                $html .= $v['html'];
            }

        }

        $html .= '</select>';

    endif;

    return $html;
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'show_price_in_attribute_dropdown', 10, 2);