<?php
/**
 * The template for displaying posts in the Standard post format.
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
?>

<div class="post-lists">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
	
		<h3 class="post-title"><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php echo wp_trim_words( get_the_title(), 20, '...' ); ?></a></h3>
			
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="thumbnail">
				<a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_post_thumbnail( 'gags-post-thumbnail', array( 'alt' => get_the_title(), 'title' => get_the_title() ) ); ?>
				</a>
			</div>
		<?php endif; ?>
		
		<div class="entry-content">
			<?php the_excerpt(); ?>
		</div>

		<div class="article-footer">
			<div class="vote-wrap">
				<a href="<?php the_permalink(); ?>"><i class="fa fa-comment"></i> <?php comments_number( '0', '1', '%' ); ?></a>
			</div>

			<?php echo gags_sharing(); // display post sharing button ?>
		</div>
		<?php echo gags_post_meta(); // display post meta ?>
		
	</article>
</div>