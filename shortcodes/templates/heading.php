<?php
// get needed classes
$classes = 'pixcode  pixcode--heading article__headline';

// create class attribute
$classes = $classes !== '' ? 'class="' . $classes . '"' : '';

echo '<hgroup ' . $classes . '>
	<h2 class="headline__secondary">' . $subtitle . '</h2>
	<h1 class="headline__primary">' . $title . '</h1>
</hgroup>';