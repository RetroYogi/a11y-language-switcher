<?php
/**
 * Plugin Name: A11y Language Switcher by Key4
 * Plugin URI: https://key4.lu
 * Description: Block-based language switcher for Polylang users with block themes. Fully accessible (WCAG 2.1 AA) with keyboard navigation. Perfect complement to Polylang Free when you need a modern language switcher.
 * Version: 1.1.0
 * Author: Gérard Kieffer
 * Author URI: https://key4.lu
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: accessible-a11ylang-switcher
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 8.0
 * Requires Plugins: polylang
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('APLS_VERSION', '1.1.0');
define('APLS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('APLS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('APLS_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Main Plugin Class
 */
class Accessible_a11ylang_language_Switcher {

    /**
     * Instance of this class
     */
    private static $instance = null;

    /**
     * Get instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        // Check if Polylang is active
        add_action('admin_init', array($this, 'check_polylang_dependency'));
        add_action('admin_notices', array($this, 'polylang_missing_notice'));

        // Initialize plugin
        add_action('plugins_loaded', array($this, 'init'));
    }

    /**
     * Initialize plugin
     */
    public function init() {
        // Load includes
        $this->load_includes();

        // Register shortcode
        add_shortcode('a11ylang_language_switcher', array($this, 'render_shortcode'));

        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));

        // Output Polylang translation data (priority 20 to run after enqueue_assets)
        add_action('wp_enqueue_scripts', array($this, 'output_polylang_translations'), 20);

        // Add settings page
        if (is_admin()) {
            require_once APLS_PLUGIN_DIR . 'admin/settings.php';
            new APLS_Admin_Settings();
        }
    }

    /**
     * Load includes
     */
    private function load_includes() {
        require_once APLS_PLUGIN_DIR . 'includes/security.php';
        require_once APLS_PLUGIN_DIR . 'includes/functions.php';
    }

    /**
     * Check if Polylang is active
     */
    public function check_polylang_dependency() {
        if (!function_exists('pll_the_languages')) {
            add_action('admin_notices', array($this, 'polylang_missing_notice'));
            deactivate_plugins(APLS_PLUGIN_BASENAME);
        }
    }

    /**
     * Display admin notice if Polylang is missing
     */
    public function polylang_missing_notice() {
        if (!function_exists('pll_the_languages')) {
            ?>
            <div class="notice notice-error">
                <p>
                    <strong><?php _e('Accessible Polylang Language Switcher', 'accessible-a11ylang-switcher'); ?></strong>
                    <?php _e('requires the Polylang plugin to be installed and activated.', 'accessible-a11ylang-switcher'); ?>
                </p>
            </div>
            <?php
        }
    }

    /**
     * Enqueue assets
     */
    public function enqueue_assets() {
        // Get options
        $options = get_option('apls_settings', array());
        $debug_mode = isset($options['debug_mode']) ? $options['debug_mode'] : false;

        // Enqueue CSS
        wp_enqueue_style(
            'apls-styles',
            APLS_PLUGIN_URL . 'assets/css/language-switcher.css',
            array(),
            APLS_VERSION
        );

        // Enqueue JavaScript
        wp_enqueue_script(
            'apls-script',
            APLS_PLUGIN_URL . 'assets/js/language-switcher.js',
            array(),
            APLS_VERSION,
            true
        );

        // Get display mode
        $display_mode = isset($options['display_mode']) ? $options['display_mode'] : 'flag_and_name';

        // Pass settings to JavaScript
        wp_localize_script('apls-script', 'aplsSettings', array(
            'debugMode' => $debug_mode,
            'displayMode' => $display_mode
        ));
    }

    /**
     * Output Polylang translation URLs as JSON
     * SECURITY: Uses wp_add_inline_script for safe JSON injection
     */
    public function output_polylang_translations() {
        if (!function_exists('pll_the_languages')) {
            return;
        }

        // Get translations for current page
        $translations = pll_the_languages(array(
            'raw' => 1,
            'echo' => 0
        ));

        if (empty($translations)) {
            return;
        }

        // Build clean array of language data with strict sanitization
        $lang_data = array();
        foreach ($translations as $lang) {
            $lang_data[] = array(
                'code' => sanitize_key($lang['slug']),
                'name' => sanitize_text_field($lang['name']),
                'url' => esc_url_raw($lang['url']),
                'current' => (bool) $lang['current_lang']
            );
        }

        // Get flag settings with validation
        $options = get_option('apls_settings', array());
        $flags = isset($options['language_flags']) ? $options['language_flags'] : $this->get_default_flags();

        // Sanitize all flags
        $sanitized_flags = array();
        foreach ($flags as $code => $flag) {
            $sanitized_flags[sanitize_key($code)] = APLS_Security::sanitize_flag($flag);
        }

        // SECURITY FIX: Use wp_add_inline_script instead of direct echo
        // This properly escapes and handles the JSON data
        $script = sprintf(
            'window.polylangTranslations = %s; window.aplsFlags = %s;',
            wp_json_encode($lang_data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
            wp_json_encode($sanitized_flags, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT)
        );

        wp_add_inline_script('apls-script', $script, 'before');
    }

    /**
     * Get default flag emojis
     */
    private function get_default_flags() {
        return array(
            'fr' => '🇫🇷',
            'en' => '🇬🇧',
            'de' => '🇩🇪',
            'es' => '🇪🇸',
            'pt' => '🇵🇹',
            'it' => '🇮🇹',
            'nl' => '🇳🇱',
        );
    }

    /**
     * Render shortcode
     * SECURITY: Properly sanitize all shortcode attributes
     */
    public function render_shortcode($atts) {
        $atts = shortcode_atts(array(
            'class' => ''
        ), $atts, 'a11ylang_language_switcher');

        // Additional sanitization via security helper
        if (class_exists('APLS_Security')) {
            $atts = APLS_Security::sanitize_shortcode_atts($atts);
        }

        ob_start();
        include APLS_PLUGIN_DIR . 'includes/template.php';
        return ob_get_clean();
    }
}

// Initialize plugin
function apls_init() {
    return Accessible_a11ylang_language_Switcher::get_instance();
}

// Start the plugin
apls_init();
