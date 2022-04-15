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
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style type="text/css">
  body { background: #ffffff; }
  h1 {
    font-size: 50px;
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
</style>

<!--The correct one: <section id="top" style="min-height: 400px; background-size: cover; background-image: url('<?php echo (empty($banner) ? $WCMp->plugin_url . 'assets/images/banner_placeholder.jpg' : esc_url($banner)); ?>');">-->
<section id="top" class="mb-5" style="min-height: 450px; background-size: cover; background-position: center center; background-image: linear-gradient(rgba(0, 0, 0, 0.35),rgba(0, 0, 0, 0.35)),url('<?php echo (empty($banner) ? 'https://dev.greeting.dk/wp-content/uploads/2022/04/DSC_0564-aspect-ratio-800-700-2-1.jpg' : esc_url($banner)); ?>');">
  <div class="container d-flex align-items-end pb-3" style="height: inherit; min-height: inherit;">
    <div class="row">
      <div class="col-12">
        <h1 class="text-white"><?php echo esc_html($vendor->page_title); ?></h1>
      </div>
      <div class="col-8">
        <div class="text-white">
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

<section id="products_shop">
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-lg-2 filter">
        <div class="row border-bottom py-1 mb-3">
          <h6 class="float-start">Filtrér produkter</h6>
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
      </div>
      <div class="col-lg-9 col-xl-8">
        <div class="row">
          <div class="col-md-6 col-lg-4">
            <div class="card mb-4 border-0">
                <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                <div class="card-body">
                    <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                    <small>Fra 235 kr.</small>
                </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="card mb-4 border-0">
                <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                <div class="card-body">
                    <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                    <small>Fra 235 kr.</small>
                </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="card mb-4 border-0">
                <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                <div class="card-body">
                    <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                    <small>Fra 235 kr.</small>
                </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="card mb-4 border-0">
                <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                <div class="card-body">
                    <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                    <small>Fra 235 kr.</small>
                </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="card mb-4 border-0">
                <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                <div class="card-body">
                    <h6 class="card-title" style="font-size: 12px;"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                    <small>Fra 235 kr.</small>
                </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
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
      <div class="pl-10 col-lg-12 col-xl-2">
        <img class="text-center" src="https://dev.greeting.dk/wp-content/uploads/2022/04/119550939_363089735070099_2663604500059929352_n-150x150.jpg">
        <h6 class="pt-3 pb-2">Den blå dør</h6>
        <p>Adresse 12<br>
        8000 Aarhus C</p>
        <h6>Åbningstider</h6>
        <p>
          Åbningsdage:
          Mandag, tirsdag, onsdag, torsdag.
        </p>
        <p>
          <b>Bemærk</b> - butikken holder lukket 24. og 25. maj 2022.
        </p>
        <h6>Levering</h6>
        <p>
          Butikken kan levere næste dag på åbningsdage ved bestilling inden <b>kl 12:00</b>
        </p>
        <h6>Levering i flg. postnumre</h6>
        <div>
          <a href="#">8543 Hornslet</a>, <a href="#">8700 Horsens</a>
        </div>
        <h6 class="pt-3">Kategorier</h6>
        <div>
          <a href="#">Blomster</a>, <a href="#">Interiør</a>
        </div>
      </div>
    </div>
  </div>
</section>




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
