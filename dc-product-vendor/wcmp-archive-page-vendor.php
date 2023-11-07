<?php
defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: wcmp_before_main_content.
 *
 */

do_action( 'wcmp_before_main_content' );

global $WCMp;
global $product;

?>
<?php
/**
 * Hook: wcmp_archive_description.
 *
 */
do_action( 'wcmp_archive_description' );
?>



<?php

/**
 * Hook: wcmp_store_tab_contents.
 *
 * Output wcmp store widget
 */

// do_action( 'wcmp_store_tab_widget_contents' );
/** amdad write custom code begin */
?>
<?php
// Get vendor
$vendorId = wcmp_find_shop_page_vendor();
$vendor = get_wcmp_vendor($vendorId);

$del_type = '';
$del_value = '';
if(!empty(get_field('delivery_type', 'user_'.$vendorId))){
  $delivery_type = get_field('delivery_type', 'user_'.$vendorId)[0];

  if(empty($delivery_type['label'])){
    $del_value = $delivery_type;
    $del_type = $delivery_type;
  } else {
    $del_value = $delivery_type['value'];
    $del_type = $delivery_type['label'];
  }
}

$productIdArray = array();
$vendorProducts = $vendor->get_products(array('fields' => 'ids'));

if(!empty($args['city']) && !empty($args['postalcode'])){
  $city_search_val = $args['postalcode'] . ' ' . $args['city'];
} else {
  $city_search_val = '';
}
?>
<section id="backbutton" class="mb-3 mt-1">
  <div class="container">



  </div>
</section>

<section id="products_shop">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-8 py-0 my-4 mb-3">
        <h5 style="font-family: Inter;">Filtrér produkter &amp; find den rigtige gave</h5>
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
      <div class="col-lg-4 col-12 my-lg-4 pt-2 pt-lg-4 align-items-center order-first order-lg-last" id="backbutton_city__" style="display: none;">
        <?php
        $display = !empty($city_search_val) ? 'block' : 'none';
        ?>
        <div class="pt-lg-2">
          <a class="text-dark btn btn-secondary bg-light-grey float-lg-end fs-6" style="border-color: #a0a0a0;" id="backbutton_city_a_link__">< Gå tilbage til <?php echo $city_search_val; ?></a>
        </div>
        <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
          var postalcode2 = localStorage.getItem('postalcode');
          var city2 = localStorage.getItem('city');
          var city2_link = localStorage.getItem('city_link');

          if (postalcode2 && city2) {
            document.getElementById('backbutton_city_a_link__').innerHTML += '' + postalcode2 + " " + city2 + '';
            document.getElementById('backbutton_city_a_link__').href = city2_link;
            document.getElementById('backbutton_city__').style.display = "block";
          }
          });
        </script>
      </div>
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
            <input type="hidden" name="guid" id="guid" value="<?php echo hash('crc32c', $vendor->get_id().'-_-'.($vendor->user_data->user_nicename?:'')); ?>">
            <input type="hidden" name="nn" id="nn" value="<?php echo ($vendor->user_data->user_nicename?:''); ?>">
            <input type="hidden" name="gid" id="gid" value="<?php echo $vendor->get_id(); ?>">

            <?php
            /**
             * ---------------------
             * Price filter
             * ---------------------
            **/
            $vendorId = wcmp_find_shop_page_vendor();
            $vendor = get_wcmp_vendor($vendorId);
            $productPriceArray = array();

            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'author' => $vendorId,
                'posts_per_page' => -1,  // Retrieve all products (including variations)
                'meta_query' => array(
                    array(
                        'key' => '_price',
                        'compare' => 'EXISTS',  // Ensure the _price key exists
                    ),
                ),
            );
            $vendorGetProducts = new WP_Query($args);

            // Retrieve prices, including variation prices
            if ($vendorGetProducts->have_posts()) {
                while ($vendorGetProducts->have_posts()) {
                    $vendorGetProducts->the_post();
                    $product = wc_get_product();

                    $product_id = $product->get_id();
                    $product_prices = array();

                    // Get the base product price
                    $price = $product->get_price();

                    if ($price) {
                        $productPriceArray[] = $price;
                    }

                    // Get prices for variations
                    if ($product->is_type('variable')) {
                        $variations = $product->get_available_variations();

                        foreach ($variations as $variation) {
                            $variation_id = $variation['variation_id'];
                            $variation_price = get_post_meta($variation_id, '_price', true);

                            if ($variation_price) {
                                $productPriceArray[] = $variation_price;
                            }
                        }
                    }
                }
            }

            // Restore original Post Data
            wp_reset_postdata();

            $minProductPrice = 0;
            $maxProductPrice = 0;

            if(count($productPriceArray) == 0){
              $minProductPrice = 0;
              $maxProductPrice = 0;
              $topProductPrice = (max($productPriceArray) > 1000) ? 1000 : (int) max($productPriceArray);
            }
            elseif(min($productPriceArray) == max($productPriceArray)){
              $minProductPrice = 0;
              $maxProductPrice = (int) max($productPriceArray);
              $topProductPrice = (max($productPriceArray) > 1000) ? 1000 : (int) max($productPriceArray);
            }
            else {
              $minProductPrice = 0;
              $maxProductPrice = (int) max($productPriceArray);
              $topProductPrice = (max($productPriceArray) > 1000) ? 1000 : (int) max($productPriceArray);
            }

            $priceIntArray = ($maxProductPrice > 250 ? range($minProductPrice, $topProductPrice, 250) : array(0) );

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
                  if($k == 0 && $end == '+'){
                      $label = 'Under 250';
                      $value = '0-250';
                  } else
                  if($end == '+' && $k > 0){
                    $label = 'Over '.$start;
                    $value = $start.'-'.$maxProductPrice;
                  } else {
                    if($start == "0"){
                      $label = 'Under '.$end;
                    } else {
                      $label = $start.'-'.$end;
                    }
                    $value = $start.'-'.$maxProductPrice;
                  }
                ?>
                <div class="rounded border-0 rounded-pill bg-light" style="display: inline-block; margin: 5px 5px 4px 0; font-size: 13px;">
                  <label class="" for="filter_price_<?php echo $k; ?>" style="cursor: pointer; padding: 6px 10px;">
                    <input type="checkbox" name="filter_del_price" class="form-check-input filter-on-vendor-page" id="filter_price_<?php echo $k; ?>" value="<?php echo $value; ?>">
                    <?php echo $label; ?> kr.
                  </label>
                </div>
                <?php
                }
                ?>
                </div>
              </div>
            </div>

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
            $vendorProducts = $vendor->get_products(array('fields' => 'ids'));
            $categoryTermIds = array();
            foreach ($vendorProducts as $productId) {
                $terms = wp_get_post_terms($productId, 'product_cat', array('fields' => 'ids', 'exclude' => array(15,16)));
                $categoryTermIds = array_merge($categoryTermIds, $terms);
            }
            $categoryTermIds = array_unique($categoryTermIds);
            $categoryTerms = get_terms(array(
                'taxonomy' => 'product_cat',
                'include' => $categoryTermIds,
                'hide_empty' => false,
            ));
            foreach($categoryTerms as $catTerm){
                $categoryTermListArray[$catTerm->term_id] = $catTerm;
            }

            foreach($categoryTermListArray as $category){ ?>
              <div class="form-check" style="overflow: visible;">
                  <input type="checkbox" role="switch" name="filter_cat_vendor" class="form-check-input filter-on-vendor-page" id="filter_cat<?php echo $category->term_id; ?>" value="<?php echo $category->term_id; ?>">
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

            $occasionTermListArray = array();
            // $vendor previously declared and get value from there
            $vendorProducts = $vendor->get_products(array('fields' => 'ids'));
            foreach ($vendorProducts as $productId) {
              $occasionTermList = wp_get_post_terms($productId, 'occasion', array('fields' => 'all'));
              foreach($occasionTermList as $occasionTerm){
                // unique item insert to array
                $uniqueTermId = $occasionTerm->term_id;
                $occasionTermListArray["$uniqueTermId"] = $occasionTerm;
              }
            }

            $vendorProducts = $vendor->get_products(array('fields' => 'ids'));

            // Get all unique occasions for the vendor's products
            $occasions = array();
            foreach ($vendorProducts as $productId) {
                $terms = wp_get_post_terms($productId, 'occasion', array('fields' => 'all'));

                foreach ($terms as $term) {
                    if (!isset($occasions[$term->term_id])) {
                        $occasions[$term->term_id] = $term;
                    }
                }
            }

            foreach($occasions as $occasion){
              ?>
              <div class="form-check">
                  <input type="checkbox" name="filter_occ_vendor" class="form-check-input filter-on-vendor-page" id="filter_occ_<?php echo $occasion->term_id; ?>" value="<?php echo $occasion->term_id; ?>">
                  <label class="form-check-label" for="filter_occ_<?php echo $occasion->term_id; ?>"><?php echo $occasion->name; ?></label>
              </div>
            <?php
            }
            ?>
            </ul>

          </div>
          <div class="modal-footer">
            <button class="btn btn-outline-dark" data-bs-dismiss="modal" aria-label="Close">Luk</button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal">Gem filtre</button>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
			<div class="col-12">
				<div class="applied-filters row mt-xs-0 mt-sm-0 mt-md-0 mb-3 lh-lg">
					<div class="col-12 filter-list"><a class="badge rounded-pill border-yellow py-2 px-2 me-1 my-lg-0 my-xl-0 text-dark filter-static">
            Butik: <?php echo ($vendor->user_data->display_name?:''); ?>
            <button type="button" class="btn-close" aria-label="Close"></button>
            </a><a href="#" id="vendorPageReset" onclick="event.preventDefault();" class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 bg-yellow text-white">
              Nulstil alle
              <button type="button" class="btn-close  btn-close-white" aria-label="Close">
              </button>
            </a>
          </div>
				</div>

				<div id="products" class="row">
				<?php
				// Get vendor
				$vendorId = wcmp_find_shop_page_vendor();
				$vendor = get_wcmp_vendor($vendorId);

				$productIdArray = array();

				$vendorProducts = $vendor->get_products(array('fields' => 'ids'));
				foreach ($vendorProducts as $productId) {
					array_push($productIdArray, $productId);
					$product = wc_get_product( $productId );

          $imageId = $product->get_image_id();
					$uploadedImage = wp_get_attachment_image_url($imageId, 'medium');
          $placeHolderImage = wc_placeholder_img_src('medium');

					$uploadDir = wp_upload_dir();
					$uploadDirBaseUrl = $uploadDir['baseurl'];
					?>
					<div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
						<div class="card mb-4 border-0">
								<a href="<?php echo get_permalink($product->get_id());?>">
								<?php if($uploadedImage != ''){?>
									<img
									src="<?php echo $uploadedImage; ?>"
									class="attachment-shop_catalog size-shop_catalog"
									loading="lazy"
									title="<?php echo $product->get_name();?>"
									class="card-img-top"
									alt="<?php echo $product->get_name();?>">
								<?php } else { ?>
									<img
									src="<?php echo $placeHolderImage;?>"
									class="card-img-top"
									title="<?php echo $product->get_name();?>"
									alt="<?php echo $product->get_name();?>">
								<?php } ?>
								</a>
								<div class="card-body">
										<h6 class="card-title">
											<a href="<?php echo get_permalink($product->get_id());?>" class="text-dark">
												<?php echo $product->get_name();?>
											</a>
										</h6>
										<p class="price"><?php echo woocommerce_template_loop_price();?></p>
										<div class="links" style="display: none;">
											<a href="?add-to-cart=<?php echo $product->get_id();?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" title="Add to cart" data-product_id="<?php echo $product->get_id();?>" data-product_sku="RGD-00010-1" aria-label="Add “Framed Poster” to your cart" rel="nofollow">Add to cart</a>
											<a href="<?php echo get_permalink($product->get_id());?>" class="rigid-quick-view-link" data-id="<?php echo $product->get_id();?>" title="Quick View"><i class="fa fa-eye"></i></a>
										</div>
								</div>
						</div>
					</div>
				<?php
				}
				?>
				</div>
				<!-- show filtered result here-->
				<div id="filteredProduct" class="row">

				</div>
        <div class="loadingHeartBeat row" style="display: none;">
          <div class="loadingcard col-6 col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <div class="card border-0 mb-3">
              <div class="image-large animated-background "></div>
              <div class="card-body">
                <div class="text-line-heading animated-background "></div>
                <div class="text-line-60 animated-background "></div>
                <div class="text-line-100 animated-background "></div>
                <div class="loading-cta animated-background "></div>
              </div>
            </div>
          </div>
          <div class="loadingcard col-6 col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <div class="card border-0 mb-3">
              <div class="image-large animated-background "></div>
              <div class="card-body">
                <div class="text-line-heading animated-background "></div>
                <div class="text-line-60 animated-background "></div>
                <div class="text-line-100 animated-background "></div>
                <div class="loading-cta animated-background "></div>
              </div>
            </div>
          </div>
          <div class="loadingcard col-6 col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <div class="card border-0 mb-3">
              <div class="image-large animated-background "></div>
              <div class="card-body">
                <div class="text-line-heading animated-background "></div>
                <div class="text-line-60 animated-background "></div>
                <div class="text-line-100 animated-background "></div>
                <div class="loading-cta animated-background "></div>
              </div>
            </div>
          </div>
          <div class="loadingcard col-6 col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <div class="card border-0 mb-3">
              <div class="image-large animated-background "></div>
              <div class="card-body">
                <div class="text-line-heading animated-background "></div>
                <div class="text-line-60 animated-background "></div>
                <div class="text-line-100 animated-background "></div>
                <div class="loading-cta animated-background "></div>
              </div>
            </div>
          </div>

        </div>
			</div>
		</div>
	</div>
</section>

<?php $defaultProductIdAsString = implode(",", $productIdArray);?>
<input type="hidden" id="defaultProductIdAsString" value="<?php echo $defaultProductIdAsString;?>">


<?php
// Additional hook after archive description ended
do_action('after_wcmp_vendor_description', $vendorId);

?>
<section id="vendor" class="bg-light-grey py-5 mb-2">
  <div class="container">
    <div class="row">
      <div class="col-lg-2">
		<?php
			$image = $vendor->get_image() ? $vendor->get_image('image', array(125, 125)) : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
		?>
		<img class="d-inline-block pb-3" alt="<?php echo $vendor->user_data->data->display_name; ?>" src="<?php echo esc_attr($image); ?>">
      </div>
      <div class="col-lg-6">
        <h6><?php echo ucfirst(esc_html($vendor->user_data->data->display_name)); ?></h6>
        <p>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#446a6b" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
          </svg>
          <?php
			       $location = get_user_meta($vendorId, '_vendor_address_1', true).', '.get_user_meta($vendorId, '_vendor_postcode', true).' '.get_user_meta($vendorId, '_vendor_city', true);

             if(!empty($location) && $vendorId != "38" && $vendorId != "76"){
               echo esc_html($location);
             } else if($vendorId == "38" || $vendorId == "76"){
               echo 'Leveres fra en fysisk gavebutik, der ligger nær din modtager.';
             }
          ?>
        </p>
        <?php
				$vendor_hide_description = apply_filters('wcmp_vendor_store_header_hide_description', get_user_meta($vendorId, '_vendor_hide_description', true), $vendorId);
				$description = get_user_meta($vendorId, '_vendor_description', true);
				if (!$vendor_hide_description && !empty($description)) { ?>
        <div>
            <?php echo wp_kses_post(htmlspecialchars_decode( wpautop( $description ), ENT_QUOTES )); ?>
        </div>
        <?php } ?>
        <p><a class="text-dark text-decoration-underline" href="<?php echo esc_url($vendor->get_permalink()); ?>">Se hele butikkens gaveudvalg</a><p>
      </div>
      <div class="col-lg-4">
        <?php

        if($del_value == '0'){
          echo "<b>Information om forsendelse</b>";
          echo '<p>'.get_field('freight_company_delivery_text', 'options').'</p>';
        } else {
        ?>
          <b>Leveringsinformationer</b>
          <p>
            <?php
              $opening = get_field('openning', 'user_'.$vendorId);
              $open_iso_days = array();
              $open_label_days = array();
              foreach($opening as $k => $v){
                $open_iso_days[] = (int) $v['value'];
                $open_label_days[$v['value']] = $v['label'];
              }

              $interv = array();
              if(!empty($open_iso_days) && is_array($open_iso_days)){
                $interv = build_intervals($open_iso_days, function($a, $b) { return ($b - $a) <= 1; }, function($a, $b) { return $a."..".$b; });
              } else {
                print 'Butikkens leveringsdage er ukendte';
              }
              $i = 1;

              if(!empty($opening) && !empty($interv) && count($interv) > 0){

                if($del_value == "1"){
                  echo 'Butikken leverer ';
                } else if($del_value == "0"){
                  echo 'Butikken afsender ';
                }

                foreach($interv as $v){
                  $val = explode('..',$v);
                  if(!empty($val)){
                    $start = isset($open_label_days[$val[0]])? $open_label_days[$val[0]] : '';
                    if($val[0] != $val[1])
                    {
                      $end = isset($open_label_days[$val[1]]) ? $open_label_days[$val[1]] : '';
                      if(!empty($start) && !empty($end)){
                        print strtolower($start."-".$end);
                      }
                    } else {
                      print strtolower($start);
                    }
                    if(count($interv) > 1){
                      if(count($interv)-1 == $i){ print " og "; }
                      else if(count($interv) > $i) { print ', ';}
                    }
                  }
                  $i++;
                }
              }
            ?>
          </p>
          <p>
            Butikken leverer senest
            <?php
              if(get_field('vendor_require_delivery_day', 'user_'.$vendorId) == 0)
              {
                echo ' i dag';
              }
                else if(get_field('vendor_require_delivery_day', 'user_'.$vendorId) == 1)
              {
                echo ' i morgen';
              } else {
                echo 'om '.get_field('vendor_require_delivery_day', 'user_'.$vendorId)." hverdage";
              }
            ?>, hvis du bestiller inden kl.
            <?php echo (!empty(get_field('vendor_drop_off_time', 'user_'.$vendor->id)) ? get_field('vendor_drop_off_time', 'user_'.$vendor->id) : '11'); ?>.
          </p>
        <?php
        }
        ?>

      	<?php
        // Get the date string and run the functions.
        $closed_dates = get_field('vendor_closed_day', 'user_'.$vendorId);
				$dates = explode(",",$closed_dates);
				$viable_dates = array();

        // Run the dates.
        $str = $closed_dates;
        $result = groupDates($str);

        if(count($result) > 0 && !empty($closed_dates))
        {
          $today = date("U");
          $list = '';
          foreach($result as $v){
            if(
                (null !== $v[0] && strtotime($v[0]) > $today)
                || (array_key_exists('1', $v) && strtotime($v[1]) > $today) ){
              // Rephrase the dato for readable dates.
              $start = rephraseDate(
                date("N", strtotime($v[0])),
                date("j", strtotime($v[0])),
                date("m", strtotime($v[0])),
                date("Y", strtotime($v[0]))
              );
              if(array_key_exists('1', $v)){
                $end = rephraseDate(
                  date("N", strtotime($v[1])),
                  date("j", strtotime($v[1])),
                  date("m", strtotime($v[1])),
                  date("Y", strtotime($v[1]))
                );
              }

              // Print the dates
              $list .= '<li>';
              $list .= $start;
              if(count($v) > 1){
                $list .= ' til ';
                $list .= $end;
              }
              $list .= '</li>';
            }
          }
        }

        if(!empty($list)){
          print '<p>Bemærk dog at butikken ikke leverer på følgende dage:</p>';
          print '<ul>'.$list.'</ul>';
        }

				// --- END of CLOSED DATES --- Dennis.
				?>
      </div>
    </div>
  </div>
</section>






<?php


get_template_part('template-parts/inc/blocks/did-you-know');
get_template_part('template-parts/inc/blocks/how-it-works');
get_template_part('template-parts/inc/blocks/learn-more');
get_template_part('template-parts/inc/blocks/press-mentions');



/**
 * Hook: wcmp_after_main_content.
 *
 */
do_action( 'wcmp_after_main_content' );

/**
 * Hook: wcmp_sidebar.
 *
 */
// deprecated since version 3.0.0 with no alternative available
// do_action( 'wcmp_sidebar' );

get_footer( 'shop' );
?>

<script type="text/javascript">
  jQuery(document).ready(function($) {
    var ajaxurl = "<?php echo admin_url('admin-ajax.php');?>";
    var catIdArray = [];
    var occIdArray = [];
    var inputPriceRangeArray = [];

    $(".filter-on-vendor-page").click(function(){
      updateVendor();

      if(this.checked){
        setFilterBadge(
          $('label[for='+this.id+']').text(),
          this.value,
          'filter_catocca_'+this.value
        );
      } else {
        removeFilterBadge(
          $('label[for='+this.id+']').text(),
          this.value,
          'filter_catocca_'+this.value,
          false
        );
      }
    });

    function updateVendor(){
      catIdArray = [];
      occIdArray = [];

      // Make the loading
      jQuery('#products').hide();
      jQuery('#filteredProduct').hide();
      jQuery('.loadingHeartBeat').show();

      $("input:checkbox[name=filter_cat_vendor]:checked").each(function(){
        catIdArray.push($(this).val());
      });
      $("input:checkbox[name=filter_occ_vendor]:checked").each(function(){
        occIdArray.push($(this).val());
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
        'action': 'productFilterAction',
        defaultProductIdAsString: jQuery("#defaultProductIdAsString").val(),
        nn: $("input[name=nn]").val(),
        gid: $("input[name=gid]").val(),
        guid: $("input[name=guid]").val(),
        catIds: catIdArray,
        occIds: occIdArray,
        inputPriceRangeArray: inputPriceRange
      };
      jQuery.post(ajaxurl, data, function(response) {
        // Hide the default products
        jQuery('#products').hide();

        // Hide the loading screen
        jQuery('.loadingHeartBeat').hide();

        // Show the filtered products
        jQuery('#filteredProduct').html(response);
        jQuery('#filteredProduct').show();
      });
    }


    // Filter badges on the vendor page.
    function setFilterBadge(label, id, dataRemove){
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
    function removeFilterBadge(label, id, dataRemove, updateVendors){
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
    $('#vendorPageReset').click(function(){
      $("input:checkbox[name=filter_catocca_vendor]").removeAttr("checked");

      $("input#slideEndPoint").val(val_max);
      $("input#slideStartPoint").val(0);

      $('div.filter-list div.dynamic-filters').remove();

      //catOccaDeliveryIdArray.length = 0;

      jQuery('#products').show();
      jQuery('#filteredProduct').hide();
    });


    jQuery(".modalBtn").click(function(){
      var uncollapseItem = jQuery(this).data('cd-open');

      jQuery('.collapse.show').removeClass('show');
      jQuery('#'+uncollapseItem).addClass('show');

      jQuery('div.modal-body a.collapse-btn').attr("aria-expanded","false");
      jQuery('*[aria-controls="'+uncollapseItem+'"]').attr("aria-expanded","true");
    });

    jQuery("#toggleOpening").click(function(){
      jQuery(".opening-row").toggle();
    });
  });

</script>
