/**
 * Accessible Language Switcher for Polylang
 * Fully keyboard accessible with ARIA support
 */

(function() {
  'use strict';

  // DEBUG MODE - Set to true to enable console logging
  const DEBUG = true;

  // Language configuration - CUSTOMIZE THIS SECTION
  const languages = [
		{ code: 'fr', name: 'Français', flag: '🇫🇷' },
    { code: 'en', name: 'English', flag: '🇬🇧' },
    { code: 'de', name: 'Deutsch', flag: '🇩🇪' },
    // Add more languages as needed
  ];

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

    const switcher = document.getElementById('a11ylang-switcher');
    if (!switcher) {
      debug('ERROR', 'Could not find #a11ylang-switcher element');
      return;
    }

    const button = document.getElementById('a11ylang-button');
    const dropdown = document.getElementById('a11ylang-dropdown');
    const currentLangElement = document.getElementById('current-lang');

    if (!button || !dropdown || !currentLangElement) {
      debug('ERROR', 'Missing required elements');
      return;
    }

    debug('Available languages', languages.map(l => l.code).join(', '));
    debug('Default language (first in array)', languages[0].code);

    // Detect current language from URL or HTML lang attribute
    const currentLang = detectCurrentLanguage();

    // Populate dropdown with language options
    populateLanguages(dropdown, currentLang);

    // Update current language display
    updateCurrentLanguage(currentLangElement, currentLang);

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

  function detectCurrentLanguage() {
    debug('Current URL', window.location.href);
    debug('Current pathname', window.location.pathname);

    // Get all valid language codes from config
    const validLangCodes = languages.map(l => l.code);
    debug('Valid language codes', validLangCodes.join(', '));

    // Try to detect from URL path (Polylang uses /en/, /es/, etc.)
    // Look for language code at the start of the path: /en/ or /en/page or /en
    const pathParts = window.location.pathname.split('/').filter(Boolean);
    debug('Path parts', pathParts);

    if (pathParts.length > 0 && validLangCodes.includes(pathParts[0])) {
      debug('Language detected from URL path', pathParts[0]);
      return pathParts[0];
    }

    // Try to detect from HTML lang attribute
    const htmlLang = document.documentElement.lang;
    debug('HTML lang attribute', htmlLang || 'not set');
    if (htmlLang) {
      const detectedLang = htmlLang.split('-')[0].toLowerCase();
      if (validLangCodes.includes(detectedLang)) {
        debug('Language detected from HTML lang', detectedLang);
        return detectedLang;
      }
    }

    // Try to detect from Polylang's body class (e.g., lang-en)
    const bodyClasses = document.body.className;
    debug('Body classes', bodyClasses);
    const langMatch = bodyClasses.match(/lang-([a-z]{2})/);
    if (langMatch && validLangCodes.includes(langMatch[1])) {
      debug('Language detected from body class', langMatch[1]);
      return langMatch[1];
    }

    // Default to first language in config
    debug('No language detected, using default', languages[0].code);
    return languages[0].code;
  }

  function populateLanguages(dropdown, currentLang) {
    debug('Populating languages dropdown', 'Current: ' + currentLang);
    dropdown.innerHTML = '';

    languages.forEach(function(lang) {
      const li = document.createElement('li');
      li.setAttribute('role', 'none');

      const link = document.createElement('a');
      link.className = 'a11ylang-switcher__link';
      link.setAttribute('role', 'menuitem');
      link.setAttribute('lang', lang.code);
      link.href = getLanguageUrl(lang.code);

      if (lang.code === currentLang) {
        link.setAttribute('aria-current', 'page');
        debug('Marking as current language', lang.code + ' (' + lang.name + ')');
      }

      const flag = document.createElement('span');
      flag.className = 'a11ylang-switcher__flag';
      flag.setAttribute('aria-hidden', 'true');
      flag.textContent = lang.flag;

      const name = document.createElement('span');
      name.className = 'a11ylang-switcher__lang-name';
      name.textContent = lang.name;

      link.appendChild(flag);
      link.appendChild(name);
      li.appendChild(link);
      dropdown.appendChild(li);
    });
  }

  function getLanguageUrl(langCode) {
    debug('Generating URL for language', langCode);

    const currentPath = window.location.pathname;
    const currentSearch = window.location.search;
    const currentHash = window.location.hash;
    const validLangCodes = languages.map(l => l.code);

    debug('Current path', currentPath);

    // Split path into parts and filter out empty strings
    const pathParts = currentPath.split('/').filter(Boolean);
    debug('Path parts', pathParts);

    // Check if first part is a language code and remove it
    let pathWithoutLang = pathParts;
    if (pathParts.length > 0 && validLangCodes.includes(pathParts[0])) {
      debug('Removing existing language code', pathParts[0]);
      pathWithoutLang = pathParts.slice(1);
    }

    debug('Path without language', pathWithoutLang);

    // Build new path
    let newPath;
    if (langCode === languages[0].code) {
      // Default language: no language code in URL
      newPath = '/' + pathWithoutLang.join('/');
      debug('Building default language URL', newPath);
    } else {
      // Non-default language: add language code at the start
      newPath = '/' + langCode + '/' + pathWithoutLang.join('/');
      debug('Building non-default language URL', newPath);
    }

    // Ensure path ends with / if the original did (except for homepage)
    if (currentPath.endsWith('/') && newPath !== '/') {
      newPath += '/';
    }

    // Clean up multiple slashes
    newPath = newPath.replace(/\/+/g, '/');

    const finalUrl = newPath + currentSearch + currentHash;
    debug('Final URL', finalUrl);

    return finalUrl;
  }

  function updateCurrentLanguage(element, langCode) {
    const lang = languages.find(l => l.code === langCode) || languages[0];
    
    const icon = element.querySelector('.a11ylang-switcher__icon');
    const text = element.querySelector('.a11ylang-switcher__text');

    if (icon) {
      icon.textContent = lang.flag;
    }

    if (text) {
      text.textContent = lang.name;
    }
  }

  function toggleDropdown(button, dropdown) {
    const isExpanded = button.getAttribute('aria-expanded') === 'true';
    
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
    const firstLink = dropdown.querySelector('.a11ylang-switcher__link:not([aria-current="page"])');
    if (firstLink) {
      setTimeout(() => firstLink.focus(), 50);
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
    const links = Array.from(dropdown.querySelectorAll('.a11ylang-switcher__link'));
    const currentIndex = links.indexOf(document.activeElement);

    switch(e.key) {
      case 'ArrowDown':
        e.preventDefault();
        const nextIndex = (currentIndex + 1) % links.length;
        links[nextIndex].focus();
        break;

      case 'ArrowUp':
        e.preventDefault();
        const prevIndex = currentIndex <= 0 ? links.length - 1 : currentIndex - 1;
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
        closeDropdown(button, dropdown);
        break;
    }
  }
})();
