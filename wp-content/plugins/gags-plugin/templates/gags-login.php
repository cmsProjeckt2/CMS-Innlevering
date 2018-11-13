<?php 
/**
* The main template file for login shortcode
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/templates
*/

if ( is_user_logged_in() ) :
	$warrior_login_page  = home_url();
	wp_redirect( $warrior_login_page );  
	exit;
else :

ob_start();
?>
	<div class="login-form">		
		<?php
		$args = array(  
		    'echo'           => true,
	        'redirect'       => home_url(), 
	        'form_id'        => 'gags_login_form',
	        'label_username' => esc_html__('Username', 'upvote-plugin'),
	        'label_password' => esc_html__('Password', 'upvote-plugin'),
	        'label_remember' => esc_html__('Remember Me', 'upvote-plugin'),
	        'label_log_in'   => esc_html__('Log In', 'upvote-plugin'),
	        'id_username'    => 'user_login',
	        'id_password'    => 'user_pass',
	        'id_remember'    => 'rememberme',
	        'id_submit'      => 'wp-submit',
	        'remember'       => false,
	        'value_username' => NULL,
	        'value_remember' => true  
	    );
		wp_login_form( $args ); // Display form login
		?>

		<?php echo gags_social_login_auth(); // display social login auth ?>

	</div>
<?php endif; ?>