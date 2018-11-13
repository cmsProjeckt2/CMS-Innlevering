<?php 
/**
* The main template file for lost password shortcode
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/templates
*/
?>

<?php
if ( is_user_logged_in() ) :
    $warrior_login_page  = home_url();
    wp_redirect( $warrior_login_page );  
    exit;
else :

ob_start();

if( function_exists( 'gags_lost_password' ) ) {
	echo gags_lost_password(); // set function lost password
}
?>
<div class="reset-form">
	<div class="info-lostpassword">
		<i class="icon icon-info-large"></i><p><?php esc_html_e('Please enter your email address. You will receive a link to create a new password via email.', 'gags-plugin'); ?></p>
	</div>
    
    <form method="post" action="<?php the_permalink(); ?>" id="lost-password">
        <div class="input-wrapper">
        	<?php $user_login = isset( $_POST['user_login'] ) ? $_POST['user_login'] : ''; ?>
			<input type="text" name="user_login" id="user_login" class="input" value="<?php echo $user_login; ?>" />
        </div>

        <div class="input-wrapper submit">
        <input type="hidden" name="action" value="reset" />
        <button type="submit" id="submit" class="button large-button"><?php esc_html_e('Get New Password', 'gags-plugin'); ?></button>
        </div>
    </form>
</div>
<?php endif; ?>