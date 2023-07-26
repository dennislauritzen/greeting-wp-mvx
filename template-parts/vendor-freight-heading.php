<?php

$heading_template_freight = get_field('heading_template_freight_stores', 'option');
$heading_dummy_template = get_field('heading_template_dummy_freight_stores', 'option');
$text_template = get_field('text_template_freight_stores', 'option');

$cityName = (isset($args['cityName']) ? $args['cityName'] : '');
$postalCode = (isset($args['postalCode']) ? $args['postalCode'] : '');

$heading = (!empty($heading_template_freight) ? str_replace('{{city_name}}', $cityName, $heading_template_freight) : $heading_dummy_template);
$heading = (!empty($heading_template_freight) ? str_replace('{{postalcode}}', $postalCode, $heading) : $heading_dummy_template);
$heading = ($args['cityName'] ? $heading : $heading_dummy_template);
?>

<h3 class="mt-5 mb-4" style="font-family: Inter;">
<?php echo $heading; ?>
</h3>
<?php if(!empty($text_template)){ ?>
<p><?php echo $text_template; ?></p>
<?php } ?>
