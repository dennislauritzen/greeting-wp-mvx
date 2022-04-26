<?php
/**
 * The template for displaying archive vendor info
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/archive_vendor_info.php
 *
 * @author      WC Marketplace
 * @package     WCMp/Templates
 * @version     3.7
 */
global $WCMp;
$vendor = get_wcmp_vendor($vendor_id);

$vendor_hide_address = apply_filters('wcmp_vendor_store_header_hide_store_address', get_user_meta($vendor_id, '_vendor_hide_address', true), $vendor->id);
$vendor_hide_phone = apply_filters('wcmp_vendor_store_header_hide_store_phone', get_user_meta($vendor_id, '_vendor_hide_phone', true), $vendor->id);
$vendor_hide_email = apply_filters('wcmp_vendor_store_header_hide_store_email', get_user_meta($vendor_id, '_vendor_hide_email', true), $vendor->id);
$template_class = get_wcmp_vendor_settings('wcmp_vendor_shop_template', 'vendor', 'dashboard', 'template1');
$template_class = apply_filters('can_vendor_edit_shop_template', false) && get_user_meta($vendor_id, '_shop_template', true) ? get_user_meta($vendor_id, '_shop_template', true) : $template_class;
$vendor_hide_description = apply_filters('wcmp_vendor_store_header_hide_description', get_user_meta($vendor_id, '_vendor_hide_description', true), $vendor->id);

$vendor_fb_profile = get_user_meta($vendor_id, '_vendor_fb_profile', true);
$vendor_twitter_profile = get_user_meta($vendor_id, '_vendor_twitter_profile', true);
$vendor_linkdin_profile = get_user_meta($vendor_id, '_vendor_linkdin_profile', true);
$vendor_google_plus_profile = get_user_meta($vendor_id, '_vendor_google_plus_profile', true);
$vendor_youtube = get_user_meta($vendor_id, '_vendor_youtube', true);
$vendor_instagram = get_user_meta($vendor_id, '_vendor_instagram', true);
// Follow code
$wcmp_customer_follow_vendor = get_user_meta( get_current_user_id(), 'wcmp_customer_follow_vendor', true ) ? get_user_meta( get_current_user_id(), 'wcmp_customer_follow_vendor', true ) : array();
$vendor_lists = !empty($wcmp_customer_follow_vendor) ? wp_list_pluck( $wcmp_customer_follow_vendor, 'user_id' ) : array();
$follow_status = in_array($vendor_id, $vendor_lists) ? __( 'Unfollow', 'dc-woocommerce-multi-vendor' ) : __( 'Follow', 'dc-woocommerce-multi-vendor' );
$follow_status_key = in_array($vendor_id, $vendor_lists) ? 'Unfollow' : 'Follow';

// Generate location
$vendor_address = !empty(get_user_meta($vendor_id, '_vendor_address_1', true)) ? get_user_meta($vendor_id, '_vendor_address_1', true) : '';
$vendor_postal = !empty(get_user_meta($vendor_id, '_vendor_postcode', true)) ? get_user_meta($vendor_id, '_vendor_postcode', true) : '';
$vendor_city = !empty(get_user_meta($vendor_id, '_vendor_city', true)) ? get_user_meta($vendor_id, '_vendor_city', true) : '';
$location = '';
if(!empty($vendor_address)){
  $location .= $vendor_address.', ';
}
if(!empty($vendor_postal)){
  $location .= $vendor_postal.' ';
}
if(!empty($vendor_city)){
  $location .= $vendor_city.' ';
}
?>


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Rubik:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style type="text/css">
  body { background: #ffffff; }
  .bg-pink {
    background: #F8F8F8;
  }
  .bg-rose {
    background: #fecbca;
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
  .bg-light-grey {
    background: #F8F8F8;
  }

  h1 {
    font-family: 'Rubik','Inter', sans-serif;
    font-weight: 500;
    font-size: 60px;
  }

  #top {
    border-top: 3px solid #446a6b;
  }
  #top .store-loc {
    font-family: 'Inter',sans-serif;
    font-size: 14px;
    font-weight: 300;
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
  div.rating span.badge {
    font-family: 'Inter',sans-serif;
    font-weight: 300;
  }


  .sticky-top {
    font-family: 'Inter',sans-serif;
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
  .card {
    transition: all .15s ease-in-out;
  }
  .card:hover {
    transform: scale(1.015);
    box-shadow: 0 .5rem .75rem rgba(150,150,150, .175);
  }
  div.card h6.card-title {
    font-family: 'Rubik','Inter', sans-serif;
    font-size: 14px;
    font-weight: 600;
  }
  div.card p.price,
  div.card bdi,
  div.card div.price_hold {
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    font-weight: 400;
  }

3
  .top-search-btn {
    width: 40px;
    height: 35px;
    margin-top: 2px;
    z-index: 1000;
    background-image: url('https://greeting.dk/wp-content/plugins/greeting-marketplace/assets/img/search-icon.svg');
    background-repeat: no-repeat;
    background-position: center center;
  }
  .top-search-input {
    padding-left: 30px;
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
</style>

<section id="top" class="pt-1" style="min-height: 350px; background-size: cover; background-position: center center; background-image: linear-gradient(rgba(0, 0, 0, 0.35),rgba(0, 0, 0, 0.35)),url('<?php echo (empty($banner) ? 'https://dev.greeting.dk/wp-content/uploads/2022/04/pexels-furkanfdemir-6309844-1-scaled.jpg' : esc_url($banner)); ?>');">
  <div class="container py-4">
    <div class="row">
      <div class="d-flex pb-3 pb-lg-0 pb-xl-0 position-relative justify-content-center justify-content-lg-start justify-content-xl-start col-md-12 col-lg-3">
        <a href="<?php echo home_url(); ?>">
          <!--<img src="https://dev.greeting.dk/wp-content/uploads/2022/04/greeting-pink.png" style="width: 150px;">-->
          <!--<img src="https://dev.greeting.dk/wp-content/uploads/2022/04/Greeting-1.png" style="width: 150px;">-->
          <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/greeting-logo-white.png" style="text-align: center; width: 150px;">
          <!-- <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/greeting-test.png" style="width: 150px;"> -->
        </a>
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
        <a href="#" class="btn bg-teal rounded text-white">Opret</a>
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
  <div class="container d-flex align-items-end" style="height: inherit; min-height: inherit;">
    <div class="row">
      <div class="col-12 m-0 p-0">
        <h1 class="text-white m-0 p-0"><?php echo ucfirst(esc_html($vendor->page_title)); ?></h1>
      </div>
      <div class="col-12">
        <div class="rating pb-2">
          <?php
          if (get_wcmp_vendor_settings('is_sellerreview', 'general') == 'Enable') {
            $vendor_term_id = get_user_meta( wcmp_find_shop_page_vendor(), '_vendor_term_id', true );
            $rating_val_array = wcmp_get_vendor_review_info($vendor_term_id);
            $WCMp->template->get_template('review/rating.php', array('rating_val_array' => $rating_val_array));
          }
          ?>
        </div>
      </div>
      <div class="col-12">
        <div class="store-loc text-white pt-1 pb-5">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
          </svg>
          <?php
            if(!empty($location)){
              echo esc_html($location);
            } ?>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="sticky-top mt-n3 mb-5" style="margin-top: -25px;">
  <div class="container">
    <div class="row">
      <div class="col-12 rounded bg-white py-3 shadow-sm">
        <div class="row align-items-center">
          <div class="col-lg-3" class="p-0 m-0">
            <?php
    					$image = $vendor->get_image() ? $vendor->get_image('image', array(125, 125)) : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
    				?>
            <img class="img-fuid pe-1" style="max-height:75px;"
              src="<?php echo esc_attr($image); ?>">
            <?php echo ucfirst(esc_html($vendor->page_title)); ?>
          </div>
          <div class="col-lg-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
              <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
              <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117zM11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5zM4 1.934V15h6V1.077l-6 .857z"/>
            </svg>
            Butikken leverer
            <?php
            $day_array = array('mandag','tirsdag','onsdag','torsdag','fredag','lørdag','søndag');
            function build_intervals($items, $is_contiguous, $make_interval) {
                  $intervals = array();
                  $end   = false;
                  if(is_array($items) || is_object($items)){
                    foreach ($items as $item) {
                        if (false === $end) {
                            $begin = (int) $item;
                            $end   = (int) $item;
                            continue;
                        }
                        if ($is_contiguous($end, $item)) {
                            $end = (int) $item;
                            continue;
                        }
                        $intervals[] = $make_interval($begin, $end);
                        $begin = (int) $item;
                        $end   = (int) $item;
                    }
                  }
                  if (false !== $end) {
                      $intervals[] = $make_interval($begin, $end);
                  }
                  return $intervals;
              }

              $opening = get_field('openning', 'user_'.$vendor->id);
              $interv = array();
              if(!empty($opening) && is_array($opening) && count($opening) > 0){
                $interv = build_intervals($opening,  function($a, $b) { return ($b - $a) <= 1; }, function($a, $b) { return "{$a}..{$b}"; });
              }
              $i = 1;
              if(count($interv) > 0){
                foreach($interv as $v){
                  $val = explode('..',$v);
                  $start = $day_array[$val[0]];
                  $end = $day_array[$val[1]];
                  if($val[0] != $val[1])
                  {
                    print $start."-".$end;
                  } else {
                    print $start;
                  }
                  if(count($interv) > 1){
                    if(count($interv)-1 == $i){ print " og "; }
                    else if(count($interv) > $i) { print ', ';}
                  }
                  $i++;
                }
              }
            ?>
          </div>
          <div class="col-lg-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
              <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
              <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
            </svg>
            Bestil inden kl.
              <?php echo (!empty(get_field('vendor_drop_off_time', 'user_'.$vendor->id)) ? get_field('vendor_drop_off_time', 'user_'.$vendor->id) : '11'); ?>
            for levering
            <?php
              if(get_field('vendor_require_delivery_day', 'user_'.$vendor->id) == 0)
              {
                echo ' i dag';
              }
                else if(get_field('vendor_require_delivery_day', 'user_'.$vendor->id) == 1)
              {
                echo ' i morgen';
              } else {
                if(!empty(get_field('vendor_require_delivery_day', 'user_'.$vendor->id))){
                  echo ' om '.get_field('vendor_require_delivery_day', 'user_'.$vendor->id)." hverdage";
                } else {
                  echo 'om 2 hverdage';
                }
              }
            ?>
          </div>
          <div class="col-lg-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
              <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
              <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117zM11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5zM4 1.934V15h6V1.077l-6 .857z"/>
            </svg>
            <?php
            $delivery_type = get_field('delivery_type', 'user_'.$vendor->id)[0];
            $del_type = '';
            if(empty($delivery_type['label'])){
              $del_value = $delivery_type;
              $del_type = $delivery_type;
            } else {
              $del_value = $delivery_type['value'];
              $del_type = $delivery_type['label'];
            }

            if($del_value == "1"){
              echo 'Personlig levering til døren';
            } else if($del_value == "0"){
              echo 'Forsendelse med fragtfirma (2-3 hverdages transporttid)';
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
