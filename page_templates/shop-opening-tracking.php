<?php
/*
  Template Name: Shop Opening Tracking
 */

global $WCMp;

//get path
$urlPath = $_SERVER["REQUEST_URI"];
//get last element
$orderId = array_slice(explode('=', rtrim($urlPath, '/')), -1)[0];
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
  wp_redirect(home_url());
  return;
  exit();
} else {
  $order = wc_get_order( $order_id );
  $order_data = $order->get_data();
  #$suborder_id = $WCMp->order->get_suborders($order_id);
  $__order_id       = '';
  $__order_id_child = '';
  if($order && $order_data){
    $orderStatus = $order->get_status();
    $order->update_status( 'order-mail-open' );
  }

  header('Content-Type: image/png');
  echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=');
}

return;
exit();
