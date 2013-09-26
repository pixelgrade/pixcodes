<?php
$return_string = '<div class="pixslider js-pixslider" ' . $navigation_style .'>';

$return_string .= do_shortcode($content);

$return_string .= '</div>';
echo $return_string;