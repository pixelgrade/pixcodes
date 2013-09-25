<?php
$return_string = '<div class="pixslider js-pixslider" ' . $arrows . ' ' . $bullets .' '. $autoheight .'>';

$return_string .= do_shortcode($content);

$return_string .= '</div>';
echo $return_string;