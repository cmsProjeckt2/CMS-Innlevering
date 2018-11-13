<?php
/**
 * The template for displaying posts in the Standard post format.
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post single-post' ); ?>>
	<h3 class="post-title"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>

	<div class="article-footer">
		<div class="vote-wrap">
			<?php
				// display post like button
				// echo gags_getPostLikeLink( get_the_ID() );
			?>
			<a href="<?php the_permalink(); ?>"><i class="fa fa-comment"></i> <?php comments_number( '0', '1', '%' ); ?></a>
		</div>

		<?php echo gags_sharing(); // display post sharing button ?>
	</div>
	<?php echo gags_post_meta(); // display post meta ?>
	
	<div class="clearfix"></div>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="thumbnail">
			<a href="<?php echo esc_url( get_permalink()); ?>" title="<?php the_title(); ?>">
				<?php the_post_thumbnail( 'gags-post-thumbnail', array( 'alt' => get_the_title(), 'title' => get_the_title() ) ); ?>
			</a>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		the_content();
		
		// Display post pagination
		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'gags' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
		) );
		?>
	</div>

	<div class="tags">
		<?php the_tags( esc_html__( 'Tags : ', 'gags' ) .'', '', '' ); ?>
	</div>
</article>