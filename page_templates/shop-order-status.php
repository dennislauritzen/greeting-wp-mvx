<?php
/*
  Template Name: Shop Order Status
 */

global $MVX;

//get path
$urlPath = $_SERVER["REQUEST_URI"];
$url = parse_url($urlPath);

// Transform query
$query = $url['query'];
$query_arr = parse_str($query, $output);
if(isset($output['_u'])){ unset($output['_u']); }

// Rebuild URL
$url_new = http_build_query($output);
$url_path_new = $url['path'].'?'.$url_new;
// -- URL rebuilding done.

// Build update links
$update_link = (isset($_GET['_u']) ? $urlPath : $url_path_new.'&_u=u');
// -- END


// Get the last part.
$order_id = $_GET['order_id'];

$get_order_hash = $_GET['oh'];
$get_order_hash2 = $_GET['sshh'];

$order_hash = hash('md4','gree_ting_dk#!4r1242142fgriejgfto'.$order_id.$order_id);
$order_hash2 = hash('md4', 'vvkrne12onrtnFG_:____'.$order_id);

#print "<p>".$order_id."</p>";
#print "<p>".$order_hash." - ".$get_order_hash."</p>";
#print "<p>".$order_hash2." - ".$get_order_hash2."</p>";

// Check if order id and order hash/salt is set.
if(empty($order_id) || !isset($order_id)
  || empty($get_order_hash) || $get_order_hash != $order_hash
  || empty($get_order_hash2) || $get_order_hash2 != $order_hash2
){
    print $order_hash."<br>";
    print $order_hash2;
    #wp_redirect(home_url());
    return;
    exit();
}



$order = wc_get_order( $order_id );
$order_data = $order->get_data();
#$suborder_id = $WCMp->order->get_suborders($order_id);

$__order_id       = '';
$__order_id_child = '';

if($order && $order_data){
  $orderStatus = $order->get_status();
  if($orderStatus == 'processing' || $orderStatus == 'order-mail-open'){
    $order->update_status( 'order-seen' );
    #echo "Opdateret til 'set'";
  }
} else {
  wp_redirect(home_url());
  return;
  exit();
}

if(isset($_GET['_u']) && $_GET['_u'] == 'u'){
  $date = date_i18n( 'l \\d\\e\\n d. F Y \\k\\l\\. H:i:s');
  if($orderStatus == 'processing' || $orderStatus == 'order-mail-open' || $orderStatus == 'order-seen' || $orderStatus == 'order-forwarded'){
    $order->update_status( 'order-accepted',  "Butikken har AKTIVT set/godkendt ordren ".$date.".");
    #echo $order->get_status();

    wp_redirect(home_url() . $url_path_new);
    exit();
  } else if($orderStatus == 'order-accepted'){
    $order->update_status( 'delivered',  "Butikken har AKTIVT set/godkendt ordren ".$date.".");

    $order->add_order_note("Butikken har opdateret ordren til status 'Leveret' ".$date.".");

    wp_redirect(home_url() . $url_path_new);
    exit();
  }
}

get_header();

get_header('green');
?>

<div id="content" class="container">

	<div class="row mt-5 mb-3">
			<!-- TITLE -->
			<h1 class=""><?php the_title();?></h1><!-- END OF TITLE -->
      <h6 class="">Ordernr. <?php echo $order_data['id'];?> til <?php echo $order_data['shipping']['first_name']; ?></h6><!-- END OF TITLE -->
      <p class="">Til levering på <b><?php echo $order_data['shipping']['address_1'].' '.$order_data['shipping']['postcode'].' '.$order_data['shipping']['city'];?></b></p><!-- END OF TITLE -->
  </div>

	<div class="row">
    <p>Klik nedenfor for opdatere ordren:</p>
    <?php
    $seen_array = array('processing', 'order-mail-open', 'order-seen', 'order-forwarded');
    $delivered_array = array('order-accepted');

    $border_order_seen = (in_array($orderStatus, $seen_array) ? array('border' => 'succes', 'color' => '#28a745', 'show_link' => true) : array('border' => 'grey', 'color' => '#444444', 'show_link' => false));
    $border_order_delivered = (in_array($orderStatus, $delivered_array) ? array('border' => 'succes', 'color' => '#28a745', 'show_link' => true) : array('border' => 'grey', 'color' => '#444444', 'show_link' => false));
    ?>
    <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-4">
      <?php echo ($border_order_seen['show_link'] === true ? '<a href="'.$update_link.'">' : ''); ?>
        <div class="text-center btn bg-light shadow border border-<?php echo $border_order_seen['border']; ?> border-1 rounded p-3">
          <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="<?php echo $border_order_seen['color']; ?>" class="bi bi-eye" viewBox="0 0 16 16">
            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
          </svg>
          <?php if($orderStatus == 'order-accepted' || $orderStatus == 'delivered' || $orderStatus == 'completed'){ ?>
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#28a745" class="bi bi-check" viewBox="0 0 16 16">
            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
          </svg>
          <?php } ?>
          <p><b>Ordre set/accepteret</b><br>Klik her for at markere ordren som set/modtaget.<br><br>
          <small style="font-size: 13px; line-height: 15px;">NB! Du skal acceptere <u>før</u> du kan markere som leveret. Når du har accepteret den, vil der være et flueben i toppen.</small></p>
        </div>
      <?php echo ($border_order_seen['show_link'] === true ? '</a>' : ''); ?>
    </div>
    <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-4">
      <?php if($orderStatus == 'processing' || $orderStatus == 'order-mail-open' || $orderStatus == 'order-seen' || $orderStatus == 'order-forwarded' || $orderStatus == 'order-accepted'){?>
      <!--<p>Klik nedenfor for at markere ordren som leveret / afsendt:</p>-->
      <?php echo ($border_order_delivered['show_link'] === true ? '<a href="'.$update_link.'">' : ''); ?>
        <div class="text-center btn bg-light shadow border border-<?php echo $border_order_delivered['border']; ?> border-1 rounded p-3">
          <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="<?php echo $border_order_delivered['color']; ?>" class="bi bi-bicycle pb-2" viewBox="0 0 16 16">
            <path d="M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5zm1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139L5.5 6.943zM8 9.057 9.598 6.5H6.402L8 9.057zM4.937 9.5a1.997 1.997 0 0 0-.487-.877l-.548.877h1.035zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765l1.027-1.643zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53L11.55 8.623z"/>
          </svg>
          <p><b>Leveret/Afsendt</b><br>Klik her for at markere ordren som leveret<br><br></p>
        </div>
      <?php echo ($border_order_delivered['show_link'] === true ? '</a>' : ''); ?>
    <?php } else if($orderStatus == 'cancelled' || $orderStatus == 'failed' || $orderStatus == 'refunded') {?>
      <div class="text-center btn bg-light shadow border border-danger border-1 rounded p-3 w-75">
        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#888888" class="bi bi-file-earmark-x pb-2" viewBox="0 0 16 16">
          <path d="M6.854 7.146a.5.5 0 1 0-.708.708L7.293 9l-1.147 1.146a.5.5 0 0 0 .708.708L8 9.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 9l1.147-1.146a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146z"/>
          <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
        </svg>
        <p><b>Annulleret</b><br>Ordren er desværre enten refunderet, slettet eller ikke gennemført, så den kan ikke markeres som leveret</p>
      </div>
    <?php } else if($orderStatus == 'delivered' || $orderStatus == 'completed') {?>
        <div class="text-center btn bg-light shadow border border-success border-1 rounded p-3 w-75">
          <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#28a745" class="bi bi-check-all pb-2" viewBox="0 0 16 16">
            <path d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992a.252.252 0 0 1 .02-.022zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486-.943 1.179z"/>
          </svg>
          <p><b>Leveret/Afsendt</b><br>Ordren ser ud til allerede at være leveret/afsendt - fedt! :)</p>
        </div>
    <?php } else { ?>
      <div class="text-center btn bg-light shadow border border-dark border-1 rounded p-3 w-75" style="min-width: 200px; min-height: 100px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#888888" class="bi bi-bug pb-2" viewBox="0 0 16 16">
          <path d="M4.355.522a.5.5 0 0 1 .623.333l.291.956A4.979 4.979 0 0 1 8 1c1.007 0 1.946.298 2.731.811l.29-.956a.5.5 0 1 1 .957.29l-.41 1.352A4.985 4.985 0 0 1 13 6h.5a.5.5 0 0 0 .5-.5V5a.5.5 0 0 1 1 0v.5A1.5 1.5 0 0 1 13.5 7H13v1h1.5a.5.5 0 0 1 0 1H13v1h.5a1.5 1.5 0 0 1 1.5 1.5v.5a.5.5 0 1 1-1 0v-.5a.5.5 0 0 0-.5-.5H13a5 5 0 0 1-10 0h-.5a.5.5 0 0 0-.5.5v.5a.5.5 0 1 1-1 0v-.5A1.5 1.5 0 0 1 2.5 10H3V9H1.5a.5.5 0 0 1 0-1H3V7h-.5A1.5 1.5 0 0 1 1 5.5V5a.5.5 0 0 1 1 0v.5a.5.5 0 0 0 .5.5H3c0-1.364.547-2.601 1.432-3.503l-.41-1.352a.5.5 0 0 1 .333-.623zM4 7v4a4 4 0 0 0 3.5 3.97V7H4zm4.5 0v7.97A4 4 0 0 0 12 11V7H8.5zM12 6a3.989 3.989 0 0 0-1.334-2.982A3.983 3.983 0 0 0 8 2a3.983 3.983 0 0 0-2.667 1.018A3.989 3.989 0 0 0 4 6h8z"/>
        </svg>
        <p><b>Leveret/Afsendt</b><br>Ordren kan ikke markeres som leveret netop nu</p>
      </div>
    <?php } ?>
    </div>

  <?php if($orderStatus == 'delivered' || $orderStatus == 'completed'){
    $hidden_val = 'grewgr8e4g6regr';
    if(isset($_POST['__hidden_updater']) && $_POST['__hidden_updater'] == hash('md4',$hidden_val) ){
        // Update
        #update_post_meta($order->get_id(), 'store_own_order_reference', $_POST['__store_own_reference']);
        $order->update_meta_data('store_own_order_reference', $_POST['__store_own_reference']);
    }

    $own_ref = (!empty(get_post_meta($order->get_id(), 'store_own_order_reference', 1)) ? get_post_meta($order->get_id(), 'store_own_order_reference', 1) : '');

  ?>
  </div>
  <div class="row">
    <div class="col-12 col-md-8 mt-4">
      <b>Egen reference (eks. fakturanr.):</b><br>
      <p>Hvis du gerne vil tilføje din egen reference til ordren (så du eks. kan matche med bilag/faktura i bogholderi-system),
        så kan du indtaste den her og trykke "Gem". Egen reference vil fremgå af faktureringsoversigten:</p>
        <form action="<?php echo $url_path_new; ?>" method="post">
          <input type="hidden" name="__hidden_updater" name="knrejgnrjeubt3o2__" value="106da8c7c000d63970be672572ed0864">
          <div class="row mb-3 input-group input-group-sm ">
            <label class="form-check-label" for="ownref_field">
            <input type="text" class="form-control w-100" name="__store_own_reference" id="ownref_field" value="<?php echo $own_ref; ?>">
          </div>
          <button type="submit" class="btn btn-primary bg-teal border-0">Gem egen reference</button>
        </form>
    </div>
  <?php } // end of the "Own reference"-part ?>
  </div>
</div>
<?php get_footer();
