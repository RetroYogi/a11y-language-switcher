# A11y Language Switcher

![Version](https://img.shields.io/badge/version-1.1.0-blue.svg)
![WordPress](https://img.shields.io/badge/WordPress-6.0+-green.svg)
![PHP](https://img.shields.io/badge/PHP-8.0+-purple.svg)
![License](https://img.shields.io/badge/license-GPL--2.0-orange.svg)

Modern, accessible language switcher for WordPress sites using the Polylang plugin. Provides a WCAG 2.1 AA compliant language switcher that works seamlessly with block-based themes and Full Site Editing.

## About This Plugin

I manage several multilingual websites for which I use Polylang Pro. But for some low-traffic sites, the free verson is definitely enough, except for one issue: Polylang Free only provides language switchers for the classic menu system and as a legacy widget block. If you're using a modern block-based theme with Full Site Editing, you're out of luck. Therefore, I've developed this free, accessible language switcher that works perfectly on WordPress sites using Polylang Free.

This plugin uses Polylang's translation database to ensure correct URLs, even when page slugs are translated.

## Features

- **Accessible**: WCAG 2.1 AA compliant with full keyboard navigation and screen reader support
- **Smart URLs**: Uses Polylang's actual translation URLs (handles translated slugs correctly)
- **Simple**: Easy shortcode `[a11ylang_language_switcher]` or PHP function
- **Customizable**: Override styles, customize flags, adjust appearance
- **Lightweight**: Vanilla JavaScript, no dependencies

## Requirements

- WordPress 6.0+
- PHP 8.0+
- [Polylang](https://wordpress.org/plugins/polylang/) plugin (free or pro)

## Installation

1. Download the latest release as a ZIP file
2. If you've downloaded individual files/folders, compress them into a ZIP file
3. Go to **WordPress Admin → Plugins → Add New → Upload Plugin**
4. Upload the ZIP file and click **Install Now**
5. Click **Activate Plugin**

## Quick Start

Add the language switcher anywhere using the shortcode:

```
[a11ylang_language_switcher]
```

Or in PHP templates:

```php
<?php
if (function_exists('apls_language_switcher')) {
    apls_language_switcher();
}
?>
```

## Documentation

- [USAGE.md](USAGE.md) - Installation, usage, customization, and troubleshooting
- [CHANGELOG.md](CHANGELOG.md) - Version history and security updates

## Accessibility

- Full keyboard navigation (Tab, Arrow keys, Enter, Escape, Home, End)
- ARIA labels and roles for screen readers
- High contrast and reduced motion support
- 44x44px minimum touch targets
- Focus indicators with proper contrast

## License

GPL v2 or later - see [LICENSE](LICENSE) for details.

## Support

- **Issues**: [GitHub Issues](https://github.com/yourusername/a11y-language-switcher/issues)
