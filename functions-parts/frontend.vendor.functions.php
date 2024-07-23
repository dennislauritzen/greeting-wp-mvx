<?php

function get_vendor_id_on_product_page() {
    // Replace with your logic to get vendor ID
    // Example: Get vendor ID from product data
    global $product;
    $vendor_id = get_post_field('post_author', $product->get_id());
    return $vendor_id;
}
function vendor_redirect_to_home( $query ){
    if ( !is_admin() && $query->is_main_query() ) {
        // Get the request URI
        $request_uri = $_SERVER['REQUEST_URI'];

        // Check if the URL contains '/vendor/'
        if (strpos($request_uri, '/vendor/') !== false) {

            #var_dump($query);
            if (!empty($query->query['dc_vendor_shop'])) {
                global $wpdb;

                $vendor_page_slug = $query->query['dc_vendor_shop'];
                // Query for users with the specific meta key and value
                $args = array(
                    'fields' => 'ID', // Get only user IDs
                    'search' => $vendor_page_slug,
                    'search_columns' => array('user_nicename'), // Search only in user_nicename
                );
                $user_query = new WP_User_Query($args);

                // Check if any users were found
                if (!empty($user_query->results)) {
                    $vendor_id = $user_query->results[0]; // Assuming there's only one vendor for simplicity

                    // Get user data
                    $user_meta = get_userdata($vendor_id);
                    if ($user_meta) {
                        $user_roles = $user_meta->roles;

                        // Check if the user has a role of 'dc_rejected_vendor' or 'dc_pending_vendor'
                        if (in_array('dc_rejected_vendor', $user_roles) || in_array('dc_pending_vendor', $user_roles)) {
                            wp_redirect(home_url(), 302);
                            exit;
                        }
                    }
                }
            }

        }
    }
}
#add_action( 'parse_query', 'vendor_redirect_to_home' );


/**
 * Function to redirect a vendors products to frontpage if the vendor is not active
 *
 * @return void
 */
function redirect_deactivated_vendor_product() {
    // Check if it's a single product page
    if (is_product()) {
        global $post, $product;

        // Get the product ID
        $product_id = $post->ID;

        // Get the vendor ID associated with the product
        $vendor_id = get_post_field('post_author', $product_id);

        // Get the user object for the vendor
        $vendor_user = get_user_by('ID', $vendor_id);

        // Check if the user is a vendor
        if ($vendor_user && !in_array('dc_vendor', $vendor_user->roles, true)) {
            // Redirect to the front page
            wp_redirect(home_url());
            exit;
        }
    }
}
add_action('template_redirect', 'redirect_deactivated_vendor_product');

/**
 * Filter on vendor store page
 * Filtering for products.
 *
 * @usedon /vendor/*
 * Updated 30/4 by Dennis Lauritzen
 */
function productFilterAction() {
    // default product id array come from front end
    $defaultProductIdAsString = $_POST['defaultProductIdAsString'];
    $defaultProductIdArray = explode(",", $defaultProductIdAsString);
    $default_placeholder = array_fill(0, count($defaultProductIdArray), '%d');

    // Get secrets & info
    $nn = $_POST['nn'];
    $gid = (int) $_POST['gid'];
    $guid = $_POST['guid'];

    // Check (best we can) if the data has been changed before post.
    if($guid != hash('crc32c', $gid.'-_-'.$nn)){
        return;
    }

    global $wpdb;

    // input price filter data come from front end
    $inputPriceRangeArray = $_POST['inputPriceRangeArray'];
    $inputMinPrice = (int) $inputPriceRangeArray[0];
    $inputMaxPrice = (int) $inputPriceRangeArray[1];

    #var_dump($inputPriceRangeArray);

    // after click filter data keep on this array
    $catIDs = !empty($_POST['catIds']) ? $_POST['catIds'] : array();

    $occIDs = !empty($_POST['occIds']) ? $_POST['occIds'] : array();

#	$query = array(
#        'post_type' => 'product',
#        'post_status' => 'publish',
#        'author' => $gid,
#        'meta_query' => array(
#            array(
#                'key' => '_price',
#                // 'value' => array(50, 100),
#                'value' => array($inputMinPrice, $inputMaxPrice),
#                'compare' => 'BETWEEN',
#                'type' => 'NUMERIC'
#            )
#        )
#	);

    $query = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'author' => $gid,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => '_price',
                'value' => array($inputMinPrice, $inputMaxPrice),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC',
            ),
            array(
                'key' => '_price',
                'compare' => 'NOT EXISTS', // Exclude products with no specific price
            ),
            array(
                'relation' => 'AND',
                array(
                    'key' => '_price',
                    'compare' => 'EXISTS', // Include products with price
                ),
                array(
                    'key' => '_price',
                    'value' => array($inputMinPrice, $inputMaxPrice),
                    'compare' => 'BETWEEN',
                    'type' => 'NUMERIC',
                ),
            ),
        ),
    );

    // Loop category IDs for where
    $cat_arr = array();
    foreach($catIDs as $k => $v){
        $cat_arr[] = $v;
    }
    // Loop occassion IDs for where
    $occ_arr = array();
    foreach($occIDs as $k => $v){
        $occ_arr[] = $v;
    }

    if(!empty($cat_arr) && !empty($occ_arr)){
        $query['tax_query']['relation'] = 'AND';
    }
    if(!empty($cat_arr)){
        $query['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $cat_arr
        );
    }

    if(!empty($occ_arr)){
        $query['tax_query'][] = array(
            'taxonomy' => 'occasion',
            'field' => 'term_id',
            'terms' => $occ_arr
        );
    }
    $loop = new WP_Query($query);
    #var_dump($loop->have_posts());

    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) {
            $loop->the_post();
            wc_get_template_part( 'content', 'product' );
        }
    } else { ?>

        <div>
            <p id="noProductFound" style="margin-top: 50px; margin-bottom: 35px; padding: 15px 10px; background-color: #f8f8f8;">
                Der blev desværre ikke fundet nogle produkter, der matchede dine filtre.
            </p>
        </div>

    <?php }

    wp_die();
}
add_action( 'wp_ajax_productFilterAction', 'productFilterAction' );
add_action( 'wp_ajax_nopriv_productFilterAction', 'productFilterAction' );


function get_vendor_lowest_price($vendor_id) {
    global $wpdb;

    // SQL query to get the lowest price of active products for the vendor
    $query = $wpdb->prepare("
        SELECT MIN(CAST(pm.meta_value AS DECIMAL(10,2))) AS lowest_price
        FROM {$wpdb->posts} AS p
        INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
        WHERE p.post_type = 'product'
        AND p.post_status = 'publish'
        AND p.post_author = %d
        AND pm.meta_key = '_price'
        AND pm.meta_value != ''
        AND pm.meta_value IS NOT NULL
    ", $vendor_id);

    // Execute the query and get the result
    $lowest_price = $wpdb->get_var($query);

    return $lowest_price ? number_format($lowest_price, 0) : null;
}