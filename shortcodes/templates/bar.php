<div class="pixcode  pixcode--progressbar  progressbar">
	<?php if ($title): ?>
		<div class="progressbar__title"><?php echo $title; ?></div>
	<?php endif; ?>
	<div class="progressbar__bar">
		<div class="progressbar__progress" data-value="<?php echo $progress ?>">
			<div class="progressbar__tooltip"><?php echo $progress ?></div>
		</div>
		<?php if ($markers == 'on') for ($i = 1; $i<=4; $i++): ?>
<<<<<<< HEAD
			<div class="progressbar__marker" style="width: <?php echo $i*20 ?>%"></div>
=======
			<div class="progressbar__marker" style="width:<?php echo $i*20 ?>%"></div>
>>>>>>> 2d759b6b684d093b3cc5c2e0e157aa3483b1951e
		<?php endfor; ?>
	</div>
</div>