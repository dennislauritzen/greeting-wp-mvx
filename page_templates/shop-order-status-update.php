<?php
/*
  Template Name: Shop Order Status Update
 */
exit();

get_header();
?>
<style>
    .shop-order-status-update-wrapper {
        max-width: 400px;
        margin: 0 auto;
    }
</style>

<div id="content" class="content-area  rigid-right-sidebar">

	<div id="rigid_page_title" class="rigid_title_holder" >
		<div class="inner fixed">
			<!-- BREADCRUMB -->
			<div class="breadcrumb">
				<a href="<?php echo site_url();?>">Home</a>
				<span class="rigid-breadcrumb-delimiter">/</span> Vendor <span class="rigid-breadcrumb-delimiter">/</span> <?php the_title();?>
			</div><!-- END OF BREADCRUMB -->
			<!-- TITLE -->
			<h1 class="product_title entry-title heading-title"><?php the_title();?></h1><!-- END OF TITLE -->
		</div>
	</div>

	<div id="products-wrapper" class="inner site-main" role="main">
        <div class="shop-order-status-update-wrapper">
        <?php
        if(isset($_POST['order_status'])&&!empty($_POST['order_status']) ):
        $orderStatus = $_POST['order_status'];
        $orderId = $_POST['order_id'];

            if($orderStatus=='wc-completed'):
                $order = wc_get_order($orderId); // Get an instance of the WC_Order oject
                $order->update_status( 'wc-completed' );
                echo "Order status successfully updated!";
            endif;
            if($orderStatus=='wc-cancelled'):
                $order = wc_get_order($orderId); // Get an instance of the WC_Order oject
                $order->update_status( 'wc-cancelled' );
                echo "Order status successfully updated!";
            endif;
        endif;
        ?>
        </div>
	</div>
</div>

<?php get_footer();
