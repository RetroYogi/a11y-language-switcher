/**
 * Accessible Language Switcher for Polylang
 * Uses Polylang's actual translation URLs (respects translated slugs)
 *
 * SECURITY: v1.0.1 - Added input validation and XSS prevention
 */

(function() {
  'use strict';

  // Settings from PHP (passed via wp_localize_script)
  var DEBUG = typeof aplsSettings !== 'undefined' ? aplsSettings.debugMode : false;
  var DISPLAY_MODE = typeof aplsSettings !== 'undefined' ? aplsSettings.displayMode : 'flag_and_name';

  // SECURITY: Validate that required data exists and is properly formed
  function validateData() {
    if (!window.polylangTranslations || !Array.isArray(window.polylangTranslations)) {
      debug('ERROR', 'Invalid or missing Polylang translation data');
      return false;
    }

    if (!window.aplsFlags || typeof window.aplsFlags !== 'object') {
      debug('ERROR', 'Invalid or missing flag data');
      return false;
    }

    return true;
  }

  // SECURITY: Sanitize text content to prevent XSS
  function sanitizeText(text) {
    var div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  // SECURITY: Validate URL before using it
  function isValidUrl(url) {
    try {
      var urlObj = new URL(url, window.location.origin);
      // Only allow http and https protocols
      return urlObj.protocol === 'http:' || urlObj.protocol === 'https:';
    } catch (e) {
      return false;
    }
  }

  // Helper function for debug logging
  function debug(label, value) {
    if (DEBUG) {
      console.log('[Language Switcher]', label + ':', value);
    }
  }

  // Wait for DOM to be ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  function init() {
    debug('Initializing language switcher', '');

    // SECURITY: Validate data before proceeding
    if (!validateData()) {
      debug('ERROR', 'Data validation failed');
      return;
    }

    var languages = window.polylangTranslations;
    var flags = window.aplsFlags || {};
    debug('Languages from Polylang', JSON.stringify(languages, null, 2));
    debug('Language flags', JSON.stringify(flags, null, 2));

    var switcher = document.getElementById('a11ylang-switcher');
    if (!switcher) {
      debug('ERROR', 'Could not find #a11ylang-switcher element');
      return;
    }

    // Add display mode as data attribute for CSS styling
    switcher.setAttribute('data-display-mode', DISPLAY_MODE);

    var button = document.getElementById('a11ylang-button');
    var dropdown = document.getElementById('a11ylang-dropdown');
    var currentLangElement = document.getElementById('current-lang');

    if (!button || !dropdown || !currentLangElement) {
      debug('ERROR', 'Missing required elements');
      return;
    }

    // Find current language
    var currentLang = null;
    for (var i = 0; i < languages.length; i++) {
      if (languages[i].current) {
        currentLang = languages[i];
        break;
      }
    }
    if (!currentLang) {
      currentLang = languages[0];
    }

    debug('Current language', currentLang.code + ' (' + currentLang.name + ')');

    // Populate dropdown with language options
    populateLanguages(dropdown, languages, currentLang, flags);

    // Update current language display
    updateCurrentLanguage(currentLangElement, currentLang, flags);

    // Button click handler
    button.addEventListener('click', function() {
      toggleDropdown(button, dropdown);
    });

    // Keyboard navigation
    button.addEventListener('keydown', function(e) {
      handleButtonKeydown(e, button, dropdown);
    });

    dropdown.addEventListener('keydown', function(e) {
      handleDropdownKeydown(e, button, dropdown);
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
      if (!switcher.contains(e.target)) {
        closeDropdown(button, dropdown);
      }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeDropdown(button, dropdown);
        button.focus();
      }
    });
  }

  function populateLanguages(dropdown, languages, currentLang, flags) {
    debug('Populating languages dropdown', '');
    dropdown.innerHTML = '';

    languages.forEach(function(lang) {
      // SECURITY: Validate language object has required properties
      if (!lang.code || !lang.name || !lang.url) {
        debug('WARNING', 'Skipping invalid language object');
        return;
      }

      // SECURITY: Validate URL before using it
      if (!isValidUrl(lang.url)) {
        debug('WARNING', 'Skipping invalid URL for language: ' + lang.code);
        return;
      }

      var li = document.createElement('li');
      li.setAttribute('role', 'none');

      var link = document.createElement('a');
      link.className = 'a11ylang-switcher__link';
      link.setAttribute('role', 'menuitem');
      link.setAttribute('lang', sanitizeText(lang.code));

      // Use Polylang's actual URL (already validated)
      link.href = lang.url;

      debug('Language link', lang.code + ' (' + lang.name + ') → ' + lang.url);

      if (lang.current) {
        link.setAttribute('aria-current', 'page');
        debug('Marking as current language', lang.code + ' (' + lang.name + ')');
      }

      // Create elements based on display mode
      var flag, code, name;

      switch (DISPLAY_MODE) {
        case 'flag_only':
          // Show only flag
          flag = document.createElement('span');
          flag.className = 'a11ylang-switcher__flag';
          flag.setAttribute('aria-hidden', 'true');
          flag.textContent = sanitizeText(flags[lang.code] || '🌐');
          link.appendChild(flag);

          // Add visually hidden name for screen readers
          name = document.createElement('span');
          name.className = 'a11ylang-switcher__lang-name a11ylang-sr-only';
          name.textContent = sanitizeText(lang.name);
          link.appendChild(name);
          break;

        case 'code_only':
          // Show only language code (uppercase)
          code = document.createElement('span');
          code.className = 'a11ylang-switcher__lang-code';
          code.setAttribute('aria-hidden', 'true');
          code.textContent = sanitizeText(lang.code.toUpperCase());
          link.appendChild(code);

          // Add visually hidden name for screen readers
          name = document.createElement('span');
          name.className = 'a11ylang-switcher__lang-name a11ylang-sr-only';
          name.textContent = sanitizeText(lang.name);
          link.appendChild(name);
          break;

        case 'name_only':
          // Show only language name (visible and for screen readers)
          name = document.createElement('span');
          name.className = 'a11ylang-switcher__lang-name';
          name.textContent = sanitizeText(lang.name);
          link.appendChild(name);
          break;

        case 'flag_and_name':
        default:
          // Show flag and name
          flag = document.createElement('span');
          flag.className = 'a11ylang-switcher__flag';
          flag.setAttribute('aria-hidden', 'true');
          flag.textContent = sanitizeText(flags[lang.code] || '🌐');
          link.appendChild(flag);

          name = document.createElement('span');
          name.className = 'a11ylang-switcher__lang-name';
          name.textContent = sanitizeText(lang.name);
          link.appendChild(name);
          break;
      }
      li.appendChild(link);
      dropdown.appendChild(li);
    });
  }

  function updateCurrentLanguage(element, lang, flags) {
    var icon = element.querySelector('.a11ylang-switcher__icon');
    var text = element.querySelector('.a11ylang-switcher__text');

    if (!icon || !text) {
      return;
    }

    // Update based on display mode
    switch (DISPLAY_MODE) {
      case 'flag_only':
        icon.textContent = sanitizeText(flags[lang.code] || '🌐');
        icon.setAttribute('aria-hidden', 'true');
        // Text is visually hidden but read by screen readers
        text.textContent = sanitizeText(lang.name);
        text.className = 'a11ylang-switcher__text a11ylang-sr-only';
        break;

      case 'code_only':
        icon.textContent = sanitizeText(lang.code.toUpperCase());
        icon.setAttribute('aria-hidden', 'true');
        icon.className = 'a11ylang-switcher__lang-code';
        // Text is visually hidden but read by screen readers
        text.textContent = sanitizeText(lang.name);
        text.className = 'a11ylang-switcher__text a11ylang-sr-only';
        break;

      case 'name_only':
        // Hide icon completely
        icon.style.display = 'none';
        // Show only name
        text.textContent = sanitizeText(lang.name);
        text.className = 'a11ylang-switcher__text';
        break;

      case 'flag_and_name':
      default:
        icon.textContent = sanitizeText(flags[lang.code] || '🌐');
        icon.setAttribute('aria-hidden', 'true');
        icon.className = 'a11ylang-switcher__icon';
        text.textContent = sanitizeText(lang.name);
        text.className = 'a11ylang-switcher__text';
        break;
    }
  }

  function toggleDropdown(button, dropdown) {
    var isExpanded = button.getAttribute('aria-expanded') === 'true';

    if (isExpanded) {
      closeDropdown(button, dropdown);
    } else {
      openDropdown(button, dropdown);
    }
  }

  function openDropdown(button, dropdown) {
    button.setAttribute('aria-expanded', 'true');
    dropdown.classList.add('is-open');

    // Focus first link in dropdown
    var firstLink = dropdown.querySelector('.a11ylang-switcher__link:not([aria-current="page"])');
    if (firstLink) {
      setTimeout(function() {
        firstLink.focus();
      }, 50);
    }
  }

  function closeDropdown(button, dropdown) {
    button.setAttribute('aria-expanded', 'false');
    dropdown.classList.remove('is-open');
  }

  function handleButtonKeydown(e, button, dropdown) {
    switch(e.key) {
      case 'ArrowDown':
      case 'ArrowUp':
      case 'Enter':
      case ' ':
        e.preventDefault();
        openDropdown(button, dropdown);
        break;
    }
  }

  function handleDropdownKeydown(e, button, dropdown) {
    var links = Array.from(dropdown.querySelectorAll('.a11ylang-switcher__link'));
    var currentIndex = links.indexOf(document.activeElement);

    switch(e.key) {
      case 'ArrowDown':
        e.preventDefault();
        var nextIndex = (currentIndex + 1) % links.length;
        links[nextIndex].focus();
        break;

      case 'ArrowUp':
        e.preventDefault();
        var prevIndex = currentIndex <= 0 ? links.length - 1 : currentIndex - 1;
        links[prevIndex].focus();
        break;

      case 'Home':
        e.preventDefault();
        links[0].focus();
        break;

      case 'End':
        e.preventDefault();
        links[links.length - 1].focus();
        break;

      case 'Escape':
        e.preventDefault();
        closeDropdown(button, dropdown);
        button.focus();
        break;

      case 'Tab':
        // Allow Tab to work normally for keyboard navigation
        // Close dropdown when Tab moves focus outside
        setTimeout(function() {
          if (!dropdown.contains(document.activeElement) && document.activeElement !== button) {
            closeDropdown(button, dropdown);
          }
        }, 0);
        break;
    }
  }
})();
