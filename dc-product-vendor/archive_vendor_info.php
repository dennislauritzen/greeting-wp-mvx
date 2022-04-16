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
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Merriweather:wght@300;400;700;900&family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&family=Rubik:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style type="text/css">
  body { background: #ffffff; }
  .bg-pink {
    background: #F8F8F8;
  }
  .bg-rose {
    background: #fecbca;
  }
  .bg-teal {
    background: #446a6b;
  }
  .bg-light-grey {
    background: #F8F8F8;
  }
  h1 {
    font-weight: 400;
    font-size: 75px;
  }

  #top {

  }
  #top .store-loc {
    font-family: 'Inter',sans-serif;
    font-size: 14px;
    font-weight: 300;
  }

  .sticky-top {
    font-family: 'Inter',sans-serif;
  }

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
  .card {
    transition: all .15s ease-in-out;
  }
  .card:hover {
    transform: scale(1.015);
    box-shadow: 0 .5rem .75rem rgba(150,150,150, .175);
  }


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

<!--The old one: <section id="top" style="min-height: 400px; background-size: cover; background-image: url('<?php echo (empty($banner) ? $WCMp->plugin_url . 'assets/images/banner_placeholder.jpg' : esc_url($banner)); ?>');">-->
<section id="top" class="pt-1" style="min-height: 350px; background-size: cover; background-position: center center; background-image: linear-gradient(rgba(0, 0, 0, 0.35),rgba(0, 0, 0, 0.35)),url('<?php echo (empty($banner) ? 'https://dev.greeting.dk/wp-content/uploads/2022/04/DSC_0564-aspect-ratio-800-700-2-1.jpg' : esc_url($banner)); ?>');">
  <div class="container py-4">
    <div class="row">
      <div class="col-3">
        <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/greeting-pink.png" style="width: 150px;">
      </div>
      <div class="col-6">
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
      <div class="col-3">
        Log ind
        Tilmeld dig
      </div>
    </div>
  </div>
  <div class="container d-flex align-items-end pb-5" style="height: inherit; min-height: inherit;">
    <div class="row">
      <div class="col-12">
        <h1 class="text-white" style="font-family: 'Roboto Slab',serif; font-weight: 700;"><?php echo ucfirst(esc_html($vendor->page_title)); ?></h1>
      </div>
      <div class="col-8">
        <div class="store-loc text-white">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
          </svg>
          <?php echo esc_html($location); ?>
        </div>
      </div>
      <div class="col-4">
        rating<?php
        if (get_wcmp_vendor_settings('is_sellerreview', 'general') == 'Enable') {
            if (wcmp_is_store_page()) {
                $vendor_term_id = get_user_meta( wcmp_find_shop_page_vendor(), '_vendor_term_id', true );
                $rating_val_array = wcmp_get_vendor_review_info($vendor_term_id);
                $WCMp->template->get_template('review/rating.php', array('rating_val_array' => $rating_val_array));
            }
        }
        ?>
      </div>
    </div>
  </div>
</section>
<section class="sticky-top mt-n3 mb-5" style="margin-top: -25px;">
  <div class="container">
    <div class="row">
      <div class="col-12 rounded bg-white py-3 shadow-sm">
        <div class="row align-items-center">
          <div class="col-lg-2" class="p-0 m-0">
            <img class="img-fuid" style="max-height:75px;" src="https://dev.greeting.dk/wp-content/uploads/2022/04/119550939_363089735070099_2663604500059929352_n-150x150.jpg">
            Den blå dør
          </div>
          <div class="col-lg-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
              <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
              <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117zM11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5zM4 1.934V15h6V1.077l-6 .857z"/>
            </svg> Butikken leverer mandag-fredag
          </div>
          <div class="col-lg-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
              <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
              <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
            </svg> Bestil inden kl. 15 for levering næste leveringsdag
          </div>
          <div class="col-lg-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
              <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
              <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117zM11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5zM4 1.934V15h6V1.077l-6 .857z"/>
            </svg> Personlig levering til døren
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="products_shop">
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-lg-2 filter">
        <div class="row border-bottom py-1 mb-3">
          <h6 class="float-start">Filtrér produkter</h6>
        </div>
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
      </div>
      <div class="col-lg-10">
        <div class="row">
          <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card mb-4 border-0">
                <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                <div class="card-body">
                    <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                    <small>Fra 235 kr.</small>
                </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card mb-4 border-0">
                <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                <div class="card-body">
                    <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                    <small>Fra 235 kr.</small>
                </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card mb-4 border-0">
                <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                <div class="card-body">
                    <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                    <small>Fra 235 kr.</small>
                </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card mb-4 border-0">
                <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                <div class="card-body">
                    <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                    <small>Fra 235 kr.</small>
                </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card mb-4 border-0">
                <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                <div class="card-body">
                    <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                    <small>Fra 235 kr.</small>
                </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card mb-4 border-0">
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
      <div class="col-2">
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
      <div class="col-3">
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
      <div class="col-3">
        <h6 class="pb-3 text-uppercase">Greeting.dk</h6>
        <ul class="list-unstyled mb-0">
          <li class="pb-1"><a href="#" class="text-white">Handelsbetingelser</a></li>
          <li class="pb-1"><a href="#" class="text-white">Privatlivspolitik</a></li>
          <li class="pb-1"><a href="#" class="text-white">Trustpilot</a></li>
          <li class="pb-1"><a href="#" class="text-white">Kontakt</a></li>
        </ul>
      </div>
      <div class="col-1">
        <p>
        </p>
      </div>
      <div class="col-3">
        <h6 class="light">Gavehilsner fra danske specialbutikker</h6>
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
</div>


<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>


<?php if ( $template_class == 'template3') { ?>
<div class='wcmp_bannersec_start wcmp-theme01'>
    <div class="wcmp-banner-wrap">
        <?php if($banner != '') { ?>
            <div class='banner-img-cls'>
            <img src="<?php echo esc_url($banner); ?>" class="wcmp-imgcls"/>
            </div>
        <?php } else { ?>
            <img src="<?php echo $WCMp->plugin_url . 'assets/images/banner_placeholder.jpg'; ?>" class="wcmp-imgcls"/>
        <?php } ?>

        <div class='wcmp-banner-area'>
            <div class='wcmp-bannerright'>
                <div class="socialicn-area">
                    <div class="wcmp_social_profile">
                    <?php if ($vendor_fb_profile) { ?> <a target="_blank" href="<?php echo esc_url($vendor_fb_profile); ?>"><i class="wcmp-font ico-facebook-icon"></i></a><?php } ?>
                    <?php if ($vendor_twitter_profile) { ?> <a target="_blank" href="<?php echo esc_url($vendor_twitter_profile); ?>"><i class="wcmp-font ico-twitter-icon"></i></a><?php } ?>
                    <?php if ($vendor_linkdin_profile) { ?> <a target="_blank" href="<?php echo esc_url($vendor_linkdin_profile); ?>"><i class="wcmp-font ico-linkedin-icon"></i></a><?php } ?>
                    <?php if ($vendor_google_plus_profile) { ?> <a target="_blank" href="<?php echo esc_url($vendor_google_plus_profile); ?>"><i class="wcmp-font ico-google-plus-icon"></i></a><?php } ?>
                    <?php if ($vendor_youtube) { ?> <a target="_blank" href="<?php echo esc_url($vendor_youtube); ?>"><i class="wcmp-font ico-youtube-icon"></i></a><?php } ?>
                    <?php if ($vendor_instagram) { ?> <a target="_blank" href="<?php echo esc_url($vendor_instagram); ?>"><i class="wcmp-font ico-instagram-icon"></i></a><?php } ?>
                    <?php do_action( 'wcmp_vendor_store_header_social_link', $vendor_id ); ?>
                    </div>
                </div>
                <div class='wcmp-butn-area'>
                    <?php do_action( 'wcmp_additional_button_at_banner' ); ?>
                </div>
            </div>
        </div>

        <div class='wcmp-banner-below'>
            <div class='wcmp-profile-area'>
                <img src='<?php echo esc_attr($profile); ?>' class='wcmp-profile-imgcls' />
            </div>
            <div>
                <div class="wcmp-banner-middle">
                    <div class="wcmp-heading"><?php echo esc_html($vendor->page_title) ?></div>
                    <!-- Follow button will be added here -->
                    <?php if (get_wcmp_vendor_settings('store_follow_enabled', 'general') == 'Enable') { ?>
                    <button type="button" class="wcmp-butn <?php echo is_user_logged_in() ? 'wcmp-stroke-butn' : ''; ?>" data-vendor_id=<?php echo esc_attr($vendor_id); ?> data-status=<?php echo esc_attr($follow_status_key); ?> ><span></span><?php echo is_user_logged_in() ? esc_attr($follow_status) : esc_html_e('You must logged in to follow', 'dc-woocommerce-multi-vendor'); ?></button>
                    <?php } ?>
                </div>
                <div class="wcmp-contact-deatil">

                    <?php if (!empty($location) && $vendor_hide_address != 'Enable') { ?><p class="wcmp-address"><span><i class="wcmp-font ico-location-icon"></i></span><?php echo esc_html($location); ?></p><?php } ?>

                    <?php if (!empty($mobile) && $vendor_hide_phone != 'Enable') { ?><p class="wcmp-address"><span><i class="wcmp-font ico-call-icon"></i></span><?php echo apply_filters('vendor_shop_page_contact', $mobile, $vendor_id); ?></p><?php } ?>

                    <?php if (!empty($email) && $vendor_hide_email != 'Enable') { ?>
                    <p class="wcmp-address"><a href="mailto:<?php echo apply_filters('vendor_shop_page_email', $email, $vendor_id); ?>" class="wcmp_vendor_detail"><i class="wcmp-font ico-mail-icon"></i><?php echo apply_filters('vendor_shop_page_email', $email, $vendor_id); ?></a></p><?php } ?>

                    <?php
                    if (apply_filters('is_vendor_add_external_url_field', true, $vendor->id)) {
                        $external_store_url = get_user_meta($vendor_id, '_vendor_external_store_url', true);
                        $external_store_label = get_user_meta($vendor_id, '_vendor_external_store_label', true);
                        if (empty($external_store_label))
                            $external_store_label = __('External Store URL', 'dc-woocommerce-multi-vendor');
                        if (isset($external_store_url) && !empty($external_store_url)) {
                            ?><p class="external_store_url"><label><a target="_blank" href="<?php echo apply_filters('vendor_shop_page_external_store', esc_url_raw($external_store_url), $vendor_id); ?>"><?php echo esc_html($external_store_label); ?></a></label></p><?php
                            }
                        }
                        ?>
                    <?php do_action('after_wcmp_vendor_information',$vendor_id);?>
                </div>

                <?php if (!$vendor_hide_description && !empty($description)) { ?>
                    <div class="description_data">
                        <?php echo wp_kses_post(htmlspecialchars_decode( wpautop( $description ), ENT_QUOTES )); ?>
                    </div>
                <?php } ?>

                <!-- Vendor shop custm data show begin -->
                <p>
                    <?php
                    $default_days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                    $openning_days = get_user_meta($vendor_id, 'openning', true); // true for not array return
                    $closed_days = array_diff($default_days, $openning_days);
                    // specific closed day
                    $all_meta_for_user = get_user_meta( $vendor_id );
                    $specific_closed_date = $all_meta_for_user['vendor_closed_day'][0];
                    $specific_closed_day = date("l", strtotime($specific_closed_date));

                    $check_already_have_closed_day = array_search($specific_closed_day, $closed_days);
                    if($check_already_have_closed_day < 0){
                        $closed_days[] = $specific_closed_day;
                    }

                    // check if specific closed day have inside regular oppennings
                    $final_openning_days = array_diff($openning_days, $closed_days);
                    echo "<b>Open:</b> ";
                    $num_of_iteration = count($final_openning_days);
                    $i = 0;
                    foreach($final_openning_days as $open){
                        if(++$i == $num_of_iteration){
                            echo $open;
                        } else {
                            echo $open.", ";
                        }
                    }
                    ?>
                </p>
                <p>
                    <?php
                    $today_day = date("l");
                    $we_are_open = 1;
                    echo "<b>Closed:</b> ";
                    sort($closed_days); // sort the array
                    $cd_num_of_iteration = count($closed_days);
                    $cdi = 0;
                    foreach($closed_days as $closed){
                        if(++$cdi == $cd_num_of_iteration){
                            echo $closed;
                        } else {
                            echo $closed.", ";
                        }
                        if($today_day == $closed){
                            $we_are_open = 0;
                        }
                    }
                    ?>
                </p>
                <p>
                    <?php
                    if($we_are_open == 1){
                        echo "We are open!";
                    }
                    if($we_are_open == 0){
                        echo "We are closed!";
                    }
                    ?>
                </p>
                <!-- Vendor shop custm data show end -->

            </div>

            <div class="wcmp_vendor_rating">
                <?php
                if (get_wcmp_vendor_settings('is_sellerreview', 'general') == 'Enable') {
                    if (wcmp_is_store_page()) {
                        $vendor_term_id = get_user_meta( wcmp_find_shop_page_vendor(), '_vendor_term_id', true );
                        $rating_val_array = wcmp_get_vendor_review_info($vendor_term_id);
                        $WCMp->template->get_template('review/rating.php', array('rating_val_array' => $rating_val_array));
                    }
                }
                ?>
            </div>

        </div>

    </div>
</div>
<?php } elseif ( $template_class == 'template1' ) {
    ?>
    <div class='wcmp_bannersec_start wcmp-theme02'>
        <div class="wcmp-banner-wrap">
        <?php if($banner != '') { ?>
            <div class='banner-img-cls'>
            <img src="<?php echo esc_url($banner); ?>" class="wcmp-imgcls"/>
            </div>
        <?php } else { ?>
            <img src="<?php echo $WCMp->plugin_url . 'assets/images/banner_placeholder.jpg'; ?>" class="wcmp-imgcls"/>
        <?php } ?>
        <div class='wcmp-banner-area'>
            <div class='wcmp-bannerleft'>
                <div class='wcmp-profile-area'>
                    <img src='<?php echo esc_attr($profile); ?>' class='wcmp-profile-imgcls' />
                </div>
                <div class="wcmp-heading"><?php echo esc_html($vendor->page_title); ?></div>

                <div class="wcmp_vendor_rating">
                    <?php
                    if (get_wcmp_vendor_settings('is_sellerreview', 'general') == 'Enable') {
                        if (wcmp_is_store_page()) {
                            $vendor_term_id = get_user_meta( wcmp_find_shop_page_vendor(), '_vendor_term_id', true );
                            $rating_val_array = wcmp_get_vendor_review_info($vendor_term_id);
                            $WCMp->template->get_template('review/rating.php', array('rating_val_array' => $rating_val_array));
                        }
                    }
                    ?>
                </div>
                    <?php if (!empty($location) && $vendor_hide_address != 'Enable') { ?><p class="wcmp-address"><span><i class="wcmp-font ico-location-icon"></i></span><?php echo esc_html($location); ?></p><?php } ?>

                <div class="wcmp-contact-deatil">

                    <?php if (!empty($mobile) && $vendor_hide_phone != 'Enable') { ?><p class="wcmp-address"><span><i class="wcmp-font ico-call-icon"></i></span><?php echo esc_html(apply_filters('vendor_shop_page_contact', $mobile, $vendor_id)); ?></p><?php } ?>

                    <?php if (!empty($email) && $vendor_hide_email != 'Enable') { ?>
                    <p class="wcmp-address"><a href="mailto:<?php echo apply_filters('vendor_shop_page_email', $email, $vendor_id); ?>" class="wcmp_vendor_detail"><i class="wcmp-font ico-mail-icon"></i><?php echo esc_html(apply_filters('vendor_shop_page_email', $email, $vendor_id)); ?></a></p><?php } ?>
                    <?php
                    if (apply_filters('is_vendor_add_external_url_field', true, $vendor->id)) {
                        $external_store_url = get_user_meta($vendor_id, '_vendor_external_store_url', true);
                        $external_store_label = get_user_meta($vendor_id, '_vendor_external_store_label', true);
                        if (empty($external_store_label))
                            $external_store_label = __('External Store URL', 'dc-woocommerce-multi-vendor');
                        if (isset($external_store_url) && !empty($external_store_url)) {
                            ?><p class="external_store_url"><label><a target="_blank" href="<?php echo esc_attr(apply_filters('vendor_shop_page_external_store', esc_url_raw($external_store_url), $vendor_id)); ?>"><?php echo esc_html($external_store_label); ?></a></label></p><?php
                            }
                        }
                        ?>
                    <?php do_action('after_wcmp_vendor_information',$vendor_id);?>
                </div>
            </div>
            <div class='wcmp-bannerright'>
                <div class="socialicn-area">
                    <div class="wcmp_social_profile">
                    <?php if ($vendor_fb_profile) { ?> <a target="_blank" href="<?php echo esc_url($vendor_fb_profile); ?>"><i class="wcmp-font ico-facebook-icon"></i></a><?php } ?>
                    <?php if ($vendor_twitter_profile) { ?> <a target="_blank" href="<?php echo esc_url($vendor_twitter_profile); ?>"><i class="wcmp-font ico-twitter-icon"></i></a><?php } ?>
                    <?php if ($vendor_linkdin_profile) { ?> <a target="_blank" href="<?php echo esc_url($vendor_linkdin_profile); ?>"><i class="wcmp-font ico-linkedin-icon"></i></a><?php } ?>
                    <?php if ($vendor_google_plus_profile) { ?> <a target="_blank" href="<?php echo esc_url($vendor_google_plus_profile); ?>"><i class="wcmp-font ico-google-plus-icon"></i></a><?php } ?>
                    <?php if ($vendor_youtube) { ?> <a target="_blank" href="<?php echo esc_url($vendor_youtube); ?>"><i class="wcmp-font ico-youtube-icon"></i></a><?php } ?>
                    <?php if ($vendor_instagram) { ?> <a target="_blank" href="<?php echo esc_url($vendor_instagram); ?>"><i class="wcmp-font ico-instagram-icon"></i></a><?php } ?>
                    <?php do_action( 'wcmp_vendor_store_header_social_link', $vendor_id ); ?>
                    </div>
                </div>
                <div class='wcmp-butn-area'>
                    <!-- Follow button will be added here -->
                    <?php if (get_wcmp_vendor_settings('store_follow_enabled', 'general') == 'Enable') { ?>
                    <button type="button" class="wcmp-butn <?php echo is_user_logged_in() ? 'wcmp-stroke-butn' : ''; ?>" data-vendor_id=<?php echo esc_attr($vendor_id); ?> data-status=<?php echo esc_attr($follow_status_key); ?> ><span></span><?php echo is_user_logged_in() ? esc_attr($follow_status) : esc_html_e('You must logged in to follow', 'dc-woocommerce-multi-vendor'); ?></button>
                    <?php } ?>
                    <?php do_action( 'wcmp_additional_button_at_banner' ); ?>
                </div>
            </div>

        </div>
        </div>
        <?php if (!$vendor_hide_description && !empty($description)) { ?>
            <div class="description_data">
                <?php echo wp_kses_post(htmlspecialchars_decode( wpautop( $description ), ENT_QUOTES )); ?>
            </div>
        <?php } ?>

        <!-- Vendor shop custm data show begin -->
        <p>
            <?php
            $default_days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
            $openning_days = get_user_meta($vendor_id, 'openning', true); // true for not array return
            $closed_days = array_diff($default_days, $openning_days);
            // specific closed day
            $all_meta_for_user = get_user_meta( $vendor_id );
            $specific_closed_date = $all_meta_for_user['vendor_closed_day'][0];
            $specific_closed_day = date("l", strtotime($specific_closed_date));

            $check_already_have_closed_day = array_search($specific_closed_day, $closed_days);
            if($check_already_have_closed_day < 0){
                $closed_days[] = $specific_closed_day;
            }

            // check if specific closed day have inside regular oppennings
            $final_openning_days = array_diff($openning_days, $closed_days);
            echo "<b>Open:</b> ";
            $num_of_iteration = count($final_openning_days);
            $i = 0;
            foreach($final_openning_days as $open){
                if(++$i == $num_of_iteration){
                    echo $open;
                } else {
                    echo $open.", ";
                }
            }
            ?>
        </p>
        <p>
            <?php
            $today_day = date("l");
            $we_are_open = 1;
            echo "<b>Closed:</b> ";
            sort($closed_days); // sort the array
            $cd_num_of_iteration = count($closed_days);
            $cdi = 0;
            foreach($closed_days as $closed){
                if(++$cdi == $cd_num_of_iteration){
                    echo $closed;
                } else {
                    echo $closed.", ";
                }
                if($today_day == $closed){
                    $we_are_open = 0;
                }
            }
            ?>
        </p>
        <p>
            <?php
            if($we_are_open == 1){
                echo "We are open!";
            }
            if($we_are_open == 0){
                echo "We are closed!";
            }
            ?>
        </p>
        <!-- Vendor shop custm data show end -->
    </div>
<?php } elseif ( $template_class == 'template2' ) {
    ?>
    <div class='wcmp_bannersec_start wcmp-theme03'>
        <div class="wcmp-banner-wrap">
            <?php if($banner != '') { ?>
                <div class='banner-img-cls'>
                <img src="<?php echo esc_url($banner); ?>" class="wcmp-imgcls"/>
                </div>
            <?php } else { ?>
                <img src="<?php echo $WCMp->plugin_url . 'assets/images/banner_placeholder.jpg'; ?>" class="wcmp-imgcls"/>
            <?php } ?>
            <div class='wcmp-banner-area'>
                <div class='wcmp-bannerright'>
                    <div class="socialicn-area">
                        <div class="wcmp_social_profile">
                        <?php if ($vendor_fb_profile) { ?> <a target="_blank" href="<?php echo esc_url($vendor_fb_profile); ?>"><i class="wcmp-font ico-facebook-icon"></i></a><?php } ?>
                        <?php if ($vendor_twitter_profile) { ?> <a target="_blank" href="<?php echo esc_url($vendor_twitter_profile); ?>"><i class="wcmp-font ico-twitter-icon"></i></a><?php } ?>
                        <?php if ($vendor_linkdin_profile) { ?> <a target="_blank" href="<?php echo esc_url($vendor_linkdin_profile); ?>"><i class="wcmp-font ico-linkedin-icon"></i></a><?php } ?>
                        <?php if ($vendor_google_plus_profile) { ?> <a target="_blank" href="<?php echo esc_url($vendor_google_plus_profile); ?>"><i class="wcmp-font ico-google-plus-icon"></i></a><?php } ?>
                        <?php if ($vendor_youtube) { ?> <a target="_blank" href="<?php echo esc_url($vendor_youtube); ?>"><i class="wcmp-font ico-youtube-icon"></i></a><?php } ?>
                        <?php if ($vendor_instagram) { ?> <a target="_blank" href="<?php echo esc_url($vendor_instagram); ?>"><i class="wcmp-font ico-instagram-icon"></i></a><?php } ?>
                        <?php do_action( 'wcmp_vendor_store_header_social_link', $vendor_id ); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class='wcmp-banner-below'>
                <div class='wcmp-profile-area'>
                    <img src='<?php echo esc_attr($profile); ?>' class='wcmp-profile-imgcls' />
                </div>
                <div class="wcmp-heading"><?php echo esc_html($vendor->page_title) ?></div>

                <div class="wcmp_vendor_rating">
                    <?php
                    if (get_wcmp_vendor_settings('is_sellerreview', 'general') == 'Enable') {
                        if (wcmp_is_store_page()) {
                            $vendor_term_id = get_user_meta( wcmp_find_shop_page_vendor(), '_vendor_term_id', true );
                            $rating_val_array = wcmp_get_vendor_review_info($vendor_term_id);
                            $WCMp->template->get_template('review/rating.php', array('rating_val_array' => $rating_val_array));
                        }
                    }
                    ?>
                </div>

                <div class="wcmp-contact-deatil">

                    <?php if (!empty($location) && $vendor_hide_address != 'Enable') { ?><p class="wcmp-address"><span><i class="wcmp-font ico-location-icon"></i></span><?php echo esc_html($location); ?></p><?php } ?>

                    <?php if (!empty($mobile) && $vendor_hide_phone != 'Enable') { ?><p class="wcmp-address"><span><i class="wcmp-font ico-call-icon"></i></span><?php echo apply_filters('vendor_shop_page_contact', $mobile, $vendor_id); ?></p><?php } ?>

                    <?php if (!empty($email) && $vendor_hide_email != 'Enable') { ?>
                    <p class="wcmp-address"><a href="mailto:<?php echo apply_filters('vendor_shop_page_email', $email, $vendor_id); ?>" class="wcmp_vendor_detail"><i class="wcmp-font ico-mail-icon"></i><?php echo apply_filters('vendor_shop_page_email', $email, $vendor_id); ?></a></p><?php } ?>

                    <?php
                    if (apply_filters('is_vendor_add_external_url_field', true, $vendor->id)) {
                        $external_store_url = get_user_meta($vendor_id, '_vendor_external_store_url', true);
                        $external_store_label = get_user_meta($vendor_id, '_vendor_external_store_label', true);
                        if (empty($external_store_label))
                            $external_store_label = __('External Store URL', 'dc-woocommerce-multi-vendor');
                        if (isset($external_store_url) && !empty($external_store_url)) {
                            ?><p class="external_store_url"><label><a target="_blank" href="<?php echo apply_filters('vendor_shop_page_external_store', esc_url_raw($external_store_url), $vendor_id); ?>"><?php echo esc_html($external_store_label); ?></a></label></p><?php
                            }
                        }
                        ?>
                    <?php do_action('after_wcmp_vendor_information',$vendor_id);?>
                </div>

                <?php if (!$vendor_hide_description && !empty($description)) { ?>
                    <div class="description_data">
                        <?php echo wp_kses_post(htmlspecialchars_decode( wpautop( $description ), ENT_QUOTES )); ?>
                    </div>
                <?php } ?>

                <!-- Vendor shop custm data show begin -->
                <p>
                    <?php
                    $default_days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                    $openning_days = get_user_meta($vendor_id, 'openning', true); // true for not array return
                    $closed_days = array_diff($default_days, $openning_days);
                    // specific closed day
                    $all_meta_for_user = get_user_meta( $vendor_id );
                    $specific_closed_date = $all_meta_for_user['vendor_closed_day'][0];
                    $specific_closed_day = date("l", strtotime($specific_closed_date));

                    $check_already_have_closed_day = array_search($specific_closed_day, $closed_days);
                    if($check_already_have_closed_day < 0){
                        $closed_days[] = $specific_closed_day;
                    }

                    // check if specific closed day have inside regular oppennings
                    $final_openning_days = array_diff($openning_days, $closed_days);
                    echo "<b>Open:</b> ";
                    $num_of_iteration = count($final_openning_days);
                    $i = 0;
                    foreach($final_openning_days as $open){
                        if(++$i == $num_of_iteration){
                            echo $open;
                        } else {
                            echo $open.", ";
                        }
                    }
                    ?>
                </p>
                <p>
                    <?php
                    $today_day = date("l");
                    $we_are_open = 1;
                    echo "<b>Closed:</b> ";
                    sort($closed_days); // sort the array
                    $cd_num_of_iteration = count($closed_days);
                    $cdi = 0;
                    foreach($closed_days as $closed){
                        if(++$cdi == $cd_num_of_iteration){
                            echo $closed;
                        } else {
                            echo $closed.", ";
                        }
                        if($today_day == $closed){
                            $we_are_open = 0;
                        }
                    }
                    ?>
                </p>
                <p>
                    <?php
                    if($we_are_open == 1){
                        echo "We are open!";
                    }
                    if($we_are_open == 0){
                        echo "We are closed!";
                    }
                    ?>
                </p>
                <!-- Vendor shop custm data show end -->

                <div class='wcmp-butn-area'>
                    <!-- Follow button will be added here -->
                    <?php if (get_wcmp_vendor_settings('store_follow_enabled', 'general') == 'Enable') { ?>
                    <button type="button" class="wcmp-butn <?php echo is_user_logged_in() ? 'wcmp-stroke-butn' : ''; ?>" data-vendor_id=<?php echo esc_attr($vendor_id); ?> data-status=<?php echo esc_attr($follow_status_key); ?> ><span></span><?php echo is_user_logged_in() ? esc_attr($follow_status) : esc_html_e('You must logged in to follow', 'dc-woocommerce-multi-vendor'); ?></button>
                    <?php } ?>
                    <?php do_action( 'wcmp_additional_button_at_banner' ); ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
// Additional hook after archive description ended
do_action('after_wcmp_vendor_description', $vendor_id);
