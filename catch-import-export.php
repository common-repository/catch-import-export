<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              catchplugins.com
 * @since             1.0
 * @package           Catch_Import_Export
 *
 * @wordpress-plugin
 * Plugin Name:       Catch Import Export
 * Plugin URI:        catchplugin.com/plugins/catch-import-export/
 * Description:       Catch Import Export is a simple and easy-to-use import-export plugin that addresses the need for importing and exporting of customizer settings from any WordPress theme to another website without any exertion.
 * Version:           2.2.1
 * Author:            Catch Plugins
 * Author URI:        catchplugins.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       catch-import-export
 * Tags:              customizer export, customizer import, export, import, customizer, customizer settings
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CATCH_IMPORT_EXPORT_VERSION', '2.2.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-import-export-activator.php
 */
if ( ! defined( 'CATCH_IMPORT_EXPORT_URL' ) ) {
	define( 'CATCH_IMPORT_EXPORT_URL', plugin_dir_url( __FILE__ ) );
}


// The absolute path of the directory that contains the file
if ( ! defined( 'CATCH_IMPORT_EXPORT_PATH' ) ) {
	define( 'CATCH_IMPORT_EXPORT_PATH', plugin_dir_path( __FILE__ ) );
}


// Gets the path to a plugin file or directory, relative to the plugins directory, without the leading and trailing slashes.
if ( ! defined( 'CATCH_IMPORT_EXPORT_BASENAME' ) ) {
	define( 'CATCH_IMPORT_EXPORT_BASENAME', plugin_basename( __FILE__ ) );
}
function activate_catch_import_export() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-catch-import-export-activator.php';
	Catch_Import_Export_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-import-export-deactivator.php
 */
function deactivate_catch_import_export() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-catch-import-export-deactivator.php';
	Catch_Import_Export_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_catch_import_export' );
register_deactivation_hook( __FILE__, 'deactivate_catch_import_export' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-catch-import-export.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0
 */
function run_catch_import_export() {

	$plugin = new Catch_Import_Export();
	$plugin->run();

}
run_catch_import_export();
/* CTP tabs removal options */
require plugin_dir_path( __FILE__ ) . '/includes/ctp-tabs-removal.php';

 $ctp_options = ctp_get_options();
if ( 1 == $ctp_options['theme_plugin_tabs'] ) {
	/* Adds Catch Themes tab in Add theme page and Themes by Catch Themes in Customizer's change theme option. */
	if ( ! class_exists( 'CatchThemesThemePlugin' ) && ! function_exists( 'add_our_plugins_tab' ) ) {
		require plugin_dir_path( __FILE__ ) . '/includes/CatchThemesThemePlugin.php';
	}
}
