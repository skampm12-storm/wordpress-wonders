<?php
/**
 * Generic archive.
 *
 * @package LoomVector
 */

get_header();
?>
<section class="lv-section">
	<div class="lv-shell">
		<?php lv_breadcrumbs(); ?>
		<header class="lv-pagehead">
			<h1 class="lv-pagehead__title"><?php echo esc_html( wp_strip_all_tags( get_the_archive_title() ) ); ?></h1>
			<?php
			$lv_desc = get_the_archive_description();
			if ( $lv_desc ) :
				?>
				<div class="lv-pagehead__intro"><?php echo wp_kses_post( $lv_desc ); ?></div>
			<?php endif; ?>
		</header>

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
			<p><?php esc_html_e( 'Nothing here yet.', 'loom-vector' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
