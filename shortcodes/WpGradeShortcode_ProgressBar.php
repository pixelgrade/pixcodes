<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_ProgressBar extends WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = true;
        $this->name = "Progress Bar";
        $this->code = "bar";
        $this->icon = "icon-tasks";
        $this->direct = false;

        $this->params = array(
            'title' => array(
                'type' => 'text',
                'name' => 'Title',
                'admin_class' => 'span8'
            ),
	        'markers' => array(
		        'type' => 'switch',
		        'name' => 'Markers',
		        'admin_class' => 'span2 push1'
	        ),
            'progress' => array(
                'type' => 'text',
                'name' => 'Progress',
                'admin_class' => 'span3'
            ),
	        array(
		        'type' => 'info',
		        'value' => 'You can use a simple number to represent the length in pixels or a percentage value (like 96%).',
		        'admin_class' => 'span8 push1'
	        )
        );

	    // allow the theme or other plugins to "hook" into this shortcode's params
	    $this->params = apply_filters('pixcodes_filter_params_for_' . strtolower($this->name), $this->params);

        add_shortcode('bar', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts, $content){
        extract( shortcode_atts( array(
            'title' => '',
			'progress' => '50%',
			'markers' => true,
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
