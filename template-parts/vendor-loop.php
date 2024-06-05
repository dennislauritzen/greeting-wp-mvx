<?php

global $MVX;


$cityName = (isset($args['cityName']) ? $args['cityName'] : '');
$postalCode = (isset($args['postalCode']) ? $args['postalCode'] : '');


if($args['vendor']){
  $vendor = $args['vendor'];
  $vendor_id = $vendor->id;
  // $vendor = get_mvx_vendor($user);
  // $image = $vendor->get_image() ? $vendor->get_image('image', array(125, 125)) : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
  $image = $vendor->get_image('image') ? $vendor->get_image('image', array(125, 125)) : $MVX->plugin_url . 'assets/images/WP-stdavatar.png';
  $banner = $vendor->get_image('banner') ? $vendor->get_image('banner', 'woocommerce_single') : 'https://www.greeting.dk/wp-content/uploads/2022/05/pexels-maria-orlova-4947386-1-scaled.jpg';

  // The delivery type of the stores
  $delivery_type = get_field('delivery_type','user_'.$vendor->id);
  $delivery_type = (!empty($delivery_type['0']['value']) ? $delivery_type['0']['value'] : 0);

  // Header text.
  $button_text = apply_filters('mvx_vendor_lists_single_button_text', $vendor->page_title);

  // Delivery text for the card-footer
  $delivery_text = ($delivery_type == 0) ? 'Sender ' : 'Leverer';
  $delivery_preposition = ($delivery_type == 0) ? ' til ' : ' i ';
  $delivery_text = (!empty($cityName)) ? $delivery_text.$delivery_preposition.$cityName : $delivery_text;

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

  ################################
  # GET CATEGORIES AND OCCASIONS FOR THE PRODUCT
    $args = array(
        'author' => $vendor_id,
        'post_type' => 'product',
        'posts_per_page' => -1, // Get all products
    );
    $vendor_products = new WP_Query($args);

    // Categories
    $categories = array();
    if ($vendor_products->have_posts()) {
        while ($vendor_products->have_posts()) {
            $vendor_products->the_post();
            $product_categories = wp_get_post_terms(get_the_ID(), 'product_cat');
            foreach ($product_categories as $product_category) {
                if($product_category->term_id == 16){ continue; }
                $categories[$product_category->term_id] = $product_category->name;
            }
        }
        wp_reset_postdata();
    }

    $categories_string = implode(' · ', array_unique($categories));

    // Occasions
    // Step 3: Extract Unique Terms from the "occasion" Taxonomy
    $occasions = array();
    if ($vendor_products->have_posts()) {
        while ($vendor_products->have_posts()) {
            $vendor_products->the_post();
            $product_occasions = wp_get_post_terms(get_the_ID(), 'occasion');
            foreach ($product_occasions as $product_occasion) {
                $occasions[] = $product_occasion->name;
            }
        }
        wp_reset_postdata();
    }

// Step 4: Concatenate Terms into a String
    $occasions_string = implode(', ', array_unique($occasions));
}


?>

<style type="text/css">
    .storenew .card {
        border-radius: 20px !important;
    }
    .storenew .card-img-top {
        border-top-left-radius: 20px !important;
        border-top-right-radius: 20px !important;
        height: 225px !important;
        min-height: 225px !important;
    }
    .bg-purple-rose {
        background: #B59BFF !important;
    }
</style>



<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4 mb-2 d-flex align-items-stretch storenew">
    <div class="card shadow border-0 mb-3">
        <div class="position-relative">
            <img src="<?php echo $banner; ?>" class="card-img-top" alt="<?php echo esc_html($button_text); ?>">

            <div class="position-absolute top-0 start-0 px-2 pt-1 m-0">
                <?php
                // Get the current date in the WordPress format
                $current_date = new DateTime();

                // Get the repeater field values
                $repeater_field = get_field('notification_labels', 'option');

                if ($repeater_field) {
                    foreach ($repeater_field as $row) {
                        // Get the connected user ID
                        $vendor_user_id_array = $row['vendor'];

                        // Check if the vendor user ID exists and matches the specific vendor ID
                        if( in_array($vendor_id, $vendor_user_id_array) ) {
                            // Get the start and end dates
                            $start_date = DateTime::createFromFormat('d-m-Y H:i:s', $row['startdatetime']);
                            $end_date = DateTime::createFromFormat('d-m-Y H:i:s', $row['enddatetime']);

                            // Check if the current date is within the interval defined by the start and end dates
                            if ($current_date >= $start_date && $current_date <= $end_date) {
                                // Get other fields like text and color
                                $text = $row['labeltext'];
                                $color = $row['badge_color'];

                                if ($color == 'darkyellow') {
                                    echo '<p class="text-white badge rounded-pill bg-yellow m-0 p-0 mt-1 me-1 px-3 py-2 fw-light" style="background-color: #FFD700; font-size: 13px;">' . $text . '</p>';
                                } else if ($color == 'yellow') {
                                    echo '<p class="text-white badge rounded-pill bg-yellow m-0 p-0 mt-1 me-1 px-3 py-2 fw-light" style="font-size: 13px;">' . $text . '</p>';
                                } else if ($color == 'rosepurple') {
                                    echo '<p class="text-white badge rounded-pill bg-purple-rose m-0 p-0 mt-1 me-1 px-3 py-2 fw-light" style="font-size: 13px;">' . $text . '</p>';
                                } else if ($color == 'teal') {
                                    echo '<p class="text-white badge rounded-pill bg-teal m-0 p-0 mt-1 me-1 px-3 py-2 fw-light" style="font-size: 13px;">' . $text . '</p>';
                                } else if ($color == 'pink') {
                                    echo '<p class="text-white badge rounded-pill bg-pink m-0 p-0 mt-1 me-1 px-3 py-2 fw-light" style="background-color: #FECBCA; font-size: 13px;">' . $text . '</p>';
                                }
                            }
                        }
                    }
                }
                ?>
            </div>

            <div class="position-absolute bottom-0 end-0 p-0 m-0">
                <?php
                if($delivery_type == 0){
                ?>
                <div class="overflow-wrap mb-1 w-100 px-2 justify-content-end text-end">
                    <p class="badge rounded-pill m-0 bg-white border-0 text-dark fw-normal" style="--bs-bg-opacity: .8;"><?php echo get_field('tag_label_freight_company', 'option'); ?></p><br>
                    <p class="badge rounded-pill m-0 bg-white border-0 text-dark fw-normal" style="--bs-bg-opacity: .8;"><?php echo get_field('tag_label_home_delivery', 'option'); ?></p>
                    <p class="badge rounded-pill m-0 bg-white border-0 text-dark fw-normal" style="--bs-bg-opacity: .8;"><?php echo get_field('tag_label_fast_delivery', 'option'); ?></p>
                </div>
                <?php
                } else {
                    ///////////////////////////
                    // TAG Days until delivery
                    var_dump($vendor_id);
                    $delivery_days 		= get_vendor_delivery_days_from_today($vendor_id, 'Kan ');
                    ?>
                    <p class="text-white badge rounded-pill rounded-end bg-teal px-3 py-2 fw-light" style="font-size: 14px;"><?php echo $delivery_days; ?></p>
                    <?php
                    ///////////////////////////
                    // TAG STORE TYPE
                    $store_type = get_field('store_type','user_'.$vendor_id);
                    #var_dump($store_type);
                    if(!empty($store_type)){
                        foreach($store_type as $k => $v){
                            if( isset($v['label'])
                                && !in_array($v['label'], array("1","2","3","4","5","6","7"))
                                && $v['label'] != "1"
                                && $v['label'] != "0"
                            ){
                                #echo '<p class="text-white badge rounded-pill rounded-end bg-teal px-3 py-2 fw-light" style="font-size: 14px;">'.$v['label'].'</p>';
                            }
                        } // endforeach store_type
                    } // endif $store_type
                }
                ?>

            </div>
        </div>
        <div class="card-body d-flex flex-column mt-2 px-4">
            <a href="<?php echo esc_url($vendor->get_permalink()); ?>" class="stretched-link text-dark">
                <h5 class="card-title"><?php echo esc_html($button_text); ?></h5>
            </a>
            <div class="m-0 mb-1 p-0">
                <svg width="6" height="18" viewBox="0 0 6 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.63494 5.04125C3.46119 5.07375 3.31994 5.24125 3.31994 5.4225V15.6775C3.31994 15.855 3.17744 16 2.99994 16C2.82369 16 2.67994 15.8588 2.67994 15.6775V5.4225C2.67994 5.245 2.54119 5.07626 2.36744 5.04125C2.36744 5.04125 2.46619 5.06625 2.36244 5.04C1.25745 4.75625 0.439941 3.75376 0.439941 2.56C0.439941 1.14624 1.58618 0 2.99994 0C4.4137 0 5.55994 1.14624 5.55994 2.56C5.55994 3.75126 4.74618 4.75251 3.64493 5.03875C3.53868 5.065 3.63494 5.04125 3.63494 5.04125ZM2.99993 4.48C1.93993 4.48 1.07993 3.62 1.07993 2.56C1.07993 1.5 1.93993 0.640002 2.99993 0.640002C4.05993 0.640002 4.91993 1.5 4.91993 2.56C4.91993 3.62 4.05993 4.48 2.99993 4.48Z" fill="black"/>
                </svg>
                <span class="align-middle" style="padding-left: 4px; font-size: 14px;">
                    <?php echo $location; ?>
                </span>
            </div>
            <div class="m-0 mb-1 p-0">
                <?php if($delivery_type == 1){
                    ?>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="20" height="20" viewBox="0 0 256 256" xml:space="preserve">
                    <defs>
                    </defs>
                        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
                            <path d="M 77.16 71.885 c -3.84 0 -6.964 -3.124 -6.964 -6.963 s 3.124 -6.963 6.964 -6.963 c 3.839 0 6.963 3.124 6.963 6.963 S 80.999 71.885 77.16 71.885 z M 77.16 59.959 c -2.737 0 -4.964 2.227 -4.964 4.963 s 2.227 4.963 4.964 4.963 c 2.736 0 4.963 -2.227 4.963 -4.963 S 79.896 59.959 77.16 59.959 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                            <path d="M 64.313 67.402 c -0.134 0 -0.269 -0.015 -0.404 -0.043 c -0.702 -0.15 -1.245 -0.674 -1.418 -1.366 c -0.941 -3.804 -0.281 -7.744 1.858 -11.097 c 3.179 -4.981 9.411 -7.478 15.16 -6.077 c 4.201 1.024 7.665 3.827 9.504 7.69 c 0.308 0.646 0.22 1.397 -0.229 1.961 c -0.458 0.573 -1.187 0.83 -1.902 0.671 c -7.845 -1.766 -16.114 1.193 -21.079 7.531 C 65.438 67.141 64.891 67.402 64.313 67.402 z M 76.26 50.431 c -4.053 0 -8.006 2.065 -10.225 5.542 c -1.794 2.812 -2.381 6.099 -1.662 9.285 c 5.406 -6.76 14.278 -9.93 22.723 -8.116 c -1.605 -3.2 -4.529 -5.519 -8.06 -6.379 C 78.118 50.539 77.187 50.431 76.26 50.431 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                            <path d="M 36.087 41.271 H 6.046 C 2.712 41.271 0 38.559 0 35.225 v -16.94 c 0 -3.334 2.712 -6.046 6.046 -6.046 h 23.995 c 3.334 0 6.046 2.712 6.046 6.046 V 41.271 z M 6.046 14.238 C 3.815 14.238 2 16.053 2 18.284 v 16.94 c 0 2.231 1.815 4.046 4.046 4.046 h 28.041 V 18.284 c 0 -2.231 -1.815 -4.046 -4.046 -4.046 H 6.046 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                            <path d="M 70.979 33.841 h -0.825 c -3.908 0 -7.087 -3.179 -7.087 -7.086 s 3.179 -7.086 7.087 -7.086 h 0.825 c 1.555 0 2.82 1.265 2.82 2.82 v 8.531 C 73.8 32.575 72.534 33.841 70.979 33.841 z M 70.154 21.668 c -2.805 0 -5.087 2.282 -5.087 5.086 c 0 2.805 2.282 5.086 5.087 5.086 h 0.825 c 0.452 0 0.82 -0.368 0.82 -0.821 v -8.531 c 0 -0.452 -0.368 -0.82 -0.82 -0.82 H 70.154 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                            <path d="M 59.517 23.493 c -1.043 0 -7.03 -0.99 -7.03 -3.593 s 5.987 -3.593 7.03 -3.593 c 1.981 0 3.593 1.612 3.593 3.593 S 61.498 23.493 59.517 23.493 z M 54.544 19.9 c 0.612 0.665 3.65 1.593 4.973 1.593 c 0.878 0 1.593 -0.714 1.593 -1.593 s -0.715 -1.593 -1.593 -1.593 C 58.194 18.308 55.156 19.236 54.544 19.9 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                            <path d="M 25.684 77.762 c -7.08 0 -12.84 -5.76 -12.84 -12.84 c 0 -0.463 0.03 -0.948 0.091 -1.482 l 1.987 0.229 c -0.053 0.458 -0.079 0.868 -0.079 1.254 c 0 5.978 4.863 10.84 10.84 10.84 c 5.978 0 10.84 -4.862 10.84 -10.84 c 0 -0.386 -0.026 -0.796 -0.079 -1.254 l 1.987 -0.229 c 0.062 0.534 0.091 1.02 0.091 1.482 C 38.524 72.002 32.764 77.762 25.684 77.762 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                            <path d="M 25.684 71.885 c -3.839 0 -6.963 -3.124 -6.963 -6.963 c 0 -0.522 0.064 -1.061 0.191 -1.598 l 1.946 0.459 c -0.091 0.387 -0.137 0.771 -0.137 1.139 c 0 2.736 2.227 4.963 4.963 4.963 c 2.737 0 4.963 -2.227 4.963 -4.963 c 0 -0.368 -0.046 -0.752 -0.137 -1.139 l 1.946 -0.459 c 0.127 0.537 0.191 1.075 0.191 1.598 C 32.647 68.761 29.524 71.885 25.684 71.885 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                            <path d="M 77.16 77.762 c -6.766 0 -12.389 -5.292 -12.802 -12.049 l 1.996 -0.121 c 0.349 5.702 5.095 10.17 10.806 10.17 c 5.978 0 10.84 -4.862 10.84 -10.84 c 0 -2.238 -0.684 -4.392 -1.978 -6.229 l 1.635 -1.152 C 89.19 59.717 90 62.27 90 64.922 C 90 72.002 84.24 77.762 77.16 77.762 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                            <path d="M 63.124 64.554 H 9.413 c -1.58 0 -3.062 -0.774 -3.963 -2.072 c -0.901 -1.298 -1.111 -2.956 -0.56 -4.437 l 4.665 -12.536 c 1.379 -3.707 4.963 -6.197 8.917 -6.197 h 16.192 c 3.262 0 5.916 2.654 5.916 5.916 v 5.603 c 0 1.695 1.379 3.075 3.075 3.075 h 12.146 c 1.041 0 2.017 -0.461 2.677 -1.265 c 0.672 -0.819 0.933 -1.883 0.713 -2.918 l -4.764 -22.504 c -0.45 -2.125 0.12 -4.276 1.564 -5.903 l 1.496 1.328 c -1.019 1.146 -1.421 2.663 -1.104 4.16 l 4.764 22.505 c 0.346 1.633 -0.064 3.311 -1.125 4.602 c -1.041 1.268 -2.58 1.995 -4.222 1.995 H 43.655 c -2.798 0 -5.075 -2.276 -5.075 -5.075 v -5.603 c 0 -2.159 -1.756 -3.916 -3.916 -3.916 H 18.472 c -3.123 0 -5.954 1.967 -7.043 4.895 L 6.764 58.742 c -0.327 0.88 -0.208 1.826 0.328 2.598 c 0.536 0.771 1.382 1.214 2.321 1.214 h 53.711 V 64.554 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                            <rect x="61.96" y="20.91" rx="0" ry="0" width="2" height="4.96" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(0.8687 -0.4954 0.4954 0.8687 -3.3184 34.2603) "/>
                            <rect x="72.01" y="31.21" rx="0" ry="0" width="2" height="19.61" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(0.8687 -0.4953 0.4953 0.8687 -10.7329 41.5491) "/>
                        </g>
                    </svg>

                <?php
                } else {
                ?>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="20" height="20" viewBox="0 0 256 256" xml:space="preserve">
                    <defs>
                    </defs>
                        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
                            <path d="M 89.034 43.825 L 74.452 27.423 c -0.725 -0.816 -1.767 -1.284 -2.859 -1.284 H 58.256 v -0.448 c 0 -3.723 -3.029 -6.752 -6.751 -6.752 H 6.752 C 3.029 18.94 0 21.969 0 25.692 v 35.098 c 0 2.219 1.805 4.024 4.023 4.024 h 10.374 c 0.827 3.573 4.029 6.247 7.85 6.247 s 7.023 -2.674 7.85 -6.247 h 25.193 h 2.967 h 10.701 c 0.827 3.573 4.029 6.247 7.85 6.247 s 7.023 -2.674 7.85 -6.247 h 1.519 c 2.109 0 3.825 -1.715 3.825 -3.825 V 46.367 C 90 45.43 89.657 44.527 89.034 43.825 z M 85.213 43.993 H 67.936 c -0.336 0 -0.609 -0.274 -0.609 -0.61 v -7.785 c 0 -0.336 0.273 -0.609 0.609 -0.609 h 9.272 L 85.213 43.993 z M 6.752 21.907 h 44.753 c 2.086 0 3.784 1.698 3.784 3.785 v 0.448 v 22.322 H 2.967 v -22.77 C 2.967 23.605 4.665 21.907 6.752 21.907 z M 22.246 68.093 c -2.81 0 -5.097 -2.286 -5.097 -5.097 s 2.287 -5.097 5.097 -5.097 s 5.097 2.286 5.097 5.097 S 25.057 68.093 22.246 68.093 z M 30.218 61.846 c -0.561 -3.902 -3.917 -6.913 -7.972 -6.913 s -7.411 3.011 -7.972 6.913 H 4.023 c -0.582 0 -1.056 -0.474 -1.056 -1.057 v -9.361 h 52.322 v 10.417 H 30.218 z M 76.807 68.093 c -2.811 0 -5.097 -2.286 -5.097 -5.097 s 2.286 -5.097 5.097 -5.097 s 5.097 2.286 5.097 5.097 S 79.617 68.093 76.807 68.093 z M 86.175 61.846 h -1.397 c -0.561 -3.902 -3.917 -6.913 -7.972 -6.913 s -7.411 3.011 -7.972 6.913 H 58.256 v -32.74 h 13.337 c 0.244 0 0.478 0.105 0.641 0.288 l 2.335 2.627 h -6.634 c -1.972 0 -3.576 1.604 -3.576 3.576 v 7.785 c 0 1.972 1.604 3.577 3.576 3.577 h 19.097 v 14.029 C 87.033 61.462 86.649 61.846 86.175 61.846 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        </g>
                    </svg>
                <?php
                }
                ?>

                <span class="align-middle" style="padding-left: 4px; font-size: 14px;">
                    <?php echo $delivery_text; ?>
                </span>
            </div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-1 pb-2 mb-1 border-bottom"></div>
            <div class="pt-2 pb-2" style="font-family: 'Inter',sans-serif; font-size: 14px;">
                <div class="pb-2">Kategorier: <?php echo $categories_string; ?></div>
                <div class="">Anledninger: <?php echo $occasions_string; ?></div>
            </div>
        </div>
        <div class="card-footer border-0 px-4 bg-transparent">
            <div class="row pt-3 pb-4">
                <div class="col-6">Priser fra</div>
                <div class="col-6 text-end">kun <span class="fw-bold" style="color: #5F082B"><?php echo get_vendor_lowest_price($vendor_id); ?>,-</span> kr.</div>
            </div>
        </div>
    </div>
</div>

<!--<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4 mb-2 d-flex align-items-stretch store">
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
          #$delivery_days 		= get_vendor_delivery_days_from_today($vendor_id, 'Kan ');
          ?>
            <span class="badge text-dark border border-dark text-dark fw-light shadow-none "><?php echo $delivery_days; ?></span>
          <?php
          ///////////////////////////
          // STORE TYPE TAG
          $store_type = get_field('store_type','user_'.$vendor_id);
          #var_dump($store_type);
          if(!empty($store_type)){
            foreach($store_type as $k => $v){
                if( isset($v['label'])
                    && !in_array($v['label'], array("1","2","3","4","5","6","7"))
                    && $v['label'] != "1"
                    && $v['label'] != "0"
                ){
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
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bicycle" viewBox="0 0 16 16">
            <path d="M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5zm1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139L5.5 6.943zM8 9.057 9.598 6.5H6.402L8 9.057zM4.937 9.5a1.997 1.997 0 0 0-.487-.877l-.548.877h1.035zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765l1.027-1.643zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53L11.55 8.623z"/>
          </svg> <?php echo $delivery_text; ?>
          <input type="hidden" id="cityName" value="<?php echo the_title();?>">
          <span style="width: 15px;">&nbsp;&nbsp;</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-range" viewBox="0 0 16 16">
            <path d="M9 7a1 1 0 0 1 1-1h5v2h-5a1 1 0 0 1-1-1zM1 9h4a1 1 0 0 1 0 2H1V9z"/>
            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
          </svg>
          <?php
            $extraordinary_dates = get_vendor_delivery_dates_extraordinary($vendor_id);
            // Filter dates within the next 10 days
            $filtered_dates = array_filter($extraordinary_dates, function ($date_str) {
              $openingDate = DateTime::createFromFormat('d-m-Y', $date_str);
              $today = new DateTime('today');
              $interval = $today->diff($openingDate);
              return $interval->days >= 0 && $interval->days < 10;
            });

            // Replace English month abbreviations with Danish ones
            $danish_month_names = array(
              'jan' => 'jan', 'feb' => 'feb', 'mar' => 'mar', 'apr' => 'apr',
              'may' => 'maj', 'jun' => 'jun', 'jul' => 'jul', 'aug' => 'aug',
              'sep' => 'sep', 'oct' => 'okt', 'nov' => 'nov', 'dec' => 'dec'
            );

            // Format filtered dates to Danish format "d. M"
            $formatted_dates = array_map(function ($date_str) use ($danish_month_names) {
              $openingDate = DateTime::createFromFormat('d-m-Y', $date_str);
              $month_abbr = strtolower($openingDate->format('M'));
              $danish_month = isset($danish_month_names[$month_abbr]) ? $danish_month_names[$month_abbr] : $month_abbr;
              return str_replace($openingDate->format('M'), $danish_month, $openingDate->format('d. M'));
            }, $filtered_dates);

            // Join the filtered dates with commas
            $dates_string = implode(', ', $formatted_dates);

            $opening = get_field('openning', 'user_'.$vendor_id);
            $str = get_del_days_text($opening, $delivery_type);
            if(count($filtered_dates) > 0) {
                $str .= ' (og ' . $dates_string . ')';
            }

            echo $str;
          ?>
        </div>
      </small>
    </div>
  </div>
</div>-->