<?php
/**
 * Services grid section.
 *
 * @package LoomVector
 */

?>
<section class="lv-section" id="services">
	<div class="lv-shell">
		<?php
		lv_section_head(
			__( 'What we do', 'loom-vector' ),
			__( 'Seven capabilities, one operating team', 'loom-vector' ),
			__( 'Most teams stitch together an agency, a freelancer and an automation contractor. Loom Vector runs design, demand and automation as a single system so nothing is handed off twice.', 'loom-vector' )
		);
		lv_render_services( 7 );
		?>
	</div>
</section>
