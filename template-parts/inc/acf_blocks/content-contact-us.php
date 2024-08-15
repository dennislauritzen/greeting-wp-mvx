<section id="address" class="mt-5 pt-5 mb-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 offset-lg-2 col-lg-8 text-center">
                <h5 class="mt-3 mb-4 fs-3"><?php echo get_field('header'); ?></h5>
                <p class="mb-2"><?php echo get_field('text'); ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 offset-lg-2 col-lg-8 text-center pt-4">
                <div class="row">
                    <div class="col-6 col-lg-4">
                        <svg class="svg-icon" viewBox="0 0 20 20" style="padding-bottom: 25px; width:50px; color: #444444;">
                            <path d="M17.388,4.751H2.613c-0.213,0-0.389,0.175-0.389,0.389v9.72c0,0.216,0.175,0.389,0.389,0.389h14.775c0.214,0,0.389-0.173,0.389-0.389v-9.72C17.776,4.926,17.602,4.751,17.388,4.751 M16.448,5.53L10,11.984L3.552,5.53H16.448zM3.002,6.081l3.921,3.925l-3.921,3.925V6.081z M3.56,14.471l3.914-3.916l2.253,2.253c0.153,0.153,0.395,0.153,0.548,0l2.253-2.253l3.913,3.916H3.56z M16.999,13.931l-3.921-3.925l3.921-3.925V13.931z"></path>
                        </svg>
                        <br>

                        E-mail<br>
                        <?php
                        if(!empty(get_field('email'))){
                            echo '<p><a href="mailto:' . get_field('email') . '">' . get_field('email') . '</a></p>';
                        }
                        ?>
                    </div>
                    <div class="col-6 col-lg-4">
                        <svg class="svg-icon" viewBox="0 0 20 20" style="padding-bottom: 25px; width:50px; color: #444444;">
                            <path d="M13.372,1.781H6.628c-0.696,0-1.265,0.569-1.265,1.265v13.91c0,0.695,0.569,1.265,1.265,1.265h6.744c0.695,0,1.265-0.569,1.265-1.265V3.045C14.637,2.35,14.067,1.781,13.372,1.781 M13.794,16.955c0,0.228-0.194,0.421-0.422,0.421H6.628c-0.228,0-0.421-0.193-0.421-0.421v-0.843h7.587V16.955z M13.794,15.269H6.207V4.731h7.587V15.269z M13.794,3.888H6.207V3.045c0-0.228,0.194-0.421,0.421-0.421h6.744c0.228,0,0.422,0.194,0.422,0.421V3.888z"></path>
                        </svg>
                        <br>

                        Telefon<br>
                        <?php
                        if(!empty(get_field('phone'))){
                            echo '<p><a href="tel:' . get_field('phone') . '">' . get_field('phone') . '</a></p>';
                        }
                        ?>
                    </div>
                    <div class="col-12 col-lg-4">
                        <svg class="svg-icon" viewBox="0 0 20 20" style="padding-bottom: 25px; width:50px; color: #444444;">
                            <path d="M17.659,3.681H8.468c-0.211,0-0.383,0.172-0.383,0.383v2.681H2.341c-0.21,0-0.383,0.172-0.383,0.383v6.126c0,0.211,0.172,0.383,0.383,0.383h1.532v2.298c0,0.566,0.554,0.368,0.653,0.27l2.569-2.567h4.437c0.21,0,0.383-0.172,0.383-0.383v-2.681h1.013l2.546,2.567c0.242,0.249,0.652,0.065,0.652-0.27v-2.298h1.533c0.211,0,0.383-0.172,0.383-0.382V4.063C18.042,3.853,17.87,3.681,17.659,3.681 M11.148,12.87H6.937c-0.102,0-0.199,0.04-0.27,0.113l-2.028,2.025v-1.756c0-0.211-0.172-0.383-0.383-0.383H2.724V7.51h5.361v2.68c0,0.21,0.172,0.382,0.383,0.382h2.68V12.87z M17.276,9.807h-1.533c-0.211,0-0.383,0.172-0.383,0.383v1.755L13.356,9.92c-0.07-0.073-0.169-0.113-0.27-0.113H8.851v-5.36h8.425V9.807z"></path>
                        </svg>
                        <br>

                        Social<br>
                        <?php
                        if(!empty(get_field('facebook'))){
                            echo '<p><a href="' . get_field('facebook') . '">Facebook</a></p>';
                        }
                        ?>
                        <?php
                        if(!empty(get_field('instagram'))){
                            echo '<p><a href="' . get_field('instagram') . '">Instagram</a></p>';
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>