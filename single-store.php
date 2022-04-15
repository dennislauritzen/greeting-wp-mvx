
<?php get_header(); ?>

<section id="top" style="background: ">

</section>






<div id="content" class="content-area  rigid-right-sidebar">
	<div id="rigid_page_title" class="rigid_title_holder left_title">
		<div class="inner fixed">
			<!-- BREADCRUMB -->
			<div class="breadcrumb">

				<a href="<?php echo site_url();?>">Home</a>
				<span class="rigid-breadcrumb-delimiter">/</span> <?php the_title();?>
			</div><!-- END OF BREADCRUMB -->
			<!-- TITLE -->
			<h1 class="product_title entry-title heading-title"><?php the_title();?>john</h1>
			<!-- END OF TITLE -->
		</div>

	</div>
	<div id="products-wrapper" class="inner site-main" role="main">
	<?php //echo do_shortcode('[op-overview set_id="5417" show_closed_days="true" include_io="true" include_holidays="true"]');?>
		<div id="main" class="fixed box box-common">
			<div class="woocommerce-notices-wrapper"></div>
			<div class="content_holder">
				<div class="box-sort-filter">
					<h2 class="heading-title">Refine Products</h2>
					<div class="product-filter">
					<?php $form_action = preg_replace('%\/page/[0-9]+%', '', home_url(trailingslashit($wp->request)));?>
						<form id="rigid-price-filter-form" data-currency_pos="right_space" data-currency_symbol="DKK"  method="get" action="<?php echo $form_action;?>">
							<div id="price-filter" class="price_slider_wrapper">
								<div class="price_slider_amount" data-step="10">
									<input type="hidden" id="min_price" name="min_price" value="10" data-min="20" placeholder="Min price" />
									<input type="hidden" id="max_price" name="max_price" value="120" data-max="100" placeholder="Max price" />
									<div class="price_label">
										<p>
											Price range: <span id="rigid_price_range"><span class="from"></span> &mdash; <span class="to"></span></span>
										</p>
									</div>
									<div class="clear"></div>
								</div>
								<div class="price_slider"></div>
							</div>
						</form>
						<form class="woocommerce-ordering" method="get">
							<div class="limit">
								<b>Show:</b>
								<select class="per_page" name="per_page">
									<option value="12" >12</option>
									<option value="24" >24</option>
									<option value="48" >48</option>
									<option value="96" >96</option>
									<option value="-1" >Show All</option>
								</select>
							</div>
							<div class="sort">
								<b>Sort By:</b>
								<select name="orderby" class="orderby" aria-label="Shop order">
									<option value="menu_order"  selected='selected'>Default sorting</option>
									<option value="popularity" >Sort by popularity</option>
									<option value="rating" >Sort by average rating</option>
									<option value="date" >Sort by latest</option>
									<option value="price" >Sort by price: low to high</option>
									<option value="price-desc" >Sort by price: high to low</option>
								</select>
								<input type="hidden" name="paged" value="1" />
							</div>
						</form>
						<div class="clear"></div>
					</div>
				</div>
				<div class="box-product-list">
					<div class="box-products woocommerce columns-4">
						<?php
						$storeId = get_the_ID();
						$connected = new WP_Query( [
							'relationship' => [
								'id'   => 'stores_to_products',
								'from' => get_the_ID(), // You can pass object ID or full object
							],
							'nopaging'     => true,
						] );
						while ( $connected->have_posts() ) : $connected->the_post();
						?>

						<div class="prod_hold rigid-prodhover-swap rigid-buttons-on-hover rigid-products-hover-shadow product type-product post-<?php the_ID();?> status-publish first instock product_cat-home-living product_cat-jewelry product_tag-blouse product_tag-top has-post-thumbnail featured shipping-taxable purchasable product-type-simple">
							<div class="image">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail()?>
									<?php the_post_thumbnail()?>
								</a>
								<!-- Small countdown -->
							</div>
							<div class="rigid-list-prod-summary">
								<a class="wrap_link" href="<?php the_permalink(); ?>">
									<span class="name"><?php the_title();?></span>
								</a>
								<div class="price_hold">
									<span class="woocommerce-Price-amount amount">
										<?php woocommerce_template_loop_price() ?>
									</span>
								</div>
							</div>
							<div class="links">
								<a href="?add-to-cart=<?php the_ID();?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" title="Add to cart" data-product_id="<?php the_ID();?>" data-product_store_id="<?php echo $storeId;?>" data-product_sku="RGD-00011-1" aria-label="Add &ldquo;Anniversary Gift&rdquo; to your cart" rel="nofollow">Add to cart</a>
								<a href="#" class="rigid-quick-view-link" data-id="<?php the_ID();?>" title="Quick View">
									<i class="fa fa-eye"></i>
								</a>
								<div class="yith-wcwl-add-to-wishlist add-to-wishlist-<?php the_ID();?>  wishlist-fragment on-first-load" data-fragment-ref="<?php the_ID();?>" data-fragment-options="{&quot;base_url&quot;:&quot;&quot;,&quot;in_default_wishlist&quot;:false,&quot;is_single&quot;:false,&quot;show_exists&quot;:false,&quot;product_id&quot;:<?php the_ID();?>,&quot;parent_product_id&quot;:<?php the_ID();?>,&quot;product_type&quot;:&quot;simple&quot;,&quot;show_view&quot;:false,&quot;browse_wishlist_text&quot;:&quot;Browse wishlist&quot;,&quot;already_in_wishslist_text&quot;:&quot;The product is already in your wishlist!&quot;,&quot;product_added_text&quot;:&quot;Product added!&quot;,&quot;heading_icon&quot;:&quot;fa-heart-o&quot;,&quot;available_multi_wishlist&quot;:false,&quot;disable_wishlist&quot;:false,&quot;show_count&quot;:false,&quot;ajax_loading&quot;:false,&quot;loop_position&quot;:&quot;after_add_to_cart&quot;,&quot;item&quot;:&quot;add_to_wishlist&quot;}">
									<!-- ADD TO WISHLIST -->
									<div class="yith-wcwl-add-button">
										<a
											href="?add_to_wishlist=<?php the_ID();?>&#038;_wpnonce=645d1b5c2b"
											class="add_to_wishlist single_add_to_wishlist"
											data-product-id="<?php the_ID();?>"
											data-product-type="simple"
											data-original-product-id="<?php the_ID();?>"
											data-title="Add to wishlist"
											rel="nofollow"
										>
											<i class="yith-wcwl-icon fa fa-heart-o"></i><span>Add to wishlist</span>
										</a>
									</div>
									<!-- COUNT TEXT -->
								</div>
							</div>
						</div><!-- end product holder -->
						<?php
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<script type='text/javascript' src='<?php echo site_url();?>/wp-includes/js/jquery/ui/core.min.js?ver=1.12.1' id='jquery-ui-core-js'></script>
<script type='text/javascript' src='<?php echo site_url();?>/wp-includes/js/jquery/ui/mouse.min.js?ver=1.12.1' id='jquery-ui-mouse-js'></script>
<script type='text/javascript' src='<?php echo site_url();?>/wp-includes/js/jquery/ui/slider.min.js?ver=1.12.1' id='jquery-ui-slider-js'></script>
<script type='text/javascript' src='<?php echo site_url();?>/wp-content/themes/greeting-theme/js/rigid-price-slider.js?ver=5.8.1' id='rigid-price-slider-js'></script>

<?php get_footer();?>
