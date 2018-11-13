<?php
/**
* The gags-plugin core functions.
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/

// Include post type files
require_once plugin_dir_path( dirname( __FILE__ ) ) .  'includes/post-type.php';

// Include social login oauth
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/facebookoauth.php'; // Facebook login auth
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/twitteroauth.php'; // Twitter login auth

/**
 * Get and include template files.
 *
 * @param mixed $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return void
 */
function get_gags_template( $template_name, $args = array(), $template_path = 'gags-templates', $default_path = '' ) {
	if ( $args && is_array( $args ) ) {
		extract( $args );
	}
	include( locate_gags_template( $template_name, $template_path, $default_path ) );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *		yourtheme		/	$template_path	/	$template_name
 *		yourtheme		/	$template_name
 *		$default_path	/	$template_name
 *
 * @param string $template_name
 * @param string $template_path (default: 'job_manager')
 * @param string|bool $default_path (default: '') False to not load a default
 * @return string
 */
function locate_gags_template( $template_name, $template_path = 'gags-templates', $default_path = '' ) {
	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template && $default_path !== false ) {
		$default_path = $default_path ? $default_path : plugin_dir_path( dirname( __FILE__ ) ) . '/templates/';
		if ( file_exists( trailingslashit( $default_path ) . $template_name ) ) {
			$template = trailingslashit( $default_path ) . $template_name;
		}
	}

	// Return what we found
	return apply_filters( 'gags_locate_template', $template, $template_name, $template_path );
}

/**
 * Get template part (for templates in loops).
 *
 * @param string $slug
 * @param string $name (default: '')
 * @param string $template_path (default: 'job_manager')
 * @param string|bool $default_path (default: '') False to not load a default
 */
function get_gags_template_part( $slug, $name = '', $template_path = 'gags-templates', $default_path = '' ) {
	$template = '';

	if ( $name ) {
		$template = locate_gags_template( "{$slug}-{$name}.php", $template_path, $default_path );
	}

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/job_manager/slug.php
	if ( ! $template ) {
		$template = locate_gags_template( "{$slug}.php", $template_path, $default_path );
	}

	if ( $template ) {
		load_template( $template, false );
	}
}

/**
* Functions to set login with facebook oauth
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_login_w_facebook' ) ) {
	function gags_login_w_facebook() {
		$gags_social_log_auth = get_option('gags_plugin_social_auth');

		$app_id_variable = !empty( $gags_social_log_auth['gags_fb_app_id'] ) ? esc_attr( $gags_social_log_auth['gags_fb_app_id'] ) : ''; // apps id of facebook apps
		$app_secret_variable = !empty( $gags_social_log_auth['gags_fb_app_secret'] ) ? esc_attr( $gags_social_log_auth['gags_fb_app_secret'] ) : ''; // apps secret of facebook apps
		update_option("facebook_app_id", $app_id_variable);
		update_option("facebook_app_secret", $app_secret_variable);
	?>
		<a href="<?php echo site_url() . '/wp-admin/admin-ajax.php?action=facebook_oauth_redirect'; ?>" class="facebook-login btn btn-block" style="background-color: #315192;"><i class="icon icon-facebook"></i> <?php esc_html_e('Login with Facebook', 'gags-plugin'); ?></a>
	<?php
	}
}

/**
* Functions to set login with twitter oauth
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_login_w_twitter' ) ) {
	function gags_login_w_twitter() {
		$gags_social_log_auth = get_option('gags_plugin_social_auth');

		$consumer_key_variable = !empty( $gags_social_log_auth['gags_tw_cons_key'] ) ? esc_attr( $gags_social_log_auth['gags_tw_cons_key'] ) : ''; // consumer key of twitter apps
		$consumer_secret_variable = !empty( $gags_social_log_auth['gags_tw_cons_api'] ) ? esc_attr( $gags_social_log_auth['gags_tw_cons_api'] ) : ''; // consumer secret of twitter apps
		update_option("twitter_oauth_consumer_key", $consumer_key_variable);
		update_option("twitter_oauth_consumer_secret", $consumer_secret_variable);
	?>
		<a href="<?php echo site_url() . '/wp-admin/admin-ajax.php?action=twitter_oauth_redirect'; ?>" class="twitter-login btn btn-block" style="background-color: #00ACEE;"><i class="icon icon-twitter"></i> <?php esc_html_e('Login with Twitter', 'gags-plugin'); ?></a>
	<?php
	}
}

/**
* Functions to set login validation
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_login_validation' ) ) {
	function gags_login_validation() {  
		$warrior_get_login_url  = (isset($_GET['login']) ) ? $_GET['login'] : 0;
		if ( $warrior_get_login_url === "failed" ) {
			echo '<div class="alert alert-danger">';
			esc_html_e("Invalid username and/or password!", "gags-plugin");
			echo '</div>'; 
		} elseif ( $warrior_get_login_url === "empty" ) {  
			echo '<div class="alert alert-danger">';
			esc_html_e("Username and/or Password is empty!", "gags-plugin");
			echo '</div>'; 
		} elseif ( $warrior_get_login_url === "false" ) {
			echo '<div class="alert alert-info">';
			esc_html_e("You are logged out!", "gags-plugin");
			echo '</div>'; 
		} elseif ( $warrior_get_login_url === "wrong" ) {
			echo '<div class="alert alert-warning">';
			esc_html_e("You must be logged in!", "gags-plugin");
			echo '</div>'; 
		}
	}
}

/**
* Functions to set logout page
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_logout_page' ) ) {
	function gags_logout_page() {
		wp_redirect( esc_url(home_url('/')) );
	    exit;  
	}
}
add_action( 'wp_logout','gags_logout_page' ); 

/**
* Functions to set custom redirect lost password page
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_redirect_lostpassword' ) ) {
	function gags_redirect_lostpassword()
	{
		$gags_lost_password_page = get_option('gags_plugin_page_setting');
		if ($gags_lost_password_page) :
	    	return esc_url($gags_lost_password_page['gags_lost_pass_page']);
	    endif;
	}
}
add_filter('lostpassword_url', 'gags_redirect_lostpassword');

/**
* Functions to set lost password
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_lost_password' ) ) {
	function gags_lost_password()
	{
		global $wpdb;
		$error = '';
		$success = '';

		// check if we're in reset form
		if( isset( $_POST['action'] ) && 'reset' == $_POST['action'] ) 
		{
			$email = trim( $_POST['user_login'] );
			
			if( empty( $email ) ) {
				$error = esc_html__('Please enter your e-mail address.', 'gags-plugin');
			} else if( ! is_email( $email ) ) {
				$error = esc_html__('Invalid e-mail address.', 'gags-plugin');
			} else if( ! email_exists( $email ) ) {
				$error = esc_html__('There is no user registered with that email address.', 'gags-plugin');
			} else {

				$random_password = wp_generate_password( 12, false );
				$user = get_user_by( 'email', $email );
				
				$update_user = wp_update_user( array (
						'ID' => $user->ID, 
						'user_pass' => $random_password
					)
				);
				
				// if  update user return true then lets send user an email containing the new password
				if( $update_user ) {
					$to = $email;
					$subject = esc_html__('Your new password', 'gags-plugin');
					$sender = get_option('name');
					
					$message = esc_html__('Your new password is: ', 'gags-plugin').$random_password;
					
					$headers[] = 'MIME-Version: 1.0' . "\r\n";
					$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers[] = "X-Mailer: PHP \r\n";
					$headers[] = 'From: '.$sender.' < '.$email.'>' . "\r\n";
					
					$mail = wp_mail( $to, $subject, $message, $headers );
					if( $mail )
						$success = esc_html__('Check your email address for you new password.', 'gags-plugin');
						
				} else {
					$error = esc_html__('Oops something went wrong updaing your account.', 'gags-plugin');
				}
				
			}
			
			if( ! empty( $error ) )
				echo '<div class="alert alert-danger">'. $error .' </div>';  
			
			if( ! empty( $success ) )
				echo '<div class="alert alert-success">'. $success .' </div>';  
		}
	}
}

/**
* Functions to set submit post image
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_submit_post_image' ) ) {
	function gags_submit_post_image() {
		if ( isset( $_POST['submit'] ) ) {
			$gags_featured_image_url = esc_attr( $_POST['_gag_image_url'] );
			$gags_upload_image_files = $_FILES['gag_featured_image'];
			$gags_image_nfsw = isset($_POST['_gag_nfsw']) ? $_POST['_gag_nfsw'] : '';
			$gags_image_post_title = wp_strip_all_tags( esc_attr( $_POST['gag_image_post_title'] ) );
			$gags_image_post_category = esc_attr( $_POST['gag_image_post_category'] );
			$gags_image_post_content = esc_attr( $_POST['gags_image_post_content'] );
			$gags_image_post_tag = esc_attr( $_POST['gags_image_post_tag'] );
			$gags_get_current_author = wp_get_current_user();
			$gags_author_id = absint($gags_get_current_author->ID);

			// Create post object
			$gags_insert_post = array(
				'post_type'      => 'gag',
				'post_status'    => 'publish',
				'post_title'	 => $gags_image_post_title,
				'post_content'	 => wp_kses_post( $gags_image_post_content ),
				'tags_input'     => array($gags_image_post_tag),
			  	'post_category'  => array($gags_image_post_category),
				'_gag_image_url' => wp_strip_all_tags( $gags_featured_image_url ),
				'post_author'    => $gags_author_id
			);

			$error = array();
			if ( empty( $gags_image_post_title ) ) {
				$error[] = '<li>'.wp_kses( __( 'Title field is required.', 'gags-plugin' ), array( 'strong' => array() ) ).'</li>';
			}
			if ( ( $gags_image_post_category == -1 ) ) {
				$error[] = '<li>'.wp_kses( __( 'Please select a gag category.', 'gags-plugin' ), array( 'strong' => array() ) ).'</li>';
			}
			if ( empty( $gags_featured_image_url ) AND $_FILES['gag_featured_image']['error'] > 0 ) {
				$error[] = '<li>'.wp_kses( __( 'Please upload your images or put your url images.', 'gags-plugin' ), array( 'strong' => array() ) ).'</li>';
			}
			if ( !empty( $gags_image_post_title ) AND !empty( $gags_image_post_category ) AND ( $gags_image_post_category != -1 ) AND !empty($gags_featured_image_url) || $gags_upload_image_files != 0 ) {
				// Submit post
				$gags_post_id = wp_insert_post( $gags_insert_post, $wp_error = '' );
				$author_id = get_current_user_id();
				if ( $author_id ){
					// automatic likes
					$meta_POSTS = get_user_option( "_liked_posts", $author_id  ); // post ids from user meta
					$meta_USERS = get_post_meta( $gags_post_id, "_user_liked" ); // user ids from post meta
					$liked_POSTS = NULL; // setup array variable
					$liked_USERS = NULL; // setup array variable
					
					if ( count( $meta_POSTS ) != 0 ) { // meta exists, set up values
						$liked_POSTS = $meta_POSTS;
					}
					
					if ( !is_array( $liked_POSTS ) ) // make array just in case
						$liked_POSTS = array();
						
					if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
						$liked_USERS = $meta_USERS[0];
					}		

					if ( !is_array( $liked_USERS ) ) // make array just in case
						$liked_USERS = array();
						
					$liked_POSTS['post-'.$gags_post_id] = $gags_post_id; // Add post id to user meta array
					$liked_USERS[$author_id] = $author_id; // add user id to post meta array
					$user_likes = count( $liked_POSTS ); // count user likes

					add_post_meta( $gags_post_id, '_post_like_count', 1 );
					add_post_meta( $gags_post_id, "_user_liked", $author_id );
					update_user_option( $author_id, "_liked_posts", $liked_POSTS ); // Add post ID to user meta
					update_user_option( $author_id, "_user_like_count", $user_likes ); // +1 count user meta
				}
				update_post_meta( $gags_post_id, '_gag_image_url', $gags_featured_image_url, true );
				update_post_meta( $gags_post_id, '_gag_nfsw', $gags_image_nfsw, true );
				wp_set_post_terms( $gags_post_id, $gags_image_post_tag, 'gag_tag', false );
				wp_set_post_terms( $gags_post_id, $gags_image_post_category, 'gag_category', false );
				$get_post_format = 'post-format-image';
				$type_format = 'post_format';
				wp_set_post_terms( $gags_post_id, $get_post_format, $type_format );

				// Add Featured Image to Post
				if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );

				if ((isset($_FILES["gag_featured_image"])) && ($_FILES["gag_featured_image"]["size"] > 0)) {
					// Add Featured Image to Post
					$gags_upload_image = $gags_upload_image_files;
					$gags_image_overrides = array( 'test_form' => false );
					$gags_move_image = wp_handle_upload( $gags_upload_image, $gags_image_overrides );
					
					$gags_get_move_image_url = isset($gags_move_image['url']) ? $gags_move_image['url'] : '';
					$image_url  = $gags_get_move_image_url; // Define the image URL here
					$upload_dir = wp_upload_dir(); // Set upload folder
					$image_data = file_get_contents( $image_url ); // Get image data
					$basename   = basename( $image_url ); // Create image file name
					if ($url = parse_url($basename)) { 
						$post_id = $gags_post_id;
						$post_slug = get_post( $gags_post_id )->post_name;
					    $filename = $post_id.'-'.$post_slug.'-'.$url['path'];
					}

					// Check folder permission and define file location
					if ( wp_mkdir_p( $upload_dir['path'] ) ) {
					    $file = $upload_dir['path'] . '/' . $filename;
					} else {
					    $file = $upload_dir['basedir'] . '/' . $filename;
					}

					// Create the image  file on the server
					file_put_contents( $file, $image_data );

					// Check image file type
					$wp_filetype = wp_check_filetype( $filename, array(
				      	'jpg|jpeg|jpe'  => 'image/jpeg',
						'gif'           => 'image/gif',
						'png'           => 'image/png',
						'bmp'           => 'image/bmp',
				    ));

					// Set attachment data
					$attachment = array(
					    'post_mime_type' => $wp_filetype['type'],
					    'post_title'     => sanitize_file_name( $filename ),
					    'post_content'   => '',
					    'post_status'    => 'inherit'
					);

					// Create the attachment
					$attach_id = wp_insert_attachment( $attachment, $file, $gags_post_id );

					// Include image.php
					require_once( ABSPATH . 'wp-admin/includes/image.php' );

					// Define attachment metadata
					$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

					// Assign metadata to attachment
					wp_update_attachment_metadata( $attach_id, $attach_data );

					// And finally assign featured image to post
					set_post_thumbnail( $gags_post_id, $attach_id );

				} else if (!empty($gags_featured_image_url)) {

					// Add Featured Image to Post
					$image_url  = $gags_featured_image_url; // Define the image URL here
					$upload_dir = wp_upload_dir(); // Set upload folder
					$image_data = file_get_contents( $image_url ); // Get image data
					$basename   = basename( $image_url ); // Create image file name
					if ($url = parse_url($basename)) { 
						$post_id = $gags_post_id;
						$post_slug = get_post( $gags_post_id )->post_name;
					    $filename = $post_id.'-'.$post_slug.'-'.$url['path'];
					}

					// Check folder permission and define file location
					if ( wp_mkdir_p( $upload_dir['path'] ) ) {
					    $file = $upload_dir['path'] . '/' . $filename;
					} else {
					    $file = $upload_dir['basedir'] . '/' . $filename;
					}

					// Create the image  file on the server
					file_put_contents( $file, $image_data );

					// Check image file type
					$wp_filetype = wp_check_filetype( $filename, array(
				      	'jpg|jpeg|jpe'  => 'image/jpeg',
						'gif'           => 'image/gif',
						'png'           => 'image/png',
						'bmp'           => 'image/bmp',
				    ));

					// Set attachment data
					$attachment = array(
					    'post_mime_type' => $wp_filetype['type'],
					    'post_title'     => sanitize_file_name( $filename ),
					    'post_content'   => '',
					    'post_status'    => 'inherit'
					);

					// Create the attachment
					$attach_id = wp_insert_attachment( $attachment, $file, $gags_post_id );

					// Include image.php
					require_once( ABSPATH . 'wp-admin/includes/image.php' );

					// Define attachment metadata
					$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

					// Assign metadata to attachment
					wp_update_attachment_metadata( $attach_id, $attach_data );

					// And finally assign featured image to post
					set_post_thumbnail( $gags_post_id, $attach_id );

				} // END upload

				if ( $gags_post_id != 0 ) {
						
					//insert taxonomy terms
					$gags_cat_id = array( $gags_image_post_category );
					$gags_cat_id = array_map( 'intval', $gags_cat_id );
					$gags_cat_id = array_unique( $gags_cat_id );

					$gags_term_cat_id = wp_set_object_terms( $gags_post_id, $gags_cat_id, 'gag_category' );

					// Redirect after submit successfully
					if ( $gags_post_id && count($error) == 0 ) :
						$get_gag_url = esc_url(get_permalink( $gags_post_id ));
						wp_redirect( $get_gag_url."?p=".$gags_post_id."&success=1" );
						exit;	
					endif;
				}	
			}
			if ( count($error) > 0 ) echo '<div class="alert alert-danger"><ul>' . implode(" ", $error) . '</ul></div>';
		}
	}
}

/**
* Functions to set submit post video
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_submit_post_video' ) ) {
	function gags_submit_post_video() {
		if ( isset( $_POST['submit'] ) ) {
			$gags_video_embed_url = esc_attr( $_POST['_gag_video_embed_url'] );
			$gags_video_nfsw = isset($_POST['_gag_nfsw']) ? $_POST['_gag_nfsw'] : '';
			$gags_video_post_title = wp_strip_all_tags( esc_attr( $_POST['gag_video_post_title'] ) );
			$gags_video_post_category = esc_attr( $_POST['gag_video_post_category'] );
			$gags_video_post_content = esc_attr( $_POST['gags_video_post_content'] );
			$gags_video_post_tag = esc_attr( $_POST['gags_video_post_tag'] );
			$gags_get_current_author = wp_get_current_user();
			$gags_author_id = absint($gags_get_current_author->ID);

			// Create post object
			$gags_insert_post = array(
				'post_type'      => 'gag',
				'post_status'    => 'publish',
				'post_title'	 => $gags_video_post_title,
				'post_content'	 => wp_kses_post( $gags_video_post_content ),
				'tags_input'     => array($gags_video_post_tag),
			  	'post_category'  => array($gags_video_post_category),
				'_gag_video_embed_url' => wp_strip_all_tags( $gags_video_embed_url ),
				'post_author'    => $gags_author_id
			);

			$error = array();
			if ( empty( $gags_video_post_title ) ) {
				$error[] = '<li>'.wp_kses( __( 'Title field is required.', 'gags-plugin' ), array( 'strong' => array() ) ).'</li>';
			}
			if ( $gags_video_post_category == -1 ) {
				$error[] = '<li>'.wp_kses( __( 'Please select a gag category.', 'gags-plugin' ), array( 'strong' => array() ) ).'</li>';
			}
			if ( empty( $gags_video_embed_url ) ) {
				$error[] = '<li>'.wp_kses( __( 'Please input video embed url.', 'gags-plugin' ), array( 'strong' => array() ) ).'</li>';
			}
			if ( !empty( $gags_video_post_title ) && !empty( $gags_video_post_category ) && !empty( $gags_video_embed_url ) && ( $gags_video_post_category != -1 ) ) {
				// Submit post
				$gags_post_id = wp_insert_post( $gags_insert_post, $wp_error = '' );
				$author_id = get_current_user_id();
				if ( $author_id ){
					// automatic likes
					$meta_POSTS = get_user_option( "_liked_posts", $author_id  ); // post ids from user meta
					$meta_USERS = get_post_meta( $gags_post_id, "_user_liked" ); // user ids from post meta
					$liked_POSTS = NULL; // setup array variable
					$liked_USERS = NULL; // setup array variable
					
					if ( count( $meta_POSTS ) != 0 ) { // meta exists, set up values
						$liked_POSTS = $meta_POSTS;
					}
					
					if ( !is_array( $liked_POSTS ) ) // make array just in case
						$liked_POSTS = array();
						
					if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
						$liked_USERS = $meta_USERS[0];
					}		

					if ( !is_array( $liked_USERS ) ) // make array just in case
						$liked_USERS = array();
						
					$liked_POSTS['post-'.$gags_post_id] = $gags_post_id; // Add post id to user meta array
					$liked_USERS[$author_id] = $author_id; // add user id to post meta array
					$user_likes = count( $liked_POSTS ); // count user likes

					add_post_meta( $gags_post_id, '_post_like_count', 1 );
					add_post_meta( $gags_post_id, "_user_liked", $author_id );
					update_user_option( $author_id, "_liked_posts", $liked_POSTS ); // Add post ID to user meta
					update_user_option( $author_id, "_user_like_count", $user_likes ); // +1 count user meta
				}
				update_post_meta( $gags_post_id, '_gag_video_embed_url', $gags_video_embed_url, true );
				update_post_meta( $gags_post_id, '_gag_nfsw', $gags_video_nfsw, true );
				wp_set_post_terms( $gags_post_id, $gags_video_post_tag, 'gag_tag', false );
				wp_set_post_terms( $gags_post_id, $gags_video_post_category, 'gag_category', false );
				$get_post_format = 'post-format-video';
				$type_format = 'post_format';
				wp_set_post_terms( $gags_post_id, $get_post_format, $type_format );
				
				if ( $gags_post_id != 0 ) {
						
					//insert taxonomy terms
					$gags_cat_id = array( $gags_video_post_category );
					$gags_cat_id = array_map( 'intval', $gags_cat_id );
					$gags_cat_id = array_unique( $gags_cat_id );

					$gags_term_cat_id = wp_set_object_terms( $gags_post_id, $gags_cat_id, 'gag_category' );

					// Redirect after submit successfully
					if ( $gags_post_id && count($error) == 0 ) :
						$get_gag_url = esc_url(get_permalink( $gags_post_id ));
						wp_redirect( $get_gag_url."?p=".$gags_post_id."&success=1" );
						exit;	
					endif;
				}	
			}
			if ( count($error) > 0 ) echo '<div class="alert alert-danger"><ul>' . implode(" ", $error) . '</ul></div>';
		}
	}
}

/**
* Functions to register a new user
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_add_new_member' ) ) {
	function gags_add_new_member() {
	  	if (isset( $_POST["gags_user_login"] ) && isset($_POST['gags_register_nonce']) && wp_verify_nonce($_POST['gags_register_nonce'], 'gags-register-nonce')) {
			$user_login		= esc_attr($_POST["gags_user_login"]);
			$user_email		= sanitize_email($_POST["gags_user_email"]);
			$user_first 	= esc_attr($_POST["gags_user_first"]);
			$user_last	 	= esc_attr($_POST["gags_user_last"]);
			$user_pass		= esc_attr($_POST["gags_user_pass"]);
			$pass_confirm 	= esc_attr($_POST["gags_user_pass_confirm"]);
			if(isset($_POST['g-recaptcha-response'])){
	        	$captcha = $_POST['g-recaptcha-response'];
	        }
	 
			// this is required for username checks
			// require_once(ABSPATH . WPINC . '/registration.php');
	 
			if(username_exists($user_login)) {
				// Username already registered
				gags_errors()->add('username_unavailable', esc_html__('Username already taken', 'gags-plugin'));
			}
			if(!validate_username($user_login)) {
				// invalid username
				gags_errors()->add('username_invalid', esc_html__('Invalid username', 'gags-plugin'));
			}
			if($user_login == '') {
				// empty username
				gags_errors()->add('username_empty', esc_html__('Please enter a username', 'gags-plugin'));
			}
			if(!is_email($user_email)) {
				//invalid email
				gags_errors()->add('email_invalid', esc_html__('Invalid email', 'gags-plugin'));
			}
			if(email_exists($user_email)) {
				//Email address already registered
				gags_errors()->add('email_used', esc_html__('Email already registered', 'gags-plugin'));
			}
			if($user_pass == '') {
				// passwords do not match
				gags_errors()->add('password_empty', esc_html__('Please enter a password', 'gags-plugin'));
			}
			if($user_pass != $pass_confirm) {
				// passwords do not match
				gags_errors()->add('password_mismatch', esc_html__('Passwords do not match', 'gags-plugin'));
			}

			$options = get_option( 'gags_plugin_captcha_auth' );
			$gags_captcha_enabled = '';
			if( isset( $options['gags_captcha_enabled'] ) ) {
				$gags_captcha_enabled = esc_attr( $options['gags_captcha_enabled'] );
			} // end if

			if ( $gags_captcha_enabled == 1 && !isset($_POST['submit-recaptcha-setup']) ) {
				$gags_recaptcha_auth = get_option('gags_plugin_captcha_auth');
				$recaptcha_secret_key = !empty( $gags_recaptcha_auth['gags_captcha_secret'] ) ? esc_attr( $gags_recaptcha_auth['gags_captcha_secret'] ) : '';

				if(!$captcha){
		 			gags_errors()->add('captcha_unavailable', esc_html__('Make sure to enter the correct captcha', 'gags-plugin'));
		        }
		        $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret_key."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
	 		}
	 
			$errors = gags_errors()->get_error_messages();
	 
			// only create the user in if there are no errors
			if(empty($errors)) {
	 
				$new_user_id = wp_insert_user(array(
						'user_login'		=> $user_login,
						'user_pass'	 		=> $user_pass,
						'user_email'		=> $user_email,
						'first_name'		=> $user_first,
						'last_name'			=> $user_last,
						'user_registered'	=> date('Y-m-d H:i:s'),
					)
				);
				if($new_user_id) {
					// send an email to the admin alerting them of the registration
					wp_new_user_notification($new_user_id);
	 
					// log the new user in
					wp_set_auth_cookie($user_login, $user_pass, true);
					wp_set_current_user($new_user_id, $user_login);	
					// do_action('wp_login', $user_login);
	 
					// send the newly created user to the home page after logging them in
					$url_permalink_redirect = get_permalink();
					wp_redirect( $url_permalink_redirect."?success=1" );
					exit;
				}
	 
			}
	 
		}
	}
}
add_action('init', 'gags_add_new_member');

/**
* Functions to login a member
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_login_member' ) ) {
	function gags_login_member() {
	 
		if(isset($_POST['gags_user_login']) && isset($_POST['gags_login_nonce']) && wp_verify_nonce($_POST['gags_login_nonce'], 'gags-login-nonce')) {
	 
			// this returns the user ID and other info from the user name
			$user = get_user_by('login', $_POST['gags_user_login'] );
			if(isset($_POST['g-recaptcha-response'])){
	        	$captcha = $_POST['g-recaptcha-response'];
	        }
	 
			if(!$user) {
				// if the user name doesn't exist
				gags_errors()->add('empty_username', esc_html__('Invalid username', 'gags-plugin'));
			}
	 
			if(!isset($_POST['gags_user_pass']) || $_POST['gags_user_pass'] == '') {
				// if no password was entered
				gags_errors()->add('empty_password', esc_html__('Please enter a password', 'gags-plugin'));
			}
	 
			// check the user's login with their password
			if($user && !wp_check_password($_POST['gags_user_pass'], $user->data->user_pass, $user->ID)) {
				// if the password is incorrect for the specified user
				gags_errors()->add('empty_password', esc_html__('Incorrect password', 'gags-plugin'));
			}

			$options = get_option( 'gags_plugin_captcha_auth' );
			$gags_captcha_enabled = '';
			if( isset( $options['gags_captcha_enabled'] ) ) {
				$gags_captcha_enabled = esc_attr( $options['gags_captcha_enabled'] );
			} // end if

			if ( $gags_captcha_enabled == 1 && !isset($_POST['submit-recaptcha-setup']) ) {
				$gags_recaptcha_auth = get_option('gags_plugin_captcha_auth');
				$recaptcha_secret_key = !empty( $gags_recaptcha_auth['gags_captcha_secret'] ) ? esc_attr( $gags_recaptcha_auth['gags_captcha_secret'] ) : '';

				if(!$captcha){
		 			gags_errors()->add('captcha_unavailable', esc_html__('Make sure to enter the correct captcha', 'gags-plugin'));
		        }
		        $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret_key."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
	 		}
	 
			// retrieve all error messages
			$errors = gags_errors()->get_error_messages();
	 
			// only log the user in if there are no errors
			if(empty($errors)) {
	 
				wp_setcookie($_POST['gags_user_login'], $_POST['gags_user_pass'], true);
				wp_set_current_user($user->ID, $_POST['gags_user_login']);	
				do_action('wp_login', $_POST['gags_user_login']);
	 
				wp_redirect(home_url()); exit;
			}
		}
	}
}
add_action('init', 'gags_login_member');

/**
* Functions to used for tracking error messages
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_errors' ) ) {
	function gags_errors(){
	    static $wp_error; // Will hold global variable safely
	    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
	}
}

/**
* Functions to displays error messages from form submissions
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_show_error_messages' ) ) {
	function gags_show_error_messages() {
		if($codes = gags_errors()->get_error_codes()) {
			echo '<div class="alert alert-danger">';
			    // Loop error codes and display errors
			   	foreach($codes as $code){
			        $message = gags_errors()->get_error_message($code);
			        echo '<strong>' . __('Error') . '</strong>: ' . $message . '<br/>';
			    }
			echo '</div>';
		}	
	}
}

/**
* Functions to set likes data
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
add_action( 'wp_ajax_nopriv_jm-post-like', 'gags_post_like' );
add_action( 'wp_ajax_jm-post-like', 'gags_post_like' );
if ( ! function_exists( 'gags_post_like' ) ) {
	function gags_post_like() {
		$nonce = $_POST['nonce'];
	    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
	        die ( 'Nope!' );
		
		if ( isset( $_POST['jm_post_like'] ) ) {
		
			$post_id = $_POST['post_id']; // post id
			$post_like_count = get_post_meta( $post_id, "_post_like_count", true ); // post like count
			
			if ( function_exists ( 'wp_cache_post_change' ) ) { // invalidate WP Super Cache if exists
				$GLOBALS["super_cache_enabled"]=1;
				wp_cache_post_change( $post_id );
			}
			
			if ( is_user_logged_in() ) { // user is logged in
				$user_id = get_current_user_id(); // current user
				$meta_POSTS = get_user_option( "_liked_posts", $user_id  ); // post ids from user meta
				$meta_USERS = get_post_meta( $post_id, "_user_liked" ); // user ids from post meta
				$liked_POSTS = NULL; // setup array variable
				$liked_USERS = NULL; // setup array variable
				
				if ( count( $meta_POSTS ) != 0 ) { // meta exists, set up values
					$liked_POSTS = $meta_POSTS;
				}
				
				if ( !is_array( $liked_POSTS ) ) // make array just in case
					$liked_POSTS = array();
					
				if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
					$liked_USERS = $meta_USERS[0];
				}		

				if ( !is_array( $liked_USERS ) ) // make array just in case
					$liked_USERS = array();
					
				$liked_POSTS['post-'.$post_id] = $post_id; // Add post id to user meta array
				$liked_USERS[$user_id] = $user_id; // add user id to post meta array
				$user_likes = count( $liked_POSTS ); // count user likes
		
				if ( !gags_AlreadyLiked( $post_id ) ) { // like the post
					add_post_meta( $post_id, "_user_liked", $user_id ); // Add user ID to post meta
					update_post_meta( $post_id, "_user_liked", $liked_USERS ); // Add user ID to post meta
					update_post_meta( $post_id, "_post_like_count", ++$post_like_count ); // +1 count post meta
					update_user_option( $user_id, "_liked_posts", $liked_POSTS ); // Add post ID to user meta
					update_user_option( $user_id, "_user_like_count", $user_likes ); // +1 count user meta
					echo $post_like_count; // update count on front end

				} else { // unlike the post
					$pid_key = array_search( $post_id, $liked_POSTS ); // find the key
					$uid_key = array_search( $user_id, $liked_USERS ); // find the key
					unset( $liked_POSTS[$pid_key] ); // remove from array
					unset( $liked_USERS[$uid_key] ); // remove from array
					$user_likes = count( $liked_POSTS ); // recount user likes
					update_post_meta( $post_id, "_user_liked", $liked_USERS ); // Remove user ID from post meta
					update_post_meta($post_id, "_post_like_count", --$post_like_count ); // -1 count post meta
					update_user_option( $user_id, "_liked_posts", $liked_POSTS ); // Remove post ID from user meta			
					update_user_option( $user_id, "_user_like_count", $user_likes ); // -1 count user meta
					echo "already".$post_like_count; // update count on front end
				}
				
			} else { // user is not logged in (anonymous)
				$ip = $_SERVER['REMOTE_ADDR']; // user IP address
				$meta_IPS = get_post_meta( $post_id, "_user_IP" ); // stored IP addresses
				$liked_IPS = NULL; // set up array variable
				
				if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
					$liked_IPS = $meta_IPS[0];
				}
		
				if ( !is_array( $liked_IPS ) ) // make array just in case
					$liked_IPS = array();
					
				if ( !in_array( $ip, $liked_IPS ) ) // if IP not in array
					$liked_IPS['ip-'.$ip] = $ip; // add IP to array
				
				if ( !gags_AlreadyLiked( $post_id ) ) { // like the post
					update_post_meta( $post_id, "_user_IP", $liked_IPS ); // Add user IP to post meta
					update_post_meta( $post_id, "_post_like_count", ++$post_like_count ); // +1 count post meta
					echo $post_like_count; // update count on front end
					
				} else { // unlike the post
					$ip_key = array_search( $ip, $liked_IPS ); // find the key
					unset( $liked_IPS[$ip_key] ); // remove from array
					update_post_meta( $post_id, "_user_IP", $liked_IPS ); // Remove user IP from post meta
					update_post_meta( $post_id, "_post_like_count", --$post_like_count ); // -1 count post meta
					echo "already".$post_like_count; // update count on front end
					
				}
			}
		}
		exit;
	}
}

/**
* Functions to set already liked post
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_AlreadyLiked' ) ) {
	function gags_AlreadyLiked( $post_id ) { // test if user liked before
		if ( is_user_logged_in() ) { // user is logged in
			$user_id = get_current_user_id(); // current user
			$meta_USERS = get_post_meta( $post_id, "_user_liked" ); // user ids from post meta
			$liked_USERS = ""; // set up array variable
			
			if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
				$liked_USERS = $meta_USERS[0];
			}
			
			if( !is_array( $liked_USERS ) ) // make array just in case
				$liked_USERS = array();
				
			if ( in_array( $user_id, $liked_USERS ) ) { // True if User ID in array
				return true;
			}
			return false;
			
		} else { // user is anonymous, use IP address for voting
		
			$meta_IPS = get_post_meta( $post_id, "_user_IP" ); // get previously voted IP address
			$ip = $_SERVER["REMOTE_ADDR"]; // Retrieve current user IP
			$liked_IPS = ""; // set up array variable
			
			if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
				$liked_IPS = $meta_IPS[0];
			}
			
			if ( !is_array( $liked_IPS ) ) // make array just in case
				$liked_IPS = array();
			
			if ( in_array( $ip, $liked_IPS ) ) { // True is IP in array
				return true;
			}
			return false;
		}	
	}
}

/**
* Functions to create like button in frontend
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_getPostLikeLink' ) ) {
	function gags_getPostLikeLink( $post_id ) {
		$like_count = get_post_meta( $post_id, "_post_like_count", true ); // get post likes
		$count = ( empty( $like_count ) || $like_count == "0" ) ? '0' : esc_attr( $like_count );
		$input = number_format($count);
	    $input_count = substr_count($input, ',');
	    if($input_count != '0'){
	        if($input_count == '1'){
	            $count = str_replace(',','.',substr($input, 0, -2).'K');
	        } else if($input_count == '2'){
				$count = str_replace(',','.',substr($input, 0, -6).'M');
	        } else if($input_count == '3'){
				$count = str_replace(',','.',substr($input, 0,  -10).'B');
	        } else {
	            $count = '';
	        }
	    } else {
	        $count = ( empty( $like_count ) || $like_count == "0" ) ? '0' : esc_attr( $like_count );
	    }
		if ( gags_AlreadyLiked( $post_id ) ) {
			$class = esc_attr( 'article-vote liked ' );
			$title = esc_html__('You already liked!', 'gags-plugin');
			if ( $count <= 1 ) {
				$voted = esc_html__(' Like', 'gags-plugin');
			} else if( strlen($count) <= 3 && $count != 1 ) {
				$voted = esc_html__(' Likes', 'gags-plugin');
			} else{
				$voted = '';
			}
			$heart = '<i class="fa fa-chevron-up"></i>';
			if ( is_user_logged_in() ) :
				$output = '<a href="#" class="'.$class.'" data-post_id="'.$post_id.'" title="'.$title.'">'.$heart.'<span class="like-count">'.$count.'</span><span class="like-text">'.$voted.'</span></a>';
			else :
				$gags_login_pages = get_option('gags_plugin_page_setting');
				if ($gags_login_pages['gags_login_page'] != '') {
					$output = '<a href="'.esc_url( $gags_login_pages['gags_login_page'] ).'" data-post_id="'.$post_id.'" title="'.$title.'" class="article-vote">'.$heart.'<span class="like-count">'.$count.'</span><span class="like-text">'.$voted.'</span></a>';
				}
			endif;
		} else {
			$class = esc_attr( 'article-vote jm-post-like ' );
			$title = esc_html__('Like', 'gags-plugin');
			if ( $count <= 1 ) {
				$voted = esc_html__(' Like', 'gags-plugin');
			} else if( strlen($count) <= 3 && $count != 1 ) {
				$voted = esc_html__(' Likes', 'gags-plugin');
			} else{
				$voted = '';
			}
			$heart = '<i class="fa fa-chevron-up"></i>';
			if ( is_user_logged_in() ) :
				$output = '<a href="#" class="'.$class.'" data-post_id="'.$post_id.'" title="'.$title.'">'.$heart.'<span class="like-count">'.$count.'</span><span class="like-text">'.$voted.'</span></a>';
			else :
				$gags_login_pages = get_option('gags_plugin_page_setting');
				if ($gags_login_pages['gags_login_page'] != '') {
					$output = '<a href="'.esc_url( $gags_login_pages['gags_login_page'] ).'" data-post_id="'.$post_id.'" title="'.$title.'" class="article-vote">'.$heart.'<span class="like-count">'.$count.'</span><span class="like-text">'.$voted.'</span></a>';
				}else{
					$output = '<a href="#" data-post_id="'.$post_id.'" title="'.$title.'" class="article-vote">'.$heart.'<span class="like-count">'.$count.'</span><span class="like-text">'.$voted.'</span></a>';
				}
			endif;
			global $post;
			$user_id = get_current_user_id();
			$author_id = $post->post_author;
			if ( $author_id == $user_id ) :
				$class = esc_attr( 'article-vote liked ' );
				$title = esc_html__('You already liked!', 'gags-plugin');
				if ( $count <= 1 ) {
					$voted = esc_html__(' Like', 'gags-plugin');
				} else if( strlen($count) <= 3 && $count != 1 ) {
					$voted = esc_html__(' Likes', 'gags-plugin');
				} else{
					$voted = '';
				}
				if ( is_user_logged_in() ) :
					$output = '<a href="#" class="'.$class.'" data-post_id="'.$post_id.'" title="'.$title.'">'.$heart.'<span class="like-count">'.$count.'</span><span class="like-text">'.$voted.'</span></a>';
				else :
					$gags_login_pages = get_option('gags_plugin_page_setting');
					if ($gags_login_pages['gags_login_page'] != '') {
						$output = '<a href="'.esc_url( $gags_login_pages['gags_login_page'] ).'" data-post_id="'.$post_id.'" title="'.$title.'" class="article-vote">'.$heart.'<span class="like-count">'.$count.'</span><span class="like-text">'.$voted.'</span></a>';
					}else{
						$output = '<a href="#" data-post_id="'.$post_id.'" title="'.$title.'" class="article-vote">'.$heart.'<span class="like-count">'.$count.'</span><span class="like-text">'.$voted.'</span></a>';
					}
				endif;
			endif;
		}
		return $output;
	}
}

/**
* Functions to set update profile
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_update_profile' ) ) {
function gags_update_profile() {
	/* Get user info. */
	$current_user = wp_get_current_user();

	$error = array();    
	/* If profile was saved, update profile. */
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {

	    /* Update user information. */
	    if ( !empty( $_POST['email'] ) ){
	        if (!is_email(esc_attr( $_POST['email'] )))
	            $error[] = esc_html__('The Email you entered is not valid.  please try again.', 'gags-plugin');
	        elseif(email_exists(esc_attr( $_POST['email'] )) != $current_user->ID )
	            $error[] = esc_html__('This email is already used by another user.  try a different one.', 'gags-plugin');
	        else{
	            wp_update_user( array ('ID' => $current_user->ID, 'user_email' => esc_attr( $_POST['email'] )));
	        }
	    }
	    if ( !empty( $_POST['first-name'] ) ) {
	        update_user_meta( $current_user->ID, 'first_name', esc_attr( $_POST['first-name'] ) );
	    }
	    if ( !empty( $_POST['nick-name'] ) ) {
	        update_user_meta($current_user->ID, 'nickname', esc_attr( $_POST['nick-name'] ) );
	    }
	    if ( !empty( $_POST['last-name'] ) ) {
	        update_user_meta($current_user->ID, 'last_name', esc_attr( $_POST['last-name'] ) );
	    }
	    if ( !empty( $_POST['display_name'] ) ) {
	        wp_update_user(array('ID' => $current_user->ID, 'display_name' => esc_attr( $_POST['display_name'] )));
	        update_user_meta($current_user->ID, 'display_name' , esc_attr( $_POST['display_name'] ));
	    }
	    if ( !empty( $_POST['description'] ) ) {
	        update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['description'] ) );
	    }

		if ( count($error) == 0 ) {
			//action hook for plugins and extra fields saving
			do_action('edit_user_profile_update', $current_user->ID);
			wp_redirect( get_permalink().'?updated=true' ); exit;
		}
	}

	// show validation messages
	$warrior_get_update_notice = isset($_GET['updated']) ? $_GET['updated'] : ''; if ( $warrior_get_update_notice == 'true' ) : ?>
        <div class="alert alert-success">
        	<?php esc_html_e('Your profile has been updated!', 'gags-plugin'); ?>
        </div>
    <?php endif; ?>
    <?php if ( count($error) > 0 ) echo '<div class="alert alert-danger"> ' . implode("<br />", $error) . '</div>';
	}
}

/**
* Functions to set display avatar
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_display_avatar' ) ) {
	function gags_display_avatar() {	
		// display wordpress avatar
		$user = wp_get_current_user();
		$user_id = $user->ID;

        echo get_avatar( $user_id, 100 );    
	}
}

/**
* Functions to get user submit post count
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_get_auth_post_count' ) ) {
	function gags_get_auth_post_count() {
		global $wpdb;

        if( is_author() ) {
            // Get current author
            $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
            $user_id = $author->ID; // get current author
        } elseif( is_page() ) {
            $user_id = get_current_user_id();
        }

	    return count_user_posts( $user_id , 'gag');
	}
}

/**
* Functions to get user comment count
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_get_auth_comment_count' ) ) {
	function gags_get_auth_comment_count() {
		global $wpdb;

        if( is_author() ) {
            // Get current author
            $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
            $user_id = $author->ID; // get current author
        } elseif( is_page() ) {
            $user_id = get_current_user_id();
        }

	    $comment_count = count( get_comments( array(
		    'user_id' 	=> $user_id
		) ) );

		return $comment_count;
	}
}

/**
* Functions to get user post liked count
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_get_auth_voted_count' ) ) {
	function gags_get_auth_voted_count() {
        if( is_author() ) {
            // Get current author
            $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
            $user_id = $author->ID; // get current author
        } elseif( is_page() ) {
            $user_id = get_current_user_id();
        }

        $user_likes = get_user_option( "_liked_posts", $user_id );
	    if ( !empty( $user_likes ) && count( $user_likes ) > 0 ) {
	        $the_likes = $user_likes;
	    } else {
	        $the_likes = '';
	    }
	    if ( !is_array( $the_likes ) )
	    $the_likes = array();
	    $count = count( $the_likes ); 
	    echo $count;
	}
}

/**
* Functions to display social login oauth button
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_social_login_auth' ) ) {
	function gags_social_login_auth() {
		$gags_social_log_auth = get_option('gags_plugin_social_auth');

		$gags_fb_app_id = esc_attr($gags_social_log_auth['gags_fb_app_id']);
		$gags_fb_app_secret = esc_attr($gags_social_log_auth['gags_fb_app_secret']);

		$gags_tw_cons_key = esc_attr($gags_social_log_auth['gags_tw_cons_key']);
		$gags_tw_cons_api = esc_attr($gags_social_log_auth['gags_tw_cons_api']);

		// Login via facebook auth
		if ($gags_fb_app_id && $gags_fb_app_secret) :
			echo gags_login_w_facebook();
		endif;

		// Login via twitter auth	
		if ($gags_tw_cons_key && $gags_tw_cons_api) :
			echo gags_login_w_twitter();
		endif;

		$gags_lost_password_page = get_option('gags_plugin_page_setting');
		if ($gags_lost_password_page) :
?>
		<a href="<?php echo esc_url( $gags_lost_password_page['gags_lost_pass_page'] ); ?>" style="float: left;" title="<?php esc_html_e(' Lost Password', 'gags-plugin'); ?>" class="lost-password-link"><i class="fa fa-unlock-alt"></i> <?php esc_html_e(' Lost Password', 'gags-plugin'); ?></a>
<?php
		endif;

		$gags_register_pages = get_option('gags_plugin_page_setting');
		if ($gags_register_pages['gags_register_page'] != '') : 
?>
			<a href="<?php echo esc_url( $gags_register_pages['gags_register_page'] ); ?>" style="float: right;" title="<?php esc_html_e(' Register', 'gags-plugin'); ?>" class="register-link"><i class="fa fa-user"></i> <?php esc_html_e(' Register', 'gags-plugin'); ?></a>
<?php
		endif;		
	}
}

/**
* Functions to set redirect edit password
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_edit_password_redire' ) ) {
	function gags_edit_password_redire() {
		/* Get user info. */
		$current_user = wp_get_current_user();

		$error = array();    
		/* If profile was saved, update profile. */
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {
			/* Update user password. */
		    if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
		        if ( $_POST['pass1'] == $_POST['pass2'] )
		            wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
		        else
		            $error[] = esc_html__('The passwords you entered do not match.  Your password was not updated.', 'gags-plugin');
		    } else {
		    	$error[] = esc_html__('Password fields can not be empty!', 'gags-plugin');
		    }

		    if ( count($error) == 0 ) {
			    //action hook for plugins and extra fields saving
			    do_action('edit_user_profile_update', $current_user->ID);
			    wp_redirect( get_permalink().'?updated=true' ); exit;
			}
		}
	}
}

/**
* Functions to set homepage stories duration
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_popular_gag_duration' ) ) {
	function gags_popular_gag_duration() {
		$gags_popular_durr = get_option('gags_plugin_page_setting');
		if ($gags_popular_durr) :
			return esc_attr($gags_popular_durr['gags_top_gag_duration']);
		endif;
	}
}

/**
* Functions to set trending stories duration
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_trending_gag_duration' ) ) {
	function gags_trending_gag_duration() {
		$gags_trending_durr = get_option('gags_plugin_page_setting');
		if ($gags_trending_durr) :
			return esc_attr($gags_trending_durr['gags_trending_gag_duration']);
		endif;
	}
}

/**
* Functions to get post views
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_get_post_views' ) ) {
	function gags_get_post_views($postID){
		$warrior_count_key = 'post_views_count';
	    $warrior_get_count = get_post_meta( $postID, $warrior_count_key, true );
	    $text_views = esc_html__( ' Views', 'gags-plugin' );
	    $text_view 	= esc_html__( ' View', 'gags-plugin' );
	    if( $warrior_get_count == '' ){
	        delete_post_meta( $postID, $warrior_count_key );
	        add_post_meta( $postID, $warrior_count_key, '0' );
	        return "0".$text_view;
	    }
	    return $warrior_get_count.$text_views;
	}
}

/**
* Functions to set post views
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_set_post_views' ) ) {
	function gags_set_post_views( $postID ) {
	    $warrior_count_key = 'post_views_count';
	    $warrior_get_count = get_post_meta($postID, $warrior_count_key, true);
	    if($warrior_get_count == '' ){
	        $warrior_get_count = 0;
	        delete_post_meta( $postID, $warrior_count_key );
	        add_post_meta( $postID, $warrior_count_key, '0' );
	    }else{
	        $warrior_get_count++;
	        update_post_meta( $postID, $warrior_count_key, $warrior_get_count );
	    }
	}
}

/**
* Functions to set custom taxonomy stories post type templates
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_custom_tax_template' ) ) {
	function gags_custom_tax_template( $taxonomy_template ){
	    if( is_tax('gag_category') ) {
	        $taxonomy_template = get_gags_template( 'taxonomy-gag_category.php' );
	    } elseif ( is_tax('gag_tag') ) {
	    	$taxonomy_template = get_gags_template( 'taxonomy-gag_tag.php' );
	    } elseif ( is_author() ) {
	    	$taxonomy_template = get_gags_template( 'gags-author.php' );
	    } elseif ( is_search() ) {
	    	$taxonomy_template = get_gags_template( 'gags-search.php' );
	    } elseif (is_singular('gag')) {
	    	$taxonomy_template = get_gags_template( 'single-gag.php' );
	    }

	    return $taxonomy_template;
	}
}
add_filter('template_include', 'gags_custom_tax_template');

/**
* Functions to collect the title of the current pages
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_title' ) ) {
	function gags_title() {
		global $wp_query;

		$title = '';
		if ( is_category() ) :
			$title = sprintf( esc_html__( 'Category: %s', 'gags-plugin' ), single_cat_title( '', false ) );
		elseif ( is_tax('gag_category') ) :
			$stories_cat_terms = wp_get_object_terms( get_the_ID(),  'gag_category' );
			if ( ! empty( $stories_cat_terms ) ) :
				if ( ! is_wp_error( $stories_cat_terms ) ) {
						foreach( $stories_cat_terms as $term ) {
							$title = sprintf( esc_html__( 'Gags Category: %s', 'gags-plugin' ), esc_html( $term->name ) );
						}
				}
			endif;
		elseif ( is_tax('gag_tag') ) :
			$gag_tag_terms = wp_get_object_terms( get_the_ID(),  'gag_tag' );
			if ( ! empty( $gag_tag_terms ) ) :
				if ( ! is_wp_error( $gag_tag_terms ) ) {
						foreach( $gag_tag_terms as $term ) {
							$title = sprintf( esc_html__( 'Gags Tag: %s', 'gags-plugin' ), esc_html( $term->name ) );
						}
				}
			endif;
		elseif ( is_tag() ) :
			$title = sprintf( esc_html__( 'Tag: %s', 'gags-plugin' ), single_tag_title( '', false ) );
		elseif ( is_single() ) :
			$title = wp_trim_words( get_the_title(), 10, ' ...' );
		elseif ( is_day() ) :
			$title = sprintf( esc_html__( '%© Daily Archives', 'gags-plugin' ), date_i18n( 'd', strtotime( get_the_date('Y-m-d'), false ) ) );
		elseif ( is_month() ) :
			$title = sprintf( esc_html__( '%s Monthly Archives', 'gags-plugin' ), date_i18n( 'F', strtotime( get_the_date('Y-m-d'), false ) ) );
		elseif ( is_year() ) :
			$title = sprintf( esc_html__( '%s Yearly Archives', 'gags-plugin' ), date_i18n( 'F', strtotime( get_the_date('Y-m-d'), false ) ) );
		elseif ( is_author() ) :
			$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
			$title = sprintf( esc_html__( '%s Author Archives', 'gags-plugin' ), get_the_author_meta( 'display_name', $author->ID ) );
		elseif ( is_search() ) :
			if ( $wp_query->found_posts ) {
				$title = sprintf( esc_html__( 'Search Keywords: "%s"', 'gags-plugin' ), esc_attr( get_search_query() ) );
			} else {
				$title = sprintf( esc_html__( 'Search Keywords: "%s"', 'gags-plugin' ), esc_attr( get_search_query() ) );
			}
		elseif ( get_post_format() ) :
			$title = sprintf( esc_html__( 'Post Format: %s', 'gags-plugin' ), get_post_format_string( get_post_format() ) );
		elseif ( is_404() ) :
			$title = esc_html__( 'Not Found', 'gags-plugin' );
		elseif ( is_home() || is_front_page() || is_single() ) :
			$title = '';
		else :
			$title = get_the_title();
		endif;
		
		return $title;
	}
}

/**
* Functions to set default pages
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_set_default_page_templates' ) ) {
	function gags_set_default_page_templates(){
		// Page Homepage
		$gags_homepage_page_title = 'Homepage';
		$gags_homepage_page_content = '[gags_recent_posts]';

		$gags_homepage_page_check = get_page_by_title($gags_homepage_page_title);
		$gags_homepage_page = array(
		        'post_type' => 'page',
		        'post_title' => $gags_homepage_page_title,
		        'post_content' => $gags_homepage_page_content,
		        'post_status' => 'publish',
		        'post_author' => 1,
		);
		if(!isset($gags_homepage_page_check->ID)){
		    $gags_homepage_page_id = wp_insert_post($gags_homepage_page);
		}
		// END

		// Page Trending Gags
		$gags_trending_stories_page_title = 'Trending Gags';
		$gags_trending_stories_page_content = '[gags_trending_posts]';

		$gags_trending_stories_page_check = get_page_by_title($gags_trending_stories_page_title);
		$gags_trending_stories_page = array(
		        'post_type' => 'page',
		        'post_title' => $gags_trending_stories_page_title,
		        'post_content' => $gags_trending_stories_page_content,
		        'post_status' => 'publish',
		        'post_author' => 1,
		);
		if(!isset($gags_trending_stories_page_check->ID)){
		    $gags_trending_stories_page_id = wp_insert_post($gags_trending_stories_page);
		}
		// END

		// Page Popular Gags
		$gags_popular_stories_page_title = 'Popular Gags';
		$gags_popular_stories_page_content = '[gags_popular_posts]';

		$gags_popular_stories_page_check = get_page_by_title($gags_popular_stories_page_title);
		$gags_popular_stories_page = array(
		        'post_type' => 'page',
		        'post_title' => $gags_popular_stories_page_title,
		        'post_content' => $gags_popular_stories_page_content,
		        'post_status' => 'publish',
		        'post_author' => 1,
		);
		if(!isset($gags_popular_stories_page_check->ID)){
		    $gags_popular_stories_page_id = wp_insert_post($gags_popular_stories_page);
		}
		// END

		// Page Recent Gags
		$gags_recent_stories_page_title = 'Recent Gags';
		$gags_recent_stories_page_content = '[gags_recent_posts]';

		$gags_recent_stories_page_check = get_page_by_title($gags_recent_stories_page_title);
		$gags_recent_stories_page = array(
		        'post_type' => 'page',
		        'post_title' => $gags_recent_stories_page_title,
		        'post_content' => $gags_recent_stories_page_content,
		        'post_status' => 'publish',
		        'post_author' => 1,
		);
		if(!isset($gags_recent_stories_page_check->ID)){
		    $gags_recent_stories_page_id = wp_insert_post($gags_recent_stories_page);
		}
		// END

		// Page Submit Gags
		$gags_submit_page_title = 'Submit Gags';
		$gags_submit_page_template = 'page-full-width.php';
		$gags_submit_page_content = '[gags_submit]';

		$gags_submit_page_check = get_page_by_title($gags_submit_page_title);
		$gags_submit_page = array(
		        'post_type' => 'page',
		        'post_title' => $gags_submit_page_title,
		        'post_content' => $gags_submit_page_content,
		        'post_status' => 'publish',
		        'post_author' => 1,
		);
		if(!isset($gags_submit_page_check->ID)){
		    $gags_submit_page_id = wp_insert_post($gags_submit_page);
		    if( $gags_submit_page_id )
		        update_post_meta($gags_submit_page_id, '_wp_page_template', $gags_submit_page_template);
		}
		// END

		// Page Dashboard
		$gags_dashboard_page_title = 'Dashboard';
		$gags_dashboard_page_template = 'page-dashboard.php';
		$gags_dashboard_page_content = '[gags_dashboard]';

		$gags_dashboard_page_check = get_page_by_title($gags_dashboard_page_title);
		$gags_dashboard_page = array(
		        'post_type' => 'page',
		        'post_title' => $gags_dashboard_page_title,
		        'post_content' => $gags_dashboard_page_content,
		        'post_status' => 'publish',
		        'post_author' => 1,
		);
		if(!isset($gags_dashboard_page_check->ID)){
		    $gags_dashboard_page_id = wp_insert_post($gags_dashboard_page);
		    if( $gags_dashboard_page_id )
		        update_post_meta($gags_dashboard_page_id, '_wp_page_template', $gags_dashboard_page_template);
		}
		// END

		// Page Edit Profile
		$gags_edit_profile_page_title = 'Edit Profile';
		$gags_edit_profile_page_template = 'page-full-width.php';
		$gags_edit_profile_page_content = '[gags_edit_profile]';

		$gags_edit_profile_page_check = get_page_by_title($gags_edit_profile_page_title);
		$gags_edit_profile_page = array(
		        'post_type' => 'page',
		        'post_title' => $gags_edit_profile_page_title,
		        'post_content' => $gags_edit_profile_page_content,
		        'post_status' => 'publish',
		        'post_author' => 1,
		);
		if(!isset($gags_edit_profile_page_check->ID)){
		    $gags_edit_profile_page_id = wp_insert_post($gags_edit_profile_page);
		    if( $gags_edit_profile_page_id )
		        update_post_meta($gags_edit_profile_page_id, '_wp_page_template', $gags_edit_profile_page_template);
		}
		// END

		// Page Edit Password
		$gags_edit_password_page_title = 'Edit Password';
		$gags_edit_password_page_template = 'page-full-width.php';
		$gags_edit_password_page_content = '[gags_edit_password]';

		$gags_edit_password_page_check = get_page_by_title($gags_edit_password_page_title);
		$gags_edit_password_page = array(
		        'post_type' => 'page',
		        'post_title' => $gags_edit_password_page_title,
		        'post_content' => $gags_edit_password_page_content,
		        'post_status' => 'publish',
		        'post_author' => 1,
		);
		if(!isset($gags_edit_password_page_check->ID)){
		    $gags_edit_password_page_id = wp_insert_post($gags_edit_password_page);
		    if( $gags_edit_password_page_id )
		        update_post_meta($gags_edit_password_page_id, '_wp_page_template', $gags_edit_password_page_template);
		}
		// END

		// Page Lost Password
		$gags_lost_password_page_title = 'Lost Password';
		$gags_lost_password_page_template = 'page-full-width.php';
		$gags_lost_password_page_content = '[gags_lost_password]';

		$gags_lost_password_page_check = get_page_by_title($gags_lost_password_page_title);
		$gags_lost_password_page = array(
		        'post_type' => 'page',
		        'post_title' => $gags_lost_password_page_title,
		        'post_content' => $gags_lost_password_page_content,
		        'post_status' => 'publish',
		        'post_author' => 1,
		);
		if(!isset($gags_lost_password_page_check->ID)){
		    $gags_lost_password_page_id = wp_insert_post($gags_lost_password_page);
		    if( $gags_lost_password_page_id )
		        update_post_meta($gags_lost_password_page_id, '_wp_page_template', $gags_lost_password_page_template);
		}
		// END

		// Page Login
		$gags_login_page_title = 'Login';
		$gags_login_page_template = 'page-full-width.php';
		$gags_login_page_content = '[gags_login]';

		$gags_login_page_check = get_page_by_title($gags_login_page_title);
		$gags_login_page = array(
		        'post_type' => 'page',
		        'post_title' => $gags_login_page_title,
		        'post_content' => $gags_login_page_content,
		        'post_status' => 'publish',
		        'post_author' => 1,
		);
		if(!isset($gags_login_page_check->ID)){
		    $gags_login_page_id = wp_insert_post($gags_login_page);
		    if( $gags_login_page_id )
		        update_post_meta($gags_login_page_id, '_wp_page_template', $gags_login_page_template);
		}
		// END

		// Page Register
		$gags_register_page_title = 'Register';
		$gags_register_page_template = 'page-full-width.php';
		$gags_register_page_content = '[gags_register]';

		$gags_register_page_check = get_page_by_title($gags_register_page_title);
		$gags_register_page = array(
		        'post_type' => 'page',
		        'post_title' => $gags_register_page_title,
		        'post_content' => $gags_register_page_content,
		        'post_status' => 'publish',
		        'post_author' => 1,
		);
		if(!isset($gags_register_page_check->ID)){
		    $gags_register_page_id = wp_insert_post($gags_register_page);
		    if( $gags_register_page_id )
		        update_post_meta($gags_register_page_id, '_wp_page_template', $gags_register_page_template);
		}
		// END
	}
}

/**
* Functions to set user last login
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_get_user_last_login' ) ) {
	function gags_get_user_last_login($user_id,$echo = true){
	    $date_format = get_option('date_format') . ' ' . get_option('time_format');
	    $last_login = get_user_meta($user_id, 'last_login', true);
	    $last_login_time = strtotime($last_login);
	    $login_time = 'Never logged in';
	    if(!empty($last_login)){
	       if(is_array($last_login)){
	       		$login_time = gags_humanTiming($last_login_time);
	        }
	        else{
	            $login_time = gags_humanTiming($last_login_time);
	        }
	    }
	    if($echo){
	        echo esc_html__('Last active ', 'gags-plugin') . $login_time . esc_html__(' ago.', 'gags-plugin');
	    }
	    else{
	        return $login_time;
	    }
	}
}

/**
* Functions to set human timing
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_humanTiming' ) ) {
	function gags_humanTiming($time)
	{
		if( is_author() ) {
	        // Get current author
	        $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
	       	$user_id = $author->ID; // get current author
	    } elseif( is_page() ) {
	        $user_id = get_current_user_id();
	    }
		$date_format = get_option('date_format') . ' ' . get_option('time_format');
	    $last_login = get_user_meta($user_id, 'last_login', true);

	    $time = strtotime(current_time('Y-m-d H:i:s')) - strtotime($last_login); // to get the time since that moment
	    $time = ($time<1)? 1 : $time;
	    $tokens = array (
	        31536000 => 'year',
	        2592000 => 'month',
	        604800 => 'week',
	        86400 => 'day',
	        3600 => 'hour',
	        60 => 'minute',
	        1 => 'second'
	    );

	    foreach ($tokens as $unit => $text) {
	        if ($time < $unit) continue;
	        $numberOfUnits = floor($time / $unit);
	        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
	    }

	}
}

add_image_size( 'gags-post-thumbnail', 602, 9999 ); // featured post thumbnail image
add_image_size( 'gags-gif-thumbnail', 602, 325, true ); // gif post thumbnail image
add_image_size( 'gags-popular-thumbnail', 301, 140, true ); // popular post thumbnail image

/**
* Hook Gags After Content
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_after_content' ) ) {
	function gags_after_content(){
		do_action('gags_after_content');
	}
}

/**
* Function to display yaarp related posts
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_yaarp_related_to_content' ) ) {
 	function gags_yaarp_related_to_content() {   
	    if( is_singular('gag') && function_exists('yarpp_related') ) {
	   		// Related stories
		    echo yarpp_related(array(
			    // Pool options: these determine the "pool" of entities which are considered
			    'post_type' => array('gag'),
			    'show_pass_post' => false, // show password-protected posts
			    'past_only' => false, // show only posts which were published before the reference post
			    'exclude' => array(), // a list of term_taxonomy_ids. entities with any of these terms will be excluded from consideration.
			    'recent' => false, // to limit to entries published recently, set to something like '15 day', '20 week', or '12 month'.
			    // Relatedness options: these determine how "relatedness" is computed
			    // Weights are used to construct the "match score" between candidates and the reference post
			    'weight' => array(
		              'body' => 3,
		              'title' => 2, // larger weights mean this criteria will be weighted more heavily
		              'tax' => array(
		                  'gag_tag' => 3, // put any taxonomies you want to consider here with their weights
		                  'gag_category' => 3, // put any taxonomies you want to consider here with their weights
		              )
		          ),
			    // The threshold which must be met by the "match score"
			    'threshold' => 2,

			    // Display options:
			    'limit' => 4, // maximum number of results
			    'order' => 'score DESC'
			),
			get_the_ID(), // second argument: (optional) the post ID. If not included, it will use the current post.
			false); // third argument: (optional) true to echo the HTML block; false to return it

	    }
 	}
}
add_filter('gags_after_content','gags_yaarp_related_to_content');

/**
* Function to set paging query var
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_query_paged' ) ) {
	function gags_query_paged() {
		global $paged;
		if ( get_query_var('paged') ) {
	        $paged = get_query_var('paged');
	    } elseif ( get_query_var('page') ) {
	        $paged = get_query_var('page');
	    } else {
	        $paged = 1;
	    }
	    return $paged;
	}
}


/**
* Function to display facebook comments
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_facebook_comment' ) ) {
	function gags_facebook_comment() { 
	$gags_facebook_comment = get_option('gags_plugin_page_setting');
	if ($gags_facebook_comment) :
		$gags_fb_app_key = esc_attr($gags_facebook_comment['gags_fb_app_key']);
	endif;?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.7&appId=<?php echo $gags_fb_app_key ?>";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="100%" data-numposts="5"></div>
<?php
	}
}

/**
* Function to display comments option
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_comments_option' ) ) {
	function gags_comments_option() {
		$gags_facebook_comment = get_option('gags_plugin_page_setting');
		if ($gags_facebook_comment) :
			$get_gags_comment_option = esc_attr($gags_facebook_comment['gags_comment_option']);
		endif;
		if(isset($get_gags_comment_option)){
			if($get_gags_comment_option == 'fb_comment'){
				gags_facebook_comment();
			}else if($get_gags_comment_option == 'wp_comment'){
				comments_template( '', true ); 
			}else if ($get_gags_comment_option == 'both'){
				gags_facebook_comment();
				comments_template( '', true ); 
			}else{
				comments_template( '', true ); 
			}

		}
	}
}

/**
* Function to display pagination on author page
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_author_archive_paged' ) ) {
	function gags_author_archive_paged( $query ) {
	    if ($query->is_author)
	        $query->set( 'post_type', array( 'post', 'gag' ) );
	}
}
add_action( 'pre_get_posts', 'gags_author_archive_paged' );


/**
* Function to add class to next post button
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
function gags_posts_link_attributes() {
    return 'class="nextpostslink"';
}
add_filter('next_posts_link_attributes', 'gags_posts_link_attributes');

/**
* Function to change custom Post type name.
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/

function gags_post_type() {
	$gags_change_slug_option = get_option('gags_plugin_page_setting');
	if ($gags_change_slug_option) :
		$gags_change_slug = $gags_change_slug_option['gags_change_slug'];
	endif;
	$name_slug = empty($gags_change_slug) ? 'gag' : $gags_change_slug ;
	if ( ! preg_match('/^[A-Za-z0-9]+$/', $name_slug) ){
		$name_slug = 'gag';
	}
	$lower_slug = strtolower($name_slug);
	$labels = array(
	    'name'                  => esc_html__( 'Gags', 'gags-plugin'),
	    'singular_name'         => esc_html__( 'Gags', 'gags-plugin'),
	    'add_new'               => esc_html__('Add New', 'gags-plugin'),
	    'add_new_item'          => esc_html__('Add New Gags', 'gags-plugin'),
	    'edit_item'             => esc_html__('Edit Gags', 'gags-plugin'),
	    'new_item'              => esc_html__('New Gags', 'gags-plugin'),
	    'view_item'             => esc_html__('View Gags', 'gags-plugin'),
	    'search_items'          => esc_html__('Search Gags', 'gags-plugin'),
	    'not_found'             => esc_html__('Nothing found', 'gags-plugin'),
	    'not_found_in_trash'    => esc_html__('Nothing found in Trash', 'gags-plugin'),
	    'parent_item_colon'     => ''
	);

	$args = array(
	    'labels'                => $labels,
	    'public'                => true,
	    'publicly_queryable'    => true,
	    'show_ui'               => true,
	    'query_var'             => true,
	    'rewrite'               => array( 'slug' => esc_attr($lower_slug), 'with_front' => true ),
	    'menu_icon'             => 'dashicons-welcome-write-blog',
	    'capability_type'       => 'post',
	    'hierarchical'          => false,
	    'menu_position'         => 30,
	    'taxonomies'            => array('gag_category', 'gag_tag'),
	    'register_meta_box_cb'  => 'add_gag_metaboxes',
	    'supports'              => array('title', 'editor', 'excerpt', 'comments', 'revisions', 'thumbnail', 'author', 'post-formats', 'custom-fields')
	); 
register_post_type( 'gag', $args );
flush_rewrite_rules();
}
add_action('init', 'gags_post_type');


/**
* Function to display gags meta
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/includes
*/
if ( ! function_exists( 'gags_meta' ) ) {
	function gags_meta() {
?>
		<div class="entry-meta">
			<span class="author">
				<i class="fa fa-user"></i>
				<?php echo '<a href="' . esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )) . '">' . get_the_author() . '</a>'; ?>
			</span>
			<span class="date">
				<i class="fa fa-clock-o"></i>
				<?php echo human_time_diff( get_the_modified_date('U'), current_time('timestamp') ) . esc_html__(' ago', 'gags'); ?>
			</span>
		</div>
<?php
	}
}