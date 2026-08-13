<?php
/**
 * Customizer controls.
 *
 * @package LoomVector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register settings.
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 */
function lv_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Brand.
	$wp_customize->add_section( 'lv_brand', array(
		'title'    => __( 'Loom Vector — Brand', 'loom-vector' ),
		'priority' => 20,
	) );

	$colors = array(
		'lv_color_ink'     => array( __( 'Ink (text)', 'loom-vector' ), '#101211' ),
		'lv_color_accent'  => array( __( 'Accent', 'loom-vector' ), '#1f6f5c' ),
		'lv_color_surface' => array( __( 'Surface', 'loom-vector' ), '#f7f6f2' ),
	);

	foreach ( $colors as $key => $data ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $data[1],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, array(
			'label'   => $data[0],
			'section' => 'lv_brand',
		) ) );
	}

	$wp_customize->add_setting( 'lv_type_scale', array(
		'default'           => 1,
		'sanitize_callback' => 'lv_sanitize_scale',
	) );
	$wp_customize->add_control( 'lv_type_scale', array(
		'label'       => __( 'Typography scale', 'loom-vector' ),
		'section'     => 'lv_brand',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 0.85,
			'max'  => 1.25,
			'step' => 0.05,
		),
	) );

	// Hero.
	$wp_customize->add_section( 'lv_hero', array(
		'title'    => __( 'Loom Vector — Hero', 'loom-vector' ),
		'priority' => 21,
	) );

	$hero_fields = array(
		'lv_hero_eyebrow'  => array( __( 'Eyebrow', 'loom-vector' ), __( 'Growth systems studio', 'loom-vector' ), 'text' ),
		'lv_hero_title'    => array( __( 'Heading', 'loom-vector' ), __( 'Demand, automated end to end.', 'loom-vector' ), 'text' ),
		'lv_hero_subtitle' => array( __( 'Subheading', 'loom-vector' ), __( 'Loom Vector designs the website, runs the campaigns and automates the workflows behind them — one team for design, messaging, media and AI operations.', 'loom-vector' ), 'textarea' ),
		'lv_hero_cta_text' => array( __( 'Primary CTA label', 'loom-vector' ), __( 'Book a working session', 'loom-vector' ), 'text' ),
		'lv_hero_cta_url'  => array( __( 'Primary CTA link', 'loom-vector' ), '/contact/', 'url' ),
		'lv_hero_alt_text' => array( __( 'Secondary CTA label', 'loom-vector' ), __( 'See services', 'loom-vector' ), 'text' ),
		'lv_hero_alt_url'  => array( __( 'Secondary CTA link', 'loom-vector' ), '/services/', 'url' ),
	);

	foreach ( $hero_fields as $key => $data ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $data[1],
			'sanitize_callback' => 'url' === $data[2] ? 'esc_url_raw' : ( 'textarea' === $data[2] ? 'sanitize_textarea_field' : 'sanitize_text_field' ),
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $data[0],
			'section' => 'lv_hero',
			'type'    => 'textarea' === $data[2] ? 'textarea' : 'text',
		) );
	}

	// Sections toggles.
	$wp_customize->add_section( 'lv_sections', array(
		'title'    => __( 'Loom Vector — Sections', 'loom-vector' ),
		'priority' => 22,
	) );

	$toggles = array(
		'lv_show_services'   => __( 'Show services grid', 'loom-vector' ),
		'lv_show_capability' => __( 'Show capability strip', 'loom-vector' ),
		'lv_show_process'    => __( 'Show process', 'loom-vector' ),
		'lv_show_proof'      => __( 'Show proof / results', 'loom-vector' ),
		'lv_show_faq'        => __( 'Show FAQ', 'loom-vector' ),
		'lv_show_cta'        => __( 'Show closing CTA', 'loom-vector' ),
	);

	foreach ( $toggles as $key => $label ) {
		$wp_customize->add_setting( $key, array(
			'default'           => true,
			'sanitize_callback' => 'lv_sanitize_bool',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $label,
			'section' => 'lv_sections',
			'type'    => 'checkbox',
		) );
	}

	// CTA banner.
	$wp_customize->add_section( 'lv_cta', array(
		'title'    => __( 'Loom Vector — CTA banner', 'loom-vector' ),
		'priority' => 23,
	) );

	$cta_fields = array(
		'lv_cta_title' => array( __( 'CTA heading', 'loom-vector' ), __( 'Tell us what should be automated first.', 'loom-vector' ) ),
		'lv_cta_text'  => array( __( 'CTA text', 'loom-vector' ), __( 'A 45-minute working session, no deck. We map the workflow, the data and the fastest path to a measurable result.', 'loom-vector' ) ),
		'lv_cta_label' => array( __( 'CTA button label', 'loom-vector' ), __( 'Start a conversation', 'loom-vector' ) ),
		'lv_cta_url'   => array( __( 'CTA button link', 'loom-vector' ), '/contact/' ),
	);

	foreach ( $cta_fields as $key => $data ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $data[1],
			'sanitize_callback' => 'lv_cta_url' === $key ? 'esc_url_raw' : 'sanitize_text_field',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $data[0],
			'section' => 'lv_cta',
			'type'    => 'text',
		) );
	}

	// Contact + social + footer.
	$wp_customize->add_section( 'lv_contact', array(
		'title'    => __( 'Loom Vector — Contact & footer', 'loom-vector' ),
		'priority' => 24,
	) );

	$contact_fields = array(
		'lv_email'       => array( __( 'Email', 'loom-vector' ), 'hello@loomvector.com', 'sanitize_email' ),
		'lv_phone'       => array( __( 'Phone', 'loom-vector' ), '', 'sanitize_text_field' ),
		'lv_address'     => array( __( 'Address', 'loom-vector' ), '', 'sanitize_text_field' ),
		'lv_linkedin'    => array( __( 'LinkedIn URL', 'loom-vector' ), '', 'esc_url_raw' ),
		'lv_x'           => array( __( 'X / Twitter URL', 'loom-vector' ), '', 'esc_url_raw' ),
		'lv_footer_text' => array( __( 'Footer text', 'loom-vector' ), __( 'Loom Vector — design, demand and automation under one roof.', 'loom-vector' ), 'sanitize_text_field' ),
	);

	foreach ( $contact_fields as $key => $data ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $data[1],
			'sanitize_callback' => $data[2],
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $data[0],
			'section' => 'lv_contact',
			'type'    => 'text',
		) );
	}
}
add_action( 'customize_register', 'lv_customize_register' );

/**
 * Sanitize checkbox.
 *
 * @param mixed $value Value.
 * @return bool
 */
function lv_sanitize_bool( $value ) {
	return (bool) $value;
}

/**
 * Sanitize type scale.
 *
 * @param mixed $value Value.
 * @return float
 */
function lv_sanitize_scale( $value ) {
	$value = (float) $value;
	if ( $value < 0.85 || $value > 1.25 ) {
		return 1.0;
	}
	return $value;
}

/**
 * Live preview script.
 */
function lv_customize_preview_js() {
	wp_enqueue_script( 'lv-customizer', LV_THEME_URI . '/assets/js/customizer.js', array( 'customize-preview' ), LV_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'lv_customize_preview_js' );
