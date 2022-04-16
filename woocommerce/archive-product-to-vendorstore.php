<?php
get_header();
?>        
<div id="content" class="has-sidebar rigid-right-sidebar" >
	<div id="rigid_page_title" class="rigid_title_holder" >
		<div class="inner fixed">

        <?php 
        global $wp_query;
        $cat = $wp_query->get_queried_object();
        $categoryId = $cat->term_id;
        $categoryName = $cat->name;        
            
        ?>
            <!-- BREADCRUMB -->
            <div class="breadcrumb"><a href="<?php echo site_url();?>">Home</a> <span class="rigid-breadcrumb-delimiter">/</span> Product Category <span class="rigid-breadcrumb-delimiter">/</span> <?php echo $categoryName;?></div>
            <!-- END OF BREADCRUMB -->
            <!-- TITLE -->
            <h1 class="heading-title">
                <?php
                $urlPath = $_SERVER["REQUEST_URI"];
                $withDeliveryZip = 0;

                if(str_contains($urlPath, '=')){
                    $withDeliveryZip = 1;
                }

                $categoryNameUcfirst = ucfirst($categoryName);

                if($withDeliveryZip == 0){
                    echo $categoryNameUcfirst;
                }

                $urlPathExp = explode("=", $urlPath);
                $deliveryZipFromUrlPath = array_pop($urlPathExp);

                if($withDeliveryZip == 1){
                    echo $categoryNameUcfirst. " In ZIP " .$deliveryZipFromUrlPath;
                }
                ?>
            </h1>
            <!-- END OF TITLE -->
		</div>
    </div>
        
    <div class="inner">
		<!-- CONTENT WRAPPER -->
		<div id="main" class="fixed box box-common">
            <!-- SIDEBARS -->
            <?php
            if (function_exists('dynamic_sidebar')) : ?>
            <div class="sidebar">
                <?php if (is_active_sidebar('right_sidebar')): ?>
                    <?php 
                        dynamic_sidebar('right_sidebar'); ?>
                <?php endif; ?>

                <!--Filter begin-->
                <span type="button" id="changeZip" style="border:1px solid green; border-radius: 12px; padding:4px 10px;cursor:pointer;">Change ZIP</span>

                <div style="float: left;">  
                    <span id="resetAllCategoryPage" style="border:1px solid salmon; border-radius: 12px; padding:4px 10px; margin-right:10px; cursor:pointer;">Reset All</span>
                </div>
                <div class="clear">
                </div>
                
                <!-- occasion filter-->
                <div class="vendor_sort_categorypage" style="margin:20px 0px !important;">
                    <p style="font-weight:500">Occasion</p>
                    <?php
                    
                    // if delivery zip empty
                    if($withDeliveryZip == 0){

                        // for used on occasion prepare here 
                        $occasionTermListArray = array();

                            // $vendorProducts = $vendor->get_products(array('fields' => 'ids'));
                            $categoryProducts = get_posts( array(
                                'post_type' => 'product',
                                'numberposts' => -1,
                                'post_status' => 'publish',
                                'fields' => 'ids',
                                'tax_query' => array(
                                   array(
                                      'taxonomy' => 'product_cat',
                                      'field' => 'term_id',
                                      'terms' => $categoryId, /*category ID*/
                                      'operator' => 'IN',
                                      )
                                   ),
                                ));
                                                
                            foreach ($categoryProducts as $productId) {
                                $occasionTermList = wp_get_post_terms($productId, 'occasion', array('fields' => 'ids'));
                                foreach($occasionTermList as $occasionTerm){
                                    array_push($occasionTermListArray, $occasionTerm);
                                }
                            }

                        $occasionTermListArrayUnique = array_unique($occasionTermListArray);

                        $args = array(
                            'taxonomy'   => "occasion",
                            // 'hide_empty' => 1,
                            // 'include'    => $ids
                        );
                        $productOccasions = get_terms($args);
                        foreach($productOccasions as $occasion){
                            foreach($occasionTermListArrayUnique as $occasionTerm){
                                if($occasionTerm == $occasion->term_id){ ?>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="type_categorypage" class="vendor_sort_categorypage_item" value="<?php echo $occasion->term_id; ?>"><?php echo $occasion->name; ?></label>
                                    </div>
                        <?php   }
                            }
                        }
                    }
                    // if delivery zip is not empty
                    else {
                        global $wpdb;

                        $userMetaQuery = $wpdb->get_results( "
                                SELECT * FROM {$wpdb->prefix}usermeta
                                WHERE meta_key = 'delivery_zips'
                            " );

                        $UserIdArrayForDeliveryZip = array();

                        foreach($userMetaQuery as $userMeta){
                            if (str_contains($userMeta->meta_value, $deliveryZipFromUrlPath)) {
                                array_push($UserIdArrayForDeliveryZip, $userMeta->user_id);
                            }
                        }

                        // for used on occasion prepare here 
                        $occasionTermListArray = array();

                        foreach ($UserIdArrayForDeliveryZip as $vendorId) {
                            $vendor = get_wcmp_vendor($vendorId);
                            $vendorProducts = $vendor->get_products(array('fields' => 'ids'));
                            foreach ($vendorProducts as $productId) {
                                $occasionTermList = wp_get_post_terms($productId, 'occasion', array('fields' => 'ids'));
                                foreach($occasionTermList as $occasionTerm){
                                    array_push($occasionTermListArray, $occasionTerm);
                                }
                            }
                        }
                        $occasionTermListArrayUnique = array_unique($occasionTermListArray);

                        $args = array(
                            'taxonomy'   => "occasion",
                        );
                        $productOccasions = get_terms($args);
                        foreach($productOccasions as $occasion){
                            foreach($occasionTermListArrayUnique as $occasionTerm){
                                if($occasionTerm == $occasion->term_id){ ?>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="type_categorypage" class="vendor_sort_categorypage_item" value="<?php echo $occasion->term_id; ?>"><?php echo $occasion->name; ?></label>
                                    </div>
                        <?php   }
                            }
                        }
                    }
                    ?>

                </div>

                <!-- delivery type filter-->
                <div class="vendor_sort_categorypage" style="margin-bottom:20px !important;">
                    <p style="font-weight:500">Delivery Type</p>
                    <?php
                    $args = array (
                        'role' => 'dc_vendor'
                    );
                    
                    // Create the WP_User_Query object
                    $userQuery = new WP_User_Query($args);
                    
                    // Get the results
                    $vendors = $userQuery->get_results();

                    $deliveryTypeArray = array();

                    foreach($vendors as $vendor){
                        $userId = $vendor->ID;
                        // check if meta data is exist
                        if ( metadata_exists( 'user', $userId, 'delivery_type' ) ) {
                            $userMetas = get_user_meta($userId, 'delivery_type', true);
                        } else {
                            $userMetas = [];
                        }
                        
                        foreach($userMetas as $deliveryType){
                            array_push($deliveryTypeArray, $deliveryType);
                        }
                    }

                    // we need unique item
                    $deliveryTypeArrayUnique = array_unique($deliveryTypeArray);

                    foreach($deliveryTypeArrayUnique as $delivery){?>
                        <div class="checkbox">
                            <label><input type="checkbox" name="type_categorypage" class="vendor_sort_categorypage_item" value="<?php echo $delivery; ?>"><?php echo $delivery; ?></label>
                        </div>
                    <?php }
                    ?>
                </div>
                
                <!--Filter end-->
            </div>
            <?php endif;?>
            <!-- END OF SIDEBARS -->

            <div class="content_holder">

                <?php
                global $WCMp;
                $frontend_assets_path = $WCMp->plugin_url . 'assets/frontend/';
                $frontend_assets_path = str_replace(array('http:', 'https:'), '', $frontend_assets_path);
                $suffix = defined('WCMP_SCRIPT_DEBUG') && WCMP_SCRIPT_DEBUG ? '' : '.min';
                wp_register_style('wcmp_vendor_list', $frontend_assets_path . 'css/vendor-list' . $suffix . '.css', array(), $WCMp->version);
                wp_style_add_data('wcmp_vendor_list', 'rtl', 'replace');
                wp_enqueue_style('wcmp_vendor_list');
                $block_vendors = wp_list_pluck(wcmp_get_all_blocked_vendors(), 'id');
                $vendors = get_wcmp_vendors( array('exclude'   => $block_vendors), $return = 'id');
                $verified_vendor_list = array();
                ?>

                <div id="wcmp-store-conatiner">

                <?php
                global $wpdb;
                // user by delivery zip
                $userByDeliveryZipQuery = get_users(array(
                    'meta_key'     => 'delivery_zips',
                    'meta_value'   => $deliveryZipFromUrlPath,
                    'meta_compare' => 'LIKE',
                ));

                $userByDeliveryZip = array();

                foreach($userByDeliveryZipQuery as $userByDeli){
                    array_push($userByDeliveryZip, $userByDeli->ID);
                }

                // user by product category id
                $userByCategoryId = array();

                $productData = $wpdb->get_results(
                    "
                        SELECT *
                        FROM {$wpdb->prefix}term_relationships
                        WHERE term_taxonomy_id = $categoryId
                    "
                );
                foreach($productData as $product){
                    $singleProductId = $product->object_id;
                    $postAuthor = $wpdb->get_row(
                        "
                            SELECT *
                            FROM {$wpdb->prefix}posts
                            WHERE ID = $singleProductId
                        "
                    );
                
                    $postAuthorId = $postAuthor->post_author;

                    array_push($userByCategoryId, $postAuthorId);
                }

                $userByCategoryIdUnique = array_unique($userByCategoryId);


                $filteredUserIdArray = array_intersect($userByDeliveryZip, $userByCategoryId);

                $filteredUserIdArrayUnique = array_unique($filteredUserIdArray);

                $userserIdArray = array();

                if($withDeliveryZip == 0){
                    $userserIdArray = $userByCategoryIdUnique;
                } else {
                    $userserIdArray = $filteredUserIdArrayUnique;
                }
                
                    // pass to backend
                    $categoryPageDefaultUserIdAsString = implode(",", $userserIdArray); ?>
    
                    <input type="hidden" id="categoryPageDefaultUserIdAsString" value="<?php echo $categoryPageDefaultUserIdAsString;?>">
                        
                    <div id="vendorByDeliveryZipCategory" class="wcmp-store-list-wrap">
                        <?php
                        if ($userserIdArray) {
                            foreach ($userserIdArray as $user) {
                                $vendor = get_wcmp_vendor($user);
                                $image = $vendor->get_image() ? $vendor->get_image('image', array(125, 125)) : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
                                $banner = $vendor->get_image('banner') ? $vendor->get_image('banner') : '';
                                ?>

                                <div class="wcmp-store-list">
                                    <?php do_action('wcmp_vendor_lists_single_before_image', $vendor->term_id, $vendor->id); ?>
                                    <div class="wcmp-profile-wrap">
                                        <div class="wcmp-cover-picture" style="background-image: url('<?php if($banner) echo $banner; ?>');"></div>
                                        <div class="store-badge-wrap">
                                            <?php do_action('wcmp_vendor_lists_vendor_store_badges', $vendor); ?>
                                        </div>
                                        <div class="wcmp-store-info">
                                            <div class="wcmp-store-picture">
                                                <img class="vendor_img" src="<?php echo esc_url($image); ?>" id="vendor_image_display">
                                            </div>
                                            <?php
                                                $rating_info = wcmp_get_vendor_review_info($vendor->term_id);
                                                $WCMp->template->get_template('review/rating_vendor_lists.php', array('rating_val_array' => $rating_info));
                                            ?>
                                        </div>
                                    </div>
                                    <?php do_action('wcmp_vendor_lists_single_after_image', $vendor->term_id, $vendor->id); ?>
                                    <div class="wcmp-store-detail-wrap">
                                        <?php do_action('wcmp_vendor_lists_vendor_before_store_details', $vendor); ?>
                                        <ul class="wcmp-store-detail-list">
                                            <li>
                                                <i class="wcmp-font ico-store-icon"></i>
                                                <?php $button_text = apply_filters('wcmp_vendor_lists_single_button_text', $vendor->page_title); ?>
                                                <a href="<?php echo esc_url($vendor->get_permalink()); ?>" class="store-name"><?php echo esc_html($button_text); ?></a>
                                                <?php do_action('wcmp_vendor_lists_single_after_button', $vendor->term_id, $vendor->id); ?>
                                                <?php do_action('wcmp_vendor_lists_vendor_after_title', $vendor); ?>
                                            </li>
                                            <?php if($vendor->get_formatted_address()) : ?>
                                            <li>
                                                <i class="wcmp-font ico-location-icon2"></i>
                                                <p><?php echo esc_html($vendor->get_formatted_address()); ?></p>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                        <?php do_action('wcmp_vendor_lists_vendor_after_store_details', $vendor); ?>
                                    </div>
                                </div>

                                <?php
                            } 

                        } else {
                            _e('No verified vendor found!', 'dc-woocommerce-multi-vendor');
                        }
                        ?>
                    </div>

                    <!--show ajax filtered result-->
                    <div id="vendorAfterFilter" class="wcmp-store-list-wrap">
                    </div>
                </div>
            </div>

            <div style="text-align: center;">
                <div class="overlay"></div>
            </div>

            <style>
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
                div.loading-custom {
                    overflow: hidden;   
                }
                /* Make spinner image visible when body element has the loading class */
                div.loading-custom .overlay {
                    display: block;
                }

                /** Modal redesign */
                .modal-content {
                    border-radius: 0px !important;
                }
            </style>

        </div>
    </div>
</div><!-- END OF MAIN CONTENT -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" style="margin-top:200px; z-index:16000">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Show vendor from your nearest delivery ZIP</h4>
            </div>
            <div class="modal-body">
                <p>Delivery ZIP</p>
                <div class="form-group">
                    <input type="text" name="delivery_zip" id="deliveryZip" class="form-control" placeholder="Please Write Delivery ZIP e.g: 1234">
                    <p id="delieryZipMessage" class="text-danger">Please write 4 digit delivery zip code.</p>
                    <input type="hidden" id="categoryId" value="<?php echo $categoryId;?>">
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="sendButton">Show Store</button>
            </div>
        </div>
    </div>
</div>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script type="text/javascript">

    $(window).on('load',function(){
        $('#myModal').modal('show');

        $('#delieryZipMessage').hide();
		$('#sendButton').attr('disabled', true);
		var deliveryZip;

        $('#deliveryZip').on('keyup', function(){
            deliveryZip = $('#deliveryZip').val();
            if(deliveryZip.length == 4){
                $('#sendButton').attr('disabled', false);
                $('#delieryZipMessage').hide();
            }
            else {
                $('#sendButton').attr('disabled', true);
                $('#delieryZipMessage').show();
            }
        });

        
        $('#sendButton').on('click', function(){	
            var deliveryZip = $('#deliveryZip').val();
		    window.history.replaceState(null, null, "?zip="+deliveryZip);
		    // window.history.pushState("string", "Title", deliveryZip);

            $("#wcmp-store-conatiner").load(location.href + " #wcmp-store-conatiner");
            $(".heading-title").load(location.href + " .heading-title");
        });
    });

    $('#changeZip').on('click', function(){
        $('#myModal').modal('show');
        $("input:checkbox[name=type_categorypage]").prop("checked", false)
    });

</script>

<?php
get_footer();
