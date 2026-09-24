# Coalition WordPress Portfolio

Custom WordPress theme implementation based on a PSD design, featuring a responsive contact page, custom Theme Settings, WordPress navigation, editable content, and database-backed configuration.

## Overview and purpose

This personal portfolio project demonstrates translating a supplied desktop Contact composition into a classic WordPress theme. The required administrative page is named Homepage; its visible content follows the Contact design. The theme extends the supplied CT Custom/Underscores starter rather than replacing its architecture. This is a demonstration project, not an official website for Coalition Technologies or another business.

## Features

- Responsive contact layout with desktop columns and stacked mobile content.
- WordPress-managed Primary and Utility menus with nested submenu controls.
- Native Theme Settings for logo, phone, address, fax, and four social URLs.
- Editable homepage block pattern with dynamic contact details.
- Contact Form 7 integration without a custom submission backend.
- Skip link, persistent form labels, visible focus, and named social links.
- Local SVG social icons and system font fallbacks; no frontend build step.

## Technologies and architecture

WordPress, PHP, HTML, CSS, vanilla JavaScript, the WordPress Settings API and Media Library, and Contact Form 7. `wp-content/themes/ct-custom` contains the classic theme. `homepage.php` runs the WordPress Loop and displays page content between the shared header and footer. `functions.php` registers support, menus, assets, and the Contact homepage pattern. `inc/theme-settings.php` owns the single `ct_custom_settings` option. `inc/template-tags.php` provides the contact shortcodes.

WordPress core, plugins, uploads, local credentials, SQL backups, and deployment ZIPs are excluded from version control. Install core and plugins separately. The included configuration sample contains placeholders only.

## Local installation and database setup

1. Install the latest stable WordPress with a supported PHP release and MySQL/MariaDB. The theme declares WordPress 6.7 and PHP 7.4 minimums; use versions compatible with your installed CF7 release.
2. Create a local database and a dedicated database user. Copy `wp-config-sample.php` to `wp-config.php`, enter local connection details, and replace every authentication key/salt placeholder with a unique value. Never commit the resulting configuration file.
3. Configure a local virtual host for `coalitiontest.local` pointing at the WordPress root and map that hostname to loopback in your local hosts file.
4. Copy `wp-content/themes/ct-custom` into the installation's themes folder. Finish the WordPress installer with your own local administrator credentials.
5. Set WordPress Address and Site Address to `http://coalitiontest.local`, then activate CT Custom.
6. Complete the page, settings, menus, and form steps below.

This repository does not contain a database dump. To restore a separately obtained private backup, import it into the intended empty database, configure the correct table prefix, and verify URLs, users, plugins, media, and page assignments. A database backup contains user data and password hashes; keep it private. Do not use the same password for a demonstration administrator and a personal account.

## Homepage and editable content

Create or edit a published page titled **Homepage**, choose the **Homepage** template, and insert the **Contact homepage** pattern once. Edit its heading, introduction, and section headings as normal WordPress blocks. Under Settings → Reading choose a static front page and select Homepage. Keep the contact details shortcode so global settings remain the source of contact data.

## Theme Settings and logo

Open Appearance → Theme Settings. Upload/select the logo and enter phone, address, fax, Facebook, Twitter, LinkedIn, and Pinterest URLs. Put the organization/demo name on the first address line. Save, reload, and verify the frontend. Logo upload uses a WordPress image attachment; the Customizer logo control is not a second source.

Use clearly labeled demonstration contact details and reserved example contact information. Use your own confirmed social profile URLs, or clearly described platform homepage links for a demo; do not imply ownership of someone else's account. Empty social values intentionally hide their icons.

## Navigation

Create Primary and Utility menus under Appearance → Menus and assign their matching locations. Add only real pages or meaningful section links. Home and Contact may point to the same contact-focused homepage or real sections; do not create empty pages to imitate a seven-item desktop reference. Utility links are ordinary menu entries and do not implement authentication. The breadcrumb uses actual page ancestry and shows Home on the front page.

## Contact form

Install and activate Contact Form 7. Create a form using the labeled, required Name, Phone, Email, Message, and Submit markup in [the theme setup guide](wp-content/themes/ct-custom/README.md#contact-form-7). Its explicit paragraphs keep phone and email in separate grid cells after CF7 formatting. Put the saved form ID into the page's `ct_contact_form` shortcode, or use CF7's own shortcode as described in that guide.

Configure an approved recipient and sender in CF7, with the visitor email as Reply-To. Test missing fields, invalid email, and a valid submission. Mail delivery requires a functioning mail transport and must be checked separately. Without a configured form, the theme displays an intentionally disabled preview; that preview is not a working form.

## Responsive design and accessibility

The desktop contact composition uses a centered content area and two columns. At narrower widths, the header and content adapt to the available space, the contact columns stack, and navigation uses a menu button with submenu controls. Breakpoints are implementation choices because no mobile PSD was supplied.

The theme includes a skip link, keyboard-operated menu controls, expanded-state attributes, Escape-key handling, visible focus styles, persistent form labels, and accessible names for social links. These measures are not a WCAG conformance claim; contrast and the installed contact form require a complete accessibility review.

## Verification and known limitations

Theme PHP and JavaScript syntax and local source checks have been performed during development. Site content, menu assignments, media, and Theme Settings are installation-specific database values and must be configured when installing this source. They are deliberately not distributed here.

**Contact Form 7 is not bundled or installed in this repository.** The development site did not have the plugin installed, so live CF7 validation, submission, and email delivery have not been tested. The source includes an integration path and a disabled fallback preview; it does not provide a working contact form by itself.

The exact PSD fonts were not supplied, so system fallbacks are used. Social artwork is approximate. Some original palette combinations require contrast improvements before a WCAG conformance claim. No external email delivery is claimed. The supplied design is desktop-only; mobile layout is an implementation adaptation.

## Licensing and attribution

The theme is based on CT Custom by Coalition Technologies and Underscores by Automattic. Preserve the theme's [GPL license](wp-content/themes/ct-custom/LICENSE) and normalize.css notice. WordPress and third-party plugins retain their respective licenses. The original assessment PSD is not redistributed in this repository.
