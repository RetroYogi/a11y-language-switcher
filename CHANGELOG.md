# Changelog

All notable changes to Accessible Polylang Language Switcher will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.1] - 2024-10-31

### Security
- **CRITICAL FIX**: Fixed XSS vulnerability in template.php shortcode class parameter
- **CRITICAL FIX**: Fixed JSON output XSS vulnerability by using `wp_add_inline_script()` instead of direct echo
- **HIGH PRIORITY**: Added comprehensive input sanitization for all settings fields
- **HIGH PRIORITY**: Added CSRF protection with proper nonce verification (handled by WordPress settings_fields)
- **HIGH PRIORITY**: Added capability checks throughout admin settings
- Added rate limiting to settings updates (10-second cooldown)
- Added strict flag emoji validation to prevent XSS
- Added security headers for admin pages (X-Content-Type-Options, X-Frame-Options, X-XSS-Protection)

### Added
- New `includes/security.php` file with security helper functions
- `APLS_Security` class with sanitization and validation methods
- JavaScript input validation and XSS prevention
- URL validation before creating language links
- Debug mode warning banner when enabled in production
- Sanitization of all Polylang translation data before output
- Maximum flag limit (20) to prevent abuse

### Changed
- Updated JavaScript to validate and sanitize all text content
- Improved shortcode attribute sanitization using `sanitize_html_class()`
- Changed JSON output method from direct echo to `wp_add_inline_script()`
- Enhanced settings sanitization with strict validation rules
- Updated capability checks to use `wp_die()` for better security

### Fixed
- Shortcode class parameter now properly sanitizes multiple classes
- Language codes and names are now sanitized before JavaScript output
- Flag emojis are validated and sanitized to prevent malicious input
- URLs are validated before being used in language links

## [1.0.0] - 2024-11-01

### Added
- Initial release of Accessible Polylang Language Switcher
- Full WordPress plugin structure with proper headers
- Integration with Polylang's `pll_the_languages()` function
- Automatic translation URL detection (handles translated slugs)
- Admin settings page (Settings → Language Switcher)
- Debug mode with comprehensive console logging
- Customizable language flag emojis
- `[a11ylang_language_switcher]` shortcode
- `apls_language_switcher()` PHP helper function
- WCAG 2.1 AA compliant accessibility features:
  - Full keyboard navigation (Tab, Arrow keys, Enter, Escape, Home, End)
  - ARIA labels and roles for screen readers
  - Proper focus indicators
  - High contrast mode support
  - Reduced motion support
- Responsive mobile design (44x44px touch targets)
- Clean, modern CSS with smooth transitions
- Vanilla JavaScript (no jQuery dependency)
- Support for Polylang free and pro versions
- Internationalization ready (text domain: accessible-a11ylang-switcher)
- Comprehensive documentation:
  - README.md (GitHub/developer docs)
  - readme.txt (WordPress.org format)
  - INSTALLATION.md (detailed installation guide)
  - CHANGELOG.md (this file)

### Features
- Automatically uses Polylang's translation URLs (no manual configuration)
- Language names come from Polylang settings
- Handles pages with translated slugs correctly
- Works on all page types (posts, pages, archives, custom post types)
- Dropdown menu with current language indicator (✓)
- Globe emoji (🌐) fallback for languages without custom flags
- Z-index: 1000 for proper dropdown layering
- Close dropdown on outside click or Escape key
- Auto-focus first available language when dropdown opens

### Technical Details
- WordPress 5.0+ compatible
- PHP 7.0+ required
- Requires Polylang plugin as dependency
- Plugin auto-deactivates if Polylang is missing
- Uses WordPress plugin API best practices
- Proper sanitization and escaping
- Follows WordPress Coding Standards
- Assets properly enqueued with version numbers
- Settings stored in WordPress options table

### Browser Support
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- iOS Safari
- Chrome Android

### Accessibility
- WCAG 2.1 Level AA compliant
- WAI-ARIA 1.2 attributes
- W3C Menu Button Pattern implementation
- Keyboard accessible dropdown navigation
- Screen reader announcements for state changes
- Respects user motion preferences
- High contrast mode compatible

### Documentation
- Installation guide with 3 installation methods
- Usage examples (shortcode, PHP, Gutenberg)
- Troubleshooting section with common issues
- Debug mode instructions
- CSS customization examples
- Accessibility features documentation
- Browser compatibility information

## [Unreleased]

### Planned Features
- Widget support for legacy widget areas
- Gutenberg block (native block editor integration)
- Visual customization options in admin panel
- Custom CSS editor in settings
- Language switcher position presets (header, footer, sidebar)
- Export/import settings
- More flag style options (circular, square, text-only presets)
- Translation file (.pot) for internationalization
- Support for language flags as images (not just emojis)
- Option to display language codes only (en, fr, de)
- Option to hide current language from dropdown
- Accessibility audit and WCAG 2.2 compliance

### Under Consideration
- Integration with other multilingual plugins (WPML, qTranslate-X)
- Mobile app-style language selector
- Language search/filter for sites with many languages
- Automatic RTL detection and styling
- Color theme presets
- Animation options
- Dropdown position options (left, right, center)

## Version History

- **1.0.0** - Initial Release (2024-11-01)

---

For support and feature requests, visit: https://key4.lu
