<?php 
/**
* The main template file for register shortcode
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

$get_notif = isset($_GET['success']) ? $_GET['success'] : '';

if( $get_notif == 1 ) {
	echo '<article class="post hentry clearfix">';
		echo '<div class="alert alert-success">';
		wp_kses( _e( '<strong>Horray!</strong> Your registration is completed !, please login to submit your gag, thank you.', 'gags-plugin' ), array( 'strong' => array() ) );
		echo '</div>';
	echo '</div>';
}

ob_start();
?>

<?php if ( get_option( 'users_can_register' ) ) : // check if user can register on this site ?>
	<?php 
		// show any error messages after form submission
		if( function_exists( 'gags_show_error_messages' ) ) {
			gags_show_error_messages();
		}
	?>
		<div class="reset-form">
			<form id="gags_registration_form" class="gags_form" action="" method="POST">
				<div class="input-heading">
					<?php esc_html_e('Profile Information', 'gags-plugin'); ?>	
				</div>

				<div class="input-wrapper input-50 clearfix">
					<input name="gags_user_first" id="gags_user_first" type="text" placeholder="<?php esc_html_e('First name', 'gags-plugin'); ?>	"/>
					<input name="gags_user_last" id="gags_user_last" type="text" placeholder="<?php esc_html_e('Last name', 'gags-plugin'); ?>	"/>
				</div>

				<div class="input-wrapper">
					<input name="gags_user_email" id="gags_user_email" type="email" placeholder="<?php esc_html_e('Email address', 'gags-plugin'); ?>	"/>
				</div>

				<div class="input-heading">
					<?php esc_html_e('Login Information', 'gags-plugin'); ?>	
				</div>

				<div class="input-wrapper">
					<input name="gags_user_login" id="gags_user_login" type="text" placeholder="<?php esc_html_e('Username', 'gags-plugin'); ?>	"/>
				</div>

				<div class="input-wrapper input-50 clearfix">
					<input name="gags_user_pass" id="password" type="password" placeholder="<?php esc_html_e('Password', 'gags-plugin'); ?>	"/>
					<input name="gags_user_pass_confirm" id="password_again" type="password" placeholder="<?php esc_html_e('Repeat password', 'gags-plugin'); ?>	"/>
				</div>

				<?php
				$options = get_option( 'gags_plugin_captcha_auth' );
				$gags_captcha_enabled = '';
				if( isset( $options['gags_captcha_enabled'] ) ) {
					$gags_captcha_enabled = esc_attr( $options['gags_captcha_enabled'] );
				} // end if

				if ( $gags_captcha_enabled == 1 && !isset($_POST['submit-recaptcha-setup']) ) {
					$gags_recaptcha_auth = get_option('gags_plugin_captcha_auth');
					$recaptcha_site_key = !empty( $gags_recaptcha_auth['gags_captcha_key'] ) ? esc_attr( $gags_recaptcha_auth['gags_captcha_key'] ) : '';
				?>
				<div class="input-wrapper">
					<div class="g-recaptcha" data-sitekey="'.<?php echo $recaptcha_site_key; ?>.'"></div>
				</div>
				<?php } ?>

				<div class="input-wrapper submit">
				<input type="hidden" name="gags_register_nonce" value="<?php echo wp_create_nonce('gags-register-nonce'); ?>"/>
				<button type="submit" class="button large-button"><?php esc_html_e('Register', 'gags-plugin'); ?>	</button>
				</div>
			</form>
		</div>
<?php
	else :
		echo '<article class="post hentry clearfix">';
		echo '<div class="alert alert-danger">';
		wp_kses( _e( '<strong>Oops!</strong> Sorry, registration is disabled.', 'gags-plugin' ), array( 'strong' => array() ) );
		echo '</div>';
	echo '</div>';
	endif; 
endif;
?>
