<?php
/**
 * Template Name: Page (Cart)
 * Description: Page template.
 *
 */

get_header();
get_header('green');

the_post();
?>
<section id="cart" class="container">
  <div class="row mt-4">
  	<div class="col-12">
  		<div id="post-<?php the_ID(); ?>" <?php post_class( 'content' ); ?>>
  			<h1 class="entry-title" style="font-family: 'Rubik', 'Inter', sans-serif;"><?php the_title(); ?></h1>
  			<?php
  				the_content();
  			?>
  		</div><!-- /#post-<?php the_ID(); ?> -->
  	</div><!-- /.col -->
  </div><!-- /.row -->
</section>

<section id="customercare" class="mt-5 bg-light-grey py-5">
	<div class="container py-5">
		<div class="row">
			<div class="col-12 text-center">
				<h2 class="pb-4">Kundeservice hos Greeting.dk</h2>
				<p class="pb-3">Har du spørgsmål eller brug for hjælp til din bestilling, så sidder vi klar på telefon hverdage mellem 8 og 16 - og på mail og chat hver dag fra 8-20.</p>
			</div>
		</div>
		<div class="row">
			<div class="col-4 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
				  <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"></path>
				</svg>
        <p class="pt-2">Ring på tlf.</p>
			</div>
			<div class="col-4 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-envelope-heart" viewBox="0 0 16 16">
				  <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l3.235 1.94a2.76 2.76 0 0 0-.233 1.027L1 5.384v5.721l3.453-2.124c.146.277.329.556.55.835l-3.97 2.443A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741l-3.968-2.442c.22-.28.403-.56.55-.836L15 11.105V5.383l-3.002 1.801a2.76 2.76 0 0 0-.233-1.026L15 4.217V4a1 1 0 0 0-1-1H2Zm6 2.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z"></path>
				</svg>
        <p class="pt-2">Skriv til os på mail ..</p>
			</div>
			<div class="col-4 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
          <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
        </svg>
        <p class="pt-2">Skriv til os via chatten</p>
			</div>
		</div>
	</div>
</section>
<section id="customerreviews" class="py-5">
	<div class="container py-3">
		<div class="row">
			<div class="col-12">
				<h2 style="font-family: 'Inter', Arial,sans-serif;" class="text-center">⭐ Det siger kunderne om Greeting.dk</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-12 text-center p-5">
				<img class="img-fluid" style="max-width: 400px;" src="https://www.greeting.dk/wp-content/uploads/2022/12/review-count-stat.png">
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6">
				<p>"<i>En meget nem og overskuelig side og er vild med at man støtter lokale butikker der hvor modtageren bor.  Købte mandag og det blev leveret tirsdag.</i>"</p>
				<p style="font-weight: bold;">Pia Hoff (15. december 2022)</p>
			</div>
			<div class="col-12 col-md-6">
				<p>"<i>Jeg bestilt en gavekurv til min far, og wauw en kurv han fik, den var virkelig flot. At man kan give en gave på den her måde synes jeg bare er genialt.
3 timer fra bestilling til kurven var hjemme ved min far.</i>"</p>
				<p style="font-weight: bold;">Janni (10. december 2022)</p>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
