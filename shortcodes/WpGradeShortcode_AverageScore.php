<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WpGradeShortcode_AverageScore extends WpGradeShortcode {

	public function __construct( $settings = array() ) {
		$this->self_closed = true;
		$this->name        = __( "Average score", 'pixcodes_txtd' );
		$this->code        = "average_score";
		$this->icon        = "icon-tasks";
		$this->direct      = true;
		//	    $this->one_line = true;

		//        $this->params = array(
		//			'score_note' => array(
		//				'type' => 'text',
		//				'name' => 'Text',
		//				'admin_class' => 'span2'
		//			),
		//            'score_desc' => array(
		//                'type' => 'textarea',
		//                'name' => 'Description',
		//                'admin_class' => 'span12',
		//				'is_content' => true
		//            ),
		//        );

		// allow the theme or other plugins to "hook" into this shortcode's params
		$this->params = apply_filters( 'pixcodes_filter_params_for_' . strtolower( $this->name ), $this->params );

		add_shortcode( 'average_score', array( $this, 'add_shortcode' ) );
	}

	public function add_shortcode( $atts, $content ) {

		extract( shortcode_atts( array(
			'score_note' => '0',
			//			'score_desc' => ''
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
