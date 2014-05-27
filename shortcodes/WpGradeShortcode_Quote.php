<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Quote extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = false;
        $this->name = "Quote";
        $this->code = "quote";
        $this->icon = "icon-quote-right";
        $this->direct = false;

        $this->params = array(
            'content_text' => array(
                'type' => 'textarea',
                'name' => 'Text',
                'admin_class' => 'span-12',
                'is_content' => true
            ),
            'text_size' => array(
                'type' => 'select',
                'name' => 'Text size',
                'options' => array('small' => 'Small', 'medium' => 'Medium', 'big' => 'Big'),
                'admin_class' => 'span-12'
            ),            
            'author' => array(
                'type' => 'text',
                'name' => 'Author',
                'admin_class' => 'span-6',
            ),

            'link' => array(
                'type' => 'text',
                'name' => 'Author link',
                'admin_class' => 'span-6'
            ),
            'author_title' => array(
                'type' => 'text',
                'name' => 'Author title',
                'admin_class' => 'span-12',
            ),            
        );

	    // allow the theme or other plugins to "hook" into this shortcode's params
	    $this->params = apply_filters('pixcodes_filter_params_for_' . strtolower($this->name), $this->params);

        add_shortcode('quote', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts, $content){
        extract( shortcode_atts( array(
			'content_text' => '',
            'text_size' => 'medium',
			'author' => '',
            'author_title' => '',
			'link' => '',
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
