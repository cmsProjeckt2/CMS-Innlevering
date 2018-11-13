<?php
/**
* List of theme support functions
*/

// Check if the function exist
if ( function_exists( 'add_theme_support' ) ){

	// Add post thumbnail feature
	add_theme_support( 'post-thumbnails' );

	// Add custom logo support
	add_theme_support( 'custom-logo', array(
		'height'      => 40,
		'width'       => 133,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );
	
	// Add WordPress navigation menus
	add_theme_support( 'nav-menus' );
	register_nav_menus( array(
		'gags-primary-navigation' => esc_html__( 'Primary Navigation', 'gags' ),
		'gags-account-navigation' => esc_html__( 'Account Navigation', 'gags' ),
		'gags-footer-navigation' => esc_html__( 'Footer Navigation', 'gags' ),
	) );

	// Add Title Tag Support
	add_theme_support( 'title-tag' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Add WordPress post format
	add_theme_support( 'post-formats', array( 'image', 'video' )); 

	// Add custom background feature 
	add_theme_support( 'custom-background' );
}

add_action( 'init', 'gags_post_type_support', 10 );
function gags_post_type_support() {
    remove_post_type_support( 'post', 'post-formats' );
}

// Theme Localization
load_theme_textdomain( 'gags', get_template_directory().'/lang' );

// Set maximum image width displayed in a single post or page
if ( ! isset( $gags_content_width ) ) {
	$gags_content_width = 1180;
}
?>