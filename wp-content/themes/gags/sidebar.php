<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
?>

<!-- START: #sidebar -->
<div id="sidebar">
	<?php
	if ( is_single() ) {
		// Load sidebar widgets
		if ( is_active_sidebar( 'gags-sidebar-detail' ) ) {
			dynamic_sidebar( 'gags-sidebar-detail' );
		}
	} else {
		// Load sidebar widgets
		if ( is_active_sidebar( 'gags-sidebar' ) ) {
			dynamic_sidebar( 'gags-sidebar' );
		}
	}
	?>
</div>