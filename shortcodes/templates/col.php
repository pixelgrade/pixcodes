<?php
$output = '';
$output .= '<div class="span'.$size. ' ' .$class.'">'.PHP_EOL;
$output .= $this->get_clean_content( $content ).PHP_EOL;
$output .= '</div>'.PHP_EOL;
echo $output;