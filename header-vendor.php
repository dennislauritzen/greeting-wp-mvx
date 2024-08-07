<?php
global $MVX, $product;

$cart_count = WC()->cart->cart_contents_count; // Set variable for cart item count
$cart_url = wc_get_cart_url();  // Set Cart URL

/**
 * Handle all vendor information
 * For product pages top.
 */

if(is_object($product)){
    // This is a product page
    $product_id = $product->get_id();
    $product_meta = get_post($product_id);
    $vendor_id = $product_meta->post_author;
} else {
    // Not a product page
    $vendor_id = mvx_find_shop_page_vendor();
}

$vendor = get_mvx_vendor($vendor_id);

$vendor2 = get_user_meta($vendor_id);

# BANNER SETUP
$banner = 'https://www.greeting.dk/wp-content/uploads/2022/05/pexels-maria-orlova-4947386-1-scaled.jpg';
if(!empty($vendor_id)){
    if(!empty( $image = $vendor->get_image('banner') )){
        $banner = $vendor->get_image('banner');
    } else {
        $banner = (!empty($vendor2['_vendor_banner']) ? $vendor2['_vendor_banner'][0] : '');
    }
}
$vendor_banner = $banner;

# PROFILE IMAGE SETUP
$image = $MVX->plugin_url . 'assets/images/WP-stdavatar.png';
if(!empty($vendor_id) && is_object($vendor)){
    $image = $vendor->get_image('image', array(125, 125));
}
#OLD v2: $image = !empty($vendor->get_image('image', array(125, 125))) ? $vendor->get_image('image', array(125, 125)) : $MVX->plugin_url . 'assets/images/WP-stdavatar.png';
#OLD: $image = $vendor->get_image() ? $vendor->get_image('image', array(125, 125)) : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';

$cart_count = WC()->cart->cart_contents_count; // Set variable for cart item count
$cart_url = wc_get_cart_url();  // Set Cart URL

$del_type = '';
$del_value = '';
if(!empty(get_field('delivery_type', 'user_'.$vendor->id))){
  $delivery_type = get_field('delivery_type', 'user_'.$vendor->id)[0];

  $del_value = (empty($delivery_type['label']) ? $delivery_type : $delivery_type['value']);
  $del_type = (empty($delivery_type['label']) ? $delivery_type : $delivery_type['label']);
}
?>

 <section id="top" class="vendor pt-1" style="background-size: cover; background-position: center center; background-image: linear-gradient(rgba(0, 0, 0, 0.35),rgba(0, 0, 0, 0.35)),url('<?php echo esc_url($vendor_banner); ?>');">
  <div class="container py-4">
    <div class="row">
        <div class="d-flex pb-3 pb-lg-0 pb-xl-0 position-relative justify-content-center justify-content-lg-start justify-content-xl-start col-md-12 col-lg-3">
        <a href="<?php echo home_url(); ?>">
          <?php echo '<?xml version="1.0" encoding="UTF-8" ?>' ?>
          <svg viewBox="0 0 524 113" width="175" fill="#ffffff"  xmlns="http://www.w3.org/2000/svg">
          <path d="m77.206 77.399c-1.3564 0.9013-3.0143 2.0655-4.9737 3.4925-1.884 1.352-4.1824 2.6664-6.8954 3.9432-2.6376 1.2017-5.7273 2.2532-9.2692 3.1545s-7.5736 1.352-12.095 1.352c-6.707 0-12.773-1.0891-18.199-3.2672-5.4259-2.2533-10.06-5.2951-13.904-9.1256-3.768-3.9057-6.707-8.4497-8.817-13.632-2.0347-5.2576-3.0521-10.891-3.0521-16.899 0-6.0086 1.055-11.604 3.1651-16.787 2.1101-5.2576 5.1244-9.8016 9.0431-13.632 3.9941-3.9056 8.8171-6.9475 14.469-9.1256 5.652-2.2532 12.058-3.3799 19.217-3.3799 3.2404 0 6.2548 0.18777 9.0431 0.56331 2.8637 0.37554 5.5013 0.86375 7.9128 1.4646 2.4868 0.52575 4.7099 1.0891 6.6693 1.6899 1.9593 0.60086 3.7303 1.1642 5.3128 1.6899l2.2608 18.364-1.0174 0.338c-2.7129-3.9056-5.3128-7.2104-7.7997-9.9143-2.4115-2.779-4.8606-5.0322-7.3475-6.7597-2.4115-1.8026-4.936-3.117-7.5736-3.9432-2.6376-0.82619-5.4636-1.2393-8.478-1.2393-5.1998 0-9.7213 1.0515-13.565 3.1545-3.8433 2.103-7.0084 4.9947-9.4952 8.675-2.4869 3.6803-4.3709 7.999-5.652 12.956-1.2058 4.9571-1.8086 10.29-1.8086 15.998s0.5652 11.041 1.6956 15.998c1.1303 4.882 2.8636 9.1632 5.1998 12.844 2.4115 3.6052 5.4635 6.4593 9.1561 8.5623 3.768 2.103 8.2896 3.1545 13.565 3.1545 6.1795 0 11.191-1.5021 15.034-4.5064 3.8434-3.0044 5.765-7.4733 5.765-13.407 0-2.0279-0.0753-3.8305-0.2261-5.4078-0.1507-1.5773-0.4521-3.0794-0.9043-4.5065-0.3768-1.427-0.9043-2.8165-1.5825-4.1685-0.6782-1.427-1.5072-2.9667-2.4869-4.6191v-0.2253h22.156v0.2253c-0.9043 1.7275-1.6579 3.3423-2.2608 4.8445-0.6029 1.427-1.0927 2.8916-1.4695 4.3938-0.3014 1.5021-0.5275 3.117-0.6782 4.8444-0.0754 1.7275-0.1131 3.7554-0.1131 6.0838v6.7597z"/>
          <path d="m88.067 87.651v-0.2253c0.5275-1.5772 0.942-3.117 1.2434-4.6191 0.3768-1.5022 0.6406-3.0794 0.7913-4.7318 0.2261-1.7275 0.3768-3.5677 0.4522-5.5205 0.0753-2.0279 0.113-4.2811 0.113-6.7597v-13.294c0-3.7554-0.5275-6.7597-1.5825-9.013-0.9797-2.2532-2.1478-4.1309-3.5043-5.6331v-0.2253l15.939-5.9711v13.745h0.452c1.13-1.352 2.336-2.779 3.617-4.2812 1.357-1.5772 2.789-3.0043 4.296-4.2811 1.507-1.352 3.089-2.441 4.747-3.2672 1.734-0.9013 3.505-1.352 5.313-1.352l-0.226 13.745h-0.452c-0.528-0.4506-1.243-0.8637-2.148-1.2393-0.904-0.3755-1.846-0.7135-2.826-1.0139-0.904-0.3756-1.846-0.6385-2.826-0.7887-0.904-0.2253-1.658-0.338-2.26-0.338-0.905 0-2.035 0.4131-3.392 1.2393-1.281 0.8262-2.562 2.103-3.843 3.8305v18.026c0 4.882 0.113 8.9754 0.339 12.28 0.302 3.2297 1.017 6.3842 2.148 9.4636v0.2253h-16.391z"/>
          <path d="m169.29 72.667c-0.754 2.3283-1.809 4.5065-3.165 6.5344-1.281 2.0279-2.864 3.793-4.748 5.2951-1.884 1.5022-4.032 2.6663-6.443 3.4925-2.412 0.9013-5.087 1.352-8.026 1.352-3.768 0-7.234-0.676-10.399-2.0279-3.09-1.4271-5.765-3.3799-8.026-5.8585-2.186-2.4785-3.919-5.4077-5.2-8.7876-1.206-3.3799-1.809-7.0226-1.809-10.928 0-4.5065 0.754-8.5623 2.261-12.168 1.583-3.6803 3.617-6.7973 6.104-9.351 2.487-2.5536 5.275-4.5064 8.365-5.8584 3.165-1.427 6.293-2.1406 9.382-2.1406 3.316 0 6.331 0.676 9.044 2.028 2.712 1.3519 5.011 3.1169 6.895 5.2951 1.959 2.103 3.429 4.4689 4.408 7.0977 0.98 2.5536 1.395 5.0698 1.244 7.5483h-36.286v2.1406c0 7.9615 1.809 13.857 5.426 17.688 3.617 3.8306 8.403 5.7458 14.356 5.7458 3.467 0 6.481-0.6384 9.043-1.9153 2.638-1.3519 4.936-3.2296 6.896-5.633l0.678 0.4506zm-22.156-38.418c-2.185 0-4.107 0.4882-5.765 1.4646-1.582 0.9013-2.976 2.1781-4.182 3.8305-1.131 1.5772-2.035 3.4925-2.713 5.7457-0.678 2.1782-1.131 4.5441-1.357 7.0977l24.53-0.5633v-1.2393c0-5.6331-0.867-9.764-2.6-12.393s-4.371-3.9431-7.913-3.9431z"/>
          <path d="m219.88 72.667c-0.753 2.3283-1.808 4.5065-3.165 6.5344-1.281 2.0279-2.863 3.793-4.747 5.2951-1.884 1.5022-4.032 2.6663-6.444 3.4925-2.411 0.9013-5.086 1.352-8.025 1.352-3.768 0-7.235-0.676-10.4-2.0279-3.09-1.4271-5.765-3.3799-8.026-5.8585-2.185-2.4785-3.918-5.4077-5.2-8.7876-1.205-3.3799-1.808-7.0226-1.808-10.928 0-4.5065 0.753-8.5623 2.261-12.168 1.582-3.6803 3.617-6.7973 6.104-9.351 2.487-2.5536 5.275-4.5064 8.365-5.8584 3.165-1.427 6.292-2.1406 9.382-2.1406 3.316 0 6.33 0.676 9.043 2.028 2.713 1.3519 5.011 3.1169 6.895 5.2951 1.96 2.103 3.429 4.4689 4.409 7.0977 0.98 2.5536 1.394 5.0698 1.243 7.5483h-36.285v2.1406c0 7.9615 1.808 13.857 5.426 17.688 3.617 3.8306 8.402 5.7458 14.356 5.7458 3.466 0 6.48-0.6384 9.043-1.9153 2.637-1.3519 4.936-3.2296 6.895-5.633l0.678 0.4506zm-22.155-38.418c-2.186 0-4.107 0.4882-5.765 1.4646-1.583 0.9013-2.977 2.1781-4.183 3.8305-1.13 1.5772-2.034 3.4925-2.713 5.7457-0.678 2.1782-1.13 4.5441-1.356 7.0977l24.529-0.5633v-1.2393c0-5.6331-0.866-9.764-2.6-12.393-1.733-2.6288-4.37-3.9431-7.912-3.9431z"/>
          <path d="m240.63 89.341c-1.657 0-3.278-0.2253-4.86-0.676-1.507-0.3755-2.864-1.0891-4.07-2.1406-1.13-1.0515-2.034-2.441-2.713-4.1685-0.678-1.8026-1.017-4.0182-1.017-6.647v-39.77h-6.104v-0.676l16.391-14.083h1.13v12.731h14.582v2.0279h-14.582v39.432c0 5.558 2.638 8.337 7.913 8.337 1.959 0 3.617-0.2629 4.973-0.7887 1.357-0.6008 2.186-0.9764 2.487-1.1266l0.339 0.4507c-1.582 2.1781-3.617 3.9056-6.104 5.1824-2.411 1.2769-5.199 1.9153-8.365 1.9153z"/>
          <path d="m273.54 13.519c0 1.8777-0.678 3.4926-2.034 4.8445-1.282 1.2768-2.864 1.9153-4.748 1.9153s-3.504-0.6385-4.861-1.9153c-1.281-1.3519-1.921-2.9668-1.921-4.8445s0.64-3.4925 1.921-4.8444c1.357-1.352 2.977-2.0279 4.861-2.0279s3.466 0.67597 4.748 2.0279c1.356 1.3519 2.034 2.9667 2.034 4.8444zm-14.469 73.906c0.754-3.0794 1.357-6.2339 1.809-9.4636 0.527-3.2296 0.791-7.2855 0.791-12.168v-12.844c0-3.6051-0.527-6.5344-1.582-8.7876-0.98-2.3283-2.148-4.2436-3.505-5.7458v-0.7886l16.391-5.9711v34.024 6.647c0.075 1.9528 0.188 3.793 0.339 5.5204 0.226 1.7275 0.49 3.3799 0.791 4.9572 0.302 1.5021 0.754 3.0419 1.357 4.6191v0.2253h-16.391v-0.2253z"/>
          <path d="m298.9 87.651h-16.39v-0.2253c0.527-1.5772 0.942-3.117 1.243-4.6191 0.377-1.5022 0.641-3.0794 0.791-4.7318 0.227-1.7275 0.377-3.5677 0.453-5.5205 0.075-2.0279 0.113-4.2811 0.113-6.7597v-13.294c0-3.7554-0.528-6.7597-1.583-9.013-0.98-2.2532-2.148-4.1309-3.504-5.6331v-0.2253l15.938-5.9711v10.816l0.453 0.1126c2.411-2.9292 5.049-5.3702 7.912-7.323 2.864-2.0279 6.293-3.0419 10.287-3.0419 5.2 0 9.156 1.4646 11.869 4.3939 2.713 2.9292 4.069 6.9099 4.069 11.942v17.125 6.8723c0.076 1.9528 0.189 3.793 0.34 5.5205 0.226 1.6524 0.489 3.2296 0.791 4.7318 0.377 1.5021 0.866 3.0419 1.469 4.6191v0.2253h-16.39v-0.2253c0.979-3.0794 1.62-6.2715 1.921-9.5763 0.377-3.3047 0.565-7.323 0.565-12.055v-14.646c0-1.5773-0.188-3.0795-0.565-4.5065-0.377-1.5022-0.979-2.8166-1.808-3.9432s-1.922-1.9904-3.278-2.5912c-1.282-0.676-2.864-1.014-4.748-1.014-2.412 0-4.672 0.5258-6.782 1.5773-2.111 0.9764-3.995 2.3283-5.652 4.0558v20.955c0 4.882 0.113 8.9754 0.339 12.28 0.301 3.2297 1.017 6.3842 2.147 9.4636v0.2253z"/>
          <path d="m360.52 68.611c1.809 0 3.354-0.4131 4.635-1.2393 1.356-0.9013 2.412-2.103 3.165-3.6052 0.829-1.5773 1.432-3.3799 1.809-5.4078 0.377-2.103 0.565-4.3938 0.565-6.8724 0-2.4785-0.188-4.7693-0.565-6.8723-0.377-2.1031-0.98-3.9057-1.809-5.4078-0.753-1.5773-1.809-2.779-3.165-3.6052-1.281-0.9013-2.864-1.3519-4.748-1.3519s-3.466 0.4506-4.747 1.3519c-1.281 0.8262-2.336 2.0279-3.165 3.6052-0.754 1.5021-1.319 3.3047-1.696 5.4078-0.301 2.103-0.452 4.3938-0.452 6.8723 0 2.4786 0.188 4.7694 0.565 6.8724 0.377 2.0279 0.942 3.8305 1.696 5.4078 0.829 1.5022 1.884 2.7039 3.165 3.6052 1.356 0.8262 2.939 1.2393 4.747 1.2393zm28.938 26.476c-0.075 2.4035-0.791 4.6943-2.147 6.8723-1.281 2.178-3.165 4.056-5.652 5.633-2.487 1.653-5.615 2.967-9.383 3.943-3.692 0.977-7.95 1.465-12.773 1.465-3.542 0-6.858-0.3-9.947-0.901-3.015-0.526-5.615-1.352-7.8-2.479-2.186-1.126-3.919-2.478-5.2-4.056-1.206-1.577-1.809-3.38-1.809-5.407 0-1.4275 0.302-2.7419 0.905-3.9436 0.603-1.1267 1.394-2.1406 2.374-3.0419 1.055-0.8262 2.223-1.5397 3.504-2.1406 1.281-0.5257 2.6-0.9764 3.956-1.3519-1.959-0.7511-3.542-1.8026-4.747-3.1546-1.131-1.427-1.696-3.3047-1.696-5.6331 0-1.7275 0.339-3.2672 1.017-4.6191 0.679-1.352 1.545-2.5161 2.6-3.4925 1.131-1.0516 2.412-1.9153 3.844-2.5913 1.431-0.6759 2.901-1.2017 4.408-1.5772-3.542-1.5773-6.405-3.8681-8.591-6.8724-2.185-3.0043-3.278-6.4218-3.278-10.252 0-2.7038 0.565-5.22 1.696-7.5483 1.13-2.4035 2.637-4.4689 4.521-6.1964 1.959-1.7275 4.22-3.0795 6.782-4.0559 2.638-0.9764 5.426-1.4646 8.365-1.4646s5.69 0.5258 8.252 1.5773c2.638 0.9764 4.936 2.3284 6.896 4.0558l14.356-8.337 0.226 0.1127v10.027h-0.452l-12.548-0.2253c1.507 1.6524 2.675 3.4925 3.504 5.5204 0.905 2.028 1.357 4.2061 1.357 6.5344 0 2.6288-0.565 5.1074-1.696 7.4357-1.13 2.3284-2.675 4.3563-4.634 6.0838-1.884 1.7275-4.145 3.117-6.783 4.1685-2.637 0.9764-5.426 1.4646-8.365 1.4646-1.507 0-2.939-0.1127-4.295-0.338-1.281-0.3004-2.562-0.676-3.843-1.1266-1.884 0.9013-3.203 1.9152-3.957 3.0419-0.678 1.0515-1.017 2.103-1.017 3.1545 0 2.103 1.017 3.5301 3.052 4.2811 2.035 0.676 4.785 1.0891 8.252 1.2393l11.304 0.338c2.562 0.0751 5.049 0.4131 7.46 1.014 2.412 0.6008 4.522 1.4646 6.33 2.5912 1.809 1.1266 3.203 2.5161 4.183 4.1685 1.055 1.7275 1.545 3.7554 1.469 6.0837zm-25.32 13.97c6.33 0 11.04-0.901 14.13-2.704 3.165-1.803 4.747-4.093 4.747-6.8724 0-1.352-0.377-2.5162-1.13-3.4926-0.678-0.9013-1.658-1.6523-2.939-2.2532-1.206-0.5258-2.675-0.9389-4.409-1.2393-1.658-0.2253-3.429-0.3755-5.313-0.4506l-12.208-0.4507c-1.733-0.0751-3.429-0.2253-5.087-0.4506-1.658-0.1503-3.24-0.4507-4.747-0.9013-0.754 0.6759-1.432 1.5772-2.035 2.7039-0.527 1.1266-0.791 2.5161-0.791 4.1685 0 3.8303 1.695 6.7593 5.087 8.7873 3.391 2.103 8.289 3.155 14.695 3.155z"/>
          <path d="m399.12 88.214c-2.11 0-3.918-0.7511-5.425-2.2533-1.432-1.5021-2.148-3.2672-2.148-5.2951 0-2.1781 0.716-3.9807 2.148-5.4078 1.507-1.5021 3.315-2.2532 5.425-2.2532 2.035 0 3.806 0.7511 5.313 2.2532 1.507 1.4271 2.261 3.2297 2.261 5.4078 0 2.0279-0.754 3.793-2.261 5.2951-1.507 1.5022-3.278 2.2533-5.313 2.2533z"/>
          <path d="m438.95 81.793c2.939 0 5.501-0.5633 7.687-1.6899 2.261-1.1266 4.145-2.5912 5.652-4.3938v-28.954c-0.528-2.4034-1.244-4.3938-2.148-5.9711-0.904-1.6523-1.959-2.9292-3.165-3.8305-1.13-0.9764-2.374-1.6523-3.73-2.0279-1.281-0.4506-2.562-0.6759-3.844-0.6759-2.486 0-4.747 0.6384-6.782 1.9152-1.959 1.2017-3.655 2.9292-5.087 5.1825-1.356 2.1781-2.411 4.8069-3.165 7.8863-0.753 3.0794-1.13 6.4593-1.13 10.14 0 6.7597 1.281 12.205 3.843 16.336 2.638 4.0558 6.594 6.0837 11.869 6.0837zm13.452-3.8305c-0.829 1.5022-1.884 2.9292-3.165 4.2812-1.206 1.3519-2.638 2.5536-4.296 3.6052-1.582 1.0515-3.391 1.8777-5.426 2.4785-1.959 0.676-4.107 1.014-6.443 1.014-3.316 0-6.33-0.6384-9.043-1.9153-2.637-1.3519-4.898-3.1921-6.782-5.5204-1.884-2.3284-3.354-5.0698-4.409-8.2243-0.979-3.2297-1.469-6.7222-1.469-10.478 0-4.0558 0.603-7.9615 1.808-11.717 1.281-3.7554 3.165-7.0601 5.652-9.9142s5.577-5.1074 9.269-6.7597c3.693-1.7275 7.951-2.5913 12.774-2.5913 2.185 0 4.22 0.1878 6.104 0.5633 1.959 0.3756 3.73 0.8638 5.313 1.4647v-13.407c0-3.7554-0.528-6.7597-1.583-9.013-0.979-2.2532-2.147-4.1309-3.504-5.6331v-0.22532l16.391-5.9711v63.654c0 3.8305 0.075 6.9475 0.226 9.351 0.226 2.4034 0.527 4.3938 0.904 5.9711 0.452 1.5021 0.98 2.7039 1.583 3.6052 0.678 0.9013 1.507 1.765 2.487 2.5912v0.2253l-16.052 3.6052v-11.041h-0.339z"/>
          <path d="m474.15 87.426c0.753-1.5772 1.356-3.4925 1.808-5.7457 0.452-2.2533 0.679-5.4829 0.679-9.689v-51.261c0-3.6803-0.528-6.647-1.583-8.9003-0.98-2.2532-2.148-4.1309-3.504-5.6331v-0.22532l16.39-5.9711v71.878c0 4.206 0.227 7.4732 0.679 9.8016 0.527 2.3283 1.205 4.2436 2.034 5.7457v0.2253h-16.503v-0.2253zm34.138 0.2253-19.443-27.94 12.999-14.083c1.809-1.9528 3.015-3.9807 3.618-6.0837 0.602-2.1782 0.452-3.9808-0.453-5.4078v-0.2253h14.695v0.2253c-3.391 1.5022-6.367 3.4174-8.93 5.7458-2.562 2.2532-5.011 4.6191-7.347 7.0977l-5.878 6.4217 16.617 23.884c1.733 2.4035 3.315 4.4314 4.747 6.0838s3.128 3.0043 5.087 4.0558v0.2253h-15.712z"/>
          </svg>
				</a>
        <a class="position-absolute top-0 start-0 me-4 ms-1 d-inline d-lg-none d-xl-none" data-bs-toggle="offcanvas" href="#offcanvasMenu" role="button" aria-controls="offcanvasExample">
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#ffffff" class="bi bi-list" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
          </svg>
        </a>
        <a class="position-absolute top-0 end-0 me-4 d-inline d-lg-none d-xl-none  right-col text-end" href="<?php echo $cart_url; ?>">
          <span class="position-relative" aria-label="Se kurv">
            <svg width="21" height="23" viewBox="0 0 21 23" xmlns="http://www.w3.org/2000/svg">
              <path d="M6.434 6.967H3.306l-1.418 14.47h17.346L17.82 6.967h-3.124c.065.828.097 1.737.097 2.729h-1.5c0-1.02-.031-1.927-.093-2.729H7.93a35.797 35.797 0 00-.093 2.729h-1.5c0-.992.032-1.9.097-2.729zm.166-1.5C7.126 1.895 8.443.25 10.565.25s3.44 1.645 3.965 5.217h4.65l1.708 17.47H.234l1.712-17.47H6.6zm6.432 0c-.407-2.65-1.27-3.717-2.467-3.717-1.196 0-2.06 1.066-2.467 3.717h4.934z" fill="#ffffff">
              </path>
            </svg>
            <span class="position-absolute start-50 top-0 badge rounded-circle text-white" style="background: #cea09f;"><?php echo $cart_count; ?></span>
          </span>
          <span class="d-inline px-lg-2 px-xl-3 hide-lg text-white">&nbsp;&nbsp;&nbsp;Kurv</span>
        </a>
      </div>
      <div class="col-md-12 col-lg-5 col-xl-6">
        <form role="search" method="get" autocomplete="off" id="searchform" class="position-relative mx-5">
          <label for="" class="screen-reader-text">Indtast det postnummer, du ønsker at sende en gave til - og se udvalget af butikker</label>
          <button type="submit" name="submit" class="top-search-btn rounded-pill position-absolute border-0 end-0 bg-teal p-3 me-1"></button>
          <?php
          if(!empty($args['city']) && !empty($args['postalcode'])){
            $val = $args['postalcode'] . ' ' . $args['city'];
          } else {
            $val = '';
          ?>

          <input type="hidden" name="__s_link" value="" id="hidden__s_link">
          <script type="text/javascript">
            jQuery(document).ready(function(){
              var postalcode = window.localStorage.getItem('postalcode');
              var city = window.localStorage.getItem('city');
              var pc_link = window.localStorage.getItem('city_link');

              if(postalcode && city){
                document.getElementById('front_Search-new_ucsa').value = postalcode+' '+city;
              }
              if(pc_link){
                document.getElementById('hidden__s_link').value = pc_link;
              }
            });
          </script>
          <?php
          }
          ?>
          <input type="text" class="top-search-input form-control rounded-pill border-0 py-2" id="front_Search-new_ucsa" name="keyword" value="<?php echo $val; ?>" placeholder="Indtast by eller postnr.">
          <ul id="datafetch_wrapper" class="d-none list-group position-relative recommandations position-absolute list-unstyled rounded w-100 bg-light bg-white" style="top: 42px; z-index: 100000;">
          </ul>
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
        <?php
        if ( is_user_logged_in() ) {
        ?>
          <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="btn btn-create rounded text-white">Min konto</a>
        <?php
        } else {
        ?>
          <a href="<?php home_url(); ?>/log-ind" class="btn text-white">Log ind</a>
          <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="btn btn-create rounded text-white">Opret</a>
        <?php
        }
        ?>
        <div class="btn position-relative ms-lg-0 ms-xl-1">
  				<a href="<?php echo $cart_url; ?>">
            <span class="position-relative" aria-label="Se kurv">
              <svg width="21" height="23" viewBox="0 0 21 23" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.434 6.967H3.306l-1.418 14.47h17.346L17.82 6.967h-3.124c.065.828.097 1.737.097 2.729h-1.5c0-1.02-.031-1.927-.093-2.729H7.93a35.797 35.797 0 00-.093 2.729h-1.5c0-.992.032-1.9.097-2.729zm.166-1.5C7.126 1.895 8.443.25 10.565.25s3.44 1.645 3.965 5.217h4.65l1.708 17.47H.234l1.712-17.47H6.6zm6.432 0c-.407-2.65-1.27-3.717-2.467-3.717-1.196 0-2.06 1.066-2.467 3.717h4.934z" fill="#ffffff">
                </path>
              </svg>
              <span class="position-absolute start-50 top-0 badge rounded-circle text-white" style="background: #cea09f;"><?php echo $cart_count; ?></span>
            </span>
            <span class="d-inline px-lg-2 px-xl-3 hide-lg text-white">Kurv</span>
  				</a>
        </div>
      </div>
    </div>
  </div>
  <div class="container d-flex align-items-end" style="height: inherit; min-height: inherit;">
    <div class="row">
        <div class="col-12">
        <?php
        $term = get_queried_object();

        if($term->taxonomy == 'dc_vendor_shop'){
        ?>
          <h1 class="text-white fs-1 m-0 p-0"><?php echo ucfirst(esc_html($vendor->page_title)); ?></h1>
        <?php } else { ?>
          <h2 class="text-white fs-1 m-0 p-0"><?php echo ucfirst(esc_html($vendor->page_title)); ?></h2>
        <?php } ?>
      </div>
      <div class="col-12 ">
        <div class="rating pb-2">
          <?php
          if (get_mvx_vendor_settings('is_sellerreview', 'general') == 'Enable') {
            $vendor_term_id = get_user_meta( mvx_find_shop_page_vendor(), '_vendor_term_id', true );
            $rating_val_array = mvx_get_vendor_review_info($vendor_term_id);
            $MVX->template->get_template('review/rating.php', array('rating_val_array' => $rating_val_array));
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

          if(!empty($location) && $vendor_id != "38" && $vendor_id != "76"){
            echo esc_html($location);
          } else if($vendor_id == "38" || $vendor_id == "76"){
            echo 'Leveres fra en fysisk gavebutik, der ligger nær din modtager.';
          }
          ?>
        </div>
      </div>
	</div>
</section>
<section class="sticky-top mt-n3 mb-5" style="margin-top: -25px;">
  <div class="container">
    <div class="row">
      <div class="col-12 rounded storebar bg-white py-3 shadow-sm">
        <div class="row align-items-center">
          <div class="d-flex col-md-12 col-lg-3 align-items-center">
            <div class="col-9 col-sm-8 col-md-8 col-lg-12 align-items-center">
              <div class="d-flex align-items-center">
                <div class="w-25 w-sm-20 w-md-15 float-start">
                  <a href="<?php echo $vendor->get_permalink(); ?>" class="text-dark">
                    <img class="img-fuid pe-1" style="max-height:75px;"
                    src="<?php echo esc_attr($image); ?>">
                  </a>
                </div>
                <div class="w-75">
                  <a href="<?php echo $vendor->get_permalink(); ?>" class="text-dark">
                    <?php echo ucfirst(esc_html($vendor->page_title)); ?>
                  </a>
                  <br>
                  <a href="#" class="text-dark text-decoration-underline d-none d-lg-block" style="font-size: 13px;" data-bs-toggle="modal" data-bs-target="#storeDescriptionModal">Læs mere om butikken</a>
                </div>
              </div>
            </div>
            <div class="d-lg-none col-3 col-sm-4 col-md-4 col-lg-0">
              <button type="button" data-bs-toggle="modal" data-bs-target="#storeDescriptionModal" class="d-lg-none btn btn-teal border-0 py-2 px-1 px-sm-4" style="font-size:14px;">
                Læs om butikken
              </button>
            </div>
          </div>
          <div class="d-none pt-1 pt-lg-0 d-lg-inline col-lg-3 opening-row">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
              <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
              <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117zM11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5zM4 1.934V15h6V1.077l-6 .857z"/>
            </svg>
            <?php
              $opening = get_field('openning', 'user_'.$vendor->id);
              $open_iso_days = array();
              $open_label_days = array();
              foreach($opening as $k => $v){
                $open_iso_days[] = (int) $v['value'];
                $open_label_days[$v['value']] = $v['label'];
              }

              $interv = array();
              if(!empty($open_iso_days) && is_array($open_iso_days)){
                $interv = build_intervals($open_iso_days, function($a, $b) { return ($b - $a) <= 1; }, function($a, $b) { return $a."..".$b; });
              } else {
                print 'Butikkens leveringsdage er ukendte';
              }
              $i = 1;

              if(!empty($opening) && !empty($interv) && count($interv) > 0){

                if($del_value == "1"){
                  echo 'Butikken leverer ';
                } else if($del_value == "0"){
                  echo 'Butikken afsender ';
                }

                foreach($interv as $v){
                  $val = explode('..',$v);
                  if(!empty($val)){
                    $start = isset($open_label_days[$val[0]])? $open_label_days[$val[0]] : '';
                    if($val[0] != $val[1])
                    {
                      $end = isset($open_label_days[$val[1]]) ? $open_label_days[$val[1]] : '';
                      if(!empty($start) && !empty($end)){
                        print strtolower($start."-".$end);
                      }
                    } else {
                      print strtolower($start);
                    }
                    if(count($interv) > 1){
                      if(count($interv)-1 == $i){ print " og "; }
                      else if(count($interv) > $i) { print ', ';}
                    }
                  }
                  $i++;
                }
              }
            ?>
          </div>
          <div class="col-lg-3 d-none d-lg-inline pt-1 pt-lg-0 opening-row">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
              <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
              <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
            </svg>
            <?php
            // Dropoff time, get.
            $dropoff_time = get_vendor_dropoff_time($vendor->id);
            $formatted_time = date("H:i", strtotime($dropoff_time));

            $prepend_text = ($del_value == "1") ? 'Bestil inden kl. '.$formatted_time.' for levering ' : 'Bestil inden kl. '.$formatted_time.' for forsendelse ';

            $vendor_delivery_days_from_today = get_vendor_delivery_days_from_today_header_vendor($vendor->id, $prepend_text, $del_value, 2);
            echo $vendor_delivery_days_from_today;
            ?>
          </div>
          <div class="col-lg-3 d-none d-lg-inline pt-1 pt-lg-0 opening-row">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
              <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
              <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117zM11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5zM4 1.934V15h6V1.077l-6 .857z"/>
            </svg>
            <?php
            if(!empty(get_field('delivery_type', 'user_'.$vendor->id))){
              if($del_value == "1"){
                echo 'Personlig levering til døren';
              } else if($del_value == "0"){
                echo 'Forsendelse med fragtfirma (2-3 hverdages transporttid)';
              }
            } else {
              echo 'Butikkens leveringstype er ukendt.';
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Modal -->
<div class="modal fade" id="storeDescriptionModal" tabindex="-1" aria-labelledby="storeDescriptionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="storeDescriptionModalLabel" style="font-family: 'Inter',sans-serif;">
          <?php echo ucfirst(esc_html($vendor->page_title)); ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
        $description = get_user_meta($vendor_id, '_vendor_description', true);
        ?>
        <div>
          <?php
          if(!empty($banner)){
          ?>
          <img src="<?php echo $vendor_banner; ?>">
          <?php
          }
          ?>
          <p>
            <b>Adresse</b>
            <br>
            <?php echo $location; ?>
          </p>
          <h6 class="pt-2" style="font-family: 'Inter';">Beskrivelse af butikken</h6>
          <?php echo wp_kses_post(htmlspecialchars_decode( wpautop( $description ), ENT_QUOTES )); ?>

          <p>
            <b>Åbningsdage:</b>
            <br>
            <?php
              $opening = get_field('openning', 'user_'.$vendor->id);
              $open_iso_days = array();
              $open_label_days = array();
              foreach($opening as $k => $v){
                $open_iso_days[] = (int) $v['value'];
                $open_label_days[$v['value']] = $v['label'];
              }

              if( !function_exists('build_intervals')){
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
              }

              $interv = array();
              if(!empty($open_iso_days) && is_array($open_iso_days)){
                $interv = build_intervals($open_iso_days, function($a, $b) { return ($b - $a) <= 1; }, function($a, $b) { return $a."..".$b; });
              } else {
                print 'Butikkens leveringsdage er ukendte';
              }
              $i = 1;

              if(!empty($opening) && !empty($interv) && count($interv) > 0){

                if($del_value == "1"){
                  echo 'Butikken leverer ';
                } else if($del_value == "0"){
                  echo 'Butikken afsender ';
                }

                foreach($interv as $v){
                  $val = explode('..',$v);
                  if(!empty($val)){
                    $start = isset($open_label_days[$val[0]])? $open_label_days[$val[0]] : '';
                    if($val[0] != $val[1])
                    {
                      $end = isset($open_label_days[$val[1]]) ? $open_label_days[$val[1]] : '';
                      if(!empty($start) && !empty($end)){
                        print strtolower($start."-".$end);
                      }
                    } else {
                      print strtolower($start);
                    }
                    if(count($interv) > 1){
                      if(count($interv)-1 == $i){ print " og "; }
                      else if(count($interv) > $i) { print ', ';}
                    }
                  }
                  $i++;
                }
              }
            ?>
          </p>

          <p><b>Leveringsinformation</b>:


            <br>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
              <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
              <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117zM11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5zM4 1.934V15h6V1.077l-6 .857z"/>
            </svg>
            <?php
            if(!empty(get_field('delivery_type', 'user_'.$vendor->id))){
              if($del_value == "1"){
                echo 'Personlig levering til døren';
              } else if($del_value == "0"){
                echo 'Forsendelse med fragtfirma (2-3 hverdages transporttid)';
              }
            } else {
              echo 'Butikkens leveringstype er ukendt.';
            }
            ?>



            <br>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                  <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                  <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
              </svg>
              <?php
              // Dropoff time, get.
              $dropoff_time = get_vendor_dropoff_time($vendor->id);
              $formatted_time = date("H:i", strtotime($dropoff_time));

              $prepend_text = ($del_value == "1") ? 'Bestil inden kl. '.$formatted_time.' for levering ' : 'Bestil inden kl. '.$formatted_time.' for forsendelse ';
              ?>

              <?php
              $vendor_delivery_days_from_today = get_vendor_delivery_days_from_today_header_vendor($vendor->id, $prepend_text, $del_value, 2);
              echo $vendor_delivery_days_from_today;
              ?>
          </p>
        </div>
        <?php

        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light-grey-dark-border" data-bs-dismiss="modal">Luk</button>
      </div>
    </div>
  </div>
</div>
