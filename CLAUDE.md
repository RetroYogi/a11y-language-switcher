# Developer Guide

Technical documentation for developers and AI assistants working with the A11y Language Switcher codebase.

## Project Overview

A11y Language Switcher is a WordPress plugin that provides an accessible language switcher for Polylang users.

**Version Requirements:** See plugin headers in `a11y-language-switcher.php` for current version and minimum requirements
**Dependencies:** Polylang (free or pro)

## Plugin Structure

```
a11y-language-switcher/
├── a11y-language-switcher.php     # Main plugin file
├── LICENSE                         # GPL v2+ license
├── README.md                       # Project overview
├── USAGE.md                        # User documentation
├── CHANGELOG.md                    # Version history
├── admin/
│   └── settings.php               # Settings page
├── assets/
│   ├── css/
│   │   └── language-switcher.css  # Styles
│   └── js/
│       └── language-switcher.js   # JavaScript
└── includes/
    ├── functions.php              # Helper functions
    ├── template.php               # HTML template
    └── security.php               # Security helpers
```

## Architecture

### Main Plugin File (`a11y-language-switcher.php`)

- WordPress plugin headers (Version, Author, License)
- Plugin initialization and hooks
- Polylang dependency checking
- Asset enqueuing (CSS/JS)
- Translation data output via `wp_add_inline_script()`
- Shortcode registration

### Admin Settings (`admin/settings.php`)

- Settings page at Settings → Language Switcher
- Debug mode toggle
- Custom flag emoji configuration
- CSRF protection with nonces
- Rate limiting (10-second cooldown)

### Template (`includes/template.php`)

- HTML structure with ARIA attributes
- Accessible button and dropdown markup
- Dynamic content populated by JavaScript

### Security Helpers (`includes/security.php`)

- `APLS_Security` class
- Input sanitization functions
- Rate limiting implementation
- Security headers
- Debug mode warnings

### Helper Functions (`includes/functions.php`)

- `apls_language_switcher()` - PHP function for theme templates
- `apls_is_configured()` - Check if Polylang is active
- `apls_get_version()` - Get plugin version

## Design Patterns

### WordPress Plugin API

**Hooks:**
- `plugins_loaded` - Initialize plugin
- `admin_init` - Register settings
- `admin_notices` - Display admin notifications
- `wp_enqueue_scripts` - Load assets

**Settings API:**
- `register_setting()` - Register plugin settings
- `add_settings_section()` - Add settings sections
- `add_settings_field()` - Add settings fields

**Shortcode API:**
- `add_shortcode()` - Register shortcode

### Security First

- **Input sanitization**: `sanitize_key()`, `sanitize_text_field()`, `wp_strip_all_tags()`
- **Output escaping**: `esc_html()`, `esc_attr()`, `esc_url_raw()`
- **CSRF protection**: `settings_fields()` nonces, `wp_verify_nonce()`
- **Capability checks**: `current_user_can('manage_options')`
- **Rate limiting**: Transient-based cooldown
- **XSS prevention**: JavaScript validation

### Polylang Integration

- Uses `pll_the_languages()` to get actual translation URLs
- No URL guessing - uses Polylang's translation database
- Handles translated page slugs correctly
- Automatically gets language names from Polylang settings

### JavaScript (IIFE Pattern)

- Wrapped in Immediately Invoked Function Expression
- Avoids global scope pollution
- Uses strict mode
- ES5+ compatible (no transpilation required)

## Configuration

### Debug Mode

Enable at Settings → Language Switcher:
- Comprehensive console logging
- Automatic warning banner when enabled
- Should be disabled in production

### Language Flags

Customize at Settings → Language Switcher:
- Default flags: 🇫🇷 🇬🇧 🇩🇪 🇪🇸 🇵🇹 🇮🇹 🇳🇱
- Can use text instead: FR, EN, DE

### Element IDs

**Important**: Do not change these IDs without updating JavaScript references:
- `a11ylang-switcher` - Main container
- `a11ylang-button` - Toggle button
- `a11ylang-dropdown` - Dropdown menu
- `current-lang` - Current language display

## Accessibility Implementation

Implements WCAG 2.1 AA standards:

### Keyboard Navigation

- Tab to focus button
- Enter/Space to open dropdown
- Arrow Up/Down to navigate options
- Home/End for first/last items
- Escape to close dropdown

### ARIA Attributes

- `aria-expanded` on button (true/false state)
- `aria-haspopup="true"` to indicate menu
- `role="menu"` and `role="menuitem"` for semantics
- `aria-current="page"` for active language
- `aria-controls` linking button to dropdown
- `aria-labelledby` for dropdown identification

### Visual Accessibility

- High contrast mode support
- Reduced motion support (`prefers-reduced-motion`)
- Focus indicators with proper contrast
- Minimum 44x44px touch targets on mobile
- Semantic HTML structure

## Security

### Version 1.0.1 Security Improvements

**XSS Prevention:**
- Shortcode class parameter sanitized with `sanitize_html_class()`
- JSON output uses `wp_add_inline_script()` instead of direct echo
- All Polylang data sanitized before output
- JavaScript validates and sanitizes all text content
- URL validation before use

**CSRF Protection:**
- Settings form uses WordPress `settings_fields()` nonces
- Explicit capability checks in `sanitize_settings()`
- User capabilities verified with `current_user_can('manage_options')`

**Rate Limiting:**
- 10-second cooldown on settings updates
- Transient-based implementation
- Prevents abuse through rapid submissions

**Input Validation:**
- Flag emojis strictly validated
- Maximum 20 flags allowed
- Length limits enforced
- HTML tags stripped
- Control characters removed

**Security Headers:**
- X-Content-Type-Options: nosniff
- X-Frame-Options: SAMEORIGIN
- X-XSS-Protection: 1; mode=block

### Security Best Practices

When modifying code:
- **ALWAYS** sanitize inputs
- **ALWAYS** escape outputs
- **ALWAYS** check capabilities
- **ALWAYS** use nonces for forms
- **NEVER** trust user input
- **NEVER** echo JSON directly
- **NEVER** concatenate SQL

## Common Modifications

### Adding a New Setting

1. Register in `admin/settings.php`:
```php
add_settings_field('apls_new_setting', __('Setting Name'),
    array($this, 'new_setting_callback'), 'apls-settings', 'section_id');
```

2. Add sanitization in `sanitize_settings()`:
```php
$sanitized['new_setting'] = sanitize_text_field($input['new_setting']);
```

3. Add callback for rendering:
```php
public function new_setting_callback() {
    $options = get_option('apls_settings', array());
    $value = isset($options['new_setting']) ? $options['new_setting'] : '';
    ?>
    <input type="text" name="apls_settings[new_setting]"
           value="<?php echo esc_attr($value); ?>" />
    <?php
}
```

### Customizing Styles

Primary CSS customization points in `assets/css/language-switcher.css`:
- `.a11ylang-switcher__button` - Button appearance
- `.a11ylang-switcher__dropdown` - Dropdown styling
- `.a11ylang-switcher__link` - Language link styling
- Focus states use `#0073aa` (WordPress blue)

### Modifying JavaScript Behavior

Main JavaScript file: `assets/js/language-switcher.js`
- Data validation functions at top
- `init()` - Initialization logic
- `populateLanguages()` - Dropdown generation
- `handleButtonKeydown()` - Button keyboard events
- `handleDropdownKeydown()` - Dropdown keyboard events

## Testing Checklist

### Functionality
- Plugin activates without errors
- Settings page loads correctly
- Shortcode renders on frontend
- PHP function works
- Language switching works correctly
- Translated slugs handled properly
- Debug mode outputs console logs
- Settings save successfully
- Flag emoji customization works

### Accessibility
- Keyboard navigation works (Tab, Arrows, Enter, Escape, Home, End)
- Screen reader announces states correctly (NVDA, JAWS, VoiceOver)
- Focus indicators are visible
- `aria-expanded` toggles correctly
- `aria-current="page"` marks active language
- Touch targets are 44x44px minimum on mobile
- High contrast mode works
- Reduced motion respected
- Zoom to 200% works

### Security
- XSS prevention: Test shortcode with `<script>` tags
- XSS prevention: Test flag settings with malicious input
- CSRF protection: Test settings form without login
- Rate limiting: Save settings rapidly (10+ times)
- Capability checks: Test as subscriber role
- JavaScript validation: Check console for validation messages

### Compatibility
- WordPress and PHP: See `a11y-language-switcher.php` for minimum required versions
- Polylang free and pro
- Modern browsers (Chrome, Firefox, Safari, Edge)
- Mobile devices (iOS Safari, Chrome Android)

## Browser Compatibility

Target: Modern browsers (released last 2 years)
JavaScript: ES5+ (no transpilation required)

## Documentation Files

### Current Documentation

- **README.md** - Project overview and quick start (GitHub display)
- **readme.txt** - WordPress.org plugin directory format (required for plugin submission)
- **USAGE.md** - Complete usage documentation
- **CHANGELOG.md** - Version history and security updates
- **CLAUDE.md** - This developer guide (AI assistant instructions)

### Documentation Guidelines

**IMPORTANT for AI Assistants:**

1. **Do NOT delete documentation files** - All existing documentation files must be preserved
2. **Do NOT create new documentation files** - Never proactively create new `.md` files without explicit user permission
3. **Updates are allowed** - Existing documentation files can and should be updated when needed
4. **Ask first** - If you think a new documentation file is needed, ask the user for permission first

**Rationale:**
- Documentation files serve specific purposes and audiences
- Each file has a defined role in the project ecosystem
- New documentation adds maintenance overhead
- User should decide if new documentation is needed

**Examples:**
- ✅ **Allowed:** Update README.md to reflect new features
- ✅ **Allowed:** Add security info to CHANGELOG.md
- ✅ **Allowed:** Update version requirements in existing files
- ❌ **Not Allowed:** Create CONTRIBUTING.md without asking
- ❌ **Not Allowed:** Create docs/ folder without permission
- ❌ **Not Allowed:** Delete USAGE.md because it seems redundant

## Version History

- **1.0.1** (2024-10-31) - Security update: XSS fixes, CSRF protection, rate limiting
- **1.0.0** (2024-11-01) - Initial release

See CHANGELOG.md for detailed version history.
