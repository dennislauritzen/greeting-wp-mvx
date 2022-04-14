<?php
get_header();
?>

<section class="row">
    <div class="col-12 col-md-6 d-flex align-items-center bg-purple" style="height:500px;">
        <div class="p-5">
            <h4 class="text-white">#STØTLOKALT</h4>
            <h1 class="text-pink">Skal vi levere en gavehilsen til én du holder af?</h1>
            <input type="text" class="form-control" placeholder="Indtast by eller postnr. (fx. 8000 el. Aarhus) og find lokale butikker">
            <ul class="list-inline">
                <li class="list-inline-item my-2">
                    <a href="#" class="btn btn-link rounded-pill border-1 border-white text-white">Vejle</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-12 col-md-6" style="background-image:url('https://greeting.dk/wp-content/uploads/2022/02/Sab_small-scaled-aspect-ratio-1400-700-scaled.jpg');background-size:cover;">

    </div>
</section>

<div class="my-6">
    <h2 class="h1">Gave inspiration</h2>
    <div class="row">
        <?php for ($i = 1; $i <= 6; $i++): ?>
        <div class="col-2">
            <div class="card">
                <a href="#"><img src="https://greeting.dk/wp-content/uploads/2021/04/Jordbaer-1-aspect-ratio-1000-800-600x600.png" class="card-img-top" alt="REPLACEME"></a>
                <div class="card-body">
                    <a href="#" class="small text-muted">Vinoble Faaborg X</a>
                    <h6 class="card-title"><a href="#" class="text-dark">Gavepakke "Forkæl"</a></h6>
                    <small>Fra 235 kr.</small>
                </div>
            </div>
        </div>
        <?php endfor; ?>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6 text-center d-flex align-items-center bg-teal text-white" style="height:500px;">
        <div class="p-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="183" height="72" viewBox="0 0 183 72"><g stroke="#F7F4F4" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"><path d="M35.696 51.159H2.652v18.174c0 .912.74 1.652 1.652 1.652h29.74c.911 0 1.652-.74 1.652-1.652V51.159zm1.652 0H1V44.55c0-.912.74-1.652 1.652-1.652h33.044c.912 0 1.652.74 1.652 1.652v6.609zm-18.174-8.261v28.087"></path><path d="M19.138 42.898c.757-4.274 4.288-9.115 8.643-9.857 1.867-.319 2.959 1.279 2.959 2.926 0 .717-.212 1.375-.562 1.888v-.006c-2.265 3.6-11.04 5.049-11.04 5.049"></path><path d="M19.21 42.898c-.757-4.274-4.288-9.115-8.643-9.857-1.867-.319-2.959 1.279-2.959 2.926 0 .717.212 1.375.562 1.888v-.006c2.265 3.6 11.04 5.049 11.04 5.049m158.877 27.45h-37.174A3.912 3.912 0 01137 66.435V44.913A3.912 3.912 0 01140.913 41h37.174A3.912 3.912 0 01182 44.913v21.522a3.912 3.912 0 01-3.913 3.913h0zm-35.217-9.783h7.826m-7.826 3.913h13.695"></path><path d="M155.013 47.707a9.785 9.785 0 009.378 6.988 9.785 9.785 0 00-6.989-9.377c-1.426-.425-2.813.962-2.388 2.389h0zm18.757 0a9.785 9.785 0 01-9.379 6.988 9.785 9.785 0 016.99-9.377c1.425-.425 2.813.962 2.388 2.389h0zm-9.379 22.641V41m0 13.696l-5.87 5.87m5.87-5.87l5.87 5.87M137 54.696h45m-61.899-21.034H53.848a3.314 3.314 0 01-3.313-3.313v-9.938a3.314 3.314 0 013.313-3.313H120.1a3.314 3.314 0 013.313 3.313v9.938a3.314 3.314 0 01-3.313 3.313h0z"></path><path d="M113.476 70.101H60.473a6.624 6.624 0 01-6.625-6.625V33.662H120.1v29.814a6.624 6.624 0 01-6.625 6.625h0zM71.097 5.265c2.034 6.844 8.374 11.833 15.877 11.833 0-7.503-4.989-13.844-11.833-15.877-2.415-.72-4.763 1.63-4.044 4.044h0zm31.755 0c-2.033 6.844-8.374 11.833-15.877 11.833 0-7.503 4.989-13.844 11.833-15.877 2.415-.72 4.763 1.63 4.044 4.044h0z"></path><path d="M86.975 70.101V17.098l-9.938 9.939m9.938-9.939l9.938 9.939"></path></g></svg>
            <h3>Om os</h3>
            <p>👋🏼👋🏼 Vi er Lisette og Dennis, og vi står bag Greeting.dk! </p>
            <p>Vi vil skabe de allerbedste muligheder for at sende fine og personlige gaver fra landets fysiske butikker til modtagere i hele Danmark.</p>
            <a class="btn btn-light" href="https://greeting.dk/om-os/" title="Gå til siden: Om Greeting.dk">Læs mere</a>
        </div>
    </div>
    <div class="col-12 col-md-6" style="background-image:url('https://greeting.dk/wp-content/uploads/2021/11/265A7587-aspect-ratio-800-700.jpg');background-size:cover;"></div>
</div>

<div class="row">
    <div class="col-12 col-md-6" style="background-image:url('https://greeting.dk/wp-content/uploads/2021/11/DSC_0628-aspect-ratio-800-700.jpg');background-size:cover;"></div>
    <div class="col-12 col-md-6 text-center d-flex align-items-center bg-pink text-teal" style="height:500px;">
        <div class="media-text__inner text-right">
            <span class="small">Medarbejder- eller kundegaver?</span>
            <h2>Send firmagaver fra lokale butikker</h2>
            <p>Lad os sørge for, at dine medarbejdere, kunder eller forretningsforbindelser modtager den perfekte gavehilsen fra dig!</p>
            <p>Når du køber gaver via Greeting.dk, så støtter du og din virksomhed samtidigt de lokale specialbutikker. </p>
            <a class="btn btn-light" href="https://greeting.dk/firmagaver/" title="https://greeting.dk/firmagaver/" target="">Erhvervskunde</a>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-12 col-md-6 text-center d-flex align-items-center bg-yellow text-teal" style="height:500px;">
            <div class="p-5">
                <div class="media-text__inner text-left">
                    <span class="small">Er du butik?</span>
                    <h2>Der er mange fordele for dig som vores samarbejdspartner</h2>
                    <p>Greeting.dk samarbejder med mange forskellige fysiske specialbutikker i Danmark – og det eneste det kræver er, at du forhandler produkter med gave-potentiale.</p>
                    <a class="btn btn-light" href="https://greeting.dk/bliv-partner/" title="Gå til siden: Bliv partner" target="">Bliv partner</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6" style="background-image:url('https://greeting.dk/wp-content/uploads/2021/11/265A7587-aspect-ratio-800-700.jpg');background-size:cover;"></div>
    </div>


<?php
get_footer();
