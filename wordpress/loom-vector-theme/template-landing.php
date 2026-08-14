<?php
/**
 * Template Name: Landing page (no nav)
 * Description: Single-CTA campaign / ABM landing page without header or footer navigation.
 *
 * @package LoomVector
 */

get_header();
?>

<section class="lv-hero">
	<div class="lv-shell lv-landing__bar">
		<span class="lv-brand__text"><span class="lv-brand__mark" aria-hidden="true"></span><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
		<a class="lv-btn lv-btn--sm" href="#lv-landing-cta"><?php echo esc_html( lv_opt( 'lv_cta_label', __( 'Start a conversation', 'loom-vector' ) ) ); ?></a>
	</div>

	<div class="lv-shell lv-hero__inner" style="padding-top:clamp(2.5rem,6vw,4.5rem)">
		<?php while ( have_posts() ) : the_post(); ?>
			<h1 class="lv-hero__title"><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="lv-hero__text"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
			<div class="lv-hero__actions">
				<a class="lv-btn" href="#lv-landing-cta"><?php echo esc_html( lv_opt( 'lv_cta_label', __( 'Start a conversation', 'loom-vector' ) ) ); ?></a>
			</div>
	</div>
</section>

<div class="lv-shell lv-shell--narrow lv-prose">
	<?php
			the_content();
			wp_link_pages( array( 'before' => '<nav class="lv-pagination">', 'after' => '</nav>' ) );
		endwhile;
	?>
</div>

<section class="lv-cta" id="lv-landing-cta">
	<div class="lv-shell lv-cta__inner">
		<div>
			<h2 class="lv-cta__title"><?php echo esc_html( lv_opt( 'lv_cta_title' ) ); ?></h2>
			<p class="lv-cta__text"><?php echo esc_html( lv_opt( 'lv_cta_text' ) ); ?></p>
		</div>
		<a class="lv-btn lv-btn--invert" href="<?php echo esc_url( lv_opt( 'lv_cta_url', '/contact/' ) ); ?>"><?php echo esc_html( lv_opt( 'lv_cta_label' ) ); ?></a>
	</div>
</section>

<?php get_footer(); ?>
