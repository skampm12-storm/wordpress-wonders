<?php
/**
 * Proof / results section, backed by Case Study posts when present.
 *
 * @package LoomVector
 */

$lv_cases = new WP_Query( array(
	'post_type'      => 'lv_case',
	'posts_per_page' => 3,
	'post_status'    => 'publish',
	'no_found_rows'  => true,
) );
?>
<section class="lv-section lv-section--tint" id="results">
	<div class="lv-shell">
		<?php lv_section_head( __( 'Proof', 'loom-vector' ), __( 'Work that shows up in the numbers', 'loom-vector' ) ); ?>

		<?php if ( $lv_cases->have_posts() ) : ?>
			<ul class="lv-grid lv-grid--3">
				<?php
				while ( $lv_cases->have_posts() ) :
					$lv_cases->the_post();
					?>
					<li class="lv-card">
						<h3 class="lv-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p class="lv-card__text"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( strip_shortcodes( get_the_content() ) ), 26, '…' ) ); ?></p>
					</li>
				<?php endwhile; ?>
			</ul>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<ul class="lv-grid lv-grid--3">
				<li class="lv-stat"><span class="lv-stat__num">3.4x</span><p class="lv-stat__text"><?php esc_html_e( 'More qualified replies after moving outbound follow-up to consented WhatsApp journeys.', 'loom-vector' ); ?></p></li>
				<li class="lv-stat"><span class="lv-stat__num">62%</span><p class="lv-stat__text"><?php esc_html_e( 'Of manual quote-preparation hours removed with an RPA and review workflow.', 'loom-vector' ); ?></p></li>
				<li class="lv-stat"><span class="lv-stat__num">11 days</span><p class="lv-stat__text"><?php esc_html_e( 'From kickoff to a live, instrumented ABM landing programme for a named account list.', 'loom-vector' ); ?></p></li>
			</ul>
			<p class="lv-note"><?php esc_html_e( 'Replace these with your own case studies from the Case Studies menu in WordPress.', 'loom-vector' ); ?></p>
		<?php endif; ?>
	</div>
</section>
