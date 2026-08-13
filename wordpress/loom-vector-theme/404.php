<?php
/**
 * 404.
 *
 * @package LoomVector
 */

get_header();
?>
<section class="lv-section">
	<div class="lv-shell lv-shell--narrow lv-404">
		<p class="lv-eyebrow">404</p>
		<h1 class="lv-pagehead__title"><?php esc_html_e( 'That page has moved on.', 'loom-vector' ); ?></h1>
		<p><?php esc_html_e( 'The link is broken or the page was retired. Try search, or head back to the homepage.', 'loom-vector' ); ?></p>
		<?php get_search_form(); ?>
		<p><a class="lv-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Go home', 'loom-vector' ); ?></a></p>
	</div>
</section>
<?php
get_footer();
