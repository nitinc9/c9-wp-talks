<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://cloudnineapps.com/
 * @since             1.0.0
 * @package           C9_Wp_Talks
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Talks
 * Plugin URI:        https://cloudnineapps.com/products/wp-plugins/c9-wp-talks
 * Description:       A simple plugin to capture WordPress talks.
 * Version:           1.0.0
 * Author:            Nitin Patil
 * Author URI:        https://cloudnineapps.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       c9-wp-talks
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'C9_WP_TALKS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-c9-wp-talks-activator.php
 */
function activate_c9_wp_talks() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-c9-wp-talks-activator.php';
	C9_Wp_Talks_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-c9-wp-talks-deactivator.php
 */
function deactivate_c9_wp_talks() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-c9-wp-talks-deactivator.php';
	C9_Wp_Talks_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_c9_wp_talks' );
register_deactivation_hook( __FILE__, 'deactivate_c9_wp_talks' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-c9-wp-talks.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_c9_wp_talks() {

	$plugin = new C9_Wp_Talks();
	$plugin->run();

}
run_c9_wp_talks();
