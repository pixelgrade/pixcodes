<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WpGradeShortcode_Testimonials extends WpGradeShortcode {

	public function __construct( $settings = array() ) {

		$this->self_closed = true;
		$this->direct      = false;
		$this->meta_prefix = get_option( 'wpgrade_metaboxes_prefix' );
		$this->name        = "Testimonials";
		$this->code        = "testimonials";
		$this->icon        = "icon-group";

		$this->params = array(
			'number'  => array(
				'type'        => 'text',
				'name'        => 'Number of Items',
				'admin_class' => 'span6'
			),
			'class'   => array(
				'type'        => 'text',
				'name'        => 'Class',
				'admin_class' => 'span5 push1'
			),
			'orderby' => array(
				'type'        => 'select',
				'name'        => 'Order By',
				'options'     => array( ''      => '-- Default --',
				                        'date'  => 'Date',
				                        'title' => 'Title',
				                        'rand'  => 'Random'
								),
				'admin_class' => 'span6'
			),
			'order'   => array(
				'type'        => 'select',
				'name'        => 'Order',
				'options'     => array( '' => '-- Select order --', 'ASC' => 'Ascending', 'DESC' => 'Descending' ),
				'admin_class' => 'span5 push1'
			),
			array(
				'type'  => 'info',
				'value' => 'If you want specific testimonials, include bellow posts IDs separated by comma.'
			),
			'include' => array(
				'type'        => 'text',
				'name'        => 'Include IDs',
				'admin_class' => 'span6'
			),
			'exclude' => array(
				'type'        => 'text',
				'name'        => 'Exclude IDs',
				'admin_class' => 'span5 push1'
			),
		);

		// allow the theme or other plugins to "hook" into this shortcode's params
		$this->params = apply_filters( 'pixcodes_filter_params_for_' . strtolower( $this->name ), $this->params );

		add_shortcode( 'testimonials', array( $this, 'add_shortcode' ) );

		// frontend assets needs to be loaded after the add_shortcode function
		$this->frontend_assets["js"] = array(
			'columns' => array(
				'name' => 'frontend_testimonials',
				'path' => 'js/shortcodes/frontend_testimonials.js',
				'deps' => array( 'jquery' )
			)
		);
		add_action( 'wp_footer', array( $this, 'load_frontend_assets' ) );
	}

	public function add_shortcode( $atts ) {

		$this->load_frontend_scripts = true;

		// init vars
		$number  = - 1;
		$orderby = 'menu_order';
		$order   = 'ASC';

		extract( shortcode_atts( array(
			'number'  => '-1',
			'order'   => 'DESC',
			'orderby' => 'date',
			'include' => '',
			'exclude' => '',
		), $atts ) );

		/**
		 * Template localization between plugin and theme
		 */
		$located = locate_template( "templates/shortcodes/{$this->code}.php", false, false );
		if ( ! $located ) {
			$located = dirname( __FILE__ ) . '/templates/' . $this->code . '.php';
		}
		// load it
		ob_start();
		require $located;
		return ob_get_clean();
	}
}