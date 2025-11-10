# Documentation

## Usage

### Basic Configuration

Initialize the language switcher with required options:

```javascript
A11yLanguageSwitcher.init({
  container: '#language-switcher',
  languages: ['en', 'fr', 'es'],
  defaultLanguage: 'en'
});
```

### Configuration Options

| Option | Type | Required | Description |
|--------|------|----------|-------------|
| `container` | string | Yes | CSS selector for the container element |
| `languages` | array | Yes | Array of language codes (ISO 639-1) |
| `defaultLanguage` | string | Yes | Default language code |
| `labels` | object | No | Custom labels for language names |
| `onChange` | function | No | Callback function when language changes |
| `position` | string | No | Position of switcher: `'top'`, `'bottom'`, `'left'`, `'right'` |
| `ariaLabel` | string | No | Custom ARIA label for the switcher |

### Custom Labels

Define custom display names for languages:

```javascript
A11yLanguageSwitcher.init({
  container: '#language-switcher',
  languages: ['en', 'fr', 'es'],
  defaultLanguage: 'en',
  labels: {
    en: 'English',
    fr: 'Français',
    es: 'Español'
  }
});
```

### Change Events

Handle language change events:

```javascript
A11yLanguageSwitcher.init({
  container: '#language-switcher',
  languages: ['en', 'fr'],
  defaultLanguage: 'en',
  onChange: function(language) {
    // Update content based on selected language
    console.log('Language changed to:', language);
  }
});
```

## Customization

### Styling

The plugin uses BEM methodology for CSS classes:

```css
.a11y-lang-switcher { }
.a11y-lang-switcher__list { }
.a11y-lang-switcher__item { }
.a11y-lang-switcher__button { }
.a11y-lang-switcher__button--active { }
```

Example custom styles:

```css
.a11y-lang-switcher {
  font-family: sans-serif;
  font-size: 14px;
}

.a11y-lang-switcher__button {
  padding: 8px 16px;
  border: 1px solid #ccc;
  background: #fff;
  cursor: pointer;
}

.a11y-lang-switcher__button--active {
  background: #007bff;
  color: #fff;
  border-color: #007bff;
}
```

### Accessibility Features

The plugin includes built-in accessibility features:

- **Keyboard Navigation**: Full support for Tab, Enter, Space, and Arrow keys
- **ARIA Attributes**: Proper `role`, `aria-label`, and `aria-current` attributes
- **Focus Management**: Visible focus indicators and logical tab order
- **Screen Reader Support**: Announces language changes and current selection

### Methods

#### `setLanguage(languageCode)`

Programmatically set the active language:

```javascript
A11yLanguageSwitcher.setLanguage('fr');
```

#### `getLanguage()`

Get the current active language:

```javascript
const currentLang = A11yLanguageSwitcher.getLanguage();
```

#### `destroy()`

Remove the language switcher:

```javascript
A11yLanguageSwitcher.destroy();
```

## Browser Support

- Chrome (last 2 versions)
- Firefox (last 2 versions)
- Safari (last 2 versions)
- Edge (last 2 versions)
- IE11 (with polyfills)

## Accessibility Standards

This plugin complies with:

- WCAG 2.1 Level AA
- Section 508
- ARIA 1.2 Authoring Practices
