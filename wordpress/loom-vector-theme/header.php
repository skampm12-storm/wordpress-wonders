<?php
/**
 * Header.
 *
 * @package LoomVector
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="lv-skip" href="#lv-main"><?php esc_html_e( 'Skip to content', 'loom-vector' ); ?></a>

<?php if ( ! is_page_template( 'template-landing.php' ) ) : ?>
<header class="lv-header">
	<div class="lv-shell lv-header__inner">
		<div class="lv-brand">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				printf(
					'<a class="lv-brand__text" href="%1$s"><span class="lv-brand__mark" aria-hidden="true"></span>%2$s</a>',
					esc_url( home_url( '/' ) ),
					esc_html( get_bloginfo( 'name' ) )
				);
			}
			?>
		</div>

		<button class="lv-navtoggle" aria-expanded="false" aria-controls="lv-nav">
			<span class="lv-navtoggle__bar" aria-hidden="true"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'loom-vector' ); ?></span>
		</button>

		<nav id="lv-nav" class="lv-nav" aria-label="<?php esc_attr_e( 'Primary', 'loom-vector' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'lv-nav__list',
					'depth'          => 2,
				) );
			} else {
				echo '<ul class="lv-nav__list">';
				wp_list_pages( array( 'title_li' => '', 'depth' => 1, 'number' => 5 ) );
				echo '</ul>';
			}
			?>
			<a class="lv-btn lv-btn--sm" href="<?php echo esc_url( lv_opt( 'lv_cta_url', '/contact/' ) ); ?>"><?php echo esc_html( lv_opt( 'lv_cta_label', __( 'Start a conversation', 'loom-vector' ) ) ); ?></a>
		</nav>
	</div>
</header>
<?php endif; ?>

<main id="lv-main" class="lv-main">
