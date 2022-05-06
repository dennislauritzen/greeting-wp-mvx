<?php

global $wpdb;

$ip_detail_ipinfo = call_ip_apis(get_client_ip());

if(!empty($ip_detail_ipinfo) AND (isset($ip_detail_ipinfo->postal) || isset($ip_detail_ipinfo->zip))){
  #print $ip_details->postal;
  $user_postal = (!empty($ip_detail_ipinfo->postal) ? $ip_detail_ipinfo->postal : $ip_detail_ipinfo->zip);
} else {
  $user_postal = '';
}


$user_areas = array(
  'start' => 1000,
  'end' => 9999
);
if(!empty($user_postal)){
  if($user_postal >= 1000 && $user_postal < 3000){
    $user_areas['start'] = 1000;
    $user_areas['end'] = 3000;
  } else if($user_postal >= 3000 && $user_postal < 3700){
    $user_areas['start'] = 3000;
    $user_areas['end'] = 3700;
  } else if($user_postal >= 3700 && $user_postal < 4000){
    $user_areas['start'] = 3700;
    $user_areas['end'] = 4000;
  } else if($user_postal >= 4000 && $user_postal < 4800){
    $user_areas['start'] = 4000;
    $user_areas['end'] = 4800;
  } else if($user_postal >= 4800 && $user_postal < 5000){
    $user_areas['start'] = 4800;
    $user_areas['end'] = 5000;
  } else if($user_postal >= 5000 && $user_postal < 6000){
    $user_areas['start'] = 5000;
    $user_areas['end'] = 6000;
  } else if($user_postal >= 6000 && $user_postal < 6700){
    $user_areas['start'] = 6000;
    $user_areas['end'] = 6700;
  } else if($user_postal >= 6700 && $user_postal < 7000){
    $user_areas['start'] = 6700;
    $user_areas['end'] = 7000;
  } else if($user_postal >= 7000 && $user_postal < 7500){
    $user_areas['start'] = 7000;
    $user_areas['end'] = 7500;
  } else if($user_postal >= 7500 && $user_postal < 8000){
    $user_areas['start'] = 7500;
    $user_areas['end'] = 8000;
  } else if($user_postal >= 8000 && $user_postal < 9000){
    $user_areas['start'] = 8000;
    $user_areas['end'] = 9000;
  } else if($user_postal >= 9000 && $user_postal < 10000){
    $user_areas['start'] = 9000;
    $user_areas['end'] = 9999;
  }
}

// =========================
// =========================

// Start the template
get_header();
?>

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
    width: 100px;
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

</style>

<section id="maintop" class=" position-relative">
    <div class="row g-0">
      <div class="col-12 d-flex  align-items-bottom align-items-md-center align-items-lg-center align-items-xl-center video-wrapper">
        <video class="position-absolute top-0 start-0" playsinline autoplay muted loop poster="">
          <source src="https://dev.greeting.dk/wp-content/uploads/2022/04/greeting_top_q23.mp4" type="video/mp4">
          <source src="https://dev.greeting.dk/wp-content/uploads/2022/04/Greeting_webm_q33.webm" type="video/webm">
        </video>
        <div class="col-12 col-md-10 col-lg-7 col-xl-6 bg-teal-75 position-relative start-0 top-0">
            <div class="py-5 px-1 px-xs-1 px-sm-1 px-md-2 px-lg-5 px-xl-5 m-5 top-text-content">
                <div class="pb-4">
                    <svg viewBox="0 0 524 113" width="150" fill="#ffffff"  xmlns="http://www.w3.org/2000/svg">
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
                <h4 class="text-teal fs-6">#STØTLOKALT</h4>
                <h1 class="text-white pb-3">Skal vi levere <span id="spinner"></span> <br>til én du holder af?</h1>
                <form role="search" method="get" autocomplete="off" id="searchform">
                <div class="input-group pb-4 w-100 me-0 me-xs-0 me-sm-0 me-md-0 me-lg-5 me-xl-5">
                  <input type="text" name="keyword" id="front_Search-new_ucsa" class="form-control border-0 ps-5 pe-3 py-3 shadow-sm rounded" placeholder="Indtast by eller postnr. (eks. <?php echo (!empty($user_postal) ? $user_postal : '8000'); ?>)">
                  <figure class="position-absolute mt-2 mb-3 ps-3" style="padding-top:5px; z-index:1000;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#333333" class="bi bi-geo-alt" viewBox="0 0 16 16">
                      <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                      <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    </svg>
                  </figure>
                  <button type="submit" class="btn bg-yellow text-white ms-3 px-4 rounded">Søg</button>
                  <ul id="datafetch_wrapper" class="d-none list-group position-relative recommandations position-absolute list-unstyled rounded w-75 bg-white" style="top: 57px; ">
                  </ul>
                  </div>
                </form>
                <ul class="list-inline my-2">
                  <?php
                  if(!empty($user_postal)){
                    $postal_args2 = array(
                      'post_type' => 'city',
                      'posts_per_page' => '1',
                      'meta_query' => array(
                        array(
                          'key' => 'postalcode',
                          'value' => $user_postal,
                          'compare' => '='
                        )
                      ),
                      'no_found_rows' => true
                    );
                    $postal_query2 = new WP_Query($postal_args2);
                    foreach($postal_query2->posts as $k => $post){
                  ?>
                  <li class="list-inline-item pb-1">
                    <a href="<?php echo get_permalink($post->ID);?>" class="btn btn-link rounded-pill pb-2 border-1 border-white text-white">
                      <?php echo get_post_meta($post->ID, 'postalcode', true)." ".get_post_meta($post->ID, 'city', true);?>
                    </a>
                  </li>
                  <?php
                    }
                  }
                  ?>
                  <?php
                  $postal_args = array(
                    'post_type' => 'city',
                    'posts_per_page' => '7',
                    'orderby' => 'meta_value',
                    'meta_key' => 'is_featured_city',
                    'order' => 'DESC',
                    'meta_query' => array(
                      'relation' => 'AND',
                      array(
                        'key' => 'postalcode',
                        'value' => array($user_areas['start'], $user_areas['end']),
                        'compare' => 'BETWEEN',
                        'type' => 'numeric'
                      ),
                      array(
                        'key' => 'postalcode',
                        'value' => (!empty($user_postal) ? $user_postal : (int) '0999'),
                        'compare' => '!=',
                        'type' => 'numeric'
                      )
                    ),
                    'no_found_rows' => true
                  );
                  $postal_query = new WP_Query($postal_args);
                  foreach($postal_query->posts as $k => $post){
                    $postal_query->the_post();?>
                    <li class="list-inline-item pb-1">
                      <a href="<?php echo get_permalink($post->ID);?>" class="btn btn-link rounded-pill pb-2 border-1 border-white text-white">
                        <?php echo get_post_meta($post->ID, 'postalcode', true)." ".get_post_meta($post->ID, 'city', true);?>
                      </a>
                    </li>
                  <?php
                  } // endwhile
                  ?>
                </ul>
            </div>
        </div>
      </div>
    </div>
</section>

<?php
if(!empty($user_postal)){
  $args = array(
    'role' => 'dc_vendor',
    'orderby' => 'meta_value',
    'meta_key' => 'delivery_zips',
    'order' => 'DESC',
    'number' => 4,
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key' => 'delivery_zips',
        'value' => $user_postal,
        'compare' => 'LIKE'
      ),
      array(
        'key' => 'delivery_type',
        'value' => array(0,1),
        'type' => 'numeric',
        'compare' => 'IN'
      )
    )
  );
  $query = new WP_User_Query($args);
  $results = $query->get_results();
}


if(!empty($results)){
?>
<section id="inspiration" class="inspirationstores">
  <div class="container">
    <div class="row my-4 py-5">
      <div clsas="col-12">
        <h4 class="h1 pb-5 mb-3 text-center">📍 Bliv inspireret i lækre butikker nær dig</h4>
      </div>
      <?php
      global $WCMp;
      foreach($results as $k => $v){
        $vendor = get_user_meta($v->ID);
        $vendor_page_slug = get_wcmp_vendor($v->ID);

        $image = (!empty($vendor['_vendor_profile_image'])? $vendor['_vendor_profile_image'][0] : '');
        $banner = (!empty($vendor['_vendor_banner'])? $vendor['_vendor_banner'][0] : '');

        $vendor_banner = (!empty(wp_get_attachment_image_src($banner)) ? wp_get_attachment_image_src($banner, 'medium')[0] : '');
        $vendor_picture = (!empty(wp_get_attachment_image_src($image)) ? wp_get_attachment_image_src($image, 'medium')[0] : '');
        #$vendor_url = get_permalink();
        #$vendor_desc = get_user_meta();

        $description2 = (!empty($vendor['_vendor_description'][0]) ? $vendor['_vendor_description'][0] : '');

        if(strlen(wp_strip_all_tags($description2)) >= '98'){
          $description = substr(wp_strip_all_tags($description2), 0, 95).'...';
        } else {
          $description = $description2;
        }

      ?>
      <div class="col-12 pb-3 pb-lg-0 pb-xl-0 col-sm-6 col-lg-3">
        <div class="card" style="">
          <img src="<?php echo $vendor_banner; ?>" class="card-img-top" alt="<?php echo $vendor['nickname']['0']; ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo $vendor['nickname']['0']; ?></h5>
            <p class="card-text"><?php echo $description; ?></p>
            <a href="<?php echo $vendor_page_slug->get_permalink(); ?>" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">Se butikkens udvalg</a>
          </div>
        </div>
      </div>
      <?php
      } // endforeach
      ?>
    </div>
  </div>
</section>
<?php } ?>

<section id="howitworks" class="bg-light-grey py-5">
  <div class="container text-center py-5 my-4">
    <div class="row">
      <div class="col-12">
        <h2 class="pt-2 pb-4">🎁 Sådan fungerer det</h2>
        <p class="text-md py-4 lh-base">
          Indtast din modtagers adresse og se udvalg af gaver. Vælg en gave.<br>
          Butikken pakker gaven flot ind, håndskriver en hilsen fra dig og sørger for, at din gave leveres til modtageren.
        </p>
      </div>
      <div class="col-lg-12">
        <ul class="timeline list-style-none py-4">
          <li class="">
            <figure class="search-place-icon">
              <svg width="33" height="44" viewBox="0 0 33 44" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.917 20.706c1.129-1.412 1.833-3.177 1.833-5.123 0-4.548-3.701-8.25-8.25-8.25-4.549 0-8.25 3.702-8.25 8.25 0 4.549 3.701 8.25 8.25 8.25 1.943 0 3.709-.704 5.12-1.831l7.064 7.064a.92.92 0 001.296 0 .917.917 0 000-1.296l-7.063-7.064zM16.5 22a6.424 6.424 0 01-6.417-6.417A6.424 6.424 0 0116.5 9.167a6.424 6.424 0 016.417 6.416A6.424 6.424 0 0116.5 22zm0-22C7.907 0 .917 6.99.917 15.583c0 15.067 14.371 27.665 14.983 28.193a.92.92 0 001.203.002c.238-.207 5.894-5.139 10.217-12.518a.917.917 0 10-1.584-.928c-3.362 5.74-7.67 10.042-9.234 11.51-2.717-2.56-13.75-13.713-13.75-26.259 0-7.582 6.167-13.75 13.75-13.75 7.582 0 13.75 6.168 13.75 13.75 0 2.512-.45 5.143-1.331 7.818a.917.917 0 001.74.574c.944-2.862 1.422-5.684 1.422-8.392C32.083 6.991 25.093 0 16.5 0z" fill="#446a6b">
                </path>
              </svg>
            </figure>
            <p>Søg på modtagerens adresse</p>
          </li>
          <li>
            <figure class="shop-icon flex flex-cy flex-cx">
              <svg width="44" height="44" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg">
                <g fill="#446a6b">
                  <path d="M42.167 44H1.833a.917.917 0 01-.916-.917A4.59 4.59 0 015.5 38.5h33a4.59 4.59 0 014.583 4.583c0 .506-.41.917-.916.917zM2.906 42.167h38.186a2.757 2.757 0 00-2.594-1.834H5.5a2.757 2.757 0 00-2.594 1.834zm31.927-33H9.167a.917.917 0 01-.917-.917V4.583A4.59 4.59 0 0112.833 0h18.334a4.59 4.59 0 014.583 4.583V8.25c0 .506-.41.917-.917.917zm-24.75-1.834h23.834v-2.75a2.753 2.753 0 00-2.75-2.75H12.833a2.753 2.753 0 00-2.75 2.75v2.75z">
                  </path>
                  <path d="M7.333 22a4.59 4.59 0 01-4.583-4.583c0-.167.044-.33.13-.472l5.5-9.166a.917.917 0 01.787-.446h3.666a.916.916 0 01.899 1.097l-1.834 9.166C11.917 19.943 9.86 22 7.333 22zm-2.74-4.347a2.755 2.755 0 002.74 2.514 2.753 2.753 0 002.75-2.75l1.634-8.25H9.685l-5.093 8.486zM22 22a4.59 4.59 0 01-4.583-4.583V8.25c0-.506.41-.917.916-.917h7.334c.506 0 .916.411.916.917v9.167A4.59 4.59 0 0122 22zM19.25 9.167v8.25a2.753 2.753 0 002.75 2.75 2.753 2.753 0 002.75-2.75v-8.25h-5.5z"></path>
                  <path d="M14.667 22a4.59 4.59 0 01-4.584-4.583l1.852-9.347a.917.917 0 01.898-.737h5.5c.506 0 .917.411.917.917v9.167A4.59 4.59 0 0114.667 22zM13.585 9.167l-1.687 8.43c.019 1.336 1.252 2.57 2.769 2.57a2.753 2.753 0 002.75-2.75v-8.25h-3.832zM36.667 22a4.59 4.59 0 01-4.584-4.583L30.268 8.43a.92.92 0 01.899-1.097h3.666c.323 0 .62.169.787.446l5.5 9.166c.086.142.13.305.13.472A4.59 4.59 0 0136.667 22zM32.285 9.167l1.613 8.07c.019 1.696 1.252 2.93 2.769 2.93a2.755 2.755 0 002.74-2.514l-5.092-8.486h-2.03z">
                  </path>
                  <path d="M29.333 22a4.59 4.59 0 01-4.583-4.583V8.25c0-.506.41-.917.917-.917h5.5c.436 0 .812.308.898.737l1.833 9.167C33.917 19.943 31.86 22 29.333 22zm-2.75-12.833v8.25a2.753 2.753 0 002.75 2.75 2.753 2.753 0 002.75-2.75l-1.666-8.25h-3.834z"></path><path d="M36.667 40.333H7.333a.917.917 0 01-.916-.916V21.083a.917.917 0 011.833 0V38.5h27.5V21.083a.917.917 0 011.833 0v18.334c0 .506-.41.916-.916.916z"></path><path d="M20.167 34.833H11a.917.917 0 01-.917-.916V24.75c0-.506.411-.917.917-.917h9.167c.506 0 .916.411.916.917v9.167c0 .506-.41.916-.916.916zM11.917 33h7.333v-7.333h-7.333V33zM33 40.333h-9.167a.917.917 0 01-.916-.916V24.75c0-.506.41-.917.916-.917H33c.506 0 .917.411.917.917v14.667a.917.917 0 01-.917.916zM24.75 38.5h7.333V25.667H24.75V38.5z">
                  </path>
                </g>
              </svg>
            </figure>
            <p>Vælg gave fra en butik</p>
          </li>
          <li>
            <figure class="pen-paper-icon flex flex-cy flex-cx">
              <svg width="41" height="42" viewBox="0 0 41 42" xmlns="http://www.w3.org/2000/svg">
                <g fill="#446a6b">
                  <path d="M40.367 26.326l-3.385-3.385a.847.847 0 00-1.196 0L22.247 36.48a.852.852 0 00-.247.599v3.384c0 .467.38.846.846.846h3.385a.84.84 0 00.597-.248l10.149-10.15c.002 0 .003 0 .005-.003.002-.001.002-.003.003-.005l3.382-3.38a.847.847 0 000-1.197zM25.88 39.617h-2.188V37.43L33 28.12l2.188 2.188-9.308 9.308zm10.505-10.504l-2.189-2.188 2.189-2.188 2.188 2.188-2.188 2.188z">
                  </path>
                  <path d="M21.034 32.856L9.998 34.434 5.212 7.313l28.798-4.8 3.234 17.795a.847.847 0 001.665-.303L35.526 1.39a.849.849 0 00-.971-.684L23.943 2.474 2.61.696A.801.801 0 001.983.9a.844.844 0 00-.289.593L.002 31.954a.844.844 0 00.75.889l7.393.822.33 1.869a.845.845 0 00.95.69l11.846-1.692a.847.847 0 00.719-.958.85.85 0 00-.956-.718zM1.736 31.25l1.6-28.793 13.812 1.15L4.092 5.783a.844.844 0 00-.694.982l4.44 25.162-6.102-.678z">
                  </path>
                </g>
              </svg>
            </figure>
            <p>Skriv en personlig hilsen </p>
          </li>
          <li>
            <figure class="gift-icon flex flex-cy flex-cx">
              <svg width="44" height="41" viewBox="0 0 44 41" xmlns="http://www.w3.org/2000/svg">
                <g fill="#446a6b">
                  <path d="M40.333 20.01H3.667a2.753 2.753 0 01-2.75-2.75v-5.5a2.753 2.753 0 012.75-2.75h36.666a2.753 2.753 0 012.75 2.75v5.5a2.753 2.753 0 01-2.75 2.75zM3.667 10.845a.917.917 0 00-.917.917v5.5c0 .506.41.916.917.916h36.666c.506 0 .917-.41.917-.916v-5.5a.917.917 0 00-.917-.917H3.667z">
                  </path>
                  <path d="M36.667 40.178H7.333a4.59 4.59 0 01-4.583-4.584v-16.5c0-.506.41-.917.917-.917h36.666c.506 0 .917.411.917.917v16.5a4.59 4.59 0 01-4.583 4.584zM4.583 20.01v15.583a2.753 2.753 0 002.75 2.75h29.334a2.753 2.753 0 002.75-2.75V20.011H4.583zM22 10.844c-4.431 0-8.404-2.962-9.665-7.205a2.664 2.664 0 01.43-2.37c.68-.911 1.874-1.326 2.947-1.007 4.242 1.262 7.205 5.236 7.205 9.665a.917.917 0 01-.917.917zm-7.046-8.86a.915.915 0 00-.718.381.842.842 0 00-.145.752c.939 3.155 3.713 5.445 6.934 5.835-.389-3.22-2.679-5.995-5.836-6.932a.794.794 0 00-.235-.036z">
                  </path>
                  <path d="M22 10.844a.917.917 0 01-.917-.916c0-4.432 2.963-8.405 7.205-9.666 1.067-.317 2.268.097 2.947 1.008.517.694.674 1.559.43 2.371-1.261 4.24-5.234 7.203-9.665 7.203zm7.046-8.86a.877.877 0 00-.235.034c-3.155.94-5.445 3.713-5.836 6.934 3.22-.389 5.995-2.678 6.932-5.835a.837.837 0 00-.145-.752.908.908 0 00-.716-.381z">
                  </path>
                  <path d="M22 40.178a.917.917 0 01-.917-.917V12.14l-3.934 3.935a.917.917 0 01-1.296-1.296l5.5-5.5a.908.908 0 01.999-.198c.341.14.565.475.565.845V39.26a.917.917 0 01-.917.916z">
                  </path>
                  <path d="M27.5 16.344a.92.92 0 01-.649-.268l-5.5-5.5a.917.917 0 011.296-1.296l5.5 5.5a.917.917 0 01-.647 1.564z">
                  </path>
                </g>
              </svg>
            </figure>
            <p>Butikken pakker din gave flot ind</p>
          </li>
          <li class="timeline__item">
            <figure class="truck-icon flex flex-cy flex-cx">
              <svg width="46" height="39" viewBox="0 0 46 39" xmlns="http://www.w3.org/2000/svg">
                <path d="M45.771 21.638l-3.868-10.833a4.784 4.784 0 00-4.495-3.167H30.55V4.774A4.78 4.78 0 0025.777 0H4.774A4.78 4.78 0 000 4.774v26.732a2.869 2.869 0 002.864 2.864h2.962a4.783 4.783 0 004.676 3.819 4.783 4.783 0 004.676-3.82h17.378a4.783 4.783 0 004.676 3.82 4.783 4.783 0 004.676-3.82h1.054a2.865 2.865 0 002.863-2.863v-9.548a.92.92 0 00-.054-.32zM1.909 4.774a2.869 2.869 0 012.865-2.865h21.003a2.866 2.866 0 012.865 2.865v20.049H1.909V4.773zm8.593 31.505a2.869 2.869 0 01-2.864-2.864 2.869 2.869 0 012.864-2.864 2.866 2.866 0 012.864 2.864 2.866 2.866 0 01-2.864 2.864zm26.732 0a2.868 2.868 0 01-2.864-2.864 2.868 2.868 0 012.864-2.864 2.868 2.868 0 012.864 2.864 2.866 2.866 0 01-2.864 2.864zm6.683-4.773a.955.955 0 01-.955.954h-1.05a4.783 4.783 0 00-4.676-3.818 4.783 4.783 0 00-4.676 3.818H15.18a4.783 4.783 0 00-4.676-3.818 4.783 4.783 0 00-4.676 3.818H2.864a.955.955 0 01-.955-.954v-4.774h27.687a.955.955 0 00.955-.955V9.547h6.855c1.207 0 2.291.764 2.698 1.9l3.813 10.676v9.383zM34.37 19.094v-6.683a.955.955 0 00-1.91 0v7.638c0 .527.428.955.955.955h6.683a.955.955 0 000-1.91H34.37z" fill="#446a6b">
                </path>
              </svg>
            </figure>
            <p>Gaven leveres til din modtager</p>
          </li>
        </ul>
        <a class="bg-teal btn rounded-pill text-white my-2 py-2 px-4" href="<?php echo site_url(); ?>/saadan-fungerer-det/" target="">Læs mere</a>
      </div>
    </div>
  </div>
</section>

<section id="about">
  <div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-6 text-center d-flex align-items-center bg-teal text-white" style="height: 35vw; min-height: 500px;">
            <div class="p-2 p-lg-5 p-xl-5">
              <div class="media-text__inner text-right px-lg-4 px-xl-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="pb-3" width="183" height="72" viewBox="0 0 183 72"><g stroke="#F7F4F4" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"><path d="M35.696 51.159H2.652v18.174c0 .912.74 1.652 1.652 1.652h29.74c.911 0 1.652-.74 1.652-1.652V51.159zm1.652 0H1V44.55c0-.912.74-1.652 1.652-1.652h33.044c.912 0 1.652.74 1.652 1.652v6.609zm-18.174-8.261v28.087"></path><path d="M19.138 42.898c.757-4.274 4.288-9.115 8.643-9.857 1.867-.319 2.959 1.279 2.959 2.926 0 .717-.212 1.375-.562 1.888v-.006c-2.265 3.6-11.04 5.049-11.04 5.049"></path><path d="M19.21 42.898c-.757-4.274-4.288-9.115-8.643-9.857-1.867-.319-2.959 1.279-2.959 2.926 0 .717.212 1.375.562 1.888v-.006c2.265 3.6 11.04 5.049 11.04 5.049m158.877 27.45h-37.174A3.912 3.912 0 01137 66.435V44.913A3.912 3.912 0 01140.913 41h37.174A3.912 3.912 0 01182 44.913v21.522a3.912 3.912 0 01-3.913 3.913h0zm-35.217-9.783h7.826m-7.826 3.913h13.695"></path><path d="M155.013 47.707a9.785 9.785 0 009.378 6.988 9.785 9.785 0 00-6.989-9.377c-1.426-.425-2.813.962-2.388 2.389h0zm18.757 0a9.785 9.785 0 01-9.379 6.988 9.785 9.785 0 016.99-9.377c1.425-.425 2.813.962 2.388 2.389h0zm-9.379 22.641V41m0 13.696l-5.87 5.87m5.87-5.87l5.87 5.87M137 54.696h45m-61.899-21.034H53.848a3.314 3.314 0 01-3.313-3.313v-9.938a3.314 3.314 0 013.313-3.313H120.1a3.314 3.314 0 013.313 3.313v9.938a3.314 3.314 0 01-3.313 3.313h0z"></path><path d="M113.476 70.101H60.473a6.624 6.624 0 01-6.625-6.625V33.662H120.1v29.814a6.624 6.624 0 01-6.625 6.625h0zM71.097 5.265c2.034 6.844 8.374 11.833 15.877 11.833 0-7.503-4.989-13.844-11.833-15.877-2.415-.72-4.763 1.63-4.044 4.044h0zm31.755 0c-2.033 6.844-8.374 11.833-15.877 11.833 0-7.503 4.989-13.844 11.833-15.877 2.415-.72 4.763 1.63 4.044 4.044h0z"></path><path d="M86.975 70.101V17.098l-9.938 9.939m9.938-9.939l9.938 9.939"></path></g></svg>
                <h3 class="py-2">Om Greeting.dk</h3>
                <p class="px-lg-5 px-xl-5">👋🏼👋🏼 Vi er Lisette og Dennis, og vi står bag Greeting.dk! </p>
                <p class="px-lg-5 px-xl-5">Vi vil skabe de allerbedste muligheder for at sende fine og personlige gaver fra landets fysiske butikker til modtagere i hele Danmark.</p>
                <a class="btn bg-white text-teal rounded-pill mt-2 py-3 px-4" href="<?php echo site_url(); ?>/om-os/" title="Gå til siden: Om Greeting.dk">Om Greeting ></a>
              </div>
            </div>
          </div>
        <div class="col-12 col-md-6" style="background-image:url('https://greeting.dk/wp-content/uploads/2021/11/265A7587-aspect-ratio-800-700.jpg');background-size:cover;"></div>
    </div>
  </div>
</div>

<section class="businessgifts">
  <div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-6" style="background-image:url('https://greeting.dk/wp-content/uploads/2021/11/DSC_0628-aspect-ratio-800-700.jpg');background-size:cover;"></div>
        <div class="col-12 col-md-6 text-center d-flex align-items-center bg-pink text-teal" style="height: 35vw; min-height: 500px;">
          <div class="p-2 p-lg-5 p-xl-5">
            <div class="media-text__inner text-right px-lg-4 px-xl-4">
              <span class="small">Medarbejder- eller kundegaver?</span>
              <h2 class="py-2">Send firmagaver fra lokale butikker</h2>
              <p class="px-lg-5 px-xl-5">Lad os sørge for, at dine medarbejdere, kunder eller forretningsforbindelser modtager den perfekte gavehilsen fra dig!</p>
              <p class="px-lg-5 px-xl-5">Når du køber gaver via Greeting.dk, så støtter du og din virksomhed samtidigt de lokale specialbutikker. </p>
              <a class="btn bg-teal text-white rounded-pill mt-2 py-3 px-4" href="<?php echo site_url(); ?>/firmagaver/" title="https://greeting.dk/firmagaver/" target="">Læs om firmagaver ></a>
            </div>
          </div>
        </div>
    </div>
  </div>
</section>

<section class="partner">
  <div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-6 text-center d-flex align-items-center bg-yellow text-teal" style="height: 35vw; min-height: 500px;">
            <div class="p-2 p-lg-5 p-xl-5">
                <div class="media-text__inner text-left px-lg-4 px-xl-4">
                    <span class="small">Er du butik?</span>
                    <h2 class="py-2">Der er mange fordele for dig som vores samarbejdspartner</h2>
                    <p class="px-lg-5 px-xl-5">Greeting.dk samarbejder med mange forskellige fysiske specialbutikker i Danmark – og det eneste det kræver er, at du forhandler produkter med gave-potentiale.</p>
                    <a class="btn bg-white rounded-pill mt-2 py-3 px-4" href="<?php echo site_url(); ?>/bliv-butikspartner" title="Gå til siden: Bliv partner" target="">Bliv partner ></a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6" style="background-image:url('https://greeting.dk/wp-content/uploads/2021/11/265A7587-aspect-ratio-800-700.jpg');background-size:cover;"></div>
    </div>
  </div>
</section>

<section id="didyouknow" class="bg-light-grey pb-4">
  <div class="container-fluid text-center mb-3 py-5">
    <div class="row">
      <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
        <h4 class="pt-4 pb-3">🤔 Vidste du, at...</h4>
        <p class="px-lg-3 px-xl-3">Du på <b>Greeting.dk</b> handler i lokale, fysiske specialbutikker - og dermed er med til at støtte
          en dansk iværksætter og selvstændig?</p>
        <p class="px-lg-3 px-xl-3 pb-3">Der er netop nu mere end <strong>70 forskellige specialbutikker</strong> at vælge i mellem, næste gang du skal sende en lækker gave til én, du holder af.</p>
        <a href="<?php echo site_url(); ?>/om-os" class="btn bg-teal text-white py-3 px-4 rounded-pill">Mere om Greeting.dk ></a>
      </div>
    </div>
  </div>
</section>

<section id="learnmore">
  <div class="container">
    <div class="row py-5">
      <div clsas="col-12">
        <h4 class="text-center pb-5">👋 Howdy - vil du lære Greeting.dk lidt bedre at kende?</h4>
      </div>
      <div class="col-lg-4">
        <div class="card" style="">
          <img src="<?php echo get_field('howdy_block1_picture', 'options'); ?>" class="card-img-top" alt="<?php echo get_field('howdy_block1_header', 'options'); ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo get_field('howdy_block1_header', 'options'); ?></h5>
            <p class="card-text"><?php echo get_field('howdy_block1_text', 'options'); ?></p>
            <a href="<?php echo get_field('howdy_block1_link', 'options'); ?>" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">
              <?php echo get_field('howdy_block1_button_cta', 'options'); ?>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card" style="">
          <img src="<?php echo get_field('howdy_block2_picture', 'options'); ?>" class="card-img-top" alt="<?php echo get_field('howdy_block2_header', 'options'); ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo get_field('howdy_block2_header', 'options'); ?></h5>
            <p class="card-text"><?php echo get_field('howdy_block2_text', 'options'); ?></p>
            <a href="<?php echo get_field('howdy_block2_link', 'options'); ?>" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">
              <?php echo get_field('howdy_block2_button_cta', 'options'); ?>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card" style="">
          <img src="<?php echo get_field('howdy_block3_picture', 'options'); ?>" class="card-img-top" alt="<?php echo get_field('howdy_block3_header', 'options'); ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo get_field('howdy_block3_header', 'options'); ?></h5>
            <p class="card-text"><?php echo get_field('howdy_block3_text', 'options'); ?></p>
            <a href="<?php echo get_field('howdy_block3_link', 'options'); ?>" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">
              <?php echo get_field('howdy_block3_button_cta', 'options'); ?>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
