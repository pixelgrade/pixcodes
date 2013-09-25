<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Slider extends  WpGradeShortcode {

    public function __construct($settings = array()) {

        $this->backend_assets["js"] = array(
            'slider' => array(
                'name' => 'slider',
                'path' => 'js/shortcodes/backend_slider.js',
                'deps'=> array( 'jquery' )
            )
        );

        // load backend assets only when an editor is present
        add_action( 'mce_buttons_2', array( $this, 'load_backend_assets' ) );

        $this->self_closed = false;
        $this->direct = false;
        $this->name = "Slider";
        $this->code = "slider";
        $this->icon = "icon-code";

        $this->params = array(
	        'arrows' => array(
		        'type' => 'switch',
		        'name' => 'Use Arrows?',
		        'admin_class' => 'span5 push1'
	        ),
            'bullets' => array(
		        'type' => 'switch',
		        'name' => 'Use Bullets?',
		        'admin_class' => 'span6'
	        ),
            'slider' => array(
                'type' => 'slider',
                'name' => 'Slider',
            ),
        );

	    // allow the theme or other plugins to "hook" into this shorcode's params
	    $this->params = apply_filters('pixcodes_filter_params_for_' . strtolower($this->name), $this->params);

        add_shortcode('slider', array( $this, 'add_slider_shortcode') );
        add_shortcode('slide', array( $this, 'add_slide_shortcode') );

        // frontend assets needs to be loaded after the add_shortcode function
//        $this->frontend_assets["js"] = array(
//            'tabs' => array(
//                'name' => 'frontend_tabs',
//                'path' => 'js/shortcodes/frontend_tabs.js',
//                'deps'=> array( 'jquery' )
//            )
//        );
//        add_action('wp_footer', array($this, 'load_frontend_assets'));

    }

    public function add_slider_shortcode( $atts, $content ) {
	    $arrows = '';
	    $bullets = '';
	    $autoheight = '';
         extract( shortcode_atts( array(
	         'arrows' => 'false',
	         'bullets' => 'true',
	         'autoheight' => 'true'
         ), $atts ) );

	    if ( $arrows == 'true' ) $arrows = 'data-arrows';
	    if ( $bullets == 'true' ) $bullets = 'data-bullets';
		if ( $autoheight == 'true' ) $autoheight = 'data-autoheight';
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

    public function add_slide_shortcode( $atts, $content ) {
//        $title = '';
//		$icon = '';
//         extract( shortcode_atts( array(
//             'title' => '',
//             'icon' => ''
//         ), $atts ) );

	    /**
	     * Template localization between plugin and theme
	     */
	    $located = locate_template("templates/shortcodes/slide.php", false, false);
	    if(!$located) {
		    $located = dirname(__FILE__).'/templates/slide.php';
	    }
	    // load it
	    ob_start();
	    require $located;
	    return ob_get_clean();
    }
}