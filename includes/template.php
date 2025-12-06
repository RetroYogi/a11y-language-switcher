<?php
/**
 * Language Switcher HTML Template
 */

if (!defined('ABSPATH')) {
    exit;
}

// SECURITY FIX: Properly sanitize class parameter
$extra_class = '';
if (!empty($atts['class'])) {
    // Split by spaces, sanitize each class, rejoin
    $classes = array_filter(array_map('sanitize_html_class', explode(' ', $atts['class'])));
    if (!empty($classes)) {
        $extra_class = ' ' . implode(' ', $classes);
    }
}
?>

<!-- Accessible Language Switcher for Polylang -->
<div class="a11ylang-switcher<?php echo $extra_class; ?>" id="a11ylang-switcher">
  <button
    class="a11ylang-switcher__button"
    aria-expanded="false"
    aria-haspopup="true"
    aria-controls="a11ylang-dropdown"
    id="a11ylang-button"
  >
    <span class="a11ylang-switcher__current" id="current-lang">
      <!-- Current language will be inserted here by JavaScript -->
      <span class="a11ylang-switcher__icon">🌐</span>
      <span class="a11ylang-switcher__text"><?php _e('Language', 'accessible-a11ylang-switcher'); ?></span>
    </span>
    <span class="a11ylang-switcher__arrow" aria-hidden="true">▼</span>
  </button>

  <ul
    class="a11ylang-switcher__dropdown"
    id="a11ylang-dropdown"
    role="menu"
    aria-labelledby="a11ylang-button"
  >
    <!-- Language options will be dynamically populated by JavaScript -->
  </ul>
</div>
