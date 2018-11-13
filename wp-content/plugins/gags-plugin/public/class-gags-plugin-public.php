<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.themewarrior.com
 * @since      1.0.0
 *
 * @package    Gags_Plugin
 * @subpackage Gags_Plugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Gags_Plugin
 * @subpackage Gags_Plugin/public
 * @author     ThemeWarrior <zakky@andrastudio.com>
 */
class Gags_Plugin_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gags_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gags_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/gags-plugin-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'gags-tagsinputcss', plugin_dir_url( __FILE__ ) . 'css/jquery.tagsinput.min.css', array(), false, 'all' );
		wp_enqueue_style( 'gags-giftplayer', plugin_dir_url( __FILE__ ) . 'css/gifplayer.css', array(), false, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gags_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gags_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'gags-tagsinput', plugin_dir_url( __FILE__ ) . 'js/jquery.tagsinput.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'gags-gifplayer-min', plugin_dir_url( __FILE__ ) . 'js/jquery.gifplayer.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'gags-jscroll', plugin_dir_url( __FILE__ ) . 'js/jquery.jscroll.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'gags-script-submit', plugin_dir_url( __FILE__ ) . 'js/script-submit.js', array( 'jquery' ), null, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/gags-plugin-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script('gags-script-submit', '_gagsplaceholder', array(
			'placeholder_tags' => esc_html__('Add Tags', 'gags-plugin'),
			'path_plugin' => plugin_dir_url( __FILE__ )
		));

		$options = get_option( 'gags_plugin_captcha_auth' );
		$gags_captcha_enabled = '';
		if( isset( $options['gags_captcha_enabled'] ) ) {
			$gags_captcha_enabled = esc_attr( $options['gags_captcha_enabled'] );
		} // end if

		if ( $gags_captcha_enabled == 1 && !isset($_POST['submit-recaptcha-setup']) ) {
			wp_enqueue_script( 'gags-recaptcha', 'https://www.google.com/recaptcha/api.js', array( 'jquery' ), null, true);
		}

		$gags_options = get_option( 'gags_plugin_page_setting' );
		$gags_infinite_scroll = '';
		if( isset( $gags_options['gags_infinite_scroll'] ) ) {
			$gags_infinite_scroll = esc_attr( $gags_options['gags_infinite_scroll'] );
		} // end if

		if ( $gags_infinite_scroll == 1  ) {
			wp_enqueue_script( 'gags-infinite-scroll', plugin_dir_url( __FILE__ ) . 'js/infinite-scroll.js', array( 'jquery' ), null, true);
		}

	}

}

/**
 * (1) Enqueue scripts for like system
 */
if ( ! function_exists( 'gags_like_scripts' ) ) {
	function gags_like_scripts() {
		wp_enqueue_script( 'jm_like_post', plugin_dir_url( __FILE__ ) . 'js/post-like.js', array('jquery'), '1.0', 1 );
		wp_localize_script( 'jm_like_post', 'ajax_var', array(
			'url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'ajax-nonce' )
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'gags_like_scripts' );