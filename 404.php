<?php
/**
 * Template Name: Not found
 * Description: Page template 404 Not found.
 *
 */

get_header();

get_header('green');

$search_enabled = get_theme_mod( 'search_enabled', '0' ); // Get custom meta-value.
?>
<div class="container content error404 not-found">
	<div class="row">
		<div class="col-12 mt-4"  style="color: #777777; font-family: 'Open Sans','Rubik',sans-serif; font-size: 14px;">
			<?php get_breadcrumb(); ?> / Siden kunne ikke findes
		</div>
	</div>
	<div class="row">
		<div class="col-12 mt-3 pt-2 pb-4">
			<h1 class="mt-0 pt-0 text-center" style="font-family: 'Rubik', sans-serif;">
				😢 Øv, vi kunne ikke finde den pågældende side!
			</h1>
			<p class=" text-center"><?php esc_html_e( 'It looks like nothing was found at this location.', 'greeting2' ); ?>. Det kan være fordi, siden er blevet flyttet, så linket
				ikke længere virker, eller fordi der er sket en fejl.</p>
		</div>



		<!-- Postal code search box START -->
		<div class="row">
			<div class="col-12 col-md-8 offset-md-2 bg-teal-front position-relative start-0 top-0">
					<div class="pt-3 pb-4 px-1 px-xs-1 px-sm-1 px-md-2 px-lg-5 px-xl-5 m-5 top-text-content">
							<h4 class="text-teal pt-4 fs-6">#STØTLOKALT #<?php echo strtoupper($category_name); ?> #GAVER</h4>
							<h3 class="text-white pb-1">Indtast postnummer & find lokale butikker</h3>
							<p class="text-white pb-3">
								For at vise dig butikker, der kan levere <?php echo strtolower($category_name); ?> gaver, er vi nødt til først at spørge om, hvilket postnummer, du gerne vil have leveret til?
							</p>
							<p></p>
							<script type="text/javascript">
							//set responsive mobile input field placeholder text
							if (jQuery(window).width() < 769) {
									jQuery("input#front_Search-new_ucsa").attr("placeholder", "By eller postnr. (eks. <?php echo (!empty($user_postal) ? $user_postal : '8000'); ?>)");
							}
							else {
									jQuery("input#front_Search-new_ucsa").attr("placeholder", "Indtast by eller postnr. (eks. <?php echo (!empty($user_postal) ? $user_postal : '8000'); ?>)");
							}
							jQuery(window).resize(function () {
									if (jQuery(window).width() < 769) {
											jQuery("input#front_Search-new_ucsa").attr("placeholder", "By eller postnr. (eks. <?php echo (!empty($user_postal) ? $user_postal : '8000'); ?>)");
									}
									else {
											jQuery("input#front_Search-new_ucsa").attr("placeholder", "Indtast by eller postnr. (eks. <?php echo (!empty($user_postal) ? $user_postal : '8000'); ?>)");
									}
							});
							</script>
							<form role="search" method="get" autocomplete="off" id="lp-searchform">
							<div class="input-group pb-4 w-100 me-0 me-xs-0 me-sm-0 me-md-0 me-lg-5 me-xl-5">
								<input type="text" name="keyword_catocca" id="front_Search-new_ucsa2" class="form-control border-0 ps-5 pe-3 py-3 shadow-sm rounded" placeholder="Indtast by eller postnr. (eks. <?php echo (!empty($user_postal) ? $user_postal : '8000'); ?>)">
								<figure class="position-absolute mt-2 mb-3 ps-3" style="padding-top:5px; z-index:1000;">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#333333" class="bi bi-geo-alt" viewBox="0 0 16 16">
										<path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
										<path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
									</svg>
								</figure>
								<button type="submit" class="d-sm-block d-md-none btn bg-yellow text-white ms-3 px-4 rounded">
									Gå
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
										<path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
									</svg>
								</button>
								<button type="submit" class="d-none d-md-block btn bg-yellow text-white ms-3 px-4 rounded">
									Gå
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
										<path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
									</svg>
								</button>
								<ul id="lp-datafetch_wrapper" class="d-inline list-group position-relative recommandations position-absolute list-unstyled rounded w-75 bg-white" style="top: 57px; ">

								</ul>
								</div>
							</form>
							<!--<h6 style="font-family: 'Rubik',sans-serif; font-size:18px; color: #ffffff;" class="pb-1">Måske følgende byer<?php if(!empty($user_postal)){ echo ' tæt på dig'; } ?> kunne være relevante?</h6>
							<ul id="lp-postalcodelist" class="list-inline my-1">

							</ul>-->
					</div>
			</div>
		</div><!-- .row end -->
		<!-- Postal code search box END -->


		<div class="row">
			<div class="col-12">
				<h5 class="pt-5 mt-3" style="font-family: 'Inter', sans-serif;">.. eller gå til en af vores kategorier eller anledninger her</h5>
			</div>
		</div>
		<?php
		################################
		################################
    // get user meta query
    $occasion_featured_list = $wpdb->get_results( "
    SELECT
      tt.term_id as term_id,
      tt.taxonomy,
		  t.name,
      t.slug,
      (SELECT tm.meta_value FROM {$wpdb->prefix}termmeta tm WHERE tm.term_id = tt.term_id AND tm.meta_key = 'featured') as featured,
      (SELECT tm.meta_value FROM {$wpdb->prefix}termmeta tm WHERE tm.term_id = tt.term_id AND tm.meta_key = 'featured_image') as image_src
    FROM
      {$wpdb->prefix}term_taxonomy tt
    INNER JOIN
      {$wpdb->prefix}terms t
    ON
      t.term_id = tt.term_id
    WHERE
      tt.taxonomy IN ('occasion')
    ORDER BY
      CASE featured
        WHEN 1 THEN 1
        ELSE 0
      END DESC,
      t.Name ASC
    ");
    $placeHolderImage = wc_placeholder_img_src();
    ?>

    <?php
    // Check if category/occassions exists.
    if(count($occasion_featured_list) > 0){
    ?>
    <div class="mt-2 mt-xs-2 mt-sm-0 mb-4" id="topoccassions">
      <div class="d-flex align-items-center mb-1">
        <h3 class="mt-1" style="font-family: Inter; font-size: 17px;">
					&#127874;
					&nbsp;Anledninger
				</h3>
        <div class="button-cont ms-auto">
          <button id="backButton" type="button" class="btn btn-light rounded-circle">
            <div class="align-items-center justify-content-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#1B4949" stroke-width="10" class="bi bi-chevron-left align-middle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" stroke-width="10" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
              </svg>
            </div>
          </button>
          <button id="forwardButton" type="button" class="btn btn-light rounded-circle">
            <div class="align-items-center justify-content-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#1B4949" stroke-width="10" class="bi bi-chevron-left align-middle"  viewBox="0 0 16 16">
                <path fill-rule="evenodd" stroke-width="10" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
              </svg>
            </div>
          </button>
        </div>
      </div>
      <style type="text/css">
        .card-img-top {
          min-height: 175px !important;
        }
        .catrownoscroll::-webkit-scrollbar {
          width: 0px
        }
      </style>

      <div class="d-flex flex-row flex-nowrap catrownoscroll p-1" id="occrowscroll" data-snap-slider="occasions" style="overflow-x: auto; scroll-snap-type: x mandatory !important; scroll-behavior: smooth;">
        <?php
        foreach($occasion_featured_list as $occasion){
          // Only show a card, if the cat/occasion is actually present in stores.
          $category_or_occasion = ($occasion->taxonomy == 'product_cat') ? 'cat' : 'occ_';

          $occasionImageUrl = '';
          if(!empty($occasion->image_src)){
            $occasionImageUrl = wp_get_attachment_image($occasion->image_src, 'vendor-product-box-size', false, array('class' => 'card-img-top ratio-4by3', 'alt' => $occasion->name));
          } else {
            $occasionImageUrl = wp_get_attachment_image($placeHolderImage, 'vendor-product-box-size', false, array('class' => 'card-img-top ratio-4by3', 'alt' => $occasion->name));
          }
        ?>
        <div class="col-6 col-sm-6 col-md-4 col-lg-2 py-0 my-0 pe-2 card_outer" style="scroll-snap-align: start;">
          <div class="card border-0 shadow-sm">
            <a href="<?php echo get_term_link($occasion); ?>" data-elm-id="<?php echo $category_or_occasion.$occasion->term_id; ?>" class="top-category-occasion-list stretched-link text-dark">
              <?php echo $occasionImageUrl;?>
              <div class="card-body">
                <h5 class="card-title" style="font-family: 'Inter',sans-serif; font-size: 14px;">
                  <b><?php echo $occasion->name;?></b>
                </h5>
              </div>
            </a>
          </div>
        </div>
      <?php
      }
      ?>
	    </div>
	  </div> <!-- .topoccasions end -->
    <?php
    } // end count.
    ?>



		<?php
		################################
		################################
    // get user meta query
    $occasion_featured_list = $wpdb->get_results( "
    SELECT
      tt.term_id as term_id,
      tt.taxonomy,
		  t.name,
      t.slug,
      (SELECT tm.meta_value FROM {$wpdb->prefix}termmeta tm WHERE tm.term_id = tt.term_id AND tm.meta_key = 'featured') as featured,
      (SELECT tm.meta_value FROM {$wpdb->prefix}termmeta tm WHERE tm.term_id = tt.term_id AND tm.meta_key = 'featured_image') as image_src
    FROM
      {$wpdb->prefix}term_taxonomy tt
    INNER JOIN
      {$wpdb->prefix}terms t
    ON
      t.term_id = tt.term_id
    WHERE
      tt.taxonomy IN ('product_cat')
    ORDER BY
      CASE featured
        WHEN 1 THEN 1
        ELSE 0
      END DESC,
      t.Name ASC
    ");
    $placeHolderImage = wc_placeholder_img_src();
    ?>

    <?php
    // Check if category/occassions exists.
    if(count($occasion_featured_list) > 0){
    ?>
    <div class="mt-2 mt-xs-2 mt-sm-0 mb-4" id="topcategories">
      <div class="d-flex align-items-center mb-1">
        <h3 class="mt-1" style="font-family: Inter; font-size: 17px;">
					&#128144;
	        &nbsp;Kategorier
				</h3>
        <div class="button-cont ms-auto">
          <button id="backButton2" type="button" class="btn btn-light rounded-circle">
            <div class="align-items-center justify-content-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#1B4949" stroke-width="10" class="bi bi-chevron-left align-middle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" stroke-width="10" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
              </svg>
            </div>
          </button>
          <button id="forwardButton2" type="button" class="btn btn-light rounded-circle">
            <div class="align-items-center justify-content-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#1B4949" stroke-width="10" class="bi bi-chevron-left align-middle"  viewBox="0 0 16 16">
                <path fill-rule="evenodd" stroke-width="10" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
              </svg>
            </div>
          </button>
        </div>
      </div>
      <style type="text/css">
        .card-img-top {
          min-height: 175px !important;
        }
        .catrownoscroll::-webkit-scrollbar {
          width: 0px
        }
      </style>

      <div class="d-flex flex-row flex-nowrap catrownoscroll p-1" id="catrowscroll" data-snap-slider="occasions" style="overflow-x: auto; scroll-snap-type: x mandatory !important; scroll-behavior: smooth;">
        <?php
        foreach($occasion_featured_list as $occasion){
          // Only show a card, if the cat/occasion is actually present in stores.
          $category_or_occasion = ($occasion->taxonomy == 'product_cat') ? 'cat' : 'occ_';

          $occasionImageUrl = '';
          if(!empty($occasion->image_src)){
            $occasionImageUrl = wp_get_attachment_image($occasion->image_src, 'vendor-product-box-size', false, array('class' => 'card-img-top ratio-4by3', 'alt' => $occasion->name));
          } else {
            $occasionImageUrl = wp_get_attachment_image($placeHolderImage, 'vendor-product-box-size', false, array('class' => 'card-img-top ratio-4by3', 'alt' => $occasion->name));
          }
        ?>
        <div class="col-6 col-sm-6 col-md-4 col-lg-2 py-0 my-0 pe-2 card_outer" style="scroll-snap-align: start;">
          <div class="card border-0 shadow-sm">
            <a href="<?php echo get_term_link($occasion); ?>" data-elm-id="<?php echo $category_or_occasion.$occasion->term_id; ?>" class="top-category-occasion-list stretched-link text-dark">
              <?php echo $occasionImageUrl;?>
              <div class="card-body">
                <h5 class="card-title" style="font-family: 'Inter',sans-serif; font-size: 14px;">
                  <b><?php echo $occasion->name;?></b>
                </h5>
              </div>
            </a>
          </div>
        </div>
      <?php
      }
      ?>
	    </div>
	  </div> <!-- .topoccasions end -->
    <?php
    } // end count.
    ?>






		<div class="offset-0 col-12 offset-lg-3 col-lg-5 mt-3 pt-2 pb-4">
			<?php
				if ( '1' === $search_enabled ) :
					get_search_form();
				endif;
			?>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($){

		// Select the container element
		const container = jQuery('#occrowscroll');
		const card_cont = jQuery('#occrowscroll div.card_outer:first-child');

		// Define the number of cards to scroll based on screen size
		const numCardsToScroll = jQuery(window).width() >= 992 ? 3 : 2;

		// Add click event listeners to the buttons
		jQuery("#forwardButton").click(function(){
			container.animate({
				scrollLeft: '+=' + (card_cont.outerWidth(true)-1) * numCardsToScroll
			}, '2');
		});

		jQuery("#backButton").click(function(){
			container.animate({
				scrollLeft: '-=' + (card_cont.outerWidth(true)-1) * numCardsToScroll
			}, '2');
		});

		// Select the container element
		const container2 = jQuery('#catrowscroll');
		const card_cont2 = jQuery('#catrowscroll div.card_outer:first-child');

		// Add click event listeners to the buttons
		jQuery("#forwardButton2").click(function(){
			container2.animate({
				scrollLeft: '+=' + (card_cont2.outerWidth(true)-1) * numCardsToScroll
			}, '2');
		});

		jQuery("#backButton2").click(function(){
			container2.animate({
				scrollLeft: '-=' + (card_cont2.outerWidth(true)-1) * numCardsToScroll
			}, '2');
		});

	});
</script>
<?php
get_footer();
