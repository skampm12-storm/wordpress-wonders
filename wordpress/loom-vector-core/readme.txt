=== Loom Vector Core ===
Contributors: loomvector
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later

Companion plugin for the Loom Vector theme: content types, FAQ manager, lead capture with UTM attribution, and shortcodes.

== Description ==

* Post types: Services, Case studies, Testimonials
* Taxonomies: Service category, Industry
* FAQ manager (per page/post/service plus a global set) feeding FAQPage schema
* Lead capture form with honeypot spam protection, validation, admin email and database storage
* First-touch UTM capture (30-day cookie) stored with each lead
* Leads admin screen with CSV export
* Shortcodes: [lv_services], [lv_cta], [lv_faq], [lv_testimonials], [lv_contact_form]
* Settings screen: notification email, global FAQs, head tracking snippet

== Installation ==

1. Plugins > Add New > Upload Plugin > choose loom-vector-core.zip > Install > Activate.
2. Visit Leads > Settings and set the notification email.
3. Add [lv_contact_form] to any page, or use the theme's Contact page template.

== Notes ==

Email delivery uses wp_mail(). For reliable inbox delivery connect an SMTP service
(Postmark, SES, Mailgun) with any SMTP plugin.

== Changelog ==

= 1.0.0 =
* First release.
