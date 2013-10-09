<?php
$return_string = '<div class="pixslider js-pixslider" ' . $navigation_style .' data-slidertransition="' . $custom_slider_transition . '">';

$return_string .= do_shortcode($content);

$return_string .= '</div>';
echo $return_string;