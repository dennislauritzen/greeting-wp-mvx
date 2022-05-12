<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php wp_head(); ?>

	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.min.css">
  <style type="text/css">
  .slider.slider-horizontal{
    width:100%;
  }
  .slider .slider-handle {
    background-color: #446a6b;
    background-image: none;
  }
  </style>


  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Rubik:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<?php
	$navbar_scheme   = get_theme_mod( 'navbar_scheme', 'navbar-light bg-light' ); // Get custom meta-value.
	$navbar_position = get_theme_mod( 'navbar_position', 'static' ); // Get custom meta-value.

	$search_enabled  = get_theme_mod( 'search_enabled', '1' ); // Get custom meta-value.
?>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<a href="#main" class="visually-hidden-focusable"><?php esc_html_e( 'Skip to main content', 'greeting2' ); ?></a>

<div id="wrapper">
	<header>
    <div class="bg-pink small text-uppercase">
        <div class="container d-flex justify-content-center justify-content-lg-between">
						<?php
						wp_nav_menu(
							array(
								'menu' => 'Main Navigation Menu (Top)',
								'theme_location' => 'main-menu-desktop',
								'container' => 'ul',
								'menu_class' => 'nav d-none d-lg-inline-flex m-0',
								'depth' => '1',
    						'fallback_cb'    => false, // Do not fall back to wp_page_menu(),
								'add_li_class' => 'nav-item',
								'add_a_class' => 'nav-link text-dark ps-0'
							)
						);
						?>
            <ul class="nav d-inline-flex m-0">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="mailto:<?php echo get_field('greeting_contact_mail_address', 'option'); ?>">
											<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-envelope-heart" viewBox="0 0 16 16">
											  <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l3.235 1.94a2.76 2.76 0 0 0-.233 1.027L1 5.384v5.721l3.453-2.124c.146.277.329.556.55.835l-3.97 2.443A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741l-3.968-2.442c.22-.28.403-.56.55-.836L15 11.105V5.383l-3.002 1.801a2.76 2.76 0 0 0-.233-1.026L15 4.217V4a1 1 0 0 0-1-1H2Zm6 2.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z"/>
											</svg>
											&nbsp;<?php echo get_field('greeting_contact_mail_address', 'option'); ?>
										</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="tel:+45<?php echo get_field('greeting_contact_phone_number', 'option'); ?>">
											<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
											  <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
											</svg>
											&nbsp;<?php echo trim(strrev(chunk_split(strrev( get_field('greeting_contact_phone_number', 'option') ),2, ' '))); ?></a>
                </li>
            </ul>
        </div>
    </div>
	</header>
	<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenu">
	  <div class="offcanvas-header">
	    <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
	    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	  </div>
	  <div class="offcanvas-body">
	    <div class="">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'main-menu-mobile',
						'container' => 'ul',
						'menu_class' => 'nav m-0',
						'depth' => '1',
						'fallback_cb'    => false, // Do not fall back to wp_page_menu(),
						'add_li_class' => 'col-12',
						'add_a_class' => 'nav-link text-dark ps-0'
					)
				);
				?>
	    </div>
	  </div>
	</div>
