<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Portfolio extends  WpGradeShortcode {

    public function __construct($settings = array()) {

        $this->self_closed = true;
        $this->direct = false;
        $this->name = "Portfolio";
        $this->code = "portfolio";
        $this->icon = "icon-qrcode";

	    // prepare categories
	    $opts_cats = get_terms('portfolio_cat', array( 'fields' => 'all' ) );
	    $all_categories = array();

	    if ( !empty($opts_cats) && !is_wp_error( $opts_cats )) {
		    foreach( $opts_cats as $key => $opt_cat ) {
			    $all_categories[$key] = $opt_cat->slug;
		    }
	    }

        $this->params = array(
	        'title' => array(
		        'type' => 'text',
		        'name' => 'Title',
		        'admin_class' => 'span12'
	        ),
            'number' => array(
                'type' => 'text',
                'name' => 'Number of Items',
                'admin_class' => 'span6'
            ),
            'class' => array(
                'type' => 'text',
                'name' => 'Class',
                'admin_class' => 'span5 push1'
            ),
	        'orderby' => array(
		        'type' => 'select',
		        'name' => 'Order By',
		        'options' => array('' => '-- Default --', 'date' => 'Date', 'title' => 'Title', 'rand' => 'Random'),
		        'admin_class' => 'span6'
	        ),
	        'order' => array(
		        'type' => 'select',
		        'name' => 'Order',
		        'options' => array('' => '-- Select order --', 'ASC' => 'Ascending', 'DESC' => 'Descending'),
		        'admin_class' => 'span5 push1'
	        ),
            array(
                'type' => 'info',
                'value' => 'If you want specific projects, include bellow posts IDs separated by comma.'
            ),
            'include' => array(
	            'type' => 'text',
	            'name' => 'Include IDs',
	            'admin_class' => 'span6'
            ),
                'exclude' => array(
                'type' => 'text',
                'name' => 'Exclude IDs',
                'admin_class' => 'span5 push1'
            ),
	        'category' => array(
		        'type' => 'tags',
		        'name' => 'Category',
		        'admin_class' => 'span12',
		        'options' => $all_categories,
		        'value' => array( '' )
	        ),
        );

	    // allow the theme or other plugins to "hook" into this shortcode's params
	    $this->params = apply_filters('pixcodes_filter_params_for_' . strtolower($this->name), $this->params);

        add_shortcode('portfolio', array( $this, 'add_shortcode') );

    }

    public function add_shortcode($atts){

        $this->load_frontend_scripts = true;

        // init vars
        $number = -1;
        $orderby = 'menu_order';
        $order = 'ASC';
	    $class = $title = '';
         extract( shortcode_atts( array(
	         'title' => '',
             'number' => '-1',
             'order' => 'ASC',
             'orderby' => 'menu_order',
             'include' => '',
             'exclude' => '',
	         'class' => '',
	         'category' => ''
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