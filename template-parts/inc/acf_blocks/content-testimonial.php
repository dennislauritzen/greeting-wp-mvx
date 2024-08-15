<?php
/**
 * Block Name: Testimonial
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
        <div class="row">
            <div class="pb-3 col-12 fs-2 text-center">
                "<i><?php echo get_field('text__quote'); ?></i>"
            </div>
            <div class="col-12s text-center">
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
        </div>
    </div>
</section>