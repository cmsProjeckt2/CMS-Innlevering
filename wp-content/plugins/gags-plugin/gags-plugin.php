<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.themewarrior.com
 * @since             1.1.0
 * @package           Gags_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Gags Plugin
 * Plugin URI:        http://www.themewarrior.com
 * Description:       Plugin for Gags WordPress theme.
 * Version:           1.1.0
 * Author:            ThemeWarrior
 * Author URI:        http://www.themewarrior.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gags-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gags-plugin-activator.php
 */
function activate_gags_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gags-plugin-activator.php';
	Gags_Plugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gags-plugin-deactivator.php
 */
function deactivate_gags_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gags-plugin-deactivator.php';
	Gags_Plugin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_gags_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_gags_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-gags-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_gags_plugin() {

	$plugin = new Gags_Plugin();
	$plugin->run();

}
run_gags_plugin();
