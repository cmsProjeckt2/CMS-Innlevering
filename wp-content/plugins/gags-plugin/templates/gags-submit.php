<?php 
/**
* The main template file for submit story shortcode
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/templates
*/

ob_start();
?>

<?php if ( is_user_logged_in() ) : ?>

<div class="submit-form">
    <div class="form-tab">
        <div class="form-tab-header tab-header clearfix">
        	<?php $get_submit_type = isset($_GET['type']) ? esc_attr( $_GET['type'] ) : ''; ?>
            <a href="<?php the_permalink(); ?>?type=image" data-content="#type-image" class="tabs-nav <?php if ( $get_submit_type == "image" ) echo "active"; elseif (empty($get_submit_type) ) echo "active"; ?>"><i class="fa fa-image"></i><?php esc_html_e('Image', 'gags-plugin'); ?></a>
            <a href="<?php the_permalink(); ?>?type=video" data-content="#type-video" class="tabs-nav <?php if ( $get_submit_type == "video" ) echo "active"; ?>"><i class="fa fa-video-camera"></i><?php esc_html_e('Video', 'gags-plugin'); ?></a>
        </div>

        <div class="tab-content-wrapper">
            <div id="type-image" class="tab-content submit-image-form" style="<?php if ( $get_submit_type == "image" ) echo "display:block;"; elseif (empty($get_submit_type) ) echo "display:block;"; ?>">
            	<div id="status">
					<?php
					if( function_exists( 'gags_submit_post_image' ) ) {
						echo gags_submit_post_image(); // set function submit image
					}
					?>
				</div>

	            <form action="" method="post" id="submit-image-gags" enctype="multipart/form-data">
	                <div class="input-wrapper">
	                    <input type="text" id="post-title" name="gag_image_post_title" value="<?php if (isset($_POST['gag_image_post_title'])) echo $_POST['gag_image_post_title']; ?>" placeholder="<?php esc_html_e('Title', 'gags-plugin'); ?>" required />
	                </div>

	                <div class="input-wrapper">
						<?php
						$get_gag_category = array (
					        'show_option_all'    => '',
					        'show_option_none' => esc_html__( 'Select a Category', 'gags-plugin' ),
					        'orderby'            => 'ID', 
					        'order'              => 'ASC',
					        'show_count'         => 0,
					        'hide_empty'         => 0, 
					        'child_of'           => 0,
					        'exclude'            => '',
					        'echo'               => 1,
					        'selected'           => 0,
					        'hierarchical' 		 => true,
					        'name'               => 'gag_image_post_category',
					        'id'                 => '',
					        'class'              => 'gag-category',
					        'depth'              => 3,
					        'tab_index'          => 0,
					        'taxonomy'           => 'gag_category',
					        'hide_if_empty'      => false
				    	);
				    	?>
				    	<?php wp_dropdown_categories( $get_gag_category ); ?>
	                </div>

	                <div class="input-wrapper">
	                	<textarea name="gags_image_post_content" id="post-desc" rows="8" placeholder="<?php esc_html_e('Description', 'gags-plugin'); ?>"  ><?php if (isset($_POST['gags_image_post_content'])) echo $_POST['gags_image_post_content']; ?></textarea>
	                </div>

	                <div class="input-wrapper">
						<input type="checkbox" id="gag-img-nfsw" name="_gag_nfsw" <?php if( isset($_POST['_gag_nfsw']) == true ) { ?> checked value="on"<?php } ?> /> <label for="gag-img-nfsw"><?php esc_html_e("NSFW - (Not Safe For Work)","gags-plugin"); ?></label>
					</div>

	                <div class="input-wrapper">
						<input type="text" id="gag-tag-image" name="gags_image_post_tag" value="<?php if (isset($_POST['gags_image_post_tag'])) echo $_POST['gags_image_post_tag']; ?>" placeholder="<?php esc_html__('Tags', 'gags-plugin'); ?>"><br /><small><i><?php esc_html_e( 'Separate each tags with coma (,)', 'gags-plugin' ) ?></i></small>
					</div>
					
	                <div class="input-wrapper input-50 input-submit-file">
	                    <input type="file" id="gag-featured-image" name="gag_featured_image" value="<?php if (isset($_POST['gag_featured_image'])) echo $_POST['gag_featured_image']; ?>"/>
	                    <input type="text" id="gag-image-url" name="_gag_image_url" value="<?php if (isset($_POST['_gag_image_url'])) echo $_POST['_gag_image_url']; ?>" placeholder="<?php esc_html_e('Image Url', 'gags_plugin'); ?>"/>

						<div class="clearfix"></div>
	                </div>
	                <div class="input-wrapper submit">
	                	<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
	                	<button type="submit" name="submit" class="button large-button"><?php esc_html_e('Submit', 'gags-plugin'); ?></button>
	                	<div class="loading"></div>
	                </div>
	            </form>
            </div>

            <div id="type-video" class="tab-content submit-video-form" style="<?php if ( $get_submit_type == "video" ) echo "display:block;"; ?>">
            	<div id="status">
					<?php
					if( function_exists( 'gags_submit_post_video' ) ) {
						echo gags_submit_post_video(); // set function submit video
					}
					?>
				</div>

	            <form action="" method="post" id="submit-video-gags" enctype="multipart/form-data">
	            	<div class="input-wrapper">
	                    <input type="text" id="gag-video-url" name="_gag_video_embed_url" value="<?php if (isset($_POST['_gag_video_embed_url'])) echo $_POST['_gag_video_embed_url']; ?>" placeholder="<?php esc_html_e('Video Embed Url', 'gags-plugin'); ?>" />
	                    <br><br><small><i><?php esc_html_e( 'Only support video embeded from YouTube, Vimeo, Hulu, DailyMotion, FunnyOrDie, Flickr, Tumblr & Vine', 'gags-plugin' ) ?></i></small>
	                    
						<div class="clearfix"></div>
	                </div>
	                
	                <div class="input-wrapper">
	                    <input type="text" id="post-title" name="gag_video_post_title" value="<?php if (isset($_POST['gag_video_post_title'])) echo $_POST['gag_video_post_title']; ?>" placeholder="<?php esc_html_e('Title', 'gags-plugin'); ?>" required/>
	                </div>

	                <div class="input-wrapper">
	                	<?php
	                	$get_gag_category = array (
					        'show_option_all'    => '',
					        'show_option_none' 	 => esc_html__( 'Select a Category', 'gags-plugin' ),
					        'orderby'            => 'ID', 
					        'order'              => 'ASC',
					        'show_count'         => 0,
					        'hide_empty'         => 0, 
					        'child_of'           => 0,
					        'exclude'            => '',
					        'echo'               => 1,
					        'selected'           => 0,
					        'hierarchical' 		 => true,
					        'name'               => 'gag_video_post_category',
					        'id'                 => '',
					        'class'              => 'gag-category',
					        'depth'              => 3,
					        'tab_index'          => 0,
					        'taxonomy'           => 'gag_category',
					        'hide_if_empty'      => false
				    	);
				    	?>
				    	
				    	<?php wp_dropdown_categories( $get_gag_category ); ?>
	                </div>

	                <div class="input-wrapper">
	                	<textarea name="gags_video_post_content" id="post-desc" rows="8" placeholder="<?php esc_html_e('Description', 'gags-plugin'); ?>"  ><?php if (isset($_POST['gags_video_post_content'])) echo $_POST['gags_video_post_content']; ?></textarea>
	                </div>

	                <div class="input-wrapper">
						<input type="checkbox" id="gag-vid-nfsw" name="_gag_nfsw" <?php if( isset($_POST['_gag_nfsw']) == true ) { ?> checked value="on"<?php } ?> /> <label for="gag-vid-nfsw"><?php esc_html_e("NSFW - (Not Safe For Work)","gags-plugin"); ?></label>
					</div>

	                <div class="input-wrapper">
						<input type="text" id="gag-tag-video" name="gags_video_post_tag" value="<?php if (isset($_POST['gags_video_post_tag'])) echo $_POST['gags_video_post_tag']; ?>" placeholder="<?php esc_html__('Tags', 'gags-plugin'); ?>"><br /><small><i><?php esc_html_e( 'Separate each tags with coma (,)', 'gags-plugin' ) ?></i></small></label>
					</div>

	                <div class="input-wrapper submit">
	                	<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
	                	<button type="submit" name="submit" class="button large-button"><?php esc_html_e('Submit', 'gags-plugin'); ?></button>
	                	<div class="loading"></div>
	                </div>
	            </form>
            </div>
        </div>

    </div>
</div>

<?php else : ?>
	<article class="post hentry clearfix">
		<div class="entrycontent clearfix">
			<div class="alert alert-danger">
	        	<?php esc_html_e( 'You must be logged in to submit new gag.', 'gag-plugin' ); ?>
	        </div>
		</div>
	</article>
<?php endif; ?>