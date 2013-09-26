<blockquote class="pixcode--testimonial">
	<?php echo $this->get_clean_content($content); ?>
	<?php if(!empty($author)) : ?>
		<?php if(!empty($link)) :
			echo '<a href="'.$link.'">';
		endif;?>
		<p class="author__name"><?php echo $author; ?></p>
		<?php if(!empty($link)) :
			echo '</a>';
		endif;?>		
	<?php if(!empty($author_title)) : ?>
	<p class="author__title"><?php echo $author_title; ?></p>
	<?php endif;
	endif; ?>
</blockquote>