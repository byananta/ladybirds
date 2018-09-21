<?php
/**
 * ladybirds functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ladybirds
 */

if ( ! function_exists( 'ladybirds_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ladybirds_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ladybirds, use a find and replace
		 * to change 'ladybirds' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ladybirds', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Main Menu', 'ladybirds' ),
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

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'ladybirds_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'ladybirds_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ladybirds_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'ladybirds_content_width', 640 );
}
add_action( 'after_setup_theme', 'ladybirds_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ladybirds_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ladybirds' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ladybirds' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="lb-widget-title"><h4 class="widget-title border-bottom">',
		'after_title'   => '</h4></div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Header Ad Section', 'ladybirds' ),
		'id'            => 'header-ad',
		'description'   => esc_html__( 'If you want to plaese your ad in header then add ad widget here.', 'ladybirds' ),
		'before_widget' => '<section id="%1$s" class="header-ad %2$s">',
		'after_widget'  => '</section>',
	));

	register_sidebar( array(
		'name'          => esc_html__( 'Home Page Full Width', 'ladybirds' ),
		'id'            => 'lb-home-page-full-width',
		'description'   => esc_html__( 'All the widgets wiil be shown in home page.', 'ladybirds' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="lb-widget-title"><h4 class="widget-title border-bottom">',
		'after_title'   => '</h4></div>',
	));

	register_sidebar( array(
		'name'          => esc_html__( 'Home Page Main', 'ladybirds' ),
		'id'            => 'lb-home-page-main',
		'description'   => esc_html__( 'All the widgets wiil be shown in home page.', 'ladybirds' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="lb-widget-title"><h4 class="widget-title border-bottom">',
		'after_title'   => '</h4></div>',
	));

	register_sidebar( array(
		'name'          => esc_html__( 'Home Page Sidebar', 'ladybirds' ),
		'id'            => 'lb-home-page-sidebar',
		'description'   => esc_html__( 'All the widgets wiil be shown in home page.', 'ladybirds' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="lb-widget-title"><h4 class="widget-title border-bottom">',
		'after_title'   => '</h4></div>',
	));
}
add_action( 'widgets_init', 'ladybirds_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ladybirds_scripts() {
	wp_enqueue_style( 'ladybirds-style', get_stylesheet_uri() );
	wp_enqueue_style( 'bootstrap-grid', get_template_directory_uri().'/css/bootstrap-grid.min.css' );
	wp_enqueue_style( 'fontawesome', get_template_directory_uri().'/css/line-awesome-font-awesome.min.css' );
	wp_enqueue_style( 'slick', get_template_directory_uri().'/css/slick.css' );
	wp_enqueue_style( 'theme-style', get_template_directory_uri().'/css/style.min.css' );

	wp_enqueue_script('jquery');
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array(), '20151215', true );
	wp_enqueue_script( 'ladybirds-mian', get_template_directory_uri() . '/js/main.js', array(), '20151215', true );

	wp_enqueue_script( 'ladybirds-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ladybirds_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * All Widgets.
 */
require get_template_directory() . '/inc/all-widgets.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
