<?php
/**
 * Plugin Name: Loom Vector Core
 * Plugin URI: https://loomvector.com
 * Description: Companion plugin for Loom Vector: Services / Case Studies / Testimonials post types, FAQ manager, lead capture form with UTM tracking and CSV export, and reusable shortcodes.
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: Loom Vector
 * Author URI: https://loomvector.com
 * License: GPL-2.0-or-later
 * Text Domain: loom-vector-core
 *
 * @package LoomVectorCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LV_CORE_VERSION', '1.0.0' );
define( 'LV_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'LV_CORE_URL', plugin_dir_url( __FILE__ ) );

require_once LV_CORE_DIR . 'includes/post-types.php';
require_once LV_CORE_DIR . 'includes/faq.php';
require_once LV_CORE_DIR . 'includes/forms.php';
require_once LV_CORE_DIR . 'includes/leads.php';
require_once LV_CORE_DIR . 'includes/shortcodes.php';
require_once LV_CORE_DIR . 'includes/settings.php';

/**
 * Marker used by the theme to detect the plugin.
 *
 * @return bool
 */
function lv_core_bootstrap() {
	return true;
}

/**
 * Load translations.
 */
function lv_core_load_textdomain() {
	load_plugin_textdomain( 'loom-vector-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'lv_core_load_textdomain' );

/**
 * Activation: register types then flush rewrites.
 */
function lv_core_activate() {
	lv_core_register_post_types();
	lv_core_register_taxonomies();
	lv_core_create_leads_table();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'lv_core_activate' );

/**
 * Deactivation.
 */
function lv_core_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'lv_core_deactivate' );

/**
 * Front-end styles for plugin output when the theme does not provide them.
 */
function lv_core_assets() {
	if ( ! wp_style_is( 'loom-vector', 'enqueued' ) ) {
		wp_enqueue_style( 'loom-vector-core', LV_CORE_URL . 'assets/core.css', array(), LV_CORE_VERSION );
	}
}
add_action( 'wp_enqueue_scripts', 'lv_core_assets' );

/**
 * Optional tracking snippets from the settings screen.
 */
function lv_core_tracking_head() {
	$snippet = get_option( 'lv_core_tracking_head', '' );
	if ( $snippet ) {
		echo wp_kses( $snippet, array(
			'script' => array( 'src' => array(), 'async' => array(), 'defer' => array(), 'id' => array(), 'type' => array() ),
			'noscript' => array(),
		) );
	}
}
add_action( 'wp_head', 'lv_core_tracking_head', 99 );
