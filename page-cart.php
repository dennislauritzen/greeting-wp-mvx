<?php
/**
 * Template Name: Page (Cart)
 * Description: Page template.
 *
 */

get_header();
get_header('green');

the_post();
?>
<section id="cart" class="container">
  <div class="row mt-4">
  	<div class="col-12">
  		<div id="post-<?php the_ID(); ?>" <?php post_class( 'content' ); ?>>
  			<h1 class="entry-title"><?php the_title(); ?></h1>
  			<?php
  				the_content();
  			?>
  		</div><!-- /#post-<?php the_ID(); ?> -->
  	</div><!-- /.col -->
  </div><!-- /.row -->
</section>
<?php
get_footer();
