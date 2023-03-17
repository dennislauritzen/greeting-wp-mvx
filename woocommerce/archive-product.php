<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;


global $woocommerce, $wpdb, $WCMp;

$postId = get_the_ID();

$checkout_postalcode = WC()->customer->get_shipping_postcode();
#if($cityPostalcode != $checkout_postalcode){
  #print 'postnumre afviger';
#  $woocommerce->cart->empty_cart();
#}


// Get header designs.
get_header();
get_header('green', array());

$delivery_zip_chosen = (isset($args['delivery_zip_chosen']) ? $args['delivery_zip_chosen'] : '');

global $wp_query;
$cat = $wp_query->get_queried_object();
if (isset($cat->term_id)) {
	$thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
	$image = wp_get_attachment_url($thumbnail_id);
}


/**
 *
 * Data of the category
 *
 */
$cat = $wp_query->get_queried_object();
$category_id = $cat->term_id;
$category_name = $cat->name;
$category_name_plural = get_field('name_plural', 'category_'.$category_id);
$category_slug = $cat->slug;
$category_title = (empty(get_field('header_h1', 'category_'.$category_id)) ? get_the_title() : get_field('header_h1', 'category_'.$category_id));
$category_subtitle = (!empty(get_field('header_top_h2', 'category_'.$category_id)) ? get_field('header_top_h2', 'occasion_'.$category_id) : 'Butikker, der kan levere gaver, som er '.strtolower(str_replace(array('sgave','gave'),array('',''),$category_name)) );
$category_bottomtitle = (!empty(get_field('header_h2', 'category_'.$category_id)) ? get_field('header_h2', 'occasion_'.$category_id) : 'Skal du sende en gave i anledning af '.strtolower(str_replace(array('sgave','gave'),array('',''),$category_name)).'?');
$filtering_title = 'Filtrér butikker';
if(!empty($category_name_plural)){
	$filtering_title .= ', der kan levere '.$category_name_plural;
}


$args = array(
    'post_type' => 'product',
		'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $category_id,
        ),
    ),
);

// Create a new instance of WP_Query
$query = get_posts( $args );

// Get an array of unique user IDs who are authors of the products in the query results
$authors = array_unique( wp_list_pluck( $query, 'post_author' ) );

// Get an array of user objects based on the unique user IDs
$user_args = array(
		'role' => 'dc_vendor',
    'include' => $authors,
		'posts_per_page' => -1,
		'fields' => 'all',
		'meta_key' => 'delivery_type',
    'orderby' => 'meta_value',
    'order' => 'DESC'
);
$user_query = new WP_User_Query( $user_args );
$vendor_arr = $user_query->get_results();



$UserIdArrayForCityPostalcode = array();
$DropOffTimes = array();
foreach($vendor_arr as $v){
	# Get the vendor ID
	$vendor_id = (isset($v->data) ? $v->data->ID : $v->ID);

	# Add ID to arrya and get vendors user meta
	$UserIdArrayForCityPostalcode[] = $vendor_id;
	$days = get_user_meta($vendor_id, 'require_delivery_day');
	$hours = get_user_meta($vendor_id, 'dropoff_time');

	# If 0 days for delivery, then
	if($days == 0){
		$DropOffTimes[] = (int) strstr($hours,':',true);
	}
}

// The maximum dropoff time today - for filtering.
$DropOffTimes = (count($DropOffTimes) > 0) ? max($DropOffTimes) : 0;


// pass to backend
$categoryDefaultUserIdAsString = implode(",", $UserIdArrayForCityPostalcode);

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

	$sql = "
      SELECT meta_value
      FROM {$wpdb->postmeta}
      WHERE meta_key = '_price'
      AND post_id IN (".implode(', ', array_fill(0, count($vendorProductIds), '%s')).")
  ";
  $prices = $wpdb->prepare($sql, $where);

  $prices = $wpdb->get_results($prices);
  // Convert the results to an array of prices
  $priceArray = array();
  foreach ($prices as $price) {
      $priceArray[] = $price->meta_value;
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
<input type="hidden" name="_hid_cat_id" id="_hid_cat_id" value="<?php echo $category_id; ?>">
<input type="hidden" name="_hid_default_user_id" id="categoryDefaultUserIdAsString" value="<?php echo $categoryDefaultUserIdAsString; ?>">

<!-- Filter content -->
<div id="categorycontent" class="container">
	<div class="row">
		<div class="col-12 mt-3">
			<?php
			/**
			 * Hook: woocommerce_before_main_content.
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20 - removed
			 * @hooked WC_Structured_Data::generate_website_data() - 30
			 */
			#do_action('woocommerce_before_main_content');
			?>
		</div>
	</div>
	<div class="row">
		<div class="row">
      <div class="col-12">
        <h1 class="d-block my-0 my-xs-2 my-sm-1 my-md-1 mt-2 mt-lg-2 pt-lg-1 mb-lg-1" style="font-family: Rubik;">
					<?php print $category_title; ?>
				</h1>
			</div>
		</div>
	</div>
	<div class="row main-and-filter-content" style="display: none;">
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
      tt.taxonomy IN ('occasion')
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
        <h3 class="mt-1" style="font-family: Inter; font-size: 17px;">
					Anledninger
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
              <a href="<?php echo get_permalink().'?c='.$occasion->term_id; ?>" data-elm-id="<?php echo $category_or_occasion.$occasion->term_id; ?>" class="top-category-occasion-list stretched-link text-dark">
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
	  </div> <!-- .topoccasions end -->
    <?php
    } // end count.
    ?>

		<!-- FILTER START -->
		<div class="col-12 py-0 my-4 mb-3">
			<h5 style="font-family: Inter;">
				<?php echo $filtering_title; ?>
			</h5>
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
		<!-- 	FILTER END -->
		<!-- Filtered stores START -->
		<div class="row">
			<div class="col-12 mb-2">
				<h2 class="my-3 my-xs-3 my-sm-3 my-md-3 my-lg-2 my-xl-2 mt-lg-4 mt-xl-4">
					<?php echo $category_subtitle; ?>
				</h2>
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
						<a href="#" id="cityPageReset" onclick="event.preventDefault();" class="badge rounded-pill border-yellow py-2 pe-2 my-1 my-lg-0 my-xl-0 mb-1 bg-yellow text-white">
							Nulstil alle
							<button type="button" class="btn-close  btn-close-white" aria-label="Close">
							</button>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="filteredStore row">

		</div>
		<!-- Filtered stores END -->
	</div><!-- .row end -->

	<!-- MAIN CONTENT: POSTAL CODE -->
	<!-- Postal code search box START -->
	<div class="row">
		<div class="row pc-form-content" style="display: block;">
			<div class="col-12 col-md-8 offset-md-2 bg-teal-front position-relative start-0 top-0">
					<div class="pt-3 pb-4 px-1 px-xs-1 px-sm-1 px-md-2 px-lg-5 px-xl-5 m-5 top-text-content">
							<h4 class="text-teal pt-4 fs-6">#STØTLOKALT #<?php echo strtoupper($category_name); ?> #GAVER</h4>
							<h3 class="text-white pb-1">Indtast postnummer</h3>
							<p class="text-white pb-3">
								For at vise dig butikker, der kan levere <?php echo strtolower($category_name); ?> gaver, er vi nødt til først at spørge om, hvilket postnummer, du gerne vil have leveret til?
							</p>
							<p></p>
							<script type="text/javascript">
							//set responsive mobile input field placeholder text
							if (jQuery(window).width() < 769) {
									jQuery("input#front_Search-new_ucsa").attr("placeholder", "By eller postnr. (eks. <?php echo (!empty($user_postal) ? $user_postal : '8000'); ?>)");
							}
							else {
									jQuery("input#front_Search-new_ucsa").attr("placeholder", "Indtast by eller postnr. (eks. <?php echo (!empty($user_postal) ? $user_postal : '8000'); ?>)");
							}
							jQuery(window).resize(function () {
									if (jQuery(window).width() < 769) {
											jQuery("input#front_Search-new_ucsa").attr("placeholder", "By eller postnr. (eks. <?php echo (!empty($user_postal) ? $user_postal : '8000'); ?>)");
									}
									else {
											jQuery("input#front_Search-new_ucsa").attr("placeholder", "Indtast by eller postnr. (eks. <?php echo (!empty($user_postal) ? $user_postal : '8000'); ?>)");
									}
							});
							</script>
							<form role="search" method="get" autocomplete="off" id="lp-searchform">
							<div class="input-group pb-4 w-100 me-0 me-xs-0 me-sm-0 me-md-0 me-lg-5 me-xl-5">
								<input type="text" name="keyword_catocca" id="front_Search-new_ucsa2" class="form-control border-0 ps-5 pe-3 py-3 shadow-sm rounded" placeholder="Indtast by eller postnr. (eks. <?php echo (!empty($user_postal) ? $user_postal : '8000'); ?>)">
								<figure class="position-absolute mt-2 mb-3 ps-3" style="padding-top:5px; z-index:1000;">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#333333" class="bi bi-geo-alt" viewBox="0 0 16 16">
										<path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
										<path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
									</svg>
								</figure>
								<button type="submit" class="d-sm-block d-md-none btn bg-yellow text-white ms-3 px-4 rounded">
									Gem
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
										<path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
									</svg>
								</button>
								<button type="submit" class="d-none d-md-block btn bg-yellow text-white ms-3 px-4 rounded">
									Gem
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
										<path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
									</svg>
								</button>
								<ul id="lp-datafetch_wrapper" class="d-inline list-group position-relative recommandations position-absolute list-unstyled rounded w-75 bg-white" style="top: 57px; ">

								</ul>
								</div>
							</form>
							<h6 style="font-family: 'Rubik',sans-serif; font-size:18px; color: #ffffff;" class="pb-1">Måske følgende byer<?php if(!empty($user_postal)){ echo ' tæt på dig'; } ?> kunne være relevante?</h6>
							<ul id="lp-postalcodelist" class="list-inline my-1">

							</ul>
					</div>
			</div>
		</div>
	</div><!-- .row end -->
	<!-- Postal code search box END -->


	<!-- Loading heartbeat START -->
	<?php get_template_part('template-parts/inc/blocks/loading-heartbeat'); ?>
	<!-- Loading heartbeat END -->


	<!-- Category description -->
	<?php
	if( category_description($category_id) ){
	?>
	<div class="description row">
		<div class="col-12 mt-5">
			<h2 style="font-family: 'MS Trebuchet', 'Rubik', 'Inter',sans-serif;">
				<?php echo get_field('header_h2', 'category_'.$category_id); ?>
			</h2>
			<?php echo category_description($category_id); ?>
		</div>
	</div>
	<?php
	}
	?>
	<!-- Category description END -->
	<!-- MAIN CONTENT END -->
</div><!-- .container end -->
<!-- BOTTOM CONTENT AND SCRIPT -->
<?php

get_template_part('template-parts/inc/blocks/press-mentions');
get_template_part('template-parts/inc/blocks/how-it-works');
get_template_part('template-parts/inc/blocks/learn-more');

get_footer( );
?>

		<script type="text/javascript">
		  // Start the jQuery
		  jQuery(document).ready(function($) {
		    jQuery('#filterdel_dummy_0, #filterdel_dummy_1').remove();

				// Check for clicks for setting postal codes
				jQuery("a.lp-recomms-link").on('click', function(event) {
					event.preventDefault();

					var this_link_postal = this.getAttribute("data-postal");
					var this_link_city = this.getAttribute("data-city");
					var this_link_citylink = this.getAttribute("data-city-link");

					addToLocalStorage('postalcode', this_link_postal);
					addToLocalStorage('city', this_link_city);
					addToLocalStorage('city_link', this_link_citylink);

					check_for_postalcode();
				});

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
		         jQuery('#filter_delivery_' + id).prop('checked', true);
		       });
		     }

		     // Check category and occasion filters
		     if (catOccaDeliveryIdArray) {
		       catOccaDeliveryIdArray.forEach(function(id) {
		         var input = jQuery('#filter_cat' + id + ', #filter_occ_' + id);
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
		    jQuery('a.top-category-occasion-list').click(function(event) {
		      event.preventDefault();
		      var elmId = this.getAttribute("data-elm-id");
		      jQuery('#filter_' + elmId).click();

		      jQuery('html, body').animate({
		        scrollTop: jQuery('h2').offset().top
		      }, 0);
		    });



				// Get the stores.
		    jQuery(".filter-on-city-page").click(function(){
		      update();

		      if(this.type == "radio"){
		        var id = this.id;
		        var id2 = id.replace(/[0-9]+/, "");
		        jQuery("div[id*='"+id2+"']").remove();
		      }

		      if(this.checked){
		        setFilterBadgeCity(
		          jQuery('label[for='+this.id+']').text(),
		          this.value,
		          this.id
		        );
		      } else {
		        if (this.id.includes("filter_delivery_date")){
		          jQuery("input#filter_delivery_date_8").prop('checked',true);
		        }
		        removeFilterBadgeCity(
		          jQuery('label[for='+this.id+']').text(),
		          this.value,
		          this.id,
		          false
		        );
		      }

		    });

				// Perform an update function call on initiazion
		    update();


		    // reset filter
		    jQuery('#cityPageReset').click(function(){
		      jQuery("input:checkbox[name=filter_catocca_city]").removeAttr("checked");
		      jQuery("input:checkbox[name=filter_del_city]").prop('checked',true);
		      jQuery("input#filter_delivery_date_8").prop('checked',true);
		      //catOccaDeliveryIdArray.length = 0;

		      jQuery('div.filter-list div.dynamic-filters').remove();

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

				// Get IP data to get close postals.
				var ip = '';
			  jQuery.get('https://ipapi.co/postal/', function(ip_data){
			    ip = ip_data;

			    jQuery.ajax({
			      url: '<?php echo admin_url('admin-ajax.php'); ?>',
			      type: 'post',
			      data: { action: 'get_featured_postal_codes', postal_code: ip },
			      beforeSend: function(){
			        if(ip == null){
			          currentRequest.abort();
			        }
			      },
			      success: function(data) {
			        data_arr = jQuery.parseJSON(data);

			        if(data_arr.length > 0){
			          jQuery.each(data_arr, function(k, v) {
			            var link = v.link;
			            var postal = v.postal;
			            var city = v.city;

			            var div_elm = jQuery("<li>", {"class": "list-inline-item pb-1 me-0 ms-0 pe-1"});
									var card_link = jQuery("<a>",{"class": "ip-recomms-link btn btn-link rounded-pill pb-2 border-1 border-white text-white",
																								"href": "#",
																								"data-postal": postal,
																								"data-city": city,
																								"data-city-link": link}).text(postal+' '+city).css('font-size','15px');
			            div_elm.append(card_link);

			            jQuery("ul#lp-postalcodelist").append(div_elm);
			          });


								// Check for clicks for setting postal codes
								jQuery("a.ip-recomms-link,a.ip-recomms-link").on('click', function(event) {
									event.preventDefault();

									var this_link_postal = this.getAttribute("data-postal");
									var this_link_city = this.getAttribute("data-city");
									var this_link_citylink = this.getAttribute("data-city-link");

									addToLocalStorage('postalcode', this_link_postal);
									addToLocalStorage('city', this_link_city);
									addToLocalStorage('city_link', this_link_citylink);

									check_for_postalcode();
								});
			        }
			      }
			    });
				});
		  });
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

				if(id !='filterpostalcode_id'){
					elmbtn.onclick = function(){removeFilterBadgeCity('"'+useableLabel+'"', id, dataRemove, true);};
				}
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

			function update(){
				var ajaxurl = "<?php echo admin_url('admin-ajax.php');?>";

				var cityName = window.localStorage.getItem('city');
				var postalCode = window.localStorage.getItem('postalcode');

				if(!cityName || !postalCode){
					return;
				}

				var categoryId = jQuery("#_hid_cat_id").val();
				catOccaIdArray = [];
				deliveryIdArray = [];
				inputPriceRangeArray = [];

				// Make the loading...
				jQuery('.loadingHeartBeat').show();
				jQuery('#defaultStore').hide();
				jQuery('.filteredStore').hide();

				// Chosen delivery date
				var delDate = jQuery('input[name=filter_del_days_city]:checked').val();

				jQuery("input:checkbox[name=filter_catocca_city]:checked").each(function(){
					catOccaIdArray.push(jQuery(this).val());
				});
				//catOccaIdArray.push(categoryId);
				jQuery("input:checkbox[name=filter_del_city]:checked").each(function(){
					deliveryIdArray.push(jQuery(this).val());
				});


				if(jQuery('input[name=filter_del_price]').is(':checked')){
					var pricearray = [];
					jQuery("input:checkbox[name=filter_del_price]:checked").each(function(){
						var price = jQuery(this).val().split("-");
						pricearray.push(price[0]);
						pricearray.push(price[1]);
					});
					var inputPriceRange = [Math.min.apply(Math,pricearray), Math.max.apply(Math,pricearray)];
				} else {
					var inputPriceRange = jQuery('input[name=filter_del_price_default]').val().split("-");
				}

				var data = {
					'action': 'categoryAndOccasionVendorFilterAction',
					cityDefaultUserIdAsString: jQuery("#categoryDefaultUserIdAsString").val(),
					delDate: delDate,
					catOccaIdArray: catOccaIdArray,
					deliveryIdArray: deliveryIdArray,
					inputPriceRangeArray: inputPriceRange,
					cityName: cityName,
					postalCode: postalCode
				};
				jQuery.post(ajaxurl, data, function(response) {
					jQuery('#defaultStore').hide();
					jQuery('.filteredStore').show();
					jQuery('.filteredStore').html(response);
					jQuery('.loadingHeartBeat').hide();

					if(catOccaIdArray.length == 0 && deliveryIdArray.length == 0 && priceChange == 1){
						jQuery('#defaultStore').show();
						jQuery('.filteredStore').hide();
						jQuery('#noVendorFound').hide();
					} else if(catOccaIdArray.length == 0 && deliveryIdArray.length == 0 && priceChange == 0){
						jQuery('#defaultStore').show();
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
		</script>
		<!-- Loading and showing the content Javascript -->
		<script type="text/javascript">
		// @todo - listen to the localStorage - if there is a postalcode all ready, then lets just use that. Else show formula.
		function addToLocalStorage(key, val) {
		  window.localStorage.setItem(key, val);
		}

		function check_for_postalcode(){
			const get_postalcode = window.localStorage.getItem('postalcode');
			const get_city = window.localStorage.getItem('city');
			const get_pc_link = window.localStorage.getItem('city_link');

			const mainAndFilterContent = document.querySelector('.main-and-filter-content');
			const pcFormContent = document.querySelector('.pc-form-content');

			if (mainAndFilterContent || pcFormContent) {
				if (get_postalcode && get_city) {
					mainAndFilterContent.style.display = 'block';
					pcFormContent.style.display = 'none';


					setFilterBadgeCity(
						get_postalcode+' '+get_city,
						'postalcode_page'+get_postalcode,
						'postalcode_id'
					);

					update();
				} else {
					mainAndFilterContent.style.display = 'none';
					pcFormContent.style.display = 'block';
				}
			}
		}

		document.addEventListener('DOMContentLoaded', function() {
			check_for_postalcode();
		});

		// If you delete postal code
		jQuery(document).on('click', "#filterpostalcode_id button.btn-close", function(){
			jQuery(this).remove();
			window.localStorage.removeItem('city');
			window.localStorage.removeItem('postalcode');

			check_for_postalcode();
		});
		jQuery(document).on('click', '#lp-datafetch_wrapper a', function(event) {
			event.preventDefault();

			var this_link_postal = this.getAttribute("data-postal");
			var this_link_city = this.getAttribute("data-city");
			var this_link_citylink = this.getAttribute("data-city-link");

			addToLocalStorage('postalcode', this_link_postal);
			addToLocalStorage('city', this_link_city);
			addToLocalStorage('city_link', this_link_citylink);

			check_for_postalcode();
		});
		</script>
		<!-- BOTTOM END -->

<?php
get_footer('shop');
