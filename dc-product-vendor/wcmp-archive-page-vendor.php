<?php
defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: wcmp_before_main_content.
 *
 */

do_action( 'wcmp_before_main_content' );

global $WCMp;

?>
<header class="woocommerce-products-header">
	<?php
	/**
	 * Hook: wcmp_archive_description.
	 *
	 */
	do_action( 'wcmp_archive_description' );
	?>
</header>
<?php

/**
 * Hook: wcmp_store_tab_contents.
 *
 * Output wcmp store widget
 */

/*** amdad off this hook */
// do_action( 'wcmp_store_tab_widget_contents' );

/** amdad write custom code begin */
?>

<div>
	<div class="woocommerce-notices-wrapper">
	</div>

	<div class="content_holder">
		<!-- <div class="box-sort-filter rigid-product-filters-has-widgets">
		</div> -->
		<hr>
		<div id="defaultProductList" class="box-product-list">
			<div class="box-products woocommerce columns-3">
				<?php
				// Get vendor
				$vendorId = wcmp_find_shop_page_vendor();
				$vendor = get_wcmp_vendor($vendorId);

				$productIdArray = array();

				$vendorProducts = $vendor->get_products(array('fields' => 'ids'));
				foreach ($vendorProducts as $productId) {
					array_push($productIdArray, $productId);
					$singleProduct = wc_get_product( $productId );
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
				<?php
				}
				$defaultProductIdAsString = implode(",", $productIdArray);
				?>
				<input type="hidden" id="defaultProductIdAsString" value="<?php echo $defaultProductIdAsString;?>">
			</div>
		</div>

		<!--show ajax filtered result-->
		<div id="filteredProductList" class="box-product-list">
		</div>

	</div>

	<div class="sidebar">
		<div id="wcmp_vendor_product_categories-2" class="widget box wcmp woocommerce wcmp_widget_vendor_product_categories widget_product_categories">
			<h3>Filter</h3>
			<div style="float: left;">
				<span id="productResetAll" style="border:1px solid salmon; border-radius: 15px; padding:4px 10px;cursor:pointer;">Reset All</span>
			</div>
			<div class="clear">
			</div>
			<!-- category filter-->
			<div class="product_sort" style="margin-bottom:20px !important;">
				<p style="font-weight:500; margin: .5em 0">Category</p>
				<?php
				$categoryTermListArray = array();
				// $vendor previously declared and get value from there
				$vendorProducts = $vendor->get_products(array('fields' => 'ids'));
				foreach ($vendorProducts as $productId) {
					$categoryTermList = wp_get_post_terms($productId, 'product_cat', array('fields' => 'all'));
					foreach($categoryTermList as $catTerm){
						// unique item insert to array
						$uniqueTermId = $catTerm->term_id;
						$categoryTermListArray["$uniqueTermId"] = $catTerm;
					}
				}
				foreach($categoryTermListArray as $category){
					?>
					<div class="checkbox">
						<label><input type="checkbox" name="product_type" class="vendor_sort_product" value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></label>
					</div>
				<?php
				}
				?>
			</div>

			<!-- occasion filter-->
			<div class="product_sort" style="margin-bottom:20px !important;">
				<p style="font-weight:500; margin: .5em 0">Occasion</p>
				<?php
				$occasionTermListArray = array();
				// $vendor previously declared and get value from there
				$vendorProducts = $vendor->get_products(array('fields' => 'ids'));
				foreach ($vendorProducts as $productId) {
					$occasionTermList = wp_get_post_terms($productId, 'occasion', array('fields' => 'all'));
					foreach($occasionTermList as $occasionTerm){
						// unique item insert to array
						$uniqueTermId = $occasionTerm->term_id;
						$occasionTermListArray["$uniqueTermId"] = $occasionTerm;
					}
				}
				foreach($occasionTermListArray as $occasion){
					?>
					<div class="checkbox">
						<label><input type="checkbox" name="product_type" class="vendor_sort_product" value="<?php echo $occasion->term_id; ?>"><?php echo $occasion->name; ?></label>
					</div>
				<?php
				}
				?>
			</div>

			<!-- tag filter-->
			<div class="product_sort" style="margin-bottom:20px !important;">
				<p style="font-weight:500; margin: .5em 0">Tag</p>
				<?php
				$tagTermListArray = array();
				// $vendor previously declared and get value from there
				$vendorProducts = $vendor->get_products(array('fields' => 'ids'));
				foreach ($vendorProducts as $productId) {
					$tagTermList = wp_get_post_terms($productId, 'product_tag', array('fields' => 'all'));
					foreach($tagTermList as $tagTerm){
						// unique item insert to array
						$tagUniqueTermId = $occasionTerm->term_id;
						$tagTermListArray["$tagUniqueTermId"] = $tagTerm;
					}
				}
				foreach($tagTermListArray as $tag){ ?>
					<div class="checkbox">
						<label><input type="checkbox" name="product_type" class="vendor_sort_product" value="<?php echo $tag->term_id; ?>"><?php echo $tag->name; ?></label>
					</div>
				<?php
				}
				?>
			</div>
		</div>
	</div>
	<div class="clear">
	</div>
</div>


<div style="text-align: center;">
            	<div class="overlay"></div>
        	</div>

            <style>
                .overlay {
                    display: none;
                    position: fixed;
                    width: 100%;
                    height: 100%;
                    top: 0;
                    left: 0;
                    z-index: 999;
                    background: rgba(255,255,255,0.8) url("<?php echo get_stylesheet_directory_uri() . '/image/loading3.gif';?>") center no-repeat;
                }
                /* Turn off scrollbar when body element has the loading class */
                div.loading-custom3 {
                    overflow: hidden;
                }
                /* Make spinner image visible when body element has the loading class */
                div.loading-custom3 .overlay {
                    display: block;
                }
			</style>

<?php
/** amdad write custom code end */


/**
 * Hook: wcmp_after_main_content.
 *
 */
do_action( 'wcmp_after_main_content' );

/**
 * Hook: wcmp_sidebar.
 *
 */
// deprecated since version 3.0.0 with no alternative available
// do_action( 'wcmp_sidebar' );

get_footer( 'shop' );
