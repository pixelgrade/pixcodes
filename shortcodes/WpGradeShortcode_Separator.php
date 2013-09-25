<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Separator extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = true;
        $this->name = "Separator";
        $this->code = "hr";
        $this->icon = "icon-fire";
        $this->direct = false;

        $this->params = array(
	        'align' => array(
		        'type' => 'select',
		        'name' => 'Alignment',
		        'options' => array('center' => 'Center', 'left' => 'Left', 'right' => 'Right'),
		        'admin_class' => 'span12'
	        ),
	        'size' => array(
		        'type' => 'select',
		        'name' => 'Size',
		        'options' => array('' => 'Regular', 'double' => 'Double'),
		        'admin_class' => 'span6'
	        ),
	        'weight' => array(
		        'type' => 'select',
		        'name' => 'Weight',
		        'options' => array('' => 'Thin', 'thick' => 'Thick'),
		        'admin_class' => 'span5 push1'
	        ),
	        'color' => array(
		        'type' => 'select',
		        'name' => 'Color',
		        'options' => array('' => 'Dark', 'white' => 'Light', 'color' => 'Color'),
		        'admin_class' => 'span6'
	        ),
			'style' => array(
                'type' => 'select',
                'name' => 'Style',
                'options' => array('dotted' => 'Dotted', 'striped' => 'Striped'),
                'admin_class' => 'span5 push1'
            )
        );

	    // allow the theme or other plugins to "hook" into this shorcode's params
	    $this->params = apply_filters('pixcodes_filter_params_for_' . strtolower($this->name), $this->params);
      //var_dump(apply_filters('pixcodes_filter_params_for_' . strtolower($this->name), $this->params));
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
