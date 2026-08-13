<?php
/**
 * Comments.
 *
 * @package LoomVector
 */

if ( post_password_required() ) {
	return;
}
?>
<section class="lv-comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="lv-comments__title"><?php echo esc_html( sprintf( /* translators: %d: count */ _n( '%d comment', '%d comments', get_comments_number(), 'loom-vector' ), (int) get_comments_number() ) ); ?></h2>
		<ol class="lv-comments__list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size' => 40,
			) );
			?>
		</ol>
		<?php the_comments_pagination(); ?>
	<?php endif; ?>

	<?php
	comment_form( array(
		'title_reply' => __( 'Leave a comment', 'loom-vector' ),
		'class_submit' => 'lv-btn',
	) );
	?>
</section>
