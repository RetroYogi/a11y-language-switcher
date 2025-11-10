# A11y Language Switcher by Key4

Modern, accessible language switcher for Polylang and block themes. The perfect complement to Polylang Free for modern WordPress sites.

![Version](https://img.shields.io/badge/version-1.0.1-blue.svg)
![WordPress](https://img.shields.io/badge/WordPress-5.0+-green.svg)
![PHP](https://img.shields.io/badge/PHP-7.0+-purple.svg)
![License](https://img.shields.io/badge/license-GPL--2.0-orange.svg)

## 🎯 The Problem This Solves

Traditional language switchers try to "guess" translation URLs by swapping language codes. This breaks when page slugs are translated:

**Example:**
- French: `https://yoursite.com/services/`
- English: `https://yoursite.com/en/digital-services/` ❌ (NOT `/en/services/`)
- German: `https://yoursite.com/de/dienstleistungen/` ❌ (NOT `/de/services/`)

**This plugin uses Polylang's actual translation URLs**, ensuring language switching always works correctly!

## ✨ Features

### Accessibility (WCAG 2.1 AA)
- ✅ Full keyboard navigation (Tab, Arrows, Enter, Escape)
- ✅ Screen reader support with ARIA labels
- ✅ High contrast mode support
- ✅ Reduced motion support
- ✅ Proper focus indicators
- ✅ 44x44px touch targets on mobile

### Technical
- ✅ Handles translated page slugs automatically
- ✅ No configuration needed (uses Polylang settings)
- ✅ Customizable flag emojis
- ✅ Debug mode for troubleshooting
- ✅ Vanilla JavaScript (no jQuery)
- ✅ Responsive mobile design
- ✅ Works with Polylang free & pro

## 📦 Installation

### From WordPress.org (Recommended)

1. Go to **WordPress Dashboard → Plugins → Add New**
2. Search for "A11y Language Switcher by Key4"
3. Click **Install Now** then **Activate**
4. Go to **Settings → Language Switcher** to configure (optional)

### From GitHub Release

1. Download the latest release ZIP from [GitHub Releases](https://github.com/yourusername/a11y-language-switcher/releases)
2. Go to **WordPress Dashboard → Plugins → Add New → Upload Plugin**
3. Choose the ZIP file and click **Install Now**
4. Click **Activate Plugin**

## 🚀 Usage

Add the language switcher using one of these methods:

### Shortcode (Easiest)
```
[a11ylang_language_switcher]
```

### PHP (In Theme Templates)
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

### Gutenberg Block Editor
1. Add a **Shortcode** block
2. Enter: `[a11ylang_language_switcher]`

## ⚙️ Configuration

### Settings Page

Go to **Settings → Language Switcher** to configure:

1. **Debug Mode**: Enable console logging for troubleshooting
2. **Language Flags**: Customize flag emojis for each language (e.g., 🇫🇷, 🇬🇧, 🇩🇪)

### Default Flags

The plugin includes default flags for common languages:
- 🇫🇷 French (fr)
- 🇬🇧 English (en)
- 🇩🇪 German (de)
- 🇪🇸 Spanish (es)
- 🇵🇹 Portuguese (pt)
- 🇮🇹 Italian (it)
- 🇳🇱 Dutch (nl)

You can customize these or add new ones in the settings.

## 🎨 Customization

### CSS Customization

Override these CSS classes in your theme:

```css
/* Main container */
.a11ylang-switcher {
    /* Your styles */
}

/* Toggle button */
.a11ylang-switcher__button {
    background-color: #your-color;
    border-color: #your-border;
}

/* Dropdown menu */
.a11ylang-switcher__dropdown {
    /* Your styles */
}

/* Language links */
.a11ylang-switcher__link {
    /* Your styles */
}

/* Current language (active) */
.a11ylang-switcher__link[aria-current="page"] {
    background-color: #your-active-color;
}
```

### Removing Flags

To show only language names without flags, add this CSS:

```css
.a11ylang-switcher__flag,
.a11ylang-switcher__icon {
    display: none;
}
```

Or set all flags to empty strings in the settings.

## 🔍 Troubleshooting

### Language Switcher Not Appearing

1. Make sure Polylang plugin is installed and activated
2. Check that you've added the shortcode to your page/template
3. Look for JavaScript errors in browser console (F12)

### Wrong Language URLs

1. Go to **Settings → Language Switcher**
2. Enable **Debug Mode**
3. Open browser console (F12)
4. Check the output - it will show which URLs Polylang is providing

### Debug Console Output

With debug mode enabled, you'll see:

```
[Language Switcher] Initializing language switcher
[Language Switcher] Languages from Polylang: [...]
[Language Switcher] Language link: fr (Français) → /
[Language Switcher] Language link: en (English) → /en/home/
[Language Switcher] Language link: de (Deutsch) → /de/start/
```

## 📋 Requirements

- WordPress 5.0+
- PHP 7.0+
- [Polylang](https://wordpress.org/plugins/polylang/) (free or pro)

## 🤝 Contributing

Contributions are welcome! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

## 📄 License

GPL v2 or later - see [LICENSE](LICENSE) for details.

## 👨‍💻 Author

**Gérard Kieffer** - [key4.lu](https://key4.lu)

## 📞 Support

- **Issues**: [GitHub Issues](https://github.com/yourusername/a11y-language-switcher/issues)
- **Website**: [key4.lu](https://key4.lu)
