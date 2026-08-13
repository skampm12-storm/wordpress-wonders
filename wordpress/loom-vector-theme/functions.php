<?php
/**
 * Loom Vector theme bootstrap.
 *
 * @package LoomVector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LV_THEME_VERSION', '1.0.0' );
define( 'LV_THEME_DIR', get_template_directory() );
define( 'LV_THEME_URI', get_template_directory_uri() );

require_once LV_THEME_DIR . '/inc/helpers.php';
require_once LV_THEME_DIR . '/inc/customizer.php';
require_once LV_THEME_DIR . '/inc/schema.php';
require_once LV_THEME_DIR . '/inc/seo.php';
require_once LV_THEME_DIR . '/inc/llms.php';
require_once LV_THEME_DIR . '/inc/template-tags.php';

/**
 * Theme supports.
 */
function lv_setup() {
	load_theme_textdomain( 'loom-vector', LV_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'custom-logo', array(
		'height'      => 64,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );

	register_nav_menus( array(
		'primary' => __( 'Primary menu', 'loom-vector' ),
		'footer'  => __( 'Footer menu', 'loom-vector' ),
	) );

	add_image_size( 'lv-card', 800, 600, true );
}
add_action( 'after_setup_theme', 'lv_setup' );

/**
 * Front-end assets.
 */
function lv_assets() {
	wp_enqueue_style( 'loom-vector', LV_THEME_URI . '/assets/css/theme.css', array(), LV_THEME_VERSION );
	wp_add_inline_style( 'loom-vector', lv_css_variables() );
	wp_enqueue_script( 'loom-vector', LV_THEME_URI . '/assets/js/theme.js', array(), LV_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'lv_assets' );

/**
 * Widget areas.
 */
function lv_widgets() {
	register_sidebar( array(
		'name'          => __( 'Footer widgets', 'loom-vector' ),
		'id'            => 'footer-1',
		'before_widget' => '<div class="lv-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="lv-widget__title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'lv_widgets' );

/**
 * Remove emoji cruft and jQuery migrate for a lighter front end.
 */
function lv_trim_head() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
}
add_action( 'init', 'lv_trim_head' );

/**
 * Lazy-load and decoding hints for content images.
 *
 * @param array $attr Attributes.
 * @return array
 */
function lv_image_attrs( $attr ) {
	if ( empty( $attr['loading'] ) ) {
		$attr['loading'] = 'lazy';
	}
	$attr['decoding'] = 'async';
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'lv_image_attrs' );

/**
 * Excerpt length / more.
 */
add_filter( 'excerpt_length', function () {
	return 28;
} );
add_filter( 'excerpt_more', function () {
	return '&hellip;';
} );

/**
 * Body classes.
 *
 * @param array $classes Classes.
 * @return array
 */
function lv_body_class( $classes ) {
	if ( is_page_template( 'template-landing.php' ) ) {
		$classes[] = 'lv-landing';
	}
	return $classes;
}
add_filter( 'body_class', 'lv_body_class' );
