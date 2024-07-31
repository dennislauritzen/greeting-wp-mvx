<?php

// Function to check if the current page is a WooCommerce product category page
function is_product_category_page() {
    return is_product_category();
}

// Function to check if the current page belongs to the custom taxonomy 'occasion'
function is_occasion_page() {
    return is_tax('occasion') && is_archive();
}

function greeting_set_productcat_occasion_custom_headers(){
    if(is_product_category_page()) {
        // Set the headers
        header("Cache-Tag: ProdcatOccassionPage, ProductCat");
    } else if(is_occasion_page()) {
        header("Cache-Tag: ProdcatOccassionPage, Occasion");
    }

    #header("Cache-Control: no-cache, must-revalidate");
    #header("Edge-Cache-Tag: ");
}
add_action('template_redirect', 'greeting_set_productcat_occasion_custom_headers');

/**
 * Function for getting the postal codes on Category and Occasion landing pages
 * Only for getting the postal codes.
 *
 * @author Dennis Lauritzen
 */
add_action('wp_ajax_catocca_landing_data_fetch' , 'catocca_landing_data_fetch');
add_action('wp_ajax_nopriv_catocca_landing_data_fetch','catocca_landing_data_fetch');

function catocca_landing_data_fetch(){
    // Don't
    if (isset($_SERVER['HTTP_X_GREETING_SKIP_DATA_FETCH']) && $_SERVER['HTTP_X_GREETING_SKIP_DATA_FETCH'] === 'true') {
        // Skip fetching the data
        wp_send_json_success();
        return;
    }

    $search_query = esc_attr( $_POST['keyword'] );

    global $wpdb;

    $prepared_statement_cat_occa = $wpdb->prepare("
		SELECT *
		FROM {$wpdb->prefix}posts
		WHERE post_title LIKE %s
		AND post_type = 'city'
		LIMIT 5", '%'.trim($search_query).'%');
    $query_cat_occa = $wpdb->get_results($prepared_statement_cat_occa, OBJECT);

    if (!empty($query_cat_occa)) {
        $array_count = count($query_cat_occa);
        $i = 0;

        foreach ($query_cat_occa as $key => $cat_occa) {
            $postal = get_post_meta($cat_occa->ID, 'postalcode', true);
            $city = get_post_meta($cat_occa->ID, 'city', true);
            $pc_link = get_permalink($cat_occa->ID);

            //get_permalink( $landing_page->ID
            ?>
            <li class="lp-recomms list-group-item py-2 px-4 <?php echo ($key==0) ? 'active' : '';?>" aria-current="true">
                <a
                        href="<?php echo $pc_link; ?>"
                        data-postal="<?php echo $postal; ?>"
                        data-city="<?php echo $city; ?>"
                        data-city-link="<?php echo $pc_link; ?>"
                        class="lp-recomms-link text-teal stretched-link">
                    <?php echo ucfirst($cat_occa->post_title);?>
                </a>
            </li>
        <?php }

        // If there is no match for the city, then do this...
    } else {?>
        <li class="list-group-item py-2 px-4" aria-current="true">
            Der blev desværre ikke fundet nogle byer, der matcher søgekriterierne
        </li>
    <?php }
    die();
}


/**
 * Filtering on the category landing pages.
 *
 * @access public
 * @author Dennis Lauritzen
 */
function categoryPageFilterAction() {

    // default user array come from front end
    $categoryPageDefaultUserIdAsString = $_POST['categoryPageDefaultUserIdAsString'];
    $defaultUserArray = explode(",", $categoryPageDefaultUserIdAsString);

    // category, occasion and delivery  filter data
    $itemArrayForStoreFilter = $_POST['itemArrayForStoreFilter'];

    // declare array for store user ID get from occasion
    $userIdArrayGetFromCatOcca = array();

    // declare array for store user ID got from delivery type
    $userIdArrayGetFromDelivery = array();

    global $wpdb;

    foreach($itemArrayForStoreFilter as $frontendFilterItem){

        if(is_numeric($frontendFilterItem)){
            $productData = $wpdb->get_results(
                "
					SELECT *
					FROM {$wpdb->prefix}term_relationships
					WHERE term_taxonomy_id = $frontendFilterItem
				"
            );
            foreach($productData as $product){
                $singleProductId = $product->object_id;
                $postAuthor = $wpdb->get_row(
                    "
						SELECT *
						FROM {$wpdb->prefix}posts
						WHERE ID = $singleProductId
					"
                );

                $postAuthorId = $postAuthor->post_author;

                array_push($userIdArrayGetFromCatOcca, $postAuthorId);
            }
        } else {

            foreach($defaultUserArray as $defaultUserId){

                $userMetas = get_user_meta($defaultUserId, 'delivery_type', true);

                foreach($userMetas as $deliveryType){
                    if($deliveryType == $frontendFilterItem){
                        array_push($userIdArrayGetFromDelivery, $defaultUserId);
                    }
                }
            }
        }
    }

    // check condition
    $userIdArrayGetFromCatOccaDelivery = array();
    if(count($userIdArrayGetFromCatOcca) > 0 && count($userIdArrayGetFromDelivery) > 0){
        $userIdArrayGetFromCatOccaDelivery = array_intersect($userIdArrayGetFromCatOcca, $userIdArrayGetFromDelivery);
    }
    elseif(count($userIdArrayGetFromCatOcca) > 0 && count($userIdArrayGetFromDelivery) == 0){
        $userIdArrayGetFromCatOccaDelivery = $userIdArrayGetFromCatOcca;
    }
    elseif(count($userIdArrayGetFromCatOcca) == 0 && count($userIdArrayGetFromDelivery) > 0){
        $userIdArrayGetFromCatOccaDelivery = $userIdArrayGetFromDelivery;
    }
    else {
        //echo "No filter applicable!";
    }

    $filteredCatOccaDeliveryArray = array_intersect($defaultUserArray, $userIdArrayGetFromCatOccaDelivery);
    $filteredCatOccaDeliveryArrayUnique = array_unique($filteredCatOccaDeliveryArray);


    if(count($filteredCatOccaDeliveryArrayUnique) > 0 ){
        foreach ($filteredCatOccaDeliveryArrayUnique as $filteredUser) {
            $vendor = get_mvx_vendor($filteredUser);

            // call the template with pass $vendor variable
            get_template_part('template-parts/vendor-loop', null, array('vendor' => $vendor));
        }
    } else { ?>
        <div>
            <p id="noVendorFound" style="margin-top: 50px; margin-bottom: 35px; padding: 15px 10px; background-color: #f8f8f8;">No vendors were found matching your selection.</p>
        </div>
        <?php
    }

    wp_die();
}
if ( !is_cart() && !is_checkout() ) {
    add_action( 'wp_ajax_categoryPageFilterAction', 'categoryPageFilterAction' );
    add_action( 'wp_ajax_nopriv_categoryPageFilterAction', 'categoryPageFilterAction' );
}




/**
 * Function for handling price ranges.
 * Added by Dennis Lauritzen
 *
 * @source https://stackoverflow.com/questions/66072017/filter-products-by-price-range-using-woocommerce-wc-get-products
 */
add_filter( 'woocommerce_product_data_store_cpt_get_products_query', 'handle_price_range_query_var', 10, 2 );
function handle_price_range_query_var( $query, $query_vars ) {
    if ( ! empty( $query_vars['price_range'] ) ) {
        $price_range = explode( '|', esc_attr($query_vars['price_range']) );

        if ( is_array($price_range) && count($price_range) == 2 ) {
            $query['meta_query'][] = array(
                'key' => '_price',
                // 'value' => array(50, 100),
                'value' => $price_range,
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            );

            $query['orderby'] = 'meta_value_num'; // sort by price
            $query['order'] = 'ASC'; // In ascending order
        }
    }
    return $query;
}