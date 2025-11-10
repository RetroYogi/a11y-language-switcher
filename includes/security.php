<?php
/**
 * Security Functions and Helpers
 *
 * @package Accessible_a11ylang_language_Switcher
 * @since 1.0.1
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Security helper class
 */
class APLS_Security {

    /**
     * Initialize security features
     */
    public static function init() {
        add_action('admin_init', array(__CLASS__, 'add_security_headers'));
        add_action('init', array(__CLASS__, 'check_debug_mode_warning'));
    }

    /**
     * Add security headers for admin pages
     */
    public static function add_security_headers() {
        if (is_admin()) {
            // Add Content Security Policy for admin pages
            header("X-Content-Type-Options: nosniff");
            header("X-Frame-Options: SAMEORIGIN");
            header("X-XSS-Protection: 1; mode=block");
        }
    }

    /**
     * Check if debug mode is enabled and show warning
     */
    public static function check_debug_mode_warning() {
        if (is_admin() && current_user_can('manage_options')) {
            $options = get_option('apls_settings', array());
            $debug_mode = isset($options['debug_mode']) ? $options['debug_mode'] : false;

            if ($debug_mode) {
                add_action('admin_notices', array(__CLASS__, 'debug_mode_warning'));
            }
        }
    }

    /**
     * Show debug mode warning
     */
    public static function debug_mode_warning() {
        ?>
        <div class="notice notice-warning">
            <p>
                <strong><?php esc_html_e('Accessible Polylang Language Switcher:', 'accessible-a11ylang-switcher'); ?></strong>
                <?php esc_html_e('Debug mode is enabled. This should be disabled in production environments.', 'accessible-a11ylang-switcher'); ?>
                <a href="<?php echo esc_url(admin_url('options-general.php?page=apls-settings')); ?>">
                    <?php esc_html_e('Disable debug mode', 'accessible-a11ylang-switcher'); ?>
                </a>
            </p>
        </div>
        <?php
    }

    /**
     * Validate and sanitize shortcode attributes
     *
     * @param array $atts Raw attributes
     * @return array Sanitized attributes
     */
    public static function sanitize_shortcode_atts($atts) {
        $sanitized = array();

        if (isset($atts['class'])) {
            // Split by spaces, sanitize each class, filter empty values
            $classes = array_filter(array_map('sanitize_html_class', explode(' ', $atts['class'])));
            $sanitized['class'] = implode(' ', $classes);
        }

        return $sanitized;
    }

    /**
     * Sanitize flag emoji/text
     *
     * @param string $flag Flag emoji or text
     * @return string Sanitized flag
     */
    public static function sanitize_flag($flag) {
        // Remove any HTML tags
        $flag = wp_strip_all_tags($flag);

        // Trim whitespace
        $flag = trim($flag);

        // Limit length (emojis can be 2-4 bytes, allow up to 10 chars)
        $flag = mb_substr($flag, 0, 10);

        // Remove any control characters and non-printable characters
        $flag = preg_replace('/[\x00-\x1F\x7F]/u', '', $flag);

        // If empty after sanitization, return default
        if (empty($flag)) {
            return '🌐';
        }

        // Additional validation: check if it's a reasonable emoji or text
        // Allow letters, numbers, common punctuation, and emoji characters
        if (!preg_match('/^[\p{L}\p{N}\p{M}\p{S}\p{Zs}]+$/u', $flag)) {
            return '🌐'; // Return default for invalid characters
        }

        return $flag;
    }

    /**
     * Rate limit settings updates
     *
     * @param string $user_id User ID
     * @return bool True if allowed, false if rate limited
     */
    public static function check_rate_limit($user_id) {
        $transient_key = 'apls_settings_update_' . $user_id;
        $last_update = get_transient($transient_key);

        if ($last_update) {
            return false; // Rate limited
        }

        // Set transient for 10 seconds
        set_transient($transient_key, time(), 10);
        return true;
    }
}

// Initialize security features
APLS_Security::init();
