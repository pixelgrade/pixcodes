<?php
/*
Plugin Name: PixCodes
Plugin URI: http://pixelgrade.com
Description: WordPress shortcodes plugin everywhere. Loaded with shortcodes, awesomeness and more.
Version: 2.0.0
Author: Pixelgrade Media
Author URI: http://pixelgrade.com
Author Email: contact@pixelgrade.com
License:

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

if ( ! defined( 'ABSPATH' ) )
	die('-1');

class WpGradeShortcodes {

    protected static $plugin_dir;
	public $plugin_url;

    function __construct() {
        self::$plugin_dir = dirname( plugin_basename( __FILE__ ) );
		$this->plugin_url = plugin_dir_url(dirname(__FILE__) . '/plugin.php');

	    add_action( 'admin_init', array( $this, 'wpgrade_init_plugin' ) );
		// Register admin styles and scripts
		add_action( 'mce_buttons_2', array( $this, 'register_admin_assets' ) );

		// Register site styles and scripts
		// not used right now
		//add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		//add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_scripts' ) );

        // Run our plugin along with wordpress init
        add_action( 'init', array( $this, 'create_wpgrade_shortcodes' ) );

        add_filter('the_content', array($this, 'wpgrade_remove_spaces_around_shortcodes') );

        // ajax load for modal
        if ( is_admin() ) {
            add_action('wp_ajax_wpgrade_get_shortcodes_modal', array($this, 'wpgrade_get_shortcodes_modal'));
        }

	} // end constructor

	public function wpgrade_init_plugin(){
		$this->plugin_textdomain();
		$this->add_wpgrade_shortcodes_button();
		$this->github_plugin_updater_init();
	}

	public function github_plugin_updater_init() {
		include 'updater.php';
//        define( 'WP_GITHUB_FORCE_UPDATE', true ); // this is only for testing
		if ( is_admin() ) { // note the use of is_admin() to double check that this is happening in the admin
			$config = array(
				'slug' => plugin_basename( __FILE__ ),
				'api_url' => 'https://api.github.com/repos/pixelgrade/pixcodes',
				'raw_url' => 'https://raw.github.com/pixelgrade/pixcodes/update',
				'github_url' => 'https://github.com/pixelgrade/pixcodes/tree/update',
				'zip_url' => 'https://github.com/pixelgrade/pixcodes/archive/update.zip',
				'sslverify' => false,
				'requires' => '3.0',
				'tested' => '3.3',
				'readme' => 'README.md',
//			'access_token' => '',
			);
			new WP_Pixcodes_GitHub_Updater( $config );
		}
	}

	public function plugin_textdomain() {
		$domain = 'wpgrade_txtd';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
        load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
        load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	} // end plugin_textdomain

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_assets($buttons) {
        wp_enqueue_style( 'wpgrade-shortcodes-reveal-styles', $this->plugin_url.'css/base.css', array( 'wp-color-picker' ) );
        wp_enqueue_script('select2-js', $this->plugin_url.'js/select2/select2.js', array('jquery', 'jquery-ui-tabs') );
        wp_enqueue_script('wp-color-picker');
        return $buttons;
	} // end register_admin_assets

	/**
	 * Registers and enqueues plugin-specific styles.Usually we base on the theme style and this is empty
	 */
	public function register_plugin_styles() {
	} // end register_plugin_styles

	/**
	 * Registers and enqueues plugin-specific scripts..Usually we base on theme front-end scripts and this is empty.
	 */
	public function register_plugin_scripts() {
	} // end register_plugin_scripts

	/*--------------------------------------------*
	 * Core Functions
	 *---------------------------------------------*/

	function add_wpgrade_shortcodes_button() {
		//make sure the user has correct permissions
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
			return;
		}
		
        // add to the visual mode only
		if ( get_user_option('rich_editing') == 'true' ) {
            add_filter('mce_external_plugins', array( $this, 'addto_mce_wpgrade_shortcodes') );
            add_filter('mce_buttons', array( $this, 'register_wpgrade_shortcodes_button') );
        }
	} // end action_method_name

	function register_wpgrade_shortcodes_button($buttons) {
        array_push($buttons, "wpgrade");
        return $buttons;
	} // end filter_method_name

    function addto_mce_wpgrade_shortcodes($plugin_array) {
        $plugin_array['wpgrade'] = $this->plugin_url.'js/add_shortcode.js';
        return $plugin_array;
    }

    public function wpgrade_get_shortcodes_modal(){
        ob_start();
        include('views/shortcodes-modal.php');
        echo json_encode(ob_get_clean());
        die();
    }

    public function create_wpgrade_shortcodes(){
        include_once('shortcodes.php');
    }

    function wpgrade_remove_spaces_around_shortcodes($content){
        $array = array (
            '<p>[' => '[',
            ']</p>' => ']',
            ']<br />' => ']'
        );

        $content = strtr($content, $array);
        return $content;
    }

} // end class

$WpGradeShortcodes = new WpGradeShortcodes();