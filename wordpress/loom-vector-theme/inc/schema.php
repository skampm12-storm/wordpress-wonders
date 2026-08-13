<?php
/**
 * JSON-LD structured data for answer engines.
 *
 * @package LoomVector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output all graph nodes for the current request.
 */
function lv_json_ld() {
	$graph = array( lv_schema_organization(), lv_schema_website() );

	$breadcrumb = lv_schema_breadcrumb();
	if ( $breadcrumb ) {
		$graph[] = $breadcrumb;
	}

	if ( is_singular( 'post' ) ) {
		$graph[] = lv_schema_article();
	}

	if ( is_singular( 'lv_service' ) ) {
		$graph[] = lv_schema_service();
	}

	$faq = lv_schema_faq();
	if ( $faq ) {
		$graph[] = $faq;
	}

	$payload = array(
		'@context' => 'https://schema.org',
		'@graph'   => array_values( array_filter( $graph ) ),
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'lv_json_ld', 20 );

/**
 * Organization node.
 *
 * @return array
 */
function lv_schema_organization() {
	$sameas = array_values( array_filter( array( lv_opt( 'lv_linkedin' ), lv_opt( 'lv_x' ) ) ) );

	$node = array(
		'@type'       => 'Organization',
		'@id'         => home_url( '/#organization' ),
		'name'        => get_bloginfo( 'name' ),
		'url'         => home_url( '/' ),
		'description' => get_bloginfo( 'description' ),
	);

	$logo_id = get_theme_mod( 'custom_logo' );
	if ( $logo_id ) {
		$src = wp_get_attachment_image_src( $logo_id, 'full' );
		if ( $src ) {
			$node['logo'] = $src[0];
		}
	}

	if ( $sameas ) {
		$node['sameAs'] = $sameas;
	}

	$email = lv_opt( 'lv_email' );
	$phone = lv_opt( 'lv_phone' );
	if ( $email || $phone ) {
		$contact = array( '@type' => 'ContactPoint', 'contactType' => 'sales' );
		if ( $email ) {
			$contact['email'] = $email;
		}
		if ( $phone ) {
			$contact['telephone'] = $phone;
		}
		$node['contactPoint'] = array( $contact );
	}

	return $node;
}

/**
 * WebSite node.
 *
 * @return array
 */
function lv_schema_website() {
	return array(
		'@type'           => 'WebSite',
		'@id'             => home_url( '/#website' ),
		'url'             => home_url( '/' ),
		'name'            => get_bloginfo( 'name' ),
		'publisher'       => array( '@id' => home_url( '/#organization' ) ),
		'inLanguage'      => get_bloginfo( 'language' ),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => home_url( '/?s={search_term_string}' ),
			),
			'query-input' => 'required name=search_term_string',
		),
	);
}

/**
 * Breadcrumb node.
 *
 * @return array|null
 */
function lv_schema_breadcrumb() {
	if ( is_front_page() ) {
		return null;
	}

	$items = array(
		array(
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => __( 'Home', 'loom-vector' ),
			'item'     => home_url( '/' ),
		),
	);

	if ( is_singular() ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => wp_strip_all_tags( get_the_title() ),
			'item'     => get_permalink(),
		);
	} elseif ( is_post_type_archive() ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => wp_strip_all_tags( post_type_archive_title( '', false ) ),
			'item'     => get_post_type_archive_link( get_post_type() ),
		);
	} elseif ( is_archive() ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => wp_strip_all_tags( get_the_archive_title() ),
		);
	} else {
		return null;
	}

	return array(
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $items,
	);
}

/**
 * Article node.
 *
 * @return array
 */
function lv_schema_article() {
	$node = array(
		'@type'            => 'Article',
		'headline'         => wp_strip_all_tags( get_the_title() ),
		'description'      => lv_meta_description(),
		'datePublished'    => get_the_date( 'c' ),
		'dateModified'     => get_the_modified_date( 'c' ),
		'mainEntityOfPage' => get_permalink(),
		'author'           => array(
			'@type' => 'Person',
			'name'  => get_the_author(),
		),
		'publisher'        => array( '@id' => home_url( '/#organization' ) ),
	);

	if ( has_post_thumbnail() ) {
		$node['image'] = get_the_post_thumbnail_url( null, 'full' );
	}

	return $node;
}

/**
 * Service node.
 *
 * @return array
 */
function lv_schema_service() {
	return array(
		'@type'       => 'Service',
		'name'        => wp_strip_all_tags( get_the_title() ),
		'description' => lv_meta_description(),
		'url'         => get_permalink(),
		'provider'    => array( '@id' => home_url( '/#organization' ) ),
		'areaServed'  => 'Worldwide',
	);
}

/**
 * FAQ node built from the companion plugin FAQ entries.
 *
 * @return array|null
 */
function lv_schema_faq() {
	if ( ! function_exists( 'lv_core_get_faqs' ) ) {
		return null;
	}

	$faqs = lv_core_get_faqs( is_singular() ? get_the_ID() : 0 );
	if ( empty( $faqs ) ) {
		return null;
	}

	$entities = array();
	foreach ( $faqs as $faq ) {
		$entities[] = array(
			'@type'          => 'Question',
			'name'           => wp_strip_all_tags( $faq['question'] ),
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => wp_strip_all_tags( $faq['answer'] ),
			),
		);
	}

	return array(
		'@type'      => 'FAQPage',
		'mainEntity' => $entities,
	);
}
