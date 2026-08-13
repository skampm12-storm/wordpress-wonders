<?php
/**
 * Blog index / fallback.
 *
 * @package LoomVector
 */

get_header();
?>
<section class="lv-section">
	<div class="lv-shell">
		<header class="lv-pagehead">
			<h1 class="lv-pagehead__title"><?php echo esc_html( is_home() && ! is_front_page() ? get_the_title( get_option( 'page_for_posts' ) ) : __( 'Writing', 'loom-vector' ) ); ?></h1>
			<p class="lv-pagehead__intro"><?php esc_html_e( 'Field notes on demand generation, messaging channels, automation and go-to-market tooling.', 'loom-vector' ); ?></p>
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
			<?php
			the_posts_pagination( array(
				'mid_size'  => 1,
				'prev_text' => __( 'Previous', 'loom-vector' ),
				'next_text' => __( 'Next', 'loom-vector' ),
			) );
			?>
		<?php else : ?>
			<p><?php esc_html_e( 'No posts yet.', 'loom-vector' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
