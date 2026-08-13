<?php
/**
 * Shared helpers.
 *
 * @package LoomVector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme option with default.
 *
 * @param string $key     Setting key.
 * @param mixed  $default Default value.
 * @return mixed
 */
function lv_opt( $key, $default = '' ) {
	$value = get_theme_mod( $key, $default );
	return ( '' === $value || null === $value ) ? $default : $value;
}

/**
 * Inline CSS variables driven by the Customizer.
 *
 * @return string
 */
function lv_css_variables() {
	$ink     = lv_opt( 'lv_color_ink', '#101211' );
	$accent  = lv_opt( 'lv_color_accent', '#1f6f5c' );
	$surface = lv_opt( 'lv_color_surface', '#f7f6f2' );
	$scale   = (float) lv_opt( 'lv_type_scale', 1 );
	$scale   = ( $scale >= 0.85 && $scale <= 1.25 ) ? $scale : 1;

	return sprintf(
		':root{--lv-ink:%1$s;--lv-accent:%2$s;--lv-surface:%3$s;--lv-scale:%4$s;}',
		esc_attr( $ink ),
		esc_attr( $accent ),
		esc_attr( $surface ),
		esc_attr( (string) $scale )
	);
}

/**
 * Whether the companion plugin is active.
 *
 * @return bool
 */
function lv_core_active() {
	return function_exists( 'lv_core_bootstrap' );
}

/**
 * Default service list used when no Service posts exist yet.
 *
 * @return array
 */
function lv_default_services() {
	return array(
		array(
			'title' => __( 'Website design & build', 'loom-vector' ),
			'desc'  => __( 'Positioning-led sites that load fast, rank well and read cleanly for both people and AI answer engines.', 'loom-vector' ),
		),
		array(
			'title' => __( 'WhatsApp & SMS marketing', 'loom-vector' ),
			'desc'  => __( 'Opt-in journeys, broadcast templates and conversational flows wired to your CRM with measurable reply rates.', 'loom-vector' ),
		),
		array(
			'title' => __( 'Digital advertising', 'loom-vector' ),
			'desc'  => __( 'Search, social and programmatic campaigns built around pipeline, not impressions, with clean UTM attribution.', 'loom-vector' ),
		),
		array(
			'title' => __( 'Offline advertising', 'loom-vector' ),
			'desc'  => __( 'Print, OOH, radio and event placements planned with the same measurement discipline as paid digital.', 'loom-vector' ),
		),
		array(
			'title' => __( 'RPA solutions', 'loom-vector' ),
			'desc'  => __( 'Robotic process automation for repetitive back-office work: data entry, reconciliation, reporting and handoffs.', 'loom-vector' ),
		),
		array(
			'title' => __( 'AI workflows', 'loom-vector' ),
			'desc'  => __( 'Practical AI in your existing stack: enrichment, drafting, routing, summarisation and quality checks with human review.', 'loom-vector' ),
		),
		array(
			'title' => __( 'GTM enablement consulting', 'loom-vector' ),
			'desc'  => __( 'Tooling, ICP definition, ABM programmes and revenue reporting so your go-to-market runs on one shared source of truth.', 'loom-vector' ),
		),
	);
}
