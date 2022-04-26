<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Rubik:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">


<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenu">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="">
      <p>Bliv Butikspartner</p>
      <p>Cases</p>
      <p>Om Greeting.dk</p>
      <p>Kontakt</p>
    </div>
  </div>
</div>
<section id="top" class="bg-teal pt-1">
    <div class="container py-4">
      <div class="row">
        <div class="d-flex pb-3 pb-lg-0 pb-xl-0 position-relative justify-content-center justify-content-lg-start justify-content-xl-start col-md-12 col-lg-3">
          <a href="<?php echo home_url(); ?>">
            <!--<img src="https://dev.greeting.dk/wp-content/uploads/2022/04/greeting-pink.png" style="width: 150px;">-->
            <!--<img src="https://dev.greeting.dk/wp-content/uploads/2022/04/Greeting-1.png" style="width: 150px;">-->
            <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/greeting-logo-white.png" style="text-align: center; width: 150px;">
            <!-- <img src="https://dev.greeting.dk/wp-content/uploads/2022/04/greeting-test.png" style="width: 150px;"> -->
          </a>
          <a class="position-absolute top-0 end-0 me-4 d-inline d-lg-none d-xl-none" data-bs-toggle="offcanvas" href="#offcanvasMenu" role="button" aria-controls="offcanvasExample">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#ffffff" class="bi bi-list" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg>
          </a>
        </div>
        <div class="col-md-12 col-lg-5 col-xl-6">
          <form action="" method="" class="position-relative mx-5">
            <label for="" class="screen-reader-text">Indtast det postnummer, du ønsker at sende en gave til - og se udvalget af butikker</label>
            <button type="submit" name="submit" class="top-search-btn rounded-pill position-absolute border-0 end-0 bg-teal p-3 me-1"></button>
            <input type="text" class="top-search-input form-control rounded-pill border-0 py-2" value="5683 Haarby" placeholder="Indtast by eller postnr.">
            <figure class="location-pin position-absolute ms-2 mt-1 top-0" style="padding-top:1px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#333333" class="bi bi-geo-alt" viewBox="0 0 16 16">
                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
              </svg>
            </figure>
            <input type="hidden" name="greeting_topsearch_submit_" value="re54813wfq1_!fe515">
          </form>
        </div>
        <div class="d-none d-lg-inline d-xl-inline d-lg-inline col-lg-4 col-xl-3 right-col text-end">
          <a href="#" class="btn text-white">Log ind</a>
          <a href="#" class="btn btn-create rounded text-white">Opret</a>
          <div class="btn position-relative ms-lg-0 ms-xl-1">
            <span class="position-relative" aria-label="Se kurv">
              <svg width="21" height="23" viewBox="0 0 21 23" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.434 6.967H3.306l-1.418 14.47h17.346L17.82 6.967h-3.124c.065.828.097 1.737.097 2.729h-1.5c0-1.02-.031-1.927-.093-2.729H7.93a35.797 35.797 0 00-.093 2.729h-1.5c0-.992.032-1.9.097-2.729zm.166-1.5C7.126 1.895 8.443.25 10.565.25s3.44 1.645 3.965 5.217h4.65l1.708 17.47H.234l1.712-17.47H6.6zm6.432 0c-.407-2.65-1.27-3.717-2.467-3.717-1.196 0-2.06 1.066-2.467 3.717h4.934z" fill="#ffffff">
                </path>
              </svg>
              <span class="position-absolute start-50 top-0 badge rounded-circle text-white" style="background: #cea09f;">0</span>
            </span>
            <span class="d-inline px-lg-2 px-xl-3 hide-lg text-white">Kurv</span>
          </div>
        </div>
      </div>
    </div>
</section>
