<?php
/**
* The main template file for taxonomy stories category
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
		<header class="section-title">
            <h4 class="widget-title"><?php echo gags_title(); ?></h4>
        </header>
		<?php
			// The loop
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_gags_template_part( 'content-gag' ); // get content template
				}
				get_gags_template_part( 'includes/pagination' ); // display pagination section
			} else { 
		?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'post hentry clearfix' ); ?>>
                <div class="alert alert-warning">
                    <?php esc_html_e( "You don't have submitted links.", "gags-plugin" ); ?>
                </div>
            </article>
		<?php
			} 
			wp_reset_postdata();
		?>
		</div>

	<?php get_sidebar(); ?>
	</div>
</div>
<!-- End : Main Content -->
		
<?php get_footer(); ?>