<?php
/**
 * Template Name: Blog
 * 
 * The blog template file.
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
				$args = array(
					'post_type'    => 'post',
					'post_status'  => 'publish',
					'order'		   => 'DESC',
					'paged' 	   => gags_query_paged()
				);

				$wp_query = new WP_Query();
				$wp_query->query( $args );
				if ( $wp_query->have_posts() ) {
					while( $wp_query->have_posts() ) { $wp_query->the_post();
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