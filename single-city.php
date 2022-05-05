<?php

/**
 *
 * Perform start setup
 *
**/
$postId = get_the_ID();
$cityPostalcode = get_post_meta($postId, 'postalcode', true);
$cityName = get_post_meta($postId, 'city', true);

get_header();


get_header('green', array('city' => $cityName, 'postalcode' => $cityPostalcode)); ?>


<?php
/**
* @author Dennis Lauritzen
* @todo Slider for the occassion&category filter-cards.
*
*/
 ?>

<style type="text/css">
  .bg-pink {
    background: #F8F8F8;
  }
  .bg-rose {
    background: #fecbca;
  }
  .bg-teal {
    background: #446a6b;
  }
  .border-teal {
    border-color: #446a6b;
  }
  .bg-light-grey {
    background: #F8F8F8;
  }
  .bg-yellow {
    background: #d6bf75;
  }
  .border-teal {
    border: 1px solid #446a6b;
  }
  .border-yellow {
    border: 1px solid #d6bf75;
  }

  #top {
    border-top: 3px solid #fecbca;
  }
  #top div.right-col {
    font-family: 'Inter', sans-serif;
  }
  #top div.right-col .btn {
    font-size: 13px;
  }
  #top .top-search-btn {
    width: 40px;
    height: 35px;
    margin-top: 2px;
    z-index: 1000;
    background-image: url('https://greeting.dk/wp-content/plugins/greeting-marketplace/assets/img/search-icon.svg');
    background-repeat: no-repeat;
    background-position: center center;
  }
  #top .top-search-input {
    padding-left: 30px;
  }
  .btn-create {
    border: 1px solid #58a2a2;
  }

  #content h1 {
    padding-bottom: 15px;
    position: relative;
  }
  #content h1::before {
    position: absolute;
    background: linear-gradient(to right, #555555 75px, #ffffff 75px);
    height: 3px;
    content: '';
    bottom: 0;
    right: 0;
    left: 0;
  }

  #content #topoccassions .card .card-img-top {
		width: 100%;
    height: 10vw;
    object-fit: cover;
	}
  #content #topoccassions .card h5.card-title {
    font-family: 'Inter',sans-serif;
    font-size: 14px;
  }

  .filter a[aria-expanded='true'] {
    background: #d6bf75;
  }
  .accordion-button:not(.collapsed)::after {
    background-image: url('data:image/svg+xml, %3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2216%22%20height%3D%2216%22%20fill%3D%22%23222222%22%20class%3D%22bi%20bi-chevron-down%22%20viewBox%3D%220%200%2016%2016%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M1.646%204.646a.5.5%200%200%201%20.708%200L8%2010.293l5.646-5.647a.5.5%200%200%201%20.708.708l-6%206a.5.5%200%200%201-.708%200l-6-6a.5.5%200%200%201%200-.708z%22%2F%3E%3C%2Fsvg%3E');
    transform: rotate(180deg);
  }

  .filter h5 {
    font-family: 'Rubik','Inter', serif;
    font-weight: 500;
    font-size: 12px;
  }
  .filter h6 {
    font-family: 'Inter','Rubik',serif;
    font-weight: 800;
    font-size: 13px;
  }
  .filter ul {
    font-family: 'Inter', sans-serif;
    font-size: 12px;
  }
  .filter span.price-filter-text {
    font-size: 11px;
  }
  .filter input[type="range"]::-webkit-slider-thumb {
    background: #446a6b;
    border: 1px solid #446a6b;
  }
  .filter input[type="range"]::-ms-thumb {
    background: #446a6b;
    border: 1px solid #446a6b;
  }
  .filter input[type="range"]::-moz-range-thumb {
    background: #446a6b;
    border: 1px solid #446a6b;
  }

  div.applied-filters {
    font-family: 'Inter', sans-serif;
    font-size: 15px;
    font-weight: 200;
  }

  div.store h6.card-title {
    font-family: 'Rubik','Inter', sans-serif;
    font-size: 14px;
    font-weight: 600;
  }
  div.store small {
    font-family: 'Inter', sans-serif;
    font-size: 10px;
    font-weight: 400;
  }
  div.store div.card p.price,
  div.store div.card bdi,
  div.store div.card div.price_hold {
    font-size: 13px;
  }

  h1, h2 {
    font-family: 'Rubik','Inter', sans-serif;
    font-weight: 600;
  }

  .store {
    transition: all .15s ease-in-out;
  }
  .store:hover {
    transform: scale(1.015);
  }
  @media (max-width: 768px){
    .store a.cta {
      font-size: 0.725rem;
    }
  }


  /*
  * section#hotitworks
  * How it works section
  * --
  */
  #howitworks h1,
  #howitworks h2,
  #howitworks h3 {
    font-family: "Dela Gothic One", cursive, serif;
    font-weight: 300;
  }
  ul.timeline {
    width: 100%;
    position: relative;
    list-style: none;
    line-height: 1.8em;
    min-height: 50px;
    float: left;
    text-align: center;
  }
  ul.timeline::before {
    content: "";
    display: block;
    background-color: #446a6b;
    height: 0.5px;
    margin: 0 ;
    position:relative;
    top:23px;
  }
  ul.timeline li {
    float: left;
    width: 20%;
    min-width: 125px;
    padding: 0 10px;
  }
  ul.timeline li figure {
    position: relative;
    z-index: 2;
    background: #F8F8F8;
    height: 50px;
    width: 80px;
    border-radius: 50%;
    margin: 0 auto 10px auto;
    box-sizing: inherit;
  }
  @media (min-width: 769px){
    ul.timeline::before {
      margin: 0 100px;
    }
  }
  @media (max-width: 768px){
    ul.timeline {
      text-align: left;
    }
    ul.timeline::before {
      content: "";
      position: absolute;
      width: 1px;
      top: 10px;
      left: 59px;
      margin-top: 25px;
      height: calc(100% - 75px);
    }
    ul.timeline li {
      display: flex;
      align-items: center;
      width: 100%;
      min-width: 200px;
      padding: 5px 10px 10px 10px;
    }
    ul.timeline li figure {
      width: 34px;
      text-align: left;
      margin: 0 15px 0 0;
    }
    ul.timeline li svg {
      width: 34px;
    }
  }

  /*
  * #learnmore
  * Learn more section
  */
  #learnmore h1,
  #learnmore h2,
  #learnmore h3,
  #learnmore h4 {
    font-family: "Dela Gothic One", cursive, serif;
  }
  #learnmore .card .card-img-top {
    width: 100%;
    height: 10vw;
    min-height: 200px;
    object-fit: cover;
  }
  #learnmore .card .card-title {
    font-family: 'Rubik',sans-serif;
  }
  #learnmore .card .card-text {
    font-family: 'Inter',sans-serif;
    font-size: 14px;
    line-height: 23px;
  }



  #greeting-footer h6 {
    font-family: 'Rubik', 'Inter', 'Comic Sans', sans-serif;
    font-size: 20px;
    color: #1b4949;
  }
  #greeting-footer h6.light {
    font-family: 'Rubik', 'Inter', 'Comic Sans', sans-serif;
    font-size: 18px;
    text-transform: uppercase;
    color: #ffffff;
  }
  #greeting-footer ul {
    font-family: 'Inter', 'Comic Sans', sans-serif;
    font-weight: 300;
    font-size: 13px;
  }
  #greeting-footer ul.social {
    width: 100px;
    list-style: none;
    margin: -30px 0 0 -100px;
    padding: 0 5px 0 0;
  }
  #greeting-footer ul.social li {
    float: left;
    width: 45px;
    margin: 0;
    padding: 0;
  }

  #formal-footer {
    border-top: 3px solid #fecbca;
    font-family: 'Inter',sans-serif;
    font-size: 12px;
    color: #555555;
  }
  #formal-footer ul {
    list-style: none;
    margin: 0;
    padding: 0;
  }
  #formal-footer ul li {
    float: left;
    margin: 0;
    padding: 0 10px 0 0;
  }

  /** loading begin */
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
	div.loading {
		overflow: hidden;
	}
	/* Make spinner image visible when body element has the loading class */
	div.loading .overlay {
		display: block;
	}
  /** loading end */

</style>


<main id="main" class="container"<?php if ( isset( $navbar_position ) && 'fixed_top' === $navbar_position ) : echo ' style="padding-top: 100px;"'; elseif ( isset( $navbar_position ) && 'fixed_bottom' === $navbar_position ) : echo ' style="padding-bottom: 100px;"'; endif; ?>>
<?php

// get user meta query
$userMetaQuery = $wpdb->get_results( "
    SELECT * FROM {$wpdb->prefix}usermeta
    WHERE meta_key = 'delivery_zips'
" );

$UserIdArrayForCityPostalcode = array();

foreach($userMetaQuery as $userMeta){
    if (str_contains($userMeta->meta_value, $cityPostalcode)) {
        array_push($UserIdArrayForCityPostalcode, $userMeta->user_id);
    }
}

// pass to backend
$cityDefaultUserIdAsString = implode(",", $UserIdArrayForCityPostalcode); ?>
<script type="text/javascript">
function addToLocalStorage(key, val){
	window.localStorage.setItem(key, val);
}
jQuery(document).ready(function(){
  addToLocalStorage('city', '<?php echo $cityName; ?>');
  addToLocalStorage('postalcode', '<?php echo $cityPostalcode; ?>');
});
</script>
<input type="hidden" id="cityDefaultUserIdAsString" value="<?php echo $cityDefaultUserIdAsString;?>">
<input type="hidden" id="postalCode" value="<?php echo $cityPostalcode; ?>">
<section id="content" class="row">
  <div class="container">
    <div class="row d-inline d-lg-none d-xl-none">
      <div class="col-12">
        <h1 class="d-inline d-lg-none d-xl-none my-3 my-xs-3 my-sm-3 my-md-3 my-lg-0 my-xl-0 mb-lg-4 mb-xl-4">Find gavehilsner til <?php the_title();?></h1>
      </div>
    </div>

    <div class="row mt-4 mb-5" id="topoccassions">
    <?php
    $occasionTermListArray = array();

    $productPriceArray = array(); // for price filter

    foreach ($UserIdArrayForCityPostalcode as $vendorId) {
        $vendor = get_wcmp_vendor($vendorId);
        $vendorProducts = $vendor->get_products(array('fields' => 'ids'));
        foreach ($vendorProducts as $productId) {
            $occasionTermList = wp_get_post_terms($productId, 'occasion', array('fields' => 'all'));
            // for price filter begin
            $singleProduct = wc_get_product( $productId );
            array_push($productPriceArray, $singleProduct->get_price()); // for price filter
            // for price filter end
            foreach($occasionTermList as $occasionTerm){
                array_push($occasionTermListArray, $occasionTerm);
            }
        }
    }


    // get user meta query
    $occasion_featured_list = $wpdb->get_results( "
    SELECT
      tt.term_id,
      tt.taxonomy,
		  t.name,
      t.slug,
      (SELECT tm.meta_value FROM {$wpdb->prefix}termmeta tm WHERE tm.term_id = tt.term_id AND tm.meta_key = 'featured_image') as image_src
    FROM
      {$wpdb->prefix}term_taxonomy tt
    INNER JOIN
      {$wpdb->prefix}terms t
    ON
      t.term_id = tt.term_id
    WHERE
      tt.taxonomy IN ('occasion','product_cat')
    AND
      tt.term_id IN (SELECT term_id FROM {$wpdb->prefix}termmeta tm WHERE meta_key = 'featured' AND meta_value = 1)
    ORDER BY
		  tt.count DESC
    LIMIT 6
    ");
    foreach($occasion_featured_list as $occasion){
      $placeHolderImage = wc_placeholder_img_src();
      $occasionImageUrl = '';
      if(!empty($occasion->image_src)){
        $occasionImageUrl = wp_get_attachment_image($occasion->image_src, 'thumbnail', false, array('class' => 'card-img-top', 'alt' => $occasion->name));
      } else {
        $occasionImageUrl = $placeHolderImage;
      }
    ?>
    <div class="col-6 col-md-2">
        <div class="card border-0 shadow-sm">
          <?php echo $occasionImageUrl;?>
          <div class="card-body">
            <h5 class="card-title">
              <a href="#" class="stretched-link text-dark">
                <?php echo $occasion->name;?>
              </a>
            </h5>
          </div>
        </div>
      </div>

    <?php }
    ?>
    </div>

    <div class="row">
      <div class="col-md-12 col-lg-3 filter">
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
          <?php
          /**
           * ---------------------
           * Category filter
           * ---------------------
          **/
          ?>
          <h5 class="text-uppercase">Kategori</h5>
          <ul class="dropdown rounded-3 list-unstyled overflow-hidden mb-4">

          <?php
          // search users for get filtered category
          $cityPostalcode = get_post_meta($postId, 'postalcode', true);
             $userMetaQuery = $wpdb->get_results( "
             SELECT * FROM {$wpdb->prefix}usermeta
             WHERE meta_key = 'delivery_zips'
          " );

          $UserIdArrayForCityPostalcode = array();
          foreach($userMetaQuery as $userMeta){
             if (str_contains($userMeta->meta_value, $cityPostalcode)) {
                 array_push($UserIdArrayForCityPostalcode, $userMeta->user_id);
             }
          }

          // for category
          $categoryTermListArray = array();

          foreach ($UserIdArrayForCityPostalcode as $vendorId) {
             $vendor = get_wcmp_vendor($vendorId);
             $vendorProducts = $vendor->get_products(array('fields' => 'ids'));
             foreach ($vendorProducts as $productId) {
                 $categoryTermList = wp_get_post_terms($productId, 'product_cat', array('fields' => 'ids'));
                 foreach($categoryTermList as $catTerm){
                     array_push($categoryTermListArray, $catTerm);
                 }
             }
          }
          $categoryTermListArrayUnique = array_unique($categoryTermListArray);

          // product category
          $categoryArgs = array(
             'taxonomy'   => "product_cat",
             'exclude' => 15,
             // 'pad_counts' => true,
             // 'hide_empty' => 1,
          );
          $productCategories = get_terms($categoryArgs);
          foreach($productCategories as $category){
             foreach($categoryTermListArrayUnique as $catTerm){
                 if($catTerm == $category->term_id){ ?>
                    <!-- <li>
                     <a class="city-page-item dropdown-item d-flex align-items-center gap-2 py-2" href="#">
                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                         <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                       </svg>
                       <?php //echo $category->name; ?>
                     </a>
                    </li> -->
                    <div class="form-check">
                        <input type="checkbox" name="filter_catocca_city" class="form-check-input filter-on-city-page" id="filter_cat<?php echo $category->term_id; ?>" value="<?php echo $category->term_id; ?>">
                        <label for="filter_cat<?php echo $category->term_id; ?>" class="form-check-label">
                          <?php echo $category->name; ?>
                        </label>
                    </div>
                 <?php }
             }
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
          <h5 class="text-uppercase">Anledning</h5>
          <ul class="dropdown rounded-3 list-unstyled overflow-hidden mb-4">
          <?php
          // for used on occasion prepare here
          $occasionTermListArray = array();

          foreach ($UserIdArrayForCityPostalcode as $vendorId) {
              $vendor = get_wcmp_vendor($vendorId);
              $vendorProducts = $vendor->get_products(array('fields' => 'ids'));
              foreach ($vendorProducts as $productId) {
                  $occasionTermList = wp_get_post_terms($productId, 'occasion', array('fields' => 'ids'));
                  foreach($occasionTermList as $occasionTerm){
                      array_push($occasionTermListArray, $occasionTerm);
                  }
              }
          }
          $occasionTermListArrayUnique = array_unique($occasionTermListArray);
          // for occasion end

          $args = array(
              'taxonomy'   => "occasion",
              // 'hide_empty' => 1,
              // 'include'    => $ids
          );
          $productOccasions = get_terms($args);
          foreach($productOccasions as $occasion){
            foreach($occasionTermListArrayUnique as $occasionTerm){
              if($occasionTerm == $occasion->term_id){ ?>
                <div class="form-check">
                    <input type="checkbox" name="filter_catocca_city" class="form-check-input filter-on-city-page" id="filter_occ_<?php echo $occasion->term_id; ?>" value="<?php echo $occasion->term_id; ?>">
                    <label class="form-check-label" for="filter_occ_<?php echo $occasion->term_id; ?>"><?php echo $occasion->name; ?></label>
                </div>
          <?php
              }
            }
          }
          ?>
          </ul>

          <?php
          /**
           * ---------------------
           * Delivery type filter
           * ---------------------
          **/
          ?>
          <h5 class="text-uppercase">Levering</h5>
          <ul class="dropdown rounded-3 list-unstyled overflow-hidden mb-4">

          <div class="form-check">
              <input type="checkbox" name="filter_del_city" class="form-check-input filter-on-city-page" id="filter_delivery_1" value="1">
              <label class="form-check-label" for="filter_delivery_1">Personlig levering</label>
          </div>
          <div class="form-check">
              <input type="checkbox" name="filter_del_city" class="form-check-input filter-on-city-page" id="filter_delivery_0" value="0">
              <label class="form-check-label" for="filter_delivery_0">Forsendelse med fragtfirma</label>
          </div>

          </ul>

          <!-- price filter filter-->
          <?php
          // for price filter
          $minProductPrice;
          $maxProductPrice;

          if(count($productPriceArray) == 0){
            $minProductPrice = 0;
            $maxProductPrice = 0;
          }
          elseif(min($productPriceArray) == max($productPriceArray)){
            $minProductPrice = 0;
            $maxProductPrice = max($productPriceArray);
          }
          else {
            $minProductPrice = 0;
            $maxProductPrice = max($productPriceArray);
          }
          ?>

          <h5 class="text-uppercase">Pris</h5>
          <form>
            <div id="slideInput" class="my-3">
              <div class="row">
                <div class="col-2 col-xs-2 col-sm-2 col-md-2 col-lg-4 col-xl-3">
                  <input type="text" id="slideStartPoint" class="form-control price-field" data-index="0" value="<?php echo $minProductPrice;?>" readonly/>
                </div>
                <div class="col-2 offset-8 col-xs-2 col-sm-2 offset-xs-8 offset-sm-8 col-md-2 offset-md-8 col-lg-4 offset-lg-4 col-xl-3 offset-xl-6">
                  <input type="text" id="slideEndPoint" class="form-control price-field" data-index="1" value="<?php echo ceil($maxProductPrice);?>" readonly/>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="px-3 px-lg-2 pt-3 pt-lg-2 pt-xl-2 pb-4">
                    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.min.css">
                    <style type="text/css">
                    .slider.slider-horizontal{
                      width:100%;
                    }
                    .slider .slider-handle {
                      background-color: #446a6b;
                      background-image: none;
                    }
                    </style>
                    <input
                      id="sliderPrice"
                      type="text"
                      class="form-range py-3"
                      value="array"
                      data-slider-min="0"
                      data-slider-max="<?php echo ceil($maxProductPrice+1); ?>"
                      data-slider-step="1"
                      data-slider-tooltip="hide"
                      data-slider-value="[0,<?php echo ceil($maxProductPrice); ?>]"/>
                  </div>
                </div>
              </div>
            </div>
          </form>

        </div> <!-- #colFilter -->
      </div>

      <div class="col-md-12 col-lg-9 mb-5">
        <h1 class="d-none d-lg-block d-xl-block my-3 my-xs-3 my-sm-3 my-md-3 my-lg-0 my-xl-0 mb-lg-4 mb-xl-4">Find gavehilsner til <?php the_title();?></h1>
        <div class="applied-filters row mt-xs-0 mt-sm-0 mt-md-0 mt-2 mb-4 lh-lg">
          <div class="col-12 filter-list">
            <a href="<?php echo home_url(); ?>"class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 text-dark">
              <?php echo $cityPostalcode.' '.$cityName; ?>
              <button type="button" class="btn-close" aria-label="Close"></button>
            </a>
            <a href="#" id="cityPageReset" onclick="event.preventDefault();" class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 bg-yellow text-white">
              Nulstil alle
              <button type="button" class="btn-close  btn-close-white" aria-label="Close">
              </button>
            </a>
          </div>
        </div>

        <div id="defaultStore">
      <?php
      foreach ($UserIdArrayForCityPostalcode as $user) {
        $vendor = get_wcmp_vendor($user);
        $image = $vendor->get_image() ? $vendor->get_image('image', array(125, 125)) : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
        ?>
        <div class="row store">
          <div class="col-12">
            <div class="card shadow border-0 mb-3">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-12 col-md-3 text-start text-md-center">
                    <div class="row mb-4 mb-md-0 d-flex">
                      <div class="col-4 col-md-12">
                        <a href="<?php echo esc_url($vendor->get_permalink()); ?>">
                          <img class="img-fluid rounded-start" src="<?php echo $image;?>" style="max-width: 100px;">
                        </a>
                      </div>
                      <div class="col-8 col-md-12">
                        <?php $button_text = apply_filters('wcmp_vendor_lists_single_button_text', $vendor->page_title); ?>
                        <a href="<?php echo esc_url($vendor->get_permalink()); ?>" class="text-dark">
                          <h6><?php echo esc_html($button_text); ?></h6>
                        </a>
                        <a href="<?php echo esc_url($vendor->get_permalink()); ?>" class="cta rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-3 px-md-4">
                          Gå til butik<span class="d-none d-md-inline"> ></span>
                        </a>
                      </div>
                    </div>
                  </div>


                  <div class="col-12 col-md-9">
                    <div class="row">
                    <?php
                    $vendorProducts = $vendor->get_products(array('fields' => 'all', 'posts_per_page' => 3));
                    foreach ($vendorProducts as $prod) {
                      $product = wc_get_product($prod);
                      $imageId = $product->get_image_id();
                        $uploadedImage = wp_get_attachment_image_url($imageId, 'medium');
                        $placeHolderImage = wc_placeholder_img_src();
                        $imageUrl;
                        if($uploadedImage != ''){
                          $imageUrl = $uploadedImage;
                        } else {
                          $imageUrl = $placeHolderImage;
                        }
                      ?>
                      <div class="col-4 col-xs-4 col-sm-4 col-md-4">
                        <div class="card border-0">
                            <a href="<?php echo get_permalink($product->get_id());?>"><img src="<?php echo $imageUrl;?>" class="card-img-top" alt="<?php echo $product->get_name();?>"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark"><?php echo $product->get_name();?></a></h6>
                                <p class="price"><?php echo woocommerce_template_loop_price(); ?></p>
                            </div>
                        </div>
                      </div>
                    <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <small class="text-muted">
                  <div>
                    <?php
                    $delivery_type = get_field('_delivery_type','user_'.$vendor->id);

                    if($delivery_type == 1){
                    ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bicycle" viewBox="0 0 16 16">
                      <path d="M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5zm1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139L5.5 6.943zM8 9.057 9.598 6.5H6.402L8 9.057zM4.937 9.5a1.997 1.997 0 0 0-.487-.877l-.548.877h1.035zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765l1.027-1.643zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53L11.55 8.623z"/>
                    </svg> Personlig levering i <?php print the_title(); ?>
                    <?php
                    } else if($delivery_type == 0) {
                    ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                      <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                    </svg>
                      Sender med fragtfirma til <?php print the_title(); ?>
                    <?php
                    }
                    ?>
                    <input type="hidden" id="cityName" value="<?php echo the_title();?>">
                  </div>
                </small>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      </div>

      <!-- show filtered result here-->
      <div class="filteredStore row"></div>

      </div>
    </div>
  </div>
</section>
</main>


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
          <img src="<?php echo get_field('howdy_block1_picture', 'options'); ?>" class="card-img-top" alt="<?php echo get_field('howdy_block1_header', 'options'); ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo get_field('howdy_block1_header', 'options'); ?></h5>
            <p class="card-text"><?php echo get_field('howdy_block1_text', 'options'); ?></p>
            <a href="<?php echo get_field('howdy_block1_link', 'options'); ?>" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">
              <?php echo get_field('howdy_block1_button_cta', 'options'); ?>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card" style="">
          <img src="<?php echo get_field('howdy_block2_picture', 'options'); ?>" class="card-img-top" alt="<?php echo get_field('howdy_block2_header', 'options'); ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo get_field('howdy_block2_header', 'options'); ?></h5>
            <p class="card-text"><?php echo get_field('howdy_block2_text', 'options'); ?></p>
            <a href="<?php echo get_field('howdy_block2_link', 'options'); ?>" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">
              <?php echo get_field('howdy_block2_button_cta', 'options'); ?>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card" style="">
          <img src="<?php echo get_field('howdy_block3_picture', 'options'); ?>" class="card-img-top" alt="<?php echo get_field('howdy_block3_header', 'options'); ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo get_field('howdy_block3_header', 'options'); ?></h5>
            <p class="card-text"><?php echo get_field('howdy_block3_text', 'options'); ?></p>
            <a href="<?php echo get_field('howdy_block3_link', 'options'); ?>" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">
              <?php echo get_field('howdy_block3_button_cta', 'options'); ?>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<?php get_footer( ); ?>

<script src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">
