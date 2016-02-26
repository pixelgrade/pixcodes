<?php

defined( 'WPGRADE_SHORTCODES_PATH' ) or define( 'WPGRADE_SHORTCODES_PATH', plugin_dir_path( __FILE__ ) );
defined( 'WPGRADE_SHORTCODES_URL' ) or define( 'WPGRADE_SHORTCODES_URL', plugin_dir_url( dirname( __FILE__ ) . '/shortcodes.php' ) );

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

require_once 'util.php';

class WpGradeShortcode {

	public $plug_dir;
	protected $shortcode;
	protected $settings;
	protected $params;
	protected $self_closed;
	protected $one_line;
	protected $code;
	protected $direct;
	protected $icon;
	protected $shortcodes;
	protected $name;
	protected $backend_assets;
	protected $frontend_assets;
	protected $load_frontend_scripts;
	protected $shortcake_support;
	//we use this to get the prefix for the meta data from the theme - usually it's short theme name
	protected $meta_prefix;

	public function __construct() {

		$this->plug_dir    = plugins_url();
		$this->self_closed = false;
		$this->one_line    = false;
		$this->shortcake_support    = false;
		$this->shortcodes  = array();

		$this->autoload();

		// init assets list // useless
		$this->assets = array(
			'js'  => array(),
			'css' => array()
		);
	}

	public function autoload() {

		$shortcodes = get_option( 'wpgrade_shortcodes_list' );

		if ( empty( $shortcodes ) ) {
			$shortcodes = array(
				'Arrow',
				'AverageScore',
				'Button',
				'Circle',
				'Columns',
				'Heading',
				'Icon',
				'InfoBox',
				'OpenTableReservations',
				'Portfolio',
				'ProgressBar',
				'Quote',
				'RestaurantMenu',
				'Separator',
				'Slider',
				'Tabs',
				'TeamMember',
				'Testimonials',
				'PixFields'
			);
		}

		foreach ( $shortcodes as $file ) {

			$file_name = 'WpGradeShortcode_' . $file . '.php';
			$file_path = WPGRADE_SHORTCODES_PATH . '/shortcodes/' . $file_name;

			if ( ! file_exists( $file_path ) ) {
				continue;
			}

			include_once( $file_path );
			$shortcode_class = 'WpGradeShortcode_' . $file;
			$shortcode       = new $shortcode_class();

			// create a list of params needed for js to create the admin panel
			$this->shortcodes[ $shortcode_class ]["name"]        = $shortcode->name;
			$this->shortcodes[ $shortcode_class ]["code"]        = $shortcode->code;
			$this->shortcodes[ $shortcode_class ]["self_closed"] = $shortcode->self_closed;
			$this->shortcodes[ $shortcode_class ]["direct"]      = $shortcode->direct;
			$this->shortcodes[ $shortcode_class ]["one_line"]    = $shortcode->one_line;
			$this->shortcodes[ $shortcode_class ]["icon"]        = $shortcode->icon;
			if ( $shortcode->direct == false ) {
				$this->shortcodes[ $shortcode_class ]["params"] = $shortcode->params;
			}

			if ( $shortcode->shortcake_support && function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
				$this->register_shortcode_ui( $shortcode );
			}
		}
	}


	function register_shortcode_ui ( $shortcode ) {

		$ui_args = array(
			'label'         => $shortcode->name,
			'listItemImage' => $shortcode->shortcake_icon
		);

		if ( ! $shortcode->code === 'columns' ) {
			$shortcode->code = 'row';
		}

		if ( isset( $shortcode->params ) && is_array( $shortcode->params ) && ! empty( $shortcode->params ) ) {

			foreach ( $shortcode->params as $key => $param ) {

				if ( 'label' === $param['type'] || 'info' === $param['type'] ) {
					continue;
				}

				$this_param_args = array(
					'attr'        => $key,
					'type'        => $param['type'],
					/*
					 * These arguments are passed to the instantiation of the media library:
					 * 'libraryType' - Type of media to make available.
					 * 'addButton' - Text for the button to open media library.
					 * 'frameTitle' - Title for the modal UI once the library is open.
					 */
					//					'libraryType' => array( 'image' ),
										//'addButton'   => 'what?',
					//					'frameTitle'  => $param['name'],
				);

				if ( isset( $param['name'] ) ) {
					$this_param_args['label'] = $param['name'];
				}

				if ( isset( $param['is_content'] )|| 'grid' === $param['type'] ) {
					$ui_args['inner_content']['label'] = $param['name'];
					$ui_args['inner_content']['description'] = esc_html__( 'The inner content', 'shortcode-ui' );
					continue;
				}

				if ( ( 'select' === $param['type'] || 'radio' === $param['type'] ) && isset( $param['options'] ) ){
					$this_param_args['options'] = $param['options'];
				}

				if ( ( 'tags' === $param['type'] ) && isset( $param['options'] ) ){
					$this_param_args['options'] =  $param['options'];
				}

				if ( 'switch' === $param['type'] ){
					$this_param_args['type'] = 'checkbox';
				}

				if ( 'size' === $param['type'] ) {
					$this_param_args['type'] = 'range';
				}

				if ( 'image' === $param['type'] ) {
					$this_param_args['type'] = 'attachment';
				}

				if ( isset(  $param['predefined'] ) ) {
					$this_param_args['default'] = $param['predefined'] ;
				}

				if ( 'icon_list' === $param['type'] && isset( $param['icons'] ) ){
					$this_param_args['type'] = 'select';
					$this_param_args['options'] = $param['icons'];/// array_fill_keys( array_flip ( $param['icons'] ), $key );
				}

				if ( 'grid' === $param['type'] ) {
					$args['code'] = 'row';
				}

				$ui_args['attrs'][] = $this_param_args;
			}
		}

		shortcode_ui_register_for_shortcode( $shortcode->code, $ui_args );
	}

	public function get_shortcodes() {
		return $this->shortcodes;
	}

	public function get_code() {
		return $this->code;
	}

	public function load_backend_assets( $buttons ) {

		if ( ! empty( $this->backend_assets ) ) {
			$types = $this->backend_assets;

			foreach ( $types as $type => $assets ) {
				foreach ( $assets as $key => $asset ) {
					$path = WPGRADE_SHORTCODES_URL . $asset['path'];
					if ( $type == 'js' ) {
						wp_enqueue_script( $asset['name'], $path, $asset['deps'] );
					} elseif ( $type == 'css' ) {
						wp_enqueue_style( $asset['name'], $path, $asset['deps'] );
					}
				}
			}
		}

		// do not modify buttons here ... we just add our scripts
		return $buttons;
	}

	public function load_frontend_assets() {

		if ( ! empty( $this->frontend_assets ) && $this->load_frontend_scripts == true ) {
			$types = $this->frontend_assets;

			foreach ( $types as $type => $assets ) {
				foreach ( $assets as $key => $asset ) {
					$path = WPGRADE_SHORTCODES_URL . $asset['path'];
					if ( $type == 'js' ) {
						wp_enqueue_script( $asset['name'], $path, $asset['deps'] );
					} elseif ( $type == 'css' ) {
						wp_enqueue_style( $asset['name'], $path, $asset['deps'] );
					}
				}
			}
		}
	}

	public function get_clean_content( $content ) {
		$content = preg_replace( '#<br class="pxg_removable" />#', '', $content ); // remove our temp brs

		return do_shortcode( $content );
	}

	public function render_param( $param ) {

		$file_name = $param['type'] . '.php';
		$file_path = WPGRADE_SHORTCODES_PATH . 'params/' . $file_name;

		if ( ! file_exists( $file_path ) ) {
			echo '<span class="error">Inexistent param</span>';
		}
		ob_start();

		include( $file_path );

		echo ob_get_clean();
	}
}

global $wpgrade_shortcodes;
$wpgrade_shortcodes = new WpGradeShortcode();