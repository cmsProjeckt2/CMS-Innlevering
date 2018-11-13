<?php
/**
 * The template for displaying search form.
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
?>

<!-- Start : Search Form -->
<div class="search-widget">
	<form class="block-form float-label search-form" method="get" action="<?php echo esc_url( home_url('/') ); ?>">
		<input type="text" name="s" value="<?php esc_attr( the_search_query() ); ?>" placeholder="<?php esc_html_e( 'Type and hit enter...', 'gags' ); ?>">
		<button type="submit" onclick="jQuery('#search-form').submit()"><i class="fa fa-search"></i></button>
	</form>
</div>
<!-- End : Search Form -->