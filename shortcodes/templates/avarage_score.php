<?php
echo 'ceva';
?>
<div class="score-box  score-box--inside">
	<div class="score__average-wrapper">
		<div class="score__average average--with-desc">
			<div class="score__note" itemprop="rating">
				<?php echo $score_note; ?>
			</div>
			<div class="score__desc">
				<?php echo $content; ?>
			</div>
		<meta itemprop="worst" content="1">
		<meta itemprop="best" content="10">
		</div>
	</div>
</div>
