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
            'slider' => array(
                'type' => 'slider',
                'name' => 'Slider',
            ),
            'navigation_style' => array(
                'type' => 'select',
                'name' => 'Navigation Style',
                'options' => array('arrows' => 'Arrows', 'bullets' => 'Bullets', 'both' => 'Arrows and Bullets', 'none' => 'None'),
                'admin_class' => 'span10 push2'
            ),
            'arrows' => array(
                'type' => 'switch',
                'name' => 'Use Arrows for Slider Navigation ?',
                'admin_class' => 'span12 inline'
            ),
            'bullets' => array(
                'type' => 'switch',
                'name' => 'Use Bullets ?',
                'admin_class' => 'span12 inline'
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

//         extract( shortcode_atts( array(
//             'number' => '-1',
//         ), $atts ) );

        // prepare the icons first
        preg_match_all ( '#<icon>(.*?)</icon>#', $this->get_clean_content( $content ), $icons );
        if ( isset( $icons[1] ) ) {
            $icons = $icons[1];
        }
		// prepare content
	    preg_match_all ( '#<body>([\s\S]*?)</body>#', $this->get_clean_content( $content ), $contents );

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
        $title = '';
		$icon = '';
         extract( shortcode_atts( array(
             'title' => '',
             'icon' => ''
         ), $atts ) );

	    /**
	     * Template localization between plugin and theme
	     */
	    $located = locate_template("templates/shortcodes/slider.php", false, false);
	    if(!$located) {
		    $located = dirname(__FILE__).'/templates/slider.php';
	    }
	    // load it
	    ob_start();
	    require $located;
	    return ob_get_clean();
    }
}