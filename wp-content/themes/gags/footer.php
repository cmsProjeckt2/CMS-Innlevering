<?php
/**
 * The template for displaying footer section.
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
?>

<footer id="colofon">
	<div id="backtotop"><i class="fa fa-chevron-up"></i></div>
	<div class="container clearfix">
		<?php
		// Display footer menu
		if ( has_nav_menu( 'gags-footer-navigation' ) ) :
		?>
		<nav id="footer-menu">
			<?php wp_nav_menu( array ( 'theme_location' => 'gags-footer-navigation', 'container' => null, 'menu_class' => 'footer-menu', 'depth' => 1 ) ); ?>
		</nav>
		<?php endif; ?>

		<span class="copyright"><?php printf( __( '&copy; Copyright %2$s %1$s.', 'gags' ), get_bloginfo('name'), date_i18n('Y') ); ?></span>
		<?php esc_html_e( 'Theme by', 'gags' ); ?><a href="<?php esc_url( 'http://www.themewarrior.com' ); ?>" target="_blank"><?php esc_html_e(' ThemeWarrior', 'gags'); ?></a>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>