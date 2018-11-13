<?php
/**
* The main template file for content stories page
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/templates
*/
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
		<h3 class="post-title"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title(); ?>"><?php echo wp_trim_words( get_the_title(), 20, '...' ); ?></a></h3>
		<?php
			// Get external status
			$gags_video_embed_url = get_post_meta( get_the_ID(), '_gag_video_embed_url', true );
			if ( $gags_video_embed_url ) :
				$gags_get_nfsw = get_post_meta( get_the_ID(), '_gag_nfsw', true );
				if($gags_get_nfsw == 'on'){
					$thumb_image = "http://placehold.it/622x337/000000/FFFFFF?text=".esc_html__('NSFW', 'gags-plugin');
					echo '<div class="thumbnail">';
						echo '<a href="'.esc_url( get_permalink() ).'" title="'.get_the_title().'" alt="'.get_the_title().'">';
							echo '<img src="'. esc_url( $thumb_image ) .'" alt="'.get_the_title().'" title="'.get_the_title().'">';
						echo '</a>';
					echo '</div>';
				} else {
					if(has_post_thumbnail()){ 
			?>
						<div class="thumbnail">
							<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>">
								<?php the_post_thumbnail( 'gags-post-thumbnail', array( 'alt' => get_the_title(), 'title' => get_the_title() ) ); ?>
							</a>
						</div>
		<?php
					}else{
						$thumb_image = "http://placehold.it/622x337/?text=".esc_html__('No Thumbnail', 'gags-plugin');
						echo '<div class="thumbnail">';
							echo '<a href="'.esc_url( get_permalink() ).'" title="'.get_the_title().'" alt="'.get_the_title().'">';
								echo '<img src="'. esc_url( $thumb_image ) .'" alt="'.get_the_title().'" title="'.get_the_title().'">';
							echo '</a>';
						echo '</div>';
					}

				}
			elseif ( has_post_thumbnail() ) :
			
			$get_img_ids = get_post_thumbnail_id(get_the_ID());
		    $type =  get_post_mime_type( $get_img_ids );
		    $mime_type = explode('/', $type);
		    $type = '.'.$mime_type['1'];
		?>
			<?php if( $type == ".gif" ) : ?>
				<?php
					$gags_get_nfsw = get_post_meta( get_the_ID(), '_gag_nfsw', true );
					if($gags_get_nfsw == 'on'){
						$thumb_image = "http://placehold.it/622x337/000000/FFFFFF?text=".esc_html__('NSFW', 'gags-plugin');
						echo '<div class="thumbnail">';
							echo '<a href="'.esc_url( get_permalink() ).'" title="'.get_the_title().'" alt="'.get_the_title().'">';
								echo '<img src="'. esc_url( $thumb_image ).'" alt="'.get_the_title().'" title="'.get_the_title().'">';
							echo '</a>';
						echo '</div>';
					} else {
				?>
					<div class="thumbnail gifplayer">
						<?php
							$image_attributes_gif = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
						?>
						<?php the_post_thumbnail( 'gags-gif-thumbnail', array( 'data-gif' => $image_attributes_gif[0], 'title' => get_the_title() ) ); ?>
					</div>
				<?php } ?>
			<?php else : ?>
				<?php
					$gags_get_nfsw = get_post_meta( get_the_ID(), '_gag_nfsw', true );
					if($gags_get_nfsw == 'on'){
						$thumb_image = "http://placehold.it/622x337/000000/FFFFFF?text=".esc_html__('NSFW', 'gags-plugin');
						echo '<div class="thumbnail">';
							echo '<a href="'.esc_url( get_permalink() ).'" title="'.get_the_title().'" alt="'.get_the_title().'">';
								echo '<img src="'. esc_url( $thumb_image ) .'" alt="'.get_the_title().'" title="'.get_the_title().'">';
							echo '</a>';
						echo '</div>';
					} else {
				?>
					<?php
					$image_data = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), "gags-post-thumbnail" );
					$image_height = $image_data[2];
					if ($image_height > 800) {
					?>
					<div class="thumbnail large">
						<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>">
							<?php the_post_thumbnail( 'gags-post-thumbnail', array( 'alt' => get_the_title(), 'title' => get_the_title() ) ); ?>
						</a>
						<a class="view-full-post" href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>">
							<?php esc_html_e('View Full Post', 'gags-plugin'); ?>
						</a>
					</div>
					<?php } else { ?>
					<div class="thumbnail">
						<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>">
							<?php the_post_thumbnail( 'gags-post-thumbnail', array( 'alt' => get_the_title(), 'title' => get_the_title() ) ); ?>
						</a>
					</div>
					<?php } ?>
				<?php } ?>
			<?php endif; ?>
		<?php else: ?>
			<div class="thumbnail">
				<?php $thumb_image = "http://placehold.it/622x337/?text=".esc_html__('No Thumbnail', 'gags-plugin'); ?>
				<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>">
					<img src="<?php echo esc_url( $thumb_image ); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
				</a>
			</div>
		<?php endif; ?>
		
		<div class="article-footer">
			<div class="vote-wrap">
				<?php
				// display post like button
				echo gags_getPostLikeLink( get_the_ID() );
				?>

				<a class="comment-count" href="<?php the_permalink(); ?>"><i class="fa fa-comments"></i> <?php comments_number( esc_html__( '0 Comments', 'gags'), esc_html__( '1 Comments', 'gags'), esc_html__( '% Comments', 'gags') ); ?></a>
			</div>

			<?php echo gags_sharing(); // display post sharing button ?>
		</div>
		<?php echo gags_meta(); // display post meta ?>
	</article>