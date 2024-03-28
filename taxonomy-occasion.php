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


global $woocommerce, $wpdb, $MVX, $wp_query;

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

global ;

/**
 *
 * Data of the category
 *
 */
$cat = $wp_query->get_queried_object();
if (isset($cat->term_id)) {
	$thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
	$image = wp_get_attachment_url($thumbnail_id);
}

$category_id = $cat->term_id;
$category_name = $cat->name;
$category_slug = $cat->slug;
$category_name_plural = get_field('name_plural', 'occasion_'.$category_id);
$category_title = (!empty(get_field('header_h1', 'occasion_'.$category_id)) ? get_field('header_h1', 'occasion_'.$category_id) : $category_name);
$category_subtitle = (!empty(get_field('header_top_h2', 'occasion_'.$category_id)) ? get_field('header_top_h2', 'occasion_'.$category_id) : 'Butikker, der kan levere i anledning af '.strtolower(str_replace(array('sgave','gave'),array('',''),$category_name)) );
$category_bottomtitle = (!empty(get_field('header_h2', 'occasion_'.$category_id)) ? get_field('header_h2', 'occasion_'.$category_id) : 'Skal du sende en gave i anledning af '.strtolower(str_replace(array('sgave','gave'),array('',''),$category_name)).'?');
$filtering_title = 'Filtrér butikker';
if(!empty($category_name_plural)){
	$filtering_title .= ', der kan levere '.$category_name_plural;
}

// Get the products connected to this category/occasion.
$args = array(
    'post_type' => 'product',
		'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'occasion',
            'field' => 'term_id',
            'terms' => array($category_id)
        ),
    ),
);

// Create a new instance of WP_Query
$query = new WP_Query( $args );

// Get an array of unique user IDs who are authors of the products in the query results
$authors = array_unique( wp_list_pluck( $query->posts, 'post_author' ) );

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
		<div class="row">
             <div class="col-12">
                <h1 class="d-block my-0 my-xs-2 my-sm-1 my-md-1 mt-4 mt-lg-5 pt-lg-1 mb-lg-1" style="font-family: Rubik;">
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
      tt.taxonomy IN ('product_cat')
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
get_footer('shop');
