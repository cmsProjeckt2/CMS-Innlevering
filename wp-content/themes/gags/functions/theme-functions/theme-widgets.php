<?php
/**
 * Function to register widget areas
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
if ( ! function_exists( 'gags_register_sidebars' ) ) {
	function gags_register_sidebars(){
		// Sidebar Widget
		if ( function_exists( 'register_sidebar' ) ) {
			register_sidebar( array(
				'name' => esc_html__( 'Sidebar - Default', 'gags' ),
				'id' => 'gags-sidebar',
				'description' => esc_html__('Widgets will be displayed in right sidebar.', 'gags'),
				'class' => '',
				'before_widget' => '<div id="widget-%1$s" class="sidebar-widget widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
			) );
		}

		// Sidebar - Gag Detail Widget
		if ( function_exists( 'register_sidebar' ) ) {
			register_sidebar( array(
				'name' => esc_html__( 'Sidebar - Detail', 'gags' ),
				'id' => 'gags-sidebar-detail',
				'description' => esc_html__('Widgets will be displayed in right sidebar.', 'gags'),
				'class' => '',
				'before_widget' => '<div id="widget-%1$s" class="sidebar-widget widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
			) );
		}
	}
}

/**
 * Function to remove default widgets after theme switch
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
if ( ! function_exists( 'gags_removed_default_widgets' ) ) {
	function gags_removed_default_widgets(){
		global $wp_registered_sidebars;
		$widgets = get_option( 'sidebars_widgets' );
		foreach ( $wp_registered_sidebars as $sidebar=>$value ) {
			unset( $widgets[$sidebar] );
		}
		update_option( 'sidebars_widgets', $widgets );
	}
}

if ( is_admin() && $pagenow == 'themes.php' && isset( $_GET['activated'] ) )
	add_action( 'admin_init', 'gags_removed_default_widgets' );

// Load Custom Widgets
include_once( get_template_directory() . '/includes/widgets/gags-custom-menu.php' ); // include gags custom menu widgets
include_once( get_template_directory() . '/includes/widgets/gags-category-list.php' ); // include gags custom category list widgets
?>