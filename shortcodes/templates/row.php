<?php
$output = '';
if ($is_narrow) {
	$output .= '<div class="narrow">'.PHP_EOL;
}

$output .= '<div class="row row-shortcode '.$class.'">'.PHP_EOL;
if ( !empty($bg_color) ) {
	$output .= '<div class="row-background';
	if ( !empty( $full_width ) )  $output .= ' full-width';
	$output .= '" style="background-color:'.$bg_color.';"></div>'.PHP_EOL;
}
$output .= $this->get_clean_content($content).PHP_EOL;
$output .= '</div>'.PHP_EOL;

if ($is_narrow) {
	$output .= '</div>'.PHP_EOL;
}

echo $output;