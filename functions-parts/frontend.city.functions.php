<?php

/**
 * Vendor filter on City Pages.
 *
 * Be aware!! This is also used for category and occasion filters (archive-product.php)
 *
 * @usedon single-city.php
 * @usedon archive-product.php
 * @author Dennis Lauritzen
 */
/**
 *
 */


/**
 * Vendor filter on City Page
 *  city filter
 *
 * This is used by the old single-city-v2-old.php
 *
 * @usedby single-city-v2-old.php
 * @return void
 */
function oldcategoryAndOccasionVendorFilterAction() {
    global $wpdb;

    // default user array come from front end
    $cityDefaultUserIdAsString = $_POST['cityDefaultUserIdAsString'];
    $defaultUserArray = explode(",", $cityDefaultUserIdAsString);

    // category & occasion filter data
    $catOccaArray = array();
    if(isset($_POST['catOccaIdArray']) && !empty($_POST['catOccaIdArray'])){
        $catOccaArray = $_POST['catOccaIdArray'];
    }
    $catOccaDeliveryIdArray = is_array($catOccaArray) ? $catOccaArray : array();

    // The default ID from the category / occasion (the "base" landing page cat / occa)
    $idCatOccaArray = array();
    if(isset($_POST['defaultIdCatOcca']) && !empty($_POST['defaultIdCatOcca'])){
        $idCatOccaArray = $_POST['defaultIdCatOcca'];
    }
    $defaultIdCatOcca = is_array($idCatOccaArray) ? $idCatOccaArray : array();

    // delivery date
    $deliveryDate = empty($_POST['delDate']) ? 8 : $_POST['delDate'];
    if(empty($deliveryDate) && $deliveryDate != 0){
        $deliveryDate = 8;
    } else if(!is_numeric($deliveryDate) || $deliveryDate < 0){
        $deliveryDate = 0;
    }

    // Calculate Selected Date
    $filteredDate = new DateTime();
    $filteredDate->modify('+'.$deliveryDate.' days');
    $selectedDate = $filteredDate->format('d-m-Y');
    $selectedDate2 = $filteredDate->format('dmY');
    $selectedDay = $filteredDate->format('N');

    // delivery filter data
    $deliveryIdArray = $_POST['deliveryIdArray'];

    $postal_code = $_POST['postalCode'];

    // declare array for store user ID get from occasion
    $userIdArrayGetFromPostalCode = array();

    // declare array for store user ID get from occasion
    $userIdArrayGetFromDelDate = array();

    // declare array for store user ID get from occasion
    $userIdArrayGetFromCatOcca = array();

    // declare array for store user ID got from delivery type
    $userIdArrayGetFromDelivery = array();

    ////////////////////////
    // FILTER: Category & Occasion
    // Prepare the where and where-placeholders for term_id (cat and occassion ID's).
    $where = array();
    $placeholder_arr = (is_countable($catOccaDeliveryIdArray) ? array_fill(0, count($catOccaDeliveryIdArray), '%s') : array());

    #### TEST INITIAL ARRAY
    #highlight_string("\n\$defaultUserArrayInit =\n" . var_export($defaultUserArray, true) . ";\n");

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

    ////////////////////////
    // FILTER: Delivery DATE
    // Prepare the statement for delivery array
    if($deliveryDate >= 0 && $deliveryDate < 8){
        $args = array(
            'role' => 'dc_vendor',
            'meta_query' => array(
                'key' => 'vendor_require_delivery_day',
                'value' => $deliveryDate,
                'compare' => '<=',
                'type' => 'NUMERIC'
            )
        );

        // (v) @todo: Move cut-off time out of the query and into PHP.
        // (v) @todo: Make sure the store is not closed on the given date!!!! Make a PHP check.

        $usersByDelDateFilter = new WP_User_Query( $args	);
        $delDateArr = $usersByDelDateFilter->get_results();

        foreach($delDateArr as $v){
            $dropoff_time 		= get_field('vendor_drop_off_time','user_'.$v->ID);
            $delDate 			= get_field('vendor_require_delivery_day','user_'.$v->ID);
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


        // Remove all the stores that doesnt match from default array
        // Normally we would check if the userIdArray is empty, but not here,
        // instead we check if the date-filter is set - if it is and the userID-array
        // is empty, then there is no stores left.
        // if(!empty($userIdArrayGetFromDelDate)){
        $userIdArrayGetFromDelDate = array_intersect($defaultUserArray, $userIdArrayGetFromDelDate);
        $defaultUserArray = $userIdArrayGetFromDelDate;
    }

    ////////////////////////
    // Filter Postal Code
    //
    $sql = "SELECT u.ID, umm1.meta_value AS dropoff_time, umm2.meta_value AS require_delivery_day, umm3.meta_value AS delivery_type
          FROM {$wpdb->prefix}users u
          LEFT JOIN {$wpdb->prefix}usermeta umm1 ON u.ID = umm1.user_id AND umm1.meta_key = 'vendor_drop_off_time'
          LEFT JOIN {$wpdb->prefix}usermeta umm2 ON u.ID = umm2.user_id AND umm2.meta_key = 'vendor_require_delivery_day'
          LEFT JOIN {$wpdb->prefix}usermeta umm3 ON u.ID = umm3.user_id AND umm3.meta_key = 'delivery_type'
          WHERE EXISTS (
              SELECT 1
              FROM {$wpdb->prefix}usermeta um
              WHERE um.user_id = u.ID AND um.meta_key = 'delivery_zips' AND um.meta_value LIKE %s
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
          umm2.meta_value DESC";

    $vendor_query = $wpdb->prepare($sql, '%'.$postal_code.'%', '%dc_vendor%');
    $vendor_arr = $wpdb->get_results($vendor_query);

    foreach($vendor_arr as $k => $v){
        array_push($userIdArrayGetFromPostalCode, (string) $v->ID);
    }

    // Remove all the stores that doesnt match from default array
    if(!empty($userIdArrayGetFromPostalCode)){
        $userIdArrayGetFromPostalCode = array_intersect($defaultUserArray, $userIdArrayGetFromPostalCode);
        $defaultUserArray = $userIdArrayGetFromPostalCode;
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
        SELECT DISTINCT(p.post_author)
        FROM {$wpdb->prefix}posts p
        INNER JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id
        WHERE (p.post_type = 'product' OR p.post_type = 'product_variation')
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
    // $userIdArrayGetFromCatOcca
    // $userIdArrayGetFromDelivery
    // $userIdArrayGetFromPriceFilter

    $return_arr = $defaultUserArray;

    //Variable holding the boolean controlling if it is the first freight store.
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

/**
 * This is the new function used by single-city.php
 *
 * @usedby single-city.php
 * @return void
 */
function categoryAndOccasionVendorFilterAction() {
    global $wpdb;

    // default user array come from front end
    $cityDefaultUserIdAsString = $_POST['cityDefaultUserIdAsString'];
    $defaultUserArray = explode(",", $cityDefaultUserIdAsString);

    // delivery date
    $deliveryDate = empty($_POST['delDate']) ? 8 : $_POST['delDate'];
    if(empty($deliveryDate) && $deliveryDate != 0){
        $deliveryDate = 8;
    } else if(!is_numeric($deliveryDate) || $deliveryDate < 0){
        $deliveryDate = 0;
    }

    // CAtegory & Occasions
    // category & occasion filter data
    $catOccaArray = array();
    if(isset($_POST['catOccaIdArray']) && !empty($_POST['catOccaIdArray'])){
        $catOccaArray = $_POST['catOccaIdArray'];
    }
    $catOccaDeliveryIdArray = is_array($catOccaArray) ? $catOccaArray : array();

    // Calculate Selected Date
    $timezone = new DateTimeZone('Europe/Copenhagen');
    $filteredDate = new DateTime('now', $timezone);
    $filteredDate->modify('+'.$deliveryDate.' days');
    $selectedDate = $filteredDate->format('d-m-Y');
    $selectedDate2 = $filteredDate->format('dmY');
    $selectedDay = $filteredDate->format('N');

    $postal_code = $_POST['postalCode'];

    // declare array for store user ID get from occasion
    $userIdArrayGetFromCatOcca = array();

    // declare array for store user ID get from occasion
    $userIdArrayGetFromPostalCode = array();

    // declare array for delivery date
    $userIdArrayGetFromDelDate = array();

    ////////////////////////
    // FILTER: Category & Occasion
    // Prepare the where and where-placeholders for term_id (cat and occassion ID's).
    $where = array();
    $placeholder_arr = (is_countable($catOccaDeliveryIdArray) ? array_fill(0, count($catOccaDeliveryIdArray), '%s') : array());

    #### TEST INITIAL ARRAY
    #highlight_string("\n\$defaultUserArrayInit =\n" . var_export($defaultUserArray, true) . ";\n");

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

    ////////////////////////
    // FILTER: Delivery DATE
    // Prepare the statement for delivery array
    if($deliveryDate >= 0 && $deliveryDate < 8){
        $args = array(
            'role' => 'dc_vendor',
            'meta_query' => array(
                'key' => 'vendor_require_delivery_day',
                'value' => $deliveryDate,
                'compare' => '<=',
                'type' => 'NUMERIC'
            )
        );

        // (v) @todo: Move cut-off time out of the query and into PHP.
        // (v) @todo: Make sure the store is not closed on the given date!!!! Make a PHP check.

        $usersByDelDateFilter = new WP_User_Query( $args	);
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

        // Remove all the stores that doesnt match from default array
        // Normally we would check if the userIdArray is empty, but not here,
        // instead we check if the date-filter is set - if it is and the userID-array
        // is empty, then there is no stores left.
        // if(!empty($userIdArrayGetFromDelDate)){
        $userIdArrayGetFromDelDate = array_intersect($defaultUserArray, $userIdArrayGetFromDelDate);
        $defaultUserArray = $userIdArrayGetFromDelDate;
    }

    ////////////////////////
    // Filter Postal Code
    //
    $sql = "SELECT u.ID, umm1.meta_value AS dropoff_time, umm2.meta_value AS require_delivery_day, umm3.meta_value AS delivery_type
          FROM {$wpdb->prefix}users u
          LEFT JOIN {$wpdb->prefix}usermeta umm1 ON u.ID = umm1.user_id AND umm1.meta_key = 'vendor_drop_off_time'
          LEFT JOIN {$wpdb->prefix}usermeta umm2 ON u.ID = umm2.user_id AND umm2.meta_key = 'vendor_require_delivery_day'
          LEFT JOIN {$wpdb->prefix}usermeta umm3 ON u.ID = umm3.user_id AND umm3.meta_key = 'delivery_type'
          WHERE EXISTS (
              SELECT 1
              FROM {$wpdb->prefix}usermeta um
              WHERE um.user_id = u.ID AND um.meta_key = 'delivery_zips' AND um.meta_value LIKE %s
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
          umm2.meta_value DESC";

    $vendor_query = $wpdb->prepare($sql, '%'.$postal_code.'%', '%dc_vendor%');
    $vendor_arr = $wpdb->get_results($vendor_query);

    foreach($vendor_arr as $k => $v){
        array_push($userIdArrayGetFromPostalCode, (string) $v->ID);
    }

    // Remove all the stores that doesnt match from default array
    if(!empty($userIdArrayGetFromPostalCode)){
        $userIdArrayGetFromPostalCode = array_intersect($defaultUserArray, $userIdArrayGetFromPostalCode);
        $defaultUserArray = $userIdArrayGetFromPostalCode;
    }

    // three array is
    // $userIdArrayGetFromCatOcca
    // $userIdArrayGetFromDelivery
    // $userIdArrayGetFromPriceFilter

    $return_arr = $defaultUserArray;

    //Variable holding the boolean controlling if it is the first freight store.
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
add_action( 'wp_ajax_catOccaDeliveryAction', 'categoryAndOccasionVendorFilterAction' );
add_action( 'wp_ajax_nopriv_catOccaDeliveryAction', 'categoryAndOccasionVendorFilterAction' );
add_action( 'wp_ajax_categoryAndOccasionVendorFilterAction', 'categoryAndOccasionVendorFilterAction' );
add_action( 'wp_ajax_nopriv_categoryAndOccasionVendorFilterAction', 'categoryAndOccasionVendorFilterAction' );
