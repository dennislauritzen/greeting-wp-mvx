<section id="didyouknow">
  <div class="container text-center mb-5 mt-5 py-3">
    <div class="row">
      <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
        <h4 class="pb-3"><?php echo get_field('didyouknow_header', 'options'); ?></h4>
        <?php echo get_field('didyouknow_text', 'options'); ?>
        <a href="<?php echo get_field('didyouknow_cta_link', 'options'); ?>" title="Vidste du følgende om Greeting.dk?" class="btn bg-teal text-white rounded-pill">
          <?php echo get_field('didyouknow_cta_text', 'options'); ?>
        </a>
      </div>
    </div>
  </div>
</section>
