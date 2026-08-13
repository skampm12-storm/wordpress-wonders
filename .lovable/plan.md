# Loom Vector — WordPress Theme + Companion Plugin (downloadable ZIPs)

Build a custom, clean-and-minimal WordPress theme for Loom Vector plus a companion plugin, packaged as two ZIP files you can upload directly in WordPress (Appearance > Themes > Add New > Upload, and Plugins > Add New > Upload).

## What you get

**1. `loom-vector-theme.zip`** — a classic WordPress theme (no page builder, no paid plugin required)

Templates:
- Front page: hero, services overview, capability strip, process, proof/results, CTA
- About page
- Services archive + single service page (one page per offering: website design, WhatsApp/SMS marketing, digital advertising, offline advertising, RPA solutions, AI workflows, GTM enablement consulting)
- Landing page template (no header/footer nav, single CTA — for ABM and paid campaigns)
- Blog index, single post, category/archive, search, 404
- Contact page with form
- Reusable section partials so new pages can be assembled quickly

Customizer options (live preview, editable by you without code):
- Logo, brand colors, typography scale
- Hero heading/subheading/CTA text and link
- Contact details, social links, footer text
- Toggle sections on/off per page
- Global CTA banner content

AEO / AI-readability (built into the theme):
- Semantic HTML5 landmarks, one H1 per page, clean heading hierarchy
- JSON-LD schema: Organization, WebSite, Service (per service page), BreadcrumbList, FAQPage, Article for posts
- Auto meta description, canonical, Open Graph + Twitter cards
- Question-style FAQ blocks with schema so answers are extractable by AI engines
- `llms.txt` output, clean XML sitemap hooks, sensible robots rules
- Fast, lightweight CSS/JS (no jQuery dependency), lazy-loaded images, accessible focus states

**2. `loom-vector-core.zip`** — companion plugin (keeps functionality if you switch themes)

- Custom post types: Services, Case Studies, Testimonials
- Taxonomies: service category, industry
- Contact / lead capture form with spam honeypot, validation, admin email, and leads stored in the WP admin (exportable to CSV)
- FAQ manager that feeds the FAQ schema
- Reusable shortcodes: `[lv_services]`, `[lv_cta]`, `[lv_faq]`, `[lv_testimonials]`, `[lv_contact_form]`
- UTM capture on lead submissions (for ABM/campaign attribution)
- Settings screen for notification email and tracking script snippets

## Honest scope notes

Coded in-house, no purchase needed: forms and lead storage, CPTs, schema/AEO, SEO meta, sitemap, shortcodes, customizer, UTM tracking.

Better bought/used as a service when you need them later: transactional email deliverability (SMTP service such as Postmark/SES), WhatsApp Business API sending, payments/e-commerce (WooCommerce), advanced CRM sync, security/backup, CDN. The theme will hook cleanly into these rather than reinventing them.

## Content

Real Loom Vector copy for every page (services, about, process, FAQs) written to be specific and AI-extractable — no lorem ipsum. Placeholder-free imagery generated to match the minimal style.

## Technical approach

- Classic PHP theme: `style.css`, `functions.php`, `index.php`, `front-page.php`, `page-*.php`, `single-service.php`, `archive-service.php`, `template-landing.php`, `header.php`, `footer.php`, `template-parts/`, `inc/` (customizer, schema, enqueue, helpers), `assets/` (CSS, minimal vanilla JS, images), `screenshot.png`.
- Plugin: standard `loom-vector-core.php` bootstrap with `includes/` modules (CPTs, forms, shortcodes, settings, leads admin table).
- Files authored in this project under a `wordpress/` folder, then zipped and delivered to your downloads with preview links.
- Verification: PHP lint every file, validate JSON-LD output, and render the theme's page HTML to check layout, spacing, and responsive behavior before delivering the ZIPs.

## Not included in this pass

The Lovable preview app itself stays as-is; this pass produces WordPress files only. If you also want the same design running as a live Lovable site, say so and I'll build that alongside.
