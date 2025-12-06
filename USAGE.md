# Usage Guide

Complete guide for installing, using, and customizing the A11y Language Switcher plugin.

## Installation

### Quick Install

1. Download the plugin ZIP file
2. Go to **WordPress Admin → Plugins → Add New**
3. Click **Upload Plugin**
4. Choose the ZIP file and click **Install Now**
5. Click **Activate Plugin**

### Manual Install (FTP)

1. Extract the plugin ZIP file
2. Upload the `a11y-language-switcher` folder to `/wp-content/plugins/`
3. Go to **WordPress Admin → Plugins**
4. Find "A11y Language Switcher" and click **Activate**

### Requirements Check

After installation, verify:
- ✅ Polylang plugin is installed and active
- ✅ At least 2 languages are configured in Polylang
- ✅ Plugin activated successfully

If you see "Polylang plugin is required" error, install and activate Polylang first.

## Usage

### Shortcode (Recommended)

Add the language switcher anywhere using:

```
[a11ylang_language_switcher]
```

**Where to add:**
- Pages and posts (using Shortcode block in Gutenberg)
- Header template (Appearance → Editor → Header)
- Footer template (Appearance → Editor → Footer)
- Sidebar widgets (using Shortcode widget)

### PHP Function

In theme template files:

```php
<?php
if (function_exists('apls_language_switcher')) {
    apls_language_switcher();
}
?>
```

Or using `do_shortcode()`:

```php
<?php echo do_shortcode('[a11ylang_language_switcher]'); ?>
```

### Block Editor (Gutenberg)

1. Click **+** to add a new block
2. Search for "Shortcode"
3. Add the Shortcode block
4. Enter: `[a11ylang_language_switcher]`

### Navigation Menu

1. Go to **Appearance → Menus**
2. Add **Custom HTML** menu item
3. In the content field, enter: `[a11ylang_language_switcher]`
4. Save the menu

## Configuration

### Settings Page

Access settings at **Settings → Language Switcher**.

#### Debug Mode

Enable debug mode for troubleshooting:
- Shows detailed console logs in browser developer tools
- Displays language data from Polylang
- Shows URL mapping for each language

**To enable:**
1. Go to Settings → Language Switcher
2. Check "Enable Debug Mode"
3. Click "Save Changes"
4. Open browser console (F12) to view logs

**Debug output example:**
```
[Language Switcher] Initializing language switcher
[Language Switcher] Languages from Polylang: [...]
[Language Switcher] Language link: fr (Français) → /
[Language Switcher] Language link: en (English) → /en/home/
[Language Switcher] Current language: fr (Français)
```

#### Language Flags

Customize flag emojis for each language:

**Default flags:**
- 🇫🇷 French (fr)
- 🇬🇧 English (en)
- 🇩🇪 German (de)
- 🇪🇸 Spanish (es)
- 🇵🇹 Portuguese (pt)
- 🇮🇹 Italian (it)
- 🇳🇱 Dutch (nl)

**To customize:**
1. Go to Settings → Language Switcher
2. Enter custom flags in the text fields (one per language code)
3. Use emojis (🇫🇷) or text (FR)
4. Click "Save Changes"

## Customization

### CSS Styling

Override the default styles by adding CSS to your theme:

**Change button appearance:**
```css
.a11ylang-switcher__button {
    background-color: #your-color;
    border: 2px solid #your-border;
    color: #your-text-color;
    padding: 10px 20px;
    border-radius: 5px;
}
```

**Change dropdown styling:**
```css
.a11ylang-switcher__dropdown {
    background-color: #your-background;
    border: 1px solid #your-border;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
```

**Style language links:**
```css
.a11ylang-switcher__link {
    color: #your-text-color;
    padding: 12px 16px;
}

.a11ylang-switcher__link:hover {
    background-color: #your-hover-color;
}

/* Active/current language */
.a11ylang-switcher__link[aria-current="page"] {
    background-color: #your-active-color;
    font-weight: bold;
}
```

**Hide flags (text only):**
```css
.a11ylang-switcher__flag,
.a11ylang-switcher__icon {
    display: none;
}
```

**Adjust positioning:**
```css
.a11ylang-switcher {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
}
```

### CSS Classes Reference

| Class | Description |
|-------|-------------|
| `.a11ylang-switcher` | Main container |
| `.a11ylang-switcher__button` | Toggle button |
| `.a11ylang-switcher__icon` | Globe icon in button |
| `.a11ylang-switcher__text` | Current language text |
| `.a11ylang-switcher__dropdown` | Dropdown menu |
| `.a11ylang-switcher__link` | Language link item |
| `.a11ylang-switcher__flag` | Flag emoji |
| `.a11ylang-switcher__name` | Language name |

### Keyboard Navigation

The language switcher is fully keyboard accessible:

| Key | Action |
|-----|--------|
| **Tab** | Focus the button |
| **Enter** or **Space** | Open/close dropdown |
| **Arrow Down** | Move to next language |
| **Arrow Up** | Move to previous language |
| **Home** | Jump to first language |
| **End** | Jump to last language |
| **Escape** | Close dropdown |

## Troubleshooting

### Language Switcher Not Appearing

**Possible causes:**
1. Shortcode not added to page
2. Polylang plugin not active
3. Less than 2 languages configured
4. JavaScript error

**Solutions:**
1. Verify shortcode is present: `[a11ylang_language_switcher]`
2. Check Plugins page - ensure Polylang is active
3. Go to Languages settings - add at least 2 languages
4. Open browser console (F12) - check for JavaScript errors

### Wrong Language URLs

**Problem:** Language switcher links to incorrect pages

**Solution:**
1. Enable debug mode (Settings → Language Switcher)
2. Open browser console (F12)
3. Check the URL output for each language
4. Verify Polylang translations exist for the current page
5. Check Polylang's URL structure settings (Languages → Settings)

### Settings Not Saving

**Possible causes:**
1. Insufficient user permissions
2. Rate limiting (10-second cooldown)
3. Browser cache
4. Server error

**Solutions:**
1. Ensure you're logged in as Administrator
2. Wait 10 seconds between saves
3. Clear browser cache (Ctrl+Shift+Delete)
4. Check WordPress debug log for PHP errors

### Styling Issues

**Problem:** Switcher appearance conflicts with theme

**Solution - Reset theme styles:**
```css
.a11ylang-switcher__button {
    all: unset;
    /* Add plugin styles here */
    display: inline-flex;
    align-items: center;
    padding: 8px 16px;
    border: 1px solid #ddd;
    background: white;
    cursor: pointer;
}
```

### Dropdown Not Opening

**Check:**
1. JavaScript is enabled in browser
2. No JavaScript errors in console (F12)
3. Plugin assets loaded (check Network tab in DevTools)
4. No conflicting JavaScript from other plugins

**Debug:**
1. Enable debug mode
2. Check console for error messages
3. Disable other plugins temporarily to identify conflicts

## Browser Compatibility

**Supported browsers:**
- Chrome/Edge (latest 2 versions)
- Firefox (latest 2 versions)
- Safari (latest 2 versions)
- iOS Safari (latest 2 versions)
- Chrome Android (latest 2 versions)

## Uninstalling

### Temporary Disable
1. Go to **Plugins**
2. Find "A11y Language Switcher"
3. Click **Deactivate**
4. Settings are preserved

### Complete Removal
1. **Deactivate** the plugin first
2. Click **Delete**
3. Confirm deletion
4. All settings will be removed from database

## Advanced

### Element IDs

If you need to target elements with JavaScript:

- `#a11ylang-switcher` - Main container
- `#a11ylang-button` - Toggle button
- `#a11ylang-dropdown` - Dropdown menu

**Note:** Do not change these IDs as they're required for functionality.

### Custom Flag Images

Currently, the plugin supports flag emojis only. To use custom flag images:

1. Hide emoji flags with CSS: `.a11ylang-switcher__flag { display: none; }`
2. Add background images via CSS:
```css
.a11ylang-switcher__link[data-lang="fr"]::before {
    content: "";
    display: inline-block;
    width: 24px;
    height: 16px;
    background: url('/path/to/fr-flag.png');
    margin-right: 8px;
}
```

## Support

If you encounter issues not covered in this guide:

1. Check the [CHANGELOG.md](CHANGELOG.md) for known issues
2. Search existing [GitHub Issues](https://github.com/yourusername/a11y-language-switcher/issues)
3. Create a new issue with:
   - WordPress version
   - PHP version
   - Plugin version
   - Steps to reproduce
   - Browser console errors (if any)
