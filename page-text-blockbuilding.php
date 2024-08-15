<?php
/**
 * Template Name: Page (Block Builder)
 * Description: Page template.
 *
 */

get_header();
get_header('green');



the_post();
?>
<section id="landingpage">
  <div class="container">
    <div class="row">
      <div class="col-12 mt-4"  style="color: #777777; font-family: 'Open Sans','Rubik',sans-serif; font-size: 14px;">
        <?php get_breadcrumb(); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-12 mt-5 pt-2 pb-4">
        <h1><?php the_title(); ?></h1>
      </div>
    </div>
  </div>
</section>

<?php echo the_content(); ?>

<?php
get_footer();
