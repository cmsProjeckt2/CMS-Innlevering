<?php
/**
 * List of files inclusion and functions
 * 
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */

$gags_version = wp_get_theme()->Version;

// Include theme functions
require_once( get_template_directory() . '/functions/theme-functions/theme-widgets.php' ); // Load widgets
require_once( get_template_directory() . '/functions/theme-functions/theme-support.php' ); // Load theme support
require_once( get_template_directory() . '/functions/theme-functions/theme-functions.php' ); // Load custom functions
require_once( get_template_directory() . '/functions/theme-functions/theme-styles.php' ); // Load JavaScript, CSS & comment list layout
require_once( get_template_directory() . '/functions/class-tgm-plugin-activation.php' ); // Load TGM-Plugin-Activation

/**
 * After setup theme
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
function gags_theme_init() {
	add_action( 'widgets_init', 'gags_register_sidebars' );
}
add_action( 'after_setup_theme', 'gags_theme_init' );


/**
 * Loads the Options Panel
 * 
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */

if ( file_exists( get_template_directory() . '/functions/theme-functions/theme-options.php' ) ) {
	require_once( get_template_directory() . '/functions/theme-functions/theme-options.php' );
}

/**
 * Required & recommended plugins
 * *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
function gags_required_plugins() {
	$plugins = array(
		array(
			'name'			=> esc_html__('ZillaShortcodes', 'gags'),
			'version' 		=> '2.0.2',
			'slug'			=> 'zilla-shortcodes',
			'source'		=> esc_url( 'http://plugins.themewarrior.com/zilla-shortcodes.zip' ),
			'external_url'	=> '',
			'required'		=> false,
		),
		array(
			'name'			=> esc_html__('Gags Plugin', 'gags'),
			'version' 		=> '1.1.0',
			'slug'			=> 'gags-plugin',
			'source'		=> esc_url( 'http://plugins.themewarrior.com/gags-plugin/gags-plugin.1.1.0.zip' ),
			'external_url'	=> '',
			'required'		=> true,
		),
		array(
			'name'			=> esc_html__('Video Thumbnails', 'gags'),
			'slug'			=> 'video-thumbnails',
			'required'		=> true,
		),
		array(
			'name'			=> esc_html__('Redux Framework', 'gags'),
			'slug'			=> 'redux-framework',
			'required'		=> true,
		),
		array(
			'name'			=> esc_html__('WP Page-Navi', 'gags'),
			'slug'			=> 'wp-pagenavi',
			'required'		=> true,
		),
		array(
			'name'			=> esc_html__('Yet Another Related Posts Plugin (YARPP)', 'gags'),
			'slug'			=> 'yet-another-related-posts-plugin',
			'required'		=> true,
		),
		array(
			'name'			=> esc_html__('WordPress SEO by Yoast', 'gags'),
			'slug'			=> 'wordpress-seo',
			'required'		=> false,
		),
	);

	$config = array(
		'id'           => 'gags',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'gags-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'gags_required_plugins' );