<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WpGradeShortcode_OpenTableReservations extends WpGradeShortcode {

	public function __construct( $settings = array() ) {

		$this->self_closed = true;
		$this->direct      = false;
		$this->name        = "OpenTable Reservations";
		$this->code        = "otreservations";
		$this->icon        = "icon-group";

		$this->params = array(
			'rid' => array(
				'type'        => 'text',
				'name'        => 'OpenTable Restaurant ID',
				'admin_class' => 'span4',
			),
			'title'           => array(
				'type'        => 'text',
				'name'        => 'Title',
				'admin_class' => 'span7 push1',
			),
			'domain_ext' => array(
				'type' => 'select',
				'name' => 'Country',
				'options' => array('' => 'Global / U.S.', 'de' => 'Germany', 'co.uk' => 'United Kingdom', 'jp' => 'Japan', 'com.mx' => 'Mexico'),
				'admin_class' => 'span4'
			),
			'class'           => array(
				'type'        => 'text',
				'name'        => 'Class',
				'admin_class' => 'span7 push1',
			),
			'labels'          => array(
				'type'        => 'switch',
				'name'        => 'Replace Icons with Text?',
				'admin_class' => 'span4',
			),
			'disable_weekends'          => array(
				'type'        => 'switch',
				'name'        => 'Disable Weekends?',
				'admin_class' => 'span7 push1',
			),
		);

		// allow the theme or other plugins to "hook" into this shortcode's params
		$this->params = apply_filters( 'pixcodes_filter_params_for_' . preg_replace('/\s+/', '_', strtolower( $this->name ) ), $this->params );

		add_shortcode( 'otreservations', array( $this, 'add_shortcode' ) );

		// frontend assets needs to be loaded after the add_shortcode function
		$this->frontend_assets["js"] = array(
			'columns' => array(
				'name' => 'frontend_otreservations',
				'path' => 'js/shortcodes/frontend_otreservations.js',
				'deps' => array( 'jquery' )
			)
		);
		add_action( 'wp_footer', array( $this, 'load_frontend_assets' ) );
	}

	public function add_shortcode( $atts ) {

		extract( shortcode_atts( array(
			'rid' => '',
			'title'           => 'Make a Reservation',
			'labels'          => '',
			'class'           => '',
			'domain_ext'      => 'com',
			'date_format'     => 'MM/DD/YYYY', //this can be overwritten by the user
			'disable_weekends' => false,
		), $atts ) );

		$this->load_frontend_scripts = true;

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
