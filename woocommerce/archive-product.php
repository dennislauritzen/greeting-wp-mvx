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

#$checkout_postalcode = WC()->customer->get_shipping_postcode();
#if($cityPostalcode != $checkout_postalcode){
#print 'postnumre afviger';
#  $woocommerce->cart->empty_cart();
#}

// Get header designs.
get_header();
get_header('green', array());

$delivery_zip_chosen = (isset($args['delivery_zip_chosen']) ? $args['delivery_zip_chosen'] : '');

/**
 * Data of the category
 */
$cat = $wp_query->get_queried_object();
if (isset($cat->term_id)) {
    $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
    $image = wp_get_attachment_url($thumbnail_id);
}

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

// Retrieve unique author (vendor) IDs and prices of products directly from the database using a custom SQL query
$sql = "
    SELECT p.post_author AS author_id, pm.meta_value AS price
    FROM {$wpdb->posts} p
    INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
    INNER JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
    INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
    WHERE p.post_type = 'product'
    AND p.post_status = 'publish'
    AND tt.taxonomy = 'product_cat'
    AND tt.term_id = %d
    AND pm.meta_key = '_price'
";
$sql = $wpdb->prepare($sql, $category_id);

// Execute the SQL query
$results = $wpdb->get_results($sql);

// Initialize arrays
$authors = array();
$priceArray = array();

// Extract unique author IDs and prices
foreach ($results as $result) {
    $authors[] = $result->author_id;
    $priceArray[] = $result->price;
}

// Deduplicate author IDs and prices
$authors_new = array_unique($authors);

// Get an array of user objects based on the unique user IDs
$user_args = array(
    'role' => 'dc_vendor',
    'include' => $authors,
    'posts_per_page' => -1,
    'fields' => 'all_with_meta',
    'meta_key' => 'delivery_type',
    'orderby' => 'meta_value',
    'order' => 'DESC'
);
$user_query = new WP_User_Query( $user_args );
$vendor_arr = $user_query->get_results();

// Initialize arrays
$UserIdArrayForCityPostalcode = wp_list_pluck($vendor_arr, 'ID'); // Extract vendor IDs

// Filter vendors where require_delivery_day is equal to 0
$filtered_vendors = array_filter($vendor_arr, function($vendor) {
    return $vendor->require_delivery_day == 0;
});

// Extract dropoff times for filtered vendors
$dropoff_times = array_map(function($vendor) {
    return (int) strstr($vendor->dropoff_time, ':', true);
}, $filtered_vendors);

// Get the maximum dropoff time
$max_dropoff_time = !empty($dropoff_times) ? max($dropoff_times) : 0;


// pass to backend
$categoryDefaultUserIdAsString = implode(",", $UserIdArrayForCityPostalcode);


/////////////////////////
// ######################
// Data for the filtering.
// This data is used for the filters and for the stores.
// It is also used for the featuring of categories and occasions in the top.
$productPriceArray = array(); // for price filter
$categoryTermListArray = array(); // for cat term filter
$occasionTermListArray = array();

// FILTERING FOR PRICES
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

// Use min and max to get the minimum and maximum prices
$minPrice = min($priceArray);
$maxPrice = max($priceArray);

// Use array_push to add the prices to the $productPriceArray
array_push($productPriceArray, $minPrice, $maxPrice);

// FILTERING FOR CATS AND OCCASIONS
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
<div id="categorycontent">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="d-block my-xs-3 my-sm-2 my-md-2 mt-3 mt-lg-4 pt-lg-3 mb-lg-3">
                    <?php print $category_title; ?>
                </h1>
            </div>
        </div>
        <div class="row main-and-filter-content" style="display: none;">
            <?php
            // get user meta query
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
                  tt.taxonomy = 'occasion'
                ORDER BY
                  CASE featured
                    WHEN 2 THEN 2
                    WHEN 1 THEN 1
                    ELSE 0
                  END DESC,
                  t.Name ASC
            ");

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
                    $dates[8] = 'Vis alle (inkl. senere) datoer';

                    ?>

                    <div class="rounded-3 mb-4">
                        <?php
                        foreach($dates as $k => $v){
                            $closed_for_today = 0;
                            if($k == 0 && $max_dropoff_time <= date("H")){
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
            <div class="col-12 py-0 my-4 mb-5">
                <div class="datepicking">
                    <div class="text">
                        Hvor skal gaven leveres?
                    </div>
                    <div id="filterpostalcode_id" class="rounded border-0 rounded-pill datelabel-bg" style="display: inline-block; margin: 5px 5px 4px 0; font-size: 13px;">
                        <label class="datelabel">
                            <span class="text">
                            </span>
                            <button class="btn-close"></button>
                        </label>
                    </div>
                </div>
            </div>

		<!-- Filtered stores START -->
		<!--<div class="row">
			<div class="col-12 mb-2">
				<h2 class="my-3 my-xs-3 my-sm-3 my-md-3 my-lg-2 my-xl-2 mt-lg-4 mt-xl-4">
					<?php echo $category_subtitle; ?>
				</h2>
			</div>
		</div>-->
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
        <section id="description" class="description row lp-content-block mt-5 mb-5 pb-4">
            <div class="description lp-content-block row">
                <div class="col-12">
                    <h2 style="font-family: 'Inter', 'Rubik', sans-serif; font-size: 29px; font-weight: 600;">
                        <?php echo get_field('header_h2', 'category_'.$category_id); ?>
                    </h2>
                    <div style="position: relative;">
                        <div id="categoryDescription" style="max-height: 400px; overflow: hidden;">
                            <?php
                            $description = category_description($category_id);
                            $description = add_links_to_keywords(
                                wp_kses_post( $description ),
                                array('product_cat', 'occasion')
                            );
                            $collapsed = false;

                            // Check if the content exceeds the max-height
                            if (strlen($description) > 300) {
                                $collapsed = true;
                            }

                            echo '<div class="short_description">';
                            echo $description;
                            echo '</div>';

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
                                height: 50%;
                                background: linear-gradient(to bottom, rgba(255, 255, 255, 0.33) 25%, rgba(255, 255, 255, 1) 100%);
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


        <?php
	}
	?>
	<!-- Category description END -->
	<!-- MAIN CONTENT END -->
    </div>
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


    jQuery("#lp-searchform").submit(function(event){
        event.preventDefault();
        var hid_pc_link = '';
        if(document.getElementById('hidden__s_link')){
            hid_pc_link = document.getElementById('hidden__s_link').value;
        }
        var val = jQuery("#lp-datafetch_wrapper li.lp-recomms:first-child a").prop('href');

        var firstAnchor = jQuery("#lp-datafetch_wrapper li.lp-recomms:first-child a").get(0);

        var this_link_postal =  firstAnchor.getAttribute("data-postal");
        var this_link_city =  firstAnchor.getAttribute("data-city");
        var this_link_citylink =  firstAnchor.getAttribute("data-city-link");

        addToLocalStorage('postalcode', this_link_postal);
        addToLocalStorage('city', this_link_city);
        addToLocalStorage('city_link', this_link_citylink);

        check_for_postalcode();
    });

    var ajaxurl = "<?php echo admin_url('admin-ajax.php');?>";
    var catOccaDeliveryIdArray = [];
    var inputPriceRangeArray = [];
    var deliveryIdArray = [];


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



    // Perform an update function call on initiazion
    update();

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

                jQuery('#filterpostalcode_id span.text').text(this_link_postal+' '+this_link_city);

                check_for_postalcode();
            });
        }
      }
    });
    });
});

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

    var data = {
        action: 'categoryAndOccasionVendorFilterAction',
        cityDefaultUserIdAsString: jQuery("#categoryDefaultUserIdAsString").val(),
        delDate: delDate,
        catOccaIdArray: catOccaIdArray,
        cityName: cityName,
        postalCode: postalCode
    };
    jQuery.post(ajaxurl, data, function(response) {
        jQuery('#defaultStore').hide();
        jQuery('.filteredStore').show();
        jQuery('.filteredStore').html(response);
        jQuery('.loadingHeartBeat').hide();
    });
}
		</script>
		<!-- Loading and showing the content Javascript -->
<script type="text/javascript">
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
            jQuery('#filterpostalcode_id span.text').text(get_postalcode+' '+get_city);

            mainAndFilterContent.style.display = 'block';
            pcFormContent.style.display = 'none';

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
    window.localStorage.removeItem('city');
    window.localStorage.removeItem('postalcode');

    jQuery('#filterpostalcode_id span.text').text('');

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
</script>
<!-- BOTTOM END -->

<?php
get_footer('shop');
