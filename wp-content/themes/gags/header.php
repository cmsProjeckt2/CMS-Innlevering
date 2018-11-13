<?php
/**
 * The template for displaying header part.
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<?php echo gags_android_header_color(); ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<!-- Start : Header -->
	<header id="masthead" class="with-bg">
		<div id="top-header" class="clearfix">
			<div id="logo">
				<?php
				// display site logo
				if (!has_custom_logo()) :
				?>
					<a href="<?php echo esc_url( home_url('/') ); ?>" title="<?php echo esc_attr(get_bloginfo('name')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
						<img src="<?php echo esc_url( get_template_directory_uri().'/images/logo.png'); ?>" width="30" height="30" alt="">
					</a>
				<?php
				elseif ( function_exists( 'the_custom_logo' ) ) :
					the_custom_logo();
				endif;
				?>
			</div>

			<?php 
			// Display main menu
			if ( has_nav_menu( 'gags-primary-navigation' ) ) : 
			?>

				<nav id="main-menu" class="site-navigation">
				<?php wp_nav_menu( array ( 'theme_location' => 'gags-primary-navigation', 'container' => null, 'menu_class' => 'main-menu', 'depth' => 3 ) ); ?>
				</nav>
				
				<nav id="user-menu" class="site-navigation">
					<?php
					if ( is_user_logged_in() ) : 
						$gags_submit_pages = get_option('gags_plugin_page_setting');
						if ($gags_submit_pages['gags_submit_page'] != '') : 
					?>
						<a href="<?php echo esc_url( $gags_submit_pages['gags_submit_page'] ); ?>" class="btn upload-btn"><?php esc_html_e('Upload', 'gags'); ?></a>
					<?php endif; endif; ?>
					
					<ul class="visitor-menu">
						<?php 
						if ( ! is_user_logged_in() ) : 
							$gags_login_pages = get_option('gags_plugin_page_setting');
							if ($gags_login_pages['gags_login_page'] != '') : 
						?>
							<li class="login"><a href="<?php echo esc_url( $gags_login_pages['gags_login_page'] ); ?>"><?php esc_html_e( 'Login', 'gags' ); ?></a></li>
						<?php
							endif;
							$gags_register_pages = get_option('gags_plugin_page_setting');
							if ($gags_register_pages['gags_register_page'] != '') : 
						?>
							<li class="register"><a href="<?php echo esc_url( $gags_register_pages['gags_register_page'] ); ?>"><?php esc_html_e( 'Register', 'gags' ); ?></a></li>
						<?php 
							endif;
						endif;
						?>
					</ul>

					<?php if ( is_user_logged_in() ) :  ?>
						<div class="user-logged-in-menu" class="site-naviagtion">
							<div class="avatar">
							<?php
								// display wordpress avatar
								$user = wp_get_current_user();
								$user_id = $user->ID;

						        echo get_avatar( $user_id, 100 );  
							?>
							</div>
							
							<div class="user-menu-trigger"><i class="fa fa-chevron-down"></i></div>
							<?php
								// Display account menu
								if ( has_nav_menu( 'gags-account-navigation' ) ) :
									wp_nav_menu( array ( 'theme_location' => 'gags-account-navigation', 'container' => null, 'menu_class' => 'account-menu', 'depth' => 1 ) );
								endif;
							?>
						</div>
					<?php endif; ?>
					
					<div class="menu-holder">
						<div class="close-menu"><i class="fa fa-close"></i></div>
						<div class="menu-trigger"><i class="fa fa-bars"></i></div>
					</div>
				
					<div id="header-search-widget">
						<?php get_search_form(); ?>
						<div class="search-trigger"><i class="fa fa-search"></i></div>
					</div>				
				</nav>


				<?php 
			endif;
				if ( !is_user_logged_in() ) :
					$gags_submit_pages = get_option('gags_plugin_page_setting');
					if ($gags_submit_pages['gags_submit_page'] != '') : 
				?>
					<a href="<?php echo esc_url( $gags_submit_pages['gags_submit_page'] ); ?>" class="btn upload-btn"><?php esc_html_e('Upload', 'gags'); ?></a>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		
	</header>
	<!-- End : Header -->