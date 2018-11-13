<?php
/**
* The include widgets.
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/widgets
*/

// Include Widgets
require_once plugin_dir_path( dirname( __FILE__ ) ) . '/widgets/gags-popular.php'; // include popular posts widgets
require_once plugin_dir_path( dirname( __FILE__ ) ) . '/widgets/gags-recent.php'; // include recent posts widgets
require_once plugin_dir_path( dirname( __FILE__ ) ) . '/widgets/gags-trending.php'; // include trending posts widgets
require_once plugin_dir_path( dirname( __FILE__ ) ) . '/widgets/gags-categories.php'; // include gags category lists widgets
require_once plugin_dir_path( dirname( __FILE__ ) ) . '/widgets/gags-top-users.php'; // include gags top users widgets
?>