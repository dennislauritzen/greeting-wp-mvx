<?php
#print microtime(true)*1000 . "<br>";
/**
 *
 * @author Dennis Lauritzen
 * Perform start setup
 *
**/
global $woocommerce, $wpdb;

// Get the ID of the city
$postId = get_the_ID();

// Get the permalink of the city
$city_page_permalink = get_permalink();

// Get the city name and the postalcode of the city.
$cityPostalcode = get_post_meta($postId, 'postalcode', true);
$cityName = get_post_meta($postId, 'city', true);

$checkout_postalcode = WC()->customer->get_shipping_postcode();
if($cityPostalcode != $checkout_postalcode){
  #print 'postnumre afviger';
  $woocommerce->cart->empty_cart();
}

// Get header designs.
get_header();
get_header('green', array('city' => $cityName, 'postalcode' => $cityPostalcode));

 ?>

<main id="main" class="container"<?php if ( isset( $navbar_position ) && 'fixed_top' === $navbar_position ) : echo ' style="padding-top: 100px;"'; elseif ( isset( $navbar_position ) && 'fixed_bottom' === $navbar_position ) : echo ' style="padding-bottom: 100px;"'; endif; ?>>
<?php



// get user meta query
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
          umm2.meta_value DESC
        	";
$vendor_query = $wpdb->prepare($sql, '%'.$cityPostalcode.'%', '%dc_vendor%');
$vendor_arr = $wpdb->get_results($vendor_query);


$UserIdArrayForCityPostalcode = array();
$DropOffTimes = array();
foreach($vendor_arr as $v){
  if(isset($v->data)){
    $UserIdArrayForCityPostalcode[] = $v->data->ID;
    $days = $v->data->require_delivery_day;
    $hours = $v->data->dropoff_time;
    if($days == 0){
      $DropOffTimes[] = (int) strstr($hours,':',true);
    }
  } else {
    $UserIdArrayForCityPostalcode[] = $v->ID;
    $days = $v->require_delivery_day;
    $hours = $v->dropoff_time;
    if($days == 0){
      $DropOffTimes[] = (int) strstr($hours,':',true);
    }
  }
}

// The maximum dropoff time today - for filtering.
$DropOffTimes = (count($DropOffTimes) > 0) ? max($DropOffTimes) : 0;

// pass to backend
$cityDefaultUserIdAsString = implode(",", $UserIdArrayForCityPostalcode);

/////////////////////////
// Data for the filtering.
// This data is used for the filters and for the stores.
// It is also used for the featuring of categories and occasions in the top.

$productPriceArray = array(); // for price filter
$categoryTermListArray = array(); // for cat term filter
$occasionTermListArray = array();

// for price filter

// Get all vendor product IDs
$vendorProductIds = array();

foreach ($UserIdArrayForCityPostalcode as $vendorId) {
    $vendor = get_mvx_vendor($vendorId);
    $vendorProductIds = array_merge($vendorProductIds, $vendor->get_products(array('fields' => 'ids')));
}
$vendorProductIds = array_unique($vendorProductIds);

// Use get_the_terms to fetch all the terms for all products belonging to the vendors
$terms = wp_get_object_terms($vendorProductIds, array('product_cat', 'occasion'));

$categoryTermListArray = array();
$occasionTermListArray = array();

if ($terms && !is_wp_error($terms)) {
    foreach ($terms as $term) {
        if ($term->taxonomy === 'product_cat') {
            if ($term->term_id != 15 && $term->term_id != 16) {
                $categoryTermListArray[] = $term->term_id;
            }
        } else if ($term->taxonomy === 'occasion') {
            $occasionTermListArray[] = $term->term_id;
        }
    }
}

$categoryTermListArray = array_unique($categoryTermListArray);
$occasionTermListArray = array_unique($occasionTermListArray);
?>


<script type="text/javascript">
function addToLocalStorage(key, val) {
  window.localStorage.setItem(key, val);
}
document.addEventListener("DOMContentLoaded", function() {
  addToLocalStorage('city_link', window.location.href);
  addToLocalStorage('city', '<?php echo $cityName; ?>');
  addToLocalStorage('postalcode', '<?php echo $cityPostalcode; ?>');
});
</script>

<input type="hidden" id="cityDefaultUserIdAsString" value="<?php echo $cityDefaultUserIdAsString;?>">
<input type="hidden" id="postalCode" value="<?php echo $cityPostalcode; ?>">
<input type="hidden" id="cityName" value="<?php echo $cityName; ?>">
<section id="citycontent" class="row">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1 class="d-block my-0 my-xs-3 my-sm-2 my-md-2 mt-3 mt-lg-4 pt-lg-1 mb-lg-3">
            Find butikker med gavehilsner i
            <span class="cityname"><?php the_title();?></span>
        </h1>
      </div>
    </div>

    <?php
    // get user meta query
    $occasion_featured_list = $wpdb->get_results( "
    SELECT
      tt.term_id as term_id,
      tt.taxonomy,
        t.name,
      t.slug,
      (SELECT tm.meta_value FROM {$wpdb->prefix}termmeta tm WHERE tm.term_id = tt.term_id AND tm.meta_key = 'featured') as featured,
      (SELECT tm.meta_value FROM {$wpdb->prefix}termmeta tm WHERE tm.term_id = tt.term_id AND tm.meta_key = 'featured_image') as image_src,
      (SELECT tm.meta_value FROM {$wpdb->prefix}termmeta tm WHERE tm.term_id = tt.term_id AND tm.meta_key = 'featured_icon') as icon_src,
      (SELECT tm.meta_value FROM {$wpdb->prefix}termmeta tm WHERE tm.term_id = tt.term_id AND tm.meta_key = 'featured_bg_color') as featured_bg_color,
      (SELECT tm.meta_value FROM {$wpdb->prefix}termmeta tm WHERE tm.term_id = tt.term_id AND tm.meta_key = 'featured_text_color') as featured_text_color,
      (SELECT tm.meta_value FROM {$wpdb->prefix}termmeta tm WHERE tm.term_id = tt.term_id AND tm.meta_key = 'featured_border_color') as featured_border_color
    FROM
      {$wpdb->prefix}term_taxonomy tt
    INNER JOIN
      {$wpdb->prefix}terms t
    ON
      t.term_id = tt.term_id
    WHERE
      tt.taxonomy IN ('occasion','product_cat')
    ORDER BY
      CASE featured
        WHEN 2 THEN 2
        WHEN 1 THEN 1
        ELSE 0
      END DESC,
      t.Name ASC
    ");
    $placeHolderImage = wc_placeholder_img_src();
    ?>

    <?php
    // Check if category/occassions exists.
    if(count($occasion_featured_list) > 0){
    ?>
    <div class="mt-2 mt-xs-2 mt-sm-0 mb-4" id="topoccassions">
      <div class="d-flex align-items-center mb-1">
        <h3 class="mt-1 popular-headings">
            Kategorier & anledninger
        </h3>
        <div class="button-cont ms-auto">
          <button id="backButton" type="button" class="btn btn-light rounded-circle">
            <div class="align-items-center justify-content-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#1B4949" stroke-width="10" class="bi bi-chevron-left align-middle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" stroke-width="10" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
              </svg>
            </div>
          </button>
          <button id="forwardButton" type="button" class="btn btn-light rounded-circle">
            <div class="align-items-center justify-content-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#1B4949" stroke-width="10" class="bi bi-chevron-left align-middle"  viewBox="0 0 16 16">
                <path fill-rule="evenodd" stroke-width="10" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
              </svg>
            </div>
          </button>
        </div>
      </div>

      <div class="d-flex flex-row flex-nowrap catrownoscroll p-1" id="catrowscroll" data-snap-slider="occasions" style="overflow-x: auto; scroll-snap-type: x mandatory !important; scroll-behavior: smooth;">
        <?php
        $city_id = $postId;

        // Query to fetch all landing pages related to the collected cat_occ_ids and city_id
        $args = array(
            'post_type'      => 'landingpage',
            'post_status'    => 'publish',
            'posts_per_page' => -1, // Fetch all relevant posts
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'     => 'postal_code_relation', // ACF field key
                    'value'   => '"' . $city_id . '"', // Pass the city post ID
                    'compare' => 'LIKE',
                )
            )
        );

        $query = new WP_Query($args);

        // Build an associative array to map cat_occ_id to the landing page permalink
        $landing_page_permalinks = array();

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();

                // Check if the current post has category_relation or occasion_relation
                $category_relation = get_post_meta($post_id, 'category_relation', true);
                $occasion_relation = get_post_meta($post_id, 'occasion_relation', true);

                if ($category_relation) {
                    $landing_page_permalinks[$category_relation] = get_permalink();
                } elseif ($occasion_relation) {
                    $landing_page_permalinks[$occasion_relation] = get_permalink();
                }
            }
            wp_reset_postdata(); // Reset post data after the query
        }
        // END OF GETTING PERMALINKS


        foreach($occasion_featured_list as $occasion){
            // Only show a card, if the cat/occasion is actually present in stores.
            if(in_array($occasion->term_id, $occasionTermListArray) || in_array($occasion->term_id, $categoryTermListArray))
            {
                $category_or_occasion = ($occasion->taxonomy == 'product_cat') ? 'cat' : 'occ_';

                // Get the permalink from the associative array or use the default city page permalink
                $landing_page_permalink = isset($landing_page_permalinks[$occasion->term_id]) ? $landing_page_permalinks[$occasion->term_id] : $city_page_permalink . '?c=' . $occasion->term_id;


                $occasionImageUrl = '';
                $icon_src = $occasion->icon_src;
                $image_src = $occasion->image_src;
                $featured_bg_color = $occasion->featured_bg_color;
                $featured_text_color = $occasion->featured_text_color;
                $featured_border_color = $occasion->featured_border_color;
                $featured = $occasion->featured;

                $bg_str = '';
                $text_str = ' color: #222222;';
                $border_str = '';
                if(!empty($featured) && $featured == "1"){
                    if(!empty($featured_bg_color)){
                        $bg_str = ' background-color: '.$featured_bg_color.'; color: '.$featured_text_color.';';
                    }
                    if(!empty($featured_text_color)){
                        $text_str = ' color: '.$featured_text_color.'"';
                    }
                    if(!empty($featured_border_color)){
                        $border_str = ' border: 3px solid '.$featured_border_color.' !important;';
                    }
                }

                if(!empty($icon_src)){
                    $occasionImageUrl = wp_get_attachment_image($occasion->icon_src, 'vendor-product-box-size', false, array('class' => 'mx-auto my-auto d-block  ratio-4by3', 'style' => 'max-width: 75%; max-height: 75%;', 'alt' => $occasion->name));
                } else {
                    if(!empty($occasion->image_src)){
                        $occasionImageUrl = wp_get_attachment_image($occasion->image_src, 'vendor-product-box-size', false, array('class' => 'card-img-top ratio-4by3', 'alt' => $occasion->name));
                    } else {
                        $occasionImageUrl = wp_get_attachment_image($placeHolderImage, 'vendor-product-box-size', false, array('class' => 'card-img-top ratio-4by3', 'alt' => $occasion->name));
                    }
                }
              ?>
              <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 py-0 my-0 pe-2  card_outer occasion-card" style="scroll-snap-align: start;">
                <div class="card border-0 shadow-sm" style="<?php echo $bg_str; ?>  <?php echo $border_str; ?>">
                  <a href="<?php echo $landing_page_permalink; ?>" data-elm-id="<?php echo $category_or_occasion.$occasion->term_id; ?>" class="top-category-occasion-list stretched-link" style="<?php echo $text_str; ?>">
                    <div class="card-img-top d-flex flex-wrap align-items-center">
                        <?php echo $occasionImageUrl;?>
                    </div>
                    <div class="card-body" style="font-size: 14px; font-family: 'Inter', sans-serif;<?php echo $text_str; ?>">
                        <?php echo $occasion->name;?>
                    </div>
                  </a>
                </div>
              </div>
          <?php
            } // endif
        } // endforeach
        ?>
        </div>
    </div>
    <?php
    } // end count.
    ?>


    <div class="col-12 py-0 my-4 mb-3">
        <div class="datepicking">
            <div class="text">
                Hvornår skal gaven leveres?
            </div>
            <?php
            // MODAL FILTER (duplicated in desktop filter).
            /**
             * ---------------------
             * Delivery date filter
             * ---------------------
             **/
            $dates = array();
            setlocale(LC_TIME, 'da_DK.UTF-8'); // Set the locale to Danish
            $date_today = new DateTime('now');

            $danish_month_names = array(
                'jan' => 'jan', 'feb' => 'feb', 'mar' => 'mar', 'apr' => 'apr',
                'may' => 'maj', 'jun' => 'jun', 'jul' => 'jul', 'aug' => 'aug',
                'sep' => 'sep', 'oct' => 'okt', 'nov' => 'nov', 'dec' => 'dec'
            );

            for($i=0;$i<7;$i++){
                $formatted_date = strtolower($date_today->format('d. M'));
                $month_abbr = strtolower($date_today->format('M'));
                $formatted_date = str_replace($month_abbr, $danish_month_names[$month_abbr], $formatted_date);
                $dates[$i] = $formatted_date;
                $date_today->modify('+1 day');
            }
            $dates[8] = 'Vis alle';

            ?>

            <div class="rounded-3 mb-4">
                <?php
                foreach($dates as $k => $v){
                    $closed_for_today = 0;
                    if($k == 0 && $DropOffTimes <= date("H")){
                        $closed_for_today = 1;
                    }
                    ?>
                    <div class="rounded border-0 rounded-pill datelabel-bg" style="display: inline-block; margin: 5px 5px 4px 0; font-size: 13px;">
                        <label class="datelabel <?php echo ($closed_for_today == 1 ? 'datelabelstrikethrough;' : ';'); ?>" for="filter_delivery_date_<?php echo $k; ?>">
                            <input type="radio" name="filter_del_days_city" class="form-check-input filter-on-city-page" id="filter_delivery_date_<?php echo $k; ?>" value="<?php echo $k; ?>" <?php echo ($closed_for_today == 1 ? 'disabled="disabled" ' : ''); ?> <?php echo ($k == 8 ? 'checked="checked"' : ''); ?>>
                            <span style="color: <?php echo ($closed_for_today == 1 ? '#c0c0c0' : '#000000'); ?>;">
                                <?php echo $v; ?>
                              </span>
                        </label>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

    <!-- show filtered result here-->
    <div class="filteredStore row"></div>

    </div>

    <!-- Loading heartbeat START -->
    <?php get_template_part('template-parts/inc/blocks/loading-heartbeat'); ?>
    <!-- Loading heartbeat END -->


    <?php
    if(!empty(the_content())){
    ?>
    <style type="text/css">
        .lp-content-block h1,
        .lp-content-block h2,
        .lp-content-block h3,
        .lp-content-block h4,
        .lp-content-block h5,
        .lp-content-block h6
        {
            font-family: 'Inter','MS Trebuchet', 'Rubik',sans-serif;
        }
        .lp-content-block h1 { font-size: 24px; }
        .lp-content-block h2 { font-size: 23px; }
        .lp-content-block h3 { font-size: 22px; }
        .lp-content-block h4 { font-size: 20px; }
        .lp-content-block h5 { font-size: 18px; }
        .lp-content-block h6 { font-size: 16px; }

        .lp-content-block p {
            font-size: 14px;
        }
        .lp-content-block a {
            color: #000000;
            text-decoration: underline;
        }
    </style>
    <div class="lp-content-block">
      <?php echo the_content(); ?>
    </div>
    <?php
    }
    ?>


      <?php
      # TODO: Add so the description is here with a "read more"
      # TODO: Add so we only show this part if there is a description. We shouldn't just stuff links in here.

      if(get_field('show_landingpage_links_on_city_page', 'option') == 1){
        $args = array(
            'post_type' => 'landingpage',
            'post_status' => 'publish',
            'posts_per_page' => 15,
            'meta_query' => array(
              array(
                'key' => 'postal_code_relation',
                'value' => '"'.get_the_ID() .'"',
                'compare' => 'LIKE'
              )
            ),
            'orderby' => 'post_title',
            'order' => 'ASC'
        );
        $posts = new WP_Query( $args );
        $i = 1;
        $count = count($posts->posts);
        $cols = 3;
        $countcols = $count / $cols;

        if($count > 0){
        ?>
        <div class="row mb-3">
          <h5 style="font-family: 'Inter', sans-serif; margin-top: 25px;">Er du på udkig efter noget specifikt? Find alle typer af gavehilsner i <?php echo $cityName; ?></h5>
          <div class="col-12 col-md-6 col-lg-4 mb-3" style="overflow-wrap: break-word;">
            <?php
            foreach($posts->posts as $k => $v){
              echo '<a href="'.get_permalink($v->ID).'">';
              print $v->post_title;
              echo '</a><br>';
              if($i % $countcols == 0){
                echo '</div>';
                echo '<div class="col-12 col-md-6 col-lg-4 mb-3"  style="overflow-wrap: break-word;">';
              }
              $i++;
            }
            ?>
          </div>
        </div>
        <?php
        }
      }
      ?>
      </div>
    </div>
  </div>
</section>
</main>


<?php

get_template_part('template-parts/inc/blocks/press-mentions');
get_template_part('template-parts/inc/blocks/how-it-works');
get_template_part('template-parts/inc/blocks/learn-more');

get_footer( );
?>

<script type="text/javascript">
  // Start the jQuery
  jQuery(document).ready(function($) {
    var ajaxurl = "<?php echo admin_url('admin-ajax.php');?>";

    // Get URL parameters
    var url = new URL(window.location.href);

    jQuery(".filter-on-city-page").click(function(){
      update();

      if(this.type == "radio"){
        var id = this.id;
        var id2 = id.replace(/[0-9]+/, "");
        jQuery("div[id*='"+id2+"']").remove();
      }
    });

    update();
    function update(){
      var cityName = $('#cityName').val();
      var postalCode = $('#postalCode').val();

      // Make the loading...
      jQuery('.loadingHeartBeat').show();
      jQuery('.filteredStore').hide();

      // Chosen delivery date
      var delDate = $('input[name=filter_del_days_city]:checked').val();

      var data = {
        'action': 'catOccaDeliveryAction',
        cityDefaultUserIdAsString: jQuery("#cityDefaultUserIdAsString").val(),
        delDate: delDate,
        cityName: cityName,
        postalCode: postalCode
      };
      jQuery.post(ajaxurl, data, function(response) {
        jQuery('.filteredStore').show();
        jQuery('.filteredStore').html(response);
        jQuery('.loadingHeartBeat').hide();
      });
    }

    // Select the container element
    const container = jQuery('#catrowscroll');
    const card_cont = jQuery('#catrowscroll div.card_outer:first-child');

    // Define the number of cards to scroll based on screen size
    const numCardsToScroll = jQuery(window).width() >= 992 ? 3 : 2;

    // Add click event listeners to the buttons
    jQuery("#forwardButton").click(function(){
      container.animate({
        scrollLeft: '+=' + (card_cont.outerWidth(true)-1) * numCardsToScroll
      }, '2');
    });

    jQuery("#backButton").click(function(){
      container.animate({
        scrollLeft: '-=' + (card_cont.outerWidth(true)-1) * numCardsToScroll
      }, '2');
    });
  });
</script>
