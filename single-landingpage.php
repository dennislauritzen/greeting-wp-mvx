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

// Get the connectors fields and check if they are empty.
// If empty, then redirect to home.
$lp_category_conn = get_field('category_relation', $page_id);
$lp_occasion_conn = get_field('occasion_relation', $page_id);
#var_dump($lp_category_conn);var_dump($lp_occasion_conn);
$connection_id = !empty($lp_category_conn) ? $lp_category_conn : $lp_occasion_conn;
$connection_type = !empty($lp_category_conn) ? 'category' : (!empty($lp_occasion_conn) ? 'occasion' : '');

if(empty($connection_id)){
  wp_redirect(home_url());
  exit();
}

get_header();
get_header('green', array('city' => '', 'postalcode' => ''));
?>

<?php
/**
* @author Dennis Lauritzen
* @todo Slider for the occassion&category filter-cards.
*
*/
 ?>


<main id="main" class="container"<?php if ( isset( $navbar_position ) && 'fixed_top' === $navbar_position ) : echo ' style="padding-top: 100px;"'; elseif ( isset( $navbar_position ) && 'fixed_bottom' === $navbar_position ) : echo ' style="padding-bottom: 100px;"'; endif; ?>>
<?php
// TODOS!!!!!
// --
// (v) @todo - move from custom relation to ACF Relation on occassion / category (line 54-66).
// (v) @todo - add a filter if there is less than 10 postal codes.
// (v) @todo - if more than 10 (only Copenhagen) then we think they deliver to all postal codes.
// @todo - SEO text should be compiled.
// (v) @todo - check if it is an occassion or a category that is connected to the landing page - and only filter for the "other".
// (v) @todo - make the postal code connection perform better
// @todo - Make sure  the mobile view has postal codes as the "top boxes".

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

// Add the user role to the where array:
$where[] = '%dc_vendor%';

$sql = "SELECT
        	DISTINCT(u.ID)
        FROM
        	{$wpdb->prefix}users u
        LEFT JOIN
        	{$wpdb->prefix}usermeta um
            ON um.user_id = u.ID
        LEFT JOIN
          {$wpdb->prefix}usermeta um5
          ON
            u.ID = um5.user_id
        WHERE
      	(
          um.meta_key = 'delivery_zips'
          AND
      		(".implode(" OR ",$placeholder_arr).")
        )
        AND
          NOT EXISTS (SELECT um.meta_value FROM {$wpdb->prefix}usermeta um2 WHERE um2.user_id = u.ID AND um2.meta_key = 'vendor_turn_off')
        AND
          NOT EXISTS (SELECT um2.meta_value FROM {$wpdb->prefix}usermeta um2 WHERE um2.user_id = u.ID AND um2.meta_key = 'vendor_turn_off')
          and
          (um5.meta_key = 'wp_capabilities' AND um5.meta_value LIKE %s)
        ORDER BY
          CASE u.ID
            WHEN 38 THEN 0
            WHEN 76 THEN 0
                ELSE 1
          END DESC,
          (SELECT um3.meta_value FROM {$wpdb->prefix}usermeta um3 WHERE um3.user_id = u.ID AND um3.meta_key = 'delivery_type') DESC
";

$sql_prepare = $wpdb->prepare($sql, $where);
$users_from_postcode = wp_list_pluck( $wpdb->get_results($sql_prepare), 'ID' );

$userForThisCategory = array();
foreach ($users_from_postcode as $queryUserId) {
    $vendor = get_wcmp_vendor($queryUserId);

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

// pass to backend
$defaultUserArray = array_intersect($users_from_postcode, $userForThisCategory);
$defaultUserString = implode(",", $defaultUserArray);

?>
<input type="hidden" id="landingPageDefaultUserIdAsString" value="<?php echo $defaultUserString;?>">

<section id="citycontent" class="row">
  <div class="container">
    <div class="row d-inline d-lg-none d-xl-none">
      <div class="col-12">
        <h1 class="d-inline d-lg-none d-xl-none my-3 my-xs-3 my-sm-3 my-md-3 my-lg-0 my-xl-0 mb-lg-4 mb-xl-4"><?php the_title();?></h1>
      </div>
    </div>

    <div class="row mt-4 mb-5" id="topoccassions">
    <?php
    // Get the top occassions

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
    $placeHolderImage = wc_placeholder_img_src();
    foreach($occasion_featured_list as $occasion){
      $occasionImageUrl = '';
      if(!empty($occasion->image_src)){
        $occasionImageUrl = wp_get_attachment_image($occasion->image_src, 'vendor-product-box-size', false, array('class' => 'card-img-top', 'alt' => $occasion->name));
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
    <?php
    }
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
              <h6 class="accordion-header float-start filter-header">Vælg leveringsmåde - og filtrér gavehilsner</h6>
            </a>
          </div>
        </div>
        <div class="row py-1 mb-3">
          <h6 class="float-start d-none d-lg-inline d-xl-inline py-2 border-bottom filter-header">Filtrér</h6>
        </div>
        <div class="collapse d-lg-block accordion-collapse " id="colFilter">


          <?php
          $productPriceArray = array(); // for price filter
          $categoryTermListArray = array(); // for cat term filter
          $occasionTermListArray = array();

          // for price filter
          foreach ($defaultUserArray as $vendorId) {
              $vendor = get_wcmp_vendor($vendorId);
              $vendorProducts = $vendor->get_products(array('fields' => 'ids'));
              foreach ($vendorProducts as $productId) {
                  // for price filter begin
                  $singleProduct = wc_get_product( $productId );
                  array_push($productPriceArray, $singleProduct->get_price()); // for price filter
                  // for price filter end

                  // for cat terms filter
                  $categoryTermList = wp_get_post_terms($productId, 'product_cat', array('fields' => 'ids'));
                  foreach($categoryTermList as $catTerm){
                      array_push($categoryTermListArray, $catTerm);
                  }
                  // --

                  // for occassions
                  $occasionTermList = wp_get_post_terms($productId, 'occasion', array('fields' => 'ids'));
                  foreach($occasionTermList as $occasionTerm){
                      array_push($occasionTermListArray, $occasionTerm);
                  }
              }
          }


          /**
           * ---------------------
           * Delivery type filter
           * ---------------------
          **/
          ?>
          <h5 class="text-uppercase mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc107" class="bi bi-star-fill" viewBox="0 0 16 16">
              <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
            </svg>&nbsp;
            Levering
          </h5>
          <ul class="dropdown rounded-3 list-unstyled overflow-hidden mb-4">

          <div class="form-check">
              <input type="checkbox" name="filter_del_city" class="form-check-input filter-on-lp-page" id="filter_delivery_1" checked="checked" value="1">
              <label class="form-check-label" for="filter_delivery_1">
                Personlig levering fra lokal butik
              </label>
          </div>
          <div class="form-check">
              <input type="checkbox" name="filter_del_city" class="form-check-input filter-on-lp-page" id="filter_delivery_0" checked="checked" value="0">
              <label class="form-check-label" for="filter_delivery_0">
                Forsendelse med fragtfirma
              </label>
          </div>

          </ul>


          <?php
          /**
           * ---------------------
           * Postalcode filter
           * ---------------------
          **/
          if($pc_filter == 1){
          ?>
            <h5 class="text-uppercase mb-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc107" class="bi bi-geo-alt" viewBox="0 0 16 16">
                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
              </svg>
              Postnumre
            </h5>
            <ul class="dropdown rounded-3 list-unstyled overflow-hidden mb-4">

            <?php
            // search users for get filtered category
            foreach($postalcodesForFilter as $postcode){
            ?>
                <div class="form-check">
                    <input type="checkbox" name="filter_postalcode" class="form-check-input filter-on-lp-page" id="filter_postalcode<?php echo $postcode['id']; ?>" value="<?php echo $postcode['postcode']; ?>">
                    <label for="filter_postalcode<?php echo $postcode['id']; ?>" class="form-check-label">
                      <?php echo $postcode['title']; ?>
                    </label>
                </div>
          <?php
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
          <h5 class="text-uppercase mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc107" class="bi bi-calendar3-event" viewBox="0 0 16 16">
              <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z"/>
              <path d="M12 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
            </svg>&nbsp;
            <?php echo ($connection_type == 'category' ? 'Anledning' : 'Kategori'); ?>
          </h5>
          <ul class="dropdown rounded-3 list-unstyled overflow-hidden mb-4">
          <?php
          // Occassion

          // Take the occassion term array and make sure we only get uniques.
          if($connection_type == 'category'){
            $filterTermList = array_unique($occasionTermListArray);
            $args = array(
                'taxonomy'   => "occasion",
                // 'hide_empty' => 1,
                // 'include'    => $ids
            );
            $filterTermListUnique = $filterTermList;
          } else if($connection_type == 'occasion'){
            $filterTermList = array_unique($categoryTermListArray);
            $args = array(
                'taxonomy'   => "product_cat",
                // 'hide_empty' => 1,
                // 'include'    => $ids
            );
            $filterTermListUnique = $filterTermList;
          }

          $productFilterList = get_terms($args);
          foreach($productFilterList as $filter){
            foreach($filterTermListUnique as $filterTerm){
              if($filterTerm == $filter->term_id){ ?>
                <div class="form-check">
                    <input type="checkbox" name="filter_co_lp" class="form-check-input filter-on-lp-page" id="filter_co_<?php echo $filter->term_id; ?>" value="<?php echo $filter->term_id; ?>">
                    <label class="form-check-label" for="filter_co_<?php echo $filter->term_id; ?>"><?php echo $filter->name; ?></label>
                </div>
          <?php
              }
            }
          }
          ?>
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

          <h5 class="text-uppercase mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc107" class="bi bi-cash-coin" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
              <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
              <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
              <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
            </svg>&nbsp;
            Pris
          </h5>
          <form>
            <div id="slideInput" class="my-3">
              <div class="row">
                <div class="col-2 col-xs-2 col-sm-2 col-md-2 col-lg-4 col-xl-3">
                  <input type="text" id="slideStartPoint" class="form-control price-field" data-index="0" value="<?php echo $start_val;?>" readonly/>
                </div>
                <div class="col-2 offset-8 col-xs-2 col-sm-2 offset-xs-8 offset-sm-8 col-md-2 offset-md-8 col-lg-4 offset-lg-4 col-xl-3 offset-xl-6">
                  <input type="text" id="slideEndPoint" class="form-control price-field" data-index="1" value="<?php echo ceil($end_val);?>" readonly/>
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
                      data-slider-max="<?php echo ceil($maxProductPrice); ?>"
                      data-slider-step="1"
                      data-slider-tooltip="hide"
                      data-slider-value="[<?php echo $start_val; ?>,<?php echo ceil($end_val); ?>]"/>
                  </div>
                </div>
              </div>
            </div>
          </form>

        </div> <!-- #colFilter -->
      </div>


      <div class="col-md-12 col-lg-9 mb-5">
        <h1 class="d-none d-lg-block d-xl-block my-3 my-xs-3 my-sm-3 my-md-3 my-lg-0 my-xl-0 mb-lg-4 mb-xl-4"><?php the_title();?></h1>
        <div class="applied-filters row mt-xs-0 mt-sm-0 mt-md-0 mt-2 mb-4 lh-lg">
          <div class="col-12 filter-list">
            <div id="filterfilter_cat0" class="badge rounded-pill border-yellow py-2 px-2 me-1 my-1 my-lg-0 my-xl-0 text-dark dynamic-filters">
                Forsendelse med fragtfirma
              <button type="button" class="btn-close filter-btn-delete" data-filter-id="0" data-label="Forsendelsemedfragtfirma" data-filter-remove="filter_cat0"></button>
            </div>
            <div id="filterfilter_cat1" class="badge rounded-pill border-yellow py-2 px-2 me-1 my-1 my-lg-0 my-xl-0 text-dark dynamic-filters">
                Personlig levering fra lokal butik
              <button type="button" class="btn-close filter-btn-delete" data-filter-id="1" data-label="Personligleveringfralokalbutik" data-filter-remove="filter_cat1"></button>
            </div>
            <a href="<?php echo home_url(); ?>"class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 text-dark">
              <?php echo the_title(); ?>
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
      foreach ($defaultUserArray as $user) {
        $vendor = get_wcmp_vendor($user);
        $image = $vendor->get_image() ? $vendor->get_image('image', array(125, 125)) : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
        ?>
        <div class="store row">
          <div class="col-12">
            <div class="card shadow border-0 mb-3">
              <div class="card-body">
                <div class="row align-items-center">

                  <div class="col-3 text-center">
                    <a href="<?php echo esc_url($vendor->get_permalink()); ?>" class="border-0">
                      <img class="img-fluid rounded-start" src="<?php echo $image;?>" alt="<?php echo $vendor->page_title; ?>" style="max-width: 100px;">
                    </a>
                    <?php $button_text = apply_filters('wcmp_vendor_lists_single_button_text', $vendor->page_title); ?>
                    <a href="<?php echo esc_url($vendor->get_permalink()); ?>" class="text-dark">
                      <h6 class="pt-2"><?php echo esc_html($button_text); ?></h6>
                    </a>
                    <a href="<?php echo esc_url($vendor->get_permalink()); ?>" class="cta rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-3 px-md-4">
                      Gå til butik<span class="d-none d-md-inline"> ></span>
                    </a>
                  </div>


                  <div class="col-9">
                    <div class="row">
                    <?php
                    $vendorProducts = $vendor->get_products(array('fields' => 'all', 'posts_per_page' => 3));
                    foreach ($vendorProducts as $prod) {
                      $product = wc_get_product($prod);
                      $imageId = $product->get_image_id();
                        $uploadedImage = wp_get_attachment_image_url($imageId, 'vendor-product-box-size');
                        $placeHolderImage = wc_placeholder_img_src();
                        $imageUrl;
                        if($uploadedImage != ''){
                          $imageUrl = $uploadedImage;
                        } else {
                          $imageUrl = $placeHolderImage;
                        }
                      ?>
                      <div class="col-6 col-xs-6 col-sm-6 col-md-4">
                        <div class="card border-0">
                            <a href="<?php echo get_permalink($product->get_id());?>">
                              <img src="<?php echo $imageUrl;?>" class="card-img-top" alt="<?php echo $product->get_name();?>">
                            </a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark"><?php echo $product->get_name();?></a></h6>
                                <p class="price">Fra <?php echo $product->get_price();?> kr.</p>
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
                    $delivery_type = get_field('delivery_type','user_'.$vendor->id);
                    $delivery_type = (!empty($delivery_type['0']['value']) ? $delivery_type['0']['value'] : '');
                    if($delivery_type == 1){
                    ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bicycle" viewBox="0 0 16 16">
                      <path d="M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5zm1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139L5.5 6.943zM8 9.057 9.598 6.5H6.402L8 9.057zM4.937 9.5a1.997 1.997 0 0 0-.487-.877l-.548.877h1.035zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765l1.027-1.643zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53L11.55 8.623z"/>
                    </svg> Personlig levering i <?php print get_field('city_name'); ?>
                    <?php
                    } else if($delivery_type == 0) {
                    ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                      <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                    </svg>
                      Sender med fragtfirma til <?php print get_field('city_name'); ?>
                    <?php
                    }
                    ?>
                    <input type="hidden" id="cityName" value="<?php echo get_field('city_name');?>">
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
</section>
<section id="description" class="mt-4 mb-5 pt-5">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <style type="text/css">
        div.lpdesc h1,
        div.lpdesc h2,
        div.lpdesc h3,
        div.lpdesc h4 {
          font-family: 'Rubik', 'Inter', sans-serif;
        }
        div.lpdesc h2 {
          font-size: 20px;
        }
        div.lpdesc h3 {
          font-size: 18px;
        }
        div.lpdesc h4 {
          font-size: 16px;
        }

        h3.altheader  {
          font-family: 'Rubik', 'Inter', sans-serif;
          font-size: 20px;
        }
        </style>
        <div class="lpdesc">
          <?php echo the_content(); ?>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <?php
          $var_plural_array = explode(' ', the_title('','',false) );
        ?>
        <h3 class="altheader pt-3">Vil du sende sende andet end <?php echo strtolower($var_plural_array[0]); ?>? Se alle butikker i <?php echo get_field('city_name', $page_id); ?></h3>
      </div>
      <div class="col-sm-12 col-md-3">
      <?php
      $i++;
      $num = count($postalcodesForFilter);
      $num4 = ceil($num / 4);
      $i = 0;
      foreach($postalcodesForFilter as $postcode){
        echo '<a href="'.get_permalink($postcode['id']).'" class="text-dark fs-6 fw-light py-1">';
        print $postcode['title'];
        echo '</a>';
        echo '<br>';
        if(($i % $num4) == 0){
          print '</div><div class="col-sm-12 col-md-3">';
        }
      }
      ?>
      </div>
    </div>
  </div>
</section>
</main>

<section id="pressmentions" class="pressmentions bg-white">
  <div class="container">
    <div class="row py-5">
      <div class="col-12 col-md-3 pb-3 pb-md-0 d-flex align-items-center text-center">
        <div class="w-100 align-middle" style="font-family: 'Inter',sans-serif;">Greeting.dk har været nævnt i</div>
      </div>
      <div class="col-12 col-md-9">
        <div class="row d-flex align-items-center pb-3 pb-md-0">
          <div class="col-6 col-md-3 align-middle">
            <img class="w-75 align-middle" alt="Jyllands Posten" src="https://www.greeting.dk/wp-content/uploads/2022/08/jyllands-posten-logo.png">
          </div>
          <div class="col-6 col-md-3 align-middle pb-3 pb-md-0">
            <img class="w-75 align-middle" alt="Finans" src="https://www.greeting.dk/wp-content/uploads/2022/08/finans-logo.png">
          </div>
          <div class="col-6 col-md-3 align-middle pb-3 pb-md-0">
            <img class="w-75 align-middle" alt="Mig og Odense" src="https://www.greeting.dk/wp-content/uploads/2022/08/migogodense-logo.png">
          </div>
          <div class="col-6 col-md-3 align-middle pb-3 pb-md-0">
            <img class="w-75 align-middle" alt="Horsens Folkeblad" src="https://www.greeting.dk/wp-content/uploads/2022/08/hsfo-logo.png">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="howitworks" class="bg-light-grey  py-5">
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
    <div class="row pt-5 pb-0">
      <div clsas="col-12">
        <h4 class="text-center pb-5">👋 Howdy - vil du lære Greeting.dk lidt bedre at kende?</h4>
      </div>
      <div class="col-12 pb-3 pb-lg-0 pb-xl-0 col-lg-4">
        <div class="card" style="">
          <img src="https://www.greeting.dk/wp-content/uploads/2022/04/pexels-furkanfdemir-6309844-scaled.jpg" class="card-img-top" alt="<?php echo $store_name; ?>">
          <div class="card-body">
            <h5 class="card-title">Skal din butik være med?</h5>
            <p class="card-text">Skal din butik også være med på Greeting.dk? Vi arbejder altid for et ligeværdigt samarbejde -
              og vil til enhver tid arbejde sammen med dig om at sikre den bedste oplevelse for vores fælles kunder. Vil du være med?</p>
            <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">Du starter lige her</a>
          </div>
        </div>
      </div>
      <div class="col-12 pb-3 pb-lg-0 pb-xl-0 col-lg-4">
        <div class="card" style="">
          <img src="https://www.greeting.dk/wp-content/uploads/2022/04/pexels-secret-garden-931154-scaled.jpg" class="card-img-top" alt="<?php echo $store_name; ?>">
          <div class="card-body">
            <h5 class="card-title">Fortjener dine medarbejdere en hilsen?</h5>
            <p class="card-text">Det er vigtigt at huske dem, du sætter pris på - også på jobbet. Derfor tilbyder vi også firmaer at levere større partiere af medarbejder gaver til eks. jul, påske, sommer - eller gaven til den kommende jubilar.</p>
            <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">Se butikkens udvalg</a>
          </div>
        </div>
      </div>
      <div class="col-12 pb-3 pb-lg-0 pb-xl-0 col-lg-4">
        <div class="card" style="">
          <img src="https://www.greeting.dk/wp-content/uploads/2022/04/pexels-florent-b-2664149-scaled.jpg" class="card-img-top" alt="<?php echo $store_name; ?>">
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

<section id="greeting-footer" class="bg-teal py-5 mt-5 text-light">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center pt-4 pb-5 mb-3 position-relative">
        <div class="">
          <img src="https://www.greeting.dk/wp-content/uploads/2022/04/greeting-pink.png" alt="Greeting.dk" style="width: 150px;">
        </div>
        <div class="position-absolute top-50 start-100">
          <ul class="social">
            <li>
              <a href="#" class="text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" class="float-end" height="40" fill="currentColor" class="bi bi-facebook" viewBox="0 0 18 18">
                  <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                </svg>
              </a>
            </li>
            <li>
              <a href="#">
                <figure class="rounded-circle text-center float-end" style="background-color: #ffffff; width: 40px; height: 40px; padding: 7px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                    <path color="#446a6b" d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                  </svg>
                </figure>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-2 col-xl-2">
        <h6 class="pb-3 text-uppercase">Opdag</h6>
        <ul class="list-unstyled mb-0">
          <li class="pb-1"><a href="#" class="text-white">Påskegaver</a></li>
          <li class="pb-1"><a href="#" class="text-white">Påskegaver</a></li>
          <li class="pb-1"><a href="#" class="text-white">Påskegaver</a></li>
          <li class="pb-1"><a href="#" class="text-white">Påskegaver</a></li>
          <li class="pb-1"><a href="#" class="text-white">Påskegaver</a></li>
          <li class="pb-1"><a href="#" class="text-white">Påskegaver</a></li>
          <li class="pb-1"><a href="#" class="text-white">Påskegaver</a></li>
        </ul>
      </div>
      <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">
        <h6 class="pb-3 text-uppercase">Byer på Greeting.dk</h6>
        <ul class="list-unstyled mb-0">
          <li class="pb-1"><a href="#" class="text-white">Påskegaver</a></li>
          <li class="pb-1"><a href="#" class="text-white">Påskegaver</a></li>
          <li class="pb-1"><a href="#" class="text-white">Påskegaver</a></li>
          <li class="pb-1"><a href="#" class="text-white">Påskegaver</a></li>
          <li class="pb-1"><a href="#" class="text-white">Påskegaver</a></li>
          <li class="pb-1"><a href="#" class="text-white">Påskegaver</a></li>
          <li class="pb-1"><a href="#" class="text-white">Påskegaver</a></li>
        </ul>
      </div>
      <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">
        <h6 class=" mt-3 mt-lg-0 mt-xl-0 pb-3 text-uppercase">Greeting.dk</h6>
        <ul class="list-unstyled mb-0">
          <li class="pb-1"><a href="#" class="text-white">Handelsbetingelser</a></li>
          <li class="pb-1"><a href="#" class="text-white">Privatlivspolitik</a></li>
          <li class="pb-1"><a href="#" class="text-white">Trustpilot</a></li>
          <li class="pb-1"><a href="#" class="text-white">Kontakt</a></li>
        </ul>
      </div>
      <div class="d-none d-lg-inline d-xl-inline col-lg-1">
        <p>
        </p>
      </div>
      <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">
        <h6 class="light mt-3 mt-lg-0 mt-xl-0">Gavehilsner fra danske specialbutikker</h6>
        <p>
          Med Greeting.dk kan du nemt, hurtigt og sikkert sende gaver fra lokale, fysiske specialbutikker.
        </p>
        <p>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#1b4949" class="pr-2 bi bi-envelope" viewBox="0 0 16 16">
          <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
          </svg>
          <a href="mailto:kontakt@greeting.dk" class="ms-2 text-white">kontakt@greeting.dk</a>
        </p>
        <p>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#1b4949" class="pr-2 bi bi-telephone" viewBox="0 0 16 16">
          <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
          </svg>
            <a href="tel:+4512345678" class="ms-2 text-white">(+45) 12 34 56 78</a>
        </p>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>


<script src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">

<script type="text/javascript">
  // Set the slider.
  var slider = new Slider('#sliderPrice', {
    'tooltip_split': true
  });
  slider.on("slideStop", function(sliderValue){
    var val = slider.getValue();
    var min_val = val[0];
    var max_val = val[1];
    document.getElementById("slideStartPoint").value = min_val;
    document.getElementById("slideEndPoint").value = max_val;
  });
</script>

<script type="text/javascript">
  // Start the jQuery
  jQuery(document).ready(function($) {
    var ajaxurl = "<?php echo admin_url('admin-ajax.php');?>";
    var filterOccasionCategoryArray = [];
    var inputPriceRangeArray = [];
    var deliveryIdArray = [];
    var postalArray = [];
    var priceSliderMin = jQuery("#sliderPrice").data("slider-min");
    var priceSliderMax = jQuery("#sliderPrice").data("slider-max");
    // $('#cityPageReset').hide();

    var url_string = window.location.href; //window.location.href
    var url = new URL(url_string);

    var del_url_val = url.searchParams.get("d");
    var cat_url_val = url.searchParams.get("c");
    var postalcode_url_val = url.searchParams.get("pc");
    var price_url_val = url.searchParams.get("price");

    if(del_url_val){
      deliveryIdArray = del_url_val.split(",");

      jQuery.each( deliveryIdArray, function(i,v){
        if(	$("input#filter_delivery_"+v).length){
          $("input#filter_delivery_"+v).prop('checked',true);
        }
      });
    }
    if(cat_url_val){
      filterOccasionCategoryArray = cat_url_val.split(",");

      jQuery.each( filterOccasionCategoryArray, function(i,v){
        if(	$("input#filter_cat"+v).length){
          $("input#filter_cat"+v).prop('checked',true);
        } else if($("input#filter_occ_"+v).length) {
          $("input#filter_occ_"+v).prop('checked',true);
        }
      });
    }
    if(postalcode_url_val){
      postalArray = postalcode_url_val.split(",");

      jQuery.each( postalArray, function(i,v){
        if(	$("input#filter_cat"+v).length){
          $("input#filter_cat"+v).prop('checked',true);
        } else if($("input#filter_occ_"+v).length) {
          $("input#filter_occ_"+v).prop('checked',true);
        }
      });
    }
    if(price_url_val){
      inputPriceRangeArray = price_url_val.split(",");

      var priceRangeMinVal = 0;
      var priceRangeMaxVal = priceSliderMax;
      if(inputPriceRangeArray[0] >= priceSliderMin &&  !isNaN(parseFloat(inputPriceRangeArray[0])) && isFinite(inputPriceRangeArray[0])){
        priceRangeMinVal = inputPriceRangeArray[0];
      }
      if(inputPriceRangeArray[1] <= priceSliderMax &&  !isNaN(parseFloat(inputPriceRangeArray[1])) && isFinite(inputPriceRangeArray[1])){
        priceRangeMaxVal = inputPriceRangeArray[1];
      }

      jQuery("#sliderPrice").data('data-slider-value','['+priceRangeMinVal+','+priceRangeMaxVal+']');
      document.getElementById("slideStartPoint").value = priceRangeMinVal;
      document.getElementById("slideEndPoint").value =  priceRangeMaxVal;
    }

    if(deliveryIdArray.length > 0 && postalArray.length > 0 && filterOccasionCategoryArray.length > 0 && inputPriceRangeArray.length > 0){
      update();
    }

    jQuery(".filter-on-lp-page").click(function(){
      update();

      if(this.checked){
        setFilterBadgeCity(
          $('label[for='+this.id+']').text(),
          this.value,
          'filter_cat'+this.value
        );
      } else {
        removeFilterBadgeCity(
          $('label[for='+this.id+']').text(),
          this.value,
          'filter_cat'+this.value,
          false
        );
      }
    });
    slider.on("slideStop", function(sliderValue){
      update();
    });

    function update(){
      var cityName = $('#cityName').val();
      var postalCode = $('#postalCode').val();
      occCatIdArray = [];
      postalArray = [];
      deliveryIdArray = [];
      inputPriceRangeArray = [];

      $("input:checkbox[name=filter_postalcode]:checked").each(function(){
        postalArray.push($(this).val());
      });
      $("input:checkbox[name=filter_co_lp]:checked").each(function(){
        occCatIdArray.push($(this).val());
      });
      $("input:checkbox[name=filter_del_city]:checked").each(function(){
        deliveryIdArray.push($(this).val());
      });

      var sliderValMin = jQuery("#sliderPrice").data("slider-min");
      var sliderValMax = jQuery("#sliderPrice").data("slider-max");
      inputPriceRangeArray = [
        document.getElementById("slideStartPoint").value,
        document.getElementById("slideEndPoint").value
      ];
      var priceChange = 0;
      if(sliderValMin < document.getElementById("slideStartPoint").value || sliderValMax > document.getElementById("slideEndPoint").value){
        priceChange = 1;
      }

      var data = {
        'action': 'lpFilterAction',
        cityName: cityName,
        landingPageDefaultUserIdAsString: jQuery("#landingPageDefaultUserIdAsString").val(),
        occCatIdArray: occCatIdArray,
        postalArray: postalArray, // this should probably be the raw postal instead of the ID og the post
        deliveryIdArray: deliveryIdArray,
        inputPriceRangeArray: inputPriceRangeArray
      };
      jQuery.post(ajaxurl, data, function(response) {
        jQuery('#defaultStore').hide();
        jQuery('.filteredStore').show();
        jQuery('.filteredStore').html(response);

        if(occCatIdArray.length == 0 && deliveryIdArray.length == 0 && priceChange == 1){
          jQuery('#defaultStore').show();
          jQuery('.filteredStore').hide();
          jQuery('#noVendorFound').hide();
        } else if(occCatIdArray.length == 0 && deliveryIdArray.length == 0 && priceChange == 0){
          jQuery('#defaultStore').show();
          jQuery('.filteredStore').hide();
          jQuery('#noVendorFound').hide();
        }

        var state = { 'd': deliveryIdArray, 'c': occCatIdArray, 'pc' : postalArray, 'p': inputPriceRangeArray }
        var url = '';
        if(deliveryIdArray.length > 0){
          if(url){ 	url += '&'; }
          url += 'd='+deliveryIdArray;
        }
        if(occCatIdArray.length > 0){
          if(url){ 	url += '&'; }
          url += 'c='+occCatIdArray;
        }
        if(postalArray.length > 0){
          if(url){ 	url += '&'; }
          url += 'pc='+postalArray;
        }

        if(inputPriceRangeArray.length > 0 && (inputPriceRangeArray[0] > sliderValMin || inputPriceRangeArray[1] < sliderValMax)){
          if(url){ 	url += '&'; }
          url += 'price='+inputPriceRangeArray;
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
      var elm = document.createElement('div');
      elm.id = 'filter'+dataRemove;
      elm.classList.add('badge', 'rounded-pill', 'border-yellow', 'py-2', 'px-2', 'me-1', 'my-1', 'my-lg-0', 'my-xl-0', 'text-dark', 'dynamic-filters');
      elm.href = '#';
      elm.innerHTML = label;

      elmbtn = document.createElement('button');
      elmbtn.type = 'button';
      elmbtn.classList.add('btn-close', 'filter-btn-delete');
      elmbtn.dataset.filterId = id;
      elmbtn.dataset.label = label.replace(/ /g,'');
      elmbtn.onclick = function(){removeFilterBadgeCity('"'+label.replace(/ /g,'')+'"', id, dataRemove, true);};
      elmbtn.dataset.filterRemove = dataRemove;
      elm.appendChild(elmbtn);

      jQuery('div.filter-list').prepend(elm);
    }
    function removeFilterBadgeCity(label, id, dataRemove, updateVendors){
      if(updateVendors === true){
        var elmId = dataRemove;
        console.log(elmId+' '+dataRemove);
        document.getElementById(elmId).checked = false;
        update();
      }
      jQuery('#filter'+dataRemove).remove();
    }

    // reset filter
    $('#cityPageReset').click(function(){
      $("input:checkbox[name=filter_occa_lp], input:checkbox[name=filter_del_city]").removeAttr("checked");
      var val_max = $("input#sliderPrice").data('slider-max');

      slider.setValue([0,val_max]);
      $("input#sliderPrice").data('slider-value', '[0,'+val_max+']');
      $("input#sliderPrice").data('slider-max', val_max);

      $("input#slideEndPoint").val(val_max);
      $("input#slideStartPoint").val(0);

      occCatIdArray.length = 0;

      $('div.filter-list div.dynamic-filters').remove();

      jQuery('#defaultStore').show();
      jQuery('.filteredStore').hide();
    });
  });

  // Add remove loading class on body element based on Ajax request status
  jQuery(document).on({
    ajaxStart: function(){
      jQuery("div").addClass("loading");
    },
    ajaxStop: function(){
      jQuery("div").removeClass("loading");
    }
  });
</script>


<?php wp_footer(); ?>
