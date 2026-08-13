<?php
/**
 * /llms.txt endpoint: a plain-text map of the site for AI answer engines.
 *
 * @package LoomVector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the rewrite rule.
 */
function lv_llms_rewrite() {
	add_rewrite_rule( '^llms\.txt$', 'index.php?lv_llms=1', 'top' );
}
add_action( 'init', 'lv_llms_rewrite' );

/**
 * Register the query var.
 *
 * @param array $vars Query vars.
 * @return array
 */
function lv_llms_query_var( $vars ) {
	$vars[] = 'lv_llms';
	return $vars;
}
add_filter( 'query_vars', 'lv_llms_query_var' );

/**
 * Flush rules once after activation.
 */
function lv_llms_flush() {
	lv_llms_rewrite();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'lv_llms_flush' );

/**
 * Render llms.txt.
 */
function lv_llms_render() {
	if ( ! get_query_var( 'lv_llms' ) ) {
		return;
	}

	nocache_headers();
	header( 'Content-Type: text/plain; charset=utf-8' );

	$lines   = array();
	$lines[] = '# ' . get_bloginfo( 'name' );
	$lines[] = '';
	$lines[] = '> ' . get_bloginfo( 'description' );
	$lines[] = '';
	$lines[] = '## Services';

	$services = get_posts( array(
		'post_type'      => 'lv_service',
		'posts_per_page' => 50,
		'post_status'    => 'publish',
	) );

	if ( $services ) {
		foreach ( $services as $service ) {
			$lines[] = sprintf(
				'- [%s](%s): %s',
				wp_strip_all_tags( $service->post_title ),
				get_permalink( $service ),
				wp_trim_words( wp_strip_all_tags( strip_shortcodes( $service->post_content ) ), 24, '' )
			);
		}
	} else {
		foreach ( lv_default_services() as $service ) {
			$lines[] = '- ' . $service['title'] . ': ' . $service['desc'];
		}
	}

	$lines[] = '';
	$lines[] = '## Pages';
	$pages   = get_pages( array( 'sort_column' => 'menu_order,post_title', 'number' => 40 ) );
	foreach ( $pages as $page ) {
		$lines[] = sprintf( '- [%s](%s)', wp_strip_all_tags( $page->post_title ), get_permalink( $page ) );
	}

	$lines[] = '';
	$lines[] = '## Latest writing';
	$posts   = get_posts( array( 'posts_per_page' => 15, 'post_status' => 'publish' ) );
	foreach ( $posts as $post ) {
		$lines[] = sprintf( '- [%s](%s)', wp_strip_all_tags( $post->post_title ), get_permalink( $post ) );
	}

	$lines[] = '';
	$lines[] = '## Contact';
	if ( lv_opt( 'lv_email' ) ) {
		$lines[] = '- Email: ' . lv_opt( 'lv_email' );
	}
	if ( lv_opt( 'lv_phone' ) ) {
		$lines[] = '- Phone: ' . lv_opt( 'lv_phone' );
	}
	$lines[] = '- Sitemap: ' . home_url( '/wp-sitemap.xml' );

	echo implode( "\n", array_map( 'wp_strip_all_tags', $lines ) ) . "\n";
	exit;
}
add_action( 'template_redirect', 'lv_llms_render' );
