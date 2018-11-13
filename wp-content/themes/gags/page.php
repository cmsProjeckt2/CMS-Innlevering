<?php 
/**
 * The template for displaying comments
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
					$content = get_the_content();

					if ( has_shortcode( $content, 'gags_recent_posts' ) || has_shortcode( $content, 'gags_popular_posts' ) || has_shortcode( $content, 'gags_trending_posts' ) || has_shortcode( $content, 'gags_dashboard' ) || has_shortcode( $content, 'gags_edit_password' ) || has_shortcode( $content, 'gags_edit_profile' ) || has_shortcode( $content, 'gags_login' ) || has_shortcode( $content, 'gags_register' ) || has_shortcode( $content, 'gags_lost_password' ) || has_shortcode( $content, 'gags_edit_password' ) ) {

						get_template_part( 'content-gags' ); // get content template
					} else {
						get_template_part( 'content-page' ); // get content template
					}
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