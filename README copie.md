# A11y Language Switcher by Key4

[![Version](https://img.shields.io/badge/version-1.0.1-blue.svg)](https://github.com/yourusername/a11y-language-switcher)
[![WordPress](https://img.shields.io/badge/wordpress-5.0%2B-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/php-7.0%2B-purple.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-GPL--2.0%2B-red.svg)](LICENSE)
[![WCAG](https://img.shields.io/badge/WCAG-2.1%20AA-green.svg)](https://www.w3.org/WAI/WCAG21/quickref/)

Modern, accessible language switcher for Polylang and block themes. The perfect complement to Polylang Free for users who need a modern language switcher without upgrading to Pro.

## 🎯 The Problem This Solves

[Polylang](https://wordpress.org/plugins/polylang/) is an excellent multilingual plugin, and we highly recommend supporting the developers by purchasing the Pro version if you need its advanced features.

However, **Polylang Free only provides a language switcher for**:
- Legacy navigation menus
- Legacy widget blocks

If you're using a **block-based theme** (FSE - Full Site Editing) with modern block navigation, you're out of luck.

**This plugin is the solution.** It provides a modern, accessible language switcher that works seamlessly with block themes and FSE, without requiring Polylang Pro.

## 💡 What This Plugin Does

- ✅ Provides a language switcher for block-based themes
- ✅ Works with Polylang Free (and Pro)
- ✅ Simple shortcode: `[a11ylang_language_switcher]`
- ✅ Fully accessible (WCAG 2.1 AA compliant)

## ⚠️ What This Plugin Does NOT Do

- ❌ Does NOT add multilingual functionality (use Polylang for that)
- ❌ Does NOT translate content (use Polylang for that)
- ❌ Does NOT replace Polylang (requires Polylang to be installed)

**This is purely a language switcher** - but it's the best one for modern WordPress sites.

## ✨ Features

- **🌍 Smart URL Handling**: Uses Polylang's actual translation URLs (no URL guessing!)
- **♿ Fully Accessible**: WCAG 2.1 AA compliant with complete keyboard navigation
- **🎨 Customizable**: Override CSS, customize flag emojis, adjust colors
- **🔒 Secure**: Comprehensive XSS and CSRF protection (v1.0.1+)
- **📱 Responsive**: Mobile-first design with proper touch targets
- **🚀 Lightweight**: Vanilla JavaScript, no jQuery dependency
- **🔧 Easy Setup**: Simple shortcode or PHP function

## 🎯 Why This Plugin?

Most language switchers break when page slugs are translated. For example:
- French: `/services/`
- English: `/en/digital-services/` ✅ (not `/en/services/`)
- German: `/de/dienstleistungen/` ✅ (not `/de/services/`)

This plugin uses **Polylang's translation database** to get the correct URLs, ensuring reliable language switching across all pages.

## 📦 Installation

### Quick Install (Recommended)

1. Download the [latest release](https://github.com/yourusername/a11y-language-switcher/releases)
2. Go to **WordPress Admin → Plugins → Add New → Upload Plugin**
3. Choose the ZIP file and click **Install Now**
4. Click **Activate Plugin**
5. Add the shortcode: `[a11ylang_language_switcher]`

### Manual Install

1. Download and extract the plugin
2. Upload `a11y-language-switcher/` to `/wp-content/plugins/`
3. Activate through the WordPress Plugins menu
4. Add the shortcode where needed

### Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher
- [Polylang](https://wordpress.org/plugins/polylang/) plugin (free or pro)

## 🚀 Usage

### Shortcode (Easiest)

Add anywhere in your content:
```
[a11ylang_language_switcher]
```

### PHP Function

In your theme files:
```php
<?php
if (function_exists('apls_language_switcher')) {
    apls_language_switcher();
}
?>
```

### Gutenberg Block

1. Add a **Shortcode** block
2. Enter: `[a11ylang_language_switcher]`

### Navigation Menu

1. Go to **Appearance → Menus**
2. Add **Custom HTML** menu item
3. Content: `[a11ylang_language_switcher]`

## ⚙️ Configuration

Settings are available at **Settings → Language Switcher**:

- **Debug Mode**: Enable console logging for troubleshooting
- **Language Flags**: Customize flag emojis for each language (e.g., 🇫🇷 🇬🇧 🇩🇪)

## ♿ Accessibility Features

- Full keyboard navigation (Tab, Arrow keys, Enter, Escape, Home, End)
- ARIA labels and roles for screen readers
- `aria-current="page"` for current language
- High contrast mode support
- Reduced motion support
- Minimum 44x44px touch targets on mobile
- Focus indicators with proper contrast

## 🎨 Customization

### Custom CSS

Add to your theme's custom CSS:

```css
/* Change button colors */
.a11ylang-switcher__button {
    background-color: #your-color;
    border-color: #your-border-color;
}

/* Change dropdown colors */
.a11ylang-switcher__link:hover {
    background-color: #your-hover-color;
}

/* Hide flags, show only text */
.a11ylang-switcher__flag {
    display: none;
}
```

## 🔒 Security

Version 1.0.1 includes comprehensive security improvements:

- XSS protection for all inputs and outputs
- CSRF protection with nonce verification
- Rate limiting on settings updates
- Strict input sanitization
- URL validation
- Security headers

See [SECURITY.md](a11y-language-switcher/SECURITY.md) for details.

## 📚 Documentation

- **[Installation Guide](a11y-language-switcher/INSTALLATION.md)** - Detailed installation instructions
- **[Changelog](a11y-language-switcher/CHANGELOG.md)** - Version history
- **[Security](a11y-language-switcher/SECURITY.md)** - Security updates and fixes

## 🤝 Contributing

Contributions are welcome! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

## 📝 License

GPL v2 or later - see [LICENSE](a11y-language-switcher/LICENSE) for details.

## 👨‍💻 Author

**Gérard Kieffer** - [key4.lu](https://key4.lu)

## 🐛 Support

- **Issues**: [GitHub Issues](https://github.com/yourusername/a11y-language-switcher/issues)
- **Website**: [key4.lu](https://key4.lu)

---

**Made with ♿ accessibility in mind**
