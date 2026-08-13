<?php
/**
 * Meta description, canonical and social tags.
 *
 * @package LoomVector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build a meta description for the current view.
 *
 * @return string
 */
function lv_meta_description() {
	if ( is_singular() ) {
		$post = get_post();
		if ( $post && ! empty( $post->post_excerpt ) ) {
			return wp_strip_all_tags( $post->post_excerpt );
		}
		if ( $post ) {
			return wp_trim_words( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ), 32, '…' );
		}
	}

	if ( is_post_type_archive() || is_category() || is_tax() ) {
		$desc = wp_strip_all_tags( get_the_archive_description() );
		if ( $desc ) {
			return $desc;
		}
	}

	return wp_strip_all_tags( get_bloginfo( 'description' ) );
}

/**
 * Output SEO / social meta.
 */
function lv_head_meta() {
	$desc  = lv_meta_description();
	$title = wp_get_document_title();
	$url   = is_singular() ? get_permalink() : home_url( add_query_arg( array() ) );

	echo '<meta name="description" content="' . esc_attr( $desc ) . '" />' . "\n";
	echo '<link rel="canonical" href="' . esc_url( $url ) . '" />' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . "\n";
	echo '<meta property="og:type" content="' . ( is_singular( 'post' ) ? 'article' : 'website' ) . '" />' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '" />' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $desc ) . '" />' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '" />' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '" />' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '" />' . "\n";

	if ( is_singular() && has_post_thumbnail() ) {
		$img = get_the_post_thumbnail_url( null, 'full' );
		echo '<meta property="og:image" content="' . esc_url( $img ) . '" />' . "\n";
		echo '<meta name="twitter:image" content="' . esc_url( $img ) . '" />' . "\n";
	}
}
add_action( 'wp_head', 'lv_head_meta', 5 );

/**
 * Allow AI crawlers explicitly and point them at llms.txt.
 *
 * @param string $output Robots.txt body.
 * @return string
 */
function lv_robots_txt( $output ) {
	$output .= "\n# Loom Vector\n";
	$output .= "User-agent: GPTBot\nAllow: /\n\n";
	$output .= "User-agent: PerplexityBot\nAllow: /\n\n";
	$output .= "User-agent: ClaudeBot\nAllow: /\n\n";
	$output .= 'Sitemap: ' . esc_url( home_url( '/wp-sitemap.xml' ) ) . "\n";
	$output .= '# LLM guide: ' . esc_url( home_url( '/llms.txt' ) ) . "\n";
	return $output;
}
add_filter( 'robots_txt', 'lv_robots_txt', 10, 1 );
