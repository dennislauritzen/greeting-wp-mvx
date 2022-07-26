<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php wp_head(); ?>

	<link rel='stylesheet' id='style-css' href='https://www.greeting.dk/wp-content/themes/greeting2/style.css?ver=3.0.4' media='all' />
	<link rel='stylesheet' id='main-css' href='https://www.greeting.dk/wp-content/themes/greeting2/assets/css/main.css?ver=3.0.4' media='all' />

	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js" async></script>
	<link rel="stylesheet preconnect" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.min.css">
  <style type="text/css">
  .slider.slider-horizontal{
    width:100%;
  }
  .slider .slider-handle {
    background-color: #446a6b;
    background-image: none;
  }


  .bg-pink {
    background: #F8F8F8;
  }
  .bg-rose {
    background: #fecbca;
  }
  .bg-teal {
    background: #446a6b;
  }
  .bg-teal-front {
    background: rgba(68, 106, 107,0.75);
  }
  .bg-teal-75 {
    background: rgba(68, 106, 107,0.75);
  }
  .border-teal {
    border-color: #446a6b;
  }
  .bg-light-grey {
    background: #F8F8F8;
  }
  .bg-yellow {
    background: #d6bf75;
  }
  .border-teal {
    border: 1px solid #446a6b;
  }
  .border-yellow {
    border: 1px solid #d6bf75;
  }
  .text-teal {
    color: #1b4949;
  }

  #top {
    border-top: 3px solid #fecbca;
  }

  .top-text-content {
    opacity: 1.0 !important;
  }

	/*
	*	Frontpage video
	*/
	#maintop {
	}
	#maintop .video-wrapper {
	  /* Telling our absolute positioned video to
	  be relative to this element */
	  width: 100vw;
	  height: 700px;
	  /* Will not allow the video to overflow the
	  container */
	  overflow: hidden;
	}
	video {
	  /** Simulationg background-size: cover */
	  object-fit: cover;
	  height: 100%;
	  width: 100%;
	}

	#spinner {
	  color:#fecbca;
	}
	#spinner:after {
	  content:"";
	  animation: spin 20s linear infinite;
	}
	@keyframes spin {
	  0% { content:"en gavekurv"; }
	  10% { content:"en vingave"; }
	  20% { content:"et strikkesæt"; }
	  30% { content:"en overraskelse"; }
	  40% { content:"en buket blomster"; }
	  50% { content: "en lækker gin"; }
	  60% { content: "smukke roser"; }
	  70% { content: "tak for besøg-gaven"; }
	  80% { content: "bare fordi-gaven"; }
	  90% { content: "en gavehilsen"; }
	  100% { content:"en gavekurv"; }
	}


	ul.recommandations {

	}
	ul.recommandations li.active {
		background-color: #d6bf75;
		border: 0;
	}
	ul.recommandations li.active a {
		color: #ffffff;
	}
	ul.recommandations li:hover {
		background-color: #d6bf75;
	}
	ul.recommandations li:last-child:hover {
		border-bottom-left-radius: 3px !important;
		border-bottom-right-radius: 3px !important;
	}
	ul.recommandations li:hover a,
	ul.recommandations li a:hover {
		color: #ffffff;
	}


  /*
  * section#hotitworks
  * How it works section
  * --
  */
  #howitworks h1,
  #howitworks h2,
  #howitworks h3 {
    font-family: "Dela Gothic One", cursive, serif;
    font-weight: 300;
  }
	ul.timeline {
		width: 100%;
		position: relative;
		list-style: none;
		line-height: 1.8em;
		min-height: 50px;
		float: left;
		text-align: center;
	}
	ul.timeline::before {
		content: "";
		display: block;
		background-color: #446a6b;
		height: 0.5px;
		margin: 0 ;
		position:relative;
		top:23px;
	}
  ul.timeline li {
    float: left;
    width: 20%;
    min-width: 125px;
    padding: 0 10px;
  }
  ul.timeline li figure {
    position: relative;
    z-index: 2;
    background: #F8F8F8;
    height: 50px;
    width: 80px;
    border-radius: 50%;
    margin: 0 auto 10px auto;
    box-sizing: inherit;
  }
  @media (min-width: 769px){
    ul.timeline::before {
      margin: 0 100px;
    }
  }
  @media (max-width: 768px){
    ul.timeline {
      text-align: left;
    }
    ul.timeline::before {
      content: "";
      position: absolute;
      width: 1px;
      top: 10px;
      left: 59px;
      margin-top: 25px;
      height: calc(100% - 75px);
    }
    ul.timeline li {
      display: flex;
      align-items: center;
      width: 100%;
      min-width: 200px;
      padding: 5px 10px 10px 10px;
    }
    ul.timeline li figure {
      width: 34px;
      text-align: left;
      margin: 0 15px 0 0;
    }
    ul.timeline li svg {
      width: 34px;
    }
  }

  /*
  * #inspiration .inspirationstores
  * The "get inspired by other stores sections"
  * also used on product pages.
  */
  .inspirationstores h1,
  .inspirationstores h2,
  .inspirationstores h3,
  .inspirationstores h4 {
    font-family: "Dela Gothic One", cursive, serif;
  }
  .inspirationstores .card .card-img-top {
    width: 100%;
    height: 10vw;
    min-height: 200px;
    object-fit: cover;
  }
  .inspirationstores .card .card-title {
    font-family: 'Rubik',sans-serif;
  }
  .inspirationstores .card .card-text {
    font-family: 'Inter',sans-serif;
    font-size: 14px;
    line-height: 23px;
  }

	/*
	* #learnmore
	* Learn more section
	*/
	#learnmore h1,
	#learnmore h2,
	#learnmore h3,
	#learnmore h4 {
		font-family: "Dela Gothic One", cursive, serif;
	}
	#learnmore .card .card-img-top {
		width: 100%;
		height: 10vw;
		min-height: 200px;
		object-fit: cover;
	}
	#learnmore .card .card-title {
		font-family: 'Rubik',sans-serif;
	}
	#learnmore .card .card-text {
		font-family: 'Inter',sans-serif;
		font-size: 14px;
		line-height: 23px;
	}

  #greeting-footer h6 {
    font-family: 'Rubik', 'Inter', 'Comic Sans', sans-serif;
    font-size: 20px;
    color: #1b4949;
  }
  #greeting-footer h6.light {
    font-family: 'Rubik', 'Inter', 'Comic Sans', sans-serif;
    font-size: 18px;
    text-transform: uppercase;
    color: #ffffff;
  }
  #greeting-footer ul {
    font-family: 'Inter', 'Comic Sans', sans-serif;
    font-weight: 300;
    font-size: 13px;
  }
  #greeting-footer ul.social {
    width: 150px;
    list-style: none;
    margin: -30px 0 0 -100px;
    padding: 0 5px 0 0;
  }
  #greeting-footer ul.social li {
    float: left;
    width: 45px;
    margin: 0;
    padding: 0;
  }

  #formal-footer {
    border-top: 3px solid #fecbca;
    font-family: 'Inter',sans-serif;
    font-size: 12px;
    color: #555555;
  }
  #formal-footer ul {
    list-style: none;
    margin: 0;
    padding: 0;
  }
  #formal-footer ul li {
    float: left;
    margin: 0;
    padding: 0 10px 0 0;
  }


	#top {
		border-top: 3px solid #fecbca;
	}
	#top div.right-col {
		font-family: 'Inter', sans-serif;
	}
	#top div.right-col .btn {
		font-size: 13px;
	}
	#top .top-search-btn {
		width: 40px;
		height: 35px;
		margin-top: 2px;
		z-index: 1000;
		background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23ffffff' class='bi bi-search' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/%3E%3C/svg%3E");
		background-repeat: no-repeat;
		background-position: center center;
	}
	#top .top-search-input {
		padding-left: 30px;
	}
	.btn-create {
		border: 1px solid #58a2a2;
	}

	#citycontent h1 {
		padding-bottom: 15px;
		position: relative;
	}
	#citycontent h1::before {
		position: absolute;
		background: linear-gradient(to right, #555555 75px, #ffffff 75px);
		height: 3px;
		content: '';
		bottom: 0;
		right: 0;
		left: 0;
	}
	#citycontent h1,
	#citycontent h2 {
		font-family: 'Rubik','Inter', sans-serif;
		font-weight: 600;
	}

	#citycontent #topoccassions .card .card-img-top {
		width: 100%;
		height: 10vw;
		object-fit: cover;
	}
	#citycontent #topoccassions .card h5.card-title {
		font-family: 'Inter',sans-serif;
		font-size: 14px;
	}

	.filter a[aria-expanded='true'] {
		background: #d6bf75;
	}
	.accordion-button:not(.collapsed)::after {
		background-image: url('data:image/svg+xml, %3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2216%22%20height%3D%2216%22%20fill%3D%22%23222222%22%20class%3D%22bi%20bi-chevron-down%22%20viewBox%3D%220%200%2016%2016%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M1.646%204.646a.5.5%200%200%201%20.708%200L8%2010.293l5.646-5.647a.5.5%200%200%201%20.708.708l-6%206a.5.5%200%200%201-.708%200l-6-6a.5.5%200%200%201%200-.708z%22%2F%3E%3C%2Fsvg%3E');
		transform: rotate(180deg);
	}

	.filter h5 {
		font-family: 'Rubik','Inter', serif;
		font-weight: 500;
		font-size: 12px;
	}
	.filter h6 {
		font-family: 'Inter','Rubik',serif;
		font-weight: 800;
		font-size: 13px;
	}
	.filter ul {
		font-family: 'Inter', sans-serif;
		font-size: 12px;
	}
	.filter span.price-filter-text {
		font-size: 11px;
	}
	.filter input[type="range"]::-webkit-slider-thumb {
		background: #446a6b;
		border: 1px solid #446a6b;
	}
	.filter input[type="range"]::-ms-thumb {
		background: #446a6b;
		border: 1px solid #446a6b;
	}
	.filter input[type="range"]::-moz-range-thumb {
		background: #446a6b;
		border: 1px solid #446a6b;
	}

	div.applied-filters {
		font-family: 'Inter', sans-serif;
		font-size: 15px;
		font-weight: 200;
	}

	div.store h6.card-title {
		font-family: 'Rubik','Inter', sans-serif;
		font-size: 14px;
		font-weight: 600;
	}
	div.store small {
		font-family: 'Inter', sans-serif;
		font-size: 10px;
		font-weight: 400;
	}
	div.store div.card p.price,
	div.store div.card bdi,
	div.store div.card div.price_hold {
		font-size: 13px;
	}
	.store {
		transition: all .15s ease-in-out;
	}
	.store:hover {
		transform: scale(1.015);
	}
	@media (max-width: 768px){
		.store a.cta {
			font-size: 0.725rem;
		}
	}

	/** Cart **/
	.woocommerce-remove-coupon {
		width: 100%;
		display: block;
		color: #000000;
	}

	/** loading begin */
	.overlay {
		display: none;
		position: fixed;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		z-index: 999;
		background: rgba(255,255,255,0.8) url("<?php echo get_stylesheet_directory_uri() . '/image/loading3.gif';?>") center no-repeat;
	}
	/* Turn off scrollbar when body element has the loading class */
	div.loading {
		overflow: hidden;
	}
	/* Make spinner image visible when body element has the loading class */
	div.loading .overlay {
		display: block;
	}
	/** loading end */

	/* Inserting this collapsed row between two flex items will make
 	* the flex item that comes after it break to a new row */
	.break {
	  flex-basis: 100%;
	  height: 0;
	}
	</style>

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
              new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
          'https://gtm.greeting.dk/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-N7VZGS3');</script>
  <!-- End Google Tag Manager -->

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://gtm.greeting.dk/ns.html?id=GTM-N7VZGS3"
                    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Rubik:wght@300;400;500;600;700;800;900&display=swap">
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
								'menu_class' => 'nav d-none d-lg-inline-flex m-0 order-0',
								'depth' => '1',
    						'fallback_cb'    => false, // Do not fall back to wp_page_menu(),
								'add_li_class' => 'nav-item',
								'add_a_class' => 'nav-link text-dark ps-0'
							)
						);
						?>
						<!-- TrustBox script -->
	          <script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
	          <!-- End TrustBox script -->
	          <!-- TrustBox widget - Micro Review Count -->
	          <div
	            class="nav d-none d-md-inline trustpilot-widget align-self-center order-1"
							style="text-align: left; overflow-x: visible;"
	            data-locale="da-DK"
	            data-template-id="5419b6a8b0d04a076446a9ad"
	            data-businessunit-id="60133f8342c1850001d9606a" data-style-height="24px" data-style-width="100%" data-theme="light" data-min-review-count="10">
	            <a href="https://dk.trustpilot.com/review/greeting.dk" target="_blank" rel="noopener">Trustpilot</a>
	          </div>
	          <!-- End TrustBox widget -->
            <ul class="nav d-flex d-md-inline-flex m-0 order-0 order-md-2">
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
				<div class="container d-flex justify-content-center">
					<div class="row">
						<div class="col-sm-12 d-md-none align-items-center justify-content-center">
							<div
		            class="nav trustpilot-widget"
								style="text-align: center; overflow-x: visible; width: 100%;"
		            data-locale="da-DK"
		            data-template-id="5419b6a8b0d04a076446a9ad"
		            data-businessunit-id="60133f8342c1850001d9606a" data-style-height="24px" data-style-width="100%" data-theme="light" data-min-review-count="10">
		            <a href="https://dk.trustpilot.com/review/greeting.dk" target="_blank" rel="noopener">Trustpilot</a>
		          </div>
						</div>
					</div>
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
