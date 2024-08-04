<?php

function enqueue_partytown() {
    wp_enqueue_script(
        'partytown',
        'https://unpkg.com/@builder.io/partytown@0.10.2/lib/partytown.js',
        array(),
        false,
        //'0.10.2',
        false
    );
}
#add_action('wp_enqueue_scripts', 'enqueue_partytown');

function greeting_gtm_head(){
    echo " <!-- LOCAL TM -->
    <script defer>
        (function(w,d,s,l,i){
            w[l]=w[l]||[];
            w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});
            var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
            j.defer=true;
            j.src='https://gtm.greeting.dk/bocfvmll.js?id='+i+dl;
            f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-N7VZGS3');
    </script>
    <!-- End LOCAL TM -->";
}
add_action( 'wp_head' , 'greeting_gtm_head');

function greeting_gtm_body_open(){
    echo '<!-- LOCAL TM (noscript) -->
	<noscript><iframe src="https://gtm.greeting.dk/ns.html?id=GTM-N7VZGS3"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End LOCAL TM (noscript) -->';
}
add_action( 'wp_body_open' , 'greeting_gtm_body_open');


function add_expires_headers_to_assets($headers, $file) {
    $path_info = pathinfo($file);
    $ext = isset($path_info['extension']) ? $path_info['extension'] : '';

    switch ($ext) {
        case 'jpg':
        case 'jpeg':
        case 'gif':
        case 'png':
        case 'webp':
        case 'svg':
        case 'ico':
            $expires_offset = 31536000; // 1 year
            break;
        case 'css':
            $expires_offset = 2592000; // 1 month
            break;
        case 'js':
            $expires_offset = 2592000; // 1 month
            break;
        case 'pdf':
        case 'swf':
            $expires_offset = 2592000; // 1 month
            break;
        default:
            $expires_offset = 604800; // 1 week
            break;
    }

    $headers['Expires'] = gmdate("D, d M Y H:i:s", time() + $expires_offset) . " GMT";
    $headers['Cache-Control'] = 'public, max-age=' . $expires_offset;

    return $headers;
}

#('wp_headers', 'add_expires_headers_to_assets', 10, 2);