<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_TeamMemberCityHub extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = false;
        $this->name = "Team Member";
        $this->code = "team-member";
        $this->icon = "icon-user";
        $this->direct = false;

        $this->params = array(
            'name' => array(
                'type' => 'text',
                'name' => 'Name',
                'admin_class' => 'span6'
            ),
            'image' => array(
                'type' => 'image',
                'name' => 'Image',
                'admin_class' => 'span5 push1 pxg_media_uploader'
            ),
            'title' => array(
                'type' => 'text',
                'name' => 'Title',
                'admin_class' => 'span6'
            ),
			'imagelink' => array(
                'type' => 'text',
                'name' => 'Image Link',
                'admin_class' => 'span5 push1'
            ),
            'content' => array(
                'type' => 'textarea',
                'name' => 'Description',
                'admin_class' => 'span12',
                'is_content' => true
            ),
            'social_twitter' => array(
                'type' => 'text',
                'name' => 'Twitter Link',
                'admin_class' => 'span6'
            ),
            'social_facebook' => array(
                'type' => 'text',
                'name' => 'Facebook Link',
                'admin_class' => 'span5 push1'
            ),
            'social_linkedin' => array(
                'type' => 'text',
                'name' => 'LinkedIn Link',
                'admin_class' => 'span6'
            ),
            'social_pinterest' => array(
                'type' => 'text',
                'name' => 'Pinterest Link',
                'admin_class' => 'span5 push1'
            ),
        );

        add_shortcode('team-member', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts, $content){

        extract( shortcode_atts( array(
            'name' => '',
            'title' => '',
            'image' => '',
            'imagelink' => '',
            'social_twitter' => '',
            'social_facebook' => '',
            'social_linkedin' => '',
            'social_pinterest' => '',
            'class' => '',
        ), $atts ) );

        ob_start(); ?>
        <div class="team-member-container <?php echo $class ?>">


            <?php if( !empty($image) ):
                    if( !empty($imagelink) ): ?>
                        <div class="team-member-image">
                            <a href="<?php echo $imagelink ?>" class="team-member-image-link" title="More about <?php echo !empty($name) ? $name : ''; ?>">
                                <div class="rounded-image-container">                        
                                    <img src="<?php echo $image; ?>" alt="<?php echo $name; ?> Profile Image">
                                </div>
                                <div class="team-member-profile-container">
                                    <div class="team-member-profile-table">
                                        <span class="team-member-profile-cell">
                                            <?php _e('View profile', wpGrade_txtd); ?>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>                        
                    <?php else: ?>
                        <div class="team-member-image">
                            <div class="rounded-image-container">                        
                                <img src="<?php echo $image; ?>" alt="<?php echo $name; ?> Profile Image">
                            </div>
                        </div>
                <?php endif; 
                endif; ?>                        

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
        <?php return ob_get_clean();
    }
}
