<?php
/**
 * The template for displaying posts in the Page post format.
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
?>

<div class="post-lists">
	<?php $content = get_the_content(); ?>
    
	<div class="entry-content <?php if ( has_shortcode( $content, 'gags_recent_posts' ) || has_shortcode( $content, 'gags_popular_posts' ) || has_shortcode( $content, 'gags_trending_posts' )) { echo 'no-page-title'; } ?>">
		
		<h3 class="post-title"><?php the_title(); ?></h3>
		
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
</div>