<div class="team-member-container <?php echo $class ?>">
	<?php if ( !empty($image) ) {
	if ( !empty($imagelink) ) { ?>
	<a href="<?php echo $imagelink ?>" class="team-member-image" title="More about <?php echo !empty($name) ? $name : ''; ?>">
		<?php } else { ?>
		<div class="team-member-image">
			<?php } ?>
			<img src="<?php echo $image; ?>" alt="<?php echo $name; ?> Profile Image">
			<?php if ( !empty($imagelink) ) { ?>
	</a>
	<?php } else { ?>
</div>
<?php }
} ?>

<div class="team-member-header">
	<?php if ( !empty($name) ) { ?>
		<h3 class="team-member-name"><?php echo $name; ?></h3>
	<?php } ?>
	<?php if ( !empty($title) ) { ?>
		<h4 class="team-member-position"><?php echo $title; ?></h4>
	<?php } ?>
</div>
<div class="team-member-description">
	<?php echo $this->get_clean_content($content); ?>
</div>
<div class="team-member-footer">
	<ul class="team-member-social-links">
		<?php if ( !empty($social_twitter) ) { ?>
			<li class="team-member-social-link"><a class="social-link" href="<?php echo $social_twitter; ?>"  target="_blank"><i class="icon-twitter"></i></a></li>
		<?php } ?>

		<?php if ( !empty($social_facebook) ) { ?>
			<li class="team-member-social-link"><a class="social-link" href="<?php echo $social_facebook; ?>"  target="_blank"><i class="icon-facebook"></i></a></li>
		<?php } ?>

		<?php if ( !empty($social_linkedin) ) { ?>
			<li class="team-member-social-link"><a class="social-link" href="<?php echo $social_linkedin; ?>"  target="_blank"><i class="icon-linkedin"></i></a></li>
		<?php } ?>

		<?php if ( !empty($social_pinterest) ) { ?>
			<li class="team-member-social-link"><a class="social-link" href="<?php echo $social_pinterest; ?>"  target="_blank"><i class="icon-pinterest"></i></a></li>
		<?php } ?>
	</ul>
</div>
</div>