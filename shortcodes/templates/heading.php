<?php
// get needed classes
$classes = 'pixcode  pixcode--heading article__headline';

// create class attribute
$classes = $classes !== '' ? 'class="' . $classes . '"' : '';

//make the first subtitle letter special
if ( ! empty( $subtitle ) ) {
	$subtitle   = esc_html( $subtitle );
	$first_char = mb_substr( $subtitle, 0, 1 );
	$subtitle   = '<span class="first-letter">' . $first_char . '</span>' . mb_substr( $subtitle, 1 );
}

echo '<hgroup ' . $classes . '>
	<h2 class="headline__secondary">' . $subtitle . '</h2>
	<h1 class="headline__primary">' . $title . '</h1>
</hgroup>';