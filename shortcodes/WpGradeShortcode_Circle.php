<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Circle extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = true;
        $this->name = "Circle Knob";
        $this->code = "circle";
        $this->icon = "icon-circle-blank";
        $this->direct = false;

        $this->params = array(
            'title' => array(
                'type' => 'text',
                'name' => 'Title (inside of circle knob)',
                'admin_class' => 'span4'
            ),
            'color' => array(
                'type' => 'text',
                'name' => 'Color (knob color in HEX format)',
                'admin_class' => 'span7 push1'
            ),
            'value' => array(
                'type' => 'text',
                'name' => 'Value (0 to 100)',
                'admin_class' => 'span4'
            ),
            'offset' => array(
                'type' => 'text',
                'name' => 'Offset Angle (starting angle in degrees - default=0)',
                'admin_class' => 'span7 push1'
            ),
        );

	    // allow the theme or other plugins to "hook" into this shorcode's params
	    $this->params = apply_filters('pixcodes_filter_params_for_' . strtolower($this->name), $this->params);

        add_shortcode('circle', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts, $content){

        extract( shortcode_atts( array(
            'title' => '',
            'color' => '',
            'value' => '',
            'offset' => '',
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
