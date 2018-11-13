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
<?php get_header(); ?>

<!-- Start : Main Content -->
<div id="main">
	<div class="container clearfix">
		<div id="maincontent">	
			<?php
			// The loop
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_gags_template_part( 'content-single-gag' ); // get single content template
					gags_after_content();

					gags_comments_option();
					if ( function_exists( 'gags_set_post_views' ) ) {
						gags_set_post_views(get_the_ID());
					}
				}
			} else {
				get_template_part( 'content', 'none' );
			}
		?>
		</div>

	<?php get_sidebar(); ?>
	</div>
</div>
<!-- End : Main Content -->
		
<?php get_footer(); ?>