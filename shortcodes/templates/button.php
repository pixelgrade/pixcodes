<?php

    // create id attribute
    $id = !empty($id) ? 'id="'.$id.'"' : '';

    // get needed classes
    $classes = 'pixcode  pixcode--btn  btn';
    $classes.= !empty($size) ? '  btn--'.$size : '';
    $classes.= !empty($text_size) ? '  btn--'.$text_size : '';
    $classes.= !empty($class) ? '  '.$class : '';
    // create class attribute
    $classes = $classes !== '' ? 'class="'.$classes.'"' : '';

    // create href attribute
    $href = !empty($link) ? 'href="'.$link.'"' : '';

    // get content
    $content = !empty($content) ? $this->get_clean_content($content) : '';

    // get target
    $target = !empty($newtab) ? 'target="_blank"' : '';

echo '<a '.$id.' '.$classes.' '.$href.' '.$target.'>'.$content.'</a>';