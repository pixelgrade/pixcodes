<?php
    // get needed classes
    $classes = 'pixcode  pixcode--testimonial  testimonial';
    // $classes.= !empty($style) ? ' testimonial--'.$style : '';
    // create class attribute
    $classes = $classes !== '' ? 'class="'.$classes.'"' : '';

?>
<blockquote <?php echo $classes; ?>>
    <div class="testimonial__content"><?php echo $this->get_clean_content($content); ?></div>
    <div class="testimonial__author-name"><?php echo $author; ?></div>
    <div class="testimonial__autho-title">Theoritician</div>
</blockquote>
