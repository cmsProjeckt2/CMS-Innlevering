<?php 
/**
* The main template file for edit profile shortcode
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/templates
*/

$current_user = wp_get_current_user();
?>
<?php if ( is_user_logged_in() ) : ?>
	<div id="gags-reset-profile" class="reset-form">
		<?php 
			if( function_exists( 'gags_update_profile' ) ) {
				echo gags_update_profile(); 
			}
		?>
		<form method="post" id="adduser" action="<?php the_permalink(); ?>" enctype="multipart/form-data">
			<div class="input-wrapper">
				<label>
					<span><?php esc_html_e('First name', 'gags-plugin'); ?></span>
					<input type="text" name="first-name" id="edit_firstname" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" placeholder="<?php esc_html_e('First name', 'gags-plugin'); ?>" />
				</label>
			</div>
			<div class="input-wrapper">
				<label>
					<span><?php esc_html_e('Last name', 'gags-plugin'); ?></span>
					<input type="text" name="last-name" id="edit_lastname" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" placeholder="<?php esc_html_e('Last name', 'gags-plugin'); ?>" />
				</label>
			</div>
			<div class="input-wrapper">
				<label>
					<span><?php esc_html_e('Nickname', 'gags-plugin'); ?></span>
					<input type="text" name="nick-name" id="edit_nickname" value="<?php the_author_meta( 'nickname', $current_user->ID ); ?>" placeholder="<?php esc_html_e('Nickname', 'gags-plugin'); ?>" />
				</label>
			</div>
			<div class="input-wrapper">
				<label>
					<span><?php esc_html_e('Email', 'gags-plugin'); ?></span>
					<input type="email" name="email" id="edit_email" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" placeholder="<?php esc_html_e('Email (Optional)', 'gags-plugin'); ?>" />
				</label>
			</div>

			<div class="input-wrapper">
				<label>
					<span><?php esc_html_e('User profile', 'gags-plugin'); ?></span>
					<div class="current-avatar">
						<?php echo gags_display_avatar(); ?>
					</div>
					<p><?php echo wp_kses( __('Go to <a href="https://gravatar.com" target="_blank">Gravatar</a> to change your profile picture.', 'gags'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ); ?></p>
				</label>
			</div>

			<div class="input-wrapper">
				<label>
					<span><?php esc_html_e('Display name', 'gags-plugin'); ?></span>
					<select name="display_name" id="display_name"><br/>
						<?php
							$warrior_public_display = array();
							$warrior_public_display['display_nickname']  = esc_attr( $current_user->nickname );
							$warrior_public_display['display_username']  = esc_attr( $current_user->user_login );
				 
							if ( !empty($current_user->first_name) )
								$warrior_public_display['display_firstname'] = esc_attr( $current_user->first_name );
				 
							if ( !empty($current_user->last_name) )
								$warrior_public_display['display_lastname'] = esc_attr( $current_user->last_name );
				 
							if ( !empty($current_user->first_name) && !empty($current_user->last_name) ) {
								$warrior_public_display['display_firstlast'] = esc_attr( $current_user->first_name ) . ' ' . esc_attr( $current_user->last_name );
								$warrior_public_display['display_lastfirst'] = esc_attr( $current_user->last_name ) . ' ' . esc_attr( $current_user->first_name );
							}
				 
							if ( ! in_array( $current_user->display_name, $warrior_public_display ) ) // Only add this if it isn't duplicated elsewhere
								$warrior_public_display = array( 'display_displayname' => $current_user->display_name ) + $warrior_public_display;
				 
							$warrior_public_display = array_map( 'trim', $warrior_public_display );
							$warrior_public_display = array_unique( $warrior_public_display );
				 
							foreach ( $warrior_public_display as $id => $item ) {
						?>
							<option <?php selected( $current_user->display_name, $item ); ?>><?php echo esc_attr( $item ); ?></option>
						<?php
							}
						?>
					</select>
				</label>
			</div>
			<div class="input-wrapper">
				<label>
					<span><?php esc_html_e('Short description', 'gags-plugin'); ?></span>
					<textarea name="description" rows="8" placeholder="<?php esc_html_e('Short description', 'gags-plugin'); ?>"><?php the_author_meta( 'description', $current_user->ID ); ?></textarea>
				</label>
			</div>

			<div class="input-wrapper submit">
	            <?php wp_nonce_field( 'update-user_'. $current_user->ID ) ?>
	            <input name="action" type="hidden" id="action" value="update-user" />
				<button name="updateuser" id="updateuser" type="submit" class="button large-button"><?php esc_html_e('Update Profile', 'gags-plugin'); ?></button>
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