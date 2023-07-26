<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php wp_head(); ?>

	<link rel='stylesheet' id='style-css' href='https://www.greeting.dk/wp-content/themes/greeting2/style.css?ver=3.0.4' media='all' />
	<link rel='stylesheet' id='main-css' href='https://www.greeting.dk/wp-content/themes/greeting2/assets/css/main.css?ver=3.0.4' media='all' />

  <style type="text/css">
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
    color: #094444;
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

	#citycontent h1,
	#categorycontent h1,
	#occasioncontent h1 {
		padding-bottom: 15px;
		position: relative;
	}
	#citycontent h1::before,
	#categorycontent h1::before,
	#occasioncontent h1::before {
		position: absolute;
		background: linear-gradient(to right, #555555 75px, #ffffff 75px);
		height: 3px;
		content: '';
		bottom: 0;
		right: 0;
		left: 0;
	}
	#citycontent h1,
	#citycontent h2,
	#categorycontent h1,
	#categorycontent h2,
	#occasioncontent h1,
	#occasioncontent h2 {
		font-family: 'Rubik','Inter', sans-serif;
		font-weight: 600;
	}

	#citycontent #topoccassions .card .card-img-top,
	#categorycontent #topoccassions .card .card-img-top,
	#occasioncontent #topoccassions .card .card-img-top {
		width: 100%;
		height: 10vw;
		object-fit: cover;
	}
	#citycontent #topoccassions .card h5.card-title,
	#categorycontent #topoccassions .card h5.card-title,
	#occasioncontent #topoccassions .card h5.card-title {
		font-family: 'Inter',sans-serif;
		font-size: 14px;
	}

	#filterModal {
		z-index: 12500;
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
		font-size: 13px;
		overflow: visible;
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
	.modal-body .collapse-btn h5:before {
		content: "+";
		float: right;
		padding: 0 0 5px 0;
	}
	.modal-body .collapse-btn[aria-expanded="true"] h5:before {
		content: "-";
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

	div.store div.card  span.bagde {
		transition: none !important;
		transform: none !important;
		border-size: 1px !important;
	}
	.store {
		transition: all .15s ease-in-out;
	}
	.store:hover:not(div > span.badge) {
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

	@media (max-width: 575px) {
		.rounded.storebar {
			border-radius: 0px !important;
		}
	}

	/* Inserting this collapsed row between two flex items will make
 	* the flex item that comes after it break to a new row */
	.break {
	  flex-basis: 100%;
	  height: 0;
	}

	/*
	* The loader
	*/
	.greeting-loader {
	  border: 4px solid #f3f3f3; /* Light grey */
	  border-top: 4px solid #446a6b; /* Blue */
	  border-radius: 50%;
	  margin: 2px 7px 4px 0px;
	  width: 22px;
	  height: 22px;
	  animation: loaderspin 2s linear infinite;
  }
  @keyframes loaderspin {
	  0% { transform: rotate(0deg); }
	  100% { transform: rotate(360deg); }
  }

	@keyframes placeHolderShimmer{
	    0%{
	        background-position: -468px 0
	    }
	    100%{
	        background-position: 468px 0
	    }
	}
	.animated-background {
	    animation-duration: 1.25s;
	    animation-fill-mode: forwards;
	    animation-iteration-count: infinite;
	    animation-name: placeHolderShimmer;
	    animation-timing-function: linear;
	    background: #F6F6F6;
	    background: linear-gradient(to right, #F6F6F6 8%, #F0F0F0 18%, #F6F6F6 33%);
	    background-size: 800px 104px;
	    height: 96px;
	    position: relative;
	}

	.loadingcard .image.animated-background {
	  height: 150px;
	  width: 100%;
	  margin: 0px;
	  @extend .animated-background;
	}
	.loadingcard .image-large.animated-background {
	  height: 200px;
	  width: 100%;
	  margin: 0px;
	  @extend .animated-background;
	}
	.loadingcard .text.animated-background {
	  margin-left: 20px
	}
	.loadingcard .text-line-heading.animated-background {
	  height: 22px;
	  width: 50%;
	  margin: 5px 0;
	  @ .animated-background;
	}
	.loadingcard .text-line-30.animated-background {
	  height: 12px;
	  width: 30%;
	  margin: 5px 0;
	  @ .animated-background;
	}
	.loadingcard .text-line-60.animated-background {
	  height: 12px;
	  width: 60%;
	  margin: 5px 0;
	  @ .animated-background;
	}
	.loadingcard .text-line-100.animated-background {
	  height: 32px;
	  width: 100%;
	  margin: 5px 0;
	  @ .animated-background;
	}
	.loadingcard .loading-cta.animated-background {
	  height: 25px;
	  width: 20%;
	  margin: 10px 0;
	  @.animated-background;
	}
	</style>

	<!-- LOCAL TM -->
	<script async>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://gtm.greeting.dk/bocfvmll.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-N7VZGS3');</script>
	<!-- End LOCAL TM -->
	<!-- LOCAL TM (noscript) -->
	<noscript><iframe src="https://gtm.greeting.dk/ns.html?id=GTM-N7VZGS3"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End LOCAL TM (noscript) -->
	<meta name="google-site-verification" content="IzMcch4GbZsuyDXUn9Ar4A0kpVHugadljONNzrSZh3I" />
  <!--<link rel="preload" href="https://fonts.googleapis.com">
  <link rel="preload" href="https://fonts.gstatic.com" crossorigin>
	<link rel="preload" as="style" rel="preload" onload="this.onload=null;this.rel='stylesheet'" href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Rubik:wght@300;400;500;600;700;800;900&display=swap">
	<noscript>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Rubik:wght@300;400;500;600;700;800;900&display=swap">
	</noscript>-->
</head>

<?php
	$navbar_scheme   = get_theme_mod( 'navbar_scheme', 'navbar-light bg-light' ); // Get custom meta-value.
	$navbar_position = get_theme_mod( 'navbar_position', 'static' ); // Get custom meta-value.

	$search_enabled  = get_theme_mod( 'search_enabled', '1' ); // Get custom meta-value.
?>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div id="wrapper">
	<header class="p-0 m-0">
	  <style>
		.topbar {
			position: relative;
			overflow: hidden;
			height: 33px; /* Adjust the height as needed */
		}

		.topbar ul {
			list-style: none;
			margin: 0;
			padding: 0;
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			animation: scroll 15s linear infinite;
		}

		.topbar ul li {
		  display: flex;
		  align-items: center;
		  justify-content: center;
		  line-height: 33px;
		  text-align: center;
		}

		@keyframes scroll {
			0% {
				transform: translateY(0);
			}
			20% {
				transform: translateY(0);
			}
			25% {
				transform: translateY(-22%);
			}
			45% {
				transform: translateY(-22%);
			}
			50% {
				transform: translateY(-47%);
			}
			70% {
				transform: translateY(-47%);
			}
			75% {
				transform: translateY(-75%);
			}
			95% {
				transform: translateY(-75%);
			}
			100% {
				transform: translateY(-100%);
			}
		}
	  </style>

		<div class="bg-pink small text-uppercase">
			<!-- TrustBox script -->
			<script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" defer async></script>
			<!-- End TrustBox script -->
	    <div class="topbar d-block d-lg-none d-xl-none">
				<ul>
		      <li><?php echo trim(get_field('header_usp1', 'options')); ?></li>
		      <li>
						<div
						class="nav trustpilot-widget"
						style="text-align: center; overflow-x: visible; width: 100%;"
						data-locale="da-DK"
						data-template-id="5419b6a8b0d04a076446a9ad"
						data-businessunit-id="60133f8342c1850001d9606a" data-style-height="24px" data-style-width="100%" data-theme="light" data-min-review-count="10">
						<a href="https://dk.trustpilot.com/review/greeting.dk" target="_blank" rel="noopener">Trustpilot</a>
						</div>
					</li>
		      <li><?php echo trim(get_field('header_usp3', 'options')); ?></li>
		      <li><?php echo trim(get_field('header_usp4', 'options')); ?></li>
		    </ul>
	    </div>
	    <div class="container-xxl d-none d-lg-block d-xl-block text-center">
				<div class="row">
					<div class="col-4 py-2"><?php echo trim(get_field('header_usp1', 'options')); ?></div>
		      <div class="col-3 py-2">
						<div
						class="nav trustpilot-widget"
						style="text-align: center; overflow-x: visible; width: 100%;"
						data-locale="da-DK"
						data-template-id="5419b6a8b0d04a076446a9ad"
						data-businessunit-id="60133f8342c1850001d9606a" data-style-height="24px" data-style-width="100%" data-theme="light" data-min-review-count="10">
						<a href="https://dk.trustpilot.com/review/greeting.dk" target="_blank" rel="noopener">Trustpilot</a>
						</div>
					</div>
		      <div class="col-3 py-2"><?php echo trim(get_field('header_usp3', 'options')); ?></div>
		      <div class="col-2 py-2"><?php echo trim(get_field('header_usp4', 'options')); ?></div>
				</div>
	    </div>
	  </div>
	</header>

	<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenu">
	  <div class="offcanvas-header">
			<div>
				<svg viewBox="0 0 524 113" width="120" fill="#446a6b"  xmlns="http://www.w3.org/2000/svg">
					<path d="m77.206 77.399c-1.3564 0.9013-3.0143 2.0655-4.9737 3.4925-1.884 1.352-4.1824 2.6664-6.8954 3.9432-2.6376 1.2017-5.7273 2.2532-9.2692 3.1545s-7.5736 1.352-12.095 1.352c-6.707 0-12.773-1.0891-18.199-3.2672-5.4259-2.2533-10.06-5.2951-13.904-9.1256-3.768-3.9057-6.707-8.4497-8.817-13.632-2.0347-5.2576-3.0521-10.891-3.0521-16.899 0-6.0086 1.055-11.604 3.1651-16.787 2.1101-5.2576 5.1244-9.8016 9.0431-13.632 3.9941-3.9056 8.8171-6.9475 14.469-9.1256 5.652-2.2532 12.058-3.3799 19.217-3.3799 3.2404 0 6.2548 0.18777 9.0431 0.56331 2.8637 0.37554 5.5013 0.86375 7.9128 1.4646 2.4868 0.52575 4.7099 1.0891 6.6693 1.6899 1.9593 0.60086 3.7303 1.1642 5.3128 1.6899l2.2608 18.364-1.0174 0.338c-2.7129-3.9056-5.3128-7.2104-7.7997-9.9143-2.4115-2.779-4.8606-5.0322-7.3475-6.7597-2.4115-1.8026-4.936-3.117-7.5736-3.9432-2.6376-0.82619-5.4636-1.2393-8.478-1.2393-5.1998 0-9.7213 1.0515-13.565 3.1545-3.8433 2.103-7.0084 4.9947-9.4952 8.675-2.4869 3.6803-4.3709 7.999-5.652 12.956-1.2058 4.9571-1.8086 10.29-1.8086 15.998s0.5652 11.041 1.6956 15.998c1.1303 4.882 2.8636 9.1632 5.1998 12.844 2.4115 3.6052 5.4635 6.4593 9.1561 8.5623 3.768 2.103 8.2896 3.1545 13.565 3.1545 6.1795 0 11.191-1.5021 15.034-4.5064 3.8434-3.0044 5.765-7.4733 5.765-13.407 0-2.0279-0.0753-3.8305-0.2261-5.4078-0.1507-1.5773-0.4521-3.0794-0.9043-4.5065-0.3768-1.427-0.9043-2.8165-1.5825-4.1685-0.6782-1.427-1.5072-2.9667-2.4869-4.6191v-0.2253h22.156v0.2253c-0.9043 1.7275-1.6579 3.3423-2.2608 4.8445-0.6029 1.427-1.0927 2.8916-1.4695 4.3938-0.3014 1.5021-0.5275 3.117-0.6782 4.8444-0.0754 1.7275-0.1131 3.7554-0.1131 6.0838v6.7597z"/>
					<path d="m88.067 87.651v-0.2253c0.5275-1.5772 0.942-3.117 1.2434-4.6191 0.3768-1.5022 0.6406-3.0794 0.7913-4.7318 0.2261-1.7275 0.3768-3.5677 0.4522-5.5205 0.0753-2.0279 0.113-4.2811 0.113-6.7597v-13.294c0-3.7554-0.5275-6.7597-1.5825-9.013-0.9797-2.2532-2.1478-4.1309-3.5043-5.6331v-0.2253l15.939-5.9711v13.745h0.452c1.13-1.352 2.336-2.779 3.617-4.2812 1.357-1.5772 2.789-3.0043 4.296-4.2811 1.507-1.352 3.089-2.441 4.747-3.2672 1.734-0.9013 3.505-1.352 5.313-1.352l-0.226 13.745h-0.452c-0.528-0.4506-1.243-0.8637-2.148-1.2393-0.904-0.3755-1.846-0.7135-2.826-1.0139-0.904-0.3756-1.846-0.6385-2.826-0.7887-0.904-0.2253-1.658-0.338-2.26-0.338-0.905 0-2.035 0.4131-3.392 1.2393-1.281 0.8262-2.562 2.103-3.843 3.8305v18.026c0 4.882 0.113 8.9754 0.339 12.28 0.302 3.2297 1.017 6.3842 2.148 9.4636v0.2253h-16.391z"/>
					<path d="m169.29 72.667c-0.754 2.3283-1.809 4.5065-3.165 6.5344-1.281 2.0279-2.864 3.793-4.748 5.2951-1.884 1.5022-4.032 2.6663-6.443 3.4925-2.412 0.9013-5.087 1.352-8.026 1.352-3.768 0-7.234-0.676-10.399-2.0279-3.09-1.4271-5.765-3.3799-8.026-5.8585-2.186-2.4785-3.919-5.4077-5.2-8.7876-1.206-3.3799-1.809-7.0226-1.809-10.928 0-4.5065 0.754-8.5623 2.261-12.168 1.583-3.6803 3.617-6.7973 6.104-9.351 2.487-2.5536 5.275-4.5064 8.365-5.8584 3.165-1.427 6.293-2.1406 9.382-2.1406 3.316 0 6.331 0.676 9.044 2.028 2.712 1.3519 5.011 3.1169 6.895 5.2951 1.959 2.103 3.429 4.4689 4.408 7.0977 0.98 2.5536 1.395 5.0698 1.244 7.5483h-36.286v2.1406c0 7.9615 1.809 13.857 5.426 17.688 3.617 3.8306 8.403 5.7458 14.356 5.7458 3.467 0 6.481-0.6384 9.043-1.9153 2.638-1.3519 4.936-3.2296 6.896-5.633l0.678 0.4506zm-22.156-38.418c-2.185 0-4.107 0.4882-5.765 1.4646-1.582 0.9013-2.976 2.1781-4.182 3.8305-1.131 1.5772-2.035 3.4925-2.713 5.7457-0.678 2.1782-1.131 4.5441-1.357 7.0977l24.53-0.5633v-1.2393c0-5.6331-0.867-9.764-2.6-12.393s-4.371-3.9431-7.913-3.9431z"/>
					<path d="m219.88 72.667c-0.753 2.3283-1.808 4.5065-3.165 6.5344-1.281 2.0279-2.863 3.793-4.747 5.2951-1.884 1.5022-4.032 2.6663-6.444 3.4925-2.411 0.9013-5.086 1.352-8.025 1.352-3.768 0-7.235-0.676-10.4-2.0279-3.09-1.4271-5.765-3.3799-8.026-5.8585-2.185-2.4785-3.918-5.4077-5.2-8.7876-1.205-3.3799-1.808-7.0226-1.808-10.928 0-4.5065 0.753-8.5623 2.261-12.168 1.582-3.6803 3.617-6.7973 6.104-9.351 2.487-2.5536 5.275-4.5064 8.365-5.8584 3.165-1.427 6.292-2.1406 9.382-2.1406 3.316 0 6.33 0.676 9.043 2.028 2.713 1.3519 5.011 3.1169 6.895 5.2951 1.96 2.103 3.429 4.4689 4.409 7.0977 0.98 2.5536 1.394 5.0698 1.243 7.5483h-36.285v2.1406c0 7.9615 1.808 13.857 5.426 17.688 3.617 3.8306 8.402 5.7458 14.356 5.7458 3.466 0 6.48-0.6384 9.043-1.9153 2.637-1.3519 4.936-3.2296 6.895-5.633l0.678 0.4506zm-22.155-38.418c-2.186 0-4.107 0.4882-5.765 1.4646-1.583 0.9013-2.977 2.1781-4.183 3.8305-1.13 1.5772-2.034 3.4925-2.713 5.7457-0.678 2.1782-1.13 4.5441-1.356 7.0977l24.529-0.5633v-1.2393c0-5.6331-0.866-9.764-2.6-12.393-1.733-2.6288-4.37-3.9431-7.912-3.9431z"/>
					<path d="m240.63 89.341c-1.657 0-3.278-0.2253-4.86-0.676-1.507-0.3755-2.864-1.0891-4.07-2.1406-1.13-1.0515-2.034-2.441-2.713-4.1685-0.678-1.8026-1.017-4.0182-1.017-6.647v-39.77h-6.104v-0.676l16.391-14.083h1.13v12.731h14.582v2.0279h-14.582v39.432c0 5.558 2.638 8.337 7.913 8.337 1.959 0 3.617-0.2629 4.973-0.7887 1.357-0.6008 2.186-0.9764 2.487-1.1266l0.339 0.4507c-1.582 2.1781-3.617 3.9056-6.104 5.1824-2.411 1.2769-5.199 1.9153-8.365 1.9153z"/>
					<path d="m273.54 13.519c0 1.8777-0.678 3.4926-2.034 4.8445-1.282 1.2768-2.864 1.9153-4.748 1.9153s-3.504-0.6385-4.861-1.9153c-1.281-1.3519-1.921-2.9668-1.921-4.8445s0.64-3.4925 1.921-4.8444c1.357-1.352 2.977-2.0279 4.861-2.0279s3.466 0.67597 4.748 2.0279c1.356 1.3519 2.034 2.9667 2.034 4.8444zm-14.469 73.906c0.754-3.0794 1.357-6.2339 1.809-9.4636 0.527-3.2296 0.791-7.2855 0.791-12.168v-12.844c0-3.6051-0.527-6.5344-1.582-8.7876-0.98-2.3283-2.148-4.2436-3.505-5.7458v-0.7886l16.391-5.9711v34.024 6.647c0.075 1.9528 0.188 3.793 0.339 5.5204 0.226 1.7275 0.49 3.3799 0.791 4.9572 0.302 1.5021 0.754 3.0419 1.357 4.6191v0.2253h-16.391v-0.2253z"/>
					<path d="m298.9 87.651h-16.39v-0.2253c0.527-1.5772 0.942-3.117 1.243-4.6191 0.377-1.5022 0.641-3.0794 0.791-4.7318 0.227-1.7275 0.377-3.5677 0.453-5.5205 0.075-2.0279 0.113-4.2811 0.113-6.7597v-13.294c0-3.7554-0.528-6.7597-1.583-9.013-0.98-2.2532-2.148-4.1309-3.504-5.6331v-0.2253l15.938-5.9711v10.816l0.453 0.1126c2.411-2.9292 5.049-5.3702 7.912-7.323 2.864-2.0279 6.293-3.0419 10.287-3.0419 5.2 0 9.156 1.4646 11.869 4.3939 2.713 2.9292 4.069 6.9099 4.069 11.942v17.125 6.8723c0.076 1.9528 0.189 3.793 0.34 5.5205 0.226 1.6524 0.489 3.2296 0.791 4.7318 0.377 1.5021 0.866 3.0419 1.469 4.6191v0.2253h-16.39v-0.2253c0.979-3.0794 1.62-6.2715 1.921-9.5763 0.377-3.3047 0.565-7.323 0.565-12.055v-14.646c0-1.5773-0.188-3.0795-0.565-4.5065-0.377-1.5022-0.979-2.8166-1.808-3.9432s-1.922-1.9904-3.278-2.5912c-1.282-0.676-2.864-1.014-4.748-1.014-2.412 0-4.672 0.5258-6.782 1.5773-2.111 0.9764-3.995 2.3283-5.652 4.0558v20.955c0 4.882 0.113 8.9754 0.339 12.28 0.301 3.2297 1.017 6.3842 2.147 9.4636v0.2253z"/>
					<path d="m360.52 68.611c1.809 0 3.354-0.4131 4.635-1.2393 1.356-0.9013 2.412-2.103 3.165-3.6052 0.829-1.5773 1.432-3.3799 1.809-5.4078 0.377-2.103 0.565-4.3938 0.565-6.8724 0-2.4785-0.188-4.7693-0.565-6.8723-0.377-2.1031-0.98-3.9057-1.809-5.4078-0.753-1.5773-1.809-2.779-3.165-3.6052-1.281-0.9013-2.864-1.3519-4.748-1.3519s-3.466 0.4506-4.747 1.3519c-1.281 0.8262-2.336 2.0279-3.165 3.6052-0.754 1.5021-1.319 3.3047-1.696 5.4078-0.301 2.103-0.452 4.3938-0.452 6.8723 0 2.4786 0.188 4.7694 0.565 6.8724 0.377 2.0279 0.942 3.8305 1.696 5.4078 0.829 1.5022 1.884 2.7039 3.165 3.6052 1.356 0.8262 2.939 1.2393 4.747 1.2393zm28.938 26.476c-0.075 2.4035-0.791 4.6943-2.147 6.8723-1.281 2.178-3.165 4.056-5.652 5.633-2.487 1.653-5.615 2.967-9.383 3.943-3.692 0.977-7.95 1.465-12.773 1.465-3.542 0-6.858-0.3-9.947-0.901-3.015-0.526-5.615-1.352-7.8-2.479-2.186-1.126-3.919-2.478-5.2-4.056-1.206-1.577-1.809-3.38-1.809-5.407 0-1.4275 0.302-2.7419 0.905-3.9436 0.603-1.1267 1.394-2.1406 2.374-3.0419 1.055-0.8262 2.223-1.5397 3.504-2.1406 1.281-0.5257 2.6-0.9764 3.956-1.3519-1.959-0.7511-3.542-1.8026-4.747-3.1546-1.131-1.427-1.696-3.3047-1.696-5.6331 0-1.7275 0.339-3.2672 1.017-4.6191 0.679-1.352 1.545-2.5161 2.6-3.4925 1.131-1.0516 2.412-1.9153 3.844-2.5913 1.431-0.6759 2.901-1.2017 4.408-1.5772-3.542-1.5773-6.405-3.8681-8.591-6.8724-2.185-3.0043-3.278-6.4218-3.278-10.252 0-2.7038 0.565-5.22 1.696-7.5483 1.13-2.4035 2.637-4.4689 4.521-6.1964 1.959-1.7275 4.22-3.0795 6.782-4.0559 2.638-0.9764 5.426-1.4646 8.365-1.4646s5.69 0.5258 8.252 1.5773c2.638 0.9764 4.936 2.3284 6.896 4.0558l14.356-8.337 0.226 0.1127v10.027h-0.452l-12.548-0.2253c1.507 1.6524 2.675 3.4925 3.504 5.5204 0.905 2.028 1.357 4.2061 1.357 6.5344 0 2.6288-0.565 5.1074-1.696 7.4357-1.13 2.3284-2.675 4.3563-4.634 6.0838-1.884 1.7275-4.145 3.117-6.783 4.1685-2.637 0.9764-5.426 1.4646-8.365 1.4646-1.507 0-2.939-0.1127-4.295-0.338-1.281-0.3004-2.562-0.676-3.843-1.1266-1.884 0.9013-3.203 1.9152-3.957 3.0419-0.678 1.0515-1.017 2.103-1.017 3.1545 0 2.103 1.017 3.5301 3.052 4.2811 2.035 0.676 4.785 1.0891 8.252 1.2393l11.304 0.338c2.562 0.0751 5.049 0.4131 7.46 1.014 2.412 0.6008 4.522 1.4646 6.33 2.5912 1.809 1.1266 3.203 2.5161 4.183 4.1685 1.055 1.7275 1.545 3.7554 1.469 6.0837zm-25.32 13.97c6.33 0 11.04-0.901 14.13-2.704 3.165-1.803 4.747-4.093 4.747-6.8724 0-1.352-0.377-2.5162-1.13-3.4926-0.678-0.9013-1.658-1.6523-2.939-2.2532-1.206-0.5258-2.675-0.9389-4.409-1.2393-1.658-0.2253-3.429-0.3755-5.313-0.4506l-12.208-0.4507c-1.733-0.0751-3.429-0.2253-5.087-0.4506-1.658-0.1503-3.24-0.4507-4.747-0.9013-0.754 0.6759-1.432 1.5772-2.035 2.7039-0.527 1.1266-0.791 2.5161-0.791 4.1685 0 3.8303 1.695 6.7593 5.087 8.7873 3.391 2.103 8.289 3.155 14.695 3.155z"/>
					<path d="m399.12 88.214c-2.11 0-3.918-0.7511-5.425-2.2533-1.432-1.5021-2.148-3.2672-2.148-5.2951 0-2.1781 0.716-3.9807 2.148-5.4078 1.507-1.5021 3.315-2.2532 5.425-2.2532 2.035 0 3.806 0.7511 5.313 2.2532 1.507 1.4271 2.261 3.2297 2.261 5.4078 0 2.0279-0.754 3.793-2.261 5.2951-1.507 1.5022-3.278 2.2533-5.313 2.2533z"/>
					<path d="m438.95 81.793c2.939 0 5.501-0.5633 7.687-1.6899 2.261-1.1266 4.145-2.5912 5.652-4.3938v-28.954c-0.528-2.4034-1.244-4.3938-2.148-5.9711-0.904-1.6523-1.959-2.9292-3.165-3.8305-1.13-0.9764-2.374-1.6523-3.73-2.0279-1.281-0.4506-2.562-0.6759-3.844-0.6759-2.486 0-4.747 0.6384-6.782 1.9152-1.959 1.2017-3.655 2.9292-5.087 5.1825-1.356 2.1781-2.411 4.8069-3.165 7.8863-0.753 3.0794-1.13 6.4593-1.13 10.14 0 6.7597 1.281 12.205 3.843 16.336 2.638 4.0558 6.594 6.0837 11.869 6.0837zm13.452-3.8305c-0.829 1.5022-1.884 2.9292-3.165 4.2812-1.206 1.3519-2.638 2.5536-4.296 3.6052-1.582 1.0515-3.391 1.8777-5.426 2.4785-1.959 0.676-4.107 1.014-6.443 1.014-3.316 0-6.33-0.6384-9.043-1.9153-2.637-1.3519-4.898-3.1921-6.782-5.5204-1.884-2.3284-3.354-5.0698-4.409-8.2243-0.979-3.2297-1.469-6.7222-1.469-10.478 0-4.0558 0.603-7.9615 1.808-11.717 1.281-3.7554 3.165-7.0601 5.652-9.9142s5.577-5.1074 9.269-6.7597c3.693-1.7275 7.951-2.5913 12.774-2.5913 2.185 0 4.22 0.1878 6.104 0.5633 1.959 0.3756 3.73 0.8638 5.313 1.4647v-13.407c0-3.7554-0.528-6.7597-1.583-9.013-0.979-2.2532-2.147-4.1309-3.504-5.6331v-0.22532l16.391-5.9711v63.654c0 3.8305 0.075 6.9475 0.226 9.351 0.226 2.4034 0.527 4.3938 0.904 5.9711 0.452 1.5021 0.98 2.7039 1.583 3.6052 0.678 0.9013 1.507 1.765 2.487 2.5912v0.2253l-16.052 3.6052v-11.041h-0.339z"/>
					<path d="m474.15 87.426c0.753-1.5772 1.356-3.4925 1.808-5.7457 0.452-2.2533 0.679-5.4829 0.679-9.689v-51.261c0-3.6803-0.528-6.647-1.583-8.9003-0.98-2.2532-2.148-4.1309-3.504-5.6331v-0.22532l16.39-5.9711v71.878c0 4.206 0.227 7.4732 0.679 9.8016 0.527 2.3283 1.205 4.2436 2.034 5.7457v0.2253h-16.503v-0.2253zm34.138 0.2253-19.443-27.94 12.999-14.083c1.809-1.9528 3.015-3.9807 3.618-6.0837 0.602-2.1782 0.452-3.9808-0.453-5.4078v-0.2253h14.695v0.2253c-3.391 1.5022-6.367 3.4174-8.93 5.7458-2.562 2.2532-5.011 4.6191-7.347 7.0977l-5.878 6.4217 16.617 23.884c1.733 2.4035 3.315 4.4314 4.747 6.0838s3.128 3.0043 5.087 4.0558v0.2253h-15.712z"/>
				</svg>
			</div>
	    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	  </div>
	  <div class="offcanvas-body">
	    <div class="">
				<b>Menu</b>
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
			<div class="row">
				<div class="col-6 pt-3">
					<div class="d-flex border border-1 rounded-3 justify-content-center text-center">
						<a class="nav-link text-dark p-3" href="mailto:<?php echo get_field('greeting_contact_mail_address', 'option'); ?>">
							<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-envelope-heart" viewBox="0 0 16 16">
								<path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l3.235 1.94a2.76 2.76 0 0 0-.233 1.027L1 5.384v5.721l3.453-2.124c.146.277.329.556.55.835l-3.97 2.443A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741l-3.968-2.442c.22-.28.403-.56.55-.836L15 11.105V5.383l-3.002 1.801a2.76 2.76 0 0 0-.233-1.026L15 4.217V4a1 1 0 0 0-1-1H2Zm6 2.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z"/>
							</svg>
							<br>
							<?php echo get_field('greeting_contact_mail_address', 'option'); ?>
						</a>
					</div>
				</div>
				<div class="col-6 pt-3">
					<div class="d-flex border border-1 rounded-3 justify-content-center text-center">
						<a class="nav-link text-dark p-3" href="tel:+45<?php echo get_field('greeting_contact_phone_number', 'option'); ?>">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
								<path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
							</svg>
							<br>
							<?php echo trim(strrev(chunk_split(strrev( get_field('greeting_contact_phone_number', 'option') ),2, ' '))); ?>
						</a>
					</div>
				</div>
			</div>
	  </div>
	</div>
