<div class="testimonial shc">
	<blockquote>
		<?php echo $this->get_clean_content($content);
		if(!empty($author)) {
			echo '<div class="testimonial_author">';
			if(!empty($link)) {
				echo '<a href="'.$link.'">';
			}
			echo '<span class="author_name">'.$author.'</span>';
			if(!empty($link)) {
				echo '</a>';
			}
			echo '</div>';
		} ?>
	</blockquote>
</div>