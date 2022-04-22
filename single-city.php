<?php get_header(); ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Rubik:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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
  div.store div.card p.price {
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


  /** price filter begin */

	#priceSlider {
		background-color: #ddd !important;
	}

	.ui-widget-content {
		height: 7px !important;
	}

	.ui-slider .ui-slider-handle {
		background-color: #494932 !important;
		border-radius: 8px;
		height: 17px !important;
		width: 17px !important;
	}

	input[type='text'] {
		padding: 4px 15px;
		border: 1px solid #c1c1c1;
	}
	#slideStartPoint {
		max-width: 60px;
		background-color: #c6c6c6;
		color: white;
	}

	#slideEndPoint {
		max-width: 60px;
		background-color: #c6c6c6;
		float: right;
		color: white;
	}
  /** price filter end */

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


<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenu">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="">
      <p>Bliv Butikspartner</p>
      <p>Cases</p>
      <p>Om Greeting.dk</p>
      <p>Kontakt</p>
    </div>
  </div>
</div>
<section id="top" class="bg-teal pt-1">
    <div class="container py-4">
      <div class="row">
        <div class="d-flex pb-3 pb-lg-0 pb-xl-0 position-relative justify-content-center justify-content-lg-start justify-content-xl-start col-md-12 col-lg-3">
          <!--<img src="https://dev.greeting.dk/wp-content/uploads/2022/04/greeting-pink.png" style="width: 150px;">-->
          <!--<img src="https://dev.greeting.dk/wp-content/uploads/2022/04/Greeting-1.png" style="width: 150px;">-->
          <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/greeting-logo-white.png" style="text-align: center; width: 150px;">
          <!-- <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/greeting-test.png" style="width: 150px;"> -->
          <a class="position-absolute top-0 end-0 me-4 d-inline d-lg-none d-xl-none" data-bs-toggle="offcanvas" href="#offcanvasMenu" role="button" aria-controls="offcanvasExample">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#ffffff" class="bi bi-list" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg>
          </a>
        </div>
        <div class="col-md-12 col-lg-5 col-xl-6">
          <form action="" method="" class="position-relative mx-5">
            <label for="" class="screen-reader-text">Indtast det postnummer, du ønsker at sende en gave til - og se udvalget af butikker</label>
            <button type="submit" name="submit" class="top-search-btn rounded-pill position-absolute border-0 end-0 bg-teal p-3 me-1"></button>
            <input type="text" class="top-search-input form-control rounded-pill border-0 py-2" value="5683 Haarby" placeholder="Indtast by eller postnr.">
            <figure class="location-pin position-absolute ms-2 mt-1 top-0" style="padding-top:1px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#333333" class="bi bi-geo-alt" viewBox="0 0 16 16">
                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
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
$postId = get_the_ID();
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

    foreach($occasionTermListArray as $occasion){
      $uploadedOccasionImage = '';
      $placeHolderImage = wc_placeholder_img_src();
      $occasionImageUrl;
      if($uploadedOccasionImage != ''){
        $occasionImageUrl = $uploadedOccasionImage;
      } else {
        $occasionImageUrl = $placeHolderImage;
      }
    ?>
    <div class="col-6 col-md-2">
        <div class="card border-0 shadow-sm">
          <img src="<?php echo $occasionImageUrl;?>" class="card-img-top" alt="Påskegaver">
          <div class="card-body">
            <h5 class="card-title"><?php echo $occasion->name;?></h5>
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
          <!-- <h5 class="text-uppercase">Anledninger</h5>
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
          </ul> -->

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
                    <div class="checkbox">
                        <label><input type="checkbox" name="type" class="vendor_sort_category" value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></label>
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
                    <!-- <li>
                      <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                          <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                        </svg>
                        <?php //echo $occasion->name; ?>
                      </a>
                    </li> -->
                    <div class="checkbox">
                        <label><input type="checkbox" name="type" class="vendor_sort_category" value="<?php echo $occasion->term_id; ?>"><?php echo $occasion->name; ?></label>
                    </div>
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
              <!-- <li>
                <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                  </svg>
                  <?php //echo $delivery; ?>
                </a>
              </li> -->
              <div class="checkbox">
                  <label><input type="checkbox" name="type" class="vendor_sort_category" value="<?php echo $delivery; ?>"><?php echo $delivery; ?></label>
              </div>
          <?php }
          ?>
          </ul>

          <!-- <h5>Pris</h5>
          !--<label for="price" class="form-label">Pris</label>--
          <p style="width: 100%;">
            <span class="float-start price-filter-text">149,-</span>
            <span class="float-end price-filter-text">749,-</span>
          </p>
          <input type="range" class="form-range" min="0" max="2500" id="price"> -->

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
            $minProductPrice = min($productPriceArray);
            $maxProductPrice = max($productPriceArray);
          } 
          ?>

          <div id="priceSliderWrap">
            <h5>Price</h5>
            <form>
                <div id="slideInput">
                    <input type="text" id="slideStartPoint" class="sliderValue text-" data-index="0" value="<?php echo $minProductPrice;?>" readonly/>
                    <input type="text" id="slideEndPoint" class="sliderValue" data-index="1" value="<?php echo $maxProductPrice;?>" readonly/>
                </div>
                <br />
                <div id="priceSlider"></div>
            </form>
          </div>

        </div> <!-- #colFilter -->
      </div>

      <div class="col-md-12 col-lg-9 mb-5">
        <h1 class="d-none d-lg-block d-xl-block my-3 my-xs-3 my-sm-3 my-md-3 my-lg-0 my-xl-0 mb-lg-4 mb-xl-4">Find gavehilsner til <?php the_title();?></h1>
        <div class="applied-filters row mt-xs-0 mt-sm-0 mt-md-0 mt-2 mb-4 lh-lg">
          <div class="col-12 filterItemShow">

            <a class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 text-dark">Påske <button type="button" class="btn-close" aria-label="Close"></button></a>

            <a class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 text-dark">Påske <button type="button" class="btn-close" aria-label="Close"></button></a>
            <a class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 text-dark">Pris: 250,- til 750,- <button type="button" class="btn-close" aria-label="Close"></button></a>
            <a class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 text-dark">5683 Haarby <button type="button" class="btn-close" aria-label="Close"></button></a>

            <a class="badge rounded-pill border-yellow py-2 px-2 my-1 my-lg-0 my-xl-0 bg-yellow text-white">Nulstil alle <button type="button" class="btn-close  btn-close-white" aria-label="Close"></button></a>

            <button id="cityPageReset">Reset</button>
          </div>
        </div>

      
      <?php    
      foreach ($UserIdArrayForCityPostalcode as $user) {
        $vendor = get_wcmp_vendor($user);
        $image = $vendor->get_image() ? $vendor->get_image('image', array(125, 125)) : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
        ?>
        <div id="defaultStore" class="store row">
          <div class="col-12">
            <div class="card shadow border-0 mb-3">
              <div class="card-body">
                <div class="row align-items-center">

                  <div class="col-3 text-center">
                    <img class="img-fluid rounded-start" src="<?php echo $image;?>" style="max-width: 100px;">
                    <?php $button_text = apply_filters('wcmp_vendor_lists_single_button_text', $vendor->page_title); ?>
                    <h6><?php echo esc_html($button_text); ?></h6>
                    <a href="<?php echo esc_url($vendor->get_permalink()); ?>" class="cta rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-3 px-md-4">
                      Gå til butik<span class="d-none d-md-inline"> ></span>
                    </a>
                  </div>


                  <div class="col-9">
                    <div class="row">
                    <?php 
                    $vendorProducts = $vendor->get_products(array('fields' => 'all'));
                    foreach ($vendorProducts as $prod) {
                      $product = wc_get_product($prod);
                      $imageId = $product->get_image_id();
                        $uploadedImage = wp_get_attachment_image_url($imageId);
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
                            <a href="<?php echo get_permalink($product->get_id());?>"><img src="<?php echo $imageUrl;?>" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark"><?php echo $product->get_name();?></a></h6>
                                <p class="price">Fra <?php echo $product->get_price();?> kr.</p>
                            </div>
                        </div>
                      </div>
                    <?php } ?>
                      <!-- <div class="d-none d-md-inline d-lg-inline d-xl-inline col-6 col-xs-6 col-sm-6 col-md-4">
                        <div class="card border-0">
                            <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/02/Toerretmoerk-scaled-aspect-ratio-1000-800-1-600x600.jpg" class="card-img-top" alt="REPLACEME"></a>
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                                <p class="price">Fra 235 kr.</p>
                            </div>
                        </div>
                      </div> -->
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
                    <!-- Leverer til: 8000 Aarhus C, 8200 Aarhus N, 8270 Højbjerg -->
                    Leverer til: <?php
                    $deliveryZip = get_user_meta($user, 'delivery_zips', true);
                    echo $deliveryZip;?>
                  </div>
                </small>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

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
    <div class="row pt-5 pb-0">
      <div clsas="col-12">
        <h4 class="text-center pb-5">👋 Howdy - vil du lære Greeting.dk lidt bedre at kende?</h4>
      </div>
      <div class="col-12 pb-3 pb-lg-0 pb-xl-0 col-lg-4">
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
      <div class="col-12 pb-3 pb-lg-0 pb-xl-0 col-lg-4">
        <div class="card" style="">
          <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/pexels-secret-garden-931154-scaled.jpg" class="card-img-top" alt="<?php echo $store_name; ?>">
          <div class="card-body">
            <h5 class="card-title">Fortjener dine medarbejdere en hilsen?</h5>
            <p class="card-text">Det er vigtigt at huske dem, du sætter pris på - også på jobbet. Derfor tilbyder vi også firmaer at levere større partiere af medarbejder gaver til eks. jul, påske, sommer - eller gaven til den kommende jubilar.</p>
            <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">Se butikkens udvalg</a>
          </div>
        </div>
      </div>
      <div class="col-12 pb-3 pb-lg-0 pb-xl-0 col-lg-4">
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


<script src="https://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">

<script>

	jQuery(document).ready(function() {
		var minPrice = "<?php echo $minProductPrice;?>";
		var maxPrice = "<?php echo $maxProductPrice;?>";
		jQuery("#priceSlider").slider({
			// min: minPrice,
			min: 1,
			max: maxPrice,
			step: 1,
			values: [minPrice, maxPrice],
			slide: function(event, ui) {
				for (var i = 0; i < ui.values.length; ++i) {
					jQuery("input.sliderValue[data-index=" + i + "]").val(ui.values[i]);
				}
			}
		});
	
		jQuery("input.sliderValue").change(function() {
			var $this = jQuery(this);
			jQuery("#priceSlider").slider("values", $this.data("index"), $this.val());
			// var val = jQuery('#priceSlider').slider("option", "values");
		});
		// add class
		jQuery("a").addClass("vendor_sort_category");
	});
</script>


<?php wp_footer(); ?>
