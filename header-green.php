<?php
$cart_count = WC()->cart->cart_contents_count; // Set variable for cart item count
$cart_url = wc_get_cart_url();  // Set Cart URL
?>

<section id="top" class="general bg-teal pt-1">
    <div class="container py-4">
      <div class="row align-items-center">
        <div class="d-flex pb-3 pb-lg-0 pb-xl-0 position-relative justify-content-center justify-content-lg-start justify-content-xl-start col-md-12 col-lg-3">
          <a href="<?php echo home_url(); ?>" title="Gå til forsiden af Greeting.dk" aria-label="Gå til forsiden af Greeting.dk">
            <div>
              <svg viewBox="0 0 524 113" width="175" fill="#ffffff"  xmlns="http://www.w3.org/2000/svg">
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
            <div style="margin-top: -3px">
              <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="150" viewBox="0 0 1339.000000 71.000000" fill="#ffffff">
                <g transform="translate(0.000000,71.000000) scale(0.100000,-0.100000)"  stroke="none">
                  <path d="M3080 684 c-96 -30 -142 -109 -119 -199 19 -71 58 -97 216 -147 105 -32 153 -66 153 -107 0 -63 -58 -101 -153 -101 -73 0 -119 23 -147 75 -13 24 -23 30 -51 30 -33 0 -34 -1 -33 -38 4 -106 178 -176 329 -132 76 22 129 72 140 132 17 104 -26 154 -171 202 -139 45 -180 67 -194 100 -28 68 25 121 120 121 68 0 98 -15 129 -63 21 -32 29 -37 64 -37 39 0 39 0 33 33 -22 113 -175 176 -316 131z"/>
                  <path d="M7484 691 c-88 -23 -138 -84 -138 -168 0 -91 46 -130 218 -184 140 -43 185 -94 140 -157 -25 -36 -68 -52 -136 -52 -75 0 -118 22 -150 76 -18 30 -25 35 -52 32 -72 -7 -28 -111 66 -159 22 -11 70 -23 107 -26 184 -15 310 100 256 235 -23 56 -51 74 -188 120 -132 44 -164 62 -173 97 -17 68 34 115 126 115 65 0 111 -24 135 -70 14 -27 20 -31 53 -28 34 3 37 5 35 31 -3 39 -46 93 -94 118 -45 22 -154 33 -205 20z"/>
                  <path d="M8362 685 c-61 -19 -106 -57 -133 -112 -22 -44 -24 -61 -24 -198 0 -138 2 -154 24 -198 28 -57 73 -93 137 -113 128 -38 264 9 316 109 18 34 22 59 23 132 l0 90 -117 3 -118 3 0 -36 0 -35 76 0 76 0 -4 -55 c-8 -94 -66 -145 -163 -145 -63 0 -114 25 -140 70 -17 31 -20 52 -20 175 0 123 3 144 20 175 26 44 77 70 138 70 64 0 113 -24 144 -72 22 -33 31 -38 64 -38 33 0 39 3 39 20 0 58 -72 131 -152 155 -62 18 -128 18 -186 0z"/>
                  <path d="M35 677 c-3 -7 -4 -147 -3 -312 l3 -300 205 0 205 0 0 35 0 35 -167 3 -168 2 0 100 0 99 153 3 152 3 0 35 0 35 -152 3 -153 3 0 94 0 95 163 2 162 3 3 38 3 37 -201 0 c-152 0 -202 -3 -205 -13z"/>
                  <path d="M605 677 c-3 -7 -4 -147 -3 -312 l3 -300 40 0 40 0 5 225 5 224 149 -227 149 -228 36 3 36 3 0 310 0 310 -37 3 -38 3 0 -230 c0 -127 -3 -231 -7 -231 -5 0 -75 104 -157 230 -146 226 -149 230 -182 230 -19 0 -37 -6 -39 -13z"/>
                  <path d="M1505 678 c-3 -7 -4 -148 -3 -313 l3 -300 40 0 40 0 3 138 3 137 154 0 154 0 3 -137 3 -138 40 0 40 0 0 310 0 310 -40 0 -40 0 -3 -132 -3 -133 -154 0 -154 0 -3 133 -3 132 -38 3 c-24 2 -39 -1 -42 -10z"/>
                  <path d="M2175 678 c-3 -7 -4 -148 -3 -313 l3 -300 40 0 40 0 0 310 0 310 -38 3 c-24 2 -39 -1 -42 -10z"/>
                  <path d="M2445 678 c-3 -7 -4 -148 -3 -313 l3 -300 200 0 200 0 0 35 0 35 -157 3 -158 3 -2 272 -3 272 -38 3 c-24 2 -39 -1 -42 -10z"/>
                  <path d="M3565 678 c-3 -7 -4 -148 -3 -313 l3 -300 208 -3 208 -2 -3 37 -3 38 -162 3 -163 2 0 100 0 99 153 3 152 3 3 29 c2 16 -2 32 -10 37 -7 5 -77 9 -155 9 l-143 0 0 95 0 95 154 0 c165 0 181 5 174 52 l-3 23 -203 3 c-157 2 -204 0 -207 -10z"/>
                  <path d="M4140 374 l0 -315 38 3 37 3 5 228 5 229 152 -231 c150 -227 153 -231 186 -231 33 0 35 2 38 38 2 20 3 162 1 315 l-3 278 -37 -3 -37 -3 -5 -231 -5 -230 -150 233 -150 232 -37 1 -38 0 0 -316z"/>
                  <path d="M5285 678 c-3 -7 -4 -148 -3 -313 l3 -300 165 0 c151 0 169 2 207 22 84 45 105 103 105 294 0 134 -1 142 -28 197 -24 47 -38 61 -79 82 -45 23 -62 25 -207 28 -126 3 -159 1 -163 -10z m315 -86 c62 -31 75 -68 75 -217 0 -207 -25 -235 -204 -235 l-101 0 0 235 0 235 98 0 c72 0 106 -4 132 -18z"/>
                  <path d="M5932 378 l3 -313 205 0 205 0 0 35 0 35 -168 3 -168 2 2 100 1 99 152 3 151 3 0 35 0 35 -152 3 -153 3 0 94 0 95 163 2 162 3 3 38 3 37 -206 0 -205 0 2 -312z"/>
                  <path d="M6505 677 c-3 -7 -4 -147 -3 -312 l3 -300 40 0 40 0 3 122 3 123 79 0 79 0 71 -125 71 -125 40 0 c28 0 39 4 39 15 0 9 -30 68 -67 132 -63 108 -66 117 -49 127 74 44 106 95 106 170 0 88 -43 147 -124 171 -65 20 -324 21 -331 2z m266 -67 c68 -13 99 -44 99 -101 0 -54 -23 -95 -61 -108 -18 -6 -74 -11 -125 -11 l-94 0 0 115 0 115 64 0 c35 0 88 -4 117 -10z"/>
                  <path d="M7955 678 c-3 -7 -4 -148 -3 -313 l3 -300 40 0 40 0 0 310 0 310 -38 3 c-24 2 -39 -1 -42 -10z"/>
                  <path d="M8870 665 c0 -14 0 -142 0 -285 0 -143 0 -273 0 -290 l0 -30 206 0 205 0 -3 38 -3 37 -162 3 -163 2 0 100 0 99 153 3 152 3 3 29 c2 16 -2 32 -10 37 -7 5 -77 9 -155 9 l-143 0 0 95 0 95 153 0 c83 0 158 4 165 9 8 5 12 21 10 37 l-3 29 -202 3 -203 2 0 -25z"/>
                  <path d="M9440 376 l0 -316 39 0 c26 0 41 5 45 16 3 9 6 65 6 125 l0 109 78 0 78 0 70 -122 c65 -116 72 -123 103 -126 60 -6 58 9 -17 140 l-71 123 34 17 c66 34 103 111 91 190 -9 61 -38 103 -88 130 -39 20 -59 23 -205 26 l-163 4 0 -316z m318 220 c58 -30 67 -129 16 -177 -23 -22 -36 -24 -135 -27 l-109 -4 0 118 0 117 99 -6 c60 -3 110 -11 129 -21z"/>
                  <path d="M10305 678 c-3 -7 -4 -148 -3 -313 l3 -300 40 0 40 0 3 225 3 225 78 -150 c78 -148 79 -150 112 -150 34 0 35 2 109 147 41 82 79 148 83 148 4 0 7 -87 7 -192 0 -106 -1 -208 0 -226 0 -32 1 -33 38 -30 l37 3 0 310 0 310 -38 0 -39 0 -96 -182 c-54 -101 -99 -183 -102 -183 -3 0 -48 82 -100 183 l-96 182 -37 3 c-24 2 -39 -1 -42 -10z"/>
                  <path d="M11045 678 c-3 -7 -4 -148 -3 -313 l3 -300 208 -3 208 -2 -3 37 -3 38 -162 3 -163 2 0 100 0 99 153 3 c150 3 152 3 155 26 7 47 -9 52 -164 52 l-144 0 0 95 0 95 154 0 c165 0 181 5 174 52 l-3 23 -203 3 c-157 2 -204 0 -207 -10z"/>
                  <path d="M11620 376 l0 -316 40 0 40 0 0 125 0 125 83 0 82 0 70 -123 c66 -115 72 -122 104 -125 18 -2 38 1 43 6 7 7 -15 53 -62 133 -39 68 -67 125 -61 127 6 2 25 13 42 25 49 33 74 82 74 147 0 75 -29 128 -86 160 -41 23 -55 25 -206 28 l-163 4 0 -316z m313 223 c28 -13 57 -63 57 -99 0 -34 -28 -78 -60 -95 -20 -10 -59 -15 -130 -15 l-100 0 0 108 c0 60 3 112 8 117 10 11 194 -2 225 -16z"/>
                  <path d="M12235 678 c-3 -7 -4 -148 -3 -313 l3 -300 208 -3 208 -2 -3 37 -3 38 -162 3 -163 2 0 100 0 99 153 3 c150 3 152 3 155 26 7 47 -9 52 -164 52 l-144 0 0 95 0 95 154 0 c165 0 181 5 174 52 l-3 23 -203 3 c-157 2 -204 0 -207 -10z"/>
                  <path d="M4784 162 c-9 -5 -34 -122 -34 -157 0 -3 15 -5 32 -3 30 3 35 8 61 73 15 38 25 75 23 82 -6 14 -63 18 -82 5z"/>
                  <path d="M12797 164 c-4 -4 -7 -29 -7 -56 l0 -48 51 0 50 0 -3 53 -3 52 -40 3 c-23 2 -44 0 -48 -4z"/>
                  <path d="M13044 156 c-3 -8 -4 -31 -2 -52 l3 -39 50 0 50 0 3 38 c2 21 -2 45 -9 53 -15 18 -88 19 -95 0z"/>
                  <path d="M13307 163 c-4 -3 -7 -28 -7 -55 l0 -48 45 0 45 0 0 55 0 55 -38 0 c-21 0 -42 -3 -45 -7z"/>
                </g>
              </svg>
            </div>
          </a>
          <a class="position-absolute top-0 start-0 me-4 ms-1 d-inline d-lg-none d-xl-none" title="Åbn sidemenu" aria-label="Åbn sidemenu" data-bs-toggle="offcanvas" href="#offcanvasMenu" role="button" aria-controls="offcanvasMenu">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#ffffff" class="bi bi-list" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg>
          </a>
          <a class="position-absolute top-0 end-0 me-4 d-inline d-lg-none d-xl-none  right-col text-end" href="<?php echo$cart_url; ?>">
            <span class="position-relative" aria-label="Se kurv">
              <svg width="21" height="23" viewBox="0 0 21 23" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.434 6.967H3.306l-1.418 14.47h17.346L17.82 6.967h-3.124c.065.828.097 1.737.097 2.729h-1.5c0-1.02-.031-1.927-.093-2.729H7.93a35.797 35.797 0 00-.093 2.729h-1.5c0-.992.032-1.9.097-2.729zm.166-1.5C7.126 1.895 8.443.25 10.565.25s3.44 1.645 3.965 5.217h4.65l1.708 17.47H.234l1.712-17.47H6.6zm6.432 0c-.407-2.65-1.27-3.717-2.467-3.717-1.196 0-2.06 1.066-2.467 3.717h4.934z" fill="#ffffff">
                </path>
              </svg>
              <span class="position-absolute start-50 top-0 badge rounded-circle text-white" style="background: #cea09f;"><?php echo $cart_count; ?></span>
            </span>
            <span class="d-inline px-lg-2 px-xl-3 hide-lg text-white">&nbsp;&nbsp;&nbsp;Kurv</span>
          </a>
        </div>
        <div class="col-md-12 col-lg-5 col-xl-6 align-middle">
          <form role="search" method="get" autocomplete="off" id="searchform" class="position-relative mx-5" >
            <label for="" class="screen-reader-text">Indtast det postnummer, du ønsker at sende en gave til - og se udvalget af butikker</label>
            <button type="submit" name="submit" aria-label="Søg efter by" Title="Gå til / søg efter by"  class="top-search-btn rounded-pill position-absolute border-0 end-0 bg-teal p-3 me-1"></button>
            <?php
            if(!empty($args['city']) && !empty($args['postalcode'])){
              $val = $args['postalcode'] . ' ' . $args['city'];
            } else {
              $val = '';
            }
            ?>

            <input type="hidden" name="__s_link" value="" id="hidden__s_link">
            <script type="text/javascript">
              jQuery(document).ready(function(){
                var postalcode = window.localStorage.getItem('postalcode');
                var city = window.localStorage.getItem('city');
                var pc_link = window.localStorage.getItem('city_link');

                var input_val = jQuery('input[name="keyword"]').val();

                if(!document.getElementById('front_Search-new_ucsa').value){
                  if(postalcode && city){
                    document.getElementById('front_Search-new_ucsa').value = postalcode+' '+city;
                  }
                }
                if(pc_link){
                  document.getElementById('hidden__s_link').value = pc_link;
                }

              });
            </script>
            <input type="text" name="keyword" class="top-search-input form-control rounded-pill border-0 py-2" id="front_Search-new_ucsa" value="<?php echo $val; ?>" placeholder="Indtast by eller postnr.">
            <ul id="datafetch_wrapper" class="d-none list-group position-relative recommandations position-absolute list-unstyled rounded w-100 bg-light bg-white" style="top: 42px; z-index: 100000;">
            </ul>
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
          <?php
          if ( is_user_logged_in() ) {
          ?>
            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="btn btn-create rounded text-white">Min konto</a>
          <?php
          } else {
          ?>
            <a href="<?php home_url(); ?>/log-ind" class="btn text-white">Log ind</a>
            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="btn btn-create rounded text-white">Opret</a>
          <?php
          }
          ?>
          <div class="btn position-relative ms-lg-0 ms-xl-1">
            <a href="<?php echo $cart_url; ?>">
              <span class="position-relative" aria-label="Se kurv">
                <svg width="21" height="23" viewBox="0 0 21 23" xmlns="http://www.w3.org/2000/svg">
                  <path d="M6.434 6.967H3.306l-1.418 14.47h17.346L17.82 6.967h-3.124c.065.828.097 1.737.097 2.729h-1.5c0-1.02-.031-1.927-.093-2.729H7.93a35.797 35.797 0 00-.093 2.729h-1.5c0-.992.032-1.9.097-2.729zm.166-1.5C7.126 1.895 8.443.25 10.565.25s3.44 1.645 3.965 5.217h4.65l1.708 17.47H.234l1.712-17.47H6.6zm6.432 0c-.407-2.65-1.27-3.717-2.467-3.717-1.196 0-2.06 1.066-2.467 3.717h4.934z" fill="#ffffff">
                  </path>
                </svg>
                <span class="position-absolute start-50 top-0 badge rounded-circle text-white" style="background: #cea09f;"><?php echo $cart_count; ?></span>
              </span>
              <span class="d-inline px-lg-2 px-xl-3 hide-lg text-white">Kurv</span>
            </a>
          </div>
        </div>
      </div>
    </div>
</section>
