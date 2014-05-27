<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_TeamMember extends  WpGradeShortcode {

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

	    // allow the theme or other plugins to "hook" into this shortcode's params
	    $this->params = apply_filters('pixcodes_filter_params_for_' . strtolower($this->name), $this->params);

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

	    /**
	     * Template localization between plugin and theme
	     */
	    $located = locate_template("templates/shortcodes/{$this->code}.php", false, false);
	    if(!$located) {
		    $located = dirname(__FILE__).'/templates/'.$this->code.'.php';
	    }
	    // load it
	    ob_start();
	    require $located;
	    return ob_get_clean();
    }
}