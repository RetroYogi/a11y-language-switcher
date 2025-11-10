=== A11y Language Switcher by Key4 ===
Contributors: Gérard Kieffer
Tags: polylang, language, switcher, accessibility, wcag, multilingual, a11y, block-theme
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.0
Stable tag: 1.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Modern, accessible language switcher for Polylang and block themes. The missing piece for Polylang Free users with modern WordPress sites.

== Description ==

**The Perfect Complement to Polylang Free**

[Polylang](https://wordpress.org/plugins/polylang/) is an exceptional multilingual plugin for WordPress, and we highly recommend supporting the developers by purchasing the Pro version if you need its advanced features.

However, if you're using Polylang Free with a block-based theme, you'll notice that the language switcher only works with:
- Legacy menu system (Navigation Menus)
- Legacy widget blocks (Classic Widgets)

**This plugin solves that problem.**

= What This Plugin Does =

A11y Language Switcher by Key4 provides a **modern, accessible language switcher** that works seamlessly with:
- ✅ Block-based themes (FSE - Full Site Editing)
- ✅ Block-based navigation elements
- ✅ Modern WordPress workflows
- ✅ Any theme built with blocks

**Important:** This plugin does NOT add multilingual functionality to your site. It requires Polylang (free or pro) to be installed and configured. It's simply a language switcher block - but it's the best one you'll find.

= Why Choose This Plugin? =

**For Polylang Free Users:**
If you don't need Polylang Pro's advanced features but want a modern language switcher for your block theme, this is your solution.

**For Block Theme Users:**
Works perfectly with FSE themes like Twenty Twenty-Three, Twenty Twenty-Four, and any Gutenberg-based theme.

**For Accessibility:**
Built from the ground up following WCAG 2.1 AA standards with full keyboard navigation and screen reader support.

= Key Features =

**Modern WordPress Integration:**
* Works with block themes and FSE (Full Site Editing)
* Simple shortcode: `[a11ylang_language_switcher]`
* Can be added anywhere: header, footer, sidebar, content
* Responsive mobile design

**Accessibility (WCAG 2.1 AA):**
* Full keyboard navigation (Tab, Arrow keys, Enter, Escape)
* Screen reader support with ARIA labels
* High contrast mode support
* Reduced motion support
* Proper focus indicators
* 44x44px minimum touch targets

**Smart URL Handling:**
* Uses Polylang's actual translation URLs
* Handles translated page slugs correctly
* Example: `/services/` (FR) → `/en/digital-services/` (EN) ✓
* No URL guessing - always accurate

**Customization:**
* Customizable flag emojis for each language
* Override CSS for custom styling
* Debug mode for troubleshooting
* No configuration needed - uses Polylang settings

= How It Works =

1. Install and activate Polylang (free or pro)
2. Configure your languages in Polylang
3. Install this plugin
4. Add shortcode `[a11ylang_language_switcher]` where you want it
5. Done!

The plugin automatically:
- Gets language names from Polylang
- Gets translation URLs from Polylang
- Detects the current language
- Creates accessible language links

= Perfect For =

* **Block theme users** who want a modern language switcher
* **Polylang Free users** who don't need Pro features
* **Accessibility-conscious developers** building WCAG-compliant sites
* **Anyone** who needs a reliable, modern language switcher

= Requirements =

* WordPress 5.0 or higher
* Polylang plugin (free or pro version) - **required**
* PHP 7.0 or higher
* Block theme recommended (works with classic themes too)

= Not Included =

This plugin does NOT:
- Add multilingual functionality (use Polylang for that)
- Translate content (use Polylang for that)
- Replace Polylang (it requires Polylang)

It ONLY provides a modern, accessible language switcher.

== Installation ==

= Quick Install =

1. Install and activate [Polylang](https://wordpress.org/plugins/polylang/) if not already installed
2. Go to Plugins → Add New
3. Search for "A11y Language Switcher by Key4"
4. Click "Install Now" and then "Activate"
5. Add shortcode `[a11ylang_language_switcher]` to your site

= Manual Installation =

1. Download the plugin ZIP file
2. Go to Plugins → Add New → Upload Plugin
3. Choose the ZIP file and click "Install Now"
4. Click "Activate"
5. Go to Settings → Language Switcher (optional configuration)

= Adding to Your Site =

**In Block Editor (Gutenberg):**
1. Add a "Shortcode" block
2. Enter: `[a11ylang_language_switcher]`

**In FSE Header/Footer:**
1. Go to Appearance → Editor
2. Select Header or Footer template
3. Add a "Shortcode" block
4. Enter: `[a11ylang_language_switcher]`

**In PHP Template:**
```php
<?php echo do_shortcode('[a11ylang_language_switcher]'); ?>
```

Or use the helper function:
```php
<?php
if (function_exists('apls_language_switcher')) {
    apls_language_switcher();
}
?>
```

== Frequently Asked Questions ==

= Does this work with Polylang Free? =

Yes! This plugin is specifically designed to complement Polylang Free for users with block themes.

= Does this work with Polylang Pro? =

Yes, it works with both Polylang Free and Pro.

= Do I need Polylang installed? =

**Yes, absolutely.** This plugin requires Polylang (free or pro) to be installed and activated. It does not add multilingual functionality - it's only a language switcher.

= Will this work without Polylang? =

No. The plugin will deactivate if Polylang is not installed.

= What if I'm using a classic theme (not a block theme)? =

The plugin still works! You can add the shortcode anywhere in your classic theme.

= My page slugs are different in each language. Will this work? =

Yes! That's one of the main features. The plugin uses Polylang's actual translation URLs, so it correctly handles different slugs:
- French: `/services/`
- English: `/en/digital-services/`
- German: `/de/dienstleistungen/`

= Can I customize the appearance? =

Yes! Use custom CSS to override these classes:
* `.a11ylang-switcher__button` - Toggle button
* `.a11ylang-switcher__dropdown` - Dropdown menu
* `.a11ylang-switcher__link` - Language links
* `.a11ylang-switcher__flag` - Flag emojis

= How do I change the flag emojis? =

Go to Settings → Language Switcher and customize the flag for each language.

= Is this accessible? =

Yes! The plugin follows WCAG 2.1 AA standards with:
- Full keyboard navigation
- Screen reader support
- ARIA attributes
- High contrast mode support
- Reduced motion support

= How do I troubleshoot issues? =

1. Go to Settings → Language Switcher
2. Enable "Debug Mode"
3. Open browser console (F12)
4. Reload page and check for debug messages

= Does this plugin collect any data? =

No. This plugin does not collect, store, or transmit any user data. It only uses Polylang's existing translation data.

== Screenshots ==

1. Language switcher on desktop (closed state)
2. Language switcher with dropdown open showing available languages
3. Admin settings page at Settings → Language Switcher
4. Mobile responsive view with proper touch targets
5. Keyboard focus indicators showing accessibility features

== Changelog ==

= 1.0.1 - 2024-10-31 =

**Security Updates:**
* Fixed XSS vulnerability in shortcode class parameter
* Fixed JSON output XSS vulnerability
* Added CSRF protection for settings form
* Added rate limiting on settings updates
* Added comprehensive input sanitization
* Added JavaScript input validation
* Added security headers for admin pages

**Added:**
* Security helper class with validation functions
* URL validation before creating language links
* Debug mode warning banner
* Maximum flag limit (20) to prevent abuse

**Changed:**
* Improved shortcode attribute sanitization
* Enhanced settings sanitization with strict validation
* Updated JSON output to use wp_add_inline_script()

= 1.0.0 - 2024-11-01 =

* Initial release
* Full keyboard navigation support
* WCAG 2.1 AA compliance
* Block theme compatibility
* Polylang translation URL integration
* Customizable language flags
* Debug mode for troubleshooting
* Responsive mobile design
* High contrast and reduced motion support

== Upgrade Notice ==

= 1.0.1 =
Security update with XSS and CSRF fixes. Recommended for all users.

= 1.0.0 =
Initial release. Modern language switcher for Polylang and block themes.

== About Polylang ==

This plugin is designed to work with [Polylang](https://wordpress.org/plugins/polylang/), an excellent multilingual plugin for WordPress.

**We recommend supporting Polylang:**
- Polylang Free: Great for basic multilingual sites
- Polylang Pro: Advanced features like ACF translation, WooCommerce support, and more

**Our plugin fills a gap:** If you're using Polylang Free with a block theme and only need a modern language switcher (not the other Pro features), this plugin is perfect for you.

Consider [purchasing Polylang Pro](https://polylang.pro/) if you need:
- Advanced Custom Fields (ACF) translation
- WooCommerce multilingual support
- Professional support
- Share translations across networks
- And many more features

== Technical Details ==

= Architecture =

The plugin uses Polylang's `pll_the_languages()` function to retrieve actual translation URLs. This data is passed to JavaScript as JSON, which creates the accessible language switcher.

= Browser Support =

* Chrome/Edge (latest)
* Firefox (latest)
* Safari (latest)
* Mobile browsers (iOS Safari, Chrome Android)

= Standards Compliance =

* WCAG 2.1 Level AA
* WAI-ARIA 1.2
* W3C Menu Button Pattern

== Support ==

For support and feature requests, visit: [key4.lu](https://key4.lu)

== Credits ==

Developed by Gérard Kieffer for Key4.lu

Built with accessibility in mind for the WordPress community.
