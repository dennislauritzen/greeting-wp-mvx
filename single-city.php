<?php get_header(); ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Rubik:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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
    padding-bottom: 12px;
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
    font-family: 'Rubik','Inter', serif;
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
    font-size: 15px;
    font-weight: 600;
  }
  div.store small {
    font-family: 'Inter', sans-serif;
    font-size: 10px;
    font-weight: 400;
  }

  h1 {
    font-family: 'Rubik','Inter', sans-serif;
    font-weight: 600;
  }

  .store {
    transition: all .15s ease-in-out;
  }
  .store:hover {
    transform: scale(1.015);
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

</style>


<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Offcanvas</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div>
      Some text as placeholder. In real life you can have the elements you have chosen. Like, text, images, lists, etc.
    </div>
    <div class="dropdown mt-3">
      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
        Dropdown button
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
      </ul>
    </div>
  </div>
</div>
<section id="top" class="bg-teal pt-1">
    <div class="container py-4">
      <div class="row">
        <div class="d-flex pb-3 pb-lg-0 pb-xl-0 justify-content-center justify-content-lg-start justify-content-xl-start col-md-12 col-lg-3">
          <!--<img src="https://dev.greeting.dk/wp-content/uploads/2022/04/greeting-pink.png" style="width: 150px;">-->
          <!--<img src="https://dev.greeting.dk/wp-content/uploads/2022/04/Greeting-1.png" style="width: 150px;">-->
          <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/greeting-logo-white.png" style="width: 150px;">
          <!-- <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/greeting-test.png" style="width: 150px;"> -->
        </div>
        <div class="col-md-12 col-lg-5 col-xl-6">
          <form action="" method="" class="position-relative mx-5">
            <label for="" class="screen-reader-text">Indtast det postnummer, du ønsker at sende en gave til - og se udvalget af butikker</label>
            <button type="submit" name="submit" class="top-search-btn rounded-pill position-absolute border-0 end-0 bg-teal p-3 me-1"></button>
            <input type="text" class="top-search-input form-control rounded-pill border-0 py-2" value="5683 Haarby" placeholder="Indtast by eller postnr.">
            <figure class="location-pin position-absolute ms-2 mt-1 top-0" style="padding-top:1px;">
              <svg width="14" height="18" viewBox="0 0 13 17" xmlns="http://www.w3.org/2000/svg">
                <path fill="#4d696b" d="M6.5 0C3.115 0 .361 2.7.361 6.02c0 5.822 5.662 10.69 5.903 10.894a.366.366 0 00.472 0c.241-.205 5.903-5.073 5.903-10.893C12.639 2.7 9.885 0 6.5 0zm0 9.208c-1.795 0-3.25-1.427-3.25-3.187 0-1.76 1.455-3.188 3.25-3.188s3.25 1.428 3.25 3.188c0 1.76-1.455 3.187-3.25 3.187z">
                </path>
              </svg>
            </figure>
            <input type="hidden" name="greeting_topsearch_submit_" value="re54813wfq1_!fe515">
          </form>
        </div>
        <div class="d-none d-lg-inline d-xl-inline d-lg-inline col-lg-4 col-xl-3 right-col text-end">
          <a href="#" class="btn text-white">Log ind</a>
          <a href="#" class="btn btn-create rounded text-white">Opret</a>
          <div class="btn position-relative ms-lg-0 ms-xl-1">
            <span class="position-relative" aria-label="Se kurv">
              <svg width="21" height="23" viewBox="0 0 21 23" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.434 6.967H3.306l-1.418 14.47h17.346L17.82 6.967h-3.124c.065.828.097 1.737.097 2.729h-1.5c0-1.02-.031-1.927-.093-2.729H7.93a35.797 35.797 0 00-.093 2.729h-1.5c0-.992.032-1.9.097-2.729zm.166-1.5C7.126 1.895 8.443.25 10.565.25s3.44 1.645 3.965 5.217h4.65l1.708 17.47H.234l1.712-17.47H6.6zm6.432 0c-.407-2.65-1.27-3.717-2.467-3.717-1.196 0-2.06 1.066-2.467 3.717h4.934z" fill="#ffffff">
                </path>
              </svg>
              <span class="position-absolute start-50 top-0 badge rounded-circle text-white" style="background: #cea09f;">0</span>
            </span>
            <span class="d-inline px-lg-2 px-xl-3 hide-lg text-white">Kurv</span>
          </div>
        </div>
      </div>
    </div>
</section>

<main id="main" class="container"<?php if ( isset( $navbar_position ) && 'fixed_top' === $navbar_position ) : echo ' style="padding-top: 100px;"'; elseif ( isset( $navbar_position ) && 'fixed_bottom' === $navbar_position ) : echo ' style="padding-bottom: 100px;"'; endif; ?>>

<?php
/**
 *
 * Perform start setup
 *
**/
$cityPostalcode = get_post_meta($postId, 'postalcode', true);

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

<input type="hidden" id="cityDefaultUserIdAsString" value="<?php echo $cityDefaultUserIdAsString;?>">


<section id="content" class="row">
  <div class="container">
    <h1 class="my-3 my-xs-3 my-sm-3 my-md-3 my-lg-5 my-xl-5">Send gavehilsner i <?php the_title();?></h1>
    <div class="row">
      <div class="col-md-12 col-lg-3 filter">
        <div class="row d-md-block d-lg-none">
          <div class="py-0 mb-2">
            <a class="btn accordion-button collapsed border-0 px-3 rounded bg-yellow text-white" data-bs-toggle="collapse" href="#colFilter" role="button" aria-expanded="false" aria-controls="collapseExample">
              <h6 class="accordion-header float-start">Filtrér butikker</h6>
            </a>
          </div>
        </div>
        <div class="row py-1 mb-3">
          <h6 class="float-start d-none d-lg-inline d-xl-inline py-2 border-bottom">Filtrér butikker</h6>
        </div>
        <div class="collapse d-lg-block accordion-collapse " id="colFilter">
        <h5 class="text-uppercase">Anledninger</h5>
        <ul class="dropdown rounded-3 list-unstyled overflow-hidden mb-4 px-0">
          <li class="px-0">
            <a class="dropdown-item d-flex align-items-center gap-2 py-2 px-2" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
              </svg>
              Valentinsdag
            </a>
          </li>
          <li class="px-0">
            <a class="dropdown-item d-flex align-items-center gap-2 py-2 px-2" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/>
              </svg>
              Påske
            </a>
          </li>
          <li class="px-0">
            <a class="dropdown-item d-flex align-items-center gap-2 py-2 px-2" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
              </svg>
              Action
            </a>
          </li>
        </ul>

        <h5 class="text-uppercase">Kategorier</h5>
        <ul class="dropdown rounded-3 list-unstyled overflow-hidden mb-4">
          <li class="px-0">
            <a class="dropdown-item d-flex align-items-center gap-2 py-2 px-2" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
              </svg>
              Valentinsdag
            </a>
          </li>
          <li class="px-0">
            <a class="dropdown-item d-flex align-items-center gap-2 py-2 px-2" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/>
              </svg>
              Påske
            </a>
          </li>
          <li class="px-0">
            <a class="dropdown-item d-flex align-items-center gap-2 py-2 px-2" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
              </svg>
              Action
            </a>
          </li>
        </ul>

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
                  <li>
                   <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                       <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                     </svg>
                     <?php echo $category->name; ?>
                   </a>
                  </li>
                  <!--<div class="checkbox">
                      <label><input type="checkbox" name="type" class="vendor_sort_category" value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></label>
                  </div>-->
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
                  <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                      </svg>
                      <?php echo $occasion->name; ?>
                    </a>
                  </li>
                  <!--<div class="checkbox">
                      <label><input type="checkbox" name="type" class="vendor_sort_category" value="<?php echo $occasion->term_id; ?>"><?php echo $occasion->name; ?></label>
                  </div>-->
        <?php   }
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
        <h5>Levering</h5>
        <ul class="dropdown rounded-3 list-unstyled overflow-hidden mb-4">
        <?php
        $args = array (
            'role' => 'dc_vendor'
        );

        // Create the WP_User_Query object
        $userQuery = new WP_User_Query($args);

        // Get the results
        $vendors = $userQuery->get_results();

        $deliveryTypeArray = array();

        foreach($vendors as $vendor){
            $userMetas = get_user_meta($vendor->ID, 'delivery_type', true);
            foreach($userMetas as $deliveryType){
                array_push($deliveryTypeArray, $deliveryType);
            }
        }

        // we need unique item
        $deliveryTypeArrayUnique = array_unique($deliveryTypeArray);

        foreach($deliveryTypeArrayUnique as $delivery){?>
            <li>
              <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                  <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                </svg>
                <?php echo $delivery; ?>
              </a>
            </li>
            <!--<div class="checkbox">
                <label><input type="checkbox" name="type" class="vendor_sort_category" value="<?php echo $delivery; ?>"><?php echo $delivery; ?></label>
            </div>-->
        <?php }
        ?>
        </ul>

        <h5>Pris</h5>
        <!--<label for="price" class="form-label">Pris</label>-->
        <p style="width: 100%;">
          <span class="float-start price-filter-text">149,-</span>
          <span class="float-end price-filter-text">749,-</span>
        </p>
        <input type="range" class="form-range" min="0" max="2500" id="price">
      </div> <!-- #colFilter -->
      </div>
      <div class="col-md-12 col-lg-9">
        <div class="applied-filters row mt-xs-0 mt-sm-0 mt-md-0 mb-3 lh-lg">
          <div class="col-12">
            <a class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 text-dark">Påske <button type="button" class="btn-close" aria-label="Close"></button></a>
            <a class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 text-dark">Påske <button type="button" class="btn-close" aria-label="Close"></button></a>
            <a class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 text-dark">Pris: 250,- til 750,- <button type="button" class="btn-close" aria-label="Close"></button></a>
            <a class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 text-dark">5683 Haarby <button type="button" class="btn-close" aria-label="Close"></button></a>
            <a class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 bg-yellow text-white">Nulstil alle <button type="button" class="btn-close  btn-close-white" aria-label="Close"></button></a>
          </div>
        </div>

        <div class="store row">
          <div class="col-12">
            <div class="card shadow border-0 mb-3">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-3 text-center">
                    <img class="img-fluid rounded-start" src="https://dev.greeting.dk/wp-content/uploads/2022/04/119550939_363089735070099_2663604500059929352_n-150x150.jpg" style="max-width: 100px;">
                    <h6>Den blå dør</h6>
                    <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4">Gå til butik ></a>
                  </div>
                  <div class="col-9">
                    <div class="row">
                      <div class="col-sm-6 col-md-4">
                        <div class="card border-0">
                            <a href="#john"><img src="https://greeting.dk/wp-content/uploads/2022/01/Foraarsbombe_-scaled-aspect-ratio-1000-800-600x600.jpg" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/02/Valentinesbuket-aspect-ratio-1000-800-600x600.jpg" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                      <div class="d-none d-md-inline d-lg-inline d-xl-inline col-sm-6 col-md-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/02/Toerretmoerk-scaled-aspect-ratio-1000-800-1-600x600.jpg" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <small class="text-muted">
                  <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bicycle" viewBox="0 0 16 16">
                      <path d="M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5zm1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139L5.5 6.943zM8 9.057 9.598 6.5H6.402L8 9.057zM4.937 9.5a1.997 1.997 0 0 0-.487-.877l-.548.877h1.035zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765l1.027-1.643zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53L11.55 8.623z"/>
                    </svg>
                    Leverer til: 8000 Aarhus C, 8200 Aarhus N, 8270 Højbjerg
                  </div>
                </small>
              </div>
            </div>
          </div>
        </div>

        <div class="store row">
          <div class="col-12">
            <div class="card shadow border-0 mb-3">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-3 text-center">
                    <img class="img-fluid rounded-start" src="https://dev.greeting.dk/wp-content/uploads/2022/04/119550939_363089735070099_2663604500059929352_n-150x150.jpg" style="max-width: 100px;">
                    <h6>Den blå dør</h6>
                    <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4">Gå til butik ></a>
                  </div>
                  <div class="col-9">
                    <div class="row">
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <small class="text-muted">
                  <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bicycle" viewBox="0 0 16 16">
                      <path d="M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5zm1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139L5.5 6.943zM8 9.057 9.598 6.5H6.402L8 9.057zM4.937 9.5a1.997 1.997 0 0 0-.487-.877l-.548.877h1.035zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765l1.027-1.643zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53L11.55 8.623z"/>
                    </svg>
                    Leverer til: 8000 Aarhus C, 8200 Aarhus N, 8270 Højbjerg
                  </div>
                </small>
              </div>
            </div>
          </div>
        </div>


        <div class="store row">
          <div class="col-12">
            <div class="card shadow border-0 mb-3">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-3 text-center">
                    <img class="img-fluid rounded-start" src="https://dev.greeting.dk/wp-content/uploads/2022/04/119550939_363089735070099_2663604500059929352_n-150x150.jpg" style="max-width: 100px;">
                    <h6>Den blå dør</h6>
                    <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4">Gå til butik ></a>
                  </div>
                  <div class="col-9">
                    <div class="row">
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#john"><img src="https://greeting.dk/wp-content/uploads/2022/01/Foraarsbombe_-scaled-aspect-ratio-1000-800-600x600.jpg" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/02/Valentinesbuket-aspect-ratio-1000-800-600x600.jpg" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/02/Toerretmoerk-scaled-aspect-ratio-1000-800-1-600x600.jpg" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <small class="text-muted">
                  <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bicycle" viewBox="0 0 16 16">
                      <path d="M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5zm1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139L5.5 6.943zM8 9.057 9.598 6.5H6.402L8 9.057zM4.937 9.5a1.997 1.997 0 0 0-.487-.877l-.548.877h1.035zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765l1.027-1.643zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53L11.55 8.623z"/>
                    </svg>
                    Leverer til: 8000 Aarhus C, 8200 Aarhus N, 8270 Højbjerg
                  </div>
                </small>
              </div>
            </div>
          </div>
        </div>

        <div class="store row">
          <div class="col-12">
            <div class="card shadow border-0 mb-3">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-3 text-center">
                    <img class="img-fluid rounded-start" src="https://dev.greeting.dk/wp-content/uploads/2022/04/119550939_363089735070099_2663604500059929352_n-150x150.jpg" style="max-width: 100px;">
                    <h6>Den blå dør</h6>
                    <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4">Gå til butik ></a>
                  </div>
                  <div class="col-9">
                    <div class="row">
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <small class="text-muted">
                  <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bicycle" viewBox="0 0 16 16">
                      <path d="M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5zm1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139L5.5 6.943zM8 9.057 9.598 6.5H6.402L8 9.057zM4.937 9.5a1.997 1.997 0 0 0-.487-.877l-.548.877h1.035zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765l1.027-1.643zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53L11.55 8.623z"/>
                    </svg>
                    Leverer til: 8000 Aarhus C, 8200 Aarhus N, 8270 Højbjerg
                  </div>
                </small>
              </div>
            </div>
          </div>
        </div>


        <div class="store row">
          <div class="col-12">
            <div class="card shadow border-0 mb-3">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-3 text-center">
                    <img class="img-fluid rounded-start" src="https://dev.greeting.dk/wp-content/uploads/2022/04/119550939_363089735070099_2663604500059929352_n-150x150.jpg" style="max-width: 100px;">
                    <h6>Den blå dør</h6>
                    <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4">Gå til butik ></a>
                  </div>
                  <div class="col-9">
                    <div class="row">
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#john"><img src="https://greeting.dk/wp-content/uploads/2022/01/Foraarsbombe_-scaled-aspect-ratio-1000-800-600x600.jpg" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/02/Valentinesbuket-aspect-ratio-1000-800-600x600.jpg" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/02/Toerretmoerk-scaled-aspect-ratio-1000-800-1-600x600.jpg" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <small class="text-muted">
                  <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bicycle" viewBox="0 0 16 16">
                      <path d="M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5zm1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139L5.5 6.943zM8 9.057 9.598 6.5H6.402L8 9.057zM4.937 9.5a1.997 1.997 0 0 0-.487-.877l-.548.877h1.035zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765l1.027-1.643zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53L11.55 8.623z"/>
                    </svg>
                    Leverer til: 8000 Aarhus C, 8200 Aarhus N, 8270 Højbjerg
                  </div>
                </small>
              </div>
            </div>
          </div>
        </div>

        <div class="store row">
          <div class="col-12">
            <div class="card shadow border-0 mb-3">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-3 text-center">
                    <img class="img-fluid rounded-start" src="https://dev.greeting.dk/wp-content/uploads/2022/04/119550939_363089735070099_2663604500059929352_n-150x150.jpg" style="max-width: 100px;">
                    <h6>Den blå dør</h6>
                    <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4">Gå til butik ></a>
                  </div>
                  <div class="col-9">
                    <div class="row">
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <small class="text-muted">
                  <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bicycle" viewBox="0 0 16 16">
                      <path d="M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5zm1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139L5.5 6.943zM8 9.057 9.598 6.5H6.402L8 9.057zM4.937 9.5a1.997 1.997 0 0 0-.487-.877l-.548.877h1.035zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765l1.027-1.643zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53L11.55 8.623z"/>
                    </svg>
                    Leverer til: 8000 Aarhus C, 8200 Aarhus N, 8270 Højbjerg
                  </div>
                </small>
              </div>
            </div>
          </div>
        </div>


        <div class="store row">
          <div class="col-12">
            <div class="card shadow border-0 mb-3">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-3 text-center">
                    <img class="img-fluid rounded-start" src="https://dev.greeting.dk/wp-content/uploads/2022/04/119550939_363089735070099_2663604500059929352_n-150x150.jpg" style="max-width: 100px;">
                    <h6>Den blå dør</h6>
                    <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4">Gå til butik ></a>
                  </div>
                  <div class="col-9">
                    <div class="row">
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#john"><img src="https://greeting.dk/wp-content/uploads/2022/01/Foraarsbombe_-scaled-aspect-ratio-1000-800-600x600.jpg" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/02/Valentinesbuket-aspect-ratio-1000-800-600x600.jpg" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/02/Toerretmoerk-scaled-aspect-ratio-1000-800-1-600x600.jpg" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <small class="text-muted">
                  <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bicycle" viewBox="0 0 16 16">
                      <path d="M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5zm1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139L5.5 6.943zM8 9.057 9.598 6.5H6.402L8 9.057zM4.937 9.5a1.997 1.997 0 0 0-.487-.877l-.548.877h1.035zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765l1.027-1.643zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53L11.55 8.623z"/>
                    </svg>
                    Leverer til: 8000 Aarhus C, 8200 Aarhus N, 8270 Højbjerg
                  </div>
                </small>
              </div>
            </div>
          </div>
        </div>

        <div class="store row">
          <div class="col-12">
            <div class="card shadow border-0 mb-3">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-3 text-center">
                    <img class="img-fluid rounded-start" src="https://dev.greeting.dk/wp-content/uploads/2022/04/119550939_363089735070099_2663604500059929352_n-150x150.jpg" style="max-width: 100px;">
                    <h6>Den blå dør</h6>
                    <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4">Gå til butik ></a>
                  </div>
                  <div class="col-9">
                    <div class="row">
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p style="font-size: 13px;">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <small class="text-muted">
                  <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bicycle" viewBox="0 0 16 16">
                      <path d="M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5zm1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139L5.5 6.943zM8 9.057 9.598 6.5H6.402L8 9.057zM4.937 9.5a1.997 1.997 0 0 0-.487-.877l-.548.877h1.035zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765l1.027-1.643zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53L11.55 8.623z"/>
                    </svg>
                    Leverer til: 8000 Aarhus C, 8200 Aarhus N, 8270 Højbjerg
                  </div>
                </small>
              </div>
            </div>
          </div>
        </div>




      </div>
    </div>
  </div>
</section>
</main>

<section id="greeting-footer" class="bg-teal py-5 mt-5 text-light">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center pt-4 pb-5 mb-3 position-relative">
        <div class="">
          <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/greeting-pink.png" style="width: 150px;">
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
<section id="formal-footer" class="pt-3 pb-1 bg-light-grey">
  <div class="container-fluid">
    <div class="row">
      <div class="col-8">
        © 2022 Greeting.dk · Holmegårdsvej 1, 8270 Højbjerg · CVR: 41 72 68 49
      </div>
      <div class="col-4">
        <ul class="float-end m-0 p-0">
          <li class="" aria-label="Visa logo">
            <figure>
              <svg width="38" height="12" viewBox="0 0 38 12" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.737.209l-2.445 11.434h-2.959L15.78.21h2.958zm12.446 7.383l1.557-4.294.896 4.294h-2.453zm3.302 4.051h2.735L34.83.21h-2.523c-.569 0-1.048.33-1.26.838l-4.439 10.596h3.107l.617-1.707h3.794l.359 1.707zM26.762 7.91c.013-3.017-4.171-3.185-4.144-4.533.01-.41.4-.846 1.255-.958.423-.054 1.592-.098 2.917.512l.518-2.426A7.975 7.975 0 0024.542 0c-2.925 0-4.982 1.553-4.999 3.78-.018 1.646 1.47 2.564 2.589 3.112 1.154.56 1.54.92 1.535 1.42-.008.768-.92 1.107-1.77 1.12-1.488.023-2.35-.402-3.038-.723l-.537 2.507c.693.317 1.968.593 3.29.607 3.108 0 5.14-1.535 5.15-3.913zM14.51.21L9.717 11.643H6.591L4.23 2.518c-.142-.561-.267-.768-.702-1.005C2.818 1.127 1.644.766.611.541l.07-.332h5.034c.64 0 1.218.427 1.364 1.165l1.246 6.617L11.403.21h3.107z" fill="#101974" fill-rule="evenodd">
                </path>
              </svg>
            </figure>
          </li>
          <li class="" aria-label="Master Card logo">
            <figure>
              <svg width="24" height="19" viewBox="0 0 24 19" xmlns="http://www.w3.org/2000/svg">
                <g fill="none">
                  <path d="M4.51 18.286v-1.178a.699.699 0 00-.738-.746.726.726 0 00-.66.334.689.689 0
                  00-.62-.334.62.62 0 00-.55.279v-.232h-.408v1.877h.412v-1.033a.44.44 0 01.46-.498c.27 0 .408.176.408.494v1.044h.412v-1.04a.442.442 0 01.46-.498c.278 0
                  .412.176.412.494v1.044l.412-.007zm6.098-1.877h-.671v-.57h-.412v.57h-.373v.373h.38v.864c0 .435.17.694.652.694.18.001.358-.05.51-.145l-.117-.35a.754.754 0 01-.361.107c-
                  .197 0-.271-.126-.271-.314v-.856h.667l-.004-.373zm3.482-.047a.554.554 0 00-.494.275v-.228h-.405v1.877h.409v-1.053c0-.31.133-.482.392-.482a.665.665 0 01.255.047l.126-
                  .393a.873.873 0 00-.29-.05l.007.007zm-5.264.196a1.403 1.403 0 00-.765-.196c-.475 0-.786.228-.786.6 0 .307.228.495.648.554l.196.028c.224.031.33.09.33.196 0 .145-.149.228-
                  .428.228a1 1 0 01-.624-.197l-.196.318c.238.166.522.252.812.244.542 0 .856-.256.856-.613s-.247-.502-.655-.561l-.197-.028c-.176-.023-.318-.058-.318-.184s.134-.22.358-.22c.206.002.41.058.588.161l.181-
                  .33zm10.935-.196a.554.554 0 00-.495.275v-.228h-.404v1.877h.408v-1.053c0-.31.134-.482.393-.482a.665.665 0 01.255.047l.125-.393a.873.873 0 00-.29-.05l.008.007zm-5.26.981a.948.948 0 001 .982.981.981
                  0 00.676-.224l-.197-.33a.824.824 0 01-.49.17.603.603 0 010-1.202c.177.002.35.061.49.169l.197-.33a.981.981 0 00-.675-.224.948.948 0 00-1.001.982v.007zm3.823 0v-.934h-.408v.228a.712.712 0 00-.589-
                  .275.981.981 0 100 1.963.713.713 0 00.589-.275v.228h.408v-.935zm-1.52 0a.567.567 0 111.133.067.567.567 0 01-1.132-.067zm-4.926-.981a.982.982 0 10.028 1.963c.282.014.56-.077.779-.255l-.196-.303a.893.893 0 01-
                  .546.197.52.52 0 01-.561-.46h1.393v-.157c0-.589-.365-.981-.89-.981l-.007-.004zm0 .365a.465.465 0 01.475.455h-.981a.483.483 0 01.498-.455h.008zm10.228.62v-1.692h-.392v.982a.712.712 0 00-.589-.275.981.981
                  0 100 1.963.713.713 0 00.589-.275v.228h.392v-.93zm.681.666a.196.196 0 01.136.053.183.183 0 01-.06.302.185.185 0 01-.075.016.196.196 0 01-.177-.114.185.185 0 01.041-.204.196.196 0 01.141-.053h-.005zm0
                  .331a.14.14 0 00.103-.043.145.145 0 000-.196.145.145 0 00-.102-.043.147.147 0 00-.105.043.145.145 0 000 .196.145.145 0 00.11.043h-.005zm.012-.233a.076.076 0 01.051.016.05.05 0 01.018.04.047.047 0 01-
                  .014.036.069.069 0 01-.041.018l.057.065h-.045l-.053-.065h-.018v.065h-.037v-.173l.082-.002zm-.043.033v.047h.043a.041.041 0 00.024 0 .02.02 0 000-.017.02.02 0 000-.018.041.041 0 00-.024 0l-.043-.012zm-2.159-
                  .797a.567.567 0 111.133.067.567.567 0 01-1.133-.067zm-13.785 0v-.938h-.408v.228a.712.712 0 00-.589-.275.981.981 0 100 1.963.713.713 0 00.589-.275v.228h.408v-.93zm-1.519 0a.567.567 0 11.57.6.563.563 0 01-.574-.6h.004z" fill="#231F20"></path>
                  <path fill="#FF5F00" d="M8.691 2.11h6.183v11.111H8.691z"></path>
                  <path d="M9.083 7.667a7.054 7.054 0 012.699-5.557 7.066 7.066 0 100 11.111 7.054 7.054 0 01-2.699-5.554z" fill="#EB001B"></path>
                  <path d="M23.215 7.667a7.066 7.066 0 01-11.433 5.554 7.066 7.066 0 000-11.111 7.066 7.066 0 0111.433 5.555v.002zm-.675 4.598v-.41h.092v-.086H22.4v.085h.1v.411h.041zm.454 0v-.496h-.071l-.083.355-.082-.355h-.063v.496h.051v-.372l.077.323h.053l.076-.323v.376l.042-.004z" fill="#F79E1B">
                  </path>
                </g>
              </svg>
            </figure>
          </li>
          <li class="" aria-label="Mobile Pay logo">
            <figure>
            <svg width="18" height="19" viewBox="0 0 18 19" xmlns="http://www.w3.org/2000/svg">
            <defs>
            <linearGradient x1="48.743%" y1="76.002%" x2="52.403%" y2="-.583%" id="a">
            <stop stop-color="#504678" offset="0%"></stop>
            <stop stop-color="#504678" stop-opacity=".616" offset="30.2%"></stop>
            <stop stop-color="#504678" stop-opacity=".283" offset="60.8%"></stop>
            <stop stop-color="#504678" stop-opacity=".076" offset="85.2%"></stop>
            <stop stop-color="#504678" stop-opacity="0" offset="100%"></stop>
            </linearGradient>
            <linearGradient x1="13.702%" y1="66.341%" x2="57.382%" y2="41.255%" id="b">
            <stop stop-color="#504678" offset="0%"></stop>
            <stop stop-color="#504678" stop-opacity=".872" offset="17.9%"></stop>
            <stop stop-color="#504678" stop-opacity=".536" offset="52.6%"></stop>
            <stop stop-color="#504678" stop-opacity="0" offset="100%"></stop>
            </linearGradient>
            <linearGradient x1="47.724%" y1="34.971%" x2="45.261%" y2="18.375%" id="c">
            <stop stop-color="#504678" offset="0%"></stop>
            <stop stop-color="#504678" stop-opacity=".332" offset="64.3%"></stop>
            <stop stop-color="#504678" stop-opacity="0" offset="100%"></stop>
            </linearGradient></defs><g fill="none">
            <path d="M7.044 18.498c-.633 0-1.204-.38-1.446-.965L.2 4.503a1.563 1.563 0 01.846-2.042L6.699.12a1.562 1.562 0 012.042.845l5.397 13.03a1.564 1.564 0 01-.846 2.042L7.64 18.379a1.555 1.555 0 01-.595.12zM7.297.842a.72.72 0 00-.276.055L1.368 3.238a.721.721 0 00-.39.943l5.397 13.03a.722.722 0 00.942.391l5.654-2.343a.721.721 0 00.39-.942L7.963 1.287a.722.722 0 00-.666-.445z" fill="#5A78FF">
            </path>
            <path fill="url(#a)" opacity=".7" style="mix-blend-mode:multiply;" transform="rotate(-22.5 9.831 4.565)" d="M9.356 1.773h1v5.584h-1z"></path>
            <path fill="url(#a)" opacity=".7" style="mix-blend-mode:multiply" transform="rotate(157.5 12.235 10.37)" d="M11.76 7.21h1v6.321h-1z"></path>
            <path d="M12.02 9.58c-1.617.67-2.967 1.595-3.85 2.709L5.89 6.785a9.623 9.623 0 013.851-2.709c1.617-.67 3.25-.995 4.638-.806l2.28 5.504a9.62 9.62 0 00-4.639.806z" fill="#5A78FF"></path>
            <path d="M12.02 9.58c-1.617.67-2.967 1.595-3.85 2.709L5.89 6.785a9.623 9.623 0 013.851-2.709c1.617-.67 3.25-.995 4.638-.806l2.28 5.504a9.62 9.62 0 00-4.639.806z" fill="url(#b)" opacity=".9">
            </path><path d="M12.02 9.58c-1.617.67-2.967 1.595-3.85 2.709L5.89 6.785a9.623 9.623 0 013.851-2.709c1.617-.67 3.25-.995 4.638-.806l2.28 5.504a9.62 9.62 0 00-4.639.806z" fill="url(#c)" opacity=".7"></path>
            <path d="M12.763 11.258c-1.75 0-3.352.338-4.594 1.029V6.72a9.623 9.623 0 014.594-1.028c1.75 0 3.383.325 4.593 1.03v5.565a9.62 9.62 0 00-4.593-1.03z" fill="#5A78FF"></path>
            </g>
            </svg>
            </figure>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>



<div id="content" class="has-sidebar rigid-right-sidebar" >
	<div class="inner">
		<!-- CONTENT WRAPPER -->
		<div id="main" class="fixed box box-common">

            <!-- SIDEBARS -->

                <div class="sidebar">

                    <!--Filter begin-->
                    <?php
                    $postId = get_the_ID();
                    ?>
                    <div style="float: left;">
                        <span id="resetAll" style="border:1px solid salmon; border-radius: 15px; padding:4px 10px;cursor:pointer;">Reset All</span>
                    </div>
                    <div class="clear">
                    </div>
                </div>
            <!-- END OF SIDEBARS -->

            <div class="content_holder">


                <?php
                global $WCMp;
                $frontend_assets_path = $WCMp->plugin_url . 'assets/frontend/';
                $frontend_assets_path = str_replace(array('http:', 'https:'), '', $frontend_assets_path);
                $suffix = defined('WCMP_SCRIPT_DEBUG') && WCMP_SCRIPT_DEBUG ? '' : '.min';
                wp_register_style('wcmp_vendor_list', $frontend_assets_path . 'css/vendor-list' . $suffix . '.css', array(), $WCMp->version);
                wp_style_add_data('wcmp_vendor_list', 'rtl', 'replace');
                wp_enqueue_style('wcmp_vendor_list');
                $block_vendors = wp_list_pluck(wcmp_get_all_blocked_vendors(), 'id');
                $vendors = get_wcmp_vendors( array('exclude'   => $block_vendors), $return = 'id');
                $verified_vendor_list = array();
                foreach ($vendors as $vendor_id) {
                    $vendor_verification_settings = get_user_meta($vendor_id, 'wcmp_vendor_verification_settings', true);
                    $verified_vendor = get_user_meta( $vendor_id, '_verify_vendor', true);
                    $verification_options = get_option('wcmp_vendor_verification_settings_name');
                    $option_enable = $verified = $social = 0;
                    if($verification_options) {
                        foreach($verification_options as $key => $option) {
                            if($option == 'Enable') {
                                if(isset($vendor_verification_settings[$key]['is_verified']) && $vendor_verification_settings[$key]['is_verified'] == 'verified')
                                    $verified++;

                                $option_enable++;
                            }
                        }
                    }
                    if(isset($vendor_verification_settings['social_verification']) && count($vendor_verification_settings['social_verification']) > 1 ){
                        foreach ($vendor_verification_settings['social_verification'] as $provider => $settings) {
                            $key = strtolower(sanitize_text_field($provider));
                            if(get_vendor_verification_settings($key.'_enable') == 'Enable')
                                $social++;
                        }
                    }
                    if( $option_enable == ($verified+$social) || $verified_vendor == 'Enable' ) {
                        $verified_vendor_list[] = $vendor_id;
                    }
                }
                ?>

                <div id="wcmp-store-conatiner">
                    <div id="defaultStoreList" class="wcmp-store-list-wrap">
                        <?php
                        if ($UserIdArrayForCityPostalcode) {
                            foreach ($UserIdArrayForCityPostalcode as $user) {
                                $vendor = get_wcmp_vendor($user);
                                $image = $vendor->get_image() ? $vendor->get_image('image', array(125, 125)) : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
                                $banner = $vendor->get_image('banner') ? $vendor->get_image('banner') : '';
                                ?>

                                <div class="wcmp-store-list">
                                    <?php do_action('wcmp_vendor_lists_single_before_image', $vendor->term_id, $vendor->id); ?>
                                    <div class="wcmp-profile-wrap">
                                        <div class="wcmp-cover-picture" style="background-image: url('<?php if($banner) echo $banner; ?>');"></div>
                                        <div class="store-badge-wrap">
                                            <?php do_action('wcmp_vendor_lists_vendor_store_badges', $vendor); ?>
                                        </div>
                                        <div class="wcmp-store-info">
                                            <div class="wcmp-store-picture">
                                                <img class="vendor_img" src="<?php echo esc_url($image); ?>" id="vendor_image_display">
                                            </div>
                                            <?php
                                                $rating_info = wcmp_get_vendor_review_info($vendor->term_id);
                                                $WCMp->template->get_template('review/rating_vendor_lists.php', array('rating_val_array' => $rating_info));
                                            ?>
                                        </div>
                                    </div>
                                    <?php do_action('wcmp_vendor_lists_single_after_image', $vendor->term_id, $vendor->id); ?>
                                    <div class="wcmp-store-detail-wrap">
                                        <?php do_action('wcmp_vendor_lists_vendor_before_store_details', $vendor); ?>
                                        <ul class="wcmp-store-detail-list">
                                            <li>
                                                <i class="wcmp-font ico-store-icon"></i>
                                                <?php $button_text = apply_filters('wcmp_vendor_lists_single_button_text', $vendor->page_title); ?>
                                                <a href="<?php echo esc_url($vendor->get_permalink()); ?>" class="store-name"><?php echo esc_html($button_text); ?></a>
                                                <?php do_action('wcmp_vendor_lists_single_after_button', $vendor->term_id, $vendor->id); ?>
                                                <?php do_action('wcmp_vendor_lists_vendor_after_title', $vendor); ?>
                                            </li>
                                            <?php if($vendor->get_formatted_address()) : ?>
                                            <li>
                                                <i class="wcmp-font ico-location-icon2"></i>
                                                <p><?php echo esc_html($vendor->get_formatted_address()); ?></p>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                        <?php do_action('wcmp_vendor_lists_vendor_after_store_details', $vendor); ?>
                                    </div>
                                </div>

                                <?php
                            }

                        } else {
                            _e('No verified vendor found!', 'dc-woocommerce-multi-vendor');
                        }
                        ?>
                    </div>

                    <!--show ajax filtered result-->
                    <div id="filteredStoreList" class="wcmp-store-list-wrap">
                    </div>

                </div>
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
                div.loading-custom {
                    overflow: hidden;
                }
                /* Make spinner image visible when body element has the loading class */
                div.loading-custom .overlay {
                    display: block;
                }
            </style>

        </div>
    </div>
</div><!-- END OF MAIN CONTENT -->
<?php wp_footer(); ?>
