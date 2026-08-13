<?php
/**
 * Search results.
 *
 * @package LoomVector
 */

get_header();
?>
<section class="lv-section">
	<div class="lv-shell">
		<?php lv_breadcrumbs(); ?>
		<header class="lv-pagehead">
			<h1 class="lv-pagehead__title">
				<?php
				/* translators: %s: search term */
				printf( esc_html__( 'Results for “%s”', 'loom-vector' ), esc_html( get_search_query() ) );
				?>
			</h1>
		</header>
		<?php get_search_form(); ?>

		<?php if ( have_posts() ) : ?>
			<ul class="lv-grid lv-grid--3">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content-card' );
				endwhile;
				?>
			</ul>
			<?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No matches. Try a broader term such as “automation” or “WhatsApp”.', 'loom-vector' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
