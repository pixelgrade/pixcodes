<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WpGradeShortcode_Circle extends WpGradeShortcode {

	public function __construct( $settings = array() ) {
		$this->self_closed = true;
		$this->name        = __( "Circle Knob", 'pixcodes_txtd' );
		$this->code        = "circle";
		$this->icon        = "icon-circle-blank";
		$this->direct      = false;

		$this->params = array(
			'title'  => array(
				'type'        => 'text',
				'name'        => __( 'Title (inside of circle knob)', 'pixcodes_txtd' ),
				'admin_class' => 'span4'
			),
			'color'  => array(
				'type'        => 'text',
				'name'        => __( 'Color (knob color in HEX format)', 'pixcodes_txtd' ),
				'admin_class' => 'span7 push1'
			),
			'value'  => array(
				'type'        => 'text',
				'name'        => __( 'Value (0 to 100)', 'pixcodes_txtd' ),
				'admin_class' => 'span4'
			),
			'offset' => array(
				'type'        => 'text',
				'name'        => __( 'Offset Angle (starting angle in degrees - default=0)', 'pixcodes_txtd' ),
				'admin_class' => 'span7 push1'
			),
		);

		// allow the theme or other plugins to "hook" into this shortcode's params
		$this->params = apply_filters( 'pixcodes_filter_params_for_' . strtolower( $this->name ), $this->params );

		add_shortcode( 'circle', array( $this, 'add_shortcode' ) );
	}

	public function add_shortcode( $atts, $content ) {

		extract( shortcode_atts( array(
			'title'  => '',
			'color'  => '',
			'value'  => '',
			'offset' => '',
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
