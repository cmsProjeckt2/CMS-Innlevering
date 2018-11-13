<?php
/**
* The main template file for single stories page
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/templates
*/
?>

<?php
$get_notif = isset($_GET['success']) ? $_GET['success'] : '';

if( is_single() && $get_notif == 1 ) {
	echo '<div class="alert alert-success">';
	wp_kses( _e( '<strong>Horray!</strong> Your gags has been submitted.', 'gags-plugin' ), array( 'strong' => array() ) );
	echo '</div>';
}
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post single-post' ); ?>>
		<h1 class="post-title"><?php the_title(); ?></h1>

		<div class="clearfix"></div>

		<?php
		if ( is_user_logged_in() ) :
			// Get external status
			$gags_video_embed_url = get_post_meta( get_the_ID(), '_gag_video_embed_url', true );
			if ( $gags_video_embed_url ) :
				echo '<div class="thumbnail fluid-vids">';
				echo wp_oembed_get( esc_url( $gags_video_embed_url ) ); 
				echo '</div>';
			elseif ( has_post_thumbnail() ) :
			
			$get_img_ids = get_post_thumbnail_id(get_the_ID());
		    $type =  get_post_mime_type( $get_img_ids );
		    $mime_type = explode('/', $type);
		    $type = '.'.$mime_type['1'];
		?>
			<?php if( $type == ".gif" ) : ?>
				<div class="thumbnail gifplayer">
					<?php
						$image_attributes_gif = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
					?>
					<?php the_post_thumbnail( 'gags-gif-thumbnail', array( 'data-gif' => $image_attributes_gif[0], 'title' => get_the_title() ) ); ?>
				</div>
			<?php else : ?>
				<div class="thumbnail">
					<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title(); ?>">
						<?php the_post_thumbnail( 'gags-post-thumbnail', array( 'alt' => get_the_title(), 'title' => get_the_title() ) ); ?>
					</a>
				</div>
			<?php endif; ?>
			<?php else: ?>
			<div class="thumbnail">
				<?php $thumb_image = "http://placehold.it/622x337/?text=".esc_html__('No Thumbnail', 'gags-plugin'); ?>
				<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title(); ?>">
					<img src="<?php echo esc_url( $thumb_image ); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
				</a>
			</div>
		<?php 
			endif;
		else :
			$gags_get_nfsw = get_post_meta( get_the_ID(), '_gag_nfsw', true );
			if($gags_get_nfsw == 'on'){
				$thumb_image = "http://placehold.it/622x337/?text=".esc_html__('NSFW', 'gags-plugin');
				echo '<div class="thumbnail">';
					echo '<a href="'.esc_url( get_permalink() ).'" title="'.get_the_title().'" alt="'.get_the_title().'">';
						echo '<img src="'. esc_url ( $thumb_image ) .'" alt="'.get_the_title().'" title="'.get_the_title().'">';
					echo '</a>';
				echo '</div>';
			} else {
				
			// Get external status
			$gags_video_embed_url = get_post_meta( get_the_ID(), '_gag_video_embed_url', true );
			if ( $gags_video_embed_url ) :
				echo '<div class="thumbnail fluid-vids">';
				echo wp_oembed_get( esc_url( $gags_video_embed_url ) ); 
				echo '</div>';
			elseif ( has_post_thumbnail() ) :
			
			$get_img_ids = get_post_thumbnail_id(get_the_ID());
		    $type =  get_post_mime_type( $get_img_ids );
		    $mime_type = explode('/', $type);
		    $type = '.'.$mime_type['1'];
		?>
			<?php if( $type == ".gif" ) : ?>
				<div class="thumbnail gifplayer">
					<?php
						$image_attributes_gif = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
					?>
					<?php the_post_thumbnail( 'gags-gif-thumbnail', array( 'data-gif' => $image_attributes_gif[0], 'title' => get_the_title() ) ); ?>
				</div>
			<?php else : ?>
				<div class="thumbnail">
					<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title(); ?>">
						<?php the_post_thumbnail( 'gags-post-thumbnail', array( 'alt' => get_the_title(), 'title' => get_the_title() ) ); ?>
					</a>
				</div>
			<?php endif; ?>
		<?php else: ?>
			<div class="thumbnail">
				<?php $thumb_image = "http://placehold.it/622x337/?text=".esc_html__('No Thumbnail', 'gags-plugin'); ?>
				<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title(); ?>">
					<img src="<?php echo esc_url ( $thumb_image ); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
				</a>
			</div>
		<?php 
			endif;	
			}
		endif;
		?>

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

		<div class="clearfix"></div>

		<div class="entry-content">
			<?php
			the_content();
			
			// Display post pagination
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'gags-plugin' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
			?>
		</div>

		<div class="tags">
			<?php
			$gag_tag_terms = wp_get_object_terms( get_the_ID(),  'gag_tag' );
			if ( ! empty( $gag_tag_terms ) ) {
				if ( ! is_wp_error( $gag_tag_terms ) ) {
						echo '<span><i class="icon icon-tags"></i> '. esc_html__( 'Tags : ', 'gags-plugin' ) .'</span>';
						foreach( $gag_tag_terms as $term ) {
							echo '<a href="' . get_term_link( $term->slug, 'gag_tag' ) . '">' . esc_html( $term->name ) . '</a>'; 
						}
				}
			}
	        ?>
		</div>
	</article>