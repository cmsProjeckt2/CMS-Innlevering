<?php
/**
* The main template file for search page
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/templates
*/
?>
<?php get_header(); ?>

<!-- Start : Main Content -->
<div id="main">
	<div class="container clearfix">
		<div id="maincontent">	
			<?php
			// The loop
			if ( have_posts() ) :
				while ( have_posts() ) {
					the_post();
					get_gags_template_part( 'content-gag' ); // get content template
				}
				get_gags_template_part( 'pagination' ); // display pagination section
			?>
			<?php else : ?> 
				<article <?php post_class( 'hentry post' ); ?>>
	  				<h1 class="post-title"><?php esc_html_e( 'Oops! That page can\'t be found.', 'gags-plugin' ); ?></h1>
	            	<div class="entry-content">
	                	<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'gags-plugin' ); ?></p>
	                    <?php get_search_form(); ?>
	                </div>
	            </article>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>

		<?php get_sidebar(); ?>
	</div>
</div>
<!-- End : Main Content -->
		
<?php get_footer(); ?>