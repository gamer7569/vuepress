<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package VuePress
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class( 'w-100 athelas bg-white' ); ?>>
<div id="page" class="site">
	<a class="clip" href="#main"><?php esc_html_e( 'Skip to content', 'vuepress' ); ?></a>

	<header id="masthead" class="athelas" role="banner">
		<div class="site-branding vh-10 dt w-100 tc bg-washed-red black-80">
			<h1 class="site-title"><a class="f1 f-headline-l fw1 i black-80 link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation" role="navigation" aria-live="assertive">
			<div class="menu-toggle">
				<button aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'vuepress' ); ?></button>
			</div>
			<?php
			wp_nav_menu( array(
				'container'      => false,
				'depth'          => 1,
				'theme_location' => 'primary',
				'menu_class'     => 'list bt bb tc mw9 center mt4',
				'menu_id'        => 'primary-menu',
				'fallback_cb'    => '__return_false',
			));
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
