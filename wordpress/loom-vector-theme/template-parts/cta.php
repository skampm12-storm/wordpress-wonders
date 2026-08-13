<?php
/**
 * Closing CTA banner.
 *
 * @package LoomVector
 */

?>
<section class="lv-cta">
	<div class="lv-shell lv-cta__inner">
		<div>
			<h2 class="lv-cta__title"><?php echo esc_html( lv_opt( 'lv_cta_title' ) ); ?></h2>
			<p class="lv-cta__text"><?php echo esc_html( lv_opt( 'lv_cta_text' ) ); ?></p>
		</div>
		<a class="lv-btn lv-btn--invert" href="<?php echo esc_url( lv_opt( 'lv_cta_url', '/contact/' ) ); ?>"><?php echo esc_html( lv_opt( 'lv_cta_label' ) ); ?></a>
	</div>
</section>
