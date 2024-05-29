<?php


function vendor_redirect_to_home( $query ){
    $page_slug = $query->dc_vendor_shop;
    global $wpdb;

    #var_dump(get_query_var());

    if( is_tax('dc_vendor_shop') ) {
        $sql = "SELECT
				u.id
			FROM  wp_users u
			INNER JOIN wp_usermeta um
			ON um.user_id = u.id
			WHERE um.meta_key = '_vendor_page_slug' AND um.meta_value LIKE %s";

        $sql_query = $wpdb->prepare( $sql, $query->query['dc_vendor_shop'] );
        $results = $wpdb->get_results($sql_query);

        $vendor_id = $results['0']->id;
        if( isset($vendor_id) && !empty($vendor_id) ){
            $user_meta = get_userdata($vendor_id);
            $user_roles = $user_meta->roles;

            if(in_array('dc_rejected_vendor', $user_roles) || in_array('dc_pending_vendor', $user_roles)){

            }
        }
        #wp_redirect( home_url() );
        #exit;
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