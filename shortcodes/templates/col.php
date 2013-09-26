<?php
$output = '';
$output .= '<div class="col-12  hand-span-'.$size. ' ' .$class.'">'.PHP_EOL;
$output .= $this->get_clean_content( $content ).PHP_EOL;
$output .= '</div>'.PHP_EOL;
echo $output;