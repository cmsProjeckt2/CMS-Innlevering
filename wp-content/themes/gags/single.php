<?php
/**
 * The template for displaying single posts
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
			<?php
			// The loop
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_template_part( 'content-single' ); // get single content template
					comments_template( '', true ); // display comments
					gags_set_post_views(get_the_ID());
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