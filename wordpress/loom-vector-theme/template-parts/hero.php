<?php
/**
 * Front-page hero.
 *
 * @package LoomVector
 */

?>
<section class="lv-hero">
	<div class="lv-shell lv-hero__inner">
		<p class="lv-eyebrow"><?php echo esc_html( lv_opt( 'lv_hero_eyebrow', __( 'Growth systems studio', 'loom-vector' ) ) ); ?></p>
		<h1 class="lv-hero__title"><?php echo esc_html( lv_opt( 'lv_hero_title', __( 'Demand, automated end to end.', 'loom-vector' ) ) ); ?></h1>
		<p class="lv-hero__text"><?php echo esc_html( lv_opt( 'lv_hero_subtitle' ) ); ?></p>
		<p class="lv-hero__actions">
			<a class="lv-btn" href="<?php echo esc_url( lv_opt( 'lv_hero_cta_url', '/contact/' ) ); ?>"><?php echo esc_html( lv_opt( 'lv_hero_cta_text', __( 'Book a working session', 'loom-vector' ) ) ); ?></a>
			<a class="lv-link" href="<?php echo esc_url( lv_opt( 'lv_hero_alt_url', '/services/' ) ); ?>"><?php echo esc_html( lv_opt( 'lv_hero_alt_text', __( 'See services', 'loom-vector' ) ) ); ?></a>
		</p>
	</div>
</section>
