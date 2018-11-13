<?php
/**
 * The template for displaying posts in the search results.
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
					get_template_part( 'content' ); // get content template
				}
				get_template_part( 'includes/pagination' ); // display pagination section
			} else { 
				get_template_part( 'content', 'none' );
			} 
			wp_reset_postdata();
			?>
		</div>

	<?php get_sidebar(); ?>
	</div>
</div>
<!-- End : Main Content -->
		
<?php get_footer(); ?>