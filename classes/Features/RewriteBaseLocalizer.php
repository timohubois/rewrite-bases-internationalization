<?php

namespace RewriteBasesI18n\Features;

defined('ABSPATH') || exit;
class RewriteBaseLocalizer
{
    private const OPTION_PREFIX = 'rewrite-bases-internationalization_rewrite_bases_';
    private const NONCE_ACTION = 'rewrite-bases-internationalization_update_option';
    private const NONCE_NAME = 'rewrite-bases-internationalization_nonce';

    /**
     * Array of rewrite bases.
     *
     * The keys are the hardcoded rewrite bases from the WordPress core WP_Rewrite class.
     * The values are used as identifiers for the plugin options.
     *
     * @var array $bases Array of rewrite bases.
     */
    private array $bases = [
        'author' => 'author_base',
        'search' => 'search_base',
        'comments' => 'comments_base',
        'comment-page' => 'comment-page_base',
        'page' => 'pagination_base'
    ];

    private static ?self $instance = null;

    /**
     * Constructor: Set up WordPress hooks.
     */
    public function __construct()
    {
        add_action('init', [$this, 'updateRewriteBases']);
        add_action('load-options-permalink.php', [$this, 'registerSettings']);
    }

    /**
     * Initialize the class.
     */
    public static function init(): void
    {
        self::getInstance();
    }

    /**
     * Get the instance of the class.
     *
     * @return self The instance of the class.
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
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
            __('Rewrite Bases', 'rewrite-bases-internationalization'),
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
            $label,
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
        esc_html_e('Enter custom rewrite bases for author, search, comments and pagination.', 'rewrite-bases-internationalization');
        esc_html_e('Blank inputs will default to WordPress’s language-specific terms.', 'rewrite-bases-internationalization');
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

        if ($key === 'page') {
            echo '<code>' . esc_url(home_url('%postname%/')) . '</code>';
        } elseif ($key === 'author') {
            echo '<code>' . esc_url(home_url('/')) . '</code>';
        } elseif ($key === 'search') {
            echo '<code>' . esc_url(home_url('/')) . '</code>';
        } elseif ($key === 'comments') {
            echo '<code>' . esc_url(home_url('%postname%/')) . '</code>';
        } elseif ($key === 'comment-page') {
            echo '<code>' . esc_url(home_url('%postname%/')) . '</code>';
        } else {
            echo '<code>' . esc_url(home_url('/')) . '</code>';
        }

        echo '<input type="text" id="' . esc_attr($optionName) . '" name="' . esc_attr($optionName) . '" value="' . esc_attr($value) . '" placeholder="' . esc_attr($default['value']) . '">';

        if ($key === 'page') {
            echo '<code>/2/</code>';
        } elseif ($key === 'comment-page') {
            echo '<code>/2/</code>';
        } elseif ($key === 'author') {
            echo '<code>/%authorname%/</code>';
        } else {
            echo '<code>/</code>';
        }

        echo '<p class="description">';
        printf(
            // translators: 1: WordPress Core default value, 2: Internationalized value, 3: Internationalized value (translation), 4: Original value, 5: Translation source
            esc_html__('WordPress Core default value: %1$s | Internationalized %2$s: %3$s (Translation of: %4$s, Source: %5$s)', 'rewrite-bases-internationalization'),
            '<code>' . esc_html($default['native']) . '</code>',
            esc_html(get_locale()),
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

    public function deleteOptions(): void
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
            'comment-page' => ['Comment Page', __('Comment') . ' ' . _x('Page', 'post type singular name'), 'WordPress Core'],
            'page' => ['Page', _x('Page', 'post type singular name'), 'WordPress Core']
        ];

        $translated = $defaults[$key][1];
        $source = $defaults[$key][2];

        return [
            'value' => sanitize_title($translated),
            'original' => $translated,
            'native' => $key,
            'source' => $source
        ];
    }
}
