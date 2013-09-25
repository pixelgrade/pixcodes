<div class="team-member-container <?php echo $class ?>">
	<?php if ( !empty($image) ) : ?>
		<div class="team-member-image-wrapper">
		<?php if ( !empty($imagelink) ) : ?>	
        <a href="<?php echo $imagelink ?>" class="team-member-image-link" title="More about <?php echo !empty($name) ? $name : ''; ?>">
            <div class="team-member-image-container">                        
                <img src="<?php echo $image; ?>" alt="<?php echo !empty($name) ? $name : ''; ?>">
            </div>
            <div class="team-member-profile-container">
                <div class="team-member-profile-table">
                    <span class="team-member-profile-cell">
                       <i class="shc big icon-link"></i>                                      
                    </span>
                </div>
            </div>
        </a>
    	<?php else: ?>
        <div class="team-member-image-link">
            <div class="team-member-image-container">                        
                <img src="<?php echo $image; ?>" alt="Catherine Alison Profile Image" alt="<?php echo !empty($name) ? $name : ''; ?>">
            </div>
        </div>
        <?php endif; ?> 
    <?php endif; ?>  	
    </div>  
    <div class="team-member-header">
		<?php if ( !empty($name) ) : ?>    	
    	<h5 class="team-member-name"><?php echo $name; ?></h5>
    	<?php endif; ?>
    	<?php if ( !empty($title) ) : ?>
        <h6 class="team-member-position"><?php echo $title; ?></h6>
    	<?php endif;?>
    </div>
    <div class="team-member-description">
        <?php echo $this->get_clean_content($content); ?>
    </div>
    <hr class="separator separator--striped" />
    <div class="team-member-footer">
        <ul class="team-member-social-links">
        	<?php if ( !empty($social_twitter) ) : ?>
            <li class="team-member-social-link"><a class="social-link" href="#" target="_blank"><i class="shc icon-twitter"></i></a></li>
        	<?php endif; ?>
        	<?php if ( !empty($social_facebook) ) : ?>
            <li class="team-member-social-link"><a class="social-link" href="#" target="_blank"><i class="shc icon-facebook"></i></a></li>
        	<?php endif; ?>
        	<?php if ( !empty($social_linkedin) ) : ?>
            <li class="team-member-social-link"><a class="social-link" href="#" target="_blank"><i class="shc icon-linkedin"></i></a></li>
        	<?php endif; ?>
        	<?php if ( !empty($social_pinterest) ) : ?>
            <li class="team-member-social-link"><a class="social-link" href="#" target="_blank"><i class="shc icon-pinterest"></i></a></li>
        	<?php endif; ?>
        </ul>
    </div>
</div>   