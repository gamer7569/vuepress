<?php
/**
 * VuePress functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package VuePress
 */

/**
 * VuePress only works if the REST API is available
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_template_directory() . '/inc/compat-warnings.php';
	return;
}

if ( ! defined( 'VUEPRESS_VERSION' ) ) {
	define( 'VUEPRESS_VERSION', '1.0.0' );
}

if ( ! defined( 'VUEPRESS_APP' ) ) {
	define( 'VUEPRESS_APP', 'vuepress-vue' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function vuepress_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on VuePress, use a find and replace
	 * to change 'vuepress' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'vuepress', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'vuepress' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
}
add_action( 'after_setup_theme', 'vuepress_setup' );

/**
 * Add custom classes to 'primary' menu's <a> tags.
 *
 * @see Walker::start_el()
 *
 * @param string   $item_output Passed by reference. Used to append additional content.
 * @param WP_Post  $item   Menu item data object.
 * @param int      $depth  Depth of menu item. Used for padding.
 * @param stdClass $args   An object of wp_nav_menu() arguments.
 *
 * @link https://developer.wordpress.org/reference/hooks/walker_nav_menu_start_el/
 */
function vuepress_walker_nav_menu_start_el( $item_output, $item, $depth, $args ) {
	// Only affect the menu placed in the 'primary' wp_nav_bar() theme location.
	if ( 'primary' === $args->theme_location ) {
		$item_output = preg_replace( '/<a /', '<a class="f6 f5-l link bg-animate black-80 hover-bg-lightest-blue dib pa3 ph4-l" ', $item_output, 1 );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'vuepress_walker_nav_menu_start_el', 10, 4 );

/**
 * Add custom classes to 'primary' menu's <a> tags.
 *
 * @see Walker::start_el()
 *
 * @param array    $classes The CSS classes that are applied to the menu item's `<li>` element.
 * @param WP_Post  $item    The current menu item.
 * @param stdClass $args    An object of wp_nav_menu() arguments.
 *
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/nav_menu_css_class
 */
function vue_secondary_menu_classes( $classes, $item, $args ) {
	// Only affect the menu placed in the 'primary' wp_nav_bar() theme location.
	if ( 'primary' === $args->theme_location ) {
		// Make these items display: inline-block.
		$classes[] = 'dib';
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'vue_secondary_menu_classes', 10, 3 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function vuepress_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'vuepress' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'vuepress_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function vuepress_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'vuepress_content_width', 635 );
}
add_action( 'after_setup_theme', 'vuepress_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function vuepress_scripts() {
	wp_enqueue_style( 'vuepress-tachyons-style', 'https://cdnjs.cloudflare.com/ajax/libs/tachyons/4.7.4/tachyons.min.css', array(), VUEPRESS_VERSION );
	wp_enqueue_script( 'vuepress-vue', get_template_directory_uri() . '/assets/js/vendor.min.js', array( 'jquery', 'wp-a11y' ), VUEPRESS_VERSION, true );
	wp_enqueue_script( 'vuepress-app', get_template_directory_uri() . '/assets/js/main.min.js', array( 'vuepress-vue' ), VUEPRESS_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'vuepress_scripts' );
