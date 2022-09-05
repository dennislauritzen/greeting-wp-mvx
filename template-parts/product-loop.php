<?php
if($args['filteredProductArrayUnique']){
    $vendorProducts = $args['filteredProductArrayUnique'];
}
?>

<?php
foreach ($vendorProducts as $productId) {
	// echo "<pre>";
	// echo var_dump($filteredProductArrayUnique);
	// echo "</pre>";

	$product = wc_get_product( $productId );
	$uploadedImage = wp_get_attachment_url( $product->get_image_id() );
	$uploadDir = wp_upload_dir();
	$uploadDirBaseUrl = $uploadDir['baseurl'];
	?>

	<div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
		<div class="card mb-4 border-0">
			<a href="<?php echo get_permalink($product->get_id());?>">
			<?php if($uploadedImage != ''){?>
				<img
				src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>"
				class="attachment-shop_catalog size-shop_catalog"
				alt=""
				loading="lazy"
				title="<?php echo $product->get_name();?>"
				class="card-img-top"
				alt="<?php echo $product->get_name();?>">
			<?php } else { ?>
				<img
				src="<?php echo $uploadDirBaseUrl;?>/woocommerce-placeholder-300x300.png"
				class="card-img-top"
				alt="<?php echo $product->get_name();?>">
			<?php } ?>
			</a>
			<div class="card-body">
				<h6 class="card-title text-dark" style="font-size: 14px;">
					<a href="<?php echo get_permalink($product->get_id());?>" class="text-dark">
						<?php echo $product->get_name();?>
					</a>
				</h6>
				<p class="price"><?php echo woocommerce_template_loop_price();?></p>
				<div class="links" style="display: none;">
					<a href="?add-to-cart=<?php echo $product->get_id();?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" title="Tilføj til kurv" data-product_id="<?php echo $product->get_id();?>" data-product_sku="RGD-00010-1" aria-label="Tilføj til kurv" rel="nofollow">Tilføj til kurv</a>
					<a href="<?php echo get_permalink($product->get_id());?>" class="rigid-quick-view-link" data-id="<?php echo $product->get_id();?>" title="Hurtig visning"><i class="fa fa-eye"></i></a>
				</div>
			</div>
		</div>
	</div>

<?php } ?>
