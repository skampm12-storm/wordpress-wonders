<?php
/**
 * Template helpers.
 *
 * @package LoomVector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Section heading block.
 *
 * @param string $eyebrow Eyebrow text.
 * @param string $title   Heading.
 * @param string $intro   Intro copy.
 */
function lv_section_head( $eyebrow, $title, $intro = '' ) {
	echo '<header class="lv-sectionhead">';
	if ( $eyebrow ) {
		echo '<p class="lv-eyebrow">' . esc_html( $eyebrow ) . '</p>';
	}
	echo '<h2 class="lv-sectionhead__title">' . esc_html( $title ) . '</h2>';
	if ( $intro ) {
		echo '<p class="lv-sectionhead__intro">' . esc_html( $intro ) . '</p>';
	}
	echo '</header>';
}

/**
 * Post meta line.
 */
function lv_post_meta() {
	printf(
		'<p class="lv-postmeta"><time datetime="%1$s">%2$s</time> · %3$s</p>',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_html( sprintf( /* translators: %d: minutes */ __( '%d min read', 'loom-vector' ), max( 1, (int) round( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) ) ) )
	);
}

/**
 * Breadcrumb trail markup.
 */
function lv_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}
	echo '<nav class="lv-crumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'loom-vector' ) . '"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'loom-vector' ) . '</a>';
	echo '<span aria-hidden="true">/</span><span>';
	if ( is_singular() ) {
		echo esc_html( wp_strip_all_tags( get_the_title() ) );
	} elseif ( is_search() ) {
		echo esc_html__( 'Search', 'loom-vector' );
	} else {
		echo esc_html( wp_strip_all_tags( get_the_archive_title() ) );
	}
	echo '</span></nav>';
}

/**
 * Render the services grid, from Service posts when available.
 *
 * @param int $limit Maximum items.
 */
function lv_render_services( $limit = 7 ) {
	$items = array();

	$query = new WP_Query( array(
		'post_type'              => 'lv_service',
		'posts_per_page'         => $limit,
		'post_status'            => 'publish',
		'no_found_rows'          => true,
		'ignore_sticky_posts'    => true,
	) );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$items[] = array(
				'title' => get_the_title(),
				'desc'  => wp_trim_words( wp_strip_all_tags( strip_shortcodes( get_the_content() ) ), 24, '…' ),
				'link'  => get_permalink(),
			);
		}
		wp_reset_postdata();
	} else {
		foreach ( array_slice( lv_default_services(), 0, $limit ) as $service ) {
			$items[] = array(
				'title' => $service['title'],
				'desc'  => $service['desc'],
				'link'  => '',
			);
		}
	}

	echo '<ul class="lv-grid lv-grid--services">';
	foreach ( $items as $item ) {
		echo '<li class="lv-card">';
		if ( $item['link'] ) {
			echo '<h3 class="lv-card__title"><a href="' . esc_url( $item['link'] ) . '">' . esc_html( $item['title'] ) . '</a></h3>';
		} else {
			echo '<h3 class="lv-card__title">' . esc_html( $item['title'] ) . '</h3>';
		}
		echo '<p class="lv-card__text">' . esc_html( $item['desc'] ) . '</p>';
		echo '</li>';
	}
	echo '</ul>';
}
