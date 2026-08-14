<?php
/**
 * FAQ manager — per-post FAQs plus a global set, feeding FAQPage schema.
 *
 * @package LoomVectorCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Meta box on pages, posts and services.
 */
function lv_core_faq_meta_box() {
	foreach ( array( 'page', 'post', 'lv_service' ) as $type ) {
		add_meta_box( 'lv_core_faq', __( 'FAQ (schema-enabled)', 'loom-vector-core' ), 'lv_core_faq_render', $type, 'normal', 'default' );
	}
}
add_action( 'add_meta_boxes', 'lv_core_faq_meta_box' );

/**
 * Render the FAQ editor.
 *
 * @param WP_Post $post Post.
 */
function lv_core_faq_render( $post ) {
	wp_nonce_field( 'lv_core_faq_save', 'lv_core_faq_nonce' );
	$faqs = lv_core_get_faqs( $post->ID, false );
	$text = '';
	foreach ( $faqs as $faq ) {
		$text .= $faq['question'] . "\n" . $faq['answer'] . "\n\n";
	}
	echo '<p>' . esc_html__( 'One FAQ per block: question on the first line, answer on the second, blank line between blocks.', 'loom-vector-core' ) . '</p>';
	printf(
		'<textarea class="widefat" rows="10" name="lv_core_faq_text">%s</textarea>',
		esc_textarea( trim( $text ) )
	);
}

/**
 * Save FAQs.
 *
 * @param int $post_id Post ID.
 */
function lv_core_faq_save( $post_id ) {
	if ( ! isset( $_POST['lv_core_faq_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['lv_core_faq_nonce'] ) ), 'lv_core_faq_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$raw = isset( $_POST['lv_core_faq_text'] ) ? sanitize_textarea_field( wp_unslash( $_POST['lv_core_faq_text'] ) ) : '';
	update_post_meta( $post_id, '_lv_faqs', lv_core_parse_faq_text( $raw ) );
}
add_action( 'save_post', 'lv_core_faq_save' );

/**
 * Parse the FAQ textarea format into pairs.
 *
 * @param string $raw Raw text.
 * @return array
 */
function lv_core_parse_faq_text( $raw ) {
	$faqs   = array();
	$blocks = preg_split( '/\R{2,}/', trim( (string) $raw ) );

	foreach ( (array) $blocks as $block ) {
		$lines = array_values( array_filter( array_map( 'trim', preg_split( '/\R/', $block ) ) ) );
		if ( count( $lines ) < 2 ) {
			continue;
		}
		$faqs[] = array(
			'question' => $lines[0],
			'answer'   => implode( ' ', array_slice( $lines, 1 ) ),
		);
	}

	return $faqs;
}

/**
 * Get FAQs for a post, falling back to the global set.
 *
 * @param int  $post_id  Post ID (0 for global).
 * @param bool $fallback Whether to fall back to the global set.
 * @return array
 */
function lv_core_get_faqs( $post_id = 0, $fallback = true ) {
	$faqs = array();

	if ( $post_id ) {
		$stored = get_post_meta( $post_id, '_lv_faqs', true );
		if ( is_array( $stored ) ) {
			$faqs = $stored;
		}
	}

	if ( empty( $faqs ) && $fallback ) {
		$global = get_option( 'lv_core_global_faqs', array() );
		if ( is_array( $global ) ) {
			$faqs = $global;
		}
	}

	return $faqs;
}
