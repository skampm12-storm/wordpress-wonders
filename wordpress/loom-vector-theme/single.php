<?php
/**
 * Single post.
 *
 * @package LoomVector
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article class="lv-section" <?php post_class(); ?>>
		<div class="lv-shell lv-shell--narrow">
			<?php lv_breadcrumbs(); ?>
			<header class="lv-pagehead">
				<h1 class="lv-pagehead__title"><?php the_title(); ?></h1>
				<?php lv_post_meta(); ?>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="lv-figure"><?php the_post_thumbnail( 'full' ); ?></figure>
			<?php endif; ?>

			<div class="lv-prose">
				<?php
				the_content();
				wp_link_pages();
				?>
			</div>

			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</div>
	</article>
	<?php
endwhile;

get_template_part( 'template-parts/cta' );
get_footer();
