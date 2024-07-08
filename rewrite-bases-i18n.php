<?php

/**
 * Plugin Name:       Rewrite Bases Internationalization
 * Plugin URI:        https://github.com/timohubois/rewrite-bases-i18n/
 * Description:       Internationalization of rewrite bases for author, search, comments and pagination.
 * Version:           1.0
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            Timo Hubois
 * Author URI:        https://pixelsaft.wtf
 * Text Domain:       rewrite-bases-i18n
 * Domain Path:       /languages
 * License:           GPLv3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// phpcs:ignore PSR1.Classes.ClassDeclaration.MissingNamespace
class RewriteBasesI18n
{
    private const OPTION_PREFIX = 'rewrite-bases-i18n_rewrite_bases_';
    private const NONCE_ACTION = 'rewrite-bases-i18n_update_option';
    private const NONCE_NAME = 'rewrite-bases-i18n_nonce';

    private array $bases = [
        'author' => 'author_base',
        'search' => 'search_base',
        'comments' => 'comments_base',
        'pagination' => 'pagination_base'
    ];

    /**
     * Constructor: Set up WordPress hooks.
     */
    public function __construct()
    {
        add_action('init', [$this, 'updateRewriteBases']);
        add_action('load-options-permalink.php', [$this, 'registerSettings']);
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'addSettingsLink']);
    }

    /**
     * Activation hook callback.
     */
    public static function activate(): void
    {
        $instance = new self();
        $instance->updateRewriteBases();

        flush_rewrite_rules(true);
    }

    /**
     * Deactivation hook callback.
     */
    public static function deactivate(): void
    {
        flush_rewrite_rules(true);
    }

    public static function uninstall(): void
    {
        $instance = new self();
        $instance->deleteOptions();
        $instance->deactivate();
    }

    /**
     * Add settings link to plugin page.
     *
     * @param array $links Existing plugin action links.
     * @return array Modified plugin action links.
     */
    public function addSettingsLink(array $links): array
    {
        array_unshift($links, '<a href="options-permalink.php">' . __('Permalinks Settings', 'rewrite-bases-i18n') . '</a>');
        return $links;
    }

    /**
     * Update rewrite bases with custom or default values.
     */
    public function updateRewriteBases(): void
    {
        global $wp_rewrite;

        foreach ($this->bases as $key => $base) {
            $wp_rewrite->{$base} = $this->getOption($key) ?: $this->getDefaultValue($key)['value'];
        }
    }

    /**
     * Register settings and add settings fields.
     */
    public function registerSettings(): void
    {
        $this->handlePostRequests();

        add_settings_section(
            self::OPTION_PREFIX . 'rewrite_bases',
            __('Rewrite Bases', 'rewrite-bases-i18n'),
            [$this, 'renderSectionDescription'],
            'permalink'
        );

        foreach ($this->bases as $key => $base) {
            $this->registerSettingField($key);
        }
    }

    /**
     * Handle POST requests for updating options.
     */
    private function handlePostRequests(): void
    {
        // Check for valid POST request and validate nonce.
        if (!$this->isValidPostRequest()) {
            return;
        }

        foreach ($this->bases as $key => $base) {
            $optionName = self::OPTION_PREFIX . $key . '_base';
            // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce is verified in isValidPostRequest.
            if (isset($_POST[$optionName])) {
                // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce is verified in isValidPostRequest.
                $inputValue = sanitize_title(wp_unslash($_POST[$optionName]));

                if (empty($inputValue)) {
                    delete_option($optionName);
                    continue;
                }

                update_option($optionName, $inputValue);
            }
        }
    }

    /**
     * Check if the current POST request is valid.
     *
     * @return bool True if the request is valid, false otherwise.
     */
    private function isValidPostRequest(): bool
    {
        if (!isset($_POST[self::NONCE_NAME])) {
            return false;
        }

        $nonce = sanitize_text_field(wp_unslash($_POST[self::NONCE_NAME]));
        return wp_verify_nonce($nonce, self::NONCE_ACTION);
    }

    /**
     * Register a setting field for a specific rewrite base.
     *
     * @param string $key The key for the rewrite base.
     */
    private function registerSettingField(string $key): void
    {
        $optionName = self::OPTION_PREFIX . $key . '_base';
        $label = ucfirst($key) . ' Base';

        register_setting(
            'permalink',
            $optionName,
            ['type' => 'string', 'sanitize_callback' => 'sanitize_title']
        );

        add_settings_field(
            $optionName,
            __($label, 'rewrite-bases-i18n'),
            [$this, 'renderSettingField'],
            'permalink',
            self::OPTION_PREFIX . 'rewrite_bases',
            ['label_for' => $optionName, 'key' => $key]
        );
    }

    /**
     * Render the description for the settings section.
     */
    public function renderSectionDescription(): void
    {
        echo '<p>';
        esc_html_e('Enter custom rewrite bases for author, search, comments, and pagination.', 'rewrite-bases-i18n');
        echo ' ';
        esc_html_e('Blank inputs will default to WordPress’s language-specific terms.', 'rewrite-bases-i18n');
        echo ' ';
        printf(
            /* translators: %s: URL to wp_rewrite class documentation */
            wp_kses(
                __('For more information, see the <a href="%s">WordPress Rewrite API documentation</a>.', 'rewrite-bases-i18n'),
                ['a' => ['href' => []]]
            ),
            esc_url('https://developer.wordpress.org/reference/classes/wp_rewrite/')
        );
        echo '</p>';
    }

    /**
     * Render an individual setting field.
     *
     * @param array $args Arguments passed to the callback.
     */
    public function renderSettingField(array $args): void
    {
        wp_nonce_field(self::NONCE_ACTION, self::NONCE_NAME);

        $optionName = $args['label_for'];
        $key = $args['key'];
        $value = $this->getOption($key);
        $default = $this->getDefaultValue($key);

        if ($key === 'pagination') {
            echo '<code>' . esc_url(home_url('%postname%/')) . '</code>';
        } elseif ($key === 'author') {
            echo '<code>' . esc_url(home_url('/')) . '</code>';
        } elseif ($key === 'search') {
            echo '<code>' . esc_url(home_url('/')) . '</code>';
        } elseif ($key === 'comments') {
            echo '<code>' . esc_url(home_url('%postname%/')) . '</code>';
        } else {
            echo '<code>' . esc_url(home_url('/')) . '/</code>';
        }

        echo '<input type="text" id="' . esc_attr($optionName) . '" name="' . esc_attr($optionName) . '" value="' . esc_attr($value) . '" placeholder="' . esc_attr($default['value']) . '">';

        if ($key === 'pagination') {
            echo '<code>/2/</code>';
        } elseif ($key === 'author') {
            echo '<code>/%authorname%/</code>';
        } else {
            echo '<code>/</code>';
        }

        echo '<p class="description">';
        printf(
            esc_html__('WordPress Core default value: %1$s | Internationalized value: %2$s (Translation of: %3$s, Source: %4$s)', 'rewrite-bases-i18n'),
            '<code>' . esc_html($default['native']) . '</code>',
            '<code>' . esc_html($default['value']) . '</code>',
            '<code>' . esc_html($default['original']) . '</code>',
            '<strong>' . esc_html($default['source']) . '</strong>',
        );
        echo '</p>';
    }

    /**
     * Get the option value for a specific key.
     *
     * @param string $key The key for the option.
     * @return string|bool The option value or false if not set.
     */
    private function getOption(string $key): string|bool
    {
        $optionName = self::OPTION_PREFIX . $key . '_base';
        return get_option($optionName);
    }

    private function deleteOptions(): void
    {
        foreach ($this->bases as $key => $base) {
            delete_option(self::OPTION_PREFIX . $key . '_base');
        }
    }

    /**
     * Get the default value for a specific key.
     *
     * @param string $key The key for the default value.
     * @return array An array containing default value information.
     */
    private function getDefaultValue(string $key): array
    {
        $defaults = [
            'author' => ['Author', __('Author'), 'WordPress Core'],
            'search' => ['Search', __('Search'), 'WordPress Core'],
            'comments' => ['Comments', __('Comments'), 'WordPress Core'],
            'pagination' => ['Page', _x('Page', 'post type singular name'), 'WordPress Core']
        ];

        $translated = $defaults[$key][1];
        $source = $defaults[$key][2];

        return [
            'value' => remove_accents(mb_strtolower($translated)),
            'original' => $translated,
            'native' => $key,
            'source' => $source
        ];
    }
}

register_activation_hook(__FILE__, [RewriteBasesI18n::class, 'activate']);
register_deactivation_hook(__FILE__, [RewriteBasesI18n::class, 'deactivate']);

new RewriteBasesI18n();
