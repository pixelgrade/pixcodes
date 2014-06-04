<?php
/*

  Copyright 2013 contact@pixelgrade.com

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

if (!function_exists('wpgrade_remove_spaces_around_shortcodes')) {

	function wpgrade_remove_spaces_around_shortcodes( $content ) {
		$content = shortcode_unautop($content);

		$array = array(
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