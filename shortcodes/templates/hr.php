<?php

// get needed classes
$classes = 'pixcode  pixcode--separator  separator';
$classes .= ! empty( $style ) ? ' separator--' . $style : '';
// create class attribute
$classes = $classes !== '' ? 'class="' . $classes . '"' : '';

echo '<hr ' . $classes . '/>';