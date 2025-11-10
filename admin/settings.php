<?php
/**
 * Admin Settings Page
 */

if (!defined('ABSPATH')) {
    exit;
}

class APLS_Admin_Settings {

    public function __construct() {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    /**
     * Add settings page to admin menu
     */
    public function add_settings_page() {
        add_options_page(
            __('Language Switcher Settings', 'accessible-a11ylang-switcher'),
            __('Language Switcher', 'accessible-a11ylang-switcher'),
            'manage_options',
            'apls-settings',
            array($this, 'render_settings_page')
        );
    }

    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('apls_settings_group', 'apls_settings', array($this, 'sanitize_settings'));

        // General settings section
        add_settings_section(
            'apls_general_section',
            __('General Settings', 'accessible-a11ylang-switcher'),
            array($this, 'general_section_callback'),
            'apls-settings'
        );

        // Display mode
        add_settings_field(
            'apls_display_mode',
            __('Display Mode', 'accessible-a11ylang-switcher'),
            array($this, 'display_mode_callback'),
            'apls-settings',
            'apls_general_section'
        );

        // Debug mode
        add_settings_field(
            'apls_debug_mode',
            __('Debug Mode', 'accessible-a11ylang-switcher'),
            array($this, 'debug_mode_callback'),
            'apls-settings',
            'apls_general_section'
        );

        // Language flags section
        add_settings_section(
            'apls_flags_section',
            __('Language Flags', 'accessible-a11ylang-switcher'),
            array($this, 'flags_section_callback'),
            'apls-settings'
        );

        // Get Polylang languages
        if (function_exists('pll_languages_list')) {
            $languages = pll_languages_list();
            foreach ($languages as $lang) {
                add_settings_field(
                    'apls_flag_' . $lang,
                    sprintf(__('Flag for %s', 'accessible-a11ylang-switcher'), strtoupper($lang)),
                    array($this, 'flag_input_callback'),
                    'apls-settings',
                    'apls_flags_section',
                    array('lang' => $lang)
                );
            }
        }
    }

    /**
     * Sanitize settings
     * SECURITY: Added comprehensive validation, capability checks, and rate limiting
     */
    public function sanitize_settings($input) {
        // SECURITY: Verify user capabilities
        if (!current_user_can('manage_options')) {
            add_settings_error(
                'apls_messages',
                'apls_error',
                __('You do not have permission to update these settings.', 'accessible-a11ylang-switcher'),
                'error'
            );
            return get_option('apls_settings', array());
        }

        // SECURITY: Rate limiting to prevent abuse
        $user_id = get_current_user_id();
        if (class_exists('APLS_Security') && !APLS_Security::check_rate_limit($user_id)) {
            add_settings_error(
                'apls_messages',
                'apls_rate_limit',
                __('Settings updated too frequently. Please wait a moment and try again.', 'accessible-a11ylang-switcher'),
                'error'
            );
            return get_option('apls_settings', array());
        }

        $sanitized = array();

        // Sanitize display mode
        $valid_display_modes = array('flag_only', 'code_only', 'name_only', 'flag_and_name');
        $sanitized['display_mode'] = isset($input['display_mode']) && in_array($input['display_mode'], $valid_display_modes, true)
            ? $input['display_mode']
            : 'flag_and_name'; // Default

        // Sanitize debug mode
        $sanitized['debug_mode'] = isset($input['debug_mode']) ? (bool) $input['debug_mode'] : false;

        // Sanitize flags with strict validation
        if (isset($input['language_flags']) && is_array($input['language_flags'])) {
            $sanitized['language_flags'] = array();

            // Limit number of flags to prevent abuse
            $count = 0;
            $max_flags = 20;

            foreach ($input['language_flags'] as $lang => $flag) {
                if ($count >= $max_flags) {
                    break;
                }

                // Validate language code
                $lang_code = sanitize_key($lang);
                if (empty($lang_code) || strlen($lang_code) > 10) {
                    continue; // Skip invalid language codes
                }

                // Sanitize and validate flag using security helper
                if (class_exists('APLS_Security')) {
                    $sanitized_flag = APLS_Security::sanitize_flag($flag);
                    $sanitized['language_flags'][$lang_code] = $sanitized_flag;
                    $count++;
                }
            }
        }

        return $sanitized;
    }

    /**
     * Render settings page
     * SECURITY: Proper capability checks and nonce verification (handled by settings_fields)
     */
    public function render_settings_page() {
        // SECURITY: Check user capabilities first
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.', 'accessible-a11ylang-switcher'));
        }

        // Check if Polylang is active
        if (!function_exists('pll_the_languages')) {
            ?>
            <div class="wrap">
                <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
                <div class="notice notice-error">
                    <p><?php _e('Polylang plugin is required but not active.', 'accessible-a11ylang-switcher'); ?></p>
                </div>
            </div>
            <?php
            return;
        }

        // Show success message if settings saved
        if (isset($_GET['settings-updated'])) {
            add_settings_error('apls_messages', 'apls_message', __('Settings Saved', 'accessible-a11ylang-switcher'), 'updated');
        }

        settings_errors('apls_messages');
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

            <div class="apls-settings-header" style="background: #fff; padding: 20px; margin: 20px 0; border-left: 4px solid #2271b1;">
                <h2><?php _e('How to Use', 'accessible-a11ylang-switcher'); ?></h2>
                <p><?php _e('Add the language switcher to your site using one of these methods:', 'accessible-a11ylang-switcher'); ?></p>
                <ol>
                    <li><strong><?php _e('Shortcode:', 'accessible-a11ylang-switcher'); ?></strong> <code>[a11ylang_language_switcher]</code></li>
                    <li><strong><?php _e('PHP:', 'accessible-a11ylang-switcher'); ?></strong> <code>&lt;?php echo do_shortcode('[a11ylang_language_switcher]'); ?&gt;</code></li>
                    <li><strong><?php _e('Gutenberg:', 'accessible-a11ylang-switcher'); ?></strong> <?php _e('Add a "Shortcode" block with', 'accessible-a11ylang-switcher'); ?> <code>[a11ylang_language_switcher]</code></li>
                </ol>
            </div>

            <form action="options.php" method="post">
                <?php
                settings_fields('apls_settings_group');
                do_settings_sections('apls-settings');
                submit_button(__('Save Settings', 'accessible-a11ylang-switcher'));
                ?>
            </form>

            <div class="apls-info-box" style="background: #f0f0f1; padding: 20px; margin-top: 30px;">
                <h2><?php _e('Accessibility Features', 'accessible-a11ylang-switcher'); ?></h2>
                <ul>
                    <li>✅ <?php _e('Full keyboard navigation (Tab, Arrow keys, Enter, Escape)', 'accessible-a11ylang-switcher'); ?></li>
                    <li>✅ <?php _e('ARIA labels and roles for screen readers', 'accessible-a11ylang-switcher'); ?></li>
                    <li>✅ <?php _e('High contrast mode support', 'accessible-a11ylang-switcher'); ?></li>
                    <li>✅ <?php _e('Reduced motion support', 'accessible-a11ylang-switcher'); ?></li>
                    <li>✅ <?php _e('WCAG 2.1 AA compliant', 'accessible-a11ylang-switcher'); ?></li>
                </ul>

                <h2 style="margin-top: 20px;"><?php _e('How It Works', 'accessible-a11ylang-switcher'); ?></h2>
                <p><?php _e('This plugin uses Polylang\'s translation URLs directly, so it correctly handles translated page slugs:', 'accessible-a11ylang-switcher'); ?></p>
                <ul>
                    <li><?php _e('French:', 'accessible-a11ylang-switcher'); ?> <code>/services/</code></li>
                    <li><?php _e('German:', 'accessible-a11ylang-switcher'); ?> <code>/de/dienstleistungen/</code></li>
                    <li><?php _e('Spanish:', 'accessible-a11ylang-switcher'); ?> <code>/es/servicios/</code></li>
                </ul>
            </div>
        </div>
        <?php
    }

    /**
     * General section callback
     */
    public function general_section_callback() {
        echo '<p>' . __('Configure general plugin settings.', 'accessible-a11ylang-switcher') . '</p>';
    }

    /**
     * Flags section callback
     */
    public function flags_section_callback() {
        echo '<p>' . __('Customize flag emojis for each language. You can use flag emojis (🇫🇷, 🇬🇧, 🇩🇪) or text (FR, EN, DE).', 'accessible-a11ylang-switcher') . '</p>';
        ?>
        <div style="margin-top: 15px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 4px;">
            <button type="button"
                    onclick="this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'); document.getElementById('apls-customization-guide').style.display = this.getAttribute('aria-expanded') === 'true' ? 'block' : 'none';"
                    aria-expanded="false"
                    aria-controls="apls-customization-guide"
                    style="width: 100%; text-align: left; padding: 12px 15px; background: transparent; border: none; cursor: pointer; font-weight: 600; color: #2271b1;">
                <span style="display: inline-block; margin-right: 8px; transition: transform 0.2s;">▶</span>
                <?php _e('How to customize the language list', 'accessible-a11ylang-switcher'); ?>
            </button>
            <div id="apls-customization-guide" style="display: none; padding: 0 15px 15px 15px; border-top: 1px solid #ddd; margin-top: 0;">
                <h4 style="margin-top: 15px;"><?php _e('Customizing Language Flags', 'accessible-a11ylang-switcher'); ?></h4>
                <p><?php _e('The language list above is automatically generated based on the languages you\'ve configured in Polylang. To customize the flags:', 'accessible-a11ylang-switcher'); ?></p>
                <ol style="margin-left: 20px;">
                    <li><?php _e('Use the fields above to change the flag emoji or text for each language', 'accessible-a11ylang-switcher'); ?></li>
                    <li><?php _e('Click "Save Settings" to apply your changes', 'accessible-a11ylang-switcher'); ?></li>
                </ol>

                <h4 style="margin-top: 20px;"><?php _e('Adding or Removing Languages', 'accessible-a11ylang-switcher'); ?></h4>
                <p><?php _e('To add or remove languages from the switcher, you need to configure them in Polylang:', 'accessible-a11ylang-switcher'); ?></p>
                <ol style="margin-left: 20px;">
                    <li><?php _e('Go to <strong>Languages</strong> in your WordPress admin menu', 'accessible-a11ylang-switcher'); ?></li>
                    <li><?php _e('Add or remove languages as needed in Polylang', 'accessible-a11ylang-switcher'); ?></li>
                    <li><?php _e('Return to this settings page - new languages will appear automatically', 'accessible-a11ylang-switcher'); ?></li>
                </ol>

                <h4 style="margin-top: 20px;"><?php _e('Default Flag Emojis', 'accessible-a11ylang-switcher'); ?></h4>
                <p><?php _e('The plugin provides default flag emojis for 34 languages (including the 20 most commonly used languages worldwide, plus Luxembourgish and other European languages). These defaults are defined in the file:', 'accessible-a11ylang-switcher'); ?></p>
                <p><code style="background: #fff; padding: 4px 8px; border: 1px solid #ddd; border-radius: 3px;">admin/settings.php</code> <?php _e('(see the <code>get_default_flag()</code> function)', 'accessible-a11ylang-switcher'); ?></p>
                <p><?php _e('To change the default flags used for new languages:', 'accessible-a11ylang-switcher'); ?></p>
                <ol style="margin-left: 20px;">
                    <li><?php _e('Edit the <code>admin/settings.php</code> file', 'accessible-a11ylang-switcher'); ?></li>
                    <li><?php _e('Find the <code>get_default_flag()</code> method (around line 330)', 'accessible-a11ylang-switcher'); ?></li>
                    <li><?php _e('Add or modify the language codes and their corresponding flag emojis in the <code>$defaults</code> array', 'accessible-a11ylang-switcher'); ?></li>
                    <li><?php _e('Save the file', 'accessible-a11ylang-switcher'); ?></li>
                </ol>

                <h4 style="margin-top: 20px;"><?php _e('Screen Reader Accessibility', 'accessible-a11ylang-switcher'); ?></h4>
                <p style="color: #0a6e2f; background: #e8f5e9; padding: 10px; border-left: 3px solid #0a6e2f;">
                    <strong>✓ <?php _e('Verified:', 'accessible-a11ylang-switcher'); ?></strong>
                    <?php _e('Screen readers always announce the full language name (e.g., "Français", "English", "Deutsch"), even when the visual display shows only flags or language codes. This is achieved using visually-hidden text that is accessible to assistive technologies.', 'accessible-a11ylang-switcher'); ?>
                </p>
            </div>
        </div>
        <script>
        // Add rotation animation to arrow when expanded
        document.addEventListener('DOMContentLoaded', function() {
            var btn = document.querySelector('[aria-controls="apls-customization-guide"]');
            if (btn) {
                btn.addEventListener('click', function() {
                    var arrow = this.querySelector('span');
                    if (this.getAttribute('aria-expanded') === 'true') {
                        arrow.style.transform = 'rotate(90deg)';
                    } else {
                        arrow.style.transform = 'rotate(0deg)';
                    }
                });
            }
        });
        </script>
        <?php
    }

    /**
     * Display mode callback
     */
    public function display_mode_callback() {
        $options = get_option('apls_settings', array());
        $display_mode = isset($options['display_mode']) ? $options['display_mode'] : 'flag_and_name';
        ?>
        <fieldset>
            <label>
                <input type="radio" name="apls_settings[display_mode]" value="flag_only" <?php checked($display_mode, 'flag_only'); ?> />
                <strong><?php _e('Flag only', 'accessible-a11ylang-switcher'); ?></strong> (🇫🇷 🇬🇧 🇩🇪)
            </label>
            <br><br>
            <label>
                <input type="radio" name="apls_settings[display_mode]" value="code_only" <?php checked($display_mode, 'code_only'); ?> />
                <strong><?php _e('Language code only', 'accessible-a11ylang-switcher'); ?></strong> (FR EN DE)
            </label>
            <br><br>
            <label>
                <input type="radio" name="apls_settings[display_mode]" value="name_only" <?php checked($display_mode, 'name_only'); ?> />
                <strong><?php _e('Language name only', 'accessible-a11ylang-switcher'); ?></strong> (Français English Deutsch)
            </label>
            <br><br>
            <label>
                <input type="radio" name="apls_settings[display_mode]" value="flag_and_name" <?php checked($display_mode, 'flag_and_name'); ?> />
                <strong><?php _e('Flag and name', 'accessible-a11ylang-switcher'); ?></strong> (🇫🇷 Français 🇬🇧 English)
            </label>
        </fieldset>
        <p class="description">
            <?php _e('Note: Screen readers will always read the full language name for accessibility, regardless of this setting.', 'accessible-a11ylang-switcher'); ?>
        </p>
        <?php
    }

    /**
     * Debug mode callback
     */
    public function debug_mode_callback() {
        $options = get_option('apls_settings', array());
        $debug_mode = isset($options['debug_mode']) ? $options['debug_mode'] : false;
        ?>
        <label>
            <input type="checkbox" name="apls_settings[debug_mode]" value="1" <?php checked($debug_mode, true); ?> />
            <?php _e('Enable debug mode (outputs detailed console logs)', 'accessible-a11ylang-switcher'); ?>
        </label>
        <p class="description">
            <?php _e('When enabled, the language switcher will output detailed information to the browser console for troubleshooting.', 'accessible-a11ylang-switcher'); ?>
        </p>
        <?php
    }

    /**
     * Flag input callback
     */
    public function flag_input_callback($args) {
        $lang = $args['lang'];
        $options = get_option('apls_settings', array());
        $flags = isset($options['language_flags']) ? $options['language_flags'] : array();
        $value = isset($flags[$lang]) ? $flags[$lang] : $this->get_default_flag($lang);
        ?>
        <input
            type="text"
            name="apls_settings[language_flags][<?php echo esc_attr($lang); ?>]"
            value="<?php echo esc_attr($value); ?>"
            style="width: 100px;"
        />
        <span class="description"><?php echo sprintf(__('Current: %s', 'accessible-a11ylang-switcher'), $value); ?></span>
        <?php
    }

    /**
     * Get default flag for language
     * Includes 20 most commonly used languages + Luxembourgish
     */
    private function get_default_flag($lang) {
        $defaults = array(
            // Most commonly used languages (by number of speakers)
            'en' => '🇬🇧',  // English
            'zh' => '🇨🇳',  // Chinese (Mandarin)
            'hi' => '🇮🇳',  // Hindi
            'es' => '🇪🇸',  // Spanish
            'fr' => '🇫🇷',  // French
            'ar' => '🇸🇦',  // Arabic
            'bn' => '🇧🇩',  // Bengali
            'pt' => '🇵🇹',  // Portuguese
            'ru' => '🇷🇺',  // Russian
            'ur' => '🇵🇰',  // Urdu
            'id' => '🇮🇩',  // Indonesian
            'de' => '🇩🇪',  // German
            'ja' => '🇯🇵',  // Japanese
            'sw' => '🇰🇪',  // Swahili
            'mr' => '🇮🇳',  // Marathi
            'te' => '🇮🇳',  // Telugu
            'tr' => '🇹🇷',  // Turkish
            'ta' => '🇮🇳',  // Tamil
            'vi' => '🇻🇳',  // Vietnamese
            'ko' => '🇰🇷',  // Korean

            // Additional commonly used languages
            'it' => '🇮🇹',  // Italian
            'nl' => '🇳🇱',  // Dutch
            'pl' => '🇵🇱',  // Polish
            'uk' => '🇺🇦',  // Ukrainian
            'th' => '🇹🇭',  // Thai
            'sv' => '🇸🇪',  // Swedish
            'no' => '🇳🇴',  // Norwegian
            'da' => '🇩🇰',  // Danish
            'fi' => '🇫🇮',  // Finnish
            'el' => '🇬🇷',  // Greek
            'cs' => '🇨🇿',  // Czech
            'ro' => '🇷🇴',  // Romanian
            'hu' => '🇭🇺',  // Hungarian

            // Luxembourgish (special request)
            'lb' => '🇱🇺',  // Luxembourgish
        );
        return isset($defaults[$lang]) ? $defaults[$lang] : '🌐';
    }
}
