<?php
/**
 *
 * Perform start setup
 *
**/
global $wpdb;

$pageId = get_the_ID();
$page_id = $pageId;
$usersForThisLP = array();
$city_name = get_field('city_name', $page_id);

// Get the connectors fields and check if they are empty.
// If empty, then redirect to home.
$lp_category_conn = get_field('category_relation', $page_id);
$lp_occasion_conn = get_field('occasion_relation', $page_id);
#var_dump($lp_category_conn);var_dump($lp_occasion_conn);
$connection_id = !empty($lp_category_conn) ? $lp_category_conn : $lp_occasion_conn;
$connection_type = !empty($lp_category_conn) ? 'category' : (!empty($lp_occasion_conn) ? 'occasion' : '');
$filter_to_show = $connection_type == 'category' ? 'occasion' : 'category';

if(empty($connection_id)){
  wp_redirect(home_url());
  exit();
}

// Generate the string for the title of the page.
// Get the title
$title = get_the_title();
// Check if the city name exists in the title
if (strpos($title, $city_name) !== false) {
    // Replace the city name with the same name wrapped in a span
    $title = str_replace($city_name, '<span class="cityname">' . $city_name . '</span>', $title);
}

get_header();
get_header('green', array('city' => '', 'postalcode' => ''));
?>


<main id="main" class="container"<?php if ( isset( $navbar_position ) && 'fixed_top' === $navbar_position ) : echo ' style="padding-top: 100px;"'; elseif ( isset( $navbar_position ) && 'fixed_bottom' === $navbar_position ) : echo ' style="padding-bottom: 100px;"'; endif; ?>>
<?php
// TODOS!!!!!
// --
// @todo: Implement delivery date in ajax call. It isn't at the moment.
// (v) @todo: The filter is not applying correct. On this page I can add "flowers" and get "Vinskibet" who doesn't have "flowers": http://greeting/l/barselsgaver-i-koebenhavn-k/?d=1,0&c=355&price=0,1150
// (v) @todo: Make sure we only show EITHER category OR occasion, since one of them is "set by default" on landing pages.
// (v) @todo: Make sure the header for category / occasions change.
// (v) @todo: Show postalcode filter when it is due (>1 and <15 postalcodes.)

// ----
// Generate array of postal codes for this landing page.
//
#$cityIdArr = get_post_meta($pageId, 'postal_code_relation', true);
#$cityId = $cityIdArr[0];
$postal_codes = get_field('postal_code_relation', $pageId);

foreach($postal_codes as $postcode){
  $post_code_val = get_field('postalcode', $postcode->ID);
  $postcodes[] = $post_code_val;
  $postalcodesForFilter[] = array('id' => $postcode->ID, 'postcode' => $post_code_val, 'title' => $postcode->post_title, 'shorttag' => $postcode->post_name);
}

if(count($postal_codes) > 15 || count($postal_codes) == 1){
  $pc_filter = 0;
} else {
  $pc_filter = 1;
}

// -------------------

// Prepare the placeholders
// And the where statement
$where = array();
$placeholder_arr = array_fill(0, count($postcodes), 'um.meta_value LIKE %s');
foreach($postcodes as $postcode){
  $where[] = '%'.$postcode.'%';
}
#53,38,43,65,39,68,44,60,50

// Add the user role to the where array:
$where[] = '%dc_vendor%';

$sql = "
SELECT u.ID, umm1.meta_value AS dropoff_time, umm2.meta_value AS require_delivery_day, umm3.meta_value AS delivery_type
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
$vendor_arr = $wpdb->get_results($sql_prepare);

$userForThisCategory = array();
foreach ($users_from_postcode as $queryUserId) {
    $vendor = get_mvx_vendor($queryUserId);

    $vendorProducts = $vendor->get_products(array('fields' => 'ids'));
    #var_dump($vendorProducts);
    foreach ($vendorProducts as $productId) {
        if($connection_type == 'category'){
          $categoryTermList = wp_get_post_terms($productId, 'product_cat', array('fields' => 'ids'));
        } else {
          $categoryTermList = wp_get_post_terms($productId, 'occasion', array('fields' => 'ids'));
        }
        #var_dump($categoryTermList);
        foreach($categoryTermList as $catTerm){
            if($catTerm == $connection_id){
                array_push($userForThisCategory, $queryUserId);
            }
        }
    }
}

// Use get_the_terms to fetch all the terms for all products belonging to the vendors
$terms = wp_get_object_terms($users_from_postcode, array('product_cat', 'occasion'));

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
$defaultUserArray = array_intersect($users_from_postcode, $userForThisCategory);
$defaultUserString = implode(",", $defaultUserArray);

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

foreach ($defaultUserArray as $vendorId) {
    $vendor = get_mvx_vendor($vendorId);
    $vendorProductIds = array_merge($vendorProductIds, $vendor->get_products(array('fields' => 'ids')));
}
$vendorProductIds = array_unique($vendorProductIds);

// Use a custom SQL query to fetch the prices of those products
$where = array();
foreach($vendorProductIds as $pv){
  if(is_numeric($pv)){
    $where[] = $pv;
  }
}

if(!empty($where)){
  $prices = $wpdb->prepare("
      SELECT meta_value
      FROM {$wpdb->postmeta}
      WHERE meta_key = '_price'
      AND post_id IN (".implode(', ', array_fill(0, count($vendorProductIds), '%s')).")
  ", $where);
  $prices = $wpdb->get_results($prices);

  // Convert the results to an array of prices
  $priceArray = array();
  foreach ($prices as $price) {
      $priceArray[] = $price->meta_value;
  }
} else {
  $priceArray = array(0,2000);
}

// Use min and max to get the minimum and maximum prices
$minPrice = min($priceArray);
$maxPrice = max($priceArray);

// Use array_push to add the prices to the $productPriceArray
array_push($productPriceArray, $minPrice, $maxPrice);

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
<input type="hidden" id="landingPageDefaultUserIdAsString" value="<?php echo $defaultUserString;?>">
<input type="hidden" id="cityName" value="<?php echo $city_name; ?>">

<section id="citycontent" class="row">
  <div class="container">
      <div class="row">
        <div class="col-12">
          <h1 class="d-block my-0 my-xs-3 my-sm-2 my-md-2 mt-3 mt-lg-4 pt-lg-1 mb-lg-3">
            <?php echo $title; ?>
          </h1>
        </div>
      </div>


      <?php
      // get user meta query
      $catocca_query_type = ($connection_type == 'occasion') ? 'product_cat' : 'occasion';

      $occasion_query = $wpdb->prepare( "
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
          tt.taxonomy = %s
        ORDER BY
          CASE featured
            WHEN 2 THEN 2
            WHEN 1 THEN 1
            ELSE 0
          END DESC,
          t.Name ASC
        ", $catocca_query_type);

      $occasion_featured_list = $wpdb->get_results($occasion_query);

      $placeHolderImage = wc_placeholder_img_src();
      ?>

      <?php
      // Check if category/occassions exists.
      if(count($occasion_featured_list) > 0){
          ?>
          <div class="mt-2 mt-xs-2 mt-sm-0 mb-4" id="topoccassions">
              <div class="d-flex align-items-center mb-1">
                  <h3 class="mt-1 popular-headings">
                      <?php echo ($filter_to_show == 'category' ? 'Kategorier' : 'Anledninger'); ?>
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

              <div class="d-flex flex-row flex-nowrap catrownoscroll px-1 py-2" id="catrowscroll" data-snap-slider="occasions" style="overflow-y: visible; overflow-x: auto; scroll-snap-type: x mandatory !important; scroll-behavior: smooth;">
                  <?php
                  foreach($occasion_featured_list as $occasion){
                      // Only show a card, if the cat/occasion is actually present in stores.
                      if(in_array($occasion->term_id, $occasionTermListArray) || in_array($occasion->term_id, $categoryTermListArray)){

                          $category_or_occasion = ($occasion->taxonomy == 'product_cat') ? 'cat' : 'occ_';

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
                              <div class="card border-3 border-transparent shadow-sm" style="<?php echo $bg_str; ?>  <?php echo $border_str; ?>">
                                  <label for="filter_cat<?php echo $occasion->term_id; ?>" rel="nofollow" class="cursor-pointer form-check-label top-category-occasion-list stretched-link" style="cursor: pointer; <?php echo $text_str; ?>">
                                      <input type="checkbox" role="switch" name="filter_catocca_city" class="d-none form-check-input filter-on-city-page" id="filter_cat<?php echo $occasion->term_id; ?>" value="<?php echo $occasion->term_id; ?>">
                                      <div class="card-img-top d-flex flex-wrap align-items-center">
                                          <?php echo $occasionImageUrl;?>
                                      </div>
                                      <div class="card-body" style="font-size: 14px; font-family: 'Inter', sans-serif;<?php echo $text_str; ?>">
                                          <span class="swoosh d-none">✓&nbsp;</span><?php echo $occasion->name;?>
                                      </div>
                                  </label>
                              </div>
                          </div>
                          <?php
                      }
                  }
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


    <div class="row">
      <div class="col-12 mb-5">
        <!-- show filtered result here-->
        <div class="filteredStore row">
        </div>
        <!-- Loading heartbeat START -->
        <?php get_template_part('template-parts/inc/blocks/loading-heartbeat'); ?>
        <!-- Loading heartbeat END -->
      </div>
    </div>
  </div>
</section>

<style type="text/css">
    .lp-content-block h1,
    .lp-content-block h2,
    .lp-content-block h3,
    .lp-content-block h4,
    .lp-content-block h5,
    .lp-content-block h6
    {
        font-family: 'MS Trebuchet', 'Trebuchet MS', 'Inter', 'Rubik', sans-serif !important;
    }
    .lp-content-block h1 { font-size: 24px !important; font-weight: 400 !important; }
    .lp-content-block h2 { font-size: 20px !important; font-weight: 400 !important; }
    .lp-content-block h3 { font-size: 19px !important; font-weight: 300 !important; }
    .lp-content-block h4 { font-size: 18px !important; font-weight: 300 !important; }
    .lp-content-block h5 { font-size: 16px !important; font-weight: 300 !important; }
    .lp-content-block h6 { font-size: 14px !important; font-weight: 300 !important; }


    .lp-content-block p {
        font-size: 14px;
    }
    .lp-content-block a {
        color: #000000;
        text-decoration: underline;
    }

    .lp-content-block div.short_description {
        column-count: 2;
    }
    @media only screen
    and (max-width: 876px) {
        .lp-content-block div.short_description {
            column-count: 1;
        }
    }
</style>
<section id="description" class="mt-4 mb-5 pb-4">
  <div class="description lp-content-block row">
      <div class="col-12">
          <div style="position: relative;">
            <div id="categoryDescription" style="max-height: 400px; overflow: hidden;">
              <?php
              $description = get_the_content();
              $description = add_links_to_keywords(
                  wp_kses_post( $description ),
                  array('product_cat', 'occasion'),
                  true,
                  $postal_codes
              );
              $collapsed = false;

              // Check if the content exceeds the max-height
              if (strlen($description) > 300) {
                  $collapsed = true;
              }

              echo '<div class="short_description">';
              echo $description;
              echo '</div>';
              #the_content();

              if ($collapsed) {
                  echo '<div class="overlay" id="ctaOverlayWhite"></div>';
                  echo '<div class="button-line col-12 text-center py-2">';
                  echo '<button class="btn bg-teal text-white rounded-pill border-teal border-1" id="toggleDescription" style="z-index: 1 !important;">Læs mere</button>';
                  echo '</div>';
              }
              ?>
            </div>
            <style>
              .overlay {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(to bottom, rgba(255, 255, 255, 0.33) 20%, rgba(255, 255, 255, 1) 100%);
                pointer-events: none;
              }
              .button-line {
                position: absolute;
                bottom: -40px;
                width: 100%;
                z-index: 1 !important;
              }
            </style>
        </div>
      </div>
  </div>
  <script>

    var categoryDescription = document.getElementById('categoryDescription');
    var descriptionOverlay = document.getElementById('ctaOverlayWhite');
    var showMoreButton = document.getElementById('toggleDescription');

    if (showMoreButton) {
        showMoreButton.addEventListener('click', function () {
            categoryDescription.style.maxHeight = 'none'; // Allow the container to expand
            descriptionOverlay.style.display = 'none';
            showMoreButton.style.display = 'none'; // Hide the "Show More" button
        });
    }
  </script>
</section>
</main>


<?php

get_template_part('template-parts/inc/blocks/press-mentions');
get_template_part('template-parts/inc/blocks/how-it-works');
get_template_part('template-parts/inc/blocks/learn-more');

get_footer(); ?>


<script src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">

<script type="text/javascript">
  jQuery(document).ready(function($) {
    var ajaxurl = "<?php echo admin_url('admin-ajax.php');?>";
    var catOccaIdArray = [];
    var inputPriceRangeArray = [];
    var deliveryIdArray = [];
    var postalArray = [];

    // Get URL parameters
    var url = new URL(window.location.href);

    jQuery(".filter-on-lp-page").click(function(){
      update();
    });

     // Check delivery filters
     if (deliveryIdArray) {
       deliveryIdArray.forEach(function(id) {
         $('#filter_delivery_' + id).prop('checked', true);
       });
     }

     // Check category and occasion filters
     if (catOccaIdArray) {
       catOccaIdArray.forEach(function(id) {
         var input = $('#filter_cat' + id + ', #filter_occ_' + id);
         if (input.length) {
           input.prop('checked', true);
         }
       });
     }

    // Update filters if all are selected
    if (catOccaIdArray?.length) {
     update();
    }


      //$('html, body').animate({
      //    scrollTop: $('.applied-filters').offset().top
      //}, 0);

    jQuery(".filter-on-city-page").click(function(){
      update();

        if(this.checked){
            $('label[for="' + $(this).attr('id') + '"] span.swoosh').removeClass('d-none').addClass('d-inline-block');
            $(this).closest('.card').toggleClass('border-teal');
        } else {
            $('label[for="' + $(this).attr('id') + '"] span.swoosh').removeClass('d-inline-block').addClass('d-none');
            $(this).closest('.card').toggleClass('border-teal');
        }

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
      catOccaIdArray = [];

      // Make the loading...
      jQuery('.loadingHeartBeat').show();
      jQuery('.filteredStore').hide();

      // Chosen delivery date
      var delDate = $('input[name=filter_del_days_city]:checked').val();

      $("input:checkbox[name=filter_catocca_city]:checked").each(function(){
        catOccaIdArray.push($(this).val());
      });


      var data = {
        'action': 'lpFilterAction',
        cityName: cityName,
        landingPageDefaultUserIdAsString: jQuery("#landingPageDefaultUserIdAsString").val(),
        delDate: delDate,
        catOccaIdArray: catOccaIdArray,
        postalArray: postalArray // this should probably be the raw postal instead of the ID og the post

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
