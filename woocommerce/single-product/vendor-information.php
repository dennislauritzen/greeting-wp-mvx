<?php
/**
* Template part for showing vendor information on product page
* @author Dennis Lauritzen
*
*
*
*
*/

global $WCMp, $product;

$product_id = $product->get_id();
$product_meta = get_post($product_id);
$vendor_id = $product_meta->post_author;
$vendor = get_wcmp_vendor($vendor_id);

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
            $image = $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
            $link = '#';
          } else {
  					$image = $vendor->get_image() ? $vendor->get_image('image', array(175,175)) : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
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
				$vendor_hide_description = apply_filters('wcmp_vendor_store_header_hide_description', get_user_meta($vendor_id, '_vendor_hide_description', true), $vendor_id);
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
          <p>Butikken leverer på flg. dage:
            <?php
            $del_days = get_field('openning', 'user_'.$vendor_id);
            $day_array = array(1 => 'mandag', 2 => 'tirsdag', 3 => 'onsdag', 4 => 'torsdag', 5 => 'fredag', 6 => 'lørdag', 7 => 'søndag');

            if(is_array($del_days) && count($del_days) > 0){
    					$i = 1;
              foreach($del_days as $v){
                $day = $day_array[$i];
                if ($i == 1){
                  $day = ucfirst($day);
                }

                if(count($del_days) > 1)
                {
                  if($i < count($del_days)-1){
                    $day .= ', ';
                  } else if($i == count($del_days)) {
                    $day = ' og '.$day;
                  }
                }

                print $day;
                $i++;
              } // endforeach
            } // endif
            ?>.
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
  				// --- CLOSED DATES --- Dennis.
  				$closed_dates = get_field('vendor_closed_day', 'user_'.$vendor_id);
  				$dates = explode(",",$closed_dates);
  				$viable_dates = array();

  				foreach($dates as $val){
  					$date_u = strtotime($val);
  					$date = date("d-m-Y", $date_u);
  					$today = date("U");

  					if($date_u >= ($today-(60*60*24)) && $date_u <= ($today+(60*60*24*30))){
  						$weekday = date('N',$date_u);
  						$weekday_str = '';
  						$date = date('j',$date_u);
  						$month = date('m',$date_u);
  						$month_str = '';

  						switch($weekday){
  							case 1:
  								$weekday_str = 'mandag';
  								break;
  							case 2:
  								$weekday_str = 'tirsdag';
  								break;
  							case 3:
  								$weekday_str = 'onsdag';
  								break;
  							case 4:
  								$weekday_str = 'torsdag';
  								break;
  							case 5:
  								$weekday_str = 'fredag';
  								break;
  							case 6:
  								$weekday_str = 'lørdag';
  								break;
  							case 7:
  								$weekday_str = 'søndag';
  								break;
  						}

  						switch($month){
  							case 1:
  								$month_str = 'januar';
  								break;
  							case 2:
  								$month_str = 'februar';
  								break;
  							case 3:
  								$month_str = 'marts';
  								break;
  							case 4:
  								$month_str = 'april';
  								break;
  							case 5:
  								$month_str = 'maj';
  								break;
  							case 6:
  								$month_str = 'juni';
  								break;
  							case 7:
  								$month_str = 'juli';
  								break;
  							case 8:
  								$month_str = 'august';
  								break;
  							case 9:
  								$month_str = 'september';
  								break;
  							case 10:
  								$month_str = 'oktober';
  								break;
  							case 11:
  								$month_str = 'november';
  								break;
  							case 12:
  								$month_str = 'december';
  								break;
  						}
  						$viable_dates[] = $weekday_str." d. ".$date.". ".$month_str;
  					}
  				}

  				$dates_for_str = '';
  				$i = 0;
  				foreach($viable_dates as $v){
  					$i++;
  					$dates_for_str .= $v;
  					if(count($viable_dates) > 1){
  						if($i == count($viable_dates)-1){
  							$dates_for_str .= ' og ';
  						} else if($i < count($viable_dates)){
  							$dates_for_str .= ', ';
  						}
  					}
  				}

  				if(count($viable_dates) > 0){
  				?>
  			 		<p>Bemærk dog at butikken ikke leverer <?php print $dates_for_str; ?>.</p>
  				<?php
  				}
  				// --- END of CLOSED DATES --- Dennis.
  				?>

        <?php
        } // end if
        ?>
      </div>
    </div>
  </div>
</section>
