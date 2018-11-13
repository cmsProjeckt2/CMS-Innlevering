<?php 
/**
* The main template file for edit password shortcode
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/templates
*/

if( function_exists( 'gags_edit_password_redire' ) ) {
    echo gags_edit_password_redire(); // edit password redire
}
$current_user = wp_get_current_user();
$error = array();
?>
<?php if ( is_user_logged_in() ) : ?>
	<!-- display error message -->
    <?php $warrior_update_pswd = isset($_GET['updated']) ? $_GET['updated'] : ''; if ( $warrior_update_pswd == 'true' ) : ?> 
        <div class="alert alert-success">
        	<?php esc_html_e('Your password has been updated!', 'gags-plugin'); ?>
        </div>
	<?php endif; ?>
    <?php if ( count($error) > 0 ) echo '<div class="alert alert-danger"> ' . implode("<br />", $error) . '</div>'; ?>

    <div class="reset-form">
        <form method="post" action="<?php the_permalink(); ?>">
            <div class="input-wrapper">
                <input class="text-input" name="pass1" type="password" id="pass1" placeholder="<?php esc_html_e('Password', 'gags-plugin'); ?>" />
            </div>
            <div class="input-wrapper">
                 <input class="text-input" name="pass2" type="password" id="pass2" placeholder="<?php esc_html_e('Repeat password', 'gags-plugin'); ?>" />
            </div>

            <div class="input-wrapper submit">
            <button name="updateuser" type="submit" id="updateuser" class="button large-button"><?php esc_html_e('Update Password', 'gags-plugin'); ?></button>
            <?php wp_nonce_field( 'update-user_'. $current_user->ID ) ?>
            <input name="action" type="hidden" id="action" value="update-user" />
            </div>
        </form>
    </div>
<?php else : ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post hentry clearfix' ); ?>>
		<div class="alert alert-danger">
        	<?php esc_html_e( 'You must be logged in to edit a profile', 'gags-plugin' ); ?>
        </div>
	</article>
<?php endif; ?>