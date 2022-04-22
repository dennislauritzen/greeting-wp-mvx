<?php
if($args['filteredProductArrayUnique']){
    $filteredProductArrayUnique = $args['filteredProductArrayUnique'];
}
?>

<div class="box-products woocommerce columns-3">
	<?php
	foreach ($filteredProductArrayUnique as $filteredProduct) {
		$singleProduct = wc_get_product( $filteredProduct );
		$uploadedImage = wp_get_attachment_url( $singleProduct->get_image_id() );
		$uploadDir = wp_upload_dir();
		$uploadDirBaseUrl = $uploadDir['baseurl'];
		?>
		<div class="prod_hold rigid-prodhover-swap rigid-buttons-on-hover rigid-products-hover-shadow product type-product post-2914 status-publish first instock product_cat-celebrations product_tag-justfashion has-post-thumbnail featured shipping-taxable purchasable product-type-simple prod_visible">
			<?php if($uploadedImage != ''){?>
			<div class="image">
				<a href="<?php echo get_permalink($singleProduct->get_id());?>">
					<img width="370" height="370" src="<?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" loading="lazy" srcset="<?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 370w, <?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 150w, <?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 300w, <?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 768w, <?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 640w, <?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 100w, <?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 60w, <?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 620w, <?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 800w" sizes="(max-width: 370px) 100vw, 370px"> 
					<img width="370" height="370" src="<?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?>" class="attachment-shop_catalog size-shop_catalog" alt="" loading="lazy" title="m_prod5_2" srcset="<?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 370w, <?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 150w, <?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 300w, <?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 768w, <?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 640w, <?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 100w, <?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 60w, <?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 620w, <?php echo wp_get_attachment_url( $singleProduct->get_image_id() ); ?> 800w" sizes="(max-width: 370px) 100vw, 370px">
				</a>
			</div>
			<?php } else { ?>
				<a href="<?php echo get_permalink($singleProduct->get_id());?>">
					<img width="300" height="300" src="<?php echo $uploadDirBaseUrl;?>/woocommerce-placeholder-300x300.png" class="woocommerce-placeholder wp-post-image" alt="Placeholder" loading="lazy" srcset="<?php echo $uploadDirBaseUrl;?>/woocommerce-placeholder-300x300.png 300w, <?php echo $uploadDirBaseUrl;?>/woocommerce-placeholder-100x100.png 100w, <?php echo $uploadDirBaseUrl;?>/woocommerce-placeholder-600x600.png 600w, <?php echo $uploadDirBaseUrl;?>/woocommerce-placeholder-1024x1024.png 1024w, <?php echo $uploadDirBaseUrl;?>/woocommerce-placeholder-150x150.png 150w, <?php echo $uploadDirBaseUrl;?>/uploads/woocommerce-placeholder-768x768.png 768w, <?php echo $uploadDirBaseUrl;?>/woocommerce-placeholder-640x640.png 640w, <?php echo $uploadDirBaseUrl;?>/woocommerce-placeholder-60x60.png 60w, <?php echo $uploadDirBaseUrl;?>/woocommerce-placeholder.png 1200w" sizes="(max-width: 300px) 100vw, 300px">
				</a>
			<?php }?>
			<div class="rigid-list-prod-summary">
				<a class="wrap_link" href="<?php echo get_permalink($singleProduct->get_id());?>">
					<span class="name"> <?php echo $singleProduct->get_name();?> </span>
				</a>
				<div class="price_hold">
					<span class="woocommerce-Price-amount amount">
						<?php echo $singleProduct->get_price();?><span class="woocommerce-Price-currencySymbol"> DKK</span>
					</span>
				</div>
			</div>
			<div class="links">
				<a href="?add-to-cart=<?php echo $singleProduct->get_id();?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" title="Add to cart" data-product_id="<?php echo $singleProduct->get_id();?>" data-product_sku="RGD-00010-1" aria-label="Add “Framed Poster” to your cart" rel="nofollow">Add to cart</a>
				<a href="#" class="rigid-quick-view-link" data-id="<?php echo $singleProduct->get_id();?>" title="Quick View"><i class="fa fa-eye"></i></a>
			</div>
		</div>	
		<div class="clear">
		</div>
	<?php } ?>
</div>
