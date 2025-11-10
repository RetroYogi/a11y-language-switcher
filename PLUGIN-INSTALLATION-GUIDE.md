# WordPress Plugin - Installation Guide

## 🎉 Your Plugin is Ready!

I've converted your language switcher into a complete WordPress plugin. **No more copying code into functions.php!**

## 📦 What's Included

The plugin folder `accessible-a11ylang-language-switcher/` contains:

```
accessible-a11ylang-language-switcher/
├── accessible-a11ylang-language-switcher.php  # Main plugin file
├── admin/
│   └── settings.php                           # Settings page (admin panel)
├── assets/
│   ├── css/
│   │   └── language-switcher.css              # Styles (auto-loaded)
│   └── js/
│       └── language-switcher.js               # JavaScript (auto-loaded)
├── includes/
│   ├── functions.php                          # Helper functions
│   └── template.php                           # HTML template
├── readme.txt                                 # WordPress.org format
├── README.md                                  # GitHub documentation
├── INSTALLATION.md                            # Detailed setup guide
└── CHANGELOG.md                               # Version history
```

## 🚀 Quick Installation (2 Minutes!)

### Step 1: Create ZIP File

**On Mac:**
1. Right-click the `accessible-a11ylang-language-switcher` folder
2. Click "Compress"
3. You'll get `accessible-a11ylang-language-switcher.zip`

**On Windows:**
1. Right-click the `accessible-a11ylang-language-switcher` folder
2. Select "Send to → Compressed (zipped) folder"
3. You'll get `accessible-a11ylang-language-switcher.zip`

### Step 2: Upload to WordPress

1. Go to **WordPress Dashboard → Plugins → Add New**
2. Click **"Upload Plugin"** at the top
3. Click **"Choose File"** and select your ZIP file
4. Click **"Install Now"**
5. Click **"Activate Plugin"**

### Step 3: Add to Your Site

Simply add this shortcode where you want the language switcher:

```
[a11ylang_language_switcher]
```

**That's it!** No functions.php editing needed! 🎉

## ⚙️ Settings (Optional)

Go to **Settings → Language Switcher** to:

1. **Enable Debug Mode** - For troubleshooting (shows console logs)
2. **Customize Flags** - Change flag emojis for your languages

**Note:** Language names and URLs are automatically pulled from Polylang!

## 📍 Where to Add the Shortcode

### Option 1: In Header (Recommended)

**Block Theme (FSE):**
1. Go to **Appearance → Editor**
2. Click "Header" template
3. Add "Shortcode" block
4. Enter: `[a11ylang_language_switcher]`
5. Save

**Classic Theme:**
Edit your theme's `header.php`:
```php
<?php echo do_shortcode('[a11ylang_language_switcher]'); ?>
```

### Option 2: In Navigation Menu

1. **Appearance → Menus**
2. Add "Custom HTML" menu item
3. Content: `[a11ylang_language_switcher]`
4. Save menu

### Option 3: In Page Content

**Gutenberg:**
1. Add "Shortcode" block
2. Enter: `[a11ylang_language_switcher]`

**Classic Editor:**
1. Switch to Text mode
2. Add: `[a11ylang_language_switcher]`

### Option 4: In Widget Area

1. **Appearance → Widgets**
2. Add "Shortcode" widget
3. Enter: `[a11ylang_language_switcher]`

## ✨ Key Features

### What Makes This Plugin Special?

✅ **Handles Translated Slugs** - Works when URLs are different:
   - French: `/services/`
   - English: `/en/digital-services/`
   - German: `/de/dienstleistungen/`

✅ **Fully Accessible** - WCAG 2.1 AA compliant:
   - Full keyboard navigation
   - Screen reader support
   - High contrast mode
   - Reduced motion support

✅ **No Configuration Needed** - Uses Polylang's settings:
   - Language names → From Polylang
   - Language URLs → From Polylang
   - Translations → From Polylang

✅ **Clean Admin Integration**:
   - Settings page in WordPress admin
   - Debug mode for troubleshooting
   - Customizable language flags

## 🔧 Customization

### Change Flag Emojis

Go to **Settings → Language Switcher** and change flags for each language:
- Default: 🇫🇷 🇬🇧 🇩🇪
- Custom: FR EN DE (text)
- Or use different flag emojis

### Custom CSS

Add to your theme's custom CSS:

```css
/* Change button colors */
.a11ylang-switcher__button {
    background-color: #your-color;
    border-color: #your-border;
}

/* Change dropdown colors */
.a11ylang-switcher__link:hover {
    background-color: #your-hover-color;
}

/* Hide flags (show only text) */
.a11ylang-switcher__flag {
    display: none;
}
```

## 🐛 Troubleshooting

### Plugin Won't Activate?

**Error: "Polylang plugin is required"**

**Solution:**
1. Install Polylang plugin first
2. Activate Polylang
3. Then activate this plugin

### Switcher Not Showing?

**Check:**
1. ✅ Did you add the shortcode `[a11ylang_language_switcher]`?
2. ✅ Is Polylang plugin active?
3. ✅ Are there at least 2 languages in Polylang settings?

**Test:**
1. Add shortcode to a test page
2. View page on frontend
3. Press F12 (browser console)
4. Look for JavaScript errors

### Enable Debug Mode

1. Go to **Settings → Language Switcher**
2. Check "Debug Mode"
3. Save
4. Open browser console (F12)
5. Reload page
6. Look for messages starting with `[Language Switcher]`

You should see:
```
[Language Switcher] Initializing language switcher
[Language Switcher] Languages from Polylang: [...]
[Language Switcher] Language link: fr → /
[Language Switcher] Language link: en → /en/home/
[Language Switcher] Language link: de → /de/start/
```

## 📋 Comparison: Old vs New

### Old Manual Method ❌
- Copy HTML to Custom HTML block
- Copy CSS to HFCM plugin (Header)
- Copy JavaScript to HFCM plugin (Footer)
- Copy PHP to functions.php
- Update 4 different places when making changes
- Risk of breaking site with PHP errors

### New Plugin Method ✅
1. Upload ZIP file
2. Activate plugin
3. Add shortcode
4. **Done!**

**Benefits:**
- ✅ No functions.php editing
- ✅ Easy to update
- ✅ Settings page in admin
- ✅ Can't break site (safe activation/deactivation)
- ✅ One-click install
- ✅ Professional integration

## 🎯 Testing Checklist

After installation:

- [ ] **Activation**
  - [ ] Plugin activates without errors
  - [ ] Settings page appears (Settings → Language Switcher)

- [ ] **Display**
  - [ ] Shortcode renders on frontend
  - [ ] All languages appear in dropdown
  - [ ] Current language is highlighted

- [ ] **Functionality**
  - [ ] Click opens dropdown
  - [ ] Clicking language switches page
  - [ ] Translated slugs work correctly
  - [ ] Dropdown closes on outside click

- [ ] **Keyboard**
  - [ ] Tab focuses the button
  - [ ] Enter/Space opens dropdown
  - [ ] Arrow keys navigate languages
  - [ ] Escape closes dropdown

- [ ] **Mobile**
  - [ ] Button is large enough to tap
  - [ ] Dropdown works on touch devices
  - [ ] Responsive design looks good

## 📚 Documentation Files

- **`README.md`** - Main documentation (features, usage, customization)
- **`INSTALLATION.md`** - Detailed installation guide
- **`CHANGELOG.md`** - Version history
- **`readme.txt`** - WordPress.org format (for plugin directory)

## 🔄 Updating the Plugin

When you make changes:

1. Edit files in the plugin folder
2. Increment version in main plugin file:
   ```php
   * Version: 1.0.1
   ```
3. Add changes to `CHANGELOG.md`
4. Create new ZIP
5. Upload to WordPress (it will ask to replace)

## 🗑️ Uninstalling

### To Temporarily Disable
1. **Plugins** → Find plugin → Click **"Deactivate"**
2. Settings are preserved

### To Completely Remove
1. **Plugins** → Find plugin → Click **"Deactivate"**
2. Click **"Delete"**
3. Settings will be removed from database

## 🎓 How It Works

### Behind the Scenes

1. **PHP (Main Plugin)**
   - Registers with WordPress
   - Creates settings page
   - Outputs Polylang translation data as JSON

2. **JavaScript**
   - Reads JSON data
   - Creates language links with correct URLs
   - Handles keyboard navigation

3. **CSS**
   - Styles the switcher
   - Responsive design
   - Accessibility features

### Data Flow

```
Polylang Settings
       ↓
PHP: pll_the_languages()
       ↓
JSON: window.polylangTranslations
       ↓
JavaScript: Creates dropdown
       ↓
User sees language switcher!
```

## 🆘 Support

If you need help:

1. **Check documentation** - README.md, INSTALLATION.md
2. **Enable debug mode** - See console messages
3. **Test with default theme** - Rule out theme conflicts
4. **Check Polylang** - Verify it's configured correctly
5. **Contact support** - https://key4.lu

## 🎉 Success!

Your language switcher is now:
- ✅ A professional WordPress plugin
- ✅ Easy to install (one-click)
- ✅ Easy to update
- ✅ Has admin settings
- ✅ Fully accessible
- ✅ Works with translated slugs

**No more manual code copying!** 🚀

---

**Plugin created by:** Gérard Kieffer
**Website:** https://key4.lu
**License:** GPL v2 or later
