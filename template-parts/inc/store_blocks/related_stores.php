<?php
global $product, $MVX;

$product_id2 = $product->get_id();
$product_meta2 = get_post($product_id2);
$vendor_id2 = $product_meta2->post_author;
$vendor = get_user_meta($vendor_id2);

#$ip_detail_ipinfo = (!empty(call_ip_apis(get_client_ip())) ? call_ip_apis(get_client_ip()) : 0);

if(!empty($ip_detail_ipinfo) AND (isset($ip_detail_ipinfo->postal) || isset($ip_detail_ipinfo->zip))){
  $user_postal = (!empty($ip_detail_ipinfo->postal) ? $ip_detail_ipinfo->postal : $ip_detail_ipinfo->zip);
} else if(!empty($_SESSION['get_user_postal'])){
  $user_postal = $_SESSION['get_user_postal'];
} else {
  $user_postal = '';
}

if(!empty($user_postal)){
  $args = array(
    'role' => 'dc_vendor',
    'orderby' => 'meta_value',
    'meta_key' => 'delivery_zips',
    'order' => 'DESC',
    'number' => 3,
    'meta_query' => array(
      array(
        'key' => 'delivery_zips',
        'value' => $user_postal,
        'compare' => 'LIKE'
      )
    )
  );
} else {
  $postal_code = explode(',', $vendor['delivery_zips'][0]);
  $user_postal = $postal_code[0]?: '8000';

  $args = array(
    'role' => 'dc_vendor',
    'orderby' => 'meta_value',
    'meta_key' => 'delivery_zips',
    'order' => 'DESC',
    'number' => 3,
    'meta_query' => array(
      array(
        'key' => 'delivery_zips',
        'value' => $user_postal,
        'compare' => 'LIKE'
      ),
        array(
            'key' => 'openning',
            'value' => '',
            'compare' => '!='  // Ensures the 'openning' field has a value
        )
    )
  );
}


$query = new WP_User_Query($args);
$results = $query->get_results();
?>
<section id="relatedstores">
  <div class="container">
    <div class="row py-5">
        <?php
        $args = array(
          'post_type' => 'city',
          'posts_per_page' => 1,
          'meta_query' => array(
            array(
              'key' => 'postalcode',
              'value' => $user_postal,
              'compare' => '=',
              'type' => 'numeric'
            )
          ),
          'no_found_rows' => true
        );

        $query_city = new WP_Query($args);
        $city_name = '';

        while ( $query_city->have_posts() ) {
          $query_city->the_post();
          $city_name = get_the_title();
        ?>
          <h4 class="text-center pb-5">🚴 Andre butikker, der leverer til <?php print the_title(); ?></h4>
        <?php }
        ?>
      </div>

    <div class="row">
      <?php

      foreach($results as $k => $v){
        $vendor = get_user_meta($v->ID);
        $vendor_page_slug = get_mvx_vendor($v->ID);

        $image = (!empty($vendor['_vendor_profile_image'])? $vendor['_vendor_profile_image'][0] : '');
        $banner = (!empty($vendor['_vendor_banner'])? $vendor['_vendor_banner'][0] : '');

        $vendor_banner = (!empty(wp_get_attachment_image_src($banner)) ? wp_get_attachment_image_src($banner, 'medium')[0] : '');
        $vendor_picture = (!empty(wp_get_attachment_image_src($image)) ? wp_get_attachment_image_src($image, 'medium')[0] : '');
        #$vendor_url = get_permalink();
        #$vendor_desc = get_user_meta();

        $description2 = (!empty($vendor['_vendor_description'][0]) ? $vendor['_vendor_description'][0] : '');

        if(strlen(wp_strip_all_tags($description2)) >= '98'){
          $description = substr(wp_strip_all_tags($description2), 0, 95).'...';
        } else {
          $description = $description2;
        }

        // call the template with pass $vendor variable
        get_template_part('template-parts/vendor-loop', null, array('vendor' => $vendor_page_slug, 'cityName' => $city_name, 'postalCode' => $user_postal));
      } // endforeach
      ?>
    </div>
  </div>
</section>