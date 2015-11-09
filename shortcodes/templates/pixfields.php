<?php

if ( function_exists('display_pixfields') ) {

	global $pixfields_plugin;

	if ( isset( $pixfields_plugin->plugin_settings['display_place'] ) ) { // && $pixfields_plugin::$plugin_settings['display_place'] == 'shortcode' ) {
		display_pixfields();
	}
}