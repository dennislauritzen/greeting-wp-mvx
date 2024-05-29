<?php

/**
 * Function for duplicating taxonomies when duplicating a product.
 *
 * @author Dennis Lauritzen
 * @param \WC_Product $duplicate The new product, that is the receiver of the copied stuff
 * @param \WC_Product $product The original product, that we are copying from
 * @return void
 */
add_action( 'woocommerce_product_duplicate', 'greeting_duplicate_custom_taxonomies', 999, 2);
function greeting_duplicate_custom_taxonomies( WC_Product $duplicate, WC_Product $product ) {
    foreach ( [ 'occasion' ] as $taxonomy ) {
        $terms = get_the_terms( $product->get_id(), $taxonomy );
        if ( ! is_wp_error( $terms ) ) {
            wp_set_object_terms( $duplicate->get_id(), wp_list_pluck( $terms, 'term_id' ), $taxonomy );
        }
    }
}


/***
 * Function for securing that WooCommerce doesn't add "Copy" / "Kopier" to product name
 * When duplication product
 *
 *
 */
// Hook into the action that fires when a product is duplicated
add_action('woocommerce_product_duplicate_before_save', 'greeting_name_product_as_original', 9, 2);
function greeting_name_product_as_original($duplicate, $product) {
    // Get the original product's name
    $original_name = $product->get_name();

    // Set the original name for the duplicated product
    $duplicate->set_name($original_name);

    // Save the changes to the duplicated product
    $duplicate->save();
}

/**
 * Hook into the action that fires when a product is duplicated
 *
 * @param WC_Product $duplicate
 * @param WC_Product $product
 * @return void
 */
function woocommerce_product_new_slug_for_duplicate(WC_Product $duplicate, WC_Product $product) {
    // Get the original product's slug
    $original_slug = $product->get_slug();

    // Get the original product's post ID
    $original_id = $product->get_id();

    // Get the number of duplicates for the original product
    $duplicate_count = 1;
    while (get_page_by_path($original_slug . '-' . $duplicate_count, OBJECT, 'product')) {
        $duplicate_count++;
    }

    // Append the sequential number to the original slug
    $new_slug = $original_slug . '-' . $duplicate_count;

    // Set the new slug for the duplicated product
    $duplicate->set_slug($new_slug);

    // Set the original name for the duplicated product
    $duplicate->set_name($product->get_name());

    // Save the changes to the duplicated product
    $duplicate->save();
}
add_action('woocommerce_product_duplicate', 'woocommerce_product_new_slug_for_duplicate', 10, 2);
