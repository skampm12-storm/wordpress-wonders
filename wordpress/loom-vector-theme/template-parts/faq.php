<?php
/**
 * FAQ section — answer-engine friendly question/answer pairs.
 *
 * @package LoomVector
 */

$lv_faqs = function_exists( 'lv_core_get_faqs' ) ? lv_core_get_faqs( is_singular() ? get_the_ID() : 0 ) : array();

if ( empty( $lv_faqs ) ) {
	$lv_faqs = array(
		array(
			'question' => __( 'What does Loom Vector actually do?', 'loom-vector' ),
			'answer'   => __( 'Loom Vector is a consultancy that designs and builds websites, runs WhatsApp, SMS, digital and offline advertising, and automates the operations behind them with RPA and AI workflows, plus GTM enablement consulting.', 'loom-vector' ),
		),
		array(
			'question' => __( 'How do engagements start?', 'loom-vector' ),
			'answer'   => __( 'Every engagement starts with a paid or free mapping session where we document the current funnel and pick one measurable outcome. Build work then ships in two-week increments.', 'loom-vector' ),
		),
		array(
			'question' => __( 'Do you work with existing tools?', 'loom-vector' ),
			'answer'   => __( 'Yes. We build inside your current CRM, ad accounts and messaging providers rather than replacing them, and we hand over documentation and access at the end of every project.', 'loom-vector' ),
		),
		array(
			'question' => __( 'Can you support account-based marketing?', 'loom-vector' ),
			'answer'   => __( 'Yes. We build per-account landing pages, personalised messaging sequences and reporting so an ABM target list can be run and measured end to end.', 'loom-vector' ),
		),
	);
}
?>
<section class="lv-section" id="faq">
	<div class="lv-shell lv-shell--narrow">
		<?php lv_section_head( __( 'Questions', 'loom-vector' ), __( 'Answers, in plain language', 'loom-vector' ) ); ?>
		<div class="lv-faq">
			<?php foreach ( $lv_faqs as $lv_faq ) : ?>
				<details class="lv-faq__item">
					<summary class="lv-faq__q"><?php echo esc_html( $lv_faq['question'] ); ?></summary>
					<div class="lv-faq__a"><p><?php echo esc_html( $lv_faq['answer'] ); ?></p></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
