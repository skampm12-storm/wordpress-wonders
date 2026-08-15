<?php
/**
 * Reusable shortcodes.
 *
 * @package LoomVectorCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * [lv_contact_form title="" intro="" button=""]
 *
 * @param array $atts Attributes.
 * @return string
 */
function lv_core_sc_contact_form( $atts ) {
	$atts = shortcode_atts(
		array(
			'title'  => __( 'Tell us what you want to fix', 'loom-vector-core' ),
			'intro'  => __( 'One business day reply, always from a human.', 'loom-vector-core' ),
			'button' => __( 'Send enquiry', 'loom-vector-core' ),
		),
		$atts,
		'lv_contact_form'
	);

	return '<div id="lv-form">' . lv_core_render_form( $atts ) . '</div>';
}
add_shortcode( 'lv_contact_form', 'lv_core_sc_contact_form' );

/**
 * [lv_services count="6" category=""]
 *
 * @param array $atts Attributes.
 * @return string
 */
function lv_core_sc_services( $atts ) {
	$atts = shortcode_atts(
		array(
			'count'    => 6,
			'category' => '',
		),
		$atts,
		'lv_services'
	);

	$args = array(
		'post_type'      => 'lv_service',
		'posts_per_page' => (int) $atts['count'],
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	);

	if ( $atts['category'] ) {
		$args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery
			array(
				'taxonomy' => 'lv_service_cat',
				'field'    => 'slug',
				'terms'    => array_map( 'sanitize_title', explode( ',', $atts['category'] ) ),
			),
		);
	}

	$query = new WP_Query( $args );

	if ( ! $query->have_posts() ) {
		return '';
	}

	ob_start();
	echo '<div class="lv-grid lv-grid--3">';
	while ( $query->have_posts() ) {
		$query->the_post();
		?>
		<article class="lv-card">
			<h3 class="lv-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<p class="lv-card__text"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 26 ) ); ?></p>
			<a class="lv-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'See how it works', 'loom-vector-core' ); ?></a>
		</article>
		<?php
	}
	echo '</div>';
	wp_reset_postdata();

	return (string) ob_get_clean();
}
add_shortcode( 'lv_services', 'lv_core_sc_services' );

/**
 * [lv_testimonials count="3"]
 *
 * @param array $atts Attributes.
 * @return string
 */
function lv_core_sc_testimonials( $atts ) {
	$atts = shortcode_atts( array( 'count' => 3 ), $atts, 'lv_testimonials' );

	$query = new WP_Query( array(
		'post_type'      => 'lv_testimonial',
		'posts_per_page' => (int) $atts['count'],
		'no_found_rows'  => true,
	) );

	if ( ! $query->have_posts() ) {
		return '';
	}

	ob_start();
	echo '<div class="lv-grid lv-grid--3">';
	while ( $query->have_posts() ) {
		$query->the_post();
		$author  = (string) get_post_meta( get_the_ID(), '_lv_author', true );
		$role    = (string) get_post_meta( get_the_ID(), '_lv_role', true );
		$company = (string) get_post_meta( get_the_ID(), '_lv_company', true );
		$meta    = trim( implode( ', ', array_filter( array( $role, $company ) ) ) );
		?>
		<figure class="lv-quote">
			<blockquote class="lv-quote__text"><?php echo wp_kses_post( wpautop( get_the_content() ) ); ?></blockquote>
			<figcaption class="lv-quote__cite">
				<strong><?php echo esc_html( $author ? $author : get_the_title() ); ?></strong>
				<?php if ( $meta ) : ?><span><?php echo esc_html( $meta ); ?></span><?php endif; ?>
			</figcaption>
		</figure>
		<?php
	}
	echo '</div>';
	wp_reset_postdata();

	return (string) ob_get_clean();
}
add_shortcode( 'lv_testimonials', 'lv_core_sc_testimonials' );

/**
 * [lv_faq id="" title="Questions people ask"]
 *
 * @param array $atts Attributes.
 * @return string
 */
function lv_core_sc_faq( $atts ) {
	$atts = shortcode_atts(
		array(
			'id'    => 0,
			'title' => __( 'Questions people ask', 'loom-vector-core' ),
		),
		$atts,
		'lv_faq'
	);

	$post_id = (int) $atts['id'];
	if ( ! $post_id && is_singular() ) {
		$post_id = (int) get_the_ID();
	}

	$faqs = lv_core_get_faqs( $post_id );
	if ( empty( $faqs ) ) {
		return '';
	}

	ob_start();
	echo '<section class="lv-faq">';
	if ( $atts['title'] ) {
		echo '<h2 class="lv-section__title">' . esc_html( $atts['title'] ) . '</h2>';
	}
	echo '<div class="lv-faq__list">';
	foreach ( $faqs as $faq ) {
		printf(
			'<details class="lv-faq__item"><summary class="lv-faq__q">%s</summary><div class="lv-faq__a"><p>%s</p></div></details>',
			esc_html( $faq['question'] ),
			esc_html( $faq['answer'] )
		);
	}
	echo '</div></section>';

	return (string) ob_get_clean();
}
add_shortcode( 'lv_faq', 'lv_core_sc_faq' );

/**
 * [lv_cta title="" text="" label="" url=""]
 *
 * @param array $atts Attributes.
 * @return string
 */
function lv_core_sc_cta( $atts ) {
	$atts = shortcode_atts(
		array(
			'title' => __( 'Ready to make the pipeline predictable?', 'loom-vector-core' ),
			'text'  => __( 'Book a 45-minute working session. You leave with a mapped funnel and a written next step.', 'loom-vector-core' ),
			'label' => __( 'Start a conversation', 'loom-vector-core' ),
			'url'   => '/contact/',
		),
		$atts,
		'lv_cta'
	);

	ob_start();
	?>
	<section class="lv-cta">
		<div class="lv-shell lv-cta__inner">
			<div>
				<h2 class="lv-cta__title"><?php echo esc_html( $atts['title'] ); ?></h2>
				<p class="lv-cta__text"><?php echo esc_html( $atts['text'] ); ?></p>
			</div>
			<a class="lv-btn lv-btn--invert" href="<?php echo esc_url( $atts['url'] ); ?>"><?php echo esc_html( $atts['label'] ); ?></a>
		</div>
	</section>
	<?php
	return (string) ob_get_clean();
}
add_shortcode( 'lv_cta', 'lv_core_sc_cta' );
