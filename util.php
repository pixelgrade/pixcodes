<?php

if (!function_exists('wpgrade_remove_spaces_around_shortcodes')) {

	function wpgrade_remove_spaces_around_shortcodes( $content ) {
		$array = array(
			'<p>[' => '[',
			']</p>' => ']',
			']<br />' => ']'
		);

		$content = strtr( $content, $array );

		return $content;
	}
}

if (!function_exists('wpgrade_parse_shortcode_content')) {

	function wpgrade_parse_shortcode_content( $content ) {

	   /* Parse nested shortcodes and add formatting. */
		$content = trim( do_shortcode( shortcode_unautop( $content ) ) );

		/* Remove '' from the start of the string. */
		if ( substr( $content, 0, 4 ) == '' )
			$content = substr( $content, 4 );

		/* Remove '' from the end of the string. */
		if ( substr( $content, -3, 3 ) == '' )
			$content = substr( $content, 0, -3 );

		/* Remove any instances of ''. */
		$content = str_replace( array( '<p></p>' ), '', $content );
		$content = str_replace( array( '<p> </p>' ), '', $content );
		$content = str_replace( array( '<p>  </p>' ), '', $content );

		return $content;
	}
}