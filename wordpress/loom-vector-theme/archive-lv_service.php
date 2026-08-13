<?php
/**
 * Services archive.
 *
 * @package LoomVector
 */

get_header();
?>
<section class="lv-section">
	<div class="lv-shell">
		<?php lv_breadcrumbs(); ?>
		<header class="lv-pagehead">
			<h1 class="lv-pagehead__title"><?php esc_html_e( 'Services', 'loom-vector' ); ?></h1>
			<p class="lv-pagehead__intro"><?php esc_html_e( 'Design, demand and automation delivered by one team — pick the entry point that matches the problem in front of you.', 'loom-vector' ); ?></p>
		</header>

		<?php if ( have_posts() ) : ?>
			<ul class="lv-grid lv-grid--services">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<li class="lv-card">
						<h2 class="lv-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="lv-card__text"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( strip_shortcodes( get_the_content() ) ), 26, '…' ) ); ?></p>
					</li>
				<?php endwhile; ?>
			</ul>
		<?php else : ?>
			<?php lv_render_services( 7 ); ?>
			<p class="lv-note"><?php esc_html_e( 'Add Service entries in WordPress to give each of these its own page.', 'loom-vector' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_template_part( 'template-parts/cta' );
get_footer();
