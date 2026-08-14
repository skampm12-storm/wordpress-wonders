/* Loom Vector — minimal vanilla JS (no jQuery). */
(function () {
	'use strict';

	var toggle = document.querySelector('.lv-navtoggle');
	var nav = document.getElementById('lv-nav');

	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			var open = nav.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' && nav.classList.contains('is-open')) {
				nav.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
				toggle.focus();
			}
		});
	}

	// Smooth in-page anchors, respecting reduced motion.
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	document.querySelectorAll('a[href^="#"]').forEach(function (link) {
		link.addEventListener('click', function (event) {
			var id = link.getAttribute('href');
			if (!id || id === '#') return;
			var target = document.querySelector(id);
			if (!target) return;
			event.preventDefault();
			target.scrollIntoView({ behavior: reduce ? 'auto' : 'smooth', block: 'start' });
			if (nav) nav.classList.remove('is-open');
		});
	});
})();
