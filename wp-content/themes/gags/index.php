<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
			<header class="section-title">
	            <h4 class="widget-title"><?php echo gags_archive_title(); ?></h4>
	        </header>
			
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