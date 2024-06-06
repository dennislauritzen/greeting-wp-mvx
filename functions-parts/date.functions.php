<?php


/**
 * Function for validation a date has the correct format
 *
 * @param $date
 * @param $format
 * @return bool
 */
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}


/**
 * Function for calculating the day difference from today to a date.
 *
 * @param $date
 * @return string|void
 * @throws Exception
 */
function get_date_diff_text($date){
    if(!($date instanceof DateTime)){
        return;
    }

    $today = new DateTime('today');
    $date = new DateTime($date->format('Y-m-d')); // Extracting only the date portion

    $date_diff = $today->diff($date);

    $diff_days = $date_diff->format('%R%a'); // Convert to integer
var_dump($date);
var_dump($today);
var_dump($date_diff);
    if($diff_days == '0' || $diff_days == '+0'){
        return 'i dag';
    } else if($diff_days == '1' || $diff_days == '+1'){
        return 'i morgen';
    } else if($diff_days == '2' || $diff_days == '+2'){
        return 'i overmorgen';
    } else {
        return 'om '.$date_diff->format('%a').' dage';
    }
}


/**
 * Function for rephrashing a month to danish
 *
 * @param $month
 * @return string
 */
function rephraseMonth($month){
    $months = ['januar', 'februar', 'marts', 'april', 'maj', 'juni', 'juli', 'august', 'september', 'oktober', 'november', 'december'];

    return $months[$month-1];
}

/**
 * Function for rephrasing a date to danish.
 *
 * @param $weekday
 * @param $date
 * @param $month
 * @param $year
 * @return string
 */
function rephraseDate($weekday, $date, $month, $year) {
    $weekdays = ['mandag', 'tirsdag', 'onsdag', 'torsdag', 'fredag', 'lørdag', 'søndag'];
    $months = ['januar', 'februar', 'marts', 'april', 'maj', 'juni', 'juli', 'august', 'september', 'oktober', 'november', 'december'];

    $weekday_str = $weekdays[$weekday - 1];
    $month_str = $months[$month - 1];
    $year_str = ($year != date("Y") ? $year : '');

    return $weekday_str." d. ".$date.". ".$month_str. " ". $year_str;
}