<div class="progressbar">
	<?php if ($title): ?>
		<div class="progressbar-title"><?php echo $title; ?></div>
	<?php endif; ?>
	<div class="progressbar-bar">
		<div class="progressbar-progress" data-value="<?php echo $progress ?>">
			<div class="progressbar-tooltip"><?php echo $progress ?></div>
		</div>
		<?php if ($markers == 'on') for ($i = 1; $i<=4; $i++): ?>
			<div class="progressbar-marker" style="width:<?php echo $i*20 ?>%"></div>
		<?php endfor; ?>
	</div>
</div>