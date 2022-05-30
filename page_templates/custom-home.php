<?php
/*
  Template Name: Custom Home
 */
get_header();
?>

<style>
    .vc_custom_1509877871727 {
        margin-bottom: 0px !important;
        padding-top: 100px !important;
        padding-bottom: 150px !important;
        background: rgba(245,172,153,0.91) url(<?php echo wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );?>) !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        background-size: cover !important;
        *background-color: rgb(245,172,153) !important;
    }
    #content>.inner, .dokan-dashboard #container>.dokan-dashboard-wrap {
        padding-top: 0px;
    }

    div.widget_product_search input[type="text"] {
        border-radius: 2em;
        padding-left: 40px !important;
        font-family: 'Open Sans',sans-serif;
        font-weight: 300 !important;
        font-size: 14px !important;
        color: #111111 !important;
    }

    .wpb_widgetised_column div.widget_product_search form#searchform>div:after {
        display: block;
        color: #494932;
        content: "\f3c5";
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 18px;
        width: 45px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        vertical-align: middle;
        z-index: 10;
        position: absolute;
        top: 5.5px;
        left: 0;
    }

    .wpb_widgetised_column div.widget_product_search form#searchform>div:before {
        display: block;
        color: white;
        background-color: #494932;
        border-radius: 2em;
        content: "\f002";
        font-family: 'Font Awesome 5 Free';
        font-weight: 600;
        font-size: 14px;
        width: 45px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        vertical-align: middle;
        z-index: 10;
        position: absolute;
        top: 5.5px;
        right: 10px;
    }

    #post-12 {
        height: auto;
        width: auto;
        position: relative;
    }

    .top-area {
        width:100%;
        position:absolute;
        z-index: 3000;
    }

    table {
        margin-bottom: 0;
    }
    /**how it works begin */
    input[type="submit"],input[type="button"],button[type="submit"],.btn-1,.wp-block-button__link,.btn-2,.btn-3,.btn-4{background-color:#494932;color:#FFF;border:none;padding:1em 3em;text-align:center;cursor:pointer;transition:.2s;outline:none;border-radius:50px;font-size:15px;font-weight:bold;display:inline-block;text-decoration:none}input[type="submit"] a,input[type="button"] a,button[type="submit"] a,.btn-1 a,.wp-block-button__link a,.btn-2 a,.btn-3 a,.btn-4 a{color:#FFF !important}input:hover[type="submit"],input:hover[type="button"],button:hover[type="submit"],.btn-1:hover,.wp-block-button__link:hover,.btn-2:hover,.btn-3:hover,.btn-4:hover{background-color:#494932;color:#FFF}input:active[type="submit"],input:active[type="button"],button:active[type="submit"],.btn-1:active,.wp-block-button__link:active,.btn-2:active,.btn-3:active,.btn-4:active,input:focus[type="submit"],input:focus[type="button"],button:focus[type="submit"],.btn-1:focus,.wp-block-button__link:focus,.btn-2:focus,.btn-3:focus,.btn-4:focus{background-color:#582938;color:#FFF}input[type="text"],input[type="number"],input[type="email"],input[type="tel"],input[type="date"],input[type="month"],input[type="week"],input[type="time"],input[type="url"],input[type="search"],input[type="password"],textarea,select{border:solid 1px #CCC;padding:0.7em;border-radius:4px;outline:none;color:#333;background-color:#FFF}! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.csshtml{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}main{display:block}h1{font-size:2em;margin:0.67em 0}hr{box-sizing:content-box;height:0;overflow:visible}pre{font-family:monospace, monospace;font-size:1em}a{background-color:transparent}abbr[title]{border-bottom:none;text-decoration:underline;-webkit-text-decoration:underline dotted;text-decoration:underline dotted}b,strong{font-weight:bolder}code,kbd,samp{font-family:monospace, monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-0.25em}sup{top:-0.5em}img{border-style:none}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;line-height:1.15;margin:0}button,input{overflow:visible}button,select{text-transform:none}button,[type="button"],[type="reset"],[type="submit"]{-webkit-appearance:button}button::-moz-focus-inner,[type="button"]::-moz-focus-inner,[type="reset"]::-moz-focus-inner,[type="submit"]::-moz-focus-inner{border-style:none;padding:0}button:-moz-focusring,[type="button"]:-moz-focusring,[type="reset"]:-moz-focusring,[type="submit"]:-moz-focusring{outline:1px dotted ButtonText}fieldset{padding:0.35em 0.75em 0.625em}legend{box-sizing:border-box;color:inherit;display:table;max-width:100%;padding:0;white-space:normal}progress{vertical-align:baseline}textarea{overflow:auto}[type="checkbox"],[type="radio"]{box-sizing:border-box;padding:0}[type="number"]::-webkit-inner-spin-button,[type="number"]::-webkit-outer-spin-button{height:auto}[type="search"]{-webkit-appearance:textfield;outline-offset:-2px}[type="search"]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}details{display:block}summary{display:list-item}template{display:none}[hidden]{display:none}html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline}article,aside,footer,header,nav,section,figcaption,figure,figure img,main,hgroup{display:block}time{display:inline}input:focus,textarea:focus{outline:none}table{border-collapse:collapse;border-spacing:0}img{border:none;max-width:100%;height:auto}a{cursor:pointer;text-decoration:none}ul,ol{list-style:none;padding-left:0}ins{text-decoration:none}mark{background:transparent;color:inherit}button{border:none}a,p,b,strong,i,em,h1,h2,h3,h4,h5,h6,td,th,li,input,label,textarea,button,span,code,blockquote,input,option,time,mark,cite,small,ins,del,u,s,abbr,figcaption,address,div{-webkit-font-smoothing:antialiased;-moz-font-smoothing:antialiased;-o-font-smoothing:antialiased;font-smoothing:antialiased;text-rendering:optimizeLegibility}h1,.h1,h2,.h2,h3,.h3,h4,.h4,h5,.h5,fieldset legend,h6,.h6{color:#333;font-family:"merriweatherregular",arial,sans-serif;margin:0 0 0.5em 0;line-height:1.4em;word-break:break-word;-webkit-hyphens:auto;-ms-hyphens:auto;hyphens:auto}h1 a,.h1 a,h2 a,.h2 a,h3 a,.h3 a,h4 a,.h4 a,h5 a,.h5 a,fieldset legend a,h6 a,.h6 a{color:#333}h1,.h1{font-size:30px;font-size:30px}
    @media (min-width: 320px){h2,.h2{font-size:calc(26px + 8 * (100vw - 320px) / 880)}}
    @media (min-width: 1200px){blockquote{font-size:22px}}blockquote p{line-height:1.6em !important;margin:0 0 0.5em 0 !important}a{color:#494932;outline:none;transition:.2s}a:focus,a:hover,a:active,a.active{color:#582938}cite{font-size:14px;opacity:0.6}figcaption{opacity:0.75;margin-top:0.75em}.text-sm{font-size:14px;font-size:12px}.text-md{font-size:16px;font-size:15px}
    @media (min-width: 320px){.text-md{font-size:calc(15px + 2 * (100vw - 320px) / 880)}}
    @media (min-width: 1200px){.text-md{font-size:17px}}.text-lg{font-size:20px;font-size:16px}
    @media (min-width: 1200px){.text-lg{font-size:20px}}.main-content ul,.main-content ol,.main-footer ul,.main-footer ol{line-height:1.8em;word-break:break-word;-webkit-hyphens:auto;-ms-hyphens:auto;hyphens:auto}.main-content p,.main-footer p{line-height:1.8em;margin:0 0 2em 0}.main-content ul,.main-content ol{padding-left:1em}.main-content ul{list-style:disc}.main-content ol{list-style:decimal}.anim-appear-up{transform:translateY(20px)}.anim-appear-right{transform:translateX(-20px)}.anim-appear-down{transform:translateY(-20px)}.anim-appear-left{transform:translateX(20px)}.anim-appear-up,.anim-appear-right,.anim-appear-down,.anim-appear-left{transition:opacity 1s ease-out 0ms,transform 1s cubic-bezier(0.3, 0.98, 0.41, 0.99) 0ms;opacity:0}.anim-fade-in{opacity:0}.anim-fade-out{opacity:1}.anim-fade-in,.anim-fade-out{transition:opacity 0.6s ease-in-out}.anim-delay-1{transition-delay:0.1s}.anim-delay-2{transition-delay:0.2s}.anim-delay-3{transition-delay:0.3s}.anim-delay-4{transition-delay:0.4s}.anim-delay-5{transition-delay:0.5s}.anim-delay-6{transition-delay:0.6s}.anim-delay-7{transition-delay:0.7s}.anim-delay-8{transition-delay:0.8s}.anim-delay-9{transition-delay:0.9s}.anim-delay-10{transition-delay:1s}[data-emergence=visible].anim-appear-up{transform:translateY(0)}[data-emergence=visible].anim-appear-right{transform:translateX(0)}[data-emergence=visible].anim-appear-down{transform:translateY(0)}[data-emergence=visible].anim-appear-left{transform:translateX(0)}[data-emergence=visible].anim-appear-up,[data-emergence=visible].anim-appear-right,[data-emergence=visible].anim-appear-down,[data-emergence=visible].anim-appear-left{opacity:1}[data-emergence=visible].anim-fade-in{opacity:1}[data-emergence=visible].anim-fade-out{opacity:0}@-webkit-keyframes spinner{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}@keyframes spinner{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}@-webkit-keyframes hovering{0%{transform:translateY(0px)}20%{transform:translateY(0px)}60%{transform:translateY(-20px)}100%{transform:translateY(0px)}}@keyframes hovering{0%{transform:translateY(0px)}20%{transform:translateY(0px)}60%{transform:translateY(-20px)}100%{transform:translateY(0px)}}*,*::before,*::after{box-sizing:inherit}html{box-sizing:border-box;font-size:15px;line-height:1.3em;-webkit-tap-highlight-color:transparent}

    body{
        background:#fff;
        color:#333;
        font-family:"open_sansregular","Helvetica Neue",arial,sans-serif;
        font-size:15px;
        overflow-x:hidden
    }
    ::-moz-selection{
        background:rgba(123,57,78,0.15)
    }
    ::selection{
        background:rgba(123,57,78,0.15)}
    hr{
        border:none;
        height:1px;
        width:100%;
        background:#D8D8D8;
        margin:3em 0
    }
    .screen-reader-text{
        border:0;
        clip:rect(1px, 1px, 1px, 1px);
        -webkit-clip-path:inset(50%);
        clip-path:inset(50%);
        height:1px;
        margin:-1px;
        overflow:hidden;
        padding:0;
        position:absolute !important;
        width:1px;
        word-wrap:normal !important
    }
    img{
        image-rendering:-webkit-optimize-contrast;
        image-rendering:-moz-optimize-contrast
    }
    img[data-lazy-src]{
        opacity:0
    }
    img.lazyloaded{
        transition:opacity .5s linear 0.2s;
        opacity:1
    }
    .embed-responsive--video{
        position:relative;
        padding-bottom:56.25%;
        overflow:hidden;
        max-width:100%;
        height:auto
    }
    .embed-responsive--video iframe,.embed-responsive--video object,.embed-responsive--video embed{
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%
    }
    .clearfix::after{
        clear:both;
        content:"";
        display:table
    }
    .float-left{
        float:left !important
    }
    .float-right{
        float:right !important
        }
    .rel{
        position:relative
    }
    .abs{
        position:absolute
    }
    .sticky{
        position:-webkit-sticky;
        position:sticky
    }
    .abs-center{
        top:50%;
        left:50%;
        transform:translate(-50%, -50%)
    }
    .block{
        display:block
    }
    .inline{
        display:inline
    }
    .inline-block{
        display:inline-block
    }
    .none{
        display:none !important
    }
    .flex{
        display:flex
    }
    .inline-flex{
        display:inline-flex
    }
    .flex-cy{
        align-items:center
    }
    .flex-cx{
        justify-content:center
    }
    .is-visible{
        display:block !important
    }
    .text-center,.aligncenter,.has-text-align-center{
        text-align:center
    }
    .no-margin{
        margin-top:0 !important;
        margin-bottom:0 !important
    }

    .slogan-before-search {
        font-family: 'Merriweather', serif;
        font-size:35px;
        color: #ffffff;
        font-weight: 700;
        letter-spacing: -1px;
    }

    h2.how-it-works-header {
        font-family: 'Open Sans', 'open_sansregular', 'open_sans', 'Helvetica', 'Helvetica Neue', Arial, sans-serif;
        margin: -25px 0 30px 0;
        padding: 0;
        font-weight: 400;
    }

    .how-it-works-paragraph {
        font-family: 'Open Sans', 'open_sansregular', 'open_sans', 'Helvetica', 'Helvetica Neue', Arial, sans-serif;
        padding: 0 0 10px 0;
        font-size: 12pt;
    }

    .timeline__item p {
        font-family: 'Open Sans', 'open_sansregular', 'open_sans', 'Helvetica', 'Helvetica Neue', Arial, sans-serif;
    }

    .recommandations {
      padding: 50px 0 0 0;
    }
    .recommandations a {
      color: #494932 !important;
      background-color:rgb(255,255,255);background-color:rgba(255,255,255,0.75) !important;
      margin: 0 0 10px 0 !important;
    }


    .top-area {
      position: absolute;
      z-index: 999999;
    }
    #woocommerce_product_search-2,
    .wpb_wrapper,
    .vc_custom_1509877871727 {
      position: relative;
      z-index: 999999 !important;
    }
    #datafetch_wrapper {
      display: none;
      z-index: inherit;
    }

    #datafetch {
      /*background-color:rgb(255,255,255);background-color:rgba(255,255,255,0.9) !important;*/
      color: #494932 !important;
      padding: 0;
      width: auto;
      margin: 1px 50px 0 25px;
      z-index: inherit;
      font-family: 'Open Sans', 'open_sansregular', 'open_sans', 'Helvetica', 'Helvetica Neue', Arial, sans-serif;
    }

    @media screen and (max-width: 960px){.nav-open .mobile-menu .receiver-field,.nav-open .mobile-menu .receiver-enter-address{display:none}.nav-open .mobile-menu__nav{position:fixed;top:0;right:0;bottom:0;left:0;background:#fff;width:100%;z-index:98;height:100%;overflow-y:auto;overflow-x:initial;max-height:100%;display:block;white-space:initial;padding-bottom:54px}.nav-open .mobile-menu__nav:after{display:none}.nav-open .mobile-menu__nav li{width:100%;position:relative}.nav-open .mobile-menu__nav li a{width:100%;color:#333;transition:none}.nav-open .mobile-menu__nav li.open>.sub-menu{max-height:100%}.nav-open .mobile-menu__nav .current-menu-item>a,.nav-open .mobile-menu__nav .current-menu-ancestor>a{color:#494932}.nav-open .mobile-menu__nav .menu{padding:0;overflow-x:visible;overflow-y:visible;white-space:normal}.nav-open .mobile-menu__nav .menu li a{border-bottom:solid 1px #D8D8D8}.nav-open .mobile-menu__nav .sub-menu{padding:0;max-height:0;overflow:hidden}.nav-open .mobile-menu__nav .sub-menu a{background:#F7F4F4}.nav-open .mobile-menu__nav .sub-menu .sub-menu a{background:#f1ebeb}.nav-open .mobile-menu__nav .sub-menu .sub-menu .sub-menu a{background:#eae2e2}.nav-open .mobile-menu__nav .sub-menu .sub-menu .sub-menu .sub-menu a{background:#e4d9d9}.nav-open .menu-collapse{right:0;top:0;border-left:solid 1px #D8D8D8;padding:25px 17px;height:100%;color:#333}.nav-open .menu-collapse__icon{width:15px;height:15px}.nav-open .menu-collapse__icon:before,.nav-open .menu-collapse__icon:after{content:"";width:15px;height:2px;background-color:#333;display:block;position:absolute;transition:0.1s}.nav-open .menu-collapse__icon:after{transform:rotate(90deg)}.nav-open .collapsed>.sub-menu{display:block;max-height:100%}.nav-open .collapsed>.menu-collapse .menu-collapse__icon:before,.nav-open .collapsed>.menu-collapse .menu-collapse__icon:after{transform:rotate(180deg)}.nav-open .mobile-nav__icon{transition-delay:.12s;transition-timing-function:cubic-bezier(0.215, 0.61, 0.355, 1);transform:rotate(45deg)}.nav-open .mobile-nav__icon:before{top:0;transition:top 75ms ease,opacity 75ms ease .12s;opacity:0}.nav-open .mobile-nav__icon:after{bottom:0;transition:bottom 75ms ease,transform 75ms cubic-bezier(0.215, 0.61, 0.355, 1) 0.12s;transform:rotate(-90deg)}.nav-open .show-in-mobile-nav{display:block}.nav-open .show-in-mobile-menu{display:inline-block}}.sub-nav{border-bottom:solid 1px #D8D8D8}.sub-nav .menu{padding:0}.sub-nav li{display:inline-block;margin-right:10px}.sub-nav li:last-child{margin-right:20px}.sub-nav a{padding:15px 0;display:inline-block;color:#333}.sub-nav a:hover{color:#494932}.sub-nav.below-cover{border-top:0}.sub-nav:after{content:"";display:block;width:40px;position:absolute;top:0;right:0;bottom:0;background:linear-gradient(to right, rgba(255,255,255,0), rgba(255,255,255,0.8), #fff)}.slick-slider .slick-dots{list-style:none;padding:0;margin:10px 0 0 0;text-align:center}.slick-slider .slick-dots li{display:inline-block;margin:0 5px}.slick-slider .slick-dots button{outline:none;background:rgba(153,153,153,0.4);border-radius:50%;text-indent:-9999px;color:transparent;width:12px;height:12px;border:none;padding:0;cursor:pointer;transition:.2s}.slick-slider .slick-dots .slick-active button{background:#999}.breadcrumbs{padding:25px 0 35px 0}.breadcrumbs p{margin:0;line-height:initial}.breadcrumbs>span,.breadcrumbs nav{display:block;padding-right:20px;font-size:13px;color:rgba(51,51,51,0.7);overflow-x:auto;overflow-y:hidden;white-space:nowrap;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.breadcrumbs>span::-webkit-scrollbar,.breadcrumbs nav::-webkit-scrollbar{display:none}.breadcrumbs a{color:rgba(51,51,51,0.7)}.breadcrumbs a:hover{text-decoration:underline}.breadcrumbs:after{content:"";display:block;width:30px;position:absolute;top:0;right:0;bottom:0;background:linear-gradient(to right, rgba(255,255,255,0), rgba(255,255,255,0.6), #fff)}.nav-links,.woocommerce-pagination{text-align:center}.nav-links li,.woocommerce-pagination li{display:inline-block}.nav-links span.page-numbers,.nav-links a.page-numbers,.woocommerce-pagination span.page-numbers,.woocommerce-pagination a.page-numbers{display:inline-block;text-align:center;background:rgba(0,0,0,0.1);width:32px;height:32px;white-space:nowrap;text-decoration:none;line-height:32px;border-radius:50%;color:#333;margin:0 3px;font-size:16px;list-style:none;padding:0}.nav-links span.page-numbers.next,.nav-links span.page-numbers.prev,.nav-links a.page-numbers.next,.nav-links a.page-numbers.prev,.woocommerce-pagination span.page-numbers.next,.woocommerce-pagination span.page-numbers.prev,.woocommerce-pagination a.page-numbers.next,.woocommerce-pagination a.page-numbers.prev{text-indent:-9999px;color:transparent;position:relative}.nav-links span.page-numbers.next:after,.nav-links span.page-numbers.prev:after,.nav-links a.page-numbers.next:after,.nav-links a.page-numbers.prev:after,.woocommerce-pagination span.page-numbers.next:after,.woocommerce-pagination span.page-numbers.prev:after,.woocommerce-pagination a.page-numbers.next:after,.woocommerce-pagination a.page-numbers.prev:after{content:"";position:absolute;top:0;right:0;bottom:0;left:0;margin:auto;width:9px;height:9px;border-top:2px solid #333;border-right:2px solid #333;transition:.2s}.nav-links span.page-numbers.next:after,.nav-links a.page-numbers.next:after,.woocommerce-pagination span.page-numbers.next:after,.woocommerce-pagination a.page-numbers.next:after{transform:rotate(45deg);left:-2px}.nav-links span.page-numbers.prev:after,.nav-links a.page-numbers.prev:after,.woocommerce-pagination span.page-numbers.prev:after,.woocommerce-pagination a.page-numbers.prev:after{transform:rotate(-135deg);right:-3px}.nav-links span.page-numbers:hover,.nav-links span.page-numbers.current,.nav-links a.page-numbers:hover,.nav-links a.page-numbers.current,.woocommerce-pagination span.page-numbers:hover,.woocommerce-pagination span.page-numbers.current,.woocommerce-pagination a.page-numbers:hover,.woocommerce-pagination a.page-numbers.current{background:#494932;color:#FFF;font-weight:bold}.nav-links span.page-numbers:hover.next:after,.nav-links span.page-numbers:hover.prev:after,.nav-links span.page-numbers.current.next:after,.nav-links span.page-numbers.current.prev:after,.nav-links a.page-numbers:hover.next:after,.nav-links a.page-numbers:hover.prev:after,.nav-links a.page-numbers.current.next:after,.nav-links a.page-numbers.current.prev:after,.woocommerce-pagination span.page-numbers:hover.next:after,.woocommerce-pagination span.page-numbers:hover.prev:after,.woocommerce-pagination span.page-numbers.current.next:after,.woocommerce-pagination span.page-numbers.current.prev:after,.woocommerce-pagination a.page-numbers:hover.next:after,.woocommerce-pagination a.page-numbers:hover.prev:after,.woocommerce-pagination a.page-numbers.current.next:after,.woocommerce-pagination a.page-numbers.current.prev:after{border-top:2px solid #FFF;border-right:2px solid #FFF}table{width:100%}table thead{border-bottom:solid 1px #D8D8D8}table tfoot{border-top:solid 1px #D8D8D8}table th,table td{text-align:left}table th,table tfoot td{font-weight:bold;padding:15px}table td{padding:15px}.gallery{flex-wrap:wrap;list-style:none !important;padding:0 !important}.gallery li{width:calc((100% - 20px) / 2);margin:0 10px 10px 0;flex-grow:1;flex-direction:column}
    @media (max-width: 768px){.gallery li:nth-child(2n){margin:0 0 10px 0}}.gallery figure{align-items:flex-end;justify-content:flex-start;height:100%;color:#FFF}.gallery figcaption{right:0;bottom:0;left:0;z-index:2;opacity:1;line-height:1.3em;padding-right:50px}.gallery img{display:block;width:100%;height:100%;flex:1;-o-object-fit:cover;object-fit:cover}.off-canvas-panel{position:fixed;z-index:100;top:0;right:0;bottom:0;left:0;display:none}.off-canvas-panel__wrapper{position:absolute;top:0;bottom:0;z-index:101;width:100%;max-width:400px;background:#FFF;box-shadow:-10px 2px 30px 0 rgba(0,0,0,0.05)}.off-canvas-panel__wrapper--left{left:0}.off-canvas-panel__wrapper--right{right:0}.off-canvas-panel__header{margin-bottom:20px;border-bottom:solid 1px #D8D8D8}.off-canvas-panel__close{right:0;top:0;background:transparent;padding:0 0 0 1.5em;width:45px;height:100%;-webkit-appearance:none;-moz-appearance:none;appearance:none;border:none}.off-canvas-panel__close:before,.off-canvas-panel__close:after{position:absolute;top:9px;right:5px;content:' ';height:14px;width:2px;background-color:#333;transition:.2s}.off-canvas-panel__close:before{transform:rotate(45deg)}.off-canvas-panel__close:after{transform:rotate(-45deg)}.off-canvas-panel__close:hover{background:transparent}.off-canvas-panel__close:hover:before,.off-canvas-panel__close:hover:after{background-color:#595959}.off-canvas-panel__overlay{position:fixed;top:0;right:0;bottom:0;left:0;background:rgba(247,244,244,0.5);z-index:99}.off-canvas-panel__cancel{width:100%}.badge{width:80px;height:80px;padding:5px;-webkit-hyphens:auto;-ms-hyphens:auto;hyphens:auto;top:15px;left:15px;z-index:5}.global-message a{text-decoration:underline}.copyright:hover .copyright__holder{visibility:visible;opacity:1}.copyright__icon{line-height:1em;right:0;bottom:0;z-index:3;font-size:19px;color:#FFF !important}.copyright__holder{right:20px;bottom:50px;visibility:hidden;opacity:0;transition:.2s;background:#FFF;border-radius:4px;white-space:nowrap;color:#333;font-size:13px;line-height:normal;max-width:calc(100% - 40px);z-index:3}
    @media (max-width: 480px){.copyright__icon{padding:10px !important}.copyright__holder{right:10px;bottom:40px}}.language-list figure,.language-list svg{width:16px;height:16px}.tooltip__text{visibility:hidden;width:120px;background-color:#555;color:#FFF;text-align:center;font-size:14px;line-height:initial;border-radius:6px;padding:5px;position:absolute;z-index:1;bottom:150%;left:50%;margin-left:-60px;opacity:0;transition:.2s}.tooltip__text:after{content:"";position:absolute;top:100%;left:50%;margin-left:-5px;border-width:5px;border-style:solid;border-color:#555 transparent transparent transparent}.tooltip__text:hover,.tooltip__text .tooltip--clicked{visibility:visible;opacity:1}.timeline{margin-top:20px !important}.timeline:before{content:"";display:block;position:absolute;background:#494932;width:100%;height:1px;top:23px}.timeline figure{position:relative;z-index:2;background:#F7F4F4;height:50px;width:50px;border-radius:50%;margin:0 auto 10px auto}.timeline p{margin:0;line-height:1.6em}.timeline__item{padding:0 10px}
    @media (min-width: 768px){.timeline{display:flex}.timeline:before{width:calc(100% - 228px);left:106px}.timeline figure{width:80px}}
    @media (max-width: 768px){.timeline{text-align:left}.timeline:before{content:"";position:absolute;top:10px;left:26px;width:1px;height:calc(100% - 33px)}.timeline figure{width:34px;text-align:left;margin:0 15px 0 0}.timeline svg{width:34px}.timeline__item{display:flex;align-items:center;margin:10px 0}.timeline__item:first-child{margin-top:0}.timeline__item:lastchild{margin-bottom:0}.search-place-icon svg{height:34px}}.container,.wp-block-group__inner-container{margin-left:auto;margin-right:auto;padding-left:15px;padding-right:15px;width:100%;zoom:1}.container:after,.wp-block-group__inner-container:after{content:"";clear:both;display:table}.container.grid-3xl,.wp-block-group__inner-container.grid-3xl{max-width:1670px}.container.grid-2xl,.wp-block-group__inner-container.grid-2xl{max-width:1290px}.container.grid-xl,.wp-block-group__inner-container.grid-xl{max-width:1090px}.container.grid-lg,.wp-block-group__inner-container.grid-lg{max-width:990px}.container.grid-md,.wp-block-group__inner-container.grid-md{max-width:790px}
    @media screen and (min-width: 480px){.col-sm-12,.col-sm-11,.col-sm-10,.col-sm-9,.col-sm-8,.col-sm-7,.col-sm-6,.col-sm-5,.col-sm-4,.col-sm-3,.col-sm-2,.col-sm-1{flex:none}.col-sm-12{width:100%}.col-sm-11{width:91.66666667%}.col-sm-10{width:83.33333333%}.col-sm-9{width:75%}.col-sm-8{width:66.66666667%}.col-sm-7{width:58.33333333%}.col-sm-6{width:50%}.col-sm-5{width:41.66666667%}.col-sm-4{width:33.33333333%}.col-sm-3{width:25%}.col-sm-2{width:16.66666667%}.col-sm-1{width:8.33333333%}.offset-sm-1{margin-left:8.33333333%}.offset-sm-2{margin-left:16.66666667%}.offset-sm-3{margin-left:25%}.offset-sm-4{margin-left:33.33333333%}.offset-sm-5{margin-left:41.66666667%}.offset-sm-6{margin-left:50%}.offset-sm-7{margin-left:58.33333333%}.offset-sm-8{margin-left:66.66666667%}.offset-sm-9{margin-left:75%}.offset-sm-10{margin-left:83.33333333%}.offset-sm-11{margin-left:91.66666667%}}
    @media screen and (min-width: 768px){.container{padding-left:20px;padding-right:20px}.container.grid-3xl{max-width:1680px}.container.grid-2xl{max-width:1300px}.container.grid-xl{max-width:1100px}.container.grid-lg{max-width:1000px}.container.grid-md{max-width:800px}.container.grid-sm{max-width:520px}.columns{margin-left:-20px;margin-right:-20px}.column{padding-left:20px;padding-right:20px}.col-md-12,.col-md-11,.col-md-10,.col-md-9,.col-md-8,.col-md-7,.col-md-6,.col-md-5,.col-md-4,.col-md-3,.col-md-2,.col-md-1{flex:none}.col-md-12{width:100%}.col-md-11{width:91.66666667%}.col-md-10{width:83.33333333%}.col-md-9{width:75%}.col-md-8{width:66.66666667%}.col-md-7{width:58.33333333%}.col-md-6{width:50%}.col-md-5{width:41.66666667%}.col-md-4{width:33.33333333%}.col-md-3{width:25%}.col-md-2{width:16.66666667%}.col-md-1{width:8.33333333%}.offset-md-1{margin-left:8.33333333%}.offset-md-2{margin-left:16.66666667%}.offset-md-3{margin-left:25%}.offset-md-4{margin-left:33.33333333%}.offset-md-5{margin-left:41.66666667%}.offset-md-6{margin-left:50%}.offset-md-7{margin-left:58.33333333%}.offset-md-8{margin-left:66.66666667%}.offset-md-9{margin-left:75%}.offset-md-10{margin-left:83.33333333%}.offset-md-11{margin-left:91.66666667%}}
    @media screen and (min-width: 960px){.col-lg-12,.col-lg-11,.col-lg-10,.col-lg-9,.col-lg-8,.col-lg-7,.col-lg-6,.col-lg-5,.col-lg-4,.col-lg-3,.col-lg-2,.col-lg-1{flex:none}.col-lg-12{width:100%}.col-lg-11{width:91.66666667%}.col-lg-10{width:83.33333333%}.col-lg-9{width:75%}.col-lg-8{width:66.66666667%}.col-lg-7{width:58.33333333%}.col-lg-6{width:50%}.col-lg-5{width:41.66666667%}.col-lg-4{width:33.33333333%}.col-lg-3{width:25%}.col-lg-2{width:16.66666667%}.col-lg-1{width:8.33333333%}.offset-lg-1{margin-left:8.33333333%}.offset-lg-2{margin-left:16.66666667%}.offset-lg-3{margin-left:25%}.offset-lg-4{margin-left:33.33333333%}.offset-lg-5{margin-left:41.66666667%}.offset-lg-6{margin-left:50%}.offset-lg-7{margin-left:58.33333333%}.offset-lg-8{margin-left:66.66666667%}.offset-lg-9{margin-left:75%}.offset-lg-10{margin-left:83.33333333%}.offset-lg-11{margin-left:91.66666667%}}
    @media screen and (min-width: 1060px){.col-xl-12,.col-xl-11,.col-xl-10,.col-xl-9,.col-xl-8,.col-xl-7,.col-xl-6,.col-xl-5,.col-xl-4,.col-xl-3,.col-xl-2,.col-xl-1{flex:none}.col-xl-12{width:100%}.col-xl-11{width:91.66666667%}.col-xl-10{width:83.33333333%}.col-xl-9{width:75%}.col-xl-8{width:66.66666667%}.col-xl-7{width:58.33333333%}.col-xl-6{width:50%}.col-xl-5{width:41.66666667%}.col-xl-4{width:33.33333333%}.col-xl-3{width:25%}.col-xl-2{width:16.66666667%}.col-xl-1{width:8.33333333%}}
    @media screen and (min-width: 1260px){.col-2xl-12,.col-2xl-11,.col-2xl-10,.col-2xl-9,.col-2xl-8,.col-2xl-7,.col-2xl-6,.col-2xl-5,.col-2xl-4,.col-2xl-3,.col-2xl-2,.col-2xl-1{flex:none}.col-2xl-12{width:100%}.col-2xl-11{width:91.66666667%}.col-2xl-10{width:83.33333333%}.col-2xl-9{width:75%}.col-2xl-8{width:66.66666667%}.col-2xl-7{width:58.33333333%}.col-2xl-6{width:50%}.col-2xl-5{width:41.66666667%}.col-2xl-4{width:33.33333333%}.col-2xl-3{width:25%}.col-2xl-2{width:16.66666667%}.col-2xl-1{width:8.33333333%}}.show-xs,.show-sm,.show-md,.show-lg{display:none !important}
    @media (min-width: 1200px){.my-sm{margin-bottom:30px}}.my-md{margin-top:30px;margin-bottom:30px;margin-top:30px;margin-bottom:30px}
    @media (min-width: 320px){.my-md{margin-top:calc(30px + 20 * (100vw - 320px) / 880)}}
    @media (min-width: 1200px){.my-md{margin-top:50px}}
    @media (min-width: 320px){.my-md{margin-bottom:calc(30px + 20 * (100vw - 320px) / 880)}}
    @media (min-width: 1200px){.my-md{margin-bottom:50px}}.my-lg{margin-top:40px;margin-bottom:40px;margin-top:40px;margin-bottom:40px}
    @media (min-width: 320px){.my-lg{margin-top:calc(40px + 50 * (100vw - 320px) / 880)}}
    @media (min-width: 1200px){.my-lg{margin-top:90px}}
    @media (min-width: 320px){.my-lg{margin-bottom:calc(40px + 50 * (100vw - 320px) / 880)}}.section-padding,.wp-block-group.has-background{padding:40px 0;padding:10vh 0}.full-width,.alignfull{margin-left:calc(-100vw / 2 + 100% / 2);margin-right:calc(-100vw / 2 + 100% / 2);width:100vw}.bg-color-4{background:#F7F4F4}
    @media (max-width: 480px){.hero{padding-top:30px}}.hero:after{content:"";position:absolute;top:0;right:0;bottom:0;left:0;background:rgba(0,0,0,0.5);z-index:1}.hero h1,.hero p{color:#FFF}.hero .logo svg{width:auto;height:80px}.hero .logo svg path{fill:#FFF}.hero .greeting-marketplace-form{width:100%;max-width:550px}.hero .greeting-marketplace-form input[type="search"]{height:50px}.hero .greeting-marketplace-form input[type="submit"]{width:60px}.hero .greeting-marketplace-pin{top:16px}.hero .btn-1{margin-top:15px;min-width:220px}
    @media (max-width: 480px){.hero .btn-1{width:100%}}.hero__content{position:relative;z-index:2}.blog-post-loop h3{transition:.2s}.blog-post-loop a:hover h3{color:#494932}.blog-post__author-meta p{margin:0 0 1em 0}.blog-post__author-image figure{width:150px}.comment-list .depth-2,.comment-list .depth-3,.comment-list .depth-4{margin-left:1.5em}.comment-list .comment-body{margin-bottom:2em}.comment-list time{color:#333;opacity:0.75}.comment-list .comment-edit-link{margin-left:5px}.comment-list .comment-reply-link{background:#494932;color:#FFF;padding:5px 14px;border-radius:4px;font-size:14px;font-weight:bold}.comment-list .comment-reply-link:hover{background:#713447}.comment-list .comment-reply-link:active,.comment-list .comment-reply-link:focus{background:#6a3143}.comment-list .children .comment.bypostauthor{position:relative}.comment-list .children .comment.bypostauthor:before{content:"";position:absolute;width:2px;height:100%;left:-24px;background:#494932}.comment-list .comment-awaiting-moderation{display:block;padding:10px;background:#F7F4F4}.search-form-wrapper label{margin:10px 0 0 0}.search-form-wrapper .search-submit{width:100%;margin-top:10px}.search-form-wrapper .search-field{height:100%}
    /** how it works end */
</style>

<div id="content" class="rigid-right-sidebar" >
	<div class="inner">
		<!-- CONTENT WRAPPER -->
		<div id="main" class="fixed box box-common">
			<div class="content_holder">
				<div id="post-12" class="post-12 page type-page status-publish hentry">
                    <div data-vc-full-width="true" data-vc-full-width-init="false" class="vc_row wpb_row vc_row-fluid vc_custom_1509877871727 vc_row-has-fill rigid-align-center">
	                    <div class="wpb_column vc_column_container vc_col-sm-12">
                            <div class="vc_column-inner">
                                <div class="wpb_wrapper">
                                    <div class="vc_row wpb_row vc_inner vc_row-fluid">
	                                    <div class="wpb_column vc_column_container vc_col-sm-2">
                                            <div class="vc_column-inner">
                                                <div class="wpb_wrapper">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wpb_column vc_column_container vc_col-sm-8">
                                            <div class="vc_column-inner">
                                                <div class="wpb_wrapper">
	                                                <div class="wpb_text_column wpb_content_element  vc_custom_1509711703006">
		                                                <div class="wpb_wrapper">
			                                                <h1 class="slogan-before-search">
                                                        Skal vi levere en gavehilsen til én, du holder af?
                                                      </h1>
		                                                </div>
                                                    </div>
                                                    <div class="top-area wpb_widgetised_column wpb_content_element">
		                                                <div class="wpb_wrapper">
			                                                <div id="woocommerce_product_search-2" class="widget box woocommerce widget_product_search">
                                                                <form role="search" method="get" autocomplete="off" id="searchform">
                                                                    <div>
                                                                        <input type="text" name="keyword" id="frontSearchGr_new" autocomplete="off" placeholder="Indtast by eller postnr. (f.eks. '8000' el. 'Aarhus') og find lokale butikker"></input>
                                                                    </div>
                                                                </form>
                                                                <div id="datafetch_wrapper">
                                                                  <div id="datafetch"></div>
                                                                </div>
                                                                <div class="recommandations">
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
                                                                    <a class="vc_general vc_btn3 vc_btn3-size-sm vc_btn3-shape-round vc_btn3-style-custom vc_btn3-icon-left" href="<?php echo get_permalink($landing_page_id);?>" title=""><i class="vc_btn3-icon vc_li vc_li-t-shirt"></i> <?php echo get_post_meta($landing_page_id, 'postalcode', true); echo " "; echo get_post_meta($landing_page_id, 'city', true);?></a>
                                                                        <?php if($key+1 == $page_id_array_midle_celling){
                                                                            echo "<br/>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="wpb_text_column wpb_content_element  vc_custom_1509712827620" >
                                                        <div class="wpb_wrapper">
                                                            &nbsp;
                                                        </div>
                                                    </div>
                                                    <div id="cityShowArea" class="vc_btn3-container vc_btn3-inline" >
                                                        <a style="color:fff;" class="vc_general vc_btn3 vc_btn3-size-sm vc_btn3-shape-round vc_btn3-style-custom vc_btn3-icon-left" title="">
                                                            &nbsp;
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wpb_column vc_column_container vc_col-sm-2">
                                            <div class="vc_column-inner">
                                                <div class="wpb_wrapper">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="vc_row-full-width vc_clearfix">
                    </div>
                    <!--how it works begin-->
                    <section id="how-it-works-block" class="how-it-works my-lg section-padding bg-color-4 full-width aligncenter no-margin">
	                    <div class="container grid-md text-center">
                            <h2 class="how-it-works-header">Sådan fungerer det</h2>
                            <p class="how-it-works-paragraph">Når du sender gaver via Greeting.dk, handler du hos fysiske specialbutikker</p>
							    </div>
	                <div class="container grid-xl text-center">
    					        <ul class="timeline rel list-none my-md">
    							    <li class="timeline__item">
    					                <figure class="search-place-icon flex flex-cy flex-cx"><svg width="33" height="44" viewBox="0 0 33 44" xmlns="http://www.w3.org/2000/svg"><path d="M22.917 20.706c1.129-1.412 1.833-3.177 1.833-5.123 0-4.548-3.701-8.25-8.25-8.25-4.549 0-8.25 3.702-8.25 8.25 0 4.549 3.701 8.25 8.25 8.25 1.943 0 3.709-.704 5.12-1.831l7.064 7.064a.92.92 0 001.296 0 .917.917 0 000-1.296l-7.063-7.064zM16.5 22a6.424 6.424 0 01-6.417-6.417A6.424 6.424 0 0116.5 9.167a6.424 6.424 0 016.417 6.416A6.424 6.424 0 0116.5 22zm0-22C7.907 0 .917 6.99.917 15.583c0 15.067 14.371 27.665 14.983 28.193a.92.92 0 001.203.002c.238-.207 5.894-5.139 10.217-12.518a.917.917 0 10-1.584-.928c-3.362 5.74-7.67 10.042-9.234 11.51-2.717-2.56-13.75-13.713-13.75-26.259 0-7.582 6.167-13.75 13.75-13.75 7.582 0 13.75 6.168 13.75 13.75 0 2.512-.45 5.143-1.331 7.818a.917.917 0 001.74.574c.944-2.862 1.422-5.684 1.422-8.392C32.083 6.991 25.093 0 16.5 0z" fill="#494932"/></svg></figure>
    					                <p>Søg på modtagerens adresse</p>
    				                </li>
    							    <li class="timeline__item">
    					                <figure class="shop-icon flex flex-cy flex-cx"><svg width="44" height="44" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg"><g fill="#494932"><path d="M42.167 44H1.833a.917.917 0 01-.916-.917A4.59 4.59 0 015.5 38.5h33a4.59 4.59 0 014.583 4.583c0 .506-.41.917-.916.917zM2.906 42.167h38.186a2.757 2.757 0 00-2.594-1.834H5.5a2.757 2.757 0 00-2.594 1.834zm31.927-33H9.167a.917.917 0 01-.917-.917V4.583A4.59 4.59 0 0112.833 0h18.334a4.59 4.59 0 014.583 4.583V8.25c0 .506-.41.917-.917.917zm-24.75-1.834h23.834v-2.75a2.753 2.753 0 00-2.75-2.75H12.833a2.753 2.753 0 00-2.75 2.75v2.75z"/><path d="M7.333 22a4.59 4.59 0 01-4.583-4.583c0-.167.044-.33.13-.472l5.5-9.166a.917.917 0 01.787-.446h3.666a.916.916 0 01.899 1.097l-1.834 9.166C11.917 19.943 9.86 22 7.333 22zm-2.74-4.347a2.755 2.755 0 002.74 2.514 2.753 2.753 0 002.75-2.75l1.634-8.25H9.685l-5.093 8.486zM22 22a4.59 4.59 0 01-4.583-4.583V8.25c0-.506.41-.917.916-.917h7.334c.506 0 .916.411.916.917v9.167A4.59 4.59 0 0122 22zM19.25 9.167v8.25a2.753 2.753 0 002.75 2.75 2.753 2.753 0 002.75-2.75v-8.25h-5.5z"/><path d="M14.667 22a4.59 4.59 0 01-4.584-4.583l1.852-9.347a.917.917 0 01.898-.737h5.5c.506 0 .917.411.917.917v9.167A4.59 4.59 0 0114.667 22zM13.585 9.167l-1.687 8.43c.019 1.336 1.252 2.57 2.769 2.57a2.753 2.753 0 002.75-2.75v-8.25h-3.832zM36.667 22a4.59 4.59 0 01-4.584-4.583L30.268 8.43a.92.92 0 01.899-1.097h3.666c.323 0 .62.169.787.446l5.5 9.166c.086.142.13.305.13.472A4.59 4.59 0 0136.667 22zM32.285 9.167l1.613 8.07c.019 1.696 1.252 2.93 2.769 2.93a2.755 2.755 0 002.74-2.514l-5.092-8.486h-2.03z"/><path d="M29.333 22a4.59 4.59 0 01-4.583-4.583V8.25c0-.506.41-.917.917-.917h5.5c.436 0 .812.308.898.737l1.833 9.167C33.917 19.943 31.86 22 29.333 22zm-2.75-12.833v8.25a2.753 2.753 0 002.75 2.75 2.753 2.753 0 002.75-2.75l-1.666-8.25h-3.834z"/><path d="M36.667 40.333H7.333a.917.917 0 01-.916-.916V21.083a.917.917 0 011.833 0V38.5h27.5V21.083a.917.917 0 011.833 0v18.334c0 .506-.41.916-.916.916z"/><path d="M20.167 34.833H11a.917.917 0 01-.917-.916V24.75c0-.506.411-.917.917-.917h9.167c.506 0 .916.411.916.917v9.167c0 .506-.41.916-.916.916zM11.917 33h7.333v-7.333h-7.333V33zM33 40.333h-9.167a.917.917 0 01-.916-.916V24.75c0-.506.41-.917.916-.917H33c.506 0 .917.411.917.917v14.667a.917.917 0 01-.917.916zM24.75 38.5h7.333V25.667H24.75V38.5z"/></g></svg></figure>
    					                <p>Vælg gave fra en butik</p>
    				                </li>
    							    <li class="timeline__item">
    					                <figure class="pen-paper-icon flex flex-cy flex-cx"><svg width="41" height="42" viewBox="0 0 41 42" xmlns="http://www.w3.org/2000/svg"><g fill="#494932"><path d="M40.367 26.326l-3.385-3.385a.847.847 0 00-1.196 0L22.247 36.48a.852.852 0 00-.247.599v3.384c0 .467.38.846.846.846h3.385a.84.84 0 00.597-.248l10.149-10.15c.002 0 .003 0 .005-.003.002-.001.002-.003.003-.005l3.382-3.38a.847.847 0 000-1.197zM25.88 39.617h-2.188V37.43L33 28.12l2.188 2.188-9.308 9.308zm10.505-10.504l-2.189-2.188 2.189-2.188 2.188 2.188-2.188 2.188z"/><path d="M21.034 32.856L9.998 34.434 5.212 7.313l28.798-4.8 3.234 17.795a.847.847 0 001.665-.303L35.526 1.39a.849.849 0 00-.971-.684L23.943 2.474 2.61.696A.801.801 0 001.983.9a.844.844 0 00-.289.593L.002 31.954a.844.844 0 00.75.889l7.393.822.33 1.869a.845.845 0 00.95.69l11.846-1.692a.847.847 0 00.719-.958.85.85 0 00-.956-.718zM1.736 31.25l1.6-28.793 13.812 1.15L4.092 5.783a.844.844 0 00-.694.982l4.44 25.162-6.102-.678z"/></g></svg></figure>
    					                <p>Skriv en personlig hilsen </p>
    				                </li>
    							    <li class="timeline__item">
    					                <figure class="gift-icon flex flex-cy flex-cx"><svg width="44" height="41" viewBox="0 0 44 41" xmlns="http://www.w3.org/2000/svg"><g fill="#494932"><path d="M40.333 20.01H3.667a2.753 2.753 0 01-2.75-2.75v-5.5a2.753 2.753 0 012.75-2.75h36.666a2.753 2.753 0 012.75 2.75v5.5a2.753 2.753 0 01-2.75 2.75zM3.667 10.845a.917.917 0 00-.917.917v5.5c0 .506.41.916.917.916h36.666c.506 0 .917-.41.917-.916v-5.5a.917.917 0 00-.917-.917H3.667z"/><path d="M36.667 40.178H7.333a4.59 4.59 0 01-4.583-4.584v-16.5c0-.506.41-.917.917-.917h36.666c.506 0 .917.411.917.917v16.5a4.59 4.59 0 01-4.583 4.584zM4.583 20.01v15.583a2.753 2.753 0 002.75 2.75h29.334a2.753 2.753 0 002.75-2.75V20.011H4.583zM22 10.844c-4.431 0-8.404-2.962-9.665-7.205a2.664 2.664 0 01.43-2.37c.68-.911 1.874-1.326 2.947-1.007 4.242 1.262 7.205 5.236 7.205 9.665a.917.917 0 01-.917.917zm-7.046-8.86a.915.915 0 00-.718.381.842.842 0 00-.145.752c.939 3.155 3.713 5.445 6.934 5.835-.389-3.22-2.679-5.995-5.836-6.932a.794.794 0 00-.235-.036z"/><path d="M22 10.844a.917.917 0 01-.917-.916c0-4.432 2.963-8.405 7.205-9.666 1.067-.317 2.268.097 2.947 1.008.517.694.674 1.559.43 2.371-1.261 4.24-5.234 7.203-9.665 7.203zm7.046-8.86a.877.877 0 00-.235.034c-3.155.94-5.445 3.713-5.836 6.934 3.22-.389 5.995-2.678 6.932-5.835a.837.837 0 00-.145-.752.908.908 0 00-.716-.381z"/><path d="M22 40.178a.917.917 0 01-.917-.917V12.14l-3.934 3.935a.917.917 0 01-1.296-1.296l5.5-5.5a.908.908 0 01.999-.198c.341.14.565.475.565.845V39.26a.917.917 0 01-.917.916z"/><path d="M27.5 16.344a.92.92 0 01-.649-.268l-5.5-5.5a.917.917 0 011.296-1.296l5.5 5.5a.917.917 0 01-.647 1.564z"/></g></svg></figure>
    					                <p>Butikken pakker din gave flot ind</p>
    				                </li>
    							    <li class="timeline__item">
    					                <figure class="truck-icon flex flex-cy flex-cx"><svg width="46" height="39" viewBox="0 0 46 39" xmlns="http://www.w3.org/2000/svg"><path d="M45.771 21.638l-3.868-10.833a4.784 4.784 0 00-4.495-3.167H30.55V4.774A4.78 4.78 0 0025.777 0H4.774A4.78 4.78 0 000 4.774v26.732a2.869 2.869 0 002.864 2.864h2.962a4.783 4.783 0 004.676 3.819 4.783 4.783 0 004.676-3.82h17.378a4.783 4.783 0 004.676 3.82 4.783 4.783 0 004.676-3.82h1.054a2.865 2.865 0 002.863-2.863v-9.548a.92.92 0 00-.054-.32zM1.909 4.774a2.869 2.869 0 012.865-2.865h21.003a2.866 2.866 0 012.865 2.865v20.049H1.909V4.773zm8.593 31.505a2.869 2.869 0 01-2.864-2.864 2.869 2.869 0 012.864-2.864 2.866 2.866 0 012.864 2.864 2.866 2.866 0 01-2.864 2.864zm26.732 0a2.868 2.868 0 01-2.864-2.864 2.868 2.868 0 012.864-2.864 2.868 2.868 0 012.864 2.864 2.866 2.866 0 01-2.864 2.864zm6.683-4.773a.955.955 0 01-.955.954h-1.05a4.783 4.783 0 00-4.676-3.818 4.783 4.783 0 00-4.676 3.818H15.18a4.783 4.783 0 00-4.676-3.818 4.783 4.783 0 00-4.676 3.818H2.864a.955.955 0 01-.955-.954v-4.774h27.687a.955.955 0 00.955-.955V9.547h6.855c1.207 0 2.291.764 2.698 1.9l3.813 10.676v9.383zM34.37 19.094v-6.683a.955.955 0 00-1.91 0v7.638c0 .527.428.955.955.955h6.683a.955.955 0 000-1.91H34.37z" fill="#494932"/></svg></figure>
    					                <p>Gaven leveres til din modtager</p>
    				                </li>
    						    </ul>
							      <a class="btn-1" href="https://greeting.dk/saadan-fungerer-det/" target="" title="Læs mere">Læs mere</a>
			          </div>
              </section>
        </div>
        <div class="clear">
        </div>

        <div id="comments">
        </div><!-- #comments -->
</div><!-- SIDEBARS -->
<!-- END OF IDEBARS -->
<div class="clear"></div>
<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('content', 'page'); ?>
<?php endwhile; ?>
        </div>
    </div>
</div><!-- END OF MAIN CONTENT -->

<?php
get_footer();
