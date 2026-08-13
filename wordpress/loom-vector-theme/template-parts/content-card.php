<?php
/**
 * Post card used in archives.
 *
 * @package LoomVector
 */

?>
<li <?php post_class( 'lv-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="lv-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php the_post_thumbnail( 'lv-card' ); ?></a>
	<?php endif; ?>
	<h2 class="lv-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<?php lv_post_meta(); ?>
	<p class="lv-card__text"><?php echo esc_html( get_the_excerpt() ); ?></p>
</li>
