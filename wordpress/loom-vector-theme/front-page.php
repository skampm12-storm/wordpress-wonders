<?php
/**
 * Front page.
 *
 * @package LoomVector
 */

get_header();

get_template_part( 'template-parts/hero' );

if ( lv_opt( 'lv_show_services', true ) ) {
	get_template_part( 'template-parts/services' );
}
if ( lv_opt( 'lv_show_capability', true ) ) {
	get_template_part( 'template-parts/capability' );
}
if ( lv_opt( 'lv_show_process', true ) ) {
	get_template_part( 'template-parts/process' );
}
if ( lv_opt( 'lv_show_proof', true ) ) {
	get_template_part( 'template-parts/proof' );
}
if ( lv_opt( 'lv_show_faq', true ) ) {
	get_template_part( 'template-parts/faq' );
}
if ( lv_opt( 'lv_show_cta', true ) ) {
	get_template_part( 'template-parts/cta' );
}

get_footer();
