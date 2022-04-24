<?php
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
                <div><img src="https://dev.greeting.dk/wp-content/uploads/2022/04/greeting-logo-white.png" class="pb-4" style="max-height:60px;"></div>
                <h4 class="text-teal fs-6">#STØTLOKALT</h4>
                <h1 class="text-white pb-3">Skal vi levere <span id="spinner"></span> <br>til én du holder af?</h1>
                <form role="search" method="get" autocomplete="off" id="searchform">
                <div class="input-group pb-4 w-100 me-0 me-xs-0 me-sm-0 me-md-0 me-lg-5 me-xl-5">
                  <input type="text" name="keyword" id="front_Search-new_ucsa" class="form-control border-0 ps-5 pe-3 py-3 shadow-sm rounded" placeholder="Indtast by eller postnr. (eks. 8000)">
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
                  global $wpdb;

                  $landing_page_meta = $wpdb->get_results(
                      "
                          SELECT *
                          FROM {$wpdb->prefix}postmeta
                          WHERE meta_key =  'is_featured_city'
                          AND meta_value = 1
                          LIMIT 8
                      "
                  );

                  $page_id_array = array();

                  foreach($landing_page_meta as $key => $land_meta){
                      $page_id_array[] = $land_meta->post_id;
                  }

                  $page_id_array_length = count($page_id_array);
                  $page_id_array_midle = $page_id_array_length/2;
                  $page_id_array_midle_celling = ceil($page_id_array_midle);

                  foreach($page_id_array as $key => $landing_page_id){ ?>
                    <li class="list-inline-item pb-1">
                      <a href="<?php echo get_permalink($landing_page_id);?>" class="btn btn-link rounded-pill pb-2 border-1 border-white text-white">
                        <?php echo get_post_meta($landing_page_id, 'postalcode', true)." ".get_post_meta($landing_page_id, 'city', true);?>
                      </a>
                    </li>
                  <?php
                  }
                  ?>
                </ul>
            </div>
        </div>
      </div>
    </div>
</section>

<section id="inspiration" class="inspirationstores">
  <div class="container">
    <div class="row my-4 py-5">
      <div clsas="col-12">
        <h4 class="h1 pb-5 mb-3 text-center">📍 Bliv inspireret i lækre butikker nær dig</h4>
      </div>
      <div class="col-12 pb-3 pb-lg-0 pb-xl-0 col-sm-6 col-lg-3">
        <div class="card" style="">
          <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/pexels-furkanfdemir-6309844-scaled.jpg" class="card-img-top" alt="<?php echo $store_name; ?>">
          <div class="card-body">
            <h5 class="card-title">Vin & Vin</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">Se butikkens udvalg</a>
          </div>
        </div>
      </div>
      <div class="col-12 pb-3 pb-lg-0 pb-xl-0 col-sm-6 col-lg-3">
        <div class="card" style="">
          <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/pexels-secret-garden-931154-scaled.jpg" class="card-img-top" alt="<?php echo $store_name; ?>">
          <div class="card-body">
            <h5 class="card-title">Flowers all over</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">Se butikkens udvalg</a>
          </div>
        </div>
      </div>
      <div class="col-12 pb-3 pb-lg-0 pb-xl-0 col-sm-6 col-lg-3">
        <div class="card" style="">
          <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/pexels-florent-b-2664149-scaled.jpg" class="card-img-top" alt="<?php echo $store_name; ?>">
          <div class="card-body">
            <h5 class="card-title">John's Vin</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">Se butikkens udvalg</a>
          </div>
        </div>
      </div>
      <div class="col-12 pb-3 pb-lg-0 pb-xl-0 col-sm-6 col-lg-3">
        <div class="card">
          <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/pexels-furkanfdemir-6309844-scaled.jpg" class="card-img-top" alt="<?php echo $store_name; ?>">
          <div class="card-body">
            <h5 class="card-title">Vin & Vin</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">Se butikkens udvalg</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="howitworks" class="bg-light-grey py-5">
  <div class="container text-center">
    <div class="row">
      <div class="col-12">
        <h2 class="py-2">🎁 Sådan fungerer det</h2>
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
          <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/pexels-furkanfdemir-6309844-scaled.jpg" class="card-img-top" alt="<?php echo $store_name; ?>">
          <div class="card-body">
            <h5 class="card-title">Skal din butik være med?</h5>
            <p class="card-text">Skal din butik også være med på Greeting.dk? Vi arbejder altid for et ligeværdigt samarbejde -
              og vil til enhver tid arbejde sammen med dig om at sikre den bedste oplevelse for vores fælles kunder. Vil du være med?</p>
            <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">Du starter lige her</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card" style="">
          <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/pexels-secret-garden-931154-scaled.jpg" class="card-img-top" alt="<?php echo $store_name; ?>">
          <div class="card-body">
            <h5 class="card-title">Fortjener dine medarbejdere en hilsen?</h5>
            <p class="card-text">Det er vigtigt at huske dem, du sætter pris på - også på jobbet. Derfor tilbyder vi også firmaer at levere større partiere af medarbejder gaver til eks. jul, påske, sommer - eller gaven til den kommende jubilar.</p>
            <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">Se butikkens udvalg</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card" style="">
          <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/pexels-florent-b-2664149-scaled.jpg" class="card-img-top" alt="<?php echo $store_name; ?>">
          <div class="card-body">
            <h5 class="card-title">Spørgsmål? Så fang os her :)</h5>
            <p class="card-text">Vil du gerne høre, hvad vi er for nogen - og hvordan det hele fungerer? Eller har du konkrete spørgsmål til udvalget i en af butikkerne? Vi sidder altid klar - så ræk endelig ud.</p>
            <a href="#" class="rounded-pill bg-teal text-white d-inline-block my-1 py-2 px-4 stretched-link">Se butikkens udvalg</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
