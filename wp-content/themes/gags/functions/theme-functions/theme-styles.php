<?php
/**
 * Function to load JS & CSS files
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */

if ( ! function_exists( 'gags_enqueue_scripts' ) ) {
	function gags_enqueue_scripts() {
		global $pagenow;
		
		// Only load these scripts on frontend
		if( !is_admin() && $pagenow != 'wp-login.php' ) {

			// Load all Javascript files
			wp_enqueue_script('jquery');

			if ( is_singular() ) {
				wp_enqueue_script( 'comment-reply' );
			}

			wp_enqueue_script( 'fluidvids', get_template_directory_uri() .'/js/fluidvids.js', '', '1.1', true );	
			wp_enqueue_script( 'jrespond', get_template_directory_uri() .'/js/jrespond.min.js', '', '0.10', true );
			wp_enqueue_script( 'gags-functions', get_template_directory_uri() .'/js/functions.js', '', null, true );

			// Load all CSS files
			wp_enqueue_style( 'gags-reset', get_template_directory_uri() .'/css/reset.css', array(), false, 'all' );
			wp_enqueue_style( 'font-awesome', get_template_directory_uri() .'/fonts/fontawesome/css/font-awesome.min.css', array(), false, 'all' );
			wp_enqueue_style( 'owl-carousel', get_template_directory_uri() .'/css/owl.carousel.css', array(), false, 'all' );
			wp_enqueue_style( 'gags-style', get_template_directory_uri() .'/style.css', array(), false, 'all' );
			wp_enqueue_style( 'gags-responsive', get_template_directory_uri() .'/css/responsive.css', array(), false, 'all' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'gags_enqueue_scripts' );


/**
 * Function to generate the several styles from theme options
 *
 * @package WordPress
 * @subpackage Hospitalplus
 * @since Hospitalplus 1.0.0
 */
if ( ! function_exists( 'gags_add_styles_theme_options' ) ) {
	function gags_add_styles_theme_options() {
		global $gags_option;
?>
		<?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>
		<?php if ( is_plugin_active( 'redux-framework/redux-framework.php' ) ) : // check if plugin is activated ?>
			<style type="text/css">
				nav#main-menu.site-navigation ul li.current-menu-item > a,
				nav#main-menu.site-navigation ul li.current-menu-ancestor > a {
					color: <?php echo isset($gags_option['gags_main_menu_link_color']['hover']) ? $gags_option['gags_main_menu_link_color']['hover'] : '' ; ?> !important;
					background-color: <?php echo isset($gags_option['gags_menu_hover_background']['background-color']) ? $gags_option['gags_menu_hover_background']['background-color'] : ''; ?> !important;
				}

				.pagination span,
				.pagination a {
					box-shadow: 0 0 5px <?php echo isset($gags_option['gags_paging_shadow']['rgba']) ? $gags_option['gags_paging_shadow']['rgba'] : '' ; ?> !important;
				}
				
				#maincontent article.hentry.post {
					box-shadow: 0 10px 30px 0 <?php echo isset($gags_option['gags_hentry_box_shadow']['background-color']) ? $gags_option['gags_hentry_box_shadow']['background-color'] : ''; ?> !important;
				}

				article.hentry.post {
				    border-bottom: <?php echo isset($gags_option['gags_hentry_border']['border-width']) ? $gags_option['gags_hentry_border']['border-width'] : ''; ?> <?php echo isset($gags_option['gags_hentry_border']['border-style']) ? $gags_option['gags_hentry_border']['border-style'] : '' ; ?> <?php echo isset($gags_option['gags_hentry_border']['border-color']) ? $gags_option['gags_hentry_border']['border-color'] : ''; ?> !important;
				}
			</style>
		<?php endif; ?>
<?php
	}
}
add_action( 'wp_enqueue_scripts', 'gags_add_styles_theme_options' );

/**
 * Function to load JS & CSS files on init
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
if ( ! function_exists( 'gags_init_styles' ) ) {
	function gags_init_styles () {
		add_editor_style( 'css/editor-style.css' );
	}
}
add_action( 'admin_enqueue_scripts', 'gags_init_styles' );
?>