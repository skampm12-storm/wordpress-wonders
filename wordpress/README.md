# Loom Vector — WordPress theme + companion plugin

Two uploadable packages:

- `loom-vector-theme.zip` — classic PHP theme (no page builder, no paid plugins)
- `loom-vector-core.zip` — companion plugin (content types, forms, FAQs, shortcodes)

## Install order

1. **Plugins > Add New > Upload Plugin** → `loom-vector-core.zip` → Install → Activate.
2. **Appearance > Themes > Add New > Upload Theme** → `loom-vector-theme.zip` → Install → Activate.
3. **Settings > Permalinks** → click Save (flushes rewrite rules for `/services/`).

## First-run setup

1. **Appearance > Customize > Loom Vector** — logo, brand colours, type scale, hero copy,
   contact details, social links, global CTA banner, section toggles.
2. **Appearance > Menus** — create a menu and assign it to *Primary* (and *Footer*).
3. Create pages: Home, About, Contact, plus any landing pages.
   - Home: **Settings > Reading** → "A static page" → select Home (uses `front-page.php`).
   - Contact: page template **Contact page**.
   - Campaign/ABM pages: page template **Landing page (no nav)**.
4. Add Services under **Services > Add service**. The archive lives at `/services/`.
5. **Leads > Settings** — notification email, global FAQs, optional tracking snippet.

## AEO / SEO built in

- Semantic landmarks, single H1 per page, clean heading order
- JSON-LD: Organization, WebSite, Service, BreadcrumbList, FAQPage, Article
- Meta description, canonical, Open Graph and Twitter cards
- `/llms.txt` output for AI crawlers
- Lazy-loaded images, no jQuery, accessible focus states, reduced-motion support

## Leads

Submissions are stored in the `wp_lv_leads` table with first-touch UTM values and are
exportable to CSV from **Leads > Export CSV**.

## Things worth buying rather than building

SMTP deliverability (Postmark/SES), WhatsApp Business API sending, WooCommerce for
payments, CRM sync, backups/security, CDN. The theme and plugin hook cleanly into these.
