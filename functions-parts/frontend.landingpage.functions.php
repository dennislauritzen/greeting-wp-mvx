<?php

/**
 * Vendor filter on Landing Page
 *
 * @usedon /l/*
 *
 */
function lpFilterAction() {
    global $wpdb;

    // default user array come from front end
    $cityDefaultUserIdAsString = $_POST['landingPageDefaultUserIdAsString'];
    $defaultUserArray = explode(",", $cityDefaultUserIdAsString);

    // Check the encryption post key
    $post_key = 'gr42142!____GRege13lj1mnGnERNGRe' . $cityDefaultUserIdAsString . 'greeting!?41412__%!132æfæfdæfsøøaøræwæååå!';
    $post_key_str = hash('sha256', $post_key);

    if(empty($_POST['post_key']) || $post_key_str !== $_POST['post_key']){
        // Someone tried to manipulate the data. Exit.

        return;
        exit;
    }

    // category & occasion filter data
    $catOccaArray = array();
    if(isset($_POST['catOccaIdArray']) && !empty($_POST['catOccaIdArray'])){
        $catOccaArray = $_POST['catOccaIdArray'];
    }
    $catOccaDeliveryIdArray = is_array($catOccaArray) ? $catOccaArray : array();

    // delivery filter data
    $deliveryIdArray = empty($_POST['deliveryIdArray']) ? array() : $_POST['deliveryIdArray'];

    // get the postal code array from post.
    $postal_code = empty($_POST['postalArray']) ? array() : $_POST['postalArray'];

    // get the delivery date from post
    // delivery date
    $deliveryDate = (int) $_POST['delDate'];
    if(empty($deliveryDate) && $deliveryDate !== 0){
        $deliveryDate = 8;
    } else if(!is_numeric($deliveryDate) || $deliveryDate < 0){
        $deliveryDate = 0;
    }

    // Calculate Selected Date
    $timezone = new DateTimeZone('Europe/Copenhagen');
    $filteredDate = new DateTime('now', $timezone);
    $filteredDate->modify('+'.$deliveryDate.' days');
    $selectedDate = $filteredDate->format('d-m-Y');
    $selectedDate2 = $filteredDate->format('dmY');
    $selectedDay = $filteredDate->format('N');

    // declare array for store user ID get from occasion
    $userIdArrayGetFromCatOcca = array();

    // declare array holding store IDs that match delivery date.
    $userIdArrayGetFromDelDate = array();

    // declare array for store user ID got from delivery type
    $userIdArrayGetFromDelivery = array();


    // Prepare the where and where-placeholders for term_id (cat and occassion ID's).
    $where = array();
    $placeholder_arr = (is_countable($catOccaDeliveryIdArray) ? array_fill(0, count($catOccaDeliveryIdArray), '%s') : array());

    if(!empty($catOccaDeliveryIdArray) && is_array($placeholder_arr) && !empty($placeholder_arr)){
        foreach($catOccaDeliveryIdArray as $catOccaDeliveryId){
            if(is_numeric($catOccaDeliveryId)){
                $where[] = $catOccaDeliveryId;
            }
        }

        $sql = "SELECT
			p.post_author
		FROM ".$wpdb->prefix."posts p
		WHERE
			p.ID IN (
				SELECT
					tm.object_id
				FROM ".$wpdb->prefix."term_relationships tm
				WHERE tm.term_taxonomy_id IN (".implode(", ",$placeholder_arr).")
			)
			AND p.post_status = 'publish'
		GROUP BY p.post_author";

        $getStoreUserDataBasedOnProduct = $wpdb->prepare($sql, $where);
        $storeUserCatOccaResults = $wpdb->get_results($getStoreUserDataBasedOnProduct);

        foreach($storeUserCatOccaResults as $product){
            array_push($userIdArrayGetFromCatOcca, $product->post_author);
        }
    }
    // Remove all the stores that doesnt match from default array
    if(!empty($userIdArrayGetFromCatOcca)){
        $userIdArrayGetFromCatOcca = array_intersect($defaultUserArray, $userIdArrayGetFromCatOcca);
        $defaultUserArray = $userIdArrayGetFromCatOcca;
    }

    //////////////////////////
    // FILTER: Postal Codes
    // Prepare the statement for postal code array
    if(!empty($postal_code)){
        $where = array();
        $placeholder_arr = array_fill(0, count($postal_code), 'um.meta_value LIKE %s');
        foreach($postal_code as $postcode){
            $where[] = '%'.$postcode.'%';
        }

        // Add the user role to the where array:
        $where[] = '%dc_vendor%';

        $sql = "SELECT u.ID, umm1.meta_value AS dropoff_time, umm2.meta_value AS require_delivery_day, umm3.meta_value AS delivery_type
		          FROM {$wpdb->prefix}users u
		          LEFT JOIN {$wpdb->prefix}usermeta umm1 ON u.ID = umm1.user_id AND umm1.meta_key = 'vendor_drop_off_time'
		          LEFT JOIN {$wpdb->prefix}usermeta umm2 ON u.ID = umm2.user_id AND umm2.meta_key = 'vendor_require_delivery_day'
		          LEFT JOIN {$wpdb->prefix}usermeta umm3 ON u.ID = umm3.user_id AND umm3.meta_key = 'delivery_type'
		          WHERE EXISTS (
		              SELECT 1
		              FROM {$wpdb->prefix}usermeta um
		              WHERE um.user_id = u.ID AND um.meta_key = 'delivery_zips' AND (".implode(" OR ",$placeholder_arr).")
		          )
		          AND NOT EXISTS (
		              SELECT 1
		              FROM {$wpdb->prefix}usermeta um2
		              WHERE um2.user_id = u.ID AND um2.meta_key = 'vendor_turn_off'
		          )
		          AND EXISTS (
		              SELECT 1
		              FROM {$wpdb->prefix}usermeta um5
		              WHERE um5.user_id = u.ID AND um5.meta_key = 'wp_capabilities' AND um5.meta_value LIKE %s
		          )
		          ORDER BY
		          umm3.meta_value DESC,
		          CASE u.ID
		              WHEN 38 THEN 0
		              WHEN 76 THEN 0
		              ELSE 1
		          END DESC,
		          umm2.meta_value ASC,
		          umm2.meta_value DESC
		";

        $sql_prepare = $wpdb->prepare($sql, $where);
        $users_from_postcode = wp_list_pluck( $wpdb->get_results($sql_prepare), 'ID' );

        // Remove all the stores that doesnt match from default array
        if(!empty($users_from_postcode)){
            $userIdArrayGetFromPostal = array_intersect($defaultUserArray, $users_from_postcode);
            $defaultUserArray = $userIdArrayGetFromPostal;
        }
    }
    // --
    //////////////////////////


    ////////////////////////
    // FILTER: Delivery DATE
    // Prepare the statement for delivery array
    if($deliveryDate >= 0 && $deliveryDate < 8){
        $args = array(
            'role' => 'dc_vendor',
            'include' => $defaultUserArray,
        );

        // (v) @todo: Move cut-off time out of the query and into PHP.
        // (v) @todo: Make sure the store is not closed on the given date!!!! Make a PHP check.

        $usersByDelDateFilter = new WP_User_Query( $args );
        $delDateArr = $usersByDelDateFilter->get_results();

        foreach($delDateArr as $v){
            $dropoff_time 		= get_vendor_dropoff_time($v->ID);
            $delDate 			= get_vendor_delivery_days_required($v->ID);
            $closedDatesArr		= get_vendor_closed_dates($v->ID);
            $delWeekDays	    = get_field('openning','user_'.$v->ID);
            $vendor_extraordinary_dates = get_vendor_delivery_dates_extraordinary($v->ID);

            $open_iso_days = array();
            foreach($delWeekDays as $key => $val){
                $open_iso_days[] = $val['value'];
            }

            $open_this_day = (in_array($selectedDay, $open_iso_days) ? 1 : 0);
            #var_dump($open_this_day);

            // Check if the store is closed this specific date.
            $closedThisDate 	= 0;
            if(in_array($selectedDate, $closedDatesArr)){
                $closedThisDate = 1;
            }

            if (in_array($selectedDate, $vendor_extraordinary_dates) || in_array($selectedDate2, $vendor_extraordinary_dates)) {
                $open_this_day = 1;
                $closedThisDate = 0;
            }

            if (in_array($selectedDate, $vendor_extraordinary_dates) || in_array($selectedDate2, $vendor_extraordinary_dates)) {
                array_push($userIdArrayGetFromDelDate, (string) $v->ID);
            } else if($deliveryDate < $delDate){
                // Can't delivery on selected date.
            } else if($deliveryDate == $delDate && $dropoff_time < date("H")){
                // Can't deliver on selected date because time has passed cutoff.
            } else {
                // Can deliver, woohoo.
                if($closedThisDate == 0 && $open_this_day == 1){
                    array_push($userIdArrayGetFromDelDate, (string) $v->ID);
                }
            }
        }

        #var_dump($userIdArrayGetFromDelDate);

        // Remove all the stores that doesnt match from default array
        // Normally we would check if the userIdArray is empty, but not here,
        // instead we check if the date-filter is set - if it is and the userID-array
        // is empty, then there is no stores left.
        // if(!empty($userIdArrayGetFromDelDate)){
        $userIdArrayGetFromDelDate = array_intersect($defaultUserArray, $userIdArrayGetFromDelDate);
        $defaultUserArray = $userIdArrayGetFromDelDate;
    }


    ////////////////////////
    // FILTER: Delivery
    // Prepare the statement for delivery array
    $where = array();
    $placeholder_arr = array_fill(0, count($deliveryIdArray), '%s');

    if(!empty($deliveryIdArray)){
        $args = array(
            'role' => 'dc_vendor',
            'meta_query' => array(
                'key' => 'delivery_type',
                'value' => $deliveryIdArray,
                'compare' => 'IN',
                'type' => 'NUMERIC'
            )
        );
        $usersByFilter = new WP_User_Query( $args	);
        $deliveryArr = $usersByFilter->get_results($usersByFilter);

        foreach($deliveryArr as $v){
            $delivery_type = get_field('delivery_type','user_'.$v->ID);

            if(!empty($delivery_type)){
                if(in_array($delivery_type[0]['value'],$deliveryIdArray) || (isset($delivery_type[1]['value']) && in_array($delivery_type[1]['value'],$deliveryIdArray) )  ){
                    array_push($userIdArrayGetFromDelivery, (string) $v->ID);
                }
            }
        }
    }
    // Remove all the stores that doesnt match from default array
    if(!empty($userIdArrayGetFromDelivery)){
        $userIdArrayGetFromDelivery = array_intersect($defaultUserArray, $userIdArrayGetFromDelivery);
        $defaultUserArray = $userIdArrayGetFromDelivery;
    }

    ////////////////
    // Filter: Price
    // Location: City Page
    // input price filter data come from front end
    $userIdArrayGetFromPriceFilter = array();
    $inputPriceRangeArray = $_POST['inputPriceRangeArray'];
    $inputMinPrice = (int) $inputPriceRangeArray[0];
    $inputMaxPrice = (int) $inputPriceRangeArray[1];

    $author_ids = $wpdb->get_col(
        $wpdb->prepare(
            "
	        SELECT DISTINCT p.post_author
	        FROM {$wpdb->prefix}posts p
	        INNER JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id
	        WHERE p.post_type = 'product'
	        AND p.post_status = 'publish'
	        AND pm.meta_key = '_price'
	        AND pm.meta_value BETWEEN %d AND %d
	        ",
            $inputMinPrice,
            $inputMaxPrice
        )
    );

    $userIdArrayGetFromPriceFilter = array_unique($author_ids);

    // Remove all the stores that doesnt match from default array
    if(!empty($userIdArrayGetFromPriceFilter)){
        $userIdArrayGetFromPriceFilter = array_intersect($defaultUserArray, $userIdArrayGetFromPriceFilter);

        $defaultUserArray = $userIdArrayGetFromPriceFilter;
    }

    // three array is
    // $userIdArrayGetFromPostal
    // $userIdArrayGetFromCatOcca
    // $userIdArrayGetFromDelivery
    // $userIdArrayGetFromPriceFilter

    $return_arr = $defaultUserArray;

    $first = 0;
    if(!empty($return_arr)){
        foreach ($return_arr as $filteredUser) {
            $vendor_int = (int) $filteredUser;

            $vendor = get_mvx_vendor($vendor_int);
            $cityName = $_POST['cityName'];

            // Get the delivery type for the vendor so we know if it is local or freight.
            // The delivery type of the store
            $delivery_type = get_field('delivery_type','user_'.$vendor->id);
            $delivery_type = (!empty($delivery_type['0']['value']) ? $delivery_type['0']['value'] : 0);

            if($delivery_type == 0 && $first == 0){
                get_template_part('template-parts/vendor-freight-heading', null, array('cityName' => $cityName));
                $first = 1;
            }
            // call the template with pass $vendor variable
            get_template_part('template-parts/vendor-loop', null, array('vendor' => $vendor, 'cityName' => $cityName));
        }
    } else { ?>
        <div>
            <p id="noVendorFound" style="margin-top: 50px; margin-bottom: 35px; padding: 15px 10px; background-color: #f8f8f8;">
                Der blev desværre ikke fundet nogle butikker, der matcher dine søgekriterier.
            </p>
        </div>
        <?php
    }
    wp_die();
}
add_action( 'wp_ajax_lpFilterAction', 'lpFilterAction' );
add_action( 'wp_ajax_nopriv_lpFilterAction', 'lpFilterAction' );

