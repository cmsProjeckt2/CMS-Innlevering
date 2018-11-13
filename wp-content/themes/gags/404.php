<?php
/**
 * Template for displaying Page post type.
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
?>
<?php get_header(); ?>

<!-- Start : Main Content -->
<div id="main">
    <div class="container clearfix">
        <div id="maincontent">  
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'hentry post' ); ?>>
  				<h1 class="post-title"><?php esc_html_e( 'Oops! That page can\'t be found.', 'gags' ); ?></h1>
            	<div class="entry-content">
                	<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'gags' ); ?></p>
                    <?php get_search_form(); ?>
                </div>
            </article>
        </div>

    <?php get_sidebar(); ?>
    </div>
</div>
<!-- End : Main Content -->
        
<?php get_footer(); ?>