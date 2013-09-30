<?php
    // get needed classes
    $classes = 'pixcode  pixcode--testimonial  testimonial';
    $classes.= !empty($text_size) ? ' testimonial--'.$text_size.'-text' : '';
    // create class attribute
    $classes = $classes !== '' ? 'class="'.$classes.'"' : '';

?>
<blockquote <?php echo $classes; ?>>
    <div class="testimonial__content"><?php echo $this->get_clean_content($content); ?></div>

    <?php if(!empty($author)) : ?>

        <?php if(!empty($link)) : ?>
            <a href="<?php echo $link; ?>">
        <?php endif ?>

            <div class="testimonial__author-name"><?php echo $author; ?></div>
        
        <?php if(!empty($link)) : ?>
            </a>
        <?php endif ?>

        <?php if(!empty($author_title)) : ?>
            <div class="testimonial__author-title"><?php echo $author_title; ?></div>
        <?php endif; ?>

    <?php endif; ?>
</blockquote>
