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

/*** amdad off this hook */
// do_action( 'wcmp_store_tab_widget_contents' );
/** amdad write custom code begin */
?>
<?php
// Get vendor
$vendorId = wcmp_find_shop_page_vendor();
$vendor = get_wcmp_vendor($vendorId);

$productIdArray = array();

$vendorProducts = $vendor->get_products(array('fields' => 'ids'));
?>

<section id="products_shop">
  <div class="container">
    <div class="row">
			<div class="col-md-12 col-lg-2 filter">
				<div class="row d-md-block d-lg-none">
					<div class="py-0 mb-2">
						<a class="btn accordion-button collapsed border-0 ps-3 pe-3 rounded bg-yellow text-white" data-bs-toggle="collapse" href="#colFilter" role="button" aria-expanded="false" aria-controls="collapseExample">
							<svg class="pe-2" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#ffffff" class="bi bi-funnel" viewBox="0 0 16 16">
								<path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/>
							</svg>
							<h6 class="accordion-header float-start filter-header">Filtrér</h6>
						</a>
					</div>
				</div>
				<div class="row py-1 mb-3">
					<h6 class="float-start d-none d-lg-inline d-xl-inline py-2 border-bottom filter-header">Filtrér</h6>
				</div>
				<div class="collapse d-lg-block accordion-collapse " id="colFilter">

					<h5 class="text-uppercase">Kategorier</h5>
					<ul class="dropdown rounded-3 list-unstyled overflow-hidden mb-4">
					<?php
					$categoryTermListArray = array();
					// $vendor previously declared and get value from there
					$vendorProducts = $vendor->get_products(array('fields' => 'ids'));
					foreach ($vendorProducts as $productId) {
						$categoryTermList = wp_get_post_terms($productId, 'product_cat', array('fields' => 'all'));
						foreach($categoryTermList as $catTerm){
							// unique item insert to array
							$uniqueTermId = $catTerm->term_id;
							$categoryTermListArray["$uniqueTermId"] = $catTerm;
						}
					}
					foreach($categoryTermListArray as $category){
						?>
						<li class="px-0">
							<div class="form-check">
									<input type="checkbox" name="filter_del[<?php echo $category->term_id; ?>]" class="form-check-input" id="filter_delivery_<?php echo $category->term_id; ?>" value="<?php echo $category->term_id; ?>">
									<label class="form-check-label" for="filter_delivery_<?php echo $category->term_id; ?>"><?php echo $category->name; ?></label>
							</div>
						</li>
					<?php
					}
					?>
					</ul>

					<!-- occasion filter-->
					<h5 class="text-uppercase">Anledninger</h5>
					<ul class="dropdown rounded-3 list-unstyled overflow-hidden mb-4">
					<?php
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
					foreach($occasionTermListArray as $occasion){
						?>
						<li class="px-0">
							<div class="form-check">
								<input type="checkbox" name="filter_del[<?php echo $occasion->term_id; ?>]" class="form-check-input" id="filter_delivery_<?php echo $occasion->term_id; ?>" value="<?php echo $occasion->term_id; ?>">
								<label class="form-check-label" for="filter_delivery_<?php echo $occasion->term_id; ?>"><?php echo $occasion->name; ?></label>
							</div>
						</li>
					<?php
					}
					?>
					</ul>

					<!-- tag filter-->
					<h5 class="text-uppercase">Tags</h5>
					<ul class="dropdown rounded-3 list-unstyled overflow-hidden mb-4">
					<?php
					$tagTermListArray = array();
					// $vendor previously declared and get value from there
					$vendorProducts = $vendor->get_products(array('fields' => 'ids'));
					foreach ($vendorProducts as $productId) {
						$tagTermList = wp_get_post_terms($productId, 'product_tag', array('fields' => 'all'));
						foreach($tagTermList as $tagTerm){
							// unique item insert to array
							$tagUniqueTermId = $occasionTerm->term_id;
							$tagTermListArray["$tagUniqueTermId"] = $tagTerm;
						}
					}
					foreach($tagTermListArray as $tag){ ?>
						<li class="px-0">
							<div class="form-check">
								<input type="checkbox" name="filter_del[<?php echo $tag->term_id; ?>]" class="form-check-input" id="filter_delivery_<?php echo $tag->term_id; ?>" value="<?php echo $tag->term_id; ?>">
								<label class="form-check-label" for="filter_delivery_<?php echo $tag->term_id; ?>"><?php echo $tag->name; ?></label>
							</div>
						</li>
					<?php
					}
					?>
					</ul>
				</div>
			</div><!-- div.filter end -->

			<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-10">
				<div class="applied-filters row mt-xs-0 mt-sm-0 mt-md-0 mb-3 lh-lg">
					<div class="col-12">
						<a class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 text-dark">Påske <button type="button" class="btn-close" aria-label="Close"></button></a>
						<a class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 text-dark">Påske <button type="button" class="btn-close" aria-label="Close"></button></a>
						<a class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 text-dark">Pris: 250,- til 750,- <button type="button" class="btn-close" aria-label="Close"></button></a>
						<a class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 text-dark">Butik: Den Blå Dør <button type="button" class="btn-close" aria-label="Close"></button></a>
						<a class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 bg-yellow text-white">Nulstil alle <button type="button" class="btn-close  btn-close-white" aria-label="Close"></button></a>
					</div>
				</div>

				<div class="row">
				<?php
				// Get vendor
				$vendorId = wcmp_find_shop_page_vendor();
				$vendor = get_wcmp_vendor($vendorId);

				$productIdArray = array();

				$vendorProducts = $vendor->get_products(array('fields' => 'ids'));
				foreach ($vendorProducts as $productId) {
					array_push($productIdArray, $productId);
					$product = wc_get_product( $productId );
					$uploadedImage = wp_get_attachment_url( $product->get_image_id() );
					$uploadDir = wp_upload_dir();
					$uploadDirBaseUrl = $uploadDir['baseurl'];
					?>
					<div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
						<div class="card mb-4 border-0">
								<a href="<?php echo get_permalink($product->get_id());?>">
								<?php if($uploadedImage != ''){?>
									<img
									src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>"
									class="attachment-shop_catalog size-shop_catalog"
									alt=""
									loading="lazy"
									title="<?php echo $product->get_name();?>"
									srcset="
										<?php echo wp_get_attachment_url( $product->get_image_id() ); ?> 370w,
										<?php echo wp_get_attachment_url( $product->get_image_id() ); ?> 150w,
										<?php echo wp_get_attachment_url( $product->get_image_id() ); ?> 300w,
										<?php echo wp_get_attachment_url( $product->get_image_id() ); ?> 768w,
										<?php echo wp_get_attachment_url( $product->get_image_id() ); ?> 640w,
										<?php echo wp_get_attachment_url( $product->get_image_id() ); ?> 100w,
										<?php echo wp_get_attachment_url( $product->get_image_id() ); ?> 60w,
										<?php echo wp_get_attachment_url( $product->get_image_id() ); ?> 620w,
										<?php echo wp_get_attachment_url( $product->get_image_id() ); ?> 800w"
									class="card-img-top"
									alt="<?php echo $product->get_name();?>">
								<?php } else { ?>
									<img
									src="<?php echo $uploadDirBaseUrl;?>/woocommerce-placeholder-300x300.png"
									class="card-img-top"
									alt="<?php echo $product->get_name();?>">
								<?php } ?>
								</a>
								<div class="card-body">
										<h6 class="card-title">
											<a href="<?php echo get_permalink($product->get_id());?>" class="text-dark">
												<?php echo $product->get_name();?>
											</a>
										</h6>
										<p class="price"><?php echo woocommerce_template_loop_price();?></small>
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
			</div>
		</div>
	</div>
</section>

<?php
$defaultProductIdAsString = implode(",", $productIdArray);
?>
<input type="hidden" id="defaultProductIdAsString" value="<?php echo $defaultProductIdAsString;?>">

<!--show ajax filtered result-->
<div id="filteredProductList" class="box-product-list">
</div>



<div style="text-align: center;">
  	<div class="overlay"></div>
</div>

<style>
    .overlay {
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 999;
        background: rgba(255,255,255,0.8) url("<?php echo get_stylesheet_directory_uri() . '/image/loading3.gif';?>") center no-repeat;
    }
    /* Turn off scrollbar when body element has the loading class */
    div.loading-custom3 {
        overflow: hidden;
    }
    /* Make spinner image visible when body element has the loading class */
    div.loading-custom3 .overlay {
        display: block;
    }
</style>


<?php
// Additional hook after archive description ended
do_action('after_wcmp_vendor_description', $vendorId);

?>
<section id="vendor" class="bg-light-grey py-5 mb-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-2">
				<?php
					$image = $vendor->get_image() ? $vendor->get_image('image', array(125, 125)) : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
				?>
				<img class="d-inline-block pb-3" src="<?php echo esc_attr($image); ?>">
      </div>
      <div class="col-lg-6">
        <h6><?php echo ucfirst(esc_html($vendor->user_data->data->display_name)); ?></h6>
        <p>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#446a6b" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
          </svg>
          <?php
					$location = get_user_meta($vendorId, '_vendor_address_1', true).', '.get_user_meta($vendorId, '_vendor_postcode', true).' '.get_user_meta($vendorId, '_vendor_city', true);
					echo esc_html($location); ?>
        </p>
        <?php
				$vendor_hide_description = apply_filters('wcmp_vendor_store_header_hide_description', get_user_meta($vendorId, '_vendor_hide_description', true), $vendor->id);
				$description = get_user_meta($vendorId, '_vendor_description', true);
				if (!$vendor_hide_description && !empty($description)) { ?>
        <div>
            <?php echo wp_kses_post(htmlspecialchars_decode( wpautop( $description ), ENT_QUOTES )); ?>
        </div>
        <?php } ?>
        <p><a href="<?php echo esc_url($vendor->get_permalink()); ?>">Se butikkens øvrige gaveprodukter</a><p>
      </div>
      <div class="col-lg-4">
        <b>Leveringsinformationer</b>
        <p>Butikken leverer på flg. dage:
          <?php
          $del_days = get_field('openning', 'user_'.$vendorId);
					$day_array = array('mandag','tirsdag','onsdag','torsdag','fredag','lørdag','søndag');

					$i = 0;
          foreach($del_days as $v){
            $day = $day_array[$v];
            if ($i == 0){
              $day = ucfirst($day);
            }

            if(count($del_days) > 1)
            {
              if($i < count($del_days)-2){
                $day .= ', ';
              } else if($i == count($del_days)-1) {
                $day = ' og '.$day;
              }
            }

            print $day;
            $i++;
          }
          ?>.
        </p>
        <p>
          Butikken leverer
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
				// --- CLOSED DATES --- Dennis.
				$closed_dates = get_field('vendor_closed_day', 'user_'.$vendorId);
				$dates = explode(",",$closed_dates);
				$viable_dates = array();

				foreach($dates as $val){
					$date_u = strtotime($val);
					$date = date("d-m-Y", $date_u);
					$today = date("U");

					if($date_u >= ($today-(60*60*24)) && $date_u <= ($today+(60*60*24*30))){
						$weekday = date('N',$date_u);
						$weekday_str = '';
						$date = date('j',$date_u);
						$month = date('m',$date_u);
						$month_str = '';

						switch($weekday){
							case 1:
								$weekday_str = 'mandag';
								break;
							case 2:
								$weekday_str = 'tirsdag';
								break;
							case 3:
								$weekday_str = 'onsdag';
								break;
							case 4:
								$weekday_str = 'torsdag';
								break;
							case 5:
								$weekday_str = 'fredag';
								break;
							case 6:
								$weekday_str = 'lørdag';
								break;
							case 7:
								$weekday_str = 'søndag';
								break;
						}

						switch($month){
							case 1:
								$month_str = 'januar';
								break;
							case 2:
								$month_str = 'februar';
								break;
							case 3:
								$month_str = 'marts';
								break;
							case 4:
								$month_str = 'april';
								break;
							case 5:
								$month_str = 'maj';
								break;
							case 6:
								$month_str = 'juni';
								break;
							case 7:
								$month_str = 'juli';
								break;
							case 8:
								$month_str = 'august';
								break;
							case 9:
								$month_str = 'september';
								break;
							case 10:
								$month_str = 'oktober';
								break;
							case 11:
								$month_str = 'november';
								break;
							case 12:
								$month_str = 'december';
								break;
						}
						$viable_dates[] = $weekday_str." d. ".$date.". ".$month_str;
					}
				}

				$dates_for_str = '';
				$i = 0;
				foreach($viable_dates as $v){
					$i++;
					$dates_for_str .= $v;
					if(count($viable_dates) > 1){
						if($i == count($viable_dates)-1){
							$dates_for_str .= ' og ';
						} else if($i < count($viable_dates)){
							$dates_for_str .= ', ';
						}
					}
				}

				if(count($viable_dates) > 0){
				?>
			 		<p>Bemærk dog at butikken ikke leverer <?php print $dates_for_str; ?>.</p>
				<?php
				}
				// --- END of CLOSED DATES --- Dennis.
				?>
      </div>
    </div>
  </div>
</section>



<section id="didyouknow">
  <div class="container text-center mb-5 mt-1 py-3">
    <div class="row">
      <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
        <h4 class="pb-3">🤔 Vidste du, at...</h4>
        <p class="px-lg-3 px-xl-3">Du på <b>Greeting.dk</b> handler i lokale, fysiske specialbutikker - og dermed er med til at støtte
          en dansk iværksætter og selvstændig?</p>
        <p class="px-lg-3 px-xl-3 pb-3">Der er netop nu mere end <strong>70 forskellige specialbutikker</strong> at vælge i mellem, næste gang du skal sende en lækker gave til én, du holder af.</p>
        <a class="btn bg-teal text-white rounded-pill">Vil du vide mere?</a>
      </div>
    </div>
  </div>
</section>


<section id="howitworks" class="bg-light-grey py-5">
  <div class="container text-center">
    <div class="row">
      <div class="col-12">
        <h2 class="py-2">🎁 Sådan fungerer det</h2>
        <p class="text-md py-4 lh-base">
          Indtast din modtagers adresse og se udvalg af gaver. Vælg en gave.<br>
          Butikken pakker gaven flot ind, håndskriver en hilsen fra dig og sørger for, at din gave leveres til modtageren.
        </p>
      </div>
      <div class="col-lg-12">
        <ul class="timeline list-style-none py-4">
          <li class="">
            <figure class="search-place-icon">
              <svg width="33" height="44" viewBox="0 0 33 44" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.917 20.706c1.129-1.412 1.833-3.177 1.833-5.123 0-4.548-3.701-8.25-8.25-8.25-4.549 0-8.25 3.702-8.25 8.25 0 4.549 3.701 8.25 8.25 8.25 1.943 0 3.709-.704 5.12-1.831l7.064 7.064a.92.92 0 001.296 0 .917.917 0 000-1.296l-7.063-7.064zM16.5 22a6.424 6.424 0 01-6.417-6.417A6.424 6.424 0 0116.5 9.167a6.424 6.424 0 016.417 6.416A6.424 6.424 0 0116.5 22zm0-22C7.907 0 .917 6.99.917 15.583c0 15.067 14.371 27.665 14.983 28.193a.92.92 0 001.203.002c.238-.207 5.894-5.139 10.217-12.518a.917.917 0 10-1.584-.928c-3.362 5.74-7.67 10.042-9.234 11.51-2.717-2.56-13.75-13.713-13.75-26.259 0-7.582 6.167-13.75 13.75-13.75 7.582 0 13.75 6.168 13.75 13.75 0 2.512-.45 5.143-1.331 7.818a.917.917 0 001.74.574c.944-2.862 1.422-5.684 1.422-8.392C32.083 6.991 25.093 0 16.5 0z" fill="#446a6b">
                </path>
              </svg>
            </figure>
            <p>Søg på modtagerens adresse</p>
          </li>
          <li>
            <figure class="shop-icon flex flex-cy flex-cx">
              <svg width="44" height="44" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg">
                <g fill="#446a6b">
                  <path d="M42.167 44H1.833a.917.917 0 01-.916-.917A4.59 4.59 0 015.5 38.5h33a4.59 4.59 0 014.583 4.583c0 .506-.41.917-.916.917zM2.906 42.167h38.186a2.757 2.757 0 00-2.594-1.834H5.5a2.757 2.757 0 00-2.594 1.834zm31.927-33H9.167a.917.917 0 01-.917-.917V4.583A4.59 4.59 0 0112.833 0h18.334a4.59 4.59 0 014.583 4.583V8.25c0 .506-.41.917-.917.917zm-24.75-1.834h23.834v-2.75a2.753 2.753 0 00-2.75-2.75H12.833a2.753 2.753 0 00-2.75 2.75v2.75z">
                  </path>
                  <path d="M7.333 22a4.59 4.59 0 01-4.583-4.583c0-.167.044-.33.13-.472l5.5-9.166a.917.917 0 01.787-.446h3.666a.916.916 0 01.899 1.097l-1.834 9.166C11.917 19.943 9.86 22 7.333 22zm-2.74-4.347a2.755 2.755 0 002.74 2.514 2.753 2.753 0 002.75-2.75l1.634-8.25H9.685l-5.093 8.486zM22 22a4.59 4.59 0 01-4.583-4.583V8.25c0-.506.41-.917.916-.917h7.334c.506 0 .916.411.916.917v9.167A4.59 4.59 0 0122 22zM19.25 9.167v8.25a2.753 2.753 0 002.75 2.75 2.753 2.753 0 002.75-2.75v-8.25h-5.5z"></path>
                  <path d="M14.667 22a4.59 4.59 0 01-4.584-4.583l1.852-9.347a.917.917 0 01.898-.737h5.5c.506 0 .917.411.917.917v9.167A4.59 4.59 0 0114.667 22zM13.585 9.167l-1.687 8.43c.019 1.336 1.252 2.57 2.769 2.57a2.753 2.753 0 002.75-2.75v-8.25h-3.832zM36.667 22a4.59 4.59 0 01-4.584-4.583L30.268 8.43a.92.92 0 01.899-1.097h3.666c.323 0 .62.169.787.446l5.5 9.166c.086.142.13.305.13.472A4.59 4.59 0 0136.667 22zM32.285 9.167l1.613 8.07c.019 1.696 1.252 2.93 2.769 2.93a2.755 2.755 0 002.74-2.514l-5.092-8.486h-2.03z">
                  </path>
                  <path d="M29.333 22a4.59 4.59 0 01-4.583-4.583V8.25c0-.506.41-.917.917-.917h5.5c.436 0 .812.308.898.737l1.833 9.167C33.917 19.943 31.86 22 29.333 22zm-2.75-12.833v8.25a2.753 2.753 0 002.75 2.75 2.753 2.753 0 002.75-2.75l-1.666-8.25h-3.834z"></path><path d="M36.667 40.333H7.333a.917.917 0 01-.916-.916V21.083a.917.917 0 011.833 0V38.5h27.5V21.083a.917.917 0 011.833 0v18.334c0 .506-.41.916-.916.916z"></path><path d="M20.167 34.833H11a.917.917 0 01-.917-.916V24.75c0-.506.411-.917.917-.917h9.167c.506 0 .916.411.916.917v9.167c0 .506-.41.916-.916.916zM11.917 33h7.333v-7.333h-7.333V33zM33 40.333h-9.167a.917.917 0 01-.916-.916V24.75c0-.506.41-.917.916-.917H33c.506 0 .917.411.917.917v14.667a.917.917 0 01-.917.916zM24.75 38.5h7.333V25.667H24.75V38.5z">
                  </path>
                </g>
              </svg>
            </figure>
            <p>Vælg gave fra en butik</p>
          </li>
          <li>
            <figure class="pen-paper-icon flex flex-cy flex-cx">
              <svg width="41" height="42" viewBox="0 0 41 42" xmlns="http://www.w3.org/2000/svg">
                <g fill="#446a6b">
                  <path d="M40.367 26.326l-3.385-3.385a.847.847 0 00-1.196 0L22.247 36.48a.852.852 0 00-.247.599v3.384c0 .467.38.846.846.846h3.385a.84.84 0 00.597-.248l10.149-10.15c.002 0 .003 0 .005-.003.002-.001.002-.003.003-.005l3.382-3.38a.847.847 0 000-1.197zM25.88 39.617h-2.188V37.43L33 28.12l2.188 2.188-9.308 9.308zm10.505-10.504l-2.189-2.188 2.189-2.188 2.188 2.188-2.188 2.188z">
                  </path>
                  <path d="M21.034 32.856L9.998 34.434 5.212 7.313l28.798-4.8 3.234 17.795a.847.847 0 001.665-.303L35.526 1.39a.849.849 0 00-.971-.684L23.943 2.474 2.61.696A.801.801 0 001.983.9a.844.844 0 00-.289.593L.002 31.954a.844.844 0 00.75.889l7.393.822.33 1.869a.845.845 0 00.95.69l11.846-1.692a.847.847 0 00.719-.958.85.85 0 00-.956-.718zM1.736 31.25l1.6-28.793 13.812 1.15L4.092 5.783a.844.844 0 00-.694.982l4.44 25.162-6.102-.678z">
                  </path>
                </g>
              </svg>
            </figure>
            <p>Skriv en personlig hilsen </p>
          </li>
          <li>
            <figure class="gift-icon flex flex-cy flex-cx">
              <svg width="44" height="41" viewBox="0 0 44 41" xmlns="http://www.w3.org/2000/svg">
                <g fill="#446a6b">
                  <path d="M40.333 20.01H3.667a2.753 2.753 0 01-2.75-2.75v-5.5a2.753 2.753 0 012.75-2.75h36.666a2.753 2.753 0 012.75 2.75v5.5a2.753 2.753 0 01-2.75 2.75zM3.667 10.845a.917.917 0 00-.917.917v5.5c0 .506.41.916.917.916h36.666c.506 0 .917-.41.917-.916v-5.5a.917.917 0 00-.917-.917H3.667z">
                  </path>
                  <path d="M36.667 40.178H7.333a4.59 4.59 0 01-4.583-4.584v-16.5c0-.506.41-.917.917-.917h36.666c.506 0 .917.411.917.917v16.5a4.59 4.59 0 01-4.583 4.584zM4.583 20.01v15.583a2.753 2.753 0 002.75 2.75h29.334a2.753 2.753 0 002.75-2.75V20.011H4.583zM22 10.844c-4.431 0-8.404-2.962-9.665-7.205a2.664 2.664 0 01.43-2.37c.68-.911 1.874-1.326 2.947-1.007 4.242 1.262 7.205 5.236 7.205 9.665a.917.917 0 01-.917.917zm-7.046-8.86a.915.915 0 00-.718.381.842.842 0 00-.145.752c.939 3.155 3.713 5.445 6.934 5.835-.389-3.22-2.679-5.995-5.836-6.932a.794.794 0 00-.235-.036z">
                  </path>
                  <path d="M22 10.844a.917.917 0 01-.917-.916c0-4.432 2.963-8.405 7.205-9.666 1.067-.317 2.268.097 2.947 1.008.517.694.674 1.559.43 2.371-1.261 4.24-5.234 7.203-9.665 7.203zm7.046-8.86a.877.877 0 00-.235.034c-3.155.94-5.445 3.713-5.836 6.934 3.22-.389 5.995-2.678 6.932-5.835a.837.837 0 00-.145-.752.908.908 0 00-.716-.381z">
                  </path>
                  <path d="M22 40.178a.917.917 0 01-.917-.917V12.14l-3.934 3.935a.917.917 0 01-1.296-1.296l5.5-5.5a.908.908 0 01.999-.198c.341.14.565.475.565.845V39.26a.917.917 0 01-.917.916z">
                  </path>
                  <path d="M27.5 16.344a.92.92 0 01-.649-.268l-5.5-5.5a.917.917 0 011.296-1.296l5.5 5.5a.917.917 0 01-.647 1.564z">
                  </path>
                </g>
              </svg>
            </figure>
            <p>Butikken pakker din gave flot ind</p>
          </li>
          <li class="timeline__item">
            <figure class="truck-icon flex flex-cy flex-cx">
              <svg width="46" height="39" viewBox="0 0 46 39" xmlns="http://www.w3.org/2000/svg">
                <path d="M45.771 21.638l-3.868-10.833a4.784 4.784 0 00-4.495-3.167H30.55V4.774A4.78 4.78 0 0025.777 0H4.774A4.78 4.78 0 000 4.774v26.732a2.869 2.869 0 002.864 2.864h2.962a4.783 4.783 0 004.676 3.819 4.783 4.783 0 004.676-3.82h17.378a4.783 4.783 0 004.676 3.82 4.783 4.783 0 004.676-3.82h1.054a2.865 2.865 0 002.863-2.863v-9.548a.92.92 0 00-.054-.32zM1.909 4.774a2.869 2.869 0 012.865-2.865h21.003a2.866 2.866 0 012.865 2.865v20.049H1.909V4.773zm8.593 31.505a2.869 2.869 0 01-2.864-2.864 2.869 2.869 0 012.864-2.864 2.866 2.866 0 012.864 2.864 2.866 2.866 0 01-2.864 2.864zm26.732 0a2.868 2.868 0 01-2.864-2.864 2.868 2.868 0 012.864-2.864 2.868 2.868 0 012.864 2.864 2.866 2.866 0 01-2.864 2.864zm6.683-4.773a.955.955 0 01-.955.954h-1.05a4.783 4.783 0 00-4.676-3.818 4.783 4.783 0 00-4.676 3.818H15.18a4.783 4.783 0 00-4.676-3.818 4.783 4.783 0 00-4.676 3.818H2.864a.955.955 0 01-.955-.954v-4.774h27.687a.955.955 0 00.955-.955V9.547h6.855c1.207 0 2.291.764 2.698 1.9l3.813 10.676v9.383zM34.37 19.094v-6.683a.955.955 0 00-1.91 0v7.638c0 .527.428.955.955.955h6.683a.955.955 0 000-1.91H34.37z" fill="#446a6b">
                </path>
              </svg>
            </figure>
            <p>Gaven leveres til din modtager</p>
          </li>
        </ul>
        <a class="bg-teal btn rounded-pill text-white my-2 py-2 px-4" href="https://greeting.dk/saadan-fungerer-det/" target="">Læs mere</a>
      </div>
    </div>
  </div>
</section>


<section id="learnmore">
  <div class="container">
    <div class="row py-5">
      <div clsas="col-12">
        <h4 class="text-center pb-5">👋 Howdy - vil du lære Greeting.dk lidt bedre at kende?</h4>
      </div>
      <div class="col-lg-4">
        <div class="card" style="">
          <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/pexels-furkanfdemir-6309844-scaled.jpg" class="card-img-top" alt="<?php echo $store_name; ?>">
          <div class="card-body">
            <h5 class="card-title">Skal din butik være med?</h5>
            <p class="card-text">Skal din butik også være med på Greeting.dk? Vi arbejder altid for et ligeværdigt samarbejde -
              og vil til enhver tid arbejde sammen med dig om at sikre den bedste oplevelse for vores fælles kunder. Vil du være med?</p>
            <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">Du starter lige her</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card" style="">
          <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/pexels-secret-garden-931154-scaled.jpg" class="card-img-top" alt="<?php echo $store_name; ?>">
          <div class="card-body">
            <h5 class="card-title">Fortjener dine medarbejdere en hilsen?</h5>
            <p class="card-text">Det er vigtigt at huske dem, du sætter pris på - også på jobbet. Derfor tilbyder vi også firmaer at levere større partiere af medarbejder gaver til eks. jul, påske, sommer - eller gaven til den kommende jubilar.</p>
            <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">Se butikkens udvalg</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card" style="">
          <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/pexels-florent-b-2664149-scaled.jpg" class="card-img-top" alt="<?php echo $store_name; ?>">
          <div class="card-body">
            <h5 class="card-title">Spørgsmål? Så fang os her :)</h5>
            <p class="card-text">Vil du gerne høre, hvad vi er for nogen - og hvordan det hele fungerer? Eller har du konkrete spørgsmål til udvalget i en af butikkerne? Vi sidder altid klar - så ræk endelig ud.</p>
            <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">Se butikkens udvalg</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
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
