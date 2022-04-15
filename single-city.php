<?php get_header(); ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<style type="text/css">
  .filter h5 {
    font-family: 'Inter', serif;
    font-weight: 500;
    font-size: 12px;
  }
  .filter h6 {
    font-family: 'Inter', serif;
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

  div.applied-filters {
    font-family: 'Inter', sans-serif;
    font-size: 15px;
    font-weight: 200;
  }

  div.store h6.card-title {
    font-family: 'Inter', sans-serif;
    font-size: 15px;
    font-weight: 600;
  }
  div.store small {
    font-family: 'Inter', sans-serif;
    font-size: 10px;
    font-weight: 400;
  }

  h1 {
    font-family: 'Inter', sans-serif;
    font-weight: 900;
  }

  .store {
    transition: all .15s ease-in-out;
  }
  .store:hover {
    transform: scale(1.015);
  }
  .store-btn {
    font-family: 'Inter', sans-serif;
    font-size: 11px;
  }
</style>

<section id="top" class="bg-teal">
    <div class="container py-4">
      <div class="row">
        <div class="col-3">
          <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/Greeting-1.png" style="width: 150px;">
        </div>
        <div class="col-6">
          <input type="text" class="form-control rounded-pill border-0" value="<?= the_title();?>" placeholder="Indtast by eller postnr.">
        </div>
        <div class="col-3">
          Log ind
          Tilmeld dig
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
    <h1 class="my-5">Send gavehilsner i <?php the_title();?></h1>
    <div class="row">
      <div class="col-3 filter">
        <div class="row border-bottom py-1 mb-3">
          <h6 class="float-start">Filtrér butikker</h6>
        </div>
        <h5 class="text-uppercase">Anledninger</h5>
        <ul class="dropdown rounded-3 list-unstyled overflow-hidden mb-4">
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
              </svg>
              Valentinsdag
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/>
              </svg>
              Påske
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
              </svg>
              Action
            </a>
          </li>
        </ul>

        <h5 class="text-uppercase">Kategorier</h5>
        <ul class="dropdown rounded-3 list-unstyled overflow-hidden mb-4">
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
              </svg>
              Valentinsdag
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/>
              </svg>
              Påske
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
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

      </div>
      <div class="col-9">
        <div class="applied-filters row mb-2">
          <div class="col-12">
            <a class="badge rounded-pill border border-primary text-dark">Påske <button type="button" class="btn-close" aria-label="Close"></button></a>
            <a class="badge rounded-pill border border-primary text-dark">Påske <button type="button" class="btn-close" aria-label="Close"></button></a>
            <a class="badge rounded-pill border border-primary text-dark">Pris: 250,- til 750,- <button type="button" class="btn-close" aria-label="Close"></button></a>
            <a class="badge rounded-pill border border-primary text-dark">5683 Haarby <button type="button" class="btn-close" aria-label="Close"></button></a>
            <a class="badge rounded-pill border border-primary bg-primary text-white">Nulstil alle <button type="button" class="btn-close  btn-close-white" aria-label="Close"></button></a>
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
                    <a href="#" class="store-btn btn btn-secondary bg-teal border-0">Gå til butik ></a>
                  </div>
                  <div class="col-9">
                    <div class="row">
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
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
                    <a href="#" class="store-btn btn btn-secondary bg-teal border-0">Gå til butik ></a>
                  </div>
                  <div class="col-9">
                    <div class="row">
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
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
                    <a href="#" class="store-btn btn btn-secondary bg-teal border-0">Gå til butik ></a>
                  </div>
                  <div class="col-9">
                    <div class="row">
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
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

        <div class="row store">
          <div class="col-12">
            <div class="card mb-3">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-2 text-center">
                    <img class="img-fluid rounded-start" src="https://dev.greeting.dk/wp-content/uploads/2022/04/119550939_363089735070099_2663604500059929352_n-150x150.jpg" style="max-width: 100px;">
                    <h6>Den blå dør</h6>
                    <a href="#" class="store-btn btn btn-secondary bg-teal border-0">Gå til butik ></a>
                  </div>
                  <div class="col-10">
                    <div class="row">
                      <div class="col-4">
                        <div class="card border-0 shadow">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0 shadow">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0 shadow">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
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

        <div class="row store">
          <div class="col-12">
            <div class="card mb-3">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-2 text-center">
                    <img class="img-fluid rounded-start" src="https://dev.greeting.dk/wp-content/uploads/2022/04/119550939_363089735070099_2663604500059929352_n-150x150.jpg" style="max-width: 100px;">
                    <h6>Den blå dør</h6>
                    <a href="#" class="store-btn btn btn-secondary bg-teal border-0">Gå til butik ></a>
                  </div>
                  <div class="col-10">
                    <div class="row">
                      <div class="col-4">
                        <div class="card border-0 shadow">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0 shadow">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card border-0 shadow">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
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
            <div class="card mb-3">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-2 text-center">
                    <img class="img-fluid rounded-start" src="https://dev.greeting.dk/wp-content/uploads/2022/04/119550939_363089735070099_2663604500059929352_n-150x150.jpg" style="max-width: 100px;">
                    <h6>Den blå dør</h6>
                    <a href="#" class="store-btn btn btn-secondary bg-teal border-0">Gå til butik ></a>
                  </div>
                  <div class="col-10">
                    <div class="row">
                      <div class="col-4">
                        <div class="card">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
                            </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="card">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <small>Fra 235 kr.</small>
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
