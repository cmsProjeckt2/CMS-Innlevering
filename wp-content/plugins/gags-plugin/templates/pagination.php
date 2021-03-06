<?php
/**
* The main template file for pagination
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/templates
*/
?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<!-- Start: Pagination -->
	<?php
	// Check if WP Page-Navi plugin is installed and activated
	if( function_exists( 'wp_pagenavi' ) ) {
		echo '<div class="pagination">';
			wp_pagenavi();
		echo '</div>';
	} else {
		echo '<div class="pagination default">';
			previous_posts_link( '&#8592; '. esc_html__( 'Previous', 'gags-plugin' ) );
			next_posts_link( esc_html__( 'Next', 'gags-plugin' ) .' &#8594;' );
		echo '</div>';	
	}
	?>
<!-- End: Pagination -->
<?php endif; ?>