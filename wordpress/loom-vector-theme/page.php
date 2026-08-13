<?php
/**
 * Default page.
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
			</header>
			<div class="lv-prose"><?php the_content(); ?></div>
		</div>
	</article>
	<?php
endwhile;

get_footer();
