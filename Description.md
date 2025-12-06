# A Language Switcher That Works With Polylang

I manage several websites in multiple languages, from very small to larger sites. For managing translations, I use a wonderful tool called Polylang.

Polylang comes in two versions: a free version and a paid "Pro" version. Both are excellent. The free version is remarkably capable and does everything most websites need.

## A Small Problem with a Simple Solution

I like to keep up to date with new WordPress features. Therefore I've been using the block-based WordPress interface for a few years, sometimes called Full Site Editing. It's more flexible and easier to use.

But here's what I discovered: the free version of Polylang doesn't have a ready-made solution for the newer block-based themes. It only allows inserting the language switcher through the classic menu system or through a legacy widget. Both are not supported in modern themes.

So I built the **A11y Language Switcher**.

## What Does It Do?

This plugin adds a language switcher to your WordPress site that works seamlessly with block-based themes and Full Site Editing. It displays as a button showing your current language with a flag, and when clicked, opens a dropdown menu listing all your available languages.

Here's what makes this plugin special:

**It works for everyone**: The plugin is built with accessibility as a core feature. It includes full keyboard navigation (using Tab, Arrow keys, Enter, and Escape).

**It's easy to add**: You don't need technical expertise to use it. Simply add the shortcode `[a11ylang_language_switcher]` wherever you want the language switcher to appear.

**It connects directly with Polylang**
The plugin uses Polylang's translation data to ensure visitors always land on the correct translated page. Even when your page slugs are translated (like "services" becoming "servicios" in Spanish), the switcher finds the right URL. It works with both Polylang Free and Polylang Pro.

## Getting Started

A11y Language Switcher is not yet available on the WordPress store:

1. **Download** the plugin through as a ZIP archive from GitHub
2. **Install**: Upload it via your WordPress plugins page and activate it.
3. **Add the shortcode** `[a11ylang_language_switcher]` to your header, footer, or wherever you want the language switcher to appear
4. **Customize** (optional) the flag emojis and styling through the settings page

## Settings

The settings page is located in the WordPress settings menu and it is named "Language Switcher".