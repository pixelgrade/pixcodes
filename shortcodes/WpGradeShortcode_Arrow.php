<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WpGradeShortcode_Arrow extends WpGradeShortcode {

	public function __construct( $settings = array() ) {
		$this->self_closed = true;
		$this->direct      = true;
		$this->name        = __( "Arrow", 'pixcodes_txtd' );
		$this->code        = "arrow";
		$this->icon        = "icon-arrow-right";

		add_shortcode( 'arrow', array( $this, 'add_shortcode' ) );
	}

	public function add_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'align' => '',
			'size'  => '',
			'color' => '',
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
