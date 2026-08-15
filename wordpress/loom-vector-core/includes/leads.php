<?php
/**
 * Lead storage, admin list table and CSV export.
 *
 * @package LoomVectorCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Leads table name.
 *
 * @return string
 */
function lv_core_leads_table() {
	global $wpdb;
	return $wpdb->prefix . 'lv_leads';
}

/**
 * Create the leads table.
 */
function lv_core_create_leads_table() {
	global $wpdb;

	$table   = lv_core_leads_table();
	$charset = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE {$table} (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		created_at datetime NOT NULL,
		name varchar(190) NOT NULL DEFAULT '',
		email varchar(190) NOT NULL DEFAULT '',
		company varchar(190) NOT NULL DEFAULT '',
		phone varchar(60) NOT NULL DEFAULT '',
		interest varchar(190) NOT NULL DEFAULT '',
		message longtext NOT NULL,
		page_url varchar(255) NOT NULL DEFAULT '',
		utm_source varchar(190) NOT NULL DEFAULT '',
		utm_medium varchar(190) NOT NULL DEFAULT '',
		utm_campaign varchar(190) NOT NULL DEFAULT '',
		utm_term varchar(190) NOT NULL DEFAULT '',
		utm_content varchar(190) NOT NULL DEFAULT '',
		referrer varchar(255) NOT NULL DEFAULT '',
		PRIMARY KEY  (id),
		KEY created_at (created_at),
		KEY email (email)
	) {$charset};";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );

	update_option( 'lv_core_db_version', '1.0.0' );
}

/**
 * Make sure the table exists after plugin updates.
 */
function lv_core_maybe_upgrade_db() {
	if ( get_option( 'lv_core_db_version' ) !== '1.0.0' ) {
		lv_core_create_leads_table();
	}
}
add_action( 'admin_init', 'lv_core_maybe_upgrade_db' );

/**
 * Insert a lead row.
 *
 * @param array $lead Sanitized lead data.
 * @return int Inserted ID or 0.
 */
function lv_core_insert_lead( $lead ) {
	global $wpdb;

	$defaults = array(
		'created_at'   => current_time( 'mysql' ),
		'name'         => '',
		'email'        => '',
		'company'      => '',
		'phone'        => '',
		'interest'     => '',
		'message'      => '',
		'page_url'     => '',
		'utm_source'   => '',
		'utm_medium'   => '',
		'utm_campaign' => '',
		'utm_term'     => '',
		'utm_content'  => '',
		'referrer'     => '',
	);

	$row = wp_parse_args( $lead, $defaults );

	// phpcs:ignore WordPress.DB.DirectDatabaseQuery
	$ok = $wpdb->insert( lv_core_leads_table(), $row );

	return $ok ? (int) $wpdb->insert_id : 0;
}

/**
 * Admin menu for leads.
 */
function lv_core_leads_menu() {
	add_menu_page(
		__( 'Leads', 'loom-vector-core' ),
		__( 'Leads', 'loom-vector-core' ),
		'manage_options',
		'lv-core-leads',
		'lv_core_leads_screen',
		'dashicons-email-alt',
		23
	);
}
add_action( 'admin_menu', 'lv_core_leads_menu' );

/**
 * Fetch leads.
 *
 * @param int $limit  Limit.
 * @param int $offset Offset.
 * @return array
 */
function lv_core_get_leads( $limit = 50, $offset = 0 ) {
	global $wpdb;
	$table = lv_core_leads_table();

	// phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL
	return (array) $wpdb->get_results(
		$wpdb->prepare( "SELECT * FROM {$table} ORDER BY id DESC LIMIT %d OFFSET %d", $limit, $offset ),
		ARRAY_A
	);
}

/**
 * Count leads.
 *
 * @return int
 */
function lv_core_count_leads() {
	global $wpdb;
	$table = lv_core_leads_table();
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL
	return (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );
}

/**
 * Render the leads screen.
 */
function lv_core_leads_screen() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$paged  = isset( $_GET['paged'] ) ? max( 1, absint( $_GET['paged'] ) ) : 1; // phpcs:ignore WordPress.Security.NonceVerification
	$per    = 25;
	$leads  = lv_core_get_leads( $per, ( $paged - 1 ) * $per );
	$total  = lv_core_count_leads();
	$pages  = max( 1, (int) ceil( $total / $per ) );
	$export = wp_nonce_url( admin_url( 'admin-post.php?action=lv_core_export_leads' ), 'lv_core_export_leads' );

	echo '<div class="wrap">';
	echo '<h1 class="wp-heading-inline">' . esc_html__( 'Leads', 'loom-vector-core' ) . '</h1> ';
	printf( '<a href="%s" class="page-title-action">%s</a>', esc_url( $export ), esc_html__( 'Export CSV', 'loom-vector-core' ) );
	printf( '<p>%s</p>', esc_html( sprintf( /* translators: %d: number of leads */ __( '%d total submissions.', 'loom-vector-core' ), $total ) ) );

	echo '<table class="widefat striped"><thead><tr>';
	foreach ( array( __( 'Date', 'loom-vector-core' ), __( 'Name', 'loom-vector-core' ), __( 'Email', 'loom-vector-core' ), __( 'Company', 'loom-vector-core' ), __( 'Interest', 'loom-vector-core' ), __( 'Message', 'loom-vector-core' ), __( 'Source', 'loom-vector-core' ) ) as $heading ) {
		echo '<th>' . esc_html( $heading ) . '</th>';
	}
	echo '</tr></thead><tbody>';

	if ( empty( $leads ) ) {
		echo '<tr><td colspan="7">' . esc_html__( 'No leads yet.', 'loom-vector-core' ) . '</td></tr>';
	}

	foreach ( $leads as $lead ) {
		echo '<tr>';
		echo '<td>' . esc_html( $lead['created_at'] ) . '</td>';
		echo '<td>' . esc_html( $lead['name'] ) . '</td>';
		echo '<td><a href="mailto:' . esc_attr( $lead['email'] ) . '">' . esc_html( $lead['email'] ) . '</a></td>';
		echo '<td>' . esc_html( $lead['company'] ) . '</td>';
		echo '<td>' . esc_html( $lead['interest'] ) . '</td>';
		echo '<td>' . esc_html( wp_trim_words( $lead['message'], 24 ) ) . '</td>';
		echo '<td>' . esc_html( trim( $lead['utm_source'] . ' / ' . $lead['utm_campaign'], ' /' ) ) . '</td>';
		echo '</tr>';
	}

	echo '</tbody></table>';

	if ( $pages > 1 ) {
		echo '<p class="tablenav-pages">';
		echo wp_kses_post( paginate_links( array(
			'base'    => add_query_arg( 'paged', '%#%' ),
			'format'  => '',
			'current' => $paged,
			'total'   => $pages,
		) ) );
		echo '</p>';
	}

	echo '</div>';
}

/**
 * CSV export.
 */
function lv_core_export_leads() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Not allowed.', 'loom-vector-core' ) );
	}
	check_admin_referer( 'lv_core_export_leads' );

	$leads = lv_core_get_leads( 10000, 0 );

	nocache_headers();
	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=loom-vector-leads-' . gmdate( 'Y-m-d' ) . '.csv' );

	$out     = fopen( 'php://output', 'w' );
	$columns = array( 'id', 'created_at', 'name', 'email', 'company', 'phone', 'interest', 'message', 'page_url', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'referrer' );
	fputcsv( $out, $columns );

	foreach ( $leads as $lead ) {
		$row = array();
		foreach ( $columns as $column ) {
			$row[] = isset( $lead[ $column ] ) ? $lead[ $column ] : '';
		}
		fputcsv( $out, $row );
	}

	fclose( $out );
	exit;
}
add_action( 'admin_post_lv_core_export_leads', 'lv_core_export_leads' );
