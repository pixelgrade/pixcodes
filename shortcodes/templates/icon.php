<?php

$output = '<i class="pixcode  pixcode--icon  icon-' . $name . '  ' . $type . '  ' . $size . '  ' . $class . '"></i>';

if ( ! empty( $link ) ) {
	$link = ' href="' . esc_attr( $link ) . '" ';

	if ( ! empty( $link_target_blank ) ) {
		$link .= ' target="_blank" ';
	}

	$output = '<a class="pixcode-icon-link" ' . $link . '">' . $output . '</a>';
}

echo $output;