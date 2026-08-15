<?php
/**
 * Lead capture form: rendering, validation, storage, notification.
 *
 * @package LoomVectorCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Interest options offered in the form.
 *
 * @return array
 */
function lv_core_interest_options() {
	return apply_filters( 'lv_core_interest_options', array(
		'website'    => __( 'Website design & build', 'loom-vector-core' ),
		'messaging'  => __( 'WhatsApp / SMS marketing', 'loom-vector-core' ),
		'ads'        => __( 'Digital advertising', 'loom-vector-core' ),
		'offline'    => __( 'Offline advertising', 'loom-vector-core' ),
		'rpa'        => __( 'RPA / process automation', 'loom-vector-core' ),
		'ai'         => __( 'AI workflows', 'loom-vector-core' ),
		'gtm'        => __( 'GTM enablement consulting', 'loom-vector-core' ),
		'other'      => __( 'Something else', 'loom-vector-core' ),
	) );
}

/**
 * Render the contact form.
 *
 * @param array $args Args: title, intro, button.
 * @return string
 */
function lv_core_render_form( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'title'  => __( 'Tell us what you want to fix', 'loom-vector-core' ),
		'intro'  => __( 'One business day reply, always from a human.', 'loom-vector-core' ),
		'button' => __( 'Send enquiry', 'loom-vector-core' ),
	) );

	$notice = '';
	$state  = isset( $_GET['lv_sent'] ) ? sanitize_key( wp_unslash( $_GET['lv_sent'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification

	if ( 'ok' === $state ) {
		$notice = '<div class="lv-form__notice lv-form__notice--ok">' . esc_html__( 'Thanks — your message is in. We reply within one business day.', 'loom-vector-core' ) . '</div>';
	} elseif ( 'error' === $state ) {
		$notice = '<div class="lv-form__notice lv-form__notice--error">' . esc_html__( 'Please add your name, a valid email and a short message.', 'loom-vector-core' ) . '</div>';
	}

	$old = static function ( $key ) {
		return '';
	};
	unset( $old );

	ob_start();
	?>
	<form class="lv-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<?php echo $notice; // phpcs:ignore WordPress.Security.EscapeOutput ?>

		<?php if ( $args['title'] ) : ?>
			<h2 class="lv-form__title"><?php echo esc_html( $args['title'] ); ?></h2>
		<?php endif; ?>
		<?php if ( $args['intro'] ) : ?>
			<p class="lv-form__intro"><?php echo esc_html( $args['intro'] ); ?></p>
		<?php endif; ?>

		<input type="hidden" name="action" value="lv_core_lead" />
		<?php wp_nonce_field( 'lv_core_lead', 'lv_core_lead_nonce' ); ?>
		<input type="hidden" name="lv_page_url" value="<?php echo esc_url( lv_core_current_url() ); ?>" />
		<?php foreach ( array( 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content' ) as $utm ) : ?>
			<input type="hidden" name="<?php echo esc_attr( $utm ); ?>" value="<?php echo esc_attr( lv_core_utm_value( $utm ) ); ?>" />
		<?php endforeach; ?>

		<p class="lv-form__hp" aria-hidden="true">
			<label for="lv-website"><?php esc_html_e( 'Leave this field empty', 'loom-vector-core' ); ?></label>
			<input type="text" id="lv-website" name="lv_website" tabindex="-1" autocomplete="off" value="" />
		</p>

		<div class="lv-form__row">
			<p class="lv-field">
				<label for="lv-name"><?php esc_html_e( 'Name', 'loom-vector-core' ); ?> <span aria-hidden="true">*</span></label>
				<input type="text" id="lv-name" name="lv_name" required />
			</p>
			<p class="lv-field">
				<label for="lv-email"><?php esc_html_e( 'Work email', 'loom-vector-core' ); ?> <span aria-hidden="true">*</span></label>
				<input type="email" id="lv-email" name="lv_email" required />
			</p>
		</div>

		<div class="lv-form__row">
			<p class="lv-field">
				<label for="lv-company"><?php esc_html_e( 'Company', 'loom-vector-core' ); ?></label>
				<input type="text" id="lv-company" name="lv_company" />
			</p>
			<p class="lv-field">
				<label for="lv-phone"><?php esc_html_e( 'Phone / WhatsApp', 'loom-vector-core' ); ?></label>
				<input type="tel" id="lv-phone" name="lv_phone" />
			</p>
		</div>

		<p class="lv-field">
			<label for="lv-interest"><?php esc_html_e( 'What do you need?', 'loom-vector-core' ); ?></label>
			<select id="lv-interest" name="lv_interest">
				<?php foreach ( lv_core_interest_options() as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p class="lv-field">
			<label for="lv-message"><?php esc_html_e( 'What are you trying to fix?', 'loom-vector-core' ); ?> <span aria-hidden="true">*</span></label>
			<textarea id="lv-message" name="lv_message" rows="5" required></textarea>
		</p>

		<p class="lv-field lv-field--submit">
			<button type="submit" class="lv-btn"><?php echo esc_html( $args['button'] ); ?></button>
		</p>
	</form>
	<?php
	return (string) ob_get_clean();
}

/**
 * Current front-end URL.
 *
 * @return string
 */
function lv_core_current_url() {
	$host = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '';
	$uri  = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';

	if ( ! $host ) {
		return home_url( '/' );
	}

	return ( is_ssl() ? 'https://' : 'http://' ) . $host . $uri;
}

/**
 * Read a UTM value from the query string or the stored cookie.
 *
 * @param string $key UTM key.
 * @return string
 */
function lv_core_utm_value( $key ) {
	// phpcs:ignore WordPress.Security.NonceVerification
	if ( isset( $_GET[ $key ] ) ) {
		return sanitize_text_field( wp_unslash( $_GET[ $key ] ) );
	}

	if ( isset( $_COOKIE['lv_utm'] ) ) {
		$stored = json_decode( sanitize_textarea_field( wp_unslash( $_COOKIE['lv_utm'] ) ), true );
		if ( is_array( $stored ) && isset( $stored[ $key ] ) ) {
			return sanitize_text_field( (string) $stored[ $key ] );
		}
	}

	return '';
}

/**
 * Persist first-touch UTM parameters in a cookie for 30 days.
 */
function lv_core_capture_utm() {
	if ( is_admin() || headers_sent() || isset( $_COOKIE['lv_utm'] ) ) {
		return;
	}

	$data = array();
	foreach ( array( 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content' ) as $key ) {
		// phpcs:ignore WordPress.Security.NonceVerification
		if ( isset( $_GET[ $key ] ) ) {
			$data[ $key ] = sanitize_text_field( wp_unslash( $_GET[ $key ] ) );
		}
	}

	if ( empty( $data ) ) {
		return;
	}

	setcookie( 'lv_utm', wp_json_encode( $data ), time() + ( 30 * DAY_IN_SECONDS ), COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN, is_ssl(), true );
}
add_action( 'template_redirect', 'lv_core_capture_utm' );

/**
 * Handle the submission.
 */
function lv_core_handle_lead() {
	$referer = wp_get_referer() ? wp_get_referer() : home_url( '/' );

	if ( ! isset( $_POST['lv_core_lead_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['lv_core_lead_nonce'] ) ), 'lv_core_lead' ) ) {
		wp_safe_redirect( add_query_arg( 'lv_sent', 'error', $referer ) );
		exit;
	}

	// Honeypot: silently accept and drop.
	if ( ! empty( $_POST['lv_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'lv_sent', 'ok', $referer ) );
		exit;
	}

	$name    = isset( $_POST['lv_name'] ) ? sanitize_text_field( wp_unslash( $_POST['lv_name'] ) ) : '';
	$email   = isset( $_POST['lv_email'] ) ? sanitize_email( wp_unslash( $_POST['lv_email'] ) ) : '';
	$message = isset( $_POST['lv_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['lv_message'] ) ) : '';

	if ( '' === $name || ! is_email( $email ) || strlen( $message ) < 5 ) {
		wp_safe_redirect( add_query_arg( 'lv_sent', 'error', $referer ) );
		exit;
	}

	$interests = lv_core_interest_options();
	$interest  = isset( $_POST['lv_interest'] ) ? sanitize_key( wp_unslash( $_POST['lv_interest'] ) ) : '';
	$interest  = isset( $interests[ $interest ] ) ? $interests[ $interest ] : '';

	$lead = array(
		'created_at'   => current_time( 'mysql' ),
		'name'         => $name,
		'email'        => $email,
		'company'      => isset( $_POST['lv_company'] ) ? sanitize_text_field( wp_unslash( $_POST['lv_company'] ) ) : '',
		'phone'        => isset( $_POST['lv_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['lv_phone'] ) ) : '',
		'interest'     => $interest,
		'message'      => $message,
		'page_url'     => isset( $_POST['lv_page_url'] ) ? esc_url_raw( wp_unslash( $_POST['lv_page_url'] ) ) : '',
		'utm_source'   => isset( $_POST['utm_source'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_source'] ) ) : '',
		'utm_medium'   => isset( $_POST['utm_medium'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_medium'] ) ) : '',
		'utm_campaign' => isset( $_POST['utm_campaign'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_campaign'] ) ) : '',
		'utm_term'     => isset( $_POST['utm_term'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_term'] ) ) : '',
		'utm_content'  => isset( $_POST['utm_content'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_content'] ) ) : '',
		'referrer'     => esc_url_raw( $referer ),
	);

	$lead_id = lv_core_insert_lead( $lead );

	lv_core_notify_lead( $lead );

	/**
	 * Fires after a lead is stored.
	 *
	 * @param int   $lead_id Lead ID.
	 * @param array $lead    Lead data.
	 */
	do_action( 'lv_core_lead_created', $lead_id, $lead );

	wp_safe_redirect( add_query_arg( 'lv_sent', 'ok', $lead['page_url'] ? $lead['page_url'] : $referer ) . '#lv-form' );
	exit;
}
add_action( 'admin_post_nopriv_lv_core_lead', 'lv_core_handle_lead' );
add_action( 'admin_post_lv_core_lead', 'lv_core_handle_lead' );

/**
 * Email the notification recipient.
 *
 * @param array $lead Lead data.
 */
function lv_core_notify_lead( $lead ) {
	$to = get_option( 'lv_core_notify_email', get_option( 'admin_email' ) );
	if ( ! is_email( $to ) ) {
		return;
	}

	$subject = sprintf(
		/* translators: %s: lead name */
		__( 'New enquiry from %s', 'loom-vector-core' ),
		$lead['name']
	);

	$lines = array(
		__( 'Name', 'loom-vector-core' ) . ': ' . $lead['name'],
		__( 'Email', 'loom-vector-core' ) . ': ' . $lead['email'],
		__( 'Company', 'loom-vector-core' ) . ': ' . $lead['company'],
		__( 'Phone', 'loom-vector-core' ) . ': ' . $lead['phone'],
		__( 'Interest', 'loom-vector-core' ) . ': ' . $lead['interest'],
		'',
		$lead['message'],
		'',
		__( 'Page', 'loom-vector-core' ) . ': ' . $lead['page_url'],
		'UTM: ' . trim( $lead['utm_source'] . ' / ' . $lead['utm_medium'] . ' / ' . $lead['utm_campaign'], ' /' ),
	);

	wp_mail(
		$to,
		$subject,
		implode( "\n", $lines ),
		array( 'Reply-To: ' . $lead['name'] . ' <' . $lead['email'] . '>' )
	);
}
