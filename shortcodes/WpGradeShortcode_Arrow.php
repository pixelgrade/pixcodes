<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WpGradeShortcode_Arrow extends WpGradeShortcode {

	public function __construct( $settings = array() ) {
		$this->self_closed       = true;
		$this->direct            = true;
		$this->name              = esc_html__( "Arrow", 'pixcodes_txtd' );
		$this->code              = "arrow";
		$this->icon              = "icon-arrow-right";
		$this->shortcake_support = true;
		$this->shortcake_icon    = 'dashicons-plus-alt';

		add_shortcode( 'arrow', array( $this, 'add_shortcode' ) );
	}

	public function add_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'align' => '',
			'size'  => '',
			'color' => '',
		), $atts ) );

		$theme_path = apply_filters( 'pixcodes_theme_templates_path_filter', "templates/shortcodes/", $this->code );
		$theme_path = $theme_path . $this->code . '.php';
		/**
		 * Template localization between plugin and theme
		 */
		$located = locate_template( $theme_path, false, false );
		if ( ! $located ) {
			$located = dirname( __FILE__ ) . '/templates/' . $this->code . '.php';
		}
		// load it
		ob_start();
		require $located;

		return ob_get_clean();
	}
}
