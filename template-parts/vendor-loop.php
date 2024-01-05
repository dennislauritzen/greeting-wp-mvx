<?php

global $WCMp;


$cityName = (isset($args['cityName']) ? $args['cityName'] : '');
$postalCode = (isset($args['postalCode']) ? $args['postalCode'] : '');


if($args['vendor']){
  $vendor = $args['vendor'];
  $vendor_id = $vendor->id;
  // $vendor = get_wcmp_vendor($user);
  // $image = $vendor->get_image() ? $vendor->get_image('image', array(125, 125)) : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
  $image = $vendor->get_image('image') ? $vendor->get_image('image', array(125, 125)) : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
  $banner = $vendor->get_image('banner') ? $vendor->get_image('banner', 'woocommerce_single') : 'https://www.greeting.dk/wp-content/uploads/2022/05/pexels-maria-orlova-4947386-1-scaled.jpg';

  // The delivery type of the stores
  $delivery_type = get_field('delivery_type','user_'.$vendor->id);
  $delivery_type = (!empty($delivery_type['0']['value']) ? $delivery_type['0']['value'] : 0);

  // Header text.
  $button_text = apply_filters('wcmp_vendor_lists_single_button_text', $vendor->page_title);

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
  $location = (in_array($vendor_id, array(38,76)) ? str_replace(array('{{city_name}}','{{postalcode}}'),array($cityName,$postalCode), get_field('adress_text_for_greeting_stores', 'option')) : $location);
}


?>
<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4 mb-2 d-flex align-items-stretch store">
  <div class="card shadow border-0 mb-3">
    <img src="<?php echo $banner; ?>" class="card-img-top" alt="<?php echo esc_html($button_text); ?>">
    <div class="card-body d-flex flex-column">
      <a href="<?php echo esc_url($vendor->get_permalink()); ?>" class="text-dark">
        <h5 class="card-title"><?php echo esc_html($button_text); ?></h5>
      </a>
      <div>
        <?php
        if($delivery_type == 0){
        ?>
          <span class="badge text-dark border border-dark text-dark fw-light shadow-none "><?php echo get_field('tag_label_freight_company', 'option'); ?></span>
          <span class="badge text-dark border border-dark text-dark fw-light shadow-none "><?php echo get_field('tag_label_home_delivery', 'option'); ?></span>
          <span class="badge text-dark border border-dark text-dark fw-light shadow-none "><?php echo get_field('tag_label_fast_delivery', 'option'); ?></span>
        <?php
        } else {
          ///////////////////////////
          // Days until delivery
          $delivery_days 		= get_vendor_days_until_delivery($vendor_id);

          if($delivery_days == 0){
            ?>
            <span class="badge text-dark border border-dark text-dark fw-light shadow-none ">Kan levere i dag</span>
            <?php
          } else if($delivery_days == 1){
            ?>
            <span class="badge text-dark border border-dark text-dark fw-light shadow-none ">Kan levere i morgen</span>
            <?php
          } else if($delivery_days == 2){
            ?>
            <span class="badge text-dark border border-dark text-dark fw-light shadow-none ">Kan levere i overmorgen</span>
            <?php
          }
          ?>

          <?php
          ///////////////////////////
          // STORE TYPE TAG
          $store_type = get_field('store_type','user_'.$vendor_id);
          #var_dump($store_type);
          if(!empty($store_type)){
            foreach($store_type as $k => $v){
                if($v['label'] != "1" && $v['label'] != "0"){
                ?>
                <span class="badge text-dark border border-dark fw-light shadow-none "><?php echo $v['label']; ?></span>
                <?php
                }
            } // endforeach store_type
          } // endif $store_type
        }
        ?>
      </div>
      <div class="m-0 mb-1 p-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e1e1e1" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
          <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
        </svg>
        <span class="align-middle" style="font-size: 11px;">
          <?php echo $location; ?>
        </span>
      </div>
      <?php
      ///////////////////////////
      // Get product categories
      //

      ?>
      <!--<div>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e1e1e1" class="bi bi-tags" viewBox="0 0 16 16">
          <path d="M3 2v4.586l7 7L14.586 9l-7-7H3zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2z"/>
          <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1v5.086z"/>
        </svg>
        <span class="align-middle" style="font-size: 11px;">
          Blomster, vin,
        </span>
      </div>-->

      <p class="card-text">
        <?php
        $numwords = 25;
        $description = wp_strip_all_tags($vendor->description);
        $word_arr = explode(" ", $description);
        $description = implode(" ", array_slice( $word_arr, 0, $numwords) );
        echo $description;
        if(count($word_arr) > $numwords){
          echo '...';
        }?>&nbsp;
      </p>

      <!--<p class="lh-sm" style="font-size: 13px !important;">Butikken har flere forskellige gavehilsner, du kan vælge i mellem.</p>-->
      <a
      href="<?php echo esc_url($vendor->get_permalink()); ?>"
      class="cta stretched-link rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-3 px-md-4 mt-auto align-self-start">
        <?php echo get_field('cta_store_label', 'option'); ?>
        <span class="d-none d-md-inline"></span>
      </a>
    </div>
    <div class="card-footer">
      <small class="text-muted">
        <div style="col-12">
          <?php
          if($delivery_type == 1){
          ?>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bicycle" viewBox="0 0 16 16">
            <path d="M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5zm1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139L5.5 6.943zM8 9.057 9.598 6.5H6.402L8 9.057zM4.937 9.5a1.997 1.997 0 0 0-.487-.877l-.548.877h1.035zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765l1.027-1.643zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53L11.55 8.623z"/>
          </svg> Personlig levering i <?php print $cityName; ?>
          <?php
          } else if($delivery_type == 0) {
          ?>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
            <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
          </svg>
            Sender med fragtfirma til <?php print $cityName; ?>
          <?php
          }
          ?>
          <input type="hidden" id="cityName" value="<?php echo the_title();?>">
          <span style="width: 15px;">&nbsp;&nbsp;</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-range" viewBox="0 0 16 16">
            <path d="M9 7a1 1 0 0 1 1-1h5v2h-5a1 1 0 0 1-1-1zM1 9h4a1 1 0 0 1 0 2H1V9z"/>
            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
          </svg>
          <?php
            $opening = get_field('openning', 'user_'.$vendor_id);
            echo get_del_days_text($opening, $delivery_type);
          ?>
        </div>
      </small>
    </div>
  </div>
</div>
