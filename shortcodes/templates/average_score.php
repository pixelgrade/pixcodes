<?php

?>
<div class="score-box  score-box--inside">
	<div class="score__average-wrapper">
		<div class="score__average <?php echo get_field('note') ? 'average--with-desc' : '' ?>">
			<?php
			echo '<div class="score__note" itemprop="rating" >'.bucket::get_average_score().'</div>';
			if (get_field('note')) {
				echo '<div class="score__desc">'.get_field('note').'</div>';
			} ?>
			<meta itemprop="worst" content = "1">
			<meta itemprop="best" content = "10">
		</div>
	</div>
</div>
