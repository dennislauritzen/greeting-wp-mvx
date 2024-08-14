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
}

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
    var servertime_field = document.getElementById('server_date_time').value;
    var serverTime = new Date(servertime_field);

    $('#datepicker').click(function() {
        var vendorClosedDayArray = vendorClosedDayArray_str_input.value;

        jQuery('#datepicker').datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: new Date(),
            maxDate: "+58D",
            beforeShowDay: function(date){
                var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
                return [ vendorClosedDayArray.indexOf(string) == -1 ];
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


document.addEventListener('DOMContentLoaded', function() {
    var greeting_key = document.getElementById('greeting_post_key_prodvend').value;
    var vendor_id = document.getElementById('vendor_id').value;

    // Prepare the data as URL-encoded form data
    const postData = new URLSearchParams({
        vendor_id: vendor_id,
        greeting_key: greeting_key
    });

    fetch('/wp-admin/admin-ajax.php?action=get_vendor_closed_days', {
        method: 'POST',
        credentials: 'same-origin', // Ensure cookies are sent along with the request,
        body: postData,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded' // Set the content type to URL-encoded
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data && typeof data === 'object') {
                // Extract the values from the object into an array
                const dateArray = Object.values(data);

                // Convert the array to a JSON string
                const jsonArrayString = JSON.stringify(dateArray);

                // Insert the JSON array string into the hidden input field
                document.getElementById('vendor_closed_date_array').value = jsonArrayString;

                // For debugging: Output to console to verify the format
                //console.log(jsonArrayString);
            } else {
                console.error('Invalid data format:', data);
            }
        })
        .catch(error => console.error('Error fetching dates:', error));

});
