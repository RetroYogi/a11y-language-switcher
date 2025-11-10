# A11y Language Switcher

An accessible language switcher plugin designed with WCAG compliance and keyboard navigation support.

## Features

- WCAG 2.1 compliant language switching
- Full keyboard navigation support
- Screen reader optimized
- Customizable styling
- Lightweight and performant
- No external dependencies

## Installation

1. Download the latest release
2. Extract the files to your project directory
3. Include the required files in your HTML
4. Initialize the language switcher

## Quick Start

```html
<div id="language-switcher"></div>

<script src="path/to/a11y-language-switcher.js"></script>
<script>
  A11yLanguageSwitcher.init({
    container: '#language-switcher',
    languages: ['en', 'fr', 'es'],
    defaultLanguage: 'en'
  });
</script>
```

## Documentation

For detailed usage instructions and customization options, see [DOCUMENTATION.md](DOCUMENTATION.md)

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for version history and security updates.

## License

This project is licensed under the GNU General Public License v3.0 - see the [LICENSE](LICENSE) file for details.

## Contributing

Contributions are welcome. Please ensure all changes maintain accessibility standards and include appropriate tests.
