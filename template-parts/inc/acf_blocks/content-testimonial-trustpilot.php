<?php
/**
 * Block Name: Testimonial Trustpilot
 *
 * This is the template that displays the testimonial block.
 */

// get image field (array)
$avatar = get_field('picture');

// create id attribute for specific styling
$id = 'testimonial-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

?>

<section id="<?php echo $id; ?>" class="mt-4 mt-lg-5 mb-4 mb-lg-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-12 fs-2 pt-2 pb-3 text-center">
                ⭐⭐⭐⭐⭐
            </div>
            <div class="pb-3 col-12 fs-2 text-center">
                "<i><?php echo get_field('text__quote'); ?></i>"
            </div>
            <div class="col-12 text-center">
                <div>
                    <img src="<?php echo $avatar; ?>" class="img-fluid rounded-circle" style="max-height: 150px;">
                </div>
                <?php if( !empty(get_field('name')) ){ ?>
                <div class="pt-2 fw-bold">
                    <?php echo get_field('name'); ?>
                </div>
                <?php } ?>
                <div class="pt-1">
                    <i><?php echo get_field('work_title'); ?></i>
                </div>
            </div>
            <div class="col-12 pt-3 pb-3">
                <a class="bg-teal btn rounded-pill text-white my-2 py-2 px-4" href="https://dk.trustpilot.com/review/greeting.dk" title="Læs alle vores anmeldelser" target="">
                    Se alle vores anmeldelser her
                </a>
            </div>
        </div>
    </div>
</section>