<?php
/**
 * Template Name: Contact page
 * Description: Page with contact details and the Loom Vector Core lead capture form.
 *
 * @package LoomVector
 */

get_header();
?>

<div class="lv-shell lv-pagehead">
	<?php lv_breadcrumbs(); ?>
	<h1 class="lv-pagehead__title"><?php the_title(); ?></h1>
	<p class="lv-pagehead__intro"><?php esc_html_e( 'Tell us the workflow, campaign or website problem you want solved. We reply within one business day.', 'loom-vector' ); ?></p>
</div>

<div class="lv-shell" style="padding-bottom:clamp(3rem,6vw,5rem)">
	<div class="lv-grid" style="grid-template-columns:repeat(auto-fit,minmax(280px,1fr))">
		<div class="lv-prose">
			<?php
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;

			if ( lv_core_active() ) {
				echo do_shortcode( '[lv_contact_form]' );
			} else {
				echo '<p class="lv-note">' . esc_html__( 'Activate the Loom Vector Core plugin to enable the lead capture form.', 'loom-vector' ) . '</p>';
			}
			?>
		</div>

		<aside>
			<div class="lv-card">
				<h2 class="lv-card__title"><?php esc_html_e( 'Direct', 'loom-vector' ); ?></h2>
				<ul class="lv-footer__list">
					<?php if ( lv_opt( 'lv_email' ) ) : ?>
						<li><a href="mailto:<?php echo esc_attr( lv_opt( 'lv_email' ) ); ?>"><?php echo esc_html( lv_opt( 'lv_email' ) ); ?></a></li>
					<?php endif; ?>
					<?php if ( lv_opt( 'lv_phone' ) ) : ?>
						<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', lv_opt( 'lv_phone' ) ) ); ?>"><?php echo esc_html( lv_opt( 'lv_phone' ) ); ?></a></li>
					<?php endif; ?>
					<?php if ( lv_opt( 'lv_address' ) ) : ?>
						<li><?php echo esc_html( lv_opt( 'lv_address' ) ); ?></li>
					<?php endif; ?>
				</ul>
			</div>

			<div class="lv-card" style="margin-top:1.25rem">
				<h2 class="lv-card__title"><?php esc_html_e( 'What happens next', 'loom-vector' ); ?></h2>
				<ol class="lv-card__text" style="padding-left:1.1rem;margin:0">
					<li><?php esc_html_e( 'We read your note and reply within one business day.', 'loom-vector' ); ?></li>
					<li><?php esc_html_e( 'A 45-minute working session to map the funnel or workflow.', 'loom-vector' ); ?></li>
					<li><?php esc_html_e( 'A short written scope with timeline, price and the metric we will move.', 'loom-vector' ); ?></li>
				</ol>
			</div>
		</aside>
	</div>
</div>

<?php get_footer(); ?>
