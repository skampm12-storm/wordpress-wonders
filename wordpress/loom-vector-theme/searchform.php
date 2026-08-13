<?php
/**
 * Search form.
 *
 * @package LoomVector
 */

?>
<form role="search" method="get" class="lv-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="lv-s"><?php esc_html_e( 'Search', 'loom-vector' ); ?></label>
	<input id="lv-s" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search the site', 'loom-vector' ); ?>" />
	<button type="submit" class="lv-btn lv-btn--sm"><?php esc_html_e( 'Search', 'loom-vector' ); ?></button>
</form>
