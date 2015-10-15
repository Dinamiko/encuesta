<?php
/*
 * Plugin Name: Encuesta
 * Version: 1.0
 * Plugin URI: http://wp.dinamiko.com/demos/encuesta 
 * Description: Ejemplo aplicación web
 * Author: Emili Castells
 * Author URI: http://www.dinamiko.com
 * Requires at least: 4.3
 * Tested up to: 4.3
 *
 * Text Domain: encuesta
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Encuesta' ) ) {

	final class Encuesta {

		private static $instance;

		public static function instance() {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Encuesta ) ) {

				self::$instance = new Encuesta;

				self::$instance->setup_constants();

				add_action( 'plugins_loaded', array( self::$instance, 'encuesta_load_textdomain' ) );
				
				self::$instance->includes();

			}

			return self::$instance;

		}

		public function encuesta_load_textdomain() {

			load_plugin_textdomain( 'encuesta', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 

		}

		private function setup_constants() {

			if ( ! defined( 'ENCUESTA_VERSION' ) ) { define( 'ENCUESTA_VERSION', '1.0' ); }
			if ( ! defined( 'ENCUESTA_BBDD_VERSION' ) ) { define( 'ENCUESTA_BBDD_VERSION', '1.0' ); }
			if ( ! defined( 'ENCUESTA_PLUGIN_DIR' ) ) { define( 'ENCUESTA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) ); }
			if ( ! defined( 'ENCUESTA_PLUGIN_URL' ) ) { define( 'ENCUESTA_PLUGIN_URL', plugin_dir_url( __FILE__ ) ); }
			if ( ! defined( 'ENCUESTA_PLUGIN_FILE' ) ) { define( 'ENCUESTA_PLUGIN_FILE', __FILE__ ); }			

		}

		private function includes() {

			require_once ENCUESTA_PLUGIN_DIR . 'includes/encuesta-load-js-css.php';
			require_once ENCUESTA_PLUGIN_DIR . 'includes/encuesta-functions.php';
			require_once ENCUESTA_PLUGIN_DIR . 'includes/class-encuesta-template-loader.php';
			require_once ENCUESTA_PLUGIN_DIR . 'includes/encuesta-shortcodes.php';			
			require_once ENCUESTA_PLUGIN_DIR . 'includes/encuesta-bbdd.php';
			require_once ENCUESTA_PLUGIN_DIR . 'includes/encuesta-table.php';
			require_once ENCUESTA_PLUGIN_DIR . 'includes/encuesta-install.php';

		}

		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'encuesta' ), ENCUESTA_VERSION );
		}

		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'encuesta' ), ENCUESTA_VERSION );
		}

	}

}

function Encuesta() {

	return Encuesta::instance();

}

Encuesta();