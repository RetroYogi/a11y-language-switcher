# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is **A11y Language Switcher by Key4** - a complete WordPress plugin that provides a modern, fully accessible language switcher for WordPress sites using the Polylang plugin (free or pro version).

**Plugin Name:** A11y Language Switcher by Key4
**Current Version:** 1.0.1
**Purpose:** Modern language switcher for Polylang Free users with block-based themes

### Plugin Structure

```
a11y-language-switcher/
├── a11y-language-switcher.php  # Main plugin file
├── LICENSE                                     # GPL v2+ license
├── README.md                                   # Plugin documentation
├── readme.txt                                  # WordPress.org format
├── CHANGELOG.md                                # Version history
├── INSTALLATION.md                             # Installation guide
├── SECURITY.md                                 # Security update details
├── admin/
│   └── settings.php                           # Settings page
├── assets/
│   ├── css/
│   │   └── language-switcher.css              # Styles
│   └── js/
│       └── language-switcher.js               # JavaScript
└── includes/
    ├── functions.php                          # Helper functions
    ├── template.php                           # HTML template
    └── security.php                           # Security helpers
```

## Architecture

### Plugin Components

1. **Main Plugin File** (`accessible-polylang-language-switcher.php`)
   - WordPress plugin headers (Version, Author, License)
   - Plugin initialization and hooks
   - Polylang dependency checking
   - Asset enqueuing
   - Translation data output via `wp_add_inline_script()`
   - Shortcode registration

2. **Admin Settings** (`admin/settings.php`)
   - Settings page at Settings → Language Switcher
   - Debug mode toggle
   - Custom flag emoji configuration
   - CSRF protection with nonces
   - Rate limiting (10-second cooldown)

3. **Template** (`includes/template.php`)
   - HTML structure with ARIA attributes
   - Accessible button and dropdown markup
   - Dynamic content populated by JavaScript

4. **Security Helpers** (`includes/security.php`)
   - `APLS_Security` class
   - Input sanitization functions
   - Rate limiting
   - Security headers
   - Debug mode warnings

5. **Helper Functions** (`includes/functions.php`)
   - `apls_language_switcher()` - PHP function for theme templates
   - `apls_is_configured()` - Check if Polylang is active
   - `apls_get_version()` - Get plugin version

### Key Design Patterns

1. **WordPress Plugin API**
   - Hooks: `plugins_loaded`, `admin_init`, `admin_notices`, `wp_enqueue_scripts`
   - Settings API: `register_setting()`, `add_settings_section()`, `add_settings_field()`
   - Shortcode API: `add_shortcode()`

2. **Security First**
   - All inputs sanitized (`sanitize_key()`, `sanitize_text_field()`, `wp_strip_all_tags()`)
   - All outputs escaped (`esc_html()`, `esc_attr()`, `esc_url_raw()`)
   - CSRF protection via `settings_fields()` nonces
   - Capability checks (`current_user_can('manage_options')`)
   - Rate limiting on settings updates
   - XSS prevention in JavaScript

3. **Polylang Integration**
   - Uses `pll_the_languages()` to get actual translation URLs
   - No URL guessing - uses Polylang's translation database
   - Handles translated page slugs correctly
   - Automatically gets language names from Polylang settings

4. **IIFE Pattern** (JavaScript)
   - Wrapped in Immediately Invoked Function Expression
   - Avoids global scope pollution
   - Uses strict mode

## Documentation Files - IMPORTANT

### Primary Documentation Locations

**DO NOT create new documentation files.** Always update existing files in their designated locations:

#### 1. Version Information
Update in these files (keep synchronized):
- `a11y-language-switcher.php` - Plugin header: `* Version: X.X.X`
- `a11y-language-switcher.php` - Constant: `define('APLS_VERSION', 'X.X.X');`
- `a11y-language-switcher/readme.txt` - `Stable tag: X.X.X`
- `a11y-language-switcher/README.md` - Badge: `![Version](https://img.shields.io/badge/version-X.X.X-blue.svg)`
- Root `README.md` - Badge: `[![Version](https://img.shields.io/badge/version-X.X.X-blue.svg)]`

#### 2. Changelog
- **Location:** `a11y-language-switcher/CHANGELOG.md`
- **Format:** Keep a Changelog format (https://keepachangelog.com/)
- **Sections:** Added, Changed, Deprecated, Removed, Fixed, Security
- **Always add new version at TOP** of file

#### 3. Author/Contact Information
Update in these files:
- `a11y-language-switcher.php` - Plugin header: `* Author:` and `* Author URI:`
- `a11y-language-switcher/readme.txt` - `Contributors:`
- `a11y-language-switcher/LICENSE` - Copyright line
- Root `README.md` - Credits section
- `CONTRIBUTING.md` - Contact section (if changed)

#### 4. License
- **Location:** `a11y-language-switcher/LICENSE`
- **Type:** GPL v2 or later (do not change without legal review)
- **Copyright year:** Update annually in LICENSE file header

#### 5. Security Updates
- **Location:** `a11y-language-switcher/SECURITY.md`
- **Purpose:** Document security vulnerabilities and fixes
- **When to update:** Only when security issues are discovered and fixed
- **Do NOT:** Create separate security files per version

### Documentation Update Workflow

When making changes:

1. **Bug Fix (Patch Version X.X.Y)**
   ```
   1. Update CHANGELOG.md (add patch version at top)
   2. Update version in 4 files listed above
   3. Update README.md if behavior changed
   4. DO NOT create new documentation files
   ```

2. **New Feature (Minor Version X.Y.0)**
   ```
   1. Update CHANGELOG.md (add minor version at top)
   2. Update version in 4 files listed above
   3. Update README.md with new feature documentation
   4. Update INSTALLATION.md if setup changed
   5. DO NOT create new documentation files
   ```

3. **Breaking Change (Major Version Y.0.0)**
   ```
   1. Update CHANGELOG.md (add major version at top, note breaking changes)
   2. Update version in 4 files listed above
   3. Update README.md with migration guide
   4. Update INSTALLATION.md if installation changed
   5. Consider adding migration guide to INSTALLATION.md
   6. DO NOT create new documentation files
   ```

4. **Security Fix**
   ```
   1. Update CHANGELOG.md (add version with Security section at top)
   2. Update version in 4 files listed above
   3. Update SECURITY.md with vulnerability details and fix
   4. DO NOT create separate security announcement files
   ```

### File Hierarchy (Most Important → Supporting)

1. **`a11y-language-switcher.php`** - Source of truth for version
2. **`CHANGELOG.md`** - Source of truth for changes
3. **`LICENSE`** - Source of truth for copyright/author
4. **`README.md`** (plugin) - User-facing documentation
5. **`readme.txt`** - WordPress.org submission format
6. **`INSTALLATION.md`** - Detailed installation steps
7. **`SECURITY.md`** - Security-related information
8. **Root `README.md`** - GitHub repository overview

### Documentation Rules

**NEVER:**
- Create duplicate documentation files
- Create version-specific docs (e.g., `README-v2.md`)
- Create `UPDATES.md`, `NOTES.md`, `TODO.md` in the repository
- Add personal task notes to committed files
- Create temporary documentation files that get committed

**ALWAYS:**
- Update existing files in their designated locations
- Keep version numbers synchronized across all files
- Update CHANGELOG.md before releasing
- Verify all documentation files are consistent
- Use CLAUDE.md (this file) for AI assistant instructions only

## Configuration

### Debug Mode
- Location: Settings → Language Switcher (admin)
- Enables comprehensive console logging
- Automatically shows warning banner when enabled
- Should be disabled in production

### Language Flags
- Location: Settings → Language Switcher (admin)
- Customize flag emoji for each language
- Default flags: 🇫🇷 🇬🇧 🇩🇪 🇪🇸 🇵🇹 🇮🇹 🇳🇱
- Can use text instead: FR, EN, DE

### Element IDs (in template.php)
- `polylang-switcher` - Main container
- `polylang-button` - Toggle button
- `polylang-dropdown` - Dropdown menu
- `current-lang` - Current language display

**Do not change these IDs without updating JavaScript references.**

## Accessibility Features

This plugin implements WCAG 2.1 AA standards:

1. **Keyboard Navigation**:
   - Tab to focus button
   - Enter/Space to open dropdown
   - Arrow Up/Down to navigate options
   - Home/End for first/last items
   - Escape to close dropdown

2. **ARIA Implementation**:
   - `aria-expanded` on button (true/false state)
   - `aria-haspopup="true"` to indicate menu
   - `role="menu"` and `role="menuitem"` for semantics
   - `aria-current="page"` for active language
   - `aria-controls` linking button to dropdown
   - `aria-labelledby` for dropdown identification

3. **Visual Accessibility**:
   - High contrast mode support
   - Reduced motion support
   - Focus indicators with proper contrast
   - Minimum 44x44px touch targets on mobile
   - Semantic HTML structure

## Security

### Version 1.0.1 Security Improvements

1. **XSS Prevention**
   - Shortcode class parameter sanitized with `sanitize_html_class()`
   - JSON output uses `wp_add_inline_script()` instead of direct echo
   - All Polylang data sanitized before output
   - JavaScript validates and sanitizes all text content
   - URL validation before use

2. **CSRF Protection**
   - Settings form uses WordPress `settings_fields()` nonces
   - Explicit capability checks in `sanitize_settings()`
   - User capabilities verified with `current_user_can('manage_options')`

3. **Rate Limiting**
   - 10-second cooldown on settings updates
   - Transient-based implementation
   - Prevents abuse through rapid submissions

4. **Input Validation**
   - Flag emojis strictly validated
   - Maximum 20 flags allowed
   - Length limits enforced
   - HTML tags stripped
   - Control characters removed

5. **Security Headers**
   - X-Content-Type-Options: nosniff
   - X-Frame-Options: SAMEORIGIN
   - X-XSS-Protection: 1; mode=block

### Security Best Practices

When modifying code:
- **ALWAYS** sanitize inputs: `sanitize_text_field()`, `sanitize_key()`, `wp_strip_all_tags()`
- **ALWAYS** escape outputs: `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`
- **ALWAYS** check capabilities: `current_user_can('manage_options')`
- **ALWAYS** use nonces for forms: `wp_nonce_field()`, `wp_verify_nonce()`
- **NEVER** trust user input
- **NEVER** echo JSON directly (use `wp_add_inline_script()`)
- **NEVER** concatenate SQL (use `$wpdb->prepare()`)

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
- `.polylang-switcher__button` - Button appearance
- `.polylang-switcher__dropdown` - Dropdown styling
- `.polylang-switcher__link` - Language link styling
- Focus states use `#0073aa` (WordPress blue)

### Modifying JavaScript Behavior

Main JavaScript file: `assets/js/language-switcher.js`
- Data validation functions at top
- `init()` - Initialization logic
- `populateLanguages()` - Dropdown generation
- `handleButtonKeydown()` - Button keyboard events
- `handleDropdownKeydown()` - Dropdown keyboard events

## Testing Checklist

### Functionality Tests
1. Plugin activates without errors
2. Settings page loads correctly (Settings → Language Switcher)
3. Shortcode renders on frontend: `[polylang_language_switcher]`
4. PHP function works: `apls_language_switcher()`
5. Language switching works correctly
6. Translated slugs are handled properly
7. Debug mode outputs console logs
8. Settings save successfully
9. Flag emoji customization works

### Accessibility Tests
1. Keyboard navigation works (Tab, Arrows, Enter, Escape, Home, End)
2. Screen reader announces states correctly (NVDA, JAWS, VoiceOver)
3. Focus indicators are visible
4. `aria-expanded` toggles correctly (inspect in DevTools)
5. `aria-current="page"` marks active language
6. Touch targets are 44x44px minimum on mobile
7. High contrast mode works
8. Reduced motion is respected
9. Zoom to 200% works without issues

### Security Tests
1. XSS prevention: Try `[polylang_language_switcher class="<script>alert('XSS')</script>"]`
2. XSS prevention: Try entering `<script>` in flag settings
3. CSRF protection: Try settings form without being logged in
4. Rate limiting: Save settings rapidly (10+ times)
5. Capability checks: Try accessing settings page as subscriber
6. JavaScript validation: Check console for validation messages

### Compatibility Tests
1. Works with WordPress 5.0+
2. Works with PHP 7.0+
3. Works with Polylang free version
4. Works with Polylang pro version
5. No JavaScript errors in console
6. Works on mobile devices (iOS Safari, Chrome Android)
7. Works in multiple browsers (Chrome, Firefox, Safari, Edge)

### Regression Tests
1. Version number consistent across all files
2. CHANGELOG.md updated
3. README.md reflects current features
4. No broken links in documentation
5. License information correct
6. Author information correct

## Troubleshooting

### Language Switcher Not Showing
1. Check if Polylang is active
2. Check if at least 2 languages are configured in Polylang
3. Verify shortcode is added to page: `[polylang_language_switcher]`
4. Enable debug mode and check browser console
5. Check for JavaScript errors in console
6. Verify plugin is activated

### Wrong Language URLs
1. Enable debug mode (Settings → Language Switcher)
2. Open browser console (F12)
3. Check "Language link" messages for each language
4. Compare with Polylang's actual URL structure
5. Verify Polylang translations exist for current page

### Settings Not Saving
1. Check user has 'manage_options' capability
2. Check for rate limiting message (10-second cooldown)
3. Clear browser cache
4. Check for PHP errors in WordPress debug log
5. Verify WordPress nonces are working

### Debug Mode
Enable at Settings → Language Switcher to see:
- `[Language Switcher] Initializing...`
- `[Language Switcher] Languages from Polylang: [...]`
- `[Language Switcher] Language link: fr → /`
- `[Language Switcher] Current language: fr (Français)`

## Browser Compatibility

Target: Modern browsers (last 2 versions)
- Chrome/Edge (Chromium-based)
- Firefox
- Safari (desktop and iOS)
- Chrome Android

JavaScript: ES5+ (no transpilation required)

## WordPress Compatibility

- **WordPress:** 5.0+ required
- **PHP:** 7.0+ required
- **Polylang:** Free or Pro version required

## Version History

- **1.0.1** (2024-10-31) - Security update: XSS fixes, CSRF protection, rate limiting
- **1.0.0** (2024-11-01) - Initial release

See CHANGELOG.md for detailed version history.
