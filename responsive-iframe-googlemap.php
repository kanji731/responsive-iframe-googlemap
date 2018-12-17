<?php

/*
Plugin Name: Responsive iframe GoogleMap
Plugin URI:
Description: Responsive-friendly free GoogleMap. It can be easily arranged with a short code.
Version: 1.0.2
Author: PRESSMAN
Author URI: https://www.pressman.ne.jp/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WP_Responsive_Iframe_GoogleMap {

	private static $instance;

	// Default Position
	const WIDTH = 860;
	const HEIGHT = 500;
	const ZOOM = 16;
	const ADDRESS = '"Tokyo Station"';
	const BORDER = '"1px solid #ccc"';
	const LATITUDE = '35.681236';
	const LONGITUDE = '139.767125';

	private $dom_count = 0;

	public function __construct() {
		add_shortcode( 'responsive_map', [ $this, 'responsive_map_func' ] );

		add_filter( 'mce_external_plugins', [ $this, 'add_original_tinymce_button_plugin' ] );
		add_filter( 'mce_buttons', [ $this, 'add_original_tinymce_button' ] );
		add_action( 'admin_print_footer_scripts', [ $this, 'add_custom_quicktags' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'my_scripts_method' ] );
	}

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}
	}

	/**
	 * Return a list of constants.
	 *
	 * @return array Constant list
	 * @throws ReflectionException
	 */
	static function getConstants() {
		$oClass = new ReflectionClass( __CLASS__ );

		return $oClass->getConstants();
	}

	/**
	 * Show GoogleMap from shortcode.
	 *
	 * @param $atts shortcode value
	 *
	 * @return string iframe html
	 */
	public function responsive_map_func( $atts ) {
		if ( isset( $atts['latitude'] ) && isset( $atts['longitude'] ) ) {
			$atts = shortcode_atts(
				[
					'width'     => self::WIDTH,
					'height'    => self::HEIGHT,
					'latitude'  => self::LATITUDE,
					'longitude' => self::LONGITUDE,
					'zoom'      => self::ZOOM,
					'border'    => self::BORDER
				], $atts, 'responsive_map' );

			$html = "<div class='responsive-map{$this->dom_count}'>" .
			        "<iframe width='{$atts['width']}' height='{$atts['height']}' src='http://maps.google.co.jp/maps?&output=embed&q={$atts['latitude']},{$atts['longitude']}&z={$atts['zoom']}'>" .
			        "</iframe>" .
			        "</div>" .
			        "<style>.responsive-map{$this->dom_count} > iframe{border: {$atts['border']};}</style>";
		} else {
			$atts = shortcode_atts(
				[
					'width'   => self::WIDTH,
					'height'  => self::HEIGHT,
					'address' => self::ADDRESS,
					'zoom'    => self::ZOOM,
					'border'  => self::BORDER
				], $atts, 'responsive_map' );

			$html = "<div class='responsive-map{$this->dom_count}'>" .
			        "<iframe width='{$atts['width']}' height='{$atts['height']}' src='http://maps.google.co.jp/maps?&output=embed&q={$atts['address']}&z={$atts['zoom']}'>" .
			        "</iframe>" .
			        "</div>" .
			        "<style>.responsive-map{$this->dom_count} > iframe{border: {$atts['border']};}</style>";
		}

		$this->dom_count ++;

		return $html;
	}

	/**
	 * Added a button for entering a shortcode for responsive-map on the visual tab of the post entry screen.
	 *
	 * @param $plugin_array
	 *
	 * @return mixed
	 * @throws ReflectionException
	 */
	public function add_original_tinymce_button_plugin( $plugin_array ) {
		$consts = $this->getConstants();
		foreach ( $consts as $key => $value ) {
			echo "<script type='text/javascript'> var {$key} = '{$value}';</script>";
		}

		$plugin_array['responsive_map_original_tinymce_button_plugin'] = plugin_dir_url( __FILE__ ) . '/assets/js/responsive-map-shortcode-btm.js';

		return $plugin_array;
	}

	/**
	 * Add button to tinymce.
	 *
	 * @param $buttons
	 *
	 * @return array
	 */
	public function add_original_tinymce_button( $buttons ) {
		$buttons[] = 'responsive_map_recommended';

		return $buttons;
	}

	/**
	 * Added a button for entering a shortcode for responsive-map on the text tab of the post entry screen.
	 */
	public function add_custom_quicktags() {
		if ( wp_script_is( 'quicktags' ) ) {
			echo "<script type='text/javascript'>" .
			     "QTags.addButton(" .
			     "'responsive_map', 'responsive_map', '[responsive_map width=" . self::WIDTH . " height=" . self::HEIGHT . " address=" . self::ADDRESS . " zoom=" . self::ZOOM . " border=" . self::BORDER . "]', '', '', 'shortcode to display Google Maps.', 1" .
			     ");" .
			     "</script>";
		}
	}

	/**
	 * Load css
	 */
	public function my_scripts_method() {
		global $post;

		if ( isset( $post ) && isset( $post->post_content ) && has_shortcode( $post->post_content, 'responsive_map' ) ) {
			wp_enqueue_style( 'responsive-map' . '-style', plugin_dir_url( __FILE__ ) . '/assets/css/style.css' );
		}
	}
}

WP_Responsive_Iframe_GoogleMap::get_instance();
