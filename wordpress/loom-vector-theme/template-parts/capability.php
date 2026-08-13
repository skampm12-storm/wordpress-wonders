<?php
/**
 * Capability strip.
 *
 * @package LoomVector
 */

$lv_items = array(
	array( __( 'Answer-engine ready', 'loom-vector' ), __( 'Structured data, clean semantics and an llms.txt map so AI search can quote you accurately.', 'loom-vector' ) ),
	array( __( 'Owned channels first', 'loom-vector' ), __( 'WhatsApp, SMS and email sequences you control, with consent tracking built in.', 'loom-vector' ) ),
	array( __( 'Automation over headcount', 'loom-vector' ), __( 'RPA and AI workflows that remove the repetitive middle of your revenue process.', 'loom-vector' ) ),
	array( __( 'Attribution you trust', 'loom-vector' ), __( 'UTM capture on every lead, tied back to campaign, account and source.', 'loom-vector' ) ),
);
?>
<section class="lv-section lv-section--tint">
	<div class="lv-shell">
		<ul class="lv-grid lv-grid--4">
			<?php foreach ( $lv_items as $lv_item ) : ?>
				<li class="lv-mini">
					<h3 class="lv-mini__title"><?php echo esc_html( $lv_item[0] ); ?></h3>
					<p class="lv-mini__text"><?php echo esc_html( $lv_item[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
