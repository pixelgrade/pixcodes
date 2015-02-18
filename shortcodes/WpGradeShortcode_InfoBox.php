<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_InfoBox extends  WpGradeShortcode {

    public function __construct($settings = array()) {

        $this->self_closed = false;
        $this->direct = false;
        $this->name = "InfoBox";
        $this->code = "infobox";
        $this->icon = "icon-info";

        $this->params = array(
            'title' => array(
                'type' => 'text',
                'name' => 'Title',
                'admin_class' => 'span6'
            ),
            'align' => array(
                'type' => 'select',
                'name' => 'Align',
                'options' => array('' => '-- Align --', 'align-left' => 'Left', 'align-center' => 'Center', 'align-right' => 'Right'),
                'admin_class' => 'span5 push1'
            ),
            'subtitle' => array(
                'type' => 'text',
                'name' => 'Subtitle',
                'admin_class' => 'span12'
            ),
            'content_text' => array(
			    'type' => 'textarea',
			    'name' => 'Text',
			    'admin_class' => 'span12',
			    'is_content' => true
		    ),
        );

	    // allow the theme or other plugins to "hook" into this shortcode's params
	    $this->params = apply_filters('pixcodes_filter_params_for_' . strtolower($this->name), $this->params);

        // add_shortcode('tabs', array( $this, 'add_tabs_shortcode') );
        add_shortcode('infobox', array( $this, 'add_infobox_shortcode') );

    }

    public function add_infobox_shortcode( $atts, $content ) {
        $title = $align = $subtitle = ''; // init vars
         extract( shortcode_atts( array(
             'title' => '',
             'align' => 'align-left',
             'subtitle' => ''
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