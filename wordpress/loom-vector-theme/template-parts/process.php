<?php
/**
 * Process section.
 *
 * @package LoomVector
 */

$lv_steps = array(
	array( __( 'Map', 'loom-vector' ), __( 'We audit the funnel, the tooling and the manual steps in between, then agree on the one metric worth moving first.', 'loom-vector' ) ),
	array( __( 'Build', 'loom-vector' ), __( 'Site, campaign or workflow ships in two-week increments. You see working software, not status decks.', 'loom-vector' ) ),
	array( __( 'Instrument', 'loom-vector' ), __( 'Events, UTMs and CRM fields are wired up before launch so every result is attributable.', 'loom-vector' ) ),
	array( __( 'Compound', 'loom-vector' ), __( 'Monthly review of what converted, what to automate next and what to retire.', 'loom-vector' ) ),
);
?>
<section class="lv-section" id="process">
	<div class="lv-shell">
		<?php lv_section_head( __( 'How we work', 'loom-vector' ), __( 'A short loop, run in the open', 'loom-vector' ) ); ?>
		<ol class="lv-steps">
			<?php foreach ( $lv_steps as $lv_i => $lv_step ) : ?>
				<li class="lv-step">
					<span class="lv-step__num"><?php echo esc_html( str_pad( (string) ( $lv_i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					<h3 class="lv-step__title"><?php echo esc_html( $lv_step[0] ); ?></h3>
					<p class="lv-step__text"><?php echo esc_html( $lv_step[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
