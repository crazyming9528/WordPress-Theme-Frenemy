<?php
/**
 * Twenty Nineteen functions and definitions
 *
 * @link       https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package    WordPress
 * @subpackage Twenty_Nineteen
 * @since      1.0.0
 */

if ( ! function_exists( 'frenemy_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function frenemy_setup() {
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
		set_post_thumbnail_size( 1568, 9999 );


		// Adding image sizes. https://developer.wordpress.org/reference/functions/add_image_size/
		// 列表页特色图展示
		add_image_size( 'frenemy-post-list-images', 460, 460, true );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-top' => __( '头部菜单' )
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'frenemy_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width Content width.
 */
function frenemy_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'frenemy_content_width', 640 );
}

add_action( 'after_setup_theme', 'frenemy_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function frenemy_scripts() {
	wp_enqueue_style( 'frenemy-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ), 'all' );
	wp_enqueue_style( 'frenemy-bootstrap', get_template_directory_uri() . '/assets/bootstrap/bootstrap.min.css', array(), wp_get_theme()->get( 'Version' ), 'all' );
	wp_enqueue_style( 'frenemy-fonts', get_template_directory_uri() . '/assets/fonts/css/font-awesome.min.css', array(), wp_get_theme()->get( 'Version' ), 'all' );
	wp_enqueue_style( 'frenemy-app', get_template_directory_uri() . '/assets/app/app.min.css', array(), wp_get_theme()->get( 'Version' ), 'all' );
	wp_enqueue_style( 'frenemy-other', get_template_directory_uri() . '/assets/app/style.css', array(), wp_get_theme()->get( 'Version' ), 'all' );

	wp_enqueue_script( 'frenemy-jquery', get_theme_file_uri( '/assets/jquery/jquery.min.js' ), array(), wp_get_theme()->get( 'Version' ), true );
	wp_enqueue_script( 'frenemy-bootstrap', get_theme_file_uri( '/assets/bootstrap/bootstrap.min.js' ), array(), wp_get_theme()->get( 'Version' ), true );
	wp_enqueue_script( 'frenemy-pivot', get_theme_file_uri( '/assets/pivot/pivot.min.js' ), array(), wp_get_theme()->get( 'Version' ), true );
	wp_enqueue_script( 'frenemy-app', get_theme_file_uri( '/assets/app/app.min.js' ), array(), wp_get_theme()->get( 'Version' ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_deregister_script( 'wp-mediaelement' );
	wp_deregister_style( 'wp-mediaelement' );
	wp_deregister_style( 'wp-block-library' );
}

add_action( 'wp_enqueue_scripts', 'frenemy_scripts' );

/**
 * Custom Comment Walker template.
 */
require get_template_directory() . '/classes/class-frenemy-walker-comment.php';

/**
 * Custom Nav Walker template。
 */
require get_template_directory() . '/classes/class-frenemy-bootstrap-navwalker.php';

/**
 * Enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom template tags for the theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer-basic.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer-seo.php';

/**
 * Optimization
 */
require get_template_directory() . '/inc/template-optimization.php';
