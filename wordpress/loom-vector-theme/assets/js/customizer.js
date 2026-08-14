/* Loom Vector — Customizer live preview. */
(function (api) {
	'use strict';

	if (!api) return;

	api('blogname', function (value) {
		value.bind(function (to) {
			document.querySelectorAll('.lv-brand__text, .lv-footer__name').forEach(function (el) {
				el.textContent = to;
			});
		});
	});

	api('blogdescription', function (value) {
		value.bind(function (to) {
			var el = document.querySelector('.lv-footer__text');
			if (el) el.textContent = to;
		});
	});

	var textMap = {
		lv_hero_eyebrow: '.lv-hero .lv-eyebrow',
		lv_hero_title: '.lv-hero__title',
		lv_hero_subtitle: '.lv-hero__text',
		lv_cta_title: '.lv-cta__title',
		lv_cta_text: '.lv-cta__text',
		lv_footer_text: '.lv-footer__text'
	};

	Object.keys(textMap).forEach(function (key) {
		api(key, function (value) {
			value.bind(function (to) {
				var el = document.querySelector(textMap[key]);
				if (el) el.textContent = to;
			});
		});
	});
})(window.wp && window.wp.customize);
