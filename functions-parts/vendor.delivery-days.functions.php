<?php

#######################################
##
## DEFINITION FUNCTIONS
##
## These functions get the base values
##

function get_vendor_delivery_days_required($vendor_id, $type = 'weekday'){
    // Get the new delivery day required value
    $get_deliveryday_required_repeater = get_field('vendor_require_order_days_before', 'user_'.$vendor_id);

    // Get the old delivery day required value.
    # Just as a fallback
    $delivery_day_required_old = get_field('vendor_require_delivery_day', 'user_'.$vendor_id);
    $delivery_day_required_old = (!empty($delivery_day_required_old) ? $delivery_day_required_old : 0);

    if (
        $get_deliveryday_required_repeater === NULL
        ||
        (
            (!isset($get_deliveryday_required_repeater['order_days_before_weekday']) || (empty($get_deliveryday_required_repeater['order_days_before_weekday']) && $get_deliveryday_required_repeater['order_days_before_weekday'] !== "0"))
            && (!isset($get_deliveryday_required_repeater['order_days_before_weekend']) || (empty($get_deliveryday_required_repeater['order_days_before_weekend']) && $get_deliveryday_required_repeater['order_days_before_weekend'] !== "0"))
            && (!isset($get_deliveryday_required_repeater['order_days_before_holiday']) || (empty($get_deliveryday_required_repeater['order_days_before_holiday']) && $get_deliveryday_required_repeater['order_days_before_holiday'] !== "0"))
        )
    ){
        #print "nye felter er tomme";
        return $delivery_day_required_old;
    } else {
        #print "nye felter er ikke tomme";
        if($type == 'holiday'){
            return (!empty($get_deliveryday_required_repeater['order_days_before_holiday'] || $get_deliveryday_required_repeater['order_days_before_holiday'] == "0") ? $get_deliveryday_required_repeater['order_days_before_holiday'] : $delivery_day_required_old);
        } else if($type == 'weekend') {
            return (!empty($get_deliveryday_required_repeater['order_days_before_weekend'] || $get_deliveryday_required_repeater['order_days_before_weekend'] == "0") ? $get_deliveryday_required_repeater['order_days_before_weekend'] : $delivery_day_required_old);
        } else {
            return (!empty($get_deliveryday_required_repeater['order_days_before_weekday'] || $get_deliveryday_required_repeater['order_days_before_weekday'] == "0") ? $get_deliveryday_required_repeater['order_days_before_weekday'] : $delivery_day_required_old);
        }
    }
}

/**
 * Function for getting the closed dates from the Vendor.
 * Either from the text field - or from the repeater field
 *
 * @author Dennis Lauritzen <dl@dvlp-consult.dk
 * @param $vendor_id integer
 * @return array
 */
function get_vendor_closed_dates($vendor_id){
    // Get the closed days / dates for the vendor.

    // TEXT FIELD
    // Get the closed dates from the text field
    $vendorClosedDay = get_user_meta($vendor_id, 'vendor_closed_day', true);
    $meta_closed_days = empty($vendorClosedDay) ? get_field('vendor_closed_day', 'user_'.$vendor_id) : $vendorClosedDay;

    // Split the closed dates
    $vendor_closed_days_text = (!empty($meta_closed_days) ? preg_split('/[, ]+/', $meta_closed_days, -1, PREG_SPLIT_NO_EMPTY) : array());

    // REPEATER FIELD
    // If the closed dates from the text field is empty, get it from
    $vendor_closed_days_repeater = get_field('vendor_closed_dates', 'user_'.$vendor_id);

    // Set the array
    $closed_dates_array = array();

    # We could think about merging the two arrays (TEXT & REPEATER) if both are set:
    #return array_merge($vendor_closed_days_text, $vendor_closed_days_repeater);

    if(!empty($vendor_closed_days_repeater)
        && is_array($vendor_closed_days_repeater)
        && $vendor_closed_days_text != $vendor_closed_days_repeater){
        return array_map(function($item) {
            if(empty($item) || empty($item['closing_dates'])){
                return;
            }

            $closingDate = DateTime::createFromFormat('d/m/Y', $item['closing_dates']);
            return $closingDate->format('d-m-Y');
        }, $vendor_closed_days_repeater);
    } else {
        return array_filter($vendor_closed_days_text, function ($element) {
            return is_string($element) && '' !== trim($element);
        });
        // Old days this was done this way: $closedDatesArr		= array_map('trim', explode(",",$delClosedDates));
        #$closed_dates_array = $vendor_closed_days_text;
    }
}

/**
 * Function for getting the dropoff time for a specific vendor.
 *
 * @param $vendor_id
 * @param $type weekday|weekend|holiday
 * @return string
 */
function get_vendor_dropoff_time($vendor_id, $type = 'weekday'){
    // Get the vendor dropoff time the old way
    // Get the dropoff time metavalue for the vendor.
    #$vendorDropOffTime = ($type == 'weekend' ? get_user_meta($vendor_id, 'vendor_drop_off_time_weekend', true) : get_user_meta($vendor_id, 'vendor_drop_off_time', true));

    $vendor_cutoff_times = get_field('vendor_cutoff_times', 'user_'.$vendor_id);
#var_dump($vendor_cutoff_times);
    // Get the new vendor dropoff time.
    if(!empty($vendor_cutoff_times)
        && !(empty($vendor_cutoff_times['cutoff_time_weekend']) && empty($vendor_cutoff_times['cutoff_time_holiday']) && empty($vendor_cutoff_times['cutoff_time_weekday']))
        && count($vendor_cutoff_times) > 0){
        if($type == 'weekend' && !empty($vendor_cutoff_times['cutoff_time_weekend'])) {
            $vendor_dropoff_time = $vendor_cutoff_times['cutoff_time_weekend'];
        } else if($type == 'holiday' && !empty($vendor_cutoff_times['cutoff_time_holiday'])) {
            $vendor_dropoff_time = $vendor_cutoff_times['cutoff_time_holiday'];
        } else if($type == 'weekday'  && !empty($vendor_cutoff_times['cutoff_time_weekday'])) {
            $vendor_dropoff_time = $vendor_cutoff_times['cutoff_time_weekday'];
        }
    } else {
        $vendor_dropoff_time = get_field('vendor_drop_off_time', 'user_'.$vendor_id);
        $vendor_dropoff_time = empty($vendor_dropoff_time)?: get_user_meta($vendor_id, 'vendor_drop_off_time', true);
    }

    if(!empty($vendor_dropoff_time)) {
        if (strpos($vendor_dropoff_time, ':') === false && strpos($vendor_dropoff_time, '.') === false) {
            $vendor_dropoff_time = $vendor_dropoff_time . ':00';
        } else {
            $vendor_dropoff_time = str_replace(array(':', '.'), array(':', ':'), $vendor_dropoff_time);
        }

        $default_timeZone = new DateTimeZone('Europe/Copenhagen');
    } else {
        $vendor_dropoff_time = '00:00:00';
        $default_timeZone = new DateTimeZone('Europe/Copenhagen');
    }

    // Create the DateTime object in default timezone
    $dateTime = new DateTime($vendor_dropoff_time, $default_timeZone);

    // Save the original time
    $originalTime = $dateTime->format('H:i:s');

    // Change the timezone to Copenhagen but keep the time the same
    $timeZone = new DateTimeZone('Europe/Copenhagen');
    $dateTime->setTimezone($timeZone);

    // Check if the converted time is different from the original time
    if ($dateTime->format('H:i:s') !== $originalTime) {
        // Adjust the DateTime to retain the original time
        $dateTime = new DateTime($originalTime, new DateTimeZone('Europe/Copenhagen'));
    }

    // Return the time in H:i:s format
    return $dateTime->format('H:i:s');
}

/**
 * Get the vendor delivery dates for the extraordinary opening dates.
 *
 * @param $vendor_id
 * @return array|null[]|string[]|void[]
 */
function get_vendor_delivery_dates_extraordinary($vendor_id){
    $extraordinary_dates = get_field('vendor_open_dates_extraordinary', 'user_'.$vendor_id);

    // Check if $extraordinary_dates is empty, and return an empty array if true
    if (empty($extraordinary_dates)) {
        return array();
    }

    return array_map(function ($item) {
        if(empty($item) || empty($item['opening_date'])){
            return;
        }

        $openingDate = DateTime::createFromFormat('d/m/Y', $item['opening_date']);
        return $openingDate ? $openingDate->format('d-m-Y') : null;
    }, $extraordinary_dates);
}

/**
 * Get the global set closed dates from admin.
 *
 * @param $type
 * @return array|null[]|string[]|void[]
 */
function get_global_days($type = 'closed') {
    $result = [];

    if ($type != 'closed' && $type != 'holidays') {
        return $result;
    }

    if ($type == 'holidays') {
        $holidays = get_field('global_holidays', 'option');

        // Check if $closed_dates is empty
        if (empty($holidays)) {
            return []; // Return an empty array
        }

        return array_map(function ($item) {
            $closingDate = DateTime::createFromFormat('d/m/Y', $item['holiday_date']);
            return $closingDate ? $closingDate->format('d-m-Y') : null;
        }, $holidays);
    } else {
        $closed_dates = get_field('global_closed_dates', 'option');

        // Check if $closed_dates is empty
        if (empty($closed_dates)) {
            return []; // Return an empty array
        }

        return array_map(function ($item) {
            if(empty($item) || empty($item['closed_date'])){
                return;
            }

            $closingDate = DateTime::createFromFormat('d-m-Y', $item['closed_date']);
            return $closingDate ? $closingDate->format('d-m-Y') : null;
        }, $closed_dates);
    }
}

/**
 * Get the type of delivery type for a vendor.
 *
 * @param $vendor_id
 * @param $return_type
 * @return string|array
 */
function get_vendor_delivery_type($vendor_id, $return_type = 'type'){
    // Get delivery type.
    $del_type = '';
    $del_value = '';

    $delivery = get_field('delivery_type', 'user_'.$vendor_id);

    if(!empty($delivery)){
        $delivery_type = $delivery[0];

        if(empty($delivery_type['label'])){
            $del_value = $delivery_type;
            $del_type = $delivery_type;
        } else {
            $del_value = $delivery_type['value'];
            $del_type = $delivery_type['label'];
        }
    }

    if($return_type == 'type'){
        return $del_type;
    } else if($return_type == 'value'){
        return $del_value;
    } else {
        return array('value' => $del_value, 'type' => $del_type);
    }
}

##
##
##
##
## This is the end of the definitions functions
## ----------------------------------------------
#################################################
#################################################


/**
 * Function for calculating the days until the vendor is next able to deliver.
 *
 * @param $vendor_id
 * @return false|mixed|void
 *
 * (No - no necessary) #to do Calculate this using the new way, in order to ensure it takes weekends and holidays into account.
 *
 * @deprecated Use get_vendor_delivery_days_from_today instead
 */
function get_vendor_days_until_delivery($vendor_id, $for_vendor_header_with_cutoff = false){
    if(empty($vendor_id)){
        return;
    }

    // Set the timezone to Copenhagen
    date_default_timezone_set('Europe/Copenhagen');

    $dropoff_time 		= get_vendor_dropoff_time($vendor_id);
    $delDate 			= get_vendor_delivery_days_required($vendor_id);
    $closedDatesArr		= get_vendor_closed_dates($vendor_id);
    $delWeekDays		= get_field('openning','user_'.$vendor_id);

    // Check if the store is closed this specific date.
    $closedThisDate 	= (in_array(date('d-m-Y'), $closedDatesArr)) ? 1 : 0;

    // Start calculation from 0 (= today)
    $days_until_delivery = $delDate;

    $open_iso_days = array();
    foreach($delWeekDays as $key => $val){
        $open_iso_days[] = $val['value'];
    }

    $open_this_day = (in_array(date('N'), $open_iso_days) ? 1 : 0);

    if($open_this_day == 0){
        $days_until_delivery++;
    } else {
        if($closedThisDate == 1){
            $days_until_delivery++;
        } else {
            if($dropoff_time < date('H')){
                $days_until_delivery++;
            }
        }
    }
    #if($for_vendor_header_with_cutoff === true){
    #    $days_until_delivery--;
    #}

    return $days_until_delivery;
}

/**
 * Function for calculating how many days from now until next time the store can deliver.
 * Implements the array from the get_vendor_dates_new() function.
 *
 * @uses get_vendor_dates_new()
 * @param $days_array
 * @param $today
 * @return String
 */
function get_vendor_delivery_days_from_today($vendor_id, $prepend_text = '', $del_type = "1", $long_or_short_text = 0)
{
    // Set the timezone to Copenhagen
    #date_default_timezone_set('Europe/Copenhagen');

    #if(!($comparison_date instanceof DateTime)){
    #   $comparison_date = DateTime::createFromFormat('d-m-Y', now());
    #}

    $vendor_days = get_vendor_dates_new($vendor_id, 'd-m-Y', 'all', 60);
    $result = [];

    $now = new DateTime();

    foreach ($vendor_days as $p => $c) {
        if(isset($c['cutoff_datetime'])
            && $c['cutoff_datetime'] !== false){

            $cutofftime = $c['cutoff_datetime'];

            $cutoff_time = DateTime::createFromFormat('d-m-Y H:i:s', $cutofftime, new DateTimeZone('UTC'));
            // Change the timezone to Copenhagen
            $cutoff_time->setTimezone(new DateTimeZone('Europe/Copenhagen'));

            #$cutoff_time = DateTime::createFromFormat('d-m-Y H:i:s', $cutofftime);

            if($cutoff_time > $now){
                $result = array(
                    'date' => $c['date'],
                    'cutoff_datetime' => $c['cutoff_datetime'],
                    'cutoff_time' => $c['cutoff_time'],
                    'type' => $c['type']
                );
                break; // Break out of the inner loop once a non-false 'cutoff_time' is found
            }
        }
    }

    $date = '';
    $text = '';
    if(empty($result)){
        return;
    } else {
        // Create a fallback date object.
        $date_str = $result['date'].' 00:00:00';
        $date_obj =  DateTime::createFromFormat('d-m-Y H:i:s', $date_str, new DateTimeZone('UTC'));
        $date_obj->setTimezone(new DateTimeZone('Europe/Copenhagen'));
        #$date = $date_obj->format('d-m-Y'); // Construct from the date.

        $str = '';
        if($del_type == "1"){
            $str .= 'Levere ';
        } else if($del_type == "0"){
            $str .= 'Afsende ';
        }
        if($long_or_short_text == 1){
            $str = "Butikken kan ".strtolower($str);
        } else if($long_or_short_text == 2){
            $str = '';
        }

        return $prepend_text . ' ' . strtolower($str . get_date_diff_text($date_obj));
        // There is a date. Let's populate the variables for the calculation.
    }
}

/**
 * Function for calculating when the order should be made - used on the header-vendor.php
 * The difference from the one above is, that it doesnt take current time into account.
 * Since the text is regarding when I need to order today to get at the next possible delivery time.
 *
 * @uses get_vendor_dates_new()
 * @param $days_array
 * @param $today
 * @return String
 */
function get_vendor_delivery_days_from_today_header_vendor($vendor_id, $prepend_text = '', $del_type = "1", $long_or_short_text = 0)
{
    // Get the vendors opening days the next 60 days
    $vendor_days = get_vendor_dates_new($vendor_id, 'd-m-Y', 'all', 60);
    $result = [];

    if(empty($vendor_days)){
        return "Næste mulige leveringsdato/-tidspunkt ukendt.";
    }

    $now = new DateTime();
    foreach ($vendor_days as $p => $c) {
        if(isset($c['cutoff_datetime'])
            && $c['cutoff_datetime'] !== false){

            $cutofftime = $c['cutoff_datetime'];
            $cutoff_time = DateTime::createFromFormat('d-m-Y H:i:s', $cutofftime, new DateTimeZone('UTC'));
            // Change the timezone to Copenhagen
            $cutoff_time->setTimezone(new DateTimeZone('Europe/Copenhagen'));

            if($cutoff_time > $now){
                $result = array(
                    'date' => $c['date'],
                    'cutoff_datetime' => $c['cutoff_datetime'],
                    'cutoff_time' => $c['cutoff_time'],
                    'type' => $c['type']
                );
                break; // Break out of the inner loop once a non-false 'cutoff_time' is found
            }
        }
    }

    if(empty($result)){
        return;
    } else {
        # Calculation of the cutoff time.
        $cutoff_datetime_obj = DateTime::createFromFormat('d-m-Y H:i:s', $result['cutoff_datetime'], new DateTimeZone('UTC'));
        $cutoff_weekday = rephraseWeekday( $cutoff_datetime_obj->format('N') );
        $cutoff_datetime = $cutoff_datetime_obj->format('\k\l\. H:i');

        # Calculation of the delivery time
        $date_str = $result['date'].' 00:00:00';
        $delivery_date_obj = DateTime::createFromFormat('d-m-Y H:i:s', $date_str, new DateTimeZone('UTC'));
        $delivery_date_weekday = rephraseWeekday( $delivery_date_obj->format('N'));
        $delivery_date_datetime = $delivery_date_obj->format('d/m');

        $str = '';
        if($del_type == "1"){
            $str .= 'levering';
        } else if($del_type == "0"){
            $str .= 'afsendelse';
        }

        return 'Bestil inden '.$cutoff_weekday.' '.$cutoff_datetime.' for '.$str.' '.$delivery_date_weekday;
    }
}

/**
 * Function for calculating when the order should be made - used on the header-vendor.php
 * The difference from the one above is, that it doesnt take current time into account.
 * Since the text is regarding when I need to order today to get at the next possible delivery time.
 *
 * @uses get_vendor_dates_new()
 * @param $days_array
 * @param $today
 * @return String
 */
function get_vendor_delivery_days_from_today_header_vendor_old($vendor_id, $prepend_text = '', $del_type = "1", $long_or_short_text = 0)
{
    // Set the timezone to Copenhagen
    #date_default_timezone_set('Europe/Copenhagen');

    $vendor_days = get_vendor_dates_new($vendor_id, 'd-m-Y', 'all', 60);
    $result = [];

    $now = new DateTime();

    #var_dump($vendor_days);

    foreach ($vendor_days as $p => $c) {
        if(isset($c['cutoff_datetime'])
            && $c['cutoff_datetime'] !== false){

            $cutofftime = $c['cutoff_datetime'];
            $cutoff_time = DateTime::createFromFormat('d-m-Y H:i:s', $cutofftime, new DateTimeZone('UTC'));
            // Change the timezone to Copenhagen
            $cutoff_time->setTimezone(new DateTimeZone('Europe/Copenhagen'));

            if($cutoff_time > $now){
                $result = array(
                    'date' => $c['date'],
                    'cutoff_datetime' => $c['cutoff_datetime'],
                    'cutoff_time' => $c['cutoff_time'],
                    'type' => $c['type']
                );
                break; // Break out of the inner loop once a non-false 'cutoff_time' is found
            }
        }
    }

    $date = '';
    $text = '';
    if(empty($result)){
        return;
    } else {
        // Create a fallback date object.
        // NOTE: Maybe we shouldnt add the '00:00:00'-part... Test it :-)
        $date_str = $result['date'].' 00:00:00';
        $date_obj =  DateTime::createFromFormat('d-m-Y H:i:s', $date_str, new DateTimeZone('UTC'));
        $date_obj->setTimezone(new DateTimeZone('Europe/Copenhagen'));
        #$date = $date_obj->format('d-m-Y'); // Construct from the date.

        // Subtract one day in order to calculate comparing to "when I need to order today" for next delivery slot.
        $subdate = $cutoff_time;
        $subnow = $now;
        if($subdate->format('H:i:s') < $subnow->format('H:i:s')){
            $date_obj->sub(new DateInterval('P1D'));
        }

        $str = '';
        if($del_type == "1"){
            $str .= 'Levere ';
        } else if($del_type == "0"){
            $str .= 'Afsende ';
        }
        if($long_or_short_text == 1){
            $str = "Butikken kan ".strtolower($str);
        } else if($long_or_short_text == 2){
            $str = '';
        }

        return $prepend_text . ' ' . strtolower($str . get_date_diff_text($date_obj));
        // There is a date. Let's populate the variables for the calculation.
    }
}




function get_del_days_text($opening, $del_type = '1', $long_or_short_text = 0){
    $open_iso_days = array();
    $open_label_days = array();
    foreach($opening as $k => $v){
        $open_iso_days[] = (int) $v['value'];
        $open_label_days[$v['value']] = $v['label'];
    }

    $str = '';
    $interv = array();
    if(!empty($open_iso_days) && is_array($open_iso_days)){
        $interv = build_intervals($open_iso_days, function($a, $b) { return ($b - $a) <= 1; }, function($a, $b) { return $a."..".$b; });
    } else {
        $str .= 'Leveringsdage er ukendte';
        if($long_or_short_text == 1){
            $str .= 'Butikkens '.strtolower($str);
        }
    }
    $i = 1;

    if(!empty($opening) && !empty($interv) && count($interv) > 0){
        if($del_type == "1"){
            $str .= 'Leverer ';
        } else if($del_type == "0"){
            $str .= 'Afsender ';
        }
        if($long_or_short_text == 1){
            $str = "Butikken ".strtolower($str);
        } else if($long_or_short_text == 2){
            $str = '';
        }

        foreach($interv as $v){
            $val = explode('..',$v);
            if(!empty($val)){
                $start = isset($open_label_days[$val[0]])? $open_label_days[$val[0]] : '';
                if($val[0] != $val[1])
                {
                    $end = isset($open_label_days[$val[1]]) ? $open_label_days[$val[1]] : '';
                    if(!empty($start) && !empty($end)){
                        $str .=  strtolower($start."-".$end);
                    }
                } else {
                    $str .=  strtolower($start);
                }
                if(count($interv) > 1){
                    if(count($interv)-1 == $i){ $str .=  " og "; }
                    else if(count($interv) > $i) { $str .=  ', ';}
                }
            }
            $i++;
        }
    }

    return $str;
}



function groupDates($input) {
    $arr = explode(",", $input);
    foreach($arr as $k => $v){
        $arr[$k] = strtotime(trim($v));
    }
    sort($arr);
    $expected = -1;
    foreach ($arr as $date) {
        if ($date == $expected) {
            array_splice($range, 1, 1, date("d-m-Y",$date));
        } else {
            unset($range);
            $range = [date("d-m-Y",$date)];
            $ranges[] = &$range;
        }
        $expected = strtotime(date("d-m-Y",$date) . ' + 1 day');
    }

    foreach ($ranges as $entry) {
        $result[] = $entry;
    }
    return $result;
}

/**
 *  Function for building the intervals of delivery days.
 *  E.g. "monday-friday & sunday" etc.
 * @param $items
 * @param $is_contiguous
 * @param $make_interval
 * @return array
 */
function build_intervals($items, $is_contiguous, $make_interval) {
    $intervals = array();
    $end   = false;
    if(is_array($items) || is_object($items)){
        foreach ($items as $item) {
            if (false === $end) {
                $begin = (int) $item;
                $end   = (int) $item;
                continue;
            }
            if ($is_contiguous($end, $item)) {
                $end = (int) $item;
                continue;
            }
            $intervals[] = $make_interval($begin, $end);
            $begin = (int) $item;
            $end   = (int) $item;
        }
    }
    if (false !== $end) {
        $intervals[] = $make_interval($begin, $end);
    }
    return $intervals;
}

/**
 * Function for getting text for delivery days until the vendor can delivery
 *
 * @param $vendor_id
 * @param $prepend_text
 * @param $html_container the HTML container to have around the delivery text. Placeholder is {placeholder}
 * @return array|mixed|string|string[]
 */
function get_vendor_delivery_date_text($vendor_id, $prepend_text = '', $html_container = ''){
    ///////////////////////////
    // Days until delivery
    $delivery_days 		= get_vendor_days_until_delivery($vendor_id);

    switch($delivery_days) {
        case 0:
            $text = 'i dag';
            break;
        case 1:
            $text = 'i morgen';
            break;
        case 2:
            $text = 'i overmorgen';
            break;
        default:
            $text = 'om '.$delivery_days.' dage';
            break;
    }

    if(!empty($html_container)) {
        $text = str_replace('{placeholder}', $text, $html_container);
    }

    $text = (empty($prepent_text) ? $text : $prepend_text.$text);
    return $text;
}

/**
 * Function for estimating the deliveryDate for a vendor from his opening days, closing days etc.
 *
 * @param $days
 * @param $cut_off
 * @param $iso_opening_days
 * @param $format
 * @return string
 * @throws Exception
 */
function estimateDeliveryDate($days = 1, $cut_off = 15, $iso_opening_days = array(1,2,3,4,5,6,7), $format = 'U')
{
    $iso_days = array(1,2,3,4,5,6,7);
    $iso_open_days = array();
    foreach($iso_opening_days as $k => $v){
        $iso_open_days[] = (int) $v['value'];
    }
    $close_days = array_diff($iso_days, $iso_open_days);

    $calc_days = 0;
    if(strpos($cut_off, '.') === false || strpos($cut_off,':') === false){
        if (date("H") <= $cut_off) {
            $calc_days = $days;
        } else {
            $calc_days = $days+1;
        }
    } else {
        if (date("H:i") <= $cut_off) {
            $calc_days = $days;
        } else {
            $calc_days = $days+1;
        }
    }

    $date_iso = date("N");

    $z = 0;
    for($i=$date_iso;$z<count($iso_days);$i++){
        if(in_array($i, $close_days)){
            $calc_days+=1;
        }

        if($i==7){
            $i = 1;
        }
        $z++;
    }

    $deliveryDate = new \DateTime("+".$calc_days." days");

    return $deliveryDate->format($format);
}

function get_vendor_dates_new($vendor_id, $date_format = 'd-m-Y', $open_close = 'close', $num_dates = 60)
{
    if(empty($vendor_id)){
        return false;
    }

    // Set the timezone to Copenhagen
    #date_default_timezone_set('Europe/Copenhagen');

    global $wpdb;


    // Explicitly set arrays used in the formula.
    $open_days_arr = array();
    $closed_days_arr = array();
    $dates = array();

    // Get the number of days required for delivery by the vendor
    // Days before, that an order should be places for the date types.
    $vendor_order_delivery_days_before = get_vendor_delivery_days_required($vendor_id);
    $vendor_order_delivery_days_before_weekend = get_vendor_delivery_days_required($vendor_id, 'weekend');
    $vendor_order_delivery_days_before_holiday = get_vendor_delivery_days_required($vendor_id, 'holiday');
    ## Todo here: We need to make this so it can handle the weekend days.
    // Get the number of days required for delivery by the vendor
    #$vendorDeliveryDayReq = get_vendor_delivery_days_required($vendor_id);
    #$vendorDeliveryDayRequiredCalculated = ($now->format('H:i') > $vendorDropOffTime) ? $vendorDeliveryDayReq+1 : $vendorDeliveryDayReq;
    #$closed_num = 0;

    // Get the time the store has chosen as their "cut-off" / drop-off for next order.
    $vendor_dropoff_time = get_vendor_dropoff_time($vendor_id);
    $vendor_dropoff_time_weekend = get_vendor_dropoff_time($vendor_id, 'weekend');
    $vendor_dropoff_time_holiday = get_vendor_dropoff_time($vendor_id, 'holiday');

    // @todo - Dennis update according to latest updates in closing day-field.
    // open close days begin. Generate an array of all days ISO.
    $default_days = ['1','2','3','4','5','6','7'];

    // Get the opening days string/array from the database and handle it.

    $opening_days = !empty(get_user_meta($vendor_id, 'openning')) ? get_user_meta($vendor_id, 'openning', true) : get_field('openning', 'user_'.$vendor_id); // true for not array return
    $closed_days = (is_array($opening_days) ? array_diff($default_days, $opening_days) : array());

    if(empty($opening_days)){
        // If the opening days variable doesnt have a value, just return.
        return;
    }

    // Get the global dates.
    // Global dates is defined by Greeting - and it is defining close days and "holidays"
    $global_closed_dates = get_global_days('closed');//array( '24-12-2023', '25-12-2023', '31-12-2022', '01-01-2023', '05-05-2023', '18-05-2023', '29-05-2023');
    $global_holidays = get_global_days('holidays');

    // Explicitly set todays timezone and date, since there is some problems with this if not set explicitly.
    // Define today's timezone and date.
    $timezone = new DateTimeZone('Europe/Copenhagen');
    $today = new DateTime('now', $timezone); # $today is used for incrementing in the for loop.
    $now = new DateTime('now', $timezone); # $now is used for getting the time right now.

    // Get the explicitly defined closed DATES from admin (e.g. if one store is closed on a specific date)
    // Loop through the closed dates from admin.
    // The $closed_days_date array gets exploded, and then array_filter applied to make sure no empty items is left in the array.
    $closed_dates_arr = get_vendor_closed_dates($vendor_id);

    // Get the explicitly set opening days.
    $open_days_extraordinary = get_vendor_delivery_dates_extraordinary($vendor_id);

    // If $num_dates is greater than 180, then we set it to 180 due to minimizing the load.
    $num_dates = ($num_dates > 180) ? 180 : $num_dates;

    for($i=0;$i<$num_dates;$i++){
        $datekey = $today->format('dmY');
        $date = $today->format($date_format);
        $date_weekday = $today->format('N');

        $is_open = true; // true or false - is this date open at the time?
        $is_closed = !$is_open; // true or false - is this date closed at the time? Will always be the opposite of $is_open
        $is_open_extraordinary_day = in_array($today->format('d-m-Y'), $open_days_extraordinary) ? true : false; // true or false
        $is_closed_date = in_array($today->format('d-m-Y'), $closed_dates_arr);
        $is_open_day_weekdays = in_array($today->format('N'), $opening_days) ? true : false;
        $is_holiday = in_array($date, $global_holidays) ? true : false;
        $is_global_closed_date = in_array($date, $global_closed_dates) ? true : false;

        $type = 'weekday';
        if ($date_weekday >= 1 && $date_weekday <= 5) {
            $type = 'weekday';
        } elseif ($date_weekday >= 6 && $date_weekday <= 7) {
            $type = 'weekend';
        }
        $type = in_array($today->format('d-m-Y'), $global_holidays) ? 'holiday' : $type;

        switch ($type) {
            case 'weekend':
                $cutoff = $vendor_dropoff_time_weekend;
                break;
            case 'holiday':
                $cutoff = $vendor_dropoff_time_holiday;
                break;
            default:
                $cutoff = $vendor_dropoff_time;
                break;
        }
        #var_dump($cutoff);

        // Calculation of the specific cutoff time for this date.
        # @todo - Make the calculation
        $cutoff_datetime = new DateTime($today->format('d-m-Y '.$cutoff), $timezone);
        if($type == 'weekday'){
            $cutoff_datetime->modify('-'.$vendor_order_delivery_days_before.' day');
        } else if($type == 'weekend'){
            $cutoff_datetime->modify('-'.$vendor_order_delivery_days_before_weekend.' day');
        } else if($type == 'holiday'){
            $cutoff_datetime->modify('-'.$vendor_order_delivery_days_before_holiday.' day');
        }

        if($now->format('H:i') > $cutoff
            && $now->format('d-m-Y') == $today->format('d-m-Y')){
            $cutoff_datetime->modify('-1 day');
        }

        if(
            (!in_array($date_weekday, $opening_days)
                && !in_array($today->format('d-m-Y'), $open_days_extraordinary))
            ||
            (in_array($today->format('d-m-Y'), $closed_dates_arr)
                && !in_array($today->format('d-m-Y'), $open_days_extraordinary))
        ){

            $cutoff_datetime_val = false;
            $is_open = false;
        } else {
            $cutoff_datetime_val = $cutoff_datetime->format('d-m-Y H:i:s');
        }

        $dates[$datekey] = array(
            'date' => $date,
            'cutoff_datetime' => $cutoff_datetime_val, // the exact time you can order for this date.
            'cutoff_time' => $cutoff, // the value from the cutoff field based on the type of the date
            'is_open' => $is_open, // true or false - is this date closed at the time?
            'is_closed' => !$is_open, // true or false - is this date open at the time?
            'is_open_day_weekdays' => $is_open_day_weekdays,
            'is_closed_date' => $is_closed_date,
            'type' => $type,
            'is_extraordinary_date' => $is_open_extraordinary_day,
            'is_global_closed_date' => $is_global_closed_date,
            'is_holiday' => $is_holiday
        );

        // Last action, add 1 day.
        $today->modify('+1 day');
    }

    if($open_close === "all"){
        return $dates;
    }

    foreach ($dates as $key => $value) {
        $cutoffDatetime_static = $value['cutoff_datetime'];
        $date = DateTime::createFromFormat('d-m-Y', $value['date']);

        if($value['is_global_closed_date'] === true){
            $closed_days_arr[$key] = $date->format('d-m-Y');
            continue;
        }

        if ($cutoffDatetime_static) {

            $cutoffDatetime = DateTime::createFromFormat('d-m-Y H:i:s', $cutoffDatetime_static);

            if ($cutoffDatetime >= $now) {
                $open_days_arr[$key] = $date->format('d-m-Y');
            } else {
                $closed_days_arr[$key] = $date->format('d-m-Y');
            }
        } else {
            $closed_days_arr[$key] = $date->format('d-m-Y');
        }
    }

    #return $dates;
    // Return either the closed days or the open days, depending on the $open_close parameter.
    return $open_close == 'close' ? $closed_days_arr : $open_days_arr;
}



###########################################
## *** *** *** ***
## POSSIBLY DEPRECATED FUNCTIONS BELOW
##
##
##
##


/**
 * Function to get all closed dates calculated
 * from opening days, closed dates etc.
 *
 * @author Dennis
 */
function get_vendor_dates($vendor_id, $date_format = 'd-m-Y', $open_close = 'close'){
    global $wpdb;

    #var_dump(get_field('vendor_require_order_days_before','user_'.$vendor_id));
    #var_dump(get_vendor_dates_new($vendor_id, $date_format, $open_close, 60));

    // Explicitly set arrays used in the formula.
    $open_days = array();
    $closed_days = array();
    $dates = array();

    // Get the time the store has chosen as their "cut-off" / drop-off for next order.
    $vendorDropOffTime = get_vendor_dropoff_time($vendor_id);
    #$vendorDropOffTimeWeekend = get_vendor_dropoff_time($vendor_id, 'weekend');

    // Get the number of days required for delivery by the vendor
    $vendorDeliveryDayReq = get_vendor_delivery_days_required($vendor_id);

    // @todo - Dennis update according to latest updates in closing day-field.
    // open close days begin. Generate an array of all days ISO.
    $default_days = ['1','2','3','4','5','6','7'];

    // Get the opening days string/array from the database and handle it.
    $opening_days = get_user_meta($vendor_id, 'openning', true); // true for not array return
    $closed_days = (is_array($opening_days) ? array_diff($default_days, $opening_days) : $closed_days);

    // Global closed dates (when Greeting.dk is totally closed).
    $global_closed_dates = array( '24-12-2023', '25-12-2023', '31-12-2022', '01-01-2023', '05-05-2023', '18-05-2023', '29-05-2023');

    // Explicitly set todays timezone and date, since there is some problems with this if not set explicitly.
    // Define today's timezone and date.
    $timezone = new DateTimeZone('Europe/Copenhagen');
    $today = new DateTime('now', $timezone); # $today is used for incrementing in the for loop.
    $now = new DateTime('now', $timezone); # $now is used for getting the time right now.

    // Get the explicitly defined closed DATES from admin (e.g. if one store is closed on a specific date)
    // Loop through the closed dates from admin.
    // The $closed_days_date array gets exploded, and then array_filter applied to make sure no empty items is left in the array.
    $closed_days_date = get_vendor_closed_dates($vendor_id);
    $closed_dates_arr = array();

    // Loop through the closed dates string from admin (exploded above)
    // Check if it is larger than today, if so then add to array of closed dates.
    if(!empty($closed_days_date)){
        foreach($closed_days_date as $ok_date){
            $the_date = trim($ok_date);
            $the_date = (strpos($the_date, ' ') == true) ? strstr($the_date, ' ', true) : $the_date;
            $date_time_object = new DateTime($the_date);
            if($date_time_object > $today){
                $closed_dates_arr[] = $date_time_object->format($date_format);
            }
        }
    }

    // Generate array of all open days for the next 60 days.
    ## Todo here: We need to make this so it can handle the weekend days.
    $vendorDeliveryDayRequiredCalculated = ($now->format('H:i') > $vendorDropOffTime) ? $vendorDeliveryDayReq+1 : $vendorDeliveryDayReq;
    $closed_num = 0;

    for($i=0;$i<60;$i++){
        if(in_array($today->format('N'), $closed_days)){
            // If the date is a day of the week, where the store is not opened, then...
            // @todo eliminate deliveryday requirement.
            $closed_days_date[] = $today->format($date_format);
            $closed_num++;
        } else if(in_array($today->format($date_format), $closed_dates_arr)){
            // If the date is explicitly closed in the admin closed dates array
            $closed_days_date[] = $today->format($date_format);
            $closed_num++;
        } else if(in_array($today->format($date_format), $global_closed_dates)) {
            // If the date is one of the globally closed dates, then...
            $closed_days_date[] = $today->format($date_format);
            $closed_num++;
        } else {
            if($i >= $vendorDeliveryDayRequiredCalculated){
                // The date is open, since it is later than the required dates.
                $dates[] = $today->format($date_format);
            } else {
                $closed_days_date[] = $today->format($date_format);
            }
        }

        $today->modify('+1 day');
    }

    // Return either the closed days or the open days, depending on the $open_close parameter.
    return $open_close == 'close' ? $closed_days_date : $dates;
}

function greeting_generate_filtering_days() {
    $dates = array();
    setlocale(LC_TIME, 'da_DK.UTF-8'); // Set the locale to Danish
    $date_today = new DateTime('now');

    // Get POST variables
    $greeting_dot = isset($_POST['greeting_dot']) ? sanitize_text_field($_POST['greeting_dot']) : '0';
    $greeting_dot_key = isset($_POST['greeting_dot_key']) ? sanitize_text_field($_POST['greeting_dot_key']) : '';
    $greeting_dot_hash = md5("gre_et_i_ng21p412421" . $greeting_dot);

    // Validate that the input is numeric and within the hour range
    if (is_numeric($greeting_dot)) {
        $greeting_dot = intval($greeting_dot); // Convert to integer
        if ($greeting_dot < 0 || $greeting_dot > 24) {
            $greeting_dot = 0; // Default to 0 if out of range
        }
    } else {
        $greeting_dot = 0; // Default to 0 if not numeric
    }


    if($greeting_dot_key !== $greeting_dot_hash){
        // Return JSON response indicating failure
        wp_send_json(array('success' => false, 'message' => 'Invalid hash or key. '.$greeting_dot.'    Key: '.$greeting_dot_key.'    Hash: '.$greeting_dot_hash));
    }

    $danish_month_names = array(
        'jan' => 'jan', 'feb' => 'feb', 'mar' => 'mar', 'apr' => 'apr',
        'may' => 'maj', 'jun' => 'jun', 'jul' => 'jul', 'aug' => 'aug',
        'sep' => 'sep', 'oct' => 'okt', 'nov' => 'nov', 'dec' => 'dec'
    );

    // Generate dates for the next 7 days
    for ($i = 0; $i < 9; $i++) {
        $closed_for_today = 0;
        $greeting_dot = isset($_POST['greeting_dot']) ? sanitize_text_field($_POST['greeting_dot']) : '0';
        if($i == 0 && $greeting_dot <= date("H")){
            $closed_for_today = 1;
        }

        $formatted_date = strtolower($date_today->format('d. M'));
        $month_abbr = strtolower($date_today->format('M'));
        $formatted_date = str_replace($month_abbr, $danish_month_names[$month_abbr], $formatted_date);
        $dates[] = array('formatted' => $formatted_date, 'date' => $date_today->format('Y-m-d'), 'closed_for_today' => $closed_for_today);
        $date_today->modify('+1 day');
    }

    // Add "Show all" option
    $dates[] = array('formatted' => 'Vis alle (inkl. senere) datoer', 'date' => 'all');

    // Send the response as JSON
    wp_send_json(array('dates' => $dates));
}
add_action('wp_ajax_get_filtering_days', 'greeting_generate_filtering_days');
add_action('wp_ajax_nopriv_get_filtering_days', 'greeting_generate_filtering_days');