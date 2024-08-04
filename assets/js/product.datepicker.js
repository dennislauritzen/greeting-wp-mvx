(function($) {
    $.datepicker.regional['da'] = {
        closeText: 'Luk',
        prevText: '&#x3C;Forrige',
        nextText: 'Næste&#x3E;',
        currentText: 'I dag',
        monthNames: ['Januar','Februar','Marts','April','Maj','Juni',
            'Juli','August','September','Oktober','November','December'],
        monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
            'Jul','Aug','Sep','Okt','Nov','Dec'],
        dayNames: ['Søndag','Mandag','Tirsdag','Onsdag','Torsdag','Fredag','Lørdag'],
        dayNamesShort: ['Søn','Man','Tir','Ons','Tor','Fre','Lør'],
        dayNamesMin: ['Sø','Ma','Ti','On','To','Fr','Lø'],
        weekHeader: 'Uge',
        dateFormat: 'dd-mm-yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['da']);
})(jQuery);

// Validates that the input string is a valid date formatted as "mm/dd/yyyy"
function isValidDate(dateString)
{
    // First check for the pattern
    if(!/^\d{1,2}\-\d{1,2}\-\d{4}$/.test(dateString))
        return false;

    // Parse the date parts to integers
    var parts = dateString.split("-");
    var day = parseInt(parts[0], 10);
    var month = parseInt(parts[1], 10);
    var year = parseInt(parts[2], 10);

    // Check the ranges of month and year
    if(year < 1000 || year > 3000 || month == 0 || month > 12)
        return false;

    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    // Adjust for leap years
    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
        monthLength[1] = 29;

    // Check the range of the day
    return day > 0 && day <= monthLength[month - 1];
};

jQuery(document).ready(function($) {
    // GET THE CUTOFF DAYS / EXTRA DAYS NEEDED
    //var vendorCutoffDays = <?php echo get_vendor_delivery_days_required($vendor_id); ?>;
    var vendorCutoffDays = document.getElementById('vendor_cutoff_days').value;

    // GET THE CUTOFF TIME
    //var vendorCutoffTime = '<?php echo get_vendor_dropoff_time($vendor_id); ?>';
    var vendorCutoffTime = document.getElementById('vendor_cutoff_time').value;

    // GET THE CLOSED DAYS ARRAY
    //var vendorClosedDayArray = <?php echo $dates_json; ?>;
    var vendorClosedDayArray_str_input = document.getElementById('vendor_closed_date_array');
    // Retrieve the JSON string from the hidden input field's value
    const datesJsonString = vendorClosedDayArray_str_input.value;
    // Parse the JSON string to get the array of dates
    const vendorClosedDayArray = JSON.parse(datesJsonString);

    // The server time
    var serverTime = new Date('<?php echo $server_time_string; ?>');

    $('#datepicker').click(function() {
        // Extract hours and minutes from the cutoff time
        var [hours, minutes, seconds] = vendorCutoffTime.split(':').map(Number);

        // Create a cutoff datetime for the current date
        var cutoffDateTime = new Date();
        cutoffDateTime.setDate(cutoffDateTime.getDate() + vendorCutoffDays);
        cutoffDateTime.setHours(hours, minutes, seconds);
        // Extract hours, minutes, and seconds
        var co_timeString = ('0' + hours).slice(-2) + ':' + ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);

        // Function to format date as "DD-MM-YYYY"
        function formatDate(date) {
            return ('0' + date.getDate()).slice(-2) + '-' +
                ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
                date.getFullYear();
        }

        function timeStringToDate(timeString) {
            // Create a Date object with a fixed date (e.g., 1970-01-01) and the given time
            var date = new Date('1970-01-01T' + timeString + 'Z');
            return date;
        }

        function compareTimes(time1, time2) {
            var date1 = timeStringToDate(time1);
            var date2 = timeStringToDate(time2);

            if (date1 > date2) {
                return 1; // time1 is later than time2
            } else if (date1 < date2) {
                return -1; // time1 is earlier than time2
            } else {
                return 0; // time1 is equal to time2
            }
        }

        // Function to update vendorClosedDayArray based on cutoff
        function updateClosedDaysArray(cutoffDays, cutoffDateTime, closedDayArray) {
            var adjustedDates = new Set(closedDayArray); // Use a Set for unique dates

            // Loop through the next (cutoffDays + 2) days
            for (var i = 0; i <= (cutoffDays + 2); i++) {
                var dateToCheck = new Date();
                dateToCheck.setDate(dateToCheck.getDate() + i);
                var dateToCheckOnlyDate = dateToCheck.getDate();

                // Handle the case where dateToCheck is the same as the cutoff date
                if (dateToCheckOnlyDate === cutoffDateTime.getDate()) {
                    // Check if the current time has passed the cut
                    // off time on the same day
                    var currentTime = new Date();
                    // Extract hours, minutes, and seconds
                    var hours = currentTime.getHours();
                    var minutes = currentTime.getMinutes();
                    var seconds = currentTime.getSeconds();
                    var timeString = ('0' + hours).slice(-2) + ':' + ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);
                    var compareTimeStrings = compareTimes(timeString, co_timeString);

                    if (compareTimeStrings == 1) {
                        adjustedDates.add(formatDate(dateToCheck));
                    }
                } else if (dateToCheck < cutoffDateTime) {
                    var formattedDate = formatDate(dateToCheck);
                    adjustedDates.add(formattedDate);
                }
            }

            return Array.from(adjustedDates); // Convert Set back to array
        }

        // Update closed days array
        var updatedClosedDaysArray = updateClosedDaysArray(vendorCutoffDays, cutoffDateTime, vendorClosedDayArray);

        jQuery('#datepicker').datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: new Date(),
            maxDate: "+58D",
            beforeShowDay: function(date){
                var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
                return [ updatedClosedDaysArray.indexOf(string) == -1 ];
            },
            onClose: function(date, datepicker){
                const par_elm = jQuery(this).closest('.form-row');

                if (!isValidDate(date) || date == '') {
                    par_elm.addClass('has-error');
                } else {
                    par_elm.removeClass('has-error').addClass('woocommerce-validated');
                    jQuery("#datepicker_field label.error").css('display','none');
                }
            },
            errorPlacement: function(error, element) { }
        }).datepicker( "show" );
        jQuery(".ui-datepicker").addClass('notranslate').css('z-index', 99999999999999);
    });
});