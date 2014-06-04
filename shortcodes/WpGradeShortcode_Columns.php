<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Columns extends  WpGradeShortcode {

    public function __construct($settings = array()) {

        $this->backend_assets["js"] = array(
            'columns' => array(
                'name' => 'columns',
                'path' => 'js/shortcodes/backend_columns.js',
                'deps'=> array( 'jquery' )
            )
        );

        // load backend assets only when an editor is present
        add_action( 'mce_buttons_2', array( $this, 'load_backend_assets' ) );

        $this->self_closed = false;
        $this->name = "Columns";
        $this->code = "columns";
        $this->icon = "icon-th-list";
        $this->direct = false;

        $this->params = array(
            'cols_nr' => array(
                'type' => 'select',
                'name' => 'No. of columns:',
                'options' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '6' => '6'),
                'admin_class' => 'span3 strong'
            ),
             'bg_color' => array(
                'type' => 'color',
                'name' => 'Background Color',
                'admin_class' => 'span7 push1'
            ),
            'full_width' => array(
                'type' => 'switch',
                'name' => 'Full Width Background ?',
                'admin_class' => 'span5 inline full_width_bg'
            ),
            'cols_slider' =>array(
                'type' => 'grid',
                'name' => 'Drag handlers to change the columns width.'
            ),
	        'inner' => array(
		        'type' => 'switch',
		        'name' => 'Inner Row ?',
		        'admin_class' => 'span3'
	        ),
	        'inner_info' => array(
		        'type' => 'info',
		        'value' => 'You can create level 2 rows by checking this checkbox.',
		        'admin_class' => 'span8 push1'
	        ),
            'class' => array(
                'type' => 'tags',
                'name' => 'Custom CSS Class',
                'admin_class' => 'span12',
                'options' => array( 'narrow', 'inverse'),
                'value' => array( '' )
            ),
        );

	    // allow the theme or other plugins to "hook" into this shortcode's params
	    $this->params = apply_filters('pixcodes_filter_params_for_' . strtolower($this->name), $this->params);

        add_shortcode('col', array( $this, 'add_column_shortcode') );
        add_shortcode('row', array( $this, 'add_row_shortcode') );

	    // Create second level shortcodes
	    add_shortcode('col_inner', array( $this, 'add_column_shortcode') );
	    add_shortcode('row_inner', array( $this, 'add_row_shortcode') );
    }

    public function add_row_shortcode($atts, $content){
        $class = '';
        $bg_color = '';

        extract( shortcode_atts( array(
            'bg_color' => '',
            'full_width' => '',
            'class' => '',
            'thick_gutter' => '',
        ), $atts ) );

        if ( !empty($bg_color) ) {
            if ( substr($bg_color, 0, 1 ) != '#' ) {
                $bg_color = '#'. $bg_color;
            }
        }

        $is_narrow = false;
        $classes = explode(" ", $class);
        foreach ($classes as $my_class):
            if ($my_class == "narrow") $is_narrow = true;
        endforeach;

	    /**
	     * Template localization between plugin and theme
	     */
	    $located = locate_template("templates/shortcodes/row.php", false, false);
	    if(!$located) {
		    $located = dirname(__FILE__).'/templates/row.php';
	    }
	    // load it
	    ob_start();
	    require $located;
	    return ob_get_clean();
    }

    public function add_column_shortcode($atts, $content){
        $size = '';
        $class= '';

        extract( shortcode_atts( array(
            'size' => '1',
            'class' => ''
        ), $atts ) );

	    /**
	     * Template localization between plugin and theme
	     */
	    $located = locate_template("templates/shortcodes/col.php", false, false);
	    if(!$located) {
		    $located = dirname(__FILE__).'/templates/col.php';
	    }
	    // load it
	    ob_start();
	    require $located;
	    return ob_get_clean();
    }
}