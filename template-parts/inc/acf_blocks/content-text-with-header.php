<section class="mt-5 pt-5 mb-5 pb-5" style="background-color: <?php echo get_field('section_background_color'); ?>">
    <div class="container">
        <div class="row">
            <?php if( !empty(get_field('header')) ){ ?>
            <div class="col-12">
                <h5 class="fs-2 pt-3 pb-4<?php echo (!empty(get_field('text-align_header')) ? ' text-'.get_field('text-align_text') : ''); ?>"><?php echo get_field('header'); ?></h5>
            </div>
            <?php } ?>

            <div class="col-12 pb-4<?php echo (!empty(get_field('text-align_text')) ? ' text-'.get_field('text-align_text') : ''); ?>">
                <?php echo get_field('text'); ?>
            </div>
        </div>
    </div>
</section>