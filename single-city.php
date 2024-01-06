<?php

/**
 *
 * Perform start setup
 *
**/
global $woocommerce, $wpdb;

$postId = get_the_ID();
$cityPostalcode = get_post_meta($postId, 'postalcode', true);
$cityName = get_post_meta($postId, 'city', true);

$checkout_postalcode = WC()->customer->get_shipping_postcode();
if($cityPostalcode != $checkout_postalcode){
  #print 'postnumre afviger';
  $woocommerce->cart->empty_cart();
}


// Get header designs.
get_header();
get_header('green', array('city' => $cityName, 'postalcode' => $cityPostalcode)); ?>


<?php
/**
* @author Dennis Lauritzen
*
*/
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
    $vendor = get_wcmp_vendor($vendorId);
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
        <h1 class="d-block my-0 my-xs-3 my-sm-2 my-md-2 mt-3 mt-lg-4 pt-lg-1 mb-lg-3">Find butikker med gavehilsner i <?php the_title();?></h1>
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
      (SELECT tm.meta_value FROM {$wpdb->prefix}termmeta tm WHERE tm.term_id = tt.term_id AND tm.meta_key = 'featured_image') as image_src
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
        <h3 class="mt-1" style="font-family: Inter; font-size: 17px;">Kategorier</h3>
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
      <style type="text/css">
        .card-img-top {
          min-height: 175px !important;
        }
        .catrownoscroll::-webkit-scrollbar {
          width: 0px
        }
      </style>

      <div class="d-flex flex-row flex-nowrap catrownoscroll p-1" id="catrowscroll" data-snap-slider="occasions" style="overflow-x: auto; scroll-snap-type: x mandatory !important; scroll-behavior: smooth;">
        <?php
        foreach($occasion_featured_list as $occasion){
          if(in_array($occasion->term_id, $occasionTermListArray) || in_array($occasion->term_id, $categoryTermListArray)){
            // Only show a card, if the cat/occasion is actually present in stores.
            $category_or_occasion = ($occasion->taxonomy == 'product_cat') ? 'cat' : 'occ_';

            $occasionImageUrl = '';
            if(!empty($occasion->image_src)){
              $occasionImageUrl = wp_get_attachment_image($occasion->image_src, 'vendor-product-box-size', false, array('class' => 'card-img-top ratio-4by3', 'alt' => $occasion->name));
            } else {
              $occasionImageUrl = wp_get_attachment_image($placeHolderImage, 'vendor-product-box-size', false, array('class' => 'card-img-top ratio-4by3', 'alt' => $occasion->name));
            }
          ?>
          <div class="col-6 col-sm-6 col-md-4 col-lg-2 py-0 my-0 pe-2 card_outer" style="scroll-snap-align: start;">
            <div class="card border-0 shadow-sm">
              <a href="<?php echo get_permalink().'?c='.$occasion->term_id; ?>" rel="nofollow" data-elm-id="<?php echo $category_or_occasion.$occasion->term_id; ?>" class="top-category-occasion-list stretched-link text-dark">
                <?php echo $occasionImageUrl;?>
                <div class="card-body">
                  <h5 class="card-title">
                    <b><?php echo $occasion->name;?></b>
                  </h5>
                </div>
              </a>
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
      <h5 style="font-family: Inter;"><?php echo str_replace(array('{{city_name}}','{{postalcode}}'),array($cityName,$cityPostalcode),get_field('filter_heading','option')); ?></h5>
      <a class="btn border-teal text-green mb-1 modalBtn" id="filterModalDelDateBtn" data-bs-toggle="modal" data-cd-open="deliveryDates" href="#filterModal" role="button">
        &#128197;
        &nbsp;Vælg leveringsdato
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
          <path d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
        </svg>
      </a>
      <a class="btn border-teal text-green mb-1 modalBtn" id="filterModalOccasionBtn" data-bs-toggle="modal" data-cd-open="occasionFilter" href="#filterModal" role="button">
        &#127874;
        &nbsp;Vælg anledning
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
        <path d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
      </svg>
      </a>
      <a class="btn border-teal text-green mb-1 modalBtn" id="filterModalCategoryBtn" data-bs-toggle="modal" data-cd-open="categoryFilter"  href="#filterModal" role="button">
        &#128144;
        &nbsp;Vælg kategori
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
          <path d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
        </svg>
      </a>
      <a class="btn border-teal text-green mb-1 modalBtn" id="filterModalPriceBtn" data-bs-toggle="modal" data-cd-open="priceFilter" href="#filterModal" role="button">
        &#128176;
        &nbsp;Pris
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
          <path d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
        </svg>
      </a>
    </div>
    <div class="modal fade" id="filterModal" aria-hidden="true" aria-labelledby="filterButton" tabindex="-1">
      <div class="modal-dialog modal-fullscreen-lg-down modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalToggleLabel" style="font-family: Inter,sans-serif; font-size: 15px;">Filtrér</h5>
            <button type="button" class="btn-check" data-bs-dismiss="modal" aria-label="Approve"></button>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php
            // MODAL FILTER (duplicated in desktop filter).
            /**
             * ---------------------
             * Delivery date filter
             * ---------------------
            **/
            $dates = array();
            $date_today = new DateTime('now');
            for($i=0;$i<7;$i++){
              $dates[$i] = strtolower($date_today->format('d. M'));
              $date_today->modify('+1 day');
            }
            $dates[8] = 'Vis alle';

            ?>
            <style type="text/css">

            .collapse-btn h5:before {
              content: "+";
              float: right;
              padding: 0 0 5px 0;
            }
            .collapse-btn[aria-expanded="true"] h5:before {
              content: "-";
            }
            </style>
            <a data-bs-toggle="collapse" href="#deliveryDates" class="collapse-btn position-relative mb-3" role="button" aria-expanded="false" aria-controls="deliveryDates">
              <h5 class="text-uppercase text-dark pb-2" style="font-family: Inter,sans-serif; font-size: 15px;">
                &#128197;&nbsp;Hvornår skal gaven leveres?
              </h5>
            </a>
            <div class="dropdown rounded-3 list-unstyled overflow-hidden mb-4 collapse" id="deliveryDates">
            <?php
            foreach($dates as $k => $v){
              $closed_for_today = 0;
              if($k == 0 && $DropOffTimes <= date("H")){
                $closed_for_today = 1;
              }
            ?>
            <div class="rounded border-0 rounded-pill bg-light" style="display: inline-block; margin: 5px 5px 4px 0; font-size: 13px;">
              <label class="" for="filter_delivery_date_<?php echo $k; ?>" style="cursor: pointer; padding: 6px 10px; text-transform: <?php echo ($closed_for_today == 1 ? 'strikethrough;' : ';'); ?>;">
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


            <?php
            /**
             * ---------------------
             * Price filter
             * ---------------------
            **/

            $minProductPrice;
            $maxProductPrice;

            if(count($productPriceArray) == 0){
              $minProductPrice = 0;
              $maxProductPrice = 0;
              $topProductPrice = (max($productPriceArray) > 1000) ? '1000' : max($productPriceArray);
            }
            elseif(min($productPriceArray) == max($productPriceArray)){
              $minProductPrice = 0;
              $maxProductPrice = max($productPriceArray);
              $topProductPrice = (max($productPriceArray) > 1000) ? '1000' : max($productPriceArray);
            }
            else {
              $minProductPrice = 0;
              $maxProductPrice = max($productPriceArray);
              $topProductPrice = (max($productPriceArray) > 1000) ? '1000' : max($productPriceArray);
            }

            $priceIntArray = range($minProductPrice, $topProductPrice, 250);

            $start_val = $minProductPrice;
            $end_val = $maxProductPrice;
            if(isset($_GET['price'])){
              $price_arr = explode(',',$_GET['price']);
              if(is_numeric($price_arr['0']) && $price_arr['0'] >= $minProductPrice){
                $start_val = $price_arr['0'];
              }
              if(is_numeric($price_arr['1']) && $price_arr['1'] <= $maxProductPrice){
                $end_val = $price_arr['1'];
              }
            }
            ?>

            <a data-bs-toggle="collapse" href="#priceFilter" class="collapse-btn mb-3" role="button" aria-expanded="false" aria-controls="priceFilter">
              <h5 class="text-uppercase text-dark pb-2" style="font-family: Inter,sans-serif; font-size: 15px;">
                &#128176;&nbsp;Pris
              </h5>
            </a>

            <div class="row  collapse" id="priceFilter">
              <div class="col-12">
                <input type="hidden" name="filter_del_price_default" value="0-<?php echo $maxProductPrice; ?>">
                <div class="dropdown rounded-3 list-unstyled overflow-hidden mb-4">
                <?php
                foreach($priceIntArray as $k => $v){
                  $start = $v;
                  $end = (isset($priceIntArray[$k+1]) ? $priceIntArray[$k+1] : '+');
                  if($end == '+'){
                    $label = 'Over '.$start;
                    $value = $start.'-'.$maxProductPrice;
                  } else {
                    if($start == "0"){
                      $label = 'Under '.$end;
                    } else {
                      $label = $start.'-'.$end;
                    }
                    $value = $start.'-'.$end;
                  }
                ?>
                <div class="rounded border-0 rounded-pill bg-light" style="display: inline-block; margin: 5px 5px 4px 0; font-size: 13px;">
                  <label class="" for="filter_price_<?php echo $k; ?>" style="cursor: pointer; padding: 6px 10px;">
                    <input type="checkbox" name="filter_del_price" class="form-check-input filter-on-city-page" id="filter_price_<?php echo $k; ?>" value="<?php echo $value; ?>">
                    <?php echo $label; ?> kr.
                  </label>
                </div>
                <?php
                }
                ?>
                </div>
              </div>
            </div>

            <?
            /**
             * ---------------------
             * Delivery type filter
             * ---------------------
            **/
            ?>
            <a data-bs-toggle="collapse" href="#delTypeFilter" class="collapse-btn mb-3" role="button" aria-expanded="false" aria-controls="delTypeFilter">
              <h5 class="text-uppercase text-dark pb-2" style="font-family: Inter,sans-serif; font-size: 15px;">
                &#128757;&nbsp;Levering
              </h5>
            </a>
            <ul class="dropdown rounded-3 list-unstyled overflow-hidden collapse mb-4" id="delTypeFilter">

            <div class="form-check form-switch">
                <input type="checkbox" name="filter_del_city" class="form-check-input filter-on-city-page" id="filter_delivery_1" checked="checked" value="1">
                <label class="form-check-label" for="filter_delivery_1">
                  Personlig levering fra lokal butik
                </label>
            </div>
            <div class="form-check form-switch">
                <input type="checkbox" name="filter_del_city" class="form-check-input filter-on-city-page" id="filter_delivery_0" checked="checked" value="0">
                <label class="form-check-label" for="filter_delivery_0">
                  Forsendelse med fragtfirma
                </label>
            </div>

            </ul>


            <?php
            /**
             * ---------------------
             * Category filter
             * ---------------------
            **/
            ?>
            <a data-bs-toggle="collapse" href="#categoryFilter" class="collapse-btn mb-3" role="button" aria-expanded="false" aria-controls="categoryFilter">
              <h5 class="text-uppercase text-dark pb-2" style="font-family: Inter,sans-serif; font-size: 15px;">
                &#128144;&nbsp;Kategori
              </h5>
            </a>

            <ul class="dropdown rounded-3 list-unstyled overflow-hidden collapse mb-4" id="categoryFilter">

            <?php
            // search users for get filtered category
            $categoryTermListArrayUnique = array_unique($categoryTermListArray);

            // product category
            $categoryArgs = array(
              'fields' => 'all',
              'taxonomy'   => "product_cat",
              'exclude' => array('15','16'),
              'include' => $categoryTermListArrayUnique
              // 'pad_counts' => true,
              // 'hide_empty' => 1,
            );
            $productCategories = get_terms($categoryArgs);

            foreach($productCategories as $category){ ?>
              <div class="form-check" style="overflow: visible;">
                  <input type="checkbox" role="switch" name="filter_catocca_city" class="form-check-input filter-on-city-page" id="filter_cat<?php echo $category->term_id; ?>" value="<?php echo $category->term_id; ?>">
                  <label for="filter_cat<?php echo $category->term_id; ?>" class="form-check-label">
                    <?php echo $category->name; ?>
                  </label>
              </div>
            <?php
            }
            ?>
            </ul>

            <?php
            /**
             * ---------------------
             * Occasion filter
             * ---------------------
            **/
            ?>
            <a data-bs-toggle="collapse" href="#occasionFilter" class="collapse-btn mb-3" role="button" aria-expanded="false" aria-controls="occasionFilter">
              <h5 class="text-uppercase text-dark pb-2" style="font-family: Inter,sans-serif; font-size: 15px;">
                &#127874;&nbsp;Anledning
              </h5>
            </a>
            <ul class="dropdown rounded-3 list-unstyled overflow-hidden collapse mb-4" id="occasionFilter">
            <?php
            // Occassion

            // Take the occassion term array and make sure we only get uniques.
            $occasionTermListArrayUnique = array_unique($occasionTermListArray);

            $args = array(
                'taxonomy'   => "occasion",
                'include' => $occasionTermListArrayUnique
                // 'hide_empty' => 1,
                // 'include'    => $ids
            );
            $productOccasions = get_terms($args);
            foreach($productOccasions as $occasion){
              ?>
              <div class="form-check">
                  <input type="checkbox" name="filter_catocca_city" class="form-check-input filter-on-city-page" id="filter_occ_<?php echo $occasion->term_id; ?>" value="<?php echo $occasion->term_id; ?>">
                  <label class="form-check-label" for="filter_occ_<?php echo $occasion->term_id; ?>"><?php echo $occasion->name; ?></label>
              </div>
            <?php
            }
            ?>
            </ul>

          </div>
          <div class="modal-footer">
            <button class="btn btn-outline-dark" data-bs-dismiss="modal" aria-label="Close">Luk</button>
            <button class="btn bg-teal border-teal text-w" data-bs-toggle="modal" data-bs-dismiss="modal">Gem filtre</button>
          </div>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col-12 mb-2">
        <h2 class="my-3 my-xs-3 my-sm-3 my-md-3 my-lg-2 my-xl-2 mt-lg-4 mt-xl-4">Alle butikker i <?php the_title();?></h2>
        <div class="applied-filters row mt-xs-0 mt-sm-0 mt-md-0 mt-3 mb-0 lh-lg">
          <div class="col-12 filter-list">
            <div id="filterdel_dummy_0" class="badge rounded-pill border-yellow py-2 px-2 me-1 my-1 text-dark dynamic-filters">
                Forsendelse med fragtfirma
              <button type="button" class="btn-close filter-btn-delete"
              data-filter-id="0" data-label="Forsendelsemedfragtfirma"
              data-filter-remove="filter_delivery_0" onclick="removeFilterBadgeCity('Forsendelsemedfragtfirma', 'filterfilter_delivery_0', 'filter_delivery_0', true);"></button>
            </div>
            <div id="filterdel_dummy_1" class="badge rounded-pill border-yellow py-2 px-2 me-1 my-1 my-lg-0 my-xl-0 text-dark dynamic-filters">
                Personlig levering fra lokal butik
              <button type="button" class="btn-close filter-btn-delete" data-filter-id="0" data-label="Personligleveringfralokalbutik"
              data-filter-remove="filter_delivery_1" onclick="removeFilterBadgeCity('Personligleveringfralokalbutik', 'filterfilter_delivery_1', 'filter_delivery_1', true);"></button>
            </div>
            <a href="<?php echo home_url(); ?>"class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 mb-1 text-dark">
              <?php echo $cityPostalcode.' '.$cityName; ?>
              <button type="button" class="btn-close" aria-label="Close"></button>
            </a>
            <a href="#" id="cityPageReset" onclick="event.preventDefault();" class="badge rounded-pill border-yellow py-2 pe-2 my-1 my-lg-0 my-xl-0 mb-1 bg-yellow text-white">
              Nulstil alle
              <button type="button" class="btn-close  btn-close-white" aria-label="Close">
              </button>
            </a>
          </div>
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
    $('#filterdel_dummy_0, #filterdel_dummy_1').remove();

    // Set delivery filters
    setFilterBadgeCity('Personlig levering fra lokal butik', 'filterfilter_delivery_1', 'filter_delivery_1');
    setFilterBadgeCity('Forsendelse med fragtfirma', 'filterfilter_delivery_0', 'filter_delivery_0');

    var ajaxurl = "<?php echo admin_url('admin-ajax.php');?>";
    var catOccaDeliveryIdArray = [];
    var inputPriceRangeArray = [];
    var deliveryIdArray = [];

    // Get URL parameters
     var url = new URL(window.location.href);
     var deliveryIdArray = url.searchParams.get("d")?.split(",");
     var catOccaDeliveryIdArray = url.searchParams.get("c")?.split(",");
     var inputPriceRangeArray = url.searchParams.get("price")?.split(",");

     // Check delivery filters
     if (deliveryIdArray) {
       deliveryIdArray.forEach(function(id) {
         $('#filter_delivery_' + id).prop('checked', true);
       });
     }

     // Check category and occasion filters
     if (catOccaDeliveryIdArray) {
       catOccaDeliveryIdArray.forEach(function(id) {
         var input = $('#filter_cat' + id + ', #filter_occ_' + id);
         if (input.length) {
           input.prop('checked', true);
         }
       });
     }

     // Set price range filter
     if (inputPriceRangeArray) {
       var priceRangeMinVal = inputPriceRangeArray[0] || 0;
       var priceRangeMaxVal = inputPriceRangeArray[1];
       if (priceRangeMaxVal) {
         priceRangeMaxVal = parseFloat(priceRangeMaxVal);
       }
     }

    // Update filters if all are selected
    if (deliveryIdArray?.length && catOccaDeliveryIdArray?.length && inputPriceRangeArray?.length) {
      update();
    }

    // Handle category and occasion filter clicks
    $('a.top-category-occasion-list').click(function(event) {
      event.preventDefault();
      var elmId = this.getAttribute("data-elm-id");
      $('#filter_' + elmId).click();

      $('html, body').animate({
        scrollTop: $('h2').offset().top
      }, 0);
    });

    jQuery(".filter-on-city-page").click(function(){
      update();

      if(this.type == "radio"){
        var id = this.id;
        var id2 = id.replace(/[0-9]+/, "");
        jQuery("div[id*='"+id2+"']").remove();
      }

      if(this.checked){
        setFilterBadgeCity(
          $('label[for='+this.id+']').text(),
          this.value,
          this.id
        );
      } else {
        if (this.id.includes("filter_delivery_date")){
          jQuery("input#filter_delivery_date_8").prop('checked',true);
        }
        removeFilterBadgeCity(
          $('label[for='+this.id+']').text(),
          this.value,
          this.id,
          false
        );
      }
    });

    update();
    function update(){
      var cityName = $('#cityName').val();
      var postalCode = $('#postalCode').val();
      catOccaIdArray = [];
      deliveryIdArray = [];
      inputPriceRangeArray = [];

      // Make the loading...
      jQuery('.loadingHeartBeat').show();
      jQuery('.filteredStore').hide();

      // Chosen delivery date
      var delDate = $('input[name=filter_del_days_city]:checked').val();

      $("input:checkbox[name=filter_catocca_city]:checked").each(function(){
        catOccaIdArray.push($(this).val());
      });
      $("input:checkbox[name=filter_del_city]:checked").each(function(){
        deliveryIdArray.push($(this).val());
      });


      if($('input[name=filter_del_price]').is(':checked')){
        var pricearray = [];
        $("input:checkbox[name=filter_del_price]:checked").each(function(){
          var price = $(this).val().split("-");
          pricearray.push(price[0]);
          pricearray.push(price[1]);
        });
        var inputPriceRange = [Math.min.apply(Math,pricearray), Math.max.apply(Math,pricearray)];
      } else {
        var inputPriceRange = $('input[name=filter_del_price_default]').val().split("-");
      }

      var data = {
        'action': 'catOccaDeliveryAction',
        cityDefaultUserIdAsString: jQuery("#cityDefaultUserIdAsString").val(),
        delDate: delDate,
        catOccaIdArray: catOccaIdArray,
        deliveryIdArray: deliveryIdArray,
        inputPriceRangeArray: inputPriceRange,
        cityName: cityName,
        postalCode: postalCode
      };
      jQuery.post(ajaxurl, data, function(response) {
        jQuery('.filteredStore').show();
        jQuery('.filteredStore').html(response);
        jQuery('.loadingHeartBeat').hide();

        if(catOccaIdArray.length == 0 && deliveryIdArray.length == 0 && priceChange == 1){
          jQuery('.filteredStore').hide();
          jQuery('#noVendorFound').hide();
        } else if(catOccaIdArray.length == 0 && deliveryIdArray.length == 0 && priceChange == 0){
          jQuery('.filteredStore').hide();
          jQuery('#noVendorFound').hide();
        }

        var state = { 'd': deliveryIdArray, 'c': catOccaIdArray, 'p': inputPriceRange }
        var url = '';
        if(deliveryIdArray.length > 0){
          if(url){ 	url += '&'; }
          url += 'd='+deliveryIdArray;
        }
        if(catOccaIdArray.length > 0){
          if(url){ 	url += '&'; }
          url += 'c='+catOccaIdArray;
        }

        if(inputPriceRange.length > 0){
          if(url){ 	url += '&'; }
          url += 'price='+inputPriceRange;
        }
        if(url.length > 0){
          url = '?'+url;
        }

        if(url){
          history.pushState(state, '', url);
        } else {
          window.history.replaceState({}, '', location.pathname);
        }
      });
    }

    // Filter badges on the vendor page.
    function setFilterBadgeCity(label, id, dataRemove){
      const elm = document.createElement('div');
      elm.id = 'filter'+dataRemove;
      elm.classList.add('badge', 'rounded-pill', 'border-yellow', 'py-2', 'pe-2', 'my-1', 'me-1', 'text-dark', 'dynamic-filters');
      elm.href = '#';
      elm.innerHTML = label;

      const elmbtn = document.createElement('button');
      elmbtn.type = 'button';
      elmbtn.classList.add('btn-close', 'filter-btn-delete', 'ms-1');
      elmbtn.dataset.filterId = id;
      var useableLabel = label.replace(/ /g,'').replace(/(?:\r\n|\r|\n)/g,'').replace(/\./g,'');
      elmbtn.dataset.label = useableLabel;

      elmbtn.onclick = function(){removeFilterBadgeCity('"'+useableLabel+'"', id, dataRemove, true);};
      elmbtn.dataset.filterRemove = dataRemove;
      elm.appendChild(elmbtn);

      jQuery('div.filter-list').prepend(elm);
    }
    function removeFilterBadgeCity(label, id, dataRemove, updateVendors){
      jQuery('#filter'+dataRemove).remove();

      // Check if dataRemove is delivery date, then erase checks and check the defauls.
      if (dataRemove.includes("filter_delivery_date")){
        jQuery("input#filter_delivery_date_8").prop('checked',true);
        jQuery('#'+dataRemove).prop('checked',false);
      }

      if(updateVendors === true){
        var elmId = dataRemove;
        document.getElementById(elmId).checked = false;
        update();
      }
    }

    // reset filter
    $('#cityPageReset').click(function(){
      $("input:checkbox[name=filter_catocca_city]").removeAttr("checked");
      $("input:checkbox[name=filter_del_city]").prop('checked',true);
      $("input#filter_delivery_date_8").prop('checked',true);
      //catOccaDeliveryIdArray.length = 0;

      $('div.filter-list div.dynamic-filters').remove();

      setFilterBadgeCity('Personlig levering fra lokal butik', 'filterfilter_delivery_1', 'filter_delivery_1');
      setFilterBadgeCity('Forsendelse med fragtfirma', 'filterfilter_delivery_0', 'filter_delivery_0');

      //$(this).data('reset-to-default', '1');

      update();
    });

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

    jQuery(".modalBtn").click(function(){
      var uncollapseItem = jQuery(this).data('cd-open');

      jQuery('.collapse.show').removeClass('show');
      jQuery('#'+uncollapseItem).addClass('show');

      jQuery('div.modal-body a.collapse-btn').attr("aria-expanded","false");
      jQuery('*[aria-controls="'+uncollapseItem+'"]').attr("aria-expanded","true");
    });
  });
</script>
