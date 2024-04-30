<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $MVX;



 if ( post_password_required() ) {
    echo get_the_password_form();
    return;
 }
?>


<section id="product" class="mb-5">
  <div class="container">
    <div class="row">
        <div class="col-12">
          <?php
          /**
           * Hook: woocommerce_before_single_product.
           *
           * @hooked wc_print_notices - 10
           */
           do_action( 'woocommerce_before_single_product' );
          ?>
        </div>
        <?php
        // WooCommerce single product gallery type
        //$rigid_single_product_gallery_classes = rigid_get_gallery_type_classes(array());
        ?>
        <div class="col-md-12 col-lg-6">
          <?php
              /**
               * Hook: woocommerce_before_single_product_summary.
               *
               * @hooked woocommerce_show_product_sale_flash - 10
               * @hooked woocommerce_show_product_images - 20
               */
              do_action( 'woocommerce_before_single_product_summary' );
          ?>
        </div>
        <div class="col-md-12 col-lg-6">
            <?php
                /**
                 * Hook: woocommerce_single_product_summary.
                 *
                 * @hooked woocommerce_template_single_title - 5
                 * @hooked woocommerce_template_single_excerpt - 6
                 * @hooked rigid_product_sale_countdown - 7
                 * @hooked woocommerce_template_single_rating - 10
                 * @hooked woocommerce_template_single_price - 10
                 * @hooked woocommerce_template_single_add_to_cart - 30
                 * @hooked woocommerce_template_single_meta - 40
                 * @hooked woocommerce_template_single_sharing - 50
                 * @hooked WC_Structured_Data::generate_product_data() - 60
                 */
                do_action( 'woocommerce_single_product_summary' );
            ?>

            <div class="col-12 bg-light-grey">
              <div class="container py-3">
                <div class="row">
                  <div class="col-12 py-1">
                    <strong><small>Fordele, når du handler på Greeting.dk</small></strong>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 py-1">
                    <small>✍️ Du får altid håndskrevet kort med din personlige hilsen.</small>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 py-1">
                    <small>🚲 Varen leveres direkte til din modtager på den dag du vælger under købsprocessen.</small>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 py-1">
                    <small>🏷️ Du betaler 69,- for levering - lige til din modtagers dør.</small>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 py-1">
                    <small>🤝 Du støtter en fysisk, dansk butik med dit køb.</small>
                  </div>
                </div>
              </div>
            </div>


            <?php
            // Get the product categories
            $categories = get_the_terms( get_the_ID(), 'product_cat' );

            // Check if categories exist
            if ( $categories && !is_wp_error( $categories ) ) {
                $default_category_id = get_option( 'default_product_cat' );

                echo '<div class="product-categories mt-3 mb-2">';
                echo '<span style="font-size: 14px;">Kategorier: </span>';
                foreach ( $categories as $category ) {
                    if(!empty($default_category_id) && !empty($category->term_id) && $category->term_id == $default_category_id){
                        continue;
                    }
                    $category_link = get_term_link( $category );
                    echo '<a href="' . esc_url( $category_link ) . '" class="badge border border-grey text-dark me-1 mb-1 px-2 py-2 fw-normal">' . esc_html( $category->name ) . '</a>';
                }
                echo '</div>';
            }
            ?>

            <?php
            // Get the product occasions
            $categories = get_the_terms( get_the_ID(), 'occasion' );

            // Check if categories exist
            if ( $categories && ! is_wp_error( $categories ) ) {
                echo '<div class="product-categories mb-2">';
                echo '<span style="font-size: 14px;">Anledninger: </span>';
                foreach ( $categories as $category ) {
                    $category_link = get_term_link( $category );
                    echo '<a href="' . esc_url( $category_link ) . '" class="badge border border-grey text-dark me-1 mb-1 px-2 py-2 fw-normal">' . esc_html( $category->name ) . '</a>';
                }
                echo '</div>';
            }
            ?>

        </div>
      </div><!-- .row -->
	</div><!-- closing div of content-holder -->
</section><!-- #product-<?php the_ID(); ?> -->
<?php
    /**
     * woocommerce_after_single_product_summary hook.
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    do_action( 'woocommerce_after_single_product_summary' );
?>
<?php do_action( 'woocommerce_after_single_product' ); ?>
