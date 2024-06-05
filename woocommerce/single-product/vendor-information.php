<?php
/**
* Template part for showing vendor information on product page
* @author Dennis Lauritzen
*
*
*
*
*/

global $MVX, $product;

$product_id = $product->get_id();
$product_meta = get_post($product_id);
$vendor_id = $product_meta->post_author;
$vendor = get_mvx_vendor($vendor_id);

if(!is_object($vendor)){
  return;
}

$del_type = '';
$del_value = '';
if(!empty(get_field('delivery_type', 'user_'.$vendor_id))){
  $delivery_type = get_field('delivery_type', 'user_'.$vendor_id)[0];

  if(empty($delivery_type['label'])){
    $del_value = $delivery_type;
    $del_type = $delivery_type;
  } else {
    $del_value = $delivery_type['value'];
    $del_type = $delivery_type['label'];
  }
}
?>

<section id="vendor" class="bg-light-grey py-5 mb-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-2">
				<?php
          if(!is_object($vendor)){
            $image = $MVX->plugin_url . 'assets/images/WP-stdavatar.png';
            $link = '#';
          } else {
              $image = $vendor->get_image() ? $vendor->get_image('image', array(175,175)) : $MVX->plugin_url . 'assets/images/WP-stdavatar.png';
              $link = $vendor->get_permalink();
          }
				?>
        <a href="<?php echo $link; ?>">
  				<img class="d-inline-block pb-3" src="<?php echo esc_attr($image); ?>">
        </a>
      </div>
      <div class="col-lg-6">
        <h6><?php echo (is_object($vendor) ? ucfirst(esc_html($vendor->user_data->data->display_name)) : ''); ?></h6>
        <p>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#446a6b" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
          </svg>
          <?php
          $vendor_address = !empty(get_user_meta($vendor_id, '_vendor_address_1', true)) ? get_user_meta($vendor_id, '_vendor_address_1', true) : '';
          $vendor_postal = !empty(get_user_meta($vendor_id, '_vendor_postcode', true)) ? get_user_meta($vendor_id, '_vendor_postcode', true) : '';
          $vendor_city = !empty(get_user_meta($vendor_id, '_vendor_city', true)) ? get_user_meta($vendor_id, '_vendor_city', true) : '';
          $location = '';
          if(!empty($vendor_address)){
            $location .= $vendor_address.', ';
          }
          if(!empty($vendor_postal)){
            $location .= $vendor_postal.' ';
          }
          if(!empty($vendor_city)){
            $location .= $vendor_city.' ';
          }

          if(!empty($location) && $vendor_id != "38" && $vendor_id != "76"){
            echo esc_html($location);
          } else if($vendor_id == "38" || $vendor_id == "76"){
            echo 'Leveres fra en fysisk gavebutik, der ligger nær din modtager.';
          } ?>
        </p>
        <?php
				$vendor_hide_description = apply_filters('mvx_vendor_store_header_hide_description', get_user_meta($vendor_id, '_vendor_hide_description', true), $vendor_id);
				$description = get_user_meta($vendor_id, '_vendor_description', true);
				if (!$vendor_hide_description && !empty($description)) { ?>
        <div>
            <?php echo wp_kses_post(htmlspecialchars_decode( wpautop( $description ), ENT_QUOTES )); ?>
        </div>
        <?php } ?>
        <p><a href="<?php echo esc_url($vendor->get_permalink()); ?>">Se butikkens øvrige gaveprodukter</a><p>
      </div>
      <div class="col-lg-4">

        <?php

        if($del_value == '0'){
          echo "<b>Information om forsendelse</b>";
          echo '<p>'.get_field('freight_company_delivery_text', 'options').'</p>';
        } else {
        ?>
          <b>Leveringsinformation</b>
          <p>
            <?php
              $opening = get_field('openning', 'user_'.$vendor_id);
              $open_iso_days = array();
              $open_label_days = array();
              foreach($opening as $k => $v){
                $open_iso_days[] = (int) $v['value'];
                $open_label_days[$v['value']] = $v['label'];
              }

              $interv = array();
              if(!empty($open_iso_days) && is_array($open_iso_days)){
                $interv = build_intervals($open_iso_days, function($a, $b) { return ($b - $a) <= 1; }, function($a, $b) { return $a."..".$b; });
              } else {
                print 'Butikkens leveringsdage er ukendte';
              }
              $i = 1;

              if(!empty($opening) && !empty($interv) && count($interv) > 0){

                if($del_value == "1"){
                  echo 'Butikken leverer ';
                } else if($del_value == "0"){
                  echo 'Butikken afsender ';
                }

                foreach($interv as $v){
                  $val = explode('..',$v);
                  if(!empty($val)){
                    $start = isset($open_label_days[$val[0]])? $open_label_days[$val[0]] : '';
                    if($val[0] != $val[1])
                    {
                      $end = isset($open_label_days[$val[1]]) ? $open_label_days[$val[1]] : '';
                      if(!empty($start) && !empty($end)){
                        print strtolower($start."-".$end);
                      }
                    } else {
                      print strtolower($start);
                    }
                    if(count($interv) > 1){
                      if(count($interv)-1 == $i){ print " og "; }
                      else if(count($interv) > $i) { print ', ';}
                    }
                  }
                  $i++;
                }
              }
            ?>
          </p>
          <p>
            Butikken leverer senest
            <?php
              if(get_field('vendor_require_delivery_day', 'user_'.$vendor_id) == 0)
              {
                echo ' i dag';
              }
                else if(get_field('vendor_require_delivery_day', 'user_'.$vendor_id) == 1)
              {
                echo ' i morgen';
              } else {
                echo 'om '.get_field('vendor_require_delivery_day', 'user_'.$vendor_id)." hverdage";
              }
            ?>, hvis du bestiller inden kl.
            <?php echo (!empty(get_field('vendor_drop_off_time', 'user_'.$vendor_id)) ? get_field('vendor_drop_off_time', 'user_'.$vendor_id) : '11'); ?>.
          </p>
        <?php
        } // end if
        ?>
				<?php
        // Get the date string and run the functions.
        $closed_dates = get_field('vendor_closed_day', 'user_'.$vendor_id);
				$dates = explode(",",$closed_dates);

        // Run the dates.
        $str = $closed_dates;
        $result = groupDates($str);

        if(count($result) > 0 && !empty($closed_dates))
        {
          $today = date("U");
          $str = '';
          foreach($result as $v){
            if(
              strtotime($v[0]) > $today ||
              (isset($v[1]) && strtotime($v[1]) > $today)){
              // Rephrase the dato for readable dates.
              $start = rephraseDate(
                date("N", strtotime($v[0])),
                date("j", strtotime($v[0])),
                date("m", strtotime($v[0])),
                date("Y", strtotime($v[0]))
              );
              if(count($v) > 1){
                $end = rephraseDate(
                  date("N", strtotime($v[1])),
                  date("j", strtotime($v[1])),
                  date("m", strtotime($v[1])),
                  date("Y", strtotime($v[1]))
                );
              }

              // Print the dates
              $str .= '<li>';
              $str .= $start;
              if(count($v) > 1){
                $str .= ' til ';
                $str .= $end;
              }
              $str .= '</li>';
            }
          }

          if(!empty($str)){
            print '<p>Bemærk dog at butikken ikke leverer på følgende dage:</p>'.$str;
          }
        }
				// --- END of CLOSED DATES --- Dennis.
				// --- END of CLOSED DATES --- Dennis.
				?>
      </div>
    </div>
  </div>
</section>
