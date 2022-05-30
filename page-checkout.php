<?php
/**
 * Template Name: Page (Checkout)
 * Description: Page template.
 *
 */

get_header('checkout');

the_post();
?>
<section id="checkout" class="container">
  <div class="row mt-4">
  	<div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 pt-4">
  		<div id="post-<?php the_ID(); ?>" <?php post_class( 'content' ); ?>>
  			<!--<h1 class="entry-title"><?php the_title(); ?></h1>-->
  			<?php
          #var_dump(WC()->checkout);
  				the_content();
  			?>
  		</div><!-- /#post-<?php the_ID(); ?> -->
  	</div><!-- /.col -->
  </div><!-- /.row -->
</section>
<?php
get_footer();
