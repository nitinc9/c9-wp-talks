<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://cloudnineapps.com/
 * @since      1.0.0
 *
 * @package    C9_Wp_Talks
 * @subpackage C9_Wp_Talks/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    C9_Wp_Talks
 * @subpackage C9_Wp_Talks/includes
 * @author     Nitin Patil <support@cloudnineapps.com>
 */
class C9_Wp_Talks_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'c9-wp-talks',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
