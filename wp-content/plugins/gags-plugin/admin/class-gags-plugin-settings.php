<?php

/**
 * The settings of the plugin.
 *
 * @link       http://www.themewarrior.com
 * @since      1.0.0
 *
 * @package    Gags_Plugin
 * @subpackage Gags_Plugin/admin
 */

/**
 * Class WordPress_Plugin_Template_Settings
 *
 */
class Gags_Plugin_Admin_Settings {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * This function introduces the theme options into the 'Appearance' menu and into a top-level
	 * 'WPPB Demo' menu.
	 */
	public function setup_plugin_options_menu() {

		//Add the menu to the Plugins set of menu items
		add_options_page(
			'Gags', 					// The title to be displayed in the browser window for this page.
			'Gags',					// The text to be displayed for this menu item
			'manage_options',					// Which type of users can see this menu item
			'gags_options',			// The unique ID - that is, the slug - for this menu item
			array( $this, 'render_settings_page_content')				// The name of the function to call when rendering this menu's page
		);

	}

	/**
	 * Provides default values for the Input Options.
	 *
	 * @return array
	 */
	public function page_setting_input_options() {

		$defaults = array(
			'gags_login_page'					=>	'',
			'gags_register_page'				=>	'',
			'gags_submit_page'					=>	'',
			'gags_lost_pass_page'				=>	'',
			'gags_top_gag_duration'				=>	'1 week ago',
			'gags_trending_gag_duration'		=>	'2 days ago',
			'gags_comment_option'				=>	'',
			'gags_comment_api_key'				=>	'',
			'gags_infinite_scroll'				=>  '2',
			'gags_change_slug'					=> 	'gag',
		);

		return $defaults;

	}

	/**
	 * Provides default values for the Input Options.
	 *
	 * @return array
	 */
	public function social_auth_input_options() {

		$defaults = array(
			'gags_fb_app_id'				=>	'',
			'gags_fb_app_secret'			=>	'',
			'gags_tw_cons_key'			=>	'',
			'gags_tw_cons_api'			=>	''
		);

		return $defaults;

	}

	/**
	 * Provides default values for the Input Options.
	 *
	 * @return array
	 */
	public function captcha_auth_input_options() {

		$defaults = array(
			'gags_captcha_enabled'		=>	'',
			'gags_captcha_key'			=>	'',
			'gags_captcha_secret'			=>	''
		);

		return $defaults;

	}

	/**
	 * Provides default values for the Input Options.
	 *
	 * @return array
	 */
	public function page_setup_input_options() {

		$defaults = array(
			'gags_page_setup_btn'				=>	''
		);

		return $defaults;

	}

	/**
	 * Renders a simple page to display for the theme menu defined above.
	 */
	public function render_settings_page_content( $active_tab = '' ) {
		?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wrap">

			<h2><?php esc_html_e( 'Gags Options', 'gags-plugin' ); ?></h2>
			<?php settings_errors(); ?>

			<?php if( isset( $_GET[ 'tab' ] ) ) {
				$active_tab = $_GET[ 'tab' ];
			} else if( $active_tab == 'page_setting' ) {
				$active_tab = 'page_setting';
			} // end if/else 
			else if( $active_tab == 'social_auth' ) {
				$active_tab = 'social_auth';
			}
			else if( $active_tab == 'captcha_auth' ) {
				$active_tab = 'captcha_auth';
			} else if( $active_tab == 'default_page_setup' ) {
				$active_tab = 'default_page_setup';
			} else {
				$active_tab = 'page_setting';
			}
			?>

			<h2 class="nav-tab-wrapper">
				<a href="?page=gags_options&tab=page_setting" class="nav-tab <?php echo $active_tab == 'page_setting' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'General', 'gags-plugin' ); ?></a>
				<a href="?page=gags_options&tab=social_auth" class="nav-tab <?php echo $active_tab == 'social_auth' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Social Network Login', 'gags-plugin' ); ?></a>
				<a href="?page=gags_options&tab=captcha_auth" class="nav-tab <?php echo $active_tab == 'captcha_auth' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Google reCaptcha', 'gags-plugin' ); ?></a>
				<a href="?page=gags_options&tab=default_page_setup" class="nav-tab <?php echo $active_tab == 'default_page_setup' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Setup', 'gags-plugin' ); ?></a>
			</h2>

			<form method="post" action="options.php">
				<?php
					if( $active_tab == 'page_setting' ) {

						settings_fields( 'gags_plugin_page_setting' );
						do_settings_sections( 'gags_plugin_page_setting' );
						submit_button();
					} elseif( $active_tab == 'social_auth' ) {

						settings_fields( 'gags_plugin_social_auth' );
						do_settings_sections( 'gags_plugin_social_auth' );
						submit_button();
					}
					elseif( $active_tab == 'default_page_setup' ) {

						settings_fields( 'gags_plugin_page_setup' );
						do_settings_sections( 'gags_plugin_page_setup' );
						submit_button( 'Generate Default Pages', 'primary', 'submit-generate-page', false );
					}
					elseif( $active_tab == 'captcha_auth' ) {

						settings_fields( 'gags_plugin_captcha_auth' );
						do_settings_sections( 'gags_plugin_captcha_auth' );
						submit_button( 'Save Changes', 'primary', 'submit-recaptcha-setup', false );
					}
					else {

						settings_fields( 'gags_plugin_page_setting' );
						do_settings_sections( 'gags_plugin_page_setting' );
						submit_button();
					}
				?>
			</form>

		</div><!-- /.wrap -->
	<?php
	}


	/**
	 * This function provides a simple description for the General page.
	 *
	 * It's called from the 'wppb-demo_theme_initialize_page_setting_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function page_setting_callback() {
		$options = get_option('gags_plugin_page_setting');
		echo '<p>' . esc_html__( 'General settings.', 'gags-plugin' ) . '</p>';
	} // end general_options_callback

	/**
	 * Initializes the theme's input example by registering the Sections,
	 * Fields, and Settings. This particular group of options is used to demonstration
	 * validation and sanitization.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_page_setting() {
		//delete_option('gags_plugin_page_setting');
		if( false == get_option( 'gags_plugin_page_setting' ) ) {
			$default_array = $this->page_setting_input_options();
			update_option( 'gags_plugin_page_setting', $default_array );
		} // end if

		add_settings_section(
			'page_setting_section',
			esc_html__( 'General', 'gags-plugin' ),
			array( $this, 'page_setting_callback'),
			'gags_plugin_page_setting'
		);

		add_settings_field(
			'Login Page',
			esc_html__( 'Login Page', 'gags-plugin' ),
			array( $this, 'gags_login_page_callback'),
			'gags_plugin_page_setting',
			'page_setting_section'
		);

		add_settings_field(
			'Register Page',
			esc_html__( 'Register Page', 'gags-plugin' ),
			array( $this, 'gags_register_page_callback'),
			'gags_plugin_page_setting',
			'page_setting_section'
		);

		add_settings_field(
			'Submit Page',
			esc_html__( 'Submit Page', 'gags-plugin' ),
			array( $this, 'gags_submit_page_callback'),
			'gags_plugin_page_setting',
			'page_setting_section'
		);

		add_settings_field(
			'Lost Password Page',
			esc_html__( 'Lost Password Page', 'gags-plugin' ),
			array( $this, 'gags_lost_pass_page_callback'),
			'gags_plugin_page_setting',
			'page_setting_section'
		);

		add_settings_field(
			'Popular Gags Duration',
			esc_html__( 'Popular Gags Duration', 'gags-plugin' ),
			array( $this, 'gags_top_gag_duration_callback'),
			'gags_plugin_page_setting',
			'page_setting_section'
		);

		add_settings_field(
			'Trending Gags Duration',
			esc_html__( 'Trending Gags Duration', 'gags-plugin' ),
			array( $this, 'gags_trending_gag_duration_callback'),
			'gags_plugin_page_setting',
			'page_setting_section'
		);

		add_settings_field(
			'Comments',
			esc_html__( 'Comments', 'gags-plugin' ),
			array( $this, 'gags_comment_option_callback'),
			'gags_plugin_page_setting',
			'page_setting_section'
		);

		add_settings_field(
			'Facebook Comments API Key',
			esc_html__( 'Facebook Comments API Key', 'gags-plugin' ),
			array( $this, 'gags_facebook_comment_callback'),
			'gags_plugin_page_setting',
			'page_setting_section'
		);

		add_settings_field(
			'Infinite Scroll',
			__( 'Infinite Scroll', 'gags-plugin' ),
			array( $this, 'gags_infinite_scroll_callback'),
			'gags_plugin_page_setting',
			'page_setting_section'
		);

		add_settings_field(
			'Gag Post Slug',
			__( 'Gag Post Slug', 'gags-plugin' ),
			array( $this, 'gags_change_slug_callback'),
			'gags_plugin_page_setting',
			'page_setting_section'
		);

		register_setting(
			'gags_plugin_page_setting',
			'gags_plugin_page_setting',
			array( $this, 'validate_page_setting')
		);

	}

	public function gags_login_page_callback() {

		$options = get_option( 'gags_plugin_page_setting' );
		
		$get_gags_login_page = isset($options['gags_login_page']) ? esc_attr( $options['gags_login_page'] ) : '';

		$html = '<select id="gags_login_page" name="gags_plugin_page_setting[gags_login_page]">';
		$html .= '<option value="">' . esc_html__( 'Select Page...', 'gags-plugin' ) . '</option>';
		global $wp_query;
		$args = array(
		        'post_type' => 'page',
		        'post_status' => 'publish',
		        'posts_per_page' => -1
		      );
		$pages_array = get_posts( $args );
		$pages = array();
		if( count($pages_array) > 0 ) :
		foreach ($pages_array as $page) {
		  $pages_name = $page->post_title;
		  $pages_guid = get_page_link( $page->ID );
		  $html .= '<option value="'.$pages_guid.'"' . selected( $get_gags_login_page, $pages_guid, false) . '>' . $pages_name . '</option>';
		}
		endif;
		$html .= '</select>';

		echo $html;

	} // end gags_login_page_callback

	public function gags_register_page_callback() {

		$options = get_option( 'gags_plugin_page_setting' );

		$get_gags_register_page = isset($options['gags_register_page']) ? esc_attr( $options['gags_register_page'] ) : '';

		$html = '<select id="gags_register_page" name="gags_plugin_page_setting[gags_register_page]">';
		$html .= '<option value="">' . esc_html__( 'Select Page...', 'gags-plugin' ) . '</option>';
		global $wp_query;
		$args = array(
		        'post_type' => 'page',
		        'post_status' => 'publish',
		        'posts_per_page' => -1
		      );
		$pages_array = get_posts( $args );
		$pages = array();
		if( count($pages_array) > 0 ) :
		foreach ($pages_array as $page) {
		  $pages_name = $page->post_title;
		  $pages_guid = get_page_link( $page->ID );
		  $html .= '<option value="'.$pages_guid.'"' . selected( $get_gags_register_page, $pages_guid, false) . '>' . $pages_name . '</option>';
		}
		endif;
		$html .= '</select>';

		echo $html;

	} // end gags_register_page_callback

	public function gags_submit_page_callback() {

		$options = get_option( 'gags_plugin_page_setting' );

		$get_gags_submit_page = isset($options['gags_submit_page']) ? esc_attr( $options['gags_submit_page'] ) : '';

		$html = '<select id="gags_submit_page" name="gags_plugin_page_setting[gags_submit_page]">';
		$html .= '<option value="">' . esc_html__( 'Select Page...', 'gags-plugin' ) . '</option>';
		global $wp_query;
		$args = array(
		        'post_type' => 'page',
		        'post_status' => 'publish',
		        'posts_per_page' => -1
		      );
		$pages_array = get_posts( $args );
		$pages = array();
		if( count($pages_array) > 0 ) :
		foreach ($pages_array as $page) {
		  $pages_name = $page->post_title;
		  $pages_guid = get_page_link( $page->ID );
		  $html .= '<option value="'.$pages_guid.'"' . selected( $get_gags_submit_page, $pages_guid, false) . '>' . $pages_name . '</option>';
		}
		endif;
		$html .= '</select>';

		echo $html;

	} // end gags_submit_page_callback

	public function gags_lost_pass_page_callback() {

		$options = get_option( 'gags_plugin_page_setting' );

		if( isset( $options['gags_lost_pass_page'] ) ) {
			$get_gags_lost_pass_page = esc_attr( $options['gags_lost_pass_page'] );
		} // end if

		$html = '<select id="gags_lost_pass_page" name="gags_plugin_page_setting[gags_lost_pass_page]">';
		$html .= '<option value="">' . esc_html__( 'Select Page...', 'gags-plugin' ) . '</option>';
		global $wp_query;
		$args = array(
		        'post_type' => 'page',
		        'post_status' => 'publish',
		        'posts_per_page' => -1
		      );
		$pages_array = get_posts( $args );
		$pages = array();
		if( count($pages_array) > 0 ) :
		foreach ($pages_array as $page) {
		  $pages_name = $page->post_title;
		  $pages_guid = get_page_link( $page->ID );
		  $html .= '<option value="'.$pages_guid.'"' . selected( $get_gags_lost_pass_page, $pages_guid, false) . '>' . $pages_name . '</option>';
		}
		endif;
		$html .= '</select>';

		echo $html;

	} // end gags_lost_pass_page_callback

	public function gags_top_gag_duration_callback() {

		$options = get_option( 'gags_plugin_page_setting' );

		if( isset( $options['gags_top_gag_duration'] ) ) {
			$get_gags_top_gag_duration = esc_attr( $options['gags_top_gag_duration'] );
		} // end if

		$html = '<select id="gags_top_gag_duration" name="gags_plugin_page_setting[gags_top_gag_duration]">';
		$html .= '<option value="1 week ago">' . esc_html__( 'Select stories duration...', 'gags-plugin' ) . '</option>';
		$html .= '<option value="1 day ago"' . selected( $get_gags_top_gag_duration, '1 day ago', false) . '>' . esc_html__( '1 day ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="2 days ago"' . selected( $get_gags_top_gag_duration, '2 days ago', false) . '>' . esc_html__( '2 days ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="3 days ago"' . selected( $get_gags_top_gag_duration, '3 days ago', false) . '>' . esc_html__( '3 days ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="4 days ago"' . selected( $get_gags_top_gag_duration, '4 days ago', false) . '>' . esc_html__( '4 days ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="5 days ago"' . selected( $get_gags_top_gag_duration, '5 days ago', false) . '>' . esc_html__( '5 days ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="6 days ago"' . selected( $get_gags_top_gag_duration, '6 days ago', false) . '>' . esc_html__( '6 days ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="1 week ago"' . selected( $get_gags_top_gag_duration, '1 week ago', false) . '>' . esc_html__( '1 week ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="2 weeks ago"' . selected( $get_gags_top_gag_duration, '2 weeks ago', false) . '>' . esc_html__( '2 weeks ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="1 month ago"' . selected( $get_gags_top_gag_duration, '1 month ago', false) . '>' . esc_html__( '1 month ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="2 months ago"' . selected( $get_gags_top_gag_duration, '2 months ago', false) . '>' . esc_html__( '2 months ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="3 months ago"' . selected( $get_gags_top_gag_duration, '3 months ago', false) . '>' . esc_html__( '3 months ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="6 months ago"' . selected( $get_gags_top_gag_duration, '6 months ago', false) . '>' . esc_html__( '6 months ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="1 year ago"' . selected( $get_gags_top_gag_duration, '1 year ago', false) . '>' . esc_html__( '1 year ago', 'gags-plugin' ) . '</option>';
		$html .= '</select>';

		echo $html;

	} // end gags_top_gag_duration_callback

	public function gags_trending_gag_duration_callback() {

		$options = get_option( 'gags_plugin_page_setting' );

		if( isset( $options['gags_trending_gag_duration'] ) ) {
			$get_gags_trending_gag_duration = esc_attr( $options['gags_trending_gag_duration'] );
		} // end if

		$html = '<select id="gags_trending_gag_duration" name="gags_plugin_page_setting[gags_trending_gag_duration]">';
		$html .= '<option value="2 days ago">' . esc_html__( 'Select stories duration...', 'gags-plugin' ) . '</option>';
		$html .= '<option value="1 day ago"' . selected( $get_gags_trending_gag_duration, '1 day ago', false) . '>' . esc_html__( '1 day ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="2 days ago"' . selected( $get_gags_trending_gag_duration, '2 days ago', false) . '>' . esc_html__( '2 days ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="3 days ago"' . selected( $get_gags_trending_gag_duration, '3 days ago', false) . '>' . esc_html__( '3 days ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="4 days ago"' . selected( $get_gags_trending_gag_duration, '4 days ago', false) . '>' . esc_html__( '4 days ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="5 days ago"' . selected( $get_gags_trending_gag_duration, '5 days ago', false) . '>' . esc_html__( '5 days ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="6 days ago"' . selected( $get_gags_trending_gag_duration, '6 days ago', false) . '>' . esc_html__( '6 days ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="1 week ago"' . selected( $get_gags_trending_gag_duration, '1 week ago', false) . '>' . esc_html__( '1 week ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="2 weeks ago"' . selected( $get_gags_trending_gag_duration, '2 weeks ago', false) . '>' . esc_html__( '2 weeks ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="1 month ago"' . selected( $get_gags_trending_gag_duration, '1 month ago', false) . '>' . esc_html__( '1 month ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="2 months ago"' . selected( $get_gags_trending_gag_duration, '2 months ago', false) . '>' . esc_html__( '2 months ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="3 months ago"' . selected( $get_gags_trending_gag_duration, '3 months ago', false) . '>' . esc_html__( '3 months ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="6 months ago"' . selected( $get_gags_trending_gag_duration, '6 months ago', false) . '>' . esc_html__( '6 months ago', 'gags-plugin' ) . '</option>';
		$html .= '<option value="1 year ago"' . selected( $get_gags_trending_gag_duration, '1 year ago', false) . '>' . esc_html__( '1 year ago', 'gags-plugin' ) . '</option>';
		$html .= '</select>';

		echo $html;

	} // end gags_trending_gag_duration_callback

	public function gags_comment_option_callback() {

		$options = get_option( 'gags_plugin_page_setting' );

		if( isset( $options['gags_comment_option'] ) ) {
			$get_gags_comment_option = esc_attr( $options['gags_comment_option'] );
		} // end if

		$html = '<select id="gags_comment_option" name="gags_plugin_page_setting[gags_comment_option]">';
		$html .= '<option value="">' . esc_html__( 'Select comment option...', 'gags-plugin' ) . '</option>';
		$html .= '<option value="wp_comment"' . selected( $get_gags_comment_option, 'wp_comment', false) . '>' . esc_html__( 'WordPress Comment', 'gags-plugin' ) . '</option>';
		$html .= '<option value="fb_comment"' . selected( $get_gags_comment_option, 'fb_comment', false) . '>' . esc_html__( 'Facebook Comment', 'gags-plugin' ) . '</option>';
		$html .= '<option value="both"' . selected( $get_gags_comment_option, 'both', false) . '>' . esc_html__( 'Both', 'gags-plugin' ) . '</option>';
		$html .= '</select>';

		echo $html;

	} // end gags_trending_gag_duration_callback

	public function gags_facebook_comment_callback() {

		$options = get_option( 'gags_plugin_page_setting' );

		$gags_fb_app_key = '';
		if( isset( $options['gags_fb_app_key'] ) ) {
			$gags_fb_app_key = esc_attr( $options['gags_fb_app_key'] );
		}

		$html = '<input type="text" id="gags_fb_app_key" name="gags_plugin_page_setting[gags_fb_app_key]" value="' . $gags_fb_app_key . '" />';
		$html .= '<p>';
		$html .= wp_kses( __('Go to <a href="https://developers.facebook.com" target="_blank">Facebook Developer</a> page to register an app to get App ID', 'gags-plugin'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) );
		$html .= '</p>';

		echo $html;

	} // end gags_trending_gag_duration_callback

	public function gags_infinite_scroll_callback() {
		$options = get_option( 'gags_plugin_page_setting' );

		$gags_infinite_scroll = '';
		if( isset( $options['gags_infinite_scroll'] ) ) {
			$gags_infinite_scroll = esc_attr( $options['gags_infinite_scroll'] );
		}

		$html = '<input type="radio" id="gags_infinite_one" name="gags_plugin_page_setting[gags_infinite_scroll]" value="1"' . checked( 1, $gags_infinite_scroll, false ) . '/>';
		$html .= '&nbsp;';
		$html .= '<label for="gags_infinite_one">On</label>';
		$html .= '&nbsp;';
		$html .= '<input type="radio" id="gags_infinite_two" name="gags_plugin_page_setting[gags_infinite_scroll]" value="2"' . checked( 2, $gags_infinite_scroll, false ) . '/>';
		$html .= '&nbsp;';
		$html .= '<label for="gags_infinite_two">Off</label>';
		echo $html;
	} // end radio_element_callback

	public function gags_slug_error() { 
		$options = get_option( 'gags_plugin_page_setting' );
		$gags_change_slug = esc_attr( $options['gags_change_slug'] );
		if ( ! preg_match('/^[A-Za-z0-9]+$/', $gags_change_slug) && isset($_GET['page']) ? $_GET['page'] : '' == 'gags_options' ){ ?>
		    <div class="notice notice-error is-dismissible">
		        <p><?php esc_html_e( 'Gags Option : Slug must letters and not contain any whitespace', 'gags-plugin' ); ?></p>
				<button type="button" class="notice-dismiss">
					<span class="screen-reader-text">Dismiss this notice.</span>
				</button>
		    </div>	
	    <?php
		
		} 
	}

	public function gags_change_slug_callback() {

		$options = get_option( 'gags_plugin_page_setting' );

		$gags_change_slug = '';
		if( isset( $options['gags_change_slug'] ) ) {
			$gags_change_slug = esc_attr( $options['gags_change_slug'] );
			if( empty( $gags_change_slug ) ){
				$gags_change_slug = esc_attr( 'gag' );
			}else{
				if ( ! preg_match('/^[A-Za-z0-9]+$/', $gags_change_slug) ){ 
					$gags_change_slug = esc_attr( 'gag' );
				}
			}
		}else{
			$gags_change_slug = esc_attr( 'gag' );
		}

		$html = '<input type="text" id="gags_change_slug" name="gags_plugin_page_setting[gags_change_slug]" value="' . $gags_change_slug . '" />';
		$html .= '<p>';
		$html .= __('Enter Singular Name Only', 'gags-plugin');
		$html .= '</p>';

		echo $html;

	} // end gags_trending_gag_duration_callback



	public function validate_page_setting( $input ) {

		// Create our array for storing the validated options
		$output = array();

		// Loop through each of the incoming options
		foreach( $input as $key => $value ) {

			// Check to see if the current option has a value. If so, process it.
			if( isset( $input[$key] ) ) {

				// Strip all HTML and PHP tags and properly handle quoted strings
				$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

			} // end if

		} // end foreach

		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'validate_page_setting', $output, $input );

	} // end validate_page_setting

	/**
	 * This function provides a simple description for the General page.
	 *
	 * It's called from the 'wppb-demo_theme_initialize_social_auth_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function social_auth_callback() {
		$options = get_option('gags_plugin_social_auth');
		echo '<p>' . esc_html__( 'Social network login settings.', 'gags-plugin' ) . '</p>';
	} // end general_options_callback

	/**
	 * Initializes the theme's input example by registering the Sections,
	 * Fields, and Settings. This particular group of options is used to demonstration
	 * validation and sanitization.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_social_auth() {
		//delete_option('gags_plugin_social_auth');
		if( false == get_option( 'gags_plugin_social_auth' ) ) {
			$default_array = $this->social_auth_input_options();
			update_option( 'gags_plugin_social_auth', $default_array );
		} // end if

		add_settings_section(
			'social_auth_section',
			esc_html__( 'Social Network Login', 'gags-plugin' ),
			array( $this, 'social_auth_callback'),
			'gags_plugin_social_auth'
		);

		add_settings_field(
			'Facebook App ID',
			esc_html__( 'Facebook App ID', 'gags-plugin' ),
			array( $this, 'gags_fb_app_id_callback'),
			'gags_plugin_social_auth',
			'social_auth_section'
		);

		add_settings_field(
			'Facebook App Secret',
			esc_html__( 'Facebook App Secret', 'gags-plugin' ),
			array( $this, 'gags_fb_app_secret_callback'),
			'gags_plugin_social_auth',
			'social_auth_section'
		);

		add_settings_field(
			'Twitter Consumer Key (API Key)',
			esc_html__( 'Twitter Consumer Key (API Key)', 'gags-plugin' ),
			array( $this, 'gags_tw_cons_key_callback'),
			'gags_plugin_social_auth',
			'social_auth_section'
		);

		add_settings_field(
			'Twitter Consumer Secret (API Secret)',
			esc_html__( 'Twitter Consumer Secret (API Secret)', 'gags-plugin' ),
			array( $this, 'gags_tw_cons_api_callback'),
			'gags_plugin_social_auth',
			'social_auth_section'
		);

		register_setting(
			'gags_plugin_social_auth',
			'gags_plugin_social_auth',
			array( $this, 'validate_social_auth')
		);

	}

	public function gags_fb_app_id_callback() {

		$options = get_option( 'gags_plugin_social_auth' );

		$gags_fb_app_id = '';
		if( isset( $options['gags_fb_app_id'] ) ) {
			$gags_fb_app_id = esc_attr( $options['gags_fb_app_id'] );
		} // end if
		// Render the output
		$html = '<input type="text" id="gags_fb_app_id" name="gags_plugin_social_auth[gags_fb_app_id]" value="' . $gags_fb_app_id . '" />';

		echo $html;

	} // end gags_fb_app_id_callback

	public function gags_fb_app_secret_callback() {

		$options = get_option( 'gags_plugin_social_auth' );

		$gags_fb_app_secret = '';
		if( isset( $options['gags_fb_app_secret'] ) ) {
			$gags_fb_app_secret = esc_attr( $options['gags_fb_app_secret'] );
		} // end if
		// Render the output
		$html = '<input type="text" id="gags_fb_app_secret" name="gags_plugin_social_auth[gags_fb_app_secret]" value="' . $gags_fb_app_secret . '" />';
		$html .= '<p>';
		$html .= wp_kses( __('Go to <a href="https://developers.facebook.com" target="_blank">Facebook Developer</a> page to register an app to get App ID and App Secret.', 'gags-plugin'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) );
		$html .= '</p>';

		echo $html;

	} // end gags_fb_app_secret_callback

	public function gags_tw_cons_key_callback() {

		$options = get_option( 'gags_plugin_social_auth' );

		$gags_tw_cons_key = '';
		if( isset( $options['gags_tw_cons_key'] ) ) {
			$gags_tw_cons_key = esc_attr( $options['gags_tw_cons_key'] );
		} // end if

		// Render the output
		$html = '<input type="text" id="gags_tw_cons_key" name="gags_plugin_social_auth[gags_tw_cons_key]" value="' . $gags_tw_cons_key . '" />';

		echo $html;

	} // end gags_tw_cons_key_callback

	public function gags_tw_cons_api_callback() {

		$options = get_option( 'gags_plugin_social_auth' );

		$gags_tw_cons_api = '';
		if( isset( $options['gags_tw_cons_api'] ) ) {
			$gags_tw_cons_api = esc_attr( $options['gags_tw_cons_api'] );
		} // end if

		// Render the output
		$html = '<input type="text" id="gags_tw_cons_api" name="gags_plugin_social_auth[gags_tw_cons_api]" value="' . $gags_tw_cons_api . '" />';
		$html .= '<p>';
		$html .= wp_kses( __('Go to <a href="https://dev.twitter.com" target="_blank">Twitter Developer</a> page to register an app to register an app to get Consumer Key and Consumer Secret.', 'gags-plugin'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) );
		$html .= '</p>';

		echo $html;

	} // end gags_tw_cons_api_callback

	public function validate_social_auth( $input ) {

		// Create our array for storing the validated options
		$output = array();

		// Loop through each of the incoming options
		foreach( $input as $key => $value ) {

			// Check to see if the current option has a value. If so, process it.
			if( isset( $input[$key] ) ) {

				// Strip all HTML and PHP tags and properly handle quoted strings
				$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

			} // end if

		} // end foreach

		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'validate_social_auth', $output, $input );

	} // end validate_social_auth

	/**
	 * This function provides a simple description for the General page.
	 *
	 * It's called from the 'wppb-demo_theme_initialize_social_profile_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function social_profile_callback() {
		$options = get_option('gags_plugin_social_profile');
		echo '<p>' . esc_html__( 'Social network profile settings.', 'gags-plugin' ) . '</p>';
	} // end general_options_callback

	/**
	 * This function provides a simple description for the General page.
	 *
	 * It's called from the 'wppb-demo_theme_initialize_page_setup_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function page_setup_callback() {
		$options = get_option('gags_plugin_page_setup');
		echo '<p>' . esc_html__( 'Click the button below to generate all required pages by gags. Please only do this step once!.', 'gags-plugin' ) . '</p>';
	} // end general_options_callback

	/**
	 * Initializes the theme's input example by registering the Sections,
	 * Fields, and Settings. This particular group of options is used to demonstration
	 * validation and sanitization.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_page_setup() {
		//delete_option('gags_plugin_page_setup');
		if( false == get_option( 'gags_plugin_page_setup' ) ) {
			$default_array = $this->page_setup_input_options();
			update_option( 'gags_plugin_page_setup', $default_array );
		} // end if

		add_settings_section(
			'page_setup_section',
			esc_html__( 'Default Page Setup', 'gags-plugin' ),
			array( $this, 'page_setup_callback'),
			'gags_plugin_page_setup'
		);

		add_settings_field(
			'Generate Default Pages',
			esc_html__( 'Generate Default Pages', 'gags-plugin' ),
			array( $this, 'gags_page_setup_btn_callback'),
			'gags_plugin_page_setup',
			'page_setup_section'
		);

		register_setting(
			'gags_plugin_page_setup',
			'gags_plugin_page_setup',
			array( $this, 'validate_page_setup')
		);

	}

	public function gags_page_setup_btn_callback() {

		$options = get_option( 'gags_plugin_page_setup' );

		$gags_page_setup_btn = '';
		if( isset( $options['gags_page_setup_btn'] ) ) {
			$gags_page_setup_btn = esc_attr( $options['gags_page_setup_btn'] );
		} // end if

		if ( $gags_page_setup_btn == 1 && !isset($_POST['submit-generate-page']) ) {
			gags_set_default_page_templates();
		}

		// Render the output
		$html = '<input type="checkbox" id="gags_page_setup_btn" name="gags_plugin_page_setup[gags_page_setup_btn]" value="1"' . checked( $options['gags_page_setup_btn'], 1, false) . '/>';
		$html .= '<label for="gags_page_setup_btn">'.esc_html__('Generate pages now.', 'gags-plugin').'</label>';

		echo $html;

	} // end gags_fb_app_id_callback

	public function validate_page_setup( $input ) {

		// Create our array for storing the validated options
		$output = array();

		// Loop through each of the incoming options
		foreach( $input as $key => $value ) {

			// Check to see if the current option has a value. If so, process it.
			if( isset( $input[$key] ) ) {

				// Strip all HTML and PHP tags and properly handle quoted strings
				$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

			} // end if

		} // end foreach

		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'validate_page_setup', $output, $input );

	} // end validate_page_setup

	/**
	 * This function provides a simple description for the General page.
	 *
	 * It's called from the 'wppb-demo_theme_initialize_captcha_auth_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function captcha_auth_callback() {
		$options = get_option('gags_plugin_captcha_auth');
		echo '<p>' . esc_html__( 'Enter site key and secret key, that you get after registration.', 'gags-plugin' ) . '</p>';
	} // end general_options_callback

	/**
	 * Initializes the theme's input example by registering the Sections,
	 * Fields, and Settings. This particular group of options is used to demonstration
	 * validation and sanitization.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_captcha_auth() {
		//delete_option('gags_plugin_captcha_auth');
		if( false == get_option( 'gags_plugin_captcha_auth' ) ) {
			$default_array = $this->captcha_auth_input_options();
			update_option( 'gags_plugin_captcha_auth', $default_array );
		} // end if

		add_settings_section(
			'captcha_auth_section',
			esc_html__( 'Google reCaptcha', 'gags-plugin' ),
			array( $this, 'captcha_auth_callback'),
			'gags_plugin_captcha_auth'
		);

		add_settings_field(
			'Enable Google reCaptcha',
			esc_html__( 'Enable Google reCaptcha', 'gags-plugin' ),
			array( $this, 'gags_gr_enabled_callback'),
			'gags_plugin_captcha_auth',
			'captcha_auth_section'
		);

		add_settings_field(
			'Google reCaptcha Site key',
			esc_html__( 'Google reCaptcha Site key', 'gags-plugin' ),
			array( $this, 'gags_gr_site_key_callback'),
			'gags_plugin_captcha_auth',
			'captcha_auth_section'
		);

		add_settings_field(
			'Google reCaptcha Secret Key',
			esc_html__( 'Google reCaptcha Secret Key', 'gags-plugin' ),
			array( $this, 'gags_gr_secret_key_callback'),
			'gags_plugin_captcha_auth',
			'captcha_auth_section'
		);

		register_setting(
			'gags_plugin_captcha_auth',
			'gags_plugin_captcha_auth',
			array( $this, 'validate_captcha_auth')
		);

	}

	public function gags_gr_enabled_callback() {

		$options = get_option( 'gags_plugin_captcha_auth' );

		$gags_captcha_enabled = '';
		if( isset( $options['gags_captcha_enabled'] ) ) {
			$gags_captcha_enabled = esc_attr( $options['gags_captcha_enabled'] );
		} // end if

		// Render the output
		$html = '<input type="checkbox" id="gags_captcha_enabled" name="gags_plugin_captcha_auth[gags_captcha_enabled]" value="1"' . checked( $gags_captcha_enabled, 1, false) . '/>';
		$html .= '<label for="gags_captcha_enabled">'.esc_html__('Enable Google reCaptcha.', 'gags-plugin').'</label>';

		echo $html;

	} // end gags_gr_enabled_callback

	public function gags_gr_site_key_callback() {

		$options = get_option( 'gags_plugin_captcha_auth' );

		$gags_captcha_key = '';
		if( isset( $options['gags_captcha_key'] ) ) {
			$gags_captcha_key = esc_attr( $options['gags_captcha_key'] );
		} // end if
		// Render the output
		$html = '<input type="text" id="gags_captcha_key" name="gags_plugin_captcha_auth[gags_captcha_key]" value="' . $gags_captcha_key . '" />';

		echo $html;

	} // end gags_gr_site_key_callback

	public function gags_gr_secret_key_callback() {

		$options = get_option( 'gags_plugin_captcha_auth' );

		$gags_captcha_secret = '';
		if( isset( $options['gags_captcha_secret'] ) ) {
			$gags_captcha_secret = esc_attr( $options['gags_captcha_secret'] );
		} // end if
		// Render the output
		$html = '<input type="text" id="gags_captcha_secret" name="gags_plugin_captcha_auth[gags_captcha_secret]" value="' . $gags_captcha_secret . '" />';
		$html .= '<p>';
		$html .= wp_kses( __('You can register for Google reCaptcha to obtain the Site Key and Secret Key. <a href="https://www.google.com/recaptcha" target="_blank">Register now</a>.', 'gags'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) );
		$html .= '</p>';

		echo $html;

	} // end gags_gr_secret_key_callback

	public function validate_captcha_auth( $input ) {

		// Create our array for storing the validated options
		$output = array();

		// Loop through each of the incoming options
		foreach( $input as $key => $value ) {

			// Check to see if the current option has a value. If so, process it.
			if( isset( $input[$key] ) ) {

				// Strip all HTML and PHP tags and properly handle quoted strings
				$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

			} // end if

		} // end foreach

		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'validate_captcha_auth', $output, $input );

	} // end validate_captcha_auth
}