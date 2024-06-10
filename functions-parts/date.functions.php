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
 * @param DateTime|string $date
 * @return string|void
 * @throws Exception
 */
function get_date_diff_text($date){
    // Set the timezone to Copenhagen
    #date_default_timezone_set('Europe/Copenhagen');

    // Ensure $date is a DateTime object
    if(!($date instanceof DateTime)){
        try {
            $date = new DateTime($date);
        } catch (Exception $e) {
            return;
        }
    }

    $today = new DateTime('today');
    $today->setTime(0,0,0);
    //$date_only = new DateTime($date->format('Y-m-d')); // Extracting only the date portion

    $date_diff = $today->diff($date);
    $diff_days = (int) $date_diff->format('%R%a'); // Convert to integer

    #var_dump($date);
    #var_dump($today);
    #var_dump($date_diff);
    #var_dump($diff_days);

    if($diff_days == 0){
        return 'i dag';
    } else if($diff_days == 1){
        return 'i morgen';
    } else if($diff_days == 2){
        return 'i overmorgen';
    } else {
        return 'om ' . ($diff_days) . ' dage';
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