<?php
if($args['vendor']){
    $vendor = $args['vendor'];
}
?>


<div class="col-12">
            <div class="card shadow border-0 mb-3">
              <div class="card-body">
                <div class="row align-items-center">

                  <div class="col-3 text-center">
                    <img class="img-fluid rounded-start" src="<?php echo $image;?>" style="max-width: 100px;">
                    <?php $button_text = apply_filters('mvx_vendor_lists_single_button_text', $vendor->page_title); ?>
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
		  
		  

<div class="wcmp-store-list">
	<?php				
	global $MVX;
	$image = $vendor->get_image() ? $vendor->get_image('image', array(125, 125)) : $MVX->plugin_url . 'assets/images/WP-stdavatar.png';
	$banner = $vendor->get_image('banner') ? $vendor->get_image('banner') : '';

	do_action('mvx_vendor_lists_single_before_image', $vendor->term_id, $vendor->id); ?>
	<div class="wcmp-profile-wrap">
		<div class="wcmp-cover-picture" style="background-image: url('<?php if($banner) echo $banner; ?>');"></div>
		<div class="store-badge-wrap">
			<?php do_action('mvx_vendor_lists_vendor_store_badges', $vendor); ?>
		</div>
		<div class="wcmp-store-info">
			<div class="wcmp-store-picture">
				<img class="vendor_img" src="<?php echo esc_url($image); ?>" id="vendor_image_display">
			</div>
			<?php
				$rating_info = mvx_get_vendor_review_info($vendor->term_id);
                $MVX->template->get_template('review/rating_vendor_lists.php', array('rating_val_array' => $rating_info));
			?>
		</div>
	</div>
	<?php do_action('mvx_vendor_lists_single_after_image', $vendor->term_id, $vendor->id); ?>
	<div class="wcmp-store-detail-wrap">
		<?php do_action('mvx_vendor_lists_vendor_before_store_details', $vendor); ?>
		<ul class="wcmp-store-detail-list">
			<li>
				<i class="wcmp-font ico-store-icon"></i>
				<?php $button_text = apply_filters('mvx_vendor_lists_single_button_text', $vendor->page_title); ?>
				<a href="<?php echo esc_url($vendor->get_permalink()); ?>" class="store-name"><?php echo esc_html($button_text); ?></a>
				<?php do_action('mvx_vendor_lists_single_after_button', $vendor->term_id, $vendor->id); ?>
				<?php do_action('mvx_vendor_lists_vendor_after_title', $vendor); ?>
			</li>
			<?php if($vendor->get_formatted_address()) : ?>
			<li>
				<i class="wcmp-font ico-location-icon2"></i>
				<p><?php echo esc_html($vendor->get_formatted_address()); ?></p>
			</li>
			<?php endif; ?>
		</ul>
		<?php do_action('mvx_vendor_lists_vendor_after_store_details', $vendor); ?>
	</div>
</div>
