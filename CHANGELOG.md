# Changelog

All notable changes to A11y Language Switcher will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.1] - 2025-11-01

### Security

**CRITICAL and HIGH priority security update - immediate update recommended**

- **CRITICAL**: Fixed XSS vulnerability in shortcode class parameter (`includes/template.php`)
  - Multiple classes now properly sanitized with `sanitize_html_class()`
  - Prevents JavaScript injection via shortcode attributes

- **CRITICAL**: Fixed XSS vulnerability in JSON output (`a11y-language-switcher.php`)
  - Changed from direct echo to `wp_add_inline_script()` with proper JSON encoding
  - All Polylang data (language codes, names, URLs) now sanitized before output
  - JavaScript validates and sanitizes all text content

- **HIGH**: Added CSRF protection
  - Explicit capability checks in settings sanitization
  - Nonce verification via WordPress `settings_fields()`

- **HIGH**: Added rate limiting to settings updates
  - 10-second cooldown between saves
  - Prevents abuse through rapid submissions

- **HIGH**: Improved input validation
  - Flag emojis strictly validated with Unicode character class checks
  - Maximum 20 flags allowed
  - Length limits enforced (10 characters per flag)
  - HTML tags stripped, control characters removed

### Added

- New `includes/security.php` with `APLS_Security` helper class
- Security headers for admin pages (X-Content-Type-Options, X-Frame-Options, X-XSS-Protection)
- Debug mode warning banner when enabled (visible to admins only)
- JavaScript validation functions for data, text, and URLs

### Changed

- Updated all data sanitization to use WordPress security functions
- Enhanced settings sanitization with strict validation rules
- Improved shortcode attribute handling for multiple CSS classes
- Updated JavaScript to validate all user-facing content

### Fixed

- Shortcode class parameter now handles multiple classes correctly
- Language codes and names properly sanitized before output
- Flag emojis validated to prevent malicious input
- URLs validated before creating language links

---

## [1.0.0] - 2025-10-31

### Added

Initial release of A11y Language Switcher

**Core Features:**
- Integration with Polylang via `pll_the_languages()` function
- Automatic translation URL detection (handles translated slugs)
- `[a11ylang_language_switcher]` shortcode
- `apls_language_switcher()` PHP helper function
- Admin settings page (Settings → Language Switcher)
- Debug mode with console logging
- Customizable language flag emojis

**Accessibility (WCAG 2.1 AA compliant):**
- Full keyboard navigation (Tab, Arrow keys, Enter, Escape, Home, End)
- ARIA labels and roles (aria-expanded, aria-haspopup, aria-current)
- Proper focus indicators
- High contrast mode support
- Reduced motion support
- 44x44px minimum touch targets on mobile

**Technical:**
- Vanilla JavaScript (no jQuery dependency)
- Responsive mobile design
- Clean, modern CSS with smooth transitions
- Polylang dependency check (auto-deactivates if Polylang missing)
- Support for Polylang free and pro versions
- WordPress 6.0+ compatible
- PHP 8.0+ required

**Browser Support:**
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- iOS Safari
- Chrome Android

---

## Version History

- **1.0.1** (2025-11-01) - Security update: XSS fixes, CSRF protection, rate limiting
- **1.0.0** (2025-10-31) - Initial release

---

For support and bug reports, visit the [GitHub Issues](https://github.com/yourusername/a11y-language-switcher/issues) page.
