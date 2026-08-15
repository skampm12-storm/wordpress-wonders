<?php
/**
 * Settings screen: notification email, global FAQs, tracking snippet.
 *
 * @package LoomVectorCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add the settings submenu under Leads.
 */
function lv_core_settings_menu() {
	add_submenu_page(
		'lv-core-leads',
		__( 'Loom Vector settings', 'loom-vector-core' ),
		__( 'Settings', 'loom-vector-core' ),
		'manage_options',
		'lv-core-settings',
		'lv_core_settings_screen'
	);
}
add_action( 'admin_menu', 'lv_core_settings_menu' );

/**
 * Register settings.
 */
function lv_core_register_settings() {
	register_setting( 'lv_core_settings', 'lv_core_notify_email', array(
		'type'              => 'string',
		'sanitize_callback' => 'sanitize_email',
		'default'           => get_option( 'admin_email' ),
	) );

	register_setting( 'lv_core_settings', 'lv_core_tracking_head', array(
		'type'              => 'string',
		'sanitize_callback' => 'lv_core_sanitize_snippet',
		'default'           => '',
	) );

	register_setting( 'lv_core_settings', 'lv_core_global_faqs', array(
		'type'              => 'array',
		'sanitize_callback' => 'lv_core_sanitize_global_faqs',
		'default'           => array(),
	) );
}
add_action( 'admin_init', 'lv_core_register_settings' );

/**
 * Allow only script/noscript markup in the tracking snippet.
 *
 * @param string $value Raw value.
 * @return string
 */
function lv_core_sanitize_snippet( $value ) {
	if ( ! current_user_can( 'unfiltered_html' ) ) {
		return get_option( 'lv_core_tracking_head', '' );
	}
	return (string) $value;
}

/**
 * Parse the global FAQ textarea into pairs.
 *
 * @param mixed $value Raw textarea value.
 * @return array
 */
function lv_core_sanitize_global_faqs( $value ) {
	if ( is_array( $value ) ) {
		return $value;
	}
	return lv_core_parse_faq_text( sanitize_textarea_field( (string) $value ) );
}

/**
 * Render the settings screen.
 */
function lv_core_settings_screen() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$faqs = get_option( 'lv_core_global_faqs', array() );
	$text = '';
	foreach ( (array) $faqs as $faq ) {
		if ( isset( $faq['question'], $faq['answer'] ) ) {
			$text .= $faq['question'] . "\n" . $faq['answer'] . "\n\n";
		}
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Loom Vector settings', 'loom-vector-core' ); ?></h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'lv_core_settings' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="lv_core_notify_email"><?php esc_html_e( 'Notification email', 'loom-vector-core' ); ?></label></th>
					<td>
						<input type="email" class="regular-text" id="lv_core_notify_email" name="lv_core_notify_email" value="<?php echo esc_attr( get_option( 'lv_core_notify_email', get_option( 'admin_email' ) ) ); ?>" />
						<p class="description"><?php esc_html_e( 'Where new enquiries are sent. Use an SMTP plugin/service for reliable delivery.', 'loom-vector-core' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="lv_core_global_faqs"><?php esc_html_e( 'Global FAQs', 'loom-vector-core' ); ?></label></th>
					<td>
						<textarea class="large-text code" rows="10" id="lv_core_global_faqs" name="lv_core_global_faqs"><?php echo esc_textarea( trim( $text ) ); ?></textarea>
						<p class="description"><?php esc_html_e( 'Question on the first line, answer on the next, blank line between blocks. Used wherever a page has no FAQs of its own, and output as FAQPage schema.', 'loom-vector-core' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="lv_core_tracking_head"><?php esc_html_e( 'Head tracking snippet', 'loom-vector-core' ); ?></label></th>
					<td>
						<textarea class="large-text code" rows="6" id="lv_core_tracking_head" name="lv_core_tracking_head"><?php echo esc_textarea( get_option( 'lv_core_tracking_head', '' ) ); ?></textarea>
						<p class="description"><?php esc_html_e( 'Analytics or pixel script tags printed in the site head.', 'loom-vector-core' ); ?></p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
