<?php


/**
 * Set Cache Headers for frontpage
 *
 * @access public
 */
function greeting_set_frontpage_custom_headers(){
    if(is_front_page()) {
        header("Cache-Tag: Frontpage,TextPage");
    }
}
add_action('template_redirect', 'greeting_set_frontpage_custom_headers');

/**
 * Set Cache Headers for pages
 *
 * @access public
 */
function greeting_set_textpage_custom_headers(){
    if(is_page() && !is_cart() && !is_checkout()) {
        header("Cache-Tag: TextPage");
    }
}
add_action('template_redirect', 'greeting_set_textpage_custom_headers');


/**** Remove Suborder from coustomer my-account page *****/
add_filter( 'woocommerce_account_orders_columns' , function( $suborders ) {
    unset( $suborders['mvx_suborder'] );
    return $suborders;
} , 999 );

/**
 * Function for generating breadcrumbs.
 * Has to be called on the template pages (not called automatically).
 * @used on landing pages
 *
 * @author Dennis Lauritzen
 */
/**
 * Generate breadcrumbs
 * @author CodexWorld
 * @authorURL www.codexworld.com
 */
function get_breadcrumb() {
    echo '<a href="'.home_url().'" rel="nofollow" style="color: #777777;">Forside</a>';
    if (is_category() || is_single()) {
        echo "&nbsp;/&nbsp;";
        the_category(' &bull; ');
        if (is_single()) {
            echo " &nbsp;/&nbsp; ";
            the_title();
        }
    } elseif (is_page()) {
        echo "&nbsp;/&nbsp;";
        echo the_title();
    } elseif (is_search()) {
        echo "&nbsp;/&nbsp; Search Results for... ";
        echo '"<em>';
        echo the_search_query();
        echo '</em>"';
    }
}

function ajax_fetch() { ?>
    <script type="text/javascript">
        /** function for delaying ajax input**/
        function delay(ms, callback) {
            var timer = 0;
            return function() {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }

        jQuery(document).ready(function(){
            var currentRequest = null;

            jQuery("#searchform").submit(function(event){
                event.preventDefault();
                var hid_pc_link = '';
                if(document.getElementById('hidden__s_link')){
                    hid_pc_link = document.getElementById('hidden__s_link').value;
                }
                var val = jQuery("#datafetch_wrapper li.recomms:first-child a").prop('href');
                var location;

                if(hid_pc_link) {
                    location = hid_pc_link;
                }
                if(val){
                    location = val;
                }
                if(location.length){
                    window.location.href = location;
                }
                return false;
            });

            function doSearch($searchInput, $dataFetchWrapper, url, action) {
                var xhr; // declare the xhr variable outside the AJAX function

                $searchInput.keyup(delay(400, function (e) {
                    var text = jQuery(this).val();

                    if (xhr) {
                        xhr.abort(); // abort the previous request if it's still in progress
                    }

                    xhr = jQuery.ajax({
                        url: url,
                        type: 'post',
                        data: { action: action, keyword: text },
                        beforeSend: function(){
                            if(currentRequest != null){

                                currentRequest.abort();
                            }
                        },
                        success: function(data) {

                            $dataFetchWrapper.data('loading','0');

                            $dataFetchWrapper.html(data);

                            if(text !== '' || !text){
                                $dataFetchWrapper.removeClass('d-none').addClass('d-inline');
                            } else {
                                $dataFetchWrapper.addClass('d-none').removeClass('d-inline');
                            }

                        }
                    }).fail(function(){
                        $dataFetchWrapper.addClass('d-none').removeClass('d-inline');
                    });
                }));

                $searchInput.on("input", function(){
                    var text = jQuery(this).val();
                    var str_text = "Søger efter by/postnummer der matcher '"+text+"'...";
                    var loading = $dataFetchWrapper.data('loading');

                    if (xhr) {
                        xhr.abort(); // abort the previous request if it's still in progress
                    }

                    if(loading !== '1'){
                        if(text.length > 0){
                            $dataFetchWrapper.html('');
                            var $loadingElm = jQuery("<li>", {"class": "recomms list-group-item py-2 px-1 bg-white"});
                            var $div = jQuery('<div/>');
                            var $loader = jQuery('<div/>').addClass('greeting-loader float-start d-block pe-1 align-middle').removeClass('d-none');
                            var $loaderDiv = $div.clone().addClass('ms-2 align-middle').html($loader);
                            var $textElm = jQuery('<span/>').addClass('loadingText').text(str_text);
                            var $textDiv = $div.clone().addClass('loaderText').html($textElm);

                            $dataFetchWrapper.removeClass('d-none').addClass('d-inline');
                            $dataFetchWrapper.html($loadingElm.append($loaderDiv, $textDiv));
                        }
                    } else {
                        $dataFetchWrapper.find('span.loadingText').text(str_text);
                    }

                    search_input_val = text;
                    $dataFetchWrapper.data('loading', '1');
                });
            }

            // Call the function for the first search input
            doSearch(jQuery('#front_Search-new_ucsa'), jQuery('#datafetch_wrapper'), '<?php echo admin_url('admin-ajax.php'); ?>', 'data_fetch');

            // Call the function for the second search input
            doSearch(jQuery('.pc-form-content #front_Search-new_ucsa2'), jQuery('.pc-form-content #lp-datafetch_wrapper'), '<?php echo admin_url('admin-ajax.php'); ?>', 'catocca_landing_data_fetch');

        }); // jquery ready
    </script>
    <?php
}
add_action( 'wp_footer', 'ajax_fetch' );


function data_fetch(){
    $search_query = esc_attr( $_POST['keyword'] );
    global $wpdb;

    $prepared_statement = $wpdb->prepare("
		SELECT *
		FROM {$wpdb->prefix}posts
		WHERE post_title LIKE %s
		AND post_type = 'city'
		LIMIT 5", '%'.trim($search_query).'%');
    $landing_page_query = $wpdb->get_results($prepared_statement, OBJECT);

    if (!empty($landing_page_query)) {
        $array_count = count($landing_page_query);
        $i = 0;

        foreach ($landing_page_query as $key => $landing_page) {
            ?>
            <li class="recomms list-group-item py-2 px-4 <?php echo ($key==0) ? 'active' : '';?>" aria-current="true">
                <a href="<?php print get_permalink( $landing_page->ID ) ;?>" class="recomms-link text-teal stretched-link"><?php echo ucfirst($landing_page->post_title);?></a>
            </li>
        <?php } ?>
        <?php
        // If there is no match for the city, then do this...
    } else {?>
        <li class="list-group-item py-2 px-4" aria-current="true">
            Der blev desværre ikke fundet nogle byer, der matcher søgekriterierne
        </li>
    <?php }
    die();
}
add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');