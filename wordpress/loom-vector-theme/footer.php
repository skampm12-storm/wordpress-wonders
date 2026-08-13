<?php
/**
 * Footer.
 *
 * @package LoomVector
 */

?>
</main>

<?php if ( ! is_page_template( 'template-landing.php' ) ) : ?>
<footer class="lv-footer">
	<div class="lv-shell lv-footer__inner">
		<div class="lv-footer__brand">
			<p class="lv-footer__name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
			<p class="lv-footer__text"><?php echo esc_html( lv_opt( 'lv_footer_text' ) ); ?></p>
		</div>

		<div class="lv-footer__col">
			<h2 class="lv-footer__title"><?php esc_html_e( 'Contact', 'loom-vector' ); ?></h2>
			<ul class="lv-footer__list">
				<?php if ( lv_opt( 'lv_email' ) ) : ?>
					<li><a href="mailto:<?php echo esc_attr( lv_opt( 'lv_email' ) ); ?>"><?php echo esc_html( lv_opt( 'lv_email' ) ); ?></a></li>
				<?php endif; ?>
				<?php if ( lv_opt( 'lv_phone' ) ) : ?>
					<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', lv_opt( 'lv_phone' ) ) ); ?>"><?php echo esc_html( lv_opt( 'lv_phone' ) ); ?></a></li>
				<?php endif; ?>
				<?php if ( lv_opt( 'lv_address' ) ) : ?>
					<li><?php echo esc_html( lv_opt( 'lv_address' ) ); ?></li>
				<?php endif; ?>
				<?php if ( lv_opt( 'lv_linkedin' ) ) : ?>
					<li><a href="<?php echo esc_url( lv_opt( 'lv_linkedin' ) ); ?>">LinkedIn</a></li>
				<?php endif; ?>
				<?php if ( lv_opt( 'lv_x' ) ) : ?>
					<li><a href="<?php echo esc_url( lv_opt( 'lv_x' ) ); ?>">X</a></li>
				<?php endif; ?>
			</ul>
		</div>

		<div class="lv-footer__col">
			<h2 class="lv-footer__title"><?php esc_html_e( 'Explore', 'loom-vector' ); ?></h2>
			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'lv-footer__list',
					'depth'          => 1,
				) );
			} else {
				echo '<ul class="lv-footer__list">';
				wp_list_pages( array( 'title_li' => '', 'depth' => 1, 'number' => 6 ) );
				echo '</ul>';
			}
			?>
		</div>

		<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
			<div class="lv-footer__col"><?php dynamic_sidebar( 'footer-1' ); ?></div>
		<?php endif; ?>
	</div>

	<div class="lv-shell lv-footer__legal">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'All rights reserved.', 'loom-vector' ); ?></p>
	</div>
</footer>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
