<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WpGradeShortcode_PixFields extends WpGradeShortcode {

	public function __construct( $settings = array() ) {

		if ( ! function_exists( 'display_pixfields' ) ) {
			return;
		}

		$this->self_closed = true;
		$this->direct      = true;
		$this->name        = "PixFields";
		$this->code        = "pixfields";
		$this->icon        = "icon-list-alt";

		$this->shortcake_support = true;
		$this->shortcake_icon    = 'dashicons-layout';

		add_shortcode( 'pixfields', array( $this, 'add_shortcode' ) );
	}

	public function add_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'align' => '',
			'size'  => '',
			'color' => '',
		), $atts ) );

		$theme_path = apply_filters( 'pixcodes_theme_templates_path_filter', "templates/shortcodes/", $this->code );
		$theme_path = $theme_path . $this->code . 'php';
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
