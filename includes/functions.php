<?php
/**
 * Helper Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render language switcher (for use in theme templates)
 * SECURITY: Properly handles output and escaping
 *
 * @param array $args Optional arguments
 * @return void
 */
function apls_language_switcher($args = array()) {
    // SECURITY: Output is already sanitized by the template.php and shortcode handler
    // do_shortcode() is safe as it returns sanitized HTML from our template
    echo wp_kses_post(do_shortcode('[a11ylang_language_switcher]'));
}

/**
 * Check if plugin is properly configured
 *
 * @return bool True if configured, false otherwise
 */
function apls_is_configured() {
    return function_exists('pll_the_languages');
}

/**
 * Get plugin version
 *
 * @return string Version number
 */
function apls_get_version() {
    return defined('APLS_VERSION') ? APLS_VERSION : '1.0.1';
}
