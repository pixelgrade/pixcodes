<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Button extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = false;
        $this->name = "Button";
        $this->code = "button";
        $this->icon = "icon-bookmark";
        $this->direct = false;
	    $this->one_line = true;

        $this->params = array(
            'link' => array(
                'type' => 'text',
                'name' => 'Link',
                'admin_class' => 'span6'
            ),
            'label' => array(
                'type' => 'text',
                'name' => 'Label',
                'admin_class' => 'span5 push1',
                'is_content' => true
            ),
            'class' => array(
                'type' => 'text',
                'name' => 'Class',
                'admin_class' => 'span6'
            ),
            'id' => array(
                'type' => 'text',
                'name' => 'ID',
                'admin_class' => 'span5 push1'
            ),
            'size' => array(
                'type' => 'select',
                'name' => 'Size',
                'options' => array('' => '-- Select Size --', 'small' => 'Small', 'medium' => 'Medium', 'large' => 'Large'),
                'admin_class' => 'span6'
            ),
			'newtab' => array(
                'type' => 'switch',
                'name' => 'Open in a new tab?',
                'admin_class' => 'span5 push1'
            ),
        );

        add_shortcode('button', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts, $content){

        extract( shortcode_atts( array(
			'link' => '',
			'class' => '',
			'id' => '',
			'size' => '',
			'newtab' => '',
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
