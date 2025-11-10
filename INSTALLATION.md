# Installation Guide - Accessible Polylang Language Switcher

## Quick Installation (5 Minutes)

### Step 1: Prepare Plugin for Upload

1. **Compress the plugin folder** into a ZIP file:
   - Right-click on `accessible-a11ylang-language-switcher` folder
   - Select "Compress" (Mac) or "Send to → Compressed folder" (Windows)
   - You'll get `accessible-a11ylang-language-switcher.zip`

### Step 2: Install in WordPress

1. Go to **WordPress Dashboard → Plugins → Add New**
2. Click **Upload Plugin** at the top
3. Click **Choose File** and select your ZIP file
4. Click **Install Now**
5. Click **Activate Plugin**

### Step 3: Verify Installation

Check that you see:
✅ Success message: "Plugin activated"
✅ New menu item: **Settings → Language Switcher**

If you see an error about Polylang missing:
❌ Install and activate Polylang plugin first
❌ Then reactivate this plugin

### Step 4: Add to Your Site

Add the shortcode where you want the language switcher:

```
[a11ylang_language_switcher]
```

**Common places:**
- Header (Appearance → Editor → Header template)
- Navigation menu (use a custom HTML menu item)
- Sidebar widget (use a Shortcode widget)
- Page content (any page or post)

## Detailed Installation Methods

### Method 1: WordPress Admin Upload (Easiest)

**Requirements:**
- Access to WordPress Dashboard
- Polylang plugin installed

**Steps:**

1. **Create ZIP file**
   ```
   Right-click accessible-a11ylang-language-switcher folder
   → Compress/Create ZIP
   ```

2. **Upload to WordPress**
   - Dashboard → Plugins → Add New
   - Click "Upload Plugin"
   - Choose ZIP file
   - Click "Install Now"

3. **Activate**
   - Click "Activate Plugin"

4. **Configure (Optional)**
   - Go to Settings → Language Switcher
   - Customize flags if needed
   - Enable debug mode if troubleshooting

### Method 2: FTP Upload (Manual)

**Requirements:**
- FTP access to your server
- FTP client (FileZilla, Cyberduck, etc.)
- Polylang plugin installed

**Steps:**

1. **Connect to server via FTP**
   - Host: your-site.com
   - Username: your-ftp-username
   - Password: your-ftp-password

2. **Navigate to plugins directory**
   ```
   /wp-content/plugins/
   ```

3. **Upload plugin folder**
   - Upload entire `accessible-a11ylang-language-switcher` folder
   - Make sure structure is:
     ```
     /wp-content/plugins/accessible-a11ylang-language-switcher/
     ├── accessible-a11ylang-language-switcher.php
     ├── admin/
     ├── assets/
     └── includes/
     ```

4. **Activate in WordPress**
   - Dashboard → Plugins
   - Find "Accessible Polylang Language Switcher"
   - Click "Activate"

### Method 3: WP-CLI (Command Line)

**Requirements:**
- SSH access to server
- WP-CLI installed

**Steps:**

```bash
# Navigate to WordPress directory
cd /path/to/wordpress

# Upload plugin folder to wp-content/plugins/
# (Use SCP, FTP, or Git)

# Activate plugin
wp plugin activate accessible-a11ylang-language-switcher

# Verify activation
wp plugin list | grep accessible-a11ylang
```

## Configuration

### Basic Setup (No Configuration Needed!)

The plugin works out-of-the-box with Polylang's settings:
- ✅ Language names → From Polylang
- ✅ Language URLs → From Polylang
- ✅ Current language → Detected automatically

### Optional Customization

Go to **Settings → Language Switcher**:

1. **Debug Mode**
   - Enable for troubleshooting
   - Shows console logs in browser (F12)

2. **Language Flags**
   - Customize flag emojis
   - Default: 🇫🇷 🇬🇧 🇩🇪 🇪🇸 etc.
   - Change to text: FR, EN, DE, etc.

## Adding the Switcher to Your Site

### Option 1: Shortcode (Easiest)

Add anywhere in content:
```
[a11ylang_language_switcher]
```

**Gutenberg:**
1. Add "Shortcode" block
2. Enter: `[a11ylang_language_switcher]`

**Classic Editor:**
1. Switch to Text mode
2. Add: `[a11ylang_language_switcher]`

### Option 2: PHP Template Code

In your theme files (e.g., `header.php`):

```php
<?php
if (function_exists('apls_language_switcher')) {
    apls_language_switcher();
}
?>
```

Or using shortcode:
```php
<?php echo do_shortcode('[a11ylang_language_switcher]'); ?>
```

### Option 3: Navigation Menu

1. Go to **Appearance → Menus**
2. Expand "Custom Links"
3. Add item:
   - URL: `#` (or leave empty)
   - Link Text: (leave empty)
4. Click "Add to Menu"
5. Expand the menu item
6. In "Description" field, add: `[a11ylang_language_switcher]`
7. Save menu

**Note:** Your theme must support menu item descriptions for this to work.

### Option 4: Widget

1. Go to **Appearance → Widgets**
2. Add "Shortcode" widget (or "Custom HTML" widget)
3. Enter: `[a11ylang_language_switcher]`
4. Save

### Option 5: Block Theme (FSE)

1. Go to **Appearance → Editor**
2. Select template to edit (e.g., Header)
3. Add "Shortcode" block
4. Enter: `[a11ylang_language_switcher]`
5. Save

## Verification

### Check Installation

1. **Visit your site** (frontend)
2. **Look for language switcher**
   - Should show current language
   - Click to see dropdown
   - All languages should appear

3. **Test functionality**
   - Click different languages
   - Verify page switches correctly
   - Check translated slugs work

### Debug Mode Test

1. **Enable debug mode**
   - Settings → Language Switcher
   - Check "Debug Mode"
   - Save

2. **Open browser console**
   - Press F12
   - Go to "Console" tab

3. **Reload page**
   - Look for messages starting with `[Language Switcher]`
   - Should show:
     ```
     [Language Switcher] Initializing language switcher
     [Language Switcher] Languages from Polylang: [...]
     [Language Switcher] Language link: fr → /
     [Language Switcher] Language link: en → /en/home/
     ```

4. **Verify URLs**
   - Each language should have correct URL
   - Translated slugs should be different

## Troubleshooting

### Plugin Won't Activate

**Error: "Polylang plugin is required"**

**Solution:**
1. Install Polylang plugin first
2. Activate Polylang
3. Then activate this plugin

### Switcher Doesn't Appear

**Check:**
1. ✅ Shortcode added to page?
2. ✅ Polylang plugin active?
3. ✅ At least 2 languages configured in Polylang?

**Test:**
1. Add shortcode to test page
2. View page on frontend
3. Open browser console (F12)
4. Look for errors

### Wrong Language URLs

**Enable debug mode:**
1. Settings → Language Switcher
2. Enable debug mode
3. Check console output
4. Verify Polylang is providing correct URLs

**Verify Polylang setup:**
1. Go to Languages settings in Polylang
2. Check URL structure is set correctly
3. Verify translations exist for current page

### Styling Issues

**Theme conflicts:**
```css
/* Add to your theme's custom CSS */
.a11ylang-switcher__button {
    /* Override theme styles */
    all: unset;
    /* Then add plugin styles */
}
```

## Updating the Plugin

### Via WordPress Admin

1. Dashboard → Plugins
2. Find "Accessible Polylang Language Switcher"
3. Click "Update Now" (when available)

### Manual Update

1. **Deactivate** old version (don't delete yet)
2. **Upload** new version
3. **Activate** new version
4. **Delete** old version if prompted

**Note:** Settings are preserved during updates.

## Uninstallation

### Via WordPress Admin

1. Dashboard → Plugins
2. Find plugin
3. Click "Deactivate"
4. Click "Delete"

**Note:** Settings will be deleted with the plugin.

### Manual Removal

1. Delete folder via FTP:
   ```
   /wp-content/plugins/accessible-a11ylang-language-switcher/
   ```

2. (Optional) Clean database:
   ```sql
   DELETE FROM wp_options WHERE option_name = 'apls_settings';
   ```

## Next Steps

1. ✅ **Test on different pages**
   - Homepage
   - Regular pages
   - Posts
   - Archives

2. ✅ **Test language switching**
   - Click each language
   - Verify URLs are correct
   - Check translated slugs work

3. ✅ **Customize appearance** (optional)
   - Add custom CSS
   - Change colors to match theme
   - Adjust positioning

4. ✅ **Test accessibility**
   - Keyboard navigation (Tab, Arrows, Enter, Esc)
   - Screen reader (if available)
   - Mobile devices

## Support

Need help? Check:
- Plugin README.md
- Settings → Language Switcher (usage examples)
- Debug mode console output
- https://key4.lu

---

**Installation complete!** 🎉

Your accessible language switcher is now ready to use.
