<?php
/**
 * Post types and taxonomies.
 *
 * @package LoomVectorCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Services, Case Studies and Testimonials.
 */
function lv_core_register_post_types() {

	register_post_type( 'lv_service', array(
		'labels' => array(
			'name'          => __( 'Services', 'loom-vector-core' ),
			'singular_name' => __( 'Service', 'loom-vector-core' ),
			'add_new_item'  => __( 'Add service', 'loom-vector-core' ),
			'edit_item'     => __( 'Edit service', 'loom-vector-core' ),
		),
		'public'       => true,
		'has_archive'  => 'services',
		'menu_icon'    => 'dashicons-networking',
		'menu_position' => 22,
		'show_in_rest' => true,
		'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'custom-fields' ),
		'rewrite'      => array( 'slug' => 'services', 'with_front' => false ),
	) );

	register_post_type( 'lv_case', array(
		'labels' => array(
			'name'          => __( 'Case studies', 'loom-vector-core' ),
			'singular_name' => __( 'Case study', 'loom-vector-core' ),
		),
		'public'       => true,
		'has_archive'  => 'case-studies',
		'menu_icon'    => 'dashicons-chart-line',
		'show_in_rest' => true,
		'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
		'rewrite'      => array( 'slug' => 'case-studies', 'with_front' => false ),
	) );

	register_post_type( 'lv_testimonial', array(
		'labels' => array(
			'name'          => __( 'Testimonials', 'loom-vector-core' ),
			'singular_name' => __( 'Testimonial', 'loom-vector-core' ),
		),
		'public'       => false,
		'show_ui'      => true,
		'menu_icon'    => 'dashicons-format-quote',
		'show_in_rest' => true,
		'supports'     => array( 'title', 'editor', 'custom-fields' ),
	) );
}
add_action( 'init', 'lv_core_register_post_types' );

/**
 * Register service category and industry taxonomies.
 */
function lv_core_register_taxonomies() {

	register_taxonomy( 'lv_service_cat', array( 'lv_service' ), array(
		'labels' => array(
			'name'          => __( 'Service categories', 'loom-vector-core' ),
			'singular_name' => __( 'Service category', 'loom-vector-core' ),
		),
		'hierarchical' => true,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'service-category' ),
	) );

	register_taxonomy( 'lv_industry', array( 'lv_service', 'lv_case' ), array(
		'labels' => array(
			'name'          => __( 'Industries', 'loom-vector-core' ),
			'singular_name' => __( 'Industry', 'loom-vector-core' ),
		),
		'hierarchical' => false,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'industry' ),
	) );
}
add_action( 'init', 'lv_core_register_taxonomies' );

/**
 * Testimonial meta box (author, role, company).
 */
function lv_core_testimonial_meta_box() {
	add_meta_box(
		'lv_core_testimonial',
		__( 'Attribution', 'loom-vector-core' ),
		'lv_core_testimonial_meta_render',
		'lv_testimonial',
		'side'
	);
}
add_action( 'add_meta_boxes', 'lv_core_testimonial_meta_box' );

/**
 * Render testimonial meta box.
 *
 * @param WP_Post $post Post.
 */
function lv_core_testimonial_meta_render( $post ) {
	wp_nonce_field( 'lv_core_testimonial_save', 'lv_core_testimonial_nonce' );
	$fields = array(
		'_lv_author'  => __( 'Person', 'loom-vector-core' ),
		'_lv_role'    => __( 'Role', 'loom-vector-core' ),
		'_lv_company' => __( 'Company', 'loom-vector-core' ),
	);
	foreach ( $fields as $key => $label ) {
		printf(
			'<p><label for="%1$s"><strong>%2$s</strong></label><input type="text" class="widefat" id="%1$s" name="%1$s" value="%3$s" /></p>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( (string) get_post_meta( $post->ID, $key, true ) )
		);
	}
}

/**
 * Save testimonial meta.
 *
 * @param int $post_id Post ID.
 */
function lv_core_testimonial_meta_save( $post_id ) {
	if ( ! isset( $_POST['lv_core_testimonial_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['lv_core_testimonial_nonce'] ) ), 'lv_core_testimonial_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( array( '_lv_author', '_lv_role', '_lv_company' ) as $key ) {
		$value = isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '';
		update_post_meta( $post_id, $key, $value );
	}
}
add_action( 'save_post_lv_testimonial', 'lv_core_testimonial_meta_save' );
