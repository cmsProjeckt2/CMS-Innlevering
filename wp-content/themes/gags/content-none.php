<?php
/**
 * The template for displaying posts in the not found post format.
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
?>

<article <?php post_class( 'hentry post' ); ?>>
	<h1 class="post-title"><?php esc_html_e( 'Oops! That page can\'t be found.', 'gags' ); ?></h1>
	<div class="entry-content">
		<?php if (is_search()) : ?>
    	<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'gags' ); ?></p>
    	<?php else: ?>
    	<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'gags' ); ?></p>
    	<?php endif; ?>
        <?php get_search_form(); ?>
    </div>
</article>
