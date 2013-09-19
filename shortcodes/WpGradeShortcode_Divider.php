<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Divider extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = true;
        $this->name = "Divider";
        $this->code = "hr";
        $this->icon = "icon-fire";
        $this->direct = false;

        $this->params = array(
			'style' => array(
                'type' => 'select',
                'name' => 'Style',
                'options' => array('dotted' => 'Dotted', 'striped' => 'Striped'),
                'admin_class' => 'span-6'
            )
        );

        add_shortcode('hr', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts, $content) {
        extract( shortcode_atts( array(
			'style' => ''
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
