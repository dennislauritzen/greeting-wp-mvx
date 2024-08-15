<section id="contact-person" class="mt-5 pt-5 mb-5 pb-5">
    <div class="container rounded" style="background: #efefef; border-radius: 25px !important;">
        <!--<div class="row">
            <div class="col-12">
                <h5 class="mt-3 mb-4 fs-3"><?php echo get_field('header'); ?></h5>
                <p class="mb-2"><?php echo get_field('text'); ?></p>
            </div>
        </div>-->
        <div class="row">
            <div class="col-12 px-2 py-4">
                <div class="row align-items-center">
                    <div class="col-6 col-lg-4 col-xl-3">
                        <div class=" px-4 py-3">
                            <img src="<?php echo get_field('image'); ?>" class="rounded img-fluid">
                        </div>
                    </div>
                    <div class="col-6 col-lg-8 col-xl-9">
                        <p class="fs-2 pb-0 mb-0"><?php echo get_field('name'); ?></p>
                        <i><?php echo get_field('title'); ?></i>
                        <br><br>
                        <a class="bg-teal btn rounded-pill text-white my-2 py-2 px-4" href="mailto:<?php echo get_field('email'); ?>" title="Læs mere om konceptet bag Greeting.dk" target="" style="color: #fff;">
                            <svg viewBox="0 0 20 20" class="text-white" fill="currentColor" style="width:25px; padding: 0 3px 3px 0;">
                                <path d="M17.388,4.751H2.613c-0.213,0-0.389,0.175-0.389,0.389v9.72c0,0.216,0.175,0.389,0.389,0.389h14.775c0.214,0,0.389-0.173,0.389-0.389v-9.72C17.776,4.926,17.602,4.751,17.388,4.751 M16.448,5.53L10,11.984L3.552,5.53H16.448zM3.002,6.081l3.921,3.925l-3.921,3.925V6.081z M3.56,14.471l3.914-3.916l2.253,2.253c0.153,0.153,0.395,0.153,0.548,0l2.253-2.253l3.913,3.916H3.56z M16.999,13.931l-3.921-3.925l3.921-3.925V13.931z"></path>
                            </svg>
                            <?php echo get_field('email'); ?>
                        </a>&nbsp;
                        <a class="bg-teal btn rounded-pill text-white my-2 py-2 px-4" href="tel:<?php echo str_replace(' ','', get_field('phone') ); ?>"  target="">
                            <svg viewBox="0 0 20 20" class="text-white" fill="currentColor" style="width:25px; padding: 0 3px 0px 0;">
                                <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"></path>
                            </svg>
                            <?php echo get_field('phone'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>