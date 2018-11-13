<?php
/**
* The create shortcode class.
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* Gags_Plugin_Shortcodes class.
*/
class Gags_Plugin_Shortcodes {
	// Dashboard shortcode functions
	public static function gags_dashboard_shortcode_func() {
		get_gags_template( 'gags-dashboard.php' );
	}

	// Submit gags shortcode functions
	public static function gags_submit_shortcode_func() {
		get_gags_template( 'gags-submit.php' );
	}

	// Register shortcode functions
	public static function gags_register_shortcode_func() {
		get_gags_template( 'gags-register.php' );
	}

	// Login shortcode functions
	public static function gags_login_shortcode_func() {
		get_gags_template( 'gags-login.php' );
	}

	// Edit profile shortcode functions
	public static function gags_edit_profile_shortcode_func() {
		get_gags_template( 'gags-edit-profile.php' );
	}

	// Edit password shortcode functions
	public static function gags_edit_password_shortcode_func() {
		get_gags_template( 'gags-edit-password.php' );
	}

	// Lost password shortcode functions
	public static function gags_lost_password_shortcode_func() {
		get_gags_template( 'gags-lost-password.php' );
	}

	// Recent gags shortcode functions
	public static function gags_recent_gags_shortcode_func() {
		get_gags_template( 'gags-recent-gags.php' );
	}

	// Trending gags shortcode functions
	public static function gags_trending_gags_shortcode_func() {
		get_gags_template( 'gags-trending-gags.php' );
	}

	// Popular gags shortcode functions
	public static function gags_popular_gags_shortcode_func($atts) {
		get_gags_template( 'gags-popular-gags.php' );
	}
}

// Create gags-plugin shortcode
add_shortcode( 'gags_dashboard', array( 'Gags_Plugin_Shortcodes', 'gags_dashboard_shortcode_func' ) );
add_shortcode( 'gags_submit', array( 'Gags_Plugin_Shortcodes', 'gags_submit_shortcode_func' ) );
add_shortcode( 'gags_register', array( 'Gags_Plugin_Shortcodes', 'gags_register_shortcode_func' ) );
add_shortcode( 'gags_login', array( 'Gags_Plugin_Shortcodes', 'gags_login_shortcode_func' ) );
add_shortcode( 'gags_edit_profile', array( 'Gags_Plugin_Shortcodes', 'gags_edit_profile_shortcode_func' ) );
add_shortcode( 'gags_edit_password', array( 'Gags_Plugin_Shortcodes', 'gags_edit_password_shortcode_func' ) );
add_shortcode( 'gags_lost_password', array( 'Gags_Plugin_Shortcodes', 'gags_lost_password_shortcode_func' ) );
add_shortcode( 'gags_recent_posts', array( 'Gags_Plugin_Shortcodes', 'gags_recent_gags_shortcode_func' ) );
add_shortcode( 'gags_trending_posts', array( 'Gags_Plugin_Shortcodes', 'gags_trending_gags_shortcode_func' ) );
add_shortcode( 'gags_popular_posts', array( 'Gags_Plugin_Shortcodes', 'gags_popular_gags_shortcode_func' ) );