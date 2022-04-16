<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce\Templates
 * @version     3.3.0
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
global $wp_query;
$woocommerce_sidebar = rigid_get_option('woocommerce_sidebar');

$vendor_sidebar = 'none';
if(RIGID_IS_WC_MARKETPLACE || RIGID_IS_WC_VENDORS) {
    $vendor_sidebar = rigid_get_option('vendor_sidebar');
}

$show_sidebar_class = '';

if (RIGID_IS_WC_MARKETPLACE && is_tax( 'dc_vendor_shop' ) && $vendor_sidebar != 'none') {
    $show_sidebar_class = 'has-sidebar';
} elseif (RIGID_IS_WC_MARKETPLACE && is_tax( 'dc_vendor_shop' ) && $vendor_sidebar == 'none') {
    $show_sidebar_class = '';
} elseif (RIGID_IS_WC_VENDORS && WCV_Vendors::is_vendor_page() && $vendor_sidebar != 'none') {
    $show_sidebar_class = 'has-sidebar';
} elseif (RIGID_IS_WC_VENDORS && WCV_Vendors::is_vendor_page() && $vendor_sidebar == 'none') {
    $show_sidebar_class = '';
} elseif (rigid_get_option('show_sidebar_shop') && $woocommerce_sidebar && $woocommerce_sidebar != 'none' && !is_product()) {
	$show_sidebar_class = 'has-sidebar';
} elseif (rigid_get_option('show_sidebar_product') && $woocommerce_sidebar && $woocommerce_sidebar != 'none' && is_product()) {
	$show_sidebar_class = 'has-sidebar';
}

$rigid_offcanvas_sidebar_choice = apply_filters('rigid_has_offcanvas_sidebar', '');

if ($rigid_offcanvas_sidebar_choice != 'none') {
	$rigid_has_offcanvas_sidebar = is_active_sidebar($rigid_offcanvas_sidebar_choice);
} else {
	$rigid_has_offcanvas_sidebar = false;
}

$sidebar_classes[] = $show_sidebar_class;

// Sidebar position
$sidebar_classes[] = apply_filters('rigid_left_sidebar_position_class', '');

if ($rigid_has_offcanvas_sidebar) {
	$sidebar_classes[] = 'has-off-canvas-sidebar';
}

// get Shop subtitle
$shop_subtitle = rigid_get_option('shop_subtitle');
$title_background_image = rigid_get_option('shop_title_background_imgid');

if ($title_background_image) {
	$img = wp_get_attachment_image_src($title_background_image, 'full');
	$title_background_image = $img[0];
}

// If it is product category or tag - check if it has header image
$rigid_prod_category_header_img_id = 0;
$rigid_prod_category_header_alignment = '';
$rigid_prod_category_subtitle = '';

$rigid_queried_object = $wp_query->get_queried_object();
$rigid_is_product_attribute = isset($rigid_queried_object->taxonomy) && taxonomy_is_product_attribute($rigid_queried_object->taxonomy);
if (isset($rigid_queried_object->term_id) && (is_product_category() || is_product_tag() || $rigid_is_product_attribute)) {
    $rigid_prod_category_header_img_id = absint( get_term_meta( $rigid_queried_object->term_id, 'rigid_term_header_img_id', true ) );
    $rigid_prod_category_header_alignment = get_term_meta( $rigid_queried_object->term_id, 'rigid_term_header_alignment', true );
    $rigid_prod_category_subtitle = get_term_meta( $rigid_queried_object->term_id, 'rigid_term_header_subtitle', true );
}

// If it is product - check for background image
$rigid_product_header_img_id = 0;
if(is_product()) {
    $product = wc_get_product();
    if(isset($product)) {
       $rigid_product_header_img_id = $product->get_meta('rigid_title_background_imgid', true);
    }
}
?>


<section id="product-<?php the_ID(); ?>">
  <div class="container">
    <div class="col-md-12 col-lg-6">
      galleri
    </div>
    <div class="col-md-12 col-lg-6">
      produkt
    </div>
  </div>
</section>

<?php if ($rigid_has_offcanvas_sidebar): ?>
	<?php get_sidebar('offcanvas'); ?>
<?php endif; ?>
<div id="content" class="content-area <?php echo esc_attr(implode(' ', $sidebar_classes)) ?>">
	<?php if (is_shop()): // For SHOP page ?>
		<div id="rigid_page_title" class="rigid_title_holder <?php echo esc_attr(rigid_get_option('shop_title_alignment')) ?> <?php if ($title_background_image): ?>title_has_image<?php endif; ?>">
			<?php if ($title_background_image): ?><div class="rigid-zoomable-background" style="background-image: url('<?php echo esc_url($title_background_image) ?>');"></div><?php endif; ?>
		<?php elseif(is_product_category() || is_product_tag() || $rigid_is_product_attribute):  // For Category / Tag / Attribute page?>
		    <div id="rigid_page_title" class="<?php echo implode(" ", array("rigid_title_holder", esc_attr($rigid_prod_category_header_alignment))) ?><?php if ($rigid_prod_category_header_img_id): ?> title_has_image<?php endif; ?>">
			<?php if($rigid_prod_category_header_img_id): ?>
                <?php $rigid_prod_category_header_img = wp_get_attachment_image_src($rigid_prod_category_header_img_id, 'full'); ?>
                <div class="rigid-zoomable-background" style="background-image: url('<?php echo esc_url($rigid_prod_category_header_img[0]) ?>');"></div>
			<?php endif; ?>
		<?php elseif($rigid_product_header_img_id): // For product ?>
		    <?php $rigid_product_image = wp_get_attachment_image_src($rigid_product_header_img_id, 'full'); ?>
		    <div id="rigid_page_title" class="rigid_title_holder title_has_image">
			<div class="rigid-zoomable-background" style="background-image: url('<?php echo esc_url($rigid_product_image[0]) ?>');"></div>
		<?php else: // For the rest?>
			<div id="rigid_page_title" class="rigid_title_holder" >
		<?php endif; ?>

			<div class="inner fixed">
				<!-- BREADCRUMB -->
				<?php if(rigid_get_option( 'show_breadcrumb')): ?>
                    <?php woocommerce_breadcrumb() ?>
                <?php endif; ?>
				<!-- END OF BREADCRUMB -->

				<!-- TITLE -->
				<?php if (!is_product() && apply_filters('woocommerce_show_page_title', true)): ?>
					<h1 class="product_title entry-title heading-title"><?php woocommerce_page_title(); ?></h1>
					<?php if (is_shop() && $shop_subtitle): ?>
						<h6><?php echo esc_html($shop_subtitle) ?></h6>
					<?php elseif ((is_product_category() || is_product_tag() || $rigid_is_product_attribute) && $rigid_prod_category_subtitle): ?>
						<h6><?php echo esc_html($rigid_prod_category_subtitle) ?></h6>
					<?php endif; ?>
				<?php endif; ?>
				<!-- END OF TITLE -->
			</div>

		</div>
		<div id="products-wrapper" class="inner site-main" role="main">
			<?php if ($rigid_has_offcanvas_sidebar): ?>
				<a class="sidebar-trigger" href="#"><?php echo esc_html__('show', 'rigid') ?></a>
			<?php endif; ?>
